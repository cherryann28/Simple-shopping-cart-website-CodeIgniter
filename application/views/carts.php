<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="<?= base_url('assets/css/style1.css')?>">
	<title>Shopping spree</title>
</head>
<body>
	<div class="store">
		<div class="nav">
			<h1>Shantal's Chlothing Store</h1>
			<h2>New Arrival</h2>
			<p><a href="<?= base_url('carts/checkout')?>">Cart</a>(<?= $products['cart']?>)</p>
		</div>
		<div class="items">
			<p class="error"><?= $this->session->flashdata('error')?></p>
			<p class="success"><?= $this->session->flashdata('success')?></p>
<?php
		foreach($products['items'] as $product){
?>
			<form action="<?= base_url('carts/add_to_cart')?>" method="post">
				<p class="img"><img src="<?= base_url('assets/image/'. $product['imagefile'])?>" alt="<?= $product['description']?>"></p>
				<div class="label">
					<label for="t-shirt"><?= ucfirst($product['item_name']) . " " . '$'. $product['price']?></label>
				</div>
				<input type="number" name="quantity" min="0" max="30" placeholder="0">
				<input type="hidden" name="item" value="<?= $product['id']?>">
				<input type="submit" value="Buy">
			</form>
<?php		}	?>
			
		</div>
	</div> 
</body>
</html>    