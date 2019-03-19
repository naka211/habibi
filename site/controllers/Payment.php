<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Payment extends MX_Controller {
	private $language = "";
    private $message = "";
    private $_meta = null;
    function __construct(){
        parent::__construct();
        $this->session->set_userdata(array('url'=>uri_string()));
        //$this->load->library('user_agent');
        $this->load->model('user_model', 'user');
        /*$this->load->model('tilbud_model','tilbud');
        $this->load->model('invita_model','invita');*/
        $this->language = $this->lang->lang();

        $this->_meta = $this->general_model->getMetaDataFromUrl();
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
        //Go payment Quickpay

        $data['orderid'] = randomPassword();
        $data['amount'] = $this->config->item($packageName)*100;
        $data['continueurl'] = site_url('payment/upgradeSuccess/'.$user->id);
        $data['cancelurl'] = site_url('payment/upgradeCancel');
        $data['callbackurl'] = site_url('payment/upgradeCallback/'.$user->id);

        $data['page'] = 'payment/upgrade';
        $this->load->view('templates', $data);
    }

    function changeCard(){
        //$userid = $this->session->userdata('userid');
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

    public function upgradeSuccess($userId){
        $data = array();
        $this->user->addMeta($this->_meta, $data);

        $user = $this->user->getUser($userId);
        if($user->package == 1){
            $plusTime = '+1 month';
        } else if($user->package == 3){
            $plusTime = '+3 months';
        } else if($user->package == 6){
            $plusTime = '+6 months';
        } else {
            $plusTime = '+1 day';
        }

        $DB['type'] = 2;
        $DB['paymenttime'] = time();
        $DB['expired_at'] = strtotime($plusTime, $DB['paymenttime']);
        $this->user->saveUser($DB, $userId);

        $data['page'] = 'user/upgradeSuccess';
        $this->load->view('templates', $data);
    }

    public function upgradeCancel(){
        customRedirectWithMessage(site_url('user/index'), 'Din betaling mislykkedes');
    }

    public function upgradeCallback($userId){
        $requestBody = file_get_contents("php://input");
        $request = json_decode($requestBody);

        // Check checksum
        /*$key = '196543afab47e2f8552ee61d99f658562937118aaa709d458943e20c110764e3';
        $checksum = hash_hmac("sha256", $requestBody, $key);
        if ($checksum != $_SERVER["HTTP_QUICKPAY_CHECKSUM_SHA256"]) {
            return null;
        }*/

        $user = $this->user->getUser($userId);
        $operation = end($request->operations);
        $metadata = $request->metadata;
        //Update payment
        $DB['price'] = $operation->amount/100;
        $DB['subscriptionid'] = $request->id;
        $DB['orderid'] = $request->order_id;
        $DB['cardno']    = $metadata->bin.'XXXXXX'.$metadata->last4;
        $this->user->saveUser($DB, $userId);
        //Add to log
        //$this->addPaymentLog($userId);

        //Send email
        $sendEmailInfo['name']      = $user->name;
        $sendEmailInfo['email']     = $user->email;
        $sendEmailInfo['orderId']   = $DB['orderid'];
        $sendEmailInfo['price']     = $DB['price'].' DKK';
        $sendEmailInfo['expired']   = date('d/m/Y', $DB['expired_at']);
        $emailTo = array($user->email);
        sendEmail($emailTo,'upgradeGoldMember',$sendEmailInfo,'');

        return true;
    }

    public function changeCardSuccess(){
        $user = $this->session->userdata('user');

        //Update card info
        $DB['subscriptionid'] = $this->input->get('subscriptionid');
        $DB['cardno']    = $this->input->get('cardno');
        $this->user->saveUser($DB, $user->id);

        customRedirectWithMessage(site_url('user/update'), 'Ændring af kortoplysningerne');
    }

    public function changeCardCancel(){
        customRedirectWithMessage(site_url('user/update'), 'Ændring af kortoplysningerne fejler');
    }

    public function changeCardCallback(){

    }

    public function addPaymentLog($userId){
        if($this->input->get('txnid')){
            $logDb['userId']    = $userId;
            $logDb['txnid']     = $this->input->get('txnid');
            $logDb['orderId']   = $this->input->get('orderid');
            $logDb['amount']    = $this->input->get('amount')/100;
            $logDb['currency']  = $this->input->get('currency');
            $logDb['date']      = $this->input->get('date');
            $logDb['time']      = $this->input->get('time');
            $logDb['hash']      = $this->input->get('hash');
            $logDb['txnfee']    = $this->input->get('txnfee');
            $logDb['cardno']    = $this->input->get('cardno');
            $id = $this->user->addLog($logDb);
            if($id == false){
                customRedirectWithMessage(site_url('user/index'), 'Fejl ved lagring af log');
            }
        } else {
            customRedirectWithMessage(site_url('user/index'), 'Kan ikke finde betalingsoplysninger');
        }
    }

    public function testRecurring(){
        $order_id = randomPassword();
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.quickpay.net/subscriptions/142737268/recurring');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"amount\":9900,\"order_id\":\"".$order_id."\"}");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_USERPWD, '' . ':' . 'c9150af0dff909ed414cc9373239be48288b3e4aabe8b60d7674a2832159d45f');

        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Accept-Version: v10';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);print_r($result);exit();
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close ($ch);

    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */