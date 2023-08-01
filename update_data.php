<?php
// Start the session
session_start();
// If the user is not logged in, redirect to the login page...
if (!isset($_SESSION['uname'])) {
  header('Location: index.html');
  exit;
}

require_once 'includes/db_inc.php';
require_once 'includes/functions_inc.php';
// Check if the form was submitted for updating the record
if (isset($_POST['product_name']) && isset($_POST['quantity']) && isset($_POST['price']) && isset($_POST['status'])) {
  // Get cleaned POST data
  $update_name = clean_input($_POST['product_name']);
  $update_quantity = clean_input($_POST['quantity']);
  $update_price = clean_input($_POST['price']);
  $update_status = clean_input($_POST['status']);

  // Get the product and supplier IDs from session variables
  $product_id = isset($_SESSION['product_id']) ? clean_input($_SESSION['product_id']) : '';
  $supplier_id = isset($_SESSION['supplier_id']) ? clean_input($_SESSION['supplier_id']) : '';

  // Update the database
  $query = "UPDATE products 
            SET product_name = ?, quantity = ?, product_price = ?, product_status = ? 
            WHERE (supplier_id = ? AND product_id = ?)";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("ssssss", $update_name, $update_quantity, $update_price, $update_status, $supplier_id, $product_id);
  echo '';
  $stmt->execute();

  // Clear the session variables after updating
  unset($_SESSION['product_id']);
  unset($_SESSION['supplier_id']);
  unset($_SESSION['product_name']);
  unset($_SESSION['product_price']);
  unset($_SESSION['quantity']);
  unset($_SESSION['product_status']);
}

// Fetch data to display in the table
$query2 = "SELECT product_id, product_name, quantity, product_price, product_status, supplier_name 
           FROM suppliers 
           INNER JOIN products ON suppliers.supplier_id = products.supplier_id";
$display_result = mysqli_query($conn, $query2);

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
    <p>
      <?php if ($stmt->execute()) {
        // Query executed successfully
        echo "Update successful!";
      } else {
        // Query execution failed
        echo "Error updating record: " . $stmt->error;
      } ?>
    </p>
    <h1>CP476 Project</h1>
    <nav>
      <p>Welcome back, <strong>
          <?= $_SESSION['uname'] ?>
        </strong>!</p>
    </nav>
  </header>
  <div class="content">
    <h1>Update Database</h1>
    <p>
      <?php echo isset($output) ? $output : 'Database connection established.'; ?>
    </p>
    <br />
    <hr />
    <h2>Displayed Data</h2>
    <div class="table_container">
      <div class="table1">
        <h3>Inventory table:</h3>
        <table border="1" cellspacing="2" cellpadding="2">
          <tr>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Status</th>
            <th>Supplier Name</th>
          </tr>
          <?php while ($rows = mysqli_fetch_assoc($display_result)) { ?>
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
          <?php echo mysqli_num_rows($display_result); ?>
        </p>
      </div>
    </div>

    <br />
    <button onclick="location.href = 'update.php';">Go Back</button>
    <button onclick="location.href = 'dashboard.php';">Home</button>
  </div>
</body>

</html>