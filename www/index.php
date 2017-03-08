<?php
// ---------------------------------
// --- index.php partie publique ---
// ---------------------------------

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
        include 'navbar.php';
        include 'carousel.php';
    ?>

<!-- zone liste pizzas ---------------------------------- -->

    <div class="container-fluid">

        <div class="row"> <!-- zone pizzas 2 col -->
            <div class="col-xs-offset-1 col-xs-10">
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
        </div> <!-- fin zone pizzas -->

        <?php
            include 'supplement.php';
            include 'map.php';
            include 'qsn.php';
            include 'footer.php';
        ?>

    </div> <!-- fin container-fluid -->

    <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>

