<?php
    require_once(dirname(__FILE__) . '/lib/user.php'); //Aqui tornarem a fer un require once de l'arxiu de user.php
       
    if($_SERVER["REQUEST_METHOD"] == "POST"){ //Si de la manera que ha entrat a la pagina és POST (Recorda que POST és una manera per entrar amb Formularis)
        if(isset($_POST['user']) && isset($_POST['pass'])){ //Si per valors del post ens han passat la variable user i la variable pass entrarem aqui dins

            //Protecció contra Injecció a través d'input fields
            $userPOST = filter_input(INPUT_POST, 'user'); //Aqui netejarem les variables per impedir cap falla de seguretat
            $passPOST = filter_input(INPUT_POST, 'pass'); //Aqui netejarem les variables per impedir cap falla de seguretat

            $user = checkUser($userPOST, $passPOST); //Ara farem un check per saber si les dades que ens ha passat l'usuari son les correctes, si tenim les dades el valor de user sera true
            if($user){ //Si el valor de user no esta en true (Si l'usuari que ha introduit es incorrecte) no entrara aqui dins
                session_start(); //Arranquem la sessio
                //I tots els valors que ens ha tornat els posarem a dins de la variable de sessio
                $_SESSION['iduser']           = $user['iduser'];
                $_SESSION['mail']             = $user['mail'];
                $_SESSION['username']         = $user['username'];
                $_SESSION['userFirstName']    = $user['userFirstName'];
                $_SESSION['userLastName']     = $user['userLastName'];
                $_SESSION['creationDate']     = $user['creationDate'];
                $_SESSION['lastSignin']       = $user['lastSignin'];
                //Redirecció a pàgina principal
                header("Location: home.php");
                exit;
                //Fem un exit despres de fer un header ja que pot ser que el programa peti (Ho dic pk a lempresa he tingut problemes amb aixo)
            }
            else{ //Si les credencials que ens ha passat de l'usuari son incorrectes entrara aqui dins
                $err = TRUE; //Direm que error es true
                $user = $userPOST;
            }
            $err = TRUE;
        }
    }else{ //Si entra per GET
        if(isset($_COOKIE[session_name()])){ //Comprovara que la cookie de sessio existira o no
            header("Location: home.php"); //Si existeix fara un redirect
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

      <link rel="icon" href="./img/favicon-16x16.png" /> 
  </head>
  <body>

    <div class="overlay"></div>
    <video playsinline="playsinline" autoplay="autoplay" muted="muted" loop="loop">
      <source src="mp4/bg.mp4" type="video/mp4">
    </video>

    <div class="masthead">
      <div class="masthead-bg"></div>
      <div class="container h-100">
        <div class="row h-100">
          <div class="col-12 my-auto">
            <div class="masthead-content text-white py-5 py-md-0">
              <h1 class="mb-5">Sign In <span class="cinetics">Cinetics</span></h1>
              <?php 
              if(isset($err) && $err == TRUE){
                  echo '<p class="error p-2 rounded bg-danger">Sorry, but it is not possible to access with the data provided</p>';
              }
              ?>

              <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                  <div class="input-group">
                      <div class="form-group col">
                          <label for="user">Username / Mail</label>
                          <input id="user" name="user" class="form-control form-control-lg input-cinetics" type="text" value="<?php if(isset($user)) echo $user;?>" autocomplete="off" autofocus required>
                          <label for="pass">Password</label>
                          <input id="pass" name="pass" class="form-control form-control-lg input-cinetics" type="password" autocomplete="off" required>
                          <button class="form-control form-control-lg btn btn-secondary mt-3" type="submit"><span>Sign In</span></button>
                      </div>
                  </div>
              </form>
              <p class="text-center mb-2"><a id="lostPass" class="nav-link" href="#resetPassModal" data-toggle="modal">Forgot Password?</a></p>
              <p class="text-center mb-5">Don't have an account yet? <strong><a id="register" class="nav-link" href="./register.php">Sign Up</a></strong></p>
              
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="social-icons">
      <ul class="list-unstyled text-center mb-0">
        <li class="list-unstyled-item">
          <a href="#">
            <i class="fab fa-android"></i>
          </a>
        </li>
        <li class="list-unstyled-item">
          <a href="#">
            <i class="fab fa-apple"></i>
          </a>
        </li>
      </ul>
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  </body>

</html>