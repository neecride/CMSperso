<div class="col-md-12">
		<!-- news -->
	<div class="news box-shadow">
    <div class="newsTitle text-shadow">
            <h4><?= $_GET['page']; ?></h4>
    </div>
    <div class="newsInfos text-shadow">
         Bonjour <?= isset($_SESSION['auth']->username) ? $_SESSION['auth']->username.' Votre IP : '. $_SERVER["REMOTE_ADDR"] : 'visiteur votre IP' . $_SERVER["REMOTE_ADDR"] ; ?>
    </div>
    <div class="newsContent text-shadow">
            <div class="the_content">
                Vous-vous trouvez sur cette page car vous ête tomber soit sur une page qui n'existe pas, soit une erreur dans un formulaire type erreur <a href="https://fr.wikipedia.org/wiki/Cross-Site_Request_Forgery" target="_blank">CSFR</a>.
                <br />
                Un email nous a été envoyez consernant cette erreur CSRF avec vos donnée en session ainsi que votre adresse IP afin de prendre des mesures en cas de possible hack de notre site.
                <br /><br />
                Si vous-vous trouvez sur cette page pour une simple erreur dans l'URL pas d'inquiétude vous avez le menue en haute de page.   
            </div>
 
            <div class="newsAutor">
                <div class="comentary-area text-shadow">
                </div>
		    </div> <!--  class row -->
	</div> <!-- class newsAuthor -->
</div> <!-- class newscontent -->
	
</div>