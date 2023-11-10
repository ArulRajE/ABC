<?php include ("header.php"); include ("topbar.php"); include ("menu.php");
$where = ""; 
$action = "";
if($header!=0 && $rows['assignlist']!=null && $rows['assignlist']!='0')  
{
    $action = explode(',',$rows['assignlist']);
   $where = 'where "stCount2021"."STID" ='.$rows['assignlist'].'';
    $arr = array($rows['assignlist']);
    $result = pg_query_params($db, 'select * from "stCount'.$_SESSION['logindetails']['baseyear'].'" Full JOIN "stCount'.$_SESSION['activeyears'].'" On "stCount'.$_SESSION['logindetails']['baseyear'].'"."STID'.$_SESSION['logindetails']['baseyear'].'"="stCount'.$_SESSION['activeyears'].'"."STID" where "stCount'.$_SESSION['activeyears'].'"."STID" =$1',$arr);
$result_a=pg_fetch_all($result);
}
else
{
    $result = pg_query($db, 'select * from "stCount'.$_SESSION['logindetails']['baseyear'].'" Full JOIN "stCount'.$_SESSION['activeyears'].'" On "stCount'.$_SESSION['logindetails']['baseyear'].'"."STID'.$_SESSION['logindetails']['baseyear'].'"="stCount'.$_SESSION['activeyears'].'"."STID" ');
$result_a=pg_fetch_all($result);

}




// $stc=0;
for($k=0;$k<count($result_a);$k++)
{
    // echo "<pre>";
    // print_r($result_a);
    
    if($result_a[$k]['STName']!='')
    {
       
        $st=$st+1;
    }
}


$resultstate = pg_query($db, 'select "st'.$_SESSION['logindetails']['baseyear'].'"."STID","st'.$_SESSION['logindetails']['baseyear'].'"."STName","st'.$_SESSION['activeyears'].'"."STID","st'.$_SESSION['activeyears'].'"."STName" from "st'.$_SESSION['logindetails']['baseyear'].'" Full JOIN "st'.$_SESSION['activeyears'].'" On "st'.$_SESSION['logindetails']['baseyear'].'"."STID"="st'.$_SESSION['activeyears'].'"."STID" Order By "st'.$_SESSION['logindetails']['baseyear'].'"."STID","st'.$_SESSION['activeyears'].'"."STID"');
$row = pg_fetch_all($resultstate); 

$arr1 = array('ST','1');
$resultaction = pg_query_params($db, "select * from detailforread where comefrom=$1 and is_deleted=$2 order by statuslevel ASC",$arr1);
$rowaction = pg_fetch_all($resultaction); 
// $result = pg_query($db, 'select * from "stCount2011" Full JOIN "stCount2021" On "stCount2011"."STID2011"="stCount2021"."STID2021" '.$where.'');
// echo "JIGAR".$total = pg_numrows($result);

// function getactiondata($STIDS,$level,$db)
// {

//         $query = "select array_to_string(array_agg(dataforread.\"For2011\"), ',') AS For2011,dataforread.\"ChangeFrom\",dataforread.\"ChangeTo\",
//         array_to_string(array_agg(dataforread.\"Read".$_SESSION['activeyears']."\"), ',') AS read".$_SESSION['activeyears'].",
//         a_to_string(( SELECT array_agg(st".$_SESSION['activeyears']."_1.\"STName\") AS array_agg FROM st".$_SESSION['activeyears']." st".$_SESSION['activeyears']."_1 WHERE st".$_SESSION['activeyears']."_1.\"STID\" = ANY (array_agg(dataforread.\"Read".$_SESSION['activeyears']."\"))), ',') AS 
//         forreadname,
//         array_to_string(( SELECT array_agg(st".$_SESSION['activeyears']."_1.\"STName\") AS array_agg FROM st".$_SESSION['activeyears']." st".$_SESSION['activeyears']."_1 WHERE st".$_SESSION['activeyears']."_1.\"STID\" = ANY (array_agg(dataforread.\"For2011\"))), ',') AS 
//         forreadnamefor,
//         (select \"detailforread\".\"forreaddetails\" from detailforread where \"detailforread\".\"statuslevel\"=dataforread.\"ChangeTo\" and is_deleted=1 AND comefrom='ST') AS 
//         whattodo,
//         (select \"detailforread\".\"forreaddetails\" from detailforread where \"detailforread\".\"statuslevel\"=dataforread.\"ChangeFrom\" and is_deleted=1 AND comefrom='ST') AS 
//         whattodofor,
//         (select \"detailforread\".\"statusicon\" from detailforread where \"detailforread\".\"statuslevel\"=dataforread.\"ChangeTo\" and is_deleted=1 AND comefrom='ST') AS 
//         statusicon from dataforread where \"dataforread\".\"For2011\"=".$STIDS." OR \"dataforread\".\"Read".$_SESSION['activeyears']."\"=".$STIDS." GROUP BY dataforread.\"ChangeFrom\",dataforread.\"ChangeTo\"";
//       $sql = pg_query($db,$query); 
//       if(pg_numrows($sql)>0)
//       {
//           $ro = pg_fetch_all($sql);
       
//         return $ro; 
//       }
//       else
//       {
//           return array();
//       } 
// }



// function getselected($findvalue,$level,$db)
// {

//     $sql = pg_query($db,"select * from detailforread where statuslevel=".$findvalue." and comefrom='".$level."' and is_deleted=1");
   
//     if(pg_numrows($sql)>0)
//     {
//         $ro = pg_fetch_array($sql);
     
//       return $ro; 
//     }
//     else
//     {
//         return array("forreaddetails"=>"","statusicon"=>"");
//     }
// }

 $qi="SELECT  
     string_agg(ids,',') as stids
FROM stincompleted";
$pg_query=pg_query($db,$qi);
$pg_query_data = pg_fetch_row($pg_query);

if($pg_query_data[0]=='')
{
    $arraydata = array();
}
else
{
$arraydata = explode(',',$pg_query_data[0]);    
}


?>
<style type="text/css">
.dataTables_scrollBody {
    max-height: 550px !important;
}
</style>

<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->

<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <?php include("breadcrumbs.php"); ?>
            <!-- start page title -->


            <!-- end page title -->
            <?php include("box.php"); ?>
            <!-- end row -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dropdown float-right">
                                <?php if($header==0) { ?>
                                <!-- <button class="btn btn-primary btn-rounded waves-effect waves-light" data-toggle="modal"
                                    data-target="#con-close-modal-add" data-backdrop="static" data-keyboard="false"> <i
                                        class="fas fa-plus-circle mr-1"></i> <span>ADD STATE</span> </button> -->
                                <?php } ?>
                            </div>
                            <h4 class="header-title mb-4"><span class="dropcap text-primary">Statewise</span>
                                Administrative Units - Census <?php echo $_SESSION['logindetails']['baseyear']; ?> - Census <?php echo $_SESSION['activeyears']; ?></h4>

                                <!-- modified by sahana to download Administrative Units state data  -->
<!-- Include the xlsx library -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js" integrity="sha512-r22gChDnGvBylk90+2e/ycr3RVrDi8DIOkIGNhJlKfuyQM4tIRAI062MaV8sfjQKYVGjOBaZBOA87z+IhZE9DA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
<script src="assets/js/xlsx.full.min.js"></script>
<!-- HTML code with the dropdown -->
<div class="dropdown">
  <button class="btn btn-primary dropdown-toggle" type="button" id="yearDropdownButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="margin-left: 90%; margin-bottom: 10px;">
  <i class="fa fa-download"></i> Download
  </button>
  <div class="dropdown-menu" aria-labelledby="yearDropdownButton" style="margin-left: 90%">
    <a class="dropdown-item" href="#" data-year="2011">2011</a>
    <a class="dropdown-item" href="#" data-year="2021">2021</a>
    <a class="dropdown-item" href="#" data-year="2011-2021">2011-2021</a>
  </div>
</div>

<!-- JavaScript code to handle the dropdown selection and to download the data-->
<script>
$(document).ready(function() {
  $(document).on('click', '.dropdown-item', function() {
    var selectedYear = $(this).data('year');
    console.log('Selected year:', selectedYear);
    
    if (selectedYear == '2011' || selectedYear == '2021' || selectedYear == '2011-2021') {
      // Create a workbook and add a worksheet
      var wb = XLSX.utils.book_new();
      var table = document.getElementById('units-datatable');
      
      // Create a new table with only the desired columns for 2011
      if (selectedYear == '2011') {
        var newTable = document.createElement('table');
        var thead = document.createElement('thead');
        var headerRow = document.createElement('tr');
        var columns = ["State / UT Code", "State / UT Name", "Districts", "Sub-districts", "Villages", "Towns"];
        
        // Create header cells for 2011
        for (var i = 0; i < columns.length; i++) {
          var th = document.createElement('th');
          th.textContent = columns[i];
          headerRow.appendChild(th);
        }
        
        thead.appendChild(headerRow);
        newTable.appendChild(thead);
        
        // Copy data rows for 2011
        var tbody = document.createElement('tbody');
        var dataRows = table.tBodies[0].rows;
        for (var j = 0; j < dataRows.length; j++) {
          var rowData = dataRows[j].cells;
          var newRow = document.createElement('tr');
          
          // Copy cells for 2011
          for (var k = 0; k < columns.length; k++) {
            var td = document.createElement('td');
            td.textContent = rowData[k].textContent;
            newRow.appendChild(td);
          }
          
          tbody.appendChild(newRow);
        }
        
        newTable.appendChild(tbody);
        table = newTable;
      }
      
      // Create a new table with only the last 10 columns for 2021
      if (selectedYear == '2021') {
        var newTable = document.createElement('table');
        var thead = document.createElement('thead');
        var headerRow = document.createElement('tr');
        var columns = ["State / UT Code", "State / UT Name", "Districts", "Sub-districts", "Villages", "Towns", ""];
        
        // Create header cells for 2021
        for (var i = 0; i < columns.length; i++) {
          var th = document.createElement('th');
          th.textContent = columns[i];
          headerRow.appendChild(th);
        }
        
        thead.appendChild(headerRow);
        newTable.appendChild(thead);
        
        // Copy data rows for 2021
        var tbody = document.createElement('tbody');
        var dataRows = table.tBodies[0].rows;
        for (var j = 0; j < dataRows.length; j++) {
          var rowData = dataRows[j].cells;
          var newRow = document.createElement('tr');
          
          // Copy last 6 cells for 2021
          for (var k = rowData.length - 6; k < rowData.length; k++) {
            var td = document.createElement('td');
            td.textContent = rowData[k].textContent;
            newRow.appendChild(td);
          }
          
          tbody.appendChild(newRow);
        }
        
        newTable.appendChild(tbody);
        table = newTable;
      }
      
      var ws = XLSX.utils.table_to_sheet(table);
      
      // Add the worksheet to the workbook
      XLSX.utils.book_append_sheet(wb, ws, 'Administrative Units');
      
      // Generate the Excel file in binary form
      var wbout = XLSX.write(wb, { bookType: 'xlsx', type: 'binary' });
      
      // Convert the binary data to a Blob object
      var blob = new Blob([s2ab(wbout)], { type: 'application/octet-stream' });
      
      // Create a temporary link element to trigger the download
      var link = document.createElement('a');
      link.href = window.URL.createObjectURL(blob);
      link.download = 'State-Level_Administrative_Units_' + selectedYear + '.xlsx';
      link.style.display = 'none';
      document.body.appendChild(link);
      
      // Trigger the download
      link.click();
      
      // Clean up the temporary link element
      document.body.removeChild(link);
      
      toastr['success']('Administrative Units ' + selectedYear + ' Downloaded Successfully For State Level.');
    }
  });
});

// Convert data to array buffer
function s2ab(s) {
  var buf = new ArrayBuffer(s.length);
  var view = new Uint8Array(buf);
  for (var i = 0; i < s.length; i++) {
    view[i] = s.charCodeAt(i) & 0xff;
  }
  return buf;
}
</script>


                            <table id="units-datatable" class="table table-hover table-striped table-bordered"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th colspan="6" style="background-color: #fe6271; color: #FFFFFF">Administrative Units - Census <?php echo $_SESSION['logindetails']['baseyear']; ?></th>
                                        <th colspan="10" style="background-color: #15bed2; color: #FFFFFF ">
                                            Administrative Units - Census <?php echo $_SESSION['activeyears']; ?></th>

                                    </tr>
                                    <tr>
                                        <th>State / UT Code</th>
                                        <th>State / UT Name</th>
                                        <th>Districts</th>
                                        <th>Sub-districts</th>
                                        <th>Villages</th>
                                        <th>Towns</th>
                                        <!-- <th>Wards</th> -->

                                        <th>State / UT Code</th>
                                        <th>State / UT Name</th>
                                        <th>Districts</th>
                                        <th>Sub-districts</th>
                                        <th>Villages</th>
                                        <th>Towns</th>
                                        <!-- <th>Wards</th> -->
                                        <!-- <th>Status</th>
                                        <th>Linked Document</th> -->
                                      <!--   <th>
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown">
                                                    <i class="mdi mdi-dots-vertical"></i>
                                                </a>
                                            </div>
                                        </th> -->
                                        <th>Map Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 

                                                $dt = 0;
                                                $sd = 0;
                                                $vt = 0;
                                                $ct = 0;
                                                $wd = 0;
                                                while ($data = pg_fetch_array($result)) { 
                                                   

                                                   $datanew = json_decode('[' . substr($data['read'.$_SESSION['activeyears'].''], 1, -1) . ']');

                                                   $dataforreadname = substr($data['forreadname'], 1, -1);

                                                    $dt = $dt + (int)$data['Districts'];
                                                    $sd = $sd + (int)$data['SubDistricts'];
                                                    $vt = $vt + (int)$data['Villages'];
                                                    $ct = $ct + (int)$data['Towns'];
                                                   //  $wd = $wd + (int)$data['Wards'];
                                                    $dataflag='';
                                                    $dataflag2011='';
                                                    if($data['STName']!='' && $data['Status']=='UT')
                                                    {
                                                        $dataflag = ' - ('.$data['Status'].')';
                                                      
                                                    }
                                                    if($data['STName'.$_SESSION['logindetails']['baseyear'].'']!='' && $data['Status'.$_SESSION['logindetails']['baseyear'].'']=='UT')
                                                    {
                                                       
                                                        $dataflag2011 = ' - ('.$data['Status'.$_SESSION['logindetails']['baseyear'].''].')';
                                                    }

                                                    $fla=false;                                                 
                                                    if (in_array($data['STID'], $arraydata))
                                                    {
                                                        $fla=true;  
                                                    }
                                                         
                                                    //By sahana 0111
                                                    $stid = $data['STID2011']; 
                                                    $query2 = 'SELECT * FROM st' . $_SESSION['activeyears'] . ' WHERE "STID" = $1';
                                                    $result2 = pg_query_params($db, $query2, array($stid));
                                                    
                                                    if (!$result) {
                                                        echo 'Query failed: ' . pg_last_error($db);
                                                    }

                                                    $data2 = pg_fetch_array($result2)

                                          ?>

                                        <tr <?php if($fla){ ?>class="incompleted"<?php  } ?> >
                                       <!-- modified by sahana to add 0 to first 9 numbers for STID 2011 -->
                                       <?php
                                        $number = $data['STID'.$_SESSION['logindetails']['baseyear']];
                                        $formattedNumber = ($number >= 1 && $number <= 9) ? str_pad($number, 2, '0', STR_PAD_LEFT) : $number;
                                        ?>
                                        <td><?php echo $formattedNumber; ?></td>
                                        <!-- Changes for Admin New State issue By Sahana -->
                                        <!-- <td><?php// echo $data['STID'.$_SESSION['logindetails']['baseyear'].'']; ?></td> -->
                                        <td><?php echo $data['STName'.$_SESSION['logindetails']['baseyear'].''].$dataflag2011; ?></td>
                                        <td><?php echo $data['Districts'.$_SESSION['logindetails']['baseyear'].'']; ?></td>
                                        <td><?php echo $data['SubDistricts'.$_SESSION['logindetails']['baseyear'].'']; ?></td>
                                        <td><?php echo $data['Villages'.$_SESSION['logindetails']['baseyear'].'']; ?></td>
                                        <td><?php echo $data['Towns'.$_SESSION['logindetails']['baseyear'].'']; ?></td>


                                        <!-- modified by sahana to add 0 to first 9 numbers for STID 2021  -->
                                        <td class="<?php if ($fla) { ?>incompleted<?php } ?>class2021">
                                            <?php
                                            $number = $data['STID'];
                                            if ($number >= 1 && $number <= 9) {
                                                $formattedNumber = str_pad($number, 2, '0', STR_PAD_LEFT);
                                            } else {
                                                $formattedNumber = $number;
                                            }
                                            echo $formattedNumber;
                                            ?>
                                        </td>
                                        <!-- Changes for Admin New State issue By Sahana -->
                                        <!-- <td class="<?php //if($fla){ ?>incompleted<?php // } ?>class2021"><?php //echo $data['STID']; ?></td> -->
                                        <td class="<?php if($fla){ ?>incompleted<?php  } ?>class2021"><?php echo $data['STName'].$dataflag; ?></td>
                                        <td class="<?php if($fla){ ?>incompleted<?php  } ?>class2021"><?php echo $data['Districts']; ?></td>
                                        <td class="<?php if($fla){ ?>incompleted<?php  } ?>class2021"><?php echo $data['SubDistricts']; ?></td>
                                        <td class="<?php if($fla){ ?>incompleted<?php  } ?>class2021"><?php echo $data['Villages']; ?></td>
                                        <td class="<?php if($fla){ ?>incompleted<?php  } ?>class2021"><?php echo $data['Towns']; ?></td>
                                        


                                        <?php 
                                        
                                        if($data['STID']==null)
                                        {
                                            $dataidsof = $data['STID'.$_SESSION['logindetails']['baseyear'].''];
                                        }
                                        else
                                        {
                                            $dataidsof = $data['STID'];
                                        }
                                       //  $arraydata = getactiondata($dataidsof,'ST',$db);
                                      

                                       ?>
                                    <?php /*     <td class="class2021">
                                            <?php for($i=0;$i<count($arraydata);$i++) { 
                                                if($dataidsof==$arraydata[$i]['for2011'] && $dataidsof!=$arraydata[$i]['read'.$_SESSION['activeyears'].''])
                                                {
                                                    $title = $arraydata[$i]['whattodo']." at ".$arraydata[$i]['forreadname'];
                                                }
                                                else if($dataidsof!=$arraydata[$i]['for2011'] && $dataidsof==$arraydata[$i]['read'.$_SESSION['activeyears'].''])
                                                {
                                                    $title = $arraydata[$i]['whattodofor']." From ".$arraydata[$i]['forreadnamefor'];
                                                }
                                                else if($dataidsof==$arraydata[$i]['for2011'] && $dataidsof==$arraydata[$i]['read'.$_SESSION['activeyears'].''])
                                                {
                                                    $title = $arraydata[$i]['whattodofor'];
                                                }
                                                else
                                                {
                                                    $title = "";
                                                }
                                                

                                                ?>
                                        <i class="<?php echo $arraydata[$i]['statusicon']; ?>"
                                                data-toggle="tooltip" data-placement="top" title=""
                                                data-original-title='<?php echo $title; ?>'>
                                        </i>
                                        <?php } ?>
                                        </td>
                                        <td class="class2021  <?php if((int)$data['linkeddocument21']!=0 && $action == "") { ?> btnlinked <?php } ?>"
                                            <?php if((int)$data['linkeddocument21']!=0 && $action == "" ) { ?>
                                            data-target="#con-close-modal-linked"
                                            data-todo=' <?php echo json_encode($data); ?>'
                                            data-id="<?php echo $data['STID']; ?>" <?php } ?>><a
                                                <?php if((int)$data['linkeddocument21']!=0 && $action == "") { ?>
                                                href="javascript:void(0);" class="btnlinked"
                                                data-target="#con-close-modal-linked"
                                                data-todo='<?php echo json_encode($data); ?>'
                                                data-id="<?php echo $data['STID']; ?>" <?php } else {  ?>
                                                class="noaction" data-id="<?php echo $data['STID']; ?>"
                                                <?php } ?>><?php echo (int)$data['linkeddocument21']; ?></a>
                                        </td> */ ?>

                                       <?php /* <td class="<?php if($fla){ ?>incompleted<?php  } ?>class2021 btnlink">
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown"
                                                    aria-expanded="true">
                                                    <i class="mdi mdi-dots-vertical"></i>
                                                </a>
                                               <?php  if(isset($data['STID']) && ($data['STID']!='' || $data['STID']!=null)) { ?>
                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <li><a href="#" <?php if($action == "") { ?> data-toggle="modal"
                                                            data-target="#con-close-modal"
                                                            class="dropdown-item btnEditnew"
                                                            data-id="<?php echo $data['STID']; ?>"
                                                            data-todo='<?php echo json_encode($data); ?>'
                                                            <?php } else {  ?> class="dropdown-item noaction"
                                                            data-id="<?php echo $data['STID']; ?>"
                                                            <?php } ?>>Update</a></li>
                                                    <li><a href="javascript:void(0);"
                                                            <?php if($action == "" || in_array($data['STID'], $action)) { ?>
                                                            data-target="#con-close-modal-link"
                                                            data-todo='<?php echo json_encode($data); ?>'
                                                            data-id="<?php echo $data['STID']; ?>"
                                                            class="dropdown-item btnlink" <?php } else {  ?>
                                                            class="dropdown-item noaction"
                                                            data-id="<?php echo $data['STID']; ?>" <?php } ?>>Link
                                                            Document</a></li>
                                                    <li class="dropdown-divider"></li>
                                                    <li><a href="javascript:void(0);" <?php if($action == "") { ?>
                                                            id="<?php echo $data['STID']; ?>"
                                                            class="dropdown-item deletetablerow" <?php } else {  ?>
                                                            class="dropdown-item noaction"
                                                            data-id="<?php echo $data['STID']; ?>"
                                                            <?php } ?>>Delete</a></li>
                                                </ul>
                                                <?php  } ?>
                                            </div>
                                        </td>*/ ?>
                                        <td><input type = "checkbox" id="myCheckbox" style ="cursor:pointer"></td>
                                    </tr>
                                    <?php } 
                                                ?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>



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
<script>
//modified by sahana map checkbox
var checkboxes = document.querySelectorAll("input[id='myCheckbox']");
checkboxes.forEach(function(checkbox) {
    checkbox.addEventListener("click", function(event) {
        var row = checkbox.closest("tr");
        var stName = row.querySelector("td:nth-child(8)").textContent;

        Swal.fire({
            type: checkbox.checked ? "success" : "error",
            title: "Verification",
            text: checkbox.checked
                ? "I have verified that as per the uploaded document (notification), " + stName + " administrative units have been updated in the map"
                : "I have verified that as per the uploaded document (notification), " + stName + " administrative units have NOT been updated in the map",
            confirmButtonText: "Agree",
        });
        event.stopPropagation();
    });
});
</script>

<?php // include ("rightsidebar.php"); ?>

<?php include ("footer.php"); ?>

<div id="con-close-modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">

    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form class="form-horizontal group-border-dashed parsley-examples" id="updatestate">
                <input type="hidden" name="update_ids" id="update_ids" value="">
                <input type="hidden" name="getrecords" id="getrecords" value="">
                <input type="hidden" name="Leveldataup" id="Leveldataup" value="ST">
                <!--  <input type="hidden" name="formname" id="formname" value="updatestatedata"> -->
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white">UPDATE STATE</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12">
                            <div>

                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">&nbsp;</label>

                                    <label class="col-md-5 col-form-label">2011</label>
                                    <label class="col-md-5 col-form-label">2021</label>


                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">State Name</label>
                                    <div class="col-md-5">
                                        <input type="text" name="STName2011" id="STName2011" class="form-control"
                                            disabled="disabled" placeholder="" />
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" name="STName2021"
                                            id="STName2021" placeholder="State Name 2021" />
                                    </div>

                                </div>

                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">Status</label>
                                    <div class="col-md-5">
                                        &nbsp;
                                    </div>
                                    <div class="col-md-5 pt-2">
                                        <select id="upStatus2021" name="upStatus2021">
                                            <option value="">Select Status</option>
                                            <option value="ST">State</option>
                                            <option value="UT">Union Territory</option>

                                        </select>

                                    </div>

                                </div>

                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">Short code</label>

                                    <div class="col-md-5">
                                        <input type="text" class="form-control" id="Short_ST2011" name="Short_ST2011"
                                            disabled="disabled" placeholder="" />
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" data-parsley-minlength="1"
                                            data-parsley-maxlength="3" id="Short_ST2021" name="Short_ST2021"
                                            placeholder="Short code" />
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label class="col-md-2 col-form-label">MDDS Code</label>

                                    <div class="col-md-5">
                                        <input type="text" class="form-control" disabled="disabled" placeholder=""
                                            id="MDDS_ST2011" name="MDDS_ST2011" />
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" id="MDDS_ST2021" data-parsley-minlength="1"
                                            data-parsley-maxlength="3" name="MDDS_ST2021"
                                            onkeypress="return numbersOnly12(event)" class="form-control"
                                            placeholder="MDDS Code" />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">ForRead</label>
                                    <div class="col-md-10">
                                        <button type="button"
                                            class="btn btn-primary btn-rounded waves-effect waves-light add_buttonupdate">
                                            <i class="fas fa-plus-circle mr-1"></i> <span>ADD </span> </button>
                                    </div>
                                </div>
                                <div class="field_wrapper1">

                                </div>

                            </div>
                        </div><!-- end col -->

                    </div>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="submit" class="btn btn-info waves-effect waves-light">Save</button>
                </div>
            </form>
        </div>

    </div>
</div>

<div id="con-close-modal-link" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">

    <div class="modal-dialog modal-full">
        <div class="modal-content">
            <form class="form-horizontal group-border-dashed parsley-examples" id="linkdata">
                <input type="hidden" name="dataids" id="dataids" value="">
                <input type="hidden" name="comefrom" id="comefrom" value="ST">
                <input type="hidden" name="formname" id="formname" value="linkdatas">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white">LINK DOCUMENT</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <table id="jigardata-datatable"
                                        class="table table-hover table-striped table-bordered nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>

                                            <tr>

                                                <th><input name="select_all" value="1" id="example-select-all"
                                                        type="checkbox"></th>
                                                <th>Document ID</th>
                                                <th>State Code</th>
                                                <th>Document Type</th>
                                                <th>Date</th>
                                                <th>Document No</th>
                                                <th>Description</th>
                                                <th>Document</th>
                                            </tr>
                                        </thead>

                                    </table>
                                </div>
                            </div>
                        </div><!-- end col -->

                    </div>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="submit" class="btn btn-info waves-effect waves-light">Link</button>
                </div>
            </form>
        </div>

    </div>
</div>


<div id="con-close-modal-linked" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">

    <div class="modal-dialog modal-full">
        <div class="modal-content">
            <form class="form-horizontal group-border-dashed parsley-examples" id="linkeddataupdate">
                <input type="hidden" name="linkeddataids" id="linkeddataids" value="">
                <input type="hidden" name="linkedcomefrom" id="linkedcomefrom" value="ST">
                <input type="hidden" name="formname" id="formname" value="linkedlinkdatas">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white">LINKED DOCUMENT</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <table id="linked-datatable"
                                        class="table table-hover table-striped table-bordered nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>

                                            <tr>
                                                <th><input name="linkedselect_all" value="1" id="linkedselect-all"
                                                        type="checkbox"></th>
                                                <th>Document ID</th>
                                                <th>State Code</th>
                                                <th>Document Type</th>
                                                <th>Date</th>
                                                <th>Document No</th>
                                                <th>Description</th>
                                                <th>Document</th>
                                            </tr>
                                        </thead>

                                    </table>
                                </div>
                            </div>
                        </div><!-- end col -->

                    </div>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect closepop"
                        data-dismiss="modal">Cancel</button>
                    <button type="submit" name="submit" class="btn btn-info waves-effect waves-light">Unlinked</button>
                </div>
            </form>
        </div>

    </div>
</div>


<div id="con-close-modal-add" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">

    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form class="form-horizontal group-border-dashed" data-parsley-validate novalidate
                data-parsley-trigger="keyup" id="addstate">
                <input type="hidden" name="formname" id="formname" value="addstatedata">
                <input type="hidden" name="Leveldata" id="Leveldata" value="ST">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white">ADD STATE</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12">
                            <div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">&nbsp;</label>
                                    <label class="col-md-5 col-form-label">2021</label>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">State Name</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="addSTName2021" id="addSTName2021"
                                            required placeholder="State Name 2021" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Status</label>
                                    <div class="col-md-9 pt-2">
                                        <select required id="Status2021" name="Status2021">
                                            <option value="">Select Status</option>
                                            <option value="ST">State</option>
                                            <option value="UT">Union Territory</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- <div class="form-group row">
                                    <label class="col-md-3 col-form-label">&nbsp;</label>
                                    <div class="custom-control custom-checkbox" style="padding-left: 2.5rem">
                                        <input type="checkbox" class="custom-control-input" id="checkbox-signin"
                                            name="checkboxut">
                                        <label class="custom-control-label" for="checkbox-signin">As a Union
                                            Territory</label>
                                    </div>
                                </div> -->
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Short code</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="addShort_ST2021"
                                            id="addShort_ST2021" data-parsley-minlength="1" data-parsley-maxlength="3"
                                            placeholder="Short code" onkeypress="return numbersOnly12(event)"
                                            data-parsley-trigger="keyup" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">MDDS Code</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="addMDDS_ST2021"
                                            id="addMDDS_ST2021" data-parsley-minlength="1" data-parsley-maxlength="3"
                                            onkeypress="return numbersOnly12(event)" data-parsley-trigger="keyup"
                                            placeholder="MDDS Code" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">ForRead</label>
                                    <div class="col-md-9">
                                        <button type="button"
                                            class="btn btn-primary btn-rounded waves-effect waves-light add_button"> <i
                                                class="fas fa-plus-circle mr-1"></i> <span>ADD </span> </button>
                                    </div>
                                </div>
                                <div class="field_wrapper">
                                </div>
                            </div>
                        </div><!-- end col -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect closepop" data-dismiss="modal"
                        aria-label="Close">Cancel</button>
                    <button type="submit" name="submit" class="btn btn-info waves-effect waves-light">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
$('select').select2({
    maximumInputLength: 20 // only allow terms up to 20 characters long
});
</script>
<script type="text/javascript">
$(function() {

    $('#state_count_name').text(<?php echo $st; ?>);
    $('#districts_count_name').text(<?php echo $dt; ?>);
    $('#sub_districts_count_name').text(<?php echo $sd; ?>);
    $('#villages_count_name').text(<?php echo $vt; ?>);
    $('#town_count_name').text(<?php echo $ct; ?>);
    $('#wards_count_name').text(<?php echo $wd; ?>);
    var maxField = 11;
    var maxField1 = 10;
    var x = 1;
    var y = 0;

    var addButton = $('.add_button');
    var updateButton = $('.add_buttonupdate');

    var wrapper = $('.field_wrapper');
    var wrapper1 = $('.field_wrapper1');

    var optionstate = '';
    <?php  foreach ($row as $key => $element) { 
        if($element['STID']==null)
        {
           $valueof = $element['STID2011'];
           $valueofname = $element['STName2011'];
        }
        else
        {
            $valueof = $element['STID'];
            $valueofname = $element['STName'];
        }
        ?>
    optionstate +=
        '<option value = "<?php  echo $valueof; ?>"><?php  echo $valueofname; ?></option>';
    <?php  } ?>

   

    var optionaction = '';
    <?php  foreach ($rowaction as $key => $element) { ?>
    optionaction +=
        '<option value = "<?php  echo $element['statuslevel']; ?>"><?php  echo $element['forreaddetails']; ?></option>';
    <?php  } ?>

    var fieldHTML =
        '<div class="form-group row"><div class = "col-md-3 pt-2"><select class="form-select" required name = "STID2021[]"><option value = "">Select State</option>' +
        optionstate +
        '</select></div><div class = "col-md-4 pt-2"><select class="form-select" required name = "action[]"><option value = "">Action From</option>' +
        optionaction +
        '</select></div><div class = "col-md-4 pt-2"><select class="form-select" required name = "actionto[]"><option value = "">Action To</option>' +
        optionaction +
        '</select></div><div class = "col-md-1 pt-2"><button type="button" class = "btn-block btn-primary btn-rounded waves-effect waves-light remove_button" ><i class = "fas fa-times-circle" ></i></button></div></div>';

        var fieldHTML1 =
        '<div class="form-group row"><div class = "row col-md-5"><div class = "col-md-6 pt-2"><select class="form-select" required name = "STID2011[]"><option value = "">Select 2011 State</option>' +
        optionstate +
        '</select></div><div class = "col-md-6 pt-2"><select class="form-select" required name = "action[]"><option value = "">Action From</option>' +
        optionaction +
        '</select></div></div><div class = "row col-md-7"><div class = "col-md-5 pt-2"><select class="form-select" required name = "STID2021[]"><option value = "">Select 2021 State</option>' +
        optionstate +
        '</select></div><div class = "col-md-5 pt-2"><select class="form-select" required name = "actionto[]"><option value = "">Action To</option>' +
        optionaction +
        '</select></div><div class = "col-md-2 pt-2"><button type="button" class = "btn-block btn-primary btn-rounded waves-effect waves-light remove_button" ><i class = "fas fa-times-circle" ></i></button></div></div></div>';

    $(addButton).click(function() {


        if (x < maxField) {
            x++;
            $(wrapper).append(fieldHTML);
            $('select.form-select').select2({
                maximumInputLength: 20
            });
        }
    });

    $(updateButton).click(function() {
        var x1 = $("#getrecords").val();

        if (x1 == '') {
            y = y + 1;
        } else if (x1 != '' && x1 == y) {

            y = x1;
        } else if (x1 != '' && x1 < y) {

            y = y;
        } else {

            y = x1;
        }


        if (y < maxField1) {
            y++;

            $(wrapper1).append(fieldHTML1);
            $('select.form-select').select2({
                maximumInputLength: 20
            });
        }
    });


    $(wrapper).on('click', '.remove_button', function(e) {
        e.preventDefault();
        $(this).parent().parent('div').remove();
        x--;
    });

    $(wrapper1).on('click', '.remove_button', function(e) {
        e.preventDefault();
        $(this).parent().parent('div').remove();
        y--;
    });

});
</script>