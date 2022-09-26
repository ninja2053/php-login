<?php
  session_start();

  require 'database.php';

  if (isset($_SESSION['user_id'])) {
    $records = $conn->prepare('SELECT id, email, password FROM users WHERE id = :id');
    $records->bindParam(':id', $_SESSION['user_id']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $user = null;

    if (count($results) > 0) {
      $user = $results;
    }
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">

  </head>
  <body>
    

    <?php if(!empty($user)): ?>
      <br> ¡Bienvenido. <?= $user['email']; ?>
      <br>Te has logueado correctamente!
      <br>
      <br>
      <?php require 'indexc.php' ?>
    <?php else: ?>
      <h1>Iniciar sesion o registarse</h1>
      
      

      <a class="button" href="login.php">Iniciar sesion</a> o
      <a class="button" href="signup.php">Registarse</a>
    <?php endif; ?>
  </body>
</html>
