<?php
class AccessToken{ 

    // database connection and table name
    private $conn;
    private $table_name = "accesstoken";
  
    // object properties
    public $accessToken;
	public $created;    
  
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
	
	// insert Access Token
	function create_accesToken($accesstoken){
		
		// query to insert record
		$query = "INSERT INTO
					" . $this->table_name . "
				SET
					accesstoken=:accesstoken, access_created_at=:access_created_at";	  
		
		$stmt = $this->conn->prepare($query);
	  
		// sanitize
		$this->accesstoken=htmlspecialchars(strip_tags($accesstoken->accessToken));
		$this->access_created_at=htmlspecialchars(strip_tags($accesstoken->created));
	  
		// bind values
		$stmt->bindParam(":accesstoken", $this->accesstoken);
		$stmt->bindParam(":access_created_at", $this->access_created_at);	  
		
		if($stmt->execute()){
			return true;
		}
	  
		return false;
	}
	
	// read products
	function read($accesstoken){		
		
		// select all query
		$query = "SELECT
					 p.access_created_at
				FROM
					" . $this->table_name . " p					
				WHERE
					p.accesstoken = ?";	  
		
		$stmt = $this->conn->prepare($query);

		$stmt->bindParam(1, $accesstoken);
		
		$stmt->execute();
		
		//return $stmt;
		// get retrieved row
		$row = $stmt->fetch(PDO::FETCH_ASSOC);	
		
			// set values to object properties
			$this->access_created_at = isset($row['access_created_at']) ? $row['access_created_at'] : "";
			
	}
	
	function noasscessToken(){
		// set response code - 400 Bad Gateway
		http_response_code(400);
	  
		// tell error message
		echo json_encode(
			array("message" => "Access token is invalid / Access token is missing.")
		);
		exit();
	}
	
	function getCurrentTime(){
		// Getting Singapore Timimg
		date_default_timezone_set('Asia/Singapore');

		return date("Y-m-d H:i:s", time());

	}
	
	function checkIfTokenIsValid($access_created_at){
		// Comparing the Current Timing and exiting timing
		$timeDiff = round(abs(strtotime($this->getCurrentTime()) - strtotime($access_created_at) ) / 60,2);		
		
		
		if($timeDiff > 30 ){
			// More that 30mins
			return false;
		} else {
			// less then 
			return true;
		}
	}
	
	
	
}


?>