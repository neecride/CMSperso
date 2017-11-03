<?php
/********
* on recupere le premier topic
*********/
    $firstTopic = $db->prepare("
    SELECT 

        f_topics.id AS topicsid,
        f_topics.f_topic_content,
        f_topics.f_topic_name,
        f_topics.f_topic_slug,
        f_topics.f_forum_id,
        f_topics.f_user_id,
        f_topics.f_topic_date,
        users.id AS usersid,
        users.username,
        users.description,
        users.authorization,
        users.avatar,
        users.email,
        users.slug,
        users.userurl

    FROM f_topics

    LEFT JOIN users ON users.id = f_topics.f_user_id

    WHERE f_topics.id = ?

    ");
    $firstTopic->execute([intval($_GET['id'])]);

    $topic = $firstTopic->fetch();


if(!empty($topic->topicsid != $_GET['id']) || !empty($topic->f_topic_slug != $_GET['slug'])){
     setFlash('<strong>Ho ho !</strong> Problème <strong>aucun topic avec cette id/slug </strong>','orange');
     redirect('forum');
}else{
    $id = intval($_GET['id']);
}

/********
* on recupere les reponse + pagination
*********/

$PagesMax = $param[4]->param_value;

$PagesTotal = $db->prepare('SELECT id FROM f_topics_reponse WHERE f_topic_id = ?');
    
$PagesTotal->execute([$id]);

$Total = $PagesTotal->rowCount();

$PagesTotales = ceil($Total/$PagesMax);

//si id en get
if(isset($_GET['pager']) AND !empty($_GET['pager']) AND $_GET['pager'] > 0 AND $_GET['pager'] <= $PagesTotales) {
    
   $CurrentPage = $_GET['pager'];
    
} else {
   //si id null alors page sera egal 1 
    $CurrentPage = 1;

}

//pagination number link
function paginatNumbers($nb=2){
    
    global $Total, $PagesTotales, $CurrentPage,$PagesMax;
    
    $getid = isset($_GET['id']) ? intval($_GET['id']) : '' ;
    
    if(!empty($Total > $PagesMax)){
    
    echo '<div style="width:100%; overflow:hidden;"><ul style="margin:10px 0 20px 0;" class="pull-right pagination pagination-sm">'; 
    //prev
    if($CurrentPage > "1"){
        
        $prev = $CurrentPage-1;
        echo '<li><a href="'.WEBROOT.'viewtopic/'. $getid .'/'.$_GET['slug'].'/'.$prev.'">Prev</a></li>' ;
        
    }else{
        
         echo '<li class="disabled" /><a>Prev</a></li>';
        
    }
    
    //pagination current
    
        for($i=1; $i <= $PagesTotales; $i++) {
            
            if($i <= $nb || $i > $PagesTotales - $nb ||  ($i > $CurrentPage-$nb && $i < $CurrentPage+$nb)){
                
                if($i == $CurrentPage) {
                    
                    echo '<li class="active"><a>'. $i .'</a></li>';   


                } else {
                    
                    echo '<li><a href="'.WEBROOT.'viewtopic/'. $getid .'/'.$_GET['slug'].'/'.$i.'">'. $i .'</a></li>' ;

                }
                
            }else{
                if($i > $nb && $i < $CurrentPage-$nb){
                    $i = $CurrentPage - $nb;
                }elseif($i >= $CurrentPage + $nb && $i < $PagesTotales-$nb){
                    $i = $PagesTotales - $nb;
                }
                echo '<li><a href="">...</a></li>';
            }
            
        }
    
    
    
    //next last page
    if($CurrentPage != $PagesTotales){
        
        $next = $CurrentPage+1;
        
        echo '<li><a href="'.WEBROOT.'viewtopic/'. $getid .'/'.$_GET['slug'].'/'.$next.'">Next</a></li>' ;
            
    }else{
        
        echo '<li class="disabled" /><a>Next</a></li>';
        
    }
    
    echo '</ul></div>';
    }
}


$StartPager = ($CurrentPage-1)*$PagesMax;

$limited = $StartPager .','. $PagesMax;

$get_reponse = $db->prepare("
SELECT 

    f_topics_reponse.id AS topicsrep,
    f_topics_reponse.f_topic_reponse,
    f_topics_reponse.f_topic_id,
    f_topics_reponse.id AS repid,
    f_topics_reponse.f_user_id,
    f_topics_reponse.f_topic_rep_date,
    users.id AS usersrep,
    users.username,
    users.description,
    users.authorization,
    users.avatar,
    users.email,
    users.slug,
    users.userurl

FROM f_topics_reponse

LEFT JOIN users ON users.id = f_topics_reponse.f_user_id

WHERE f_topics_reponse.f_topic_id = ?

GROUP BY f_topics_reponse.id 

ORDER BY f_topics_reponse.f_topic_rep_date ASC LIMIT $limited

");

$get_reponse->execute([$id]);


//title forum
$forumTitle = $db->prepare("SELECT * FROM f_forums WHERE f_forums.id = ? ");
    
$forumTitle->execute([$topic->f_forum_id]);   

$forumtitle = $forumTitle->fetch();


if(
    isset($_SESSION['auth']->authorization) && !empty($_SESSION['auth']->authorization < $forumtitle->f_authorization)
  ||
    isset($_SESSION['authorization']) && !empty($_SESSION['authorization'] < $forumtitle->f_authorization)
  ){
    
    setFlash('<strong>Ho ho !</strong> Problème <strong>Vous n\'avez pas le level requis pour cette pages</strong>','rouge');
    redirect('forum');
    
}

/**
* La sauvegarde
**/
if(isset($_POST['topics'])){
    checkCsrf();//on verifie les faille csrf
    $id;
    $content = trim($_POST['f_topic_content']);
    $user_id = intval($_SESSION['auth']->id);
    $autor = strip_tags(trim($_SESSION['auth']->username));
    $slug = strip_tags(trim($_GET['slug']));
    $error = '';
    if(strlen($content) < 100){

        $error .= errors(['Votre topic dois contenir au moins 100 caractères']);

    }if(empty($error)){
        
        //on insert une reponse
        $i = [$user_id, $slug, $content, $autor, $id];

        $db->prepare("INSERT INTO f_topics_reponse SET f_user_id = ?, f_rep_slug = ?,f_topic_reponse = ?, user_rep = ?, f_topic_id = ?, f_topic_rep_date = NOW()")->execute($i);
       
        $lastid = $db->lastInsertId();//redirection ver le topic creer a instant
        
        if(isset($id)){
            
            $fid = $forumtitle->id;

            $nbrep = [$fid];

            $db->prepare("UPDATE f_forums SET f_count_rep = f_count_rep + 1 WHERE id = ?")->execute($nbrep);

        }
        
        setFlash('<strong>Super !</strong> Votre réponse a bien étais poster <strong>Bien jouer </strong>');
       
        //faire redirection si on a plusieur page var_dump($_GET['pager']);
        
        if(empty($_GET['pager'])){
            
            redirect('viewtopic/'.$id.'/'.$_GET['slug'].'#rep'.$lastid); 
            
        }else if(!empty($_GET['pager']) > 0){
            
            redirect('viewtopic/'.$id.'/'.$_GET['slug'].'/' . $_GET['pager'] .'#rep'.$lastid); 
            
        }
        
    }

       
}

/**********
* view
***********/
if(isset($_SESSION['auth']) && !empty($_SESSION['auth'])){
    
    $id = intval($_SESSION['auth']->id);
    
    $get = intval($_GET['id']);

    $views = $db->prepare("
    SELECT 
    
    f_message_view.id AS viewid,
    f_message_view.topic_id,
    f_message_view.user_id,
    f_message_view.last,
    
    f_topics.id
    
    FROM f_message_view
    
    LEFT JOIN f_topics ON f_message_view.topic_id = f_topics.id
    
    WHERE f_message_view.user_id = ? AND topic_id = ?
    
    ");

    $views->execute([$id,$get]);
    
    $view = $views->fetch();

    if(
        isset($view->topic_id) && !empty($view->topic_id == $get) 
        && 
        isset($view->user_id) && !empty($view->user_id == $id)
    ){
        
        $u = [$id,$get];
        
        $sql = $db->prepare("UPDATE f_message_view SET last = NOW() WHERE user_id = ? AND topic_id = ? ")->execute($u); 
        
    }else{
        
        $i = [$get,$id];
    
        $sql = $db->prepare("INSERT f_message_view SET topic_id = ?, user_id = ?, last = NOW()")->execute($i);     
        
    }
    
    
}
/**********
* UPDATE count view
***********/
if(isset($_SESSION['auth']) && isset($_GET['id'])){
    $vu = [intval($_GET['id'])];
    
    $sql = $db->prepare("UPDATE f_topics SET f_topic_vu = f_topic_vu + 1 WHERE id = ?")->execute($vu); 
}