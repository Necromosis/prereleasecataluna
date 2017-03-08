<?php
    // ---------------------------------------
    // --- index.php partie adlinistration ---
    // ---------------------------------------

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

$titreheader = "Carte des pizzas";
?>


<?php include 'header.php'; ?> <!-- debut page html -->

<!-- note : la row est ouverte dans le header, et fermee dans le footer -->

    <div class="col-xs-12 text-center titre">Carte des pizzas</div>
    <div class="col-xs-12 bouton"><a href="form.php" class="btn btn-danger btn-xs">Ajouter une pizza</a></div>

    <?php
        // --- affichage de la liste des pizzas par type de pizza
        foreach ( $pizzastypes as $pizztype ) {
            // --- on affiche le type de pizza
            echo '<div class="col-xs-12 pizztype">' . $pizztype['pizztype'] . ' ('.$pizztype['nbpizz'].' pizzas)</div>';

            // --- on recupere la liste des pizzas concernees
            $sql = "SELECT id, nompizz, compo, prix29, prix33 FROM pizzas WHERE idtype=" . $pizztype['idtype'];
            $res = mysqli_query($bdd, $sql);

            // --- on affiche la liste
            while ($pizza = mysqli_fetch_assoc($res)) {
                echo '<div class="col-xs-12 lignepizz">';
                    echo '<div class="infos">';
                        echo '<a href="form.php?id='.$pizza['id'].'"><img src="img/modif.png" alt="bouton modification" /></a>';
                        echo '&nbsp;&nbsp;&nbsp;&nbsp;';
                        echo '<img class="pointer" src="img/supp.png" alt="bouton suppression" onclick="envoieForm('.$pizza['id'].');" />';
                        echo '&nbsp;&nbsp;&nbsp;&nbsp;';
                        echo '<span class="plusgros">' . $pizza['nompizz'] . '</span> (' . $pizza['compo'] . ') - ';
                        echo '29 cm : <span class="plusgros">' . number_format($pizza['prix29'], 2, ',', ' ') . ' €</span> - ';
                        echo '33 cm : <span class="plusgros">' . number_format($pizza['prix33'], 2, ',', ' ') . ' €</span>';
                    echo '</div>';
                echo '</div>';
            }
            echo '<div class="col-xs-12 bouton"><a href="form.php" class="btn btn-danger btn-xs">Ajouter une pizza</a></div>';
       }
    ?>

    <form id="delpizz" action="delpizz.php" method="post">
        <input type="hidden" id="id" name="id" value="" />
    </form>
    <script>
        function envoieForm(id) {
            document.getElementById('id').value = id;
            document.getElementById('delpizz').submit();
        }
    </script>

<?php include 'footer.php'; ?> <!-- fin de page html -->
