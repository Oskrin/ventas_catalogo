<?php

session_start();
include 'base.php';
conectarse();
$texto2 = $_GET['term'];
$consulta = pg_query("select * from clientes C where nombres_cli like '%$texto2%' and estado='Activo' and C.id_director='$_SESSION[id]'");
while ($row = pg_fetch_row($consulta)) {
    $data[] = array(
        'value' => $row[3],
        'id_cliente' => $row[0],
        'ruc_ci' => $row[2],
        'saldo' => $row[11]
    );
}
echo $data = json_encode($data);
?>