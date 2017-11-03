<?php

is_admin();

/*********
* supression
***********/
if(isset($_GET['delete'])){
    
    //die('success url');
    
    checkCsrf();
    
    $id = [intval($_GET['delete'])];
    
    $req = $db->prepare("DELETE FROM f_categories WHERE id = ?")->execute($id);
    
    setFlash('<strong>Super !</strong> La catégorie à bien étais supprimer <strong>Bien jouer :)</strong>');
    
    redirect('categories-forums');
    
}
/**
* affichage des categorie
**/
function get_f_categories(){
    
    global $db;
    
    $req = $db->query("SELECT id, f_cat_name FROM f_categories ORDER BY id ASC");
    
    $results = [];
    
    while($rows = $req->fetchObject()){
        
        $results[] = $rows;
        
    }
    return $results;   
    
};