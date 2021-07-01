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

   function cita_post(){
        $this->form_validation->set_data($this->post());
        $this->form_validation->set_rules('pName', 'Nombre', 'required');
        $this->form_validation->set_rules('pDoc', 'Nombre Doctor', 'required');
        $this->form_validation->set_rules('pDate', 'Fecha', 'required');
        $this->form_validation->set_rules('pTime', 'Horario', 'required');
        $this->form_validation->set_rules('pPadecimiento', 'Padecimiento', 'required');
        $this->form_validation->set_rules('pNotes', 'notas', 'required');

        if ($this->form_validation->run()) {
            // guardar
            $data = array(
                "nombre_paciente" => $this->post('pName'),
                "nombre_doctor" => $this->post('pDoc'),
                "fecha_paciente" => $this->post('pDate'),
                "horario_paciente" => $this->post('pPadecimiento'),
                "padecimiento_paciente" => $this->post('pNotes'),
                "notas_paciente" => $this->post('pTime')
            );
            $this->DAO->saveOrUpdate('citas', $data);

            $response = array(
                "status" => 200,
                "status_text" => "success",
                "api" => "users/api/cita",
                "method" => "POST",
                "message" => "Registro correcto",
                "data" => null,
            );
        } else {
            // error
            $response = array(
                "status" => 500,
                "status_text" => "error",
                "api" => "users/api/cita",
                "method" => "POST",
                "message" => "Error al registrar el artista",
                "errors" => $this->form_validation->error_array(),
                "data" => null,
            );
        }
        $this->response($response, 200);
   }

}
