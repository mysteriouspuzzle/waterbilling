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
		$data['consumers'] = $this->consumers->getAllConsumers();
		$this->load->view('teller/viewconsumers', $data);
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
		}
		$this->session->set_flashdata('success','Payment success!');
		$this->load->view('teller/receipt', $data);
	}
}
