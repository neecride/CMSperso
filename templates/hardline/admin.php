<div class="col-md-12">
		<!-- news -->
	<div class="news box-shadow">
    <div class="newsTitle text-shadow">
            <h4>Administration du site</h4>
    </div>
        
    <div class="newsInfos text-shadow">
       
    <?php include 'templates/hardline/navigation.php'; ?>

    </div>
    <div class="newsContent text-shadow">
        <div class="the_admin"> 
        
<?php foreach($tables as $table_name => $table){ ?>    
        <div class="col-md-4">
            <div class="alert" style="overflow:hidden; background-color: <?= getColor($table,$colors); ?> ;" role="alert">
                <div class="pull-right">
                    <p><span style="font-size:30px;" class="glyphicon glyphicon-<?= getGlyphicon($table,$glyphicons); ?>"></span></p>
                </div>
                <div class="pull-left">
                <h5><?= $table_name; ?></h5>
                
                <?php $nombre = inTable($table); ?>
                
                <p><?php echo $nombre->nb; ?></p>
                </div>
            </div>
        </div>
    <?php } ?>
        <div style="width: 100%; height: 118px;"></div>
        <div class="HR"></div>
   
        <h4 style="padding:10px 5px;">Liste des catégories</h4>
        <ul style="padding:10px 5px;" class="list-group">
            <?php
            $cats = inCaTtable();
            foreach($cats as $cat){

            ?>    

                 <li style="background: #353535; color: #ddd; padding: 10px 5px; border: 1px solid #DDD;" class="list-group-item">
                 <?= $cat->cat_name; ?><span style="font-weight:normal; color:#ddd; font-size:14px;" class="badge">Articles dans cette catégorie - <?= $cat->nbartid; ?></span>
                 </li>

            <?php    
            }
            ?>
        </ul>
        <div class="HR"></div>
        <h4 style="padding:10px 5px;">Validation des commentaires</h4>
        <table style="margin-bottom: 0px; background-color:#ddd;" class="table table-striped">
        <thead style="background-color: #353535; color: #ddd;">
            <tr>
                <th>Username</th>
                <th>Dans l'article</th>
                <th>Le commentaire</th>
                <th>Activation</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>

            <?php 

            $comments = get_comments();
            foreach($comments as $comment){

            ?>
            <tr>
                <td><?= $comment->username; ?></td>
                <td><?= $comment->name; ?></td>
                <td><?= trunque($Purifier->purify($Parsedown->text($comment->comment)),50); ?></td>
                <td><?= $comment->seen; ?></td>
                    <td>
                        <?php if($comment->seen == "0"){ ?>

                        <a href="<?= WEBROOT; ?>admin-update/<?= $comment->id; ?>/<?= csrf(); ?>" style="padding:5px;" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="Valider le commentaire">
                            <span class="glyphicon glyphicon-ok"></span>
                        </a>

                        <?php } ?>

                        <!-- Modal -->
                            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                              <div class="modal-dialog" role="document">
                                <div class="panel panel-default">
                                  <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-12">

                                                    <h5>Email utiliser : <?= $comment->email; ?></h5>


                                                    <h5>Username : <?= $comment->username; ?></h5>

                                            </div>   
                                        </div> 
                                         <div class="form-group">
                                            <h4>Contenue du commentaire</h4><hr/>
                                             <?= $Purifier->purify($Parsedown->text($comment->comment)); ?>
                                        </div>

                                        <a href="<?= WEBROOT; ?>admin-update/<?= $comment->id; ?>/<?= csrf(); ?>" style="padding:5px;" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="Valider le commentaire">
                                            <span class="glyphicon glyphicon-ok"></span>
                                        </a>

                                    </div>
                                </div>
                              </div>
                            </div>

                        <button type="button" data-toggle="modal" data-target="#myModal" style="padding:5px;" class="btn btn-primary btn-xs">
                            <span data-toggle="tooltip" data-placement="top" title="Lire le commentaire" class="glyphicon glyphicon-eye-open"></span>
                        </button>

                        <a href="<?= WEBROOT; ?>admin-delete/<?= $comment->id; ?>/<?= csrf(); ?>" style="padding:5px;" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Supprimer le commentaire" onclick="return confirm('Sur de sur ?');">
                            <span class="glyphicon glyphicon-ban-circle"></span>
                        </a>
                    </td>
            </tr>
            <?php } ?>
        </tbody>
        </table>                                     
        </div>
            <div class="newsAutor">
     
            <div class="newsNextPrev text-shadow" style="font-family: diamanteef-medium; font-size: 25px; color: #DDD; text-align:center;">
                
            </div>
            <div class="comentary-area text-shadow">
		
                                <!-- #comment-## -->
	  
            </div>
		</div> <!--  class row -->
	</div> <!-- class newsAuthor -->
</div> <!-- class newscontent -->
	
</div>