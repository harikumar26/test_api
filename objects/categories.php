<?php
class Categories{ 

    // database connection and table name
    private $conn;
    private $table_name = "categories";
  
    // object properties
    public $id;
    public $name;
    public $description;
    public $created;
  
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

	// read products
	function read(){		
		// select all records
		$query = "SELECT
					p.id, p.name, p.description, p.created
				FROM
					" . $this->table_name . " p					
				ORDER BY
					p.created DESC";	  
		
		$stmt = $this->conn->prepare($query);		
		
		$stmt->execute();	
		
		return $stmt;
	}
	
	// create product
	function create(){  
		// query to insert record
		$query = "INSERT INTO
					" . $this->table_name . "
				SET
					name=:name, description=:description, created=:created";
	  
		
		$stmt = $this->conn->prepare($query);
		
		// sanitize
		$this->name=htmlspecialchars(strip_tags($this->name));
		$this->description=htmlspecialchars(strip_tags($this->description));
		$this->created=htmlspecialchars(strip_tags($this->created));
	  
		// bind values
		$stmt->bindParam(":name", $this->name);
		$stmt->bindParam(":description", $this->description);
		$stmt->bindParam(":created", $this->created);	  
		
		if($stmt->execute()){
			return true;
		}
	  
		return false;
		  
	}	
	
	
	//products not found
	function productnotfound(){
		// set response code - 404 Not found
		http_response_code(404);
	  
		// tell the user no products found
		echo json_encode(
			array("message" => "No products found.")
		);
		exit();
	}
	
	//service unavailable
	function productunavailable(){
		// set response code - 503 service unavailable
		http_response_code(503);
	  
		// tell the user
		echo json_encode(array("message" => "Unable to update product."));
		exit();
	}
	
}


?>