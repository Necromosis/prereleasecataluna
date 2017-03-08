<?php
// --- form.php ---
// --- ajout ou modification de pizza

    include '../connect.php';
    $bdd = mysqli_connect(SERVEUR, USER, PASSE, DB) or die("Connexion DB impossible (code : ".mysqli_connect_errno()." ".mysqli_connect_error().")");
    mysqli_set_charset($bdd,"utf8");

    $txtbtn = 'Créer';
    $nompizz = $compo = '';
    $id = $prix29 = prix33 = 0;
    $idtype = 1;
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        if ( is_numeric($id) && $id>0 ) {
            // --- il s'agit d'une modification de fiche, on lit les infos
            $sql = "SELECT * FROM pizzas WHERE id=$id";
            $res = mysqli_query($bdd, $res);
            while($data = mysqli_fetch_assoc($res)) {
                $nompizz = $data['nompizz'];
                $compo = $data['compo'];
                $prix29 = $data['prix29'];
                $prix33 = $data['prix33'];
                $idtype = $data['idtype'];
            }
            $txtbtn = 'Modifier';
            $titreheader = 'Modification pizza';
        }

    }
    else {
        // --- il s'agit d'une creation
        $titreheader = 'Création pizza';
    }
    if (!empty($_POST)) {
        foreach ($_POST as $key => $value) {
            $postclean[$key] = mysqli_real_escape_string($bdd, htmlentities(trim($value)));
        }
        // --- Controles de saisie
        $ok = true;
        $erreur = '';
        if ( strlen($postclean['nompizz']) == 0 ) {
            $ok = false;
            $erreur = 'Erreur : nom de la pizza manquant.';
        } elseif ( strlen($postclean['compo']) == 0 ) {
            $ok = false;
            $erreur = 'Erreur : composition manquante.';
        } elseif ( true === preg_match('/[^0-9.]/', $postclean['prix29']) ) {
            $ok = false;
            $erreur = 'Erreur : Caractère incorrect dans prix 29cm (chiffres et point uniquement).';
        } elseif ( true === preg_match('/[^0-9.]/', $postclean['prix33']) ) {
            $ok = false;
            $erreur = 'Erreur : Caractère incorrect dans prix 33cm (chiffres et point uniquement).';
        }
        if ( true === $ok ) {
            // --- il n'y a pas eu d'erreur
            if ( $id == 0 ) {
                // --- il s'agit d'un ajout
                $sql = "INSERT INTO pizzas (nompizz, compo, prix29, prix33, idtype) ";
                $sql .= "VALUES ('" . $postclean['nompizz'] . "', '" . $postclean['compo'] . "', " . $postclean['prix29'] . ", " . $postclean['prix33'] . ", " . $postclean['idtype'] . ")";
            }
            else {
                // --- il s'agit d'une modification
                $sql = "UPDATE pizzas SET nompizz='" . $postclean['nompizz'] . "', compo='" . $postclean['compo'] . "', prix29=" . $postclean['prix29'] . ",";
                $sql .= " prix33=" . $postclean['prix33'] . ", idtype=" . $postclean['idtype'] . " WHERE id=$id";
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
<div class="col-xs-12 text-center">
    <form id="edition" name="edition" action="form.php" method="post">

        <select name="idtype">
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
        </select>

        <input type="text" name="nompizz" value="<?php echo $nompizz; ?>" /><br />
        <br />
        <input type="text" name="compo" value="<?php echo $compo; ?>" /><br />
        <br />
        <input type="text" name="prix29" value="<?php echo $prix29; ?>" /><br />
        <br />
        <input type="text" name="prix33" value="<?php echo $prix33; ?>" /><br />
        <br />
        <input type="hidden" name="id" value="<?php echo $id; ?>" /><br />
    </form>
</div>
<div class="col-xs-12 text-center">
    <a href="index.php" class="btn btn-default">Annuler</a>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

    <input form="edition" class="btn btn-success" type="submit" name="action" value="<?php echo $txtbtn; ?>" />
</div>



<?php include 'footer.php'; ?>


