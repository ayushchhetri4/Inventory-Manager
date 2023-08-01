<?php
session_start();

// If the user is not logged in, redirect to the login page
if (!isset($_SESSION['uname'])) {
  header('Location: index.php');
  exit;
}

require_once "includes/db_inc.php";
// Create tables (schema)
try {
  $sql = file_get_contents("init_tables.sql");
  if ($conn->multi_query($sql)) {
    do {
      if ($result = $conn->store_result()) {
        $result->free();
      }
    } while ($conn->next_result());
  } else {
    printf("Error: %s\n", $conn->error);
  }
  error_log("Tables created successfully");
} catch (Exception $e) {
  error_log("Error creating tables: " . $e->getMessage());
}

// Function to insert data into the "suppliers" table
function insertSuppliers($conn, $supplierData)
{
  $sql = $conn->prepare("INSERT INTO suppliers (supplier_id, supplier_name, supplier_address, phone, email) VALUES (?, ?, ?, ?, ?)");

  if (!$sql) {
    // Error handling for prepare failure
    error_log("Error in prepare statement (Suppliers): " . $conn->error);
    return false;
  }

  $sql->bind_param('sssss', $supplierData[0], $supplierData[1], $supplierData[2], $supplierData[3], $supplierData[4]);

  if ($sql->execute()) {
    // Success
    $sql->close();
    return true;
  } else {
    // Error handling for execute failure
    error_log("Error in query execution (Suppliers): " . $sql->error);
    $sql->close();
    return false;
  }
}

// Function to insert data into the "products" table
function insertProducts($conn, $productData)
{
  $sql = $conn->prepare("INSERT INTO products (product_id, product_name, product_desc, product_price, quantity, product_status, supplier_id) VALUES (?, ?, ?, ?, ?, ?, ?)");

  if (!$sql) {
    // Error handling for prepare failure
    error_log("Error in prepare statement (Products): " . $conn->error);
    return false;
  }

  $sql->bind_param('sssssss', $productData[0], $productData[1], $productData[2], $productData[3], $productData[4], $productData[5], $productData[6]);

  if ($sql->execute()) {
    // Success
    $sql->close();
    return true;
  } else {
    // Error handling for execute failure
    error_log("Error in query execution (Products): " . $sql->error);
    $sql->close();
    return false;
  }
}

// Function to convert file into 2D indexed array
function get_lines($fh)
{
  while (!feof($fh)) {
    yield explode(', ', fgets($fh));
  }
}

// Open files for reading
$product_file = fopen("ProductFile.txt", "r");
$supplier_file = fopen("SupplierFile.txt", "r");

// delete existing tables
try {
  $sql = file_get_contents('del_db.sql');
  $conn->query($sql);
} catch (Exception $e) {
  error_log("Error deleting tables: " . $e->getMessage());
}

// INSERT DATA INTO TABLES - use prepared statements

// Suppliers table
foreach (get_lines($supplier_file) as $line) {
  if (count($line) > 1) {
    insertSuppliers($conn, $line);
  }
}

// Products table
foreach (get_lines($product_file) as $line) {
  if (count($line) > 1) {
    insertProducts($conn, $line);
  }
}

// Close files
fclose($product_file);
fclose($supplier_file);

// Redirect to index.php after data insertion
header('Location: dashboard.php');
exit();
?>