<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}

include('config.php');
$username = $_POST['username'];
$password = $_POST['password'];
// SQLMap 
$evilwords = ["/sleep/i", "/0x/i", "/\*\*/", "/-- [a-z0-9]{4}/i", "/ifnull/i", "/ or /i"];
foreach ($evilwords as $evilword) {
	if (preg_match( $evilword, $username )) {
		echo 'SQL Injection detected. This incident will be logged!';
		die();
	} elseif (preg_match( $evilword, $password )) {
		echo 'SQL Injection detected. This incident will be logged!';	
		die();
	}
}


$sql = "select * from siteusers where username = '$username' and password = '$password';";  
$result = mysqli_query($mysqli, $sql);  
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
$count = mysqli_num_rows($result);
if($count == 1){
	// Password is correct, so start a new session
	session_start();

	// Store data in session variables
	$_SESSION["loggedin"] = true;
	$_SESSION["username"] = $row["username"];
	$_SESSION["message"] = str_replace("#PASS#", $row["password"], $row["message"]);

    if (empty($_SESSION['message'])) {
        $_SESSION['message'] = "From a friend:<br>
                                1. Find a way to authenticate without password<br>
                                2. Find a valid user (fuzzing)<br>
                                3. 1+2";
    }
	// Redirect user to welcome page
	header("location: welcome.php");
} elseif ($username == ""){
	$login_err = "";
} else{
	// Password is not valid, display a generic error message
	$login_err = "Invalid username or password";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ 
            font: 14px sans-serif; 
            display: flex;
            justify-content: center;
            flex-direction: column;
            align-items: center;
        }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>User Login</h2>
        <p>Please fill in your credentials to login.</p>

<?php 
if(!empty($login_err)){
        echo '<div class="alert alert-danger">' . $login_err . '</div>';
}        
?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control">
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
	    </div>
	    <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
        </form>
    </div>
</body>
</html>
