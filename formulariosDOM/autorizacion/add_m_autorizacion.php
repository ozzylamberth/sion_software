<form action="<?php echo PROGRAMA.'?doc='.$doc.'&servicio='.$servicio.'&buscar=Buscar&opcion='.$opcion;?>" method="POST" enctype="multipart/form-data" onsubmit="return validar()" role="form" class="form-horizontal">
  <section class="panel panel-default">
    <section class="panel-heading">
     <h2><?php echo $subtitulo; ?></h2>
    </section>
    <section class="panel-body alert alert-info">
      <?php
      $idadm=$_REQUEST['idadm'];
      $sql="SELECT a.tdoc_pac,doc_pac,nom1,nom2,ape1,ape2,
                   b.fingreso_hosp,id_eps
            FROM pacientes a INNER JOIN adm_hospitalario b on a.id_paciente=b.id_paciente
            WHERE id_adm_hosp=$idadm";
      if($tabla=$bd1->sub_tuplas($sql)){
        foreach ($tabla as $fila2) {
          echo'<article class="col-md-4"><h2><strong>Paciente:</strong><br>'.$fila2['nom1'].' '.$fila2['nom2'].' '.$fila2['ape1'].' '.$fila2['ape2'].'</h2></article>
               <article class="col-md-4"><h3><strong>'.$fila2['tdoc_pac'].': </strong>'.$fila2['doc_pac'].'</h3></article>
               <article class="col-md-4"><h3><strong>Ingreso: </strong>'.$fila2['fingreso_hosp'].'</h3></article>';
        }
      }
       ?>
    </section>
    <section class="row panel-body">
      <section class="col-md-9">
        <section class="row">
          <article class="col-sm-3">
            <label for="">Tipo paciente:</label>
            <input type="hidden" name="idadm" value="<?php echo $_REQUEST['idadm']?>">
            <select name="tipo_paciente" class="form-control" <?php echo atributo3; ?> required="">
              <option value=""></option>
              <?php
              $sql="SELECT id_cusuario,nomclaseusuario from clase_usuario ORDER BY id_cusuario ASC";
              if($tabla=$bd1->sub_tuplas($sql)){
                foreach ($tabla as $fila2) {
                  if ($fila["id_cusuario"]==$fila2["id_cusuario"]){
                    $sw=' selected="selected"';
                  }else{
                    $sw="";
                  }
                echo '<option value="'.$fila2["id_cusuario"].'"'.$sw.'>'.$fila2["nomclaseusuario"].'</option>';
                }
              }
              ?>
            </select>
          </article>
          <article class="col-sm-3">
            <label for="">Zona Paciente:</label>
            <select name="zona_paciente" class="form-control" <?php echo atributo3; ?> required="">
              <option value=""></option>
              <option value="ZonaIn">Zona In</option>
              <option value="Compartido">Compartido</option>
              <option value="Evento">Evento</option>
              <option value="Ninguna">Ninguna</option>
            </select>
          </article>
          <article class="col-sm-3">
            <label for="">IPS Ordena:</label>
            <select name="ips_ordena" class="form-control" <?php echo atributo3; ?> required="">
              <option value=""></option>
              <?php
              $sql="SELECT id_ips_externa,nom_ips_externa from ips_externa ORDER BY id_ips_externa ASC";
              if($tabla=$bd1->sub_tuplas($sql)){
                foreach ($tabla as $fila2) {
                  if ($fila["id_ips_externa"]==$fila2["id_ips_externa"]){
                    $sw=' selected="selected"';
                  }else{
                    $sw="";
                  }
                echo '<option value="'.$fila2["id_ips_externa"].'"'.$sw.'>'.$fila2["nom_ips_externa"].'</option>';
                }
              }
              ?>
            </select>
          </article>
          <article class="col-sm-4">
            <label for="">Medico Ordena:</label>
            <input type="text" class="form-control" required name="medico_ordena" value="">
          </article>
        </section>
      </section>
      <section class="col-md-3">
        <input type="submit" class="btn btn-primary btn-lg" name="aceptar" Value="<?php echo $boton; ?>" /><br>
        <input type="hidden" class="btn btn-primary" name="opcion" Value="<?php echo $_GET["opcion"];?>"/>
        <input type="hidden" class="btn btn-primary" name="operacion" Value="<?php echo $_GET["mante"];?>"/>
      </section>
      <section class="panel-body">
        <article class="col-sm-12">
         <?php include('dxindv.php');?>
       </article>
      </section>
    </section>
  </section>
</form>
