<?php
session_start();
$page_title = 'Welcome';
include 'includes/header.html';
if (isset($_SESSION['username'])) {
	$username = $_SESSION['username'];
	echo '<h1>Welcome!</h1><br><p>Hi ' . $username . '!</p><br><a href="logout.php"><input type="button" value="logout" class="submit-button"></a>';
} else {
	echo '<h1>Welcome!</h1><br><p>Please <a href="login.php">Login</a></p>';
}
?>
<?php
include 'includes/footer.html';
?>