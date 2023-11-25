<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/ease/model/payment.php');

class PaymentController{
    public function get($id){
        $response = array(
            "body" => null,
            "message" => ""
        );

        if( !isset( $id ) ){
            $response['message'] = "Se necesutan mandar parametros";
            Flight::json($response, 422);
            return;
        }

        $paymentModel = new PaymentModel();
        $result = $paymentModel->get( $id );

        $response['body'] = $result;

        Flight::json( $response, 200 );
        return;
    }

    public function getAll(){
        $response = array(
            "body" => null,
            "message" => ""
        );

        $paymentModel = new PaymentModel();
        $result = $paymentModel->getAll();

        $response['body'] = $result;

        Flight::json( $response, 200 );
        return;
    }

    public function create(){
        $body = Flight::request()->data;
        $response = array(
            "body" => null,
            "message" => ""
        );

        if( 
            !isset( $body['name'] ) ||
            !isset( $body['number'] ) ||
            !isset( $body['expire'] ) ||
            !isset( $body['zip'] ) ||
            !isset( $body['ownerId'] )
        ){
            $response['message'] = "Faltan enviar parametros";
            Flight::json($response, 422);
            return;
        }

        if( 
            trim( $body['name'] ) == "" ||
            trim( $body['number'] ) == "" ||
            trim( $body['expire'] ) == "" ||
            trim( $body['zip'] ) == "" ||
            trim( $body['ownerId'] ) == ""
            ){
            $response['message'] = "Los campos no pueden ir vacíos";
            Flight::json($response, 409);
            return;
        }

        $paymentModel = new PaymentModel();
        $result = $paymentModel->create( $body );

        if( isset( $result['message'] ) && isset( $result['name'] ) ){
            $response['body'] = array(
                "id" => $result['id'],
                "name" => $result['name'],
                "number" => $result['number'],
                "expire" => $result['expire'],
                "zip"=>$result['zip']
            );
            $response['message'] = $result['message'];

            Flight::json( $response, 200 );
            return;
        } else if( isset( $result['message'] ) ){
            $response['message'] = $result['message'];

            Flight::json( $response, 409 );
            return;
        } else{
            Flight::json( $response, 505 );
            return;
        }
        
    }

    public function update(){
        $body = json_decode( Flight::request()->getBody() );
        $response = array(
            "body" => null,
            "message" => ""
        );

        if( 
            !isset( $body->id ) ||
            !isset( $body->name ) ||
            !isset( $body->number ) ||
            !isset( $body->expire ) ||
            !isset( $body->zip ) ||
            !isset( $body->ownerId )
            ){
            $response['message'] = "Faltan enviar parametros";
            Flight::json($response, 422);
            return;
        }

        if( 
            trim( $body->id ) == "" ||
            trim( $body->name ) == "" ||
            trim( $body->number ) == "" ||
            trim( $body->expire ) == "" ||
            trim( $body->zip ) == "" ||
            trim( $body->ownerId ) == ""
            ){
            $response['message'] = "Los campos no pueden ir vacíos";
            Flight::json($response, 409);
            return;
        }

        $paymentModel = new PaymentModel();
        $result = $paymentModel->update( $body );

        $response['body'] = $result;

        Flight::json( $response, 200 );
        return;
    }

    public function delete($id){
        $response = array(
            "body" => null,
            "message" => ""
        );

        if( !isset( $id ) ){
            $response['message'] = "Se necesutan mandar parametros";
            Flight::json($response, 422);
            return;
        }

        $paymentModel = new PaymentModel();
        $result = $paymentModel->delete( $id );

        $response['body'] = $result;

        Flight::json( $response, 200 );
        return;
    }

    public function getFrom($id){
        $response = array(
            "body" => null,
            "message" => ""
        );

        if( !isset( $id ) ){
            $response['message'] = "Se necesutan mandar parametros";
            Flight::json($response, 422);
            return;
        }

        try{
            $paymentModel = new PaymentModel();
            $result = $paymentModel->getFrom( $id );
            $response['body'] = $result;

            Flight::json( $response, 200 );
            return;
        } catch(PDOException $error){
            $response['message'] = $error->errorInfo[0];
            Flight::json( $response, 500 );
        }
        
    }
}