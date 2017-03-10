<?php
// ------------------------------------------
// --- uptype.php partie administration   ---
// --- administration des types de pizzas ---
// ------------------------------------------

// --- connexion base de donnees
include '../connect.php';
$bdd = mysqli_connect(SERVEUR, USER, PASSE, DB) or die("Connexion DB impossible (code : ".mysqli_connect_errno()." ".mysqli_connect_error().")");
mysqli_set_charset($bdd,"utf8");

if (isset($_POST['idtype'])) {
    $idtype = $_POST['idtype'];
    // --- on recupere les infos
    $sql = "SELECT * FROM pizzatypes WHERE idtype=$idtype";
    $res = mysqli_query($bdd, $sql);
    if ( mysqli_num_rows($res) == 1 ) { // si le tuple existe
        $pizztype = mysqli_fetch_assoc($res);
        $ordreaff = $pizztype['ordreaff'];
        // --- il faut switcher l'ordre entre ce tuple et celui qui porte l'ordre-1
        // --- on recupere donc l'id du tuple avec lequel faire l'echange
        $sql = "SELECT * FROM pizzatypes WHERE ordreaff=".($ordreaff-1);
        $res = mysqli_query($bdd, $sql); // pas de gestion d'erreur
        $pizztype = mysqli_fetch_assoc($res);
        $idtype2 = $pizztype['idtype'];
        // --- mise a jour de celle que l'on descend (idtype2)
        $sql = "UPDATE pizzatypes SET ordreaff=$ordreaff WHERE idtype=$idtype2";
        $res = mysqli_query($bdd, $sql); // pas de gestion d'erreur
        // --- mise a jour de celle que l'on remonte (idtype)
        $sql = "UPDATE pizzatypes SET ordreaff=".($ordreaff-1)." WHERE idtype=$idtype";
        $res = mysqli_query($bdd, $sql); // pas de gestion d'erreur
    }

}

// --- on rentre a la maison
header('Location: admtype.php');

?>