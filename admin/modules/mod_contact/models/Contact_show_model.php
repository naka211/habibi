<?php

class Contact_Show_Model extends CI_Model{

	function __construct()
    {
        parent::__construct();
	}
	
	function getShowContactPaging($num,$offset)
	{
		$this->db->order_by('show_letter_id','DESC');
		$query = $this->db->get('fm_show_letter',$num,$offset);
        if($query->num_rows()>0){
          return $query->result();
        }else{
          return false;
        }
	}
	
	function getNumShowContact()
	{
		return $this->db->get('fm_show_letter')->num_rows();          
	}
	
	function getShowContact($id=0){
		 $this->db->where('show_letter_id',$id);
		 $query = $this->db->get('fm_show_letter');
         if($query->num_rows()>0){
           return $query->row();
         }else{
           return false;
         }
	}
	
	function del($id){
		$this->db->where('show_letter_id', $id);
		if($this->db->delete('fm_show_letter')){
		  	return true;
		}else{
		  	return false;
		}
	}
}
