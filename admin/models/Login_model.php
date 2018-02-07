<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login_Model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    function checkLogin(){
        $username = $this->input->post('username');
		$password = md5($this->input->post('password'));
        $this->db->where('username',$username);
        $this->db->where('password',$password);
        $query = $this->db->get('admin');
        if($query->row()){
             $row = $query->row_array();
             //$this->session->sess_destroy();
             //$this->session->sess_create(); 
             //Set session data 
             $this->session->set_userdata($row);
             $this->session->set_userdata(array('isAdmin' => true));               
             return true;
        }else{
             return false;
        }          
    }
}