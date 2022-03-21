<?php
function get($name,$def='')
{ // if bracket contents exist load the value of it or return default value
    return isset($_REQUEST[$name]) ? $_REQUEST[$name] : $def;
}

function is_active($page,$current_link){
return $page == $current_link? 'active' : '';
}


// Displays Items In A Table & Displays By Category
function list_items($categorySearch)
{
    $watchArray = categoryArray($categorySearch);
    foreach ($watchArray as $watch)
            {
                echo '<tr>';
                for ($i = 0; $i < count($watch); $i++)
                {
                    switch ($i)
                    {
                        case 0:
                            echo '<td> <h6 class="mb-0">Item ID</h6>' . $watch[$i] . '</td>';
                        break;

                        case 1:
                            echo '<td> <h6 class="mb-0">Category ID</h6>' . $watch[$i] . '</td>';
                        break;

                        case 2:
                            echo    '<td> <h5 class="mb-0">' .
                                    $watch[$i] . ' ' .
                                    $watch[$i+1] .
                                    '</h5></td>';
                        break;

                        case 4:
                            echo '<td> <h6 class="mb-0">Case Diamaeter</h6>' . $watch[$i] . '</td>';
                        break;

                        case 5:
                            echo '<td> <h6 class="mb-0">Price</h6>' . $watch[$i] . '</td>';
                            if (isset($_SESSION['loggedIn'])){
                                echo '<td> <form method="post" action="?page=dashboard"> <button class="nav-link" type="submit" name="itemModify" value="'.$watch[0].'">Modify</button></form></td>';
                                echo '<td> <form method="post" action="?page=dashboard"> <button onclick="return confirmDelete()" class="nav-link" type="submit" name="itemDelete" value="'.$watch[0].'">Delete</button></form></td>';
                            }
                        break;
                    }
                }

                echo '</tr>';
                echo '<br>';
            }
}

// Displays the Category Description When Selecting A Category on Item Page
function listCategoryDesc($categorySearch){
    $categArray = makeCategoryArray();

    if($categorySearch == 0){

    }
    for($y = 0; $y < count($categArray); $y++){
        if($categorySearch != 0 && $categorySearch == $categArray[$y][0])
        {
            echo $categArray[$y][2];
        }
    }
}

// Display the List of Categories In The Dashboard
function list_categories(){
    $categoryArray = makeCategoryArray();
    foreach($categoryArray as $category){
        echo '<tr>';

        for($i = 0; $i < count($category); $i++){
            switch($i){
                case 0:
                    echo '<td> <h5 class="mb-0">Category ID</h5>' . $category[$i] . '</td>';
                    break;

                case 1:
                    echo '<td> <h5 class="mb-0">Category Name</h5>' . $category[$i] . '</td>';
                    break;

                case 2:
                    echo '<td> <h5 class="mb-0">Category Description</h5>' . $category[$i] . '</td>';
                    if (isset($_SESSION['loggedIn'])){
                        echo '<td> <form method="post" action="?page=dashboard"> <button class="nav-link" type="submit" name="catModify" value="'.$category[0].'">Modify</button></form></td>';
                        echo '<td> <form method="post" action="?page=dashboard"> <button class="nav-link" type="submit" name="catStatus" value="'.$category[0].'">Show/Hide</button></form></td>';
                    }
                    break;
            }
        }

        echo '</tr>';
        echo '<br>';
    }
}

// Take values from category file and input into an array to allow for changes
// Modified
function makeCategoryArray(){
    global $config;
    $categoryList = getDBCateg();
    $categoryArray = array();
    $x = 0;

    foreach ($categoryList as $category){

        for($y = 0; $y < 3; $y++){
            $categoryArray[$x][$y] = $category[$y];
        }
        $x++;
    }
    return $categoryArray;
}

// Post the categories into options on the sidebar/dropdown
// Modified
function postCategories($typeOfNav)
{
    global $config;
    $categoryList = getDBCateg();
    
    if ($typeOfNav == 'dropDown'){
        foreach ($categoryList as $row)
        {
            if ($row[3] == 'SHOW'){
            echo '<button class="dropdown-item" type="submit" name="category" value="' . $row[0] . '">' . $row[1] .'</button>';
            }
            else if ($row[3]== 'HIDE'){}
        }
    }
    if ($typeOfNav == 'sideBar')
    {
        foreach ($categoryList as $row)
        {
            if ($row[3] == 'SHOW'){
            echo '<button class="nav-item, nav-link" type="submit" name="category" value="' . $row[0] . '">' . $row[1] . '</button>';
            }
            else if ($row[3] == 'HIDE'){}
        }
    }
}

// Take values from item file and input into an array to allow for changes
// Modified
function makeItemArray()
{
    global $config;
    $itemList = getDBItems();
    $itemArray = array();
    $x = 0;
    
    foreach ($itemList as $item)
    {    
        if ($item[6] == 'SHOW'){
            for($y = 0; $y < 6; $y++)
            {
                $itemArray[$x][$y] = $item[$y];
            }

            $x++;
        }
        else if ($item[6] == 'HIDE'){}
    }
    
    return $itemArray;
}

// Creates an item array list of the matching category
function categoryArray($categorySearch){
    $categSort = $categorySearch;
    $itemArray = makeItemArray();
    $sortedArray = array();

        for($z = 0; $z < count($itemArray); $z++){
            if($categSort == 0){
                for($a = 0; $a < count($itemArray[$z]); $a++){
                    $sortedArray[$z][$a] = $itemArray[$z][$a];
                }
            }
            if($categSort != 0 && $categSort == $itemArray[$z][1]){
                for($a = 0; $a < count($itemArray[$z]); $a++){
                    $sortedArray[$z][$a] = $itemArray[$z][$a];
                }
            }
        }
    return $sortedArray;
}

// Deletes An Item
// Modified
function deleteItem($givenId){
    global $config;
    include $config['DATABASE_PATH'] . DS . 'database.php';
    global $myDB;
        
    $query = "DELETE FROM items WHERE id=" . $givenId . ";";
    $statement = $myDB->prepare($query);
    $statement->execute();
}
// Previous Version
/*function deleteItem($givenId){
    $locationId = $givenId;
    $baseArray = makeItemArray();
    $modifiedArray = array();

    for($y = 0; $y < count($baseArray); $y++){
        for($x = 0; $x < count($baseArray[$y]); $x++){
            if($baseArray[$y][0] == $locationId){

            }
            else{
                $modifiedArray[$y][$x] = $baseArray[$y][$x];
            }
        }
    }

    writeToItemText($modifiedArray, 'deletes', $givenId);
}*/

// Modifies the item file array and sends it to be written into the file
// Modified
function writeModifyItem($givenId, $modifiedItem){
    global $config;
    include $config['DATABASE_PATH'] . DS . 'database.php';
    global $myDB;
    
    $query = "UPDATE items "
            . 'SET'
            . ' brand="' . $modifiedItem[2] . '"'
            . ',model="' . $modifiedItem[3] . '"'
            . ',diameter="' . $modifiedItem[4] . '"'
            . ',price="' . doubleval($modifiedItem[5]) . '"'
            . "WHERE id=" . $givenId;
    $statement = $myDB->prepare($query);
    $statement->execute();
    header('Location: ?page=dashboard');
}
// Previous Version
/*function writeModifyItem($givenId, $modifiedItem){
    $locationId = $givenId;
    $baseArray = makeItemArray();
    $modifiedArray = array();

    for($y = 0; $y < count($baseArray); $y++){
        if ($baseArray[$y][0] == $locationId) {
                $modifiedArray[$y] = $modifiedItem;
        }
        for($x = 0; $x < count($baseArray[$y]); $x++){
            if ($baseArray[$y][0] != $locationId) {
                $modifiedArray[$y][$x] = $baseArray[$y][$x];
            }
        }
    }
    writeToItemText($modifiedArray, 'modify', $givenId);
    header('Location: ?page=dashboard');
}*/

// Adds an Item to the file array and sends it to be written into the file
function addItem($itemToAdd){
    global $config;
    include $config['DATABASE_PATH'] . DS . 'database.php';
    global $myDB;

    $query = "INSERT INTO items"
            . "(`category_id`, `brand`, `model`, `diameter`, `price`)"
            . "VALUES"
            . "(" 
            . intval($itemToAdd[0]) 
            . ",'" . $itemToAdd[1] . "'"
            . ",'" . $itemToAdd[2] . "'"
            . ",'" . $itemToAdd[3] . "'"
            . "," . doubleval($itemToAdd[4])
            . ");";
    $statement = $myDB->prepare($query);
    $statement->execute();
    
    //UNSET($_SESSION[])
    
    header("Location: ?page=dashboard");
}

/*
 * ---
 *  Category Methods
 * ---
 */

// Modifies the category file array and sends it to be written into the file
// Modified
function writeModifyCategory($givenId, $modifiedCat){
    global $config;
    include $config['DATABASE_PATH'] . DS . 'database.php';
    global $myDB;
    
    $query = "UPDATE category "
            . 'SET'
            . ' `name`="' . $modifiedCat[1] . '"'
            . ',`desc`="' . $modifiedCat[2] . '"'
            . "WHERE id=" . $givenId;
    $statement = $myDB->prepare($query);
    $statement->execute();
    header('Location: ?page=dashboard');
}

// Adds a Category to the file array and sends it to be written into the file
function addCategory($categoryToAdd){
    global $config;
    include $config['DATABASE_PATH'] . DS . 'database.php';
    global $myDB;

    $query = "INSERT INTO category"
            . "(`name`, `desc`)"
            . "VALUES"
            . "(" 
            . '"' . $categoryToAdd[0] . '"' 
            . ',"' . $categoryToAdd[1] . '"'
            . ");";
    $statement = $myDB->prepare($query);
    $statement->execute();
    
    unset($_SESSION['catIdToAdd']);
    unset($_SESSION['catNameToAdd']);
    unset($_SESSION['catDescToAdd']);

    header("Location: ?page=dashboard");

}

// Gets the Default values of an Item When Modifying
function getModifyForm($givenId){
    $itemToModify = array();
    $baseArray = makeItemArray();

    for($y = 0; $y < count($baseArray); $y++){
        if($baseArray[$y][0] == $givenId){
            for($x = 0; $x < count($baseArray[$y]); $x++){
                $itemToModify[$x] = $baseArray[$y][$x];
            }
        }
    }
    return $itemToModify;
}

// Gets the Default values of a Category When Modifying
function getCategoryForm($givenId){
    $categoryToModify = array();
    $baseArray = makeCategoryArray();

    for($y = 0; $y < count($baseArray); $y++){
        if($baseArray[$y][0] == $givenId){
            for($x = 0; $x < count($baseArray[$y]); $x++){
                $categoryToModify[$x] = $baseArray[$y][$x];
            }
        }
    }
    return $categoryToModify;
}

function setCategoryStatus($givenId){
    global $config;
    global $myDB;
    $catStatus = '';
    $toReturn = '';
    
    $catList = getDBCateg();
    
    foreach ($catList as $category){

        if ($category[0] == $givenId){
            $catStatus = $category[3];
        }
    }
    
    if ($catStatus == 'SHOW'){
        $toReturn = 2; 
    }
    else if ($catStatus == 'HIDE'){
        $toReturn = 1;
    }
    
    $query = "UPDATE `category` "
            . 'SET'
            . ' `status`=' . $toReturn
            . " WHERE `id`=" . $givenId;
    $statement = $myDB->prepare($query);
    $statement->execute();
    updateItemStatus($givenId, $toReturn);
    //header('Location: ?page=dashboard');
}

function updateItemStatus($givenId, $catStatus){
    global $config;
    global $myDB;
    $itemStatus = '';
    $toReturn = '';
    
    $itemList = getDBItems();
    
    foreach($itemList as $item){
        if ($item[1] == $givenId){
            
            if ($catStatus == 1){
                $toReturn = 1;
            }
            else if ($catStatus == 2){
                $toReturn = 2;
            }
            $query = "UPDATE `items` "
            . 'SET'
            . ' `status`=' . $toReturn
            . " WHERE `id`=" . $item[0];
            $statement = $myDB->prepare($query);
            $statement->execute();
        }
    }
}