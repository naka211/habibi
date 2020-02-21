<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class General_model extends CI_Model{
	function __construct(){
        parent::__construct();
	}
    function getMetaData($id=NULL){
        $query = $this->db->select('*')
                ->from('seo')
                ->where('seo.id',$id)
                ->where("seo.bl_active",1)
                ->get()->row();
	    return $query;
    }
    
    /** Static content*/
    function getNewsStatic($code=NULL){
        $query = $this->db->select('*')
                ->from('content_static')
                ->where('code', $code)
                ->where('bl_active', 1)
                ->get()->row();
        return $query;
    }
    function getNewsStaticID($id=NULL){
        $query = $this->db->select('*')
                ->from('content_static')
                ->where('id', $id)
                ->where('bl_active', 1)
                ->get()->row();
        return $query;
    }
    
    function saveContact($data=NULL){
        if($this->db->insert('contact',$data)){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }

    function getMetaDataFromUrl(){
        $code = $this->router->fetch_class().'-'.$this->router->fetch_method();
        $query = $this->db->select('*')
            ->from('seo')
            ->where('seo.code',$code)
            ->where("seo.bl_active",1)
            ->get()->row();
        return $query;
    }

    /**
     * @param $emails
     * @param $subject
     * @param $content
     * @param array $data
     * @param null $from
     * @param string $mailType
     * @return bool
     */
    function sendEmail($emails, $subject, $content, $data = array(), $from = null, $mailType = 'html')
    {
        $configEmail['mailtype'] = $mailType;
        $configEmail['protocol'] = 'smtp';
        $configEmail['smtp_host'] = 'smtp.unoeuro.com';
        $configEmail['smtp_user'] = $this->config->item('sender_email');
        $configEmail['smtp_pass'] = $this->config->item('email_password');
        $configEmail['smtp_port'] = 587;
        $configEmail['smtp_crypto'] = 'tls';
        $configEmail['smtp_timeout'] = 30;

        $this->load->library('email');
        $this->email->set_newline("\r\n");
        $this->email->initialize($configEmail);
        try {
            foreach($emails as $email){
                $this->email->clear();
                $this->email->to($email);
                if($from == NULL ){
                    $this->email->from($this->config->item('sender_email') ,'Habibidating.dk');
                }
                else{
                    $this->email->from($from,'Habibidating.dk');
                }
                $this->email->subject($subject);
                $this->email->message($content);
                $this->email->send();
            }
        } catch (Exception $e){
            return false;
        }
        return true;
    }

    public function getAllUserForComet(){
        $this->db->select('id, name, avatar')->from('user')->where('deleted', null);
        $query = $this->db->get()->result();

        return $query;
    }
}