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

    // SELECT id as userID, name, pseudo, avatar FROM users
    //             WHERE id != 1 and id NOT IN (SELECT user_id2 FROM relation_ship);

    $query = mysqli_query($base, "SELECT id as userID, name, pseudo, avatar FROM users
            WHERE id != '".$user_id."' AND id NOT IN (SELECT user_id2 FROM relation_ship)");
    
    while($data = mysqli_fetch_array($query)){
        $result[] = [
            'id'        => $data['userID'],
            'name'      => $data['name'],
            'pseudo'    => $data['pseudo'],
            'avatar'    => $data['avatar'] !== null ? "http://127.0.0.1/data/avatar/".$data['avatar'] : "http://127.0.0.1/data/avatar/avatar.png",
        ];
    }
    echo json_encode($result);
}