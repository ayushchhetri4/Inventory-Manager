<?php
//connect to db
require_once "includes/db_inc.php";
require_once "includes/functions_inc.php";

//make sure the user is logged in 
session_start();
if(!isset($_SESSION['uname'])) {
  header('Location: index.php');
  exit;
}
$res = getSuppliersData($conn);
$res2 = getProductsData($conn); 

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Home Page</title>
    <link href="style.css" rel="stylesheet" type="text/css">
</head>
<body class="loggedin">
    <header class="navtop">
        <h1>CP476 Final Project</h1>
    </header>
    <div class="content">
        <h1>Deleting Elements from Database</h1>
        <br/>
        <hr/>
        <div class="table_container">
            <div class="table2">
                <h3>Products table:</h3>
                <table border="1" cellspacing="2" cellpadding="2">
                    <tr>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Product Description</th>
                        <th>Product Price</th>
                        <th>Quantity</th>
                        <th>Product Status</th>
                        <th>Supplier ID</th>
                    </tr>
                    <?php while ($rows = $res2->FETCH_ASSOC()) { ?>
                        <tr>
                            <td><?php echo $rows['product_id']; ?></td>
                            <td><?php echo $rows['product_name']; ?></td>
                            <td><?php echo $rows['product_desc']; ?></td>
                            <td><?php echo $rows['product_price']; ?></td>
                            <td><?php echo $rows['quantity']; ?></td>
                            <td><?php echo $rows['product_status']; ?></td>
                            <td><?php echo $rows['supplier_id']; ?></td>
                        </tr>
                    <?php } ?>
                </table>
                <br/>
                <p>Number of rows (Products): <?php echo mysqli_num_rows($res2); ?></p>
            </div>
        </div>

        <!-- user enters supplier id / product id to delete that element -->
        <div class="delete">
            <form action="delete_d.php" method="post">
                <label for="html">Product ID</label>
                <input type="text" id="product_id" name="product_id">
                <br>
                <label for="html">Supplier ID</label>
                <input type="text" id="supplier_id" name="supplier_id">
                <br>
                <input type="submit" value="Delete Item">
            </form>
        </div>
        <br/>
        <button onclick="location.href = 'dashboard.php';">Home</button>
    </div>
</body>
</html>