<?php 
    include 'function_curl_partisipan.php';
    include 'function_curl_event.php';
        
    $id=$_GET['id'];
    $token=$_SESSION['token'];
    $json2 = event_detail_api($id);
    $record2=$json2->records;
    $r = $record2[0];

?>
<div class="box box-danger">
    <div class="box-header with-border">
        <h3 class="box-title">Rincian Event <?php echo $r->judul; ?></h3>
    </div>
    <div class="box-body">
        <img src="<?php echo "http://localhost/volunteer/".$r->banner; ?>" alt="" class="center-block img-responsive" width="30%"><br>
        <b> Waktu Pelaksanaan : <?php echo $r->tgl_event; ?></b><br>
        <b>Tempat </b> <b style="margin : 0 0 0 7%;"> : </b><b class="text-danger"> <?php echo $r->tempat; ?></b><br>
        <b>Keterangan</b><br>
            <?php echo $r->deskripsi; ?>
        <br><br>
        <div class="text-center">
            <?php 
                $id_pendonor=$_SESSION['id'];
                $id_event=$id;
               
                $response = partisipan_api($id_pendonor, $id_event);
                $status = $response->status;
                if($status=="found")
                {
                    $id_partisipan=$response->id;
                    $no_registrasi=$response->no_registrasi;
            ?>
                    <h3> <b>No Registrasi : <?php echo $no_registrasi; ?></b></h3>
                    <a href="validate_batal.php?id=<?php echo $id_partisipan;?>" class="btn btn-danger btn-sm col-lg-2" style="margin:0 0 0 40%;">Batal Ikuti</a>
            <?php
                }else
                    {
            ?>
                    <a href="validate_ikuti.php?id=<?php echo $r->id; ?>" class="btn btn-primary btn-sm col-lg-2" style="margin:0 0 0 40%;">Ikuti</a><br>
            <?php

                    }
            ?>
        </div>
    </div>
    <!-- /.box-body -->
</div>