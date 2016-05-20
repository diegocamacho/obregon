<?
$sql="SELECT * FROM usuarios 
JOIN tipo_usuario ON tipo_usuario.id_tipo_usuario=usuarios.id_tipo_usuario
WHERE activo=1
ORDER BY usuarios.id_tipo_usuario ASC";
$q=mysql_query($sql);

if($s_tipo!=1){  
	exit();
}
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
					  		<p>El usuario se ha agregado</p>
					  	</div>
				  <? }if($_GET['msg']==2){ ?>
				  		<br>
				  		<div class="alert alert-dismissable alert-info">
					  		<button type="button" class="close" data-dismiss="alert">×</button>
					  		<p>El usuario se ha editado</p>
					  	</div>
				  <? } ?>
				  <!-- Contenido -->
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
				<div class="portlet light">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-users font-green-sharp"></i>
							<span class="caption-subject font-green-sharp bold uppercase">Usuarios</span>
						</div>
						<div class="actions btn-set">
							<a href="javascript:;" class="btn btn-sm btn-circle blue easy-pie-chart-reload" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#NuevoUsuario"><i class="fa fa-plus"></i> Agregar usuario </a>
						</div>
					</div>
					<div class="portlet-body">
						<table class="table table-striped table-bordered table-hover">
							<thead>
						        <tr>
						          <th>Nombre</th>
						          <th>Tipo</th>
						          <th>Celular</th>
						          <th>Email</th>
						          <th>Último Acceso</th>
						          <th width="180"></th>
						        </tr>
						      </thead>
						      <tbody>
						      <? while($ft=mysql_fetch_assoc($q)){ ?>
						        <tr>
						          <td><?=$ft['nombre']?></td>
						          <td><?=$ft['tipo_usuario']?></td>
						          <td><?=$ft['celular']?></td>
						          <td><?=$ft['email']?></td>
						          <td><? if($ft['ultimo_acceso']){ echo devuelveFechaHora($ft['ultimo_acceso']); }else{ echo "NUNCA"; }?></td>
						          <td align="right">
						          		<img src="assets/global/img/loading-spinner-grey.gif" border="0" id="load_<?=$ft['id_usuario']?>" width="19" class="oculto" />
						          	<? if($ft['activo']==1){ ?>
						          		<span class="label label-success link btn_<?=$ft['id_usuario']?>" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#EditaUsuario" data-id="<?=$ft['id_usuario']?>">Editar</span> &nbsp; &nbsp; 
						          		<span class="label label-danger link btn_<?=$ft['id_usuario']?>" onclick="javascript:Desactiva(<?=$ft['id_usuario']?>)">Desactivar</span>
						          	<? }else{ ?>
						          		<span class="label label-warning link btn_<?=$ft['id_usuario']?>" onclick="javascript:Activa(<?=$ft['id_usuario']?>)">Activar</span>
						          	<? } ?>
						          </td>
						        </tr>
						      <? } ?>
						      </tbody>
						</table>
					</div>
				</div>
				<!-- END EXAMPLE TABLE PORTLET-->
			</div>
		</div>

    </div>
</div>












<!-- Modal -->
<div class="modal fade" id="NuevoUsuario">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
        <h4 class="modal-title">Nuevo Usuario</h4>
      </div>
      <div class="modal-body">
      	<div class="alert alert-danger oculto" role="alert" id="msg_error"></div>
<!--Formulario -->
		<form id="frm_guarda" class="form-horizontal">
			
			<div class="form-group">
				<label for="nombre" class="col-md-3 control-label">Tipo de Usuario</label>
				<div class="col-md-9">
					<select class="form-control" name="id_tipo_usuario">
                    	<option></option>
                    	<?
	                    $sq="SELECT * FROM tipo_usuario WHERE usa=1";	
	                    $q=mysql_query($sq);
	                    while($ft=mysql_fetch_assoc($q)){
						?>
						<option value="<?=$ft['id_tipo_usuario']?>"><?=$ft['tipo']?></option>
						<? } ?>
					</select>
				</div>
			</div>
			
			<div class="form-group">
				<label for="nombre" class="col-md-3 control-label">Nombre</label>
				<div class="col-md-9">
					<input type="text" maxlength="64" class="form-control dat" name="nombre" id="nuevo_nombre" autocomplete="off">
				</div>
			</div>
			
			<div class="form-group">
				<label for="email" class="col-md-3 control-label">Email</label>
				<div class="col-md-9">
					<input type="text" maxlength="64" class="form-control dat" name="email" autocomplete="off">
				</div>
			</div>
			
			<div class="form-group">
				<label for="celular" class="col-md-3 control-label">Celular</label>
				<div class="col-md-9">
					<input type="text" maxlength="10" class="form-control dat" name="celular" autocomplete="off">
				</div>
			</div>
			
			<div class="form-group">
				<label for="password" class="col-md-3 control-label">Contraseña</label>
				<div class="col-md-9">
					<input type="text" maxlength="16" class="form-control dat" name="password" autocomplete="off">
				</div>
			</div>

		</form>
		      
      </div>
      <div class="modal-footer">
      	<img src="assets/global/img/loading-spinner-grey.gif" border="0" id="load" width="30" class="oculto" />
        <button type="button" class="btn btn-default btn_ac" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success btn_ac" onclick="NuevoUsuario()">Guardar Usuario</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->




<!-- Modal -->
<div class="modal fade" id="EditaUsuario">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
        <h4 class="modal-title">Edita Usuario</h4>
      </div>
      <div class="modal-body">
      	<div class="alert alert-danger oculto" role="alert" id="msg_error2"></div>
<!-- Loader -->
		<div class="row oculto" id="load_big">
			<div class="col-md-12 text-center" >
				<img src="assets/global/img/Preloader_3.gif" border="0" width="125" />
			</div>
		</div>
<!--Formulario -->
		<form id="frm_edita" class="form-horizontal">
			
			<div class="form-group">
				<label for="nombre" class="col-md-3 control-label">Tipo de Usuario</label>
				<div class="col-md-9">
					<select class="form-control" name="id_tipo_usuario" id="id_tipo_usuario">
                    	<option></option>
                    	<?
	                    $sq="SELECT * FROM tipo_usuario WHERE usa=1";	
	                    $q=mysql_query($sq);
	                    while($ft=mysql_fetch_assoc($q)){
						?>
						<option value="<?=$ft['id_tipo_usuario']?>"><?=$ft['tipo']?></option>
						<? } ?>
					</select>
				</div>
			</div>
			
			<div class="form-group">
				<label for="nombre" class="col-md-3 control-label">Nombre</label>
				<div class="col-md-9">
					<input type="text" maxlength="64" class="form-control edit" id="nombre" name="nombre" autocomplete="off">
				</div>
			</div>
			
			<div class="form-group">
				<label for="email" class="col-md-3 control-label">Email</label>
				<div class="col-md-9">
					<input type="text" maxlength="64" class="form-control edit" id="email" name="email" autocomplete="off">
				</div>
			</div>
			
			<div class="form-group">
				<label for="celular" class="col-md-3 control-label">Celular</label>
				<div class="col-md-9">
					<input type="text" maxlength="24" class="form-control edit" id="celular" name="celular" autocomplete="off">
				</div>
			</div>
			
			<div class="form-group">
				<label for="password" class="col-md-3 control-label">Contraseña</label>
				<div class="col-md-9">
					<input type="text" maxlength="16" class="form-control edit" name="password" placeholder="Cambiar la contraseña" autocomplete="off">
				</div>
			</div>
			
			
			<input type="hidden" name="id_usuario" id="id_usuario" />
		</form>
		      
      </div>
      <div class="modal-footer">      	
      	<img src="assets/global/img/loading-spinner-grey.gif" border="0" id="load2" width="30" class="oculto" />
        <button type="button" class="btn btn-default btn_ac btn-modal" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success btn_ac btn-modal" onclick="EditaUsuario()">Actualizar Usuario</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<!--- Js -->
<script>
$(function(){
	$(document).on('click', '[data-id]', function () {
		$('.edit').val("");
		$('.btn-modal').hide();
		$('#frm_edita').hide();
		$('#load_big').show();
	    var data_id = $(this).attr('data-id');
	    $.ajax({
	   	url: "data/usuarios.php",
	   	data: 'id_usuario='+data_id,
	   	success: function(data){
		   	
	   		var datos = data.split('|');
	   		var id_tipo_usuario=datos[0];
	   		var nombre=datos[1];
	   		var email=datos[2];
	   		var celular=datos[3];
	   		
	   		$('#id_tipo_usuario').val(id_tipo_usuario);
	   		$('#nombre').val(nombre);
	   		$('#email').val(email);
	   		$('#celular').val(celular);
	   		$('#id_usuario').val(data_id);
	   		
	   		
	   		$('#load_big').hide();
	   		$('#frm_edita').show();
	   		$('.btn-modal').show();
	  	
	   	},
	   	cache: false
	   });
	});
	
	
	$('#NuevoUsuario').on('shown.bs.modal',function(e){
		$('#nuevo_nombre').focus();
	});
	
	$('#NuevoUsuario').on('hidden.bs.modal',function(e){
		$('#id_tipo_usuario').val("0");
		$('.dat').val("");
		$('#msg_error2').hide();
		$('#msg_error').hide();
		$('#ver_permisos').hide();
	});
	
	$('#EditaUsuario').on('hidden.bs.modal',function(e){
		$('.edit').val("");
		$('#msg_error2').hide();
		$('#msg_error').hide();
	});
});

function EditaUsuario(){
	$('#msg_error2').hide('Fast');
	$('.btn_ac').hide();
	$('#load2').show();
	var datos=$('#frm_edita').serialize();
	$.post('ac/edita_usuario.php',datos,function(data){
	    if(data==1){
	    	$('#load2').hide();
			$('.btn').show();
			window.open("?Modulo=Usuarios&msg=2", "_self");
	    }else{
	    	$('#load2').hide();
			$('.btn').show();
			$('#msg_error2').html(data);
			$('#msg_error2').show('Fast');
	    }
	});
}
function Desactiva(id){
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
function Activa(id){
	$(".btn_"+id+"").hide();
	$("#load_"+id+"").show();
	$.post('ac/activa_desactiva_usuario.php', { tipo: "1", id_usuario: ""+id+"" },function(data){
		if(data==1){
			window.open("?Modulo=Usuarios", "_self");
		}else{
			$("#load_"+id+"").hide();
			$(".btn_"+id+"").show();
			alert(data);
		}
	});
}
function NuevoUsuario(){
	$('#msg_error').hide('Fast');
	$('.btn_ac').hide();
	$('#load').show();
	var datos=$('#frm_guarda').serialize();
	$.post('ac/nuevo_usuario.php',datos,function(data){
	    if(data==1){
	    	$('#load').hide();
			$('.btn').show();
			window.open("?Modulo=Usuarios&msg=1", "_self");
	    }else{
	    	$('#load').hide();
			$('.btn').show();
			$('#msg_error').html(data);
			$('#msg_error').show('Fast');
	    }
	});
}
</script>