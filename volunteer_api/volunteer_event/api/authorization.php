<?php
    require_once("./lib/JWT.php");
    require_once("./lib/SignatureInvalidException.php");
    use \Firebase\JWT\JWT;
    use \Firebase\JWT\SignatureInvalidException;

         function makeJWT($id)
        {
            $token = array('id' => $id, );
            $jwt = JWT::encode($token, "testvolunteerhwebservice2019");
            return $jwt;
        }

        function readJWT($jwt)
        {
            $decoded = JWT::decode($jwt,"testvolunteerhwebservice2019", ['HS256']);
            return $decoded->id;
        }
        
        function isValidJWT($jwt){
            try{
                readJWT($jwt);
            }catch(Exception $exc){
                return false;
            }
            return true;
        }
        
        function getAuthorizationHeader(){
            $headers = null;
            if (isset($_SERVER['Authorization'])) {
                $headers = trim($_SERVER["Authorization"]);
            }
            else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
                $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
            } elseif (function_exists('apache_request_headers')) {
                $requestHeaders = apache_request_headers();
                // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
                $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
                //print_r($requestHeaders);
                if (isset($requestHeaders['X-Authorization'])) {
                    $headers = trim($requestHeaders['X-Authorization']);
                }
            }
            return $headers;
        }
    
    /**
    * get access token from header
    * */
    function getBearerToken() {
        $headers = getAuthorizationHeader();
        // HEADER: Get the access token from the header
        if (!empty($headers)) {
            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                return $matches[1];
            }
        }
        return null;
    }