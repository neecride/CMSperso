<?php
is_admin();

if(isset($_POST['users']) && isset($_GET['id'])){
    checkCsrf();//on verifie les faille csrf
    $slug = strip_tags($_POST['slug']);
    $activation = intval($_POST['activation']);
    $authorization = intval($_POST['authorization']);
    if(!preg_match("#^(modo|admin|non-actif|membre)$#", $slug)){
        
        setFlash('<strong>Ho ho !</strong> Le role n\'est pas valide <strong> choix possible non-actif,membre,admin,modo </strong> ','orange');
        redirect('users');
        
        
    }if(!preg_match("#^(0|1)$#",$activation)){
        
        setFlash('<strong>Ho ho !</strong> Le champ n\'est pas valide <strong> choix possible 0 ou 1</strong>','orange');
        redirectAdmin('users');
        
    }if(!preg_match("#^(1|2|3|4)$#",$authorization)){
        
        setFlash('<strong>Ho ho !</strong> Le champ n\'est pas valide <strong> choix possible 1,2 ou 3</strong>','orange');
        redirect('users');
        
    }else{
        if(!empty($_GET['id'])){
            
            $id = intval($_GET['id']);
            
            $u = [$slug, $activation, $authorization,$id ];

            $req = $db->prepare("UPDATE users SET slug = ?, activation = ?, authorization = ? WHERE id = ?")->execute($u);

            setFlash('<strong>Super !</strong> Votre utilisateur a bien étais modifier <strong>Bien jouer :)</strong>');
            
            redirect('users');
            
        }
       
    }
}
/********
* on recupere les entree
*********/
function get_input(){
    
    global $db;

    if(!empty($_GET['id'])){
        
        $id = intval($_GET['id']);
        
        $s = [$id];
        
        $req = $db->prepare("SELECT * FROM users WHERE id = ?");
            
        $req->execute($s);
        
        $results =  $req->fetchObject();
      
        return $results;       
    
    }
}
$input = get_input();

if($input->authorization == 4){
    setFlash('On ne peut pas editer un admin','rouge');

    redirect('users');

}

if(isset($_GET['id']) && !empty($_GET['id'] != $input->id) || empty($_GET['id'])){
             
    setFlash('<strong>Ho ho !</strong> un problème est survenue <strong> aucun utilisateurs avec cet ID </strong>','orange');
    redirect('users');
            
}