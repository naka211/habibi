<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ajax_model extends CI_Model{

	function __construct(){
        parent::__construct();
	}

    function getShoutout($id = NULL){
        $result = $this->db->select("us.*, u.name, u.email")
            ->from("user_shoutouts as us")
            ->join("user as u", "us.userId = u.id")
            ->where('us.id', $id)
            ->get()->row();
        return $result;
    }
}
?>