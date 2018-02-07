<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Fction_Model extends CI_Model{
    function __construct() {
        parent::__construct();
    }      
    function getFunctionByModule($module_id=NULL,$num=NULL,$offset=NULL){
        $query = $this->db->where('module_id',$module_id)->get('admin_function',$num,$offset)->result(); 
        return $query;
    }
    function getNumFunctionByModule($module_id=NULL){
        $query = $this->db->where('module_id',$module_id)->get('admin_function')->num_rows(); 
        return $query;
    }
    function get_all_fction(){
        $query = $this->db->join('admin_module','admin_function.module_id = admin_module.module_id')->get('admin_function')->result();
        return $query;
    }
    function getFunctionByID($id=NULL){
        $query = $this->db->where('function_id',$id)->get('admin_function')->row();
        return $query;
    }
    function saveData($data=NULL,$id=NULL){          
        if($id){
            $this->db->where('function_id',$id);
            if($this->db->update('admin_function',$data)){
                return $id;
            }else{
                return false;
            }
        }else{
            if($this->db->insert('admin_function',$data)){
                return $this->db->insert_id();
            }else{
                return false;
            }
        }
    }
    function deleteData($id=NULL){
        $query = $this->db->where('function_id',$id)->delete('admin_right');
        $query = $this->db->where('function_id',$id)->delete('admin_function');
        if($query){
            return true;
        }else{
            return false;
        }
    }
    function getAllModule(){
        $query = $this->db->get('admin_module')->result();
        return $query;
    }
}
?>