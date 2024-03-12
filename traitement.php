<?php

if(isset($_GET["action"])){
    switch($_GET["action"]){
        //ici connexion, mais selon le modele MVC ça ne se passe pas ici
        case "register":

            if($_POST["submit"]){

                $pdo = new PDO("mysql:host=localhost;dbname=session_laure;charset=utf8", "root", "");
    
                //filtrer les champs
                $pseudo= filter_input(INPUT_POST, "pseudo", FILTER_SANITIZE_SPECIAL_CHARS);
                $email= filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS, FILTER_VALIDATE_EMAIL);
                $pass1= filter_input(INPUT_POST, "pass1", FILTER_SANITIZE_SPECIAL_CHARS);
                $pass2= filter_input(INPUT_POST, "pass2", FILTER_SANITIZE_SPECIAL_CHARS);
    
                //on verifie
                if($pseudo && $email && $pass1 && $pass2){
                    $requeteExist = $pdo->prepare("SELECT * FROM user WHERE email = :email");
                    $requeteExist->execute(["email" => $email]);
                    //dans user, resultat de la requete
                    $user = $requeteExist->fetch();
    
                    //si l'utilisateur existe
                    if($user){
                        header("Location: register.php"); exit;
                    } else{
                        //verifier que les 2 mdp sont identiques et longueur>5 (12 recommandation de la cnil)
                        if($pass1 == $pass2 && strlen($pass1 >=5)){
                            $insertUser = $pdo->prepare("INSERT INTO user (pseudo, email, password) VALUES (:pseudo, :email, :password)");
                            $insertUser->execute([
                                "pseudo" => $pseudo,
                                "email" => $email,
                                //hache le mdp
                                "password" => password_hash($pass1, PASSWORD_DEFAULT)
                            ]);
                            header("location: index.php"); exit;
                        } else{
                            //msg : mdp non identiques ou trop courts
                        }
                        
                    }
                } else{
                    //pb de saisi dans les champs
                }
            }

            header("location:register.php"); exit;

         break;
         case "login":
            if($_POST["submit"]){
                $pdo = new PDO("mysql:host=localhost;dbname=session_laure;charset=utf8", "root", "");
    
                //filtrer les champs
                $pseudo= filter_input(INPUT_POST, "pseudo", FILTER_SANITIZE_SPECIAL_CHARS);
                $email= filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS, FILTER_VALIDATE_EMAIL);
                $password= filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
            }

            header("location:login.php"); exit;

         break;
    }
}