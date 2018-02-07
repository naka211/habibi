<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Gallery extends CI_Controller{
    public $module_name = "";
    private $message = "";
    public $language = "";
    function __construct(){
        parent::__construct();
        $this->module_name = $this->router->fetch_module();
        $this->session->set_userdata(array('url'=>uri_string()));
        $this->load->model('gallery_model','gallery');
        $this->load->model('category_model','category');
        //$this->lang->load('banner');
        $this->language = $this->lang->lang();
    }

    function index($page = 0){
        $this->check->check('view','','',base_url());
        if($this->check->check('add')){
            $data['add'] = $this->module_name.'/gallery/add';
        }
        $config['base_url'] = base_url().$this->language.'/'.$this->module_name.'/gallery/index/';
        $config['total_rows'] = $this->gallery->getNumData();
        $config['per_page'] = $this->config->item('numberpage');
        $config['num_links'] = 2;
        $config['uri_segment'] = $this->uri->total_segments();
        $this->pagination->initialize($config);
        $data['list'] = $this->gallery->getAllData($config['per_page'],(int)$page);
        $data['pagination'] = $this->pagination->create_links();
        $data['title'] = lang('admin.list');
        $data['num'] = $config['total_rows'];
        $data['currentpage'] = $page;
        $data['page'] = 'gallery/list';
        $this->load->view('templates', $data);
    }
    function add(){
        $this->check->check('add','','',base_url());
        /** Upload images*/
        if(isset($_FILES['image']['name'])&&$_FILES['image']['name'][0]!=""){
            $config['upload_path'] = $this->config->item('root')."uploads/gallery/";
    		$config['allowed_types'] = 'gif|jpg|jpeg|png';
    		$config['max_size']	= $this->config->item('maxupload');
    		$config['encrypt_name']	= TRUE;  //rename to random string image
            $this->load->library('upload', $config);
            if(isset($_FILES['image']['name'])){
                $data_img = $this->upload->do_multi_upload('image');
    			if ($data_img){	
    				$data_img = $data_img;
    			}else {
    				$data_img[] = NULL;
    			}
    		}else {
    			$data_img[] = NULL;
            }
            $images_arr = array();
        	foreach($_FILES['image']['name'] as $key=>$val){
        		$image_name = $_FILES['image']['name'][$key];
        		$tmp_name 	= $_FILES['image']['tmp_name'][$key];
        		$size 		= $_FILES['image']['size'][$key];
        		$type 		= $_FILES['image']['type'][$key];
        		$error 		= $_FILES['image']['error'][$key];
        		//display images without stored
        		$extra_info = getimagesize($_FILES['image']['tmp_name'][$key]);
            	$images_arr[] = "data:" . $extra_info["mime"] . ";base64," . base64_encode(file_get_contents($_FILES['image']['tmp_name'][$key]));
        	}
            if($images_arr){
                $i=0;
        		foreach($images_arr as $image_src){?>
                    <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6" id="show_images_<?php echo $i;?>">
                        <img src="<?php echo $image_src;?>" width="95" height="95" alt="" class="img-responsive"/>
                        <a onclick="deleteImages('show_images_<?php echo $i;?>');" href="javascript:void(0);" class="btn btn-sm btn-icon btn-pure btn-default on-default"
                        data-toggle="tooltip" data-original-title="Remove"><i class="icon wb-trash" aria-hidden="true"></i></a>
                        <input type="hidden" name="data_img[]" value="<?php echo $data_img[$i]['file_name'];?>" />
                    </div>
        	<?php $i++;}}
            return;
        }
        if($this->input->post()){
            $images = $this->input->post('data_img');
            if($images){
                for($i=0;$i<count($images);$i++){
                    $DB['image'] = $images[$i];
                    $DB['dt_create'] = date('Y-m-d H:i:s');
                    $DB['bl_active'] = 1;
                    $this->gallery->saveData($DB);
                }
            }
            $this->session->set_flashdata('message',lang('admin.save_successful'));
            redirect(site_url($this->module_name.'/gallery/index/'.$page));
        }
        $data['title'] = lang('admin.add');
        $data['category'] = $this->category->get_all_category();
		$data['message'] = $this->message;
		$data['page'] = 'gallery/add';
        $this->load->view('templates', $data);
	}
}
?>