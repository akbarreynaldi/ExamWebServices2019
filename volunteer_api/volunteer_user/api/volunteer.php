<?php
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        require_once("./konek.php");
        require_once("./lib/JWT.php");
        require_once("./lib/SignatureInvalidException.php");
        require_once("./authorization.php");
        use \Firebase\JWT\JWT;
        use \Firebase\JWT\SignatureInvalidException;
    
        $db = new Database();
        $koneksi = $db->getConnection();

        // Check for the path elements
        $path = (empty($_SERVER['PATH_INFO'])?null:$_SERVER['PATH_INFO']);
        if ($path != null) {
            $path_params = explode("/", $path);
        }

        //POST
        if ($_SERVER['REQUEST_METHOD']=='POST') {
            $data = json_decode(file_get_contents("php://input"));
            // $query = "INSERT INTO book (id, author, title, genre, publish_date, price, description)
            //                 VALUES (:id, :author, :title, :genre, :publish_date, :price, :description)";
            if (!empty($data->method)) {
                if ($data->method=="validate") {
                    // echo "hahahaha";
                    $username = $data->username;
                    $password = $data->password;
                    $query_check = "SELECT * FROM volunteer WHERE username='$username' AND password='$password'";
                    // echo $query_check;
                    $stmt = $koneksi->prepare($query_check);
                    $stmt->execute();
                    $num = $stmt->rowCount();
                    if ($num>0) {
                        $pen_arr=array();
                        $pen_item;
                        //$pen_arr["records"]=array();
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            extract($row);
                            $payload = json_encode(['id' => $id]);
                            $pen_item = array(
                                "status" => "authenticated",
                                "id" => $id,
                                "token" => makeJWT($payload));
                            array_push($pen_arr, $pen_item);
                        }
                        echo json_encode($pen_item);
                    } else {
                        echo '{"status" : "authenticated_failed"}';
                    }
                } elseif ($data->method=="available") {
                    $username = $data->username;
                    $query_check = "SELECT * FROM volunteer WHERE username='$username'";
                    // echo $query_check;
                    $stmt = $koneksi->prepare($query_check);
                    $stmt->execute();
                    $num = $stmt->rowCount();
                    if ($num>0) {
                        echo '{"status" : "available"}';
                    } else {
                        echo '{"status" : "not_available"}';
                    }
                } elseif ($data->method=="delete") {
                    $id = $data->id;
                    $query_check = "DELETE FROM volunteer WHERE id = '$id'";
                    // echo $query_check;
                    $stmt = $koneksi->prepare($query_check);
                    if ($stmt->execute()) {
                        echo '{"status" : "delete_success"}';
                    } else {
                        echo '{"status" : "delete_failed"}';
                    }
                } elseif ($data->method=="update") {
                    $id = $data->id;
                    $query = "UPDATE volunteer SET 
                            nama = :nama, 
                            pendidikan = :pendidikan,
                            alamat = :alamat,
                            tempat_lahir = :tempat_lahir,
                            tgl_lahir = :tgl_lahir,
                            email = :email,
                            no_hp = :no_hp WHERE id = '$id'";

                    $stmt = $koneksi->prepare($query);
                    //$tgl = date("Y-m-d");
                    //$stmt->bindParam(':tgl_event_dibuat', $tgl);
                    $stmt->bindParam(':nama', $data->nama);
                    $stmt->bindParam(':pendidikan', $data->pendidikan);
                    $stmt->bindParam(':alamat', $data->alamat);
                    $stmt->bindParam(':tempat_lahir', $data->tempat_lahir);
                    $stmt->bindParam(':tgl_lahir', $data->tgl_lahir);
                    $stmt->bindParam(':email', $data->email);
                    $stmt->bindParam(':no_hp', $data->no_hp);

                    if ($stmt->execute()) {
                        echo "{\n\"status\":\"update_success\"\n}";
                    } else {
                        echo "{\n\"status\":update_un_success\n}";
                    }
                }
            } else {
                $query = "INSERT INTO volunteer SET 
                        id = :id, 
                        username = :username,  
                        password = :password,
                        nama = :nama, 
                        pendidikan = :pendidikan,
                        alamat = :alamat,
                        tempat_lahir = :tempat_lahir,
                        tgl_lahir = :tgl_lahir,
                        email = :email,
                        no_hp = :no_hp,
                        tgl_daftar = :tgl_daftar";


                // prepare query
                $stmt = $koneksi->prepare($query);
                // // sanitize
                // $id = htmlspecialchars(strip_tags($id));
            
                // bind new values
                $stmt->bindParam(':id', $data->id);
                $stmt->bindParam(':username', $data->username);
                $stmt->bindParam(':password', $data->password);
                $stmt->bindParam(':nama', $data->nama);
                $stmt->bindParam(':pendidikan', $data->pendidikan);
                $stmt->bindParam(':alamat', $data->alamat);
                $stmt->bindParam(':tempat_lahir', $data->tempat_lahir);
                $stmt->bindParam(':tgl_lahir', $data->tgl_lahir);
                $stmt->bindParam(':email', $data->email);
                $stmt->bindParam(':no_hp', $data->no_hp);
                $tgl_daftar = date("Y-m-d");
                $stmt->bindParam(':tgl_daftar', $tgl_daftar);

                // execute query
                if ($stmt->execute()) {
                    echo "{";
                    echo '"status" : "data_inserted"';
                    echo "}";
                } else {
                    echo "{";
                    echo '"status" : "data_inserted_failed"';
                    echo "}";
                }
            }

            //DELETE
        } elseif ($_SERVER['REQUEST_METHOD']=='DELETE') {
            $data = json_decode(file_get_contents("php://input"));
            $id = $data->id;

            $query_check = "SELECT * FROM volunteer WHERE id=$id";
            $stmt = $koneksi->prepare($query_check);
            $stmt->execute();
            $num = $stmt->rowCount();
            if ($num>0) {
                $query = "DELETE FROM volunteer WHERE id= ? ";
                // prepare query
                $stmt = $koneksi->prepare($query);
                // sanitize
                $id = htmlspecialchars(strip_tags($id));

                // bind id of record to delete
                $stmt->bindParam(1, $id);

                // execute query
                if ($stmt->execute()) {
                    echo "{\"status\":\"delete_success\"}";
                } else {
                    echo "{\"status\":\"delete_un_success\"}";
                }
            } else {
                echo "{\"status\":delete_un_success__no_such_id}";
            }
            //GET
        } elseif ($_SERVER['REQUEST_METHOD']=='GET') {
            
            if (isset($_GET["validasi"])) {
                echo "hehe";
            } else {
                if (!empty($path_params[1]) && $path_params[1] != null) {
                    $query = "SELECT * FROM volunteer WHERE id = $path_params[1]";
                } else {
                    $query = "SELECT * FROM volunteer";
                }

                $stmt = $koneksi->prepare($query);
                if(isValidJWT(getBearerToken())){
                    $stmt->execute();
                    $num = $stmt->rowCount();

                    if ($num>0 && isValidJWT(getBearerToken())) {
                        $book_arr=array();
                        $book_arr["records"]=array();
                        
                        $book_arr["statistic"]=array();

                        $sd = 0;
                        $smp = 0;
                        $sma = 0;
                        $s1 = 0;
                        $s2 = 0;
                        $s3 = 0;

                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);
                            $book_item = array(
                            "id" => $id,
                            "username" => $username,
                            "password" => $password,
                            "nama" => $nama,
                            "pendidikan" => $pendidikan,
                            "alamat" => $alamat,
                            "tempat_lahir" => $tempat_lahir,
                            "tgl_lahir" => $tgl_lahir,
                            "email" => $email,
                            "no_hp" => $no_hp,
                            "tgl_daftar" => $tgl_daftar
                            );

                            $g = $pendidikan;
                            if ($g=="SD") {
                                $sd++;
                            } elseif ($g=="SMP") {
                                $smp++;
                            } elseif ($g=="SMA") {
                                $sma++;
                            } elseif ($g=="S1") {
                                $s1++;
                            }elseif ($g=="S2") {
                                $s2++;
                            }elseif ($g=="S3") {
                                $s3++;
                            }
                    
            
                            array_push($book_arr["records"], $book_item);
                    }

                    $par_statistic = array(
                        "hehe" => getBearerToken(),
                        "sd" => $sd,
                        "smp" => $smp,
                        "sma" => $sma,
                        "s1" => $s1,
                        "s2" => $s2,
                        "s3" => $s3,
                    );
                    array_push($book_arr["statistic"], $par_statistic);
                    echo json_encode($book_arr);
                }
            }
                else{echo json_encode(["status"=>"invalid_token"]);}
            }
        }

        