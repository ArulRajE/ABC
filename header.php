<?php error_reporting(0);  session_start(); include('include/db_conn.php'); include('include/function.php');

//HOST HEADER INJECTION
// Get the host header value
$host = $_SERVER['HTTP_HOST'];

// Validate the host header value
// if (!preg_match('/^[a-z0-9.-]+$/i', $host)) {
//     // Invalid host header value, handle error
//     header("HTTP/1.1 400 Bad Request");
//     exit("Invalid Host header");
// }

// // Set the Host header explicitly to the expected value
// header("Host: " . $host);


// $sq="select user_token from $admin_table where id=$1";
// $sql1=pg_query_params($db,$sq,array($_SESSION['login_id']));
// $valid_tokan = pg_numrows($sql1);
// $rowtoken = pg_fetch_all($sql1);





if($valid_tokan>0 && $rowtoken[0]['user_token']!=$_SESSION['user_token']) 
{
    echo "<script language='javascript'>alert('This user already logged in another device')</script>";
session_destroy();
echo "<script language='javascript'>location.href='login';</script>";exit;
}

$filename = basename($_SERVER['PHP_SELF']);
if( !isset($_SESSION['login_id']))
{
    session_destroy();
    echo "<script language='javascript'>location.href='login';</script>";exit;
}
else
{
   
      if($_SESSION['login_type']==0 && ($filename=="units.php" || $filename=="index.php" || $filename=="users.php" || $filename=="adddocument.php" || $filename=="profile.php" || $filename=="reports.php" || $filename=="districts.php" || $filename=="subdistricts.php" || $filename=="villagelist.php" || $filename=="villages.php"  || $filename=="circulars.php" || $filename=="document.php" || $filename=="map.php" || $filename=="forread.php" || $filename=="setdates.php" || $filename=="map.php"))
    {
                if(time() - $_SESSION['login_time'] < 1200)
                {
                $_SESSION['login_time']=time();
                }
                else
                {
                session_destroy();
                echo "<script language='javascript'>location.href='login';</script>";
                exit;

                }   
    }

    else if($_SESSION['login_type']==1 && ($filename=="units.php" || $filename=="users.php" || $filename=="index.php" || $filename=="adddocument.php" || $filename=="profile.php" || $filename=="reports.php" || $filename=="districts.php" || $filename=="subdistricts.php" || $filename=="villagelist.php" || $filename=="villages.php"  || $filename=="circulars.php" || $filename=="document.php" || $filename=="map.php" || $filename=="forread.php" || $filename=="setdates.php" || $filename=="map.php"))
    {
                if(time() - $_SESSION['login_time'] < 1200)
                {
                $_SESSION['login_time']=time();
                }
                else
                {
                session_destroy();
                echo "<script language='javascript'>location.href='login';</script>";
                exit;

                }   
    }
     else if($_SESSION['login_type']==2 &&  ($filename=="units.php" || $filename=="users.php"|| $filename=="index.php" || $filename=="adddocument.php" || $filename=="profile.php" || $filename=="reports.php" || $filename=="districts.php" || $filename=="subdistricts.php" || $filename=="villagelist.php" || $filename=="circulars.php"  || $filename=="villages.php" || $filename=="document.php" || $filename=="map.php" || $filename=="forread.php" || $filename=="setdates.php" || $filename=="map.php"))
    {
                if(time() - $_SESSION['login_time'] < 1200)
                {
                $_SESSION['login_time']=time();
                }
                else
                {
                session_destroy();
                echo "<script language='javascript'>location.href='login';</script>";
                exit;

                }   
    }
    else if($_SESSION['login_type']==3 &&  ($filename=="units.php" || $filename=="index.php" || $filename=="adddocument.php" || $filename=="profile.php" || $filename=="reports.php" || $filename=="districts.php" || $filename=="subdistricts.php" || $filename=="villagelist.php" || $filename=="circulars.php"  || $filename=="villages.php" || $filename=="document.php" || $filename=="map.php" || $filename=="forread.php" || $filename=="setdates.php" || $filename=="map.php"))
    {
                if(time() - $_SESSION['login_time'] < 1200)
                {
                
                $_SESSION['login_time']=time();
                
                }
                else
                {
                session_destroy();
                echo "<script language='javascript'>location.href='login';</script>";
                exit;

                }   
    }
    else
    {
        session_destroy();
        echo "<script language='javascript'>location.href='login';</script>";
        exit;
    }

}

// $query = "select al.*,(select ARRAY_TO_STRING(ARRAY_AGG(assignlistids), ',') as assignlist from adminassignlist where adminids=al.id GROUP BY adminids) from admin_login al where al.id=".$_SESSION['login_id']."";


//   $concate = ",
// (select ARRAY_TO_STRING(ARRAY_AGG(recastinguserassign.\"STID\"), ',') as assignlist from recastinguserassign where rcids=al.rcids  and rcuyear=".$_SESSION['activeyears']."
//  GROUP BY rcids),(select ARRAY_TO_STRING(ARRAY_AGG(recastinguserassign.\"DTID\"), ',') as assignlistdist from recastinguserassign where rcids=al.rcids  and rcuyear=".$_SESSION['activeyears']."
//  GROUP BY rcids)";  


 

 // $query = "select al.*,(select ARRAY_TO_STRING(ARRAY_AGG(DISTINCT(adminassignlist.\"assignyear\")), ',') as assignyears from adminassignlist where adminids=al.id  GROUP BY adminids ),(select ARRAY_TO_STRING(ARRAY_AGG(distinct(assignlistids)), ',') as assignlist from adminassignlist where adminids=al.id and is_deleted=1 GROUP BY adminids),(select ARRAY_TO_STRING(ARRAY_AGG(distinct(stids)), ',') as assignstids from adminassignlist where adminids=al.id and is_deleted=1 GROUP BY adminids) 
 // from admin_login al where al.id=".$_SESSION['login_id']."";

 // $query = "select al.*
 // from admin_login al where al.id=".$_SESSION['login_id']."";
if(isset($_SESSION['activeyears']) && $_SESSION['activeyears']!='')
{
    $checkval = array($_SESSION['activeyears'],$_SESSION['login_id']); 

    $query = "select al.*,(select ARRAY_TO_STRING(ARRAY_AGG(DISTINCT(userassign.\"rcuyear\")), ',') as assignyears from userassign where rcids=al.id  GROUP BY rcids ) ,
(select ARRAY_TO_STRING(ARRAY_AGG(userassign.\"STID\"), ',') as assignlist from userassign where rcids=al.id  and rcuyear=$1
 GROUP BY rcids),(select ARRAY_TO_STRING(ARRAY_AGG(userassign.\"DTID\"), ',') as assignlistdist from userassign where rcids=al.id  and rcuyear=$1
 GROUP BY rcids)
 from admin_login al where al.id=$2";
 $result = pg_query_params($db,$query,$checkval);
}
else
{
    $checkval = array($_SESSION['login_id']); 

    $query = "select al.*,(select ARRAY_TO_STRING(ARRAY_AGG(DISTINCT(userassign.\"rcuyear\")), ',') as assignyears from userassign where rcids=al.id  GROUP BY rcids ) from admin_login al where al.id=$1";
    $result = pg_query_params($db,$query,$checkval);

}



 // $query = "select al.*,(select ARRAY_TO_STRING(ARRAY_AGG(DISTINCT(userassign.\"rcuyear\")), ',') as assignyears from userassign where rcids=al.id  GROUP BY rcids ) ".$concate."
 // from admin_login al where al.id=".$_SESSION['login_id']."";



// $query = "select al.*,(select ARRAY_TO_STRING(ARRAY_AGG(assignlistids), ',') as assignlist from adminassignlist where adminids=al.id and is_deleted=1 GROUP BY adminids),(select ARRAY_TO_STRING(ARRAY_AGG(distinct(stids)), ',') as assignstids from adminassignlist where adminids=al.id and is_deleted=1 GROUP BY adminids) from admin_login al where al.id=".$_SESSION['login_id']."";

// $result = pg_query($db, $query);
$rows = pg_fetch_array($result);
$checkval1 = array($_SESSION['activeyears']); 
 $getbase = "select * from jcyearbaseyear where selyear=$1";
$byquery = pg_query_params($db,$getbase,$checkval1);
$byquerydata = pg_fetch_array($byquery);

$rows['baseyear'] = $byquerydata['baseyear'];
$_SESSION['logindetails'] = $rows;






// print_r($_SESSION);


$header='';


$header = $rows['admin_type'];

// echo "<pre>";
// print_r($rows);
//   print_r($_SESSION);
?>



<!DOCTYPE html>
<html lang="en">


<head>

    <meta Content-Type: text/plain; charset=UTF-8 />
    <title>Dashboard | CMS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="" name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="image/logo1.jpg">

   <!--  Solution for "using components with known vulnerabilities i.e., updating the libraries as mentioned"    -->
    

<!-- 
   <script srnt.min.js" integrity="sha512-CryKbMe7sjSCDPl18jtJI5DR5jtkUWxPXWaLCst6QjH8wxDexfRJic2WRmRXmstr2Y8SxDDWuBO6CQC6IE4KTA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
c="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/mome
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js" integrity="sha512-XMVd28F1oH/O71fzwBnV7HucLxVwtxf26XV8P4wPk26EDxuGZ91N8bsOttmnomcCD3CS5ZMRL50H0GgOHvegtg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

   <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script> -->

   <script src="assets/libs/moment/moment.min.js"></script>
   <script src="assets/libs/jszip/jszip.min.js"></script>
   <script src="assets/js/jquery.min.js"></script>
   <!-- <script src="assets/js/xlsx.full.min.js"></script> -->

      

   <!-- -->

    <!-- Sweet Alert-->
    <link href="assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <!-- Notification css (toastr) -->
    <link href="assets/libs/toastr/toastr.min.css" rel="stylesheet" type="text/css" />
    <!-- Plugins css -->
    <link href="assets/libs/dropify/dropify.min.css" rel="stylesheet" type="text/css" />
    <!-- App css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bootstrap-stylesheet" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-stylesheet" />

    <link href="assets/css/style.css" rel="stylesheet" type="text/css" />


    <!-- Table datatable css -->
    <link href="assets/libs/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <!--  <link href="assets/libs/datatables/fixedHeader.bootstrap4.min.html" rel="stylesheet" type="text/css" /> -->
    <link href="assets/libs/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/datatables/scroller.bootstrap4.min.css" rel="stylesheet" type="text/css" />


    <!-- Plugins css -->
    <link href="assets/libs/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/switchery/switchery.min.css" rel="stylesheet" type="text/css" />

    <link href="assets/libs/multiselect/multi-select.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/select2/dist/css/select2.css" rel="stylesheet" type="text/css" />
    <!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> -->
    <link href="assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/switchery/switchery.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css">
    <link href="assets/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.css" rel="stylesheet" type="text/css">
    <link href="assets/libs/bootstrap-datepicker/bootstrap-datepicker.css" rel="stylesheet" type="text/css">
    <link href="assets/libs/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet" type="text/css">

</head>


<body class="center-menu" data-layout="horizontal">



    <!-- Begin page -->
    

    <div id="wrapper">
        <!-- Navigation Bar-->
     