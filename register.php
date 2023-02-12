<?php
    require_once(dirname(__FILE__) . '/lib/user.php'); //Tornem a demanar l'arxiu per fer la gestio de l'usuari
       
    if($_SERVER["REQUEST_METHOD"] == "POST"){ //Si la manera que sha accedit a la pagina es per post entrara aqui dins
        if(isset($_POST['user']) && isset($_POST['email']) && isset($_POST['password']) &&
            isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['password2'])){ //Si totes les dades que li hem demanat estan posades entrarem a dins del if

            //Protecció contra Injecció a través d'input fields
            $userPOST       = filter_input(INPUT_POST, 'user'); //Pillara la variable _POST 'user' i li passara el filtre de input_post
            $mailPOST       = filter_input(INPUT_POST, 'email');//Pillara la variable _POST 'email' i li passara el filtre de input_post
            $firstnamePOST  = filter_input(INPUT_POST, 'firstname');//Pillara la variable _POST 'firstname' i li passara el filtre de input_post
            $lastnamePOST   = filter_input(INPUT_POST, 'lastname');//Pillara la variable _POST 'lastname' i li passara el filtre de input_post
            $passwordPOST   = filter_input(INPUT_POST, 'password');//Pillara la variable _POST 'password' i li passara el filtre de input_post
            $password2POST  = filter_input(INPUT_POST, 'password2');//Pillara la variable _POST 'password2' i li passara el filtre de input_post

            $user       = $userPOST;
            $email      = $mailPOST;
            $firstname  = $firstnamePOST;
            $lastname   = $lastnamePOST;

            $allOk = isPasswordOk($passwordPOST,$password2POST) && !checkUserExists($userPOST, $mailPOST) && //Aqui farem la comprovacio de que la contrasenya esta ok i comprovarem que l'usuari NO existeix previament, per aixo hem posat ! al davant
                     registerNewUser($userPOST, $mailPOST, $firstnamePOST, $lastnamePOST, $passwordPOST); //Aqui veurem si sha pogut registrar l'usuari
        }
    }else{
        if(isset($_COOKIE[session_name()])){ //Si la persona ya tenia la cookie de sessio oberta anteriorment entrara aqui dins
            header("Location: home.php"); //Aqui farem el redirect a la pagina de home.php
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
            <source src="mp4/bg-register.mp4" type="video/mp4">
        </video>

        <div class="masthead">
            <div class="masthead-bg"></div>
            <div class="container h-100">
                <div class="row h-100">
                    <div class="col-12 my-auto">
                        <div class="masthead-content text-white py-5 py-md-0">
                            <h1 class="mb-5">Sign Up <span class="cinetics">Cinetics</span></h1>
                            <?php 
                            if(isset($allOk) && !$allOk){
                            echo '<p class="error p-2 rounded bg-danger">Sorry, but it is not possible to register an account with the data provided</p>';
                            }
                            ?>
                            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                                <div class="input-group">
                                    <div class="form-group col">
                                        <label for="user">Username</label>
                                        <input id="user" name="user" class="form-control form-control-lg input-cinetics" type="text" value="<?php if(isset($user)) echo $user;?>" autocomplete="off" autofocus required>
                                        <label for="email">Email</label>
                                        <input id="email" name="email" class="form-control form-control-lg input-cinetics" type="email" value="<?php if(isset($user)) echo $email;?>" autocomplete="off" required>
                                        <label for="firstname">First Name</label>
                                        <input id="firstname" name="firstname" class="form-control form-control-lg input-cinetics" type="text" value="<?php if(isset($user)) echo $firstname;?>" autocomplete="off" required>
                                        <label for="lastname">Last Name</label>
                                        <input id="lastname" name="lastname" class="form-control form-control-lg input-cinetics" type="text" value="<?php if(isset($user)) echo $lastname;?>" autocomplete="off" required>
                                        <label for="password">Password</label>
                                        <input id="password" name="password" class="form-control form-control-lg input-cinetics" type="password" value="" autocomplete="off" required>
                                        <label for="password2">Verify Password</label>
                                        <input id="password2" name="password2" class="form-control form-control-lg input-cinetics" type="password" value="" autocomplete="off" required>
                                        <button class="form-control form-control-lg btn btn-secondary mt-3" type="submit"><span>Sign Up</span></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="social-icons">
            <ul class="list-unstyled text-center mb-0">
                <li class="list-unstyled-item">
                    <a href="#"><i class="fab fa-android"></i></a>
                </li>
                <li class="list-unstyled-item">
                    <a href="#"><i class="fab fa-apple"></i></a>
                </li>
            </ul>
        </div>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <?php if(isset($allOk) && $allOk) echo '<script src="js/register.js"></script>'; ?>
    </body>
</html>