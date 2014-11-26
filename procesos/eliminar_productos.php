<?php

session_start();
include 'base.php';
conectarse();
error_reporting(0);
$data = 0;
$cont = 0;

////////////////////contadores///////////////

$consulta = pg_query("select * from clientes C, factura_venta F where C.id_cliente = F.id_cliente and F.id_cliente = '$_POST[id_cliente]'");
while ($row = pg_fetch_row($consulta)) {
    $cont++;
}

if ($cont == 0) {
    pg_query("Update productos Set estado='Pasivo' where cod_productos='$_POST[cod_productos]'");
    $data = 0;
} else {
    $data = 1;
}

echo $data;
?>