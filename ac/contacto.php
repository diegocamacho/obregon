<?php
if(empty($_POST['nombre'])  		||
   empty($_POST['telefono']))
   {
	exit("Los campos llegaron vacios");
   }
	
$nombre = $_POST['nombre'];
$telefono = $_POST['telefono'];
	

$to = 'hola@epicmedia.pro';
$email_subject = "Contacto desde Obregón";
$email_body = "Hemos recibido un contacto desde la página Web.\n\n"."Detalles:\n\nNombre: $nombre\n\nTeléfono: $phone\n\n";
$headers = "From: robot@epicmedia.pro\n";
$headers .= "Reply-To: $email_address";	
if(mail($to,$email_subject,$email_body,$headers)){
	
echo "1";
}else{
	exit("Ocurrió un error intente nuevamente.");
}
?>