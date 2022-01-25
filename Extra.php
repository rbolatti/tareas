<?php

include("Classes/CConection.php");


$consulta=<<<SQL
SELECT * FROM `tareascargadas` WHERE `Asignador`='pazs' 
SQL;
$setRec =mysqli_query($connect,$consulta);

$columnHeader = ''; 
$columnHeader = "id" . "\t" . "Fecha" . "\t" . "Asignador" . "\t" . "TituloTarea" . "\t" . "Descripcion" . "\t". "Asignado" . "\t" . "FechaLimite" . "\t". "Vencida" . "\t" . "Terminada" . "\t"; 
$setData = ''; 
while ($rec = mysqli_fetch_row($setRec)) { 
$rowData = ''; 
foreach ($rec as $value) { 
$value = '"' . $value . '"' . "\t"; 
$rowData .= $value; 
} 
$setData .= trim($rowData) . "\n"; 
} 
header("Content-type: application/octet-stream"); 
header("Content-Disposition: attachment; filename=User_Detail.xls"); 
header("Pragma: no-cache"); 
header("Expires: 0"); 
echo ucwords($columnHeader) . "\n" . $setData . "\n"; 


?>