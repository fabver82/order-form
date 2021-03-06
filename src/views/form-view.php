<?php // This file is mostly containing things for your view / html 
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" type="text/css"
        rel="stylesheet" />
    <title>Your fancy store</title>
</head>

<body>
    <div class="container">
        <h1>Place your order</h1>
        <?php // Navigation for when you need it 
        ?>

        <nav>
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link active" href="?food=1">Order food</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?food=0">Order drinks</a>
                </li>
            </ul>
        </nav>
        <?php
        if (isset($_GET['error'])) { ?>
        <div class="alert alert-danger" role="alert">
            <p>Please check the following fields: </p>
            <?php foreach ($_SESSION['errors'] as $error) { ?>
            <p><?= $error ?></p>
            <?php } ?>
        </div>
        <?php }
        if (isset($_GET['order'])) { ?>
        <div class="alert alert-success" role="alert">
            <p>Confirmation of your order</p>
            <p>You have ordered are :</p>
            <ul>
                <?php
                    foreach ($order['products'] as $id_product) {
                        echo "<li>" . $products[$id_product]['name'] . "</li>";
                    }
                    ?>
            </ul>
            <p>To be delivered to <?= $order['street'] ?>, <?= $order['streetNumber'] ?>, <?= $order['zipcode'] ?>
                <?= $order['city'] ?></p>
        </div>
        <?php } else { ?>
        <form method="post" action="../controllers/order.php">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="email">E-mail:</label>
                    <input type="email" id="email" name="email" class="form-control" value="<?= $order['email'] ?>" />
                </div>
                <div></div>
            </div>

            <fieldset>
                <legend>Address</legend>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="street">Street:</label>
                        <input type="text" name="street" id="street" class="form-control"
                            value="<?= $order['street'] ?>" placeholder="Street">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="streetnumber">Street number:</label>
                        <input type="text" id="streetnumber" name="streetnumber" value="<?= $order['streetNumber'] ?>"
                            class="form-control">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="city">City:</label>
                        <input type="text" id="city" name="city" class="form-control" value="<?= $order['city'] ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="zipcode">Zipcode</label>
                        <input type="text" id="zipcode" name="zipcode" class="form-control"
                            value="<?= $order['zipcode'] ?>">
                    </div>
                </div>
            </fieldset>

            <fieldset>
                <legend>Products</legend>
                <?php foreach ($products as $i => $product) : ?>
                <label>
                    <?php // <?= is equal to <?php echo 
                            ?>
                    <input type="checkbox" value="<?= $i ?>" name="products[<?php echo $i ?>]"
                        <?= productIsChecked($i, $order['products']) ?> />
                    <?php echo $product['name'] ?>
                    -
                    &euro; <?= number_format($product['price'], 2) ?></label><br />
                <?php endforeach; ?>
            </fieldset>

            <button type="submit" class="btn btn-primary">Order!</button>
        </form>
        <?php } ?>
        <footer>You already ordered <strong>&euro; <?php echo $totalValue ?></strong> in food and drinks.</footer>
    </div>

    <style>
    footer {
        text-align: center;
    }
    </style>
</body>

</html>