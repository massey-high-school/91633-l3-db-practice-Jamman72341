<?php

$name="";
$price=0;
$categoryID=1;
$topline="";
$description="";
$NameErr=$PriceErr=$TopErr=$DesErr="";


 if(!isset($_SESSION['admin']))
        {
            header("Location: index.php");
            exit();
        }

// define variables and set to empty values...
$valid=true;
$uploadOk = 1;

// Code below executes when the form is submitted...
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // santise all variables
    $name = test_input(mysqli_real_escape_string($dbconnect,$_POST['name']));
    $price = test_input($_POST["price"]);
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
        header('Location:admin.php?page=addstock_success');
    }
    
    
    if($valid==true) {
    // adds stock to database
    $addstock_sql="INSERT INTO `webbj72341`.`L3_prac_stock` (
`stockID` ,
`name` ,
`categoryID` ,
`price` ,
`topline` ,
`description`
)
VALUES (
NULL , '$name', '$categoryID', '$price', '$topline', '$description'
);
"; 
    $addstock_query=mysqli_query($dbconnect, $addstock_sql);
        
        } // end of insert data if (works if valid)
     
} // end of button has been pressed if

?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]."?page=addstock");?>" enctype="multipart/form-data">
    
    <h1>Add Item</h1>

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
            echo '<option value="'.$cat_rs['categoryID'].'"';
            echo ">".$cat_rs['catName']."</option>";
            
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
    
    <input type="submit" name="submit" value="Add Item" />
    
</form>