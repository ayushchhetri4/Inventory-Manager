<?php
// We start our session
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['uname'])) {
  header('Location: index.html');
  exit;
}

//connect to database
require_once "includes/db_inc.php";

?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Home Page</title>
  <link href="style.css" rel="stylesheet" type="text/css">
</head>

<body class="authenticated">
  <header class="dashboard-header">
    <h1>CP476 Project</h1>
    <navbar>
      <p>Welcome back, <strong>
          <?= $_SESSION['uname'] ?>
        </strong>!</p>
    </navbar>
  </header>
  <div class="container">
    <div class="search-form">
      <h2>Search Database</h2>
      <p>Database Status:
        <?= $_SESSION['db_status']; ?>
      </p>
      <hr>
      <form action="search_data.php" method="post">
        <div class="form-group">
          <label for="supplier_id">Supplier ID:</label>
          <select name='supplier_id'>
            <?php
            $query = 'SELECT supplier_id FROM suppliers';
            $result = $conn->query($query);
            while ($rows = mysqli_fetch_assoc($result)) {
              echo '<option value=' . $rows['supplier_id'] . '>' . $rows['supplier_id'] . '</option>';
            }
            ?>
          </select>
        </div>

        <div class="form-group">
          <label for="product_id">Product ID:</label>
          <select name='product_id'>
            <?php
            $query = 'SELECT product_id FROM products';
            $result = $conn->query($query);
            while ($rows = mysqli_fetch_assoc($result)) {
              echo '<option value=' . $rows['product_id'] . '>' . $rows['product_id'] . '</option>';
            }
            ?>
          </select>
        </div>
        <br />
        <div class="form-group">
          <input type="submit" value="Search Item">
        </div>
      </form>
    </div>
    <br />
    <div class="home-button">
      <button onclick="location.href = 'dashboard.php';">Home</button>
    </div>
  </div>
</body>

</html>