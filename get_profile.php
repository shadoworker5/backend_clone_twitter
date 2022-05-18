<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Origin, Content-Type, Authorization, Accept, X-Requested-With, x-xsrf-token");
header("Content-Type: application/json; charset=utf-8");

include "connexion.php";

$data_post = json_decode(file_get_contents('php://input'));

if(!empty($data_post) && isset($data_post)){
    $result = [];
    
    $user_id = strip_tags(trim($data_post->user_id));

    $query = mysqli_query($base, "SELECT users.id, name, pseudo, email, avatar, COUNT(relation_ship.id) as followers, COUNT(relation_ship.id) as followings
    FROM users, relation_ship WHERE (user_id1 = '".$user_id."' OR user_id2 = '".$user_id."') AND users.id = '".$user_id."' AND is_follow = '1'");
    
    while($data = mysqli_fetch_array($query)){
        $result[] = [
            'name'      => $data['name'],
            'pseudo'    => $data['pseudo'],
            'email'     => $data['email'],
            'followers' => $data['followers'],
            'followings'=> $data['followings'],
            'avatar'    => $data['avatar'] !== null ? "http://127.0.0.1/data/avatar/".$data['avatar'] : "http://127.0.0.1/data/avatar/avatar.png",
        ];
    }
    echo json_encode($result);
}