<?php include ("header.php"); include ("topbar.php"); include ("menu.php"); 
if(!isset($_GET) || $_GET['ids']=='')
{
     echo "<script language='javascript'>location.href='units';</script>";
        exit;
}
 $datof = base64_decode( $_GET['ids'] );

$dat = base64_decode( $_GET['data'] );

$STIDDATA = explode('**',$datof);


$boxdata = explode(',',$dat);

$arra=array($STIDDATA[1]);
// print_r($STIDDATA);



$result = pg_query_params($db, 'select * from "vtCount'.$_SESSION['logindetails']['baseyear'].'" Full JOIN "vtCount'.$_SESSION['activeyears'].'" 
Left JOIN ( SELECT fromids,partiallydataids,toids,docids,partiallyids,comefrom
           FROM "partiallydata'.$_SESSION['activeyears'].'" where pstatus=0 group by fromids,partiallydataids,toids,docids,partiallyids,comefrom) pd 
           LEFT JOIN ( select * from documentdata'.$_SESSION['activeyears'].') dd ON dd.docids=pd.docids
            LEFT JOIN ( select "STID" as "STIDS","DTID" as "DTIDS","SDID" as "SDIDS","SDName" as "SDNameof" from sd'.$_SESSION['activeyears'].') sdt ON sdt."SDIDS"=pd."toids"
           ON "vtCount'.$_SESSION['activeyears'].'"."VTID" = pd."partiallydataids"
 On "vtCount'.$_SESSION['logindetails']['baseyear'].'"."VTID'.$_SESSION['logindetails']['baseyear'].'"="vtCount'.$_SESSION['activeyears'].'"."VTID" where  "vtCount'.$_SESSION['activeyears'].'"."SDID" = $1 OR "vtCount'.$_SESSION['logindetails']['baseyear'].'"."SDID'.$_SESSION['logindetails']['baseyear'].'" = $1',$arra);

$where = "";


$action = "";
$passvalue ="";

if($header!=0 && $rows['assignlist']!=null)  
{
    
    $action = explode(',',$rows['assignlist']);
    // $where = 'where "STID" in ('.$rows['assignstids'].')';
    $array = array($rows['assignlist']);
    $resultstate = pg_query_params($db, 'select "STID","STName" from "st'.$_SESSION['activeyears'].'" where "STID" in ($1) order by "STID" ASC',$array);

$row = pg_fetch_all($resultstate);  

}
else
{
    $action = "";
    $resultstate = pg_query($db, 'select "STID","STName" from "st'.$_SESSION['activeyears'].'"  order by "STID" ASC');

$row = pg_fetch_all($resultstate);  


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
            <?php  include("breadcrumbs.php"); ?>
            <!-- end page title -->




            <?php  include("box.php"); ?>

            <!-- end row -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dropdown float-right">
                               <!--  <button class="btn btn-primary btn-rounded waves-effect waves-light" data-toggle="modal"
                                    data-target="#con-close-modal-add" data-backdrop="static" data-keyboard="false"> <i
                                        class="fas fa-plus-circle mr-1"></i> <span>ADD VILLAGE / TOWN</span> </button> -->
                            </div>

                            <h4 class="header-title mb-4"><span class="dropcap text-primary">Village / Town</span> -
                                Census <?php echo $_SESSION['logindetails']['baseyear']; ?> - Census <?php echo $_SESSION['activeyears']; ?></h4>
                            <input type="hidden" name="ids" id="ids" value="<?php echo $_GET['ids']; ?>">

<!-- modified by sahana to download Administrative Units data  -->
<!-- Include the xlsx library -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js" integrity="sha512-r22gChDnGvBylk90+2e/ycr3RVrDi8DIOkIGNhJlKfuyQM4tIRAI062MaV8sfjQKYVGjOBaZBOA87z+IhZE9DA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
<script src="assets/js/xlsx.full.min.js"></script>
<!-- HTML code with the dropdown -->
<div class="dropdown">
  <button class="btn btn-primary dropdown-toggle" type="button" id="yearDropdownButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="margin-left: 90%; margin-bottom: 10px;">
  <i class="fa fa-download"></i>  Download
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
      var table = document.getElementById('villages-units-datatable');
      
      // Create a new table with only the desired columns for 2011
      if (selectedYear == '2011') {
        var newTable = document.createElement('table');
        var thead = document.createElement('thead');
        var headerRow = document.createElement('tr');
        var columns = ["Village/Town MDDS Code", "Village/Town Name", "Level", "Civic Status", "Population"];
        
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
        var columns = ["Village/Town MDDS Code", "Village/Town Name", "Level", "Civic Status","Population","Status"];
        
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
      link.download = 'Village_Town-level_Administrative_Units_' + selectedYear + '.xlsx';
      link.style.display = 'none';
      document.body.appendChild(link);
      
      // Trigger the download
      link.click();
      
      // Clean up the temporary link element
      document.body.removeChild(link);
      
      toastr['success']('Administrative Units ' + selectedYear + ' Downloaded Successfully For Village_Town Level.');
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

                            <table id="villages-units-datatable" class="table  table-striped table-bordered"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th colspan="5" style="background-color: #fe6271; color: #FFFFFF">Administrative Units - Census <?php echo $_SESSION['logindetails']['baseyear']; ?></th>
                                        <th colspan="8" style="background-color: #15bed2; color: #FFFFFF ">
                                            Administrative Units - Census <?php echo $_SESSION['activeyears']; ?></th>

                                    </tr>
                                    <tr>
                                        <th>Village/Town MDDS Code</th>
                                        <th>Village/Town Name</th>
                                        <th>Level</th>
                                        <th>Civic Status</th>
                                        <th>Population</th>
                                        <!-- <th>Wards</th> -->
                                        <th>Village/Town MDDS Code</th>
                                        <th>Village/Town Name</th>
                                        <th>Level</th>
                                        <th>Civic Status</th>
                                        <th>Population</th>
                                       <!--  <th>Wards</th> -->
                                        <th>Status</th>
                                    <!--     <th>Linked Document</th> -->
                                        <!-- <th>
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i class="mdi mdi-dots-vertical"></i>
                                                </a>
                                            </div>
                                        </th> -->
                                        <th>Map Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($data = pg_fetch_array($result)) { 

                                        // if($data['SDID']==$STIDDATA[1])
                                        // {
                                        //  echo "<pre>";
                                        // print_r($STIDDATA);
                                        //  print_r($data);
                                     
                                        if(trim($data['Level'])=='VILLAGE' || trim($data['Level'])=='village' || trim($data['Level'])=='Village')
                                        {
                                            if(trim($data['Status'])=='')
                                            {
                                                $sta = "Revenue Village";    
                                            }
                                            else
                                            {
                                                 $sta = $data['Status'];  
                                            }
                                            
                                        }
                                        else
                                        {
                                            $sta = $data['Status'];
                                        }
                                        if(trim($data['Level'.$_SESSION['logindetails']['baseyear'].''])=='VILLAGE' || trim($data['Level'.$_SESSION['logindetails']['baseyear'].''])=='village' || trim($data['Level'.$_SESSION['logindetails']['baseyear'].''])=='Village')
                                        {

                                            if(trim($data['Status'.$_SESSION['logindetails']['baseyear'].''])=='')
                                            {
                                               $sta_baseyear = "Revenue Village";   
                                            }
                                            else
                                            {
                                                if($data['Status'.$_SESSION['logindetails']['baseyear'].'']=='Village')
                                                {
                                                         $sta_baseyear = 'RV';
                                                }
                                                else
                                                {
                                                         $sta_baseyear = $data['Status'.$_SESSION['logindetails']['baseyear'].''];
                                                }
                                              
                                            }
                                            
                                           // $sta_baseyear = "Revenue Village";
                                        }
                                        else
                                        {
                                            $sta_baseyear = $data['Status'.$_SESSION['logindetails']['baseyear'].''];
                                        }

                                        //By sahana 0111
                                        $vtid = $data['VTID']; 
                                        $query2 = 'SELECT "STID","DTID","SDID","VTID", "VTName", "auflag", "auaction" FROM vt' . $_SESSION['activeyears'] . ' WHERE "VTID" = $1';
                                        $result2 = pg_query_params($db, $query2, array($vtid));
                                        $data2 = pg_fetch_array($result2)
                                       
                                                    ?>
                                   <tr>
                                         <!-- Modified by sahana Split_Action_Administrative_Units 0310 Defect_JC_38-->  
                                        <!-- modified for "pointer" value will change the cursor to a hand icon-->
                                        <td style=><?php 
                                    if($data2['auaction']== 'Split'){
                                        if($data['STID2011']==$data['STID'] && $data['DTID2011']==$data['DTID'] && $data['SDID2011']==$data['SDID']) 
                                        { 
                                            echo $data['MDDS_VT'.$_SESSION['logindetails']['baseyear'].'']; 
                                        } 
                                        // else if ($STIDDATA[1]==$data2['SDID'] && $data['SDID2011']!=$data['SDID'])
                                        // {
                                        //     echo $data['MDDS_VT'.$_SESSION['logindetails']['baseyear'].'']; 
                                        // }
                                        else if ($data['SDID']==$data2['SDID'] && $STIDDATA[1]!=$data['SDID'] && $data['SDID2011']!=$data['SDID'] && $STIDDATA[1]==$data['SDID']) //0211  0611 && $STIDDATA[1]==$data['SDID']
                                        {
                                            echo ""; 
                                        }
                                        else if ($data['SDID']==$data2['SDID'] && $STIDDATA[1]!=$data['SDID'] && $data['SDID2011']!=$data['SDID'] && $STIDDATA[1]!=$data['SDID']) //0211  0611 && $STIDDATA[1]==$data['SDID']
                                        {
                                            echo $data['MDDS_VT'.$_SESSION['logindetails']['baseyear'].'']; 
                                        }
                                        else if ($data['SDID']==$data2['SDID'] && $STIDDATA[1]!=$data['SDID'] && $data['SDID2011']!=$data['SDID']) //0211  0611 && $STIDDATA[1]==$data['SDID']
                                        {
                                            echo ""; 
                                        }
                                        else if ($data['SDID']==$data2['SDID'] && $STIDDATA[1]!=$data['SDID'])
                                        {
                                            echo $data['MDDS_VT'.$_SESSION['logindetails']['baseyear'].'']; 
                                        }
                                        else 
                                        {
                                             echo ""; 
                                        } 
                                    }
                                    else if($data2['auaction']== 'Full Merge'){
                                        if($data['STID2011']==$data['STID'] && $data['DTID2011']==$data['DTID'] && $data['SDID2011']==$data['SDID']) 
                                        { 
                                            echo $data['MDDS_VT'.$_SESSION['logindetails']['baseyear'].'']; 
                                        } 
                                        else 
                                        {
                                             echo ""; 
                                        } 
                                    }
                                    else if($data2['auaction']== 'Merge'){
                                        if($data['STID2011']==$data['STID'] && $data['DTID2011']==$data['DTID'] && $data['SDID2011']==$data['SDID']) 
                                        { 
                                            echo $data['MDDS_VT'.$_SESSION['logindetails']['baseyear'].'']; 
                                        } 
                                        else 
                                        {
                                             echo ""; 
                                        } 
                                    }
                                    else if($data2['auaction']== 'Partially Merge'){
                                        if($data['STID2011']==$data['STID'] && $data['DTID2011']==$data['DTID'] && $data['SDID2011']==$data['SDID']) 
                                        { 
                                            echo $data['MDDS_VT'.$_SESSION['logindetails']['baseyear'].'']; 
                                        } 
                                        else if ($data['DTID2011']!=$data['DTID'] && $STIDDATA[1]!=$data['SDID'])
                                        {
                                            echo $data['MDDS_VT'.$_SESSION['logindetails']['baseyear'].'']; 
                                        }
                                        else 
                                        {
                                             echo ""; 
                                        } 
                                    }
                                    else if ($data2['auaction']== 'Reshuffle'){
                                        if (($STIDDATA[4]==$data['DTID']) && $data['SDIDD2011']==$data2['SDID']){
                                                
                                            echo $data['MDDS_VT'.$_SESSION['logindetails']['baseyear'].'']; 
                                        }
                                        else if ($data['SDID2011']!=$data['SDID'] && $STIDDATA[4]!=$data['DTID'])
                                        {
                                            echo $data['MDDS_VT'.$_SESSION['logindetails']['baseyear'].'']; 
                                        }
                                        else if ($data['DTID2011']==$data['DTID'] && $STIDDATA[1]!=$data2['SDID'] && $data['SDID2011']!=$data['SDID'] ) //0311
                                        {
                                            echo $data['MDDS_VT'.$_SESSION['logindetails']['baseyear'].'']; 
                                        }
                                        else {
                                            echo ''; 
                                        }
                                    }
                                    else 
                                    {
                                        echo $data['MDDS_VT'.$_SESSION['logindetails']['baseyear'].''];
                                    }
                                    ?></td>
                                        
                                        
                                    <td style=><?php  

                                    if($data2['auaction']== 'Split'){
                                        if($data['STID2011']==$data['STID'] && $data['DTID2011']==$data['DTID'] && $data['SDID2011']==$data['SDID']) 
                                        { 
                                            echo $data['VTName'.$_SESSION['logindetails']['baseyear'].'']; 
                                        } 
                                        // else if ($data['SDID2011']!=$data['SDID'])
                                        // {
                                        //     echo $data['VTName'.$_SESSION['logindetails']['baseyear'].'']; 
                                        // }
                                        else if ($data['SDID']==$data2['SDID'] && $STIDDATA[1]!=$data['SDID'] && $data['SDID2011']!=$data['SDID'] && $STIDDATA[1]==$data['SDID']) //0211  0611 && $STIDDATA[1]==$data['SDID']
                                        {
                                            echo ""; 
                                        }
                                        else if ($data['SDID']==$data2['SDID'] && $STIDDATA[1]!=$data['SDID'] && $data['SDID2011']!=$data['SDID'] && $STIDDATA[1]!=$data['SDID']) //0211  0611 && $STIDDATA[1]==$data['SDID']
                                        {
                                            echo $data['VTName'.$_SESSION['logindetails']['baseyear'].''];  
                                        }
                                        else if ($data['SDID']==$data2['SDID'] && $STIDDATA[1]!=$data['SDID'] && $data['SDID2011']!=$data['SDID']) //0211  0611 && $STIDDATA[1]==$data['SDID']
                                        {
                                            echo ""; 
                                        }
                                        else if ($data['SDID']==$data2['SDID'] && $STIDDATA[1]!=$data['SDID'])
                                        {
                                            echo $data['VTName'.$_SESSION['logindetails']['baseyear'].''];
                                        }
                                        else 
                                        { 
                                            echo ""; 
                                        } 
                                    }
                                    else if($data2['auaction']== 'Full Merge'){
                                        if($data['STID2011']==$data['STID'] && $data['DTID2011']==$data['DTID'] && $data['SDID2011']==$data['SDID']) 
                                        { 
                                            echo $data['VTName'.$_SESSION['logindetails']['baseyear'].''];  
                                        } 
                                        else 
                                        {
                                             echo ""; 
                                        } 
                                    }
                                    else if($data2['auaction']== 'Merge'){
                                        if($data['STID2011']==$data['STID'] && $data['DTID2011']==$data['DTID'] && $data['SDID2011']==$data['SDID']) 
                                        { 
                                            echo $data['VTName'.$_SESSION['logindetails']['baseyear'].'']; 
                                        } 
                                        else 
                                        {
                                             echo ""; 
                                        } 
                                    }
                                    else if($data2['auaction']== 'Partially Merge'){
                                        if($data['STID2011']==$data['STID'] && $data['DTID2011']==$data['DTID'] && $data['SDID2011']==$data['SDID']) 
                                        { 
                                            echo $data['VTName'.$_SESSION['logindetails']['baseyear'].''];  
                                        } 
                                        else if ($data['DTID2011']!=$data['DTID'] && $STIDDATA[1]!=$data['SDID'])
                                        {
                                            echo $data['VTName'.$_SESSION['logindetails']['baseyear'].''];  
                                        }
                                        else 
                                        {
                                             echo ""; 
                                        } 
                                    }
                                    else if ($data2['auaction']== 'Reshuffle'){
                                        if (($STIDDATA[4]==$data['DTID']) && $data['SDIDD2011']==$data2['SDID']){
                                                
                                            echo $data['VTName'.$_SESSION['logindetails']['baseyear'].'']; 
                                        }
                                        else if ($data['SDID2011']!=$data['SDID'] && $STIDDATA[4]!=$data['DTID'])
                                        {
                                            echo $data['VTName'.$_SESSION['logindetails']['baseyear'].'']; 
                                        }
                                        else if ($data['DTID2011']==$data['DTID'] && $STIDDATA[1]!=$data2['SDID'] && $data['SDID2011']!=$data['SDID'] ) //0311
                                        {
                                            echo $data['VTName'.$_SESSION['logindetails']['baseyear'].'']; 
                                        }
                                        else {
                                            echo ''; 
                                        }
                                    }
                                    else 
                                    {
                                        echo $data['VTName'.$_SESSION['logindetails']['baseyear'].'']; 
                                    }
                                    ?></td>
                                        
                                        
                                    <td style=><?php 
                       
                                    if($data2['auaction']== 'Split'){
                                            if($data['STID2011']==$data['STID'] && $data['DTID2011']==$data['DTID'] && $data['SDID2011']==$data['SDID']) 
                                            { 
                                                echo $data['Level'.$_SESSION['logindetails']['baseyear'].'']; 
                                            } 
                                            // else if ($data['SDID2011']!=$data['SDID'])
                                            // {
                                            //     echo $data['Level'.$_SESSION['logindetails']['baseyear'].'']; 
                                            // }
                                            else if ($data['SDID']==$data2['SDID'] && $STIDDATA[1]!=$data['SDID'] && $data['SDID2011']!=$data['SDID'] && $STIDDATA[1]==$data['SDID']) //0211  0611 && $STIDDATA[1]==$data['SDID']
                                            {
                                                echo ""; 
                                            }
                                            else if ($data['SDID']==$data2['SDID'] && $STIDDATA[1]!=$data['SDID'] && $data['SDID2011']!=$data['SDID'] && $STIDDATA[1]!=$data['SDID']) //0211  0611 && $STIDDATA[1]==$data['SDID']
                                            {
                                                echo $data['Level'.$_SESSION['logindetails']['baseyear'].''];  
                                            }
                                            else if ($data['SDID']==$data2['SDID'] && $STIDDATA[1]!=$data['SDID'] && $data['SDID2011']!=$data['SDID']) //0211  0611 && $STIDDATA[1]==$data['SDID']
                                            {
                                                echo ""; 
                                            }
                                            else if ($data['SDID']==$data2['SDID'] && $STIDDATA[1]!=$data['SDID'])
                                            {
                                                echo $data['Level'.$_SESSION['logindetails']['baseyear'].'']; 
                                            }
                                            else 
                                            { 
                                                echo ""; 
                                            } 
                                    }
                                    else if($data2['auaction']== 'Full Merge'){
                                        if($data['STID2011']==$data['STID'] && $data['DTID2011']==$data['DTID'] && $data['SDID2011']==$data['SDID']) 
                                        { 
                                            echo $data['Level'.$_SESSION['logindetails']['baseyear'].'']; 
                                        } 
                                        else 
                                        {
                                             echo ""; 
                                        } 
                                    }
                                    else if($data2['auaction']== 'Merge'){
                                        if($data['STID2011']==$data['STID'] && $data['DTID2011']==$data['DTID'] && $data['SDID2011']==$data['SDID']) 
                                        { 
                                            echo $data['Level'.$_SESSION['logindetails']['baseyear'].'']; 
                                        } 
                                        else 
                                        {
                                             echo ""; 
                                        } 
                                    }
                                    else if($data2['auaction']== 'Partially Merge'){
                                        if($data['STID2011']==$data['STID'] && $data['DTID2011']==$data['DTID'] && $data['SDID2011']==$data['SDID']) 
                                        { 
                                            echo $data['Level'.$_SESSION['logindetails']['baseyear'].'']; 
                                        } 
                                        else if ($data['DTID2011']!=$data['DTID'] && $STIDDATA[1]!=$data['SDID'])
                                        {
                                            echo $data['Level'.$_SESSION['logindetails']['baseyear'].'']; 
                                        }
                                        else 
                                        {
                                             echo ""; 
                                        } 
                                    }
                                    else if ($data2['auaction']== 'Reshuffle'){
                                        if (($STIDDATA[4]==$data['DTID']) && $data['SDIDD2011']==$data2['SDID']){
                                                
                                            echo $data['Level'.$_SESSION['logindetails']['baseyear'].'']; 
                                        }
                                        else if ($data['SDID2011']!=$data['SDID'] && $STIDDATA[4]!=$data['DTID'])
                                        {
                                            echo $data['Level'.$_SESSION['logindetails']['baseyear'].'']; 
                                        }
                                        else if ($data['DTID2011']==$data['DTID'] && $STIDDATA[1]!=$data2['SDID'] && $data['SDID2011']!=$data['SDID'] ) //0311
                                        {
                                            echo $data['Level'.$_SESSION['logindetails']['baseyear'].'']; 
                                        }
                                        else {
                                            echo ''; 
                                        }
                                    }
                                    else 
                                    {
                                        echo $data['Level'.$_SESSION['logindetails']['baseyear'].'']; 
                                    }
                                    ?></td>
                                    
                                    
                                    <td style=><?php 
                                
                                    if($data2['auaction']== 'Split'){
                                            if($data['STID2011']==$data['STID'] && $data['DTID2011']==$data['DTID'] && $data['SDID2011']==$data['SDID']) 
                                            { 
                                                echo $sta_baseyear; 
                                            } 
                                            // else if ($data['SDID2011']!=$data['SDID'])
                                            // {
                                            //     echo $sta_baseyear; 
                                            // }
                                            else if ($data['SDID']==$data2['SDID'] && $STIDDATA[1]!=$data['SDID'] && $data['SDID2011']!=$data['SDID'] && $STIDDATA[1]==$data['SDID']) //0211  0611 && $STIDDATA[1]==$data['SDID']
                                            {
                                                echo ""; 
                                            }
                                            else if ($data['SDID']==$data2['SDID'] && $STIDDATA[1]!=$data['SDID'] && $data['SDID2011']!=$data['SDID'] && $STIDDATA[1]!=$data['SDID']) //0211  0611 && $STIDDATA[1]==$data['SDID']
                                            {
                                                echo $sta_baseyear; 
                                            }
                                            else if ($data['SDID']==$data2['SDID'] && $STIDDATA[1]!=$data['SDID'] && $data['SDID2011']!=$data['SDID']) //0211  0611 && $STIDDATA[1]==$data['SDID']
                                            {
                                                echo ""; 
                                            }
                                            else if ($data['SDID']==$data2['SDID'] && $STIDDATA[1]!=$data['SDID'])
                                            {
                                                echo $sta_baseyear; 
                                            }
                                            else 
                                            { 
                                                echo ""; 
                                            } 
                                    }
                                    else if($data2['auaction']== 'Full Merge'){
                                        if($data['STID2011']==$data['STID'] && $data['DTID2011']==$data['DTID'] && $data['SDID2011']==$data['SDID']) 
                                        { 
                                            echo $sta_baseyear; 
                                        } 
                                        else 
                                        {
                                             echo ""; 
                                        } 
                                    }
                                    else if($data2['auaction']== 'Merge'){
                                        if($data['STID2011']==$data['STID'] && $data['DTID2011']==$data['DTID'] && $data['SDID2011']==$data['SDID']) 
                                        { 
                                            echo $sta_baseyear; 
                                        } 
                                        else 
                                        {
                                             echo ""; 
                                        } 
                                    }
                                    else if($data2['auaction']== 'Partially Merge'){
                                        if($data['STID2011']==$data['STID'] && $data['DTID2011']==$data['DTID'] && $data['SDID2011']==$data['SDID']) 
                                        { 
                                            echo $sta_baseyear; 
                                        }
                                        else if ($data['DTID2011']!=$data['DTID'] && $STIDDATA[1]!=$data['SDID'])
                                        {
                                            echo $sta_baseyear; 
                                        } 
                                        else 
                                        {
                                             echo ""; 
                                        } 
                                    }
                                    else if ($data2['auaction']== 'Reshuffle'){
                                        if (($STIDDATA[4]==$data['DTID']) && $data['SDIDD2011']==$data2['SDID']){
                                                
                                            echo $sta_baseyear; 
                                        }
                                        else if ($data['SDID2011']!=$data['SDID'] && $STIDDATA[4]!=$data['DTID'])
                                        {
                                            echo $sta_baseyear; 
                                        }
                                        else if ($data['DTID2011']==$data['DTID'] && $STIDDATA[1]!=$data2['SDID'] && $data['SDID2011']!=$data['SDID'] ) //0311
                                        {
                                            echo $sta_baseyear; 
                                        }
                                        else {
                                            echo ''; 
                                        }
                                    }
                                    else 
                                    {
                                        echo $sta_baseyear; 
                                    }
                                    ?></td>
                                    
                                    
                                    <td style=><?php 
                                 
                                    if($data2['auaction']== 'Split'){
                                            if($data['STID2011']==$data['STID'] && $data['DTID2011']==$data['DTID'] && $data['SDID2011']==$data['SDID']) 
                                            { 
                                                echo $data['Pop'.$_SESSION['logindetails']['baseyear'].'']; 
                                            } 
                                            // else if ($data['SDID2011']!=$data['SDID'])
                                            // {
                                            //     echo $data['Pop'.$_SESSION['logindetails']['baseyear'].'']; 
                                            // }
                                            else if ($data['SDID']==$data2['SDID'] && $STIDDATA[1]!=$data['SDID'] && $data['SDID2011']!=$data['SDID'] && $STIDDATA[1]==$data['SDID']) //0211  0611 && $STIDDATA[1]==$data['SDID']
                                            {
                                                echo ""; 
                                            }
                                            else if ($data['SDID']==$data2['SDID'] && $STIDDATA[1]!=$data['SDID'] && $data['SDID2011']!=$data['SDID'] && $STIDDATA[1]!=$data['SDID']) //0211  0611 && $STIDDATA[1]==$data['SDID']
                                            {
                                                echo $data['Pop'.$_SESSION['logindetails']['baseyear'].'']; 
                                            }
                                            else if ($data['SDID']==$data2['SDID'] && $STIDDATA[1]!=$data['SDID'] && $data['SDID2011']!=$data['SDID']) //0211  0611 && $STIDDATA[1]==$data['SDID']
                                            {
                                                echo ""; 
                                            }
                                            else if ($data['SDID']==$data2['SDID'] && $STIDDATA[1]!=$data['SDID'])
                                            {
                                                echo $data['Pop'.$_SESSION['logindetails']['baseyear'].'']; 
                                            }
                                            else 
                                            { 
                                                echo ""; 
                                            } 
                                    }
                                    else if($data2['auaction']== 'Full Merge'){
                                        if($data['STID2011']==$data['STID'] && $data['DTID2011']==$data['DTID'] && $data['SDID2011']==$data['SDID']) 
                                        { 
                                            echo $data['Pop'.$_SESSION['logindetails']['baseyear'].'']; 
                                        } 
                                        else 
                                        {
                                             echo ""; 
                                        } 
                                    }
                                    else if($data2['auaction']== 'Merge'){
                                        if($data['STID2011']==$data['STID'] && $data['DTID2011']==$data['DTID'] && $data['SDID2011']==$data['SDID']) 
                                        { 
                                            echo $data['Pop'.$_SESSION['logindetails']['baseyear'].'']; 
                                        } 
                                        else 
                                        {
                                             echo ""; 
                                        } 
                                    }
                                    else if($data2['auaction']== 'Partially Merge'){
                                        if($data['STID2011']==$data['STID'] && $data['DTID2011']==$data['DTID'] && $data['SDID2011']==$data['SDID']) 
                                        { 
                                            echo $data['Pop'.$_SESSION['logindetails']['baseyear'].'']; 
                                        } 
                                        else if ($data['DTID2011']!=$data['DTID'] && $STIDDATA[1]!=$data['SDID'])
                                        {
                                            echo $data['Pop'.$_SESSION['logindetails']['baseyear'].'']; 
                                        }
                                        else 
                                        {
                                             echo ""; 
                                        } 
                                    }
                                    else if ($data2['auaction']== 'Reshuffle'){
                                        if (($STIDDATA[4]==$data['DTID']) && $data['SDIDD2011']==$data2['SDID']){
                                                
                                            echo $data['Pop'.$_SESSION['logindetails']['baseyear'].'']; 
                                        }
                                        else if ($data['SDID2011']!=$data['SDID'] && $STIDDATA[4]!=$data['DTID'])
                                        {
                                            echo $data['Pop'.$_SESSION['logindetails']['baseyear'].'']; 
                                        }
                                        else if ($data['DTID2011']==$data['DTID'] && $STIDDATA[1]!=$data2['SDID'] && $data['SDID2011']!=$data['SDID'] ) //0311
                                        {
                                            echo $data['Pop'.$_SESSION['logindetails']['baseyear'].'']; 
                                        }
                                        else {
                                            echo ''; 
                                        }
                                    }
                                    else 
                                        {
                                            echo $data['Pop'.$_SESSION['logindetails']['baseyear'].'']; 
                                        }
                                    ?></td>
                                       
                                       
                                        <!-- <td><?php // echo (int)$data['Wards'.$_SESSION['logindetails']['baseyear'].'']; ?></td> -->

                                        <!-- Modified by sahana Split_Action_Administrative_Units 0310 Defect_JC_38-->  

                                         <td class="class2021" style=><?php 

                                        if($data2['auaction']== 'Split'){
                                            // if($data['STID2011']!=$data['STID'] && $data['DTID2011']!=$data['DTID'] && $data['SDID2011']!=$data['SDID']) 
                                            // { 
                                            //     echo ''; 
                                            // }
                                            // else if($data['STID2011']==$data['STID'] && $data['DTID2011']==$data['DTID'] && $data['SDID2011']==$data['SDID']) 
                                            // { 
                                            //     echo $data['MDDS_VT'];
                                            // }  
                                            // else 
                                            // {
                                            //     echo $data['MDDS_VT'];
                                            // } 
                                            // if($data['SDID2011']==$data['SDID'] && $STIDDATA[7]==$data2['SDID']) 
                                            // { 
                                            //     echo $data['MDDS_VT'];
                                            // } 
                                            // else 
                                            // {
                                            //     echo ""; 
                                            // } 

                                            if($data['STID2011']==$data['STID'] && $data['DTID2011']==$data['DTID'] && $data['SDID2011']==$data['SDID'])
                                            { 
                                                echo $data['MDDS_VT']; 
                                            } 
                                            else if($STIDDATA[1]==$data['SDID']) 
                                            {
                                                echo $data['MDDS_VT'];
                                            } 
                                            // else if($STIDDATA[1]!=$data['SDID'] && $STIDDATA[1]==$data['SDID2011'] && $data['DTID2011']==$data['DTID']) //0611
                                            // {
                                            //     echo $data['MDDS_VT'];
                                            // } 
                                             else 
                                            { 
                                                echo ''; 
                                            }
                                        }
                                        else if($data2['auaction']== 'Merge'){
                                            if($data['STID2011']!=$data['STID'] && $data['SDID2011']!=$data['SDID']) 
                                            { 
                                                echo $data['MDDS_VT'];
                                            } 
                                            else if($data['STID2011']!=$data['STID'] && $data['SDID2011']==$data['SDID']) 
                                            { 
                                                echo $data['MDDS_VT'];
                                            } 
                                            else if($data['STID2011']=$data['STID'] && $data['DTID2011']!=$data['DTID'] && $data['SDID2011']!=$data['SDID']) 
                                            { 
                                                echo $data['MDDS_VT'];
                                            } 
                                            else if($data['DTID2011']==$data['DTID'] && $data['SDID2011']==$data['SDID'] && $data['SDID']==$data2['SDID']) 
                                            { 
                                                echo $data['MDDS_VT'];
                                            } 
                                            else 
                                            {
                                                 echo ""; 
                                            } 
                                        }
                                        else if($data2['auaction']== 'Partially Merge'){
                                            if($data['STID']==$data2['STID'] && $data['DTID']==$data2['DTID'] && $data['SDID']==$data2['SDID'] && $STIDDATA[1]==$data['SDID']) 
                                            { 
                                                echo $data['MDDS_VT'];
                                            } 
                                            else 
                                            {
                                                 echo ""; 
                                            } 
                                        }
                                        else if ($data2['auaction']== 'Reshuffle'){
                                            // if (($STIDDATA[7]==$data['STID'])){
                                                    
                                            //     echo $data['VTName']; 
                                            // }
                                            if ($STIDDATA[1]!=$data2['SDID'] && $data['SDID2011']!=$STIDDATA[1]){ //0311 
                                                    
                                                echo '';
                                            }
                                            else if ($STIDDATA[1]==$data2['SDID'] && $data['SDID2011']!=$STIDDATA[1]){ //0311  
                                                    
                                                echo $data['MDDS_VT'];
                                            }
                                            else if ($data['SDID2011']!=$data['SDID'] && $data['STID2011']!=$data['STID']){
                                                    
                                                 echo '';
                                            }
                                            else if ($STIDDATA[4]!=$data['DTID'] && $data['SDID']==$data2['SDID'] && $STIDDATA[1]!=$data['SDID']){ //0611
                                                    
                                                echo '';
                                            }
                                            else if ($STIDDATA[4]!=$data['DTID'] && $data['SDID']==$data2['SDID']){
                                                    
                                                echo $data['MDDS_VT'];
                                            }
                                            // else if ($STIDDATA[4]==$data['DTID2011'] && $data['SDID']==$data2['SDID']){
                                                    
                                            //     echo '';
                                            // }
                                            else if ($STIDDATA[4]==$data['DTID'] && $data['SDID']==$data2['SDID'] && $STIDDATA[1]==$data['SDID']){ //0311
                                                    
                                                echo $data['MDDS_VT'];
                                            }
                                            else {
                                                echo ''; 
                                            }
                                        }
                                        else 
                                        {
                                            echo $data['MDDS_VT'];
                                        }
                                        ?></td>


                                        <td class="class2021" style=><?php 

                                        if($data2['auaction']== 'Split'){     
                                            // if($data['STID2011']!=$data['STID'] && $data['DTID2011']!=$data['DTID'] && $data['SDID2011']!=$data['SDID']) 
                                            // { 
                                            //     echo ''; 
                                            // }  
                                            // else 
                                            // { 
                                            //     echo $data['VTName']; 
                                            // } 
                                            if($data['STID2011']==$data['STID'] && $data['DTID2011']==$data['DTID'] && $data['SDID2011']==$data['SDID'])
                                            { 
                                                echo $data['VTName']; 
                                            } 
                                            else if($STIDDATA[1]==$data['SDID']) 
                                            {
                                                echo $data['VTName']; 
                                            } 
                                            // else if($STIDDATA[1]!=$data['SDID'] && $STIDDATA[1]==$data['SDID2011'] && $data['DTID2011']==$data['DTID']) //0611
                                            // {
                                            //     echo $data['VTName']; 
                                            // } 
                                             else 
                                             { echo ''; 
                                            }
                                        }
                                        else if($data2['auaction']== 'Merge'){
                                            if($data['STID2011']!=$data['STID'] && $data['SDID2011']!=$data['SDID']) 
                                            { 
                                                echo $data['VTName']; 
                                            } 
                                            else if($data['STID2011']!=$data['STID'] && $data['SDID2011']==$data['SDID']) 
                                            { 
                                                echo $data['VTName']; 
                                            } 
                                            else if($data['STID2011']=$data['STID'] && $data['DTID2011']!=$data['DTID'] && $data['SDID2011']!=$data['SDID']) 
                                            { 
                                                echo $data['VTName']; 
                                            } 
                                            else 
                                            {
                                                 echo ""; 
                                            } 
                                        }
                                        else if($data2['auaction']== 'Partially Merge'){
                                            if($data['STID']==$data2['STID'] && $data['DTID']==$data2['DTID'] && $data['SDID']==$data2['SDID'] && $STIDDATA[1]==$data['SDID']) 
                                            { 
                                                echo $data['VTName']; 
                                            } 
                                            else 
                                            {
                                                 echo ""; 
                                            } 
                                        }
                                        else if ($data2['auaction']== 'Reshuffle'){
                                            if ($STIDDATA[1]!=$data2['SDID'] && $data['SDID2011']!=$STIDDATA[1]){ //0311 
                                                    
                                                echo '';
                                            }
                                            else if ($STIDDATA[1]==$data2['SDID'] && $data['SDID2011']!=$STIDDATA[1]){ //0311  
                                                    
                                                echo $data['VTName']; 
                                            }
                                            else if ($data['SDID2011']!=$data['SDID'] && $data['STID2011']!=$data['STID']){
                                                    
                                                echo '';
                                            }
                                            else if ($STIDDATA[4]!=$data['DTID'] && $data['SDID']==$data2['SDID'] && $STIDDATA[1]!=$data['SDID']){ //0611
                                                    
                                                echo '';
                                            }
                                            else if (($STIDDATA[4]!=$data['DTID']) && $data['SDID']==$data2['SDID']){
                                                    
                                                echo $data['VTName']; 
                                            }
                                            // else if ($STIDDATA[4]==$data['DTID'] && $data['SDID']==$data2['SDID'] && $STIDDATA[1]==$data['SDID']){ //0311
                                                    
                                            //     echo $data['VTName']; 
                                            // }
                                            else if ($STIDDATA[4]==$data['DTID'] && $data['SDID']==$data2['SDID'] && $STIDDATA[1]==$data['SDID']){ //0311
                                                    
                                                echo $data['VTName']; 
                                            }
                                            else {
                                                echo ''; 
                                            }
                                        }
                                        else 
                                        {
                                            echo $data['VTName']; 
                                        }
                                        ?></td>


                                        <td class="class2021" style=><?php 
    
                                        if($data2['auaction']== 'Split'){
                                            // if($data['STID2011']!=$data['STID'] && $data['DTID2011']!=$data['DTID'] && $data['SDID2011']!=$data['SDID']) 
                                            // { 
                                            //     echo ''; 
                                            // } 
                                            // else 
                                            // { 
                                            //     echo $data['Level']; 
                                            // } 
                                            if($data['STID2011']==$data['STID'] && $data['DTID2011']==$data['DTID'] && $data['SDID2011']==$data['SDID'])
                                            { 
                                                echo $data['Level']; 
                                            } 
                                            else if($STIDDATA[1]==$data['SDID']) 
                                            {
                                                echo $data['Level']; 
                                            } 
                                            // else if($STIDDATA[1]!=$data['SDID'] && $STIDDATA[1]==$data['SDID2011'] && $data['DTID2011']==$data['DTID']) //0611
                                            // {
                                            //     echo $data['Level']; 
                                            // } 
                                             else 
                                             { echo ''; 
                                            }
                                        }
                                        else if($data2['auaction']== 'Merge'){
                                            if($data['STID2011']!=$data['STID'] && $data['SDID2011']!=$data['SDID']) 
                                            { 
                                                echo $data['Level']; 
                                            } 
                                            else if($data['STID2011']!=$data['STID'] && $data['SDID2011']==$data['SDID']) 
                                            { 
                                                echo $data['Level']; 
                                            }
                                            else if($data['STID2011']=$data['STID'] && $data['DTID2011']!=$data['DTID'] && $data['SDID2011']!=$data['SDID']) 
                                            { 
                                                echo $data['Level']; 
                                            }  
                                            else 
                                            {
                                                 echo ""; 
                                            } 
                                        }
                                        else if($data2['auaction']== 'Partially Merge'){
                                            if($data['STID']==$data2['STID'] && $data['DTID']==$data2['DTID'] && $data['SDID']==$data2['SDID'] && $STIDDATA[1]==$data['SDID']) 
                                            {
                                                echo $data['Level']; 
                                            } 
                                            else 
                                            {
                                                 echo ""; 
                                            } 
                                        }
                                        else if ($data2['auaction']== 'Reshuffle'){
                                            if ($STIDDATA[1]!=$data2['SDID'] && $data['SDID2011']!=$STIDDATA[1]){ //0311 
                                                    
                                                echo '';
                                            }
                                            else if ($STIDDATA[1]==$data2['SDID'] && $data['SDID2011']!=$STIDDATA[1]){ //0311  
                                                    
                                                echo $data['Level']; 
                                            }
                                            else if ($STIDDATA[4]!=$data['DTID'] && $data['SDID']==$data2['SDID'] && $STIDDATA[1]!=$data['SDID']){ //0611
                                                    
                                                echo '';
                                            }
                                            else if (($STIDDATA[4]!=$data['DTID']) && $data['SDID']==$data2['SDID']){
                                                    
                                                echo $data['Level']; 
                                            }
                                            // else if ($STIDDATA[4]==$data['DTID'] && $data['SDID']==$data2['SDID'] && $STIDDATA[1]==$data['SDID']){ //0311
                                                    
                                            //     echo $data['Level']; 
                                            // }
                                            else if ($STIDDATA[4]==$data['DTID'] && $data['SDID']==$data2['SDID'] && $STIDDATA[1]==$data['SDID']){ //0311
                                                    
                                                echo $data['Level']; 
                                            }
                                            else {
                                                echo ''; 
                                            }
                                        }
                                        else 
                                        {
                                            echo $data['Level']; 
                                        }
                                        ?></td>


                                       <td class="class2021" style=><?php 
      
                                        if($data2['auaction']== 'Split'){
                                            // if($data['STID2011']!=$data['STID'] && $data['DTID2011']!=$data['DTID'] && $data['SDID2011']!=$data['SDID']) 
                                            // { 
                                            //     echo ''; 
                                            // } 
                                            // else 
                                            // { 
                                            //     echo $sta; 
                                            // } 
                                            if($data['STID2011']==$data['STID'] && $data['DTID2011']==$data['DTID'] && $data['SDID2011']==$data['SDID'])
                                            { 
                                                echo $sta; 
                                            } 
                                            else if($STIDDATA[1]==$data['SDID']) 
                                            {
                                                echo $sta; 
                                            } 
                                            // else if($STIDDATA[1]!=$data['SDID'] && $STIDDATA[1]==$data['SDID2011'] && $data['DTID2011']==$data['DTID']) //0611
                                            // {
                                            //     echo $sta; 
                                            // } 
                                             else 
                                             { echo ''; 
                                            }
                                        }
                                        else if($data2['auaction']== 'Merge'){
                                            if($data['STID2011']!=$data['STID'] && $data['SDID2011']!=$data['SDID']) 
                                            { 
                                                echo $sta;
                                            } 
                                            else if($data['STID2011']!=$data['STID'] && $data['SDID2011']==$data['SDID']) 
                                            { 
                                                echo $sta; 
                                            }
                                            else if($data['STID2011']=$data['STID'] && $data['DTID2011']!=$data['DTID'] && $data['SDID2011']!=$data['SDID']) 
                                            { 
                                                echo $sta; 
                                            }  
                                            else 
                                            {
                                                 echo ""; 
                                            } 
                                        }
                                        else if($data2['auaction']== 'Partially Merge'){
                                            if($data['STID']==$data2['STID'] && $data['DTID']==$data2['DTID'] && $data['SDID']==$data2['SDID'] && $STIDDATA[1]==$data['SDID']) 
                                            { 
                                                echo $sta; 
                                            } 
                                            else 
                                            {
                                                 echo ""; 
                                            } 
                                        }
                                        else if ($data2['auaction']== 'Reshuffle'){
                                            if ($STIDDATA[1]!=$data2['SDID'] && $data['SDID2011']!=$STIDDATA[1]){ //0311 
                                                    
                                                echo '';
                                            }
                                            else if ($STIDDATA[1]==$data2['SDID'] && $data['SDID2011']!=$STIDDATA[1]){ //0311  
                                                    
                                                echo $sta; 
                                            }
                                            else if ($STIDDATA[4]!=$data['DTID'] && $data['SDID']==$data2['SDID'] && $STIDDATA[1]!=$data['SDID']){ //0611
                                                    
                                                echo '';
                                            }
                                            else if (($STIDDATA[4]!=$data['DTID']) && $data['SDID']==$data2['SDID']){
                                                    
                                                echo $sta; 
                                            }
                                            // else if ($STIDDATA[4]==$data['DTID'] && $data['SDID']==$data2['SDID'] && $STIDDATA[1]==$data['SDID']){ //0311
                                                    
                                            //     echo $sta; 
                                            // }
                                            else if ($STIDDATA[4]==$data['DTID'] && $data['SDID']==$data2['SDID'] && $STIDDATA[1]==$data['SDID']){ //0311
                                                    
                                                echo $sta; 
                                            }
                                            else {
                                                echo ''; 
                                            }
                                        }
                                        else 
                                        {
                                            echo $sta; 
                                        }
                                        ?></td>


                                        <td class="class2021" style=><?php 
                              
                                        if($data2['auaction']== 'Split'){
                                            // if($data['STID2011']!=$data['STID'] && $data['DTID2011']!=$data['DTID'] && $data['SDID2011']!=$data['SDID']) 
                                            // { 
                                            //     echo ''; 
                                            // } 
                                            // else 
                                            // { 
                                            //     echo $data['Pop']; 
                                            // } 
                                            if($data['STID2011']==$data['STID'] && $data['DTID2011']==$data['DTID'] && $data['SDID2011']==$data['SDID'])
                                            { 
                                                echo $data['Pop']; 
                                            } 
                                            else if($STIDDATA[1]==$data['SDID']) 
                                            {
                                                echo $data['Pop']; 
                                            } 
                                            // else if($STIDDATA[1]!=$data['SDID'] && $STIDDATA[1]==$data['SDID2011'] && $data['DTID2011']==$data['DTID']) //0611
                                            // {
                                            //     echo $data['Pop']; 
                                            // }
                                             else 
                                             { echo ''; 
                                            }
                                        }
                                        else if($data2['auaction']== 'Merge'){
                                            if($data['STID2011']!=$data['STID'] && $data['SDID2011']!=$data['SDID']) 
                                            { 
                                                echo $data['Pop'];
                                            } 
                                            else if($data['STID2011']!=$data['STID'] && $data['SDID2011']==$data['SDID']) 
                                            { 
                                                echo $data['Pop']; 
                                            } 
                                            else if($data['STID2011']=$data['STID'] && $data['DTID2011']!=$data['DTID'] && $data['SDID2011']!=$data['SDID']) 
                                            { 
                                                echo $data['Pop']; 
                                            } 
                                            else 
                                            {
                                                 echo ""; 
                                            } 
                                        }
                                        else if($data2['auaction']== 'Partially Merge'){
                                            if($data['STID']==$data2['STID'] && $data['DTID']==$data2['DTID'] && $data['SDID']==$data2['SDID'] && $STIDDATA[1]==$data['SDID']) 
                                            { 
                                                echo $data['Pop']; 
                                            } 
                                            else 
                                            {
                                                 echo ""; 
                                            } 
                                        }
                                        else if ($data2['auaction']== 'Reshuffle'){

                                            if ($STIDDATA[1]!=$data2['SDID'] && $data['SDID2011']!=$STIDDATA[1]){ //0311 
                                                    
                                                echo '';
                                            }
                                            else if ($STIDDATA[1]==$data2['SDID'] && $data['SDID2011']!=$STIDDATA[1]){ //0311  
                                                    
                                               echo $data['Pop']; 
                                            }
                                            else if ($data['SDID2011']!=$data['SDID'] && $data['STID2011']!=$data['STID']){
                                                    
                                                echo '';
                                            }
                                            else if ($STIDDATA[4]!=$data['DTID'] && $data['SDID']==$data2['SDID'] && $STIDDATA[1]!=$data['SDID']){ //0611
                                                    
                                                echo '';
                                            }
                                            else if (($STIDDATA[4]!=$data['DTID']) && $data['SDID']==$data2['SDID']){
                                                    
                                                echo $data['Pop']; 
                                            }
                                            // else if ($STIDDATA[4]==$data['DTID'] && $data['SDID']==$data2['SDID'] && $STIDDATA[1]==$data['SDID']){ //0311
                                                    
                                            //     echo $data['Pop']; 
                                            // }
                                            else if ($STIDDATA[4]==$data['DTID'] && $data['SDID']==$data2['SDID'] && $STIDDATA[1]==$data['SDID']){ //0311
                                                    
                                                echo $data['Pop']; 
                                            }
                                            else {
                                                echo ''; 
                                            }
                                        }
                                        else 
                                        {
                                            echo $data['Pop']; 
                                        }
                                        ?></td>



                                        <!-- <td class="class2021"><?php //echo (int)$data['Wards']; ?></td> -->


                                        <td class="class2021" >
                                        <?php if($data['fromids']!=null){ ?><span class="badge badge-purple" style = "cursor:pointer; background-color:#fbca35;"    data-todo='<?php echo json_encode($data); ?>'>Incomplete</span><?php } ?></td>

                                        <?php /*<td class="class2021 <?php if((int)$data['linkeddocument21']!=0 && ($action == "" || in_array($data['STID'], $action) || in_array($data['DTID'], $action) || in_array($data['SDID'], $action))) { ?> btnlinked <?php } ?>"
                                            <?php if((int)$data['linkeddocument21']!=0  && ($action == "" || in_array($data['STID'], $action) || in_array($data['DTID'], $action) || in_array($data['SDID'], $action))) { ?>
                                            data-target="#con-close-modal-linked"
                                            data-todo='<?php echo json_encode($data); ?>'
                                            data-id="<?php echo $data['STID']; ?>" <?php } ?>><a
                                                <?php if((int)$data['linkeddocument21']!=0 && ($action == "" || in_array($data['STID'], $action) || in_array($data['DTID'], $action) || in_array($data['SDID'], $action))) { ?>
                                                href="javascript:void(0);" class="btnlinked"
                                                data-target="#con-close-modal-linked"
                                                data-todo='<?php echo json_encode($data); ?>'
                                                data-id="<?php echo $data['STID']; ?>" <?php } else {  ?>
                                                class="noaction" data-id="<?php echo $data['STID']; ?>"
                                                <?php } ?>><?php echo (int)$data['linkeddocument21']; ?></a>
                                        </td> */?>

                                       <?php /* <td class="class2021">
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown"
                                                    aria-expanded="true">
                                                    <i class="mdi mdi-dots-vertical"></i>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <li><a <?php if($action == "" || in_array($data['STID'], $action) || in_array($data['DTID'], $action) || in_array($data['SDID'], $action)) { ?>
                                                            href="#" data-toggle="modal" data-target="#con-close-modal"
                                                            class="dropdown-item btnEditnew"
                                                            data-id="<?php echo $data['VTID']; ?>"
                                                            data-todo='<?php echo json_encode($data); ?>'
                                                            <?php } else {  ?> class="dropdown-item noaction"
                                                            id="<?php echo $data['VTID']; ?>" <?php } ?>>Update</a>
                                                    </li>
                                                    <li><a <?php if($action == "" || in_array($data['STID'], $action) || in_array($data['DTID'], $action) || in_array($data['SDID'], $action)) { ?>
                                                            href="javascript:void(0);"
                                                            data-target="#con-close-modal-link"
                                                            data-todo='<?php echo json_encode($data); ?>'
                                                            data-id="<?php echo $data['STID']; ?>"
                                                            class="dropdown-item btnlink" <?php } else {  ?>
                                                            class="dropdown-item noaction"
                                                            id="<?php echo $data['VTID']; ?>" <?php } ?>>Link
                                                            Document</a>
                                                    </li>
                                                    <!-- <li><a href="javascript:void(0);" class="dropdown-item">View</a></li> -->
                                                    <li class="dropdown-divider"></li>
                                                    <li><a <?php if($action == "" || in_array($data['STID'], $action) || in_array($data['DTID'], $action) || in_array($data['SDID'], $action)) { ?>
                                                            href="javascript:void(0);"
                                                            id="<?php echo $data['VTID']; ?>"
                                                            class="dropdown-item deletetablerow" <?php } else {  ?>
                                                            class="dropdown-item noaction"
                                                            id="<?php echo $data['VTID']; ?>" <?php } ?>>Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>*/?>
                                       <td class="class2021">
                                        <input type="checkbox" id="myCheckbox" style = "cursor:pointer">
                                        <!-- data-vtname="<?php //echo $data['VTName']; ?> -->
                                       </td>

                                    </tr>
                                    <?php } 
                                // }
                                 ?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>



            </div>


            <!-- end row -->

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

<div id="con-close-modal-link" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">

    <div class="modal-dialog modal-full">
        <div class="modal-content">
            <form class="form-horizontal group-border-dashed parsley-examples" id="linkdata">
                <input type="hidden" name="datadtids" id="datadtids" value="">
                <input type="hidden" name="datasdids" id="datasdids" value="">
                <input type="hidden" name="datavtids" id="datavtids" value="">
                <input type="hidden" name="dataids" id="dataids" value="">
                <input type="hidden" name="comefrom" id="comefrom" value="VT">
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
                <input type="hidden" name="linkeddtdataids" id="linkeddtdataids" value="">
                <input type="hidden" name="linkedsddataids" id="linkedsddataids" value="">
                <input type="hidden" name="linkedvtdataids" id="linkedvtdataids" value="">
                <input type="hidden" name="linkedcomefrom" id="linkedcomefrom" value="VT">
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

<div id="con-close-modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form class="form-horizontal group-border-dashed" data-parsley-validate novalidate
                data-parsley-trigger="keyup" id="updatevillages">
                <input type="hidden" name="update_ids" id="update_ids" value="">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white">UPDATE VILLAGES</h5>
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
                                    <div class="col-md-10 pt-2">
                                        <select required id="STID2021" disabled="disabled" name="STID2021"
                                            onchange="return get_dist_select_data(this,'<?php echo $passvalue; ?>');">
                                            <option value="">Select State Name</option>
                                            <?php foreach ($row as $key => $element) { ?>
                                            <option value="<?php echo $element['STID2021']; ?>">
                                                <?php echo $element['STName2021']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">District Name</label>
                                    <div class="col-md-10 pt-2">
                                        <select required id="DTID2021" name="DTID2021" disabled="disabled"
                                            onchange="return get_subdist_select_data(this);">
                                            <option value="">Select Districts Name</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">Subdistrict Name</label>
                                    <div class="col-md-10 pt-2">
                                        <select disabled="disabled" required id="SDID2021" name="SDID2021"
                                            onchange="return get_subdist_select_datavals(this);">
                                            <option value="">Select Sub Districts Name</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label class="col-md-2 col-form-label">Villages/Town Name</label>

                                    <div class="col-md-5">
                                        <input type="text" id="VTName2011" name="VTName2011" class="form-control"
                                            disabled="disabled" placeholder="" />
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" id="VTName2021" name="VTName2021" class="form-control"
                                            required placeholder="Villages/Town Name" />
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label class="col-md-2 col-form-label">Short code</label>

                                    <div class="col-md-5">
                                        <input type="text" data-parsley-minlength="4" id="Short_VT2011"
                                            name="Short_VT2011" data-parsley-maxlength="10"
                                            onkeypress="return numbersOnly12(event)" class="form-control"
                                            disabled="disabled" placeholder="" />
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" data-parsley-minlength="4" id="Short_VT2021"
                                            name="Short_VT2021" data-parsley-maxlength="10"
                                            onkeypress="return numbersOnly12(event)" class="form-control"
                                            placeholder="Short code" />
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label class="col-md-2 col-form-label">MDDS Code</label>

                                    <div class="col-md-5">
                                        <input type="text" id="MDDS_VT2011" name="MDDS_VT2011"
                                            data-parsley-minlength="6" data-parsley-maxlength="10"
                                            onkeypress="return numbersOnly12(event)" class="form-control"
                                            disabled="disabled" placeholder="" />
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" id="MDDS_VT2021" name="MDDS_VT2021"
                                            data-parsley-minlength="6" data-parsley-maxlength="10"
                                            onkeypress="return numbersOnly12(event)" class="form-control"
                                            placeholder="MDDS Code" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">Level</label>
                                    <div class="col-md-10 pt-2">
                                        <select data-toggle="select2" required="required" id="Level2021"
                                            name="Level2021" onchange="return get_status_data_update(this);">
                                            <option value="">Select Level</option>
                                            <option value="VILLAGE">Village</option>
                                            <option value="TOWN">Town</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">Status</label>
                                    <div class="col-md-10 pt-2">
                                        <select data-toggle="select2" disabled="disabled" id="Status2021"
                                            name="Status2021">
                                            <option value="">Select Status</option>
                                        </select>
                                    </div>
                                </div>
                                <!--   <div class="form-group row">
                                                                    <label class="col-md-3 col-form-label">OGTYPE</label>
                                                                     <div class="col-md-9">
                                                                        <input type="text" class="form-control" required
                                                                                placeholder="OGTYPE"/>
                                                                    </div>
                                                                </div> -->
                                <div class="form-group row">

                                    <label class="col-md-2 col-form-label">Population</label>

                                    <div class="col-md-5">
                                        <input type="text" id="Pop2011" name="Pop2011" data-parsley-minlength="1"
                                            data-parsley-maxlength="10" onkeypress="return numbersOnly12(event)"
                                            class="form-control" disabled="disabled" placeholder="" />
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" id="Pop2021" name="Pop2021" data-parsley-minlength="1"
                                            data-parsley-maxlength="10" onkeypress="return numbersOnly12(event)"
                                            class="form-control" required placeholder="Population" />
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label class="col-md-2 col-form-label">Area</label>

                                    <div class="col-md-5">
                                        <input type="text" disabled="disabled" onkeypress="return numbersOnly12(event)"
                                            id="Area2011" name="Area2011" class="form-control" placeholder="" />
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" required onkeypress="return numbersOnly12(event)"
                                            id="Area2021" name="Area2021" class="form-control" placeholder="Area" />
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label class="col-md-2 col-form-label">Remark 1</label>

                                    <div class="col-md-5">
                                        <textarea class="form-control" placeholder="Remark 1" rows="4" id="upRemark111"
                                            name="upRemark111" disabled="disabled"></textarea>
                                    </div>
                                    <div class="col-md-5">
                                        <textarea class="form-control" placeholder="Remark 1" rows="4" id="upRemark121"
                                            name="upRemark121"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label class="col-md-2 col-form-label">Remark 2</label>

                                    <div class="col-md-5">
                                        <textarea class="form-control" placeholder="Remark 2" rows="4" id="upRemark211"
                                            name="upRemark211" disabled="disabled"></textarea>
                                    </div>
                                    <div class="col-md-5">
                                        <textarea class="form-control" placeholder="Remark 2" rows="4" id="upRemark221"
                                            name="upRemark221"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end col -->

                    </div>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect closepop" data-dismiss="modal"
                        aria-label="Close">Cancel</button>
                    <button type="submit" class="btn btn-info waves-effect waves-light">Save</button>
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
                data-parsley-trigger="keyup" id="addvillages">
                <input type="hidden" name="formname" id="formname" value="addvillagesdata">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white">ADD VILLAGES</h5>
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
                                    <label class="col-md-9 col-form-label">2021</label>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">State Name</label>
                                    <div class="col-md-9 pt-2">
                                        <select required id="addSTID2021" name="addSTID2021"
                                            onchange="return get_dist_select_data(this,'<?php echo $passvalue; ?>');">
                                            <option value="">Select State Name</option>
                                            <?php foreach ($row as $key => $element) { ?>
                                            <option value="<?php echo $element['STID2021']; ?>">
                                                <?php echo $element['STName2021']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">District Name</label>
                                    <div class="col-md-9 pt-2">
                                        <select required id="addDTID2021" name="addDTID2021"
                                            onchange="return get_subdist_select_data(this);">
                                            <option value="">Select Districts Name</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Subdistrict Name</label>
                                    <div class="col-md-9 pt-2">
                                        <select required id="addSDID2021" name="addSDID2021"
                                            onchange="return get_subdist_select_datavals(this);">
                                            <option value="">Select Sub Districts Name</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Villages/Town Name</label>
                                    <div class="col-md-9">
                                        <input type="text" id="addVTName2021" name="addVTName2021" class="form-control"
                                            required placeholder="Villages/Town Name" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Short code</label>
                                    <div class="col-md-9">
                                        <input type="text" data-parsley-minlength="4" id="addShort_VT2021"
                                            name="addShort_VT2021" data-parsley-maxlength="10"
                                            onkeypress="return numbersOnly12(event)" class="form-control"
                                            placeholder="Short code" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">MDDS Code</label>
                                    <div class="col-md-9">
                                        <input type="text" id="addMDDS_VT2021" name="addMDDS_VT2021"
                                            data-parsley-minlength="6" data-parsley-maxlength="10"
                                            onkeypress="return numbersOnly12(event)" class="form-control"
                                            placeholder="MDDS Code" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Level</label>
                                    <div class="col-md-9 pt-2">
                                        <select data-toggle="select2" required="required" id="addLevel2021"
                                            name="addLevel2021" onchange="return get_status_data(this);">
                                            <option value="">Select Level</option>
                                            <option value="VILLAGE">Village</option>
                                            <option value="TOWN">Town</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Status</label>
                                    <div class="col-md-9 pt-2">
                                        <select data-toggle="select2" disabled="disabled" id="addStatus2021"
                                            name="addStatus2021">
                                            <option value="">Select Status</option>
                                        </select>
                                    </div>
                                </div>
                                <!--   <div class="form-group row">
                                                                    <label class="col-md-3 col-form-label">OGTYPE</label>
                                                                     <div class="col-md-9">
                                                                        <input type="text" class="form-control" required
                                                                                placeholder="OGTYPE"/>
                                                                    </div>
                                                                </div> -->
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Population</label>
                                    <div class="col-md-9">
                                        <input type="text" id="addPop2021" name="addPop2021" data-parsley-minlength="1"
                                            data-parsley-maxlength="10" onkeypress="return numbersOnly12(event)"
                                            class="form-control" required placeholder="Population" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Area</label>
                                    <div class="col-md-9">
                                        <input type="text" required onkeypress="return numbersOnly12(event)"
                                            id="addArea2021" name="addArea2021" class="form-control"
                                            placeholder="Area" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Remark 1</label>
                                    <div class="col-md-9">
                                        <textarea class="form-control" placeholder="Remark 1" rows="4" id="addRemark1"
                                            name="addRemark1"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Remark 2</label>
                                    <div class="col-md-9">
                                        <textarea class="form-control" placeholder="Remark 2" rows="4" id="addRemark2"
                                            name="addRemark2"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end col -->

                    </div>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect closepop" data-dismiss="modal"
                        aria-label="Close">Cancel</button>
                    <button type="submit" class="btn btn-info waves-effect waves-light">Save</button>
                </div>
            </form>
        </div>

    </div>
</div>

<script type="text/javascript">
$('select').select2({
    maximumInputLength: 20 // only allow terms up to 20 characters long
});

//modified by sahana to check the checkbox for uploading map
var checkboxes = document.querySelectorAll("input[id='myCheckbox']");
checkboxes.forEach(function(checkbox) {
    checkbox.addEventListener("click", function(event) {
        var row = checkbox.closest("tr");
        var stName = row.querySelector("td:nth-child(7)").textContent;

        Swal.fire({
            type: checkbox.checked ? "success" : "error",
            title: checkbox.checked ? "Verification" : "Pending",
            text: checkbox.checked
                ? "I have verified that as per the uploaded document (notification), " + stName + " administrative units have been updated in the map"
                : "As per the uploaded document (notification), " + stName + " administrative units is pending to be uploaded in the map",
                confirmButtonText: checkbox.checked ? "Agree" : "Ok",
        });
        event.stopPropagation();
    });
});
</script>