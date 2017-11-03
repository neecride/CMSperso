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
        
          <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
               <label for="f_forum_name">Nom du forum</label>
               <input class="form-control" placeholder="Nom du forum" id="f_forum_name" value="<?= !empty($input->f_forum_name) ? $input->f_forum_name : ''; ?>" type="text" name="f_forum_name" />
               <p class="help-block">Plus de 6 cractères requis !</p>
            </div>            
              
            <div class="form-group">
               <label for="f_forum_description">Description du forum</label>
               <textarea class="form-control" name="f_forum_description" id="f_forum_description"><?= !empty($input->f_forum_description) ? $input->f_forum_description : ''; ?></textarea>
               <p class="help-block">Plus de 6 cractères requis !</p>
            </div>
            
            <div class="form-group">
                <label for="category_id">Catégorie</label>
                <select class="form-control" id="category_id" name="f_category_id">
                <?php
                foreach($categories as $category){ ?>
                
                    <option value="<?= $category->id ?>" <?= isset($category->id,$input->f_categorie_id) && !empty($category->id == $input->f_categorie_id) ? 'selected' : ''?>><?= $category->f_cat_name ?></option>
                   
                <?php } ?> 
                </select>
            </div> 
               
               
            <div class="form-group">
                <label for="f_authorization">Autorisation</label>
                <select class="form-control" id="f_authorization" name="f_authorization">
                    <option value='1' <?= isset($input->f_authorization) && !empty($input->f_authorization == '1') ? 'selected="selected"' : '' ; ?>>Visiteur</option>
                    <option value='2' <?= isset($input->f_authorization) && !empty($input->f_authorization == '2') ? 'selected="selected"' : '' ; ?>>Membre</option>
                    <option value='3' <?= isset($input->f_authorization) && !empty($input->f_authorization == '3') ? 'selected="selected"' : '' ; ?>>Modo</option>
                    <option value='4' <?= isset($input->f_authorization) && !empty($input->f_authorization == '4') ? 'selected="selected"' : '' ; ?>>Admin</option>
                </select>
            </div>            
            <?php echo csrfInput(); ?>
            
            <?php if(isset($_GET['id'])){ ?>
                <button type="submit" name="forums" class="btn btn-warning">Editer un forum</button>
            <?php   
            }else{  
            ?>
                <button type="submit" name="forums" class="btn btn-warning">Ajouter un forum</button>
            <?php  
            } 
            ?>
            
            <a href="<?= WEBROOT; ?>forums" class="btn btn-default">Anuler</a>			
	  
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