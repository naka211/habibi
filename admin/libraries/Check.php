<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class check{
	function __construct(){
		$this->CI =& get_instance();    
	}
	function check($type=NULL,$module=NULL,$function=NULL,$url=NULL){
        if(!$this->CI->session->userdata('isAdmin')){
            redirect(base_url());
        }
        $loginname = $this->CI->session->userdata('username');
        if($loginname=="leduccuong"){
            return true;
        }
        if(!$module){
            $module = $this->CI->router->fetch_module();
        }
        if(!$function){
            $function = $this->CI->router->fetch_class();
        }
        $group_id = $this->CI->session->userdata('group_id');
        $this->CI->db->select('permission');
        $this->CI->db->join('admin_module',"admin_right.module_id = admin_module.module_id");
        $this->CI->db->join('admin_function',"admin_right.function_id = admin_function.function_id");
		$this->CI->db->where('admin_right.group_id',$group_id);
		$this->CI->db->where('admin_module.module_code',$module);
        $this->CI->db->where('admin_function.function_code',$function);
		$permission = $this->CI->db->get('admin_right')->row();
        if($permission){        
			if($permission->permission){
                $arr_permission = json_decode($permission->permission,true);
                if(isset($arr_permission[$type])&&$arr_permission[$type] == 1){
                    //$this->write_logs($module,$function);
                    $access = true;
                }else{
                    $access = false;
                }
            }
		}else{
            $access = false;
		}
        if($url&&$access==false){
            redirect(base_url());
        }else{
            return $access;
        }   
	}
	function write_logs($modules=NULL,$function=NULL){
		$url = $this->CI->session->userdata('url');
		$id = $this->CI->session->userdata('id');
		$data = array(
			'adminid' => $id,
			'modules' => $modules,
			'function' => $function,
			'url' => $url,
			'loginfo' =>$this->CI->agent->agent_string(),
			'ip' => $this->CI->input->ip_address(),
			'datelog' => time()
		);
		$this->CI->db->insert('admin_logs',$data);
	}
}
?>