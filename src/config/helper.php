<?php

class helper{

    function select($sql){
        try{
            $db = new database();
            $db = $db->conexionDb();                 
            $resultado = $db->query($sql); 
            $resultado = $resultado->fetchAll(PDO::FETCH_ASSOC);            
            $db = null; 
            return $resultado;
        } catch( PDOException $e ) {
            $message = array('error'=> $e->getMessage());
            return $message;
        }
    }

    function preparedStatement($sql, $params){
        try{
            $db = new database();
            $db = $db->conexionDb();                 
            $resultado = $db->prepare($sql);
            $resultado->execute($params);
            $resultado = $resultado->fetchAll(PDO::FETCH_ASSOC);           
            $db = null; 
            return $resultado;

            return $rows;
        } catch( PDOException $e ) {
            $message = array('error'=> $e->getMessage());
            return $message;
        }
    }

    function execute($sql, $params){
        try{
            $db = new database();
            $db = $db->conexionDb();                 
            $resultado = $db->prepare($sql);
            $resultado = $resultado->execute($params);            
            $db = null; 
            return $resultado;
        } catch( PDOException $e ) {
            $message = array('error'=> $e->getMessage());
            return $message;
        }
    }
}