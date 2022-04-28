<?php
require_once('../models/FoodModel.php');
require_once '../../config.php';


$databaseManager = new DatabaseManager(CONFIG['host'], CONFIG['user'], CONFIG['password'], CONFIG['dbname'], CONFIG['port']);
$foodModel = new FoodModel($databaseManager);


function validate()
{
    // TODO: This function will send a list of invalid fields back
    return [];
}

function handleForm()
{
    // TODO: form related tasks (step 1)
    if(isset($_POST['name'] and isset($_POST['price']))){
        //sanitize 

    }

    // Validation (step 2)
    $invalidFields = validate();
    if (!empty($invalidFields)) {
        // TODO: handle errors
    } else {
        // TODO: handle successful submission
    }
}

// TODO: replace this if by an actual check
$formSubmitted = false;
if ($formSubmitted) {
    handleForm();
}