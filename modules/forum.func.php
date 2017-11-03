<?php

$categories = $db->query("SELECT * FROM f_categories ORDER BY id");

$forum = $db->prepare("SELECT * FROM f_forums WHERE f_categorie_id = ? ORDER BY f_forums.ordre ASC");


function CountTopic($forumid){
    global $db;
    
    $nbt = $db->prepare("SELECT id FROM f_topics WHERE f_forum_id = ?");
    
    $nbt->execute([$forumid]);
    return $nbt->rowCount();
}

/*function CountRep($forumid){
    global $db;
    
    $nbt = $db->prepare("SELECT f_rep_topic_nb FROM f_topics WHERE f_forum_id = ?");
    
    $nbt->execute([$forumid]);
    return $nbt->rowCount();
}*/

//affiche le dernier topic créer
function LastTopic($id){
    global $db;
    
    $Tlast = $db->prepare("SELECT 
            f_topics.id, 
            f_topics.f_topic_date, 
            f_topics.f_autor_topic,
            f_topics.f_topic_slug,
            
            f_topics_reponse.id AS idrep,
            f_topics_reponse.user_rep,
            f_topics_reponse.f_topic_rep_date,
            f_topics_reponse.f_topic_id,
            
            CASE 
            
              WHEN f_topics.f_topic_date < f_topics_reponse.f_topic_rep_date THEN f_topics_reponse.f_topic_rep_date
                              
              WHEN f_topics.f_topic_date > f_topics_reponse.f_topic_rep_date THEN f_topics.f_topic_date

              ELSE f_topics.f_topic_date

            END AS Lastdate

            FROM f_topics 
            
            LEFT JOIN f_topics_reponse ON f_topics.id = f_topics_reponse.f_topic_id
            
            WHERE f_forum_id = ? 

            ORDER BY Lastdate 

            DESC LIMIT 0,1");
    
    $Tlast->execute([$id]);
    
    $Tl = $Tlast->fetchObject();
    
    return $Tl;
}
