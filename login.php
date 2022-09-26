<?php
session_start();

if (isset($_SESSION['user_id']))
{
    header('Location: /php-login');
}
require 'database.php';

if (!empty($_POST['email']) && !empty($_POST['password']))
{
    $records = $conn->prepare('SELECT id, email, password FROM users WHERE email = :email');
    $records->bindParam(':email', $_POST['email']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $message = '';

    if ($results === false)
    {
        $message = '!El usuario no existe¡';
    }
    else
    {
        if (count($results) > 0 && password_verify($_POST['password'], $results['password']))
        {
            $_SESSION['user_id'] = $results['id'];
            header("Location: /php-login");
        }
        else
        {
            $message = '!Usuario o contraseña incorrecta¡';
        }
    }
}

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Home</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
  </head>
  <body>
    <?php require 'partials/header.php' ?>
    <h1>Iniciar sesiòn</h1>

    <form action="login.php" method="POST">
      <input name="email" type="text" placeholder="Enter your email">
      <input name="password" type="password" placeholder="Enter your Password">
      <?php if (!empty($message)): ?> <p> <?=$message ?></p> <?php endif; ?>
      <button class="button" type="submit" value="Submit">Login</button>
    </form>
    <br>
    <a button class="button" href="signup.php">Registrarse</button>
  </body>
</html>
