<?php

session_start();
        
include("CConection.php");

        /*Validamos que esten todos los campos requeridos del formulario*/
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if ((empty($_POST["txtNombre1"])) || (empty($_POST["txtNombreCompleto1"])) || (empty($_POST["txtroleedit"])) || (empty($_POST["txtEmailEdit"])) ) {
                echo "<!DOCTYPE html>";
                echo "<html>";
                echo "<body style='background-color: #212121;color: #FAFAFA'>";
                echo "<b style='color: #F44336'>ERROR: </b>Favor de llenar todos los campos.";
                echo "</body>";
                echo "</html>";
            } else {
                $user = $_POST['txtNombre1'];
                $FullName = $_POST['txtNombreCompleto1'];
                $Role = $_POST['txtroleedit'];
                $Email = $_POST['txtEmailEdit'];
                
                
                /*Validacion con expresiones reulares*/
                if ((preg_match("/^[a-zA-Z0-9._ñÑ* ]*$/", $user)) && (preg_match("/^[a-zA-Z0-9._ñÑ* ]*$/", $FullName)) && (preg_match("/^[a-zA-Z0-9._ñÑ* ]*$/", $Role)) && (preg_match("/^[a-zA-Z0-9._ñÑ*@ ]*$/", $Email)) ) {
                    $con = mysqli_connect($host_name, $user_name, $password) or die ("Problemas con el servidor de la base de datos.");
                    mysqli_select_db($connect, $database);
                    $sqlCommand = "UPDATE users SET FullName='$FullName', Role='$Role', Email='$Email' WHERE User='$user'";
                    $query = mysqli_query($connect, $sqlCommand) or die(mysqli_error("Fallo en la consulta a la base de datos."));
                   
                   
                    $_SESSION['TitleMsg'] ="Exito";
                    $_SESSION['ColorMsg'] ="#00C851";
                    $_SESSION['ErrorMsg']="Usuario actualizado correctamente.";
                    header("location:../UserAdministration.php");
                   
                } else {

                    $_SESSION['TitleMsg'] ="Error";
                    $_SESSION['ColorMsg'] ="#222";
                    $_SESSION['ErrorMsg']="Favor de no utilizar caracteres especiales.";
                    header('Location: ../index.php');
                }
            }
        }
   