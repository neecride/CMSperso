<?php if(isset($_SESSION['auth']->authorization) && !empty($_SESSION['auth']->authorization >= 4)){ ?>
<ul id="menu-sidebar-menu" class="menu">
    <li class="<?= ($_GET['page']=='admin')?'sidebarreActive':''; ?>">
        <a href="<?= WEBROOT; ?>admin"><span class="glyphicon glyphicon-dashboard"></span>&nbsp;&nbsp;Accueil admin</a>
    </li>
    <li class="<?= ($_GET['page']=='category')?'sidebarreActive':''; ?>">
        <a href="<?= WEBROOT; ?>category"><span class="glyphicon glyphicon-folder-open"></span>&nbsp;&nbsp;Administré les catégories</a>
    </li>    
       
    <li class="<?= ($_GET['page']=='categories-forums')?'sidebarreActive':''; ?>">
        <a href="<?= WEBROOT; ?>categories-forums"><span class="glyphicon glyphicon-folder-open"></span>&nbsp;&nbsp;Administré les catégories de forums</a>
    </li>
    <li class="<?= ($_GET['page']=='works')?'sidebarreActive':''; ?>">
        <a href="<?= WEBROOT; ?>works"><span class="glyphicon glyphicon-file"></span>&nbsp;&nbsp;Administré les articles</a>
    </li>    
    <li class="<?= ($_GET['page']=='forums')?'sidebarreActive':''; ?>">
        <a href="<?= WEBROOT; ?>forums"><span class="glyphicon glyphicon-file"></span>&nbsp;&nbsp;Administré les forums</a>
    </li>
    <li class="<?= ($_GET['page']=='users')?'sidebarreActive':''; ?>">
        <a href="<?= WEBROOT; ?>users"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;Géré les utilisateurs</a>
    </li>
    <li class="<?= ($_GET['page']=='parameters')?'sidebarreActive':''; ?>">
        <a href="<?= WEBROOT; ?>parameters"><span class="glyphicon glyphicon-wrench"></span>&nbsp;&nbsp;Paramêtres Générals</a>
    </li>
</ul>
<?php } ?>