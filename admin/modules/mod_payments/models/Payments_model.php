<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Payments_model extends CI_Model{
	function __construct(){
        parent::__construct();
	}
	function getAllPayments($num=NULL,$offset=NULL,$search=NULL){
        $this->db->select("pl.*, u.name, u.paymenttime")
            ->from("payment_log as pl")
            ->join("user as u", "pl.userId = u.id")
            ->order_by('id','DESC');
        if($search['name']){
            $where = "u.name LIKE '%".$search['name']."%'";
            $this->db->where($where);
        }
        $result = $this->db->get()->result();
		return $result;
	}

	function getNumPayments($search=NULL){
        $this->db->select('pl.id')
            ->from('payment_log as pl')
            ->join("user as u", "pl.userId = u.id");
        if($search['name']){
            $where = "u.name LIKE '%".$search['name']."%'";
            $this->db->where($where);
        }
        $query = $this->db->get()->num_rows();
		return $query;
	}

	function delete($id=NULL){
		$this->db->where('id',$id);
        if($this->db->delete('payment_log')){
            return true;
        }else{
            return false;
        }
	}
}
?>