<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class User_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    function get_all_data($num=NULL,$offset=NULL,$search=NULL){
        $this->db->from('user');
    	$this->db->select('*');
        $this->db->where("user.bl_active <> ",-1);
        if($search['name']){
            $where = "name = '".$search['name']."'";
            $this->db->where($where);
        }
    	$this->db->order_by('user.id','DESC');
        if($num || $offset){
            $this->db->limit($num,$offset);
        }
    	$result = $this->db->get();
	    return $result->result();
    }

    function get_num_data($search=NULL){
        $this->db->from('user');
    	$this->db->select('*');
        $this->db->where("user.bl_active <> ",-1);
        if($search['name']){
            $where = "name = '".$search['name']."'";
            $this->db->where($where);
        }
    	$result = $this->db->get();
	    return $result->num_rows();
    }
    function save_data($data=NULL,$id=NULL){
        if($id){
            $this->db->where('id',$id);
            $this->db->update('user',$data);
            return true;
        }else{
            if($this->db->insert('user',$data)){
                return $this->db->insert_id();
            }else{
                return false;
            }
        }
    }
    function delete_data($id=NULL){
        /*$this->db->where("user_from = $id OR user_to = $id");
        $this->db->delete('user_blocked');
        $this->db->reset_query();

        $this->db->where("user_from = $id OR user_to = $id");
        $this->db->delete('user_favorite');
        $this->db->reset_query();

        $this->db->where("user_from = $id OR user_to = $id");
        $this->db->delete('user_friendlist');
        $this->db->reset_query();

        $this->db->where("user_from = $id OR user_to = $id");
        $this->db->delete('user_friends');
        $this->db->reset_query();

        $this->db->where("from_user_id = $id OR to_user_id = $id");
        $this->db->delete('user_kisses');
        $this->db->reset_query();

        $this->db->where("user_from = $id OR user_to = $id");
        $this->db->delete('user_messages');
        $this->db->reset_query();

        $this->db->where("from_user = $id OR to_user = $id");
        $this->db->delete('user_visit');
        $this->db->reset_query();

        $this->db->where("userFrom = $id OR userTo = $id");
        $this->db->delete('user_reports');
        $this->db->reset_query();*/

        $this->db->select('avatar');
        $this->db->from('user');
        $this->db->where('id', $id);
        $avatar = $this->db->get()->row()->avatar;
        echo $this->config->item('root')."uploads/user/".$avatar;
        print_r(file_exists($this->config->item('root')."uploads/user/".$avatar));exit();
        if($avatar != 'no-avatar1.png' && $avatar != 'no-avatar2.png'){
            @unlink($this->config->item('root')."uploads/user/".$avatar);
            @unlink($this->config->item('root')."uploads/thumb_user/".$avatar);
            @unlink($this->config->item('root')."uploads/raw_thumb_user/".$avatar);
        }
        $this->db->reset_query();

        $this->db->select('id, image');
        $this->db->from('user_image');
        $this->db->where('userId', $id);
        $result = $this->db->get()->result();
        foreach ($result as $image){
            @unlink($this->config->item('root')."uploads/photo/".$image->image);
            @unlink($this->config->item('root')."uploads/thumb_photo/".$image->image);
            @unlink($this->config->item('root')."uploads/raw_photo/".$image->image);
        }
        $this->db->where("userId", $id);
        $this->db->delete('user_image');
        $this->db->reset_query();

        $this->db->where('id',$id);
        if($this->db->delete('user')){
            return true;
        }else{
            return false;
        }
    }
    function get_item_data($id=NULL){
        $query = $this->db->select('*')
                ->from('user')
                ->where('user.id',$id)
                ->where("user.bl_active <> ",-1)
                ->get()->row();
	    return $query;
    }

    function export_user($from=NULL,$to=NULL){
        if($from && $to){
            $this->db->where('dt_create >=', $from);
            $this->db->where('dt_create <=', $to);
        }
        $this->db->where('bl_active', 1);
        $this->db->order_by('dt_create','DESC');
        $query = $this->db->get('user');
        return $query->result();
    }

    function updateCurrentAvatarAndDeleteNewAvatar($userId){
        $this->db->set('avatar', 'new_avatar', false);
        $this->db->where('id', $userId);
        $this->db->update('user');
        $this->db->reset_query();

        $this->deleteNewAvatar($userId);
    }

    function deleteNewAvatar($userId){
        $this->db->set('new_avatar', '');
        $this->db->where('id', $userId);
        $this->db->update('user');
    }

    function getNewAvatar($userId){
        $this->db->select('new_avatar');
        $this->db->from('user');
        $this->db->where("id",$userId);
        $new_avatar = $this->db->get()->row()->new_avatar;
        return $new_avatar;
    }

    function getCurrentAvatar($userId){
        $this->db->select('avatar');
        $this->db->from('user');
        $this->db->where("id",$userId);
        $avatar = $this->db->get()->row()->avatar;
        return $avatar;
    }

    function getUserInfo($userId){
        $this->db->select('name, email');
        $this->db->from('user');
        $this->db->where("id", $userId);
        $user = $this->db->get()->row();
        return $user;
    }
}
?>