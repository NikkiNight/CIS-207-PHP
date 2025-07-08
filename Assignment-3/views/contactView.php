<head>
<title>Contact Us</title>
</head>
<body>
<?php if ($postData) : ?>
	<!-- insert code and HTML here to display the submitted data using the variables from the controller (examples are in the text and lecture slides and one is below). Hint: the $favorite_instruments is an array, so loop through it -->
	<h3>Here is your submitted data:</h3><br />
	<ul>
		<li>First Name: <?=$first_name ?></li>
		<!-- Code the rest to display the rest here -->
	</ul>
<?php else: ?>
	<form method="post" action="self">
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
<?php endif; ?>
</body>
</html>