<?php
require_once 'class.user.php';
$user = new USER();

if (empty($_GET['id']) && empty($_GET['code']) && empty($_GET['status'])) {
    $user->redirect('index.php');
}

if (isset($_GET['id']) && isset($_GET['code']) && isset($_GET['status'])) {
    $id = base64_decode($_GET['id']);
    $code = $_GET['code'];
    $status = base64_decode($_GET['status']);

    $statusW = "Attendre";

    // $close = 'JavaScript:window.close()';
    try
      {
      // On se connecte à MySQL
      $db = new PDO('mysql:host=localhost;dbname=dbmagic', 'root', 'root');
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      }
      catch(Exception $e)
      {
      // En cas d'erreur, on affiche un message et on arrête tout
      die('Erreur : '.$e->getMessage());
      }
    
    $stmt = $db->prepare('SELECT id, validate, userid, message, date FROM tbl_request WHERE id=:id AND tokenCode=:code LIMIT 1');
    $stmt->execute(array(':id' => $id, ':code' => $code));
    $ro = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmtU = $db->prepare('SELECT userName, userEmail FROM tbl_users WHERE userID=:id LIMIT 1');
    $stmtU->execute(array(':id' => $ro['userid']));
    $row = $stmtU->fetch(PDO::FETCH_ASSOC);
    $username = $row['userName'];
    $useremail = $row['userEmail'];
    $date    = $ro['date'];
    $souhait = $ro['message'];

    if ($stmt->rowCount() > 0) {
        if ($ro['validate']==$statusW) {
            $stmt = $db->prepare('UPDATE tbl_request SET validate=:validate WHERE id=:id');
            $stmt->bindparam(':validate', $status);
            $stmt->bindparam(':id', $id);
            $stmt->execute();


            $msg = "
                    <div class='alert alert-success'>
                      <button class='close' data-dismiss='alert'>&times;</button>
                      <strong>OK !</strong>  Votre souhait, il a été enregistré dans votre boîte de souhait  ..
                      <!-- <script> setTimeout() </script> -->
                    </div>
                   ";
                  $mail = $useremail;

                  $messages = "
                            <img src='./images/Magic-Lamp.png' alt='Magic-Lamp'>
                            <br /><br />
                             Bonjour , <b>$username</b>
                             <br /><br />
                             Félicitation votre souhait se réalise,
                             <br />de: $souhait
                             <br />de: $date
                             <br /><br />
                             Merci.
                             ";

                   $subject = 'Félicitation votre souhait se réalise !';

                   $user->send_mail($mail, $messages, $subject);
                   header('refresh:2;index.php');
        } else {
            $msg = "
                   <div class='alert alert-error'>
                     <button class='close' data-dismiss='alert'>&times;</button>
                     <strong>désolé !</strong>  Votre demande est déjà activé ..
                     <script> setTimeout() </script>
                   </div>
                   ";
        }
    } else {
        $msg = "
               <div class='alert alert-error'>
                 <button class='close' data-dismiss='alert'>&times;</button>
                 <strong>désolé !</strong>  Non demande trouvé ..
                 <script> setTimeout() </script>
               </div>
               ";
    }
}

?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mes Souhaits | Magique</title>
    <?php require 'header.inc.php'; ?>
</head>
<body id="login">
    <div class="container" id="con2">
    <?php
    if (isset($msg)) {
        echo $msg;
    }
    ?>
    </div>
    <!-- /container -->
    <?php require 'footer.inc.php'; ?>
    <?php require 'script.inc.php'; ?>
    <script type="text/javascript">
        window.setTimeout(function(){
          window.location.href = "myrequest.php";
        }, 1500);
    </script>
</body>

</html>
