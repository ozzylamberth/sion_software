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
		case 'ADDANUNCIO':

			$sql="INSERT INTO anuncios (id_user,servicio,tipo_anuncio,freg,hreg,titulo,anuncio,estado)
			VALUES ('".$_SESSION["AUT"]["id_user"]."','".$_POST["servicio"]."','".$_POST["tipo_anuncio"]."','".$_POST["freg"]."',
							'".$_POST["hreg"]."','".$_POST["titulo"]."','".$_POST["anuncio"]."',1)";
			$subtitulo="Anuncio " ;
			$subtitulo1="Guardado " ;


		break;

	}
//echo $sql;
	if ($bd1->consulta($sql)){
		$subtitulo="$subtitulo $subtitulo1 con exito";
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
		case 'ADDANUNCIO':
      $sql="";
    //echo $sql;
      $boton="Guardar";
			$atributo1=' readonly="readonly"';
			$atributo2='';
			$atributo3='';
			$date=date('Y-m-d');
			$date1=date('H:i');
      $doc=$_REQUEST['doc'];
      $servicio=$_REQUEST['servicio'];
			$form1='anuncios/vista/add_anuncio.php';
			$subtitulo='Creación de anuncio';
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
		echo '<script>swal("EXCELENTE !!! '.$subtitulo.'","","success")</script>';
		echo'</section>';
	}if ($check=='no') {
		echo'<section>';
		echo '<script>swal("DEBES REVISAR EL PROCESO !!! '.$subtitulo.'","","error")</script>';
		echo'</section>';
	}
// nivel 1?>
<section class="panel panel-default">
	<section class="panel-heading animated slideInLeft">
		<h3>Gestión de anuncios y capacitaciones</h3>
  </section>
		<section class="col-md-12">
			<section class="row panel-body">

				 <table class="table table-bordered">
					 <tr>
					 	<td colspan="3">
							<a href="<?php echo PROGRAMA.'?opcion='.$_REQUEST["opcion"].'&mante=ADDANUNCIO'?>" align="center" ><button type="button" class="btn btn-primary" >Nuevo Anuncio</button></a>
						</td>
					 </tr>
					 <tr class="fuente_titulo_tabla">
            <th class="text-center text-primary">#</th>
		 		    <th class="text-center text-primary">ANUNCIO</th>
						<th class="text-center text-primary"></th>
		 			</tr>
					<?php
					$sql_anuncio="SELECT a.id_anuncio,a.servicio,a.tipo_anuncio,a.freg,a.hreg,a.titulo,a.anuncio,a.estado,a.f_elimina,a.resp_elimina ,
                               b.nombre
											  FROM anuncios a inner join user b on a.id_user=b.id_user
												WHERE a.estado=1 ORDER BY a.freg DESC";
												//echo $sql_usuario;
					$i=1;
					if ($tabla_anuncio=$bd1->sub_tuplas($sql_anuncio)){
						foreach ($tabla_anuncio as $fila_anuncio ) {
							echo'<tr>';
              $tipo_anuncio=$fila_anuncio['tipo_anuncio'];
              if ($tipo_anuncio==1) { // anunncio general

								echo'<td class="alert alert-info">
                      <p><strong>'.$i++.'</strong></p>
                     </td>';
                echo'<td class="alert alert-info">
                      <p><strong>Fecha registro: </strong>'.$fila_anuncio['freg'].'</p>
                      <p><strong>TITULO: </strong>'.utf8_encode($fila_anuncio['titulo']).'</p>
                      <p><strong>CONTENIDO: </strong>'.utf8_encode($fila_anuncio['anuncio']).'</p>
                     </td>';
                echo'<td class="alert alert-info">
											<article class="col-md-12">
                      	<p><button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit_anuncio_'.$fila_anuncio["id_anuncio"].'">Editar Anuncio</button></p>
											</article>
											<article class="col-md-12">
												<p><a href="Funcion_base/eliminar_anuncio.php?id='.$fila_anuncio["id_anuncio"].'&resp='.$_SESSION['AUT']['id_user'].'"><button type="button" class="btn btn-danger" ><span class="fa fa-trash"></span> Eliminar Anuncio</button></a></p>
											</article>
                     </td>';
              }
              if ($tipo_anuncio==2) {// anunncio SION

								echo'<td class="alert alert-success">
											<p><strong>'.$i++.'</strong></p>
										 </td>';
                echo'<td class="alert alert-success">
                      <p><strong>Fecha registro: </strong>'.$fila_anuncio['freg'].'</p>
                      <p><strong>TITULO: </strong>'.$fila_anuncio['titulo'].'</p>
                      <p><strong>CONTENIDO: </strong>'.$fila_anuncio['anuncio'].'</p>
                        <button type="button" class="btn btn-info " data-toggle="modal" data-target="#gdocu_'.$fila_anuncio["id_anuncio"].'">Cargar Adicionales</button>
                     </td>';
                     include('Funcion_base/gestorDocumental/modalGD.php');
                echo'<td class="alert alert-success">
											<section class="panel-body">';

								echo'<article class="col-md-12">
											<p><button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit_anuncio_'.$fila_anuncio["id_anuncio"].'">Editar Anuncio</button></p>
											<p><a href="Funcion_base/eliminar_anuncio.php?id='.$fila_anuncio["id_anuncio"].'&resp='.$_SESSION['AUT']['id_user'].'"><button type="button" class="btn btn-danger" ><span class="fa fa-trash"></span> Eliminar Anuncio</button></a></p>
                     </section>
										 </td>';
              }
              if ($tipo_anuncio==3) {// anunncio capacitaciones

								echo'<td class="alert alert-warning">
											<p><strong>'.$i++.'</strong></p>
										 </td>';
                echo'<td class="alert alert-warning">
                      <p><strong>Fecha registro: </strong>'.$fila_anuncio['freg'].'</p>
                      <p><strong>TITULO: </strong>'.$fila_anuncio['titulo'].'</p>
                      <p><strong>CONTENIDO: </strong>'.$fila_anuncio['anuncio'].'</p>
                          <button type="button" class="btn btn-info " data-toggle="modal" data-target="#gdocu_'.$fila_anuncio["id_anuncio"].'">Cargar Adicionales</button>
                     </td>';
                echo'<td class="alert alert-warning">
											<p><button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit_anuncio_'.$fila_anuncio["id_anuncio"].'">Editar Anuncio</button></p>
                      <p><a href="Funcion_base/eliminar_anuncio.php?id='.$fila_anuncio["id_anuncio"].'&resp='.$_SESSION['AUT']['id_user'].'"><button type="button" class="btn btn-danger" ><span class="fa fa-trash"></span> Eliminar Anuncio</button></a></p>
                     </td>';

              }
							echo'	<article class="col-md-12">
								<div id="edit_anuncio_'.$fila_anuncio['id_anuncio'].'" class="modal fade" role="dialog">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="modal-title">Editar anuncio</h4>
											</div>
											<div class="modal-body">
											<form action="Funcion_base/editar_anuncio.php" method="POST">
												<section class="panel-body">
													<article class="col-md-12">
														<label>titulo</label>
														<input type="text" class="form-control" name="titulo" value="'.$fila_anuncio["titulo"].'">
														<input type="hidden" name="id_anuncio" value="'.$fila_anuncio["id_anuncio"].'">
														<input type="hidden" name="resp" value="'.$_SESSION['AUT']['id_user'].'">
													</article>
													<article class="col-md-12">
														<label>Anuncio</label>
														<textarea class="form-control" name="anuncio" rows="6">'.$fila_anuncio["anuncio"].'</textarea>
													</article>

												</section>
												<section class="panel-body">
													<article class="col-md-12">
														<input type="submit" value="Editar">
													</article>
												</section>
											</form>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											</div>
										</div>
									</div>
								</div>
								</article>';
							echo'</tr>';

						}
					}

					?>

				 </table>
			</section>
		</section>
</section>
	<?php
}
?>
