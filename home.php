<?php
//Sabeu es una cookie de sessio?
    date_default_timezone_set('Europe/Madrid'); //Aqui posarem la hora del servidor a hora de Madrid
    // ---> Si no hi ha sessió no cal revisar res més: OUT! <----
    if(!isset($_COOKIE[session_name()])){ //Recordem que sempre fem un ! abans dun if és per indicar el contrari
        // if 2+2 == 4 ; true   ---   if 2+2 !=4 ; false
        header("Location: index.php"); //El header és per fer un redirect //Quan poses aixo fa la mateixa que fer un boto de html amb un href(Fan el mateix pero serveixen per coses completament diferents)
        exit;
    }
    else{
        session_start();
        if(!isset($_SESSION['username'])){ //Si la cookie de sessio del username no esta disponible
            //Hi ha la sessió però no les variables de sessió!! Hasta la vista baby!
            header("Location: logout.php"); //I aqui tornem a fer un redirect a la pagina de logout
            exit;
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="initial-scale=1, maximum-scale=1">
        <title>Cinetics: The Next Revolution on Social Networks</title>
        <!-- Bootstrap core CSS -->
        <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom fonts -->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,200i,300,300i,400,400i,600,600i,700,700i,900,900i" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Merriweather:300,300i,400,400i,700,700i,900,900i" rel="stylesheet">
        
        <!-- Cinetics font -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" rel="stylesheet">

        <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

        <!-- Custom styles -->
        <link href="css/common.css" rel="stylesheet">
        <link href="css/home.css" rel="stylesheet">

        <link rel="icon" href="./img/favicon-16x16.png" /> 
    </head>
    <body>
        <div class="overlay"></div>
        <video playsinline="playsinline" autoplay="autoplay" muted="muted" loop="loop">
        <source src="mp4/home.mp4" type="video/mp4">
        </video>

        <div class="masthead">
        <div class="masthead-bg"></div>
        <div class="container h-100">
            <div class="row h-100">
            <div class="col-12 my-auto">
                <div class="masthead-content text-white py-5 py-md-0">
                    <h1 class="mb-5"><span class="cinetics">Cinetics</span></h1>
                    <h2><?php echo 'Welcome ' . $_SESSION['username']; ?><h2>
                </div>
            </div>
            </div>
        </div>
        </div>

        <div class="social-icons">
        <ul class="list-unstyled text-center mb-0">
            <li class="list-unstyled-item">
                <a id="logout" href="logout.php">
                    <i class="fa fa-door-open"></i>
                </a>
            </li>
        </ul>
        </div>
        <!-- Bootstrap core JavaScript -->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    </body>
</html>