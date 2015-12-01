<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller {

  function __construct()
  {
    parent::__construct();
    if($this->session->userdata('logged_in'))
    {

    } else
    {
      //If no session, redirect to login page
      redirect('login', 'refresh');
    }
  }

  function index()
  {
    $data['username'] = $this->session->userdata('logged_in')['username'];
    $this->load->model('WelcomeModel','',TRUE);
    $data['runs'] = $this->WelcomeModel->getDistinctProtocol();
    $data['fileTypes'] = $this->WelcomeModel->getDistinctFileType();
    $data['averageTotal'] = $this->WelcomeModel->getAverageTotalTime();
    $this->load->view('home_view', $data);
  }

  function logout()
  {
    $this->session->unset_userdata('logged_in');
    session_destroy();
    redirect('home', 'refresh');
  }
}

?>
