<?php
/************
* pagination 
************/
//pagination parameters
$PagesMax = $param[2]->param_value;

$PagesTotal = $db->query('SELECT id FROM works WHERE posted=1');

$Total = $PagesTotal->rowCount();

$PagesTotales = ceil($Total/$PagesMax);

//si id en get
if(isset($_GET['pager']) AND !empty($_GET['pager']) AND $_GET['pager'] > 0 AND $_GET['pager'] <= $PagesTotales) {
    
   $CurrentPage = $_GET['pager'];
    
} else {
   //si id null alors page sera egal 1 
    $CurrentPage = 1;

}

//pagination number link
function paginatNumbers($nb=2){
    
    global $Total, $PagesTotales, $CurrentPage,$PagesMax;
    
    //pagination current
    $pagination = '<div id="pagination">';
    for($i=1; $i <= $PagesTotales; $i++) {

        if($i <= $nb || $i > $PagesTotales - $nb ||  ($i > $CurrentPage-$nb && $i < $CurrentPage+$nb)){

            if($i == $CurrentPage){

                $pagination .=  $i.' ';   

            }elseif($i == $CurrentPage+1){ 

                $pagination .= '<a href="'.WEBROOT.'home/'.$i.'" class="suivant">'. $i .'</a>' ;

            }else{

                $pagination .= '<a href="'.WEBROOT.'home/'.$i.'">'. $i .'</a>' ;

            }

        }

    }
    $pagination .= '</div>';

    return $pagination;
}


$StartPager = ($CurrentPage-1)*$PagesMax;

$limited = $StartPager .','. $PagesMax;

//liste works
$req = $db->query("

   SELECT   works.id,
            works.name,
            works.writer,
            works.content,
            works.posted,
            works.date,
            works.slug,
            images.name AS image_name,
            categories.cat_name,
            categories.id AS catid,
            users.email,
            users.username,
            users.avatar,
            comments.post_id,
            COUNT(comments.post_id) AS nbcoms

    FROM works

    LEFT JOIN users ON users.username = works.writer

    LEFT JOIN categories ON works.category_id=categories.id

    LEFT JOIN comments ON comments.post_id = works.id

    LEFT JOIN images ON images.id = works.image_id

    WHERE works.posted=1

    GROUP BY works.id

    ORDER BY works.date DESC LIMIT $limited

");

/**********
* like dislike
***********/
function likes($id){
    global $db;
    $likes = $db->prepare('SELECT id FROM likes WHERE id_article = ?');
    $likes->execute([$id]);
    $likes = $likes->rowCount();
    return $likes;
}

function dislikes($id){
    global $db;
    $dislikes = $db->prepare('SELECT id FROM dislikes WHERE id_article = ?');
    $dislikes->execute([$id]);
    $dislikes = $dislikes->rowCount();
    return $dislikes;
}