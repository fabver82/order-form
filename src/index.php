<?php

// This file is your starting point (= since it's the index)
// It will contain most of the logic, to prevent making a messy mix in the html

// This line makes PHP behave in a more strict way
declare(strict_types=1);

// We are going to use session variables so we need to enable sessions
session_start();

// Use this function when you need to need an overview of these variables
function whatIsHappening()
{
    echo '<h2>$_GET</h2>';
    var_dump($_GET);
    echo '<h2>$_POST</h2>';
    var_dump($_POST);
    echo '<h2>$_COOKIE</h2>';
    var_dump($_COOKIE);
    echo '<h2>$_SESSION</h2>';
    var_dump($_SESSION);
}
function getTotalValue($product_ids, $products)
{
    $sum = 0;
    foreach ($product_ids as $id) {
        $sum += $products[$id]['price'];
    }
    return $sum;
}
function productIsChecked($id, $products)
{
    foreach ($products as $product) {
        if ($product == $id) {
            return 'checked';
        }
    }
}

$products = [
    ['name' => 'Pizza Margharita', 'price' => 2.5],
    ['name' => 'Hamburger', 'price' => 4.5],
    ['name' => 'Cheeseburger', 'price' => 3],
    ['name' => 'Club Sandwich', 'price' => 2.5],
];

$totalValue = 0;
if (isset($_SESSION['errors'])) {
    $order = [
        'email' => $_SESSION['order']['email'],
        'street' => $_SESSION['order']['street'],
        'streetNumber' => $_SESSION['order']['streetNumber'],
        'city' => $_SESSION['order']['city'],
        'zipcode' => $_SESSION['order']['zipcode'],
        'products' => $_SESSION['order']['products'],
    ];
    $totalValue = getTotalValue($_SESSION['order']['products'], $products);
} else {
    $order = [
        'email' => '',
        'street' => '',
        'streetNumber' => '',
        'city' => '',
        'zipcode' => '',
        'products' => [],
    ];
}

if (isset($_GET['order'])) {
    $id = $_GET['order'];
    require_once('./models/OrderModel.php');
    require_once('./utilities/DatabaseManager.php');
    require_once './config.php';
    $databaseManager = new DatabaseManager(CONFIG['host'], CONFIG['user'], CONFIG['password'], CONFIG['dbname'], CONFIG['port']);
    $OrderModel = new OrderModel($databaseManager);
    $order = $OrderModel->find($id);
    $totalValue = getTotalValue($order['products'], $products);
    // var_dump($order);
}

require 'views/form-view.php';