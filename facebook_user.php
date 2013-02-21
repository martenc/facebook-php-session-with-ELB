<?php

require_once(APPPATH.'libraries/facebook/facebook.php');

class Facebook_user {

    private $CI = null;
    private $user_profile = null;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->config('facebook');
        $this->set_headers();
    
        // need to move these credentials to config file
        $facebook = new Facebook(array(
          'appId'  => $this->CI->config->item('facebook_appid'),
          'secret' => $this->CI->config->item('facebook_secret'),
          'cookie' => TRUE
        ));
    
        $user = $facebook->getUser();

        if ($user) {
          try {
            // Proceed knowing you have a logged in user who's authenticated.
            $this->user_profile = $facebook->api('/me');
            
          } catch (FacebookApiException $e) {
            //echo '<pre>'.htmlspecialchars(print_r($e, true)).'</pre>';
            $user = null;
          }
        }

    }

    public function getUserId() {
        if ($this->user_profile) {
            return $this->user_profile['id'];    
        }
        else {
            return null;
        }
        
    }

    protected function set_headers($headers = array()) {
        $this->CI->output->set_header('p3p: CP="ALL DSP COR PSAa PSDa OUR NOR ONL UNI COM NAV"');

        if (count($headers) > 0) {
            foreach ($headers AS $header) {
                $this->CI->output->set_header($header);
            }
        }
    }

}

