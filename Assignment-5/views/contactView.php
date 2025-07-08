<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the form is submitted

    // Extract data
    $first_name = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING);
    $last_name = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING);
    $favorite_instruments = filter_input(INPUT_POST, 'favorite_instruments', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY); // Array   
    $comments = filter_input(INPUT_POST, 'comments', FILTER_SANITIZE_STRING);
    ?>

	<!--ADDED 4/18/2024 Regular Expressions Code-->
	
<?php
	//Check if first name and last name contain digits, if so, echo error
	
	if (preg_match("/[0-9]/", $first_name) || preg_match("/[0-9]/", $last_name)) {
		echo 'Error. Name and last name cannot contain digits.<br>';
	} // End if
	
    	$specialChars = "/[!@#$%^&*()]+/"; // Declare special characters

    	if (preg_match($specialChars, $comments)) {
        	echo 'Error. Comment cannot contain special characters.';
    	} // End if
	
	?>

	

    <!-- Display submitted data -->
    <h3>Here is your submitted data:</h3><br />
    <ul>
        <li>First Name: <?=$first_name ?></li>
        <li>Last Name: <?=$last_name ?></li>
        <li>Favorite Instruments:
            <?php foreach ($favorite_instruments as $instrument) : ?>
                <?=htmlspecialchars($instrument) ?> 
            <?php endforeach; ?>
        </li>
        <li>Comments: <?=$comments ?></li>        
    </ul>
    <?php
} else {
    // Display the form if it's not submitted
    ?>
    <form method="post" action="">
        <input type="text" name="first_name"><br />
        <input type="text" name="last_name"><br />
        Select your favorite instruments: <br />
        <select name="favorite_instruments[]" multiple>
            <option value="guitar">Guitar</option>
            <option value="piano">Piano</option>
            <option value="trombone">Trombone</option>
            <option value="saxophone">Saxophone</option>
        </select>
        <br />
        Write some comments: <br />
        <input type="text" name="comments" rows="4" cols="50">
        <br /> <br />
        <input type="submit" value="Submit">
    </form>
    <?php
}
?>
