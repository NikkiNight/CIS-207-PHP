<html>
<head>
<title>Contact Us</title>
</head>
<body>
	Check out our products: <br />
	<ol>
		<!-- Hint: you will need to customize this depending on the name of your database columns -->
		<?php foreach ($products as $product): ?> 
	      		<li><a href="index.php?action=productDetails&productID=<?=$product['id'] ?>"><?=$product['name'] ?></a></li>
		<?php endforeach; ?>
	</ol>
	<br />
	Some actions you can take: <br />
	<ul>
		<li><a href="index.php?action=viewCart">View your cart</a></li>
		<li><a href="index.php?action=logout">Log out</a></li>
		<li><a href=“index.php?action=contact”>Contact Us</a></li>
</body>
</html>