<?php
session_start();

// Checks if User is logged in
if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true)
{
    // Get the category Id
    $categoryId = $_SESSION['catModifyId'];
    
    $categoryDefault = array();
    $categoryChanged = array();
    
    // Get the default values of the category
    $categoryDefault = getCategoryForm($categoryId);
    
    // If submit button is pressed assign the values to an array
    if(isset($_POST['catModSubmit'])){
        $categoryChanged[0] = $categoryId;
        $categoryChanged[1] = $_POST['catModName'];
        $categoryChanged[2] = $_POST['catModDesc'];
        
        // Call Function to write the new array into the file
        writeModifyCategory($categoryId, $categoryChanged);
    }
}
else
{
    // If user is not logged In and user used ?page=categoryModify alert them
    if(!isset($_POST['username']) && !isset($_POST['password']))
    {
        echo '<script>alert("Invalid access"); window.location.href="?page=login"</script>'; // Displays invalid access & redirects to login
    }
    session_destroy();
}
