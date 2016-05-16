<? set_time_limit(0); 
//include('../includes/db.php');
//include('../includes/session.php');
include('num_letra.php');
/*
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
*/
//$data = @mysql_fetch_assoc($q);


//$xml = simplexml_load_file('../bot/'.$data['xml']); 
$xml = simplexml_load_file('e1f3c3c4-eff6-4425-a74f-8393e7dfd6c2.xml'); 
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
	  
	  $descuento = (double)$cfdiComprobante['descuento'];
	  $cfdiComprobante['motivoDescuento'];
      
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
<style>
.titulos{
	background-color: #000000;
	color: #FFF;
	/*padding-left: 5px;*/
	/*Rojo claro #D90909
	Rojo obscuro #AC0000	
		
	*/
}
.borde-azul{
	border: #000000 1px solid ;
}
.borde-iz{
	border-left: #000000 1px solid;
}
.borde-der{
	border-right: #000000 1px solid;
}
.borde-bot{
	border-bottom: #000000 1px solid;
}
b{
	font-family: sfsemi;
}
table{
	font-family: sf;
}
.f11{
	font-size: 11px;
}
.f10{
	font-size: 10px;
}
</style>

<page backtop="90mm" backbottom="75mm" backleft="0mm" backright="2mm" footer="page">

<page_header>
	<table width="780" border="0" cellpadding="0" cellspacing="0" class="f11">
		<tr>
	    	<td width="180" height="150" valign="top">
		    	<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td width="180" height="150" align="center" valign="middle"><img src="kntr_factura.png" width="150" /></td>
	        		</tr>
				</table>
			</td>
			<td width="400" valign="top">
			    <table width="100%" border="0" cellpadding="0" cellspacing="0">
					<tr>
			    		<td width="400" height="150" valign="top">
			        		<p><b><?=$Emisor['nombre']?></b><br />
							<?=$DomicilioFiscal['calle']?> <?=$DomicilioFiscal['noExterior']?>, <?=$DomicilioFiscal['colonia']?>, <?=$DomicilioFiscal['municipio']?> C.P. <?=$DomicilioFiscal['codigoPostal']?><br />
							<?=$DomicilioFiscal['localidad']?>, <?=$DomicilioFiscal['estado']?>, <?=$DomicilioFiscal['pais']?><br />
							RFC. <?=$Emisor['rfc']?></p>
							
							<p><b>Regimen Fiscal</b><br />
							<?=$RegimenFiscal['Regimen']?></p>
						</td>
					</tr>
				</table>
			</td>
			<td width="200" valign="top">
			    <table width="100%" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td width="200" height="18" align="left" valign="bottom" ><p><b>FACTURA <?=$cfdiComprobante['serie']?><?=$cfdiComprobante['folio']?></b></p></td>
					</tr>
					<tr>
						<td height="24" valign="middle" class="titulos" >&nbsp; Fecha y hora de emisión</td>
					</tr>
					<tr>
						<td height="20" valign="top" ><?=$cfdiComprobante['fecha'];?></td>
					</tr>
					<tr>
						<td height="24" valign="middle" class="titulos" >&nbsp; Fecha y hora de certificacion</td>
					</tr>
					<tr>
						<td height="20" valign="top" ><?=$tfd['FechaTimbrado'];?></td>
					</tr>
					<tr>
						<td height="24" valign="middle" class="titulos" >&nbsp; Lugar</td>
					</tr>
					<tr>
						<td height="20" valign="top" ><?=$cfdiComprobante['LugarExpedicion'];?></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<table width="750" cellpadding="0" cellspacing="0" class="borde-azul f11">
	  	<tr>
	    	<td width="270" height="20" valign="middle" class="titulos">&nbsp;Receptor</td>
			<td width="230" height="20" valign="middle" class="titulos">&nbsp;Lugar de Expedicion</td>
			<td width="250" height="20" valign="middle" class="titulos">&nbsp;Datos Fiscales</td>
		</tr>
		<tr>
	    	<td width="270" height="100" valign="top" class="borde-der" style="padding-left: 5px;padding-right: 5px;padding-top: 5px;" >
			    <b><?=$Receptor['nombre']?></b><br />
				<?=$ReceptorDomicilio['calle']?> NO EXT. <?=$ReceptorDomicilio['noExterior']?> <?
					if($ReceptorDomicilio['noInterior']){
						echo 'NO. INT. '.$ReceptorDomicilio['noInterior'];
					}	 
				?><br />
				COL. <?=$ReceptorDomicilio['colonia']?>, <?=$ReceptorDomicilio['localidad']?>, <?=$ReceptorDomicilio['municipio']?>, C.P. <?=$ReceptorDomicilio['codigoPostal']?><br />
				<?=$ReceptorDomicilio['estado']?>, <?=$ReceptorDomicilio['pais']?><br />
				RFC: <?=$Receptor['rfc'];?>
			</td>
	    	<td width="230" height="100" valign="top" class="borde-der pad" style="padding-left: 5px;padding-top: 5px;">
			    <?=$DomicilioFiscal['calle']?> <?=$DomicilioFiscal['noExterior']?>, <?=$DomicilioFiscal['colonia']?>, <?=$DomicilioFiscal['municipio']?> C.P. <?=$DomicilioFiscal['codigoPostal']?><br />
				<?=$DomicilioFiscal['localidad']?>, <?=$DomicilioFiscal['estado']?>, <?=$DomicilioFiscal['pais']?>
			</td>
	    	<td width="240" height="100" valign="top" class="pad" style="padding-left: 5px;padding-right: 5px;padding-top: 5px;">
			    <b>Folio Sat</b><br />
				<?=$tfd['UUID']?><br />
				<b>Número de serie certificado emisor:</b><br />
				<?=$cfdiComprobante['noCertificado']?><br />
				<b>Número serie del certificado SAT:</b><br />
				<?=$tfd['noCertificadoSAT'];?>
			</td>
		</tr>
	</table>
</page_header>

<page_footer>
	<table width="787" class="borde-azul" cellpadding="0" cellspacing="0">
		<thead>
			<tr class="titulos">
				<th width="787" height="25" class="f11" valign="middle" style="padding-left: 5px;">Cadena original del complemento de certificación digital del SAT:</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td width="787" height="30" valign="top" class="f11"><?
				echo $tfd['version'].'|'.$tfd['UUID'].'|'.$tfd['FechaTimbrado'].'|'.substr($tfd['selloCFD'],0,45).'<br/>'.substr($tfd['selloCFD'],45,90).'<br>'.substr($tfd['selloCFD'],135,800).'|'.$tfd['noCertificadoSAT'].'||';
				
//				version|UUID|FechaTimbrado|Sello CFDI|No serie cert sat||	
				?></td>
			</tr>
		</tbody>
	</table>
	<table width="780" border="0" cellpadding="0" cellspacing="0" style="margin-top: 5px;">
		<tr>
	    	<td width="165" rowspan="2" valign="top">
		    	<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td width="165" height="165" valign="middle" align="center">
							<? $CadImpTot = ProcesImpTot($total);
								$Cadena = "?re=".$Emisor['rfc']."&rr=".$Receptor['rfc']."&tt=".$CadImpTot."&id=".$tfd['UUID']; ?>
							<qrcode value="<?=$Cadena?>" ec="H" style="width: 159px; border: none; background-color: white; color: black;"></qrcode>
							<!--<img src="../facturacion/archs_graf/Img_<?=$tfd['UUID']?>.png" width="159" height="159" />-->
						</td>
					</tr>
				</table>
			</td>
			
			<td width="615" height="75" valign="top">
				<table width="615" class="borde-azul" cellpadding="0" cellspacing="0">
					<thead>
						<tr class="titulos">
							<th width="615" height="25" class="f11" valign="middle" style="padding-left: 5px;">Sello digital del CFDI:</th>
						</tr>
			    	</thead>
			    	<tbody>
						<tr>
							<td width="615" height="50" valign="top" class="f11"><? echo substr($tfd['selloCFD'],0,92).'<br/>'.substr($tfd['selloCFD'],92,500);	?></td>
						</tr>
			    	</tbody>
				</table>
			</td>
		</tr>
		
		<tr>
	    	<td width="615" height="75" valign="top">
		    	<table width="615" class="borde-azul" cellpadding="0" cellspacing="0">
					<thead>
						<tr class="titulos">
							<th width="615" height="25" class="f11" valign="middle" style="padding-left: 5px;">Sello del SAT:</th>
						</tr>
			    	</thead>
			    	<tbody>
						<tr>
							<td width="615" height="50" valign="top" class="f11"><? echo substr($tfd['selloSAT'],0,92).'<br/>'.substr($tfd['selloSAT'],92,500);	?></td>
						</tr>
			    	</tbody>
				</table>
			</td>
		</tr>
	</table>
	<table width="780" border="0" cellpadding="0" cellspacing="0" class="f11">
    	<tr>
			<td width="300" style="padding-top: 10px;padding-bottom: 16px;">Facturación sin complicaciones <b>www.adminus.mx</b></td>
			<td width="480" style="padding-top: 10px;padding-bottom: 16px;">Este documento es una representación impresa de un CFDI</td>
		</tr>
	</table>
</page_footer>
<!-- Adenda para el gobierno
<table width="796" cellpadding="0" cellspacing="0" class="borde-azul f11">
	<tbody>
    	<tr>
			<td width="796" style="padding-top: 10px;padding-bottom: 10px;">&nbsp;CÉDULA 389, POR CONCEPTO DE PAGO ÚNICO DEL EQUIPAMIENTO DENOMINADO “EQUIPAMIENTO DEL HOSPITAL COMUNITARIO DE NICOLÁS BRAVO (TERCERA ETAPA) EN LA LOCALIDAD DE NICOLÁS BRAVO, MUNICIPIO DE OTHÓN P. BLANCO BAJO EN CONTRATO SESA-DA-132-2015 DE FECHA 24 DE DICIEMBRE DE 2015. PERIODO DEL PAGO ÚNICO: DEL 24 DE DICIEMBRE DE 2015 AL 2 DE ENERO DE 2016. 						
						
						</td>
		</tr>
	</tbody>
</table>
<br><br>
-->
<table width="780" cellpadding="0" cellspacing="0" class="borde-azul f11">
	<thead>
    	<tr class="titulos">
			<th width="55" height="25" class="f11" style="padding-left: 5px;">Cantidad</th>
			<th width="80" height="25" class="f11">Unidad</th>
			<th width="80" height="25" class="f11">Clave</th>
			<th width="290" height="25" class="f11">Descripción</th>
			<th width="130" height="25" class="f11" align="right">Precio</th>
			<th width="125" height="25" class="f11" align="right" style="padding-right: 5px;">Importe</th>
		</tr>
	</thead>
	<tbody>
<? foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Conceptos//cfdi:Concepto') as $Concepto){ ?>
    	<tr style="margin-bottom: 10px;">
			<td width="55" height="20" style="padding-left: 5px;"><?=$Concepto['cantidad']?></td>
		    <td width="80" height="20"><?=$Concepto['unidad']?></td>
			<td width="80" height="20"><?=$Concepto['noIdentificacion']?></td>
			<td width="290" height="20"><?=$Concepto['descripcion']?></td>
			<td width="130" height="20" align="right"><?=number_format((double)$Concepto['valorUnitario'],2)?></td>
			<td width="125" height="20" align="right"><?=number_format((double)$Concepto['importe'],2)?></td>
		</tr>
<? } ?>	
	</tbody>
</table>
<br>
<table width="780" class="borde-azul" cellpadding="0" cellspacing="0">
  <tr>
    <td height="20" colspan="2" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="520" height="20" valign="middle" class="f11"><?=mb_strtoupper(NumLet($total),'UTF-8')?></td>
        </tr>
      
      
    </table></td>
    <td width="260" rowspan="2" valign="top"><table width="100%" style="border-left:#000000 1px solid;" cellpadding="0" cellspacing="0">
      <tr>
        <td width="130" height="98" align="right" valign="top" class="f11"><b>Subtotal:</b><br>
          <b>Descuentos:</b><br>
          <b>IVA 16%</b><br></td>
          <td width="130" align="right" valign="top" class="f11"><b><?=number_format($subtotal,2)?></b><br>
            <b><?=number_format($descuento,2)?></b><br>
			<b><?=number_format($cantidad_iva,2)?></b><br></td>
        </tr>
      
      
      <tr>
        <td height="20" align="right" valign="middle" class="f11 titulos"><b>TOTAL:</b></td>
          <td align="right" valign="middle" class="f11 titulos"><b><?=number_format($total,2)?></b></td>
        </tr>
      
      
      
    </table></td>
  </tr>
  <tr>
    <td width="190" height="98" valign="top" class="f11">
	    	FORMA DE PAGO:<br />
			MÉTODO DE PAGO:<br />
			NÚMERO CUENTA DE PAGO:<br />
			TIPO DE COMPROBANTE:<br />
			CONDICIONES DE PAGO:<br />
			MOTIVO DE DESCUENTO:<br />
			MONEDA: <br /></td>
    <td width="330" valign="top" class="f11">
	    	<?=mb_strtoupper($cfdiComprobante['formaDePago'], 'UTF-8')?><br />
			<?=mb_strtoupper($cfdiComprobante['metodoDePago'], 'UTF-8')?><br />
			<?=$cfdiComprobante['NumCtaPago']?><br />
			<?=mb_strtoupper($cfdiComprobante['tipoDeComprobante'], 'UTF-8')?><br /> 
			<?=mb_strtoupper($cfdiComprobante['condicionesDePago'], 'UTF-8')?><br /> 
			<?=mb_strtoupper($cfdiComprobante['motivoDescuento'], 'UTF-8')?><br />
			<?=mb_strtoupper($cfdiComprobante['Moneda'], 'UTF-8')?></td>
  </tr>
</table>

<br>
<!-- Adenda para la firma de los propietarios
<table width="796" cellpadding="0" cellspacing="0" class="borde-azul f11">
	<tbody>
    	<tr>
			<td width="398" style="padding-top: 10px;padding-bottom: 10px;" align="center"> 
				<br><br><br>
_____________________________________________<br>
LIC. MARIANA SOLEDAD KÁNTER SOLÍS<br>
              REPRESENTANTE LEGAL<br>
                 “KÁNTER ARQUITECTOS, S.A. DE C.V.
</td>
			<td width="398" style="padding-top: 10px;padding-bottom: 10px;" align="center"> 
				<br><br><br>
_____________________________________________<br>				
M.A. RAÚL ROLANDO AGUILAR LAGUARDIA<br>
DIRECTOR ADMINISTRATIVO DE LOS “SESA”
</td>

		</tr>
	</tbody>
</table>
-->
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
		$html2pdf->Output('Factura_'.$tfd['UUID'].'.pdf');
	}
	catch(HTML2PDF_exception $e) { echo $e; }

?>