<html>
<head>
<title>Contact Us</title>
</head>
<body>
<?php if ($product !== NULL): ?>
	Here are your selected product details: 
	<!-- you will have to update this to reflect the columns in your database -->
	<ul>
		<li>Name: <?= $product['name'] ?></li>
		<li>ID: <?= $product['id'] ?></li>
		<li>Price: $<?= $product['price'] ?></li>
		<!-- go through and display all of your database columns in the format above -->
	</ul><br>
	<a href="index.php?action=addToCart&productID=<?= $product['id'] ?>">Add to cart</a>
<?php else: ?>
	<h2>Sorry! We can’t find that product.</h2>
<?php endif; ?>
<br />
<a href="index.php">Return Home</a>
</body>
</html>