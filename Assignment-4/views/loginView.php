<html>
<head>
<title>Your Cart</title>
</head>
<body>
	<?php if($badLogin): ?>
		<h3>Login incorrect. Try again!</h3>
	<?php endif; ?>
	<?php if($showForm): ?>
		<!-- CREATE THE LOGIN FORM HERE -->
		<form method="post">
			<input type="text" name="username"><br>
			<input type="password" name="password"><br>
			<input type="submit" value="Log In">
		</form>
	<?php else: ?>
		<h4>You are logged in. <a href="index.php?action=logout">Log out</a></h4>
	<?php endif; ?>
	<br /><br />
	<a href="index.php">Return Home</a>
</body>
</html>