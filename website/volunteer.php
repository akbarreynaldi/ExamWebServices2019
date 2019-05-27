<?php
    include 'function_curl_user.php';
    
    session_start(); 
    $id=$_GET['id'];
    $json = profile_api();
    $record = $json->records;
    $nama1= $record[0];
    $nama = $nama1->nama;

?>

<!DOCTYPE html>
<html>
    <head>
        <?php include('template/css.php'); ?>
    </head>

    <!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->

    <body class="hold-transition skin-red layout-top-nav fixed">
        <div class="wrapper">

            <header class="main-header">
                <?php include "template/header.php"; ?>
            </header>
            <!-- Full Width Column -->
            <div class="modal fade" id="modal-default">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title">About</h4>
                        </div>
                        <div class="modal-body">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
            <div class="content-wrapper">
                <div class="container">
                    <!-- Main content -->
                    <section class="content">
                        <?php
                            include 'function_curl_event.php';
                            if(isset($_REQUEST['options']))
                            {
                                $options=$_REQUEST['options'];
                                switch ($options) {
                                    case 'd_e':
                                        include("detail_event.php");
                                        break;
                                }
                            }else
                                {                        
                                    
                                    $json2 = event_detail_api($id);
                                    $record2 = $json2->records;

                                    foreach ($record2 as $key => $row) 
                                    {
                                ?>
                                        <div class="box box-danger">
                                            <div class="box-header with-border">
                                                <img src="<?php echo "http://localhost/volunteer/".$row->banner; ?>" alt="" class="center-block img-responsive" width="30%"><br>
                                                <h3 class="box-title"><?php echo $row->judul; ?></h3>
                                            </div>
                                            <div class="box-body">
                                                <?php echo $row->deskripsi; ?>
                                                <br>
                                                <a href="?options=d_e&id=<?php echo $row->id;?>" class="btn btn-default btn-sm pull-right">Rincian Event</a>
                                            </div>
                                            <!-- /.box-body -->
                                        </div>
                                        <!-- /.box -->
                                <?php
                                    }
                                }
                                ?>
                    </section>
                    <!-- /.content -->
                </div>
                <!-- /.container -->
            </div>
            <!-- /.content-wrapper -->
            <footer class="main-footer">
                <?php include('template/footer.php'); ?>
            </footer>
        </div>
        <!-- ./wrapper -->
        <?php include('template/js.php'); ?>
    </body>
</html>