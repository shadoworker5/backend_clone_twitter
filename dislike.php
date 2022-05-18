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
        
        $post_id = (int)strip_tags(trim($data_post->post_id));

        $dislike = "UPDATE posts SET dislike_count = dislike_count + 1 WHERE id = '".$post_id."'";
        $query = mysqli_query($base, $dislike);
        
        if($query){
            $result[] = [
                'status' => 'success',
            ];
        }else{
            $result[] = [
                'status' => 'error'
            ];
        }
        echo json_encode($result);
    }