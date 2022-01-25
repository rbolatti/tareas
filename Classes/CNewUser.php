<?php

session_start();
        
include("CConection.php");

        /*Validamos que esten todos los campos requeridos del formulario*/
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if ((empty($_POST["txtFullName"])) || (empty($_POST["txtUser1"])) || (empty($_POST["txtpassword1"])) || (empty($_POST["txtRole"])) || (empty($_POST["txtEmail1"])) ) {
                echo "<!DOCTYPE html>";
                echo "<html>";
                echo "<body style='background-color: #212121;color: #FAFAFA'>";
                echo "<b style='color: #F44336'>ERROR: </b>Favor de llenar todos los campos.";
                echo "</body>";
                echo "</html>";
            } else {
                $user = $_POST['txtUser1'];
                $passwordUser = $_POST['txtpassword1'];
                $fullname = $_POST['txtFullName'];
                if($_POST['txtRole']=="Usuario"){
                    $Role =2;
                }elseif($_POST['txtRole']=="Administrador"){
                    $Role =1;
                }
                $Email = $_POST['txtEmail1'];
                
                /*Validacion con expresiones reulares*/
                if ((preg_match("/^[a-zA-Z0-9._ñÑ* ]*$/", $user)) && (preg_match("/^[a-zA-Z0-9._ñÑ* ]*$/", $passwordUser)) && (preg_match("/^[a-zA-Z0-9._ñÑ* ]*$/", $fullname)) && (preg_match("/^[a-zA-Z0-9._ñÑ* ]*$/", $Role)) ) {
                    
                    $connect = mysqli_connect($host_name, $user_name, $password) or die ("Problemas con el servidor de la base de datos.");
                    mysqli_select_db($connect, $database);

                    $sqlCommand = "INSERT INTO users (User,Password,FullName,Role,Email) VALUES ('$user','$passwordUser','$fullname','$Role','$Email')";
                 
                    if(mysqli_query($connect, $sqlCommand)){
                        $_SESSION['TitleMsg'] ="Exito";
                        $_SESSION['ColorMsg'] ="#00C851";
                        $_SESSION['ErrorMsg']="Usuario dado de alta correctamente.";
                      } else{
                        $_SESSION['ErrorMsg']="ERROR: Could not able to execute $sql. " . mysqli_error($connect);
                        $_SESSION['ColorMsg']='#222';
                        $_SESSION['TitleMsg']='Error';
                      }
                   
                  
                    header("location:../UserAdministration.php");
                    
                } else {

                    
                    $_SESSION['ErrorMsg']="Favor de no utilizar caracteres especiales.";
                    header('Location: ../index.php');
                }
            }
        }
   ?>