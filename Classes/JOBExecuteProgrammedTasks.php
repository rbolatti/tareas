<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';


      include("CConection.php");
      $connect = mysqli_connect($host_name, $user_name, $password) or die ("Problemas con el servidor de la base de datos.");
      mysqli_select_db($connect, $database);

      $consulta1="SELECT id,Asignador,TituloTarea,Descripcion,Asignado,FechaDeProximoEvento,Frecuencia FROM `tareasprogramadas` WHERE FechaDeProximoEvento=DATE_ADD(curdate() , INTERVAL 1 DAY) 
      AND Finalizada='No'";    
      $Datos1 =mysqli_query($connect,$consulta1);
      while($row = mysqli_fetch_assoc($Datos1))
      {
        $Asignado1=$row['Asignado'];
        $consulta2="SELECT * FROM `users` WHERE `User`='$Asignado1'";    
        $Datos2 =mysqli_query($connect,$consulta2);
        $results = mysqli_fetch_array($Datos2); 
        $Asignador1=$row['Asignador'];
        $consulta3="SELECT * FROM `users` WHERE `User`='$Asignador1'";    
        $Datos3 =mysqli_query($connect,$consulta3);
        $results2 = mysqli_fetch_array($Datos3); 

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
        $mail->addBCC('sergio.pazholguin@iqor.com','SergioPaz');

        $mail->isHTML(true);                                
        $mail->Subject = 'Tienes una nueva tarea de '.$results2['FullName'];
        $mail->Body    = 'Hola '.$results['FullName'].'<br><br>Una nueva tarea te ha sido asignada: <br><br>
        <b>Usuario:</b> '.$results2['FullName'].'<br><b>Titulo:</b> '.$row['TituloTarea'].'<br><b>Descripcion:</b> '.$row['Descripcion'].'<br>
        <b>Fecha limite: </b>'.$row['FechaDeProximoEvento'].'<br><br>En caso de dudas ponerse en contacto con el usuario.<br><br>Esta es una tarea programada.';
        $mail->AltBody = 'xxxxxxxxxxxxxxxxx';

        $mail->send();

        } catch (Exception $e) {
       
        }
      }








      $consulta4="SELECT id,Fecha,Asignador,TituloTarea,Descripcion,Asignado,FechaLimite,Vencida,Terminada,FechaDeTermino,Adjunto FROM `tareascargadas` WHERE FechaLimite = curdate() 
      AND Vencida='0' and Terminada='0';";    
      $Datos4 =mysqli_query($connect,$consulta4);
      while($row2 = mysqli_fetch_assoc($Datos4))
      {
        $Asignado2=$row2['Asignado'];
        $consulta5="SELECT * FROM `users` WHERE `User`='$Asignado2'";    
        $Datos5 =mysqli_query($connect,$consulta5);
        $results3 = mysqli_fetch_array($Datos5); 
        $Asignador2=$row2['Asignador'];
        $consulta6="SELECT * FROM `users` WHERE `User`='$Asignador2'";    
        $Datos6 =mysqli_query($connect,$consulta6);
        $results4 = mysqli_fetch_array($Datos6); 

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

        $mail->addAddress($results3['Email'], $results3['FullName']);     
        //$mail->addAddress('', 'Joe User'); 
        // $mail->addReplyTo('', 'Information');
        // $mail->addCC('');
        $mail->addBCC('sergio.pazholguin@iqor.com','SergioPaz');

        $mail->isHTML(true);                                
        $mail->Subject = 'Hoy vence una de tus tareas';
        $mail->Body    = 'Hola '.$results3['FullName'].'<br><br>Una tarea que te fue asignada vence el dia de hoy: <br><br>
        <b>Usuario:</b> '.$results4['FullName'].'<br><b>Titulo:</b> '.$row2['TituloTarea'].'<br><b>Descripcion:</b> '.$row2['Descripcion'].'<br>
        <b>Fecha limite: </b>'.$row2['FechaLimite'].'<br><br>En caso de dudas ponerse en contacto con el usuario.';
        $mail->AltBody = 'xxxxxxxxxxxxxxxxx';

        $mail->send();

        } catch (Exception $e) {
       
        }
      }


      
   


  include("CConection.php");
$sqlCommand='CALL GenerarTarea()';
mysqli_query($connect, $sqlCommand);

include("CConection.php");
$sqlCommand='CALL TareasVencidas()';
mysqli_query($connect, $sqlCommand);


// http://valoresmx.com/Classes/JOBExecuteProgrammedTasks.php






?>






