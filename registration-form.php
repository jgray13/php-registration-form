<?php
require_once 'config.php';
$page_title = 'Registration Form';
$username = '';
$email = '';
$password = '';
$confirm_password = '';
$username_error = '';
$email_error = '';
$password_error = '';
$confirm_password_error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_POST['username'])) {
    	$username = trim($_POST['username']);
	}
	if (isset($_POST['email'])) {
    	$email = trim($_POST['email']);
	}
	if (isset($_POST['password'])) {
    	$password = trim($_POST['password']);
	}
	if (isset($_POST['confirm_password'])) {
    	$confirm_password = trim($_POST['confirm_password']);
	}
	if (empty($_POST['username'])) {
	    $username_error = 'Please enter a username';
    } elseif (!ctype_alnum($username)) {
	    $username_error = 'Usernames can only contain letters and numbers';
    } else {
		$username_error = NULL;
		$sql = "SELECT id FROM users WHERE username = ?";
		if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = trim($_POST["username"]);
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_error = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);
        }
    }
	if (empty($_POST['email'])) {
		$email_error = 'Please enter an email address';
	} else {
		$email_error = NULL;
	}
	if (empty($_POST['password'])) {
		$password_error = 'Please enter a password';
	} else {
		$password_error = NULL;
	}
	if (empty($_POST['confirm_password'])) {
		$confirm_password_error = 'Please confirm password';
	} else {
		$confirm_password_error = NULL;
	}
	if (empty($password_error) && ($password != $confirm_password)) {
		$confirm_password_error = 'Passwords do not match';
	}
	if(empty($username_error) && empty($password_error) && empty($confirm_password_error) && empty($email_error)){
        $sql = "INSERT INTO users (username, email,  password) VALUES (?, ?, ?)";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_email, $param_password);
            $param_username = $username;
			$param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            if(mysqli_stmt_execute($stmt)){
                header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($link);
}
include 'includes/header.html';
?>

		    <h1>Registration</h1>
		        <form action="" method="POST" id="signup-form">
			        <div id="form-inner">
					    <fieldset>
					        <legend>Complete this form to register</legend>
			                <label for="name">Username: </label>
				            <input type="text" name="username" id="username" value="<?php if (isset($_POST['username'])) echo $_POST['username']; ?>">
				            <p class="err-message"><?php if (!empty($username_error)) echo  $username_error; ?></p>
				
				            <br><label for="email">Email: </label>
				            <input type="email" name="email" id="email" value="<?PHP if (isset($_POST['email'])) echo $_POST['email']; ?>">
				            <p class="err-message"><?php if (!empty($email_error)) echo  $email_error; ?></p>
				
				            <br><label for="password">Password: </label>
				            <input type="password" name="password" id="password" >
				            <p class="err-message"><?php if (!empty($password_error)) echo $password_error; ?></p>
				
				            <br><label for="confirm_password">Confirm Password: </label>
				            <input type="password" name="confirm_password" id="confirm_password" >
				            <p class="err-message"><?php if (!empty($confirm_password_error)) echo  $confirm_password_error; ?></p>
				
		                    <br><input type="submit" name="register" value="register" class="submit-button">
						</fieldset>
		            </div>
				</form>
<?php
include 'includes/footer.html';
?>