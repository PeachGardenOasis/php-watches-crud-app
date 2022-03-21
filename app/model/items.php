<?php
/* 
 * Determines if category selection is active
 * If NOT active set category selection to 0 (Show ALL items)
 */
if(isset($_POST['category']))
{
    $categorySearch = $_POST['category'];  
}
else 
{
    $categorySearch = 0;
}
?>
