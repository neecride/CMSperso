<?php
// si on a réussit a poster on met une limite avant de reposter après 2 commentaire
if(!empty($_SESSION['commenttime']) && $_SESSION['commenttime'] < time()){
    unset($_SESSION['commentwin']);
    unset($_SESSION['commenttime']);
}
else if(isset($_POST['commentary'])){//on sauvegarde les commentaires
        checkCsrf();//on vérifie tout de meme les failles csrf
        $id = intval($_GET['id']);
        $username = isset($_SESSION['auth']->username) && !empty($_SESSION["auth"]->username) ? $_SESSION["auth"]->username : '' ;
        $email = isset($_SESSION['auth']->email) && !empty($_SESSION["auth"]->email) ? $_SESSION["auth"]->email : '' ;
        $comment = trim($_POST['comment']);
        $error = '';
        
        if(!empty($_SESSION['commentwin']) && $_SESSION['commentwin'] >= 2){
            $error = errors(['Il vous faut attendre '. date('H\hi',$_SESSION['commenttime']) .' pour réessayer']);
        }
        if(empty($username) || !preg_match('/^[a-zA-Z0-9_]+$/', $username)){

            $error .= errors(["Votre username n'est pas valide selement des minuscules/majuscule et underscore (_)"]);

        }if((strlen($username) < 3) || (strlen($username) > 30)){

            $error .= errors(['Le username doit contenir au moins 4 min et 30 max caractères']);

        }if(empty(filter_var($email, FILTER_VALIDATE_EMAIL)) || !filter_var($email, FILTER_VALIDATE_EMAIL)){

            $error .= errors(["Votre email n'est pas valide"]);

        }if(strlen($comment) < 20 || (strlen($comment) > 500)){

            $error .= errors(['Votre commentaire doit avoir au moins 20 caractères et pas plus de 500']);

        }else if(empty($error)){
            
                if(isset($_SESSION["auth"]->authorization) && !empty($_SESSION["auth"]->authorization < 4)){
                    if(empty($_SESSION['commentwin'])){
                        $_SESSION['commentwin'] = 1;
                        $_SESSION['commenttime'] = time()+ 60 * 10;
                    }else{
                        $_SESSION['commentwin']++;
                    }
                }
            
            $parent_id = isset($_POST['parent_id']) ? $_POST['parent_id'] : 0 ;
            
            $depth = 0;
            
            if($parent_id != 0){
                
                $req = $db->prepare('SELECT id, depth FROM comments WHERE id = ?');
                    
                $req->execute([$parent_id]);
            
                $commentary = $req->fetch(); 
                
                
                if($commentary == false){
                    
                    throw new Exception("Ce parent ID n'existe pas");
                    
                }
                $depth = $commentary->depth + 1;
                
            }
            if($depth >= 3){
                
                setFlash('<strong>Oh oh!</strong> Commentaire incorrect ! <strong>Vous ne pouvez pas répondre à une réponse d\'une réponse</strong>','orange');
                redirect('post/'. $id.'/'.$_GET['slug']);
                
            }else{
                
                //si on est admin le commentaire est aciter automatiquement
                $seen = isset($_SESSION["auth"]->authorization) && !empty($_SESSION["auth"]->authorization == 4) ? 1 : 0 ;
                
                $i = [$username,$email,$comment,$id,$parent_id,$depth,$seen];

                $req = $db->prepare('INSERT INTO comments SET username = ? ,email = ? ,comment = ? ,post_id = ? ,parent_id = ? ,depth = ? ,seen = ? ,date = NOW()')->execute($i);
                
                setFlash('<strong>Super !</strong> Votre commentaire a bien étais reçu');
                redirect('post/'. $id.'/'.$_GET['slug']);
                
            }

        }
    
}
function get_post(){//on affiche les articles
    
    global $db;
    
    $id = [intval($_GET['id'])];
    
    $req = $db->prepare("
    
        SELECT  works.id,
                works.name,
                works.writer,
                works.content,
                works.posted,
                works.date,
                works.slug AS url,
                images.name AS image_name,
                categories.cat_name,
                categories.id AS cat_id,
                users.id AS auteur,
                users.username,
                users.userurl,
                users.slug,
                users.date_inscription,
                users.email,
                users.avatar,
                comments.post_id,
                COUNT(post_id) AS nbcoms
                
        FROM works
        
        LEFT JOIN users ON works.user_id = users.id
        
        LEFT JOIN categories ON works.category_id=categories.id
        
        LEFT JOIN comments ON works.id = comments.post_id
        
        LEFT JOIN images ON images.id = works.image_id
        
        WHERE works.id = ?
        
        GROUP BY works.id
                
        "); 
    
    $req->execute($id);
    
    if($req->rowcount() == 0){
        setFlash('<strong>Oh oh!</strong> une erreur c\'est produite <strong> il n\'y a aucun article avec cette id </strong>','orange');
        redirect('home');
    }

    $results = $req->fetchObject();

    return $results;
    
}
$post = get_post();

if(!empty($_GET['id'] != $post->id) || !empty($post->posted) == "0"){ 
    setFlash('<strong>Ho ho !</strong> Problème <strong>le slug n\'est pas valide</strong>','orange');
    redirect('home');
}


$id = [intval($_GET['id'])];
    
function get_comments(){//on afficher les commentaire
    
    global $db;
    
    $id = [intval($_GET['id'])];
    
    $req = $db->prepare("
    SELECT 
    comments.id, 
    comments.username, 
    comments.email, 
    comments.comment, 
    comments.post_id, 
    comments.parent_id, 
    comments.depth, 
    comments.date, 
    comments.seen, 
    users.avatar
    FROM 
    comments 
    LEFT JOIN users ON users.username = comments.username
    
    WHERE post_id = ? 
    
    GROUP BY comments.id
    
    ORDER BY comments.date DESC
    "); 
    
    $req->execute($id);
    
    $results = [];
    
    while($rows = $req->fetchObject()){
    
        $results[] = $rows;
        
    }
    
    return $results;
    
}

/**********
* like dislike
***********/

$likes = $db->prepare('SELECT id FROM likes WHERE id_article = ?');
$likes->execute([$_GET['id']]);
$likes = $likes->rowCount();
$dislikes = $db->prepare('SELECT id FROM dislikes WHERE id_article = ?');
$dislikes->execute([$_GET['id']]);
$dislikes = $dislikes->rowCount();


/*****
*supprimer comment enfant
*****/
if(isset($_GET['delchildreen'])){
    
    checkCsrf();
    
    $id = [intval($_GET['delchildreen'])];
    
    $req = $db->prepare("DELETE FROM comments WHERE id = ?")->execute($id);
    
    setFlash('<strong>Super !</strong> Le commentaire a bien été supprimer <strong>Bien jouer :)</strong>');
    
    redirect('post/'. $_GET['id'] .'/'.$post->url);
    
}