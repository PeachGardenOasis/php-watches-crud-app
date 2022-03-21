<?php
session_start();

// Checks if user is logged in
if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true)
{
    // Array to put the values in
    $itemToAdd = array();
    
    if(isset($_POST['addSubmit'])){
        $_SESSION['categoryToAdd'] = $_POST['addCategory'];
        $_SESSION['brandToAdd'] = $_POST['addBrand'];
        $_SESSION['nameToAdd'] = $_POST['addName'];
        $_SESSION['diameterToAdd'] = $_POST['addDiameter'];
        $_SESSION['priceToAdd'] = $_POST['addPrice'];
        
        // Add the values from the text boxes to the array
        array_push($itemToAdd, $_SESSION['categoryToAdd'], $_SESSION['brandToAdd'], $_SESSION['nameToAdd'], $_SESSION['diameterToAdd'], $_SESSION['priceToAdd']);

        addItem($itemToAdd);
    }
    
}
else
{
    // If user tries to access through ?page=add and is not logged in
    if(!isset($_POST['username']) && !isset($_POST['password']))
    {
        echo '<script>alert("Invalid access"); window.location.href="?page=login"</script>';
    }
    session_destroy();
}