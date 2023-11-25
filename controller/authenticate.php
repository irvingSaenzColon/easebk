<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/ease/model/authenticate.php');

class AuthenticateController{
    public function authenticate(){
        $body = Flight::request()->data;
        $response = array(
            "body" => null,
            "messsage" => ""
        );

        if(!isset( $body['credential'] ) || !isset( $body['password'] )){
            $response['message'] = "Faltan parametros por enviar";
            Flight::json( $response, 422 );
            return;
        }

        if(trim( $body['credential']) == "" ||  trim( $body['password']) == ""){
            $response['message'] = "No debe mandar campos vacíos";
            Flight::json( $response, 422 );
            return;
        }

        $auth = new AuthenticateModel();

        $result = $auth->authenticate( $body );

        if ($result == null){
            $response = array(
                "body" => null,
                "message" => "Usuario y/o contraseña incorrectos"
            );

            Flight::json( $response, 500 );
            return;
        } else if(!is_array($result)){
            $response = array(
                "body" => null,
                "message" => $result->errorInfo[0]
            );

            Flight::json( $response, 500 );
            return;
        } else if( !isset( $result['name'] ) ){
            $response = array(
                "body" => null,
                "message" => "Usuario y/o contraseña incorrectos"
            );

            Flight::json( $response, 500 );
            return;
        } else if( $result['password'] === $body['password'] ){

            $userCreated = array( 
                "id" => intval($result['id']),
                "name" => $result['name'], 
                "nickname" => $result['nickname'], 
                "email"=> $result['email'], 
                "password"=> $result['password'], 
                "gender"=> $result['gender'], 
                "birthdate"=> explode(" ", $result['birthdate'])[0], 
                "picture"=> base64_encode($result['picture']));

            $response = array(
                "body" => $userCreated,
                "message" => "found"
            );

            Flight::json( $response, 200 );
            return;
        } else{
            $response = array(
                "body" => null,
                "message" => "Usuario y/o contraseña incorrectos"
            );

            Flight::json( $response, 500 );
            return;
        }
    }
}