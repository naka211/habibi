<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
    class Permission_Model extends CI_Model{
    function __construct() {
      parent::__construct();
    }      
    function getAllPermission(){
        $query = $this->db->get('admin_permission')->result();
        return $query;
    }
    function getPermissionPaging($num=NULL,$offset=NULL){
        $query = $this->db->get('admin_permission',$num,$offset)->result();
        return $query;
    }
    function getNumPermission(){
        $query = $this->db->get('admin_permission')->num_rows();
        return $query;
    }
    function getPermissionByID($id=NULL){
        $query = $this->db->where('permission_id',$id)->get('admin_permission')->row();
        return $query;
    }
    function saveData($data=NULL,$id=NULL){          
        if($id){
            $this->db->where('permission_id',$id);
            if($this->db->update('admin_permission',$data)){
                return $id;
            }else{
                return false;
            }
        }else{
            if($this->db->insert('admin_permission',$data)){
                return $this->db->insert_id();
            }else{
                return false;
            }
        }
    }
    function deleteData($id=NULL){
        $query = $this->db->where('permission_id',$id)->delete('admin_permission');
        if($query){
            return true;
        }else{
            return false;
        }
    }
}
?>