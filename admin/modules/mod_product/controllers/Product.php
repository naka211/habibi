<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Product extends CI_Controller{
    public $module_name = "";
    private $message = "";
    public $language = "";
    function __construct(){
        parent::__construct();
        $this->module_name = $this->router->fetch_module();
        $this->session->set_userdata(array('url'=>uri_string()));
        $this->load->model('category_model','category');
        $this->load->model('product_model','product');
        //$this->lang->load('product');
        $this->language = $this->lang->lang();
    }
    function index($page = 0){
        $this->check->check('view','','',base_url());
        if($this->check->check('add')){
            $data['add'] = $this->module_name.'/product/add';
        }
        if($this->check->check('export')){
            $data['export'] = $this->module_name.'/product/export';
        }
        //Xoa key khi search
        $this->session->unset_userdata('search');
        if($page > 0){
            $this->session->set_userdata('offset',$page);
        }else{
            $this->session->unset_userdata('offset');
        }
        $data['title'] = lang('admin.list');
        $data['category'] = $this->category->get_all_category();
        $data['page'] = 'product/list';
        $this->load->view('templates', $data);
    }
    function search(){
        if($this->input->post()){
            $name = $this->input->post('name');
            $category_id = $this->input->post('category_id');
            if($name){
                $search['name'] = $name;
            }else{
                $search['name'] = "";
            }
            if($category_id){
                $search['category_id'] = $category_id;
            }else{
                $search['category_id'] = "";
            }
            $this->session->set_userdata('search',$search);
        }else{
            $search['name'] = "";
            $search['category_id'] = "";
            $this->session->unset_userdata('search');
        }
        $data['message'] = '';
        $data['status'] = true;
        header('Content-Type: application/json');
        echo json_encode($data);
        return;
	}
    function getContent(){
        if($_GET['limit']){
            $limit = $_GET['limit'];
        }else{
            $limit = 10;
        }
        if($this->session->userdata('offset')){
            $offset = $this->session->userdata('offset');
        }else{
            $offset = $_GET['offset'];
        }
        //SEARCH
        $search = $this->session->userdata('search');
        //SEARCH
        $total = $this->product->get_num_product($search);
        $list = $this->product->get_all_product($limit,$offset,$search);
        if($list){
            foreach($list as $row){
                $data = new stdClass();
                $data->id = $row->id;
                $data->name = $row->name;
                if($row->image){
                    $data->image = '<img src="'.base_url_site()."uploads/product/".$row->image.'" width="150" />';
                }else{
                    $data->image = "";
                }
                $data->description = $row->description;
                $data->price = $row->price;
                $data->nameCategory = $row->nameCategory;
                $data->dt_create = $row->dt_create;
                $data->sort = icon_sort($row->id,$row->ordering);
                //ACTION
                $data->action = "";
                //$data->action .= icon_view_popup($this->module_name.'/product/more/',$row->id);
                $data->action .= ($this->check->check('edit'))?icon_edit($this->module_name.'/product/edit/'.$row->id.'/'.$offset):"";
                $data->action .= '<span id="publish'.$row->id.'">';
                $data->action .= ($this->check->check('edit'))?icon_active("'product_product'","'id'",$row->id,$row->bl_active):"";
                $data->action .= '</span>';
                if($this->check->check('del')){
                    $data->action .= '<input type="hidden" id="linkDelete-'.$row->id.'" name="linkDelete-'.$row->id.'" value="'.site_url($this->module_name."/product/del/").'"/>';
                    $data->action .= icon_delete($row->id);
                }
                $rows[] = $data;
            }
        }else{
            $rows = array();
        }
        $return['rows'] = $rows;
        $return['total'] = $total;
        header('Content-Type: application/json');
        echo json_encode($return);
        return;
    }
    function add(){
        $this->check->check('add','','',base_url());
        $this->form_validation->set_rules('name',"Name",'trim|required');
        $this->form_validation->set_rules('category_id',"Category",'trim|required');
        $this->form_validation->set_rules('price',"Price",'trim|required');
		if($this->form_validation->run()== FALSE){
			$this->message = validation_errors();
		}else{
            $config['upload_path'] = $this->config->item('root')."uploads/product/";
    		$config['allowed_types'] = 'gif|jpg|jpeg|png';
    		$config['max_size']	= $this->config->item('maxupload');
    		$config['encrypt_name']	= TRUE;  //rename to random string image
            $this->load->library('upload', $config);
    		if(isset($_FILES['image']['name'])&&$_FILES['image']['name']!=""){
    			if ($this->upload->do_upload('image')){	
    				$data_img = $this->upload->data();
    			} else {
    				$this->session->set_flashdata('message',"Upload image failed");
                    redirect(site_url($this->module_name.'/product/add'));
    			}
    		}else {
    			$data_img['file_name'] = NULL;
    		}
            $DB['image'] = $data_img['file_name'];
            $DB['category_id'] = $this->input->post('category_id');
            $DB['company_id'] = $this->input->post('company_id');
            $DB['name'] = $this->input->post('name');
            $DB['price_old'] = $this->input->post('price_old');
            $DB['price'] = $this->input->post('price');
            $DB['quantity'] = $this->input->post('quantity');
            $DB['address'] = $this->input->post('address');
            $DB['description'] = $this->input->post('description');
            $DB['content'] = $this->input->post('content');
            $DB['map_code'] = $this->input->post('map_code');
            $DB['ordering'] = $this->input->post('ordering');
            $DB['dt_create'] = date('Y-m-d H:i:s');
            $DB['dt_end'] = strtotime(str_replace('/', '-', $this->input->post('dt_end')));
            $DB['bl_active'] = 1;
            $id = $this->product->save_product($DB);
            if($id){
                $product_img = $this->input->post('product_img');
                if($product_img){
                    for($i=0; $i<count($product_img); $i++){
                        $DBi['product_id'] = $id;
                        $DBi['image'] = $product_img[$i];
                        $DBi['dt_create'] = date('Y-m-d H:i:s');
                        $DBi['bl_active'] = 1;
                        $this->product->save_image($DBi);
                    }
                }
                $this->session->set_flashdata('message',lang('admin.save_successful'));
                redirect(site_url($this->module_name.'/product/index'));
            }else{
                $this->message = lang('admin.save_unsuccessful');
            }
        }
        $data['title'] = lang('admin.add');
        $data['category'] = $this->category->get_all_category();
        $data['company'] = $this->product->getCompany();
		$data['message'] = $this->message;
		$data['page'] = 'product/add';
        $this->load->view('templates', $data);
	}
    function edit($id,$page = 0){
        $this->check->check('edit','','',base_url());
        $this->form_validation->set_rules('name',"Name",'trim|required');
        $this->form_validation->set_rules('category_id',"Category",'trim|required');
        $this->form_validation->set_rules('price',"Price",'trim|required');
		if($this->form_validation->run()== FALSE){
			$this->message = validation_errors();
		}else{
            $config['upload_path'] = $this->config->item('root')."uploads/product/";
    		$config['allowed_types'] = 'gif|jpg|jpeg|png';
    		$config['max_size']	= $this->config->item('maxupload');
    		$config['encrypt_name']	= TRUE;  //rename to random string image
            $this->load->library('upload', $config);
    		if(isset($_FILES['image']['name'])&&$_FILES['image']['name']!=""){
    			if ($this->upload->do_upload('image')){	
    				$data_img = $this->upload->data();
                    $DB['image'] = $data_img['file_name'];
    			} else {
    				$this->session->set_flashdata('message',"Upload image failed");
                    redirect(site_url($this->module_name.'/product/edit/'.$id.'/'.$page));
    			}
    		}
            $DB['category_id'] = $this->input->post('category_id');
            $DB['company_id'] = $this->input->post('company_id');
            $DB['name'] = $this->input->post('name');
            $DB['price_old'] = $this->input->post('price_old');
            $DB['price'] = $this->input->post('price');
            $DB['quantity'] = $this->input->post('quantity');
            $DB['address'] = $this->input->post('address');
            $DB['description'] = $this->input->post('description');
            $DB['content'] = $this->input->post('content');
            $DB['map_code'] = $this->input->post('map_code');
            $DB['ordering'] = $this->input->post('ordering');
            $DB['dt_update'] = date('Y-m-d H:i:s');
            $DB['dt_end'] = strtotime(str_replace('/', '-', $this->input->post('dt_end')));
            $DB['bl_active'] = $this->input->post('bl_active');
            $id = $this->product->save_product($DB,$id);
            if($id){
                $product_img = $this->input->post('product_img');
                if($product_img){
                    for($i=0; $i<count($product_img); $i++){
                        $DBi['product_id'] = $id;
                        $DBi['image'] = $product_img[$i];
                        $DBi['dt_create'] = date('Y-m-d H:i:s');
                        $DBi['bl_active'] = 1;
                        $this->product->save_image($DBi);
                    }
                }
                $this->session->set_flashdata('message',lang('admin.save_successful'));
                redirect(site_url($this->module_name.'/product/index/'.$page));
            }else{
                $this->message = lang('admin.save_unsuccessful');
            }
        }
        $data['item'] = $this->product->get_item_product($id);
        $data['image'] = $this->product->get_image_product($id);
        $data['title'] = lang('admin.edit').": ".$data['item']->name;
        $data['category'] = $this->category->get_all_category();
        $data['company'] = $this->product->getCompany();
		$data['message'] = $this->message;
		$data['page'] = 'product/edit';
        $this->load->view('templates', $data);
	}
    function del(){
        $check = $this->check->check('del','','');
        if($check){
            $id = $this->input->post('id',true);
            if($this->product->delete_product($id)){
                $data['status'] = true;
                $data['message'] = lang('admin.delete_successful');
            }else{
                $data['status'] = false;
                $data['message'] = lang('admin.delete_unsuccessful');
            }
        }else{
            $data['status'] = false;
            $data['message'] = lang('admin.delete_unsuccessful');
        }
        header('Content-Type: application/json');
        echo json_encode($data);
        return;
    }
    function dels(){
        $this->check->check('dels','','');
        $itemid = $this->input->post('id',true);
        if($itemid){
            for($i = 0; $i < sizeof($itemid); $i++){
                if($itemid[$i]){
                    if($this->product->delete_product($itemid[$i])){
                        $data['status'] = true;
                        $data['message'] = lang('admin.delete_successful');
                    }else{
                        $data['status'] = false;
                        $data['message'] = lang('admin.delete_unsuccessful');
                    }
                }
            }
        }else{
            $data['status'] = false;
            $data['message'] = lang('admin.delete_unsuccessful');
        }	
        header('Content-Type: application/json');
        echo json_encode($data);
        return;
    }
    function export(){
        
    }
    function upload(){
        if(isset($_FILES['productimage']['name'])&&$_FILES['productimage']['name'][0]!=""){
            $config['upload_path'] = $this->config->item('root')."uploads/product/";
    		$config['allowed_types'] = 'gif|jpg|jpeg|png';
    		$config['max_size']	= $this->config->item('maxupload');
    		$config['encrypt_name']	= TRUE;  //rename to random string image
            $this->load->library('upload', $config);
            if(isset($_FILES['productimage']['name'])){
                $product_img = $this->upload->do_multi_upload('productimage');
    			if ($product_img){	
    				$product_img = $product_img;
    			}else {
                    return false;
    			}
    		}else {
    			$product_img[] = NULL;
    		}
            
            $images_arr = array();
        	foreach($_FILES['productimage']['name'] as $key=>$val){
        		$image_name = $_FILES['productimage']['name'][$key];
        		$tmp_name 	= $_FILES['productimage']['tmp_name'][$key];
        		$size 		= $_FILES['productimage']['size'][$key];
        		$type 		= $_FILES['productimage']['type'][$key];
        		$error 		= $_FILES['productimage']['error'][$key];
        		//display images without stored
        		$extra_info = getimagesize($_FILES['productimage']['tmp_name'][$key]);
            	$images_arr[] = "data:" . $extra_info["mime"] . ";base64," . base64_encode(file_get_contents($_FILES['productimage']['tmp_name'][$key]));
        	}
            if($images_arr){
                $i = 0;
        		foreach($images_arr as $image_src){ ?>
                    <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6" id="show_images_<?php echo $i;?>">
                        <img src="<?php echo $image_src;?>" width="95" height="95" alt="" class="img-responsive"/>
                        <a onclick="deleteDIV('show_images_<?php echo $i;?>');" href="javascript:void(0);" class="btn btn-sm btn-icon btn-pure btn-default on-default"
                        data-toggle="tooltip" data-original-title="Remove"><i class="icon wb-trash" aria-hidden="true"></i></a>
                        <input type="hidden" name="product_img[]" value="<?php echo $product_img[$i]['file_name'];?>" />
                    </div>
                
        	<?php $i++; }}
            return;
        }
    }
}
?>