<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Content_model extends CI_Model{
    public $language = "";
    function __construct(){
        parent::__construct();
    }
    function init($lang){
        $this->language = $lang;
    }
    /** CONTENT----------------------------------------------------------------------*/
    function getAllContent($num=NULL,$offset=NULL,$search=NULL){
    	$this->db->select('cc.*, c.name as nameCategory');
        $this->db->from('content_content AS cc');
        $this->db->join('content_category AS c','c.category_id = cc.category_id','left');
        if($search['category_id']){
            $this->db->where('cc.category_id', $search['category_id']);
        }
        if($search['name']){
            $where = "cc.title LIKE '%".$search['name']."%' OR cc.description LIKE '%".$search['name']."%' OR cc.content LIKE '%".$search['name']."%'";
            $this->db->where($where);
        }
		$this->db->order_by('cc.ordering','ASC');
		$this->db->limit($num,$offset);
    	$query = $this->db->get()->result();
	    return $query;
    }

    function getNumContent($search=NULL){
    	$this->db->select('*');
        $this->db->from('content_content');
        if($search['category_id']){
            $this->db->where('category_id', $search['category_id']);
        }
        if($search['name']){
            $where = "title LIKE '%".$search['name']."%' OR description LIKE '%".$search['name']."%' OR content LIKE '%".$search['name']."%'";
            $this->db->where($where);
        }
    	$query = $this->db->get()->num_rows();
	    return $query;
    }
    function save_content($data=NULL,$id=NULL){
        if($id){
            $this->db->where('id',$id);
            $this->db->update('content_content',$data);
            return $id;
        }else{
            if($this->db->insert('content_content',$data)){
                return $this->db->insert_id();
            }else{
                return false;
            }
        }
    }
    function delete_content($id=NULL){
        $this->db->where('id',$id);
        if($this->db->delete('content_content')){
            return true;
        }else{
            return false;
        }
    }
    function get_content($id=NULL){
    	$query = $this->db->select('*')
                    ->from('content_content')
                    ->where('id',$id)
                    ->get()->row();
	    return $query;
    }

    /** CATEGORY--------------------------------------------------------------------*/
    function getCategory($parentID=0){
        $this->db->select('*');
        $this->db->from('content_category');
        $this->db->where('parent_id', $parentID);
		$this->db->order_by('ordering','ASC');
    	$query = $this->db->get()->result();
	    return $query;
    }
    function getCategoryParentName($parentID=NULL){
        $this->db->select('cc.category_id, cc.name, cc1.name as nameParent');
        $this->db->from('content_category as cc');
        $this->db->join('content_category as cc1','cc.parent_id = cc1.category_id','left outer');
        $this->db->order_by('cc.ordering','ASC');
        $query = $this->db->get()->result();
        return $query;
    }
    function getNumCategory($search=NULL){
        $this->db->select('cc.*');
        $this->db->from('content_category as cc');
        $this->db->join('content_category as cc1','cc.parent_id = cc1.category_id','left outer');
        if($search['name']){
            $where = "cc.name LIKE '%".$search['name']."%' OR cc1.name LIKE '%".$search['name']."%'";
            $this->db->where($where);
        }
    	$query = $this->db->get()->num_rows();
	    return $query;
    }
    function getAllCategory($num=NULL,$offset=NULL,$search=NULL){
    	$this->db->select('cc.category_id, cc.code, cc1.name as nameParent, cc.name, cc.dt_create, cc.bl_active, cc.ordering');
        $this->db->from('content_category as cc');
        $this->db->join('content_category as cc1','cc.parent_id = cc1.category_id','left outer');
        if($search['name']){
            $where = "cc.name LIKE '%".$search['name']."%' OR cc1.name LIKE '%".$search['name']."%'";
            $this->db->where($where);
        }
		$this->db->order_by('cc.ordering','ASC');
		$this->db->limit($num,$offset);
    	$query = $this->db->get()->result();
	    return $query;
    }
    function get_category_item($id=NULL){
        $this->db->select('*');
        $this->db->from('content_category');
        $this->db->where('category_id',$id);
    	$query = $this->db->get()->row();
	    return $query;
    }
    function save_category($data=NULL,$id=NULL){
        if($id){
            $this->db->where('category_id',$id);
            $this->db->update('content_category',$data);
            return $id;
        }else{
            if($this->db->insert('content_category',$data)){
                return $this->db->insert_id();
            }else{
                return false;
            }
        }
	}
    function delete_category($id=NULL){
        $this->db->where('category_id',$id);
        if($this->db->delete('content_category')){
            return true;
        }else{
            return false;
        }
    }
    function export_category(){
        
    }
}
?>