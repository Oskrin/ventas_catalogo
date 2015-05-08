<?php
include 'base.php';
conectarse();
$data = 0;
session_start();	
$sql = "update dias set lunes = '".$_POST['lunes']."', martes = '".$_POST['martes']."', miercoles = '".$_POST['miercoles']."', jueves = '".$_POST['jueves']."' ,viernes = '".$_POST['viernes']."' ,sabado = '".$_POST['sabado']."' ,domingo = '".$_POST['domingo']."' where id_dias = '1'";
if(pg_query($sql)){
	$data = '1';
}else{
	$data  = '0';
}
echo $data;

?>