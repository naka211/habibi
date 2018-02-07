<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Tilbud_model extends CI_Model{
	function __construct(){
        parent::__construct();
	}
    function getData($num=NULL,$offset=NULL,$search=NULL,$ignore=NULL){
        $this->db->select('pp.*, b2b.name as company');
        $this->db->from('product_product as pp');
        $this->db->join('user_b2b as b2b', 'b2b.id = pp.company_id', 'inner');
        $this->db->where("pp.bl_active",1);
        if($search['category_id']){
            $this->db->where('pp.category_id', $search['category_id']);
        }
        if(!empty($search['postfrom'])){
            $this->db->where('b2b.code >=', $search['postfrom']);
            $this->db->where('b2b.code <=', $search['postto']);
            $this->db->where('pp.price >=', $search['pricefrom']);
            $this->db->where('pp.price <=', $search['priceto']);
        }
        if($ignore) {
            //$ignore = array(12, 13);
            $this->db->where_not_in('pp.id', $ignore);
        }

		$this->db->order_by('pp.id','DESC');
        if($num || $offset){
            $this->db->limit($num,$offset);
        }

    	$query = $this->db->get()->result();
	    return $query;
    }
    function getNum($search=NULL){
		$this->db->select('pp.*');
        $this->db->from('product_product as pp');
        $this->db->join('user_b2b as b2b', 'pp.company_id = b2b.id', 'inner');
        $this->db->where("pp.bl_active",1);
        if($search['category_id']){
            $this->db->where('pp.category_id', $search['category_id']);
        }
        if($search['postfrom']){
            $this->db->where('b2b.code >=', $search['postfrom']);
            $this->db->where('b2b.code <=', $search['postto']);
            $this->db->where('pp.price >=', $search['pricefrom']);
            $this->db->where('pp.price <=', $search['priceto']);
        }

    	$query = $this->db->get()->num_rows();
	    return $query;
    }
    function getItem($id=NULL){
        $query = $this->db->select('pp.*, b2b.name as company, b2b.address as companyAddress')
                ->from('product_product as pp')
                ->join('user_b2b as b2b', 'b2b.id = pp.company_id', 'left')
                ->where('pp.id',$id)
                ->where("pp.bl_active",1)
                ->get()
                ->row();
        return $query;
    }
    function getImage($id=NULL){
        $query = $this->db->select('*')
                ->from('product_image as pi')
                ->where('pi.product_id',$id)
                ->where("pi.bl_active",1)
                ->get()
                ->result();
        return $query;
    }
    function getCategory($id=NULL){
        $this->db->select('*')->from('product_category as pc')->where("pc.bl_active",1);
        if($id){
            $this->db->where('pc.category_id',$id);
        }
		$this->db->order_by('pc.ordering','ASC');
    	$query = $this->db->get()->result();
	    return $query;
    }
    /** Order*/
    function saveOrder($data=NULL,$id=NULL){
        if($id){
            $this->db->where('id',$id);
            $this->db->update('product_order',$data);
            return $id;
        }else{
            if($this->db->insert('product_order',$data)){
                return $this->db->insert_id();
            }else{
                return false;
            }
        }
    }
    function deleteOrder($id=NULL){
        $this->db->where('id', $id)->delete('order');
    }
    function addItems($data=NULL){
        $this->db->insert('product_order_item', $data);
    }
    function deleteItems($id=NULL){
        $this->db->where('order_id', $id)->delete('product_order_item');
    }
    
    /** Wishlist*/
    function addWishlist($userID=NULL,$productID=NULL){
        $query = $this->db->set('userID', $userID)->set('productID', $productID)->insert('product_wishlist');
		return $query;
    }
    function removeWishlist($userID=NULL,$productID=NULL){
        $this->db->where('userID', $userID);
        $this->db->where('productID', $productID);
        $query = $this->db->delete('product_wishlist');
        return $query;
    }
    function checkWishlist($userID=NULL,$productID=NULL){
        $query = $this->db->where('userID', $userID)->where('productID', $productID)->get('product_wishlist')->row();
		return $query;
    }
}
?>