<?php

$name="";
$price=0;
$categoryID=1;
$topline="";
$description="";
$photo="noimage.png";
$NameErr=$PriceErr=$PhotoErr=$TopErr=$DesErr="";

// sql to populate our 'edit' form...
$stockID=preg_replace('/[^0-9.]-/','',$_REQUEST['stockID']);
$editstock_sql="SELECT * FROM `L3_prac_stock` WHERE stockID=".$stockID;
$editstock_query=mysqli_query($dbconnect, $editstock_sql);
$editstock_rs=mysqli_fetch_assoc($editstock_query);

$name=$editstock_rs['name'];
$price=$editstock_rs['price'];
$categoryID=$editstock_rs['categoryID'];
$topline=$editstock_rs['topline'];
$description=$editstock_rs['description'];

// define variables and set to empty values...
$valid=true;
$uploadOk = 1;

// Code below executes when the form is submitted...
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // santise all variables
    $name = test_input(mysqli_real_escape_string($dbconnect,$_POST['name']));
    $price = test_input($_POST['price']);
    $categoryID = preg_replace('/[^0-9.]-/','',$_POST['categoryID']);
    $topline = test_input(mysqli_real_escape_string($dbconnect,$_POST['topline']));
    $description = test_input(mysqli_real_escape_string($dbconnect,$_POST['description']));
    
    // Error checking...
    if (empty($name)) {
    $NameErr = "Item name is required";
    $valid=false;
    }
    
    $price=preg_replace('/[^0-9.]-/','',$_POST['price']);
    if ($price<=0) {
    $PriceErr = "Enter a number greater than 0";
    $valid=false;
    }
    
    if (empty($topline)) {
    $TopErr = "Please provide a byline";
    $valid=false;
    }
    
    if (empty($description)) {
    $DesErr = "Please provide a description";
    $valid=false;
    }
    
     // If everything is OK - show 'success message and update database'
    if($valid){
        header('Location:admin.php?page=editstock_success');
    }
    
    // Update the database Column_Name=New_Value, Column_Name=New_Value
    
    $editstock_sql="UPDATE `L3_prac_stock` SET
    name='$name',
    categoryID='$categoryID',
    price='$price',
    topline='$topline',
    description='$description'
    WHERE stockID=$stockID";
    
    // Code below runs query and inputs data into database
    $editstock_query=mysqli_query($dbconnect, $editstock_sql);
        
        } // end of insert data if (works if valid)
     
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]."?page=editstock&stockID=$stockID");?>" enctype="multipart/form-data">
    
    <h1>Edit Item</h1>

   <p>
        <b>Item Name:</b>
        <input type="text" name="name" value="<?php echo $name;?>" />
       &nbsp;&nbsp; <span class="error"><?php echo $NameErr;?></span>
    </p>
    
    <p>
        <b>Price: $</b>
        <input type="text" name="price" value="<?php echo $price;  ?>" size="2" />
        &nbsp;&nbsp; <span class="error"><?php echo $PriceErr;?></span>
    </p>
    
    <p>
        <b>Category</b>
        <select name="categoryID">
        
        <?php
            
        $cat_sql="SELECT * FROM `L3_prac_category`";
        $cat_query=mysqli_query($dbconnect,$cat_sql);
            
        do {
            
            if ($cat_rs['categoryID']==$categoryID) {
                echo '<option value="'.$cat_rs['categoryID'].'"selected';
            echo ">".$cat_rs['catName']."</option>";    
            }
            else{
            echo '<option value="'.$cat_rs['categoryID'].'"';
            echo ">".$cat_rs['catName']."</option>";
            }
            
        }
        while ($cat_rs=mysqli_fetch_assoc($cat_query))
            
        ?>
        
        </select>
        
    </p>
    
    
    <p>
        <b>Topline</b>
        <input type="text" name="topline" value="<?php echo $topline; ?>" />
        &nbsp;&nbsp;<span class="error"><?php echo $TopErr;?></span>
    </p>
    
    <p>
        <b>Description</b>&nbsp;&nbsp;<span class="error"><?php echo $DesErr;?></span>
    </p>
    <p>
        <textarea type="text" name="description" cols="60" rows="7"><?php echo $description; ?></textarea>
    </p>
    
    <input type="submit" name="submit" value="Edit Item" />
    
</form>