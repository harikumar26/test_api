<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// get database connection
include_once '../config/database.php';
  
// instantiate product object
include_once '../objects/product.php';
include_once '../objects/accessToken.php';
  
$database = new Database();
$db = $database->getConnection();
  
$product = new Product($db);
$token = new AccessToken($db);
  
// get posted data
$data = json_decode(file_get_contents("php://input"));

  
// make sure data is not empty
if(
    !empty($data->name) &&
    !empty($data->price) &&
    !empty($data->description) &&
    !empty($data->category_id) &&
	!empty($data->accessToken)
){
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
  
    // set product property values
    $product->name = $data->name;
    $product->price = $data->price;
    $product->description = $data->description;
    $product->category_id = $data->category_id;	
    $product->created = $token->getCurrentTime();
  
    // create the product
    if($product->create()){
  
        // set response code - 201 created
        http_response_code(201);
  
        // tell the user
        echo json_encode(array("message" => "Product was created."));
    }else{
		$product->productunavailable();
    }
}else{
  $token->noasscessToken();
}
?>