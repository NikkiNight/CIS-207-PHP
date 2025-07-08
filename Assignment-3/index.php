<?php

/*  
	Nicola Ward
	CIS 207 Assignment 3
	DATE
*/

/*
	-------------------------------------------------------------------------
	| The controller code for routing user actions to functions starts here |
	-------------------------------------------------------------------------
 */

# Here we declare and set/reset the $action PHP variable for reach run of the application (request)
$action = NULL;

# Here we look for the "action" GET parameter and, if present, assign to the above declared $action PHP variable.
# If the "action" GET parameter is not present, the $action PHP variable will remain set to NULL, thus triggering the DEFAULT condition in the switch statement.
if (isset($_GET['action'])){
	$action = filter_input(INPUT_GET, 'action');
}

# Check if the person is logged in and set a global variable for it.
session_start();
$authenticated = isset($_SESSION['logged_in']);

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

	# The login page
	case "login":
		login();
		break;

	# The logout page
	case "logout":
		logout();
		break;

	# The 'secret' page only accessible to logged in users
	case "secret":
	    # Check that that user is authenticated
		if ($authenticated){
			secretPage();
		}else{
			#They aren't authenticated, send them to the login page
			header("Location: index.php?action=login");
		}
		break;

	# An unrecognized or no action (NULL) was found so we call the home() function to display the main page
	default:
		home();
		break;
}


/*
	----------------------------------------------------------------
	| The controller functions for application actions starts here |
	----------------------------------------------------------------
 */

# The login function. Finishe this code for your assignment using sessions
function login(){
	# Create a variable to check for errors to show an error message if needed
	$error = false;

	# check for the error flag in the GET request
	if (isset($_GET['error']) && $_GET['error'] == 'true'){
		$error = true;
	}

	# the form was submitted, so we initiate the login and redirect to the "secret" page
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){

		# For this assignment, we set the username and password in the code
		# NEVER DO THIS IN REAL LIFE - you would normally get this from a database
		$username = "username"; #create a username you want to use
		$password = "password"; #create a password you want to use

		# These are what the user submitted - you are going to check these against what 
		# you set above in $username and $password
		$posted_username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
		$posted_password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);

		# Finish the rest of the assignment below...
		# You need to: get the username and password from the POST, check them against the variables,
		if ($posted_username == $username && $posted_password == $password){
			# session_start();
			$_SESSION['logged_in'] = True;
			# direct to secret page
			header("Location: index.php?action=secret");
		}
		else {
			$error = true;
			# direct to login page
			# header("Location: index.php");
		}
		
		# if they match set the session 'logged_in' to true and redirect them to the 'secret' page with
		# header("Location: index.php?action=login");
		# If the information does not match, set $error = true; to show the error message
		# remember to do session_start() and $_SESSION['logged_in'] = true; if the login info matches

	}
	include('views/loginView.php');
}

# the logout function
function logout(){
	session_start();
	unset($_SESSION["logged_in"]); 
	header("Location: index.php?action=login");
}

# This is the "secret" page ONLY accessible by being logged in
function secretPage(){
	global $authenticated; # ADDED
	
	if ($authenticated){
		# They are authenticated, so show them the 'secret' page
		include('views/secretPage.php');
	}else{
		# They are not authenticated, so send them to the login page
		header("Location: index.php?action=login");
		exit();
	}
}

# The contact function (action) that displays a form OR user supplied data depending on if POST data is present
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


# The home function that displays the home page
function home(){
	include('views/homeView.php');
}

# Add more functions below as needed ... 

?>