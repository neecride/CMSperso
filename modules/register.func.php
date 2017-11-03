<?php

is_logged();
if(empty($param[7]->param_value)){//Recaptcha desactiver
    if(!empty($_POST)){

        $username = strip_tags(trim($_POST['username']));
        $pass = trim($_POST['password']); 
        $password_confirm = trim($_POST['password_confirm']); 
        checkCsrf();//on vérifie tout de meme les failles csrf
        $error = '';
            if(empty($username) || !preg_match('/^[a-zA-Z0-9_]+$/', $username)){

                $error .= errors(["Votre pseudo n'est pas valide selement des minuscules/majuscule et underscore (_)"]);

            }if((strlen($username) < 3) || (strlen($username) > 30)){

                $error .= errors(['le titre doit contenir au moins 4 caractèreset et être inférieure a 10']);

            }if(empty($error)){

                $req = $db->prepare('SELECT id FROM users WHERE username = ?');

                $req->execute([$username]);

                $user = $req->fetch();
                if($user){

                   $error .= errors(["Pseudo est déjà utiliser"]);

                }

            }if(empty(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){

                $error .= errors(["Votre email n'est pas valide"]);

            }
            if(!empty($_POST['captcha'] != $_SESSION['captcha'])){

                $error .= errors(["Le captcha n'est pas valide"]);

            }if(empty($_POST['captcha'])){

                $error .= errors(["Le captcha est obligatoire"]);

            }
            if(empty($error)){

                $req = $db->prepare('SELECT id FROM users WHERE email = ?');

                $req->execute([$_POST['email']]);

                $email = $req->fetch();
                if($email){

                    $error .= errors(["Email est déjà utiliser"]);

                }

            }if(!empty($pass != $password_confirm)){

                    $error .= errors(["Vos mots de pass sont diférent"]);

                }if((strlen($pass) < 6) || (strlen($pass) > 100)){

                    $error .= errors(["Le mots de pass est trop court 6 mini et maxi 100 caractères"]);

                }if(empty($error)){

                    $req = $db->prepare("INSERT INTO users SET username = ?, password = ?, email = ?, confirmed_token = ?, date_inscription = now()");

                    $password = password_hash($pass, PASSWORD_BCRYPT);

                    $token = str_random(60);

                    $req->execute([$username,  $password, $_POST['email'], $token]);

                    $user_id = $db->lastInsertId();
                    
                    $header="MIME-Version: 1.0\r\n";
                    $header.='From:"'.$_SERVER['HTTP_HOST'].'"<support@'.$_SERVER['HTTP_HOST'].'.com>'."\n";
                    $header.='Content-Type:text/html; charset="uft-8"'."\n";
                    $header.='Content-Transfer-Encoding: 8bit';
                
                    $message = '
                    <html>
                        <body>
                            <div align="center">
                                Pour valider votre compte merci de cliquer sur ce >> <a href="http://'.$_SERVER['HTTP_HOST'].'/confirm/'.urlencode($username).'/'.$token.'" target="_blank" >LIEN</a> <<
                            </div>
                        </body>
                    </html>
                    ';
                
                    mail($_POST['email'], 'Confirmation de votre inscription',$message,$header);

                    setFlash('<strong>Super !</strong> Vous êtes bien inscrit reste a valider votre compte ! par Email');
                    redirect('home');

                }  

        }
}else{ //recaptcha actif
    
        if(!empty($_POST)){

        $username = strip_tags(trim($_POST['username']));
        $pass = trim($_POST['password']); 
        $password_confirm = trim($_POST['password_confirm']); 
        $resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['SERVER_ADDR']);
        checkCsrf();//on vérifie tout de meme les failles csrf
        $error = '';
        if($resp->isSuccess()){ //effacer cette ligne si vous utiliser le captcha par defaut
            if(empty($username) || !preg_match('/^[a-zA-Z0-9_]+$/', $username)){

                $error .= errors(["Votre pseudo n'est pas valide selement des minuscules/majuscule et underscore (_)"]);

            }if((strlen($username) < 3) || (strlen($username) > 30)){

                $error .= errors(['le titre doit contenir au moins 4 caractèreset et être inférieure a 10']);

            }if(empty($error)){

                $req = $db->prepare('SELECT id FROM users WHERE username = ?');

                $req->execute([$username]);

                $user = $req->fetch();
                if($user){

                   $error .= errors(["Pseudo est déjà utiliser"]);

                }

            }if(empty(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){

                $error .= errors(["Votre email n'est pas valide"]);

            }if(empty($error)){

                $req = $db->prepare('SELECT id FROM users WHERE email = ?');

                $req->execute([$_POST['email']]);

                $email = $req->fetch();
                if($email){

                    $error .= errors(["Email est déjà utiliser"]);

                }

            }if(!empty($pass != $password_confirm)){

                    $error .= errors(["Vos mots de pass sont diférent"]);

                }if((strlen($pass) < 6) || (strlen($pass) > 100)){

                    $error .= errors(["Le mots de pass est trop court 6 mini et maxi 100 caractères"]);

                }if(empty($error)){

                    $req = $db->prepare("INSERT INTO users SET username = ?, password = ?, email = ?, confirmed_token = ?, date_inscription = now()");

                    $password = password_hash($pass, PASSWORD_BCRYPT);

                    $token = str_random(60);

                    $req->execute([$username,  $password, $_POST['email'], $token]);

                    $user_id = $db->lastInsertId();
                    
                    $header="MIME-Version: 1.0\r\n";
                    $header.='From:"'.$_SERVER['HTTP_HOST'].'"<support@'.$_SERVER['HTTP_HOST'].'.com>'."\n";
                    $header.='Content-Type:text/html; charset="uft-8"'."\n";
                    $header.='Content-Transfer-Encoding: 8bit';
                
                    $message = '
                    <html>
                        <body>
                            <div align="center">
                                Pour valider votre compte merci de cliquer sur ce >> <a href="http://'.$_SERVER['HTTP_HOST'].'/confirm/'.urlencode($username).'/'.$token.'" target="_blank" >LIEN</a> <<
                            </div>
                        </body>
                    </html>
                    ';
                
                    mail($_POST['email'], 'Confirmation de votre inscription',$message,$header);

                    setFlash('<strong>Super !</strong> Vous êtes bien inscrit reste a valider votre compte ! par Email');
                    redirect('home');

                }   
       }else{

            setFlash('<strong>Oh oh!</strong> Formulaire incorect !<strong> captcha invalide </strong>','orange');
            redirect('register');   

        }
    }
    
}