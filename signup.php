<?php include_once "header.php"; ?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Home Page</title>
    <link href="style.css" rel="stylesheet" type="text/css">
</head>
<div class="content_signup">
<body class="signup">
        <h2>Signup:</h2>

        <form action="includes/signup_inc.php" method="post">
        <label for="html">FIRST NAME:</label>
        <input type="text" name="fname"><br>

        <label for="html">LAST NAME:</label>
        <input type="text" name="lname"><br>

        <label for="html">E-MAIL:</label>
        <input type="text" name="email"><br>

        <label for="html">USERNAME:</label>
        <input type="text" name="uname"><br>

        <label for="html">PASSWORD:</label>
        <input type="password" name="pw"><br>

        <button type="submit" name="signup">Signup</button>
      </form>
</body>
</div>
</html>

<?php include_once "footer.php"; ?>