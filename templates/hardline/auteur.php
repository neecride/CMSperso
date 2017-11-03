<div class="col-md-12">
<div class="news box-shadow">

 <div class="newsTitle text-shadow">
     <h4>Bienvenue sur votre profil de <?= $user->username ?></h4>
    </div>
  <div class="newsAutor">
   <div class="the_profil">
   
       <div class="row userprofile" style="padding:10px 20px;">
            <div class="col-md-6">
                <h4 style="padding-bottom: 15px;">
                       <span class="glyphicon glyphicon-user"></span> A propos de l'auteur 
                </h4>
                <div class="row">
                    <div class="col-md-4">

                            <?= isset($user->avatar) && !empty($user->avatar) ? "<img src='".WEBROOT."inc/img/avatars/".$user->avatar."' class='img-thumbnail img-responsive'  style='width:80px;' data-original-title='' title='' alt='' />" : "<img src='http://www.gravatar.com/avatar/". md5($user->email) .".png?size=80&d=&r=G' class='img-thumbnail img-responsive' style='width:80px;' data-original-title='' title='' alt='' />" ; ?>      

                    </div>
                    
                    <div class="col-md-8">
                        <p><strong>Role sur ce site</strong> : <?= $user->username ?></p>
                        <p><strong>Date inscription</strong> : <?= date('d/M/Y', strtotime($user->date_inscription));?></p>
                        <p><strong>Son site WEB</strong> : <?= $user->userurl ?></p>
                        <p><strong>Son eMail</strong> : <?= $user->email ?></p>                     
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <?php if($auteurpost != null){ ?>
                <h4 style="padding-bottom: 15px;"><span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;Les 5 dernier articles</h4>
                <ul class="list-group list-group-item">
                    <?php foreach($auteurpost as $auteurposts){ ?>
                    <li class="list-group-item">
                        <a href="<?= WEBROOT ?>post/<?= $auteurposts->id ?>/<?= $auteurposts->slug ?> " rel="author">
                            <?= trunque($auteurposts->name, 80); ?>                 
                        </a>
                    </li>
                    <?php } ?>
                </ul>
                <?php } ?>
                <?php if($auteurtopic != null){ ?>
                <br />
                <h4 style="padding-bottom: 15px;"><span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;Les 5 dernier topic</h4>
                <ul class="list-group list-group-item">
                    <?php foreach($auteurtopic as $auteurtopics){ ?>
                    <li class="list-group-item">
                        <a href="<?= WEBROOT ?>viewtopic/<?= $auteurtopics->id ?>/<?= $auteurtopics->f_topic_slug ?> " rel="author">
                            <?= trunque($auteurtopics->f_topic_name, 80); ?>                 
                        </a>
                    </li>
                    <?php } ?>
                </ul>

                <?php } ?>
            </div>            
            
            <div class="col-md-12" style="margin-top:10px;">
                <h6><strong>Sa description</strong> : qui ce vera dans le forum</h6>
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
</div>