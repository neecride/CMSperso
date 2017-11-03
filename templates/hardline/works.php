<div class="col-md-12">
		<!-- news -->
	<div class="news box-shadow">
    <div class="newsTitle text-shadow">
            <h4>Administration article</h4>
    </div>
        
    <div class="newsInfos text-shadow">
       
        <?php include 'templates/hardline/navigation.php'; ?>

    </div>
    <div class="newsContent text-shadow">
        <div class="the_admin"> 
         <table style="background-color:#ddd;" class="table table-striped">
            <thead style="background-color: #353535; color: #ddd;">
                <tr>
                    <th>Id</th>
                    <th>Nom</th>
                    <th>Catégorie</th>
                    <th>Auteur</th>
                    <th>Actions</th>
                    <th>Date création</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $works = get_works();
                foreach($works as $work){
                ?>
                <tr>
                    <td><?= $work->id; ?></td>
                    <td><?= trunque($work->name, 30) ?></td>
                    <td><?= $work->cat_name; ?></td>
                    <td><?= $work->writer ?></td>
                    <td>
                       <?php 
                        if($work->posted == "1"){
                        ?>

                        <a href="<?= WEBROOT; ?>works-backward/<?= $work->id; ?>/<?= csrf(); ?>" style="padding:5px;" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Ne plus mettre en avant">
                            <span class="glyphicon glyphicon-remove"></span>
                        </a>
                         <a href="<?= WEBROOT; ?>post/<?= $work->id; ?>/<?= $work->slug; ?>" style="padding:5px;" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="Voir l'article">
                            <span class="glyphicon glyphicon-eye-open"></span>
                        </a>
                        <?php

                        }else{
                        ?>

                        <a href="<?= WEBROOT; ?>works-forward/<?= $work->id; ?>/<?= csrf(); ?>" style="padding:5px;" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="Mise en avant">
                            <span class="glyphicon glyphicon-ok"></span>
                        </a>

                        <?php 
                        } 
                        ?>
                        <a href="<?= WEBROOT; ?>works-edit/<?= $work->id; ?>" style="padding:5px;" class="btn btn-warning btn-xs" data-toggle="tooltip" data-placement="top" title="Editer l'article">
                            <span class="glyphicon glyphicon-edit"></span>
                        </a>

                        <a href="<?= WEBROOT; ?>works-delete/<?= $work->id; ?>/<?= csrf(); ?>" style="padding:5px;" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Supprimer l'article" onclick="return confirm('Sur de sur ?');">
                            <span class="glyphicon glyphicon-ban-circle"></span>
                        </a>
                    </td>
                    <td><?= date('d/m/Y', strtotime($work->date)); ?></td>
                </tr>
                <?php } ?>
            </tbody>

        </table>
        <a class="btn btn-warning" href="<?= WEBROOT; ?>works-edit">Ajouter un article</a>
        <a class="btn btn-primary" href="<?= WEBROOT; ?>category">Ajouter une catégories</a>

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