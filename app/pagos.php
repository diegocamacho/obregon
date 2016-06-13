<?
$fecha=$_GET['fecha'];
if(isset($fecha)){ $fecha=fechaBase($fecha); }else{ $fecha=$fecha_actual; }
$sql="SELECT * FROM pagos 
JOIN tipo_pago ON tipo_pago.id_tipo_pago=pagos.id_tipo_pago
JOIN alumnos On alumnos.id_alumno=pagos.id_alumno
WHERE DATE(fecha_hora)='$fecha'
ORDER BY fecha_hora ASC";

$q=mysql_query($sql);
$valida=mysql_num_rows($q);

$sq="SELECT * FROM alumnos WHERE activo=1";
$q2=mysql_query($sq);

$sq3="SELECT * FROM tipo_pago";
$q3=mysql_query($sq3);
?>
<style>
.oculto{
	display: none;
}
.link{
	cursor: pointer;
}
</style>

<div class="page-content">
    <div class="container">
	    
		<div class="row">
			<div class="col-md-12">
				<!-- Confirmación -->
				  <? if($_GET['msg']==1){ ?>
				  		<br>
				  		<div class="alert alert-dismissable alert-success">
					  		<button type="button" class="close" data-dismiss="alert">×</button>
					  		<p>El pago se ha guardado</p>
					  	</div>
				  <? }if($_GET['msg']==2){ ?>
				  		<br>
				  		<div class="alert alert-dismissable alert-info">
					  		<button type="button" class="close" data-dismiss="alert">×</button>
					  		<p>El pago se ha editado</p>
					  	</div>
				  <? } ?>
				  <!-- Contenido -->
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
				<div class="portlet light">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-basket font-green-sharp"></i>
							<span class="caption-subject font-green-sharp bold uppercase">Pagos de hoy</span>
						</div>
						<div class="actions btn-set">
							<a href="javascript:;" class="btn btn-sm red easy-pie-chart-reload" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#CambiaFecha"><i class="fa fa-calendar"></i> Cambiar Fecha </a>&nbsp;&nbsp;&nbsp;
							<a href="javascript:;" class="btn btn-sm green easy-pie-chart-reload" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#NuevaVenta"><i class="fa fa-plus"></i> Nuevo Pago </a>
						</div>
					</div>
					<div class="portlet-body">
						<? if($valida){ ?>
                        <table class="table table-striped table-bordered table-hover" >
                            <thead>
                                <tr>
                                    <th width="15%">Fecha</th>
                                    <th width="25%">Alumno</th>
                                    <th width="34%">Descripción</th>
                                    <th width="10%" style="text-align: center">Monto</th>
                                    <th width="16%"></th>
                                </tr>
                            </thead>
                            <tbody>
	                            <? while($ft=mysql_fetch_assoc($q)){ ?>
                                <tr class="odd gradeX">
                                    <td><?=devuelveFechaHora($ft['fecha_hora'])?></td>
                                    <td><?=$ft['nombre']?></td>
                                    <td><?=$ft['observacion']?></td>
                                    <td align="right"><?=number_format($ft['monto'],2)?></td>
                                    <td align="right">
	                                    <a target="_blank" href="<? if($ft['id_tipo_pago']==1){ echo 'formatos/inscripcion.php?id='.$ft['id_alumno']; }else{ echo 'formatos/recibo.php?id='.$ft['id_pago']; }?>" class="btn sbold green btn-xs" role="button">Recibo</a>&nbsp;
	                                    <a href="#" onclick="EliminaPago(<?=$ft['id_pago']?>)" class="btn sbold red btn-xs" role="button">Eliminar</a>
                                    </td>
                                </tr>
                                <? } ?>
                            </tbody>
                        </table>

                        <div class="row">
	                        <div class="col-md-12" style="text-align: right;">
								<a href="formatos/ingresos.php?fecha=<?=$fecha?>" class="btn btn-sm btn-default" target="_blank" ><i class="fa fa-print"></i> Imprimir </a>
	                        </div>
                        </div>
                        <? }else{ ?>
                        <div class="alert alert-info" role="alert">No se han registrado pagos en esta fecha.</div>
                        <? } ?>
					</div>
				</div>
				<!-- END EXAMPLE TABLE PORTLET-->
			</div>
		</div>

    </div>
</div>












<!-- Modal -->
<div class="modal fade" id="NuevaVenta">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
        <h4 class="modal-title">Nuevo Pago</h4>
      </div>
      <div class="modal-body">
      	<div class="alert alert-danger oculto" role="alert" id="msg_error"></div>
<!--Formulario -->
		<form action="#" class="form-horizontal" id="frm_guarda">
            
            <div class="form-group form-group-lg">
                <label class="control-label col-md-4">Alumno</label>
                <div class="col-md-8">
                    <select class="form-control select2" name="id_alumno" id="id_alumno">
	                    <option value="0">Seleccione uno</option>
                        <? while($ft=mysql_fetch_assoc($q2)){ ?>
                        <option value="<?=$ft['id_alumno']?>"><?=$ft['nombre']?></option>
                        <? } ?>
                    </select>
                </div>
            </div>
            
            <div class="form-group form-group-lg">
                <label class="control-label col-md-4">Tipo de pago</label>
                <div class="col-md-8">
                    <select class="form-control" name="id_tipo_pago" id="id_tipo_pago">
	                    <option value="0">Seleccione uno</option>
	                    <? while($ft=mysql_fetch_assoc($q3)){ ?>
                        <option value="<?=$ft['id_tipo_pago']?>"><?=$ft['tipo_pago']?></option>
                        <? } ?>
                    </select>
                </div>
            </div>
            
            <div class="form-group form-group-lg oculto" id="fechas">
                <label for="inputEmail12" class="col-md-4 control-label">Periódo de Clase </label>
                <div class="col-md-8">
			 	<div class="input-group input-large date-picker input-daterange" data-date-format="mm/dd/yyyy">
                        <input type="text" class="form-control limpia" name="inicio">
                        <span class="input-group-addon"> al </span>
                        <input type="text" class="form-control limpia" name="final"> </div>
                    <!-- /input-group -->
                    <span class="help-block"> Seleccione el rango de fechas </span>
                </div>
            </div>
            

	        <div class="form-group form-group-lg oculto" id="concepto">
                <label class="control-label col-md-4">Concepto</label>
                <div class="col-md-8">
                    <input type="text" class="form-control limpia" name="concepto">
                </div>
            </div>
            
            <div class="form-group form-group-lg">
                <label class="control-label col-md-4">Monto</label>
                <div class="col-md-4">
                    <input type="text" class="form-control limpia" name="monto" maxlength="4">
                </div>
            </div>
            
            
            
		</form>
	</div>
		
    <div class="modal-footer">
    	<img src="assets/global/img/loading-spinner-grey.gif" border="0" id="load" width="20" class="oculto" />
		<button type="button" class="btn btn-default btn_ac" data-dismiss="modal">Cancelar</button>
		<button type="button" class="btn btn-success btn_ac" onclick="NuevaVenta()">Guardar Pago</button>
	</div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->




<!-- Modal -->
<div class="modal fade" id="CambiaFecha">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
        <h4 class="modal-title">Ver pagos por fecha</h4>
      </div>
      <div class="modal-body">
      	<div class="alert alert-danger oculto" role="alert" id="msg_error"></div>
<!--Formulario -->
		<form action="#" class="form-horizontal" id="frm_guarda">
            
            <div class="form-group form-group-lg">
                <label class="control-label col-md-4">Seleccione Fecha</label>
                <div class="col-md-8">
                        <input type="text" class="form-control fecha" name="fecha" id="fecha"> 
                </div>
            </div>            
            
		</form>
	</div>
		
    <div class="modal-footer">
    	<img src="assets/global/img/loading-spinner-grey.gif" border="0" id="load2" width="20" class="oculto" />
		<button type="button" class="btn btn-default btn_ac" data-dismiss="modal">Cancelar</button>
		<button type="button" class="btn btn-success btn_ac" onclick="CambiaFecha()">Aceptar</button>
	</div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->






<!--- Js -->
<script>
$(function(){
	
	
	$('#id_tipo_pago').change(function () { 
	    var id_tipo_pago = $('#id_tipo_pago').val();
	    if(id_tipo_pago==2){
		    $('#fechas').show();
		    $('#concepto').hide();
	    }else{
		    $('#fechas').hide();
		    $('#concepto').show();
	    }
	});
	
	
	
	$('#NuevaVenta').on('hidden.bs.modal',function(e){
		$('#id_tipo_pago').val("0");
		$('.limpia').val("");
		$('#msg_error').hide();
		$('#fechas').hide();
		$('#concepto').hide();
	});
});

function EliminaPagp(id){
	$(".btn_"+id+"").hide();
	$("#load_"+id+"").show();
	$.post('ac/activa_desactiva_usuario.php', { tipo: "0", id_usuario: ""+id+"" },function(data){
		if(data==1){
			window.open("?Modulo=Usuarios", "_self");
		}else{
			$("#load_"+id+"").hide();
			$(".btn_"+id+"").show();
			alert(data);
		}
	});
}

function NuevaVenta(){
	$('#msg_error').hide('Fast');
	$('.btn_ac').hide();
	$('#load').show();
	var datos=$('#frm_guarda').serialize();
	$.post('ac/nuevo_pago.php',datos,function(data){
	    if(data==1){
	    	$('#load').hide();
			$('.btn').show();
			window.open("?Modulo=Pagos&msg=1", "_self");
	    }else{
	    	$('#load').hide();
			$('.btn').show();
			$('#msg_error').html(data);
			$('#msg_error').show('Fast');
	    }
	});
}

function CambiaFecha(){
	var fecha = $('#fecha').val();
	$('.btn_ac').hide();
	$('#load2').show();
	
	if(fecha){
		window.open("?Modulo=Pagos&fecha="+fecha, "_self");
	}else{
		alert("Seleccione una fecha");
		$('#load').hide();
		$('.btn').show();
		return false;
	}
}
</script>