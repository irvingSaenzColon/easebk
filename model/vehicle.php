<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/ease/config/databasehelper.php');

class VehicleModel{
    public function get($id){
        $query = "call sp_vehicle_actions(?, ?, ?, ?, ?, ?, ?)";

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
                'r'
            ) );

            $result = $statement->fetch(PDO::FETCH_ASSOC);

            return $result;

        } catch( PDOException $error ){
            return $error;
        }
    }

    public function getAll(){
        $query = "call sp_vehicle_actions(?, ?, ?, ?, ?, ?, ?)";

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
                'ra'
            ) );

            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

            return $result;

        } catch( PDOException $error ){
            return $error;
        }
    }

    public function create( $body ){
        $query = "call sp_vehicle_actions(?, ?, ?, ?, ?, ?, ?)";
    
        try{
            $db = new DataBaseHelper();
            $con = $db->getConnection();

            $statement = $con->prepare( $query );
            $statement->execute( array(
                null,
                $body['name'],
                $body['price'],
                $body['info'],
                $body['model'],
                $body['owner'],
                'c'
            ) );

            $result = $statement->fetch(PDO::FETCH_ASSOC);

            return $result;

        } catch( PDOException $error ){
            return $error;
        }
    }

    public function update( $body ){
        $query = "call sp_vehicle_actions(?, ?, ?, ?, ?, ?, ?)";
    
        try{
            $db = new DataBaseHelper();
            $con = $db->getConnection();

            $statement = $con->prepare( $query );
            $statement->execute( array(
                $body->id,
                $body->name,
                $body->price,
                $body->info,
                $body->model,
                null,
                'u'
            ) );

            $result = $statement->fetch(PDO::FETCH_ASSOC);

            return $result;

        } catch( PDOException $error ){
            return $error;
        }
    }

    public function delete( $id ){
        $query = "call sp_vehicle_actions(?, ?, ?, ?, ?, ?, ?)";
    
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
                'd'
            ) );

            $result = $statement->fetch(PDO::FETCH_ASSOC);

            return $result;

        } catch( PDOException $error ){
            return $error;
        }
    }

    public function insertImage($vehicleInfo){
        $query = "call sp_insert_image_vehicle(? ,? ,?)";

        try{
            $db = new DataBaseHelper();
            $con = $db->getConnection();

            $statement = $con->prepare( $query );
            $statement->execute( array(
                $vehicleInfo['id'],
                $vehicleInfo['data'],
                $vehicleInfo['format']
            ) );

            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $db->closeConnection();

            return $result;

        }catch(PDOException $error){
            return $error;
        }
    }

    public function getImageFromVehicle($id){
        $query = "call sp_get_images_from_vehicle( ? )";

        try{
            $db = new DataBaseHelper();
            $con = $db->getConnection();

            $statement = $con->prepare( $query );
            $statement->execute( array( $id ) );

            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            $db->closeConnection();

            return $result;
        }catch(PDOException $error){
            return $error;
        }
    }

    public function deleteImageFromVehicle($id){
        $query = "call sp_delete_image_from_vehicle( ? )";

        try{
            $db = new DataBaseHelper();
            $con = $db->getConnection();

            $statement = $con->prepare( $query );
            $statement->execute( array( $id ) );

            $result = $statement->fetch(PDO::FETCH_ASSOC);
            return $result;
        }catch(PDOException $error){
            return $error;
        }
    }

    public function getMyCars($id){
        $query = "call sp_my_car( ? )";

        try{
            $db = new DataBaseHelper();
            $con = $db->getConnection();

            $statement = $con->prepare( $query );
            $statement->execute( array( $id ) );

            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            $db->closeConnection();
            return $result;
            
        } catch( PDOException $error ){
            return $error;
        }
    }

    public function lastestPublished(){
        $query = "call sp_latest_cars( )";

        try{
            $db = new DataBaseHelper();
            $con = $db->getConnection();

            $statement = $con->prepare( $query );
            $statement->execute( array() );

            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            // $db->closeConnection();
            return $result;
            
        } catch( PDOException $error ){
            return $error;
        }
    }

    public function chepeast(){
        $query = "call sp_chepeast_cars( )";

        try{
            $db = new DataBaseHelper();
            $con = $db->getConnection();

            $statement = $con->prepare( $query );
            $statement->execute( );

            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            $db->closeConnection();
            return $result;
            
        } catch( PDOException $error ){
            return $error;
        }
    }

    public function sellers(){
        $query = "call sp_best_seller( )";

        try{
            $db = new DataBaseHelper();
            $con = $db->getConnection();

            $statement = $con->prepare( $query );
            $statement->execute( );

            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            $db->closeConnection();
            return $result;
            
        } catch( PDOException $error ){
            return $error;
        }
    }

    public function images(){
        $query = "call sp_vehicle_images( )";

        try{
            $db = new DataBaseHelper();
            $con = $db->getConnection();

            $statement = $con->prepare( $query );
            $statement->execute( );

            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            $db->closeConnection();
            return $result;
            
        } catch( PDOException $error ){
            return $error;
        }
    }

    public function search( $body ){
        $query = "call sp_search_vehicles( ?, ?)";

        try{
            $db = new DataBaseHelper();
            $con = $db->getConnection();

            $statement = $con->prepare( $query );
            $statement->execute( array($body['name'], $body['category']) );

            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            if($result == null)
             $result = array();
            $db->closeConnection();
            return $result;
            
        } catch( PDOException $error ){
            return $error;
        }
    }
}