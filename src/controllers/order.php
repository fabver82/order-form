<?php
require_once('../models/FoodModel.php');
require_once('../models/OrderModel.php');
require_once '../config.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function validate($email, $street, $streetNumber, $city, $zipcode, $products)
{
    // TODO: This function will send a list of invalid fields back
    $invalidFields = [];
    if (empty($email) or false === filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($invalidFields, $email);
    }
    if (empty($street)) {
        array_push($invalidFields, $street);
    }
    if (empty($streetNumber)) {
        array_push($invalidFields, $streetNumber);
    }
    if ($city == '') {
        array_push($invalidFields, $city);
    }
    if (empty($zipcode) or false === filter_var($zipcode, FILTER_VALIDATE_INT)) {
        array_push($invalidFields, $zipcode);
    }
    if (count($products) == 0) {
        array_push($invalidFields, $products);
    }
    return $invalidFields;
}

function handleForm()
{
    // TODO: form related tasks (step 1)
    if (!empty($_POST)) {
        //sanitize 
        $email  = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $street = filter_var($_POST['street'], FILTER_SANITIZE_ENCODED);
        $streetNumber = filter_var($_POST['streetnumber'], FILTER_SANITIZE_ENCODED);
        $city = filter_var($_POST['city'], FILTER_SANITIZE_ENCODED);
        $zipcode = filter_var($_POST['zipcode'], FILTER_SANITIZE_NUMBER_INT);
        $products = $_POST['products'];
        // var_dump($_POST['products']);
    }

    // Validation (step 2)
    $invalidFields = validate($email, $street, $streetNumber, $city, $zipcode, $products);
    if (!empty($invalidFields)) {
        // TODO: handle errors
        // var_dump($invalidFields);
        $_SESSION['errors'] = $invalidFields;
        header("Location: ../index.php?errors");
        exit;
    } else {
        // TODO: handle successful submission
        $databaseManager = new DatabaseManager(CONFIG['host'], CONFIG['user'], CONFIG['password'], CONFIG['dbname'], CONFIG['port']);
        $OrderModel = new OrderModel($databaseManager);
        //var_dump($OrderModel);
        $id = $OrderModel->create($email, $street, $streetNumber, $city, $zipcode, $products);
        // var_dump($id);
        unset($_SESSION["errors"]);
        header("Location: ../index.php?order=" . $id);
    }
}
handleForm();