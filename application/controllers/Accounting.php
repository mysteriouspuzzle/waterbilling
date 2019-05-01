<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accounting extends CI_Controller {

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
		$this->load->view('accounting/dashboard');
	}
	public function logout(){
		session_destroy();
		redirect('./');
	}

	public function disco(){
		$data['consumers'] = $this->bills->getDiscoConsumers();
		$this->load->view('accounting/disconnection', $data);
	}

	public function sales(){
		// $data['sales'] = $this->db->query("select c.account_number, c.firstname, c.lastname, c.classification, b.bill, b.payment_type, b.payment_date from consumers c, bills b where c.id = b.consumer_id and b.status = 'Paid'")->result();
		$this->load->view('accounting/sales', $data);
	}
}
