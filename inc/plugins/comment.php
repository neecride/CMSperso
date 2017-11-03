<div id="comment-<?= $response->id; ?>" class="comment_content">
    <div class="author_comment_link">
       <?= isset($response->avatar) && !empty($response->avatar) ? "<img src='".WEBROOT."inc/img/avatars/".$response->avatar."' height='18' width='18' data-original-title='' title='' alt='' />" : "<img src='http://www.gravatar.com/avatar/".md5($response->email).".png?size=18&d=&r=G' height='18' width='18' data-original-title='' title='' alt='' />" ; ?>&nbsp;Poster par : <?= $response->username; ?> 
    </div>
    <div class="comment_text">
            <?php if(!empty($response->seen != '0')){ ?>
                <?= $Purifier->purify($Parsedown->text($response->comment)); ?>   

            <?php }else{ //si non valider

                echo "Votre commentaire est en cours d'aprobation !! ";  

            } ?>
    </div>	
    <div class="HR"></div>
    <div class="reply">
        <strong>Poster le</strong> : <?= date('d/M/Y',  strtotime($response->date)); ?> <?= isset($_SESSION["auth"]->authorization) && !empty($response->depth <= 1)? "<button data-id='$response->id' class='rep pull-right btn btn-xs btn-success'>Répondre</button>" : '' ; ?>   
    </div>
    <?php if(isset($_SESSION['auth']->authorization) && !empty($_SESSION['auth']->authorization >= 4) AND $response->parent_id != 0){ ?>
        <a href="<?= WEBROOT ?>post-delchildreen/<?= $post->id ?>/<?= $response->id ?>/<?= csrf(); ?>">Supprimer</a>
    <?php } ?>
</div>

<?php if(isset($response->children)): ?>
    <?php foreach($response->children as $response): ?>
        <div style="margin-left:50px;">
            <?php require 'inc/plugins/comment.php'; ?>
        </div>
    <?php endforeach; ?>

<?php endif; ?>
