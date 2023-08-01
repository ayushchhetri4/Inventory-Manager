<?php
// We start our session
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['uname'])) {
  header('Location: index.html');
  exit;
}

//connect to database
require_once 'includes/db_inc.php';
// use INNER JOIN Query to get all the data from both tables
$query = 'SELECT product_id, product_name, quantity, product_price, product_status, supplier_name FROM suppliers INNER JOIN products ON suppliers.supplier_id = products.supplier_id';
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset='utf-8'>
  <title>Home Page</title>
  <link href='style.css' rel='stylesheet' type='text/css'>
</head>

<body class='loggedin'>
  <header class='navtop'>
    <h1>CP476 Project</h1>
    <nav>
      <p>Welcome back, <strong>
          <?= $_SESSION['uname'] ?>
        </strong>!</p>
    </nav>
  </header>
  <div class='content'>
    <h1>Inventory Status (Appendix B)</h1>
    <p>
      <?php echo isset($output) ? $output : 'Database connection established.'; ?>
    </p>
    <br />
    <hr />
    <div class='table_container'>
      <div class='table1'>
        <h3>Inventory table:</h3>
        <table border='1' cellspacing='2' cellpadding='2'>
          <tr>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Status</th>
            <th>Supplier Name</th>
          </tr>
          <?php while ($rows = mysqli_fetch_assoc($result)) { ?>

            <tr>
              <td>
                <?php echo $rows['product_id']; ?>
              </td>
              <td>
                <?php echo $rows['product_name']; ?>
              </td>
              <td>
                <?php echo $rows['quantity']; ?>
              </td>
              <td>
                <?php echo $rows['product_price']; ?>
              </td>
              <td>
                <?php echo $rows['product_status']; ?>
              </td>
              <td>
                <?php echo $rows['supplier_name']; ?>
              </td>
            </tr>
          <?php } ?>
        </table>
        <!-- echo row count here -->
        <br />
        <p>Number of rows:
          <?php echo mysqli_num_rows($result); ?>
        </p>
      </div>
    </div>


    <br />
    <button onclick="location.href = 'dashboard.php';">Home</button>
  </div>
</body>

</html>