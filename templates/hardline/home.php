<article class="col-md-8">
<div id="infiniteScroll">
<div class="newsTitleVignette text-shadow">
    <h4>Les dernier article</h4>
</div>
<?php

    while($work = $req->fetchObject()){
            if(isset($work->posted) == "1"){
?>
        
<div class="newsVignette paginat box-shadow">
  
   <?= addLink('post/'.$work->id.'/'.$work->slug, !empty($work->image_name) ? '<img src="'.WEBROOT.'inc/img/works/'.$work->image_name. '" alt="" >' : '<img src="'.WEBROOT.'inc/img/works/noimages.jpg" alt="" >' ); ?>
    
   <?= addLink('post/'.$work->id .'/'. $work->slug, "<h3 class='titleVignette'>".trunque($work->name, 35) .'</h3>'); ?>
    <span class="pull-right">LIKES ( <?= likes($work->id) ?> )&nbsp;-&nbsp;DISLIKES ( <?= dislikes($work->id) ?> )</span>              
    <div class="auteurVignette">
        <div class="avatarVignette">
            <?= isset($work->avatar) && !empty($work->avatar) ? "<img src='".WEBROOT."inc/img/avatars/".$work->avatar."' height='40' width='40' data-original-title='' title='' alt='' />" : "<img src='http://www.gravatar.com/avatar/". md5($work->email) .".png?size=40&d=&r=G' class='avatar' height='40' width='40' alt='' />" ; ?>&nbsp;&nbsp;&nbsp;
        </div>  
    
    <span>
        Rédigé par : <strong><?= addLink('auteur/'.$work->username, $work->username); ?></strong>&nbsp;-&nbsp;le&nbsp;:&nbsp;<?= date('d/M/Y', strtotime($work->date));?><span class="pull-right"><?= addLink('post/'.$work->id .'/'. $work->slug,"<strong>Commentaire (". $work->nbcoms .") </strong>"); ?></span>
    </span>
    </div>			                  
               
</div>                  
<?php                
        } 
    }
?>
<?= paginatNumbers(); ?>


</div>

</article>
<section class="col-md-4" role="complementary"><!-- sidebare -->
    <?php widgetSidebar('php'); ?>
</section>
