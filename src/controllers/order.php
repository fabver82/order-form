<?php
require_once('../models/FoodModel.php');
require_once '../../config.php';


$databaseManager = new DatabaseManager(CONFIG['host'], CONFIG['user'], CONFIG['password'], CONFIG['dbname'], CONFIG['port']);
$foodModel = new FoodModel($databaseManager);


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
    if (count($products) != 0) {
        array_push($invalidFields, $zipcode);
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
    }

    // Validation (step 2)
    $invalidFields = validate($email, $street, $streetNumber, $city, $zipcode, $products);
    if (!empty($invalidFields)) {
        // TODO: handle errors
        return false;
    } else {
        // TODO: handle successful submission
        return true;
    }
}

// TODO: replace this if by an actual check
$formSubmitted = false;
if ($formSubmitted) {
    handleForm();
}