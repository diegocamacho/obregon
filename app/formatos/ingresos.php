<? set_time_limit(0); 
include('../includes/db.php');
include('../includes/session.php');
include('../includes/funciones.php');
ob_start();
$fecha=$_GET['fecha'];
$sql="SELECT * FROM pagos 
JOIN tipo_pago ON tipo_pago.id_tipo_pago=pagos.id_tipo_pago
JOIN alumnos On alumnos.id_alumno=pagos.id_alumno
WHERE DATE(fecha_hora)='$fecha'
ORDER BY fecha_hora ASC";
$q=mysql_query($sql);
?>
<style>
.titulos{
	background-color: #666666;
	color: #FFF;
	/*padding-left: 5px;*/
	/*Rojo claro #D90909
	Rojo obscuro #AC0000	
		
	*/
}
.borde-azul{
	border: #666666 1px solid ;
}
.borde-iz{
	border-left: #666666 1px solid;
}
.borde-der{
	border-right: #666666 1px solid;
}
.borde-bot{
	border-bottom: #666666 1px solid;
}
b{
	font-family: sfsemi;
}
h3{
	font-family: sfsemi;
	color: #333;
}
table{
	font-family: sf;
	text-transform: uppercase;
}
.f11{
	font-size: 11px;
}
.f13{
	font-size: 13px;
}
.f10{
	font-size: 10px;
}
</style>

<page backtop="28mm" backbottom="10mm" backleft="10mm" backright="10mm" >
<!-- header -->	
	<page_header>
	<table class="page_header" width="760">
		<tr>
			<td align="center">
				<img src="head.png" width="790" />
			</td>
		</tr>
	</table>
	</page_header>
<!-- Footer -->
	<page_footer>
	<table class="page_footer" width="760">
		<tr>
			<td align="center" >
				<img src="footer.png" width="790" />
			</td>
		</tr>
	</table>
	</page_footer>

<!-- Contenido -->
	
	
	
	<h4 style="text-align: center;">REPORTE DE PAGOS DEL <?=fechaLetraDos($fecha)?></h4>
	<table width="760" cellpadding="0" cellspacing="0" class="borde-azul f11" >
        <thead>
            <tr class="titulos">
                <th width="220" height="25" class="f11" style="padding-left: 5px;">ALUMNO</th>
                <th width="390" height="25" class="f11">DESCRIPCIÓN</th>
                <th width="85" height="25" class="f11" align="center">MONTO</th>
            </tr>
        </thead>
        <tbody>
	        <? while($ft=mysql_fetch_assoc($q)){ ?>
            <tr>
                <td width="220" height="20" style="padding-left: 5px;border-bottom: 1px #666 solid;"><?=$ft['nombre']?></td>
                <td width="390" height="20" style="border-bottom: 1px #666 solid;"><?=$ft['observacion']?></td>
                <td width="85" height="20" align="right" style="padding-right: 5px;border-bottom: 1px #666 solid;"><?=number_format($ft['monto'],2)?></td>
            </tr>
            <? 
	            $total+=$ft['monto'];
	            } ?>
            <tr>
                <td width="220" height="20" style="padding-left: 5px;">&nbsp;</td>
                <td width="390" height="20">&nbsp;</td>
                <td width="85" height="20" align="right" style="padding-right: 5px;"><b><?=number_format($total,2)?></b></td>
            </tr>
        </tbody>
    </table>



</page>


<?php

	$content_html = ob_get_clean();

	// initialisation de HTML2PDF
	require_once(dirname(__FILE__).'/pdf/html2pdf.class.php');
	try
	{
		$html2pdf = new HTML2PDF('P','letter','es', true, 'UTF-8', array(2, 0, 0, 0));
		$html2pdf->pdf->SetDisplayMode('fullpage');
		
		$html2pdf->addFont("sf");
		$html2pdf->addFont("sfsemi");
		//$html2pdf = new HTML2PDF('L','A4','es', false, 'utf-8', array(0, 0, 0, 0));
		$html2pdf->writeHTML($content_html, isset($_GET['vuehtml']));
//		$html2pdf->createIndex('Sommaire', 25, 12, false, true, 1);
		$html2pdf->Output('Inscripcion_'.$id_alumno.'.pdf');
	}
	catch(HTML2PDF_exception $e) { echo $e; }

?>