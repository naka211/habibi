<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Api_model extends CI_Model{
	function __construct(){
        parent::__construct();
	}

    function getRows($id = ""){
        if(!empty($id)){
            $query = $this->db->get_where('user', array('id' => $id));
            return $query->row_array();
        }else{
            $query = $this->db->get('user');
            return $query->result_array();
        }
    }

    function saveToken($data){
        return $this->db->insert('user_keys', $data);
    }

    function deleteToken($userId, $token){
        return $this->db->where('user_id',$userId)->where('token', $token)->delete('user_keys');
    }

    function checkFriend($userId, $profileId){
        $query = $this->db->select("viewAvatar")
            ->from('tb_user_friendlist')
            ->where("user_from = $profileId AND user_to = $userId");
        return $query->get()->row();
    }
}
?>