<?php
// We start our session
session_start();
// If the user is not logged in, redirect to the login page...
if (!isset($_SESSION['uname'])) {
  header('Location: index.html');
  exit;
}

// Connect to the database using mysqli
require_once "includes/db_inc.php";
require_once "includes/functions_inc.php";

// Get cleaned POST data
$product_id = clean_input($_POST['product_id']);
$supplier_id = clean_input($_POST['supplier_id']);

// Different queries based on form data
$query = "SELECT product_id, product_name, quantity, product_price, product_status, supplier_name FROM suppliers INNER JOIN products ON suppliers.supplier_id = products.supplier_id";

if (!empty($product_id) && empty($supplier_id)) {
  $query .= " WHERE products.product_id = ?";
  $result = executeQuery($conn, $query, "s", $product_id);
} else if (empty($product_id) && !empty($supplier_id)) {
  $query .= " WHERE products.supplier_id = ?";
  $result = executeQuery($conn, $query, "s", $supplier_id);
} else if (!empty($product_id) && !empty($supplier_id)) {
  $query .= " WHERE products.supplier_id = ? AND products.product_id = ?";
  $result = executeQuery($conn, $query, "ss", $supplier_id, $product_id);
} else {
  $_SESSION['status'] = "Both fields cannot be empty";
  header('Location: search.php');
  exit;
}

// Function to execute a prepared statement and return the result set
function executeQuery($conn, $query, $paramTypes, ...$params)
{
  $stmt = $conn->prepare($query);
  if ($stmt === false) {
    $_SESSION['status'] = "Database query error.";
    header('Location: search.php');
    exit;
  }

  $stmt->bind_param($paramTypes, ...$params);
  $stmt->execute();
  $result = $stmt->get_result();

  // Close the statement to avoid "Commands out of sync" error
  $stmt->close();

  return $result;
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Home Page</title>
  <link href="search_results_style.css" rel="stylesheet" type="text/css">
</head>

<body class="loggedin">
  <header class="navtop">
    <h1>CP476 Project</h1>
    <nav>
      <p>Welcome back, <strong>
          <?= $_SESSION['uname'] ?>
        </strong>!</p>
    </nav>
  </header>
  <div class="content">
    <h1>Search Database</h1>
    <p>
      <?= "Database Status: " . $_SESSION['db_status']; ?>
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
          <?php while ($rows = $result->fetch_assoc()) { ?>
            <tr>
              <td>
                <?= $rows['product_id']; ?>
              </td>
              <td>
                <?= $rows['product_name']; ?>
              </td>
              <td>
                <?= $rows['quantity']; ?>
              </td>
              <td>
                <?= $rows['product_price']; ?>
              </td>
              <td>
                <?= $rows['product_status']; ?>
              </td>
              <td>
                <?= $rows['supplier_name']; ?>
              </td>
            </tr>
          <?php } ?>
        </table>
        <!-- Display row count here -->
        <br />
        <p>Number of rows:
          <?= $result->num_rows; ?>
        </p>
      </div>
    </div>

    <br />
    <button onclick="location.href = 'search.php';">Go Back</button>
    <button onclick="location.href = 'dashboard.php';">Home</button>
  </div>
</body>

</html>