<div class="col-md-12">
		<!-- news -->
	<div class="news box-shadow">
    <div class="newsTitle text-shadow">
            <h4>Paramêtre général</h4>
    </div>
        
    <div class="newsInfos text-shadow">
       
    <?php include 'templates/hardline/navigation.php'; ?>

    </div>
    <div class="newsContent text-shadow">
        <div class="the_admin"> 
    <table style="margin-bottom:0; background-color:#ddd;" class="table table-striped">
    <thead style="background-color: #353535; color: #ddd;">
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Valeur</th>
            <th>Fonction</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?= $param[0]->param_id; ?></td>
            <td><?= $param[0]->param_name; ?></td>
            <td>
                <form style="margin:0;" method="post" action="" class="form-inline">
                  <div class="form-group">
                    <input type="text" style="height:24px;" class="form-control input-sm" value="<?= $param[0]->param_value; ?>" placeholder="<?= $param[0]->param_value; ?>" name="slogan">
                  </div>
                  <button type="submit" class="btn btn-primary btn-xs">Editer</button>
                  <?= csrfInput(); ?>
                </form>
            </td>
            <td>Donner un slogan au site ( a-z A-Z 0-9 - ) pas d'accents</td>            
        </tr>        
        <tr>
            <td><?= $param[1]->param_id; ?></td>
            <td><?= $param[1]->param_name; ?></td>
             <td>
                <form style="margin:0;" method="post" action="" class="form-inline">
                  <div class="form-group">
                    <input type="text" style="height:24px;" class="form-control input-sm" value="<?= $param[1]->param_value; ?>" placeholder="<?= $param[1]->param_value; ?>" name="sitename">
                  </div>
                  <button type="submit" class="btn btn-primary btn-xs">Editer</button>
                  <?= csrfInput(); ?>
                 </form>
            
            </td>
            <td>Donner un nom au site ( a-z A-Z 0-9 - ) pas d'accents</td>
        </tr>        
        <tr>
            <td><?= $param[2]->param_id; ?></td>
            <td><?= $param[2]->param_name; ?></td>
             <td>
                <form style="margin:0;" method="post" action="" class="form-inline">
                   <div class="form-group">
                    <select style="height:24px;" id="slug" class="form-control input-sm" name="pager">
                        <option <?= !empty($param[2]->param_value == 3) ? 'selected="selected"' : '' ; ?> value="3">3</option>
                        <option <?= !empty($param[2]->param_value == 5) ? 'selected="selected"' : '' ; ?> value="5">5</option>
                        <option <?= !empty($param[2]->param_value == 10) ? 'selected="selected"' : '' ; ?> value="10">10</option>
                        <option <?= !empty($param[2]->param_value == 15) ? 'selected="selected"' : '' ; ?> value="15">15</option>
                        <option <?= !empty($param[2]->param_value == 20) ? 'selected="selected"' : '' ; ?> value="20">20</option>
                    </select>
                    <?= csrfInput(); ?>
                  </div>
                  <button type="submit" class="btn btn-primary btn-xs">Editer</button>
                </form>
            </td>
            <td>Pagination nombre d'article par page réglage actuel :<strong> <?= $param[2]->param_value; ?></strong></td>
        </tr>
        <tr>
            <td><?= $param[3]->param_id; ?></td>
            <td><?= $param[3]->param_name; ?></td>
             <td>        
               <?php if($param[3]->param_activ == 'oui'){ ?>
                    <a href="<?= WEBROOT; ?>parameters-del/<?= $param[3]->param_id; ?>/<?= csrf(); ?>"  class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Déssactiver les commentaires">
                        <span class="glyphicon glyphicon-edit"></span> Déssactiver les commentaires
                    </a>
                <?php }else{ ?>
                    <a href="<?= WEBROOT; ?>parameters-activ/<?= $param[3]->param_id; ?>/<?= csrf(); ?>"  class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="Activer les commentaires">
                        <span class="glyphicon glyphicon-edit"></span> Activer les commentaires
                    </a>
                <?php } ?>
            </td>
            <td>Activation des commentaire : <strom><?php if($param[3]->param_activ == 'oui'){ echo 'Activer';  }else{ echo 'Desactiver'; } ?></strom></td>
        </tr>   
        
        <tr>
            <td><?= $param[4]->param_id; ?></td>
            <td><?= $param[4]->param_name; ?></td>
             <td>
                <form style="margin:0;" method="post" action="" class="form-inline">
                   <div class="form-group">
                   
                    <select style="height:24px;" id="forumpager" class="form-control input-sm" name="forumpager">
                        <option <?= !empty($param[4]->param_value == 3) ? 'selected="selected"' : '' ; ?> value="3">3</option>
                        <option <?= !empty($param[4]->param_value == 5) ? 'selected="selected"' : '' ; ?> value="5">5</option>
                        <option <?= !empty($param[4]->param_value == 10) ? 'selected="selected"' : '' ; ?> value="10">10</option>
                        <option <?= !empty($param[4]->param_value == 15) ? 'selected="selected"' : '' ; ?> value="15">15</option>
                        <option <?= !empty($param[4]->param_value == 20) ? 'selected="selected"' : '' ; ?> value="20">20</option>
                    </select>
                    <?= csrfInput(); ?>
                  </div>
                  <button type="submit" class="btn btn-primary btn-xs">Editer</button>
                </form>
            </td>
            <td>Pagination nombre de topic par page réglage actuel :<strong> <?= $param[4]->param_value; ?></strong></td>
        </tr>         
           
        <tr>
            <td><?= $param[5]->param_id; ?></td>
            <td><?= $param[5]->param_name; ?></td>
             <td>
                <form style="margin:0;" method="post" action="" class="form-inline">
                   <div class="form-group">
                       <?= newInput('themeforlayout','',

                            [
                                'type' => 'text',
                                'value' =>  $param[5]->param_value, 
                                'style' =>  'height:24px;', 
                                'class' => 'form-control&nbsp;input-sm',
                                'required' => 'required'
                            ]

                           ); 
                        ?>
                    <?= csrfInput(); ?>
                  </div>
                  <button type="submit" class="btn btn-primary btn-xs">Editer</button>
                </form>
            </td>
            <td>Themes actuel :<strong> <?= $param[5]->param_value; ?></strong> ne pas mettre l'extension juste le nom</td>
        </tr>
           
        <tr>
            <td><?= $param[6]->param_id; ?></td>
            <td>ReCaptcha : <?= $param[6]->param_name; ?></td>
             <td>
                <form style="margin:0;" method="post" action="" class="form-inline">
                   <div class="form-group">
                       <?= newInput('secretkey','',

                            [
                                'type' => 'text',
                                'value' =>  !empty($param[6]->param_value) ? $param[6]->param_value : 'Not&nbsp;Key' , 
                                'style' =>  'height:24px;', 
                                'class' => 'form-control&nbsp;input-sm',
                                'required' => 'required'
                            ]

                           ); 
                        ?>
                    <?= csrfInput(); ?>
                  </div>
                  <button type="submit" class="btn btn-primary btn-xs">Editer</button>
                </form>
            </td>
            <td>Clef secret actuel :<strong> <?= $param[6]->param_value; ?></strong></td>
        </tr>       
           
        <tr>
            <td><?= $param[7]->param_id; ?></td>
            <td>ReCaptcha : <?= $param[7]->param_name; ?></td>
             <td>
                <form style="margin:0;" method="post" action="" class="form-inline">
                   <div class="form-group">
                       <?= newInput('publickey','',

                            [
                                'type' => 'text',
                                'value' =>  !empty($param[7]->param_value) ? $param[7]->param_value : 'Not&nbsp;Key' , 
                                'style' =>  'height:24px;', 
                                'class' => 'form-control&nbsp;input-sm',
                                'required' => 'required'
                            ]

                           ); 
                        ?>
                    <?= csrfInput(); ?>
                  </div>
                  <button type="submit" class="btn btn-primary btn-xs">Editer</button>
                </form>
            </td>
            <td>Clef public actuel :<strong> <?= $param[7]->param_value; ?></strong></td>
        </tr>  
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
