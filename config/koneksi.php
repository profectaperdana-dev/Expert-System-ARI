<?php
//KONVERSI PHP KE PHP 7
require_once "parser-php-version.php";

error_reporting(0);
# Konek ke Web Server Lokal
$myHost	= "localhost";
$myUser	= "root";
$myPass	= "";
$myDbs	= "db_ispa";

// Konek ke MySQL Server 
$koneksidb	= mysql_connect($myHost, $myUser, $myPass);
if (! $koneksidb) {
  echo "Ada kesalahan koneksi ke MySQL !";
}

// Memilih database pd MySQL Server
mysql_select_db($myDbs) or die ("Database <b>$myDbs</b> tidak ditemukan !");
?>