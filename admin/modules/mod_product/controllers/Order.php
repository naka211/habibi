<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Order extends CI_Controller{
    public $module_name = "";
    private $message = "";
    public $language = "";
    function __construct(){
        parent::__construct();
        $this->module_name = $this->router->fetch_module();
        $this->session->set_userdata(array('url'=>uri_string()));
        $this->load->model('category_model','category');
        $this->load->model('order_model','order');
        //$this->lang->load('order');
        $this->language = $this->lang->lang();
    }
    function index($page = 0){
        $this->check->check('view','','',base_url());
        if($this->check->check('export')){
            $data['export'] = $this->module_name.'/order/export';
        }
        //Xoa key khi search
        $this->session->unset_userdata('search');
        if($page > 0){
            $this->session->set_userdata('offset',$page);
        }else{
            $this->session->unset_userdata('offset');
        }
        $data['title'] = lang('admin.list');
        $data['page'] = 'order/list';
        $this->load->view('templates', $data);
    }
    function search(){
        if($this->input->post()){
            $name = $this->input->post('name');
            if($name){
                $search['name'] = $name;
            }else{
                $search['name'] = "";
            }
            $this->session->set_userdata('search',$search);
        }else{
            $search['name'] = "";
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
        $total = $this->order->getNumOrder($search);
        $list = $this->order->getAllOrder($limit,$offset,$search);
        if($list){
            foreach($list as $row){
                $data = new stdClass();
                $data->id = $row->id;
                $data->orderID = $row->orderID;
                $data->user = $row->user;
                $data->price = priceFormat($row->total);
                if($row->payment){
                    $data->payment = date('d-m-Y',$row->payment);
                }else{
                    $data->payment = "No payment";
                }
                $data->dt_create = $row->dt_create;
                //ACTION
                $data->action = "";
                $data->action .= icon_view_popup($this->module_name.'/order/detail/',$row->id);
                //$data->action .= ($this->check->check('edit'))?icon_edit($this->module_name.'/order/edit/'.$row->id.'/'.$offset):"";
                $data->action .= '<span id="publish'.$row->id.'">';
                $data->action .= ($this->check->check('edit'))?icon_active("'product_order'","'id'",$row->id,$row->bl_active):"";
                $data->action .= '</span>';
                if($this->check->check('del')){
                    $data->action .= '<input type="hidden" id="linkDelete-'.$row->id.'" name="linkDelete-'.$row->id.'" value="'.site_url($this->module_name."/order/del/").'"/>';
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
    function detail(){
        $data['id'] = $this->input->post('id');
        $this->load->view('order/view',$data);
	}
    function getContentDetail($id){
        if($_GET['limit']){
            $limit = $_GET['limit'];
        }else{
            $limit = 10;
        }
        $offset = $_GET['offset'];
        $search['id'] = $id;
        $total = $this->order->getNumOrderItem($search);
        $list = $this->order->getAllOrderItem($limit,$offset,$search);
        if($list){
            foreach($list as $row){
                $data = new stdClass();
                $data->id = $row->id;
                $data->product_name = $row->product_name;
                $data->quantity = $row->quantity;
                $data->subtotal = priceFormat($row->subtotal);
                $data->codes = $row->codes;
                if($row->used){
                    $data->used = "Used";
                }else{
                    $data->used = "Available";
                }
                if($row->bl_active){
                    $data->bl_active = "Checked";
                }else{
                    $data->bl_active = "No Check";
                }
                $data->dt_create = $row->dt_create;
                //ACTION
                $data->action = "";
                $data->action .= '<span id="publishPopup'.$row->id.'">';
                $data->action .= ($this->check->check('edit'))?icon_active_popup("'product_order_item'","'id'",$row->id,$row->bl_active):"";
                $data->action .= '</span>';
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
    function edit($id,$page = 0){
        
	}
    function del(){
        $check = $this->check->check('del','','');
        if($check){
            $id = $this->input->post('id',true);
            if($this->order->delete($id)){
                $this->order->deleteItem($id);
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
                    if($this->order->delete($itemid[$i])){
                        $this->order->deleteItem($itemid[$i]);
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
}
?>