<?php

is_logged();

    if(isset($_GET['username']) && isset($_GET['token']) ){
        $req = $db->prepare('SELECT * FROM users WHERE username = ? AND reset_token IS NOT NULL AND reset_token = ? AND reset_at > DATE_SUB(NOW(), INTERVAL 30 MINUTE)');
        $req->execute([$_GET['username'], $_GET['token']]);
        $user = $req->fetch();
        $error = '';
        if($user){
            
            if(!empty($_POST)){
                
                checkCsrf();//on vérifie tout de meme les failles csrf
                $pass = trim($_POST['password']); 
                $password_confirm = trim($_POST['password_confirm']); 
                
                if($pass != $password_confirm){
            
                    $error .= errors(["Vos mots de pass sont diférent"]);
            
                }if((strlen($pass) < 6) || (strlen($pass) > 100)){

                    $error .= errors(["Le mots de pass est trop court min 6 et maxi 100 caractères"]);

                }
                else if(empty($error)){

                    $password = password_hash($pass, PASSWORD_BCRYPT);

                    $db->prepare("UPDATE users SET password = ?, reset_at = NULL, reset_token = NULL")->execute([$password]);

                    $_SESSION['auth'] = $user;
                    setFlash('<strong>Salut !!</strong> votre mots de pass a bien étais restauré <strong>super</strong>');
                    redirect('home');
                }
                
             }
            
        }else{

                setFlash('<strong>Ho ho!</strong> mauvaise URL <strong>Ce token n\'est pas valide</strong>','rouge');
                redirect('home');
            
        }
        
    }else{
        
        setFlash('<strong>Ho ho!</strong> mauvaise URL <strong>Vous n\'avez pas le droit d\'être sur cette page </strong>','rouge');
        redirect('error');
        
    }