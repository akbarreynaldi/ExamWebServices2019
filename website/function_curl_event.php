<?php
if (!function_exists('base_url_event')) {
    function base_url_event($path="") {
        return "http://localhost/volunteer_event/$path";
    }
}
if (!function_exists('base_url_event_api')) {
    function base_url_event_api($path="") {
        return base_url_event("/api/$path");
    }
}
if (!function_exists('base_url_banner_event')) {
    function base_url_banner_event($path="") {
        return base_url_event("/banner/$path");
    }
}
if (!function_exists('event_api')) {
    function event_api() {

        $token=$_SESSION['token'];
        $url=base_url_event_api("/event.php");

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
        $url=base_url_event_api("/event.php/$id");

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

?>