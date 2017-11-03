<?php
if(session_status() == PHP_SESSION_NONE){ //on verifie si les session ne sont pas démmarer
    session_start(); //et on demarre les sessions
}
session_regenerate_id(); //Remplace l'identifiant de session courant par un nouveau

define('ROOT', $_SERVER['DOCUMENT_ROOT']); //au cas ou si besoin

//on inclu les diferente librairie fonction etc...
define('DS', DIRECTORY_SEPARATOR);

require_once ('lib'.DS.'libs-includes.php');

$page = strtolower($_GET['page']);   

$themeForLayout = $param[5]->param_value;// variable du template

if(
    isset($page) && !empty($page) 
    && preg_match("/^[a-z0-9\-]+$/i",$page) 
    && in_array($page.'.php', scandir('templates'.DS.$themeForLayout)) 
    && is_file('templates'.DS.$themeForLayout.DS.$page.'.php') 
    && file_exists('templates'.DS.$themeForLayout.DS.$page.'.php')
){
        
        //on inclue les fonctions de chaque page appeler en GET
        require_once 'modules'. DS . $page .'.func.php';

        ob_start();
    
        //on inclu les pages appeler en GET
        require_once 'templates'.DS.$themeForLayout.DS.$page.'.php';

        $contentForLayout = ob_get_clean();
        
        //on inclu le temeplate 
        require_once 'templates'.DS.$themeForLayout.DS.'theme'.DS.$themeForLayout.'.php';
    
}else{
    sleep(2);
    setFlash('<strong>Ho ho !</strong> cette page n\'éxiste pas redirection sur la page d\'erreur','orange');
    redirect('error');
}
