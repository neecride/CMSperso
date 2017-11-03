<?php

if(isset($_POST['install'])){
    
    $dbhost = isset($_POST['dbhost']) && !empty($_POST['dbhost']) ? trim($_POST['dbhost']) : '' ;
    $dbname = isset($_POST['dbname']) && !empty($_POST['dbname']) ? trim($_POST['dbname']) : '' ;
    $dbuser = isset($_POST['dbuser']) && !empty($_POST['dbuser']) ? trim($_POST['dbuser']) : '' ;
    $dbpswd = isset($_POST['dbpswd']) && !empty($_POST['dbpswd']) ? trim($_POST['dbpswd']) : '' ;
    
    $errors = [];
    
    if(!preg_match('#^[a-zA-Z0-9]+$#',$dbhost)){
        
        $errors['host'] = 'La host doit être en alphanumeric a-zA-Z0-9';
        
    }if(!preg_match('#^[a-zA-Z0-9]+$#',$dbname)){
        
        $errors['name'] = 'La nom de la base de donnée doit être en alphanumeric a-zA-Z0-9';
        
    }if(!preg_match('#^[a-zA-Z0-9]+$#',$dbuser)){
        
        $errors['user'] = 'La nom d\'utilisateur de la base donnée doit être en alphanumeric a-zA-Z0-9';
        
    }if(!preg_match('#^[a-zA-Z0-9]+$#',$dbpswd)){
        
        $errors['pswd'] = 'La mots de pass de la base de donnée doit être en alphanumeric a-zA-Z0-9';
        
    }else if(empty($errors)){

        try{
            $db = new PDO('mysql:host=' . $dbhost . ';dbname='.$dbname,$dbuser,$dbpswd,array( PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8' )); 
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);//ou FETCH_ASSOC
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //exception or WARNING
        }catch(Exception $e){
            echo $e->getMessage(); 
            die('&nbsp;Imopsible de ce connecter a la BDD');    
        }
    
        //si on retourne un résultat alors on lace l'installation
        if($db != null){
                        
            $config = [];
            $config[] = '<?php ';
            $config[] = 'define(\'DBHOST\', \'' . $dbhost . '\');';
            $config[] = 'define(\'DBNAME\', \'' . $dbname . '\');';
            $config[] = 'define(\'DBUSER\', \'' . $dbuser . '\');';
            $config[] = 'define(\'DBPSWD\', \'' . $dbpswd . '\');';
            
            
            if(file_exists('lib/config.php')){
                
                file_put_contents('lib/config.php', implode("\r\n",$config) , LOCK_EX);
                
            }else{
                
                die('ce fichier est introuvable');
                
            }
            
            sleep(5);
            
            //Structure de la table `categories`
            $db->query('CREATE TABLE IF NOT EXISTS `categories` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `cat_name` varchar(255) DEFAULT NULL,
              `slug` varchar(255) DEFAULT NULL,
              `date` datetime DEFAULT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8');


            //Contenu de la table `categories`
            $db->query('INSERT INTO categories SET id="1", cat_name="Catégorie par défaut", slug="categorie-par-defaut", date = now()');



            //Structure de la table `comments`
            $db->query('CREATE TABLE IF NOT EXISTS `comments` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `username` varchar(255) DEFAULT NULL,
              `email` varchar(255) DEFAULT NULL,
              `comment` text,
              `post_id` int(11) DEFAULT "0",
              `parent_id` int(11) DEFAULT "0",
              `depth` int(11) DEFAULT "0",
              `date` datetime DEFAULT NULL,
              `seen` tinyint(1) DEFAULT "0",
              PRIMARY KEY (`id`),
              KEY `post_id` (`post_id`),
              KEY `parent_id` (`parent_id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8');


            //Contenu de la table `comments`
            $db->query('INSERT INTO comments SET id=1, username="admin", email="admin@admin.com", comment="je suis le commentaire par defaut", post_id=1, parent_id=0, depth=0, date = now(), seen=1'); 


            //Structure de la table `dislikes`
            $db->query('CREATE TABLE IF NOT EXISTS `dislikes` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `id_article` int(11) DEFAULT "0",
              `id_membre` int(11) DEFAULT "0",
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8');



            //Structure de la table `f_categories`
            $db->query('CREATE TABLE IF NOT EXISTS `f_categories` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `f_cat_name` varchar(255) DEFAULT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8');


            //Contenu de la table `f_categories`
            $db->query("INSERT INTO `f_categories` (`id`, `f_cat_name`) VALUES
            (1, 'Catégorie par défaut '),
            (2, 'Deuxième catégorie ')");



            //Structure de la table `f_forums`
            $db->query('CREATE TABLE IF NOT EXISTS `f_forums` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `f_forum_name` varchar(255) DEFAULT NULL,
              `f_forum_description` varchar(255) DEFAULT NULL COMMENT "titre du topic",
              `f_count_rep` int(11) DEFAULT "0" COMMENT "count reponse",
              `f_categorie_id` int(11) DEFAULT "0",
              `slug` varchar(255) DEFAULT NULL,
              `f_authorization` int(1) DEFAULT "0",
              `ordre` int(11) DEFAULT "0",
              PRIMARY KEY (`id`),
              KEY `f_categorie_id` (`f_categorie_id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8');


            //Contenu de la table `f_forums`
            $db->query("INSERT INTO `f_forums` (`id`, `f_forum_name`, `f_forum_description`, `f_count_rep`, `f_categorie_id`, `slug`, `f_authorization`, `ordre`) VALUES
            (1, 'Forum visiteurs', 'Je suis un forum pour les visiteurs', 0, 1, 'forum-visiteurs', 1, 0),
            (2, 'Forum membres', 'Je suis un forum pour les membres', 0, 1, 'forum-membres', 2, 0),
            (3, 'Forum modos', 'Je suis un forum pour les modos', 0, 2, 'forum-modos', 3, 0),
            (4, 'Forum admin', 'Je suis un forum pour le chef', 0, 2, 'forum-admin', 4, 0);");


            //Structure de la table `f_message_view`
            $db->query('CREATE TABLE IF NOT EXISTS `f_message_view` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `user_id` int(11) DEFAULT "0",
              `topic_id` int(11) DEFAULT "0",
              `last` datetime DEFAULT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8');



            //Structure de la table `f_topics`
            $db->query("CREATE TABLE IF NOT EXISTS `f_topics` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `f_topic_name` varchar(255) DEFAULT NULL,
              `f_topic_slug` varchar(255) DEFAULT NULL COMMENT 'url',
              `f_topic_content` longtext,
              `f_user_id` int(11) DEFAULT '0',
              `f_autor_topic` varchar(255) DEFAULT NULL COMMENT 'auteur topic',
              `f_topic_date` datetime DEFAULT NULL,
              `f_forum_id` int(11) DEFAULT '0',
              `f_topic_vu` int(11) DEFAULT '0',
              PRIMARY KEY (`id`),
              KEY `f_forum_id` (`f_forum_id`),
              KEY `f_forum_id_2` (`f_forum_id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8");


            //Contenu de la table `f_topics`
            $db->query("INSERT INTO `f_topics` (`id`, `f_topic_name`, `f_topic_slug`, `f_topic_content`, `f_user_id`, `f_autor_topic`, `f_topic_date`, `f_forum_id`, `f_topic_vu`) VALUES
            (1, 'Titre de mon topic', 'titre-de-mon-topic', 'Topic par defaut', 1, 'admin', now() , 1, 0)");



            //Structure de la table `f_topics_reponse`
            $db->query("CREATE TABLE IF NOT EXISTS `f_topics_reponse` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `f_rep_slug` varchar(255) DEFAULT NULL,
              `f_topic_reponse` longtext NOT NULL,
              `f_user_id` int(11) DEFAULT NULL,
              `user_rep` varchar(255) DEFAULT NULL COMMENT 'créateur de la réponse',
              `f_topic_rep_date` datetime DEFAULT NULL,
              `f_topic_id` int(11) DEFAULT NULL,
              PRIMARY KEY (`id`),
              KEY `f_topic_id` (`f_topic_id`),
              KEY `f_user_id` (`f_user_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8");



            //Structure de la table `images`
            $db->query('CREATE TABLE IF NOT EXISTS `images` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `name` varchar(255) DEFAULT NULL,
              `work_id` int(11) DEFAULT NULL,
              PRIMARY KEY (`id`),
              KEY `work_id` (`work_id`),
              KEY `work_id_2` (`work_id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8');


            $db->query('INSERT INTO `images` (`id`, `name`, `work_id`) VALUES (1, "1.jpg", 1);');

            //Structure de la table `likes`
            $db->query('CREATE TABLE IF NOT EXISTS `likes` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `id_article` int(11) DEFAULT "0",
              `id_membre` int(11) DEFAULT "0",
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8');



            //Structure de la table `parameters`
            $db->query('CREATE TABLE IF NOT EXISTS `parameters` (
              `param_id` bigint(20) unsigned NOT NULL COMMENT "no A_I",
              `param_name` varchar(255) NOT NULL,
              `param_value` longtext NOT NULL,
              `param_activ` varchar(3) DEFAULT "oui",
              PRIMARY KEY (`param_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8');


            //Contenu de la table `parameters`
            $db->query('INSERT INTO `parameters` (`param_id`, `param_name`, `param_value`, `param_activ`) VALUES
            (1, "slogan", "Ceci est un site en beta", "oui"),
            (2, "sitename", "Que de boulot PIUF !!!", "oui"),
            (3, "pagination article", "10", "oui"),
            (4, "comment", "1", "oui"),
            (5, "pagination forum", "3", "oui"),
            (6, "themeforlayout", "hardline", "oui"),
            (7, "secretkey", "", "oui"),
            (8, "publickey", "", "oui")');

            //Structure de la table `users`
            $db->query("CREATE TABLE IF NOT EXISTS `users` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `username` varchar(255) DEFAULT NULL,
              `password` varchar(255) DEFAULT NULL,
              `description` varchar(255) DEFAULT NULL,
              `date_inscription` datetime DEFAULT NULL,
              `lastconect` datetime DEFAULT NULL COMMENT 'date dernière connexion',
              `email` varchar(255) DEFAULT NULL,
              `userurl` varchar(255) NOT NULL DEFAULT 'http://yoursite.fr',
              `avatar` varchar(255) DEFAULT NULL,
              `confirmed_token` varchar(255) DEFAULT NULL,
              `confirmed_at` datetime DEFAULT NULL,
              `reset_token` varchar(255) DEFAULT NULL,
              `reset_at` datetime DEFAULT NULL,
              `remember_token` varchar(255) DEFAULT NULL,
              `activation` tinyint(1) DEFAULT '1',
              `authorization` int(1) DEFAULT '1',
              `slug` varchar(255) DEFAULT 'membre',
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8");


            //Contenu de la table `users`
            $db->query('INSERT INTO `users` (`id`, `username`, `password`, `description`, `date_inscription`, `lastconect`, `email`, `userurl`, `avatar`, `confirmed_token`, `confirmed_at`, `reset_token`, `reset_at`, `remember_token`, `activation`, `authorization`, `slug`) VALUES
            (1, "admin", "$2y$10$7iwUxjW47kv0s9v2R7zUce6saEztvmyZUp72xQSPLfXqDWJNW4vRy", NULL, now(), now(), "admin@admin.com", "http://your-site.fr", "", NULL, now(), NULL, NULL, "", 1, 4, "admin")');

            //Structure de la table `works`
            $db->query("CREATE TABLE IF NOT EXISTS `works` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `name` varchar(255) DEFAULT NULL,
              `writer` varchar(255) DEFAULT NULL,
              `slug` varchar(255) DEFAULT NULL,
              `content` longtext NOT NULL,
              `posted` tinyint(1) DEFAULT '0',
              `date` datetime DEFAULT NULL,
              `category_id` int(11) DEFAULT NULL,
              `image_id` int(11) DEFAULT NULL,
              `user_id` int(11) DEFAULT NULL,
              PRIMARY KEY (`id`),
              KEY `category_id` (`category_id`),
              KEY `image_id` (`image_id`),
              KEY `category_id_2` (`category_id`),
              KEY `image_id_2` (`image_id`),
              KEY `user_id` (`user_id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8");


            //Contenu de la table `works`
            $db->query("INSERT INTO `works` (`id`, `name`, `writer`, `slug`, `content`, `posted`, `date`, `category_id`, `image_id`, `user_id`) VALUES
            (1, 'Article par défaut', 'admin', 'article-par-defaut', 'Article par defaut', 1, now() , 1, 1, 1)");

        }
        header("location:home");
        die;
    }else{
        
        die('error');
        
    }
}
?>

<?php 
if(!empty($errors)){ 
    foreach($errors as $error){ 
?>

            <li><?= $error; ?></li> 

<?php 
   } 
} 
?>

<form action="" method="post">
    <input type="text" name="dbhost" value='<?= isset($_POST['dbhost']) && !empty($_POST['dbhost']) ? $_POST['dbhost'] : 'localhost' ; ?>'>
    
    <input type="text" name="dbname" value='<?= isset($_POST['dbname']) && !empty($_POST['dbname']) ? $_POST['dbname'] : 'nom de la base de donnee'; ?>'>
    
    <input type="text" name="dbuser" value='<?= isset($_POST['dbuser']) && !empty($_POST['dbuser']) ? $_POST['dbuser'] : 'username'; ?>'>
    
    <input type="password" name="dbpswd" placeholder="dbpswd">
    
    <button type="submit" name="install">enyoyez</button>
</form>
