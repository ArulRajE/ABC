<?php include ("header.php"); include ("topbar.php"); include ("menu.php"); 
if(isset($_SESSION['activeyears']) && $_SESSION['activeyears']!='') {

$result = pg_query($db, 'select * from "stCount'.$_SESSION['logindetails']['baseyear'].'" Full JOIN "stCount'.$_SESSION['activeyears'].'" On "stCount'.$_SESSION['logindetails']['baseyear'].'"."STID'.$_SESSION['logindetails']['baseyear'].'"="stCount'.$_SESSION['activeyears'].'"."STID"');

$rowsall = pg_fetch_all($result);
 
$st=0;
$dt=0;
$sd=0;
$vt=0;
$to=0;
$st11=0;
$dt11=0;
$sd11=0;
$vt11=0;
$to11=0;
foreach ($rowsall as $key => $element) {

        if($element['STID'.$_SESSION['logindetails']['baseyear'].'']!='')
        {
           $st11 =  $st11+1;
        }

        if($element['Districts'.$_SESSION['logindetails']['baseyear'].'']!='')
        {
            $dt11 = $dt11+$element['Districts'.$_SESSION['logindetails']['baseyear'].''];
            $sd11 = $sd11+$element['SubDistricts'.$_SESSION['logindetails']['baseyear'].''];
            $vt11 = $vt11+$element['Villages'.$_SESSION['logindetails']['baseyear'].''];
            $to11 = $to11+$element['Towns'.$_SESSION['logindetails']['baseyear'].''];
        }

        if($element['STID']!='')
        {
           $st =  $st+1;
        }

        if($element['Districts']!='')
        {
            $dt = $dt+$element['Districts'];
            $sd = $sd+$element['SubDistricts'];
            $vt = $vt+$element['Villages'];
            $to = $to+$element['Towns'];
        }



    }


    $starray = array(array('Year'=>''.$_SESSION['logindetails']['baseyear'].'','nb'=>$st11),array('Year'=>''.$_SESSION['activeyears'].'','nb'=>$st));
    $dtarray = array(array('Year'=>''.$_SESSION['logindetails']['baseyear'].'','nb'=>$dt11),array('Year'=>''.$_SESSION['activeyears'].'','nb'=>$dt));
    $sdarray = array(array('Year'=>''.$_SESSION['logindetails']['baseyear'].'','nb'=>$sd11),array('Year'=>''.$_SESSION['activeyears'].'','nb'=>$sd));
    $vtarray = array(array('Year'=>''.$_SESSION['logindetails']['baseyear'].'','nb'=>$vt11),array('Year'=>''.$_SESSION['activeyears'].'','nb'=>$vt));
    $toarray = array(array('Year'=>''.$_SESSION['logindetails']['baseyear'].'','nb'=>$to11),array('Year'=>''.$_SESSION['activeyears'].'','nb'=>$to));
    // print_r(json_encode($starray));
    // exit;
    // [{ 'Year': '2011', 'nb': $sr11 }, { Year: '2021', nb: $st }];
}

?>
  <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="content-page">
                <div class="content">
                    
                    <!-- Start Content-->
                    <div class="container-fluid">
                        
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <!-- Removed Dashboard from the below line by veena   -->
                                    <h4 class="page-title"></h4>
                                </div>
                            </div>
                        </div>   
                        <?php if(isset($_SESSION['activeyears']) && $_SESSION['activeyears']!='')
                        {  
 // $whereaction='';

    if($header!=0 && $rows['assignlist']!=null && $rows['assignlist']!='0')  
    {

    // $whereaction = 'AND (dt'.$_SESSION['activeyears'].'."STID"='.$rows['assignlist'].' OR sd'.$_SESSION['activeyears'].'."STID"='.$rows['assignlist'].' OR vt'.$_SESSION['activeyears'].'."STID"='.$rows['assignlist'].' )';

$array_in = array(0,$rows['assignlist']);
    $resultdata = pg_query_params($db, 'select partiallydata'.$_SESSION['activeyears'].'.*,dt'.$_SESSION['activeyears'].'."STID" as "DTSTID",dt'.$_SESSION['activeyears'].'."STName" as "DTSTName",dt'.$_SESSION['activeyears'].'."DTID" as "DTID",dt'.$_SESSION['activeyears'].'."DTName" as "DTName"
,sd'.$_SESSION['activeyears'].'."STID" as "SDSTID",sd'.$_SESSION['activeyears'].'."DTID" as "SDDTID",sd'.$_SESSION['activeyears'].'."STName" as "SDSTName",sd'.$_SESSION['activeyears'].'."DTName" as "SDDTName",sd'.$_SESSION['activeyears'].'."SDID" as "SDID",sd'.$_SESSION['activeyears'].'."SDName" as "SDName"
,vt'.$_SESSION['activeyears'].'."STID" as "VTSTID",vt'.$_SESSION['activeyears'].'."DTID" as "VTDTID",vt'.$_SESSION['activeyears'].'."SDID" as "VTSDID",vt'.$_SESSION['activeyears'].'."STName" as "VTSTName",vt'.$_SESSION['activeyears'].'."DTName" as "VTDTName",vt'.$_SESSION['activeyears'].'."SDName" as "VTSDName",vt'.$_SESSION['activeyears'].'."VTID" as "VTID",vt'.$_SESSION['activeyears'].'."VTName" as "VTName"
from partiallydata'.$_SESSION['activeyears'].' 
LEFT JOIN (select dt'.$_SESSION['activeyears'].'.*,st'.$_SESSION['activeyears'].'."STName" from dt'.$_SESSION['activeyears'].' 
          LEFT JOIN st'.$_SESSION['activeyears'].' ON st'.$_SESSION['activeyears'].'."STID"=dt'.$_SESSION['activeyears'].'."STID"
          ) AS dt'.$_SESSION['activeyears'].'
ON partiallydata'.$_SESSION['activeyears'].'."partiallydataids"=dt'.$_SESSION['activeyears'].'."DTID"

LEFT JOIN (select sd'.$_SESSION['activeyears'].'.*,dt."DTName",st."STName" from sd'.$_SESSION['activeyears'].'
          LEFT JOIN (select * from dt'.$_SESSION['activeyears'].') as dt ON dt."DTID"=sd'.$_SESSION['activeyears'].'."DTID"
          LEFT JOIN (select * from st'.$_SESSION['activeyears'].') as st ON st."STID"=sd'.$_SESSION['activeyears'].'."STID"
          ) as sd'.$_SESSION['activeyears'].'  
ON partiallydata'.$_SESSION['activeyears'].'."partiallydataids"=sd'.$_SESSION['activeyears'].'."SDID"
LEFT JOIN (select vt'.$_SESSION['activeyears'].'.*,dt."DTName",st."STName",sd."SDName" from vt'.$_SESSION['activeyears'].'
          LEFT JOIN (select * from sd'.$_SESSION['activeyears'].') as sd ON sd."SDID"=vt'.$_SESSION['activeyears'].'."SDID"
           LEFT JOIN (select * from dt'.$_SESSION['activeyears'].') as dt ON dt."DTID"=vt'.$_SESSION['activeyears'].'."DTID"
          LEFT JOIN (select * from st'.$_SESSION['activeyears'].') as st ON st."STID"=vt'.$_SESSION['activeyears'].'."STID"
          ) as vt'.$_SESSION['activeyears'].' 
ON partiallydata'.$_SESSION['activeyears'].'."partiallydataids"=vt'.$_SESSION['activeyears'].'."VTID"

where partiallydata'.$_SESSION['activeyears'].'.pstatus=$1 AND (dt'.$_SESSION['activeyears'].'."STID"=$2 OR sd'.$_SESSION['activeyears'].'."STID"=$2 OR vt'.$_SESSION['activeyears'].'."STID"=$2)
ORDER BY partiallydata'.$_SESSION['activeyears'].'."partiallyids" ASC',$array_in);

 
    }
    else
    {
$array_in = array(0);
$resultdata = pg_query_params($db, 'select partiallydata'.$_SESSION['activeyears'].'.*,dt'.$_SESSION['activeyears'].'."STID" as "DTSTID",dt'.$_SESSION['activeyears'].'."STName" as "DTSTName",dt'.$_SESSION['activeyears'].'."DTID" as "DTID",dt'.$_SESSION['activeyears'].'."DTName" as "DTName"
,sd'.$_SESSION['activeyears'].'."STID" as "SDSTID",sd'.$_SESSION['activeyears'].'."DTID" as "SDDTID",sd'.$_SESSION['activeyears'].'."STName" as "SDSTName",sd'.$_SESSION['activeyears'].'."DTName" as "SDDTName",sd'.$_SESSION['activeyears'].'."SDID" as "SDID",sd'.$_SESSION['activeyears'].'."SDName" as "SDName"
,vt'.$_SESSION['activeyears'].'."STID" as "VTSTID",vt'.$_SESSION['activeyears'].'."DTID" as "VTDTID",vt'.$_SESSION['activeyears'].'."SDID" as "VTSDID",vt'.$_SESSION['activeyears'].'."STName" as "VTSTName",vt'.$_SESSION['activeyears'].'."DTName" as "VTDTName",vt'.$_SESSION['activeyears'].'."SDName" as "VTSDName",vt'.$_SESSION['activeyears'].'."VTID" as "VTID",vt'.$_SESSION['activeyears'].'."VTName" as "VTName"
from partiallydata'.$_SESSION['activeyears'].' 
LEFT JOIN (select dt'.$_SESSION['activeyears'].'.*,st'.$_SESSION['activeyears'].'."STName" from dt'.$_SESSION['activeyears'].' 
          LEFT JOIN st'.$_SESSION['activeyears'].' ON st'.$_SESSION['activeyears'].'."STID"=dt'.$_SESSION['activeyears'].'."STID"
          ) AS dt'.$_SESSION['activeyears'].'
ON partiallydata'.$_SESSION['activeyears'].'."partiallydataids"=dt'.$_SESSION['activeyears'].'."DTID"

LEFT JOIN (select sd'.$_SESSION['activeyears'].'.*,dt."DTName",st."STName" from sd'.$_SESSION['activeyears'].'
          LEFT JOIN (select * from dt'.$_SESSION['activeyears'].') as dt ON dt."DTID"=sd'.$_SESSION['activeyears'].'."DTID"
          LEFT JOIN (select * from st'.$_SESSION['activeyears'].') as st ON st."STID"=sd'.$_SESSION['activeyears'].'."STID"
          ) as sd'.$_SESSION['activeyears'].'  
ON partiallydata'.$_SESSION['activeyears'].'."partiallydataids"=sd'.$_SESSION['activeyears'].'."SDID"
LEFT JOIN (select vt'.$_SESSION['activeyears'].'.*,dt."DTName",st."STName",sd."SDName" from vt'.$_SESSION['activeyears'].'
          LEFT JOIN (select * from sd'.$_SESSION['activeyears'].') as sd ON sd."SDID"=vt'.$_SESSION['activeyears'].'."SDID"
           LEFT JOIN (select * from dt'.$_SESSION['activeyears'].') as dt ON dt."DTID"=vt'.$_SESSION['activeyears'].'."DTID"
          LEFT JOIN (select * from st'.$_SESSION['activeyears'].') as st ON st."STID"=vt'.$_SESSION['activeyears'].'."STID"
          ) as vt'.$_SESSION['activeyears'].' 
ON partiallydata'.$_SESSION['activeyears'].'."partiallydataids"=vt'.$_SESSION['activeyears'].'."VTID"

where partiallydata'.$_SESSION['activeyears'].'.pstatus=$1
ORDER BY partiallydata'.$_SESSION['activeyears'].'."partiallyids" ASC',$array_in);


    }

                            ?>

                        <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-4"><span class="dropcap text-primary">Incomplete List</span>
                                <?php echo $_SESSION['activeyears']; ?></h4>

                            <table id="index-datatable" class="table table-hover table-striped table-bordered"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th colspan="5" style="background-color: #fe6271; color: #FFFFFF">Incomplete List <?php echo $_SESSION['activeyears']; ?></th>
                                        

                                    </tr>
                                    <tr>
                                        <th>State / UT Name</th>
                                        <th>District Name</th>
                                        <th>Sub-District Name</th>
                                        <th>Village / Town Name</th>
                                        <th>Status</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                          //   echo "INNNNNNN".pg_numrows($resultdata);
                                                while ($data = pg_fetch_array($resultdata)) {
                                                 
                                                $array_in_data = array();
                                                $array_in_data = array($data['docids']); 
                                                   $sel = pg_query_params($db,'select * from documentdata'.$_SESSION['activeyears'].' where "docids"=$1',$array_in_data);
                                                   $da = pg_fetch_array($sel);
                                                
                                                  $data = array_merge($data, $da);

                                                  $yesterday = pg_query_params($db,'select * from reuse_document'.$_SESSION['activeyears'].' where "docids"=$1',$array_in_data);
                                                  $today = pg_fetch_array($yesterday);


                                                    if($data['comefrom']=='State')
                                                    { 
                                                        $data['STID']=$data['DTSTID'];

                                                        $data['STIDS']=$data['toids'];
                                                     

                                                    ?>
                                                      
                                    <tr>

                                        <td class="class2021"><?php echo $data['DTSTName']; ?></td>
                                        <td class="class2021"><?php echo $data['DTName']; ?></td>
                                        <td class="class2021">-</td>
                                        <td class="class2021">-</td>
                                        <td class="class2021">
                                            <!-- SR No. 10 By sahana -->
                                            <?php if( $da['created_by']==$_SESSION['login_email'] || $today['created_by']==$_SESSION['login_email']) {   ?>
                                                    <span class="badge badge-purple" data-todo='<?php echo json_encode($data); ?>' style="background-color:#fbca35;">Incomplete</span>
                                            <?php }  else {?>
                                                    <span class="badge badge-purple" style="background-color:#fbca35; cursor:not-allowed">Incomplete</span>
                                            <?php }?>
                                       </td>
                                        
                                  
                                       

                                    </tr>
                                                    <?php }
                                                    else if($data['comefrom']=='District')
                                                    { 

                                                          $data['STID']=$data['SDSTID'];
                                                          $data['DTID']=$data['SDDTID'];
                                                          $data['SDID']=$data['SDID'];
                                                          $array_con = array();
                                                          $array_con = array($data['toids']);
                                                           $sqlda='select * from dt'.$_SESSION['activeyears'].' where "DTID"=$1';
                                                          $sqlda_q=pg_query_params($db,$sqlda,$array_con);
                                                          $sqlda_q_d = pg_fetch_array($sqlda_q);  

                                                          $data['STIDS']=$sqlda_q_d['STID'];
                                                          $data['DTIDS']=$data['toids'];
 
                                                        ?>

                                                    <tr>

                                        <td class="class2021"><?php echo $data['SDSTName']; ?></td>
                                        <td class="class2021"><?php echo $data['SDDTName']; ?></td>
                                        <td class="class2021"><?php echo $data['SDName']; ?></td>
                                        <td class="class2021">-</td>
                                        <td class="class2021">
                                            <!--SR No. 10 By sahana -->
                                            <?php  if( $da['created_by']==$_SESSION['login_email'] || $today['created_by']==$_SESSION['login_email']) {   ?>
                                                    <span class="badge badge-purple" data-todo='<?php echo json_encode($data); ?>' style="background-color:#fbca35;">Incomplete</span>
                                            <?php }  else {?>
                                                    <span class="badge badge-purple" style="background-color:#fbca35; cursor:not-allowed">Incomplete</span>
                                            <?php }?>
                                       </td>
                                        
                                  
                                       

                                    </tr>

                                                    <?php }

                                                    else if($data['comefrom']=='Sub-District')
                                                    { 
                                                        // echo "<pre>";
                                                        // print_r($data);

                                                          $data['STID']=$data['VTSTID'];
                                                          $data['DTID']=$data['VTDTID'];
                                                          $data['SDID']=$data['VTSDID'];
                                                          $data['VTID']=$data['VTID'];

                                                          $array_con = array();
                                                          $array_con = array($data['toids']);

                                                          $sqlda='select * from sd'.$_SESSION['activeyears'].' where "SDID"=$1';
                                                          $sqlda_q=pg_query_params($db,$sqlda,$array_con);
                                                          $sqlda_q_d = pg_fetch_array($sqlda_q);  
                                                          $data['STIDS']=$sqlda_q_d['STID'];
                                                           $data['DTIDS']=$sqlda_q_d['DTID'];
                                                       $data['SDIDS']=$data['toids'];
                                                        ?>
  <tr>

                                        <td class="class2021"><?php echo $data['VTSTName']; ?></td>
                                        <td class="class2021"><?php echo $data['VTDTName']; ?></td>
                                        <td class="class2021"><?php echo $data['VTSDName']; ?></td>
                                        <td class="class2021"><?php echo $data['VTName']; ?></td>
                                        <td class="class2021">
                                            <!--SR No. 10 By sahana -->
                                            <?php  if( $da['created_by']==$_SESSION['login_email'] || $today['created_by']==$_SESSION['login_email']) {   ?>
                                                    <span class="badge badge-purple" data-todo='<?php echo json_encode($data); ?>' style="background-color:#fbca35;">Incomplete</span>
                                            <?php }  else {?>
                                                    <span class="badge badge-purple" style="background-color:#fbca35; cursor:not-allowed">Incomplete</span>
                                            <?php }?>
                                       </td>
                                        
                                  
                                       

                                    </tr>
                                                    <?php }

                                                }
                                                    
                                          ?>

                                    
                                   
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
                    <?php } ?>

<!-- <div class="row">
   <div class="card">
                                    <div class="card-body">
<iframe src="https://map.census.gov.in/portal/apps/dashboards/10136e1510204abcaebf17fbd0498887" style="overflow: hidden; height: 100%;
        width: 100%; position: absolute;"></iframe>
</div>
</div>
</div> -->
                        <!-- end page title --> 
                        <?php if(isset($_SESSION['activeyears']) && $_SESSION['activeyears']!='') { ?>
                        <div class="row">
                            <!-- end col -->
        
                            <div class="col-xl-4">
                                <div class="card">
                                    <div class="card-body">
                                        
                                        <h4 class="header-title">States & UTs</h4>
            
                                        <div class="row text-center mt-4">
                                            <div class="col-4 offset-2">
                                                <h4 data-plugin="counterup"><?php echo $st11; ?></h4>
                                                <p class="text-muted text-truncate">Census <?php echo $_SESSION['logindetails']['baseyear']; ?></p>
                                            </div>
                                             <div class="col-6">
                                                <h4 data-plugin="counterup"><?php echo $st; ?></h4>
                                                <p class="text-muted text-truncate">Census <?php echo $_SESSION['activeyears']; ?></p>
                                            </div>
                                            
                                        </div>
            
                                        <div id="morris-bar-example" style="height: 280px;" class="morris-chart mt-2"></div>
                                    </div>
                                </div>
                            </div><!-- end col -->

                            <div class="col-xl-4">
                                <div class="card">
                                    <div class="card-body">
                                        
                                        <h4 class="header-title">Districts</h4>
            
                                        <div class="row text-center mt-4">
                                            <div class="col-4 offset-2">
                                                <h4 data-plugin="counterup"><?php echo $dt11; ?></h4>
                                                <p class="text-muted text-truncate">Census <?php echo $_SESSION['logindetails']['baseyear']; ?></p>
                                            </div>
                                             <div class="col-6">
                                                <h4 data-plugin="counterup"><?php echo $dt; ?></h4>
                                                <p class="text-muted text-truncate">Census <?php echo $_SESSION['activeyears']; ?></p>
                                            </div>
                                            
                                        </div>
            
                                        <div id="morris-bar-example-dt" style="height: 280px;" class="morris-chart mt-2"></div>
                                    </div>
                                </div>
                            </div><!-- end col -->

                            <div class="col-xl-4">
                                <div class="card">
                                    <div class="card-body">
                                        
                                        <h4 class="header-title">Sub Districts</h4>
            
                                        <div class="row text-center mt-4">
                                            <div class="col-4 offset-2">
                                                <h4 data-plugin="counterup"><?php echo $sd11; ?></h4>
                                                <p class="text-muted text-truncate">Census <?php echo $_SESSION['logindetails']['baseyear']; ?></p>
                                            </div>
                                             <div class="col-6">
                                                <h4 data-plugin="counterup"><?php echo $sd; ?></h4>
                                                <p class="text-muted text-truncate">Census <?php echo $_SESSION['activeyears']; ?></p>
                                            </div>
                                            
                                        </div>
            
                                        <div id="morris-bar-example-sd" style="height: 280px;" class="morris-chart mt-2"></div>
                                    </div>
                                </div>
                            </div><!-- end col -->


                        <!-- end row -->
                            
                            <div class="col-xl-4">
                                <div class="card">
                                    <div class="card-body">
                                        
                                        <h4 class="header-title">Villages</h4>
            
                                        <div class="row text-center mt-4">
                                            <div class="col-4 offset-2">
                                                <h4 data-plugin="counterup"><?php echo $vt11; ?></h4>
                                                <p class="text-muted text-truncate">Census <?php echo $_SESSION['logindetails']['baseyear']; ?></p>
                                            </div>
                                             <div class="col-6">
                                                <h4 data-plugin="counterup"><?php echo $vt; ?></h4>
                                                <p class="text-muted text-truncate">Census <?php echo $_SESSION['activeyears']; ?></p>
                                            </div>
                                            
                                        </div>
            
                                        <div id="morris-bar-example-vt" style="height: 280px;" class="morris-chart mt-2"></div>
                                    </div>
                                </div>
                            </div><!-- end col -->

                            <div class="col-xl-4">
                                <div class="card">
                                    <div class="card-body">
                                        
                                        <h4 class="header-title">Towns</h4>
            
                                        <div class="row text-center mt-4">
                                            <div class="col-4 offset-2">
                                                <h4 data-plugin="counterup"><?php echo $to11; ?></h4>
                                                <p class="text-muted text-truncate">Census <?php echo $_SESSION['logindetails']['baseyear']; ?></p>
                                            </div>
                                             <div class="col-6">
                                                <h4 data-plugin="counterup"><?php echo $to; ?></h4>
                                                <p class="text-muted text-truncate">Census <?php echo $_SESSION['activeyears']; ?></p>
                                            </div>
                                            
                                        </div>
            
                                        <div id="morris-bar-example-tw" style="height: 280px;" class="morris-chart mt-2"></div>
                                    </div>
                                </div>
                            </div><!-- end col -->

                            <!-- <div class="col-xl-4">
                                <div class="card">
                                    <div class="card-body">
                                        
                                        <h4 class="header-title">Wards</h4>
            
                                        <div class="row text-center mt-4">
                                            <div class="col-6">
                                                <h4 data-plugin="counterup">1234</h4>
                                                <p class="text-muted text-truncate">Census 2011</p>
                                            </div>
                                             <div class="col-6">
                                                <h4 data-plugin="counterup">1234</h4>
                                                <p class="text-muted text-truncate">Census 2021</p>
                                            </div>
                                            
                                        </div>
            
                                        <div id="morris-bar-example-wd" style="height: 280px;" class="morris-chart mt-2"></div>
                                    </div>
                                </div>
                            </div> -->

                            <!-- end col -->

                        </div>
                        <?php } ?>
                      
        
        
                        
                    </div> <!-- end container-fluid -->

                </div> <!-- end content -->

                

                <!-- Footer Start -->
                <?php include ("footertext.php"); ?>
                <!-- end Footer -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->

        </div>

        <?php // include ("rightsidebar.php"); ?>

        <?php include ("footer.php"); ?>
        <script type="text/javascript">
            Morris.Bar({
        element: 'morris-bar-example',
        data: <?php echo  json_encode($starray); ?>,
        xkey: 'Year',
        ykeys: ['nb'],
        labels: ['States & UTs'],
        barColors:["#fe6271"], barSizeRatio: .3
      });

             Morris.Bar({
        element: 'morris-bar-example-dt',
        data: <?php echo  json_encode($dtarray); ?>,
        xkey: 'Year',
        ykeys: ['nb'],
        labels: ['Districts'],
        barColors:["#fe6271"], barSizeRatio: .3
      });


              Morris.Bar({
        element: 'morris-bar-example-sd',
        data: <?php echo  json_encode($sdarray); ?>,
        xkey: 'Year',
        ykeys: ['nb'],
        labels: ['Sub-Districts'],
        barColors:["#fe6271"], barSizeRatio: .3
      });


               Morris.Bar({
        element: 'morris-bar-example-vt',
        data: <?php echo  json_encode($vtarray); ?>,
        xkey: 'Year',
        ykeys: ['nb'],
        labels: ['Villages'],
        barColors:["#fe6271"], barSizeRatio: .3
      });

                Morris.Bar({ element: 'morris-bar-example-tw', data: <?php
                echo  json_encode($toarray); ?>, xkey: 'Year', ykeys:
                ['nb'], labels: ['Town'], barColors:
                ["#fe6271"], barSizeRatio: .3});



       

        </script>
