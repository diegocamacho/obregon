<?
$sql="SELECT * FROM salones WHERE activo=1";
$q=mysql_query($sql);
?>
<!-- BEGIN PAGE HEAD--
<div class="page-head">
    <div class="container">

        <div class="page-title">
            <h1>Inscripciones </h1>
        </div>

    </div>
</div>
<!-- END PAGE HEAD-->
<!-- BEGIN PAGE CONTENT BODY -->
<div class="page-content">
    <div class="container">
 	<!-- BEGIN PAGE CONTENT INNER -->
 	<div class="page-content-inner">
	 	
	 	
	 	

 		<div class="row ">
            <div class="col-md-12">
                
                
                
                
                
                <div class="portlet light ">
                    <div class="portlet-title tabbable-line">
                        <div class="caption">
                            <i class="icon-user-follow font-dark"></i>
                            <span class="caption-subject font-dark bold uppercase">Inscripción</span>
                        </div>
                        <ul class="nav nav-tabs">
	                        <li class="active">
                                <a href="#portlet_tab1" data-toggle="tab"> Datos </a>
                            </li>
                            <li>
                                <a href="#portlet_tab2" data-toggle="tab"> Historial de Pagos </a>
                            </li>
                        </ul>
                    </div>
                    <div class="portlet-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="portlet_tab1">
                                <form class="form-horizontal" role="form" id="frm_guarda">
                        		<h4>Datos del tutor</h4>
                        		
                        			<div class="form-group">
                        		        <label for="inputEmail12" class="col-md-2 control-label">Nombre</label>
                        		        <div class="col-md-6">
                        		            <div class="input-icon">
                        		                <i class="fa fa-user"></i>
                        		                <input type="text" class="form-control" name="nombre" id="nombre"> </div>
                        		        </div>
                        		    </div>
                        		    
                        		    <div class="form-group">
                        		        <label for="inputEmail12" class="col-md-2 control-label">Teléfono Celular</label>
                        		        <div class="col-md-3">
                        		            <div class="input-icon">
                        		                <i class="fa fa-phone"></i>
                        		                <input type="text" class="form-control" name="telefono1" id="telefono1"> </div>
                        		        </div>
                        		    </div>
                        		    
                        		    <div class="form-group">
                        		        <label for="inputEmail12" class="col-md-2 control-label">Teléfono de Casa</label>
                        		        <div class="col-md-3">
                        		            <div class="input-icon">
                        		                <i class="fa fa-phone"></i>
                        		                <input type="text" class="form-control" name="telefono2" id="telefono2" > </div>
                        		        </div>
                        		    </div>
                        		    
                        		    <div class="form-group">
                        		        <label for="inputEmail12" class="col-md-2 control-label">Teléfono de Oficina</label>
                        		        <div class="col-md-3">
                        		            <div class="input-icon">
                        		                <i class="fa fa-phone"></i>
                        		                <input type="text" class="form-control" name="telefono3" id="telefono3" > </div>
                        		        </div>
                        		    </div>
                        		    
                        		    <div class="form-group">
                        		        <label for="inputEmail12" class="col-md-2 control-label">Dirección</label>
                        		        <div class="col-md-6">
                        		            <div class="input-icon">
                        		                <i class="fa fa-home"></i>
                        		                <input type="text" class="form-control" name="direccion" id="direccion" > </div>
                        		        </div>
                        		    </div>
                        		    
                        		    <div class="form-group">
                        		        <label for="inputEmail12" class="col-md-2 control-label">Parentesco</label>
                        		        <div class="col-md-6">
                        		            <div class="input-icon">
                        		                <i class="fa fa-user"></i>
                        		                <input type="text" class="form-control" name="parentesco" id="parentesco"> </div>
                        		        </div>
                        		    </div>
                        		    
                        		    <div class="form-group">
                        		        <label for="inputEmail12" class="col-md-2 control-label">Email</label>
                        		        <div class="col-md-6">
                        		            <div class="input-icon">
                        		                <i class="fa fa-envelope"></i>
                        		                <input type="email" class="form-control" name="email" id="email"> </div>
                        		        </div>
                        		    </div>
                        		    
                        		    <!--
                        		    <div class="form-group">
                        		        <label for="inputPassword1" class="col-md-2 control-label">Password</label>
                        		        <div class="col-md-4">
                        		            <div class="input-icon right">
                        		                <i class="fa fa-user"></i>
                        		                <input type="password" class="form-control" id="inputPassword1" placeholder="Password"> </div>
                        		            <div class="help-block"> with right aligned icon </div>
                        		        </div>
                        		    </div>
                        		    
                        		    <div class="form-group">
                        		        <div class="col-md-offset-2 col-md-4">
                        		            <label class="mt-checkbox">
                        		                <input type="checkbox"> Remember me
                        		                <span></span>
                        		            </label>
                        		        </div>
                        		    </div>
                        		    -->
                        		    <div class="form-group">
                        		        <label for="inputEmail12" class="col-md-2 control-label">Notas u Observaciones</label>
                        		        <div class="col-md-6">
                        		            <div class="input-icon">
                        		                <i class="fa fa-book"></i>
                        		                <input type="text" class="form-control" name="notas" id="notas" > </div>
                        		        </div>
                        		    </div>
                        		<hr>
                        		<h4>Contacto Adicional</h4>
                        			<div class="form-group">
                        		        <label for="inputEmail12" class="col-md-2 control-label">Nombre</label>
                        		        <div class="col-md-6">
                        		            <div class="input-icon">
                        		                <i class="fa fa-user"></i>
                        		                <input type="text" class="form-control" name="adicional_nombre" id="adicional_nombre"> </div>
                        		        </div>
                        		    </div>
                        		    
                        		    <div class="form-group">
                        		        <label for="inputEmail12" class="col-md-2 control-label">Teléfono Celular</label>
                        		        <div class="col-md-3">
                        		            <div class="input-icon">
                        		                <i class="fa fa-phone"></i>
                        		                <input type="text" class="form-control" name="adicional_telefono" id="adicional_telefono"> </div>
                        		        </div>
                        		    </div>
                        		
                        		<hr>
                        		<h4>Datos del Alumno</h4>
                        		
                        			<div class="form-group">
                        		        <label for="inputEmail12" class="col-md-2 control-label">Nombre</label>
                        		        <div class="col-md-6">
                        		            <div class="input-icon">
                        		                <i class="fa fa-user"></i>
                        		                <input type="text" class="form-control" name="alumno_nombre" id="alumno_nombre"> </div>
                        		        </div>
                        		    </div>
                        		    
                        		    <div class="form-group">
                        		        <label for="inputEmail12" class="col-md-2 control-label">Fecha de Nacimiento</label>
                        		        <div class="col-md-6">
                        		            <div class="input-icon">
                        		                <i class="fa fa-calendar"></i>
                        		                <input type="text" class="form-control fecha" name="fecha_nacimiento" id="fecha_nacimiento"> </div>
                        		        </div>
                        		    </div>
                        		    
                        		    <div class="form-group">
                        		        <label for="inputEmail12" class="col-md-2 control-label">Sexo</label>
                        		        <div class="col-md-6">
                        		            <select class="form-control" name="sexo">
                        		                <option value="0">Seleccione uno</option>
                        		                <option value="M">Masculino</option>
                        		                <option value="F">Femenino</option>
                        		            </select>
                        		        </div>
                        		    </div>
                        		    
                        		    <div class="form-group">
                        		        <label for="inputEmail12" class="col-md-2 control-label">Condiciones Médicas</label>
                        		        <div class="col-md-6">
                        		            <div class="input-icon">
                        		                <i class="fa fa-wheelchair"></i>
                        		                <input type="text" class="form-control" name="condiciones" id="condiciones"> </div>
                        		        </div>
                        		    </div>
                        		    
                        		    <div class="form-group">
                        		        <label for="inputEmail12" class="col-md-2 control-label">Alergías</label>
                        		        <div class="col-md-6">
                        		            <div class="input-icon">
                        		                <i class="fa fa-plus-square"></i>
                        		                <input type="text" class="form-control" name="alergias" id="alergias"> </div>
                        		        </div>
                        		    </div>
                        		    
                        		    <div class="form-group">
                        		        <label for="inputEmail12" class="col-md-2 control-label">Grupo Sanguineo</label>
                        		        <div class="col-md-6">
                        		            <div class="input-icon">
                        		                <i class="fa fa-heartbeat"></i>
                        		                <input type="text" class="form-control" name="grupo_sanguineo" id="grupo_sanguineo"> </div>
                        		        </div>
                        		    </div>
                        		    
                        		    
                        		    
                        		    <div class="form-group">
                        		        <div class="col-md-offset-2 col-md-10">
                        		            <button type="button" class="btn green" id="btn-inscripcion" >Actualizar</button>
                        		            <img src="assets/global/img/loading-spinner-grey.gif" border="0" id="load" width="20" style="display: none;" />
                        		        </div>
                        		    </div>
                        		</form>
                            </div>
                            <div class="tab-pane" id="portlet_tab2">
                                <h2>Pagos</h2>
                            </div>
                            
                        </div>
                    </div>
                </div>
                
                
                
                
            </div>
        </div>
        
        
        
 	</div>
 	<!-- END PAGE CONTENT INNER -->
    </div>
</div>
<!-- END PAGE CONTENT BODY -->
<!-- END CONTENT BODY -->