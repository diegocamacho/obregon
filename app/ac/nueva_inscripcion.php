<?
include("../includes/session.php");
include("../includes/db.php");
include("../includes/funciones.php");

extract($_POST);

//REVISAMOS Y CHECAMOS DATOS DEL TUTOR
if(!$nombre) exit("No escribío el nombre del tutor");
$nombre=limpiaStr($nombre,1,1);
if(!$telefono1) exit("No coloco el número de celular");
if(!escapar($telefono1,1) || strlen($telefono1)<10) exit("El número celular que colocó no es válido");
if(!$telefono2) exit("No coloco el teléfono de casa");
if(!escapar($telefono2,1)) exit("El teléfono de casa que colocó no es válido");
//if(!$telefono3) exit("No coloco el teléfono de oficina");
//if(!escapar($telefono3,1)) exit("El número celular que colocó no es válido");
if(!$direccion) exit("No escribío la dirección del tutor");
$direccion=limpiaStr($direccion,1,1);
if(!$parentesco) exit("No escribío el parentesco del tutor");
$parentesco=limpiaStr($parentesco,1,1);
if(!$email) exit("No escribío el email del tutor");
if(!validarEmail($email)) exit("El email que escríbio no es válido");
$condiciones=limpiaStr($condiciones,1,1);
$alergias=limpiaStr($alergias,1,1);
$grupo_sanguineo=limpiaStr($grupo_sanguineo,1,1);
//FIN DATOS TUTOR
//ADICIONALES
if($adicional_nombre || $adicional_telefono){
	if(!$adicional_nombre) exit("No coloco el nombre de la persona adicional");
	$adicional_nombre=limpiaStr($adicional_nombre,1,1);
	if(!$adicional_telefono) exit("No coloco el teléfono de la persona adicional");
	$adicional_telefono=limpiaStr($adicional_telefono,1,1);
}
//FIN ADICIONALES
//REVISAMOS Y CHECAMOS DATOS DEL ALUMNO
if(!$alumno_nombre) exit("No escribío el nombre del alumno");
$alumno_nombre=limpiaStr($alumno_nombre,1,1);
if(!$fecha_nacimiento) exit ("Debe escribir la fecha de nacimiento del alumno");
$fecha_nacimiento = fechaBase($fecha_nacimiento);
if(!$sexo) exit ("Debe elegir el género del alumno");
//FIN DATOS ALUMNO
//REVISAMOS LO DE LOS PAGOS
if(!$id_salon) exit("Debe seleccionar el salón de clases");
//if(!$inicio) exit("Debe escribir una fecha de inicio");
//if(!$final) exit("Debe escribir una fecha de fin");
if(!$hora_entrada) exit("Debe seleccionar la hora de entrada del alumno");
$hora_entrada = date("H:i",strtotime($hora_entrada));
/*if($beca){
	$pago = 0;
}else{
	if(!$pago) exit("Debe escribir la cantidad de pago que se realiza");
}
if($libro){
	$libro = 1;
}*/
//FIN DE LOS PAGOS

//INSERTAMOS AL TUTOR
$q = mysql_query("INSERT INTO tutores (nombre,telefono1,telefono2,telefono3,direccion,parentesco,email,adicional_nombre,adicional_telefono,notas) 
	VALUES ('$nombre','$telefono1','$telefono2','$telefono3','$direccion','$parentesco','$email','$adicional_nombre','$adicional_telefono','$notas')");
$id_tutor = mysql_insert_id();

//INSERTAMOS AL ALUMNO
$q2 = mysql_query("INSERT INTO alumnos (nombre,fecha_nacimiento,sexo,condicion_medica,alergias,grupo_sanguineo) 
	VALUES ('$alumno_nombre','$fecha_nacimiento','$sexo','$condiciones','$alergias','$grupo_sanguineo')");
$id_alumno = mysql_insert_id();

//INSERTAMOS EL PAGO
$inicio = fechaBase($inicio);
$final = fechaBase($final);
$dias = (strtotime($final) - strtotime($inicio)) /24/3600;
$dias++;
/*$q3 = mysql_query("INSERT INTO pagos (id_alumno,id_tipo_pago,fecha_inicio,fecha_final,dias,monto,observacion,fecha_hora)
	VALUES ('$id_alumno','1','$inicio','$final','$dias','$pago','$observ_pago','$fechahora')");*/

if($q && $q2){
	$q4 = mysql_query("INSERT INTO inscripcion (id_usuario,id_alumno,id_tutor,id_salon,horario,libro,fecha_hora)
		VALUES ('$s_id_usuario','$id_alumno','$id_tutor','$id_salon','$hora_entrada','$libro','$fechahora')");
	if($q4){
		echo "1";
	}else{
		echo "Ocurrió un problema al inscribir al alumno; contacte a soporte";
	}
}else{
	echo "Ocurrió un problema con la agregación de alguna información; contacte a soporte";
}
?>