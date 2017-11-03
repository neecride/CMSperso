<div class="col-md-12">
	<div class="news box-shadow">
    <div class="newsTitle text-shadow">
            <h4>Géré les forums</h4>
    </div>
        
    <div class="newsInfos text-shadow">
       
    <?php include 'templates/hardline/navigation.php'; ?>

    </div>
    <div class="newsContent text-shadow">
        <div class="the_admin"> 
        <table style="background-color:#ddd;" class="table table-striped">
            <thead style="background-color: #353535; color: #ddd;">
                <tr>
                    <th>Nom</th>
                    <th>Dans la catégorie</th>
                    <th>Description</th>
                    <th>Autorisation</th>
                    <th>Actions</th>

                </tr>
            </thead>
            <tbody>
                <?php 
                foreach($forums as $forum){
                ?>
                <tr>
                    <td><?= $forum->f_forum_name ?></td>
                    <td><?= $forum->f_cat_name ?></td>
                    <td><?= $forum->f_forum_description ?></td>
                    <td><?= $forum->f_authorization ?></td>
                    <td>
                        <a href="<?= WEBROOT; ?>forums-edit/<?= $forum->id; ?>" style="padding:5px;" class="btn btn-warning btn-xs" data-toggle="tooltip" data-placement="top" title="Editer forums">
                            <span class="glyphicon glyphicon-edit"></span>
                        </a>

                        <a href="<?= WEBROOT; ?>forums-edit-delete/<?= $forum->id; ?>/<?= csrf(); ?>" style="padding:5px;" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Supprimer forums" onclick="return confirm('Sur de sur ?');">
                            <span class="glyphicon glyphicon-ban-circle"></span>
                        </a>

                    </td>

                </tr>
                <?php } ?>
            </tbody>

        </table>
            <a class="btn btn-warning" href="<?= WEBROOT; ?>forums-edit">Ajouter un forum</a>
            <a class="btn btn-primary" href="<?= WEBROOT; ?>categories-forums">Ajouter une catégories</a>                                                             
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