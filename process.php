<?php
	session_start();
	require_once('new-connection.php');

	// Check which form has been submitted (Login or Registration)
	// by checking the value of the $_POST['action']
	if (isset($_POST['action']) && $_POST['action'] == 'login') 
	{
		$_SESSION['errors'] = array();

		if (empty($_POST['email']))
		{
			$_SESSION['errors'][] = "Sorry, email cannot be blank.";
		}
		elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
		{
			$_SESSION['errors'][] = "The email you entered is invalid.";
		}

		if (empty($_POST['password']))
		{
			$_SESSION['errors'][] = "Password cannot be blank.";
		}

		// Check if there are no errors to this point
		if (empty($_SESSION['errors']))
		{
			// Encrypt the user's password before using it to retrieve from the database. Here
			// we are using md5 encryption but read on using salted hashes which are more secure
			$password = md5($_POST['password']);
			$query = "SELECT * FROM users where email = '{$_POST['email']}' AND password = '{$password}'";
			$user = fetch_record($query);

			if ($user)
			{
				$user['is_logged_in'] = true;

				$_SESSION['user'] = $user;
				header('Location: userpage.php');
				exit;
			}
			else
			{
				$_SESSION['errors'][] = "No user with the specified email exists in the database";
			}
		}

		header('Location: index.php');
		exit;
	}
	elseif (isset($_POST['action']) &&  $_POST['action'] == 'register')
	{
		if (empty($_POST['first_name']))
		{
			$_SESSION['errors'][] = "First name cannot be blank";
		}
		if (empty($_POST['last_name']))
		{
			$_SESSION['errors'][] = "Last name cannot be blank.";
		}
		if (empty($_POST['email']))
		{
			$_SESSION['errors'][] = "Email cannot be blank";
		}
		elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
		{
			$_SESSION['errors'][] = "Invalid email address supplied";
		}
		if (empty($_POST['password']))
		{
			$_SESSION['errors'][] = "Password cannot be blank";
		}
		elseif ($_POST['password'] != $_POST['confirm_password'])
		{
			$_SESSION['errors'][] = "Password and confirm password do not match";
		}

		if (empty($_SESSION['errors']))
		{
			// See if user is already registered
			$check_user = "SELECT id FROM users WHERE email = '{$_POST['email']}'";
			$user_exists = fetch_record($check_user);

			if (!$user_exists)
			{
				// Encrypt the password before adding it to the datbase. Here we are just
				// using the md5 encryption which is not very secure. Read more about using
				// a salted hash instead
				$password = md5($_POST['password']);

				// Build an SQL query to add the user to the database
				$query = "INSERT INTO users (first_name, last_name, email, password, created_at, updated_at)
									VALUES ('{$_POST['first_name']}', '{$_POST['last_name']}', '{$_POST['email']}',
													'{$password}', NOW(), NOW())";

				$user_id = run_mysql_query($query);

				if ($user_id)
				{
					$user = array(
						'first_name' => $_POST['first_name'],
						'last_name' => $_POST['last_name'],
						'email' => $_POST['email'],
						'id' => $user_id,
						'is_logged_in' => true 
					);

					$_SESSION['user'] = $user;
					header('Location: userpage.php');
					exit;
				}	
				else
				{
					$_SESSION['errors'][] = "Problem adding user to the database";
				}
			}
			else
			{
				$_SESSION['errors'][] = "The user with the specified email address already is registered.";
			}
		}

		header('Location: index.php');
		exit;
	}
	else
	{
		session_destroy();
		header('Location: index.php');
		exit;
	}

?>