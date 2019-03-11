<form action="<?php echo PROGRAMA.'?opcion=31&idadm='.$idadm.'&servicio='.$servicio.'&doc='.$doc;?>" method="POST" enctype="multipart/form-data" onsubmit="return validar()" role="form" class="form-horizontal">
  <section class="panel panel-default">
  	<section class="panel-heading">
  		<h3><?php echo $subtitulo; ?></h3>
  	</section>
  	<section class="panel-body">
      <article class="col-xs-3">
        <label for=""># autorización:</label>
        <input type="text" class="form-control" name="num_autori" value="<?php echo $fila['num_autori']?>">
        <input type="hidden" class="form-control" name="id_m_autori" value="<?php echo $fila['id_m_autori']?>">
  		</article>
      <article class="col-xs-5">
        <label for="">Tipo numero autorización:</label>
        <select class="form-control" required="" name="tipo_num_autori">
          <option class="text-primary" value="<?php echo $fila['tipo_num_autori']; ?>"><?php echo $fila['tipo_num_autori']; ?></option>
          <option value="PROPIO">PROPIO</option>
          <option value="EPS">EPS</option>
        </select>
  		</article>
  	</section>
    <?php include('dxindv.php') ?>
  	<section class="col-xs-12">
  		<input type="submit" class="btn btn-primary btn-lg" name="aceptar" Value="<?php echo $boton; ?>" />
  	  <input type="hidden" class="btn btn-primary" name="opcion" Value="<?php echo $_GET["opcion"];?>"/>
  	  <input type="hidden" class="btn btn-primary" name="operacion" Value="<?php echo $_GET["mante"];?>"/>
  	</section>
  </section>
</form>
