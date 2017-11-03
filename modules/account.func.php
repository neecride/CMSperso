<?php
//si on est deja logger ou si id est digérent de session
isNot_connect();

//edition du mdp
if(isset($_POST['pwd']) && !empty($_POST['pwd'])){
    
        $pass = trim($_POST['password']); 
        $password_confirm = trim($_POST['password_confirm']); 
            
        checkCsrf();//on vérifie tout de meme les failles csrf
    
        $error = '';
    
        if((strlen($pass) < 6) || (strlen($pass) > 100)){
            
            $error .= errors(["Le mots de pass est trop court 6 mini et 100 max caractères"]);
            
        }if($pass != $password_confirm){
            
            $error .= errors(["Vos mots de pass sont diférent"]);
            
        }if(empty($error)){
            
            
            $user_id = intval($_SESSION['auth']->id);

            $password = trim(password_hash($pass, PASSWORD_BCRYPT));

            $db->prepare("UPDATE users SET password = ? WHERE id = ?")->execute([$password, $user_id]);
            
            $_SESSION['auth']->password = $password;

            setFlash('<strong>Super !</strong> Votre mots de pass a bien étais modifier <strong>Bien jouer :)</strong>');
            redirect('account');

        }


}
//modification email
if(isset($_POST['edit-profil']) && !empty($_POST['edit-profil'])){
    
    $profil_id = intval($_SESSION['auth']->id);
    
    $email = trim(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
    
    $email_confirm = trim(filter_var($_POST['email_confirm'], FILTER_VALIDATE_EMAIL));
    
    $userurl = trim($_POST['userurl']);
    
    $description = trim($_POST['description']);
    
    $error = '';
    
    checkCsrf();//on vérifie tout de meme les failles csrf

    $req = $db->prepare('SELECT id FROM users WHERE email = ?');

    $req->execute([$_POST['email']]);

    $emailt = $req->fetch();
    if($emailt){

        $error .= errors(["Email est déjà utiliser"]);

    }
    if(empty($email)){
        
        $error .= errors(["L'email n'est pas valide ne doit pas être vide"]);

    }if($email != $email_confirm){

        $error .= errors(["L'email est diférent"]);

    }if(!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$userurl)){

        $error .= errors(["Votre URL n'est pas une URL valide"]);

    }if((strlen($description) > 200)){
            
        $error .= errors(["Votre description ne dois pas dépasser 200 caractères"]);

    }else if(empty($error)){
        
        $db->prepare("UPDATE users SET email = ?, userurl = ?, description = ? WHERE id = ?")->execute([$email, $userurl, $description, $profil_id]);

        setFlash('<strong>Super !</strong> Votre profil a bien étais modifier <strong>Bien jouer :)</strong>');
        redirect('account');

                
    }
            
}

if(isset($_POST['avatar']) && !empty($_POST['avatar'])){
    
    //on initialise l'id
    $profil_id = intval($_SESSION['auth']->id);
    
    $avatar = $_FILES['avatar'];
    
    //on définie le nom de l'image
    $avatar_name = $avatar['name'];
    
    //on definie l'extension
    $extension = strtolower(substr($avatar_name, -3));
    
    //toutes les extensions n'on pas que 3 caractères 
    //$extension = strtolower(substr(strrchr($avatar_name, '.'),1));
    
    //on renome l'image avant envoie avec l'id de l'utilisateur
    $save_name = md5($profil_id).'.'.$extension;
    
    //taille du fichier envoyez
    $pdsfile = filesize($_FILES['avatar']['tmp_name']);
    
    //1go en octets 1048576
    $max_size = 200000; //200ko
    
    //on definie l'extension autoriser
    $ext_autorize = ['png'];
    
    $error = '';

    checkCsrf();//on vérifie tout de meme les failles csrf
    if(!in_array($extension, $ext_autorize)){
        
        $error .= errors(['le fichier n\'est pas valide PNG uniquement']);
        
    }    
    if($pdsfile > $max_size){
            
        $error .= errors(['le fichier est trop volumineux 200ko max']);
            
    }else if(empty($error)){
    
        move_uploaded_file($avatar['tmp_name'], 'inc/img/avatars/'.$save_name);   

        $db->prepare("UPDATE users SET avatar = ? WHERE id = ?")->execute([$save_name, $profil_id]);

        $_SESSION['auth']->avatar = $save_name;
        setFlash('<strong>Super !</strong> Votre avatar a bien étais modifier/ajouter');
        redirect('account'); 
            
    }
    
   

}

//suppression avatar
if(isset($_POST['delete_avatar']) && !empty($_POST['delete_avatar'])){
    
    checkCsrf();//on vérifie tout de meme les failles csrf
    
    $profil_id = intval($_SESSION['auth']->id);
    
    $image_name = md5($profil_id) . '.png';
    $error = '';
     
    if(!file_exists('inc/img/avatars/' . $image_name)){
        
        $error .= errors(['le fichier n\'existe pas']);
          
    }if(empty($error)){
        
        unlink('inc/img/avatars/' . $image_name);
        
        $db->prepare("UPDATE users SET avatar = ? WHERE id = ?")->execute(['', $profil_id]);    
        
        setFlash('<strong>Super !</strong> L\'avatar a bien été supprimer <strong>Bien jouer :)</strong>');

        redirect('account');
        
    }
    
}


/*********
* supression
***********/
if(isset($_GET['lock'])){
    die('function lock');
   
    checkCsrf();
    
    $id = intval($_GET['lock']);
    
    $req = $db->prepare("UPDATE users SET activation = 0 WHERE id = ?")->execute([$id]);
    
    $_SESSION = array();
    setcookie('remember', NULL, -1);
    
    setFlash('<strong>Super !</strong> Votre compte a bien étais désactiver <strong>Bien jouer :)</strong>');
    
    redirect('home');
    
}


//check les utilisateur
function user_account(){

    global $db;

    $user_id = intval($_SESSION['auth']->id);

    $req = $db->prepare('
        SELECT 
        id,
        username,
        email,
        slug,
        avatar,
        description,
        date_inscription,
        userurl
        
        FROM users 

        WHERE id = ?


    ');

    $req->execute([$user_id]);

    $users = $req->fetchObject();  
    return $users;
}

function user_works(){

    global $db;

    $user_name = $_SESSION['auth']->username;

    $req = $db->prepare('
        SELECT *
        
        FROM works 

        WHERE writer = ? AND posted = 1
        
        ORDER BY date DESC LIMIT 5

    ');
    
    $req->execute([$user_name]);
    
    $results = [];
    
    while($rows = $req->fetchObject()){
        
        $results[] = $rows;
        
    }

    return $results;
}

$works = user_works();

$user = user_account();
