<?php

session_start();
include 'base.php';
conectarse();
error_reporting(0);

/////////////contador productos//////////
$cont = 0;
$consulta = pg_query("select max(cod_productos) from productos");
while ($row = pg_fetch_row($consulta)) {
    $cont = $row[0];
}
$cont++;
////////////////////////////////////////
/////////////contador kardex//////////
$cont1 = 0;
$consulta2 = pg_query("select max(cod_productos) from productos");
while ($row = pg_fetch_row($consulta2)) {
    $cont1 = $row[0];
}
$cont1++;
////////////////////////////////////////
///////////////valores imagen//////////
$extension = explode(".", $_FILES["archivo"]["name"]);

$extension = end($extension);
$type = $_FILES["archivo"]["type"];
$tmp_name = $_FILES["archivo"]["tmp_name"];
$size = $_FILES["archivo"]["size"];
$nombre = basename($_FILES["archivo"]["name"], "." . $extension);
//$fecha = date("d-m-Y");
//////////////////////////

if ($nombre == "") {
    /////////////////guardar productos///////
    $valor = number_format($_POST['precio_compra'], 2, '.', '');
    $valor2 = number_format($_POST['precio_minorista'], 2, '.', '');
    $valor3 = number_format($_POST['precio_mayorista'], 2, '.', '');
    pg_query("insert into productos values('$cont','$_POST[cod_prod]','$_POST[cod_barras]','" . strtoupper($_POST['nombre_art']) . "','$_POST[iva]','$_POST[series]','$valor','$_POST[utilidad_minorista]','$_POST[utilidad_mayorista]','$valor2','$valor3','$_POST[categoria]','$_POST[marca]','$_POST[stock]','$_POST[minimo]','$_POST[maximo]','$_POST[fecha_creacion]','$_POST[modelo]','$_POST[aplicacion]','$_POST[descuento]','$_POST[vendible]','$_POST[inventario]','','','')");
} else {
    /////////////////guardar productos///////
    $foto = $cont . '.' . $extension;
    $valor = number_format($_POST['precio_compra'], 2, '.', '');
    $valor2 = number_format($_POST['precio_minorista'], 2, '.', '');
    $valor3 = number_format($_POST['precio_mayorista'], 2, '.', '');
    move_uploaded_file($_FILES["archivo"]["tmp_name"], "../fotos_productos/" . $foto);
    pg_query("insert into productos values('$cont','$_POST[cod_prod]','$_POST[cod_barras]','" . strtoupper($_POST['nombre_art']) . "','$_POST[iva]','$_POST[series]','$valor','$_POST[utilidad_minorista]','$_POST[utilidad_mayorista]','$valor2','$valor3','$_POST[categoria]','$_POST[marca]','$_POST[stock]','$_POST[minimo]','$_POST[maximo]','$_POST[fecha_creacion]','$_POST[modelo]','$_POST[aplicacion]','$_POST[descuento]','$_POST[vendible]','$_POST[inventario]','','','$foto')");
}

$data = 1;
echo $data;
?>
