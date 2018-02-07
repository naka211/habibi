<?php

class Feedback extends CI_Controller{
    public  $_module_name='';
	function __construct()
	{
        parent::__construct();	
        $this->_module_name = $this->router->fetch_module();
	  	$this->session->set_userdata(array('Url'=>uri_string()));   
		$this->load->model('feedback_model','feedback_md');
	}
	/**
	  @author hieuvo
	  @date create 25/09/2012
	  @method load list feedback
	  @return void;
	**/
	function index($current_page=0)
	{
        $this->acl->check('view','','',base_url());
        
		$data = array();
		$data['title'] = lang('list_feedback');
		//$data['add'] = 'feedback/add';
		
		$config['total_rows']   =  $this->feedback_md->get_num_feedback();
		$data['num'] = $config['total_rows'];
		$config['per_page']  =  $this->config->item('per_page');
		$config['uri_segment'] =$this->uri->total_segments(); 
		$this->pagination->initialize($config);
		$data['list'] =   $this->feedback_md->get_all_feedback($config['per_page'],(int)$current_page);
		$data['pagination']    = $this->pagination->create_links();
        $data['current_page']=$current_page;
		$this->_templates['page'] = 'contact/feedback_view';
		$this->site_library->load($this->_templates['page'],$data);
	}
	/**
	@author binh.ngo
	@date create 10/4/2012
	@method load page edit category
	@return void;
	**/
	function edit($id)
	{
        $this->acl->check('edit','','',base_url());
        
		$data = array();
        
		$data['rs'] = $this->feedback_md->get_feedback($id);

		$data['title'] ='';// lang('update')." ".$data['rs']->cd_feedback;
		$this->_templates['page'] = 'contact/feedback_edit_view';
		$this->site_library->load($this->_templates['page'],$data);
	}   
	/**
	  @author binh.ngo
	  @date create 10/4/2012
	  @method delete once category
	  @return void;
	**/
	function del($id){
      $this->acl->check('del','','',base_url());
      
	  $current_page = (int)$this->input->post('current_page');
      
      if($this->feedback_md->del_feedback($id))
			$this->session->set_flashdata('message',lang('delete_success'));
	  else $this->session->set_flashdata('message',lang('delete_unsuccess'));
	  
	  // xóa các tin đã bo sau 3 tháng
	  $this->feedback_md->remove() ;
	  redirect($this->_module_name.'/feedback/index/'.$current_page);
  	}
  /**
	  @author binh.ngo
	  @date create 10/4/2012
	  @method delete more category
	  @return void;
	**/
    function dels()
    {
        $this->acl->check('dels','','',base_url());
      
        if(!empty($_POST['ar_id']))
        {
            $current_page = (int)$this->input->post('current_page');
            $ar_id = $this->input->post('ar_id');

            if(!empty($_POST['btn_submit']))
            {
                for($i = 0; $i < sizeof($ar_id); $i ++) {
                    if ($ar_id[$i]){
                        if($this->feedback_md->del_feedback($ar_id[$i]))
                            $this->session->set_flashdata('message',lang('delete_success'));
                        else $this->session->set_flashdata('message',lang('delete_unsuccess'));
                    }
                }
            }
        }
		redirect($this->_module_name.'/feedback/index/'.$current_page);
    }  
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */