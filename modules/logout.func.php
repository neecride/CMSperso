<?php
$_SESSION = array();
setcookie('remember', NULL, -1);
setFlash('Revenez quand vous voulez !','info');
redirect('home');