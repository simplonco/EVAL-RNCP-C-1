<?php
session_start();
require_once 'class.user.php';
$user_login = new USER();

if ($user_login->is_logged_in() != '') {
    $user_login->redirect('home.php');
}

if (isset($_POST['btn-login'])) {
    $email = trim($_POST['txtemail']);
    $upass = trim($_POST['txtupass']);

    if ($user_login->login($email, $upass)) {
        $user_login->redirect('home.php');
    }
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Mes Souhaits</title>
        <?php require 'header.inc.php'; ?>
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
</head>

<body id="login">
  <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
          <a class="brand" id="app-name" href="#"><img src="./images/Magic-Lamp.png" alt="Magique Souhaits"> Mes Souhaits </a>
      </div>
  </div>

    <div class="container" id="con2">
        <?php
        if (isset($_GET['inactive'])) {
        ?>
        <div class='alert alert-error'>
            <button class='close' data-dismiss='alert'>&times;</button>
            <strong>désolé!</strong> Ce compte est non activé Accédez à votre boîte de réception et l'activer.
        </div>
        <?php
        }
        ?>
        <form class="form-signin" method="post">
            <?php
            if (isset($_GET['error'])) {
            ?>
            <div class='alert alert-success'>
                <button class='close' data-dismiss='alert'>&times;</button>
                <strong>Informations incorrectes!</strong>
            </div>
            <?php
            }
            ?>

            <h2 class="form-signin-heading">Se connecter</h2>
            <hr />
            <input type="email" class="input-block-level" placeholder="Adresse e-mail" name="txtemail" required />
            <input type="password" class="input-block-level" placeholder="Mot de passe" name="txtupass" required />
            <hr />
            <button class="btn btn-large btn-primary" type="submit" name="btn-login">Se connecter</button>
            <a href="signup.php" style="float:right;" class="btn btn-large">S'enregistrer</a>
            <hr />
            <a href="fpass.php">Perdu votre mot de passe?</a>
        </form>
    </div>
    <!-- Sound NoCopyrightSounds -->
    <iframe width="0" height="0" src="https://www.youtube.com/embed/UkUweq5FAcE?list=PLRBp0Fe2Gpgm57nFVNM7qYZ9u64U9Q-Bf&amp;controls=0&amp;showinfo=0&autoplay=1" frameborder="0" allowfullscreen></iframe>

    <!-- /container -->
    <?php require 'footer.inc.php'; ?>
    <?php require 'script.inc.php'; ?>
</body>
</html>
