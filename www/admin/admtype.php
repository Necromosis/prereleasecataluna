<?php
// ------------------------------------------
// --- admtype.php partie administration  ---
// --- administration des types de pizzas ---
// ------------------------------------------

// --- connexion base de donnees
include '../connect.php';
$bdd = mysqli_connect(SERVEUR, USER, PASSE, DB) or die("Connexion DB impossible (code : ".mysqli_connect_errno()." ".mysqli_connect_error().")");
mysqli_set_charset($bdd,"utf8");

// --- recup libelles types pizzas <<<<<<<<< bloc a mettre en commun avec index public >>>>>>>>>>>>>
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

$titreheader = "Types de pizzas";
?>


<?php include 'header.php'; ?> <!-- debut page html -->

<!-- note : la row est ouverte dans le header, et fermee dans le footer -->

<div class="col-xs-12 text-center titre"><?php echo $titreheader; ?></div>
<div class="col-xs-12 lignepizztype">
    <a href="../index.php" class="btn btn-success btn-xs" target="_blanc">Voir le site</a>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="index.php" class="btn btn-info btn-xs">Gérer les pizzas</a>
</div>
<div class="col-xs-12">&nbsp;</div> <!-- ligne vide --- -->
<div class="col-xs-12 lignepizztype"><a href="formtype.php" class="btn btn-danger btn-xs">Ajouter un type</a></div>

<?php
    // --- affichage de la liste des types
    for ( $i=1; $i<=count($pizzastypes); $i++ ) {
        $pizztype = $pizzastypes[$i];
        echo '<div class="col-xs-12 lignepizztype">';

            $clsupp = $clup = $cldn = '';

            // --- on affiche le bouton modification
            echo '
                <form id="modiftype'.$i.'" action="formtype.php" method="post">
                    <input type="hidden" name="idtype" value="'.$pizztype['idtype'].'" />
                </form>';

            // --- on affiche le bouton suppression si pas ou plus de pizzas dans cette rubrique
            echo '
                <form id="supptype'.$i.'" action="delpizztype.php" method="post">
                    <input type="hidden" name="idtype" value="'.$pizztype['idtype'].'" />
                </form>';
            // --- Note : le bouton est cree pour la mise en page, mais visible uniquement si utilisable
            if ( $pizztype['nbpizz'] > 0 || count($pizzastypes) <= 1 ) {
                $clsupp = ' voitpas';
            }


            // --- on affiche le bouton monter
            echo '
                <form id="uptype'.$i.'" action="uptype.php" method="post">
                    <input type="hidden" name="idtype" value="'.$pizztype['idtype'].'" />
               </form>';
            // --- Note : le bouton est cree pour la mise en page, mais visible uniquement si utilisable
            if ( $i == 1 || count($pizzastypes) <= 1 ) {
                $clup = ' voitpas';
            }

            // --- on affiche le bouton descendre
            echo '
                <form id="dntype'.$i.'" action="dntype.php" method="post">
                    <input type="hidden" name="idtype" value="'.$pizztype['idtype'].'" />
                </form>';
            // --- Note : le bouton est cree pour la mise en page, mais visible uniquement si utilisable
            if ( $i == count($pizzastypes) ) {
                $cldn = ' voitpas';
            }


            // --- on affiche les infos
            echo '<input form="supptype'.$i.'" class="btn btn-warning btn-xs'.$clsupp.'" type="submit" name="btnsupp" value="Supprimer" />';
            echo '&nbsp;&nbsp;&nbsp;&nbsp;';
            echo '<input form="modiftype'.$i.'" class="btn btn-default btn-xs" type="submit" name="btnmodif" value="Modifier" />';
            echo '&nbsp;&nbsp;&nbsp;&nbsp;';
            echo '<input form="uptype'.$i.'" class="btn btn-default btn-xs'.$clup.'" type="submit" name="btnmonte" value="Monter" />';
            echo '&nbsp;&nbsp;&nbsp;&nbsp;';
            echo '<input form="dntype'.$i.'" class="btn btn-default btn-xs'.$cldn.'" type="submit" name="btndescend" value="Descendre" />';
            echo '&nbsp;&nbsp;&nbsp;&nbsp;';

            echo '<span class="plusgros">'.$pizztype['pizztype'].'</span>';



        echo '</div>';
    }

?>

<?php include 'footer.php'; ?> <!-- fin de page html -->
