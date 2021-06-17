<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DAO extends CI_Model {
    function __construct(){
        parent:: __construct();
    }
    function selectEntity($entity,$params =  null,$isUnique = FALSE){
    	if($params){
    		$this->db->where($params);
    	}
    	$query = $this->db->get($entity);
    	if($this->db->error()['message']!=''){
    		$response = array(
    			"status"=>"error",
    			"message"=>$this->db->error()['message'],
                "validation"=>array(),
    			"data"=>null
    		);
    	}else{
    		$response = array(
    			"status"=>"success",
    			"message"=>"Información cargada correctamente",
                "validation"=>array(),
    			"data"=> $isUnique ?  $query->row() : $query->result()
    		);
    	}
    	return $response;
    }
    function sqlQuery($sql, $params = array(), $isUnique = FALSE){
        $query =  $this->db->query($sql,$params ? $params : null);

        if($this->db->error()['message']!=''){
    		$response = array(
    			"status"=>"error",
    			"message"=>$this->db->error()['message'],
    			"data"=>null
    		);
    	}else{
    		$response = array(
    			"status"=>"success",
    			"message"=>"Información cargada correctamente",
    			"data"=> $isUnique ?  $query->row() : $query->result()
    		);
    	}
    	return $response;
    }

    function deleteEntity($entity,$whereClause =  array()){
        $this->db->where($whereClause);
        $this->db->delete($entity);
        if($this->db->error()['message']!=''){
    		$response = array(
    			"status"=>"error",
    			"message"=>$this->db->error()['message'],
    			"data"=>null
    		);
    	}else{
            $response = array(
    			"status"=>"success",
    			"message"=> "Información borrada correctamente",
    			"data"=>null
    		);
        }
        return $response;
    }

    function saveOrUpdate($entity,$data,$whereClause = null, $returnKey = FALSE){
    	if($whereClause){
    		$this->db->where($whereClause);
            $this->db->update($entity,$data);
    	}else{
            $this->db->insert($entity,$data);
        }
    	if($this->db->error()['message']!=''){
    		$response = array(
    			"status"=>"error",
    			"message"=>$this->db->error()['message'],
    			"data"=>null
    		);
    	}else{
        if($whereClause){
            $msg = "Información actualizada correctamente!";
        }else{
            $msg = "Información registrada correctamente!";
        }
    		$response = array(
    			"status" => "success",
    			"message" => $msg,
                "data" => null
    		);
        if($returnKey){
          $response['data'] = $this->db->insert_id();
        }
    	}
    	return $response;
    }

    function login($email,$password,$app='web'){
      $this->db->where("email_usuario",$email);
      $users_exists = $this->db->get('usuarios')->row();
      //Si el email existe en la bd
      if($users_exists){
          if($users_exists->password_usuario == $password){
              if($users_exists->status_usuario == "Inactivo"){
                      $response = array(
                          "status" => "error",
                          "message" => "Este usuario se encuentra inactivo, contacta al admin",
                          "validations"=>array(),
                          "data" => null
                      );
              }else{
                  $this->db->where('id_usuario',$users_exists->id_usuario);
                  $has_permition = TRUE;
                    if($app=='mobile'){
                        if($users_exists->perfil_usuario=="Profesor"){
                              $has_permition = FALSE;
                              $response = array(
                                  "status" => "error",
                                  "message" => "Tu acceso está restringido a esta aplicación. Contacta al administrador.",
                                  "validations"=>array(),
                                  "data" => null
                              );
                        }
                    }elseif($app="web"){
                          if($users_exists->perfil_usuario=="Alumno"){
                              $has_permition = FALSE;
                              $response = array(
                                  "status" => "error",
                                  "message" => "Tu acceso está restringido a esta aplicación. Contacta al administrador.",
                                  "validations"=>array(),
                                  "data" => null
                              );
                          }  
                    }
                    if($has_permition){
                      $response = array(
                          "status" => "success",
                          "message" => "Autentificación correcta",
                          "validations"=>array(),
                          "data" => array(
                              "user_key" =>$users_exists->id_usuario,
                              "user_email"=>$users_exists->email_usuario,
                              "user_genre"=>$users_exists->genero_usuario,
                              "user_name"=>$users_exists->nombre_usuario,
                              "profile"=>$users_exists->perfil_usuario,
                              "status"=>$users_exists->status_usuario
                          )
                      );
                    }
              }
          }
          else{
              //// si la contraseña no es correcta
              $response = array(
                  "status" => "error",
                  "message" => "La clave ingresada no es correcta",
                  "validations"=>array(),
                  "data" => null
              );
          }
      }else{
          $response = array(
              "status" => "error",
              "message" => "El correo ingresado no existe",
              "validations"=>array(),
              "data" => null
          );
      }
      return $response;
    }

    function init_transaction(){
        $this->db->trans_begin();
    }

    function check_transaction(){
        if($this->db->trans_status()){
            $this->db->trans_commit();
            $response = array(
                "status" => "success",
                "message" => "Proceso completado correctamente",
                "data" => null
            );
        }else{
            $this->db->trans_rollback();
            $response = array(
                "status" => "error",
                "message" => "Error al completar el proceso",
                "data" => null
            );
        }
        return $response;
    }



}
