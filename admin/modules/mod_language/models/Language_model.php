<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Language_model extends CI_Model{
	function __construct(){
        parent::__construct();
	}
	function getAll($num=NULL,$offset=NULL,$search=NULL){
		$query = $this->db->order_by('ordering','ASC')->get('language',$num,$offset)->result();
		return $query;
	}
	function getNum($search=NULL){
		$query = $this->db->get('language')->num_rows();
		return $query;
	}
	function getItem($id){
		 $query = $this->db->where('id',$id)->get('language')->row();
		 return $query;
	}
    function save($data=NULL,$id=NULL){
        if($id){
            $this->db->where('id',$id);
            if($this->db->update('language',$data)){
                return $id;
            }else{
                return false;
            }
        }else{
            if($this->db->insert('language',$data)){
                return $this->db->insert_id();
            }else{
                return false;
            }
        }
	}
	function delete($id){
        $query = $this->db->where('id',$id)->delete('language');
        if($query){
            return true;
        }else{
            return false;
        }
	}
}
?>