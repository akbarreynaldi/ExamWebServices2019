<nav class="navbar navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <a href="volunteer.php" class="navbar-brand">
                <b>Volunteer</b>
            </a>
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                <i class="fa fa-bars"></i>
            </button>
        </div>

        <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
            <ul class="nav navbar-nav">
                <li>
                    <a href="volunteer.php">Home</a>
                </li>
            </ul>
        </div>

        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <!-- The user image in the navbar-->
                        <img src="dist/img/org.png" class="user-image" alt="User Image">
                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <span class="hidden-xs"><?php echo $nama; ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- The user image in the menu -->
                        <li class="user-header">
                            <img src="dist/img/org.png" class="img-circle" alt="User Image">

                            <p>
                                <?php echo $nama; ?>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body">
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="text-center">
                                <a href="logout.php" class="btn btn-default btn-flat">Logout</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- /.navbar-custom-menu -->
    </div>
    <!-- /.container-fluid -->
</nav>