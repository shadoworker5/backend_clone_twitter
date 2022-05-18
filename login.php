<?php
    session_start();

    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Origin, Content-Type, Authorization, Accept, X-Requested-With, x-xsrf-token");
    header("Content-Type: application/json; charset=utf-8");
    
    include "connexion.php";
    
    $data_post = json_decode(file_get_contents('php://input'));
    
    if(!empty($data_post) && isset($data_post)){
        $result = [];
        
        $pseudo = strip_tags(trim($data_post->email));
        $password = strip_tags(trim($data_post->password));

        $query = mysqli_query($base, "SELECT * FROM users WHERE pseudo = '".$pseudo."'");
        $data = mysqli_fetch_array($query);

        if(md5($password) === $data['password'] && !empty($data['password'])){
            $_SESSION['user_id'] = $data['id'];
            $result[] = [
                'user_id'   => $data['id'],
                'name'      => $data['name'],
                'right'     => $data['right_user'],
                'avatar_path' => $data['avatar'] !== null ? "http://127.0.0.1/data/avatar/".$data['avatar'] : "http://127.0.0.1/data/avatar/avatar.png",
                'status'    => true
            ];
        }else{
            $result[] = [
                "erreur" => 'Pseudo/password incorrect. Please try again',
                'status'    => false
            ];
        }
        echo json_encode($result);
    }else{
        if(!isset($_SESSION['user_id'])){
            $result[] = [ 'status'    => false ];
        }else{
            $result[] = [ 'status'    => true];
        }
        echo json_encode($result);
    }