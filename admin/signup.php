<?php


   require_once "db_connect.php";
    $username = $email =$password =$confirm_password ="";
    
    if ($_SERVER['REQUEST_METHOD'] == "POST"){

        // Check if username is empty
        if(empty(trim($_POST["username"]))){
            $username_err = "Username cannot be blank";
        }
        else{
            $sql = "SELECT username FROM users WHERE username = ?";
            $stmt = mysqli_prepare($conn, $sql);
            if($stmt)
            {
                mysqli_stmt_bind_param($stmt, "s", $param_username);
    
                // Set the value of param username
                $param_username = trim($_POST['username']);
    
                // Try to execute this statement
                if(mysqli_stmt_execute($stmt)){
                    mysqli_stmt_store_result($stmt);
                    if(mysqli_stmt_num_rows($stmt) == 1)
                    {
                        $username_err = "This username is already taken"; 
                    }
                    else{
                        $username = trim($_POST['username']);
                    }
                }
                else{
                    echo "Something went wrong";
                }
            }
        }
    
        mysqli_stmt_close($stmt);
    
    
    // Check for password
    if(empty(trim($_POST['password']))){
        $password_err = "Password cannot be blank";
    }
    elseif(strlen(trim($_POST['password'])) < 5){
        $password_err = "Password cannot be less than 5 characters";
    }
    else{
        $password = trim($_POST['password']);
    }

    // Check for confirm password field
    if(trim($_POST['password']) !=  trim($_POST['confirm_password'])){
        $password_err = "Passwords should match";
    }
    
  
    
    
    // If there were no errors, go ahead and insert into the database
    if(empty($username_err) && empty($password_err) )
    {
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt)
        {
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
    
            // Set these parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT);
    
            // Try to execute the query
            if (mysqli_stmt_execute($stmt))
            {
                header("location: login.php");
            }
            else{
                echo "Incoreect username and password";
                echo "Something went wrong... cannot redirect!";
            }
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
    }
    
    ?>
    
<!DOCTYPE html>
<html>
<head>
<title>SignUp Form</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href="//fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,700,700i" rel="stylesheet">

<link rel="stylesheet" type="text/css" href="assets\signupcss.css">

<!-- //web font -->
</head>
<body class="img js-fullheight" style="background-image: url(login2.jpg);">

	<!-- main -->
	<div class="main-w3layouts wrapper">
		<h1>Event SignUp Form</h1>
		<div class="main-agileinfo">
			<div class="agileits-top">
				<form action="" method="post">
                    <p>User Type</p>
                <input class="text w3lpass" id="administrator" type="radio" name="name"  required="">
                <label for="administrator">Administrator</label><br>
                <input class="text w3lpass" id="customers" type="radio" name="name"  required="">
                <label for="customers">Customer</label><br>

					<input class="text w3lpass" type="text" name="username" placeholder="Username" required="">
					
					<input class="text w3lpass" type="password" name="password" placeholder="Password" required="">
                    <input class="text w3lpass" type="password" name="confirm_password" placeholder="Confirm Password" required="">
					<div class="wthree-text">
						<label class="anim">
							<input type="checkbox" class="checkbox" required="">
							<span>I Agree To The Terms & Conditions</span>
						</label>
						<div class="clear"> </div>
					</div>
					<input type="submit" value="SIGNUP">
				</form>
				<p>I have an Account? <a href="login.php"> Login Now!</a></p>
			</div>
		</div>
		<!-- copyright -->
		<div class="colorlibcopy-agile">
			
		</div>
		<!-- //copyright -->
		<ul class="colorlib-bubbles">
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
		</ul>
	</div>
	<!-- //main -->
</body>
</html>