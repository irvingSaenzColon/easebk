<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/ease/model/category.php');

class CategoryController{
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

        $categoryModel = new CategoryModel();
        $result = $categoryModel->get( $id );

        $response['body'] = $result;

        Flight::json( $response, 200 );
        return;
    }

    public function getAll(){
        $response = array(
            "body" => null,
            "message" => ""
        );

        $categoryModel = new CategoryModel();
        $result = $categoryModel->getAll();

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

        if( !isset( $body['name'] ) ){
            $response['message'] = "Faltan enviar parametros";
            Flight::json($response, 422);
            return;
        }

        if( trim( $body['name'] ) == "" ){
            $response['message'] = "Los campos no pueden ir vacíos";
            Flight::json($response, 409);
            return;
        }

        $categoryModel = new CategoryModel();
        $result = $categoryModel->create( $body );

        if( isset( $result['message'] ) && isset( $result['name'] ) ){
            $response['body'] = array(
                "id" => $result['id'],
                "name" => $result['name']
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

        if( !isset( $body->name ) || !isset($body->id)){
            $response['message'] = "Faltan enviar parametros";
            Flight::json($response, 422);
            return;
        }

        if( trim( $body->name ) == "" || trim( $body->id ) == ""){
            $response['message'] = "Los campos no pueden ir vacíos";
            Flight::json($response, 409);
            return;
        }

        $categoryModel = new CategoryModel();
        $result = $categoryModel->update( $body );

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

        $categoryModel = new CategoryModel();
        $result = $categoryModel->delete( $id );

        $response['body'] = $result;

        Flight::json( $response, 200 );
        return;
    }
}