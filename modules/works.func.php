<?php
is_admin();
/*********
* activation
***********/
if(isset($_GET['forward'])){
    //die;
    checkCsrf();
    
    $id = intval($_GET['forward']);
    
    $u = [$id];
    
    $req = $db->prepare("UPDATE works SET posted = '1' WHERE id = ?");
    
    $req->execute($u);
    
    setFlash('<strong>Super !</strong> l\'article a bien étais activer <strong>Bien jouer :)</strong>');
    
    redirect('works');
    
}
if(isset($_GET['backward'])){//desactiver
    //die;
    checkCsrf();
    
    $id = intval($_GET['backward']);
    
    $u = [$id];
    
    $req = $db->prepare("UPDATE works SET posted = '0' WHERE id = ?");
    
    $req->execute($u);
    
    setFlash('<strong>Super !</strong> l\'article a bien étais désactiver <strong>Bien jouer :)</strong>');
    
    redirect('works');
    
}
/*********
* supression
***********/
if(isset($_GET['delete'])){
    //die;
    checkCsrf();
    
    $id = [intval($_GET['delete'])];
    
    $select = $db->prepare("SELECT * FROM images WHERE work_id = ?");
    $select->execute($id);
    
    $image = $select->fetchObject();
    
    if($select->rowCount() >= 1){

        //En cas de supression on supprime la total image et commentaire 
        $db->prepare("DELETE FROM images WHERE work_id = ?")->execute($id);

        sleep(2);
    }
    
    
    $comment = $db->prepare("SELECT * FROM comments WHERE post_id = ?");
    $comment->execute($id);
    
    if($comment->rowCount() >= 1){
    
        $db->prepare("DELETE FROM comments WHERE post_id = ?")->execute($id);
    
        sleep(2);
    }
    
    $db->prepare("DELETE FROM works WHERE id = ?")->execute($id);
    
    setFlash('<strong>Super !</strong> Votre article a bien étais supprimer ainsi que les images/commentaire liée <strong>Bien jouer :)</strong>');
    
    redirect('works');
    
}
/**
* affichage des articles
**/
function get_works(){
    
    global $db;
    
    $req = $db->query(" 
    
    SELECT  works.id, 
            works.name, 
            works.slug, 
            works.posted, 
            works.date,
            works.writer,
            users.username,
            categories.cat_name

    FROM works 

    LEFT JOIN users ON works.writer=users.username

    LEFT JOIN categories ON works.category_id=categories.id

    ORDER BY works.date DESC

 ");
    
    $results = [];
    
    while($rows = $req->fetchObject()){
        
        $results[] = $rows;
        
    }
    return $results;   
    
};
