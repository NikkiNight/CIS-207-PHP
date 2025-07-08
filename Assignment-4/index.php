<?php

/*  
	Nicola Ward
	CIS 207 / Assignment 4
	4/26/2024
*/

require('model.php');


/*
	-------------------------------------------------------------------------
	| The controller code for routing user actions to functions starts here |
	-------------------------------------------------------------------------
 */

# Here we declare and set/reset the $action PHP variable for reach run of the application (request)
$action = NULL;

# Here we look for the "action" GET parameter and, if present, assign to the above declared $action PHP variable.
# If the "action" GET parameter is not present, the $action PHP variable will remain set to NULL.
if (isset($_GET['action'])){
	$action = filter_input(INPUT_GET, 'action');
}

# Set the authenticated flag to its default value, false.
session_start();
	$authenticated = isset($_SESSION['userid']); # INDENTED

# Here we check if someone is logged in and set the appropriate flag. 
# If they  are not logged in, we send the flag to the LOGIN page.
if (!$authenticated && $action != "login"){
	# they're not authenticated, so send them to the LOGIN page (action)
	header("Location: index.php?action=login"); # <------------------------------------------------------------------------------------------ POSSIBLE REDIRECT PROBLEM
	# stop running other code for the application
	exit();
}

/* 
	Here, below, we evaluate the PHP $action variable value and run the appropriate function. 
	You can call functionss here before they are defined because PHP compiles the 
	entire file at once, thus you can call functions coded later in the file. 
	Keeping this at the top makes the file easier to read and maintain as we add more code later.
 */
switch($action){

	# The variable $action = "contact" so we call the contact() function
	case "contact":
		contact();
		break;

	case "login":
		login();
		break;

	case "logout":
		logout();
		break;

	case "viewCart":
		view_cart();
		break;

	case "addToCart":
		$productID = NULL;
		if (isset($_GET['productID'])){
			$productID = filter_input(INPUT_GET, 'productID');
		}
		add_to_cart($productID);
		break;

	case "removeFromCart":
		$productID = NULL;
		if (isset($_GET['productID'])){
			$productID = filter_input(INPUT_GET, 'productID');
		}
		remove_from_cart($productID);
		break;

	# The variable $action = "productDetails" so we get the productID GET parameter and call productDetails()
	case "productDetails":
		# Here we declare and set/reset the $productID PHP variable
		$productID = NULL;

		# Here we check if the productID GET parameter is set and assign it, otherwise it remains NULL
		if (isset($_GET['productID'])){
			$productID = filter_input(INPUT_GET, 'productID');
		}
		productDetails($productID);
		break;

	# An unrecognized or no action (NULL) was found so we call the home() function to display the main page
	default:
		if ($authenticated){
			home();
		}else{
			login();
		}
		break;
}


/*
	----------------------------------------------------------------
	| The controller functions for application actions starts here |
	----------------------------------------------------------------
 */

# The contact function (action) that displays a form OR user supplied data
function contact(){

	# Here we declare and set/reset the $postData variable to its default value (false).
	# It is good practice to declare and reset these types of variables in the beggning of a function.
	$postData = false;

	# Here we check to see if the form was submitted (i.e. if the server request method was POST)
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){

		# The form was submitted, so we set the $postData PHP variable to true.
		# Setting this to true will trigger hiding the form and showing the submitted data in the view.
		$postData = true;

		# Here you get, filter, and assign the posted information to variables for use in the view.
		# You may need to customize these based on what fields you have in your HTML form.
		$first_name = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_SPECIAL_CHARS);
		$last_name = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_SPECIAL_CHARS);
		$comments = filter_input(INPUT_POST, 'comments', FILTER_SANITIZE_SPECIAL_CHARS);
		$favorite_instruments = $_POST['favorite_instruments'];

	}
	include('views/contactView.php');
}


# The home function that displays all products (with links to each) and a link to the contact page
function home(){
	global $authenticated;
	#let's do another authentication check because you can never be too sure
	if ($authenticated){
		# Here we call the model function that gets all products from the database
		$products = get_all_products();
		include('views/homeView.php');
	}else{
		header("Location: index.php?action=login");
		exit();
	}
}


# The product details function (action) that displays details for a selected $productID
function productDetails($productID){

    # Here we declare and reset the $product variable to NULL in case $productID is not set.
    # It is good practice to declase and reset these types of variables in the beginning of a function.
    $product = NULL;

	if ($productID !== NULL){
		# Here we call the model function to get the product selected from the database
		$product = get_product_by_id($productID);
	}
	include('views/productDetailsView.php');
}


# the add to cart function
function add_to_cart($productID){
	if ($productID !== NULL){
		$product = get_product_by_id($productID);
		session_start();
		# check if the product session is already set
		if (!isset($_SESSION['products'])) {
			# it's not set, so we create it
	    	$_SESSION['products'] = array();
		}
		# add the product to the cart (product session array)
		array_push($_SESSION['products'], $product['id']);
		header("Location: index.php?action=viewCart&productAction=added");
	}else{
		home();
	}
}


# the remvove from cart function
function remove_from_cart($productID){
	if ($productID !== NULL){
		session_start();
		
		# REMOVE FROM CART
		$key = array_search($productID, $_SESSION['products']);
		if ($key !== false) {
			unset($_SESSION['products'][$key]);
		}
		
		#unset($_SESSION['products'][$productID]); WAS UNCOMMENTED
		header("Location: index.php?action=viewCart&productAction=removed");
	}else{
		home();
	}
}


# the view cart function
function view_cart(){
	$cartEmpty = False;
	$productAdded = False;
	$productRemoved = False;
	$cartProducts = array();
	if (isset($_GET['productAction']) && $_GET['productAction'] == "added"){
		$productAdded = True;
	}elseif (isset($_GET['productAction']) && $_GET['productAction'] == "removed"){
		$productRemoved = True;
	}
	session_start();
	if (isset($_SESSION['products'])){
		foreach($_SESSION['products'] as $productID){
			# this would be a good place for a try-catch block. Try adding one.
			$product = get_product_by_id($productID);
			if (isset($product) && $product != NULL){
				array_push($cartProducts, $product);
			}
			$product = NULL;
		}
	}else{
		$cartEmpty = True;
	}
	include('views/cartView.php');
}


# The login page which displays if someone is not authenticated
function login(){
	$showForm = True;
	$badLogin = False;
	global $authenticated;
	# if the user is not authenticated, we run this code
	if (!$authenticated){
		# check if the user submitted the form
		if (isset($_POST)){
			$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
			$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
			#$passwordHash = password_hash($password, PASSWORD_DEFAULT); WAS UNCOMMENTED
			if (check_login($username, $password)){ # WAS $passwordHash
				# they successfully logged in, so set the session and send them to the homepage (reload the application)
				session_start();
				$_SESSION['userid'] = get_userid_by_username($username);				
				#header("Location: index.php"); <----------------------------------------------------------------------------------------------- REDIRECT PROBLEM
				#exit(); #WAS UNCOMMENTED <----------------------------------------------------------------------------------------------------- REDIRECT PROBLEM
			}else{
				# it was a bad login, so set the flag to show an error message in the view
				$badLogin = True;
			}
		}
	}else{
		# they are authenticated, so hide the login form
		$showForm = False;
	}
	include('views/loginView.php');
}


# the logout function
function logout(){
	session_start();
	unset($_SESSION["userid"]); 
	header("Location: index.php?action=login");
}

?>