<?php
// --- delpizz.php ---

    $erreur = '';
    if (!empty($_POST['id'])) {
        $id = $_POST['id'];
        if ( is_numeric($id) && $id>0 ) {
            // --- connexion base de donnees
            include '../connect.php';
            $bdd = mysqli_connect(SERVEUR, USER, PASSE, DB) or die("Connexion DB impossible (code : " . mysqli_connect_errno() . " " . mysqli_connect_error() . ")");
            mysqli_set_charset($bdd, "utf8");

            if ( isset($_POST['btnsupp']) ) {
                // --- suppression tuple
                $sql = "DELETE FROM pizzas WHERE id=$id";
                $res = mysqli_query($bdd, $sql);
                header('Location: index.php');
            }
            else {
                // --- relecture des infos
                $sql = "SELECT nompizz, compo, prix29, prix33, pizztype FROM pizzas, pizzatypes WHERE id=$id AND pizzas.idtype=pizzatypes.idtype";
                $res = mysqli_query($bdd, $sql); // --- pas de gestion d'erreur (non trouve)
                $pizza = mysqli_fetch_assoc($res);
            }
        }
        else {
            $erreur = 'Identifiant invalide ('.$id.').';
        }
    }
    else {
        $erreur = 'Erreur transfert données (identifiant manquant)';
    }

$titreheader = 'Suppression pizza';
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
            echo $pizza['pizztype'].' : '.$pizza['nompizz'].'<br />';
            echo $pizza['compo'].'<br />';
            echo 'Prix 29 cm : '.number_format($pizza['prix29'],2,',',' ').' €<br />';
            echo 'Prix 33 cm : '.number_format($pizza['prix33'],2,',',' ').' €<br />';
            echo '<br /><br />';
            $btfin = 'Ne pas supprimer';
        }
    ?>
</div>
<form id="supprime" name="supprime" action="delpizz.php" method="post">
    <input type="hidden" name="id" value="<?php echo $id; ?>" />
</form>
<div class="col-xs-12 text-center">
    <a href="index.php" class="btn btn-success"><?php echo $btfin; ?></a>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

    <input form="supprime" class="btn btn-danger" type="submit" name="btnsupp" value="Supprimer" />
</div>



<?php include 'footer.php'; ?>


