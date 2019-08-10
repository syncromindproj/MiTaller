<?php
class Etaller{
    // database connection and table name
    private $conn;
    private $table_name = "etaller";
 
    // object properties
    public $idetaller;
    public $fecha;
    public $nroplaca;
    public $pricarchivo;
    public $descripcion;
    public $estado;
    
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
    function read()
    {
        // select all query
        $query = "SELECT * from etaller";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }

    // search products
    function search($keywords){
    
        // query to read single record
        $query = "SELECT idetaller, DATE_FORMAT(fecha, '%d/%m/%Y') as fecha_str, fecha, count(*) as total FROM etaller WHERE nroplaca = ? GROUP by fecha desc";
        
        // prepare query statement
        $stmt = $this->conn->prepare( $query );

        // sanitize
        $keywords = htmlspecialchars(strip_tags($keywords));
        //$keywords = "%{$keywords}%";
        
        // bind
        $stmt->bindParam(1, $keywords);
        // execute query
        $stmt->execute();
 
        return $stmt;
        //print_r($stmt);
    }
	
	// search products
    function search_images($placa, $fecha){
    
        // query to read single record
        $query = "SELECT * from etaller WHERE nroplaca = ? and fecha = ?";
        
        // prepare query statement
        $stmt = $this->conn->prepare( $query );

        // bind
        $stmt->bindParam(1, $placa);
        $stmt->bindParam(2, $fecha);
        // execute query
        $stmt->execute();
 
        return $stmt;
        //print_r($stmt);
    }
}
?>