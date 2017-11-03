<div class="col-md-12">
	<div class="news box-shadow">
    <div class="newsTitle text-shadow">
            <h4>Administration article</h4>
    </div>
        
    <div class="newsInfos text-shadow">
           <?php include 'templates/hardline/navigation.php'; ?>

    </div>
    <div class="newsContent text-shadow">
        <div class="the_admin"> 
           <h3>Vous êtes sur le point d'éditer ce membre : <?php echo $input->username; ?></h3>

          <form method="post" action="">
            <div class="form-group">

            <select id="authorization" class="form-control" name="authorization">
                    
                    <option <?= !empty($input->authorization == 1) ? 'selected="selected" ' : '' ; ?> value="1">Visiteur</option>
                    <option <?= !empty($input->authorization == 2) ? 'selected="selected" ' : '' ; ?> value="2">Membre</option>             
                    <option <?= !empty($input->authorization == 3) ? 'selected="selected" ' : '' ; ?> value="3">Modo</option>             
                    <option <?= !empty($input->authorization == 4) ? 'selected="selected" ' : '' ; ?> value="4">Admin</option>             

            </select>
                <span>Autorisation | Statut actuel = <span style="color:red;" ><?= $input->authorization; ?></span></span>
            </div>
            
            <div class="form-group">
            <select id="slug" class="form-control" name="slug">

                <option <?= !empty($input->slug == 'admin') ? 'selected="selected"' : '' ; ?> value="admin">admin</option>
                <option <?= !empty($input->slug == 'modo') ? 'selected="selected"' : '' ; ?> value="modo">modo</option>
                <option <?= !empty($input->slug == 'membre') ? 'selected="selected"' : '' ; ?> value="membre">membre</option>
                <option <?= !empty($input->slug == 'non-actif') ? 'selected="selected"' : '' ; ?> value="non-actif">non-actif</option>

            </select>
            <span>Les choix possible non-actif par défaut puis membre, admin ou modo | Statut actuel = <span style="color:red;" ><?= $input->slug; ?></span></span>
            </div>
            
            
            <div class="form-group">

            <select id="activation" class="form-control" name="activation">
                    
                    <option <?= !empty($input->activation == 0) ? 'selected="selected" ' : '' ; ?> value="0">0</option>
                    <option <?= !empty($input->activation == 1) ? 'selected="selected" ' : '' ; ?> value="1">1</option>             

            </select>
                <span>Activation : 0 = non-actif et 1 = actif | Statut actuel = <span style="color:red;" ><?php echo $input->activation; ?></span></span>
            </div>
            <?= csrfInput(); ?>
            <button type="submit" name="users" class="btn btn-warning">Envoyer</button>
            <a href="<?= WEBROOT; ?>users" class="btn btn-default">Anulée</a>
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
