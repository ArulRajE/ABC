<?php
$filename = basename($_SERVER['PHP_SELF']);

           $active = "";
           $active1 = "";
           if($filename=='districts.php' && isset($_GET['ids']) && $_GET['ids']!='')
           {    

               $active = " active ";
                
           }
           else  if($filename=='subdistricts.php' && isset($_GET['ids']) && $_GET['ids']!='')
           {
            
                $active = " active ";
           }
            else  if($filename=='villages.php' && isset($_GET['ids']) && $_GET['ids']!='')
           {
                $active = " active ";

           }
              else  if($filename=='wards.php' && isset($_GET['ids']) && $_GET['ids']!='')
           {


                $active = " active ";
           }
           if($filename=='document.php' || $filename=='adddocument.php')
           {


                $active1 = " active ";
           }
           if($filename=='map.php')
           {


                $active2 = " active ";
           }

            

?>
  
<div class="topbar-menu">
    <div class="container-fluid">
        <div id="navigation">
            <!-- Navigation Menu-->
            <ul class="navigation-menu">

                <li class="has-submenu">
                    <a href="index">
                        <i class="mdi mdi-speedometer"></i>Dashboard
                    </a>
                </li>

                <li class="has-submenu">
                    <a href="circulars">
                        <i class="mdi mdi-purse-outline"></i>Circulars <div class="arrow-down"></div>
                    </a>
                </li>
                <?php if(isset($_SESSION['activeyears']) && $_SESSION['activeyears']!='') { ?>
                <li class="has-submenu <?php echo $active1; ?>">
                    <a href="document"> <i class="mdi mdi-file-document"></i>Documents <div class="arrow-down"></div>
                    </a>
                </li>

                <li class="has-submenu <?php echo $active; ?>">
                    <a href="units">
                        <i class="mdi mdi-layers-outline"></i>Administrative Units <div class="arrow-down"></div></a>
                </li>
                 <li class="has-submenu <?php echo $active2; ?>">
                    <a href="map">
                        <i class="mdi mdi-map-check"></i>Map <div class="arrow-down"></div></a>
                </li>

<li class="has-submenu">
                                    <a href="#"> <i class="mdi mdi-flip-horizontal"></i>Reports <div class="arrow-down"></div></a>
                                    <ul class="submenu">
                                      
                                        <li class="has-submenu">
                                            <a href="forread">For Read (<?php echo $_SESSION['logindetails']['baseyear']; ?> - <?php echo $_SESSION['activeyears']; ?>)</a>
                                        </li>

                                        
                                        <li><a href="reports">Concordance (<?php echo $_SESSION['logindetails']['baseyear']; ?> - <?php echo $_SESSION['activeyears']; ?>)</a></li>
                                        <li class="has-submenu">
                                            <a href="#">Circular 1 <div class="arrow-down"></div></a>
                                            <ul class="submenu">
                                                <li><a href="#">Annexure-I Form A</a></li>
                                                <li><a href="#">Annexure-I Form B</a></li>
                                                <li><a href="#">Annexure-I Form C</a></li>
                                                <li><a href="#">Annexure-I Form D</a></li>
                                                <li><a href="#">Annexure-I Form E</a></li>
                                                <li><a href="#">Annexure-II</a></li>
                                            </ul>
                                        </li>

                                        <li class="has-submenu">
                                            <a href="#">Circular 2 <div class="arrow-down"></div></a>
                                            <ul class="submenu">
                                                <li><a href="#">Proforma  - I.1</a></li>
                                               <li><a href="#">Proforma  - I.2</a></li>
                                               <li><a href="#">Proforma  - II.1</a></li>
                                               <li><a href="#">Proforma  - II.2</a></li>
                                               <li><a href="#">Proforma  - II.3</a></li>
                                               <li><a href="#">Proforma  - II.4</a></li>
                                               <li><a href="#">Proforma  - II.5</a></li>
                                               <li><a href="#">Proforma  - II.6</a></li>
                                            </ul>
                                        </li>

                                        <li class="has-submenu">
                                            <a href="#">Circular 3 <div class="arrow-down"></div></a>
                                            <ul class="submenu">
                                                <li><a href="#">Proforma  - 1</a></li>
                                                <li><a href="#">Proforma  - 2</a></li>
                                                <li><a href="#">Proforma  - 3</a></li>
                                                <li><a href="#">Proforma  - 4</a></li>
                                                <li><a href="#">Proforma  - 5</a></li>
                                                
                                            </ul>
                                        </li>

                                        
                            
                                    </ul>
                                </li>
               <!--  <li class="has-submenu">
                    <a href="javascript:void(0);"> <i class="mdi mdi-flip-horizontal"></i>Reports <div
                            class="arrow-down"></div></a>
                </li>
 -->
                <li class="has-submenu">
                    <a href="setdates"> <i class="mdi mdi-calendar-account-outline"></i>Important Dates <div
                            class="arrow-down"></div></a>
                </li>
          
                <?php 
// print_r($rows);
                if($_SESSION['login_type']=="0" || $_SESSION['login_type']=="1" || $_SESSION['login_type']=="2") { ?>
                <li class="has-submenu">
                    <a href="users"> <i class="mdi mdi-account-group"></i>Users <div class="arrow-down"></div></a>
                </li>
                <?php } ?>
  <?php } ?>

            </ul>
            <!-- End navigation menu -->

            <div class="clearfix"></div>
        </div>
        <!-- end #navigation -->
    </div>
    <!-- end container -->
</div>

<!-- end navbar-custom -->
</header>
<!-- End Navigation Bar-->