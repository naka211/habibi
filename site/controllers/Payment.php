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
    function upgrade(){
        $user = $this->session->userdata('user');
        $package = $this->input->post('package');

        $db['package'] = $package;
        $this->user->saveUser($db, $user->id);

        if($package == 1){
            $packageName = 'price1Month';
        } else if($package == 3) {
            $packageName = 'price3Months';
        } else if($package == 6) {
            $packageName = 'price6Months';
        } else {
            $packageName = 'test';
        }
        //Go payment Epay

        $data['merchantnumber'] = $this->merchantnumber;
        $data['currency'] = $this->currency;
        $data['windowstate'] = $this->windowstate;

        $data['amount'] = number_format($this->config->item($packageName)*100, 0, ',', '.');
        $data['accepturl'] = site_url('user/upgradeSuccess');
        $data['cancelurl'] = site_url('user/upgradeCancel');
        $data['callbackurl'] = site_url('user/upgradeCallback');
        $data['orderid'] = randomPassword();

        $data['page'] = 'payment/upgrade';
        $this->load->view('templates', $data);
    }

    function changeCard(){
        $userid = $this->session->userdata('userid');
        //Go payment Epay

        $data['merchantnumber'] = $this->merchantnumber;
        $data['currency'] = $this->currency;
        $data['windowstate'] = $this->windowstate;

        $data['amount'] = 0;
        $data['accepturl'] = site_url('user/changeCardSuccess');
        $data['cancelurl'] = site_url('user/changeCardCancel');
        $data['callbackurl'] = site_url('user/changeCardCallback');
        $data['orderid'] = randomPassword();

        $data['page'] = 'payment/upgrade';
        $this->load->view('templates', $data);
    }

    public function getFee(){
        $users = $this->user->getExpiredUsers();
        if($users){
            foreach ($users as $user){
                if($user->stand_by_payment != 2){
                    $orderId = 'US-'.randomPassword();

                    if($user->package == 1){
                        $packageName = 'price1Month';
                        $plusTime = '+1 month';
                    } else if($user->package == 3) {
                        $packageName = 'price3Months';
                        $plusTime = '+3 months';
                    } else if($user->package == 6) {
                        $packageName = 'price6Months';
                        $plusTime = '+6 months';
                    } else {
                        $packageName = 'test';
                        $plusTime = '+1 day';
                    }

                    $expired = strtotime($plusTime, $user->expired_at);
                    //Call payment
                    $epay_params = array();
                    $epay_params['merchantnumber'] = $this->merchantnumber;
                    $epay_params['subscriptionid'] = $user->subscriptionid;
                    $epay_params['orderid'] = $orderId;
                    $epay_params['amount'] = $this->config->item($packageName)*100;
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
                        if($user->stand_by_payment == 1){
                            $DB['stand_by_payment'] = 2;
                        }
                        $this->user->saveUser($DB, $user->id);

                        //Add log
                        $logDb['userId']    = $user->id;
                        $logDb['txnid']     = $result->transactionid;
                        $logDb['orderId']   = $orderId;
                        $logDb['amount']    = $this->config->item($packageName);
                        $id = $this->user->addLog($logDb);

                        //Send email
                        $sendEmailInfo['name']      = $user->name;
                        $sendEmailInfo['email']     = $user->email;
                        $sendEmailInfo['orderId']   = $orderId;
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