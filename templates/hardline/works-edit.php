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
                     
   <?php   
        if(!empty($_GET['id'])){
    ?>  
    <div style="margin-bottom:20px; padding:0;" class="col-md-12">
     <?php   
            $images = get_images();
            foreach ($images as $image){
    ?>

        <div  style="padding:0; text-align:center;" class="col-md-2">
            
            <img src="<?= WEBROOT; ?>inc/img/works/<?= $image->name; ?>" height="100" width="100" alt="<?= $image->name; ?>"><br /><br />
            
            <?php if(!empty($input->image_id  != $image->id )){ ?>
            
            <a href="<?= WEBROOT; ?>works-edit-forward/<?= $image->id; ?>/<?= $_GET['id']; ?>/<?= csrf(); ?>" class="btn btn-success btn-xs">
                Mettre à la une
            </a>
            <?php }else{ ?>
            
            <a href="<?= WEBROOT; ?>works-edit-backward/<?= $image->id; ?>/<?= $_GET['id']; ?>/<?= csrf(); ?>" class="btn btn-primary btn-xs">
                Retirer de la une
            </a>
            
            <?php } ?>
            
            <a href="<?= WEBROOT; ?>works-edit-delete/<?= $image->id; ?>/<?= csrf(); ?>" onclick="return confirm('Sur ?');" class="btn btn-warning btn-xs">
                Supprimer
            </a>
        
        </div>

    <?php      
            }
            
    ?>
    </div>
    <?php            
        }
    ?>      
    <h3 style="margin:0px 0 20px 0;">Edition d'articles</h3>
      <form action="" method="post" enctype="multipart/form-data">
            
            <div class="form-group">
               <label for="name">Nom de la réalisation</label>
               <input class="form-control" placeholder="Nom de la réalisation" id="name" value="<?= !empty($input->name) ? $input->name : ''; ?>" type="text" name="name" >
               <p class="help-block">Plus de 6 cractères requis et moins de 100 !</p>
            </div>   
            <div class="form-group">
                <?= bootstrapmde('content', isset($input->content) ? $Purifier->purify($input->content) : '' ); ?>
                <?php if(empty($_GET['id'])){ ?>
                <label class="publish">
                    <input name="publish" value="1" type="checkbox"> Pulié l'article maintenant ?
                </label>
                <?php } ?>
				<span id="help-block"></span> 
            </div>
            
            <div class="form-group">
                <label for="category_id">Catégorie</label>
                <select class="form-control" id="category_id" name="category_id">
                <?php
                foreach($categories as $category){ ?>  
                    
                    <option value="<?= $category->id ?>" <?= isset($input->category_id) && !empty($category->id == $input->category_id) ? 'selected' : '' ; ?>><?= $category->cat_name ?></option>
                    
               <?php } ?> 
                </select>
            </div>
            
            <!-- images -->
            

                <div class="form-group">
                    <input type="file" name="images[]">
                    <input type="file" name="images[]" class="hidden" id="duplicate">
                </div>
                <p>
                    <a href="#" class="btn btn-success" id="duplicatebtn">Ajouter une image</a>
                </p>
         
            
            <?= csrfInput(); ?>
            <button type="submit" name="works" class="btn btn-warning">Enregistrer</button>
            <a href="<?= WEBROOT; ?>works" class="btn btn-default">Anuler</a>			
	  
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