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
        $data['description'] = 'gold-member';
        if($user->first_payment == 0){
            $data['amount'] = 0;
        } else {
            $data['amount'] = $this->config->item($packageName)*100;
        }
        $data['continueurl'] = site_url('payment/upgradeSuccess/'.$user->id);
        $data['cancelurl'] = site_url('payment/upgradeCancel');
        $data['callbackurl'] = site_url('payment/upgradeCallback/'.$user->id);

        $data['page'] = 'payment/upgrade';
        $this->load->view('templates', $data);
    }

    public function upgradeSuccess($userId){
        $data = array();
        $this->user->addMeta($this->_meta, $data);

        $user = $this->user->getUser($userId);
        if($user->package == 1){
            $plusTime = '+3 months';
        } else if($user->package == 3){
            $plusTime = '+3 months';
        } else if($user->package == 6){
            $plusTime = '+6 months';
        } else {
            $plusTime = '+1 day';
        }

        $DB['type'] = 2;
        $DB['first_payment'] = 1;
        $DB['paymenttime'] = time();
        $DB['expired_at'] = strtotime($plusTime, time());
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
        $this->addPaymentLog($userId, $request);

        //Send email
        $sendEmailInfo['name']      = $user->name;
        $sendEmailInfo['email']     = $user->email;
        $sendEmailInfo['orderId']   = $DB['orderid'];
        $sendEmailInfo['price']     = $DB['price'].' DKK';
        $sendEmailInfo['expired']   = date('d/m/Y', strtotime('+3 months', time()));
        $emailTo = array($user->email);
        sendEmail($emailTo,'upgradeGoldMember',$sendEmailInfo,'');

        return true;
    }

    function changeCard(){
        $user = $this->session->userdata('user');

        $data['amount'] = 0;
        $data['description'] = 'change-card';
        $data['continueurl'] = site_url('user/changeCardSuccess');
        $data['cancelurl'] = site_url('user/changeCardCancel');
        $data['callbackurl'] = site_url('user/changeCardCallback/'.$user->id);
        $data['orderid'] = randomPassword();

        $data['page'] = 'payment/upgrade';
        $this->load->view('templates', $data);
    }

    public function changeCardSuccess(){
        customRedirectWithMessage(site_url('user/update'), 'Ændring af kortoplysningerne');
    }

    public function changeCardCancel(){
        customRedirectWithMessage(site_url('user/update'), 'Ændring af kortoplysningerne fejler');
    }

    public function changeCardCallback($userId){
        $requestBody = file_get_contents("php://input");
        $request = json_decode($requestBody);

        $user = $this->user->getUser($userId);
        $metadata = $request->metadata;
        //Update card info
        $DB['subscriptionid'] = $request->id;
        $DB['cardno']    = $metadata->bin.'XXXXXX'.$metadata->last4;
        $this->user->saveUser($DB, $user->id);
    }

    public function addPaymentLog($userId, $request){
        $operation = end($request->operations);
        $metadata = $request->metadata;

        $logDb['userId']    = $userId;
        $logDb['payment_id']     = $request->id;
        $logDb['orderId']   = $request->order_id;
        $logDb['amount']    = $operation->amount/100;
        $logDb['currency']  = 'DKK';
        $logDb['created_at']      = time();
        $logDb['hash']      = $metadata->hash;
        $logDb['customer_ip']    = $metadata->customer_ip;
        $logDb['customer_country']    = $metadata->customer_country;
        $logDb['cardno']    = $metadata->bin.'XXXXXX'.$metadata->last4;
        $id = $this->user->addLog($logDb);
        if($id == false){
            customRedirectWithMessage(site_url('user/index'), 'Fejl ved lagring af log');
        }
    }

    public function getFee(){
        $users = $this->user->getExpiredUsers();
        if($users){
            foreach ($users as $user){
                if($user->stand_by_payment != 2 || $user->deactivation == 0){
                    $orderId = randomPassword();
                    if($user->package == 1){
                        $packageName = 'price1Month';
                        $plusTime = '+1 month';
                    } else if($user->package == 3) {
                        $packageName = 'price3Months';
                        $plusTime = '+3 months';
                    } else if($user->package == 6) {
                        $packageName = 'price6Months';
                        $plusTime = '+6 months';
                    }
                    //Call payment
                    $ch = curl_init();

                    curl_setopt($ch, CURLOPT_URL, 'https://api.quickpay.net/subscriptions/'.$user->subscriptionid.'/recurring');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"amount\":".($this->config->item($packageName)*100).",\"order_id\":\"".$orderId."\", \"auto_capture\":\"true\"}");
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_USERPWD, '' . ':' . 'c9150af0dff909ed414cc9373239be48288b3e4aabe8b60d7674a2832159d45f');

                    $headers = array();
                    $headers[] = 'Content-Type: application/json';
                    $headers[] = 'Accept-Version: v10';
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                    $result = curl_exec($ch);
                    if (curl_errno($ch)) {
                        echo 'Error:' . curl_error($ch);
                    } else {
                        $request = json_decode($result);
                        $expired = strtotime($plusTime, $user->expired_at);

                        //Update info in user table
                        $DB['orderid'] = $request->order_id;
                        $DB['paymenttime'] = time();
                        $DB['expired_at'] = $expired;
                        if($user->stand_by_payment == 1){
                            $DB['stand_by_payment'] = 2;
                        }
                        $this->user->saveUser($DB, $user->id);
                        //Add log
                        $this->addPaymentLog($user->id, $request);

                        //Send email
                        $sendEmailInfo['name']      = $user->name;
                        $sendEmailInfo['email']     = $user->email;
                        $sendEmailInfo['orderId']   = $request->order_id;
                        $sendEmailInfo['price']     = $this->config->item($packageName).' DKK';
                        $sendEmailInfo['expired']   = date('d/m/Y', $expired);

                        $emailTo = array($user->email);
                        sendEmail($emailTo, 'withdrawMonthly',$sendEmailInfo,'');
                    }
                    curl_close ($ch);
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

    public function testRecurring(){
        $order_id = randomPassword();
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.quickpay.net/subscriptions/142737268/recurring');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"amount\":9900,\"order_id\":\"".$order_id."\", \"auto_capture\":\"true\"}");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_USERPWD, '' . ':' . 'c9150af0dff909ed414cc9373239be48288b3e4aabe8b60d7674a2832159d45f');

        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Accept-Version: v10';
        $headers[] = 'QuickPay-Callback-Url: '.site_url('payment/recurringCallback');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close ($ch);

    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */