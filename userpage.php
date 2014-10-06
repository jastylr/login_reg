<?php
	session_start();

	if (!isset($_SESSION['user']) || $_SESSION['user']['is_logged_in'] == FALSE)
	{
		header('Location: index.php');
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>User Page</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<div id="container">
		<button><a href="process.php">Log out!</a></button>

		<?php if (isset($_SESSION['user'])): ?>
			<h2>Hello, <?= $_SESSION['user']['first_name']; ?>!</h2>
			<p>Your email address: <?= $_SESSION['user']['email']; ?></p>
			<p>Your User ID: <?= $_SESSION['user']['id']; ?></p>
		<?php endif; ?>
	</div>
</body>
</html>