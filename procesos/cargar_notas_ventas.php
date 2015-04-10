<?php

session_start();
include 'base.php';
conectarse();
error_reporting(0);
$consulta = pg_query("select id_facturas_novalidas,comprobante from facturas_novalidas where id_cliente = '".$_GET['id']."'");
if(pg_num_rows($consulta)){
	while ($row = pg_fetch_row($consulta)) {    
		echo "<option id='$row[0]' value='$row[0]'> $row[0]</option>";
	}	
}else{
	echo "<option id='' value=''> Sin resultados </option>";
}

?>
