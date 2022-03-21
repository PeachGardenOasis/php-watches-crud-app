<?php
session_start();

// Checks if user is logged in
if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true) // if session variable loggedIn is true
{
    // Array to put the values in
    $categoryToAdd = array();
    
    if(isset($_POST['catAddSubmit'])){
        $_SESSION['catIdToAdd'] = $_POST['catAddId'];
        $_SESSION['catNameToAdd'] = $_POST['catAddName'];
        $_SESSION['catDescToAdd'] = $_POST['catAddDesc'];
        
        // Add values from text boxes into the array
        array_push($categoryToAdd, $_SESSION['catNameToAdd'], $_SESSION['catDescToAdd']);
        
        addCategory($categoryToAdd);
    }
    
}
else
{
    // alert user if not logged in and tried to access through ?page=categoryAdd
    if(!isset($_POST['username']) && !isset($_POST['password']))
    {
        echo '<script>alert("Invalid access"); window.location.href="?page=login"</script>'; // Displays invalid access & redirects to login
    }
    session_destroy();
}