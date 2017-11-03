<?php include 'templates/hardline/breadcrumbs.php'; ?>
<div class="col-md-12" style="margin-bottom:15px;">
    
    <div class="main-forum">
       <div class="forum-head-title">
           <div class="viewforumname">forum - <?= $forum->f_forum_name; ?></div>
           <div class="counttopic">Réponses</div> 
           <div class="countreponse">Vue</div>
           <div class="lastmessage">Dernier message</div>  
       </div>
        <?php
        if($get_topics->rowCount()> 0){
        while($topics = $get_topics->fetchObject()):
        
        ?>

        <div class="child forums <?= isset($_SESSION['auth']->id) && !empty($topics->Lastdate < $topics->last) ? '' : 'notread' ; ?>">
           
           <div class="viewforumname">
               <a href="<?= WEBROOT; ?>viewtopic/<?= $topics->topicsid; ?>/<?= $topics->f_topic_slug; ?>"><?= $topics->f_topic_name; ?></a>
               <div class="view-forum-autor">
                   Créer par : <a href="<?= WEBROOT; ?>viewtopic/<?= $topics->topicsid; ?>/<?= $topics->f_topic_slug; ?>"><?= $topics->f_autor_topic; ?></a> le <?= date('d/M/Y à : H:i:s', strtotime($topics->f_topic_date)); ?>
               </div>         
           </div>
           
            <?php $count = CountRep($topics->topicsid); ?>
            <div class="counttopic"><?= $count->countid; ?></div> 
            <div class="countreponse"><?= $topics->f_topic_vu; ?></div>
            
            <div class="lastmessage">
                 <?php
                    $rep = LastTopic($topics->topicsid);
            
                    if($rep != null){

                        echo "Réponse par : <a href='". WEBROOT ."viewtopic/". $topics->topicsid ."/".$topics->f_topic_slug."#". $rep->idrep ."'>".$rep->user_rep ."</a><br />";
                        
                        echo "<a href='". WEBROOT ."viewtopic/". $topics->topicsid ."/".$topics->f_topic_slug."#". $rep->idrep ."'>". date('d/M/Y à H:i:s', strtotime($rep->f_topic_rep_date)) ."</a>";

                    }else{
                        
                        echo 'pas de réponse';
                        
                    }

                ?>
           </div>
           
           
        </div>
        
        <?php endwhile; ?>
       
        <?php if(isset($_SESSION['auth']->id)){ ?> 
        
        <div class="alert alert-success">Vous pouvez maintenant créer un topic</div>
        
        <a class="btn btn-primary" href="<?= WEBROOT; ?>creattopic/<?= $id; ?>">Créer un topic</a>
        
        <?php }else{ ?>

        <div class="alert alert-warning">Il faut être connecter pour créer un topic</div>
    
        <?php } ?>   
        <?php           
            
        }else{
        ?>

        <?php if(isset($_SESSION['auth']->id)){ ?> 
        
        <div class="empty">
           Aucun topic à afficher 
        </div>
        
        <div class="alert alert-success">Vous pouvez maintenant créer un topic</div>
        
        <a class="btn btn-primary" href="<?= WEBROOT; ?>creattopic/<?= $id; ?>">Créer un topic</a>
        
        <?php }else{ ?>
        
        <div class="empty">
           Aucun topic à afficher 
        </div>
                
        <div class="alert alert-warning">Il faut être connecter pour créer un topic</div>
        

        <a href="<?= WEBROOT; ?>login" class="btn btn-warning">Connexion</a>

        <a href="<?= WEBROOT; ?>register" class="btn btn-default">Inscription</a>


        <?php } ?>   
        
        <?php } ?>
    </div>  
</div>
