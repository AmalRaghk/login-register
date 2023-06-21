<!DOCTYPE html>
<html>
<head>
  <title>Register</title>
  <link rel="stylesheet" href="register.css">
</head>
<body>
  <h1>Register</h1>
  <form action="register.php" method="post">
    <input type="text" name="name" placeholder="Name">
    <input type="email" name="email" placeholder="Email">
    <input type="password" name="password" placeholder="Password">
    <input type="password" name="confirm_password" placeholder="Confirm Password">
    <input type="submit" value="Register">
  </form>
</body>
</html>
<?php

// Create the database connection
$db = new mysqli('localhost', 'root', '', 'my_database');

// Check if the connection was successful
if ($db->connect_error) {
  die('Connection failed: ' . $db->connect_error);
}

// If the form was submitted, check the data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Check if the name is empty
  if (empty($_POST['name'])) {
    echo '<p>Please enter your name.</p>';
  }

  // Check if the email is empty
  if (empty($_POST['email'])) {
    echo '<p>Please enter your email address.</p>';
  }

  // Check if the password is empty
  if (empty($_POST['password'])) {
    echo '<p>Please enter a password.</p>';
  }

  // Check if the passwords match
  if ($_POST['password'] != $_POST['confirm_password']) {
    echo '<p>The passwords do not match.</p>';
  }

  // If all the data is valid, insert it into the database
  else {
    $id = mt_rand();
    $sql = 'INSERT INTO users (id, name, email, password) VALUES (?, ?, ?, ?)';
    $stmt = $db->prepare($sql);
    $stmt->bind_param('ssss', $id, $_POST['name'], $_POST['email'], $_POST['password']);
    $stmt->execute();

    // Redirect the user to the login page
    header('Location: login.php');
  }
}

?>