<?php
require_once "includes/db_inc.php";
require_once "includes/functions_inc.php";

session_start();

//make sure user is logged in 
if(!isset($_SESSION['uname'])) {
  header('Location: index.html');
  exit;
}

//check for product id and supplier id, then delete
if (isset($_POST['product_id']) && isset($_POST['supplier_id'])) {
  try {
      $sql = "DELETE FROM products WHERE product_id = ? AND supplier_id = ?";
      $stmt = $conn->prepare($sql);

      // Clean and bind the parame
      $pr_id = clean_input($_POST['product_id']);
      $sup_id = clean_input($_POST['supplier_id']);

      $stmt->bind_param("ss",$pr_id,$sup_id);
      

      // Execute the prepared statement
      $stmt->execute();
  } catch (PDOException $e) {
      echo $sql . "<br>" . $e->getMessage();
  }
}

// Query the data to be displayed
$query = "SELECT * FROM suppliers";
$res = $conn->query($query);

$query2 = "SELECT * FROM products";
$res2 = $conn->query($query2);

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
        <h2>Row deleted. Data now looks like:</h2>
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
                <p>Number of rows (Products): <?php echo $res2->num_rows; ?></p>
            </div>
        </div>
        <button onclick="location.href = 'delete.php';">Go Back</button>
        <button onclick="location.href = 'dashboard.php';">Home</button>
    </div>
</body>
</html>

 
