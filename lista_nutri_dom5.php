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
				$sql="INSERT INTO val_nutri_dom (id_adm_hosp, id_user, freg_nutri, hreg_nutri, motivo_nutri, val_nutricional, dx_nutricional, plan_nutricional, estado_nutri) VALUES
				('".$_POST["idadmhosp"]."',
'".$_SESSION["AUT"]["id_user"]."',
'".$_POST["freg_nutri"]."'	,
'".$_POST["hreg_nutri"]."'	,
'".$_POST["motivonutri"]."',
'".$_POST["val_nutri"]."',
'".$_POST["dxnutri"]."',
'".$_POST["plan_nutri"]."','Realizada'
)";
				$subtitulo="Valoración inicial";
				$subtitulo1="Adicionado";
				$subtitulo2="Nutrición";
			break;
			case 'EVO':
				$horaInicial=$_POST["hregevo"];
				$horat= strtotime ( '+40 minute' , strtotime ( $horaInicial ) ) ;
				$ht=date('H:i',$horat);
				$sql="INSERT INTO evo_nutri_dom (id_adm_hosp, id_user, freg_nutrice_sm, hreg_nutrice_sm, hfin_nutri_dom,evolucion_nutri, estado_evonutri) VALUES
				('".$_POST["idadmhosp"]."','".$_SESSION["AUT"]["id_user"]."','".$_POST["freg"]."','".$_POST["hregevo"]."','$ht','".$_POST["evoto"]."','Realizada')";
				$subtitulo="Evolución";
				$subtitulo1="Adicionado";
				$subtitulo2="Nutrición y Dietética";

			break;

		}
	//echo $sql;
		if ($bd1->consulta($sql)){
			$subtitulo="El formato de $subtitulo en $subtitulo2 fue $subtitulo1 con exito!";
			$check='si';
			if($_POST["operacion"]=="X"){
			if(is_file($fila["logo"])){
				unlink($fila["logo"]);
			}
			}
		}else{
			$subtitulo="El formato de $subtitulo en $subtitulo2 NO fue $subtitulo1 !!! .";
			$check='no';
		}
	}
}

if (isset($_GET["mante"])){					///nivel 2
	switch ($_GET["mante"]) {
		case 'VI':
    $sql="SELECT a.tdoc_pac,a.doc_pac,nom1,nom2,ape1,ape2,edad,fnacimiento,dir_pac,tel_pac,rh,email_pac,genero,lateralidad,religion,fotopac,
    b.id_adm_hosp,fingreso_hosp,hingreso_hosp,fegreso_hosp,hegreso_hosp,
    j.nom_eps
    from pacientes a left join adm_hospitalario b on a.id_paciente=b.id_paciente
                left join eps j on (j.id_eps=b.id_eps)
    where b.id_adm_hosp ='".$_GET["idadmhosp"]."'" ;
			$boton="Agregar Valoración";
			$atributo1=' readonly="readonly"';
			$atributo2='';
			$atributo3='';
			$date=date('Y-m-d');
			$date1=date('H:i');
			$form1='formulariosHOSP/NUTRICION/valini_nutri.php';
			$subtitulo='Valoracion inicial  Nutrición';
			break;
			case 'EVO':
      $sql="SELECT a.tdoc_pac,a.doc_pac,nom1,nom2,ape1,ape2,edad,fnacimiento,dir_pac,tel_pac,rh,email_pac,genero,lateralidad,religion,fotopac,
      b.id_adm_hosp,fingreso_hosp,hingreso_hosp,fegreso_hosp,hegreso_hosp,
      j.nom_eps
      from pacientes a left join adm_hospitalario b on a.id_paciente=b.id_paciente
                  left join eps j on (j.id_eps=b.id_eps)
      where b.id_adm_hosp ='".$_GET["idadmhosp"]."'" ;
			$boton="Agregar Evolución";
			$atributo1=' readonly="readonly"';
			$atributo2='';
			$atributo3='';
			$date=date('Y-m-d');
			$date1=date('H:i');
			$form1='formulariosHOSP/NUTRICION/evo_nutri_dom.php';
			$subtitulo='Evolución Diaria  Nutrición';
			break;

		}
//echo $sql;
		if($sql!=""){
			if (!$fila=$bd1->sub_fila($sql)){
				$fila=array("tdoc_pac"=>"","doc_pac"=>"","nom1"=>"","nom2"=>"","ape1"=>"","ape2"=>"","edad"=>"","fnacimiento"=>"","dir_pac"=>"","tel_pac"=>"","rh"=>"","email_pac"=>"","genero"=>"","lateralidad"=>"","religion"=>"","fotopac"=>"","id_adm_hosp"=>"","fingreso_hosp"=>"","hingreso_hosp"=>"","fegreso_hosp"=>"","hegreso_hosp"=>"", "nom_eps"=>"");
			}
		}else{
				$fila=array("tdoc_pac"=>"","doc_pac"=>"","nom1"=>"","nom2"=>"","ape1"=>"","ape2"=>"","edad"=>"","fnacimiento"=>"","dir_pac"=>"","tel_pac"=>"","rh"=>"","email_pac"=>"","genero"=>"","lateralidad"=>"","religion"=>"","fotopac"=>"","id_adm_hosp"=>"","fingreso_hosp"=>"","hingreso_hosp"=>"","fegreso_hosp"=>"","hegreso_hosp"=>"", "nom_eps"=>"");
			}

		?>
<script src = "js/sha3.js"></script>
		<script>
			function validar(){
				if (document.forms[0].hreg.value > document.forms[0].fecha.value){
					alert("Nutricionista <?php echo $_SESSION["AUT"]["nombre"]?>, NO puede adelantar el tiempo.");
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
<div class="panel-default">
<div class="panel-body">

	<section class="panel panel-default" class="col-xs-7">
		<form class="navbar-form navbar-center" role="search" >
        	<section class="form-group col-xs-3">
          		<input type="text" class="form-control" name="doc" placeholder="Digite Identificacion">
        	</section>
        	<input type="submit" name="buscar" class="btn btn-primary" value="Consultar">
        	<input type="hidden" name="opcion" Value="<?php echo $_GET["opcion"];?>"/>
    </form>
		<form class="navbar-form navbar-center" role="search">
					<section class="form-group col-xs-3">
							<input type="text" class="form-control" name="nom" placeholder="Digite Nombre paciente">
					</section>
					<input type="submit" name="buscar" class="btn btn-primary" value="Consultar">
					<input type="hidden" name="opcion" Value="<?php echo $_GET["opcion"];?>"/>
		</form>
	</section>
<table class="table table-bordered">
	<tr>
		<th id="th-estilo1">ADMISION</th>
		<th id="th-estilo1">IDENTIFICACION</th>
		<th id="th-estilo2">NOMBRES Y APELLIDOS</th>
		<th id="th-estilo3">FECHA INGRESO</th>
		<th id="th-estilo3">FOTO</th>
		<th id="th-estilo4">Valoracion Inicial</th>
		<th id="th-estilo4">Evolucion</th>
	</tr>

	<?php
	if (isset($_REQUEST["doc"])){
	$doc=$_REQUEST["doc"];
	$sql="SELECT p.id_paciente,tdoc_pac,doc_pac,nom1,nom2,ape1,ape2,fotopac,
							 a.id_adm_hosp,fingreso_hosp,hingreso_hosp,
							 s.nom_sedes
				FROM pacientes p LEFT JOIN adm_hospitalario a on p.id_paciente=a.id_paciente
				 								 LEFT JOIN sedes_ips s on a.id_sedes_ips=s.id_sedes_ips  
				WHERE p.doc_pac='".$doc."' and a.estado_adm_hosp='Activo' and tipo_servicio='Domiciliarios'";

	if ($tabla=$bd1->sub_tuplas($sql)){
		//echo $sql;
		foreach ($tabla as $fila ) {

			echo"<tr >\n";
			echo'<td class="text-center">'.$fila["id_adm_hosp"].'</td>';
			echo'<td class="text-center">'.$fila["doc_pac"].'</td>';
			echo'<td class="text-center">'.$fila["nom1"].' '.$fila["nom2"].' '.$fila["ape1"].' '.$fila["ape2"].'</td>';
			echo'<td class="text-center">'.$fila["fingreso_hosp"].' | '.$fila["hingreso_hosp"].'</td>';
			echo'<td class="text-center"><img src="'.$fila["fotopac"].'"alt ="foto" class="image_login cursor1" data-toggle="modal" data-target="#modalpac"> </td>';
			echo'<th class="text-center"><a href="'.PROGRAMA.'?opcion='.$_REQUEST["opcion"].'&mante=VI&idadmhosp='.$fila["id_adm_hosp"].'"><button type="button" class="btn btn-warning sombra_movil" ><span class="fa fa-plus-circle"></span></button></a></th>';
			echo'<th class="text-center"><a href="'.PROGRAMA.'?opcion='.$_REQUEST["opcion"].'&mante=EVO&idadmhosp='.$fila["id_adm_hosp"].'"><button type="button" class="btn btn-danger sombra_movil" ><span class="fa fa-plus-circle"></span></button></a></th>';
			echo "</tr>\n";
		}
	}
}	if (isset($_REQUEST["nom"])){
	$doc=$_REQUEST["nom"];
	$sql="SELECT p.id_paciente,tdoc_pac,doc_pac,nom1,nom2,ape1,ape2,fotopac,a.id_adm_hosp,fingreso_hosp,hingreso_hosp,s.nom_sedes FROM pacientes p LEFT JOIN adm_hospitalario a on p.id_paciente=a.id_paciente LEFT JOIN sedes_ips s on a.id_sedes_ips=s.id_sedes_ips  WHERE p.nom1 LIKE '%".$doc."%' and a.estado_adm_hosp='Activo'  and tipo_servicio='Domiciliarios'";

	if ($tabla=$bd1->sub_tuplas($sql)){
		//echo $sql;
		foreach ($tabla as $fila ) {

			echo"<tr >\n";
			echo'<td class="text-center">'.$fila["id_adm_hosp"].'</td>';
			echo'<td class="text-center">'.$fila["doc_pac"].'</td>';
			echo'<td class="text-center">'.$fila["nom1"].' '.$fila["nom2"].' '.$fila["ape1"].' '.$fila["ape2"].'</td>';
			echo'<td class="text-center">'.$fila["fingreso_hosp"].' | '.$fila["hingreso_hosp"].'</td>';
			echo'<td class="text-center"><img src="'.$fila["fotopac"].'"alt ="foto" class="image_login cursor1" data-toggle="modal" data-target="#modalpac"> </td>';
      echo'<th class="text-center"><a href="'.PROGRAMA.'?opcion='.$_REQUEST["opcion"].'&mante=VI&idadmhosp='.$fila["id_adm_hosp"].'"><button type="button" class="btn btn-warning sombra_movil" ><span class="fa fa-plus-circle"></span></button></a></th>';
      echo'<th class="text-center"><a href="'.PROGRAMA.'?opcion='.$_REQUEST["opcion"].'&mante=EVO&idadmhosp='.$fila["id_adm_hosp"].'"><button type="button" class="btn btn-danger sombra_movil" ><span class="fa fa-plus-circle"></span></button></a></th>';
			echo "</tr>\n";
		}
	}
}
	?>

</table>

</div>
</div>
	<?php
}
?>
