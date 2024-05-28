<?php
$server = 'localhost';
$user = 'dbusr23360859808';
$password = '19PHP_myadmin_SQL63@__.EK';
$database = 'dbstorage23360859808';

$baglanti = mysqli_connect($server, $user, $password, $database);

if(!$baglanti){
      echo "MySQL server bağlanamadı. </br>";
      echo "HATA: " . mysqli_connect_error();
      exit;
}

?>