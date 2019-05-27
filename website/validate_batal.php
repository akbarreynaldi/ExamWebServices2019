<?php
session_start();
include 'function_curl_partisipan.php';
                $id=$_GET['id'];
            
                $response = partisipan_api_batal_ikuti($id);
                $status = $response->status;
                if($status=="delete_success")
                {
                    echo "<script>alert('Event berhenti di ikuti ')</script>";
                    echo "<script> window.history.back()</script>";
                }else
                    {
                        echo "gagal";
                    }
            ?>