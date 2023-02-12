<?php
    //Messing with mess detector... to review proximament

    function openDB(){
        $connectionString = 'mysql:dbname=cinetics;host=localhost;port=3306'; //Aqui declarem la string de la connexio de la base de dades
        $user = 'root'; //Nom d'usuari
        $password = ''; //I la seva contrasenya
        //$password = 'qlovac,l1,l1,vaD.';
        try{
            //Creem una connexió persistent a BDs
            $connDB = new PDO($connectionString, $user, $password, array(PDO::ATTR_PERSISTENT => true)); //AQUEST ERROR NI CAS
            return $connDB;
        }catch(PDOException $e){
            echo 'Error amb la BDs: ' . $e->getMessage();
        }
    
    }

    //Aquesta sera la funcio que farem servir per saber si un usuari o un correu sha fet servir
    function checkUserExistsDB($username, $email){

        try{
            $userValid = false; //Declarem la variable uservalid i li posem false

            $connDB = openDB(); //Fem que ens retorni la connexio a la base de dades
            if(isset($connDB)){ //un ISSET és una comanda de php que detecta si te algun tipus de valor
                //Si connDB no s'hagues pogut arrancar correctament, no tindria valor i no entraria a dins del if
                $sql = 'SELECT `iduser`,`mail`,`username` FROM `users` WHERE mail = :mail OR username = :username'; //Aqui declarem la consulta sql i lo dels ":mail..." és per raons de seguretat
                $prepared = $connDB->prepare($sql); //Aqui PREPAREM LA CONSULTA
                $prepared->execute(array(':mail' => $email, ':username' => $username)); //A la hora d'executar la comanda canviarem els valors que previament teniem amb ':username' per el valor que tingui la variable
                if($prepared && $prepared->rowCount()>0){ //La primera part del if es per saber si esta creada i la segona part es per saber si la cantitat de files que ha tornat supera 0
                    $userValid = $prepared->fetch(PDO::FETCH_ASSOC); //Si la consulta sha pogut fer posara un true a dins de la variable $uservalid
                }
            }
            return $userValid;
        
        }catch(PDOException $e){
            echo 'Error amb la BDs: ' . $e->getMessage();
        }
    }


    function userVerifyDB($user, $pass){ //A aquesta funcio li passarem el nom d'usuari i la seva password

        try{
            $userValid = false; //Aqui tornem a posar una variable en false

            $connDB = openDB(); //Aqui tornem a obrir la base de dades
            if(isset($connDB)){ //Tornem a comprovar que la connexio ha estat correcte
                $sql = 'SELECT * FROM `users` WHERE active = 1 AND (mail = :mail OR username = :username)'; //Aqui declarem la consulta sql i lo dels ":mail..." és per raons de seguretat
                $prepared = $connDB->prepare($sql); //Aqui PREPAREM LA CONSULTA
                $prepared->execute(array(':mail' => $user, ':username' => $user)); //A la hora d'executar la comanda canviarem els valors que previament teniem amb ':username' per el valor que tingui la variable

                if($prepared && $prepared->rowCount()>0){ //Tornem a fer la consulta per saber 
                    $result = $prepared->fetch(PDO::FETCH_ASSOC); //Si la consulta sha pogut fer guardara les dades de la consulta a dins de la variable $result
                    if(password_verify($pass,$result['passHash'])) //Comprovarem que la contrasenya que ens ha passat l'alumne es correcte
                    //Per aixo ho farem amb la comanda de password_verify
                    //Estructura de password_verify = password_verify($contrasenyaenclar,$contrasenyadelabasededades)
                    {
                        //I aqui dins agafarem tots els valors i el posarem a dins de la variable userValid
                        $userValid['iduser']           = $result['iduser'];
                        $userValid['mail']             = $result['mail'];
                        $userValid['username']         = $result['username'];
                        $userValid['userFirstName']    = $result['userFirstName'];
                        $userValid['userLastName']     = $result['userLastName'];
                        $userValid['creationDate']     = $result['creationDate'];
                        $userValid['lastSignin']       = $result['lastSignin'];
                    }
                }
            }
            return $userValid;
        }catch(PDOException $e){
            echo 'Error amb la BDs: ' . $e->getMessage();
        }
    }


    function updateSigninDB($iduser){ //Aqui li pasarem la id de usuari
        try{
            $result=false; //Tornem a declarar una variable en false

            $connDB = openDB(); //Tornem a obrir la base de dades
            if(isset($connDB)){ //Si sha pogut fer la connexio a la base de dades entrara aqui
                $sql = 'UPDATE `users` SET lastSignin = CURRENT_TIMESTAMP WHERE (iduser = :iduser)'; //Fem un update a sql per posar la ultima hora que ha fet login aquella persona amb la id com a hora actual
                $prepared = $connDB->prepare($sql); //Tornem a fer un prepare
                $prepared->execute(array(':iduser' => $iduser)); //Tornem  a posar el valor de $iduser a dins de la consulta en el lloc de ':iduser'
            }
            //TODO: per verificar UPDATE ok --> rowcount! //? Aixo no tinc ni idea de si sha de fer
            return $result; //Retornem els resultats
        }catch(PDOException $e){
            echo 'Error amb la BDs: ' . $e->getMessage();
        }
    }


    function newUserDB($user, $mail, $firstname, $lastname, $password){ //Aquesta sera la funcio que executarem quan volguem crear una base de dades
        try{
            $result=false; //Tornem a declarar una variable en false

            $connDB = openDB(); //Tornem a obrir la base de dades
            if(isset($connDB)){ //Si la connexio a la base de dades és succes entrarem aqui dins
                $sql = 'INSERT INTO `users`(`username`,`mail`,`userFirstName`,`userLastName`,`passHash`,`active`) 
                        VALUES (:user,:mail,:fname,:lname,:pass,1)'; //Aqui farem la consulta d'insersio de la base de la persona que s'acaba de registrar
                $result = $connDB->prepare($sql); //Farem el PREPARE de la base de dades
                $result->execute(array( ':user' => $user, ':mail' => $mail,
                                        ':fname' => $firstname, ':lname' => $lastname, 
                                        ':pass' => $password)); //Com sempre a la hora de fer el execute posarem les variables correctes
            }
            return $result;
        }catch(PDOException $e){
            echo 'Error amb la BDs: ' . $e->getMessage();
        }
    }
