
<!doctype html>
<html lang="en">

<head>
  <title>Tasks</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" href="Assets/img/icon.png">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<style>

body {
   background-image: url("Assets/img/doodles.png");
   background-color: #cccccc;
}
</style>
<body style="background-color: #fafafa">

  <div class="container">

    <div class="row"> 
      <div class="col-sm-12">


        <div class="col-sm-6 mx-auto" style=" height: 500px;margin-top: 150px;background-color: #fafafa; color: black; border-radius: 8px; text-align: center;border: 1px solid #33b5e5 ">
          <br>
          <h3>Tasks</h3>
     


          <img src="Assets/img/user.png" class="img-circle img-responsive" alt="" style="max-width: 170px" />
        
          <br>
<br>
          <form method="POST" id="flogin" action="Classes/CLogin.php">

            <label>Usuario:</label>
            <input type="text" name="user" id="name" class="form-control" placeholder="Usuario" maxlength="25" pattern="^\s*[a-zA-Z0-9ñÑ_.*\s]+\s*" required>
            <label style="margin-top: 10px  ">Contraseña:</label>
            <input type="password" name="pw" id="pw" class="form-control" placeholder="Contraseña" maxlength="25" pattern="^\s*[a-zA-Z0-9ñÑ_.*\s]+\s*"
              required>
            <p id="mensaje" style="color: red;margin-top: 10px"></p>

            <?php session_start(); ?>
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
               echo "<script>  window.onload = function(){  document.getElementById('pepe').click();}  </script>";
            }
            unset($_SESSION['ErrorMsg']);
            unset($_SESSION['ColorMsg']);
            unset($_SESSION['TitleMsg']);
            ?>

            <button class="btn btn-default" type="reset" style="width: 213px" >Limpiar</button>
            <button type="submit" class="btn btn-primary" style="width: 213px">Ingresar</button>

          </form>


          <br>
          <br>
          
          <br>
        </div>
      </div>

    </div>

  </div>
  
      
        
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
    crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    crossorigin="anonymous"></script>
</body>

</html>