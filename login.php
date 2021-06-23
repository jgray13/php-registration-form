<?php
session_start();
if (isset($_SESSION['username'])) {
	header('Location: welcome.php');
}
require_once 'config.php';
$page_title = 'Login';
$username = '';
$password = '';
$username_error = '';
$password_error = '';
$login_error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['username'])) {
	    $username = trim($_POST['username']);
    }
    if (empty($_POST['username']))	{
		$username_error = 'Please enter a username';
	} else {
		$username_error = NULL;
	}
    if (isset($_POST['password'])) {
	    $password = trim($_POST['password']);
    }
	if (empty($_POST['password'])) {
		$password_error = 'Please enter a password';
	} else {
		$password_error = NULL;
	}
	if (empty($username_error) && empty($password_error)) {
		$sql = "SELECT id, username, password FROM users WHERE username = ?";
		if ($stmt = mysqli_prepare($link, $sql)) {
			mysqli_stmt_bind_param($stmt, "s", $param_username);
			$param_username = $username;
			if (mysqli_stmt_execute($stmt)) {
				mysqli_stmt_store_result($stmt);
				if (mysqli_stmt_num_rows($stmt) == 1) {
					mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
					if (mysqli_stmt_fetch($stmt)) {
						if (password_verify($password, $hashed_password)) {
							session_start();
							$_SESSION['id'] = $id;
							$_SESSION['username'] = $username;
							header('Location: welcome.php');
						} else {
							$login_error = 'Invalid password';
						}
					}
				} else {
					$login_error = 'Invalid username';
				}
			} else {
				echo 'Something went wrong. Please try again later';
			}
			mysqli_stmt_close($stmt);
		}
	}
	mysqli_close($link);
}
include 'includes/header.html';
?>
		    <h1>Login</h1>
			    <form action="" method="POST">
				    <div id="form-inner">
					    <fieldset>
						    <legend>Fill in your details to login</legend>
				            <label for="username">Username: </label>
					        <input type="text" name="username" id="username" value="<?php if (isset($_POST['username'])) echo $_POST['username']; ?>">
					        <p class="err-message"><?php if (!empty($username_error)) echo  $username_error;?></p>
					
					        <br><label for="password">Password: </label>
					        <input type="password" name="password" id="password">
					        <p class="err-message"><?php if (!empty($password_error)) echo $password_error;?></p>
						
						    <p class="err-message"><?php if (!empty($login_error)) echo $login_error; ?></p>
						
					        <br><input type="submit" name="submit" value="login" class="submit-button" id="login-button">
						</fieldset>
				    </div>
				</form>
		
		
<?php
include 'includes/footer.html';
?>