<?php 
    ob_start();
    include 'function_curl_user.php';
    session_start();
    if(isset($_POST['login']))
    {
        $username=$_POST['username'];
        $password=$_POST['password'];

        $response = validate_api($username, $password);

        $status = $response->status;
        $token=$response->token;
        $id= $response->id;
        if($status=="authenticated")
        {
            $_SESSION['id'] = $id;
             $_SESSION['token'] = $token;
            header("Location: volunteer.php");
        }else
            {
                $_SESSION['gagal']="username atau password tidak ditemukan";
                header("Location: index.php");
            }
    }
?>