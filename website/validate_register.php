<?php 
include 'function_curl_user.php';
session_start();
    if(isset($_POST['daftar']))
    {
        $nama=$_POST['nama'];
        $alamat=$_POST['alamat'];
        $pendidikan=$_POST['pendidikan'];
        $username=$_POST['username'];
        $password=$_POST['password'];
        $tempat_lahir=$_POST['tempat_lahir'];
        $tgl_lahir=$_POST['tgl_lahir'];
        $email=$_POST['email'];
        $no_hp=$_POST['no_hp'];
        $tgl_Daftar = date("Y-m-d");

        $response = profile_api_add($nama,$alamat,$pendidikan,$username,$password,$tempat_lahir,$tgl_lahir,$email,$no_hp,$tgl_Daftar);
        $status = $response->status;
        if($status=="data_inserted")
        {
            $_SESSION['berhasil']="data berhasil di simpan, silahkan login";
            header("Location: index.php");
        }else
            {
                $_SESSION['gagal_simpan']="data gagal di simpan";
                header("Location: index.php?options=register");
            }
    }
?>