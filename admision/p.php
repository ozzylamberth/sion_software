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
						//print_r($_FILES);
			$fotoE="";$fotoA1="";$fotoA2="";
			if (isset($_FILES["foto"])){
				if (is_uploaded_file($_FILES["foto"]["tmp_name"])){

					$cfoto=explode(".",$_FILES["foto"]["name"]);
					$archivo=$_POST["idpac"].'_'.$_POST["nomdoc"].".".$cfoto[count($cfoto)-1];

					if(move_uploaded_file($_FILES["foto"]["tmp_name"],WEB.DOCPAC.$archivo)){
						$fotoE=",foto='".DOCPAC.$archivo."'";
						$fotoA=',foto';
						$fotob=",'".DOCPAC.$archivo."'";
						}
				}
			}
			switch ($_POST["operacion"]) {
			case 'E':
				$nom_completo=$_POST['nom1'].' '.$_POST['nom2'].' '.$_POST['ape1'].' '.$_POST['ape2'];
				$fecha=$_POST["fnacimiento"];
				$segundos= strtotime('now') - strtotime($fecha);
				$diferencia_dias=intval($segundos /60/60/24);
				$dias=floor($diferencia_dias/365);
				$sql="UPDATE pacientes SET tdoc_pac='".$_POST["tdocpac"]."',doc_pac='".$_POST["docpac"]."',nom1='".$_POST["nom1"]."',nom2='".$_POST["nom2"]."',
				ape1='".$_POST["ape1"]."',ape2='".$_POST["ape2"]."',
				fnacimiento='".$_POST["fnacimiento"]."',edad='".$dias."',uedad='1',dir_pac='".$_POST["dirpac"]."',tel_pac='".$_POST["telpac"]."',
				email_pac='".$_POST["emailpac"]."',
				estadocivil='".$_POST["estadocivil"]."',genero='".$_POST["genero"]."',rh='".$_POST["rh"]."',etnia='".$_POST["etnia"]."',
				lateralidad='".$_POST["lateralidad"]."',profesion='".$_POST["profesion"]."',religion='".$_POST["religion"]."'$fotoE,estado_pac='".$_POST["estado_pac"]."',
				nom_completo='$nom_completo'
				where id_paciente=".$_POST["idpaci"];
				$subtitulo="El registro del paciente ";
				$subtitulo1="Actualizado";
			break;
			case 'X':
				$sql="SELECT logo from cliente where id=".$_POST["idcli"];
				if (!$fila=$bd1->sub_fila($sql)){
					$fila=array("logo"=> "");
				}
				$sql="DELETE FROM cliente WHERE id_cliente=".$_POST["idcli"];
				$subtitulo="Eliminado";
			break;
			case 'A':
				$nom_completo=$_POST['nom1'].' '.$_POST['nom2'].' '.$_POST['ape1'].' '.$_POST['ape2'];
				$fecha=$_POST["fnacimiento"];
				$segundos= strtotime('now') - strtotime($fecha);
				$diferencia_dias=intval($segundos /60/60/24);
				$dias=floor($diferencia_dias/365);
				$sql="INSERT INTO pacientes (tdoc_pac,doc_pac,nom1,nom2,ape1,ape2,fnacimiento,edad,uedad,dir_pac,tel_pac,email_pac,estadocivil,
					genero,rh,etnia,lateralidad,profesion$fotoA1,religion,estado_pac,nom_completo) VALUES
				('".$_POST["tdocpac"]."','".$_POST["docpac"]."','".$_POST["nom1"]."','".$_POST["nom2"]."','".$_POST["ape1"]."',
				'".$_POST["ape2"]."','".$_POST["fnacimiento"]."','".$dias."','1','".$_POST["dirpac"]."',
				'".$_POST["telpac"]."','".$_POST["emailpac"]."','".$_POST["estadocivil"]."','".$_POST["genero"]."','".$_POST["rh"]."',
				'".$_POST["etnia"]."','".$_POST["lateralidad"]."','".$_POST["profesion"]."','".$_POST["religion"]."'$fotoA2,
				'".$_POST["estado_pac"]."','$nom_completo')";
				$subtitulo="El regitro del paciente ";
				$subtitulo1="Adicionado";
			break;
			case 'ACU':
				$sql="INSERT INTO info_acudiente (id_adm_hosp,nombre_acu,dir_acu,tel_acu,parentesco_acu) VALUES
				('".$_POST["idadm"]."','".$_POST["nombre"]."','".$_POST["direccion"]."','".$_POST["telefono"]."','".$_POST["parentesco"]."')";
				$subtitulo="El registro de ACUDIENTE ";
				$subtitulo1="Adicionado";
			break;
			case 'DOC':
				$sql="INSERT INTO info_documentacion (id_paciente,nombre_doc$fotoA)
				VALUES ('".$_POST["idpac"]."','".$_POST["nomdoc"]."'$fotob)";
				$subtitulo="El soporte documental ";
				$subtitulo1="Cargado";
			break;
			case 'E':
			$sql="UPDATE adm_hospitalario set fegreso_hosp='".$_POST["fegreso"]."',hegreso_hosp='".$_POST["hegreso"]."',
			estado_salida='".$_POST["esalida"]."',via_salida='".$_POST["viasalida"]."',
			medsalida='".$_SESSION["AUT"]["nombre"]."',estado_adm_hosp='Parcial'
			WHERE id_adm_hosp='".$_POST["idadmhosp"]."'";
			$subtitulo="Realizado";
			break;
		}
		echo $sql;
		if ($bd1->consulta($sql)){
			$subtitulo="$subtitulo fue $subtitulo1 con exito!";
			$check='si';
			if($_POST["operacion"]=="X"){
			if(is_file($fila["logo"])){
				unlink($fila["logo"]);
			}
			}
		}else{
			$subtitulo="$subtitulo NO fue $subtitulo1 !!! .";
			$check='no';
		}
	}
}

if (isset($_GET["mante"])){					///nivel 2
	switch ($_GET["mante"]) {
		case 'E':
			$sql="SELECT a.id_paciente, tdoc_pac, doc_pac, nom1, nom2, ape1, ape2, fnacimiento, edad, uedad, dir_pac, tel_pac, email_pac, estadocivil,
									 genero, rh, etnia, lateralidad, profesion, religion, fotopac, estado_pac, cie, descricie, zonapac, ipsordena,
									 b.tipo,descri_tipo
						FROM pacientes a LEFT JOIN tdocumentos b on a.tdoc_pac=b.tipo
						WHERE id_paciente=".$_GET["idpac"];
						//echo $sql;
			$color="green";
			$boton="Actualizar";
			$atributo1=' readonly="readonly"';
			$atributo2='';
			$atributo3='';
			$option=17;
			$doc=$_REQUEST['doc'];
			$form1='admision/add_paciente.php';
			$subtitulo='Edicion o actualizacion de datos del paciente';
			break;
			case 'DOC':
				$sql="SELECT a.id_paciente, tdoc_pac, doc_pac, nom1, nom2, ape1, ape2, fnacimiento, edad, uedad, dir_pac, tel_pac, email_pac, estadocivil,
										 genero, rh, etnia, lateralidad, profesion, religion, fotopac, estado_pac, cie, descricie, zonapac, ipsordena,
										 b.tipo,descri_tipo
							FROM pacientes a LEFT JOIN tdocumentos b on a.tdoc_pac=b.tipo
							WHERE id_paciente=".$_GET["idpac"];
							//echo $sql;
				$color="green";
				$boton="Cargar Documento";
				$atributo1=' readonly="readonly"';
				$atributo2='';
				$atributo3='';
				$option=17;
				$doc=$_REQUEST['doc'];
				$form1='admision/add_documentos.php';
				$subtitulo='Cargar documentos del paciente';
				break;
			case 'ACU':
			$pac=$_GET['idadm'];
				$sql="SELECT a.id_paciente, tdoc_pac, doc_pac, nom1, nom2, ape1, ape2, fnacimiento, edad, uedad, dir_pac, tel_pac, email_pac, estadocivil,
										 genero, rh, etnia, lateralidad, profesion, religion, fotopac, estado_pac, cie, descricie, zonapac, ipsordena,
										 c.id_adm_hosp
							FROM pacientes a INNER JOIN adm_hospitalario c on a.id_paciente=c.id_paciente
							WHERE c.id_adm_hosp=$pac and c.estado_adm_hosp='Activo'";
							//echo $sql;
				$color="green";
				$boton="Agregar acudiente";
				$atributo1=' readonly="readonly"';
				$atributo2='';
				$atributo3='';
				$option=17;
				$doc=$_REQUEST['doc'];
				$form1='admision/add_acudiente.php';
				$subtitulo='Registro de acudiente';
			break;
			case 'EGR':
			$pac=$_GET['idadm'];
			$sql="SELECT a.id_paciente, tdoc_pac, doc_pac, nom1, nom2, ape1, ape2, fnacimiento, edad, uedad, dir_pac, tel_pac, email_pac, estadocivil,
									 genero, rh, etnia, lateralidad, profesion, religion, fotopac, estado_pac, cie, descricie, zonapac, ipsordena,
									 c.id_adm_hosp,fingreso_hosp,hingreso_hosp,fegreso_hosp,hegreso_hosp
						FROM pacientes a INNER JOIN adm_hospitalario c on a.id_paciente=c.id_paciente
						WHERE c.id_adm_hosp=$pac and c.estado_adm_hosp='Activo'";
						//echo $sql;
			$color="green";
			$boton="Egresar paciente";
			$atributo1=' readonly="readonly"';
			$atributo2='';
			$atributo3='';
			$option=17;
			$doc=$_REQUEST['doc'];
			$form1='admision/egreso.php';
			$subtitulo='Egreso del paciente';
			break;
			case 'A':
			$sql="";
			$color="yellow";
			$boton="Crear Paciente";
			$atributo1=' readonly="readonly"';
			$atributo2='';
			$atributo3='disabled';
			$date=date('Y-m-d');
			$option=17;
			$doc=$_REQUEST['doc'];
			$form1='admision/add_paciente.php';
			$subtitulo='Registro de datos básicos del paciente';
			break;
		}

		if($sql!=""){
			if (!$fila=$bd1->sub_fila($sql)){
				$fila=array("id_paciente"=>"", "tdoc_pac"=>"", "doc_pac"=>"", "nom1"=>"", "nom2"=>"", "ape1"=>"", "ape2"=>"", "fnacimiento"=>"", "edad"=>"",
				"uedad"=>"", "dir_pac"=>"", "tel_pac"=>"", "email_pac"=>"", "estadocivil"=>"", "genero"=>"", "rh"=>"", "etnia"=>"", "lateralidad"=>"",
				"profesion"=>"", "religion"=>"", "fotopac"=>"", "estado_pac"=>"", "cie"=>"", "descricie"=>"", "zonapac"=>"", "ipsordena"=>"", "tipo"=>"",
				"descri_tipo"=>"","fingreso_hosp"=>"","hingreso_hosp"=>"");

			}
		}else{
				$fila=array("id_paciente"=>"", "tdoc_pac"=>"", "doc_pac"=>"", "nom1"=>"", "nom2"=>"", "ape1"=>"", "ape2"=>"", "fnacimiento"=>"", "edad"=>"",
				"uedad"=>"", "dir_pac"=>"", "tel_pac"=>"", "email_pac"=>"", "estadocivil"=>"", "genero"=>"", "rh"=>"", "etnia"=>"", "lateralidad"=>"",
				"profesion"=>"", "religion"=>"", "fotopac"=>"", "estado_pac"=>"", "cie"=>"", "descricie"=>"", "zonapac"=>"", "ipsordena"=>"", "tipo"=>"",
				"descri_tipo"=>"","fingreso_hosp"=>"","hingreso_hosp"=>"");
			}

		?>
<script src = "js/sha3.js"></script>
		<script>
			function validar(){
				if (document.forms[0].nom_cliente.value == ""){
					alert("Se requiere el nombre del cliente!");
					document.forms[0].nom_cliente.focus();				// Ubicar el cursor
					return(false);
				}
			}
		</script>
	<?php include ($form1);?>
<?php
}else{
	if ($check=='si') {
		echo '<div class="alert alert-success animated bounceInRight">';
		echo $subtitulo;
		echo '</div>';
	}else {
		echo '<div class="alert alert-danger animated bounceInRight">';
		echo $subtitulo;
		echo '</div>';
	}

// nivel 1?>
<section class="panel panel-default">
		<section class="panel-body">
			<?php
				include("consulta_rapida1.php");
			?>
		</section>
		<section class="panel-heading"><h4>Admisiones y registro SION Software</h4></section>
		<section class="col-xs-6">
			<label for="" class="alert alert-info text-center col-xs-12">Filtro por documento</label>
			<form>
				<section class="panel-body">
					<article class="col-xs-12 input-group">
						<span class="input-group-addon fa fa-user" id="basic-addon1"></span>
						<input type="text" class="form-control" placeholder="Digite documento de identidad" name="doc" aria-describedby="basic-addon1">
					</article>
					<br>
					<div class="text-center animated bounceIn">
						<input type="submit" name="buscar" class="btn btn-warning" value="Buscar">
						<input type="hidden" name="opcion" Value="<?php echo $_GET["opcion"];?>"/>
					</div>
				</section>
			</form>
		</section>
		<section class="col-xs-6">
			<label for="" class="alert alert-info text-center col-xs-12">Filtro por Nombre</label>
			<form>
				<section class="panel-body">
					<article class="col-xs-12 input-group">
						<span class="input-group-addon fa fa-user" id="basic-addon1"></span>
						<input type="text" class="form-control" placeholder="Digite nombre o apellido " name="nom" aria-describedby="basic-addon1">
					</article>
					<br>
					<div class="text-center animated bounceIn">
						<input type="submit" name="buscar" class="btn btn-warning" value="Buscar">
						<input type="hidden" name="opcion" Value="<?php echo $_GET["opcion"];?>"/>
					</div>
				</section>
			</form>
		</section>
		<section>
			<table class="table table-bordered">
				<tr>

					<th>PACIENTE</th>
					<th>FOTO</th>
					<th>ADMISION ACTUAL</th>
					<th></th>
				</tr>

				<?php
				if (isset($_REQUEST["doc"])){
				$fecha=$_REQUEST["doc"];
				$sql="SELECT id_paciente,tdoc_pac,doc_pac,nom1,nom2,ape1,ape2,fotopac
							FROM pacientes
							WHERE doc_pac='".$fecha."'";
					//echo $sql;
				if ($tabla=$bd1->sub_tuplas($sql)){
					//echo $sql;
					foreach ($tabla as $fila ) {

							echo"<tr >\n";
							echo'<td class="text-center">
										<p>'.$fila["nom1"].' '.$fila["nom2"].' '.$fila["ape1"].' '.$fila["ape2"].'</p>
										<p><strong>'.$fila["tdoc_pac"].':</strong> '.$fila["doc_pac"].' <strong>ID:</strong>'.$fila["id_paciente"].'</p>
										<p><a href="'.PROGRAMA.'?opcion='.$_REQUEST["opcion"].'&mante=E&idpac='.$fila["id_paciente"].'&doc='.$fila["doc_pac"].'"><button type="button" class="btn btn-primary" ><span class="fa fa-edit"></span> Editar paciente</button></a></p>
									 </td>';
							echo'<td class="text-center"><img src="'.$fila["fotopac"].'"alt ="foto" class="image_login cursor1" data-toggle="modal" data-target="#modalpac"> </td>';
							echo'<td class="text-center">';
							$pac=$fila['id_paciente'];
							$sql2="SELECT a.id_paciente,
														b.id_adm_hosp,fingreso_hosp,fegreso_hosp,tipo_servicio,estado_adm_hosp
									FROM pacientes a LEFT JOIN adm_hospitalario b on (a.id_paciente=b.id_paciente)

									WHERE a.id_paciente=$pac and estado_adm_hosp='Activo'";
									//echo $sql2;
									if ($tabla2=$bd1->sub_tuplas($sql2)){
										foreach ($tabla2 as $fila2 ) {
											if ($fila2['estado_adm_hosp']=='Activo') {
												echo'
												<article class="col-xs-12 alert alert-danger">
													<p><strong>'.$fila2['tipo_servicio'].'</strong></p>
													<p>'.$fila2['fingreso_hosp'].' '.$fila2['fegreso_hosp'].'</p>
													<p>Tiene servicio ACTIVO, NO es posible realizar admisión</p>
													<p><a href="'.PROGRAMA.'?opcion='.$_REQUEST["opcion"].'&mante=EGR&idadm='.$fila2["id_adm_hosp"].'"><button type="button" class="btn btn-danger sombra_movil"><span class="fa fa-ban"></span> Desea dar egreso?</button></a></p>
												</article>';
											}else {
												echo'<a href="'.PROGRAMA.'?opcion='.$_REQUEST["opcion"].'&mante=ADM&idpac='.$fila["id_paciente"].'"><button type="button" class="btn btn-success sombra_movil"><span class="fa fa-play"></span> Admisión</button></a>';
											}

										}
									}
							echo'</td>';
							echo'<th class="text-center " >';
							$adm=$fila2['id_adm_hosp'];
							$sql3="SELECT b.id_adm_hosp,fingreso_hosp,fegreso_hosp,tipo_servicio,estado_adm_hosp,
														c.id_infoacu,parentesco_acu,nombre_acu
									FROM adm_hospitalario b LEFT JOIN info_acudiente c on (c.id_adm_hosp=b.id_adm_hosp)

									WHERE b.id_adm_hosp=$adm";
									//echo $sql3;
									if ($tabla3=$bd1->sub_tuplas($sql3)){
										foreach ($tabla3 as $fila3 ) {
											if ($fila3['id_infoacu']=='') {
												echo'
												<article class="col-xs-6 alert alert-info animated shake well">
													<p>No tiene registro de ACUDIENTE en admisión #'.$fila2['id_adm_hosp'].' servicio: '.$fila2['tipo_servicio'].' Egreso:'.$fila2['fegreso_hosp'].'</p>
												</article>
												<article class="col-xs-6 well">
													<a href="'.PROGRAMA.'?opcion='.$_REQUEST["opcion"].'&mante=ACU&idadm='.$fila2["id_adm_hosp"].'&doc='.$fila["doc_pac"].'"><button type="button" class="btn btn-warning sombra_movil"><span class="fa fa-user"></span>  <p>Registrar Acudiente</p></button></a>
												</article>';
											}else {
												echo'
												<article class="col-xs-12 alert alert-info well">
													<p><strong>Nombre acudiente:</strong> '.$fila3['nombre_acu'].'</p>
													<p><strong>Parentesco:</strong> '.$fila3['parentesco_acu'].'</p>
												</article>';
											}
										}

									}
							echo'<article class="col-xs-4">
										<p><a href="'.PROGRAMA.'?opcion='.$_REQUEST["opcion"].'&mante=DOC&idpac='.$fila["id_paciente"].'&doc='.$fila["doc_pac"].'"><button type="button" class="btn btn-success sombra_movil"><span class="fa fa-file-text"></span> <p>Cargar documentos</p></button></a></p>
									 </article>
									 <article class="col-xs-8">
									 <h4>Documentos Cargados al paciente</h4>';
									 $adm=$fila['id_paciente'];
		 							$sql4="SELECT b.id_paciente,
		 														c.id_infodocs,nombre_doc,foto
		 									FROM pacientes b LEFT JOIN info_documentacion c on (c.id_paciente=b.id_paciente)

		 									WHERE b.id_paciente=$adm";
		 									//echo $sql4;
		 									if ($tabla4=$bd1->sub_tuplas($sql4)){
		 										foreach ($tabla4 as $fila4 ) {
		 											if ($fila4['id_infodocs']!='') {
														if ($fila4['nombre_doc']=='Documento Identidad' && $fila4['foto']!='') {
															echo'<p class="col-xs-4 fa fa-check animated fadeInLeft text-success borde_p"> Doc. Identidad</p>';
														}
														if ($fila4['nombre_doc']=='Autorizacion EPS' && $fila4['foto']!='') {
															echo'<p class="col-xs-4 fa fa-check animated fadeInLeft text-success borde_p"> Autorizacion EPS</p>';
														}
														if ($fila4['nombre_doc']=='Consentimiento Informado' && $fila4['foto']!='') {
															echo'<p class="col-xs-4 fa fa-check animated fadeInLeft text-success borde_p"> Consentimiento Informado</p>';
														}
														if ($fila4['nombre_doc']=='Consentimiento Traslado' && $fila4['foto']!='') {
															echo'<p class="col-xs-3 fa fa-check animated fadeInLeft text-success borde_p"> Consentimiento Traslado</p>';
														}
														if ($fila4['nombre_doc']=='Consentimiento Procedimientos' && $fila4['foto']!='') {
															echo'<p class="col-xs-3 fa fa-check animated fadeInLeft text-success borde_p"> Consentimiento Procedimientos</p>';
														}
														if ($fila4['nombre_doc']=='Epicrisis' && $fila4['foto']!='') {
															echo'<p class="col-xs-3 fa fa-check animated fadeInLeft text-success borde_p"> Epicrisis</p>';
														}
														if ($fila4['nombre_doc']=='Pagare' && $fila4['foto']!='') {
															echo'<p class="col-xs-3 fa fa-check animated fadeInLeft text-success borde_p"> Pagare</p>';
														}
		 											}
		 										}
		 									}
							echo'</article></th>';
							echo "</tr>\n";

					}
				}
			}
			if (isset($_REQUEST["nom"])){
			$fecha=$_REQUEST["nom"];
			$sql="SELECT a.id_paciente,tdoc_pac,doc_pac,nom1,nom2,ape1,ape2,fotopac,b.id_adm_hosp,fingreso_hosp,tipo_servicio,estado_adm_hosp FROM pacientes a LEFT JOIN adm_hospitalario b on a.id_paciente=b.id_paciente WHERE a.nom_completo LIKE '%".$fecha."%'";

			if ($tabla=$bd1->sub_tuplas($sql)){
				//echo $sql;
				foreach ($tabla as $fila ) {

				}
			}
			}
				?>

				<tr>
					<th colspan="14" class="text-center"><a href="<?php echo PROGRAMA.'?opcion='.$_REQUEST["opcion"].'&mante=A&doc='.$_REQUEST['doc'];?>"><button type="button" class="btn btn-primary fa fa-user-plus"> Creación Nuevo Paciente</button>
					</a></th>
				</tr>
			</table>

		</section>
</section>

	<?php
}
?>
