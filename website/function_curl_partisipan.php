<?php

if (!function_exists('base_url')) {
    function base_url($path="") {
        return "http://localhost/volunteer_partisipan/$path";
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

?>