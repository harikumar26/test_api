<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
  
// include database and object files
include_once '../config/database.php';
include_once '../objects/product.php';
include_once '../objects/accessToken.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
$product = new Product($db);
$token = new AccessToken($db);
  
// set ID property of record to read
$product->id = isset($_GET['id']) ? $_GET['id'] : die();

// get posted data for accessToken
$data = json_decode(file_get_contents("php://input"));

//Data is empty
if(empty($data)){
	$token->noasscessToken();	
}

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
	
	// read the details of product to be edited
	$product->readOne();
	  
	if($product->name!=null){
		// create array
		$product_arr = array(
			"id" =>  $product->id,
			"name" => $product->name,
			"description" => $product->description,
			"price" => $product->price,
			"category_id" => $product->category_id,
			"category_name" => $product->category_name
	  
		);
	  
		// set response code - 200 OK
		http_response_code(200);
	  
		// make it json format
		echo json_encode($product_arr);
	}else{
		$product->productnotfound();
	}
}else{
	$token->noasscessToken();
}
  

?>