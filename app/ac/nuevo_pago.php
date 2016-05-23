<?
include("../includes/session.php");
include("../includes/db.php");
include("../includes/funciones.php");

extract($_POST);

//REVISAMOS Y CHECAMOS DATOS DEL TUTOR
if(!$id_alumno) exit("Selecciona un alumno");
if(!$id_tipo_pago) exit("Selecciona el tipo de pago");

if($id_tipo_pago==2){
	if(!$inicio) exit("Debe escribir una fecha de inicio");
	if(!$final) exit("Debe escribir una fecha de fin");
	
	$concepto="PAGO DE COLEGIATURA DEL ".$inicio." AL ".$final;
	
	$inicio = fechaBase($inicio);
	$final = fechaBase($final);
	
	if($final<$inicio) exit("La fecha final no puede ser menor a la fecha de inicio");
	
	$dias = (strtotime($final) - strtotime($inicio)) /24/3600;
	$dias++;
	
}else{
	if(!$concepto) exit("Debe escribir el concepto del pago.");
	$concepto=limpiaStr($concepto,1,1);	
}
if(!$monto) exit("Debe escribir el monto del pago recibido.");

$q = mysql_query("INSERT INTO pagos (id_alumno,id_tipo_pago,fecha_inicio,fecha_final,dias,monto,observacion,fecha_hora) VALUES ('$id_alumno','$id_tipo_pago','$inicio','$final','$dias','$monto','$concepto','$fechahora')");

if($q){
	echo "1";
}else{
	echo "Ocurrió un problema, intente nuevamente.";
}
?>