<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// database connection will be here

// include database and object files
include_once '../config/database.php';
include_once '../objects/product.php';
include_once '../objects/accessToken.php';
include_once '../config/aescipher1_helper.php';
  
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();  

$product = new AccessToken($db);

$text = "cartrack";
//new Encrypted		
$secretKey1 = '5676dabc7160420da0b7cf175ae94a42';
$encrypted1 = aescipher1::encrypt($secretKey1, $text);

// set product property values
$product->accessToken = $encrypted1->getData();
date_default_timezone_set("Asia/Singapore");
$product->created = date('Y-m-d H:i:s');


if($product->create_accesToken($product)){
	 // set response code - 200 OK
	http_response_code(200);
	
	$accessToken=array(
		"access-token" => $encrypted1->getData(),
		"expires_in" => 1800,            
	);
	//array_push();
  
	// show products data in json format
	echo json_encode(array($accessToken));
}
