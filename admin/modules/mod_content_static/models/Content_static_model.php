<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Content_Static_model extends CI_Model{
	function __construct(){
        parent::__construct();
	}
	function getAllNewsStatic($num=NULL,$offset=NULL,$search=NULL){
        if($search['name']){
            $where = "title LIKE '%".$search['name']."%' OR content LIKE '%".$search['name']."%'";
            $this->db->where($where);
        }
		$this->db->order_by('id','DESC');
		$query = $this->db->get('content_static',$num,$offset)->result();
		return $query;
	}
	function getNumNewsStatic($search=NULL){
        if($search['name']){
            $where = "title LIKE '%".$search['name']."%' OR content LIKE '%".$search['name']."%'";
            $this->db->where($where);
        }
        $query = $this->db->get('content_static')->num_rows();
		return $query;
	}
	function saveNewsStatic($data=NULL,$id=NULL){
        if($id){
            $this->db->where('id',$id);
            $this->db->update('content_static',$data);
            return $id;
        }else{
            if($this->db->insert('content_static',$data)){
                return $this->db->insert_id();
            }else{
                return false;
            }
        }
	}
	function getNewsStaticByID($id=NULL){
		 $query = $this->db->where('id',$id)->get('content_static')->row();
		 return $query;
	}
	function delete($id=NULL){
        $this->db->where('id',$id);
        if($this->db->delete('content_static')){
            return true;
        }else{
            return false;
        }
	}
}
?>