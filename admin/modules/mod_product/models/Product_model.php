<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Product_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    /** PRODUCT----------------------------------------------------------------------*/
    function get_all_product($num=NULL,$offset=NULL,$search=NULL){
        $this->db->select('pp.*, pc.name as nameCategory');
        $this->db->from('product_product as pp');
        $this->db->join('product_category as pc', 'pc.category_id = pp.category_id', 'left');
        $this->db->where("pp.bl_active <> ",-1);
        if($search['category_id']){
            $this->db->where('pp.category_id', $search['category_id']);
        }
        if($search['name']){
            $where = "pp.name LIKE '%".$search['name']."%' OR pp.description LIKE '%".$search['name']."%' OR pp.content LIKE '%".$search['name']."%'";
            $this->db->where($where);
        }
		$this->db->order_by('pp.ordering','ASC');
        if($num || $offset){
            $this->db->limit($num,$offset);
        }
    	$query = $this->db->get()->result();
	    return $query;
    }
    function get_num_product($search=NULL){
		$this->db->select('*');
        $this->db->from('product_product as pp');
        $this->db->where("pp.bl_active <> ",-1);
        if($search['category_id']){
            $this->db->where('pp.category_id', $search['category_id']);
        }
        if($search['name']){
            $where = "pp.name LIKE '%".$search['name']."%' OR pp.description LIKE '%".$search['name']."%' OR pp.content LIKE '%".$search['name']."%'";
            $this->db->where($where);
        }
    	$query = $this->db->get()->num_rows();
	    return $query;
    }
    function get_item_product($id=NULL){
        $query = $this->db->select('*')
                ->from('product_product as pp')
                ->where('pp.id',$id)
                ->where("pp.bl_active <> ",-1)
                ->get()
                ->row();
        return $query;
    }
    function get_image_product($id=NULL){
        $query = $this->db->select('*')
                ->from('product_image as pi')
                ->where('pi.product_id',$id)
                ->where("pi.bl_active <> ",-1)
                ->get()
                ->result();
        return $query;
    }
    function save_product($data=NULL,$id=NULL){
        if($id){
            $this->db->where('id',$id)->update('product_product',$data);
            return $id;
        }else{
            if($this->db->insert('product_product',$data)){
                return $this->db->insert_id();
            }else{
                return false;
            }
        }
    }
    function save_image($data=NULL,$id=NULL){
        if($id){
            $this->db->where('id',$id)->update('product_image',$data);
            return $id;
        }else{
            if($this->db->insert('product_image',$data)){
                return $this->db->insert_id();
            }else{
                return false;
            }
        }
    }
    function delete_product($id=NULL){
        $query = $this->db->where('id',$id)->delete('product_product');
        if($query){
            return true;
        }else{
            return false;
        }
    }
    
    /** Get company*/
    function getCompany(){
        $query = $this->db->select('*')->where('bl_active',1)->from('user_b2b')->get()->result();
        return $query;
    }
}
?>