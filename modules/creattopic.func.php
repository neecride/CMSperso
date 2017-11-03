<?php
//si on est pas logger
isNot_connect();

if(isset($_GET['id']) && !empty($_GET['id'])){

    $id = [intval($_GET['id'])];

}else{

    setFlash('<strong>Oh oh!</strong> ça ne va pas ! <strong> tu n\'a pas le droit d\'être la</strong>','orange');
    redirect('forum');
}

$req = $db->prepare("SELECT * FROM f_forums WHERE id = ?");
    
$req->execute($id);   

$results = $req->fetch();

if($req->rowcount() == 0){

    setFlash('<strong>Ho ho !</strong> un problème est survenue <strong> aucun forums avec cet ID </strong> ','orange');
    redirect('forum');

} 

/**
* La sauvegarde
**/
if(isset($_POST['topics'])){
    checkCsrf();//on verifie les faille csrf
    $topic_name = strip_tags(trim($_POST['f_topic_name']));
    $topic_slug = slug($topic_name);
    $content = trim($_POST['f_topic_content']);
    $forum_id = intval($_GET['id']);
    $user_id = intval($_SESSION['auth']->id);
    $username = strip_tags($_SESSION['auth']->username);
    $error = '';
    if((strlen($topic_name) < 6) || (strlen($topic_name) > 100)){
        
        $error .= errors(['Le titre du topic doit avoir en 6 et 100 caractères']);
        
    }if(strlen($content) < 100){

        $error .= errors(['Votre topic dois contenir au moins 100 caractères']);

    }else if(empty($error)){

            
            //on insert les donee de f_topics
            $i = [$topic_name, $topic_slug, $user_id, $username ,$content ,$forum_id];
            
            $db->prepare("INSERT INTO f_topics SET f_topic_name = ?, f_topic_slug = ?, f_user_id = ?, f_autor_topic = ?, f_topic_content = ?, f_forum_id = ? , f_topic_date = NOW()")->execute($i);
            
            $lastid = $db->lastInsertId();//redirection ver le topic creer a instant
            
            setFlash('<strong>Super !</strong> Votre topic a bien étais poster <strong>Bien jouer </strong>');
            
            redirect('viewtopic/'.$lastid.'/'.$topic_slug.'#topic'.$lastid);
            
    }
}