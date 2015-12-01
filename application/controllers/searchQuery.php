<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SearchQuery extends CI_Controller{

  function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('SearchModel','',TRUE);
    } else {
      //If no session, redirect to login page
      redirect('login', 'refresh');
    }
  }

  public function index()
  {
    $this->load->helper(array('form'));
    $this->load->library('form_validation');
    $this->load->view('custom_graph');
  }


  public function graph(){
    $data['multiple'] = false;
    if(!empty($_POST['protocol'])){
      for($i = 0; $i < count($_POST['protocol']); $i++){
        $data['results'][$i] = $this->SearchModel->query($_POST, $_POST['protocol'][$i]);
      }
      $data['multiple'] = true;
    } else {
      $data['results'] = $this->SearchModel->query($_POST);
    }
    $data['username'] = $this->session->userdata('logged_in')['username'];
    $this->load->view('custom_graph', $data);
  }

}
