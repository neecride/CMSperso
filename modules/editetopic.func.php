<?php
//si on est pas logger
isNot_connect();

$firstTopic = $db->prepare("SELECT id, f_topic_content, f_topic_name, f_topic_slug, f_user_id, f_autor_topic FROM f_topics WHERE id = ? ");

$firstTopic->execute([intval($_GET['id'])]);

$topic = $firstTopic->fetch();

if(!empty($topic->id != $_GET['id']) || !empty($topic->f_topic_slug != $_GET['slug'])){
      
    setFlash('<strong>Ho ho !</strong> Problème <strong>Pas de topic avec cette id/slug </strong>','rouge');
    redirect('forum');
    
}else{
    $firstid = intval($_GET['id']);
}

if($firstTopic->rowcount() == 0){
    setFlash('<strong>Ho ho !</strong> un problème est survenue <strong> aucun topics avec cet ID </strong> ','orange');
    redirect('forum');
} 

if(!empty($_SESSION['auth']->authorization < 4) AND !empty($_SESSION['auth']->id != $topic->f_user_id)){
        setFlash('<strong>Ho ho !</strong> Problème <strong> vous n\'avez pas le bon rang pour editer ce topic ou ce topic n\'est pas le votre</strong>','orange');
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
    $error = '';
    if((strlen($topic_name) < 6) || (strlen($topic_name) > 100)){
        
        $error .= errors(['Le titre du topic doit avoir en 6 et 100 caractères']);
        
    }if(strlen($content) < 100){

        $error .= errors(['Votre topic dois contenir au moins 100 caractères']);

    }else if(empty($error)){

        $u = [$topic_name,$topic_slug, $content, $firstid];

        $db->prepare("UPDATE f_topics SET f_topic_name = ?,f_topic_slug = ?, f_topic_content = ? WHERE id = ?")->execute($u);

        setFlash('<strong>Super !</strong> Votre message a bien étais modifier <strong>Bien jouer :)</strong>');
        
        if(!empty($_GET['pager'])){
            redirect('viewtopic/'.$firstid.'/'.$_GET['slug'].'/'. $_GET['pager'] .'#topic'.$firstid);
        }else{
            redirect('viewtopic/'.$firstid.'/'.$_GET['slug'].'#topic'.$firstid);
        }
    
    }


}