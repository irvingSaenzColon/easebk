<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/ease/config/databasehelper.php');

class RentModel{
    public function get($id){
        $query = "call sp_order_car(?, ?, ?, ?, ?, ?, ?)";

        try{
            $db = new DataBaseHelper();
            $con = $db->getConnection();

            $statement = $con->prepare( $query );
            $statement->execute( array(
                $id, 
                null, 
                null,
                null,
                null,
                null,
                "g") );

            $result = $statement->fetch( PDO::FETCH_ASSOC );

            return $result;

        } catch(PDOException $error){
            return $error;
        }
    }

    public function getAll($userId){
        $query = "call sp_order_car(?, ?, ?, ?, ?, ?, ?)";

        try{
            $db = new DataBaseHelper();
            $con = $db->getConnection();

            $statement = $con->prepare( $query );
            $statement->execute( array(
                null, 
                $userId, 
                null,
                null,
                null,
                null,
                "ga") );

            $result = $statement->fetchAll( PDO::FETCH_ASSOC );

            return $result;

        } catch(PDOException $error){
            return $error;
        }
    }

    public function create($body){
        $query = "call sp_order_car(?, ?, ?, ?, ?, ?, ?)";

        try{
            $db = new DataBaseHelper();
            $con = $db->getConnection();

            $statement = $con->prepare( $query );
            $statement->execute( array(
                $body['orderId'], 
                $body['userId'], 
                $body['carId'],
                $body['paymethodId'],
                $body['total'],
                $body['returnDate'],
                "c") );

            $result = $statement->fetch( PDO::FETCH_ASSOC );

            return $result;

        } catch(PDOException $error){
            return $error;
        }
    }
}