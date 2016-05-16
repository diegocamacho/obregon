<?
session_start();
require '../includes/db.php';
date_default_timezone_set ("America/Mexico_City");
$fecha_hora=date("Y-m-d H:i:s");
	if(isset ($_POST['email']) && ($_POST['pass']))
	{

		$primer_dia = date('Y-m-').'01';
		$dias=cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y'));
		$ultimo_dia = date('Y-m-').$dias;
		$sql = "SELECT id_menu FROM fechas WHERE fecha_inicia = '$primer_dia' AND fecha_termina = '$ultimo_dia'";
		$q = mysql_query($sql);
		$id_menu = @mysql_result($q, 0);

		$email=mysql_real_escape_string($_POST['email']);
		$contrasena=mysql_real_escape_string($_POST['pass']);
		// Admin
 		$sql = "SELECT * FROM usuarios WHERE email='$email' AND pass='$contrasena' AND activo='1' LIMIT 1";
		$res = mysql_query($sql) or die ('Error en db');
		$num_result = mysql_num_rows($res);
		if($num_result != 0){
			while ($row=mysql_fetch_object($res))
				{
					$_SESSION['s_id'] = $row->id_usuario;
					$_SESSION['s_id_tipo_usuario'] = $row->id_tipo_usuario;
					$_SESSION['s_nombre'] = $row->nombre;
					$_SESSION['s_id_empresa'] = $row->id_empresa;
					$_SESSION['s_rfc'] = "";
					$_SESSION['s_razon_social'] = $row->razon_social;
					$_SESSION['mes_ingreso'] = $row->mes_ingreso;
					$_SESSION['mensual_bimestral'] = $row->mensual_bimestral;
					$_SESSION['mes_actual'] = $id_menu;
					$_SESSION['mes_select'] = $id_menu;
				}
			if(mysql_query("UPDATE usuarios SET ultimo_acceso='$fecha_hora' WHERE id_usuario='".$_SESSION['s_id']."'")){
				echo "1";
			}
		}else{
			exit('Datos de acceso incorrectos, por favor intente nuevamente.');
		}

	}

$sql =""
?>