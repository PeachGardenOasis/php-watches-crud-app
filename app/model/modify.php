<?php
session_start();

// Determines if user is logged in
if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true) 
{
    // Get the Item ID
    $toModifyId = $_SESSION['itemModifyId'];
    
    $modifyItem = array();
    $modifiedItem = array();
    
    // Gets the default values of item based on the ID given
    $modifyItem = getModifyForm($toModifyId);
    
    // If submit button is pressed assign the values to an array
    if(isset($_POST['modSubmit'])){
        $modifiedItem[0] = $toModifyId;
        $modifiedItem[1] = $_POST['modCategory'];
        $modifiedItem[2] = $_POST['modBrand'];
        $modifiedItem[3] = $_POST['modName'];
        $modifiedItem[4] = $_POST['modDiameter'];
        $modifiedItem[5] = $_POST['modPrice'];
        
        // Call Function to write the new array into the file
        writeModifyItem($toModifyId, $modifiedItem);
    }
}
else
{
    // If user is not logged in and tried to access through ?page=modify. Use alert message
    if(!isset($_POST['username']) && !isset($_POST['password']))
    {
        echo '<script>alert("Invalid access"); window.location.href="?page=login"</script>'; // Displays invalid access & redirects to login
    }
    session_destroy();
}
