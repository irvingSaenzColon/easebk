<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/ease/config/databasehelper.php');

class AuthenticateModel{
    public function authenticate($body){
        $query = "call sp_authenticate(?)";

        try{
            $db = new DataBaseHelper();
            $con = $db->getConnection();
            $statement = $con->prepare( $query );
            $statement->execute( array( $body->credential ) );

            $result = $statement->fetch( PDO::FETCH_ASSOC );

            return $result;
        } catch( PDOException $error ){
            return $error;
        }
    }
}