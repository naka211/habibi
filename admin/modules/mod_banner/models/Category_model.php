<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Category_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    /** CATEGORY--------------------------------------------------------------------*/
    function getCategory($parentID=0){
        $this->db->select('*');
        $this->db->from('banner_category');
        $this->db->where('parent_id', $parentID);
		$this->db->order_by('ordering','ASC');
    	$query = $this->db->get()->result();
	    return $query;
    }
    function get_num_category($search=NULL){
    	$this->db->select('cc.*');
        $this->db->from('banner_category as cc');
        $this->db->join('banner_category as cc1','cc.parent_id = cc1.category_id','left outer');
        if($search['name']){
            $where = "cc.name LIKE '%".$search['name']."%' OR cc.content LIKE '%".$search['name']."%' OR cc1.name LIKE '%".$search['name']."%' OR cc1.content LIKE '%".$search['name']."%'";
            $this->db->where($where);
        }
    	$query = $this->db->get()->num_rows();
	    return $query;
    }
    function get_all_category($num=NULL,$offset=NULL,$search=NULL){
    	$this->db->select('cc.*, cc1.name as nameParent');
        $this->db->from('banner_category as cc');
        $this->db->join('banner_category as cc1','cc.parent_id = cc1.category_id','left outer');
        if($search['name']){
            $where = "cc.name LIKE '%".$search['name']."%' OR cc.content LIKE '%".$search['name']."%' OR cc1.name LIKE '%".$search['name']."%' OR cc1.content LIKE '%".$search['name']."%'";
            $this->db->where($where);
        }
		$this->db->order_by('cc.ordering','ASC');
        if($num || $offset){
            $this->db->limit($num,$offset);
        }
    	$query = $this->db->get()->result();
	    return $query;
    }
    function get_category_item($id=NULL){
        $this->db->select('*');
        $this->db->from('banner_category');
        $this->db->where('banner_category.category_id',$id);
    	$query = $this->db->get()->row();
	    return $query;
    }
    function save_category($data=NULL,$id=NULL){
        if($id){
            $this->db->where('category_id',$id);
            $this->db->update('banner_category',$data);
            return $id;
        }else{
            if($this->db->insert('banner_category',$data)){
                return $this->db->insert_id();
            }else{
                return false;
            }
        }
	}
    function delete_category($id=NULL){
        $this->db->where('category_id',$id);
        if($this->db->delete('banner_category')){
            return true;
        }else{
            return false;
        }
    }
}
?>