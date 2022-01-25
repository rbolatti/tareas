<?php

include("CConection.php");
if(isset($_POST["UserID"])){
   
    $UseIDD=$_POST["UserID"];
    $con = mysqli_connect($host_name, $user_name, $password) or die ("Problemas con el servidor de la base de datos.");
    mysqli_select_db($connect, $database);
    $query="SELECT * FROM users WHERE id='$UseIDD'";
    $result=mysqli_query($connect, $query) or die(mysqli_error("Fallo en la consulta a la base de datos."));
    $result2 = mysqli_fetch_array($result); 
   

    $return_arr[] = array("User" => $result2["User"],
    "FullName" => $result2["FullName"],
    "Role" => $result2["Role"],
    "Email" => $result2["Email"]);

echo json_encode($return_arr);
}