<div class="col-md-12">
	<div class="news box-shadow">
    <div class="newsTitle text-shadow">
            <h4>Géré les catégories des forums</h4>
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
                        <th>Actions</th>

                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $categories = get_f_categories();
                    foreach($categories as $categorie){
                    ?>
                    <tr>

                        <td><?= $categorie->f_cat_name ?></td>
                        <td>
                            <a href="<?= WEBROOT; ?>categories-edit-forums/<?= $categorie->id; ?>" style="padding:5px;" class="btn btn-warning btn-xs" data-toggle="tooltip" data-placement="top" title="Editer catégorie">
                                <span class="glyphicon glyphicon-edit"></span>
                            </a>

                            <a href="<?= WEBROOT; ?>categories-forums-delete/<?= $categorie->id; ?>/<?= csrf(); ?>" style="padding:5px;" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Supprimer catégorie" onclick="return confirm('Sur de sur ?');">
                                <span class="glyphicon glyphicon-ban-circle"></span>
                            </a>

                        </td>

                    </tr>
                    <?php } ?>
                </tbody>

            </table>
              <a class="btn btn-warning" href="<?= WEBROOT; ?>categories-edit-forums">Ajouter une catégorie</a>

              <a class="btn btn-primary" href="<?= WEBROOT; ?>forums">Ajouter un forum</a>

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