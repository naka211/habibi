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
        $configEmail['protocol'] = 'sendmail';
        /*$configEmail['smtp_host'] = 'asmtp.unoeuro.com';
        $configEmail['smtp_user'] = 'noreply@zeduuce.com';
        $configEmail['smtp_pass'] = 'yi16wunegapu';
        $configEmail['smtp_port'] = 587;
        $configEmail['smtp_crypto'] = 'tls';
        $configEmail['smtp_timeout'] = 30;*/

        $this->load->library('email');
        $this->email->set_newline("\r\n");
        $this->email->initialize($configEmail);
        try {
            foreach($emails as $email){
                $this->email->clear();
                $this->email->to($email);
                if($from == NULL ){
                    $this->email->from('noreply@zeduuce.com ','Zeduuce.com');
                }
                else{
                    $this->email->from($from,'Zeduuce.com');
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
}