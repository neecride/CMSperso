<?php

is_admin();

/*********
* supression
***********/
if(isset($_GET['delete'])){
    //die('success url');
    checkCsrf();
    
    $id = [intval($_GET['delete'])];
    
    $req = $db->prepare("DELETE FROM categories WHERE id = ?")->execute($id);
    
    setFlash('<strong>Super !</strong> La catégorie à bien étais supprimer <strong>Bien jouer :)</strong>');
    
    redirect('category');
    
}
/**
* affichage des categorie
**/
function get_category(){
    
    global $db;
    
    $req = $db->query("SELECT id, cat_name, slug, date FROM categories ORDER BY id ASC");
    
    $results = [];
    
    while($rows = $req->fetchObject()){
        
        $results[] = $rows;
        
    }
    return $results;   
    
}