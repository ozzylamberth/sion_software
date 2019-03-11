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
<section class="panel panel-default">
	<section class="panel-heading"><h4>Evolución terapia ocupacional en servicios domiciliarios</h4></section>
	<form action="<?php echo PROGRAMA.'?doc='.$doc.'&buscar=Consultar&opcion=64';?>" method="POST" enctype="multipart/form-data" onsubmit="return validar()" role="form" class="form-horizontal">
		<section class="panel-body">
		  <?php
		    include("consulta_paciente.php");
		  ?>
			<br>
			<?php include("consulta_rapidaDOM.php");?>
		<section class="panel-body">
			<section class="col-xs-12">
				<article class="col-xs-4">
					<label for="">Fecha de registro:</label>
					<input type="date" name="freg" value="<?php echo $date ;?>" class="form-control" <?php echo $atributo2;?>>
					<input type="hidden" name="fecha1" value="<?php echo $date;?>">
					<input type="hidden" name="fregreg" value="<?php echo date('Y-m-d H:m:s') ;?>" class="form-control" <?php echo $atributo2;?>>
					<input type="hidden" name="idadmhosp" value="<?php echo $fila['id_adm_hosp'];?>">
					<input type="hidden" name="idd" value="<?php echo $_GET['idd'];?>">
				</article>
				<article class="col-xs-4">
					<label for="">Hora de Evolucion</label>
					<<input type="time" required name="hregevo" value="" class="form-control">
					<input type="hidden" name="hreg" value="<?php echo $date1 ;?>" class="form-control">
				</article>
				<article class="col-xs-12">
					<label for="">Evolucion Terapia Ocupacional:</label>
					<button type="button" class="fa fa-plus btn-danger"  onclick="verTexto18()" ></button>
					<textarea class="form-control" name="evoto" rows="10" id="respuesta18" required ></textarea>
				</article>
			</section>

		</section>
		<div class="row text-center">
		  <input type="submit" class="btn btn-primary" name="aceptar" Value="<?php echo $boton; ?>" />
			<input type="hidden" class="btn btn-primary" name="opcion" Value="<?php echo $_GET["opcion"];?>"/>
			<input type="hidden" class="btn btn-primary" name="operacion" Value="<?php echo $_GET["mante"];?>"/>
		</div>
	</section>
</form>

</section>
