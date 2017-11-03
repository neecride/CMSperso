<?php
//si on est pas logger
isNot_connect();

/********
* on recupere les reponse
*********/
$get_reponse = $db->prepare("SELECT id, f_topic_id  AS repid, f_rep_slug, f_topic_reponse, f_user_id, user_rep FROM f_topics_reponse WHERE id = ?");

$get_reponse->execute([intval($_GET['id'])]);

$rep = $get_reponse->fetch();

if(!empty($rep->id != $_GET['id']) || !empty($rep->f_rep_slug != $_GET['slug'])){
      
    setFlash('<strong>Ho ho !</strong> Problème <strong>Pas de réponse avec cette id/slug </strong>','orange');
    redirect('forum');
    
}else{
    $repid = intval($_GET['id']);
}

if($get_reponse->rowcount() == 0){

    setFlash(' <strong>Ho ho !</strong> un problème est survenue <strong> aucunes réponses avec cet ID </strong> ','orange');
    redirect('forum');

} 

if(!empty($_SESSION['auth']->authorization < 4) AND !empty($_SESSION['auth']->id != $rep->f_user_id)){
    setFlash('<strong>Ho ho !</strong> Problème <strong> vous n\'avez pas le bon rang pour editer cette réponse ou cette réponse n\'est pas la votre</strong>','info');
    redirect('forum');
} 

/**
* La sauvegarde
**/
if(isset($_POST['topics'])){
    
    checkCsrf();//on verifie les faille csrf
    $content = trim($_POST['f_topic_content']);
    $error = '';
    $slug  = strip_tags(trim($_GET['slug']));
    if(strlen($content) < 100){

        $error .= errors(['Votre réponse dois contenir au moins 100 caractères']);

    }else if(empty($error)){
           
        $u = [$slug, $content ,$repid];
        
        $uReponse = $db->prepare("UPDATE f_topics_reponse SET f_rep_slug = ?, f_topic_reponse = ? WHERE id = ?");
            
        $uReponse->execute($u);
        
        setFlash('<strong>Super !</strong> Votre message a bien étais modifier <strong>Bien jouer</strong>');
        
        if(!empty($_GET['pager'])){
            redirect('viewtopic/'.$rep->repid.'/'.$_GET['slug'].'/'.$_GET['pager'].'#rep'. $repid);
        }else{
            redirect('viewtopic/'.$rep->repid.'/'.$_GET['slug'].'#rep'. $repid);
        }
        
    }


}