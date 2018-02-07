<?php
class Contact_Show extends CI_Controller{
    public  $_module_name='';
	function __construct()
	{
       
        parent::__construct();	
        $this->_module_name = $this->router->fetch_module();
	  	$this->session->set_userdata(array('Url'=>uri_string()));   
        $this->lang->load('contact');
		$this->load->model('contact_show_model','contact_show');
	}
	/**
	@author hieuvo
	@date create 25/09/2012
	@method load list contact show
	@return void;
	**/
	function index($current_page=0)
	{
        $this->acl->check('view','','',base_url());
        
		$data = array();
		$data['title'] = lang('ct_show.list');
        		
		$config['total_rows']   =  $this->contact_show->getNumShowContact();
		$data['num'] = $config['total_rows'];
        
		$config['per_page']  =  $this->config->item('per_page');
		$config['uri_segment'] = $this->uri->total_segments(); 
		$this->pagination->initialize($config);
        $data['pagination']    = $this->pagination->create_links();
        
		$data['list'] =   $this->contact_show->getShowContactPaging($config['per_page'],(int)$current_page);
		$data['current_page']=$current_page;
        $this->_templates['page'] = 'contact_show/contact_view';
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
		$data['rs'] = $this->contact_show->getShowContact($id);

		$data['title'] ='From: '.$data['rs']->from.' <br/>To&nbsp;&nbsp;&nbsp;&nbsp; : '.$data['rs']->to;// lang('update')." ".$data['rs']->cd_contact;
		$this->_templates['page'] = 'contact_show/contact_edit_view';
		$this->site_library->load($this->_templates['page'],$data);
	}   
	/**
	@author binh.ngo
	@date create 10/4/2012
	@method delete once category
	@return void;
	**/
	function del($id)
	{
        $this->acl->check('del','','',base_url());
        
		$current_page = (int)$this->input->post('current_page');
        
		if($this->contact_show->del($id))
			$this->session->set_flashdata('message',lang('delete_success'));
		else $this->session->set_flashdata('message',lang('delete_unsuccess'));
		
		redirect($this->_module_name.'/contact_show/index/'.$current_page);
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
				for($i = 0; $i < sizeof($ar_id); $i ++)
				{
					if ($ar_id[$i])
					{
						if($this->contact_show->del($ar_id[$i]))
							$this->session->set_flashdata('message',lang('delete_success'));
						else $this->session->set_flashdata('message',lang('delete_unsuccess'));
					}
				}
			}
		}
		redirect($this->_module_name.'/contact_show/index/'.$current_page);
	}  
}

?>