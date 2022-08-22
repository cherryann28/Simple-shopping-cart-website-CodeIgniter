<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('assets/css/style1.css')?>">
    <title>Checkout</title>
</head>
<body>
    <div class="checkout">
        <div class="nav">
			<h1>Shantal's Chlothing Store</h1>
			<p><a href="<?= base_url('carts')?>">Catalog</a></p>
		</div>
        <div class="table_data">
            <h2>Checkout</h2>
            <h3>Total: $<?= !empty($products['total_price']) ? $products['total_price'] : '0'?></h3>
            <p class="remove"><?= $this->session->flashdata('remove')?></p>
            <table>
                <tr>
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
<?php foreach($products['items'] as $items){ ?>
                <tr>
                    <td><?= $items['item_name']?></td>
                    <td><?= $items['quantity']?></td>
                    <td><?= $items['price']?></td>
                    <td><a href="<?= base_url('carts/remove_item/'. $items['item_id'])?>">X</a></td>
                </tr>
<?php } ?>
            </table>
        </div>
        <div class="billing_info">
            <h2>Billing Info</h2>
            <form action="" method="post">
                <label for="name">Name:</label>
                <input type="text" name="name">
                <label for="address">Address:</label>
                <input type="text" name="address">
                <label for="card_number">Card number:</label>
                <input type="text" name="card_number">
                <input type="submit" value="Submit Order">
            </form>
        </div>
    </div>
</body>
</html>