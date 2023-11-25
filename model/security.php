<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/ease/config/databasehelper.php');

class SecurityModel{
    public function changePassword($data){
        $query = "call sp_change_password(? , ?, ?)";

        try{
            $db = new DataBaseHelper();
            $con = $db->getConnection();

            $statement = $con->prepare( $query );
            $statement->execute( array(
                $data['id'], 
                $data['newPassword'], 
                $data['password']) );

            $result = $statement->fetch(PDO::FETCH_ASSOC);

            return $result;
        } catch(PDOException $error){
            return $error;
        }
    }
}