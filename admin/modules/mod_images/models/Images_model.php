<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Images_model extends CI_Model{
	function __construct(){
        parent::__construct();
	}
	function getAllImages($num=NULL,$offset=NULL,$search=NULL){
        if($search['name']){
            $this->db->where('u.name', $search['name']);
        }
        if($search['status'] != null){
            $this->db->where('ui.status', $search['status']);
        }
        $result = $this->db->select("ui.*, u.name")
                ->from("user_image as ui")
                ->join("user as u", "ui.userId = u.id", 'inner')
                ->order_by('ui.id','DESC')
                ->get()->result();
		return $result;
	}
	function getNumImages($search=NULL){
        if($search['name']){
            $this->db->where('u.name', $search['name']);
        }
        if($search['status'] != null){
            $this->db->where('ui.status', $search['status']);
        }
        $query = $this->db->select('ui.*')
            ->from('user_image as ui')
            ->join("user as u", "ui.userId = u.id", 'inner')
            ->get()->num_rows();
		return $query;
	}
	function saveShoutout($data=NULL,$id=NULL){
        if($id){
            $this->db->where('id',$id);
            $this->db->update('user_shoutouts',$data);
            return $id;
        }else{
            if($this->db->insert('user_shoutouts',$data)){
                return $this->db->insert_id();
            }else{
                return false;
            }
        }
	}
	function getShoutoutByID($id=NULL){
		 $query = $this->db->where('id',$id)->get('user_shoutouts')->row();
		 return $query;
	}
	function delete($id=NULL){
		$this->db->where('id',$id);
        if($this->db->delete('user_shoutouts')){
            return true;
        }else{
            return false;
        }
	}
}
?>