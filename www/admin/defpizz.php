<?php
// --- defpizz.php ---
// --- ajout ou modification de pizza

    // --- connexion database
    include '../connect.php';
    $bdd = mysqli_connect(SERVEUR, USER, PASSE, DB) or die("Connexion DB impossible (code : ".mysqli_connect_errno()." ".mysqli_connect_error().")");
    mysqli_set_charset($bdd,"utf8");


    if ( isset($_POST['id']) ) {
        // --- on est deja passe dans cette page, on y revient pour traitement sql

echo '>>>>> 1 >>>>> post id >'.$_POST['id'].'<<br />';

        if ( $_POST['erreur'] =! '' ) {
            // --- on revient dans cette page suite a une erreur detectee dans la saisie

echo '>>>>> 2 >>>>> post erreur >'.$_POST['erreur'].'<<br />';

        }
        /*
        else {
            // --- pas d'erreur detectee dans la saisie, on peut traiter la fiche
            // --- on securise les donnees collectees
            $id = mysqli_real_escape_string($bdd, htmlentities(trim($_POST['id'])));
            $nompizz = mysqli_real_escape_string($bdd, htmlentities(trim($_POST['nompizz'])));
            $compo = mysqli_real_escape_string($bdd, htmlentities(trim($_POST['nompizz'])));
            $prix29 = mysqli_real_escape_string($bdd, htmlentities(trim($_POST['nompizz'])));
            $prix33 = mysqli_real_escape_string($bdd, htmlentities(trim($_POST['nompizz'])));
            $idtype = mysqli_real_escape_string($bdd, htmlentities(trim($_POST['nompizz'])));
            $erreur = mysqli_real_escape_string($bdd, htmlentities(trim($_POST['erreur'])));

            echo '>'.$id.'< >'.$erreur.'< >'.$nompizz.'< >'.prix29.'< >'.prix33.'<';

            if ( $secupizz['id'] == 0] ) {
                // --- il s'agit d'une creation
                $sql = "INSERT INTO pizzas (nompizz, compo, prix29, prix33, idtype) ";
                $sql .= "VALUES ('".$secupizz['nompizz']."', '".$secupizz['compo']."',".$secupizz['prix29'].",".$secupizz['prix33'].",".$secupizz['idtype'].")";

                echo $sql;

            }
            else {
                // --- il s'agit d'une mise a jour

            }
            // --- on execute la requete
            $res = mysqli_query($bdd, $sql);
            // --- et on se barre de la (retour liste)
            header('Location: index.php');
        }
        */
    }
    else {
        // --- première entree dans cette page
        if ( isset($_GET['id']) ) {
            // --- il s'agit d'une demande de modification

echo '>>>>> 10 >>>>> get id >'.$_GET['id'].'<<br />';


        }
        else {
            // --- il s'agit d'une creation
            // --- on initialise les variables
            $txtbtn = 'Créer la pizza';
            $nompizz = $compo = '';
            $id = $prix29 = $prix33 = 0;
            $idtype = 1;
            $erreur='';
        }
    }
    // --- on passe a l'affichage du formulaire (html ci-dessous)

$erreur = '';
?>





<?php include 'header.php'; ?>

<!-- container et row sont ouverts dans header, et fermes dans footer -->

<div class="col-xs-12 text-center titre"><?php echo $titreheader; ?></div>
<div class="col-xs-12 text-center erreur"><?php echo $erreur; ?></div>
<div class="col-xs-12 text-center">

    <form id="edition" name="edition" action="defpizz.php" method="post">
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
        </select><br />
        <br />
        <input type="text" name="nompizz" value="<?php echo $nompizz; ?>" /><br />
        <br />
        <input type="text" name="compo" value="<?php echo $compo; ?>" /><br />
        <br />
        <input type="text" name="prix29" value="<?php echo number_format($prix29,2,',',' '); ?>" /> €<br />
        <br />
        <input type="text" name="prix33" value="<?php echo number_format($prix33,2,',',' '); ?>" /> €<br />
        <br />
        <input type="hidden" name="id" value="<?php echo $id; ?>" /><br />
        <input type="hidden" name="erreur" value="<?php echo $erreur; ?>" />
    </form>

    <script>console.log('><?php echo $erreur; ?><');</script>

    <?php echo '>'.$erreur.'<'; ?>

</div>
<div class="col-xs-12 text-center">
    <a href="index.php" class="btn btn-default">Annuler</a>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

    <input form="edition" class="btn btn-success" type="submit" name="action" value="<?php echo $txtbtn; ?>" />
</div>



<?php include 'footer.php'; ?>

