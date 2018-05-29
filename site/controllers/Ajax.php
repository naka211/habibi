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

    function checkEmail(){
        $email = $this->input->post('email', true);
        $id = $this->user->getUser('', $email);
        if ($id) {
            $data['status'] = true;
        } else {
            $data['status'] = false;
        }
        header('Content-Type: application/json');
        echo json_encode($data);
        return;
    }

    /**
     * Generating age html
     */
    function generateToAgeSelection(){
        $fromAge = $this->input->post('fromAge', true);
        $htmlSelection = '';
        for($i = $fromAge + 1; $i <= 70; $i++){
            $htmlSelection .= '<option value="'.$i.'">'.$i.'</option>';
        }
        echo $htmlSelection;
        exit();
    }

    /**
     * Setting cookie for cookie information
     */
    function setCookie(){
        setcookie('ha_cookie', 1, time() + (86400 * 30), "/");
        die('ok');
    }

    /**
     * Setting cookie for panik information
     */
    function setCookiePanik(){
        setcookie('ha_panik_cookie', 1, time() + (86400 * 30), "/");
        die('ok');
    }

    function logout(){
        /** Login*/
        $Login = array('isLoginSite', 'user', 'email', 'password');
        $this->session->unset_userdata($Login);

        setcookie('cc_data', '', -time() + (86400 * 30), "/");

        die('ok');
    }

    function changeChatStatus(){
        $user = $this->session->userdata('user');
        $status = $this->input->post('status', true);
        $result = $this->db->set('chat', $status)
            ->where("id", $user->id)
            ->update("tb_user");
        if($result == false){
            die('0');
        } else {
            $user = $this->user->getUser($user->id);
            $this->session->set_userdata('user', $user);
            die('1');
        }
    }
}
?>