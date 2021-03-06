<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Consumers extends CI_Model {

	public function getAllConsumers(){
    return $this->db->get('consumers')->result();
	}

	public function searchConsumers($search){
    return $this->db->query("select * from consumers where account_number like '%$search%' or firstname like '%$search%' or middlename like '%$search%' or lastname like '%$search%'")->result();
	}
	
	public function getAllConnectedConsumers(){
    return $this->db->where('is_disconnected', 0)->get('consumers')->result();
  }

  public function storeConsumer($data){
		$this->db->insert('consumers', $data);
		$insertId = $this->db->insert_id();
		return $insertId;
	}

	public function getConsumerDetails($id){
		return $this->db->get_where('consumers', array('id'=>$id))->row();
	}

	public function updateConsumer($id, $data){
		$this->db->where('id', $id)->update('consumers', $data);
		return null;
	}

	public function getLatestAccountNumberGenerated(){
		return $this->db->order_by('account_number', 'desc')->get('consumers')->row();
	}
}
