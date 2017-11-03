<?php include 'templates/hardline/breadcrumbs.php'; ?>
<div class="col-md-12" style="margin-bottom:15px;">
    <div class="main-forum-view-topic">
    <div class="forum-head-title">
        forum - <?= $forumtitle->f_forum_name; ?>
    </div>
        <div id='topic<?= $topic->topicsid; ?>' class="view-topic-info">

            <div class="pull-left">
                Topic : <?= $topic->f_topic_name; ?> 
            
                <?php if(isset($_SESSION['auth']->id) && !empty($_SESSION['auth']->id == $topic->usersid)){//on verifir si c'est bien l'auteur ?>

                - <a href="<?= WEBROOT; ?>editetopic/<?= $topic->topicsid; ?>/<?= $topic->f_topic_slug; ?><?= isset($_GET['pager']) && !empty($_GET['pager']) ? '/'.$_GET['pager'] : '' ; ?>">éditer</a>

                <?php }else if(isset($_SESSION["auth"]->authorization) && !empty($_SESSION["auth"]->authorization == 4)){//sinon si auteur + admin ?>

                - <a href="<?= WEBROOT; ?>editetopic/<?= $topic->topicsid; ?>/<?= $topic->f_topic_slug; ?><?= isset($_GET['pager']) && !empty($_GET['pager']) ? '/'.$_GET['pager'] : '' ; ?>">éditer</a>

                <?php } ?>
            </div>
            <div class="pull-right">
                Poster le - <?= date('d/m/Y à H:i:s', strtotime($topic->f_topic_date));?>
            </div>
        </div>
        
        <div class="child post-topics">
        
            <div class="user-post">
            Auteur - <?= addLink('auteur/'.$topic->username,isset($topic->username) && !empty($topic->username) ? $topic->username : 'userdelete'); ?>
            
            <div style="margin-top:10px; text-align:center;">
                  
                  <?= isset($topic->avatar) && !empty($topic->avatar) ? "<img src='".WEBROOT."inc/img/avatars/".$topic->avatar."' class='img-thumbnail img-circle img-responsive' height='100' width='100' data-original-title='' title='' alt='' />" : "<img src='http://www.gravatar.com/avatar/". md5($topic->email) .".png?size=100&d=&r=G' class='img-thumbnail img-circle img-responsive' height='100' width='100' alt='' />" ; ?>
                  
            </div>
            <?php if($topic->authorization == 4){ ?>
            <div class="author-role-admin">
                <?= role($topic->authorization); ?>
            </div>
            <?php }else{ ?>
            <div class="author-role-member">
                <?= role($topic->authorization); ?>
            </div>
            <?php } ?>
            
            <p><a href="<?= $topic->userurl; ?>" target="_blank">Site web</a></p>
            
            </div>

            <div class="topic-content">
                <?= $Purifier->purify($Parsedown->text($topic->f_topic_content)); ?>
                
                <?php if(isset($topic->description) && !empty($topic->description)){ ?>
                <div class="signon">
                <?= $Purifier->purify($Parsedown->text($topic->description)); ?>  
                </div>
            <?php } ?>
            </div>
        </div>   
    <?php  
    while($reps = $get_reponse->fetchObject()):
    ?>
        <div id="rep<?= $reps->topicsrep; ?>" class="view-topic-info">
            <div class="pull-left">
                    RE : <?= $topic->f_topic_name; ?>   
                    <?php if(isset($_SESSION['auth']->id) && !empty($_SESSION['auth']->id == $reps->usersrep)){ ?>

                       - <a href="<?= WEBROOT; ?>editerep/<?= $reps->topicsrep; ?>/<?= $topic->f_topic_slug; ?><?= isset($_GET['pager']) && !empty($_GET['pager']) ? '/'.$_GET['pager'] : '' ; ?>">éditer</a>

                    <?php }elseif(isset($_SESSION["auth"]->authorization) && !empty($_SESSION["auth"]->authorization == 4)){ ?>

                       - <a href="<?= WEBROOT; ?>editerep/<?= $reps->topicsrep; ?>/<?= $topic->f_topic_slug; ?><?= isset($_GET['pager']) && !empty($_GET['pager']) ? '/'.$_GET['pager'] : '' ; ?>">éditer</a>

                    <?php } ?>
                    
                    
            </div>
            <div class="pull-right">Poster le - <?= date('d/m/Y à H:i:s', strtotime($reps->f_topic_rep_date));?></div>    
            
        </div>       
        
        <div id="<?= $reps->repid; ?>" class="<?= (++$color%2==0 ? $bg1 : $bg2); ?>  post-topics">
           
            <div class="user-post">
                Auteur - <?= addLink('auteur/'.$reps->username,isset($reps->username) && !empty($reps->username) ? $reps->username : 'userdelete'); ?>
                <div style="margin-top:10px; text-align:center;">
                   <?= isset($reps->avatar) && !empty($reps->avatar) ? "<img src='".WEBROOT."inc/img/avatars/".$reps->avatar."' class='img-thumbnail img-circle img-responsive' height='100' width='100' data-original-title='' title='' alt='' />" : "<img src='http://www.gravatar.com/avatar/". md5($reps->email) .".png?size=100&d=&r=G' class='img-thumbnail img-circle img-responsive' height='100' width='100' alt='' />" ; ?>
                </div>
                
                <?php if($reps->authorization == 4){ ?>
                <div class="author-role-admin">
                    <?= role($reps->authorization); ?>
                </div>
                <?php }else{ ?>
                <div class="author-role-member">
                    <?= role($reps->authorization); ?>
                </div>
                <?php } ?>
                
                
                <p><a href="<?= isset($reps->userurl) ? $reps->userurl : WEBROOT ; ?>" target="_blank">Site web</a></p>
            </div>

            <div class="topic-content">
                
                <?= $Purifier->purify($Parsedown->text($reps->f_topic_reponse)); ?>
                
                <?php if(isset($reps->description) && !empty($reps->description)){ ?>
                
                <div class="signon">
                <?= $Purifier->purify($Parsedown->text($reps->description)); ?>   
                </div>
            <?php } ?>
            </div>
        </div>
    <?php endwhile; ?>
    
    </div>
    <?php if(isset($_SESSION['auth']->id)){ ?> 
    <div class="alert alert-success">Vous pouvez maintenant créer une réponse</div>
    <?php paginatNumbers(); ?>
    <div class="topic-form-main">
        <form method="post">
                 
                <div class="form-group">
                   
                    <?= bootstrapmde('f_topic_content'); ?>
                   
                    <p class="help-block">Le méssage ne doit pas être vide !</p>
                </div>
                
                <?= csrfInput(); ?>
                <button type="submit" name="topics" class="btn btn-warning">Enregistrer</button>
                <a href="<?= WEBROOT; ?>forum" class="btn btn-default">Anuler</a>

        </form> 
    </div>
    <?php }else{ ?>
        
        <div class="alert alert-warning">Il faut être connecter pour créer une réponse</div>
        <?php paginatNumbers(); ?>
    <?php } ?>
</div>
