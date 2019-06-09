<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reader extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('consumers');
		$this->load->model('rates');
		$this->load->model('smsapi');
		$this->load->model('bills');
		$this->load->model('credentials');
		$this->load->view('layout/header');
		if(!isset($_SESSION['wbUserID'])){
			redirect('./');
		}
	}
	public function index(){
		$this->load->view('reader/dashboard');
	}
	public function logout(){
		session_destroy();
		redirect('./');
	}
	public function viewconsumers(){
		$data['consumers'] = $this->consumers->getAllConsumers();
		$this->load->view('reader/viewconsumers', $data);
	}
	public function readmeter($consumer_id){
		$data['id'] = $consumer_id;
		$data['current_meter'] = $this->input->post('current_meter');
		$count_prev_meter = $this->bills->countPreviousMeterReading($consumer_id);
		if($count_prev_meter == 0) {
			$data['prev_meter'] = "0000";
		}else{
			// $count = $this->bills->countPreviousMeterReading($consumer_id);
			$result = $this->bills->getPreviousMeterReading($consumer_id);
			$data['prev_meter'] = str_pad($result->present_meter, 4, '0', STR_PAD_LEFT);
		}	
		$data['consumer'] = $this->consumers->getConsumerDetails($consumer_id);
		$diff = $data['current_meter'] - $data['prev_meter'];
		if($diff >= 0){
			$rate = $this->rates->getRateByDiff($diff);
			if($rate->minimum ==0){	
				$data['bill'] = $rate->rate;
			}else{
				$rates = $this->rates->getRates();
				foreach($rates as $rate){
					if($rate->minimum == 0){
						$newDiff = $rate->rate;
						$tmpMaxCubicMeter = $rate->maximum;
					}elseif($rate->minimum != 0){
						if($diff > $rate->maximum){
							$newDiff = ($rate->rate * ($rate->maximum - $tmpMaxCubicMeter)) + $newDiff;
							$tmpMaxCubicMeter = $rate->maximum;
						}elseif($rate->minimum <= $diff and $rate->maximum >= $diff){
							$newDiff = ($rate->rate * ($diff - $tmpMaxCubicMeter)) + $newDiff;
						}
					}
				}
				$data['bill'] = $newDiff;
			}
			unset($_SESSION['error']);
		}else{
			if($data['current_meter']!==null){
				$this->session->set_flashdata('error','Invalid input.');
			}
		}
		
		$this->load->view('reader/readmeter', $data);
	}
	public function sendbill($id) {
		$consumer = $this->consumers->getConsumerDetails($id);
		$checkNewConsumer = $this->bills->countPreviousMeterReading($id);
		if($checkNewConsumer == 0){
			$prev_date = $consumer->date_added;
		}else{
			$tempdate = $this->bills->getPreviousMeterReading($id);
			$prev_date = $tempdate->present_date;
		}
		$data = array(
			'consumer_id'=>$id,
			'previous_date'=>$prev_date,
			'present_date'=>date('Y-m-d'),
			'previous_meter'=>$this->input->post('prev_meter'),
			'present_meter'=>$this->input->post('current_meter'),
			'bill'=>$this->input->post('bill'),
			'consumption'=>$this->input->post('consumption'),
			'due_date'=>date('Y-m-d', strtotime(date('Y-m-d'). ' + 14 days')),
			'status'=>'Unpaid',
			'notification'=>'Unsent',
			'due_notif'=>'Unsent',
		);
		$tId = $this->bills->saveTransaction($data);
		$details = $this->bills->getBillDetails($tId);
		$this->sendEmail($consumer, $details, $tId);
		$this->sendSms($consumer, $details, $tId);
		$this->session->set_flashdata('success','SMS and email successfully sent to consumer.');
		redirect('reader/readmeter/'.$id);
	}
	function sendEmail($consumer, $details, $tId){
		$this->load->view('PHPMailerAutoload');
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

		$mail->Subject = 'Water Billing System Receipt';
		$data['details'] = $details;
		$data['tid'] = $tId;
		$data['consumer'] = $consumer;
		$rId = $_SESSION['wbUserID'];
		$data['reader'] = $this->credentials->getAccountDetails($rId);
		$msg = $this->load->view('reader/email',$data,true);
		$mail->Body    = $msg;
		$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

		if(!$mail->send()) {
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			mail($consumer->email,"Water Billing System Receipt",$msg, $headers);
		}
	}
	function sendSms($consumer, $details, $tId){
		$api = $this->smsapi->getEndpoint();
		$msg = "Your account number $consumer->account_number has a bill amount of for P$details->bill from $details->previous_date to $details->present_date. For more details check your email.";
		$check = $this->smsapi->sendSms($api->endpoint, $consumer->contactNumber, $msg);
		if($check == true){
			$this->session->set_flashdata('success','SMS and Email succcessfully sent!');
		}else{
			$this->session->set_flashdata('error','Update your SMS API endpoint or check your connection.');
		}
	}
	public function email(){
		$consumer = $this->consumers->getConsumerDetails(3);
		$bill = array(
			'current_date'=>date('Y-m-d'),
			'prev_meter'=>$this->input->post('prev_meter'),
			'current_meter'=>$this->input->post('current_meter'),
			'bill'=>$this->input->post('bill'),
			'consumption'=>$this->input->post('consumption')
		);
		$data = array(
			'consumer_id'=>3,
			'previous_date'=>date('Y-m-d'),
			'present_date'=>date('Y-m-d'),
			'previous_meter'=>$this->input->post('prev_meter'),
			'present_meter'=>$this->input->post('current_meter'),
			'bill'=>$this->input->post('bill'),
			'consumption'=>$this->input->post('consumption'),
			'due_date'=>date('Y-m-d', strtotime(date('Y-m-d'). ' + 14 days')),
			'status'=>'Unpaid'
		);
		$rId = $_SESSION['wbUserID'];
		$data['reader'] = $this->credentials->getAccountDetails($rId);
		$details = $this->bills->getBillDetails(6);
		$data['details'] = $details;
		$data['tid'] = 6;
		$data['consumer'] = $consumer;
		$this->load->view('reader/email', $data);
	}

	public function qrscanner(){
		$this->load->view('reader/qrscanner');
	}
}
