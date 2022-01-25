<?php
session_start();
include("CConection.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

// Cuenta: tasksiqor@gmail.com
// Contraeña: Tareas1260*
// Tareas2020*P

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

// ELIMINAR USUARIO
    if(($_SERVER["REQUEST_METHOD"] == "POST") &&  isset($_POST['UserIDDelete']))
    {
      EliminarUsuario($_POST['UserIDDelete']);
    }

    // ELIMINAR MiembroDeEquipo
    if(($_SERVER["REQUEST_METHOD"] == "POST") &&  isset($_POST['IDTeam']))
    {
      EliminarMiembroEquipo($_POST['IDTeam']);
    }
    // VIZUALIZAR TAREAS DE USUARIO
    if(($_SERVER["REQUEST_METHOD"] == "POST") &&  isset($_POST['UsuarioAVizualizar2']))
    {
      UsuarioAVizualizar($_POST['UsuarioAVizualizar2']);
    }
    // NUEVA ASIGNACION PARA EQUIPO
    if(($_SERVER["REQUEST_METHOD"] == "POST") &&  isset($_POST['UsuarioParaEquipo']) &&  isset($_POST['Responsable1']))
    {
      NuevaAsignacion($_POST['UsuarioParaEquipo'],$_POST['Responsable1']);
    }

    // AGREGAR NUEVA TAREA
    if(($_SERVER["REQUEST_METHOD"] == "POST") &&  isset($_POST['txtUserAsignadorDeTarea']))
    {
      $txtUserAsignadorDeTarea=$_POST['txtUserAsignadorDeTarea'];
      $txtTitulo=$_POST['txtTitulo'];
      $txtDescripcion=$_POST['txtDescripcion'];
      $FullNameAsignado=$_POST['FullNameAsignado'];
      $txtFechaLimite=$_POST['txtFechaLimite'];
      NuevaTarea($txtUserAsignadorDeTarea,$txtTitulo,$txtDescripcion,$FullNameAsignado,$txtFechaLimite);
    }
    // AGREGAR NUEVA TAREA PROGRAMADA
    if(($_SERVER["REQUEST_METHOD"] == "POST") &&  isset($_POST['txtUserAsignadorDeTareaProgramada']))
    {
      $txtUserAsignadorDeTarea=$_POST['txtUserAsignadorDeTareaProgramada'];
      $txtTitulo=$_POST['txtTituloProgramada'];
      $txtDescripcion=$_POST['txtDescripcionProgramada'];
      $FullNameAsignado=$_POST['FullNameAsignado2Programada'];
      $slctPeriodicidad1Programada=$_POST['slctPeriodicidad1Programada'];
      if($slctPeriodicidad1Programada=="Un solo evento"){
        $txtFechaInicioRecurrenteProgramada=$_POST['txtFechaLimiteUnSoloEventoProgramada'];
        NuevaTareaProgramada($txtUserAsignadorDeTarea,$txtTitulo,$txtDescripcion,$FullNameAsignado,$slctPeriodicidad1Programada,$txtFechaInicioRecurrenteProgramada,"No aplica");
      }elseif($slctPeriodicidad1Programada=="Recurrente"){
        $txtFechaInicioRecurrenteProgramada=$_POST['txtFechaInicioRecurrenteProgramada'];
        $PeriodicidadProgramada=$_POST['PeriodicidadProgramada'];
        NuevaTareaProgramada($txtUserAsignadorDeTarea,$txtTitulo,$txtDescripcion,$FullNameAsignado,$slctPeriodicidad1Programada,$txtFechaInicioRecurrenteProgramada,$PeriodicidadProgramada);
      }else{
        $_SESSION['ErrorMsg']='Por favor completa todos los campos.';
        $_SESSION['ColorMsg']='#ffbb33';
        $_SESSION['TitleMsg']='Campos incompletos';
        header('Location: ../Main.php');
      }

    }

// ELIMINAR TAREA
    if(($_SERVER["REQUEST_METHOD"] == "POST") &&  isset($_POST['IdTareaAEliminar']))
    {
      EliminarTarea($_POST['IdTareaAEliminar']);
    }
    //ELIMINAR TAREA PROGRAMADA
    if(($_SERVER["REQUEST_METHOD"] == "POST") &&  isset($_POST['IdTareaProgramadaAEliminar']))
    {
      EliminarTareaProgramada($_POST['IdTareaProgramadaAEliminar']);
    }

    //TAREA A TERMINAR
    if(($_SERVER["REQUEST_METHOD"] == "POST") &&  isset($_POST['TaskID1260']))
    {
      $IdTarea=$_POST['TaskID1260'];
      $Cmnt=$_POST['txtComntCierre'];
      TerminarTarea($IdTarea,$Cmnt);
    }

    // TAREA DESGLOSADA
    if(($_SERVER["REQUEST_METHOD"] == "POST") &&  isset($_POST['TaskIDShow']))
    {

      TareaDesglosada($_POST['TaskIDShow']);
    }

     // TAREA PROGRAMADA DESGLOSADA
     if(($_SERVER["REQUEST_METHOD"] == "POST") &&  isset($_POST['TaskProgrammedIDShow']))
     {
      TareaProgrammedDesglosada($_POST['TaskProgrammedIDShow']);
     }


    // ELIMINAR TAREA DEL HISTORIAL DE TAREAS ASIGNADAS
    if(($_SERVER["REQUEST_METHOD"] == "POST") &&  isset($_POST['IdTareaAEliminarHistorialTareasAsignadas']))
    {
      EliminarTareaHistorialTareasAsignadas($_POST['IdTareaAEliminarHistorialTareasAsignadas']);
    }
      // ELIMINAR TAREA DEL HISTORIAL DE TAREAS QUE HE ASIGNADO
      if(($_SERVER["REQUEST_METHOD"] == "POST") &&  isset($_POST['IdTareaAEliminarHistorialTareasQueHeAsignado']))
      {
        IdTareaAEliminarHistorialTareasQueHeAsignado($_POST['IdTareaAEliminarHistorialTareasQueHeAsignado']);
      }
    // TAREA DESGLOSADA EN HISTORIAL TAREAS ASIGNADAS
    if(($_SERVER["REQUEST_METHOD"] == "POST") &&  isset($_POST['TaskIDShowHistoTarAsig']))
    {
      TareaDesglosadaHistorialTareasAsignadas($_POST['TaskIDShowHistoTarAsig']);
    }

     // ExcelMisTareasAsignadas
     if(($_SERVER["REQUEST_METHOD"] == "POST") &&  isset($_POST['ExcelMisTareasAsignadas']))
     {
       $decrypted_txt = encrypt_decrypt('decrypt', $_POST['ExcelMisTareasAsignadas']);

      ExcelMisTarasAsignadas($decrypted_txt);
     }

      // Excel2
    if(($_SERVER["REQUEST_METHOD"] == "POST") &&  isset($_POST['ExcelTareasQueHeAsignado']))
    {

      $decrypted_txt = encrypt_decrypt('decrypt', $_POST['ExcelTareasQueHeAsignado']);
      ExcelTareasQueHeAsignado($decrypted_txt);
    }

    // DESCARGAR ARCHIVO ADJUNTO
    if(($_SERVER["REQUEST_METHOD"] == "POST") &&  isset($_POST['NombreFile']))
    {
      DownloadFile($_POST['NombreFile']);
    }

    // DESCARGAR ARCHIVO ADJUNTO EVIDENCIA
    if(($_SERVER["REQUEST_METHOD"] == "POST") &&  isset($_POST['NombreFileEndTask']))
    {
      DownloadFileEndTask($_POST['NombreFileEndTask']);
    }



         // ExcelTodasLasTareas
    if(($_SERVER["REQUEST_METHOD"] == "POST") &&  isset($_POST['btnAllTasks']))
     {


      ExcelTodasLasTareas($_POST['btnAllTasks']);
     }

    // ExcelTodasLasTareasProgramas
    if(($_SERVER["REQUEST_METHOD"] == "POST") &&  isset($_POST['btnAllProgrammedTasks']))
    {

      btnAllProgrammedTasks($_POST['btnAllProgrammedTasks']);
    }

    // ExcelTodasLasTareasEliminadas
    if(($_SERVER["REQUEST_METHOD"] == "POST") &&  isset($_POST['btnAllDeletedTasks']))
    {
      btnAllDeletedTasks($_POST['btnAllDeletedTasks']);
    }

    // --------------------------------------------------------------------------------------------------------------



    function EliminarUsuario($UserID){
      include("CConection.php");
      $connect = mysqli_connect($host_name, $user_name, $password) or die ("Problemas con el servidor de la base de datos.");
      mysqli_select_db($connect, $database);
      $sqlCommand = "DELETE FROM users WHERE id='$UserID'";
      $query = mysqli_query($connect, $sqlCommand) or die(mysqli_error("Fallo en la consulta a la base de datos."));
      $_SESSION['ErrorMsg']='Usuario eliminado.';
      $_SESSION['ColorMsg']='#00C851';
      $_SESSION['TitleMsg']='Exito';
      header('Location: ../UserAdministration.php');
    }

    function EliminarMiembroEquipo($MemberID){
      include("CConection.php");
      $connect = mysqli_connect($host_name, $user_name, $password) or die ("Problemas con el servidor de la base de datos.");
      mysqli_select_db($connect, $database);
      $sqlCommand = "DELETE FROM `equipos` WHERE `id` = '$MemberID';";
      $query = mysqli_query($connect, $sqlCommand) or die(mysqli_error("Fallo en la consulta a la base de datos."));
      $_SESSION['ErrorMsg']='Asignaion eliminada.';
      $_SESSION['ColorMsg']='#00C851';
      $_SESSION['TitleMsg']='Exito';
      header('Location: ../UserAdministration.php');
    }

    function NuevaTarea($txtUserAsignadorDeTarea,$txtTitulo,$txtDescripcion,$FullNameAsignado,$txtFechaLimite){
      if($txtUserAsignadorDeTarea==""  or $txtDescripcion=="" or $FullNameAsignado=="" or $txtFechaLimite==""){
        $_SESSION['ErrorMsg']='Por favor completa todos los campos.';
        $_SESSION['ColorMsg']='#ffbb33';
        $_SESSION['TitleMsg']='Campos incompletos';
        header('Location: ../Main.php');
      }
      else
      {


        if(isset($_FILES['fileToUpload']))
        {
          if ($_FILES["fileToUpload"]["size"] > 9000000)
          {
            $_SESSION['ErrorMsg']='El archivo es demasiado grande.';
            $_SESSION['ColorMsg']='#222';
            $_SESSION['TitleMsg']='Error';
            $uploadOk = 0;
          }
          else
          {

            $filename = $_FILES["fileToUpload"]["name"];
            $file_ext = substr($filename, strripos($filename, '.'));
            $file_basename = substr($filename, 0, strripos($filename, '.'));
            $newfilename = time() . $file_ext;
            if (file_exists("../Adjuntos/" . $newfilename))
            {
              $_SESSION['ErrorMsg']='El archivo ya existe por favor elija otro nombre.';
              $_SESSION['ColorMsg']='#222';
              $_SESSION['TitleMsg']='Nombre duplicado';
              $uploadOk = 0;
              $newfilename = "";
            }
            else
            {
            move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], "../Adjuntos/" . $newfilename);
            }
          }
        }else{
          $newfilename = "";
        }
        if($file_ext==""){
          $newfilename = "";
        }

          include("CConection.php");
          $connect = mysqli_connect($host_name, $user_name, $password) or die ("Problemas con el servidor de la base de datos.");
          mysqli_select_db($connect, $database);
          $sqlCommand = "INSERT INTO `tareascargadas` (`Fecha`, `Asignador`, `TituloTarea`, `Descripcion`, `Asignado`, `FechaLimite`, `Vencida`,`Terminada`,`Adjunto`) VALUES (NOW() - INTERVAL 2 HOUR, '$txtUserAsignadorDeTarea', '$txtTitulo',
          '$txtDescripcion', '$FullNameAsignado', '$txtFechaLimite', '0','0','$newfilename')";

          if(mysqli_query($connect, $sqlCommand)){

            $_SESSION['ErrorMsg']='Tarea creada con exito';
            $_SESSION['ColorMsg']='#00C851';
            $_SESSION['TitleMsg']='Exito';

            EnviarCorreo($FullNameAsignado,$txtUserAsignadorDeTarea,$txtTitulo,$txtDescripcion,$txtFechaLimite);
          } else{
            $_SESSION['ErrorMsg']="ERRORal insertar nueva tarea: Could not able to execute $sql. " . mysqli_error($connect);
            $_SESSION['ColorMsg']='#222';
            $_SESSION['TitleMsg']='Error';
          }

        header('Location: ../Main.php');
      }

    }
    function NuevaTareaProgramada($txtUserAsignadorDeTarea,$txtTitulo,$txtDescripcion,$FullNameAsignado,$slctPeriodicidad1Programada,$txtFechaInicioRecurrenteProgramada,$PeriodicidadProgramada){
      if($txtUserAsignadorDeTarea==""  or $txtDescripcion==""  ){
        $_SESSION['ErrorMsg']='Por favor completa todos los campos.';
        $_SESSION['ColorMsg']='#ffbb33';
        $_SESSION['TitleMsg']='Campos incompletos';
        header('Location: ../Main.php');
      }else{
        include("CConection.php");
      $connect = mysqli_connect($host_name, $user_name, $password) or die ("Problemas con el servidor de la base de datos.");
      mysqli_select_db($connect, $database);
      if($slctPeriodicidad1Programada=="Un solo evento" ){
        $Periodicidad="Un solo evento";
      }else if($slctPeriodicidad1Programada=="Recurrente"){
        $Periodicidad=$PeriodicidadProgramada;
      }else{
        $Periodicidad="No especificada";
      }
      $sqlCommand = "INSERT INTO `tareasprogramadas` (`FechaDeCreacion`, `Asignador`, `TituloTarea`, `Descripcion`, `Asignado`, `FechaDeProximoEvento`, `Frecuencia`,`Finalizada`)
      VALUES (NOW() - INTERVAL 2 HOUR, '$txtUserAsignadorDeTarea', '$txtTitulo', '$txtDescripcion', '$FullNameAsignado', '$txtFechaInicioRecurrenteProgramada', '$Periodicidad','No');";
      if(mysqli_query($connect, $sqlCommand)){

        $_SESSION['ErrorMsg']='Tarea creada con exito';
        $_SESSION['ColorMsg']='#00C851';
        $_SESSION['TitleMsg']='Exito';

        EnviarCorreoTareaProgramada($FullNameAsignado,$txtUserAsignadorDeTarea,$txtTitulo,$txtDescripcion,$txtFechaInicioRecurrenteProgramada,$Periodicidad);
      } else{
        $_SESSION['ErrorMsg']="ERRORal insertar nueva tarea: Could not able to execute $sql. " . mysqli_error($connect);
        $_SESSION['ColorMsg']='#222';
        $_SESSION['TitleMsg']='Error';
      }
      header('Location: ../Main.php');
      }




    }

    function EnviarCorreo($FullNameAsignado,$txtUserAsignadorDeTarea,$txtTitulo,$txtDescripcion,$txtFechaLimite){

    if($FullNameAsignado == $txtUserAsignadorDeTarea)
      {

      }
      else
      {
        include("CConection.php");
        $connect = mysqli_connect($host_name, $user_name, $password) or die ("Problemas con el servidor de la base de datos.");
        mysqli_select_db($connect, $database);
        $consulta4="SELECT * FROM `users` WHERE `User`='$FullNameAsignado'";
        $Datos1 =mysqli_query($connect,$consulta4);
        $results = mysqli_fetch_array($Datos1);

        $consulta5="SELECT * FROM `users` WHERE `User`='$txtUserAsignadorDeTarea'";
        $Datos2 =mysqli_query($connect,$consulta5);
        $results2 = mysqli_fetch_array($Datos2);

        $mail = new PHPMailer();
        try {
        $mail->IsSendmail();
        $mail->SMTPDebug = 0;
        $mail->Host = 'ssl://smtp.1and1.es';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'tasksiqor@valoresmx.com';                 // SMTP username
        $mail->Password = 'Tareas2020*P';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 25; // TCP port to connect to
        $mail->setFrom('tasksiqor@valoresmx.com', 'Tareas IQor');


        $mail->addAddress($results['Email'], $results['FullName']);
        //$mail->addAddress('', 'Joe User');
        // $mail->addReplyTo('', 'Information');
        // $mail->addCC('');
        // $mail->addBCC('');

        $mail->isHTML(true);
        $mail->Subject = 'Tienes una nueva tarea de '.$results2['FullName'];
        $mail->Body    = 'Hola '.$results['FullName'].'<br><br>Una nueva tarea te ha sido asignada: <br><br>
        <b>Usuario:</b> '.$results2['FullName'].'<br><b>Titulo:</b> '.$txtTitulo.'<br><b>Descripcion:</b> '.$txtDescripcion.'<br>
        <b>Fecha limite: </b>'.$txtFechaLimite.'<br><br>En caso de dudas ponerse en contacto con el usuario.';
        $mail->AltBody = 'xxxxxxxxxxxxxxxxx';

        $mail->send();

        } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }
      }
    }


    function EnviarCorreoTareaProgramada($FullNameAsignado,$txtUserAsignadorDeTarea,$txtTitulo,$txtDescripcion,$txtFechaInicioRecurrenteProgramada,$Periodicidad){

    if($FullNameAsignado == $txtUserAsignadorDeTarea){


      }
      else
      {
        include("CConection.php");
        $connect = mysqli_connect($host_name, $user_name, $password) or die ("Problemas con el servidor de la base de datos.");
        mysqli_select_db($connect, $database);

        $consulta4="SELECT * FROM `users` WHERE `User`='$FullNameAsignado'";
        $Datos1 =mysqli_query($connect,$consulta4);
        $results = mysqli_fetch_array($Datos1);

        $consulta5="SELECT * FROM `users` WHERE `User`='$txtUserAsignadorDeTarea'";
        $Datos2 =mysqli_query($connect,$consulta5);
        $results2 = mysqli_fetch_array($Datos2);

        $mail = new PHPMailer(true);
        try {
        //Server settings
        //$mail->SMTPDebug = 0;                                 // Enable verbose debug output
        //$mail->isSMTP();                                      // Set mailer to use SMTP
        //$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
        //$mail->SMTPAuth = true;                               // Enable SMTP authentication
        //$mail->Username = 'tasksiqor@gmail.com';                 // SMTP username
        //$mail->Password = 'Tareas2020*P';                           // SMTP password
        //$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        //$mail->Port = 587;                                    // TCP port to connect to
        //$mail->setFrom('tasksiqor@gmail.com', 'Tareas IQor');

        $mail->IsSendmail();
        $mail->SMTPDebug = 0;
        $mail->Host = 'ssl://smtp.1and1.es';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'tasksiqor@valoresmx.com';                 // SMTP username
        $mail->Password = 'Tareas2020*P';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 25; // TCP port to connect to
        $mail->setFrom('tasksiqor@valoresmx.com', 'Tareas IQor');


        $mail->addAddress($results['Email'], $results['FullName']);
        //$mail->addAddress('', 'Joe User');
        // $mail->addReplyTo('', 'Information');
        // $mail->addCC('');
        // $mail->addBCC('');

        $mail->isHTML(true);
        $mail->Subject = 'Tienes una nueva tarea programada de '.$results['FullName'];
        $mail->Body    = 'Hola '.$results['FullName'].'<br><br>Una nueva tarea programada te ha sido asignada: <br><br>
        <b>Usuario:</b> '.$results2['FullName'].'<br><b>Titulo:</b> '.$txtTitulo.'<br><b>Descripcion:</b> '.$txtDescripcion.'<br>
        <b>Fecha de proximo evento: </b>'.$txtFechaInicioRecurrenteProgramada.'<br><b>Frecuencia: </b>'.$Periodicidad.' <br><br>En caso de dudas ponerse en contacto con el usuario.';
        $mail->AltBody = 'xxxxxxxxxxxxxxxxx';

        $mail->send();

        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }
      }
    }

    function EliminarTarea($TaskID){
      include("CConection.php");
      $connect = mysqli_connect($host_name, $user_name, $password) or die ("Problemas con el servidor de la base de datos.");
      mysqli_select_db($connect, $database);

      $Query0="SELECT * FROM `tareascargadas` WHERE id='$TaskID'";
      $Datos2 =mysqli_query($connect,$Query0);
      $results156 = mysqli_fetch_array($Datos2);

      $id0= $results156["id"];
      $Fecha0= $results156["Fecha"];
      $Asignador0= $results156["Asignador"];
      $TituloTarea0= $results156["TituloTarea"];
      $Descripcion0= $results156["Descripcion"];
      $Asignado0= $results156["Asignado"];
      $FechaLimite0= $results156["FechaLimite"];
      $Terminada0= $results156["Terminada"];
      $FechaDeTermino0= $results156["FechaDeTermino"];
      $ComentarioDeCierre0= $results156["ComentarioDeCierre"];


      if($FechaDeTermino0 != ""){

      }else{
        $FechaDeTermino0="NULL";
      }
      $sqlCommand0 = "INSERT INTO tareascargadaseliminadas (`id`,`Fecha`,`Asignador` ,`TituloTarea` ,`Descripcion`,`Asignado`,`FechaLimite`,`Terminada`,`FechaDeTermino`,`ComentarioDeCierre`)
       VALUES ('$id0', '$Fecha0','$Asignador0','$TituloTarea0','$Descripcion0','$Asignado0','$FechaLimite0','$Terminada0','$FechaDeTermino0','$ComentarioDeCierre0')";
       mysqli_query($connect,$sqlCommand0);


       $sqlCommand= "DELETE FROM tareascargadas WHERE id='$TaskID'";
      if(mysqli_query($connect, $sqlCommand)){
      $_SESSION['ErrorMsg']='Tarea eliminada con exito.';
      $_SESSION['ColorMsg']='#00C851';
      $_SESSION['TitleMsg']='Exito';
      } else{
        $_SESSION['ErrorMsg']="ERROR: Could not able to execute $sql. " . mysqli_error($connect);
        $_SESSION['ColorMsg']='#222';
        $_SESSION['TitleMsg']='Error';
      }
      header('Location: ../Main.php');
    }
    function EliminarTareaProgramada($TaskID){
      include("CConection.php");
      $connect = mysqli_connect($host_name, $user_name, $password) or die ("Problemas con el servidor de la base de datos.");
      mysqli_select_db($connect, $database);
      $sqlCommand = "DELETE FROM `tareasprogramadas` WHERE `id` = '$TaskID'";
      if(mysqli_query($connect, $sqlCommand)){
        $_SESSION['ErrorMsg']='Tarea eliminada con exito.';
      $_SESSION['ColorMsg']='#00C851';
      $_SESSION['TitleMsg']='Exito';
      } else{
        $_SESSION['ErrorMsg']="ERROR: Could not able to execute $sql. " . mysqli_error($connect);
        $_SESSION['ColorMsg']='#222';
        $_SESSION['TitleMsg']='Error';
      }
      header('Location: ../Main.php');
    }

    function TerminarTarea($TaskID, $Cmnt){
      include("CConection.php");
      $connect = mysqli_connect($host_name, $user_name, $password) or die ("Problemas con el servidor de la base de datos.");
      mysqli_select_db($connect, $database);

      if(isset($_FILES['fileToUploadEndTask']))
        {
          if ($_FILES["fileToUploadEndTask"]["size"] > 9000000)
          {
            $_SESSION['ErrorMsg']='El archivo es demasiado grande.';
            $_SESSION['ColorMsg']='#222';
            $_SESSION['TitleMsg']='Error';
            $uploadOk = 0;
          }
          else
          {

            $filename = $_FILES["fileToUploadEndTask"]["name"];
            $file_ext = substr($filename, strripos($filename, '.'));
            $file_basename = substr($filename, 0, strripos($filename, '.'));
            $newfilename = time() . $file_ext;
            if (file_exists("../Adjuntos/" . $newfilename))
            {
              $_SESSION['ErrorMsg']='El archivo ya existe por favor elija otro nombre.';
              $_SESSION['ColorMsg']='#222';
              $_SESSION['TitleMsg']='Nombre duplicado';
              $uploadOk = 0;
              $newfilename = "";
            }
            else
            {
            move_uploaded_file($_FILES["fileToUploadEndTask"]["tmp_name"], "../Adjuntos/" . $newfilename);
            }
          }
        }else{
          $newfilename = "";
        }
        if($file_ext==""){
          $newfilename = "";
        }


      $sqlCommand = "UPDATE tareascargadas SET Terminada=1,FechaDeTermino=NOW() - INTERVAL 2 HOUR,ComentarioDeCierre='$Cmnt',EvidenciaDeCierreAdjunto='$newfilename' WHERE id='$TaskID'";
      if(mysqli_query($connect, $sqlCommand)){
        $_SESSION['ErrorMsg']='Tarea completada con exito.';
        $_SESSION['ColorMsg']='#00C851';
        $_SESSION['TitleMsg']='Exito';

        $consulta4="SELECT * FROM `tareascargadas` WHERE id='$TaskID'";
        $Datos1 =mysqli_query($connect,$consulta4);
        $results1 = mysqli_fetch_array($Datos1);

        if($results1['Asignado'] != $results1['Asignador']){
          EnviarCorreoEndTask($results1['Asignado'],$results1['Asignador'],$TaskID,$results1['TituloTarea'],$results1['Descripcion'],$results1['FechaLimite'],$results1['ComentarioDeCierre']);
        }


      } else{
        $_SESSION['ErrorMsg']="ERROR al terminar la tarea: Could not able to execute $sql. " . mysqli_error($connect);
        $_SESSION['ColorMsg']='#222';
        $_SESSION['TitleMsg']='Error';
      }
      header('Location: ../Main.php');
    }



    // REGRESA EL CONTENIDO DE UNA TAREA PARA MOSTRARLA DESGLOSADA EN MODAL
    function TareaDesglosada($TaskIDShow){
      include("CConection.php");
      $connect = mysqli_connect($host_name, $user_name, $password) or die ("Problemas con el servidor de la base de datos.");
      mysqli_select_db($connect, $database);
        $query="SELECT * FROM `tareascargadas` WHERE id='$TaskIDShow'";
        $result=mysqli_query($connect, $query) or die(mysqli_error("Fallo en la consulta a la base de datos."));
        $result2 = mysqli_fetch_array($result);


        $return_arr[] = array("Fecha" => $result2["Fecha"],
        "Asignador" => $result2["Asignador"],
        "TituloTarea" => $result2["TituloTarea"],
        "Descripcion" => $result2["Descripcion"],
        "Asignado" => $result2["Asignado"],
        "FechaLimite" => $result2["FechaLimite"]
        );

        echo json_encode($return_arr);
    }

    function TareaProgrammedDesglosada($TaskIDShow){
      include("CConection.php");
      $connect = mysqli_connect($host_name, $user_name, $password) or die ("Problemas con el servidor de la base de datos.");
      mysqli_select_db($connect, $database);
        $query="SELECT * FROM `tareasprogramadas` WHERE id='$TaskIDShow'";
        $result=mysqli_query($connect, $query) or die(mysqli_error("Fallo en la consulta a la base de datos."));
        $result2 = mysqli_fetch_array($result);


        $return_arr[] = array("Asignador" => $result2["Asignador"],
        "TituloTarea" => $result2["TituloTarea"],
        "Descripcion" => $result2["Descripcion"],
        "Asignado" => $result2["Asignado"],
        "FechaDeProximoEvento" => $result2["FechaDeProximoEvento"],
        "Frecuencia" => $result2["Frecuencia"]
        );

        echo json_encode($return_arr);
    }



    function EliminarTareaHistorialTareasAsignadas($TaskID){
      include("CConection.php");
      $connect = mysqli_connect($host_name, $user_name, $password) or die ("Problemas con el servidor de la base de datos.");
      mysqli_select_db($connect, $database);

      $Query0="SELECT * FROM `tareascargadas` WHERE id='$TaskID'";
      $Datos2 =mysqli_query($connect,$Query0);
      $results156 = mysqli_fetch_array($Datos2);

      $id0= $results156["id"];
      $Fecha0= $results156["Fecha"];
      $Asignador0= $results156["Asignador"];
      $TituloTarea0= $results156["TituloTarea"];
      $Descripcion0= $results156["Descripcion"];
      $Asignado0= $results156["Asignado"];
      $FechaLimite0= $results156["FechaLimite"];
      $Terminada0= $results156["Terminada"];
      $FechaDeTermino0= $results156["FechaDeTermino"];
      $ComentarioDeCierre0= $results156["ComentarioDeCierre"];


      $sqlCommand0 = "INSERT INTO tareascargadaseliminadas (`id`,`Fecha`,`Asignador` ,`TituloTarea` ,`Descripcion`,`Asignado`,`FechaLimite`,`Terminada`,`FechaDeTermino`,`ComentarioDeCierre`)
      VALUES ('$id0', '$Fecha0','$Asignador0','$TituloTarea0','$Descripcion0','$Asignado0','$FechaLimite0','$Terminada0','$FechaDeTermino0','$ComentarioDeCierre0')";
      mysqli_query($connect,$sqlCommand0);



      $sqlCommand = "DELETE FROM tareascargadas WHERE id='$TaskID'";
      if(mysqli_query($connect, $sqlCommand)){
        $_SESSION['ErrorMsg']='Tarea eliminada con exito.';
      $_SESSION['ColorMsg']='#00C851';
      $_SESSION['TitleMsg']='Exito';
      } else{
        $_SESSION['ErrorMsg']="ERROR: Could not able to execute $sql. " . mysqli_error($connect);
        $_SESSION['ColorMsg']='#222';
        $_SESSION['TitleMsg']='Error';
      }
      header('Location: ../TareasAsignadas.php');
    }

    function IdTareaAEliminarHistorialTareasQueHeAsignado($TaskID){
      include("CConection.php");
      $connect = mysqli_connect($host_name, $user_name, $password) or die ("Problemas con el servidor de la base de datos.");
      mysqli_select_db($connect, $database);


      $Query0="SELECT * FROM `tareascargadas` WHERE id='$TaskID'";
      $Datos2 =mysqli_query($connect,$Query0);
      $results156 = mysqli_fetch_array($Datos2);

      $id0= $results156["id"];
      $Fecha0= $results156["Fecha"];
      $Asignador0= $results156["Asignador"];
      $TituloTarea0= $results156["TituloTarea"];
      $Descripcion0= $results156["Descripcion"];
      $Asignado0= $results156["Asignado"];
      $FechaLimite0= $results156["FechaLimite"];
      $Terminada0= $results156["Terminada"];
      $FechaDeTermino0= $results156["FechaDeTermino"];
      $ComentarioDeCierre0= $results156["ComentarioDeCierre"];


      $sqlCommand0 = "INSERT INTO tareascargadaseliminadas (`id`,`Fecha`,`Asignador` ,`TituloTarea` ,`Descripcion`,`Asignado`,`FechaLimite`,`Terminada`,`FechaDeTermino`,`ComentarioDeCierre`)
       VALUES ('$id0', '$Fecha0','$Asignador0','$TituloTarea0','$Descripcion0','$Asignado0','$FechaLimite0','$Terminada0','$FechaDeTermino0','$ComentarioDeCierre0')";
       mysqli_query($connect,$sqlCommand0);


      $sqlCommand = "DELETE FROM tareascargadas WHERE id='$TaskID'";
      if(mysqli_query($connect, $sqlCommand)){
        $_SESSION['ErrorMsg']='Tarea eliminada con exito.';
      $_SESSION['ColorMsg']='#00C851';
      $_SESSION['TitleMsg']='Exito';
      } else{
        $_SESSION['ErrorMsg']="ERROR: Could not able to execute $sql. " . mysqli_error($connect);
        $_SESSION['ColorMsg']='#222';
        $_SESSION['TitleMsg']='Error';
      }
      header('Location: ../MisTareasCreadas.php');
    }

    function TareaDesglosadaHistorialTareasAsignadas($TaskIDShowHistoTarAsig){
      include("CConection.php");
      $connect = mysqli_connect($host_name, $user_name, $password) or die ("Problemas con el servidor de la base de datos.");
      mysqli_select_db($connect, $database);
        $query="SELECT * FROM `tareascargadas` WHERE id='$TaskIDShowHistoTarAsig'";
        $result=mysqli_query($connect, $query) or die(mysqli_error("Fallo en la consulta a la base de datos."));
        $result2 = mysqli_fetch_array($result);


        $return_arr[] = array("Fecha" => $result2["Fecha"],
        "Asignador" => $result2["Asignador"],
        "TituloTarea" => $result2["TituloTarea"],
        "Descripcion" => $result2["Descripcion"],
        "Asignado" => $result2["Asignado"],
        "FechaLimite" => $result2["FechaLimite"]
        );

        echo json_encode($return_arr);
    }

    function UsuarioAVizualizar($UserName156131){

      $_SESSION['UsuarioAVizualizar']=$UserName156131;

    header('Location: ../MiEquipo.php');
    }

    function ExcelMisTarasAsignadas($User){
      include("CConection.php");
      $connect = mysqli_connect($host_name, $user_name, $password) or die ("Problemas con el servidor de la base de datos.");
      mysqli_select_db($connect, $database);
        $consulta="SELECT id,Fecha,Asignador,TituloTarea,Descripcion,Asignado,FechaLimite,Vencida,Terminada,FechaDeTermino,ComentarioDeCierre FROM `tareascargadas` WHERE `Asignado`='$User'";

        $setRec =mysqli_query($connect,$consulta);

        $columnHeader = '';
        $columnHeader = "id" . "\t" . "Fecha" . "\t" . "Asignador" . "\t" . "TituloTarea" . "\t" . "Descripcion" . "\t". "Asignado" . "\t" . "FechaLimite" . "\t". "Vencida" . "\t" . "Terminada" . "\t" . "FechaDeTermino" . "\t" . "ComentarioDeCierre" . "\t";
        $setData = '';
        while ($rec = mysqli_fetch_row($setRec)) {
        $rowData = '';
        foreach ($rec as $value) {
        $value = '"' . $value . '"' . "\t";
        $rowData .= $value;
        }
        $setData .= trim($rowData) . "\n";
        }
        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename=MisTareasAsignadas.xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        echo ucwords($columnHeader) . "\n" . $setData . "\n";


    }

    function ExcelTareasQueHeAsignado($User){
      include("CConection.php");
      $connect = mysqli_connect($host_name, $user_name, $password) or die ("Problemas con el servidor de la base de datos.");
      mysqli_select_db($connect, $database);
        $consulta="SELECT id,Fecha,Asignador,TituloTarea,Descripcion,Asignado,FechaLimite,Vencida,Terminada,FechaDeTermino,ComentarioDeCierre FROM `tareascargadas` WHERE `Asignador`='$User'";
        $setRec =mysqli_query($connect,$consulta);

        $columnHeader = '';
        $columnHeader = "id" . "\t" . "Fecha" . "\t" . "Asignador" . "\t" . "TituloTarea" . "\t" . "Descripcion" . "\t". "Asignado" . "\t" . "FechaLimite" . "\t". "Vencida" . "\t" . "Terminada" . "\t" . "FechaDeTermino" . "\t" . "ComentarioDeCierre" . "\t";
        $setData = '';
        while ($rec = mysqli_fetch_row($setRec)) {
        $rowData = '';
        foreach ($rec as $value) {
        $value = '"' . $value . '"' . "\t";
        $rowData .= $value;
        }
        $setData .= trim($rowData) . "\n";
        }
        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename=TareasQueHeAsignado.xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        echo ucwords($columnHeader) . "\n" . $setData . "\n";


      }


      function NuevaAsignacion($Usuario,$Responsable){
        include("CConection.php");
        $connect = mysqli_connect($host_name, $user_name, $password) or die ("Problemas con el servidor de la base de datos.");
        mysqli_select_db($connect, $database);`Usuario`;
  $sqlCommand = "INSERT INTO `equipos` (`Usuario`, `Responsable`) VALUES ('$Usuario', '$Responsable');";
        if(mysqli_query($connect, $sqlCommand)){
          $_SESSION['ErrorMsg']='Nueva asociación creada';
          $_SESSION['ColorMsg']='#00C851';
          $_SESSION['TitleMsg']='Exito';
        } else{
          $_SESSION['ErrorMsg']="ERROR en la insercion: Could not able to execute $sql. " . mysqli_error($connect);
          $_SESSION['ColorMsg']='#222';
          $_SESSION['TitleMsg']='Error';
        }
        header('Location: ../UserAdministration.php');
      }



      function DownloadFile($File){

        $fileName = basename($_POST['NombreFile']);
        $filePath = '../Adjuntos/'.$fileName;
        if(!empty($fileName) && file_exists($filePath)){
            // Define headers
            header("Cache-Control: public");
            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment; filename=$fileName");
            header("Content-Type: application/zip");
            header("Content-Transfer-Encoding: binary");

            // Read the file
            readfile($filePath);
            exit;
        }else{
            echo 'The file does not exist.';
        }
      }


      function DownloadFileEndTask($File){

        $fileName = basename($_POST['NombreFileEndTask']);
        $filePath = '../Adjuntos/'.$fileName;
        if(!empty($fileName) && file_exists($filePath)){
            // Define headers
            header("Cache-Control: public");
            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment; filename=$fileName");
            header("Content-Type: application/zip");
            header("Content-Transfer-Encoding: binary");

            // Read the file
            readfile($filePath);
            exit;
        }else{
            echo 'The file does not exist..';
        }
      }







      function ExcelTodasLasTareas($User){
        include("CConection.php");
        $connect = mysqli_connect($host_name, $user_name, $password) or die ("Problemas con el servidor de la base de datos.");
        mysqli_select_db($connect, $database);
          $consulta="SELECT * FROM `tareascargadas`  ";

          $setRec =mysqli_query($connect,$consulta);

          $columnHeader = '';
          $columnHeader = "id" . "\t" . "Fecha" . "\t" . "Asignador" . "\t" . "TituloTarea" . "\t" . "Descripcion" . "\t". "Asignado" . "\t" . "FechaLimite" . "\t". "Vencida" . "\t" . "Terminada" . "\t" . "FechaDeTermino" . "\t";
          $setData = '';
          while ($rec = mysqli_fetch_row($setRec)) {
          $rowData = '';
          foreach ($rec as $value) {
          $value = '"' . $value . '"' . "\t";
          $rowData .= $value;
          }
          $setData .= trim($rowData) . "\n";
          }
          header("Content-type: application/octet-stream");
          header("Content-Disposition: attachment; filename=TodasLasTareas.xls");
          header("Pragma: no-cache");
          header("Expires: 0");
          echo ucwords($columnHeader) . "\n" . $setData . "\n";


      }




      function btnAllProgrammedTasks($User){
        include("CConection.php");
        $connect = mysqli_connect($host_name, $user_name, $password) or die ("Problemas con el servidor de la base de datos.");
        mysqli_select_db($connect, $database);
          $consulta="SELECT * FROM `tareasprogramadas`";

          $setRec =mysqli_query($connect,$consulta);

          $columnHeader = '';
          $columnHeader = "id" . "\t" . "FechaDeCreacion" . "\t" . "Asignador" . "\t" . "TituloTarea" . "\t" . "Descripcion" . "\t". "Asignado" . "\t" . "FechaDeProximoEvento" . "\t". "Frecuencia" . "\t" . "Finalizada" . "\t";
          $setData = '';
          while ($rec = mysqli_fetch_row($setRec)) {
          $rowData = '';
          foreach ($rec as $value) {
          $value = '"' . $value . '"' . "\t";
          $rowData .= $value;
          }
          $setData .= trim($rowData) . "\n";
          }
          header("Content-type: application/octet-stream");
          header("Content-Disposition: attachment; filename=TodasLasTareasProgramadas.xls");
          header("Pragma: no-cache");
          header("Expires: 0");
          echo ucwords($columnHeader) . "\n" . $setData . "\n";
      }

      function btnAllDeletedTasks($User){
        include("CConection.php");
        $connect = mysqli_connect($host_name, $user_name, $password) or die ("Problemas con el servidor de la base de datos.");
        mysqli_select_db($connect, $database);
          $consulta="SELECT * FROM `tareascargadaseliminadas`";

          $setRec =mysqli_query($connect,$consulta);

          $columnHeader = '';
          $columnHeader = "id" . "\t" . "Fecha" . "\t" . "Asignador" . "\t" . "TituloTarea" . "\t" . "Descripcion" . "\t". "Asignado" . "\t" . "FechaLimite" . "\t". "Vencida" . "\t" . "Terminada" . "\t". "FechaDeTermino" . "\t". "ComentarioDeCierre" . "\t";
          $setData = '';
          while ($rec = mysqli_fetch_row($setRec)) {
          $rowData = '';
          foreach ($rec as $value) {
          $value = '"' . $value . '"' . "\t";
          $rowData .= $value;
          }
          $setData .= trim($rowData) . "\n";
          }
          header("Content-type: application/octet-stream");
          header("Content-Disposition: attachment; filename=TodasLasTareasEliminadas.xls");
          header("Pragma: no-cache");
          header("Expires: 0");
          echo ucwords($columnHeader) . "\n" . $setData . "\n";


      }

      function EnviarCorreoEndTask($FullNameAsignado,$txtUserAsignadorDeTarea,$Id,$txtTitulo,$txtDescripcion,$txtFechaLimite,$ComentarioDeCierre){
        include("CConection.php");
        $connect = mysqli_connect($host_name, $user_name, $password) or die ("Problemas con el servidor de la base de datos.");
        mysqli_select_db($connect, $database);
        $consulta4="SELECT * FROM `users` WHERE `User`='$FullNameAsignado'";
        $Datos1 =mysqli_query($connect,$consulta4);
        $results = mysqli_fetch_array($Datos1);

        $consulta5="SELECT * FROM `users` WHERE `User`='$txtUserAsignadorDeTarea'";
        $Datos2 =mysqli_query($connect,$consulta5);
        $results2 = mysqli_fetch_array($Datos2);

        $mail = new PHPMailer();
  try {
      $mail->IsSendmail();
      $mail->SMTPDebug = 0;
      $mail->Host = 'ssl://smtp.1and1.es';  // Specify main and backup SMTP servers
      $mail->SMTPAuth = true;                               // Enable SMTP authentication
      $mail->Username = 'tasksiqor@valoresmx.com';                 // SMTP username
      $mail->Password = 'Tareas2020*P';                           // SMTP password
      $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
      $mail->Port = 25; // TCP port to connect to
      $mail->setFrom('tasksiqor@valoresmx.com', 'Tareas IQor');


      $mail->addAddress($results2['Email'], $results2['FullName']);
      //$mail->addAddress('', 'Joe User');
      // $mail->addReplyTo('', 'Information');
      // $mail->addCC('');
      // $mail->addBCC('');

      $mail->isHTML(true);
      $mail->Subject = 'Tarea completada del usuario '.$results['FullName'];
      $mail->Body    = 'Hola '.$results2['FullName'].'<br><br>Una tarea que asignaste ha sido completada: <br><br><b>Folio:</b> '.$Id .'<br>
      <b>Usuario:</b> '.$results['FullName'].'<br><b>Titulo:</b> '.$txtTitulo.'<br><b>Descripcion:</b> '.$txtDescripcion.'<br>
      <b>Fecha limite: </b>'.$txtFechaLimite.'<br>
      <b>Comentario de cierre:</b> '.$ComentarioDeCierre.'<br><br>En caso de dudas ponerse en contacto con el usuario.';
      $mail->AltBody = 'xxxxxxxxxxxxxxxxx';

      $mail->send();

  } catch (Exception $e) {
      echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
  }
      }




?>
