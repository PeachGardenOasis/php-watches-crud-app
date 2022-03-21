<?php
function categoryOrItem()
{
    if (isset($_POST['button3'])){
        list_items(0);
    }
    if (isset($_POST['button2'])){
        list_categories();
    }
}

// variables containing username & password
$uName = 'un';
$psWord = 'pw';

session_start(); //start session

// Determines if session variables are initialized and user is already loggedIn
if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true)
{}
else 
{
    // checks if user tried to access page through ?page=dashboard without loggedIn being true and not using login page
    if(!isset($_POST['username']) && !isset($_POST['password']))
    {
        echo '<script>alert("Invalid access"); window.location.href="?page=login"</script>'; 
        // Displays invalid access & redirects to login
    }
    else
    {    
        $un = $_POST['username'];
        $pw = $_POST['password'];
        
        // checks if username and password were correct
        if($un == $uName && $pw == $psWord)
        {
            $_SESSION['loggedIn'] = true; // create session variable loggedIn and it is true
 
            header('Location: ?page=dashboard'); // redirects to dashboard 
        }
        else
        {
            echo 
                '<script>
                    alert("Invalid username and or password entered"); 
                    window.location.href="?page=login"
                </script>';
            
            // displays improper login credentials, redirect back to login
            session_destroy(); // ends session if username and password failed
        }
    }
}

// if user presses logout button, end session (deletes session loggedIn variable)
if(isset($_POST['button1']))
{
    session_destroy();
    header('Location: ?page=login');
}

// If user presses modify button for specific item. get that items ID and go to modify item page
if(isset($_POST['itemModify'])){
    $itemModifyId = $_POST['itemModify'];
    $_SESSION['itemModifyId'] = $itemModifyId;
    header('Location: ?page=modify');
}

// If user presses delete button for specific item. call deleteItem() function to delete the item
if(isset($_POST['itemDelete'])){
    $deleteId = $_POST['itemDelete'];
    deleteItem($deleteId);
}

// If user presses modify button for specific category. get that categorys ID and go to modify category page
if(isset($_POST['catModify'])){
    $catModifyId = $_POST['catModify'];
    $_SESSION['catModifyId'] = $catModifyId;
    header('Location: ?page=categoryModify');
}

if(isset($_POST['catStatus'])){
    $catStatusId = $_POST['catStatus'];
    $_SESSION['catStatusId'] = $catStatusId;
    setCategoryStatus($catStatusId);
}

// If user presses add item button go to add item page
if(isset($_POST['button4'])){
    header('Location: ?page=add');
}

// If user presses add category button go to add category page
if(isset($_POST['button5'])){
    header('Location: ?page=categoryAdd');
}