<?php 
try{
  session_start(); 
  $User= $_SESSION['FullName'];  
  $Role= $_SESSION['AccountRole']; 
}catch(Exception $e){


  header('Location: index.php');
}

?>
<!doctype html>
<html lang="en">

<head>
  <title>IqorTasks</title>
  <meta charset="utf-8">
  <link rel="icon" href="Assets/img/icon.png">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ"
    crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
    crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
    crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    crossorigin="anonymous"></script>

</head>

<body>


  <nav class="navbar navbar-expand-sm   fixed-top" style="z-index:900;background-color:   #2E2E2E">
    <!-- Brand -->
    <a class="navbar-brand" href="#">
      <img src="Assets/img/f.png" alt="Smiley face" style="margin-left: 5px" height="42" width="42">


    </a>

    <!-- Links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="Main.php">Principal</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="Reportes.php">Reportes</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="MiEquipo.php">Mi equipo</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
          aria-expanded="false">
          Historial
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="TareasAsignadas.php">Tareas recibidas</a>
          <a class="dropdown-item" href="MisTareasCreadas.php">Tareas que he asignado</a>

        </div>
      </li>

     


      <!-- Dropdown -->

    </ul>
    <ul class="navbar-nav mr-auto">
    </ul>
    <ul class="navbar-nav">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
          <?php  echo $User;  ?>
        </a>
        <div class="dropdown-menu">


        <?php
          if($Role=="1"){
            $_SESSION['AccountRole']=$Role;
            echo '<a class="dropdown-item" href="UserAdministration.php">Gestión de usuarios</a>';
          }
        ?>
          


          <a class="dropdown-item" href="Classes\LogOut.php">Cerrar Sesión</a>


        </div>
      </li>
    </ul>
  </nav>





</body>

</html>