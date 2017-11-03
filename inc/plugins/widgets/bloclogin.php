<?php if(empty($_SESSION['auth'])){ ?>
   
<div id="blockLogin" class="box-shadow">
    <?= isset($error) ? $error : '' ; ?>
    <div class="blockLogin-title">User Login</div>


        <div class="blockLogin-content">
    <!-- form si on est pas connecter -->
        <div class="blockLogin-content">
             <form method="post" action="<?= WEBROOT?>login">
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
        </div>
        <div class="blockLogin-logout">
            <div class="text-center">
                <a href="<?= WEBROOT ?>register" role="button" class="login-link"><span class="glyphicon glyphicon-log-in" style="width: 1.5em;"></span>&nbsp;Créer un compte</a>
            </div>
        </div>
</div>

<?php }else{ ?>


<div id="blockLogin" class="box-shadow">
	<div class="blockLogin-title">User Login</div>
		<div class="blockLogin-content">
			<div style="font-size: 18px; margin-bottom: 10px;" class="text-center">
                <div class="welcom-user">Bienvenue, <a href="<?= WEBROOT ?>index.php?page=account"><strong><?= users()->username; ?></strong></a></div>
			</div>
			<div class="text-center">
                    <?= isset(users()->avatar) && !empty(users()->avatar) ? "<img src='".WEBROOT."inc/img/avatars/".users()->avatar."' style='margin-bottom: 15px;' class='img-thumbnail img-circle img-responsive' height='100' width='100' data-original-title='' title='' alt='' />" : "<img src='http://www.gravatar.com/avatar/". md5(users()->email) .".png?size=100&d=&r=G' style='margin-bottom: 15px;' class='img-thumbnail img-circle img-responsive' height='100' width='100' alt='' />" ; ?> 
			</div>
	
			<div class="btn-group btn-group-md btn-group-justified">
				
				<a href="<?= WEBROOT ?>account" class="btn btn-add"><span class="glyphicon glyphicon-user"></span></a>
				              
				<?php if(isset($_SESSION['auth']->slug) && !empty($_SESSION['auth']->slug === 'admin')){  ?>				
				    <a href="<?= WEBROOT ?>works" class="btn btn-add"><span class="glyphicon glyphicon-plus"></span></a>
				<?php } ?>
               
                <a href="<?= WEBROOT ?>logout" class="btn btn-add"><span class="glyphicon glyphicon-remove-circle"></span></a>
            </div>
		</div>
        <div class="blockLogin-actions">
			<div class="btn-group btn-group-justified" style="margin-top: 5px;">
				<?php if(isset($_SESSION['auth']->slug) && !empty($_SESSION['auth']->slug === 'admin')){  ?>				
				    <a href="<?= WEBROOT ?>admin" class="btn btn-add"><span class="glyphicon glyphicon-dashboard"></span> Admin</a>
				<?php } ?>
				
				<?php if(isset($_SESSION['auth']->slug) && !empty($_SESSION['auth']->slug === 'admin')){  ?>				
				    <a href="<?= WEBROOT ?>parameters" class="btn btn-add"><span class="glyphicon glyphicon-cog"></span> Params</a>
				<?php } ?>		
		    </div>
		</div>
					
		<div class="blockLogin-logout">
			
		</div>
</div>


<?php } ?>