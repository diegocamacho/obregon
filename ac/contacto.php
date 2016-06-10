<?php
if(empty($_POST['nombre'])  		||
   empty($_POST['telefono']))
   {
	echo "Los campos llegaron vacios";
	return false;
   }
	
$nombre = $_POST['nombre'];
$telefono = $_POST['telefono'];
	

$to = 'hola@epicmedia.pro';
$email_subject = "Contacto desde Obregón";
$email_body = "Hemos recibido un contacto desde la página Web.\n\n"."Detalles:\n\nNombre: $nombre\n\nTeléfono: $phone\n\n";
$headers = "From: robot@epicmedia.pro\n";
$headers .= "Reply-To: $email_address";	
mail($to,$email_subject,$email_body,$headers);
return true;
?>