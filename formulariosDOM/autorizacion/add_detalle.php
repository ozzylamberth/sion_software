<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type="text/javascript">
$(function() {
          $("#codigo").autocomplete({
              source: "configuraciones/bus_cups_dom.php",
              minLength: 2,
              select: function(event, ui) {
        event.preventDefault();
                  $('#codigo').val(ui.item.codigo);
        $('#descripcion').val(ui.item.descripcion);
         }
          });
  });
</script>
<script src = "js/sha3.js"></script>
		<script>
			function validar(){
				if (document.forms[0].ffinal.value < document.forms[0].finicio.value){
					alert("HEYYYYY !!!!! <?php echo $_SESSION["AUT"]["nombre"]?>, La fecha final no puede ser menor a la inicial.");
					document.forms[0].ffinal.focus();				// Ubicar el cursor
					return(false);
				}
			}
		</script>
<form action="<?php echo PROGRAMA.'?doc='.$doc.'&servicio='.$servicio.'&buscar=Buscar&opcion='.$opcion;?>" method="POST" enctype="multipart/form-data" onsubmit="return validar()" role="form" class="form-horizontal">
  <section class="panel panel-default">
    <section class="panel-heading">
     <h2><?php echo $subtitulo; ?></h2>
    </section>
    <section class="panel-body">
      <article class="col-md-4">
        <label for="">CUPS</label> <label for="" class="text-danger"><span class="fa fa-info-circle"></span> Recuerde que debe seleccionar el procedimiento del listado sugerido</label>
        <input type="hidden" name="idm" value="<?php echo $_REQUEST['idm'] ?>">
        <input type="text" name="cups" class="form-control" value="" id="codigo" required="">
      </article>
      <article class="col-md-8">
        <label for="">Procedimiento</label>
        <input type="text" name="procedimiento" class="form-control" value="" id="descripcion" required="">
      </article>
    </section>
    <section class="panel-body">
      <article class="col-md-3">
        <label for="">Cantidad</label>
        <input type="number" name="cantidad" class="form-control" value="" required="" min="1" max="65">
      </article>
      <article class="col-md-3">
        <label for="">Intervalo</label>
        <select class="form-control" name="intervalo">
          <option value=""></option>
          <option value="40">40 minutos</option>
          <option value="60">60 minutos</option>
          <option value="3">3 horas</option>
          <option value="6">6 horas</option>
          <option value="8">8 horas</option>
          <option value="12">12 horas</option>
          <option value="24">24 horas</option>
        </select>
      </article>
      <article class="col-md-3">
        <label for="">Succión?</label>
        <select class="form-control" name="succion" required="">
          <option value="N">NO</option>
          <option value="S">SI</option>
        </select>
      </article>
      <article class="col-md-3">
        <label for="">Temporalidad</label>
        <select class="form-control" name="temporalidad" required="">
          <option value="NA">NO APLICA</option>
          <option value="L-V">L-V</option>
          <option value="L-S">L-S</option>
          <option value="D-D">D-D</option>
        </select>
      </article>
      <article class="col-md-6">
        <label for="">Fecha Inial</label>
        <input type="date" class="form-control" name="finicio" value="">
      </article>
      <article class="col-md-6">
        <label for="">Fecha Final</label>
        <input type="date" class="form-control" name="ffinal" value="">
      </article>
    </section>
    <section class="panel-Body">
      <div class="row text-center">
        <input type="submit" class="btn btn-primary btn-lg" name="aceptar" Value="<?php echo $boton; ?>" />
        <input type="hidden" class="btn btn-primary" name="opcion" Value="<?php echo $_GET["opcion"];?>"/>
        <input type="hidden" class="btn btn-primary" name="operacion" Value="<?php echo $_GET["mante"];?>"/>
      </div>
    </section>
  </section>
</form>
