<?php
    include 'connect.php';
    $bdd = mysqli_connect(SERVEUR, USER, PASSE, DB);
    mysqli_set_charset($bdd, "utf8");


switch ($_POST['mode']) {
        case "create":
            creation($bdd);
            break;
        case "edit":
            edit($bdd,$_POST['id']);
            break;
        case "delete":
            delete($bdd,$_POST['id']);
            break;
        default:
            '';
            break;
    }
    //reroot sur edit
    if(!empty($_GET['id'])){
        header("Location: edit.php?id=".$_GET['id']);
    }
function creation($bdd)
{
    $nompizz = $_POST['nompizz'];
    $compo = $_POST['compo'];
    $prix29 = $_POST['prix29'];
    $prix33 = $_POST['prix33'];
    $idtype = $_POST['idtype'];

    $qer = "INSERT INTO pizzas (nompizz, compo, prix29, prix33, idtype) VALUES ('$nompizz','$compo','$prix29','$prix33','$idtype');";
    mysqli_query($bdd, $qer);
    header("Location: admin/index.php");
}
function edit($bdd,$id)
{
    $nompizz = $_POST['nompizz'];
    $compo = $_POST['compo'];
    $prix29 = $_POST['prix29'];
    $prix33 = $_POST['prix33'];
    $idtype = $_POST['idtype'];

    $qer = "UPDATE pizzas SET nompizz='$nompizz', compo='$compo', prix29=$prix29, prix33=$prix33, idtype=$idtype WHERE id = $id;";
    mysqli_query($bdd, $qer);
    header("Location: admin/index.php");
}
function delete($bdd,$id)
{
    $qer = "DELETE FROM pizzas WHERE id=$id;";
    mysqli_query($bdd, $qer);
    echo $qer;
    header("Location: admin/index.php");
}

?>