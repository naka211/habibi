<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Gallery_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    function getAllData($num=NULL,$offset=NULL,$search=NULL){
        $this->db->select('*')
                ->from('banner_gallery as bg')
                ->where("bg.bl_active <> ",-1);
		$result = $this->db->order_by('bg.id','DESC')
                        ->limit($num,$offset)
                        ->get()->result();
	    return $result;
    }
    function getNumData($search=NULL){
    	$this->db->select('*')
                ->from('banner_gallery as bg')
                ->where("bg.bl_active <> ",-1);
    	$result = $this->db->get();
	    return $result->num_rows();
    }
    function saveData($data=NULL,$id=NULL){
        if($id){
            $this->db->where('id',$id);
            $this->db->update('banner_gallery',$data);
            return true;
        }else{
            if($this->db->insert('banner_gallery',$data)){
                return $this->db->insert_id();
            }else{
                return false;
            }
        }
    }
    function deleteData($id=NULL){
        $this->db->where('id',$id);
        if($this->db->delete('banner_gallery')){
            return true;
        }else{
            return false;
        }
    }
    function getItem($id=NULL){
        $this->db->select('*')
                    ->from('banner_gallery')
                    ->where('banner_gallery.id',$id)
                    ->where("banner_gallery.bl_active <> ",-1);
    	$result = $this->db->get();
	    return $result->row();
    }
}
?>
