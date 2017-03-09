<?php
    include 'connect.php';
    $bdd = mysqli_connect(SERVEUR, USER, PASSE, DB);
    mysqli_set_charset($bdd, "utf8");

?>

<div>
    <form action="action.php" method="post">

        <label>NOM :</label><br>
            <?php echo "<input type='text' name='nompizz' value='$nompizz'<br>"; ?>

        <label>INGREDIENTS :</label><br>
            <?php echo "<input type='text' name='compo' value='$compo'<br><br>"; ?>

        <label>Price 29 :</label>
            <?php echo "<input type='text' name='prix29' placeholder='0.00' value='$prix29'<br>"; ?>

        <label>Price 33 :</label>
            <?php echo "<input type='text' name='prix33' placeholder='0.00' value='$prix33'<br>"; ?>

        <label>Choose a categorie :</label><br>


        <select name="idtype">
            <?php
            $sql = "SELECT idtype, pizztype FROM pizzatypes";
            $res = mysqli_query($bdd, $sql);
            while ( $type = mysqli_fetch_assoc($res) ) {
                echo '<option value="'.$type['idtype'].'"';
                if ( $type['idtype'] == $idtype ) echo ' selected="selected"';
                echo '>'.$type['pizztype'].'</option>';
            }
            ?>
        </select>


        <input type="hidden" name='mode' value="create">
        <input type="submit" name="submit">
        <br><br>

    </form>
</div>

