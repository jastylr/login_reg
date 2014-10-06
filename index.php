<?php
	session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Login and Registration</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<div id="container">
		<?php if (!empty($_SESSION['errors'])): ?>
			<?php foreach($_SESSION['errors'] as $error): ?>
				<p class="error"><?= $error; ?></p>
			<?php endforeach; ?>
			<?php unset($_SESSION['errors']); ?>
		<?php endif; ?>
		<h2>Simple Login and Registration</h2>
		<p>A simple login and registration example app.</p>
		<div id="login">
			<form action="process.php" method="post">
				<input type="hidden" name="action" value="login">
				<label for="email">Email: </label>
				<input type="text" name="email">
				<label for="password">Password:</label> <input type="password" name="password">
				<input type="submit" value="Log in!">
			</form>
		</div>

		<div id="registration">
			<form action="process.php" method="post">
				<input type="hidden" name="action" value="register">
				<label for="first_name">First name:</label> 
				<input type="text" name="first_name">
				<label for="last_name">Last name:</label> 
				<input type="text" name="last_name">
				<label for="email">Email:</label> 
				<input type="text" name="email">
				<label for="password">Password:</label> 
				<input type="password" name="password">
				<label for="confirm_password">Confirm Password:</label> 
				<input type="password" name="confirm_password">
				<input type="submit" value="Register!">
			</form>
		</div>
	</div>
</body>
</html>