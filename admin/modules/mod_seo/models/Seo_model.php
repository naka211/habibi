<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Seo_model extends CI_Model{
	function __construct(){
        parent::__construct();
	}
	function get_all_seo($num=NULL,$offset=NULL,$search=NULL){
		$query = $this->db->order_by('ordering','ASC')->get('seo',$num,$offset)->result();
		return $query;
	}
	function get_num_seo($search=NULL){
		$query = $this->db->get('seo')->num_rows();
		return $query;
	}
	function save_seo($data=NULL,$id=NULL){
        if($id){
            $this->db->where('id',$id);
            if($this->db->update('seo',$data)){
                return $id;
            }else{
                return false;
            }
        }else{
            if($this->db->insert('seo',$data)){
                return $this->db->insert_id();
            }else{
                return false;
            }
        }
	}
	function get_seo_item($id){
		 $query = $this->db->where('id',$id)->get('seo')->row();
		 return $query;
	}
	function deleteData($id){
        $query = $this->db->where('id',$id)->delete('seo');
        if($query){
            return true;
        }else{
            return false;
        }
	}
}
?>