<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/core.php';
include_once '../config/database.php';
include_once '../objects/etaller.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$etaller = new Etaller($db);
 
// set ID property of record to read
$keywords = isset($_GET["s"]) ? $_GET["s"] : "";
 
// read the details of product to be edited
$stmt = $etaller->search($keywords);
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // products array
    $etaller_arr=array();
    $etaller_arr["records"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $etaller_item=array(
            "idetaller" => $idetaller,
            "fecha_str" => $fecha_str,
            "fecha"     => $fecha,
            "total"     => $total
        );
 
        array_push($etaller_arr["records"], $etaller_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show products data
    echo json_encode($etaller_arr);
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no products found
    echo json_encode(
        array("message" => "No products found.")
    );
}
?>