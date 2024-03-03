<?php
// Initialize the session
session_start();
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ 
            font: 14px sans-serif; 
            text-align: center; 
            display: flex;
            justify-content: center;
            flex-direction: column;
            align-items: center;
        }
        h2.message{
            text-align: left;
        }
    </style>
</head>
<body>
    <h1 class="my-5"> Welcome to your internal message box!</h1>
    <h2 class="message">
	<?php echo $_SESSION['message'];?>
    </h2>
    <br>
    <p>
        <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
    </p>
</body>
</html>
