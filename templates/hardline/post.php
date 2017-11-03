<div class="col-md-8">
		<!-- news -->
	<div class="news box-shadow">
    <div class="newsTitle text-shadow">
            <h4><?= trunque($post->name, 80); ?></h4>
    </div>
        <?php if($post->image_name != null){ ?>
         <div class="newsCat">
              <?= addLink('post/'.$post->id .'/'. $post->url ,'<img src="'.WEBROOT.'inc/img/works/'.resizedName($post->image_name, 736,153).'" alt="" />'); ?>          
         </div>
        <?php } ?>
    <div class="newsInfos text-shadow">
       
       <?= isset($post->avatar) && !empty($post->avatar) ? "<img src='".WEBROOT."inc/img/avatars/".$post->avatar."' class='avatar' height='40' width='40' data-original-title='' title='' alt='' />" : "<img src='http://www.gravatar.com/avatar/". md5($post->email) .".png?size=40&d=&r=G' class='avatar' height='40' width='40' data-original-title='' title='' alt='' />" ; ?>&nbsp;&nbsp;&nbsp;<span>Rédigé par : <strong><?= $post->writer; ?></strong> 
       <?= isset($_SESSION['auth']->authorization) && !empty($_SESSION['auth']->authorization == 4) ? addLink('works-edit/'.$post->id,"<strong> Editer l'artcle</strong>") : ""; ?>	
       </span>			
        <div class="right hidden-xs">
			Posté le&nbsp;:&nbsp;<?= date('d/M/Y', strtotime($post->date));?>				
		</div>
    </div>
    <div class="newsContent text-shadow">
        <div class="the_content">
            <?= $Purifier->purify($Parsedown->text($post->content)); ?>
            <div class="HR"></div>
            
            <div class="likes">
                <?= !empty($_SESSION['auth']->id) ? addLink('likes/'.$_GET['id'].'/'.$_GET['slug'].'/1/'.csrf(),"<span style='color:green;' class='glyphicon glyphicon-thumbs-up'></span>") : '' ; ?> Nombre de like (<?= $likes ?>)&nbsp;
                <?= !empty($_SESSION['auth']->id) ? addLink('likes/'.$_GET['id'].'/'.$_GET['slug'].'/2/'.csrf(),"<span style='color:red;' class='glyphicon glyphicon-thumbs-down'></span>") : '' ; ?> Nombre de dislikes(<?= $dislikes ?>)
            </div>
        </div>
            <div class="newsNextPrev">
                <div class="">
                    Catégorie&nbsp;|&nbsp;<?= $post->cat_name;  ?>&nbsp;|&nbsp;<?= "commentaires <span class='badge pull-right'>" . $post->nbcoms . "</span>"; ?>
                </div>
             </div>
            <div class="newsAutor">
            <div class="row userprofile" style="padding:10px 20px;">
                <div class="col-md-6">
                    <h4 style="padding-bottom: 15px;"><span class="glyphicon glyphicon-user"></span> A propos de l'auteur</h4>
                    <div class="row">
                        <div class="col-md-4">
                           <?= isset($post->avatar) && !empty($post->avatar) ? "<img src='".WEBROOT."inc/img/avatars/".$post->avatar."' class='avatar' height='80' width='80' data-original-title='' title='' alt='' />" : "<img src='http://www.gravatar.com/avatar/". md5($post->email) .".png?size=80&d=&r=G' class='avatar' height='80' width='80' data-original-title='' title='' alt='' />" ; ?>
                          							
                        </div>
                        <div class="col-md-8">
                            <p style="margin:0;"><strong>Pseudo :</strong> <?= $post->writer; ?></p>
							<p style="margin:0;">
							<strong>Inscrit le :</strong> <?= date('d/M/Y', strtotime($post->date_inscription));?>							
							</p>
							<p style="margin:0;">
							<strong>URL :</strong> <a target="blank" href="<?= $post->userurl; ?>">site web de l'auteur</a>
							</p>
                            <p style="margin:0;"><strong>Rôle :</strong> <?= $post->slug; ?></p>
							
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <h4 style="padding-bottom: 15px;"><span class="glyphicon glyphicon-pencil"></span>&nbsp;Autres actu de l'auteur</h4>
                    <ul class="list-group list-group-item">
						<li class="list-group-item">
							<a href="<?= WEBROOT; ?>auteur/<?= $post->writer; ?>">
								Voir mes autres contribution
							</a>
                        </li>
                    </ul>
                </div>

            </div>
            <div class="newsNextPrev text-shadow" style="font-family: diamanteef-medium; font-size: 25px; color: #DDD; text-align:center;">
                Les dernier commentaires
            </div>
            <div class="comentary-area text-shadow">
		
                <?php
                $responses = get_comments();
                if($responses != false){
                    foreach($responses as $response){
                        $result[$response->id] = $response;
                    }
                    foreach($responses as $k => $response){
                        if($response->parent_id != 0){

                            $result[$response->parent_id]->children[] = $response;
                            unset($responses[$k]);
                        }

                    }
                    foreach($responses as $response){

                        require ('inc/plugins/comment.php');

                    }
                } 
                ?>
                <!-- #comment-## -->
	  
            </div>
		</div> <!--  class row -->
	</div> <!-- class newsAuthor -->
</div> <!-- class newscontent -->
    <!-- comment -->
    <?php if($param[3]->param_activ == 'oui' || isset($_SESSION["auth"]->authorization) && !empty($_SESSION['auth']->authorization == 4)){ ?>

        <?php if(isset($_SESSION["auth"]->activation) && !empty($_SESSION["auth"]->activation >= 1)){ ?> 
            <div class="comment">
                    <div class="newsNextPrev text-shadow" style="font-family: diamanteef-medium; font-size: 25px; color: #DDD; text-align:center;">
                    Laisser un commentaire
                    </div>	
                    <div id="respond" class="comment-respond">		
                         <form class="newsContenu-comentary" style="padding: 10px;" action="" method="post" id="form-comment">
                            <input type="hidden" id="parent_id" name="parent_id" value="0">
                            <?= bootstrapmde('comment'); ?>
                            <?= csrfInput(); ?>
                            <br />
                            <span style="color:#ddd;">Votre commentaire doit avoir au moins 20 caractères et pas plus de 500</span>
                            <br />
                            <br />
                            <button name="commentary" id="commentary" type="submit" class="btn btn-primary">Envoyer</button>
                            <span style="color:#ddd;">&nbsp;<?= isset($_SESSION['commentwin']) && !empty($_SESSION['commentwin'] == 1) ? 'vous pouver encore poster 1 fois ' : '' ; ?>
                            </span>
                         </form>
                    </div><!-- #respond -->
             
            </div>
        <?php }else { echo "<div class='alert alert-warning'> vous devez être inscrit pour poster un commentaire</div>";} ?>

    <?php } else {echo "<div class='alert alert-warning'>Les commentaires sont desactiver</div>";}  ?>
    <!-- comment fin -->
</div>

<section class="col-md-4" role="complementary"><!-- sidebare -->
        <?php widgetSidebar('php'); ?>
</section>   
