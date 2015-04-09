<?php

session_start();
include 'base.php';
conectarse();
$texto2 = $_GET['term'];
$consulta = pg_query("select * from clientes C where identificacion like '%$texto2%' and estado='Activo' and C.id_director='$_SESSION[id]'");
while ($row = pg_fetch_row($consulta)) {
    $data[] = array(
        'value' => $row[2],
        'id_cliente' => $row[0],
        'nombres_completos' => $row[3],
        'saldo' => $row[11]
    );
}
echo $data = json_encode($data);
?>