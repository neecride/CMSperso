<?php if(($sidebarre->rowCount() >= 1)){ ?>
    <aside id="menu-sidebar-menu-cotainer" class="block box-shadow widget_recent_comments">
       <div class="droiteTitre text-shadow">LES 10 DERNIER TOPICS</div>
          
           <ul id="menu-sidebar-menu" class="menu">
            <?php while($side = $sidebarre->fetchObject()){ ?>
               <?php 
    
                    if
                    (
                        isset($_SESSION['auth']->authorization) && !empty($_SESSION['auth']->authorization >= $side->f_authorization) 
                        || 
                        isset($_SESSION['authorization']) && !empty($_SESSION['authorization'] >= $side->f_authorization)
                    )
                       { 
               ?>
                <li>
                    <?= addLink('viewtopic/'.$side->id.'/'.$side->f_topic_slug , trunque($side->f_topic_name,35).'<span class="label pull-right label-warning">'. date('d/M/Y', strtotime($side->f_topic_date)).'</span>') ?>
                    
                </li>
                <?php } ?>
            <?php } ?>
           </ul>
           
    </aside>
<?php } ?>