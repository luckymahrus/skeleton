<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Emails
{
    
    public function __construct()
    {
        # code...
    }

    /**
     * __get
     *
     * Enables the use of CI super-global without having to define an extra variable.
     *
     * I can't remember where I first saw this, so thank you if you are the original author. -Militis
     *
     * @access  public
     * @param   $var
     * @return  mixed
     */
    public function __get($var)
    {
        return get_instance()->$var;
    }


    /*
    $attachment[]   = array(
                            'key'       => 'header',
                            'fullpath'  => FCPATH.'assets/default/images/background/header.jpg',
                            'url'       => 'default/images/background/header.jpg',
                            );

    it will generates:

        $this->email->attach(FCPATH.'assets/default/images/background/header.jpg');
        $data['header']     = $this->email->attachment_cid(FCPATH.'assets/default/images/background/header.jpg');
        $data['headerurl']  = assets_url('default/images/background/header.jpg');
    */
    public function sendEmail($sender,$email,$subject,$data,$template,$attachment=null)
    {
        if(is_array($email))
        {
            $email = implode(',', $email);
        }

        $email_config       = $this->config->item('email_config');
        $email_attachment   = $this->config->item('email_attachment');

        $this->load->library('email', $email_config);

        if(!is_null($attachment) && is_array($attachment) && count($attachment) > 0)
        {
            foreach ($attachment as $idxA => $file)
            {
                $this->email->attach($file['fullpath']);

                $data[$file['key']] = $this->email->attachment_cid($file['fullpath']);
            }
        }

        if(!is_null($email_attachment) && is_array($email_attachment) && count($email_attachment) > 0)
        {
            foreach ($email_attachment as $idxA => $file)
            {
                $this->email->attach($file['fullpath']);

                $data[$file['key']] = $this->email->attachment_cid($file['fullpath']);
            }
        }

        $message = $this->load->view($template, $data, true);

        if(!is_null($attachment) && is_array($attachment) && count($attachment) > 0)
        {
            foreach ($attachment as $idxA => $file)
            {
                $data[$file['key'].'url'] = assets_url($file['url']);
            }
        }

        if(!is_null($email_attachment) && is_array($email_attachment) && count($email_attachment) > 0)
        {
            foreach ($email_attachment as $idxA => $file)
            {
                $data[$file['key'].'url'] = assets_url($file['url']);
            }
        }

        $sendEmailData['emails_message'] = $this->load->view($template, $data, true);
        $from   = 'no-reply@'.$_SERVER['HTTP_HOST'];
        $to   = (($this->config->item('development_mode') == TRUE) ? $this->config->item('email_development') : $email);

        $this->email->clear();
        $this->email->set_mailtype($email_config['mailtype']);
        $this->email->set_newline($email_config['newline']);
        $this->email->from($from, $sender);
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);

        if(!is_null($attachment))
        {
            if(is_array($attachment))
            {
                foreach ($attachment as $key)
                {
                    $this->email->attach($key);
                }
            }
            else
            {
                $this->email->attach($attachment);
            }
        }

        $this->load->model('sendemail_model','sendemail');

        $sendEmailData['emails_sender_addess']  = $from;
        $sendEmailData['emails_sender_name']    = $sender;
        $sendEmailData['emails_to_addess']      = (($to == (($this->config->item('development_mode') == TRUE) ? $this->config->item('email_development') : $email)) ? $to : $to.','.(($this->config->item('development_mode') == TRUE) ? $this->config->item('email_development') : $email));
        $sendEmailData['emails_subject']        = $subject;
        //$sendEmailData['emails_send_datetime']  = date("Y-m-d H:i:s",time());
        $sendEmailData['emails_send_datetime']  = time();
        $this->sendemail->insert($sendEmailData);
        
        if($_SERVER['SERVER_ADDR'] == '127.0.0.1' || $_SERVER['REMOTE_ADDR'] = '127.0.0.1')
        {
            return true;
        }
        else
        {
            try
            {
                return $this->email->send();
            }
            catch (Exception $e)
            {
                return $e->getMessage();
            }
        }
    }
}