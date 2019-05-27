<?php 
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php  include ("template/css_login.php");?>
    </head>
    <body>
        <!-- Top content -->
        <div class="top-content">
        <?php 
          if(isset($_REQUEST['options']))
          {
            $options=$_REQUEST['options'];
            switch ($options) {
              case 'register':
                include("register.php");
                break;
            }
          }else
            {
        ?>
              <div class="inner-bg">
                  <div class="container">
                      <div class="row" >
                          <div class="col-sm-6 col-sm-offset-3 form-box" style="margin-top:-3%;" >
                            <div class="form-top"  style="background-color:#fff;">
                              <div class="form-top-center">
                              <img src="dist/img/logo3.png" class="center-block" style="margin-top:10px" alt="">
                                <h2 class="text-center">Login Volunteer</h2>
                              </div>
                              </div>
                              <div class="form-bottom">
                            <form role="form" action="validate.php" method="POST" class="login-form">
                            <?php 
                              if(isset($_SESSION['gagal']))
                              {
                                $gagal = $_SESSION['gagal'];
                                echo "<p class='text-center'style='color:red;'>$gagal</p>";
                                unset($_SESSION['gagal']);
                              } 
                              if(isset($_SESSION['berhasil']))
                              {
                                $berhasil = $_SESSION['berhasil'];
                                echo "<p class='text-center'style='color:#00CC00;'>$berhasil</p>";
                                unset($_SESSION['berhasil']);
                              }
                            ?>
                              <div class="form-group">
                                <label class="sr-only" for="username">Username</label>
                                  <input type="text" name="username" placeholder="Username" class="form-username form-control" id="form-username">
                                </div>
                                <div class="form-group">
                                  <label class="sr-only" for="password">Password</label>
                                  <input type="password" name="password" placeholder="Password" class="form-password form-control" id="form-password">
                                </div>
                                <button type="submit" name="login" class="btn">Login</button>
                                  </form>
                                  belum punya akun? <a href="?options=register">Daftar di sini</a>
                          </div>
                          </div>
                      </div>
                  </div>
              </div>
          <?php             
            } 
          ?>
        </div>
        <?php include ("template/js_login.php"); ?>
    </body>

</html>