<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class District_Model extends CI_Model{
    public $language = "";
    function __construct(){
        parent::__construct();
	}
    function init($lang){
        $this->language = $lang;
    }
    function getNumData($search=NULL){
        $this->db->select('*');
        $this->db->from('city_district');
        if($search['city_id']){
            $this->db->where('city_id', $search['city_id']);
        }
        if($search['name']){
            $where = "name LIKE '%".$search['name']."%'";
            $this->db->where($where);
        }
        $query = $this->db->get()->num_rows();
        return $query;
    }
    function getAllDistrict($num=NULL,$offset=NULL,$search=NULL){
        $this->db->select('cd.*, cp.name as city');
        $this->db->from('city_district as cd');
        $this->db->join('city_province cp','cp.city_id = cd.city_id');
        if($search['city_id']){
            $this->db->where('cd.city_id', $search['city_id']);
        }
        if($search['name']){
            $where = "cd.name LIKE '%".$search['name']."%'";
            $this->db->where($where);
        }
		$this->db->order_by('cd.ordering','ASC');
        if($num || $offset){
            $this->db->limit($num,$offset);
        }
    	$query = $this->db->get()->result();
	    return $query;
    }
    function get_item_data($id=NULL){
        $this->db->select('*');
        $this->db->from('city_district');
        $this->db->where('district_id',$id);
    	$query = $this->db->get()->row();
	    return $query;
    }
    function get_item_by_city($id=NULL){
        $this->db->select('*');
        $this->db->from('city_district');
        $this->db->where('city_id',$id);
        $this->db->order_by('ordering','ASC');
    	$query = $this->db->get()->result();
        return $query;
    }
    function save_data($data=NULL,$id=NULL){
        if($id){
            $this->db->where('district_id',$id);
            $this->db->update('city_district',$data);
            return $id;
        }else{
            if($this->db->insert('city_district',$data)){
                return $this->db->insert_id();
            }else{
                return false;
            }
        }
    }
    function delete_data($id=NULL){
        $this->db->where('district_id',$id);
        if($this->db->delete('city_district')){
            return true;
        }else{
            return false;
        }
    }
}
?>