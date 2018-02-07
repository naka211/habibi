<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Ajax extends CI_Controller{
	function __construct(){
        parent::__construct();
        $this->load->model('user_model', 'user');
	}
	function index(){
		//Nothing to do
	}
    function deleteimage(){
         $table = $this->input->post('table');
		 $field = $this->input->post('field');
		 $id = $this->input->post('id');
         $fielddelete = $this->input->post('fielddelete');
         $this->db->set($fielddelete,"");
		 $this->db->where($field,$id);
		 $this->db->update($table);
		 echo true;
         return;
	}
    function deletedata(){
        $table = $this->input->post('table');
        $id = $this->input->post('id');
        if($table == 'user_image'){
            $this->db->select('image');
            $this->db->from('user_image');
            $this->db->where('id', $id);
            $query = $this->db->get();
            $image = $query->row();
            unlink("uploads/photo/".$image->image);
        }
        $query = $this->db->where('id',$id)->delete($table);
        echo true;
        return;
	}

    /**
     *
     */
	function getKissesLog(){
        $friendId = $this->input->post('friendId');
        $user = $this->session->userdata('user');

        //Seen the kisses
        $this->user->disableStatus($friendId, $user->id, 'Kiss');

        //Load all kisses
        $data['kisses'] = $this->db->where('user_from', $friendId)
            ->where('user_to', $user->id)
            ->where('action', 'Kiss')
            ->where('status', 0)
            ->get('user_activity')->result();

        $this->load->view('ajax/kisseslog', $data);
    }

    public function deleteKissLog(){
	    $id = $this->input->post('id');

        $result = $this->db->set('status', -1)
            ->where("id", $id)
            ->update("user_activity");
        if($result == false){
            die('0');
        } else {
            die('1');
        }
    }

    function setUsedDeal(){
        $id = $this->input->post('id');
        $result = $this->db->set('used', 1)
            ->where("id", $id)
            ->update("product_order_item");
        if($result == false){
            die('0');
        } else {
            die('1');
        }
    }
}
?>