
<?php
$subtitulo="";
	if(isset($_POST["operacion"])){	//nivel3
		if($_POST["aceptar"]!="Descartar"){
			//print_r($_FILES);
			$fotoE="";$fotoA1="";$fotoA2="";
			if (isset($_FILES["fotopac"])){
				if (is_uploaded_file($_FILES["fotopac"]["tmp_name"])){

					$cfoto=explode(".",$_FILES["fotopac"]["name"]);
					$archivo=$_POST["docpac"].".".$cfoto[count($cfoto)-1];

					if(move_uploaded_file($_FILES["fotopac"]["tmp_name"],LOG.PACIENTES.$archivo)){
						$fotoE=",fotopac='".PACIENTES.$archivo."'";
						$fotoA1=",fotopac";
						$fotoA2=",'".PACIENTES.$archivo."'";
						}
				}
			}
			switch ($_POST["operacion"]) {
			case 'VI':
			$ant=$_POST['id_hc_principal'];
			if ($ant=='') {
				$sql="INSERT INTO val_inifisio_dom (id_adm_hosp, id_user, freg_fisio_dom, hreg_fisio_dom, motivo_consulta,
													 dolor, pf, sencibilidad, fosteomuscular, postura,
													marcha, dx_fisioterapeutico, pron_fisioterapeutico, plan_intervencion, obj_terapeutico, estado_fisio_dom) VALUES
											('".$_POST["idadmhosp"]."',
							'".$_SESSION["AUT"]["id_user"]."',
							'".$_POST["freg"]."',
							'".$_POST["hreg"]."',
							'".$_POST["motivo_consulta"]."',
							'".$_POST["dolor"]."',
							'".$_POST["pf"]."',
							'".$_POST["sencibilidad"]."',
							'".$_POST["fosteomuscular"]."',
							'".$_POST["postura"]."',
							'".$_POST["marcha"]."',
							'".$_POST["dx_fisioterapeutico"]."',
							'".$_POST["pron_fisioterapeutico"]."',
							'".$_POST["plan_intervencion"]."',
							'".$_POST["obj_terapeutico"]."',
							'Realizada') ;";
						$sql1="INSERT INTO hc_principal (id_paciente, ant_alergicos, ant_patologicos, ant_quirurgico, ant_toxicologico, ant_farmaco,
							ant_gineco, ant_psiquiatrico, ant_hospitalario, ant_traumatologico, ant_familiar, otros_ant)
							VALUES ('".$_POST["paciente"]."','".$_POST["ant_alergicos"]."','".$_POST["ant_patologicos"]."','".$_POST["ant_quirurgico"]."','".$_POST["ant_toxicologico"]."',
								'".$_POST["ant_farmaco"]."','".$_POST["ant_gineco"]."','".$_POST["ant_psiquiatrico"]."','".$_POST["ant_hospitalario"]."','".$_POST["ant_traumatologico"]."',
								'".$_POST["ant_familiar"]."','".$_POST["otros_ant"]."')";
				$subtitulo="Valoracion inicial Adicionada con exito";

			}
			if ($ant!='') {
				$sql="INSERT INTO val_inifisio_dom (id_adm_hosp, id_user, freg_fisio_dom, hreg_fisio_dom, motivo_consulta,
													 dolor, pf, sencibilidad, fosteomuscular, postura,
													marcha, dx_fisioterapeutico, pron_fisioterapeutico, plan_intervencion, obj_terapeutico, estado_fisio_dom) VALUES
											('".$_POST["idadmhosp"]."',
							'".$_SESSION["AUT"]["id_user"]."',
							'".$_POST["freg"]."',
							'".$_POST["hreg"]."',
							'".$_POST["motivo_consulta"]."',
							'".$_POST["dolor"]."',
							'".$_POST["pf"]."',
							'".$_POST["sencibilidad"]."',
							'".$_POST["fosteomuscular"]."',
							'".$_POST["postura"]."',
							'".$_POST["marcha"]."',
							'".$_POST["dx_fisioterapeutico"]."',
							'".$_POST["pron_fisioterapeutico"]."',
							'".$_POST["plan_intervencion"]."',
							'".$_POST["obj_terapeutico"]."',
							'Realizada') ;";
						$sql1="UPDATE hc_principal SET ant_alergicos='".$_POST["ant_alergicos"]."', ant_patologicos='".$_POST["ant_patologicos"]."', ant_quirurgico='".$_POST["ant_quirurgico"]."',
						 															 ant_toxicologico='".$_POST["ant_toxicologico"]."', ant_farmaco='".$_POST["ant_farmaco"]."',ant_gineco='".$_POST["ant_gineco"]."',
																					 ant_psiquiatrico='".$_POST["ant_psiquiatrico"]."', ant_hospitalario='".$_POST["ant_hospitalario"]."', ant_traumatologico='".$_POST["ant_traumatologico"]."',
																					 ant_familiar='".$_POST["ant_familiar"]."', otros_ant='".$_POST["otros_ant"]."' WHERE id_paciente='".$_POST["paciente"]."' ";

				$subtitulo="Valoracion inicial Adicionada con exito";
			}
			break;
			case 'EVO':
				$fecha =date('Y-m-d');
				$nuevafecha = strtotime ( '-30 day' , strtotime ( $fecha ) ) ;
				$nuevafecha = date ( 'Y-m-d' , $nuevafecha );
				$f1=$nuevafecha;
				$f2=$_POST['freg'];

				if ($f1 < $f2) {
					$horaInicial=$_POST["hregevo"];
					$horat= strtotime ( '+40 minute' , strtotime ( $horaInicial ) ) ;
					$ht=date('H:i',$horat);
					$sql="INSERT INTO evo_fisio_dom (id_adm_hosp, id_user,id_d_aut_dom,freg_reg,freg_evofisio_dom, hreg_evofisio_dom, hreg_regfisio_dom, hfin_evofisio_dom, evolucionfisio_dom, estado_evofisio_dom) VALUES
					('".$_POST["idadmhosp"]."','".$_SESSION["AUT"]["id_user"]."','".$_POST["idd"]."','".$_POST["fregreg"]."','".$_POST["freg"]."','".$_POST["hregevo"]."','".$_POST["hreg"]."','$ht','".$_POST["evoto"]."','Realizada')";
					$subtitulo="Evolucion adicionada con exito";

				}
				if ($f1 >= $f2) {
					$horaInicial=$_POST["hregevo"];
					$horat= strtotime ( '+40 minute' , strtotime ( $horaInicial ) ) ;
					$ht=date('H:i',$horat);
					$sql="INSERT INTO evo_fisio_dom (  freg_reg,freg_evofisio_dom, hreg_evofisio_dom, hreg_regfisio_dom, hfin_evofisio_dom, evolucionfisio_dom, estado_evofisio_dom) VALUES
					('".$_POST["idadmhosp"]."','".$_SESSION["AUT"]["id_user"]."','".$_POST["fregreg"]."','".$_POST["freg"]."','".$_POST["hregevo"]."','".$_POST["hreg"]."','$ht','".$_POST["evoto"]."','Realizada')";
					$subtitulo="HEYYY, no se pueden realizar evoluciones menores a 30 días de retrazo";

				}

			break;
			case 'EVOP':
			$horaInicial=$_POST["hregevo"];
			$horat= strtotime ( '+40 minute' , strtotime ( $horaInicial ) ) ;
			$ht=date('H:i',$horat);
			$fecha =date('Y-m-d');
			$sql="INSERT INTO evo_fisio_dom (id_adm_hosp, id_user,freg_reg,freg_evofisio_dom, hreg_evofisio_dom, hreg_regfisio_dom, hfin_evofisio_dom, evolucionfisio_dom, estado_evofisio_dom) VALUES
			('".$_POST["idadmhosp"]."','".$_SESSION["AUT"]["id_user"]."','$fecha','".$_POST["freg"]."','".$_POST["hregevo"]."','".$_POST["hreg"]."','$ht','".$_POST["evoto"]."','Realizada')";
			$subtitulo="Evolucion";
			$subtitulo1="Adicionado";
			$subtitulo2="Terapia Fisica";
			break;

		}
		//echo $sql;
		//echo $sql1;
		if ($bd1->consulta($sql)){
			$subtitulo="$subtitulo fue $subtitulo1 con exito!";
			$check='si';
			if ($bd1->consulta($sql1)) {
					$subtitulo="$subtitulo fue $subtitulo1 con exito!";
					$check='si';
			}
		}else{
			$subtitulo="$subtitulo NO fue $subtitulo1 !!! .$subtitulo2";
			$check='no';
		}
	}
}

if (isset($_GET["mante"])){					///nivel 2
	switch ($_GET["mante"]) {
		case 'VI':
    $sql="SELECT a.id_paciente,tdoc_pac,a.doc_pac,nom1,nom2,ape1,ape2,edad,fnacimiento,dir_pac,tel_pac,rh,email_pac,genero,lateralidad,religion,fotopac,
    b.id_adm_hosp,fingreso_hosp,hingreso_hosp,fegreso_hosp,hegreso_hosp,
    j.nom_eps
    from pacientes a left join adm_hospitalario b on a.id_paciente=b.id_paciente
                left join eps j on (j.id_eps=b.id_eps)
    where b.id_adm_hosp ='".$_GET["idadmhosp"]."'" ;
      $boton="Agregar Valoracion";
			$atributo1=' readonly="readonly"';
			$atributo2='';
			$atributo3='';
			$date=date('Y-m-d');
			$date1=date('H:i');
			$doc=$_REQUEST['doc'];
			$form1='formulariosDOM/FISIO/val_inifisio_dom.php';
			$subtitulo='Valoracion inicial Terapia Fisica';
			break;
			case 'EVO':
      $sql="SELECT a.id_paciente,tdoc_pac,a.doc_pac,nom1,nom2,ape1,ape2,edad,fnacimiento,dir_pac,tel_pac,rh,email_pac,genero,lateralidad,religion,fotopac,
      b.id_adm_hosp,fingreso_hosp,hingreso_hosp,fegreso_hosp,hegreso_hosp,
      j.nom_eps
      from pacientes a left join adm_hospitalario b on a.id_paciente=b.id_paciente
                  left join eps j on (j.id_eps=b.id_eps)
      where b.id_adm_hosp ='".$_GET["idadmhosp"]."'" ;
      $boton="Agregar Evolucion";
			$atributo1=' readonly="readonly"';
			$atributo2='';
			$atributo3='';
			$date=date('Y-m-d');
			$date1=date('H:i');
			$doc=$_REQUEST['doc'];
			$form1='formularios/evo_fisio_dom5.php';
			$subtitulo='Evolucion Diaria Terapia Fisica';
			break;
			case 'EVOP':
			$sql="SELECT a.id_paciente,tdoc_pac,a.doc_pac,nom1,nom2,ape1,ape2,edad,fnacimiento,dir_pac,tel_pac,rh,email_pac,genero,lateralidad,religion,fotopac,
			b.id_adm_hosp,fingreso_hosp,hingreso_hosp,fegreso_hosp,hegreso_hosp,
			j.nom_eps
			from pacientes a left join adm_hospitalario b on a.id_paciente=b.id_paciente
									left join eps j on (j.id_eps=b.id_eps)
			where b.id_adm_hosp ='".$_GET["idadmhosp"]."'" ;
			$boton="Agregar Evolucion";
			$atributo1=' readonly="readonly"';
			$atributo2='';
			$atributo3='';
			$date=date('Y-m-d');
			$date1=date('H:i');
			$opcion=$_REQUEST['opcion'];
			$form1='formulariosDOM/evo_pendiente_dom.php';
			$subtitulo='Evolucion pendiente';
			break;
		}
//echo $sql;
		if($sql!=""){
			if (!$fila=$bd1->sub_fila($sql)){
				$fila=array("id_paciente"=>"","tdoc_pac"=>"","doc_pac"=>"","nom1"=>"","nom2"=>"","ape1"=>"","ape2"=>"","edad"=>"",
				"fnacimiento"=>"","dir_pac"=>"","tel_pac"=>"","rh"=>"","email_pac"=>"","genero"=>"","lateralidad"=>"",
				"religion"=>"","fotopac"=>"","id_adm_hosp"=>"","fingreso_hosp"=>"","hingreso_hosp"=>"","fegreso_hosp"=>"","hegreso_hosp"=>"", "nom_eps"=>"");
			}
		}else{
				$fila=array("id_paciente"=>"","tdoc_pac"=>"","doc_pac"=>"","nom1"=>"","nom2"=>"","ape1"=>"","ape2"=>"","edad"=>"",
				"fnacimiento"=>"","dir_pac"=>"","tel_pac"=>"","rh"=>"","email_pac"=>"","genero"=>"","lateralidad"=>"",
				"religion"=>"","fotopac"=>"","id_adm_hosp"=>"","fingreso_hosp"=>"","hingreso_hosp"=>"","fegreso_hosp"=>"","hegreso_hosp"=>"", "nom_eps"=>"");
			}

		?>

		<?php include($form1);?>

<?php
}else{
if ($check=='si') {
	echo'<section>';
	echo '<script>swal("EXCELENTE !!! '.$subtitulo.'","","success")</script>';
	echo'</section>';
}if ($check=='no') {
	echo'<section>';
	echo '<script>swal("DEBES REVISAR EL PROCESO !!! '.$subtitulo.'","","error")</script>';
	echo'</section>';
}
// nivel 1?>
<section class="panel-default">
	<section class="panel-heading"><h4>Fisioterapia Servicios Domiciliarios</h4></section>
<section class="panel-body">
	<section class="col-md-4">
		<form>
			<div class="row">
				<div class="col-lg-12">
					<div class="input-group">
						<input type="text" class="form-control" name="doc" placeholder="Digite identificación">
						<span class="input-group-btn">
								<input type="submit" name="buscar" class="btn btn-primary" value="Consultar">
								<input type="hidden" name="opcion" Value="<?php echo $_GET["opcion"];?>"/>
						</span>
					</div><!-- /input-group -->
				</div><!-- /.col-lg-6 -->
			</div>
		</form>
		<br>
		<form>
			<div class="row">
				<div class="col-lg-12">
					<div class="input-group">
						<input type="text" class="form-control" name="nom" placeholder="Digite nombre o apellidos">
						<span class="input-group-btn">
								<input type="submit" name="buscar" class="btn btn-primary" value="Consultar">
								<input type="hidden" name="opcion" Value="<?php echo $_GET["opcion"];?>"/>
						</span>
					</div><!-- /input-group -->
				</div><!-- /.col-lg-6 -->
			</div>
		</form>
	</section>

	</section>
	<section class="panel-body">
		<table class="table table-bordered">
			<tr>
				<th class="info">PACIENTE</th>
				<th class="info">INGRESO</th>
				<th class="info">SERVICIOS <br> AUTORIZADOS</th>
				<th class="info">Registro asistencial</th>
			</tr>

			<?php
			if (isset($_REQUEST["doc"])){
			$doc=$_REQUEST["doc"];
			$sql="SELECT p.id_paciente,tdoc_pac,doc_pac,nom1,nom2,ape1,ape2,fotopac,
									 a.id_adm_hosp,fingreso_hosp,hingreso_hosp,
									 s.nom_sedes,
									 e.nom_eps,e.id_eps ide
						FROM pacientes p LEFT JOIN adm_hospitalario a on p.id_paciente=a.id_paciente
														 LEFT JOIN sedes_ips s on a.id_sedes_ips=s.id_sedes_ips
														 INNER JOIN eps e on a.id_eps=e.id_eps
					  WHERE p.doc_pac='".$doc."' and a.estado_adm_hosp='Activo' and tipo_servicio='Domiciliarios' ";

			if ($tabla=$bd1->sub_tuplas($sql)){
				foreach ($tabla as $fila) {


					echo"<tr>	\n";
					echo'<td class="text-center">
								<p><strong>NOMBRE: </strong> '.$fila["nom1"].' '.$fila["nom2"].' '.$fila["ape1"].' '.$fila["ape2"].'</p>
								<p><strong>IDENTIFICACIÓN: </strong> '.$fila["tdoc_pac"].' '.$fila["doc_pac"].'</p>
								<p><strong>AMD: </strong> '.$fila["id_adm_hosp"].'</p>
							 </td>';
					echo'<td class="text-left">
								<p><strong>FECHA INGRESO: </strong> '.$fila["fingreso_hosp"].' '.$fila["hingreso_hosp"].' </p>
								<p><strong>SEDE: </strong> '.$fila["nom_sedes"].'</p>
								<p><strong>EPS: </strong> '.$fila["nom_eps"].'</p>
							 </td>';

								$adm=$fila['id_adm_hosp'];
								$hoy=date('Y-m-d');
								$profesional=$_SESSION['AUT']['id_user'];
								$sql_detalle="SELECT a.id_m_aut_dom, id_adm_hosp, zona_paciente,cdx_presentacion,dx_presentacion,
																		 b.id_d_aut_dom, cups, procedimiento, cantidad, finicio, ffinal, num_aut_externa, estado_d_aut_dom, intervalo, temporalidad, profesional, f_prof,
																		 c.nomclaseusuario
															FROM m_aut_dom a INNER JOIN d_aut_dom b on a.id_m_aut_dom=b.id_m_aut_dom
																							 INNER JOIN clase_usuario c on a.tipo_paciente=c.id_cusuario
															WHERE a.id_adm_hosp=$adm and b.estado_d_aut_dom in (1,2) and b.cups='890111'";
								//echo $sql_detalle;
								if ($tabla_detalle=$bd1->sub_tuplas($sql_detalle)){
									foreach ($tabla_detalle as $fila_detalle) {
										$hoy=date('Y-m-d');
										$fini=$fila_detalle['finicio'];
										$ffin=$fila_detalle['ffinal'];
										if ($hoy >= $fini && $hoy <= $ffin ) {
											echo'<td class="text-left">';
											echo'<p><strong>ID: </strong> '.$fila_detalle["id_d_aut_dom"].'</p>';
											echo'<p><strong>CUPS: </strong> '.$fila_detalle["cups"].' '.$fila_detalle["procedimiento"].'</p>';
											echo'<p><strong>CANTIDAD AUTORIZADA: </strong> '.$fila_detalle["cantidad"].' <strong>INTERVALO:</strong> '.$fila_detalle["intervalo"].' Min</p>';
											echo'<p class="text-danger"><strong>VIGENCIA AUTORIZACIÓN: </strong> '.$fila_detalle["finicio"].' -- '.$fila_detalle["ffinal"].'</p>';
											echo'</td>';
											$idd=$fila_detalle['id_d_aut_dom'];
											$sql_profesional="SELECT profesional FROM profesional_d_dom WHERE id_d_aut_dom=$idd and estado_profesional=1";
											//echo $sql_profesional;
											if ($tabla_profesional=$bd1->sub_tuplas($sql_profesional)){
												foreach ($tabla_profesional as $fila_profesional) {
													$realizador=$_SESSION['AUT']['id_user'];
													$prof_autorizado=$fila_profesional['profesional'];

													if ($realizador === $prof_autorizado) {
														echo'<th class="text-center">';
														echo'<p><a href="'.PROGRAMA.'?opcion='.$_REQUEST["opcion"].'&mante=VI&idadmhosp='.$fila["id_adm_hosp"].'&idd='.$fila_detalle["id_d_aut_dom"].'&doc='.$fila["doc_pac"].'"><button type="button" class="btn btn-primary sombra_movil" ><span class="fa fa-plus-circle"></span> Valoración Inicial</button></a></p>
																 <p><a href="'.PROGRAMA.'?opcion='.$_REQUEST["opcion"].'&mante=EVO&idadmhosp='.$fila["id_adm_hosp"].'&idd='.$fila_detalle["id_d_aut_dom"].'&doc='.$fila["doc_pac"].'"><button type="button" class="btn btn-warning sombra_movil" ><span class="fa fa-plus-circle"></span> Evolución</button></a></p>
																 <p><button type="button" class="btn btn-info" data-toggle="modal" data-target="#evolucion_'.$fila_detalle["id_d_aut_dom"].'"><span class="fa fa-search"></span> Consultar Evoluciones</button></p>';
																 ?>
																 <div id="<?php echo 'evolucion_'.$fila_detalle["id_d_aut_dom"] ?>" class="modal fade" role="dialog">
																	  <div class="modal-dialog">

																	    <!-- Modal content-->
																	    <div class="modal-content">
																	      <div class="modal-header">
																	        <button type="button" class="close" data-dismiss="modal">&times;</button>
																	        <h4 class="modal-title">Historico de Evoluciones</h4>
																	      </div>
																	      <div class="modal-body">
																	        <?php
																						$idd=$fila_detalle["id_d_aut_dom"];
																						$sql_evolucion="SELECT a.id_evofisio_dom, id_adm_hosp,  id_d_aut_dom, freg_reg, freg_evofisio_dom,
																																	 hreg_evofisio_dom, hreg_regfisio_dom, hfin_evofisio_dom, evolucionfisio_dom, estado_evofisio_dom,
																																	 b.nombre
																														FROM evo_fisio_dom a inner join user b on a.id_user=b.id_user WHERE a.id_d_aut_dom=$idd and estado_evofisio_dom='Realizada'";
																						if ($tabla_evolucion=$bd1->sub_tuplas($sql_evolucion)){
																							foreach ($tabla_evolucion as $fila_evolucion) {
																								echo'<section class="panel-body">
																											<article class="col-md-8">';
																								echo'<p class="col-md-12"><button data-toggle="collapse" class="btn btn-primary text-center" data-target="#evofisio_'.$fila_evolucion['id_evofisio_dom'].'">Evolucion '.$fila_evolucion["freg_evofisio_dom"].'<span class="glyphicon glyphicon-arrow-down"></span> </button></p>';
																								echo'</article>';
																								echo'<article class="col-md-4">';
																								echo'<p  class="col-md-12"><a href="Funcion_base/borrar_evofisio_dom.php?idadmhosp='.$fila["id_adm_hosp"].'&doc='.$fila["doc_pac"].'&id='.$fila_evolucion['id_evofisio_dom'].'&resp='.$_SESSION['AUT']['id_user'].'"><button type="button" class="btn btn-danger" ><span class="fa fa-trash"></span> Invalidar</button></a></p>';
																								echo'</article>';
																								echo'</section>';
																								echo'<section id="evofisio_'.$fila_evolucion['id_evofisio_dom'].'" class="collapse">';
																								echo"<article class='col-md-6'>\n";
																									echo'<p class="text-center text-"><strong><span class="fa fa-calendar"></span> '.$fila_evolucion["freg_evofisio_dom"].'</strong></p>';
																								echo"</article>";
																								echo"<article class='col-md-6'>";
																									echo'<p class="text-center success"><strong><span class="fa fa-nurse"></span> '.$fila_evolucion["nombre"].' </strong></p>';
																								echo"</article>";
																								echo"<article class='col-md-3'>";
																									echo'<p class="text-success"><strong><span class="fa fa-nurse"></span> '.$fila_evolucion["hreg_evofisio_dom"].' </strong></p>';
																								echo"</article>";
																								echo"<article class='col-md-9'>";
																									echo'<p class="text-left"> '.$fila_evolucion["evolucionfisio_dom"].' </p>';
																								echo"</article>";

																								echo'</section>';
																							}
																						}
																					 ?>
																	      </div>
																	      <div class="modal-footer">
																	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																	      </div>
																	    </div>

																	  </div>
																	</div>
																 <?php
														echo'</th>';
													}else {
														echo'<th class="text-center">';
														echo'<p class="alert alert-danger animated bounceIn"><span class="fa fa-ban fa-4x"></span></p>';
														echo'</th>';
													}

												}
											}// fin validacion profesional
										}else {
											echo'<th class="text-center"><p class="alert alert-danger animated bounceIn">Upss... Procedimiento no autorizado por fecha .</p></th>';
											echo'<th class="text-center"><p class="alert alert-danger animated bounceIn"><span class="fa fa-ban fa-4x"></span></p></th>';
										}

									}
								}else {
									echo'<th class="text-center">
												<p>El paciente no tiene servicios autorizados para fisioterapia</p>
											 </th>';
								}


					echo "</tr>\n";
				}
			}
		}
		if (isset($_REQUEST["nom"])){
			$doc=$_REQUEST["nom"];
			$sql="SELECT p.id_paciente,tdoc_pac,doc_pac,nom1,nom2,ape1,ape2,fotopac,
									 a.id_adm_hosp,fingreso_hosp,hingreso_hosp,
									 s.nom_sedes,
									 e.nom_eps,e.id_eps ide
						FROM pacientes p LEFT JOIN adm_hospitalario a on p.id_paciente=a.id_paciente
														 LEFT JOIN sedes_ips s on a.id_sedes_ips=s.id_sedes_ips
														 INNER JOIN eps e on a.id_eps=e.id_eps
			WHERE p.nom_completo LIKE '%".$doc."%' and a.estado_adm_hosp='Activo'  and tipo_servicio='Domiciliarios' ";
//echo $sql;
			if ($tabla=$bd1->sub_tuplas($sql)){

				foreach ($tabla as $fila ) {
					echo"<tr>	\n";
					echo'<td class="text-center">
								<p><strong>NOMBRE: </strong> '.$fila["nom1"].' '.$fila["nom2"].' '.$fila["ape1"].' '.$fila["ape2"].'</p>
								<p><strong>IDENTIFICACIÓN: </strong> '.$fila["tdoc_pac"].' '.$fila["doc_pac"].'</p>
								<p><strong>AMD: </strong> '.$fila["id_adm_hosp"].'</p>
							 </td>';
					echo'<td class="text-left">
								<p><strong>FECHA INGRESO: </strong> '.$fila["fingreso_hosp"].' '.$fila["hingreso_hosp"].' </p>
								<p><strong>SEDE: </strong> '.$fila["nom_sedes"].'</p>
								<p><strong>EPS: </strong> '.$fila["nom_eps"].'</p>
							 </td>';

								$adm=$fila['id_adm_hosp'];
								$hoy=date('Y-m-d');
								$profesional=$_SESSION['AUT']['id_user'];
								$sql_detalle="SELECT a.id_m_aut_dom, id_adm_hosp, zona_paciente,cdx_presentacion,dx_presentacion,
																		 b.id_d_aut_dom, cups, procedimiento, cantidad, finicio, ffinal, num_aut_externa, estado_d_aut_dom, intervalo, temporalidad, profesional, f_prof,
																		 c.nomclaseusuario
															FROM m_aut_dom a INNER JOIN d_aut_dom b on a.id_m_aut_dom=b.id_m_aut_dom
																							 INNER JOIN clase_usuario c on a.tipo_paciente=c.id_cusuario
															WHERE a.id_adm_hosp=$adm and b.estado_d_aut_dom in (1,2) and b.cups='890111'";
								//echo $sql_detalle;
								if ($tabla_detalle=$bd1->sub_tuplas($sql_detalle)){
									foreach ($tabla_detalle as $fila_detalle) {
										$hoy=date('Y-m-d');
										$fini=$fila_detalle['finicio'];
										$ffin=$fila_detalle['ffinal'];
										if ($hoy >= $fini && $hoy <= $ffin ) {
											echo'<td class="text-left">';
											echo'<p><strong>ID: </strong> '.$fila_detalle["id_d_aut_dom"].'</p>';
											echo'<p><strong>CUPS: </strong> '.$fila_detalle["cups"].' '.$fila_detalle["procedimiento"].'</p>';
											echo'<p><strong>CANTIDAD AUTORIZADA: </strong> '.$fila_detalle["cantidad"].' <strong>INTERVALO:</strong> '.$fila_detalle["intervalo"].' Min</p>';
											echo'<p class="text-danger"><strong>VIGENCIA AUTORIZACIÓN: </strong> '.$fila_detalle["finicio"].' -- '.$fila_detalle["ffinal"].'</p>';
											echo'</td>';
											$idd=$fila_detalle['id_d_aut_dom'];
											$sql_profesional="SELECT profesional FROM profesional_d_dom WHERE id_d_aut_dom=$idd and estado_profesional=1";
											//echo $sql_profesional;
											if ($tabla_profesional=$bd1->sub_tuplas($sql_profesional)){
												foreach ($tabla_profesional as $fila_profesional) {
													$realizador=$_SESSION['AUT']['id_user'];
													$prof_autorizado=$fila_profesional['profesional'];

													if ($realizador === $prof_autorizado) {
														echo'<th class="text-center">';
														echo'<p><a href="'.PROGRAMA.'?opcion='.$_REQUEST["opcion"].'&mante=VI&idadmhosp='.$fila["id_adm_hosp"].'&idd='.$fila_detalle["id_d_aut_dom"].'&doc='.$fila["doc_pac"].'"><button type="button" class="btn btn-primary sombra_movil" ><span class="fa fa-plus-circle"></span> Valoración Inicial</button></a></p>
																 <p><a href="'.PROGRAMA.'?opcion='.$_REQUEST["opcion"].'&mante=EVO&idadmhosp='.$fila["id_adm_hosp"].'&idd='.$fila_detalle["id_d_aut_dom"].'&doc='.$fila["doc_pac"].'"><button type="button" class="btn btn-warning sombra_movil" ><span class="fa fa-plus-circle"></span> Evolución</button></a></p>
																 <p><button type="button" class="btn btn-info" data-toggle="modal" data-target="#evolucion_'.$fila_detalle["id_d_aut_dom"].'"><span class="fa fa-search"></span> Consultar Evoluciones</button></p>';
																 ?>
																 <div id="<?php echo 'evolucion_'.$fila_detalle["id_d_aut_dom"] ?>" class="modal fade" role="dialog">
																	  <div class="modal-dialog">

																	    <!-- Modal content-->
																	    <div class="modal-content">
																	      <div class="modal-header">
																	        <button type="button" class="close" data-dismiss="modal">&times;</button>
																	        <h4 class="modal-title">Historico de Evoluciones</h4>
																	      </div>
																	      <div class="modal-body">
																	        <?php
																						$idd=$fila_detalle["id_d_aut_dom"];
																						$sql_evolucion="SELECT a.id_evofisio_dom, id_adm_hosp,  id_d_aut_dom, freg_reg, freg_evofisio_dom,
																																	 hreg_evofisio_dom, hreg_regfisio_dom, hfin_evofisio_dom, evolucionfisio_dom, estado_evofisio_dom,
																																	 b.nombre
																														FROM evo_fisio_dom a inner join user b on a.id_user=b.id_user WHERE a.id_d_aut_dom=$idd and estado_evofisio_dom='Realizada'";
																						if ($tabla_evolucion=$bd1->sub_tuplas($sql_evolucion)){
																							foreach ($tabla_evolucion as $fila_evolucion) {
																								echo'<section class="panel-body">
																											<article class="col-md-8">';
																								echo'<p class="col-md-12"><button data-toggle="collapse" class="btn btn-primary text-center" data-target="#evofisio_'.$fila_evolucion['id_evofisio_dom'].'">Evolucion '.$fila_evolucion["freg_evofisio_dom"].'<span class="glyphicon glyphicon-arrow-down"></span> </button></p>';
																								echo'</article>';
																								echo'<article class="col-md-4">';
																								echo'<p  class="col-md-12"><a href="Funcion_base/borrar_evofisio_dom.php?idadmhosp='.$fila["id_adm_hosp"].'&doc='.$fila["doc_pac"].'&id='.$fila_evolucion['id_evofisio_dom'].'&resp='.$_SESSION['AUT']['id_user'].'"><button type="button" class="btn btn-danger" ><span class="fa fa-trash"></span> Invalidar</button></a></p>';
																								echo'</article>';
																								echo'</section>';
																								echo'<section id="evofisio_'.$fila_evolucion['id_evofisio_dom'].'" class="collapse">';
																								echo"<article class='col-md-6'>\n";
																									echo'<p class="text-center text-"><strong><span class="fa fa-calendar"></span> '.$fila_evolucion["freg_evofisio_dom"].'</strong></p>';
																								echo"</article>";
																								echo"<article class='col-md-6'>";
																									echo'<p class="text-center success"><strong><span class="fa fa-nurse"></span> '.$fila_evolucion["nombre"].' </strong></p>';
																								echo"</article>";
																								echo"<article class='col-md-3'>";
																									echo'<p class="text-success"><strong><span class="fa fa-nurse"></span> '.$fila_evolucion["hreg_evofisio_dom"].' </strong></p>';
																								echo"</article>";
																								echo"<article class='col-md-9'>";
																									echo'<p class="text-left"> '.$fila_evolucion["evolucionfisio_dom"].' </p>';
																								echo"</article>";

																								echo'</section>';
																							}
																						}
																					 ?>
																	      </div>
																	      <div class="modal-footer">
																	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																	      </div>
																	    </div>

																	  </div>
																	</div>
																 <?php
														echo'</th>';
													}else {
														echo'<th class="text-center">';
														echo'<p class="alert alert-danger animated bounceIn"><span class="fa fa-ban fa-4x"></span></p>';
														echo'</th>';
													}

												}
											}// fin validacion profesional
										}else {
											echo'<th class="text-center"><p class="alert alert-danger animated bounceIn">Upss... Procedimiento no autorizado por fecha .</p></th>';
											echo'<th class="text-center"><p class="alert alert-danger animated bounceIn"><span class="fa fa-ban fa-4x"></span></p></th>';
										}

									}
								}else {
									echo'<th class="text-center">
												<p>El paciente no tiene servicios autorizados para fisioterapia</p>
											 </th>';
								}


					echo "</tr>\n";
				}
			}
		}
			?>

		</table>
	</section>
</section>
	<?php
}
?>
