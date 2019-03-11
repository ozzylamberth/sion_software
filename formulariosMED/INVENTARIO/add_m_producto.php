<?php
$cat=$_REQUEST['CAT'];
if ($cat==1) {
  ?>
  <form action="<?php echo PROGRAMA.'?opcion=97';?>" method="POST" enctype="multipart/form-data" onsubmit="return validar()" role="form" class="form-horizontal">
    <section class="panel panel-default">
      <section class="panel-heading"><h4><?php echo $subtitulo ?></h4></section>
      <section class="panel-body"><!-- Información del m_producto -->
        <article class="col-xs-12 animated flipInY alert alert-danger">
          <ul> <strong> <span class="fa fa-info-circle"></span> RECUERDE: El medicamento principal que va a registrar debe poseer las siguientes características:</strong>
            <li>El nombre del medicamento principal consta de : principio activo + concentración + forma farmacéutica. <i>Ejemplo:</i> "ACETAMINOFEN 500MG TABLETA"</li>
            <li>El nombre del medicamento principal no puede repetirse es único. Por lo tanto el software no le permitirá guardar un registro repetido.</li>
            <li>Tenga cuenta que los productos detallados que se anidan a este medicamento principal contienen toda la información</li>
          </ul>
        </article>
       </section>
       <section class="panel-body">
         <article class="col-md-4">
          <label for="">Descripción del producto:</label>
          <input type="text" name="nom_producto" class="form-control text-center" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $fila["nom_producto"];?>"<?php echo $atributo3;?>/>
          <input type="hidden" name="cat" value="<?php echo $cat ?>">
          <input type="hidden" name="id_producto" value="<?php echo $fila['id_producto'] ?>">
        </article>
        <article class="col-md-2">
          <label for="">Grupo terapeutico:</label>
          <select class="form-control" name="gterapeutico" required="">
            <option value=""></option>
            <option values="ANTIVIRAL">ANTIVIRAL</option>
            <option values="ANTICONVULSIVO">ANTICONVULSIVO</option>
            <option values="INMUNOSUPRESOR">INMUNOSUPRESOR</option>
            <option values="ONCOLOGICO">ONCOLOGICO</option>
            <option values="METABOLISMO">METABOLISMO</option>
            <option values="SISTEMA MUSCULOESQUELETICO">SISTEMA MUSCULOESQUELETICO</option>
            <option values="ANTIINFLAMATORIO NO ESTEROIDEO Y ANT">ANTIINFLAMATORIO NO ESTEROIDEO Y ANT</option>
            <option values="ANALGESICO">ANALGESICO</option>
            <option values="DERMATOLOGIA">DERMATOLOGIA</option>
            <option values="HORMONA">HORMONA</option>
            <option values="ANTIGLAUCOMATOSO">ANTIGLAUCOMATOSO</option>
            <option values="SISTEMA RESPIRATORIO">SISTEMA RESPIRATORIO</option>
            <option values="VASODILATADOR">VASODILATADOR</option>
            <option values="ANTIBIOTICO">ANTIBIOTICO</option>
            <option values="CARDIOVASCULAR">CARDIOVASCULAR</option>
            <option values="HEMATOLOGIA">HEMATOLOGIA</option>
            <option values="ANTIBACTERIAL">ANTIBACTERIAL</option>
            <option values="MEDIO DE CONTRASTE">MEDIO DE CONTRASTE</option>
            <option values="HIPOLIPEMIANTE">HIPOLIPEMIANTE</option>
            <option values="LUBRICANTE-HUMECTANTE">LUBRICANTE-HUMECTANTE</option>
            <option values="ANTIINFECCIOSO">ANTIINFECCIOSO</option>
            <option values="APARATO DIGESTIVO">APARATO DIGESTIVO</option>
            <option values="LIQUIDOS Y ELECTROLITOS">LIQUIDOS Y ELECTROLITOS</option>
            <option values="EQUIPOS">EQUIPOS</option>
            <option values="ANTIPARASITARIO">ANTIPARASITARIO</option>
            <option values="HIPERTENSIVO">HIPERTENSIVO</option>
            <option values="NUTRICION">NUTRICION</option>
            <option values="BRONCODILATADOR">BRONCODILATADOR</option>
            <option values="ANTIHISTAMINICO">ANTIHISTAMINICO</option>
            <option values="ANTIPERTENSIVO">ANTIPERTENSIVO</option>
            <option values="ANTIMICOTICO">ANTIMICOTICO</option>
            <option values="ANTICOAGULANTE">ANTICOAGULANTE</option>
            <option values="SISTEMA INMUNOLOGICO">SISTEMA INMUNOLOGICO</option>
            <option values="ANESTESICO">ANESTESICO</option>
            <option values="ANTIINFLAMATORIO ESTEROIDES">ANTIINFLAMATORIO ESTEROIDES</option>
            <option values="GINECOLOGICO">GINECOLOGICO</option>
            <option values="ANTIEMETICO">ANTIEMETICO</option>
            <option values="SISTEMA GENITOURINARIO Y HORMONA SEXUALES">SISTEMA GENITOURINARIO Y HORMONA SEXUALES</option>
            <option values="ANTIMALARICO">ANTIMALARICO</option>
            <option values="ANTICONCEPTIVOS HORMONAL">ANTICONCEPTIVOS HORMONAL</option>
            <option values="HIPOGLICEMIANTE">HIPOGLICEMIANTE</option>
            <option values="ANABOLICOS">ANABOLICOS</option>
            <option values="VACUNA">VACUNA</option>
            <option values="ANTIESPASMODICO">ANTIESPASMODICO</option>
            <option values="ANTIPARKISONIANO">ANTIPARKISONIANO</option>
          </select>
        </article>
        <article class="col-md-2">
          <label for="">POS:</label>
          <select recuired="" class="form-control" name="pos">
            <option value="<?php echo $fila["pos"];?>"><?php echo $fila["pos"];?></option>
            <option value="0">POS</option>
            <option value="1">NO POS</option>
          </select>
        </article>
        <article class="col-md-2">
          <label for="">Controlado:</label>
          <select recuired="" class="form-control" name="controlado">
            <option value="<?php echo $fila["controlado"];?>"><?php echo $fila["controlado"];?></option>
            <option value="0">NO</option>
            <option value="1">SI</option>
          </select>
        </article>
        <article class="col-md-2">
          <label for="">Costo Mayor:</label>
          <select recuired="" class="form-control" name="altocosto">
            <option value="<?php echo $fila["altocosto"];?>"><?php echo $fila["altocosto"];?></option>
            <option value="0">NO</option>
            <option value="1">SI</option>
          </select>
        </article>
       </section>
       <section class="panel-body">
         <article class="col-md-2">
          <label for="">Embalaje:</label>
          <select class="form-control" name="embalaje">
            <option value="<?php echo $fila["embalaje"];?>"><?php echo $fila["embalaje"];?></option>
            <option value="UNIDAD">UNIDAD</option>
            <option value="PAQUETE">PAQUETE</option>
            <option value="FRASCO">FRASCO</option>
          </select>
         </article>
         <article class="col-md-2">
           <label for="">Unidad:</label>
           <input type="number" class="form-control" name="unidad" value="<?php echo $fila['unidad'] ?>">
           </select>
         </article>
         <article class="col-md-8">
           <label for="">En caso de ser NO POS, aclarar aqui la exepción :</label>
           <textarea name="exepcion" class="form-control" rows="5" cols="80"><?php echo $fila['exepcion'] ?></textarea>
           </select>
         </article>
       </section>
    <div class="row text-center">
      <input type="submit" class="btn btn-primary" name="aceptar" Value="<?php echo $boton; ?>" />
      <input type="hidden" class="btn btn-primary" name="opcion" Value="<?php echo $_GET["opcion"];?>"/>
      <input type="hidden" class="btn btn-primary" name="operacion" Value="<?php echo $_GET["mante"];?>"/>
    </div>
    </section>
  </form>
  <?php
}
if ($cat==2) {
  ?>
  <form action="<?php echo PROGRAMA.'?opcion=97';?>" method="POST" enctype="multipart/form-data" onsubmit="return validar()" role="form" class="form-horizontal">
    <section class="panel panel-default">
      <section class="panel-heading"><h4><?php echo $subtitulo ?></h4></section>

       <section class="panel-body">
         <article class="col-md-4">
          <label for="">Descripción del producto:</label>
          <input type="text" name="nom_producto" class="form-control text-center" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $fila["nom_producto"];?>"<?php echo $atributo3;?>/>
          <input type="hidden" name="cat" value="<?php echo $cat ?>">
          <input type="hidden" name="id_producto" value="<?php echo $fila['id_producto'] ?>">
        </article>
        <article class="col-md-2">
          <label for="">Grupo terapeutico:</label>
          <select class="form-control" name="gterapeutico" required="">
            <option values="DISPOSITIVO MEDICO">DISPOSITIVO MEDICO</option>
          </select>
        </article>
        <article class="col-md-2">
          <label for="">POS:</label>
          <select recuired="" class="form-control" name="pos">
            <option value="<?php echo $fila["pos"];?>"><?php echo $fila["pos"];?></option>
            <option value="0">POS</option>
            <option value="1">NO POS</option>
          </select>
        </article>
        <article class="col-md-2">
          <label for="">Controlado:</label>
          <select recuired="" class="form-control" name="controlado">
            <option value="<?php echo $fila["controlado"];?>"><?php echo $fila["controlado"];?></option>
            <option value="0">NO</option>
            <option value="1">SI</option>
          </select>
        </article>
        <article class="col-md-2">
          <label for="">Alto Costo:</label>
          <select recuired="" class="form-control" name="altocosto">
            <option value="<?php echo $fila["altocosto"];?>"><?php echo $fila["altocosto"];?></option>
            <option value="0">NO</option>
            <option value="1">SI</option>
          </select>
        </article>
       </section>
       <section class="panel-body">
         <article class="col-md-2">
          <label for="">Embalaje:</label>
          <select class="form-control" name="embalaje">
            <option value="<?php echo $fila["embalaje"];?>"><?php echo $fila["embalaje"];?></option>
            <option value="UNIDAD">UNIDAD</option>
            <option value="PAQUETE">PAQUETE</option>
            <option value="FRASCO">FRASCO</option>
          </select>
         </article>
         <article class="col-md-2">
           <label for="">Unidad:</label>
           <input type="number" class="form-control" name="unidad" value="<?php echo $fila['unidad'] ?>">
           </select>
         </article>
         <article class="col-md-8">
          <label for="">Clasificación de Riesgo:</label>
          <select class="form-control" name="clase_riesgo">
            <option value="<?php echo $fila["clase_riesgo"];?>"><?php echo $fila["clase_riesgo"];?></option>
            <option value="I(A)">Riesgo Bajo (Instrumental quirúrgico / Gasa.)</option>
            <option value="IIa(B)"> Riesgo Moderado (Agujas hipodérmicas / equipo de succión)</option>
            <option value="IIb(C)"> Riesgo Alto (Ventilador pulmonar / implantes ortopédicos)</option>
            <option value="III(D)"> Riesgo Muy Alto (Válvulas cardiacas / marcapasos.)</option>
          </select>
         </article>
         <article class="col-md-12">
           <label for="">En caso de ser NO POS, aclarar aqui la exepción :</label>
           <textarea name="exepcion" class="form-control" rows="5" cols="80"><?php echo $fila['exepcion'] ?></textarea>
           </select>
         </article>
       </section>
    <div class="row text-center">
      <input type="submit" class="btn btn-primary" name="aceptar" Value="<?php echo $boton; ?>" />
      <input type="hidden" class="btn btn-primary" name="opcion" Value="<?php echo $_GET["opcion"];?>"/>
      <input type="hidden" class="btn btn-primary" name="operacion" Value="<?php echo $_GET["mante"];?>"/>
    </div>
    </section>
  </form>
  <?php
}
 ?>
