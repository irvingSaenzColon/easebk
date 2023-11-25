<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/ease/model/vehicle.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/ease/util/ImageHandler.php');

class VehicleController{
    public function get($id){
        if(trim($id) === ""){
            $response['message'] = "Faltan parametros";
            Flight::json($response, 422);
            return;
        }

        $response = array(
            "body" => null,
            "message" => ""
        );

        $vehicleModel = new VehicleModel();

        $result = $vehicleModel->get( $id );

        if($result != null && isset($result['id'])){
            $imageResult = $vehicleModel->getImageFromVehicle( $result['id'] );
            $result['images'] = $imageResult;
            $response['body'] = $result;
            Flight::json( $response, 200 );
        } else{
            Flight::json( $response, 404 );
        }
        return;
    }

    public function getAll(){
        $response = array(
            "body" => null,
            "message" => ""
        );
        $vehiclesResponse = array();

        $vehicleModel = new VehicleModel();

        $result = $vehicleModel->getAll();

        if($result != null){
            foreach($result as $vehicle){

                $imageResult = $vehicleModel->getImageFromVehicle( $vehicle['id'] );
                $vehicle['images'] = $imageResult;

                array_push( $vehiclesResponse, $vehicle );
            }
            $response['body'] = $vehiclesResponse;
            Flight::json( $response, 200 );
        } else{
            Flight::json( $response, 404 );
        }
        return;
    }

    public function create(){
        $body = Flight::request()->data;
        $response = array(
            "body" => null,
            "message" => ""
        );

        if(
            !isset($body['name']) === "" ||
            !isset( $body['price'] ) === "" ||
            !isset( $body['info'] ) === "" ||
            !isset( $body['model'] ) === "" ||
            !isset( $body['owner'] ) === ""
            ){
            $response['message'] = "Faltan parametros";
            Flight::json($response, 422);
            return;
        }

        if(
            trim($body['name']) === "" ||
            trim( $body['price'] ) === "" ||
            trim( $body['info'] ) === "" ||
            trim( $body['model'] ) === "" ||
            trim( $body['owner'] ) === ""
            ){
            $response['message'] = "Los campos no pueden ir vacíos";
            Flight::json($response, 409);
            return;
        }

        if(!is_array($body['images'])){
            $body['images'] = array();
        }

        $response = array(
            "body" => null,
            "message" => ""
        );

        $vehicleModel = new VehicleModel();

        $result = $vehicleModel->create( $body );

        if(!is_array( $result )){
            $response = array(
                "body" => null,
                "message" => $result
            );
            Flight::json( $response, 500 );

        } else if( isset($result['id']) ){
            $result['images'] = array();
            $imageHandler = new ImageHandler();

            foreach($body['images'] as $image){
                $vehicleInfo = $imageHandler->base64ToBin( $image['image'] );
                $vehicleInfo['id'] = $result['id'];

                $imageResult = $vehicleModel->insertImage( $vehicleInfo );
                $imageElement = array(
                    "id" => 0,
                    "image" => $imageResult['images']
                );
                array_push( $result['images'],  $imageElement);
            }

            $response['body'] = $result;
            Flight::json( $response, 200 );
        }
        return;
    }

    public function update(){
        $body = json_decode( Flight::request()->getBody() );
        $response = array(
            "body" => null,
            "message" => ""
        );

        if(
            !isset($body->id) === "" ||
            !isset($body->name) === "" ||
            !isset( $body->price ) === "" ||
            !isset( $body->info ) === "" ||
            !isset( $body->model ) === ""
            ){
            $response['message'] = "Faltan parametros";
            Flight::json($response, 422);
            return;
        }

        if(
            trim($body->id) === "" ||
            trim($body->name) === "" ||
            trim( $body->price ) === "" ||
            trim( $body->info ) === "" ||
            trim( $body->model ) === ""
            ){
            $response['message'] = "Los campos no pueden ir vacíos";
            Flight::json($response, 409);
            return;
        }

        if(!is_array($body->newImages)){
            $body->images = array();
        }

        if(!is_array($body->deleted)){
            $body->deleted = array();
        }

        $response = array(
            "body" => null,
            "message" => ""
        );

        $vehicleModel = new VehicleModel();

        $result = $vehicleModel->update( $body );

        if(!is_array( $result )){
            $response = array(
                "body" => null,
                "message" => $result
            );
            Flight::json( $response, 500 );

        } else if( isset($result['id']) ){
            $result['newImages'] = array();
            $imageHandler = new ImageHandler();

            //Insert new Images if needed
            foreach($body->newImages as $image){
                $vehicleInfo = $imageHandler->base64ToBin( $image->image );
                $vehicleInfo['id'] = $result['id'];
                $vehicleModel->insertImage( $vehicleInfo );
            }

            //Delete images if needed
            foreach($body->deleted as $image){
                $vehicleModel->deleteImageFromVehicle( $image );
            }

            $response['body'] = $result;
            Flight::json( $response, 200 );
        }
        return;
    }

    public function delete($id){
        if(trim($id) === ""){
            $response['message'] = "Faltan parametros";
            Flight::json($response, 422);
            return;
        }

        $response = array(
            "body" => null,
            "message" => ""
        );
        
        $vehicleModel = new VehicleModel();
        $vehicleModel->delete( $id );
        
        $response['body'] = null;
        Flight::json( $response, 200 );

        return;
    }

    public function getMyCars($id){
        if(trim($id) === ""){
            $response['message'] = "Faltan parametros";
            Flight::json($response, 422);
            return;
        }

        $response = array(
            "body" => null,
            "message" => ""
        );
        $vehiclesResponse = array();

        $vehicleModel = new VehicleModel();

        $result = $vehicleModel->getMyCars( $id );

        if($result != null ){
            foreach($result as $vehicle){

                $imageResult = $vehicleModel->getImageFromVehicle( $vehicle['id'] );
                $vehicle['images'] = $imageResult;

                array_push( $vehiclesResponse, $vehicle );
            }
            $response['body'] = $vehiclesResponse;
            Flight::json( $response, 200 );
        } else{
            $response['body'] = array();
            Flight::json( $response, 200 );
        }
        return;

    }

    public function lastest(){
        $response = array(
            "body" => null,
            "message" => ""
        );
        $vehiclesResponse = array();

        $vehicleModel = new VehicleModel();

        $result = $vehicleModel->lastestPublished( );

        if($result != null && is_array($result) ){
            foreach($result as $vehicle){

                $imageResult = $vehicleModel->getImageFromVehicle( $vehicle['id'] );
                $vehicle['images'] = $imageResult;

                array_push( $vehiclesResponse, $vehicle );
            }
            $response['body'] = $vehiclesResponse;
            Flight::json( $response, 200 );
        } else{
            Flight::json( $response, 404 );
        }
        return;
    }

    public function chepeast(){
        $response = array(
            "body" => null,
            "message" => ""
        );
        $vehiclesResponse = array();

        $vehicleModel = new VehicleModel();

        $result = $vehicleModel->chepeast( );

        if($result != null ){
            foreach($result as $vehicle){

                $imageResult = $vehicleModel->getImageFromVehicle( $vehicle['id'] );
                $vehicle['images'] = $imageResult;

                array_push( $vehiclesResponse, $vehicle );
            }
            $response['body'] = $vehiclesResponse;
            Flight::json( $response, 200 );
        } else{
            Flight::json( $response, 404 );
        }
        return;
    }

    public function sellers(){
        $response = array(
            "body" => null,
            "message" => ""
        );
        $vehiclesResponse = array();

        $vehicleModel = new VehicleModel();

        $result = $vehicleModel->sellers( );

        if($result != null ){
            foreach($result as $vehicle){

                $imageResult = $vehicleModel->getImageFromVehicle( $vehicle['id'] );
                $vehicle['images'] = $imageResult;

                array_push( $vehiclesResponse, $vehicle );
            }
            $response['body'] = $vehiclesResponse;
            Flight::json( $response, 200 );
        } else{
            Flight::json( $response, 404 );
        }
        return;
    }

    public function images(){
        $response = array(
            "body" => null,
            "message" => ""
        );

        $vehicleModel = new VehicleModel();
        $result = $vehicleModel->images();

        if($result != null ){
            $response['body'] = $result;
            Flight::json( $response, 200 );
        } else{
            Flight::json( $response, 404 );
        }
        return;
    }

    public function search(){
        $body = Flight::request()->data;
        $response = array(
            "body" => null,
            "message" => ""
        );

        if(
            !isset($body['name']) === "" ||
            !isset( $body['category'] ) === ""
            ){
            $response['message'] = "Faltan parametros";
            Flight::json($response, 422);
            return;
        }

        if(!is_array($body['images'])){
            $body['images'] = array();
        }

        $response = array(
            "body" => null,
            "message" => ""
        );
        $vehiclesResponse = array();
        $vehicleModel = new VehicleModel();
        
        $result = $vehicleModel->search( $body );

        if($result == null || is_array($result)){
            foreach($result as $vehicle){

                $imageResult = $vehicleModel->getImageFromVehicle( $vehicle['id'] );
                $vehicle['images'] = $imageResult;

                array_push( $vehiclesResponse, $vehicle );
            }
            $response['body'] = $vehiclesResponse;
            Flight::json( $response, 200 );
        } else{
            Flight::json( $response, 500 );
        }
        return;
    }
}