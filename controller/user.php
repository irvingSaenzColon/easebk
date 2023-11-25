<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/ease/model/user.php');

class UserController{
    public function get($id){
        $response = array(
            "body" => null,
            "message" => ""
        );
     
        if(!isset( $id )){
            $response['message'] = "Faltan parametros por mandar";
            Flight::json( $response, 422 );
            return;
        }

        $userModel = new UserModel();

        $result = $userModel->delete( $id );

        Flight::json($response, 200);
    }

    public function getAll(){
        $userModel = new UserModel();
        $response = array(
            "body" => [],
            "message" => ""
        );

        $result = $userModel->getAll();

        $response['body'] = $result;

        Flight::json( $response,  200);
    }

    public function update(){
        $body = json_decode( Flight::request()->getBody() );
        $response = array(
            "body" => null,
            "message" => ""
        );

        if(!isset($body->id) ||
        !isset($body->name) ||
        !isset($body->nickname) ||
        !isset($body->gender) ||
        !isset($body->birthdate) ){
            $response['message'] = "Faltan campos por mandar";
            Flight::json( $response, 422 );

            return;
        }

        if(trim($body->id) === ''||
        trim($body->name) === '' ||
        trim($body->nickname) === '' ||
        trim($body->gender) === '' ||
        trim($body->birthdate) === ''){
            $response['message'] = "Los campos no pueden ir vacíos";
            Flight::json( $response, 422 );

            return;
        }

        

        if( !isset($body->picture) ){
            $body->picture = null;
            $body->format = null;
            
        } else if(trim($body->picture) === ""){
            $body->picture = null;
            $body->format = null;
        } else {
            $binaryData = $body->picture;
            list($format, $binaryData) = explode( ";", $binaryData );
            list(, $binaryData) = explode( ",", $binaryData );

            $body->picture = base64_decode( $binaryData );
            $body->format = $format;
        }

        $userModel = new UserModel();
        $result = $userModel->update( $body );

        if($result === null){
            $response = array(
                "body" => null,
                "message" => "No se ha actualizado el usuario"
            );

            Flight::json( $response, 404 );
            return;
        }
        else if(!is_array($result)){
            $response = array(
                "body" => null,
                "message" => $result->errorInfo[1]
            );

            Flight::json( $response, 500 );
            return;
        } else if( isset($result['name']) ){
            $userCreated = array( 
                "name" => $result['name'], 
                "nickname" => $result['nickname'],
                "gender"=> $result['gender'], 
                "birthdate"=> explode(" ", $result['birthdate'])[0], 
                "picture"=> $result['picture']
            );

            $response = array(
                "body" => $userCreated,
                "message" => "found"
            );

            Flight::json( $response, 200 );
            return;
        } else{
            $response = array(
                "body" => null,
                "message" => $result['message']
            );

            Flight::json( $response, 409 );
            return;
        }
    }

    public function delete($id){
        $response = array(
            "body" => null,
            "message" => ""
        );
     
        if(!isset( $id )){
            $response['message'] = "Faltan parametros por mandar";
            Flight::json( $response, 422 );
            return;
        }

        $userModel = new UserModel();

        $result = $userModel->delete( $id );

        $response['message'] = $result['message'];

        Flight::json($response, 200);

    }
}