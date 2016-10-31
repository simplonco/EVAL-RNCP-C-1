<?php
session_start();
require_once 'class.user.php';
$user_home = new USER();
$req = new USER();

if (!$user_home->is_logged_in()) {
    $user_home->redirect('index.php');
}

$stmt = $user_home->runQuery('SELECT * FROM tbl_users WHERE userID=:uid');
$stmt->execute(array(':uid' => $_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (isset($_POST['btn-request'])) {
    $date = trim($_POST['txtdate']);
    $message = trim($_POST['txtmessage']);
    $code = md5(uniqid(rand()));
    $WeekNumber = date('W', strtotime($date));



    $userid = $row['userID'];
    $username = $row['userName'];
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
    
    $stmt = $db->prepare('SELECT * FROM tbl_request WHERE weekNum=:weekNum');
    $stmt->execute(array(':weekNum' => $WeekNumber));
    $stmt->fetch(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() > 5) {
        $msg = "
                <div class='alert alert-error'>
                <button class='close' data-dismiss='alert'>&times;</button>
                <strong>désolé !</strong>  Vous avez plusieur souhaits cette semaine, S'il vous plaît essayer une autre semaine!
                </div>
                ";
    } else {
        $stmt = $db->prepare('INSERT INTO `tbl_request` (`date`, `weekNum`, `message`, `userid`, `tokenCode`) VALUES (:date, :weekNum, :message, :userid, :tokenCode)');
        $stmt->execute(array(':date' => $date, ':weekNum' => $WeekNumber, ':message' => $message, ':userid' => $userid, ':tokenCode' => $code));


        $stmtU = $db->prepare('SELECT userEmail FROM tbl_users WHERE userID=:id LIMIT 1');
        $stmtU->execute(array(':id' => $userid));
        $row = $stmtU->fetch(PDO::FETCH_ASSOC);
        $useremail = $row['userEmail'];

        $mail = '16magic.wishes@gmail.com';
        $messages = "
                    <img src='./images/Magic-Lamp.png' alt='Magic-Lamp'>
                    <br /><br />
                    chèr <b>$username</b>,
                    <br /><br />
                    Merci d'utiliser Mes souhaits application et nous tenons à votre rêve devienne réalité très bientôt <br /><br />
                    Votre Souhait: $message<br/><br/>
                    <br />
                    Merci,";

        $subject = "MERCI d'utiliser Mes souhaits application";

        $req->send_mail($useremail, $messages, $subject);
        $msg = "
                <div class='alert alert-success'>
                    <button class='close' data-dismiss='alert'>&times;</button>
                    Nous tenons à votre rêve devienne réalité très bientôt, bonne fin de journée.
                </div>
                ";
                header('refresh:2;home.php');
    }
}
?>

<!DOCTYPE html>
<html class="no-js">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mes Souhaits | Magique</title>
    <?php require 'header.inc.php'; ?>
</head>
<body>
      <?php require 'navbar.inc.php'; ?>
        <div class="container" id="con">
            <?php
            if (isset($msg)) {
                echo $msg;
            }
            ?>
            <div>
              <form class="form-request" method="post">
                  <h3 class="form-request-heading">Ajouter un souhait</h3>
                  <hr />
                  <h5 class="form-label">Choisissez la date pour votre souhait:</h5>
                  <input type="text" class="input-block-level" id="datepicker" placeholder="Choisissez une date" name="txtdate" required />
                  <h5 class="form-label">Indiquez votre souhait:</h5>
                  <input type="text" class="input-block-level" placeholder="Entrez votre souhait" name="txtmessage" required />
                  <hr />
                  <button class="btn btn-large btn-warning" type="submit" name="btn-request">Enregistrer</button>
              </form>
            </div>
            <h4 class="form-request-heading">Les personnes qui, comme vous, utilisent l'application, expriment un ou des souhaits. Exemples:</h4>
            <div class="alert alert-info">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th style="text-align: center">Date</th>
                            <th style="text-align: center">Description</th>
                            <th style="text-align: center">Tweet</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php
                      try
                        {
                        // On se connecte à MySQL
                        $dbr = new PDO('mysql:host=localhost;dbname=dbmagic', 'root', 'root');
                        $dbr->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        }
                        catch(Exception $e)
                        {
                        // En cas d'erreur, on affiche un message et on arrête tout
                        die('Erreur : '.$e->getMessage());
                        }


                      $stmtr = $dbr->query("SELECT date, message FROM tbl_request ORDER BY RAND( ) LIMIT 5");
                      while ($requestr = $stmtr->fetch()) {
                          echo '<tr>';
                          echo '<td width=85>'.$requestr['date'].'</td>';

                          echo '<td>'.$requestr['message'].'</td>';
                          echo '<td width=65> <a href="https://twitter.com/share" data-url=" " class="twitter-share-button" data-text="Mon Souhait: '.$requestr['message'].'">Tweet</a> </td>';
                          echo '</tr>';
                      }
                    ?>

                    </tbody>
                </table>
            </div>

        </div>
        <!-- /container -->
        <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
        <?php require 'footer.inc.php'; ?>
        <?php require 'script.inc.php'; ?>
</body>

</html>
