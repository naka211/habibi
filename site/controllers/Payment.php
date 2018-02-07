<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Payment extends MX_Controller {
	private $language = "";
    private $message = "";
    private $action = "";
    private $merchantnumber = "";
    private $currency = "";
    private $windowstate = "";
    private $md5 = "";
    function __construct(){
        parent::__construct();
        $this->session->set_userdata(array('url'=>uri_string()));
        //$this->load->library('user_agent');
        $this->load->model('user_model', 'user');
        $this->load->model('tilbud_model','tilbud');
        $this->load->model('invita_model','invita');
        $this->language = $this->lang->lang();
        $this->action = "https://ssl.ditonlinebetalingssystem.dk/integration/ewindow/Default.aspx";
        $this->merchantnumber = "8016239";
        $this->currency = "DKK";
        $this->windowstate = "3";
        $this->md5 = "0c6f4246756c27adf3eaa80b2839484b";
    }
    function user(){
        $meta = $this->general_model->getMetaData(1);
        $data['title'] = ($meta->meta_title)?$meta->meta_title:"";
        $data['meta_title'] = ($meta->meta_title)?$meta->meta_title:"";
        $data['meta_keywords'] = ($meta->meta_keywords)?$meta->meta_keywords:"";
        $data['meta_description'] = ($meta->meta_description)?$meta->meta_description:"";
        
        $userid = $this->session->userdata('userid');
        //Go payment Epay
        $data['action'] = $this->action;
        $data['merchantnumber'] = $this->merchantnumber;
        $data['currency'] = $this->currency;
        $data['windowstate'] = $this->windowstate;
        $data['md5'] = $this->md5;
        
        $data['amount'] = number_format($this->config->item('priceuser')*100, 0, '.', '');
        $data['accepturl'] = site_url('user/success');
        $data['cancelurl'] = site_url('user/cancel');
        $data['callbackurl'] = site_url('user/callback');
		$data['orderid'] = 'US-'.randomPassword();
        
        //Update user
        /*$DB['orderid'] = $data['orderid'];
        $DB['price'] = $this->config->item('priceuser');
        $this->user->saveUser($DB,$userid);*/
        $data['page'] = 'payment/user';
		$this->load->view('templates', $data);
	}
    
    function shop(){
        $meta = $this->general_model->getMetaData(1);
        $data['title'] = ($meta->meta_title)?$meta->meta_title:"";
        $data['meta_title'] = ($meta->meta_title)?$meta->meta_title:"";
        $data['meta_keywords'] = ($meta->meta_keywords)?$meta->meta_keywords:"";
        $data['meta_description'] = ($meta->meta_description)?$meta->meta_description:"";
        if(!$this->cart->total_items()){
            redirect(site_url('tilbud/cart'));
        }
        if(!checkLogin()){
            redirect(site_url('home/index'));
        }
        //Save or update order
        //Create order
        $user = $this->session->userdata('user');
        if($this->session->userdata('orderID')){
            $DB['orderID'] = $this->session->userdata('orderID');
        }else{
            $this->session->set_userdata('orderID', 'ZE-'.randomPassword());
            $DB['orderID'] = $this->session->userdata('orderID');
        }
        $DB['userID'] = $user->id;
        $DB['total'] = $this->cart->total();
        $DB['bl_active'] = 0;
        $DB['dt_create'] = date('Y-m-d H:i:s');
        $catID = "";
        if($this->session->userdata('ID')){
            //Update order
            $this->tilbud->saveOrder($DB, $this->session->userdata('ID'));
            $this->tilbud->deleteItems($this->session->userdata('ID'));
            //Add items
            foreach ($this->cart->contents() as $row){
                $pro = $this->tilbud->getItem($row['id']);
                $DBi['order_id'] = $this->session->userdata('ID');
                $DBi['product_id'] = $row['id'];
                $DBi['category_id'] = $pro->category_id;
                $catID .= $pro->category_id.",";
                $DBi['product_name'] = $pro->name;
                $DBi['quantity'] = $row['qty'];
                $DBi['price'] = $row['price'];
                $DBi['subtotal'] = $row['price']*$row['qty'];
                $DBi['codes'] = "ZE-".randomPassword();
                $DBi['dt_create'] = date('Y-m-d H:i:s');
                $this->tilbud->addItems($DBi);
            }
            $cat['categoryID'] = $catID;
            $this->tilbud->saveOrder($cat, $this->session->userdata('ID'));
        }else{
            $ID = $this->tilbud->saveOrder($DB);
            $this->session->set_userdata('ID', $ID);
            //Add items
            foreach ($this->cart->contents() as $row){
                $pro = $this->tilbud->getItem($row['id']);
                $DBi['order_id'] = $this->session->userdata('ID');
                $DBi['product_id'] = $row['id'];
                $DBi['category_id'] = $pro->category_id;
                $catID .= $pro->category_id.",";
                $DBi['product_name'] = $pro->name;
                $DBi['quantity'] = $row['qty'];
                $DBi['price'] = $row['price'];
                $DBi['subtotal'] = $row['price']*$row['qty'];
                $DBi['codes'] = "ZE-".randomPassword();
                $DBi['dt_create'] = date('Y-m-d H:i:s');
                $this->tilbud->addItems($DBi);
            }
            $cat['categoryID'] = $catID;
            $this->tilbud->saveOrder($cat, $this->session->userdata('ID'));
        }
        //Go payment Epay
        $data['action'] = $this->action;
        $data['merchantnumber'] = $this->merchantnumber;
        $data['currency'] = $this->currency;
        $data['windowstate'] = $this->windowstate;
        $data['md5'] = $this->md5;
        
        $data['amount'] = number_format($this->cart->total()*100, 0, '.', '');
        $data['accepturl'] = site_url('tilbud/success');
        $data['cancelurl'] = site_url('tilbud/cancel');
        $data['callbackurl'] = site_url('tilbud/callback');
		$data['orderid'] = $this->session->userdata('orderID');
        
        $data['page'] = 'payment/shop';
		$this->load->view('templates', $data);
	}
    function invitationer(){
        $meta = $this->general_model->getMetaData(1);
        $data['title'] = ($meta->meta_title)?$meta->meta_title:"";
        $data['meta_title'] = ($meta->meta_title)?$meta->meta_title:"";
        $data['meta_keywords'] = ($meta->meta_keywords)?$meta->meta_keywords:"";
        $data['meta_description'] = ($meta->meta_description)?$meta->meta_description:"";
        //Go payment Epay
        $data['action'] = $this->action;
        $data['merchantnumber'] = $this->merchantnumber;
        $data['currency'] = $this->currency;
        $data['windowstate'] = $this->windowstate;
        $data['md5'] = $this->md5;
        
        $data['amount'] = number_format(29*100, 0, '.', '');
        $data['accepturl'] = site_url('invitationer/success');
        $data['cancelurl'] = site_url('invitationer/cancel');
        $data['callbackurl'] = site_url('invitationer/callback');
		$data['orderid'] = 'IN-'.randomPassword();
        
        $datingID = $this->session->userdata('datingID');
        $DB['orderid'] = $data['orderid'];
        $DB['price'] = $this->config->item('pricedating');
        $this->invita->saveDating($DB,$datingID);
        
        $data['page'] = 'payment/invitationer';
		$this->load->view('templates', $data);
    }

    function shoutout(){
        $meta = $this->general_model->getMetaData(1);
        $data['title'] = ($meta->meta_title)?$meta->meta_title:"";
        $data['meta_title'] = ($meta->meta_title)?$meta->meta_title:"";
        $data['meta_keywords'] = ($meta->meta_keywords)?$meta->meta_keywords:"";
        $data['meta_description'] = ($meta->meta_description)?$meta->meta_description:"";
        //Go payment Epay
        $data['action'] = $this->action;
        $data['merchantnumber'] = $this->merchantnumber;
        $data['currency'] = $this->currency;
        $data['windowstate'] = $this->windowstate;
        $data['md5'] = $this->md5;

        $data['amount'] = number_format(10*100, 0, '.', '');
        $data['accepturl'] = site_url('user/shoutoutSuccess');
        $data['cancelurl'] = site_url('invitationer/shoutoutCancel');
        $data['callbackurl'] = site_url('invitationer/shoutoutCallback');
        $data['orderid'] = 'SO-'.randomPassword();

        $data['page'] = 'payment/shoutout';
        $this->load->view('templates', $data);
    }

    function upgrade(){
        $userid = $this->session->userdata('userid');
        //Go payment Epay
        $data['action'] = $this->action;
        $data['merchantnumber'] = $this->merchantnumber;
        $data['currency'] = $this->currency;
        $data['windowstate'] = $this->windowstate;
        $data['md5'] = $this->md5;

        $data['amount'] = number_format($this->config->item('priceuser')*100, 0, '.', '');
        $data['accepturl'] = site_url('user/upgradeSuccess');
        $data['cancelurl'] = site_url('user/upgradeCancel');
        $data['callbackurl'] = site_url('user/upgradeCallback');
        $data['orderid'] = 'US-'.randomPassword();

        $this->session->set_userdata('payment', true);
        //Update user
        /*$DB['orderid'] = $data['orderid'];
        $DB['price'] = $this->config->item('priceuser');
        $this->user->saveUser($DB,$userid);*/
        $data['page'] = 'payment/upgrade';
        $this->load->view('templates', $data);
    }

    public function getMonthlyFee(){
        $users = $this->user->getExpiredUsers();
        if($users){
            foreach ($users as $user){
                if($user->stand_by_payment == 0){
                    $orderId = 'US-'.randomPassword();
                    $expired = strtotime('+1 month', $user->expired_at );
                    //Call payment
                    $epay_params = array();
                    $epay_params['merchantnumber'] = $this->merchantnumber;
                    $epay_params['subscriptionid'] = $user->subscriptionid;
                    $epay_params['orderid'] = $orderId;
                    $epay_params['amount'] = $this->config->item('priceuser')*100;
                    $epay_params['currency'] = "208";
                    $epay_params['instantcapture'] = "0";
                    $epay_params['fraud'] = "0";
                    $epay_params['transactionid'] = "-1";
                    $epay_params['pbsresponse'] = "-1";
                    $epay_params['epayresponse'] = "-1";

                    $client = new SoapClient('https://ssl.ditonlinebetalingssystem.dk/remote/subscription.asmx?WSDL');

                    $result = $client->authorize($epay_params);

                    if($result->authorizeResult == 1){
                        //Update info in user table
                        $DB['orderid'] = $orderId;
                        $DB['paymenttime'] = time();
                        $DB['expired_at'] = $expired;
                        $this->user->saveUser($DB, $user->id);

                        //Add log
                        $logDb['userId']    = $user->id;
                        $logDb['txnid']     = $result->txnid;
                        $logDb['orderId']   = $orderId;
                        $logDb['amount']    = $this->config->item('priceuser');
                        $id = $this->user->addLog($logDb);

                        //Send email
                        $sendEmailInfo['name']      = $user->name;
                        $sendEmailInfo['email']     = $user->email;
                        $sendEmailInfo['orderId']   = $logDb['orderid'];
                        $sendEmailInfo['price']     = $logDb['amount'].' DKK';
                        $sendEmailInfo['expired']   = date('d/m/Y', $expired);

                        $emailTo = array($user->email);
                        sendEmail($emailTo, 'withdrawMonthly',$sendEmailInfo,'');
                    } else {
                        echo($user->id.': is failed');
                    }
                } else {
                    $this->user->downgradeUser($user->id);

                    //Send email
                    $sendEmailInfo['name']      = $user->name;
                    $sendEmailInfo['email']     = $user->email;

                    $emailTo = array($user->email);
                    sendEmail($emailTo, 'downgradeUser',$sendEmailInfo,'');
                }

            }
            print_r($users);exit();
        } else {
            echo 'Nobody';
        }
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */