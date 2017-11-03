<div class="col-md-12">
	<div class="news box-shadow">
    <div class="newsTitle text-shadow">
            <h4>Géré les catégories d'articles</h4>
    </div>
        
    <div class="newsInfos text-shadow">
       
    <?php include 'templates/hardline/navigation.php'; ?>

    </div>
    <div class="newsContent text-shadow">
        <div class="the_admin"> 
       
          <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                   <label for="name">Nom de la catégorie</label>
                   <input class="form-control" placeholder="Nom de la catégorie" id="cat_name" value="<?= isset($input->cat_name) ? $input->cat_name : ''; ?>" type="text" name="cat_name" />
                   <p class="help-block">Plus de 6 cractères requis !</p>
                </div>
                <?= csrfInput(); ?>
                <button type="submit" name="category" class="btn btn-warning">Enregistrer</button>
                <a href="<?= WEBROOT; ?>category" class="btn btn-default">Anuler</a>			

            </form>
                                                                       
                                                                                                                                             
                                                                           
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
