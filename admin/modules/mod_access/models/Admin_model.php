<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Admin_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    function getAllData($num=NULL, $offset=NULL, $search=NULL){
        $query = $this->db->select('admin.*,admin_group.group_name')
                ->from('admin')
                ->join('admin_group','admin.group_id=admin_group.group_id','left')
                ->limit($num, $offset)
                ->get()->result();
        return $query;
    }
    function getNumData($search=NULL){
        $query = $this->db->select('admin.*,admin_group.group_name')
                ->from('admin')
                ->join('admin_group','admin_group.group_id=admin.group_id','left')
                ->get()->num_rows();
        return $query;
    }
    function getData($id=NULL){
        $query = $this->db->where('id',$id)->get('admin')->row();
        return $query;
    }
    function saveData($DB=NULL,$id=NULL){
        if($id){
            $query = $this->db->where('id',$id)->update('admin',$DB);
            if($query){
                return $id;
            }else{
                return false;
            }
        }else{
            $query = $this->db->insert('admin',$DB);
            if($query){                
                return $this->db->insert_id();
            }else{
                return false;
            }
        }
    }
    function deleteData($id=NULL){
        $query = $this->db->where('id',$id)->delete('admin');
        if($query){
            return true;
        }else{
            return false;
        }
    }
    function getAllGroup(){
        $query = $this->db->get('admin_group')->result();
        return $query;
    }
}
?>
