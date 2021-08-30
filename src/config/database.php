<?php

class database{
    // Propiedades localhost
    private $dbHost = "localhost";
    private $dbUser = "root";
    private $dbPassword = "";
    private $dbName = "ventas";    

    // Conexión
    public function conexionDb(){        
        $mysqlConnect = "mysql:host=$this->dbHost;dbname=$this->dbName;charset=utf8";
        $dbConexion = new PDO($mysqlConnect, $this->dbUser, $this->dbPassword);
        $dbConexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
        
        return $dbConexion;
    }
}