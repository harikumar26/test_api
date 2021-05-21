<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// include database and object files
include_once '../config/database.php';
include_once '../objects/categories.php';
include_once '../objects/accessToken.php';

  
// instantiate database and object
$database = new Database();
$db = $database->getConnection();

$categories = new Categories($db);
$token = new AccessToken($db);

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
	
	$stmt = $categories->read();
	$num = $stmt->rowCount();
	
	// check if more than 0 record found
	if($num>0){
	  
		// products array
		$categories_arr=array();
		$categories_arr["records"]=array();	  
		
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);	  
			$categories_item=array(
				"id" => $id,
				"name" => $name,
				"description" => html_entity_decode($description),
			);
	  
			array_push($categories_arr["records"], $categories_item);
		}
	  
		// set response code - 200 OK
		http_response_code(200);
	  
		// show products data in json format
		echo json_encode($categories_arr);
	}else{	  
		$categories->productnotfound();
	}	
}else{
	$token->noasscessToken();
}
?>