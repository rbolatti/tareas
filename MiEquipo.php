<?php
    include 'MasterPage.php';
    include("Classes/CConection.php");
    $User= $_SESSION['User'];
    $Role= $_SESSION['AccountRole']; 
    $UserFullName= $_SESSION['FullName']; 


    function encrypt_decrypt($action, $string) {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_key = 'fer1fer45f1488566';
        $secret_iv = '1225615s1d6c6c156';
        // hash
        $key = hash('sha256', $secret_key);
        
        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        if ( $action == 'encrypt' ) {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if( $action == 'decrypt' ) {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }
        return $output;
      }
    


$consulta2=<<<SQL
SELECT `Usuario` FROM `equipos` WHERE `Responsable`='$UserFullName'
SQL;
$DistintosMiembros =mysqli_query($connect,$consulta2);

if(isset($_SESSION['UsuarioAVizualizar'] ))
{  
$Usuario56165=($_SESSION['UsuarioAVizualizar']);
$decrypted_txt = encrypt_decrypt('decrypt', $Usuario56165);

///////////
$consulta4="SELECT * FROM `users` WHERE `User`='$decrypted_txt'";                  
$UsuarioDeNombre =mysqli_query($connect,$consulta4);
$result22 = mysqli_fetch_array($UsuarioDeNombre); 
///////////

$Vizualizado2=$result22['FullName'];
$Vizualizado3 = encrypt_decrypt('encrypt', $Vizualizado2);

echo '$(document).ready(function () {    document.getElementById("<?php echo $Usuario56165; ?>").selected = "true";  });';

$TareasAsignadas=<<<SQL
SELECT * FROM `tareascargadas` WHERE `Asignador`='$decrypted_txt' AND `Asignado` != '$decrypted_txt'
SQL;
$TareasAsignadas2 =mysqli_query($connect,$TareasAsignadas);

$TareasQueHaAsignado=<<<SQL
SELECT * FROM `tareascargadas` WHERE `Asignado`='$decrypted_txt' 
SQL;
$TareasQueHaAsignado2 =mysqli_query($connect,$TareasQueHaAsignado);

unset($_SESSION['UsuarioAVizualizar']);
} else{
    unset($_SESSION['UsuarioAVizualizar']);
    $TareasAsignadas=<<<SQL
SELECT * FROM `tareascargadas` WHERE `Asignado`='xxxxxx'
SQL;
$TareasAsignadas2 =mysqli_query($connect,$TareasAsignadas);
$TareasQueHaAsignado=<<<SQL
SELECT * FROM `tareascargadas` WHERE `Asignador`='xxxxxx'
SQL;
$TareasQueHaAsignado2 =mysqli_query($connect,$TareasQueHaAsignado);




$Vizualizado2="";

}

  
?>

<head>


    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.css" />
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.js"></script>

    <script type="text/javascript" src="Assets/js/MiEquipo.js"></script>



</head>


<script type="text/javascript">


$(document).ready(function () {
    document.getElementById("<?php echo $Usuario56165; ?>").selected = "true";
  });



 function SelectVizualized() {
    // document.getElementById("idbUgvWlZhemFQMllHNXJBUkVTVlUxdz09").selected = "true";
 alert("ddd");
 }


</script>

<div class="container-fluid" style="margin-top: 100px;border: 1px solid #64b5f6  ;border-radius: 5px;padding: 15px;max-width: 1850px;">
    <div class="Row">
        <p class="alert fondo456" style="font-size: 20px;background-color: #ef9a9a    ;color: #fafafa ;border: 1px solid #64b5f6   ">
            <span>Tareas de mi equipo</span>
        </p>

        <div class="col-4" style="text-align: center">

            <script type="text/javascript">
                $(document).ready(function () {
                    var e = document.getElementById("UsuarioAVizualizar");
                    var strUser = e.options[e.selectedIndex].value;
                    document.getElementById('UsuarioAVizualizar2').value = strUser;
                });
                function UsuarioAVer() {
                    var e = document.getElementById("UsuarioAVizualizar");
                    var strUser = e.options[e.selectedIndex].value;
                    document.getElementById('UsuarioAVizualizar2').value = strUser;
                }
            </script>

            <label style="float: left; margin-top: 7px;margin-right: 10px">Usuario: </label>
            <form action="Classes/Querys.php" method="POST">
                <input type='hidden' value='' id="UsuarioAVizualizar2" name="UsuarioAVizualizar2" />
                <input type='submit' class="btn btn-outline-primary" style="float: right" value="Vizualizar" />
            </form>
            <div style="overflow: hidden; padding-right: .1em;">
                <?php
                        echo '<select onchange="UsuarioAVer()" name="UsuarioAVizualizar" class="form-control" id="UsuarioAVizualizar" style="width:400px" >';
                        while($row=mysqli_fetch_assoc($DistintosMiembros))
                        {  
                            $Nombre=$row['Usuario'];
                            $consulta4="SELECT * FROM `users` WHERE `FullName`='$Nombre'";
                            $UsuarioDeNombre =mysqli_query($connect,$consulta4);
                            $result2 = mysqli_fetch_array($UsuarioDeNombre); 

                            $Nombre=$row['Usuario'];
                            $consulta4="SELECT * FROM `users` WHERE `FullName`='$Nombre'";
                            $UsuarioDeNombre =mysqli_query($connect,$consulta4);
                            $result2 = mysqli_fetch_array($UsuarioDeNombre); 
                            $encrypted_txt = encrypt_decrypt('encrypt', $result2['User']);
                            echo '<option id="' .$encrypted_txt.'" value="' .$encrypted_txt.'">' . htmlspecialchars($row['Usuario'])   . '</option>';
                        }
                        echo '</select>';
                    ?>
            </div>​

        </div>

        <hr>


        <div id="accordion" style="margin-top: 20px">
            <div class="card">
                <div class="card-header">
                    <a class="card-link" data-toggle="collapse" href="#collapseOne">
                        Tareas asignadas al usuario <label id="lblVizualizado"><?php echo $Vizualizado2 ?></label>
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
                            <table class="table  table-bordered table-hover table-condensed tab" id="table23" style="background-color: #ffffff;text-align: center;vertical-align: middle;">
                                <thead>
                                    <tr style="background-color: #90caf9 ">
                                        <!-- <th style="font-size: 14px;color: #222">Numero</th> -->
                                        <th style="font-size: 14px;color: #222;width: 20px">Folio</th>
                                        <th style="font-size: 14px;color: #222;width: 70px">Fecha</th>
                                        <th style="font-size: 14px;color: #222;width: 60px">Asignador</th>
                                        <th style="font-size: 14px;color: #222">Titulo</th>
                                        <th style="font-size: 14px;color: #222">Descripción</th>
                                        <th style="font-size: 14px;color: #222;width: 60px">Asignado</th>
                                        <th style="font-size: 14px;color: #222;width: 90px">Fecha Limite</th>
                                        <th style="font-size: 14px;color: #222;width: 90px">Ver</th>
                                        <th style="font-size: 14px;color: #222;width: 1px">Adj.</th>
                                        <th style="font-size: 14px;color: #222;width: 1px">Vencida</th>
                                        <th style="font-size: 14px;color: #222;width: 90px">Finalizada</th>
                                        <th style="font-size: 14px;color: #222;width: 1px">CmntCierre</th>
                                        <th style="font-size: 14px;color: #222;width: 1px">Evidencia</th>
                                        <th style="font-size: 14px;color: #222;width: 90px">FechaDeTermino</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $count=0;
                                        while ($columna=mysqli_fetch_assoc($TareasQueHaAsignado2))
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

                                             
                                            if($columna['Terminada']=="1"){
                                                echo "<td><label>Si</label></td>";
                                            }else{
                                                echo "<td><label>No</label></td>";
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


                                            echo "<td>$columna[FechaDeTermino]</td>";
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
                    <a class="card-link" data-toggle="collapse" href="#collapseOne">
                        Tareas que ha asignado <label id="lblVizualizado"><?php echo $Vizualizado2 ?></label>
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
                            <table class="table  table-bordered table-hover table-condensed tab" id="table22" style="background-color: #ffffff;text-align: center;vertical-align: middle;">
                                <thead>
                                    <tr style="background-color: #90caf9 ">
                                        <!-- <th style="font-size: 14px;color: #222">Numero</th> -->
                                        <th style="font-size: 14px;color: #222;width: 20px">Folio</th>
                                        <th style="font-size: 14px;color: #222;width: 70px">Fecha</th>
                                        <th style="font-size: 14px;color: #222;width: 60px">Asignador</th>
                                        <th style="font-size: 14px;color: #222">Titulo</th>
                                        <th style="font-size: 14px;color: #222">Descripción</th>
                                        <th style="font-size: 14px;color: #222;width: 60px">Asignado</th>
                                        <th style="font-size: 14px;color: #222;width: 90px">Fecha Limite</th>
                                        <th style="font-size: 14px;color: #222;width: 90px">Ver</th>
                                        <th style="font-size: 14px;color: #222;width: 1px">Adj.</th>
                                        <th style="font-size: 14px;color: #222;width: 1px">Vencida</th>
                                        <th style="font-size: 14px;color: #222;width: 90px">Finalizada</th>
                                        <th style="font-size: 14px;color: #222;width: 1px">CmntCierre</th>
                                        <th style="font-size: 14px;color: #222;width: 1px">Evidencia</th>
                                        <th style="font-size: 14px;color: #222;width: 90px">FechaDeTermino</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $count=0;
                                        while ($columna=mysqli_fetch_assoc($TareasAsignadas2))
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

                                              

                                            if($columna['Terminada']=="1"){
                                                echo "<td><label>Si</label></td>";
                                            }else{
                                                echo "<td><label>No</label></td>";
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
                                            echo "<td>$columna[FechaDeTermino]</td>";
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

<br>
<br>


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
              <input type="text" name="txtUserAsignadorDeTareaShow" id="txtUserAsignadorDeTareaShow" class="form-control" value="<?php echo $User; ?>" readonly placeholder="Nombre completo" pattern="^\s*[a-zA-Z0-9ñÑ@_.*\s]+\s*" required>
            </div>
            <div class="col-sm-6" style="margin-top: 5px">
              <label>Titulo:</label>
              <input type="text" name="txtTituloShow" id="txtTituloShow" class="form-control" placeholder="Nombre completo" maxlength="50" pattern="^\s*[a-zA-Z0-9ñÑ@_.*\s]+\s*">
            </div>
            <br>            <br>            <br>            <br>
            <div class="col-sm-12" style="margin-bottom: 15px">
              <label>Descripcion:</label>
              <textarea rows="8" type="text" name="txtDescripcionShow" id="txtDescripcionShow" class="form-control" placeholder="Nombre completo"
                pattern="^\s*[a-zA-Z0-9ñÑ@_.*\s]+\s*"></textarea>
            </div>
            <br>            <br>            <br>            <br>            <br>            <br>            <br>
            <div class="col-sm-6">
              <label>Asignado:</label>
              <input type="text" name="txtAsignadoShow" id="txtAsignadoShow" class="form-control" placeholder="Nombre completo" maxlength="50" pattern="^\s*[a-zA-Z0-9ñÑ@_.*\s]+\s*">
            </div>
            <div class="col-sm-6" style="margin-bottom: 10px">
              <label>Fecha limite:</label>
              <input type="text" name="txtFechaLimiteShow" id="txtFechaLimiteShow" class="form-control" placeholder="Nombre completo" maxlength="50" pattern="^\s*[a-zA-Z0-9ñÑ@_.-*\s]+\s*">
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