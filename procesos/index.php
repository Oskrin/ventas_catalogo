<?php
//
//session_start();
//include 'base.php';
//conectarse();
//$data = "";
//$cont = 0;
//
//$contrasena = md5($_POST['clave']);
//
//$consulta = pg_query("select * from usuario where usuario='$_POST[usuario]' and clave='$contrasena'");
//while ($row = pg_fetch_row($consulta)) {
//    $cont = 1;
//    $_SESSION['id'] = $row[0];
//    $_SESSION['nombres'] = $row[1] . " " . $row[2];
//    $_SESSION['cargo'] = $row[6];
//    $_SESSION['user'] = $row[10];
//}
//
//$_SESSION['empresa'] = "P&S Systems";
//$_SESSION['slogan'] = "SERVICIOS INTEGRALES";
//$_SESSION['propietario'] = "YEPEZ RIVERA PABLO SANTIAGO";
//$_SESSION['direccion'] = "Av. Eugenio Espejo 9-66 y Juan Fransico Bonilla";
//$_SESSION['telefono'] = "2 603 - 193";
//$_SESSION['celular'] = "0987805075";
//$_SESSION['pais_ciudad'] = "Ibarra - Ecuador";
//
//if ($cont == 1) {
//    $data = 1;
//} else {
//    $data = 0;
//}
//
//echo $data;
?>




<?php

include 'base.php';
conectarse();
$data = "";
$cont = 0;
$contrasena = md5($_POST['clave']);
session_start();



$consulta = pg_query("select * from usuario where usuario='$_POST[usuario]' and clave='$contrasena'");
while ($row = pg_fetch_row($consulta)) {
    $cont = 1;
    $_SESSION['id'] = $row[0];
    $_SESSION['nombres'] = $row[1] . " " . $row[2];
    $_SESSION['cargo'] = $row[6];
    $_SESSION['user'] = $row[10];
    $_SESSION['id_empresa'] = $_POST['id_empresa'];
    $_SESSION['empresa'] = "P&S Systems";
//    $_SESSION['slogan'] = "SERVICIOS INTEGRALES";
//    $_SESSION['propietario'] = "YEPEZ RIVERA PABLO SANTIAGO";
//    $_SESSION['direccion'] = "Av. Eugenio Espejo 9-66 y Juan Fransico Bonilla";
//    $_SESSION['telefono'] = "2 603 - 193";
//    $_SESSION['celular'] = "0987805075";
//    $_SESSION['pais_ciudad'] = "Ibarra - Ecuador";
}

if ($cont == 1) {
    if ($_SESSION['cargo'] == 1) {
        $data = 1;
    } else {
        $data = 2;
    }
} else {
    $data = 0;
}

echo $data;
?>

