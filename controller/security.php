<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/ease/model/security.php');

class SecurityController{
    public function changePassword() {
        $body = Flight::request()->data;
        $response = array( "body" => null, "message" => "" );

        if( !isset( $body['id'] ) || 
            !isset( $body['newPassword'] ) ||
            !isset( $body['password'] )){
                $response['message'] = "Faltan mandar campos";
                Flight::json($response, 422);
                return;
        }

        if( trim( $body['id'] ) == "" || 
            trim( $body['newPassword'] ) == "" ||
            trim( $body['password'] ) == "" ){
                $response['message'] = "No puede mandar campos vacíos";
                Flight::json($response, 409);
                return;
        }

        $securityModel = new SecurityModel();
        $result = $securityModel->changePassword( $body );

        if( isset( $result['message'] ) && isset( $result['id'] ) ){
            $response['body'] = array(
                "id" => $result['id'],
                "password" => $result['password']
            );
            $response['message'] = $result['message'];
            Flight::json($response, 200);
        } else if( isset( $result['message'] ) ){
            $response['message'] = $result['message'];
            Flight::json($response, 409);
        } else {
            $response['message'] = $result->errorInfo[0];
            Flight::json($response, 500);
        }

        return;
    }
}