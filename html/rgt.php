<?php

include '../conexion.php';
include '../funciones_generales.php';
$conexion = conectarse();
date_default_timezone_set('America/Guayaquil');
$fecha = date('Y-m-d H:i:s', time());
$fecha_larga = date('His', time());
$sql = "";
$id = unique($fecha_larga);


if ($_POST['oper'] == "add") {
    $sql = "insert into bodega values ('$id','$_POST[nombre_bodega]','$_POST[ubicacion_bodega]','1')";
    $guardar = guardarSql($conexion, $sql);
}

/* if($_GET['tipo'] == "g"){
  $repetidos = repetidos($conexion,"nombre_bodega",strtoupper($_POST["nombre_bodega"]),"bodega","g","","");
  if( $repetidos == 'true'){
  $data = 1; /// este dato ya existe;
  }else{




  }
  } */
?>