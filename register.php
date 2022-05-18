<?php

    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Origin, Content-Type, Authorization, Accept, X-Requested-With, x-xsrf-token");
    header("Content-Type: application/json; charset=utf-8");

    include "connexion.php";
    
    // $data_post = json_decode(file_get_contents($_GET['url'])); //'php://input
    if(isset($_POST['name'])){
        $result = [];
        $name = strip_tags($_POST['name']);
        $pseudo = strip_tags($_POST['pseudo']);
        $email = strip_tags($_POST['email']);
        $password = md5(strip_tags($_POST['password']));
        
        $q = "INSERT INTO users(name, pseudo, email, password) VALUES('".$name."', '".$pseudo."', '".$email."', '".$password."')";
        $sql = mysqli_query($base, $q);
        
        $sql ? $result[] = ['status' => true, 'user_id' => mysqli_insert_id($sql)] : $result = ['status' => false];
        echo json_encode($result);
    }else{
        echo json_encode('Not found');
    }