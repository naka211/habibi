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

	function getImageName($id=NULL){
		 $query = $this->db->where('id',$id)->get('user_image')->row();
		 return $query;
	}
	function delete($id=NULL){
		$this->db->where('id',$id);
        if($this->db->delete('user_image')){
            return true;
        }else{
            return false;
        }
	}

	function updateImageStatus($imageId, $status){
        $this->db->set('status', $status, false);
        $this->db->where('id', $imageId);
        $this->db->update('user_image');
    }
}
?>