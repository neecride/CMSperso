<?php include 'templates/hardline/breadcrumbs.php'; ?>
<div class="col-md-12" style="margin-bottom:15px;">
    <div class="topic-form-main">
      <div class="alert alert-info"><u><?= $rep->user_rep; ?></u> : Vous pouvez maintenant éditez votre réponse</div>
       
        <form method="post">
                <div class="form-group">
                   <?= bootstrapmde('f_topic_content', $Purifier->purify($rep->f_topic_reponse)); ?>
                    <span class="help-block">Votre réponse dois contenir au moins 100 caractères</span>
                </div> 
                 
                <?= csrfInput(); ?>
                <button type="submit" name="topics" class="btn btn-warning">Enregistrer</button>
                <a href="<?= WEBROOT; ?>viewtopic/<?= $rep->repid; ?>/<?= $_GET['slug'] ?><?= isset($_GET['pager']) && !empty($_GET['pager']) ? '/'.$_GET['pager'] : '' ; ?>" class="btn btn-default">Anuler</a>

        </form> 
    </div>
</div>