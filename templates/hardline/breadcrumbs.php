<div class="col-md-12">
    <ul style="border-radius:0;" class="breadcrumb">
     
      <li><a href="<?= WEBROOT; ?>forum">Forum</a></li>
      
      <?php 
        if(isset($id,$results->id,$results->f_forum_name)){ ?>
        
        <li><?= $results->f_forum_name; ?></li>
        
      <?php
      }if(isset($id,$forumtitle->id,$forumtitle->f_forum_name) ){ ?>
        
        <li><a href="<?= WEBROOT; ?>viewforums/<?= $forumtitle->id; ?>/<?= $forumtitle->slug; ?>"><?= $forumtitle->f_forum_name; ?></a></li>
       
       <?php }if(isset($_GET['id']) && isset($topic->topicsid) && isset($topic->f_topic_name) ){ ?>
        
        <li><?= $topic->f_topic_name; ?></li> 
        
      <?php } ?>
    </ul>
</div>