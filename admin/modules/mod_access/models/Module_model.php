<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Module_Model extends CI_Model{
    function __construct() {
        parent::__construct();
    }
    function getAllData($num=NULL,$offset=NULL){
        $query = $this->db->get('admin_module',$num,$offset)->result();
        return $query;
    }
    function getNumData(){
        $query = $this->db->get('admin_module')->num_rows();
        return $query;
    }
    function getDataID($id=NULL){
      $query = $this->db->where('module_id',$id)->get('admin_module')->row();
      return $query;
    }
    function saveData($data=NULL,$id=NULL){          
        if($id){
            $this->db->where('module_id',$id);
            if($this->db->update('admin_module',$data)){
                return $id;
            }else{
                return false;
            }
        }else{
            if($this->db->insert('admin_module',$data)){
                return $this->db->insert_id();
            }else{
                return false;
            }
        }
    }
    function deleteData($id=NULL){
        $query = $this->db->where('module_id',$id)->delete('admin_function');
        $query = $this->db->where('module_id',$id)->delete('admin_right');
        $query = $this->db->where('module_id',$id)->delete('admin_module');
        if($query){
            return true;
        }else{
            return false;
        }
    }
    function checkCode($code=NULL,$id=NULL){
        if($id){
            $this->db->where('module_id !=',$id);
        }
        $this->db->where('module_code',$code);
        $query = $this->db->get('admin_module');
        if($query->num_rows()){
            return false;
        }else {
            return true;
        } 
    }
}
?>