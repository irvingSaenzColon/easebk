<?php
include_once($_SERVER['DOCUMENT_ROOT']."/ease/config/databasehelper.php");

class UserModel{

    public function get($id){
        $query = "call sp_user_actions(?, ?, ?, ?, ?, ?, ?, ?, ?)";

        try{
            $db = new DataBaseHelper();
            $con = $db->getConnection();

            $statement = $con->prepare( $query );
            $statement->execute( 
                array(
                    intval( $id ),
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    'rs'
                ) );

            $result = $statement->fetch( PDO::FETCH_ASSOC );

            return $result;

        }catch(PDOException $error){
            return $error;
        }
    }

    public function getAll(){
        $query = "call sp_user_actions(?, ?, ?, ?, ?, ?, ?, ?, ?)";

        try{
            $db = new DataBaseHelper();
            $con = $db->getConnection();

            $statement = $con->prepare( $query );
            $statement->execute( 
                array(
                    0,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    'r'
                ) );

            $result = $statement->fetchAll( PDO::FETCH_ASSOC );

            return $result;

        }catch(PDOException $error){
            return $error;
        }
    }
    
    public function create(){
        
    }

    public function update($body){
        $query = "call sp_user_actions(?, ?, ?, ?, ?, ?, ?, ?, ?)";

        try{
            $db = new DataBaseHelper();
            $con = $db->getConnection();

            $statement = $con->prepare( $query );
            $statement->execute( 
                array(
                    $body->id,
                    $body->name,
                    $body->nickname,
                    null,
                    $body->gender,
                    $body->birthdate,
                    $body->picture,
                    $body->format,
                    'u'
                ) );

            $result = $statement->fetch( PDO::FETCH_ASSOC );

            return $result;

        }catch(PDOException $error){
            return $error;
        }
    }

    public function delete($id){
        $query = "call sp_user_actions(?, ?, ?, ?, ?, ?, ?, ?, ?)";

        try{
            $db = new DataBaseHelper();
            $con = $db->getConnection();

            $statement = $con->prepare( $query );
            $statement->execute( array( $id, null, null, null, null, null, null, null, 'd' ) );

            $result = $statement->fetch(PDO::FETCH_ASSOC);

            return $result;
        }catch(PDOException $error){
            return $error;
        }
    }
}