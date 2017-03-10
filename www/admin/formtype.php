<?php
// --- formtype.php ---
// --- ajout ou modification de type de pizzas

include '../connect.php';
$bdd = mysqli_connect(SERVEUR, USER, PASSE, DB) or die("Connexion DB impossible (code : ".mysqli_connect_errno()." ".mysqli_connect_error().")");
mysqli_set_charset($bdd,"utf8");

// --- recuperation du nombre actuel de types
$sql = "SELECT * FROM pizzatypes";
$res = mysqli_query($bdd, $sql);
$ordreaff = mysqli_num_rows($res) + 1;

$txtbouton = 'Créer le type';
$pizztype = $txtbtn = '';
$idtype = 0;

if (isset($_GET['idtype'])) {
    $id = $_GET['idtype'];
    if ( is_numeric($idtype) && $idtype>0 ) {
        // --- il s'agit d'une modification de fiche, on lit les infos
        $sql = "SELECT * FROM pizzatypes WHERE idtype=$idtype";
        $res = mysqli_query($bdd, $sql);
        while($pizza = mysqli_fetch_assoc($res)) {
            $pizztype = $pizza['pizztype'];
            $txtbtn = $pizza['txtbtn'];
            $ordreaff = $pizza['ordreaff'];
        }
        $txtbouton = 'Enregistrer la modification';
        $titreheader = 'Modification type de pizzas';
    }

}
else {
    // --- il s'agit d'une creation
    $titreheader = 'Création type de pizzas';
}
if (!empty($_POST)) {
    // --- on relit les données en les sécurisant
    $idtype = mysqli_real_escape_string($bdd, htmlentities(trim($_POST['idtype'])));
    $pizztype = mysqli_real_escape_string($bdd, htmlentities(trim($_POST['pizztype'])));
    $txtbtn = mysqli_real_escape_string($bdd, htmlentities(trim($_POST['txtbtn'])));
    $ordreaff = mysqli_real_escape_string($bdd, htmlentities(trim($_POST['ordreaff'])));
    $titreheader = $_POST['titreheader'];
    // --- Controles de saisie
    $ok = true;
    $erreur = '';
    if ( strlen($pizztype) == 0 ) {
        $ok = false;
        $erreur = 'Erreur : nom du type de pizzas manquant.';
    }
    elseif ( strlen($txtbtn) == 0 ) {
        $ok = false;
        $erreur = 'Erreur : Info bouton manquante.';
    }
    if ( true === $ok ) {
        // --- il n'y a pas eu d'erreur
        if ( $id == 0 ) {
            // --- il s'agit d'un ajout
            $sql = "INSERT INTO pizzatypes (pizztype, txtbtn, ordreaff) VALUES ('$pizztype', '$txtbtn', $ordreaff)";
        }
        else {
            // --- il s'agit d'une modification
            $sql = "UPDATE pizzatypes SET pizztype='$pizztype', txtbtn='$txtbtn', ordreaff=$ordreaff WHERE idtype=$idtype";
        }
        mysqli_query($bdd, $sql); // --- pas de traitement d'erreur
        header('Location: admtype.php'); // --- on retourne a la liste
    }
}

?>

<?php include 'header.php'; ?>

<!-- container et row sont ouverts dans header, et fermes dans footer -->

<div class="col-xs-12 text-center titre"><?php echo $titreheader; ?></div>
<div class="col-xs-12 text-center erreur"><?php echo $erreur; ?></div>
<div class="col-xs-12 col-md-8 col-md-offset-2 form-group">
    <form id="edition" name="edition" action="formtype.php" method="post">
        <label for="pizztype">Nom du type de pizzas (telle qu'il apparaitra sur la carte)</label><br />
        <input id="pizztype" class="form-control" type="text" name="pizztype" value="<?php echo $pizztypz; ?>" /><br />
        <label for="txtbtn">Libellé du lien (barre de navigation)</label><br />
        <input id="txtbtn" class="form-control" type="text" name="txtbtn" value="<?php echo $txtbtn; ?>" /><br />
        <input type="hidden" name="idtype" value="<?php echo $idtype; ?>" /><br />
        <input type="hidden" name="ordreaff" value="<?php echo $ordreaff; ?>" /><br />
        <input type="hidden" name="titreheader" value="<?php echo $titreheader; ?>" />
    </form>
</div>
<div class="col-xs-12 col-md-8 col-md-offset-2">
    <a href="admtype.php" class="btn btn-default">Ne pas enregistrer</a>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input form="edition" class="btn btn-success" type="submit" name="action" value="<?php echo $txtbouton; ?>" />
</div>



<?php include 'footer.php'; ?>


