<?php  

is_admin();

function inTable($table){

    global $db;    

    $query = $db->query("SELECT COUNT(id) AS nb FROM $table");
    
    return $nombre = $query->fetch();

}
$tables = ["Publications" => "works", "Les commentaires" => "comments", "Utilisateurs" => "users"];        

function getColor($table,$colors){
    
    if(isset($colors[$table]) ){
        
        return $colors[$table];
        
    }else{
        
        return "orange";
        
    }
    
}

$colors = ["works" => "chocolate", "comments" => "cadetblue", "users" => "crimson"];        

function getGlyphicon($table,$glyphicons){
    
   if(isset($glyphicons[$table]) ){
        
        return $glyphicons[$table];
        
    }else{
        
        return "";
        
    }
    
    
}
$glyphicons = ["works" => "file", "comments" => "th-list", "users" => "user"];    
/*************
* on récupère les catégories
**************/
function inCaTtable(){
        
    global $db;
    
    $req = $db->query("
    
                        SELECT categories.id,
                               categories.cat_name,
                               works.category_id,
                               COUNT(works.category_id) AS nbartid
                        
                        FROM categories 
                        
                        LEFT JOIN works ON categories.id = works.category_id
                        
                        WHERE categories.id 
                        
                        GROUP BY categories.id
                        
                        ORDER BY categories.date DESC
                        
                        
                    ");
    
    $results = [];
    
    while($rows = $req->fetchObject()){
        
        $results[] = $rows;
        
    }
    return $results;   
}
/*************
* on récupère les commentaires
**************/
function get_comments(){
    
    global $db;
    
    $req = $db->query("
                
                SELECT comments.id,
                       comments.username,
                       comments.date,
                       comments.email,
                       comments.post_id,
                       comments.comment,
                       comments.seen,
                       works.name
                
                FROM comments
                
                JOIN works
                
                ON comments.post_id = works.id
                
                WHERE comments.seen = '0'
                
                ORDER BY comments.date DESC
    
    ");
    
    $results = [];
    
    while($rows = $req->fetchAll()){
        
        $results= $rows;
        
    }
    return $results;
    
}
/*********
* activation
***********/
if(isset($_GET['update'])){
    
    //die('success url');
    
    checkCsrf();
    
    $id = intval($_GET['update']);
    
    $db->prepare("UPDATE comments SET seen ='1' WHERE id = ?")->execute([$id]);
    
    setFlash('<strong>Super !</strong> le commentaire a bien étais valider');
    
    redirect('admin');
    
}
/*********
* supression
***********/
if(isset($_GET['delete'])){
    
    //die('success url');
    
    checkCsrf();
    
    $id = intval($_GET['delete']);
    
    $db->prepare("DELETE FROM comments WHERE id = ?")->execute([$id]);
    
    setFlash('<strong>Super !</strong> le commentaire a bien étais supprimer');
    
    redirect('admin');
    
}