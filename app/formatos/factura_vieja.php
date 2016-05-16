<? set_time_limit(0); 

include('../includes/db.php');
include('../includes/session.php');
include('num_letra.php');

$id_factura = mysql_real_escape_string($_GET['i']);
$tipo = mysql_escape_string($_GET['t']);

if(!is_numeric($id_factura)) exit('ID incorrecto.');
if(!is_numeric($tipo)) exit('Tipo incorrecto.');

if($tipo=='1'){
	$tipo = 'recibidas';
	$s = 'recibida';
}elseif($tipo=='2'){
	$tipo = 'emitidas';
	$s = 'emitida';
}

$sql = "SELECT*FROM facturas_$tipo WHERE id_empresa = '$s_id_empresa' AND id_factura_$s = $id_factura";
$q = @mysql_query($sql);
$n = @mysql_num_rows($q);

if(!$n) exit('Error.');

$data = @mysql_fetch_assoc($q);


$xml = simplexml_load_file('../bot/'.$data['xml']); 
$ns = $xml->getNamespaces(true);
$xml->registerXPathNamespace('c', $ns['cfdi']);
$xml->registerXPathNamespace('t', $ns['tfd']);
 
$ret_isr = 0.00;
$ret_iva = 0.00;
$cantidad_iva = (double)0.00;
foreach ($xml->xpath('//cfdi:Comprobante') as $cfdiComprobante){ 
      $cfdiComprobante['version']; 
      
      $cfdiComprobante['fecha']; 
      
      $cfdiComprobante['sello']; 
      
      $total = (double)$cfdiComprobante['total'];
      $subtotal = (double)$cfdiComprobante['subTotal'];
      
      $cfdiComprobante['certificado']; 
      
      $cfdiComprobante['formaDePago']; 
      
      $cfdiComprobante['noCertificado']; 
      
      $cfdiComprobante['tipoDeComprobante']; 
      $cfdiComprobante['LugarExpedicion'];
      $cfdiComprobante['metodoDePago'];
      $cfdiComprobante['condicionesDePago'];
      
      
      $cfdiComprobante['serie'];
	  $cfdiComprobante['folio'];
	  
      $cfdiComprobante['motivoDescuento'];
	  $cfdiComprobante['Moneda'];
      
} 
foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Emisor') as $Emisor){ 
   $Emisor['rfc']; 
   
   $Emisor['nombre']; 
   
} 
foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Emisor//cfdi:DomicilioFiscal') as $DomicilioFiscal){ 
   $DomicilioFiscal['pais']; 
   
   $DomicilioFiscal['calle']; 
   
   $DomicilioFiscal['estado']; 
   
   $DomicilioFiscal['colonia']; 
   
   $DomicilioFiscal['municipio']; 
   
   $DomicilioFiscal['noExterior']; 
   
   $DomicilioFiscal['codigoPostal']; 
   
} 
foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Emisor//cfdi:ExpedidoEn') as $ExpedidoEn){ 
   $ExpedidoEn['pais']; 
   
   $ExpedidoEn['calle']; 
   
   $ExpedidoEn['estado']; 
   
   $ExpedidoEn['colonia']; 
   
   $ExpedidoEn['noExterior']; 
   
   $ExpedidoEn['codigoPostal']; 
   
} 

foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Emisor//cfdi:RegimenFiscal') as $RegimenFiscal){ 
   $RegimenFiscal['Regimen']; 

} 


foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Receptor') as $Receptor){ 
   $Receptor['rfc']; 
   
   $Receptor['nombre']; 
   
} 
foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Receptor//cfdi:Domicilio') as $ReceptorDomicilio){ 
   $ReceptorDomicilio['pais']; 
   
   $ReceptorDomicilio['calle']; 
   
   $ReceptorDomicilio['estado']; 
   
   $ReceptorDomicilio['colonia']; 
   
   $ReceptorDomicilio['municipio']; 
   
   $ReceptorDomicilio['noExterior']; 
   
   $ReceptorDomicilio['noInterior']; 
   
   $ReceptorDomicilio['codigoPostal']; 
   
} 

foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Impuestos//cfdi:Traslados//cfdi:Traslado') as $Traslado){ 

   $Traslado['tasa'];
   $Traslado['importe'] = (double)$Traslado['importe'];
   $Traslado['impuesto']; 
   
   if($Traslado['impuesto']=='IVA'){
	   $cantidad_iva+=(double)$Traslado['importe'];
   }
     
   
} 

foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Impuestos//cfdi:Retenciones//cfdi:Retencion') as $Retenciones){ 
   
   $Retenciones['importe']; 
   $Retenciones['impuesto']; 
   
   if($Retenciones['impuesto']=='IVA'){
	   $ret_iva+=(double)$Retenciones['importe'];
   }
   if($Retenciones['impuesto']=='ISR'){
	   $ret_isr+=(double)$Retenciones['importe'];
   }
     
   
} 

 
//ESTA ULTIMA PARTE ES LA QUE GENERABA EL ERROR
foreach ($xml->xpath('//t:TimbreFiscalDigital') as $tfd) {
   $tfd['selloCFD']; 
   
   $tfd['FechaTimbrado']; 
   
   $tfd['UUID']; 
   
   $tfd['noCertificadoSAT']; 
   
   $tfd['version']; 
   
   $tfd['selloSAT']; 
} 

function ProcesImpTot($ImpTot){
        $ArrayImpTot = explode(".", $ImpTot);
        $NumEnt = $ArrayImpTot[0];
        $NumDec = ProcesDecFac($ArrayImpTot[1]);
        return $NumEnt.".".$NumDec;
    }
    
function ProcesDecFac($Num){
    $FolDec = "";
    if ($Num < 10){$FolDec = "00000".$Num;}
    if ($Num > 9 and $Num < 100){$FolDec = $Num."0000";}
    if ($Num > 99 and $Num < 1000){$FolDec = $Num."000";}
    if ($Num > 999 and $Num < 10000){$FolDec = $Num."00";}
    if ($Num > 9999 and $Num < 100000){$FolDec = $Num."0";}
    return $FolDec;
}
ob_start(); 
?>


<style type="text/css">
body {
    margin-left:0px;
    margin-right:0px;
    margin-top:0px;
    margin-bottom:0px;
    font-family:"Arial", Helvetica, sans-serif;
  }
.info{ 
	font-size: 16px;
}
.info td{
	padding: 10px;
	text-transform: uppercase;
}
.cal{ 
	font-size: 10px;
}
.cal td{
	padding: 3px;
	text-transform: uppercase;
}
table.page_header {width: 100%; border: none; padding-top: 2mm; font-size: 14px; }
table.page_footer {
	font-size: 12px;
}
.productos{
	 border-collapse: collapse; 
}
.abajo-izquierda{
	height: 20px;

}
.cabeza{
	height: 40px;
	background-color: #004b80;
	color: #FFF;
}
</style>

<page backtop="80mm" backbottom="80mm" backleft="5mm" backright="5mm" footer="page">
<!-- header -->	
	<page_header>
	<table class="page_header" width="750" align="center">
		<tr>
			<td align="left" valign="bottom" style="width: 50%; text-align: left;padding-left:10px;" height="70">
				<img src="../logoadmins_AZUL.png" width="160" />
				<h5 style="margin-top: 0px;">Factura Electrónica (CFDI)</h5>
				
			</td>
			<td align="right" valign="bottom" style="width: 50%; text-align: right;padding-right:10px;" height="70">
				<b>Folio Fiscal:</b><br>
				<?=$tfd['UUID']?>
			</td>
		</tr>
		
		<tr>
			<td align="left" style="width: 50%; text-align: left;padding-left:10px;" height="50">
				<h4 style="margin-bottom: 0px;">RFC: <?=$Emisor['rfc']?></h4>
				 <?=$Emisor['nombre']?>
			</td>
			<td align="right" style="width: 50%; text-align: right;padding-right:10px;" height="50">
				<b>No. de Serie del Certificado del CSD:</b><br>
				<?=$cfdiComprobante['noCertificado']?>
			</td>
		</tr>
		
		<tr>
			<td align="left" style="width: 50%; text-align: left;padding-left:10px;" height="50">
				<b>Régimen Fiscal:</b><br>
				<?=$RegimenFiscal['Regimen']?>
			</td>
			<td align="right" style="width: 50%; text-align: right;padding-right:10px;" height="50">
				<b>Lugar, fecha y hora de emisión:</b><br>
				<?=$cfdiComprobante['LugarExpedicion'];?>, <?=$cfdiComprobante['fecha'];?>
			</td>
		</tr>
		<tr>
			<td align="left" valign="top" style="width:100%; text-align: left;padding-left:10px;margin-right: 10px;border-top: 1px solid #333;" colspan="2" height="100">
				<h4 style="margin-bottom: 0px;">RFC Receptor:</h4>
				<?=$Receptor['rfc'];?><br>
				<?=$Receptor['nombre']?>
			</td>
		</tr>
	</table>
	</page_header>
<!-- Footer -->
	<page_footer>
	<table class="page_footer" width="750" align="center">
		<tr>
			<td align="left" height="50" style="width:100%;border-top: 1px solid #333;">
				<b>Sello Digital del CFDI:</b><br/>
				<? echo substr($tfd['selloCFD'],0,87).'<br/>'.substr($tfd['selloCFD'],87,500);	?>
			</td>
		</tr>
		<tr>
			<td align="left" height="50" style="width:100%;">
				<b>Sello del SAT:</b><br/>
				<?
				echo substr($tfd['selloSAT'],0,87).'<br/>'.substr($tfd['selloSAT'],87,500);	
				?>

			</td>
		</tr>
		<tr>
			<td align="left" height="50" style="width:100%;">
				<b>Cadena Original del complemento de certificación digital del SAT:</b><br/>
				<?
				echo $tfd['version'].'|'.$tfd['UUID'].'|'.$tfd['FechaTimbrado'].'|'.substr($tfd['selloCFD'],0,45).'<br/>'.substr($tfd['selloCFD'],45,90).'<br>'.substr($tfd['selloCFD'],135,800).'|'.$tfd['noCertificadoSAT'].'||';
				
//				version|UUID|FechaTimbrado|Sello CFDI|No serie cert sat||	
				?>
			</td>
		</tr>
		<tr>
			<td align="left" style="width:100%;font-size: 16px;" align="center">
				No de Serie del Certificado del SAT: <b><?=$tfd['noCertificadoSAT'];?></b><br>
				Fecha y hora de certificación: <b><?=$tfd['FechaTimbrado'];?></b><br>
				Este documento es una representación impresa de un CFDI
			</td>
		</tr>
		<tr>
			<td align="left" height="20" valign="top" style="width:100%;font-size: 11px;" align="left">
				Generado por www.adminus.mx

			</td>
		</tr>
	</table>
	</page_footer>
<!-- contenido -->
	<table width="750" class="productos" border="1" >
		<thead>
	    	<tr>
	        	<th width="70" align="center" class="cabeza">Cantidad</th>
	            <th width="110" align="center" class="cabeza">U. Medida</th>
	            <th width="340" align="center" class="cabeza">Descripción</th>
	            <th width="100" align="center" class="cabeza">Precio U.</th>
	            <th width="100" align="center" class="cabeza">Importe</th>
	        </tr>
		</thead>
	
		<tbody>
<?
foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Conceptos//cfdi:Concepto') as $Concepto){ 
   
?>
	    	<tr>
	        	<td align="center" width="70" class="abajo-izquierda"><?=$Concepto['cantidad']?></td>
	        	<td align="center" width="110" class="abajo-izquierda"><?=$Concepto['unidad']?></td>
	        	<td align="left" width="340" class="abajo-izquierda"><?
		        	echo $Concepto['descripcion']
		        	
		        ?></td>
	        	<td align="right" width="100" class="abajo-izquierda"><?=number_format((double)$Concepto['valorUnitario'],2)?></td>
	        	<td align="right" width="100" class="abajo-izquierda"><?=number_format((double)$Concepto['importe'],2)?></td>
	    	</tr>

<?
} 
?>	    	
<tr>
		    	<td colspan="3">
			    	TOTAL CON LETRA: <?=mb_strtoupper(NumLet($total),'UTF-8')?><br>
			    	<?= mb_strtoupper($cfdiComprobante['formaDePago'], 'UTF-8')?><br>
			    	METODO DE PAGO: <?= mb_strtoupper($cfdiComprobante['metodoDePago'], 'UTF-8')?>
		    	</td>
		    	<td align="right" class="abajo-izquierda">
			    	Subtotal:<br>
			    	IVA (16%): <br>
			    	ISR Retenido:<br>
			    	IVA Retenido:<br>
			    	<b>Total:</b>
		    	</td>
	        	<td align="right" class="abajo-izquierda">
		        	 <?=number_format($subtotal,2)?><br>
		        	<?=number_format($cantidad_iva,2)?><br>
		        	<?=number_format($ret_isr,2)?><br>
		        	<?=number_format($ret_iva,2)?><br>
		        	<b><?=number_format($total,2)?></b>
		        </td>
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
		$html2pdf = new HTML2PDF('P','A4','es', true, 'UTF-8', array(0, 0, 0, 0));
		$html2pdf->pdf->SetDisplayMode('fullpage');
		//$html2pdf = new HTML2PDF('L','A4','es', false, 'utf-8', array(0, 0, 0, 0));
		$html2pdf->writeHTML($content_html, isset($_GET['vuehtml']));
//		$html2pdf->createIndex('Sommaire', 25, 12, false, true, 1);
		$html2pdf->Output('extracto_alumnos.pdf');
	}
	catch(HTML2PDF_exception $e) { $e; }	

?>