<?php
require_once('../models/FoodModel.php');
require_once('../models/OrderModel.php');
require_once('../utilities/DatabaseManager.php');
require_once '../config.php';
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function validate($email, $street, $streetNumber, $city, $zipcode)
{
    // TODO: This function will send a list of invalid fields back
    $invalidFields = [];
    if (empty($email) or false === filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($invalidFields, 'email must be valid');
    }
    if (empty($street)) {
        array_push($invalidFields, 'street cannot be empty');
    }
    if (empty($streetNumber)) {
        array_push($invalidFields, 'street number cannot be empty');
    }
    if ($city == '') {
        array_push($invalidFields, 'city cannot be empty');
    }
    if (empty($zipcode) or false === filter_var($zipcode, FILTER_VALIDATE_INT)) {
        array_push($invalidFields, 'zipcode must be numbers');
    }
    if (!isset($_POST['products'])) {
        array_push($invalidFields, 'There are no products selected');
    }
    return $invalidFields;
}

function handleForm()
{
    // TODO: form related tasks (step 1)
    if (!empty($_POST)) {
        //sanitize 
        $email  = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $street = filter_var($_POST['street'], FILTER_SANITIZE_SPECIAL_CHARS);
        $streetNumber = filter_var($_POST['streetnumber'], FILTER_SANITIZE_SPECIAL_CHARS);
        $city = filter_var($_POST['city'], FILTER_SANITIZE_SPECIAL_CHARS);
        $zipcode = filter_var($_POST['zipcode'], FILTER_SANITIZE_NUMBER_INT);
        if (!empty($_POST['products'])) {
            $products = $_POST['products'];
        } else {
            $products = null;
        }
        // var_dump($_POST['products']);
    }

    // Validation (step 2)
    $invalidFields = validate($email, $street, $streetNumber, $city, $zipcode);
    if (!empty($invalidFields)) {
        // TODO: handle errors
        // var_dump($invalidFields);
        $_SESSION['errors'] = $invalidFields;
        $_SESSION['order'] = [
            'email' => $email,
            'street' => $street,
            'streetNumber' => $streetNumber,
            'city' => $city,
            'zipcode' => $zipcode,
            'products' => $products,
        ];
        header("Location: ../index.php?error");
        exit;
    } else {
        // TODO: handle successful submission
        $databaseManager = new DatabaseManager(CONFIG['host'], CONFIG['user'], CONFIG['password'], CONFIG['dbname'], CONFIG['port']);
        $OrderModel = new OrderModel($databaseManager);
        //var_dump($OrderModel);
        $id = $OrderModel->create($email, $street, $streetNumber, $city, $zipcode, $_POST['products']);
        // var_dump($id);
        unset($_SESSION["errors"]);
        unset($_SESSION["order"]);
        header("Location: ../index.php?order=" . $id);
    }
}
handleForm();