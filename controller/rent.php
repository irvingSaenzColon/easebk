<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/ease/model/rent.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/ease/model/vehicle.php');


class RentController{
    public function test(){
        Flight::json("hola", 200);
    }

    public function get($id){
        $response = array(
            "body" => null,
            "message" => ""
        );

        if( !isset( $id ) ){
            $response['message'] = "Se necesitan mandar parametros";
            Flight::json($response, 422);
            return;
        }

        try{
            $rentModel = new RentModel();
            $result = $rentModel->get( $id );

            $response['body'] = $result;

            Flight::json( $response, 200 );
            return;
        } catch(PDOException $error){
            Flight::json( $error, 500 );
            return;
        }
    }

    public function getAll($id){
        $response = array(
            "body" => null,
            "message" => ""
        );

        $vehicleModel = new VehicleModel();
        $rentModel = new RentModel();
        $result = $rentModel->getAll($id);

        foreach($result as $vehicle){

            $imageResult = $vehicleModel->getImageFromVehicle( $vehicle['id'] );
            $vehicle['images'] = $imageResult;

            array_push( $vehiclesResponse, $vehicle );
        }

        if(is_array($result) ){

            foreach($result as $vehicle){
                $vehicleResult = $vehicleModel->get($vehicle['vehicleId']);
                $vehicleImages = $vehicleModel->getImageFromVehicle( $vehicle['vehicleId'] );
                $vehicleResult['images'] = $vehicleImages;
            }
            
            
        }

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
            !isset( $body['orderId'] ) ||
            !isset( $body['userId'] ) ||
            !isset( $body['carId'] ) ||
            !isset( $body['paymethodId'] ) ||
            !isset( $body['total'] ) ||
            !isset( $body['returnDate'] ) 
        ){
            $response['message'] = "Faltan enviar parametros";
            Flight::json($response, 422);
            return;
        }

        if ( 
            trim( $body['orderId'] ) == "" ||
            trim( $body['userId'] ) == "" ||
            trim( $body['carId'] ) == "" ||
            trim( $body['paymethodId'] ) == "" ||
            trim( $body['total'] ) == "" ||
            trim( $body['returnDate']) == "" 
        ){
            $response['message'] = "Los campos no pueden ir vacíos";
            Flight::json($response, 409);
            return;
        }

        try{
            $rentModel = new RentModel();
            $result = $rentModel->create( $body );

            $response['body'] = $result;

            Flight::json( $response, 200 );
            return;
        } catch(PDOException $error){
            Flight::json( $error, 500 );
            return;
        }
        
    }
}