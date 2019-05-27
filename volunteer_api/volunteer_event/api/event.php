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
        if(isValidJWT(getBearerToken())){
        if (!empty($data->method)) {
            if ($data->method=="delete") {
                if (!empty($data->id)) {
                
                $id = $data->id;
                    
                $query2 = "SELECT * FROM list_event WHERE id = '$id'";
                $stmt2 = $koneksi->prepare($query2);
                $file_gbr = ""; 
                if($stmt2->execute())
                {
                    while ($row22 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                        $file_gbr = $row22["banner"];  
                    }
                }else{
                    echo "failed";
                }
                    $query = "DELETE FROM list_event WHERE id = '$id'";
                    $stmt = $koneksi->prepare($query);
                    if ($stmt->execute()) {
                        unlink("." . $file_gbr);
                        echo "{\n\"status\":\"delete_success\"\n}";
                        //echo $file_gbr;
                        //file_get_contents('./delete.php?id=', false);
                    } else {
                        echo "{\n\"status\":delete_un_success\n}";
                    }
                }
            }else if($data->method=="update"){
                $id = $data->id;
                    $query = "UPDATE list_event SET 
                        judul = :judul,
                        deskripsi = :deskripsi,
                        banner = :banner,
                        tgl_event = :tgl_event,
                        kuota = :kuota,
                        tempat = :tempat WHERE id = '$id'";

                    $stmt = $koneksi->prepare($query);
                    $stmt->bindParam(':judul', $data->judul);
                    $stmt->bindParam(':deskripsi', $data->deskripsi);
                    $stmt->bindParam(':banner', $data->banner);
                    $tgl = date("Y-m-d");
                    //$stmt->bindParam(':tgl_event_dibuat', $tgl);
                    $stmt->bindParam(':tgl_event', $data->tgl_event);
                    $stmt->bindParam(':kuota', $data->kuota);
                    $stmt->bindParam(':tempat', $data->tempat);

                    
                    if ($stmt->execute()) {
                        echo "{\n\"status\":\"update_success\"\n}";
                    } else {
                        echo "{\n\"status\":update_un_success\n}";
                    }
            }else if($data->method=="cek_partisipan"){
                $query_check = "SELECT * FROM partisipan WHERE id_event=$id";
                $stmt = $koneksi->prepare($query_check);
                $stmt->execute();
                if ($stmt->execute()) {
                    $num = $stmt->rowCount();
                    echo "{\n\"kuota\":\"$num\"\n}";
                } else {
                    echo "{\n\"status\":cek_un_success\n}";
                }
                if ($num>0) {
                    
                }  
            }
        
        } else {
            // $query = "INSERT INTO book (id, author, title, genre, publish_date, price, description)
            //                 VALUES (:id, :author, :title, :genre, :publish_date, :price, :description)";
            $query = "INSERT INTO list_event SET 
                    judul = :judul,
                    deskripsi = :deskripsi,
                    banner = :banner,
                    tgl_event_dibuat = :tgl_event_dibuat,
                    tgl_event = :tgl_event,
                    kuota = :kuota,
                    tempat = :tempat";
            // prepare query
            $stmt = $koneksi->prepare($query);
            // // sanitize
            // $id = htmlspecialchars(strip_tags($id));
        
            // bind new values
            $stmt->bindParam(':judul', $data->judul);
            $stmt->bindParam(':deskripsi', $data->deskripsi);
            $stmt->bindParam(':banner', $data->banner);
            $tgl = date("Y-m-d");
            $stmt->bindParam(':tgl_event_dibuat', $tgl);
            $stmt->bindParam(':tgl_event', $data->tgl_event);
            $stmt->bindParam(':kuota', $data->kuota);
            $stmt->bindParam(':tempat', $data->tempat);
        
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
    }else{
        json_encode(["status"=>"invalid_token"]);
    }
    
    } elseif ($_SERVER['REQUEST_METHOD']=='DELETE') {
        $data = json_decode(file_get_contents("php://input"));
        $id = $data->id;

        $query_check = "SELECT * FROM list_event WHERE id=$id";
        $stmt = $koneksi->prepare($query_check);
        $stmt->execute();
        $num = $stmt->rowCount();
        if ($num>0) {
            $query = "DELETE FROM list_event WHERE id= ? ";

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

        //GET
    } elseif ($_SERVER['REQUEST_METHOD']=='GET') {
        if (!empty($path_params[1]) && $path_params[1] != null) {
            $query = "SELECT * FROM list_event WHERE id = $path_params[1]";
        } else {
            $query = "SELECT * FROM list_event";
        }

        $stmt = $koneksi->prepare($query);
        $stmt->execute();
        $num = $stmt->rowCount();

        if ($num>0 && isValidJWT(getBearerToken())) {
            $book_arr=array();
            $book_arr["records"]=array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                
                $query2 = "SELECT * FROM partisipan WHERE id_event = '$id'";
                $stmt2 = $koneksi->prepare($query2);
                $stmt2->execute();
                $num_partisipan = $stmt2->rowCount();

                $book_item = array(
                    "id" => $id,
                    "judul" => $judul,
                    "deskripsi" => $deskripsi,
                    "banner" => $banner,
                    "tgl_event_dibuat" => $tgl_event_dibuat,
                    "tgl_event" => $tgl_event,
                    "kuota" => $kuota,
                    "tempat" => $tempat,
                    "jml_partisipan" => $num_partisipan
                );
                array_push($book_arr["records"], $book_item);
            }
            echo json_encode($book_arr);
        }else{
            echo json_encode(['status'=>'invalid_token']);
        }
    }
