<?php
is_admin();
/**
* La sauvegarde
**/
if(isset($_POST['forums'])){
    checkCsrf();//on verifie les faille csrf
    $name = strip_tags(trim($_POST['f_forum_name']));
    $slug = slug($name);
    $description = strip_tags($_POST['f_forum_description']);
    $category_id = intval($_POST['f_category_id']);
    $f_authorization = intval($_POST['f_authorization']);
  
    if((strlen($name) < 6 )){
        
        setFlash('<strong>Ho ho !</strong> Le titre n\'est pas valide <strong>doit contenir au moins 6 caractère</strong>','orange');
        if(isset($_GET['id'])){
            
            redirect('forums-edit/' .$_GET['id']);
            
        }else{
            
            redirect('forums-edit');
            
        }
        
        
    }if(!preg_match("#^(1|2|3|4)$#",$f_authorization)){
        
        setFlash('<strong>Ho ho !</strong> Le champ authorization n\'est pas valide <strong> choix possible public ou private</strong>','orange');
        
        if(isset($_GET['id'])){
            
            redirect('forums-edit/' .$_GET['id']);
            
        }else{
            
            redirect('forums-edit');
            
        }
        
    }if((strlen($description) < 6)){
        
        setFlash('<strong>Ho ho !</strong> La description n\'est pas valide <strong>doit contenir au moins 6 caractère</strong>','orange');
        
        if(isset($_GET['id'])){
            
            redirect('forums-edit/' .$_GET['id']);
            
        }else{
            
            redirect('forums-edit');
            
        }
        
        
    }
    /**********
    * sauvegarde forums
    **********/
    if(!empty($_GET['id'])){
            
        $id = intval($_GET['id']);

        $u = [$name ,$slug ,$description, $category_id, $f_authorization,$id];

        $db->prepare("UPDATE f_forums SET f_forum_name = ?, slug = ?, f_forum_description = ?, f_categorie_id = ?, f_authorization = ? WHERE id = ?")->execute($u);
        
        $_GET['id'] = $db->lastInsertId();
        
        setFlash('<strong>Super !</strong> Votre article a bien étais modifier <strong>Bien jouer :)</strong>');

        redirect('forums');


    }else{

        $i = [$name ,$slug,$description, $category_id, $f_authorization];
                
        $db->prepare("INSERT INTO f_forums(f_forum_name, slug, f_forum_description, f_categorie_id, f_authorization) VALUE (?,?,?,?,?)")->execute($i);

        $_GET['id'] = $db->lastInsertId();

        setFlash('<strong>Super !</strong> Votre article a bien étais ajouter <strong>Bien jouer :)</strong>');

        redirect('forums');
    }
    
}
/*********
* supression
***********/
if(isset($_GET['delete'])){
    
    //die('url valide');
    
    checkCsrf();
    
    $id = [intval($_GET['delete'])];
    
    $db->prepare("DELETE FROM f_forums WHERE id = ?")->execute($id);
    
    setFlash('<strong>Super !</strong> Le forum à bien étais supprimer <strong>Bien jouer :)</strong>');
    
    redirect('forums');
    
}
/*********
* on recupere les categories dans un select
**********/
$select = $db->query('

    SELECT 
    id, 
    f_cat_name

    FROM f_categories             

    ORDER BY f_cat_name DESC
            
');
$categories = $select->fetchAll();
if($select->rowcount() == 0){
             
    setFlash('<strong>Ho ho !</strong> un problème est survenue <strong> vous devez créer au moins une catégories pour le forum</strong> ','info');
    redirect('forums');
            
}

/********
* on recupere les entree
*********/
function get_input(){
    
    global $db;
    
    if(!empty($_GET['id'])){
        
        $id = [intval($_GET['id'])];
        
        $req = $db->prepare("
        SELECT 
        id,
        f_forum_name,
        f_authorization,
        f_forum_description,
        f_categorie_id

        FROM f_forums 

        WHERE id = ?
        ");
        $req->execute($id);
    
        $results =  $req->fetchObject();
      
        return $results;       
    
    }
}

$input = get_input();

if(isset($_GET['id']) && !empty($_GET['id'] != $input->id)){

    setFlash('<strong>Ho ho !</strong> un problème est survenue <strong> aucun forum avec cet ID </strong> ','orange');
    redirect('forums');

}
