<?php

is_admin();

/**
* La sauvegarde
**/
if(isset($_POST['category'])){
    checkCsrf();//on verifie les faille csrf
    $cat_name = strip_tags(trim($_POST['cat_name']));
    $slug = slug($cat_name);//slug auto
    
    if(!empty(strlen($cat_name) < 6 )){
        
        setFlash('<strong>Ho ho !</strong> Le nom n\'est pas valide <strong>doit contenir au moins 6 caractère</strong>','orange');
        redirect('category');
        
    }else{

        if(!empty($_GET['id'])){
            
            $id = intval($_GET['id']);
            
            $u = [$slug,$cat_name,$id];
            
            $db->prepare("UPDATE categories SET slug = ?, cat_name = ? WHERE id = ?")->execute($u);

            setFlash('<strong>Super !</strong> Votre catégorie a bien étais modifier <strong>Bien jouer :)</strong>');
            
            redirect('category');
            
            
        }else{
            
            $i = [$slug, $cat_name];
            
            $db->prepare("INSERT INTO categories SET slug = ?, cat_name = ?, date = now()")->execute($i);

            setFlash('<strong>Super !</strong> Votre catégorie a bien étais ajouter <strong>Bien jouer :)</strong>');
            
            redirect('category');
        }
       
    }
}
/********
* on recupere les entree
*********/
function get_input(){
    
    global $db;
    
    if(!empty($_GET['id'])){
        
        $id = [intval($_GET['id'])];
        
        $req = $db->prepare("SELECT id,cat_name FROM categories WHERE id = ?");
        $req->execute($id);
        
        $results =  $req->fetchObject();
      
        return $results;       
    
    }
}
$input = get_input();

if(isset($_GET['id']) && !empty($_GET['id'] != $input->id)){
    setFlash('<strong>Ho ho !</strong> un problème est survenue <strong> aucune catégories avec cet ID </strong> ','orange');
    redirect('category');
}