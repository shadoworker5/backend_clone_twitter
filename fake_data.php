<?php
    include "connexion.php";

    function generate_fake_data($longueur = 5){
        $lettre = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $mot = "";
        $taille = strlen($lettre);
        
        for($i=0; $i < $longueur; $i++){
            $mot .= $lettre[rand(0, $taille -1)];
        }
        return $mot;
    }
    
    function create_fake_data(){
        global $base;

        for($i = 0; $i < 20; $i++){
            $name = generate_fake_data();
            $pseudo = generate_fake_data();
            $email = generate_fake_data().'@yahoo.fr';
            $password = md5('qwertyuiop');
            $sql = "INSERT INTO users(name, email, pseudo, password) VALUES('".$name."', '".$email."', '".$pseudo."', '".$password."')";
            mysqli_query($base, $sql) or die(mysqli_errno($base));
        }
    }

    // create_fake_data();