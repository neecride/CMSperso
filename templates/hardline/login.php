<div class="col-md-12">
   <aside id="recent-comments-2" class="block box-shadow widget_recent_comments">
           <div class="droiteTitre text-shadow">Connectez vous</div>
               <div class="droiteContenu">
                      <form method="post" action="">
                            <div class="form-group">
                                <?= newInput('username', 'Username/email',
                                    [   
                                        'type'          => 'text',
                                        'style'         => '"width:100%;"',
                                        'class'         => 'username',
                                        'placeholder'   => 'username',
                                        'required'      => 'required',
                                        'autocomplete'  => 'off'
                                    ]); 
                                ?> 
                            </div>
                            <div class="form-group">
                               <?= newInput('password', 'Mot de pass',
                                      [
                                        'type'          => 'password',
                                        'style'         => '"width:100%;"', 
                                        'class'         => 'password', 
                                        'placeholder'   => 'password', 
                                        'required'      => 'required',
                                        'autocomplete'  => 'off'
                                      ]); 
                                ?>
                            </div>
                            <button type="submit" name="login" class="btn btn-warning">Envoyer</button>

                            <a href="<?= WEBROOT; ?>register" class="btn btn-primary">Pas inscrit</a>

                            <a href="<?= WEBROOT ?>remember" title="Lost Password" class="btn btn-default">Pass perdu</a>

                            <div class="form-group checkbox">
                              <label>
                                <input type="checkbox" name="remember" value="1" /> Se souvenir de moi
                              </label>
                            </div>
                            <?= csrfInput(); ?>
                    </form>

               </div>
        </aside>
</div> 
