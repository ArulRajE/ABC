<?php error_reporting(0);  session_start(); include('include/db_conn.php'); include('include/function.php'); include('Classes/PHPExcel.php');
 if( !isset($_SESSION['login_id'] ))
{
    session_destroy();
    echo "<script language='javascript'>location.href='login';</script>";exit;
}
else
{
    if(time() - $_SESSION['login_time'] < 3600)
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
function cellsToMergeByColsRow($start = -1, $end = -1, $row = -1){
    $merge = 'A2:A3';
    if($start>=0 && $end>=0 && $row>=0){
        $start = PHPExcel_Cell::stringFromColumnIndex($start);
        $end = PHPExcel_Cell::stringFromColumnIndex($end);
        $merge = "$start{$row}:$end{$row}";
    }
    return $merge;
}



$yearl =$_SESSION['activeyears'];
// $years = substr($_SESSION['activeyears'], -2);

// $querydata = "DELETE FROM reclink".$yearl." a USING reclink".$yearl." b WHERE a.reclinkids < b.reclinkids AND a.\"VTID\" = b.\"VTID\" AND a.\"VTID2011\" = b.\"VTID2011\"";
// $final = pg_query($db,$querydata);


$objPHPExcel    =   new PHPExcel();

$styleArray = array(
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  ), 'font'  => array(
        'bold'  => true,
        'color' => array('rgb' => 'FFFFFF')
        
       
    )
);
$styleArraynew = array(
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);

$filename ='PCA_'.$yearl.'_'.date('d-m-Y').'.xlsx';

// $where="";
// if(isset($_GET['stids']) && $_GET['stids']!='')
// {
//   $where = "where recvt".$yearl.".\"STID\"=".$_GET['stids']."";

//   $filename =$_GET['stids'].'_PCA_'.$yearl.'_'.date('d-m-Y').'.xlsx';

// }
// if(isset($_GET['dtids']) && $_GET['dtids']!='')
// {
//   $where = "where recvt".$yearl.".\"STID\"=".$_GET['stids']." AND recvt".$yearl.".\"DTID\"=".$_GET['dtids']."";
// $filename =$_GET['dtids'].'_PCA_'.$yearl.'_'.date('d-m-Y').'.xlsx';
// }

// if(isset($_GET['sdids']) && $_GET['sdids']!='')
// {
//   $where = "where recvt".$yearl.".\"STID\"=".$_GET['stids']." AND recvt".$yearl.".\"DTID\"=".$_GET['dtids']." AND recvt".$yearl.".\"SDID\"=".$_GET['sdids']."";
// $filename =$_GET['sdids'].'_PCA_'.$yearl.'_'.date('d-m-Y').'.xlsx';
// }


 // $sql_query = "select * from recvt".$yearl." 
 //          LEFT JOIN ( SELECT recst".$yearl.".\"STID\" as \"STIDST\",
 //              recst".$yearl.".\"Short_ST\" as \"Short_ST_ST\",
 //              recst".$yearl.".\"STName\" as \"STName_ST\"
 //              FROM recst".$yearl."
 //              WHERE recst".$yearl.".is_deleted = 1) st 
 //              ON recvt".$yearl.".\"STID\" = st.\"STIDST\"
 //          LEFT JOIN ( SELECT recdt".$yearl.".\"DTID\" as \"DTIDDT\",
 //              recdt".$yearl.".\"Short_DT\" as \"Short_DT_DT\",
 //              recdt".$yearl.".\"DTName\" as \"DTName_DT\"
 //              FROM recdt".$yearl."
 //              WHERE recdt".$yearl.".is_deleted = 1) dt 
 //              ON recvt".$yearl.".\"DTID\" = dt.\"DTIDDT\"
 //          LEFT JOIN ( SELECT recsd".$yearl.".\"SDID\" as \"SDIDSD\",
 //              recsd".$yearl.".\"Short_SD\" as \"Short_SD_SD\" ,
 //              recsd".$yearl.".\"SDName\" as \"SDName_SD\"
 //              FROM recsd".$yearl."
 //              WHERE recsd".$yearl.".is_deleted = 1) sd 
 //              ON recvt".$yearl.".\"SDID\" = sd.\"SDIDSD\"
          
 //          LEFT JOIN ( 

 //          SELECT reclink".$yearl.".\"reclinkids\",reclink".$yearl.".\"VTID\" as \"VTIDLINK\"
 //              ,reclink".$yearl.".\"STID2011\",reclink".$yearl.".\"DTID2011\",reclink".$yearl.".\"SDID2011\",reclink".$yearl.".\"VTID2011\",reclink".$yearl.".\"MDDS2011\" as \"jigar\",reclink".$yearl.".\"Remarks\"
 //              ,reclink".$yearl.".\"OtherRemarks\",reclink".$yearl.".\"Area2011\",reclink".$yearl.".\"joinmessage\",st1.\"STName_ST2011NAME\",dt1.\"DTName_DT2011\",sd1.\"SDName_SD2011_name\",sd1.\"MDDS_SD_new2011\",dt1.\"MDDS_DT_new2011\"
 //              FROM reclink".$yearl." 

 //              LEFT JOIN ( SELECT recst2011.\"STID\" as \"STIDST2011\",
 //              recst2011.\"Short_ST\" as \"Short_ST_ST2011\",
 //              recst2011.\"STName\" as \"STName_ST2011NAME\"
 //              FROM recst2011
 //              WHERE recst2011.is_deleted = 1) st1 ON st1.\"STIDST2011\"=reclink".$yearl.".\"STID2011\" 

 //              LEFT JOIN (SELECT recdt2011.\"DTID\" as \"DTIDDT_2011\",
 //              recdt2011.\"Short_DT\" as \"Short_DT_DT2011\",
 //              recdt2011.\"DTName\" as \"DTName_DT2011\", recdt2011.\"MDDS_DT\" AS \"MDDS_DT_new2011\"
 //              FROM recdt2011
 //              WHERE recdt2011.is_deleted = 1) dt1 
 //              ON reclink".$yearl.".\"DTID2011\" = dt1.\"DTIDDT_2011\"
              
 //              LEFT JOIN ( SELECT recsd2011.\"SDID\" as \"SDIDSD2011\",
 //              recsd2011.\"Short_SD\" as \"Short_SD_SD2011\" , recsd2011.\"MDDS_SD\" as \"MDDS_SD_new2011\" ,
 //              recsd2011.\"SDName\" as \"SDName_SD2011_name\"
 //              FROM recsd2011
 //              WHERE recsd2011.is_deleted = 1) sd1 
 //              ON reclink".$yearl.".\"SDID2011\" = sd1.\"SDIDSD2011\"

 //              ) reclink 

 //              ON recvt".$yearl.".\"VTID\" = reclink.\"VTIDLINK\"
           
 //          LEFT JOIN ( SELECT recvt2011.\"VTName\" as \"VTName2011\",recvt2011.\"VTID\" as \"VTIDS\"
 //              FROM recvt2011 WHERE recvt2011.is_deleted = 1 ) vt11 
 //              ON reclink.\"VTID2011\" = vt11.\"VTIDS\" ".$where." 
 //              ORDER BY recvt".$yearl.".\"STID\",recvt".$yearl.".\"DTID\",recvt".$yearl.".\"SDID\",recvt".$yearl.".\"VTID\" 
 //          ";
   

// $result=pg_query($db,$sql_query) or die(mysql_error());

$objPHPExcel->setActiveSheetIndex(0);
 $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'OLD Census PCA '.$yearl.'');
 $objPHPExcel->getActiveSheet()->getStyle('A1:AE1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('fe6271');
 $objPHPExcel->getActiveSheet()
            ->getStyle("A1:AE1")
            ->getFont()
            ->setSize(20);
$objPHPExcel->getActiveSheet()->mergeCells('A1:U1');

 $objPHPExcel->getActiveSheet()->SetCellValue('V1', 'As Per Census 2011');

$objPHPExcel->getActiveSheet()->getStyle("A1:AE1")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->mergeCells('V1:AE1');

$objPHPExcel->getActiveSheet()->getStyle("A1:U1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle("V1:AE1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// $objPHPExcel->setActiveSheetIndex(1);
$objPHPExcel->getActiveSheet()->mergeCells("A2:A3");
$objPHPExcel->getActiveSheet()->mergeCells("B2:B3");
$objPHPExcel->getActiveSheet()->mergeCells("C2:C3");
$objPHPExcel->getActiveSheet()->mergeCells("D2:D3");
$objPHPExcel->getActiveSheet()->mergeCells("E2:E3");
$objPHPExcel->getActiveSheet()->mergeCells("F2:F3");
$objPHPExcel->getActiveSheet()->mergeCells("G2:G3");
$objPHPExcel->getActiveSheet()->mergeCells("H2:H3");
$objPHPExcel->getActiveSheet()->mergeCells("I2:I3");
$objPHPExcel->getActiveSheet()->mergeCells("J2:J3");
$objPHPExcel->getActiveSheet()->mergeCells("K2:K3");

$objPHPExcel->getActiveSheet()->mergeCells("V2:V3");
$objPHPExcel->getActiveSheet()->mergeCells("W2:W3");
$objPHPExcel->getActiveSheet()->mergeCells("X2:X3");
$objPHPExcel->getActiveSheet()->mergeCells("Y2:Y3");
$objPHPExcel->getActiveSheet()->mergeCells("Z2:Z3");
$objPHPExcel->getActiveSheet()->mergeCells("AA2:AA3");
$objPHPExcel->getActiveSheet()->mergeCells("AB2:AB3");
$objPHPExcel->getActiveSheet()->mergeCells("AC2:AC3");
$objPHPExcel->getActiveSheet()->mergeCells("AD2:AD3");
$objPHPExcel->getActiveSheet()->mergeCells("AE2:AE3");


$objPHPExcel->getActiveSheet()->mergeCells('L2:M2');
$objPHPExcel->getActiveSheet()->mergeCells('N2:O2');
$objPHPExcel->getActiveSheet()->mergeCells('P2:Q2');
$objPHPExcel->getActiveSheet()->mergeCells('R2:S2');
$objPHPExcel->getActiveSheet()->mergeCells('T2:U2');

// $objPHPExcel->getActiveSheet()->mergeCells("V2:V3");

$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'State Code');
$objPHPExcel->getActiveSheet()->SetCellValue('B2', 'State Name');
$objPHPExcel->getActiveSheet()->SetCellValue('C2', 'District Code');
$objPHPExcel->getActiveSheet()->SetCellValue('D2', 'District Name');
$objPHPExcel->getActiveSheet()->SetCellValue('E2', 'Sub District Code');
$objPHPExcel->getActiveSheet()->SetCellValue('F2', 'Sub District Name');
$objPHPExcel->getActiveSheet()->SetCellValue('G2', 'Village / Town Code');
$objPHPExcel->getActiveSheet()->SetCellValue('H2', 'Name of Village / Town');
$objPHPExcel->getActiveSheet()->SetCellValue('I2', 'Rural/Urban');
$objPHPExcel->getActiveSheet()->SetCellValue('J2', 'Status of Village / Town');
$objPHPExcel->getActiveSheet()->SetCellValue('K2', 'Geographical Area (in Hectares)');
$objPHPExcel->getActiveSheet()->SetCellValue('L2', 'Population');
$objPHPExcel->getActiveSheet()->SetCellValue('L3', 'Male');
$objPHPExcel->getActiveSheet()->SetCellValue('M3', 'Female');
$objPHPExcel->getActiveSheet()->SetCellValue('N2', '0-6 Years');
$objPHPExcel->getActiveSheet()->SetCellValue('N3', 'Male');
$objPHPExcel->getActiveSheet()->SetCellValue('O3', 'Female');
$objPHPExcel->getActiveSheet()->SetCellValue('P2', 'Literate Population');
$objPHPExcel->getActiveSheet()->SetCellValue('P3', 'Male');
$objPHPExcel->getActiveSheet()->SetCellValue('Q3', 'Female');
$objPHPExcel->getActiveSheet()->SetCellValue('R2', 'SC Population');
$objPHPExcel->getActiveSheet()->SetCellValue('R3', 'Male');
$objPHPExcel->getActiveSheet()->SetCellValue('S3', 'Female');
$objPHPExcel->getActiveSheet()->SetCellValue('T2', 'ST Population');
$objPHPExcel->getActiveSheet()->SetCellValue('T3', 'Male');
$objPHPExcel->getActiveSheet()->SetCellValue('U3', 'Female');

$objPHPExcel->getActiveSheet()->SetCellValue('V2', 'State MDDS');
$objPHPExcel->getActiveSheet()->SetCellValue('W2', 'State Name');
$objPHPExcel->getActiveSheet()->SetCellValue('X2', 'District MDDS');
$objPHPExcel->getActiveSheet()->SetCellValue('Y2', 'District Name');
$objPHPExcel->getActiveSheet()->SetCellValue('Z2', 'Sub District MDDS');
$objPHPExcel->getActiveSheet()->SetCellValue('AA2', 'Sub District Name');
$objPHPExcel->getActiveSheet()->SetCellValue('AB2', 'Village / Town MDDS');
$objPHPExcel->getActiveSheet()->SetCellValue('AC2', 'Name of Village / Town');

$objPHPExcel->getActiveSheet()->SetCellValue('AD2', 'Geographical Area (in Hectares)');
$objPHPExcel->getActiveSheet()->SetCellValue('AE2', 'Remarks');




$objPHPExcel->getActiveSheet()->SetCellValue('A4', '1');
$objPHPExcel->getActiveSheet()->SetCellValue('B4', '2');
$objPHPExcel->getActiveSheet()->SetCellValue('C4', '3');
$objPHPExcel->getActiveSheet()->SetCellValue('D4', '4');
$objPHPExcel->getActiveSheet()->SetCellValue('E4', '5');
$objPHPExcel->getActiveSheet()->SetCellValue('F4', '6');
$objPHPExcel->getActiveSheet()->SetCellValue('G4', '7');
$objPHPExcel->getActiveSheet()->SetCellValue('H4', '8');
$objPHPExcel->getActiveSheet()->SetCellValue('I4', '9');
$objPHPExcel->getActiveSheet()->SetCellValue('J4', '10');
$objPHPExcel->getActiveSheet()->SetCellValue('K4', '11');
$objPHPExcel->getActiveSheet()->SetCellValue('L4', '12');
$objPHPExcel->getActiveSheet()->SetCellValue('M4', '13');
$objPHPExcel->getActiveSheet()->SetCellValue('N4', '14');
$objPHPExcel->getActiveSheet()->SetCellValue('O4', '15');
$objPHPExcel->getActiveSheet()->SetCellValue('P4', '16');
$objPHPExcel->getActiveSheet()->SetCellValue('Q4', '17');
$objPHPExcel->getActiveSheet()->SetCellValue('R4', '18');
$objPHPExcel->getActiveSheet()->SetCellValue('S4', '19');
$objPHPExcel->getActiveSheet()->SetCellValue('T4', '20');
$objPHPExcel->getActiveSheet()->SetCellValue('U4', '21');
$objPHPExcel->getActiveSheet()->SetCellValue('V4', '22');
$objPHPExcel->getActiveSheet()->SetCellValue('W4', '23');
$objPHPExcel->getActiveSheet()->SetCellValue('X4', '24');
$objPHPExcel->getActiveSheet()->SetCellValue('Y4', '25');
$objPHPExcel->getActiveSheet()->SetCellValue('Z4', '26');
$objPHPExcel->getActiveSheet()->SetCellValue('AA4', '27');
$objPHPExcel->getActiveSheet()->SetCellValue('AB4', '28');
$objPHPExcel->getActiveSheet()->SetCellValue('AC4', '29');
$objPHPExcel->getActiveSheet()->SetCellValue('AD4', '30');
$objPHPExcel->getActiveSheet()->SetCellValue('AE4', '31');


// 


// $objPHPExcel->getActiveSheet()->getStyle("A2:V2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A2:AE2')
->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);
$objPHPExcel->getActiveSheet()
            ->getStyle("A3:AE3")
            ->getFont()
            ->setSize(11)->setBold(true);
// $objPHPExcel->getActiveSheet()->getStyle("A3:V3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A2:AE2')
->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);

    $objPHPExcel->getActiveSheet()->getStyle('A4:AE4')
->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);

$objPHPExcel->getActiveSheet()
                ->getStyle('A2:AE2')
                ->applyFromArray($styleArray);
                $objPHPExcel->getActiveSheet()
                ->getStyle('A4:AE4')
                ->applyFromArray($styleArray);
                $objPHPExcel->getActiveSheet()->getStyle("A4:AE4")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()
                ->getStyle('A3:AE3')
                ->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()
                ->getStyle('A1:AE1')
                ->applyFromArray($styleArray);

            $objPHPExcel->getActiveSheet()->getStyle("A2:AE2")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('15bed2');
            $objPHPExcel->getActiveSheet()->getStyle("A3:AE3")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('15bed2');
             $objPHPExcel->getActiveSheet()->getStyle('A4:AE4')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('fe6271');


   foreach(range('A','AE') as $columnID) {
   
  //   $objPHPExcel->getActiveSheet()->SetCellValue($columnID.'4',$i );

    
   
    if($columnID=="AE")
      {
         $objPHPExcel->getActiveSheet()->getColumnDimension('AE')->setWidth(25);
      }
      else
      {
    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
        ->setAutoSize(true);    
       }
       
    
}

 




$rowCount   =   5;
$array = array();

// $row1=pg_fetch_all($result);

// $chunks = array_chunk($array, 1000);

// foreach($row1 as $key => $row)
while($row = pg_fetch_assoc($result))
{

// echo "<pre>";
// print_r($row);

// $TOT_M = "";
// $TOT_F = "";
// $M_06 = "";
// $F_06 = "";
// $M_LIT = "";
// $F_LIT = "";
// $M_SC = "";
// $F_SC = "";
// $M_ST = "";
// $F_ST = "";



// if(count($array)==0)
// {
//  //  $array[]=$row['Short_ST_ST']."".$row['Short_DT_DT']."".$row['Short_SD_SD']."".$row['locationcode_VT']."".$row['MDDS2011'];
//  $array[]=$row['Short_ST_ST']."".$row['Short_DT_DT']."".$row['Short_SD_SD']."".$row['locationcode_VT']."".$row['VTName'];

// $TOT_M = $row['TOT_M'];
// $TOT_F = $row['TOT_F'];
// $M_06 = $row['M_06'];
// $F_06 = $row['F_06'];
// $M_LIT = $row['M_LIT'];
// $F_LIT = $row['F_LIT'];
// $M_SC = $row['M_SC'];
// $F_SC = $row['F_SC'];
// $M_ST = $row['M_ST'];
// $F_ST = $row['F_ST'];

// }
// else
// {
//  //  if(in_array($row['Short_ST_ST']."".$row['Short_DT_DT']."".$row['Short_SD_SD']."".$row['locationcode_VT']."".$row['MDDS2011'], $array))
//   if(in_array($row['Short_ST_ST']."".$row['Short_DT_DT']."".$row['Short_SD_SD']."".$row['locationcode_VT']."".$row['VTName'], $array))
//   {
//     $TOT_M = "";
// $TOT_F = "";
// $M_06 = "";
// $F_06 = "";
// $M_LIT = "";
// $F_LIT = "";
// $M_SC = "";
// $F_SC = "";
// $M_ST = "";
// $F_ST = "";
//   }
//   else
//   {

// $TOT_M = $row['TOT_M'];
// $TOT_F = $row['TOT_F'];
// $M_06 = $row['M_06'];
// $F_06 = $row['F_06'];
// $M_LIT = $row['M_LIT'];
// $F_LIT = $row['F_LIT'];
// $M_SC = $row['M_SC'];
// $F_SC = $row['F_SC'];
// $M_ST = $row['M_ST'];
// $F_ST = $row['F_ST'];
// // $array[]=$row['Short_ST_ST']."".$row['Short_DT_DT']."".$row['Short_SD_SD']."".$row['locationcode_VT']."".$row['MDDS2011'];
// $array[]=$row['Short_ST_ST']."".$row['Short_DT_DT']."".$row['Short_SD_SD']."".$row['locationcode_VT']."".$row['VTName'];  
// }

// }


//  $rem = "";
// if($row['OtherRemarks']!="" && $row['joinmessage']!="")
// {
//   $rem = $row['Remarks']." ; ".$row['joinmessage']." ; ".$row['OtherRemarks'];
// }
// else if($row['OtherRemarks']=="" && $row['joinmessage']!="")
// {
//   $rem = $row['Remarks']." ; ".$row['joinmessage'];
// }
// else if($row['OtherRemarks']!="" && $row['joinmessage']=="")
// {
//   $rem = $row['Remarks']." ; ".$row['OtherRemarks'];
// }
// else
// {
//   $rem = $row['Remarks'];
// }

 //   $objPHPExcel->getActiveSheet()->getRowDimension($rowCount)->setRowHeight(18);
  $objPHPExcel->getActiveSheet()
                ->getStyle('A'.$rowCount.':AE'.$rowCount.'')
                ->applyFromArray($styleArraynew);


    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'aaaaa','UTF-8');
    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'aaaaa','UTF-8');
    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'aaaaa','UTF-8');
    $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, 'aaaaa','UTF-8');
    $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, 'aaaaa','UTF-8');
    $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, 'aaaaa','UTF-8');
    $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, 'aaaaa','UTF-8');
    $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount,'aaaaa','UTF-8');
    $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, 'aaaaa','UTF-8');
    $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, 'aaaaa','UTF-8');
    $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, 'aaaaa','UTF-8');

    $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, 'aaaaa','UTF-8');
    $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, 'aaaaa','UTF-8');
    $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, 'aaaaa','UTF-8');
    $objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, 'aaaaa','UTF-8');
    $objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, 'aaaaa','UTF-8');
    $objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, 'aaaaa','UTF-8');
    $objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount, 'aaaaa','UTF-8');
    $objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount, 'aaaaa','UTF-8');
    $objPHPExcel->getActiveSheet()->SetCellValue('T'.$rowCount, 'aaaaa','UTF-8');
    $objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowCount, 'aaaaa','UTF-8');

          $objPHPExcel->getActiveSheet()->SetCellValue('V'.$rowCount, 'aaaaa','UTF-8');
          $objPHPExcel->getActiveSheet()->SetCellValue('W'.$rowCount, 'aaaaa','UTF-8');
          $objPHPExcel->getActiveSheet()->SetCellValue('X'.$rowCount, 'aaaaa','UTF-8');
          $objPHPExcel->getActiveSheet()->SetCellValue('Y'.$rowCount, 'aaaaa','UTF-8');
          $objPHPExcel->getActiveSheet()->SetCellValue('Z'.$rowCount, 'aaaaa','UTF-8');
          $objPHPExcel->getActiveSheet()->SetCellValue('AA'.$rowCount, 'aaaaa','UTF-8');
          $objPHPExcel->getActiveSheet()->SetCellValue('AB'.$rowCount, 'aaaaa','UTF-8');
          $objPHPExcel->getActiveSheet()->SetCellValue('AC'.$rowCount, 'aaaaa','UTF-8');
          $objPHPExcel->getActiveSheet()->SetCellValue('AD'.$rowCount, 'aaaaa','UTF-8');
          $objPHPExcel->getActiveSheet()->SetCellValue('AE'.$rowCount, 'aaaaa','UTF-8');
         
          
        

    $rowCount++;
}

  
$objWriter  =   new PHPExcel_Writer_Excel2007($objPHPExcel);


header('Content-Type: application/vnd.ms-excel'); //mime type
header("Content-Type:application/octet-stream");
header('Content-Disposition: attachment;filename='.$filename.''); //tell browser what's the file name
header('Cache-Control: max-age=0'); //no cache
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');  
$objWriter->save('php://output');

?>
