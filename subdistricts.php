<?php include ("header.php"); include ("topbar.php"); include ("menu.php"); 
if(!isset($_GET) || $_GET['ids']=='')
{
     echo "<script language='javascript'>location.href='units';</script>";
        exit;
}

$datof = base64_decode( $_GET['ids'] ); 
//Remove Wine color in Sub district Defect_JC_52
$dat = base64_decode( $_GET['data'] );


$STIDDATA = explode('**',$datof);
//Remove Wine color in Sub district Defect_JC_52
$boxdata = explode(',',$dat);


          
$arra=array($STIDDATA[1]);         
$result = pg_query_params($db, 'select * from "sdCount'.$_SESSION['logindetails']['baseyear'].'" Full JOIN "sdCount'.$_SESSION['activeyears'].'" Left JOIN ( SELECT fromids,partiallydataids,toids,docids,partiallyids,comefrom
           FROM "partiallydata'.$_SESSION['activeyears'].'" where pstatus=0 group by fromids,partiallydataids,toids,docids,partiallyids,comefrom) pd 
           LEFT JOIN ( select * from documentdata'.$_SESSION['activeyears'].') dd ON dd.docids=pd.docids
            LEFT JOIN ( select "STID" as "STIDS","DTID" as "DTIDS","DTName" as "DTNameof" from dt'.$_SESSION['activeyears'].') dtd ON dtd."DTIDS"=pd."toids"

           ON "sdCount'.$_SESSION['activeyears'].'"."SDID" = pd."partiallydataids"
           On "sdCount'.$_SESSION['logindetails']['baseyear'].'"."SDID'.$_SESSION['logindetails']['baseyear'].'"="sdCount'.$_SESSION['activeyears'].'"."SDID" where ("sdCount'.$_SESSION['activeyears'].'"."DTID" = $1 OR "sdCount'.$_SESSION['logindetails']['baseyear'].'"."DTID'.$_SESSION['logindetails']['baseyear'].'" = $1)', $arra);

$where = "";


$action = "";
$passvalue ="";
if($header!=0 && $rows['assignlist']!=null)  
{
    // if($rows['adminassigntype']!="ST")
    // {
    //  $passvalue = $rows['assignlist'];   
    // }
    $action = explode(',',$rows['assignlist']);
    // $where = 'where "STID" in ('.$rows['assignstids'].')';
    $array = array($rows['assignlist']);
    $resultstate = pg_query_params($db, 'select "STID","STName" from "st'.$_SESSION['activeyears'].'" where "STID" in ($1) order by "STID" ASC', $array);

 $row = pg_fetch_all($resultstate); 
}
else
{
    $action = "";
    $resultstate = pg_query($db, 'select "STID","STName" from "st'.$_SESSION['activeyears'].'"  order by "STID" ASC');

 $row = pg_fetch_all($resultstate); 

}




 $qi="SELECT  
     string_agg(ids,',') as sdids
FROM sdincompleted";
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
<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->

<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <?php include("breadcrumbs.php"); ?>
            <!-- end page title -->

            <?php include("box.php"); ?>

            <!-- end row -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dropdown float-right">
                                <?php if($header==0 || ($header==1 && ($rows['adminassigntype']=="ST" || $rows['adminassigntype']=="DT"))) { ?>
                               <!--  <button class="btn btn-primary btn-rounded waves-effect waves-light" data-toggle="modal"
                                    data-target="#con-close-modal-add" data-backdrop="static" data-keyboard="false"> <i
                                        class="fas fa-plus-circle mr-1"></i> <span>ADD SUB DISTRICT</span> </button> -->
                                <?php } ?>

                            </div>

                            <h4 class="header-title mb-4"><span class="dropcap text-primary">Sub-Districtwise</span>
                                Administrative Units - Census <?php echo $_SESSION['logindetails']['baseyear']; ?> - Census <?php echo $_SESSION['activeyears']; ?></h4>
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
      var table = document.getElementById('subdistricts-units-datatable');
      
      // Create a new table with only the desired columns for 2011
      if (selectedYear == '2011') {
        var newTable = document.createElement('table');
        var thead = document.createElement('thead');
        var headerRow = document.createElement('tr');
        var columns = ["Sub-district MDDS Code", "Sub-district Name", "Villages", "Towns"];
        
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
        var columns = ["Sub-district MDDS Code", "Sub-district Name", "Villages", "Towns","Status"];
        
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
          
          // Copy last 5 cells for 2021
          for (var k = rowData.length - 5; k < rowData.length; k++) {
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
      link.download = 'Sub-District-Level_Administrative_Units_' + selectedYear + '.xlsx';
      link.style.display = 'none';
      document.body.appendChild(link);
      
      // Trigger the download
      link.click();
      
      // Clean up the temporary link element
      document.body.removeChild(link);
      
      toastr['success']('Administrative Units ' + selectedYear + ' Downloaded Successfully For Sub-district Level.');
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

                            <table id="subdistricts-units-datatable"
                                class="table table-hover table-striped table-bordered"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th colspan="4" style="background-color: #fe6271; color: #FFFFFF">Administrative Units - Census <?php echo $_SESSION['logindetails']['baseyear']; ?></th>
                                        <th colspan="7" style="background-color: #15bed2; color: #FFFFFF ">
                                            Administrative Units - Census <?php echo $_SESSION['activeyears']; ?></th>

                                    </tr>
                                    <tr>
                                        <th>Sub-District MDDS Code</th>
                                        <th>Sub-District Name</th>
                                        <th>Villages</th>
                                        <th>Towns</th>
                                        <!-- <th>Wards</th> -->

                                        <th>Sub-District MDDS Code</th>
                                        <th>Sub-District Name</th>
                                        <th>Villages</th>
                                        <th>Towns</th>
                                        <!-- <th>Wards</th> -->
                                        <th>Status</th>
                                       
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
                                    <?php while ($data = pg_fetch_assoc($result)) { 
                                        // echo "<pre>";
                                        // print_r($STIDDATA);
                                        // print_r($data);
                                         $fla=false;                                                 
                                        if (in_array($data['SDID'], $arraydata))
                                        {
                                            $fla=true;  
                                        }

                                        //By sahana 0111
                                        $dtid = $data['SDID'];
                                        $query2 = 'SELECT * FROM sd' . $_SESSION['activeyears'] . ' WHERE "SDID" = $1';
                                        $result2 = pg_query_params($db, $query2, array($dtid));
                                        
                                        if (!$result2) {
                                            echo 'Query failed: ' . pg_last_error($db);
                                        }
                                
                                        $data2 = pg_fetch_array($result2)
                                    ?>
                                        <tr id="<?php echo $data['SDID']."*****".$data['SDID'.$_SESSION['logindetails']['baseyear'].'']; ?>" <?php if($fla){ ?>class="incompleted"<?php  } ?>>
                                        
                                          <!-- Modified by sahana Split_Action_Administrative_Units 0310 Defect_JC_38-->  
                                          <td>
                                        <?php  
                                            if($data2['auaction']== 'Split'){
                                                if($data['STID2011']!=$data['STID'])
                                                {
                                                        if (($data['STID2011']!=$data['STID']) && ($data['DTID2011']!=$data['DTID']) && ($data['SDID2011']!=$data['SDID']))
                                                        { 
                                                            echo $data['MDDS_SD'.$_SESSION['logindetails']['baseyear'].''];  
                                                        } 
                                                        else if ((($data['STID2011']==$data['STID']) && ($STIDDATA[1]==$data['DTID2011'])) || ($STIDDATA[1]!=$data['DTID']))
                                                        {
                                                            echo $data['MDDS_SD'.$_SESSION['logindetails']['baseyear'].''];  
                                                        } 
                                                        else 
                                                        { 
                                                            echo '';  
                                                        } 
                                                }
                                                else if ($data['STID2011']==$data['STID'])
                                                {
                                                        if ((($data['STID2011']==$data['STID']) && ($STIDDATA[1]==$data['DTID2011'])) || ($STIDDATA[1]!=$data['DTID']))
                                                        {
                                                            echo $data['MDDS_SD'.$_SESSION['logindetails']['baseyear'].''];  
                                                        } 
                                                        else 
                                                        { 
                                                            echo '';  
                                                        } 
                                                }
                                            }
                                            else if ($data2['auaction']== 'Full Merge')
                                            {
                                                if($data['STID']==$data2['STID']){
                                                    
                                                    echo ''; 
                                                }
                                                else {
                                                    echo $data['MDDS_SD'.$_SESSION['logindetails']['baseyear'].''];  
                                                }
                                            }
                                            else if ($data2['auaction']== 'Merge'){
                                                if($data['STID']!=$data2['STID'] && $data['DTID']==$data2['DTID'] ){ //1311
                                                    
                                                    echo $data['MDDS_SD'.$_SESSION['logindetails']['baseyear'].''];  
                                                    
                                                }
                                                else if($data['STID']==$data2['STID'] && $data['DTID']!=$data2['DTID']){ //1311
                                                    
                                                    echo $data['MDDS_SD'.$_SESSION['logindetails']['baseyear'].''];  
                                                    
                                                }
                                                else if($data['STID']==$data2['STID'] && $data['DTID']==$data2['DTID'] && $data['SDID']==$data2['SDID'] && $data['STID2011']==$data['STID']){ //1311
                                                    
                                                    echo $data['MDDS_SD'.$_SESSION['logindetails']['baseyear'].''];  
                                                    
                                                }
                                                else {
                                                    echo ''; 
                                                }

                                            }
                                            else if ($data2['auaction']== 'Partially Merge'){

                                                // if($STIDDATA[1]==$data['DTID2011'] && $data['SDID2011']==$data2['SDID']){
                                                    
                                                //     echo $data['MDDS_SD'.$_SESSION['logindetails']['baseyear'].'']; 
                                                // }
                                                // else {
                                                //     echo ''; 
                                                // }
                                                if($data['STID2011']==$data['STID'] && $data['DTID2011']==$data['DTID'] && $data['SDID2011']==$data['SDID'])
                                                { 
                                                    echo $data['MDDS_SD'.$_SESSION['logindetails']['baseyear'].''];  
                                                } 
                                                else if($data['DTID2011']==$data['DTID'])
                                                { 
                                                    echo "";
                                                }
                                                else if($STIDDATA[1]==$data['DTID2011'] && $data['SDID2011']==$data2['SDID'] && $data['DTID']==$data['DTIDR'])
                                                { 
                                                    echo $data['MDDS_SD'.$_SESSION['logindetails']['baseyear'].''];  
                                                } 
                                                else 
                                                {
                                                     echo ""; 
                                                } 
                                            }
                                            else if ($data2['auaction']== 'Reshuffle'){
                                                if (($data['STID']==$data2['STID']) && ($STIDDATA[1]==$data2['DTID'])){
                                                    
                                                    echo ''; 
                                                }
                                                else {
                                                    echo $data['MDDS_SD'.$_SESSION['logindetails']['baseyear'].''];  
                                                }
                                            }
                                            else {
                                                echo $data['MDDS_SD'.$_SESSION['logindetails']['baseyear'].''];  
                                            }

                                        ?>
                                        </td>
                                        <td>
                                            <?php 
                                        if($data2['auaction']== 'Split'){
                                            if($data['STID2011']!=$data['STID'])
                                            {
                                                    if (($data['STID2011']!=$data['STID']) && ($data['DTID2011']!=$data['DTID']) && ($data['SDID2011']!=$data['SDID']))
                                                    { 
                                                        echo $data['SDName'.$_SESSION['logindetails']['baseyear'].''];
                                                    } 
                                                    else if ((($data['STID2011']==$data['STID']) && ($STIDDATA[1]==$data['DTID2011'])) || ($STIDDATA[1]!=$data['DTID']))
                                                    {
                                                        echo $data['SDName'.$_SESSION['logindetails']['baseyear'].''];
                                                    } 
                                                    else 
                                                    { 
                                                        echo '';  
                                                    } 
                                            }
                                            else if ($data['STID2011']==$data['STID'])
                                            {
                                                    if ((($data['STID2011']==$data['STID']) && ($STIDDATA[1]==$data['DTID2011'])) || ($STIDDATA[1]!=$data['DTID']))
                                                    {
                                                        echo $data['SDName'.$_SESSION['logindetails']['baseyear'].''];
                                                    } 
                                                    else 
                                                    { 
                                                        echo '';  
                                                    } 
                                            }
                                        }
                                        else if ($data2['auaction']== 'Full Merge')
                                            {
                                                if($data['STID']==$data2['STID']){
                                                    
                                                    echo ''; 
                                                }
                                                else {
                                                    echo $data['SDName'.$_SESSION['logindetails']['baseyear'].''];   
                                                }
                                            }
                                        else if ($data2['auaction']== 'Merge'){
                                            if($data['STID']!=$data2['STID'] && $data['DTID']==$data2['DTID'] ){ //1311
                                                
                                                echo $data['SDName'.$_SESSION['logindetails']['baseyear'].'']; 
                                                
                                            }
                                            else if($data['STID']==$data2['STID'] && $data['DTID']!=$data2['DTID']){ //1311
                                                    
                                                echo $data['SDName'.$_SESSION['logindetails']['baseyear'].'']; 
                                                
                                            }
                                            else if($data['STID']==$data2['STID'] && $data['DTID']==$data2['DTID'] && $data['SDID']==$data2['SDID'] && $data['STID2011']==$data['STID']){ //1311
                                                    
                                                echo $data['SDName'.$_SESSION['logindetails']['baseyear'].''];  
                                                
                                            }
                                            else {
                                                echo ''; 
                                            }

                                        }
                                        else if ($data2['auaction']== 'Partially Merge'){

                                            if($data['STID2011']==$data['STID'] && $data['DTID2011']==$data['DTID'] && $data['SDID2011']==$data['SDID']){ 
                                                
                                                echo $data['SDName'.$_SESSION['logindetails']['baseyear'].''];  
                                            }
                                            else if($data['DTID2011']==$data['DTID'])
                                                { 
                                                    echo "";
                                                }
                                            else if($STIDDATA[1]==$data['DTID2011'] && $data['SDID2011']==$data2['SDID'] && $data['DTID']==$data['DTIDR'])
                                                { 
                                                    echo $data['SDName'.$_SESSION['logindetails']['baseyear'].''];  
                                                } 
                                            else {
                                                echo ''; 
                                            }
                                        }
                                        else if ($data2['auaction']== 'Reshuffle'){
                                            if ((($data['STID']==$data2['STID']) && ($STIDDATA[1]==$data2['DTID']))){
                                                
                                                echo ''; 
                                            }
                                            else {
                                                echo $data['SDName'.$_SESSION['logindetails']['baseyear'].'']; 
                                            }
                                        }
                                        else {
                                            echo $data['SDName'.$_SESSION['logindetails']['baseyear'].''];  
                                        }
                                            ?>
                                            
                                        </td>
                                        <td>
                                            <?php 
                                            if($data2['auaction']== 'Split'){
                                                if($data['STID2011']!=$data['STID'])
                                                {
                                                        if (($data['STID2011']!=$data['STID']) && ($data['DTID2011']!=$data['DTID']) && ($data['SDID2011']!=$data['SDID']))
                                                        { 
                                                            echo $data['Villages'.$_SESSION['logindetails']['baseyear'].''];  
                                                        } 
                                                        else if ((($data['STID2011']==$data['STID']) && ($STIDDATA[1]==$data['DTID2011'])) || ($STIDDATA[1]!=$data['DTID']))
                                                        {
                                                            echo $data['Villages'.$_SESSION['logindetails']['baseyear'].''];  
                                                        } 
                                                        else 
                                                        { 
                                                            echo '';  
                                                        } 
                                                }
                                                else if ($data['STID2011']==$data['STID'])
                                                {
                                                        if ((($data['STID2011']==$data['STID']) && ($STIDDATA[1]==$data['DTID2011'])) || ($STIDDATA[1]!=$data['DTID']))
                                                        {
                                                            echo $data['Villages'.$_SESSION['logindetails']['baseyear'].''];  
                                                        } 
                                                        else 
                                                        { 
                                                            echo '';  
                                                        } 
                                                }
                                            }
                                            else if ($data2['auaction']== 'Full Merge')
                                            {
                                                if($data['STID']==$data2['STID']){
                                                    
                                                    echo ''; 
                                                }
                                                else {
                                                    echo $data['Villages'.$_SESSION['logindetails']['baseyear'].'']; 
                                                }
                                            }
                                            else if ($data2['auaction']== 'Merge'){
                                                if($data['STID']!=$data2['STID'] && $data['DTID']==$data2['DTID'] ){ //1311
                                                    
                                                    echo $data['Villages'.$_SESSION['logindetails']['baseyear'].'']; 
                                                    
                                                }
                                                else if($data['STID']==$data2['STID'] && $data['DTID']!=$data2['DTID']){ //1311
                                                    
                                                    echo $data['Villages'.$_SESSION['logindetails']['baseyear'].''];  
                                                    
                                                }
                                                else if($data['STID']==$data2['STID'] && $data['DTID']==$data2['DTID'] && $data['SDID']==$data2['SDID'] && $data['STID2011']==$data['STID']){ //1311
                                                    
                                                    echo $data['Villages'.$_SESSION['logindetails']['baseyear'].''];  
                                                    
                                                }
                                                else {
                                                    echo ''; 
                                                }

                                            }
                                            else if ($data2['auaction']== 'Partially Merge'){

                                                if($data['STID2011']==$data['STID'] && $data['DTID2011']==$data['DTID'] && $data['SDID2011']==$data['SDID']) {
                                                    
                                                    echo $data['Villages'.$_SESSION['logindetails']['baseyear'].''];  
                                                }
                                                else if($data['DTID2011']==$data['DTID'])
                                                { 
                                                    echo "";
                                                }
                                                else if($STIDDATA[1]==$data['DTID2011'] && $data['SDID2011']==$data2['SDID'] && $data['DTID']==$data['DTIDR'])
                                                { 
                                                    echo $data['Villages'.$_SESSION['logindetails']['baseyear'].''];  
                                                } 
                                                else {
                                                    echo ''; 
                                                }
                                            }
                                            else if ($data2['auaction']== 'Reshuffle'){
                                                if ((($data['STID']==$data2['STID']) && ($STIDDATA[1]==$data2['DTID']))){
                                                    
                                                    echo ''; 
                                                }
                                                else {
                                                    echo $data['Villages'.$_SESSION['logindetails']['baseyear'].''];  
                                                }
                                            }
                                            else {
                                                echo $data['Villages'.$_SESSION['logindetails']['baseyear'].''];  
                                            }
                                            ?>
                                                
                                            </td>
                                        <td>
                                           <?php 
                                        if($data2['auaction']== 'Split'){
                                            if($data['STID2011']!=$data['STID'])
                                                {
                                                        if (($data['STID2011']!=$data['STID']) && ($data['DTID2011']!=$data['DTID']) && ($data['SDID2011']!=$data['SDID']))
                                                        { 
                                                            echo $data['Towns'.$_SESSION['logindetails']['baseyear'].'']; 
                                                        } 
                                                        else if ((($data['STID2011']==$data['STID']) && ($STIDDATA[1]==$data['DTID2011'])) || ($STIDDATA[1]!=$data['DTID']))
                                                        {
                                                            echo $data['Towns'.$_SESSION['logindetails']['baseyear'].'']; 
                                                        } 
                                                        else 
                                                        { 
                                                            echo '';  
                                                        } 
                                                }
                                                else if ($data['STID2011']==$data['STID'])
                                                {
                                                        if ((($data['STID2011']==$data['STID']) && ($STIDDATA[1]==$data['DTID2011'])) || ($STIDDATA[1]!=$data['DTID']))
                                                        {
                                                            echo $data['Towns'.$_SESSION['logindetails']['baseyear'].'']; 
                                                        } 
                                                        else 
                                                        { 
                                                            echo '';  
                                                        } 
                                                }
                                        }
                                        else if ($data2['auaction']== 'Full Merge')
                                            {
                                                if($data['STID']==$data2['STID']){
                                                    
                                                    echo ''; 
                                                }
                                                else {
                                                    echo $data['Towns'.$_SESSION['logindetails']['baseyear'].''];  
                                                }
                                            }
                                        else if ($data2['auaction']== 'Merge'){
                                            if($data['STID']!=$data2['STID'] && $data['DTID']==$data2['DTID'] ){ //1311
                                                
                                                echo $data['Towns'.$_SESSION['logindetails']['baseyear'].'']; 
                                                
                                            }
                                            else if($data['STID']==$data2['STID'] && $data['DTID']!=$data2['DTID']){ //1311
                                                    
                                                echo $data['Towns'.$_SESSION['logindetails']['baseyear'].'']; 
                                                
                                            }
                                            else if($data['STID']==$data2['STID'] && $data['DTID']==$data2['DTID'] && $data['SDID']==$data2['SDID'] && $data['STID2011']==$data['STID']){ //1311
                                                    
                                                echo $data['Towns'.$_SESSION['logindetails']['baseyear'].'']; 
                                                
                                            }
                                            else {
                                                echo ''; 
                                            }

                                        }
                                        else if ($data2['auaction']== 'Partially Merge'){

                                            if($data['STID2011']==$data['STID'] && $data['DTID2011']==$data['DTID'] && $data['SDID2011']==$data['SDID']) {
                                                
                                                echo $data['Towns'.$_SESSION['logindetails']['baseyear'].'']; 
                                            }
                                            else if($data['DTID2011']==$data['DTID'])
                                                { 
                                                    echo "";
                                                }
                                            else if($STIDDATA[1]==$data['DTID2011'] && $data['SDID2011']==$data2['SDID'] && $data['DTID']==$data['DTIDR'])
                                                { 
                                                    echo $data['Towns'.$_SESSION['logindetails']['baseyear'].'']; 
                                                } 
                                            else {
                                                echo ''; 
                                            }
                                        }
                                        else if ($data2['auaction']== 'Reshuffle'){
                                            if ((($data['STID']==$data2['STID']) && ($STIDDATA[1]==$data2['DTID']))){
                                                
                                                echo ''; 
                                            }
                                            else {
                                                echo $data['Towns'.$_SESSION['logindetails']['baseyear'].'']; 
                                            }
                                        }
                                        else {
                                            echo $data['Towns'.$_SESSION['logindetails']['baseyear'].'']; 
                                        }                                           
                                            ?>
                                                
                                            </td>



                                        <?php /* ?><td><?php if($data['STID2011']==$data['STID'] && $data['DTID2011']==$data['DTID']){ echo $data['Wards'.$_SESSION['logindetails']['baseyear'].'']; } else if($STIDDATA[1]!=$data['DTID2011']) { echo '';  }  else { echo $data['Wards'.$_SESSION['logindetails']['baseyear'].''];  } ?></td> <?php */ ?>


                                         <!-- Modified by sahana Split_Action_Administrative_Units 0310 Defect_JC_38-->  
                                        <td class="<?php if($fla){ ?>incompleted<?php  } ?>class2021">
                                            <?php  
                                        if ($data2['auaction']== 'Split')
                                        {
                                            if ((($data['STID']==$data2['STID']) && ($STIDDATA[1]==$data2['DTID']))){
                                                    
                                                
                                                echo $data['MDDS_SD']; 
                                            }
                                            else {
                                                echo ''; 
                                            }
                                        }
                                        else if ($data2['auaction']== 'Partially Merge'){
                                            if($STIDDATA[1]!=$data['DTID2011'])
                                            { 
                                                echo $data['MDDS_SD']; 
                                            } 
                                            else if(($STIDDATA[4]==$data['STID']) && ($STIDDATA[1]==$data['DTID']))
                                            {
                                                echo $data['MDDS_SD']; 
                                            }
                                            else if ($STIDDATA[1]==$data['DTID2011'] && $STIDDATA[1]==$data['DTID'])
                                            {
                                                echo $data['MDDS_SD']; 
                                            }
                                            else 
                                            { 
                                                echo '';   
                                            } 
                                        }
                                        else if ($data2['auaction']== 'Reshuffle')
                                        {
                                            if ((($data['STID']==$data2['STID']) && ($STIDDATA[1]==$data2['DTID']))){
                                                    
                                                
                                                echo $data['MDDS_SD'];  
                                            }
                                            else {
                                                echo ''; 
                                            }
                                        }
                                        else 
                                        {
                                            echo $data['MDDS_SD']; 
                                        }
                                        
                                            ?>
                                                
                                            </td>
                                        <td class="<?php if($fla){ ?>incompleted<?php  } ?>class2021">
                                            <?php  

                                        if ($data2['auaction']== 'Split')
                                        {
                                            if ((($data['STID']==$data2['STID']) && ($STIDDATA[1]==$data2['DTID']))){
                                                    
                                                
                                                echo $data['SDName'];  
                                            }
                                            else {
                                                echo ''; 
                                            }
                                        }
                                        else if ($data2['auaction']== 'Partially Merge'){
                                            if($STIDDATA[1]!=$data['DTID2011'])
                                            { 
                                                echo $data['SDName']; 
                                            } 
                                            else if(($STIDDATA[4]==$data['STID']) && ($STIDDATA[1]==$data['DTID']))
                                            {
                                                echo $data['SDName']; 
                                            }
                                            else if ($STIDDATA[1]==$data['DTID2011'] && $STIDDATA[1]==$data['DTID'])
                                            {
                                                echo $data['SDName']; 
                                            }
                                            else 
                                            { 
                                                echo '';   
                                            } 
                                        }
                                        else if ($data2['auaction']== 'Reshuffle')
                                        {
                                            if ((($data['STID']==$data2['STID']) && ($STIDDATA[1]==$data2['DTID'])))
                                            {
                                                
                                                echo $data['SDName']; 
                                            }
                                            else {
                                                echo ''; 
                                            }
                                        }
                                        else 
                                        {
                                           echo $data['SDName']; 
                                        }
                                            ?>
                                                
                                            </td>
                                        <td class="<?php if($fla){ ?>incompleted<?php  } ?>class2021">
                                             <?php  
                                        if ($data2['auaction']== 'Split')
                                        {
                                            if ((($data['STID']==$data2['STID']) && ($STIDDATA[1]==$data2['DTID']))){
                                                    
                                                
                                                echo $data['Villages'];;  
                                            }
                                            else {
                                                echo ''; 
                                            }
                                        }
                                        else if ($data2['auaction']== 'Partially Merge'){
                                            if($STIDDATA[1]!=$data['DTID2011'])
                                            { 
                                                echo $data['Villages'];
                                            } 
                                            else if(($STIDDATA[4]==$data['STID']) && ($STIDDATA[1]==$data['DTID']))
                                            {
                                                echo $data['Villages'];
                                            }
                                            else if ($STIDDATA[1]==$data['DTID2011'] && $STIDDATA[1]==$data['DTID'])
                                            {
                                                echo $data['Villages'];
                                            }
                                            else 
                                            { 
                                                echo '';   
                                            } 
                                        }
                                        else if ($data2['auaction']== 'Reshuffle')
                                        {
                                            if ((($data['STID']==$data2['STID']) && ($STIDDATA[1]==$data2['DTID']))){
                                                    
                                                
                                                echo $data['Villages'];
                                            }
                                            else {
                                                echo ''; 
                                            }
                                        }
                                        else 
                                        {
                                            echo $data['Villages'];
                                        }
                                             ?>
                                                
                                            </td>
                                        <td class="<?php if($fla){ ?>incompleted<?php  } ?>class2021">
                                            <?php  
                                        if ($data2['auaction']== 'Split')
                                        {
                                            if ((($data['STID']==$data2['STID']) && ($STIDDATA[1]==$data2['DTID']))){
                                                    
                                                
                                                echo $data['Towns'];  
                                            }
                                            else {
                                                echo ''; 
                                            }
                                        }
                                        else if ($data2['auaction']== 'Partially Merge'){
                                            if($STIDDATA[1]!=$data['DTID2011'])
                                            { 
                                                echo $data['Towns']; 
                                            }
                                            else if(($STIDDATA[4]==$data['STID']) && ($STIDDATA[1]==$data['DTID']))
                                            {
                                                echo $data['Towns']; 
                                            }
                                            else if ($STIDDATA[1]==$data['DTID2011'] && $STIDDATA[1]==$data['DTID'])
                                            {
                                                echo $data['Towns']; 
                                            }
                                             else 
                                            { 
                                                echo '';   
                                            } 
                                        }
                                        else if ($data2['auaction']== 'Reshuffle')
                                        {
                                            if ((($data['STID']==$data2['STID']) && ($STIDDATA[1]==$data2['DTID']))){
                                                    
                                                
                                                echo $data['Towns']; 
                                            }
                                            else {
                                                echo ''; 
                                            }
                                        }
                                        else 
                                        {
                                            echo $data['Towns']; 
                                        }
                                            ?>
                                                
                                            </td>
                                        

                                    
                                        <td class="<?php if($fla){ ?>incompleted<?php  } ?>class2021">
                                        <?php if($data['fromids']!=null){ ?>
                                        <span class="badge badge-purple" data-todo='<?php echo json_encode($data); ?>'style="background-color:#fbca35;">Incomplete</span>
                                        <?php } ?>
                                        </td>


                                        

                                       <?php /* <td class="<?php if($fla){ ?>incompleted<?php  } ?>class2021 btnlink">
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown"
                                                    aria-expanded="true">
                                                    <i class="mdi mdi-dots-vertical"></i>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <li><a href="#"
                                                            <?php if($action == "" || in_array($data['STID'], $action) || in_array($data['DTID'], $action)) { ?>
                                                            data-toggle="modal" data-target="#con-close-modal"
                                                            class="dropdown-item btnEditnew"
                                                            data-id="<?php echo $data['SDID']; ?>"
                                                            data-todo='<?php echo json_encode($data); ?>'
                                                            <?php } else {  ?> class="dropdown-item noaction"
                                                            id="<?php echo $data['SDID']; ?>" <?php } ?>>Update</a>
                                                    </li>
                                                    <li><a <?php if($action == "" || in_array($data['STID'], $action) || in_array($data['DTID'], $action)) { ?>
                                                            href="javascript:void(0);"
                                                            data-target="#con-close-modal-link"
                                                            data-todo='<?php echo json_encode($data); ?>'
                                                            data-id="<?php echo $data['STID']; ?>"
                                                            class="dropdown-item btnlink" <?php } else {  ?>
                                                            class="dropdown-item noaction"
                                                            id="<?php echo $data['SDID']; ?>" <?php } ?>>Link
                                                            Document</a>
                                                    </li>

                                                    <li class="dropdown-divider"></li>
                                                    <li><a href="javascript:void(0);"
                                                            <?php if($action == "" || in_array($data['STID'], $action) || in_array($data['DTID'], $action)) { ?>
                                                            id="<?php echo $data['SDID']; ?>"
                                                            class="dropdown-item deletetablerow" <?php } else {  ?>
                                                            class="dropdown-item noaction"
                                                            id="<?php echo $data['SDID']; ?>" <?php } ?>>Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>*/?>
                                         <td><input type = "checkbox" id="myCheckbox" style = "cursor:pointer"></td>
                                    </tr>
                                    <?php } ?>
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

<?php // include ("rightsidebar.php"); ?>

<?php include ("footer.php"); ?>
<div id="con-close-modal-link" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">

    <div class="modal-dialog modal-full">
        <div class="modal-content">
            <form class="form-horizontal group-border-dashed parsley-examples" id="linkdata">
                <input type="hidden" name="datadtids" id="datadtids" value="">
                <input type="hidden" name="datasdids" id="datasdids" value="">
                <input type="hidden" name="dataids" id="dataids" value="">
                <input type="hidden" name="comefrom" id="comefrom" value="SD">
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
                <input type="hidden" name="linkedcomefrom" id="linkedcomefrom" value="SD">
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

            <form class="form-horizontal group-border-dashed parsley-examples" id="updatesubdistricts">
                <input type="hidden" name="update_ids" id="update_ids" value="">
                <!--  <input type="hidden" name="formname" id="formname" value="updatestatedata"> -->
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white">UPDATE SUB DISTRICTS</h5>

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

                                    <label class="col-md-4 col-form-label">2011</label>
                                    <label class="col-md-4 col-form-label">2021</label>


                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">State Name</label>
                                    <div class="col-md-9 pt-2">
                                        <select required id="STID2021" name="STID2021" disabled="disabled">
                                            <option value="">Select State Name</option>
                                            <?php foreach ($row as $key => $element) { ?>
                                            <option value="<?php echo $element['STID2021']; ?>">
                                                <?php echo $element['STName2021']; ?></option>
                                            <?php } ?>
                                        </select>

                                    </div>

                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Districts Name</label>
                                    <div class="col-md-9 pt-2">
                                        <select required id="DTID2021" required="required" disabled="disabled"
                                            name="DTID2021">
                                            <option value="">Select Districts Name</option>

                                        </select>

                                    </div>

                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Sub Districts Name</label>
                                    <div class="col-md-4">
                                        <input type="text" name="SDName2011" id="SDName2011" class="form-control"
                                            disabled="disabled" placeholder="" />
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" required class="form-control" name="SDName2021"
                                            id="SDName2021" placeholder="Sub Districts Name 2021" />
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Short code</label>

                                    <div class="col-md-4">
                                        <input type="text" class="form-control" id="Short_DT2011" name="Short_SD2011"
                                            disabled="disabled" placeholder="" />
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" onkeypress="return numbersOnly12(event)" class="form-control"
                                            id="Short_SD2021" name="Short_SD2021" placeholder="Short code" />
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label class="col-md-3 col-form-label">MDDS Code</label>

                                    <div class="col-md-4">
                                        <input type="text" class="form-control" disabled="disabled" placeholder=""
                                            id="MDDS_SD2011" name="MDDS_SD2011" />
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" onkeypress="return numbersOnly12(event)" id="MDDS_SD2021"
                                            name="MDDS_SD2021" class="form-control" placeholder="MDDS Code" />
                                    </div>
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

<div id="con-close-modal-add" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">

    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form class="form-horizontal group-border-dashed" data-parsley-validate novalidate
                data-parsley-trigger="keyup" id="addsubdistricts">
                <input type="hidden" name="formname" id="formname" value="addsubdistrictsdata">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white">ADD SUB DISTRICTS</h5>
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
                                    <label class="col-md-3 col-form-label">Districts Name</label>
                                    <div class="col-md-9 pt-2">
                                        <select required id="addDTID2021" name="addDTID2021"
                                            onchange="return get_subdist_select_data(this);">
                                            <option value="">Select Districts Name</option>
                                        </select>

                                    </div>

                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Sub Districts Name</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="addSDName2021" id="addSDName2021"
                                            required placeholder="Sub Districts Name" />
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Short code</label>

                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="addShort_SD2021"
                                            data-parsley-minlength="3" data-parsley-maxlength="10" id="addShort_SD2021"
                                            onkeypress="return numbersOnly12(event)" data-parsley-maxlength="7"
                                            placeholder="Short code" />
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label class="col-md-3 col-form-label">MDDS Code</label>

                                    <div class="col-md-9">
                                        <input type="text" class="form-control" data-parsley-minlength="5"
                                            data-parsley-maxlength="7" onkeypress="return numbersOnly12(event)"
                                            name="addMDDS_SD2021" id="addMDDS_SD2021" placeholder="MDDS Code" />
                                    </div>
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

//modified by sahana map checkbox
var checkboxes = document.querySelectorAll("input[id='myCheckbox']");
checkboxes.forEach(function(checkbox) {
    checkbox.addEventListener("click", function(event) {
        var row = checkbox.closest("tr");
        var stName = row.querySelector("td:nth-child(6)").textContent;

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