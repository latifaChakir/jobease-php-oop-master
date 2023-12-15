<?php
include('../../database/connection.php');

require_once('../../models/user.php');

$user = new User($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $user->setUsername($_POST['username']);
  $user->setEmail($_POST['email']);
  $user->setPassword($_POST['password']);
  $user->setRoleName('candidat');
  $confirmPassword = $_POST['confirm_password'];

  if ($user->isUsernameTaken()) {
    echo 'Username already exists';
  }  else {
    if ($user->insertUser()) {
      $hashedConfirmPassword = password_hash($confirmPassword, PASSWORD_DEFAULT);

      echo 'Password: ' . $user->getPassword() . '<br>';
      echo 'Confirm Password: ' . $hashedConfirmPassword . '<br>';

      if (password_verify($confirmPassword, $user->getPassword())) {
        header('Location: login.php');
      } else {
        echo 'Le mot de passe et le confirm ne sont pas égaux';
      }
    } else {
      echo 'User insertion failed';
    }
  }
}


?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration or Sign Up form in HTML CSS | CodingLab</title>
  <link rel="stylesheet" href="../../styles/registerstyle.css">
</head>

<body>
  <div class="wrapper">
    <h2>Registration</h2>
    <form method="POST">
      <div class="input-box">
        <input type="text" name="username" placeholder="Enter your name" required>
      </div>
      <div class="input-box">
        <input type="text" name="email" placeholder="Enter your email" required>
      </div>
      <div class="input-box">
        <input type="password" name="password" placeholder="Create password" required>
      </div>
      <div class="input-box">
        <input type="password" name="confirm_password" placeholder="Confirm password" required>
      </div>
      <div class="policy">
        <input type="checkbox" required>
        <h3>I accept all terms & condition</h3>
      </div>
      <div class="input-box button">
        <input type="submit" value="Register Now">
      </div>
      <div class="text">
        <h3>Already have an account? <a href="login.php">Login now</a></h3>
      </div>
    </form>
  </div>
</body>

</html>