<div class="col-md-12">
		<!-- news -->
	<div class="news box-shadow">
    <div class="newsTitle text-shadow">
            <h4>Géré les utilisateurs</h4>
    </div>
        
    <div class="newsInfos text-shadow">
           <?php include 'templates/hardline/navigation.php'; ?>
    </div>
    <div class="newsContent text-shadow">
        <div class="the_admin"> 
                    <table style="background-color:#ddd;margin-bottom:0;" class="table table-striped">
					<thead style="background-color: #353535; color: #ddd;">
						<tr>
							<th>Pseudo</th>
							<th>eMail</th>
							<th>Autorisation</th>
							<th>Activation</th>
							<th>slug</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						
						<?php 
                        
                        foreach ($users as $user){ 
                        
                        ?>
						<tr>
							<td><?= $user->username; ?></td>
							<td><?= $user->email; ?></td>
							<td><?= $user->authorization; ?></td>
							<td><?= $user->activation; ?></td>
							<td><?= $user->slug; ?></td>
								<td>
									<?php 
									if($user->activation >= "1"){ ?>
                                        <?php if($user->authorization < 4){ ?>
                                            <a href="<?= WEBROOT; ?>users-delete/<?= $user->id; ?>/<?= csrf(); ?>" style="padding:5px;" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="supprimer l'utilisateur">
                                                <span class="glyphicon glyphicon-ban-circle"></span>
                                            </a>   
                                        <?php } ?>   
                                        
									<?php }else{ ?>
									
									<a href="<?= WEBROOT; ?>users-update/<?= $user->id; ?>/<?= csrf(); ?>" style="padding:5px;" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="Activer l'utilisateur">
									    <span class="glyphicon glyphicon-ok"></span>
									</a>
									
									<?php } ?>
									
									<?php if($user->authorization < 4){ ?>
                           <a href="<?= WEBROOT; ?>users-edit/<?= $user->id; ?>" style="padding:5px;" class="btn btn-warning btn-xs" data-toggle="tooltip" data-placement="top" title="Editer l'utilisateur">
                                   <span class="glyphicon glyphicon-edit"></span>
                           </a>
									<?php } ?>   
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
