 <header id="topnav">
<div class="navbar-custom">
     <div class="container-fluid">
                        <ul class="list-unstyled topnav-menu float-right mb-0">

                            <li class="dropdown notification-list">
                                <!-- Mobile menu toggle-->
                                <a class="navbar-toggle nav-link">
                                    <div class="lines">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                </a>
                                <!-- End mobile menu toggle-->
                            </li>
         
            
            <li class="dropdown d-none d-lg-block">
<?php 
                       
                    
                        $condition ="";
                        if(isset($rows['rcuseryearaccess']) && $rows['rcuseryearaccess']!=null)
                        {
                            $checkval_array = array('1',$rows['assignlist']);
                            $query_year = "select * from jcyear where is_deleted=$1 and jcyactive=$1 and jcyearname IN ($2) Order By jcyearname DESC"; 
                        $resultyear = pg_query_params($db,$query_year,$checkval_array);
                        $resultyeardata = pg_fetch_all($resultyear);

                        }
                        else
                        {
                            $checkval_array = array('1');

                            $query_year = "select * from jcyear where is_deleted=$1 and jcyactive=$1 Order By jcyearname DESC"; 
                        $resultyear = pg_query_params($db,$query_year,$checkval_array);
                        $resultyeardata = pg_fetch_all($resultyear);

                        }
                        
                        ?>
                <a class="nav-link dropdown-toggle mr-0" data-toggle="dropdown" href="#" role="button"
                    aria-haspopup="false" aria-expanded="false">

                    <span class="align-middle" id="activeyear">
                        <?php if(isset($_SESSION['activeyears']) && $_SESSION['activeyears']!='')  {  echo $_SESSION['activeyears']; } else { echo "Select Year"; } ?>
                        <i class="mdi mdi-chevron-down"></i>
                    </span>
                </a>
                <div class="dropdown-menu">
                    <?php 
                            $arrayofyears = array();
                            foreach ($resultyeardata as $key => $elementdata) { 
                                $arrayofyears[]=$elementdata['jcyearname'];
                                ?>
                    <a href="javascript:void(0);"
                        onclick="return selectyears('<?php echo $elementdata['jcyids']; ?>','<?php echo $elementdata['jcyearname']; ?>')"
                        class="dropdown-item notify-item">
                        <span class="align-middle"><?php echo $elementdata['jcyearname']; ?></span>
                    </a>
                    <?php } ?>

                </div>
            </li>
<li class=" d-none d-lg-block">
                <a class="nav-link mr-0" data-toggle="dropdown" href="javascript:void(0)" role="button"
                    aria-haspopup="false" aria-expanded="false">
                    <span class="align-middle"> <?php echo $rows['admin_name']; ?> </span>
                </a>

            </li>
            <li class="dropdown notification-list">
                <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown"
                    href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <!--   <i class="fas fa-user fa-2x" ></i> -->
                    <img src="assets/images/users/avatar.png" alt="user-image" class="rounded-circle">
                </a>
                <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                    <!-- item-->
                    <div class="dropdown-header noti-title">
                        <h6 class="text-overflow m-0">Welcome <?php echo $rows['admin_name']; ?></h6>
                    </div>

                    <!-- item-->
                    <a href="profile" class="dropdown-item notify-item">
                        <i class="mdi mdi-account-outline"></i>
                        <span>Profile</span>
                    </a>
                    <div class="dropdown-divider"></div>

                    <!-- item-->
                    <a href="logout" class="dropdown-item notify-item">
                        <i class="mdi mdi-logout-variant"></i>
                        <span>Logout</span>
                    </a>

                </div>
            </li>


        </ul>

        <!-- LOGO -->
        <div class="logo-box">
            <a href="index" class="logo text-center logo-light">
                <span class="logo-lg">
                    <img src="image/logo1.jpg" alt="" style="width: auto; height: 60px;">
                    <!-- <span class="logo-lg-text-light">Flacto</span> -->
                </span>
                <span class="logo-sm">
                    <!-- <span class="logo-sm-text-dark">F</span> -->
                    <img src="image/logo1.jpg" alt="" style="width: auto; height: 60px;">
                </span>
            </a>

            <a href="index" class="logo text-center logo-dark">
                <span class="logo-lg">
                    <img src="image/logo1.jpg" alt="" style="width: auto; height: 60px;">
                    <!-- <span class="logo-lg-text-dark">Flacto</span> -->
                </span>
                <span class="logo-sm">
                    <!-- <span class="logo-lg-text-dark">F</span> -->
                    <img src="image/logo1.jpg" alt="" style="width: auto; height: 60px;">
                </span>
            </a>
           
        </div>
        <div class="text-center">

            <a class="nav-link dropdown-toggle  waves-effect waves-light wid" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
             <!--     <marquee behavior="alternate" direction="up" width="80%">
    <marquee direction="right" behavior="alternate"> <span style="text-align: center;color: white;" class="align-middle fontres">Jurisdictional Changes</span></marquee>
</marquee> -->
   <span style="text-align: center;color: white;" class="align-middle fontres">Jurisdictional Changes</span><span class="align-bottom ml-2" style="text-align: center; color: white">Ver. 1.0.0</span>
                                    <!-- <i class="mdi mdi-bell-outline noti-icon"></i> -->
                                  
                                </a>
        </div>
       
        <div class="clearfix"></div>
    </div>
</div>
<!-- end Topbar -->