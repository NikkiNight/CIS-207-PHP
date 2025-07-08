<html>
<head>
<title>Your Cart</title>
</head>
<body>
<!-- here we provide messages based on if an item was added or removed from the cart -->
	<?php if ($productRemoved): ?>
		<h3>Your product was successfully removed from your cart.</h3><br /><br />
	<?php endif; ?>
	<?php if ($productAdded): ?>
		<h3>Your product was successfully added to your cart.</h3><br /><br />
	<?php endif; ?>

	<?php if($cartEmpty): ?>
		<h3>Your cart is empty. Get to shopping!</h3>
	<?php else: ?>
		<ul>
		<?php foreach($cartProducts as $product): ?>
			<!-- HINT: You will need to update these to match your datbase fields! -->
			<li>Product Name: <?= $product['name'] ?><br>
				Product Price: <?= $product['price'] ?><br>
				<!-- add the rest of your product columns here -->
				<a href="index.php?action=removeFromCart&productID=<?= $product['id']?>">Remove from cart</a>
				<br />
			</li>
		<?php endforeach; ?>
		</ul>
	<?php endif; ?>
	<br /><br />
	<a href="index.php">Return Home</a>
</body>
</html>