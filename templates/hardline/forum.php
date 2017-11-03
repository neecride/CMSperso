<?php include 'templates/hardline/breadcrumbs.php'; ?>
<div class="col-md-12" >
<?php
   if($categories->rowCount() == true){
   while($categorie = $categories->fetchObject()){
   $forum->execute(array($categorie->id)); 
?>
     <div class="main-forum">
      <div class="forum-head-title">
          <div class="forumname"><?= $categorie->f_cat_name ?></div> 
          <div class="countreponse">Réponses</div> 
          <div class="counttopic">Topics</div> 
          <div class="lastmessage">Dernier message</div>  
      </div>    
      
<?php         
      if($forum->rowCount()> 0){
      while($f_forums = $forum->fetchObject()){
?>        
        <div class="child forums">
               
            <div class="forumname">
                <a href="<?= WEBROOT; ?>viewforums/<?= $f_forums->id ?>/<?= $f_forums->slug ?>"><?= $f_forums->f_forum_name; ?></a>
                <div class="description"><?= $f_forums->f_forum_description; ?></div>
            </div>
            
              
              <div class="countreponse"><?= $f_forums->f_count_rep; ?></div> 
              <div class="counttopic"><?= CountTopic($f_forums->id); ?></div> 
              <div class="lastmessage">
                    <?php
                        $topic = LastTopic($f_forums->id);
                        if(!empty($topic != null)){
                            if(!empty($topic->f_topic_date > $topic->f_topic_rep_date)){ // topic

                                echo "<a href='". WEBROOT ."viewtopic/". $topic->id ."/".$topic->f_topic_slug."'>". date('d/M/Y à H:i:s', strtotime($topic->f_topic_date)) ."</a>";   

                                echo "<br /><a href='". WEBROOT ."viewtopic/". $topic->id ."/".$topic->f_topic_slug."'>".$topic->f_autor_topic."</a>";

                            }else{ // reponse

                                echo "<a href='". WEBROOT ."viewtopic/". $topic->id ."/".$topic->f_topic_slug."#". $topic->idrep ."'>". date('d/M/Y à H:i:s', strtotime($topic->f_topic_rep_date)) ."</a>";

                                echo "<br /><a href='". WEBROOT ."viewtopic/". $topic->id ."/".$topic->f_topic_slug."#". $topic->idrep ."'>".$topic->user_rep ."</a>";

                            }
                        }else{
                            
                            echo "pas de topic";
                        
                        }
                    ?>       
              </div>  
            
         </div>  
<?php
      }
    
    }else{
     
?>

       <div class="empty">
            pas de forum dans cette catégorie
        </div>
<?php       
       }
?>
    </div>
<?php
   
   }
}else{
?>
<div class="main-forum">
    <div class="forum-head-title">
          <div class="forumname">Pas de catégorie</div> 
          <div class="countreponse">Réponses</div> 
          <div class="counttopic">Topics</div> 
          <div class="lastmessage">Dernier message</div>  
      </div>   
        <div class="empty">
            Pas de catégorie
        </div>
</div>
<?php
       
   }
?> 
<div class="breadcrumb">
<?php 
    
    echo CountMembers(); 
    echo "<br />";
    echo LastMember(); 
    
?>
</div>

</div>