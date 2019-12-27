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
    function getNum($search=NULL,$ignore=NULL){
        $this->db->select('u.id');
        $this->db->from('user as u');
        $this->db->where("u.bl_active",1);
        $this->db->where("u.deactivation", 0);
        $this->db->where("u.deleted", null);
        //Search
        if(isset($search['toAge']) && !empty($search['toAge'])){
            $this->db->where('u.year >=', date('Y', time()) - $search['toAge']);
        }
        if(isset($search['fromAge']) && !empty($search['fromAge'])){
            $this->db->where('u.year <=', date('Y', time()) - $search['fromAge']);
        }
        if(isset($search['toHeight']) && !empty($search['toHeight'])){
            $this->db->where('u.height <=', $search['toHeight']);
        }
        if(isset($search['fromHeight']) && !empty($search['fromHeight'])){
            $this->db->where('u.height >=', $search['fromHeight']);
        }
        if(isset($search['toWeight']) && !empty($search['toWeight'])){
            $this->db->where('u.weight <=', $search['toWeight']);
        }
        if(isset($search['fromWeight']) && !empty($search['fromWeight'])){
            $this->db->where('u.weight >=', $search['fromWeight']);
        }
        if(isset($search['land']) && !empty($search['land'])){
            $this->db->where_in('land', $search['land']);
        }
        if(isset($search['region']) && !empty($search['region'])){
            $this->db->where_in('region', $search['region']);
        }
        if(isset($search['gender']) && !empty($search['gender'])){
            $this->db->where_in('gender', $search['gender']);
        }
        if(isset($search['relationship']) && !empty($search['relationship'])){
            $this->db->where_in('relationship', $search['relationship']);
        }
        if(isset($search['children']) && !empty($search['children'])){
            $this->db->where_in('children', $search['children']);
        }
        if(isset($search['religion']) && !empty($search['religion'])){
            $this->db->where_in('religion', $search['religion']);
        }
        if(isset($search['training']) && !empty($search['training'])){
            $this->db->where_in('training', $search['training']);
        }
        if(isset($search['body']) && !empty($search['body'])){
            $this->db->where_in('body', $search['body']);
        }
        if(isset($search['smoking']) && !empty($search['smoking'])){
            $this->db->where_in('smoking', $search['smoking']);
        }
        if(isset($search['business']) && !empty($search['business'])){
            $this->db->where_in('business', $search['business']);
        }
        if(isset($search['job_type']) && !empty($search['job_type'])){
            $this->db->where_in('job_type', $search['job_type']);
        }
        if(isset($search['hair_color']) && !empty($search['hair_color'])){
            $this->db->where_in('hair_color', $search['hair_color']);
        }
        if(isset($search['eye_color']) && !empty($search['eye_color'])){
            $this->db->where_in('eye_color', $search['eye_color']);
        }
        if(isset($search['zodiac']) && !empty($search['zodiac'])){
            $this->db->where_in('zodiac', $search['zodiac']);
        }

        if($ignore){
            //$ignore = array(12, 13);
            $this->db->where_not_in('u.id', $ignore);
        }
        $query = $this->db->get()->num_rows();
        return $query;
    }

    function getBrowsing($num=NULL,$offset=NULL,$search=NULL,$ignore=NULL){
        $this->db->select('u.name, u.id, u.avatar, u.region, u.blurIndex, u.land, u.year, u.login');
        $this->db->from('user as u');
        $this->db->where("u.bl_active",1);
        $this->db->where("u.deactivation", 0);
        $this->db->where("u.deleted", null);
        //Search
        if(isset($search['toAge']) && !empty($search['toAge'])){
            $this->db->where('u.year >=', date('Y', time()) - $search['toAge']);
        }
        if(isset($search['fromAge']) && !empty($search['fromAge'])){
            $this->db->where('u.year <=', date('Y', time()) - $search['fromAge']);
        }
        if(isset($search['toHeight']) && !empty($search['toHeight'])){
            $this->db->where('u.height <=', $search['toHeight']);
        }
        if(isset($search['fromHeight']) && !empty($search['fromHeight'])){
            $this->db->where('u.height >=', $search['fromHeight']);
        }
        if(isset($search['toWeight']) && !empty($search['toWeight'])){
            $this->db->where('u.weight <=', $search['toWeight']);
        }
        if(isset($search['fromWeight']) && !empty($search['fromWeight'])){
            $this->db->where('u.weight >=', $search['fromWeight']);
        }
        if(isset($search['land']) && !empty($search['land'])){
            $this->db->where_in('land', $search['land']);
        }
        if(isset($search['region']) && !empty($search['region'])){
            $this->db->where_in('region', $search['region']);
        }
        if(isset($search['gender']) && !empty($search['gender'])){
            $this->db->where_in('gender', $search['gender']);
        }
        if(isset($search['relationship']) && !empty($search['relationship'])){
            $this->db->where_in('relationship', $search['relationship']);
        }
        if(isset($search['children']) && !empty($search['children'])){
            $this->db->where_in('children', $search['children']);
        }
        if(isset($search['religion']) && !empty($search['religion'])){
            $this->db->where_in('religion', $search['religion']);
        }
        if(isset($search['training']) && !empty($search['training'])){
            $this->db->where_in('training', $search['training']);
        }
        if(isset($search['body']) && !empty($search['body'])){
            $this->db->where_in('body', $search['body']);
        }
        if(isset($search['smoking']) && !empty($search['smoking'])){
            $this->db->where_in('smoking', $search['smoking']);
        }
        if(isset($search['business']) && !empty($search['business'])){
            $this->db->where_in('business', $search['business']);
        }
        if(isset($search['job_type']) && !empty($search['job_type'])){
            $this->db->where_in('job_type', $search['job_type']);
        }
        if(isset($search['hair_color']) && !empty($search['hair_color'])){
            $this->db->where_in('hair_color', $search['hair_color']);
        }
        if(isset($search['eye_color']) && !empty($search['eye_color'])){
            $this->db->where_in('eye_color', $search['eye_color']);
        }
        if(isset($search['zodiac']) && !empty($search['zodiac'])){
            $this->db->where_in('zodiac', $search['zodiac']);
        }


        if($ignore){
            //$ignore = array(12, 13);
            $this->db->where_not_in('u.id', $ignore);
        }

        if(isset($search['order']) && $search['order'] == 'popular'){
            $this->db->order_by('u.visit','DESC');
            $this->db->order_by('u.id','DESC');
        } else {
            $this->db->order_by('u.id','DESC');
        }

        if($num || $offset){
            $this->db->limit($num,$offset);
        }
    	$result = $this->db->get()->result();
        //print_r($this->db->last_query());exit();
	    return $result;
    }

    
    function getList($num=NULL,$offset=NULL,$search=NULL,$ignore=NULL,$inUser=NULL, $type = 'random'){
        $this->db->select('u.id, u.name, u.avatar, u.land, u.year, u.region, u.blurIndex, u.login');
        $this->db->from('tb_user as u');
        $this->db->where("u.bl_active",1);
        $this->db->where("u.deactivation", 0);
        $this->db->where("u.deleted", null);
        /*if($search['name']){
            $this->db->where('u.id LIKE "%'.$search['name'].'%" OR u.name LIKE "%'.$search['name'].'%"');
        }*/
        if($search){
            $this->db->where('u.gender', (int)$search);
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
            $this->db->where("(email = '".$email."' OR name ='".$email."')");
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

    function checkUser($id = null, $name = null, $email = null){
        $this->db->select('id');
        $this->db->from('user');
        if($name){
            $this->db->where("name", $name);
        }
        if($email){
            $this->db->where("email", $email);
        }
        if($id){
            $this->db->where('id !=', $id);
        }
        $query = $this->db->get()->row();
        return $query;
    }



    function updateLogin($userId=NULL, $login = 1){
        if($login == 0){
            $this->db->set('expiredSessionTime', 0);
        }
        $this->db->set('login', $login);
        $this->db->where('id', $userId);
        $query = $this->db->update('user');
        if($query){
            return $query;
        }else{
            return false;
        }
	}

    function setExpireSessionTime($userId=NULL){
        $this->db->set('expiredSessionTime', strtotime("+10 minutes"));
        $this->db->where('id', $userId);
        $query = $this->db->update('user');
        if($query){
            return $query;
        }else{
            return false;
        }
    }

    function getExpiredSessionTime($userId=NULL){
        $this->db->select('expiredSessionTime');
        $this->db->from('user');
        $this->db->where("id", $userId);
        $result = $this->db->get()->row();
        return $result->expiredSessionTime;
    }

    function getLoggedInList(){
        $this->db->select('id, expiredSessionTime');
        $this->db->from('user');
        $this->db->where("login", 1);
        $result = $this->db->get()->result();
        return $result;
    }

    function saveUser($DB=NULL,$id=NULL){
        if($id){
            $this->db->where('id',$id);
            return $this->db->update('user',$DB);
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

    function updateCometMessageId($messageId, $DB=NULL){
        $this->db->where('id', $messageId);
        return $this->db->update('user_messages',$DB);
    }

    function getMessages($user=NULL,$userID=NULL,$num=NULL,$offset=NULL){
        $this->db->set('seen',1)->where("(user_from = $user AND user_to = $userID) OR (user_from = $userID AND user_to = $user)")->update('user_messages');

		$this->db->select('m.*, u.name, u.id as uid, u.avatar');
		$this->db->from('user_messages m');
        $this->db->join('user u', 'm.user_from = u.id','inner');
        $this->db->where('(m.user_from='.$user.' AND m.user_to='.$userID.') OR (m.user_from='.$userID.' AND m.user_to='.$user.')');
        $this->db->where("u.deactivation", 0);
        $this->db->where("u.deleted", null);
        $this->db->order_by('m.id DESC');
        if($num || $offset){
            $this->db->limit($num, $offset);
        }
        $query = $this->db->get();
        return $query->result();
    }

    function updateSeenMessages($user=NULL, $userID=NULL){
        $this->db->set('seen',1)->where("(user_from = $user AND user_to = $userID) OR (user_from = $userID AND user_to = $user)")->update('user_messages');
    }

    function getNumMessages($user=NULL,$userID=NULL){
        $this->db->select('COUNT(m.id) as num');
        $this->db->from('user_messages m');
        $this->db->join('user u', 'm.user_from = u.id','inner');
        $this->db->where('(m.user_from='.$user.' AND m.user_to='.$userID.') OR (m.user_from='.$userID.' AND m.user_to='.$user.')');
        $this->db->where("u.deactivation", 0);
        $this->db->where("u.deleted", null);
        $query = $this->db->get();
        return $query->row()->num;
    }

    function setSeenMessage($userId, $profileId){
        return $this->db->set('seen',1)->where("user_from = $profileId AND user_to = $userId")->update('user_messages');
    }

    /**
     * @param null $userId
     * @return mixed
     */
    function getUnreadMessageQuantity($userId = NULL){
        $ignore = $this->getBlockedUserIds($userId);
        $this->db->distinct();
        $this->db->select('id');
        $this->db->from('tb_user_messages');
        $this->db->group_by('user_from');
        $this->db->where('user_to', $userId);
        $this->db->where('seen', 0);
        if($ignore){
            $this->db->where_not_in('user_from', $ignore);
        }
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

    public function checkEmptyMessage($userId, $profileId){
        $this->db->select('id');
        $this->db->from('user_messages');
        $this->db->where("(user_from = $userId AND user_to = $profileId) OR (user_from = $profileId AND user_to = $userId)");
        $this->db->limit(1);
        $query = $this->db->get()->num_rows();
        return $query?false:true;
    }

    public function checkNewMessage($userId, $profileId){
        $this->db->select('*');
        $this->db->from('user_messages');
        $this->db->where('user_from', $profileId);
        $this->db->where('user_to', $userId);
        $this->db->where('seen', 0);
        return $this->db->get()->result();
    }
    /** FAVORITE*/
    /**
     * @param null $userId
     * @param null $num
     * @param null $offset
     * @return mixed
     */
    function getFavorites($userId=NULL, $num=NULL, $offset=NULL, $ignore = null){
        $this->db->select('u.name, u.id, u.avatar, u.region, u.land, u.year, u.blurIndex, u.login, uf.created_at as added_time');
        $this->db->from('user_favorite as uf');
        $this->db->join('user as u', 'u.id = uf.user_to', 'inner');
        $this->db->where("uf.user_from", $userId);
        $this->db->where("u.deactivation", 0);
        $this->db->where("u.deleted", null);
        if($ignore){
            $this->db->where_not_in('uf.user_to', $ignore);
        }
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
    function getNumFavorite($user=NULL, $ignore = null){
        $this->db->select('uf.*');
        $this->db->from('user_favorite as uf');
        $this->db->join('user as u', 'u.id = uf.user_to', 'inner');
        $this->db->where("uf.user_from",$user);
        $this->db->where("u.deactivation", 0);
        $this->db->where("u.deleted", null);
        if($ignore){
            $this->db->where_not_in('uf.user_to', $ignore);
        }
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

    function setBlurAvatar($userId, $profileId, $status){
        $this->db->set('viewAvatar', $status);
        $this->db->where('user_from', $userId);
        $this->db->where('user_to', $profileId);
        return $this->db->update('user_friendlist');
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
            $status->isFriend = "-1";
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
     * @param $userId
     * @param null $num
     * @param null $offset
     * @return bool
     */
    public function getBlockList($userId, $num = NULL, $offset = NULL){
        $this->db->select('u.name, u.id, u.avatar, u.region, u.ethnic_origin, u.year');
        $this->db->from('user as u');
        $this->db->join('user_blocked as ub', 'u.id = ub.user_to');
        $this->db->where("u.bl_active",1);
        $this->db->where("ub.user_from", $userId);
        if($num || $offset){
            $this->db->limit($num,$offset);
        }
        $query = $this->db->get()->result();
        return $query;
    }

    /**
     * @param $userId
     * @return array
     */
    public function getBlockedUserIds($userId){
        $this->db->select('DISTINCT (CASE WHEN user_from = '.$userId.' THEN user_to WHEN user_to = '.$userId.' THEN user_from END) as userId');
        //$this->db->where('user_from', $userId);
        $this->db->from('user_blocked');
        $result = $this->db->get()->result();

        $ids = array();
        foreach ($result as $item){
            if(!empty($item->userId)){
                $ids[] = $item->userId;
            }

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
    function getPhoto($userId = NULL, $type = 1){
        $this->db->select('id, image, status, blurIndex')->from('user_image');
        if($userId){
            $this->db->where("userID",$userId);
        }
        if($type){
            $this->db->where("status", 1);
        }
        $this->db->order_by('id', 'DESC');
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

    function getPhotoDetail($photoId){
        $this->db->select('*')->from('user_image');
        $this->db->where("id", $photoId);
        $result = $this->db->get()->row();
        return $result;
    }

    function getNewAvatar($userId){
        $this->db->select('new_avatar');
        $this->db->from('user');
        $this->db->where("id",$userId);
        $new_avatar = $this->db->get()->row()->new_avatar;
        return $new_avatar;
    }

    function getAvatar($userId){
        $this->db->select('avatar');
        $this->db->from('user');
        $this->db->where("id",$userId);
        $avatar = $this->db->get()->row()->avatar;
        return $avatar;
    }

    function updateAvatar($userId, $avatar, $new = 0){
        if($new == 1){
            $this->db->set('new_avatar', $avatar);
        } else {
            $this->db->set('new_avatar', '');
            $this->db->set('avatar', $avatar);
        }
        $this->db->set('blurIndex', 0);
        $this->db->where('id', $userId);
        return $this->db->update('user');
    }

    function updateBlurIndex($userId, $blurIndex){
        $this->db->set('blurIndex', $blurIndex);
        $this->db->where('id', $userId);
        return $this->db->update('user');
    }

    function updateBlurIndexForPhoto($imageName, $blurIndex){
        $this->db->set('blurIndex', $blurIndex);
        $this->db->where('image', $imageName);
        return $this->db->update('user_image');
    }
    
    //T.Trung



    /**
     * @param null $user_id
     * @return mixed
     */
    function getNumReceivedBlinks($user_id = NULL, $ignore = null){
        $this->db->distinct();
        $this->db->select('uk.from_user_id');
        $this->db->from('user_kisses uk');
        $this->db->join('user as u', 'u.id = uk.from_user_id', 'inner');
        $this->db->where("uk.to_user_id",$user_id);
        $this->db->where("u.deactivation", 0);
        $this->db->where("u.deleted", null);
        if($ignore){
            $this->db->where_not_in('uk.from_user_id', $ignore);
        }
        $query = $this->db->get()->num_rows();
        return $query;
    }

    /**
     * @param null $userId
     * @param null $num
     * @param null $offset
     * @param null $ignore
     * @return mixed
     */
    function getReceivedBlinks($userId = NULL, $num = NULL, $offset = NULL, $ignore = null){
        $this->db->select('u.name, u.id, u.avatar, u.region, u.ethnic_origin, u.year, u.blurIndex, u.login, uk.seen, uk.send_at as sent_time');
        $this->db->from('user_kisses as uk');
        $this->db->join('user as u', 'u.id = uk.from_user_id', 'inner');
        $this->db->where('uk.id IN (SELECT max(id) FROM tb_user_kisses WHERE uk.to_user_id = '.$userId.' GROUP BY from_user_id)');
        $this->db->where("u.deactivation", 0);
        $this->db->where("u.deleted", null);
        if($ignore){
            $this->db->where_not_in('uk.from_user_id', $ignore);
        }
        $this->db->order_by('uk.id','DESC');
        if($num || $offset){
            $this->db->limit($num,$offset);
        }
        $query = $this->db->get()->result();

        //Set seen = 1
        $this->db->set('seen',1)->where("to_user_id", $userId)->update('user_kisses');

        return $query;
    }

    /**
     * @param null $user_id
     * @return mixed
     */
    function getNumSentBlinks($user_id = NULL, $ignore = null){
        $this->db->distinct();
        $this->db->select('uk.to_user_id');
        $this->db->from('user_kisses uk');
        $this->db->join('user as u', 'u.id = uk.to_user_id', 'inner');
        $this->db->where("uk.from_user_id",$user_id);
        $this->db->where("u.deactivation", 0);
        $this->db->where("u.deleted", null);
        if($ignore){
            $this->db->where_not_in('uk.to_user_id', $ignore);
        }
        $query = $this->db->get()->num_rows();
        return $query;
    }

    /**
     * @param null $userId
     * @param null $num
     * @param null $offset
     * @param null $ignore
     * @return mixed
     */
    function getSentBlinks($userId = NULL, $num = NULL, $offset = NULL, $ignore = null){
        $this->db->select('u.name, u.id, u.avatar, u.region, u.ethnic_origin, u.year, u.blurIndex, u.login, uk.send_at as sent_time');
        $this->db->from('user_kisses as uk');
        $this->db->join('user as u', 'u.id = uk.to_user_id', 'inner');
        $this->db->where('uk.id IN (SELECT max(id) FROM tb_user_kisses WHERE uk.from_user_id = '.$userId.' GROUP BY to_user_id)');
        $this->db->where("u.deactivation", 0);
        $this->db->where("u.deleted", null);
        if($ignore){
            $this->db->where_not_in('uk.to_user_id', $ignore);
        }
        $this->db->order_by('uk.id','DESC');
        if($num || $offset){
            $this->db->limit($num,$offset);
        }
        $query = $this->db->get()->result();
        return $query;
    }

    /* Visit*/
    function getNumVisitMe($user_id = NULL, $ignore = null){
        $this->db->distinct();
        $this->db->select('uv.from_user');
        $this->db->from('user_visit uv');
        $this->db->join('user as u', 'u.id = uv.from_user', 'inner');
        $this->db->where("uv.to_user",$user_id);
        $this->db->where("u.deactivation", 0);
        $this->db->where("u.deleted", null);
        if($ignore){
            $this->db->where_not_in('uv.from_user', $ignore);
        }
        $query = $this->db->get()->num_rows();
        return $query;
    }

    function getVisitMe($userId = NULL, $num = NULL, $offset = NULL, $ignore = null){
        $this->db->select('DISTINCT(from_user)')->from('tb_user_visit')->where('to_user', $userId);
        $fromUsers = $this->db->get()->result();
        if(!empty($fromUsers)){
            $idArr = array();
            foreach ($fromUsers as $fromUser){
                $this->db->select('max(id) as id')->from('tb_user_visit')->where('to_user', $userId)->where('from_user', $fromUser->from_user);
                $idArr[] = $this->db->get()->row()->id;
            }

            $this->db->select('u.name, u.id, u.avatar, u.region, u.ethnic_origin, u.year, u.blurIndex, u.login, uv.created_at as seen_time');
            $this->db->from('user_visit as uv');
            $this->db->join('user as u', 'u.id = uv.from_user', 'inner');
            $this->db->where('uv.id IN ('.implode(',', $idArr).')');
            $this->db->where("u.deactivation", 0);
            $this->db->where("u.deleted", null);
            if($ignore){
                $this->db->where_not_in('uv.from_user', $ignore);
            }
            $this->db->order_by('uv.id', 'DESC');
            if($num || $offset){
                $this->db->limit($num,$offset);
            }
            $query = $this->db->get()->result();
            return $query;
        } else {
            return '';
        }
    }

    /*function getVisitMe($userId = NULL, $num = NULL, $offset = NULL, $ignore = null){
        $this->db->select('u.name, u.id, u.avatar, u.region, u.ethnic_origin, u.year, u.blurIndex, u.login, uv.created_at as seen_time');
        $this->db->from('user_visit as uv');
        $this->db->join('user as u', 'u.id = uv.from_user', 'inner');
        $this->db->where('uv.id IN (SELECT max(id) FROM tb_user_visit WHERE uv.to_user = '.$userId.' GROUP BY from_user)');
        $this->db->where("u.deactivation", 0);
        $this->db->where("u.deleted", null);
        if($ignore){
            $this->db->where_not_in('uv.from_user', $ignore);
        }
        $this->db->order_by('uv.id', 'DESC');
        if($num || $offset){
            $this->db->limit($num,$offset);
        }
        $query = $this->db->get()->result();
        return $query;
    }*/

    function getNumVisited($user_id = NULL, $ignore = null){
        $this->db->distinct();
        $this->db->select('uv.to_user');
        $this->db->from('user_visit uv');
        $this->db->join('user as u', 'u.id = uv.from_user', 'inner');
        $this->db->where("uv.from_user",$user_id);
        $this->db->where("u.deactivation", 0);
        $this->db->where("u.deleted", null);
        if($ignore){
            $this->db->where_not_in('uv.to_user', $ignore);
        }
        $query = $this->db->get()->num_rows();
        return $query;
    }

    function getVisited($userId = NULL, $num = NULL, $offset = NULL, $ignore = null){
        $this->db->select('DISTINCT(to_user)')->from('tb_user_visit')->where('from_user', $userId);
        $toUsers = $this->db->get()->result();
        if(!empty($toUsers)){
            $idArr = array();
            foreach ($toUsers as $toUser){
                $this->db->select('max(id) as id')->from('tb_user_visit')->where('from_user', $userId)->where('to_user', $toUser->to_user);
                $idArr[] = $this->db->get()->row()->id;
            }

            $this->db->select('u.name, u.id, u.avatar, u.region, u.ethnic_origin, u.year, u.blurIndex, u.login, uv.created_at as seen_time');
            $this->db->from('user_visit as uv');
            $this->db->join('user as u', 'u.id = uv.to_user', 'inner');
            $this->db->where('uv.id IN ('.implode(',', $idArr).')');
            $this->db->where("u.deactivation", 0);
            $this->db->where("u.deleted", null);
            if($ignore){
                $this->db->where_not_in('uv.to_user', $ignore);
            }
            $this->db->order_by('uv.id', 'DESC');
            if($num || $offset){
                $this->db->limit($num,$offset);
            }
            $query = $this->db->get()->result();
            return $query;
        } else {
            return '';
        }
    }
    /* */

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



    //Get fee
    public function getExpiredUsers(){
        $time = time()+86400;
        $result = $this->db->select('id, subscriptionid, expired_at, stand_by_payment, deactivation, name, email, price, package')
            ->from('user')
            ->where('expired_at <', $time)
            ->where('expired_at <>', 0)
            ->get()->result();
        return $result;
    }

    //Get fee
    public function getDeletedAccount(){
        $time = time() - (60*60*24*15);
        $result = $this->db->select('id')
            ->from('user')
            ->where('deleted <', $time)
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
            'package' => 0,
            'paymenttime' => 0,
            'expired_at' => 0,
            'subscriptionid' => '',
            'price' => 0,
            'stand_by_payment' => 0,
            'cardno' => ''
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

    public function removeUserToBlockList($userId, $friendId){
        $this->db->where('user_from', $userId)->where('user_to', $friendId);
        return $this->db->delete('user_blocked');
    }

    public function addToVisiting($user_id, $profile_id){
        $this->db->set('visit', 'visit+1', false);
        $this->db->where('id', $profile_id);
        $this->db->update('tb_user');

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

    public function friendRequestQuantity($userId){
        $ignore = $this->getBlockedUserIds($userId);

        $this->db->select('uf.id');
        $this->db->from('tb_user_friends uf');
        $this->db->join('user as u', 'u.id = uf.user_from', 'inner');
        $this->db->where("uf.user_to", $userId);
        $this->db->where("uf.status", 0);
        $this->db->where("u.deleted", null);

        if($ignore){
            $this->db->where_not_in('user_from', $ignore);
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function rejectRequestQuantity($userId){
        $ignore = $this->getBlockedUserIds($userId);

        $this->db->select('uf.id');
        $this->db->from('tb_user_friends uf');
        $this->db->join('user as u', 'u.id = uf.user_to', 'inner');
        $this->db->where("uf.user_from", $userId);
        $this->db->where("uf.status", 2);
        $this->db->where("u.deleted", null);

        if($ignore){
            $this->db->where_not_in('user_to', $ignore);
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function newFriendQuantity($user_id){
        $this->db->select('id');
        $this->db->from('tb_user_friendlist');
        $this->db->where('user_from', $user_id);
        $this->db->where('new', 1);
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

    public function checkExistRequest($userId, $profileId){
        $query = $this->db->where('user_from', $userId)->where('user_to', $profileId)->where('status', 0)->get('user_friends')->row();
        return $query;
    }

    public function cancelRequestAddFriend($user_id=NULL,$profile_id=NULL){
        $this->db->where("(user_from = $user_id AND user_to = $profile_id) OR (user_from = $profile_id AND user_to = $user_id)")->delete('user_friends');
        $this->db->where("(user_from = $user_id AND user_to = $profile_id) OR (user_from = $profile_id AND user_to = $user_id)")->delete('user_friendlist');
        return true;
    }

    public function getReceivedRequests($userId, $ignore = null){
        $this->db->select('u.name, u.id, u.avatar, u.region, u.ethnic_origin, u.year, u.login, u.blurIndex, uf.dt_create');
        $this->db->from('user_friends as uf');
        $this->db->join('user as u', 'u.id = uf.user_from', 'inner');
        $this->db->where("uf.user_to", $userId);
        $this->db->where("uf.status", 0);
        $this->db->where("u.deactivation", 0);
        $this->db->where("u.deleted", null);
        if($ignore){
            $this->db->where_not_in('uf.user_from', $ignore);
        }
        $this->db->order_by('uf.id','DESC');
        $query = $this->db->get()->result();
        return $query;
    }

    public function getSentRequests($userId, $ignore = null){
        $this->db->select('u.name, u.id, u.avatar, u.region, u.ethnic_origin, u.year, u.login, u.blurIndex, uf.dt_create');
        $this->db->from('user_friends as uf');
        $this->db->join('user as u', 'u.id = uf.user_to', 'inner');
        $this->db->where("uf.user_from", $userId);
        $this->db->where("uf.status", 0);
        $this->db->where("u.deactivation", 0);
        $this->db->where("u.deleted", null);
        if($ignore){
            $this->db->where_not_in('uf.user_to', $ignore);
        }
        $this->db->order_by('uf.id','DESC');
        $query = $this->db->get()->result();
        return $query;
    }

    public function getRejectedRequests($userId, $ignore = null){
        $this->db->select('u.name, u.id, u.avatar, u.region, u.ethnic_origin, u.year, u.login, u.blurIndex, uf.dt_update');
        $this->db->from('user_friends as uf');
        $this->db->join('user as u', 'u.id = uf.user_to', 'inner');
        $this->db->where("uf.user_from", $userId);
        $this->db->where("uf.status", 2);
        $this->db->where("u.deactivation", 0);
        $this->db->where("u.deleted", null);
        if($ignore){
            $this->db->where_not_in('uf.user_to', $ignore);
        }
        $this->db->order_by('uf.id','DESC');
        $result = $this->db->get()->result();
        return $result;
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

    public function reAddFriend($userId, $profileId){
        $data = array(
            'status' => 0,
            'dt_create' => time()
        );
        $this->db->where('user_from', $userId);
        $this->db->where('user_to', $profileId);
        return $this->db->update('user_friends', $data);
    }

    public function insertFriendList($userId, $profileId){
        $data = array();
        $data['user_from']  = $userId;
        $data['user_to']    = $profileId;
        $data['new']        = 1;
        $data['created_at']  = time();
        $this->db->insert('user_friendlist',$data);

        $data1 = array();
        $data1['user_to']  = $userId;
        $data1['user_from']    = $profileId;
        $data['new']        = 1;
        $data1['created_at']  = time();
        $this->db->insert('user_friendlist',$data1);
    }

    /**
     * @param null $userId
     * @param null $num
     * @param null $offset
     * @return mixed
     */
    function getFriends($userId=NULL, $num=NULL, $offset=NULL, $ignore = null, $keyword = null){
        $this->db->select('u.name, u.id, u.avatar, u.region, u.ethnic_origin, u.year, u.login, u.blurIndex, ul.created_at as added_time, ul.new, ul.viewAvatar');
        $this->db->from('user_friendlist as ul');
        $this->db->join('user as u', 'u.id = ul.user_to', 'inner');
        $this->db->where("ul.user_from", $userId);
        $this->db->where("u.deactivation", 0);
        $this->db->where("u.deleted", null);
        if($ignore){
            $this->db->where_not_in('ul.user_to', $ignore);
        }
        if($keyword){
            $this->db->like('u.name', $keyword);
        }
        $this->db->order_by('ul.id','DESC');
        if($num || $offset){
            $this->db->limit($num, $offset);
        }
        $query = $this->db->get()->result();

        //Update new
        $this->db->set('new', 0)->where('user_from', $userId)->update('user_friendlist');

        return $query;
    }

    public function getNumFriends($userId = null, $ignore = null, $keyword = null){
        $this->db->select('COUNT(ul.id) as num');
        $this->db->from('user_friendlist as ul');
        $this->db->where('ul.user_from', $userId);
        $this->db->join('user as u', 'ul.user_to = u.id', 'inner');
        $this->db->where("u.deactivation", 0);
        $this->db->where("u.deleted", null);
        if($ignore){
            $this->db->where_not_in('ul.user_to', $ignore);
        }
        if($keyword){
            $this->db->like('u.name', $keyword);
        }
        $query = $this->db->get();
        return $query->row()->num;
    }

    public function getNumUserSent($userId){
        $this->db->select('DISTINCT (CASE WHEN user_from = '.$userId.' THEN user_to WHEN user_to = '.$userId.' THEN user_from END) as userId');
        $this->db->from('user_messages');
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getUserSent($userId, $num, $offset){
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
                    $this->db->select('name, id, avatar, region, ethnic_origin, year, login, blurIndex');
                    $this->db->from('user');
                    $this->db->where("id", $user->userId);
                    $this->db->where("deactivation", 0);
                    $this->db->where("deleted", null);
                    $userInfo = $this->db->get()->row();
                    if($userInfo){
                        $result[$key] = $userInfo;

                        $this->db->select('user_from, message, messageType, seen, dt_create');
                        $this->db->from('user_messages');
                        $this->db->where("(user_from = $user->userId AND user_to = $userId) OR (user_from = $userId AND user_to = $user->userId)");
                        $this->db->order_by('id', 'DESC');
                        $this->db->limit(1, 0);
                        $query = $this->db->get()->row();
                        $result[$key]->message = $query->message;
                        $result[$key]->messageType = $query->messageType;
                        $result[$key]->added_time = $query->dt_create;
                        $result[$key]->seen = $query->seen;
                        $result[$key]->senderUID = $query->user_from;
                    }
                }
            }
        }
        return array_values($result);
    }

    public function saveReport($userFrom, $userTo, $reason){
        $data = array('userFrom'=>$userFrom,
            'userTo'=>$userTo,
            'reason'=>$reason,
            'createdAt'=>time());
        if($this->db->insert('user_reports', $data)){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }

    public function deletePhoto($photoId){
        $this->db->select('image');
        $this->db->from('user_image');
        $this->db->where('id', $photoId);
        $query = $this->db->get();
        $image = $query->row();

        unlink("./uploads/photo/".$image->image);
        unlink("./uploads/thumb_photo/".$image->image);

        unlink("./uploads/raw_photo/".$image->image);
        unlink("./uploads/raw_thumb_photo/".$image->image);

        return $this->db->where('id',$photoId)->delete('user_image');
    }

    function deleteVisited($userId = NULL, $profileId = NULL){
        $this->db->where("from_user = $userId AND to_user = $profileId")->delete('user_visit');
        return true;
    }

    function deleteVisitMe($userId = NULL, $profileId = NULL){
        $this->db->where("from_user = $profileId AND to_user = $userId")->delete('user_visit');
        return true;
    }

    function deleteBlink($userId = NULL, $profileId = NULL){
        $this->db->where("(from_user_id = $userId AND to_user_id = $profileId) OR (from_user_id = $profileId AND to_user_id = $userId)")->delete('user_kisses');
        return true;
    }
    /** The End*/
}