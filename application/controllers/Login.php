<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('credentials');
		$this->load->model('codes');
		$this->load->model('bills');
		$this->load->view('layout/header');
		$this->load->view('PHPMailerAutoload');
		$this->load->model('smsapi');
		if(isset($_SESSION['wbUserID'])){
			if($_SESSION['wbUserLevel']=='Teller'){
				redirect('teller/');
			}elseif($_SESSION['wbUserLevel']=='Accounting'){
				redirect('accounting/');
			}
		}
	}
	public function index(){
		$this->load->view('login');
		$this->notifydueconsumers();
	}
	public function login(){
		$u = $this->input->post('username');
		$p = $this->input->post('password');
		$p = md5($p);
		$user = $this->credentials->checkUserCredential($u, $p);
		$count = count($user);
		if($count==0){
			$this->session->set_flashdata('error','Invalid Credentials.');
			redirect('./');
		}else{
			$_SESSION['wbUserID'] =$user->id;
			$_SESSION['wbUserLevel'] =$user->userLevel;
			$_SESSION['wbUser'] =$user->fullname;
			if($_SESSION['wbUserLevel']=='Teller'){
				redirect('teller/');
			}elseif($_SESSION['wbUserLevel']=='Reader'){
				redirect('reader/');
			}elseif($_SESSION['wbUserLevel']=='Accounting'){
				redirect('accounting/');
			}
		}
	}
	public function email(){
		$this->load->view('email');
	}
	public function checkemail(){
		$email = $this->input->get('email');
		$check = $this->db->query("select * from credentials where email = '$email'")->num_rows();
		if($check == 1){
			$user = $this->db->query("select * from credentials where email = '$email'")->row();
			$id = $user->id;
			$this->db->query("update codes set status = 'Expired' where pass_id = '$id'");
			$code = sprintf("%06d", mt_rand(1, 999999));

			$user = $this->db->query("select * from credentials where email = '$email'")->row();
			$this->db->query("update codes set status = 'Expired' where pass_id = '$user->id'");
			$_SESSION['fp'] = $user->id;
			$data = array(
				'pass_id'=>$user->id,
				'code'=>$code,
				'status'=>'Pending'
			);
			$this->codes->addCode($data);
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

			$mail->setFrom($user->email, 'Water Billing System');
			$mail->addAddress($user->email, $user->fullName);     // Add a recipient
			$mail->addReplyTo('iamstevenjamesb@gmail.com', 'Information');

			$mail->isHTML(true);                                  // Set email format to HTML

			$mail->Subject = 'Your Password Recovery Code';
			$mail->Body    = 'Please input code '. $code .' for you to recover your password.';
			$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

			if(!$mail->send()) {
			    echo 'Message could not be sent.';
			    echo 'Mailer Error: ' . $mail->ErrorInfo;
			    echo "<script>alert('Please check your internet connection.')</script>";
					redirect('login/email');
			} else {
			    redirect('login/code');
			}
			redirect('login/code');
		}else{
			$this->session->set_flashdata('error', 'Invalid email address.');
			redirect('login/email');
		}
	}
	public function code(){
		$this->load->view('code');
	}
	public function checkcode(){
		$code = $this->input->get('code');
		$id = $_SESSION['fp'];
		$check = $this->db->query("select * from codes where code = '$code' and pass_id = '$id' and status = 'Pending'")->num_rows();
		if($check == 1){
			redirect('login/newpass');
		}else{
			$this->session->set_flashdata('error', 'Invalid code.');
			redirect('login/code');
		}
	}
	public function newpass(){
		$this->load->view('newpass');
	}
	public function createnewpass(){
		$pass = $this->input->get('pass');
		$cpass = $this->input->get('cpass');
		if($pass == $cpass){
			$pass = md5($pass);
			$id = $_SESSION['fp'];
			$this->db->query("update credentials set password = '$pass' where id = '$id'");
			unset($_SESSION['fp']); 
			redirect('login');
		}else{
			$this->session->set_flashdata('error', 'Password does not match.');
			redirect('login/newpass');
		}
	}

	function notifydueconsumers(){
		$consumers = $this->bills->getUnsentDueConsumers();
		if(count($consumers) > 0) {
			$this->sendDueEmail($consumers);
			$this->sendDueSms($consumers);
		}
		$consumers = $this->bills->getUnsentDiscoConsumers();
		if(count($consumers) > 0) {
			$this->sendDiscoSms($consumers);
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

	function Disco($consumers){
		foreach($consumers as $consumer){
			$api = $this->smsapi->getEndpoint();
			$msg = "Hi $consumer->firstname $consumer->lastname, this is Ormoc Waterworks Water Billing. Your account number $consumer->account_number has a disconnection notice. For more details check your email.";
			$check = $this->smsapi->sendSms($api->endpoint, $consumer->contactNumber, $msg);
			if($check == true){
				$this->session->set_flashdata('success','SMS and Email succcessfully sent!');
			}else{
				$this->session->set_flashdata('error','Update your SMS API endpoint or check your connection.');
			}
		}
	}

	function sendDueSms($consumers){
		foreach($consumers as $consumer){
			$api = $this->smsapi->getEndpoint();
			$msg = "Hi $consumer->firstname $consumer->lastname, this is Ormoc Waterworks Water Billing. Your account number $consumer->account_number has a due date amount of $consumer->bill. For more details check your email.";
			$check = $this->smsapi->sendSms($api->endpoint, $consumer->contactNumber, $msg);
			if($check == true){
				$this->session->set_flashdata('success','SMS and Email succcessfully sent!');
			}else{
				$this->session->set_flashdata('error','Update your SMS API endpoint or check your connection.');
			}
		}
	}

	function sendDiscoSms($consumers){
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
}
