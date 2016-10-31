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

    if(!empty($_POST))
    {
        $id = checkInput($_POST['id']);

        $sql = "DELETE FROM tbl_request WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $_POST['id'], PDO::PARAM_INT);
        $stmt->execute();

        header("Location: myrequest.php");
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
    <title>Mes Souhaits | Delete</title>
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
            <h3 class="form-request-heading"><strong>Supprimer un souhait !!</strong></h3>
            <form class="form" action="delete.php" role="form" method="post">
                <input type="hidden" name="id" value="<?php echo $id;?>"/>
                <p class="alert alert-warning">Etes vous sur de vouloir supprimer ?</p>
                <div class="form-actions">
                  <button type="submit" class="btn btn-warning">Oui</button>
                  <a class="btn btn-default" href="myrequest.php">Non</a>
                </div>
            </form>
          </div>
        </div>
    </div>
    <!-- /container -->
    <?php require 'footer.inc.php'; ?>
    <?php require 'script.inc.php'; ?>
</body>

</html>
