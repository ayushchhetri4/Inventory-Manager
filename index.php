<?php
session_start();

// Redirect to "logged_in.php" if the session "uname" is set.
if (isset($_SESSION["uname"])) {
    header("location: ../dashboard.php"); 
    exit(); // Make sure to exit after the header() function to prevent further code execution.
}

include_once "header.php"; ?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Home Page</title>
    <link href="style.css" rel="stylesheet" type="text/css">
</head>
<div class="content">
<body class="index">
        <h2>Login/Signup:</h2>
        <br>

        <!-- sets up navigation -->
        <form class="index_options">
            <input type="button" onclick="location.href = 'login.php';" value="Login"><br>
            <br>
            <input type="button" onclick="location.href = 'signup.php';" value="Signup"><br>
            <br>
        </form>
    </div>
</body>

<?php
if(isset($_GET["error"])){
    if($_GET["error"] == "none"){
        echo "Account succesfully created.";
    }
    else if($_GET["error"] == "usernameincorrect"){
        echo "Username incorrect.";
    }
    else if($_GET["error"] == "passwordincorrect"){
        echo "Password incorrect.";
    }
    else{
        echo "Account could not be created.";
    }
}
?>

</html>
<?php include_once "footer.php"; ?>