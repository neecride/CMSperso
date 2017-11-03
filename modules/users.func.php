<?php
is_admin();

/**
* Users gestion
**/
function get_users(){
    
    global $db;
    $req = $db->query("SELECT * FROM users ORDER BY date_inscription");
    
    $results = [];
    
    while($rows = $req->fetchObject()){
        
        $results[] = $rows;
        
    }
    return $results;   
    
}

$users = get_users();


/*********
* activation
***********/
if(isset($_GET['update'])){
    
    //die('success url');
    
    checkCsrf();
    
    if($users->authorization == 4){
        setFlash('On ne peut pas editer un admin','rouge');

        redirect('users');
           
    }else{
        $id = intval($_GET['update']);

        $u = [$id];

        $req = $db->prepare("UPDATE users SET slug = 'membre', activation = '1', authorization = '2' WHERE id = ?")->execute($u);

        setFlash('<strong>Super !</strong> l\'utilisateur a bien étais activer <strong>Bien jouer :)</strong>');

        redirect('users');
    }
    
}

/*********************
* supprisseion
**********************/

if(isset($_GET['delete'])){
    
    die('Fonction desactivé');
    
    checkCsrf();
    
    if($users->authorization == 4){
        setFlash('On ne peut pas supprimer un admin','rouge');

        redirect('users');

    }else{
        $id = intval($_GET['delete']);

        $u = [$id];

        $req = $db->prepare("DELETE users id = ?")->execute($u);

        setFlash('<strong>Super !</strong> l\'utilisateur a bien étais activer <strong>Bien jouer :)</strong>');

        redirect('users');
    }
}
