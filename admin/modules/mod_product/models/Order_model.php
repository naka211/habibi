<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Order_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    /** ORDER----------------------------------------------------------------------*/
    function getAllOrder($num=NULL,$offset=NULL,$search=NULL){
        $this->db->select('po.*, u.name as user');
        $this->db->from('product_order as po');
        $this->db->join('user as u', 'u.id = po.userID', 'left');
        if($search['name']){
            $where = "po.orderID LIKE '%".$search['name']."%'";
            $this->db->where($where);
        }
		$this->db->order_by('po.ordering','ASC');
        if($num || $offset){
            $this->db->limit($num,$offset);
        }
    	$query = $this->db->get()->result();
	    return $query;
    }
    function getNumOrder($search=NULL){
		$this->db->select('*');
        $this->db->from('product_order as po');
        if($search['name']){
            $where = "po.orderID LIKE '%".$search['name']."%'";
            $this->db->where($where);
        }
    	$query = $this->db->get()->num_rows();
	    return $query;
    }
    function getOrder($id=NULL){
        $query = $this->db->select('*')
                ->from('product_order as po')
                ->where('po.id',$id)
                ->get()->row();
        return $query;
    }
    function delete($id=NULL){
        $query = $this->db->where('id',$id)->delete('product_order');
        if($query){
            return true;
        }else{
            return false;
        }
    }
    function deleteItem($id=NULL){
        $query = $this->db->where('order_id',$id)->delete('product_order_item');
        if($query){
            return true;
        }else{
            return false;
        }
    }
    
    /** Order item*/
    function getAllOrderItem($num=NULL,$offset=NULL,$search=NULL){
        $this->db->select('poi.*');
        $this->db->from('product_order_item as poi');
		$this->db->order_by('poi.ordering','ASC');
        if($search['id']){
            $this->db->where('poi.order_id',$search['id']);
        }
        if($num || $offset){
            $this->db->limit($num,$offset);
        }
    	$query = $this->db->get()->result();
	    return $query;
    }
    function getNumOrderItem($search=NULL){
		$this->db->select('*');
        $this->db->from('product_order_item as poi');
        if($search['id']){
            $this->db->where('poi.order_id',$search['id']);
        }
    	$query = $this->db->get()->num_rows();
	    return $query;
    }
    /** Get company*/
    function getCompany(){
        $query = $this->db->select('*')->where('bl_active',1)->from('user_b2b')->get()->result();
        return $query;
    }
}
?>