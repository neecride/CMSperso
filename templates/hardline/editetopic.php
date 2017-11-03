<?php include 'templates/hardline/breadcrumbs.php'; ?>
<div class="col-md-12" style="margin-bottom:15px;">  		  
    <div class="topic-form-main">
   
        <div class="alert alert-info"><u><?= $topic->f_autor_topic; ?></u> : Vous pouvez éditez votre topic</div>
       
        <form method="post">
                <div class="form-group">
                   <label for="f_forum_name">Nom du topic</label>
                   <input class="form-control" value="<?= $topic->f_topic_name; ?>" placeholder="<?= $topic->f_topic_name; ?>" id="f_forum_name" type="text" name="f_topic_name" />
                   <span class="help-block">Le titre du topic doit avoir en 6 et 100 caractères</span>
                </div>
    
                <div class="form-group">
                    <?= bootstrapmde('f_topic_content', $Purifier->purify($topic->f_topic_content)); ?>
                    <span class="help-block">Votre topic dois contenir au moins 100 caractères</span>
                </div> 
                 
                <?= csrfInput(); ?>
                <button type="submit" name="topics" class="btn btn-warning">Enregistrer</button>
                <a href="<?= WEBROOT; ?>viewtopic/<?= $firstid ?>/<?= $_GET['slug'] ?><?= isset($_GET['pager']) && !empty($_GET['pager']) ? '/'.$_GET['pager'] : '' ; ?>" class="btn btn-default">Anuler</a>
        </form> 
    </div>
</div>