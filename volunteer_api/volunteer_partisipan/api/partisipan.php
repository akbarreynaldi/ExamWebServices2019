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
        if(isValidJWT(getBearerToken())){
        if (!empty($data->method)) {
            if ($data->method=="check") {
                $id_volunteer = $data->id_volunteer;
                $id_event = $data->id_event;
                $query_check = "SELECT * FROM partisipan WHERE id_event='$id_event' AND id_volunteer='$id_volunteer'";
                $stmt = $koneksi->prepare($query_check);
                $stmt->execute();
                $num = $stmt->rowCount();
                if ($num>0) {
                    $par_arr=array();
                    $par_arr["records"]=array();
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);
                        $par_item = array(
                            "status" => "found",
                            "id" => $id,
                            "id_volunteer" => $id_volunteer,
                            "id_event" => $id_event,
                            "tgl_daftar" => $tgl_daftar,
                            "no_registrasi" => $no_registrasi
                        );
                        echo json_encode($par_item);die();
                        array_push($par_arr["records"], $par_item);
                    }
                    
                    // echo '{"status" : "found"}';
                } else {
                    echo '{"status" : "not_found"}';
                }
            }else if($data->method=="delete")
            {

                if(!empty($data->id))
                {
                    $id = $data->id;
                    $query = "DELETE FROM partisipan WHERE id = '$id'";
                    $stmt = $koneksi->prepare($query);
                    if ($stmt->execute()) {
                        echo "{\n\"status\":\"delete_success\"\n}";
                    } else {
                        echo "{\n\"status\":delete_un_success\n}";
                    }
                }else{
                    $id_event = $data->id_event;
                    $id_volunteer = $data->id_volunteer;
                    $query = "DELETE FROM partisipan WHERE id_event = '$id_event' AND id_volunteer='$id_volunteer'";
                    $stmt = $koneksi->prepare($query);
                    if ($stmt->execute()) {
                        echo "{\n\"status\":\"delete_success\"\n}";
                    } else {
                        echo "{\n\"status\":delete_un_success\n}";
                    }
                }
            }else if($data->method=="delete_all")
            {
                $query = "DELETE FROM partisipan";
                $stmt = $koneksi->prepare($query);
                if ($stmt->execute()) {
                    echo "{\n\"status\":\"delete_all_success\"\n}";
                } else {
                    echo "{\n\"status\":delete_all_un_success\n}";
                }
            }
        } else {
            $query = "INSERT INTO partisipan SET 
                    id_volunteer = :id_volunteer,
                    id_event = :id_event,
                    tgl_daftar = :tgl_daftar,
                    no_registrasi = :no_registrasi";


            // prepare query
            $stmt = $koneksi->prepare($query);
            // // sanitize
            // $id = htmlspecialchars(strip_tags($id));

            $id_volunteer = $data->id_volunteer;
            $id_event = $data->id_event;
            // bind new values
            $stmt->bindParam(':id_volunteer', $id_volunteer);
            $stmt->bindParam(':id_event', $id_event);
            $tgl = date("Y-m-d");
            $stmt->bindParam(':tgl_daftar', $tgl);
            $no_reg = strval(rand(10000, 99999));
            $stmt->bindParam(':no_registrasi', $no_reg);

            // execute query
            if ($stmt->execute()) {
                echo "{";
                echo '"status" : "data_inserted","no_registrasi":"' . $no_reg . '"';
                echo "}";
            } else {
                echo "{";
                echo '"status" : "data_inserted_failed"';
                echo "}";
            }
        }
    }else{
        echo json_encode(["status"=>"invalid_token"]);
    }
        //DELETE
    } elseif ($_SERVER['REQUEST_METHOD']=='DELETE') {
        // $data = json_decode(file_get_contents("php://input"));
        // $id = $data->id;
        
        if (!empty($path_params[1]) && $path_params[1] != null) {
            $query = "DELETE FROM partisipan WHERE id = $path_params[1]";
            // $query_2 = "DELETE FROM partisipan WHERE id_event='$id_event' AND id_volunteer='$id_volunteer'";
            $stmt = $koneksi->prepare($query);
            if ($stmt->execute()) {
                echo "{\n\"status\":\"delete_success\"\n}";
            } else {
                echo "{\n\"status\":delete_un_success\n}";
            }
        } else {
            $query_check = "SELECT * FROM partisipan WHERE id=$id";
            $stmt = $koneksi->prepare($query_check);
            $stmt->execute();
            $num = $stmt->rowCount();
            if ($num>0) {
                $query = "DELETE FROM pastisipan WHERE id= ? ";

                // prepare query
                $stmt = $koneksi->prepare($query);
        
                // sanitize
                $id = htmlspecialchars(strip_tags($id));
        
                // bind id of record to delete
                $stmt->bindParam(1, $id);
        
                // execute query
                if ($stmt->execute()) {
                    echo "{\n\"status\":\"delete_success\"\n}";
                } else {
                    echo "{\n\"status\":delete_un_success\n}";
                }
            } else {
                echo "{\"status\":delete_un_success__no_such_id}";
            }
        }
        //GET
    } elseif ($_SERVER['REQUEST_METHOD']=='GET') {
        if (!empty($path_params[1]) && $path_params[1] != null) {
            $query = "SELECT * FROM partisipan WHERE id_event = $path_params[1]";
        } else {
            $query = "SELECT * FROM partisipan";
        }

        $stmt = $koneksi->prepare($query);
        $stmt->execute();
        $num = $stmt->rowCount();

        if ($num>0 && isValidJWT(getBearerToken())) {
            $par_arr=array();
            $par_arr["records"]=array();
            $par_arr["statistic"]=array();

            $a = 0;
            $b = 0;
            $ab = 0;
            $o = 0;

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);

                $query2 = "SELECT * FROM volnteer WHERE id = '$id_volunteer'";
                $stmt2 = $koneksi->prepare($query2);
                $stmt2->execute();
                $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);

                $par_item = array(
                    "id" => $id,
                    "id_volunteer" => $id_volunteer,
                    "id_event" => $id_event,
                    "tgl_daftar" => $tgl_daftar,
                    "no_registrasi" => $no_registrasi,
                    "nama" => $row2["nama"],
                    "pendidikan" => $row2["pendidikan"],
                    "alamat" => $row2["alamat"],
                    "tempat_lahir" => $row2["tempat_lahir"],
                    "tgl_lahir" => $row2["tgl_lahir"],
                    "email" => $row2["email"],
                    "no_hp" => $row2["no_hp"],
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
                            array_push($par_arr["records"], $par_item);
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
            //     $g = $row2["pendidikan"];
            //     if($g=="A"){$a++;}elseif($g=="B"){$b++;}elseif($g=="AB"){$ab++;}elseif($g=="O"){$o++;}
            //     array_push($par_arr["records"], $par_item);
            // }
            // $par_statistic = array(
            //     "a" => $a,
            //     "b" => $b,
            //     "ab" => $ab,
            //     "o" => $o
            // );
            array_push($par_arr["statistic"], $par_statistic);
            echo json_encode($par_arr);
        }else{
            echo json_encode(["status"=>"invalid_token"]);
        }
    }
