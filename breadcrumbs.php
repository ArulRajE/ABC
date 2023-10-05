<?php 
$filename = basename($_SERVER['PHP_SELF']);

            $ahrfdt = "#";
            $ahrfsd = "#";
            $ahrfvt = "#";
            $dt='';
            $aaaa='';
            $stc ='';
           if($filename=='districts.php' && isset($_GET['ids']) && $_GET['ids']!='')
           {    

                $array = array($STIDDATA[1]);

                $sqlq = 'select * from "stCount'.$_SESSION['logindetails']['baseyear'].'" Full JOIN "stCount'.$_SESSION['activeyears'].'" On "stCount'.$_SESSION['logindetails']['baseyear'].'"."STID'.$_SESSION['logindetails']['baseyear'].'"="stCount'.$_SESSION['activeyears'].'"."STID" where "stCount'.$_SESSION['activeyears'].'"."STID" =$1';
                $resultbox = pg_query_params($db,$sqlq,$array);
                $boxdata = pg_fetch_array($resultbox);
                $statecount =$boxdata['STName'];
                $districtscount =(int)$boxdata['Districts'];
                $subdistrictscount =(int)$boxdata['SubDistricts'];
                $villagecount =(int)$boxdata['Villages'];
                $towncount =(int)$boxdata['Towns'];
                $wardscount =(int)$boxdata['Wards'];
                $ids=base64_encode('321**'.$boxdata['STID'].'**123');
                $ahrfdt = "districts?ids=$ids";

                
           }
           else  if($filename=='subdistricts.php' && isset($_GET['ids']) && $_GET['ids']!='')
           {
            $array = array($STIDDATA[1]);
                $resultbox = pg_query_params($db, 'select * from "dtCount'.$_SESSION['logindetails']['baseyear'].'" Full JOIN "dtCount'.$_SESSION['activeyears'].'" On "dtCount'.$_SESSION['logindetails']['baseyear'].'"."DTID'.$_SESSION['logindetails']['baseyear'].'"="dtCount'.$_SESSION['activeyears'].'"."DTID" where "dtCount'.$_SESSION['activeyears'].'"."DTID" = $1',$array);
                $boxdata = pg_fetch_array($resultbox);

                 // echo "<pre>";
                 //  print_r($boxdata);
                $statecount =$boxdata['STName'];
                $districtscount =$boxdata['DTName'];
                $subdistrictscount =(int)$boxdata['SubDistricts'];
                $villagecount =(int)$boxdata['Villages'];
                $towncount =(int)$boxdata['Towns'];
                $wardscount =(int)$boxdata['Wards'];
                // echo "=================".trim($boxdata['STID']);
                 $ids=base64_encode('321**'.trim($boxdata['STID']).'**123');
                 $idssd=base64_encode('321**'.trim($boxdata['DTID']).'**123**321**'.trim($boxdata['STID']).'**123');
                $ahrfdt = "districts?ids=$ids";
                $ahrfsd = "subdistricts?ids=$idssd";
           }
            else  if($filename=='villages.php' && isset($_GET['ids']) && $_GET['ids']!='')
           {

           $array = array($STIDDATA[1]);

                $resultbox = pg_query_params($db, 'select * from "sdCount'.$_SESSION['logindetails']['baseyear'].'" Full JOIN "sdCount'.$_SESSION['activeyears'].'" On "sdCount'.$_SESSION['logindetails']['baseyear'].'"."SDID'.$_SESSION['logindetails']['baseyear'].'"="sdCount'.$_SESSION['activeyears'].'"."SDID" where "sdCount'.$_SESSION['activeyears'].'"."SDID" = $1',$array);
                $boxdata = pg_fetch_array($resultbox);
               //  print_r($boxdata);
                $statecount =$boxdata['STName'];
                $districtscount =$boxdata['DTName'];
                $subdistrictscount =$boxdata['SDName'];
                $villagecount =(int)$boxdata['Villages'];
                $towncount =(int)$boxdata['Towns'];
                $wardscount =(int)$boxdata['Wards'];
                 $ids=base64_encode('321**'.trim($boxdata['STID']).'**123');
                $idssd=base64_encode('321**'.trim($boxdata['DTID']).'**123**321**'.trim($boxdata['STID']).'**123');

                $ahrfdt = "districts?ids=$ids";
                $ahrfsd = "subdistricts?ids=$idssd";
                

           }
           //    else  if($filename=='wards.php' && isset($_GET['ids']) && $_GET['ids']!='')
           // {


           //      $resultbox = pg_query($db, 'select * from "vtCount2011" Full JOIN "vtCount2021" On "vtCount2011"."VTID2011"="vtCount2021"."VTID2021" where "vtCount2021"."VTID2021" = '.$STIDDATA[1].'');
           //      $boxdata = pg_fetch_array($resultbox);
           //    //  print_r($boxdata);
           //     $statecount =$boxdata['STName2021'];
           //      $districtscount =$boxdata['DTName2021'];
           //      $subdistrictscount =$boxdata['SDName2021'];
           //      //  echo "+++++++++++".$boxdata['Level2021'];
           //      if(trim($boxdata['Level2021'])=="TOWN")
           //      {
           //      $villagecount = 0;
           //      $towncount = $boxdata['VTName2021'];
           //      }
           //      else
           //      {
              
           //      $villagecount =$boxdata['VTName2021'];
           //      $towncount =0;
           //      }
               
           //       $wardscount =(int)$boxdata['Wards21'];

           //        $ids=base64_encode('321**'.trim($boxdata['STID']).'**123');
           //      $idssd=base64_encode('321**'.trim($boxdata['DTID2021']).'**123**321**'.trim($boxdata['STID']).'**123');
           //      $idsvt=base64_encode('321**'.trim($boxdata['SDID2021']).'**123**321**'.trim($boxdata['DTID2021']).'**123**321**'.trim($boxdata['STID']).'**123');
           //      $ahrfdt = "districts?ids=$ids";
           //      $ahrfsd = "subdistricts?ids=$idssd";
           //      $ahrfvt = "villages?ids=$idsvt";

           // }

            else
            {
                $statecount =$stc;
                $districtscount = $dt;
                $subdistrictscount =0;
                $villagecount =0;
                $towncount =0;
                $wardscount =0;
                 $ahrfdt = "#";
                $ahrfsd = "#";
                $ahrfvt = "#";

            }

 

$breadcrumbs = "";
$array = array('profile.php','users.php','units.php','alldistricts.php','allsubdistricts.php','allvillages.php','alltown.php','allwards.php','districts.php','subdistricts.php','villages.php','wards.php','circulars.php','document.php','adddocument.php');

$arraynew = array('units.php','districts.php','subdistricts.php','villages.php','wards.php');
  $urldata = array('',$ahrfdt,$ahrfsd,$ahrfvt);
if(in_array($filename, $array))
{
    if($filename=='units.php')
    {
        $name = "States";

         $breadcrumbs = "<a href='units' >".$name."</a>"; 
         $aaaa = "Administrative Units /";     
    }
    else
    {

      if(in_array($filename, $arraynew))
      {


            $data = "";
            for($i=0;$i<count($arraynew);$i++)
            {
              $nameexp = explode('.',$arraynew[$i]);
        $name = ucfirst($nameexp[0]);
     
                if($arraynew[$i]==$filename)
                {
                    //  echo "INNNNNNNNNNNNN";

                      if($arraynew[$i]=='units.php')
                      {
                        $data .="<a href='units' class='breadcrumbs' >States</a> / ";
                         $aaaa = "Administrative Units /"; 
                         break;
                      }
                      else
                      {
                         if($arraynew[$i]=="adddocument.php")
        {
         $name = "Add Document"; 
        }
        if($arraynew[$i]=="villages.php")
        {
         $name = "Villages_Towns"; 
        }
                       $data .="<a href='".$urldata[$i]."'>".$name."</a> / "; 
                         break;
                      }

                  
                }
                else
                {

                    if($arraynew[$i]=='units.php')
                      {
                        $data .="<a href='units' class='breadcrumbs' >States</a> / ";
                      }
                      
                      else
                      {
if($arraynew[$i]=="villages.php")
        {
         $name = "Villages_Towns"; 
        }
                         if($arraynew[$i]=="adddocument.php")
        {
         $name = "Add Document"; 
        }


                       $data .="<a href='".$urldata[$i]."' class='breadcrumbs' >".$name."</a> / "; 
                        
                      }
                } 

            }
      
         $breadcrumbs = rtrim($data, '/ ');   
         $aaaa = "Administrative Units /"; 
      }
      else
      {
        $nameexp = explode('.',$filename);
        $name = ucfirst($nameexp[0]);
       
 if($name=="Document")
        {
         $name = $name."s"; 
        }
         if($name=="Adddocument")
        {
         $name = "Add Document"; 
        }

     // Commented to remove titles from Top left corner by veena
    //  $breadcrumbs = "<a>".$name."</a>";  
        
      }
      
       // if($name=='Villages')
       // {

       //  $name = "Villages_Town";
       // }

    }
  //   echo "VVVVV".$breadcrumbs;
  // echo "IIII". $name;

    
}
else
{

  $name = explode('.',$filename);
 //  print_r($name[0]);
   if($name[0]=="Adddocument")
        {
         $name = "Add Document"; 
        }

if($name[0]=="setdates")
        {
         $name = array("Set Dates"); 
       
        }

        if($name[0]=="forread")
        {
         $name = array("for Read"); 
       
        }

    $breadcrumbs = ucfirst($name[0]);
   $aaaa = "";
}

 ?>


<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title"> <?php echo $aaaa; ?> <?php echo $breadcrumbs; ?></h4>
        </div>
    </div>
</div>
