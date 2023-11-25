<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/ease/config/databasehelper.php');

class FavoriteModel{
    public function getFavoriteCar($input){
        $query = "call sp_my_favorite(?, ?)";

        try{
            $db = new DataBaseHelper();
            $con = $db->getConnection();

            $statement = $con->prepare( $query );
            $statement->execute( array(
                $input['userId'], 
                $input['carId']
                ) );

            $result = $statement->fetch( PDO::FETCH_ASSOC );

            return $result;

        } catch(PDOException $error){
            throw new PDOException($error);
        }
    }

    public function getAllFavorites($id){
        $query = "call sp_my_favorites(?)";

        try{
            $db = new DataBaseHelper();
            $con = $db->getConnection();

            $statement = $con->prepare( $query );
            $statement->execute( array( $id ) );

            $result = $statement->fetchAll( PDO::FETCH_ASSOC );

            return $result;

        } catch(PDOException $error){
            return $error;
        }
    }

    public function mark($body){
        $query = "call sp_favorite_car_actions(?, ?, ?, ?)";

        try{
            $db = new DataBaseHelper();
            $con = $db->getConnection();

            $statement = $con->prepare( $query );
            $statement->execute( array(
                $body['carBodyId'], 
                $body['userId'],
                $body['carId'],
                $body['action']
                ) );

            $result = $statement->fetch( PDO::FETCH_ASSOC );

            return $result;

        } catch(PDOException $error){
            throw new PDOException($error->getMessage()) ;
        }
    }
}