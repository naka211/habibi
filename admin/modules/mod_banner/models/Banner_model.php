<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Banner_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    /** PRODUCT----------------------------------------------------------------------*/
    function get_all_data($num=NULL,$offset=NULL,$search=NULL){
        $this->db->select('bb.*, bc.name as namecategory')
                ->from('banner_banner as bb')
                ->join('banner_category as bc', 'bc.category_id = bb.category_id', 'left');
        if($search['category_id']){
            $this->db->where('bb.category_id', $search['category_id']);
        }
        if($search['name']){
            $where = "bb.name LIKE '%".$search['name']."%' OR bb.description LIKE '%".$search['name']."%' OR bb.content LIKE '%".$search['name']."%'";
            $this->db->where($where);
        }
		$query = $this->db->order_by('bb.ordering','ASC')
                        ->limit($num,$offset)
                        ->get()->result();
	    return $query;
    }

    function get_num_data($search=NULL){
    	$this->db->select('bb.*')
                ->from('banner_banner as bb')
                ->join('banner_category as bc', 'bc.category_id = bb.category_id', 'left');
        if($search['category_id']){
            $this->db->where('bb.category_id', $search['category_id']);
        }
        if($search['name']){
            $where = "bb.name LIKE '%".$search['name']."%' OR bb.description LIKE '%".$search['name']."%' OR bb.content LIKE '%".$search['name']."%'";
            $this->db->where($where);
        }
    	$query = $this->db->get()->num_rows();
	    return $query;
    }
    function save_data($data=NULL,$id=NULL){
        if($id){
            $this->db->where('id',$id);
            $this->db->update('banner_banner',$data);
            return $id;
        }else{
            if($this->db->insert('banner_banner',$data)){
                return $this->db->insert_id();
            }else{
                return false;
            }
        }
    }
    function delete_data($id=NULL){
        $this->db->where('id',$id);
        if($this->db->delete('banner_banner')){
            return true;
        }else{
            return false;
        }
    }
    function get_item($id=NULL){
        $query = $this->db->select('*')
                    ->from('banner_banner')
                    ->where('banner_banner.id',$id)
                    ->get()->row();
	    return $query;
    }
}
?>
