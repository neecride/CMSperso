<div class="col-md-12">
      <aside id="recent-comments-2" class="block box-shadow widget_recent_comments">
           <div class="droiteTitre text-shadow">Réinitialiser votre mots de pass</div>
               <div class="droiteContenu">
                <form method="post">
                    <div class="form-group validate">
                        <?= input('email','email','form-control', 'email', '', 'required'); ?>
                        <span class="help-block">Si vous n'avez pas reçu le mail renvoyez ce formulaire</span>
                    </div>
                <button type="submit" name="submit" class="btn btn-warning">Envoyer</button>&nbsp;<a href="<?= WEBROOT; ?>login" class="btn btn-primary">Login</a>
                <?= csrfInput(); ?>
                </form>
 
               </div>
        </aside>
</div>
