<?php include 'templates/hardline/breadcrumbs.php'; ?>
<div class="col-md-12" style="margin-bottom:15px;">
    <div class="topic-form-main">
        <div style="margin-top:20px;" class="alert alert-success">Vous pouvez maintenant créer un topic</div>
       
        <form method="post">

                <div class="form-group">
                   <label for="f_topic_name">Titre du topic</label>
                   <input class="form-control" placeholder="Titre du topic" value="<?= isset($_POST['f_topic_name']) && !empty($_POST['f_topic_name']) ? $_POST['f_topic_name'] : "" ; ?>" id="f_topic_name" type="text" name="f_topic_name" />
                   <span class="help-block">Le titre du topic doit avoir en 6 et 100 caractères</span>
                </div>
                 
                <div class="form-group">
                  
                   <?= bootstrapmde('f_topic_content'); ?>
                   <span class="help-block">Votre topic dois contenir au moins 100 caractères</span>
                </div> 
                 
                <?= csrfInput(); ?>
                <button type="submit" name="topics" class="btn btn-warning">Enregistrer</button>
                <a href="<?= WEBROOT; ?>forum" class="btn btn-default">Anuler</a>

        </form> 
    </div>
</div>