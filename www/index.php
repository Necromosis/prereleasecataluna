<?php


    // --- connexion base de donnees
    include 'connect.php';
    $bdd = mysqli_connect(SERVEUR, USER, PASSE, DB) or die("Connexion DB impossible (code : ".mysqli_connect_errno()." ".mysqli_connect_error().")");
    mysqli_set_charset($bdd,"utf8");

    // --- recup libelles types pizzas
    $pizzastypes = [];
    $sql = "SELECT idtype, pizztype, txtbtn, ordreaff FROM pizzatypes ORDER BY ordreaff";
    $res = mysqli_query($bdd, $sql);
    while ( $recpizztype = mysqli_fetch_assoc($res) ) {
        $idtype = $recpizztype['idtype'];
        $pizzastypes[$recpizztype['ordreaff']]['idtype'] = $idtype;
        $pizzastypes[$recpizztype['ordreaff']]['pizztype'] = $recpizztype['pizztype'];
        $pizzastypes[$recpizztype['ordreaff']]['txtbtn'] = $recpizztype['txtbtn'];
        // --- calcul du nombre de pizzas de ce type
        $sql2 = "SELECT * FROM pizzas WHERE idtype=$idtype";
        $res2 = mysqli_query($bdd, $sql2);
        $pizzastypes[$recpizztype['ordreaff']]['nbpizz'] = mysqli_num_rows($res2);
    }

function affcolpizz ($res) {
    $html = '';
    $html .= '<div class="col-xs-12 col-sm-6">'; // div colonne
    while ( $pizza = mysqli_fetch_assoc($res)) {
        $html .=  '<div class="pizza">';
            $html .=  '<div class="nompizz">'.$pizza['nompizz'].'</div>';
            $html .=  '<div class="prixpizz">';
                $html .=  '29 cm : <span class="txtprixpizz">'.number_format($pizza['prix29'],2,',',' ').' €</span>';
                $html .=  '&nbsp;&nbsp;&nbsp;';
                $html .=  '33 cm : <span class="txtprixpizz">'.number_format($pizza['prix33'],2,',',' ').' €</span>';
            $html .=  '</div>';
            $html .=  '<div class="descpizz">'.$pizza['compo'].'</div>';
        $html .=  '</div>';
    }
    $html .= '</div>'; // --- fin de div colonne
    return $html;
}


?>



<!DOCTYPE html>

<html lang=fr>

<head>
	<title>Cataluna Pizz - Les pizzas de tradition</title>
	<meta charset="utf-8">
	<meta name="viewport" content="initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link href="https://fonts.googleapis.com/css?family=Permanent+Marker" rel="stylesheet"> 
</head>

<body>

    <?php
        include 'header.php';
        include 'navbar.php';   // --->>>>>>>>>>>>> penser a gerer les ancres (voir plus bas)
        include 'carousel.php';
    ?>

<!-- zone liste pizzas ---------------------------------- -->

		<div class="container-fluid">

			<div class="row"> <!-- zone pizzas 2 col -->

				<div class="col-xs-offset-1 col-xs-10"> <!-- zone pizza 2 col -->

                    <?php
                        // --- pour tous les types de pizzas, on affiche le titre, puis la liste sur 2 colonnes
                        foreach ( $pizzastypes as $pizztype ) {

                            // --- on cree l'ancre pour la navbar
                            echo '<div id="pizztyp'.$pizztype['idtype'].'"></div>';

                            // --- on affiche le type de pizza sur toute la largeur
                            echo '<div class="row">';
                                echo '<div class="col-xs-12">';
                                    echo '<div id="pizztomate" class="titrepizz">'.$pizztype['pizztype'].'</div>';
                                echo '</div>';
                            echo '</div>';

                            // ATTENTION : il faut gérer l'ancre (id=pizztomate) avec la navbar

                            // --- on calcule le nombre de pizzas pour la premiere colonne (le reste dans la deuxieme)
                            $nbpizzgauche = ceil( $pizztype['nbpizz'] / 2 - 0.01 ); // ceil = arrondi superieur

                            // creation de la row pour les 2 colonnes
                            echo '<div class="row pizzsep">';

                                // --- recuperation des pizzas de la colonne gauche
                                $sql = "SELECT nompizz, compo, prix29, prix33 FROM pizzas WHERE idtype=".$pizztype['idtype']." LIMIT $nbpizzgauche;";
                                $res = mysqli_query($bdd, $sql);


                                echo affcolpizz($res); // genere le contenu html de la colonne


                                // --- recuperation des pizzas de la colonne droite
                                $sql = "SELECT nompizz, compo, prix29, prix33 FROM pizzas WHERE idtype=".$pizztype['idtype']." LIMIT $nbpizzgauche,500";
                                $res = mysqli_query($bdd, $sql);

                                echo affcolpizz($res); // genere le contenu html de la colonne

                            // fin de la row
                            echo '</div>';

                        }
                    ?>

				</div>

			</div>

	<!-- supplement fromage -->
			<div class="row">
				<div class="col-xs-offset-1 col-xs-10">
					<div class="text-center supplement txtprixpizz">
						100% FROMAGE (emmental, mozzarella)<br />
						Supplément viande et fromage 1.20€, autre Supplément 0.50€<br />
						Toutes nos pizzas peuvent être adaptées en fonction de vos goûts : Base tomate, crème fraîche ou aillée.
					</div>
				</div>

			</div>

<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2674.976116120907!2d1.8872609511447886!3d47.898147575683424!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e4e52fb85970f3%3A0xbe45bf8a189931dd!2sOrleans+Pneumatiques+-+Eurotyre!5e0!3m2!1sfr!2sus!4v1488539405013" width="400" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>

	<!-- Qui sommes nous -->
		  	<div class="row qsn">
				<div class="col-xs-12 col-md-8">

					<h3 id="noscontacts" class="titreqsn">Qui sommes-nous ?</h3>
					<p class="pqsn">
						Cataluña Pizz, c'est avant tout un food truck qui permet d'aller à votre rencontre dans toute 
						l'agglomération orléanaise pour vous fournir une cuisine et des produits frais venus tout droit 
						d’Espagne. Nous y apportons simplement une touche personnelle en réinterprétant les richesses 
						de cette gastronomie.
					</p>
				</div>
	  			<div class="col-md-4">
	  				<img class="img-responsive imgqsn" src="img/foodtruck.jpg" alt="image Food Truck" />
	  			</div>
	 		</div>


	<!-- Footer -->
			<footer class="row footer">

				<div class="col-xs-4"> <!-- telechargement carte -->
					<a class="txtfoot" href="img/catalunapizz-carte.pdf" target="_blanc">Télécharger la carte</a>
				</div>

	  			<div class="col-xs-4"> <!-- infos legales -->
					<a class="txtfoot" data-toggle="modal" data-target="#myModal">Informations légales</a>
					<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
									<h3 class="modal-title" id="myModalLabel">Informations légales</h3>
								</div>
								<div class="modal-body legal">
									<h4>Editeur</h4>
									<p>
										SARL CATALUNA PIZZ<br />
										Siège social : Au fond u couloir, à gauche, 45000 ORLEANS-PLAGE.<br />
										Siret : 254500250000005<br />
										Inscrit au registre de la Chambre des Métiers et de l'Artisanat du Loiret
									</p>


									<h4>Responsable de publication</h4>
									<p>M. DUGLANTIER, gérant.</p>


									<h4>Hébergement</h4>
									<p>Ce site est hébergé chez OVH (ou ailleurs).</p>


									<h4>Protection des données personnelles sur le site</h4>
									<p>
										Aucune donnée à caractère personnel n'est stockée sur ce site, qui respecte les règles suivantes :<br />
										- 1. Pas d’information collectée à l’insu de l’internaute,<br />
										- 2. Pas de cession à des tiers.
									</p>


									<h4>Droit d'auteur - Copyright</h4>
									<p>
										L'ensemble de ce site relève de la législation française et internationale sur le droit d'auteur et la propriété intellectuelle. Tous les droits de reproduction sont réservés, y compris pour les documents téléchargeables et les représentations iconographiques et photographiques.<br />
										En dehors de la carte téléchargeable au format PDF, réservée à un usage strictement personnel, la reproduction de tout ou partie de ce site sur un support quelconque, matériel ou immatériel, quel qu'il soit est formellement interdite sauf autorisation expresse du responsable de publication.
									</p>

									<h4>Fonctionnement</h4>
									<p>
										Pour toute remarque sur le fonctionnement du site, veuillez adresser un message au webmaster : <a href="mailto:duglantier@catalunapizz.fr">duglantier@catalunapizz.fr</a>
									</p>

									<h4>Conception et réalisation</h4>
									<p><a href="https://wildcodeschool.fr/orleans/" target="_blanc">WildCodeSchool Orléans</a></p>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								</div>
							</div>
						</div>
		  			</div>
		  		</div>

	  			<div class="col-xs-4"> <!-- liens Facebook et Tweeter -->
					<a href="https://fr-fr.facebook.com/catalunapizz/" target="_blanc"><img src="img/fb.png" alt="Lien vers page Facebook" /></a>
					&nbsp;&nbsp;&nbsp;
					<a href="https://twitter.com/catalunapizz?lang=fr" target="_blanc"><img src="img/twt.png" alt="Lien vers page Tweeter" /></a>
	 			</div>

			</footer>
		</div>

	</div>

<script src="https://code.jquery.com/jquery-3.1.1.min.js"
	integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" 
	crossorigin="anonymous"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>

