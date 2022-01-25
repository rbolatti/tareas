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

      
    $encrypted_txt = encrypt_decrypt('encrypt', $User);
  
?>
<br><br><br><br><br>
<div class="container" style="border: 1px solid blue;border-radius: 5px">
    <div class="row" style="">
        <div class=" col-sm-5" style="margin-left: 30%;padding: 15px;text-align: center;background-color: transparent   ">
            <h2>Reportes</h2>
                <br>
             <div class="" style="background-color: brown">
                <form method="POST" action="Classes/Querys.php">
                    <input type='hidden'  value='<?php echo $encrypted_txt; ?>'  name='ExcelMisTareasAsignadas'/>
                    <button type="submit"   class="btn btn-outline-primary float-left">Mis Tareas Asignadas</button>
                </form>
            </div>
                
                
                <div class="" style="background-color: blue">
                    <form method="POST" action="Classes/Querys.php">
                        <input type='hidden'  value='<?php echo $encrypted_txt; ?>'  name='ExcelTareasQueHeAsignado'/>
                        <button type="submit" class="btn btn-outline-primary float-right">Tareas que he asignado</button>
                    </form>
                </div>
                
        </div>

    </div>
 
</div>