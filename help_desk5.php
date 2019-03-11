<?php
$subtitulo="";
if(isset($_POST["operacion"])){	//nivel3
	if($_POST["aceptar"]!="Descartar"){
		//print_r($_FILES);
		$fotoE="";$fotoA1="";$fotoA2="";
		if (isset($_FILES["foto"])){
			if (is_uploaded_file($_FILES["foto"]["tmp_name"])){

				$cfoto=explode(".",$_FILES["foto"]["name"]);
				$archivo=$_POST["username"].".".$cfoto[count($cfoto)-1];

				if(move_uploaded_file($_FILES["foto"]["tmp_name"],WEB.FOTOS.$archivo)){
					$fotoE=",foto='".FOTOS.$archivo."'";
					$fotoA1=",foto";
					$fotoA2=",'".FOTOS.$archivo."'";
					}
			}
		}
		$docE="";$docA1="";$docA2="";
		if (isset($_FILES["soporte_hdesk"])){
			if (is_uploaded_file($_FILES["soporte_hdesk"]["tmp_name"])){
				$cfoto=explode(".",$_FILES["soporte_hdesk"]["name"]);
				$archivo=$_POST["nombre_soporte"].".".$cfoto[count($cfoto)-1];
				if(move_uploaded_file($_FILES["soporte_hdesk"]["tmp_name"],WEB.SHDESK.$archivo)){
					$docE=",soporte_hdesk='".SHDESK.$archivo."'";
					$docA=',soporte_hdesk';
					$docb=",'".SHDESK.$archivo."'";
					}
			}
		}
		switch ($_POST["operacion"]) {
			case 'EVIDENCIA':
				$sql="INSERT INTO soporte_hdesk (id_hdesk,id_user,freg_hdesk,hreg_hdesk,nombre_soporte$docA)
				VALUES ('".$_POST["id_hdesk"]."','".$_SESSION["AUT"]["id_user"]."','".$_POST["freg_hdesk"]."','".$_POST["hreg_hdesk"]."',
					'".$_POST["nombre_soporte"]."'$docb)";
				$subtitulo="Evidencia cargada con exito";
				$subtitulo1="los documentos cargados no deben superar las 2MB . Revise nuevamente el cargue.";
			break;
		case 'X':
			$sql="SELECT foto from user where id_user=".$_POST["idu"];
			if (!$fila=$bd1->sub_fila($sql)){
				$fila=array("foto"=> "");
			}
			if (!$fila=$bd1->sub_fila($sql)){
				$fila=array("firma"=> "");
			}
			$sql="DELETE FROM user WHERE id_user=".$_POST["idu"];
			$subtitulo="Eliminado";
		break;
		case 'ADDHDESK':

			$sql="INSERT INTO help_desk (id_user,freg_hdesk, hreg_hdesk, descripcion, tipo_soporte,estado_soporte)
			VALUES ('".$_SESSION['AUT']['id_user']."','".$_POST["freg_hdesk"]."','".$_POST["hreg_hdesk"]."','".$_POST["descripcion"]."','".$_POST["tipo_soporte"]."',1)";
			$subtitulo="El caso de soporte ha sido registrado con exito, muy pronto el area de soporte se comunicará para informar la situación y avance del caso. ";
      $subtitulo1="Algo salio mal tu caso no se registro verifica el texto en busca de una comilla sencilla  ";
		break;
	}
//echo $sql;
	if ($bd1->consulta($sql)){
		$subtitulo="$subtitulo";
		$check='si';
		if($_POST["operacion"]=="X"){
		if(is_file($fila["foto"])){
			unlink($fila["foto"]);
		}
		}
	}else{
		$subtitulo="$subtitulo1";
		$check='no';
	}
}
}

if (isset($_GET["mante"])){					///nivel 2
	switch ($_GET["mante"]) {
		case 'ADDHDESK':
    $sql="";
    //echo $sql;
      $boton="Agregar";
			$atributo1=' readonly="readonly"';
			$atributo2='';
			$atributo3='';
			$date=date('Y-m-d');
			$date1=date('H:i');
      $doc=$_REQUEST['doc'];
      $servicio=$_REQUEST['servicio'];
			$form1='formulariosADM/help_desk/add_hdesk.php';
			$subtitulo='Registro de TICKET para hepl desk';
			break;
			case 'EVIDENCIA':
			$sql="";
			//echo $sql;
				$boton="Agregar";
				$atributo1=' readonly="readonly"';
				$atributo2='';
				$atributo3='';
				$date=date('Y-m-d');
				$date1=date('H:i');
				$doc=$_REQUEST['doc'];
				$servicio=$_REQUEST['servicio'];
				$form1='formulariosADM/help_desk/soporte_hdesk.php';
				$subtitulo='Registro de evidencias HELP DESK';
				break;
		}
//echo $sql;
		if($sql!=""){
			if (!$fila=$bd1->sub_fila($sql)){
				$fila=array("id_user"=>"", "id_perfil"=>"", "nombre"=>"", "cuenta"=>"", "clave"=>"", "foto"=>"", "email"=>"", "tdoc"=>"",
										 "doc"=>"", "dir_user"=>"", "tel_user"=>"", "rm_profesional"=>"", "especialidad"=>"", "firma"=>"",
										 "estado"=>"", "freg_user"=>"", "resp_reg"=>"");
			}
		}else{
				$fila=array("id_user"=>"", "id_perfil"=>"", "nombre"=>"", "cuenta"=>"", "clave"=>"", "foto"=>"", "email"=>"", "tdoc"=>"",
										 "doc"=>"", "dir_user"=>"", "tel_user"=>"", "rm_profesional"=>"", "especialidad"=>"", "firma"=>"",
										 "estado"=>"", "freg_user"=>"", "resp_reg"=>"");
			}

		?>

		<?php include($form1);?>

<?php
}else{
  if ($check=='si') {
		echo'<section>';
		echo '<script>swal("MUY BIEN  !!!","'.$subtitulo.'","success")</script>';
		echo'</section>';
	}if ($check=='no') {
		echo'<section>';
		echo '<script>swal("ALGO SALIO MAL !!! ","'.$subtitulo1.'","error")</script>';
		echo'</section>';
	}
// nivel 1?>
<section class="panel panel-default">
	<section class="panel-heading animated slideInLeft">
		<h1>HELP DESK</h1>
  </section>
	<section class="panel-body">
    <section class="col-md-4 col-sm-12">
      <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#historia_tickets"><span class="fa fa-ticket-alt fa-4x"></span><br>Historico tickets</button>

       <div id="historia_tickets" class="modal fade" role="dialog">
         <div class="modal-dialog">

           <!-- Modal content-->
           <div class="modal-content">
             <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h4 class="modal-title">Historico de tickets</h4>
             </div>
             <div class="modal-body">
               <?php
               $sql_firma="";
                          //	echo $sql_firma;
              if ($tabla_firma=$bd1->sub_tuplas($sql_firma)){
                foreach ($tabla_firma as $fila_firma ) {
                  echo'<p><strong>Nombre: </strong>'.$fila_firma['nombre'].'</p>';
                  echo'<p><img src="'.$fila_firma["firma"].'"alt ="foto" class="image_inicio_login"></p>';
                  echo'<p><strong>Perfil: </strong>'.$fila_firma['nombre_perfil'].'</p>';
                  echo'<p><a href="'.PROGRAMA.'?opcion='.$_REQUEST["opcion"].'&mante=E&idu='.$fila_firma["id_user"].'&doc='.$fila_firma["doc"].'"><button type="button" class="btn btn-warning" ><span class="fa fa-edit"></span> Editar Usuario</button></a></p>';
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
    </section>
    <section class="col-md-4 col-sm-12">

		</section>
		<section class="col-md-4 col-sm-12">

		</section>

	</section>
	<section class="panel-body">

				 <table class="table table-bordered">
					 <tr>
					 	<td colspan="3">
							<a href="<?php echo PROGRAMA.'?opcion='.$_REQUEST["opcion"].'&mante=ADDHDESK'?>" align="center" ><button type="button" class="btn btn-primary" >Generar Tickets</button></a>
						</td>
					 </tr>
					 <tr class="fuente_titulo_tabla">
             <th class="text-center text-primary">#</th>
		 		    <th class="text-center text-primary">CASO</th>
		 				<th class="text-center text-primary">CLASIFICACION</th>
						<th class="text-center text-primary"></th>
		 			</tr>
					<?php

					$usuario=$_SESSION['AUT']["id_user"];
					$sql_usuario="SELECT a.id_hdesk, freg_hdesk, hreg_hdesk, descripcion, tipo_soporte,
                               estado_soporte, rta_hdesk1, observacion_hdesk1, user_rta1,frta1,hrta1, rta_hdesk2, observacion_hdesk2, user_rta2,frta2,hrta2,
															 b.nombre realiza,
                               c.nombre respon1,
                               d.nombre respon2
											  FROM help_desk a LEFT JOIN user b on a.id_user=b.id_user
                                         LEFT JOIN user c on c.id_user=a.user_rta1
                                         LEFT JOIN user d on d.id_user=a.user_rta2

                        WHERE a.estado_soporte in (1,2,3) and a.id_user=$usuario ORDER BY freg_hdesk ASC";
												//echo $sql_usuario;
          $i=1;
					if ($tablau=$bd1->sub_tuplas($sql_usuario)){
						foreach ($tablau as $filau) {
              $estado_hdesk=$filau['estado_soporte'];
							if ($estado_hdesk==1) {
								echo'<tr>';
                echo'<td class="alert alert-danger">
                      <h2>'.$i++.'</>
                     </td>';
								echo'<td class="alert alert-danger">
											<p><strong>Fecha Registro: </strong>'.$filau['freg_hdesk'].'</p>
											<p><strong>Hora Registro: </strong>'.$filau['hreg_hdesk'].'</p>

										 </td>';
								 echo'<td class="alert alert-danger">
                       <p><strong>Tipo Soporte: </strong>
                       ';
                       $tipo=$filau['tipo_soporte'];
                       if ($tipo==1) {
                         echo'SION';
                       }
                       if ($tipo==2) {
                         echo'Equipo';
                       }
                echo'</p>
		 								   <p><strong>Problema: </strong>'.$filau['descripcion'].'</p>
											 <p><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#soportes_hdesk_'.$filau['id_hdesk'].'"><span class="fa fa-upload"></span> Evidencias</button></p>
											 <div id="soportes_hdesk_'.$filau['id_hdesk'].'" class="modal fade" role="dialog">
												<div class="modal-dialog modal-lg">

													<!-- Modal content-->
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal">&times;</button>
															<h4 class="modal-title">Evidencias para Ticket # '.$filau['id_hdesk'].'</h4>
														 <p class="text-right"><a href="'.PROGRAMA.'?opcion='.$_REQUEST["opcion"].'&mante=EVIDENCIA&id='.$filau['id_hdesk'].'">
														 <button type="button" class="btn btn-success"><span class="fa fa-file-text"></span>Cargar Evidencia</button></a></p>
														</div>
														<div class="modal-body">';
														$id=$filau['id_hdesk'];
															 $sql_doc="SELECT id_s_hdesk,id_hdesk,id_user,freg_hdesk,hreg_hdesk,
															 									nombre_soporte,soporte_hdesk
																				 FROM soporte_hdesk
																				 WHERE id_hdesk=$id";
															//echo $sql_doc;
															 if ($tabla_doc=$bd1->sub_tuplas($sql_doc)){
																 foreach ($tabla_doc as $fila_doc ) {
																	 echo'<section class="panel-body">';
																		 echo'<article class="col-md-6">';
																			 echo'<p><strong>Fecha Registro: </strong>'.$fila_doc['freg_hdesk'].' - '.$fila_doc['hreg_hdesk'].'</p>';
																			 echo'<p><strong>Nombre: </strong>'.$fila_doc['nombre_soporte'].'</p>';
																		 echo'</article>';
																		 echo'<article class="col-md-6">';
																			 echo'<p><img src="'.$fila_doc['soporte_hdesk'].'" width="100%"></p>';
																			 echo'<p>';
																			 $soporte=$fila_doc['soporte_hdesk'];
																			 $sop=substr($soporte, -3);
																			 
																			 				if ($sop=='jpg' || $sop=='JPG' || $sop=='png') {
																			 					echo'
																									<a href="'.$fila_doc['soporte_hdesk'].'">
																										<button type="button" class="btn btn-info btn-md" ><span class="fa fa-file-image"></span> Ver imagen</button>
																									</a>';
																			 				}
																							if ($sop=='pdf') {
																			 					echo'
																									<a href="'.$fila_doc['soporte_hdesk'].'">
																										<button type="button" class="btn btn-info btn-md" ><span class="fa fa-file-pdf"></span> Ver PDF</button>
																									</a>';
																			 				}
																							if ($sop=='mp4') {
																			 					echo'
																									<a href="'.$fila_doc['soporte_hdesk'].'">
																										<button type="button" class="btn btn-info btn-md" ><span class="fa fa-file-video"></span> Ver Video</button>
																									</a>';
																			 				}

																			echo'<a href="'.PROGRAMA.'?opcion='.$_REQUEST["opcion"].'&mante=XDOC&idadm='.$fila_adm["id_adm_hosp"].'&docc='.$filap["doc_pac"].'&pac='.$filap["id_paciente"].'">
																		 						<button type="button" class="btn btn-danger" ><span class="fa fa-times-circle"></span>	Eliminar Evidencia</button>
																							</a>
																		 				</p>';
																		 echo'</article>';
																	 echo'</section>';
																 }
															 }else {
															 	echo'<p>No existen evidencias de este ticket</p>';
															 }
														echo'</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
														</div>
													</div>

												</div>
											</div>
		 								  </td>';
								echo'<td  class="alert alert-danger">
											<p class="text-primary">Ticket en estado ACTIVO</p>
										 </td>';
								echo'</tr>';
							}
              if ($estado_hdesk==2) {
								echo'<tr>';
                echo'<td  class="alert alert-info">
                      <h2>'.$i++.'</>
                     </td>';
								echo'<td  class="alert alert-info">
											<p><strong>Fecha Registro: </strong>'.$filau['freg_hdesk'].'</p>
											<p><strong>Hora Registro: </strong>'.$filau['hreg_hdesk'].'</p>

										 </td>';
								 echo'<td  class="alert alert-info">
                       <p><strong>Tipo Soporte: </strong>
                       ';
                       $tipo=$filau['tipo_soporte'];
                       if ($tipo==1) {
                         echo'SION';
                       }
                       if ($tipo==2) {
                         echo'Equipo';
                       }
                echo'</p>
		 								   <p><strong>Problema: </strong>'.$filau['descripcion'].'</p>
                       <p class="text-primary"><strong>Respuesta Soporte: </strong>'.$filau['rta1'].'</p>
                       <p class="text-primary"><strong>Observación Soporte: </strong>'.$filau['observacion_hdesk1'].'</p>
                       <p class="text-primary"><strong>Responsable Soporte: </strong>'.$filau['respon1'].'</p>
											 <p><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#soportes_hdesk"><span class="fa fa-upload"></span> Evidencias</button></p>
		 								  </td>';
								echo'<td  class="alert alert-info">
											<p></p>
										 </td>';
								echo'</tr>';
							}
              if ($estado_hdesk==3) {
                echo'<tr>';
                echo'<td>
                      <h2>'.$i++.'</>
                     </td>';
                echo'<td>
                      <p><strong>Fecha Registro: </strong>'.$filau['freg_hdesk'].'</p>
                      <p><strong>Hora Registro: </strong>'.$filau['hreg_hdesk'].'</p>

                     </td>';
                 echo'<td>
                       <p><strong>Tipo Soporte: </strong>
                       ';
                       $tipo=$filau['tipo_soporte'];
                       if ($tipo==1) {
                         echo'SION';
                       }
                       if ($tipo==2) {
                         echo'Equipo';
                       }
                echo'</p>
                       <p><strong>Problema: </strong>'.$filau['descripcion'].'</p>
                       <p class="text-primary"><strong>Respuesta Soporte: </strong>'.$filau['rta1'].'</p>
                       <p class="text-primary"><strong>Observación Soporte: </strong>'.$filau['observacion_hdesk1'].'</p>
                       <p class="text-primary"><strong>Responsable Soporte: </strong>'.$filau['respon1'].'</p>
                       <p class="text-primary"><strong>Respuesta Soporte: </strong>'.$filau['rta2'].'</p>
                       <p class="text-primary"><strong>Observación Soporte: </strong>'.$filau['observacion_hdesk2'].'</p>
                       <p class="text-primary"><strong>Responsable Soporte: </strong>'.$filau['respon2'].'</p>
                       <p><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#soportes_hdesk"><span class="fa fa-upload"></span> Evidencias</button></p>
                      </td>';
                echo'<td>
                      <p><a href="'.PROGRAMA.'?opcion='.$_REQUEST["opcion"].'&mante=E&idu='.$filau["id_user"].'&doc='.$filau["doc"].'"><button type="button" class="btn btn-warning" >
                      <span class="fa fa-edit"></span> Editar Usuario</button></a></p>
                      <p><a href="Funcion_base/borrar_usuario.php?idadmhosp='.$fila["id_adm_hosp"].'&doc='.$fila["doc_pac"].'&id='.$filau['id_user'].'&resp='.$_SESSION['AUT']['id_user'].'"><button type="button" class="btn btn-danger" ><span class="fa fa-trash"></span> Eliminar Usuario</button></a></p>
                     </td>';
                echo'</tr>';
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
