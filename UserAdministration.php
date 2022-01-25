<?php


try{
  include 'MasterPage.php';
  include "Classes/CConection.php";
  $Role=$_SESSION['AccountRole'];
  if($Role !="1"){
    header('Location: ../index.php');
  }
}
catch(Exception $e){
  header('Location: ../index.php');
}


$consulta = <<<SQL
  SELECT * FROM `users`
SQL;
$filas = mysqli_query($connect, $consulta);

$consultaEquipos2 = <<<SQL
  SELECT * FROM `equipos`
SQL;
$consultaEquipos22 = mysqli_query($connect, $consultaEquipos2);

$consulta2=<<<SQL
 SELECT DISTINCT FullName as 'Nombres' FROM users
SQL;
$DistintosMiembros =mysqli_query($connect,$consulta2);
$DistintosMiembros2 =mysqli_query($connect,$consulta2);

$consulta3=<<<SQL
 SELECT DISTINCT User as 'Nombres' FROM users
SQL;
$DistintosUsers =mysqli_query($connect,$consulta3);
 

?>

<head>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.css" />
  <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.js"></script>
</head>

<script type="text/javascript" charset="utf-8">
  $(document).ready(function () {
    $('#table').dataTable();
  });


  $(document).ready(function () {
    $('#table2').dataTable();
  });

</script>



<br>
<div class="container">
  <h2>Gestión de usuarios</h2>
  <br>
  <div id="accordion">
    <div class="card">
      <div class="card-header">
        <a class="card-link" data-toggle="collapse" href="#collapseOne">
          Agregar usuarios
        </a>
      </div>
      <div id="collapseOne" class="collapse" data-parent="#accordion">
        <div class="card-body">
          <form method="POST" id="flogin" action="Classes/CNewUser.php">
            <div class="row">
              <div class="col-6">
                <label>Nombre completo</label>
                <input type="text" name="txtFullName" id="txtFullName" class="form-control" placeholder="Nombre completo" maxlength="50"
                  pattern="^\s*[a-zA-Z0-9ñÑ_.*\s]+\s*" required>


              </div>

              <div class="col-6">
                <label>Usuario</label>
                <input type="text" value=" " name="txtUser1" id="txtUser1" class="form-control" placeholder="Usuario" maxlength="30" pattern="^\s*[a-zA-Z0-9ñÑ_.*\s]+\s*"
                  required>
              </div>
              <br>
              <br>
              <br>
              <br>
              <div class="col-6">
                <label>Contraseña</label>
                <input type="password" value="" name="txtpassword1" id="txtpassword1" class="form-control" placeholder="Contraseña" maxlength="50"
                  pattern="^\s*[a-zA-Z0-9ñÑ_.*\s]+\s*" required>


              </div>

              <div class="col-6">
                <label>Rol</label>
                <select name="txtRole" class="form-control" id="txtRole">
                  <option selected>Usuario</option>
                  <option>Administrador</option>
                </select>
              </div>
              <br>
              <br>
              <br>
              <br>
              <div class="col-6">
                <label>Email</label>
                <input type="text" value=" " name="txtEmail1" id="txtEmail1" class="form-control" placeholder="Email" required>
              </div>


              <br>
              <br>
              <br>
              <br>
              <div class="col-sm-12 ">
                <div class="float-right">
                  <button class="btn btn-default" type="reset" style="width: 150px">Limpiar</button>
                  <button type="submit" class="btn btn-primary" style="width: 150px">Registrar</button>
                </div>

              </div>


              <br>
              <br>
            </div>

          </form>

        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-header">
        <a class="collapsed card-link" data-toggle="collapse" href="#collapseTwo">
          Editar usuarios
        </a>
      </div>
      <div id="collapseTwo" class="collapse" data-parent="#accordion">
        <div class="card-body">


          <div class="panel panel-default">
            <div class="panel-body">
              <p class="alert fondo456" style="font-size: 20px;background-color: #90caf9 ;color: #fafafa ;border: 1px solid #90caf9 ">
                <span>Usuarios existentes</span>
              </p>
              <div class="table-responsive" style="border-radius: 10px;margin-top: 12px">
                <table class="table  table-bordered table-hover table-condensed tab" id="table" style="background-color: #ffffff;text-align: center;vertical-align: middle;">
                  <thead>
                    <tr style="background-color: #fafafa">
                      <th style="font-size: 14px;color: #222">ID</th>
                      <th style="font-size: 14px;color: #222">Usuario</th>
                      <th style="font-size: 14px;color: #222">Nombre</th>
                      <th style="font-size: 14px;color: #222">Rol</th>
                      <th style="font-size: 14px;color: #222">Email</th>
                      <th style="font-size: 14px;color: #222">Acciones</th>


                    </tr>
                  </thead>

                  <tbody>
                    <?php
$count = 0;
while ($columna = mysqli_fetch_assoc($filas)) {
    $count = $count + 1;
    echo "<tr >";
    echo "<td>$count</td>";
    echo "<td>$columna[User]</td>";
    echo "<td>$columna[FullName]</td>";
    echo "<td>$columna[Role]</td>";
    echo "<td>$columna[Email]</td>";
    echo "<td>  <input type='button' name='view' style='width: 68px' value='Editar  ' id='$columna[id]' class='btn btn-warning btn-sm view_data'    />
                              <form action='Classes/Querys.php' method='post'>
                              <input type='hidden' name='UserIDDelete' id='UserIDDelete' value='$columna[id]' style='display:false'>
                              <input type='submit' style='margin-top:5px'  value='Eliminar'  id='btnDeleteUser' class='btn btn-danger btn-sm'   />
                              </form></td>";
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



    <div class="card">
      <div class="card-header">
        <a class="collapsed card-link" data-toggle="collapse" href="#collapseThree">
          Equipos
        </a>
      </div>
      <div id="collapseThree" class="collapse" data-parent="#accordion">
        <div class="card-body">


          <div class="panel panel-default">
            <div class="panel-body">
              <p class="alert fondo456" style="font-size: 20px;background-color: #90caf9 ;color: #fafafa ;border: 1px solid #90caf9 ">
                <span>Gestion de equipos</span>
              </p>

              <h4 style="font-size: 20px;margin-bottom: 12px">Nueva asignación </h4>

              <form method="POST" id="flogin" action="Classes/Querys.php">
                <div class="row">
                  <div class="col-6">
                    <label>Nombre completo</label>
                    <?php
                    echo '<select name="UsuarioParaEquipo" class="form-control" id="UsuarioParaEquipo" >';
                      while($row=mysqli_fetch_assoc($DistintosMiembros))
                      {
                        $Nombre=$row['Nombres'];
                        $consulta4="SELECT * FROM `users` WHERE `FullName`='$Nombre'";
                        
                        $UsuarioDeNombre =mysqli_query($connect,$consulta4);
                        $result2 = mysqli_fetch_array($UsuarioDeNombre); 
                        echo '<option value="' . htmlspecialchars($row['Nombres']) . '">' . htmlspecialchars($row['Nombres'])   . '</option>';
                      }
                      echo '</select>';
                    
                      ?>

                  </div>
                  <br>
                  <br>
                  <br>
                  <br>

                  <div class="col-6">
                    <label>Responsable</label>


                    <?php
                    echo '<select name="Responsable1" class="form-control" id="Responsable1" >';
                    while($row2=mysqli_fetch_assoc($DistintosMiembros2))
                    {
                      $Nombre=$row2['Nombres'];
                      $consulta5="SELECT * FROM `users` WHERE `FullName`='$Nombre'";
                      
                      $UsuarioDeNombre =mysqli_query($connect,$consulta5);
                      $result3 = mysqli_fetch_array($UsuarioDeNombre); 
                      echo '<option value="' . htmlspecialchars($row2['Nombres']) . '">' . htmlspecialchars($row2['Nombres'])   . '</option>';
                    }
                    echo '</select>';
                  ?>

                  </div>
                  <br>
                  <br>
                  <br>
                  <br>
                  <div class="col-sm-12 ">
                    <div class="float-right">

                      <button type="submit" class="btn btn-primary" style="width: 150px">Ligar</button>
                    </div>

                  </div>


                  <br>
                  <br>
                </div>

              </form>


              <hr>

              <div class="table-responsive" style="border-radius: 10px;margin-top: 12px">
                <table class="table  table-bordered table-hover table-condensed tab" id="table2" style="background-color: #ffffff;text-align: center;vertical-align: middle;">
                  <thead>
                    <tr style="background-color: #fafafa">
                      <th style="font-size: 14px;color: #222">#</th>
                      <th style="font-size: 14px;color: #222">ID</th>
                      <th style="font-size: 14px;color: #222">Usuario</th>
                      <th style="font-size: 14px;color: #222">Responsable</th>
                      <th style="font-size: 14px;color: #222">Acciones</th>


                    </tr>
                  </thead>

                  <tbody>
                    <?php
$count = 0;
while ($columna = mysqli_fetch_assoc($consultaEquipos22)) {
    $count = $count + 1;
    echo "<tr >";
    echo "<td>$count</td>";
    echo "<td>$columna[id]</td>";
    echo "<td>$columna[Usuario]</td>";
    echo "<td>$columna[Responsable]</td>";
    echo "<td>
                              <form action='Classes/Querys.php' method='post'>
                              <input type='hidden' name='IDTeam' id='IDTeam' value='$columna[id]' style='display:false'>
                              <input type='submit' value='Eliminar'  id='btnDeleteUser' class='btn btn-danger btn-sm'   />
                              </form></td>";
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








    <div class="card">
      <div class="card-header">
        <a class="collapsed card-link" data-toggle="collapse" href="#collapseFour">
          Reportes para el administrador
        </a>
      </div>
      <div id="collapseFour" class="collapse" data-parent="#accordion">
        <div class="card-body">


          <div class="panel panel-default">
            <div class="panel-body">
              <p class="alert fondo456" style="font-size: 20px;background-color: #90caf9 ;color: #fafafa ;border: 1px solid #90caf9 ">
                <span>Reportes</span>
              </p>


              <div class="row" style="text-align: center">

                <br>
                <div class="col-2" style="background-color: transparent">
                  <form method="POST" action="Classes/Querys.php">
                    <input type='hidden'  value='Go'  name='btnAllTasks'/>
                    <button type="submit" id="btnAllTasks2" class="btn btn-outline-primary float-left">Descargar todas las tareas</button>
                  </form>
                </div>


                <div class="col-4" style="background-color: transparent;margin-left: 5px">
                  <form method="POST" action="Classes/Querys.php">
                    <input type='hidden'  value='Go'  name='btnAllProgrammedTasks'/>
                    <button type="submit" id="btnAllProgrammedTasks2" class="btn btn-outline-primary float-right">Descargar todas las tareas programadas</button>
                  </form>
                </div>

                <div class="col-3" style="background-color: transparent;margin-left: 22px">
                  <form method="POST" action="Classes/Querys.php">
                    <input type='hidden'  value='Go'  name='btnAllDeletedTasks'/>
                    <button type="submit" id="btnAllProgrammedTasks2" class="btn btn-outline-primary float-right">Descargar todas las tareas eliminadas</button>
                  </form>
                </div>


              </div>

              <hr>


            </div>
          </div>


        </div>
      </div>
    </div>


  </div>
</div>
<br>
<br>
<br>

<!-- MODAL PARA MENSAJES -->
<?php
if (!empty($_SESSION['ErrorMsg'])) {
    echo '<div class="modal fade" id="myModal">';
    echo '<div class="modal-dialog">';
    echo '<div class="modal-content">';
    echo '<div class="modal-header" style="background-color:' . $_SESSION['ColorMsg'] . '">';
    echo '<h4 class="modal-title" style="color:white">' . $_SESSION['TitleMsg'] . '</h4>';
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



<!-- MODAL DE EDICION DE USUARIOS -->
<div class="modal fade" id="myModalNewUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #90caf9">
        <h5 class="modal-title" id="exampleModalLabel" style="color: #fafafa">Editar datos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" id="flogin" action="Classes/UpdateUser.php">

        <div class="modal-body" id="UserBody">

          <div class="row">


            <div class="col-sm-6">
              <label>Usuario:</label>
              <input id="txtNombre1" name="txtNombre1" type="text" class="form-control" readonly="true">

            </div>

            <div class="col-sm-6">
              <label>Nombre:</label>
              <input id="txtNombreCompleto1" name="txtNombreCompleto1" type="text" class="form-control">

            </div>
            <br>
            <br>
            <br>
            <br>
            <div class="col-sm-6">
              <label>Rol:</label>
              <input id="txtroleedit" name="txtroleedit" type="text" class="form-control">
            </div>

            <br>
            <br>
            <br>
            <br>
            <div class="col-sm-6">
              <label>Email:</label>
              <input id="txtEmailEdit" name="txtEmailEdit" type="text" class="form-control">
            </div>

          </div>


        </div>
        <div class="modal-footer">

          <button type="submit" class="btn btn-primary">Actualizar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- SCRIPT PARA JALAR DATOS Y ABRIR MODAL PARA EDITAR USUARIO -->
<script>
  $(document).ready(function () {
    $('.view_data').click(function () {
      var UserID = $(this).attr("id");
      $('#myModalNewUser').modal("show");
      $.ajax({
        data: { UserID: UserID },
        url: 'Classes/GetUser.php',
        type: 'post',
        dataType: 'JSON',
        success: function (data) {
          $('#txtNombre1').val(data[0].User);
          $('#txtNombreCompleto1').val(data[0].FullName);
          $('#txtroleedit').val(data[0].Role);
          $('#txtEmailEdit').val(data[0].Email);
        }
      });
    });
  });
</script>