<?php
 error_reporting(1);
$koneksi = mysqli_connect("localhost","root","","db_sampah");
//echo "berhasil";
// Check connection
if (mysqli_connect_errno()){
	echo "Koneksi database gagal : " . mysqli_connect_error();
}

ini_set('display_errors',1); 
?>