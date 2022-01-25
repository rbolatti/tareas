<?php

session_start();
        
include("CConection.php");

        /*Validamos que esten todos los campos requeridos del formulario*/
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if ((empty($_POST["user"])) || (empty($_POST["pw"]))) {
                echo "<!DOCTYPE html>";
                echo "<html>";
                echo "<body style='background-color: #212121;color: #FAFAFA'>";
                echo "<b style='color: #F44336'>ERROR: </b>Favor de llenar todos los campos.";
                echo "</body>";
                echo "</html>";
            } else {
                $usr = $_POST['user'];
                $psw = $_POST['pw'];
                /*Validacion con expresiones reulares*/
                if ((preg_match("/^[a-zA-Z0-9._ñÑ* ]*$/", $usr)) && (preg_match("/^[a-zA-Z0-9._ñÑ* ]*$/", $psw))) {
                    $con = mysqli_connect($host_name, $user_name, $password) or die ("Problemas con el servidor de la base de datos.");
                    mysqli_select_db($con, $database);
                    $sqlCommand = "SELECT * FROM users WHERE USER='$usr'";
                    $query = mysqli_query($con, $sqlCommand) or die(mysqli_error("Fallo en la consulta a la base de datos."));
                    $filler = mysqli_fetch_array($query);
                    if ($psw == $filler['Password']) {
                        /*VARIABLE GLOBAL $_SESSION[]*/
                        $_SESSION['User'] = $filler['User'];
                        $_SESSION['AccountRole'] = $filler['Role'];
                        $_SESSION['FullName'] = $filler['FullName'];
                       
                        header("location:../Main.php");
                    } else {
                        
                        $_SESSION['TitleMsg'] ="Credenciales incorrectas";
                        $_SESSION['ColorMsg'] ="#CC0000";
                        $_SESSION['ErrorMsg']="Usuario o contraseña incorrectos.";
                        header('Location: ../index.php');
                    }
                } else {

                    
                    $_SESSION['ErrorMsg']="Favor de no utilizar caracteres especiales.";
                    header('Location: ../index.php');
                }
            }
        }
   
    ?>