<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Invita_model extends CI_Model{
	function __construct(){
        parent::__construct();
	}
    /** ORDER*/
    function getOrderItem($user=NULL){
        $query = $this->db->select('po.*, pp.name as product')
                ->from('product_order_item as po')
                ->join('product_product as pp', 'pp.id = po.product_id', 'left')
                ->join('product_order as p', 'p.id = po.order_id', 'left')
                ->where("po.used",0)
                ->where("p.userID",$user)
                ->order_by('po.id', 'DESC')
                ->get()->result();
        return $query;
    }
    function getMyTilbud($user=NULL){
        $query = $this->db->select('po.*, pp.name, pp.image, pp.description, b2b.name as company')
                ->from('product_order_item as po')
                ->join('product_product as pp', 'pp.id = po.product_id', 'left')
                ->join('user_b2b as b2b', 'b2b.id = pp.company_id', 'left')
                ->join('product_order as p', 'p.id = po.order_id', 'left')
                ->where("p.userID",$user)
                ->where("pp.bl_active",1)
                ->where("po.used",0)
                ->order_by('po.id','DESC')
                ->get()->result();
	    return $query;
    }
    function getOrderFromItemID($id=NULL){
        $query = $this->db->select('o.*, po.codes')
                ->from('product_order_item as po')
                ->join('product_order as o', 'o.id = po.order_id', 'left')
                ->where('po.used',0)
                ->where('po.id',$id)
                ->get()->row();
        return $query;
    }
    function saveOrderItem($data=NULL,$id=NULL){
        if($id){
            $this->db->where('id',$id);
            $this->db->update('product_order_item',$data);
            return $id;
        }else{
            if($this->db->insert('product_order_item',$data)){
                return $this->db->insert_id();
            }else{
                return false;
            }
        }
    }
    function deleteOrderItem($id=NULL){
        $this->db->where('id', $id)->delete('product_order_item');
    }
    /** INVITATION*/
    /**
     * @param null $data
     * @param null $id
     * @return bool|null
     */
    function saveDating($data=NULL,$id=NULL){
        if($id){
            $this->db->where('id',$id);
            $this->db->update('dating',$data);
            return $id;
        }else{
            if($this->db->insert('dating',$data)){
                return $this->db->insert_id();
            }else{
                return false;
            }
        }
    }
    function saveDatingUser($data=NULL,$id=NULL){
        if($id){
            $this->db->where('id',$id);
            $this->db->update('dating_user',$data);
            return $id;
        }else{
            if($this->db->insert('dating_user',$data)){
                return $this->db->insert_id();
            }else{
                return false;
            }
        }
    }
    function saveDatingImage($data=NULL,$id=NULL){
        if($id){
            $this->db->where('id',$id);
            $this->db->update('dating_image',$data);
            return $id;
        }else{
            if($this->db->insert('dating_image',$data)){
                return $this->db->insert_id();
            }else{
                return false;
            }
        }
    }
    
    
    /** THE END*/
}
?>