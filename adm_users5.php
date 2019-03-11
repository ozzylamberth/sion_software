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
		$firmaE="";$firmaA1="";$firmaA2="";
		if (isset($_FILES["firma"])){
			if (is_uploaded_file($_FILES["firma"]["tmp_name"])){

				$cfoto=explode(".",$_FILES["firma"]["name"]);
				$archivo=$_POST["username"].".".$cfoto[count($cfoto)-1];

				if(move_uploaded_file($_FILES["firma"]["tmp_name"],WEB.FIRMAS.$archivo)){
					$firmaE=",firma='".FIRMAS.$archivo."'";
					$firmaA1=",firma";
					$firmaA2=",'".FIRMAS.$archivo."'";
					}
			}
		}
		$claveE="";$claveA1="";$claveA2="";
		if ($_POST["clave1"]==$_POST["clave2"]){
			if ($_POST["clave1"]!=""){
				$claveE=",clave='".$_POST["clave1"]."'";
				$claveA1=",clave";
				$claveA2=",'".$_POST["clave1"]."'";
			}
		}
		switch ($_POST["operacion"]) {
		case 'E':
			$sql="UPDATE user SET id_perfil='".$_POST['id_perfil']."', nombre='".$_POST['nombre']."', cuenta='".$_POST['username']."'$claveE$fotoE,
			 											email='".$_POST['email']."', tdoc='".$_POST['tdoc']."',doc='".$_POST['doc']."', dir_user='".$_POST['dir_user']."',
														tel_user='".$_POST['tel_user']."', rm_profesional='".$_POST['rm_profesional']."', especialidad='".$_POST['especialidad']."'$firmaE,
									 					resp_user='".$_SESSION['AUT']['id_user']."'
  				  WHERE id_user=".$_POST["idu"];
			$subtitulo="Actualizado";
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
		case 'ADDUSER':

			$sql="INSERT INTO user (id_perfil,nombre, cuenta, clave$fotoA1, email, tdoc, doc, dir_user,
															tel_user, rm_profesional, especialidad$firmaA1, estado, resp_user	)
			VALUES ('".$_POST["id_perfil"]."','".$_POST["nombre"]."','".$_POST["username"]."'$claveA2$fotoA2,'".$_POST["email"]."',
							'".$_POST["tdoc"]."','".$_POST["doc"]."','".$_POST["dir_user"]."','".$_POST["tel_user"]."','".$_POST["rm_profesional"]."',
							'".$_POST["especialidad"]."'$firmaA2,'Activo','".$_SESSION['AUT']['id_user']."')";
			$subtitulo="El usuario ".$username." fue" ;
			$subtitulo1="Adicionado.";


		break;
		case 'ADDMENU':
			$sql="INSERT INTO aux_perfiles_menus (id_perfil,id_menu) VALUES ('".$_POST["perfil"]."','".$_POST["menu"]."')";
			$subtitulo="El menú fue" ;
			$subtitulo1="Adicionado.";
		break;
		case 'EPERFIL':
			$sql="UPDATE perfil SET nombre_perfil='".$_POST["nombre_perfil"]."' where id_perfil = '".$_POST["id_perfil"]."'";
			$subtitulo="Perfil " ;
			$subtitulo1="Actualizado.";
		break;
	}
//echo $sql;
	if ($bd1->consulta($sql)){
		$subtitulo="$subtitulo $subtitulo1 con exito!";
		$check='si';
		if($_POST["operacion"]=="X"){
		if(is_file($fila["foto"])){
			unlink($fila["foto"]);
		}
		}
	}else{
		$subtitulo="$subtitulo NO fue $subtitulo1";
		$check='no';
	}
}
}

if (isset($_GET["mante"])){					///nivel 2
	switch ($_GET["mante"]) {
		case 'ADDUSER':
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
			$form1='formulariosADM/usuarios/usuarios/add_user.php';
			$subtitulo='Registro de usuarios';
			break;
			case 'ADDMENU':
			$idu=$_REQUEST['idp'];
	    $sql="SELECT id_user, id_perfil, nombre, cuenta, clave, foto, email, tdoc,
									 doc, dir_user, tel_user, rm_profesional, especialidad, firma,
									 estado, fresp_user, resp_user
						FROM user WHERE id_user=$idu";
	    //echo $sql;
	      $boton="Habilitar";
				$atributo1=' readonly="readonly"';
				$atributo2='';
				$atributo3='';
				$date=date('Y-m-d');
				$date1=date('H:i');
	      $doc=$_REQUEST['doc'];
	      $servicio=$_REQUEST['servicio'];
				$form1='formulariosADM/usuarios/usuarios/add_menu.php';
				$subtitulo='Habilitación de menú';
				break;
			case 'E':
			$idu=$_REQUEST['idu'];
	    $sql="SELECT id_user, id_perfil, nombre, cuenta, clave, foto, email, tdoc,
									 doc, dir_user, tel_user, rm_profesional, especialidad, firma,
									 estado
						FROM user WHERE id_user=$idu";
	    //echo $sql;
	      $boton="Actualizar";
				$atributo1=' readonly="readonly"';
				$atributo2='';
				$atributo3='';
				$date=date('Y-m-d');
				$date1=date('H:i');
	      $doc=$_REQUEST['doc'];
	      $servicio=$_REQUEST['servicio'];
				$form1='formulariosADM/usuarios/usuarios/add_user.php';
				$subtitulo='Edición de usuarios';
				break;
				case 'X':
		    $sql="SELECT id_user, id_perfil, nombre, cuenta, clave, foto, email, tdoc,
										 doc, dir_user, tel_user, rm_profesional, especialidad, firma,
										 estado, freg_user, resp_reg
							FROM user WHERE id_user=$idu";
		    //echo $sql;
		      $boton="Eliminar ";
					$atributo1=' readonly="readonly"';
					$atributo2='';
					$atributo3='';
					$date=date('Y-m-d');
					$date1=date('H:i');
		      $doc=$_REQUEST['doc'];
		      $servicio=$_REQUEST['servicio'];
					$form1='vista_configuracion/usuarios/add_user.php';
					$subtitulo='Eliminación de usuarios';
					break;
					case 'EPERFIL':
					$idp=$_REQUEST['idp'];
					$sql="SELECT id_perfil, nombre_perfil
								FROM perfil  WHERE id_perfil=$idp";
					//echo $sql;
						$boton="Actualizar ";
						$atributo1=' readonly="readonly"';
						$atributo2='';
						$atributo3='';
						$date=date('Y-m-d');
						$date1=date('H:i');
						$doc=$_REQUEST['doc'];
						$servicio=$_REQUEST['servicio'];
						$form1='formulariosADM/perfil/edit_perfil.php';
						$subtitulo='Editar Perfil';
						break;

		}
//echo $sql;
		if($sql!=""){
			if (!$fila=$bd1->sub_fila($sql)){
				$fila=array("id_user"=>"", "id_perfil"=>"", "nombre"=>"", "cuenta"=>"", "clave"=>"", "foto"=>"", "email"=>"", "tdoc"=>"",
										 "doc"=>"", "dir_user"=>"", "tel_user"=>"", "rm_profesional"=>"", "especialidad"=>"", "firma"=>"",
										 "estado"=>"", "freg_user"=>"", "resp_reg"=>"", "nombre_perfil"=>"");
			}
		}else{
				$fila=array("id_user"=>"", "id_perfil"=>"", "nombre"=>"", "cuenta"=>"", "clave"=>"", "foto"=>"", "email"=>"", "tdoc"=>"",
										 "doc"=>"", "dir_user"=>"", "tel_user"=>"", "rm_profesional"=>"", "especialidad"=>"", "firma"=>"",
										 "estado"=>"", "freg_user"=>"", "resp_reg"=>"", "nombre_perfil"=>"");
			}

		?>

		<?php include($form1);?>

<?php
}else{
  if ($check=='si') {
		echo'<section>';
		echo '<script>swal("EXCELENTE !!!"," '.$subtitulo.'","success")</script>';
		echo'</section>';
	}if ($check=='no') {
		echo'<section>';
		echo '<script>swal("DEBES REVISAR EL PROCESO !!! '.$subtitulo.'","","error")</script>';
		echo'</section>';
	}
// nivel 1?>
<section class="panel-default">
	<section class="panel-heading animated slideInLeft">
		<h3>Administración de usuarios y perfiles</h3>

  </section>
	<section class="panel-body">
		<section class="col-md-12">
			<form>
				<div class="col-md-6">
					<div class="input-group col-md-12">
						<input type="text" class="form-control" name="ident" placeholder="Filtro por identificación" aria-describedby="basic-addon1">
					</div>
					<br>
					<div class="text-left animated fadeInLeft">
						<input type="submit" name="buscar" class="btn btn-danger" value="Consultar">
						<input type="hidden" name="opcion" Value="<?php echo $_GET["opcion"];?>"/>
					</div>
				</div>
			</form>
			<form>
				<div class="col-md-6">
					<div class="input-group col-md-12">
						<input type="text" class="form-control" name="nombre" placeholder="Filtro por nombre" aria-describedby="basic-addon1">
					</div>
					<br>
					<div class="text-left animated fadeInLeft">
						<input type="submit" name="buscar" class="btn btn-danger" value="Consultar">
						<input type="hidden" name="opcion" Value="<?php echo $_GET["opcion"];?>"/>
					</div>
				</div>
			</form>
		</section>
	</section>
		<section class="col-md-4">
			<button type="button" class="btn btn-info" data-toggle="modal" data-target="#firmas"><span class="fa fa-address-card fa-3x"></span> Estado<br>firmas</button>

			 <div id="firmas" class="modal fade" role="dialog">
				 <div class="modal-dialog">

					 <!-- Modal content-->
					 <div class="modal-content">
						 <div class="modal-header">
							 <button type="button" class="close" data-dismiss="modal">&times;</button>
							 <h4 class="modal-title">Estado de firmas</h4>
						 </div>
						 <div class="modal-body">
							 <?php
							 $sql_firma="SELECT a.id_user,a.id_perfil perfil, nombre, cuenta, clave, foto, email, tdoc, doc, dir_user, tel_user,
		 															 rm_profesional, especialidad, firma, estado,
		 															 b.nombre_perfil
		 											  FROM user a INNER JOIN perfil b on a.id_perfil=b.id_perfil
		 												WHERE a.estado='Activo' and a.id_perfil=6 ORDER BY id_user ASC";
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
		<section class="col-md-4">
			<p><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#menus"><span class="fa fa-key fa-3x"></span> Privilegios<br>Acceso</button></p>
			<div id="menus" class="modal fade" role="dialog">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title">Listado de perfiles SION software</h4>
							<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>
						<div class="modal-body">
							<table class="table table-bordered" >
								<tr>
									<td colspan="4">
										<a href="<?php echo PROGRAMA.'?opcion='.$_REQUEST["opcion"].'&mante=ADDPERFI';?>">
											<button type="button" class="btn btn-primary "><span class="fa fa-user-circle"></span> Crear nuevo perfil</button>
										</a>
									</td>
								</tr>
								<tr>
									<td class="text-center"><strong>ID</strong></td>
									<td class="text-center"><strong>NOMBRE</strong></td>
									<td class="text-center"><strong>ESTADO</strong></td>
									<td class="text-center"></td>
								</tr>
								<?php
								$perfil=$filau['perfil'];
								$sql_perfil="SELECT id_perfil,nombre_perfil,estado_perfil
												FROM perfil ORDER BY id_perfil ASC";
									//echo $sqlhd;
								if ($tabla_perfil=$bd1->sub_tuplas($sql_perfil)){
									foreach ($tabla_perfil as $fila_perfil ) {
										echo"<tr >\n";
										echo'<td class="text-left ">
													<p>'.$fila_perfil["id_perfil"].'</p>
												 </td>';
												 echo'<td class="text-left ">
		 													<p>'.$fila_perfil["nombre_perfil"].'</p>
		 												 </td>';
										echo'<td class="text-left ">';
													if ($fila_perfil["estado_perfil"]==1) {
														echo'<p>Activo</p>';
													}else {
														echo'<p>Inactivo</p>';
													}
										echo'</td>';
										echo'<td class="text-left ">
													<p><a href="'.PROGRAMA.'?opcion='.$_REQUEST["opcion"].'&mante=EPERFIL&idp='.$fila_perfil["id_perfil"].'"><button type="button" class="btn btn-warning" ><span class="fa fa-edit"></span> Editar</button></a></p>
													<p><a href="'.PROGRAMA.'?opcion='.$_REQUEST["opcion"].'&mante=XPERFIL&idp='.$fila_perfil["id_perfil"].'"><button type="button" class="btn btn-danger" ><span class="fa fa-trash"></span> Eliminar</button></a></p>
													<p><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#asignar_menu'.$fila_perfil["id_perfil"].'">Asignar menu</button>
                              <div id="asignar_menu'.$fila_perfil["id_perfil"].'" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                      <h4 class="modal-title">Asignacion y consulta de Menu en perfil #'.$fila_perfil["id_perfil"].'  '.$fila_perfil["nombre_perfil"].'</h4>
                                    </div>
                                    <div class="modal-body">
                                    <form action="Funcion_base/asignar_menu.php" method="POST">
                                      <section class="panel-body">
                                        <article class="col-md-12">';
																				?>
																				<label for="">Seleccione Menu :</label>
																				<select name="id_menu" class="form-control" required="">
																						<option values=""></option>
																					<?php
																					$sql="SELECT id_menu,titulo from menu ORDER BY id_menu ASC";
																					if($tabla=$bd1->sub_tuplas($sql)){
																						foreach ($tabla as $fila2) {
																							if ($fila["id_menu"]==$fila2["id_menu"]){
																								$sw='selected="selected"';
																							}else{
																								$sw="";
																							}
																						echo '<option value="'.$fila2["id_menu"].'"'.$sw.'>'.$fila2["titulo"].'</option>';
																						}
																					}
																					?>
																			</select>
																				<?php
                                        echo'
                                          <input type="hidden" class="form-control" name="id_perfil" value="'.$fila_perfil["id_perfil"].'">
                                        </article>
                                      </section>
                                      <section class="panel-body">
                                        <article class="col-md-12">
                                          <input type="submit" value="Asignar">
                                        </article>
                                      </section>
                                    </form>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                  </div>

                                </div>
                              </div></p>
												 </td>';
										echo '</tr>';
									}
								}
								?>
							</table>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
						</div>
					</div>
				</div>
			</div>
		</section>
		<section class="col-md-4">

		</section>
		<section class="col-md-12">
			<section class="row panel-body">
				<div class="table animated fadeInUp">
				 <table class="table table-bordered">
					 <tr>
					 	<td colspan="3">
							<a href="<?php echo PROGRAMA.'?opcion='.$_REQUEST["opcion"].'&mante=ADDUSER'?>" align="center" ><button type="button" class="btn btn-primary" >Adicionar Usuario</button></a>
						</td>
					 </tr>
					 <tr class="fuente_titulo_tabla">
		 		    <th class="text-center text-primary">PACIENTE</th>
		 				<th class="text-center text-primary">PERFIL</th>
						<th class="text-center text-primary"></th>
		 			</tr>
					<?php
					if (isset($_REQUEST["nombre"])){
					$doc=$_REQUEST["nombre"];
					$sql_usuario="SELECT a.id_user,a.id_perfil perfil, nombre, cuenta, clave, foto, email, tdoc, doc, dir_user, tel_user,
															 rm_profesional, especialidad, firma, estado,
															 b.nombre_perfil
											  FROM user a INNER JOIN perfil b on a.id_perfil=b.id_perfil
												WHERE a.nombre like '%$doc%' ORDER BY id_user ASC";
												//echo $sql_usuario;
					if ($tablau=$bd1->sub_tuplas($sql_usuario)){
						foreach ($tablau as $filau ) {
							if ($filau['estado']=='Activo') {
								echo'<tr>';
								echo'<td>
											<p><strong>Nombre: </strong>'.$filau['nombre'].'</p>
											<p><strong>'.$filau['tdoc'].': </strong>'.$filau['doc'].'</p>
											<p><strong>CUENTA: </strong>'.$filau['cuenta'].'</p>
											<p><strong>Especialidad: </strong>'.$filau['especialidad'].'</p>
										 </td>';
								 echo'<td>
								 			 <p><img src="'.$filau["foto"].'"alt ="foto" class="image_login"></p>
		 								   <p><strong>Perfil: </strong>'.$filau['nombre_perfil'].'</p>
		 								  </td>';
								echo'<td>
											<p><a href="'.PROGRAMA.'?opcion='.$_REQUEST["opcion"].'&mante=E&idu='.$filau["id_user"].'&doc='.$filau["doc"].'"><button type="button" class="btn btn-warning" ><span class="fa fa-edit"></span> Editar Usuario</button></a></p>
											<p><a href="Funcion_base/borrar_usuario.php?idadmhosp='.$fila["id_adm_hosp"].'&doc='.$fila["doc_pac"].'&id='.$filau['id_user'].'&resp='.$_SESSION['AUT']['id_user'].'"><button type="button" class="btn btn-danger" ><span class="fa fa-trash"></span> Eliminar Usuario</button></a></p>
										 </td>';
								echo'</tr>';
							}
							if ($filau['estado']=='Inactivo') {
								echo'<tr>';
								echo'<td>
											<p class="text-left"><strong>Nombre: </strong>'.$filau['nombre'].'</p>
											<p><strong>'.$filau['tdoc'].': </strong>'.$filau['doc'].'</p>
											<p><strong>CUENTA: </strong>'.$filau['cuenta'].'</p>
											<p><strong>Especialidad: </strong>'.$filau['especialidad'].'</p>
										 </td>';
								echo'<td>
										 		<p><img src="'.$filau["foto"].'"alt ="foto" class="image_login"></p>
				 								<p><strong>Perfil: </strong>'.$filau['nombre_perfil'].'</p>
				 							</td>';
								echo'<td>
										 	<p><a href="Funcion_base/activar_usuario.php?idadmhosp='.$fila["id_adm_hosp"].'&doc='.$fila["doc_pac"].'&id='.$filau['id_user'].'&resp='.$_SESSION['AUT']['id_user'].'"><button type="button" class="btn btn-warning" ><span class="fa fa-edit"></span> Activar Usuario</button></a></p>
										 </td>';
								echo'</tr>';
							}
						}
					}
					}

					?>
					<?php
					if (isset($_REQUEST["ident"])){
					$doc=$_REQUEST["ident"];
					$sql_usuario="SELECT a.id_user,a.id_perfil perfil, nombre, cuenta, clave, foto, email, tdoc, doc, dir_user, tel_user,
															 rm_profesional, especialidad, firma, estado,
															 b.nombre_perfil
											  FROM user a INNER JOIN perfil b on a.id_perfil=b.id_perfil
												WHERE a.doc='$doc' ORDER BY id_user ASC";
												//echo $sql_usuario;
					if ($tablau=$bd1->sub_tuplas($sql_usuario)){
						foreach ($tablau as $filau ) {
							if ($filau['estado']=='Activo') {
								echo'<tr>';
								echo'<td>
											<p class="text-left"><strong>Nombre: </strong>'.$filau['nombre'].'</p>
											<p><strong>'.$filau['tdoc'].': </strong>'.$filau['doc'].'</p>
											<p><strong>CUENTA: </strong>'.$filau['cuenta'].'</p>
											<p><strong>Especialidad: </strong>'.$filau['especialidad'].'</p>
										 </td>';
								 echo'<td>
								 			 <p><img src="'.$filau["foto"].'"alt ="foto" class="image_login"></p>
		 								   <p><strong>Perfil: </strong>'.$filau['nombre_perfil'].'</p>

		 								  </td>';
								echo'<td>
											<p><a href="'.PROGRAMA.'?opcion='.$_REQUEST["opcion"].'&mante=E&idu='.$filau["id_user"].'&doc='.$filau["doc"].'"><button type="button" class="btn btn-warning" ><span class="fa fa-edit"></span> Editar Usuario</button></a></p>
											<p><a href="Funcion_base/borrar_usuario.php?idadmhosp='.$fila["id_adm_hosp"].'&doc='.$fila["doc_pac"].'&id='.$filau['id_user'].'&resp='.$_SESSION['AUT']['id_user'].'"><button type="button" class="btn btn-danger" ><span class="fa fa-trash"></span> Eliminar Usuario</button></a></p>
										 </td>';
								echo'</tr>';
							}
							if ($filau['estado']=='Inactivo') {
								echo'<tr>';
								echo'<td>
											<p class="text-left"><strong>Nombre: </strong>'.$filau['nombre'].'</p>
											<p><strong>'.$filau['tdoc'].': </strong>'.$filau['doc'].'</p>
											<p><strong>CUENTA: </strong>'.$filau['cuenta'].'</p>
											<p><strong>Especialidad: </strong>'.$filau['especialidad'].'</p>
										 </td>';
								echo'<td>
												<p><img src="'.$filau["foto"].'"alt ="foto" class="image_login"></p>
												<p><strong>Perfil: </strong>'.$filau['nombre_perfil'].'</p>
											</td>';
								echo'<td>
											<p><a href="Funcion_base/activar_usuario.php?idadmhosp='.$fila["id_adm_hosp"].'&doc='.$fila["doc_pac"].'&id='.$filau['id_user'].'&resp='.$_SESSION['AUT']['id_user'].'"><button type="button" class="btn btn-warning" ><span class="fa fa-edit"></span> Activar Usuario</button></a></p>
										 </td>';
								echo'</tr>';
							}
						}
					}
					}

					?>
				 </table>
				</div>
			</section>

		</section>

</section>
	<?php
}
?>
