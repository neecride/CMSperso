<?php
is_admin();

/**
* La sauvegarde
**/
if(isset($_POST['category'])){
    checkCsrf();//on verifie les faille csrf
    $cat_name = strip_tags(trim($_POST['f_cat_name']));
    
    if(!empty(strlen($cat_name) > 100 ) || !empty(strlen($cat_name) < 6 )){
        
        setFlash('<strong>Ho ho !</strong> Le nom n\'est pas valide <strong>doit contenir au moins 6 et moins 255 caractère</strong>','orange');
        redirect('categories-forums');
        
    }else{

        if(!empty($_GET['id'])){
            
            $id = intval($_GET['id']);
            
            $u = [$cat_name,$id];
            
            $db->prepare("UPDATE f_categories SET f_cat_name = ? WHERE id = ?")->execute($u);

            setFlash('<strong>Super !</strong> Votre catégorie a bien étais modifier <strong>Bien jouer :)</strong>');
            
            redirect('categories-forums');
            
            
        }else{
            
            $i = [$cat_name];
            
            $db->prepare("INSERT INTO f_categories SET f_cat_name = ? ")->execute($i);

            setFlash('<strong>Super !</strong> Votre catégorie a bien étais ajouter <strong>Bien jouer :)</strong>');
            
            redirect('categories-forums');
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
        
        $req = $db->prepare("SELECT id,f_cat_name FROM f_categories WHERE id = ?");
        
        $req->execute($id);
        
        $results =  $req->fetchObject();
      
        return $results;       
    
    }
}

$input = get_input();

if(isset($_GET['id']) && !empty($_GET['id'] != $input->id)){
             
    setFlash('<strong>Ho ho !</strong> un problème est survenue <strong> aucune catégories avec cet ID </strong> ','orange');
    redirect('categories-forums');
            
}