<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accounting extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('consumers');
		$this->load->model('reading');
		$this->load->model('bills');
		$this->load->model('credentials');
		$this->load->model('smsapi');
		$this->load->view('layout/header');
		if(!isset($_SESSION['wbUserID'])){
			redirect('./');
		}
		$this->load->view('PHPMailerAutoload');
	}
	public function index(){
		$this->load->view('accounting/dashboard');
	}
	public function logout(){
		session_destroy();
		redirect('./');
	}

	public function disco(){
		$data['disco'] = $this->bills->getDiscoConsumers();
		$this->load->view('accounting/disconnection', $data);
	}

	public function recon(){
		$data['disco'] = $this->bills->getDisconnectedConsumers();
		$this->load->view('accounting/reconnection', $data);
	}

	public function due(){
		$data['due'] = $this->bills->getDueConsumers();
		$this->load->view('accounting/duedate', $data);
	}

	public function sales(){
		$data['sales'] = $this->db->query("select c.account_number, c.firstname, c.lastname, c.classification, b.bill, b.payment_type, b.payment_date, b.status from consumers c, bills b where c.id = b.consumer_id and b.payment_type != '' order by bill_id desc")->result();
		$this->load->view('accounting/sales', $data);
	}

	public function walkinsales(){
		$data['sales'] = $this->db->query("select c.account_number, c.firstname, c.lastname, c.classification, b.bill, b.payment_type, b.payment_date, b.status from consumers c, bills b where c.id = b.consumer_id and b.payment_type = 'walk-in' order by bill_id desc")->result();
		$this->load->view('accounting/walk-in-sales', $data);
	}

	public function onlinesales(){
		$data['sales'] = $this->db->query("select c.account_number, c.firstname, c.lastname, c.classification, b.bill, b.payment_type, b.payment_date, b.status from consumers c, bills b where c.id = b.consumer_id and b.payment_type = 'online' order by bill_id desc")->result();
		$this->load->view('accounting/online-sales', $data);
	}

	function sendEmail($consumers){
		foreach($consumers as $consumer){
			$mail = new PHPMailer;

			// $mail->SMTPDebug = 4;                               // Enable verbose debug output

			$mail->isSMTP();                                      // Set mailer to use SMTP
			$mail->Host = 'ssl://smtp.gmail.com:465';  // Specify main and backup SMTP servers
			$mail->SMTPAuth = true;                               // Enable SMTP authentication
			$mail->Username = 'iamstevenjamesb@gmail.com';                 // SMTP username
			$mail->Password = 'March181999';                           // SMTP password
			$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
			// $mail->Port = 465;                                    // TCP port to connect to

			$mail->setFrom($consumer->email, 'Water Billing System');
			$mail->addAddress($consumer->email, $consumer->firstname . ' ' . $consumer->lastname);     // Add a recipient
			$mail->addReplyTo('iamstevenjamesb@gmail.com', 'Information');

			$mail->isHTML(true);                                  // Set email format to HTML
			$data['consumer'] = $consumer;
			$consumerbills = $this->bills->getConsumerBills($consumer->consumer_id);
			$total_bill = 0;
			for($x = 0; $x < count($consumerbills); $x++){
				if($x==0){
					$dateTo = $consumerbills[$x]->present_date;
				}
				if($x==count($consumerbills)-1){
					$dateFrom = $consumerbills[$x]->previous_date;
				}
				$total_bill += $consumerbills[$x]->bill;
			}
			$data['total_bill'] = $total_bill;
			$data['dateTo'] = $dateTo;
			$data['dateFrom'] = $dateFrom;
			$mail->Subject = 'Water Billing System Disconnection Notice';
			$msg = $this->load->view('accounting/email',$data,true);
			$mail->Body    = $msg;
			$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

			if(!$mail->send()) {
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
						
						mail($consumer->email,"Water Billing System Disconnection Notice",$msg, $headers);
				$data = array(
					'notification'=>'Sent'
				);
				$this->bills->updateBillDetails($consumer->bill_id, $data);
			}else{
				$data = array(
					'notification'=>'Sent'
				);
				$this->bills->updateBillDetails($consumer->bill_id, $data);
			}
		}
	}

	function sendDueEmail($consumers){
		foreach($consumers as $consumer){
			$mail = new PHPMailer;

			// $mail->SMTPDebug = 4;                               // Enable verbose debug output

			$mail->isSMTP();                                      // Set mailer to use SMTP
			$mail->Host = 'ssl://smtp.gmail.com:465';  // Specify main and backup SMTP servers
			$mail->SMTPAuth = true;                               // Enable SMTP authentication
			$mail->Username = 'iamstevenjamesb@gmail.com';                 // SMTP username
			$mail->Password = 'March181999';                           // SMTP password
			$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
			// $mail->Port = 465;                                    // TCP port to connect to

			$mail->setFrom($consumer->email, 'Water Billing System');
			$mail->addAddress($consumer->email, $consumer->firstname . ' ' . $consumer->lastname);     // Add a recipient
			$mail->addReplyTo('iamstevenjamesb@gmail.com', 'Information');

			$mail->isHTML(true);                                  // Set email format to HTML
			$data['consumer'] = $consumer;
			$mail->Subject = 'Water Billing System Due Date Notice';
			$msg = $this->load->view('accounting/due-email',$data,true);
			$mail->Body    = $msg;
			$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

			if(!$mail->send()) {
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
						
						mail($consumer->email,"Water Billing System Due Date Notice",$msg, $headers);
				$data = array(
					'due_notif'=>'Sent'
				);
				$this->bills->updateBillDetails($consumer->bill_id, $data);
			}else{
				$data = array(
					'due_notif'=>'Sent'
				);
				$this->bills->updateBillDetails($consumer->bill_id, $data);
			}
		}
	}

	function sendSms($consumers){
		foreach($consumers as $consumer){
			$api = $this->smsapi->getEndpoint();
			$msg = "Hi $consumer->firstname $consumer->lastname, this is Ormoc Waterworks Water Billing. Your account number $consumer->account_number has a disconnection notice. For more details check your email.";
			$check = $this->smsapi->sendSms($api->endpoint, $consumer->contactNumber, $msg);
			if($check == true){
				$data = array(
					'notification'=>'Sent'
				);
				$this->bills->updateBillDetails($consumer->bill_id, $data);
				$this->session->set_flashdata('success','SMS and Email succcessfully sent!');
			}else{
				$this->session->set_flashdata('error','Update your SMS API endpoint or check your connection.');
			}
		}
	}

	function sendDueSms($consumers){
		foreach($consumers as $consumer){
			$api = $this->smsapi->getEndpoint();	
			$msg = "Hi $consumer->firstname $consumer->lastname, this is Ormoc Waterworks Water Billing. Your account number $consumer->account_number has a due date amount of P$consumer->bill. For more details check your email.";
			$check = $this->smsapi->sendSms($api->endpoint, $consumer->contactNumber, $msg);
			if($check == true){
				$this->session->set_flashdata('success','SMS and Email succcessfully sent!');
			}else{
				$this->session->set_flashdata('error','Update your SMS API endpoint or check your connection.');
			}
		}
	}

	public function notifydiscoconsumers(){
		$consumers = $this->bills->getUnsentDiscoConsumers();
		$this->sendEmail($consumers);
		$this->sendSms($consumers);
		redirect('accounting/disco');
	}

	public function notifydueconsumers(){
		$consumers = $this->bills->getUnsentDueConsumers();
		$this->sendDueEmail($consumers);
		$this->sendDueSms($consumers);
		redirect('accounting/due');
	}

	public function disconnect($id) {
		$this->db->query("update consumers set is_disconnected = '1' where id = $id");
		redirect('accounting/disco');
	}

	public function reconnect($id) {
		$this->db->query("update consumers set is_disconnected = '0' where id = $id");
		$prev_reading = $this->reading->getPreviousMeterReading($id);
		$data = array(
			'consumer_id' => $id,
			'previous_date' => $prev_reading->previous_date,
			'present_date' => $prev_reading->present_date,
			'previous_meter' => $prev_reading->previous_meter,
			'present_meter' => $prev_reading->present_meter,
			'consumption' => $prev_reading->consumption,
			'bill' => '70.00',
			'date' => date('Y-m-d'),
			'due_date' => date('Y-m-d'),
			'status' => 'Paid',
			'notification' => 'Unsent',
			'due_notif' => 'Unsent'
		);
		$this->bills->saveTransaction($data);
		redirect('accounting/recon');
	}
}
