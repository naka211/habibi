<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class User_model extends CI_Model{
	function __construct(){
        parent::__construct();
	}

    /**
     * @param $meta
     * @param array $data
     * @param string $custom_title
     */
    public function addMeta($meta, &$data = array(), $custom_title = ''){
        if($custom_title != ''){
            $data['title'] = $custom_title;
        } else {
            $data['title'] = ($meta)?$meta->name:"";
        }
        $data['meta_title'] = ($meta)?$meta->meta_title:"";
        $data['meta_keywords'] = ($meta)?$meta->meta_keywords:"";
        $data['meta_description'] = ($meta)?$meta->meta_description:"";
    }

    /** USER*/
    /**
     * @param null $num
     * @param null $offset
     * @param null $search
     * @param null $ignore
     * @return mixed
     */
    function getBrowsing($num=NULL,$offset=NULL,$search=NULL,$ignore=NULL){
        $this->db->select('u.*');
        $this->db->from('user as u');
        $this->db->where("u.bl_active",1);
        //Search
        if($search['year_from']){
            $this->db->where('u.year >=', $search['year_from']);
        }
        if($search['year_to']){
            $this->db->where('u.year <=', $search['year_to']);
        }
        if($search['height_from']){
            $this->db->where('u.height >=', $search['height_from']);
        }
        if($search['height_to']){
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
    function getNum($search=NULL,$ignore=NULL){
        $this->db->select('u.*');
        $this->db->from('user as u');
        $this->db->where("u.bl_active",1);
        //Search
        if($search['year_from']){
            $this->db->where('u.year >=', $search['year_from']);
        }
        if($search['year_to']){
            $this->db->where('u.year <=', $search['year_to']);
        }
        if($search['height_from']){
            $this->db->where('u.height >=', $search['height_from']);
        }
        if($search['height_to']){
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
    
    function getList($num=NULL,$offset=NULL,$search=NULL,$ignore=NULL,$inUser=NULL){
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
    function getUser($id=NULL,$email=NULL,$password=NULL,$facebook=NULL,$google=NULL,$permission=NULL){
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
        if($permission){
            $this->db->where("permission",$permission); //1: register - 2: facebook - 3: google
        }
        $query = $this->db->get()->row();
	    return $query;
    }

    /**
     * @param null $id
     * @param null $email
     * @param null $password
     * @return mixed
     */
    function getB2b($id=NULL,$email=NULL,$password=NULL){
        $this->db->select('*')->from('user_b2b');
        if($id){
            $this->db->where("id",$id);
        }
		if($email){
            $this->db->where("email",$email);
		}
        if($password){
            $this->db->where("password",$password);
        }
        $query = $this->db->get()->row();
        return $query;
	}

    function updateB2B($DB=NULL,$id=NULL){
        if($id){
            $this->db->where('id',$id);
            return $this->db->update('user_b2b',$DB);
        }
    }

    function getQuantityB2BDeals($company_id){
        $query = $this->db->select('po.*')
            ->from('product_order_item as po')
            ->join('product_product as pp', 'pp.id = po.product_id', 'left')
            ->join('user_b2b as b2b', 'b2b.id = pp.company_id', 'left')
            ->join('product_order as p', 'p.id = po.order_id', 'left')
            ->where("b2b.id",$company_id)
            ->where("p.bl_active",1)
            ->order_by('po.dt_create','DESC')
            ->get()->num_rows();
        return $query;
    }

    function getB2BDeals($company_id, $num, $offset){
        $query = $this->db->select('po.*, pp.name, pp.image, pp.description, p.orderID as orderId, pc.name as categoryName')
            ->from('product_order_item as po')
            ->join('product_product as pp', 'pp.id = po.product_id', 'left')
            ->join('user_b2b as b2b', 'b2b.id = pp.company_id', 'left')
            ->join('product_order as p', 'p.id = po.order_id', 'left')
            ->join('product_category as pc', 'pp.category_id = pc.category_id', 'left')
            ->where("b2b.id",$company_id)
            ->where("p.bl_active",1)
            ->order_by('po.dt_create','DESC')
            ->limit($num,$offset)
            ->get()->result();
        return $query;
    }

    function updateLogin($id=NULL, $b2b=NULL){
        if($b2b){
            $this->db->set('login', date('Y-m-d H:i:s'));
            $this->db->where('id', $id);
            $query = $this->db->update('user_b2b');
            if($query){
                return $id;
            }else{
                return false;
            }
        }else{
            $this->db->set('login', date('Y-m-d H:i:s'));
            $this->db->where('id', $id);
            $query = $this->db->update('user');
            if($query){
                return $id;
            }else{
                return false;
            }
        }
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

    public function addLog($db){
        if($this->db->insert('payment_log',$db)){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }
    /** MESSAGE*/
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

    /**
     * @param null $userId
     * @return mixed
     */
    function getNumUnreadMessage($userId = NULL){
        $this->db->distinct();
        $this->db->select('id');
        $this->db->from('user_messages');
        $this->db->group_by('user_from');
        $this->db->where('user_to', $userId);
        $this->db->where('seen', 1);
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * @param null $user
     * @param null $userID
     * @return mixed
     */
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

    public function checkSentMessage($userId, $friendId){
        $this->db->select('id');
        $this->db->from('user_messages');
        $this->db->where('user_from', $userId);
        $this->db->where('user_to', $friendId);
        $this->db->where('seen', 1);
        $query = $this->db->get()->num_rows();
        return $query?true:false;
    }
    /** FAVORITE*/
    /**
     * @param null $num
     * @param null $offset
     * @param null $user
     * @param null $search
     * @return mixed
     */
    function getFavorite($num=NULL,$offset=NULL,$user=NULL,$search=NULL){
        $this->db->select('u.*, uf.dt_create as time_added');
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
    function getNumFavorite($user=NULL){
        $this->db->select('uf.*');
        $this->db->from('user_favorite as uf');
        $this->db->where("uf.user_from",$user);
        $this->db->where("uf.bl_active",1);
    	$query = $this->db->get()->num_rows();
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

    /**
     * @author T.Trung
     * @param null $user_id_1
     * @param null $user_id_2
     * @return mixed
     */
    function checkStatus($user_id_1 = NULL,$user_id_2 = NULL){
        $status = new stdClass();
        $query = $this->db->where('user_from', $user_id_1)->where('user_to', $user_id_2)->get('user_favorite')->num_rows();
        $status->isFavorite = $query?true:false;

        $query = $this->db->where('user_id', $user_id_1)->where('invited_user_id', $user_id_2)->get('user_dated')->num_rows();
        $isDated1 = $query?true:false;
        $query = $this->db->where('user_id', $user_id_2)->where('invited_user_id', $user_id_1)->get('user_dated')->num_rows();
        $isDated2 = $query?true:false;

        $status->isDated = $isDated1||$isDated2?true:false;

        $query = $this->db->where('from_user_id', $user_id_1)->where('to_user_id', $user_id_2)->get('user_kisses')->num_rows();
        $status->isKissed = $query?true:false;

        $query = $this->db->where('user_from', $user_id_1)->where('user_to', $user_id_2)->get('user_blocked')->num_rows();
        $status->isBlocked = $query?true:false;

        return $status;
    }

    /**
     * @param null $DB
     * @return bool
     */
    function sendKiss($DB=NULL){
        if($this->db->insert('user_kisses',$DB)){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }

    /**
     * @param null $user
     * @param null $userID
     * @return bool
     */
    function removeKiss($user=NULL,$userID=NULL){
        $this->db->where('from_user_id',$user);
        $this->db->where('to_user_id',$userID);
        if($this->db->delete('user_kisses')){
            return true;
        }else{
            return false;
        }
    }
    
    /** POSITIV*/
    /*function getPositiv($num=NULL,$offset=NULL,$user=NULL,$search=NULL){
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
    function getNumPositiv($user=NULL){
        $this->db->select('ua.*');
        $this->db->from('user_action as ua');
        $this->db->where("ua.user_from",$user);
        $this->db->where("ua.bl_active",1);
    	$query = $this->db->get()->num_rows();
	    return $query;
    }*/

    /**
     * @param null $num
     * @param null $offset
     * @param null $userId
     * @return mixed
     */
    function getPositiv($num = NULL, $offset = NULL, $userId = NULL){
        $datedUserIds = $this->getDatedUserIds($userId);
        if(empty($datedUserIds)){
            return false;
        } else {
            $this->db->select('u.*');
            $this->db->from('user as u');
            $this->db->where("u.bl_active",1);
            $this->db->where_in("id", $datedUserIds);
            if($num || $offset){
                $this->db->limit($num,$offset);
            }
            $query = $this->db->get()->result();
            return $query;
        }
    }

    /**
     * @param $userId
     * @return array
     */
    public function getDatedUserIds($userId){
        $userIdArr1 = $userIdArr2 = array();

        $result1 = $this->db->distinct()->select("invited_user_id")->from("user_dated")->where("user_id", $userId)->where('blocked', 0)->get()->result();
        foreach($result1 as $item){
            $userIdArr1[] = $item->invited_user_id;
        }

        $result2 = $this->db->distinct()->select("user_id")->from("user_dated")->where("invited_user_id", $userId)->where('blocked', 0)->get()->result();
        foreach($result2 as $item){
            $userIdArr2[] = $item->user_id;
        }
        return array_unique (array_merge ($userIdArr1, $userIdArr2));
    }

    /**
     * @param null $num
     * @param null $offset
     * @param null $userId
     * @return bool
     */
    public function getBlockedList($num = NULL, $offset = NULL, $userId = NULL){
        $blockedUserIds = $this->getBlockedUserIds($userId);
        if(empty($blockedUserIds)){
            return false;
        } else {
            $this->db->select('u.*');
            $this->db->from('user as u');
            $this->db->where("u.bl_active",1);
            $this->db->where_in("id", $blockedUserIds);
            if($num || $offset){
                $this->db->limit($num,$offset);
            }
            $query = $this->db->get()->result();
            return $query;
        }
    }

    /**
     * @param $userId
     * @return array
     */
    public function getBlockedUserIds($userId){
        $this->db->select('user_to');
        $this->db->from('user_blocked');
        $this->db->where("user_from", $userId);
        $result = $this->db->get()->result();
        $ids = array();
        foreach ($result as $item){
            $ids[] = $item->user_to;
        }
        return $ids;
    }

    /**
     * @param $userId
     * @param $clientId
     * @return bool
     */
    public function checkIsSentKiss($userId, $clientId){
        $result = $this->db->where("user_from", $clientId)
            ->where("user_to", $userId)
            ->where("bl_active", 1)
            ->where('action', 'Kiss')
            ->order_by('id DESC')
            ->limit(1)
            ->get("user_activity")->row();
        return $result ? $result->dt_create : false;
    }

    public function checkIsApproved($userId, $clientId){
        $result = $this->db->where("user_to", $userId)
            ->where("user_from", $clientId)
            ->where('action', 'AcceptedDating')
            ->where('bl_active', 1)
            ->get("user_activity")->row();
        return $result ? $result->dt_create : false;
    }

    function checkAddedToFavorite($userId1 = NULL, $userId2 = NULL){
        $result = $this->db->where('user_from', $userId2)->where('user_to', $userId1)->get('user_favorite')->row();
        return $result ? $result->dt_create : false;
    }

    public function checkSentInvitation($userId, $clientId){
        $result = $this->db->where("user_to", $userId)
            ->where("user_from", $clientId)
            ->where('action', 'Invite')
            ->where('bl_active', 1)
            ->get("user_activity")->row();
        return $result ? $result->dt_create : false;
    }

    public function checkSeeMore3Times($userId, $clientId){
        $result = $this->db->select("id")
            ->from("user_activity")
            ->where("user_from", $clientId)
            ->where("user_to", $userId)
            ->where("action", "SeeMore3Times")
            ->where("bl_active", 1)
            ->get()->num_rows();
        return $result ? true : false;
    }

    public function countSeeTimes($userId, $clientId){
        $result = $this->db->select("COUNT(id) num")->from("user_action")->where("user_from", $clientId)->where("user_to", $userId)->where("type", 1)->get()->row();
        return $result->num;
    }

    function getLastSeeTime($user = NULL, $userId = NULL){
        $result = $this->db->where('user_from', $userId)->where('user_to', $user)->where('type', 1)->order_by('id DESC')->limit(1)->get('user_action')->row();
        return $result ? $result->dt_create : false;
    }

    function checkUnreadSentMessage($user = NULL, $userId = NULL){
        $result = $this->db->where('user_from', $userId)->where('user_to', $user)->where('seen', 1)->order_by('id DESC')->limit(1)->get('user_messages')->row();
        return $result ? $result->dt_create : false;
    }

    function getLastMessageTime($user = NULL, $userId = NULL){
        $result = $this->db->where('user_from', $userId)->where('user_to', $user)->order_by('id DESC')->limit(1)->get('user_messages')->row();
        return $result ? $result->dt_create : false;
    }

    public function getNumOfNotification($userId){
        $result = $this->db->select("number_of_notification")->from("user")->where("id", $userId)->get()->row();
        return $result->number_of_notification;
    }

    public function resetNumOfNotification($userId){
        $this->db->set('number_of_notification', 0);
        $this->db->where('id', $userId);
        return $this->db->update('user');
    }
    
    /** TILBUD*/
    /**
     * @param $user
     * @return mixed
     */
    function getMyTilbud($user){
        $query = $this->db->select('po.*, pp.name, pp.image, pp.description, b2b.name as company')
                ->from('product_order_item as po')
                ->join('product_product as pp', 'pp.id = po.product_id', 'left')
                ->join('user_b2b as b2b', 'b2b.id = pp.company_id', 'left')
                ->join('product_order as p', 'p.id = po.order_id', 'left')
                ->where("p.userID",$user)
                ->where("p.bl_active",1)
                ->order_by('po.id','DESC')
                ->get()->result();
	    return $query;
    }
    
    /** IMAGES*/
    /**
     * @param null $userId
     * @param int $type
     * @param string $avatar
     * @return mixed
     */
    function getPhoto($userId = NULL, $type = 1, $avatar = ''){
        $this->db->select('*')->from('user_image');
        if($userId){
            $this->db->where("userID",$userId);
        }
        $this->db->where("type",$type);
        if($avatar != ''){
            $this->db->where('image != ',$avatar);
        }
        $query = $this->db->get()->result();
        return $query;
    }
    function getNumPhoto($user=NULL){
        $this->db->select('*')->from('user_image');
        if($user){
            $this->db->where("userID",$user);
        }
        $query = $this->db->get()->num_rows();
	    return $query;
    }
    function savePhoto($DB=NULL){
        if($this->db->insert('user_image',$DB)){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }
    
    /** INVITATION*/
    function getDating($user=NULL){
        $query = $this->db->select('dt.*')
                ->from('dating as dt')
                ->where('bl_active',1)
                ->where('userID',$user)
                ->order_by('dt.id','DESC')
                ->get()->result();
        return $query;
    }
    function getUserDating($datingID=NULL,$search=NULL){
        $query = $this->db->select('du.*, u.name, u.birthday, u.code, u.avatar, u.facebook')
                ->from('dating_user as du')
                ->join('user as u','u.id = du.user','left')
                ->where('du.datingID',$datingID)
                ->get()->result();
        return $query;
    }
    function getImageDating($datingID=NULL){
        $query = $this->db->select('di.*')
                ->from('dating_image as di')
                ->where('di.datingID',$datingID)
                ->get()->result();
        return $query;
    }
    function getDatingOrderItem($itemID=NULL){
        $query = $this->db->select('po.*, pp.name, pp.description, pp.image, pc.name as company')
                ->from('product_order_item as po')
                ->join('product_product as pp','pp.id = po.product_id','left')
                ->join('product_category as pc','pc.category_id = po.category_id','left')
                ->where('po.id',$itemID)
                ->get()->row();
        return $query;
    }
    //Delete dating
    function deleteUser($datingID=NULL){
        $this->db->where('datingID',$datingID);
        if($this->db->delete('dating_user')){
            return true;
        }else{
            return false;
        }
    }
    function deleteImage($datingID=NULL){
        $this->db->where('datingID',$datingID);
        if($this->db->delete('dating_image')){
            return true;
        }else{
            return false;
        }
    }
    function deleteDating($datingID=NULL){
        $this->db->where('id',$datingID);
        if($this->db->delete('dating')){
            return true;
        }else{
            return false;
        }
    }
    //myinvitationerjoin
    function getDatingByUser($userID=NULL){
        $query = $this->db->select('dt.*, du.id as datinguserID, du.time_start, du.time_end, du.accept, u.name as nameUser, u.avatar, u.facebook')
                ->from('dating_user as du')
                ->join('dating as dt','dt.id = du.datingID','left')
                ->join('user as u','u.id = dt.userID','left')
                ->where('du.user',$userID)
                ->where('du.time_end >=',time())
                ->order_by('dt.id','DESC')
                ->get()->result();
        return $query;
    }

    function getApprovedDatingByUser($userID=NULL){
        $query = $this->db->select('dt.*, du.id as datinguserID, du.time_start, du.time_end, du.accept, du.dt_update as accepted_time, u.name as nameUser, u.avatar, u.facebook')
            ->from('dating_user as du')
            ->join('dating as dt','dt.id = du.datingID','left')
            ->join('user as u','u.id = dt.userID','left')
            ->where('du.user',$userID)
            ->where('du.accept ', 1)
            ->where('du.bl_active ', 1)
            ->order_by('dt.id','DESC')
            ->get()->result();
        return $query;
    }

    function getSentDatingByUser($friendId=NULL, $userId){
        $query = $this->db->select('dt.*, du.id as datinguserID, du.time_start, du.time_end, du.accept, du.dt_update as replied_time, u.name as nameUser, u.avatar, u.facebook')
            ->from('dating_user as du')
            ->join('dating as dt','dt.id = du.datingID','left')
            ->join('user as u','u.id = dt.userID','left')
            ->where('du.user',$userId)
            ->where('dt.userID ', $friendId)
            ->where('du.bl_active ', 1)
            ->order_by('dt.id','DESC')
            ->get()->result();
        return $query;
    }

    function rejectDatingUser($DB, $id=NULL){
        $this->db->where('id',$id);
        if($this->db->update('dating_user', $DB)){
            return true;
        }else{
            return false;
        }
    }
    function acceptDating($DB=NULL,$id=NULL){
        if($id){
            $this->db->where('id',$id);
            $this->db->update('dating_user', $DB);
            return $id;
        }else{
            return false;
        }
    }
    //myinvitationerapproved
    function getDatingApproved($user=NULL){
        $query = $this->db->select('dt.*, du.id as datinguserID, du.time_start, du.time_end, du.accept')
                ->from('dating_user as du')
                ->join('dating as dt','dt.id = du.datingID','left')
                ->where('dt.userID',$user)
                ->where('du.accept',1)
                ->order_by('dt.id','DESC')
                ->group_by('dt.id')
                ->get()->result();
        return $query;
    }
    function getUserApproved($datingID=NULL){
        $query = $this->db->select('du.*, u.name as nameUser, u.avatar, u.facebook')
                ->from('dating_user as du')
                ->join('user as u','u.id = du.user','left')
                ->where('du.datingID',$datingID)
                ->where('du.accept',1)
                ->get()->result();
        return $query;
    }
    
    //T.Trung

    /**
     * @param int $dating_user_id
     * @return boolean
     */
    public function checkOrCreateDatedUser($dating_user_id){
        $row = $this->db->select('d.userID, du.user')
            ->from('dating as d')
            ->join('dating_user as du', 'd.id = du.datingID')
            ->where('du.id', $dating_user_id)
            ->get()->row();
        $user_id = $row->userID;
        $invited_user_id = $row->user;

        //check 2 person is dated
        $isDated = isDated($user_id, $invited_user_id);
        if($isDated === false){
            $isDated = $this->createDatedUser($user_id, $invited_user_id);
        }
        return $isDated;
    }

    /**
     * @param $user_id
     * @param $invited_user_id
     * @return mixed
     */
    public function createDatedUser($user_id, $invited_user_id){
        $data = array('user_id'=>$user_id, 'invited_user_id'=>$invited_user_id, 'accepted_time'=>time());
        $isDated = $this->db->insert('user_dated', $data);
        return $isDated;
    }

    /**
     * @param integer $num
     * @param integer $offset
     * @param integer $user
     * @param string $search
     * @return query result
     */
    function getContactPersons($num=NULL,$offset=NULL,$user=NULL,$search=NULL){
        $this->db->select('u.*');
        $this->db->from('user_dated as ud');
        $this->db->join('user as u', 'u.id = ud.invited_user_id', 'left');
        if($search['name']){
            $this->db->where('u.id LIKE "%'.$search['name'].'%" OR u.name LIKE "%'.$search['name'].'%"');
        }
        $this->db->where("ud.user_id",$user);
        $this->db->order_by('ud.id','DESC');
        if($num || $offset){
            $this->db->limit($num,$offset);
        }
        $query = $this->db->get()->result();
        return $query;
    }

    /**
     * @param null $user_id
     * @return integer
     */
    function getNumContactPersons($user_id = NULL){
        $this->db->select('ud.id');
        $this->db->from('user_dated as ud');
        $this->db->where("ud.user_id",$user_id);
        $query = $this->db->get()->num_rows();
        return $query;
    }

    /**
     * @param null $user_id
     * @return mixed
     */
    function getNumSentKiss($user_id = NULL){
        $this->db->select('id');
        $this->db->from('user_kisses');
        $this->db->where("from_user_id",$user_id);
        $query = $this->db->get()->num_rows();
        return $query;
    }

    /**
     * @param null $num
     * @param null $offset
     * @param null $user_id
     * @param null $search
     * @return mixed
     */
    function getSentKiss($num = NULL, $offset = NULL, $user_id = NULL, $search = NULL){
        $this->db->select('u.*, uk.send_at');
        $this->db->from('user_kisses as uk');
        $this->db->join('user as u', 'u.id = uk.to_user_id', 'left');
        $this->db->where("uk.from_user_id",$user_id);
        $this->db->order_by('uk.send_at','DESC');
        if($num || $offset){
            $this->db->limit($num,$offset);
        }
        $query = $this->db->get()->result();
        return $query;
    }

    /**
     * @param null $user_id
     * @return mixed
     */
    function getNumReceivedKisses($user_id = NULL){
        $this->db->select('id');
        $this->db->from('user_kisses');
        $this->db->where("to_user_id",$user_id);
        $query = $this->db->get()->num_rows();
        return $query;
    }

    /**
     * @param null $num
     * @param null $offset
     * @param null $user_id
     * @param null $search
     * @return mixed
     */
    function getReceivedKisses($num = NULL, $offset = NULL, $user_id = NULL, $search = NULL){
        $this->db->select('u.*, uk.send_at');
        $this->db->from('user_kisses as uk');
        $this->db->join('user as u', 'u.id = uk.from_user_id', 'left');
        $this->db->where("uk.to_user_id",$user_id);
        $this->db->order_by('uk.send_at','DESC');
        if($num || $offset){
            $this->db->limit($num,$offset);
        }
        $query = $this->db->get()->result();
        return $query;
    }

    /**
     * @param $category_id
     * @return mixed
     */
    function getImagesFromCatgoryId($category_id){
        $this->db->select("image");
        $this->db->from("banner_banner");
        $this->db->where("category_id", $category_id);
        $this->db->where("bl_active", 1);
        $this->db->order_by('ordering','ASC');

        $query = $this->db->get()->result();
        return $query;
    }

    /**
     * @return mixed
     */
    function getNewEvents(){
        $this->db->select("d.*, u.name, u.birthday, u.code, u.avatar");
        $this->db->from("dating as d");
        $this->db->join("user as u", "d.userID = u.id");
        $this->db->where("d.bl_active", 1);
        $this->db->where("d.times_end >= ", time());
        $this->db->where("d.type", 4);

        $result = $this->db->get()->result();
        if(empty($result)){
            return false;
        }
        $i = 0;
        foreach($result as $item){
            $images = $this->getImageDating($item->id);
            $result[$i]->image = $images[0]->image;
            $i++;
        }
        return $result;
    }

    public function isBlocked($userId, $friendId){
        $query = $this->db->where('user_from', $friendId)->where('user_to', $userId)->get('user_blocked')->num_rows();
        return $query?true:false;
    }
    public function addNotification($userId){
        $this->db->set('number_of_notification', '`number_of_notification`+1', FALSE);
        $this->db->where('id', $userId);
        return $this->db->update('user');
    }

    public function addStatus($user_from, $user_to, $action){
        $data['user_from'] = $user_from;
        $data['user_to'] = $user_to;
        $data['action'] = $action;
        $data['dt_create'] = date("Y-m-d H:i:s");
        $data['bl_active'] = 1;
        if($this->db->insert('user_activity',$data)){
            return $this->db->insert_id();
        }else{
            return false;
        }

    }

    public function disableStatus($user_from, $user_to, $action){
        $this->db->set('bl_active', 0)
            ->where("user_from", $user_from)
            ->where("user_to", $user_to)
            ->where("action", $action)
            ->update("user_activity");
    }

    //Shoutouts
    public function getNumShoutouts($userId){
        $result = $this->db->select("COUNT(id) num")
            ->from("user_shoutouts")
            ->where("userId", $userId)
            ->where("bl_active", 1)
            ->get()->row();
        return $result->num;
    }

    public function getShoutouts($num, $offset, $userId){
        $result = $this->db->select("*")
            ->from("user_shoutouts")
            ->where("userId", $userId)
            ->where("bl_active", 1)
            ->order_by("status DESC, id DESC")
            ->limit($num,$offset)
            ->get()->result();
        return $result;
    }

    /**
     * @param $shoutoutId
     * @param $userId
     * @return mixed
     */
    public function checkShoutoutOwner($shoutoutId, $userId){
        $result = $this->db->where("userId", $userId)
            ->where("id", $shoutoutId)
            ->get("user_shoutouts")
            ->num_rows();
        return $result;
    }

    /**
     * @param $shoutoutId
     */
    public function deleteShoutout($shoutoutId){
        $this->db->where("id", $shoutoutId)->delete("user_shoutouts");
    }

    public function checkUncreateShoutout($userId){
        $result = $this->db->select("uncreate_shoutout")->from("user")->where("id", $userId)->get()->row();
        return $result->uncreate_shoutout;
    }
    /**
     * @param $num
     * @return mixed
     */
    public function updateUncreateShoutout($num){
        $user = $this->session->userdata('user');
        $this->db->set('uncreate_shoutout', '`uncreate_shoutout`+'.$num, FALSE);
        $this->db->where('id', $user->id);
        return $this->db->update('user');
    }

    /**
     * @param $info
     * @return bool
     */
    public function saveShoutout($info){
        if($this->db->insert('user_shoutouts',$info)){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }

    /**
     * @param $limit
     * @return mixed
     */
    public function getShoutoutsInHome($limit){
        $result = $this->db->select("us.*, u.name, u.avatar, u.facebook")
            ->from("user_shoutouts as us")
            ->join("user as u", "us.userId = u.id")
            ->where("us.bl_active", 1)
            ->where("time_to_sec(timediff(NOW(), us.dt_create )) / 3600 <", 72)
            ->where("us.status", 1)
            ->order_by('us.id','DESC')
            ->limit($limit)
            ->get()->result();
        return $result;
    }

    /**
     * @param $userId
     * @return bool
     */
    public function checkShoutoutsStatus($userId){
        $this->db->set('status', 0);
        $this->db->where('userId', $userId);
        $this->db->where('status', 1);
        $this->db->where("time_to_sec(timediff(NOW(), dt_update )) / 3600 >", 72);
        if($this->db->update('user_shoutouts')){
            return true;
        } else {
            die('checkShoutoutsStatus is fail');
        }
    }

    public function addAcceptedNotification($userId){
        $userIdArr = array();
        $result = $this->db->select('invited_user_id')
            ->from('user_dated')
            ->where('user_id', $userId)
            ->get()->result();
        foreach($result as $user){
            $userIdArr[] = $user->invited_user_id;
        }
        $result = $this->db->select('user_id')
            ->from('user_dated')
            ->where('invited_user_id', $userId)
            ->get()->result();
        foreach($result as $user){
            $userIdArr[] = $user->user_id;
        }

        foreach ($userIdArr as $friendId){
            //Adding status in postive list
            $this->addStatus($userId, $friendId, 'AcceptedDating');
            //Adding notification in top bar
            $this->addNotification($friendId);
        }
    }

    //Get monthly fee
    public function getExpiredUsers(){
        $time = time()+86400;
        $result = $this->db->select('id, subscriptionid, expired_at, stand_by_payment, name, email')
            ->from('user')
            ->where('expired_at <', $time)
            ->where('expired_at <>', 0)
            ->get()->result();
        return $result;
    }

    /**
     * @param $userId
     */
    public function downgradeUser($userId){
        $data = array(
            'type' => 1,
            'orderid' => '',
            'payment' => 0,
            'paymenttime' => 0,
            'expired_at' => 0,
            'subscriptionid' => '',
            'price' => 0,
            'stand_by_payment' => 0
        );
        $this->db->where('id', $userId);
        $this->db->update('user', $data);
    }

    /**
     * @param $userId
     * @param $friendId
     * @return bool
     */
    public function checkAction($userId, $friendId){
        $result = $this->db->select('id')
            ->from('user_activity')
            ->where('user_from', $friendId)
            ->where('user_to', $userId)
            ->where('bl_active', 1)
            ->get()->num_rows();
        return $result?true:false;
    }

    /**
     * @param $userId
     * @param $friendId
     * @return bool
     */
    public function removeUser($userId, $friendId){
        $where = '(user_id = '.$userId.' AND invited_user_id = '.$friendId.') OR (invited_user_id = '.$userId.' AND user_id = '.$friendId.')';
        $this->db->where($where);
        if($this->db->delete('user_dated')){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param $userId
     * @param $friendId
     * @return bool
     */
    public function addUserToBlockedList($userId, $friendId){
        $data = array();
        $data['user_from']  = $userId;
        $data['user_to']    = $friendId;
        $data['dt_create']  = time();
        if($this->db->insert('user_blocked',$data)){
            return true;
        } else {
            return false;
        }
    }

    public function removeUserToBlockedList($userId, $friendId){
        $this->db->where('user_from', $userId)->where('user_to', $friendId);
        return $this->db->delete('user_blocked');
    }

    /**
     * @param $userId
     * @param $friendId
     * @param $status
     * @return bool
     */
    public function changeBlockedStatus($userId, $friendId, $status){
        $where = '(user_id = '.$userId.' AND invited_user_id = '.$friendId.') OR (invited_user_id = '.$userId.' AND user_id = '.$friendId.')';
        $this->db->set('blocked', $status);
        $this->db->set('blocked_time', time());
        $this->db->where($where);
        $query = $this->db->update('user_dated');
        if($query){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param $userId
     * @param $friendId
     * @return bool
     */
    public function blockUser($userId, $friendId){
        return $this->changeBlockedStatus($userId, $friendId, 1);
    }

    /**
     * @param $userId
     * @param $friendId
     * @return bool
     */
    public function unblockUser($userId, $friendId){
        return $this->changeBlockedStatus($userId, $friendId, 0);
    }

    /** The End*/
}