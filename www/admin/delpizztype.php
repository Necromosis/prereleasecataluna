<?php
// --- delpizztype.php ---

$erreur = '';
if (!empty($_POST['idtype'])) {
    $idtype = $_POST['idtype'];
    if ( is_numeric($idtype) && $idtype>0 ) {
        // --- connexion base de donnees
        include '../connect.php';
        $bdd = mysqli_connect(SERVEUR, USER, PASSE, DB) or die("Connexion DB impossible (code : " . mysqli_connect_errno() . " " . mysqli_connect_error() . ")");
        mysqli_set_charset($bdd, "utf8");

        if ( isset($_POST['btnsupp']) ) {
            // --- suppression tuple
            $sql = "DELETE FROM pizzatypes WHERE idtype=$idtype";
            $res = mysqli_query($bdd, $sql);
            header('Location: admtype.php');
        }
        else {
            // --- relecture des infos
            $sql = "SELECT pizztype, txtbtn FROM pizzatypes WHERE idtype=$idtype";
            $res = mysqli_query($bdd, $sql); // --- pas de gestion d'erreur (non trouve)
            $pizztype = mysqli_fetch_assoc($res);
        }
    }
    else {
        $erreur = 'Identifiant invalide ('.$id.').';
    }
}
else {
    $erreur = 'Erreur transfert données (identifiant manquant)';
}

$titreheader = 'Suppression type de pizza';
?>

<?php include 'header.php'; ?>

<!-- container et row sont ouverts dans header, et fermes dans footer -->

<div class="col-xs-12 text-center titre"><?php echo $titreheader; ?></div>
<div class="col-xs-12 text-center decrit">
    <?php
    if ( $erreur != '' ) {
        echo '<br /><br />';
        echo '<span class="plusgros">ERREUR : </span>'.$erreur;
        echo '<br /><br />';
        $btfin = 'Retour à la liste';
    }
    else {
        echo '<br /><br />';
        echo '<span class="plusgros">'.$pizztype['pizztype'].'</span><br />';
        echo '<br /><br />';
        $btfin = 'Ne pas supprimer';
    }
    ?>
</div>
<form id="supprime" name="supprime" action="delpizztype.php" method="post">
    <input type="hidden" name="idtype" value="<?php echo $idtype; ?>" />
</form>
<div class="col-xs-12 text-center">
    <a href="admtype.php" class="btn btn-success"><?php echo $btfin; ?></a>
    <input form="supprime" class="btn btn-danger" type="submit" name="btnsupp" value="Supprimer" />
</div>



<?php include 'footer.php'; ?>


