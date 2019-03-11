<section class="panel-body">
  <h1 class=" animated zoomIn">Hola, <?php echo $_SESSION['AUT']['nombre'] ?></h1>
  <p class="lead">Aqui puede realizar consulta de los pacientes asignados por Emmanuel IPS.</p>
  <hr class="my-4">
  <article class="col-md-12">
    <button data-toggle="collapse" class="btn btn-info btn-lg text-center" data-target="#Pacaut">Consulte AQUI los pacientes que tiene autorizados <br><span class="glyphicon glyphicon-arrow-down"></span> </button>
  </article>

  <section class="panel-body">
    <article class="col-md-12">
      <section id="Pacaut" class="collapse">
        <?php
        echo'<table class="table table-bordered">
        <tr>
          <th>#</th>
          <th>PACIENTE</th>
          <th>INGRESO</th>
          <th>AUTORIZACION</th>
          <th>SESIONES</th>
          <th></th>
        </tr>
          ';
        $user=$_SESSION['AUT']['id_user'];
        $sql="SELECT h.nom_eps,b.tdoc_pac,b.doc_pac, b.nom_completo,b.tel_pac,b.dir_pac, c.tipo_usuario,b.zonificacion,
                     c.mun_residencia,c.dep_residencia,i.descrimuni,c.zona_residencia,
                     IFNULL(c.id_adm_hosp,0),d.id_m_aut_dom, IFNULL(e.id_d_aut_dom,0),
                     e.freg, e.cups, e.procedimiento, e.cantidad, e.finicio, e.ffinal,
                     e.num_aut_externa, e.estado_d_aut_dom, e.intervalo,
                     e.temporalidad,g.nombre profesional,
                     j.nom_sedes,
                     cantidad_sesion_dom(e.cups,c.id_adm_hosp,CAST(e.finicio AS DATE),CAST(e.ffinal AS DATE)) sesiones

              from adm_hospitalario c INNER JOIN m_aut_dom d on (d.id_adm_hosp = c.id_adm_hosp)
                                      INNER JOIN d_aut_dom e on (e.id_m_aut_dom = d.id_m_aut_dom
                                               and CURRENT_DATE BETWEEN
                                              CAST(e.finicio AS DATE) AND CAST(e.ffinal  AS DATE))
                                      INNER JOIN pacientes b on (c.id_paciente = b.id_paciente)
                                      INNER JOIN eps h on (h.id_eps = c.id_eps)
                                      INNER JOIN sedes_ips j on (j.id_sedes_ips = c.id_sedes_ips)
                                      LEFT  JOIN profesional_d_dom f on (f.id_d_aut_dom = e.id_d_aut_dom)
                                      LEFT  JOIN user g on (g.id_user = f.profesional)
                                      LEFT  JOIN municipios i on (i.codmuni = c.mun_residencia)
              where c.tipo_servicio = 'Domiciliarios' and c.estado_adm_hosp = 'Activo' and f.profesional=$user
              ";
            $i=1;
            if ($tabla=$bd1->sub_tuplas($sql)){
              foreach ($tabla as $fila) {
                echo"<tr >\n";
                echo'<td class="text-center">
                      <p>'.$i++.'<p>
                     </td>';
                echo'<td class="text-left">
                      <p>'.$fila["nom_completo"].'<p>
                      <p><strong>'.$fila["tdoc_pac"].' </strong>: '.$fila["doc_pac"].'</p>
                      <p><strong>Tel: </strong>: '.$fila["tel_pac"].'</p>
                      <p><strong>Dirección: </strong> '.$fila["dir_pac"].' '.$fila["descrimuni"].'</p>
                     </td>';
                echo'<td class="text-left">
                      <p><strong>ADM: </strong>'.$fila["IFNULL(c.id_adm_hosp,0)"].'</p>
                      <p><strong>EPS: </strong>'.$fila["nom_eps"].'</p>
                      <p><strong>SEDE: </strong>'.$fila["nom_sedes"].'</p>';
                echo'</td>';
                echo'<td class="text-left">
                      <p><strong>ID M: </strong>'.$fila["id_m_aut_dom"].'</p>
                      <p><strong>ID D: </strong>'.$fila["IFNULL(e.id_d_aut_dom,0)"].'</p>
                      <p><strong>Intervalo/turno: </strong>'.$fila["intervalo"].'</p>
                      <p><strong>Tipo Paciente: </strong>'.$fila["nomclaseusuario"].'</p>
                      <p><strong>'.$fila["cups"].' </strong>'.$fila["procedimiento"].'</p>
                      <p><strong>Vigencia: </strong>'.$fila["finicio"].' -- '.$fila["ffinal"].'</p>
                     </td>';
                echo'<td class="text-center">
                      <p><strong>Autorizado: </strong>'.$fila["cantidad"].'</p>
                      <p><strong>Realizado: </strong>'.$fila["sesiones"].'</p>
                     </td>';
                echo'<td class="text-center">

                     </td>';
                echo "</tr>\n";
              }
            }
        ?>
         </table>
      </section>
    </article>
  </section>
  <section class="panel-body ">
    <section class="panel-body">
      <section class="col-md-12">
        <h1 class="display-4 text-center text-primary">Anuncios Generales</h1>
        <hr class="my-4">
        <ul>
          <?php
          $servicio='Domiciliarios';
          $sql_ag="SELECT a.id_anuncio,a.servicio,a.tipo_anuncio,a.freg,a.hreg,a.titulo,a.anuncio,a.estado,a.f_elimina,a.resp_elimina ,
                               b.nombre
                        FROM anuncios a inner join user b on a.id_user=b.id_user
                        WHERE a.estado=1 and a.tipo_anuncio=1 ORDER BY a.freg DESC ";
          if ($tabla_ag=$bd1->sub_tuplas($sql_ag)){
            foreach ($tabla_ag as $fila_ag ) {
              echo'<i>';
              echo'<article class="col-md-8 animated bounceIn alert alert-info ">
                    <h3>'.$fila_ag["titulo"].'</h3>
                    <p class="text-justify">'.$fila_ag["anuncio"].'</p>
                   </article>';
                   echo'<article class="col-md-4">

                        </article>';
              echo'</i>';
            }
          }
           ?>
        </ul>
      </section>
    <article class="col-md-6">
      <h2 class="display-4 animated zoomIn text-primary">Actualizaciones SION SOFTWARE</h2>
      <hr class="my-4">
      <ul>
        <?php
        $servicio='Domiciliarios';
        $sql_ag="SELECT a.id_anuncio,a.servicio,a.tipo_anuncio,a.freg,a.hreg,a.titulo,a.anuncio,a.estado,a.f_elimina,a.resp_elimina ,
                             b.nombre
                      FROM anuncios a inner join user b on a.id_user=b.id_user
                      WHERE a.estado=1 and a.tipo_anuncio=2 ORDER BY a.freg DESC ";
        if ($tabla_ag=$bd1->sub_tuplas($sql_ag)){
          foreach ($tabla_ag as $fila_ag ) {
            echo'<i>';
            echo'<article class="col-md-8 animated bounceIn alert alert-success">
                  <h3>'.$fila_ag["titulo"].'</h3>
                  <p class="text-justify">'.$fila_ag["anuncio"].'</p>
                 </article>';
                 echo'<article class="col-md-4">

                      </article>';
            echo'</i>';
          }
        }
         ?>
      </ul>
    </article>
    <article class="col-md-6">
      <h2 class="display-4 animated zoomIn text-primary">Anuncios Capacitación</h2>
      <hr class="my-4">
      <ul>
        <?php
        $servicio='Domiciliarios';
        $sql_ag="SELECT a.id_anuncio,a.servicio,a.tipo_anuncio,a.freg,a.hreg,a.titulo,a.anuncio,a.estado,a.f_elimina,a.resp_elimina ,
                             b.nombre
                      FROM anuncios a inner join user b on a.id_user=b.id_user
                      WHERE a.estado=1 and a.tipo_anuncio=3 ORDER BY a.freg DESC ";
        if ($tabla_ag=$bd1->sub_tuplas($sql_ag)){
          foreach ($tabla_ag as $fila_ag ) {
            echo'<i>';
            echo'<article class="col-md-8 animated bounceIn alert alert-warning">
                  <h3>'.$fila_ag["titulo"].'</h3>
                  <p class="text-justify">'.$fila_ag["anuncio"].'</p>
                 </article>';
                 echo'<article class="col-md-4">

                      </article>';
            echo'</i>';
          }
        }else {
          echo'<i>';
          echo'<article class="col-md-12">
                <p class="text-justify"><span class="fa fa-"></span> No hay anuncios en esta sección.</p>
               </article>';
               echo'<article class="col-md-4">

                    </article>';
          echo'</i>';
        }
         ?>
      </ul>
    </article>
  </section>
</section>
