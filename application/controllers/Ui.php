<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ui extends CI_Controller {

   	function __construct()
    {
        // Construct the parent class
        parent::__construct();

        $this->load->helper('url');
        
        date_default_timezone_set('Asia/Singapore');
    }
    
    public function index()
    {
    	
    }

    public function charts($section='')
    {
    	$this->load->view('header.php');
    	
    	
    	switch ($section) {
    		case 'average':
    				$this->load->view('charts/chart_average.php');
    			break;    		
    		default:
    				$this->load->view('charts/chart.php');
    			break;
    	}    	
    	$this->load->view('footer.php');
    }
}
