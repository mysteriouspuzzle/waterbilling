<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bills extends CI_Model {

  public function paidBill($bill_id){
    $data = array(
      'status' => 'Paid'
    );
    $this->db->where('bill_id', $bill_id)->update('bills', $data);
    return null;
  }
  public function getBillDetails($bill_id){
    return $this->db->get_where('bills',array('bill_id'=>$bill_id))->row();
  }
  public function saveTransaction($data){
    $this->db->insert('bills', $data);
    $insertId = $this->db->insert_id();
    return $insertId;
  }
  public function countPreviousMeterReading($consumer_id){
    return $this->db->get_where('bills', array('consumer_id'=>$consumer_id))->num_rows();
  }
  public function getPreviousMeterReading($consumer_id){
    return $this->db->order_by('bill_id', 'desc')->get_where('bills', array('consumer_id'=>$consumer_id))->row();
  }

  public function getConsumerRecords($id){
    return $this->db->order_by('bill_id', 'desc')->get_where('bills', array('consumer_id'=>$id))->result();
  }

  public function getConsumerBills($id){
    return $this->db->order_by('bill_id', 'desc')->get_where('bills', array('consumer_id'=>$id, 'status'=>'Unpaid'))->result();
  }

  public function updateBillDetails($id,$billupdate){
    $this->db->where('bill_id', $id)->update('bills', $billupdate);
		return null;
  }

  public function getPaidBills(){
    return $this->db->order_by('bill_id', 'desc')->get_where('bills', array('status'=>'Paid'))->result();
  }

  public function getDiscoConsumers(){
		return $this->db->query("SELECT * FROM bills b, consumers c WHERE b.due_date < (NOW() - INTERVAL 3 MONTH) and b.status = 'Unpaid' and b.consumer_id = c.id order by b.notification desc")->result();
  }

  public function getDueConsumers(){
		return $this->db->query("SELECT * FROM bills b, consumers c WHERE b.due_date < (NOW() - INTERVAL 3 MONTH) and b.status = 'Unpaid' and b.consumer_id = c.id order by b.notification desc")->result();
  }
  
  public function getUnsentDiscoConsumers(){
		return $this->db->query("SELECT * FROM bills b, consumers c WHERE b.due_date < (NOW() - INTERVAL 3 MONTH) and b.status = 'Unpaid' and b.consumer_id = c.id and b.notification = 'Unsent' order by b.notification desc")->result();
	}
}
