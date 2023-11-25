<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/ease/config/databasehelper.php');

class PaymentModel{
    public function get($id){
        $query = "call sp_payment_actions(?, ?, ?, ?, ?, ?, ?)";

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

    public function getAll(){
        $query = "call sp_payment_actions(?, ?, ?, ?, ?, ?, ?)";

        try{
            $db = new DataBaseHelper();
            $con = $db->getConnection();

            $statement = $con->prepare( $query );
            $statement->execute( array(
                null, 
                null, 
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
        $query = "call sp_payment_actions(?, ?, ?, ?, ?, ?, ?)";

        try{
            $db = new DataBaseHelper();
            $con = $db->getConnection();

            $statement = $con->prepare( $query );
            $statement->execute( array(
                null, 
                $body['name'], 
                $body['number'],
                $body['expire'],
                $body['zip'],
                $body['ownerId'],
                "c") );

            $result = $statement->fetch( PDO::FETCH_ASSOC );

            return $result;

        } catch(PDOException $error){
            return $error;
        }
    }

    public function update($body){
        $query = "call sp_payment_actions(?, ?, ?, ?, ?, ?, ?)";

        try{
            $db = new DataBaseHelper();
            $con = $db->getConnection();

            $statement = $con->prepare( $query );
            $statement->execute( array(
                $body->id, 
                $body->name, 
                $body->number,
                $body->expire,
                $body->zip,
                $body->ownerId,
                "u") );

            $result = $statement->fetch( PDO::FETCH_ASSOC );

            return $result;

        } catch(PDOException $error){
            return $error;
        }
    }

    public function delete( $id ){
        $query = "call sp_payment_actions(?, ?, ?, ?, ?, ?, ?)";

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
                "d") );

            $result = $statement->fetch( PDO::FETCH_ASSOC );

            return $result;

        } catch(PDOException $error){
            return $error;
        }
    }

    public function getFrom($id){
        $query = "call sp_payments_from(?)";

        try{
            $db = new DataBaseHelper();
            $con = $db->getConnection();

            $statement = $con->prepare( $query );
            $statement->execute( array( $id ) );

            $result = $statement->fetchAll( PDO::FETCH_ASSOC );

            return $result;

        } catch(PDOException $error){
            throw $error;
        }
    }
}