<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	 function __construct() {
		 parent::__construct();
		 if($this->session->userdata('logged_in')){
		 	$this->load->model('WelcomeModel','',TRUE);
		 } else {
			 //If no session, redirect to login page
			 redirect('login', 'refresh');
		 }
	 }
	public function index()
	{
		$this->load->helper(array('form'));
		$this->load->library('form_validation');
    $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
    $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_database');

		$this->load->view('login_view');
	}

	public function runStats(){
		$data['username'] = $this->session->userdata('logged_in')['username'];
		$data['fileTypes'] = $this->WelcomeModel->getDistinctFileType();
		$data['pktSizes'] = $this->WelcomeModel->getDistinctPktSize();
		$data['encryptions'] = $this->WelcomeModel->getDistinctEncryptionUsed();
		$data['fileSizes'] = $this->WelcomeModel->getDistinctFileSize();
		$data['protocols'] = $this->WelcomeModel->getDistinctProtocol();
		$this->load->view('run_stats', $data);
	}

	public function tables(){
		$data['username'] = $this->session->userdata('logged_in')['username'];
		$data['rows'] = $this->WelcomeModel->getTableRows();
		$this->load->view('tables', $data);
	}

	public function scatter(){
		$data['username'] = $this->session->userdata('logged_in')['username'];
		$this->load->view('scattergraph', $data);
	}

	public function averageByFileType(){
		$data['username'] = $this->session->userdata('logged_in')['username'];
		$this->load->view('averageByFileType', $data);
	}

	public function averageByProtocol(){
		$data['username'] = $this->session->userdata('logged_in')['username'];
		$this->load->view('averageByProtocol', $data);
	}

	public function averageSendTimeVTotalTime(){
		$data['username'] = $this->session->userdata('logged_in')['username'];
		$this->load->view('averageSendTimeVTotalTime', $data);
	}

	public function search(){
		$this->load->helper(array('form'));
		$data['username'] = $this->session->userdata('logged_in')['username'];
		$data['fileTypes'] = $this->WelcomeModel->getDistinctFileType();
		$data['pktSizes'] = $this->WelcomeModel->getDistinctPktSize();
		$data['encryptions'] = $this->WelcomeModel->getDistinctEncryptionUsed();
		$data['protocols'] = $this->WelcomeModel->getDistinctProtocol();
		$this->load->view('customForm', $data);
	}

	public function data(){
		$data['username'] = $this->session->userdata('logged_in')['username'];
		$data['rows'] = $this->WelcomeModel->getTableRows();
		$this->load->view('data', $data);
	}
}
