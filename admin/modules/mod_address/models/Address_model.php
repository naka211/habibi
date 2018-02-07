<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Address_Model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    function get_num_data($search=NULL){
        $this->db->select('*');
        $this->db->from('city_address');
        if($search['city_id']){
            $this->db->where('city_id', $search['city_id']);
        }
        if($search['district_id']){
            $this->db->where('district_id', $search['district_id']);
        }
        if($search['name']){
            $where = "name LIKE '%".$search['name']."%'";
            $this->db->where($where);
        }
        $query = $this->db->get()->num_rows();
        return $query;
    }
    function get_all_data($num=NULL,$offset=NULL,$search=NULL){
        $this->db->select('*');
        $this->db->from('city_address');
        if($search['city_id']){
            $this->db->where('city_id', $search['city_id']);
        }
        if($search['district_id']){
            $this->db->where('district_id', $search['district_id']);
        }
        if($search['name']){
            $where = "name LIKE '%".$search['name']."%'";
            $this->db->where($where);
        }
		$this->db->order_by('city_address.id','ASC');
        if($num || $offset){
            $this->db->limit($num,$offset);
        }
    	$query = $this->db->get()->result();
	    return $query;
    }
    function get_item_data($id=NULL){
        $this->db->from('city_address');
    	$this->db->select('*');
        $this->db->where('city_address.id',$id);
        $this->db->where("city_address.bl_active <> ",-1);
    	$query = $this->db->get()->row();
	    return $query;
    }
    function save_data($data=NULL,$id=NULL){
        if($id){
            $this->db->where('id',$id);
            $this->db->update('city_address',$data);
            return $id;
        }else{
            if($this->db->insert('city_address',$data)){
                return $this->db->insert_id();
            }else{
                return false;
            }
        }
    }
    function delete_data($id=NULL){
        $this->db->where('id',$id);
        if($this->db->delete('city_address')){
            return true;
        }else{
            return false;
        }
    }
}
?>