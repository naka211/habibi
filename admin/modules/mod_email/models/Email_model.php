<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Email_model extends CI_Model{
	function __construct(){
        parent::__construct();
	}
	function getAllEmail($num=NULL,$offset=NULL,$search=NULL){
        if($search['name']){
            $where = "subject LIKE '%".$search['name']."%' OR content LIKE '%".$search['name']."%'";
            $this->db->where($where);
        }
		$this->db->order_by('id','DESC');
		$query = $this->db->get('email_template',$num,$offset)->result();
		return $query;
	}
	function getNumEmail($search=NULL){
        if($search['name']){
            $where = "subject LIKE '%".$search['name']."%' OR content LIKE '%".$search['name']."%'";
            $this->db->where($where);
        }
        $query = $this->db->get('email_template')->num_rows();
		return $query;
	}
	function saveEmail($data=NULL,$id=NULL){
        if($id){
            $this->db->where('id',$id);
            $this->db->update('email_template',$data);
            return $id;
        }else{
            if($this->db->insert('email_template',$data)){
                return $this->db->insert_id();
            }else{
                return false;
            }
        }
	}
	function getEmailByID($id=NULL){
		 $query = $this->db->where('id',$id)->get('email_template')->row();
		 return $query;
	}
	function delete($id=NULL){
		$this->db->where('id',$id);
        if($this->db->delete('email_template')){
            return true;
        }else{
            return false;
        }
	}
}
?>