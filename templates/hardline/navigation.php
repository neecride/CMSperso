<ul class="navigate">
    <li class="<?= ($page=='admin')?'activeNavigate':''; ?>">
        <a href="<?= WEBROOT; ?>admin">Accueil admin&nbsp;>&nbsp;</a>
    </li>
    <li class="<?= ($page=='category')?'activeNavigate':''; ?>">
        <a href="<?= WEBROOT; ?>category">Administré les catégories&nbsp;>&nbsp;</a>
    </li>    
    <li class="<?= ($page=='categories-forums')?'activeNavigate':''; ?>">
        <a href="<?= WEBROOT; ?>categories-forums">Administré les catégories de forums&nbsp;>&nbsp;</a>
    </li>
    <li class="<?= ($page=='works')?'activeNavigate':''; ?>">
        <a href="<?= WEBROOT; ?>works">Administré les articles&nbsp;>&nbsp;</a>
    </li>    
    <li class="<?= ($page=='forums')?'activeNavigate':''; ?>">
        <a href="<?= WEBROOT; ?>forums">Administré les forums&nbsp;>&nbsp;</a>
    </li>
    <li class="<?= ($page=='users')?'activeNavigate':''; ?>">
        <a href="<?= WEBROOT; ?>users">Géré les utilisateurs&nbsp;>&nbsp;</a>
    </li>
    <li class="<?= ($page=='parameters')?'activeNavigate':''; ?>">
        <a href="<?= WEBROOT; ?>parameters">Paramêtres Générals</a>
    </li>
</ul>
