<?
include("../includes/session.php");
include("../includes/db.php");
include("../includes/funciones.php");

extract($_POST);

//REVISAMOS Y CHECAMOS DATOS DEL TUTOR
if(!$nombre) exit("No escribío el nombre del tutor");
if(escapar($nombre,1)) exit("El nombre del tutor que escribío no es válido");
if(!$telefono1) exit("No coloco el número de celular");
if(!escapar($telefono1,1) || strlen($telefono1)<10) exit("El número celular que colocó no es válido");
if(!$telefono2) exit("No coloco el teléfono de casa");
if(!escapar($telefono2,1)) exit("El teléfono de casa que colocó no es válido");
//if(!$telefono3) exit("No coloco el teléfono de oficina");
//if(!escapar($telefono3,1)) exit("El número celular que colocó no es válido");
if(!$direccion) exit("No escribío la dirección del tutor");
if(!$parentesco) exit("No escribío el parentesco del tutor");
if(escapar($parentesco,1)) exit("El parentesco que escribío no es válido");
if(!$email) exit("No escribío el email del tutor");
if(!validarEmail($email)) exit("El email que escríbio no es válido");
//FIN DATOS TUTOR
//ADICIONALES
if($adicional_nombre || $adicional_telefono){
	if(!$adicional_nombre) exit("No coloco el nombre de la persona adicional");
	if(escapar($adicional_nombre,1)) exit("El nombre del adicional que escribío no es válido");
	if(!$adicional_telefono) exit("No coloco el teléfono de la persona adicional");
	if(!escapar($adicional_telefono,1)) exit("El teléfono del adicional que colocó no es válido");
}
//FIN ADICIONALES
//REVISAMOS Y CHECAMOS DATOS DEL ALUMNO
if(!$alumno_nombre) exit("No escribío el nombre del alumno");
if(escapar($alumno_nombre,1)) exit("El nombre del alumno que escribío no es válido");
if(!$fecha_nacimiento) exit ("Debe escribir la fecha de nacimiento del alumno");
$fecha_nacimiento = fechaBase($fecha_nacimiento);
if(!$sexo) exit ("Debe elegir el género del alumno");
//FIN DATOS ALUMNO


//INSERTAMOS AL TUTOR
$q = mysql_query("UPDATE tutores SET nombre='$nombre',telefono1='$telefono1',telefono2='$telefono2',telefono3='$telefono3',direccion='$direccion'
	,parentesco='$parentesco',email='$email',adicional_nombre='$adicional_nombre',adicional_telefono='$adicional_telefono',notas='$notas' 
	WHERE id_tutor = '$id_tutor'");

//INSERTAMOS AL ALUMNO
$q2 = mysql_query("UPDATE alumnos SET nombre='$alumno_nombre',fecha_nacimiento='$fecha_nacimiento',sexo='$sexo',
	condicion_medica='$condiciones',alergias='$alergias',grupo_sanguineo='$grupo_sanguineo' 
	WHERE id_alumno='$id_alumno'");


if($q && $q2){
	echo "1";
}else{
	echo "Ocurrió un problema con la agregación de alguna información; contacte a soporte";
}
?>