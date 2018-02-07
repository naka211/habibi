<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Group_Model extends CI_Model{
    function __construct() {
        parent::__construct();
    }      
    function getAllData($num=NULL,$offset=NULL){
        $query = $this->db->select('*')->from('admin_group')->limit($num,$offset)->get()->result();
        return $query;
    }
    function getNumData(){
        $query = $this->db->get('admin_group')->num_rows();
        return $query;
    }
    function getGroupId($id=NULl){
        $query = $this->db->where('group_id',$id)->get('admin_group')->row();
        return $query;
    }
    function saveData($data=NULL,$id=NULL){          
        if($id){
            $this->db->where('group_id',$id);
            if($this->db->update('admin_group',$data)){
                return $id;
            }else{
                return false;
            }
        }else{
            if($this->db->insert('admin_group',$data)){
                return $this->db->insert_id();
            }else{
                return false;
            }
        }
    }
    function deleteData($id=NULL){
        $query = $this->db->where('group_id',$id)->delete('admin_right');
        $query = $this->db->where('group_id',$id)->delete('admin_group');
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
    function getAllFunction($id=NULL){
        $query = $this->db->where('module_id',$id)->get('admin_function')->result();
        return $query;
    }
    function getRightFC($group_id=NULL,$module_id=NULL,$function_id=NULL){
        $this->db->where('group_id',$group_id);
        $this->db->where('module_id',$module_id);
        $query = $this->db->where('function_id',$function_id)->get('admin_right')->row();
        return $query;
    }
    function saveRight($data=NULL,$id=NULL){          
        if($id){
            $this->db->where('right_id',$id);
            if($this->db->update('admin_right',$data)){
                return $id;
            }else{
                return false;
            }
        }else{
            if($this->db->insert('admin_right',$data)){
                return $this->db->insert_id();
            }else{
                return false;
            }
        }
    }
    function getAllPermission(){
        $query = $this->db->get('admin_permission')->result();
        return $query;
    }
}
?>