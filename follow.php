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
    
    $user_id1 = (int)strip_tags(trim($data_post->user_id1));
    $user_id2 = (int)strip_tags(trim($data_post->user_id2));

    $like = "INSERT INTO relation_ship(user_id1, user_id2, is_follow)  VALUES('".$user_id1."', '".$user_id2."', '1')";
    $query = mysqli_query($base, $like);

    if($query){
        $result[] = [
            'status' => 'success',
        ];
    }else{
        $result[] = [
            'status'    => 'error'
        ];
    }
    echo json_encode($result);
}