<?php

session_start();
include 'base.php';
conectarse();
error_reporting(0);
$id = $_GET['id1'];
$arr_data = array();

$consulta = pg_query("select C.id_cliente,C.identificacion, C.nombres_cli, C.direccion_cli, C.telefono, C.correo, P.tipo_precio, D.nombres from proforma P, clientes C, directores D where P.id_cliente = C.id_cliente and P.estado='Activo' and C.id_director = D.id_director and P.id_proforma='" . $id . "'");
while ($row = pg_fetch_row($consulta)) {
    $arr_data[] = $row[0];
    $arr_data[] = $row[1];
    $arr_data[] = $row[2];
    $arr_data[] = $row[3];
    $arr_data[] = $row[4];
    $arr_data[] = $row[5];
    $arr_data[] = $row[6];
    $arr_data[] = $row[7];
}
echo json_encode($arr_data);
?>
