<?php
session_start();
include "function_curl_partisipan.php";

$id_pendonor=$_SESSION['id'];
$id_event=$_GET['id'];

$response = partisipan_api_ikuti($id_pendonor, $id_event);
$status = @$response->status;
$no_registrasi=@$response->no_registrasi;
if($status=="data_inserted")
{
    echo "<script>alert('No Registrasi : ".$no_registrasi." ')</script>";
    echo "<script> window.history.back()</script>";
}else
{
    echo "gagal";
}