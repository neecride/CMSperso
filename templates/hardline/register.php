<div class="col-md-12">
   <aside id="recent-comments-2" class="block box-shadow widget_recent_comments">
           <div class="droiteTitre text-shadow">Inscription</div>
               <div class="droiteContenu">
                 
              <form method="post" action="">
                    <div class="form-group">
                        <?= newInput('username','Choisissez un pseudo <span id="pseudo"></span>', 
                        [
                            'type' => 'text',
                            'class' => 'form-control',
                            'id' => 'username',
                            'style' => 'width:100%;',
                            'placeholder' => 'username',
                            'required' => 'required'
                        ]
                        ); ?>
                    </div>
                    <div class="form-group">
                        <?= newInput('email','Votre email', 
                        [
                            'type' => 'email',
                            'class' => 'form-control',
                            'id' => 'email',
                            'style' => 'width:100%;',
                            'placeholder' => 'email',
                            'required' => 'required'
                        ]
                        ); 
                        ?>
                    </div>
                    <div class="form-group">
                      <?= newInput('password','Taper votre mot de pass <span id="passwd"></span>',
                                
                        [
                            'type' => 'password',
                            'class' => 'form-control',
                            'id' => 'password',
                            'style' => 'width:100%;',
                            'placeholder' => 'password',
                            'required' => 'required'
                        ]

                       ); 
                    ?>
                    </div>
                    
                    <div class="form-group">
                       <?= newInput('password_confirm','Confirmez votre mot de pass <span id="passwdc"></span>',
                                
                        [
                            'type' => 'password',
                            'class' => 'form-control',
                            'id' => 'password_confirm',
                            'style' => 'width:100%;',
                            'placeholder' => 'password&nbsp;confirm',
                            'required' => 'required'
                        ]

                       ); 
                    ?>
                     
                     
                     <?php if(empty($param[7]->param_value)){ ?> 
                      <div class="form-group">
                       <?= newInput('captcha','Confirmer le Captcha',
                                
                        [
                            'type' => 'text',
                            'class' => 'form-control',
                            'style' => 'width:100%;',
                            'placeholder' => 'captcha',
                            'required' => 'required'
                        ]

                       ); 
                        ?> 
                    </div>
                    <?php } ?>
                    </div>
                    <!-- effacer cette ligne si vous souhaiter utiliser le captcha par defaut du site -->
                    <?= isset($param[7]->param_value) && !empty($param[7]->param_value) ? '<div class="g-recaptcha" data-sitekey="' . $param[7]->param_value . '"></div>' : '<img src="'.WEBROOT.'inc/img/captcha.php" alt="">' ?>
                    
                    <button type="submit" class="btn btn-warning">Envoyer</button>
                    &nbsp;<a href="<?= WEBROOT; ?>login">Déjà inscrit</a>
                    <?= csrfInput(); ?>
            </form>

               </div>
        </aside>
</div>
 
