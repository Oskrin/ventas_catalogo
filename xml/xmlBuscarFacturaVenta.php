<?php

session_start();
include '../procesos/base.php';
$page = $_GET['page'];
$limit = $_GET['rows'];
$sidx = $_GET['sidx'];
$sord = $_GET['sord'];
$search = $_GET['_search'];

if (!$sidx)
    $sidx = 1;
$result = pg_query("SELECT COUNT(*) AS count from factura_venta, clientes ,usuario where factura_venta.id_cliente=clientes.id_cliente and factura_venta.id_usuario=usuario.id_usuario");
$row = pg_fetch_row($result);
$count = $row[0];
if ($count > 0 && $limit > 0) {
    $total_pages = ceil($count / $limit);
} else {
    $total_pages = 0;
}
if ($page > $total_pages)
    $page = $total_pages;
$start = $limit * $page - $limit;
if ($start < 0)
    $start = 0;
if ($search == 'false') {
    $SQL = "select F.id_factura_venta, C.identificacion, C.nombres_cli, F.num_factura, F.total_venta, F.fecha_actual, D.nombres from factura_venta F, clientes C, directores D  where F.id_cliente = C.id_cliente and C.id_director = D.id_director ORDER BY $sidx $sord offset $start limit $limit";
} else {
    if ($_GET['searchOper'] == 'eq') {
        $SQL = "select F.id_factura_venta, C.identificacion, C.nombres_cli, F.num_factura, F.total_venta, F.fecha_actual, D.nombres from factura_venta F, clientes C, directores D  where F.id_cliente = C.id_cliente and C.id_director = D.id_director $_GET[searchField] = '$_GET[searchString]' ORDER BY $sidx $sord offset $start limit $limit";
    }
    if ($_GET['searchOper'] == 'ne') {
        $SQL = "select F.id_factura_venta, C.identificacion, C.nombres_cli, F.num_factura, F.total_venta, F.fecha_actual, D.nombres from factura_venta F, clientes C, directores D  where F.id_cliente = C.id_cliente and C.id_director = D.id_director $_GET[searchField] != '$_GET[searchString]' ORDER BY $sidx $sord offset $start limit $limit";
    }
    if ($_GET['searchOper'] == 'bw') {
        $SQL = "select F.id_factura_venta, C.identificacion, C.nombres_cli, F.num_factura, F.total_venta, F.fecha_actual, D.nombres from factura_venta F, clientes C, directores D  where F.id_cliente = C.id_cliente and C.id_director = D.id_director $_GET[searchField] like '$_GET[searchString]%' ORDER BY $sidx $sord offset $start limit $limit";
    }
    if ($_GET['searchOper'] == 'bn') {
        $SQL = "select F.id_factura_venta, C.identificacion, C.nombres_cli, F.num_factura, F.total_venta, F.fecha_actual, D.nombres from factura_venta F, clientes C, directores D  where F.id_cliente = C.id_cliente and C.id_director = D.id_director $_GET[searchField] not like '$_GET[searchString]%' ORDER BY $sidx $sord offset $start limit $limit";
    }
    if ($_GET['searchOper'] == 'ew') {
        $SQL = "select F.id_factura_venta, C.identificacion, C.nombres_cli, F.num_factura, F.total_venta, F.fecha_actual, D.nombres from factura_venta F, clientes C, directores D  where F.id_cliente = C.id_cliente and C.id_director = D.id_director $_GET[searchField] like '%$_GET[searchString]' ORDER BY $sidx $sord offset $start limit $limit";
    }
    if ($_GET['searchOper'] == 'en') {
        $SQL = "select F.id_factura_venta, C.identificacion, C.nombres_cli, F.num_factura, F.total_venta, F.fecha_actual, D.nombres from factura_venta F, clientes C, directores D  where F.id_cliente = C.id_cliente and C.id_director = D.id_director $_GET[searchField] not like '%$_GET[searchString]' ORDER BY $sidx $sord offset $start limit $limit";
    }
    if ($_GET['searchOper'] == 'cn') {
        $SQL = "select F.id_factura_venta, C.identificacion, C.nombres_cli, F.num_factura, F.total_venta, F.fecha_actual, D.nombres from factura_venta F, clientes C, directores D  where F.id_cliente = C.id_cliente and C.id_director = D.id_director $_GET[searchField] like '%$_GET[searchString]%' ORDER BY $sidx $sord offset $start limit $limit";
    }
    if ($_GET['searchOper'] == 'nc') {
        $SQL = "select F.id_factura_venta, C.identificacion, C.nombres_cli, F.num_factura, F.total_venta, F.fecha_actual, D.nombres from factura_venta F, clientes C, directores D  where F.id_cliente = C.id_cliente and C.id_director = D.id_director $_GET[searchField] not like '%$_GET[searchString]%' ORDER BY $sidx $sord offset $start limit $limit";
    }
    if ($_GET['searchOper'] == 'in') {
        $SQL = "select F.id_factura_venta, C.identificacion, C.nombres_cli, F.num_factura, F.total_venta, F.fecha_actual, D.nombres from factura_venta F, clientes C, directores D  where F.id_cliente = C.id_cliente and C.id_director = D.id_director $_GET[searchField] like '%$_GET[searchString]%' ORDER BY $sidx $sord offset $start limit $limit";
    }
    if ($_GET['searchOper'] == 'ni') {
        $SQL = "select F.id_factura_venta, C.identificacion, C.nombres_cli, F.num_factura, F.total_venta, F.fecha_actual, D.nombres from factura_venta F, clientes C, directores D  where F.id_cliente = C.id_cliente and C.id_director = D.id_director $_GET[searchField] not like '%$_GET[searchString]%' ORDER BY $sidx $sord offset $start limit $limit";
    }
    //echo $SQL;
}
$result = pg_query($SQL);
header("Content-type: text/xml;charset=utf-8");
$s = "<?xml version='1.0' encoding='utf-8'?>";
$s .= "<rows>";
$s .= "<page>" . $page . "</page>";
$s .= "<total>" . $total_pages . "</total>";
$s .= "<records>" . $count . "</records>";
while ($row = pg_fetch_row($result)) {
    $s .= "<row id='" . $row[0] . "'>";
    $s .= "<cell>" . $row[0] . "</cell>";
    $s .= "<cell>" . $row[1] . "</cell>";
    $s .= "<cell>" . $row[2] . "</cell>";
    $s .= "<cell>" . $row[3] . "</cell>";
    $s .= "<cell>" . $row[4] . "</cell>";
    $s .= "<cell>" . $row[5] . "</cell>";
    $s .= "<cell>" . $row[6] . "</cell>";
    $s .= "</row>";
}
$s .= "</rows>";
echo $s;
?>
