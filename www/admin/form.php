<?php
// --- form.php ---
// --- ajout ou modification de pizza

    include '../connect.php';
    $bdd = mysqli_connect(SERVEUR, USER, PASSE, DB) or die("Connexion DB impossible (code : ".mysqli_connect_errno()." ".mysqli_connect_error().")");
    mysqli_set_charset($bdd,"utf8");

    $txtbtn = 'Créer la pizza';
    $nompizz = $compo = '';
    $id = $prix29 = $prix33 = 0;
    $idtype = 1;

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        if ( is_numeric($id) && $id>0 ) {
            // --- il s'agit d'une modification de fiche, on lit les infos
            $sql = "SELECT * FROM pizzas WHERE id=$id";
            $res = mysqli_query($bdd, $sql);
            while($pizza = mysqli_fetch_assoc($res)) {
                $nompizz = $pizza['nompizz'];
                $compo = $pizza['compo'];
                $prix29 = $pizza['prix29'];
                $prix33 = $pizza['prix33'];
                $idtype = $pizza['idtype'];
            }
            $txtbtn = 'Enregistrer la modification';
            $titreheader = 'Modification pizza';
        }

    }
    else {
        // --- il s'agit d'une creation
        $titreheader = 'Création pizza';
    }
    if (!empty($_POST)) {
        // --- on relit les données en les sécurisant
        $id = mysqli_real_escape_string($bdd, htmlentities(trim($_POST['id'])));
        $nompizz = mysqli_real_escape_string($bdd, htmlentities(trim($_POST['nompizz'])));
        $compo = mysqli_real_escape_string($bdd, htmlentities(trim($_POST['compo'])));
        $prix29 = mysqli_real_escape_string($bdd, htmlentities(trim($_POST['prix29'])));
        $prix33 = mysqli_real_escape_string($bdd, htmlentities(trim($_POST['prix33'])));
        $idtype = mysqli_real_escape_string($bdd, htmlentities(trim($_POST['idtype'])));
        $titreheader = $_POST['titreheader'];
        $txtbtn = $_POST['txtbtn'];
        // --- Controles de saisie
        $ok = true;
        $erreur = '';
        if ( strlen($nompizz) == 0 ) {
            $ok = false;
            $erreur = 'Erreur : nom de la pizza manquant.';
        }
        elseif ( strlen($compo) == 0 ) {
            $ok = false;
            $erreur = 'Erreur : composition manquante.';
        }
        elseif ( preg_match('/[^0-9.]/', $prix29) ) {
            $ok = false;
            $erreur = 'Erreur : Caractère incorrect dans prix 29cm (chiffres et point uniquement).';
        }
        elseif ( $prix29 == 0 ) {
            $ok = false;
            $erreur = 'Erreur : Indiquer un prix non nul pour la pizza 29cm (chiffres et point uniquement).';
        }
        elseif ( preg_match('/[^0-9.]/', $prix33) ) {
            $ok = false;
            $erreur = 'Erreur : Caractère incorrect dans prix 33cm (chiffres et point uniquement).';
        }
        elseif ( $prix33 == 0 ) {
            $ok = false;
            $erreur = 'Erreur : Indiquer un prix non nul pour la pizza 33cm (chiffres et point uniquement).';
        }
        if ( true === $ok ) {
            // --- il n'y a pas eu d'erreur
            if ( $id == 0 ) {
                // --- il s'agit d'un ajout
                $sql = "INSERT INTO pizzas (nompizz, compo, prix29, prix33, idtype) VALUES ('$nompizz', '$compo', $prix29, $prix33, $idtype)";
            }
            else {
                // --- il s'agit d'une modification
                $sql = "UPDATE pizzas SET nompizz='$nompizz', compo='$compo', prix29=$prix29, prix33=$prix33, idtype=$idtype WHERE id=$id";
            }
            mysqli_query($bdd, $sql); // --- pas de traitement d'erreur
            header('Location: index.php'); // --- on retourne a la liste
        }
    }

?>

<?php include 'header.php'; ?>

<!-- container et row sont ouverts dans header, et fermes dans footer -->

<div class="col-xs-12 text-center titre"><?php echo $titreheader; ?></div>
<div class="col-xs-12 text-center erreur"><?php echo $erreur; ?></div>
<div class="col-xs-12 col-md-8 col-md-offset-2 form-group">
    <form id="edition" name="edition" action="form.php" method="post">
        <label for="idtype">Type de pizza</label><br />
        <select id="idtype" class="form-control" name="idtype">
            <?php
                // --- recuperation des types de pizzas
                $sql = "SELECT idtype, pizztype FROM pizzatypes";
                $res = mysqli_query($bdd, $sql);
                while ( $type = mysqli_fetch_assoc($res) ) {
                    echo '<option value="'.$type['idtype'].'"';
                    if ( $type['idtype'] == $idtype ) echo ' selected="selected"';
                    echo '>'.$type['pizztype'].'</option>';
                }
            ?>
        </select><br />
        <label for="nompizz">Nom de la pizza (telle qu'elle apparaitra sur la carte)</label><br />
        <input id="nompizz" class="form-control" type="text" name="nompizz" value="<?php echo $nompizz; ?>" /><br />
        <label for="compo">Composition</label><br />
        <input id="compo" class="form-control" type="text" name="compo" value="<?php echo $compo; ?>" /><br />
        <label for="prix29">Prix (€) de la pizza 29 cm (chiffres et point)</label><br />
        <input id="prix29" class="form-control" type="text" name="prix29" value="<?php echo $prix29; ?>" /><br />
        <label for="prix33">Prix (€) de la pizza 33 cm (chiffres et point)</label><br />
        <input id="prix33" class="form-control" type="text" name="prix33" value="<?php echo $prix33; ?>" /><br />
        <input type="hidden" name="id" value="<?php echo $id; ?>" /><br />
        <input type="hidden" name="titreheader" value="<?php echo $titreheader; ?>" />
        <input type="hidden" name="txtbtn" value="<?php echo $txtbtn; ?>" />
    </form>
</div>
<div class="col-xs-12 col-md-8 col-md-offset-2">
    <a href="index.php" class="btn btn-default">Ne pas enregistrer</a>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input form="edition" class="btn btn-success" type="submit" name="action" value="<?php echo $txtbtn; ?>" />
</div>



<?php include 'footer.php'; ?>


