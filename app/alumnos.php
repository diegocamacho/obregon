<?
$sql="SELECT *, alumnos.nombre AS alumno, tutores.nombre AS tutor, salones.nombre AS salon FROM alumnos 
JOIN inscripcion ON inscripcion.id_alumno=alumnos.id_alumno
JOIN tutores ON tutores.id_tutor=inscripcion.id_tutor
JOIN salones ON salones.id_salon=inscripcion.id_salon
LEFT JOIN pagos ON pagos.id_alumno=alumnos.id_alumno
WHERE alumnos.activo=1";
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
                            <span class="caption-subject font-dark bold uppercase">Alumnos</span>
                        </div>
                        <ul class="nav nav-tabs">
	                        <li class="active">
                                <a href="#portlet_tab1" data-toggle="tab"> Activos</a>
                            </li>
                            <li>
                                <a href="#portlet_tab2" data-toggle="tab"> Desactivados </a>
                            </li>
                        </ul>
                    </div>
                    <div class="portlet-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="portlet_tab1">
                        		<h4>Alumnos Activos</h4>
                        		
                        		<table class="table table-striped table-bordered table-hover" id="sample_1">
                                    <thead>
                                        <tr>
                                            <th width="30%"> Alumno </th>
                                            <th width="30%"> Tutor </th>
                                            <th> Teléfono </th>
                                            <th> Salón </th>
                                            <th> Horario </th>
                                            <th> Vencimiento </th>
                                            <th>  </th>
                                        </tr>
                                    </thead>
                                    <tbody>
	                                    <? while($ft=mysql_fetch_assoc($q)){ ?>
                                        <tr class="odd gradeX">
                                            
                                            <td><?=$ft['alumno']?></td>
                                            <td><?=$ft['tutor']?></td>
                                            <td><?=$ft['telefono1']?></td>
                                            <td> <?=$ft['salon']?> </td>
                                            <td> <?=substr($ft['horario'],0,5)?> </td>
                                            <td> <?=fechaLetra($ft['fecha_final'])?> </td>
                                            <td align="right">
	                                            <a href="?Modulo=EditaAlumno&id=<?=$ft['id_alumno']?>" class="btn sbold green btn-xs" role="button">Perfil</a>
                                            </td>
                                        </tr>
                                        <? } ?>
                                    </tbody>
                                </table>	
                            </div>
                            <div class="tab-pane" id="portlet_tab2">
                                <h4>Alumnos Desactivados</h4>
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
<script>

</script>