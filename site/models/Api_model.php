<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Api_model extends CI_Model{
	function __construct(){
        parent::__construct();
	}
    function getData($id){
        $query = $this->db->select('*')
                ->from('seo')
                ->where('seo.id',$id)
                ->where("seo.bl_active",1)
                ->get()->row();
	    return $query;
    }
    function checkDevice($token=NULL){
		$this->db->like('token',$token);
		$query = $this->db->get('device')->row();
		return $query;
	}
    function insertDevice($DB=NULL,$id=NULL){
        if($id){
            $this->db->where('id',$id);
            $this->db->update('device',$DB);
            return $id;
        }else{
            if($this->db->insert('device',$DB)){
                return $this->db->insert_id();
            }else{
                return false;
            }
        }
	}
    /** USER --------------------------------------------------------------------------------------*/
    function getUser($id=NULL,$email=NULL,$password=NULL,$facebook=NULL,$google=NULL,$groups=NULL){
        $this->db->select('*')->from('user');
        if($id){
            $this->db->where("id",$id);
        }
        if($email){
            $this->db->where("email",$email);
        }
        if($password){
            $this->db->where("password",$password);
        }
        if($facebook){
            $this->db->where("facebook",$facebook);
        }
        if($google){
            $this->db->where("google",$google);
        }
        if($groups){
            $this->db->where("groups",$groups); //1: register - 2: facebook - 3: google
        }
        $query = $this->db->get()->row();
	    return $query;
    }
    function getUserOrderID($orderID=NULL){
        $this->db->select('*')->from('user');
        $this->db->where("orderid",$orderID);
        $query = $this->db->get()->row();
	    return $query;
    }
    function saveUser($DB=NULL,$id=NULL){
        if($id){
            $this->db->where('id',$id);
            $this->db->update('user',$DB);
            return $id;
        }else{
            if($this->db->insert('user',$DB)){
                return $this->db->insert_id();
            }else{
                return false;
            }
        }
    }
    function updateLogin($id=NULL){
        $this->db->set('login', date('Y-m-d H:i:s'));
        $this->db->where('id', $id);
        $query = $this->db->update('user');
        if($query){
            return $id;
        }else{
            return false;
        }
	}
    function getUserList($num=NULL,$offset=NULL,$search=NULL,$ignore=NULL,$inUser=NULL){
        $this->db->select('u.*');
        $this->db->from('user as u');
        $this->db->where("u.bl_active",1);
        if($search['name']){
            $this->db->where('u.id LIKE "%'.$search['name'].'%" OR u.name LIKE "%'.$search['name'].'%"');
        }
        if($ignore){
            //$ignore = array(12, 13);
            $this->db->where_not_in('u.id', $ignore);
        }
        if($inUser){
            //$inUser = array(12, 13);
            $this->db->where_in('u.id', $inUser);
        }
		$this->db->order_by('u.id','DESC');
        if($num || $offset){
            $this->db->limit($num,$offset);
        }
    	$query = $this->db->get()->result();
	    return $query;
    }
    function getPositiv($num=NULL,$offset=NULL,$user=NULL,$search=NULL){
        $this->db->select('u.*');
        $this->db->from('user_action as ua');
        $this->db->join('user as u', 'u.id = ua.user_to', 'left');
        $this->db->where("ua.user_from",$user);
        $this->db->where("ua.bl_active",1);
        $this->db->where("u.bl_active",1);
		$this->db->order_by('ua.id','DESC');
        if($num || $offset){
            $this->db->limit($num,$offset);
        }
    	$query = $this->db->get()->result();
	    return $query;
    }
    function getBrowsing($num=NULL,$offset=NULL,$search=NULL,$ignore=NULL){
        $this->db->select('u.*');
        $this->db->from('user as u');
        $this->db->where("u.bl_active",1);
        //Search
        if(isset($search['year_from'])){
            $this->db->where('u.year >=', $search['year_from']);
        }
        if(isset($search['year_to'])){
            $this->db->where('u.year <=', $search['year_to']);
        }
        if(isset($search['height_from'])){
            $this->db->where('u.height >=', $search['height_from']);
        }
        if(isset($search['height_to'])){
            $this->db->where('u.height <=', $search['height_to']);
        }
        if(isset($search['gender'])&&$search['gender']!=0){
            $this->db->where('u.gender', $search['gender']);
        }
        if(isset($search['relationship'])&&$search['relationship'][0]!=""){
            //$inUser = array(12, 13);
            $this->db->where_in('u.relationship', $search['relationship']);
        }
        if(isset($search['children'])&&$search['children'][0]!=""){
            $this->db->where_in('u.children', $search['children']);
        }
        if(isset($search['ethnic_origin'])&&$search['ethnic_origin'][0]!=""){
            $this->db->where_in('u.ethnic_origin', $search['ethnic_origin']);
        }
        if(isset($search['religion'])&&$search['religion'][0]!=""){
            $this->db->where_in('u.religion', $search['religion']);
        }
        if(isset($search['training'])&&$search['training'][0]!=""){
            $this->db->where_in('u.training', $search['training']);
        }
        if(isset($search['body'])&&$search['body'][0]!=""){
            $this->db->where_in('u.body', $search['body']);
        }
        if($ignore){
            //$ignore = array(12, 13);
            $this->db->where_not_in('u.id', $ignore);
        }
		$this->db->order_by('u.id','DESC');
        if($num || $offset){
            $this->db->limit($num,$offset);
        }
    	$query = $this->db->get()->result();
	    return $query;
    }
    function getNumBrowsing($search=NULL,$ignore=NULL){
        $this->db->select('u.*');
        $this->db->from('user as u');
        $this->db->where("u.bl_active",1);
        //Search
        if(isset($search['year_from'])){
            $this->db->where('u.year >=', $search['year_from']);
        }
        if(isset($search['year_to'])){
            $this->db->where('u.year <=', $search['year_to']);
        }
        if(isset($search['height_from'])){
            $this->db->where('u.height >=', $search['height_from']);
        }
        if(isset($search['height_to'])){
            $this->db->where('u.height <=', $search['height_to']);
        }
        if(isset($search['gender'])&&$search['gender']!=0){
            $this->db->where('u.gender', $search['gender']);
        }
        if(isset($search['relationship'])&&$search['relationship'][0]!=""){
            //$inUser = array(12, 13);
            $this->db->where_in('u.relationship', $search['relationship']);
        }
        if(isset($search['children'])&&$search['children'][0]!=""){
            $this->db->where_in('u.children', $search['children']);
        }
        if(isset($search['ethnic_origin'])&&$search['ethnic_origin'][0]!=""){
            $this->db->where_in('u.ethnic_origin', $search['ethnic_origin']);
        }
        if(isset($search['religion'])&&$search['religion'][0]!=""){
            $this->db->where_in('u.religion', $search['religion']);
        }
        if(isset($search['training'])&&$search['training'][0]!=""){
            $this->db->where_in('u.training', $search['training']);
        }
        if(isset($search['body'])&&$search['body'][0]!=""){
            $this->db->where_in('u.body', $search['body']);
        }
        if($ignore){
            //$ignore = array(12, 13);
            $this->db->where_not_in('u.id', $ignore);
        }
    	$query = $this->db->get()->num_rows();
	    return $query;
    }
    /** PHOTO -------------------------------------------------------------------------------------*/
    function getPhoto($user=NULL){
        $this->db->select('*')->from('user_image');
        if($user){
            $this->db->where("userID",$user);
        }
        $query = $this->db->get()->result();
        return $query;
    }
    function savePhoto($DB=NULL){
        if($this->db->insert('user_image',$DB)){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }
    function deletePhoto($id=NULL,$user=NULL){
        $this->db->select('image');
        $this->db->from('user_image');
        $this->db->where('id', $id);
        $query = $this->db->get();
        $image = $query->row();
        unlink("uploads/photo/".$image->image);

        $this->db->where('id',$id);
        $this->db->where('userID',$user);
        if($this->db->delete('user_image')){
            return true;
        }else{
            return false;
        }
    }
    /** FAVORITE -----------------------------------------------------------------------------------*/
    function getFavorite($num=NULL,$offset=NULL,$user=NULL,$search=NULL){
        $this->db->select('u.*');
        $this->db->from('user_favorite as uf');
        $this->db->join('user as u', 'u.id = uf.user_to', 'left');
        if($search['name']){
            $this->db->where('u.id LIKE "%'.$search['name'].'%" OR u.name LIKE "%'.$search['name'].'%"');
        }
        $this->db->where("uf.user_from",$user);
        $this->db->where("u.bl_active",1);
		$this->db->order_by('uf.id','DESC');
        if($num || $offset){
            $this->db->limit($num,$offset);
        }
    	$query = $this->db->get()->result();
	    return $query;
    }
    function addFavorite($DB=NULL,$id=NULL){
        if($id){
            $this->db->where('id',$id);
            $this->db->update('user_favorite',$DB);
            return $id;
        }else{
            if($this->db->insert('user_favorite',$DB)){
                return $this->db->insert_id();
            }else{
                return false;
            }
        }
    }
    function removeFavorite($user=NULL,$userID=NULL){
        $this->db->where('user_from',$user);
        $this->db->where('user_to',$userID);
        if($this->db->delete('user_favorite')){
            return true;
        }else{
            return false;
        }
    }
    function checkFavorite($user=NULL,$userID=NULL){
        $query = $this->db->where('user_from', $user)->where('user_to', $userID)->get('user_favorite')->row();
		return $query;
    }
    /** MESSAGE -------------------------------------------------------------------------------------*/
    function saveMessage($DB=NULL){
        if($this->db->insert('user_messages',$DB)){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }
    function getMessages($user=NULL,$userID=NULL,$num=NULL,$offset=NULL){
		$this->db->select('m.*, u.name');
		$this->db->from('user_messages m');
        $this->db->join('user u', 'm.user_from = u.id','left');
        $this->db->where('(m.user_from='.$user.' AND m.user_to='.$userID.') OR (m.user_from='.$userID.' AND m.user_to='.$user.')');
        $this->db->order_by('m.id DESC');
        if($num || $offset){
            $this->db->limit($num, $offset);
        }
        $query = $this->db->get();
        return $query->result();
    }
    function getListMessage($user=NULL){
        $this->db->select('DISTINCT(user_from)');
        $this->db->from('user_messages');
        $this->db->where('user_to', $user);
        $this->db->order_by('id DESC');
        $query = $this->db->get();
        return $query->result();
    }
    function getNotSeen($user=NULL,$userID=NULL){
        $this->db->select('COUNT(*) num');
        $this->db->from('user_messages');
        $this->db->where('user_from', $userID);
        $this->db->where('user_to', $user);
        $this->db->where('seen', 1);
        $query = $this->db->get();
        return $query->row()->num;
    }
    
    function getLatestMessage($user=NULL,$userID=NULL){
        $this->db->select('message, dt_create');
        $this->db->from('user_messages');
        $this->db->where('user_from', $userID);
        $this->db->where('user_to', $user);
        $this->db->order_by('id DESC');
        $this->db->limit(1, 0);
        $query = $this->db->get();
        return $query->row();
    }
    function clearNotSeen($user=NULL,$userID=NULL){
        $this->db->set('seen',0)->where('user_from', $userID)->where('user_to', $user)->update('user_messages');
        return true;
    }
    function deleteMessage_FT($user=NULL,$userID=NULL){
        $this->db->where('user_from', $user)->where('user_to', $userID)->delete('user_messages');
        return true;
    }
    function deleteMessage_TF($user=NULL,$userID=NULL){
        $this->db->where('user_to', $user)->where('user_from', $userID)->delete('user_messages');
        return true;
    }
    /** SHOP PRODUCTS ---------------------------------------------------------------------------*/
    function getCategory(){
        $query = $this->db->select('pc.category_id, pc.name')
                    ->from('product_category as pc')
                    ->where('bl_active',1)
                    ->order_by('ordering', 'ASC')
                    ->get()->result();
        return $query;
    }
    function getProduct($num=NULL,$offset=NULL,$search=NULL,$ignore=NULL){
        $this->db->select('pp.*, b2b.name as company');
        $this->db->from('product_product as pp');
        $this->db->join('user_b2b as b2b', 'b2b.id = pp.company_id', 'left');
        $this->db->where("pp.bl_active",1);
        if($search['category_id']){
            $this->db->where('pp.category_id', $search['category_id']);
        }
        if($ignore){
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
    function getProductDetail($id=NULL){
        $query = $this->db->select('pp.*, b2b.name as company, b2b.address as companyAddress')
                ->from('product_product as pp')
                ->join('user_b2b as b2b', 'b2b.id = pp.company_id', 'left')
                ->where('pp.id',$id)
                ->where("pp.bl_active",1)
                ->get()->row();
        return $query;
    }
    function getProductImage($id=NULL){
        $query = $this->db->select('*')
                ->from('product_image as pi')
                ->where('pi.product_id',$id)
                ->where("pi.bl_active",1)
                ->get()->result();
        return $query;
    }
    function getMyTilbud($user){
        $query = $this->db->select('po.*, pp.name, pp.image, pp.description, b2b.name as company')
                ->from('product_order_item as po')
                ->join('product_product as pp', 'pp.id = po.product_id', 'left')
                ->join('user_b2b as b2b', 'b2b.id = pp.company_id', 'left')
                ->join('product_order as p', 'p.id = po.order_id', 'left')
                ->where("p.userID",$user)
                ->where("pp.bl_active",1)
                ->order_by('po.id','DESC')
                ->get()->result();
	    return $query;
    }
    function getMyTilbudNoUsed($user=NULL){
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
    function checkWishlist($user=NULL,$productID=NULL){
        $query = $this->db->where('userID', $user)->where('productID', $productID)->get('product_wishlist')->row();
		return $query;
    }
    function addWishlist($DB=NULL,$id=NULL){
        if($id){
            $this->db->where('id',$id);
            $this->db->update('product_wishlist',$DB);
            return $id;
        }else{
            if($this->db->insert('product_wishlist',$DB)){
                return $this->db->insert_id();
            }else{
                return false;
            }
        }
    }
    function removeWishlist($user=NULL,$productID=NULL){
        $this->db->where('userID',$user);
        $this->db->where('productID',$productID);
        if($this->db->delete('product_wishlist')){
            return true;
        }else{
            return false;
        }
    }
    /** ORDER ------------------------------------------------------------------------------------*/
    function getOrder($id=NULL,$orderID=NULL){
        $this->db->select('*');
        $this->db->from('product_order');
        if($id){
            $this->db->where('id', $id);
        }
        if($orderID){
            $this->db->where('orderID', $orderID);
        }
    	$query = $this->db->get()->row();
	    return $query;
    }
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
    function addOrderItems($data=NULL){
        $this->db->insert('product_order_item', $data);
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
    function deleteOrderItem($id=NULL){
        $this->db->where('id', $id)->delete('product_order_item');
    }
    /** INVITATION -----------------------------------------------------------------------------------*/
    function getDating($id=NULL,$orderID=NULL){
        $this->db->select('*');
        $this->db->from('dating');
        if($id){
            $this->db->where('id', $id);
        }
        if($orderID){
            $this->db->where('orderid', $orderID);
        }
    	$query = $this->db->get()->row();
	    return $query;
    }
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
    
    
    /** THE END*/
}
?>