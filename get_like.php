<?php

    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Origin, Content-Type, Authorization, Accept, X-Requested-With, x-xsrf-token");
    header("Content-Type: application/json; charset=utf-8");
    
    include "connexion.php";
    
    $post_like = json_decode(file_get_contents('php://input'));
    
    if(!empty($post_like) && isset($post_like)){
        $result = [];
        
        $post_id = strip_tags(trim($post_like->post_id));

        $query = mysqli_query($base, "SELECT * FROM posts WHERE id = '".$post_id."'");
        $data = mysqli_fetch_array($query);

        while($data = mysqli_fetch_array($sql)){
            $response[] = [
                'post_id'    => $data['id'],
                'like'       => $data['like_count'],
                'dislike'    => $data['dislike_count'],
            ];
        }
        echo json_encode($result);
    }