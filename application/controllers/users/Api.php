<?php
require APPPATH . 'core/MY_RootController.php';

defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends MY_RootController {
    function __construct(){
        parent:: __construct();
        $this->load->model('DAO');
    }

   function login_post(){
     $this->form_validation->set_data($this->post());
     $this->form_validation->set_rules('pEmail','email','required');
     $this->form_validation->set_rules('pPassword','password','required');

     if($this->form_validation->run()){
        $response = $this->DAO->login($this->post('pEmail'),$this->post('pPassword'));
    }else{
         $response = array(
             "status"=>"error",
             "message"=>"Información enviada incorrectamente.",
             "validations"=>$this->form_validation->error_array(),
             "data"=>null
         );
     }
     $this->response($response,200);
   }

   function login_mobile_post(){
     $this->form_validation->set_data($this->post());
     $this->form_validation->set_rules('pEmail','email','required');
     $this->form_validation->set_rules('pPassword','password','required');

     if($this->form_validation->run()){
        $response = $this->DAO->login($this->post('pEmail'),$this->post('pPassword'), "mobile");
    }else{
         $response = array(
             "status"=>"error",
             "message"=>"Información enviada incorrectamente.",
             "validations"=>$this->form_validation->error_array(),
             "data"=>null
         );
     }
     $this->response($response,200);
   }

}
