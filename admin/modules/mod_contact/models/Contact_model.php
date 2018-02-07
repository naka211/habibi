<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Contact_model extends CI_Model{
	public $language = "";
    function __construct(){
        parent::__construct();
	}
	function init($lang){
        $this->language = $lang;
    }
	function getAllContact($num=NULL,$offset=NULL,$search=NULL){
		if($search['name']){
            $where = "name LIKE '%".$search['name']."%' OR besked LIKE '%".$search['name']."%'";
            $this->db->where($where);
        }
		$this->db->order_by('id','DESC');
		$query = $this->db->get('contact',$num,$offset)->result();
		return $query;
	}
	function getNumContact($search=NULL){
		if($search['name']){
            $where = "name LIKE '%".$search['name']."%' OR besked LIKE '%".$search['name']."%'";
            $this->db->where($where);
        }
        $query = $this->db->get('contact')->num_rows();
		return $query;
	}
	function saveContact($data=NULL,$id=NULL){
		if($id){
            $this->db->where('id',$id);
            $this->db->update('contact',$data);
            return $id;
        }else{
            if($this->db->insert('contact',$data)){
                return $this->db->insert_id();
            }else{
                return false;
            }
        }     
	}
	function getContact($id=NULL){
		 $query = $this->db->where('id',$id)->get('contact')->row();
		 return $query;
	}
	function delete($id=NULL){
        $this->db->where('id',$id);
        if($this->db->delete('contact')){
            return true;
        }else{
            return false;
        }
	}
}
/** THE END*/
?>