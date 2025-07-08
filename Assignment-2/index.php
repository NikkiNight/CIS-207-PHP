<?php

/*  
	Student Name: Nicola Ward
	Class / Assignment: CIS 207 Assignment 2 MVC
	Date Created: 2/8/2024
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
		$favorite_instruments = filter_input(INPUT_POST, 'favorite_instruments', FILTER_SANITIZE_SPECIAL_CHARS); // ARRAY CODE
		$comments = filter_input(INPUT_POST, 'comments', FILTER_SANITIZE_SPECIAL_CHARS);
		//!!! TODO: complete for the rest of the fields in the form here !!!
	}
	include('views/contactView.php');
}


# The home function that displays the home page
function home(){
	include('views/homeView.php');
}

# Add more functions below as needed ... 

?>
