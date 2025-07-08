<?php

/* Nicola Ward
   model file
*/
	
	#DATABASE CONNECTION DETAILS - UPDATE dsb (specifically the dbname in the string), dbuser (your student number) and dbpass (your password)
    $dsn = 'mysql:dbname=student1;host=127.0.0.1';
	$dbuser = 'student1';
	$dbpassword = 'CIS207Student1!';

	try {
		$db = new PDO($dsn, $dbuser, $dbpassword);
	} catch (PDOException $e) {
		echo 'Connection failed: ' . $e->getMessage();
	}

	# QUICK FUNCTIONS FOR SOME OF THE DATABASE TASKS:

   // FUNCTION TO GET ALL PRODUCTS (fetchall)
    function get_all_products() {
    	global $db;
    	$query = "SELECT * FROM products";
    	$statement = $db->prepare($query);
    	$statement->execute();
    	$results = $statement->fetchall();
    	$statement->closeCursor();
    	return $results;
    }

    // FUNCTION TO GET SINGLE PRODUCT (fetch)
    function get_product_by_id($product_id) {
    	global $db;
    	$query = "SELECT * FROM products WHERE id = :id";
    	$statement = $db->prepare($query);
    	$statement->bindValue(':id',$product_id);
    	$statement->execute();
    	$result=$statement->fetch();
    	$statement->closeCursor();
    	return $result;
    }

    function get_userid_by_username($username){ # ADDED FUNCTION
        global $db;
        $query = "SELECT * FROM users WHERE username = :username";
        $statement = $db->prepare($query);
        $statement->bindValue(':username', $username);
        $statement->execute();
        $result=$statement->fetch();
        $statement->closeCursor();
        return $result['id'];
    }


    # the check login function
    function check_login($username, $password){ # ADDED FUNCTION / WAS passwordHash
        global $db;
        $query = "SELECT * FROM users WHERE username = :username";
        $statement = $db->prepare($query);
        $statement->bindValue(':username', $username);
        $statement->execute();
        $result=$statement->fetch();
        $statement->closeCursor();
        # check if the password provided matches the one in the database
        if($password == $result['password']){ # WAS passwordHash
            return True;
        }else{
            return False;
        }
    }
	
	#CLASSES THAT REPRESENT DATABASE OBJECTS (ITEMS):
	
	#The Product object:
	class Product {
		private $id, $name, $description, $price;
		
		public function __construct($product_id){
			global $db;
			$query = "SELECT * FROM products WHERE id = :id";
			$statement = $db->prepare($query);
			$statement->bindValue(':id',$product_id);
			$statement->execute();
			$result=$statement->fetch();
			$statement->closeCursor();
			
			#set the properties of the class from the database record
			$this->id = $result['id'];
			$this->name = $result['name'];
			$this->description = $result['description'];
			$this->price = $result['price'];
		}	
		
		public function getName(){
			return $this->name;
		}
		
		public function getDescription(){
			return $this->description;
		}
		
		public function getPrice(){
			return $this->price;
		}
	}
	
	#NOW YOU TRY - CREATE ONE JUST LIKE THE ABOVE FOR THE USERS DATABASE TABLE
	
	#The User object:
	class User {
		private $id, $username, $password, $record;
		
		public function __construct($username){ # WAS $product_id
			global $db;
			$query = "SELECT * FROM users WHERE username = :username"; # WAS "SELECT * FROM products WHERE id = :id"
			$statement = $db->prepare($query);
			$statement->bindValue(':username',$username); # WAS ':id',$product_id
			$statement->execute();
			$result=$statement->fetch();
			$statement->closeCursor();
			
			#set the properties of the class from the database record
			$this->id = $result['id'];
			$this->username = $result['username'];
			$this->password = $result['password'];
			$this->record = $result['record'];
		}	
		
		public function getUsername(){
			return $this->username;
		}
		
		public function getPassword(){
			return $this->password;
		}
		
		public function getRecord(){
			return $this->record;
		}
	}

?>