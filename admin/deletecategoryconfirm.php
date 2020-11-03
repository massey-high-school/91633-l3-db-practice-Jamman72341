<?php

// remove unwanted items
$delcat_sql="DELETE FROM `L3_prac_stock` WHERE `categoryID`=".$_REQUEST['categoryID'];
$delcat_query=mysqli_query($dbconnect,$delcat_sql);

// delete unwanted category
$delcat_sql="DELETE FROM `L3_prac_category` WHERE `categoryID`=".$_REQUEST['categoryID'];
$delcat_query=mysqli_query($dbconnect, $delcat_sql);

header('Location:admin.php?page=delcatsuccess');

?>