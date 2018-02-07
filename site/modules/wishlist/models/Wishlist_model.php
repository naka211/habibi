<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Wishlist_Model extends MX_Controller { 
    public function __construct() {
        parent::__construct(); 
    }
    function getWishlist($user){
        $query = $this->db->select('pp.*, pw.id as wishlistID')
                ->from('product_wishlist as pw')
                ->join('product_product as pp', 'pp.id = pw.productID', 'left')
                ->where("pw.userID",$user)
                ->where("pp.bl_active",1)
                ->order_by('pw.id','DESC')
                ->get()->result();
	    return $query;
    }
}