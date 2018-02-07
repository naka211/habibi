<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class City_model extends CI_Model{
	public $language = "";
    function __construct(){
        parent::__construct();
	}
    function init($lang){
        $this->language = $lang;
    }
    function getNumData($search=NULL){
        $this->db->select('*');
        $this->db->from('city_province');
        if($search['name']){
            $where = "name LIKE '%".$search['name']."%'";
            $this->db->where($where);
        }
        $query = $this->db->get()->num_rows();
        return $query;
    }
    function getAllCity($num=NULL,$offset=NULL,$search=NULL){
        $this->db->select('*');
        $this->db->from('city_province');
        if($search['name']){
            $where = "name LIKE '%".$search['name']."%'";
            $this->db->where($where);
        }
		$this->db->order_by('ordering','ASC');
        if($num || $offset){
            $this->db->limit($num,$offset);
        }
    	$query = $this->db->get()->result();
	    return $query;
    }
    
    function getCity($id=NULL){
        $this->db->select('*');
        $this->db->from('city_province');
        $this->db->where('city_id',$id);
    	$query = $this->db->get()->row();
	    return $query;
    }
    function saveCity($DB=NULL,$id=NULL){
        if($id){
            $this->db->where('city_id',$id);
            $this->db->update('city_province',$DB);
            return $id;
        }else{
            if($this->db->insert('city_province',$DB)){
                return $this->db->insert_id();
            }else{
                return false;
            }
        }
    }
    function deleteCity($id=NULL){
        $this->db->where('city_id',$id);
        if($this->db->delete('city_province')){
            return true;
        }else{
            return false;
        }
    }
}
?>