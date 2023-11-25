<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/ease/config/databasehelper.php');

class CategoryModel{
    public function get($id){
        $query = "call sp_model_actions(?, ?, ?)";

        try{
            $db = new DataBaseHelper();
            $con = $db->getConnection();

            $statement = $con->prepare( $query );
            $statement->execute( array($id, null, "r") );

            $result = $statement->fetch( PDO::FETCH_ASSOC );

            return $result;

        } catch(PDOException $error){
            return $error;
        }
    }

    public function getAll(){
        $query = "call sp_model_actions(?, ?, ?)";

        try{
            $db = new DataBaseHelper();
            $con = $db->getConnection();

            $statement = $con->prepare( $query );
            $statement->execute( array(null, null, "ra") );

            $result = $statement->fetchAll( PDO::FETCH_ASSOC );

            $db->closeConnection();

            return $result;

        } catch(PDOException $error){
            return $error;
        }
    }

    public function create($body){
        $query = "call sp_model_actions(?, ?, ?)";

        try{
            $db = new DataBaseHelper();
            $con = $db->getConnection();

            $statement = $con->prepare( $query );
            $statement->execute( array(null, $body['name'], "c") );

            $result = $statement->fetch( PDO::FETCH_ASSOC );

            return $result;

        } catch(PDOException $error){
            return $error;
        }
    }

    public function update($body){
        $query = "call sp_model_actions(?, ?, ?)";

        try{
            $db = new DataBaseHelper();
            $con = $db->getConnection();

            $statement = $con->prepare( $query );
            $statement->execute( array( $body->id, $body->name, "u") );

            $result = $statement->fetch( PDO::FETCH_ASSOC );

            return $result;

        } catch(PDOException $error){
            return $error;
        }
    }

    public function delete($id){
        $query = "call sp_model_actions(?, ?, ?)";

        try{
            $db = new DataBaseHelper();
            $con = $db->getConnection();

            $statement = $con->prepare( $query );
            $statement->execute( array($id, null, "d") );

            $result = $statement->fetch( PDO::FETCH_ASSOC );

            return $result;

        } catch(PDOException $error){
            return $error;
        }
    }
}