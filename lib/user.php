<?php  
    require_once(dirname(__FILE__) . '/db.php'); //Aqui farem un require_once //Un require once és que abans d'executar aquest arxiu anira a buscar l'arxiu de db.php

    function checkUser($name, $pass){ //Aquesta és la funcio que comprovara que la persona hagi fet be el login, i rebra dos parametres, el nom i la pass
        $user = userVerifyDB($name, $pass); //Farem la comprovacio de l'usuari

        //Recordem que la variable user si ha introduit les dades correctament, ens retornara una array amb totes les dades de l'usuari o totes les dades que li haguem indicat

        if($user) //Una recomananacio que faig és si un IF no el veus gaire clar, separa per lineas de la manera que tu estiguis correcte
        {
            updateSigninDB($user['iduser']); //Aqui es a on pasarem la id de la persona per fer el update de l'ultima data que sha connectat
        }

        return $user; //I retornarem les dades de la persona si sha trobat i si no tornarem un false
    }

    function checkUserExists($username, $email){
        return checkUserExistsDB($username, $email); //Aqui directament retornem el true o false per saber si el nom d'usuari o el correu de la persona ya estan a dins de la base de dades
    }

    function isPasswordOk($pass,$pass2){ //Aquesta es la funcio que farem per comprovar que la password esta be
        return ($pass==$pass2) && (strlen($pass) >= 8);
        //Aqui estem dient: Si la contrasenya i el verificar contrasenya son el mateix i la longitud de la contrasenya és igual o major a 8 estarà,
        //Si algun daquestes condicions falla, el return sera false
    }

    function registerNewUser($user, $mail, $firstname, $lastname, $password){ //Aquesta es la funcio que ens permet crear un usuari
        $passHash = password_hash($password,PASSWORD_DEFAULT); //Abans de passar la password a la funcio per inserir la base de dades, posarem la contrasenya en un hash que fa servir el php
        $resultOK = newUserDB($user, $mail, $firstname, $lastname, $passHash); //I aqui cridem a la funcio de afegir usuari que aquesta ens retornara un true o un false depenent de si sha pogut afegir o no    
        return $resultOK; //I retornarem el true o false depenent de si sha pogut afegir l'usuari
    }