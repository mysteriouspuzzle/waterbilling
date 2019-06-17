<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Teller extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('consumers');
		$this->load->model('reading');
		$this->load->model('bills');
		$this->load->model('credentials');
		$this->load->view('layout/header');
		if(!isset($_SESSION['wbUserID'])){
			redirect('./');
		}
	}
	public function index(){
		$this->load->view('teller/dashboard');
	}
	public function logout(){
		session_destroy();
		redirect('./');
	}

	public function viewconsumers(){
		if(isset($_GET['search'])){
			$search = $_GET['search'];
			// $data['consumers'] = $this->consumers->getAllConsumers();
			$data['consumers'] = $this->consumers->searchConsumers($search);
			$this->load->view('teller/viewconsumers', $data);
		}else{
			$this->load->view('teller/viewconsumers');
		}
	}

	public function records($id){
		$data['records'] = $this->bills->getConsumerRecords($id);
		$this->load->view('teller/records', $data);
	}

	public function paymentdetails($id){
		$data['records'] = $this->bills->getConsumerBills($id);
		$data['consumer_id'] = $id;
		$this->load->view('teller/paymentdetails', $data);
	}

	public function receipt($id){
		$data['hcash'] = $this->input->post('hcash');
		$data['hchange'] = $this->input->post('hchange');
		$data['records'] = $this->bills->getConsumerBills($id);
		$data['consumer'] = $this->consumers->getConsumerDetails($id);
		$data['teller'] = $this->credentials->getAccountDetails($_SESSION['wbUserID']);
		$billIds = $this->input->post('billids');
		$billupdate = array(
			'status'=>'Paid',
			'payment_type'=>'walk-in',
			'payment_date'=>date('Y-m-d')
		);
		foreach($billIds as $billId){
			$this->bills->updateBillDetails($billId, $billupdate);
			$billDetails = $this->bills->getBillDetails($billId);
			$consumer = $this->consumers->getConsumerDetails($billDetails->consumer_id);
			$this->sendEmail($consumer, $billDetails);
		}
		$this->session->set_flashdata('success','Payment success!');
		$this->load->view('teller/receipt', $data);
	}

	function sendEmail($consumer, $billDetails){
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
		$data['prev_date'] = $billDetails->previous_date;
		$data['curr_date'] = $billDetails->present_date;
		$data['current_meter'] = $billDetails->present_meter;
		$data['prev_meter'] = $billDetails->previous_meter;
		$data['bill'] = $billDetails->bill;
		$msg = $this->load->view('paypal/receipt-email',$data,true);
		$mail->Body    = $msg;
		$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

		if(!$mail->send()) {
				echo 'Message could not be sent.';
				echo 'Mailer Error: ' . $mail->ErrorInfo;
				echo "<script>alert('Please check your internet connection.')</script>";
				// redirect('reader/readmeter/'.$consumer->id);
		}
	}
}
