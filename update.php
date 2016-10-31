<?php
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
    
    if(!empty($_GET['id']))
    {
        $id = checkInput($_GET['id']);
    }

    $dateError = $messageError = "";

    if(!empty($_POST))
    {
        $date           = checkInput($_POST['date']);
        $message        = checkInput($_POST['message']);
        $isSuccess      = true;

        if(empty($date))
        {
            $dateError = 'Ce champ ne peut pas être vide';
            $isSuccess = false;
        }
        if(empty($message))
        {
            $messageError = 'Ce champ ne peut pas être vide';
            $isSuccess = false;
        }

        if ( $isSuccess )
        {
          $statement = $db->prepare("UPDATE tbl_request  set date = ?, message = ? WHERE id = ?");
          $statement->execute(array($date , $message , $id));

          header("Location: myrequest.php");
        }
    }
    else
    {
        $stmt = $db->prepare('SELECT * FROM tbl_request WHERE id = ?');
        $stmt->execute(array($id));
        $row = $stmt->fetch();
        $date      = $row ['date'];
        $message   = $row ['message'];
    }

    function checkInput($data)
    {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }

?>



<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mes Souhaits | Modify</title>
        <?php require 'header.inc.php'; ?>
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
</head>

<body id="login">
         <div class="container" id="con">
            <div class="row">
                <div class="col-sm-12">
                  <h2 class="form-request-heading">Mes souhaits</h2>
                  <hr />
                    <h3><strong>Modifier un souhait</strong></h3>

                    <form class="form" action="<?php echo 'update.php?id='.$id;?>" role="form" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <h5 class="form-label">Choisissez la date pour votre souhait:</h5>
                            <input type="text" class="input-block-level" id="datepicker" placeholder="Choisissez une date" name="date" value="<?php echo $date;?>"/>

                            <span class="help-inline"><?php echo $dateError;?></span>
                        </div>
                        <div class="form-group">
                            <h5 class="form-label">Note votre souhait:</h5>
                            <input type="text" class="input-block-level" placeholder="Entrez votre souhait" id="message" name="message" value="<?php echo $message;?>" />
                            <span class="help-inline"><?php echo $messageError;?></span>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success"><span></span> Modifier</button>
                            <a class="btn btn-primary" href="myrequest.php"><span></span> Retour</a>
                       </div>
                    </form>
                </div>
            </div>
        </div>
      </div>
        <!-- /container -->

        <?php require 'footer.inc.php'; ?>
        <?php require 'script.inc.php'; ?>
    </body>
</html>
