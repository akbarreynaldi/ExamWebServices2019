<?php



if (!function_exists('base_url')) {
    function base_url($path="") {
        return "http://localhost/volunteer/$path";
    }
}
if (!function_exists('base_url_api')) {
    function base_url_api($path="") {
        return base_url("/api/$path");
    }
}
if (!function_exists('base_url_banner')) {
    function base_url_banner($path="") {
        return base_url("/banner/$path");
    }
}


if (!function_exists('validate_api')) {
    function validate_api($username, $password) {

        $login_form = array('method'=>'validate','username' => $username ,'password' => $password);

        $json = json_encode($login_form);

        $url = base_url_api("/volunteer.php");
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

if (!function_exists('validate_api')) {
    function validate_api_admin($username, $password) {

        $login_form = array('method'=>'validate','username' => $username ,'password' => $password);

        $json = json_encode($login_form);

        $url = base_url_api("/admin.php");
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
        $url=base_url_api("/volunteer.php/$id");

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
        $url=base_url_api("/volunteer.php");

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

if (!function_exists('event_api')) {
    function event_api() {

        $token=$_SESSION['token'];
        $url=base_url_api("/event.php");

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

if (!function_exists('event_detail_api')) {
    function event_detail_api($id) {

        $token=$_SESSION['token'];
        $url=base_url_api("/event.php/$id");

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
                "cache-control: no-cache",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        $json=json_decode($response);
        $record2=$json->records;
        $r = $record2[0];
        return $json;
    }
}

if (!function_exists('partisipan_api')) {
    function partisipan_api($id_volunteer, $id_event) {

        $token=$_SESSION['token'];
        $detail_event = array(
            'method'=>'check',
            'id_volunteer'=> $id_volunteer,
            'id_event'=> $id_event,
        );
        $json = json_encode($detail_event);

        $url = base_url_api("/partisipan.php");
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
                "cache-control: no-cache",
                "X-Authorization: Bearer $token",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        $response = json_decode($response);
        return $response;
    }
}

if (!function_exists('partisipan_api_ikuti')) {
    function partisipan_api_ikuti($id_volunteer, $id_event) {

        $token=$_SESSION['token'];
        $ikuti = array(
            'id_volunteer'=> $id_volunteer,
            'id_event'=> $id_event,
        );
        $json = json_encode($ikuti);

        $url = base_url_api("/partisipan.php");
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
                "cache-control: no-cache",
                "X-Authorization: Bearer $token",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        $response = json_decode($response);
        return $response;
    }
}
if (!function_exists('partisipan_api_batal_ikuti')) {
    function partisipan_api_batal_ikuti($id) {

        $token=$_SESSION['token'];
        $detail_event = array(
            'method'=>'delete',
            'id'=> $id
        );
        $json = json_encode($detail_event);

        $url = base_url_api("/partisipan.php");
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
                "cache-control: no-cache",
                "X-Authorization: Bearer $token",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);


        $response = json_decode($response);
        return $response;
    }
}