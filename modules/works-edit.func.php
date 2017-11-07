<?php
is_admin();
/**
* La sauvegarde
**/
if(isset($_POST) && !empty($_POST)){
    
    checkCsrf();//on verifie les faille csrf
    //$slug = strip_tags($_POST['slug']);
    $name = strip_tags(trim($_POST['name']));
    $slug = slug($name);//slug auto
    $content = trim($_POST['content']);
    $writer = strip_tags(trim($_SESSION['auth']->username));
    $user_id = isset($_SESSION['auth']->id) && !empty($_SESSION['auth']->id) ? intval($_SESSION['auth']->id) : '' ;
    $category_id = intval($_POST['category_id']);
  
    $error = '';
    if(isset($_GET['id']) && !empty($_GET['id'])){
        
        if((strlen($name) < 6) || (strlen($name) > 100)){

            $error .= errors("Le titre dois contenire entre 6 et 100 caractères");

        }if(empty($error)){
            
            $id = intval($_GET['id']);

            $u = [$slug, $name , $content, $writer, $category_id, $user_id, $id];

            $db->prepare("UPDATE works SET slug = ?, name = ?, content = ?, writer = ?, category_id = ?, user_id = ? WHERE id = ?")->execute($u);

            $_GET['id'] = $db->lastInsertId();

            /**
            * ENVOIS DES IMAGES
            **/
            $work_id = $id;
            $files = $_FILES['images'];
            $images = array();
            //require '../parts/image.php';

            foreach($files['tmp_name'] as $k => $v){
            $image = array(
            'name' => $files['name'][$k],
            'tmp_name' => $files['tmp_name'][$k]
            );

            $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
            if(in_array($extension, array('jpg','png'))){

                $i = [$work_id];

                $db->prepare("INSERT INTO images SET work_id=?")->execute($i);

                $image_id = $db->lastInsertId();

                $image_name = $image_id . '.' . $extension;
                move_uploaded_file($image['tmp_name'], IMAGES . '/works/' . $image_name);
                resizeImage(IMAGES . '/works/' . $image_name, 736,153);

                $img_name = $image_name;

                $u = [$img_name,$image_id];
                $db->prepare("UPDATE images SET name = ? WHERE id = ? ")->execute($u);
            }
            }//fin image 

            setFlash('<strong>Super !</strong> Votre article a bien étais modifier <strong>Bien jouer :)</strong>');
            redirect('works');
        }
        
    
    }else{
         
        if((strlen($name) < 6) || (strlen($name) > 100)){

            $error .= errors("Le titre dois contenire entre 6 et 100 caractères");

        }if(isset($_POST['publish']) && !empty($_POST['publish'] != preg_match("#^(1)$#", $_POST['publish']))){
            
            $error .= errors(["Vous avez essayez de hack c\'est pas bien"]);
            
        }if(empty($error)){

            if(isset($_POST['publish'])){

                $ins = [$slug, $name , $content, $_POST['publish'], $writer, $category_id, $user_id];
            
                $db->prepare("INSERT INTO works SET slug = ?, name = ?, content = ?, posted = ? , writer = ?, category_id = ?, user_id = ?, date = now()")->execute($ins);
                
            }else{

               $ins = [$slug, $name , $content, $writer, $category_id, $user_id];
            
               $db->prepare("INSERT INTO works SET slug = ?, name = ?, content = ?, writer = ?, category_id = ?, user_id = ?, date = now()")->execute($ins); 
                
            }

            $_GET['id'] = $db->lastInsertId();       

            /**
            * ENVOIS DES IMAGES
            **/
            $work_id = intval($_GET['id']);
            $files = $_FILES['images'];
            $images = array();

            foreach($files['tmp_name'] as $k => $v){
            $image = array(
                'name' => $files['name'][$k],
                'tmp_name' => $files['tmp_name'][$k]
            );

            $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
                if(in_array($extension, array('jpg','png'))){

                    $i = [$work_id];

                    $db->prepare("INSERT INTO images SET work_id=?")->execute($i);

                    $image_id = $db->lastInsertId();

                    $image_name = $image_id . '.' . $extension;
                    move_uploaded_file($image['tmp_name'], IMAGES . '/works/' . $image_name);
                    resizeImage(IMAGES . '/works/' . $image_name, 736,153);

                    $img_name = $image_name;

                    $u = [$img_name,$image_id];
                    $db->prepare("UPDATE images SET name = ? WHERE id = ? ")->execute($u);


                }
            }//fin image 
            
            setFlash('<strong>Super !</strong> Votre article a bien étais ajouter <strong>Bien jouer :)</strong>');
            redirect('works');
            
        }
        
    }

}
/**
* Suppression d'une image
**/
if(isset($_GET['delete-image'])){
    //die('url success);
    checkCsrf();
    $id = intval($_GET['delete-image']);
    
    $select = $db->prepare("SELECT name, work_id FROM images WHERE id = ?");
    $select->execute([$id]);
    
    $image = $select->fetchObject();

    $images=glob(IMAGES . '/works/' . pathinfo($image->name, PATHINFO_FILENAME) . '_*x*.*');

    if(is_array($images)){
        foreach($images as $v){
            unlink($v);
        }
    }
    unlink(IMAGES . '/works/' . $image->name);
    $req = $db->prepare("DELETE FROM images WHERE id = ?");
    $req->execute([$id]);
    setFlash('<strong>Super !</strong> L\'image a bien étais supprimer <strong>Bien jouer :)</strong>','info');
    redirect('works');
}

/**
* Mise en avant d'une image
**/
if(isset($_GET['forward-image'])){
    //die('url success');
    checkCsrf();
    $work_id = intval($_GET['id']);
    
    $image_id = intval($_GET['forward-image']);
    
    $u = [$image_id,$work_id];
    
    $req = $db->prepare("UPDATE works SET image_id=? WHERE id=?");
    
    $req->execute($u);
    
    setFlash('<strong>Super !</strong> L\'image a bien étais mise en avant <strong>Bien jouer :)</strong>');
    redirect('works-edit/'.$_GET['id']);
}
/**
* ne plus mettre a la une
**/
if(isset($_GET['backward-image'])){
    //die('url success');
    checkCsrf();
    $work_id = intval($_GET['id']);
    
    $image_id = intval($_GET['backward-image']);
    
    $u = [$work_id];
    
    $req = $db->prepare("UPDATE works SET image_id= '0' WHERE id=?");
    
    $req->execute($u);
    
    setFlash('<strong>Super !</strong> L\'image a bien étais retirer de la une<strong>Bien jouer :)</strong>','info');
    redirect('works-edit/'.$_GET['id']);
}

/********
* on recupere les entree
*********/
function get_input(){
    
    global $db;
    
    if(!empty($_GET['id'])){
        
        $id = intval($_GET['id']);
        
        $s = [$id];
        
        $req = $db->prepare("SELECT id,name,slug,content,image_id,category_id FROM works WHERE id = ?");
        $req->execute($s);
        if($req->rowcount() == 0){
             
            setFlash('<strong>Ho ho !</strong> un problème est survenue <strong> aucun articles avec cet ID </strong> ','orange');
            redirect('works');
            
        }
        $results = $req->fetchObject();
      
        return $results;       
    
    }
}
$input = get_input();
/*********
* on recupere les images
**********/
function get_images(){
    
    global $db;
    
    $work_id = intval($_GET['id']);
    
    $s = [$work_id];
    
    $req = $db->prepare("SELECT * FROM images WHERE work_id = ?");
    $req->execute($s);
    $results = [];
    
    while($rows = $req->fetchObject()){
        
        $results[] = $rows;
        
    }
    return $results;   
    
}
/*********
* on recupere les categories dans un select
**********/
$select = $db->query('SELECT * FROM categories ORDER BY cat_name DESC');

if($select->rowCount() == 0){
    setFlash('<strong>Ho ho !</strong> un problème est survenue <strong> veulliez créer au moins une catégorie pour les articles</strong> ','info');
    redirect('category-edit');
}

$categories = $select->fetchAll();
