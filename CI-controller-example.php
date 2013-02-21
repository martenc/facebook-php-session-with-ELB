<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// This example will not run without CodeIgniter setup and of course a dummy db/table called users

class Vote extends CI_Controller {

	private $fbid;

	public function __construct()
	{
		parent::__construct();
		
		$this->load->database();
		$this->load->helper('url');
		$this->load->library('facebook_user');
		
	}
	
	public function _remap()
	{
		$args = $this->uri->segment_array();

		// default action if nothing is sent (assumes something is in args[3])
        $item = (isset($args[3])) ? $args[3] : 'index';
        $someAction = (isset($args[4])) ? $args[4] : 'index';

		$fbid = $this->facebook_user->getUserId();  
	    if (empty($fbid) || $fbid == 0) {
	        // no fbid so you may want to go to plan B
	        exit;
	    }
       
		switch($item) {
            case 'get' : 
                $params = array(
                    'fbid' => $fbid,
                    'action' => $someAction
                );
                $this->$item($params);
                break; 
            default :
                $this->$item();
                break;
        }
		
	}

	public function index()
	{
		$output = array(
            'status' => 'fail',
            'content' => 'error_message',
            'message' => 'Please provide a valid action'
            );
        echo json_encode($output); 
        exit;
	}	
	
	public function get($args=null) 
	{
		$output = '';
		try {

			$fbid = $args['fbid'];
			$someAction = $args['matchup'];

			// transational:  
			// http://ellislab.com/codeigniter/user-guide/database/transactions.html
        	$this->db->trans_start();
			$this->db->where('fbid', $fbid);
			$row = $this->db->get('users')->row();
			$this->db->trans_complete();

			if (!empty($row)) {
			// todo something
			}
		}
		catch(Exception $e) {
			$output = array(
				'status' => 'fail', 
				'content' => 'error_message',
				'message' => 'Sorry, there was a problem:' . $e
				);
			echo json_encode($output);
		}
	}
}