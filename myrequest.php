<?php
session_start();
require_once 'class.user.php';
$user_home = new USER();

if (!$user_home->is_logged_in()) {
    $user_home->redirect('index.php');
}

$stmt = $user_home->runQuery('SELECT * FROM tbl_users WHERE userID=:uid');
$stmt->execute(array(':uid' => $_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$userid = $row['userID'];
$username = $row['userName'];

$db = new PDO('mysql:host=localhost;dbname=dbmagic;charset=utf8mb4', 'root', 'root');
?>

<!DOCTYPE html>
<html class="no-js">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mes Souhaits</title>
    <?php require 'header.inc.php'; ?>
</head>
<body style="background:rgb(170, 17, 51)">
  <?php require 'navbar.inc.php'; ?>
    <div class="container" id="con2">
        <h2 class="form-request-heading">Mes souhaits</h2>
        <hr />
        <div class="alert alert-info">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                <?php
                  $statusY = "Accepté";
                  $keyY = base64_encode($statusY);
                  $statusY = $keyY;

                  $order = $_GET['order'];

                  $stmt = $db->query('SELECT * FROM tbl_request WHERE userid = '.$userid.' ORDER BY id DESC');
                  while ($request = $stmt->fetch()) {
                      echo '<tr>';
                      echo '<td width=100>'.$request['date'].'</td>';

                      echo '<td>'.$request['message'].'</td>';



                      echo '<td width=310>';
                      if ($request['validate'] == "Attendre") {
                          echo '<a class="btn btn-warning" id="btn-admin" href="verifyreq.php?id='.base64_encode($request['id']).'&code='.$request['tokenCode'].'&status='.$statusY.'"><span class="glyphicon glyphicon-pencil"></span> Se réaliser </a>';
                          echo ' ';
                          echo '<a class="btn btn-primary" href="update.php?id='.$request['id'].'"><span class="glyphicon glyphicon-pencil"></span> Modifier </a>';
                          echo ' ';
                          echo '<a class="btn btn-danger" href="delete.php?id='.$request['id'].'"><span class="glyphicon glyphicon-remove"></span> Supprimer </a>';
                          echo '</td>';
                          } else {
                              if ($request['validate'] == "Accepté") {
                                  echo '<strong style="color:red"> Félicitation votre souhait se réalise ! </strong>';
                              }
                          }

                      echo '</tr>';
                  }
                ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- /container -->
    <?php require 'footer.inc.php'; ?>
    <?php require 'script.inc.php'; ?>
</body>
</html>
