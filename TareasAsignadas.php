<?php
  include 'MasterPage.php';
  include("Classes/CConection.php");
  $User= $_SESSION['User'];
  $Role= $_SESSION['AccountRole']; 
  $UserFullName= $_SESSION['FullName']; 

  $consulta2=<<<SQL
SELECT * FROM `tareascargadas` WHERE `Asignado`='$User'  
SQL;
$Tareas =mysqli_query($connect,$consulta2);
?>


<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.css" />
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.js"></script>

<script type="text/javascript" src="Assets/js/TareasAsignadas.js"></script>
<div class="container-fluid" style="max-width: 1850px;background-color: transparent;padding: 15px;margin-top: 90px;border: 1px solid #4285F4;border-radius: 5px">
  <div class="row">
    <div class="col-sm-12">
      <div class="alert alert-primary" role="alert" style='font-size: 25px;'>
        Tareas asignadas
      </div>
      <div class="table-responsive" style="border-radius: 10px;margin-top: 20px">
        <table class="table  table-bordered table-hover table-condensed tab" id="table" style="background-color: #ffffff;text-align: center;vertical-align: middle;">
          <thead>
            <tr style="background-color: #fafafa">
              <!-- <th style="font-size: 14px;color: #222">Numero</th> -->
              <th style="font-size: 14px;color: #222;width: 20px">Folio</th>
              <th style="font-size: 14px;color: #222;width: 70px">Fecha</th>
              <th style="font-size: 14px;color: #222;width: 60px">Asignador</th>
              <th style="font-size: 14px;color: #222">Titulo</th>
              <th style="font-size: 14px;color: #222">Descripción</th>
              <th style="font-size: 14px;color: #222;width: 60px">Asignado</th>
              <th style="font-size: 14px;color: #222;width: 90px">Fecha Limite</th>
              <th style="font-size: 14px;color: #222;width: 90px">Finalizada</th>
              <th style="font-size: 14px;color: #222;width: 90px">FechaDeTermino</th>
              <th style="font-size: 14px;color: #222;width: 20px">Ver</th>
              <th style="font-size: 14px;color: #222;width: 1px">Adj.</th>
              <th style="font-size: 14px;color: #222;width: 1px">Vencida</th>
              <th style="font-size: 14px;color: #222;width: 1px">CmntCierre</th>
              <th style="font-size: 14px;color: #222;width: 1px">Evidencia</th>
              <th style="font-size: 14px;color: #222;width: 70px;">Acciones</th>

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
                                            echo "<td>";
                                            if(strlen($columna['Descripcion']) > 200){
                                              echo substr($columna['Descripcion'], 0, 200).'...   '.'<span style="color: #4285F4">Mas</span>';echo "</td>";
                                            }else{
                                              echo $columna['Descripcion'] ;
                                            }
                                            
                                            echo "<td>$columna[Asignado]</td>";
                                            echo "<td>$columna[FechaLimite]</td>";
                                            if($columna['Terminada']=="1"){
                                                echo "<td><label>Si</label></td>";
                                            }else{
                                                echo "<td><label>No</label></td>";
                                            }
                                            echo "<td>$columna[FechaDeTermino]</td>";
                                            echo "<td><span align='right'><a class='VerModalTareaDesglosada' id='$columna[id]'><i class='far fa-window-restore  fa-lg'></xi></a></span></td>";

                                            if($columna['Adjunto']==""){
                                              echo "<td><label></label></td>";
                                            }else{
                                              echo "<form action='Classes/Querys.php' method='post'>";
                                              echo "<input type='hidden'  value='$columna[Adjunto]'  name='NombreFile'/>";
                                              echo "<td><button type='submit' class=' btn btn-success far fa-file-alt  fa-lg btn-sm'>       </button></td>";
                                              echo "</form>";
                                            }
                                            if ($columna['Vencida']=="0"){
                                              echo "<td><label>No</label></td>";
                                            }else{
                                              echo "<td><label>Si</label></td>";
                                            }
                                            echo "<td>$columna[ComentarioDeCierre]</td>";

                                            if($columna['EvidenciaDeCierreAdjunto']==""){
                                              echo "<td><label></label></td>";
                                            }else{
                                              echo "<form action='Classes/Querys.php' method='post'>";
                                              echo "<input type='hidden'  value='$columna[EvidenciaDeCierreAdjunto]'  name='NombreFileEndTask'/>";
                                              echo "<td><button type='submit' class=' btn btn-success far fa-file-alt  fa-lg btn-sm'>       </button></td>";
                                              echo "</form>";
                                            }


                                            if ($columna['Asignador']==$User){
                                              echo "<form action='Classes/Querys.php' method='post'>";
                                              echo "<td><input type='hidden'  value='$columna[id]'  name='IdTareaAEliminarHistorialTareasAsignadas'/>";
                                              echo "<input type='submit'  value='Eliminar'  style='width: 72px' class='btn btn-default btn-sm '   />";
                                            }else{
                                                echo "<td>  <label>Ninguna</label>";
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
<br><br><br><br>
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
              <input type="text" name="txtUserAsignadorDeTareaShow" id="txtUserAsignadorDeTareaShow" class="form-control" value="<?php echo $User; ?>"
                readonly placeholder="Nombre completo" pattern="^\s*[a-zA-Z0-9ñÑ@_.*\s]+\s*" required>
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
              <input type="text" name="txtFechaLimiteShow" id="txtFechaLimiteShow" class="form-control" placeholder="Nombre completo" maxlength="50"
                pattern="^\s*[a-zA-Z0-9ñÑ@_.-*\s]+\s*">
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