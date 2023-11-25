<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/ease/model/favorite.php');

class FavoriteController{
    public function get(){
        Flight::json( "Hola", 200 );
        return;
    }

    public function getFavorite(){
        $body = Flight::request()->data;
        $response = array(
            "body" => null,
            "message" => ""
        );

        if( 
            !isset( $body['userId'] ) ||
            !isset( $body['carId'] ) 
        )
        {
            $response['message'] = "Faltan enviar parametros";
            Flight::json($response, 422);
            return;
        }

        if( 
            trim( $body['userId'] ) == "" ||
            trim( $body['carId'] ) == "" 
            ){
            $response['message'] = "Los campos no pueden ir vacíos";
            Flight::json($response, 409);
            return;
        }

       try{
            $favoriteModel = new FavoriteModel();
            $result = $favoriteModel->getFavoriteCar($body);
            $response['body'] = $result;
                
            Flight::json( $response, 200 );
            return;
       } catch(PDOException $error){
            Flight::json( $error, 500 );
            return;
       }

        

        
    }

    public function getFavorites($id){
        $response = array(
            "body" => null,
            "message" => ""
        );
        $favoriteModel = new FavoriteModel();

        try{
            $result = $favoriteModel->getAllFavorites( $id );
            $response['body'] = $result;
            Flight::json( $response, 200 );
            return;
        } catch(PDOException $error){
            Flight::json($error, 500);
        }

        
            
    }

    public function mark(){
        $body = Flight::request()->data;
        $response = array(
            "body" => null,
            "message" => ""
        );

        if( 
            !isset( $body['carBodyId'] ) ||
            !isset( $body['userId'] ) ||
            !isset( $body['carId'] ) ||
            !isset( $body['action'] )
        )
        {
            $response['message'] = "Faltan enviar parametros";
            Flight::json($response, 422);
            return;
        }

        if( 
            trim( $body['carBodyId'] ) == "" ||
            trim( $body['userId'] ) == "" ||
            trim( $body['carId'] ) == "" ||
            trim( $body['action'] ) == "" 
            ){
            $response['message'] = "Los campos no pueden ir vacíos";
            Flight::json($response, 409);
            return;
        }

        $favoriteModel = new FavoriteModel();

        try{
            $result = $favoriteModel->mark( $body );
            $response['body'] = $result;
            
            Flight::json( $response, 200 );
            return;
        } catch(PDOException $error){
            Flight::json( $error, 500 );
            return;
        }
    }

  
}