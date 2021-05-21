<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// include database and object file
include_once '../config/database.php';
include_once '../objects/product.php';
include_once '../objects/accessToken.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
$product = new Product($db);
$token = new AccessToken($db);
  
// get product id
$data = json_decode(file_get_contents("php://input"));

// Access Token is not Null
if($data->accessToken!=null){
	
	// Getting Access Token Value
	$token->read($data->accessToken);
	
	// Access Token is empty
	if($token->access_created_at == null) {
		$token->noasscessToken();
	}
	//Checking Access valid or not
	$isValid = $token->checkIfTokenIsValid($token->access_created_at);	
	
	if($isValid == false){
		$token->noasscessToken();
	}
	// set product id to be deleted
	
	if($data->id == null){
		$product->productunavailable();
	}
	$product->id = $data->id;
	  
	// delete the product
	if($product->delete()){
	  
		// set response code - 200 ok
		http_response_code(200);
	  
		// tell the user
		echo json_encode(array("message" => "Product was deleted."));
		
	}else{	  
		$product->productunavailable();
	}
}else{
	$token->noasscessToken();
}


?>