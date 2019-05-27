<?php 
if (!function_exists('base_url_user')) {
    function base_url_user($path="") {
        return "http://localhost/volunteer_user/$path";
    }
}
if (!function_exists('base_url_user_api')) {
    function base_url_user_api($path="") {
        return base_url_user("/api/$path");
    }
}

if (!function_exists('validate_api')) {
    function validate_api($username, $password) {

        $login_form = array('method'=>'validate','username' => $username ,'password' => $password);

        $json = json_encode($login_form);

        $url = base_url_user_api("/volunteer.php");
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $json,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Postman-Token: 2114e224-fae5-405f-9b5f-7dd2ec92bdd9",
                "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        $response = json_decode($response);
        return $response;
    }
}



if (!function_exists('profile_api')) {
    function profile_api() {

        $id=$_SESSION['id'];
        $token=$_SESSION['token'];
        $url=base_url_user_api("/volunteer.php/$id");

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_HTTPHEADER => array(
                "Postman-Token: f55cc4b3-a593-49ad-bf29-9573693c07cf",
                "X-Authorization: Bearer $token",
                "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        $json=json_decode($response);
        return $json;
    }
}

if (!function_exists('profile_api_add')) {
    function profile_api_add( $nama,$alamat,$pendidikan,$username,$password,$tempat_lahir,$tgl_lahir,$email,$no_hp,$tgl_Daftar) {

        $token=$_SESSION['token'];
        $daftar = array(
            'nama'=> $nama,
            'alamat'=>$alamat,
            'pendidikan'=> $pendidikan,
            'username' => $username,
            'password' => $password,
            'tempat_lahir' => $tempat_lahir,
            'tgl_lahir'=> $tgl_lahir,
            'email'=> $email,
            'no_hp' => $no_hp,
            'tgl_daftar' => $tgl_Daftar
        );
        $json = json_encode($daftar);
        $url=base_url_user_api("/volunteer.php");

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $json,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Postman-Token: f55cc4b3-a593-49ad-bf29-9573693c07cf",
                "X-Authorization: Bearer $token",
                "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        $json=json_decode($response);
        return $json;
    }
}
?>