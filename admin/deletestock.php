<?php


    // Delete item
    $delstock_sql="DELETE FROM `L3_prac_stock` WHERE `stockID`=".$_REQUEST['stockID'];
    $delstock_query=mysqli_query($dbconnect, $delstock_sql);
?>

<h1>Delete Success</h1>

<p><a href="admin.php?page=adminpanel">Return to admin panel</a></p>