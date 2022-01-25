<?php
  include 'MasterPage.php';
  include("Classes/CConection.php");
  $User= $_SESSION['User'];
  $Role= $_SESSION['AccountRole'];
  $UserFullName= $_SESSION['FullName'];

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
  require 'PHPMailer/src/Exception.php';
  require 'PHPMailer/src/PHPMailer.php';
  require 'PHPMailer/src/SMTP.php';

$consulta=<<<SQL
 SELECT DISTINCT FullName as 'Nombres' FROM users
SQL;
$NombresCompletosDeUsuarios =mysqli_query($connect,$consulta);

$consulta22=<<<SQL
 SELECT DISTINCT FullName as 'Nombres' FROM users
SQL;
$NombresCompletosDeUsuarios2 =mysqli_query($connect,$consulta22);


$consulta2=<<<SQL
SELECT * FROM `tareascargadas` WHERE `Asignador`='$User' and `Terminada`='0' and  `Asignado` <> '$User'
SQL;
$Tareas =mysqli_query($connect,$consulta2);

$consulta3=<<<SQL
SELECT * FROM `tareascargadas` WHERE `Asignado`='$User' and `Terminada`='0'
SQL;
$MisTareasPendientes =mysqli_query($connect,$consulta3);

$TareasProgramadas=<<<SQL
SELECT * FROM `tareasprogramadas` WHERE `Asignador`='$User' and `Finalizada`='No'
SQL;
$TareasProgramadas2 =mysqli_query($connect,$TareasProgramadas);

?>


<head>

  <!-- datetimepicker -->
  <script src="https://cdn.jsdelivr.net/npm/gijgo@1.9.9/js/gijgo.min.js" type="text/javascript"></script>
  <link href="https://cdn.jsdelivr.net/npm/gijgo@1.9.9/css/gijgo.min.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU"
    crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.css" />
  <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.js"></script>

  <link rel="stylesheet" type="text/css" href="Assets/Styles/Main.css">

  <script src="Assets/js/Main.js"></script>
</head>
<script>
  $(document).ready(function () {
    document.getElementById("<?php echo $User; ?>").selected = "true";

    document.getElementById("id2<?php echo $User; ?>").selected = "true";

  });

  function slctRecurrencia(sel) {
    var e = document.getElementById("slctPeriodicidad1Programada");
    var strUser = e.options[e.selectedIndex].text;

    if (strUser == "Un solo evento") {
      document.getElementById("txtFechaLimiteUnSoloEventoProgramada").disabled = false;
      document.getElementById("txtFechaInicioRecurrenteProgramada").disabled = true;
      document.getElementById("PeriodicidadProgramada").disabled = true;
    } else if (strUser == "Recurrente") {
      document.getElementById("PeriodicidadProgramada").disabled = false;
      document.getElementById("txtFechaInicioRecurrenteProgramada").disabled = false;
      document.getElementById("txtFechaLimiteUnSoloEventoProgramada").disabled = true;
    } else {
      document.getElementById("txtFechaLimiteUnSoloEventoProgramada").disabled = true;
      document.getElementById("txtFechaInicioRecurrenteProgramada").disabled = true;
      document.getElementById("PeriodicidadProgramada").disabled = true;
    }
  }

  $(document).ready(function () {
    document.getElementById("txtFechaLimiteUnSoloEventoProgramada").disabled = true;
    document.getElementById("txtFechaInicioRecurrenteProgramada").disabled = true;
    document.getElementById("PeriodicidadProgramada").disabled = true;

  });
  $(document).ready(function () {

    $("#frmNewTask").submit(function () {
      $("#btnNewTask").attr("disabled", true);
      document.getElementById("btnNewTask").value = "Enviando…";
      return true;
    });

    $("#frmNewTaskProgramada").submit(function () {
      $("#btnNewTaskProgramada").attr("disabled", true);
      document.getElementById("btnNewTaskProgramada").value = "Creando…";
      return true;
    });
  });

</script>

<style>
  .numberCircle {
    border-radius: 50%;
    behavior: url(PIE.htc);

    width: 35px;
    margin-bottom: -5px;
    height: 35px;
    padding: 6px;
    padding-top: 7px;
    margin-top: -5px;
    background: #fff;
    border: 2px solid #666;
    color: #666;
    text-align: center;
    font: 16px Arial, sans-serif;
  }


@media screen and (max-width: 1900px) {
  .pnllg {
    display: none;
    background-color: purple;
    }
    .pnlMed {
    display: block;
    background-color: yellow;
    }
}
@media screen and (min-width: 1900px) {
    .pnllg {
    display: block;
    background-color:red;
    }
    .pnlMed {
    display: none;
    background-color: #42A5F5;
    }
}
</style>
<div class="container-fluid" style="background-color: transparent">

  <div class="row">

    <div class="col-sm-1 Largo  pnlMed  " style=" height: 3000px; top:0px; left:0px; bottom:0px; right:0px;; ;z-index:800;background-color: #eeeeee       ;margin-left: -45px;padding-top: 100px;padding-left: 70px;text-align: center;border: 1px solid #90caf9 ">
      <div class="row">
        <button type="submit" class="btn btn-outline-primary estilobtn1" style="margin-top:-23px;width:43px;height:42px;margin-left: 0px"
          data-toggle="modal" data-target="#ModalNuevaTarea">
          <i class="far fa-plus-square  fa-2x" style="margin-left: -6px;margin-top: -2px"></i>
        </button>
        <br>
        <button type="submit" class="btn btn-outline-primary estilobtn1" style="margin-top:5px;width:43px;height:42px;margin-left: 0px"
          data-toggle="modal" data-target="#ModalNuevaTareaProgramada">
          <i class="far fa-calendar-alt fa-2x" style="margin-left: -6px;margin-top: -2px"></i>
        </button>
      </div>
    </div>

    <div class="col-sm-1 Largo  pnllg" style=" height: 3000px; top:0px; left:0px; bottom:0px; right:0px;; ;z-index:800;background-color: #eeeeee       ;margin-left: -45px;padding-top: 100px;padding-left: 70px;text-align: center;border: 1px solid #90caf9 ">
      <div class="row">
        <button type="submit" class="btn btn-outline-primary estilobtn1" style="margin-top:-23px;width:80px;height:79px;margin-left: 6px"
          data-toggle="modal" data-target="#ModalNuevaTarea">
          <i class="far fa-plus-square  fa-4x" style="margin-left: -1px;margin-top: -2px"></i>
        </button>
        <br>
        <button type="submit" class="btn btn-outline-primary estilobtn1" style="margin-top:8px;width:80px;height:79px;margin-left: 6px"
          data-toggle="modal" data-target="#ModalNuevaTareaProgramada">
          <i class="far fa-calendar-alt fa-4x" style="margin-left: -1px;margin-top: -2px"></i>
        </button>
      </div>
    </div>

    <div class="col-sm-11" style="margin-bottom:25px;margin-left:23px;background-color:transparent;border: 1px solid #4285F4;border-radius: 5px;margin-top: 90px;padding: 20px">
      <h3>Gestión de tareas</h3>
      <div id="accordion" style="margin-top: 20px">
        <div class="card">
          <div class="card-header">
            <a class="card-link" data-toggle="collapse" href="#collapseOne">
              Mis tareas pendientes
              <div class="float-right">
                <div class="numberCircle">
                  <span id="TareasGeneradas"></span>
                </div>
              </div>

            </a>
          </div>
          <div id="collapseOne" class="collapse show" data-parent="#accordion">
            <div class="card-body">
              <div class="table-responsive" style="border-radius: 10px;margin-top: 12px">
                <table class="table  table-bordered table-hover table-condensed tab" id="table2" style="background-color: #ffffff;text-align: center;vertical-align: middle;">
                  <thead>
                    <tr style="background-color: #90caf9">
                      <!-- <th style="font-size: 14px;color: #222">Numero</th> -->
                      <th style="font-size: 14px;color: #222;width: 20px">Folio</th>
                      <th style="font-size: 14px;color: #222;width: 70px">Fecha</th>
                      <th style="font-size: 14px;color: #222;width: 60px">Asignador</th>
                      <th style="font-size: 14px;color: #222">Titulo</th>
                      <th style="font-size: 14px;color: #222">Descripción</th>
                      <th style="font-size: 14px;color: #222;width: 60px">Asignado</th>
                      <th style="font-size: 14px;color: #222;width: 90px">Fecha Limite</th>
                      <th style="font-size: 14px;color: #222;width: 20px">Ver</th>
                      <th style="font-size: 14px;color: #222;width: 1px">Adj.</th>
                      <th style="font-size: 14px;color: #222;width: 1px">Vencida</th>
                      <th style="font-size: 14px;color: #222;width: 130px">Acciones</th>

                    </tr>
                  </thead>

                  <tbody>
                    <?php
                            $count=0;
                            while ($columna=mysqli_fetch_assoc($MisTareasPendientes))
                            {
                                $count=$count+1;
                                echo "<tr >";
                                echo "<td>$columna[id]</td>";
                                echo "<td>$columna[Fecha]</td>";
                                echo "<td>$columna[Asignador]</td>";
                                echo "<td>$columna[TituloTarea]</td>";
                                echo "<td>";
                                if(strlen($columna['Descripcion']) > 265){
                                  echo substr($columna['Descripcion'], 0, 265).'...   '.'<span style="color: #4285F4">Mas</span>';echo "</td>";
                                }else{
                                  echo $columna['Descripcion'] ;
                                }

                                echo "<td>$columna[Asignado]</td>";
                                echo "<td>$columna[FechaLimite]</td>";
                                echo "<td><span align='right'><a class='VerModalTareaDesglosada' id='$columna[id]'><i class=' far fa-window-restore  fa-lg'></xi></a></span></td>";

                                if($columna['Adjunto']==""){
                                  echo "<td><label></label></td>";
                                }else{
                                  echo "<form action='Classes/Querys.php' method='post'>";
                                  echo "<input type='hidden'  value='$columna[Adjunto]'  name='NombreFile'/>";
                                  echo "<td><button type='submit' class=' btn btn-success far fa-file-alt  fa-lg btn-sm'>       </button></td>";
                                  echo "</form>";
                                }
                                $fecha_entrada = strtotime("$columna[FechaLimite]");
                                $fecha_actual = strtotime(date("d-m-Y H:i:00",time()));
                                if($fecha_actual > $fecha_entrada)
                                  {
                                $columna['Vencida']="1";
                          $sqlCommand = "UPDATE tareascargadas SET Vencida=1 WHERE id=$columna[id]";
                          if(mysqli_query($connect, $sqlCommand)){
                            }
                                  }else
                                    {
                                $columna['Vencida']="0";
                                    }
                                if ($columna['Vencida']=="0"){
                                  echo "<td><label>No</label></td>";
                                }else{
                                  echo "<td><label>Si</label></td>";
                                }



                                // echo "<form action='Classes/Querys.php' method='post'>";
                                // echo "<input type='hidden'  value='$columna[id]'  name='IdTareaATerminar'/>";
                                // echo "<td>  <button class='TerminarTarea'>edwed</button> ";
                                echo "<td><a class='btn btn-primary btn-sm float-left TerminarTarea' id='$columna[id]'  style='color:white' >Terminar</a>";
                                // echo "</form>";

                                if ($columna['Asignador']==$User){
                                  echo "<form action='Classes/Querys.php' method='post'>";
                                  echo "<input type='hidden'  value='$columna[id]'  name='IdTareaAEliminar'/>";
                                  echo "<input type='submit'  value='Eliminar'  style='width: 72px' class='btn btn-default btn-sm float-right'   />";
                                }
                                echo "</form></td>";
                                echo "</tr>";

                            }
                            ?>
                  </tbody>
                </table>


              </div>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header">
            <a class="collapsed card-link" data-toggle="collapse" href="#collapseTwo">
              Tareas que he asignado a otros usuarios
              <div class="float-right">
                <div class="numberCircle">
                  <span id="TareasAsignadas"></span>
                </div>
              </div>
            </a>
          </div>
          <div id="collapseTwo" class="collapse show" data-parent="#accordion">
            <div class="card-body">
              <div class="table-responsive" style="border-radius: 10px;margin-top: 12px">
                <table class="table  table-bordered table-hover table-condensed tab" id="table" style="background-color: #ffffff;text-align: center;vertical-align: middle;">
                  <thead>
                    <tr style="background-color: #90caf9 ">

                      <th style="font-size: 14px;color: #222;width: 20px">Folio</th>
                      <th style="font-size: 14px;color: #222;width: 70px">Fecha</th>
                      <th style="font-size: 14px;color: #222;width: 60px">Asignador</th>
                      <th style="font-size: 14px;color: #222">Titulo</th>
                      <th style="font-size: 14px;color: #222">Descripción</th>
                      <th style="font-size: 14px;color: #222;width: 60px">Asignado</th>
                      <th style="font-size: 14px;color: #222;width: 90px">Fecha Limite</th>
                      <th style="font-size: 14px;color: #222;width: 20px">Ver</th>
                      <th style="font-size: 14px;color: #222;width: 1px">Adj.</th>
                      <th style="font-size: 14px;color: #222;width: 1px">Vencida</th>
                      <th style="font-size: 14px;color: #222;width: 40px">Acciones</th>


                    </tr>
                  </thead>

                  <tbody>
                    <?php
                        $count=0;
                        while ($columna=mysqli_fetch_assoc($Tareas))
                        {
                            $count=$count+1;
                            echo "<tr >";

                            echo "<td>$columna[id]</td>";
                            echo "<td>$columna[Fecha]</td>";
                            echo "<td>$columna[Asignador]</td>";
                            echo "<td>$columna[TituloTarea]</td>";
                            echo "<td>$columna[Descripcion]</td>";
                            echo "<td>$columna[Asignado]</td>";
                            echo "<td>$columna[FechaLimite]</td>";
                            echo "<td><span align='right'><a class='VerModalTareaDesglosada' id='$columna[id]'><i class='far fa-window-restore  fa-lg'></xi></a></span></td>";

                            if($columna['Adjunto']==""){
                              echo "<td><label></label></td>";
                            }else{
                              echo "<form action='Classes/Querys.php' method='post'>";
                              echo "<input type='hidden'  value='$columna[Adjunto]'  name='NombreFile'/>";
                              echo "<td><button type='submit' class=' btn btn-success far fa-file-alt  fa-lg btn-sm'>       </button></td>";
                              echo "</form>";
                            }
                            $fecha_entrada = strtotime("$columna[FechaLimite]");
                            $fecha_actual = strtotime(date("d-m-Y H:i:00",time()));
                            if($fecha_actual > $fecha_entrada)
                            	{
                            $columna['Vencida']="1";
                            	}else
                            		{
                            $columna['Vencida']="0";
                            		}
                            if ($columna['Vencida']=="0"){
                              echo "<td><label>No</label></td>";
                            }else{
                              echo "<td><label>Si</label></td>";
                            }
                            if ($columna['Asignador']==$User){
                              echo "<form action='Classes/Querys.php' method='post'>";
                              echo "<td><input type='hidden' type='hidden'  value='$columna[id]'  name='IdTareaAEliminar'/>";
                              echo "<input type='submit'  value='Eliminar'  style='width: 72px' class='btn btn-default btn-sm float-right'   />";
                            }
                            echo "</form></td>";
                            echo "</tr>";

                        }
                        ?>
                  </tbody>
                </table>


              </div>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header">
            <a class="collapsed card-link" data-toggle="collapse" href="#collapseThree">
              Tareas programadas
              <div class="float-right">
                <div class="numberCircle">
                  <span id="TareasAsignadasProgramadas"></span>
                </div>
              </div>
            </a>
          </div>
          <div id="collapseThree" class="collapse show" data-parent="#accordion">
            <div class="card-body">
              <div class="table-responsive" style=";margin-top: 12px">
                <table class="table  table-bordered table-hover table-condensed tab" id="tableProgramadas" style="background-color: #ffffff;text-align: center;vertical-align: middle;">
                  <thead>
                    <tr style="background-color: #90caf9 ">
                      <th style="font-size: 14px;color: #222;width: 20px">Folio</th>
                      <th style="font-size: 14px;color: #222;width: 20px">FechaDeCreacion</th>
                      <th style="font-size: 14px;color: #222;width: 70px">Asignador</th>
                      <th style="font-size: 14px;color: #222;width: 60px">TituloTarea</th>
                      <th style="font-size: 14px;color: #222">Descripcion</th>
                      <th style="font-size: 14px;color: #222">Asignado</th>
                      <th style="font-size: 14px;color: #222;width: 60px">FechaDeProximoEvento</th>
                      <th style="font-size: 14px;color: #222;width: 90px">Frecuencia</th>
                      <th style="font-size: 14px;color: #222;width: 90px">Finalizada</th>
                      <th style="font-size: 14px;color: #222;width: 20px">Ver</th>
                      <th style="font-size: 14px;color: #222;width: 40px">Acciones</th>


                    </tr>
                  </thead>

                  <tbody>
                    <?php
                          $count=0;
                          while ($columna=mysqli_fetch_assoc($TareasProgramadas2))
                          {
                              $count=$count+1;
                              echo "<tr >";

                              echo "<td>$columna[id]</td>";
                              echo "<td>$columna[FechaDeCreacion]</td>";
                              echo "<td>$columna[Asignador]</td>";
                              echo "<td>$columna[TituloTarea]</td>";
                              echo "<td>$columna[Descripcion]</td>";
                              echo "<td>$columna[Asignado]</td>";
                              echo "<td>$columna[FechaDeProximoEvento]</td>";
                              echo "<td>$columna[Frecuencia]</td>";
                              echo "<td>$columna[Finalizada]</td>";
                              echo "<td><span align='right'><a class='VerModalTareaProgramadaDesglosada' id='$columna[id]'><i class='far fa-window-restore  fa-lg'></xi></a></span></td>";

                              if ($columna['Asignador']==$User){
                                echo "<form action='Classes/Querys.php' method='post'>";
                                echo "<input type='hidden' type='hidden'  value='$columna[id]'  name='IdTareaProgramadaAEliminar'/>";
                                echo "<td><input type='submit'  value='Eliminar'  style='width: 72px' class='btn btn-default btn-sm float-right'   />";
                              }
                              echo "</form></td>";
                              echo "</tr>";

                          }
                          ?>
                  </tbody>
                </table>


              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<div class="modal fade" id="ModalNuevaTarea">
  <div class="modal-dialog  modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header" style="background-color: #42a5f5 ;color: white">
        <h4 class="modal-title">Crear nueva tarea</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <form enctype="multipart/form-data" action="Classes/Querys.php" id="frmNewTask" method="POST">
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-6" style="margin-top: 5px">
              <label>Asignador</label>
              <input type="text" name="txtUserAsignadorDeTarea" id="txtUserAsignadorDeTarea" class="form-control" value="<?php echo $User; ?>"
                readonly placeholder="Nombre completo" pattern="^\s*[a-zA-Z0-9ñÑ@_.*\s]+\s*" required>
            </div>
            <div class="col-sm-6" style="margin-top: 5px">
              <label>Titulo</label>
              <input type="text" name="txtTitulo" id="txtTitulo" class="form-control" placeholder="Nombre completo" maxlength="50" pattern="^\s*[a-zA-Z0-9ñÑ@_.*\s]+\s*">
            </div>
            <br>
            <br>
            <br>
            <br>
            <div class="col-sm-12">
              <label>Descripcion</label>
              <textarea rows="4" type="text" name="txtDescripcion" id="txtDescripcion" class="form-control" placeholder="Nombre completo"
                pattern="^\s*[a-zA-Z0-9ñÑ@_.*\s]+\s*"></textarea>
            </div>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <div class="col-sm-6">
              <label>Asignado</label>
              <?php
                echo '<select name="FullNameAsignado" class="form-control" id="FullNameAsignado" >';
                while($row=mysqli_fetch_assoc($NombresCompletosDeUsuarios))
                {
                  $Nombre=$row['Nombres'];
                  $consulta4="SELECT * FROM `users` WHERE `FullName`='$Nombre'";

                  $UsuarioDeNombre =mysqli_query($connect,$consulta4);
                  $result2 = mysqli_fetch_array($UsuarioDeNombre);
                  echo '<option id="'.htmlspecialchars($result2['User']).'"  value="' . htmlspecialchars($result2['User']) . '">' . htmlspecialchars($row['Nombres'])   . '</option>';
                }
                echo '</select>';
              ?>
            </div>

            <div class="col-sm-6" style="margin-bottom: 10px">
              <label>Fecha limite</label>
              <input type="text" name="txtFechaLimite" id="txtFechaLimite" class="form-control" maxlength="50" pattern="^\s*[a-zA-Z0-9ñÑ@_.-*\s]+\s*">
            </div>

            <div class="col-sm-6" style="margin-bottom: 10px">
              <label>Adjunto</label>
              <input id="fileToUpload" name="fileToUpload" type="file">
            </div>

          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
          <input type="submit" class="btn btn-primary" id="btnNewTask" style="width: 213px;" value="Crear tarea" />
        </div>
      </form>
    </div>
  </div>
</div>



<div class="modal fade" id="ModalTareaCompleta">
  <div class="modal-dialog  modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header" style="background-color: #42a5f5 ;color: white">
        <h4 class="modal-title">Ver tarea</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <form action="Classes/Querys.php" method="POST">
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-6" style="margin-top: 5px">
              <label>Asignador:</label>
              <input type="text" name="txtUserAsignadorDeTareaShow" id="txtUserAsignadorDeTareaShow" class="form-control" readonly pattern="^\s*[a-zA-Z0-9ñÑ@_.*\s]+\s*"
                required>
            </div>
            <div class="col-sm-6" style="margin-top: 5px">
              <label>Titulo:</label>
              <input type="text" name="txtTituloShow" id="txtTituloShow" class="form-control" placeholder="Nombre completo" maxlength="50"
                pattern="^\s*[a-zA-Z0-9ñÑ@_.*\s]+\s*">
            </div>
            <br>
            <br>
            <br>
            <br>
            <div class="col-sm-12" style="margin-bottom: 15px">
              <label>Descripcion:</label>
              <textarea rows="8" type="text" name="txtDescripcionShow" id="txtDescripcionShow" class="form-control" placeholder="Nombre completo"
                pattern="^\s*[a-zA-Z0-9ñÑ@_.*\s]+\s*"></textarea>
            </div>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <div class="col-sm-6">
              <label>Asignado:</label>
              <input type="text" name="txtAsignadoShow" id="txtAsignadoShow" class="form-control" placeholder="Nombre completo" maxlength="50"
                pattern="^\s*[a-zA-Z0-9ñÑ@_.*\s]+\s*">
            </div>
            <div class="col-sm-6" style="margin-bottom: 10px">
              <label>Fecha limite:</label>
              <input type="text" name="txtFechaLimiteShow" id="txtFechaLimiteShow" class="form-control" maxlength="50" pattern="^\s*[a-zA-Z0-9ñÑ@_.-*\s]+\s*">
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cerrar</button>


        </div>
      </form>
    </div>
  </div>
</div>


<div class="modal fade" id="ModalTareaProgramadaCompleta">
  <div class="modal-dialog  modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header" style="background-color: #42a5f5 ;color: white">
        <h4 class="modal-title">Ver tarea programada</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <form action="Classes/Querys.php" method="POST">
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-6" style="margin-top: 5px">
              <label>Asignador:</label>
              <input type="text" name="txtUserAsignadorDeTareaShowProgramada" id="txtUserAsignadorDeTareaShowProgramada" class="form-control"
                value="<?php echo $User; ?>" readonly placeholder="Nombre completo" pattern="^\s*[a-zA-Z0-9ñÑ@_.*\s]+\s*" required>
            </div>
            <div class="col-sm-6" style="margin-top: 5px">
              <label>Titulo:</label>
              <input type="text" name="txtTituloShowProgramada" id="txtTituloShowProgramada" class="form-control" placeholder="Nombre completo"
                maxlength="50" pattern="^\s*[a-zA-Z0-9ñÑ@_.*\s]+\s*">
            </div>
            <br>
            <br>
            <br>
            <br>
            <div class="col-sm-12" style="margin-bottom: 15px">
              <label>Descripcion:</label>
              <textarea rows="8" type="text" name="txtDescripcionShowProgramada" id="txtDescripcionShowProgramada" class="form-control"
                placeholder="Nombre completo" pattern="^\s*[a-zA-Z0-9ñÑ@_.*\s]+\s*"></textarea>
            </div>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <div class="col-sm-6">
              <label>Asignado:</label>
              <input type="text" name="txtAsignadoShowProgramada" id="txtAsignadoShowProgramada" class="form-control" placeholder="Nombre completo"
                maxlength="50" pattern="^\s*[a-zA-Z0-9ñÑ@_.*\s]+\s*">
            </div>
            <div class="col-sm-6" style="margin-bottom: 10px">
              <label>Fecha Inicio:</label>
              <input type="text" name="txtFechaInicioShowProgramada" id="txtFechaInicioShowProgramada" class="form-control" placeholder="Nombre completo"
                maxlength="50" pattern="^\s*[a-zA-Z0-9ñÑ@_.-*\s]+\s*">
            </div>
            <div class="col-sm-6" style="margin-bottom: 10px">
              <label>Frecuencia:</label>
              <input type="text" name="txtFrecuenciaProgramada" id="txtFrecuenciaProgramada" class="form-control" placeholder="Nombre completo"
                maxlength="50" pattern="^\s*[a-zA-Z0-9ñÑ@_.-*\s]+\s*">
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cerrar</button>


        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="ModalNuevaTareaProgramada">
  <div class="modal-dialog  modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #42a5f5 ;color: white">
        <h4 class="modal-title">Nueva tarea programada</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <form action="Classes/Querys.php" id="frmNewTaskProgramada" method="POST">
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-6" style="margin-top: 5px">
              <label>Asignador</label>
              <input type="text" name="txtUserAsignadorDeTareaProgramada" id="txtUserAsignadorDeTareaProgramada" class="form-control" value="<?php echo $User; ?>"
                readonly placeholder="Nombre completo" pattern="^\s*[a-zA-Z0-9ñÑ@_.*\s]+\s*" required>
            </div>
            <div class="col-sm-6" style="margin-top: 5px">
              <label>Titulo</label>
              <input type="text" name="txtTituloProgramada" id="txtTituloProgramada" class="form-control" placeholder="Nombre completo"
                maxlength="50" pattern="^\s*[a-zA-Z0-9ñÑ@_.*\s]+\s*">

            </div>
            <br>
            <br>
            <br>
            <br>
            <div class="col-sm-12">
              <label>Descripcion</label>
              <textarea rows="4" type="text" name="txtDescripcionProgramada" id="txtDescripcionProgramada" class="form-control" placeholder="Nombre completo"
                pattern="^\s*[a-zA-Z0-9ñÑ@_.*\s]+\s*"></textarea>
            </div>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <div class="col-sm-6">
              <label>Asignado</label>
              <?php
                echo '<select name="FullNameAsignado2Programada" class="form-control" id="FullNameAsignado2Programada" >';
                while($row2=mysqli_fetch_assoc($NombresCompletosDeUsuarios2))
                {
                  $Nombre=$row2['Nombres'];
                  $consulta4="SELECT * FROM `users` WHERE `FullName`='$Nombre'";

                  $UsuarioDeNombre =mysqli_query($connect,$consulta4);
                  $result22 = mysqli_fetch_array($UsuarioDeNombre);


                  echo '<option id="id2'.htmlspecialchars($result22['User']).'" value="' . htmlspecialchars($result22['User']) . '">' . htmlspecialchars($row2['Nombres'])   . '</option>';
                }
                echo '</select>';
              ?>
            </div>

            <div class="col-sm-6" style="margin-bottom: 10px">

              <label>Frecuencia</label>
              <select class="form-control" id="slctPeriodicidad1Programada" name="slctPeriodicidad1Programada" onchange="slctRecurrencia(this);">
                <option value="´nada">Sin selección</option>
                <option value="Un solo evento">Un solo evento</option>
                <option value="Recurrente">Recurrente</option>
              </select>

            </div>
            <br>
            <br>
            <br>
            <br>
            <div class="col-sm-6" style="margin-bottom: 10px;border:1px solid #42A5F5;max-width: 375px;margin-left: 15px;;padding: 0;border-radius: 3px">
              <div style="width: 100%;background-color: #42A5F5;margin-bottom: 10px;text-align: center">
                <label style="margin-top: 5px;color: white">Un solo evento</label>

              </div>
              <div style="width: 100%;">
                <div style="display:flex; flex-direction: row; justify-content: center; align-items: center;margin-top: 22px">
                  <label style="margin-left: 20px;margin-top: 9px">Fecha:</label>
                  <input type="text" name="txtFechaLimiteUnSoloEventoProgramada" id="txtFechaLimiteUnSoloEventoProgramada" class="form-control"
                    style="max-width: 230px;margin-left: 15px" placeholder="" maxlength="50" pattern="^\s*[a-zA-Z0-9ñÑ@_.-*\s]+\s*">
                </div>

                <br>
              </div>

            </div>
            <div class="col-sm-6" style="margin-bottom: 10px;border:1px solid #42A5F5;max-width: 375px;margin-left: 15px;padding: 0 ;border-radius: 3px">
              <div style="width: 100%;background-color: #42A5F5;margin-bottom: 10px;text-align: center">
                <label style="margin-top: 5px;color: white">Recurrente</label>
              </div>
              <div style="width: 100%;">
                <div style="display:flex; flex-direction: row; justify-content: center; align-items: center">
                  <label style="margin-left: 20px;margin-top: 9px">Fecha de inicio:</label>
                  <input type="text" name="txtFechaInicioRecurrenteProgramada" id="txtFechaInicioRecurrenteProgramada" class="form-control"
                    style="max-width: 195px;margin-left: 18px" placeholder="" maxlength="50" pattern="^\s*[a-zA-Z0-9ñÑ@_.-*\s]+\s*">
                  <br>
                </div>

                <div style="display:flex; flex-direction: row; justify-content: center; align-items: center;margin-top: 5px">
                  <label style="margin-left: 0px;margin-top: 9px;margin-right: 10px">Recurrencia:</label>
                  <select name="PeriodicidadProgramada" class="form-control" id="PeriodicidadProgramada" style="width: 230px">
                    <option value="nada">Sin selección</option>
                    <option value="Diaria">Diaria</option>
                    <option value="Semanal">Semanal</option>
                    <option value="Quincenal">Quincenal</option>
                    <option value="Mensual">Mensual</option>
                    <option value="Anual">Anual</option>
                  </select>
                  <br>
                </div>
              </div>
              <br>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>

          <input type="submit" class="btn btn-primary" id="btnNewTaskProgramada" style="width: 213px;" value="Crear tarea programada"
          />
        </div>
      </form>
    </div>
  </div>
</div>


<div class="modal fade" id="ModalTerminarTarea">
  <div class="modal-dialog  modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header" style="background-color: #42a5f5 ;color: white">
        <h4 class="modal-title">Completar tarea</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <form enctype="multipart/form-data" action="Classes/Querys.php" id="frmNewTask" method="POST">
        <div class="modal-body">
          <div class="row">

            <div class="col-sm-12">
            <input type="text" name="TaskID1260" readonly id="TaskID1260" style="display: none" class="form-control"  pattern="^\s*[a-zA-Z0-9ñÑ@_.*\s]+\s*" required>
              <label>Comentario:</label>
              <textarea rows="2" type="text" name="txtComntCierre" id="txtComntCierre" class="form-control" placeholder="" pattern="^\s*[a-zA-Z0-9ñÑ@_.*\s]+\s*"></textarea>
            </div>
            <br>
            <br>
            <br>
            <br>
            <br>
            <div class="col-sm-6" style="margin-bottom: 10px">
              <label>Evidencia:</label>
              <input id="fileToUploadEndTask" name="fileToUploadEndTask" type="file">
            </div>

          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
          <input type="submit" class="btn btn-primary" id="btnEndTask" style="width: 213px;" value="Terminar" />
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  $('#txtFechaLimite').datepicker({
    uiLibrary: 'bootstrap4',
    format: 'yyyy-mm-dd'
  });

  $('#txtFechaLimiteUnSoloEvento').datepicker({
    uiLibrary: 'bootstrap4',
    format: 'yyyy-mm-dd'
  });
  $('#txtFechaLimiteRecurrente').datepicker({
    uiLibrary: 'bootstrap4',
    format: 'yyyy-mm-dd'
  });
  $('#txtFechaLimiteUnSoloEventoProgramada').datepicker({
    uiLibrary: 'bootstrap4',
    format: 'yyyy-mm-dd'
  });
  $('#txtFechaInicioRecurrenteProgramada').datepicker({
    uiLibrary: 'bootstrap4',
    format: 'yyyy-mm-dd'
  });


</script>


<!-- MODAL PARA MENSAJES  -->
<?php
if(!empty($_SESSION['ErrorMsg'])) {
  echo '<div class="modal fade" id="myModal">';
   echo '<div class="modal-dialog">';
   echo '<div class="modal-content">';
   echo '<div class="modal-header" style="background-color:'.$_SESSION['ColorMsg'].'">';
   echo '<h4 class="modal-title" style="color:white">'.$_SESSION['TitleMsg'].'</h4>';
   echo '<button type="button" class="close" data-dismiss="modal">&times;</button>';
   echo '</div>';
  echo '<div class="modal-body">';
   echo $_SESSION['ErrorMsg'];
   echo '</div>';
   echo '</div>';
   echo '</div>';
   echo '</div>';
   echo ' <button type="button" style="display: none;" class="btn btn-info btn-lg" id="pepe" data-toggle="modal" data-target="#myModal"></button>';
   echo "<script>  window.onload = function () { document.getElementById('pepe').click(); }  </script>";
}
unset($_SESSION['ErrorMsg']);
unset($_SESSION['ColorMsg']);
unset($_SESSION['TitleMsg']);



?>
