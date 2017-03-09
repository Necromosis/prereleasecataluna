<?php
    include 'connect.php';
    $bdd = mysqli_connect(SERVEUR, USER, PASSE, DB);
    mysqli_set_charset($bdd, "utf8");


    $qer = "SELECT nompizz, compo, prix29, prix33, idtype FROM pizzas WHERE id =".$_GET['id'].";";
    $rest = mysqli_query($bdd, $qer);
    $rowpizza = mysqli_fetch_assoc($rest);

?>

<div>
    <form action="action.php" method="post">

        <label>NOM :</label><br/>
        <input type="text" name="nompizz" value="<?php echo $rowpizza['nompizz']; ?>"/>

        <label>INGREDIENTS :</label><br>
        <input type="text" name="compo" value="<?php echo  $rowpizza['compo']; ?>" /><br />

        <label>Price 29 :</label>
        <input type="text" name="prix29" value="<?php echo number_format($rowpizza['prix29'],2); ?>" /><br />

        <label>Price 33 :</label>
        <input type="text" name="prix33" value="<?php echo  $rowpizza['prix33']; ?>" /><br />

        <label>Choose a categorie :</label><br>

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

        <input type="hidden" name='mode' value="edit" />
        <input type="hidden" name='id' value="<?php echo $_GET['id'];?>" />
        <input type="submit" name="edit" value="btn" />
        <br/><br/>

    </form>
</div>