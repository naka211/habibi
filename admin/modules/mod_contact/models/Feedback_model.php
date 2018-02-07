<?php
class Feedback_model extends CI_Model{

	function __construct()
    {
        parent::__construct();
	}
	function get_all_feedback($num,$offset)
	{
		$this->db->where('bl_active !=', -1);
		$this->db->order_by('feedback_id','DESC');
		return $this->db->get('fm_feedback',$num,$offset)->result();
	}
	
	function get_num_feedback()
	{
		$this->db->where('bl_active !=', -1);
		return $this->db->get('fm_feedback')->num_rows();          
	}
	
	function save_feedback($data)
	{
		 $id = (int)$this->uri->segment(3);
		 if($id != 0){
			  $this->db->where('feedback_id',$id);
			  if($this->db->update('fm_feedback',$data)){
					return true;
			  }else{
					return false;
			  }
		 }else{

			  if($this->db->insert('fm_feedback',$data)){
					return true;
			  }else{
					return false;
			  }
		 }          
	}
	
	function get_feedback($id=0)
	{
		 $this->db->where('feedback_id',$id);
		 return $this->db->get('fm_feedback')->row();
	}
	
	function del_feedback($id)
	{
		$data['bl_active'] = -1 ;
		$data['feedback_dt_create'] = date("Y-m-d H:i:s") ;
		$this->db->where('feedback_id', $id);
		if($this->db->update('fm_feedback', $data)){
			return true;
		}else{
			return false;
		}
	}
	
	function remove()
	{
		$date = new DateTime();
		$date->modify('-3 month');
		$date_del = $date->format('Y-m-d H:i:s');
		
		$this->db->where('bl_active', -1);
		$this->db->where('feedback_dt_create <', $date_del);
		if($this->db->delete('fm_feedback')){
		  	return true;
		}else{
		  	return false;
		}
	}
}
