<script src = "js_p/sha3.js"></script>
		<script>
			function validar(){

				if (document.forms[0].freg.value > document.forms[0].fecha1.value){
					alert("Apreciado Terapeuta <?php echo $_SESSION["AUT"]["nombre"]?>, no no no, NO puede adelantar las fechas.");
					document.forms[0].freg.focus();				// Ubicar el cursor
					return(false);
				}
			}
		</script>
<form action="<?php echo PROGRAMA.'?doc='.$doc.'&buscar=Consultar&opcion=62';?>" method="POST" enctype="multipart/form-data" onsubmit="return validar()" role="form" class="form-horizontal">
	<section class="panel-body">
	  <?php
	    include("consulta_paciente.php");
	  ?>
	</section>
	<article>
		<h4 id="th-estilot">Evoluciones Fisioterapia Domiciliarios</h4>
<?php include("consulta_rapidaDOM.php");?>

	<section class="panel-body"> <!--evolucion to-->
			<article class="col-xs-3">
				<label for="">Fecha de registro:</label>
				<input type="date" name="freg" value="<?php echo $date ;?>" class="form-control" <?php echo $atributo2;?>>
				<input type="hidden" name="fecha1" value="<?php echo $date;?>">
				<input type="hidden" name="fregreg" value="<?php echo date('Y-m-d H:m:s') ;?>" class="form-control" <?php echo $atributo2;?>>
				<input type="hidden" name="idadmhosp" value="<?php echo $fila['id_adm_hosp'];?>">
				<input type="hidden" name="idd" value="<?php echo $_GET['idd'];?>">
			</article>
			<article class="col-xs-3">
				<label for="">Hora de Evolucion</label>
				<input type="time" required name="hregevo" value="" class="form-control">
				<input type="hidden" name="hreg" value="<?php echo $date1 ;?>" class="form-control">
			</article>
			<article class="col-xs-10">
				<label for="">Evolucion Fisioterapia:</label>
				<button type="button" class="fa fa-plus btn-danger"  onclick="verTexto18()" ></button>
<textarea class="form-control" name="evoto" rows="15" id="respuesta18" required ></textarea>
			</article>
		</section>
	<div class="row text-center">
	  <input type="submit" class="btn btn-primary" name="aceptar" Value="<?php echo $boton; ?>" />
		<input type="hidden" class="btn btn-primary" name="opcion" Value="<?php echo $_GET["opcion"];?>"/>
		<input type="hidden" class="btn btn-primary" name="operacion" Value="<?php echo $_GET["mante"];?>"/>
	</div>
  </section>
</form>
