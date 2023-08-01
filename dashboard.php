<?php
// check if the right tables are already in place:
//connect to database
require_once "includes/db_inc.php";
require_once "includes/functions_inc.php";

$sql = "SELECT * FROM information_schema.TABLES WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? LIMIT 1";

if ($stmt = $conn->prepare($sql)) {
    // Bind the parameters to the prepared statement
    $stmt->bind_param("ss", $DATABASE_NAME, $table_name);

    // Check if the "suppliers" table exists
    $table_name = "suppliers";
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $_SESSION['suppliers_table_status'] = "Exists";
    } else {
        $_SESSION['suppliers_table_status'] = "Does not exist";
    }

    // Check if the "products" table exists
    $table_name = "products";
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $_SESSION['products_table_status'] = "Exists";
    } else {
        $_SESSION['products_table_status'] = "Does not exist";
    }

    // Close the prepared statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
<session />
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Home Page</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
    <link href="style.css" rel="stylesheet" type="text/css">
</head>

<body class="loggedin">
    <header class="navtop">
        <h1>CP476 Project</h1>
        <nav>
            <p>Welcome back! <strong>
                </strong></p>
        </nav>
    </header>
    <div class="content">
        <hr />

        <h3>Database Table(s) Status:</h3>
        <ul class="status">
            <li>Supplier Table:
                <?= $_SESSION['suppliers_table_status'] ?>
            </li>
            <li>Product Table:
                <?= $_SESSION['products_table_status'] ?>
            </li>
        </ul>
        <?php
        // Check if the session variable exists and has the value "Does not exist"
        if (
            isset($_SESSION['suppliers_table_status']) && $_SESSION['suppliers_table_status'] === "Does not exist" &&
            isset($_SESSION['products_table_status']) && $_SESSION['products_table_status'] === "Does not exist"
        ) { // The button will be displayed only when the condition is met.
            echo '<button class="init" onclick="location.href = \'initialize_tables.php\';">Initialize Tables</button>';
        }
        ?>
        <h2>Here are your options:</h2>

        <!-- sets up navigation -->
        <form class="options">
            <input type="button" onclick="location.href = 'calc_inventories.php';" value="Get Inventory Status"><br>
            <br>
            <input type="button" onclick="location.href = 'search.php';" value="View Product/Supplier Information"><br>
            <br>
            <input type="button" onclick="location.href = 'update.php';"
                value="Update Product/Supplier Information"><br>
            <br>
            <input type="button" onclick="location.href = 'delete.php';"
                value="Delete Product/Supplier Information"><br>
            <br>

            <input type="button" onclick="location.href = 'includes/logout_inc.php';" value="Logout">
        </form>
    </div>
</body>

</html>
