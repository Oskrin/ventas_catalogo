<?php
include '../procesos/base.php';
conectarse();

$source_db="mantenimiento_inventario"; 
$new_db="db2"; 

//mysql_connect("localhost","root","");
//mysql_select_db($source_db);


$result = pg_query("show tables");
$table_names=array();

while($row=  pg_fetch_array($result)){
         $table_names[]=$row[0];
} 
pg_query("create database $new_db");
//mysql_select_db($new_db); 

for($i=0;$i<count($table_names);$i++){
pg_query("create table ".$table_names[$i]."
select * from $source_db.".$table_names[$i]);
} 
echo count($table_names)." tablas correctamente copiadas!";

?>
