<?php
is_admin();
/**
* affichage des forums
**/
function get_forums(){
    
    global $db;
    
    $req = $db->query("
    SELECT 
    f_forums.id, 
    f_forums.f_forum_description, 
    f_forums.f_forum_name,
    f_forums.f_categorie_id,
    f_forums.f_authorization,
    f_categories.f_cat_name
    
    FROM f_forums 
    
    JOIN f_categories ON f_forums.f_categorie_id = f_categories.id
    
    ORDER BY f_forums.id ASC
    ");
    
    $results = [];
    
    while($rows = $req->fetchObject()){
        
        $results[] = $rows;
        
    }
    
    return $results;   
    
}

$forums = get_forums();