<?php
/**********
* like dislike
***********/

if(isset($_GET['t'],$_GET['id']) AND !empty($_GET['t']) AND !empty($_GET['id'])) {
   checkCsrf();//on vérifie tout de meme les failles csrf
   $getid =  intval($_GET['id']);
   $gett =  intval($_GET['t']);
   $sessionid = $_SESSION['auth']->id;
   $check = $db->prepare('SELECT id FROM works WHERE id = ?');
   $check->execute(array($getid));
    if(empty($_SESSION['auth']->id)){
        setFlash('<strong>Ho ho !</strong> Problème <strong> vous devez être connecter pour donner votre avis</strong>','orange');
        redirect('post/'.$_GET['id'].'/'.$_GET['slug']);
        
    }if($check->rowCount() == 1) {
      if($gett == 1) {
         $check_like = $db->prepare('SELECT id FROM likes WHERE id_article = ? AND id_membre = ?');
         $check_like->execute(array($getid,$sessionid));
         $del = $db->prepare('DELETE FROM dislikes WHERE id_article = ? AND id_membre = ?');
         $del->execute(array($getid,$sessionid));
         if($check_like->rowCount() == 1) {
            $del = $db->prepare('DELETE FROM likes WHERE id_article = ? AND id_membre = ?');
            $del->execute(array($getid,$sessionid));
            setFlash('vous avez changer d\'avis sur cette article','info');
            redirect('post/'.$_GET['id'].'/'.$_GET['slug']);
         } else {
            $ins = $db->prepare('INSERT INTO likes (id_article, id_membre) VALUES (?, ?)');
            $ins->execute(array($getid, $sessionid));
            setFlash('vous aimez cette article');
            redirect('post/'.$_GET['id'].'/'.$_GET['slug']);
         }
          
      } elseif($gett == 2) {
         $check_like = $db->prepare('SELECT id FROM dislikes WHERE id_article = ? AND id_membre = ?');
         $check_like->execute(array($getid,$sessionid));
         $del = $db->prepare('DELETE FROM likes WHERE id_article = ? AND id_membre = ?');
         $del->execute(array($getid,$sessionid));
         if($check_like->rowCount() == 1) {
            $del = $db->prepare('DELETE FROM dislikes WHERE id_article = ? AND id_membre = ?');
            $del->execute(array($getid,$sessionid));
            setFlash('vous avez changer d\'avis sur cette article','info');
            redirect('post/'.$_GET['id'].'/'.$_GET['slug']);
         } else {
            $ins = $db->prepare('INSERT INTO dislikes (id_article, id_membre) VALUES (?, ?)');
            $ins->execute(array($getid, $sessionid));
            setFlash('vous n\'aimez pas cette article','orange');
            redirect('post/'.$_GET['id'].'/'.$_GET['slug']); 
         }
      }
   } else {
      setFlash('<strong>Ho ho !</strong> Problème <strong> cette id n\'éxiste pas </strong>','orange');
      redirect('error');
   }
} else {
   setFlash('<strong>Ho ho !</strong> Problème <strong> cette id n\'éxiste pas </strong>','orange');
   redirect('error');
}