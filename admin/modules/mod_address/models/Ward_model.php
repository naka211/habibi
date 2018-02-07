<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Ward_Model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    function init($lang){
        $this->language = $lang;
    }
    function getNumData($search=NULL){
        $this->db->select('*');
        $this->db->from('city_ward');
        /*if($search['city_id']){
            $this->db->where('city_id', $search['city_id']);
        }*/
        if($search['district_id']){
            $this->db->where('city_ward.district_id', $search['district_id']);
        }
        if($search['name']){
            $where = "name LIKE '%".$search['name']."%'";
            $this->db->where($where);
        }
        $query = $this->db->get()->num_rows();
        return $query;
    }
    function getAllWard($num=NULL,$offset=NULL,$search=NULL){
        $this->db->select('city_ward.*, city_district.name as district');
        $this->db->from('city_ward');
        $this->db->join('city_district','city_district.district_id = city_ward.district_id');
        /*if($search['city_id']){
            $this->db->where('city_id', $search['city_id']);
        }*/
        if($search['district_id']){
            $this->db->where('city_ward.district_id', $search['district_id']);
        }
        if($search['name']){
            $where = "city_ward.name LIKE '%".$search['name']."%'";
            $this->db->where($where);
        }
		$this->db->order_by('city_ward.name','ASC');
        if($num || $offset){
            $this->db->limit($num,$offset);
        }
    	$query = $this->db->get()->result();
	    return $query;
    }
    function get_item_data($id=NULL){
        $this->db->select('*');
        $this->db->from('city_ward');
        $this->db->where('city_ward.ward_id',$id);
    	$query = $this->db->get()->row();
	    return $query;
    }
    function get_item_district($id){
        $this->db->select('*');
        $this->db->from('city_ward');
        $this->db->where('city_ward.district_id',$id);
        $this->db->order_by('city_ward.name','ASC');
    	$query = $this->db->get()->result();
        return $query;
    }
    function save_data($data=NULL,$id=NULL){
        if($id){
            $this->db->where('ward_id',$id);
            $this->db->update('city_ward',$data);
            return $id;
        }else{
            if($this->db->insert('city_ward',$data)){
                return $this->db->insert_id();
            }else{
                return false;
            }
        }
    }
    function delete_data($id=NULL){
        $this->db->where('ward_id',$id);
        if($this->db->delete('city_ward')){
            return true;
        }else{
            return false;
        }
    }
}
?>