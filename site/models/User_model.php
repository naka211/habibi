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
    
    function getList($num=NULL,$offset=NULL,$search=NULL,$ignore=NULL,$inUser=NULL, $type = 'random'){
        $this->db->select('u.id, u.name, u.avatar, u.ethnic_origin, u.year, u.region');
        $this->db->from('tb_user as u');
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

        if($type == 'random'){
            $this->db->order_by('u.id','RANDOM');
        }
        if($type == 'newest'){
            $this->db->order_by('u.id','DESC');
        }
        if($type == 'popular'){
            $this->db->order_by('u.visit','DESC');
            $this->db->order_by('u.id','DESC');
        }

        if($num || $offset){
            $this->db->limit($num,$offset);
        }
    	$query = $this->db->get()->result();
        //print_r($this->db->last_query());exit();
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
        $this->db->set('seen',1)->where("(user_from = $user AND user_to = $userID) OR (user_from = $userID AND user_to = $user)")->update('user_messages');

		$this->db->select('m.*, u.name, u.id as uid, u.avatar');
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

    function getNumMessages($user=NULL,$userID=NULL){
        $this->db->select('COUNT(id) as num');
        $this->db->from('user_messages');
        $this->db->where('(user_from='.$user.' AND user_to='.$userID.') OR (user_from='.$userID.' AND user_to='.$user.')');
        $query = $this->db->get();
        return $query->row()->num;
    }

    /**
     * @param null $userId
     * @return mixed
     */
    function getUnreadMessageQuantity($userId = NULL){
        $this->db->distinct();
        $this->db->select('id');
        $this->db->from('tb_user_messages');
        $this->db->group_by('user_from');
        $this->db->where('user_to', $userId);
        $this->db->where('seen', 0);
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

    function deleteMessage($user=NULL,$userID=NULL){
        $this->db->where("(user_from = $user AND user_to = $userID) OR (user_from = $userID AND user_to = $user)")->delete('user_messages');
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
     * @param null $userId
     * @param null $num
     * @param null $offset
     * @return mixed
     */
    function getFavorites($userId=NULL, $num=NULL, $offset=NULL){
        $this->db->select('u.name, u.id, u.avatar, u.region, u.ethnic_origin, u.year, uf.created_at as time_added');
        $this->db->from('user_favorite as uf');
        $this->db->join('user as u', 'u.id = uf.user_to', 'left');
        $this->db->where("uf.user_from", $userId);
		$this->db->order_by('uf.id','DESC');
        if($num || $offset){
            $this->db->limit($num, $offset);
        }
    	$query = $this->db->get()->result();
	    return $query;
    }

    /**
     * @param null $user
     * @return mixed
     */
    function getNumFavorite($user=NULL){
        $this->db->select('uf.*');
        $this->db->from('user_favorite as uf');
        $this->db->where("uf.user_from",$user);
    	$query = $this->db->get()->num_rows();
	    return $query;
    }

    /**
     * @param null $DB
     * @param null $id
     * @return bool|null
     */
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
        $query = $this->db->where('user_from', $user_id_1)->where('user_to', $user_id_2)->get('tb_user_favorite')->num_rows();
        $status->isFavorite = $query?true:false;

        $query = $this->db->where("(user_from = $user_id_1 AND user_to = $user_id_2) OR (user_from = $user_id_2 AND user_to = $user_id_1)")->select("status")->from('tb_user_friends');
        $friendStatus = $query->get()->row();
        if(!empty($friendStatus)){
            $status->isFriend = $friendStatus->status;
        } else {
            $status->isFriend = -1;
        }


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
    function sendBlink($DB=NULL){
        if($this->db->insert('user_kisses',$DB)){
            return $this->db->insert_id();
        }else{
            return false;
        }
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



    function checkAddedToFavorite($userId1 = NULL, $userId2 = NULL){
        $result = $this->db->where('user_from', $userId2)->where('user_to', $userId1)->get('user_favorite')->row();
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




    
    /** IMAGES*/
    /**
     * @param null $userId
     * @param int $type
     * @param string $avatar
     * @return mixed
     */
    function getPhoto($userId = NULL, $type = 1, $avatar = ''){
        $this->db->select('id, image')->from('user_image');
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
    

    
    //T.Trung



    /**
     * @param null $user_id
     * @return mixed
     */
    function getNumReceivedBlinks($user_id = NULL){
        $this->db->distinct();
        $this->db->select('from_user_id');
        $this->db->from('user_kisses');
        $this->db->where("to_user_id",$user_id);
        $query = $this->db->get()->num_rows();
        return $query;
    }

    /**
     * @param null $userId
     * @param null $num
     * @param null $offset
     * @param null $search
     * @return mixed
     */
    function getReceivedBlinks($userId = NULL, $num = NULL, $offset = NULL, $search = NULL){
        $this->db->set('seen',1)->where("to_user_id", $userId)->update('user_kisses');

        $this->db->select('u.name, u.id, u.avatar, u.region, u.ethnic_origin, u.year, uk.send_at as sent_time');
        $this->db->from('user_kisses as uk');
        $this->db->join('user as u', 'u.id = uk.from_user_id', 'left');
        $this->db->where("uk.to_user_id",$userId);
        $this->db->group_by("uk.from_user_id");
        $this->db->order_by('uk.id','DESC');
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
    function getNumSentBlinks($user_id = NULL){
        $this->db->distinct();
        $this->db->select('to_user_id');
        $this->db->from('user_kisses');
        $this->db->where("from_user_id",$user_id);
        $query = $this->db->get()->num_rows();
        return $query;
    }

    /**
     * @param null $userId
     * @param null $num
     * @param null $offset
     * @param null $search
     * @return mixed
     */
    function getSentBlinks($userId = NULL, $num = NULL, $offset = NULL, $search = NULL){
        $this->db->select('u.name, u.id, u.avatar, u.region, u.ethnic_origin, u.year, uk.send_at as sent_time');
        $this->db->from('user_kisses as uk');
        $this->db->join('user as u', 'u.id = uk.to_user_id', 'left');
        $this->db->where("uk.from_user_id",$userId);
        $this->db->group_by("uk.to_user_id");
        $this->db->order_by('uk.id','DESC');
        if($num || $offset){
            $this->db->limit($num,$offset);
        }
        $query = $this->db->get()->result();
        return $query;
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

    public function addToVisiting($user_id, $profile_id){
        $data = array();
        $data['from_user']  = $user_id;
        $data['to_user']    = $profile_id;
        $data['created_at']  = time();
        if($this->db->insert('tb_user_visit',$data)){
            return true;
        } else {
            return false;
        }
    }

    public function getBlinkingQuantity($user_id){
        $this->db->distinct();
        $this->db->select('id');
        $this->db->from('tb_user_kisses');
        $this->db->group_by('from_user_id');
        $this->db->where('to_user_id', $user_id);
        $this->db->where('seen', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function friendRequestQuantity($user_id){
        $this->db->select('id');
        $this->db->from('tb_user_friends');
        $this->db->where('user_to', $user_id);
        $this->db->where('status', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function addRequestAddFriend($db = null){
        if($this->db->insert('user_friends',$db)){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }

    public function cancelRequestAddFriend($user_id=NULL,$profile_id=NULL){
        $this->db->where("(user_from = $user_id AND user_to = $profile_id) OR (user_from = $profile_id AND user_to = $user_id)")->delete('user_friends');
        $this->db->where("(user_from = $user_id AND user_to = $profile_id) OR (user_from = $profile_id AND user_to = $user_id)")->delete('user_friendlist');
        return true;
    }

    public function getReceivedRequests($userId){
        $this->db->select('u.name, u.id, u.avatar, u.region, u.ethnic_origin, u.year, uf.dt_create');
        $this->db->from('user_friends as uf');
        $this->db->join('user as u', 'u.id = uf.user_from', 'left');
        $this->db->where("uf.user_to", $userId);
        $this->db->where("uf.status", 0);
        $this->db->order_by('uf.id','DESC');
        $query = $this->db->get()->result();
        return $query;
    }

    public function getSentRequests($userId){
        $this->db->select('u.name, u.id, u.avatar, u.region, u.ethnic_origin, u.year, uf.dt_create');
        $this->db->from('user_friends as uf');
        $this->db->join('user as u', 'u.id = uf.user_to', 'left');
        $this->db->where("uf.user_from", $userId);
        $this->db->where("uf.status", 0);
        $this->db->order_by('uf.id','DESC');
        $query = $this->db->get()->result();
        return $query;
    }

    public function updateFriendRequest($userId, $profileId, $status){
        $data = array(
            'status' => $status,
            'dt_update' => time()
        );
        $this->db->where('user_from', $profileId);
        $this->db->where('user_to', $userId);
        return $this->db->update('user_friends', $data);
    }

    public function insertFriendList($userId, $profileId){
        $data = array();
        $data['user_from']  = $userId;
        $data['user_to']    = $profileId;
        $data['created_at']  = time();
        $this->db->insert('user_friendlist',$data);

        $data1 = array();
        $data1['user_to']  = $userId;
        $data1['user_from']    = $profileId;
        $data1['created_at']  = time();
        $this->db->insert('user_friendlist',$data1);
    }

    /**
     * @param null $userId
     * @param null $num
     * @param null $offset
     * @return mixed
     */
    function getFriends($userId=NULL, $num=NULL, $offset=NULL){
        $this->db->select('u.name, u.id, u.avatar, u.region, u.ethnic_origin, u.year, ul.created_at as added_time');
        $this->db->from('user_friendlist as ul');
        $this->db->join('user as u', 'u.id = ul.user_to', 'inner');
        $this->db->where("ul.user_from", $userId);
        $this->db->order_by('ul.id','DESC');
        if($num || $offset){
            $this->db->limit($num, $offset);
        }
        $query = $this->db->get()->result();
        return $query;
    }

    public function getNumFriends($userId){
        $this->db->select('COUNT(id) as num');
        $this->db->from('user_friendlist');
        $this->db->where('user_from', $userId);
        $query = $this->db->get();
        return $query->row()->num;
    }

    public function getNumUserSent($userId){
        $this->db->select('DISTINCT (CASE WHEN user_from = '.$userId.' THEN user_to WHEN user_to = '.$userId.' THEN user_from END) as userId');
        $this->db->from('user_messages');
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getUserSent($userId, $num, $offset)
    {
        $this->db->select('DISTINCT (CASE WHEN user_from = ' . $userId . ' THEN user_to WHEN user_to = ' . $userId . ' THEN user_from END) as userId');
        $this->db->from('user_messages');
        $this->db->order_by('id', 'DESC');
        if ($num || $offset) {
            $this->db->limit($num, $offset);
        }
        $userIdArr = $this->db->get()->result();
        $result = array();
        if (!empty($userIdArr)) {
            foreach ($userIdArr as $key => $user) {
                if(!empty($user->userId)){
                    $this->db->select('name, id, avatar, region, ethnic_origin, year');
                    $this->db->from('user');
                    $this->db->where("id", $user->userId);
                    $result[$key] = $this->db->get()->row();

                    $this->db->select('message, seen, dt_create');
                    $this->db->from('user_messages');
                    $this->db->where("user_from = $user->userId OR user_to = $user->userId");
                    $this->db->order_by('id', 'DESC');
                    $this->db->limit(1, 0);
                    $query = $this->db->get()->row();
                    $result[$key]->message = $query->message;
                    $result[$key]->added_time = $query->dt_create;
                    $result[$key]->seen = $query->seen;
                }
            }
        }
        return $result;
    }
    /** The End*/
}