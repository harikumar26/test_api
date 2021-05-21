<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
// include database and object files
include_once '../config/database.php';
include_once '../objects/product.php';
include_once '../objects/accessToken.php';
  
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
  
$product = new Product($db);
$token = new AccessToken($db);

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
	// get keywords
	$keywords=isset($_GET["s"]) ? $_GET["s"] : "";
	  
	// query products
	$stmt = $product->search($keywords);
	$num = $stmt->rowCount();
	  
	// check if more than 0 record found
	if($num>0){
	  
		// products array
		$products_arr=array();
		$products_arr["records"]=array();	  
		
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){			
			extract($row);	  
			$product_item=array(
				"id" => $id,
				"name" => $name,
				"description" => html_entity_decode($description),
				"price" => $price,
				"category_id" => $category_id,
				"category_name" => $category_name
			);
	  
			array_push($products_arr["records"], $product_item);
		}
	  
		// set response code - 200 OK
		http_response_code(200);
	  
		// show products data
		echo json_encode($products_arr);
	}else{
		$product->productnotfound();
	}
}else{
	$token->noasscessToken();
}
  

?>
