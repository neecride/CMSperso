<?php

$req = $db->prepare("SELECT * FROM f_forums WHERE id = ?");
    
$req->execute([intval($_GET['id'])]);   

$forum = $req->fetch();

if(
    isset($_SESSION['auth']->authorization) && !empty($_SESSION['auth']->authorization < $forum->f_authorization)
    ||
    isset($_SESSION['authorization']) && !empty($_SESSION['authorization'] < $forum->f_authorization)
  ){
    
    setFlash('<strong>Ho ho !</strong> Problème <strong>Vous n\'avez pas le level requis pour cette pages</strong>','rouge');
    redirect('forum');
    
}

if(!empty($forum->id != $_GET['id']) || !empty($forum->slug != $_GET['slug'])){
      
    setFlash('<strong>Ho ho !</strong> Problème <strong>Pas de forum avec cette id/slug </strong>','rouge');
    redirect('forum');
    
}else{
    $id = intval($_GET['id']);
}

/********
* on recupere les topic par forum
*********/

if(isset($_SESSION['auth']->id) && !empty($_SESSION['auth']->id)){
    
    $get_topics = $db->prepare("
                        SELECT 

                            f_topics.id AS topicsid,
                            f_topics.f_topic_content,
                            f_topics.f_topic_name,
                            f_topics.f_topic_slug,
                            f_topics.f_forum_id,
                            f_topics.f_user_id,
                            f_topics.f_topic_date,
                            f_topics.f_topic_vu,
                            f_topics.f_autor_topic,

                            f_topics_reponse.f_topic_rep_date,
                            f_topics_reponse.id AS idrep,
                            f_topics_reponse.user_rep,

                            f_message_view.last,
                            f_message_view.user_id,

                        max(CASE 
                        
                              WHEN f_topics.f_topic_date < f_topics_reponse.f_topic_rep_date THEN f_topics_reponse.f_topic_rep_date
                              
                              WHEN f_topics.f_topic_date > f_topics_reponse.f_topic_rep_date THEN f_topics.f_topic_date

                              ELSE f_topics.f_topic_date

                        END) AS Lastdate

                        FROM f_topics

                        LEFT JOIN f_topics_reponse ON f_topics_reponse.f_topic_id = f_topics.id

                        LEFT JOIN f_message_view ON f_message_view.topic_id = f_topics.id AND f_message_view.user_id = ?

                        WHERE f_topics.f_forum_id = ?

                        GROUP BY f_topics.id

                        ORDER BY Lastdate DESC

                ");

    $user_connect = isset($_SESSION['auth']->id) ? intval($_SESSION['auth']->id) : '';

    $get_topics->execute([$user_connect,$id]);
    
}else{
    
      $get_topics = $db->prepare("
                SELECT 

                    f_topics.id AS topicsid,
                    f_topics.f_topic_content,
                    f_topics.f_topic_name,
                    f_topics.f_topic_slug,
                    f_topics.f_forum_id,
                    f_topics.f_user_id,
                    f_topics.f_topic_date,
                    f_topics.f_topic_vu,
                    f_topics.f_autor_topic,

                    f_topics_reponse.f_topic_rep_date,
                    f_topics_reponse.id AS idrep,
                    f_topics_reponse.user_rep,

                    f_message_view.last,
                    f_message_view.user_id,

                max(CASE 
                        
                      WHEN f_topics.f_topic_date < f_topics_reponse.f_topic_rep_date THEN f_topics_reponse.f_topic_rep_date

                      WHEN f_topics.f_topic_date > f_topics_reponse.f_topic_rep_date THEN f_topics.f_topic_date

                      ELSE f_topics.f_topic_date

                END) AS Lastdate

                FROM f_topics

                LEFT JOIN f_topics_reponse ON f_topics_reponse.f_topic_id = f_topics.id

                LEFT JOIN f_message_view ON f_message_view.topic_id = f_topics.id

                WHERE f_topics.f_forum_id = ?

                GROUP BY f_topics.id

                ORDER BY Lastdate DESC

                ");

    $get_topics->execute([$id]);
    
}


function LastTopic($id){
    global $db;
            
    $rep = $db->prepare("

    SELECT 

    id AS idrep,
    user_rep,
    f_topic_rep_date,
    f_topic_id

    FROM f_topics_reponse 

    WHERE f_topic_id = ?

    ORDER BY f_topic_rep_date

    DESC LIMIT 0,1");

    $rep->execute([$id]);  
    
    $reps = $rep->fetchObject();
    
    return $reps;
}

function CountRep($id){
        global $db;
        $counter = $db->prepare("SELECT COUNT(id) AS countid FROM f_topics_reponse WHERE f_topic_id = ?");
        $counter->execute([$id]);
    
        $count = $counter->fetchObject();
    
        return $count;
}
