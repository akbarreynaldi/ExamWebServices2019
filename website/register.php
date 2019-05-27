<div class="inner-bg">
    <div class="container">
        <div class="row" style="margin:-10% 0 0 0">
            <div class="col-sm-6 col-sm-offset-3 form-box">
            	<div class="form-top">
            		<div class="form-top-center">
            			<h1>Register To Be a Volunteer</h1>
            		</div>
                </div>
                <div class="form-bottom">
                    <form role="form" action="validate_register.php" method="post" class="login-form">
                        <?php 
                              if(isset($_SESSION['gagal_simpan']))
                              {
                                $gagal_simpan = $_SESSION['gagal_simpan'];
                                echo "<p class='text-center'style='color:red;'>$gagal_simpan</p>";
                                unset($_SESSION['gagal_simpan']);
                              } 
                            ?>
                        <div class="form-group">
                    		<label class="sr-only" for="nama">Nama</label>
                        	<input type="text" name="nama" placeholder="Nama" class=" form-control"  required>
                        </div>
                        
                        <div class="form-group">
                    		<label class="sr-only" for="alamat">Alamat</label>
                        	<input type="text" name="alamat" placeholder="Alamat" class="form-control"  required>
                        </div>
                        <hr style="border-bottom:1px #fff solid;">

                        <div class="form-group">
                            <h5>Pendidikan Terakihir :</h5>
                            <select name="pendidikan" id="" class="form-control select" placeholder="Pendidikan Terakihir"  required>
                                    <option value="SD">SD</option>
                                    <option value="SMP">SMP</option>
                                    <option value="SMA">SMA</option>
                                    <option value="S1">S1</option>
                                    <option value="S2">S2</option>
                                    <option value="S3">S3</option>
                                </select>
                        </div>
                         
                        <hr style="border-bottom:1px #fff solid;">
   

                    	<div class="form-group">
                    		<label class="sr-only" for="username">Username</label>
                        	<input type="text" name="username" placeholder="Username" class="form-control"  required>
                        </div>
                        
                        <div class="form-group">
                        	<label class="sr-only" for="password">Password</label>
                        	<input type="password" name="password" placeholder="Password" class="form-control"  required>
                        </div>
                        <hr style="border-bottom:1px #fff solid;">

                        <div class="row form-group">
                            <div class="col-md-6">
                                <label class="sr-only" for="tempat_lahir">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" placeholder="Tempat Lahir" class="form-control"  required>
                            </div>
                            <div class="form-group">
                            <input type="date" name="tgl_lahir" class="form-control"  required>
                            </div>
                        </div>
                           <!--  <div class="col-md-6">
                                <select name="tanggal_lahir" id="" class="form-control select " requied>
                                    <option value="">tanggal Lahir</option>
                                    <?php for ($i=1; $i <=31 ; $i++) 
                                    { 
                                        echo "<option value='$i'>$i</option>";
                                    } ?>
                                </select>
                                
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-6">
                                <select name="bulan_lahir" id="" class="form-control select" required>
                                    <option>Bulan Lahir</option>
                                    <?php 
                                        $bulan = array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember' );
                                        for ($i=0; $i < count($bulan) ; $i++) 
                                        { 
                                            $j=1+$i;
                                            echo "<option value='$j'>$bulan[$i]</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="tahun_lahir" placeholder="Tahun Lahir" class="form-control number" data-inputmask='"mask": "9999"' data-mask required>
                            </div>
                        </div> -->
                        <hr style="border-bottom:1px #fff solid;">

                        <div class="form-group">
                            <label class="sr-only" for="email">E-mail</label>
                            <input type="text" name="email" placeholder="E-mail" class=" form-control"  required>
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="no_hp">No. HP</label>
                            <input type="text" name="no_hp" placeholder="No. HP" class=" form-control"  required>
                        </div>
                        <button type="submit" name="daftar" class="btn">Daftar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>