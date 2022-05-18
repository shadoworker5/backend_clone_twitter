<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Origin, Content-Type, Authorization, Accept, X-Requested-With, x-xsrf-token");
header("Content-Type: application/json; charset=utf-8");

include "connexion.php";

$data_post = json_decode(file_get_contents('php://input'));
    
if(!empty($data_post) && isset($data_post)){
    $response = [];    
    
    $user_id = strip_tags(trim($data_post->user_id));
    
    $q = "SELECT posts.id as post_id, user_id, content, posts.created_at, like_count, dislike_count, type_post, users.id, name, pseudo, avatar FROM posts, users WHERE user_id = users.id AND status = '0' AND  users.id = '".$user_id."' ORDER BY posts.created_at DESC";
    $sql = mysqli_query($base, $q);
    
    while($data = mysqli_fetch_array($sql)){
        $response[] = [
            'comment_id'    => $data['post_id'],
            'user_id'       => $data['user_id'],
            'type_post'     => $data['type_post'],
            'synopsis'      => $data['type_post'] === 'comment' ? $data['content'] : ($data['type_post'] === 'video' ? "http://127.0.0.1/data/videos/".$data['content'] : "http://127.0.0.1/data/videos/".$data['content']),
            'created_at'    => $data['created_at'],
            'user_name'     => $data['name'],
            'like'          => $data['like_count'] !== null ? $data['like_count'] : 0,
            'dislike'       => $data['dislike_count'] !== null ? $data['dislike_count'] : 0,
            'user_pseudo'   => $data['pseudo'],
            'avatar'        => $data['avatar'] !== null ? "http://127.0.0.1/data/avatar/".$data['avatar'] : "http://127.0.0.1/data/avatar/avatar.png"
        ];
    }
    echo json_encode($response);
}