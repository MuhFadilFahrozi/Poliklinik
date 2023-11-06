<?php
$databaseHost = 'localhost';
$databaseName = 'poliklinik';
$databaseUsername = 'root';
$databasePassword = '';

$hostname = "localhost";
$user = "root";
$password = "";
$db_name ="poliklinik";

$koneksi = mysqli_connect($hostname,$user,$password,$db_name) or die (mysqli_error($koneksi));
$mysqli = mysqli_connect($databaseHost,
    $databaseUsername, $databasePassword,$databaseName) ;
