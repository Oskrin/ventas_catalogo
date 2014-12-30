<?php

session_start();
include 'base.php';
conectarse();
error_reporting(0);

///////////////////contador clientes////////////////////////
$cont = 0;
$consulta = pg_query("select max(id_director) from directores");
while ($row = pg_fetch_row($consulta)) {
    $cont = $row[0];
}
$cont++;
/////////////////////////////////////////////////////////

if (pg_query("insert into directores values('$cont','$_POST[ruc_ci]','" . strtoupper($_POST[nombres_cli]) . "','$_POST[direccion_cli]','$_POST[nro_telefono]','$_POST[nro_celular]','" . strtoupper($_POST[pais_cli]) . "','" . strtoupper($_POST[ciudad_cli]) . "','$_POST[email]','Activo')")) {
    $data = 1;
}

echo $data;
?>
