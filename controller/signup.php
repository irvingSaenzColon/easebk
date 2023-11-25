<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/ease/model/signup.php');

class SignUpController{
    public function signup(){

        $body = Flight::request()->data;
        $response = array(
            "body" => null,
            "message" => ""
        );

        if(!isset($body['name']) || 
        !isset($body['nickname']) || 
        !isset($body['email']) || 
        !isset( $body['password'] ) || 
        !isset( $body['gender'] ) ||
        !isset( $body['birthdate'] ) ){
            $response['message'] = "Faltan parametros";
            Flight::json( $response, 422 );

            return;
        }

        if(trim($body['name']) === '' ||
        trim($body['nickname']) === '' ||
        trim($body['email']) === '' ||
        trim($body['password']) === '' ||
        trim($body['gender']) === '' ||
        trim($body['birthdate']) === ''){
            $response['message'] = "Los campos no pueden ir vacíos";
            Flight::json( $response, 422 );

            return;
        }

        if(!isset( $body['picture'] )){
            $body['picture'] = null;
        }
        else if(trim($body['picture']) === ""){
            $body['picture'] = null;
            $body['format'] = null;
        }
        else{
            $binaryData = $body['picture'];
            list($format, $binaryData) = explode( ";", $binaryData );
            list(, $binaryData) = explode( ",", $binaryData );

            $body['picture'] = base64_decode( $binaryData );
            $body['format'] = $format;
        }

        $signupModel = new SignUpModel();

        $result = $signupModel->signup($body);

        $userCreated = null;

        if(! is_array( $result )){
            $response = array(
                "body" => null,
                "message" => $result->errorInfo[0]
            );

            Flight::json( $response, 500 );
        } else if(isset( $result['name'] )){
            $userCreated = array( "name" => $result['name'], 
            "nickname" => $result['nickname'], 
            "email"=> $result['email'], 
            "password"=> $result['password'], 
            "gender"=> $result['gender'], 
            "birthdate"=> $result['birthdate'], 
            "picture"=> base64_encode($result['picture']));

            $response = array(
                "body" => $userCreated,
                "message" => $result["message"]
            );

            Flight::json( $response, 201 );
        }
        else{
            $response = array(
                "body" => $userCreated,
                "message" => $result["message"]
            );

            Flight::json( $response, 409 );
        }
        
    }

}