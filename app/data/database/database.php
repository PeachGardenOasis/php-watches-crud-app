<?php

    $dsn = 'mysql:host=localhost;dbname=assign2';
    $usName = 'root';
    $password = '';
    
    try {
        $myDB = new PDO($dsn, $usName, $password);
    } catch (PDOException $ex) {
        $erMsg = $ex->getMessage();
        include('db_error.php');
        exit();
    }

    function getDBCateg(){
    global $myDB;
    $query = 'SELECT * FROM category;';
    $statement = $myDB->prepare($query);
    $statement->execute();
    $categories = $statement->fetchAll();
    $statement->closeCursor();
    return $categories;
    }
    
    function getDBItems(){
    global $myDB;
    $query = 'SELECT * FROM items;';
    $statement = $myDB->prepare($query);
    $statement->execute();
    $items = $statement->fetchAll();
    $statement->closeCursor();
    return $items;
    }
?>

