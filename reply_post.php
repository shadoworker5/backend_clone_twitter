<?php

    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Allow-Methods: GET, POST");
    header("Access-Control-Allow-Headers: Origin, Content-Type, Authorization, Accept, X-Requested-With, x-xsrf-token");
    header("Content-Type: application/json; charset=utf-8");
    
    include "connexion.php";
    
    $data_post = json_decode(file_get_contents('php://input'));
    
    if(!empty($data_post) && isset($data_post)){
        $result = [];
        
        $user_id = strip_tags(trim($data_post->user_id));
        $post_id = strip_tags(trim($data_post->post_id));
        $content = strip_tags(trim($data_post->content));

        $query = mysqli_query($base, "INSERT INTO reply_posts(user_id, post_id, content) VALUES('".$user_id."', '".$post_id."', '".$content."')");

        if($query){
            $result[] = [
                'status' => 'success'
            ];
        }else{
            $result[] = [
                'status' => 'error'
            ];
        }
        echo json_encode($result);
    }