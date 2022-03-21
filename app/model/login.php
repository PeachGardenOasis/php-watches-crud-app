<?php
session_start();

// Checks if LoggedIn, if True go to dashboard
if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true)
{
    echo 'Logged In';
    header('Location: ?page=dashboard');
}
?>