<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class B2b_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    function get_all_data($num=NULL,$offset=NULL,$search=NULL){
        $this->db->from('user_b2b');
    	$this->db->select('*');
        $this->db->where("user_b2b.bl_active <> ",-1);
        if($search['name']){
            $where = "name LIKE '%".$search['name']."%' OR id LIKE '%".$search['name']."%'";
            $this->db->where($where);
        }
    	$this->db->order_by('user_b2b.id','DESC');
        if($num || $offset){
            $this->db->limit($num,$offset);
        }
    	$result = $this->db->get();
	    return $result->result();
    }

    function get_num_data($search=NULL){
        $this->db->from('user_b2b');
    	$this->db->select('*');
        $this->db->where("user_b2b.bl_active <> ",-1);
        if($search['name']){
            $where = "name LIKE '%".$search['name']."%' OR id LIKE '%".$search['name']."%'";
            $this->db->where($where);
        }
    	$result = $this->db->get();
	    return $result->num_rows();
    }
    function save_data($data=NULL,$id=NULL){
        if($id){
            $this->db->where('id',$id);
            $this->db->update('user_b2b',$data);
            return true;
        }else{
            if($this->db->insert('user_b2b',$data)){
                return $this->db->insert_id();
            }else{
                return false;
            }
        }
    }
    function delete_data($id=NULL){
        $this->db->where('id',$id);
        if($this->db->delete('user_b2b')){
            return true;
        }else{
            return false;
        }
    }
    function get_item_data($id=NULL){
        $query = $this->db->select('*')
                ->from('user_b2b')
                ->where('user_b2b.id',$id)
                ->where("user_b2b.bl_active <> ",-1)
                ->get()->row();
	    return $query;
    }

    function export_data($from=NULL,$to=NULL){
        if($from && $to){
            $this->db->where('dt_create >=', $from);
            $this->db->where('dt_create <=', $to);
        }
        $this->db->where('bl_active', 1);
        $this->db->order_by('dt_create','DESC');
        $query = $this->db->get('user_b2b');
        return $query->result();
    }
}
?>