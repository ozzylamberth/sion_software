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
			case 'A':
				$sql="INSERT INTO m_producto ( id_bodega, fcreacion, nom_producto, estado_producto, crea_mproducto) VALUES
				('".$_POST["idbog"]."','".date('Y-m-d H:m')."','".$_POST["nomgenerico"]."','Activo','".$_SESSION["AUT"]["id_user"]."')";
				$subtitulo="Medicamento principal";
				$subtitulo1="Adicionado";

			break;
			case 'EVO':
				$sql="INSERT INTO evo_nutrism (id_adm_hosp, id_user, freg_nutrice_sm, hreg_nutrice_sm, evolucion_nutri, estado_evonutri) VALUES
				('".$_POST["idadmhosp"]."','".$_SESSION["AUT"]["id_user"]."','".$_POST["freg"]."','".$_POST["hreg"]."','".$_POST["evoto"]."','Realizada')";
				$subtitulo="Evolución";
				$subtitulo1="Adicionado";

			break;
		}
	//echo $sql;
		if ($bd1->consulta($sql)){
			$subtitulo="El $subtitulo  fue $subtitulo1 con exito!";
			if($_POST["operacion"]=="X"){
			if(is_file($fila["logo"])){
				unlink($fila["logo"]);
			}
			}
		}else{
			$subtitulo="El $subtitulo  NO fue $subtitulo1 !!! .";
		}
	}
}
if (isset($_GET["mante"])){					///nivel 2
	switch ($_GET["mante"]) {
			case 'ADD':
      $sql="SELECT id_producto,id_bodega,nom_producto,estado_producto FROM m_producto WHERE id_producto=".$_REQUEST['idmp'];
			$boton="Agregar Detalle Medicamento";
			$atributo1=' readonly="readonly"';
			$atributo2='';
			$atributo3='';
			$date=date('Y-m-d');
			$date1=date('H:i');
			$form1='formulariosMED/add_dproducto.php';
			$subtitulo='Adición detalle de productos.';
			break;
			case 'A':
      $sql="";
			$boton="Agregar Medicamento Principal";
			$atributo1=' readonly="readonly"';
			$atributo2='';
			$atributo3='';
			$date=date('Y-m-d');
			$date1=date('H:i');
			$form1='formulariosMED/add_mproducto.php';
			$subtitulo='Creación de medicamento principal.';
			break;
		}
//echo $sql;
		if($sql!=""){
			if (!$fila=$bd1->sub_fila($sql)){
				$fila=array("id_producto"=>"","id_bodega"=>"","nom_producto"=>"","estado_producto"=>"");
			}
		}else{
				$fila=array("id_producto"=>"","id_bodega"=>"","nom_producto"=>"","estado_producto"=>"");
			}
		?>
<script src = "js/sha3.js"></script>
		<script>
			function validar(){
				if (document.forms[0].hreg.value > document.forms[0].fecha.value){
					alert("Enfermero (a) <?php echo $_SESSION["AUT"]["nombre"]?>, NO puede adelantar el tiempo.");
					document.forms[0].hreg.focus();				// Ubicar el cursor
					return(false);
				}
			}
		</script>
		<script type="text/javascript" src="/js/jquery.js"></script>
		<div class="alert alert-info animated bounceInRight">
			<?php echo $subtitulo;?>
		</div>
		<?php include($form1);?>

<?php
}else{
	echo '<div class="alert alert-success animated bounceInRight">';
	echo $subtitulo;
	echo '</div>';
// nivel 1?>
<section class="panel panel-default">
  <section class="panel-heading"><h4>Administración de Medicamentos en Farmacia</h4></section>
	<section class="panel-body col-xs-12">
		<section class="col-xs-6">
					<form>
						<div class="row">
						  <div class="col-lg-12">
						    <div class="input-group">
									<select name="sede" class="form-control" id="sede" onchange="mostrarbod()" aria-describedby="basic-addon1" <?php echo $atributo2;?>>
										<option value="0"></option>
										<?php
											$sql_pais = "SELECT * FROM sedes_ips WHERE id_sedes_ips in (2,8)";
											$resultado = $conex->query($sql_pais);
											if($conex->errno) die($conex->error);
											while ($fila = $resultado ->fetch_assoc()){
										?>
											<option value="<?php echo $fila['id_sedes_ips'] ?>"><?php echo $fila['nom_sedes']; ?></option>
										<?php
											}
										?>
									</select>
						      <span class="input-group-btn">
											<input type="submit" name="buscar" class="btn btn-primary" value="Consultar">
											<input type="hidden" name="opcion" Value="<?php echo $_GET["opcion"];?>"/>
						      </span>
						    </div><!-- /input-group -->
						  </div><!-- /.col-lg-6 -->
						</div>
					</form>
		</section>
		<section class="col-xs-6">
				<p class="alert alert-info animated zoomInRight text-center">
					<span class="fa fa-arrow-left fa-2x"></span>
					PARA TENER EN CUENTA  <strong class="text-center"><br>JEFE <?php echo $_SESSION['AUT']['nombre'] ?></strong>:<br>
				</p>
		</section>
		<section class="col-md-12">
			<article class="col-xs-4 alert alert-success animated bounceIn">
				<a href=""><button type="button" class="btn btn-success" > Farmacia</button></a> = Aqui administra y registra los medicamentos que despacha farmacia cuando esta en la institución.<br>
			</article>
			<article class="col-xs-4 alert alert-warning animated bounceIn">
				<a href=""><button type="button" class="btn btn-warning" > Auxiliar</button></a> = Aqui administra los medicamentos cuando la farmacia no se encuentra en la institución y es ordenado por el medico al carro de medicamento auxiliar.<br>
			</article>
			<article class="col-xs-4 alert alert-danger animated bounceIn">
				<a href=""><button type="button" class="btn btn-danger" > Carro paro</button></a> = Aqui administra y registra los medicamentos utilizados en caso de requerir el carro de paro.
			</article>
		</section>
	</section>

	<section class="panel-body col-xs-12">
		<?php
			$sede=$_REQUEST['sede'];
			if ($sede==2) {
				?>

				  <section class="panel-body col-xs-12 text-left">
				    <div class="col-xs-12 text-center">
				        <button data-toggle="collapse" class="btn btn-primary text-center col-xs-12" data-target="#uca">
									<article class="col-xs-2">
										<span class="fa fa-hospital-o fa-4x"></span>
									</article>
									<article class="col-xs-6">
										<hgroup>
											<h3>UCA</h3>
											<h4>Clínica Facatativá</h4>
										</hgroup>
									</article>
									<article class="col-xs-4">
										<dl><i><strong>PABELLONES</strong></i>
											<dd><span class="fa fa-female"></span> Femenino</dd>
											<dd><span class="fa fa-male"></span> Masculino</dd>
										</dl>
									</article>
								</button>
				    </div>
				    <section id="uca" class="collapse col-lg-12 text-left">
				      <table class="table table-bordered">
				        <thead class="thead-inverse ">
				          <tr>
										<th class="text-center danger">#</th>
				            <th class="text-center danger">PACIENTE</th>
				            <th class="text-center danger">UBICACION</th>
				            <th class="text-center danger"></th>
				          </tr>
				        </thead>
				          <?php
									$sede=$_REQUEST['sede'];
				          $sql="SELECT a.id_paciente,tdoc_pac,doc_pac,nom1,nom2,ape1,ape2,fotopac,
				                       b.id_adm_hosp,
				                       c.id_ubipaciente,
				                       d.nom_cama,
				                       e.nom_hab,
				                       f.nom_pabellon,
				                       g.nom_piso
				              FROM pacientes a INNER JOIN adm_hospitalario b on (a.id_paciente=b.id_paciente)
				                               INNER JOIN ubipaciente c on b.id_adm_hosp=c.id_adm_hosp
				                               INNER JOIN cama d on d.id_cama=c.id_cama
				                               INNER JOIN habitacion e on e.id_habitacion=d.id_habitacion
				                               INNER JOIN pabellon f on f.id_pabellon=e.id_pabellon
				                               INNER JOIN piso g on g.id_piso=f.id_piso
				              WHERE b.estado_adm_hosp='Activo' and g.id_piso='1' and c.ffinal is null ";
				              //echo $sql;
											$i=1;
				        if ($tabla=$bd1->sub_tuplas($sql)){
				          foreach ($tabla as $fila ) {
										$sede=$_REQUEST['sede'];
				                echo"<tr >\n";
												echo'<td class="text-center">'.$i++.'</td>';
				                echo'<td class="text-center">
																<p>'.$fila["nom1"].' '.$fila["nom2"].' '.$fila["ape1"].' '.$fila["ape2"].'</p>
																<p><strong>'.$fila["tdoc_pac"].':</strong> '.$fila["doc_pac"].'</p>
														 </td>';
				                echo'<td class="text-center">
																<p><strong>Piso/Pabellon: </strong><br>'.$fila["nom_piso"].' '.$fila["nom_pabellon"].' '.$fila["nom_hab"].' '.$fila["nom_cama"].'</p>
																<figure class="text-center"><img src="'.$fila["fotopac"].'"alt ="foto" class="image_piso"></figure>
														 </td>';
				                echo'<th class="text-left">
															<p><a href="'.PROGRAMA.'?opcion=155&idadmhosp='.$fila["id_adm_hosp"].'&servicio=Hospitalario&doc='.$fila["doc_pac"].'&sede='.$sede.'"><button type="button" class="btn btn-success" > Farmacia</button></a></p>
															<p><a href="'.PROGRAMA.'?opcion=171&idadmhosp='.$fila["id_adm_hosp"].'&servicio=Hospitalario&doc='.$fila["doc_pac"].'&sede='.$sede.'&bod=14"><button type="button" class="btn btn-warning" > Auxiliar</button></a></p>
															<p><a href="'.PROGRAMA.'?opcion=&idadmhosp='.$fila["id_adm_hos"].'&servicio=Hospitalario&doc='.$fila["doc_pac"].'&sede='.$_REQUEST['sede'].'&bod=5"><button type="button" class="btn btn-danger "> CP-UCA</button></a>
																 <a href="'.PROGRAMA.'?opcion=&idadmhosp='.$fila["id_adm_hosp"].'&servicio=Hospitalario&doc='.$fila["doc_pac"].'&sede='.$_REQUEST['sede'].'&bod=6"><button type="button" class="btn btn-danger "> CP-1</button></a>
																 <a href="'.PROGRAMA.'?opcion=&idadmhosp='.$fila["id_adm_hosp"].'&servicio=Hospitalario&doc='.$fila["doc_pac"].'&sede='.$_REQUEST['sede'].'&bod=7"><button type="button" class="btn btn-danger "> CP-2</button></a>
															   <a href="'.PROGRAMA.'?opcion=&idadmhosp='.$fila["id_adm_hosp"].'&servicio=Hospitalario&doc='.$fila["doc_pac"].'&sede='.$_REQUEST['sede'].'&bod=8"><button type="button" class="btn btn-danger "> CP-3</button></a></p>
														 </th>';
				                echo"</tr >\n";

				          }
				        }
				        ?>
				      </table>
				    </section>
				  </section>
				  <section class="panel-body col-xs-12 text-right">
				    <div class="col-xs-12 text-center">
				        <button data-toggle="collapse" class="btn btn-primary text-center col-xs-12" data-target="#p1">
									<article class="col-xs-2">
										<span class="fa fa-hospital-o fa-4x"></span>
									</article>
									<article class="col-xs-6">
										<hgroup>
											<h3>PISO 1</h3>
											<h4>Clínica Facatativá</h4>
										</hgroup>
									</article>
									<article class="col-xs-4">
										<dl><i><strong>PABELLONES</strong></i>
											<dd><span class="fa fa-male"></span><span class="fa fa-female"></span> AVD Mixto</dd>
											<dd><span class="fa fa-female"></span> Mujeres</dd>
										</dl>
									</article>
								</button>
				    </div>
				    <section id="p1" class="collapse">
				      <table class="table table-bordered">
				        <thead class="thead-inverse ">
									<tr>
										<th class="text-center danger">#</th>
				            <th class="text-center danger">PACIENTE</th>
				            <th class="text-center danger">UBICACION</th>
				            <th class="text-center danger"></th>
				          </tr>
				        </thead>
				          <?php

				          $sql="SELECT a.id_paciente,tdoc_pac,doc_pac,nom1,nom2,ape1,ape2,fotopac,
				                       b.id_adm_hosp,b.id_sedes_ips sede,
				                       c.id_ubipaciente,
				                       d.nom_cama,
				                       e.nom_hab,
				                       f.nom_pabellon,
				                       g.nom_piso
				              FROM pacientes a INNER JOIN adm_hospitalario b on (a.id_paciente=b.id_paciente)
				                               INNER JOIN ubipaciente c on b.id_adm_hosp=c.id_adm_hosp
				                               INNER JOIN cama d on d.id_cama=c.id_cama
				                               INNER JOIN habitacion e on e.id_habitacion=d.id_habitacion
				                               INNER JOIN pabellon f on f.id_pabellon=e.id_pabellon
				                               INNER JOIN piso g on g.id_piso=f.id_piso
				              WHERE b.estado_adm_hosp='Activo' and g.id_piso='2' and c.ffinal is null";
				              //echo $sql;$i=1;
											$i=1;
				        if ($tabla=$bd1->sub_tuplas($sql)){
				          foreach ($tabla as $fila ) {
											$sede=$_REQUEST['sede'];
				                echo"<tr >\n";
												echo'<td class="text-center">'.$i++.'</td>';
				                echo'<td class="text-center">
																<p>'.$fila["nom1"].' '.$fila["nom2"].' '.$fila["ape1"].' '.$fila["ape2"].'</p>
																<p><strong>'.$fila["tdoc_pac"].':</strong> '.$fila["doc_pac"].'</p>
														 </td>';
														 echo'<td class="text-center">
		 																<p><strong>Piso/Pabellon: </strong><br>'.$fila["nom_piso"].' '.$fila["nom_pabellon"].' '.$fila["nom_hab"].' '.$fila["nom_cama"].'</p>
		 																<figure class="text-center"><img src="'.$fila["fotopac"].'"alt ="foto" class="image_piso"></figure>
		 														 </td>';
												echo'<th class="text-left">
															<p><a href="'.PROGRAMA.'?opcion=155&idadmhosp='.$fila["id_adm_hosp"].'&servicio=Hospitalario&doc='.$fila["doc_pac"].'&sede='.$sede.'"><button type="button" class="btn btn-success" > Farmacia</button></a></p>
															<p><a href="'.PROGRAMA.'?opcion=171&idadmhosp='.$fila["id_adm_hosp"].'&servicio=Hospitalario&doc='.$fila["doc_pac"].'&sede='.$sede.'&bod=14"><button type="button" class="btn btn-warning" > Auxiliar</button></a></p>
															<p><a href="'.PROGRAMA.'?opcion=&idadmhosp='.$fila["id_adm_hos"].'&servicio=Hospitalario&doc='.$fila["doc_pac"].'&sede='.$_REQUEST['sede'].'&bod=5"><button type="button" class="btn btn-danger "> CP-UCA</button></a>
																 <a href="'.PROGRAMA.'?opcion=&idadmhosp='.$fila["id_adm_hosp"].'&servicio=Hospitalario&doc='.$fila["doc_pac"].'&sede='.$_REQUEST['sede'].'&bod=6"><button type="button" class="btn btn-danger "> CP-1</button></a>
																 <a href="'.PROGRAMA.'?opcion=&idadmhosp='.$fila["id_adm_hosp"].'&servicio=Hospitalario&doc='.$fila["doc_pac"].'&sede='.$_REQUEST['sede'].'&bod=7"><button type="button" class="btn btn-danger "> CP-2</button></a>
															   <a href="'.PROGRAMA.'?opcion=&idadmhosp='.$fila["id_adm_hosp"].'&servicio=Hospitalario&doc='.$fila["doc_pac"].'&sede='.$_REQUEST['sede'].'&bod=8"><button type="button" class="btn btn-danger "> CP-3</button></a></p>
														 </th>';
				                echo"</tr >\n";

				          }
				        }
				        ?>
				      </table>
				    </section>
				  </section>
				  <section class="panel-body col-xs-12 text-left">
				    <div class="col-xs-12 text-center">
				        <button data-toggle="collapse" class="btn btn-primary text-center col-xs-12" data-target="#p2">
									<article class="col-xs-2">
										<span class="fa fa-hospital-o fa-4x"></span>
									</article>
									<article class="col-xs-6">
										<hgroup>
											<h3>PISO 2</h3>
											<h4>Clínica Facatativá</h4>
										</hgroup>
									</article>
									<article class="col-xs-4">
										<dl><i><strong>PABELLONES</strong></i>
											<dd>Crónico <span class="fa fa-male"></span> NO AVD</dd>
											<dd><span class="fa fa-male"></span> Hombres</dd>
										</dl>
									</article>
								</button>
				    </div>
				    <section id="p2" class="collapse">
				      <table class="table table-bordered">
				        <thead class="thead-inverse ">
									<tr>
										<th class="text-center danger">#</th>
				            <th class="text-center danger">PACIENTE</th>
				            <th class="text-center danger">UBICACION</th>
				            <th class="text-center danger"></th>
				          </tr>
				        </thead>
				          <?php
									$sede=$_REQUEST['sede'];
				          $sql="SELECT a.id_paciente,tdoc_pac,doc_pac,nom1,nom2,ape1,ape2,fotopac,
				                       b.id_adm_hosp,
				                       c.id_ubipaciente,
				                       d.nom_cama,
				                       e.nom_hab,
				                       f.nom_pabellon,
				                       g.nom_piso
				              FROM pacientes a INNER JOIN adm_hospitalario b on (a.id_paciente=b.id_paciente)
				                               INNER JOIN ubipaciente c on b.id_adm_hosp=c.id_adm_hosp
				                               INNER JOIN cama d on d.id_cama=c.id_cama
				                               INNER JOIN habitacion e on e.id_habitacion=d.id_habitacion
				                               INNER JOIN pabellon f on f.id_pabellon=e.id_pabellon
				                               INNER JOIN piso g on g.id_piso=f.id_piso
				              WHERE b.estado_adm_hosp='Activo' and g.id_piso='3' and c.ffinal is null";
				              //echo $sql;
											$i=1;
				        if ($tabla=$bd1->sub_tuplas($sql)){
				          foreach ($tabla as $fila ) {

				                echo"<tr >\n";
												echo'<td class="text-center">'.$i++.'</td>';
				                echo'<td class="text-center">
																<p>'.$fila["nom1"].' '.$fila["nom2"].' '.$fila["ape1"].' '.$fila["ape2"].'</p>
																<p><strong>'.$fila["tdoc_pac"].':</strong> '.$fila["doc_pac"].'</p>
														 </td>';
														 echo'<td class="text-center">
		 																<p><strong>Piso/Pabellon: </strong><br>'.$fila["nom_piso"].' '.$fila["nom_pabellon"].' '.$fila["nom_hab"].' '.$fila["nom_cama"].'</p>
		 																<figure class="text-center"><img src="'.$fila["fotopac"].'"alt ="foto" class="image_piso"></figure>
		 														 </td>';
												echo'<th class="text-left">
															<p><a href="'.PROGRAMA.'?opcion=155&idadmhosp='.$fila["id_adm_hosp"].'&servicio=Hospitalario&doc='.$fila["doc_pac"].'&sede='.$sede.'"><button type="button" class="btn btn-success" > Farmacia</button></a></p>
															<p><a href="'.PROGRAMA.'?opcion=171&idadmhosp='.$fila["id_adm_hosp"].'&servicio=Hospitalario&doc='.$fila["doc_pac"].'&sede='.$sede.'&bod=14"><button type="button" class="btn btn-warning" > Auxiliar</button></a></p>
															<p><a href="'.PROGRAMA.'?opcion=&idadmhosp='.$fila["id_adm_hos"].'&servicio=Hospitalario&doc='.$fila["doc_pac"].'&sede='.$_REQUEST['sede'].'&bod=5"><button type="button" class="btn btn-danger "> CP-UCA</button></a>
																 <a href="'.PROGRAMA.'?opcion=&idadmhosp='.$fila["id_adm_hosp"].'&servicio=Hospitalario&doc='.$fila["doc_pac"].'&sede='.$_REQUEST['sede'].'&bod=6"><button type="button" class="btn btn-danger "> CP-1</button></a>
																 <a href="'.PROGRAMA.'?opcion=&idadmhosp='.$fila["id_adm_hosp"].'&servicio=Hospitalario&doc='.$fila["doc_pac"].'&sede='.$_REQUEST['sede'].'&bod=7"><button type="button" class="btn btn-danger "> CP-2</button></a>
															   <a href="'.PROGRAMA.'?opcion=&idadmhosp='.$fila["id_adm_hosp"].'&servicio=Hospitalario&doc='.$fila["doc_pac"].'&sede='.$_REQUEST['sede'].'&bod=8"><button type="button" class="btn btn-danger "> CP-3</button></a></p>
														 </th>';
				                echo"</tr >\n";

				          }
				        }
				        ?>
				      </table>
				    </section>
				  </section>
				  <section class="panel-body col-xs-12 text-right">
				    <div class="col-xs-12 text-center">
				        <button data-toggle="collapse" class="btn btn-primary text-center col-xs-12" data-target="#p3">
									<article class="col-xs-2">
										<span class="fa fa-hospital-o fa-4x"></span>
									</article>
									<article class="col-xs-6">
										<hgroup>
											<h3>PISO 3</h3>
											<h4>Clínica Facatativá</h4>
										</hgroup>
									</article>
									<article class="col-xs-4">
										<dl><i><strong>PABELLONES</strong></i>
											<dd>VIP</dd>
										</dl>
									</article>
								</button>
				    </div>
				    <section id="p3" class="collapse">
				      <table class="table table-bordered">
				        <thead class="thead-inverse ">
									<tr>
										<th class="text-center danger">#</th>
				            <th class="text-center danger">PACIENTE</th>
				            <th class="text-center danger">UBICACION</th>
				            <th class="text-center danger"></th>
				          </tr>
				        </thead>
				          <?php
									$sede=$_REQUEST['sede'];
				          $sql="SELECT a.id_paciente,tdoc_pac,doc_pac,nom1,nom2,ape1,ape2,fotopac,
				                       b.id_adm_hosp,
				                       c.id_ubipaciente,
				                       d.nom_cama,
				                       e.nom_hab,
				                       f.nom_pabellon,
				                       g.nom_piso
				              FROM pacientes a INNER JOIN adm_hospitalario b on (a.id_paciente=b.id_paciente)
				                               INNER JOIN ubipaciente c on b.id_adm_hosp=c.id_adm_hosp
				                               INNER JOIN cama d on d.id_cama=c.id_cama
				                               INNER JOIN habitacion e on e.id_habitacion=d.id_habitacion
				                               INNER JOIN pabellon f on f.id_pabellon=e.id_pabellon
				                               INNER JOIN piso g on g.id_piso=f.id_piso
				              WHERE b.estado_adm_hosp='Activo' and g.id_piso='4' and c.ffinal is null";
				              //echo $sql;
											$i=1;
				        if ($tabla=$bd1->sub_tuplas($sql)){
				          foreach ($tabla as $fila ) {

				                echo"<tr >\n";
												echo'<td class="text-center">'.$i++.'</td>';
				                echo'<td class="text-center">
																<p>'.$fila["nom1"].' '.$fila["nom2"].' '.$fila["ape1"].' '.$fila["ape2"].'</p>
																<p><strong>'.$fila["tdoc_pac"].':</strong> '.$fila["doc_pac"].'</p>
														 </td>';
														 echo'<td class="text-center">
		 																<p><strong>Piso/Pabellon: </strong><br>'.$fila["nom_piso"].' '.$fila["nom_pabellon"].' '.$fila["nom_hab"].' '.$fila["nom_cama"].'</p>
		 																<figure class="text-center"><img src="'.$fila["fotopac"].'"alt ="foto" class="image_piso"></figure>
		 														 </td>';
				                echo'<td class="text-center"><img src="'.$fila["fotopac"].'"alt ="foto" class="image_piso"> </td>';
												echo'<th class="text-left">
															<p><a href="'.PROGRAMA.'?opcion=155&idadmhosp='.$fila["id_adm_hosp"].'&servicio=Hospitalario&doc='.$fila["doc_pac"].'&sede='.$sede.'"><button type="button" class="btn btn-success" > Farmacia</button></a></p>
															<p><a href="'.PROGRAMA.'?opcion=171&idadmhosp='.$fila["id_adm_hosp"].'&servicio=Hospitalario&doc='.$fila["doc_pac"].'&sede='.$sede.'&bod=14"><button type="button" class="btn btn-warning" > Auxiliar</button></a></p>
															<p><a href="'.PROGRAMA.'?opcion=&idadmhosp='.$fila["id_adm_hos"].'&servicio=Hospitalario&doc='.$fila["doc_pac"].'&sede='.$_REQUEST['sede'].'&bod=5"><button type="button" class="btn btn-danger "> CP-UCA</button></a>
																 <a href="'.PROGRAMA.'?opcion=&idadmhosp='.$fila["id_adm_hosp"].'&servicio=Hospitalario&doc='.$fila["doc_pac"].'&sede='.$_REQUEST['sede'].'&bod=6"><button type="button" class="btn btn-danger "> CP-1</button></a>
																 <a href="'.PROGRAMA.'?opcion=&idadmhosp='.$fila["id_adm_hosp"].'&servicio=Hospitalario&doc='.$fila["doc_pac"].'&sede='.$_REQUEST['sede'].'&bod=7"><button type="button" class="btn btn-danger "> CP-2</button></a>
																 <a href="'.PROGRAMA.'?opcion=&idadmhosp='.$fila["id_adm_hosp"].'&servicio=Hospitalario&doc='.$fila["doc_pac"].'&sede='.$_REQUEST['sede'].'&bod=8"><button type="button" class="btn btn-danger "> CP-3</button></a></p>
														 </th>';
				                echo"</tr >\n";

				          }
				        }
				        ?>
				      </table>
				    </section>
				  </section>

				<?php
			}
			$sede=$_REQUEST['sede'];
			if ($sede==8) {
				?>

					<section class="panel-body col-xs-12 text-center">
						<div class="col-xs-12 text-center">
								<button data-toggle="collapse" class="btn btn-primary text-center col-xs-12" data-target="#uca">
									<article class="col-xs-2">
										<span class="fa fa-hospital-o fa-4x"></span>
									</article>
									<article class="col-xs-6">
										<hgroup>
											<h3>UCA</h3>
											<h4>Clínica Bogotá</h4>
										</hgroup>
									</article>
									<article class="col-xs-4">
										<dl><i><strong>PABELLONES</strong></i>
											<dd>UCA</dd>
										</dl>
									</article>
								</button>
						</div>
						<section id="uca" class="collapse">
							<table class="table table-bordered">
								<thead class="thead-inverse ">
									<tr>
										<th class="text-center danger">#</th>
				            <th class="text-center danger">PACIENTE</th>
				            <th class="text-center danger">UBICACION</th>
				            <th class="text-center danger"></th>
				          </tr>
								</thead>
									<?php
$sede=$_REQUEST['sede'];
									$sql="SELECT a.id_paciente,tdoc_pac,doc_pac,nom1,nom2,ape1,ape2,fotopac,
															 b.id_adm_hosp,
															 c.id_ubipaciente,
															 d.nom_cama,
															 e.nom_hab,
															 f.nom_pabellon,
															 g.nom_piso
											FROM pacientes a INNER JOIN adm_hospitalario b on (a.id_paciente=b.id_paciente)
																			 INNER JOIN ubipaciente c on b.id_adm_hosp=c.id_adm_hosp
																			 INNER JOIN cama d on d.id_cama=c.id_cama
																			 INNER JOIN habitacion e on e.id_habitacion=d.id_habitacion
																			 INNER JOIN pabellon f on f.id_pabellon=e.id_pabellon
																			 INNER JOIN piso g on g.id_piso=f.id_piso
											WHERE b.estado_adm_hosp='Activo' and g.id_piso='8' and c.ffinal is null";
											//echo $sql;
											$i=1;
								if ($tabla=$bd1->sub_tuplas($sql)){
									foreach ($tabla as $fila ) {

												echo"<tr >\n";
												echo'<td class="text-left">
															'.$i++.'
														 </td>';
												echo'<td class="text-center">
																<p>'.$fila["nom1"].' '.$fila["nom2"].' '.$fila["ape1"].' '.$fila["ape2"].'</p>
																<p><strong>'.$fila["tdoc_pac"].':</strong> '.$fila["doc_pac"].'</p>
														 </td>';
														 echo'<td class="text-center">
		 																<p><strong>Piso/Pabellon: </strong><br>'.$fila["nom_piso"].' '.$fila["nom_pabellon"].' '.$fila["nom_hab"].' '.$fila["nom_cama"].'</p>
		 																<figure class="text-center"><img src="'.$fila["fotopac"].'"alt ="foto" class="image_piso"></figure>
		 														 </td>';
												echo'<td class="text-center"><img src="'.$fila["fotopac"].'"alt ="foto" class="image_piso" > </td>';
												echo'<th class="text-left">
															<p><a href="'.PROGRAMA.'?opcion=155&idadmhosp='.$fila["id_adm_hosp"].'&servicio=Hospitalario&doc='.$fila["doc_pac"].'&sede='.$sede.'"><button type="button" class="btn btn-success" > Farmacia</button></a></p>
															<p><a href="'.PROGRAMA.'?opcion=171&idadmhosp='.$fila["id_adm_hosp"].'&servicio=Hospitalario&doc='.$fila["doc_pac"].'&sede='.$sede.'&bod=12"><button type="button" class="btn btn-warning" > Auxiliar</button></a></p>
															<p><a href="'.PROGRAMA.'?opcion=&idadmhosp='.$fila["id_adm_hosp"].'&servicio=Hospitalario&doc='.$fila["doc_pac"].'&sede='.$_REQUEST['sede'].'&bod=9"><button type="button" class="btn btn-danger "> CP-1</button></a>
																 <a href="'.PROGRAMA.'?opcion=&idadmhosp='.$fila["id_adm_hosp"].'&servicio=Hospitalario&doc='.$fila["doc_pac"].'&sede='.$_REQUEST['sede'].'&bod=10"><button type="button" class="btn btn-danger "> CP-2</button></a>
																 <a href="'.PROGRAMA.'?opcion=&idadmhosp='.$fila["id_adm_hosp"].'&servicio=Hospitalario&doc='.$fila["doc_pac"].'&sede='.$_REQUEST['sede'].'&bod=11"><button type="button" class="btn btn-danger "> CP-3</button></a></p>
														 </th>';
												echo"</tr >\n";

									}
								}
								?>
							</table>
						</section>
					</section>
					<section class="panel-body col-xs-12 text-center">
						<div class="col-xs-12 text-center">
								<button data-toggle="collapse" class="btn btn-primary text-center col-xs-12" data-target="#p1">
									<article class="col-xs-2">
										<span class="fa fa-hospital-o fa-4x"></span>
									</article>
									<article class="col-xs-6">
										<hgroup>
											<h3>PISO 1</h3>
											<h4>Clínica Bogotá</h4>
										</hgroup>
									</article>
									<article class="col-xs-4">
										<dl><i><strong>PABELLONES</strong></i>
											<dd>Intermedios</dd>
										</dl>
									</article>
								</button>
						</div>
						<section id="p1" class="collapse">
							<table class="table table-bordered">
								<thead class="thead-inverse ">
									<tr>
										<th class="text-center danger">#</th>
				            <th class="text-center danger">PACIENTE</th>
				            <th class="text-center danger">UBICACION</th>
				            <th class="text-center danger"></th>
				          </tr>
									<?php
$sede=$_REQUEST['sede'];
									$sql="SELECT a.id_paciente,tdoc_pac,doc_pac,nom1,nom2,ape1,ape2,fotopac,
															 b.id_adm_hosp,
															 c.id_ubipaciente,
															 d.nom_cama,
															 e.nom_hab,
															 f.nom_pabellon,
															 g.nom_piso
											FROM pacientes a INNER JOIN adm_hospitalario b on (a.id_paciente=b.id_paciente)
																			 INNER JOIN ubipaciente c on b.id_adm_hosp=c.id_adm_hosp
																			 INNER JOIN cama d on d.id_cama=c.id_cama
																			 INNER JOIN habitacion e on e.id_habitacion=d.id_habitacion
																			 INNER JOIN pabellon f on f.id_pabellon=e.id_pabellon
																			 INNER JOIN piso g on g.id_piso=f.id_piso
											WHERE b.estado_adm_hosp='Activo' and g.id_piso='5' and c.ffinal is null";
											//echo $sql;
											$i=1;
								if ($tabla=$bd1->sub_tuplas($sql)){
									foreach ($tabla as $fila ) {

												echo"<tr >\n";
												echo'<td class="text-center">'.$i++.'</td>';
												echo'<td class="text-center">
																<p>'.$fila["nom1"].' '.$fila["nom2"].' '.$fila["ape1"].' '.$fila["ape2"].'</p>
																<p><strong>'.$fila["tdoc_pac"].':</strong> '.$fila["doc_pac"].'</p>
														 </td>';
														 echo'<td class="text-center">
		 																<p><strong>Piso/Pabellon: </strong><br>'.$fila["nom_piso"].' '.$fila["nom_pabellon"].' '.$fila["nom_hab"].' '.$fila["nom_cama"].'</p>
		 																<figure class="text-center"><img src="'.$fila["fotopac"].'"alt ="foto" class="image_piso"></figure>
		 														 </td>';
												echo'<td class="text-center"><img src="'.$fila["fotopac"].'"alt ="foto" class="image_piso"> </td>';
												echo'<th class="text-left">
															<p><a href="'.PROGRAMA.'?opcion=155&idadmhosp='.$fila["id_adm_hosp"].'&servicio=Hospitalario&doc='.$fila["doc_pac"].'&sede='.$sede.'"><button type="button" class="btn btn-success" > Farmacia</button></a></p>
															<p><a href="'.PROGRAMA.'?opcion=171&idadmhosp='.$fila["id_adm_hosp"].'&servicio=Hospitalario&doc='.$fila["doc_pac"].'&sede='.$sede.'&bod=12"><button type="button" class="btn btn-warning" > Auxiliar</button></a></p>
															<p><a href="'.PROGRAMA.'?opcion=&idadmhosp='.$fila["id_adm_hosp"].'&servicio=Hospitalario&doc='.$fila["doc_pac"].'&sede='.$_REQUEST['sede'].'&bod=9"><button type="button" class="btn btn-danger "> CP-1</button></a>
																 <a href="'.PROGRAMA.'?opcion=&idadmhosp='.$fila["id_adm_hosp"].'&servicio=Hospitalario&doc='.$fila["doc_pac"].'&sede='.$_REQUEST['sede'].'&bod=10"><button type="button" class="btn btn-danger "> CP-2</button></a>
																 <a href="'.PROGRAMA.'?opcion=&idadmhosp='.$fila["id_adm_hosp"].'&servicio=Hospitalario&doc='.$fila["doc_pac"].'&sede='.$_REQUEST['sede'].'&bod=11"><button type="button" class="btn btn-danger "> CP-3</button></a></p>
														 </th>';
												echo"</tr >\n";

									}
								}
								?>
							</table>
						</section>
					</section>
					<section class="panel-body col-xs-12 text-center">
						<div class="col-xs-12 text-center">
								<button data-toggle="collapse" class="btn btn-primary text-center col-xs-12" data-target="#p2">
									<article class="col-xs-2">
										<span class="fa fa-hospital-o fa-4x"></span>
									</article>
									<article class="col-xs-6">
										<hgroup>
											<h3>PISO 2</h3>
											<h4>Clínica Bogotá</h4>
										</hgroup>
									</article>
									<article class="col-xs-4">
										<dl><i><strong>PABELLONES</strong></i>
											<dd>Niños y adolescentes</dd>
										</dl>
									</article>
								</button>
						</div>
						<section id="p2" class="collapse">
							<table class="table table-bordered">
								<thead class="thead-inverse ">
									<tr>
										<th class="text-center danger">#</th>
				            <th class="text-center danger">PACIENTE</th>
				            <th class="text-center danger">UBICACION</th>
				            <th class="text-center danger"></th>
				          </tr>
								</thead>
									<?php
									$sede=$_REQUEST['sede'];
									$sql="SELECT a.id_paciente,tdoc_pac,doc_pac,nom1,nom2,ape1,ape2,fotopac,
															 b.id_adm_hosp,
															 c.id_ubipaciente,
															 d.nom_cama,
															 e.nom_hab,
															 f.nom_pabellon,
															 g.nom_piso
											FROM pacientes a INNER JOIN adm_hospitalario b on (a.id_paciente=b.id_paciente)
																			 INNER JOIN ubipaciente c on b.id_adm_hosp=c.id_adm_hosp
																			 INNER JOIN cama d on d.id_cama=c.id_cama
																			 INNER JOIN habitacion e on e.id_habitacion=d.id_habitacion
																			 INNER JOIN pabellon f on f.id_pabellon=e.id_pabellon
																			 INNER JOIN piso g on g.id_piso=f.id_piso
											WHERE b.estado_adm_hosp='Activo' and g.id_piso='6' and c.ffinal is null";
											//echo $sql;
											$i=1;
								if ($tabla=$bd1->sub_tuplas($sql)){
									foreach ($tabla as $fila ) {

												echo"<tr >\n";
												echo'<td class="text-center">'.$i++.'</td>';
												echo'<td class="text-center">
																<p>'.$fila["nom1"].' '.$fila["nom2"].' '.$fila["ape1"].' '.$fila["ape2"].'</p>
																<p><strong>'.$fila["tdoc_pac"].':</strong> '.$fila["doc_pac"].'</p>
														 </td>';
														 echo'<td class="text-center">
		 																<p><strong>Piso/Pabellon: </strong><br>'.$fila["nom_piso"].' '.$fila["nom_pabellon"].' '.$fila["nom_hab"].' '.$fila["nom_cama"].'</p>
		 																<figure class="text-center"><img src="'.$fila["fotopac"].'"alt ="foto" class="image_piso"></figure>
		 														 </td>';
												echo'<td class="text-center"><img src="'.$fila["fotopac"].'"alt ="foto" class="image_piso"> </td>';
												echo'<th class="text-left">
															<p><a href="'.PROGRAMA.'?opcion=155&idadmhosp='.$fila["id_adm_hosp"].'&servicio=Hospitalario&doc='.$fila["doc_pac"].'&sede='.$sede.'"><button type="button" class="btn btn-success" > Farmacia</button></a></p>
															<p><a href="'.PROGRAMA.'?opcion=171&idadmhosp='.$fila["id_adm_hosp"].'&servicio=Hospitalario&doc='.$fila["doc_pac"].'&sede='.$sede.'&bod=12"><button type="button" class="btn btn-warning" > Auxiliar</button></a></p>
															<p><a href="'.PROGRAMA.'?opcion=&idadmhosp='.$fila["id_adm_hosp"].'&servicio=Hospitalario&doc='.$fila["doc_pac"].'&sede='.$_REQUEST['sede'].'&bod=9"><button type="button" class="btn btn-danger "> CP-1</button></a>
																 <a href="'.PROGRAMA.'?opcion=&idadmhosp='.$fila["id_adm_hosp"].'&servicio=Hospitalario&doc='.$fila["doc_pac"].'&sede='.$_REQUEST['sede'].'&bod=10"><button type="button" class="btn btn-danger "> CP-2</button></a>
																 <a href="'.PROGRAMA.'?opcion=&idadmhosp='.$fila["id_adm_hosp"].'&servicio=Hospitalario&doc='.$fila["doc_pac"].'&sede='.$_REQUEST['sede'].'&bod=11"><button type="button" class="btn btn-danger "> CP-3</button></a></p>
														 </th>';
												echo"</tr >\n";

									}
								}
								?>
							</table>
						</section>
					</section>
					<section class="panel-body col-xs-12 text-center">
						<div class="col-xs-12 text-center">
								<button data-toggle="collapse" class="btn btn-primary text-center col-xs-12" data-target="#p3">
									<article class="col-xs-2">
										<span class="fa fa-hospital-o fa-4x"></span>
									</article>
									<article class="col-xs-6">
										<hgroup>
											<h3>PISO 3</h3>
											<h4>Clínica Bogotá</h4>
										</hgroup>
									</article>
									<article class="col-xs-4">
										<dl><i><strong>PABELLONES</strong></i>
											<dd>Adultos</dd>
										</dl>
									</article>
								</button>
						</div>
						<section id="p3" class="collapse">
							<table class="table table-bordered">
								<thead class="thead-inverse ">
									<tr>
										<th class="text-center danger">#</th>
				            <th class="text-center danger">PACIENTE</th>
				            <th class="text-center danger">UBICACION</th>
				            <th class="text-center danger"></th>
				          </tr>
								</thead>
									<?php
									$sede=$_REQUEST['sede'];
									$sql="SELECT a.id_paciente,tdoc_pac,doc_pac,nom1,nom2,ape1,ape2,fotopac,
															 b.id_adm_hosp,
															 c.id_ubipaciente,
															 d.nom_cama,
															 e.nom_hab,
															 f.nom_pabellon,
															 g.nom_piso
											FROM pacientes a INNER JOIN adm_hospitalario b on (a.id_paciente=b.id_paciente)
																			 INNER JOIN ubipaciente c on b.id_adm_hosp=c.id_adm_hosp
																			 INNER JOIN cama d on d.id_cama=c.id_cama
																			 INNER JOIN habitacion e on e.id_habitacion=d.id_habitacion
																			 INNER JOIN pabellon f on f.id_pabellon=e.id_pabellon
																			 INNER JOIN piso g on g.id_piso=f.id_piso
											WHERE b.estado_adm_hosp='Activo' and g.id_piso='7' and c.ffinal is null";
											//echo $sql;
											$i=1;
								if ($tabla=$bd1->sub_tuplas($sql)){
									foreach ($tabla as $fila ) {

												echo"<tr >\n";
												echo'<td class="text-left">
															'.$i++.'
														 </td>';
												$sede=$_REQUEST['sede'];
												echo'<td class="text-center">'.$i++.'</td>';
												echo'<td class="text-center">
																<p>'.$fila["nom1"].' '.$fila["nom2"].' '.$fila["ape1"].' '.$fila["ape2"].'</p>
																<p><strong>'.$fila["tdoc_pac"].':</strong> '.$fila["doc_pac"].'</p>
														 </td>';
														 echo'<td class="text-center">
		 																<p><strong>Piso/Pabellon: </strong><br>'.$fila["nom_piso"].' '.$fila["nom_pabellon"].' '.$fila["nom_hab"].' '.$fila["nom_cama"].'</p>
		 																<figure class="text-center"><img src="'.$fila["fotopac"].'"alt ="foto" class="image_piso"></figure>
		 														 </td>';
												echo'<td class="text-center"><img src="'.$fila["fotopac"].'"alt ="foto" class="image_piso"> </td>';
												echo'<th class="text-left">
															<p><a href="'.PROGRAMA.'?opcion=155&idadmhosp='.$fila["id_adm_hosp"].'&servicio=Hospitalario&doc='.$fila["doc_pac"].'&sede='.$sede.'"><button type="button" class="btn btn-success" > Farmacia</button></a></p>
															<p><a href="'.PROGRAMA.'?opcion=171&idadmhosp='.$fila["id_adm_hosp"].'&servicio=Hospitalario&doc='.$fila["doc_pac"].'&sede='.$sede.'&bod=12"><button type="button" class="btn btn-warning" > Auxiliar</button></a></p>
															<p><a href="'.PROGRAMA.'?opcion=&idadmhosp='.$fila["id_adm_hosp"].'&servicio=Hospitalario&doc='.$fila["doc_pac"].'&sede='.$_REQUEST['sede'].'&bod=9"><button type="button" class="btn btn-danger "> CP-1</button></a>
																 <a href="'.PROGRAMA.'?opcion=&idadmhosp='.$fila["id_adm_hosp"].'&servicio=Hospitalario&doc='.$fila["doc_pac"].'&sede='.$_REQUEST['sede'].'&bod=10"><button type="button" class="btn btn-danger "> CP-2</button></a>
																 <a href="'.PROGRAMA.'?opcion=&idadmhosp='.$fila["id_adm_hosp"].'&servicio=Hospitalario&doc='.$fila["doc_pac"].'&sede='.$_REQUEST['sede'].'&bod=11"><button type="button" class="btn btn-danger "> CP-3</button></a></p>
														 </th>';
												echo"</tr >\n";

									}
								}
								?>
							</table>
						</section>
					</section>

				<?php
			}
			?>
	</section>
</section>
	<?php
}
?>
