<?php
function reconnect_from_cookie(){//reconextion automatique
    
    if(isset($_COOKIE['remember']) && !isset($_SESSION['auth'])){
        if(!isset($db)){
            global $db;
        }
        $remember_token = $_COOKIE['remember'];
        $parts = explode('==', $remember_token);
        $user_id = $parts[0];
        $req = $db->prepare('SELECT * FROM users WHERE id = ?');
        $req->execute([$user_id]);
        $user = $req->fetch();
        $key = sha1($user->id . 'ratonlaveurs' . $_SERVER['REMOTE_ADDR']);
        if($_SESSION['auth'] = $user){
            $expected = $user_id . '==' . $user->remember_token . $key;
            if($expected == $remember_token){
            
                $_SESSION['auth'] = $user;
                setcookie('remember', $remember_token, time() + 60 * 60 * 24 * 7,null,null,false,true);
                
            } else{
                
                setcookie('remember', null, -1);
            
            }
        }else{
            
            setcookie('remember', null, -1);
        
        }
    }
}
reconnect_from_cookie();

//le nom du cookies (sans espace) > ce qu'il contien > sa duree > et ?? 
//setcookie('CookieName', 'je suis un cokkie ! de teste', time() + 60 * 60 * 24 * 7 ,null,null,false,true);

/**********
* mise en cash
**********/
function version($path){
    if (file_exists($file = $_SERVER['DOCUMENT_ROOT'] . $path)){
        $mtime = filemtime($file);
        $path_info = pathinfo($file); 
        $ext = substr($file, strrpos($file, '.'));

        return str_replace($ext,'-'. hash('md5',$mtime),$path) . $ext;
        //return $path_info['dirname'] . '/' . $path_info['filename'] . '-' . hash('md5', $mtime) . '.' . $path_info['extension']
    
    }

    return $path;
}
/**************
* redirect
***************/
function redirect($location_page, $folder=false){
    
    if($folder != false){
        header("location:" . WEBROOT . $folder . $location_page);
        exit();
    }else{
        header("location:" . WEBROOT . $location_page);
        exit();
    }
 
}
/*********
*is Not connect
********/
function isNot_connect(){
    
     if(!isset($_SESSION['auth'])){//si rien en session

        setFlash('<strong>Oh oh!</strong> ça ne va pas ! vous devez être connecter pour acceder a cette page','orange');
        redirect('home');
    }   
    
}

/*********
*is Not connect
********/
function is_logged(){
    
    if(!empty($_SESSION['auth']->id)){

        setFlash('<strong>Oh oh!</strong> ça ne va pas ! <strong> tu est déjà logger</strong>','orange');
        redirect('account');

    } 
    
}
/******
* function admin or not
********/
function is_admin(){
    
    if(empty($_SESSION["auth"]->authorization) || !empty($_SESSION["auth"]->authorization != 4)){//verification du rang admin
	
        setFlash('<strong>Oh oh!</strong> vous n\'avez pas acces a cette page <strong> réserver au admin </strong>','orange');
        redirect('home');
    
    } 
}
/**********
* fonction role
**********/
function role($master = ''){
    
        if($master == 4){

            $role = 'admin';

        }if($master == 3){

            $role = 'modo';

        }if($master == 2){

            $role = 'membre';

        }if($master == 1){

            $role = 'visiteur';

        }if(empty($master)){
            
            $role = 'unknow';
            
        }
      
    
    return $role;
}



/******
*token
******/
function str_random($length){
    
    $alphabet = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
    
    return substr(str_shuffle(str_repeat($alphabet, $length)), 0,$length);
    
}

function widgetSidebar($ext){
    
    global $db, $sidebarre;
    
    $dirname = 'inc/plugins/widgets';
    $dir = @ opendir($dirname); //on masque l'erreur si le chemin est incorect
    $extensions = [$ext];
    $nb_fichier = 0;
    if($dir !== false) {
        while(false!==($file = readdir($dir))) {
            if($file != "." && $file != ".." && stristr($file,'.'.$ext)){ 

                $nb_fichier++;   
                
                include_once 'inc/plugins/widgets/'.$file; 

            }
        }
    }
    closedir($dir);
    
}

/*******
* auto slug
*******/
function Slug($string){
    return strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($string, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-'));
}

//check les utilisateur
function users(){
    
    global $db;

    $user_id = isset($_SESSION['auth']->id) && !empty($_SESSION['auth']->id) ? intval($_SESSION['auth']->id) : '' ;

    $req = $db->prepare('SELECT id,username,email,slug,avatar,description,date_inscription,userurl FROM users WHERE id = ?');

    $req->execute([$user_id]);

    $user = $req->fetchObject();
    
    return $user;
}
/*******
* url
********/
function addLink($url,$name,$attrs = []){
    
    $link = '<a href='. WEBROOT . $url .'';
    
    foreach($attrs as $k => $v){
        $link .= ' '.$k.'='.$v;
    }
    
    $link .= '>' . $name . '</a>';

    return $link;
    
}

/*****
* default session
******/
if(!isset($_SESSION['authorization']) && empty($_SESSION['authorization'])){
    
    $_SESSION['authorization'] = 1;
    
}
if(isset($_SESSION['auth']->id) && !empty($_SESSION['auth']->id)){
    
    unset($_SESSION['authorization']);   

}

/******
*fail csrf
******/	
if(!isset($_SESSION['csrf'])){
    
    //$alphabet = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
    
    //$key = substr(str_shuffle(str_repeat($alphabet, 50)), 0,50);
    
    $key = md5(time() + mt_rand());
    
	$_SESSION['csrf'] = $key;
}

function csrf($params = null){
    
    if($params != null){
        return $params . $_SESSION['csrf'];
    }else{
        return $_SESSION['csrf'];
    }
    
}
function csrfInput(){
	return '<input type="hidden" value="' . $_SESSION['csrf'] . '" name="csrf">';
}	
	
function checkCsrf(){
    if(
        (isset($_POST['csrf']) && $_POST['csrf'] == $_SESSION['csrf']) 
        ||
        (isset($_GET['csrf']) && $_GET['csrf'] == $_SESSION['csrf'])
      )
    {
      return true;	
    }

    if(isset($_SESSION['auth']->id) && !empty($_SESSION['auth']->id)){

        $userConnect = 'session en cour de l\'utilisateur, '.$_SESSION['auth']->username;

    }else{

        $userConnect = 'session en cour de l\'utilisateur, Visiteur pas de session';
    }

    //mail('amin@mail.com', 'Faille CSRF sur votre site',"Vous recevez ce mail car il y a eu une faille avec cette IP ".$_SERVER["REMOTE_ADDR"] ." ". $userConnect ." ");

    sleep(5);

    setFlash('<strong>Oh oh!</strong> C\'est pas bien ! <strong> :( Faille CSRF </strong>','rouge');
    header('Location:' . WEBROOT . 'error');
    exit();
    
}
/********
* les formulaires
********/
function newInput($field,$label=null,$attrs = []){
        
    $r = '';
    if($label!=null){
        
        $r = '<label for="'. $field .'">'.$label.'</label>';
    
    }
    
    $r .= '<input name="'.$field.'" ';
    
    foreach($attrs as $k => $v){
        $r .= ' '.$k.'='.$v ;
    }
    $r .= ' />';
    
    return $r; 
}


function input($id,$type,$CssClass,$PlaceHolder='',$empty='', $required=''){
    $value = isset($_POST[$id]) && !empty($_POST[$id]) ? $_POST[$id] : $empty ;
    return "<input type='$type' class='$CssClass' id='$id' name='$id' placeholder='$PlaceHolder' value='$value' $required>";
}

function input_email($id, $label){
    $label = isset($label) ? $label : '';
    $value = isset($_POST[$id]) ? $_POST[$id] : '';
    return "<label class='field-label' for='$label'>$label</label><input type='email'  class='form-control field-input' id='$id' name='$id' value='$value' />";
}
function input_password($id, $label){
    $label = isset($label) && !empty($label) ? $label : "";
    $value = isset($_POST[$id]) ? $_POST[$id] : '';
    return "<label class='field-label' for='$label'>$label</label><input type='password'  class='form-control field-input' id='$id' name='$id' value='$value' />";
}
function textArea($id,$type,$CssClass,$required=''){
    $value = isset($_POST[$id]) && !empty($_POST[$id]) ? $_POST[$id] : "Ne postez pas d'insultes, évitez les majuscules... Tout message d'incitation à la haine, au piratage, les insultes à la personne, le harcèlement reviendra à être banis du site temporairement ou définitivement vous êtes responsable de vos commentaires...";
    return "<textarea  type='$type' class='$CssClass' id='$id' name='$id' $required>$value</textarea>";
}

function bootstrapmde($id, $sql=''){
    $req = isset($sql) && !empty($sql) ? $sql : '' ;
    $value = isset($_POST[$id]) ? htmlspecialchars($_POST[$id]) : $req ;
    return "<textarea  type='text' data-provide='markdown-editable' class='form-control' id='editor1' name='$id'>$value</textarea>";
}
function select($id, $options = []){
    $return = "<select class='form-control' id='$id' name='$id'>";
    foreach($options as $k => $v){
        $selected = '';
        if(isset($_POST[$id]) && $k == $_POST[$id]){
            $selected = ' selected';
        }
        $return .= "<option value='$k' $selected>$v</option>";
    }
    $return .= '</select>';
    return $return;
}

/*************
* trucast long titre
*************/
function trunque($str, $nb = '') {
	if (strlen($str) > $nb) {
		$str = substr($str, 0, $nb);
		$position_espace = strrpos($str, " ");
		$texte = substr($str, 0, $position_espace); 
		$str = $str."...";
	}
	return $str;
}

/***********
* error message
***********/
function errors($messages = []){
    
    if(!empty($messages)){
        foreach($messages as $v){ 

            $return = '<li>'.$v.'</li>'; 

        }
    }
    
    return $return;
}

/*************
* flash message
**************/
function flash(){
    if(isset($_SESSION['Flash'])){
	    extract($_SESSION['Flash']);
		unset($_SESSION['Flash']);
        
        return "<div class='notify notify-$type'><div class='notify-box-content'>$message</div></div>";
	} 		
}
function setFlash($message,$type = 'vert'){
	$_SESSION['Flash']['message'] = $message;
	$_SESSION['Flash']['type'] = $type;
}


/**********
* parametre du site
***********/
function parameters(){//site params
    
    global $db;
    
    $params = $db->query("SELECT * FROM parameters");

    $param = [];

    while($rows = $params->fetchObject()){
        $param[] = $rows;
    }
    
    return $param;
}

$param = parameters();

/**********
* widjet forum
***********/
$sidebarre = $db->query("
SELECT 

    f_topics.id,
    f_topics.f_topic_name,
    f_topics.f_topic_slug,
    f_topics.f_forum_id,
    f_topics.f_topic_date,
    f_forums.f_authorization

FROM f_topics

LEFT JOIN f_forums on f_forums.id = f_topics.f_forum_id

ORDER BY f_topics.f_topic_date ASC LIMIT 10
");

function CountMembers(){
    
    global $db;
    
    $Cusers = $db->query("SELECT COUNT(id) AS NbUsers FROM users");
    
    $Cusers = $Cusers->fetch();
    
    $CountMembers = "Totals membres : <strong>" . $Cusers->NbUsers . "</strong>";
    
    return $CountMembers;
}

function LastMember(){
    
    global $db;
    
    $users = $db->query("SELECT id, username, date_inscription FROM users ORDER BY id DESC");
    
    $user = $users->fetch();
    
    if($user != null){
        $AllMembers = "Dernier inscrit : <strong>" . $user->username . "</strong> le : " . date('d/M/Y à H:i', strtotime($user->date_inscription)) . "";   
    }else{
        $AllMembers = 'Pas de membres';
    }
    
    return $AllMembers;
}

/************
* bgcolor
*************/
$color=0;
$burntopic = 'burntopic';
$bg1 = "element-first";
$bg2 = "element-child";

/**********
* parser recaptcha etc
***********/

//htmlpurifier
$purifierConfig = HTMLPurifier_Config::createDefault();
$purifierConfig->set('Core.Encoding', 'UTF-8');
$purifierConfig->set('HTML.Allowed', 'p, a[href|title], blockquote[cite],span[style], table[style], thead, tr, th[style], td[style], tbody, pre, code[class|style], hr, em, strong, ul, li, img[src|alt], br, ol, del, h1, h2, h3, h4, h5, h6');
$Purifier = new HTMLPurifier($purifierConfig);

//captcha google
if(isset($param[6]->param_value) && !empty($param[6]->param_value)){   
    $recaptcha = new \ReCaptcha\ReCaptcha($param[6]->param_value);
}

//parsedown
$parsedown = new Aidantwoods\SecureParsedown\SecureParsedown;
$parsedown->setSafeMode(true);
$Parsedown = new Parsedown();


/***********
* alert folder install exist
***********/
if(file_exists('install.php')){
                
    echo "<div class='notify notify-rouge'><div class='notify-box-content'><li>il faut supprimer de fichier install.php pour eviter le hack default pass 123456789</li></div></div>";

}