<div class="col-md-12">
<div class="news box-shadow">

 <div class="newsTitle text-shadow">
     <h4>Bienvenue sur votre profil - <?= $user->username; ?></h4>
    </div>
  <div class="newsAutor">
   <div class="the_profil">
   
       <div class="row userprofile" style="padding:10px 20px;">
            <div class="col-md-6">
                <h4 style="padding-bottom: 15px;">
                       <span class="glyphicon glyphicon-user"></span> A propos de l'utilisateur - desactiver votre compte : <a href="<?= WEBROOT; ?>account-lock/<?= $user->id; ?>/<?= csrf(); ?>" style="padding:5px;" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="désactiver compte" onclick="return confirm('Sur de sur ?');">
                           <span class="glyphicon glyphicon-ban-circle"></span>
                       </a>
                </h4>
                <div class="row">
                    <div class="col-md-4">

                      <?= isset($user->avatar) && !empty($user->avatar) ? "<img src='".WEBROOT."inc/img/avatars/".$user->avatar."' class='img-thumbnail img-responsive'  style='width:80px;' data-original-title='' title='' alt='' />" : "<img src='http://www.gravatar.com/avatar/". md5($user->email) .".png?size=80&d=&r=G' class='img-thumbnail img-responsive' style='width:80px;' data-original-title='' title='' alt='' />" ; ?>     

                    </div>
                    
                    <div class="col-md-8">
                        <p><strong>Votre role sur ce site</strong> : <?= $user->slug; ?></p>
                        <p><strong>Date inscription</strong> : <?= date('d/M/Y', strtotime($user->date_inscription)); ?></p>
                        <p><strong>Site WEB</strong> : <?= $user->userurl; ?></p>
                        <p><strong>Votre eMail</strong> : <?= $user->email; ?></p>  
                        
                        <?php if(isset($user->avatar) && !empty($user->avatar)){ ?>   
                        <form action="" method="post">
                            <?= csrfInput(); ?>
                            <strong>Supprimer votre avatar</strong> : <button type="submit" name="delete_avatar" class="btn btn-xs btn-danger" onclick="return confirm('Sur de sur ?');">X</button>
                        </form> 
                        <?php } ?>
                 
                    </div>
                </div>
            </div>
            <?php if($works != null){ ?>
            <div class="col-md-6">
                <h4 style="padding-bottom: 15px;"><span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;Vos 5 dernier articles</h4>
                <ul class="list-group list-group-item">
                   <?php foreach($works as $work){ ?>
                    <li class="list-group-item">
                        <a href="<?= WEBROOT; ?>post/<?= $work->id; ?>/<?= $work->slug; ?>" rel="author">
                            <?= trunque($work->name, 80); ?>
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
            <?php } ?>
            <div class="col-md-12" style="margin-top:10px;">
                <h6><strong>Votre description</strong> : qui ce vera dans le forum</h6>
                <p>
                <?= $Purifier->purify($Parsedown->text($user->description)); ?>
                </p>	
            </div>
        </div>
   
    </div>
        <div class="newsInfos" style="min-height: 40px;">
            
        </div>
        <div class="newsAutor" style="height:40px;"></div>
  </div>
</div>

<div class="row">

    <div class="col-md-6">
       
        <aside id="recent-comments-2" class="block box-shadow widget_recent_comments">
           <div class="droiteTitre text-shadow">Modifier Email</div>
               <div class="droiteContenu">
                 <form method="post" id="mail" action="">
                    <div class="form-group">
                        <?= newInput('email','eMail',

                            [
                                'type' => 'email',
                                'value' =>  $user->email, 
                                'class' => 'form-control',
                                'id' => 'email',
                                'style' => 'width:100%;',
                                'required' => 'required'
                            ]

                           ); 
                        ?> 
                    </div>
                    <div class="form-group">
                        <?= newInput('email_confirm','eMail confirmation',

                            [
                                'type' => 'email',
                                'value' =>  $user->email, 
                                'class' => 'form-control',
                                'id' => 'email_confirm',
                                'style' => 'width:100%;',
                                'required' => 'required'
                            ]

                           ); 
                        ?>
                        <span class="help-block">Vous pouvez liée votre emil a gravatar pour votre avatar, ou en enoyez un via le formulaire</span>
                    </div>
                    <div class="form-group">
                       <?= newInput('userurl','Votre site web',

                            [
                                'type' => 'text',
                                'value' =>  isset($user->userurl) && !empty($user->userurl) ? $user->userurl : 'http://yoursite.fr' , 
                                'class' => 'form-control',
                                'id' => 'userurl',
                                'style' => 'width:100%;',
                                'required' => 'required'
                            ]

                           ); 
                        ?>
                        <span class="help-block">Ajouter votre adresse web</span>
                     </div>
                     <div class="form-group">
                           
                            <?= bootstrapmde('description', $Purifier->purify($user->description)); ?>
                            
                            <span class="help-block">Votre description ne dois pas dépasser 200 caractères</span>
                     </div>

                    <button type="submit" name="edit-profil" style="width:100%;" class="btn btn-xs btn-primary">Confirmer l'édition de votre profil</button>
                    <?= csrfInput(); ?>
                </form>
               </div>
        </aside>
       
    </div>

    <div class="col-md-6">
        <aside id="recent-comments-2" class="block box-shadow widget_recent_comments">
            <div class="droiteTitre text-shadow">Upload Avatar</div>

            <div class="droiteContenu">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="file" name="avatar">
                    </div>
                    <?= csrfInput(); ?>
                    <button type="submit" name="avatar" style="width:100%;" class="btn btn-xs btn-primary">Confirmer l'envoie de l'avatar</button>
                </form> 
            </div>
        </aside>
    </div>    
    <div class="col-md-6">
       
    <aside id="recent-comments-2" class="block box-shadow widget_recent_comments">
       <div class="droiteTitre text-shadow">Modifier mots de pass (uniquement si vous souhaitez le changer)</div>

           <div class="droiteContenu">
            <form method="post" id="pass" action="">
                <div class="form-group">
                   <?= newInput('password','Mot de pass <span id="passwd"></span>',
                                
                        [
                            'type' => 'password',
                            'placeholder' => 'password',
                            'class' => 'form-control',
                            'id' => 'password',
                            'style' => 'width:100%;',
                            'required' => 'required'
                        ]

                       ); 
                    ?>
                </div>
                
                <div class="form-group">
                   <?= newInput('password_confirm','Mot de pass confirmation <span id="passwdc"></span>',
                                
                        [
                            'type' => 'password',
                            'placeholder' => 'password&nbsp;confirm',
                            'class' => 'form-control',
                            'id' => 'password_confirm',
                            'style' => 'width:100%;',
                            'required' => 'required'
                        ]

                       ); 
                    ?>	
                </div>
                <button type="submit" name="pwd" style="width:100%;" style="width:100%;" class="btn btn-xs btn-primary">Confirmer votre nouveau password</button>
                <?= csrfInput(); ?>
            </form>
           </div>
    </aside>       
    </div>

</div>
    
    
    
</div>