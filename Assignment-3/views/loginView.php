<head>
<title>Log In</title>
</head>
<body>
	<h3>Log In</h3>
	<?php if ($error) : ?>
		<p style="color:red">Invalid login information</p>
	<?php endif; ?>
	<form method="post">
		<input type="text" name="username"><br />
		<input type="password" name="password"><br />
		<input type="submit" value="Submit">
	</form>
</body>
</html>