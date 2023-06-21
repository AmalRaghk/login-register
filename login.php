<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link rel="stylesheet" href="login.css">
</head>
<body>
  <h1>Login</h1>
  <form action="login.php" method="post">
    <input type="email" name="email" placeholder="Email">
    <input type="password" name="password" placeholder="Password">
    <input type="submit" value="Login">
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

// If the form was submitted, check the user's credentials
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Check if the email and password are set
  if (isset($email) && isset($password)) {
    // Check if the user exists in the database
    $sql = 'SELECT * FROM users WHERE email = ? AND password = ?';
    $stmt = $db->prepare($sql);
    $stmt->bind_param('ss', $email, $password);
    $stmt->execute();
    
    // If the user exists, log them in
    if ($stmt->fetch()) {
      session_start();
      $_SESSION['user'] = $email;
      header('Location: index.php');
      echo'<p>This email is valid</p>';
    }

    // Otherwise, show an error message
    else {
      echo '<p>The email or password is incorrect.</p>';
      echo $email;
      echo $password;
    }
  }
  else {
    echo '<p>Please enter your email and password.</p>';
  }
  // Close the statement
$stmt->close();

// Close the database connection
$db->close();
}

?>

