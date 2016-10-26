<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container-fluid">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>

            <a class="brand" id="app-name" href="#"><img src="./images/Magic-Lamp.png" alt="Magique Souhaits"> Mes Souhaits </a>
            <div class="nav-collapse collapse">
                <ul class="nav pull-right">
                    <li class="dropdown">
                        <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-user"></i>
                            <?php echo "Bienvenue " . $row['userName']; ?> <i class="caret"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a tabindex="-1" href="home.php">Ajouter un souhait</a>
                                <a tabindex="-1" href="myrequest.php">Mes souhaits</a>
                                <a tabindex="-1" href="logout.php">Se déconnecter</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <ul class="nav">
                    <li class="active">
                      <a href="http://simplon.co/" target="_blank">SimplonCo</a>
                    </li>
                    <li>
                      <a href="http://www.rncp.cncp.gouv.fr/" target="_blank">RNCP</a>
                    </li>
                </ul>
            </div>
            <!--/.nav-collapse -->
        </div>
    </div>
</div>
