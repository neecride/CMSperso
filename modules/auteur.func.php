<?php

function auteurPost(){
    
    global $db;
    
    $user_id = isset($_GET['username']) && !empty($_GET['username']) ? $_GET['username'] : '' ;

    $req = $db->prepare("SELECT id, name, writer, posted, slug FROM works WHERE writer = ? AND posted = 1 ORDER BY date DESC LIMIT 0,5");

    $req->execute([$user_id]);
    
    $results = [];
    
    while($rows = $req->fetchObject()){
    
        $results[] = $rows;
        
    }
    
    return $results;
}

function auteurTopic(){
    
    global $db;
    
    $user_id = isset($_GET['username']) && !empty($_GET['username']) ? $_GET['username'] : '' ;

    $req = $db->prepare("
    SELECT 

    id,
    f_topic_name,
    f_topic_slug,
    f_autor_topic

    FROM f_topics

    WHERE f_autor_topic = ?

    ORDER BY f_topic_date ASC LIMIT 0,5
    ");

    $req->execute([$user_id]);
    
    $results = [];
    
    while($rows = $req->fetchObject()){
    
        $results[] = $rows;
        
    }
    
    return $results;
}

function user_account(){

    global $db;

    $user_name = isset($_GET['username']) && !empty($_GET['username']) ? $_GET['username'] : '' ;

    $req = $db->prepare(' SELECT  id, username, email, slug, avatar, description, date_inscription, userurl FROM users WHERE username = ?');

    $req->execute([$user_name]);

    $users = $req->fetchObject();  
    return $users;
}

$auteurtopic = auteurTopic();

$auteurpost = auteurPost();

$user = user_account();

if(isset($_GET['username']) && !empty($_GET['username'] != $user->username) || empty($_GET['username'])){
    
    setFlash('Aucun utilisateurs avec cet username','info');

    redirect('home');
    
}