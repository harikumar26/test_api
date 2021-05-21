<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// include database and object files
include_once '../config/database.php';
include_once '../objects/product.php';
include_once '../objects/accessToken.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
$product = new Product($db);
$token = new AccessToken($db);
  
// get id of product to be edited
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
	// set ID property of product to be edited
	$product->id = $data->id;
	  
	// set product property values
	$product->name = $data->name;
	$product->price = $data->price;
	$product->description = $data->description;
	$product->category_id = $data->category_id;
	  
	// update the product
	if($product->update()){
	  
		// set response code - 200 ok
		http_response_code(200);
	  
		// tell the user
		echo json_encode(array("message" => "Product was updated."));
	}else{
	  $product->productunavailable();
	}
}else{
	$token->noasscessToken();
}
  

?>