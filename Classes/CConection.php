<?php

try {

//  $host_name = 'db747997577.db.1and1.com';
    //  $database = 'db747997577';
    //  $user_name = 'dbo747997577';
    //  $password = 'a123456789Q';
    $host_name = 'localhost';
    $database = 'c1361575_tasks';
    $user_name = 'c1361575_tasks';
    $password = 'nita58toLI';
    $connect = mysqli_connect($host_name, $user_name, $password, $database);

    $secret_key = 'fer1fer45f1488566';
    $secret_iv = '1225615s1d6c6c156';

//   $encrypted_txt = encrypt_decrypt('encrypt', $User);
    //   $decrypted_txt = encrypt_decrypt('decrypt', $encrypted_txt);
} catch (Exception $e) {
    header('Location: ../index.php');
}