<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/ease/config/databasehelper.php');

class SignUpModel{
    public function signup($input){
        $query = "call sp_signup(?, ?, ?, ?, ?, ?, ?, ?)";

        try{
            $db = new DataBaseHelper();
            $con = $db->getConnection();
            
            $statement = $con->prepare( $query );
            $statement->execute( array( $input->name, $input->nickname, $input->email, $input->password, $input->gender, $input->birthdate, $input->picture, $input->format ) );

            $result = $statement->fetch( PDO::FETCH_ASSOC );
            return $result;
        }catch(PDOException $error){
            return $error;
        }
    }
}