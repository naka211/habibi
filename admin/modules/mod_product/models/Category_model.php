<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Category_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    /** CATEGORY--------------------------------------------------------------------*/
    function get_all_category($num=NULL,$offset=NULL,$search=NULL){
        $this->db->select('*');
        $this->db->from('product_category as pc');
        $this->db->where("pc.bl_active <> ",-1);
        if($search['name']){
            $where = "name LIKE '%".$search['name']."%' OR content LIKE '%".$search['name']."%'";
            $this->db->where($where);
        }
		$this->db->order_by('pc.ordering','ASC');
        if($num || $offset){
            $this->db->limit($num,$offset);
        }
    	$query = $this->db->get()->result();
	    return $query;
    }
    function get_num_category($search=NULL){
        $this->db->select('*');
        $this->db->from('product_category as pc');
        $this->db->where("pc.bl_active <> ",-1);
        if($search['name']){
            $where = "name LIKE '%".$search['name']."%' OR content LIKE '%".$search['name']."%'";
            $this->db->where($where);
        }
    	$query = $this->db->get()->num_rows();
	    return $query;
    }
    
    function get_item_category($id=NULL){
        $query = $this->db->select('*')
                ->from('product_category as pc')
                ->where('pc.category_id',$id)
                ->where("pc.bl_active <> ",-1)
                ->get()->row();
	    return $query;
    }
    function save_category($data=NULL,$id=NULL){
        if($id){
            $this->db->where('category_id',$id)->update('product_category',$data);
            return $id;
        }else{
            if($this->db->insert('product_category',$data)){
                return $this->db->insert_id();
            }else{
                return false;
            }
        }
	}
    function delete_category($id=NULL){
        $query = $this->db->where('category_id',$id)->delete('product_category');
        if($query){
            return true;
        }else{
            return false;
        }
    }
}
?>
