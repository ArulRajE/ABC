<?php
session_start(); 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING | E_DEPRECATED));
 include('include/db_conn.php');
 include('include/function.php');
 $sq="select user_token from $admin_table where id=$1";
$sql1=pg_query_params($db,$sq,array($_SESSION['login_id']));
$valid_tokan = pg_numrows($sql1);
$rowtoken = pg_fetch_all($sql1);

if($valid_tokan>0 && $rowtoken[0]['user_token']!=$_SESSION['user_token']) 
{
    echo "<script language='javascript'>alert('This user already logged in another device')</script>";
session_destroy();
echo "<script language='javascript'>location.href='login';</script>";exit;
}      
       
if($_POST['formname']=='login_data')  
{
	       
if($_POST['captcha_code']==$_SESSION['captcha_code'])
{

	$_POST['admin_name']=$_POST['email'];
	$_POST['admin_password']=$_POST['password'];
	$_POST['masterpassword']=$_POST['password'];

 	$checkval = array($_POST['admin_name'],md5($_POST['admin_password']));	
  //  	$valid = CheckAvailability("".$admin_table."",$checkval,$db);

$result = pg_query_params($db,"SELECT * FROM $admin_table WHERE admin_name = $1 AND admin_password=$2" , $checkval);
$valid = pg_numrows($result);

	if($valid>0) 
	{
		
		// $row = getTblData("".$admin_table."",$checkval,$db,"","");
		$row = pg_fetch_all($result);

		if($row[0]['status']==1) 
		{
			$tokendata = getToken(10);

			$_SESSION['login_id'] = $row[0]['id'];
			$_SESSION['login_type'] = $row[0]['admin_type'];
			$_SESSION['login_email'] = $row[0]['admin_name'];
			$_SESSION['user_token'] = $tokendata;
			$_SESSION['login_time'] = time();
			$_SESSION['activeyears'] = '2021';
			$_POST['jcyname']='2021';
			$_SESSION['activeyears'] = $_POST['jcyname'];

			 $checkvalt = array($tokendata,$row[0]['id']);	
			 $queupdate = 'update '.$admin_table.' set "user_token"=$1 where "id"=$2';		
			 pg_query_params($db,$queupdate,$checkvalt);
			// if(!empty($_POST["checkbox-signup"]) || isset($_POST["checkbox-signup"])) {
			// 		setcookie ("member_login",$_POST["email"],time()+ (10 * 365 * 24 * 60 * 60));
			// 		setcookie ("member_login_pass",$_POST['password'],time()+ (10 * 365 * 24 * 60 * 60));
			// 	} else {
			// 		if(isset($_COOKIE["member_login"])) {
			// 			setcookie ("member_login","");
			// 			setcookie ("member_login_pass","");
			// 		}
			// 	}

			// For setting cookie secure flag on : while adding in the server level include "jurisdiction.census.gov.in otherwise "localhost" coded by Veena

				// if (!empty($_POST["checkbox-signup"]) || isset($_POST["checkbox-signup"])) {
				// 	setcookie("member_login", $_POST["email"], time() + (10 * 365 * 24 * 60 * 60), "/", "jurisdiction.census.gov.in", true, true);
				// 	setcookie("member_login_pass", $_POST['password'], time() + (10 * 365 * 24 * 60 * 60), "/", "jurisdiction.census.gov.in", true, true);
				//   } else {
				// 	if (isset($_COOKIE["member_login"])) {
				// 	  setcookie("member_login", "", time() - 3600, "/", "jurisdiction.census.gov.in", true, true);
				// 	  setcookie("member_login_pass", "", time() - 3600, "/", "jurisdiction.census.gov.in", true, true);
				// 	}
				//   }
				

				// Enable secure flag for all cookies
				ini_set('session.cookie_secure', '1');
				
				// Set secure flag for existing cookies
				foreach ($_COOKIE as $name => $value) {
					setcookie($name, $value, [
						'expires' => time() + 3600, // Adjust the expiration time as needed
						'secure' => true,
						'httponly' => true,
						'samesite' => 'Strict'
					]);
				}
				
				  
				 
			$task="login";
				 
		}
		else
		{
			$task="notactivated";
		}		
	}
	else
	{
		

		$checkval = array($_POST['admin_name'],md5($_POST['admin_password']));	
  //  	$valid = CheckAvailability("".$admin_table."",$checkval,$db);

$result = pg_query_params($db,"SELECT * FROM $admin_table WHERE admin_name = $1 OR admin_password=$2" , $checkval);
$valid = pg_numrows($result);


		
		if($valid>0){
		// $row1 = getTblData("".$admin_table."",$checkval1,$db,"","");
			$row1 = pg_fetch_all($result);
			$array = array();
				if($row1[0]['failcount']<=3)
				{
				$j=$row1[0]['failcount']+1;
				if($j==3)
				{
					$array = array($j,0,$row1[0]['id']);
					// $que = "update ".$admin_table." set \"failcount\"=".$j.",\"status\"=0 where \"id\"=".$row1[0]['id']."";		
				$que = 'update '.$admin_table.' set "failcount"=$1,"status"=$2 where "id"=$3';		
				}
				else
				{
					$array = array($j,$row1[0]['id']);
					// $que = "update ".$admin_table." set \"failcount\"=".$j." where \"id\"=".$row1[0]['id']."";	
				$que = 'update '.$admin_table.' set "failcount"=$1 where "id"=$2';	
				}
				
				pg_query_params($db,$que,$array);
				}
				
			$task="loginfail";
		}
		else{
			$task='notregistered';
		}

	
	}

}
else
{
$task="inccodedata";
}


	echo $task;
}


else if($_POST['formname']=='getreportPCA_DATA')
{

// SWAMII

// forread issue solved by shashi and the code is start //
$primaryKey = 'frids';

if($_POST['flag']=='ST')
{

	$cond='';
	$cond1='';
	$cond2=''; //forread by sahana
	$cond3=''; //forread by sahana
	$cond4=''; //forread by sahana
	$acyear=$_SESSION['activeyears'];
	$acyearshort = substr($acyear, -2);
	$olyear=$_SESSION['logindetails']['baseyear'];
		$array = array("stids"=>$_POST['stids'],"dtids"=>$_POST['dtids'],"sdids"=>$_POST['sdids']);
	// print_r($array);
	
	if($_SESSION['logindetails']['assignlist']!='')
	{
		if($_POST['stids']!='' &&  $_POST['dtids']=='' &&  $_POST['sdids']=='')
		{
				$cond = ' AND ( "fr21"."STID"='.$_SESSION['logindetails']['assignlist'].' OR "fr21"."STIDACTIVE"='.$_SESSION['logindetails']['assignlist'].' )';
				$cond1 = ' WHERE "STID"='.$_SESSION['logindetails']['assignlist'].'';

				//by sahana forread state issue
				$stidActive = $_POST['stids'];
				$querystate = pg_prepare($db, "my_query", 'SELECT "frfromaction","frcomefrom","STID" FROM forreaddata2021 WHERE "STIDACTIVE" = $1');
				$resultstate = pg_execute($db, "my_query", array($stidActive));
				$rowstate = pg_fetch_assoc($resultstate);
				if ($rowstate) 
				{
					$cond2 = ' WHERE "STID"=' . $rowstate['STID'];
					$cond3=$cond2;
				}
				else {
					$cond1 = ' WHERE "STID"='.$_POST['stids'].'';
					$cond3=$cond1;
				}

		}
		// else if($_POST['stids']!='' &&  $_POST['dtids']!='' &&  $_POST['sdids']=='' )
		// {
			

		// 	$cond = ' AND ( "fr21"."STID"='.$_SESSION['logindetails']['assignlist'].' OR "fr21"."STIDACTIVE"='.$_SESSION['logindetails']['assignlist'].' ) AND ("fr21"."DTID"='.$_POST['dtids'].' OR "fr21"."DTIDACTIVE"='.$_POST['dtids'].')';
		// 		$cond1 = ' WHERE "STID"='.$_POST['stids'].'';
		// }
		// else if($_POST['stids']!='' &&  $_POST['dtids']!='' &&  $_POST['sdids']!='' )
		// {

		// 	$cond = ' AND ( "fr21"."STID"='.$_SESSION['logindetails']['assignlist'].' OR "fr21"."STIDACTIVE"='.$_SESSION['logindetails']['assignlist'].' ) AND ("fr21"."DTID"='.$_POST['dtids'].' OR "fr21"."DTIDACTIVE"='.$_POST['dtids'].') AND ("fr21"."SDID"='.$_POST['sdids'].' OR "fr21"."SDIDACTIVE"='.$_POST['sdids'].')';
		// 		$cond1 = ' WHERE "STID"='.$_POST['stids'].'';

		// 	// $cond = ' AND "fr21"."STID"='.$_POST['stids'].' AND "fr21"."DTID"='.$_POST['dtids'].' AND "fr21"."SDID"='.$_POST['sdids'].'';
		// }


			// $cond = ' AND "fr21"."STID"='.$_SESSION['logindetails']['assignlist'].'';
			// $cond1 = ' WHERE "STID"='.$_SESSION['logindetails']['assignlist'].'';
			
	}
	else
	{
		if($_POST['stids']!='' &&  $_POST['dtids']=='' &&  $_POST['sdids']=='')
		{
			$cond = ' AND ( "fr21"."STID"='.$_POST['stids'].' OR "fr21"."STIDACTIVE"='.$_POST['stids'].' )';
			$cond1 = ' WHERE "STID"='.$_POST['stids'].'';

			//by sahana forread state issue
			$stidActive = $_POST['stids'];
			$stid = $_POST['stids'];
			$querystate = pg_prepare($db, "my_query", 'SELECT "frfromaction","frcomefrom","STID" FROM forreaddata2021 WHERE "STIDACTIVE" = $1');
			$querystatepm = pg_prepare($db, "my_query_statepm", 'SELECT "frfromaction","frcomefrom","STIDACTIVE" FROM forreaddata2021 WHERE "STID" = $1');
			$resultstate = pg_execute($db, "my_query", array($stidActive));
			$resultstatepm = pg_execute($db, "my_query_statepm", array($stid));
			$rowstate = pg_fetch_assoc($resultstate);
			$rowstatepm = pg_fetch_assoc($resultstatepm);
			if ($rowstate) 
			{
				$cond2 = ' WHERE "STID"=' . $rowstate['STID'];
				$cond4 = ' WHERE "STID"=' . $rowstate['STID'].' OR "STID"=' . $_POST['stids'];
				$cond3=$cond2;
			}
			else {
				$cond1 = ' WHERE "STID"='.$_POST['stids'].'';
				$cond3=$cond1;
			}

		}
		else if($_POST['stids']!='' &&  $_POST['dtids']!='' &&  $_POST['sdids']=='' )
		{
			$cond = ' AND ( "fr21"."STID"='.$_POST['stids'].' OR "fr21"."STIDACTIVE"='.$_POST['stids'].' ) AND ("fr21"."DTID"='.$_POST['dtids'].' OR "fr21"."DTIDACTIVE"='.$_POST['dtids'].')';
				$cond1 = ' WHERE "STID"='.$_POST['stids'].'';
		}
		else if($_POST['stids']!='' &&  $_POST['dtids']!='' &&  $_POST['sdids']!='' )
		{
		$cond = ' AND ( "fr21"."STID"='.$_POST['stids'].' OR "fr21"."STIDACTIVE"='.$_POST['stids'].' ) AND ("fr21"."DTID"='.$_POST['dtids'].' OR "fr21"."DTIDACTIVE"='.$_POST['dtids'].') AND ("fr21"."SDID"='.$_POST['sdids'].' OR "fr21"."SDIDACTIVE"='.$_POST['sdids'].')';
			$cond1 = ' WHERE "STID"='.$_POST['stids'].'';
		}

	}
//modified by sahana given if and else condition for forread state split issue 
	if($rowstate['frcomefrom']=='State' && $rowstate['frfromaction']=='Split'){
		if($_POST['stids']==$rowstate['STID'])
		{
			$table = <<<EOT
			(
				SELECT * FROM (
					SELECT "VTIDACTIVE","frids","STID$olyear","STName$olyear","STStatus$olyear","MDDS_ST$olyear","DTID$olyear","DTName$olyear","MDDS_DT$olyear","SDID$olyear","SDName$olyear","MDDS_SD$olyear",
					"VTID$olyear","VTName$olyear","MDDS_VT$olyear","Level$olyear","Status$olyear","frcomment","comeaction","STID$acyearshort"
						
					,CASE
					WHEN "frfromaction"='Sub-Merge'  THEN ''
					ELSE "STName$acyearshort"
						END AS "STName$acyearshort"
	
					,CASE WHEN "frfromaction"='Sub-Merge' THEN ''
					ELSE "STStatus$acyearshort"  
					END AS  "STStatus$acyearshort"
			
						,CASE
					WHEN "frfromaction"='Sub-Merge'  THEN ''
					ELSE "MDDS_ST$acyearshort"
						END AS "MDDS_ST$acyearshort"
			
					,"DTID$acyearshort"
					
					,CASE
					WHEN "frfromaction"='Sub-Merge'  THEN ''
					ELSE "DTName$acyearshort"
						END AS "DTName$acyearshort"
			
						,CASE
					WHEN "frfromaction"='Sub-Merge'  THEN ''
					ELSE "MDDS_DT$acyearshort"
						END AS "MDDS_DT$acyearshort"
						
					,"SDID$acyearshort"
					
					,CASE
					WHEN "frfromaction"='Sub-Merge'  THEN ''
					ELSE "SDName$acyearshort"
						END AS "SDName$acyearshort"
			
						,CASE
					WHEN "frfromaction"='Sub-Merge'  THEN ''
					ELSE "MDDS_SD$acyearshort"
						END AS "MDDS_SD$acyearshort"
						
						,"VTID$acyearshort"
			
						,CASE
					WHEN "frfromaction"='Sub-Merge'  THEN ''
					ELSE "VTName$acyearshort"
						END AS "VTName$acyearshort"
			
						,CASE
						WHEN vt$acyear."is_deleted"=0  THEN ''
					ELSE "MDDS_VT$acyearshort"
					END AS "MDDS_VT$acyearshort"
					,CASE
					WHEN "frfromaction"='Sub-Merge'  THEN ''
					ELSE "Level$acyearshort"
					END AS "Level$acyearshort"
					,CASE
					WHEN "frfromaction"='Sub-Merge'  THEN ''
					ELSE "Status$acyearshort"
					END AS "Status$acyearshort","is_deleted"
			
					FROM (
						SELECT DISTINCT ON( fr$acyearshort."VTIDACTIVE") fr$acyearshort."VTIDACTIVE",fr$acyearshort."VTIDR",fr$acyearshort.frids,
						fr$acyearshort.frcomment,fr$acyearshort.comeaction,fr$acyearshort.frfromaction
			
						FROM forreaddata20$acyearshort AS fr$acyearshort
			
						WHERE fr$acyearshort."VTIDACTIVE"=0 AND fr$acyearshort."VTIDACTIVE"=fr$acyearshort."VTIDR"  $cond AND fr$acyearshort."VTIDACTIVE"=fr$acyearshort."VTID"   ORDER BY "VTIDACTIVE", "frids" DESC
					) AS frtab
					INNER JOIN (
						SELECT "STID$acyearshort","STName$acyearshort","STStatus$acyearshort","MDDS_ST$acyearshort","DTID$acyearshort","DTName$acyearshort","MDDS_DT$acyearshort","SDID$acyearshort","SDName$acyearshort","MDDS_SD$acyearshort"
							,"VTID" AS "VTID$acyearshort","VTName" AS "VTName$acyearshort","MDDS_VT" AS "MDDS_VT$acyearshort","Level" AS "Level$acyearshort","Status" AS "Status$acyearshort","is_deleted" FROM vt$acyear 
							INNER JOIN (
								SELECT "STID" AS "STID$acyearshort","STName" AS "STName$acyearshort","Status" AS "STStatus$acyearshort","MDDS_ST" AS "MDDS_ST$acyearshort" FROM st$acyear WHERE is_deleted=1
							) AS st$acyearshort ON st$acyearshort."STID$acyearshort"=vt$acyear."STID"
							INNER JOIN (
								SELECT "DTID" AS "DTID$acyearshort","DTName" AS "DTName$acyearshort","MDDS_DT" AS "MDDS_DT$acyearshort" FROM dt$acyear WHERE is_deleted=1
							) AS dt$acyearshort ON dt$acyearshort."DTID$acyearshort"=vt$acyear."DTID"
							INNER JOIN (
								SELECT "SDID" AS "SDID$acyearshort","SDName" AS "SDName$acyearshort","MDDS_SD" AS "MDDS_SD$acyearshort" FROM sd$acyear WHERE is_deleted=1
							) AS sd$acyearshort ON sd$acyearshort."SDID$acyearshort"=vt$acyear."SDID"
							$cond1
					) AS vt$acyear ON frtab."VTIDACTIVE" = vt$acyear."VTID$acyearshort" 
			
					LEFT JOIN (
						SELECT "STID$olyear","STName$olyear","STStatus$olyear","MDDS_ST$olyear","DTID$olyear","DTName$olyear","MDDS_DT$olyear","SDID$olyear","SDName$olyear","MDDS_SD$olyear"
							,"VTID" AS "VTID$olyear","VTName" AS "VTName$olyear","MDDS_VT" AS "MDDS_VT$olyear","Level" AS "Level$olyear","Status" AS "Status$olyear" FROM vt$olyear 
							INNER JOIN (
								SELECT "STID" AS "STID$olyear","STName" AS "STName$olyear","Status" AS "STStatus$olyear","MDDS_ST" AS "MDDS_ST$olyear" FROM st$olyear
							) AS st11 ON st11."STID$olyear"=vt$olyear."STID"
							INNER JOIN (
								SELECT "DTID" AS "DTID$olyear","DTName" AS "DTName$olyear","MDDS_DT" AS "MDDS_DT$olyear" FROM dt$olyear
							) AS dt11 ON dt11."DTID$olyear"=vt$olyear."DTID"
							INNER JOIN (
								SELECT "SDID" AS "SDID$olyear","SDName" AS "SDName$olyear","MDDS_SD" AS "MDDS_SD$olyear" FROM sd$olyear
							) AS sd11 ON sd11."SDID$olyear"=vt$olyear."SDID"
							$cond3
					) AS vt$olyear ON frtab."VTIDR" = vt$olyear."VTID$olyear"
				) AS TAB1
			
				UNION ALL
			
				SELECT * FROM (
					SELECT DISTINCT ( fr$acyearshort."VTIDACTIVE"),fr$acyearshort."frids",vt$olyear.*,fr$acyearshort.frcomment,fr$acyearshort.comeaction,vt$acyear.* FROM forreaddata$acyear AS fr$acyearshort
					LEFT JOIN (
						SELECT "STID$olyear","STName$olyear","STStatus$olyear","MDDS_ST$olyear","DTID$olyear","DTName$olyear","MDDS_DT$olyear","SDID$olyear","SDName$olyear","MDDS_SD$olyear"
							,"VTID" AS "VTID$olyear","VTName" AS "VTName$olyear","MDDS_VT" AS "MDDS_VT$olyear","Level" AS "Level$olyear","Status" AS "Status$olyear" FROM vt$olyear 
							INNER JOIN (
								SELECT "STID" AS "STID$olyear","STName" AS "STName$olyear","Status" AS "STStatus$olyear","MDDS_ST" AS "MDDS_ST$olyear" FROM st$olyear
							) AS st11 ON st11."STID$olyear"=vt$olyear."STID"
							INNER JOIN (
								SELECT "DTID" AS "DTID$olyear","DTName" AS "DTName$olyear","MDDS_DT" AS "MDDS_DT$olyear" FROM dt$olyear
							) AS dt11 ON dt11."DTID$olyear"=vt$olyear."DTID"
							INNER JOIN (
								SELECT "SDID" AS "SDID$olyear","SDName" AS "SDName$olyear","MDDS_SD" AS "MDDS_SD$olyear" FROM sd$olyear
							) AS sd11 ON sd11."SDID$olyear"=vt$olyear."SDID"
							$cond1
					) AS vt$olyear ON fr$acyearshort."VTIDR" = vt$olyear."VTID$olyear"
			
					LEFT JOIN (
						SELECT "STID$acyearshort","STName$acyearshort","STStatus$acyearshort","MDDS_ST$acyearshort","DTID$acyearshort","DTName$acyearshort","MDDS_DT$acyearshort","SDID$acyearshort","SDName$acyearshort","MDDS_SD$acyearshort"
							,"VTID" AS "VTID$acyearshort","VTName" AS "VTName$acyearshort","MDDS_VT" AS "MDDS_VT$acyearshort","Level" AS "Level$acyearshort","Status" AS "Status$acyearshort","is_deleted" FROM vt$acyear 
							INNER JOIN (
								SELECT "STID" AS "STID$acyearshort","STName" AS "STName$acyearshort","Status" AS "STStatus$acyearshort","MDDS_ST" AS "MDDS_ST$acyearshort" FROM st$acyear
							) AS st$acyearshort ON st$acyearshort."STID$acyearshort"=vt$acyear."STID"
							INNER JOIN (
								SELECT "DTID" AS "DTID$acyearshort","DTName" AS "DTName$acyearshort","MDDS_DT" AS "MDDS_DT$acyearshort" FROM dt$acyear
							) AS dt$acyearshort ON dt$acyearshort."DTID$acyearshort"=vt$acyear."DTID"
							INNER JOIN (
								SELECT "SDID" AS "SDID$acyearshort","SDName" AS "SDName$acyearshort","MDDS_SD" AS "MDDS_SD$acyearshort" FROM sd$acyear
							) AS sd$acyearshort ON sd$acyearshort."SDID$acyearshort"=vt$acyear."SDID"
					) AS vt$acyear ON fr$acyearshort."VTIDACTIVE" = vt$acyear."VTID$acyearshort"
					WHERE fr$acyearshort."VTIDACTIVE"!=0   $cond AND fr$acyearshort."VTIDACTIVE"=fr$acyearshort."VTID"  ORDER BY "VTIDACTIVE", "frids" DESC
				) AS TAB2
			) temp
			EOT;
		}
		else if($_POST['stids']!=$rowstate['STID']) {
			$table = <<<EOT
			(
				SELECT * FROM (
					SELECT "VTIDACTIVE","frids","STID$olyear","STName$olyear","STStatus$olyear","MDDS_ST$olyear","DTID$olyear","DTName$olyear","MDDS_DT$olyear","SDID$olyear","SDName$olyear","MDDS_SD$olyear",
					"VTID$olyear","VTName$olyear","MDDS_VT$olyear","Level$olyear","Status$olyear","frcomment","comeaction","STID$acyearshort"
						
					,CASE
					WHEN "frfromaction"='Sub-Merge'  THEN ''
					ELSE "STName$acyearshort"
						END AS "STName$acyearshort"
			
					,CASE WHEN "frfromaction"='Sub-Merge' THEN ''
					ELSE "STStatus$acyearshort"  
					END AS  "STStatus$acyearshort"
	
						,CASE
					WHEN "frfromaction"='Sub-Merge'  THEN ''
					ELSE "MDDS_ST$acyearshort"
						END AS "MDDS_ST$acyearshort"
			
					,"DTID$acyearshort"
					
					,CASE
					WHEN "frfromaction"='Sub-Merge'  THEN ''
					ELSE "DTName$acyearshort"
						END AS "DTName$acyearshort"
			
						,CASE
					WHEN "frfromaction"='Sub-Merge'  THEN ''
					ELSE "MDDS_DT$acyearshort"
						END AS "MDDS_DT$acyearshort"
						
					,"SDID$acyearshort"
					
					,CASE
					WHEN "frfromaction"='Sub-Merge'  THEN ''
					ELSE "SDName$acyearshort"
						END AS "SDName$acyearshort"
			
						,CASE
					WHEN "frfromaction"='Sub-Merge'  THEN ''
					ELSE "MDDS_SD$acyearshort"
						END AS "MDDS_SD$acyearshort"
						
						,"VTID$acyearshort"
			
						,CASE
					WHEN "frfromaction"='Sub-Merge'  THEN ''
					ELSE "VTName$acyearshort"
						END AS "VTName$acyearshort"
			
						,CASE
						WHEN vt$acyear."is_deleted"=0  THEN ''
					ELSE "MDDS_VT$acyearshort"
					END AS "MDDS_VT$acyearshort"
					,CASE
					WHEN "frfromaction"='Sub-Merge'  THEN ''
					ELSE "Level$acyearshort"
					END AS "Level$acyearshort"
					,CASE
					WHEN "frfromaction"='Sub-Merge'  THEN ''
					ELSE "Status$acyearshort"
					END AS "Status$acyearshort","is_deleted"
			
					FROM (
						SELECT DISTINCT ON( fr$acyearshort."VTIDACTIVE") fr$acyearshort."VTIDACTIVE",fr$acyearshort."VTIDR",fr$acyearshort.frids,
						fr$acyearshort.frcomment,fr$acyearshort.comeaction,fr$acyearshort.frfromaction
			
						FROM forreaddata20$acyearshort AS fr$acyearshort
			
						WHERE fr$acyearshort."VTIDACTIVE"!=0 AND fr$acyearshort."VTIDACTIVE"=fr$acyearshort."VTIDR"  $cond AND fr$acyearshort."VTIDACTIVE"=fr$acyearshort."VTID"   ORDER BY "VTIDACTIVE", "frids" DESC
					) AS frtab
					INNER JOIN (
						SELECT "STID$acyearshort","STName$acyearshort","STStatus$acyearshort","MDDS_ST$acyearshort","DTID$acyearshort","DTName$acyearshort","MDDS_DT$acyearshort","SDID$acyearshort","SDName$acyearshort","MDDS_SD$acyearshort"
							,"VTID" AS "VTID$acyearshort","VTName" AS "VTName$acyearshort","MDDS_VT" AS "MDDS_VT$acyearshort","Level" AS "Level$acyearshort","Status" AS "Status$acyearshort","is_deleted" FROM vt$acyear 
							INNER JOIN (
								SELECT "STID" AS "STID$acyearshort","STName" AS "STName$acyearshort","Status" AS "STStatus$acyearshort","MDDS_ST" AS "MDDS_ST$acyearshort" FROM st$acyear WHERE is_deleted=1
							) AS st$acyearshort ON st$acyearshort."STID$acyearshort"=vt$acyear."STID"
							INNER JOIN (
								SELECT "DTID" AS "DTID$acyearshort","DTName" AS "DTName$acyearshort","MDDS_DT" AS "MDDS_DT$acyearshort" FROM dt$acyear WHERE is_deleted=1
							) AS dt$acyearshort ON dt$acyearshort."DTID$acyearshort"=vt$acyear."DTID"
							INNER JOIN (
								SELECT "SDID" AS "SDID$acyearshort","SDName" AS "SDName$acyearshort","MDDS_SD" AS "MDDS_SD$acyearshort" FROM sd$acyear WHERE is_deleted=1
							) AS sd$acyearshort ON sd$acyearshort."SDID$acyearshort"=vt$acyear."SDID"
							$cond1
					) AS vt$acyear ON frtab."VTIDACTIVE" = vt$acyear."VTID$acyearshort" 
			
					LEFT JOIN (
						SELECT "STID$olyear","STName$olyear","STStatus$olyear","MDDS_ST$olyear","DTID$olyear","DTName$olyear","MDDS_DT$olyear","SDID$olyear","SDName$olyear","MDDS_SD$olyear"
							,"VTID" AS "VTID$olyear","VTName" AS "VTName$olyear","MDDS_VT" AS "MDDS_VT$olyear","Level" AS "Level$olyear","Status" AS "Status$olyear" FROM vt$olyear 
							INNER JOIN (
								SELECT "STID" AS "STID$olyear","STName" AS "STName$olyear","Status" AS "STStatus$olyear","MDDS_ST" AS "MDDS_ST$olyear" FROM st$olyear
							) AS st11 ON st11."STID$olyear"=vt$olyear."STID"
							INNER JOIN (
								SELECT "DTID" AS "DTID$olyear","DTName" AS "DTName$olyear","MDDS_DT" AS "MDDS_DT$olyear" FROM dt$olyear
							) AS dt11 ON dt11."DTID$olyear"=vt$olyear."DTID"
							INNER JOIN (
								SELECT "SDID" AS "SDID$olyear","SDName" AS "SDName$olyear","MDDS_SD" AS "MDDS_SD$olyear" FROM sd$olyear
							) AS sd11 ON sd11."SDID$olyear"=vt$olyear."SDID"
							$cond3
					) AS vt$olyear ON frtab."VTIDR" = vt$olyear."VTID$olyear"
				) AS TAB1
			
				UNION ALL
			
				SELECT * FROM (
					SELECT DISTINCT ( fr$acyearshort."VTIDACTIVE"),fr$acyearshort."frids",vt$olyear.*,fr$acyearshort.frcomment,fr$acyearshort.comeaction,vt$acyear.* FROM forreaddata$acyear AS fr$acyearshort
					LEFT JOIN (
						SELECT "STID$olyear","STName$olyear","STStatus$olyear","MDDS_ST$olyear","DTID$olyear","DTName$olyear","MDDS_DT$olyear","SDID$olyear","SDName$olyear","MDDS_SD$olyear"
							,"VTID" AS "VTID$olyear","VTName" AS "VTName$olyear","MDDS_VT" AS "MDDS_VT$olyear","Level" AS "Level$olyear","Status" AS "Status$olyear" FROM vt$olyear 
							INNER JOIN (
								SELECT "STID" AS "STID$olyear","STName" AS "STName$olyear","Status" AS "STStatus$olyear","MDDS_ST" AS "MDDS_ST$olyear" FROM st$olyear
							) AS st11 ON st11."STID$olyear"=vt$olyear."STID"
							INNER JOIN (
								SELECT "DTID" AS "DTID$olyear","DTName" AS "DTName$olyear","MDDS_DT" AS "MDDS_DT$olyear" FROM dt$olyear
							) AS dt11 ON dt11."DTID$olyear"=vt$olyear."DTID"
							INNER JOIN (
								SELECT "SDID" AS "SDID$olyear","SDName" AS "SDName$olyear","MDDS_SD" AS "MDDS_SD$olyear" FROM sd$olyear
							) AS sd11 ON sd11."SDID$olyear"=vt$olyear."SDID"
							$cond1
					) AS vt$olyear ON fr$acyearshort."VTIDR" = vt$olyear."VTID$olyear"
			
					LEFT JOIN (
						SELECT "STID$acyearshort","STName$acyearshort","STStatus$acyearshort","MDDS_ST$acyearshort","DTID$acyearshort","DTName$acyearshort","MDDS_DT$acyearshort","SDID$acyearshort","SDName$acyearshort","MDDS_SD$acyearshort"
							,"VTID" AS "VTID$acyearshort","VTName" AS "VTName$acyearshort","MDDS_VT" AS "MDDS_VT$acyearshort","Level" AS "Level$acyearshort","Status" AS "Status$acyearshort","is_deleted" FROM vt$acyear 
							INNER JOIN (
								SELECT "STID" AS "STID$acyearshort","STName" AS "STName$acyearshort","Status" AS "STStatus$acyearshort","MDDS_ST" AS "MDDS_ST$acyearshort" FROM st$acyear
							) AS st$acyearshort ON st$acyearshort."STID$acyearshort"=vt$acyear."STID"
							INNER JOIN (
								SELECT "DTID" AS "DTID$acyearshort","DTName" AS "DTName$acyearshort","MDDS_DT" AS "MDDS_DT$acyearshort" FROM dt$acyear
							) AS dt$acyearshort ON dt$acyearshort."DTID$acyearshort"=vt$acyear."DTID"
							INNER JOIN (
								SELECT "SDID" AS "SDID$acyearshort","SDName" AS "SDName$acyearshort","MDDS_SD" AS "MDDS_SD$acyearshort" FROM sd$acyear
							) AS sd$acyearshort ON sd$acyearshort."SDID$acyearshort"=vt$acyear."SDID"
							$cond1
					) AS vt$acyear ON fr$acyearshort."VTIDACTIVE" = vt$acyear."VTID$acyearshort"
					WHERE fr$acyearshort."VTIDACTIVE"!=0   $cond AND fr$acyearshort."VTIDACTIVE"!=fr$acyearshort."VTID"  ORDER BY "VTIDACTIVE", "frids" DESC
				) AS TAB2
			) temp
			EOT;
		}
		
	}
	else if($rowstatepm['frcomefrom']=='State' && $rowstatepm['frfromaction']=='Partially Merge'){
		$table = <<<EOT
		(
			SELECT * FROM (
				SELECT "VTIDACTIVE","frids","STID$olyear","STName$olyear","STStatus$olyear","MDDS_ST$olyear","DTID$olyear","DTName$olyear","MDDS_DT$olyear","SDID$olyear","SDName$olyear","MDDS_SD$olyear",
				"VTID$olyear","VTName$olyear","MDDS_VT$olyear","Level$olyear","Status$olyear","frcomment","comeaction","STID$acyearshort"
					
				,CASE
				WHEN "frfromaction"='Sub-Merge'  THEN ''
				ELSE "STName$acyearshort"
					END AS "STName$acyearshort"

				,CASE WHEN "frfromaction"='Sub-Merge' THEN ''
				ELSE "STStatus$acyearshort"  
				END AS  "STStatus$acyearshort"
		
					,CASE
				WHEN "frfromaction"='Sub-Merge'  THEN ''
				ELSE "MDDS_ST$acyearshort"
					END AS "MDDS_ST$acyearshort"
		
				,"DTID$acyearshort"
				
				,CASE
				WHEN "frfromaction"='Sub-Merge'  THEN ''
				ELSE "DTName$acyearshort"
					END AS "DTName$acyearshort"
		
					,CASE
				WHEN "frfromaction"='Sub-Merge'  THEN ''
				ELSE "MDDS_DT$acyearshort"
					END AS "MDDS_DT$acyearshort"
					
				,"SDID$acyearshort"
				
				,CASE
				WHEN "frfromaction"='Sub-Merge'  THEN ''
				ELSE "SDName$acyearshort"
					END AS "SDName$acyearshort"
		
					,CASE
				WHEN "frfromaction"='Sub-Merge'  THEN ''
				ELSE "MDDS_SD$acyearshort"
					END AS "MDDS_SD$acyearshort"
					
					,"VTID$acyearshort"
		
					,CASE
				WHEN "frfromaction"='Sub-Merge'  THEN ''
				ELSE "VTName$acyearshort"
					END AS "VTName$acyearshort"
		
					,CASE
					WHEN vt$acyear."is_deleted"=0  THEN ''
				ELSE "MDDS_VT$acyearshort"
				END AS "MDDS_VT$acyearshort"
				,CASE
				WHEN "frfromaction"='Sub-Merge'  THEN ''
				ELSE "Level$acyearshort"
				END AS "Level$acyearshort"
				,CASE
				WHEN "frfromaction"='Sub-Merge'  THEN ''
				ELSE "Status$acyearshort"
				END AS "Status$acyearshort","is_deleted"
		
				FROM (
					SELECT DISTINCT ON( fr$acyearshort."VTIDACTIVE") fr$acyearshort."VTIDACTIVE",fr$acyearshort."VTIDR",fr$acyearshort.frids,
					fr$acyearshort.frcomment,fr$acyearshort.comeaction,fr$acyearshort.frfromaction
		
					FROM forreaddata20$acyearshort AS fr$acyearshort
		
					WHERE fr$acyearshort."VTIDACTIVE"=0 AND fr$acyearshort."VTIDACTIVE"=fr$acyearshort."VTIDR"  $cond AND fr$acyearshort."VTIDACTIVE"=fr$acyearshort."VTID"   ORDER BY "VTIDACTIVE", "frids" DESC
				) AS frtab
				INNER JOIN (
					SELECT "STID$acyearshort","STName$acyearshort","STStatus$acyearshort","MDDS_ST$acyearshort","DTID$acyearshort","DTName$acyearshort","MDDS_DT$acyearshort","SDID$acyearshort","SDName$acyearshort","MDDS_SD$acyearshort"
						,"VTID" AS "VTID$acyearshort","VTName" AS "VTName$acyearshort","MDDS_VT" AS "MDDS_VT$acyearshort","Level" AS "Level$acyearshort","Status" AS "Status$acyearshort","is_deleted" FROM vt$acyear 
						INNER JOIN (
							SELECT "STID" AS "STID$acyearshort","STName" AS "STName$acyearshort","Status" AS "STStatus$acyearshort","MDDS_ST" AS "MDDS_ST$acyearshort" FROM st$acyear WHERE is_deleted=1
						) AS st$acyearshort ON st$acyearshort."STID$acyearshort"=vt$acyear."STID"
						INNER JOIN (
							SELECT "DTID" AS "DTID$acyearshort","DTName" AS "DTName$acyearshort","MDDS_DT" AS "MDDS_DT$acyearshort" FROM dt$acyear WHERE is_deleted=1
						) AS dt$acyearshort ON dt$acyearshort."DTID$acyearshort"=vt$acyear."DTID"
						INNER JOIN (
							SELECT "SDID" AS "SDID$acyearshort","SDName" AS "SDName$acyearshort","MDDS_SD" AS "MDDS_SD$acyearshort" FROM sd$acyear WHERE is_deleted=1
						) AS sd$acyearshort ON sd$acyearshort."SDID$acyearshort"=vt$acyear."SDID"
						$cond1
				) AS vt$acyear ON frtab."VTIDACTIVE" = vt$acyear."VTID$acyearshort" 
		
				LEFT JOIN (
					SELECT "STID$olyear","STName$olyear","STStatus$olyear","MDDS_ST$olyear","DTID$olyear","DTName$olyear","MDDS_DT$olyear","SDID$olyear","SDName$olyear","MDDS_SD$olyear"
						,"VTID" AS "VTID$olyear","VTName" AS "VTName$olyear","MDDS_VT" AS "MDDS_VT$olyear","Level" AS "Level$olyear","Status" AS "Status$olyear" FROM vt$olyear 
						INNER JOIN (
							SELECT "STID" AS "STID$olyear","STName" AS "STName$olyear","Status" AS "STStatus$olyear","MDDS_ST" AS "MDDS_ST$olyear" FROM st$olyear
						) AS st11 ON st11."STID$olyear"=vt$olyear."STID"
						INNER JOIN (
							SELECT "DTID" AS "DTID$olyear","DTName" AS "DTName$olyear","MDDS_DT" AS "MDDS_DT$olyear" FROM dt$olyear
						) AS dt11 ON dt11."DTID$olyear"=vt$olyear."DTID"
						INNER JOIN (
							SELECT "SDID" AS "SDID$olyear","SDName" AS "SDName$olyear","MDDS_SD" AS "MDDS_SD$olyear" FROM sd$olyear
						) AS sd11 ON sd11."SDID$olyear"=vt$olyear."SDID"
						$cond3
				) AS vt$olyear ON frtab."VTIDR" = vt$olyear."VTID$olyear"
			) AS TAB1
		
			UNION ALL
		
			SELECT * FROM (
				SELECT DISTINCT ( fr$acyearshort."VTIDACTIVE"),fr$acyearshort."frids",vt$olyear.*,fr$acyearshort.frcomment,fr$acyearshort.comeaction,vt$acyear.* FROM forreaddata$acyear AS fr$acyearshort
				LEFT JOIN (
					SELECT "STID$olyear","STName$olyear","STStatus$olyear","MDDS_ST$olyear","DTID$olyear","DTName$olyear","MDDS_DT$olyear","SDID$olyear","SDName$olyear","MDDS_SD$olyear"
						,"VTID" AS "VTID$olyear","VTName" AS "VTName$olyear","MDDS_VT" AS "MDDS_VT$olyear","Level" AS "Level$olyear","Status" AS "Status$olyear" FROM vt$olyear 
						INNER JOIN (
							SELECT "STID" AS "STID$olyear","STName" AS "STName$olyear","Status" AS "STStatus$olyear","MDDS_ST" AS "MDDS_ST$olyear" FROM st$olyear
						) AS st11 ON st11."STID$olyear"=vt$olyear."STID"
						INNER JOIN (
							SELECT "DTID" AS "DTID$olyear","DTName" AS "DTName$olyear","MDDS_DT" AS "MDDS_DT$olyear" FROM dt$olyear
						) AS dt11 ON dt11."DTID$olyear"=vt$olyear."DTID"
						INNER JOIN (
							SELECT "SDID" AS "SDID$olyear","SDName" AS "SDName$olyear","MDDS_SD" AS "MDDS_SD$olyear" FROM sd$olyear
						) AS sd11 ON sd11."SDID$olyear"=vt$olyear."SDID"
						$cond1
				) AS vt$olyear ON fr$acyearshort."VTIDR" = vt$olyear."VTID$olyear"
		
				LEFT JOIN (
					SELECT "STID$acyearshort","STName$acyearshort","STStatus$acyearshort","MDDS_ST$acyearshort","DTID$acyearshort","DTName$acyearshort","MDDS_DT$acyearshort","SDID$acyearshort","SDName$acyearshort","MDDS_SD$acyearshort"
						,"VTID" AS "VTID$acyearshort","VTName" AS "VTName$acyearshort","MDDS_VT" AS "MDDS_VT$acyearshort","Level" AS "Level$acyearshort","Status" AS "Status$acyearshort","is_deleted" FROM vt$acyear 
						INNER JOIN (
							SELECT "STID" AS "STID$acyearshort","STName" AS "STName$acyearshort","Status" AS "STStatus$acyearshort","MDDS_ST" AS "MDDS_ST$acyearshort" FROM st$acyear
						) AS st$acyearshort ON st$acyearshort."STID$acyearshort"=vt$acyear."STID"
						INNER JOIN (
							SELECT "DTID" AS "DTID$acyearshort","DTName" AS "DTName$acyearshort","MDDS_DT" AS "MDDS_DT$acyearshort" FROM dt$acyear
						) AS dt$acyearshort ON dt$acyearshort."DTID$acyearshort"=vt$acyear."DTID"
						INNER JOIN (
							SELECT "SDID" AS "SDID$acyearshort","SDName" AS "SDName$acyearshort","MDDS_SD" AS "MDDS_SD$acyearshort" FROM sd$acyear
						) AS sd$acyearshort ON sd$acyearshort."SDID$acyearshort"=vt$acyear."SDID"
				) AS vt$acyear ON fr$acyearshort."VTIDACTIVE" = vt$acyear."VTID$acyearshort"
				WHERE fr$acyearshort."VTIDACTIVE"!=0   $cond AND fr$acyearshort."VTIDACTIVE"=fr$acyearshort."VTID"  ORDER BY "VTIDACTIVE", "frids" DESC
			) AS TAB2
		) temp
		EOT;
	}
	else if($rowstate['frcomefrom']=='State' &&  $rowstate['frfromaction']=='Merge'){
		$table = <<<EOT
		(
		SELECT *
		FROM (
			SELECT
				"VTIDACTIVE", "frids", "STID$olyear", "STName$olyear", "STStatus$olyear", "MDDS_ST$olyear", "DTID$olyear", "DTName$olyear", "MDDS_DT$olyear", "SDID$olyear", "SDName$olyear", "MDDS_SD$olyear",
				"VTID$olyear", "VTName$olyear", "MDDS_VT$olyear", "Level$olyear", "Status$olyear", "frcomment", "comeaction", "STID$acyearshort",
				CASE
					WHEN "frfromaction" = 'Sub-Merge' THEN ''
					ELSE "STName$acyearshort"
				END AS "STName$acyearshort",
				CASE
					WHEN "frfromaction" = 'Sub-Merge' THEN ''
					ELSE "STStatus$acyearshort"
				END AS  "STStatus$acyearshort",
				CASE
					WHEN "frfromaction" = 'Sub-Merge' THEN ''
					ELSE "MDDS_ST$acyearshort"
				END AS "MDDS_ST$acyearshort",
				"DTID$acyearshort",
				CASE
					WHEN "frfromaction" = 'Sub-Merge' THEN ''
					ELSE "DTName$acyearshort"
				END AS "DTName$acyearshort",
				CASE
					WHEN "frfromaction" = 'Sub-Merge' THEN ''
					ELSE "MDDS_DT$acyearshort"
				END AS "MDDS_DT$acyearshort",
				"SDID$acyearshort",
				CASE
					WHEN "frfromaction" = 'Sub-Merge' THEN ''
					ELSE "SDName$acyearshort"
				END AS "SDName$acyearshort",
				CASE
					WHEN "frfromaction" = 'Sub-Merge' THEN ''
					ELSE "MDDS_SD$acyearshort"
				END AS "MDDS_SD$acyearshort",
				"VTID$acyearshort",
				CASE
					WHEN "frfromaction" = 'Sub-Merge' THEN ''
					ELSE "VTName$acyearshort"
				END AS "VTName$acyearshort",
				CASE
					WHEN vt$acyear."is_deleted" = 0 THEN ''
					ELSE "MDDS_VT$acyearshort"
				END AS "MDDS_VT$acyearshort",
				CASE
					WHEN "frfromaction" = 'Sub-Merge' THEN ''
					ELSE "Level$acyearshort"
				END AS "Level$acyearshort",
				CASE
					WHEN "frfromaction" = 'Sub-Merge' THEN ''
					ELSE "Status$acyearshort"
				END AS "Status$acyearshort",
				"is_deleted"
			FROM (
				SELECT DISTINCT ON (fr$acyearshort."VTIDACTIVE") fr$acyearshort."VTIDACTIVE", fr$acyearshort."VTIDR", fr$acyearshort.frids,
					fr$acyearshort.frcomment, fr$acyearshort.comeaction, fr$acyearshort.frfromaction
				FROM forreaddata20$acyearshort AS fr$acyearshort
				WHERE fr$acyearshort."VTIDACTIVE" != 0 AND fr$acyearshort."VTIDACTIVE" = fr$acyearshort."VTIDR" $cond
					AND fr$acyearshort."VTIDACTIVE" = fr$acyearshort."VTID"
				ORDER BY "VTIDACTIVE", "frids" DESC
			) AS frtab
			INNER JOIN (
				SELECT
					"STID$acyearshort", "STName$acyearshort", "STStatus$acyearshort", "MDDS_ST$acyearshort", "DTID$acyearshort", "DTName$acyearshort", "MDDS_DT$acyearshort", "SDID$acyearshort", "SDName$acyearshort", "MDDS_SD$acyearshort",
					"VTID" AS "VTID$acyearshort", "VTName" AS "VTName$acyearshort", "MDDS_VT" AS "MDDS_VT$acyearshort", "Level" AS "Level$acyearshort", "Status" AS "Status$acyearshort", "is_deleted"
				FROM vt$acyear
				INNER JOIN (
					SELECT "STID" AS "STID$acyearshort", "STName" AS "STName$acyearshort", "Status" AS "STStatus$acyearshort", "MDDS_ST" AS "MDDS_ST$acyearshort"
					FROM st$acyear
					WHERE is_deleted = 1
				) AS st$acyearshort ON st$acyearshort."STID$acyearshort" = vt$acyear."STID"
				INNER JOIN (
					SELECT "DTID" AS "DTID$acyearshort", "DTName" AS "DTName$acyearshort", "MDDS_DT" AS "MDDS_DT$acyearshort"
					FROM dt$acyear
					WHERE is_deleted = 1
				) AS dt$acyearshort ON dt$acyearshort."DTID$acyearshort" = vt$acyear."DTID"
				INNER JOIN (
					SELECT "SDID" AS "SDID$acyearshort", "SDName" AS "SDName$acyearshort", "MDDS_SD" AS "MDDS_SD$acyearshort"
					FROM sd$acyear
					WHERE is_deleted = 1
				) AS sd$acyearshort ON sd$acyearshort."SDID$acyearshort" = vt$acyear."SDID"
				$cond1
			) AS vt$acyear ON frtab."VTIDACTIVE" = vt$acyear."VTID$acyearshort"
			LEFT JOIN (
				SELECT
					"STID$olyear", "STName$olyear", "STStatus$olyear", "MDDS_ST$olyear", "DTID$olyear", "DTName$olyear", "MDDS_DT$olyear", "SDID$olyear", "SDName$olyear", "MDDS_SD$olyear",
					"VTID" AS "VTID$olyear", "VTName" AS "VTName$olyear", "MDDS_VT" AS "MDDS_VT$olyear", "Level" AS "Level$olyear", "Status" AS "Status$olyear"
				FROM vt$olyear
				INNER JOIN (
					SELECT "STID" AS "STID$olyear", "STName" AS "STName$olyear", "Status" AS "STStatus$olyear", "MDDS_ST" AS "MDDS_ST$olyear"
					FROM st$olyear
				) AS st11 ON st11."STID$olyear" = vt$olyear."STID"
				INNER JOIN (
					SELECT "DTID" AS "DTID$olyear", "DTName" AS "DTName$olyear", "MDDS_DT" AS "MDDS_DT$olyear"
					FROM dt$olyear
				) AS dt11 ON dt11."DTID$olyear" = vt$olyear."DTID"
				INNER JOIN (
					SELECT "SDID" AS "SDID$olyear", "SDName" AS "SDName$olyear", "MDDS_SD" AS "MDDS_SD$olyear"
					FROM sd$olyear
				) AS sd11 ON sd11."SDID$olyear" = vt$olyear."SDID"
				$cond4
			) AS vt$olyear ON frtab."VTIDR" = vt$olyear."VTID$olyear"
		) AS TAB1

		UNION ALL

		SELECT *
		FROM (
			SELECT DISTINCT (fr$acyearshort."VTIDACTIVE"), fr$acyearshort."frids", vt$olyear.*, fr$acyearshort.frcomment, fr$acyearshort.comeaction, vt$acyear.*
			FROM forreaddata$acyear AS fr$acyearshort
			LEFT JOIN (
				SELECT
					"STID$olyear", "STName$olyear", "STStatus$olyear", "MDDS_ST$olyear", "DTID$olyear", "DTName$olyear", "MDDS_DT$olyear", "SDID$olyear", "SDName$olyear", "MDDS_SD$olyear",
					"VTID" AS "VTID$olyear", "VTName" AS "VTName$olyear", "MDDS_VT" AS "MDDS_VT$olyear", "Level" AS "Level$olyear", "Status" AS "Status$olyear"
				FROM vt$olyear
				INNER JOIN (
					SELECT "STID" AS "STID$olyear", "STName" AS "STName$olyear", "Status" AS "STStatus$olyear", "MDDS_ST" AS "MDDS_ST$olyear"
					FROM st$olyear
				) AS st11 ON st11."STID$olyear" = vt$olyear."STID"
				INNER JOIN (
					SELECT "DTID" AS "DTID$olyear", "DTName" AS "DTName$olyear", "MDDS_DT" AS "MDDS_DT$olyear"
					FROM dt$olyear
				) AS dt11 ON dt11."DTID$olyear" = vt$olyear."DTID"
				INNER JOIN (
					SELECT "SDID" AS "SDID$olyear", "SDName" AS "SDName$olyear", "MDDS_SD" AS "MDDS_SD$olyear"
					FROM sd$olyear
				) AS sd11 ON sd11."SDID$olyear" = vt$olyear."SDID"
				$cond1
			) AS vt$olyear ON fr$acyearshort."VTIDR" = vt$olyear."VTID$olyear"
			LEFT JOIN (
				SELECT
					"STID$acyearshort", "STName$acyearshort", "STStatus$acyearshort", "MDDS_ST$acyearshort", "DTID$acyearshort", "DTName$acyearshort", "MDDS_DT$acyearshort", "SDID$acyearshort", "SDName$acyearshort", "MDDS_SD$acyearshort",
					"VTID" AS "VTID$acyearshort", "VTName" AS "VTName$acyearshort", "MDDS_VT" AS "MDDS_VT$acyearshort", "Level" AS "Level$acyearshort", "Status" AS "Status$acyearshort", "is_deleted"
				FROM vt$acyear
				INNER JOIN (
					SELECT "STID" AS "STID$acyearshort", "STName" AS "STName$acyearshort", "Status" AS "STStatus$acyearshort", "MDDS_ST" AS "MDDS_ST$acyearshort"
					FROM st$acyear
				) AS st$acyearshort ON st$acyearshort."STID$acyearshort" = vt$acyear."STID"
				INNER JOIN (
					SELECT "DTID" AS "DTID$acyearshort", "DTName" AS "DTName$acyearshort", "MDDS_DT" AS "MDDS_DT$acyearshort"
					FROM dt$acyear
				) AS dt$acyearshort ON dt$acyearshort."DTID$acyearshort" = vt$acyear."DTID"
				INNER JOIN (
					SELECT "SDID" AS "SDID$acyearshort", "SDName" AS "SDName$acyearshort", "MDDS_SD" AS "MDDS_SD$acyearshort"
					FROM sd$acyear
				) AS sd$acyearshort ON sd$acyearshort."SDID$acyearshort" = vt$acyear."SDID"
				$cond1
			) AS vt$acyear ON fr$acyearshort."VTIDACTIVE" = vt$acyear."VTID$acyearshort"
			WHERE fr$acyearshort."VTIDACTIVE" != 0 $cond AND fr$acyearshort."VTIDACTIVE" != fr$acyearshort."VTIDR"
			ORDER BY "VTIDACTIVE", "frids" DESC
		) AS TAB2
		) temp
		EOT;
	}
// forread related table for all level
	else {
$table = <<<EOT
(

SELECT * FROM (select "VTIDACTIVE","frids","STID$olyear","STName$olyear","STStatus$olyear","MDDS_ST$olyear","DTID$olyear","DTName$olyear","MDDS_DT$olyear","SDID$olyear","SDName$olyear","MDDS_SD$olyear",
"VTID$olyear","VTName$olyear","MDDS_VT$olyear","Level$olyear","Status$olyear","frcomment","comeaction","STID$acyearshort"
		   
		   ,CASE
		   WHEN "frfromaction"='Sub-Merge'  THEN ''
		   ELSE "STName$acyearshort"
			  END AS "STName$acyearshort"

		   ,CASE WHEN "frfromaction"='Sub-Merge' THEN ''
		   ELSE "STStatus$acyearshort"  
		   END AS  "STStatus$acyearshort"


			  ,CASE
		   WHEN "frfromaction"='Sub-Merge'  THEN ''
		   ELSE "MDDS_ST$acyearshort"
			  END AS "MDDS_ST$acyearshort"


		   ,"DTID$acyearshort"
		   
		   ,CASE
		   WHEN "frfromaction"='Sub-Merge'  THEN ''
		   ELSE "DTName$acyearshort"
			  END AS "DTName$acyearshort"

			  ,CASE
		   WHEN "frfromaction"='Sub-Merge'  THEN ''
		   ELSE "MDDS_DT$acyearshort"
			  END AS "MDDS_DT$acyearshort"
			 
		   ,"SDID$acyearshort"
		   
		   ,CASE
		   WHEN "frfromaction"='Sub-Merge'  THEN ''
		   ELSE "SDName$acyearshort"
			  END AS "SDName$acyearshort"

			  ,CASE
		   WHEN "frfromaction"='Sub-Merge'  THEN ''
		   ELSE "MDDS_SD$acyearshort"
			  END AS "MDDS_SD$acyearshort"
			 
			 ,"VTID$acyearshort"

			 ,CASE
		   WHEN "frfromaction"='Sub-Merge'  THEN ''
		   ELSE "VTName$acyearshort"
			  END AS "VTName$acyearshort"

			  ,CASE
			  WHEN vt$acyear."is_deleted"=0  THEN ''
		   ELSE "MDDS_VT$acyearshort"
		   END AS "MDDS_VT$acyearshort"
		   ,CASE
		   WHEN "frfromaction"='Sub-Merge'  THEN ''
		   ELSE "Level$acyearshort"
		   END AS "Level$acyearshort"
		   ,CASE
		   WHEN "frfromaction"='Sub-Merge'  THEN ''
		   ELSE "Status$acyearshort"
		   END AS "Status$acyearshort","is_deleted"

from (select DISTINCT ON( fr$acyearshort."VTIDACTIVE") fr$acyearshort."VTIDACTIVE",fr$acyearshort."VTIDR",fr$acyearshort.frids,
			  fr$acyearshort.frcomment,fr$acyearshort.comeaction,fr$acyearshort.frfromaction
			  
			  from forreaddata20$acyearshort as fr$acyearshort
			  
			   WHERE fr$acyearshort."VTIDACTIVE"!=0 AND fr$acyearshort."VTIDACTIVE"=fr$acyearshort."VTIDR"  $cond AND fr$acyearshort."VTIDACTIVE"=fr$acyearshort."VTID"   ORDER BY "VTIDACTIVE", "frids" DESC) as frtab
			INNER JOIN
(select "STID$acyearshort","STName$acyearshort","STStatus$acyearshort","MDDS_ST$acyearshort","DTID$acyearshort","DTName$acyearshort","MDDS_DT$acyearshort","SDID$acyearshort","SDName$acyearshort","MDDS_SD$acyearshort"
 ,"VTID" as "VTID$acyearshort","VTName" as "VTName$acyearshort","MDDS_VT" as "MDDS_VT$acyearshort","Level" as "Level$acyearshort","Status" as "Status$acyearshort","is_deleted" from vt$acyear 
 INNER JOIN (select "STID" AS "STID$acyearshort","STName" AS "STName$acyearshort","Status" AS "STStatus$acyearshort","MDDS_ST" AS "MDDS_ST$acyearshort" from st$acyear where is_deleted=1) as st$acyearshort ON st$acyearshort."STID$acyearshort"=vt$acyear."STID"
INNER JOIN (select "DTID" AS "DTID$acyearshort","DTName" AS "DTName$acyearshort","MDDS_DT" AS "MDDS_DT$acyearshort" from dt$acyear where is_deleted=1) as dt$acyearshort ON dt$acyearshort."DTID$acyearshort"=vt$acyear."DTID"
INNER JOIN (select "SDID" AS "SDID$acyearshort","SDName" AS "SDName$acyearshort","MDDS_SD" AS "MDDS_SD$acyearshort" from sd$acyear where is_deleted=1) as sd$acyearshort ON sd$acyearshort."SDID$acyearshort"=vt$acyear."SDID"
   $cond1) as vt$acyear ON frtab."VTIDACTIVE" = vt$acyear."VTID$acyearshort" 
   
LEFT JOIN
(select "STID$olyear","STName$olyear","STStatus$olyear","MDDS_ST$olyear","DTID$olyear","DTName$olyear","MDDS_DT$olyear","SDID$olyear","SDName$olyear","MDDS_SD$olyear"
 ,"VTID" as "VTID$olyear","VTName" as "VTName$olyear","MDDS_VT" as "MDDS_VT$olyear","Level" as "Level$olyear","Status" as "Status$olyear" from vt$olyear 
 INNER JOIN (select "STID" AS "STID$olyear","STName" AS "STName$olyear","Status" AS "STStatus$olyear","MDDS_ST" AS "MDDS_ST$olyear" from st$olyear) as st11 ON st11."STID$olyear"=vt$olyear."STID"
INNER JOIN (select "DTID" AS "DTID$olyear","DTName" AS "DTName$olyear","MDDS_DT" AS "MDDS_DT$olyear" from dt$olyear) as dt11 ON dt11."DTID$olyear"=vt$olyear."DTID"
INNER JOIN (select "SDID" AS "SDID$olyear","SDName" AS "SDName$olyear","MDDS_SD" AS "MDDS_SD$olyear" from sd$olyear) as sd11 ON sd11."SDID$olyear"=vt$olyear."SDID"
   $cond3) as vt$olyear ON frtab."VTIDR" = vt$olyear."VTID$olyear") AS TAB1

UNION ALL

SELECT * FROM (select DISTINCT ( fr$acyearshort."VTIDACTIVE"),fr$acyearshort."frids",vt$olyear.*,fr$acyearshort.frcomment,fr$acyearshort.comeaction,vt$acyear.* from forreaddata$acyear as fr$acyearshort
LEFT JOIN
(select "STID$olyear","STName$olyear","STStatus$olyear","MDDS_ST$olyear","DTID$olyear","DTName$olyear","MDDS_DT$olyear","SDID$olyear","SDName$olyear","MDDS_SD$olyear"
 ,"VTID" as "VTID$olyear","VTName" as "VTName$olyear","MDDS_VT" as "MDDS_VT$olyear","Level" as "Level$olyear","Status" as "Status$olyear" from vt$olyear 
 INNER JOIN (select "STID" AS "STID$olyear","STName" AS "STName$olyear","Status" AS "STStatus$olyear","MDDS_ST" AS "MDDS_ST$olyear" from st$olyear) as st11 ON st11."STID$olyear"=vt$olyear."STID"
INNER JOIN (select "DTID" AS "DTID$olyear","DTName" AS "DTName$olyear","MDDS_DT" AS "MDDS_DT$olyear" from dt$olyear) as dt11 ON dt11."DTID$olyear"=vt$olyear."DTID"
INNER JOIN (select "SDID" AS "SDID$olyear","SDName" AS "SDName$olyear","MDDS_SD" AS "MDDS_SD$olyear" from sd$olyear) as sd11 ON sd11."SDID$olyear"=vt$olyear."SDID"
  $cond1) as vt$olyear ON fr$acyearshort."VTIDR" = vt$olyear."VTID$olyear"
 
 LEFT JOIN
(select "STID$acyearshort","STName$acyearshort","STStatus$acyearshort","MDDS_ST$acyearshort","DTID$acyearshort","DTName$acyearshort","MDDS_DT$acyearshort","SDID$acyearshort","SDName$acyearshort","MDDS_SD$acyearshort"
 ,"VTID" as "VTID$acyearshort","VTName" as "VTName$acyearshort","MDDS_VT" as "MDDS_VT$acyearshort","Level" as "Level$acyearshort","Status" as "Status$acyearshort","is_deleted" from vt$acyear 
 INNER JOIN (select "STID" AS "STID$acyearshort","STName" AS "STName$acyearshort","Status" AS "STStatus$acyearshort","MDDS_ST" AS "MDDS_ST$acyearshort" from st$acyear) as st$acyearshort ON st$acyearshort."STID$acyearshort"=vt$acyear."STID"
INNER JOIN (select "DTID" AS "DTID$acyearshort","DTName" AS "DTName$acyearshort","MDDS_DT" AS "MDDS_DT$acyearshort" from dt$acyear) as dt$acyearshort ON dt$acyearshort."DTID$acyearshort"=vt$acyear."DTID"
INNER JOIN (select "SDID" AS "SDID$acyearshort","SDName" AS "SDName$acyearshort","MDDS_SD" AS "MDDS_SD$acyearshort" from sd$acyear) as sd$acyearshort ON sd$acyearshort."SDID$acyearshort"=vt$acyear."SDID"
  $cond1) as vt$acyear ON fr$acyearshort."VTIDACTIVE" = vt$acyear."VTID$acyearshort"
  WHERE fr$acyearshort."VTIDACTIVE"!=0   $cond AND fr$acyearshort."VTIDACTIVE"!=fr$acyearshort."VTIDR"  ORDER BY "VTIDACTIVE", "frids" DESC) AS TAB2

   
) temp
EOT;
	}


	// $table = <<<EOT
	// 		 (

	// 		SELECT * FROM (select "VTIDACTIVE","frids","STID$olyear","STName$olyear","MDDS_ST$olyear","DTID$olyear","DTName$olyear","MDDS_DT$olyear","SDID$olyear","SDName$olyear","MDDS_SD$olyear",
	// 		"VTID$olyear","VTName$olyear","MDDS_VT$olyear","frcomment","comeaction","STID$acyearshort"
						
	// 					,CASE
	// 		            WHEN "frfromaction"='Sub-Merge'  THEN ''
	// 		            ELSE "STName$acyearshort"
	// 		       		END AS "STName$acyearshort"

	// 		       		,CASE
	// 		            WHEN "frfromaction"='Sub-Merge'  THEN ''
	// 		            ELSE "MDDS_ST$acyearshort"
	// 		       		END AS "MDDS_ST$acyearshort"


	// 					,"DTID$acyearshort"
						
	// 					,CASE
	// 		            WHEN "frfromaction"='Sub-Merge'  THEN ''
	// 		            ELSE "DTName$acyearshort"
	// 		       		END AS "DTName$acyearshort"

	// 		       		,CASE
	// 		            WHEN "frfromaction"='Sub-Merge'  THEN ''
	// 		            ELSE "MDDS_DT$acyearshort"
	// 		       		END AS "MDDS_DT$acyearshort"
			  			
	// 					,"SDID$acyearshort"
						
	// 					,CASE
	// 		            WHEN "frfromaction"='Sub-Merge'  THEN ''
	// 		            ELSE "SDName$acyearshort"
	// 		       		END AS "SDName$acyearshort"

	// 		       		,CASE
	// 		            WHEN "frfromaction"='Sub-Merge'  THEN ''
	// 		            ELSE "MDDS_SD$acyearshort"
	// 		       		END AS "MDDS_SD$acyearshort"
			  			
	// 		  			,"VTID$acyearshort"

	// 		  			,CASE
	// 		            WHEN "frfromaction"='Sub-Merge'  THEN ''
	// 		            ELSE "VTName$acyearshort"
	// 		       		END AS "VTName$acyearshort"

	// 		       		,CASE
	// 		            WHEN "frfromaction"='Sub-Merge'  THEN ''
	// 		            ELSE "MDDS_VT$acyearshort"
	// 		        	END AS "MDDS_VT$acyearshort"

	// 		from (select DISTINCT ON( fr$acyearshort."VTIDACTIVE") fr$acyearshort."VTIDACTIVE",fr$acyearshort."SDIDACTIVE",fr$acyearshort."DTIDACTIVE",fr$acyearshort."VTIDR",fr$acyearshort.frids,
	// 					   fr$acyearshort.frcomment,fr$acyearshort.comeaction,fr$acyearshort.frfromaction
						   
	// 					   from forreaddata20$acyearshort as fr$acyearshort
						   
	// 					    WHERE $cond AND fr$acyearshort."VTIDACTIVE"=fr$acyearshort."VTID"   ORDER BY "VTIDACTIVE", "frids" DESC) as frtab
	// 					 INNER JOIN
	// 		 (select "STID$acyearshort","STName$acyearshort","MDDS_ST$acyearshort","DTID$acyearshort","DTName$acyearshort","MDDS_DT$acyearshort","SDID$acyearshort","SDName$acyearshort","MDDS_SD$acyearshort"
	// 		  ,"VTID" as "VTID$acyearshort","VTName" as "VTName$acyearshort","MDDS_VT" as "MDDS_VT$acyearshort" from vt$acyear 
	// 		  INNER JOIN (select "STID" AS "STID$acyearshort","STName" AS "STName$acyearshort","MDDS_ST" AS "MDDS_ST$acyearshort" from st$acyear where is_deleted=1) as st$acyearshort ON st$acyearshort."STID$acyearshort"=vt$acyear."STID"
	// 		INNER JOIN (select "DTID" AS "DTID$acyearshort","DTName" AS "DTName$acyearshort","MDDS_DT" AS "MDDS_DT$acyearshort" from dt$acyear where is_deleted=1) as dt$acyearshort ON dt$acyearshort."DTID$acyearshort"=vt$acyear."DTID"
	// 		INNER JOIN (select "SDID" AS "SDID$acyearshort","SDName" AS "SDName$acyearshort","MDDS_SD" AS "MDDS_SD$acyearshort" from sd$acyear where is_deleted=1) as sd$acyearshort ON sd$acyearshort."SDID$acyearshort"=vt$acyear."SDID"
	// 		    $cond1) as vt$acyear INNER JOIN
	// 		 (select "STID$olyear","STName$olyear","MDDS_ST$olyear","DTID$olyear","DTName$olyear","MDDS_DT$olyear","SDID$olyear","SDName$olyear","MDDS_SD$olyear"
	// 		  ,"VTID" as "VTID$olyear","VTName" as "VTName$olyear","MDDS_VT" as "MDDS_VT$olyear" from vt$olyear 
	// 		  INNER JOIN (select "STID" AS "STID$olyear","STName" AS "STName$olyear","MDDS_ST" AS "MDDS_ST$olyear" from st$olyear) as st11 ON st11."STID$olyear"=vt$olyear."STID"
	// 		INNER JOIN (select "DTID" AS "DTID$olyear","DTName" AS "DTName$olyear","MDDS_DT" AS "MDDS_DT$olyear" from dt$olyear) as dt11 ON dt11."DTID$olyear"=vt$olyear."DTID"
	// 		INNER JOIN (select "SDID" AS "SDID$olyear","SDName" AS "SDName$olyear","MDDS_SD" AS "MDDS_SD$olyear" from sd$olyear) as sd11 ON sd11."SDID$olyear"=vt$olyear."SDID"
	// 		    $cond1) as vt$olyear ON vt$olyear."VTID$olyear" = vt$acyear."VTID$acyearshort" ON frtab."VTIDACTIVE" = vt$acyear."VTID$acyearshort" OR frtab."SDIDACTIVE" = vt$acyear."SDID$acyearshort" OR frtab."DTIDACTIVE" = vt$acyear."DTID$acyearshort" 
				
	// 		) AS TAB1

	// 		UNION ALL

	// 		SELECT * FROM (select DISTINCT ( fr$acyearshort."VTIDACTIVE"),fr$acyearshort."frids",vt$olyear.*,fr$acyearshort.frcomment,fr$acyearshort.comeaction,vt$acyear.* from forreaddata$acyear as fr$acyearshort
	// 		LEFT JOIN
	// 		 (select "STID$olyear","STName$olyear","MDDS_ST$olyear","DTID$olyear","DTName$olyear","MDDS_DT$olyear","SDID$olyear","SDName$olyear","MDDS_SD$olyear"
	// 		  ,"VTID" as "VTID$olyear","VTName" as "VTName$olyear","MDDS_VT" as "MDDS_VT$olyear" from vt$olyear 
	// 		  INNER JOIN (select "STID" AS "STID$olyear","STName" AS "STName$olyear","MDDS_ST" AS "MDDS_ST$olyear" from st$olyear) as st11 ON st11."STID$olyear"=vt$olyear."STID"
	// 		INNER JOIN (select "DTID" AS "DTID$olyear","DTName" AS "DTName$olyear","MDDS_DT" AS "MDDS_DT$olyear" from dt$olyear) as dt11 ON dt11."DTID$olyear"=vt$olyear."DTID"
	// 		INNER JOIN (select "SDID" AS "SDID$olyear","SDName" AS "SDName$olyear","MDDS_SD" AS "MDDS_SD$olyear" from sd$olyear) as sd11 ON sd11."SDID$olyear"=vt$olyear."SDID"
	// 		   $cond1) as vt$olyear ON fr$acyearshort."VTIDR" = vt$olyear."VTID$olyear"
			  
	// 		  LEFT JOIN
	// 		 (select "STID$acyearshort","STName$acyearshort","MDDS_ST$acyearshort","DTID$acyearshort","DTName$acyearshort","MDDS_DT$acyearshort","SDID$acyearshort","SDName$acyearshort","MDDS_SD$acyearshort"
	// 		  ,"VTID" as "VTID$acyearshort","VTName" as "VTName$acyearshort","MDDS_VT" as "MDDS_VT$acyearshort" from vt$acyear 
	// 		  INNER JOIN (select "STID" AS "STID$acyearshort","STName" AS "STName$acyearshort","MDDS_ST" AS "MDDS_ST$acyearshort" from st$acyear) as st$acyearshort ON st$acyearshort."STID$acyearshort"=vt$acyear."STID"
	// 		INNER JOIN (select "DTID" AS "DTID$acyearshort","DTName" AS "DTName$acyearshort","MDDS_DT" AS "MDDS_DT$acyearshort" from dt$acyear) as dt$acyearshort ON dt$acyearshort."DTID$acyearshort"=vt$acyear."DTID"
	// 		INNER JOIN (select "SDID" AS "SDID$acyearshort","SDName" AS "SDName$acyearshort","MDDS_SD" AS "MDDS_SD$acyearshort" from sd$acyear) as sd$acyearshort ON sd$acyearshort."SDID$acyearshort"=vt$acyear."SDID"
	// 		   $cond1) as vt$acyear ON fr$acyearshort."VTIDACTIVE" = vt$acyear."VTID$acyearshort"
	// 		   WHERE $cond AND fr$acyearshort."VTIDACTIVE"!=fr$acyearshort."VTID"  ORDER BY "VTIDACTIVE", "frids" DESC) AS TAB2

			    
	// 		 ) temp
	// 		EOT;

                 //submerge related  forread issue issue resolve 
			$columns = array(
			array( 'db' => '"STID'.$_SESSION['logindetails']['baseyear'].'"','dt' => 0,'db1' => 'STID'.$_SESSION['logindetails']['baseyear'].''),
			array( 'db' => '"MDDS_ST'.$_SESSION['logindetails']['baseyear'].'"','dt' => 1,'db1' => 'MDDS_ST'.$_SESSION['logindetails']['baseyear'].''),
			array( 'db' => '"STName'.$_SESSION['logindetails']['baseyear'].'"','dt' => 2,'db1' => 'STName'.$_SESSION['logindetails']['baseyear'].''),
			array( 'db' => '"STStatus'.$_SESSION['logindetails']['baseyear'].'"','dt' => 3,'db1' => 'STStatus'.$_SESSION['logindetails']['baseyear'].''),
			array( 'db' => '"DTID'.$_SESSION['logindetails']['baseyear'].'"','dt' => 4,'db1' => 'DTID'.$_SESSION['logindetails']['baseyear'].''),
			array( 'db' => '"MDDS_DT'.$_SESSION['logindetails']['baseyear'].'"','dt' => 5,'db1' => 'MDDS_DT'.$_SESSION['logindetails']['baseyear'].''),
			array( 'db' => '"DTName'.$_SESSION['logindetails']['baseyear'].'"','dt' => 6,'db1' => 'DTName'.$_SESSION['logindetails']['baseyear'].''),
			array( 'db' => '"SDID'.$_SESSION['logindetails']['baseyear'].'"','dt' => 7,'db1' => 'SDID'.$_SESSION['logindetails']['baseyear'].''),
			array( 'db' => '"MDDS_SD'.$_SESSION['logindetails']['baseyear'].'"','dt' => 8,'db1' => 'MDDS_SD'.$_SESSION['logindetails']['baseyear'].''),
			array( 'db' => '"SDName'.$_SESSION['logindetails']['baseyear'].'"','dt' => 9,'db1' => 'SDName'.$_SESSION['logindetails']['baseyear'].''),
			array( 'db' => '"MDDS_VT'.$_SESSION['logindetails']['baseyear'].'"','dt' => 10,'db1' => 'MDDS_VT'.$_SESSION['logindetails']['baseyear'].''),
			array( 'db' => '"VTName'.$_SESSION['logindetails']['baseyear'].'"','dt' => 11,'db1' => 'VTName'.$_SESSION['logindetails']['baseyear'].''),
			array( 'db' => '"Level'.$_SESSION['logindetails']['baseyear'].'"','dt' => 12,'db1' => 'Level'.$_SESSION['logindetails']['baseyear'].''),
			// array( 'db' => '"Status'.$_SESSION['logindetails']['baseyear'].'"','dt' => 12,'db1' => 'Status'.$_SESSION['logindetails']['baseyear'].''),
			 array( 'db' => '"Status'.$_SESSION['logindetails']['baseyear'].'"', 'dt' => 13,'db1' => 'Status'.$_SESSION['logindetails']['baseyear'].'',
                'formatter' => function( $d, $row ) {
                if (!is_null($d) && $d=='Village')
             	{
             		return 'RV';
             	}
             	else
             	{
             	return $d;	
             	}
                
                } ),
			 
		// submerge related forread issue 

				// array( 'db' => '"STID'.$acyearshort.'"','dt' => 1,'db1' => 'STID'.$acyearshort.''),		
				// array( 'db' => '"MDDS_DT'.$acyearshort.'"','dt' => 4,'db1' => 'MDDS_DT'.$acyearshort.''),		
				// array( 'db' => '"STName'.$acyearshort.'"','dt' => 2,'db1' => 'STName'.$acyearshort.''),
				// array( 'db' => '"DTName'.$acyearshort.'"','dt' => 5,'db1' => 'DTName'.$acyearshort.''),
				// array( 'db' => '"SDName'.$acyearshort.'"','dt' => 8,'db1' => 'SDName'.$acyearshort.''),
				// array( 'db' => '"MDDS_SD'.$acyearshort.'"','dt' => 7,'db1' => 'MDDS_SD'.$acyearshort.''),
				// array( 'db' => '"MDDS_VT'.$acyearshort.'"','dt' => 9,'db1' => 'MDDS_VT'.$acyearshort.''),
				// array( 'db' => '"VTName'.$acyearshort.'"','dt' => 10,'db1' => 'VTName'.$acyearshort.''),
				// array( 'db' => '"Level'.$acyearshort.'"','dt' => 11,'db1' => 'Level'.$acyearshort.''),
				// array( 'db' => '"Status'.$acyearshort.'"','dt' => 12,'db1' => 'Status'.$acyearshort.''),

			array( 'db' => '"VTID'.$_SESSION['logindetails']['baseyear'].'"','dt' => 14,'db1' => 'VTID'.$_SESSION['logindetails']['baseyear'].''),
			
			array( 'db' => '"STID'.$acyearshort.'"','dt' => 15,'db1' => 'STID'.$acyearshort.''),


			 array( 'db' => '"MDDS_ST'.$acyearshort.'"', 'dt' => 16,'db1' => 'MDDS_ST'.$acyearshort.'',
                'formatter' => function( $d, $row ) {
                	
                	//  print_r($row['is_deleted']);
                if ($row['is_deleted']==0)
             	{
             		return '';
             	}
             	else
             	{
             	return $d;	
             	}
                
                } ),
			 array( 'db' => '"STName'.$acyearshort.'"', 'dt' => 17,'db1' => 'STName'.$acyearshort.'',
                'formatter' => function( $d, $row ) {
                	
                	//  print_r($row['is_deleted']);
                if ($row['is_deleted']==0)
             	{
             		return '';
             	}
             	else
             	{
             	return $d;	
             	}
                
                } ),

				array( 'db' => '"STStatus'.$acyearshort.'"', 'dt' => 18,'db1' => 'STStatus'.$acyearshort.'',
				'formatter' => function( $d, $row ) {
					
					//  print_r($row['is_deleted']);
				if ($row['is_deleted']==0)
				{
					return '';
				}
				else
				{
				return $d;	
				}
				
				} ),

			// array( 'db' => '"MDDS_ST'.$acyearshort.'"','dt' => 15,'db1' => 'MDDS_ST'.$acyearshort.''),
			// array( 'db' => '"STName'.$acyearshort.'"','dt' => 16,'db1' => 'STName'.$acyearshort.''),
			array( 'db' => '"DTID'.$acyearshort.'"','dt' => 19,'db1' => 'DTID'.$acyearshort.''),
			array( 'db' => '"MDDS_DT'.$acyearshort.'"', 'dt' => 20,'db1' => 'MDDS_DT'.$acyearshort.'',
                'formatter' => function( $d, $row ) {
                	
                	//  print_r($row['is_deleted']);
                if ($row['is_deleted']==0)
             	{
             		return '';
             	}
             	else
             	{
             	return $d;	
             	}
                
                } ),
			array( 'db' => '"DTName'.$acyearshort.'"', 'dt' => 21,'db1' => 'DTName'.$acyearshort.'',
			
                'formatter' => function( $d, $row ) {
                	
                	//  print_r($row['is_deleted']);
                if ($row['is_deleted']==0)
             	{
             		return '';
             	}
             	else
             	{
             	return $d;	
             	}
                
                } ),
			// array( 'db' => '"MDDS_DT'.$acyearshort.'"','dt' => 18,'db1' => 'MDDS_DT'.$acyearshort.''),
			// array( 'db' => '"DTName'.$acyearshort.'"','dt' => 19,'db1' => 'DTName'.$acyearshort.''),
			array( 'db' => '"SDID'.$acyearshort.'"','dt' => 22,'db1' => 'SDID'.$acyearshort.''),
			array( 'db' => '"MDDS_SD'.$acyearshort.'"', 'dt' => 23,'db1' => 'MDDS_SD'.$acyearshort.'',
                'formatter' => function( $d, $row ) {
                	
                	//  print_r($row['is_deleted']);
                if ($row['is_deleted']==0)
             	{
             		return '';
             	}
             	else
             	{
             	return $d;	
             	}
                
                } ),
			array( 'db' => '"SDName'.$acyearshort.'"', 'dt' => 24,'db1' => 'SDName'.$acyearshort.'',
                'formatter' => function( $d, $row ) {
                	
                	//  print_r($row['is_deleted']);
                if ($row['is_deleted']==0)
             	{
             		return '';
             	}
             	else
             	{
             	return $d;	
             	}
                
                } ),
			// array( 'db' => '"MDDS_SD'.$acyearshort.'"','dt' => 21,'db1' => 'MDDS_SD'.$acyearshort.''),
			// array( 'db' => '"SDName'.$acyearshort.'"','dt' => 22,'db1' => 'SDName'.$acyearshort.''),
			array( 'db' => '"MDDS_VT'.$acyearshort.'"','dt' => 25,'db1' => 'MDDS_VT'.$acyearshort.''),
			array( 'db' => '"VTName'.$acyearshort.'"', 'dt' => 26,'db1' => 'VTName'.$acyearshort.'',
                'formatter' => function( $d, $row ) {
                	
                	//  print_r($row['is_deleted']);
                if ($row['is_deleted']==0)
             	{
             		return '';
             	}
             	else
             	{
             	return $d;	
             	}
                
                } ),
			array( 'db' => '"Level'.$acyearshort.'"', 'dt' => 27,'db1' => 'Level'.$acyearshort.'',
                'formatter' => function( $d, $row ) {
                	
                	//  print_r($row['is_deleted']);
                if ($row['is_deleted']==0)
             	{
             		return '';
             	}
             	else
             	{
             	return $d;	
             	}
                
                } ),
			array( 'db' => '"Status'.$acyearshort.'"', 'dt' => 28,'db1' => 'Status'.$acyearshort.'',
                'formatter' => function( $d, $row ) {
                	
                	//  print_r($row['is_deleted']);
                if ($row['is_deleted']==0)
             	{
             		return '';
             	}
             	else
             	{
             	return $d;	
             	}
                
                } ),
			
			// array( 'db' => '"VTName'.$acyearshort.'"','dt' => 24,'db1' => 'VTName'.$acyearshort.''),
			//array( 'db' => '"Level'.$acyearshort.'"','dt' => 25,'db1' => 'Level'.$acyearshort.''),
			// array( 'db' => '"Status'.$acyearshort.'"','dt' => 26,'db1' => 'Status'.$acyearshort.''),
			array( 'db' => '"VTID'.$acyearshort.'"','dt' => 29,'db1' => 'VTID'.$acyearshort.''),
			array( 'db' => '"VTID'.$acyearshort.'"','dt' => 30,'db1' => 'VTID'.$acyearshort.''),
			array( 'db' => '"is_deleted"','dt' => 31,'db1' => 'is_deleted'),
		

			);
}

// forread state leve code end 
else if($_POST['flag']=='DT')
{

	$cond='';
	$cond1='';
	$cond2=''; //forread by sahana
	$cond3=''; //forread by sahana
	$acyear=$_SESSION['activeyears'];
	$acyearshort = substr($acyear, -2);
	$olyear=$_SESSION['logindetails']['baseyear'];
		$array = array("stids"=>$_POST['stids'],"dtids"=>$_POST['dtids'],"sdids"=>$_POST['sdids']);
	// print_r($array);
	
	if($_SESSION['logindetails']['assignlist']!='')
	{
		if($_POST['stids']!='' &&  $_POST['dtids']=='' &&  $_POST['sdids']=='')
		{
				$cond = ' AND ( "fr21"."STID"='.$_SESSION['logindetails']['assignlist'].' OR "fr21"."STIDACTIVE"='.$_SESSION['logindetails']['assignlist'].' )';
				$cond1 = ' WHERE "STID"='.$_SESSION['logindetails']['assignlist'].'';

		}
		else if($_POST['stids']!='' &&  $_POST['dtids']!='' &&  $_POST['sdids']=='' )
		{
			

			$cond = ' AND ( "fr21"."STID"='.$_SESSION['logindetails']['assignlist'].' OR "fr21"."STIDACTIVE"='.$_SESSION['logindetails']['assignlist'].' ) AND ("fr21"."DTID"='.$_POST['dtids'].' OR "fr21"."DTIDACTIVE"='.$_POST['dtids'].')';
				$cond1 = ' WHERE "STID"='.$_POST['stids'].'';
		}
		else if($_POST['stids']!='' &&  $_POST['dtids']!='' &&  $_POST['sdids']!='' )
		{

			$cond = ' AND ( "fr21"."STID"='.$_SESSION['logindetails']['assignlist'].' OR "fr21"."STIDACTIVE"='.$_SESSION['logindetails']['assignlist'].' ) AND ("fr21"."DTID"='.$_POST['dtids'].' OR "fr21"."DTIDACTIVE"='.$_POST['dtids'].') AND ("fr21"."SDID"='.$_POST['sdids'].' OR "fr21"."SDIDACTIVE"='.$_POST['sdids'].')';
				$cond1 = ' WHERE "STID"='.$_POST['stids'].'';

			// $cond = ' AND "fr21"."STID"='.$_POST['stids'].' AND "fr21"."DTID"='.$_POST['dtids'].' AND "fr21"."SDID"='.$_POST['sdids'].'';
		}


			// $cond = ' AND "fr21"."STID"='.$_SESSION['logindetails']['assignlist'].'';
			// $cond1 = ' WHERE "STID"='.$_SESSION['logindetails']['assignlist'].'';
			
	}
	else
	{
		if($_POST['stids']!='' &&  $_POST['dtids']=='' &&  $_POST['sdids']=='')
		{
			$cond = ' AND ( "fr21"."STID"='.$_POST['stids'].' OR "fr21"."STIDACTIVE"='.$_POST['stids'].' )';
			$cond1 = ' WHERE "STID"='.$_POST['stids'].'';

			//by sahana forread state issue
			$stidActive = $_POST['stids'];
			$querystate = pg_prepare($db, "my_query", 'SELECT "frfromaction","frcomefrom","STID" FROM forreaddata2021 WHERE "STIDACTIVE" = $1');
			$resultstate = pg_execute($db, "my_query", array($stidActive));
			$rowstate = pg_fetch_assoc($resultstate);
			if ($rowstate) 
			{
				$cond2 = ' WHERE "STID"=' . $rowstate['STID'];
				$cond3=$cond2;
			}
			else {
				$cond1 = ' WHERE "STID"='.$_POST['stids'].'';
				$cond3=$cond1;
			}

		}
		else if($_POST['stids']!='' &&  $_POST['dtids']!='' &&  $_POST['sdids']=='' )
		{
			$cond = ' AND ( "fr21"."STID"='.$_POST['stids'].' OR "fr21"."STIDACTIVE"='.$_POST['stids'].' ) AND ("fr21"."DTID"='.$_POST['dtids'].' OR "fr21"."DTIDACTIVE"='.$_POST['dtids'].')';
				$cond1 = ' WHERE "STID"='.$_POST['stids'].'';
		}
		else if($_POST['stids']!='' &&  $_POST['dtids']!='' &&  $_POST['sdids']!='' )
		{
		$cond = ' AND ( "fr21"."STID"='.$_POST['stids'].' OR "fr21"."STIDACTIVE"='.$_POST['stids'].' ) AND ("fr21"."DTID"='.$_POST['dtids'].' OR "fr21"."DTIDACTIVE"='.$_POST['dtids'].') AND ("fr21"."SDID"='.$_POST['sdids'].' OR "fr21"."SDIDACTIVE"='.$_POST['sdids'].')';
			$cond1 = ' WHERE "STID"='.$_POST['stids'].'';
		}

	}
	

			$table = <<<EOT
			 (

			SELECT * FROM (select "VTIDACTIVE","frids","STID$olyear","STName$olyear","STStatus$olyear","MDDS_ST$olyear","DTID$olyear","DTName$olyear","MDDS_DT$olyear","SDID$olyear","SDName$olyear","MDDS_SD$olyear",
			"VTID$olyear","VTName$olyear","MDDS_VT$olyear","Level$olyear","Status$olyear","frcomment","comeaction","STID$acyearshort"
						
						,CASE
			            WHEN "frfromaction"='Sub-Merge'  THEN ''
			            ELSE "STName$acyearshort"
			       		END AS "STName$acyearshort"

						,CASE
						WHEN "frfromaction"='Sub-Merge'  THEN ''
						ELSE "STStatus$acyearshort"
						END AS "STStatus$acyearshort"

			       		,CASE
			            WHEN "frfromaction"='Sub-Merge'  THEN ''
			            ELSE "MDDS_ST$acyearshort"
			       		END AS "MDDS_ST$acyearshort"


						,"DTID$acyearshort"
						
						,CASE
			            WHEN "frfromaction"='Sub-Merge'  THEN ''
			            ELSE "DTName$acyearshort"
			       		END AS "DTName$acyearshort"

			       		,CASE
			            WHEN "frfromaction"='Sub-Merge'  THEN ''
			            ELSE "MDDS_DT$acyearshort"
			       		END AS "MDDS_DT$acyearshort"
			  			
						,"SDID$acyearshort"
						
						,CASE
			            WHEN "frfromaction"='Sub-Merge'  THEN ''
			            ELSE "SDName$acyearshort"
			       		END AS "SDName$acyearshort"

			       		,CASE
			            WHEN "frfromaction"='Sub-Merge'  THEN ''
			            ELSE "MDDS_SD$acyearshort"
			       		END AS "MDDS_SD$acyearshort"
			  			
			  			,"VTID$acyearshort"

			  			,CASE
			            WHEN "frfromaction"='Sub-Merge'  THEN ''
			            ELSE "VTName$acyearshort"
			       		END AS "VTName$acyearshort"

			       		,CASE
						   WHEN vt$acyear."is_deleted"=0  THEN ''
			            ELSE "MDDS_VT$acyearshort"
			        	END AS "MDDS_VT$acyearshort"
			        	,CASE
			            WHEN "frfromaction"='Sub-Merge'  THEN ''
			            ELSE "Level$acyearshort"
			        	END AS "Level$acyearshort"
			        	,CASE
			            WHEN "frfromaction"='Sub-Merge'  THEN ''
			            ELSE "Status$acyearshort"
			        	END AS "Status$acyearshort","is_deleted"

			from (select DISTINCT ON( fr$acyearshort."VTIDACTIVE") fr$acyearshort."VTIDACTIVE",fr$acyearshort."VTIDR",fr$acyearshort.frids,
						   fr$acyearshort.frcomment,fr$acyearshort.comeaction,fr$acyearshort.frfromaction
						   
						   from forreaddata20$acyearshort as fr$acyearshort
						   
						    WHERE fr$acyearshort."VTIDACTIVE"!=0 AND fr$acyearshort."VTIDACTIVE"=fr$acyearshort."VTIDR"  $cond AND fr$acyearshort."VTIDACTIVE"=fr$acyearshort."VTID"   ORDER BY "VTIDACTIVE", "frids" DESC) as frtab
						 INNER JOIN
			 (select "STID$acyearshort","STName$acyearshort","STStatus$acyearshort","MDDS_ST$acyearshort","DTID$acyearshort","DTName$acyearshort","MDDS_DT$acyearshort","SDID$acyearshort","SDName$acyearshort","MDDS_SD$acyearshort"
			  ,"VTID" as "VTID$acyearshort","VTName" as "VTName$acyearshort","MDDS_VT" as "MDDS_VT$acyearshort","Level" as "Level$acyearshort","Status" as "Status$acyearshort","is_deleted" from vt$acyear 
			  INNER JOIN (select "STID" AS "STID$acyearshort","STName" AS "STName$acyearshort","Status" AS "STStatus$acyearshort","MDDS_ST" AS "MDDS_ST$acyearshort" from st$acyear where is_deleted=1) as st$acyearshort ON st$acyearshort."STID$acyearshort"=vt$acyear."STID"
			INNER JOIN (select "DTID" AS "DTID$acyearshort","DTName" AS "DTName$acyearshort","MDDS_DT" AS "MDDS_DT$acyearshort" from dt$acyear where is_deleted=1) as dt$acyearshort ON dt$acyearshort."DTID$acyearshort"=vt$acyear."DTID"
			INNER JOIN (select "SDID" AS "SDID$acyearshort","SDName" AS "SDName$acyearshort","MDDS_SD" AS "MDDS_SD$acyearshort" from sd$acyear where is_deleted=1) as sd$acyearshort ON sd$acyearshort."SDID$acyearshort"=vt$acyear."SDID"
			    $cond1) as vt$acyear ON frtab."VTIDACTIVE" = vt$acyear."VTID$acyearshort" 
				
			LEFT JOIN
			 (select "STID$olyear","STName$olyear","STStatus$olyear","MDDS_ST$olyear","DTID$olyear","DTName$olyear","MDDS_DT$olyear","SDID$olyear","SDName$olyear","MDDS_SD$olyear"
			  ,"VTID" as "VTID$olyear","VTName" as "VTName$olyear","MDDS_VT" as "MDDS_VT$olyear","Level" as "Level$olyear","Status" as "Status$olyear" from vt$olyear 
			  INNER JOIN (select "STID" AS "STID$olyear","STName" AS "STName$olyear","Status" AS "STStatus$olyear","MDDS_ST" AS "MDDS_ST$olyear" from st$olyear) as st11 ON st11."STID$olyear"=vt$olyear."STID"
			INNER JOIN (select "DTID" AS "DTID$olyear","DTName" AS "DTName$olyear","MDDS_DT" AS "MDDS_DT$olyear" from dt$olyear) as dt11 ON dt11."DTID$olyear"=vt$olyear."DTID"
			INNER JOIN (select "SDID" AS "SDID$olyear","SDName" AS "SDName$olyear","MDDS_SD" AS "MDDS_SD$olyear" from sd$olyear) as sd11 ON sd11."SDID$olyear"=vt$olyear."SDID"
			    $cond3) as vt$olyear ON frtab."VTIDR" = vt$olyear."VTID$olyear") AS TAB1

			UNION ALL

			SELECT * FROM (select DISTINCT ( fr$acyearshort."VTIDACTIVE"),fr$acyearshort."frids",vt$olyear.*,fr$acyearshort.frcomment,fr$acyearshort.comeaction,vt$acyear.* from forreaddata$acyear as fr$acyearshort
			LEFT JOIN
			 (select "STID$olyear","STName$olyear","STStatus$olyear","MDDS_ST$olyear","DTID$olyear","DTName$olyear","MDDS_DT$olyear","SDID$olyear","SDName$olyear","MDDS_SD$olyear"
			  ,"VTID" as "VTID$olyear","VTName" as "VTName$olyear","MDDS_VT" as "MDDS_VT$olyear","Level" as "Level$olyear","Status" as "Status$olyear" from vt$olyear 
			  INNER JOIN (select "STID" AS "STID$olyear","STName" AS "STName$olyear","Status" AS "STStatus$olyear","MDDS_ST" AS "MDDS_ST$olyear" from st$olyear) as st11 ON st11."STID$olyear"=vt$olyear."STID"
			INNER JOIN (select "DTID" AS "DTID$olyear","DTName" AS "DTName$olyear","MDDS_DT" AS "MDDS_DT$olyear" from dt$olyear) as dt11 ON dt11."DTID$olyear"=vt$olyear."DTID"
			INNER JOIN (select "SDID" AS "SDID$olyear","SDName" AS "SDName$olyear","MDDS_SD" AS "MDDS_SD$olyear" from sd$olyear) as sd11 ON sd11."SDID$olyear"=vt$olyear."SDID"
			   $cond1) as vt$olyear ON fr$acyearshort."VTIDR" = vt$olyear."VTID$olyear"
			  
			  LEFT JOIN
			 (select "STID$acyearshort","STName$acyearshort", "STStatus$acyearshort","MDDS_ST$acyearshort","DTID$acyearshort","DTName$acyearshort","MDDS_DT$acyearshort","SDID$acyearshort","SDName$acyearshort","MDDS_SD$acyearshort"
			  ,"VTID" as "VTID$acyearshort","VTName" as "VTName$acyearshort","MDDS_VT" as "MDDS_VT$acyearshort","Level" as "Level$acyearshort","Status" as "Status$acyearshort","is_deleted" from vt$acyear 
			  INNER JOIN (select "STID" AS "STID$acyearshort","STName" AS "STName$acyearshort","Status" AS "STStatus$acyearshort","MDDS_ST" AS "MDDS_ST$acyearshort" from st$acyear) as st$acyearshort ON st$acyearshort."STID$acyearshort"=vt$acyear."STID"
			INNER JOIN (select "DTID" AS "DTID$acyearshort","DTName" AS "DTName$acyearshort","MDDS_DT" AS "MDDS_DT$acyearshort" from dt$acyear) as dt$acyearshort ON dt$acyearshort."DTID$acyearshort"=vt$acyear."DTID"
			INNER JOIN (select "SDID" AS "SDID$acyearshort","SDName" AS "SDName$acyearshort","MDDS_SD" AS "MDDS_SD$acyearshort" from sd$acyear) as sd$acyearshort ON sd$acyearshort."SDID$acyearshort"=vt$acyear."SDID"
			   $cond1) as vt$acyear ON fr$acyearshort."VTIDACTIVE" = vt$acyear."VTID$acyearshort"
			   WHERE fr$acyearshort."VTIDACTIVE"!=0   $cond AND fr$acyearshort."VTIDACTIVE"!=fr$acyearshort."VTIDR"  ORDER BY "VTIDACTIVE", "frids" DESC) AS TAB2

			    
			 ) temp
			EOT;


	// $table = <<<EOT
	// 		 (

	// 		SELECT * FROM (select "VTIDACTIVE","frids","STID$olyear","STName$olyear","MDDS_ST$olyear","DTID$olyear","DTName$olyear","MDDS_DT$olyear","SDID$olyear","SDName$olyear","MDDS_SD$olyear",
	// 		"VTID$olyear","VTName$olyear","MDDS_VT$olyear","frcomment","comeaction","STID$acyearshort"
						
	// 					,CASE
	// 		            WHEN "frfromaction"='Sub-Merge'  THEN ''
	// 		            ELSE "STName$acyearshort"
	// 		       		END AS "STName$acyearshort"

	// 		       		,CASE
	// 		            WHEN "frfromaction"='Sub-Merge'  THEN ''
	// 		            ELSE "MDDS_ST$acyearshort"
	// 		       		END AS "MDDS_ST$acyearshort"


	// 					,"DTID$acyearshort"
						
	// 					,CASE
	// 		            WHEN "frfromaction"='Sub-Merge'  THEN ''
	// 		            ELSE "DTName$acyearshort"
	// 		       		END AS "DTName$acyearshort"

	// 		       		,CASE
	// 		            WHEN "frfromaction"='Sub-Merge'  THEN ''
	// 		            ELSE "MDDS_DT$acyearshort"
	// 		       		END AS "MDDS_DT$acyearshort"
			  			
	// 					,"SDID$acyearshort"
						
	// 					,CASE
	// 		            WHEN "frfromaction"='Sub-Merge'  THEN ''
	// 		            ELSE "SDName$acyearshort"
	// 		       		END AS "SDName$acyearshort"

	// 		       		,CASE
	// 		            WHEN "frfromaction"='Sub-Merge'  THEN ''
	// 		            ELSE "MDDS_SD$acyearshort"
	// 		       		END AS "MDDS_SD$acyearshort"
			  			
	// 		  			,"VTID$acyearshort"

	// 		  			,CASE
	// 		            WHEN "frfromaction"='Sub-Merge'  THEN ''
	// 		            ELSE "VTName$acyearshort"
	// 		       		END AS "VTName$acyearshort"

	// 		       		,CASE
	// 		            WHEN "frfromaction"='Sub-Merge'  THEN ''
	// 		            ELSE "MDDS_VT$acyearshort"
	// 		        	END AS "MDDS_VT$acyearshort"

	// 		from (select DISTINCT ON( fr$acyearshort."VTIDACTIVE") fr$acyearshort."VTIDACTIVE",fr$acyearshort."SDIDACTIVE",fr$acyearshort."DTIDACTIVE",fr$acyearshort."VTIDR",fr$acyearshort.frids,
	// 					   fr$acyearshort.frcomment,fr$acyearshort.comeaction,fr$acyearshort.frfromaction
						   
	// 					   from forreaddata20$acyearshort as fr$acyearshort
						   
	// 					    WHERE $cond AND fr$acyearshort."VTIDACTIVE"=fr$acyearshort."VTID"   ORDER BY "VTIDACTIVE", "frids" DESC) as frtab
	// 					 INNER JOIN
	// 		 (select "STID$acyearshort","STName$acyearshort","MDDS_ST$acyearshort","DTID$acyearshort","DTName$acyearshort","MDDS_DT$acyearshort","SDID$acyearshort","SDName$acyearshort","MDDS_SD$acyearshort"
	// 		  ,"VTID" as "VTID$acyearshort","VTName" as "VTName$acyearshort","MDDS_VT" as "MDDS_VT$acyearshort" from vt$acyear 
	// 		  INNER JOIN (select "STID" AS "STID$acyearshort","STName" AS "STName$acyearshort","MDDS_ST" AS "MDDS_ST$acyearshort" from st$acyear where is_deleted=1) as st$acyearshort ON st$acyearshort."STID$acyearshort"=vt$acyear."STID"
	// 		INNER JOIN (select "DTID" AS "DTID$acyearshort","DTName" AS "DTName$acyearshort","MDDS_DT" AS "MDDS_DT$acyearshort" from dt$acyear where is_deleted=1) as dt$acyearshort ON dt$acyearshort."DTID$acyearshort"=vt$acyear."DTID"
	// 		INNER JOIN (select "SDID" AS "SDID$acyearshort","SDName" AS "SDName$acyearshort","MDDS_SD" AS "MDDS_SD$acyearshort" from sd$acyear where is_deleted=1) as sd$acyearshort ON sd$acyearshort."SDID$acyearshort"=vt$acyear."SDID"
	// 		    $cond1) as vt$acyear INNER JOIN
	// 		 (select "STID$olyear","STName$olyear","MDDS_ST$olyear","DTID$olyear","DTName$olyear","MDDS_DT$olyear","SDID$olyear","SDName$olyear","MDDS_SD$olyear"
	// 		  ,"VTID" as "VTID$olyear","VTName" as "VTName$olyear","MDDS_VT" as "MDDS_VT$olyear" from vt$olyear 
	// 		  INNER JOIN (select "STID" AS "STID$olyear","STName" AS "STName$olyear","MDDS_ST" AS "MDDS_ST$olyear" from st$olyear) as st11 ON st11."STID$olyear"=vt$olyear."STID"
	// 		INNER JOIN (select "DTID" AS "DTID$olyear","DTName" AS "DTName$olyear","MDDS_DT" AS "MDDS_DT$olyear" from dt$olyear) as dt11 ON dt11."DTID$olyear"=vt$olyear."DTID"
	// 		INNER JOIN (select "SDID" AS "SDID$olyear","SDName" AS "SDName$olyear","MDDS_SD" AS "MDDS_SD$olyear" from sd$olyear) as sd11 ON sd11."SDID$olyear"=vt$olyear."SDID"
	// 		    $cond1) as vt$olyear ON vt$olyear."VTID$olyear" = vt$acyear."VTID$acyearshort" ON frtab."VTIDACTIVE" = vt$acyear."VTID$acyearshort" OR frtab."SDIDACTIVE" = vt$acyear."SDID$acyearshort" OR frtab."DTIDACTIVE" = vt$acyear."DTID$acyearshort" 
				
	// 		) AS TAB1

	// 		UNION ALL

	// 		SELECT * FROM (select DISTINCT ( fr$acyearshort."VTIDACTIVE"),fr$acyearshort."frids",vt$olyear.*,fr$acyearshort.frcomment,fr$acyearshort.comeaction,vt$acyear.* from forreaddata$acyear as fr$acyearshort
	// 		LEFT JOIN
	// 		 (select "STID$olyear","STName$olyear","MDDS_ST$olyear","DTID$olyear","DTName$olyear","MDDS_DT$olyear","SDID$olyear","SDName$olyear","MDDS_SD$olyear"
	// 		  ,"VTID" as "VTID$olyear","VTName" as "VTName$olyear","MDDS_VT" as "MDDS_VT$olyear" from vt$olyear 
	// 		  INNER JOIN (select "STID" AS "STID$olyear","STName" AS "STName$olyear","MDDS_ST" AS "MDDS_ST$olyear" from st$olyear) as st11 ON st11."STID$olyear"=vt$olyear."STID"
	// 		INNER JOIN (select "DTID" AS "DTID$olyear","DTName" AS "DTName$olyear","MDDS_DT" AS "MDDS_DT$olyear" from dt$olyear) as dt11 ON dt11."DTID$olyear"=vt$olyear."DTID"
	// 		INNER JOIN (select "SDID" AS "SDID$olyear","SDName" AS "SDName$olyear","MDDS_SD" AS "MDDS_SD$olyear" from sd$olyear) as sd11 ON sd11."SDID$olyear"=vt$olyear."SDID"
	// 		   $cond1) as vt$olyear ON fr$acyearshort."VTIDR" = vt$olyear."VTID$olyear"
			  
	// 		  LEFT JOIN
	// 		 (select "STID$acyearshort","STName$acyearshort","MDDS_ST$acyearshort","DTID$acyearshort","DTName$acyearshort","MDDS_DT$acyearshort","SDID$acyearshort","SDName$acyearshort","MDDS_SD$acyearshort"
	// 		  ,"VTID" as "VTID$acyearshort","VTName" as "VTName$acyearshort","MDDS_VT" as "MDDS_VT$acyearshort" from vt$acyear 
	// 		  INNER JOIN (select "STID" AS "STID$acyearshort","STName" AS "STName$acyearshort","MDDS_ST" AS "MDDS_ST$acyearshort" from st$acyear) as st$acyearshort ON st$acyearshort."STID$acyearshort"=vt$acyear."STID"
	// 		INNER JOIN (select "DTID" AS "DTID$acyearshort","DTName" AS "DTName$acyearshort","MDDS_DT" AS "MDDS_DT$acyearshort" from dt$acyear) as dt$acyearshort ON dt$acyearshort."DTID$acyearshort"=vt$acyear."DTID"
	// 		INNER JOIN (select "SDID" AS "SDID$acyearshort","SDName" AS "SDName$acyearshort","MDDS_SD" AS "MDDS_SD$acyearshort" from sd$acyear) as sd$acyearshort ON sd$acyearshort."SDID$acyearshort"=vt$acyear."SDID"
	// 		   $cond1) as vt$acyear ON fr$acyearshort."VTIDACTIVE" = vt$acyear."VTID$acyearshort"
	// 		   WHERE $cond AND fr$acyearshort."VTIDACTIVE"!=fr$acyearshort."VTID"  ORDER BY "VTIDACTIVE", "frids" DESC) AS TAB2

			    
	// 		 ) temp
	// 		EOT;


			$columns = array(
			array( 'db' => '"STID'.$_SESSION['logindetails']['baseyear'].'"','dt' => 0,'db1' => 'STID'.$_SESSION['logindetails']['baseyear'].''),
			array( 'db' => '"MDDS_ST'.$_SESSION['logindetails']['baseyear'].'"','dt' => 1,'db1' => 'MDDS_ST'.$_SESSION['logindetails']['baseyear'].''),
			array( 'db' => '"STName'.$_SESSION['logindetails']['baseyear'].'"','dt' => 2,'db1' => 'STName'.$_SESSION['logindetails']['baseyear'].''),
			array( 'db' => '"STStatus'.$_SESSION['logindetails']['baseyear'].'"','dt' => 3,'db1' => 'STStatus'.$_SESSION['logindetails']['baseyear'].''),
			array( 'db' => '"DTID'.$_SESSION['logindetails']['baseyear'].'"','dt' => 4,'db1' => 'DTID'.$_SESSION['logindetails']['baseyear'].''),
			array( 'db' => '"MDDS_DT'.$_SESSION['logindetails']['baseyear'].'"','dt' => 5,'db1' => 'MDDS_DT'.$_SESSION['logindetails']['baseyear'].''),
			array( 'db' => '"DTName'.$_SESSION['logindetails']['baseyear'].'"','dt' => 6,'db1' => 'DTName'.$_SESSION['logindetails']['baseyear'].''),
			array( 'db' => '"SDID'.$_SESSION['logindetails']['baseyear'].'"','dt' => 7,'db1' => 'SDID'.$_SESSION['logindetails']['baseyear'].''),
			array( 'db' => '"MDDS_SD'.$_SESSION['logindetails']['baseyear'].'"','dt' => 8,'db1' => 'MDDS_SD'.$_SESSION['logindetails']['baseyear'].''),
			array( 'db' => '"SDName'.$_SESSION['logindetails']['baseyear'].'"','dt' => 9,'db1' => 'SDName'.$_SESSION['logindetails']['baseyear'].''),
			array( 'db' => '"MDDS_VT'.$_SESSION['logindetails']['baseyear'].'"','dt' => 10,'db1' => 'MDDS_VT'.$_SESSION['logindetails']['baseyear'].''),
			array( 'db' => '"VTName'.$_SESSION['logindetails']['baseyear'].'"','dt' => 11,'db1' => 'VTName'.$_SESSION['logindetails']['baseyear'].''),
			array( 'db' => '"Level'.$_SESSION['logindetails']['baseyear'].'"','dt' => 12,'db1' => 'Level'.$_SESSION['logindetails']['baseyear'].''),
			// array( 'db' => '"Status'.$_SESSION['logindetails']['baseyear'].'"','dt' => 12,'db1' => 'Status'.$_SESSION['logindetails']['baseyear'].''),
			 array( 'db' => '"Status'.$_SESSION['logindetails']['baseyear'].'"', 'dt' => 13,'db1' => 'Status'.$_SESSION['logindetails']['baseyear'].'',
                'formatter' => function( $d, $row ) {
                if (!is_null($d) && $d=='Village')
             	{
             		return 'RV';
             	}
             	else
             	{
             	return $d;	
             	}
                
                } ),
			 

			array( 'db' => '"VTID'.$_SESSION['logindetails']['baseyear'].'"','dt' => 14,'db1' => 'VTID'.$_SESSION['logindetails']['baseyear'].''),
			
			array( 'db' => '"STID'.$acyearshort.'"','dt' => 15,'db1' => 'STID'.$acyearshort.''),
			 array( 'db' => '"MDDS_ST'.$acyearshort.'"', 'dt' => 16,'db1' => 'MDDS_ST'.$acyearshort.'',
                'formatter' => function( $d, $row ) {
                	
                	//  print_r($row['is_deleted']);
                if ($row['is_deleted']==0)
             	{
             		return '';
             	}
             	else
             	{
             	return $d;	
             	}
                
                } ),
			 array( 'db' => '"STName'.$acyearshort.'"', 'dt' => 17,'db1' => 'STName'.$acyearshort.'',
                'formatter' => function( $d, $row ) {
                	
                	//  print_r($row['is_deleted']);
                if ($row['is_deleted']==0)
             	{
             		return '';
             	}
             	else
             	{
             	return $d;	
             	}
                
                } ),

				
				array( 'db' => '"STStatus'.$acyearshort.'"', 'dt' => 18,'db1' => 'STStatus'.$acyearshort.'',
				'formatter' => function( $d, $row ) {
					
					//  print_r($row['is_deleted']);
				if ($row['is_deleted']==0)
				{
					return '';
				}
				else
				{
				return $d;	
				}
				
				} ),

			// array( 'db' => '"MDDS_ST'.$acyearshort.'"','dt' => 15,'db1' => 'MDDS_ST'.$acyearshort.''),
			// array( 'db' => '"STName'.$acyearshort.'"','dt' => 16,'db1' => 'STName'.$acyearshort.''),
			array( 'db' => '"DTID'.$acyearshort.'"','dt' => 19,'db1' => 'DTID'.$acyearshort.''),
			array( 'db' => '"MDDS_DT'.$acyearshort.'"', 'dt' => 20,'db1' => 'MDDS_DT'.$acyearshort.'',
                'formatter' => function( $d, $row ) {
                	
                	//  print_r($row['is_deleted']);
                if ($row['is_deleted']==0)
             	{
             		return '';
             	}
             	else
             	{
             	return $d;	
             	}
                
                } ),
			array( 'db' => '"DTName'.$acyearshort.'"', 'dt' => 21,'db1' => 'DTName'.$acyearshort.'',
                'formatter' => function( $d, $row ) {
                	
                	//  print_r($row['is_deleted']);
                if ($row['is_deleted']==0)
             	{
             		return '';
             	}
             	else
             	{
             	return $d;	
             	}
                
                } ),
			// array( 'db' => '"MDDS_DT'.$acyearshort.'"','dt' => 18,'db1' => 'MDDS_DT'.$acyearshort.''),
			// array( 'db' => '"DTName'.$acyearshort.'"','dt' => 19,'db1' => 'DTName'.$acyearshort.''),
			array( 'db' => '"SDID'.$acyearshort.'"','dt' => 22,'db1' => 'SDID'.$acyearshort.''),
			array( 'db' => '"MDDS_SD'.$acyearshort.'"', 'dt' => 23,'db1' => 'MDDS_SD'.$acyearshort.'',
                'formatter' => function( $d, $row ) {
                	
                	//  print_r($row['is_deleted']);
                if ($row['is_deleted']==0)
             	{
             		return '';
             	}
             	else
             	{
             	return $d;	
             	}
                
                } ),
			array( 'db' => '"SDName'.$acyearshort.'"', 'dt' => 24,'db1' => 'SDName'.$acyearshort.'',
                'formatter' => function( $d, $row ) {
                	
                	//  print_r($row['is_deleted']);
                if ($row['is_deleted']==0)
             	{
             		return '';
             	}
             	else
             	{
             	return $d;	
             	}
                
                } ),
			// array( 'db' => '"MDDS_SD'.$acyearshort.'"','dt' => 21,'db1' => 'MDDS_SD'.$acyearshort.''),
			// array( 'db' => '"SDName'.$acyearshort.'"','dt' => 22,'db1' => 'SDName'.$acyearshort.''),
			array( 'db' => '"MDDS_VT'.$acyearshort.'"','dt' => 25,'db1' => 'MDDS_VT'.$acyearshort.''),
			array( 'db' => '"VTName'.$acyearshort.'"', 'dt' => 26,'db1' => 'VTName'.$acyearshort.'',
                'formatter' => function( $d, $row ) {
                	
                	//  print_r($row['is_deleted']);
                if ($row['is_deleted']==0)
             	{
             		return '';
             	}
             	else
             	{
             	return $d;	
             	}
                
                } ),
			array( 'db' => '"Level'.$acyearshort.'"', 'dt' => 27,'db1' => 'Level'.$acyearshort.'',
                'formatter' => function( $d, $row ) {
                	
                	//  print_r($row['is_deleted']);
                if ($row['is_deleted']==0)
             	{
             		return '';
             	}
             	else
             	{
             	return $d;	
             	}
                
                } ),
			array( 'db' => '"Status'.$acyearshort.'"', 'dt' => 28,'db1' => 'Status'.$acyearshort.'',
                'formatter' => function( $d, $row ) {
                	
                	//  print_r($row['is_deleted']);
                if ($row['is_deleted']==0)
             	{
             		return '';
             	}
             	else
             	{
             	return $d;	
             	}
                
                } ),
			
			// array( 'db' => '"VTName'.$acyearshort.'"','dt' => 24,'db1' => 'VTName'.$acyearshort.''),
			//array( 'db' => '"Level'.$acyearshort.'"','dt' => 25,'db1' => 'Level'.$acyearshort.''),
			// array( 'db' => '"Status'.$acyearshort.'"','dt' => 26,'db1' => 'Status'.$acyearshort.''),
			array( 'db' => '"VTID'.$acyearshort.'"','dt' => 29,'db1' => 'VTID'.$acyearshort.''),
			array( 'db' => '"VTID'.$acyearshort.'"','dt' => 30,'db1' => 'VTID'.$acyearshort.''),
			array( 'db' => '"is_deleted"','dt' => 31,'db1' => 'is_deleted'),
		

			);
}
else if($_POST['flag']=='SD')
{
	
	$cond='';
	$cond1='';
	$cond2=''; //forread by sahana
	$cond3=''; //forread by sahana
	$acyear=$_SESSION['activeyears'];
	$acyearshort = substr($acyear, -2);
	$olyear=$_SESSION['logindetails']['baseyear'];
		$array = array("stids"=>$_POST['stids'],"dtids"=>$_POST['dtids'],"sdids"=>$_POST['sdids']);
		//  print_r($array);
	if($_SESSION['logindetails']['assignlist']!='')
	{
		if($_POST['stids']!='' &&  $_POST['dtids']=='' &&  $_POST['sdids']=='')
		{
				$cond = ' AND ( "fr21"."STID"='.$_SESSION['logindetails']['assignlist'].' OR "fr21"."STIDACTIVE"='.$_SESSION['logindetails']['assignlist'].' )';
				$cond1 = ' WHERE "STID"='.$_SESSION['logindetails']['assignlist'].'';

		}
		else if($_POST['stids']!='' &&  $_POST['dtids']!='' &&  $_POST['sdids']=='' )
		{
			

			$cond = ' AND ( "fr21"."STID"='.$_SESSION['logindetails']['assignlist'].' OR "fr21"."STIDACTIVE"='.$_SESSION['logindetails']['assignlist'].' ) AND ("fr21"."DTID"='.$_POST['dtids'].' OR "fr21"."DTIDACTIVE"='.$_POST['dtids'].')';
				$cond1 = ' WHERE "STID"='.$_POST['stids'].'';
		}
		else if($_POST['stids']!='' &&  $_POST['dtids']!='' &&  $_POST['sdids']!='' )
		{

			$cond = ' AND ( "fr21"."STID"='.$_SESSION['logindetails']['assignlist'].' OR "fr21"."STIDACTIVE"='.$_SESSION['logindetails']['assignlist'].' ) AND ("fr21"."DTID"='.$_POST['dtids'].' OR "fr21"."DTIDACTIVE"='.$_POST['dtids'].') AND ("fr21"."SDID"='.$_POST['sdids'].' OR "fr21"."SDIDACTIVE"='.$_POST['sdids'].')';
				$cond1 = ' WHERE "STID"='.$_POST['stids'].'';

			// $cond = ' AND "fr21"."STID"='.$_POST['stids'].' AND "fr21"."DTID"='.$_POST['dtids'].' AND "fr21"."SDID"='.$_POST['sdids'].'';
		}


			// $cond = ' AND "fr21"."STID"='.$_SESSION['logindetails']['assignlist'].'';
			// $cond1 = ' WHERE "STID"='.$_SESSION['logindetails']['assignlist'].'';
			
	}
	else
	{
		if($_POST['stids']!='' &&  $_POST['dtids']=='' &&  $_POST['sdids']=='')
		{
			$cond = ' AND ( "fr21"."STID"='.$_POST['stids'].' OR "fr21"."STIDACTIVE"='.$_POST['stids'].' )';
			$cond1 = ' WHERE "STID"='.$_POST['stids'].'';

			//by sahana forread state issue
			$stidActive = $_POST['stids'];
			$querystate = pg_prepare($db, "my_query", 'SELECT "frfromaction","frcomefrom","STID" FROM forreaddata2021 WHERE "STIDACTIVE" = $1');
			$resultstate = pg_execute($db, "my_query", array($stidActive));
			$rowstate = pg_fetch_assoc($resultstate);
			if ($rowstate) 
			{
				$cond2 = ' WHERE "STID"=' . $rowstate['STID'];
				$cond3=$cond2;
			}
			else {
				$cond1 = ' WHERE "STID"='.$_POST['stids'].'';
				$cond3=$cond1;
			}

			//by sahana forread state issue
			$stidActive = $_POST['stids'];
			$querystate = pg_prepare($db, "my_query", 'SELECT "frfromaction","frcomefrom","STID" FROM forreaddata2021 WHERE "STIDACTIVE" = $1');
			$resultstate = pg_execute($db, "my_query", array($stidActive));
			$rowstate = pg_fetch_assoc($resultstate);
			if ($rowstate) 
			{
				$cond2 = ' WHERE "STID"=' . $rowstate['STID'];
				$cond3=$cond2;
			}
			else {
				$cond1 = ' WHERE "STID"='.$_POST['stids'].'';
				$cond3=$cond1;
			}

		}
		else if($_POST['stids']!='' &&  $_POST['dtids']!='' &&  $_POST['sdids']=='' )
		{
			$cond = ' AND ( "fr21"."STID"='.$_POST['stids'].' OR "fr21"."STIDACTIVE"='.$_POST['stids'].' ) AND ("fr21"."DTID"='.$_POST['dtids'].' OR "fr21"."DTIDACTIVE"='.$_POST['dtids'].')';
				$cond1 = ' WHERE "STID"='.$_POST['stids'].'';
		}
		else if($_POST['stids']!='' &&  $_POST['dtids']!='' &&  $_POST['sdids']!='' )
		{
		$cond = ' AND ( "fr21"."STID"='.$_POST['stids'].' OR "fr21"."STIDACTIVE"='.$_POST['stids'].' ) AND ("fr21"."DTID"='.$_POST['dtids'].' OR "fr21"."DTIDACTIVE"='.$_POST['dtids'].') AND ("fr21"."SDID"='.$_POST['sdids'].' OR "fr21"."SDIDACTIVE"='.$_POST['sdids'].')';
			$cond1 = ' WHERE "STID"='.$_POST['stids'].'';
		}

	}
	

			$table = <<<EOT
			 (

			SELECT * FROM (select "VTIDACTIVE","frids","STID$olyear","STName$olyear","STStatus$olyear","MDDS_ST$olyear","DTID$olyear","DTName$olyear","MDDS_DT$olyear","SDID$olyear","SDName$olyear","MDDS_SD$olyear",
			"VTID$olyear","VTName$olyear","MDDS_VT$olyear","Level$olyear","Status$olyear","frcomment","comeaction","STID$acyearshort"
						
						,CASE
			            WHEN "frfromaction"='Sub-Merge'  THEN ''
			            ELSE "STName$acyearshort"
			       		END AS "STName$acyearshort"

						 ,CASE
						 WHEN "frfromaction"='Sub-Merge'  THEN ''
						 ELSE "STStatus$acyearshort"
						 END AS "STStatus$acyearshort"

			       		,CASE
			            WHEN "frfromaction"='Sub-Merge'  THEN ''
			            ELSE "MDDS_ST$acyearshort"
			       		END AS "MDDS_ST$acyearshort"


						,"DTID$acyearshort"
						
						,CASE
			            WHEN "frfromaction"='Sub-Merge'  THEN ''
			            ELSE "DTName$acyearshort"
			       		END AS "DTName$acyearshort"

			       		,CASE
			            WHEN "frfromaction"='Sub-Merge'  THEN ''
			            ELSE "MDDS_DT$acyearshort"
			       		END AS "MDDS_DT$acyearshort"
			  			
						,"SDID$acyearshort"
						
						,CASE
			            WHEN "frfromaction"='Sub-Merge'  THEN ''
			            ELSE "SDName$acyearshort"
			       		END AS "SDName$acyearshort"

			       		,CASE
			            WHEN "frfromaction"='Sub-Merge'  THEN ''
			            ELSE "MDDS_SD$acyearshort"
			       		END AS "MDDS_SD$acyearshort"
			  			
			  			,"VTID$acyearshort"

			  			,CASE
			            WHEN "frfromaction"='Sub-Merge'  THEN ''
			            ELSE "VTName$acyearshort"
			       		END AS "VTName$acyearshort"

			       		,CASE
						   WHEN vt$acyear."is_deleted"=0  THEN ''
			            ELSE "MDDS_VT$acyearshort"
			        	END AS "MDDS_VT$acyearshort"
			        	,CASE
			            WHEN "frfromaction"='Sub-Merge'  THEN ''
			            ELSE "Level$acyearshort"
			        	END AS "Level$acyearshort"
			        	,CASE
			            WHEN "frfromaction"='Sub-Merge'  THEN ''
			            ELSE "Status$acyearshort"
			        	END AS "Status$acyearshort","is_deleted"

			from (select DISTINCT ON( fr$acyearshort."VTIDACTIVE") fr$acyearshort."VTIDACTIVE",fr$acyearshort."VTIDR",fr$acyearshort.frids,
						   fr$acyearshort.frcomment,fr$acyearshort.comeaction,fr$acyearshort.frfromaction
						   
						   from forreaddata20$acyearshort as fr$acyearshort
						   
						    WHERE fr$acyearshort."VTIDACTIVE"!=0  AND fr$acyearshort."VTIDACTIVE"=fr$acyearshort."VTIDR" $cond AND fr$acyearshort."VTIDACTIVE"=fr$acyearshort."VTID"   ORDER BY "VTIDACTIVE", "frids" DESC) as frtab
						 INNER JOIN
			 (select "STID$acyearshort","STName$acyearshort","STStatus$acyearshort","MDDS_ST$acyearshort","DTID$acyearshort","DTName$acyearshort","MDDS_DT$acyearshort","SDID$acyearshort","SDName$acyearshort","MDDS_SD$acyearshort"
			  ,"VTID" as "VTID$acyearshort","VTName" as "VTName$acyearshort","MDDS_VT" as "MDDS_VT$acyearshort","Level" as "Level$acyearshort","Status" as "Status$acyearshort","is_deleted" from vt$acyear 
			  INNER JOIN (select "STID" AS "STID$acyearshort","STName" AS "STName$acyearshort","Status" AS "STStatus$acyearshort","MDDS_ST" AS "MDDS_ST$acyearshort" from st$acyear where is_deleted=1) as st$acyearshort ON st$acyearshort."STID$acyearshort"=vt$acyear."STID"
			INNER JOIN (select "DTID" AS "DTID$acyearshort","DTName" AS "DTName$acyearshort","MDDS_DT" AS "MDDS_DT$acyearshort" from dt$acyear where is_deleted=1) as dt$acyearshort ON dt$acyearshort."DTID$acyearshort"=vt$acyear."DTID"
			INNER JOIN (select "SDID" AS "SDID$acyearshort","SDName" AS "SDName$acyearshort","MDDS_SD" AS "MDDS_SD$acyearshort" from sd$acyear where is_deleted=1) as sd$acyearshort ON sd$acyearshort."SDID$acyearshort"=vt$acyear."SDID"
			    $cond1) as vt$acyear ON frtab."VTIDACTIVE" = vt$acyear."VTID$acyearshort" 
				
			LEFT JOIN
			 (select "STID$olyear","STName$olyear","STStatus$olyear","MDDS_ST$olyear","DTID$olyear","DTName$olyear","MDDS_DT$olyear","SDID$olyear","SDName$olyear","MDDS_SD$olyear"
			  ,"VTID" as "VTID$olyear","VTName" as "VTName$olyear","MDDS_VT" as "MDDS_VT$olyear","Level" as "Level$olyear","Status" as "Status$olyear" from vt$olyear 
			  INNER JOIN (select "STID" AS "STID$olyear","STName" AS "STName$olyear","Status" AS "STStatus$olyear","MDDS_ST" AS "MDDS_ST$olyear" from st$olyear) as st11 ON st11."STID$olyear"=vt$olyear."STID"
			INNER JOIN (select "DTID" AS "DTID$olyear","DTName" AS "DTName$olyear","MDDS_DT" AS "MDDS_DT$olyear" from dt$olyear) as dt11 ON dt11."DTID$olyear"=vt$olyear."DTID"
			INNER JOIN (select "SDID" AS "SDID$olyear","SDName" AS "SDName$olyear","MDDS_SD" AS "MDDS_SD$olyear" from sd$olyear) as sd11 ON sd11."SDID$olyear"=vt$olyear."SDID"
			    $cond3) as vt$olyear ON frtab."VTIDR" = vt$olyear."VTID$olyear") AS TAB1

			UNION ALL

			SELECT * FROM (select DISTINCT ( fr$acyearshort."VTIDACTIVE"),fr$acyearshort."frids",vt$olyear.*,fr$acyearshort.frcomment,fr$acyearshort.comeaction,vt$acyear.* from forreaddata$acyear as fr$acyearshort
			LEFT JOIN
			 (select "STID$olyear","STName$olyear","STStatus$olyear","MDDS_ST$olyear","DTID$olyear","DTName$olyear","MDDS_DT$olyear","SDID$olyear","SDName$olyear","MDDS_SD$olyear"
			  ,"VTID" as "VTID$olyear","VTName" as "VTName$olyear","MDDS_VT" as "MDDS_VT$olyear","Level" as "Level$olyear","Status" as "Status$olyear" from vt$olyear 
			  INNER JOIN (select "STID" AS "STID$olyear","STName" AS "STName$olyear","Status" AS "STStatus$olyear","MDDS_ST" AS "MDDS_ST$olyear" from st$olyear) as st11 ON st11."STID$olyear"=vt$olyear."STID"
			INNER JOIN (select "DTID" AS "DTID$olyear","DTName" AS "DTName$olyear","MDDS_DT" AS "MDDS_DT$olyear" from dt$olyear) as dt11 ON dt11."DTID$olyear"=vt$olyear."DTID"
			INNER JOIN (select "SDID" AS "SDID$olyear","SDName" AS "SDName$olyear","MDDS_SD" AS "MDDS_SD$olyear" from sd$olyear) as sd11 ON sd11."SDID$olyear"=vt$olyear."SDID"
			   $cond1) as vt$olyear ON fr$acyearshort."VTIDR" = vt$olyear."VTID$olyear"
			  
			  LEFT JOIN
			 (select "STID$acyearshort","STName$acyearshort","STStatus$acyearshort","MDDS_ST$acyearshort","DTID$acyearshort","DTName$acyearshort","MDDS_DT$acyearshort","SDID$acyearshort","SDName$acyearshort","MDDS_SD$acyearshort"
			  ,"VTID" as "VTID$acyearshort","VTName" as "VTName$acyearshort","MDDS_VT" as "MDDS_VT$acyearshort","Level" as "Level$acyearshort","Status" as "Status$acyearshort","is_deleted" from vt$acyear 
			  INNER JOIN (select "STID" AS "STID$acyearshort","STName" AS "STName$acyearshort","Status" AS "STStatus$acyearshort","MDDS_ST" AS "MDDS_ST$acyearshort" from st$acyear) as st$acyearshort ON st$acyearshort."STID$acyearshort"=vt$acyear."STID"
			INNER JOIN (select "DTID" AS "DTID$acyearshort","DTName" AS "DTName$acyearshort","MDDS_DT" AS "MDDS_DT$acyearshort" from dt$acyear) as dt$acyearshort ON dt$acyearshort."DTID$acyearshort"=vt$acyear."DTID"
			INNER JOIN (select "SDID" AS "SDID$acyearshort","SDName" AS "SDName$acyearshort","MDDS_SD" AS "MDDS_SD$acyearshort" from sd$acyear) as sd$acyearshort ON sd$acyearshort."SDID$acyearshort"=vt$acyear."SDID"
			   $cond1) as vt$acyear ON fr$acyearshort."VTIDACTIVE" = vt$acyear."VTID$acyearshort"
			   WHERE fr$acyearshort."VTIDACTIVE"!=0   $cond AND fr$acyearshort."VTIDACTIVE"!=fr$acyearshort."VTIDR"  ORDER BY "VTIDACTIVE", "frids" DESC) AS TAB2

			    
			 ) temp
			EOT;

			$columns = array(
			array( 'db' => '"STID'.$_SESSION['logindetails']['baseyear'].'"','dt' => 0,'db1' => 'STID'.$_SESSION['logindetails']['baseyear'].''),
			array( 'db' => '"MDDS_ST'.$_SESSION['logindetails']['baseyear'].'"','dt' => 1,'db1' => 'MDDS_ST'.$_SESSION['logindetails']['baseyear'].''),
			array( 'db' => '"STName'.$_SESSION['logindetails']['baseyear'].'"','dt' => 2,'db1' => 'STName'.$_SESSION['logindetails']['baseyear'].''),
			array( 'db' => '"STStatus'.$_SESSION['logindetails']['baseyear'].'"','dt' => 3,'db1' => 'STStatus'.$_SESSION['logindetails']['baseyear'].''),
			array( 'db' => '"DTID'.$_SESSION['logindetails']['baseyear'].'"','dt' => 4,'db1' => 'DTID'.$_SESSION['logindetails']['baseyear'].''),
			array( 'db' => '"MDDS_DT'.$_SESSION['logindetails']['baseyear'].'"','dt' => 5,'db1' => 'MDDS_DT'.$_SESSION['logindetails']['baseyear'].''),
			array( 'db' => '"DTName'.$_SESSION['logindetails']['baseyear'].'"','dt' => 6,'db1' => 'DTName'.$_SESSION['logindetails']['baseyear'].''),
			array( 'db' => '"SDID'.$_SESSION['logindetails']['baseyear'].'"','dt' => 7,'db1' => 'SDID'.$_SESSION['logindetails']['baseyear'].''),
			array( 'db' => '"MDDS_SD'.$_SESSION['logindetails']['baseyear'].'"','dt' => 8,'db1' => 'MDDS_SD'.$_SESSION['logindetails']['baseyear'].''),
			array( 'db' => '"SDName'.$_SESSION['logindetails']['baseyear'].'"','dt' => 9,'db1' => 'SDName'.$_SESSION['logindetails']['baseyear'].''),
			array( 'db' => '"MDDS_VT'.$_SESSION['logindetails']['baseyear'].'"','dt' => 10,'db1' => 'MDDS_VT'.$_SESSION['logindetails']['baseyear'].''),
			array( 'db' => '"VTName'.$_SESSION['logindetails']['baseyear'].'"','dt' => 11,'db1' => 'VTName'.$_SESSION['logindetails']['baseyear'].''),
			array( 'db' => '"Level'.$_SESSION['logindetails']['baseyear'].'"','dt' => 12,'db1' => 'Level'.$_SESSION['logindetails']['baseyear'].''),
			// array( 'db' => '"Status'.$_SESSION['logindetails']['baseyear'].'"','dt' => 12,'db1' => 'Status'.$_SESSION['logindetails']['baseyear'].''),
			 array( 'db' => '"Status'.$_SESSION['logindetails']['baseyear'].'"', 'dt' => 13,'db1' => 'Status'.$_SESSION['logindetails']['baseyear'].'',
                'formatter' => function( $d, $row ) {
                if (!is_null($d) && $d=='Village')
             	{
             		return 'RV';
             	}
             	else
             	{
             	return $d;	
             	}
                
                } ),
			 

			array( 'db' => '"VTID'.$_SESSION['logindetails']['baseyear'].'"','dt' => 14,'db1' => 'VTID'.$_SESSION['logindetails']['baseyear'].''),
			
			array( 'db' => '"STID'.$acyearshort.'"','dt' => 15,'db1' => 'STID'.$acyearshort.''),
			 array( 'db' => '"MDDS_ST'.$acyearshort.'"', 'dt' => 16,'db1' => 'MDDS_ST'.$acyearshort.'',
                'formatter' => function( $d, $row ) {
                	
                	//  print_r($row['is_deleted']);
                if ($row['is_deleted']==0)
             	{
             		return '';
             	}
             	else
             	{
             	return $d;	
             	}
                
                } ),
			 array( 'db' => '"STName'.$acyearshort.'"', 'dt' => 17,'db1' => 'STName'.$acyearshort.'',
                'formatter' => function( $d, $row ) {
                	
                	//  print_r($row['is_deleted']);
                if ($row['is_deleted']==0)
             	{
             		return '';
             	}
             	else
             	{
             	return $d;	
             	}
                
                } ),

				array( 'db' => '"STStatus'.$acyearshort.'"', 'dt' => 18,'db1' => 'STStatus'.$acyearshort.'',
				'formatter' => function( $d, $row ) {
					
					//  print_r($row['is_deleted']);
				if ($row['is_deleted']==0)
				{
					return '';
				}
				else
				{
				return $d;	
				}
				
				} ),

			// array( 'db' => '"MDDS_ST'.$acyearshort.'"','dt' => 15,'db1' => 'MDDS_ST'.$acyearshort.''),
			// array( 'db' => '"STName'.$acyearshort.'"','dt' => 16,'db1' => 'STName'.$acyearshort.''),
			array( 'db' => '"DTID'.$acyearshort.'"','dt' => 19,'db1' => 'DTID'.$acyearshort.''),
			array( 'db' => '"MDDS_DT'.$acyearshort.'"', 'dt' => 20,'db1' => 'MDDS_DT'.$acyearshort.'',
                'formatter' => function( $d, $row ) {
                	
                	//  print_r($row['is_deleted']);
                if ($row['is_deleted']==0)
             	{
             		return '';
             	}
             	else
             	{
             	return $d;	
             	}
                
                } ),
			array( 'db' => '"DTName'.$acyearshort.'"', 'dt' => 21,'db1' => 'DTName'.$acyearshort.'',
                'formatter' => function( $d, $row ) {
                	
                	//  print_r($row['is_deleted']);
                if ($row['is_deleted']==0)
             	{
             		return '';
             	}
             	else
             	{
             	return $d;	
             	}
                
                } ),
			// array( 'db' => '"MDDS_DT'.$acyearshort.'"','dt' => 18,'db1' => 'MDDS_DT'.$acyearshort.''),
			// array( 'db' => '"DTName'.$acyearshort.'"','dt' => 19,'db1' => 'DTName'.$acyearshort.''),
			array( 'db' => '"SDID'.$acyearshort.'"','dt' => 22,'db1' => 'SDID'.$acyearshort.''),
			array( 'db' => '"MDDS_SD'.$acyearshort.'"', 'dt' => 23,'db1' => 'MDDS_SD'.$acyearshort.'',
                'formatter' => function( $d, $row ) {
                	
                	//  print_r($row['is_deleted']);
                if ($row['is_deleted']==0)
             	{
             		return '';
             	}
             	else
             	{
             	return $d;	
             	}
                
                } ),
			array( 'db' => '"SDName'.$acyearshort.'"', 'dt' => 24,'db1' => 'SDName'.$acyearshort.'',
                'formatter' => function( $d, $row ) {
                	
                	//  print_r($row['is_deleted']);
                if ($row['is_deleted']==0)
             	{
             		return '';
             	}
             	else
             	{
             	return $d;	
             	}
                
                } ),
			// array( 'db' => '"MDDS_SD'.$acyearshort.'"','dt' => 21,'db1' => 'MDDS_SD'.$acyearshort.''),
			// array( 'db' => '"SDName'.$acyearshort.'"','dt' => 22,'db1' => 'SDName'.$acyearshort.''),
			array( 'db' => '"MDDS_VT'.$acyearshort.'"','dt' => 25,'db1' => 'MDDS_VT'.$acyearshort.''),
			array( 'db' => '"VTName'.$acyearshort.'"', 'dt' => 26,'db1' => 'VTName'.$acyearshort.'',
                'formatter' => function( $d, $row ) {
                	
                	//  print_r($row['is_deleted']);
                if ($row['is_deleted']==0)
             	{
             		return '';
             	}
             	else
             	{
             	return $d;	
             	}
                
                } ),
			array( 'db' => '"Level'.$acyearshort.'"', 'dt' => 27,'db1' => 'Level'.$acyearshort.'',
                'formatter' => function( $d, $row ) {
                	
                	//  print_r($row['is_deleted']);
                if ($row['is_deleted']==0)
             	{
             		return '';
             	}
             	else
             	{
             	return $d;	
             	}
                
                } ),
			array( 'db' => '"Status'.$acyearshort.'"', 'dt' => 28,'db1' => 'Status'.$acyearshort.'',
                'formatter' => function( $d, $row ) {
                	
                	//  print_r($row['is_deleted']);
                if ($row['is_deleted']==0)
             	{
             		return '';
             	}
             	else
             	{
             	return $d;	
             	}
                
                } ),
			
			// array( 'db' => '"VTName'.$acyearshort.'"','dt' => 24,'db1' => 'VTName'.$acyearshort.''),
			//array( 'db' => '"Level'.$acyearshort.'"','dt' => 25,'db1' => 'Level'.$acyearshort.''),
			// array( 'db' => '"Status'.$acyearshort.'"','dt' => 26,'db1' => 'Status'.$acyearshort.''),
			array( 'db' => '"VTID'.$acyearshort.'"','dt' => 29,'db1' => 'VTID'.$acyearshort.''),
			array( 'db' => '"VTID'.$acyearshort.'"','dt' => 30,'db1' => 'VTID'.$acyearshort.''),
			array( 'db' => '"is_deleted"','dt' => 31,'db1' => 'is_deleted'),
		

			);

}
else if($_POST['flag']=='VT')
{
	$cond='';
	$cond1='';
	$acyear=$_SESSION['activeyears'];
	$acyearshort = substr($acyear, -2);
	$olyear=$_SESSION['logindetails']['baseyear'];
		$array = array("stids"=>$_POST['stids'],"dtids"=>$_POST['dtids'],"sdids"=>$_POST['sdids']);
	
	// if($_SESSION['logindetails']['assignlist']!='')
	// {
	// 		$cond = ' AND "fr21"."STID"='.$_SESSION['logindetails']['assignlist'].'';
	// 		$cond1 = ' WHERE "STID"='.$_SESSION['logindetails']['assignlist'].'';
	// 		// $cond1 = ' AND "st2021"."STID"='.$_SESSION['logindetails']['assignlist'].'';
	// 		// $cond2 = ' AND "dt2021"."STID"='.$_SESSION['logindetails']['assignlist'].'';
	// 		// $cond3 = ' AND "sd2021"."STID"='.$_SESSION['logindetails']['assignlist'].'';
	// 		// $cond4 = ' AND "vt2021"."STID"='.$_SESSION['logindetails']['assignlist'].'';
	
	// }

		if($_SESSION['logindetails']['assignlist']!='')
	{
		if($_POST['stids']!='' &&  $_POST['dtids']=='' &&  $_POST['sdids']=='')
		{
				$cond = ' ( "fr21"."STID"='.$_SESSION['logindetails']['assignlist'].' OR "fr21"."STIDACTIVE"='.$_SESSION['logindetails']['assignlist'].' )';
				$cond1 = ' WHERE "STID"='.$_SESSION['logindetails']['assignlist'].'';

		}
		else if($_POST['stids']!='' &&  $_POST['dtids']!='' &&  $_POST['sdids']=='' )
		{
			

			$cond = ' ( "fr21"."STID"='.$_SESSION['logindetails']['assignlist'].' OR "fr21"."STIDACTIVE"='.$_SESSION['logindetails']['assignlist'].' ) AND ("fr21"."DTID"='.$_POST['dtids'].' OR "fr21"."DTIDACTIVE"='.$_POST['dtids'].')';
				$cond1 = ' WHERE "STID"='.$_POST['stids'].'';
		}
		else if($_POST['stids']!='' &&  $_POST['dtids']!='' &&  $_POST['sdids']!='' )
		{

			$cond = ' ( "fr21"."STID"='.$_SESSION['logindetails']['assignlist'].' OR "fr21"."STIDACTIVE"='.$_SESSION['logindetails']['assignlist'].' ) AND ("fr21"."DTID"='.$_POST['dtids'].' OR "fr21"."DTIDACTIVE"='.$_POST['dtids'].') AND ("fr21"."SDID"='.$_POST['sdids'].' OR "fr21"."SDIDACTIVE"='.$_POST['sdids'].')';
				$cond1 = ' WHERE "STID"='.$_POST['stids'].'';

			// $cond = ' AND "fr21"."STID"='.$_POST['stids'].' AND "fr21"."DTID"='.$_POST['dtids'].' AND "fr21"."SDID"='.$_POST['sdids'].'';
		}


			// $cond = ' AND "fr21"."STID"='.$_SESSION['logindetails']['assignlist'].'';
			// $cond1 = ' WHERE "STID"='.$_SESSION['logindetails']['assignlist'].'';
			
	}
	else
	{
		if($_POST['stids']!='' &&  $_POST['dtids']=='' &&  $_POST['sdids']=='')
		{
			$cond = ' ( "fr21"."STID"='.$_POST['stids'].' OR "fr21"."STIDACTIVE"='.$_POST['stids'].' )';
			$cond1 = ' WHERE "STID"='.$_POST['stids'].'';

		}
		else if($_POST['stids']!='' &&  $_POST['dtids']!='' &&  $_POST['sdids']=='' )
		{
			$cond = ' ( "fr21"."STID"='.$_POST['stids'].' OR "fr21"."STIDACTIVE"='.$_POST['stids'].' ) AND ("fr21"."DTID"='.$_POST['dtids'].' OR "fr21"."DTIDACTIVE"='.$_POST['dtids'].')';
				$cond1 = ' WHERE "STID"='.$_POST['stids'].'';
		}
		else if($_POST['stids']!='' &&  $_POST['dtids']!='' &&  $_POST['sdids']!='' )
		{
		$cond = ' ( "fr21"."STID"='.$_POST['stids'].' OR "fr21"."STIDACTIVE"='.$_POST['stids'].' ) AND ("fr21"."DTID"='.$_POST['dtids'].' OR "fr21"."DTIDACTIVE"='.$_POST['dtids'].') AND ("fr21"."SDID"='.$_POST['sdids'].' OR "fr21"."SDIDACTIVE"='.$_POST['sdids'].')';
			$cond1 = ' WHERE "STID"='.$_POST['stids'].'';
		}

	}
	

			$table = <<<EOT
			 (

				SELECT * FROM (select "VTIDACTIVE","frids","STID$olyear","STName$olyear","MDDS_ST$olyear","DTID$olyear","DTName$olyear","MDDS_DT$olyear","SDID$olyear","SDName$olyear","MDDS_SD$olyear",
			"VTID$olyear","VTName$olyear","MDDS_VT$olyear","Level$olyear","Status$olyear","frcomment","comeaction","STID$acyearshort"
						
						,CASE
			            WHEN "frfromaction"='Sub-Merge'  THEN ''
			            ELSE "STName$acyearshort"
			       		END AS "STName$acyearshort"

			       		,CASE
			            WHEN "frfromaction"='Sub-Merge'  THEN ''
			            ELSE "MDDS_ST$acyearshort"
			       		END AS "MDDS_ST$acyearshort"


						,"DTID$acyearshort"
						
						,CASE
			            WHEN "frfromaction"='Sub-Merge'  THEN ''
			            ELSE "DTName$acyearshort"
			       		END AS "DTName$acyearshort"

			       		,CASE
			            WHEN "frfromaction"='Sub-Merge'  THEN ''
			            ELSE "MDDS_DT$acyearshort"
			       		END AS "MDDS_DT$acyearshort"
			  			
						,"SDID$acyearshort"
						
						,CASE
			            WHEN "frfromaction"='Sub-Merge'  THEN ''
			            ELSE "SDName$acyearshort"
			       		END AS "SDName$acyearshort"

			       		,CASE
			            WHEN "frfromaction"='Sub-Merge'  THEN ''
			            ELSE "MDDS_SD$acyearshort"
			       		END AS "MDDS_SD$acyearshort"
			  			
			  			,"VTID$acyearshort"

			  			,CASE
			            WHEN "frfromaction"='Sub-Merge'  THEN ''
			            ELSE "VTName$acyearshort"
			       		END AS "VTName$acyearshort"

			       		,CASE
						   WHEN vt$acyear."is_deleted"=0  THEN ''
			            ELSE "MDDS_VT$acyearshort"
			        	END AS "MDDS_VT$acyearshort"
			        	,CASE
			            WHEN "frfromaction"='Sub-Merge'  THEN ''
			            ELSE "Level$acyearshort"
			        	END AS "Level$acyearshort"
			        	,CASE
			            WHEN "frfromaction"='Sub-Merge'  THEN ''
			            ELSE "Status$acyearshort"
			        	END AS "Status$acyearshort","is_deleted"

			from (select DISTINCT ON( fr$acyearshort."VTIDACTIVE") fr$acyearshort."VTIDACTIVE",fr$acyearshort."SDIDACTIVE",fr$acyearshort."DTIDACTIVE",fr$acyearshort."VTIDR",fr$acyearshort.frids,
						   fr$acyearshort.frcomment,fr$acyearshort.comeaction,fr$acyearshort.frfromaction
						   
						   from forreaddata20$acyearshort as fr$acyearshort
						   
						    WHERE $cond AND fr$acyearshort."VTIDACTIVE"=fr$acyearshort."VTID" AND fr$acyearshort."VTIDACTIVE"=fr$acyearshort."VTIDR"  ORDER BY "VTIDACTIVE", "frids" DESC) as frtab
						 INNER JOIN
			 (select "STID$acyearshort","STName$acyearshort","MDDS_ST$acyearshort","DTID$acyearshort","DTName$acyearshort","MDDS_DT$acyearshort","SDID$acyearshort","SDName$acyearshort","MDDS_SD$acyearshort"
			  ,"VTID" as "VTID$acyearshort","VTName" as "VTName$acyearshort","MDDS_VT" as "MDDS_VT$acyearshort","Level" as "Level$acyearshort","Status" as "Status$acyearshort","is_deleted" from vt$acyear 
			  INNER JOIN (select "STID" AS "STID$acyearshort","STName" AS "STName$acyearshort","MDDS_ST" AS "MDDS_ST$acyearshort" from st$acyear where is_deleted=1) as st$acyearshort ON st$acyearshort."STID$acyearshort"=vt$acyear."STID"
			INNER JOIN (select "DTID" AS "DTID$acyearshort","DTName" AS "DTName$acyearshort","MDDS_DT" AS "MDDS_DT$acyearshort" from dt$acyear where is_deleted=1) as dt$acyearshort ON dt$acyearshort."DTID$acyearshort"=vt$acyear."DTID"
			INNER JOIN (select "SDID" AS "SDID$acyearshort","SDName" AS "SDName$acyearshort","MDDS_SD" AS "MDDS_SD$acyearshort" from sd$acyear where is_deleted=1) as sd$acyearshort ON sd$acyearshort."SDID$acyearshort"=vt$acyear."SDID"
			    $cond1) as vt$acyear INNER JOIN
			 (select "STID$olyear","STName$olyear","MDDS_ST$olyear","DTID$olyear","DTName$olyear","MDDS_DT$olyear","SDID$olyear","SDName$olyear","MDDS_SD$olyear"
			  ,"VTID" as "VTID$olyear","VTName" as "VTName$olyear","MDDS_VT" as "MDDS_VT$olyear","Level" as "Level$olyear","Status" as "Status$olyear" from vt$olyear 
			  INNER JOIN (select "STID" AS "STID$olyear","STName" AS "STName$olyear","MDDS_ST" AS "MDDS_ST$olyear" from st$olyear) as st11 ON st11."STID$olyear"=vt$olyear."STID"
			INNER JOIN (select "DTID" AS "DTID$olyear","DTName" AS "DTName$olyear","MDDS_DT" AS "MDDS_DT$olyear" from dt$olyear) as dt11 ON dt11."DTID$olyear"=vt$olyear."DTID"
			INNER JOIN (select "SDID" AS "SDID$olyear","SDName" AS "SDName$olyear","MDDS_SD" AS "MDDS_SD$olyear" from sd$olyear) as sd11 ON sd11."SDID$olyear"=vt$olyear."SDID"
			    $cond1) as vt$olyear ON vt$olyear."VTID$olyear" = vt$acyear."VTID$acyearshort" ON frtab."VTIDACTIVE" = vt$acyear."VTID$acyearshort" OR frtab."SDIDACTIVE" = vt$acyear."SDID$acyearshort" OR frtab."DTIDACTIVE" = vt$acyear."DTID$acyearshort" 
				
			) AS TAB1

			UNION ALL


			SELECT * FROM (select DISTINCT ( fr$acyearshort."VTIDACTIVE"),fr$acyearshort."frids",vt$olyear.*,fr$acyearshort.frcomment,fr$acyearshort.comeaction,vt$acyear.* from forreaddata$acyear as fr$acyearshort
			LEFT JOIN
			 (select "STID$olyear","STName$olyear","MDDS_ST$olyear","DTID$olyear","DTName$olyear","MDDS_DT$olyear","SDID$olyear","SDName$olyear","MDDS_SD$olyear"
			  ,"VTID" as "VTID$olyear","VTName" as "VTName$olyear","MDDS_VT" as "MDDS_VT$olyear","Level" as "Level$olyear","Status" as "Status$olyear","is_deleted" from vt$olyear 
			  INNER JOIN (select "STID" AS "STID$olyear","STName" AS "STName$olyear","MDDS_ST" AS "MDDS_ST$olyear" from st$olyear) as st11 ON st11."STID$olyear"=vt$olyear."STID"
			INNER JOIN (select "DTID" AS "DTID$olyear","DTName" AS "DTName$olyear","MDDS_DT" AS "MDDS_DT$olyear" from dt$olyear) as dt11 ON dt11."DTID$olyear"=vt$olyear."DTID"
			INNER JOIN (select "SDID" AS "SDID$olyear","SDName" AS "SDName$olyear","MDDS_SD" AS "MDDS_SD$olyear" from sd$olyear) as sd11 ON sd11."SDID$olyear"=vt$olyear."SDID"
			   $cond1) as vt$olyear ON fr$acyearshort."VTIDR" = vt$olyear."VTID$olyear"
			  
			  LEFT JOIN
			 (select "STID$acyearshort","STName$acyearshort","MDDS_ST$acyearshort","DTID$acyearshort","DTName$acyearshort","MDDS_DT$acyearshort","SDID$acyearshort","SDName$acyearshort","MDDS_SD$acyearshort"
			  ,"VTID" as "VTID$acyearshort","VTName" as "VTName$acyearshort","MDDS_VT" as "MDDS_VT$acyearshort","Level" as "Level$acyearshort","Status" as "Status$acyearshort","is_deleted" from vt$acyear 
			  INNER JOIN (select "STID" AS "STID$acyearshort","STName" AS "STName$acyearshort","MDDS_ST" AS "MDDS_ST$acyearshort" from st$acyear) as st$acyearshort ON st$acyearshort."STID$acyearshort"=vt$acyear."STID"
			INNER JOIN (select "DTID" AS "DTID$acyearshort","DTName" AS "DTName$acyearshort","MDDS_DT" AS "MDDS_DT$acyearshort" from dt$acyear) as dt$acyearshort ON dt$acyearshort."DTID$acyearshort"=vt$acyear."DTID"
			INNER JOIN (select "SDID" AS "SDID$acyearshort","SDName" AS "SDName$acyearshort","MDDS_SD" AS "MDDS_SD$acyearshort" from sd$acyear) as sd$acyearshort ON sd$acyearshort."SDID$acyearshort"=vt$acyear."SDID"
			   $cond1) as vt$acyear ON fr$acyearshort."VTIDACTIVE" = vt$acyear."VTID$acyearshort"
			   WHERE  $cond AND fr$acyearshort."VTIDACTIVE"!=fr$acyearshort."VTIDR"  ORDER BY "VTIDACTIVE", "frids" DESC) AS TAB2

			    
			 ) temp
			EOT;

			$columns = array(
			array( 'db' => '"STID'.$_SESSION['logindetails']['baseyear'].'"','dt' => 0,'db1' => 'STID'.$_SESSION['logindetails']['baseyear'].''),
			array( 'db' => '"MDDS_ST'.$_SESSION['logindetails']['baseyear'].'"','dt' => 1,'db1' => 'MDDS_ST'.$_SESSION['logindetails']['baseyear'].''),
			array( 'db' => '"STName'.$_SESSION['logindetails']['baseyear'].'"','dt' => 2,'db1' => 'STName'.$_SESSION['logindetails']['baseyear'].''),
			array( 'db' => '"DTID'.$_SESSION['logindetails']['baseyear'].'"','dt' => 3,'db1' => 'DTID'.$_SESSION['logindetails']['baseyear'].''),
			array( 'db' => '"MDDS_DT'.$_SESSION['logindetails']['baseyear'].'"','dt' => 4,'db1' => 'MDDS_DT'.$_SESSION['logindetails']['baseyear'].''),
			array( 'db' => '"DTName'.$_SESSION['logindetails']['baseyear'].'"','dt' => 5,'db1' => 'DTName'.$_SESSION['logindetails']['baseyear'].''),
			array( 'db' => '"SDID'.$_SESSION['logindetails']['baseyear'].'"','dt' => 6,'db1' => 'SDID'.$_SESSION['logindetails']['baseyear'].''),
			array( 'db' => '"MDDS_SD'.$_SESSION['logindetails']['baseyear'].'"','dt' => 7,'db1' => 'MDDS_SD'.$_SESSION['logindetails']['baseyear'].''),
			array( 'db' => '"SDName'.$_SESSION['logindetails']['baseyear'].'"','dt' => 8,'db1' => 'SDName'.$_SESSION['logindetails']['baseyear'].''),
			array( 'db' => '"MDDS_VT'.$_SESSION['logindetails']['baseyear'].'"','dt' => 9,'db1' => 'MDDS_VT'.$_SESSION['logindetails']['baseyear'].''),
			array( 'db' => '"VTName'.$_SESSION['logindetails']['baseyear'].'"','dt' => 10,'db1' => 'VTName'.$_SESSION['logindetails']['baseyear'].''),
			array( 'db' => '"Level'.$_SESSION['logindetails']['baseyear'].'"','dt' => 11,'db1' => 'Level'.$_SESSION['logindetails']['baseyear'].''),
			// array( 'db' => '"Status'.$_SESSION['logindetails']['baseyear'].'"','dt' => 12,'db1' => 'Status'.$_SESSION['logindetails']['baseyear'].''),
			 array( 'db' => '"Status'.$_SESSION['logindetails']['baseyear'].'"', 'dt' => 12,'db1' => 'Status'.$_SESSION['logindetails']['baseyear'].'',
                'formatter' => function( $d, $row ) {
                if (!is_null($d) && $d=='Village')
             	{
             		return 'RV';
             	}
             	else
             	{
             	return $d;	
             	}
                
                } ),
			 

			array( 'db' => '"VTID'.$_SESSION['logindetails']['baseyear'].'"','dt' => 13,'db1' => 'VTID'.$_SESSION['logindetails']['baseyear'].''),
			
			array( 'db' => '"STID'.$acyearshort.'"','dt' => 14,'db1' => 'STID'.$acyearshort.''),
			 array( 'db' => '"MDDS_ST'.$acyearshort.'"', 'dt' => 15,'db1' => 'MDDS_ST'.$acyearshort.'',
                'formatter' => function( $d, $row ) {
                	
                	//  print_r($row['is_deleted']);
                if ($row['is_deleted']==0)
             	{
             		return '';
             	}
             	else
             	{
             	return $d;	
             	}
                
                } ),
			 array( 'db' => '"STName'.$acyearshort.'"', 'dt' => 16,'db1' => 'STName'.$acyearshort.'',
                'formatter' => function( $d, $row ) {
                	
                	//  print_r($row['is_deleted']);
                if ($row['is_deleted']==0)
             	{
             		return '';
             	}
             	else
             	{
             	return $d;	
             	}
                
                } ),

			// array( 'db' => '"MDDS_ST'.$acyearshort.'"','dt' => 15,'db1' => 'MDDS_ST'.$acyearshort.''),
			// array( 'db' => '"STName'.$acyearshort.'"','dt' => 16,'db1' => 'STName'.$acyearshort.''),
			array( 'db' => '"DTID'.$acyearshort.'"','dt' => 17,'db1' => 'DTID'.$acyearshort.''),
			array( 'db' => '"MDDS_DT'.$acyearshort.'"', 'dt' => 18,'db1' => 'MDDS_DT'.$acyearshort.'',
                'formatter' => function( $d, $row ) {
                	
                	//  print_r($row['is_deleted']);
                if ($row['is_deleted']==0)
             	{
             		return '';
             	}
             	else
             	{
             	return $d;	
             	}
                
                } ),
			array( 'db' => '"DTName'.$acyearshort.'"', 'dt' => 19,'db1' => 'DTName'.$acyearshort.'',
                'formatter' => function( $d, $row ) {
                	
                	//  print_r($row['is_deleted']);
                if ($row['is_deleted']==0)
             	{
             		return '';
             	}
             	else
             	{
             	return $d;	
             	}
                
                } ),
			// array( 'db' => '"MDDS_DT'.$acyearshort.'"','dt' => 18,'db1' => 'MDDS_DT'.$acyearshort.''),
			// array( 'db' => '"DTName'.$acyearshort.'"','dt' => 19,'db1' => 'DTName'.$acyearshort.''),
			array( 'db' => '"SDID'.$acyearshort.'"','dt' => 20,'db1' => 'SDID'.$acyearshort.''),
			array( 'db' => '"MDDS_SD'.$acyearshort.'"', 'dt' => 21,'db1' => 'MDDS_SD'.$acyearshort.'',
                'formatter' => function( $d, $row ) {
                	
                	//  print_r($row['is_deleted']);
                if ($row['is_deleted']==0)
             	{
             		return '';
             	}
             	else
             	{
             	return $d;	
             	}
                
                } ),
			array( 'db' => '"SDName'.$acyearshort.'"', 'dt' => 22,'db1' => 'SDName'.$acyearshort.'',
                'formatter' => function( $d, $row ) {
                	
                	//  print_r($row['is_deleted']);
                if ($row['is_deleted']==0)
             	{
             		return '';
             	}
             	else
             	{
             	return $d;	
             	}
                
                } ),
			// array( 'db' => '"MDDS_SD'.$acyearshort.'"','dt' => 21,'db1' => 'MDDS_SD'.$acyearshort.''),
			// array( 'db' => '"SDName'.$acyearshort.'"','dt' => 22,'db1' => 'SDName'.$acyearshort.''),
			array( 'db' => '"MDDS_VT'.$acyearshort.'"','dt' => 23,'db1' => 'MDDS_VT'.$acyearshort.''),
			array( 'db' => '"VTName'.$acyearshort.'"', 'dt' => 24,'db1' => 'VTName'.$acyearshort.'',
                'formatter' => function( $d, $row ) {
                	
                	//  print_r($row['is_deleted']);
                if ($row['is_deleted']==0)
             	{
             		return '';
             	}
             	else
             	{
             	return $d;	
             	}
                
                } ),
			array( 'db' => '"Level'.$acyearshort.'"', 'dt' => 25,'db1' => 'Level'.$acyearshort.'',
                'formatter' => function( $d, $row ) {
                	
                	//  print_r($row['is_deleted']);
                if ($row['is_deleted']==0)
             	{
             		return '';
             	}
             	else
             	{
             	return $d;	
             	}
                
                } ),
			array( 'db' => '"Status'.$acyearshort.'"', 'dt' => 26,'db1' => 'Status'.$acyearshort.'',
                'formatter' => function( $d, $row ) {
                	
                	//  print_r($row['is_deleted']);
                if ($row['is_deleted']==0)
             	{
             		return '';
             	}
             	else
             	{
             	return $d;	
             	}
                
                } ),
			
			// array( 'db' => '"VTName'.$acyearshort.'"','dt' => 24,'db1' => 'VTName'.$acyearshort.''),
			//array( 'db' => '"Level'.$acyearshort.'"','dt' => 25,'db1' => 'Level'.$acyearshort.''),
			// array( 'db' => '"Status'.$acyearshort.'"','dt' => 26,'db1' => 'Status'.$acyearshort.''),
			array( 'db' => '"VTID'.$acyearshort.'"','dt' => 27,'db1' => 'VTID'.$acyearshort.''),
			array( 'db' => '"VTID'.$acyearshort.'"','dt' => 28,'db1' => 'VTID'.$acyearshort.''),
			array( 'db' => '"is_deleted"','dt' => 29,'db1' => 'is_deleted'),
		

			);
}





$pg_details = $databaseinfo;


require( 'ssp.class.php' );

echo json_encode(
SSP::simple( $_POST, $pg_details, $table, $primaryKey, $columns,$filtroAdd,$array)
);


}



else if($_POST['formname']=='setyears')
{
	$_SESSION['activeyears'] = $_POST['jcyname'];
echo "done";
}


// else if($_POST['formname']=='forgot_password_form')
// {
	
// 	$task='';
// 	$sql=mysqli_query($db,"select * from ".$admin_table." where admin_name='".$_POST['email_forgot']."'");
// 	if(mysqli_num_rows($sql)>0)
// 	{
// 		$sql_data=mysqli_fetch_array($sql);
	
// 			$to = "".$sql_data['admin_name']."";
// 			$subject = "hotels: Forgot Password Request"; 
			
			
// 			$html = file_get_contents('for_password.html', true);
// 			$html2 = str_replace("u_pass",$sql_data['admin_password1'], $html);

			
			
// 			$from = "".$support_maill.""; 
// 			$headers = 'From: ' . $from . "\n";
// 			$headers = "From: <".$from.">\n"."MIME-Version: 1.0\n"
// 			. "Content-Type: text/html; charset=\"iso-8859-1\"\n"
// 			. "Content-Transfer-Encoding: 7bit\n";
				
// 			mail($to,$subject,$html2,$headers);
			
		
// 		$task ='email_send_of';

		
// 	}
// 	else
// 	{
		
// 		$task ='emailnotexits';
// 	}
	
// 	echo $task;	
// }


else if($_POST['formname']=='get_sub')
{
	$array = array($_POST['data']);

	$check = "select \"status\" As \"id\",\"status\" As \"Name\" from vtstatuslevel where level=$1";
	$query = pg_query_params($db,$check,$array);
		$row = pg_fetch_all($query); 
if($_POST['vtids']!='')
{
	$arraynew=array($_POST['vtids'],'1');
	 $sql = 'select * from vt'.$_SESSION['activeyears'].' where "VTID"=$1 AND is_deleted=$2';
	$sqlquery = pg_query_params($db,$sql,$arraynew);
	$data = pg_fetch_array($sqlquery);
}

if(strtolower(trim($data['Status']))==strtolower($_POST['data']))
{
	$c = trim($data['Status']);
}
else
{
$c = $_POST['data'];
}
		

echo json_encode($row)."|".$_POST['comefrom']."|".$_POST['clickpopup']."|".$_POST['i']."|".$c;
  exit();
}


// else if ($_POST['formname'] == 'profiledata') {
//     $task = "";
//     $checkarray = array($_POST['idslogin_update']);
//     $check = "select * from admin_login where id=$1";
//     $checkemail = "select * from admin_login where admin_email =$1";
//     $checkmobile = "select * from admin_login where admin_mobile =$1";
    
//     $query = pg_query_params($db, $check, $checkarray);
//     $result_email = pg_query_params($db, $checkemail, array($_POST['admin_email']));
//     $result_mobile = pg_query_params($db, $checkmobile, array($_POST['admin_mobile']));
    
//     $passwordcheck = pg_numrows($query);
//     $rows_email = pg_numrows($result_email);
//     $rows_mobile = pg_numrows($result_mobile);
    
   
// 	if 
// 	($rows_email > 0 && $rows_mobile > 0) {
//         $task = "bothemailmobilealready";
//     } elseif ($rows_email > 0) {
//         $task = "emailalready";
//     } elseif ($rows_mobile > 0) {
//         $task = "mobilealready";
//     } elseif ($passwordcheck == 0) {
//         $task = "usernotmatch";
//     } else {
//         $array = array($_POST['admin_email'], $_POST['idslogin_update'], $_POST['admin_mobile'], $_POST['designation'], $_POST['admin_lname']);
//         $update = "update admin_login set admin_email=$1, admin_mobile=$3, designation=$4, admin_lname=$5 where id=$2";
//         $query = pg_query_params($db, $update, $array);
        
//         if ($query) {
//             $task = "profileupdatedone";
//         } else {
//             $task = "error";
//         }
//     }
    
//     echo $task;
// }


//Mobile No. & E-mail unique validation by Pavithra


else if ($_POST['formname'] == 'profiledata') {
    $task = "";
    $checkarray = array($_POST['idslogin_update']);
    $check = "select * from admin_login where id=$1";
    $checkemail = "select * from admin_login where admin_email =$1 and id != $2";
    $checkmobile = "select * from admin_login where admin_mobile =$1 and id != $2";
    
    $query = pg_query_params($db, $check, $checkarray);
    $result_email = pg_query_params($db, $checkemail, array($_POST['admin_email'], $_POST['idslogin_update']));
    $result_mobile = pg_query_params($db, $checkmobile, array($_POST['admin_mobile'], $_POST['idslogin_update']));
    
    $passwordcheck = pg_numrows($query);
    $rows_email = pg_numrows($result_email);
    $rows_mobile = pg_numrows($result_mobile);
   
    if ($passwordcheck == 0) {
        $task = "usernotmatch";
    } elseif ($rows_email > 0 && $rows_mobile > 0) {
        $task = "bothemailmobilealready";
    } elseif ($rows_email > 0) {
        $task = "emailalready";
    } elseif ($rows_mobile > 0) {
        $task = "mobilealready";
    } else {
        $array = array($_POST['admin_email'], $_POST['idslogin_update'], $_POST['admin_mobile'], $_POST['designation'], $_POST['admin_lname']);
        $update = "update admin_login set admin_email=$1, admin_mobile=$3, designation=$4, admin_lname=$5 where id=$2";
        $query = pg_query_params($db, $update, $array);
        
        if ($query) {
            $task = "profileupdatedone";
        } else {
            $task = "error";
        }
    }
    
    echo $task;
}


else if($_POST['formname']=='changepassworddata')
{
	$array = array(md5($_POST['oldpassword']),$_POST['idslogin']);
	$task ="";
	$check = "select * from admin_login where admin_password=$1 and id=$2";
	$query = pg_query_params($db,$check,$array);
	$passwordcheck = pg_numrows($query);
	if($passwordcheck==0)
	{
		$task = "passwordnotmatch";
	}
	else
	{

$uppercase = preg_match('@[A-Z]@', $_POST['newpassword']);
$lowercase = preg_match('@[a-z]@', $_POST['newpassword']);
$number    = preg_match('@[0-9]@', $_POST['newpassword']);
$specialChars = preg_match('@[^\w]@', $_POST['newpassword']);

if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8 || strlen($password) > 17) {

	$array = array($_POST['idslogin'],md5($_POST['newpassword']));
	$check1 = "select * from admin_login where id=$1 AND (admin_password=$2 OR last_password=$2 OR second_last_password=$2)";
		$query1 = pg_query_params($db,$check1,$array);
		$passwordcheck1 = pg_numrows($query1);
		if($passwordcheck1!=0)
		{
			$task = "samepass";
		}
		else
		{
			$arr = array($_POST['idslogin']);
		$check11 = "select * from admin_login where id=$1";
		$query11 = pg_query_params($db,$check11,$arr);
			$passwordcheck1data = pg_fetch_array($query11);

			$uparray = array(md5($_POST['newpassword']),$passwordcheck1data['admin_password'],$passwordcheck1data['last_password'],$_POST['idslogin'],$_POST['newpassword']);
			$update = "update admin_login set admin_password=$1,admin_password1=$5,last_password=$2,second_last_password=$3 where id=$4";
			$query = pg_query_params($db,$update,$uparray);
			if($query)
			{
			$task = "changepassword";
			}
			else
			{
			$task = "error";
			}

		}



}
else
{
	$task = "passwordvarification";

}

		

		
	}
	
	echo $task;
}


else if($_POST['formname']=='activedeactiveuser')
{
	$uparr=array($_POST['status'],$_POST['id']);

	 $changestatus = "update admin_login set status=$1 where id=$2";	
	$result = pg_query_params($db,$changestatus,$uparr); 
	if($result)
	{
		if($_POST['status']==1)
		{
			$task ="activate"; 
		}
		else
		{
			$task ="deactivat"; 	
		}
		
	}
	else
	{
		$task ="error"; 
	}
	echo $task;
}

else if($_POST['formname']=='resetupdateusersdata')
    {
		$array = array($_POST['userids'],md5($_POST['npassword']));
		$check1 = "select * from admin_login where id=$1 AND (admin_password=$2 OR last_password=$2 OR second_last_password=$2)";
		$query1 = pg_query_params($db,$check1,$array);
		$passwordcheck1 = pg_numrows($query1);

		if($passwordcheck1==0)
		{

$uppercase = preg_match('@[A-Z]@', $_POST['newpassword']);
$lowercase = preg_match('@[a-z]@', $_POST['newpassword']);
$number    = preg_match('@[0-9]@', $_POST['newpassword']);
$specialChars = preg_match('@[^\w]@', $_POST['newpassword']);

if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8 || strlen($password) > 17) {
	$array = array($_POST['userids']);
		$check11 = "select * from admin_login where id=$1";
		$query11 = pg_query_params($db,$check11,$array);
			$passwordcheck1data = pg_fetch_array($query11);

				$array = array(md5($_POST['npassword']),$_POST['npassword'],$passwordcheck1data['admin_password'],$passwordcheck1data['last_password'],$_POST['userids']);

				$update = "update admin_login set admin_password=$1,admin_password1=$2,last_password=$3,second_last_password=$4 where id=$5";
				$query = pg_query_params($db,$update,$array);

				if($query)
				{
				$task = "changepassword";
				}
				else
				{
				$task = "error";
				}



}
else
{
	$task = "passwordvarification";

}

			
		}
		else
		{
				$task = "samepass";
		}
		
		

				 echo $task; 
	} 


//modified by sahana to save important dates to db
else if($_POST['formname']=='saveimpdate')
    {
		if(isset($_POST['previousdate']) && isset($_POST['documentdate'])) {
			$previousdate = $_POST['previousdate'];
			$documentdate = $_POST['documentdate'];
			$_SESSION['previousdate'] = $previousdate;
			$_SESSION['documentdate'] = $documentdate;
		}
		


		$array = array($_SESSION['activeyears']);

		$sql="select * from importantdate where impdate_year=$1";
		$sql_query = pg_query_params($db,$sql,$array);

			if(pg_numrows($sql_query)>0)
			{
				// update
				$data = pg_fetch_array($sql_query);

				$array1 = array(date("Y-m-d", strtotime($_POST['idate'])),$_SESSION['login_id'],$data['ids'],$_SESSION['previousdate'],$_SESSION['documentdate'] );

				$update = "update importantdate set importantdate=$1,created_by=$2, previousdate=$4, documentdate=$5 where ids=$3";
				$in = pg_query_params($db,$update,$array1);


			}
			else
			{
				// insert
				$array1 = array(date("Y-m-d", strtotime($_POST['idate'])),$_SESSION['login_id'],$_SESSION['activeyears'],$_SESSION['previousdate'],$_SESSION['documentdate'] );

					$insert = "insert into importantdate (importantdate,created_by,impdate_year,previousdate,documentdate) values ($1,$2,$3,$4,$5)";
				$in = pg_query_params($db,$insert,$array1);

			}

		
		if($in)
		{
			$task = "savequery";
		}
		else
		{
			$task = "error";
		}

				 echo $task; 
	} 

//modified by sahana to autogenerate orgi user and dco admin and dco user 

// orgi admin - type 0
// orgi user - type 1
// dco admin - type 2
// dco user - type 3

else if ($_POST['formname'] == 'adduserdata') {
	$task = "";
	$userType = $_POST['userType'];

	$prefix = ($userType == 1) ? 'rgi' : 'dco';
	$suffix = '';

	if ($userType == 1) {
		
		$countQuery = "SELECT COUNT(*) FROM admin_login WHERE admin_name LIKE 'rgi%'"; // Get the current count of 'orgi' users
		$countResult = pg_query($db, $countQuery);
		$countRow = pg_fetch_row($countResult);
		$count = intval($countRow[0]) + 1;
	
		if ($count >= 1 && $count <= 15) {
			$suffix = sprintf('%03d', $count);
		} else {
			$task = "userlimitexceeded";
			echo $task;
			exit; 
		}
	} else {
        //userType 3 ('dco')
		$countQuery = "SELECT COUNT(*) FROM admin_login WHERE admin_name LIKE 'dco%'";
		$countResult = pg_query($db, $countQuery);
		$countRow = pg_fetch_row($countResult);
		$count = intval($countRow[0]) + 1;
	
		if ($count >= 1 && $count <= 70) {
			$suffix = sprintf('%03d', $count);
		} else {
			$task = "dcouserlimitexceeded";
			echo $task;
			exit; 
		}
	}
	
	$staid = $_POST['addSTID2021'];
	$shc = 'SELECT SUBSTRING(admin_name, 5, 3) FROM admin_login WHERE admin_type = 2 AND assign_state_id = $1';
	$selectAdminNameResult = pg_query_params($db, $shc, array($staid));

    if ($selectAdminNameResult) {
        $adminNameRow = pg_fetch_row($selectAdminNameResult);
        $STName = $adminNameRow[0];
    }
	else {
		$STName = ""; 
		}

	if ($userType == 1) {
		$adminName = $prefix .  $suffix;
	} 
	else if ($userType == 2) {
		// Checking if the dco admin login id already exists in the database
		$checkAdminNameQuery = 'SELECT * FROM admin_login WHERE admin_name = $1';
		$checkAdminNameResult = pg_query_params($db, $checkAdminNameQuery, array($_POST['addemail']));
	
		if ($checkAdminNameResult) {
			$countRow = pg_fetch_row($checkAdminNameResult);
			$count = $countRow[0];
			if ($count > 0) {
				$task = "adminnameexists";
			} else {
				$adminName = substr($_POST['addemail'], 0, 7); // take first 7 char from email for login id 
			}
		} else {
			$task = "error";
		}
	}
	else  //this is for dco usertype 3
	{
		$countQuery = "SELECT COUNT(*) FROM admin_login WHERE admin_name LIKE '".strtolower($STName)."%'";
		$countResult = pg_query($db, $countQuery);
		$countRow = pg_fetch_row($countResult);
		$count = intval($countRow[0]) + 1;
	
		if ($count >= 1 && $count <= 30) {
			$suffix = sprintf('%03d', $count);
		} else {
			$task = "dcouserlimitexceeded";
			echo $task;
			exit; 
		}
		$adminName = strtolower($STName) . $suffix;
	}
	
	$email = $_POST['addemail'] . $_POST['emailType'];
	$mobile = $_POST['addmobile'];
	$arr = array($email, $adminName, $mobile); 
	
	$checkuser = "SELECT * FROM admin_login WHERE admin_email = $1 OR admin_name = $2 OR admin_mobile = $3";
	$result = pg_query_params($db, $checkuser, $arr);
	$rowsdata = pg_numrows($result);

	 if ($rowsdata == 0) {
		$array = array(
			$adminName,
			$email,
			md5($_POST['addpassword']),
			$_POST['addpassword'],
			$_POST['userType'],
			'1',
			$_POST['addmobile'],
			$staid,
			$_POST['username'],
			$_POST['adddesignation'],
			$_POST['admin_type']
		);
		$insertdata = "INSERT INTO admin_login (\"admin_name\",\"admin_email\",\"admin_password\",\"admin_password1\",\"admin_type\",\"status\",\"last_password\",\"second_last_password\",\"admin_mobile\",\"assign_state_id\",\"admin_lname\",\"designation\",\"created_by\") values ($1,$2,$3,$4,$5,$6,$3,$3,$7,$8,$9,$10,$11) returning id";
		$result = pg_query_params($db, $insertdata, $array);

		if ($staid != null) {
			if ($result) {
				$fch = pg_fetch_row($result);
				$sub_array = array($fch[0], $staid, $_SESSION['activeyears'], $_SESSION['login_id']);
				$insertdatarelated = "INSERT INTO userassign (\"rcids\",\"STID\",\"rcuyear\",\"createdby\") values ($1,$2,$3,$4)";
				$result1 = pg_query_params($db, $insertdatarelated, $sub_array);

				if ($result1) {
					$task = "addeduser";
				} else {
					$task = "error";
				}
			} else {
				$task = "error";
			}
		} else {
			$task = "addeduser";
		}
	} else {
		// User with the same email, admin name, or mobile already exists in the database
		$checkemail = "SELECT * FROM admin_login WHERE admin_email = $1";
		$checkloginid = "SELECT * FROM admin_login WHERE admin_name = $1";
		$checkmobile = "SELECT * FROM admin_login WHERE admin_mobile = $1";

		$result_email = pg_query_params($db, $checkemail, array($arr[0]));
		$result_loginid = pg_query_params($db, $checkloginid, array($arr[1]));
		$result_mobile = pg_query_params($db, $checkmobile, array($arr[2]));

		$rows_email = pg_numrows($result_email);
		$rows_loginid = pg_numrows($result_loginid);
		$rows_mobile = pg_numrows($result_mobile);

		if ($rows_email > 0 && $rows_loginid > 0 && $rows_mobile > 0) {
			$task = "bothemailnamemobilealready";
		} else if ($rows_email > 0 && $rows_loginid > 0) {
			$task = "bothemailnamealready";
		} else if ($rows_email > 0 && $rows_mobile > 0) {
			$task = "bothemailmobilealready";
		} else if ($rows_loginid > 0 && $rows_mobile > 0) {
			$task = "bothnamemobilealready";
		} else if ($rows_email > 0) {
			$task = "emailalready";
		} else if ($rows_loginid > 0) {
			$task = "loginidalready";
		} else if ($rows_mobile > 0) {
			$task = "mobilealready";
		} else {
			$task = "error";
		}
			}
			echo $task;
}


else if($_POST['formname']=='get_state_status')
{
	
	

	$task='';
$sql = 'select * from st'.$_SESSION['activeyears'].' where "STID"='.$_POST['fstids'].' AND is_deleted=1';
	$sqlquery = pg_query($db,$sql);
	$data = pg_fetch_array($sqlquery);
	
echo "getdata|".json_encode($data)."|".$_POST['i']."|".trim($data['Status']);
}

else if($_POST['formname']=='get_vt_status')
{
	$task='';
	$array = array($_POST['fstids'],'1');
	$sql = 'select * from vt'.$_SESSION['activeyears'].' where "VTID"=$1 AND is_deleted=$2';
	$sqlquery = pg_query_params($db,$sql,$array);
	$data = pg_fetch_array($sqlquery);
	
echo "getdata|".json_encode($data)."|".$_POST['i']."|".trim($data['Level'])."|".trim($data['Status']);
}

//Defect_JC_58 modified by sahana
// else if ($_POST['formname'] == 'get_vt_status') {
//     $task = '';
//     $fstids = $_POST['fstids'];
// 	$vtid = $_POST['vtid'];

//     $fstids = ($fstids == '') ? null : $fstids;

//     $array = array($vtid, $fstids, '1');
//     $sql = 'SELECT * FROM vt' . $_SESSION['activeyears'] . ' WHERE "VTID" = $1 AND is_deleted = $2';
//     $sqlquery = pg_query_params($db, $sql, $array);

// 	if ($sqlquery === false) {
// 		// Error handling
// 		$error_message = pg_last_error($db);
// 		echo "Error executing query: " . $error_message;
// 		echo "SQL Query: " . $sql;
// 	} else {
// 		$data = pg_fetch_assoc($sqlquery);
	
// 		if (!isset($data['Level']) || !isset($data['Status'])) {
// 			echo "getdata|" . json_encode($data) . "|" . $_POST['i'] . "||";
// 		} else {
// 			echo "getdata|" . json_encode($data) . "|" . $_POST['i'] . "|" . trim($data['Level']) . "|" . trim($data['Status']);
// 		}
// 	}
// }

else if($_POST['formname']=='getdocalreadyuploadlist' ) { 
		

               $table='documentdata'.$_SESSION['activeyears'].'' ; 
			   $primaryKey='docids' ; 
			   $columns=array(
                array( 'db'=> '"docids"','db1'=> 'docids','dt' => 0),
                array( 'db'=> '"docids"','db1' => 'docids','dt' => 1),
                array( 'db'=> '"docstid"','db1' => 'docstid','dt' => 2),
                array( 'db'=> '"doctype"','db1' => 'doctype','dt' => 3),
                array( 'db'=> '"docdate"','db1' => 'docdate', 'dt' => 4,
                'formatter' => function( $d, $row ) {
                if (!is_null($d))
                return date( 'd-m-Y', strtotime($d));
                } ),
                array( 'db'=> '"doctitle"','db1' => 'doctitle','dt' => 5),
                array( 'db'=> '"docdescription"','db1' => 'docdescription','dt' => 6),
                array( 'db'=> '"docnotification"','db1' => 'docnotification','dt' => 7),

                );
                $pg_details = $databaseinfo;
                $whee='';
                if($_POST['doctype']!='')
                {
                	 $whee="AND doctype='".$_POST['doctype']."'";
                }
                $filtroAdd=" \"docstid\" = ".$_POST['STID2021']." AND (docdate='".date("Y-m-d", strtotime($_POST['dateselected']))."' OR doctitle='".$_POST['doctitle']."' OR originaldocname='".$_POST['oldfilename']."') AND docstatus='0' ".$whee."";

                require( 'ssp.class.php' );

                echo json_encode(
                SSP::simple( $_POST, $pg_details, $table, $primaryKey, $columns,$filtroAdd)
                );

                
  }


else if($_POST['formname']=='get_all_remarks1' ) { 
		
	$dataof = explode(',',$_POST['data']);



  //  print_r($dataof);


	$cond='';
	if($_SESSION['logindetails']['assignlist']!='')
	{
			$cond = 'AND "STIDACTIVE"='.$_SESSION['logindetails']['assignlist'].'';
	}
	else
	{
			$cond = '';
	}

	$cond1 = '';
	if($dataof[27]!='')
	{
		$cond1 = ' AND "VTIDACTIVE"='.$dataof[27].'';
	}
	$cond2 = '';
	if($dataof[13]!='')
	{
		$cond2 = ' AND "VTIDR"='.$dataof[13].'';
	}
	

	$cond3='';
	if($dataof[17]!='')
	{
		// $cond3 = ' AND "DTIDACTIVE"='.$dataof[17].'';


 	
	
	if($dataof[13]!='')
	{
		$cond3 = ' AND "DTIDACTIVE"='.$dataof[17].' AND "VTIDR"='.$dataof[13].'';
	}
	else
	{
		$cond3 = ' AND "DTIDACTIVE"='.$dataof[17].' AND ("VTIDACTIVE"='.$dataof[27].' OR "SDIDACTIVE"=0 OR "VTIDACTIVE"=0)';
	}
	}

	$cond5='';
	if($dataof[18]=='')
	{
		if($dataof[23]!='' && $dataof[0]=='')
		{
			$cond5 = ' AND "VTID"!="VTIDR"  AND "VTIDR"!=0';	
		}
		else if($dataof[23]!='' && $dataof[0]!='')
		{
			$cond5 = 'AND "VTID"!="VTIDR"  AND "VTIDR"!=0';	
		}
		else
		{
			$cond5 = '';
		}
		
	}
	else
	{
		if($dataof[23]=='' && $dataof[0]=='')
		{
			$cond5 = ' AND "VTID"!="VTIDR"  AND "VTIDR"!=0';	
		}
		else if($dataof[23]!='' && $dataof[0]!='')
		{
			if($dataof[20]!=$dataof[6])
			{
				$cond5 = ' AND "VTID"!="VTIDR"  AND "VTIDR"!=0';
			}
			else
			{
				$cond5 = ' AND "frfromids"="frtoids"';
			}

			
		}

	}

	$cond4='';
	if($dataof[20]!='' && $dataof[20]==$dataof[6])
	{
		$cond4 = ' OR "SDIDR"='.$dataof[20].'';
	}

 
  $table = <<<EOT
 (
     select DISTINCT("frfromids") as "JIGAR",* from (select * from (select forreaddata2021."frfromids",forreaddata2021."frdocids",to_char(created_date at time zone 'utc' at time zone 'Asia/Kolkata', 'dd-mm-yyyy HH24:MI:SS') AS createddate,
forreaddata2021."created_by",forreaddata2021."frcomment",admin_login."admin_name" 
from forreaddata2021 
LEFT JOIN admin_login 
ON admin_login."id"=forreaddata2021."created_by"  
Where frtoids!=0  $cond1  $cond2 $cond ORDER BY frids ASC) as tab1 INNER JOIN (select "docids","docstid","docnotification" from documentdata2021) as dc21 ON  tab1."frdocids"=dc21."docids"

UNION ALL

select * from (select DISTINCT ON( forreaddata2021."frfromids") forreaddata2021."frfromids",forreaddata2021."frdocids",to_char(created_date at time zone 'utc' at time zone 'Asia/Kolkata', 'dd-mm-yyyy HH24:MI:SS') AS createddate,
forreaddata2021."created_by",forreaddata2021."frcomment",admin_login."admin_name" 
from forreaddata2021 
LEFT JOIN admin_login 
ON admin_login."id"=forreaddata2021."created_by"  
Where frtoids!=0  $cond $cond3 $cond5 AND comeaction!='MAIN') as tab2 INNER JOIN (select "docids","docstid","docnotification" from documentdata2021) as dc2121 ON  tab2."frdocids"=dc2121."docids") as tab3

 ) temp
EOT;

			$columns = array(
			array( 'db' => '"frcomment"','dt' => 0,'db1' => 'frcomment'),
			array( 'db' => '"createddate"','dt' => 1,'db1' => 'createddate'),
			array( 'db' => '"admin_name"','dt' => 2,'db1' => 'admin_name'),
			array( 'db' => '"docstid"','dt' => 3,'db1' => 'docstid'),
			array( 'db' => '"docnotification"','dt' => 4,'db1' => 'docnotification'),
			
			);



    


$pg_details = $databaseinfo;


require( 'ssp.class.php' );

echo json_encode(
SSP::simplenew( $_POST, $pg_details, $table, $primaryKey, $columns,$filtroAdd)
);

                
  }


else if($_POST['formname']=='get_all_remarks' ) { 
		
	$dataof = explode(',',$_POST['data']);


	$cond='';
	if($_SESSION['logindetails']['assignlist']!='')
	{
			// $cond = 'AND "STIDACTIVE"='.$_SESSION['logindetails']['assignlist'].'';
	$cond = 'AND "STIDACTIVE"='.$_SESSION['logindetails']['assignlist'].'';
	}
	else
	{
			$cond = '';
	}

	

	// $st2011 = trim($dataof[0]);
	// $dt2011 = trim($dataof[3]);
	// $sd2011 = trim($dataof[6]);
	// $vt2011 = trim($dataof[13]);
	// $is_deleted = trim($dataof[29]);

	// $st2021 = trim($dataof[14]);
	// $st2021new = trim($dataof[15]);
	// $dt2021 = trim($dataof[17]);
	// $dt2021new = trim($dataof[18]);
	// $sd2021 = trim($dataof[20]);
	// $sd2021new = trim($dataof[21]);
	// $vt2021 = trim($dataof[27]);

 // print_r($dataof);
	//  $st2011 = trim($dataof[0]);
    // $dt2011 = trim($dataof[4]);
    // $sd2011 = trim($dataof[7]);
    // $vt2011 = trim($dataof[14]);
    // $is_deleted = trim($dataof[31]);
    // $st2021 = trim($dataof[15]);
    // $st2021new = trim($dataof[16]);
    // $dt2021 = trim($dataof[18]);
    // $dt2021new = trim($dataof[20]);
    // $sd2021 = trim($dataof[22]);
    // $sd2021new = trim($dataof[23]);
    // $vt2021 = trim($dataof[29]);

		$st2011 = trim($dataof[0]);
		$dt2011 = trim($dataof[4]);
		$sd2011 = trim($dataof[7]);
		$vt2011 = trim($dataof[14]);
		$is_deleted = trim($dataof[31]);
		$st2021 = trim($dataof[15]);
		$st2021new = trim($dataof[17]);
		$dt2021 = trim($dataof[19]);
		$dt2021new = trim($dataof[21]);
		$sd2021 = trim($dataof[22]);
		$sd2021new = trim($dataof[24]);
		$vt2021 = trim($dataof[29]);

 

 $cond='';
 if($st2021!='')
  {
	  $cond = ' "STIDACTIVE"='.$st2021.'';
  
  }

	$cond1 = '';
	if($vt2021!='')
	{
		$cond1 = ' AND "VTIDACTIVE"='.$vt2021.'';
	
	}
	// Sl 22
	$cond2 = '';
	if($vt2011!='' )
	{
		$cond2 = ' AND "VTIDR"='.$vt2011.'';
		$condd = ' AND "VTIDR"='.$vt2021.'';
		$cond8 = ' AND "VTID"='.$vt2011.'';
	}






	if($vt2011!='' && $vt2021!='')
	{

		$condnew = '';
			if($st2021new!='' && $dt2021new!='' && $sd2021new=='')
			{

				$condnew = 'UNION ALL
				select DISTINCT (forreaddata2021."SDIDACTIVE") AS "SDIDACTIVE",forreaddata2021."frfromids",forreaddata2021."frdocids"
				,to_char(created_date at time zone \'utc\' at time zone \'Asia/Kolkata\', \'dd-mm-yyyy HH24:MI:SS\') AS createddate,forreaddata2021."created_by",forreaddata2021."frcomment"
				,admin_login."admin_name",dc21."docids",dc21."docstid",dc21."docnotification" from forreaddata2021 
				LEFT JOIN admin_login 
				ON admin_login."id"=forreaddata2021."created_by"  
				INNER JOIN (select "docids","docstid","docnotification" from documentdata2021) as dc21 ON  forreaddata2021."frdocids"=dc21."docids" AND forreaddata2021."STIDACTIVE"=dc21."docstid"

				INNER JOIN (select "STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE" from forreaddata2021 where '.$cond.' '.$cond1.' '.$cond2.') as vt
				ON forreaddata2021."STIDACTIVE"=vt."STIDACTIVE"  AND forreaddata2021."SDIDACTIVE"=vt."SDIDACTIVE" AND comeaction!=\'MAIN\' AND forreaddata2021."frfromids"=vt."SDIDACTIVE" AND forreaddata2021."VTIDACTIVE"=0';

			}
			
			else if($st2021new!='' && $dt2021new=='' && $sd2021new=='')
			{

				$condnew = 'UNION ALL
				select DISTINCT (forreaddata2021."DTIDACTIVE") AS "DTIDACTIVE",forreaddata2021."frfromids",forreaddata2021."frdocids"
				,to_char(created_date at time zone \'utc\' at time zone \'Asia/Kolkata\', \'dd-mm-yyyy HH24:MI:SS\') AS createddate,forreaddata2021."created_by",forreaddata2021."frcomment"
				,admin_login."admin_name",dc21."docids",dc21."docstid",dc21."docnotification" from forreaddata2021 
				LEFT JOIN admin_login 
				ON admin_login."id"=forreaddata2021."created_by"  
				INNER JOIN (select "docids","docstid","docnotification" from documentdata2021) as dc21 ON  forreaddata2021."frdocids"=dc21."docids" AND forreaddata2021."STIDACTIVE"=dc21."docstid"

				INNER JOIN (select "STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE" from forreaddata2021 where '.$cond.' '.$cond1.' '.$cond2.') as vt
				ON forreaddata2021."STIDACTIVE"=vt."STIDACTIVE" AND comeaction!=\'MAIN\' AND (forreaddata2021."frfromids"=vt."DTIDACTIVE" OR forreaddata2021."frtoids"=vt."DTIDACTIVE") AND forreaddata2021."SDIDACTIVE"=0 AND forreaddata2021."VTIDACTIVE"=0  
				UNION ALL
				select DISTINCT (forreaddata2021."SDIDACTIVE") AS "SDIDACTIVE",forreaddata2021."frfromids",forreaddata2021."frdocids"
				,to_char(created_date at time zone \'utc\' at time zone \'Asia/Kolkata\', \'dd-mm-yyyy HH24:MI:SS\') AS createddate,forreaddata2021."created_by",forreaddata2021."frcomment"
				,admin_login."admin_name",dc21."docids",dc21."docstid",dc21."docnotification" from forreaddata2021 
				LEFT JOIN admin_login 
				ON admin_login."id"=forreaddata2021."created_by"  
				INNER JOIN (select "docids","docstid","docnotification" from documentdata2021) as dc21 ON  forreaddata2021."frdocids"=dc21."docids"

				INNER JOIN (select "STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE" from forreaddata2021 where '.$cond.' '.$cond1.' '.$cond2.') as vt
				ON forreaddata2021."STIDACTIVE"=vt."STIDACTIVE" AND comeaction!=\'MAIN\' AND forreaddata2021."frfromids"=vt."SDIDACTIVE" AND forreaddata2021."VTIDACTIVE"=0';

			}


		
		if($st2011==$st2021 && $dt2011!=$dt2021 && $sd2011!=$sd2021 && $vt2011==$vt2021)
		{
			if($is_deleted==1)
			{
				  $sql = 'select forreaddata2021."DTIDACTIVE","frfromids","frdocids",to_char(created_date at time zone \'utc\' at time zone \'Asia/Kolkata\', \'dd-mm-yyyy HH24:MI:SS\') AS createddate,forreaddata2021."created_by",
				forreaddata2021."frcomment",admin_login."admin_name",dc21."docids",dc21."docstid",dc21."docnotification"
				from forreaddata2021
				LEFT JOIN admin_login 
				ON admin_login."id"=forreaddata2021."created_by"  
				INNER JOIN (select "docids","docstid","docnotification" from documentdata2021) as dc21 ON  forreaddata2021."frdocids"=dc21."docids" AND forreaddata2021."STIDACTIVE"=dc21."docstid"
				where '.$cond.' '.$cond1.' '.$cond2.'';		
			}
			else
			{
				$sql = 'select forreaddata2021."DTIDACTIVE","frfromids","frdocids",to_char(created_date at time zone \'utc\' at time zone \'Asia/Kolkata\', \'dd-mm-yyyy HH24:MI:SS\') AS createddate,forreaddata2021."created_by",
				forreaddata2021."frcomment",admin_login."admin_name",dc21."docids",dc21."docstid",dc21."docnotification"
				from forreaddata2021
				LEFT JOIN admin_login 
				ON admin_login."id"=forreaddata2021."created_by"  
				INNER JOIN (select "docids","docstid","docnotification" from documentdata2021) as dc21 ON  forreaddata2021."frdocids"=dc21."docids"
				where '.$cond.' '.$cond1.' '.$cond2.'';	
			}
			
		}

		else if($st2011==$st2021 && $dt2011!=$dt2021 && $sd2011!=$sd2021 && $vt2011!=$vt2021)
		{
			if($is_deleted==1)
			{
				$sql='select forreaddata2021."DTIDACTIVE","frfromids","frdocids",to_char(created_date at time zone \'utc\' at time zone \'Asia/Kolkata\', \'dd-mm-yyyy HH24:MI:SS\') AS createddate,forreaddata2021."created_by",
				forreaddata2021."frcomment",admin_login."admin_name",dc21."docids",dc21."docstid",dc21."docnotification"
				from forreaddata2021
				LEFT JOIN admin_login 
				ON admin_login."id"=forreaddata2021."created_by"  
				INNER JOIN (select "docids","docstid","docnotification" from documentdata2021) as dc21 ON  forreaddata2021."frdocids"=dc21."docids"
				where '.$cond.' '.$cond1.' '.$cond2.' '.$cond8.' 
				UNION ALL
				select DISTINCT (forreaddata2021."DTIDACTIVE") AS "DTIDACTIVE",forreaddata2021."frfromids",forreaddata2021."frdocids"
				,to_char(created_date at time zone \'utc\' at time zone \'Asia/Kolkata\', \'dd-mm-yyyy HH24:MI:SS\') AS createddate,forreaddata2021."created_by",forreaddata2021."frcomment"
				,admin_login."admin_name",dc21."docids",dc21."docstid",dc21."docnotification" from forreaddata2021 
				LEFT JOIN admin_login 
				ON admin_login."id"=forreaddata2021."created_by"  
				INNER JOIN (select "docids","docstid","docnotification" from documentdata2021) as dc21 ON  forreaddata2021."frdocids"=dc21."docids"

				INNER JOIN (select "STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE" from forreaddata2021 where  '.$cond.' '.$cond1.' '.$cond2.' '.$cond8.' ) as vt
				ON forreaddata2021."STIDACTIVE"=vt."STIDACTIVE" AND (forreaddata2021."frfromids"=vt."VTIDACTIVE")';
	
			}
			else
			{
				//  $sql = 'select forreaddata2021."DTIDACTIVE","frfromids","frdocids",to_char(created_date at time zone \'utc\' at time zone \'Asia/Kolkata\', \'dd-mm-yyyy HH24:MI:SS\') AS createddate,forreaddata2021."created_by",
				// forreaddata2021."frcomment",admin_login."admin_name",dc21."docids",dc21."docstid",dc21."docnotification"
				// from forreaddata2021
				// LEFT JOIN admin_login 
				// ON admin_login."id"=forreaddata2021."created_by"  
				// INNER JOIN (select "docids","docstid","docnotification" from documentdata2021) as dc21 ON  forreaddata2021."frdocids"=dc21."docids"
				// where '.$cond.' '.$cond1.' '.$cond2.'';		



				//  echo $sql = 'select DISTINCT (forreaddata2021."DTIDACTIVE") AS "DTIDACTIVE",forreaddata2021."frfromids",forreaddata2021."frdocids"
				// ,admin_login."admin_name",dc21."docids",dc21."docstid",dc21."docnotification" from forreaddata2021 
				// ,to_char(created_date at time zone \'utc\' at time zone \'Asia/Kolkata\', \'dd-mm-yyyy HH24:MI:SS\') AS createddate,forreaddata2021."created_by",forreaddata2021."frcomment"
				// INNER JOIN (select "docids","docstid","docnotification" from documentdata2021) as dc21 ON  forreaddata2021."frdocids"=dc21."docids"
				// INNER JOIN (select "STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE" from forreaddata2021 where '.$cond.' '.$cond1.' '.$cond2.') as vt
				// LEFT JOIN admin_login 
				// ON admin_login."id"=forreaddata2021."created_by"  
				// ON forreaddata2021."STIDACTIVE"=vt."STIDACTIVE" AND (forreaddata2021."frfromids"=vt."VTIDACTIVE" OR forreaddata2021."frtoids"=vt."VTIDACTIVE")';


				$sql='select forreaddata2021."DTIDACTIVE","frfromids","frdocids",to_char(created_date at time zone \'utc\' at time zone \'Asia/Kolkata\', \'dd-mm-yyyy HH24:MI:SS\') AS createddate,forreaddata2021."created_by",
				forreaddata2021."frcomment",admin_login."admin_name",dc21."docids",dc21."docstid",dc21."docnotification"
				from forreaddata2021
				LEFT JOIN admin_login 
				ON admin_login."id"=forreaddata2021."created_by"  
				INNER JOIN (select "docids","docstid","docnotification" from documentdata2021) as dc21 ON  forreaddata2021."frdocids"=dc21."docids"
				where '.$cond.' '.$cond1.' '.$cond2.' '.$cond8.'
				UNION ALL
				select DISTINCT (forreaddata2021."DTIDACTIVE") AS "DTIDACTIVE",forreaddata2021."frfromids",forreaddata2021."frdocids"
				,to_char(created_date at time zone \'utc\' at time zone \'Asia/Kolkata\', \'dd-mm-yyyy HH24:MI:SS\') AS createddate,forreaddata2021."created_by",forreaddata2021."frcomment"
				,admin_login."admin_name",dc21."docids",dc21."docstid",dc21."docnotification" from forreaddata2021 
				LEFT JOIN admin_login 
				ON admin_login."id"=forreaddata2021."created_by"  
				INNER JOIN (select "docids","docstid","docnotification" from documentdata2021) as dc21 ON  forreaddata2021."frdocids"=dc21."docids"

				INNER JOIN (select "STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE" from forreaddata2021 where  '.$cond.' '.$cond1.' '.$cond2.' '.$cond8.' ) as vt
				ON forreaddata2021."STIDACTIVE"=vt."STIDACTIVE" AND (forreaddata2021."frfromids"=vt."VTIDACTIVE")';

			}
			
		}

		
		else if($st2011==$st2021 && $dt2011==$dt2021 && $sd2011==$sd2021 && $vt2011!=$vt2021)
		{
			if($is_deleted==1)
			{
				 $sql = 'select forreaddata2021."DTIDACTIVE","frfromids","frdocids",to_char(created_date at time zone \'utc\' at time zone \'Asia/Kolkata\', \'dd-mm-yyyy HH24:MI:SS\') AS createddate,forreaddata2021."created_by",
				forreaddata2021."frcomment",admin_login."admin_name",dc21."docids",dc21."docstid",dc21."docnotification"
				from forreaddata2021
				LEFT JOIN admin_login 
				ON admin_login."id"=forreaddata2021."created_by"  
				INNER JOIN (select "docids","docstid","docnotification" from documentdata2021) as dc21 ON  forreaddata2021."frdocids"=dc21."docids" AND forreaddata2021."STIDACTIVE"=dc21."docstid"
				where '.$cond.' '.$cond1.' '.$cond2.'';		
			}
			else
			{
				 $sql = 'select forreaddata2021."DTIDACTIVE","frfromids","frdocids",to_char(created_date at time zone \'utc\' at time zone \'Asia/Kolkata\', \'dd-mm-yyyy HH24:MI:SS\') AS createddate,forreaddata2021."created_by",
				forreaddata2021."frcomment",admin_login."admin_name",dc21."docids",dc21."docstid",dc21."docnotification"
				from forreaddata2021
				LEFT JOIN admin_login 
				ON admin_login."id"=forreaddata2021."created_by"  
				INNER JOIN (select "docids","docstid","docnotification" from documentdata2021) as dc21 ON  forreaddata2021."frdocids"=dc21."docids"
				where '.$cond.' '.$cond1.' '.$condd.' UNION ALL select forreaddata2021."DTIDACTIVE","frfromids","frdocids",to_char(created_date at time zone \'utc\' at time zone \'Asia/Kolkata\', \'dd-mm-yyyy HH24:MI:SS\') AS createddate,forreaddata2021."created_by",
				forreaddata2021."frcomment",admin_login."admin_name",dc21."docids",dc21."docstid",dc21."docnotification"
				from forreaddata2021
				LEFT JOIN admin_login 
				ON admin_login."id"=forreaddata2021."created_by"  
				INNER JOIN (select "docids","docstid","docnotification" from documentdata2021) as dc21 ON  forreaddata2021."frdocids"=dc21."docids" AND forreaddata2021."STIDACTIVE"=dc21."docstid"
				where '.$cond.' '.$cond1.' '.$cond2.'';	
			}
			
		}

		else if($st2011==$st2021 && $dt2011!=$dt2021 && $sd2011==$sd2021 && $vt2011==$vt2021)
		{
			if($is_deleted==1)
			{
				 $sql = 'select DISTINCT (forreaddata2021."DTIDACTIVE") AS "DTIDACTIVE","frfromids","frdocids",to_char(created_date at time zone \'utc\' at time zone \'Asia/Kolkata\', \'dd-mm-yyyy HH24:MI:SS\') AS createddate,forreaddata2021."created_by",
				forreaddata2021."frcomment",admin_login."admin_name",dc21."docids",dc21."docstid",dc21."docnotification"
				from forreaddata2021
				LEFT JOIN admin_login 
				ON admin_login."id"=forreaddata2021."created_by"  
				INNER JOIN (select "docids","docstid","docnotification" from documentdata2021) as dc21 ON  forreaddata2021."frdocids"=dc21."docids" AND forreaddata2021."STIDACTIVE"=dc21."docstid"
				where '.$cond.' '.$cond1.' '.$cond2.'';		
			}
			else
			{
				$sql = 'select DISTINCT (forreaddata2021."DTIDACTIVE") AS "DTIDACTIVE","frfromids","frdocids",to_char(created_date at time zone \'utc\' at time zone \'Asia/Kolkata\', \'dd-mm-yyyy HH24:MI:SS\') AS createddate,forreaddata2021."created_by",
				forreaddata2021."frcomment",admin_login."admin_name",dc21."docids",dc21."docstid",dc21."docnotification"
				from forreaddata2021
				LEFT JOIN admin_login 
				ON admin_login."id"=forreaddata2021."created_by"  
				INNER JOIN (select "docids","docstid","docnotification" from documentdata2021) as dc21 ON  forreaddata2021."frdocids"=dc21."docids" AND forreaddata2021."STIDACTIVE"=dc21."docstid"
				where '.$cond.' '.$cond1.' '.$cond2.'';	
			}
			
		}
		else if($st2011==$st2021 && $dt2011!=$dt2021 && $sd2011==$sd2021 && $vt2011!=$vt2021)
		{
			if($is_deleted==1)
			{
				$sql = 'select forreaddata2021."DTIDACTIVE","frfromids","frdocids",to_char(created_date at time zone \'utc\' at time zone \'Asia/Kolkata\', \'dd-mm-yyyy HH24:MI:SS\') AS createddate,forreaddata2021."created_by",
				forreaddata2021."frcomment",admin_login."admin_name",dc21."docids",dc21."docstid",dc21."docnotification"
				from forreaddata2021
				LEFT JOIN admin_login 
				ON admin_login."id"=forreaddata2021."created_by"  
				INNER JOIN (select "docids","docstid","docnotification" from documentdata2021) as dc21 ON  forreaddata2021."frdocids"=dc21."docids" AND forreaddata2021."STIDACTIVE"=dc21."docstid"
				where '.$cond.' '.$cond1.' '.$cond2.'
				UNION ALL
				select DISTINCT (forreaddata2021."DTIDACTIVE") AS "DTIDACTIVE",forreaddata2021."frfromids",forreaddata2021."frdocids"
				,to_char(created_date at time zone \'utc\' at time zone \'Asia/Kolkata\', \'dd-mm-yyyy HH24:MI:SS\') AS createddate,forreaddata2021."created_by",forreaddata2021."frcomment"
				,admin_login."admin_name",dc21."docids",dc21."docstid",dc21."docnotification" from forreaddata2021 
				LEFT JOIN admin_login 
				ON admin_login."id"=forreaddata2021."created_by"  
				INNER JOIN (select "docids","docstid","docnotification" from documentdata2021) as dc21 ON  forreaddata2021."frdocids"=dc21."docids"

				INNER JOIN (select "STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE" from forreaddata2021 where '.$cond.' '.$cond1.' '.$cond2.') as vt
				ON forreaddata2021."STIDACTIVE"=vt."STIDACTIVE"  AND forreaddata2021."DTIDACTIVE"=vt."DTIDACTIVE" AND forreaddata2021."SDIDACTIVE"=0 AND forreaddata2021."VTIDACTIVE"=0

				';		
			}
			else
			{
				$sql = 'select forreaddata2021."DTIDACTIVE","frfromids","frdocids",to_char(created_date at time zone \'utc\' at time zone \'Asia/Kolkata\', \'dd-mm-yyyy HH24:MI:SS\') AS createddate,forreaddata2021."created_by",
				forreaddata2021."frcomment",admin_login."admin_name",dc21."docids",dc21."docstid",dc21."docnotification"
				from forreaddata2021
				LEFT JOIN admin_login 
				ON admin_login."id"=forreaddata2021."created_by"  
				INNER JOIN (select "docids","docstid","docnotification" from documentdata2021) as dc21 ON  forreaddata2021."frdocids"=dc21."docids" AND forreaddata2021."STIDACTIVE"=dc21."docstid"
				where '.$cond.' '.$cond1.' '.$cond2.'
				UNION ALL
				select DISTINCT (forreaddata2021."DTIDACTIVE") AS "DTIDACTIVE",forreaddata2021."frfromids",forreaddata2021."frdocids"
				,to_char(created_date at time zone \'utc\' at time zone \'Asia/Kolkata\', \'dd-mm-yyyy HH24:MI:SS\') AS createddate,forreaddata2021."created_by",forreaddata2021."frcomment"
				,admin_login."admin_name",dc21."docids",dc21."docstid",dc21."docnotification" from forreaddata2021 
				LEFT JOIN admin_login 
				ON admin_login."id"=forreaddata2021."created_by"  
				INNER JOIN (select "docids","docstid","docnotification" from documentdata2021) as dc21 ON  forreaddata2021."frdocids"=dc21."docids"

				INNER JOIN (select "STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE" from forreaddata2021 where '.$cond.' '.$cond1.' '.$cond2.') as vt
				ON forreaddata2021."STIDACTIVE"=vt."STIDACTIVE"  AND forreaddata2021."DTIDACTIVE"=vt."DTIDACTIVE" AND forreaddata2021."SDIDACTIVE"=0 AND forreaddata2021."VTIDACTIVE"=0
				';	
			}
			
		}

		else if($st2011==$st2021 && $dt2011==$dt2021 && $sd2011!=$sd2021 && $vt2011==$vt2021)
		{
			if($is_deleted==1)
			{
				 $sql = 'select forreaddata2021."SDIDACTIVE","frfromids","frdocids",to_char(created_date at time zone \'utc\' at time zone \'Asia/Kolkata\', \'dd-mm-yyyy HH24:MI:SS\') AS createddate,forreaddata2021."created_by",
				forreaddata2021."frcomment",admin_login."admin_name",dc21."docids",dc21."docstid",dc21."docnotification"
				from forreaddata2021
				LEFT JOIN admin_login 
				ON admin_login."id"=forreaddata2021."created_by"  
				INNER JOIN (select "docids","docstid","docnotification" from documentdata2021) as dc21 ON  forreaddata2021."frdocids"=dc21."docids" AND forreaddata2021."STIDACTIVE"=dc21."docstid"
				where '.$cond.' '.$cond1.' '.$cond2.' ';	
				// '.$condnew.'	
			}
			else
			{
				$sql = 'select forreaddata2021."SDIDACTIVE","frfromids","frdocids",to_char(created_date at time zone \'utc\' at time zone \'Asia/Kolkata\', \'dd-mm-yyyy HH24:MI:SS\') AS createddate,forreaddata2021."created_by",
				forreaddata2021."frcomment",admin_login."admin_name",dc21."docids",dc21."docstid",dc21."docnotification"
				from forreaddata2021
				LEFT JOIN admin_login 
				ON admin_login."id"=forreaddata2021."created_by"  
				INNER JOIN (select "docids","docstid","docnotification" from documentdata2021) as dc21 ON  forreaddata2021."frdocids"=dc21."docids" AND forreaddata2021."STIDACTIVE"=dc21."docstid"
				where '.$cond.' '.$cond1.' '.$cond2.'';	
			}
			
		}
		else if($st2011==$st2021 && $dt2011==$dt2021 && $sd2011!=$sd2021 && $vt2011!=$vt2021)
		{
			if($is_deleted==1)
			{
				$sql = 'select forreaddata2021."SDIDACTIVE","frfromids","frdocids",to_char(created_date at time zone \'utc\' at time zone \'Asia/Kolkata\', \'dd-mm-yyyy HH24:MI:SS\') AS createddate,forreaddata2021."created_by",
				forreaddata2021."frcomment",admin_login."admin_name",dc21."docids",dc21."docstid",dc21."docnotification"
				from forreaddata2021
				LEFT JOIN admin_login 
				ON admin_login."id"=forreaddata2021."created_by"  
				INNER JOIN (select "docids","docstid","docnotification" from documentdata2021) as dc21 ON  forreaddata2021."frdocids"=dc21."docids" AND forreaddata2021."STIDACTIVE"=dc21."docstid"
				where '.$cond.' '.$cond1.' '.$cond2.'
				UNION ALL
				select DISTINCT (forreaddata2021."SDIDACTIVE") AS "SDIDACTIVE",forreaddata2021."frfromids",forreaddata2021."frdocids"
				,to_char(created_date at time zone \'utc\' at time zone \'Asia/Kolkata\', \'dd-mm-yyyy HH24:MI:SS\') AS createddate,forreaddata2021."created_by",forreaddata2021."frcomment"
				,admin_login."admin_name",dc21."docids",dc21."docstid",dc21."docnotification" from forreaddata2021 
				LEFT JOIN admin_login 
				ON admin_login."id"=forreaddata2021."created_by"  
				INNER JOIN (select "docids","docstid","docnotification" from documentdata2021) as dc21 ON  forreaddata2021."frdocids"=dc21."docids" AND forreaddata2021."STIDACTIVE"=dc21."docstid"

				INNER JOIN (select "STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE" from forreaddata2021 where '.$cond.' '.$cond1.' '.$cond2.') as vt
				ON forreaddata2021."STIDACTIVE"=vt."STIDACTIVE"  AND forreaddata2021."SDIDACTIVE"=vt."SDIDACTIVE" AND forreaddata2021."VTIDACTIVE"=0';		
			}
			else
			{
				$sql = 'select forreaddata2021."SDIDACTIVE","frfromids","frdocids",to_char(created_date at time zone \'utc\' at time zone \'Asia/Kolkata\', \'dd-mm-yyyy HH24:MI:SS\') AS createddate,forreaddata2021."created_by",
				forreaddata2021."frcomment",admin_login."admin_name",dc21."docids",dc21."docstid",dc21."docnotification"
				from forreaddata2021
				LEFT JOIN admin_login 
				ON admin_login."id"=forreaddata2021."created_by"  
				INNER JOIN (select "docids","docstid","docnotification" from documentdata2021) as dc21 ON  forreaddata2021."frdocids"=dc21."docids" AND forreaddata2021."STIDACTIVE"=dc21."docstid"
				where '.$cond.' '.$cond1.' '.$cond2.'
				UNION ALL
				select DISTINCT (forreaddata2021."SDIDACTIVE") AS "SDIDACTIVE",forreaddata2021."frfromids",forreaddata2021."frdocids"
				,to_char(created_date at time zone \'utc\' at time zone \'Asia/Kolkata\', \'dd-mm-yyyy HH24:MI:SS\') AS createddate,forreaddata2021."created_by",forreaddata2021."frcomment"
				,admin_login."admin_name",dc21."docids",dc21."docstid",dc21."docnotification" from forreaddata2021 
				LEFT JOIN admin_login 
				ON admin_login."id"=forreaddata2021."created_by"  
				INNER JOIN (select "docids","docstid","docnotification" from documentdata2021) as dc21 ON  forreaddata2021."frdocids"=dc21."docids" AND forreaddata2021."STIDACTIVE"=dc21."docstid"

				INNER JOIN (select "STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE" from forreaddata2021 where '.$cond.' '.$cond1.' '.$cond2.') as vt
				ON forreaddata2021."STIDACTIVE"=vt."STIDACTIVE"  AND forreaddata2021."SDIDACTIVE"=vt."SDIDACTIVE" AND forreaddata2021."VTIDACTIVE"=0
				';	
			}
			
		}


		else if($st2011==$st2021 && $dt2011==$dt2021 && $sd2011==$sd2021 && $vt2011==$vt2021)
		{
			if($is_deleted==1)
			{
				$sql = 'select forreaddata2021."DTIDACTIVE","frfromids","frdocids",to_char(created_date at time zone \'utc\' at time zone \'Asia/Kolkata\', \'dd-mm-yyyy HH24:MI:SS\') AS createddate,forreaddata2021."created_by",
				forreaddata2021."frcomment",admin_login."admin_name",dc21."docids",dc21."docstid",dc21."docnotification"
				from forreaddata2021
				LEFT JOIN admin_login 
				ON admin_login."id"=forreaddata2021."created_by"  
				INNER JOIN (select "docids","docstid","docnotification" from documentdata2021) as dc21 ON  forreaddata2021."frdocids"=dc21."docids" AND forreaddata2021."STIDACTIVE"=dc21."docstid"
				where '.$cond.' '.$cond1.' '.$cond2.'';	
			}
			else
			{
				$sql = 'select forreaddata2021."DTIDACTIVE","frfromids","frdocids",to_char(created_date at time zone \'utc\' at time zone \'Asia/Kolkata\', \'dd-mm-yyyy HH24:MI:SS\') AS createddate,forreaddata2021."created_by",
				forreaddata2021."frcomment",admin_login."admin_name",dc21."docids",dc21."docstid",dc21."docnotification"
				from forreaddata2021
				LEFT JOIN admin_login 
				ON admin_login."id"=forreaddata2021."created_by"  
				INNER JOIN (select "docids","docstid","docnotification" from documentdata2021) as dc21 ON  forreaddata2021."frdocids"=dc21."docids" AND forreaddata2021."STIDACTIVE"=dc21."docstid"
				where '.$cond.' '.$cond1.' '.$cond2.'';	
			}
			
		}
		//by sahana forread state split issue state dropdown remark
		else if($st2011!=$st2021 && $dt2011==$dt2021 && $sd2011==$sd2021){
			$sql = 'select forreaddata2021."DTIDACTIVE","frfromids","frdocids",to_char(created_date at time zone \'utc\' at time zone \'Asia/Kolkata\', \'dd-mm-yyyy HH24:MI:SS\') AS createddate,forreaddata2021."created_by",
				forreaddata2021."frcomment",admin_login."admin_name",dc21."docids",dc21."docstid",dc21."docnotification"
				from forreaddata2021
				LEFT JOIN admin_login 
				ON admin_login."id"=forreaddata2021."created_by"  
				INNER JOIN (select "docids","docstid","docnotification" from documentdata2021) as dc21 ON  forreaddata2021."frdocids"=dc21."docids" AND forreaddata2021."STID"=dc21."docstid"
				where '.$cond.' '.$cond1.' '.$cond2.'';	
		}
		//by sahana forread state split issue district dropdown remark
		else if($st2011!=$st2021 && $dt2011!=$dt2021 && $sd2011==$sd2021){
			$sql = 'select forreaddata2021."DTIDACTIVE","frfromids","frdocids",to_char(created_date at time zone \'utc\' at time zone \'Asia/Kolkata\', \'dd-mm-yyyy HH24:MI:SS\') AS createddate,forreaddata2021."created_by",
				forreaddata2021."frcomment",admin_login."admin_name",dc21."docids",dc21."docstid",dc21."docnotification"
				from forreaddata2021
				LEFT JOIN admin_login 
				ON admin_login."id"=forreaddata2021."created_by"  
				INNER JOIN (select "docids","docstid","docnotification" from documentdata2021) as dc21 ON  forreaddata2021."frdocids"=dc21."docids" AND forreaddata2021."STID"=dc21."docstid"
				where '.$cond.' '.$cond1.' '.$cond2.'';	
		}
		//by sahana forread state split issue sub district dropdown remark
		else if($st2011!=$st2021 && $dt2011!=$dt2021 && $sd2011!=$sd2021){
			$sql = 'select forreaddata2021."DTIDACTIVE","frfromids","frdocids",to_char(created_date at time zone \'utc\' at time zone \'Asia/Kolkata\', \'dd-mm-yyyy HH24:MI:SS\') AS createddate,forreaddata2021."created_by",
				forreaddata2021."frcomment",admin_login."admin_name",dc21."docids",dc21."docstid",dc21."docnotification"
				from forreaddata2021
				LEFT JOIN admin_login 
				ON admin_login."id"=forreaddata2021."created_by"  
				INNER JOIN (select "docids","docstid","docnotification" from documentdata2021) as dc21 ON  forreaddata2021."frdocids"=dc21."docids" AND forreaddata2021."STID"=dc21."docstid"
				where '.$cond.' '.$cond1.' '.$cond2.'';	
		}//by sahana forread state merge issue state dropdown remark
		else if($st2011==$st2021 && $dt2011!=$dt2021 && $sd2011!=$sd2021){
			$sql = 'select forreaddata2021."DTIDACTIVE","frfromids","frdocids",to_char(created_date at time zone \'utc\' at time zone \'Asia/Kolkata\', \'dd-mm-yyyy HH24:MI:SS\') AS createddate,forreaddata2021."created_by",
				forreaddata2021."frcomment",admin_login."admin_name",dc21."docids",dc21."docstid",dc21."docnotification"
				from forreaddata2021
				LEFT JOIN admin_login 
				ON admin_login."id"=forreaddata2021."created_by"  
				INNER JOIN (select "docids","docstid","docnotification" from documentdata2021) as dc21 ON  forreaddata2021."frdocids"=dc21."docids" AND forreaddata2021."STID"=dc21."docstid"
				where '.$cond.' '.$cond1.'';	
		}


	}
	else if($vt2011=='' && $vt2021!='')
	{

		if($st2021new!='' && $dt2021new=='' && $sd2021new!='')
		{

				if($is_deleted==1)
				{
				$sql = 'select forreaddata2021."DTIDACTIVE","frfromids","frdocids",to_char(created_date at time zone \'utc\' at time zone \'Asia/Kolkata\', \'dd-mm-yyyy HH24:MI:SS\') AS createddate,forreaddata2021."created_by",
				forreaddata2021."frcomment",admin_login."admin_name",dc21."docids",dc21."docstid",dc21."docnotification"
				from forreaddata2021
				LEFT JOIN admin_login 
				ON admin_login."id"=forreaddata2021."created_by"  
				INNER JOIN (select "docids","docstid","docnotification" from documentdata2021) as dc21 ON  forreaddata2021."frdocids"=dc21."docids" AND forreaddata2021."STIDACTIVE"=dc21."docstid"
				where '.$cond.' '.$cond1.'

				UNION ALL
				select DISTINCT ON( forreaddata2021."DTIDACTIVE") forreaddata2021."DTIDACTIVE",forreaddata2021."frfromids",forreaddata2021."frdocids"
				,to_char(created_date at time zone \'utc\' at time zone \'Asia/Kolkata\', \'dd-mm-yyyy HH24:MI:SS\') AS createddate,forreaddata2021."created_by",forreaddata2021."frcomment"
				,admin_login."admin_name",dc21."docids",dc21."docstid",dc21."docnotification" from forreaddata2021 
				LEFT JOIN admin_login 
				ON admin_login."id"=forreaddata2021."created_by"  
				INNER JOIN (select "docids","docstid","docnotification" from documentdata2021) as dc21 ON  forreaddata2021."frdocids"=dc21."docids" AND forreaddata2021."STIDACTIVE"=dc21."docstid"

				INNER JOIN (select "STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE" from forreaddata2021 where '.$cond.' '.$cond1.') as vt
				ON forreaddata2021."STIDACTIVE"=vt."STIDACTIVE"  AND forreaddata2021."DTIDACTIVE"=vt."DTIDACTIVE" AND forreaddata2021."SDIDACTIVE"=0 AND forreaddata2021."VTIDACTIVE"=0
				';	
				}
				else
				{
				$sql = 'select forreaddata2021."DTIDACTIVE","frfromids","frdocids",to_char(created_date at time zone \'utc\' at time zone \'Asia/Kolkata\', \'dd-mm-yyyy HH24:MI:SS\') AS createddate,forreaddata2021."created_by",
				forreaddata2021."frcomment",admin_login."admin_name",dc21."docids",dc21."docstid",dc21."docnotification"
				from forreaddata2021
				LEFT JOIN admin_login 
				ON admin_login."id"=forreaddata2021."created_by"  
				INNER JOIN (select "docids","docstid","docnotification" from documentdata2021) as dc21 ON  forreaddata2021."frdocids"=dc21."docids" AND forreaddata2021."STIDACTIVE"=dc21."docstid"
				where '.$cond.' '.$cond1.'

				UNION ALL
				select DISTINCT ON( forreaddata2021."DTIDACTIVE") forreaddata2021."DTIDACTIVE",forreaddata2021."frfromids",forreaddata2021."frdocids"
				,to_char(created_date at time zone \'utc\' at time zone \'Asia/Kolkata\', \'dd-mm-yyyy HH24:MI:SS\') AS createddate,forreaddata2021."created_by",forreaddata2021."frcomment"
				,admin_login."admin_name",dc21."docids",dc21."docstid",dc21."docnotification" from forreaddata2021 
				LEFT JOIN admin_login 
				ON admin_login."id"=forreaddata2021."created_by"  
				INNER JOIN (select "docids","docstid","docnotification" from documentdata2021) as dc21 ON  forreaddata2021."frdocids"=dc21."docids" AND forreaddata2021."STIDACTIVE"=dc21."docstid"

				INNER JOIN (select "STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE" from forreaddata2021 where '.$cond.' '.$cond1.') as vt
				ON forreaddata2021."STIDACTIVE"=vt."STIDACTIVE"  AND forreaddata2021."DTIDACTIVE"=vt."DTIDACTIVE" AND forreaddata2021."SDIDACTIVE"=0 AND forreaddata2021."VTIDACTIVE"=0
				';	
				}
			
			}
			else if($st2021new!='' && $dt2021new!='' && $sd2021new=='')
			{

				if($is_deleted==1)
				{
				$sql = 'select forreaddata2021."SDIDACTIVE","frfromids","frdocids",to_char(created_date at time zone \'utc\' at time zone \'Asia/Kolkata\', \'dd-mm-yyyy HH24:MI:SS\') AS createddate,forreaddata2021."created_by",
				forreaddata2021."frcomment",admin_login."admin_name",dc21."docids",dc21."docstid",dc21."docnotification"
				from forreaddata2021
				LEFT JOIN admin_login 
				ON admin_login."id"=forreaddata2021."created_by"  
				INNER JOIN (select "docids","docstid","docnotification" from documentdata2021) as dc21 ON  forreaddata2021."frdocids"=dc21."docids" AND forreaddata2021."STIDACTIVE"=dc21."docstid"
				where '.$cond.' '.$cond1.'

				UNION ALL
				select DISTINCT ON( forreaddata2021."SDIDACTIVE") forreaddata2021."SDIDACTIVE",forreaddata2021."frfromids",forreaddata2021."frdocids"
				,to_char(created_date at time zone \'utc\' at time zone \'Asia/Kolkata\', \'dd-mm-yyyy HH24:MI:SS\') AS createddate,forreaddata2021."created_by",forreaddata2021."frcomment"
				,admin_login."admin_name",dc21."docids",dc21."docstid",dc21."docnotification" from forreaddata2021 
				LEFT JOIN admin_login 
				ON admin_login."id"=forreaddata2021."created_by"  
				INNER JOIN (select "docids","docstid","docnotification" from documentdata2021) as dc21 ON  forreaddata2021."frdocids"=dc21."docids" AND forreaddata2021."STIDACTIVE"=dc21."docstid"

				INNER JOIN (select "STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE" from forreaddata2021 where '.$cond.' '.$cond1.') as vt
				ON forreaddata2021."STIDACTIVE"=vt."STIDACTIVE"  AND forreaddata2021."SDIDACTIVE"=vt."SDIDACTIVE" AND forreaddata2021."VTIDACTIVE"=0
				';	
				}
				else
				{
				$sql = 'select forreaddata2021."SDIDACTIVE","frfromids","frdocids",to_char(created_date at time zone \'utc\' at time zone \'Asia/Kolkata\', \'dd-mm-yyyy HH24:MI:SS\') AS createddate,forreaddata2021."created_by",
				forreaddata2021."frcomment",admin_login."admin_name",dc21."docids",dc21."docstid",dc21."docnotification"
				from forreaddata2021
				LEFT JOIN admin_login 
				ON admin_login."id"=forreaddata2021."created_by"  
				INNER JOIN (select "docids","docstid","docnotification" from documentdata2021) as dc21 ON  forreaddata2021."frdocids"=dc21."docids" AND forreaddata2021."STIDACTIVE"=dc21."docstid"
				where '.$cond.' '.$cond1.'

				UNION ALL
				select DISTINCT ON( forreaddata2021."SDIDACTIVE") forreaddata2021."SDIDACTIVE",forreaddata2021."frfromids",forreaddata2021."frdocids"
				,to_char(created_date at time zone \'utc\' at time zone \'Asia/Kolkata\', \'dd-mm-yyyy HH24:MI:SS\') AS createddate,forreaddata2021."created_by",forreaddata2021."frcomment"
				,admin_login."admin_name",dc21."docids",dc21."docstid",dc21."docnotification" from forreaddata2021 
				LEFT JOIN admin_login 
				ON admin_login."id"=forreaddata2021."created_by"  
				INNER JOIN (select "docids","docstid","docnotification" from documentdata2021) as dc21 ON  forreaddata2021."frdocids"=dc21."docids" AND forreaddata2021."STIDACTIVE"=dc21."docstid"

				INNER JOIN (select "STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE" from forreaddata2021 where '.$cond.' '.$cond1.') as vt
				ON forreaddata2021."STIDACTIVE"=vt."STIDACTIVE"  AND forreaddata2021."SDIDACTIVE"=vt."SDIDACTIVE" AND forreaddata2021."VTIDACTIVE"=0
				';	
				}

			}
			else if($st2021new!='' && $dt2021new!='' && $sd2021new!='')
			{

				if($is_deleted==1)
				{
				$sql = 'select forreaddata2021."DTIDACTIVE","frfromids","frdocids",to_char(created_date at time zone \'utc\' at time zone \'Asia/Kolkata\', \'dd-mm-yyyy HH24:MI:SS\') AS createddate,forreaddata2021."created_by",
				forreaddata2021."frcomment",admin_login."admin_name",dc21."docids",dc21."docstid",dc21."docnotification"
				from forreaddata2021
				LEFT JOIN admin_login 
				ON admin_login."id"=forreaddata2021."created_by"  
				INNER JOIN (select "docids","docstid","docnotification" from documentdata2021) as dc21 ON  forreaddata2021."frdocids"=dc21."docids" AND forreaddata2021."STIDACTIVE"=dc21."docstid"
				where  '.$cond.' '.$cond1.'
				
				UNION ALL
				select DISTINCT ON( forreaddata2021."DTIDACTIVE") forreaddata2021."DTIDACTIVE",forreaddata2021."frfromids",forreaddata2021."frdocids"
				,to_char(created_date at time zone \'utc\' at time zone \'Asia/Kolkata\', \'dd-mm-yyyy HH24:MI:SS\') AS createddate,forreaddata2021."created_by",forreaddata2021."frcomment"
				,admin_login."admin_name",dc21."docids",dc21."docstid",dc21."docnotification" from forreaddata2021 
				LEFT JOIN admin_login 
				ON admin_login."id"=forreaddata2021."created_by"  
				INNER JOIN (select "docids","docstid","docnotification" from documentdata2021) as dc21 ON  forreaddata2021."frdocids"=dc21."docids" AND forreaddata2021."STIDACTIVE"=dc21."docstid"

				INNER JOIN (select "STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE" from forreaddata2021 where '.$cond.' '.$cond1.') as vt
				ON forreaddata2021."STIDACTIVE"=vt."STIDACTIVE"  AND forreaddata2021."DTIDACTIVE"=vt."DTIDACTIVE" AND forreaddata2021."comeaction"!=\'MAIN\' AND forreaddata2021."frtoids"=vt."DTIDACTIVE" AND forreaddata2021."SDIDACTIVE"=0 AND forreaddata2021."VTIDACTIVE"=0
				
				UNION ALL
				select DISTINCT ON( forreaddata2021."SDIDACTIVE") forreaddata2021."SDIDACTIVE",forreaddata2021."frfromids",forreaddata2021."frdocids"
				,to_char(created_date at time zone \'utc\' at time zone \'Asia/Kolkata\', \'dd-mm-yyyy HH24:MI:SS\') AS createddate,forreaddata2021."created_by",forreaddata2021."frcomment"
				,admin_login."admin_name",dc21."docids",dc21."docstid",dc21."docnotification" from forreaddata2021 
				LEFT JOIN admin_login 
				ON admin_login."id"=forreaddata2021."created_by"  
				INNER JOIN (select "docids","docstid","docnotification" from documentdata2021) as dc21 ON  forreaddata2021."frdocids"=dc21."docids" AND forreaddata2021."STIDACTIVE"=dc21."docstid"

				INNER JOIN (select "STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE" from forreaddata2021 where '.$cond.' '.$cond1.') as vt
				ON forreaddata2021."STIDACTIVE"=vt."STIDACTIVE" AND forreaddata2021."SDIDACTIVE"=vt."SDIDACTIVE" AND forreaddata2021."comeaction"!=\'MAIN\' AND forreaddata2021."frtoids"=vt."SDIDACTIVE" AND forreaddata2021."VTIDACTIVE"=0';	
				}
				else
				{
				$sql = 'select forreaddata2021."DTIDACTIVE","frfromids","frdocids",to_char(created_date at time zone \'utc\' at time zone \'Asia/Kolkata\', \'dd-mm-yyyy HH24:MI:SS\') AS createddate,forreaddata2021."created_by",
				forreaddata2021."frcomment",admin_login."admin_name",dc21."docids",dc21."docstid",dc21."docnotification"
				from forreaddata2021
				LEFT JOIN admin_login 
				ON admin_login."id"=forreaddata2021."created_by"  
				INNER JOIN (select "docids","docstid","docnotification" from documentdata2021) as dc21 ON  forreaddata2021."frdocids"=dc21."docids" AND forreaddata2021."STIDACTIVE"=dc21."docstid"
				where  '.$cond.' '.$cond1.'
				
				UNION ALL
				select DISTINCT ON( forreaddata2021."DTIDACTIVE") forreaddata2021."DTIDACTIVE",forreaddata2021."frfromids",forreaddata2021."frdocids"
				,to_char(created_date at time zone \'utc\' at time zone \'Asia/Kolkata\', \'dd-mm-yyyy HH24:MI:SS\') AS createddate,forreaddata2021."created_by",forreaddata2021."frcomment"
				,admin_login."admin_name",dc21."docids",dc21."docstid",dc21."docnotification" from forreaddata2021 
				LEFT JOIN admin_login 
				ON admin_login."id"=forreaddata2021."created_by"  
				INNER JOIN (select "docids","docstid","docnotification" from documentdata2021) as dc21 ON  forreaddata2021."frdocids"=dc21."docids" AND forreaddata2021."STIDACTIVE"=dc21."docstid"

				INNER JOIN (select "STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE" from forreaddata2021 where '.$cond.' '.$cond1.') as vt
				ON forreaddata2021."STIDACTIVE"=vt."STIDACTIVE"  AND forreaddata2021."DTIDACTIVE"=vt."DTIDACTIVE" AND forreaddata2021."comeaction"!=\'MAIN\' AND forreaddata2021."frtoids"=vt."DTIDACTIVE" AND forreaddata2021."SDIDACTIVE"=0 AND forreaddata2021."VTIDACTIVE"=0
				
				UNION ALL
				select DISTINCT ON( forreaddata2021."SDIDACTIVE") forreaddata2021."SDIDACTIVE",forreaddata2021."frfromids",forreaddata2021."frdocids"
				,to_char(created_date at time zone \'utc\' at time zone \'Asia/Kolkata\', \'dd-mm-yyyy HH24:MI:SS\') AS createddate,forreaddata2021."created_by",forreaddata2021."frcomment"
				,admin_login."admin_name",dc21."docids",dc21."docstid",dc21."docnotification" from forreaddata2021 
				LEFT JOIN admin_login 
				ON admin_login."id"=forreaddata2021."created_by"  
				INNER JOIN (select "docids","docstid","docnotification" from documentdata2021) as dc21 ON  forreaddata2021."frdocids"=dc21."docids" AND forreaddata2021."STIDACTIVE"=dc21."docstid"

				INNER JOIN (select "STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE" from forreaddata2021 where '.$cond.' '.$cond1.') as vt
				ON forreaddata2021."STIDACTIVE"=vt."STIDACTIVE" AND forreaddata2021."SDIDACTIVE"=vt."SDIDACTIVE" AND forreaddata2021."comeaction"!=\'MAIN\' AND forreaddata2021."frtoids"=vt."SDIDACTIVE" AND forreaddata2021."VTIDACTIVE"=0';	
				}

			}
			else
			{

				if($is_deleted==1)
				{
				 $sql = 'select forreaddata2021."DTIDACTIVE","frfromids","frdocids",to_char(created_date at time zone \'utc\' at time zone \'Asia/Kolkata\', \'dd-mm-yyyy HH24:MI:SS\') AS createddate,forreaddata2021."created_by",
				forreaddata2021."frcomment",admin_login."admin_name",dc21."docids",dc21."docstid",dc21."docnotification"
				from forreaddata2021
				LEFT JOIN admin_login 
				ON admin_login."id"=forreaddata2021."created_by"  
				INNER JOIN (select "docids","docstid","docnotification" from documentdata2021) as dc21 ON  forreaddata2021."frdocids"=dc21."docids" AND forreaddata2021."STIDACTIVE"=dc21."docstid"
				where '.$cond.' '.$cond1.'';	
				}
				else
				{
				$sql = 'select forreaddata2021."DTIDACTIVE","frfromids","frdocids",to_char(created_date at time zone \'utc\' at time zone \'Asia/Kolkata\', \'dd-mm-yyyy HH24:MI:SS\') AS createddate,forreaddata2021."created_by",
				forreaddata2021."frcomment",admin_login."admin_name",dc21."docids",dc21."docstid",dc21."docnotification"
				from forreaddata2021
				LEFT JOIN admin_login 
				ON admin_login."id"=forreaddata2021."created_by"  
				INNER JOIN (select "docids","docstid","docnotification" from documentdata2021) as dc21 ON  forreaddata2021."frdocids"=dc21."docids" AND forreaddata2021."STIDACTIVE"=dc21."docstid"
				where '.$cond.' '.$cond1.'';	
				}

			}
		


	}
	
	


	



 
   $table = <<<EOT
 (
    $sql

 ) temp
EOT;

			$columns = array(
			array( 'db' => '"frcomment"','dt' => 0,'db1' => 'frcomment'),
			array( 'db' => '"createddate"','dt' => 1,'db1' => 'createddate'),
			array( 'db' => '"admin_name"','dt' => 2,'db1' => 'admin_name'),
			array( 'db' => '"docstid"','dt' => 3,'db1' => 'docstid'),
			array( 'db' => '"docnotification"','dt' => 4,'db1' => 'docnotification'),
			
			);



    


$pg_details = $databaseinfo;


require( 'ssp.class.php' );

echo json_encode(
SSP::simplenew( $_POST, $pg_details, $table, $primaryKey, $columns,$filtroAdd)
);

                
  }

  
//modified by sahana for reuse of document
else if($_POST['formname']=='getdocalreadyuploadlist_doc' ) { 
	$ye = $_SESSION['activeyears'];


	$cond='';
	$cond = 'where docids='.$_POST['docids'].' OR link_docids='.$_POST['docids'].'';

        //  $table = <<<EOT
		// (
		// 	select *,
		// 		(select REPLACE(array_to_string(array_agg( '<br>' || to_char(createddatetime at time zone 'utc' at time zone 'Asia/Kolkata', 'dd-mm-yyyy HH24:MI:SS')),',') , ',', '<hr color="black">') AS reusedate
		// 			from "reuse_document$ye" where "reuse_document$ye"."docids"="documentdata$ye"."docids"),

		// 		(select REPLACE(array_to_string(array_agg('<br><br><br>' || doc_reuse_desc),','), ',', '<hr color="black">') AS  doc_reuse_desc
		// 			from "reuse_document$ye" where "reuse_document$ye"."docids"="documentdata$ye"."docids"),
			
		// 		(select REPLACE(array_to_string(array_agg('<br><br><br>' || admin_name),','), ',', '<hr color="black">') AS allemail   
		// 			from "reuse_document$ye" as "JIGS" LEFT JOIN admin_login ON "JIGS"."created_by"=admin_login."id" where "JIGS"."docids"="documentdata$ye"."docids") 
					
		// 	from documentdata$ye $cond
		  
		// ) temp
		// EOT;

		//modified by gowthami issue related to allignment in reuse table 
		$table = <<<EOT
		(
			select *,
			(select REPLACE(array_to_string(array_agg( 
				CASE
				WHEN LENGTH(doc_reuse_desc) <= 40 THEN '<br>' || regexp_replace(to_char(createddatetime at time zone 'utc' at time zone 'Asia/Kolkata', 'dd-mm-yyyy HH24:MI:SS'), '(.{10})', '\\1<br>', 'g')
				WHEN LENGTH(doc_reuse_desc) <= 50 THEN '<br><br>' || regexp_replace(to_char(createddatetime at time zone 'utc' at time zone 'Asia/Kolkata', 'dd-mm-yyyy HH24:MI:SS'), '(.{10})', '\\1<br>', 'g')
				WHEN LENGTH(doc_reuse_desc) <= 60 THEN '<br><br><br>' || regexp_replace(to_char(createddatetime at time zone 'utc' at time zone 'Asia/Kolkata', 'dd-mm-yyyy HH24:MI:SS'), '(.{10})', '\\1<br>', 'g')
				WHEN LENGTH(doc_reuse_desc) <= 70 THEN '<br><br><br><br>' || regexp_replace(to_char(createddatetime at time zone 'utc' at time zone 'Asia/Kolkata', 'dd-mm-yyyy HH24:MI:SS'), '(.{10})', '\\1<br>', 'g')
				WHEN LENGTH(doc_reuse_desc) <= 80 THEN '<br><br><br><br><br>' || regexp_replace(to_char(createddatetime at time zone 'utc' at time zone 'Asia/Kolkata', 'dd-mm-yyyy HH24:MI:SS'), '(.{10})', '\\1<br>', 'g')
				ELSE '<br><br><br>' || regexp_replace(to_char(createddatetime at time zone 'utc' at time zone 'Asia/Kolkata', 'dd-mm-yyyy HH24:MI:SS'), '(.{10})', '\\1<br>', 'g')
				END
			),',') , ',', '<hr color="black">') AS reusedate
			from "reuse_document$ye" where "reuse_document$ye"."docids"="documentdata$ye"."docids"),
			
		  (select REPLACE(array_to_string(array_agg(
				CASE
				WHEN LENGTH(doc_reuse_desc) <= 10 THEN '<br><br><br>' || regexp_replace(doc_reuse_desc, '(.{10})', '\\1<br>', 'g')
				WHEN LENGTH(doc_reuse_desc) <= 20 THEN '<br><br>' || regexp_replace(doc_reuse_desc, '(.{10})', '\\1<br>', 'g')
					WHEN LENGTH(doc_reuse_desc) <= 30 THEN '<br>' || regexp_replace(doc_reuse_desc, '(.{10})', '\\1<br>', 'g')
					ELSE regexp_replace(doc_reuse_desc,'(.{10})', '\\1<br>', 'g')
				END
			), ','), ',', '<hr color="black">') AS doc_reuse_desc
			from "reuse_document$ye" where "reuse_document$ye"."docids"="documentdata$ye"."docids"),
		
			(select REPLACE(array_to_string(array_agg(
				CASE
					WHEN LENGTH(doc_reuse_desc) <= 40 THEN '<br><br><br>' || regexp_replace(created_by, '(.{10})', '\\1<br>', 'g')
					WHEN LENGTH(doc_reuse_desc) <= 50 THEN '<br><br><br><br>' || regexp_replace(created_by, '(.{10})', '\\1<br>', 'g')
					WHEN LENGTH(doc_reuse_desc) <= 60 THEN '<br><br><br><br><br>' || regexp_replace(created_by, '(.{10})', '\\1<br>', 'g')
					WHEN LENGTH(doc_reuse_desc) <= 70 THEN '<br><br><br><br><br><br>' || regexp_replace(created_by, '(.{10})', '\\1<br>', 'g')
					WHEN LENGTH(doc_reuse_desc) <= 80 THEN '<br><br><br><br><br><br><br>' || regexp_replace(created_by, '(.{10})', '\\1<br>', 'g')
					ELSE '<br>' || regexp_replace(created_by, '(.{10})', '\\1<br>', 'g')
					END
			) ,','), ',', '<hr color="black">') AS allemail   
			from "reuse_document$ye" where "reuse_document$ye"."docids"="documentdata$ye"."docids") 
			
			from documentdata$ye $cond
		) temp
		EOT;

			   $primaryKey='docids' ; 
			   $columns=array(
                array( 'db'=> '"docids"','db1'=> 'docids','dt' => 0),
                array( 'db'=> '"docids"','db1' => 'docids','dt' => 1),
				array( 'db'=> '"docnotification"','db1' => 'docnotification','dt' => 2),
				//modified by sahana to replace Others and Others (Link Document) with the value specified.
								array(
									'db' => 'CASE WHEN doctype = \'Others\' THEN CONCAT(\'Others: \',  \'<span style="font-weight:bold;color:#1C39BB;">\', doctypeother , \'</span>\')
												WHEN doctype = \'Others (Link Document)\' THEN CONCAT(\'Others (Link Document): \', \'<span style="font-weight:bold;color:#1C39BB;">\', doctypeother, \'</span>\')
												ELSE doctype END AS doctype',
									'db1' => 'doctype',
									'dt' => 3
								),
			
                array( 'db'=> '"doctitle"','db1' => 'doctitle','dt' => 4),
                array( 'db'=> '"docdate"','db1' => 'docdate', 'dt' => 5,
                'formatter' => function( $d, $row ) {
                if (!is_null($d))

                return date( 'd-m-Y', strtotime($d));
                } ),
               
                array( 'db'=> '"docdescription"','db1' => 'docdescription','dt' => 6),	
				array( 'db'=> '"created_by"','db1' => 'created_by','dt' => 7),	//modified by sahana JC_22
				array( 'db'=> '"currentdatetime"','db1' => 'currentdatetime','dt' => 8,
				'formatter' => function( $d, $row ) {
					if (!is_null($d))
					return date( 'd-m-Y H:i:s', strtotime($d));
					}),	//modified by sahana JC_22
                array( 'db'=> '"reusedate"','db1' => 'reusedate','dt' => 9),
                array( 'db'=> '"allemail"','db1' => 'allemail','dt' => 10),
				array( 'db'=> '"doc_reuse_desc"','db1' => 'doc_reuse_desc','dt' => 11),	//modified by sahana JC_22
                array( 'db'=> '"reusedate"','db1' => 'reusedate','dt' => 9),
                array( 'db'=> '"allemail"','db1' => 'allemail','dt' => 10),
				array( 'db'=> '"doc_reuse_desc"','db1' => 'doc_reuse_desc','dt' => 11),


				array('db'=> '"docstatus"','db1' => 'docstatus', 'dt' => 12,
				'formatter' => function( $d, $row ) {
					//modified by sahana to differentiate between document and link document and redirecting to action page 
					if ($row['doctype'] == 'Notification' || $row['doctype'] == 'Erratum Notification' || $row['doctype'] == 'Resolution' || $row['doctype'] == 'Clarification' || $row['doctype'] == 'Collector Letter') {
						if ($d == 0) {
							// $data = '<span class="badge badge-purple jigs" data-id="'.$row[0].'" onclick="return getselecteddocumentredirect(\''.$row['docids'].'\',\'comefromdoc\',\'pop\');">Pending - Only Document Uploaded</span>';
							// SR No. 9 by sahana
							if ($row['created_by']==$_SESSION['login_email']) {
								$data = '<span class="badge badge-purple jigs" data-id="'.$row[0].'" onclick="return getselecteddocumentredirect(\''.$row['docids'].'\',\'comefromdoc\',\'pop\');">Pending - Only Document Uploaded</span>';
							} else {
								$data = '<span class="badge badge-purple jigs" data-id="'.$row[0].'" style="cursor:not-allowed">Pending - Only Document Uploaded</span>';
							}
						} else if ($d == 1) {
							$data = '<span class="badge badge-success" style="cursor: not-allowed;">Completed</span>';
						} else {
							$data = '<span class="badge badge-warning" style="cursor: not-allowed;">Partially Incomplete</span>';
						}
					} else if 
						 (strpos($row['doctype'], 'Others: ') !== false) {
							if ($d == 0) {
								// $data = '<span class="badge badge-purple jigs" data-id="' . $row[0] . '" onclick="return getselecteddocumentredirect(\'' . $row['docids'] . '\',\'comefromdoc\',\'pop\');">Pending - Only  Document Uploaded</span>';
								// SR No. 9 by sahana
								if ($row['created_by']==$_SESSION['login_email']) {
									$data = '<span class="badge badge-purple jigs" data-id="' . $row[0] . '" onclick="return getselecteddocumentredirect(\'' . $row['docids'] . '\',\'comefromdoc\',\'pop\');">Pending - Only  Document Uploaded</span>';
								}
								else {
									$data = '<span class="badge badge-purple jigs" data-id="'.$row[0].'" style="cursor:not-allowed">Pending - Only Document Uploaded</span>';
								}
							} else if ($d == 1 ) {
								$data = '<span class="badge badge-success" style="cursor: not-allowed;">Completed</span>';
							} else {
								$data = '<span class="badge badge-warning" style="cursor: not-allowed;">Partially Incomplete</span>';
							}
					}
					else {
                        if ($d == 0) {
                            // $data = '<span class="badge badge-purple jigs" data-id="'.$row[0].'" onclick="return getselecteddocumentredirect(\''.$row['docids'].'\',\'comefromdoc\',\'pop\');">Pending - Only Link Document Uploaded</span>';
							// SR No. 9 by sahana
							if ($row['created_by']==$_SESSION['login_email']) {
                            	$data = '<span class="badge badge-purple jigs" data-id="'.$row[0].'" onclick="return getselecteddocumentredirect(\''.$row['docids'].'\',\'comefromdoc\',\'pop\');">Pending - Only Link Document Uploaded</span>';
							}
							else {
								$data = '<span class="badge badge-purple jigs" data-id="'.$row[0].'" style="cursor:not-allowed">Pending - Only Link Document Uploaded</span>';
							}
						
						} else if ($d == 1) {
                            if ($row['docreferance'] == 1){ //modified by sahana to differentaite with action and without action in link document status
                                $data = '<span class="badge badge-success" style="cursor: not-allowed;">Link Document Completed With Action</span>';
                             }
                             else {
                                $data = '<span class="badge badge-success" style="cursor: not-allowed; background-color:#7DC41D">Link Document Completed Without Action</span>';
                             }
                        } else {
                            $data = '<span class="badge badge-warning" style="cursor: not-allowed;">Link Document Partially Incomplete</span>';
                        }
                    }

					return $data;
				}),
				array('db'=> '"docstatus"','db1' => 'docstatus', 'dt' => 13),
				array('db'=> '"freezed"','db1' => 'freezed', 'dt' => 14),
				array('db'=> '"docreferance"','db1' => 'docreferance', 'dt' => 15) //modified by sahana to differentaite with action and without action in link document status
                );
				
				
                $pg_details = $databaseinfo;

                // $filtroAdd=" (\"docids\" = ".$_POST['docids']." OR link_docids='".$_POST['docids']."')";

                require( 'ssp.class.php' );

                echo json_encode(
                SSP::simple( $_POST, $pg_details, $table, $primaryKey, $columns,$filtroAdd)
                );

                
  }


// modified by sahana to freeze the document
else if ($_POST['formname'] === 'updatefreeze') {
    $docids = $_POST['docids'];
    $isFreezed = $_POST['isFreezed'];

    // Check if the document is completed before freezing
    $selectQuery = "SELECT * FROM documentdata" . $_SESSION['activeyears'] . " WHERE link_docids = $1 AND (docstatus = 0 OR docstatus = 2)";
    $selectResult = pg_query_params($db, $selectQuery, array($docids));
    $numRows = pg_num_rows($selectResult);

    if ($numRows > 0) {
        // Document is not completed, echo "Don't freeze" message
        // echo "Please complete the document before freezing.";
		$task ='dontfreeze';
		echo $task;
    } 
	else {
        // Update the database table with the freeze status
        $updateQuery = 'UPDATE documentdata' . $_SESSION['activeyears'] . ' SET freezed = $1 WHERE "docids" = $2';
        $updateResult = pg_query_params($db, $updateQuery, array($isFreezed, $docids));
        $resultRows = pg_affected_rows($updateResult);

        if ($resultRows !== 0) {
            // Execute the query to update the freezed values
            $updateQuery = "UPDATE documentdata" . $_SESSION['activeyears'] . "
                            SET freezed = " . ($isFreezed ? "1" : "0") . "
                            WHERE link_docids IN (SELECT docids FROM documentdata" . $_SESSION['activeyears'] . " WHERE freezed = " . ($isFreezed ? "1" : "0") . ")";
            $updateResult = pg_query($db, $updateQuery);

            // Check if the update query was successful
            if ($updateResult) {
                $task = 'updatedata';
            }
        } else {
            $task = 'error';
        }

        echo $task;
    }
}


else if($_POST['formname']=='olddocselect')
{
	
	$ids = '';
	if(isset($_POST['flag']) && $_POST['flag']=='drop')
	{
		$ids = $_POST['id'];
	}
	else
	{
		$ids = $_POST['id'][0];
	}
	$task = "";

if($_POST['comefromdoc']=='comefromdocadd')
{
	$array = array('1',$ids);
	$sqlcheck = "select documentdata".$_SESSION['activeyears'].".*,st".$_SESSION['activeyears'].".\"STName\" from documentdata".$_SESSION['activeyears']." , st".$_SESSION['activeyears']." where documentdata".$_SESSION['activeyears'].".docstatus=$1 AND documentdata".$_SESSION['activeyears'].".docids=$2 AND st".$_SESSION['activeyears'].".\"STID\"=documentdata".$_SESSION['activeyears'].".docstid";


}
else
{
	$array = array('0','1',$ids);
	$sqlcheck = "select documentdata".$_SESSION['activeyears'].".*,st".$_SESSION['activeyears'].".\"STName\" from documentdata".$_SESSION['activeyears']." , st".$_SESSION['activeyears']." where (documentdata".$_SESSION['activeyears'].".docstatus=$1 OR documentdata".$_SESSION['activeyears'].".docstatus=$2) AND documentdata".$_SESSION['activeyears'].".docids=$3 AND st".$_SESSION['activeyears'].".\"STID\"=documentdata".$_SESSION['activeyears'].".docstid";

}
	
	$querydata = pg_query_params($db,$sqlcheck,$array);
	$fch = pg_fetch_array($querydata);

	$target = "Alldocuments/".$fch['docstid']."/".$fch['docnotification'];
			

				$task = "adddata|".$fch['docids']."|".$target."|".$fch['STName']."|".$fch['docstid']."|".$_POST['flag'];

	echo $task;

}

//original document code do not touch
// //modified by sahana to validated filesize fro document 
// else if($_POST['formname']=='adddocumentdata')
// {

// $oldfilename = pathinfo($_FILES['adddocnotification']['name'], PATHINFO_FILENAME);
// $uploadedFileSize = $_FILES['adddocnotification']['size'];
// $task = ""; 

// $foldername = $_POST['addSTID2021'];
// $whe="";
// 	if($_POST['doctype']!='')
// 	{
// 		// $whe="AND doctype='".$_POST['doctype']."'";
// 		$array = array($_POST['addSTID2021'],'0',date("Y-m-d", strtotime($_POST['adddocdate'])),pg_escape_string($_POST['adddoctitle']),$oldfilename,$_POST['doctype']);
//  $sqlcheck = "select * from documentdata".$_SESSION['activeyears']." where docstid=$1 AND docstatus=$2 AND doctype=$6 AND (docdate=$3 OR doctitle=$4 OR originaldocname=$5)";

// 	}
// 	else
// 	{
// 	$array = array($_POST['addSTID2021'],'0',date("Y-m-d", strtotime($_POST['adddocdate'])),pg_escape_string($_POST['adddoctitle']),$oldfilename);
//  $sqlcheck = "select * from documentdata".$_SESSION['activeyears']." where docstid=$1 AND docstatus=$2 AND (docdate=$3 OR doctitle=$4 OR originaldocname=$5)";
 	
// 	}
	

// $querydata = pg_query_params($db,$sqlcheck,$array);

// if(pg_numrows($querydata)>0 && $_POST['adddocnew']=='')
// {
// 		$task = "aleradydatedata|".$_POST['addSTID2021']."|".$_POST['adddocdate']."|".$_POST['adddoctitle']."|".$oldfilename."|".$_POST['doctype'];	
// }

// else
// {

// 		$filesizeMatches = false;

// 		$sqlFileSize = "SELECT docids, filesize FROM documentdata".$_SESSION['activeyears'];
// 		$queryFileSize = pg_query($db, $sqlFileSize);

// 		while ($row = pg_fetch_assoc($queryFileSize)) {
// 			if ($row['filesize'] == $uploadedFileSize) {
// 				$filesizeMatches = true;
// 				break; 
// 			}
// 		}

// 		if ($filesizeMatches) {
// 			$task = "filesizeerror|";
			
// 		} 
// 		else {

// 			$structure = 'Alldocuments/'.$foldername.'';

// 			if (!file_exists("Alldocuments/". $foldername)) {
// 				mkdir("Alldocuments/". $foldername);
// 			}

// 			$foldername = $_POST['addSTID2021'];

// 			$structure = 'Alldocuments/'.$foldername.'';


// 			if (!file_exists("Alldocuments/". $foldername)) {
// 				mkdir("Alldocuments/". $foldername,0777, true);
// 			}

// 			$ext = pathinfo($_FILES['adddocnotification']['name'], PATHINFO_EXTENSION);

// 			$filename = str_replace("/","-",$_POST['adddoctitle'])." DT ".date("d-m-Y", strtotime($_POST['adddocdate'])).".".$ext ;

// 			$target = "Alldocuments/".$_POST['addSTID2021']."/".htmlspecialchars($filename);

// 			if(move_uploaded_file($_FILES['adddocnotification']['tmp_name'], $target)) 
// 			{ 

// 				if(isset($_POST['otherremarks']) && $_POST['otherremarks']!='')
// 				{
// 					$ot=$_POST['otherremarks'];
// 				}
// 				else
// 				{
// 					$ot='';	
// 				}


// 				if(isset($_POST['haveaaction']))
// 				{
// 					$hac=1;
// 				}
// 				else
// 				{
// 						if(isset($_POST['selectdocumnent_releted']) && $_POST['selectdocumnent_releted']=='')
// 						{
// 							$hac=1;	
// 						}
// 						else
// 						{
// 							$hac=0;	
// 						}
					
				
				
// 				}
// 				$stat='';
// 				if($hac==0)
// 				{
// 					$stat=1;
// 				}
// 				else
// 				{
// 					$stat=0;
// 				}

// 				//modified by sahana to differentaite with action and without action in link document status
// 				if(isset($_POST['selectdocumnent_releted']) && $_POST['selectdocumnent_releted']!='')
// 				{
// 					$docreferance = $hac; // modified by sahana Store the value of $hac in $docreferance || modified by sahana JC_22
// 					$created_by = $_SESSION['login_email'];
// 					$filesize = $_FILES['adddocnotification']['size'];
// 					date_default_timezone_set('Asia/Kolkata');
// 					$currentdatetime = date("Y-m-d H:i:s");
// 					$arraysub =array($_POST['addSTID2021'],$_POST['adddoctype'],date("Y-m-d", strtotime($_POST['adddocdate'])),pg_escape_string($_POST['adddoctitle']),pg_escape_string($_POST['docdescription']),$filename,$_FILES['adddocnotification']['name'],$stat,$ot,$_POST['adddockeydes'],$_POST['selectdocumnent_releted'],$docreferance,$created_by,$filesize,$currentdatetime);
// 					$query = "INSERT INTO documentdata".$_SESSION['activeyears']." (\"docstid\",\"doctype\",\"docdate\",\"doctitle\",\"docdescription\",\"docnotification\",\"originaldocname\",\"docstatus\",\"doctypeother\",\"adddockeydes\",\"link_docids\",\"docreferance\",\"created_by\",\"filesize\",\"currentdatetime\") values ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14,$15) returning docids";
// 					$result = pg_query_params($db,$query,$arraysub);
// 				}
// 				else
// 				{
// 					$created_by = $_SESSION['login_email'];
// 					$filesize = $_FILES['adddocnotification']['size'];
// 					date_default_timezone_set('Asia/Kolkata');
// 					$currentdatetime = date("Y-m-d H:i:s");
// 					$arraysub =array($_POST['addSTID2021'],$_POST['adddoctype'],date("Y-m-d", strtotime($_POST['adddocdate'])),pg_escape_string($_POST['adddoctitle']),pg_escape_string($_POST['docdescription']),$filename,$_FILES['adddocnotification']['name'],$ot,$_POST['adddockeydes'],$created_by,$filesize,$currentdatetime);
// 					$query = "INSERT INTO documentdata".$_SESSION['activeyears']." (\"docstid\",\"doctype\",\"docdate\",\"doctitle\",\"docdescription\",\"docnotification\",\"originaldocname\",\"doctypeother\",\"adddockeydes\",\"created_by\",\"filesize\",\"currentdatetime\") values ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12) returning docids";
// 					$result = pg_query_params($db,$query,$arraysub);
// 				}
			
				

// 				if($result) 
// 					{
// 						$fch = pg_fetch_row($result);

// 						$task = "adddata|".$fch[0]."|".$target."|".urldecode($_POST['stname'])."|".$_POST['addSTID2021']."|".$_POST['adddocnew']."|".$hac;
// 					}
// 					else
// 					{
// 					$task = "error|";
// 					}

// 			}
// 			else 
// 			{

// 			$task = "fileuploadproblem|";
// 			} 

// 		}

// }

// echo $task;

// }


//new document code modified by sahana 
else if($_POST['formname']=='adddocumentdata')
{

$oldfilename = pathinfo($_FILES['adddocnotification']['name'], PATHINFO_FILENAME);
$uploadedFileSize = $_FILES['adddocnotification']['size'];
$task = ""; 

$foldername = $_POST['addSTID2021'];
$whe="";
// 	if($_POST['doctype']!='')
// 	{
// 		// $whe="AND doctype='".$_POST['doctype']."'";
// 		$array = array($_POST['addSTID2021'],'0',date("Y-m-d", strtotime($_POST['adddocdate'])),pg_escape_string($_POST['adddoctitle']),$oldfilename,$_POST['doctype']);
//  $sqlcheck = "select * from documentdata".$_SESSION['activeyears']." where docstid=$1 AND docstatus=$2 AND doctype=$6 AND (docdate=$3 OR doctitle=$4 OR originaldocname=$5)";

// 	}
// 	else
// 	{
// 	$array = array($_POST['addSTID2021'],'0',date("Y-m-d", strtotime($_POST['adddocdate'])),pg_escape_string($_POST['adddoctitle']),$oldfilename);
//  $sqlcheck = "select * from documentdata".$_SESSION['activeyears']." where docstid=$1 AND docstatus=$2 AND (docdate=$3 OR doctitle=$4 OR originaldocname=$5)";
 	
// 	}
	

// $querydata = pg_query_params($db,$sqlcheck,$array);

// if(pg_numrows($querydata)>0 && $_POST['adddocnew']=='')
// {
// 		$task = "aleradydatedata|".$_POST['addSTID2021']."|".$_POST['adddocdate']."|".$_POST['adddoctitle']."|".$oldfilename."|".$_POST['doctype'];	
// }

// else
// {

		$filesizeMatches = false;


		// $sqlFileSize = "SELECT docids, filesize FROM documentdata".$_SESSION['activeyears']; pg_query
		$sqlFileSize = "SELECT docstid, filesize FROM documentdata".$_SESSION['activeyears']." WHERE docstid=$1";
		$queryFileSize = pg_query_params($db, $sqlFileSize, array($_POST['addSTID2021']));

		while ($row = pg_fetch_assoc($queryFileSize)) {
			if ($row['filesize'] == $uploadedFileSize) {
				$filesizeMatches = true;
				break; 
			}
		}

		if ($filesizeMatches) {
			$task = "filesizeerror|";
			// $task = "aleradydatedata|".$_POST['addSTID2021']."|".$_POST['adddocdate']."|".$_POST['adddoctitle']."|".$oldfilename."|".$_POST['doctype'];	
			
		} 
		else {

			$structure = 'Alldocuments/'.$foldername.'';

			if (!file_exists("Alldocuments/". $foldername)) {
				mkdir("Alldocuments/". $foldername);
			}

			$foldername = $_POST['addSTID2021'];

			$structure = 'Alldocuments/'.$foldername.'';


			if (!file_exists("Alldocuments/". $foldername)) {
				mkdir("Alldocuments/". $foldername,0777, true);
			}

			$ext = pathinfo($_FILES['adddocnotification']['name'], PATHINFO_EXTENSION);

			$filename = str_replace(["&","/"],"-",$_POST['adddoctitle'])." DT ".date("d-m-Y", strtotime($_POST['adddocdate'])).".".$ext ;

			$target = "Alldocuments/".$_POST['addSTID2021']."/".htmlspecialchars($filename);

			if(move_uploaded_file($_FILES['adddocnotification']['tmp_name'], $target)) 
			{ 

				if(isset($_POST['otherremarks']) && $_POST['otherremarks']!='')
				{
					$ot=$_POST['otherremarks'];
				}
				else
				{
					$ot='';	
				}


				if(isset($_POST['haveaaction']))
				{
					$hac=1;
				}
				else
				{
						if(isset($_POST['selectdocumnent_releted']) && $_POST['selectdocumnent_releted']=='')
						{
							$hac=1;	
						}
						else
						{
							$hac=0;	
						}
					
				
				
				}
				$stat='';
				if($hac==0)
				{
					$stat=1;
				}
				else
				{
					$stat=0;
				}

				//modified by sahana to differentaite with action and without action in link document status
				if(isset($_POST['selectdocumnent_releted']) && $_POST['selectdocumnent_releted']!='')
				{
					$docreferance = $hac; // modified by sahana Store the value of $hac in $docreferance || modified by sahana JC_22
					$created_by = $_SESSION['login_email'];
					$filesize = $_FILES['adddocnotification']['size'];
					date_default_timezone_set('Asia/Kolkata');
					$currentdatetime = date("Y-m-d H:i:s");
					$arraysub =array($_POST['addSTID2021'],$_POST['adddoctype'],date("Y-m-d", strtotime($_POST['adddocdate'])),pg_escape_string($_POST['adddoctitle']),pg_escape_string($_POST['docdescription']),$filename,$_FILES['adddocnotification']['name'],$stat,$ot,$_POST['adddockeydes'],$_POST['selectdocumnent_releted'],$docreferance,$created_by,$filesize,$currentdatetime);
					$query = "INSERT INTO documentdata".$_SESSION['activeyears']." (\"docstid\",\"doctype\",\"docdate\",\"doctitle\",\"docdescription\",\"docnotification\",\"originaldocname\",\"docstatus\",\"doctypeother\",\"adddockeydes\",\"link_docids\",\"docreferance\",\"created_by\",\"filesize\",\"currentdatetime\") values ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14,$15) returning docids";
					$result = pg_query_params($db,$query,$arraysub);
				}
				else
				{
					$created_by = $_SESSION['login_email'];
					$filesize = $_FILES['adddocnotification']['size'];
					date_default_timezone_set('Asia/Kolkata');
					$currentdatetime = date("Y-m-d H:i:s");
					$arraysub =array($_POST['addSTID2021'],$_POST['adddoctype'],date("Y-m-d", strtotime($_POST['adddocdate'])),pg_escape_string($_POST['adddoctitle']),pg_escape_string($_POST['docdescription']),$filename,$_FILES['adddocnotification']['name'],$ot,$_POST['adddockeydes'],$created_by,$filesize,$currentdatetime);
					$query = "INSERT INTO documentdata".$_SESSION['activeyears']." (\"docstid\",\"doctype\",\"docdate\",\"doctitle\",\"docdescription\",\"docnotification\",\"originaldocname\",\"doctypeother\",\"adddockeydes\",\"created_by\",\"filesize\",\"currentdatetime\") values ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12) returning docids";
					$result = pg_query_params($db,$query,$arraysub);
				}
			
				

				if($result) 
					{
						$fch = pg_fetch_row($result);

						$task = "adddata|".$fch[0]."|".$target."|".urldecode($_POST['stname'])."|".$_POST['addSTID2021']."|".$_POST['adddocnew']."|".$hac;
					}
					else
					{
					$task = "error|";
					}

			}
			else 
			{

			$task = "fileuploadproblem|";
			} 

		}

// }

echo $task;

}





else if($_POST['formname']=='getdataofpopupsub_list')
{
		

			$row = array();

				$where = '';
				if($_POST['fstids']!='')
				{
					$where = ' AND "STID" IN ('.$_POST['fstids'].')';
					$array = array(1,$_POST['fstids']);
					 $query = 'select "DTID" as "id","DTName" as "Name" from "dt'.$_SESSION['activeyears'].'" where is_deleted=$1 AND "STID" = Any(string_to_array($2::text, \',\'::text)::integer[]) order by "DTName" ASC';

					 $resultstatelk = pg_query_params($db, $query,$array);

				}
				else
				{
					$array = array('1');
					 $query = 'select "DTID" as "id","DTName" as "Name" from "dt'.$_SESSION['activeyears'].'" where is_deleted=$1 order by "DTName" ASC';

					 $resultstatelk = pg_query_params($db, $query,$array);

				}

			
			if(pg_numrows($resultstatelk)>0)
			{
			$row = pg_fetch_all($resultstatelk); 	
				$task1 .='<div class="col-md-6"> 
															
															<select multiple="multiple" required id="selected_comesub" class="multi-select" name="selected_comesub[]">';
															foreach($row as $key => $element) {
															$task1 .='<option value="'.$element['id'].'">'.$element['Name'].'
															</option>';
															}

															$task1 .='</select></div>';
															if($_POST['comefrom']=='Sub-District')
															{
																$task1 .='<div class="mt-2 ml-3"><input type="checkbox" onclick="handleClick(this,0,\'submerge\');" name="haveapartially0[]" class="haveapartially" id="0" > <label for="checkbox2">Any '.$_POST['comefrom'].' Partially Split & Sub Merge </label></div><div id="selectedlist0" class="col-md-6 mb-2"></div>';	
															}
															
			}


			
			

echo json_encode($row)."|".$_POST['comefrom']."|".$_POST['clickpopup']."|".$task1;
  exit();

}


else if($_POST['formname']=='getdataofpopupsub_vtlist')
{
		// SWWWWW

			$row = array();
			$where = '';
		    $array = array($_POST['fstids'],$_POST['fdtids'],$_POST['fsdids']);
		    $arraydata = array(1,$_POST['fstids'],$_POST['fdtids'],$_POST['fsdids']);
		    $array1 = array('STID','DTID','SDID');
			$o=1;
			// jc_b
			$i = $_POST['i'];
			// end
			for($j=0;$j<count($array);$j++)
			{
				if($array[$j]!='')
				{
					$o=$o+1;
					$where .= ' AND "'.$array1[$j].'" = Any(string_to_array($'.$o.'::text, \',\'::text)::bigint[])';
					//$where .= ' AND "'.$array1[$j].'" IN ($'.$o.')';
				}
			}


			// code changed by Bheema for ASC the Village Names
			$query = 'SELECT "VTID" as "id", CONCAT_WS(\' - \', "VTName", "MDDS_VT") as "Name"
    FROM "vt'.$_SESSION['activeyears'].'"
    WHERE is_deleted = $1 '.$where.'
    ORDER BY "Name" ASC';

			// concat("VTName",\' - \',"MDDS_VT")
			$resultstatelk = pg_query_params($db, $query,$arraydata); // total count
			$datacount = pg_num_rows($resultstatelk); // total count
			if(pg_numrows($resultstatelk)>0)
			{
			$row = pg_fetch_all($resultstatelk); 	
				// jc_b
				$task1 .='<div class="col-md-6"> 
															
															<select multiple="multiple" required id="selected_comesub'.$i.'" class="multi-select" name="selected_comesub'.$i.'[]">';
															foreach($row as $key => $element) {
															$task1 .='<option value="'.$element['id'].'">'.$element['Name'].'</option>';
															}

															$task1 .='</select><div class="mt-2">Total Selected Village(s)/Town(s) : <span id="totaldefultselected_'.$i.'">0</span> - out of : <span> '.$datacount.' </span></div></div>'; //total count
															if($_POST['comefrom']=='Village / Town')
															{
																$task1 .='<div class="mt-2 ml-3"><input type="checkbox" onclick="handleClick(this,'.$i.',\'submerge\');" name="haveapartially'.$i.'[]" class="haveapartially" id="'.$i.'" > <label for="checkbox2">Any '.$_POST['comefrom'].' partially Split & Sub Merge </label></div><div id="selectedlist'.$i.'" class="col-md-6 mb-2"></div>';	
															}
															
			}
			// end

			
			

echo json_encode($row)."|".$_POST['comefrom']."|".$_POST['clickpopup']."|".$task1;
  exit();

}


else if($_POST['formname']=='getdataofpopupsub_sublist')
{
		

			$row = array();
			$where = '';
		    $array = array($_POST['fstids'],$_POST['fdtids']);
		    $arraydata = array(1,$_POST['fstids'],$_POST['fdtids']);
		    $array1 = array('STID','DTID');
			$o=1;

			for($j=0;$j<count($array);$j++)
			{
				if($array[$j]!='')
				{
					$o=$o+1;
					$where .= ' AND "'.$array1[$j].'" = Any(string_to_array($'.$o.'::text, \',\'::text)::integer[])';
					//$where .= ' AND "'.$array1[$j].'" IN ($'.$o.')';
				}
			}


			 $query = 'select "SDID" as "id","SDName" as "Name" from "sd'.$_SESSION['activeyears'].'" where is_deleted=$1 '.$where.' order by "SDName" ASC';

			$resultstatelk = pg_query_params($db, $query,$arraydata);
			if(pg_numrows($resultstatelk)>0)
			{
			$row = pg_fetch_all($resultstatelk); 	
				$task1 .='<div class="col-md-6"> 
															
															<select multiple="multiple" required id="selected_comesub" class="multi-select" name="selected_comesub[]">';
															foreach($row as $key => $element) {
															$task1 .='<option value="'.$element['id'].'">'.$element['Name'].'
															</option>';
															}

															$task1 .='</select></div>';
															if($_POST['comefrom']=='Sub-District')
															{
																$task1 .='<div class="mt-2 ml-3"><input type="checkbox" onclick="handleClick(this,0,\'submerge\');" name="haveapartially0[]" class="haveapartially" id="0" > <label for="checkbox2">Any '.$_POST['comefrom'].' Partially Split & Sub Merge </label></div><div id="selectedlist0" class="col-md-6 mb-2"></div>';	
															}
															
			}


			
			

echo json_encode($row)."|".$_POST['comefrom']."|".$_POST['clickpopup']."|".$task1;
  exit();

}


else if($_POST['formname']=='getdataofpopupsub')
{


if($_POST['clickpopup']=='Create' ||  $_POST['clickpopup']=='Addition' || $_POST['clickpopup']=='Merge' || $_POST['clickpopup']=='Partiallysm' || $_POST['clickpopup']=='Reshuffle' ) 
{


		$row = array();

		$rowaction = array();



			// $where = "";
			// if(isset($_POST['fsdids']) && $_POST['fsdids']!='')
			// {
			// 	$where = ' and "SDID" IN('.$_POST['fsdids'].')';
			// }

			// $wherest = "";
			// if(isset($_POST['fstids']) && $_POST['fstids']!='')
			// {
			// 	$wherest = ' and "STID" IN ('.$_POST['fstids'].')';
			// }

			



			$wheredt = "";
			if(isset($_POST['fdtids']) && $_POST['fdtids']!='')
			{
				$wheredt = ' and "DTID" IN ('.$_POST['fdtids'].')';
			}


			$where = '';
		    $array = array($_POST['fstids'],$_POST['fdtids'],$_POST['fsdids']);
		   //  $arraydata = array(1,$_POST['fstids'],$_POST['fdtids'],$_POST['fsdids']);
		    $array1 = array('STID','DTID','SDID');
			$o=1;
			$arraydata[0]=1;
			for($j=0;$j<count($array);$j++)
			{
				if($array[$j]!='')
				{
					if($array1[$j]=='SDID')
					{
					array_push($arraydata,$array[$j]);
					$o=$o+1;
					// "STID" = Any(string_to_array($2::text, \',\'::text)::integer[])
					$where .= ' AND "'.$array1[$j].'" = Any(string_to_array($'.$o.'::text, \',\'::text)::bigint[])';

					// $where .= ' AND "'.$array1[$j].'" IN ($'.$o.')';
					}
					else
					{
						array_push($arraydata,$array[$j]);
					$o=$o+1;
					// "STID" = Any(string_to_array($2::text, \',\'::text)::integer[])
					$where .= ' AND "'.$array1[$j].'" = Any(string_to_array($'.$o.'::text, \',\'::text)::integer[])';

					// $where .= ' AND "'.$array1[$j].'" IN ($'.$o.')';
					}
					
				}
			}

			$row=array();

			if($wheredt!='')
			{
				// print_r($arraydata);

				$query = 'select "SDID" as "id","SDName" as "Name" from "sd'.$_SESSION['activeyears'].'" where is_deleted=$1 '.$where.'  order by "SDName" ASC';

			$resultstatelk = pg_query_params($db,$query,$arraydata);
			if(pg_numrows($resultstatelk)>0)
			{
			$row = pg_fetch_all($resultstatelk); 	
			}

			}

			$rowst = array();
			if($_POST['comefrom']=='Sub-District' )
			{

		
			if(isset($_SESSION['logindetails']['assignlist']) && $_SESSION['logindetails']['assignlist']!='')
			{

					$arr=array(1,$_SESSION['logindetails']['assignlist']);
					// $cond_dco = ' AND "STID" IN ('.$_SESSION['logindetails']['assignlist'].')';
					$queryst = 'select "STID" as "id","STName" as "Name" from "st'.$_SESSION['activeyears'].'" where is_deleted=$1 AND "STID" = Any(string_to_array($2::text, \',\'::text)::integer[]) order by "STName" ASC';

					}	
					else
					{
					$arr=array(1);
					$queryst = 'select "STID" as "id","STName" as "Name" from "st'.$_SESSION['activeyears'].'" where is_deleted=$1 order by "STName" ASC';
					}


					$resultstquery = pg_query_params($db,$queryst,$arr);
					if(pg_numrows($resultstquery)>0)
					{
					$rowst = pg_fetch_all($resultstquery); 	
					}

			}

			$where1='';
			if($_POST['clickpopup']=='Merge')
			{
				$where1 = "and (forreaddetails='Merge') OR (forreaddetails='Partially Merge')";
			}
			else if($_POST['clickpopup']=='Partiallysm')
			{
				$where1 = "and (forreaddetails='Partially Split & Merge')";
			}
			else if($_POST['clickpopup']=='Reshuffle')
			{
			$where1 = " and (forreaddetails='Reshuffle')";
			}
			else
			{
				if($_POST['tdtids']!='' && $_POST['tstids']!='')
				{
				$where1="and (forreaddetails='Split')";
				}
				else
				{
				$where1 = "and (forreaddetails='Split' OR forreaddetails='Full Merge')";
				}
				
			}


			$resultaction = pg_query($db, "select * from detailforread where comefrom='ST' ".$where1."  and is_deleted=1 order by statuslevel ASC");
			if(pg_numrows($resultaction)>0)
			{
			$rowaction = pg_fetch_all($resultaction); 
			}


}

else
{





			$row = array();

			$rowaction = array();
			
			// $array = array($_POST['STID'],$_POST['STdidsmrg'],$_POST['DTID'],$_POST['DTIDS'],$_POST['SDID'],$_POST['subdistselected'],$_POST['clickpopup']);

			// $arr=array('STID','DTID','SDID');
			$array[0]=1;
			$arraynew[0]=1;
			$where = "";
			$flag=0;
			if(isset($_POST['SDID']) && $_POST['SDID']!='' && $_POST['subdistselected']=='')
			{
				array_push($array,$_POST['SDID']);

				 $query = 'select "SDID" as "id","SDName" as "Name" from "sd'.$_SESSION['activeyears'].'" where is_deleted=$1 and "SDID"=$2  order by "SDName" ASC';
			$flag=1;	 
			// $where = ' and "SDID"='.$_POST['SDID'].'';
			array_push($arraynew,$_POST['SDID']);
			 $query1 = 'select "SDID" as "id","SDName" as "Name" from "sd'.$_SESSION['activeyears'].'" where is_deleted=$1 and "SDID"=$2  order by "SDName" ASC';
			
		// 	$where1 = ' and "SDID"='.$_POST['SDID'].'';
			}
			else if(isset($_POST['SDID']) && $_POST['SDID']=='' && $_POST['subdistselected']=='')
			{
				$flag=2;
			 	 $query = 'select "SDID" as "id","SDName" as "Name" from "sd'.$_SESSION['activeyears'].'" where is_deleted=$1 order by "SDName" ASC';
				 $query1 = 'select "SDID" as "id","SDName" as "Name" from "sd'.$_SESSION['activeyears'].'" where is_deleted=$1 order by "SDName" ASC';
			}
			else
			{   $flag=2;
				 $query = 'select "SDID" as "id","SDName" as "Name" from "sd'.$_SESSION['activeyears'].'" where is_deleted=$1 order by "SDName" ASC'; 
				 array_push($arraynew,$_POST['subdistselected']);
				 $query1 = 'select "SDID" as "id","SDName" as "Name" from "sd'.$_SESSION['activeyears'].'" where is_deleted=$1 and "SDID"=$2 order by "SDName" ASC';
				// $where1 = ' and "SDID"='.$_POST['subdistselected'].'';
			}





			$stflag=0;
			if(isset($_POST['STID']) && $_POST['STdidsmrg']!='' && $_POST['STID']!=$_POST['STdidsmrg'] && $_POST['clickpopup']=='submerge')
			{
				if($flag==1)
				{
				 array_push($array,$_POST['STdidsmrg']);

				 $query = 'select "SDID" as "id","SDName" as "Name" from "sd'.$_SESSION['activeyears'].'" where is_deleted=$1 and "SDID"=$2 and "STID"=$3 order by "SDName" ASC';
				 array_push($arraynew,$_POST['STdidsmrg']);
				  $query1 = 'select "SDID" as "id","SDName" as "Name" from "sd'.$_SESSION['activeyears'].'" where is_deleted=$1 and "SDID"=$2 and "STID"=$3 order by "SDName" ASC';
			

				}
				else
				{
				   array_push($array,$_POST['STdidsmrg']);

				  $query = 'select "SDID" as "id","SDName" as "Name" from "sd'.$_SESSION['activeyears'].'" where is_deleted=$1 and "STID"=$2 order by "SDName" ASC';

				  array_push($arraynew,$_POST['STdidsmrg']);
				  $query1 = 'select "SDID" as "id","SDName" as "Name" from "sd'.$_SESSION['activeyears'].'" where is_deleted=$1 and "STID"=$2 order by "SDName" ASC';

				}
			$stflag=1;
		//	$wherenewst = ' and "STID"='.$_POST['STdidsmrg'].'';
			}
			else
			{
				if($flag==1)
				{
				 array_push($array,$_POST['STID']);

				 $query = 'select "SDID" as "id","SDName" as "Name" from "sd'.$_SESSION['activeyears'].'" where is_deleted=$1 and "SDID"=$2 and "STID"=$3 order by "SDName" ASC';

				   array_push($arraynew,$_POST['STID']);
				  $query1 = 'select "SDID" as "id","SDName" as "Name" from "sd'.$_SESSION['activeyears'].'" where is_deleted=$1 and "SDID"=$2 and "STID"=$3 order by "SDName" ASC';

				}
				else
				{
					 array_push($array,$_POST['STID']);

				 $query = 'select "SDID" as "id","SDName" as "Name" from "sd'.$_SESSION['activeyears'].'" where is_deleted=$1 and "STID"=$2 order by "SDName" ASC';

				  array_push($arraynew,$_POST['STID']);
				  $query1 = 'select "SDID" as "id","SDName" as "Name" from "sd'.$_SESSION['activeyears'].'" where is_deleted=$1 and "STID"=$2 order by "SDName" ASC';

				}

				$stflag=2;
		//	$wherenewst = ' and "STID"='.$_POST['STID'].'';
			}


			$dtflag=0;
			if(isset($_POST['DTID']) && $_POST['DTIDS']!='' && $_POST['DTID']!=$_POST['DTIDS'] && $_POST['clickpopup']=='submerge')
			{
				if($flag==1 && $stflag==1)
				{
				 array_push($array,$_POST['DTIDS']);

				 $query = 'select "SDID" as "id","SDName" as "Name" from "sd'.$_SESSION['activeyears'].'" where is_deleted=$1 and "SDID"=$2 and "STID"=$3 and "DTID"=$4  order by "SDName" ASC';

				 array_push($arraynew,$_POST['DTIDS']);
				  $query1 = 'select "SDID" as "id","SDName" as "Name" from "sd'.$_SESSION['activeyears'].'" where is_deleted=$1 and "SDID"=$2 and "STID"=$3 and "DTID"=$4 order by "SDName" ASC';


				}
				else if($flag==1 && $stflag==2)
				{
				 array_push($array,$_POST['DTIDS']);

				 $query = 'select "SDID" as "id","SDName" as "Name" from "sd'.$_SESSION['activeyears'].'" where is_deleted=$1 and "SDID"=$2 and "STID"=$3 and "DTID"=$4 order by "SDName" ASC';



				  array_push($arraynew,$_POST['DTIDS']);
				  $query1 = 'select "SDID" as "id","SDName" as "Name" from "sd'.$_SESSION['activeyears'].'" where is_deleted=$1 and "SDID"=$2 and "STID"=$3 and "DTID"=$4 order by "SDName" ASC';

				}
				else if($flag==2 && $stflag==1)
				{
				 array_push($array,$_POST['DTIDS']);

				 $query = 'select "SDID" as "id","SDName" as "Name" from "sd'.$_SESSION['activeyears'].'" where is_deleted=$1 and "STID"=$2 and "DTID"=$3 order by "SDName" ASC';

				 if($_POST['subdistselected']=='')
				 {
				 	 array_push($arraynew,$_POST['DTIDS']);
				  $query1 = 'select "SDID" as "id","SDName" as "Name" from "sd'.$_SESSION['activeyears'].'" where is_deleted=$1 and "STID"=$2 and "DTID"=$3 order by "SDName" ASC';
				 }
				 else
				 {
				 	 array_push($arraynew,$_POST['DTIDS']);
				  $query1 = 'select "SDID" as "id","SDName" as "Name" from "sd'.$_SESSION['activeyears'].'" where is_deleted=$1 and "SDID"=$2 and "STID"=$3 and "DTID"=$4 order by "SDName" ASC';
				 }
				 


				}
				else if($flag==2 && $stflag==2)
				{
				 array_push($array,$_POST['DTIDS']);
				 $query = 'select "SDID" as "id","SDName" as "Name" from "sd'.$_SESSION['activeyears'].'" where is_deleted=$1 and "STID"=$2 and "DTID"=$3 order by "SDName" ASC';

					if($_POST['subdistselected']=='')
					{
					array_push($arraynew,$_POST['DTIDS']);
					$query1 = 'select "SDID" as "id","SDName" as "Name" from "sd'.$_SESSION['activeyears'].'" where is_deleted=$1 and "STID"=$2 and "DTID"=$3 order by "SDName" ASC';
					}
					else
					{
					array_push($arraynew,$_POST['DTIDS']);
					$query1 = 'select "SDID" as "id","SDName" as "Name" from "sd'.$_SESSION['activeyears'].'" where is_deleted=$1 and "SDID"=$2 and "STID"=$3 and "DTID"=$4 order by "SDName" ASC';
					}



				}
				

				$dtflag=1;
			//$wherenew = ' and "DTID"='.$_POST['DTIDS'].'';
// 			$wherenew1 = ' and "DTID"='.$_POST['DTID'].'';
			}
			else
			{

				if($flag==1 && $stflag==1)
				{
				 array_push($array,$_POST['DTID']);

				 $query = 'select "SDID" as "id","SDName" as "Name" from "sd'.$_SESSION['activeyears'].'" where is_deleted=$1 and "SDID"=$2 and "STID"=$3 and "DTID"=$4  order by "SDName" ASC';

				 	array_push($arraynew,$_POST['DTID']);
					$query1 = 'select "SDID" as "id","SDName" as "Name" from "sd'.$_SESSION['activeyears'].'" where is_deleted=$1 and "SDID"=$2 and "STID"=$3 and "DTID"=$4 order by "SDName" ASC';

				}
				else if($flag==1 && $stflag==2)
				{
				 array_push($array,$_POST['DTID']);

				 $query = 'select "SDID" as "id","SDName" as "Name" from "sd'.$_SESSION['activeyears'].'" where is_deleted=$1 and "SDID"=$2 and "STID"=$3 and "DTID"=$4 order by "SDName" ASC';


				 	array_push($arraynew,$_POST['DTID']);
					$query1 = 'select "SDID" as "id","SDName" as "Name" from "sd'.$_SESSION['activeyears'].'" where is_deleted=$1 and "SDID"=$2 and "STID"=$3 and "DTID"=$4 order by "SDName" ASC';

				}
				else if($flag==2 && $stflag==1)
				{
				 array_push($array,$_POST['DTID']);

				 $query = 'select "SDID" as "id","SDName" as "Name" from "sd'.$_SESSION['activeyears'].'" where is_deleted=$1 and "STID"=$2 and "DTID"=$3 order by "SDName" ASC';

				 if($_POST['subdistselected']=='')
					{
					array_push($arraynew,$_POST['DTID']);
					$query1 = 'select "SDID" as "id","SDName" as "Name" from "sd'.$_SESSION['activeyears'].'" where is_deleted=$1 and "STID"=$2 and "DTID"=$3 order by "SDName" ASC';
					}
					else
					{
					array_push($arraynew,$_POST['DTID']);
					$query1 = 'select "SDID" as "id","SDName" as "Name" from "sd'.$_SESSION['activeyears'].'" where is_deleted=$1 and "SDID"=$2 and "STID"=$3 and "DTID"=$4 order by "SDName" ASC';
					}


				}
				else if($flag==2 && $stflag==2)
				{
				 array_push($array,$_POST['DTID']);

				 $query = 'select "SDID" as "id","SDName" as "Name" from "sd'.$_SESSION['activeyears'].'" where is_deleted=$1 and "STID"=$2 and "DTID"=$3 order by "SDName" ASC';

				  if($_POST['subdistselected']=='')
					{
					array_push($arraynew,$_POST['DTID']);
					$query1 = 'select "SDID" as "id","SDName" as "Name" from "sd'.$_SESSION['activeyears'].'" where is_deleted=$1 and "STID"=$2 and "DTID"=$3 order by "SDName" ASC';
					}
					else
					{
					array_push($arraynew,$_POST['DTID']);
					$query1 = 'select "SDID" as "id","SDName" as "Name" from "sd'.$_SESSION['activeyears'].'" where is_deleted=$1 and "SDID"=$2 and "STID"=$3 and "DTID"=$4 order by "SDName" ASC';
					}
					


				}
				

				$dtflag=0;
			//$wherenew = ' and "DTID"='.$_POST['DTID'].'';
			// $wherenew1 = ' and "DTID"='.$_POST['DTID'].'';
			}



			// print_r($array);

			// echo $query;
			// exit;
			

			 // $query = 'select "SDID" as "id","SDName" as "Name" from "sd'.$_SESSION['activeyears'].'" where is_deleted=1 '.$wherenewst.' '.$wherenew.' '.$where.'  order by "SDID" ASC';

			$resultstatelk = pg_query_params($db, $query,$array);
			if(pg_numrows($resultstatelk)>0)
			{
			$row = pg_fetch_all($resultstatelk); 	
				$task1 .='<div class="col-md-6"> 
															
															<select multiple="multiple" required id="selected_comesub" class="multi-select" name="selected_comesub[]">';
															foreach($row as $key => $element) {
															$task1 .='<option value="'.$element['id'].'">'.$element['Name'].'
															</option>';
															}

															$task1 .='</select></div>';
															if($_POST['comefrom']=='Sub-District')
															{
																$task1 .='<div class="mt-2 ml-3"><input type="checkbox" onclick="handleClick(this,0,\'submerge\');" name="haveapartially0[]" class="haveapartially" id="0" > <label for="checkbox2">Any '.$_POST['comefrom'].' Partially Split & Sub Merge </label></div><div id="selectedlist0" class="col-md-6 mb-2"></div>';	
															}
															
			}


			 // $query1 = 'select "SDID" as "id","SDName" as "Name" from "sd'.$_SESSION['activeyears'].'" where is_deleted=1 '.$wherenewst.' '.$wherenew1.' '.$where1.'  order by "SDID" ASC';
			
			$resultstatelk1 = pg_query_params($db, $query1,$arraynew);
			if(pg_numrows($resultstatelk1)>0)
			{
			$row1 = pg_fetch_all($resultstatelk1); 	
			}

			$resultaction = pg_query($db, "select * from detailforread where comefrom='ST' and (forreaddetails='Merge' )  and is_deleted=1 order by statuslevel ASC");
			if(pg_numrows($resultaction)>0)
			{
			$rowaction = pg_fetch_all($resultaction); 
			}
}


	




	echo json_encode($row)."|".json_encode($rowaction)."|".$_POST['comefrom']."|".$_POST['clickpopup']."|".json_encode($row1)."|".$task1."|"."|".json_encode($rowst).'||'.$_SESSION['logindetails']['assignlist'];;
  exit();

}



// else if($_POST['formname']=='getdataofpopupsubward')
// {


// 	$row = array();

// $rowaction = array();


// 			 $query = 'select "WDID" as "id","WDName" as "Name" from "wd'.$_SESSION['activeyears'].'" where "STID"='.$_POST['STID'].' and "DTID"='.$_POST['DTID'].' and "SDID"='.$_POST['SDID'].' and "VTID"='.$_POST['VTID'].'  order by "WDID" ASC';

// 		 	$resultstatelk = pg_query($db, $query);
// 			if(pg_numrows($resultstatelk)>0)
// 			{
// 			$row = pg_fetch_all($resultstatelk); 	
// 			}

// 			$resultaction = pg_query($db, "select * from detailforread where comefrom='ST' and (forreaddetails='Split' OR forreaddetails='Full Merge')  and is_deleted=1 order by statuslevel ASC");
// 		if(pg_numrows($resultaction)>0)
// 		{
// 		$rowaction = pg_fetch_all($resultaction); 
// 		}






// 	echo json_encode($row)."|".json_encode($rowaction)."|".$_POST['comefrom'];
//   exit();

// }


else if($_POST['formname']=='getdataofpopupsubvillage')
{

	$row = array();

$rowaction = array();
$task1='';
		if($_POST['clickpopup']=='submerge')
		{
			$arra = array($_POST['STID'],$_POST['DTID'],$_POST['SDID'],1);
			 $query = 'select "VTID" as "id",CONCAT_WS(\' - \',"VTName","MDDS_VT") as "Name" from "vt'.$_SESSION['activeyears'].'" where "STID"=$1 and "DTID"=$2 and "SDID"=$3 and is_deleted=$4  order by "VTName" ASC';

		 	$resultstatelk = pg_query_params($db, $query,$arra);
			if(pg_numrows($resultstatelk)>0)
			{
					$row = pg_fetch_all($resultstatelk); 	

						$task1 .='<div class="col-md-6"> 

						<select multiple="multiple" id="selected_comesub" required class="multi-select" name="selected_comesub[]">';
						foreach($row as $key => $element) {
						$task1 .='<option value="'.$element['id'].'">'.$element['Name'].'
						</option>';
						}

						$task1 .='</select></div>';

																$task1 .='<div class="mt-2 ml-3"><input type="checkbox" onclick="handleClick(this,0,\'submerge\');" name="haveapartially0[]" class="haveapartially" id="0" > <label for="checkbox2">Any Split & Sub Merge </label></div><div id="selectedlist0" class="col-md-6 mb-2"></div>';	
														
			}

			
		}
		else
		{

			$rowst = array();
			if($_POST['comefrom']=='Village / Town' )
			{
			$arra = array(1);
			$queryst = 'select "STID" as "id","STName" as "Name" from "st'.$_SESSION['activeyears'].'" where is_deleted=$1 order by "STName" ASC';
			$resultstquery = pg_query_params($db, $queryst,$arra);
			if(pg_numrows($resultstquery)>0)
			{
			$rowst = pg_fetch_all($resultstquery); 	
			}

			}
				$row = array();
				if($_POST['STID']!='' && $_POST['DTID']!='' && $_POST['SDID']!='')
				{
					$aaarrr= array($_POST['STID'],$_POST['DTID'],$_POST['SDID'],1);
						 $query = 'select "VTID" as "id",CONCAT_WS(\' - \',"VTName","MDDS_VT") as "Name" from "vt'.$_SESSION['activeyears'].'" where "STID" = Any(string_to_array($1::text, \',\'::text)::bigint[]) and "DTID" = Any(string_to_array($2::text, \',\'::text)::bigint[]) and "STID" = Any(string_to_array($3::text, \',\'::text)::bigint[]) and is_deleted=$4  order by "VTName" ASC';

		 	$resultstatelk = pg_query_params($db, $query,$aaarrr);
			if(pg_numrows($resultstatelk)>0)
			{
			$row = pg_fetch_all($resultstatelk); 	
			}
				}

				

			$where='';
			if($_POST['clickpopup']=='Merge')
			{
				$where = "and (forreaddetails='Merge') OR (forreaddetails='Partially Merge')";
			}
			else
			{
				$where = "and (forreaddetails='Split' OR forreaddetails='Full Merge')";
			}

			$resultaction = pg_query($db, "select * from detailforread where comefrom='ST' ".$where."  and is_deleted=1 order by statuslevel ASC");
		if(pg_numrows($resultaction)>0)
		{
		$rowaction = pg_fetch_all($resultaction); 
		}

		}






	echo json_encode($row)."|".json_encode($rowaction)."|".$_POST['comefrom']."|".$task1."||||".json_encode($rowst);
  exit();

}

else if($_POST['formname']=='getdataofpopupsubvillagenew')
{

	$row = array();

	$rowaction = array();

			$flag=0;
			$flag1=0;

			$cond = "";
			if($_POST['fvtids']!='')
			{
				$flag=1;
				//$cond = ' AND "VTID" IN ('.$_POST['fvtids'].')';	
			}
			
			$jigs="";
			if($_POST['jigs']!='')
			{
				$flag1=1;
			//	$jigs = ' AND "VTID" NOT IN ('.$_POST['jigs'].')';	
			}


				if($flag==1 && $flag1==1)
				{
					$array = array($_POST['fstids'],$_POST['fdtids'],$_POST['datavalue'],$_POST['fvtids'],$_POST['jigs'],1);
					$query = 'select "VTID" as "id",CONCAT_WS(\' - \',"VTName","MDDS_VT") as "Name" from "vt'.$_SESSION['activeyears'].'" where "STID" = Any(string_to_array($1::text, \',\'::text)::bigint[]) and "DTID" = Any(string_to_array($2::text, \',\'::text)::bigint[]) and "SDID" = Any(string_to_array($3::text, \',\'::text)::bigint[]) AND "VTID" = Any(string_to_array($4::text, \',\'::text)::NUMERIC[]) AND NOT "VTID" != Any(string_to_array($5::text, \',\'::text)::NUMERIC[]) and is_deleted=$6 order by "VTName" ASC';

					// concat("VTName",\' - \',"MDDS_VT")
				}
				else if($flag==0 && $flag1==1)
				{
					$array = array($_POST['fstids'],$_POST['fdtids'],$_POST['datavalue'],$_POST['jigs'],1);
					 $query = 'select "VTID" as "id",CONCAT_WS(\' - \',"VTName","MDDS_VT") as "Name" from "vt'.$_SESSION['activeyears'].'" where "STID" = Any(string_to_array($1::text, \',\'::text)::bigint[]) and "DTID" = Any(string_to_array($2::text, \',\'::text)::bigint[]) and "SDID" = Any(string_to_array($3::text, \',\'::text)::bigint[]) AND NOT "VTID" = Any(string_to_array($4::text, \',\'::text)::NUMERIC[]) and is_deleted=$5 order by "VTName" ASC';	
				}
				else if($flag==1 && $flag1==0)
				{
					$array = array($_POST['fstids'],$_POST['fdtids'],$_POST['datavalue'],$_POST['fvtids'],1);
					$query = 'select "VTID" as "id",CONCAT_WS(\' - \',"VTName","MDDS_VT") as "Name" from "vt'.$_SESSION['activeyears'].'" where "STID" = Any(string_to_array($1::text, \',\'::text)::bigint[]) and "DTID" = Any(string_to_array($2::text, \',\'::text)::bigint[]) and "SDID" = Any(string_to_array($3::text, \',\'::text)::bigint[]) AND "VTID" = Any(string_to_array($4::text, \',\'::text)::NUMERIC[]) and is_deleted=$5 order by "VTName" ASC';
				}
				else
				{

					$array = array($_POST['fstids'],$_POST['fdtids'],$_POST['datavalue'],1);
					$query = 'select "VTID" as "id",CONCAT_WS(\' - \',"VTName","MDDS_VT") as "Name" from "vt'.$_SESSION['activeyears'].'" where "STID" = Any(string_to_array($1::text, \',\'::text)::bigint[]) and "DTID" = Any(string_to_array($2::text, \',\'::text)::bigint[]) and "SDID" = Any(string_to_array($3::text, \',\'::text)::bigint[]) and is_deleted=$4 order by "VTName" ASC'; // code changed by bheema for villager level NAmes ASC order
				
				}


				  

		 	$resultstatelk = pg_query_params($db, $query,$array); //total count
			 $datacount = pg_num_rows($resultstatelk); //total count
			$task='';
			if(pg_numrows($resultstatelk)>0)
			{
			$row = pg_fetch_all($resultstatelk); 
			

			if($_POST['i']>1)
			{
$task .='<select multiple="multiple" id="id2021'.$_POST['i'].'" required class="multi-select namefrom" name="namefrom'.$_POST['i'].'[]">';
			}	
			else
			{
			$task .='<select multiple="multiple" id="selected_come" required class="multi-select namefrom" name="namefrom[]">';	
			}
			
			foreach($row as $key => $element) {
			$task .='<option value="'.$element['id'].'">'.$element['Name'].'
			</option>';
			}

			$task .='</select>';
if($_POST['i']>1)
			{
			$task .='<div class="mt-2">Total Selected Village(s) / Town(s) : <span id="totaldefultselected_'.$_POST['i'].'">0</span> - out of :<span> '.$datacount.'</div>'; //total count
		}
		else
		{
			$task .='<div class="mt-2">Total Selected Village(s) / Town(s) : <span id="totaldefultselected_1">0</span> - out of :<span> '.$datacount.'</span></div>'; // total count
		}
			

			}

			

			



			$where='';
			
				$where='';
			if($_POST['clickpopup']=='Merge')
			{
				$where = "and (forreaddetails='Merge') OR (forreaddetails='Partially Merge')";
			}
			else if($_POST['clickpopup']=='Partiallysm')
			{
				$where =  "and (forreaddetails='Partially Split & Merge')";
			}
			else if($_POST['clickpopup']=='Reshuffle')
			{
			$where = " and (forreaddetails='Reshuffle')";
			}
			else
			{
				$where = "and (forreaddetails='Split' OR forreaddetails='Full Merge')";
			}
		

			$resultaction = pg_query($db, "select * from detailforread where comefrom='ST' ".$where."  and is_deleted=1 order by statuslevel ASC");
		if(pg_numrows($resultaction)>0)
		{
		$rowaction = pg_fetch_all($resultaction); 
		}


	echo json_encode($row)."|".json_encode($rowaction)."|".$_POST['comefrom']."|".$task;
  exit();

}

else if($_POST['formname']=='getdataofpopupsubvillagenew_to_more')
{



	$row = array();

$rowaction = array();
$task1='';

			$cond = "";
			
			if($_POST['fvtids']!='' && $_POST['clickpopup']!='Partiallysm')
			{
			// $cond = ' AND "VTID" IN ('.$_POST['fvtids'].')';	
				$arra=array($_POST['fstids'],$_POST['fdtids'],$_POST['fsdids'],1,$_POST['fvtids']);
				$query = 'select "VTID" as "id",CONCAT_WS(\' - \',"VTName","MDDS_VT") as "Name" from "vt'.$_SESSION['activeyears'].'" where "STID" = Any(string_to_array($1::text, \',\'::text)::bigint[]) and "DTID" = Any(string_to_array($2::text, \',\'::text)::bigint[]) and "SDID" = Any(string_to_array($3::text, \',\'::text)::bigint[])  and  is_deleted=$4 AND "VTID" = Any(string_to_array($5::text, \',\'::text)::NUMERIC[])  order by "VTName" ASC';
			}
			else
			{
				$arra=array($_POST['fstids'],$_POST['fdtids'],$_POST['fsdids'],1);
				$query = 'select "VTID" as "id",CONCAT_WS(\' - \',"VTName","MDDS_VT") as "Name" from "vt'.$_SESSION['activeyears'].'" where "STID" = Any(string_to_array($1::text, \',\'::text)::bigint[]) and "DTID" = Any(string_to_array($2::text, \',\'::text)::bigint[]) and "SDID" = Any(string_to_array($3::text, \',\'::text)::bigint[])  and  is_deleted=$4 order by "VTName" ASC';
					
			}

			

		
				 

		 	$resultstatelk = pg_query_params($db,$query,$arra);
			if(pg_numrows($resultstatelk)>0)
			{
			$row = pg_fetch_all($resultstatelk); 	
			}

			


	echo json_encode($row)."|".$_POST['clickpopup']."|".$_POST['comefrom'];
  exit();

}

else if($_POST['formname']=='getdataofpopupsubvillagenew_to')
{



	$row = array();

$rowaction = array();
$task1='';

			$cond = "";
			
			if($_POST['fvtids']!='' && $_POST['clickpopup']!='Partiallysm')
			{
				// $cond = ' AND "VTID" IN ('.$_POST['fvtids'].')';	
			
			 $arra=array($_POST['fstids'],$_POST['fdtids'],$_POST['fsdids'],1,$_POST['fvtids']);

			 $query = 'select "VTID" as "id",CONCAT_WS(\' - \',"VTName","MDDS_VT") as "Name" from "vt'.$_SESSION['activeyears'].'" where "STID" = Any(string_to_array($1::text, \',\'::text)::bigint[]) and "DTID" = Any(string_to_array($2::text, \',\'::text)::bigint[]) and "SDID" = Any(string_to_array($3::text, \',\'::text)::bigint[])  and  is_deleted=$4 AND "VTID" = Any(string_to_array($5::text, \',\'::text)::NUMERIC[])  order by "VTName" ASC';

			}
			else
			{
				$arra=array($_POST['fstids'],$_POST['fdtids'],$_POST['fsdids'],1);

			    $query = 'select "VTID" as "id",CONCAT_WS(\' - \',"VTName","MDDS_VT") as "Name" from "vt'.$_SESSION['activeyears'].'" where "STID" = Any(string_to_array($1::text, \',\'::text)::bigint[]) and "DTID" = Any(string_to_array($2::text, \',\'::text)::bigint[]) and "SDID" = Any(string_to_array($3::text, \',\'::text)::bigint[])  and  is_deleted=$4 order by "VTName" ASC';

			}

		 	$resultstatelk = pg_query_params($db,$query,$arra);
			if(pg_numrows($resultstatelk)>0)
			{
			$row = pg_fetch_all($resultstatelk); 	
			}

			


	echo json_encode($row)."|".$_POST['clickpopup']."|".$_POST['comefrom'];
  exit();

}

else if($_POST['formname']=='getdataofpopupsubmerge')
{

								$row = array();
								$rowaction = array();
								if($_POST['comefrom']=='District')
								{
														$task1='';
															 $arra=array(1);
														 $query = 'select "STID" as "id","STName" as "Name" from "st'.$_SESSION['activeyears'].'" where is_deleted=$1 order by "STName" ASC';
															 
																$resultstatelk = pg_query_params($db,$query,$arra);
															if(pg_numrows($resultstatelk)>0)
															{
															$row = pg_fetch_all($resultstatelk); 	

															$task1 .='<div class="col-md-6"> 
															
															<select multiple="multiple" id="selected_comesub" class="multi-select" name="selected_comesub[]">';
															foreach($row as $key => $element) {
															$task1 .='<option value="'.$element['id'].'">'.$element['Name'].'
															</option>';
															}

															$task1 .='</select></div>';



															}

														

								}
								else if($_POST['comefrom']=='Sub-District')
								{
									
										if(isset($_POST['createfrom']) && $_POST['createfrom']=='Merge')
												{

														
 														$where123 ='';
															
 														$array=array("is_deleted"=>1);

 														$array1=array("is_deleted"=>1);

 															//$array[0]=1;
															if($_POST['selectstidupdated']!='' && $_POST['dtselected']!='')
															{
																array_push($array,array("DTID"=>$_POST['selectstidupdated']));

																$stids = ' AND "DTID"='.$_POST['selectstidupdated'].'';
																array_push($array1,array("DTID"=>$_POST['selectstidupdated']));
																$where123 = ' AND "DTID"='.$_POST['selectstidupdated'].'';

															}

															else if($_POST['dtselected']=='' && $_POST['selectstidupdated']=='')  
															{
																array_push($array,array("STID"=>$_POST['selectstid']));

																$stids = ' AND "STID"='.$_POST['selectstid'].'';
																$where123 = '';
															}
															else
															{
																array_push($array,array("DTID"=>$_POST['dtselected']));

																$stids = ' AND "DTID"='.$_POST['dtselected'].'';
																array_push($array1,array("DTID"=>$_POST['dtselected']));
																$where123 = ' AND "DTID"='.$_POST['dtselected'].'';
															}
														
															$row1=array();




															
															if($where123!='')
															{

															  $query1 = 'select "SDID" as "id","SDName" as "Name" from "sd'.$_SESSION['activeyears'].'" where is_deleted=1 '.$where123.'  order by "DTName" ASC';
													
									
																$resultstatelk1 = pg_query($db, $query1);
															if(pg_numrows($resultstatelk1)>0)
															{
															$row1 = pg_fetch_all($resultstatelk1); 	
															}



															}
															 $query = 'select "DTID" as "id","DTName" as "Name" from "dt'.$_SESSION['activeyears'].'" where is_deleted=1 '.$stids.' order by "DTName" ASC';
																
																$resultstatelk = pg_query($db, $query);
															if(pg_numrows($resultstatelk)>0)
															{
															$row = pg_fetch_all($resultstatelk); 	
															}



															
														



															$resultaction = pg_query($db, "select * from detailforread where comefrom='ST' and  forreaddetails='Merge' and is_deleted=1 order by statuslevel ASC");
															if(pg_numrows($resultaction)>0)
															{
															$rowaction = pg_fetch_all($resultaction); 	
															}

												}

												else
												{
															$task1='';
														$arra=array(1);
														 $query = 'select "STID" as "id","STName" as "Name" from "st'.$_SESSION['activeyears'].'" where is_deleted=$1 order by "STName" ASC';
															
																$resultstatelk = pg_query_params($db, $query,$arra);
															if(pg_numrows($resultstatelk)>0)
															{
															$row = pg_fetch_all($resultstatelk); 	

															$task1 .='<div class="col-md-6"> 
															
															<select multiple="multiple" id="selected_comesub" class="multi-select" name="selected_comesub[]">';
															foreach($row as $key => $element) {
															$task1 .='<option value="'.$element['id'].'">'.$element['Name'].'
															</option>';
															}

															$task1 .='</select></div>';



															}
													}

											 
									

								}
								else if($_POST['comefrom']=='Village / Town')
								{

												$task1='';

															
																$cond_dco='';
																if(isset($_SESSION['logindetails']['assignlist']) && $_SESSION['logindetails']['assignlist']!='')
																{
																	// $cond_dco = ' AND "STID" IN ('.$_SESSION['logindetails']['assignlist'].')';
																	$arra=array(1,$_SESSION['logindetails']['assignlist']);
																	$query = 'select "STID" as "id","STName" as "Name" from "st'.$_SESSION['activeyears'].'" where is_deleted=$1 AND "STID" = Any(string_to_array($2::text, \',\'::text)::integer[]) order by "STName" ASC';
															

																}	
																else
																{
																	$arra=array(1);
																	$query = 'select "STID" as "id","STName" as "Name" from "st'.$_SESSION['activeyears'].'" where is_deleted=$1 order by "STName" ASC';
															
																}


														 
																$resultstatelk = pg_query_params($db, $query,$arra);
															if(pg_numrows($resultstatelk)>0)
															{
															$row = pg_fetch_all($resultstatelk); 	

															$task1 .='<div class="col-md-6"> 
															
															<select multiple="multiple" id="selected_comesub" class="multi-select" name="selected_comesub[]">';
															foreach($row as $key => $element) {
															$task1 .='<option value="'.$element['id'].'">'.$element['Name'].'
															</option>';
															}

															$task1 .='</select></div>';



															}


								}
								else if($_POST['comefrom']=='Ward')
								{
											$query = 'select "DTID" as "id","DTName" as "Name" from "dt'.$_SESSION['activeyears'].'" where "STID"='.$_POST['selectstid'].' AND is_deleted=1  order by "DTName" ASC';
											 	$resultstatelk = pg_query($db, $query);
												if(pg_numrows($resultstatelk)>0)
												{
												$row = pg_fetch_all($resultstatelk); 	
												}
								}
								else
								{
									$task1='';
										$arra=array(1);
													$query = 'select "STID" as "id","STName" as "Name" from "st'.$_SESSION['activeyears'].'" where is_deleted=$1  order by "STName" ASC';
												 	$resultstatelk = pg_query_params($db, $query,$arra);
													if(pg_numrows($resultstatelk)>0)
													{
													$row = pg_fetch_all($resultstatelk); 	

													$task1 .='<div class="col-md-6"> 
															
															<select multiple="multiple" id="selected_comesub" class="multi-select" name="selected_comesub[]">';
															foreach($row as $key => $element) {
															$task1 .='<option value="'.$element['id'].'">'.$element['Name'].'
															</option>';
															}

															$task1 .='</select></div>';

															

													}
													
													$whereaction = '';
												if(isset($_POST['createfrom']) && $_POST['createfrom']=='Merge')
												{
														$whereaction = " and (forreaddetails='Merge' OR forreaddetails='Partially Merge')";
												}
												else
												{
														$whereaction = " and (forreaddetails='Split')";
												}

												$resultaction = pg_query($db, "select * from detailforread where comefrom='ST' ".$whereaction."  and is_deleted=1 order by statuslevel ASC");
												if(pg_numrows($resultaction)>0)
												{
												$rowaction = pg_fetch_all($resultaction); 	
												}



							

								}
echo json_encode($row)."|".json_encode($rowaction)."|".$_POST['comefrom']."|".urldecode($_POST['dtstname'])."|".json_encode($row1)."|".$_POST['createfrom']."|".$_POST['sdidsselected']."|".$task1;
  exit();
// echo json_encode($row)."|".json_encode($rowaction)."|".$_POST['comefrom'];
//   exit();
}



else if($_POST['formname']=='getdataofpopup1')
{

		$row = array();
		$st ='';

		$flag=0;
		if($_POST['selectstid']!='')
		{
				if($_POST['selectstid']==$_POST['fstids'] && $_POST['fstids']!='')
				{
					$flag=1;

				$st =  " AND \"STID\"=".$_POST['fstids']."";
				}
				else
				{
					$flag=2;

				$st = " AND \"STID\"=".$_POST['selectstid']."";
				}

		}
		else
		{
			$st = "";
		}


		$flag1=0;

		$dt='';
		if($_POST['fdtids']!='')
		{
			$flag1=1;
			$dt = " AND \"DTID\"=".$_POST['fdtids']."";
		}
		
		$row=array();
		if($flag==1 && $flag1==1)
		{
			$arra=array(1,$_POST['fstids'],$_POST['fdtids']);
					$query = 'select "DTID" as "id","DTName" as "Name" from "dt'.$_SESSION['activeyears'].'" where  "is_deleted"=$1 AND "STID"=$2 AND "DTID"=$3 order by "DTName" ASC';
		}
		else if($flag==1 && $flag1==0)
		{
			$arra=array(1,$_POST['fstids']);
					$query = 'select "DTID" as "id","DTName" as "Name" from "dt'.$_SESSION['activeyears'].'" where  "is_deleted"=$1 AND "STID"=$2 order by "DTName" ASC';
		}
		else if($flag==2 && $flag1==0)
		{
			$arra=array(1,$_POST['selectstid']);
					$query = 'select "DTID" as "id","DTName" as "Name" from "dt'.$_SESSION['activeyears'].'" where  "is_deleted"=$1 AND "STID"=$2 order by "DTName" ASC';
		}
		else if($flag==2 && $flag1==1)
		{
			$arra=array(1,$_POST['fstids'],$_POST['fdtids']);
					$query = 'select "DTID" as "id","DTName" as "Name" from "dt'.$_SESSION['activeyears'].'" where  "is_deleted"=$1 AND "STID"=$2 AND "DTID"=$3 order by "DTName" ASC';
		}


	
	if($st!='')
	{
		// $query = 'select "DTID" as "id","DTName" as "Name" from "dt'.$_SESSION['activeyears'].'" where  "is_deleted"=1 '.$st.'  '.$dt.' order by "DTID" ASC';
	  
		$resultstatelk = pg_query_params($db, $query,$arra);
		if(pg_numrows($resultstatelk)>0)
		{
		$row = pg_fetch_all($resultstatelk); 	
		}
	}
	  




								
								
echo json_encode($row)."|".$_POST['comefrom']."|".$_POST['clickpopup'];
  exit();

}


else if($_POST['formname']=='getdataofpopup_to')
{
	// print_r($_POST);
	// 									exit;


								$row = array();
								
							

										// print_r($_POST);
										// exit;

									// $whree = '';
									if($_POST['tdtids']!='')
									{
										$arrr=array(1,$_POST['tdtids'],$_POST['selectstid']);
										$query = 'select "DTID" as "id","DTName" as "Name" from "dt'.$_SESSION['activeyears'].'" where "STID"=$3 AND "is_deleted"=$1 AND "DTID"=$2 order by "DTName" ASC';

									//	$where = ' AND "DTID"='.$_POST['tdtids'].'';
									}
									else
									{
										$arrr=array(1,$_POST['selectstid']);
										$query = 'select "DTID" as "id","DTName" as "Name" from "dt'.$_SESSION['activeyears'].'" where "STID"=$2 AND "is_deleted"=$1 order by "DTName" ASC';

									}
														
															 
																
																$resultstatelk = pg_query_params($db, $query,$arrr);
															if(pg_numrows($resultstatelk)>0)
															{
															$row = pg_fetch_all($resultstatelk); 	
															}

															
													


								
								
echo json_encode($row)."|".$_POST['comefrom']."|".$_POST['clickpopup'];
  exit();

}

else if($_POST['formname']=='getdataofpopup_to_sd')
{
	// print_r($_POST);
	// exit;
	
	$row = array();
							

	$cond='';
	if($_POST['tsdids']!='')
	{
		$arrr=array($_POST['selectdtid'],1,$_POST['tsdids']);
	$query = 'select "SDID" as "id","SDName" as "Name" from "sd'.$_SESSION['activeyears'].'" where "DTID"=$1 AND is_deleted=$2 AND  "SDID"=$3  order by "SDName" ASC';
	}
	else
	{
$arrr=array($_POST['selectdtid'],1);
	$query = 'select "SDID" as "id","SDName" as "Name" from "sd'.$_SESSION['activeyears'].'" where "DTID"=$1 AND is_deleted=$2 order by "SDName" ASC';
		}


	

	$resultstatelk = pg_query_params($db, $query,$arrr);
	if(pg_numrows($resultstatelk)>0)
	{
	$row = pg_fetch_all($resultstatelk); 	
	}

	echo json_encode($row)."|".$_POST['comefrom']."|".$_POST['clickpopup'];
  	exit();

}




else if($_POST['formname']=='getdataofpopup_add')
{



								$row = array();
								$rowaction = array();
													$ar=array($_POST['selectstid'],1);
														
															  $query = 'select "DTID" as "id","DTName" as "Name" from "dt'.$_SESSION['activeyears'].'" where "STID"=$1 AND is_deleted=$2 order by "DTName" ASC';
																
																$resultstatelk = pg_query_params($db, $query,$ar);
															if(pg_numrows($resultstatelk)>0)
															{
															$row = pg_fetch_all($resultstatelk); 	
															}

															
													


						
								
echo json_encode($row)."|".$_POST['comefrom']."|".$_POST['clickpopup']."|".$_POST['no'];
  exit();

}


else if($_POST['formname']=='getdataofpopup')
{




								$row = array();
								$rowaction = array();
								if($_POST['comefrom']=='District')
								{
									
															$row = array();
														

															$rowst = array();
																
																$flag=0;
																if($_POST['fstids']!='')
																{
																	$flag=1;
																//	$cond = ' AND "STID" IN ('.$_POST['fstids'].')';
																}

																$flag1=0;
																if(isset($_SESSION['logindetails']['assignlist']) && $_SESSION['logindetails']['assignlist']!='')
																{
																	$flag1=1;

																//	$cond_dco = ' AND "STID" IN ('.$_SESSION['logindetails']['assignlist'].')';
																}	
																// echo "+++++".$_POST['fstids'];

																if($flag==1 && $flag1==1)
																{		


																	$array = array(1,$_POST['fstids'],$_SESSION['logindetails']['assignlist']);
 
																	

																	$queryst = 'select "STID" as "id","STName" as "Name" from "st'.$_SESSION['activeyears'].'" where is_deleted=$1 AND "STID" = Any(string_to_array($2::text, \',\'::text)::integer[]) AND "STID" = Any(string_to_array($3::text, \',\'::text)::integer[]) order by "STName" ASC';
																}
																else if($flag==1 && $flag1==0)
																{
																	$array = array(1,$_POST['fstids']);
																	$queryst = 'select "STID" as "id","STName" as "Name" from "st'.$_SESSION['activeyears'].'" where is_deleted=$1 AND "STID" = Any(string_to_array($2::text, \',\'::text)::integer[]) order by "STName" ASC';
																}
																else if($flag==0 && $flag1==1)
																{
																	$array = array(1,$_SESSION['logindetails']['assignlist']);
																	$queryst = 'select "STID" as "id","STName" as "Name" from "st'.$_SESSION['activeyears'].'" where is_deleted=$1 AND "STID" = Any(string_to_array($2::text, \',\'::text)::integer[]) order by "STName" ASC';
																}
																else if($flag==0 && $flag1==0)
																{
																	$array = array(1);
																	$queryst = 'select "STID" as "id","STName" as "Name" from "st'.$_SESSION['activeyears'].'" where is_deleted=$1 order by "STName" ASC';
																}

																

																 $resultstquery = pg_query_params($db,$queryst,$array);
																  // SSSSS
																if(pg_numrows($resultstquery)>0)
																{
																$rowst = pg_fetch_all($resultstquery);
																
																}
															
															
																$rowstt = array();
																// $cond1='';
																$flag2=0;
																if($_POST['tstids']!='')
																{
																	$flag2=1;
																	// $cond1 = ' AND "STID" IN ('.$_POST['tstids'].')';
																}

																if($flag2==1 && $flag1==1)
																{
																	$array1 = array(1,$_POST['fstids'],$_POST['tstids']);
																	
																	$querystt = 'select "STID" as "id","STName" as "Name" from "st'.$_SESSION['activeyears'].'" where is_deleted=$1 AND "STID" = Any(string_to_array($2::text, \',\'::text)::integer[]) AND "STID" = Any(string_to_array($3::text, \',\'::text)::integer[]) order by "STName" ASC';


																	
																}
																else if($flag2==1 && $flag1==0)
																{
																	$array1 = array(1,$_POST['tstids']);
																	$querystt = 'select "STID" as "id","STName" as "Name" from "st'.$_SESSION['activeyears'].'" where is_deleted=$1 AND "STID" = Any(string_to_array($2::text, \',\'::text)::integer[]) order by "STName" ASC';
																}
																else if($flag2==0 && $flag1==1)
																{
																	$array1 = array(1,$_SESSION['logindetails']['assignlist']);
																	$querystt = 'select "STID" as "id","STName" as "Name" from "st'.$_SESSION['activeyears'].'" where is_deleted=$1 AND "STID" = Any(string_to_array($2::text, \',\'::text)::integer[]) order by "STName" ASC';
																}
																else if($flag2==0 && $flag1==0)
																{
																	$array1 = array(1);
																	 $querystt = 'select "STID" as "id","STName" as "Name" from "st'.$_SESSION['activeyears'].'" where is_deleted=$1 order by "STName" ASC';
																}
																$resultstqueryt = pg_query_params($db, $querystt,$array1);
																if(pg_numrows($resultstqueryt)>0)
																{
																$rowstt = pg_fetch_all($resultstqueryt); 
																//print_r($rowstt);	
																}

															$whereaction = '';
															if(isset($_POST['clickpopup']) && $_POST['clickpopup']=='Merge')
															{
															$whereaction = " and (forreaddetails='Merge' OR forreaddetails='Partially Merge')";
															}
															else if(isset($_POST['clickpopup']) && $_POST['clickpopup']=='Partiallysm')
															{
															$whereaction = " and (forreaddetails='Partially Split & Merge')";
															}
															else if(isset($_POST['clickpopup']) && $_POST['clickpopup']=='Reshuffle')
															{
															$whereaction = " and (forreaddetails='Reshuffle')";
															}
															else
															{
															$whereaction = " and (forreaddetails='Split')";
															}


															$resultaction = pg_query($db, "select * from detailforread where comefrom='ST' ".$whereaction." and is_deleted=1 order by statuslevel ASC");
															if(pg_numrows($resultaction)>0)
															{
															$rowaction = pg_fetch_all($resultaction); 	
															}
													


								}
								else if($_POST['comefrom']=='Sub-District')
								{
									// print_r($_POST);
									// exit;
										
															


																$rowst = array();
																$flag=0;
																if($_POST['fstids']!='')
																{
																	$flag=1;
																//	$cond = ' AND "STID" IN ('.$_POST['fstids'].')';
																}

																$flag1=0;
																if(isset($_SESSION['logindetails']['assignlist']) && $_SESSION['logindetails']['assignlist']!='')
																{
																	$flag1=1;

																//	$cond_dco = ' AND "STID" IN ('.$_SESSION['logindetails']['assignlist'].')';
																}	

																if($flag==1 && $flag1==1)
																{
																	$array = array(1,$_POST['fstids'],$_SESSION['logindetails']['assignlist']);
																	$queryst = 'select "STID" as "id","STName" as "Name" from "st'.$_SESSION['activeyears'].'" where is_deleted=$1 AND "STID" = Any(string_to_array($2::text, \',\'::text)::integer[]) AND "STID" = Any(string_to_array($3::text, \',\'::text)::integer[]) order by "STName" ASC';
																}
																else if($flag==1 && $flag1==0)
																{
																	$array = array(1,$_POST['fstids']);
																	$queryst = 'select "STID" as "id","STName" as "Name" from "st'.$_SESSION['activeyears'].'" where is_deleted=$1 AND "STID" = Any(string_to_array($2::text, \',\'::text)::integer[]) order by "STName" ASC';
																}
																else if($flag==0 && $flag1==1)
																{
																	
																	$array = array(1,$_SESSION['logindetails']['assignlist']);
																	$queryst = 'select "STID" as "id","STName" as "Name" from "st'.$_SESSION['activeyears'].'" where is_deleted=$1 AND "STID" = Any(string_to_array($2::text, \',\'::text)::integer[]) order by "STName" ASC';
																}
																else if($flag==0 && $flag1==0)
																{
																	$array = array(1);
																	$queryst = 'select "STID" as "id","STName" as "Name" from "st'.$_SESSION['activeyears'].'" where is_deleted=$1 order by "STName" ASC';
																}

																

																$resultstquery = pg_query_params($db,$queryst,$array);


																if(pg_numrows($resultstquery)>0)
																{
																$rowst = pg_fetch_all($resultstquery); 	

															 //  	print_r($rowst);
																}


																// print_r($_POST);


																$rowstt = array();
																$flag2=0;
																if($_POST['tstids']!='')
																{
																	$flag2=1;
																	// $cond1 = ' AND "STID" IN ('.$_POST['tstids'].')';
																}

																if($flag2==1 && $flag1==1)
																{
																	$array1 = array(1,$_POST['fstids'],$_POST['tstids']);
																	
																	$querystt = 'select "STID" as "id","STName" as "Name" from "st'.$_SESSION['activeyears'].'" where is_deleted=$1 AND "STID" = Any(string_to_array($2::text, \',\'::text)::integer[]) AND "STID" = Any(string_to_array($3::text, \',\'::text)::integer[]) order by "STName" ASC';


																	
																}
																else if($flag2==1 && $flag1==0)
																{
																	$array1 = array(1,$_POST['tstids']);
																	$querystt = 'select "STID" as "id","STName" as "Name" from "st'.$_SESSION['activeyears'].'" where is_deleted=$1 AND "STID" = Any(string_to_array($2::text, \',\'::text)::integer[]) order by "STName" ASC';
																}
																else if($flag2==0 && $flag1==1)
																{
																	$array1 = array(1,$_SESSION['logindetails']['assignlist']);
																	$querystt = 'select "STID" as "id","STName" as "Name" from "st'.$_SESSION['activeyears'].'" where is_deleted=$1 AND "STID" = Any(string_to_array($2::text, \',\'::text)::integer[]) order by "STName" ASC';
																}
																else if($flag2==0 && $flag1==0)
																{
																	$array1 = array(1);
																	$querystt = 'select "STID" as "id","STName" as "Name" from "st'.$_SESSION['activeyears'].'" where is_deleted=$1 order by "STName" ASC';
																}
																
																$resultstqueryt = pg_query_params($db,$querystt,$array1);

																if(pg_numrows($resultstqueryt)>0)
																{
																$rowstt = pg_fetch_all($resultstqueryt); 	
																}
																//	print_r($rowstt);


																$re='';
																if($_POST['tdtids']!='' && $_POST['tstids']!='')
																{
																	$re="and (forreaddetails='Split')";
																}
																else
																{
																	$re="and (forreaddetails='Split' OR forreaddetails='Full Merge')";
																}

															$resultaction = pg_query($db, "select * from detailforread where comefrom='ST' ".$re." and is_deleted=1 order by statuslevel ASC");
															if(pg_numrows($resultaction)>0)
															{
															$rowaction = pg_fetch_all($resultaction); 	
															}
												//	exit;
											 
									

								}
								else if($_POST['comefrom']=='Village / Town')
								{ 


										
														
														

																$rowst = array();
																$flag=0;
																if($_POST['fstids']!='')
																{
																	$flag=1;
																//	$cond = ' AND "STID" IN ('.$_POST['fstids'].')';
																}

																$flag1=0;
																if(isset($_SESSION['logindetails']['assignlist']) && $_SESSION['logindetails']['assignlist']!='')
																{
																	$flag1=1;

																//	$cond_dco = ' AND "STID" IN ('.$_SESSION['logindetails']['assignlist'].')';
																}	

																if($flag==1 && $flag1==1)
																{
																	$array = array(1,$_POST['fstids'],$_SESSION['logindetails']['assignlist']);
																	$queryst = 'select "STID" as "id","STName" as "Name" from "st'.$_SESSION['activeyears'].'" where is_deleted=$1 AND "STID" = Any(string_to_array($2::text, \',\'::text)::integer[]) AND "STID" = Any(string_to_array($3::text, \',\'::text)::integer[]) order by "STName" ASC';
																}
																else if($flag==1 && $flag1==0)
																{
																	$array = array(1,$_POST['fstids']);
																	$queryst = 'select "STID" as "id","STName" as "Name" from "st'.$_SESSION['activeyears'].'" where is_deleted=$1 AND "STID" = Any(string_to_array($2::text, \',\'::text)::integer[]) order by "STName" ASC';
																}
																else if($flag==0 && $flag1==1)
																{
																	$array = array(1,$_SESSION['logindetails']['assignlist']);
																	$queryst = 'select "STID" as "id","STName" as "Name" from "st'.$_SESSION['activeyears'].'" where is_deleted=$1 AND "STID" = Any(string_to_array($2::text, \',\'::text)::integer[]) order by "STName" ASC';
																}
																else if($flag==0 && $flag1==0)
																{
																	$array = array(1);
																	$queryst = 'select "STID" as "id","STName" as "Name" from "st'.$_SESSION['activeyears'].'" where is_deleted=$1 order by "STName" ASC';
																}

																

																$resultstquery = pg_query_params($db, $queryst,$array);
																if(pg_numrows($resultstquery)>0)
																{
																$rowst = pg_fetch_all($resultstquery); 	
																}


																$rowstt = array();
																$flag2=0;
																if($_POST['tstids']!='')
																{
																	$flag2=1;
																	// $cond1 = ' AND "STID" IN ('.$_POST['tstids'].')';
																}

																if($flag2==1 && $flag1==1)
																{
																	$array1 = array(1,$_POST['fstids'],$_POST['tstids']);
																	
																	$querystt = 'select "STID" as "id","STName" as "Name" from "st'.$_SESSION['activeyears'].'" where is_deleted=$1 AND "STID" = Any(string_to_array($2::text, \',\'::text)::integer[]) AND "STID" = Any(string_to_array($3::text, \',\'::text)::integer[]) order by "STName" ASC';


																	
																}
																else if($flag2==1 && $flag1==0)
																{
																	$array1 = array(1,$_POST['tstids']);
																	$querystt = 'select "STID" as "id","STName" as "Name" from "st'.$_SESSION['activeyears'].'" where is_deleted=$1 AND "STID" = Any(string_to_array($2::text, \',\'::text)::integer[]) order by "STName" ASC';
																}
																else if($flag2==0 && $flag1==1)
																{
																	$array1 = array(1,$_SESSION['logindetails']['assignlist']);
																	$querystt = 'select "STID" as "id","STName" as "Name" from "st'.$_SESSION['activeyears'].'" where is_deleted=$1 AND "STID" = Any(string_to_array($2::text, \',\'::text)::integer[]) order by "STName" ASC';
																}
																else if($flag2==0 && $flag1==0)
																{
																	$array1 = array(1);
																	$querystt = 'select "STID" as "id","STName" as "Name" from "st'.$_SESSION['activeyears'].'" where is_deleted=$1 order by "STName" ASC';
																}
																$resultstqueryt = pg_query_params($db, $querystt,$array1);

																if(pg_numrows($resultstqueryt)>0)
																{
																$rowstt = pg_fetch_all($resultstqueryt); 	
																}

																$resultaction = pg_query($db, "select * from detailforread where comefrom='ST' and (forreaddetails='Split' OR forreaddetails='Full Merge') and is_deleted=1 order by statuslevel ASC");
															if(pg_numrows($resultaction)>0)
															{
															$rowaction = pg_fetch_all($resultaction); 	
															}


												


												

								}
								
								else
								{
									// print_r($_POST);
									// exit;
													$arra=array(1);
													$query = 'select "STID" as "id","STName" as "Name" from "st'.$_SESSION['activeyears'].'" where is_deleted=$1  order by "STName" ASC';
												 	$resultstatelk = pg_query_params($db, $query,$arra);
													if(pg_numrows($resultstatelk)>0)
													{
													$row = pg_fetch_all($resultstatelk); 	
													}

													$rowstt = array();
																// $cond='';
																if($_POST['tstids']!='')
																{
																	
																$ar=array(1,$_POST['tstids']);
																	$querystt = 'select "STID" as "id","STName" as "Name" from "st'.$_SESSION['activeyears'].'" where is_deleted=$1 AND "STID" = Any(string_to_array($2::text, \',\'::text)::integer[]) order by "STName" ASC';
																}
																else
																{
																	$ar=array(1);
																	$querystt = 'select "STID" as "id","STName" as "Name" from "st'.$_SESSION['activeyears'].'" where is_deleted=$1 order by "STName" ASC';
																}	


																
																$resultstqueryt = pg_query_params($db, $querystt,$ar);
																if(pg_numrows($resultstqueryt)>0)
																{
																$rowstt = pg_fetch_all($resultstqueryt); 	
																}
														 		
													
													$whereaction = '';
												if(isset($_POST['createfrom']) && $_POST['createfrom']=='Merge')
												{
														$whereaction = " and (forreaddetails='Merge' OR forreaddetails='Partially Merge')";
												}
												else if(isset($_POST['clickpopup']) && $_POST['clickpopup']=='Reshuffle')
															{
															$whereaction = " and (forreaddetails='Reshuffle')";
															}
												else
												{
														$whereaction = " and (forreaddetails='Split')";
												}

												$resultaction = pg_query($db, "select * from detailforread where comefrom='ST' ".$whereaction."  and is_deleted=1 order by statuslevel ASC");
												if(pg_numrows($resultaction)>0)
												{
												$rowaction = pg_fetch_all($resultaction); 	
												}



							 

								}
echo json_encode($row)."|".json_encode($rowaction)."|".$_POST['comefrom']."|".urldecode($_POST['dtstname'])."|".json_encode($row1)."|".$_POST['createfrom']."|".$_POST['sdidsselected']."|".json_encode($rowst)."|".json_encode($rowstt)."|".$_SESSION['logindetails']['assignlist'];
  exit();

}

else if($_POST['formname']=='finaladddoc')
{
	//  print_r($_POST);
	
	if(isset($_POST['doc_reuse_desc'])) {
		// Handle the form data
		$doc_reuse_desc = $_POST['doc_reuse_desc'];
		$_SESSION['doc_reuse_desc'] = $doc_reuse_desc ;
		// Do something with $doc_reuse_desc
	  }
	  
		$finaldata =  (array) json_decode($_POST['finaldata']);
	 	$havep = false;

	
	 
	 if($_POST['clickbutton']!='Partiallysm')
	 {
	 		if(isset($_POST['reusecome']) && $_POST['reusecome']=='comefromdocreuse')
	 		{
	 				$arr=array($_POST['reusedocids']);
	 				$sql='select doc_reuse from documentdata'.$_SESSION['activeyears'].' where docids=$1';
	 				$sql_query = pg_query_params($db,$sql,$arr);
	 				$sql_query_data = pg_fetch_array($sql_query);

	 				$countd = '';
	 				$countd = $sql_query_data['doc_reuse']+1;

	 				$array=array($countd,$_POST['reusedocids']);
	 				pg_query_params($db,'update documentdata'.$_SESSION['activeyears'].' set "doc_reuse"=$1 where docids=$2',$array);

					
					 $arrar1=array($_POST['reusedocids'],$_SESSION['login_email'],$_SESSION['doc_reuse_desc']);
	 				// $arrar1=array($_POST['reusedocids'],$_SESSION['login_id'],$_SESSION['doc_reuse_desc']);
	 				pg_query_params($db,'insert into reuse_document'.$_SESSION['activeyears'].' ("docids","created_by","doc_reuse_desc") VALUES ($1,$2,$3)',$arrar1);

	 		}
	 }



if($_POST['clickbutton']=='Merge' || $_POST['clickbutton']=='Partiallysm')
{
	
	
		$task="";

		if($finaldata['comefromcheck']=='State')
		{
			if(isset($finaldata['returndata']) && $finaldata['returndata']!='')
			{
				$retdata =  (array) json_decode($finaldata['returndata']);


				//By sahana partially merge state level many to one 0111 3011	
				$auflag_query = 'SELECT auflag FROM unit WHERE auaction = $1 AND aulevel = $2';
				$actions = $retdata['action'];
				$namefrom_values = $retdata['namefrom'];
				$newnamem_values = $retdata['newnamem'];

				foreach ($actions as $key => $action) {
					$namefrom = $namefrom_values[$key];
					$au = pg_query_params($db, $auflag_query, array($action, $retdata['comefromcheck']));

					if ($au) {
						$row = pg_fetch_assoc($au);
						$auflag_value = $row['auflag'];

						
						$update_vt = pg_query_params($db, 'UPDATE vt'.$_SESSION['activeyears'].' SET "auflag" = $1, "auaction" = $2 WHERE "STID" = $3 OR "STID" = $4', array($auflag_value, $action, $namefrom, $newnamem)); 
						$update_sd = pg_query_params($db, 'UPDATE sd'.$_SESSION['activeyears'].' SET "auflag" = $1, "auaction" = $2 WHERE "STID" = $3 OR "STID" = $4', array($auflag_value, $action, $namefrom, $newnamem)); 
						$update_dt = pg_query_params($db, 'UPDATE dt'.$_SESSION['activeyears'].' SET "auflag" = $1, "auaction" = $2 WHERE "STID" = $3 OR "STID" = $4', array($auflag_value, $action, $namefrom, $newnamem)); 
						$update_st = pg_query_params($db, 'UPDATE st'.$_SESSION['activeyears'].' SET "auflag" = $1, "auaction" = $2 WHERE "STID" = $3 OR "STID" = $4', array($auflag_value, $action, $namefrom, $newnamem)); 

						if (!$update_st || !$update_dt || !$update_sd || !$update_vt) {
							echo "UPDATE query failed: " . pg_last_error($db);
						}
					} else {
						echo "SELECT query failed: " . pg_last_error($db);
					}
				}
				//

				$comestr='';
				if($retdata['clickpopup']=='Partiallysm')
				{
				$comestr='Partially Split & Merge';
				}
				else
				{
				$comestr='Partially Merge';

				}

				$k = array_keys($retdata['action'],$comestr);
				
				$nonfull = $retdata['namefrom'];
				$nonfull_status =$retdata['fstatus'];
				$full=[];
				foreach($nonfull as $key => $val)
				{
				if(array_search($key,$k) === false)
				{

				$full[]=$nonfull[$key];
				unset($nonfull[$key]);
				unset($nonfull_status[$key]);
				
				}
				
				}

				$nonfull = array_values($nonfull);
				$nonfull_status = array_values($nonfull_status);
				
			
				if(count($full)!=0)
				{
					$forreadqueryapp ='';
				for($j=0;$j<count($full);$j++)
				{

				$forreadqueryapp =array($full[$j],$retdata['action'][$j],$retdata['newnamem'][0],$retdata['docids'],$retdata['comefromcheck'],$retdata['clickpopup']);

					$forreaddata = "insert into forreaddata".$_SESSION['activeyears']." (frfromids,frfromaction,frtoids,frdocids,frcomefrom,comeaction) VALUES ($1,$2,$3,$4,$5,$6)";
				pg_query_params($db,$forreaddata,$forreadqueryapp);

				}
			

				// $forreadqueryappqu = rtrim($forreadqueryapp, ',');

				$insertlink = 'insert into documentlink'.$_SESSION['activeyears'].' (docids,linkstids) VALUES ($1,$2)';	
					$resultas = pg_query_params($db,$insertlink,array($retdata['docids'],$retdata['newnamem'][0]));
				
				// 12_09 $forread1data = "insert into forreaddata".$_SESSION['activeyears']." (frfromids,frfromaction,frtoids,frdocids,frcomefrom,comeaction) VALUES ($1,$2,$3,$4,$5,$6)";
				// 12_09 pg_query_params($db,$forread1data,array($retdata['newnamem'][0],'Merge',$retdata['newnamem'][0],$retdata['docids'],$retdata['comefromcheck'],'MAIN'));

			

				$stateremove = 'update st'.$_SESSION['activeyears'].' set is_deleted=$1 where st'.$_SESSION['activeyears'].'."STID" = Any(string_to_array($2::text, \',\'::text)::integer[])';
				$arra=array($retdata['newnamem'][0],implode(',',$full));

				$dtupdate = 'update dt'.$_SESSION['activeyears'].' set "STID"=$1 where "STID" = Any(string_to_array($2::text, \',\'::text)::integer[])';
				$sdupdate = 'update sd'.$_SESSION['activeyears'].' set "STID"=$1 where "STID" = Any(string_to_array($2::text, \',\'::text)::integer[])';
				$vtupdate = 'update vt'.$_SESSION['activeyears'].' set "STID"=$1 where "STID" = Any(string_to_array($2::text, \',\'::text)::bigint[])';

				pg_query_params($db,$stateremove,array(0,implode(',',$full)));
				pg_query_params($db,$dtupdate,$arra);
				pg_query_params($db,$sdupdate,$arra);
				pg_query_params($db,$vtupdate,$arra);

				}
				
				// $documentdata = "update documentdata".$_SESSION['activeyears']." set docstatus=2 where \"docids\"=".$retdata['docids']."";

				

				
				// pg_query($db,$documentdata);
				
				
					// JIGAR

					$linkDTarray = array();
					$forread = '';
					$forread1 = '';
					for($j=0;$j<count($k);$j++)
					{


					if(isset($finaldata['addlinksDTID'.$k[$j].'']))
					{

					if(isset($finaldata['partiallylevel'.$k[$j].'']))
					{
							$havep = true;

							for($a=0;$a<count($finaldata['partiallylevel'.$k[$j].'']);$a++)
								{
									//$partiallylevel .="('".$retdata['comefromcheck']."',".$nonfull[$j].",'Partially Merge',".$retdata['newnamem'][0].",".$retdata['docids'].",".$finaldata['partiallylevel'.$k[$j].''][$a].")," ;
									$partiallylevel .="('".$retdata['comefromcheck']."',".$nonfull[$j].",'Partially Merge',".$retdata['newnamem'][0].",".$retdata['docids'].",".$finaldata['partiallylevel'.$k[$j].''][$a].",".$nonfull[$j].")," ;  //12122023
								}



						$finaldata['addlinksDTID'.$k[$j].''] = array_diff($finaldata['addlinksDTID'.$k[$j].''],$finaldata['partiallylevel'.$k[$j].'']);
					}

						$linkDTarray=array_merge($linkDTarray,$finaldata['addlinksDTID'.$k[$j].'']);	 		
					}

					//modidified by gowthami and sahana 1512
					$frcomment='';
					if($retdata['newnamecheck'][0]!='')
					{
						$frcomment .='<strong style="color:#aa81f3;"><u>State/UT:</u></strong> '.$retdata['namefromtext'].' '.$retdata['action'][$j].'d into '.$retdata['nametotext'].' and '.$retdata['nametotext'].' '.$retdata['comefromcheck'].' Name Changed to '.$retdata['newnamecheck'][$j].';';
					}
					else
					{
						$frcomment .='<strong style="color:#aa81f3;"><u>State/UT:</u></strong> '.$retdata['namefromtext'].' '.$retdata['action'][$j].'d into '.$retdata['nametotext'].';';
					}
					$frcomment .=' <strong style="color:Green;"><u>District:</u></strong> <strong style="color:blue;"><br><u>Sub District:</u></strong> <strong style="color:#45b0e2;"><br><u>Town:</u></strong> <strong style="color:#15bed2;"><br><u>Village:</u></strong> ';

					//modidified by gowthami and sahana 1512
					$forread1 =array($nonfull[$j],'Partially Merge',$nonfull[$j],$retdata['docids'],$retdata['comefromcheck'],'MAIN',$frcomment);
					$insertforread1 = 'insert into forreaddata'.$_SESSION['activeyears'].' (frfromids,frfromaction,frtoids,frdocids,frcomefrom,comeaction,frcomment) VALUES ($1,$2,$3,$4,$5,$6,$7)';
					pg_query_params($db,$insertforread1,$forread1);

					//modidified by gowthami and sahana 1512
					$forread = array($nonfull[$j],'Partially Merge',$retdata['newnamem'][0],$retdata['docids'],$retdata['comefromcheck'],'Partially Merge',$frcomment);
					$insertforread = 'insert into forreaddata'.$_SESSION['activeyears'].' (frfromids,frfromaction,frtoids,frdocids,frcomefrom,comeaction,frcomment) VALUES ($1,$2,$3,$4,$5,$6,$7)';
					pg_query_params($db,$insertforread,$forread);

					

					}
					// $forreadqueryappend = rtrim($forread, ',');
					// $forreadqueryappend1 = rtrim($forread1, ',');
					
					$linkdt='';
					if(count($linkDTarray)>0)
					{
					for($l=0;$l<count($linkDTarray);$l++)
					{
					$linkdt =array($retdata['docids'],$retdata['newnamem'][0],$linkDTarray[$l]);
					

					$insertlinkdt = 'insert into documentlink'.$_SESSION['activeyears'].' (docids,linkstids,linkdtids) VALUES ($1,$2,$3)';	
					// Partially split and merged Sahana
					$resultdt = pg_query_params($db,$insertlinkdt,$linkdt);
					}

					}
					
					

					

					for($kl=0;$kl<count($nonfull_status);$kl++)
					{
						 $stateremove1 = 'update st'.$_SESSION['activeyears'].' set "Status"=$1 where st'.$_SESSION['activeyears'].'."STID"=$2';
						pg_query_params($db,$stateremove1,array($nonfull_status[$kl],$nonfull[$kl]));
					}
					// $stateremove = 'update st'.$_SESSION['activeyears'].' set Status=\''..'\' where st'.$_SESSION['activeyears'].'."STID" IN ('.implode(',',$finaldata['namefrom']).')';

					$arrr=array($retdata['newnamem'][0],implode(',',$linkDTarray));
					pg_query_params($db,'update dt'.$_SESSION['activeyears'].' set "STID"=$1 where dt'.$_SESSION['activeyears'].'."DTID" = Any(string_to_array($2::text, \',\'::text)::integer[])',$arrr);

					pg_query_params($db,'update sd'.$_SESSION['activeyears'].' set "STID"=$1 where sd'.$_SESSION['activeyears'].'."DTID" = Any(string_to_array($2::text, \',\'::text)::integer[])',$arrr);

					pg_query_params($db,'update vt'.$_SESSION['activeyears'].' set "STID"=$1 where vt'.$_SESSION['activeyears'].'."DTID" = Any(string_to_array($2::text, \',\'::text)::bigint[])',$arrr);

					// pg_query_params('update wd'.$_SESSION['activeyears'].' set "STID"=$1 where wd'.$_SESSION['activeyears'].'."DTID" IN ($2)');

					if($partiallylevel!='')
					{

					$partiallylevelquery = rtrim($partiallylevel, ',');

                        //modified by Gowthami to solve the issue related to wine line in Au
						//pg_query("insert into partiallydata".$_SESSION['activeyears']." (comefrom,fromids,comeaction,toids,docids,partiallydataids) VALUES ".$partiallylevelquery." ");
						pg_query("insert into partiallydata".$_SESSION['activeyears']." (comefrom,fromids,comeaction,toids,docids,partiallydataids,stid) VALUES ".$partiallylevelquery." ");
					}

					if($finaldata['partiallyids']!='')
					{


					pg_query_params($db,'update partiallydata'.$_SESSION['activeyears'].' set "pstatus"=$1 where partiallyids=$2',array(1,$finaldata['partiallyids']));	
					}

					$sql_da = pg_query_params($db,'select * from partiallydata'.$_SESSION['activeyears'].' where docids=$1 AND pstatus=$2',array($retdata['docids'],0));
					if(pg_numrows($sql_da)==0)
					{
					pg_query_params($db,'update documentdata'.$_SESSION['activeyears'].' set docstatus=$1 where docids=$2',array(1,$retdata['docids']));

					}
					else
					{
						pg_query_params($db,'update documentdata'.$_SESSION['activeyears'].' set docstatus=$1 where docids=$2',array(2,$retdata['docids']));
					}




					if($retdata['oremovenewarray']==1)
					{
					$stnameupdate = "update st".$_SESSION['activeyears']." set \"STName\"=$1,\"Status\"=$2 where \"STID\"=$3";		
					pg_query_params($db,$stnameupdate,array($retdata['newnamecheck'][0],ucwords($retdata['StateStatus'][0]),$retdata['newnamem'][0]));
				
				//	pg_query_params($db,$stnameupdate,array(ucwords(strtolower($retdata['newnamecheck'][0])),ucwords(strtoupper($retdata['StateStatus'][0])),$retdata['newnamem'][0]));	
					}
					else
					{
						$stnameupdate = "update st".$_SESSION['activeyears']." set \"Status\"=$1 where \"STID\"=$2";		
						pg_query_params($db,$stnameupdate,array($retdata['StateStatus'][0],$retdata['newnamem'][0]));

					//pg_query_params($db,$stnameupdate,array(ucwords(strtoupper($retdata['StateStatus'][0])),$retdata['newnamem'][0]));
					}

					//modidified by gowthami and sahana 1512 start
					$art=array();
					$art=array($retdata['newnamem'][0],1);

					$quu='';
					$quu1='';

					if($finaldata['newnamecheck'][0]=='')
					{
					$quu =' AND sd21."STIDR"::integer!=$1 ';
					$quu1 =' AND vt21."STIDR"::bigint!=$1 ';
					}

					$finalquerysd = '
					insert into forreaddata2021 ("SDID","frfromids","frfromaction","frtoids","frdocids","frcomefrom",
					"frcomment","is_final","comeaction","STID","DTID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","STIDR","DTIDR","SDIDR","created_by")
					(
					select DISTINCT(unnest(string_to_array(sd21."STIDR", \',\'))::BIGINT) AS "STIDR11",unnest(string_to_array(sd21."STIDR", \',\'))::NUMERIC as "frfromids"
					 ,(select "frfromaction" from forreaddata2021 where "frtoids"=$1 AND frfromaction=\'Partially Merge\' ORDER BY "frids" DESC LIMIT 1) as "frfromaction"
					 ,sd21."STID" as "frtoids"
					 ,(select "frdocids" from forreaddata2021 where "frtoids"=$1 AND frfromaction=\'Partially Merge\' ORDER BY "frids" DESC LIMIT 1) as "frdocids"
					 ,(select "frcomefrom" from forreaddata2021 where "frtoids"=$1 AND frfromaction=\'Partially Merge\' ORDER BY "frids" DESC LIMIT 1) as "frcomefrom"
					 ,(select "frcomment" from forreaddata2021 where "frtoids"=$1 AND frfromaction=\'Partially Merge\' ORDER BY "frids" DESC LIMIT 1) as "frcomment"
					 ,(select "is_final" from forreaddata2021 where "frtoids"=$1 AND frfromaction=\'Partially Merge\' ORDER BY "frids" DESC LIMIT 1) as "is_final"
					 ,(select "comeaction" from forreaddata2021 where "frtoids"=$1 AND frfromaction=\'Partially Merge\' ORDER BY "frids" DESC LIMIT 1) as "comeaction"
					 ,unnest(string_to_array(sd21."STIDR", \',\'))::integer AS "STIDR11",unnest(string_to_array(sd21."DTIDR", \',\'))::integer AS "DTIDR11",sd21."STID",sd21."DTID"
					 ,sd21."SDID",unnest(string_to_array(sd21."STIDR", \',\'))::integer,unnest(string_to_array(sd21."DTIDR", \',\'))::integer,
					 unnest(string_to_array(sd21."SDIDR", \',\'))::BIGINT,(select "created_by" from forreaddata2021 where "frtoids"=$1 AND frfromaction =\'Partially Merge\' ORDER BY "frids" DESC LIMIT 1) as "created_by" from sd2021 as sd21 
					LEFT JOIN (select * from forreaddata2021 where "frtoids"=$1 AND frfromaction=\'Partially Merge\'  ORDER BY "frids" DESC) as fr21 ON fr21."frtoids"=sd21."STID" 
						and fr21."frfromids" = Any(string_to_array(sd21."STIDR"::text, \',\'::text)::NUMERIC[])  
					where sd21."STID"=$1 '.$quu.' AND sd21."is_deleted"=$2
					)';
					pg_query_params($db,$finalquerysd,$art);

					 $finalqueryvt = 'insert into forreaddata2021 ("frfromids","frfromaction","frtoids","frdocids","frcomefrom",
					 "frcomment","is_final","comeaction","STID","DTID","SDID","VTID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE","STIDR","DTIDR","SDIDR","VTIDR","created_by")
					 (
					 select unnest(string_to_array(vt21."STIDR", \',\')) ::NUMERIC as "frfromids"
						 ,(select "frfromaction" from forreaddata2021 where "frtoids"=$1 AND frfromaction =\'Partially Merge\'  AND "SDID"!=0 ORDER BY "frids" DESC LIMIT 1) as "frfromaction"
						 ,vt21."STID" as "frtoids"
						 ,(select "frdocids" from forreaddata2021 where "frtoids"=$1 AND frfromaction =\'Partially Merge\'  AND "SDID"!=0 ORDER BY "frids" DESC LIMIT 1) as "frdocids"
						 ,(select "frcomefrom" from forreaddata2021 where "frtoids"=$1 AND frfromaction =\'Partially Merge\'  AND "SDID"!=0 ORDER BY "frids" DESC LIMIT 1) as "frcomefrom"
						 ,(select "frcomment" from forreaddata2021 where "frtoids"=$1 AND frfromaction =\'Partially Merge\'  AND "SDID"!=0 ORDER BY "frids" DESC LIMIT 1) as "frcomment"
						 ,(select "is_final" from forreaddata2021 where "frtoids"=$1 AND frfromaction =\'Partially Merge\'  AND "SDID"!=0 ORDER BY "frids" DESC LIMIT 1) as "is_final"
						 ,(select "comeaction" from forreaddata2021 where "frtoids"=$1 AND frfromaction =\'Partially Merge\'  AND "SDID"!=0 ORDER BY "frids" DESC LIMIT 1) as "comeaction"
						 ,unnest(string_to_array(vt21."STIDR", \',\')) ::integer AS "STIDR11",unnest(string_to_array(vt21."DTIDR", \',\')) ::integer AS "DTIDR11",unnest(string_to_array(vt21."SDIDR", \',\'))::BIGINT AS "SDIDR11",unnest(string_to_array(vt21."VTIDR", \',\'))::NUMERIC AS "VTIDR11"
						 ,vt21."STID",vt21."DTID",vt21."SDID",vt21."VTID",unnest(string_to_array(vt21."STIDR", \',\')) ::integer,unnest(string_to_array(vt21."DTIDR", \',\'))::integer,unnest(string_to_array(vt21."SDIDR", \',\'))::BIGINT,unnest(string_to_array(vt21."VTIDR", \',\'))::NUMERIC
						 ,(select "created_by" from forreaddata2021 where "frtoids"=$1 AND frfromaction =\'Partially Merge\'  AND "SDID"!=0 ORDER BY "frids" DESC LIMIT 1) as "created_by" from vt2021 as vt21
					 LEFT JOIN (select * from forreaddata2021 where "frtoids"=$1 AND frfromaction =\'Partially Merge\'  AND "SDID"=0 ORDER BY "frids" DESC) as fr21 ON fr21."frtoids"=vt21."STID" and fr21."frfromids" = Any(string_to_array(vt21."STIDR"::text, \',\'::text)::NUMERIC[])  
					 where vt21."STID"=$1 '.$quu1.' AND vt21."is_deleted"=$2
					 )';
				 
				pg_query_params($db, $finalqueryvt, $art);

				//modidified by gowthami and sahana 1512 end

				// JIGAR
				$task = "mergedone";
				
							
			}
			else
			{
					//sahana merge state level many to one n one to one 0111
					$auflag_query = 'SELECT auflag FROM unit WHERE auaction = $1 AND aulevel = $2';
					$actions = $finaldata['action'];
					$namefrom_values = $finaldata['namefrom'];
					// $newnamem_values = $finaldata['newnamem'];

					foreach ($actions as $key => $action) {
						$namefrom = $namefrom_values[$key];
						// $newnamem = $newnamem_values[0];

						$au = pg_query_params($db, $auflag_query, array($action, $finaldata['comefromcheck']));

						if ($au) {
							$row = pg_fetch_assoc($au);
							$auflag_value = $row['auflag'];

							// $update_vt = pg_query_params($db, 'UPDATE vt'.$_SESSION['activeyears'].' SET "auflag" = $1, "auaction" = $2 WHERE "STID" = $3 OR "STID" = $4', array($auflag_value, $action, $namefrom, $newnamem));
							$update_vt = pg_query_params($db, 'UPDATE vt'.$_SESSION['activeyears'].' SET "auflag" = $1, "auaction" = $2 WHERE "STID" = $3', array($auflag_value, $action, $namefrom));
							$update_sd = pg_query_params($db, 'UPDATE sd'.$_SESSION['activeyears'].' SET "auflag" = $1, "auaction" = $2 WHERE "STID" = $3', array($auflag_value, $action, $namefrom));
							$update_dt = pg_query_params($db, 'UPDATE dt'.$_SESSION['activeyears'].' SET "auflag" = $1, "auaction" = $2 WHERE "STID" = $3', array($auflag_value, $action, $namefrom));
							$update_st = pg_query_params($db, 'UPDATE st'.$_SESSION['activeyears'].' SET "auflag" = $1, "auaction" = $2 WHERE "STID" = $3', array($auflag_value, $action, $namefrom));

							if (!$update_st || !$update_dt || !$update_sd || !$update_vt) {
								echo "UPDATE query failed: " . pg_last_error($db);
							}
						} else {
							echo "SELECT query failed: " . pg_last_error($db);
						}
					}	
	
					$forreadqueryapp ='';
					for($j=0;$j<count($finaldata['namefrom']);$j++)
					{
					$frcomment='';

												

					if($finaldata['newnamecheck'][0]!='')
					{

					$frcomment .='<strong style="color:#aa81f3;"><u>State/UT:</u></strong> '.$finaldata['namefromtext'].' '.$finaldata['action'][$j].'d into '.$finaldata['nametotext'].' and '.$finaldata['nametotext'].' '.$finaldata['comefromcheck'].' Name Changed to '.$finaldata['newnamecheck'][$j].';';
					}
					else
					{
					$frcomment .='<strong style="color:#aa81f3;"><u>State/UT:</u></strong> '.$finaldata['namefromtext'].' '.$finaldata['action'][$j].'d into '.$finaldata['nametotext'].';';
					}
					$frcomment .=' <strong style="color:Green;"><u>District:</u></strong><strong style="color:blue;"><br><u>Sub District:</u></strong> <strong style="color:#45b0e2;"><br><u>Town:</u></strong> <strong style="color:#15bed2;"><br><u>Village:</u></strong>';


					$sqlo='Select "STIDR" from st'.$_SESSION['activeyears'].' WHERE "STID"=$1 AND is_deleted=$2';
					$sqlold = pg_query_params($db,$sqlo,array($finaldata['namefrom'][$j],1));
					$sqlda = pg_fetch_array($sqlold);

				
						$forreadqueryapp =array($finaldata['namefrom'][$j],$finaldata['action'][$j],$finaldata['newnamem'][0],$finaldata['docids'],$finaldata['comefromcheck'],$frcomment,$_POST['clickbutton'],$finaldata['namefrom'][$j],$finaldata['newnamem'][0],$sqlda['STIDR']);
					 $forread = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","STIDACTIVE","STIDR") VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10)';


							$resdata = pg_query_params($db,$forread,$forreadqueryapp);
						
					}
				// 	$forreadqueryappqu = rtrim($forreadqueryapp, ',');

					
					$result_rows = pg_affected_rows($resdata);
							if($result_rows!=0)
							{

								$linkk='';
								$linkarray = $finaldata['namefrom'];
								$arrayof=array_merge($linkarray,$finaldata['newnamem']);
								
								for($i=0;$i<count($arrayof);$i++)
								{
								$linkk =array($finaldata['docids'],$arrayof[$i]);
								
								$linkdata = "insert into documentlink".$_SESSION['activeyears']." (docids,linkstids) VALUES ".$linkk_final."";
									pg_query_params($db,$linkdata,$linkk);
								}
								

								$stateremove = 'update st'.$_SESSION['activeyears'].' set is_deleted=$1 where st'.$_SESSION['activeyears'].'."STID" = Any(string_to_array($2::text, \',\'::text)::integer[])';

								$documentdata = "update documentdata".$_SESSION['activeyears']." set docstatus=$1 where \"docids\"=$2";

								$arrp=array($finaldata['newnamem'][0],implode(',',$finaldata['namefrom']));
								$dtupdate = 'update dt'.$_SESSION['activeyears'].' set "STID"=$1 where "STID" = Any(string_to_array($2::text, \',\'::text)::integer[])';
								$sdupdate = 'update sd'.$_SESSION['activeyears'].' set "STID"=$1 where "STID" = Any(string_to_array($2::text, \',\'::text)::integer[])';
								$vtupdate = 'update vt'.$_SESSION['activeyears'].' set "STID"=$1 where "STID" = Any(string_to_array($2::text, \',\'::text)::bigint[])';
								

								pg_query_params($db,$documentdata,array(1,$finaldata['docids']));
							
								pg_query_params($db,$stateremove,array(0,implode(',',$finaldata['namefrom'])));
								pg_query_params($db,$dtupdate,$arrp);
								pg_query_params($db,$sdupdate,$arrp);
								pg_query_params($db,$vtupdate,$arrp);

								if($finaldata['oremovenewarray']==1)
								{

								$stnameupdate = "update st".$_SESSION['activeyears']." set \"STName\"=$1,\"Status\"=$2 where \"STID\"=$3";		

								pg_query_params($db,$stnameupdate,array($finaldata['newnamecheck'][0], ucwords(strtoupper($finaldata['StateStatus'][0])),$finaldata['newnamem'][0]));	
								}
								else
								{
								$stnameupdate = "update st".$_SESSION['activeyears']." set \"Status\"=$1 where \"STID\"=$2";		

								pg_query_params($db,$stnameupdate,array($finaldata['StateStatus'][0],$finaldata['newnamem'][0]));	
								}

								//modidified by gowthami and sahana 1512 start
								$art=array();
								$art=array($finaldata['newnamem'][0],1);

								$quu='';
								$quu1='';
								$quu2='';

								if($finaldata['newnamecheck'][0]=='')
								{
								$quu2 =' AND dt21."STIDR"::integer!=$1 ';
								$quu =' AND sd21."STIDR"::integer!=$1 ';
								$quu1 =' AND vt21."STIDR"::bigint!=$1 ';
								}

								// $finalquerydt = 'insert into forreaddata2021 ("frfromids","frfromaction","frtoids","frdocids","frcomefrom",
								// "frcomment","is_final","comeaction","STID","DTID","SDID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","STIDR","DTIDR","SDIDR")
								// (select "frfromids","frfromaction","frtoids","frdocids","frcomefrom",
								// "frcomment","is_final","comeaction",dt21."STIDR"::integer AS "STIDR11",dt21."DTIDR"::integer AS "DTIDR11",dt21."STID",dt21."DTID",dt21."STIDR"::integer,dt21."DTIDR"::integer from dt2021 as dt21 
								// LEFT JOIN (select * from forreaddata2021 where "frtoids"=$1 AND frfromaction=\'Merge\' ORDER BY "frids" DESC) as fr21 ON fr21."frtoids"=dt21."STID" and fr21."frfromids"::text=dt21."STIDR" 
								// where dt21."STID"=$1 AND dt21."is_deleted"=$2 AND frfromids is not null
								// )';
								// pg_query_params($db,$finalquerydt,$art);

								
								// $finalquerysd = 'insert into forreaddata2021 ("frfromids","frfromaction","frtoids","frdocids","frcomefrom",
								// "frcomment","is_final","comeaction","STID","DTID","SDID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","STIDR","DTIDR","SDIDR")
								// (select "frfromids","frfromaction","frtoids","frdocids","frcomefrom",
								// "frcomment","is_final","comeaction",sd21."STIDR"::integer AS "STIDR11",sd21."DTIDR"::integer AS "DTIDR11",sd21."SDIDR"::BIGINT AS "SDIDR11",sd21."STID",sd21."DTID",sd21."SDID",sd21."STIDR"::integer,sd21."DTIDR"::integer,sd21."SDIDR"::BIGINT from sd2021 as sd21 
								// LEFT JOIN (select * from forreaddata2021 where "frtoids"=$1 AND frfromaction=\'Merge\' ORDER BY "frids" DESC) as fr21 ON fr21."frtoids"=sd21."DTID" and fr21."frfromids"::text=sd21."DTIDR" 
								// where sd21."DTID"=$1 AND sd21."is_deleted"=$2 AND frfromids is not null
								// )';
								// pg_query_params($db,$finalquerysd,$art);

								// $finalqueryvt = 'insert into forreaddata2021 ("frfromids","frfromaction","frtoids","frdocids","frcomefrom",
								// "frcomment","is_final","comeaction","STID","DTID","SDID","VTID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE","STIDR","DTIDR","SDIDR","VTIDR")
								// (select "frfromids","frfromaction","frtoids","frdocids","frcomefrom",
								// "frcomment","is_final","comeaction",vt21."STIDR"::integer AS "STIDR11",vt21."DTIDR"::integer AS "DTIDR11",vt21."SDIDR"::BIGINT AS "SDIDR11",vt21."VTIDR"::NUMERIC AS "VTIDR11",vt21."STID",vt21."DTID",vt21."SDID",vt21."VTID",vt21."STIDR"::integer,vt21."DTIDR"::integer,vt21."SDIDR"::BIGINT,vt21."VTIDR"::NUMERIC from vt2021 as vt21 
								// LEFT JOIN (select * from forreaddata2021 where "frtoids"=$1 AND frfromaction=\'Merge\' ORDER BY "frids" DESC) as fr21 ON fr21."frtoids"=vt21."DTID" and fr21."frfromids"::text=vt21."DTIDR" 
								// where vt21."DTID"=$1 AND vt21."is_deleted"=$2 AND frfromids is not null
								// )';
								// pg_query_params($db,$finalqueryvt,$art);

								$finalquerysd = '
								insert into forreaddata2021 ("SDID","frfromids","frfromaction","frtoids","frdocids","frcomefrom",
								"frcomment","is_final","comeaction","STID","DTID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","STIDR","DTIDR","SDIDR","created_by")
								(
								select DISTINCT(unnest(string_to_array(sd21."STIDR", \',\'))::BIGINT) AS "STIDR11",unnest(string_to_array(sd21."STIDR", \',\'))::NUMERIC as "frfromids"
								 ,(select "frfromaction" from forreaddata2021 where "frtoids"=$1 AND frfromaction=\'Merge\' ORDER BY "frids" DESC LIMIT 1) as "frfromaction"
								 ,sd21."STID" as "frtoids"
								 ,(select "frdocids" from forreaddata2021 where "frtoids"=$1 AND frfromaction=\'Merge\' ORDER BY "frids" DESC LIMIT 1) as "frdocids"
								 ,(select "frcomefrom" from forreaddata2021 where "frtoids"=$1 AND frfromaction=\'Merge\' ORDER BY "frids" DESC LIMIT 1) as "frcomefrom"
								 ,(select "frcomment" from forreaddata2021 where "frtoids"=$1 AND frfromaction=\'Merge\' ORDER BY "frids" DESC LIMIT 1) as "frcomment"
								 ,(select "is_final" from forreaddata2021 where "frtoids"=$1 AND frfromaction=\'Merge\' ORDER BY "frids" DESC LIMIT 1) as "is_final"
								 ,(select "comeaction" from forreaddata2021 where "frtoids"=$1 AND frfromaction=\'Merge\' ORDER BY "frids" DESC LIMIT 1) as "comeaction"
								 ,unnest(string_to_array(sd21."STIDR", \',\'))::integer AS "STIDR11",unnest(string_to_array(sd21."DTIDR", \',\'))::integer AS "DTIDR11",sd21."STID",sd21."DTID"
								 ,sd21."SDID",unnest(string_to_array(sd21."STIDR", \',\'))::integer,unnest(string_to_array(sd21."DTIDR", \',\'))::integer,
								 unnest(string_to_array(sd21."SDIDR", \',\'))::BIGINT,(select "created_by" from forreaddata2021 where "frtoids"=$1 AND frfromaction =\'Merge\' ORDER BY "frids" DESC LIMIT 1) as "created_by" from sd2021 as sd21 
								LEFT JOIN (select * from forreaddata2021 where "frtoids"=$1 AND frfromaction=\'Merge\'  ORDER BY "frids" DESC) as fr21 ON fr21."frtoids"=sd21."STID" 
									and fr21."frfromids" = Any(string_to_array(sd21."STIDR"::text, \',\'::text)::NUMERIC[])  
								where sd21."STID"=$1 '.$quu.' AND sd21."is_deleted"=$2
								)';
								pg_query_params($db,$finalquerysd,$art);

								 $finalqueryvt = 'insert into forreaddata2021 ("frfromids","frfromaction","frtoids","frdocids","frcomefrom",
								 "frcomment","is_final","comeaction","STID","DTID","SDID","VTID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE","STIDR","DTIDR","SDIDR","VTIDR","created_by")
								 (
								 select unnest(string_to_array(vt21."STIDR", \',\')) ::NUMERIC as "frfromids"
									 ,(select "frfromaction" from forreaddata2021 where "frtoids"=$1 AND frfromaction =\'Merge\'  AND "SDID"!=0 ORDER BY "frids" DESC LIMIT 1) as "frfromaction"
									 ,vt21."STID" as "frtoids"
									 ,(select "frdocids" from forreaddata2021 where "frtoids"=$1 AND frfromaction =\'Merge\'  AND "SDID"!=0 ORDER BY "frids" DESC LIMIT 1) as "frdocids"
									 ,(select "frcomefrom" from forreaddata2021 where "frtoids"=$1 AND frfromaction =\'Merge\'  AND "SDID"!=0 ORDER BY "frids" DESC LIMIT 1) as "frcomefrom"
									 ,(select "frcomment" from forreaddata2021 where "frtoids"=$1 AND frfromaction =\'Merge\'  AND "SDID"!=0 ORDER BY "frids" DESC LIMIT 1) as "frcomment"
									 ,(select "is_final" from forreaddata2021 where "frtoids"=$1 AND frfromaction =\'Merge\'  AND "SDID"!=0 ORDER BY "frids" DESC LIMIT 1) as "is_final"
									 ,(select "comeaction" from forreaddata2021 where "frtoids"=$1 AND frfromaction =\'Merge\'  AND "SDID"!=0 ORDER BY "frids" DESC LIMIT 1) as "comeaction"
									 ,unnest(string_to_array(vt21."STIDR", \',\')) ::integer AS "STIDR11",unnest(string_to_array(vt21."DTIDR", \',\')) ::integer AS "DTIDR11",unnest(string_to_array(vt21."SDIDR", \',\'))::BIGINT AS "SDIDR11",unnest(string_to_array(vt21."VTIDR", \',\'))::NUMERIC AS "VTIDR11"
									 ,vt21."STID",vt21."DTID",vt21."SDID",vt21."VTID",unnest(string_to_array(vt21."STIDR", \',\')) ::integer,unnest(string_to_array(vt21."DTIDR", \',\'))::integer,unnest(string_to_array(vt21."SDIDR", \',\'))::BIGINT,unnest(string_to_array(vt21."VTIDR", \',\'))::NUMERIC
									 ,(select "created_by" from forreaddata2021 where "frtoids"=$1 AND frfromaction =\'Merge\'  AND "SDID"!=0 ORDER BY "frids" DESC LIMIT 1) as "created_by" from vt2021 as vt21
								 LEFT JOIN (select * from forreaddata2021 where "frtoids"=$1 AND frfromaction =\'Merge\'  AND "SDID"=0 ORDER BY "frids" DESC) as fr21 ON fr21."frtoids"=vt21."STID" and fr21."frfromids" = Any(string_to_array(vt21."STIDR"::text, \',\'::text)::NUMERIC[])  
								 where vt21."STID"=$1 '.$quu1.' AND vt21."is_deleted"=$2
								 )';
							 
								pg_query_params($db, $finalqueryvt, $art);
							 	//modidified by gowthami and sahana 1512 end


								$task = "mergedone";

							}
							else
							{
							$task = "error";
							}

			}
		}
		else if($finaldata['comefromcheck']=='District')
		{
			 
			$comestr='';
			if($_POST['clickbutton']=='Partiallysm')
			{
			$comestr='Partially Split & Merge';
			}
			else
			{
			$comestr='Partially Merge';

			}
			
			if(isset($finaldata['returndata']) && $finaldata['returndata']!='')
			{



				$retdata =  (array) json_decode($finaldata['returndata']);

					
				if(isset($retdata['statenewarray']))
				{
				$statenewarray = explode(',',$retdata['statenewarray']);
				}

				if(isset($retdata['statenewarrayfrom']))
							{
							$statenewarrayfrom = explode(',',$retdata['statenewarrayfrom']);
							}
					
					
				$k = array_keys($retdata['action'],$comestr);

				

				$nonfull = $retdata['namefrom'];
				$nonfullst = $retdata['fromstate'];
				$nonfull1 = explode(',',$retdata['namefromtext']);
				$full=[];
				$fullname=[];
				$fullST=[];
				foreach($nonfull as $key => $val)
				{
				if(array_search($key,$k) === false)
				{

				$full[]=$nonfull[$key];
				$fullname[]=$nonfull1[$key];
				$fullST[]=$nonfullst[$key];
				unset($nonfull[$key]);
				unset($nonfull1[$key]);
				unset($nonfullst[$key]);
				
				}
				
				}

				$nonfull = array_values($nonfull);
				$nonfull1 = array_values($nonfull1);
				$nonfullst = array_values($nonfullst);
				
				// print_r($full);
				// print_r($fullname);

				
				if(count($full)!=0)
				{
						// print_r($fullname);
						// exit;
						$forreadqueryapp ='';

						for($j=0;$j<count($full);$j++)
						{
							
							$frcomment='';
							$frcomment .='<strong style="color:#aa81f3;"><u>State/UT:</u></strong> '.$statenewarray[0].';';

							if($retdata['newnamecheck'][0]!='')
							{

							$frcomment .=' <strong style="color:Green;"><u>District:</u></strong> '.$fullname[$j].' Merged into '.$retdata['nametotext'].' and '.$retdata['nametotext'].' Name Changed to '.$retdata['newnamecheck'][0].';';
							}
							else
							{
							$frcomment .=' <strong style="color:Green;"><u>District:</u></strong> '.$fullname[$j].' Merged into '.$retdata['nametotext'].';';
							}
							$frcomment .=' <strong style="color:blue;"><u>Sub District:</u></strong> - ; <strong style="color:#45b0e2;"><u>Town:</u></strong> - ; <strong style="color:#15bed2;"><u>Village:</u></strong> - ;';

												


							$sqlo='Select "STIDR","DTIDR" from dt'.$_SESSION['activeyears'].' WHERE "STID"=$1 AND "DTID"=$2';
							 // AND is_deleted=$3
							$sqlold = pg_query_params($db,$sqlo,array($fullST[$j],$full[$j]));
							// $sqlda = pg_fetch_array($sqlold);
							$sqlda = pg_fetch_all($sqlold);
							for($iii=0;$iii<count($sqlda);$iii++)
							{
											//print_r($sqlda);
								// 	$forreadqueryapp =array($finaldata['namefrom'][$j],$finaldata['action'][$j],$finaldata['newnamem'][0],$finaldata['docids'],$finaldata['comefromcheck'],$frcomment,$_POST['clickbutton'],$finaldata['fromstate'][$j],$finaldata['namefrom'][$j],$finaldata['statenew'][0],$finaldata['newnamem'][0],$sqlda[$iii]['STIDR'],$sqlda[$iii]['DTIDR'],$_SESSION['login_id']);
									
									

								// 	$forread = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","DTID","STIDACTIVE","DTIDACTIVE","STIDR","DTIDR","created_by") VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14)';
							
								// $resdata = pg_query_params($db,$forread,$forreadqueryapp);



							$std = explode(',',$sqlda[$iii]['STIDR']);
							$dtd = explode(',',$sqlda[$iii]['DTIDR']);
							
							$forread1=array();
							$forread=array();
							for($fg=0;$fg<count($std);$fg++)
									{

							//  $forread1 =array($nonfull[$j],$comestr,$nonfull[$j],$retdata['docids'],$retdata['comefromcheck'],$frcomment1,'MAIN',$nonfullst[$j],$nonfull[$j],$nonfullst[$j],$nonfull[$j],$std[$fg],$dtd[$fg],$_SESSION['login_id']);

							//  $insertforread1 = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","DTID","STIDACTIVE","DTIDACTIVE","STIDR","DTIDR","created_by") VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14)';


							// pg_query_params($db,$insertforread1,$forread1);

							$forreadqueryapp =array($full[$j],$retdata['action'][$j],$retdata['newnamem'][0],$retdata['docids'],$retdata['comefromcheck'],$frcomment,$retdata['clickpopup'],$fullST[$j],$full[$j],$retdata['statenew'][0],$retdata['newnamem'][0],$std[$fg],$dtd[$fg],$_SESSION['login_id']);
									
									$forreaddata = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","DTID","STIDACTIVE","DTIDACTIVE","STIDR","DTIDR","created_by") VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14)';
						
								pg_query_params($db,$forreaddata,$forreadqueryapp);

		 						}


							}



								// 	$std = explode(',',$sqlda['STIDR']);
								// 	$dtd = explode(',',$sqlda['DTIDR']);
								// // 	$sdd = explode(',',$sqlda['SDIDR']);
								// 	$forreadqueryapp=array();
								// 	for($fg=0;$fg<count($std);$fg++)
								// 	{
								// // 			$forread=array();

								// // $forread = array($finaldata['namefrom'][0],$finaldata['action'][0],$idsof,$finaldata['docids'],$finaldata['comefromcheck'],$frcomment,'Create',$finaldata['fromstate'][0],$finaldata['districtget'][0],$finaldata['namefrom'][0],$finaldata['statenew'][$j],$finaldata['districtnew'][$j],$idsof,$std[$fg],$dtd[$fg],$sdd[$fg],$_SESSION['login_id']);
										
								// // 		 $insertforread = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","DTID","SDID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","STIDR","DTIDR","SDIDR","created_by") VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14,$15,$16,$17)';

								// // 		$result = pg_query_params($db,$insertforread,$forread);


								// 			$forreadqueryapp =array($full[$j],$retdata['action'][$j],$retdata['newnamem'][0],$retdata['docids'],$retdata['comefromcheck'],$frcomment,$retdata['clickpopup'],$fullST[$j],$full[$j],$retdata['statenew'][0],$retdata['newnamem'][0],$std[$fg],$dtd[$fg],$_SESSION['login_id']);
									
								// 	$forreaddata = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","DTID","STIDACTIVE","DTIDACTIVE","STIDR","DTIDR","created_by") VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14)';
						
								// pg_query_params($db,$forreaddata,$forreadqueryapp);

									
								// 	}
								


								// 	$forreadqueryapp =array($full[$j],$retdata['action'][$j],$retdata['newnamem'][0],$retdata['docids'],$retdata['comefromcheck'],$frcomment,$retdata['clickpopup'],$fullST[$j],$full[$j],$retdata['statenew'][0],$retdata['newnamem'][0],$sqlda['STIDR'],$sqlda['DTIDR'],$_SESSION['login_id']);
									
								// 	$forreaddata = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","DTID","STIDACTIVE","DTIDACTIVE","STIDR","DTIDR","created_by") VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14)';
						
								// pg_query_params($db,$forreaddata,$forreadqueryapp);

						}

						
						// $forreadqueryappqu = rtrim($forreadqueryapp, ',');

						$insertlink = 'insert into documentlink'.$_SESSION['activeyears'].' (docids,linkstids,linkdtids) VALUES ($1,$2,$3)';	
							$resultas = pg_query_params($db,$insertlink,array($retdata['docids'],$retdata['statenew'][0],$retdata['newnamem'][0]));
						
						
						


						$stateremove = 'update dt'.$_SESSION['activeyears'].' set is_deleted=$1 where dt'.$_SESSION['activeyears'].'."DTID" = Any(string_to_array($2::text, \',\'::text)::integer[])';
					
						$sdupdate = 'update sd'.$_SESSION['activeyears'].' set "STID"=$1,"DTID"=$2 where "DTID" = Any(string_to_array($3::text, \',\'::text)::integer[])';
						$vtupdate = 'update vt'.$_SESSION['activeyears'].' set "STID"=$1,"DTID"=$2 where "DTID" = Any(string_to_array($3::text, \',\'::text)::bigint[])';

							pg_query_params($db,$stateremove,array(0,implode(',',$full)));
							pg_query_params($db,$sdupdate,array($retdata['statenew'][0],$retdata['newnamem'][0],implode(',',$full)));
							pg_query_params($db,$vtupdate,array($retdata['statenew'][0],$retdata['newnamem'][0],implode(',',$full)));

							$arrr=array();
							$arrr=array($retdata['newnamem'][0],1);
							

						//  $finalquerysd = 'insert into forreaddata2021 ("frfromids","frfromaction","frtoids","frdocids","frcomefrom",
						// "frcomment","is_final","comeaction","STID","DTID","SDID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","STIDR","DTIDR","SDIDR","created_by")
						// (select sd21."DTIDR"::NUMERIC as "frfromids"
						//  ,(select "frfromaction" from forreaddata2021 where "frtoids"=$1 AND frfromaction=\'Merge\' ORDER BY "frids" DESC LIMIT 1) as "frfromaction"
						//  ,sd21."DTID" as "frtoids"
						//  ,(select "frdocids" from forreaddata2021 where "frtoids"=$1 AND frfromaction=\'Merge\' ORDER BY "frids" DESC LIMIT 1) as "frdocids"
						//  ,(select "frcomefrom" from forreaddata2021 where "frtoids"=$1 AND frfromaction=\'Merge\' ORDER BY "frids" DESC LIMIT 1) as "frcomefrom"
						//  ,(select "frcomment" from forreaddata2021 where "frtoids"=$1 AND frfromaction=\'Merge\' ORDER BY "frids" DESC LIMIT 1) as "frcomment"
						//  ,(select "is_final" from forreaddata2021 where "frtoids"=$1 AND frfromaction=\'Merge\' ORDER BY "frids" DESC LIMIT 1) as "is_final"
						//  ,(select "comeaction" from forreaddata2021 where "frtoids"=$1 AND frfromaction=\'Merge\' ORDER BY "frids" DESC LIMIT 1) as "comeaction"
						//  ,sd21."STIDR"::integer AS "STIDR11",sd21."DTIDR"::integer AS "DTIDR11",sd21."SDIDR"::BIGINT AS "SDIDR11",sd21."STID",sd21."DTID"
						//  ,sd21."SDID",sd21."STIDR"::integer,sd21."DTIDR"::integer,sd21."SDIDR"::BIGINT
						//  ,(select "created_by" from forreaddata2021 where "frtoids"=$1 AND frfromaction=\'Merge\' ORDER BY "frids" DESC LIMIT 1) as "created_by" from sd2021 as sd21 
						// INNER JOIN (select * from forreaddata2021 where "frtoids"=$1 AND frfromaction=\'Merge\' AND "SDID"=0) as fr21 ON fr21."frtoids"=sd21."DTID" and fr21."frfromids"::text=sd21."DTIDR" 
						// where sd21."DTID"=$1 AND sd21."is_deleted"=$2
						// )';
						//  pg_query_params($db,$finalquerysd,$arrr);

						// $finalqueryvt = 'insert into forreaddata2021 ("frfromids","frfromaction","frtoids","frdocids","frcomefrom",
						// "frcomment","is_final","comeaction","STID","DTID","SDID","VTID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE","STIDR","DTIDR","SDIDR","VTIDR","created_by")
						// (
						// select vt21."DTIDR"::integer as "frfromids"
						//  ,(select "frfromaction" from forreaddata2021 where "frtoids"=$1 AND frfromaction =\'Merge\'  AND "SDID"!=0 ORDER BY "frids" DESC LIMIT 1) as "frfromaction"
						//  ,vt21."DTID" as "frtoids"
						//  ,(select "frdocids" from forreaddata2021 where "frtoids"=$1 AND frfromaction =\'Merge\'  AND "SDID"!=0 ORDER BY "frids" DESC LIMIT 1) as "frdocids"
						//  ,(select "frcomefrom" from forreaddata2021 where "frtoids"=$1 AND frfromaction =\'Merge\'  AND "SDID"!=0 ORDER BY "frids" DESC LIMIT 1) as "frcomefrom"
						//  ,(select "frcomment" from forreaddata2021 where "frtoids"=$1 AND frfromaction =\'Merge\'  AND "SDID"!=0 ORDER BY "frids" DESC LIMIT 1) as "frcomment"
						//  ,(select "is_final" from forreaddata2021 where "frtoids"=$1 AND frfromaction =\'Merge\'  AND "SDID"!=0 ORDER BY "frids" DESC LIMIT 1) as "is_final"
						//  ,(select "comeaction" from forreaddata2021 where "frtoids"=$1 AND frfromaction =\'Merge\'  AND "SDID"!=0 ORDER BY "frids" DESC LIMIT 1) as "comeaction"
						//  ,vt21."STIDR"::integer AS "STIDR11",vt21."DTIDR"::integer AS "DTIDR11",vt21."SDIDR"::BIGINT AS "SDIDR11",vt21."VTIDR"::NUMERIC AS "VTIDR11"
						//  ,vt21."STID",vt21."DTID",vt21."SDID",vt21."VTID",vt21."STIDR"::integer,vt21."DTIDR"::integer,vt21."SDIDR"::BIGINT,vt21."VTIDR"::NUMERIC
						//  ,(select "created_by" from forreaddata2021 where "frtoids"=$1 AND frfromaction =\'Merge\'  AND "SDID"!=0 ORDER BY "frids" DESC LIMIT 1) as "created_by" from vt2021 as vt21
						// INNER JOIN (select * from forreaddata2021 where "frtoids"=$1 AND frfromaction =\'Merge\'  AND "SDID"=0) as fr21 ON fr21."frtoids"=vt21."DTID" and fr21."frfromids"::text=vt21."DTIDR" 
						// where vt21."DTID"=$1 AND vt21."is_deleted"=$2
						// )';
						// pg_query_params($db,$finalqueryvt,$arrr);

							$qq='';
							$qq1='';
							// if($retdata['newnamecheck'][0]=='')
							// {
							// 	$qq=' AND sd21."DTIDR"::integer!=$1 ';
							// 	$qq1=' AND vt21."DTIDR"::bigint!=$1 ';
							// }

						 $finalquerysd = '
						insert into forreaddata2021 ("SDID","frfromids","frfromaction","frtoids","frdocids","frcomefrom",
						"frcomment","is_final","comeaction","STID","DTID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","STIDR","DTIDR","SDIDR","created_by")
						(
						select DISTINCT(unnest(string_to_array(sd21."SDIDR", \',\'))::BIGINT) AS "SDIDR11",unnest(string_to_array(sd21."DTIDR", \',\'))::NUMERIC as "frfromids"
						 ,(select "frfromaction" from forreaddata2021 where "frtoids"=$1 AND comeaction=\'Merge\' ORDER BY "frids" DESC LIMIT 1) as "frfromaction"
						 ,sd21."DTID" as "frtoids"
						 ,(select "frdocids" from forreaddata2021 where "frtoids"=$1 AND comeaction=\'Merge\' ORDER BY "frids" DESC LIMIT 1) as "frdocids"
						 ,(select "frcomefrom" from forreaddata2021 where "frtoids"=$1 AND comeaction=\'Merge\' ORDER BY "frids" DESC LIMIT 1) as "frcomefrom"
						 ,(select "frcomment" from forreaddata2021 where "frtoids"=$1 AND comeaction=\'Merge\' ORDER BY "frids" DESC LIMIT 1) as "frcomment"
						 ,(select "is_final" from forreaddata2021 where "frtoids"=$1 AND comeaction=\'Merge\' ORDER BY "frids" DESC LIMIT 1) as "is_final"
						 ,(select "comeaction" from forreaddata2021 where "frtoids"=$1 AND comeaction=\'Merge\' ORDER BY "frids" DESC LIMIT 1) as "comeaction"
						 ,unnest(string_to_array(sd21."STIDR", \',\'))::integer AS "STIDR11",unnest(string_to_array(sd21."DTIDR", \',\'))::integer AS "DTIDR11",sd21."STID",sd21."DTID"
						 ,sd21."SDID",unnest(string_to_array(sd21."STIDR", \',\'))::integer,unnest(string_to_array(sd21."DTIDR", \',\'))::integer,unnest(string_to_array(sd21."SDIDR", \',\'))::BIGINT
						 ,(select "created_by" from forreaddata2021 where "frtoids"=$1 AND comeaction =\'Merge\' ORDER BY "frids" DESC LIMIT 1) as "created_by" from sd2021 as sd21 
						LEFT JOIN (select * from forreaddata2021 where "frtoids"=$1 AND comeaction=\'Merge\'  ORDER BY "frids" DESC) as fr21 ON fr21."frtoids"=sd21."DTID" 
							 
						where sd21."DTID"=$1 '.$qq.' AND sd21."is_deleted"=$2 and fr21."frfromids" = Any(string_to_array(sd21."DTIDR"::text, \',\'::text)::NUMERIC[]) 
						)';
						  pg_query_params($db,$finalquerysd,$arrr);

						$finalqueryvt = 'insert into forreaddata2021 ("frfromids","frfromaction","frtoids","frdocids","frcomefrom",
						"frcomment","is_final","comeaction","STID","DTID","SDID","VTID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE","STIDR","DTIDR","SDIDR","VTIDR","created_by")
						(
						select unnest(string_to_array(vt21."DTIDR", \',\')) ::NUMERIC as "frfromids"
						 ,(select "frfromaction" from forreaddata2021 where "frtoids"=$1 AND comeaction =\'Merge\'  AND "SDID"!=0 ORDER BY "frids" DESC LIMIT 1) as "frfromaction"
						 ,vt21."DTID" as "frtoids"
						 ,(select "frdocids" from forreaddata2021 where "frtoids"=$1 AND comeaction =\'Merge\'  AND "SDID"!=0 ORDER BY "frids" DESC LIMIT 1) as "frdocids"
						 ,(select "frcomefrom" from forreaddata2021 where "frtoids"=$1 AND comeaction =\'Merge\'  AND "SDID"!=0 ORDER BY "frids" DESC LIMIT 1) as "frcomefrom"
						 ,(select "frcomment" from forreaddata2021 where "frtoids"=$1 AND comeaction =\'Merge\'  AND "SDID"!=0 ORDER BY "frids" DESC LIMIT 1) as "frcomment"
						 ,(select "is_final" from forreaddata2021 where "frtoids"=$1 AND comeaction =\'Merge\'  AND "SDID"!=0 ORDER BY "frids" DESC LIMIT 1) as "is_final"
						 ,(select "comeaction" from forreaddata2021 where "frtoids"=$1 AND comeaction =\'Merge\'  AND "SDID"!=0 ORDER BY "frids" DESC LIMIT 1) as "comeaction"
						 ,unnest(string_to_array(vt21."STIDR", \',\')) ::integer AS "STIDR11",unnest(string_to_array(vt21."DTIDR", \',\')) ::integer AS "DTIDR11",unnest(string_to_array(vt21."SDIDR", \',\'))::BIGINT AS "SDIDR11",unnest(string_to_array(vt21."VTIDR", \',\'))::NUMERIC AS "VTIDR11"
						 ,vt21."STID",vt21."DTID",vt21."SDID",vt21."VTID",unnest(string_to_array(vt21."STIDR", \',\')) ::integer,unnest(string_to_array(vt21."DTIDR", \',\'))::integer,unnest(string_to_array(vt21."SDIDR", \',\'))::BIGINT,unnest(string_to_array(vt21."VTIDR", \',\'))::NUMERIC
						 ,(select "created_by" from forreaddata2021 where "frtoids"=$1 AND comeaction =\'Merge\'  AND "SDID"!=0 ORDER BY "frids" DESC LIMIT 1) as "created_by" from vt2021 as vt21
						LEFT JOIN (select * from forreaddata2021 where "frtoids"=$1 AND comeaction =\'Merge\'  AND "SDID"=0 ORDER BY "frids" DESC) as fr21 ON fr21."frtoids"=vt21."DTID"  
						where vt21."DTID"=$1 '.$qq1.' AND vt21."is_deleted"=$2 and fr21."frfromids" = Any(string_to_array(vt21."DTIDR"::text, \',\'::text)::NUMERIC[]) 
						)';
						  pg_query_params($db,$finalqueryvt,$arrr);


				

					
				}
				// print_r($nonfull1);
				// print_r($k);
				// exit;
					
				//By sahana Partially merge district one to one, many to one 0111
				$auflag_query = 'SELECT auflag FROM unit WHERE auaction = $1 AND aulevel = $2';
				$actions = $retdata['action'];
				$namefrom_values = $retdata['namefrom'];
				$newnamem_values = $retdata['newnamem'];

				foreach ($actions as $key => $action) {
					$namefrom = $namefrom_values[$key];
					// $newnamem = $newnamem_values[0];

					$au = pg_query_params($db, $auflag_query, array($action, $retdata['comefromcheck']));

					if ($au) {
						$row = pg_fetch_assoc($au);
						$auflag_value = $row['auflag'];

						// $update_vt = pg_query_params($db, 'UPDATE vt'.$_SESSION['activeyears'].' SET "auflag" = $1, "auaction" = $2 WHERE "DTID" = $3 OR "DTID" = $4', array($auflag_value, $action, $namefrom, $newnamem));
						$update_vt = pg_query_params($db, 'UPDATE vt'.$_SESSION['activeyears'].' SET "auflag" = $1, "auaction" = $2 WHERE "DTID" = $3', array($auflag_value, $action, $namefrom));
						$update_sd = pg_query_params($db, 'UPDATE sd'.$_SESSION['activeyears'].' SET "auflag" = $1, "auaction" = $2 WHERE "DTID" = $3', array($auflag_value, $action, $namefrom));
						$update_dt = pg_query_params($db, 'UPDATE dt'.$_SESSION['activeyears'].' SET "auflag" = $1, "auaction" = $2 WHERE "DTID" = $3', array($auflag_value, $action, $namefrom));

						if (!$update_dt || !$update_sd || !$update_vt) {
							echo "UPDATE query failed: " . pg_last_error($db);
						}
					} else {
						echo "SELECT query failed: " . pg_last_error($db);
					}
				}

					$linkDTarray = array();
					$forread = '';
					$forread1 = '';
					$partiallylevel='';
					for($j=0;$j<count($k);$j++)
					{


					if(isset($finaldata['addlinksDTID'.$k[$j].'']))
					{

					if(isset($finaldata['partiallylevel'.$k[$j].'']))
					{
							$havep = true;

							for($a=0;$a<count($finaldata['partiallylevel'.$k[$j].'']);$a++)
								{
									//$partiallylevel .="('".$retdata['comefromcheck']."',".$nonfull[$j].",'".$comestr."',".$retdata['newnamem'][0].",".$retdata['docids'].",".$finaldata['partiallylevel'.$k[$j].''][$a].")," ;
									$partiallylevel .="('".$retdata['comefromcheck']."',".$nonfull[$j].",'".$comestr."',".$retdata['newnamem'][0].",".$retdata['docids'].",".$finaldata['partiallylevel'.$k[$j].''][$a].",".$retdata['fromstate'][0].",".$nonfull[$j].")," ; //12122023
								}



						$finaldata['addlinksDTID'.$k[$j].''] = array_diff($finaldata['addlinksDTID'.$k[$j].''],$finaldata['partiallylevel'.$k[$j].'']);
					}

						$linkDTarray=array_merge($linkDTarray,$finaldata['addlinksDTID'.$k[$j].'']);	 		
					}
						
					$frcomment='';
					$frcomment1='';

					$frcomment .='<strong style="color:#aa81f3;"><u>State/UT:</u></strong> '.$statenewarray[0].';';
					$frcomment1 .='<strong style="color:#aa81f3;"><u>State/UT:</u></strong> '.$statenewarrayfrom[$k[$j]].';';
					
					if($retdata['newnamecheck'][0]!='')
					{

					$frcomment .=' <strong style="color:Green;"><u>District:</u></strong> '.$nonfull1[$j].' '.$comestr.'d into '.$retdata['nametotext'].' and '.$retdata['nametotext'].' Name Changed to '.htmlspecialchars($retdata['newnamecheck'][0]).';';

					$frcomment1 .=' <strong style="color:Green;"><u>District:</u></strong> '.$nonfull1[$j].' '.$comestr.'d into '.$retdata['nametotext'].' and '.$retdata['nametotext'].' Name Changed to '.htmlspecialchars($retdata['newnamecheck'][0]).';';
					}
					else
					{
					$frcomment .=' <strong style="color:Green;"><u>District:</u></strong> '.$nonfull1[$j].' '.$comestr.'d into '.$retdata['nametotext'].';';

					$frcomment1 .=' <strong style="color:Green;"><u>District:</u></strong> '.$nonfull1[$j].' '.$comestr.'d into '.$retdata['nametotext'].';';
					}

					$frcomment .=' <strong style="color:blue;"><u>Sub District:</u></strong> - ; <strong style="color:#45b0e2;"><u>Town:</u></strong> - ; <strong style="color:#15bed2;"><u>Village:</u></strong> - ;';

					$frcomment1 .=' <strong style="color:blue;"><u>Sub District:</u></strong> - ; <strong style="color:#45b0e2;"><u>Town:</u></strong> - ; <strong style="color:#15bed2;"><u>Village:</u></strong> - ;';

					
					$sqlo='Select "STIDR","DTIDR" from dt'.$_SESSION['activeyears'].' WHERE "STID"=$1 AND "DTID"=$2';
					// AND is_deleted=$3
					$sqlold = pg_query_params($db,$sqlo,array($nonfullst[$j],$nonfull[$j]));
					$sqlda = pg_fetch_all($sqlold);
					for($iii=0;$iii<count($sqlda);$iii++)
					{
							//print_r($sqlda);
				// 	$forreadqueryapp =array($finaldata['namefrom'][$j],$finaldata['action'][$j],$finaldata['newnamem'][0],$finaldata['docids'],$finaldata['comefromcheck'],$frcomment,$_POST['clickbutton'],$finaldata['fromstate'][$j],$finaldata['namefrom'][$j],$finaldata['statenew'][0],$finaldata['newnamem'][0],$sqlda[$iii]['STIDR'],$sqlda[$iii]['DTIDR'],$_SESSION['login_id']);
					
					

				// 	$forread = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","DTID","STIDACTIVE","DTIDACTIVE","STIDR","DTIDR","created_by") VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14)';
			
				// $resdata = pg_query_params($db,$forread,$forreadqueryapp);



				$std = explode(',',$sqlda[$iii]['STIDR']);
					$dtd = explode(',',$sqlda[$iii]['DTIDR']);
					
					$forread1=array();
					$forread=array();
					for($fg=0;$fg<count($std);$fg++)
							{

					 $forread1 =array($nonfull[$j],$comestr,$nonfull[$j],$retdata['docids'],$retdata['comefromcheck'],$frcomment1,'MAIN',$nonfullst[$j],$nonfull[$j],$nonfullst[$j],$nonfull[$j],$std[$fg],$dtd[$fg],$_SESSION['login_id']);

					 $insertforread1 = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","DTID","STIDACTIVE","DTIDACTIVE","STIDR","DTIDR","created_by") VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14)';


					pg_query_params($db,$insertforread1,$forread1);

					 $forread = array($nonfull[$j],$comestr,$retdata['newnamem'][0],$retdata['docids'],$retdata['comefromcheck'],$frcomment,$comestr,$nonfullst[$j],$nonfull[$j],$retdata['statenew'][0],$retdata['newnamem'][0],$std[$fg],$dtd[$fg],$_SESSION['login_id']);

					 	

					 $insertforread = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","DTID","STIDACTIVE","DTIDACTIVE","STIDR","DTIDR","created_by") VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14)';
	

 					pg_query_params($db,$insertforread,$forread);

 						}


					}



					

					}
					// $forreadqueryappend = rtrim($forread, ',');
					// $forreadqueryappend1 = rtrim($forread1, ',');
					if(count($linkDTarray)>0)
					{
					for($l=0;$l<count($linkDTarray);$l++)
					{
					$linkdt =array($retdata['docids'],$retdata['statenew'][0],$retdata['newnamem'][0],$linkDTarray[$l]);
					
					
					$insertlinkdt = 'insert into documentlink'.$_SESSION['activeyears'].' (docids,linkstids,linkdtids,linksdids) VALUES ($1,$2,$3,$4)';	
					$resultdt = pg_query_params($db,$insertlinkdt,$linkdt);
					}

					}
					


			 	

					


					// pg_query('update dt'.$_SESSION['activeyears'].' set "STID"='.$retdata['newnamem'][0].' where dt'.$_SESSION['activeyears'].'."DTID" IN ('.implode(',',$linkDTarray).')');
					
					// JJJJJ
					$aaa=array($retdata['statenew'][0],$retdata['newnamem'][0],implode(",",$linkDTarray));
					$aaa1=array($retdata['statenew'][0],$retdata['newnamem'][0],implode(",",$linkDTarray));

					// print_r($aaa);
					$dataq='update sd'.$_SESSION['activeyears'].' set "STID"=$1,"DTID"=$2 where sd'.$_SESSION['activeyears'].'."SDID" = Any(string_to_array($3::text, \',\'::text)::bigint[])';
					pg_query_params($db,$dataq,$aaa);

					$vtq='update vt'.$_SESSION['activeyears'].' set "STID"=$1,"DTID"=$2 where vt'.$_SESSION['activeyears'].'."SDID" = Any(string_to_array($3::text, \',\'::text)::bigint[])';
					pg_query_params($db,$vtq,$aaa1);

					// pg_query('update wd'.$_SESSION['activeyears'].' set "STID"='.$retdata['statenew'][0].',"DTID"='.$retdata['newnamem'][0].' where wd'.$_SESSION['activeyears'].'."SDID" IN ('.implode(',',$linkDTarray).')');

					if($partiallylevel!='')
					{

					$partiallylevelquery = rtrim($partiallylevel, ',');


					pg_query("insert into partiallydata".$_SESSION['activeyears']." (comefrom,fromids,comeaction,toids,docids,partiallydataids,stid,dtid) VALUES ".$partiallylevelquery." ");  // 12122023
					}

					if($finaldata['partiallyids']!='')
					{


					pg_query_params($db,'update partiallydata'.$_SESSION['activeyears'].' set "pstatus"=$1 where partiallyids=$2',array(1,$finaldata['partiallyids']));	
					}

					$sql_da = pg_query_params($db,'select * from partiallydata'.$_SESSION['activeyears'].' where docids=$1 AND pstatus=$2',array($retdata['docids'],0));
					if(pg_numrows($sql_da)==0)
					{
					pg_query_params($db,'update documentdata'.$_SESSION['activeyears'].' set docstatus=$1 where docids=$2',array(1,$retdata['docids']));

					}
					else
					{
						pg_query_params('update documentdata'.$_SESSION['activeyears'].' set docstatus=$1 where docids=$2',array(2,$retdata['docids']));
					}

					if($retdata['oremovenewarray']==1)
						{

						 $stnameupdate = "update dt".$_SESSION['activeyears']." set \"DTName\"=$1 where \"DTID\"=$2";		

						pg_query_params($db,$stnameupdate,array(($retdata['newnamecheck'][0]),$retdata['newnamem'][0]));	
						}

 						// SWAMI JIGAR
					
							$ar=array();
							$ar=array($retdata['newnamem'][0],1,$comestr);
							$ar1=array();
							$ar1=array($retdata['newnamem'][0],1,$comestr);
					
						 	
							$quuuu='';
					// 		if($retdata['newnamecheck'][0]=='')
					// {
					// 	$quuuu=' AND "frfromids" is not null';
					// }
							
					   $finalquerysd = ' insert into forreaddata2021 ("frfromids","frfromaction","frtoids","frdocids","frcomefrom",
						"frcomment","is_final","comeaction","STID","DTID","SDID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","STIDR","DTIDR","SDIDR","created_by")
						(select unnest(string_to_array(sd21."DTIDR", \',\'))::NUMERIC AS "frfromids",
						(select "frfromaction" from forreaddata2021 where "frtoids"=$1 AND comeaction =$3 ORDER BY "frids" DESC LIMIT 1) AS "frfromaction",
						 sd21."DTID" AS "frtoids",
						(select "frdocids" from forreaddata2021 where "frtoids"=$1 AND comeaction =$3 ORDER BY "frids" DESC LIMIT 1) AS "frdocids",
						(select "frcomefrom" from forreaddata2021 where "frtoids"=$1 AND comeaction =$3 ORDER BY "frids" DESC LIMIT 1) AS "frcomefrom",
						(select "frcomment" from forreaddata2021 where "frtoids"=$1 AND fr21."DTID"=forreaddata2021."DTID" AND comeaction =$3 ORDER BY "frids" DESC LIMIT 1) AS "frcomment",
						(select "is_final" from forreaddata2021 where "frtoids"=$1 AND comeaction =$3 ORDER BY "frids" DESC LIMIT 1) AS "is_final",
						 (select "comeaction" from forreaddata2021 where "frtoids"=$1 AND comeaction =$3 ORDER BY "frids" DESC LIMIT 1) AS "comeaction",
						 unnest(string_to_array(sd21."STIDR", \',\')) ::integer AS "STIDR11",
						 unnest(string_to_array(sd21."DTIDR", \',\'))::integer AS "DTIDR11",
						 unnest(string_to_array(sd21."SDIDR", \',\'))::BIGINT AS "SDIDR11",
						 sd21."STID",sd21."DTID",sd21."SDID",
						 unnest(string_to_array(sd21."STIDR", \',\')) ::integer AS "STIDR",
						 unnest(string_to_array(sd21."DTIDR", \',\'))::integer AS "DTIDR",
						 unnest(string_to_array(sd21."SDIDR", \',\'))::BIGINT AS "SDIDR",
						(select "created_by" from forreaddata2021 where "frtoids"=$1 AND comeaction =$3 ORDER BY "frids" DESC LIMIT 1) AS "created_by"
						 from sd2021 as sd21 
						LEFT JOIN (select * from forreaddata2021 where "frtoids"=$1 AND comeaction =$3 AND "SDID"=0 ORDER BY "frids" DESC) as fr21 ON fr21."frtoids"=sd21."DTID" 
						where sd21."DTID"=$1 AND sd21."is_deleted"=$2 and fr21."frfromids"= Any(string_to_array(sd21."DTIDR"::text, \',\'::text)::NUMERIC[]) '.$quuuu.'
						)';
						   pg_query_params($db,$finalquerysd,$ar);

					  $finalqueryvt = 'insert into forreaddata2021 ("frfromids","frfromaction","frtoids","frdocids","frcomefrom",
						"frcomment","is_final","comeaction","STID","DTID","SDID","VTID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE","STIDR","DTIDR","SDIDR","VTIDR","created_by")
						(select unnest(string_to_array(vt21."DTIDR", \',\'))::NUMERIC AS "frfromids",
						(select "frfromaction" from forreaddata2021 where "frtoids"=$1 AND comeaction =$3 ORDER BY "frids" DESC LIMIT 1) AS "frfromaction",
						 vt21."DTID" AS "frtoids",
						(select "frdocids" from forreaddata2021 where "frtoids"=$1 AND comeaction =$3 ORDER BY "frids" DESC LIMIT 1) AS "frdocids",
						(select "frcomefrom" from forreaddata2021 where "frtoids"=$1 AND comeaction =$3 ORDER BY "frids" DESC LIMIT 1) AS "frcomefrom",
						(select "frcomment" from forreaddata2021 where "frtoids"=$1 AND fr21."DTID"=forreaddata2021."DTID" AND comeaction =$3 ORDER BY "frids" DESC LIMIT 1) AS "frcomment",
						(select "is_final" from forreaddata2021 where "frtoids"=$1 AND comeaction =$3 ORDER BY "frids" DESC LIMIT 1) AS "is_final",
						 (select "comeaction" from forreaddata2021 where "frtoids"=$1 AND comeaction =$3 ORDER BY "frids" DESC LIMIT 1) AS "comeaction",
						 unnest(string_to_array(vt21."STIDR", \',\')) ::BIGINT AS "STIDR11",
						 unnest(string_to_array(vt21."DTIDR", \',\'))::BIGINT AS "DTIDR11",
						 unnest(string_to_array(vt21."SDIDR", \',\'))::BIGINT AS "SDIDR11",
						 unnest(string_to_array(vt21."VTIDR", \',\'))::NUMERIC AS "VTIDR11",
						 vt21."STID",vt21."DTID",vt21."SDID",vt21."VTID",
						 unnest(string_to_array(vt21."STIDR", \',\')) ::BIGINT AS "STIDR",
						 unnest(string_to_array(vt21."DTIDR", \',\'))::BIGINT AS "DTIDR",
						 unnest(string_to_array(vt21."SDIDR", \',\'))::BIGINT AS "SDIDR",
						 unnest(string_to_array(vt21."VTIDR", \',\'))::NUMERIC AS "VTIDR",
						(select "created_by" from forreaddata2021 where "frtoids"=$1 AND comeaction =$3 ORDER BY "frids" DESC LIMIT 1) AS "created_by"
						 from vt2021 as vt21 
						LEFT JOIN (select * from forreaddata2021 where "frtoids"=$1 AND comeaction =$3 AND "SDID"=0 ORDER BY "frids" DESC) as fr21 ON fr21."frtoids"=vt21."DTID" and fr21."frfromids"::text=vt21."DTIDR" 
						where vt21."DTID"=$1 AND vt21."is_deleted"=$2 and fr21."frfromids" = Any(string_to_array(vt21."DTIDR"::text, \',\'::text)::NUMERIC[]) '.$quuuu.'
						)';
					  pg_query_params($db,$finalqueryvt,$ar1);


						 if($retdata['newnamecheck'][0]!='')
							{
							$arrself=array();
							$arrself=array($retdata['newnamem'][0],1);

						 $selfquery = 'insert into forreaddata2021 ("frfromids","frfromaction","frtoids","frdocids","frcomefrom",
						"frcomment","is_final","comeaction","STID","DTID","SDID","VTID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE","STIDR","DTIDR","SDIDR","VTIDR","created_by")
						(select "frfromids",
						"frfromaction",
						 vt21."DTID" AS "frtoids",
						"frdocids",
						"frcomefrom",
						"frcomment",
						"is_final",
						"comeaction",
						 unnest(string_to_array(vt21."STIDR", \',\')) ::BIGINT AS "STIDR11",
						 unnest(string_to_array(vt21."DTIDR", \',\'))::BIGINT AS "DTIDR11",
						 unnest(string_to_array(vt21."SDIDR", \',\'))::BIGINT AS "SDIDR11",
						 unnest(string_to_array(vt21."VTIDR", \',\'))::NUMERIC AS "VTIDR11",
						 vt21."STID",vt21."DTID",vt21."SDID",vt21."VTID",
						 unnest(string_to_array(vt21."STIDR", \',\')) ::BIGINT AS "STIDR",
						 unnest(string_to_array(vt21."DTIDR", \',\'))::BIGINT AS "DTIDR",
						 unnest(string_to_array(vt21."SDIDR", \',\'))::BIGINT AS "SDIDR",
						 unnest(string_to_array(vt21."VTIDR", \',\'))::NUMERIC AS "VTIDR",
						 "created_by"
						 from vt2021 as vt21 
						INNER JOIN (select * from forreaddata2021 where "frtoids"=$1  AND "SDID"=0 ORDER BY "frids" DESC) as fr21 ON fr21."frtoids"=vt21."DTID" 
						 and fr21."frtoids" = Any(string_to_array(vt21."DTIDR"::text, \',\'::text)::NUMERIC[])  
						 
						where vt21."DTID"=$1 AND vt21."is_deleted"=$2 
						)';
						  pg_query_params($db,$selfquery,$arrself);

					   }

				
					$task = "mergedone";
				
							
			}
			else
			{
				//By sahana merge district level one to one, many to one 0111
				$auflag_query = 'SELECT auflag FROM unit WHERE auaction = $1 AND aulevel = $2';
				$actions = $finaldata['action'];
				$namefrom_values = $finaldata['namefrom'];
				// $newnamem_values = $finaldata['newnamem'];

				foreach ($actions as $key => $action) {
					$namefrom = $namefrom_values[$key];
					// $newnamem = $newnamem_values[0];

					$au = pg_query_params($db, $auflag_query, array($action, $finaldata['comefromcheck']));

					if ($au) {
						$row = pg_fetch_assoc($au);
						$auflag_value = $row['auflag'];

						// $update_vt = pg_query_params($db, 'UPDATE vt'.$_SESSION['activeyears'].' SET "auflag" = $1, "auaction" = $2 WHERE "DTID" = $3 OR "DTID" = $4', array($auflag_value, $action, $namefrom, $newnamem));
						$update_vt = pg_query_params($db, 'UPDATE vt'.$_SESSION['activeyears'].' SET "auflag" = $1, "auaction" = $2 WHERE "DTID" = $3', array($auflag_value, $action, $namefrom));
						$update_sd = pg_query_params($db, 'UPDATE sd'.$_SESSION['activeyears'].' SET "auflag" = $1, "auaction" = $2 WHERE "DTID" = $3', array($auflag_value, $action, $namefrom));
						$update_dt = pg_query_params($db, 'UPDATE dt'.$_SESSION['activeyears'].' SET "auflag" = $1, "auaction" = $2 WHERE "DTID" = $3', array($auflag_value, $action, $namefrom));

						if (!$update_dt || !$update_sd || !$update_vt) {
							echo "UPDATE query failed: " . pg_last_error($db);
						}
					} else {
						echo "SELECT query failed: " . pg_last_error($db);
					}
				}

				if(isset($finaldata['statenewarray']))
				{
				$statenewarray = explode(',',$finaldata['statenewarray']);
				}


				$forreadqueryapp ='';
				for($j=0;$j<count($finaldata['namefrom']);$j++)
				{

					$frcomment='';
					$frcomment .='<strong style="color:#aa81f3;"><u>State/UT:</u></strong> '.$statenewarray[0].';';


					if($finaldata['newnamecheck'][0]!='')
					{

					$frcomment .=' <strong style="color:Green;"><u>District:</u></strong> '.$finaldata['namefromtext'].' '.$finaldata['action'][$j].'d into '.$finaldata['nametotext'].' and '.$finaldata['nametotext'].' Name Changed to '.htmlspecialchars($finaldata['newnamecheck'][0]).';';
					}
					else
					{
					$frcomment .=' <strong style="color:Green;"><u>District:</u></strong> '.$finaldata['namefromtext'].' '.$finaldata['action'][$j].'d into '.$finaldata['nametotext'].';';
					}

					$frcomment .=' <strong style="color:blue;"><u>Sub District:</u></strong> - ; <strong style="color:#45b0e2;"><u>Town:</u></strong> - ; <strong style="color:#15bed2;"><u>Village:</u></strong> - ;';


					 $sqlo='Select "STIDR","DTIDR" from dt'.$_SESSION['activeyears'].' WHERE "STID"=$1 AND "DTID"=$2';
					// AND is_deleted=$3
					$sqlold = pg_query_params($db,$sqlo,array($finaldata['fromstate'][$j],$finaldata['namefrom'][$j]));
					$sqlda = pg_fetch_all($sqlold);
					for($iii=0;$iii<count($sqlda);$iii++)
					{
							//print_r($sqlda);
					$forreadqueryapp =array($finaldata['namefrom'][$j],$finaldata['action'][$j],$finaldata['newnamem'][0],$finaldata['docids'],$finaldata['comefromcheck'],$frcomment,$_POST['clickbutton'],$finaldata['fromstate'][$j],$finaldata['namefrom'][$j],$finaldata['statenew'][0],$finaldata['newnamem'][0],$sqlda[$iii]['STIDR'],$sqlda[$iii]['DTIDR'],$_SESSION['login_id']);
					
					

					$forread = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","DTID","STIDACTIVE","DTIDACTIVE","STIDR","DTIDR","created_by") VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14)';
			
				$resdata = pg_query_params($db,$forread,$forreadqueryapp);

					}
				

				}

				// print_r($forreadqueryapp);
				// 	exit;
				// 	$forreadqueryappqu = rtrim($forreadqueryapp, ',');
				
			  	$result_rows = pg_affected_rows($resdata);
				if($result_rows!=0)
				{
						$linkk='';

						$linkarray = $finaldata['namefrom'];
						$linkarray1 = $finaldata['fromstate'];
						
						$arrayof=array_merge($linkarray,$finaldata['newnamem']);
						$arrayof1=array_merge($linkarray1,$finaldata['statenew']);
						

						for($i=0;$i<count($arrayof);$i++)
						{
						$linkk =array($finaldata['docids'],$linkarray1[$i],$arrayof[$i]);
						$linkdata = "insert into documentlink".$_SESSION['activeyears']." (docids,linkstids,linkdtids) VALUES ($1,$2,$3)";
						pg_query_params($db,$linkdata,$linkk);
						}
						// $linkk_final = rtrim($linkk, ',');
						

				
						$documentdata = "update documentdata".$_SESSION['activeyears']." set docstatus=$1 where \"docids\"=$2";

						$updatDT = 'update dt'.$_SESSION['activeyears'].' set is_deleted=$1 where dt'.$_SESSION['activeyears'].'."DTID" = Any(string_to_array($2::text, \',\'::text)::integer[])';

						pg_query_params($db,$updatDT,array(0,implode(',',$finaldata['namefrom'])));

						 $arr=array($finaldata['statenew'][0],$finaldata['newnamem'][0],implode(',',$finaldata['namefrom']));
						
						 $sdupdate = 'update sd'.$_SESSION['activeyears'].' set "STID"=$1,"DTID"=$2 where sd'.$_SESSION['activeyears'].'."DTID" = Any(string_to_array($3::text, \',\'::text)::integer[])';
						 $vtupdate = 'update vt'.$_SESSION['activeyears'].' set "STID"=$1,"DTID"=$2 where vt'.$_SESSION['activeyears'].'."DTID" = Any(string_to_array($3::text, \',\'::text)::bigint[])';

						 // $wdupdate = 'update wd'.$_SESSION['activeyears'].' set "STID"='.$finaldata['statenew'][0].',"DTID"='.$finaldata['newnamem'][0].' where "DTID" IN ('.implode(',',$finaldata['namefrom']).')';


						pg_query_params($db,$documentdata,array(1,$finaldata['docids']));
						
						
						 pg_query_params($db,$sdupdate,$arr);
						 pg_query_params($db,$vtupdate,$arr);
						
						if($finaldata['oremovenewarray']==1)
						{
						 $stnameupdate = "update dt".$_SESSION['activeyears']." set \"DTName\"=$1 where \"DTID\"=$2";		

						pg_query_params($db,$stnameupdate,array(($finaldata['newnamecheck'][0]),$finaldata['newnamem'][0]));	
						}



						 $dtupdate = 'update dt'.$_SESSION['activeyears'].' set "STID"=$1,"DTID"=$2 where "DTID" = Any(string_to_array($3::text, \',\'::text)::integer[])';
						pg_query_params($db,$dtupdate,array($finaldata['statenew'][0],$finaldata['newnamem'][0],implode(',',$finaldata['namefrom'])));

						


						// print_r($ard);
						
						
							$ard=array();
						$ard=array($finaldata['newnamem'][0],1);
						//print_r($ard);
						//print_r($finaldata);
						$quu='';
						$quu1='';
						if($finaldata['newnamecheck'][0]=='')
						{

						$quu =' AND sd21."DTIDR"::integer!=$1 ';
						$quu1 =' AND vt21."DTIDR"::bigint!=$1 ';
						}

						 $finalquerysd = '
						insert into forreaddata2021 ("SDID","frfromids","frfromaction","frtoids","frdocids","frcomefrom",
						"frcomment","is_final","comeaction","STID","DTID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","STIDR","DTIDR","SDIDR","created_by")
						(
						select DISTINCT(unnest(string_to_array(sd21."SDIDR", \',\'))::BIGINT) AS "SDIDR11",unnest(string_to_array(sd21."DTIDR", \',\'))::NUMERIC as "frfromids"
						 ,(select "frfromaction" from forreaddata2021 where "frtoids"=$1 AND frfromaction=\'Merge\' ORDER BY "frids" DESC LIMIT 1) as "frfromaction"
						 ,sd21."DTID" as "frtoids"
						 ,(select "frdocids" from forreaddata2021 where "frtoids"=$1 AND frfromaction=\'Merge\' ORDER BY "frids" DESC LIMIT 1) as "frdocids"
						 ,(select "frcomefrom" from forreaddata2021 where "frtoids"=$1 AND frfromaction=\'Merge\' ORDER BY "frids" DESC LIMIT 1) as "frcomefrom"
						 ,(select "frcomment" from forreaddata2021 where "frtoids"=$1 AND frfromaction=\'Merge\' ORDER BY "frids" DESC LIMIT 1) as "frcomment"
						 ,(select "is_final" from forreaddata2021 where "frtoids"=$1 AND frfromaction=\'Merge\' ORDER BY "frids" DESC LIMIT 1) as "is_final"
						 ,(select "comeaction" from forreaddata2021 where "frtoids"=$1 AND frfromaction=\'Merge\' ORDER BY "frids" DESC LIMIT 1) as "comeaction"
						 ,unnest(string_to_array(sd21."STIDR", \',\'))::integer AS "STIDR11",unnest(string_to_array(sd21."DTIDR", \',\'))::integer AS "DTIDR11",sd21."STID",sd21."DTID"
						 ,sd21."SDID",unnest(string_to_array(sd21."STIDR", \',\'))::integer,unnest(string_to_array(sd21."DTIDR", \',\'))::integer,unnest(string_to_array(sd21."SDIDR", \',\'))::BIGINT
						 ,(select "created_by" from forreaddata2021 where "frtoids"=$1 AND frfromaction =\'Merge\' ORDER BY "frids" DESC LIMIT 1) as "created_by" from sd2021 as sd21 
						LEFT JOIN (select * from forreaddata2021 where "frtoids"=$1 AND frfromaction=\'Merge\'  ORDER BY "frids" DESC) as fr21 ON fr21."frtoids"=sd21."DTID" 
							and fr21."frfromids" = Any(string_to_array(sd21."DTIDR"::text, \',\'::text)::NUMERIC[])  
						where sd21."DTID"=$1 '.$quu.' AND sd21."is_deleted"=$2
						)';
						 pg_query_params($db,$finalquerysd,$ard);

						$finalqueryvt = 'insert into forreaddata2021 ("frfromids","frfromaction","frtoids","frdocids","frcomefrom",
						"frcomment","is_final","comeaction","STID","DTID","SDID","VTID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE","STIDR","DTIDR","SDIDR","VTIDR","created_by")
						(
						select unnest(string_to_array(vt21."DTIDR", \',\')) ::NUMERIC as "frfromids"
						 ,(select "frfromaction" from forreaddata2021 where "frtoids"=$1 AND frfromaction =\'Merge\'  AND "SDID"!=0 ORDER BY "frids" DESC LIMIT 1) as "frfromaction"
						 ,vt21."DTID" as "frtoids"
						 ,(select "frdocids" from forreaddata2021 where "frtoids"=$1 AND frfromaction =\'Merge\'  AND "SDID"!=0 ORDER BY "frids" DESC LIMIT 1) as "frdocids"
						 ,(select "frcomefrom" from forreaddata2021 where "frtoids"=$1 AND frfromaction =\'Merge\'  AND "SDID"!=0 ORDER BY "frids" DESC LIMIT 1) as "frcomefrom"
						 ,(select "frcomment" from forreaddata2021 where "frtoids"=$1 AND frfromaction =\'Merge\'  AND "SDID"!=0 ORDER BY "frids" DESC LIMIT 1) as "frcomment"
						 ,(select "is_final" from forreaddata2021 where "frtoids"=$1 AND frfromaction =\'Merge\'  AND "SDID"!=0 ORDER BY "frids" DESC LIMIT 1) as "is_final"
						 ,(select "comeaction" from forreaddata2021 where "frtoids"=$1 AND frfromaction =\'Merge\'  AND "SDID"!=0 ORDER BY "frids" DESC LIMIT 1) as "comeaction"
						 ,unnest(string_to_array(vt21."STIDR", \',\')) ::integer AS "STIDR11",unnest(string_to_array(vt21."DTIDR", \',\')) ::integer AS "DTIDR11",unnest(string_to_array(vt21."SDIDR", \',\'))::BIGINT AS "SDIDR11",unnest(string_to_array(vt21."VTIDR", \',\'))::NUMERIC AS "VTIDR11"
						 ,vt21."STID",vt21."DTID",vt21."SDID",vt21."VTID",unnest(string_to_array(vt21."STIDR", \',\')) ::integer,unnest(string_to_array(vt21."DTIDR", \',\'))::integer,unnest(string_to_array(vt21."SDIDR", \',\'))::BIGINT,unnest(string_to_array(vt21."VTIDR", \',\'))::NUMERIC
						 ,(select "created_by" from forreaddata2021 where "frtoids"=$1 AND frfromaction =\'Merge\'  AND "SDID"!=0 ORDER BY "frids" DESC LIMIT 1) as "created_by" from vt2021 as vt21
						LEFT JOIN (select * from forreaddata2021 where "frtoids"=$1 AND frfromaction =\'Merge\'  AND "SDID"=0 ORDER BY "frids" DESC) as fr21 ON fr21."frtoids"=vt21."DTID" and fr21."frfromids" = Any(string_to_array(vt21."DTIDR"::text, \',\'::text)::NUMERIC[])  
						where vt21."DTID"=$1 '.$quu1.' AND vt21."is_deleted"=$2
						)';
						 pg_query_params($db,$finalqueryvt,$ard);

					   
						


						$task = "mergedone";

				}
				else
				{
				$task = "error";
				}
			}
		}
		else if($finaldata['comefromcheck']=='Sub-District')
		{

			if(isset($finaldata['returndata']) && $finaldata['returndata']!='')
			{


				$retdata =  (array) json_decode($finaldata['returndata']);
				// print_r($finaldata);
				// print_r($retdata);
				// exit;



				if(isset($retdata['statenewarray']))
				{
				$statenewarray = explode(',',$retdata['statenewarray']);
				}

				if(isset($retdata['districtnewarray']))
				{
				$districtnewarray = explode(',',$retdata['districtnewarray']);
				}


					if(isset($retdata['statenewarrayfrom']))
							{
							$statenewarrayfrom = explode(',',$retdata['statenewarrayfrom']);
							}

							if(isset($retdata['districtnewarrayfrom']))
							{
							$districtnewarrayfrom = explode(',',$retdata['districtnewarrayfrom']);
							}



					$comestr='';
					if($retdata['clickpopup']=='Partiallysm')
					{
							$comestr='Partially Split & Merge';
					}
					else
					{
							$comestr='Partially Merge';

					}

				$k = array_keys($retdata['action'],$comestr);

				$nonfull = $retdata['namefrom'];
				$nonfullst = $retdata['fromstate'];
				$nonfulldt = $retdata['districtget'];
				$nonfull1 = explode(',',$retdata['namefromtext']);
				$full=[];
				$fullname=[];
				$fullST=[];
				$fullDT=[];

				foreach($nonfull as $key => $val)
				{
				if(array_search($key,$k) === false)
				{

				$full[]=$nonfull[$key];
				$fullname[]=$nonfull1[$key];
				$fullST[]=$nonfullst[$key];
				$fullDT[]=$nonfulldt[$key];
				unset($nonfull[$key]);
				unset($nonfull1[$key]);
				unset($nonfullst[$key]);
				unset($nonfulldt[$key]);
				
				}
				
				}

				$nonfull = array_values($nonfull);
				$nonfull1 = array_values($nonfull1);
				$nonfullst = array_values($nonfullst);
				$nonfulldt = array_values($nonfulldt);

				// print_r($nonfull);
				// exit;

				if(count($full)!=0)
				{




						$forreadqueryapp ='';

						for($j=0;$j<count($full);$j++)
						{
							// print_r($retdata['action'][$j]);


								$frcomment='';
								$frcomment .='<strong style="color:#aa81f3;"><u>State/UT:</u></strong> '.$statenewarray[0].'; <strong style="color:Green;"><u>District:</u></strong> '.$districtnewarray[0].'; ';

							if($retdata['newnamecheck'][0]!='')
							{

							$frcomment .='<strong style="color:blue;"><u>Sub District:</u></strong> '.$fullname[$j].' Merged into '.$retdata['nametotext'].' and '.$retdata['nametotext'].' Name Changed to '.$retdata['newnamecheck'][0].';';
							}
							else
							{
							$frcomment .='<strong style="color:blue;"><u>Sub District:</u></strong> '.$fullname[$j].' Merged into '.$retdata['nametotext'].';';
							}
								$frcomment .=' <strong style="color:#45b0e2;"><u>Town:</u></strong> - ; <strong style="color:#15bed2;"><u>Village:</u></strong> - ;';


							$sqlo='Select "STIDR","DTIDR","SDIDR" from sd'.$_SESSION['activeyears'].' WHERE "STID"=$1 AND "DTID"=$2 AND "SDID"=$3';
							$sqlold = pg_query_params($db,$sqlo,array($fullST[$j],$fullDT[$j],$full[$j]));
							// $sqlda = pg_fetch_array($sqlold);


							// $forreadqueryapp =array($full[$j],$retdata['action'][$j],$retdata['newnamem'][0],$retdata['docids'],$retdata['comefromcheck'],$frcomment,$retdata['clickpopup'],$fullST[$j],$fullDT[$j],$full[$j],$retdata['statenew'][0],$retdata['districtget'][0],$retdata['newnamem'][0],$sqlda['STIDR'],$sqlda['DTIDR'],$sqlda['SDIDR'],$_SESSION['login_id']);
							// $forreaddata123 = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","DTID","SDID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","STIDR","DTIDR","SDIDR","created_by") VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14,$15,$16,$17)';
							// 	pg_query_params($db,$forreaddata123,$forreadqueryapp);


							$sqlda = pg_fetch_all($sqlold);
							// print_r($sqlda);
							for($gh=0;$gh<count($sqlda);$gh++)
							{



							$std = explode(',',$sqlda[$gh]['STIDR']);
							$dtd = explode(',',$sqlda[$gh]['DTIDR']);
							$sdd = explode(',',$sqlda[$gh]['SDIDR']);

							for($aa=0;$aa<count($std);$aa++)
							{
							$forreadqueryapp = array($full[$j],$retdata['action'][$j],$retdata['newnamem'][0],$retdata['docids'],$retdata['comefromcheck'],$frcomment,$retdata['clickpopup'],$fullST[$j],$fullDT[$j],$full[$j],$retdata['statenew'][0],$retdata['districtget'][0],$retdata['newnamem'][0],$std[$aa],$dtd[$aa],$sdd[$aa],$_SESSION['login_id']);

							$forread = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","DTID","SDID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","STIDR","DTIDR","SDIDR","created_by") VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14,$15,$16,$17)';
							$resdata = pg_query_params($db,$forread,$forreadqueryapp);	

							}


							}


						}

						
						// $forreadqueryappqu = rtrim($forreadqueryapp, ',');



						$insertlink = 'insert into documentlink'.$_SESSION['activeyears'].' (docids,linkstids,linkdtids,linksdids) VALUES ($1,$2,$3,$4)';	
						$resultas = pg_query_params($db,$insertlink,array($retdata['docids'],$retdata['statenew'][0],$retdata['districtnew'][0],$retdata['newnamem'][0]));

						

						$stateremove = 'update sd'.$_SESSION['activeyears'].' set is_deleted=$1 where sd'.$_SESSION['activeyears'].'."SDID" = Any(string_to_array($2::text, \',\'::text)::bigint[])';
						
						pg_query_params($db,$stateremove,array(0,implode(",",$full)));
						

						$vtupdate = 'update vt'.$_SESSION['activeyears'].' set "STID"=$1,"DTID"=$2,"SDID"=$3 where vt'.$_SESSION['activeyears'].'."SDID" = Any(string_to_array($4::text, \',\'::text)::bigint[])';

					
		
						pg_query_params($db,$vtupdate,array($retdata['statenew'][0],$retdata['districtnew'][0],$retdata['newnamem'][0],implode(",",$full)));

					

					
						//  $finalqueryvt = 'insert into forreaddata2021 ("frfromids","frfromaction","frtoids","frdocids","frcomefrom",
						// "frcomment","is_final","comeaction","STID","DTID","SDID","VTID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE","STIDR","DTIDR","SDIDR","VTIDR","created_by")
						// (select "frfromids","frfromaction","frtoids","frdocids","frcomefrom",
						// "frcomment","is_final","comeaction",vt21."STIDR"::integer AS "STIDR11",vt21."DTIDR"::integer AS "DTIDR11",vt21."SDIDR"::BIGINT AS "SDIDR11",vt21."VTIDR"::NUMERIC AS "VTIDR11",vt21."STID",vt21."DTID",vt21."SDID",vt21."VTID",vt21."STIDR"::integer,vt21."DTIDR"::integer,vt21."SDIDR"::BIGINT,vt21."VTIDR"::NUMERIC,"created_by" from vt2021 as vt21 
						// LEFT JOIN (select * from forreaddata2021 where "frtoids"=$1 AND frfromaction=\'Merge\' AND "SDID"!=0 ORDER BY "frids" DESC) as fr21 ON fr21."frtoids"=vt21."SDID" and fr21."frfromids"::text=vt21."SDIDR" 
						// where vt21."SDID"=$1 AND vt21."is_deleted"=$2 AND frfromids is not null
						// )';
						$qq='';
						// if($retdata['newnamecheck'][0]=='')
						// 	{
						// 		$qq=' AND vt21."SDIDR"::bigint!=$1 ';
						// 	}

						$finalqueryvt = 'insert into forreaddata2021 ("VTID","frfromids","frfromaction","frtoids","frdocids","frcomefrom",
						"frcomment","is_final","comeaction","STID","DTID","SDID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE","STIDR","DTIDR","SDIDR","VTIDR","created_by")
						(select DISTINCT(vt21."VTIDR"::NUMERIC) AS "VTIDR11",
						 vt21."SDIDR"::bigint as "frfromids",
						 (select "frfromaction" from forreaddata2021 where "frtoids"=$1 AND comeaction =\'Merge\'  AND "VTID"=$3 ORDER BY "frids" DESC LIMIT 1) as "frfromaction",
						 vt21."SDID" as "frtoids",
						 (select "frdocids" from forreaddata2021 where "frtoids"=$1 AND comeaction =\'Merge\'  AND "VTID"=$3 ORDER BY "frids" DESC LIMIT 1) as "frdocids",
						 (select "frcomefrom" from forreaddata2021 where "frtoids"=$1 AND comeaction =\'Merge\'  AND "VTID"=$3 ORDER BY "frids" DESC LIMIT 1) as "frcomefrom",
						(select "frcomment" from forreaddata2021 where "frtoids"=$1 AND comeaction =\'Merge\'  AND "VTID"=$3 ORDER BY "frids" DESC LIMIT 1) as "frcomment",
						(select "is_final" from forreaddata2021 where "frtoids"=$1 AND comeaction =\'Merge\'  AND "VTID"=$3 ORDER BY "frids" DESC LIMIT 1) as "is_final",
						 (select "comeaction" from forreaddata2021 where "frtoids"=$1 AND comeaction =\'Merge\'  AND "VTID"=$3 ORDER BY "frids" DESC LIMIT 1) as "comeaction",
						 vt21."STIDR"::integer AS "STIDR11",
						 vt21."DTIDR"::integer AS "DTIDR11",
						 vt21."SDIDR"::BIGINT AS "SDIDR11",
						 vt21."STID",
						 vt21."DTID",
						 vt21."SDID",
						 vt21."VTID",
						 vt21."STIDR"::integer,
						 vt21."DTIDR"::integer,
						 vt21."SDIDR"::BIGINT,
						 vt21."VTIDR"::NUMERIC,
						 (select "created_by" from forreaddata2021 where "frtoids"=$1 AND comeaction =\'Merge\'  AND "VTID"=$3 ORDER BY "frids" DESC LIMIT 1) as "created_by"
						 from vt2021 as vt21
						LEFT JOIN (select * from forreaddata2021 where "frtoids"=$1 AND comeaction=\'Merge\' AND "SDID"!=0 AND "VTID"=$3 ORDER BY "frids" DESC) as fr21 ON fr21."frtoids"=vt21."SDID"
						where vt21."SDID"=$1 '.$qq.' AND vt21."is_deleted"=$2 and fr21."frfromids" = Any(string_to_array(vt21."SDIDR"::text, \',\'::text)::NUMERIC[]) 
						)';

						pg_query_params($db,$finalqueryvt,array($retdata['newnamem'][0],1,0));

						

				}
			
				

				
					$linkDTarray = array();
					$forread = '';
					$forread1 = '';
					for($j=0;$j<count($k);$j++)
					{


							if(isset($finaldata['addlinksDTID'.$k[$j].'']))
							{

							if(isset($finaldata['partiallylevel'.$k[$j].'']))
							{
									$havep = true;

									for($a=0;$a<count($finaldata['partiallylevel'.$k[$j].'']);$a++)
										{
											// modified by gowthami village partially
											//$partiallylevel .="('".$retdata['comefromcheck']."',".$nonfull[$j].",'Partially Merge',".$retdata['newnamem'][0].",".$retdata['docids'].",".$finaldata['partiallylevel'.$k[$j].''][$a].")," ;
											$partiallylevel .="('".$retdata['comefromcheck']."',".$nonfull[$j].",'Partially Merge',".$retdata['newnamem'][0].",".$retdata['docids'].",".$finaldata['partiallylevel'.$k[$j].''][$a].",".$retdata['fromstate'][0].",".$retdata['districtget'][0].")," ;
										}



								$finaldata['addlinksDTID'.$k[$j].''] = array_diff($finaldata['addlinksDTID'.$k[$j].''],$finaldata['partiallylevel'.$k[$j].'']);
							}

								$linkDTarray=array_merge($linkDTarray,$finaldata['addlinksDTID'.$k[$j].'']);	 		
							}




							$frcomment='';
							$frcomment1='';

					
							$frcomment .='<strong style="color:#aa81f3;"><u>State/UT:</u></strong> '.$statenewarray[0].'; <strong style="color:Green;"><u>District:</u></strong> '.$districtnewarray[0].'; ';
							$frcomment1 .='<strong style="color:#aa81f3;"><u>State/UT:</u></strong> '.$statenewarrayfrom[$k[$j]].'; <strong style="color:Green;"><u>District:</u></strong> '.$districtnewarrayfrom[$k[$j]].'; ';

							if($retdata['newnamecheck'][0]!='')
							{

							$frcomment .='<strong style="color:blue;"><u>Sub District:</u></strong> '.$nonfull1[$j].' '.$comestr.'d into '.$retdata['nametotext'].' and '.$retdata['nametotext'].' Name Changed to '.$retdata['newnamecheck'][0].';';

							$frcomment1 .='<strong style="color:blue;"><u>Sub District:</u></strong> '.$nonfull1[$j].' '.$comestr.'d into '.$retdata['nametotext'].' and '.$retdata['nametotext'].' Name Changed to '.$retdata['newnamecheck'][0].';';
							}
							else
							{
							$frcomment .='<strong style="color:blue;"><u>Sub District:</u></strong> '.$nonfull1[$j].' '.$comestr.'d into '.$retdata['nametotext'].';';

							$frcomment1 .='<strong style="color:blue;"><u>Sub District:</u></strong> '.$nonfull1[$j].' '.$comestr.'d into '.$retdata['nametotext'].';';
							}

								$frcomment .=' <strong style="color:#45b0e2;"><u>Town:</u></strong> - ; <strong style="color:#15bed2;"><u>Village:</u></strong> - ;';

								$frcomment1 .=' <strong style="color:#45b0e2;"><u>Town:</u></strong> - ; <strong style="color:#15bed2;"><u>Village:</u></strong> - ;';



							 $sqlo='Select "STIDR","DTIDR","SDIDR" from sd'.$_SESSION['activeyears'].' WHERE "STID"=$1 AND "DTID"=$2 AND "SDID"=$3';

							$sqlold = pg_query_params($db,$sqlo,array($nonfullst[$j],$nonfulldt[$j],$nonfull[$j]));
							$sqlda = pg_fetch_array($sqlold);


							$forread = array($nonfull[$j],$comestr,$retdata['newnamem'][0],$retdata['docids'],$retdata['comefromcheck'],$frcomment,$comestr,$nonfullst[$j],$nonfulldt[$j],$nonfull[$j],$retdata['statenew'][0],$retdata['districtnew'][0],$retdata['newnamem'][0],$sqlda['STIDR'],$sqlda['DTIDR'],$sqlda['SDIDR'],$_SESSION['login_id']);

							 $forread1 =array($nonfull[$j],$comestr,$nonfull[$j],$retdata['docids'],$retdata['comefromcheck'],$frcomment1,'MAIN',$nonfullst[$j],$nonfulldt[$j],$nonfull[$j],$nonfullst[$j],$nonfulldt[$j],$nonfull[$j],$sqlda['STIDR'],$sqlda['DTIDR'],$sqlda['SDIDR'],$_SESSION['login_id']);

								$insertforread1 = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","DTID","SDID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","STIDR","DTIDR","SDIDR","created_by") VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14,$15,$16,$17)';


										pg_query_params($db,$insertforread1,$forread1);

							 $insertforread = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","DTID","SDID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","STIDR","DTIDR","SDIDR","created_by") VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14,$15,$16,$17)';
			

		 					pg_query_params($db,$insertforread,$forread);

					 ////// 

					// $forread .= "(".$nonfull[$j].",'Partially Merge',".$retdata['newnamem'][0].",".$retdata['docids'].",'".$retdata['comefromcheck']."','Partially Merge'),";

					// $forread1 .= "(".$nonfull[$j].",'Partially Merge',".$nonfull[$j].",".$retdata['docids'].",'".$retdata['comefromcheck']."','MAIN'),";

					}

					if(count($linkDTarray)>0)
					{
					for($l=0;$l<count($linkDTarray);$l++)
					{
					
					$linkdt =array($retdata['docids'],$retdata['statenew'][0],$retdata['districtnew'][0],$retdata['newnamem'][0],$linkDTarray[$l]);
					
					
					$insertlinkdt = 'insert into documentlink'.$_SESSION['activeyears'].' (docids,linkstids,linkdtids,linksdids,linkvtids) VALUES ($1,$2,$3,$4,$5)';	
					$resultdt = pg_query_params($db,$insertlinkdt,$linkdt);
					}

					}
					

					//By sahana partially merge subdistrict one to one, many to one 0111
					$auflag_query = 'SELECT auflag FROM unit WHERE auaction = $1 AND aulevel = $2';
					$actions = $retdata['action'];
					$namefrom_values = $retdata['namefrom'];
					$newnamem_values = $retdata['newnamem'];

					foreach ($actions as $key => $action) {
						$namefrom = $namefrom_values[$key];
						$newnamem = $newnamem_values[0];

						$au = pg_query_params($db, $auflag_query, array($action, $retdata['comefromcheck']));

						if ($au) {
							$row = pg_fetch_assoc($au);
							$auflag_value = $row['auflag'];

							$update_vt = pg_query_params($db, 'UPDATE vt'.$_SESSION['activeyears'].' SET "auflag" = $1, "auaction" = $2 WHERE "SDID" = $3 OR "SDID" = $4', array($auflag_value, $action, $namefrom, $newnamem));
							$update_sd = pg_query_params($db, 'UPDATE sd'.$_SESSION['activeyears'].' SET "auflag" = $1, "auaction" = $2 WHERE "SDID" = $3 OR "SDID" = $4', array($auflag_value, $action, $namefrom, $newnamem));

							if (!$update_sd || !$update_vt) {
								echo "UPDATE query failed: " . pg_last_error($db);
							}
						} else {
							echo "SELECT query failed: " . pg_last_error($db);
						}
					}

					

					// pg_query('update dt'.$_SESSION['activeyears'].' set "STID"='.$retdata['newnamem'][0].' where dt'.$_SESSION['activeyears'].'."DTID" IN ('.implode(',',$linkDTarray).')');

					// pg_query('update sd'.$_SESSION['activeyears'].' set "STID"='.$retdata['statenew'][0].' AND "DTID"='.$retdata['newnamem'][0].' where sd'.$_SESSION['activeyears'].'."SDID" IN ('.implode(',',$linkDTarray).')');
					$arr=array($retdata['statenew'][0],$retdata['districtnew'][0],$retdata['newnamem'][0],implode(",",$linkDTarray));
					pg_query_params($db,'update vt'.$_SESSION['activeyears'].' set "STID"=$1,"DTID"=$2,"SDID"=$3 where vt'.$_SESSION['activeyears'].'."VTID" = Any(string_to_array($4::text, \',\'::text)::NUMERIC[])',$arr);

					
					if($partiallylevel!='')
					{

					$partiallylevelquery = rtrim($partiallylevel, ',');


					//pg_query("insert into partiallydata".$_SESSION['activeyears']." (comefrom,fromids,comeaction,toids,docids,partiallydataids) VALUES ".$partiallylevelquery." ");
					pg_query("insert into partiallydata".$_SESSION['activeyears']." (comefrom,fromids,comeaction,toids,docids,partiallydataids,stid,dtid) VALUES ".$partiallylevelquery." ");   //12122023
				}

					if($finaldata['partiallyids']!='')
					{


					pg_query_params($db,'update partiallydata'.$_SESSION['activeyears'].' set "pstatus"=$1 where partiallyids=$2',array(1,$finaldata['partiallyids']));	
					}

					$sql_da = pg_query_params($db,'select * from partiallydata'.$_SESSION['activeyears'].' where docids=$1 AND pstatus=$2',array($retdata['docids'],0));
					if(pg_numrows($sql_da)==0)
					{
					pg_query_params($db,'update documentdata'.$_SESSION['activeyears'].' set docstatus=$1 where docids=$2',array(1,$retdata['docids']));

					}
					else
					{
						pg_query_params($db,'update documentdata'.$_SESSION['activeyears'].' set docstatus=$1 where docids=$2',array(2,$retdata['docids']));
					}


					if($retdata['oremovenewarray']==1)
					{
					$stnameupdate = "update sd".$_SESSION['activeyears']." set \"SDName\"=$1 where \"SDID\"=$2";		

					pg_query_params($db,$stnameupdate,array($retdata['newnamecheck'][0],$retdata['newnamem'][0]));	
					}
					$aaaa=array($retdata['newnamem'][0],1,$comestr);
					// print_r($aaaa);
					// $finalqueryvt = 'insert into forreaddata2021 ("frfromids","frfromaction","frtoids","frdocids","frcomefrom",
					// 	"frcomment","is_final","comeaction","STID","DTID","SDID","VTID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE","STIDR","DTIDR","SDIDR","VTIDR","created_by")
					// 	(select "frfromids","frfromaction","frtoids","frdocids","frcomefrom",
					// 	"frcomment","is_final","comeaction",vt21."STIDR"::integer AS "STIDR11",vt21."DTIDR"::integer AS "DTIDR11",vt21."SDIDR"::BIGINT AS "SDIDR11",vt21."VTIDR"::NUMERIC AS "VTIDR11",vt21."STID",vt21."DTID",vt21."SDID",vt21."VTID",vt21."STIDR"::integer,vt21."DTIDR"::integer,vt21."SDIDR"::BIGINT,vt21."VTIDR"::NUMERIC,"created_by" from vt2021 as vt21
					// 	LEFT JOIN (select * from forreaddata2021 where "frtoids"=$1 AND frfromaction =$3  ORDER BY "frids" DESC) as fr21 ON fr21."frtoids"=vt21."SDID" and fr21."frfromids"::text=vt21."SDIDR" 
					// 	where vt21."SDID"=$1 AND vt21."is_deleted"=$2 AND "frfromids" is not null
					// 	)';
					$quuuu='';
					// if($retdata['newnamecheck'][0]=='')
					// {
					// 	$quuuu=' AND "frfromids" is not null';
					// }
					$finalqueryvt = 'insert into forreaddata2021 ("frfromids","frfromaction","frtoids","frdocids","frcomefrom",
						"frcomment","is_final","comeaction","STID","DTID","SDID","VTID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE","STIDR","DTIDR","SDIDR","VTIDR","created_by")
						(select unnest(string_to_array(vt21."SDIDR", \',\'))::NUMERIC AS "frfromids",
						(select "frfromaction" from forreaddata2021 where "frtoids"=$1 AND frfromaction =$3 AND comeaction =$3 ORDER BY "frids" DESC LIMIT 1) AS "frfromaction",
						 vt21."SDID" AS "frtoids",
						(select "frdocids" from forreaddata2021 where "frtoids"=$1 AND frfromaction =$3 AND comeaction =$3 ORDER BY "frids" DESC LIMIT 1) AS "frdocids",
						(select "frcomefrom" from forreaddata2021 where "frtoids"=$1 AND frfromaction =$3 AND comeaction =$3 ORDER BY "frids" DESC LIMIT 1) AS "frcomefrom",
						(select "frcomment" from forreaddata2021 where "frtoids"=$1 AND fr21."DTID"=forreaddata2021."DTID" AND frfromaction =$3 AND comeaction =$3 ORDER BY "frids" DESC LIMIT 1) AS "frcomment",
						(select "is_final" from forreaddata2021 where "frtoids"=$1 AND frfromaction =$3 AND comeaction =$3 ORDER BY "frids" DESC LIMIT 1) AS "is_final",
						 (select "comeaction" from forreaddata2021 where "frtoids"=$1 AND frfromaction =$3 AND comeaction =$3 ORDER BY "frids" DESC LIMIT 1) AS "comeaction",
						 unnest(string_to_array(vt21."STIDR", \',\')) ::BIGINT AS "STIDR11",
						 unnest(string_to_array(vt21."DTIDR", \',\'))::BIGINT AS "DTIDR11",
						 unnest(string_to_array(vt21."SDIDR", \',\'))::BIGINT AS "SDIDR11",
						 unnest(string_to_array(vt21."VTIDR", \',\'))::NUMERIC AS "VTIDR11",
						 vt21."STID",vt21."DTID",vt21."SDID",vt21."VTID",
						 unnest(string_to_array(vt21."STIDR", \',\')) ::BIGINT AS "STIDR",
						 unnest(string_to_array(vt21."DTIDR", \',\'))::BIGINT AS "DTIDR",
						 unnest(string_to_array(vt21."SDIDR", \',\'))::BIGINT AS "SDIDR",
						 unnest(string_to_array(vt21."VTIDR", \',\'))::NUMERIC AS "VTIDR",
						(select "created_by" from forreaddata2021 where "frtoids"=$1 AND frfromaction =$3 AND comeaction =$3 ORDER BY "frids" DESC LIMIT 1) AS "created_by"
						 from vt2021 as vt21 
						LEFT JOIN (select * from forreaddata2021 where "frtoids"=$1 AND frfromaction =$3 AND comeaction =$3 AND "SDID"!=0 AND "VTID"=0 ORDER BY "frids" DESC) as fr21 ON fr21."frtoids"=vt21."SDID" 
						where vt21."SDID"=$1 AND vt21."is_deleted"=$2 and fr21."frfromids" = Any(string_to_array(vt21."SDIDR"::text, \',\'::text)::NUMERIC[]) '.$quuuu.'
						)';


						 pg_query_params($db,$finalqueryvt,$aaaa);

						  if($retdata['newnamecheck'][0]!='')
							{
							$arrself=array();
							$arrself=array($retdata['newnamem'][0],1);
							//print_r($arrself);
						 $selfquery = 'insert into forreaddata2021 ("frfromids","frfromaction","frtoids","frdocids","frcomefrom",
						"frcomment","is_final","comeaction","STID","DTID","SDID","VTID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE","STIDR","DTIDR","SDIDR","VTIDR","created_by")
						(select "frfromids",
						"frfromaction",
						 vt21."DTID" AS "frtoids",
						"frdocids",
						"frcomefrom",
						"frcomment",
						"is_final",
						"comeaction",
						 unnest(string_to_array(vt21."STIDR", \',\')) ::BIGINT AS "STIDR11",
						 unnest(string_to_array(vt21."DTIDR", \',\'))::BIGINT AS "DTIDR11",
						 unnest(string_to_array(vt21."SDIDR", \',\'))::BIGINT AS "SDIDR11",
						 unnest(string_to_array(vt21."VTIDR", \',\'))::NUMERIC AS "VTIDR11",
						 vt21."STID",vt21."DTID",vt21."SDID",vt21."VTID",
						 unnest(string_to_array(vt21."STIDR", \',\')) ::BIGINT AS "STIDR",
						 unnest(string_to_array(vt21."DTIDR", \',\'))::BIGINT AS "DTIDR",
						 unnest(string_to_array(vt21."SDIDR", \',\'))::BIGINT AS "SDIDR",
						 unnest(string_to_array(vt21."VTIDR", \',\'))::NUMERIC AS "VTIDR",
						 "created_by"
						 from vt2021 as vt21 
						INNER JOIN (select * from forreaddata2021 where "frtoids"=$1 AND "SDID"!=0 AND "VTID"=0 ORDER BY "frids" DESC) as fr21 ON fr21."frtoids"=vt21."SDID" 
						 and fr21."frtoids" = Any(string_to_array(vt21."SDIDR"::text, \',\'::text)::NUMERIC[])  
						 
						where vt21."SDID"=$1 AND vt21."is_deleted"=$2 
						)';
						  pg_query_params($db,$selfquery,$arrself);

					   }


					// JIGAR
					$task = "mergedone";
				
							
			}
			else
			{


				if(isset($finaldata['statenewarray']))
				{
				$statenewarray = explode(',',$finaldata['statenewarray']);
				}
				
				if(isset($finaldata['districtnewarray']))
				{
				$districtnewarray = explode(',',$finaldata['districtnewarray']);
				}


				$forreadqueryapp ='';
				for($j=0;$j<count($finaldata['namefrom']);$j++)
				{
					$frcomment='';		
					$frcomment .='<strong style="color:#aa81f3;"><u>State/UT:</u></strong> '.$statenewarray[0].'; <strong style="color:Green;"><u>District:</u></strong> '.$districtnewarray[0].'; ';
					if($finaldata['newnamecheck'][0]!='')
					{

					$frcomment .='<strong style="color:blue;"><u>Sub District:</u></strong> '.$finaldata['namefromtext'].' '.$finaldata['action'][$j].'d into '.$finaldata['nametotext'].' and '.$finaldata['nametotext'].' Name Changed to '.$finaldata['newnamecheck'][0].';';
					}
					else
					{
					$frcomment .='<strong style="color:blue;"><u>Sub District:</u></strong> '.$finaldata['namefromtext'].' '.$finaldata['action'][$j].'d into '.$finaldata['nametotext'].';';
					}
					$frcomment .=' <strong style="color:#45b0e2;"><u>Town:</u></strong> - ; <strong style="color:#15bed2;"><u>Village:</u></strong> - ;';


				 	 $sqlo='Select "STIDR","DTIDR","SDIDR" from sd'.$_SESSION['activeyears'].' WHERE "STID"=$1 AND "DTID"=$2 AND "SDID"=$3';
						$aah=array($finaldata['fromstate'][$j],$finaldata['districtget'][$j],$finaldata['namefrom'][$j]);
				// 	print_r($aah);
					$sqlold = pg_query_params($db,$sqlo,$aah);
					$sqlda = pg_fetch_all($sqlold);
					// print_r($sqlda);
					for($gh=0;$gh<count($sqlda);$gh++)
					{

						

						$std = explode(',',$sqlda[$gh]['STIDR']);
						$dtd = explode(',',$sqlda[$gh]['DTIDR']);
						$sdd = explode(',',$sqlda[$gh]['SDIDR']);
						
						for($aa=0;$aa<count($std);$aa++)
						{
								$forreadqueryapp =array($finaldata['namefrom'][$j],$finaldata['action'][$j],$finaldata['newnamem'][0],$finaldata['docids'],$finaldata['comefromcheck'],$frcomment,$_POST['clickbutton'],$finaldata['fromstate'][$j],$finaldata['districtget'][$j],$finaldata['namefrom'][$j],$finaldata['statenew'][0],$finaldata['districtnew'][0],$finaldata['newnamem'][0],$std[$aa],$dtd[$aa],$sdd[$aa],$_SESSION['login_id']);
					
								$forread = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","DTID","SDID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","STIDR","DTIDR","SDIDR","created_by") VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14,$15,$16,$17)';
								$resdata = pg_query_params($db,$forread,$forreadqueryapp);	
									
						}

						
					}
					

				}
				
				// $forreadqueryappqu = rtrim($forreadqueryapp, ',');
			
				$result_rows = pg_affected_rows($resdata);
				if($result_rows!=0)
				{

					$linkk='';

					$linkarray = $finaldata['namefrom'];
					$linkarray1 = $finaldata['fromstate'];
					$linkarray2 = $finaldata['districtget'];
					$arrayof=array_merge($linkarray,$finaldata['newnamem']);
					$arrayof1=array_merge($linkarray1,$finaldata['statenew']);
					$arrayof2=array_merge($linkarray2,$finaldata['districtnew']);

					for($i=0;$i<count($arrayof);$i++)
					{
					$linkk =array($finaldata['docids'],$arrayof1[$i],$arrayof2[$i],$arrayof[$i]);
					$linkdata = "insert into documentlink".$_SESSION['activeyears']." (docids,linkstids,linkdtids,linksdids) VALUES ($1,$2,$3,$4)";
					pg_query_params($db,$linkdata,$linkk);

					}
					
					//By sahana merge sub district one to one, many to one 0111
					$auflag_query = 'SELECT auflag FROM unit WHERE auaction = $1 AND aulevel = $2';
					$actions = $finaldata['action'];
					$namefrom_values = $finaldata['namefrom'];

					foreach ($actions as $key => $action) {
						$namefrom = $namefrom_values[$key];
						$au = pg_query_params($db, $auflag_query, array($action, $finaldata['comefromcheck']));

						if ($au) {
							$row = pg_fetch_assoc($au);
							$auflag_value = $row['auflag'];

						$update_vt = pg_query_params($db, 'UPDATE vt'.$_SESSION['activeyears'].' SET "auflag" = $1, "auaction" = $2 WHERE "SDID" = $3', array($auflag_value, $action, $namefrom));
						$update_sd = pg_query_params($db, 'UPDATE sd'.$_SESSION['activeyears'].' SET "auflag" = $1, "auaction" = $2 WHERE "SDID" = $3', array($auflag_value, $action, $namefrom));

						if (!$update_sd || !$update_vt) {
							echo "UPDATE query failed: " . pg_last_error($db);
						}
						} else {
							echo "SELECT query failed: " . pg_last_error($db);
						}
					}

					$documentdata = "update documentdata".$_SESSION['activeyears']." set docstatus=$1 where \"docids\"=$2";

					
					$updatDT = 'update sd'.$_SESSION['activeyears'].' set is_deleted=$1 where sd'.$_SESSION['activeyears'].'."SDID" = Any(string_to_array($2::text, \',\'::text)::bigint[])';
					pg_query_params($db,$updatDT,array(0,implode(",",$finaldata['namefrom'])));

						$arraa=array($finaldata['statenew'][0],$finaldata['districtnew'][0],$finaldata['newnamem'][0],implode(",",$finaldata['namefrom']));
					
					$sdupdate = 'update sd'.$_SESSION['activeyears'].' set "STID"=$1,"DTID"=$2,"SDID"=$3 where sd'.$_SESSION['activeyears'].'."SDID" = Any(string_to_array($4::text, \',\'::text)::bigint[])';

					$vtupdate = 'update vt'.$_SESSION['activeyears'].' set "STID"=$1,"DTID"=$2,"SDID"=$3 where vt'.$_SESSION['activeyears'].'."SDID" = Any(string_to_array($4::text, \',\'::text)::bigint[])';

					



					pg_query_params($db,$documentdata,array(1,$finaldata['docids']));
				
					pg_query_params($db,$sdupdate,$arraa);
					pg_query_params($db,$vtupdate,$arraa);
					
					if($finaldata['oremovenewarray']==1)
					{
					$stnameupdate = "update sd".$_SESSION['activeyears']." set \"SDName\"=$1 where \"SDID\"=$2";		

					pg_query_params($db,$stnameupdate,array($finaldata['newnamecheck'][0],$finaldata['newnamem'][0]));	
					}

						//  echo $finaldata['newnamem'][0];

					 // $finalqueryvt = 'insert into forreaddata2021 ("VTID","frfromids","frfromaction","frtoids","frdocids","frcomefrom",
						// "frcomment","is_final","comeaction","STID","DTID","SDID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE","STIDR","DTIDR","SDIDR","VTIDR","created_by")
						// (select DISTINCT(vt21."VTIDR"::NUMERIC) AS "VTIDR11","frfromids","frfromaction","frtoids","frdocids","frcomefrom",
						// "frcomment","is_final","comeaction",vt21."STIDR"::integer AS "STIDR11",vt21."DTIDR"::integer AS "DTIDR11",vt21."SDIDR"::BIGINT AS "SDIDR11"
						//  ,vt21."STID",vt21."DTID",vt21."SDID",vt21."VTID",vt21."STIDR"::integer,vt21."DTIDR"::integer,vt21."SDIDR"::BIGINT,vt21."VTIDR"::NUMERIC,"created_by"  from vt2021 as vt21
						// LEFT JOIN (select * from forreaddata2021 where "frtoids"=$1 AND frfromaction=\'Merge\' AND "SDID"!=$3 ORDER BY "frids" DESC) as fr21 ON fr21."frtoids"=vt21."SDID" and fr21."frfromids"::text=vt21."SDIDR" 
						// where vt21."SDID"=$1 AND vt21."SDIDR"::bigint!=$1 AND vt21."is_deleted"=$2
						// )';
					$qq='';
						if($finaldata['newnamecheck'][0]=='')
							{
								$qq=' AND vt21."SDIDR"::bigint!=$1 ';
							}

					$finalqueryvt = 'insert into forreaddata2021 ("VTID","frfromids","frfromaction","frtoids","frdocids","frcomefrom",
						"frcomment","is_final","comeaction","STID","DTID","SDID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE","STIDR","DTIDR","SDIDR","VTIDR","created_by")
						(select DISTINCT(vt21."VTIDR"::NUMERIC) AS "VTIDR11",
						 vt21."SDIDR"::bigint as "frfromids",
						 (select "frfromaction" from forreaddata2021 where "frtoids"=$1 AND frfromaction =\'Merge\'  AND "VTID"=$3 ORDER BY "frids" DESC LIMIT 1) as "frfromaction",
						 vt21."SDID" as "frtoids",
						 (select "frdocids" from forreaddata2021 where "frtoids"=$1 AND frfromaction =\'Merge\'  AND "VTID"=$3 ORDER BY "frids" DESC LIMIT 1) as "frdocids",
						 (select "frcomefrom" from forreaddata2021 where "frtoids"=$1 AND frfromaction =\'Merge\'  AND "VTID"=$3 ORDER BY "frids" DESC LIMIT 1) as "frcomefrom",
						(select "frcomment" from forreaddata2021 where "frtoids"=$1 AND frfromaction =\'Merge\'  AND "VTID"=$3 ORDER BY "frids" DESC LIMIT 1) as "frcomment",
						(select "is_final" from forreaddata2021 where "frtoids"=$1 AND frfromaction =\'Merge\'  AND "VTID"=$3 ORDER BY "frids" DESC LIMIT 1) as "is_final",
						 (select "comeaction" from forreaddata2021 where "frtoids"=$1 AND frfromaction =\'Merge\'  AND "VTID"=$3 ORDER BY "frids" DESC LIMIT 1) as "comeaction",
						 vt21."STIDR"::integer AS "STIDR11",
						 vt21."DTIDR"::integer AS "DTIDR11",
						 vt21."SDIDR"::BIGINT AS "SDIDR11",
						 vt21."STID",
						 vt21."DTID",
						 vt21."SDID",
						 vt21."VTID",
						 vt21."STIDR"::integer,
						 vt21."DTIDR"::integer,
						 vt21."SDIDR"::BIGINT,
						 vt21."VTIDR"::NUMERIC,
						 (select "created_by" from forreaddata2021 where "frtoids"=$1 AND frfromaction =\'Merge\'  AND "VTID"=$3 ORDER BY "frids" DESC LIMIT 1) as "created_by"
						 from vt2021 as vt21
						LEFT JOIN (select * from forreaddata2021 where "frtoids"=$1 AND frfromaction=\'Merge\' AND "VTID"=$3 ORDER BY "frids" DESC) as fr21 ON fr21."frtoids"=vt21."SDID" and fr21."frfromids"::text=vt21."SDIDR" 
						where vt21."SDID"=$1 '.$qq.' AND vt21."is_deleted"=$2
						)';




						pg_query_params($db,$finalqueryvt,array($finaldata['newnamem'][0],1,0));
					

				$task = "mergedone";

				}
				else
				{
				$task = "error";
				}
			}
		}
		else if($finaldata['comefromcheck']=='Village / Town')
		{
			
			// print_r($finaldata);
			// exit;
			if($finaldata['clickpopup']=='Partiallysm')
			{	
									
					if(isset($finaldata['statenewarray']))
						{
						$statenewarray = explode(',',$finaldata['statenewarray']);
						}

						if(isset($finaldata['districtnewarray']))
						{
						$districtnewarray = explode(',',$finaldata['districtnewarray']);
						}

						if(isset($finaldata['sddistrictnewarray']))
						{
						$sddistrictnewarray = explode(',',$finaldata['sddistrictnewarray']);
						}


						if(isset($finaldata['statenewarrayfrom']))
							{
							$statenewarrayfrom = explode(',',$finaldata['statenewarrayfrom']);
							}

							if(isset($finaldata['districtnewarrayfrom']))
							{
							$districtnewarrayfrom = explode(',',$finaldata['districtnewarrayfrom']);
							}

							if(isset($finaldata['sddistrictnewarrayfrom']))
							{
							$sddistrictnewarrayfrom = explode(',',$finaldata['sddistrictnewarrayfrom']);
							}



									$comestr='';
									$comestr='Partially Split & Merge';
									

									$k = array_keys($finaldata['action'],$comestr);

									$nonfull = $finaldata['namefrom'];
									$full=[];
									foreach($nonfull as $key => $val)
									{
									if(array_search($key,$k) === false)
									{

									$full[]=$nonfull[$key];
									unset($nonfull[$key]);

									}

									}







									$forreadqueryapp ='';
									//$forreadqueryapp1 ='';
									for($j=0;$j<count($finaldata['namefrom']);$j++)
									{

//15122023

										$sqlo='Select "STIDR","DTIDR","SDIDR","VTIDR","Level","Status","VTName","MDDS_VT" from vt'.$_SESSION['activeyears'].' WHERE "STID"=$1 AND "DTID"=$2 AND "SDID"=$3 AND "VTID"=$4 AND is_deleted=$5';
										$sqlold = pg_query_params($db,$sqlo,array($finaldata['fromstate'][0],$finaldata['districtget'][0],$finaldata['sddistrictget'][0],$finaldata['namefrom'][0],1));
										$sqlda = pg_fetch_array($sqlold);
	
											$frcomment='';
											 $frcomment .='<strong style="color:#aa81f3;"><u>State/UT:</u></strong> '.$statenewarray[0].'; <strong style="color:Green;"><u>District:</u></strong> '.$districtnewarray[0].'; <strong style="color:blue;"><u>Sub District:</u></strong> '.$sddistrictnewarray[0].';';
											
											 $frcomment1='';
											 $frcomment1 .='<strong style="color:#aa81f3;"><u>State/UT:</u></strong> '.$statenewarrayfrom[0].'; <strong style="color:Green;"><u>District:</u></strong> '.$districtnewarrayfrom[0].'; <strong style="color:blue;"><u>Sub District:</u></strong> '.$sddistrictnewarrayfrom[0].';';
											 if ($sqlda['Level'] === $finaldata['vStateStatus'][$j] && $sqlda['Status'] === $finaldata['vstatus'][$j]) { // 18_12
												if ($sqlda['Level'] == 'VILLAGE') {
													$frcomment .= ' <strong style="color:#15bed2;"><u>Village:</u></strong> ' . $sqlda['VTName'] . ' - ' . $sqlda['MDDS_VT'] . ' ' . $comestr . 'd into ' . $finaldata['nametotext'];
													$frcomment1 .= ' <strong style="color:#15bed2;"><u>Village:</u></strong> ' . $sqlda['VTName'] . ' - ' . $sqlda['MDDS_VT'] . ' ' . $comestr . 'd into ' . $finaldata['nametotext'];
												} else {
													$frcomment .= ' <strong style="color:#45b0e2;"><u>Town:</u></strong> ' . $sqlda['VTName'] . ' - ' . $sqlda['MDDS_VT'] . ' ' . $comestr . 'd into ' . $finaldata['nametotext'];
													$frcomment1 .= ' <strong style="color:#45b0e2;"><u>Town:</u></strong> ' . $sqlda['VTName'] . ' - ' . $sqlda['MDDS_VT'] . ' ' . $comestr . 'd into ' . $finaldata['nametotext'];
												}
											} else {
												if ($sqlda['Level'] == 'VILLAGE') {
													$frcomment .= ' <strong style="color:#15bed2;"><u>Village:</u></strong> ' . $sqlda['VTName'] . ' - ' . $sqlda['MDDS_VT'] . ' ' . $comestr . 'd into ' . $finaldata['nametotext'] . ' and Status Changed to ' . $finaldata['vStateStatus'][$j] . ' (' . $finaldata['vstatus'][$j] . ')';
													$frcomment1 .= ' <strong style="color:#15bed2;"><u>Village:</u></strong> ' . $sqlda['VTName'] . ' - ' . $sqlda['MDDS_VT'] . ' ' . $comestr . 'd into ' . $finaldata['nametotext'] . ' and status Changes to ' . $finaldata['vStateStatus'][$j] . ' (' . $finaldata['vstatus'][$j] . ')';
												} else {
													$frcomment .= ' <strong style="color:#45b0e2;"><u>Town:</u></strong> ' . $sqlda['VTName'] . ' - ' . $sqlda['MDDS_VT'] . ' ' . $comestr . 'd into ' . $finaldata['nametotext'] . ' and Status Changed to ' . $finaldata['vStateStatus'][$j] . ' (' . $finaldata['vstatus'][$j] . ')';
													$frcomment1 .= ' <strong style="color:#45b0e2;"><u>Town:</u></strong> ' . $sqlda['VTName'] . ' - ' . $sqlda['MDDS_VT'] . ' ' . $comestr . 'd into ' . $finaldata['nametotext'] . ' and Status Changed to ' . $finaldata['vStateStatus'][$j] . ' (' . $finaldata['vstatus'][$j] . ')';
												}
											}
										
	
									
	
										$forreadqueryapp =array($finaldata['namefrom'][$j],$finaldata['action'][$j],$finaldata['newnamem'][0],$finaldata['docids'],$finaldata['comefromcheck'],$frcomment,$_POST['clickbutton'],$finaldata['fromstate'][$j],$finaldata['districtget'][$j],$finaldata['sddistrictget'][$j],$finaldata['namefrom'][$j],$finaldata['statenew'][0],$finaldata['districtnew'][0],$finaldata['sddistrictnew'][0],$finaldata['newnamem'][0],$sqlda['STIDR'],$sqlda['DTIDR'],$sqlda['SDIDR'],$finaldata['newnamem'][0],$_SESSION['login_id']);
	
										$forreadqueryapp1 =array($finaldata['namefrom'][$j],$finaldata['action'][$j],$finaldata['namefrom'][$j],$finaldata['docids'],$finaldata['comefromcheck'],$frcomment1,'MAIN',$finaldata['fromstate'][$j],$finaldata['districtget'][$j],$finaldata['sddistrictget'][$j],$finaldata['namefrom'][$j],$finaldata['fromstate'][$j],$finaldata['districtget'][$j],$finaldata['sddistrictget'][$j],$finaldata['namefrom'][$j],$sqlda['STIDR'],$sqlda['DTIDR'],$sqlda['SDIDR'],$sqlda['VTIDR'],$_SESSION['login_id']);
	
	
										// $forread2 =array($finaldata['newnamem'][0],$finaldata['action'][$o],$finaldata['newnamem'][0],$finaldata['docids'],$finaldata['comefromcheck'],$frcomment2,'NAMECHANGE',$finaldata['fromstate'][$o],$finaldata['districtnew'][$o],$finaldata['sddistrictnew'][$o],$finaldata['newnamem'][$j],$finaldata['fromstate'][$o],$finaldata['districtnew'][$o],$finaldata['sddistrictnew'][$o],$finaldata['newnamem'][0],$finaldata['fromstate'][$o],$finaldata['districtnew'][$o],$finaldata['sddistrictnew'][$o],$finaldata['newnamem'][0],$_SESSION['login_id']);
										$forread = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","DTID","SDID","VTID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE","STIDR","DTIDR","SDIDR","VTIDR","created_by") VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14,$15,$16,$17,$18,$19,$20)';
										$resdata = pg_query_params($db,$forread,$forreadqueryapp);
	
										$forread1 = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment1","comeaction","STID","DTID","SDID","VTID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE","STIDR","DTIDR","SDIDR","VTIDR","created_by") VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14,$15,$16,$17,$18,$19,$20)';
										$resdata1 = pg_query_params($db,$forread,$forreadqueryapp1);
	
										}
									$result_rows = pg_affected_rows($resdata);
									
									if($result_rows!=0)
									{
										$linkk='';

										$linkarray = $finaldata['namefrom'];
										$linkarray1 = $finaldata['fromstate'];
										$linkarray2 = $finaldata['districtget'];
										$linkarray3 = $finaldata['sddistrictget'];
										$arrayof=array_merge($linkarray,$finaldata['newnamem']);
										$arrayof1=array_merge($linkarray1,$finaldata['statenew']);
										$arrayof2=array_merge($linkarray2,$finaldata['districtnew']);
										$arrayof3=array_merge($linkarray3,$finaldata['sddistrictnew']);

										for($i=0;$i<count($arrayof);$i++)
										{
										$linkk=array($finaldata['docids'],$arrayof1[$i],$arrayof2[$i],$arrayof3[$i],$arrayof[$i]);
										
									$linkdata = "insert into documentlink".$_SESSION['activeyears']." (docids,linkstids,linkdtids,linksdids,linkvtids) VALUES ($1,$2,$3,$4,$5)";
									pg_query_params($db,$linkdata,$linkk);

										}
									
										


										// $documentdata = "update documentdata".$_SESSION['activeyears']." set docstatus=1 where \"docids\"=".$finaldata['docids']."";

										if(count($full)!=0)
										{
										$updatVT = 'update vt'.$_SESSION['activeyears'].' set is_deleted=$1 where vt'.$_SESSION['activeyears'].'."VTID" = Any(string_to_array($2::text, \',\'::text)::NUMERIC[])';

										pg_query_params($db,$updatVT,array(0,implode(',',$full)));


										// $wdupdate = 'update wd'.$_SESSION['activeyears'].' set "STID"='.$finaldata['statenew'][0].',"DTID"='.$finaldata['districtnew'][0].',"SDID"='.$finaldata['sddistrictnew'][0].',"VTID"='.$finaldata['newnamem'][0].' where VTID IN ('.implode(',',$full).')';
										// pg_query($db,$wdupdate);
										}





										// pg_query($db,$documentdata);
										

										if($finaldata['partiallyids1']!='')
										{



										pg_query_params($db,'update partiallydata'.$_SESSION['activeyears'].' set "pstatus"=$1 where partiallyids=$2',array(1,$finaldata['partiallyids1']));	
										}

										$sql_da = pg_query_params($db,'select * from partiallydata'.$_SESSION['activeyears'].' where docids=$1 AND pstatus=$2',array($finaldata['docids'],0));
										if(pg_numrows($sql_da)==0)
										{
										pg_query_params($db,'update documentdata'.$_SESSION['activeyears'].' set docstatus=$1 where docids=$2',array(1,$finaldata['docids']));

										}
										else
										{
										pg_query_params('update documentdata'.$_SESSION['activeyears'].' set docstatus=$1 where docids=$2',array(2,$finaldata['docids']));
										}


										if($finaldata['oremovenewarray']==1)
										{
										$stnameupdate = "update vt".$_SESSION['activeyears']." set \"VTName\"=$1,\"Level\"=$2,\"Status\"=$3 where \"VTID\"=$4";		

										
									//pg_query_params($db,$stnameupdate,array(ucwords(strtolower($finaldata['newnamecheck'][0])),ucwords(strtoupper($finaldata['vStateStatus'][0])),ucwords(strtoupper($finaldata['vstatus'][0])),$finaldata['newnamem'][0]));	
										//Titlecase issue resolved by gowthami
									pg_query_params($db,$stnameupdate,array($finaldata['newnamecheck'][0],ucwords(strtoupper($finaldata['vStateStatus'][0])),ucwords(strtoupper($finaldata['vstatus'][0])),$finaldata['newnamem'][0]));	
									}
										else
										{

										$stnameupdate = "update vt".$_SESSION['activeyears']." set \"Level\"=$1,\"Status\"=$2 where \"VTID\"=$3";		

										pg_query_params($db,$stnameupdate,array(ucwords(strtoupper($finaldata['vStateStatus'][0])),ucwords(strtoupper($finaldata['vstatus'][0])),$finaldata['newnamem'][0]));	

										}

										$task = "mergedone";
									}
									else
									{
										$task = "error";
									}

							

				
			}
		
					else
					{



						if(isset($finaldata['statenewarray']))
						{
						$statenewarray = explode(',',$finaldata['statenewarray']);
						}

						if(isset($finaldata['districtnewarray']))
						{
						$districtnewarray = explode(',',$finaldata['districtnewarray']);
						}

						if(isset($finaldata['sddistrictnewarray']))
						{
						$sddistrictnewarray = explode(',',$finaldata['sddistrictnewarray']);
						}


						if(isset($finaldata['statenewarrayfrom']))
							{
							$statenewarrayfrom = explode(',',$finaldata['statenewarrayfrom']);
							}

							if(isset($finaldata['districtnewarrayfrom']))
							{
							$districtnewarrayfrom = explode(',',$finaldata['districtnewarrayfrom']);
							}

							if(isset($finaldata['sddistrictnewarrayfrom']))
							{
							$sddistrictnewarrayfrom = explode(',',$finaldata['sddistrictnewarrayfrom']);
							}





						

						$vt= array();
						$vtf= array();
						$ii = explode(',',$finaldata['ind']);
						$forread = '';
						$forread1 = '';
						$linkst='';

						for($o=0;$o<count($finaldata['action']);$o++)
						{
																						
						

									if($ii[$o]==1 && $finaldata['action'][$o]=='Partially Merge')
									{



											for($j=0;$j<count($finaldata['namefrom']);$j++)
											{

												$frcomment='';
												 $frcomment .='<strong style="color:#aa81f3;"><u>State/UT:</u></strong> '.$statenewarray[0].'; <strong style="color:Green;"><u>District:</u></strong> '.$districtnewarray[0].'; <strong style="color:blue;"><u>Sub District:</u></strong> '.$sddistrictnewarray[0].';';

												 $frcomment1='';
												 $frcomment1 .='<strong style="color:#aa81f3;"><u>State/UT:</u></strong> '.$statenewarrayfrom[$o].'; <strong style="color:Green;"><u>District:</u></strong> '.$districtnewarrayfrom[$o].'; <strong style="color:blue;"><u>Sub District:</u></strong> '.$sddistrictnewarrayfrom[$o].';';
												
												 $frcomment2='';
												 $frcomment2 .='<strong style="color:#aa81f3;"><u>State/UT:</u></strong> '.$statenewarray[0].'; <strong style="color:Green;"><u>District:</u></strong> '.$districtnewarray[0].'; <strong style="color:blue;"><u>Sub District:</u></strong> '.$sddistrictnewarray[0].';';
												$sqlo='Select "STIDR","DTIDR","SDIDR","VTIDR","Level","Status","VTName","MDDS_VT" from vt'.$_SESSION['activeyears'].' WHERE "STID"=$1 AND "DTID"=$2 AND "SDID"=$3 AND "VTID"=$4';
												$sqlold = pg_query_params($db,$sqlo,array($finaldata['fromstate'][$o],$finaldata['districtget'][$o],$finaldata['sddistrictget'][$o],$finaldata['namefrom'][$j]));
												$sqlda = pg_fetch_array($sqlold);

												
												if($finaldata['newnamecheck'][0]!='')
												{
													if($sqlda['Level']=='VILLAGE')
													{
													// 	$frcomment .=' <strong style="color:#45b0e2;"><u>Town:</u></strong> No Change;';
													//08_11

													$actionLength = count($finaldata['action']);
													$namefromtextarray = explode(",", $finaldata['namefromtext']);
													$namefromtextarrayLength = count($namefromtextarray);
													$subArrays = [];
													$namefromCounter = 0;
													
													$keys = [];
													for ($i = 1; $i <= $actionLength; $i++) {
														$keys[] = 'namefrom' . ($i > 1 ? $i : '');
													}
													
													$final_string = "";
													$frcommentt = '';
													$frcommenttString ='';
													
													foreach ($keys as $key) {
														if (isset($finaldata[$key]) && is_array($finaldata[$key])) {
															$tempArray = [];
															
															foreach ($finaldata[$key] as $value) {
																if ($namefromCounter < $namefromtextarrayLength) {
																	$tempArray[] = $namefromtextarray[$namefromCounter++] . " ";
																}
															}
															$subArrays[] = implode(', ', $tempArray);
														}
													}
													
													$matchedArray = [];
							$subArraysCount = count($subArrays);
							
							for ($i = 0; $i < $subArraysCount; $i++) {
							if (isset($finaldata['action'][$i])) {
							$valueWithoutQuotes = str_replace('"', '', $finaldata['action'][$i]);
							$valueWithParentheses = '(' . $valueWithoutQuotes . ')' .';';
							$matchedArray[$subArrays[$i]] = $valueWithParentheses;
							}
							}
							
							$$frcommentt = '';
							foreach ($matchedArray as $key => $value) {
								$frcommentt .= "$key: $value ";
								}
								
								$frcommentt = trim($frcommentt);
							
//18-12 status change
if ($sqlda['Level'] === $finaldata['vStateStatus'][$j] && $sqlda['Status'] === $finaldata['vstatus'][$j]) {
	if ($sqlda['Level'] == 'VILLAGE') {
		$frcomment .=' <strong style="color:#15bed2;"><u>Village:</u></strong> '.$frcommentt.' and '.$finaldata['nametotext'].' Name Changed to '.$finaldata['newnamecheck'][0].';'; //14122023
		$frcomment1 .=' <strong style="color:#15bed2;"><u>Village:</u></strong> '.$frcommentt.' and '.$finaldata['nametotext'].' Name Changed to '.$finaldata['newnamecheck'][0].';';//14122023
		$frcomment2 .=' <strong style="color:#45b0e2;"><u>Village:</u></strong> '.$frcommentt.' into '.$finaldata['nametotext'].', '.$finaldata['nametotext'].' Name Changed to '.$finaldata['newnamecheck'][0].';';//14122023
	} else {
		$frcomment .=' <strong style="color:#15bed2;"><u>Town:</u></strong> '.$frcommentt.' and '.$finaldata['nametotext'].' Name Changed to '.$finaldata['newnamecheck'][0].';'; //14122023
	   $frcomment1 .=' <strong style="color:#15bed2;"><u>Town:</u></strong> '.$frcommentt.' and '.$finaldata['nametotext'].' Name Changed to '.$finaldata['newnamecheck'][0].';';//14122023
		$frcomment2 .=' <strong style="color:#45b0e2;"><u>Town:</u></strong> '.$frcommentt.' into '.$finaldata['nametotext'].', '.$finaldata['nametotext'].' Name Changed to '.$finaldata['newnamecheck'][0].';';//14122023
	}
} else {
	if ($sqlda['Level'] == 'VILLAGE') {
		$frcomment .=' <strong style="color:#15bed2;"><u>Village:</u></strong> '.$frcommentt.' and '.$finaldata['nametotext'].' Name Changed to '.$finaldata['newnamecheck'][0].' and Status changed to ' . $finaldata['vStateStatus'][$j] . ' (' . $finaldata['vstatus'][$j] . ') ;'; //14122023
		$frcomment1 .=' <strong style="color:#15bed2;"><u>Village:</u></strong> '.$frcommentt.' and '.$finaldata['nametotext'].' Name Changed to '.$finaldata['newnamecheck'][0].';';//14122023
		$frcomment2 .=' <strong style="color:#45b0e2;"><u>Village:</u></strong> '.$frcommentt.' into '.$finaldata['nametotext'].', '.$finaldata['nametotext'].' Name Changed to '.$finaldata['newnamecheck'][0].' and Status changed to ' . $finaldata['vStateStatus'][$j] . ' (' . $finaldata['vstatus'][$j] . ') ; ';//14122023  //19122023
	} else {
		$frcomment .=' <strong style="color:#15bed2;"><u>Town:</u></strong> '.$frcommentt.' and '.$finaldata['nametotext'].' Name Changed to '.$finaldata['newnamecheck'][0].' and Status changed to ' . $finaldata['vStateStatus'][$j] . ' (' . $finaldata['vstatus'][$j] . ');'; //14122023
	   $frcomment1 .=' <strong style="color:#15bed2;"><u>Town:</u></strong> '.$frcommentt.' and '.$finaldata['nametotext'].' Name Changed to '.$finaldata['newnamecheck'][0].';';//14122023
		$frcomment2 .=' <strong style="color:#45b0e2;"><u>Town:</u></strong> '.$frcommentt.' into '.$finaldata['nametotext'].', '.$finaldata['nametotext'].' Name Changed to '.$finaldata['newnamecheck'][0].'  ;';//14122023    //19122023
	}
}


}
}

											
											$forread1 =array($finaldata['newnamem'][0],$finaldata['action'][$o],$finaldata['newnamem'][0],$finaldata['docids'],$finaldata['comefromcheck'],$frcomment1,'MAIN',$finaldata['fromstate'][$o],$finaldata['districtget'][$o],$finaldata['sddistrictget'][$o],$finaldata['namefrom'][$j],$finaldata['fromstate'][$o],$finaldata['districtget'][$o],$finaldata['sddistrictget'][$o],$finaldata['namefrom'][$j],$sqlda['STIDR'],$sqlda['DTIDR'],$sqlda['SDIDR'],$sqlda['VTIDR'],$_SESSION['login_id']);


											$forread =array($finaldata['namefrom'][$j],$finaldata['action'][$o],$finaldata['newnamem'][0],$finaldata['docids'],$finaldata['comefromcheck'],$frcomment,$_POST['clickbutton'],$finaldata['fromstate'][$o],$finaldata['districtget'][$o],$finaldata['sddistrictget'][$o],$finaldata['namefrom'][$j],$finaldata['statenew'][0],$finaldata['districtnew'][0],$finaldata['sddistrictnew'][0],$finaldata['newnamem'][0],$sqlda['STIDR'],$sqlda['DTIDR'],$sqlda['SDIDR'],$sqlda['VTIDR'],$_SESSION['login_id']);
											$forread2 =array($finaldata['newnamem'][0],$finaldata['action'][$o],$finaldata['newnamem'][0],$finaldata['docids'],$finaldata['comefromcheck'],$frcomment2,'NAMECHANGE',$finaldata['fromstate'][$o],$finaldata['districtnew'][$o],$finaldata['sddistrictnew'][$o],$finaldata['newnamem'][$j],$finaldata['fromstate'][$o],$finaldata['districtnew'][$o],$finaldata['sddistrictnew'][$o],$finaldata['newnamem'][0],$finaldata['fromstate'][$o],$finaldata['districtnew'][$o],$finaldata['sddistrictnew'][$o],$finaldata['newnamem'][0],$_SESSION['login_id']);
											

												$linkst =array($finaldata['docids'],$finaldata['fromstate'][$o],$finaldata['districtget'][$o],$finaldata['sddistrictget'][$o],$finaldata['namefrom'][$j]);


												$insertforread1 = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","DTID","SDID","VTID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE","STIDR","DTIDR","SDIDR","VTIDR","created_by") VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14,$15,$16,$17,$18,$19,$20)';

											pg_query_params($db,$insertforread1,$forread1);

											$insertforread2 = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","DTID","SDID","VTID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE","STIDR","DTIDR","SDIDR","VTIDR","created_by") VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14,$15,$16,$17,$18,$19,$20)';

											pg_query_params($db,$insertforread1,$forread2);

											 $insertforread = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","DTID","SDID","VTID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE","STIDR","DTIDR","SDIDR","VTIDR","created_by") VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14,$15,$16,$17,$18,$19,$20)';
											pg_query_params($db,$insertforread,$forread);
											
											$insertlinkst = 'insert into documentlink'.$_SESSION['activeyears'].' (docids,linkstids,linkdtids,linksdids,linkvtids) VALUES ($1,$2,$3,$4,$5)';
											$resultst = pg_query_params($db,$insertlinkst,$linkst);


											}

						
							
							
										     $vt = array_merge($vt,$finaldata['namefrom']);
									}
									else if($ii[$o]!=1 && $finaldata['action'][$o]=='Partially Merge')
									{
										for($j=0;$j<count($finaldata['namefrom'.$ii[$o].'']);$j++)
											{
												// $sqlo='Select "STIDR","DTIDR","SDIDR","VTIDR","Level","Status","VTName","MDDS_VT" from vt'.$_SESSION['activeyears'].' WHERE "STID"='.$finaldata['fromstate'][$o].' AND "DTID"='.$finaldata['districtget'][$o].' AND "SDID"='.$finaldata['sddistrictget'][$o].' AND "VTID"='.$finaldata['namefrom'.$ii[$o].''][$j].' AND is_deleted=1';
												// $sqlold = pg_query($db,$sqlo);
												// $sqlda = pg_fetch_array($sqlold);


												$sqlo='Select "STIDR","DTIDR","SDIDR","VTIDR","Level","Status","VTName","MDDS_VT" from vt'.$_SESSION['activeyears'].' WHERE "STID"=$1 AND "DTID"=$2 AND "SDID"=$3 AND "VTID"=$4';
												$sqlold = pg_query_params($db,$sqlo,array($finaldata['fromstate'][$o],$finaldata['districtget'][$o],$finaldata['sddistrictget'][$o],$finaldata['namefrom'.$ii[$o].''][$j]));
												$sqlda = pg_fetch_array($sqlold);



												$frcomment='';

												$frcomment .='<strong style="color:#aa81f3;"><u>State/UT:</u></strong> '.$statenewarray[0].'; <strong style="color:Green;"><u>District:</u></strong> '.$districtnewarray[0].'; <strong style="color:blue;"><u>Sub District:</u></strong> '.$sddistrictnewarray[0].';';

												$frcomment1='';

												$frcomment1 .='<strong style="color:#aa81f3;"><u>State/UT:</u></strong> '.$statenewarrayfrom[$o].'; <strong style="color:Green;"><u>District:</u></strong> '.$districtnewarrayfrom[$o].'; <strong style="color:blue;"><u>Sub District:</u></strong> '.$sddistrictnewarrayfrom[$o].';';


												if($finaldata['newnamecheck'][0]!='')
												{
													if($sqlda['Level']=='VILLAGE')
													{
															//Defect ID JC_09 forread issue solved by shashi
														// $frcomment .=' <strong style="color:#45b0e2;"><u>Town:</u></strong> No Change;';
														
														//08_11
															$frcomment .=' <strong style="color:#15bed2;"><u>Village:</u></strong> '.$frcommentt.' d into '.$finaldata['nametotext'].' and '.$finaldata['nametotext'].' name changed to '.$finaldata['newnamecheck'][0].' and Status changed to '.$finaldata['vStateStatus'][0].' ('.$finaldata['vstatus'][0].') ;';

															$frcomment1 .=' <strong style="color:#15bed2;"><u>Village:</u></strong> '.$frcommentt.' d into '.$finaldata['nametotext'].' and '.$finaldata['nametotext'].' name changed to '.$finaldata['newnamecheck'][0].'  ;'; //19122023
													}
													else
													{
															//Defect ID JC_09 forread issue solved by shashi
															//08_11
															$frcomment .=' <strong style="color:#45b0e2;"><u>Town:</u></strong> '.$frcommentt.' d into '.$finaldata['nametotext'].' and '.$finaldata['nametotext'].' name changed to '.$finaldata['newnamecheck'][0].' and Status changed to '.$finaldata['vStateStatus'][0].' ('.$finaldata['vstatus'][0].') ;';

															$frcomment1 .=' <strong style="color:#45b0e2;"><u>Town:</u></strong> '.$frcommentt.' d into '.$finaldata['nametotext'].' and '.$finaldata['nametotext'].' name changed to '.$finaldata['newnamecheck'][0].'  ;'; //19122023


															// $frcomment .=' <strong style="color:#15bed2;"><u>Village:</u></strong> No Change';
													}


												
												}
												else
												{

													if($sqlda['Level']=='VILLAGE')
													{
														// $frcomment .=' <strong style="color:#45b0e2;"><u>Town:</u></strong> No Change;';
														//08_11
															$frcomment .=' <strong style="color:#15bed2;"><u>Village:</u></strong> '.$finaldata['namefromtext'].' '.$finaldata['action'][$o].'d into '.$finaldata['nametotext'].'- '.$finaldata['vStateStatus'][0].' ('.$finaldata['vstatus'][0].') ;';

															$frcomment1 .=' <strong style="color:#15bed2;"><u>Village:</u></strong> '.$finaldata['namefromtext'].' '.$finaldata['action'][$o].'d into '.$finaldata['nametotext'].'- '.$finaldata['vStateStatus'][0].' ('.$finaldata['vstatus'][0].');';
													}
													else
													{
														//08_11
															$frcomment .=' <strong style="color:#45b0e2;"><u>Town:</u></strong> '.$finaldata['namefromtext'].' '.$finaldata['action'][$o].'d into '.$finaldata['nametotext'].'- '.$finaldata['vStateStatus'][0].' ('.$finaldata['vstatus'][0].');';

															$frcomment1 .=' <strong style="color:#45b0e2;"><u>Town:</u></strong> '.$finaldata['namefromtext'].' '.$finaldata['action'][$o].'d into '.$finaldata['nametotext'].' -'.$finaldata['vStateStatus'][0].' ('.$finaldata['vstatus'][0].');';

														//	$frcomment .=' <strong style="color:#15bed2;"><u>Village:</u></strong> No Change';
													}

												
												}

												
												


											$forread1 =array($finaldata['namefrom'.$ii[$o].''][$j],$finaldata['action'][$o],$finaldata['namefrom'.$ii[$o].''][$j],$finaldata['docids'],$finaldata['comefromcheck'],$frcomment1,'MAIN',$finaldata['fromstate'][$o],$finaldata['districtget'][$o],$finaldata['sddistrictget'][$o],$finaldata['namefrom'.$ii[$o].''][$j],$finaldata['fromstate'][$o],$finaldata['districtget'][$o],$finaldata['sddistrictget'][$o],$finaldata['namefrom'.$ii[$o].''][$j],$sqlda['STIDR'],$sqlda['DTIDR'],$sqlda['SDIDR'],$sqlda['VTIDR'],$_SESSION['login_id']);

											$forread =array($finaldata['namefrom'.$ii[$o].''][$j],$finaldata['action'][$o],$finaldata['newnamem'][0],$finaldata['docids'],$finaldata['comefromcheck'],$frcomment,$_POST['clickbutton'],$finaldata['fromstate'][$o],$finaldata['districtget'][$o],$finaldata['sddistrictget'][$o],$finaldata['namefrom'.$ii[$o].''][$j],$finaldata['statenew'][0],$finaldata['districtnew'][0],$finaldata['sddistrictnew'][0],$finaldata['newnamem'][0],$sqlda['STIDR'],$sqlda['DTIDR'],$sqlda['SDIDR'],$sqlda['VTIDR'],$_SESSION['login_id']);

											

											$linkst =array($finaldata['docids'],$finaldata['fromstate'][$o],$finaldata['districtget'][$o],$finaldata['sddistrictget'][$o],$finaldata['namefrom'.$ii[$o].''][$j]);


											$insertforread1 = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","DTID","SDID","VTID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE","STIDR","DTIDR","SDIDR","VTIDR","created_by") VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14,$15,$16,$17,$18,$19,$20)';

										pg_query_params($db,$insertforread1,$forread1);


										 $insertforread = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","DTID","SDID","VTID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE","STIDR","DTIDR","SDIDR","VTIDR","created_by") VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14,$15,$16,$17,$18,$19,$20)';
										pg_query_params($db,$insertforread,$forread);
										
										$insertlinkst = 'insert into documentlink'.$_SESSION['activeyears'].' (docids,linkstids,linkdtids,linksdids,linkvtids) VALUES ($1,$2,$3,$4,$5)';
										$resultst = pg_query_params($db,$insertlinkst,$linkst);


											}

										$vt = array_merge($vt,$finaldata['namefrom'.$ii[$o].'']);
									}
									else
									{


										if($ii[$o]==1 && $finaldata['action'][$o]=='Merge')
										{

											for($j=0;$j<count($finaldata['namefrom']);$j++)
											{

												// $sqlo='Select "STIDR","DTIDR","SDIDR","VTIDR","Level","Status","VTName","MDDS_VT" from vt'.$_SESSION['activeyears'].' WHERE "STID"='.$finaldata['fromstate'][$o].' AND "DTID"='.$finaldata['districtget'][$o].' AND "SDID"='.$finaldata['sddistrictget'][$o].' AND "VTID"='.$finaldata['namefrom'][$j].' AND is_deleted=1';
												// $sqlold = pg_query($db,$sqlo);
												// $sqlda = pg_fetch_array($sqlold);

												$sqlo='Select "STIDR","DTIDR","SDIDR","VTIDR","Level","Status","VTName","MDDS_VT" from vt'.$_SESSION['activeyears'].' WHERE "STID"=$1 AND "DTID"=$2 AND "SDID"=$3 AND "VTID"=$4';
												$aaa=array($finaldata['fromstate'][$o],$finaldata['districtget'][$o],$finaldata['sddistrictget'][$o],$finaldata['namefrom'][$j]);
												// print_r($aaa);
												$sqlold = pg_query_params($db,$sqlo,$aaa);
												$sqlda = pg_fetch_array($sqlold);



												$frcomment='';
												$frcomment2='';
												$frcomment .='<strong style="color:#aa81f3;"><u>State/UT:</u></strong> '.$statenewarray[0].'; <strong style="color:Green;"><u>District:</u></strong> '.$districtnewarray[0].'; <strong style="color:blue;"><u>Sub District:</u></strong> '.$sddistrictnewarray[0].';';
                                                $frcomment2 .='<strong style="color:#aa81f3;"><u>State/UT:</u></strong> '.$statenewarray[0].'; <strong style="color:Green;"><u>District:</u></strong> '.$districtnewarray[0].'; <strong style="color:blue;"><u>Sub District:</u></strong> '.$sddistrictnewarray[0].';';
												if(isset($finaldata['newnamecheck']) && $finaldata['newnamecheck'][0]!='')
												{

													if($sqlda['Level']=='VILLAGE')
													{
														//Defect ID JC_09 forread issue solved by shashi
														//$frcomment .=' <strong style="color:#45b0e2;"><u>Town:</u></strong> No Change;';
														$actionLength = count($finaldata['action']);
													$namefromtextarray = explode(",", $finaldata['namefromtext']);
													$namefromtextarrayLength = count($namefromtextarray);
													$subArrays = [];
													$namefromCounter = 0;
													
													$keys = [];
													for ($i = 1; $i <= $actionLength; $i++) {
														$keys[] = 'namefrom' . ($i > 1 ? $i : '');
													}
													
													$final_string = "";
													$frcommentt = '';
													$frcommenttString ='';
													
													foreach ($keys as $key) {
														if (isset($finaldata[$key]) && is_array($finaldata[$key])) {
															$tempArray = [];
															
															foreach ($finaldata[$key] as $value) {
																if ($namefromCounter < $namefromtextarrayLength) {
																	$tempArray[] = $namefromtextarray[$namefromCounter++] . " ";
																}
															}
															$subArrays[] = implode(', ', $tempArray);
														}
													}
													
													$matchedArray = [];
							$subArraysCount = count($subArrays);
							
							for ($i = 0; $i < $subArraysCount; $i++) {
							if (isset($finaldata['action'][$i])) {
							$valueWithoutQuotes = str_replace('"', '', $finaldata['action'][$i]);
							$valueWithParentheses = '(' . $valueWithoutQuotes . ')' .';';
							$matchedArray[$subArrays[$i]] = $valueWithParentheses;
							}
							}
							
							$$frcommentt = '';
							foreach ($matchedArray as $key => $value) {
								$frcommentt .= "$key: $value ";
								}
								
								$frcommentt = trim($frcommentt);
							
								if ($sqlda['Level'] === $finaldata['vStateStatus'][$j] && $sqlda['Status'] === $finaldata['vstatus'][$j]) {
									if ($sqlda['Level'] == 'VILLAGE') {
										$frcomment .=' <strong style="color:#15bed2;"><u>Village:</u></strong> '.$frcommentt.' into '.$finaldata['nametotext'].' and '.$finaldata['nametotext'].' Name Changed to '.$finaldata['newnamecheck'][0].';'; //14122023
										// $frcomment1 .=' <strong style="color:#15bed2;"><u>Village:</u></strong> '.$frcommentt.' and '.$finaldata['nametotext'].' Name Changed to '.$finaldata['newnamecheck'][0].';';//14122023
										$frcomment2 .=' <strong style="color:#45b0e2;"><u>Village:</u></strong> '.$frcommentt.' into '.$finaldata['nametotext'].' and '.$finaldata['nametotext'].' Name Changed to '.$finaldata['newnamecheck'][0].';';//14122023
									} else {
										$frcomment .=' <strong style="color:#15bed2;"><u>Town:</u></strong> '.$frcommentt.' into '.$finaldata['nametotext'].' and '.$finaldata['nametotext'].'Name Changed to '.$finaldata['newnamecheck'][0].';'; //14122023
									//    $frcomment1 .=' <strong style="color:#15bed2;"><u>Town:</u></strong> '.$frcommentt.' and '.$finaldata['nametotext'].' Name Changed to '.$finaldata['newnamecheck'][0].';';//14122023
										$frcomment2 .=' <strong style="color:#45b0e2;"><u>Town:</u></strong> '.$frcommentt.' into '.$finaldata['nametotext'].' and '.$finaldata['nametotext'].' Name Changed to '.$finaldata['newnamecheck'][0].';';//14122023
									}
								} else {
									if ($sqlda['Level'] == 'VILLAGE') {
										$frcomment .=' <strong style="color:#15bed2;"><u>Village:</u></strong> '.$frcommentt.' into '.$finaldata['nametotext'].' and '.$finaldata['nametotext'].' Name Changed to '.$finaldata['newnamecheck'][0].' and Status changed to ' . $finaldata['vStateStatus'][$j] . ' (' . $finaldata['vstatus'][$j] . ') ;'; //14122023
										// $frcomment1 .=' <strong style="color:#15bed2;"><u>Village:</u></strong> '.$frcommentt.' and '.$finaldata['nametotext'].' Name Changed to '.$finaldata['newnamecheck'][0].' and Status changed to  ' . $finaldata['vStateStatus'][$j] . ' (' . $finaldata['vstatus'][$j] . ');';//14122023
										$frcomment2 .=' <strong style="color:#45b0e2;"><u>Village:</u></strong> '.$frcommentt.' into '.$finaldata['nametotext'].' and '.$finaldata['nametotext'].' Name Changed to '.$finaldata['newnamecheck'][0].' and Status changed to ' . $finaldata['vStateStatus'][$j] . ' (' . $finaldata['vstatus'][$j] . ')   ; ';//14122023  // 19122023
									} else {
										$frcomment .=' <strong style="color:#15bed2;"><u>Town:</u></strong> '.$frcommentt.' into '.$finaldata['nametotext'].' and '.$finaldata['nametotext'].' Name Changed to '.$finaldata['newnamecheck'][0].' and Status changed to ' . $finaldata['vStateStatus'][$j] . ' (' . $finaldata['vstatus'][$j] . ');'; //14122023
									//    $frcomment1 .=' <strong style="color:#15bed2;"><u>Town:</u></strong> '.$frcommentt.' and '.$finaldata['nametotext'].' Name Changed to '.$finaldata['newnamecheck'][0].' and Status changed to ' . $finaldata['vStateStatus'][$j] . ' (' . $finaldata['vstatus'][$j] . ');';//14122023
										$frcomment2 .=' <strong style="color:#45b0e2;"><u>Town:</u></strong> '.$frcommentt.' into '.$finaldata['nametotext'].' and '.$finaldata['nametotext'].' Name Changed to '.$finaldata['newnamecheck'][0].' and Status changed to ' . $finaldata['vStateStatus'][$j] . ' (' . $finaldata['vstatus'][$j] . ') ;';//14122023   // 19122023
									}
								}

							
							}
						}
												


											$forread =array($finaldata['namefrom'][$j],$finaldata['action'][$o],$finaldata['newnamem'][0],$finaldata['docids'],$finaldata['comefromcheck'],$frcomment,$_POST['clickbutton'],$finaldata['fromstate'][$o],$finaldata['districtget'][$o],$finaldata['sddistrictget'][$o],$finaldata['namefrom'][$j],$finaldata['statenew'][0],$finaldata['districtnew'][0],$finaldata['sddistrictnew'][0],$finaldata['newnamem'][0],$sqlda['STIDR'],$sqlda['DTIDR'],$sqlda['SDIDR'],$sqlda['VTIDR'],$_SESSION['login_id']);
                                            $forread2 =array($finaldata['newnamem'][0],$finaldata['action'][$o],$finaldata['newnamem'][0],$finaldata['docids'],$finaldata['comefromcheck'],$frcomment2,'NAMECHANGE',$finaldata['fromstate'][$o],$finaldata['districtnew'][$o],$finaldata['sddistrictnew'][$o],$finaldata['newnamem'][$j],$finaldata['fromstate'][$o],$finaldata['districtnew'][$o],$finaldata['sddistrictnew'][$o],$finaldata['newnamem'][0],$finaldata['fromstate'][$o],$finaldata['districtnew'][$o],$finaldata['sddistrictnew'][$o],$finaldata['newnamem'][0],$_SESSION['login_id']);
											$linkst =array($finaldata['docids'],$finaldata['fromstate'][$o],$finaldata['districtget'][$o],$finaldata['sddistrictget'][$o],$finaldata['namefrom'][$j]);


										

												 $insertforread = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","DTID","SDID","VTID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE","STIDR","DTIDR","SDIDR","VTIDR","created_by") VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14,$15,$16,$17,$18,$19,$20)';
												pg_query_params($db,$insertforread,$forread);
												$insertforread2 = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","DTID","SDID","VTID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE","STIDR","DTIDR","SDIDR","VTIDR","created_by") VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14,$15,$16,$17,$18,$19,$20)';
                                                pg_query_params($db,$insertforread,$forread2);
												
												$insertlinkst = 'insert into documentlink'.$_SESSION['activeyears'].' (docids,linkstids,linkdtids,linksdids,linkvtids) VALUES ($1,$2,$3,$4,$5)';
												$resultst = pg_query_params($db,$insertlinkst,$linkst);


											}

											$vtf = array_merge($vtf,$finaldata['namefrom']);
										}
										else
										{
											for($j=0;$j<count($finaldata['namefrom'.$ii[$o].'']);$j++)
											{
												// $sqlo='Select "STIDR","DTIDR","SDIDR","VTIDR","Level","Status","VTName","MDDS_VT" from vt'.$_SESSION['activeyears'].' WHERE "STID"='.$finaldata['fromstate'][$o].' AND "DTID"='.$finaldata['districtget'][$o].' AND "SDID"='.$finaldata['sddistrictget'][$o].' AND "VTID"='.$finaldata['namefrom'.$ii[$o].''][$j].' AND is_deleted=1';
												// $sqlold = pg_query($db,$sqlo);
												// $sqlda = pg_fetch_array($sqlold);

												$sqlo='Select "STIDR","DTIDR","SDIDR","VTIDR","Level","Status","VTName","MDDS_VT" from vt'.$_SESSION['activeyears'].' WHERE "STID"=$1 AND "DTID"=$2 AND "SDID"=$3 AND "VTID"=$4';
												$bbb=array($finaldata['fromstate'][$o],$finaldata['districtget'][$o],$finaldata['sddistrictget'][$o],$finaldata['namefrom'.$ii[$o].''][$j]);
												$sqlold = pg_query_params($db,$sqlo,$bbb);
												$sqlda = pg_fetch_array($sqlold);



												$frcomment='';
												 $frcomment .='<strong style="color:#aa81f3;"><u>State/UT:</u></strong> '.$statenewarray[0].'; <strong style="color:Green;"><u>District:</u></strong> '.$districtnewarray[0].'; <strong style="color:blue;"><u>Sub District:</u></strong> '.$sddistrictnewarray[0].';';

												 if(isset($finaldata['newnamecheck']) && $finaldata['newnamecheck'][0]!='')
												 {
 
													 if($sqlda['Level']=='VILLAGE')
													 {
															 //Defect ID JC_09 forread issue solved by shashi
														 //$frcomment .=' <strong style="color:#45b0e2;"><u>Town:</u></strong> No Change;';
															 $frcomment .=' <strong style="color:#15bed2;"><u>Village:</u></strong> '.$sqlda['VTName'].' - '.$sqlda['MDDS_VT'].' '.$finaldata['action'][$o].'d into '.$finaldata['nametotext'].' and '.$finaldata['nametotext'].' Name Changed to '.$finaldata['newnamecheck'][0].' and Status changed to ' . $finaldata['vStateStatus'][0] . ' (' . $finaldata['vstatus'][0] . ') ;';
													 }
													 else
													 {
															 //Defect ID JC_09 forread issue solved by shashi
															 $frcomment .=' <strong style="color:#45b0e2;"><u>Town:</u></strong> '.$sqlda['VTName'].' - '.$sqlda['MDDS_VT'].' '.$finaldata['action'][$o].'d into '.$finaldata['nametotext'].' and '.$finaldata['nametotext'].' Name Changed to '.$finaldata['newnamecheck'][0].'  and Status changed to ' . $finaldata['vStateStatus'][0] . ' (' . $finaldata['vstatus'][0] . ');';
														 //	$frcomment .=' <strong style="color:#15bed2;"><u>Village:</u></strong> No Change';
													 }
 
 
 
												 
												 }
												 else
												 {
													 if($sqlda['Level']=='VILLAGE')
													 {
														 // $frcomment .=' <strong style="color:#45b0e2;"><u>Town:</u></strong> No Change;';
															 $frcomment .=' <strong style="color:#15bed2;"><u>Village:</u></strong> '.$sqlda['VTName'].' - '.$sqlda['MDDS_VT'].' '.$finaldata['action'][$o].'d into '.$finaldata['nametotext'].';';
													 }
													 else
													 {
															 $frcomment .=' <strong style="color:#45b0e2;"><u>Town:</u></strong> '.$sqlda['VTName'].' - '.$sqlda['MDDS_VT'].' '.$finaldata['action'][$o].'d into '.$finaldata['nametotext'].';';
														 //	$frcomment .=' <strong style="color:#15bed2;"><u>Village:</u></strong> No Change';
													 }
 
												 }
 

												

												$forread =array($finaldata['namefrom'.$ii[$o].''][$j],$finaldata['action'][$o],$finaldata['newnamem'][0],$finaldata['docids'],$finaldata['comefromcheck'],$frcomment,$_POST['clickbutton'],$finaldata['fromstate'][$o],$finaldata['districtget'][$o],$finaldata['sddistrictget'][$o],$finaldata['namefrom'.$ii[$o].''][$j],$finaldata['statenew'][0],$finaldata['districtnew'][0],$finaldata['sddistrictnew'][0],$finaldata['newnamem'][0],$sqlda['STIDR'],$sqlda['DTIDR'],$sqlda['SDIDR'],$sqlda['VTIDR'],$_SESSION['login_id']);

												$linkst =array($finaldata['docids'],$finaldata['fromstate'][$o],$finaldata['districtget'][$o],$finaldata['sddistrictget'][$o],$finaldata['namefrom'.$ii[$o].''][$j]);

										

												 $insertforread = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","DTID","SDID","VTID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE","STIDR","DTIDR","SDIDR","VTIDR","created_by") VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14,$15,$16,$17,$18,$19,$20)';
												pg_query_params($db,$insertforread,$forread);
												
												$insertlinkst = 'insert into documentlink'.$_SESSION['activeyears'].' (docids,linkstids,linkdtids,linksdids,linkvtids) VALUES ($1,$2,$3,$4,$5)';
												$resultst = pg_query_params($db,$insertlinkst,$linkst);


											}

											$vtf = array_merge($vtf,$finaldata['namefrom'.$ii[$o].'']);
										}




										
									}


							}

								
								$insertlinkst1 = 'insert into documentlink'.$_SESSION['activeyears'].' (docids,linkstids,linkdtids,linksdids,linkvtids) VALUES ($1,$2,$3,$4,$5)';

								$resultst1 = pg_query_params($db,$insertlinkst1,array($finaldata['docids'],$finaldata['statenew'][0],$finaldata['districtnew'][0],$finaldata['sddistrictnew'][0],$finaldata['newnamem'][0]));
								
								$result_rows = pg_affected_rows($resultst);


								if($result_rows!=0)
								{
								pg_query_params($db,'update documentdata'.$_SESSION['activeyears'].' set docstatus=$1 where docids=$2',array(1,$finaldata['docids']));


								// pg_query('update wd'.$_SESSION['activeyears'].' set "STID"='.$finaldata['statenew'][0].',"DTID"='.$finaldata['districtnew'][0].',"SDID"='.$finaldata['sddistrictnew'][0].',"VTID"='.$idsof.' where wd'.$_SESSION['activeyears'].'."VTID" IN ('.implode(',',$$finaldata['namefrom']).')');


								if(count($vtf)>0)
								{
								pg_query_params($db,'update vt'.$_SESSION['activeyears'].' set "is_deleted"=$1 where vt'.$_SESSION['activeyears'].'."VTID" = Any(string_to_array($2::text, \',\'::text)::NUMERIC[])',array(0,implode(",",$vtf)));	
								}
								// if($forreadqueryappend1!='')
								// {
								// 	$insertforread1 = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","DTID","SDID","VTID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE","STIDR","DTIDR","SDIDR","VTIDR","created_by") VALUES '.$forreadqueryappend1.'';

								// pg_query($db,$insertforread1);
								// }
								
								
								

								if($finaldata['partiallyids1']!='')
								{

								pg_query_params($db,'update partiallydata'.$_SESSION['activeyears'].' set "pstatus"=$1 where partiallyids=$2',array(1,$finaldata['partiallyids1']));	
								}


										if($finaldata['oremovenewarray']==1)
										{
										$stnameupdate = 'update vt'.$_SESSION['activeyears'].' set "VTName"=$1,"Level"=$2,"Status"=$3 where vt'.$_SESSION['activeyears'].'."VTID"=$4';		

										pg_query_params($db,$stnameupdate,array($finaldata['newnamecheck'][0],ucwords(strtoupper($finaldata['vStateStatus'][0])),ucwords(strtoupper($finaldata['vstatus'][0])),$finaldata['newnamem'][0]));	
										}
										else
										{

										$stnameupdate = 'update vt'.$_SESSION['activeyears'].' set "Level"=$1,"Status"=$2 where vt'.$_SESSION['activeyears'].'."VTID"=$3';		

										pg_query_params($db,$stnameupdate,array(ucwords(strtoupper($finaldata['vStateStatus'][0])),ucwords(strtoupper($finaldata['vstatus'][0])),$finaldata['newnamem'][0]));

										}

								//By sahana village merge one to one, partially merge one to one, merge many to one, partially merge many to one, many to one merge and partially merge combination 0111
								$auflag_query = 'SELECT auflag FROM unit WHERE auaction = $1 AND aulevel = $2';
								$actions = $finaldata['action'];
								$namefrom_values = [];
								
								foreach ($finaldata as $key => $value) {
									if (preg_match('/^namefrom\d*$/', $key)) {
										$namefrom_values[] = $value;
									}
								}
				
								foreach ($actions as $action) {
									if (empty($namefrom_values)) {
										break; 
									}
								
									$namefrom = array_shift($namefrom_values);
								
									foreach ($namefrom as $item) {
										$au = pg_query_params($db, $auflag_query, array($action, $finaldata['comefromcheck']));
								
										if ($au) {
											$row = pg_fetch_assoc($au);
											$auflag_value = $row['auflag'];
											$update_vt = pg_query_params($db, 'UPDATE vt'.$_SESSION['activeyears'].' SET "auflag" = $1, "auaction" = $2 WHERE "VTID" = $3', array($auflag_value, $action, $item));
											if (!$update_vt) {
												echo "UPDATE query failed: " . pg_last_error($db);
											}
										} else {
											echo "SELECT query failed: " . pg_last_error($db);
										}
									}
								}


							$task = "mergedone";
								}
								else
								{
								$task = "error";
								}


				
				}
		}
}
else if($_POST['clickbutton']=='submerge')
{

	

			$retdata =  (array) json_decode($finaldata['returndata']);

	//FM/SB starts

			// if($finaldata['applyon']=='Sub-District' || $finaldata['comefromchecksub']=='Sub-District')
			// {
						
			// 	if(isset($retdata['partiallylevel0']))
			// 	{
			// 			$fullmerege = array_diff($retdata['selected_comesub'],$retdata['partiallylevel0']);
			// 			$fullmerege = array_values($fullmerege);
			// 			// print_r($fullmerege);
			// 			$linkVTarray = array();
			// 			$link=''; 
			// 			for($j=0;$j<count($retdata['partiallylevel0']);$j++)
			// 			{

			// 				$linkVTarray=array_merge($linkVTarray,$finaldata['addlinksDTID'.$j.'']);
			// 				for($h=0;$h<count($finaldata['addlinksDTID'.$j.'']);$h++)
			// 				{
			// 					$link .= "(".$retdata['docidssub'].",".$retdata['stids'].",".$retdata['districtgetsub'].",".$retdata['partiallylevel0'][$j].",".$finaldata['addlinksDTID'.$j.''][$h]."),";
			// 				}
							
			// 			}	
			// 			$linkdata = rtrim($link, ',');	
						

			// 			$forread = '';
						
			// 			for($k=0;$k<count($linkVTarray);$k++)
			// 			{
			// 				$forread .= "(".$linkVTarray[$k].",'Partially-Sub-Merge',".$linkVTarray[$k].",".$retdata['docidssub'].",'Village / Town','".$retdata['remarksubmerge'][0]."','Sub-Merge'),";


			// 			}

			// 			$forreadqueryappend = rtrim($forread, ',');
						

			// 			$forreadsd = '';
			// 			$linksd = '';
			// 			for($k=0;$k<count($fullmerege);$k++)
			// 			{
			// 				$forreadsd .= "(".$fullmerege[$k].",'Sub-Merge',".$fullmerege[$k].",".$retdata['docidssub'].",'Sub-District','".$retdata['remarksubmerge'][0]."','Sub-Merge'),";

			// 				$linksd .= "(".$retdata['docidssub'].",".$retdata['stids'].",".$retdata['districtgetsub'].",".$fullmerege[$k]."),";



			// 			}

			// 			$forreadqueryappendsd = rtrim($forreadsd, ',');	
			// 			$linksddata = rtrim($linksd, ',');	

			// 			$linksdinsert = 'insert into documentlink'.$_SESSION['activeyears'].' (docids,linkstids,linkdtids,linksdids) VALUES '.$linksddata.'';

			// 			$linkvtinsert = 'insert into documentlink'.$_SESSION['activeyears'].' (docids,linkstids,linkdtids,linksdids,linkvtids) VALUES '.$linkdata.'';

			// 			$insertforread = 'insert into forreaddata'.$_SESSION['activeyears'].' (frfromids,frfromaction,frtoids,frdocids,frcomefrom,othercomment,comeaction) VALUES '.$forreadqueryappendsd.'';

			// 			$insertforreadvt = 'insert into forreaddata'.$_SESSION['activeyears'].' (frfromids,frfromaction,frtoids,frdocids,frcomefrom,othercomment,comeaction) VALUES '.$forreadqueryappend.'';



			// 			$sqlsubmerge =pg_query('update sd'.$_SESSION['activeyears'].' set is_deleted=0 where "SDID" IN ('.implode(',',$fullmerege).')'); 
			// 			$sqlsubmergevt =pg_query('update vt'.$_SESSION['activeyears'].' set is_deleted=0 where "VTID" IN ('.implode(',',$linkVTarray).')'); 

			// 		if($sqlsubmerge==true && $sqlsubmergevt==true)
			// 		{
			// 			pg_query($db,$linksdinsert);
			// 			pg_query($db,$linkvtinsert);
			// 			pg_query($db,$insertforread);
			// 			pg_query($db,$insertforreadvt);

			// 			$vtofsub = 'update vt'.$_SESSION['activeyears'].' set is_deleted=0 where "SDID" IN ('.implode(',',$fullmerege).')';
			// 			pg_query($db,$vtofsub);

			// 			$docupdate = 'update documentdata'.$_SESSION['activeyears'].' set docstatus=1 where "docids"='.$finaldata['docidssub'].'';
			// 			pg_query($db,$docupdate);

			// 			$task = "addsubmergesd";
			// 		}
			// 		else
			// 		{
			// 			$task = "error";
			// 		}

			// 	}
			// 	else
			// 	{	

			// 		// print_r($finaldata);
			// 		// // print_r($retdata);
			// 		// exit;

			// 		$fullmerege = $finaldata['selected_comesub'];
			// 			$forreadsd = '';
			// 			$linksd = '';
			// 			for($k=0;$k<count($fullmerege);$k++)
			// 			{
			// 				$forreadsd .= "(".$fullmerege[$k].",'Sub-Merge',".$fullmerege[$k].",".$finaldata['docidssub'].",'Sub-District','".$finaldata['remarksubmerge'][0]."','Sub-Merge'),";

			// 				$linksd .= "(".$finaldata['docidssub'].",".$finaldata['stids'].",".$finaldata['districtgetsub'].",".$fullmerege[$k]."),";



			// 			}

			// 			$forreadqueryappendsd = rtrim($forreadsd, ',');	
			// 			$linksddata = rtrim($linksd, ',');	
			// 			$linksdinsert = 'insert into documentlink'.$_SESSION['activeyears'].' (docids,linkstids,linkdtids,linksdids) VALUES '.$linksddata.'';

			// 			$insertforread = 'insert into forreaddata'.$_SESSION['activeyears'].' (frfromids,frfromaction,frtoids,frdocids,frcomefrom,othercomment,comeaction) VALUES '.$forreadqueryappendsd.'';
			// 		$sqlsubmerge =pg_query('update sd'.$_SESSION['activeyears'].' set is_deleted=0 where "SDID" IN ('.implode(',',$fullmerege).')'); 
			// 		if($sqlsubmerge==true)
			// 		{
			// 			pg_query($db,$linksdinsert);
						
			// 			pg_query($db,$insertforread);
			// 			$vtofsub = 'update vt'.$_SESSION['activeyears'].' set is_deleted=0 where "SDID" IN ('.implode(',',$fullmerege).')';
			// 			pg_query($db,$vtofsub);
			// 			$docupdate = 'update documentdata'.$_SESSION['activeyears'].' set docstatus=1 where "docids"='.$finaldata['docidssub'].'';
			// 			pg_query($db,$docupdate);
			// 			$task = "addsubmergesd";
			// 		}
			// 		else
			// 		{
			// 			$task = "error";
			// 		}
			// 		// print_r($fullmerege);
			// 	}

			// }
			// else if($finaldata['applyon']=='District' || $finaldata['comefromchecksub']=='District')
			// {
						
			// 		$fullmerege = $finaldata['selected_comesub'];
			// 			$forreadsd = '';
			// 			$linksd = '';
			// 			for($k=0;$k<count($fullmerege);$k++)
			// 			{
			// 				$forreadsd .= "(".$fullmerege[$k].",'Sub-Merge',".$fullmerege[$k].",".$finaldata['docidssub'].",'District','".$finaldata['remarksubmerge'][0]."','Sub-Merge'),";

			// 				$linksd .= "(".$finaldata['docidssub'].",".$finaldata['stids'].",".$fullmerege[$k]."),";



			// 			}

			// 			$forreadqueryappendsd = rtrim($forreadsd, ',');	
			// 			$linksddata = rtrim($linksd, ',');	
			// 			$linksdinsert = 'insert into documentlink'.$_SESSION['activeyears'].' (docids,linkstids,linkdtids) VALUES '.$linksddata.'';

			// 			$insertforread = 'insert into forreaddata'.$_SESSION['activeyears'].' (frfromids,frfromaction,frtoids,frdocids,frcomefrom,othercomment,comeaction) VALUES '.$forreadqueryappendsd.'';
			// 			$sqlsubmerge =pg_query('update dt'.$_SESSION['activeyears'].' set is_deleted=0 where "DTID" IN ('.implode(',',$fullmerege).')'); 
			// 		if($sqlsubmerge==true)
			// 		{
			// 			pg_query($db,$linksdinsert);
						
			// 			pg_query($db,$insertforread);

			// 			$sdofsub = 'update sd'.$_SESSION['activeyears'].' set is_deleted=0 where "DTID" IN ('.implode(',',$fullmerege).')';

			// 			pg_query($db,$sdofsub);

			// 			$vtofsub = 'update vt'.$_SESSION['activeyears'].' set is_deleted=0 where "DTID" IN ('.implode(',',$fullmerege).')';

			// 			pg_query($db,$vtofsub);

			// 			$docupdate = 'update documentdata'.$_SESSION['activeyears'].' set docstatus=1 where "docids"='.$finaldata['docidssub'].'';
			// 			pg_query($db,$docupdate);

			// 			$task = "addsubmergesd";
			// 		}
			// 		else
			// 		{
			// 			$task = "error";
			// 		}
			// }
			// else if($finaldata['applyon']=='State' || $finaldata['comefromchecksub']=='State')
			// {

			// 		$fullmerege = $finaldata['selected_comesub'];
			// 			$forreadsd = '';
			// 			$linksd = '';

			// 			for($k=0;$k<count($fullmerege);$k++)
			// 			{
			// 				$forreadsd .= "(".$fullmerege[$k].",'Sub-Merge',".$fullmerege[$k].",".$finaldata['docidssub'].",'State','".$finaldata['remarksubmerge'][0]."','Sub-Merge'),";

			// 				$linksd .= "(".$finaldata['docidssub'].",".$fullmerege[$k]."),";



			// 			}

			// 			$forreadqueryappendsd = rtrim($forreadsd, ',');	
			// 			$linksddata = rtrim($linksd, ',');	
			// 			$linksdinsert = 'insert into documentlink'.$_SESSION['activeyears'].' (docids,linkstids) VALUES '.$linksddata.'';

			// 			$insertforread = 'insert into forreaddata'.$_SESSION['activeyears'].' (frfromids,frfromaction,frtoids,frdocids,frcomefrom,othercomment,comeaction) VALUES '.$forreadqueryappendsd.'';
			// 		$sqlsubmerge =pg_query('update st'.$_SESSION['activeyears'].' set is_deleted=0 where "STID" IN ('.implode(',',$fullmerege).')'); 
			// 		if($sqlsubmerge==true)
			// 		{
			// 			pg_query($db,$linksdinsert);
						
			// 			pg_query($db,$insertforread);

			// 			$dtofsub = 'update dt'.$_SESSION['activeyears'].' set is_deleted=0 where "STID" IN ('.implode(',',$fullmerege).')';

			// 			pg_query($db,$dtofsub);

						
			// 			$sdofsub = 'update sd'.$_SESSION['activeyears'].' set is_deleted=0 where "STID" IN ('.implode(',',$fullmerege).')';

			// 			pg_query($db,$sdofsub);

			// 			$vtofsub = 'update vt'.$_SESSION['activeyears'].' set is_deleted=0 where "STID" IN ('.implode(',',$fullmerege).')';

			// 			pg_query($db,$vtofsub);

			// 			$docupdate = 'update documentdata'.$_SESSION['activeyears'].' set docstatus=1 where "docids"='.$finaldata['docidssub'].'';
			// 			pg_query($db,$docupdate);

			// 			$task = "addsubmergesd";
			// 		}
			// 		else
			// 		{
			// 			$task = "error";
			// 		}
					
			// }
			// else

	//FM/SB ends

			if($finaldata['applyon']=='Village / Town' || $finaldata['comefromchecksub']=='Village / Town')
			{

				if(isset($finaldata['partiallylevel0']))
				{


						$fullmerege = array_diff($finaldata['selected_comesub0'],$finaldata['partiallylevel0']); // jc_b
						
						$fullmerege = array_values($fullmerege);
						
						$link=''; 
						$forreadsd = '';
						for($j=0;$j<count($finaldata['selected_comesub0']);$j++) // jc_b
						{



								$frcomment='';
								$flag='';

								$frcomment .='<strong style="color:#aa81f3;"><u>State/UT:</u></strong> '.$finaldata['statenewarray'].';  <strong style="color:Green;"><u>District:</u></strong> '.$finaldata['districtnewarray'].';  <strong style="color:blue;"><u>Sub District:</u></strong> '.$finaldata['sddistrictnewarray'].'; ';

								if(in_array($finaldata['selected_comesub0'][$j], $fullmerege)) // jc_b
								{

									if($finaldata['vtLevel'][$j]=='VILLAGE')
									{
										$frcomment .='<strong style="color:#15bed2;"><u>Village:</u></strong> '.$finaldata['namefromtext'].' Submerged into Sea / River / Any Other;';	
									}
									else
									{
										$frcomment .='<strong style="color:#45b0e2;"><u>Town:</u></strong> '.$finaldata['namefromtext'].' Submerged into Sea / River / Any Other;';
									}

										
								$flag='Sub-Merge';
								}
								else
								{

									
									if(trim($finaldata['vtLevel'][$j])=='VILLAGE')
									{
										$frcomment .='<strong style="color:#15bed2;"><u>Village:</u></strong> '.$finaldata['namefromtextlevel'].'  Partially Submerged into Sea / River / Any Other;';	
									}
									else
									{
										$frcomment .='<strong style="color:#45b0e2;"><u>Town:</u></strong> '.$finaldata['namefromtextlevel'].' Partially Submerged into Sea / River / Any Other;';
									}

									// $frcomment .=''.$finaldata['namefromtextlevel'].' '.$finaldata['comefromchecksub'].' Partially Submerged into Sea / River / Any Other';

									$flag='Partially-Sub-Merge';	
								}


								// $frcomment .='<strong style="color:#45b0e2;"><u>Town:</u></strong> No Change; <strong style="color:#15bed2;"><u>Village:</u></strong> No Change;';
							


								$link =array($finaldata['docidssub'],$finaldata['stids'],$finaldata['districtgetsub'],$finaldata['subdistrictgetsub'],$finaldata['selected_comesub0'][$j]); // jc_b

								$linksdinsert = 'insert into documentlink'.$_SESSION['activeyears'].' (docids,linkstids,linkdtids,linksdids,linkvtids) VALUES ($1,$2,$3,$4,$5)';
								pg_query_params($db,$linksdinsert,$link);

								$forreadsd =array($finaldata['selected_comesub0'][$j],$flag,$finaldata['selected_comesub0'][$j],$finaldata['docidssub'],'Village / Town',$finaldata['remarksubmerge'][0],$frcomment,'Sub-Merge',$finaldata['stategetsub'][0],$finaldata['districtgetsub'][0],$finaldata['subdistrictgetsub'][0],$finaldata['selected_comesub0'][$j],$finaldata['stategetsub'][0],$finaldata['districtgetsub'][0],$finaldata['subdistrictgetsub'][0],$finaldata['selected_comesub0'][$j],$finaldata['stategetsub'][0],$finaldata['districtgetsub'][0],$finaldata['subdistrictgetsub'][0],$finaldata['selected_comesub0'][$j],$_SESSION['login_id']); // jc_b

								$insertforread = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","othercomment","frcomment","comeaction","STID","DTID","SDID","VTID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE","STIDR","DTIDR","SDIDR","VTIDR","created_by") VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14,$15,$16,$17,$18,$19,$20,$21)';

									pg_query_params($db,$insertforread,$forreadsd);
							
						}	

						$sqlsubmergevt =pg_query_params($db,'update vt'.$_SESSION['activeyears'].' set is_deleted=$1 where "VTID" = Any(string_to_array($2::text, \',\'::text)::NUMERIC[])',array(0,implode(',',$fullmerege))); 

					
						
					
					$docupdate = 'update documentdata'.$_SESSION['activeyears'].' set docstatus=$1 where "docids"=$2';
						pg_query_params($db,$docupdate,array(1,$finaldata['docidssub']));
					
						$task = "addsubmergesd";
				

				}
				else
				{	
					
						
						$fullmerege = $finaldata['selected_comesub0']; // jc_b
						$forreadsd = '';
						$linksd = '';
						for($k=0;$k<count($fullmerege);$k++)
						{

							$frcomment='';

							$frcomment .='<strong style="color:#aa81f3;"><u>State/UT:</u></strong> '.$finaldata['statenewarray'].';  <strong style="color:Green;"><u>District:</u></strong> '.$finaldata['districtnewarray'].';  <strong style="color:blue;"><u>Sub District:</u></strong> '.$finaldata['sddistrictnewarray'].'; ';


							if($finaldata['vtLevel'][$k]=='VILLAGE')
							{
								// $frcomment .='<strong style="color:#45b0e2;"><u>Town:</u></strong> No Change; ';
								$frcomment .='<strong style="color:#15bed2;"><u>Village:</u></strong> '.$finaldata['namefromtext'].' Submerged into Sea / River / Any Other';
							}
							else
							{
								$frcomment .='<strong style="color:#45b0e2;"><u>Town:</u></strong> '.$finaldata['namefromtext'].' Submerged into Sea / River / Any Other ';
								// $frcomment .='<strong style="color:#15bed2;"><u>Village:</u></strong> No Change; ';
							}
						
							$forreadsd =array($fullmerege[$k],'Sub-Merge',$fullmerege[$k],$finaldata['docidssub'],'Village / Town',$finaldata['remarksubmerge'][0],$frcomment,'Sub-Merge',$finaldata['stategetsub'][0],$finaldata['districtgetsub'][0],$finaldata['subdistrictgetsub'][0],$fullmerege[$k],$finaldata['stategetsub'][0],$finaldata['districtgetsub'][0],$finaldata['subdistrictgetsub'][0],$fullmerege[$k],$finaldata['stategetsub'][0],$finaldata['districtgetsub'][0],$finaldata['subdistrictgetsub'][0],$fullmerege[$k],$_SESSION['login_id']);

							$linksd = array($finaldata['docidssub'],$finaldata['stids'],$finaldata['districtgetsub'],$finaldata['subdistrictgetsub'],$fullmerege[$k]);


							$linksdinsert = 'insert into documentlink'.$_SESSION['activeyears'].' (docids,linkstids,linkdtids,linksdids,linkvtids) VALUES ($1,$2,$3,$4,$5)';
						pg_query_params($db,$linksdinsert,$linksd);
						$insertforread = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","othercomment","frcomment","comeaction","STID","DTID","SDID","VTID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE","STIDR","DTIDR","SDIDR","VTIDR","created_by") VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14,$15,$16,$17,$18,$19,$20,$21)';
						
						
						pg_query_params($db,$insertforread,$forreadsd);

						}

						// $forreadqueryappendsd = rtrim($forreadsd, ',');	
						// $linksddata = rtrim($linksd, ',');	

						//By sahana submerge village 0111
						$auflag_query = 'SELECT auflag FROM unit WHERE auaction = $1 AND aulevel = $2';
						$action = $finaldata['clickpopup'];
						$namefrom = $finaldata['selected_comesub0']; // jc_b

							foreach ($namefrom as $item) {
								$au = pg_query_params($db, $auflag_query, array($action, $finaldata['comefromchecksub']));
						
								if ($au) {
									$row = pg_fetch_assoc($au);
									$auflag_value = $row['auflag'];
									$update_vt = pg_query_params($db, 'UPDATE vt'.$_SESSION['activeyears'].' SET "auflag" = $1, "auaction" = $2 WHERE "VTID" = $3', array($auflag_value, $action, $item));
									if (!$update_vt) {
										echo "UPDATE query failed: " . pg_last_error($db);
									}
								} else {
									echo "SELECT query failed: " . pg_last_error($db);
								}
						}
						
					$sqlsubmerge =pg_query_params($db,'update vt'.$_SESSION['activeyears'].' set is_deleted=$1 where "VTID" = Any(string_to_array($2::text, \',\'::text)::NUMERIC[])',array(0,implode(',',$fullmerege))); 
					$result_rows = pg_affected_rows($sqlsubmerge);
					if($result_rows!=0)
					{
						
						$docupdate = 'update documentdata'.$_SESSION['activeyears'].' set docstatus=$1 where documentdata'.$_SESSION['activeyears'].'."docids"=$2';
						pg_query_params($db,$docupdate,array(1,$finaldata['docidssub']));
						
						$task = "addsubmergesd";
					}
					else
					{
						$task = "error";
					}
					// print_r($fullmerege);
				}

			}
}
else if($_POST['clickbutton']=='Rename')
{
			

	 	if($finaldata['comefromcheck']=='State')
	 	{
		 			
		 		$updatequery='';
		 		$nameor=explode(',',$finaldata['nametotext']);
		 		for($i=0;$i<count($finaldata['newnamem']);$i++)
		 		{
		 			if($finaldata['newnamecheck'][$i]!='')
		 			{
		 				$nameof=$finaldata['newnamecheck'][$i];
		 			}
		 			else
		 			{
						$nameof=$nameor[$i];
		 			}
		 			//$updatequery .="('".ucwords(strtolower($nameof))."','".ucwords(strtoupper($finaldata['StateStatus'][$i]))."',".$finaldata['newnamem'][$i]."),";
		 			$updatequery .="('".($nameof)."','".ucwords(strtoupper($finaldata['StateStatus'][$i]))."',".$finaldata['newnamem'][$i]."),";



		 			$frcomment='';
		 			$stat='';
		 			if($finaldata['StateStatus'][$i]=='ST')
		 				{
		 					$stat = 'State';
		 				}
		 				else
		 				{
		 					$stat = 'Union Territory';
		 				}

		 				$stat1='';
		 			if($finaldata['toStatus'][$i]=='ST')
		 				{
		 					$stat1 = 'State';
		 				}
		 				else
		 				{
		 					$stat1 = 'Union Territory';
		 				}
		 				

		 			if($finaldata['toStatus'][$i]!=$finaldata['StateStatus'][$i])
		 			{
		 				

		 				if($finaldata['newnamecheck'][$i]!='')
		 				{

		 					$frcomment .='<strong style="color:#aa81f3;"><u>State/UT:</u></strong> '.$nameor[$i].' '.$stat1.' Renamed as  '.$finaldata['newnamecheck'][$i].' and Status Changed to '.$stat.';';
		 				}
		 				else
		 				{
							$frcomment .='<strong style="color:#aa81f3;"><u>State/UT:</u></strong> '.$nameor[$i].' '.$stat1.' Status Changed to '.$stat.';';
		 				}
		 			}
		 			else
		 			{
		 				if($finaldata['newnamecheck'][$i]!='')
		 				{

		 					$frcomment .='<strong style="color:#aa81f3;"><u>State/UT:</u></strong> '.$nameor[$i].' '.$stat1.' Renamed as '.$finaldata['newnamecheck'][$i].';';
		 				}
		 				

		 			}
		 			$frcomment .=' <strong style="color:Green;"><u>District:</u></strong> - ; <strong style="color:blue;"><u>Sub District:</u></strong> - ; <strong style="color:#45b0e2;"><u>Town:</u></strong> - ; <strong style="color:#15bed2;"><u>Village:</u></strong> - ;';

					
					$sqlo='Select "STIDR" from st'.$_SESSION['activeyears'].' WHERE "STID"=$1 AND is_deleted=$2';
					$sqlold = pg_query_params($db,$sqlo,array($finaldata['newnamem'][$i],1));
					$sqlda = pg_fetch_array($sqlold);

		 			$forreadqueryapp = array($finaldata['newnamem'][$i],$finaldata['clickpopup'],$finaldata['newnamem'][$i],$finaldata['docids'],$finaldata['comefromcheck'],$frcomment,$finaldata['clickpopup'],$finaldata['newnamem'][$i],$finaldata['newnamem'][$i],$sqlda['STIDR'],$_SESSION['login_id']);

		 			$forreaddata = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","STIDACTIVE","STIDR","created_by") VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11)';
					pg_query_params($db,$forreaddata,$forreadqueryapp);


		 			$linkst=array($finaldata['docids'],$finaldata['newnamem'][$i]);
		 			$insertlink = 'insert into documentlink'.$_SESSION['activeyears'].' (docids,linkstids) VALUES ($1,$2)';	
					pg_query_params($db,$insertlink,$linkst);

		 		}
		 		$updatequeryfinal = rtrim($updatequery, ',');
		 		// $forreadqueryappfinal = rtrim($forreadqueryapp, ',');
		 		// $linkstfinal = rtrim($linkst, ',');

				$qu = 'update st'.$_SESSION['activeyears'].' as t set
				"STName" = c."STName",
				"Status" = c."Status"
				from (values
				'.$updatequeryfinal.'
				) as c("STName","Status", "STID") 
				where c."STID" = t."STID"';
				$re = pg_query($db,$qu);
			 	
			 	if($re==true)
			 	{

			 		pg_query_params($db,'update documentdata'.$_SESSION['activeyears'].' set docstatus=$1 where docids=$2',array(1,$finaldata['docids']));	


					for($kl=0;$kl<count($finaldata['newnamem']);$kl++)
					{
						$aa=array($finaldata['newnamem'][$kl],1);
						  $finalquerydt = 'insert into forreaddata2021 ("frfromids","frfromaction","frtoids","frdocids","frcomefrom",
						"frcomment","is_final","comeaction","STID","DTID","STIDACTIVE","DTIDACTIVE","STIDR","DTIDR","created_by")
						(select "frfromids","frfromaction","frtoids","frdocids","frcomefrom",
						"frcomment","is_final","comeaction",dt21."STIDR"::integer AS "STIDR11",dt21."DTIDR"::integer AS "DTIDR11",dt21."STID",dt21."DTID",dt21."STIDR"::integer,dt21."DTIDR"::integer,"created_by" from dt2021 as dt21 
						LEFT JOIN (select * from forreaddata2021 where "frtoids"=$1 AND "frfromaction"=\'Rename\' ORDER BY "frids" DESC limit 1) as fr21 ON fr21."frtoids"=dt21."STID" 
						 where dt21."STID"=$1 AND dt21."is_deleted"=$2
						)';

						pg_query_params($db,$finalquerydt,$aa);

						$finalquerysd = 'insert into forreaddata2021 ("frfromids","frfromaction","frtoids","frdocids","frcomefrom",
						"frcomment","is_final","comeaction","STID","DTID","SDID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","STIDR","DTIDR","SDIDR","created_by")
						(select "frfromids","frfromaction","frtoids","frdocids","frcomefrom",
						"frcomment","is_final","comeaction",sd21."STIDR"::integer AS "STIDR11",sd21."DTIDR"::integer AS "DTIDR11",sd21."SDIDR"::BIGINT AS "SDIDR11",sd21."STID",sd21."DTID",sd21."SDID",sd21."STIDR"::integer,sd21."DTIDR"::integer,sd21."SDIDR"::BIGINT,"created_by" from sd2021 as sd21 
						LEFT JOIN (select * from forreaddata2021 where "frtoids"=$1 AND "frfromaction"=\'Rename\' ORDER BY "frids" DESC limit 1) as fr21 ON fr21."frtoids"=sd21."STID"
						 where sd21."STID"=$1 AND sd21."is_deleted"=$2
						)';
						pg_query_params($db,$finalquerysd,$aa);

						 $finalqueryvt = 'insert into forreaddata2021 ("frfromids","frfromaction","frtoids","frdocids","frcomefrom",
						"frcomment","is_final","comeaction","STID","DTID","SDID","VTID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE","STIDR","DTIDR","SDIDR","VTIDR","created_by")
						(select "frfromids","frfromaction","frtoids","frdocids","frcomefrom",
						"frcomment","is_final","comeaction",vt21."STIDR"::integer AS "STIDR11",vt21."DTIDR"::integer AS "DTIDR11",vt21."SDIDR"::BIGINT AS "SDIDR11",vt21."VTIDR"::NUMERIC AS "VTIDR11",vt21."STID",vt21."DTID",vt21."SDID",vt21."VTID",vt21."STIDR"::integer,vt21."DTIDR"::integer,vt21."SDIDR"::BIGINT,vt21."VTIDR"::NUMERIC ,"created_by" from vt2021 as vt21 
						LEFT JOIN (select * from forreaddata2021 where "frtoids"=$1 AND "frfromaction"=\'Rename\' ORDER BY "frids" DESC limit 1) as fr21 ON fr21."frtoids"=vt21."STID" where vt21."STID"=$1 AND vt21."is_deleted"=$2
						)';

						pg_query_params($db,$finalqueryvt,$aa);




					}


				$task = "addfinish";
				}
				else
				{
				$task = "error";
				}

	 	}
	 	else if($finaldata['comefromcheck']=='District')
	 	{

				if(isset($finaldata['statenewarray']))
				{
				$statenewarray = explode(',',$finaldata['statenewarray']);
				}

	 		
	 			$nameor=explode(',',$finaldata['nametotext']);
		 		$updatequery='';

		 		for($i=0;$i<count($finaldata['newnamem']);$i++)
		 		{

		 			$updatequery .="('".$finaldata['newnamecheck'][$i]."',".$finaldata['newnamem'][$i].",".$finaldata['statenew'][$i]."),";

		 			$sqlo='Select "STIDR","DTIDR" from dt'.$_SESSION['activeyears'].' WHERE "DTID"=$1 AND is_deleted=$2';
					$sqlold = pg_query_params($db,$sqlo,array($finaldata['newnamem'][$i],1));
					$sqlda = pg_fetch_array($sqlold);
					// print_r($sqlda);
					// exit;
					$frcomment='';
					// rename district level remarks state color modified by shashi
                    $frcomment .='<strong style="color:#aa81f3;"><u>State/UT:</u></strong> '.$statenewarray[$i].'; ';
                    $frcomment .='<strong style="color:Green;"><u>District:</u></strong> '.$nameor[$i].' Renamed as '.$finaldata['newnamecheck'][$i].';';

					$frcomment .=' <strong style="color:blue;"><u>Sub District:</u></strong> - ; <strong style="color:#45b0e2;"><u>Town:</u></strong> - ; <strong style="color:#15bed2;"><u>Village:</u></strong> - ;';


					


		 			$forreadqueryapp =array($finaldata['newnamem'][$i],$finaldata['clickpopup'],$finaldata['newnamem'][$i],$finaldata['docids'],$finaldata['comefromcheck'],$frcomment,$finaldata['clickpopup'],$finaldata['statenew'][$i],$finaldata['newnamem'][$i],$finaldata['statenew'][$i],$finaldata['newnamem'][$i],$finaldata['statenew'][$i],$finaldata['newnamem'][$i],$_SESSION['login_id']);

		 			$linkst =array($finaldata['docids'],$finaldata['statenew'][$i],$finaldata['newnamem'][$i]);

		 			 $forreaddata = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","DTID","STIDACTIVE","DTIDACTIVE","STIDR","DTIDR","created_by") VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14)';
					pg_query_params($db,$forreaddata,$forreadqueryapp);

			 		$insertlink = 'insert into documentlink'.$_SESSION['activeyears'].' (docids,linkstids,linkdtids) VALUES ($1,$2,$3)';	
					pg_query_params($db,$insertlink,$linkst);

		 		}
		 		$updatequeryfinal = rtrim($updatequery, ',');
			 	// 	$forreadqueryappfinal = rtrim($forreadqueryapp, ',');
			 	// 	$linkstfinal = rtrim($linkst, ',');


		 		// echo $forreaddata = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","DTID","STIDACTIVE","DTIDACTIVE","STIDR","DTIDR") VALUES '.$forreadqueryappfinal.'';
		 		// exit;

				$qu = 'update dt'.$_SESSION['activeyears'].' as t set
				"DTName" = c."DTName"
				from (values
				'.$updatequeryfinal.'
				) as c("DTName", "DTID","STID") 
				where c."DTID" = t."DTID" AND c."STID"=t."STID"';
			 $re = pg_query($db,$qu);
			 	
			 	if($re==true)
			 	{

			 		

					pg_query_params($db,'update documentdata'.$_SESSION['activeyears'].' set docstatus=$1 where docids=$2',array(1,$finaldata['docids']));	

					for($kl=0;$kl<count($finaldata['newnamem']);$kl++)
					{
						$arra=array();
						$arra=array($finaldata['newnamem'][$kl],1);

					 $finalquerysd = 'insert into forreaddata2021 ("frfromids","frfromaction","frtoids","frdocids","frcomefrom",
					"frcomment","is_final","comeaction","STID","DTID","SDID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","STIDR","DTIDR","SDIDR","created_by")
					(select "frfromids","frfromaction","frtoids","frdocids","frcomefrom",
					"frcomment","is_final","comeaction",sd21."STIDR"::integer AS "STIDR11",sd21."DTIDR"::integer AS "DTIDR11",sd21."SDIDR"::BIGINT AS "SDIDR11",sd21."STID",sd21."DTID",sd21."SDID",sd21."STIDR"::integer,sd21."DTIDR"::integer,sd21."SDIDR"::BIGINT,"created_by" from sd2021 as sd21 
					LEFT JOIN (select * from forreaddata2021 where "frtoids"=$1 AND "frfromaction"=\'Rename\' ORDER BY "frids" DESC LIMIT 1) as fr21 ON fr21."frtoids"=sd21."DTID"
					where sd21."DTID"=$1 AND sd21."is_deleted"=$2
					)';
					pg_query_params($db,$finalquerysd,$arra);

					$finalqueryvt = 'insert into forreaddata2021 ("frfromids","frfromaction","frtoids","frdocids","frcomefrom",
					"frcomment","is_final","comeaction","STID","DTID","SDID","VTID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE","STIDR","DTIDR","SDIDR","VTIDR","created_by")
					(select "frfromids","frfromaction","frtoids","frdocids","frcomefrom",
					"frcomment","is_final","comeaction",vt21."STIDR"::integer AS "STIDR11",vt21."DTIDR"::integer AS "DTIDR11",vt21."SDIDR"::BIGINT AS "SDIDR11",vt21."VTIDR"::NUMERIC AS "VTIDR11",vt21."STID",vt21."DTID",vt21."SDID",vt21."VTID",vt21."STIDR"::integer,vt21."DTIDR"::integer,vt21."SDIDR"::BIGINT,vt21."VTIDR"::NUMERIC,"created_by" from vt2021 as vt21 
					LEFT JOIN (select * from forreaddata2021 where "frtoids"=$1 AND "SDID"!=0 AND "frfromaction"=\'Rename\' ORDER BY "frids" DESC LIMIT 1) as fr21 ON fr21."frtoids"=vt21."DTID" 
					where vt21."DTID"=$1 AND vt21."is_deleted"=$2
					)';
					
					pg_query_params($db,$finalqueryvt,$arra);
					}


				$task = "addfinish";
				}
				else
				{
				$task = "error";
				}

	 	}
	 	else if($finaldata['comefromcheck']=='Sub-District')
	 	{

	 		if(isset($finaldata['statenewarray']))
						{
						$statenewarray = explode(',',$finaldata['statenewarray']);
						}

						if(isset($finaldata['districtnewarray']))
						{
						$districtnewarray = explode(',',$finaldata['districtnewarray']);
						}


	 		$nameor=explode(',',$finaldata['nametotext']);
		 		$updatequery='';

		 		for($i=0;$i<count($finaldata['newnamem']);$i++)
		 		{
		 			$updatequery .="('".$finaldata['newnamecheck'][$i]."',".$finaldata['newnamem'][$i].",".$finaldata['statenew'][$i].",".$finaldata['districtnew'][$i]."),";

		 			$sqlo='Select "STIDR","DTIDR","SDIDR" from sd'.$_SESSION['activeyears'].' WHERE "SDID"=$1 AND is_deleted=$2';
					$sqlold = pg_query_params($db,$sqlo,array($finaldata['newnamem'][$i],1));
					$sqlda = pg_fetch_array($sqlold);

					$frcomment='';
					$frcomment .='<strong style="color:#aa81f3;"><u>State/UT:</u></strong> '.$statenewarray[$i].'; <strong style="color:Green;"><u>District:</u></strong> '.$districtnewarray[$i].'; ';

					//Rename for single subdistrict solved by shashi
                    $frcomment .='<strong style="color:blue;"><u>Sub District:</u></strong> '.$nameor[$i].' Renamed as '.$finaldata['newnamecheck'][$i].';'; 
					$frcomment .=' <strong style="color:#45b0e2;"><u>Town:</u></strong> - ; <strong style="color:#15bed2;"><u>Village:</u></strong> - ;';

													
					$str = explode(',',$sqlda['STIDR']);
					$dtr = explode(',',$sqlda['DTIDR']);
					$sdtr = explode(',',$sqlda['SDIDR']);

					for($hj=0;$hj<count($str);$hj++)
					{
						
						$forreadqueryapp =array($finaldata['newnamem'][$i],$finaldata['clickpopup'],$finaldata['newnamem'][$i],$finaldata['docids'],$finaldata['comefromcheck'],$frcomment,$finaldata['clickpopup'],$finaldata['statenew'][$i],$finaldata['districtnew'][$i],$finaldata['newnamem'][$i],$finaldata['statenew'][$i],$finaldata['districtnew'][$i],$finaldata['newnamem'][$i],$str[$hj],$dtr[$hj],$sdtr[$hj],$_SESSION['login_id']);

						 $forreaddata = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","DTID","SDID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","STIDR","DTIDR","SDIDR","created_by") VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14,$15,$16,$17)';
					pg_query_params($db,$forreaddata,$forreadqueryapp);



					}
											

		 			

		 			$linkst =array($finaldata['docids'],$finaldata['statenew'][$i],$finaldata['districtnew'][$i],$finaldata['newnamem'][$i]);

		 			$insertlink = 'insert into documentlink'.$_SESSION['activeyears'].' (docids,linkstids,linkdtids,linksdids) VALUES ($1,$2,$3,$4)';	
					pg_query_params($db,$insertlink,$linkst);
					

		 		}
		 		$updatequeryfinal = rtrim($updatequery, ',');
		 		// $forreadqueryappfinal = rtrim($forreadqueryapp, ',');
		 		// $linkstfinal = rtrim($linkst, ',');

				$qu = 'update sd'.$_SESSION['activeyears'].' as t set
				"SDName" = c."SDName"
				from (values
				'.$updatequeryfinal.'
				) as c("SDName","SDID","STID","DTID") 
				where c."DTID" = t."DTID" AND c."STID"=t."STID" AND c."SDID"=t."SDID"';
			 $re = pg_query($db,$qu);
			 	
			 	if($re==true)
			 	{
				

					pg_query_params($db,'update documentdata'.$_SESSION['activeyears'].' set docstatus=$1 where docids=$2',array(1,$finaldata['docids']));	

					for($kl=0;$kl<count($finaldata['newnamem']);$kl++)
					{
						$arr=array();
						$arr=array($finaldata['newnamem'][$kl],1);
					  $finalqueryvt = 'insert into forreaddata2021 ("frfromids","frfromaction","frtoids","frdocids","frcomefrom",
						"frcomment","is_final","comeaction","STID","DTID","SDID","VTID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE","STIDR","DTIDR","SDIDR","VTIDR","created_by")
						(select "frfromids","frfromaction","frtoids","frdocids","frcomefrom",
						"frcomment","is_final","comeaction",vt21."STIDR"::integer AS "STIDR11",vt21."DTIDR"::integer AS "DTIDR11",vt21."SDIDR"::BIGINT AS "SDIDR11",vt21."VTIDR"::NUMERIC AS "VTIDR11",vt21."STID",vt21."DTID",vt21."SDID",vt21."VTID",vt21."STIDR"::integer,vt21."DTIDR"::integer,vt21."SDIDR"::BIGINT,vt21."VTIDR"::NUMERIC,"created_by" from vt2021 as vt21 
						LEFT JOIN (select * from forreaddata2021 where "frtoids"=$1 AND "frfromaction"=\'Rename\' ORDER BY "frids" DESC limit 1) as fr21 ON fr21."frtoids"=vt21."SDID"
						where vt21."SDID"=$1 AND vt21."is_deleted"=$2
						)';
					
						pg_query_params($db,$finalqueryvt,$arr);
					}

				$task = "addfinish";
				}
				else
				{
				$task = "error";
				}

	 	}
	 	else if($finaldata['comefromcheck']=='Village / Town')
	 	{
	 			
	 			if(isset($finaldata['statenewarray']))
						{
						$statenewarray = explode(',',$finaldata['statenewarray']);
						}

						if(isset($finaldata['districtnewarray']))
						{
						$districtnewarray = explode(',',$finaldata['districtnewarray']);
						}

						if(isset($finaldata['sddistrictnewarray']))
						{
						$sddistrictnewarray = explode(',',$finaldata['sddistrictnewarray']);
						}

	 		
	 			$updatequery='';
	 			$updatequery1='';
				$nameor=explode(',',$finaldata['nametotext']);
		 		for($i=0;$i<count($finaldata['newnamem']);$i++)
		 		{
		 			$frcomment='';
					$vstatus= '';
		 			$stat='';
					$stat2='';
					$stat3='';
		 			if($finaldata['vStateStatus'][$i]  =='VILLAGE')
		 				{
		 					$stat = 'Village';
		 				}
		 				else
		 				{
		 					$stat = 'Town';
		 				}

		 				$stat1='';
		 			if($finaldata['vlevel'][$i]=='VILLAGE')
		 				{
		 					$stat1 = 'VILLAGE';
		 				}
		 				else
		 				{
		 					$stat1 = 'TOWN';
		 				}


		
						

		 			$frcomment .='<strong style="color:#aa81f3;"><u>State/UT:</u></strong> '.$statenewarray[$i].'; <strong style="color:Green;"><u>District:</u></strong>'.$districtnewarray[$i].'; <strong style="color:blue;"><u>Sub District:</u></strong> '.$sddistrictnewarray[$i].';';

		 			if($finaldata['vlevel'][$i]!=$finaldata['vStateStatus'][$i])
		 			{
		 				
                         //Defect ID JC_8  solved by shashi
		 				if($finaldata['vlevel'][$i]=='VILLAGE')
		 				{
								if($finaldata['newnamecheck'][$i]!='' && $finaldata['vstatus'][$i]!='' )
								{
								// $frcomment .=' <strong style="color:#45b0e2;"><u>Town:</u></strong> - ;';

                                //Defect ID JC_8  solved by shashi
								$frcomment .=' <strong style="color:#15bed2;"><u>Village:</u></strong> '.$nameor[$i].' Renamed as'.$finaldata['newnamecheck'][$i].' and Status Changed to '.$stat.' - '.$finaldata['vstatus'][$i].';';
								}
								else
								{
								// 	$frcomment .=' <strong style="color:#45b0e2;"><u>Town:</u></strong> No Change;';
								$frcomment .=' <strong style="color:#15bed2;"><u>Village:</u></strong> '.$nameor[$i].' Status Change to '.$stat.' - '.$finaldata['vstatus'][$i].';';
								}

		 				}
		 				else
		 				{
								if($finaldata['newnamecheck'][$i]!='' && $finaldata['vstatus'][$i]!=''  )
								{
                               //Defect ID JC_8  solved by shashi
								$frcomment .=' <strong style="color:#45b0e2;"><u>Town:</u></strong> '.$nameor[$i].' Renamed as '.$finaldata['newnamecheck'][$i].' and Status Changed to '.$stat.' - '.$finaldata['vstatus'][$i].';';
								// $frcomment .=' <strong style="color:#15bed2;"><u>Village:</u></strong> No Change;';
								}
								else
								{
									 //Defect ID JC_8  solved by shashi
								$frcomment .=' <strong style="color:#45b0e2;"><u>Town:</u></strong> '.$nameor[$i].' Status Changed to '.$stat.' - '.$finaldata['vstatus'][$i].';';
								// $frcomment .=' <strong style="color:#15bed2;"><u>Village:</u></strong> No Change;';
								}

		 				}


		 				
		 			}
		 			else
		 			{
		 				if($finaldata['ovstatus'][$i]!=$finaldata['vstatus'][$i])
		 				{
		 						if($finaldata['vlevel'][$i]=='VILLAGE')
		 						{
                                   //Defect ID JC_8  solved by shashi
									if($finaldata['newnamecheck'][$i]!='' && $finaldata['vstatus'][$i]!='')
									{
									// 	$frcomment .=' <strong style="color:#45b0e2;"><u>Town:</u></strong> No Change;';
                             
									$frcomment .=' <strong style="color:#15bed2;"><u>Village:</u></strong> '.$nameor[$i].' Status Changed to '.$finaldata['vstatus'][$i].' and Renamed as '.$finaldata['newnamecheck'][$i].';';
									}
									else
									{
									// 	$frcomment .=' <strong style="color:#45b0e2;"><u>Town:</u></strong> No Change;';
									 //Defect ID JC_8  solved by shashi
									$frcomment .=' <strong style="color:#15bed2;"><u>Village:</u></strong> '.$nameor[$i].' Status Changed to '.$finaldata['vstatus'][$i].';';
									}


		 						}
		 						else
		 						{
									   //Defect ID JC_8  solved by shashi
									if($finaldata['newnamecheck'][$i]!='' && $finaldata['vstatus'][$i]!='')
									{

									$frcomment .=' <strong style="color:#45b0e2;"><u>Town:</u></strong>'.$nameor[$i].' Status Changed to '.$finaldata['vstatus'][$i].' and Renamed as '.$finaldata['newnamecheck'][$i].';';
									// $frcomment .=' <strong style="color:#15bed2;"><u>Village:</u></strong> No Change;';
									}
									else
									{
									$frcomment .=' <strong style="color:#45b0e2;"><u>Town:</u></strong>'.$nameor[$i].' Status Changed to '.$finaldata['vstatus'][$i].';';
									// $frcomment .=' <strong style="color:#15bed2;"><u>Village:</u></strong> No Change;';
									}
		 						}

								


		 				}
		 				else
		 				{
		 					if($finaldata['vlevel'][$i]=='VILLAGE')
		 						{
		 							// $frcomment .=' <strong style="color:#45b0e2;"><u>Town:</u></strong> No Change;';
									$frcomment .=' <strong style="color:#15bed2;"><u>Village:</u></strong> '.$nameor[$i].' Renamed as '.$finaldata['newnamecheck'][$i].'';

		 						}
		 						else
		 						{
		 							// $frcomment .=' <strong style="color:#45b0e2;"><u>Town:</u></strong> No Change;';
		 							$frcomment .=' <strong style="color:#15bed2;"><u>Town:</u></strong> '.$nameor[$i].' Renamed as '.$finaldata['newnamecheck'][$i].'';
		 						}
		 					
		 				}



		 				
		 				

		 			}


						




		 			if($finaldata['newnamecheck'][$i]!='')
		 			{
		 					$updatequery .="('".$finaldata['newnamecheck'][$i]."','".ucwords(strtoupper($finaldata['vStateStatus'][$i]))."','".ucwords(strtoupper($finaldata['vstatus'][$i]))."',".$finaldata['newnamem'][$i].",".$finaldata['statenew'][$i].",".$finaldata['districtnew'][$i].",".$finaldata['sddistrictnew'][$i]."),";
		 			}
		 			else
		 			{
						$updatequery1 .="('".ucwords(strtoupper($finaldata['vStateStatus'][$i]))."','".ucwords(strtoupper($finaldata['vstatus'][$i]))."',".$finaldata['newnamem'][$i].",".$finaldata['statenew'][$i].",".$finaldata['districtnew'][$i].",".$finaldata['sddistrictnew'][$i]."),";
		 			}
		 			

					$sqlo='Select "STIDR","DTIDR","SDIDR","VTIDR" from vt'.$_SESSION['activeyears'].' WHERE "STID"=$1 AND "DTID"=$2 AND "SDID"=$3 AND "VTID"=$4 AND is_deleted=$5';
					$sqlold = pg_query_params($db,$sqlo,array($finaldata['statenew'][$i],$finaldata['districtnew'][$i],$finaldata['sddistrictnew'][$i],$finaldata['newnamem'][$i],1));
					$sqlda = pg_fetch_array($sqlold);
		 		
					$st = explode(',',$sqlda['STIDR']);
					$dt = explode(',',$sqlda['DTIDR']);
					$sd = explode(',',$sqlda['SDIDR']);
					$vt = explode(',',$sqlda['VTIDR']);

					for($g=0;$g<count($st);$g++)
					{
				$forreadqueryapp =array($finaldata['newnamem'][$i],$finaldata['clickpopup'],$finaldata['newnamem'][$i],$finaldata['docids'],$finaldata['comefromcheck'],$frcomment,$finaldata['clickpopup'],$finaldata['statenew'][$i],$finaldata['districtnew'][$i],$finaldata['sddistrictnew'][$i],$finaldata['newnamem'][$i],$finaldata['statenew'][$i],$finaldata['districtnew'][$i],$finaldata['sddistrictnew'][$i],$finaldata['newnamem'][$i],$st[$g],$dt[$g],$sd[$g],$vt[$g],$_SESSION['login_id']);

				$forreaddata = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","DTID","SDID","VTID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE","STIDR","DTIDR","SDIDR","VTIDR","created_by") VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14,$15,$16,$17,$18,$19,$20)';
					pg_query_params($db,$forreaddata,$forreadqueryapp);

			 	
					}

		 			

		 			$linkst =array($finaldata['docids'],$finaldata['statenew'][$i],$finaldata['districtnew'][$i],$finaldata['sddistrictnew'][$i],$finaldata['newnamem'][$i]);
		 				$insertlink = 'insert into documentlink'.$_SESSION['activeyears'].' (docids,linkstids,linkdtids,linksdids) VALUES ($1,$2,$3,$4,$5)';	
					pg_query_params($db,$insertlink,$linkst);

		 		}
		 		// echo "JIGGGG";
		 		// exit;
		 		$updatequeryfinal = rtrim($updatequery, ',');
		 		$updatequeryfinal1 = rtrim($updatequery1, ',');
		 		// $forreadqueryappfinal = rtrim($forreadqueryapp, ',');
		 		// $linkstfinal = rtrim($linkst, ',');
		 	
		 		
		 		if($updatequeryfinal!='')
		 		{
		 			$qu = 'update vt'.$_SESSION['activeyears'].' as t set
				"VTName" = c."VTName",
				"Level" = c."Level",
				"Status" = c."Status"
				from (values
				'.$updatequeryfinal.'
				) as c("VTName","Level","Status","VTID","STID","DTID","SDID") 
				where c."DTID" = t."DTID" AND c."STID"=t."STID" AND c."SDID"=t."SDID" AND c."VTID"=t."VTID"';
			 $re = pg_query($db,$qu);
				//  echo "+++++++++++++++++++".$re;
		 		}

		 		if($updatequeryfinal1!='')
		 		{
		 			$qu1 = 'update vt'.$_SESSION['activeyears'].' as t set
				"Level" = c."Level",
				"Status" = c."Status"
				from (values
				'.$updatequeryfinal1.'
				) as c("Level","Status","VTID","STID","DTID","SDID") 
				where c."DTID" = t."DTID" AND c."STID"=t."STID" AND c."SDID"=t."SDID" AND c."VTID"=t."VTID"';
			
			 $re = pg_query($db,$qu1);
		 		}


				//	echo "++++++".$re;
			 	
			 	if($re==true)
			 	{

			 	 

					pg_query_params($db,'update documentdata'.$_SESSION['activeyears'].' set docstatus=$1 where docids=$2',array(1,$finaldata['docids']));	

				$task = "addfinish";
				}
				else
				{
				$task = "error";
				}

	 	}
}


// deletion code added
else if($_POST['clickbutton']=='Deletion'){
	if($finaldata['comefromcheck']=='Village / Town')
	 	{
	 			
	 			if(isset($finaldata['statenewarray']))
						{
						$statenewarray = explode(',',$finaldata['statenewarray']);
						}

						if(isset($finaldata['districtnewarray']))
						{
						$districtnewarray = explode(',',$finaldata['districtnewarray']);
						}

						if(isset($finaldata['sddistrictnewarray']))
						{
						$sddistrictnewarray = explode(',',$finaldata['sddistrictnewarray']);
						}

	 		
	 			$updatequery='';
	 			$updatequery1='';
				$nameor=explode(',',$finaldata['nametotext']);
		 		for($i=0;$i<count($finaldata['newnamem']);$i++)
		 		{
		 			$frcomment='';
		 			$stat='';
		 			if($finaldata['vStateStatus'][$i]=='VILLAGE')
		 				{
		 					$stat = 'Village';
		 				}
		 				else
		 				{
		 					$stat = 'Town';
		 				}

		 				$stat1='';
		 			if($finaldata['vlevel'][$i]=='VILLAGE')
		 				{
		 					$stat1 = 'VILLAGE';
		 				}
		 				else
		 				{
		 					$stat1 = 'TOWN';
		 				}


		 				

		 				

		 			$frcomment .='<strong style="color:#aa81f3;"><u>State/UT:</u></strong> '.$statenewarray[$i].'; <strong style="color:Green;"><u>District:</u></strong>'.$districtnewarray[$i].'; <strong style="color:blue;"><u>Sub District:</u></strong> '.$sddistrictnewarray[$i].';';

		 			if($finaldata['vlevel'][$i]!=$finaldata['vStateStatus'][$i])
		 			{
		 				

		 				if($finaldata['vlevel'][$i]=='VILLAGE')
		 				{
								if($finaldata['newnamecheck'][$i]!='')
								{
								// $frcomment .=' <strong style="color:#45b0e2;"><u>Town:</u></strong> - ;';


								$frcomment .=' <strong style="color:#15bed2;"><u>Village:</u></strong> '.$nameor[$i].' is Deleted;';
								}
								else
								{
								// 	$frcomment .=' <strong style="color:#45b0e2;"><u>Town:</u></strong> No Change;';
								$frcomment .=' <strong style="color:#15bed2;"><u>Village:</u></strong> '.$nameor[$i].'is Deleted;';
								}

		 				}
		 				else
		 				{
								if($finaldata['newnamecheck'][$i]!='')
								{

								$frcomment .=' <strong style="color:#45b0e2;"><u>Town:</u></strong> '.$nameor[$i].' is Deleted';
								// $frcomment .=' <strong style="color:#15bed2;"><u>Village:</u></strong> No Change;';
								}
								else
								{
								$frcomment .=' <strong style="color:#45b0e2;"><u>Town:</u></strong> '.$nameor[$i].' is Deleted';
								// $frcomment .=' <strong style="color:#15bed2;"><u>Village:</u></strong> No Change;';
								}

		 				}


		 				
		 			}
		 			else
		 			{
		 				if($finaldata['ovstatus'][$i]!=$finaldata['vstatus'][$i])
		 				{
		 						if($finaldata['vlevel'][$i]=='VILLAGE')
		 						{

									if($finaldata['newnamecheck'][$i]!='')
									{
									// 	$frcomment .=' <strong style="color:#45b0e2;"><u>Town:</u></strong> No Change;';

									$frcomment .=' <strong style="color:#15bed2;"><u>Village:</u></strong> '.$nameor[$i].' is Deleted;';
									}
									else
									{
									// 	$frcomment .=' <strong style="color:#45b0e2;"><u>Town:</u></strong> No Change;';
									$frcomment .=' <strong style="color:#15bed2;"><u>Village:</u></strong> '.$nameor[$i].' is Deleted;';
									}


		 						}
		 						else
		 						{
									if($finaldata['newnamecheck'][$i]!='')
									{

									$frcomment .=' <strong style="color:#45b0e2;"><u>Town:</u></strong>'.$nameor[$i].' is Deleted;';
									// $frcomment .=' <strong style="color:#15bed2;"><u>Village:</u></strong> No Change;';
									}
									else
									{
									$frcomment .=' <strong style="color:#45b0e2;"><u>Town:</u></strong>'.$nameor[$i].' is Deleted;';
									// $frcomment .=' <strong style="color:#15bed2;"><u>Village:</u></strong> No Change;';
									}
		 						}

								


		 				}
		 				else
		 				{
		 					if($finaldata['vlevel'][$i]=='VILLAGE')
		 						{
		 							// $frcomment .=' <strong style="color:#45b0e2;"><u>Town:</u></strong> No Change;';
									$frcomment .=' <strong style="color:#15bed2;"><u>Village:</u></strong> '.$nameor[$i].' is Deleted';

		 						}
		 						else
		 						{
		 							// $frcomment .=' <strong style="color:#45b0e2;"><u>Town:</u></strong> No Change;';
		 							$frcomment .=' <strong style="color:#15bed2;"><u>Village:</u></strong> '.$nameor[$i].' is Deleted';
		 						}
		 					
		 				}



		 				
		 				

		 			}


						




		 			if($finaldata['newnamecheck'][$i]!='')
		 			{
		 					$updatequery .="('".$finaldata['newnamecheck'][$i]."','".ucwords(strtoupper($finaldata['vStateStatus'][$i]))."','".ucwords(strtoupper($finaldata['vstatus'][$i]))."',".$finaldata['newnamem'][$i].",".$finaldata['statenew'][$i].",".$finaldata['districtnew'][$i].",".$finaldata['sddistrictnew'][$i]."),";
		 			}
		 			else
		 			{
						$updatequery1 .="('".ucwords(strtoupper($finaldata['vStateStatus'][$i]))."','".ucwords(strtoupper($finaldata['vstatus'][$i]))."',".$finaldata['newnamem'][$i].",".$finaldata['statenew'][$i].",".$finaldata['districtnew'][$i].",".$finaldata['sddistrictnew'][$i].",0),";
		 			}
		 			

					$sqlo='Select "STIDR","DTIDR","SDIDR","VTIDR" from vt'.$_SESSION['activeyears'].' WHERE "STID"=$1 AND "DTID"=$2 AND "SDID"=$3 AND "VTID"=$4 AND is_deleted=$5';
					$sqlold = pg_query_params($db,$sqlo,array($finaldata['statenew'][$i],$finaldata['districtnew'][$i],$finaldata['sddistrictnew'][$i],$finaldata['newnamem'][$i],1));
					$sqlda = pg_fetch_array($sqlold);
		 		
					$st = explode(',',$sqlda['STIDR']);
					$dt = explode(',',$sqlda['DTIDR']);
					$sd = explode(',',$sqlda['SDIDR']);
					$vt = explode(',',$sqlda['VTIDR']);

					for($g=0;$g<count($st);$g++)
					{
				$forreadqueryapp =array($finaldata['newnamem'][$i],$finaldata['clickpopup'],$finaldata['newnamem'][$i],$finaldata['docids'],$finaldata['comefromcheck'],$frcomment,$finaldata['clickpopup'],$finaldata['statenew'][$i],$finaldata['districtnew'][$i],$finaldata['sddistrictnew'][$i],$finaldata['newnamem'][$i],$finaldata['statenew'][$i],$finaldata['districtnew'][$i],$finaldata['sddistrictnew'][$i],$finaldata['newnamem'][$i],$st[$g],$dt[$g],$sd[$g],$vt[$g],$_SESSION['login_id']);

				$forreaddata = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","DTID","SDID","VTID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE","STIDR","DTIDR","SDIDR","VTIDR","created_by") VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14,$15,$16,$17,$18,$19,$20)';
					pg_query_params($db,$forreaddata,$forreadqueryapp);

			 	
					}

		 			

		 			$linkst =array($finaldata['docids'],$finaldata['statenew'][$i],$finaldata['districtnew'][$i],$finaldata['sddistrictnew'][$i],$finaldata['newnamem'][$i]);
		 				$insertlink = 'insert into documentlink'.$_SESSION['activeyears'].' (docids,linkstids,linkdtids,linksdids) VALUES ($1,$2,$3,$4,$5)';	
					pg_query_params($db,$insertlink,$linkst);

		 		}
		 		// echo "JIGGGG";
		 		// exit;
		 		$updatequeryfinal = rtrim($updatequery, ',');
		 		$updatequeryfinal1 = rtrim($updatequery1, ',');
		 		// $forreadqueryappfinal = rtrim($forreadqueryapp, ',');
		 		// $linkstfinal = rtrim($linkst, ',');
		 	
		 		
		 		if($updatequeryfinal!='')
		 		{
		 			$qu = 'update vt'.$_SESSION['activeyears'].' as t set
				"VTName" = c."VTName",
				"Level" = c."Level",
				"Status" = c."Status"
				from (values
				'.$updatequeryfinal.'
				) as c("VTName","Level","Status","VTID","STID","DTID","SDID") 
				where c."DTID" = t."DTID" AND c."STID"=t."STID" AND c."SDID"=t."SDID" AND c."VTID"=t."VTID"';
			 $re = pg_query($db,$qu);
				//  echo "+++++++++++++++++++".$re;
		 		}

		 		if($updatequeryfinal1!='')
		 		{
		 			$qu1 = 'update vt'.$_SESSION['activeyears'].' as t set
				"Level" = c."Level",
				"Status" = c."Status",
				"is_deleted"=c."is_deleted"
				from (values
				'.$updatequeryfinal1.'
				) as c("Level","Status","VTID","STID","DTID","SDID","is_deleted") 
				where c."DTID" = t."DTID" AND c."STID"=t."STID" AND c."SDID"=t."SDID" AND c."VTID"=t."VTID"';
			
			 $re = pg_query($db,$qu1);
		 		}


				//	echo "++++++".$re;
			 	
			 	if($re==true)
			 	{

			 	 

					pg_query_params($db,'update documentdata'.$_SESSION['activeyears'].' set docstatus=$1 where docids=$2',array(1,$finaldata['docids']));	

				$task = "addfinish";
				}
				else
				{
				$task = "error";
				}

	 	}

}




else if($_POST['clickbutton']=='Reshuffle')
{

	 	if($finaldata['comefromcheck']=='Sub-District')
	 	{

				if(isset($finaldata['statenewarray']))
				{
				$statenewarray = explode(',',$finaldata['statenewarray']);
				}

				if(isset($finaldata['districtnewarray']))
				{
				$districtnewarray = explode(',',$finaldata['districtnewarray']);
				}



	 			$updatequery='';


		 		for($i=0;$i<count($finaldata['namefrom']);$i++)
		 		{
		 			
					$sqlo='Select "STIDR","DTIDR","SDIDR" from sd'.$_SESSION['activeyears'].' WHERE "SDID"='.$finaldata['namefrom'][$i].' AND is_deleted=$1';
					$sqlold = pg_query_params($db,$sqlo,array(1));
					$sqlda = pg_fetch_array($sqlold);

					$frcomment='';
					// FR multiple SB level State & Dist name display
					$frcomment .='<strong style="color:#aa81f3;"><u>State/UT:</u></strong> '.$statenewarray[0].'; ';
					$frcomment .='<strong style="color:Green;"><u>District:</u></strong> '.$districtnewarray[0].'; ';

					$frcomment .='<strong style="color:blue;"><u>Sub District:</u></strong> '.$finaldata['namefromtext'].' Moved / Reshuffled to '.$finaldata['namefrompre'].' District;';

					
					$frcomment .=' <strong style="color:#45b0e2;"><u>Town:</u></strong> - ; <strong style="color:#15bed2;"><u>Village:</u></strong> - ;';

					$str = explode(',',$sqlda['STIDR']);
					$dtr = explode(',',$sqlda['DTIDR']);
					$sdtr = explode(',',$sqlda['SDIDR']);



					//By sahana reshuffle subdistrict one to one, many to one 0111 2811
					$auflag_query = 'SELECT auflag FROM unit WHERE auaction = $1 AND aulevel = $2';
					$actions = $finaldata['action'];
					$namefrom_values = $finaldata['namefrom'];
					foreach ($actions as $key => $action) {
						$namefrom = $namefrom_values[$key];
						$au = pg_query_params($db, $auflag_query, array($action, $finaldata['comefromcheck']));

						if ($au) {
							$row = pg_fetch_assoc($au);
							$auflag_value = $row['auflag'];

							$update_vt = pg_query_params($db, 'UPDATE vt'.$_SESSION['activeyears'].' SET "auflag" = $1, "auaction" = $2 WHERE "SDID" = $3', array($auflag_value, $action, $namefrom));
							$update_sd = pg_query_params($db, 'UPDATE sd'.$_SESSION['activeyears'].' SET "auflag" = $1, "auaction" = $2 WHERE "SDID" = $3', array($auflag_value, $action, $namefrom));

							if (!$update_sd || !$update_vt) {
								echo "UPDATE query failed: " . pg_last_error($db);
							}
						} else {
							echo "SELECT query failed: " . pg_last_error($db);
						}
					}


					for($hj=0;$hj<count($str);$hj++)
					{
						$forreadqueryapp =array();
					
						$forreadqueryapp =array($finaldata['namefrom'][$i],$finaldata['clickpopup'],$finaldata['namefrom'][$i],$finaldata['docids'],$finaldata['comefromcheck'],$frcomment,$finaldata['clickpopup'],$finaldata['fromstate'][$i],$finaldata['districtget'][$i],$finaldata['namefrom'][$i],$finaldata['statenew'][0],$finaldata['districtnew'][0],$finaldata['namefrom'][$i],$str[$hj],$dtr[$hj],$sdtr[$hj],$_SESSION['login_id']);

							 $forreaddata = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","DTID","SDID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","STIDR","DTIDR","SDIDR","created_by") VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14,$15,$16,$17)';
			 				 pg_query_params($db,$forreaddata,$forreadqueryapp);


					}


		 			

				 		$linkst =array($finaldata['docids'],$finaldata['fromstate'][$i],$finaldata['districtget'][$i],$finaldata['namefrom'][$i]);

				 		$insertlink = 'insert into documentlink'.$_SESSION['activeyears'].' (docids,linkstids,linkdtids,linksdids) VALUES ($1,$2,$3,$4)';	
					pg_query_params($db,$insertlink,$linkst);

				 		
				 		$linkst1 =array($finaldata['docids'],$finaldata['statenew'][0],$finaldata['districtnew'][0],$finaldata['namefrom'][$i]);

				 		$insertlink1 = 'insert into documentlink'.$_SESSION['activeyears'].' (docids,linkstids,linkdtids,linksdids) VALUES ($1,$2,$3,$4)';		
					pg_query_params($db,$insertlink1,$linkst1);
		 		}

		 		
		 				// $linkstfinaldata = $linkst."".$linkst1;
		 		
		 				// $linkstfinal1 = rtrim($linkstfinaldata, ',');
		 		

			 		

					pg_query_params($db,'update documentdata'.$_SESSION['activeyears'].' set docstatus=$1 where docids=$2',array(1,$finaldata['docids']));	

					pg_query_params($db,'update sd'.$_SESSION['activeyears'].' set "STID"=$1,"DTID"=$2 where "SDID" = Any(string_to_array($3::text, \',\'::text)::bigint[])',array($finaldata['statenew'][0],$finaldata['districtnew'][0],implode(',',$finaldata['namefrom'])));	

					pg_query_params($db,'update vt'.$_SESSION['activeyears'].' set "STID"=$1,"DTID"=$2 where "SDID" = Any(string_to_array($3::text, \',\'::text)::bigint[])',array($finaldata['statenew'][0],$finaldata['districtnew'][0],implode(',',$finaldata['namefrom'])));
				for($ik=0;$ik<count($finaldata['namefrom']);$ik++)
		 		{
		 			$arra=array();
		 			$arra=array($finaldata['namefrom'][$ik],1);

				  $finalqueryvt = 'insert into forreaddata2021 ("frfromids","frfromaction","frtoids","frdocids","frcomefrom",
						"frcomment","is_final","comeaction","STID","DTID","SDID","VTID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE","STIDR","DTIDR","SDIDR","VTIDR","created_by")
						(
						select "frfromids"
						 ,(select "frfromaction" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "frfromaction"
						 ,"frtoids"
						 ,(select "frdocids" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "frdocids"
						 ,(select "frcomefrom" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "frcomefrom",
							(select "frcomment" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "frcomment"
						 ,(select "is_final" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "is_final"
						 ,(select "comeaction" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "comeaction"
						 ,vt21."STIDR"::integer AS "STIDR11",vt21."DTIDR"::integer AS "DTIDR11",vt21."SDIDR"::BIGINT AS "SDIDR11",vt21."VTIDR"::NUMERIC AS "VTIDR11"
						 ,vt21."STID",vt21."DTID",vt21."SDID",vt21."VTID",vt21."STIDR"::integer,vt21."DTIDR"::integer,vt21."SDIDR"::BIGINT,vt21."VTIDR"::NUMERIC
						 ,(select "created_by" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "created_by" from vt2021 as vt21 
						LEFT JOIN (select * from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as fr21 ON fr21."frtoids"=vt21."SDID"::NUMERIC 
						 and fr21."frfromids"=vt21."SDIDR"::NUMERIC 
						where vt21."SDID"=$1 AND vt21."is_deleted"=$2
						)';
					
						 pg_query_params($db,$finalqueryvt,$arra);
				}
				$task = "addReshuffle";
				

	 	}
	 	else if($finaldata['comefromcheck']=='Village / Town')
	 	{
	 		
	 		
	 			if(isset($finaldata['statenewarray']))
				{
				$statenewarray = explode(',',$finaldata['statenewarray']);
				}

				if(isset($finaldata['districtnewarray']))
				{
				$districtnewarray = explode(',',$finaldata['districtnewarray']);
				}

				if(isset($finaldata['sddistrictnewarray']))
				{
				$sddistrictnewarray = explode(',',$finaldata['sddistrictnewarray']);
				}


	 		$updatequery='';

	 			
	 		$vt= array();
			$ii = explode(',',$finaldata['ind']);
	 			for($o=0;$o<count($finaldata['action']);$o++)
					{

						if($ii[$o]==1)
						{
								for($i=0;$i<count($finaldata['namefrom']);$i++)
								{
									$a=array();
									$a=array($finaldata['namefrom'][$i],1);
									$sqlo='Select "STIDR","DTIDR","SDIDR","VTIDR","Level","Status","VTName","MDDS_VT" from vt'.$_SESSION['activeyears'].' WHERE "VTID"=$1 AND is_deleted=$2';
									$sqlold = pg_query_params($db,$sqlo,$a);
									$sqlda = pg_fetch_array($sqlold);
									

					
									$frcomment='';
									$frcomment .='<strong style="color:#aa81f3;"><u>State/UT:</u></strong> '.$statenewarray[0].'; ';
									$frcomment .='<strong style="color:Green;"><u>District:</u></strong> '.$districtnewarray[0].'; <strong style="color:blue;"><u>Sub District:</u></strong> '.$sddistrictnewarray[0].'; ';
									if($sqlda['Level']=='VILLAGE')
									{
										$frcomment .='<strong style="color:#15bed2;"><u>Village:</u></strong> '.$sqlda['VTName'].' - '.$sqlda['MDDS_VT'].' Moved / Reshuffled to '.$finaldata['namefrompre'].' Sub District;';
									}
									else
									{
										$frcomment .='<strong style="color:#45b0e2;"><u>Town:</u></strong> '.$sqlda['VTName'].' - '.$sqlda['MDDS_VT'].' Moved / Reshuffled to '.$finaldata['namefrompre'].' Sub District;';
									}
									


									
							$std = explode(',',$sqlda['STIDR']);
							$dtd = explode(',',$sqlda['DTIDR']);
							$sdd = explode(',',$sqlda['SDIDR']);
							$vvt = explode(',',$sqlda['VTIDR']);
							$forreadqueryapp=array();
							for($fg=0;$fg<count($std);$fg++)
							{
								
								$forreadqueryapp =array($finaldata['namefrom'][$i],$finaldata['clickpopup'],$finaldata['namefrom'][$i],$finaldata['docids'],$finaldata['comefromcheck'],$frcomment,$finaldata['clickpopup'],$finaldata['fromstate'][$o],$finaldata['districtget'][$o],$finaldata['sddistrictget'][$o],$finaldata['namefrom'][$i],$finaldata['statenew'][0],$finaldata['districtnew'][0],$finaldata['sddistrictnew'][0],$finaldata['namefrom'][$i],$std[$fg],$dtd[$fg],$sdd[$fg],$vvt[$fg],$_SESSION['login_id']);

								$forreaddata = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","DTID","SDID","VTID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE","STIDR","DTIDR","SDIDR","VTIDR","created_by") VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14,$15,$16,$17,$18,$19,$20)';

								pg_query_params($db,$forreaddata,$forreadqueryapp);
							
							}


								


								$linkst=array($finaldata['docids'],$finaldata['fromstate'][$i],$finaldata['districtget'][$i],$finaldata['sddistrictget'][$i],$finaldata['namefrom'][$i]);
								$linkst1=array($finaldata['docids'],$finaldata['statenew'][0],$finaldata['districtnew'][0],$finaldata['sddistrictnew'][0],$finaldata['namefrom'][$i]);

									$insertlink = 'insert into documentlink'.$_SESSION['activeyears'].' (docids,linkstids,linkdtids,linksdids,linkvtids) VALUES ($1,$2,$3,$4,$5)';	
					pg_query_params($db,$insertlink,$linkst);

						$insertlink1 = 'insert into documentlink'.$_SESSION['activeyears'].' (docids,linkstids,linkdtids,linksdids,linkvtids) VALUES ($1,$2,$3,$4,$5)';	
					pg_query_params($db,$insertlink1,$linkst1);

								}
						$vt = array_merge($vt,$finaldata['namefrom']);
						}
						else
						{
								for($i=0;$i<count($finaldata['namefrom'.$ii[$o].'']);$i++)
								{
									$a=array();
									$a=array($finaldata['namefrom'.$ii[$o].''][$i],1);
								$sqlo1='Select "STIDR","DTIDR","SDIDR","VTIDR","Level","Status","VTName","MDDS_VT" from vt'.$_SESSION['activeyears'].' WHERE "VTID"=$1 AND is_deleted=$2';
								$sqlold1 = pg_query_params($db,$sqlo1,$a);
								$sqlda1 = pg_fetch_array($sqlold1);

								$frcomment='';
								$frcomment .='<strong style="color:#aa81f3;"><u>State/UT:</u></strong> '.$statenewarray[0].'; ';
									$frcomment .='<strong style="color:Green;"><u>District:</u></strong> '.$districtnewarray[0].'; <strong style="color:blue;"><u>Sub District:</u></strong> '.$sddistrictnewarray[0].'; ';

									if($sqlda1['Level']=='VILLAGE')
									{
										$frcomment .='<strong style="color:#15bed2;"><u>Village:</u></strong> '.$sqlda1['VTName'].' - '.$sqlda1['MDDS_VT'].' Moved / Reshuffled to '.$finaldata['namefrompre'].' Sub District;';
									}
									else
									{
										$frcomment .='<strong style="color:#45b0e2;"><u>Town:</u></strong> '.$sqlda1['VTName'].' - '.$sqlda1['MDDS_VT'].' Moved / Reshuffled to '.$finaldata['namefrompre'].' Sub District;';
									}

									$std = explode(',',$sqlda1['STIDR']);
							$dtd = explode(',',$sqlda1['DTIDR']);
							$sdd = explode(',',$sqlda1['SDIDR']);
							$vvt = explode(',',$sqlda1['VTIDR']);
							$forreadqueryapp=array();
							for($fg=0;$fg<count($std);$fg++)
							{
								
								$forreadqueryapp =array($finaldata['namefrom'.$ii[$o].''][$i],$finaldata['clickpopup'],$finaldata['namefrom'.$ii[$o].''][$i],$finaldata['docids'],$finaldata['comefromcheck'],$frcomment,$finaldata['clickpopup'],$finaldata['fromstate'][$o],$finaldata['districtget'][$o],$finaldata['sddistrictget'][$o],$finaldata['namefrom'.$ii[$o].''][$i],$finaldata['statenew'][0],$finaldata['districtnew'][0],$finaldata['sddistrictnew'][0],$finaldata['namefrom'.$ii[$o].''][$i],$std[$fg],$dtd[$fg],$sdd[$fg],$vvt[$fg],$_SESSION['login_id']);

								$forreaddata = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","DTID","SDID","VTID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE","STIDR","DTIDR","SDIDR","VTIDR","created_by") VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14,$15,$16,$17,$18,$19,$20)';

								pg_query_params($db,$forreaddata,$forreadqueryapp);
							
							}
									
								


								$linkst =array($finaldata['docids'],$finaldata['fromstate'][$i],$finaldata['districtget'][$i],$finaldata['sddistrictget'][$i],$finaldata['namefrom'.$ii[$o].''][$i]);
								$linkst1 =array($finaldata['docids'],$finaldata['statenew'][0],$finaldata['districtnew'][0],$finaldata['sddistrictnew'][0],$finaldata['namefrom'.$ii[$o].''][$i]);

								$insertlink = 'insert into documentlink'.$_SESSION['activeyears'].' (docids,linkstids,linkdtids,linksdids,linkvtids) VALUES ($1,$2,$3,$4,$5)';	
					pg_query_params($db,$insertlink,$linkst);

						$insertlink1 = 'insert into documentlink'.$_SESSION['activeyears'].' (docids,linkstids,linkdtids,linksdids,linkvtids) VALUES ($1,$2,$3,$4,$5)';	
					pg_query_params($db,$insertlink1,$linkst1);

								}
								$vt = array_merge($vt,$finaldata['namefrom'.$ii[$o].'']);
						}

					}


					pg_query_params($db,'update documentdata'.$_SESSION['activeyears'].' set docstatus=$1 where docids=$2',array(1,$finaldata['docids']));	

					// pg_query($db,'update sd'.$_SESSION['activeyears'].' set "STID"='.$finaldata['statenew'].',"DTID"='.$finaldata['districtnew'].' where "SDID" IN ('.implode(',',$finaldata['namefrom']).')');	

					pg_query_params($db,'update vt'.$_SESSION['activeyears'].' set "STID"=$1,"DTID"=$2,"SDID"=$3 where "VTID" = Any(string_to_array($4::text, \',\'::text)::NUMERIC[])',array($finaldata['statenew'][0],$finaldata['districtnew'][0],$finaldata['sddistrictnew'][0],implode(',',$vt)));


					//By sahana village reshuffle one to one, many to one 0111
					$auflag_query = 'SELECT auflag FROM unit WHERE auaction = $1 AND aulevel = $2';
								$actions = $finaldata['action'];
								$namefrom_values = [];
								
								foreach ($finaldata as $key => $value) {
									if (preg_match('/^namefrom\d*$/', $key)) {
										$namefrom_values[] = $value;
									}
								}
				
								foreach ($actions as $action) {
									if (empty($namefrom_values)) {
										break; 
									}
								
									$namefrom = array_shift($namefrom_values);
								
									foreach ($namefrom as $item) {
										$au = pg_query_params($db, $auflag_query, array($action, $finaldata['comefromcheck']));
								
										if ($au) {
											$row = pg_fetch_assoc($au);
											$auflag_value = $row['auflag'];
											$update_vt = pg_query_params($db, 'UPDATE vt'.$_SESSION['activeyears'].' SET "auflag" = $1, "auaction" = $2 WHERE "VTID" = $3', array($auflag_value, $action, $item));
											if (!$update_vt) {
												echo "UPDATE query failed: " . pg_last_error($db);
											}
										} else {
											echo "SELECT query failed: " . pg_last_error($db);
										}
									}
								} 

				$task = "addReshuffle";

	 	}



}
else
{


	$retdata =  (array) json_decode($finaldata['returndata']); 		

	if($finaldata['applyon']=='District')
	{
			// print_r($finaldata);
			// print_r($retdata);

			
				$dataofremove = explode(',',$retdata['origremove']);
				$removearraydt = array();

					$stidup = '';
					if($finaldata['tstids']!='')
					{
						$stidup = array($finaldata['tstids']);
					}
					else
					{
						$stidup = $retdata['statenew'];
					}

					$linkSTarray='';
					if($retdata['flag']=='namefrom')
					{

									// By sahana split district, many to one 0111
									$auflag_query = "SELECT auflag FROM unit WHERE auaction = $1 AND aulevel = $2";
									$actions = $retdata['action'];
									$namefrom_values = $retdata['namefrom'];
									
									foreach ($actions as $key => $action) {
										$namefrom = $namefrom_values[$key];
									
										$au = pg_query_params($db, $auflag_query, array($action, $retdata['comefromcheck']));
									
										if ($au) {
											$row = pg_fetch_assoc($au);
											$auflag_value = $row['auflag'];
									
											$update_vt = pg_query_params($db, 'UPDATE vt'.$_SESSION['activeyears'].' SET "auflag" = $1, "auaction" = $2 WHERE "DTID" = $3', array($auflag_value, $action, $namefrom));
											$update_sd = pg_query_params($db, 'UPDATE sd'.$_SESSION['activeyears'].' SET "auflag" = $1, "auaction" = $2 WHERE "DTID" = $3', array($auflag_value, $action, $namefrom));
											$update_dt = pg_query_params($db, 'UPDATE dt'.$_SESSION['activeyears'].' SET "auflag" = $1, "auaction" = $2 WHERE "DTID" = $3', array($auflag_value, $action, $namefrom));
											
											if (!$update_dt || !$update_sd || !$update_vt) {
												echo "UPDATE query failed: " . pg_last_error($db);
											}
										} else {
											echo "SELECT query failed: " . pg_last_error($db);
										}
									}

									if(isset($retdata['statenewarray']))
									{
										$statenewarray = explode(',',$retdata['statenewarray']);
									}

									if(isset($finaldata['statenewarrayfrom']))
									{
									$statenewarrayfrom = explode(',',$finaldata['statenewarrayfrom']);
									}


									$array=array();
									$sql = 'SELECT dt'.$_SESSION['activeyears'].'."ID" FROM dt'.$_SESSION['activeyears'].' ORDER BY dt'.$_SESSION['activeyears'].'."ID" DESC LIMIT 1';

									$idsquery = pg_query_params($db,$sql,$array);

									if(pg_numrows($idsquery)>0)
									{

										$idsquerydata = pg_fetch_array($idsquery);

									
									}

									$id = $idsquerydata['ID'] + 1;
									
									$idsof = $stidup[0]."".$id;
									
											$arrayofn=array();

											$arrayofn=array($stidup[0],$idsof,$retdata['newname'][0],implode(',',$retdata['fromstate']),implode(',',$retdata['namefrom']),'new',$_SESSION['login_id']);

											$state ='insert into dt'.$_SESSION['activeyears'].' ("STID","DTID","DTName","STIDR","DTIDR","flagofcreate","createdby") values ($1,$2,$3,$4,$5,$6,$7) returning "DTID"';
										
											$result = pg_query_params($db,$state,$arrayofn);
											 $fch = pg_fetch_all($result);
										// print_r($fch);
											$partiallylevel = '';
								
											
											$st=array_merge($retdata['fromstate'],$stidup);

											$dt=array_merge($retdata['namefrom'],array($idsof));
										

												$linkSDarray = array();
												$forread = '';
												$forread1 = '';
												$aa=array();

												for($j=0;$j<count($retdata['namefrom']);$j++)
												{
													$arera=array();
													$arera=array($retdata['namefrom'][$j],1);

													$sqlo='Select "STIDR","DTIDR" from dt'.$_SESSION['activeyears'].' WHERE "DTID"=$1 AND is_deleted=$2';
													$sqlold = pg_query_params($db,$sqlo,$arera);
													$sqlda = pg_fetch_array($sqlold);


													if($dataofremove[$j]==1)
													{
																array_push($removearraydt,$retdata['namefrom'][$j]); 
													}
													
													if(isset($finaldata['addlinksDTID'.$j.'']))
													{
															//echo "innnn";

															if(isset($finaldata['partiallylevel'.$j.'']))
															{
															$havep = true;

															for($a=0;$a<count($finaldata['partiallylevel'.$j.'']);$a++)
																{
																	$partiallylevel .="('".$retdata['comefromcheck']."',".$retdata['namefrom'][$j].",'".$retdata['action'][$j]."',".$idsof.",".$retdata['docids'].",".$finaldata['partiallylevel'.$j.''][$a].")," ;
																}



														$finaldata['addlinksDTID'.$j.''] = array_diff($finaldata['addlinksDTID'.$j.''],$finaldata['partiallylevel'.$j.'']);
														$linkSDarray = array_merge($linkSDarray,$finaldata['addlinksDTID'.$j.'']);	
																}
																else
																{
																	$linkSDarray = array_merge($linkSDarray,$finaldata['addlinksDTID'.$j.'']);	
																}

																
														// $linkSDarray=array_merge($linSDarray,$finaldata['addlinksDTID'.$j.'']);	 		
													}
													

													$frcomment='';
													$frcomment1='';
													
													$frcomment .='<strong style="color:#aa81f3;"><u>State/UT:</u></strong> '.$statenewarray[0].';';

													$frcomment .=' <strong style="color:Green;"><u>District:</u></strong> '.$retdata['newname'][0].'  Created from '.$retdata['namefromtext'].' ('.$retdata['action'][0].');'; 
													$frcomment .=' <strong style="color:blue;"><u>Sub District:</u></strong> - ; <strong style="color:#45b0e2;"><u>Town:</u></strong> - ; <strong style="color:#15bed2;"><u>Village:</u></strong> - ;';

													$frcomment1 .='<strong style="color:#aa81f3;"><u>State/UT:</u></strong> '.$statenewarrayfrom[0].';';

													$frcomment1 .=' <strong style="color:Green;"><u>District:</u></strong> '.$retdata['namefromtext'].' '.$retdata['action'][0].' &  Create '.$retdata['newname'][0].';';

													$frcomment1 .=' <strong style="color:blue;"><u>Sub District:</u></strong> - ; <strong style="color:#45b0e2;"><u>Town:</u></strong> - ; <strong style="color:#15bed2;"><u>Village:</u></strong> - ;';

													
													// $forread .= "(".$retdata['namefrom'][$j].",'".$retdata['action'][$j]."',".$idsof.",".$retdata['docids'].",'".$retdata['comefromcheck']."','".$frcomment."','Create',".$retdata['fromstate'][$j].",".$retdata['namefrom'][$j].",".$stidup[0].",".$idsof.",".$sqlda['STIDR'].",".$sqlda['DTIDR'].",".$_SESSION['login_id']."),";

													// $forread1 .= "(".$retdata['namefrom'][$j].",'".$retdata['action'][$j]."',".$retdata['namefrom'][$j].",".$retdata['docids'].",'".$retdata['comefromcheck']."','".$frcomment1."','MAIN',".$retdata['fromstate'][$j].",".$retdata['namefrom'][$j].",".$retdata['fromstate'][$j].",".$retdata['namefrom'][$j].",".$sqlda['STIDR'].",".$sqlda['DTIDR'].",".$_SESSION['login_id']."),";


													$arrayfor[$j]= array($retdata['namefrom'][$j],$retdata['action'][$j],$idsof,$retdata['docids'],$retdata['comefromcheck'],$frcomment,'Create',$retdata['fromstate'][$j],$retdata['namefrom'][$j],$stidup[0],$idsof,$sqlda['STIDR'],$sqlda['DTIDR'],$_SESSION['login_id']);

													$arrayformain[$j]= array($retdata['namefrom'][$j],$retdata['action'][$j],$retdata['namefrom'][$j],$retdata['docids'],$retdata['comefromcheck'],$frcomment1,'MAIN',$retdata['fromstate'][$j],$retdata['namefrom'][$j],$retdata['fromstate'][$j],$retdata['namefrom'][$j],$sqlda['STIDR'],$sqlda['DTIDR'],$_SESSION['login_id']);
												}
												// $forreadqueryappend = rtrim($forread, ',');
												// $forreadqueryappend1 = rtrim($forread1, ',');
												
												for($k=0;$k<count($st);$k++)
												{
												 $insertlinkst = 'insert into documentlink'.$_SESSION['activeyears'].' (docids,linkstids,linkdtids) VALUES ($1,$2,$3)';
													$resultst = pg_query_params($db,$insertlinkst,array($retdata['docids'],$st[$k],$dt[$k]));
												}
												$new_number_rows = pg_affected_rows($resultst); 
												
													
												for($jk=0;$jk<count($arrayfor);$jk++)
												{
													 $insertforread = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","DTID","STIDACTIVE","DTIDACTIVE","STIDR","DTIDR","created_by") VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14)';

													 $result = pg_query_params($db,$insertforread,$arrayfor[$jk]);
												
												}
												$result_rows = pg_affected_rows($result);
													
												if(count($linkSDarray)>0)
												{
													for($l=0;$l<count($linkSDarray);$l++)
													{
													$insertlinkdt = 'insert into documentlink'.$_SESSION['activeyears'].' (docids,linkstids,linkdtids,linksdids) VALUES ($1,$2,$3,$4)';	
													 pg_query_params($db,$insertlinkdt,array($retdata['docids'],$st[$l],$idsof,$linkSDarray[$l]));

													}
												}




														if($result_rows!=0 && $new_number_rows!=0)
														{

															// echo "INNNNNN";
															// exit;
															$arrayi=array(1,$retdata['docids']);

														pg_query_params('update documentdata'.$_SESSION['activeyears'].' set docstatus=$1 where docids=$2',$arrayi);
														$arrayi1=array($stidup[0],$idsof,implode(',',$linkSDarray));
														pg_query_params('update sd'.$_SESSION['activeyears'].' set "STID"=$1,"DTID"=$2 where sd'.$_SESSION['activeyears'].'."SDID" = Any(string_to_array($3::text, \',\'::text)::bigint[])',$arrayi1);
														// $arrayi2=array($stidup[0],$idsof,implode(',',$linkSDarray));
														pg_query_params('update vt'.$_SESSION['activeyears'].' set "STID"=$1,"DTID"=$2 where vt'.$_SESSION['activeyears'].'."SDID" = Any(string_to_array($3::text, \',\'::text)::bigint[])',$arrayi1);

														// pg_query('update wd'.$_SESSION['activeyears'].' set "STID"='.$stidup[0].',"DTID"='.$idsof.' where wd'.$_SESSION['activeyears'].'."SDID" IN ('.implode(',',$linkSDarray).')');

														
														


														if(count($removearraydt)>0)
														{
															$arra1=array(0,implode(',',$removearraydt));
															pg_query_params('update dt'.$_SESSION['activeyears'].' set "is_deleted"=0 where "DTID" = Any(string_to_array($2::text, \',\'::text)::integer[])');	
														}
														else
														{
															/*$insertforread1 = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","DTID","STIDACTIVE","DTIDACTIVE","STIDR","DTIDR","created_by") VALUES '.$forreadqueryappend1.'';

													pg_query($db,$insertforread1);*/
													$arrayformain = array_values($arrayformain);
													for($jk=0;$jk<count($arrayformain);$jk++)
												{
													 $insertforread1 = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","DTID","STIDACTIVE","DTIDACTIVE","STIDR","DTIDR","created_by") VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14)';

													 pg_query_params($db,$insertforread1,$arrayformain[$jk]);
												
														
												 

												
												}



														}

													

															if($partiallylevel!='')
												{

													$partiallylevelquery = rtrim($partiallylevel, ',');
													
														pg_query($db,"insert into partiallydata".$_SESSION['activeyears']." (comefrom,fromids,comeaction,toids,docids,partiallydataids) VALUES ".$partiallylevelquery." ");
												}

											

												if($finaldata['partiallyids']!='')
												{

													$arrap=array(1,$finaldata['partiallyids']);
												pg_query_params('update partiallydata'.$_SESSION['activeyears'].' set "pstatus"=$1 where partiallyids=$2',$arrap);	
												}
												$arrayop=array($retdata['docids'],0);
												$sql_da = pg_query_params('select * from partiallydata'.$_SESSION['activeyears'].' where docids=$1 AND pstatus=$2',$arrayop);
												if(pg_numrows($sql_da)==0)
												{
													$ar=array(1,$retdata['docids']);
												pg_query_params('update documentdata'.$_SESSION['activeyears'].' set docstatus=$1 where docids=$2',$ar);

												}

												$insfinal=array($idsof);
												 $finalquerysd = 'insert into forreaddata2021 ("frfromids","frfromaction","frtoids","frdocids","frcomefrom",
													"frcomment","is_final","comeaction","STID","DTID","SDID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","STIDR","DTIDR","SDIDR","created_by")
													(select sd21."DTIDR"::integer as "frfromids",(select "frfromaction" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "frfromaction"
													 ,sd21."DTID"::integer as "frtoids",(select "frdocids" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "frdocids"
													 ,(select "frcomefrom" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "frcomefrom"
													 ,(select "frcomment" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "frcomment"
													 ,(select "is_final" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "is_final"
													 ,(select "comeaction" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "comeaction"
													 ,sd21."STIDR"::integer AS "STIDR11",sd21."DTIDR"::integer AS "DTIDR11",sd21."SDIDR"::BIGINT AS "SDIDR11",sd21."STID",sd21."DTID"
													 ,sd21."SDID",sd21."STIDR"::integer,sd21."DTIDR"::integer,sd21."SDIDR"::BIGINT
													 ,(select "created_by" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "created_by" from sd2021 as sd21
													LEFT JOIN (select * from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as fr21 ON fr21."frtoids"=sd21."DTID" and fr21."frfromids"::TEXT=sd21."DTIDR" 
													where sd21."DTID"=$1 AND sd21."is_deleted"=1

													
													)';
													pg_query_params($db,$finalquerysd,$insfinal);

													$finalqueryvt = 'insert into forreaddata2021 ("frfromids","frfromaction","frtoids","frdocids","frcomefrom",
													"frcomment","is_final","comeaction","STID","DTID","SDID","VTID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE","STIDR","DTIDR","SDIDR","VTIDR","created_by")
													(
													select vt21."DTIDR"::integer AS "frfromids",(select "frfromaction" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "frfromaction"
													,vt21."DTID"::integer AS "frtoids"
													,(select "frdocids" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "frdocids"
													,(select "frcomefrom" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "frcomefrom"
													,(select "frcomment" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "frcomment"
													,(select "is_final" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "is_final"
													,(select "comeaction" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "comeaction"
													,vt21."STIDR"::integer AS "STIDR11",vt21."DTIDR"::integer AS "DTIDR11",vt21."SDIDR"::BIGINT AS "SDIDR11",vt21."VTIDR"::NUMERIC AS "VTIDR11",vt21."STID",vt21."DTID",vt21."SDID",vt21."VTID",vt21."STIDR"::integer,vt21."DTIDR"::integer,vt21."SDIDR"::BIGINT,vt21."VTIDR"::NUMERIC
													,(select "created_by" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "created_by" from vt2021 as vt21 
													LEFT JOIN (select * from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as fr21 ON fr21."frtoids"=vt21."DTID" and fr21."frfromids"::TEXT=vt21."DTIDR" 
													where vt21."DTID"=$1 AND vt21."is_deleted"=1

													)';
													pg_query_params($db,$finalqueryvt,$insfinal);


														$task = "addfinish";
														}
														else
														{
														$task = "error";
														}


					}
					else
					{

									//By sahana split district, one to one 0111
									$auflag_query = "SELECT auflag FROM unit WHERE auaction = $1 AND aulevel = $2";
									$actions = $retdata['action'];
									$namefrom_values = $retdata['namefrom'];
									
									foreach ($actions as $key => $action) {
										$namefrom = $namefrom_values[$key];
									
										$au = pg_query_params($db, $auflag_query, array($action, $retdata['comefromcheck']));
									
										if ($au) {
											$row = pg_fetch_assoc($au);
											$auflag_value = $row['auflag'];
									
											$update_vt = pg_query_params($db, 'UPDATE vt'.$_SESSION['activeyears'].' SET "auflag" = $1, "auaction" = $2 WHERE "DTID" = $3', array($auflag_value, $action, $namefrom));
											$update_sd = pg_query_params($db, 'UPDATE sd'.$_SESSION['activeyears'].' SET "auflag" = $1, "auaction" = $2 WHERE "DTID" = $3', array($auflag_value, $action, $namefrom));
											$update_dt = pg_query_params($db, 'UPDATE dt'.$_SESSION['activeyears'].' SET "auflag" = $1, "auaction" = $2 WHERE "DTID" = $3', array($auflag_value, $action, $namefrom));
											
											if (!$update_dt || !$update_sd || !$update_vt) {
												echo "UPDATE query failed: " . pg_last_error($db);
											}
										} else {
											echo "SELECT query failed: " . pg_last_error($db);
										}
									}
						
									if(isset($retdata['statenewarray']))
									{
										$statenewarray = explode(',',$retdata['statenewarray']);
									}

									if(isset($finaldata['statenewarrayfrom']))
									{
									$statenewarrayfrom = explode(',',$finaldata['statenewarrayfrom']);
									}



									$partiallylevel = '';

									$linkSTarray='';
									

									$linkSTarray = $retdata['namefrom'];


												$linkDTarray = array();
												$forread = '';
												$forread1 = '';
												$idsof ='';
												for($j=0;$j<count($retdata['newname']);$j++)
												{
													

											  $sql = 'SELECT dt'.$_SESSION['activeyears'].'."ID" FROM dt'.$_SESSION['activeyears'].' ORDER BY dt'.$_SESSION['activeyears'].'."ID" DESC LIMIT 1';

									$idsquery = pg_query($db,$sql);

									if(pg_numrows($idsquery)>0)
									{

										$idsquerydata = pg_fetch_array($idsquery);

									
									}


									$id = $idsquerydata['ID'] + 1;
									
									$idsof = $stidup[$j]."".$id;

									$sqlo='Select "STIDR","DTIDR" from dt'.$_SESSION['activeyears'].' WHERE "DTID"=$1 AND is_deleted=$2';
									$sqlold = pg_query_params($db,$sqlo,array($retdata['namefrom'][0],1));
									$sqlda = pg_fetch_array($sqlold);

										
										$stateconcate = array($stidup[$j],$idsof,$retdata['newname'][$j],$sqlda['STIDR'],$sqlda['DTIDR'],'new',$_SESSION['login_id']);

										// "(".$stidup[$j].",".$idsof.",'".ucwords(strtolower($retdata['newname'][$j]))."','".$sqlda['STIDR']."','".$sqlda['DTIDR']."','new',".$_SESSION['login_id'].")";

											

													if(isset($finaldata['partiallylevel'.$j.'']))
													{

															$havep = true;


														$finaldata['addlinksDTID'.$j.''] = array_diff($finaldata['addlinksDTID'.$j.''],$finaldata['partiallylevel'.$j.'']);
														
														// $partiallylevel = array_merge($partiallylevel,$finaldata['partiallylevel'.$j.'']);

													}


												$linkDTarray=array_merge($linkDTarray,$finaldata['addlinksDTID'.$j.'']);	 

													$frcomment='';
												
													$frcomment .='<strong style="color:#aa81f3;"><u>State/UT:</u></strong> '.$statenewarray[$j].';';

													$frcomment .=' <strong style="color:Green;"><u>District:</u></strong> '.$retdata['newname'][$j].' Created from '.$retdata['namefromtext'].' (Split);'; 

													$frcomment .=' <strong style="color:blue;"><u>Sub District:</u></strong> - ; <strong style="color:#45b0e2;"><u>Town:</u></strong> - ; <strong style="color:#15bed2;"><u>Village:</u></strong> - ;';
													
												$str = explode(',',$sqlda['STIDR']);
												$dtr = explode(',',$sqlda['DTIDR']);

												for($hj=0;$hj<count($str);$hj++)
												{
														// $forread .= "(".$retdata['namefrom'][0].",'".$retdata['action'][0]."',".$idsof.",".$retdata['docids'].",'".$retdata['comefromcheck']."','".$frcomment."','Create',".$retdata['fromstate'][0].",".$retdata['namefrom'][0].",".$stidup[$j].",".$idsof.",".$str[$hj].",".$dtr[$hj].",".$_SESSION['login_id']."),";

													// $forread[$hj] = array($retdata['namefrom'][0],$retdata['action'][0],$idsof,$retdata['docids'],$retdata['comefromcheck'],$frcomment,'Create',$retdata['fromstate'][0],$retdata['namefrom'][0],$stidup[$j],$idsof,$str[$hj],$dtr[$hj],$_SESSION['login_id']);


													 $insertforread = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","DTID","STIDACTIVE","DTIDACTIVE","STIDR","DTIDR","created_by") VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14)';

													 $result = pg_query_params($db,$insertforread,array($retdata['namefrom'][0],$retdata['action'][0],$idsof,$retdata['docids'],$retdata['comefromcheck'],$frcomment,'Create',$retdata['fromstate'][0],$retdata['namefrom'][0],$stidup[$j],$idsof,$str[$hj],$dtr[$hj],$_SESSION['login_id']));

												}
											
												$result_rows = pg_affected_rows($result);

										
												

												$st=array_merge($retdata['fromstate'],$stidup);
												$ids[]=$idsof;
												
												//$stateconcatefinal = rtrim($stateconcate, ',');

												 $state ='insert into dt'.$_SESSION['activeyears'].' ("STID","DTID","DTName","STIDR","DTIDR","flagofcreate","createdby") values ($1,$2,$3,$4,$5,$6,$7) returning "DTID"';
												 pg_query_params($db,$state,$stateconcate);
												}

													$frcomment1='';
													$frcomment1 .='<strong style="color:#aa81f3;"><u>State/UT:</u></strong> '.$statenewarrayfrom[$j].';';
												$frcomment1 .=' <strong style="color:Green;"><u>District:</u></strong> '.$retdata['namefromtext'].' '.$retdata['action'][0].' &  Create '.implode(',',$retdata['newname']).';';

												$frcomment1 .=' <strong style="color:blue;"><u>Sub District:</u></strong> - ; <strong style="color:#45b0e2;"><u>Town:</u></strong> - ; <strong style="color:#15bed2;"><u>Village:</u></strong> - ;';
												
												$str1 = explode(',',$sqlda['STIDR']);
												$dtr1 = explode(',',$sqlda['DTIDR']);
												for($hj=0;$hj<count($str1);$hj++)
												{

														// $forread1 .= "(".$retdata['namefrom'][0].",'".$retdata['action'][0]."',".$idsof.",".$retdata['docids'].",'".$retdata['comefromcheck']."','".$frcomment."','Create',".$retdata['fromstate'][0].",".$retdata['namefrom'][0].",".$stidup[$j].",".$idsof.",".$str1[$hj].",".$dtr1[$hj].",".$_SESSION['login_id']."),";

														// $forread1[$hj]= ;


														$insertforread1 = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","DTID","STIDACTIVE","DTIDACTIVE","STIDR","DTIDR","created_by") VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14)';
												
												pg_query_params($db,$insertforread1,array($retdata['namefrom'][0],$retdata['action'][0],$idsof,$retdata['docids'],$retdata['comefromcheck'],$frcomment,'Create',$retdata['fromstate'][0],$retdata['namefrom'][0],$stidup[$j],$idsof,$str1[$hj],$dtr1[$hj],$_SESSION['login_id']));

												}
												
													


												$dt=array_merge($retdata['namefrom'],$ids);
											

												// $forreadqueryappend = rtrim($forread, ',');
												// $forreadqueryappend1 = rtrim($forread1, ',');

												if($dataofremove[0]==1)
													{

														array_push($removearraydt,$retdata['namefrom'][0]); 
													}

											
												$linkst='';
												for($k=0;$k<count($dt);$k++)
												{
												// $linkst .="(".$retdata['docids'].",".$st[$k].",".$dt[$k]."),";
												$insertlinkst = 'insert into documentlink'.$_SESSION['activeyears'].' (docids,linkstids,linkdtids) VALUES ($1,$2,$3)';
													$resultst = pg_query_params($db,$insertlinkst,array($retdata['docids'],$st[$k],$dt[$k]));

												}

												$result_rowsst = pg_affected_rows($resultst);
												
												
													$linkdtupdate=array();

												for($l=0;$l<count($ids);$l++)
												{

												if(isset($finaldata['addlinksDTID'.$l.'']))
												{
													if(isset($finaldata['partiallylevel'.$l.'']))
														{
														$havep = true;
																for($a=0;$a<count($finaldata['partiallylevel'.$l.'']);$a++)
																{
																	//modified by gowthami to solve the issue related to wineline in AU dtid
																	//$partiallylevel .="('".$retdata['comefromcheck']."',".$retdata['namefrom'][0].",'".$retdata['action'][0]."',".$ids[$l].",".$retdata['docids'].",".$finaldata['partiallylevel'.$l.''][$a].")," ;
																	$partiallylevel .="('".$retdata['comefromcheck']."',".$retdata['namefrom'][0].",'".$retdata['action'][0]."',".$ids[$l].",".$retdata['docids'].",".$finaldata['partiallylevel'.$l.''][$a].",".$retdata['fromstate'][0].",".$retdata['namefrom'][0].")," ;
																}

															$finaldata['addlinksDTID'.$l.''] = array_diff($finaldata['addlinksDTID'.$l.''],$finaldata['partiallylevel'.$l.'']);
														}

										    	$datao = array_values(array_filter($finaldata['addlinksDTID'.$l.'']));
												for($b=0;$b<count($datao);$b++)
												{

														

													$linkdtupdate[$l][$b]=$datao[$b];

														// $linkdt[$b]=array($retdata['docids'],$stidup[$l],$ids[$l],$datao[$b]);
														
														// $linkdt .="(".$retdata['docids'].",".$stidup[$l].",".$ids[$l].",".$datao[$b]."),";
															
														if(count($linkDTarray)>0)
														{
														$insertlinkdt = 'insert into documentlink'.$_SESSION['activeyears'].' (docids,linkstids,linkdtids,linksdids) VALUES ($1,$2,$3,$4)';
														$resultdt = pg_query_params($db,$insertlinkdt,array($retdata['docids'],$stidup[$l],$ids[$l],$datao[$b]));
														}


												}
														
												}
												}

												
												if($result_rows!=0 && $result_rowsst!=0)
												{

												
												pg_query_params($db,'update documentdata'.$_SESSION['activeyears'].' set docstatus=$1 where docids=$2',array(1,$retdata['docids']));



												for($mk=0;$mk<count($linkdtupdate);$mk++)
												{
													
													$arrayo=array();
													$arrayo=array($stidup[$mk],$ids[$mk],implode(',',$linkdtupdate[$mk]));

													pg_query_params($db,'update sd'.$_SESSION['activeyears'].' set "STID"=$1,"DTID"=$2 where sd'.$_SESSION['activeyears'].'."SDID" = Any(string_to_array($3::text, \',\'::text)::bigint[])',$arrayo);

													pg_query_params($db,'update vt'.$_SESSION['activeyears'].' set "STID"=$1,"DTID"=$2 where vt'.$_SESSION['activeyears'].'."SDID" = Any(string_to_array($3::text, \',\'::text)::bigint[])',$arrayo);

													// pg_query('update wd'.$_SESSION['activeyears'].' set "STID"='.$stidup.',"DTID"='.$STARRAY[$mk]['DTID'].' where wd'.$_SESSION['activeyears'].'."SDID" IN ('.implode(',',$linkdtupdate[$mk]).')');	
												}


													if($partiallylevel!='')
												{



													$partiallylevelquery = rtrim($partiallylevel, ',');
													

												
														//modified by Gowthami to solve the issue related to wine line in AUdtid
													//pg_query("insert into partiallydata".$_SESSION['activeyears']." (comefrom,fromids,comeaction,toids,docids,partiallydataids) VALUES ".$partiallylevelquery." ");
													pg_query("insert into partiallydata".$_SESSION['activeyears']." (comefrom,fromids,comeaction,toids,docids,partiallydataids,stid,dtid) VALUES ".$partiallylevelquery." ");
												}

												// if($finaldata['partiallyids']!='')
												// 		{


												// 		pg_query('update partiallydata'.$_SESSION['activeyears'].' set "pstatus"=1 where partiallyids='.$finaldata['partiallyids'].'');	
												// 		}

												if($finaldata['partiallyids']!='')
												{


												pg_query_params($db,'update partiallydata'.$_SESSION['activeyears'].' set "pstatus"=$1 where partiallyids=$2',array(1,$finaldata['partiallyids']));	
												}

												$sql_da = pg_query_params($db,'select * from partiallydata'.$_SESSION['activeyears'].' where docids=$1 AND pstatus=$2',array($retdata['docids'],0));
												if(pg_numrows($sql_da)==0)
												{

												pg_query_params($db,'update documentdata'.$_SESSION['activeyears'].' set docstatus=$1 where docids=$2',array(1,$retdata['docids']));

												}


												if(count($removearraydt)>0)
												{
															
															pg_query_params($db,'update dt'.$_SESSION['activeyears'].' set "is_deleted"=$1 where "STID"=$2 and "DTID" = Any(string_to_array($3::text, \',\'::text)::bigint[])',array(0,$retdata['fromstate'][0],implode(',',$removearraydt)));	
												}


												for($kl=0;$kl<count($ids);$kl++)
												{
													$arrayofsv=array($ids[$kl]);
													 $finalquerysd = 'insert into forreaddata2021 ("frfromids","frfromaction","frtoids","frdocids","frcomefrom",
													"frcomment","is_final","comeaction","STID","DTID","SDID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","STIDR","DTIDR","SDIDR","created_by")
													(select sd21."DTIDR"::integer as "frfromids",(select "frfromaction" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "frfromaction"
													 ,sd21."DTID"::integer as "frtoids",(select "frdocids" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "frdocids"
													 ,(select "frcomefrom" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "frcomefrom"
													 ,(select "frcomment" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "frcomment"
													 ,(select "is_final" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "is_final"
													 ,(select "comeaction" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "comeaction"
													 ,sd21."STIDR"::integer AS "STIDR11",sd21."DTIDR"::integer AS "DTIDR11",sd21."SDIDR"::BIGINT AS "SDIDR11",sd21."STID",sd21."DTID"
													 ,sd21."SDID",sd21."STIDR"::integer,sd21."DTIDR"::integer,sd21."SDIDR"::BIGINT
													 ,(select "created_by" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "created_by" from sd2021 as sd21
													LEFT JOIN (select * from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as fr21 ON fr21."frtoids"=sd21."DTID" and fr21."frfromids"::TEXT=sd21."DTIDR" 
													where sd21."DTID"=$1 AND sd21."is_deleted"=1
													)';
													pg_query_params($db,$finalquerysd,$arrayofsv);

													 $finalqueryvt = 'insert into forreaddata2021 ("frfromids","frfromaction","frtoids","frdocids","frcomefrom",
													"frcomment","is_final","comeaction","STID","DTID","SDID","VTID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE","STIDR","DTIDR","SDIDR","VTIDR","created_by")
													(

													select vt21."DTIDR"::integer AS "frfromids",(select "frfromaction" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "frfromaction"
													 ,vt21."DTID"::integer AS "frtoids"
													 ,(select "frdocids" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "frdocids"
													 ,(select "frcomefrom" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "frcomefrom"
													 ,(select "frcomment" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "frcomment"
													 ,(select "is_final" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "is_final"
													 ,(select "comeaction" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "comeaction"
													 ,vt21."STIDR"::integer AS "STIDR11",vt21."DTIDR"::integer AS "DTIDR11",vt21."SDIDR"::BIGINT AS "SDIDR11",vt21."VTIDR"::NUMERIC AS "VTIDR11",vt21."STID",vt21."DTID",vt21."SDID",vt21."VTID",vt21."STIDR"::integer,vt21."DTIDR"::integer,vt21."SDIDR"::BIGINT,vt21."VTIDR"::NUMERIC
													 ,(select "created_by" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "created_by" from vt2021 as vt21 
													LEFT JOIN (select * from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as fr21 ON fr21."frtoids"=vt21."DTID" and fr21."frfromids"::TEXT=vt21."DTIDR" 
													where vt21."DTID"=$1 AND vt21."is_deleted"=1
													
													)';
													pg_query_params($db,$finalqueryvt,$arrayofsv);




												}


												$task = "addfinish";
												}
												else
												{
												$task = "error";
												}





					}



	}
	else if($finaldata['applyon']=='Sub-District' || $finaldata['comefromcheck']=='Sub-District')
	{
		// print_r($finaldata);
		// exit;

		if(count($retdata)==0)
		{
					
		
				$linkSTarray='';

				if($finaldata['flag']=='namefrom')
				{
						if(isset($finaldata['statenewarray']))
						{
						$statenewarray = explode(',',$finaldata['statenewarray']);
						}

						if(isset($finaldata['districtnewarray']))
						{
						$districtnewarray = explode(',',$finaldata['districtnewarray']);
						}


						if(isset($finaldata['statenewarrayfrom']))
							{
							$statenewarrayfrom = explode(',',$finaldata['statenewarrayfrom']);
							}

							if(isset($finaldata['districtnewarrayfrom']))
							{
							$districtnewarrayfrom = explode(',',$finaldata['districtnewarrayfrom']);
							}


						

							$sql = 'SELECT sd'.$_SESSION['activeyears'].'."ID" FROM sd'.$_SESSION['activeyears'].' ORDER BY sd'.$_SESSION['activeyears'].'."ID" DESC LIMIT 1';

										$idsquery = pg_query($db,$sql);

										if(pg_numrows($idsquery)>0)
										{

											$idsquerydata = pg_fetch_array($idsquery);

										
										}

										$id = $idsquerydata['ID'] + 1;
										$id = str_pad($id, 5, '0', STR_PAD_LEFT);
										
										$idsof = $finaldata['districtnew'][0]."".$id;

											 $sqlo='Select "STIDR","DTIDR","SDIDR" from sd'.$_SESSION['activeyears'].' WHERE "SDID" = Any(string_to_array($1::text, \',\'::text)::bigint[]) AND is_deleted=$2';

											$sqlold = pg_query_params($db,$sqlo,array(implode(',',$finaldata['namefrom']),1));
											$sqlda = pg_fetch_all($sqlold);

							//$stateconcate = array($finaldata['statenew'][0],$finaldata['districtnew'][0],$idsof,ucwords(strtolower($finaldata['newname'][0])),implode(',',$finaldata['fromstate']),implode(',',$finaldata['districtget']),implode(',',$finaldata['namefrom']),'new',$_SESSION['login_id']);
                            //Titlecase issue resolved by gowthami
							$stateconcate = array($finaldata['statenew'][0],$finaldata['districtnew'][0],$idsof,$finaldata['newname'][0],implode(',',$finaldata['fromstate']),implode(',',$finaldata['districtget']),implode(',',$finaldata['namefrom']),'new',$_SESSION['login_id']);

							$state ='insert into sd'.$_SESSION['activeyears'].' ("STID","DTID","SDID","SDName","STIDR","DTIDR","SDIDR","flagofcreate","createdby") values ($1,$2,$3,$4,$5,$6,$7,$8,$9) returning "SDID"';


							$result1 = pg_query_params($db,$state,$stateconcate);
							$fch = pg_fetch_all($result1);

							$st=array_merge($finaldata['fromstate'],$finaldata['statenew']);
							$dt=array_merge($finaldata['districtget'],$finaldata['districtnew']);

							$sd=array_merge($finaldata['namefrom'],array($idsof));

							$partiallylevel = '';

							$linkDTarray = array();
							$forread = '';
							$forread1 = '';
							for($j=0;$j<count($finaldata['namefrom']);$j++)
							{


							$frcomment='';



							$frcomment .='<strong style="color:#aa81f3;"><u>State/UT:</u></strong> '.$statenewarray[0].'; <strong style="color:Green;"><u>District:</u></strong> '.$districtnewarray[0].'; ';
							$frcomment .='<strong style="color:blue;"><u>Sub District:</u></strong> '.$finaldata['newname'][0].' Created from '.$finaldata['namefromtext'].' ('.$finaldata['action'][0].') ;';
//full merge(20_11)
							$frcomment .=' <strong style="color:#45b0e2;"><u>Town:</u></strong> - ; <strong style="color:#15bed2;"><u>Village:</u></strong> - ;';

							$forread = array($finaldata['namefrom'][$j],$finaldata['action'][$j],$idsof,$finaldata['docids'],$finaldata['comefromcheck'],$frcomment,'Create',$finaldata['fromstate'][$j],$finaldata['districtget'][$j],$finaldata['namefrom'][$j],$finaldata['statenew'][0],$finaldata['districtnew'][0],$idsof,$sqlda[$j]['STIDR'],$sqlda[$j]['DTIDR'],$sqlda[$j]['SDIDR'],$_SESSION['login_id']);

							$insertforread = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","DTID","SDID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","STIDR","DTIDR","SDIDR","created_by") VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14,$15,$16,$17)';

							$result = pg_query_params($db,$insertforread,$forread);
							}
							// $forreadqueryappend = rtrim($forread, ',');

							$result_rows = pg_affected_rows($result);


						
							for($k=0;$k<count($st);$k++)
							{
							
							$linkst =array($finaldata['docids'],$st[$k],$dt[$k],$sd[$k]);
							
								$insertlinkst = 'insert into documentlink'.$_SESSION['activeyears'].' (docids,linkstids,linkdtids,linksdids) VALUES ($1,$2,$3,$4)';

							}
							$resultst = pg_query_params($db,$insertlinkst,$linkst);

							$resultst_rows = pg_affected_rows($resultst);

							
							//By sahana full merge sub district many to one 0111
							$auflag_query = 'SELECT auflag FROM unit WHERE auaction = $1 AND aulevel = $2';
							$actions = $finaldata['action'];
							$namefrom_values = $finaldata['namefrom'];

							foreach ($actions as $key => $action) {
								$namefrom = $namefrom_values[$key];
								$au = pg_query_params($db, $auflag_query, array($action, $finaldata['comefromcheck']));

								if ($au) {
									$row = pg_fetch_assoc($au);
									$auflag_value = $row['auflag'];

									$update_vt = pg_query_params($db, 'UPDATE vt'.$_SESSION['activeyears'].' SET "auflag" = $1, "auaction" = $2 WHERE "SDID" = $3', array($auflag_value, $action, $namefrom));
									$update_sd = pg_query_params($db, 'UPDATE sd'.$_SESSION['activeyears'].' SET "auflag" = $1, "auaction" = $2 WHERE "SDID" = $3', array($auflag_value, $action, $namefrom));

									if (!$update_sd || !$update_vt) {
										echo "UPDATE query failed: " . pg_last_error($db);
									}
								} else {
									echo "SELECT query failed: " . pg_last_error($db);
								}
							}
					

							if($resultst_rows && $result_rows)
							{
							
							$arr=array(implode(',',$finaldata['namefrom']));
							pg_query_params($db,'update vt'.$_SESSION['activeyears'].' set "STID"='.$finaldata['statenew'][0].',"DTID"='.$finaldata['districtnew'][0].',"SDID"='.$idsof.' where vt'.$_SESSION['activeyears'].'."SDID" = Any(string_to_array($1::text, \',\'::text)::bigint[])',$arr);
							
							$arr1=array(implode(',',$finaldata['namefrom']),0);
							pg_query_params('update sd'.$_SESSION['activeyears'].' set "is_deleted"=$2 where "SDID" = Any(string_to_array($1::text, \',\'::text)::bigint[])',$arr1);



							$finalqueryvt = 'insert into forreaddata2021 ("frfromids","frfromaction","frtoids","frdocids","frcomefrom",
							"frcomment","is_final","comeaction","STID","DTID","SDID","VTID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE","STIDR","DTIDR","SDIDR","VTIDR","created_by")
							(
							select  vt21."SDIDR"::BIGINT as "frfromids"
							,(select "frfromaction" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "frfromaction"
							,(select "SDIDACTIVE" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "frtoids"
							,(select "frdocids" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "frdocids"
							,(select "frcomefrom" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "frcomefrom"
							,(select "frcomment" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "frcomment"
							,(select "is_final" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "is_final"
							, (select "comeaction" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "comeaction"
							,vt21."STIDR"::integer AS "STIDR11",vt21."DTIDR"::integer AS "DTIDR11",vt21."SDIDR"::BIGINT AS "SDIDR11",vt21."VTIDR"::NUMERIC AS "VTIDR11"
							,vt21."STID",vt21."DTID",vt21."SDID",vt21."VTID",vt21."STIDR"::integer,vt21."DTIDR"::integer,vt21."SDIDR"::BIGINT,vt21."VTIDR"::NUMERIC
							,(select "created_by" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "created_by" from vt2021 as vt21 
							LEFT JOIN (select * from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as fr21 ON fr21."frtoids"=vt21."SDID" and fr21."frfromids"::TEXT=vt21."SDIDR" 
							where vt21."SDID"=$1 AND vt21."is_deleted"=1



							)';
							pg_query_params($db,$finalqueryvt,array($idsof));


						$task = "addfinish";
						}
						else
						{
						$task = "error";
						}


				}
				else
				{


						if(isset($finaldata['statenewarray']))
						{
						$statenewarray = explode(',',$finaldata['statenewarray']);
						}

						if(isset($finaldata['districtnewarray']))
						{
						$districtnewarray = explode(',',$finaldata['districtnewarray']);
						}

						if(isset($finaldata['statenewarrayfrom']))
							{
							$statenewarrayfrom = explode(',',$finaldata['statenewarrayfrom']);
							}

							if(isset($finaldata['districtnewarrayfrom']))
							{
							$districtnewarrayfrom = explode(',',$finaldata['districtnewarrayfrom']);
							}

							
					
					
						$linkDTarray = array();
						$forread = '';
						$forread1 = '';
						$idsof ='';
						for($j=0;$j<count($finaldata['newname']);$j++)
						{

							

							 $sql = 'SELECT sd'.$_SESSION['activeyears'].'."ID" FROM sd'.$_SESSION['activeyears'].' ORDER BY sd'.$_SESSION['activeyears'].'."ID" DESC LIMIT 1';

											$idsquery = pg_query($db,$sql);

											if(pg_numrows($idsquery)>0)
											{

												$idsquerydata = pg_fetch_array($idsquery);

											
											}

											$id = $idsquerydata['ID'] + 1;
											$id = str_pad($id, 5, '0', STR_PAD_LEFT);
											$idsof = $finaldata['districtnew'][$j]."".$id;


								$sqlo='Select "STIDR","DTIDR","SDIDR" from sd'.$_SESSION['activeyears'].' WHERE "SDID"=$1';
									$sqlold = pg_query_params($db,$sqlo,array($finaldata['namefrom'][0]));
									$sqlda = pg_fetch_array($sqlold);
								

							$stateconcate = array($finaldata['statenew'][$j],$finaldata['districtnew'][$j],$idsof,$finaldata['newname'][$j],$sqlda['STIDR'],$sqlda['DTIDR'],$sqlda['SDIDR'],'new',$_SESSION['login_id']);
							$state ='insert into sd'.$_SESSION['activeyears'].' ("STID","DTID","SDID","SDName","STIDR","DTIDR","SDIDR","flagofcreate","createdby") values ($1,$2,$3,$4,$5,$6,$7,$8,$9) returning "SDID"';
						pg_query_params($db,$state,$stateconcate);



							$frcomment='';

						
						
						$frcomment .='<strong style="color:#aa81f3;"><u>State/UT:</u></strong> '.$statenewarray[$j].'; <strong style="color:Green;"><u>District:</u></strong> '.$districtnewarray[$j].'; ';
// fullmerge(20_11)
						$frcomment .='<strong style="color:blue;"><u>Sub District:</u></strong> '.$finaldata['newname'][$j].' Created from '.$finaldata['namefromtext'].' ('.$finaldata['action'][0].');';


						
													$frcomment .=' <strong style="color:#45b0e2;"><u>Town:</u></strong> - ; <strong style="color:#15bed2;"><u>Village:</u></strong> - ;';

					


							$std = explode(',',$sqlda['STIDR']);
							$dtd = explode(',',$sqlda['DTIDR']);
							$sdd = explode(',',$sqlda['SDIDR']);
							$forread=array();
							for($fg=0;$fg<count($std);$fg++)
							{
									$forread=array();

						$forread = array($finaldata['namefrom'][0],$finaldata['action'][0],$idsof,$finaldata['docids'],$finaldata['comefromcheck'],$frcomment,'Create',$finaldata['fromstate'][0],$finaldata['districtget'][0],$finaldata['namefrom'][0],$finaldata['statenew'][$j],$finaldata['districtnew'][$j],$idsof,$std[$fg],$dtd[$fg],$sdd[$fg],$_SESSION['login_id']);
								
								 $insertforread = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","DTID","SDID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","STIDR","DTIDR","SDIDR","created_by") VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14,$15,$16,$17)';

								$result = pg_query_params($db,$insertforread,$forread);
							
							}
						



						

						$st=array_merge($finaldata['fromstate'],$finaldata['statenew']);
						$dt=array_merge($finaldata['districtget'],$finaldata['districtnew']);
						$ids[]=$idsof;

						

						}



						$sd=array_merge($finaldata['namefrom'],$ids);
						
						// $forreadqueryappend = rtrim($forread, ',');

						$frcomment1='';

						$frcomment1 .='<strong style="color:#aa81f3;"><u>State/UT:</u></strong> '.$statenewarrayfrom[0].'; <strong style="color:Green;"><u>District:</u></strong> '.$districtnewarrayfrom[0].'; ';

						$frcomment1 .='<strong style="color:blue;"><u>Sub District:</u></strong> '.$finaldata['namefromtext'].' '.$finaldata['action'][0].' &  Create '.implode(',',$finaldata['newname']).';';

						$frcomment1 .=' <strong style="color:#45b0e2;"><u>Town:</u></strong> - ; <strong style="color:#15bed2;"><u>Village:</u></strong> - ;';

						 // $forread1 = array($finaldata['namefrom'][0],$finaldata['action'][0],$finaldata['namefrom'][0],$finaldata['docids'],$finaldata['comefromcheck'],$frcomment1,'MAIN',$finaldata['fromstate'][0],$finaldata['districtget'][0],$finaldata['namefrom'][0],$finaldata['fromstate'][0],$finaldata['districtget'][0],$finaldata['namefrom'][0],$sqlda['STIDR'],$sqlda['DTIDR'],$sqlda['SDIDR'],$_SESSION['login_id']);


					// 	$forreadqueryappend1 = rtrim($forread1, ',');

						//By sahana full merge sub district level one to one 0111
						$auflag_query = 'SELECT auflag FROM unit WHERE auaction = $1 AND aulevel = $2';
						$actions = $finaldata['action'];
						$namefrom_values = $finaldata['namefrom'];

						foreach ($actions as $key => $action) {
							$namefrom = $namefrom_values[$key];
							$au = pg_query_params($db, $auflag_query, array($action, $finaldata['comefromcheck']));

							if ($au) {
								$row = pg_fetch_assoc($au);
								$auflag_value = $row['auflag'];

								$update_vt = pg_query_params($db, 'UPDATE vt'.$_SESSION['activeyears'].' SET "auflag" = $1, "auaction" = $2 WHERE "SDID" = $3', array($auflag_value, $action, $namefrom));
								$update_sd = pg_query_params($db, 'UPDATE sd'.$_SESSION['activeyears'].' SET "auflag" = $1, "auaction" = $2 WHERE "SDID" = $3', array($auflag_value, $action, $namefrom));

								if (!$update_sd || !$update_vt) {
									echo "UPDATE query failed: " . pg_last_error($db);
								}
							} else {
								echo "SELECT query failed: " . pg_last_error($db);
							}
						}
						
						$linkst='';
						for($k=0;$k<count($sd);$k++)
						{
						
						$insertlinkst = 'insert into documentlink'.$_SESSION['activeyears'].' (docids,linkstids,linkdtids,linksdids) VALUES ($1,$2,$3,$4)';

								
						$resultst = pg_query_params($db,$insertlinkst,array($finaldata['docids'],$st[$k],$dt[$k],$sd[$k]));

						}
						

						$resultst_rows = pg_affected_rows($resultst);

						


						if($resultst_rows!=0)
						{

						pg_query_params($db,'update vt'.$_SESSION['activeyears'].' set "STID"=$1,"DTID"=$2 ,"SDID"=$3 where vt'.$_SESSION['activeyears'].'."SDID" = Any(string_to_array($4::text, \',\'::text)::bigint[])',array($finaldata['statenew'][0],$finaldata['districtnew'][0],$ids[0],implode(',',$finaldata['namefrom'])));	



						// $sql_da = pg_query('select * from partiallydata'.$_SESSION['activeyears'].' where docids='.$finaldata['docids'].' AND pstatus=0');
						// if(pg_numrows($sql_da)==0)
						// {
						// pg_query('update documentdata'.$_SESSION['activeyears'].' set docstatus=1 where docids='.$finaldata['docids'].'');

						// }

						 pg_query_params($db,'update documentdata'.$_SESSION['activeyears'].' set docstatus=$1 where docids=$2',array(1,$finaldata['docids']));

						pg_query_params('update sd'.$_SESSION['activeyears'].' set "is_deleted"=$1 where "STID"=$2 and "DTID"=$3 and "SDID" = Any(string_to_array($4::text, \',\'::text)::bigint[])',array(0,$finaldata['fromstate'][0],$finaldata['districtget'][0],implode(',',$finaldata['namefrom'])));	
						
						// 	$insertforread1 = 'insert into forreaddata'.$_SESSION['activeyears'].' (frfromids,frfromaction,frtoids,frdocids,frcomefrom,comeaction) VALUES '.$forreadqueryappend1.'';
						// pg_query($db,$insertforread1);
							// for($jm=0;$jm<count($forread);$jm++)
							// {
							// 	$insertforread = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","DTID","SDID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","STIDR","DTIDR","SDIDR","created_by") VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14,$15,$16,$17)';

							// 	$result = pg_query_params($db,$insertforread,$forread[$jm]);
							// }
						

					// 	print_r($ids);
						for($kl=0;$kl<count($ids);$kl++)
						{

						
						 $finalqueryvt = 'insert into forreaddata2021 ("frfromids","frfromaction","frtoids","frdocids","frcomefrom",
						"frcomment","is_final","comeaction","STID","DTID","SDID","VTID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE","STIDR","DTIDR","SDIDR","VTIDR","created_by")
						(
						 select  vt21."SDIDR"::BIGINT as "frfromids"
						,(select "frfromaction" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "frfromaction"
						,(select "SDIDACTIVE" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "frtoids"
						,(select "frdocids" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "frdocids"
						,(select "frcomefrom" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "frcomefrom"
						,(select "frcomment" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "frcomment"
						,(select "is_final" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "is_final"
						, (select "comeaction" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "comeaction"
						,vt21."STIDR"::integer AS "STIDR11",vt21."DTIDR"::integer AS "DTIDR11",vt21."SDIDR"::BIGINT AS "SDIDR11",vt21."VTIDR"::NUMERIC AS "VTIDR11"
						,vt21."STID",vt21."DTID",vt21."SDID",vt21."VTID",vt21."STIDR"::integer,vt21."DTIDR"::integer,vt21."SDIDR"::BIGINT,vt21."VTIDR"::NUMERIC
						,(select "created_by" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "created_by" from vt2021 as vt21 
						LEFT JOIN (select * from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as fr21 ON fr21."frtoids"=vt21."SDID" and fr21."frfromids"::TEXT=vt21."SDIDR" 
						where vt21."SDID"=$1 AND vt21."is_deleted"=$2
						)';
						pg_query_params($db,$finalqueryvt,array($ids[$kl],1));

						}



						$task = "addfinish";
						}
						else
						{
						$task = "error";
						}
				}


		}
		else
		{

				//By sahana split subdistrict, many to one 0111 2811
				$auflag_query = 'SELECT auflag FROM unit WHERE auaction = $1 AND aulevel = $2';
				$actions = $retdata['action'];
				$namefrom_values = $retdata['namefrom'];

				foreach ($actions as $key => $action) {
					$namefrom = $namefrom_values[$key];

					$au = pg_query_params($db, $auflag_query, array($action, $retdata['comefromcheck']));

					if ($au) {
						$row = pg_fetch_assoc($au);
						$auflag_value = $row['auflag'];

						$update_vt = pg_query_params($db, 'UPDATE vt'.$_SESSION['activeyears'].' SET "auflag" = $1, "auaction" = $2 WHERE "SDID" = $3', array($auflag_value, $action, $namefrom));
						$update_sd = pg_query_params($db, 'UPDATE sd'.$_SESSION['activeyears'].' SET "auflag" = $1, "auaction" = $2 WHERE "SDID" = $3', array($auflag_value, $action, $namefrom));
						
						if (!$update_sd || !$update_vt) {
							echo "UPDATE query failed: " . pg_last_error($db);
						}
					} else {
						echo "SELECT query failed: " . pg_last_error($db);
					}
				}

				$dataofremove = explode(',',$retdata['origremove']);
				$removearraysd = array();

				$linkSTarray='';
				if($retdata['flag']=='namefrom')
				{


						if(isset($retdata['statenewarray']))
						{
						$statenewarray = explode(',',$retdata['statenewarray']);
						}

						if(isset($retdata['districtnewarray']))
						{
						$districtnewarray = explode(',',$retdata['districtnewarray']);
						}

						if(isset($finaldata['statenewarrayfrom']))
							{
							$statenewarrayfrom = explode(',',$finaldata['statenewarrayfrom']);
							}

							if(isset($finaldata['districtnewarrayfrom']))
							{
							$districtnewarrayfrom = explode(',',$finaldata['districtnewarrayfrom']);
							}

						
					



						$sql = 'SELECT sd'.$_SESSION['activeyears'].'."ID" FROM sd'.$_SESSION['activeyears'].' ORDER BY sd'.$_SESSION['activeyears'].'."ID" DESC LIMIT 1';

											$idsquery = pg_query($db,$sql);

											if(pg_numrows($idsquery)>0)
											{

												$idsquerydata = pg_fetch_array($idsquery);

											
											}

											$id = $idsquerydata['ID'] + 1;
											$id = str_pad($id, 5, '0', STR_PAD_LEFT);
											
											$idsof = $retdata['districtnew'][0]."".$id;

											$sqlo='Select "STIDR","DTIDR","SDIDR" from sd'.$_SESSION['activeyears'].' WHERE "SDID" = Any(string_to_array($1::text, \',\'::text)::bigint[]) AND is_deleted=$2';
											$sqlold = pg_query_params($db,$sqlo,array(implode(',',$retdata['namefrom']),1));
											$sqlda = pg_fetch_all($sqlold);

											

						//$stateconcate = array($retdata['statenew'][0],$retdata['districtnew'][0],$idsof,ucwords(strtolower($retdata['newname'][0])),implode(',',$retdata['fromstate']),implode(',',$retdata['districtget']),implode(',',$retdata['namefrom']),'new',$_SESSION['login_id']);
                        //Titlecase issue resolved by gowthami
						$stateconcate = array($retdata['statenew'][0],$retdata['districtnew'][0],$idsof,$retdata['newname'][0],implode(',',$retdata['fromstate']),implode(',',$retdata['districtget']),implode(',',$retdata['namefrom']),'new',$_SESSION['login_id']);


						$state ='insert into sd'.$_SESSION['activeyears'].' ("STID","DTID","SDID","SDName","STIDR","DTIDR","SDIDR","flagofcreate","createdby") values ($1,$2,$3,$4,$5,$6,$7,$8,$9) returning "SDID"';

						$result1 = pg_query_params($db,$state,$stateconcate);
						$fch = pg_fetch_all($result1);
	

						$st=array_merge($retdata['fromstate'],$retdata['statenew']);
						$dt=array_merge($retdata['districtget'],$retdata['districtnew']);

						$sd=array_merge($retdata['namefrom'],array($idsof));

						$partiallylevel = '';

						$linkDTarray = array();

						$forread = array();
						$forread1 = array();

						for($j=0;$j<count($retdata['namefrom']);$j++)
						{

						if($retdata['action'][$j]=='Full Merge')
						{
								array_push($removearraysd,$retdata['namefrom'][$j]); 
						}


						if(isset($finaldata['addlinksDTID'.$j.'']))
						{


							if(isset($finaldata['partiallylevel'.$j.'']))
						{
						$havep = true;

							for($a=0;$a<count($finaldata['partiallylevel'.$j.'']);$a++)
								{
									$partiallylevel .="('".$retdata['comefromcheck']."',".$retdata['namefrom'][$j].",'".$retdata['action'][$j]."',".$idsof.",".$retdata['docids'].",".$finaldata['partiallylevel'.$j.''][$a].")," ;
								}



						$finaldata['addlinksDTID'.$j.''] = array_diff($finaldata['addlinksDTID'.$j.''],$finaldata['partiallylevel'.$j.'']);
						}


						$linkDTarray=array_merge($linkDTarray,$finaldata['addlinksDTID'.$j.'']);	 		
						}

						$frcomment='';
						
						// many to one subdistricts flow forread and remarks solved by shashi
						$frcomment = '';
						if ( isset($retdata['action']) && is_array($retdata['action'] )&& isset($retdata['namefromtext'])) {
							$namefromtextt = explode(',', $retdata['namefromtext']);
							$frcommentt = '';
							for ($a = 0; $a < count($namefromtextt); $a++) {
								$frcommentt .= ' ' . $namefromtextt[$a] . ' (' . $retdata['action'][$a] . ');';
							}
						}
						$frcomment .='<strong style="color:#aa81f3;"><u>State/UT:</u></strong> '.$statenewarray[0].'; <strong style="color:Green;"><u>District:</u></strong> '.$districtnewarray[0].'; ';
							$frcomment .= '<strong style="color:blue;"><u>Sub District:</u></strong> ' . $retdata['newname'][0] . ' Created from ' . $frcommentt . ' ';
							$frcomment .= ' <strong style="color:#45b0e2;"><u>Town:</u></strong> - ; <strong style="color:#15bed2;"><u>Village:</u></strong> - ;';
												$frcomment1='';
												$frcomment1 .='<strong style="color:#aa81f3;"><u>State/UT:</u></strong> '.$statenewarray[0].'; <strong style="color:Green;"><u>District:</u></strong> '.$districtnewarray[0].'; ';
												$frcomment1 .='<strong style="color:blue;"><u>Sub District:</u></strong> '. $frcommentt.' & Create New '.$retdata['newname'][0].';';
												$frcomment1 .=' <strong style="color:#45b0e2;"><u>Town:</u></strong> - ; <strong style="color:#15bed2;"><u>Village:</u></strong> - ;';
						// till here  

						





						$forread[$j] = array($retdata['namefrom'][$j],$retdata['action'][$j],$idsof,$retdata['docids'],$retdata['comefromcheck'],$frcomment,'Create',$retdata['fromstate'][$j],$retdata['districtget'][$j],$retdata['namefrom'][$j],$retdata['statenew'][0],$retdata['districtnew'][0],$idsof,$sqlda[$j]['STIDR'],$sqlda[$j]['DTIDR'],$sqlda[$j]['SDIDR'],$_SESSION['login_id']);

						if($retdata['action'][$j]!='Full Merge')
						{
						$forread1[$j]= array($retdata['namefrom'][$j],$retdata['action'][$j],$retdata['namefrom'][$j],$retdata['docids'],$retdata['comefromcheck'],$frcomment1,'MAIN',$retdata['fromstate'][$j],$retdata['districtget'][$j],$retdata['namefrom'][$j],$retdata['fromstate'][$j],$retdata['districtget'][$j],$retdata['namefrom'][$j],$sqlda[$j]['STIDR'],$sqlda[$j]['DTIDR'],$sqlda[$j]['SDIDR'],$_SESSION['login_id']);

						}



						}


						// $forreadqueryappend = rtrim($forread, ',');
						// $forreadqueryappend1 = rtrim($forread1, ',');
						// print_r($forread1);
						

						for($k=0;$k<count($st);$k++)
						{
						$insertlinkst = 'insert into documentlink'.$_SESSION['activeyears'].' (docids,linkstids,linkdtids,linksdids) VALUES ($1,$2,$3,$4)';
						$resultst = pg_query_params($db,$insertlinkst,array($retdata['docids'],$st[$k],$dt[$k],$sd[$k]));

						}
					
					

						
						if(count($linkDTarray)>0)
						{

						for($l=0;$l<count($linkDTarray);$l++)
						{
						$insertlinkdt = 'insert into documentlink'.$_SESSION['activeyears'].' (docids,linkstids,linkdtids,linksdids,linkvtids) VALUES '.$linkdtfinal.'';	
						$resultdt = pg_query_params($db,$insertlinkdt,array($retdata['docids'],$st[$l],$dt[$l],$idsof,$linkDTarray[$l]));

						}
						

						}


					
			

						$resultst_rows = pg_affected_rows($resultst);

						if($resultst_rows!=0)
						{


						pg_query_params($db,'update vt'.$_SESSION['activeyears'].' set "STID"=$1,"DTID"=$2,"SDID"=$3 where vt'.$_SESSION['activeyears'].'."VTID" = Any(string_to_array($4::text, \',\'::text)::NUMERIC[])',array($retdata['statenew'][0],$retdata['districtnew'][0],$idsof,implode(',',$linkDTarray)));

						pg_query_params($db,'update vt'.$_SESSION['activeyears'].' set "STID"=$1,"DTID"=$2,"SDID"=$3 where vt'.$_SESSION['activeyears'].'."SDID" = Any(string_to_array($4::text, \',\'::text)::bigint[])',array($retdata['statenew'][0],$retdata['districtnew'][0],$idsof,implode(',',$removearraysd)));
												
						if($partiallylevel!='')
						{

						$partiallylevelquery = rtrim($partiallylevel, ',');

						pg_query($db,"insert into partiallydata".$_SESSION['activeyears']." (comefrom,fromids,comeaction,toids,docids,partiallydataids) VALUES ".$partiallylevelquery." ");
						}



						if($finaldata['partiallyids']!='')
						{

						pg_query_params($db,'update partiallydata'.$_SESSION['activeyears'].' set "pstatus"=$1 where partiallyids=$2',array(1,$finaldata['partiallyids']));	
						}

						$sql_da = pg_query_params($db,'select * from partiallydata'.$_SESSION['activeyears'].' where docids=$1 AND pstatus=$2',array($retdata['docids'],1));
						if(pg_numrows($sql_da)==0)
						{

							pg_query_params($db,'update documentdata'.$_SESSION['activeyears'].' set docstatus=$1 where docids=$2',array(1,$retdata['docids']));

						}

						if(count($removearraysd)>0)
						{
								pg_query_params($db,'update sd'.$_SESSION['activeyears'].' set "is_deleted"=$1 where "SDID" = Any(string_to_array($2::text, \',\'::text)::bigint[])',array(0,implode(',',$removearraysd)));
						}
					



						if(count($forread1)>0)
						{
							$forread1 = array_values($forread1);
							
						for($fm=0;$fm<count($forread1);$fm++)
						{

						$insertforread1 = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","DTID","SDID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","STIDR","DTIDR","SDIDR","created_by") VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14,$15,$16,$17)';
						pg_query_params($db,$insertforread1,$forread1[$fm]);

						}

						}
							// print_r($sqlda);
						for($hj=0;$hj<count($forread);$hj++)
						{
								$insertforread = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","DTID","SDID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","STIDR","DTIDR","SDIDR","created_by") VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14,$15,$16,$17)';


							$result = pg_query_params($db,$insertforread,$forread[$hj]);
						}	
						
						


						$finalqueryvt = 'insert into forreaddata2021 ("frfromids","frfromaction","frtoids","frdocids","frcomefrom",
						"frcomment","is_final","comeaction","STID","DTID","SDID","VTID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE","STIDR","DTIDR","SDIDR","VTIDR","created_by")
						(
						select  vt21."SDIDR"::BIGINT as "frfromids"
						,(select "frfromaction" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "frfromaction"
						,(select "SDIDACTIVE" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "frtoids"
						,(select "frdocids" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "frdocids"
						,(select "frcomefrom" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "frcomefrom"
						,(select "frcomment" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "frcomment"
						,(select "is_final" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "is_final"
						, (select "comeaction" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "comeaction"
						,vt21."STIDR"::integer AS "STIDR11",vt21."DTIDR"::integer AS "DTIDR11",vt21."SDIDR"::BIGINT AS "SDIDR11",vt21."VTIDR"::NUMERIC AS "VTIDR11"
						,vt21."STID",vt21."DTID",vt21."SDID",vt21."VTID",vt21."STIDR"::integer,vt21."DTIDR"::integer,vt21."SDIDR"::BIGINT,vt21."VTIDR"::NUMERIC
						,(select "created_by" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "created_by" from vt2021 as vt21 
						LEFT JOIN (select * from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as fr21 ON fr21."frtoids"=vt21."SDID" and fr21."frfromids"::TEXT=vt21."SDIDR" 
						where vt21."SDID"=$1 AND vt21."is_deleted"=$2
						)';
					 	pg_query_params($db,$finalqueryvt,array($idsof,1));




						$task = "addfinish";
						}
						else
						{
						$task = "error";
						}


				}
				else
				{

		
					$statenewarray='';
					$districtnewarray='';
					$statenewarrayfrom='';
					$districtnewarrayfrom='';

	
					if(isset($retdata['statenewarray']))
						{
						$statenewarray = explode(',',$retdata['statenewarray']);
						}

						if(isset($retdata['districtnewarray']))
						{
						$districtnewarray = explode(',',$retdata['districtnewarray']);
						}

						if(isset($finaldata['statenewarrayfrom']))
							{
							$statenewarrayfrom = explode(',',$finaldata['statenewarrayfrom']);
							}

							if(isset($finaldata['districtnewarrayfrom']))
							{
							$districtnewarrayfrom = explode(',',$finaldata['districtnewarrayfrom']);
							}

					


						$partiallylevel = '';

						$linkSTarray='';
						

						$linkSTarray = $retdata['namefrom'];

					
						$linkDTarray = array();
						$forread = '';
						$forread1 = '';
						$idsof ='';
						for($j=0;$j<count($retdata['newname']);$j++)
						{

							

							 $sql = 'SELECT sd'.$_SESSION['activeyears'].'."ID" FROM sd'.$_SESSION['activeyears'].' ORDER BY sd'.$_SESSION['activeyears'].'."ID" DESC LIMIT 1';

											$idsquery = pg_query_params($db,$sql,array());

											if(pg_numrows($idsquery)>0)
											{

												$idsquerydata = pg_fetch_array($idsquery);

											
											}

											$id = $idsquerydata['ID'] + 1;
											$id = str_pad($id, 5, '0', STR_PAD_LEFT);
											$idsof = $retdata['districtnew'][$j]."".$id;

							$sqlo='Select "STIDR","DTIDR","SDIDR" from sd'.$_SESSION['activeyears'].' WHERE "SDID"=$1 AND is_deleted=$2';
									$sqlold = pg_query_params($db,$sqlo,array($retdata['namefrom'][0],1));
									$sqlda = pg_fetch_array($sqlold);



							$stateconcate = array($retdata['statenew'][$j],$retdata['districtnew'][$j],$idsof,$retdata['newname'][$j],$sqlda['STIDR'],$sqlda['DTIDR'],$sqlda['SDIDR'],'new',$_SESSION['login_id']);


 						$state ='insert into sd'.$_SESSION['activeyears'].' ("STID","DTID","SDID","SDName","STIDR","DTIDR","SDIDR","flagofcreate","createdby") values ($1,$2,$3,$4,$5,$6,$7,$8,$9) returning "SDID"';
						 pg_query_params($db,$state,$stateconcate);

						//By sahana split subdistrict one to one 0111 0611
						$auflag_query = 'SELECT auflag FROM unit WHERE auaction = $1 AND aulevel = $2';
						$au = pg_query_params($db, $auflag_query, array($retdata['action'][0], $retdata['comefromcheck']));

						if ($au) {
							$row = pg_fetch_assoc($au);
							$auflag_value = $row['auflag'];
							$namefrom = $retdata['namefrom'][0];

							$update_vt = pg_query_params($db, 'UPDATE vt'.$_SESSION['activeyears'].' SET "auflag" = $1, "auaction" = $2 WHERE "SDID" = $3', array($auflag_value, $retdata['action'][0], $namefrom));
							$update_sd = pg_query_params($db, 'UPDATE sd'.$_SESSION['activeyears'].' SET "auflag" = $1, "auaction" = $2 WHERE "SDID" = $3', array($auflag_value, $retdata['action'][0], $namefrom));
							if (!$update_sd || !$update_vt) {  
								echo "UPDATE queries failed: " . pg_last_error($db);
							}
						} else {
							echo "SELECT query failed: " . pg_last_error($db);
						} 

						if(isset($finaldata['partiallylevel'.$j.'']))
						{

						$havep = true;


						$finaldata['addlinksDTID'.$j.''] = array_diff($finaldata['addlinksDTID'.$j.''],$finaldata['partiallylevel'.$j.'']);

						// $partiallylevel = array_merge($partiallylevel,$finaldata['partiallylevel'.$j.'']);

						}


						if(isset($finaldata['addlinksDTID'.$j.'']))
						{
						$linkDTarray=array_merge($linkDTarray,$finaldata['addlinksDTID'.$j.'']);	 	
						}

						$frcomment='';
						
						$frcomment .='<strong style="color:#aa81f3;"><u>State/UT:</u></strong> '.$statenewarray[$j].'; <strong style="color:Green;"><u>District:</u></strong> '.$districtnewarray[$j].'; ';
							// $frcomment .='<strong style="color:blue;"><u>Sub District:</u></strong> '.$retdata['newname'][$j].' Created from '.$retdata['namefromtext'].';';
								// Subdistrict level remarks (one to one)
						$frcomment .='<strong style="color:blue;"><u>Sub District:</u></strong> '.$retdata['newname'][$j].' Created from '.$retdata['namefromtext'].' (Split);';
							$frcomment .=' <strong style="color:#45b0e2;"><u>Town:</u></strong> - ; <strong style="color:#15bed2;"><u>Village:</u></strong> - ;';
						

							$std = explode(',',$sqlda['STIDR']);
							$dtd = explode(',',$sqlda['DTIDR']);
							$sdd = explode(',',$sqlda['SDIDR']);
							$forread=array();
							for($fg=0;$fg<count($std);$fg++)
							{
									$forread= array($retdata['namefrom'][0],$retdata['action'][0],$idsof,$retdata['docids'],$retdata['comefromcheck'],$frcomment,'Create',$retdata['fromstate'][0],$retdata['districtget'][0],$retdata['namefrom'][0],$retdata['statenew'][$j],$retdata['districtnew'][$j],$idsof,$std[$fg],$dtd[$fg],$sdd[$fg],$_SESSION['login_id']);
								
								 $insertforread = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","DTID","SDID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","STIDR","DTIDR","SDIDR","created_by") VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14,$15,$16,$17)';
						
								$result = pg_query_params($db,$insertforread,$forread);

							}


							// for($jk=0;$jk<count($forread);$jk++)
							// {


							// }


						 
						
				
						$result_rows = pg_affected_rows($result);

						




						$st=array_merge($retdata['fromstate'],$retdata['statenew']);
						$dt=array_merge($retdata['districtget'],$retdata['districtnew']);
						$ids[]=$idsof;

						

						}

						

						$sd=array_merge($retdata['namefrom'],$ids);
						// $forreadqueryappend = rtrim($forread, ',');

						$frcomment1='';
						
						$frcomment1 .='<strong style="color:#aa81f3;"><u>State/UT:</u></strong> '.$statenewarrayfrom[0].'; <strong style="color:Green;"><u>District:</u></strong> '.$districtnewarrayfrom[0].'; ';
						$frcomment1 .='<strong style="color:blue;"><u>Sub District:</u></strong> '.$retdata['namefromtext'].' '.$retdata['action'][0].' &  Create '.implode($retdata['newname']).';';
						$frcomment1 .=' <strong style="color:#45b0e2;"><u>Town:</u></strong> - ; <strong style="color:#15bed2;"><u>Village:</u></strong> - ;';
						

							$std1 = explode(',',$sqlda['STIDR']);
							$dtd1 = explode(',',$sqlda['DTIDR']);
							$sdd1 = explode(',',$sqlda['SDIDR']);
							$forread1=array();
							for($fg1=0;$fg1<count($std1);$fg1++)
							{
						$forread1[$fg1]= array($retdata['namefrom'][0],$retdata['action'][0],$retdata['namefrom'][0],$retdata['docids'],$retdata['comefromcheck'],$frcomment1,'MAIN',$retdata['fromstate'][0],$retdata['districtget'][0],$retdata['namefrom'][0],$retdata['fromstate'][0],$retdata['districtget'][0],$retdata['namefrom'][0],$std1[$fg1],$dtd1[$fg1],$sdd1[$fg1],$_SESSION['login_id']);
							}
					// 	$forreadqueryappend1 = rtrim($forread1, ',');




						if($dataofremove[0]==1)
						{

						array_push($removearraysd,$retdata['namefrom'][0]); 
						
						}


						
						// $linkst='';
						for($k=0;$k<count($sd);$k++)
						{
						// $linkst .="(".$retdata['docids'].",".$st[$k].",".$dt[$k].",".$sd[$k]."),";

						$insertlinkst = 'insert into documentlink'.$_SESSION['activeyears'].' (docids,linkstids,linkdtids,linksdids) VALUES ($1,$2,$3,$4)';
						$resultst = pg_query_params($db,$insertlinkst,array($retdata['docids'],$st[$k],$dt[$k],$sd[$k]));

						}
						// $linkstfinal = rtrim($linkst, ',');


						// print_r($linkDTarray);
						// exit;
						$linkdt='';
						$linkdtupdate=array();
						for($l=0;$l<count($ids);$l++)
						{

						if(isset($finaldata['addlinksDTID'.$l.'']))
						{
						if(isset($finaldata['partiallylevel'.$l.'']))
						{

						$havep = true;
						for($a=0;$a<count($finaldata['partiallylevel'.$l.'']);$a++)
						{
							//modified by Gowthami to solve the issue related to wine line in Audt Id
							//$partiallylevel .="('".$retdata['comefromcheck']."',".$retdata['namefrom'][0].",'".$retdata['action'][0]."',".$ids[$l].",".$retdata['docids'].",".$finaldata['partiallylevel'.$l.''][$a].")," ;
							$partiallylevel .="('".$retdata['comefromcheck']."',".$retdata['namefrom'][0].",'".$retdata['action'][0]."',".$ids[$l].",".$retdata['docids'].",".$finaldata['partiallylevel'.$l.''][$a].",".$retdata['fromstate'][0].",".$retdata['districtget'][0].")," ;
							}
						$finaldata['addlinksDTID'.$l.''] = array_diff($finaldata['addlinksDTID'.$l.''],$finaldata['partiallylevel'.$l.'']);
						}

						$datao = array_values(array_filter($finaldata['addlinksDTID'.$l.'']));

						for($b=0;$b<count($datao);$b++)
						{



						$linkdtupdate[$l][$b]=$datao[$b];
						if(count($linkDTarray)>0)
						{

						// 	$linkdt .="(".$retdata['docids'].","..",".$retdata['districtnew'][$l].",".$ids[$l].",".$datao[$b]."),";


						$insertlinkdt = 'insert into documentlink'.$_SESSION['activeyears'].' (docids,linkstids,linkdtids,linksdids,linkvtids) VALUES ($1,$2,$3,$4,$5)';	

						$resultdt = pg_query_params($db,$insertlinkdt,array($retdata['docids'],$retdata['statenew'][$l],$retdata['districtnew'][$l],$ids[$l],$datao[$b]));
						}

						

						}

						}
						}


						// $linkdtfinal = rtrim($linkdt, ',');

						// $stateconcatefinal = rtrim($stateconcate, ',');

					

						// INSERT DATA
						$fl=false;
						if($retdata['action'][0]=='Full Merge')
						{
							$fl=true;
								// array_push($removearraysd,$retdata['namefrom'][$j]); 
						}


								$resultst_rows = pg_affected_rows($resultst);	

						if($result_rows!=0 && $resultst_rows!=0)
						{



						for($mk=0;$mk<count($linkdtupdate);$mk++)
						{



						pg_query_params($db,'update vt'.$_SESSION['activeyears'].' set "STID"=$1,"DTID"=$2 ,"SDID"=$3 where vt'.$_SESSION['activeyears'].'."VTID" = Any(string_to_array($4::text, \',\'::text)::NUMERIC[])',array($retdata['statenew'][$mk],$retdata['districtnew'][$mk],$ids[$mk],implode(',',$linkdtupdate[$mk])));	

						if($fl)
						{
							pg_query_params($db,'update vt'.$_SESSION['activeyears'].' set "STID"=$1,"DTID"=$2 ,"SDID"=$3 where vt'.$_SESSION['activeyears'].'."SDID" = Any(string_to_array($4::text, \',\'::text)::bigint[])',array($retdata['statenew'][$mk],$retdata['districtnew'][$mk],$ids[$mk],implode(',',$linkdtupdate[$mk])));	
						}

						// pg_query('update wd'.$_SESSION['activeyears'].' set "STID"='.$retdata['statenew'][$mk].',"DTID"='.$retdata['districtnew'][$mk].' ,"SDID"='.$ids[$mk].' where wd'.$_SESSION['activeyears'].'."VTID" IN ('.implode(',',$linkdtupdate[$mk]).')');	
						}

						if($partiallylevel!='')
						{



						$partiallylevelquery = rtrim($partiallylevel, ',');

                        //modified by Gowthami to solve the issue related to wine line in AUdtid
						//pg_query("insert into partiallydata".$_SESSION['activeyears']." (comefrom,fromids,comeaction,toids,docids,partiallydataids) VALUES ".$partiallylevelquery." ");
						pg_query("insert into partiallydata".$_SESSION['activeyears']." (comefrom,fromids,comeaction,toids,docids,partiallydataids,stid,dtid) VALUES ".$partiallylevelquery." ");
					}



						if($finaldata['partiallyids']!='')
						{


						pg_query_params($db,'update partiallydata'.$_SESSION['activeyears'].' set "pstatus"=$1 where partiallyids=$2',array(1,$finaldata['partiallyids']));	
						}

						$sql_da = pg_query_params($db,'select * from partiallydata'.$_SESSION['activeyears'].' where docids=$1 AND pstatus=$2',array($retdata['docids'],0));
						if(pg_numrows($sql_da)==0)
						{
						pg_query_params($db,'update documentdata'.$_SESSION['activeyears'].' set docstatus=$1 where docids=$2',array(1,$retdata['docids']));

						}


						if($fl)
						{
						pg_query_params($db,'update sd'.$_SESSION['activeyears'].' set "is_deleted"=$1 where "STID"=$2 and "DTID"=$3 and "SDID" = Any(string_to_array($4::text, \',\'::text)::bigint[])',array(0,$retdata['fromstate'][0],$retdata['districtget'][0],implode(',',$removearraysd)));	
						}
						else
						{
							for($jk=0;$jk<count($forread1);$jk++)
							{
								$insertforread1 = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","DTID","SDID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","STIDR","DTIDR","SDIDR","created_by") VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14,$15,$16,$17)';
						pg_query_params($db,$insertforread1,$forread1[$jk]);
							
							}
							
						}


						for($kl=0;$kl<count($ids);$kl++)
						{
							$aa=array($ids[$kl],1);
						
						 $finalqueryvt = 'insert into forreaddata2021 ("frfromids","frfromaction","frtoids","frdocids","frcomefrom",
						"frcomment","is_final","comeaction","STID","DTID","SDID","VTID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE","STIDR","DTIDR","SDIDR","VTIDR","created_by")
						(select  vt21."SDIDR"::BIGINT as "frfromids"
						,(select "frfromaction" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "frfromaction"
						,(select "SDIDACTIVE" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "frtoids"
						,(select "frdocids" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "frdocids"
						,(select "frcomefrom" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "frcomefrom"
						,(select "frcomment" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "frcomment"
						,(select "is_final" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "is_final"
						, (select "comeaction" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "comeaction"
						,vt21."STIDR"::integer AS "STIDR11",vt21."DTIDR"::integer AS "DTIDR11",vt21."SDIDR"::BIGINT AS "SDIDR11",vt21."VTIDR"::NUMERIC AS "VTIDR11"
						,vt21."STID",vt21."DTID",vt21."SDID",vt21."VTID",vt21."STIDR"::integer,vt21."DTIDR"::integer,vt21."SDIDR"::BIGINT,vt21."VTIDR"::NUMERIC
						,(select "created_by" from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as "created_by" from vt2021 as vt21 
						LEFT JOIN (select * from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as fr21 ON fr21."frtoids"=vt21."SDID" and fr21."frfromids"::TEXT=vt21."SDIDR" 
						where vt21."SDID"=$1 AND vt21."is_deleted"=$2
						)';
 						pg_query_params($db,$finalqueryvt,$aa);

						}



						$task = "addfinish";
						}
						else
						{
						$task = "error";
						}





				}



	
		}
	}

	else if($finaldata['applyon']=='Village / Town' || $finaldata['comefromcheck']=='Village / Town')
	{


		$dataofremove = explode(',',$finaldata['origremove']);
		$removearraysd = array();
		
		if($finaldata['flag']=='namefrom')
		{

				//By sahana village split many to one, full merge many to one, and split and full merge many to one 0111 2811
				$auflag_query = 'SELECT auflag FROM unit WHERE auaction = $1 AND aulevel = $2';
				$actions = $finaldata['action'];
				$namefrom_values = [];
				
				foreach ($finaldata as $key => $value) {
					if (preg_match('/^namefrom\d*$/', $key)) {
					$namefrom_values[] = $value;
					}
				}

				foreach ($actions as $action) {
					if (empty($namefrom_values)) {
						break; 
					}
				
					$namefrom = array_shift($namefrom_values);
				
					foreach ($namefrom as $item) {
						$au = pg_query_params($db, $auflag_query, array($action, $finaldata['comefromcheck']));
				
						if ($au) {
							$row = pg_fetch_assoc($au);
							$auflag_value = $row['auflag'];
							$update_vt = pg_query_params($db, 'UPDATE vt'.$_SESSION['activeyears'].' SET "auflag" = $1, "auaction" = $2 WHERE "VTID" = $3', array($auflag_value, $action, $item));
							if (!$update_vt) {
								echo "UPDATE query failed: " . pg_last_error($db);
						}
						} else {
							echo "SELECT query failed: " . pg_last_error($db);
					}
					}
				}

				if(isset($finaldata['statenewarray']))
				{
				$statenewarray = explode(',',$finaldata['statenewarray']);
				}

				if(isset($finaldata['districtnewarray']))
				{
				$districtnewarray = explode(',',$finaldata['districtnewarray']);
				}

				if(isset($finaldata['sddistrictnewarray']))
				{
				$sddistrictnewarray = explode(',',$finaldata['sddistrictnewarray']);
				}


					if(isset($finaldata['statenewarrayfrom']))
						{
						$statenewarrayfrom = explode(',',$finaldata['statenewarrayfrom']);
						}

						if(isset($finaldata['districtnewarrayfrom']))
						{
						$districtnewarrayfrom = explode(',',$finaldata['districtnewarrayfrom']);
						}

						if(isset($finaldata['sddistrictnewarrayfrom']))
						{
						$sddistrictnewarrayfrom = explode(',',$finaldata['sddistrictnewarrayfrom']);
						}


				$sql = 'SELECT vt'.$_SESSION['activeyears'].'."ID" FROM vt'.$_SESSION['activeyears'].' ORDER BY vt'.$_SESSION['activeyears'].'."ID" DESC LIMIT 1';

								$idsquery = pg_query_params($db,$sql,array());

								if(pg_numrows($idsquery)>0)
								{

									$idsquerydata = pg_fetch_array($idsquery);

								
								}

								$id = $idsquerydata['ID'] + 1;
								$id = str_pad($id, 6, '0', STR_PAD_LEFT);
								
								$idsof = $finaldata['sddistrictnew'][0]."".$id;

				$st=array_merge($finaldata['fromstate'],$finaldata['statenew']);
				$dt=array_merge($finaldata['districtget'],$finaldata['districtnew']);
				$sd=array_merge($finaldata['sddistrictget'],$finaldata['sddistrictnew']);

				// $vt=array_merge($finaldata['namefrom'],array($idsof));

				$ii = explode(',',$finaldata['ind']);
				$linkDTarray = array();
				$forread = '';
				$forread1 = '';
				$linkst='';
			
				$vt= array();
				$vtf= array();
				$allvt=array();
				for($o=0;$o<count($finaldata['action']);$o++)
				{


					

					if($ii[$o]==1 && $finaldata['action'][$o]=='Split')
					{
						
							for($j=0;$j<count($finaldata['namefrom']);$j++)
							{

								$sqlo1='Select "STIDR","DTIDR","SDIDR","VTIDR" from vt'.$_SESSION['activeyears'].' WHERE "VTID"=$1 AND is_deleted=$2';
								$sqlold1 = pg_query_params($db,$sqlo1,array($finaldata['namefrom'][$j],1));
								$sqlda1 = pg_fetch_array($sqlold1);



								$frcomment='';
								$frcomment .='<strong style="color:#aa81f3;"><u>State/UT:</u></strong> '.$statenewarray[0].'; <strong style="color:Green;"><u>District:</u></strong> '.$districtnewarray[0].'; <strong style="color:blue;"><u>Sub District:</u></strong> '.$sddistrictnewarray[0].'; ';
								
						// village level remarks split and full merge code modified by shashi (12122023)		
						$actionLength = count($finaldata['action']);
						$namefromtextarray = explode(",", $finaldata['namefromtext']);
						$namefromtextarrayLength = count($namefromtextarray);
						$subArrays = [];
						$namefromCounter = 0;
						
						$keys = [];
						for ($i = 1; $i <= $actionLength; $i++) {
							$keys[] = 'namefrom' . ($i > 1 ? $i : '');
						}
						
						$final_string = "";
						$frcommentt = '';
						$frcommenttString ='';
						
						foreach ($keys as $key) {
							if (isset($finaldata[$key]) && is_array($finaldata[$key])) {
								$tempArray = [];
								
								foreach ($finaldata[$key] as $value) {
									if ($namefromCounter < $namefromtextarrayLength) {
										$tempArray[] = $namefromtextarray[$namefromCounter++] . " ";
									}
								}
								$subArrays[] = implode(', ', $tempArray);
							}
						}
						
						$matchedArray = [];
$subArraysCount = count($subArrays);

for ($i = 0; $i < $subArraysCount; $i++) {
if (isset($finaldata['action'][$i])) {
$valueWithoutQuotes = str_replace('"', '', $finaldata['action'][$i]);
$valueWithParentheses = '(' . $valueWithoutQuotes . ')';
$matchedArray[$subArrays[$i]] = $valueWithParentheses;
}
}

$$frcommentt = '';

foreach ($matchedArray as $key => $value) {
$frcommentt .= "$key: $value ";
}

$frcommentt = trim($frcommentt);

if ($finaldata['vStateStatus'][0] == 'VILLAGE') {

    $frcomment .= '<strong style="color:#15bed2;"><u>Village:</u></strong> : ' . $finaldata['newname'][0] . '(' . $finaldata['vstatus'][0] . ') Created from ' . $frcommentt . ' ;';
} else {

    $frcomment .= '<strong style="color:#45b0e2;"><u>Town:</u></strong> : ' . $finaldata['newname'][0] . ' (' . $finaldata['vstatus'][0] . ')  Created from ' . $frcommentt . ' ;';
}		
								$frcomment1='';
							
								$frcomment1 .='<strong style="color:#aa81f3;"><u>State/UT:</u></strong> '.$statenewarrayfrom[$o].'; <strong style="color:Green;"><u>District:</u></strong> '.$districtnewarrayfrom[$o].'; <strong style="color:blue;"><u>Sub District:</u></strong> '.$sddistrictnewarrayfrom[$o].';';
							
								if($finaldata['vStateStatus'][0]=='VILLAGE')
								{
										// village create level remarks code resolved by shashi
								
									$frcomment1 .='<strong style="color:#15bed2;"><u>Village:</u></strong> '.$frcommentt.' &  Created '.implode(',',$finaldata['newname']).' ('.$finaldata['vstatus'][0].');';
								}
								else
								{
										// village create level remarks code resolved by shashi
										$frcomment1 .='<strong style="color:#45b0e2;"><u>Town:</u></strong> : '.$frcommentt.' &  Created '.implode(',',$finaldata['newname']).' ('.$finaldata['vstatus'][0].');';
								
								}
					
//till here

							// $forread[$j] = array($finaldata['namefrom'][$j],$finaldata['action'][$o],$idsof,$finaldata['docids'],$finaldata['comefromcheck'],$frcomment,'Create',$finaldata['fromstate'][$o],$finaldata['districtget'][$o],$finaldata['sddistrictget'][$o],$finaldata['namefrom'][$j],$finaldata['statenew'][0],$finaldata['districtnew'][0],$finaldata['sddistrictnew'][0],$idsof,$sqlda1['STIDR'],$sqlda1['DTIDR'],$sqlda1['SDIDR'],$sqlda1['VTIDR'],$_SESSION['login_id']);


								 $insertforread = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","DTID","SDID","VTID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE","STIDR","DTIDR","SDIDR","VTIDR","created_by") VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14,$15,$16,$17,$18,$19,$20)';


					$result = pg_query_params($db,$insertforread,array($finaldata['namefrom'][$j],$finaldata['action'][$o],$idsof,$finaldata['docids'],$finaldata['comefromcheck'],$frcomment,'Create',$finaldata['fromstate'][$o],$finaldata['districtget'][$o],$finaldata['sddistrictget'][$o],$finaldata['namefrom'][$j],$finaldata['statenew'][0],$finaldata['districtnew'][0],$finaldata['sddistrictnew'][0],$idsof,$sqlda1['STIDR'],$sqlda1['DTIDR'],$sqlda1['SDIDR'],$sqlda1['VTIDR'],$_SESSION['login_id']));


							// $forread1[$j]=array($finaldata['namefrom'][$j],$finaldata['action'][$o],$finaldata['namefrom'][$j],$finaldata['docids'],$finaldata['comefromcheck'],$frcomment1,'MAIN',$finaldata['fromstate'][$o],$finaldata['districtget'][$o],$finaldata['sddistrictget'][$o],$finaldata['namefrom'][$j],$finaldata['fromstate'][$o],$finaldata['districtget'][$o],$finaldata['sddistrictget'][$o],$finaldata['namefrom'][$j],$sqlda1['STIDR'],$sqlda1['DTIDR'],$sqlda1['SDIDR'],$sqlda1['VTIDR'],$_SESSION['login_id']);


							 $insertforread1 = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","DTID","SDID","VTID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE","STIDR","DTIDR","SDIDR","VTIDR","created_by") VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14,$15,$16,$17,$18,$19,$20)';

				pg_query_params($db,$insertforread1,array($finaldata['namefrom'][$j],$finaldata['action'][$o],$finaldata['namefrom'][$j],$finaldata['docids'],$finaldata['comefromcheck'],$frcomment1,'MAIN',$finaldata['fromstate'][$o],$finaldata['districtget'][$o],$finaldata['sddistrictget'][$o],$finaldata['namefrom'][$j],$finaldata['fromstate'][$o],$finaldata['districtget'][$o],$finaldata['sddistrictget'][$o],$finaldata['namefrom'][$j],$sqlda1['STIDR'],$sqlda1['DTIDR'],$sqlda1['SDIDR'],$sqlda1['VTIDR'],$_SESSION['login_id']));


							// $linkst[$j]=array($finaldata['docids'],$finaldata['fromstate'][$o],$finaldata['districtget'][$o],$finaldata['sddistrictget'][$o],$finaldata['namefrom'][$j]);

							 $insertlinkst = 'insert into documentlink'.$_SESSION['activeyears'].' (docids,linkstids,linkdtids,linksdids,linkvtids) VALUES ($1,$2,$3,$4,$5)';
							$resultst = pg_query_params($db,$insertlinkst,array($finaldata['docids'],$finaldata['fromstate'][$o],$finaldata['districtget'][$o],$finaldata['sddistrictget'][$o],$finaldata['namefrom'][$j]));

							
							}

		
			
			
						$vt = array_merge($vt,$finaldata['namefrom']);
					}
					else if($ii[$o]!=1 && $finaldata['action'][$o]=='Split')
					{

						for($j=0;$j<count($finaldata['namefrom'.$ii[$o].'']);$j++)
							{

								$sqlo1='Select "STIDR","DTIDR","SDIDR","VTIDR" from vt'.$_SESSION['activeyears'].' WHERE "VTID"=$1 AND is_deleted=$2';
								$sqlold1 = pg_query_params($db,$sqlo1,array($finaldata['namefrom'.$ii[$o].''][$j],1));
								$sqlda1 = pg_fetch_array($sqlold1);


								// $frcomment='';
								// $frcomment1='';

								// $frcomment='New '.$finaldata['applyon'].'(s) '.$finaldata['newname'][0].' Created From '.$finaldata['namefromtext'].' '.$finaldata['applyon'].'(s)';

								// $frcomment1=''.$finaldata['namefromtext'].' '.$finaldata['applyon'].'(s) '.$finaldata['action'][$o].' &  Create '.$finaldata['newname'][0].'';

								$frcomment='';
								$frcomment .='<strong style="color:#aa81f3;"><u>State/UT:</u></strong> '.$statenewarray[0].'; <strong style="color:Green;"><u>District:</u></strong> '.$districtnewarray[0].'; <strong style="color:blue;"><u>Sub District:</u></strong> '.$sddistrictnewarray[0].'; ';
								
								
								if($finaldata['vStateStatus'][0]=='VILLAGE')
								{
								// village create level remarks code resolved by shashi
								$frcomment .='<strong style="color:#15bed2;"><u>Village:</u></strong> : '.$finaldata['newname'][0].' ('.$finaldata['vstatus'][0].') Created from '.$frcommentt.' ;';
								}
								else
								{
										// village create level remarks code resolved by shashi
									$frcomment .='<strong style="color:#45b0e2;"><u>Town:</u></strong> '.$finaldata['newname'][0].' ('.$finaldata['vstatus'][0].') Created from '.$frcommentt.' ;';
								
								}



								$frcomment1='';
							
								$frcomment1 .='<strong style="color:#aa81f3;"><u>State/UT:</u></strong> '.$statenewarrayfrom[$o].'; <strong style="color:Green;"><u>District:</u></strong> '.$districtnewarrayfrom[$o].'; <strong style="color:blue;"><u>Sub District:</u></strong> '.$sddistrictnewarrayfrom[$o].'; ';
								
								if($finaldata['vStateStatus'][0]=='VILLAGE')
								{
								// village create level remarks code resolved by shashi
								$frcomment1 .='<strong style="color:#15bed2;"><u>Village:</u></strong> '.$frcommentt.' &  Created '.implode(',',$finaldata['newname']).' ('.$finaldata['vstatus'][0].');';
								}
								else
								{
										// village create level remarks code resolved by shashi
									$frcomment1 .='<strong style="color:#45b0e2;"><u>Town:</u></strong> '.$frcommentt.' &  Created '.implode(',',$finaldata['newname']).'('.$finaldata['vstatus'][0].');';
								
								}





							// $forread[$j]= array($finaldata['namefrom'.$ii[$o].''][$j],$finaldata['action'][$o],$idsof,$finaldata['docids'],$finaldata['comefromcheck'],$frcomment,'Create',$finaldata['fromstate'][$o],$finaldata['districtget'][$o],$finaldata['sddistrictget'][$o],$finaldata['namefrom'.$ii[$o].''][$j],$finaldata['statenew'][0],$finaldata['districtnew'][0],$finaldata['sddistrictnew'][0],$idsof,$sqlda1['STIDR'],$sqlda1['DTIDR'],$sqlda1['SDIDR'],$sqlda1['VTIDR'],$_SESSION['login_id']);

									 $insertforread = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","DTID","SDID","VTID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE","STIDR","DTIDR","SDIDR","VTIDR","created_by") VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14,$15,$16,$17,$18,$19,$20)';
							$result = pg_query_params($db,$insertforread,array($finaldata['namefrom'.$ii[$o].''][$j],$finaldata['action'][$o],$idsof,$finaldata['docids'],$finaldata['comefromcheck'],$frcomment,'Create',$finaldata['fromstate'][$o],$finaldata['districtget'][$o],$finaldata['sddistrictget'][$o],$finaldata['namefrom'.$ii[$o].''][$j],$finaldata['statenew'][0],$finaldata['districtnew'][0],$finaldata['sddistrictnew'][0],$idsof,$sqlda1['STIDR'],$sqlda1['DTIDR'],$sqlda1['SDIDR'],$sqlda1['VTIDR'],$_SESSION['login_id']));

							// $forread1[$j]= array($finaldata['namefrom'.$ii[$o].''][$j],$finaldata['action'][$o],$finaldata['namefrom'.$ii[$o].''][$j],$finaldata['docids'],$finaldata['comefromcheck'],$frcomment1,'MAIN',$finaldata['fromstate'][$o],$finaldata['districtget'][$o],$finaldata['sddistrictget'][$o],$finaldata['namefrom'.$ii[$o].''][$j],$finaldata['fromstate'][$o],$finaldata['districtget'][$o],$finaldata['sddistrictget'][$o],$finaldata['namefrom'.$ii[$o].''][$j],$sqlda1['STIDR'],$sqlda1['DTIDR'],$sqlda1['SDIDR'],$sqlda1['VTIDR'],$_SESSION['login_id']);

							 $insertforread1 = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","DTID","SDID","VTID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE","STIDR","DTIDR","SDIDR","VTIDR","created_by") VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14,$15,$16,$17,$18,$19,$20)';

				pg_query_params($db,$insertforread1,array($finaldata['namefrom'.$ii[$o].''][$j],$finaldata['action'][$o],$finaldata['namefrom'.$ii[$o].''][$j],$finaldata['docids'],$finaldata['comefromcheck'],$frcomment1,'MAIN',$finaldata['fromstate'][$o],$finaldata['districtget'][$o],$finaldata['sddistrictget'][$o],$finaldata['namefrom'.$ii[$o].''][$j],$finaldata['fromstate'][$o],$finaldata['districtget'][$o],$finaldata['sddistrictget'][$o],$finaldata['namefrom'.$ii[$o].''][$j],$sqlda1['STIDR'],$sqlda1['DTIDR'],$sqlda1['SDIDR'],$sqlda1['VTIDR'],$_SESSION['login_id']));

							// $linkst[$j]=array($finaldata['docids'],$finaldata['fromstate'][$o],$finaldata['districtget'][$o],$finaldata['sddistrictget'][$o],$finaldata['namefrom'.$ii[$o].''][$j]);

							 $insertlinkst = 'insert into documentlink'.$_SESSION['activeyears'].' (docids,linkstids,linkdtids,linksdids,linkvtids) VALUES ($1,$2,$3,$4,$5)';
						$resultst = pg_query_params($db,$insertlinkst,array($finaldata['docids'],$finaldata['fromstate'][$o],$finaldata['districtget'][$o],$finaldata['sddistrictget'][$o],$finaldata['namefrom'.$ii[$o].''][$j]));

							}

						$vt = array_merge($vt,$finaldata['namefrom'.$ii[$o].'']);
					}
					else
					{
						if($ii[$o]==1 && $finaldata['action'][$o]=='Full Merge')
						{
							for($j=0;$j<count($finaldata['namefrom']);$j++)
							{

									$sqlo1='Select "STIDR","DTIDR","SDIDR","VTIDR" from vt'.$_SESSION['activeyears'].' WHERE "VTID"=$1 AND is_deleted=$2';
								$sqlold1 = pg_query_params($db,$sqlo1,array($finaldata['namefrom'][$j],1));
								$sqlda1 = pg_fetch_array($sqlold1);

								// $frcomment='';
								
								// $frcomment='New '.$finaldata['applyon'].'(s) '.$finaldata['newname'][0].' Created From '.$finaldata['namefromtext'].' '.$finaldata['applyon'].'(s)';


								$frcomment='';
							$frcomment .='<strong style="color:#aa81f3;"><u>State/UT:</u></strong> '.$statenewarray[0].'; <strong style="color:Green;"><u>District:</u></strong> '.$districtnewarray[0].'; <strong style="color:blue;"><u>Sub District:</u></strong> '.$sddistrictnewarray[0].'; ';
								
							$actionLength = count($finaldata['action']);
							$namefromtextarray = explode(",", $finaldata['namefromtext']);
							$namefromtextarrayLength = count($namefromtextarray);
							$subArrays = [];
							$namefromCounter = 0;
							
							$keys = [];
							for ($i = 1; $i <= $actionLength; $i++) {
								$keys[] = 'namefrom' . ($i > 1 ? $i : '');
							}
							
							$final_string = "";
							$frcommentt = '';
							$frcommenttString ='';
							
							foreach ($keys as $key) {
								if (isset($finaldata[$key]) && is_array($finaldata[$key])) {
									$tempArray = [];
									
									foreach ($finaldata[$key] as $value) {
										if ($namefromCounter < $namefromtextarrayLength) {
											$tempArray[] = $namefromtextarray[$namefromCounter++] . " ";
										}
									}
									$subArrays[] = implode(', ', $tempArray);
								}
							}
							
							$matchedArray = [];
$subArraysCount = count($subArrays);

for ($i = 0; $i < $subArraysCount; $i++) {
if (isset($finaldata['action'][$i])) {
	$valueWithoutQuotes = str_replace('"', '', $finaldata['action'][$i]);
	$valueWithParentheses = '(' . $valueWithoutQuotes . ')';
	$matchedArray[$subArrays[$i]] = $valueWithParentheses;
}
}

$$frcommentt = '';

foreach ($matchedArray as $key => $value) {
$frcommentt .= "$key: $value ";
}

$frcommentt = trim($frcommentt);
                            
								
								if($finaldata['vStateStatus'][0]=='VILLAGE')
								{
							
								$frcomment .='<strong style="color:#15bed2;"><u>Village:</u></strong> '.$finaldata['newname'][0].' Created from '.$frcommentt.';';
								}
								else
								{
									$frcomment .='<strong style="color:#45b0e2;"><u>Town:</u></strong> '.$finaldata['newname'][0].' Created from '.$frcommentt.';';
								
								}

								


							 // $forread[$j]= array($finaldata['namefrom'][$j],$finaldata['action'][$o],$idsof,$finaldata['docids'],$finaldata['comefromcheck'],$frcomment,'Create',$finaldata['fromstate'][$o],$finaldata['districtget'][$o],$finaldata['sddistrictget'][$o],$finaldata['namefrom'][$j],$finaldata['statenew'][0],$finaldata['districtnew'][0],$finaldata['sddistrictnew'][0],$idsof,$sqlda1['STIDR'],$sqlda1['DTIDR'],$sqlda1['SDIDR'],$sqlda1['VTIDR'],$_SESSION['login_id']);

							  $insertforread = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","DTID","SDID","VTID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE","STIDR","DTIDR","SDIDR","VTIDR","created_by") VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14,$15,$16,$17,$18,$19,$20)';
							$result = pg_query_params($db,$insertforread,array($finaldata['namefrom'][$j],$finaldata['action'][$o],$idsof,$finaldata['docids'],$finaldata['comefromcheck'],$frcomment,'Create',$finaldata['fromstate'][$o],$finaldata['districtget'][$o],$finaldata['sddistrictget'][$o],$finaldata['namefrom'][$j],$finaldata['statenew'][0],$finaldata['districtnew'][0],$finaldata['sddistrictnew'][0],$idsof,$sqlda1['STIDR'],$sqlda1['DTIDR'],$sqlda1['SDIDR'],$sqlda1['VTIDR'],$_SESSION['login_id']));

							// $linkst[$j] = array($finaldata['docids'],$finaldata['fromstate'][$o],$finaldata['districtget'][$o],$finaldata['sddistrictget'][$o],$finaldata['namefrom'][$j]);

							  $insertlinkst = 'insert into documentlink'.$_SESSION['activeyears'].' (docids,linkstids,linkdtids,linksdids,linkvtids) VALUES ($1,$2,$3,$4,$5)';
						$resultst = pg_query_params($db,$insertlinkst,array($finaldata['docids'],$finaldata['fromstate'][$o],$finaldata['districtget'][$o],$finaldata['sddistrictget'][$o],$finaldata['namefrom'][$j]));

							}

							$vtf = array_merge($vtf,$finaldata['namefrom']);
						}
						else
						{
							for($j=0;$j<count($finaldata['namefrom'.$ii[$o].'']);$j++)
							{

									$sqlo1='Select "STIDR","DTIDR","SDIDR","VTIDR" from vt'.$_SESSION['activeyears'].' WHERE "VTID"=$1 AND is_deleted=$2';
								$sqlold1 = pg_query_params($db,$sqlo1,array($finaldata['namefrom'.$ii[$o].''][$j],1));
								$sqlda1 = pg_fetch_array($sqlold1);

								// $frcomment='';
								
								// $frcomment='New '.$finaldata['applyon'].'(s) '.$finaldata['newname'][0].' Created From '.$finaldata['namefromtext'].' '.$finaldata['applyon'].'(s)';


								$frcomment='';
								$frcomment .='<strong style="color:#aa81f3;"><u>State/UT:</u></strong> '.$statenewarray[0].'; <strong style="color:Green;"><u>District:</u></strong> '.$districtnewarray[0].'; <strong style="color:blue;"><u>Sub District:</u></strong> '.$sddistrictnewarray[0].'; ';
								
								
								
								if($finaldata['vStateStatus'][0]=='VILLAGE')
								{
							
								$frcomment .='<strong style="color:#15bed2;"><u>Village:</u></strong> '.$finaldata['newname'][0].' ('.$finaldata['vstatus'][0].')  Created From '.$frcommentt.';';
								}
								else
								{
									$frcomment .='<strong style="color:#45b0e2;"><u>Town:</u></strong> '.$finaldata['newname'][0].' ('.$finaldata['vstatus'][0].')  Created From '.$frcommentt.';';
								
								}



							// $forread[$j]= array($finaldata['namefrom'.$ii[$o].''][$j],$finaldata['action'][$o],$idsof,$finaldata['docids'],$finaldata['comefromcheck'],$frcomment,'Create',$finaldata['fromstate'][$o],$finaldata['districtget'][$o],$finaldata['sddistrictget'][$o],$finaldata['namefrom'.$ii[$o].''][$j],$finaldata['statenew'][0],$finaldata['districtnew'][0],$finaldata['sddistrictnew'][0],$idsof,$sqlda1['STIDR'],$sqlda1['DTIDR'],$sqlda1['SDIDR'],$sqlda1['VTIDR'],$_SESSION['login_id']);


							 $insertforread = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","DTID","SDID","VTID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE","STIDR","DTIDR","SDIDR","VTIDR","created_by") VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14,$15,$16,$17,$18,$19,$20)';
						$result = pg_query_params($db,$insertforread,array($finaldata['namefrom'.$ii[$o].''][$j],$finaldata['action'][$o],$idsof,$finaldata['docids'],$finaldata['comefromcheck'],$frcomment,'Create',$finaldata['fromstate'][$o],$finaldata['districtget'][$o],$finaldata['sddistrictget'][$o],$finaldata['namefrom'.$ii[$o].''][$j],$finaldata['statenew'][0],$finaldata['districtnew'][0],$finaldata['sddistrictnew'][0],$idsof,$sqlda1['STIDR'],$sqlda1['DTIDR'],$sqlda1['SDIDR'],$sqlda1['VTIDR'],$_SESSION['login_id']));


						// $linkst[$j]=array($finaldata['docids'],$finaldata['fromstate'][$o],$finaldata['districtget'][$o],$finaldata['sddistrictget'][$o],$finaldata['namefrom'.$ii[$o].''][$j]);

						 $insertlinkst = 'insert into documentlink'.$_SESSION['activeyears'].' (docids,linkstids,linkdtids,linksdids,linkvtids) VALUES ($1,$2,$3,$4,$5)';
						$resultst = pg_query_params($db,$insertlinkst,array($finaldata['docids'],$finaldata['fromstate'][$o],$finaldata['districtget'][$o],$finaldata['sddistrictget'][$o],$finaldata['namefrom'.$ii[$o].''][$j]));


							}

							$vtf = array_merge($vtf,$finaldata['namefrom'.$ii[$o].'']);
						}


						
					}
		
					
					if($o>=1)
					{
						
							$allvt = array_merge($allvt,$finaldata['namefrom'.$ii[$o].'']);
					}	
					else
					{
						
						$allvt = array_merge($allvt,$finaldata['namefrom']);
					}

				}

			
			 // 	print_r($frcomment1);
				// echo "+++++++++++++++++++++".$frcomment1;
				// exit;
				 $sqlo='Select "STIDR","DTIDR","SDIDR","VTIDR" from vt'.$_SESSION['activeyears'].' WHERE "VTID" = Any(string_to_array($1::text, \',\'::text)::NUMERIC[]) AND is_deleted=$2';

				$sqlold = pg_query_params($db,$sqlo,array(implode(',',$allvt),1));
				$sqlda = pg_fetch_all($sqlold);

				 //$stateconcate =array($finaldata['statenew'][0],$finaldata['districtnew'][0],$finaldata['sddistrictnew'][0],$idsof,ucwords(strtolower($finaldata['newname'][0])),$finaldata['vStateStatus'][0],$finaldata['vstatus'][0],'new',$_SESSION['login_id'],implode(',',array_column($sqlda, 'STIDR')),implode(',',array_column($sqlda, 'DTIDR')),implode(',',array_column($sqlda, 'SDIDR')),implode(',',array_column($sqlda, 'VTIDR')));
				//Titlecase issue resolved by gowthami
				$stateconcate =array($finaldata['statenew'][0],$finaldata['districtnew'][0],$finaldata['sddistrictnew'][0],$idsof,$finaldata['newname'][0],$finaldata['vStateStatus'][0],$finaldata['vstatus'][0],'new',$_SESSION['login_id'],implode(',',array_column($sqlda, 'STIDR')),implode(',',array_column($sqlda, 'DTIDR')),implode(',',array_column($sqlda, 'SDIDR')),implode(',',array_column($sqlda, 'VTIDR')));



				 $state ='insert into vt'.$_SESSION['activeyears'].' ("STID","DTID","SDID","VTID","VTName","Level","Status","flagofcreate","createdby","STIDR","DTIDR","SDIDR","VTIDR") values ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13) returning "VTID"';
				
				$result = pg_query_params($db,$state,$stateconcate);
				$fch = pg_fetch_all($result);

			
				// $forreadqueryappend = rtrim($forread, ',');
				// $forreadqueryappend1 = rtrim($forread1, ',');

				
				// $linkstfinal = rtrim($linkst, ',');


		
			

				 
				  
			
				$insertlinkst1 = 'insert into documentlink'.$_SESSION['activeyears'].' (docids,linkstids,linkdtids,linksdids,linkvtids) VALUES ($1,$2,$3,$4,$5)';
		

				$resultst1 = pg_query_params($db,$insertlinkst1,array($finaldata['docids'],$finaldata['statenew'][0],$finaldata['districtnew'][0],$finaldata['sddistrictnew'][0],$idsof));


			
				$resultst_rows = pg_affected_rows($resultst);


				if($resultst_rows!=0)
				{

				pg_query_params($db,'update documentdata'.$_SESSION['activeyears'].' set docstatus=$1 where docids=$2',array(1,$finaldata['docids']));

			
				if(count($vtf)>0)
				{
				pg_query_params($db,'update vt'.$_SESSION['activeyears'].' set "is_deleted"=$1 where "VTID" = Any(string_to_array($2::text, \',\'::text)::NUMERIC[])',array(0,implode(',',$vtf)));	
				}

				
				// if($forreadqueryappend1!='')
				// {
				// 	 $insertforread1 = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","DTID","SDID","VTID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE","STIDR","DTIDR","SDIDR","VTIDR","created_by") VALUES '.$forreadqueryappend1.'';

				// pg_query($db,$insertforread1);
				// }
				
				// //By sahana village split many to one, full merge many to one, and split and full merge many to one 0111
				// $auflag_query = 'SELECT auflag FROM unit WHERE auaction = $1 AND aulevel = $2';
				// $actions = $finaldata['action'];
				//  $namefrom_values = [];
				
				// foreach ($finaldata as $key => $value) {
				//  	if (preg_match('/^namefrom\d*$/', $key)) {
				// 	$namefrom_values[] = $value;
				//  	}
				//  }

				//  foreach ($actions as $action) {
				//  	if (empty($namefrom_values)) {
				//  		break; 
				//  	}
				
				//  	$namefrom = array_shift($namefrom_values);
				
				//  	foreach ($namefrom as $item) {
				//  		$au = pg_query_params($db, $auflag_query, array($action, $finaldata['comefromcheck']));
				
				// 		if ($au) {
				// 			$row = pg_fetch_assoc($au);
				//  			$auflag_value = $row['auflag'];
				// 			$update_vt = pg_query_params($db, 'UPDATE vt'.$_SESSION['activeyears'].' SET "auflag" = $1, "auaction" = $2 WHERE "VTID" = $3', array($auflag_value, $action, $item));
				// 			if (!$update_vt) {
				//  				echo "UPDATE query failed: " . pg_last_error($db);
				// 		}
				//  		} else {
				// 			echo "SELECT query failed: " . pg_last_error($db);
			 	// 	}
				// 	}
				//  }

				if($finaldata['partiallyids1']!='')
				{

				pg_query_params($db,'update partiallydata'.$_SESSION['activeyears'].' set "pstatus"=$1 where partiallyids=$2',array(1,$finaldata['partiallyids1']));	
				}


				// $finalqueryvt = 'insert into forreaddata2021 ("frfromids","frfromaction","frtoids","frdocids","frcomefrom",
				// 		"frcomment","is_final","comeaction","STID","DTID","SDID","VTID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE","STIDR","DTIDR","SDIDR","VTIDR")
				// 		(select "frfromids","frfromaction","frtoids","frdocids","frcomefrom",
				// 		"frcomment","is_final","comeaction",vt21."STIDR"::integer AS "STIDR11",vt21."DTIDR"::integer AS "DTIDR11",vt21."SDIDR"::BIGINT AS "SDIDR11",vt21."VTIDR"::NUMERIC AS "VTIDR11",vt21."STID",vt21."DTID",vt21."SDID",vt21."VTID",vt21."STIDR"::integer,vt21."DTIDR"::integer,vt21."SDIDR"::BIGINT,vt21."VTIDR"::NUMERIC from vt2021 as vt21 
				// 		LEFT JOIN (select * from forreaddata2021 where "frtoids"='.$idsof.' ORDER BY "frids" DESC limit 1) as fr21 ON fr21."frtoids"=vt21."VTID" and fr21."frfromids"=vt21."VTIDR" 
				// 		where vt21."VTID"='.$idsof.' AND vt21."is_deleted"=1
				// 		)';
				// 		pg_query($db,$finalqueryvt);


				$task = "addfinish";
				}
				else
				{
				$task = "error";
				}


		}
			else
			{

		
					
					if($finaldata['clickpopup']=='Addition')
					{


						
							if(isset($finaldata['statenewarray']))
							{
							$statenewarray = explode(',',$finaldata['statenewarray']);
							}

							if(isset($finaldata['districtnewarray']))
							{
							$districtnewarray = explode(',',$finaldata['districtnewarray']);
							}

							if(isset($finaldata['sddistrictnewarray']))
							{
							$sddistrictnewarray = explode(',',$finaldata['sddistrictnewarray']);
							}




							for($j=0;$j<count($finaldata['newname']);$j++)
							{
								
								$sql = 'SELECT vt'.$_SESSION['activeyears'].'."ID" FROM vt'.$_SESSION['activeyears'].' ORDER BY vt'.$_SESSION['activeyears'].'."ID" DESC LIMIT 1';

									$idsquery = pg_query_params($db,$sql,array());

									if(pg_numrows($idsquery)>0)
									{

										$idsquerydata = pg_fetch_array($idsquery);

									}

									$id = $idsquerydata['ID'] + 1;
									$id = str_pad($id, 6, '0', STR_PAD_LEFT);
									$idsof = $finaldata['sddistrictnew'][$j]."".$id;

									

									$stateconcate =array($finaldata['statenew'][$j],$finaldata['districtnew'][$j],$finaldata['sddistrictnew'][$j],$idsof,$finaldata['newname'][$j],'VILLAGE',$finaldata['vstatus'][$j],'new',$_SESSION['login_id'],$finaldata['statenew'][$j],$finaldata['districtnew'][$j],$finaldata['sddistrictnew'][$j],$idsof);

 										$state ='insert into vt'.$_SESSION['activeyears'].' ("STID","DTID","SDID","VTID","VTName","Level","Status","flagofcreate","createdby","STIDR","DTIDR","SDIDR","VTIDR") values ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13) returning "VTID"';
									
									 pg_query_params($db,$state,$stateconcate);


									// $frcomment='';
									// // $frcomment1='';

									// $frcomment='Add New Village(s) '.$finaldata['newname'][$j].'.';




									$frcomment='';
									$frcomment .='<strong style="color:#aa81f3;"><u>State/UT:</u></strong> '.$statenewarray[$j].'; <strong style="color:Green;"><u>District:</u></strong> '.$districtnewarray[$j].'; <strong style="color:blue;"><u>Sub District:</u></strong> '.$sddistrictnewarray[$j].'; ';
									
									
									
									// if($finaldata['vStateStatus'][0]=='VILLAGE')
									// {
									// $frcomment .='<strong style="color:#45b0e2;"><u>Town:</u></strong> No Change;';
									// }
									// else
									// {
									// $frcomment .='<strong style="color:#15bed2;"><u>Village:</u></strong> Add New '.ucwords(strtolower($finaldata['newname'][$j])).'.';
									// }
									// addition code  village level forread resolved by shashi
                                    $frcomment .='<strong style="color:#15bed2;"><u>Village:</u></strong> Add New '.$finaldata['newname'][$j].'   ('.$finaldata['vstatus'][$j].').';




									
									$forread = array($idsof,'Addition',$idsof,$finaldata['docids'],$finaldata['comefromcheck'],$frcomment,'Create',$finaldata['statenew'][$j],$finaldata['districtnew'][$j],$finaldata['sddistrictnew'][$j],$idsof,$finaldata['statenew'][$j],$finaldata['districtnew'][$j],$finaldata['sddistrictnew'][$j],$idsof,$finaldata['statenew'][$j],$finaldata['districtnew'][$j],$finaldata['sddistrictnew'][$j],0,$_SESSION['login_id']);

									 $insertforread = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","DTID","SDID","VTID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE","STIDR","DTIDR","SDIDR","VTIDR","created_by") VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14,$15,$16,$17,$18,$19,$20)';

									$result = pg_query_params($db,$insertforread,$forread);


									
									$ids[]=$idsof;

									


							}

							$result_rows = pg_affected_rows($result);
								
										// 	$forreadqueryappend = rtrim($forread, ',');
									// $linkst='';
									for($k=0;$k<count($ids);$k++)
									{
									$linkst=array($finaldata['docids'],$finaldata['statenew'][$k],$finaldata['districtnew'][$k],$finaldata['sddistrictnew'][$k],$ids[$k]);


									$insertlinkst = 'insert into documentlink'.$_SESSION['activeyears'].' (docids,linkstids,linkdtids,linksdids,linkvtids) VALUES ($1,$2,$3,$4,$5)';

									$resultst = pg_query_params($db,$insertlinkst,$linkst);
									}
										
								$resultst_rows = pg_affected_rows($resultst);
									
									if($result_rows!=0 && $resultst_rows!=0)
									{

										pg_query_params($db,'update documentdata'.$_SESSION['activeyears'].' set docstatus=$1 where docids=$2',array(1,$finaldata['docids']));


									// for($kl=0;$kl<count($ids);$kl++)
									// 	{


									// 	$finalqueryvt = 'insert into forreaddata2021 ("frfromids","frfromaction","frtoids","frdocids","frcomefrom",
									// 	"frcomment","is_final","comeaction","STID","DTID","SDID","VTID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE","STIDR","DTIDR","SDIDR","VTIDR")
									// 	(select "frfromids","frfromaction","frtoids","frdocids","frcomefrom",
									// 	"frcomment","is_final","comeaction",vt21."STIDR"::integer AS "STIDR11",vt21."DTIDR"::integer AS "DTIDR11",vt21."SDIDR"::BIGINT AS "SDIDR11",vt21."VTIDR"::NUMERIC AS "VTIDR11",vt21."STID",vt21."DTID",vt21."SDID",vt21."VTID",vt21."STIDR"::integer,vt21."DTIDR"::integer,vt21."SDIDR"::BIGINT,vt21."VTIDR"::NUMERIC from vt2021 as vt21 
									// 	LEFT JOIN (select * from forreaddata2021 where "frtoids"='.$ids[$kl].' ORDER BY "frids" DESC limit 1) as fr21 ON fr21."frtoids"=vt21."VTID" and fr21."frfromids"=vt21."VTIDR" 
									// 	where vt21."VTID"='.$ids[$kl].' AND vt21."is_deleted"=1
									// 	)';
									// 	pg_query($db,$finalqueryvt);

									// 	}


										$task = "addfinish";
									}
									else
									{
									$task = "error";
									}

									


					}
					else
					{
							// print_r($finaldata);
							// exit;
		
	

							
							if(isset($finaldata['statenewarray']))
							{
							$statenewarray = explode(',',$finaldata['statenewarray']);
							}

							if(isset($finaldata['districtnewarray']))
							{
							$districtnewarray = explode(',',$finaldata['districtnewarray']);
							}

							if(isset($finaldata['sddistrictnewarray']))
							{
							$sddistrictnewarray = explode(',',$finaldata['sddistrictnewarray']);
							}


							if(isset($finaldata['statenewarrayfrom']))
							{
							$statenewarrayfrom = explode(',',$finaldata['statenewarrayfrom']);
							}

							if(isset($finaldata['districtnewarrayfrom']))
							{
							$districtnewarrayfrom = explode(',',$finaldata['districtnewarrayfrom']);
							}

							if(isset($finaldata['sddistrictnewarrayfrom']))
							{
							$sddistrictnewarrayfrom = explode(',',$finaldata['sddistrictnewarrayfrom']);
							}



							$linkDTarray = array();
							$forread = '';
							$idsof ='';
							$st=array();
							$dt=array();
							$sd=array();
							$vt=array();

							for($j=0;$j<count($finaldata['newname']);$j++)
							{



									 // $sql = 'SELECT vt'.$_SESSION['activeyears'].'."VTID",Left(vt'.$_SESSION['activeyears'].'."VTID"::varchar(255),-6)  as vv1,right(vt'.$_SESSION['activeyears'].'."VTID"::varchar(255),6)  as vv2 FROM vt'.$_SESSION['activeyears'].' where "STID"='.$finaldata['statenew'][$j].' AND "DTID"='.$finaldata['districtnew'][$j].' AND Left("VTID"::varchar(255),-6)=\''.$finaldata['sddistrictnew'][$j].'\' AND "Level"=\''.$finaldata['vStateStatus'][$j].'\' ORDER BY vt'.$_SESSION['activeyears'].'."VTID" DESC FETCH FIRST ROW ONLY';

									  $sql = 'SELECT vt'.$_SESSION['activeyears'].'."ID" FROM vt'.$_SESSION['activeyears'].' ORDER BY vt'.$_SESSION['activeyears'].'."ID" DESC LIMIT 1';

									$idsquery = pg_query($db,$sql);

									if(pg_numrows($idsquery)>0)
									{
										$idsquerydata = pg_fetch_array($idsquery);
  

									}

									$id = $idsquerydata['ID'] + 1;
									$id = str_pad($id, 6, '0', STR_PAD_LEFT);
									$idsof = $finaldata['sddistrictnew'][$j]."".$id;
							
									$sqlo='Select "STIDR","DTIDR","SDIDR","VTIDR" from vt'.$_SESSION['activeyears'].' WHERE "VTID" = Any(string_to_array($1::text, \',\'::text)::NUMERIC[]) AND is_deleted=$2';
									$sqlold = pg_query_params($db,$sqlo,array(implode(',',$finaldata['namefrom']),1));
									$sqlda = pg_fetch_all($sqlold);
																

									$stateconcate =array($finaldata['statenew'][$j],$finaldata['districtnew'][$j],$finaldata['sddistrictnew'][$j],$idsof,$finaldata['newname'][$j],$finaldata['vStateStatus'][$j],$finaldata['vstatus'][$j],'new',$_SESSION['login_id'],implode(',',array_column($sqlda, 'STIDR')),implode(',',array_column($sqlda, 'DTIDR')),implode(',',array_column($sqlda, 'SDIDR')),implode(',',array_column($sqlda, 'VTIDR')));

									$states ='insert into vt'.$_SESSION['activeyears'].' ("STID","DTID","SDID","VTID","VTName","Level","Status","flagofcreate","createdby","STIDR","DTIDR","SDIDR","VTIDR") values ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13) returning "VTID"';

									pg_query_params($db,$states,$stateconcate);

									if(isset($finaldata['addlinksDTID'.$j.'']))
									{
									$linkDTarray=array_merge($linkDTarray,$finaldata['addlinksDTID'.$j.'']);	 		
									}

									for($g=0;$g<count($finaldata['namefrom']);$g++)
									{



									$frcomment='';
									
									$frcomment .='<strong style="color:#aa81f3;"><u>State/UT:</u></strong> '.$statenewarray[$j].'; <strong style="color:Green;"><u>District:</u></strong> '.$districtnewarray[$j].'; <strong style="color:blue;"><u>Sub District:</u></strong> '.$sddistrictnewarray[$j].'; ';
									
									if($finaldata['vStateStatus'][$j]=='VILLAGE')
									{
								//JC_shashi(one to many) village
										$frcomment .='<strong style="color:#15bed2;"><u>Village:</u></strong> '.$finaldata['newname'][$j].'('.$finaldata['vstatus'][$j].') Created from '.$finaldata['namefromtext'].' ('.$finaldata['action'][0].');';

									
									}
									else
									{
											
											//JC_shashi(one to many) village adding the civic status for town
											$frcomment .='<strong style="color:#45b0e2;"><u>Town:</u></strong> '.$finaldata['newname'][$j].' ('.$finaldata['vstatus'][$j].') Created from '.$finaldata['namefromtext'].'('.$finaldata['action'][0].');';
									
									}



									// $frcomment1='';

									// $frcomment1 .=''.$finaldata['namefromtext'].' '.$finaldata['applyon'].'(s) '.$finaldata['action'][0].' &  Create '.$finaldata['newname'][$j].'';


									$frcomment1='';
										//JC_shashi (one to many) village
									$frcomment1 .='<strong style="color:#aa81f3;"><u>State/UT:</u></strong> '.$statenewarrayfrom[0].'; <strong style="color:Green;"><u>District:</u></strong> '.$districtnewarrayfrom[0].'; <strong style="color:blue;"><u>Sub District:</u></strong> '.$sddistrictnewarrayfrom[0].'; ';
									
									if($finaldata['vStateStatus'][0]!=='VILLAGE')
									{
									
                                   //JC_shashi (one to many) village
									$frcomment1 .='<strong style="color:#15bed2;"><u>Village:</u></strong> '.$finaldata['namefromtext'].' ('.$finaldata['action'][0].') &  Created '.ucwords(strtolower($finaldata['newname'][$j])).' ('.$finaldata['vstatus'][$j].');';

										// $frcomment .=''.$finaldata['vStateStatus'][0].': New '.$finaldata['applyon'].'(s) '.$finaldata['newname'][$j].' Created from '.$finaldata['namefromtext'].' '.$finaldata['applyon'].'(s);';

									
									}
									else
									{
										//JC_shashi (one to many) village
												//$frcomment1 .='<strong style="color:#45b0e2;"><u>Town:</u></strong> '.$finaldata['namefromtext'].' '.$finaldata['action'][0].' &  Created '.ucwords(strtolower($finaldata['newname'][$j])).' ('.$finaldata['vstatus'][$j].');';
								//Titlecase issue resolved by gowthami
								$frcomment1 .='<strong style="color:#45b0e2;"><u>Town:</u></strong> '.$finaldata['namefromtext'].' ('.$finaldata['action'][0].') &  Created '.$finaldata['newname'][$j].' ('.$finaldata['vstatus'][$j].');';


									}

									$std=explode(',',$sqlda[$g]['STIDR']);
									$dtd=explode(',',$sqlda[$g]['DTIDR']);
									$sdd=explode(',',$sqlda[$g]['SDIDR']);
									$vtd=explode(',',$sqlda[$g]['VTIDR']);
									// Shashi foread v/t extra row
									for($ji=0;$ji<count($std);$ji++)
                                    {
                                            $forread1 = array($finaldata['namefrom'][$g],$finaldata['action'][0],$finaldata['namefrom'][0],$finaldata['docids'],$finaldata['comefromcheck'],$frcomment1,'MAIN',$finaldata['fromstate'][0],$finaldata['districtget'][0],$finaldata['sddistrictget'][0],$finaldata['namefrom'][$g],$finaldata['fromstate'][0],$finaldata['districtget'][0],$finaldata['sddistrictget'][0],$finaldata['namefrom'][$g],$std[$ji],$dtd[$ji],$sdd[$ji],$vtd[$ji],$_SESSION['login_id']);
                                    if(count($forread1)>0 )
                                        {
                                            $insertforread1 = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","DTID","SDID","VTID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE","STIDR","DTIDR","SDIDR","VTIDR","created_by") VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14,$15,$16,$17,$18,$19,$20)';
                                            pg_query_params($db,$insertforread1,$forread1);
                                        }
                                        $forread = array($finaldata['namefrom'][$g],$finaldata['action'][0],$idsof,$finaldata['docids'],$finaldata['comefromcheck'],$frcomment,'Create',$finaldata['fromstate'][0],$finaldata['districtget'][0],$finaldata['sddistrictget'][0],$finaldata['namefrom'][$g],$finaldata['statenew'][$j],$finaldata['districtnew'][$j],$finaldata['sddistrictnew'][$j],$idsof,$std[$ji],$dtd[$ji],$sdd[$ji],$vtd[$ji],$_SESSION['login_id']);
                                 $insertforread = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","DTID","SDID","VTID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE","STIDR","DTIDR","SDIDR","VTIDR","created_by") VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14,$15,$16,$17,$18,$19,$20)';
                                $result = pg_query_params($db,$insertforread,$forread);
                                    }
									
									$st=array_merge($st,$finaldata['fromstate']);
									$dt=array_merge($dt,$finaldata['districtget']);
									$sd=array_merge($sd,$finaldata['sddistrictnew']);

									}
									
									$ids[]=$idsof;

									
									}
									$st=array_merge($st,$finaldata['statenew']);
									$dt=array_merge($dt,$finaldata['districtnew']);
									$sd=array_merge($sd,$finaldata['sddistrictnew']);
									$vt=array_merge($finaldata['namefrom'],$ids);


									// $forreadqueryappend = rtrim($forread, ',');
									// $forreadqueryappend1 = rtrim($forread1, ',');
								
									if($finaldata['action'][0]=='Full Merge')
									{
									array_push($removearraysd,$finaldata['namefrom']); 
									}

								

								// 	$linkst='';
									for($k=0;$k<count($vt);$k++)
									{
									
									// $linkst .="(".$finaldata['docids'].",".$st[$k].",".$dt[$k].",".$sd[$k].",".$vt[$k]."),";
										$insertlinkst = 'insert into documentlink'.$_SESSION['activeyears'].' (docids,linkstids,linkdtids,linksdids,linkvtids) VALUES ($1,$2,$3,$4,$5)';
									$resultst = pg_query_params($db,$insertlinkst,array($finaldata['docids'],$st[$k],$dt[$k],$sd[$k],$vt[$k]));

									}
									// $linkstfinal = rtrim($linkst, ',');

									

									
									$resultst_rows = pg_affected_rows($resultst);
									$result_rows = pg_affected_rows($result);

									if($result_rows!=0 && $resultst_rows!=0)
									{

										pg_query_params($db,'update documentdata'.$_SESSION['activeyears'].' set docstatus=$1 where docids=$2',array(1,$finaldata['docids']));
									
										// print_r($removearraysd);
										// exit;
										
										if(count($removearraysd)>0)
										{
										pg_query_params($db,'update vt'.$_SESSION['activeyears'].' set "is_deleted"=$1 where "STID"=$2 and "DTID"=$3 AND "SDID"=$4 and "VTID" = Any(string_to_array($5::text, \',\'::text)::NUMERIC[])',array(0,$finaldata['fromstate'][0],$finaldata['districtget'][0],$finaldata['sddistrictget'][0],implode(',',$removearraysd[0])));	
									
										}
										
										//By sahana village split one to one, full merge one to one 0111 //2811
										$auflag_query = 'SELECT auflag FROM unit WHERE auaction = $1 AND aulevel = $2';
										$actions = $finaldata['action'];
										$namefrom_values = $finaldata['namefrom'];
										foreach ($namefrom_values as $key => $namefrom_value) {
											$action = $actions[0];
											$namefrom = $namefrom_values[$key];
											$au = pg_query_params($db, $auflag_query, array($action, $finaldata['comefromcheck']));

											if ($au) {
												$row = pg_fetch_assoc($au);
												$auflag_value = $row['auflag'];

												$update_vt = pg_query_params($db, 'UPDATE vt'.$_SESSION['activeyears'].' SET "auflag" = $1, "auaction" = $2 WHERE "VTID" = $3', array($auflag_value, $action, $namefrom));

												if (!$update_vt) {
													echo "UPDATE query failed: " . pg_last_error($db);
												}
											} else {
												echo "SELECT query failed: " . pg_last_error($db);
											}
										}

										if($finaldata['partiallyids1']!='')
										{

										pg_query_params($db,'update partiallydata'.$_SESSION['activeyears'].' set "pstatus"=$1 where partiallyids=$2',array(1,$finaldata['partiallyids1']));	
										}


										// for($kl=0;$kl<count($ids);$kl++)
										// {


										// $finalqueryvt = 'insert into forreaddata2021 ("frfromids","frfromaction","frtoids","frdocids","frcomefrom",
										// "frcomment","is_final","comeaction","STID","DTID","SDID","VTID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE","STIDR","DTIDR","SDIDR","VTIDR")
										// (select "frfromids","frfromaction","frtoids","frdocids","frcomefrom",
										// "frcomment","is_final","comeaction",vt21."STIDR"::integer AS "STIDR11",vt21."DTIDR"::integer AS "DTIDR11",vt21."SDIDR"::BIGINT AS "SDIDR11",vt21."VTIDR"::NUMERIC AS "VTIDR11",vt21."STID",vt21."DTID",vt21."SDID",vt21."VTID",vt21."STIDR"::integer,vt21."DTIDR"::integer,vt21."SDIDR"::BIGINT,vt21."VTIDR"::NUMERIC from vt2021 as vt21 
										// LEFT JOIN (select * from forreaddata2021 where "frtoids"='.$ids[$kl].' ORDER BY "frids" DESC limit 1) as fr21 ON fr21."frtoids"=vt21."VTID" and fr21."frfromids"=vt21."VTIDR" 
										// where vt21."VTID"='.$ids[$kl].' AND vt21."is_deleted"=1
										// )';
										// pg_query($db,$finalqueryvt);

										// }



										$task = "addfinish";
									}
									else
									{
									$task = "error";
									}


					}


				



			}



	}


	else
	{

					//By sahana split state level many to one 0111 0611										
					$auflag_query = 'SELECT auflag FROM unit WHERE auaction = $1 AND aulevel = $2';
					$actions = $retdata['action'];
					$namefrom_values = $retdata['namefrom'];

					foreach ($actions as $key => $action) {
						$namefrom = $namefrom_values[$key];

						$au = pg_query_params($db, $auflag_query, array($action, $retdata['comefromcheck']));

						if ($au) {
							$row = pg_fetch_assoc($au);
							$auflag_value = $row['auflag'];

							$update_vt = pg_query_params($db, 'UPDATE vt'.$_SESSION['activeyears'].' SET "auflag" = $1, "auaction" = $2 WHERE "STID" = $3', array($auflag_value, $action, $namefrom));
							$update_sd = pg_query_params($db, 'UPDATE sd'.$_SESSION['activeyears'].' SET "auflag" = $1, "auaction" = $2 WHERE "STID" = $3', array($auflag_value, $action, $namefrom));
							$update_dt = pg_query_params($db, 'UPDATE dt'.$_SESSION['activeyears'].' SET "auflag" = $1, "auaction" = $2 WHERE "STID" = $3', array($auflag_value, $action, $namefrom));
							$update_st = pg_query_params($db, 'UPDATE st'.$_SESSION['activeyears'].' SET "auflag" = $1, "auaction" = $2 WHERE "STID" = $3', array($auflag_value, $action, $namefrom));
							
							if (!$update_st || !$update_dt || !$update_sd || !$update_vt) {
								echo "UPDATE query failed: " . pg_last_error($db);
							}
						} else {
							echo "SELECT query failed: " . pg_last_error($db);
						}
					}


					$sql = 'SELECT st'.$_SESSION['activeyears'].'."STID" FROM st'.$_SESSION['activeyears'].' ORDER BY st'.$_SESSION['activeyears'].'."STID" DESC FETCH FIRST ROW ONLY';

					$idsquery = pg_query_params($db,$sql,array());
					$idsquerydata = pg_fetch_row($idsquery);

					$dataofremove = explode(',',$retdata['origremove']);
				
					$removearrayst = array();
					$linkSTarray='';

					if($retdata['flag']=='namefrom')
					{
							

							$partiallylevel = '';
							$documentlinkst = '';
							$idsarray=array();
												$idsdata = $idsquerydata[0];
												$insertquery = '';
												for($m=0;$m<count($retdata['newname']);$m++)
												{	
													
												$idsdata = $idsdata+1;

												

												//$insertstquery = array($idsdata,ucwords(strtolower($retdata['newname'][$m])),$retdata['StateStatus'][$m],implode(',',$retdata['namefrom']),'new',$_SESSION['login_id']);
                                                //Titlecase issue resolved by gowthami
												$insertstquery = array($idsdata,$retdata['newname'][$m],$retdata['StateStatus'][$m],implode(',',$retdata['namefrom']),'new',$_SESSION['login_id']);



												 $insertst = 'insert into st'.$_SESSION['activeyears'].' ("STID","STName","Status","STIDR","flagofcreate","createdby") VALUES ($1,$2,$3,$4,$5,$6) returning "STID"';
					
												 pg_query_params($db,$insertst,$insertstquery);

													
													
													
												$idsarray[$m]=$idsdata;

												}
												// $insertstqueryfinal = rtrim($insertstquery, ',');
												

												$documentlinkst=array_merge($retdata['namefrom'],$idsarray);
												for($st=0;$st<count($documentlinkst);$st++)
												{
												$insertlinkst = 'insert into documentlink'.$_SESSION['activeyears'].' (docids,linkstids) VALUES ($1,$2)';
												$resultst = pg_query_params($db,$insertlinkst,array($retdata['docids'],$documentlinkst[$st]));

													
												}
												// $insertstlinkquery = rtrim($insertstlink, ',');

												$linkDTarray = array();
												$forread = '';
												$forread1 = '';
												for($j=0;$j<count($retdata['namefrom']);$j++)
												{
										$updatequery .="('".$retdata['fstatus'][$j]."',".$retdata['namefrom'][$j]."),";

													if($dataofremove[$j]==1)
													{


																array_push($removearrayst,$retdata['namefrom'][$j]); 
													}

												if(isset($finaldata['addlinksDTID'.$j.'']))
												{

													if(isset($finaldata['partiallylevel'.$j.'']))
													{
															$havep = true;

															for($a=0;$a<count($finaldata['partiallylevel'.$j.'']);$a++)
																{
																	$partiallylevel .="('".$retdata['comefromcheck']."',".$retdata['namefrom'][$j].",'".$retdata['action'][$j]."',".$idsarray[0].",".$retdata['docids'].",".$finaldata['partiallylevel'.$j.''][$a].")," ;
																}



														$finaldata['addlinksDTID'.$j.''] = array_diff($finaldata['addlinksDTID'.$j.''],$finaldata['partiallylevel'.$j.'']);
													}

												$linkDTarray=array_merge($linkDTarray,$finaldata['addlinksDTID'.$j.'']);	 		
												}

													$frcomment='';
													$frcomment1='';
													$statusflag='';
													if($retdata['StateStatus'][0]=='ST')
													{
													$statusflag='State';
													}
													else
													{
													$statusflag='Union Territory';
													}

													$fstatusflag='';
													if($retdata['ostate'][$j]=='ST')
													{
													$fstatusflag='State';
													}
													else
													{
													$fstatusflag='Union Territory';
													}




													//$frcomment .='<strong style="color:#aa81f3;"><u>State/UT:</u></strong> '.$statusflag.' '.ucwords(strtolower($retdata['newname'][0])).' Created from '.$retdata['namefromtext'].';';
													//Titlecase issue resolved by gowthami
													$frcomment .='<strong style="color:#aa81f3;"><u>State/UT:</u></strong> '.$statusflag.' '.$retdata['newname'][0].' Created from '.$retdata['namefromtext'].';';
													
													
													
													$frcomment .=' <strong style="color:Green;"><u>District:</u></strong> - ; <strong style="color:blue;"><u>Sub District:</u></strong> - ; <strong style="color:#45b0e2;"><u>Town:</u></strong> - ; <strong style="color:#15bed2;"><u>Village:</u></strong> - ;';

													//$frcomment1 .='<strong style="color:#aa81f3;"><u>State/UT:</u></strong> '.$retdata['namefromtext'].' '.$retdata['action'][0].' &  Create '.$statusflag.' '.ucwords(strtolower($retdata['newname'][0])).';';
                                                    //Titlecase issue resolved by gowthami
													$frcomment1 .='<strong style="color:#aa81f3;"><u>State/UT:</u></strong> '.$retdata['namefromtext'].' '.$retdata['action'][0].' &  Create '.$statusflag.' '.$retdata['newname'][0].';';
													$frcomment1 .=' <strong style="color:Green;"><u>District:</u></strong> - ; <strong style="color:blue;"><u>Sub District:</u></strong> - ; <strong style="color:#45b0e2;"><u>Town:</u></strong> - ; <strong style="color:#15bed2;"><u>Village:</u></strong> - ;';
												
												$forread1 = array($retdata['namefrom'][$j],$retdata['action'][$j],$retdata['namefrom'][$j],$retdata['docids'],$retdata['comefromcheck'],$frcomment1,'MAIN',$retdata['namefrom'][$j],$retdata['namefrom'][$j],$retdata['namefrom'][$j],$_SESSION['login_id']);

												if(count($forread1)>0)
														{
															$insertforread1 = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","STIDACTIVE","STIDR","created_by") VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11)';
	 														pg_query_params($db,$insertforread1,$forread1);
														}


												$forread = array($retdata['namefrom'][$j],$retdata['action'][$j],$idsarray[0],$retdata['docids'],$retdata['comefromcheck'],$frcomment,'Create',$retdata['namefrom'][$j],$idsarray[0],$retdata['namefrom'][$j],$_SESSION['login_id']);

												$insertforread = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","STIDACTIVE","STIDR","created_by") VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11)';
													$result = pg_query_params($db, $insertforread, $forread);
												}
												// $forreadqueryappend = rtrim($forread, ',');
												// $forreadqueryappend1 = rtrim($forread1, ',');
												$updatequeryfinal = rtrim($updatequery, ',');

												
												
												if(count($linkDTarray)>0)
												{
												for($l=0;$l<count($linkDTarray);$l++)
												{
												// $linkdt .="(".$retdata['docids'].",".$idsarray[0].",".$linkDTarray[$l]."),";

											
												$insertlinkdt = 'insert into documentlink'.$_SESSION['activeyears'].' (docids,linkstids,linkdtids) VALUES ($1,$2,$3)';	
												$resultdt = pg_query_params($db,$insertlinkdt,array($retdata['docids'],$idsarray[0],$linkDTarray[$l]));
												}


												}
											

												
												

											
												

												
												$resultst_rows = pg_affected_rows($resultst);



														if($resultst_rows!=0)
														{

														 $qu = 'update st'.$_SESSION['activeyears'].' as t set
														"Status" = c."Status"
														from (values
														'.$updatequeryfinal.'
														) as c("Status", "STID") 
														where c."STID" = t."STID"';
														pg_query($db,$qu);

														pg_query_params($db,'update documentdata'.$_SESSION['activeyears'].' set docstatus=$1 where docids=$2',array(1,$retdata['docids']));
														
														pg_query_params($db,'update dt'.$_SESSION['activeyears'].' set "STID"=$1 where dt'.$_SESSION['activeyears'].'."DTID" = Any(string_to_array($2::text, \',\'::text)::integer[])',array($idsarray[0],implode(',',$linkDTarray)));

														pg_query_params($db,'update sd'.$_SESSION['activeyears'].' set "STID"=$1 where sd'.$_SESSION['activeyears'].'."DTID" = Any(string_to_array($2::text, \',\'::text)::integer[])',array($idsarray[0],implode(',',$linkDTarray)));

														pg_query_params($db,'update vt'.$_SESSION['activeyears'].' set "STID"=$1 where vt'.$_SESSION['activeyears'].'."DTID" = Any(string_to_array($2::text, \',\'::text)::bigint[])',array($idsarray[0],implode(',',$linkDTarray)));

														// pg_query('update wd'.$_SESSION['activeyears'].' set "STID"='.$idsarray[0].' where wd'.$_SESSION['activeyears'].'."DTID" IN ('.implode(',',$linkDTarray).')');

														
														if(count($removearrayst)>0)
														{
															pg_query_params($db,'update st'.$_SESSION['activeyears'].' set "is_deleted"=$1 where "STID" = Any(string_to_array($2::text, \',\'::text)::integer[])',array(0,implode(',',$removearrayst)));	
														}
															

														if($partiallylevel!='')
												{

													$partiallylevelquery = rtrim($partiallylevel, ',');


														pg_query("insert into partiallydata".$_SESSION['activeyears']." (comefrom,fromids,comeaction,toids,docids,partiallydataids) VALUES ".$partiallylevelquery." ");
												}


												
										$aa=array($idsarray[0],1);
								 $finalquerydt = 'insert into forreaddata2021 ("frfromids","frfromaction","frtoids","frdocids","frcomefrom",
								"frcomment","is_final","comeaction","STID","DTID","STIDACTIVE","DTIDACTIVE","STIDR","DTIDR","created_by")
								(select "frfromids","frfromaction","frtoids","frdocids","frcomefrom",
								"frcomment","is_final","comeaction",dt21."STIDR"::integer AS "STIDR11",dt21."DTIDR"::integer AS "DTIDR11",dt21."STID",dt21."DTID",dt21."STIDR"::integer,dt21."DTIDR"::integer,"created_by" from dt2021 as dt21 
								LEFT JOIN (select * from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as fr21 ON fr21."frtoids"=dt21."STID" 
								 where dt21."STID"=$1 AND dt21."is_deleted"=$2
								)';

								pg_query_params($db,$finalquerydt,$aa);

								$finalquerysd = 'insert into forreaddata2021 ("frfromids","frfromaction","frtoids","frdocids","frcomefrom",
								"frcomment","is_final","comeaction","STID","DTID","SDID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","STIDR","DTIDR","SDIDR","created_by")
								(select "frfromids","frfromaction","frtoids","frdocids","frcomefrom",
								"frcomment","is_final","comeaction",sd21."STIDR"::integer AS "STIDR11",sd21."DTIDR"::integer AS "DTIDR11",sd21."SDIDR"::BIGINT AS "SDIDR11",sd21."STID",sd21."DTID",sd21."SDID",sd21."STIDR"::integer,sd21."DTIDR"::integer,sd21."SDIDR"::BIGINT,"created_by" from sd2021 as sd21 
								LEFT JOIN (select * from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as fr21 ON fr21."frtoids"=sd21."STID"
								 where sd21."STID"=$1 AND sd21."is_deleted"=$2
								)';
								pg_query_params($db,$finalquerysd,$aa);

								 $finalqueryvt = 'insert into forreaddata2021 ("frfromids","frfromaction","frtoids","frdocids","frcomefrom",
								"frcomment","is_final","comeaction","STID","DTID","SDID","VTID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE","STIDR","DTIDR","SDIDR","VTIDR","created_by")
								(select "frfromids","frfromaction","frtoids","frdocids","frcomefrom",
								"frcomment","is_final","comeaction",vt21."STIDR"::integer AS "STIDR11",vt21."DTIDR"::integer AS "DTIDR11",vt21."SDIDR"::BIGINT AS "SDIDR11",vt21."VTIDR"::NUMERIC AS "VTIDR11",vt21."STID",vt21."DTID",vt21."SDID",vt21."VTID",vt21."STIDR"::integer,vt21."DTIDR"::integer,vt21."SDIDR"::BIGINT,vt21."VTIDR"::NUMERIC,"created_by" from vt2021 as vt21 
								LEFT JOIN (select * from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as fr21 ON fr21."frtoids"=vt21."STID" where vt21."STID"=$1 AND vt21."is_deleted"=$2
								)';

								pg_query_params($db,$finalqueryvt,$aa);




											


														$task = "addfinish";
														}
														else
														{
														$task = "error";
														}


					}
					else
					{


									$refid='select * from st'.$_SESSION['activeyears'].' where "STID"=$1';
									$getref = pg_query_params($db,$refid,array($retdata['namefrom'][0]));
									$refids=pg_fetch_array($getref);



									$partiallylevel = '';
									$idsarray = array();
									$insertstlink='';
									$idsdata = $idsquerydata[0];
									
									for($j1=0;$j1<count($retdata['newname']);$j1++)
									{
										$idsdata =$idsdata+1;
										$idsarray[$j1]=$idsdata;

										 $insertstlinkquery= array($idsdata,$retdata['newname'][$j1],ucwords(strtoupper($retdata['StateStatus'][$j1])),$refids['STIDR'],'new',$_SESSION['login_id']);

											$insertst = 'insert into st'.$_SESSION['activeyears'].' ("STID","STName","Status","STIDR","flagofcreate","createdby") VALUES ($1,$2,$3,$4,$5,$6) returning "STID"';

									pg_query_params($db,$insertst,$insertstlinkquery);
									}
								// 	$insertstlinkquery = rtrim($insertstlink, ',');


								

									$linkSTarray='';

									$linkSTarray = $retdata['namefrom'];

												for($i=0;$i<count($idsarray);$i++)
												{
												array_push($linkSTarray,$idsarray[$i]);
												}
												if($dataofremove[0]==1)
												{

												array_push($removearrayst,$retdata['namefrom'][0]); 
												}


												$linkDTarray = array();
												$forread = '';
												$forread1 = '';
												
												for($j=0;$j<count($retdata['newname']);$j++)
												{

													
													if(isset($finaldata['partiallylevel'.$j.'']))
													{

															$havep = true;


														$finaldata['addlinksDTID'.$j.''] = array_diff($finaldata['addlinksDTID'.$j.''],$finaldata['partiallylevel'.$j.'']);
														

													}
												// 	print_r($retdata);
													$frcomment='';
													$frcomment1='';
													$statusflag='';
													if($retdata['StateStatus'][$j]=='ST')
													{
														$statusflag='State';
													}
													else
													{
														$statusflag='Union Territory';
													}

													$fstatusflag='';
													if($retdata['ostate'][0]=='ST')
													{
														$fstatusflag='State';
													}
													else
													{
														$fstatusflag='Union Territory';
													}

													$frcomment .='<strong style="color:#aa81f3;"><u>State/UT:</u></strong> '.$statusflag.' '.$retdata['newname'][$j].' Created from '.$retdata['namefromtext'].';';

													$frcomment .=' <strong style="color:Green;"><u>District:</u></strong> - ; <strong style="color:blue;"><u>Sub District:</u></strong> - ; <strong style="color:#45b0e2;"><u>Town:</u></strong> - ; <strong style="color:#15bed2;"><u>Village:</u></strong> - ;';

													$frcomment1='<strong style="color:#aa81f3;"><u>State/UT:</u></strong> '.$retdata['namefromtext'].' '.$retdata['action'][0].' &  Create '.$statusflag.' '.$retdata['newname'][$j].'';

													$frcomment1 .=' <strong style="color:Green;"><u>District:</u></strong> - ; <strong style="color:blue;"><u>Sub District:</u></strong> - ; <strong style="color:#45b0e2;"><u>Town:</u></strong> - ; <strong style="color:#15bed2;"><u>Village:</u></strong> - ;';

												$linkDTarray=array_merge($linkDTarray,$finaldata['addlinksDTID'.$j.'']);	
											

												if(count($removearrayst)==0)
												{
												$forread1 = array($retdata['namefrom'][0],$retdata['action'][0],$retdata['namefrom'][0],$retdata['docids'],$retdata['comefromcheck'],$frcomment1,'MAIN',$retdata['namefrom'][0],$retdata['namefrom'][0],$refids['STIDR'],$_SESSION['login_id']);

												$insertforread1 = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","STIDACTIVE","STIDR","created_by") VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11)';
												pg_query_params($db,$insertforread1,$forread1);	


												}


												// $forread =array($retdata['namefrom'][0],$retdata['action'][0],$idsarray[$j],$retdata['docids'],$retdata['comefromcheck'],$frcomment,'Create',$retdata['namefrom'][0],$idsarray[$j],$refids['STIDR'],$_SESSION['login_id']);
												// $insertforread = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","STIDACTIVE","STIDR","created_by") VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11)';
												// $result = pg_query_params($db,$insertforread,$forread);

												//1912 by sahana for new state status
												if($retdata['ostate'][0]!=$retdata['fstatus'][0])
												{
														$frcomment='';
														$stat='';
														if($retdata['ostate'][0]=='ST')
														{
															$stat = 'State';
														}
														else
														{
															$stat = 'Union Territory';
														}

														$stat1='';
														if($retdata['fstatus'][0]=='ST')
														{
															$stat1 = 'State';
														}
														else
														{
															$stat1 = 'Union Territory';
														}
														
														$frcomment .='<strong style="color:#aa81f3;"><u>State/UT:</u></strong> '.$statusflag.' '.$retdata['newname'][$j].' Created from '.$retdata['namefromtext'].'. '.$retdata['namefromtext'].' '.$stat1.' Status Changed to '.$stat.';';
														$frcomment .=' <strong style="color:Green;"><u>District:</u></strong> - ; <strong style="color:blue;"><u>Sub District:</u></strong> - ; <strong style="color:#45b0e2;"><u>Town:</u></strong> - ; <strong style="color:#15bed2;"><u>Village:</u></strong> - ;';

														$forread =array($retdata['namefrom'][0],$retdata['action'][0],$idsarray[$j],$retdata['docids'],$retdata['comefromcheck'],$frcomment,'Create',$retdata['namefrom'][0],$idsarray[$j],$refids['STIDR'],$_SESSION['login_id']);
														$insertforread = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","STIDACTIVE","STIDR","created_by") VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11)';
														$result = pg_query_params($db,$insertforread,$forread);

												} 
												else 
												{

														$forread =array($retdata['namefrom'][0],$retdata['action'][0],$idsarray[$j],$retdata['docids'],$retdata['comefromcheck'],$frcomment,'Create',$retdata['namefrom'][0],$idsarray[$j],$refids['STIDR'],$_SESSION['login_id']);
														$insertforread = 'insert into forreaddata'.$_SESSION['activeyears'].' ("frfromids","frfromaction","frtoids","frdocids","frcomefrom","frcomment","comeaction","STID","STIDACTIVE","STIDR","created_by") VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11)';
														$result = pg_query_params($db,$insertforread,$forread);
													
												}


												}
													
												//By sahana split state level one to one 0111
												$auflag_query = 'SELECT auflag FROM unit WHERE auaction = $1 AND aulevel = $2';
												$au = pg_query_params($db, $auflag_query, array($retdata['action'][0], $retdata['comefromcheck']));

												if ($au) {
													$row = pg_fetch_assoc($au);
													$auflag_value = $row['auflag'];
													$namefrom = $retdata['namefrom'][0];

													$update_vt = pg_query_params($db, 'UPDATE vt'.$_SESSION['activeyears'].' SET "auflag" = $1, "auaction" = $2 WHERE "STID" = $3', array($auflag_value, $retdata['action'][0], $namefrom));
													$update_sd = pg_query_params($db, 'UPDATE sd'.$_SESSION['activeyears'].' SET "auflag" = $1, "auaction" = $2 WHERE "STID" = $3', array($auflag_value, $retdata['action'][0], $namefrom));
													$update_dt = pg_query_params($db, 'UPDATE dt'.$_SESSION['activeyears'].' SET "auflag" = $1, "auaction" = $2 WHERE "STID" = $3', array($auflag_value, $retdata['action'][0], $namefrom));
													$update_st = pg_query_params($db, 'UPDATE st'.$_SESSION['activeyears'].' SET "auflag" = $1, "auaction" = $2 WHERE "STID" = $3', array($auflag_value, $retdata['action'][0], $namefrom));
													
											
													if (!$update_st || !$update_dt || !$update_sd || !$update_vt) { 
														echo "UPDATE queries failed: " . pg_last_error($db);
													}
												} else {
													echo "SELECT query failed: " . pg_last_error($db);
												}

													
																
											

												// $forreadqueryappend = rtrim($forread, ',');
												// $forreadqueryappend1 = rtrim($forread1, ',');

												// $linkst='';
												for($k=0;$k<count($linkSTarray);$k++)
												{
												// $linkst .="(".$retdata['docids'].",".$linkSTarray[$k]."),";

												$insertlinkst = 'insert into documentlink'.$_SESSION['activeyears'].' (docids,linkstids) VALUES ($1,$2)';

													$resultst = pg_query_params($db,$insertlinkst,array($retdata['docids'],$linkSTarray[$k]));


												}
											

												$linkdt='';
												$linkdtupdate=array();
												for($l=0;$l<count($idsarray);$l++)
												{

												if(isset($finaldata['addlinksDTID'.$l.'']))
												{


													if(isset($finaldata['partiallylevel'.$l.'']))
													{
														$havep = true;
															for($a=0;$a<count($finaldata['partiallylevel'.$l.'']);$a++)
																{
																	//modified by gowthami to solve the issue related to wine line in AU
																	//$partiallylevel .="('".$retdata['comefromcheck']."',".$retdata['namefrom'][0].",'".$retdata['action'][0]."',".$idsarray[$l].",".$retdata['docids'].",".$finaldata['partiallylevel'.$l.''][$a].")," ;
																    $partiallylevel .="('".$retdata['comefromcheck']."',".$retdata['namefrom'][0].",'".$retdata['action'][0]."',".$idsarray[$l].",".$retdata['docids'].",".$finaldata['partiallylevel'.$l.''][$a].",".$retdata['namefrom'][0].")," ;
																}
														$finaldata['addlinksDTID'.$l.''] = array_diff($finaldata['addlinksDTID'.$l.''],$finaldata['partiallylevel'.$l.'']);
													}

											$datao = array_values(array_filter($finaldata['addlinksDTID'.$l.'']));
												//	print_r($finaldata['addlinksDTID'.$l.'']);

												for($b=0;$b<count($datao);$b++)
												{

														

													$linkdtupdate[$l][$b]=$datao[$b];


														// $linkdt .="(".$retdata['docids'].",".$idsarray[$l].",".$datao[$b]."),";

														if(count($linkDTarray)>0)
														{
														$insertlinkdt = 'insert into documentlink'.$_SESSION['activeyears'].' (docids,linkstids,linkdtids) VALUES ($1,$2,$3)';	
														$resultdt = pg_query_params($db,$insertlinkdt,array($retdata['docids'],$idsarray[$l],$datao[$b]));
														}




												}

														
												}


												}

										



								
												//	$linkdtfinal = rtrim($linkdt, ',');
																					

									
												

												$resultst_rows = pg_affected_rows($resultst);
												
												if($resultst_rows!=0)
												{
												//pg_query_params($db,'update documentdata'.$_SESSION['activeyears'].' set docstatus=1 where docids='.$retdata['docids'].'',array(1,$retdata['docids']));
												
                                                // Creation of new state status changing issue. By Yogesh

                                                pg_query_params($db,'update documentdata'.$_SESSION['activeyears'].' set docstatus=$1 where docids=$2',array(1,$retdata['docids']));
												//Modified by Arun for State/UT status change
                                                pg_query_params($db,'update st'.$_SESSION['activeyears'].' set "Status"=$1 where "STID"=$2',array($retdata['fstatus'][0],$retdata['namefrom'][0]));

												// pg_query_params($db,'update st'.$_SESSION['activeyears'].' set Status=$1 where "STID"=$2',array($retdata['fstatus'][0],$retdata['docids'],$retdata['namefrom'][0]));

												for($mk=0;$mk<count($linkdtupdate);$mk++)

											{

													

													pg_query_params($db,'update dt'.$_SESSION['activeyears'].' set "STID"=$1 where dt'.$_SESSION['activeyears'].'."DTID" = Any(string_to_array($2::text, \',\'::text)::integer[])',array($idsarray[$mk],implode(',',$linkdtupdate[$mk])));

													pg_query_params($db,'update sd'.$_SESSION['activeyears'].' set "STID"=$1 where sd'.$_SESSION['activeyears'].'."DTID" = Any(string_to_array($2::text, \',\'::text)::integer[])',array($idsarray[$mk],implode(',',$linkdtupdate[$mk])));	

													pg_query_params($db,'update vt'.$_SESSION['activeyears'].' set "STID"=$1 where vt'.$_SESSION['activeyears'].'."DTID" = Any(string_to_array($2::text, \',\'::text)::bigint[])',array($idsarray[$mk],implode(',',$linkdtupdate[$mk])));


													// pg_query('update wd'.$_SESSION['activeyears'].' set "STID"='.$idsarray[$mk].' where wd'.$_SESSION['activeyears'].'."DTID" IN ('.implode(',',$linkdtupdate[$mk]).')');

												}


												

												if($partiallylevel!='')
												{
													$partiallylevelquery = rtrim($partiallylevel, ',');
 															//modified by gowthami due to wineline issue
													       // pg_query("insert into partiallydata".$_SESSION['activeyears']." (comefrom,fromids,comeaction,toids,docids,partiallydataids,) VALUES ".$partiallylevelquery." ");
														   pg_query("insert into partiallydata".$_SESSION['activeyears']." (comefrom,fromids,comeaction,toids,docids,partiallydataids,stid) VALUES ".$partiallylevelquery." ");
														}
												if(count($removearrayst)>0)
												{
															pg_query_params($db,'update st'.$_SESSION['activeyears'].' set "is_deleted"=$1 where "DTID" = Any(string_to_array($2::text, \',\'::text)::integer[])',array(0,implode(',',$removearrayst)));	
												}
												

											
										

											for($kl=0;$kl<count($idsarray);$kl++)
												{
														$aaa=array();
														$aaa=array($idsarray[$kl],1);
													  $finalquerydt = 'insert into forreaddata2021 ("frfromids","frfromaction","frtoids","frdocids","frcomefrom",
													"frcomment","is_final","comeaction","STID","DTID","STIDACTIVE","DTIDACTIVE","STIDR","DTIDR","created_by")
													(select "frfromids","frfromaction","frtoids","frdocids","frcomefrom",
													"frcomment","is_final","comeaction",dt21."STIDR"::integer AS "STIDR11",dt21."DTIDR"::integer AS "DTIDR11",dt21."STID",dt21."DTID",dt21."STIDR"::integer,dt21."DTIDR"::integer,"created_by" from dt2021 as dt21 
													LEFT JOIN (select * from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as fr21 ON fr21."frtoids"=dt21."STID" 
													 where dt21."STID"=$1 AND dt21."is_deleted"=$2
													)';

													pg_query_params($db,$finalquerydt,$aaa);

													$finalquerysd = 'insert into forreaddata2021 ("frfromids","frfromaction","frtoids","frdocids","frcomefrom",
													"frcomment","is_final","comeaction","STID","DTID","SDID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","STIDR","DTIDR","SDIDR","created_by")
													(select "frfromids","frfromaction","frtoids","frdocids","frcomefrom",
													"frcomment","is_final","comeaction",sd21."STIDR"::integer AS "STIDR11",sd21."DTIDR"::integer AS "DTIDR11",sd21."SDIDR"::BIGINT AS "SDIDR11",sd21."STID",sd21."DTID",sd21."SDID",sd21."STIDR"::integer,sd21."DTIDR"::integer,sd21."SDIDR"::BIGINT,"created_by" from sd2021 as sd21 
													LEFT JOIN (select * from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as fr21 ON fr21."frtoids"=sd21."STID"
													 where sd21."STID"=$1 AND sd21."is_deleted"=$2
													)';
													pg_query_params($db,$finalquerysd,$aaa);

													//by sahana state status 1912
													if ($retdata['ostate'][0]!=$retdata['fstatus'][0])
													{
														$aaa=array($retdata['namefrom'][$kl],1,$idsarray[$kl]);

														$finalqueryvt = 'INSERT INTO forreaddata2021 (
															"frfromids", "frfromaction", "frtoids", "frdocids", "frcomefrom",
															"frcomment", "is_final", "comeaction", "STID", "DTID", "SDID", "VTID",
															"STIDACTIVE", "DTIDACTIVE", "SDIDACTIVE", "VTIDACTIVE", "STIDR", "DTIDR",
															"SDIDR", "VTIDR", "created_by"
														)
														SELECT
															"frfromids", "frfromaction", "frtoids", "frdocids", "frcomefrom",
															"frcomment", "is_final", "comeaction", vt21."STIDR"::integer AS "STIDR11",
															vt21."DTIDR"::integer AS "DTIDR11", vt21."SDIDR"::BIGINT AS "SDIDR11",
															vt21."VTIDR"::NUMERIC AS "VTIDR11", vt21."STID", vt21."DTID", vt21."SDID",
															vt21."VTID", vt21."STIDR"::integer, vt21."DTIDR"::integer,
															vt21."SDIDR"::BIGINT, vt21."VTIDR"::NUMERIC, "created_by"
														FROM
															vt2021 AS vt21
														LEFT JOIN (
															SELECT *
															FROM forreaddata2021
															WHERE "frtoids" = $3 AND "frfromaction" = \'Split\'
															ORDER BY "frids" DESC
															LIMIT 1
														) AS fr21 ON fr21."frtoids" = vt21."STID"
														WHERE
															vt21."STIDR"::integer = $1 AND vt21."is_deleted" = $2';
														
								
														pg_query_params($db,$finalqueryvt,$aaa);
													}
													else 
													{

														$finalqueryvt = 'insert into forreaddata2021 ("frfromids","frfromaction","frtoids","frdocids","frcomefrom",
														"frcomment","is_final","comeaction","STID","DTID","SDID","VTID","STIDACTIVE","DTIDACTIVE","SDIDACTIVE","VTIDACTIVE","STIDR","DTIDR","SDIDR","VTIDR","created_by")
														(select "frfromids","frfromaction","frtoids","frdocids","frcomefrom",
														"frcomment","is_final","comeaction",vt21."STIDR"::integer AS "STIDR11",vt21."DTIDR"::integer AS "DTIDR11",vt21."SDIDR"::BIGINT AS "SDIDR11",vt21."VTIDR"::NUMERIC AS "VTIDR11",vt21."STID",vt21."DTID",vt21."SDID",vt21."VTID",vt21."STIDR"::integer,vt21."DTIDR"::integer,vt21."SDIDR"::BIGINT,vt21."VTIDR"::NUMERIC ,"created_by" from vt2021 as vt21 
														LEFT JOIN (select * from forreaddata2021 where "frtoids"=$1 ORDER BY "frids" DESC limit 1) as fr21 ON fr21."frtoids"=vt21."STID" where vt21."STID"=$1 AND vt21."is_deleted"=$2
														)';
	
														pg_query_params($db,$finalqueryvt,$aaa);
													}
												}

		

												$task = "addfinish";
												}
												else
												{
												$task = "error";
												}





					}

	}

}



 		
	
echo $task."|".$retdata['docids']."|".$havep."|".$_POST['clickbutton'];

}


else if($_POST['formname']=='getreportPCA')
                {

            //    $table = "concordance".$_SESSION['activeyears']."";


$array = array("stids"=>$_POST['stids'],"dtids"=>$_POST['dtids'],"sdids"=>$_POST['sdids']);
              
                $primaryKey = 'ID';
$cond='';
$cond1='';
$cond2='';
$cond11='';
$cond22='';

$cond111='';
$cond221='';


	$acyear = $_SESSION['activeyears'];
	$olyear = $_SESSION['logindetails']['baseyear'];
	if($_SESSION['logindetails']['assignlist']!='')
	{
		$loginid = $_SESSION['logindetails']['assignlist'];
			$cond = ' WHERE "vt'.$acyear.'"."STID"='.$_SESSION['logindetails']['assignlist'].'';
			$condo = ' WHERE forreaddata'.$acyear.'."STIDACTIVE"='.$loginid.'';

			$condost = ' AND fr21."STIDACTIVE"='.$loginid.'';

			if($_POST['dtids']!='')
			{
			$cond1 =' AND "vt'.$acyear.'"."DTID"='.$_POST['dtids'].'';
			$condo =' AND "forreaddata'.$acyear.'"."DTIDACTIVE"='.$_POST['dtids'].'';
			$condost =' AND "fr21"."DTIDACTIVE"='.$_POST['dtids'].'';
			$cond111 =' AND "vt'.$olyear.'"."DTID"='.$_POST['dtids'].'';
			}

			if($_POST['sdids']!='')
			{
			$cond2 =' AND "vt'.$acyear.'"."SDID"='.$_POST['sdids'].'';
			$condo =' AND "forreaddata'.$acyear.'"."SDIDACTIVE"='.$_POST['sdids'].'';
			$condost =' AND "fr21"."SDIDACTIVE"='.$_POST['sdids'].'';
			$cond222 =' AND "vt'.$olyear.'"."SDID"='.$_POST['dtids'].'';
			}
	}
	else
	{
		$loginid = $_POST['stids'];
		        if($_POST['stids']!='')
                {
	$cond =' WHERE vt'.$acyear.'."STID"='.$_POST['stids'].'';
	$condost = ' AND fr21."STIDACTIVE"='.$loginid.'';
                }
               if($_POST['dtids']!='')
			{
			$cond1 =' AND "vt'.$_SESSION['activeyears'].'"."DTID"='.$_POST['dtids'].'';
				$cond11 =' AND "forreaddata'.$acyear.'"."DTIDACTIVE"='.$_POST['dtids'].'';
				$cond11dt =' AND "fr21"."DTIDACTIVE"='.$_POST['dtids'].'';
				$cond111 =' AND "vt'.$olyear.'"."DTID"='.$_POST['dtids'].'';
			}

			if($array['sdids']!='')
			{
			$cond2 =' AND "vt'.$acyear.'"."SDID"='.$array['sdids'].'';
			$cond22 =' AND "forreaddata'.$acyear.'"."SDIDACTIVE"='.$array['sdids'].'';
			$cond22sd =' AND "fr21"."SDIDACTIVE"='.$_POST['sdids'].'';
			$cond222 =' AND "vt'.$olyear.'"."SDID"='.$array['dtids'].'';
			}
			
	}
	

// SELECT *
//    FROM "vtCount2021"
//      LEFT JOIN "vtCount$olyear" ON "vtCount2011"."STID2011"::character varying::text = "vtCount2021"."STIDR"::text
// 	 AND "vtCount2011"."DTID2011"::character varying::text = "vtCount2021"."DTIDR"::text 
// 	 AND "vtCount2011"."SDID2011"::character varying::text = "vtCount2021"."SDIDR"::text 
// 	 AND "vtCount2011"."VTID2011" = ANY (string_to_array("vtCount2021"."VTIDR"::text, ','::text)::numeric[]) $cond $cond1 $cond2

//by gowthami concordance issue civic status
$table = <<<EOT
(
    SELECT * FROM (
        SELECT
            vt$acyear."is_deleted",
            CASE WHEN vt$acyear."is_deleted" = 0 THEN '' ELSE st21."MDDS_ST" END AS "MDDS_ST",
            CASE WHEN vt$acyear."is_deleted" = 0 THEN '' ELSE st21."STName" END AS "STName",
            CASE WHEN vt$acyear."is_deleted" = 0 THEN '' ELSE st21."Status" END AS "STStatus",
            CASE WHEN vt$acyear."is_deleted" = 0 THEN '' ELSE dt21."MDDS_DT" END AS "MDDS_DT",
            CASE WHEN vt$acyear."is_deleted" = 0 THEN '' ELSE dt21."DTName" END AS "DTName",
            CASE WHEN vt$acyear."is_deleted" = 0 THEN '' ELSE sd21."MDDS_SD" END AS "MDDS_SD",
            CASE WHEN vt$acyear."is_deleted" = 0 THEN '' ELSE sd21."SDName" END AS "SDName",
            vt$acyear."ID",
            CASE WHEN vt$acyear."is_deleted" = 0 THEN '' ELSE vt$acyear."VTName" END AS "VTName",
            CASE WHEN vt$acyear."is_deleted" = 0 THEN '' ELSE vt$acyear."MDDS_VT" END AS "MDDS_VT",
            CASE WHEN vt$acyear."is_deleted" = 0 THEN '' ELSE vt$acyear."Level" END AS "Level",
            CASE WHEN vt$acyear."is_deleted" = 0 THEN '' ELSE vt$acyear."Status" END AS "Status",
            fr21.*
        FROM vt$acyear
        INNER JOIN (
            SELECT
                forreaddata$acyear."STIDACTIVE",
                forreaddata$acyear."frfromaction"::TEXT,
                forreaddata$acyear."DTIDACTIVE",
                forreaddata$acyear."SDIDACTIVE",
                forreaddata$acyear."VTIDACTIVE",
                forreaddata$acyear."VTIDR",
                vt$olyear."STID$olyear",
                vt$olyear."STName$olyear",
                vt$olyear."STStatus$olyear",
                vt$olyear."MDDS_ST$olyear",
                vt$olyear."DTID$olyear",
                vt$olyear."DTName$olyear",
                vt$olyear."MDDS_DT$olyear",
                vt$olyear."SDID$olyear",
                vt$olyear."SDName$olyear",
                vt$olyear."MDDS_SD$olyear",
                vt$olyear."VTID" AS "VTID$olyear",
                vt$olyear."VTName" AS "VTName$olyear",
                vt$olyear."MDDS_VT" AS "MDDS_VT$olyear",
                vt$olyear."Level" AS "Level$olyear",
                vt$olyear."Status" AS "Status$olyear"
            FROM forreaddata$acyear
            LEFT JOIN (
                SELECT *
                FROM vt$olyear
                INNER JOIN (
                    SELECT
                        "STID" AS "STID$olyear",
                        "STName" AS "STName$olyear",
                        "Status" AS "STStatus$olyear",
                        "MDDS_ST" AS "MDDS_ST$olyear"
                    FROM st$olyear
                ) AS st11 ON st11."STID$olyear" = vt$olyear."STID"
                INNER JOIN (
                    SELECT
                        "DTID" AS "DTID$olyear",
                        "DTName" AS "DTName$olyear",
                        "MDDS_DT" AS "MDDS_DT$olyear"
                    FROM dt$olyear
                ) AS dt11 ON dt11."DTID$olyear" = vt$olyear."DTID"
                INNER JOIN (
                    SELECT
                        "SDID" AS "SDID$olyear",
                        "SDName" AS "SDName$olyear",
                        "MDDS_SD" AS "MDDS_SD$olyear"
                    FROM sd$olyear
                ) AS sd11 ON sd11."SDID$olyear" = vt$olyear."SDID"
            ) AS vt$olyear ON vt$olyear."VTID" = forreaddata$acyear."VTIDR" Where
                 forreaddata$acyear."VTIDACTIVE" != 0
                AND( forreaddata$acyear."VTIDACTIVE" != forreaddata$acyear."VTID" OR "frfromaction" = 'Addition' OR "frfromaction" = 'Deletion' OR "frfromaction" = 'Sub-Merge')
                AND forreaddata$acyear."frcomefrom" = 'Village / Town'
                AND forreaddata$acyear."comeaction" != 'MAIN'
        ) AS fr21 ON fr21."VTIDACTIVE" = vt$acyear."VTID"
            $condost
            AND (
                fr21."VTIDACTIVE" != fr21."VTIDR"
                OR fr21."frfromaction" = 'Sub-Merge'
                OR "frfromaction" = 'Deletion'
            )
        INNER JOIN (SELECT * FROM st$acyear) AS st21 ON st21."STID" = vt$acyear."STID"
        INNER JOIN (SELECT * FROM dt$acyear) AS dt21 ON dt21."DTID" = vt$acyear."DTID"
        INNER JOIN (SELECT * FROM sd$acyear) AS sd21 ON sd21."SDID" = vt$acyear."SDID"
        WHERE vt$acyear."STID" = $loginid $cond1 $cond2
        UNION ALL
        SELECT
            vt$acyear."is_deleted",
            st21."MDDS_ST"::TEXT,
            st21."STName",
            st21."STStatus",
            dt21."MDDS_DT"::TEXT,
            dt21."DTName",
            sd21."MDDS_SD"::TEXT,
            sd21."SDName",
            vt$acyear."ID",
            vt$acyear."VTName",
            vt$acyear."MDDS_VT",
            vt$acyear."Level",
            vt$acyear."Status",
            vt11.*
        FROM vt$acyear
        INNER JOIN (
            SELECT
                "STID" AS "STID",
                "STName" AS "STName",
                "Status" AS "STStatus",
                "MDDS_ST" AS "MDDS_ST",
                st$acyear."is_deleted"
            FROM st$acyear
        ) AS st21 ON st21."STID" = vt$acyear."STID" AND st21."is_deleted" = 1
        INNER JOIN (
            SELECT
                "DTID" AS "DTID",
                "DTName" AS "DTName",
                "MDDS_DT" AS "MDDS_DT",
                dt$acyear."is_deleted"
            FROM dt$acyear
        ) AS dt21 ON dt21."DTID" = vt$acyear."DTID" AND dt21."is_deleted" = 1
        INNER JOIN (
            SELECT
                "SDID" AS "SDID",
                "SDName" AS "SDName",
                "MDDS_SD" AS "MDDS_SD",
                sd$acyear."is_deleted"
            FROM sd$acyear
        ) AS sd21 ON sd21."SDID" = vt$acyear."SDID" AND sd21."is_deleted" = 1
        LEFT JOIN (
            SELECT
                0 AS "STIDACTIVE",
                '0' AS "frfromaction",
                0 AS "DTIDACTIVE",
                0 AS "SDIDACTIVE",
                0 AS "VTIDACTIVE",
                0 AS "VTIDR",
                vt$olyear."STID$olyear",
                vt$olyear."STName$olyear",
                vt$olyear."STStatus$olyear",
                vt$olyear."MDDS_ST$olyear",
                vt$olyear."DTID$olyear",
                vt$olyear."DTName$olyear",
                vt$olyear."MDDS_DT$olyear",
                vt$olyear."SDID$olyear",
                vt$olyear."SDName$olyear",
                vt$olyear."MDDS_SD$olyear",
                vt$olyear."VTID" AS "VTID$olyear",
                vt$olyear."VTName" AS "VTName$olyear",
                vt$olyear."MDDS_VT" AS "MDDS_VT$olyear",
                vt$olyear."Level" AS "Level$olyear",
                vt$olyear."Status" AS "Status$olyear"
            FROM (
                SELECT
                    vt$olyear."STID",
                    vt$olyear."DTID",
                    vt$olyear."SDID",
                    vt$olyear."VTID",
                    vt$olyear."VTName",
                    vt$olyear."MDDS_VT",
                    vt$olyear."Level",
                    vt$olyear."Status",
                    st11."STID$olyear",
                    st11."STName$olyear",
                    st11."STStatus$olyear",
                    st11."MDDS_ST$olyear",
                    dt11."DTID$olyear",
                    dt11."DTName$olyear",
                    dt11."MDDS_DT$olyear",
                    sd11."SDID$olyear",
                    sd11."SDName$olyear",
                    sd11."MDDS_SD$olyear"
                FROM vt$olyear
                INNER JOIN (
                    SELECT
                        "STID" AS "STID$olyear",
                        "STName" AS "STName$olyear",
                        "Status" AS "STStatus$olyear",
                        "MDDS_ST" AS "MDDS_ST$olyear"
                    FROM st$olyear
                ) AS st11 ON st11."STID$olyear" = vt$olyear."STID"
                INNER JOIN (
                    SELECT
                        "DTID" AS "DTID$olyear",
                        "DTName" AS "DTName$olyear",
                        "MDDS_DT" AS "MDDS_DT$olyear"
                    FROM dt$olyear
                ) AS dt11 ON dt11."DTID$olyear" = vt$olyear."DTID"
                INNER JOIN (
                    SELECT
                        "SDID" AS "SDID$olyear",
                        "SDName" AS "SDName$olyear",
                        "MDDS_SD" AS "MDDS_SD$olyear"
                    FROM sd$olyear
                ) AS sd11 ON sd11."SDID$olyear" = vt$olyear."SDID"
            ) AS vt$olyear
        ) AS vt11 ON vt11."VTID$olyear" = vt$acyear."VTID"
        WHERE vt$acyear."STID" = $loginid $cond1 $cond2
            AND vt$acyear."is_deleted" = 1
            AND vt11."VTID$olyear" IS NOT NULL
    ) AS TAB1
) temp
EOT;


if (pg_query(!$table)) {
	echo pg_last_error($db);
} 



// AND vt11."VTID$olyear" is not null
$columns = array(
	array( 'db' => '"MDDS_ST'.$_SESSION['logindetails']['baseyear'].'"','dt' => 0,'db1' => 'MDDS_ST'.$_SESSION['logindetails']['baseyear'].''),
	array( 'db' => '"STName'.$_SESSION['logindetails']['baseyear'].'"','dt' => 1,'db1' => 'STName'.$_SESSION['logindetails']['baseyear'].''),
	array( 'db' => '"STStatus'.$_SESSION['logindetails']['baseyear'].'"','dt' => 2,'db1' => 'STStatus'.$_SESSION['logindetails']['baseyear'].''),
	array( 'db' => '"MDDS_DT'.$_SESSION['logindetails']['baseyear'].'"','dt' => 3,'db1' => 'MDDS_DT'.$_SESSION['logindetails']['baseyear'].''),
	array( 'db' => '"DTName'.$_SESSION['logindetails']['baseyear'].'"','dt' => 4,'db1' => 'DTName'.$_SESSION['logindetails']['baseyear'].''),
	array( 'db' => '"MDDS_SD'.$_SESSION['logindetails']['baseyear'].'"','dt' => 5,'db1' => 'MDDS_SD'.$_SESSION['logindetails']['baseyear'].''),
	array( 'db' => '"SDName'.$_SESSION['logindetails']['baseyear'].'"','dt' => 6,'db1' => 'SDName'.$_SESSION['logindetails']['baseyear'].''),
	array( 'db' => '"MDDS_VT'.$_SESSION['logindetails']['baseyear'].'"','dt' => 7,'db1' => 'MDDS_VT'.$_SESSION['logindetails']['baseyear'].''),
	array( 'db' => '"VTName'.$_SESSION['logindetails']['baseyear'].'"','dt' => 8,'db1' => 'VTName'.$_SESSION['logindetails']['baseyear'].''),
	array( 'db' => '"Level'.$_SESSION['logindetails']['baseyear'].'"','dt' => 9,'db1' => 'Level'.$_SESSION['logindetails']['baseyear'].''),
	// <!-- modified by sahana to add status column in Concordance Reports -->
	array( 'db' => '"Status'.$_SESSION['logindetails']['baseyear'].'"', 'dt' => 10,'db1' => 'Status'.$_SESSION['logindetails']['baseyear'].'',
	'formatter' => function( $d, $row ) {
	if (!is_null($d) && $d=='Village')
	 {
		 return 'RV';
	 }
	 else
	 {
	 return $d;
	 }
	} ),
	array( 'db' => '"MDDS_ST"','dt' => 11,'db1' => 'MDDS_ST'),
	array( 'db' => '"STName"','dt' => 12,'db1' => 'STName'),
	array( 'db' => '"STStatus"','dt' => 13,'db1' => 'STStatus'),
	array( 'db' => '"MDDS_DT"','dt' => 14,'db1' => 'MDDS_DT'),
	array( 'db' => '"DTName"','dt' => 15,'db1' => 'DTName'),
	array( 'db' => '"MDDS_SD"','dt' => 16,'db1' => 'MDDS_SD'),
	array( 'db' => '"SDName"','dt' => 17,'db1' => 'SDName'),
	array( 'db' => '"MDDS_VT"','dt' => 18,'db1' => 'MDDS_VT'),
	array( 'db' => '"VTName"','dt' => 19,'db1' => 'VTName'),
	array( 'db' => '"Level"','dt' => 20,'db1' => 'Level'),
	array( 'db' => '"Status"','dt' => 21,'db1' => 'Status'), //<!-- modified by sahana to add status column in Concordance Reports -->
	);


            //    $other_array =array(); 

			$pg_details = $databaseinfo;
            require( 'ssp.class.php' );

            echo json_encode(SSP::simple( $_POST, $pg_details, $table, $primaryKey, $columns,$filtroAdd,$array));

               
                }

else if($_POST['formname']=='getconsd')
{
	$sql = 'select "SDID" AS "id","SDName" as "Name" from sd'.$_SESSION['activeyears'].' where "STID"=$1 AND is_deleted=$2 AND "DTID"=$3';
	$sqlquery = pg_query_params($db,$sql,array($_POST['STID'],1,$_POST['DTID']));
	$data = pg_fetch_all($sqlquery);

	echo json_encode($data);
}                
else if($_POST['formname']=='Partiallysavedata')
{

$task='';	
$update = "update documentdata".$_SESSION['activeyears']." set docstatus=$1 where docids=$2"; 
$qu = pg_query_params($db,$update,array(2,$_POST['docids']));
 $result_rows = pg_affected_rows($qu);
if($result_rows!=0)
{
	$task="update";
}
else
{
$task="error";
}

	echo $task;
	
}

else if($_POST['formname']=='getdistlistyearreport')
{
	
	$data = pg_query_params($db, 'select "DTID","DTName" from "dt'.$_SESSION['activeyears'].'" where "STID"=$1
	 ORDER BY "dt'.$_SESSION['activeyears'].'"."DTID"',array($_POST['STID']));
	$dataresult = pg_fetch_all($data);
	$datacount = pg_num_rows($data); // total count

	echo json_encode($dataresult)."|".$_POST['STID'];
	
}
else if($_POST['formname']=='selectedlistdata')
{
		$task ='';
			
		$comenexttext ='';

						if($_POST['comefrom']=='District')
						{
							$comenexttext ='Sub-District';
						}
						else if($_POST['comefrom']=='Sub-District')
						{
							$comenexttext ='Village(s) / Town';
						}
						else if($_POST['comefrom']=='Village(s) / Town')
						{
							$comenexttext ='Village(s) / Town';
						}
							else if($_POST['comefrom']=='State')
						{
							$comenexttext ='District';
						}
						else
						{
							$comenexttext ='State';
						}

		$array1 = explode(',',$_POST['valueof']); 
		$array2 = explode(',',$_POST['valueoftext']);

		$task1 = '';

		// $task1 .= '<div class="col-md-5"><select id="actiondata" onchange="getactiondata(this.value,'.$_POST['variablename'].')" name="actiondata"><option value="">Action</option><option value="Split">Split</option><option value="Merge">Merge</option></select></div><div class="col-md-5 mt-2" id="actionevent'.$_POST['variablename'].'" ></div>';

		$task .='<select multiple="multiple" id="partiallylevel'.$_POST['variablename'].'" class="multi-select" name="partiallylevel'.$_POST['variablename'].'[]">';
				for($i=0;$i<count($array1);$i++)
				{
					$task .='<option value="'.$array1[$i].'">'.$array2[$i].'</option>';
				}			
				$task .='</select><div class="mt-2">Total Partially Selected '.$comenexttext.'(s) : <span id="totaldefultselectedpar_'.$_POST['variablename'].'">0</span>  - out of :<span >'.$i.' </span></div>'; // total count
		// if($_POST['comefrom']!='State'  && $_POST['comefrom']!='District' )
		// {
		// 	$task .='<div class="mt-2"><input type="checkbox" onclick="handleClickdataof(this,'.$_POST['variablename'].')" name="haveapartially[]" class="haveapartially" > <label for="checkbox2">Any '.$com.' Partially Split ?</label><div id="selectedlistoflist'.$_POST['variablename'].'"></div></div>';
		// }


		// <div id="pardist'.$_POST['variablename'].'" class="mt-2"></div>
		echo $task."|".$_POST['variablename'];
}


else if($_POST['formname']=='selectedlistdatalist')
{
		$task ='';
			// print_r($_POST);
			// exit;
		$com="";
		if($_POST['comefrom']=='State')
		{
			$com="Sub-District";
		}
		else
		{
		$com="Sub-District";
		}

		$array1 = explode(',',$_POST['valueof']); 
		$array2 = explode(',',$_POST['valueoftext']);

		$sql = pg_query_params($db,'select * from sd'.$_SESSION['activeyears'].' where sd'.$_SESSION['activeyears'].'."DTID" = Any(string_to_array($1::text, \',\'::text)::integer[])',array($_POST['valueof']));
		$dataof = pg_fetch_all($sql);


		// print_r($array2); 
		$task .='<select multiple="multiple" id="partiallylevelsd'.$_POST['variablename'].'" class="multi-select" name="partiallylevelsd'.$_POST['variablename'].'[]">';
				for($i=0;$i<count($dataof);$i++)
				{
					$task .='<option value="'.$dataof[$i]['SDID'].'">'.$dataof[$i]['SDName'].'</option>';
				}			
		$task .='</select>';
		echo $task."|".$_POST['variablename'];
}



else if($_POST['formname']=='submergeform')
{

	
						$comenexttext ='';

						if($_POST['comefromchecksub']=='District')
						{
							$comenexttext ='Sub-District';
						}
						else if($_POST['comefromchecksub']=='Sub-District')
						{
							$comenexttext ='Village / Town';
						}
						else if($_POST['comefromchecksub']=='Village / Town')
						{
							$comenexttext ='Ward';
						}
							else if($_POST['comefromchecksub']=='State')
						{
							$comenexttext ='District';
						}
						else
						{
							$comenexttext ='State';
						}


							if($_POST['comefromchecksub']=='State')
							{
								$sql = 'select "Status" from st'.$_SESSION['activeyears'].' where "STID" = Any(string_to_array($1::text, \',\'::text)::integer[])';
								$query = pg_query_params($db,$sql,array(implode(',',$_POST['selected_comesub'])));
								$data = pg_fetch_all($query);
								for($i=0;$i<count($data);$i++) {
    							$array[]=$data[$i]['Status'];
								}

								
								$countofids =0; 

								$data=$_POST;
								$data['stStatus']=$array;
			
								$task = "addsddata";
							}
						else if($_POST['comefromchecksub']=='District')
							{
								$countofids =0; 
								$data=$_POST;
			
								$task = "addsddata";

							}

						else if($_POST['comefromchecksub']=='Sub-District')
							{

												$data['data']=array();
														$task1 = '';
														
														$countofids = 0;
														if($_POST['namefromtextlevel']=='')
														{
															
																				
																				$countofids =0; 
																				$data=$_POST;
															
																				$task = "addsddata";

														}
														else
														{


																		$sttext = explode(',',$_POST['namefromtextlevel']);
																				for($i=0;$i<count($_POST['partiallylevel0']);$i++)
																				{
																				
																				$data11 = pg_query_params($db, 'select "VTID",CONCAT_WS(\' - \',"VTName","MDDS_VT") as "VTName" from "vt'.$_SESSION['activeyears'].'" where "SDID"=$1
																				ORDER BY "vt'.$_SESSION['activeyears'].'"."VTName"',array($_POST['partiallylevel0'][$i]));
																				$dataresult1 = pg_fetch_all($data11);
																				$datacount = pg_num_rows($data11); // total count


																				$task1 .='<div class="col-md-6"><label class="col-md-5 col-form-label" for="userName1">'.$sttext[$i].' updated '.$_SESSION['logindetails']['baseyear'].'</label>  
																				                          <label class="col-md-6 col-form-label" for="userName1">'.$sttext[$i].' Draft Split & Sub Merge '.$_SESSION['activeyears'].'</label> 
																				<select required multiple="multiple" id="addlinksDTID_'.$i.'" class="multi-select" name="addlinksDTID'.$i.'[]">';
																				      foreach($dataresult1 as $key => $element) {
																				      $task1 .='<option value="'.$element['VTID'].'">'.$element['VTName'].'
																				          </option>';
																				          }
																						  $task1 .='</select><div class="mt-2">Total Selected '.$comenexttext.'(s) : <span id="totaldefultselected_'.$i.'">0</span> - out of :<span> '.$datacount.'</span></div></div>'; // total count


																				}
																				
																				

																				
																				$countofids =count($_POST['partiallylevel0']);
																				$data=$_POST;
																				

																				$task = "addsddata";



																			



														}



							}

							else if($_POST['comefromchecksub']=='Village / Town')
							{

												$data['data']=array();
														$task1 = '';
														$sql = 'select trim("Level") as "Lev","Status" from vt'.$_SESSION['activeyears'].' where "VTID" = Any(string_to_array($1::text, \',\'::text)::NUMERIC[]) ORDER BY "VTName" ASC';
								$query = pg_query_params($db,$sql,array(implode(',',$_POST['selected_comesub0']))); // jc_b
								$data1 = pg_fetch_all($query);
								// print_r($data);
														$countofids = 0;
														if($_POST['namefromtextlevel']=='')
														{

															
																		for($i=0;$i<count($data1);$i++) {
																		$array[]=$data1[$i]['Lev'];
																	    if($data1[$i]['Status']=='')
																	    {
																	    	$array1[]='RV';
																	    }
																	    else
																	    {
																	    	 $array1[]=trim($data1[$i]['Status']);
																	    }
   


																				
																				$countofids =0; 

																				$data=$_POST;
																				$data['vtLevel']=$array;
																				$data['vtStatus']=$array1;
															
																				$task = "addsddata";

														}
													}
														else
														{



								for($i=0;$i<count($data1);$i++) {
    $array[]=$data1[$i]['Lev'];
    if($data1[$i]['Status']=='')
    {
    	$array1[]='RV';
    }
    else
    {
    	 $array1[]=trim($data1[$i]['Status']);
    }


																				$countofids =count($_POST['partiallylevel0']);
																				$data=$_POST;
																				$data['vtLevel']=$array;
																				$data['vtStatus']=$array1;
																				

																				$task = "addsddata";



																			



														}



							}

						
						}



	echo $task."|".json_encode($data)."|".$_POST['comefromchecksub']."|".$task1."|".$countofids;
	
}


else if($_POST['formname']=='assignformdata')
{

						$comenexttext ='';

						if($_POST['comefromcheck']=='District')
						{
							$comenexttext ='Sub-District';
						}
						else if($_POST['comefromcheck']=='Sub-District')
						{
							$comenexttext ='Village(s) / Town';
						}
						else if($_POST['comefromcheck']=='Village(s) / Town')
						{
							$comenexttext ='Ward';
						}
							else if($_POST['comefromcheck']=='State')
						{
							$comenexttext ='District';
						}
						else
						{
							$comenexttext ='State';
						}

							$tempflag='false';

							if($_POST['comefromcheck']=='State')
							{

								
										if($_POST['clickpopup']=='Create')
										{
													// $statename = '';
												           $sttext = explode(',',$_POST['namefromtext']);
													// $a = array_map( 'trim',$_POST['newname']);
													// $im = array_map( 'strtolower',$a);
													// if(count(array_dup($im))>0)
													// {
													// 	$statename = "duplicatenameexist";
													// }
													// else
													// {
														
													// 	$imp = "'" . implode( "','", $im) . "'";

													// 	 $query = 'select * from st'.$_SESSION['activeyears'].' where lower("STName") = Any(string_to_array($1::text, \',\'::text)::text[]);';
														
													// 	$querydata = pg_query_params($db,$query,array($imp));

													// 	$querydatarow = pg_numrows($querydata);
													// 	if($querydatarow>0)
													// 	{
													// 	$statename = "alreadyexists";	
													// 	}
													// 	else
													// 	{
													// 	$statename = "addstate";
													// 	}
													// }

												
													//modified by gowthami state level name validation JC_05
											// 		$flag = false;
											//    $newnamecheck = $_POST['namefromtext'];
											//    $newnamecheckArray = explode(',', $newnamecheck);
											//    $nametotextArray = $_POST['newname'];
											//    $nametotext = implode(',', $nametotextArray);
											   

											//    foreach ($newnamecheckArray  as $index => $gs) {
											// 	   if (($gs) == $nametotext)
											// 	   {
											// 		   $statename = "alreadyexists";
											// 		   $flag = true;
											// 		   break;
											// 	   }
											//    }
											   
											//    if ($flag == true) {
											// 	   $statename = "alreadyexists";
											//    } else {

												   $statename = "addstate";
												   
											  // }
						
												$data['data']=array();

												if($statename == 'addstate')
												{


															
															
															$stateconcate = '';
															$task1 = '';
															$task2 = '';
															$countofids = 0;
															$_POST['flag'] = '';
															if(count($_POST['newname'])>=count($_POST['namefrom']))
															{
																
																
																					$_POST['flag'] = 'newname';
																					// code changed by bheema for state level ASC the districts name
																					$data11 = pg_query_params($db, 'SELECT "DTID", "DTName" FROM "dt'.$_SESSION['activeyears'].'"
																					WHERE "STID" = $1 AND "is_deleted" = $2
																					ORDER BY "DTName" ASC',
																				array($_POST['namefrom'][0], 1));

																					$dataresult1 = pg_fetch_all($data11);
																					$datacount =pg_num_rows($data11); // total count

																					// $idsof = $idsquerydata[0];
																					for($i=0;$i<count($_POST['newname']);$i++)
																					{
																						$_POST['newname'][$i]=($_POST['newname'][$i]);
																					// $idsof = $idsof + 1;

																					// $stateconcate .="(".$idsof.",'".ucwords(strtolower($_POST['newname'][$i]))."','".$_POST['StateStatus'][$i]."'),";




																					$task1 .='<div class="col-md-6"><label class="col-md-5 col-form-label" for="userName1">'.$comenexttext.' of '.$sttext[0].' '.$_SESSION['logindetails']['baseyear'].' - '.$_SESSION['activeyears'].'</label>  
																					      <label class="col-md-6 col-form-label" for="userName1">'.$comenexttext.' of '.$_POST['newname'][$i].' '.$_SESSION['activeyears'].'</label> 
																					<select multiple="multiple" id="addlinksDTID_'.$i.'" class="multi-select" name="addlinksDTID'.$i.'[]">';
																					foreach($dataresult1 as $key => $element) {
																					$task1 .='<option value="'.$element['DTID'].'">'.$element['DTName'].'
																					</option>';
																					}

																					$task1 .='</select><div class="mt-2">Total Selected '.$comenexttext.'(s) : <span id="totaldefultselected_'.$i.'">0</span> - out of :<span> '.$datacount.'</span></div><div class="mt-2"><input type="checkbox" onclick="handleClick(this,'.$i.');" name="haveapartially'.$i.'[]" id="'.$i.'" class="haveapartially" > <label for="checkbox2">Any '.$comenexttext.' Partially '.$_POST['action'][0].' from '.$sttext[0].' </label></div><div id="selectedaction'.$i.'" class="row mb-2"></div><div id="selectedlist'.$i.'"></div></div>'; //total count


																					}
																					// $stateconcatefinal = rtrim($stateconcate, ',');


																					// $state ='insert into st'.$_SESSION['activeyears'].' ("STID","STName","Status") values '.$stateconcatefinal.' returning "STID"';
																					// $result = pg_query($state);
																					// if($result)
																					// {
																					// $fch = pg_fetch_all($result);
																					$countofids =count($_POST['newname']); 
																					$data=$_POST;
																					//$data['inserstate']=$fch;
																					$task = "adddata";
																					// }
																					// else
																					// {
																					// $task = "error";
																					// } 

															}
															else
															{


																					$_POST['flag'] = 'namefrom';

																					//	$idsof = $idsquerydata[0];
																					for($i=0;$i<count($_POST['namefrom']);$i++)
																					{
																						
																					$data11 = pg_query_params($db, 'select "DTID","DTName" from "dt'.$_SESSION['activeyears'].'" where "STID"=$1 AND "is_deleted"=$2
																					ORDER BY "dt'.$_SESSION['activeyears'].'"."DTName"',array($_POST['namefrom'][$i],1));
																					$dataresult1 = pg_fetch_all($data11);
																					$datacount = pg_num_rows($data11); //total count


																					$task1 .='<div class="col-md-6"><label class="col-md-5 col-form-label" for="userName1">'.$comenexttext.' of '.$sttext[$i].' '.$_SESSION['logindetails']['baseyear'].' - '.$_SESSION['activeyears'].'</label>  
																					                          <label class="col-md-6 col-form-label" for="userName1">'.$comenexttext.' of '.$_POST['newname'][0].' '.$_SESSION['activeyears'].'</label> 
																					<select multiple="multiple" id="addlinksDTID_'.$i.'" class="multi-select" name="addlinksDTID'.$i.'[]">';
																					      foreach($dataresult1 as $key => $element) {
																					      $task1 .='<option value="'.$element['DTID'].'">'.$element['DTName'].'
																					          </option>';
																					          }
																							  $task1 .='</select><div class="mt-2">Total Selected '.$comenexttext.'(s) : <span id="totaldefultselected_'.$i.'">0</span> - out of :<span> '.$datacount.'</span></div><div class="mt-2"><input type="checkbox" name="haveapartially'.$i.'[]" class="haveapartially" id="'.$i.'" onclick="handleClick(this,'.$i.');"> <label for="checkbox2">Any '.$comenexttext.' Partially '.$_POST['action'][$i].' from '.$sttext[$i].' </label></div><div id="selectedlist'.$i.'"></div></div>'; // total count


																					}
																					// $idsof = $idsof + 1;

																					// $stateconcate .="(".$idsof.",'".ucwords(strtolower($_POST['newname'][0]))."','".$_POST['StateStatus'][0]."')";


																					// $state ='insert into st'.$_SESSION['activeyears'].' ("STID","STName","Status") values '.$stateconcate.' returning "STID"';
																					// $result = pg_query($state);
																					// if($result)
																					// {
																				 //	$fch = pg_fetch_all($result);
																					$countofids =count($_POST['namefrom']);
																					$_POST['newname'][0]=$_POST['newname'][0];
																					$data=$_POST;
																				 	// $data['inserstate']=$fch;
																					$task = "adddata";
																					// }
																					// else
																					// {
																					// $task = "error";
																					// } 



															}

												}
												else
												{
												$task = $statename;
												}
										}
										else if($_POST['clickpopup']=='Rename')
										{

											
											$_POST['applyon']=$_POST['comefromcheck'];

													
															

													$statename = '';
													$a = array_map( 'trim',$_POST['newnamecheck']);
													
													$im = array_map( 'strtolower',$a);
													
													$da = str_contains($_POST['oremovenewarray'],'1');
													
											// rename validation for state name code modified by srikanth//
											// $statename = '';
											// $a = array_map('trim', $_POST['newnamecheck']);
											// $im = array_map('strtolower', $a);


											// if (count(array_unique($im)) < count($im)) {
											// 	$statename = "duplicatenameexist"; // Duplicate Name Exists
											// } else {
											// 	$imp = "'" . implode( "','", $im) . "'";
												
												
											// 	$query = 'SELECT * FROM st' . $_SESSION['activeyears'] . ' WHERE lower("STName") IN (' . $imp . ')';
											// 	$querydata = pg_query($db, $query);

											// 	$querydatarow = pg_numrows($querydata);

											// 	if ($querydatarow > 0) {
											// 		$statename = "alreadyexists"; 
											// 	} else {
											// 		$statename = "addstate"; 
											// 	}
											// }
                                                   // ends here
												// modified by Gowthami rename state level												  
											$flag = false;
											$newnamecheck = $_POST['newnamecheck'];
											$nametotext = $_POST['nametotext'];
											$pattern = '/[^A-Za-z]/';  
											$nametotextArray = explode(',', $nametotext);
											if (count($newnamecheck) !== count($nametotextArray)) {
												$statename = "mismatched";
											} else {
												foreach (array_map(null, $newnamecheck, $nametotextArray) as $pair) {
													list($gs, $textElement) = $pair;
													if (preg_match('/\d/', $gs)) {
														continue;
													}
													$gsWos = preg_replace($pattern, '', $gs);
													$gsWos1 = preg_replace($pattern, '', $textElement);

													if (strtolower($gsWos) == strtolower($gsWos1)) {  
														$statename = "alreadyexists";
														$flag = true;
														break;
													}
												}

												if (!$flag) {
													$statename = "addstate";
												}
											}
											// ends here

											
														$data['data']=array();

														if($statename == 'addstate')
												{

														$task1 = '';
														$task2 = '';
														$countofids = 0;
																				$countofids =count($_POST['newnamem']); 
																				$data=$_POST;
														
																				$task = "adddata";

												}
												else
												{
												$task = $statename;
												}

										}
										else
										{
                                   //modified by gowthami state level  name validation
											if(($_POST['clickpopup']=='Merge') || ($_POST['clickpopup']=='Partiallysm')){
                                                $flag = false;
                                                $newnamecheck = $_POST['newnamecheck'];
                                                $nametotext = $_POST['nametotext'];
                                                foreach ($newnamecheck as $index => $gs) {
                                                    // if ($gs == $nametotext) {
                                                        if (strtolower($gs) == strtolower($nametotext)){
                                                        $task = "alreadyexists";
                                                        $flag = true;
                                                        break;
                                                    }
                                                }
                                                if ($flag == true) {
                                                    $task = "alreadyexists";
                                                } else {
                                                    $task = "adddata";
                                                }
                                            }
                                           

											$sttext = explode(',',$_POST['namefromtext']);
											$data = array();
											
											if($_POST['oremovenewarray']==1)
											{

												//  $query = 'select * from st'.$_SESSION['activeyears'].' where lower("STName") = Any(string_to_array($1::text, \',\'::text)::text[])';
												
												// $querydata = pg_query_params($db,$query,array($_POST['newnamecheck'][0]));

												// $querydatarow = pg_numrows($querydata);


												// if($querydatarow>0)
												// {
												// $task = "alreadyexists";	
												// }
												// else
												// {
												// $task = "adddata";
												// }

												$flus =false; 
												if($_POST['clickpopup']=='Partiallysm')
														{
															$str = 'Partially Split & Merge';
														}
														else
														{
															$str = 'Partially Merge';

														}
												if (in_array($str, $_POST['action']))
												{
												$flus = true;
												}
												$swami = 0;
												if($flus==true)
												{


														for($i=0;$i<count($_POST['namefrom']);$i++)
														{
															
														if($_POST['action'][$i]=='Partially Merge')
														{
														$swami = $swami+1;

														$data11 = pg_query_params($db, 'select "DTID","DTName" from "dt'.$_SESSION['activeyears'].'" where "STID"=$1 AND "is_deleted"=$2
														ORDER BY "dt'.$_SESSION['activeyears'].'"."DTName"',array($_POST['namefrom'][$i],1));
														$dataresult1 = pg_fetch_all($data11);
														$datacount = pg_num_rows($data11); // total count


														$task1 .='<div class="col-md-6"><label class="col-md-5 col-form-label" for="userName1">'.$comenexttext.' of '.$sttext[$i].' '.$_SESSION['logindetails']['baseyear'].' - '.$_SESSION['activeyears'].'</label>  
														<label class="col-md-6 col-form-label" for="userName1">'.$comenexttext.' of ';

														if(isset($_POST['newnamecheck']) && $_POST['newnamecheck'][0]!='' ){ 
													      $task1 .=''.$_POST['newnamecheck'][0].'';
												         }
														else
															{
																
															$task1 .=''.$_POST['nametotext'].'';
															}  
															
														$task1 .=' '.$_SESSION['activeyears'].'</label> 
														<select multiple="multiple" id="addlinksDTID_'.$i.'" class="multi-select" name="addlinksDTID'.$i.'[]">';
														foreach($dataresult1 as $key => $element) {
														$task1 .='<option value="'.$element['DTID'].'">'.$element['DTName'].'
														</option>';
														}
														$task1 .='</select><div class="mt-2">Total Selected '.$comenexttext.'(s) : <span id="totaldefultselected_'.$i.'">0</span> - out of : <span>'.$datacount.' </span> </div><div class="mt-2"><input type="checkbox" name="haveapartially'.$i.'[]" class="haveapartially" id="'.$i.'" onclick="handleClick(this,'.$i.');"> <label for="checkbox2">Any '.$comenexttext.'  '.$_POST['action'][$i].' from '.$sttext[$i].' </label></div><div id="selectedlist'.$i.'"></div></div>';  // total count // partially repeated twice

														}



														}


												}
														$countofids =$swami;			
														$data=$_POST;
											}
											else
											{



											$task = "adddata";
											$flus =false; 
											if($_POST['clickpopup']=='Partiallysm')
													{
														$str = 'Partially Split & Merge';
													}
													else
													{
														$str = 'Partially Merge';

													}
											if (in_array($str, $_POST['action']))
											{
											$flus = true;
											}
											$swami = 0;
											if($flus==true)
											{


											for($i=0;$i<count($_POST['namefrom']);$i++)
											{
											if($_POST['action'][$i]=='Partially Merge')
											{
											$swami = $swami+1;

											$data11 = pg_query_params($db, 'select "DTID","DTName" from "dt'.$_SESSION['activeyears'].'" where "STID"=$1 AND "is_deleted"=$2
											ORDER BY "dt'.$_SESSION['activeyears'].'"."DTName"',array($_POST['namefrom'][$i],1));
											$dataresult1 = pg_fetch_all($data11);
											$datacount = pg_num_rows($data11); // total count


											$task1 .='<div class="col-md-6"><label class="col-md-5 col-form-label" for="userName1">'.$comenexttext.' of '.$sttext[$i].' '.$_SESSION['logindetails']['baseyear'].' - '.$_SESSION['activeyears'].'</label>  
											<label class="col-md-6 col-form-label" for="userName1">'.$comenexttext.' of ';
											if(isset($_POST['newnamecheck'])  && $_POST['newnamecheck'][0]!=''){ 
													$task1 .=''.$_POST['newnamecheck'][0].'';
												}
												else
													{
														$task1 .=''.$_POST['nametotext'].'';
														} 
														$task1 .=' '.$_SESSION['activeyears'].'</label> 
											<select multiple="multiple" id="addlinksDTID_'.$i.'" class="multi-select" name="addlinksDTID'.$i.'[]">';
											foreach($dataresult1 as $key => $element) {
											$task1 .='<option value="'.$element['DTID'].'">'.$element['DTName'].'
											</option>';
											}
											$task1 .='</select><div class="mt-2">Total Selected
											 '.$comenexttext.'(s) : <span id="totaldefultselected_'.$i.'">0</span> - out of :<span> '.$datacount.'</span></div><div class="mt-2"><input type="checkbox" name="haveapartially'.$i.'[]" class="haveapartially" id="'.$i.'" onclick="handleClick(this,'.$i.');"> <label for="checkbox2">Any '.$comenexttext.'  '.$_POST['action'][$i].' from '.$sttext[$i].' </label></div><div id="selectedlist'.$i.'"></div></div>'; // total count // partially repeated twice

											}



											}


											}
											$countofids =$swami;			
											$data=$_POST;
											}

										}
								
													

							}
							else if($_POST['comefromcheck']=='District')
							{
									
										if($_POST['clickpopup']=='Create')
										{

												$statename = '';
												$sttext = explode(',',$_POST['namefromtext']);
												$a = array_map( 'trim',$_POST['newname']);
												//$im = array_map( 'strtolower',$a);

												//Duplicate district name validation veena
												// if(count(array_dup($im))>0)
												// {
												// 	$statename = "duplicatenameexist";
												// 	// Duplicate Name Exists
												// }
												// else
												// {

												// 	if($_POST['didsup']!='')
												// 	{
												// 			$stids = $_POST['didsup'];
												// 	}
												// 	else
												// 	{
												// 			$stids = "".implode( ",", $_POST['statenew'])."";	
												// 	}
												// 		$imp = "'" . implode( "','", $im) . "'";
														
												// 	$query = "select * from dt".$_SESSION['activeyears']." where \"STID\" IN ($stids) AND lower(\"DTName\") IN ($imp)";
												// 	$querydata = pg_query($db,$query);

												// 	$querydatarow = pg_numrows($querydata);

												// 	if($querydatarow>0)
												// 	{
												// 	$statename = "alreadyexists";	
												// 	}
												// 	else
												// 	{
												//  	$statename = "adddistrict";
												// 	}
												// } 	// ends here
                                                // $statename = "adddistrict";
													
												 //modified by gowthami District level  name validation JC_05

												//  $flag = false;
												//  $newnamecheck = $_POST['namefromtext'];
												//  $newnamecheckArray = explode(',', $newnamecheck);
												//  $nametotextArray = $_POST['newname'];
												//  $nametotext = implode(',', $nametotextArray);
												 
 
												//  foreach ($newnamecheckArray  as $index => $gs) {
												// 	 if (($gs) == ($nametotext)) {
												// 		 $statename = "alreadyexists";
												// 		 $flag = true;
												// 		 break;
												// 	 }
												//  }
												 
												//  if ($flag == true) {
												// 	 $statename = "alreadyexists";
												//  } else {
 
													 $statename = "adddistrict";
													 
												// }
												 
											
												
												$data['data']=array();

												if($statename == 'adddistrict')
												{
														// print_r($_POST);
														// exit;

														
														$stateconcate = '';
														$task1 = '';
														$task2 = '';
														$countofids = 0;
														$_POST['flag'] = '';
														if(count($_POST['newname'])>=count($_POST['namefrom']))
														{
															// echo "INNNNN";
															// exit;


																				$_POST['flag'] = 'newname';
  //Code changed by Bheema for ascending the districts 
  $data11 = pg_query_params(
	$db,
	'SELECT "SDID", "SDName"
	 FROM "sd'.$_SESSION['activeyears'].'"
	 WHERE "DTID" = $1 AND "is_deleted" = $2
	 ORDER BY "SDName" ASC',
	array($_POST['namefrom'][0], 1)
);

	$dataresult1 = pg_fetch_all($data11);
	$datacount =pg_num_rows($data11); // total count

																				
																				for($i=0;$i<count($_POST['newname']);$i++)
																				{

																				// 	$sql = 'SELECT dt'.$_SESSION['activeyears'].'."DTID" FROM dt'.$_SESSION['activeyears'].' where "STID"='.$_POST['statenew'][$i].' AND "MDDS_DT" is null ORDER BY dt'.$_SESSION['activeyears'].'."DTID" DESC FETCH FIRST ROW ONLY';

																				// 	$idsquery = pg_query($db,$sql);

																				// 	if(pg_numrows($idsquery)>0)
																				// 	{

																				// 	$idsquerydata = pg_fetch_row($idsquery);


																				// 	$idsof = $idsquerydata[0];		

																				// 	}
																				// 	else
																				// 	{

																				// 	$sql1 = 'SELECT dt'.$_SESSION['activeyears'].'."DTID" FROM dt'.$_SESSION['activeyears'].' where "STID"='.$_POST['statenew'][$i].' ORDER BY dt'.$_SESSION['activeyears'].'."DTID" DESC FETCH FIRST ROW ONLY';
																				// 	$idsquery1 = pg_query($db,$sql1);


																				// 	if(pg_numrows($idsquery1)>0)
																				// 	{
																				// 	$idsquerydata1 = pg_fetch_row($idsquery1);


																				// 	$idsof = $idsquerydata1[0];		
																				// 	}
																				// 	else
																				// 	{
																				// 	$idsof = $_POST['statenew'][$i]."".'000';	
																				// 	}


																				// 	}





																				// $idsof = $idsof + 1;

																				// $stateconcate .="(".$_POST['statenew'][$i].",".$idsof.",'".ucwords(strtolower($_POST['newname'][$i]))."'),";




																				$task1 .='<div class="col-md-6"><label class="col-md-5 col-form-label" for="userName1">'.$comenexttext.' of '.htmlspecialchars($sttext[0]).' '.$_SESSION['logindetails']['baseyear'].' - '.$_SESSION['activeyears'].'</label>  
																				      <label class="col-md-6 col-form-label" for="userName1">'.$comenexttext.' of '.$_POST['newname'][$i].' '.$_SESSION['activeyears'].'</label> 
																				<select multiple="multiple" id="addlinksDTID_'.$i.'" class="multi-select" name="addlinksDTID'.$i.'[]">';
																				foreach($dataresult1 as $key => $element) {
																				$task1 .='<option value="'.$element['SDID'].'">'.$element['SDName'].'
																				</option>';
																				}
																				$task1 .='</select><div class="mt-2">Total Selected '.$comenexttext.'(s) : <span id="totaldefultselected_'.$i.'">0</span> - out of :<span> '.$datacount.'</span></div>'; // total count
																				if($_POST['didsup']=='')
																				{
																				$task1 .='<div class="mt-2"><input type="checkbox" onclick="handleClick(this,'.$i.');" name="haveapartially'.$i.'[]" class="haveapartially" id="'.$i.'"> <label for="checkbox2">Any '.$comenexttext.' Partially '.$_POST['action'][0].' from '.$sttext[0].' </label></div><div id="selectedlist'.$i.'"></div>';  
																					}
																				$task1 .='</div>';


																				}
										

																				//$stateconcatefinal = rtrim($stateconcate, ',');


																			 //  $state ='insert into dt'.$_SESSION['activeyears'].' ("STID","DTID","DTName") values '.$stateconcatefinal.' returning "DTID"';

																			 
																				// $result = pg_query($state);
																				// if($result)
																				// {
																				// $fch = pg_fetch_all($result);
																				$countofids =count($_POST['newname']); 
																				$data=$_POST;
																				// $data['inserstate']=$fch;

																				$task = "adddata";



																				// }
																				// else
																				// {
																				// $task = "error";
																				// } 

														}
														else
														{
															


																				$_POST['flag'] = 'namefrom';




																					// $idsof = $idsquerydata[0];
																				for($i=0;$i<count($_POST['namefrom']);$i++)
																				{

																				// $idsof = $idsof + 1;
																				$data11 = pg_query_params($db, 'select "SDID","SDName" from "sd'.$_SESSION['activeyears'].'" where "STID"='.$_POST['fromstate'][$i].' AND "DTID"=$1 AND "is_deleted"=$2
																				ORDER BY "sd'.$_SESSION['activeyears'].'"."SDName"',array($_POST['namefrom'][$i],1));
																				$dataresult1 = pg_fetch_all($data11);
																				$datacount =pg_num_rows($data11); // total count



																				$task1 .='<div class="col-md-6"><label class="col-md-5 col-form-label" for="userName1">'.$comenexttext.' of '.htmlspecialchars($sttext[$i]).' '.$_SESSION['logindetails']['baseyear'].' - '.$_SESSION['activeyears'].'</label>  
																				                          <label class="col-md-6 col-form-label" for="userName1">'.$comenexttext.' of '.$_POST['newname'][0].'  '.$_SESSION['activeyears'].'</label> 
																				<select multiple="multiple" id="addlinksDTID_'.$i.'" class="multi-select" name="addlinksDTID'.$i.'[]">';
																				      foreach($dataresult1 as $key => $element) {
																				      $task1 .='<option value="'.$element['SDID'].'">'.$element['SDName'].'
																				          </option>';
																				          }
																						  $task1 .='</select><div class="mt-2">Total Selected '.$comenexttext.'(s) : <span id="totaldefultselected_'.$i.'">0</span> - out of : <span> '.$datacount.'</span></div><div class="mt-2"><input type="checkbox" name="haveapartially'.$i.'[]" class="haveapartially" id="'.$i.'" onclick="handleClick(this,'.$i.');"> <label for="checkbox2">Any '.$comenexttext.' Partially '.$_POST['action'][$i].' from '.$sttext[$i].' </label></div><div id="selectedlist'.$i.'"></div></div>'; // total count

																				}
																				// 	$sql = 'SELECT dt'.$_SESSION['activeyears'].'."DTID" FROM dt'.$_SESSION['activeyears'].' where "STID"='.$_POST['statenew'][0].' AND "MDDS_DT" is null ORDER BY dt'.$_SESSION['activeyears'].'."DTID" DESC FETCH FIRST ROW ONLY';

																				// 	$idsquery = pg_query($db,$sql);

																				// 	if(pg_numrows($idsquery)>0)
																				// 	{

																				// 	$idsquerydata = pg_fetch_row($idsquery);


																				// 	$idsof = $idsquerydata[0];		

																				// 	}
																				// 	else
																				// 	{

																				// 	$sql1 = 'SELECT dt'.$_SESSION['activeyears'].'."DTID" FROM dt'.$_SESSION['activeyears'].' where "STID"='.$_POST['statenew'][0].' ORDER BY dt'.$_SESSION['activeyears'].'."DTID" DESC FETCH FIRST ROW ONLY';
																				// 	$idsquery1 = pg_query($db,$sql1);


																				// 	if(pg_numrows($idsquery1)>0)
																				// 	{
																				// 	$idsquerydata1 = pg_fetch_row($idsquery1);


																				// 	$idsof = $idsquerydata1[0];		
																				// 	}
																				// 	else
																				// 	{
																				// 	$idsof = $_POST['statenew'][$i]."".'000';	
																				// 	}


																				// 	}
																				// $idsof = $idsof + 1;

																				// $stateconcate .="(".$stids.",".$idsof.",'".ucwords(strtolower($_POST['newname'][0]))."')";
																			

																				//   $state ='insert into dt'.$_SESSION['activeyears'].' ("STID","DTID","DTName") values '.$stateconcate.' returning "DTID"';
																			
																				// $result = pg_query($state);
																				
																			 $countofids =count($_POST['namefrom']);
																			 $data=$_POST;
																				
																				$task = "adddata";




														}

												}
												else
												{
												$task = $statename;
												}

											}
											else if($_POST['clickpopup']=='Rename')
										{

											
											$_POST['applyon']=$_POST['comefromcheck'];

													
															

													$statename = '';
													$a = array_map( 'trim',$_POST['newnamecheck']);
													//$im = array_map( 'strtolower', $a );
													// rename validation for district name code modified by srikanth//
													// $statename = '';
													// $districtNames = array_map('trim', $_POST['newnamecheck']);
													// $districtNames = array_map('strtolower', $districtNames);
													// $stateIds = $_POST['statenew'];

													// foreach ($districtNames as $key => $districtName) {
													
													// 	$query = "SELECT * FROM dt" . $_SESSION['activeyears'] . " WHERE \"STID\" = {$stateIds[$key]} AND lower(\"DTName\") = '{$districtName}'";
													// 	$querydata = pg_query($db, $query);

													// 	$querydatarow = pg_numrows($querydata);

													// 	if ($querydatarow > 0) {
													// 		$statename = "alreadyexists"; 
													// 		break; 
													// 	}
													// }

													// if ($statename != "alreadyexists") {
													// 	$statename = "adddistrict"; 
													// }


											// ends here//

											//Rename validation modified by Gowthami District level
											
											$flag = false;
											$newnamecheck = $_POST['newnamecheck'];
											$nametotext = $_POST['nametotext'];
											$pattern = '/[^A-Za-z]/';  
											$nametotextArray = explode(',', $nametotext);
											if (count($newnamecheck) !== count($nametotextArray)) {
												$statename = "mismatched";
											} else {
												foreach (array_map(null, $newnamecheck, $nametotextArray) as $pair) {
													list($gs, $textElement) = $pair;
													if (preg_match('/\d/', $gs)) {
														continue;
													}
													$gsWos = preg_replace($pattern, '', $gs);
													$gsWos1 = preg_replace($pattern, '', $textElement);

													if (strtolower($gsWos) == strtolower($gsWos1)) {  
														$statename = "alreadyexists";
														$flag = true;
														break;
													}
												}

												if (!$flag) {
													$statename = "adddistrict";
												}
											}

											//ends here
											
														$data['data']=array();

														if($statename == 'adddistrict')
												{

														$task1 = '';
														$task2 = '';
														$countofids = 0;
																				$countofids =count($_POST['newnamem']); 
																				$data=$_POST;
														
																				$task = "adddata";

												}
												else
												{
												$task = $statename;
												}

										}
											else
										{
											
											$sttext = explode(',',$_POST['namefromtext']);
											$data = array();
											
											if($_POST['oremovenewarray']==1)
											{

											// $query = "select * from dt".$_SESSION['activeyears']." where \"STID\"=".$_POST['statenew'][0]." AND lower(\"DTName\") IN ('".strtolower($_POST['newnamecheck'][0])."')";
											// $querydata = pg_query($db,$query);

											// $querydatarow = pg_numrows($querydata);


											// 	if($querydatarow>0)
											// 	{
											// 	$task = "alreadyexists";	
											// 	}
											// 	else
											// 	{
												// $task = "adddata";
											//	}
                                          // modified by gowthami new name validation district level
											if(($_POST['clickpopup']=='Merge') || ($_POST['clickpopup']=='Partiallysm')){	
													
												$flag = false;
												$newnamecheck = $_POST['newnamecheck'];
												$nametotext = $_POST['nametotext'];

												foreach ($newnamecheck as $index => $gs) {
													// if ($gs == $nametotext) {
														if  (strtolower($gs) == strtolower($nametotext)) {
														$task = "alreadyexists";
														$flag = true;
														break;
													}
												}
												
												if ($flag == true) {
													$task = "alreadyexists";
												} else {
													$task = "adddata";
												}
											}

												if($_POST['clickpopup']=='Partiallysm')
													{
														$str = 'Partially Split & Merge';
													}
													else
													{
														$str = 'Partially Merge';

													}


												$flus =false; 
												if (in_array($str, $_POST['action']))
												{
												$flus = true;
												}
												$swami = 0;
											if($flus==true)
											{


													for($i=0;$i<count($_POST['namefrom']);$i++)
													{
													if($_POST['action'][$i]==$str)
													{
													$swami = $swami+1;

													$data11 = pg_query_params($db, 'select "SDID","SDName" from "sd'.$_SESSION['activeyears'].'" where "STID"=$1 AND "DTID"=$2 AND "is_deleted"=$3
													ORDER BY "sd'.$_SESSION['activeyears'].'"."SDName"',array($_POST['fromstate'][$i],$_POST['namefrom'][$i],1));
													$dataresult1 = pg_fetch_all($data11);
													$datacount =pg_num_rows($data11); // total count


													$task1 .='<div class="col-md-6"><label class="col-md-5 col-form-label" for="userName1">'.$comenexttext.' of '.htmlspecialchars($sttext[$i]).' '.$_SESSION['logindetails']['baseyear'].' - '.$_SESSION['activeyears'].'</label>  
													<label class="col-md-6 col-form-label" for="userName1">'.$comenexttext.' of ';

														if(isset($_POST['newnamecheck']) && $_POST['newnamecheck'][0]!=''){ 
													$task1 .=''.$_POST['newnamecheck'][0].'';
												}
												else
													{
														$task1 .=''.$_POST['nametotext'].'';
														}  
														$task1 .=' '.$_SESSION['activeyears'].'</label> 
													<select multiple="multiple" id="addlinksDTID_'.$i.'" class="multi-select" name="addlinksDTID'.$i.'[]">';
													foreach($dataresult1 as $key => $element) {
													$task1 .='<option value="'.$element['SDID'].'">'.$element['SDName'].'
													</option>';
													}
													$task1 .='</select><div class="mt-2">Total Selected '.$comenexttext.'(s) : <span id="totaldefultselected_'.$i.'">0</span> - out of :<span> '.$datacount.'</span></div><div class="mt-2"><input type="checkbox" name="haveapartially'.$i.'[]" class="haveapartially" id="'.$i.'" onclick="handleClick(this,'.$i.');"> <label for="checkbox2">Any '.$comenexttext.'  '.$_POST['action'][$i].' from '.$sttext[$i].' </label></div><div id="selectedlist'.$i.'"></div></div>'; // total count  // removed partially repeated twice

													}



													}


											}
												$countofids =$swami;			
												$data=$_POST;
											}
											else
											{
										

													$task = "adddata";
													$str='';
													if($_POST['clickpopup']=='Partiallysm')
													{
														$str = 'Partially Split & Merge';
													}
													else
													{
														$str = 'Partially Merge';

													}

													$flus =false; 
													if (in_array($str, $_POST['action']))
													{
													$flus = true;
													}
													$swami = 0;
											if($flus==true)
											{


													for($i=0;$i<count($_POST['namefrom']);$i++)
													{
														if($_POST['action'][$i]==$str)
														{
														$swami = $swami+1;

														$data11 = pg_query_params($db, 'select "SDID","SDName" from "sd'.$_SESSION['activeyears'].'" where "STID"=$1 AND "DTID"=$2 AND "is_deleted"=$3
														ORDER BY "sd'.$_SESSION['activeyears'].'"."SDName"',array($_POST['fromstate'][$i],$_POST['namefrom'][$i],1));
														$dataresult1 = pg_fetch_all($data11);
														$datacount =pg_num_rows($data11); // total count


														$task1 .='<div class="col-md-6"><label class="col-md-5 col-form-label" for="userName1">'.$comenexttext.' of '.htmlspecialchars($sttext[$i]).' '.$_SESSION['logindetails']['baseyear'].' - '.$_SESSION['activeyears'].'</label>  
														<label class="col-md-6 col-form-label" for="userName1">'.$comenexttext.' of ';

														if(isset($_POST['newnamecheck']) && $_POST['newnamecheck'][0]!=''){ 
													$task1 .=''.$_POST['newnamecheck'][0].'';
												}
												else
													{
														$task1 .=''.$_POST['nametotext'].'';
														}  
														$task1 .=' '.$_SESSION['activeyears'].'</label> 
														<select multiple="multiple" id="addlinksDTID_'.$i.'" class="multi-select" name="addlinksDTID'.$i.'[]">';
														foreach($dataresult1 as $key => $element) {
														$task1 .='<option value="'.$element['SDID'].'">'.$element['SDName'].'
														</option>';
														}
														$task1 .='</select><div class="mt-2">Total Selected '.$comenexttext.'(s) : <span id="totaldefultselected_'.$i.'">0</span> - out of : <span> '.$datacount.' </span></div><div class="mt-2"><input type="checkbox" name="haveapartially'.$i.'[]" class="haveapartially" id="'.$i.'" onclick="handleClick(this,'.$i.');"> <label for="checkbox2">Any '.$comenexttext.'  '.$_POST['action'][$i].' from '.$sttext[$i].' </label></div><div id="selectedlist'.$i.'"></div></div>';  // total count // removed partially repeated twice

														}



													}


											}
												$countofids =$swami;	
												$data=$_POST;
											}

										}

							}

						else if($_POST['comefromcheck']=='Sub-District')
							{
									
										if($_POST['clickpopup']=='Create')
										{
										

												$statename = '';
												$sttext = explode(',',$_POST['namefromtext']);
												$a = array_map( 'trim',$_POST['newname']);
												//$im = array_map( 'strtolower', $a );
												// if(count(array_dup($im))>0)
												// {
												// 	$statename = "duplicatenameexist";
												// 	// Duplicate Name Exists
												// }
												// else
												// {

																								 //modified by gowthami subdistrict  level  name validation JC_05
																								//  $flag = false;
																								//  $newnamecheck = $_POST['namefromtext'];
																								//  //$nametotext = $_POST['newname'];
																								//  $newnamecheckArray = explode(',', $newnamecheck);
																								//  $nametotextArray = $_POST['newname'];
																								//  $nametotext = implode(',', $nametotextArray);
																								 
												 
																								//  foreach ($newnamecheckArray  as $index => $gs) {
																								// 	 if($gs == $nametotext){
																								// 		 $statename = "alreadyexists";
																								// 		 $flag = true;
																								// 		 break;
																								// 	 }
																								//  }
																								 
																								//  if ($flag == true) {
																								// 	 $statename = "alreadyexists";
																								//  } else 
																								//  {

													if($_POST['didsup']!='')
													{
															$stids = $_POST['dids'];
															$dtids = $_POST['didsup'];
													}
													else
													{
															$stids = $_POST['statenew'];
															$dtids = $_POST['districtnew'];

													}

												
													
													// 	$imp = "'" . implode( "','", $im) . "'";

												 //  $query = "select * from sd".$_SESSION['activeyears']." where \"STID\" IN (".implode( ",",$stids).")  AND \"DTID\" IN (".implode( ",",$dtids).") AND lower(\"SDName\") IN ($imp)";
													
													// $querydata = pg_query($db,$query);

													// $querydatarow = pg_numrows($querydata);
													// if($querydatarow>0)
													// {
													// $statename = "alreadyexists";	
													// }
													// else
													// {
													$statename = "addsubdistrict";

												//	}	

												//	}
												// }
						
					
												$data['data']=array();

												if($statename == 'addsubdistrict')
												{
														

														$stateconcate = '';
														$task1 = '';
														$task2 = '';
														$countofids = 0;
														$_POST['flag'] = '';

														if(count($_POST['newname'])>=count($_POST['namefrom']))
														{

																		// print_r($_POST);
															
																				$_POST['flag'] = 'newname';
																				if($_POST['action'][0]!='Full Merge')
																				{

																				
	// code changed by bheema for subdistricts level ASC the VTname

	$data11 = pg_query_params($db, 'SELECT "VTID", CONCAT_WS(\' - \', "VTName", "MDDS_VT") as "VTName"
	FROM "vt'.$_SESSION['activeyears'].'"
	WHERE "SDID" = $1 AND "is_deleted" = $2
	ORDER BY "VTName" ASC',
	array($_POST['namefrom'][0], 1));

	$dataresult1 = pg_fetch_all($data11);
	$datacount =pg_num_rows($data11); // total count


																				
																				for($i=0;$i<count($_POST['newname']);$i++)
																				{
																				// $idsof = $idsof + 1;

																				// $stateconcate .="(".$stids.",".$dtids.",".$idsof.",'".ucwords(strtolower($_POST['newname'][$i]))."'),";




																				$task1 .='<div class="col-md-6"><label class="col-md-5 col-form-label" for="userName1">'.$comenexttext.' of '.htmlspecialchars($sttext[0]).' '.$_SESSION['logindetails']['baseyear'].' - '.$_SESSION['activeyears'].'</label>  
																				      <label class="col-md-6 col-form-label" for="userName1">'.$comenexttext.' of '.$_POST['newname'][$i].' '.$_SESSION['activeyears'].'</label> 
																				<select multiple="multiple" id="addlinksDTID_'.$i.'" class="multi-select" name="addlinksDTID'.$i.'[]">';
																				foreach($dataresult1 as $key => $element) {
																				$task1 .='<option value="'.$element['VTID'].'">'.$element['VTName'].'
																				</option>';
																				}
																				$task1 .='</select><div class="mt-2">Total Selected '.$comenexttext.'(s) : <span id="totaldefultselected_'.$i.'">0</span> - out of :<span> '.$datacount.'</span></div><div class="mt-2"><input type="checkbox" name="haveapartially'.$i.'[]" class="haveapartially" id="'.$i.'" onclick="handleClick(this,'.$i.');"> <label for="checkbox2">Any '.$comenexttext.' Partially '.$_POST['action'][$i].' from '.$sttext[$i].' </label></div><div id="selectedlist'.$i.'"></div></div>'; // total count


																				

																				}
																			
																			}
																			else
																			{
																				$tempflag='true';
																			}

																				// $stateconcatefinal = rtrim($stateconcate, ',');


																			 //  $state ='insert into sd'.$_SESSION['activeyears'].' ("STID","DTID","SDID","SDName") values '.$stateconcatefinal.' returning "SDID"';

																				// $result = pg_query($state);
																				// if($result)
																				// {
																				// $fch = pg_fetch_all($result);
																				$countofids =count($_POST['newname']); 
																				$data=$_POST;
																			//	$data['inserstate']=$fch;

																				$task = "adddata";



																				// }
																				// else
																				// {
																				// $task = "error";
																				// } 

														}
														else
														{
																
																 $jig = $_POST['action'];
																
																 $pos = in_array('Split',$jig);
																
																 if ($pos==0) {
																
																$tempflag='true';
																
																}
																else
																{
																	$tempflag='false';
																}
																

															

																				$_POST['flag'] = 'namefrom';



																					// $idsof = $idsquerydata[0];
																				for($i=0;$i<count($_POST['namefrom']);$i++)
																				{
																				 // $idsof = $idsof + 1;
																				// 		echo 'select "VTID","VTName" from "vt'.$_SESSION['activeyears'].'" where "SDID"='.$_POST['namefrom'][$i].'
																				// ORDER BY "vt'.$_SESSION['activeyears'].'"."VTID"';
																				// exit;
																					if($_POST['action'][$i]!='Full Merge')
																					{

																				$data11 = pg_query_params($db, 'select "VTID",CONCAT_WS(\' - \',"VTName","MDDS_VT") as "VTName" from "vt'.$_SESSION['activeyears'].'" where "SDID"=$1 AND "is_deleted"=$2
																				ORDER BY "vt'.$_SESSION['activeyears'].'"."VTName"',array($_POST['namefrom'][$i],1));
																				$dataresult1 = pg_fetch_all($data11);
																				$datacount =pg_num_rows($data11); // total count


																				$task1 .='<div class="col-md-6"><label class="col-md-5 col-form-label" for="userName1">'.$comenexttext.' of '.htmlspecialchars($sttext[$i]).' '.$_SESSION['logindetails']['baseyear'].' - '.$_SESSION['activeyears'].'</label>  
																				                          <label class="col-md-6 col-form-label" for="userName1">'.$comenexttext.' of '.htmlspecialchars($_POST['newname'][0]).' '.$_SESSION['activeyears'].'</label> 
																				<select multiple="multiple" id="addlinksDTID_'.$i.'" class="multi-select" name="addlinksDTID'.$i.'[]">';
																				      foreach($dataresult1 as $key => $element) {
																				      $task1 .='<option value="'.$element['VTID'].'">'.$element['VTName'].'
																				          </option>';
																				          }
																						  // twice same place repeating issue JC_37
																						  $task1 .='</select><div class="mt-2">Total Selected '.$comenexttext.'(s) : <span id="totaldefultselected_'.$i.'">0</span> - out of : <span> '.$datacount.'</span></div><div class="mt-2"><input type="checkbox" onclick="handleClick(this,'.$i.');" name="haveapartially'.$i.'[]" class="haveapartially" id="'.$i.'"> <label for="checkbox2">Any '.$comenexttext.' Partially '.$_POST['action'][1].' from '.$sttext[$i].' </label></div><div id="selectedlist'.$i.'"></div></div>'; // total count  // partially repeated twice 200923


																				      }


																				}
																				// $idsof = $idsof + 1;
																					
																				// $stateconcate .="(".$stids.",".$dtids.",".$idsof.",'".ucwords(strtolower($_POST['newname'][0]))."')";
																			

																				//   $state ='insert into sd'.$_SESSION['activeyears'].' ("STID","DTID","SDID","SDName") values '.$stateconcate.' returning "SDID"';
																			
																				// $result = pg_query($state);
																				// if($result)
																				// {
																				// $fch = pg_fetch_all($result);
																				$countofids =count($_POST['namefrom']);
																				$data=$_POST;
																			//	$data['inserstate']=$fch;

																				$task = "adddata";



																				// }
																				// else
																				// {
																				// $task = "error";
																				// } 



														}

												}
												else
												{
												$task = $statename;
												}
								
										}
										else if($_POST['clickpopup']=='Rename')
										{
											// print_r($_POST);

											
											$_POST['applyon']=$_POST['comefromcheck'];

													
															

													$statename = '';
													$a = array_map( 'trim',$_POST['newnamecheck']);
													//$im = array_map( 'strtolower', $a );
													// rename validation for  sub district name code modified by srikanth//
											// $statename = '';
											// $subDistrictNames = array_map('trim', $_POST['newnamecheck']);
											// $subDistrictNames = array_map('strtolower', $subDistrictNames);
											// $stateIds = $_POST['statenew'];
											// $districtIds = $_POST['districtnew'];
	
										
											// for ($i = 0; $i < count($subDistrictNames); $i++) {
											// 	$subDistrictName = $subDistrictNames[$i];
											// 	$stateId = $stateIds[$i];
											// 	$districtId = $districtIds[$i];
	
											// 	$query = "SELECT * FROM sd".$_SESSION['activeyears']." WHERE \"STID\"=$stateId AND \"DTID\"=$districtId AND lower(TRIM(\"SDName\")) LIKE lower('%$subDistrictName%')";
											// 	// $query = "SELECT * FROM sd".$_SESSION['activeyears']." WHERE \"STID\"=$stateId AND \"DTID\"=$districtId AND lower(\"SDName\") = '$subDistrictName'";
											// 	$querydata = pg_query($db, $query);
	
											// 	$querydatarow = pg_numrows($querydata);
	
											// 	if ($querydatarow > 0) {
											// 		$statename = "alreadyexists"; 
											// 		break; 
											// 	}
											// }
	
											// if ($statename != "alreadyexists") {
											// 	$statename = "addsddistrict"; 
											// }
	
										// ends here//

										//rename validation modified by gowthami subdistrict
										$flag = false;
											$newnamecheck = $_POST['newnamecheck'];
											$nametotext = $_POST['nametotext'];
											$pattern = '/[^A-Za-z]/';  
											$nametotextArray = explode(',', $nametotext);
											if (count($newnamecheck) !== count($nametotextArray)) {
												$statename = "mismatched";
											} else {
												foreach (array_map(null, $newnamecheck, $nametotextArray) as $pair) {
													list($gs, $textElement) = $pair;
													if (preg_match('/\d/', $gs)) {
														continue;
													}
													$gsWos = preg_replace($pattern, '', $gs);
													$gsWos1 = preg_replace($pattern, '', $textElement);

													if (strtolower($gsWos) == strtolower($gsWos1)) {  
														$statename = "alreadyexists";
														$flag = true;
														break;
													}
												}

												if (!$flag) {
													$statename = "addsd";
												}
											}

										
				                                  // ends here
											
														$data['data']=array();

														if($statename == 'addsd')
												{

														$task1 = '';
														$task2 = '';
														$countofids = 0;
																				$countofids =count($_POST['newnamem']); 
																				$data=$_POST;
														
																				$task = "adddata";

												}
												else
												{
												$task = $statename;
												}

										}
										else if($_POST['clickpopup']=='Reshuffle')
										{
											 
											
											$_POST['applyon']=$_POST['comefromcheck'];

											$statename = '';


											$data['data']=array();

											$countofids = 0;
												$countofids =0; 
												$data=$_POST;

												$task = "adddata";

												

										}
										else
										{


											$sttext = explode(',',$_POST['namefromtext']);
											$data = array();
											
											if($_POST['oremovenewarray']==1)
											{
													// $query = "select * from sd".$_SESSION['activeyears']." where \"STID\"=".$_POST['statenew'][0]." AND \"DTID\"=".$_POST['districtnew'][0]." AND lower(\"SDName\") IN ('".$_POST['newnamecheck'][0]."')";
													// $querydata = pg_query($db,$query);

													// $querydatarow = pg_numrows($querydata);


													// if($querydatarow>0)
													// {
													// $task = "alreadyexists";	
													// }
													// else
													// {
													// $task = "adddata";
													// }

                                                  // subdistrict name validation starts here modified by gowthami

													if(($_POST['clickpopup']=='Merge') || ($_POST['clickpopup']=='Partiallysm')){	
													
														$flag = false;
														$newnamecheck = $_POST['newnamecheck'];
														$nametotext = $_POST['nametotext'];
		
														foreach ($newnamecheck as $index => $gs) {
															// if ($gs == $nametotext) {
																if (strtolower($gs) == strtolower($nametotext)) {
																$task = "alreadyexists";
																$flag = true;
																break;
															}
														}
														
														if ($flag == true) {
															$task = "alreadyexists";
														} else {
															$task = "adddata";
														}
													}

													// End of validation
													
													if($_POST['clickpopup']=='Partiallysm')
													{
														$str = 'Partially Split & Merge';
													}
													else
													{
														$str = 'Partially Merge';

													}
													$flus =false; 
													if (in_array($str, $_POST['action']))
													{
													$flus = true;
													}
													$swami = 0;

													if($flus==true)
													{
														

													for($i=0;$i<count($_POST['namefrom']);$i++)
													{
														if($_POST['action'][$i]==$str)
														{
														$swami = $swami+1;

														$data11 = pg_query_params($db, 'select "VTID",CONCAT_WS(\' - \',"VTName","MDDS_VT") as "VTName" from "vt'.$_SESSION['activeyears'].'" where "STID"=$1 AND "DTID"=$2 AND "SDID"=$3 AND "is_deleted"=$4 ORDER BY "vt'.$_SESSION['activeyears'].'"."VTName"',array($_POST['fromstate'][$i],$_POST['districtget'][$i],$_POST['namefrom'][$i],1));
														$dataresult1 = pg_fetch_all($data11);
														$datacount =pg_num_rows($data11); // total count


														$task1 .='<div class="col-md-6"><label class="col-md-5 col-form-label" for="userName1">'.$comenexttext.' of '.htmlspecialchars($sttext[$i]).' '.$_SESSION['logindetails']['baseyear'].' - '.$_SESSION['activeyears'].'</label>  
														<label class="col-md-6 col-form-label" for="userName1">'.$comenexttext.' of ';

														if(isset($_POST['newnamecheck']) && $_POST['newnamecheck'][0]!=''){ 
													$task1 .=''.ucwords(htmlspecialchars($_POST['newnamecheck'][0])).'';
												}
												else
													{
														$task1 .=''.ucwords(htmlspecialchars($_POST['nametotext'])).'';
														}  
														$task1 .=' '.$_SESSION['activeyears'].'</label> 
														<select multiple="multiple" id="addlinksDTID_'.$i.'" class="multi-select" name="addlinksDTID'.$i.'[]">';
														foreach($dataresult1 as $key => $element) {
														$task1 .='<option value="'.$element['VTID'].'">'.$element['VTName'].'
														</option>';
														}
														$task1 .='</select><div class="mt-2">Total Selected '.$comenexttext.'(s) : <span id="totaldefultselected_'.$i.'">0</span> - out of : <span> '.$datacount.'</span></div><div class="mt-2"><input type="checkbox" name="haveapartially'.$i.'[]" class="haveapartially" id="'.$i.'" onclick="handleClick(this,'.$i.');"> <label for="checkbox2">Any '.$comenexttext.'  '.$_POST['action'][$i].' from '.$sttext[$i].'</label></div><div id="selectedlist'.$i.'"></div></div>'; // total count

														}



														}


													}
													$countofids =$swami;			
													$data=$_POST;
											}
											else
											{
												
											$task = "adddata";
											$flus =false; 
											if($_POST['clickpopup']=='Partiallysm')
													{
														$str = 'Partially Split & Merge';
													}
													else
													{
														$str = 'Partially Merge';

													}
											if (in_array($str, $_POST['action']))
											{
											$flus = true;
											}
											$swami = 0;
											if($flus==true)
											{


											for($i=0;$i<count($_POST['namefrom']);$i++)
											{
											if($_POST['action'][$i]==$str)
											{
											$swami = $swami+1;
											

											$data11 = pg_query_params($db, 'select "VTID",CONCAT_WS(\' - \',"VTName","MDDS_VT") as "VTName" from "vt'.$_SESSION['activeyears'].'" where "STID"=$1 AND "DTID"=$2 AND "SDID"=$3 AND "is_deleted"=$4 ORDER BY "vt'.$_SESSION['activeyears'].'"."VTName"',array($_POST['fromstate'][$i],$_POST['districtget'][$i],$_POST['namefrom'][$i],1));
											$dataresult1 = pg_fetch_all($data11);
											$datacount =pg_num_rows($data11); // total count


											$task1 .='<div class="col-md-6"><label class="col-md-5 col-form-label" for="userName1">'.$comenexttext.' of '.htmlspecialchars($sttext[$i]).' '.$_SESSION['logindetails']['baseyear'].' - '.$_SESSION['activeyears'].'</label>  
											<label class="col-md-6 col-form-label" for="userName1">'.$comenexttext.' of ';

														if(isset($_POST['newnamecheck']) && $_POST['newnamecheck'][0]!=''){ 
													$task1 .=''.ucwords(htmlspecialchars($_POST['newnamecheck'][0])).'';
												}
												else
													{
														$task1 .=''.ucwords(htmlspecialchars($_POST['nametotext'])).'';
														}  
														$task1 .=' '.$_SESSION['activeyears'].'</label> 
											<select multiple="multiple" id="addlinksDTID_'.$i.'" class="multi-select" name="addlinksDTID'.$i.'[]">';
											foreach($dataresult1 as $key => $element) {
											$task1 .='<option value="'.$element['VTID'].'">'.$element['VTName'].'
											</option>';
											}
											$task1 .='</select><div class="mt-2">Total Selected '.$comenexttext.'(s) : <span id="totaldefultselected_'.$i.'">0</span> - out of :<span> '.$datacount.'</span></div><div class="mt-2"><input type="checkbox" name="haveapartially'.$i.'[]" class="haveapartially" id="'.$i.'" onclick="handleClick(this,'.$i.');"> <label for="checkbox2">Any '.$comenexttext.' '.$_POST['action'][$i].' from '.$sttext[$i].' </label></div><div id="selectedlist'.$i.'"></div></div>'; // total count

											}



											}


											}
											$countofids =$swami;			
											$data=$_POST;
											}

										}


							}

						else if($_POST['comefromcheck']=='Village / Town')
							{
										
										if($_POST['clickpopup']=='Rename')
										{
													$_POST['applyon']=$_POST['comefromcheck'];
														$statename = '';
														$a = array_map( 'trim',$_POST['newnamecheck']);
													$im = array_map( 'strtolower', $a);
													// $da = str_contains($_POST['oremovenewarray'],'1');

													// if(count(array_dup($im))>0 && $da!='')
													// {
													// 	$statename = "duplicatenameexist";
													// 	// Duplicate Name Exists
													// }
													// else
													// {
														// $stids = "".implode( ",", $_POST['statenew'])."";	
														// $dtids = "".implode( ",", $_POST['districtnew'])."";
														// $sdids = "".implode( ",", $_POST['sddistrictnew'])."";	
														// $imp = "'" . implode( "','",$im) . "'";

														// $query = "select * from vt".$_SESSION['activeyears']." where \"STID\" IN (".$stids.") AND \"DTID\" IN (".$dtids.") AND \"SDID\" IN (".$sdids.") AND lower(\"VTName\") IN ($imp)";
														// $querydata = pg_query($db,$query);

														// $querydatarow = pg_numrows($querydata);
														// if($querydatarow>0)
														// {
														// $statename = "alreadyexists";	
														// }
														// else
														// {
														// $statename = "addsddistrict";
														// }
													// }

													//rename validation for village name code changed by srikanth//
													if(count(array_dup($im))>0 && $da!='')
													{
														$statename = "duplicatenameexist";
														// Duplicate Name Exists
													}
													else
													{
														// $stids = "".implode( ",", $_POST['statenew'])."";	
														// $dtids = "".implode( ",", $_POST['districtnew'])."";
														// $sdids = "".implode( ",", $_POST['sddistrictnew'])."";	
														// $imp = "'" . implode( "','",$im) . "'";

														// $query = "select * from vt".$_SESSION['activeyears']." where \"STID\" IN (".$stids.") AND \"DTID\" IN (".$dtids.") AND \"SDID\" IN (".$sdids.") AND lower(\"VTName\") IN ($imp)";
														// $querydata = pg_query($db,$query);

														// $querydatarow = pg_numrows($querydata);
														// if($querydatarow>0)
														// {
														// $statename = "alreadyexists";	
														// }
														// else
														// {
														// 	$statename = "addsddistrict";
														// 	}
														// }
										         // ends here

											// rename validation changes made by gowthami village level
											$flag = false;
											$newnamecheck = $_POST['newnamecheck'];
											$nametotext = $_POST['nametotext'];
											$pattern = '/[^A-Za-z]/';  
											$nametotextArray = explode(',', $nametotext);
											if (count($newnamecheck) !== count($nametotextArray)) {
												$statename = "mismatched";
											} else {
												foreach (array_map(null, $newnamecheck, $nametotextArray) as $pair) {
													list($gs, $textElement) = $pair;
													if (preg_match('/\d/', $gs)) {
														continue;
													}
													$gsWos = preg_replace($pattern, '', $gs);
													$gsWos1 = preg_replace($pattern, '', $textElement);

													if (strtolower($gsWos) == strtolower($gsWos1)) {  
														$statename = "alreadyexists";
														$flag = true;
														break;
													}
												}

												if (!$flag) {
													$statename = "addvt";
												}
											}

										}
											//ends here
														$data['data']=array();

														if($statename == 'addvt')
												{

														$task1 = '';
														$task2 = '';
														$countofids = 0;
																				$countofids =count($_POST['newnamem']); 
																				$data=$_POST;
														
																				$task = "adddata";

												}
												else
												{
												$task = $statename;
												}
										}
										//modified by sahana 0509
											else
											{
													$_POST['applyon']=$_POST['comefromcheck'];

														if($_POST['didsup']!='')
														{
																$stids = $_POST['dids'];
																$dtids = $_POST['didsup'];
																$sdids = $_POST['sdidsup'];
														}
														else
														{
																$stids = $_POST['statenew'];
																$dtids = $_POST['districtnew'];
																$sdids = $_POST['sddistrictnew'];

														}


														$statename = '';


														$sttext = explode(',',$_POST['namefromtext']);

											//modified by sahana partially split & merge  Defect_JC_97
										if(($_POST['clickpopup']=='Merge') || ($_POST['clickpopup']=='Create') || ($_POST['clickpopup']=='Partiallysm') || ($_POST['clickpopup']=='Reshuffle'))			
											{
														//Defect_JC_58 modified by sahana VILLAGE level m/pm
														$namefromArrays = array();

														foreach ($_POST as $key => $value) {
															if ($key === 'namefrom' || strpos($key, 'namefrom') === 0 && preg_match('/^namefrom\d+$/', $key)) {
																$namefromArrays[] = $value;
															}
														}

														$results = array();

														function fetchVillageData($db, $vtid) {
															$sql = "SELECT \"VTName\", \"Level\", \"Status\" FROM vt" . $_SESSION['activeyears'] . " WHERE \"VTID\" = $1";
															$data = pg_query_params($db, $sql, array($vtid));
															
															if ($data) {
																$row = pg_fetch_assoc($data);
																$vtid = trim($row['VTName']);
																$level = trim($row['Level']);
																$status = trim($row['Status']);

																$dataarrayvillage = array('VTName' => $vtid, 'Level' => $level, 'Status' => $status);
																return $dataarrayvillage;
															} else {
																echo "Database query error: " . pg_last_error($db);
																return false;
															}
														}

														foreach ($namefromArrays as $outerArray) {
															$outerResult = array(); 
															foreach ($outerArray as $vtid) {
																$data = fetchVillageData($db, $vtid);
																if ($data !== false) {
																	$outerResult[] = $data; 
																} else {
																	echo "Database query error: " . pg_last_error($db);
																}
															}
															$results[] = $outerResult; 
														}


														if($_POST['clickpopup']=='Merge')
															{
																$a = array_map( 'trim',$_POST['newnamecheck']);
																$im = array_map( 'strtolower', $a);
															}
															else
															{
																$a = array_map( 'trim',$_POST['newname']);
																$im = array_map( 'strtolower', $a);
															}

											}	 
											         // duplicate name validation for M/PM in village level

														// if(count(array_dup($im))>0)
														// {
														// 	$statename = "duplicatenameexist";
															
														// }
														// else
														// {
														// 	$imp = "'" . implode( "','",$im) . "'";

															


														// 	 $query = "select * from vt".$_SESSION['activeyears']." where \"STID\" IN (".implode( ",",$stids).")  AND \"DTID\" IN (".implode( ",",$dtids).") AND \"SDID\" IN (".implode( ",",$sdids).") AND lower(\"VTName\") IN ($imp)";
														// 	$querydata = pg_query($db,$query);

														// 	$querydatarow = pg_numrows($querydata);
														// 	if($querydatarow>0)
														// 	{
														// 	$statename = "alreadyexists";	
														// 	}
														// 	else
														// 	{
														// 	$statename = "addvt";
														// 	}
														// }
												//ends here
												            //  $statename = "addvt";

                                                 //modified by gowthami village name validation
												// if(($_POST['clickpopup']=='Merge') || ($_POST['clickpopup']=='Partiallysm')){	
													
												// 	$flag = false;
												// 	$newnamecheck = $_POST['newnamecheck'];
												// 	$nametotext = $_POST['nametotext'];

												// 	foreach ($newnamecheck as $index => $gs) {
												// 		// if ($gs == $nametotext) {
												// 			if (strtolower($gs) == strtolower($nametotext)) {
												// 			$statename = "alreadyexists";
												// 			$flag = true;
												// 			break;
												// 		}
												// 	}

												// 	if ($flag == true) {
												// 		$statename = "alreadyexists";
												// 	} else {
												// 		$statename = "addvt";
												// 	}
												// }
												// else {
												// 	$statename = "addvt";
												// }
                                                    //modified by gowthami village name validation
												   if(($_POST['clickpopup'] == 'Merge') || ($_POST['clickpopup'] == 'Partiallysm')) {
                                                    $flag = false;
                                                    $newnamecheck = $_POST['newnamecheck'];
                                                    $nametotext = $_POST['nametotext'];
                                                    $pattern = '/[^A-Za-z]/';
                                                    foreach ($newnamecheck as $index => $gs) {
                                                        if (preg_match('/\d/', $gs)) {
                                                            continue;
                                                        }
                                                        $gsWos = preg_replace($pattern, '', $gs);
                                                        $gsWos1 = preg_replace($pattern, '', $nametotext);
                                                        if (strtolower($gsWos) == strtolower($gsWos1)) {
                                                            $statename = "alreadyexists";
                                                            $flag = true;
                                                            break;
                                                        }
                                                    }
                                                    if ($flag == true) {
                                                        $statename = "alreadyexists";
                                                    } else {
                                                        $statename = "addvt";
                                                    }
                                                } else {
                                                    $statename = "addvt";
                                                }
                                       
												// modified by gowthami village name validation JC_05
												// if( ($_POST['clickpopup']=='Create')){	
												// 	$flag = false;
												// 	$newnamecheck = $_POST['namefromtext'];
												// 	$newnamecheckArray = explode(',', $newnamecheck);
												// 	$nametotextArray = $_POST['newname'];
												// 	$nametotext = implode(',', $nametotextArray);
													
	
												// 	foreach ($newnamecheckArray  as $index => $gs) {
												// 		if (($gs) == ($nametotext)) {
												// 			$statename = "alreadyexists";
												// 			$flag = true;
												// 			break;
												// 		}
												// 	}
													
												// 	if ($flag == true) {
												// 		$statename = "alreadyexists";
												// 	} else {
	
												// 		$statename == 'addvt';
														
												// 	}} else {
	
														$statename == 'addvt';
														
													// }
													  //end


															$data['data']=array();

													if($statename == 'addvt')
													{


															$stateconcate = '';
															$task1 = '';
															$task2 = '';
															$countofids = 0;
															$_POST['flag'] = '';
																
															if($_POST['clickpopup']=='Addition')
															{
																	$_POST['flag'] = 'newname';

																$countofids =count($_POST['newname']); 
																$data=$_POST;
																$task = "adddatavt";
															}
															else
															{
																if(count($_POST['newname'])>=count($_POST['fromstate']))
																{
																$_POST['flag'] = 'newname';

																$countofids =count($_POST['newname']); 
																$data=$_POST;
																$task = "adddatavt";

																}
																else
																{

																$_POST['flag'] = 'namefrom';
																$countofids =count($_POST['fromstate']);
																$data=$_POST;
																$task = "adddatavt";
																}
															}		


															

													}
													else
													{
													$task = $statename;
													}

											}
													


												

											}





											echo $task."|".json_encode($data)."|".$_POST['comefromcheck']."|".$task1."|".$countofids."|".$_POST['clickpopup']."|".$tempflag. "|" . json_encode($results);;
											exit;

											}


else if($_POST['formname']=='assignformdatamerge')
{

			// print_r($_POST);			
			// exit;
						$comenexttext ='';

						if($_POST['comefromcheckmrg']=='District')
						{
							$comenexttext ='Sub-District';
						}
						else if($_POST['comefromcheckmrg']=='Sub-District')
						{
							$comenexttext ='Village(s) / Town';
						}
						else if($_POST['comefromcheckmrg']=='Village(s) / Town')
						{
							$comenexttext ='Ward';
						}
							else if($_POST['comefromcheckmrg']=='State')
						{
							$comenexttext ='District';
						}
						else
						{
							$comenexttext ='State';
						}


						if($_POST['comefromcheckmrg']=='State')
						{

										$data = array();
												if($_POST['oremovemrg']==1)
												{
														$query = 'select * from st'.$_SESSION['activeyears'].' where "STName" = Any(string_to_array($1::text, \',\'::text)::text[])';
													$querydata = pg_query_params($db,$query,array($_POST['newnamecheck'][0]));

													$querydatarow = pg_numrows($querydata);
																

																if($querydatarow>0)
																{
																	$task = "alreadyexists";	
																}
																else
																{
																	$task = "addstate";
																}
													$data=$_POST;
												}
												else
												{
																$task = "addstate";
												$data=$_POST;
												}
						
													
						}
						else if($_POST['comefromcheckmrg']=='District')
						{
								

								$data = array();
								if($_POST['oremovemrg']==1)
								{

									$where = ''; 

									if($_POST['didsupmrg']=='')
									{	
											$arr=array($_POST['newnamecheck'][0],$_POST['didsmrg']);

											$query = 'select * from dt'.$_SESSION['activeyears'].' where "DTName" = Any(string_to_array($1::text, \',\'::text)::text[]) 
										AND "STID"=$2';

									}
									else
									{
										$arr=array($_POST['newnamecheck'][0],$_POST['didsupmrg']);

										$query = 'select * from dt'.$_SESSION['activeyears'].' where "DTName" = Any(string_to_array($1::text, \',\'::text)::text[]) 
										AND "STID"=$2';
									}

										
									$querydata = pg_query_params($db,$query,$arr);

									$querydatarow = pg_numrows($querydata);
												

												if($querydatarow>0)
												{
													$task = "alreadyexists";	
												}
												else
												{
													$task = "adddistrict";
												}
								$data=$_POST;
								}
								else
								{
												$task = "adddistrict";
								$data=$_POST;
								}


						}

						else if($_POST['comefromcheckmrg']=='Sub-District')
						{

							// print_r($_POST);
							// exit;

								$data = array();
								if($_POST['oremovemrg']==1)
								{

									
									if($_POST['didsupmrg']=='')
									{	
											// $where = " ";
											$aaa=array($_POST['newnamecheck'][0],$_POST['didsmrg'],$_POST['districtgetmrg']);
											$query = 'select * from sd'.$_SESSION['activeyears'].' where "SDName" = Any(string_to_array($1::text, \',\'::text)::text[]) AND "STID"=$2 AND "DTID"=$3';
									}
									else
									{
										// $where = " AND \"STID\"=".$_POST['didsupmrg']." AND \"DTID\"=".$_POST['districtgetmrg']."";

											$aaa=array($_POST['newnamecheck'][0],$_POST['didsupmrg'],$_POST['districtgetmrg']);
											$query = 'select * from sd'.$_SESSION['activeyears'].' where "SDName" = Any(string_to_array($1::text, \',\'::text)::text[]) AND "STID"=$2 AND "DTID"=$3';

									}

										
									$querydata = pg_query_params($db,$query,$aaa);

									$querydatarow = pg_numrows($querydata);
												

												if($querydatarow>0)
												{
													$task = "alreadyexists";	
												}
												else
												{
													$task = "addsubdistrict";
												}
								$data=$_POST;
								}
								else
								{
												$task = "addsubdistrict";
								$data=$_POST;
								}


						}
						else if($_POST['comefromcheckmrg']=='Village / Town')
						{

							
								$data = array();
								if($_POST['oremovemrg']==1)
								{

									$where = ''; 

									if($_POST['didsupmrg']=='')
									{	
											$arrr=array($_POST['newnamecheck'][0],$_POST['didsmrg'],$_POST['districtgetmrg'],$_POST['subdistrictgetmrg']);

											$query = 'select * from vt'.$_SESSION['activeyears'].' where "VTName" = Any(string_to_array($1::text, \',\'::text)::text[]) 
										AND "STID"=$2 AND "DTID"=$3 AND "SDID"=$4';
									}
									else
									{
										// $where = " AND \"STID\"=".$_POST['didsupmrg']." AND \"DTID\"=".$_POST['districtgetmrg']." AND \"SDID\"=".$_POST['subdistrictgetmrg']."";

										$arrr=array($_POST['newnamecheck'][0],$_POST['didsupmrg'],$_POST['districtgetmrg'],$_POST['subdistrictgetmrg']);

											$query = 'select * from vt'.$_SESSION['activeyears'].' where "VTName" = Any(string_to_array($1::text, \',\'::text)::text[]) 
										AND "STID"=$2 AND "DTID"=$3 AND "SDID"=$4';
									}

										
									$querydata = pg_query_params($db,$query,$arrr);

									$querydatarow = pg_numrows($querydata);
												

												if($querydatarow>0)
												{
													$task = "alreadyexists";	
												}
												else
												{
													$task = "addvtdata";
												}
								$data=$_POST;
								}
								else
								{
												$task = "addvtdata";
								$data=$_POST;
								}


						}
							



	echo $task."|".json_encode($data)."|".$_POST['comefromcheckmrg'];
	
}

// veena for Enter new name validation
// else if($_POST['formname']=='assignformdatamergep')
// {

// 		// print_r($_POST);
// 		// exit;
// 						$comenexttext ='';

// 						if($_POST['comefromcheckmrgp']=='District')
// 						{
// 							$comenexttext ='Sub-District';
// 						}
// 						else if($_POST['comefromcheckmrgp']=='Sub-District')
// 						{
// 							$comenexttext ='Village / Town';
// 						}
// 						else if($_POST['comefromcheckmrgp']=='Village / Town')
// 						{
// 							$comenexttext ='Ward';
// 						}
// 							else if($_POST['comefromcheckmrgp']=='State')
// 						{
// 							$comenexttext ='District';
// 						}
// 						else
// 						{
// 							$comenexttext ='State';
// 						}


// 						if($_POST['comefromcheckmrgp']=='State')
// 						{

// 										$data = array();
// 												if($_POST['oremovemrg']==1)
// 												{
// 														$query = "select * from st".$_SESSION['activeyears']." where \"STName\" IN ('".$_POST['newnamecheck'][0]."')";
// 													$querydata = pg_query($db,$query);

// 													$querydatarow = pg_numrows($querydata);
																

// 																if($querydatarow>0)
// 																{
// 																	$task = "alreadyexists";	
// 																}
// 																else
// 																{
// 																	$task = "addstate";
// 																}
// 										$data=$_POST;
// 												}
// 												else
// 												{
// 																$task = "addstate";
// 												$data=$_POST;
// 												}
						
													
// 						}
// 						else if($_POST['comefromcheckmrgp']=='District')
// 						{
// 								// print_r($_POST);
// 								// exit;

// 								$condition = '';
										

												
// 												if($_POST['oremovemrgp']==1)
// 												{
// 														$query = "select * from dt".$_SESSION['activeyears']." where \"STID\"=".$_POST['didsmrgp']." AND \"DTName\" IN ('".$_POST['newnamecheckp'][0]."')";
// 													$querydata = pg_query($db,$query);

// 													$querydatarow = pg_numrows($querydata);
																

// 																if($querydatarow>0)
// 																{
// 																	$condition = "alreadyexists";	
// 																}
// 																else
// 																{
// 																	$condition = "adddt";
// 																}
													
// 												}
// 												else
// 												{
// 															$condition = "adddt";
													
// 												}
						

// 												// echo "+++++++++++++++++++".$condition;

// 												$data['data']=array();

// 												if($condition == 'adddt')
// 												{





// 														//   $sql = 'SELECT dt'.$_SESSION['activeyears'].'."DTID" FROM dt'.$_SESSION['activeyears'].' where "STID"='.$_POST['didsmrgp'].' AND "MDDS_SD" is null ORDER BY sd'.$_SESSION['activeyears'].'."DTID" DESC FETCH FIRST ROW ONLY';
													
// 														// $idsquery = pg_query($db,$sql);
														
// 														// if(pg_numrows($idsquery)>0)
// 														// 						{
																				
// 														// 					$idsquerydata = pg_fetch_row($idsquery);
																				
																			
// 														// 									$idsof = $idsquerydata[0];		
																					
// 														// 						}
// 														// 						else
// 														// 						{
// 														// 							$idsof = $_POST['didsmrgp']."".'000';	
// 														// 						}
// 														$stateconcate = '';
// 														$task1 = '';
// 														$task2 = '';
// 														$countofids = 0;
// 														$_POST['flag'] = '';
// 														if(count($_POST['newnamemrgp'])>=count($_POST['namefrommrgp']))
// 														{
// 															// echo 'select "VTID","VTName" from "vt'.$_SESSION['activeyears'].'" where "SDID"='.$_POST['namefrom'][0].'
// 															// 					ORDER BY "vt'.$_SESSION['activeyears'].'"."SDID"';
// 															// 					exit;

// 														// 	echo "___+++++++++++++++++++++++";
															
// 																				$_POST['flag'] = 'newnamemrgp';

// 																				$data11 = pg_query($db, 'select "SDID","SDName" from "sd'.$_SESSION['activeyears'].'" where "DTID"='.$_POST['newnamemrgp'][0].'
// 																				ORDER BY "sd'.$_SESSION['activeyears'].'"."DTID"');
// 																					$dataresult1 = pg_fetch_all($data11);

																				
// 																				for($i=0;$i<count($_POST['newnamemrgp']);$i++)
// 																				{
// 																				// $idsof = $idsof + 1;
// 																				// if($_POST['oremovemrgp']==1)
// 																				// {
// 																				// 	$stateconcate .="(".$_POST['didsmrgp'].",".$idsof.",'".$_POST['newnamecheckp'][0]."'),";
// 																				// }
// 																				// else
// 																				// {
// 																				// 	$stateconcate .="(".$_POST['didsmrgp'].",".$_POST['didsupmrgp'].",".$idsof.",'".$_POST['newnamemrgp'][$i]."'),";
// 																				// }
																				




// 																				$task1 .='<div class="col-md-6"><label class="col-md-5 col-form-label" for="userName1">'.$comenexttext.' of '.htmlspecialchars($_POST['nametotextp']).' '.$_SESSION['logindetails']['baseyear'].' - '.$_SESSION['activeyears'].'</label>  
// 																				      <label class="col-md-6 col-form-label" for="userName1">'.$comenexttext.' of '.htmlspecialchars($_POST['namefromtextmrgp']).' '.$_SESSION['activeyears'].'</label> 
// 																				<select multiple="multiple" id="addlinksDTID_'.$i.'" class="multi-select" name="addlinksDTID'.$i.'[]">';
// 																				foreach($dataresult1 as $key => $element) {
// 																				$task1 .='<option value="'.$element['SDID'].'">'.$element['SDName'].'
// 																				</option>';
// 																				}
// 																				$task1 .='</select></div>';


																				

// 																				}
// 																				if($_POST['oremovemrgp']==1)
// 																				{

// 																			// 	$stateconcatefinal = rtrim($stateconcate, ',');


// 																			  $state ="update into dt".$_SESSION['activeyears']." set \"DTName\"='".$_POST['newnamecheckp'][0]."' where \"DTID\"=".$_POST['namefrommrgp'][0]." ";

// 																				$result = pg_query($state);
// 																				// $fch = pg_fetch_all($result);
																				
// 																				$data['inserstate']=$_POST['namefrommrgp'][0];
// 																				$countofids =1; 
// 																				}
																		

// 																				$data=$_POST;
																				

// 																				$task = "adddtdata";



																				 

// 														}
// 														else
// 														{


// 																				$_POST['flag'] = 'namefrommrgp';




// 																					// $idsof = $idsquerydata[0];
// 																				for($i=0;$i<count($_POST['newnamemrgp']);$i++)
// 																				{
// 																				//  $idsof = $idsof + 1;
// 																				// 		echo 'select "VTID","VTName" from "vt'.$_SESSION['activeyears'].'" where "SDID"='.$_POST['namefrom'][$i].'
// 																				// ORDER BY "vt'.$_SESSION['activeyears'].'"."VTID"';
// 																				// exit;
// 																				$data11 = pg_query($db, 'select "SDID","SDName" from "sd'.$_SESSION['activeyears'].'" where "DTID"='.$_POST['newnamemrgp'][$i].'
// 																				ORDER BY "dt'.$_SESSION['activeyears'].'"."SDID"');
// 																				$dataresult1 = pg_fetch_all($data11);


// 																				$task1 .='<div class="col-md-6"><label class="col-md-5 col-form-label" for="userName1">'.$comenexttext.' of '.htmlspecialchars($_POST['nametotextp']).' '.$_SESSION['logindetails']['baseyear'].' - '.$_SESSION['activeyears'].'</label>  
// 																				                          <label class="col-md-6 col-form-label" for="userName1">'.$comenexttext.' of '.htmlspecialchars($_POST['namefrommrgp'][0]).' '.$_SESSION['activeyears'].'</label> 
// 																				<select multiple="multiple" id="addlinksDTID_'.$i.'" class="multi-select" name="addlinksDTID'.$i.'[]">';
// 																				      foreach($dataresult1 as $key => $element) {
// 																				      $task1 .='<option value="'.$element['SDID'].'">'.$element['SDName'].'
// 																				          </option>';
// 																				          }
// 																				          $task1 .='</select></div>';


// 																				}

// 																				// "STID"='.$_POST['didsmrgp'].' AND "DTID"='.$_POST['didsupmrgp'].'
// 																				// $idsof = $idsof + 1;
// 																					// $_POST['dids']."".$_POST['didsup']
// 																				if($_POST['oremovemrgp']==1)
// 																				{
// 																				// $stateconcate .="(".$_POST['didsmrgp'].",".$_POST['didsupmrgp'].",".$idsof.",'".$_POST['newnamemrgp'][0]."')";
// 																				// 	$stateconcatefinal = rtrim($stateconcate, ',');

// 																					 $state ="update into dt".$_SESSION['activeyears']." set \"DTName\"='".$_POST['newnamecheckp'][0]."' where \"DTID\"=".$_POST['namefrommrgp'][0]." ";

// 																				  // $state ='insert into sd'.$_SESSION['activeyears'].' ("STID","DTID","SDID","SDName") values '.$stateconcate.' returning "SDID"';
																			
// 																				$result = pg_query($state);
																				
// 																				// $fch = pg_fetch_all($result);
// 																				$data['inserstate']=$_POST['namefrommrgp'][0];
// 																				$countofids =1;
// 																				}
// 																				$data=$_POST;
																				

// 																				$task = "adddtdata";



																				



// 														}

// 												}
// 												else
// 												{
// 												$task = $condition;
// 												}


// 						}

// 						else if($_POST['comefromcheckmrgp']=='Sub-District')
// 						{

						


// 												$condition = '';
										

												
// 												if($_POST['oremovemrgp']==1)
// 												{
// 														$query = "select * from sd".$_SESSION['activeyears']." where \"STID\"=".$_POST['didsmrgp']." AND \"DTID\"=".$_POST['didsupmrgp']." AND \"SDName\" IN ('".$_POST['newnamecheckp'][0]."')";
// 													$querydata = pg_query($db,$query);

// 													$querydatarow = pg_numrows($querydata);
																

// 																if($querydatarow>0)
// 																{
// 																	$condition = "alreadyexists";	
// 																}
// 																else
// 																{
// 																	$condition = "addsd";
// 																}
													
// 												}
// 												else
// 												{
// 															$condition = "addsd";
													
// 												}
						
					
// 												$data['data']=array();

// 												if($condition == 'addsd')
// 												{





// 														  $sql = 'SELECT sd'.$_SESSION['activeyears'].'."SDID" FROM sd'.$_SESSION['activeyears'].' where "STID"='.$_POST['didsmrgp'].' AND "DTID"='.$_POST['didsupmrgp'].' AND "MDDS_SD" is null ORDER BY sd'.$_SESSION['activeyears'].'."SDID" DESC FETCH FIRST ROW ONLY';
													
// 														$idsquery = pg_query($db,$sql);
														
// 														if(pg_numrows($idsquery)>0)
// 																				{
																				
// 																			$idsquerydata = pg_fetch_row($idsquery);
																				
																			
// 																							$idsof = $idsquerydata[0];		
																					
// 																				}
// 																				else
// 																				{
// 																					$idsof = $_POST['didsmrgp']."".$_POST['didsupmrgp']."".'00000';	
// 																				}
// 														$stateconcate = '';
// 														$task1 = '';
// 														$task2 = '';
// 														$countofids = 0;
// 														$_POST['flag'] = '';
// 														if(count($_POST['newnamemrgp'])>=count($_POST['namefrommrgp']))
// 														{
// 															// echo 'select "VTID","VTName" from "vt'.$_SESSION['activeyears'].'" where "SDID"='.$_POST['namefrom'][0].'
// 															// 					ORDER BY "vt'.$_SESSION['activeyears'].'"."SDID"';
// 															// 					exit;
															
// 																				$_POST['flag'] = 'newnamemrgp';

// 																				$data11 = pg_query($db, 'select "VTID",CONCAT_WS(\' - \',"VTName","MDDS_VT") as "VTName" from "vt'.$_SESSION['activeyears'].'" where "SDID"='.$_POST['newnamemrgp'][0].'
// 																				ORDER BY "vt'.$_SESSION['activeyears'].'"."SDID"');
// 																					$dataresult1 = pg_fetch_all($data11);

																				
// 																				for($i=0;$i<count($_POST['newnamemrgp']);$i++)
// 																				{
// 																				$idsof = $idsof + 1;
// 																				if($_POST['oremovemrgp']==1)
// 																				{
// 																					$stateconcate .="(".$_POST['didsmrgp'].",".$_POST['didsupmrgp'].",".$idsof.",'".$_POST['newnamecheckp'][0]."'),";
// 																				}
// 																				// else
// 																				// {
// 																				// 	$stateconcate .="(".$_POST['didsmrgp'].",".$_POST['didsupmrgp'].",".$idsof.",'".$_POST['newnamemrgp'][$i]."'),";
// 																				// }
																				




// 																				$task1 .='<div class="col-md-6"><label class="col-md-5 col-form-label" for="userName1">'.$comenexttext.' of '.htmlspecialchars($_POST['nametotextp']).' '.$_SESSION['logindetails']['baseyear'].' - '.$_SESSION['activeyears'].'</label>  
// 																				      <label class="col-md-6 col-form-label" for="userName1">'.$comenexttext.' '.htmlspecialchars($_POST['namefromtextmrgp']).' '.$_SESSION['activeyears'].'</label> 
// 																				<select multiple="multiple" id="addlinksDTID_'.$i.'" class="multi-select" name="addlinksDTID'.$i.'[]">';
// 																				foreach($dataresult1 as $key => $element) {
// 																				$task1 .='<option value="'.$element['VTID'].'">'.$element['VTName'].'
// 																				</option>';
// 																				}
// 																				$task1 .='</select></div>';


																				

// 																				}
// 																				if($_POST['oremovemrgp']==1)
// 																				{

// 																				$stateconcatefinal = rtrim($stateconcate, ',');


// 																			  $state ='insert into sd'.$_SESSION['activeyears'].' ("STID","DTID","SDID","SDName") values '.$stateconcatefinal.' returning "SDID"';

// 																				$result = pg_query($state);
// 																				$fch = pg_fetch_all($result);
// 																				$data['inserstate']=$fch;
// 																				$countofids =count($fch); 
// 																				}
																		

// 																				$data=$_POST;
																				

// 																				$task = "addsddata";



																				 

// 														}
// 														else
// 														{


// 																				$_POST['flag'] = 'namefrommrgp';




// 																					// $idsof = $idsquerydata[0];
// 																				for($i=0;$i<count($_POST['newnamemrgp']);$i++)
// 																				{
// 																				 $idsof = $idsof + 1;
// 																				// 		echo 'select "VTID","VTName" from "vt'.$_SESSION['activeyears'].'" where "SDID"='.$_POST['namefrom'][$i].'
// 																				// ORDER BY "vt'.$_SESSION['activeyears'].'"."VTID"';
// 																				// exit;
// 																				$data11 = pg_query($db, 'select "VTID",CONCAT_WS(\' - \',"VTName","MDDS_VT") as "VTName" from "vt'.$_SESSION['activeyears'].'" where "SDID"='.$_POST['newnamemrgp'][$i].'
// 																				ORDER BY "vt'.$_SESSION['activeyears'].'"."VTID"');
// 																				$dataresult1 = pg_fetch_all($data11);


// 																				$task1 .='<div class="col-md-6"><label class="col-md-5 col-form-label" for="userName1">'.$_POST['nametotextp'].' '.$comenexttext.' Updated '.$_SESSION['logindetails']['baseyear'].'</label>  
// 																				                          <label class="col-md-6 col-form-label" for="userName1">'.$_POST['namefrommrgp'][0].' Draft '.$comenexttext.' '.$_SESSION['activeyears'].'</label> 
// 																				<select multiple="multiple" id="addlinksDTID_'.$i.'" class="multi-select" name="addlinksDTID'.$i.'[]">';
// 																				      foreach($dataresult1 as $key => $element) {
// 																				      $task1 .='<option value="'.$element['VTID'].'">'.$element['VTName'].'
// 																				          </option>';
// 																				          }
// 																				          $task1 .='</select></div>';


// 																				}

// 																				// "STID"='.$_POST['didsmrgp'].' AND "DTID"='.$_POST['didsupmrgp'].'
// 																				$idsof = $idsof + 1;
// 																					// $_POST['dids']."".$_POST['didsup']
// 																				if($_POST['oremovemrgp']==1)
// 																				{
// 																				$stateconcate .="(".$_POST['didsmrgp'].",".$_POST['didsupmrgp'].",".$idsof.",'".$_POST['newnamemrgp'][0]."')";
// 																				// 	$stateconcatefinal = rtrim($stateconcate, ',');


// 																				  $state ='insert into sd'.$_SESSION['activeyears'].' ("STID","DTID","SDID","SDName") values '.$stateconcate.' returning "SDID"';
																			
// 																				$result = pg_query($state);
																				
// 																				$fch = pg_fetch_all($result);
// 																				$data['inserstate']=$fch;
// 																				$countofids =count($_POST['namefrommrgp']);
// 																				}
// 																				$data=$_POST;
																				

// 																				$task = "addsddata";



																				



// 														}

// 												}
// 												else
// 												{
// 												$task = $condition;
// 												}
								

// 						}
// 						else if($_POST['comefromcheckmrgp']=='Village / Town')
// 						{

							
// 								$data = array();
// 								if($_POST['oremovemrg']==1)
// 								{

// 									$where = ''; 

// 									if($_POST['didsupmrg']=='')
// 									{	
// 											$where = " AND \"STID\"=".$_POST['didsmrg']." AND \"DTID\"=".$_POST['districtgetmrg']." AND \"SDID\"=".$_POST['subdistrictgetmrg']."";
// 									}
// 									else
// 									{
// 										$where = " AND \"STID\"=".$_POST['didsupmrg']." AND \"DTID\"=".$_POST['districtgetmrg']." AND \"SDID\"=".$_POST['subdistrictgetmrg']."";
// 									}

// 										$query = "select * from vt".$_SESSION['activeyears']." where \"VTName\" IN ('".$_POST['newnamecheck'][0]."') 
// 										".$where." ";
// 									$querydata = pg_query($db,$query);

// 									$querydatarow = pg_numrows($querydata);
												

// 												if($querydatarow>0)
// 												{
// 													$task = "alreadyexists";	
// 												}
// 												else
// 												{
// 													$task = "addvtdata";
// 												}
// 								$data=$_POST;
// 								}
// 								else
// 								{
// 												$task = "addvtdata";
// 								$data=$_POST;
// 								}


// 						}
							



// 	echo $task."|".json_encode($data)."|".$_POST['comefromcheckmrgp']."|".$task1."|".$countofids."|".$_POST['clickpopup'];
	
// }



else if($_POST['formname']=='finaladddocument')
{ 
		echo json_encode($_POST)."|".$_POST['uploadeddocument'];
}

// else if($_POST['formname']=='get_forread_updatedata')
// {
	
// 			$where = "";
//            if($_SESSION['admin_type']!=0 && $_SESSION['assignlist']!=null)  
// 			{
// 			$where = 'where "STID2021" in ('.$_SESSION['assignlist'].')';
           
// 			}

// 	$resultstate = pg_query($db, 'select "STID2011","STName2011","STID2021","STName2021" from "st2011" Full JOIN "st2021" On "st2011"."STID2011"="st2021"."STID2021" '.$where.' Order By "st2011"."STID2011","st2021"."STID2021"');
// 	$row = pg_fetch_all($resultstate); 

  

// 	$resultstate1 = pg_query($db, "select forreaddetails,statuslevel from detailforread where comefrom='ST' and is_deleted=1  order by statuslevel ASC");
// 	$row1 = pg_fetch_all($resultstate1); 

	
// 	$appand = '';
          
// 	$query = pg_query($db,"select * from dataforread where  \"For2011\"=".$_POST['STID2021']."");
// 	$valid = pg_numrows($query);
//     if($valid>0)
//     {
//         $rowaction = pg_fetch_all($query); 
//          foreach ($rowaction as $key => $elementdata) { 
		
// 		$appand .='<div class="form-group row">

        
//         <div class="row col-md-5">

//         <div class="col-md-6 pt-2">
//         <select class="form-select" required name="STID2011[]">
//         <option value="">Select 2011 State</option>';
// 			foreach ($row as $key => $element) {
//                 if($element['STID2021']==null)
//                 {
//                    $valueof = $element['STID2011'];
//                    $valueofname = $element['STName2011'];
//                 }
//                 else
//                 {
//                     $valueof = $element['STID2021'];
//                     $valueofname = $element['STName2021'];
//                 }

// 				$appand .='<option value="'.$valueof.'"'; if($elementdata['For2011']==$valueof){ $appand .=' selected';  }  $appand .='>'.$valueofname.'</option>';
// 		}
//         $appand .='</select>
//         </div>
// 		<div class = "col-md-6 pt-2">
// 		<select class="form-select" required name = "action[]">
// 		<option value = "">Action  From</option>';
// 		foreach ($row1 as $key => $element) {
// 			$appand .='<option value="'.$element['statuslevel'].'"'; if($elementdata['ChangeFrom']==$element['statuslevel']){ $appand .=' selected';  }  $appand .='>'.$element['forreaddetails'].'</option>';
// 	}

// 	$appand .='</select>
// 	</div>
    
//         </div>
//         <div class="row col-md-7">
//         <div class="col-md-5 pt-2">
//         <select class="form-select" required name="STID2021[]">
//         <option value="">Select 2021 State</option>';
// 			foreach ($row as $key => $element) {
//                 if($element['STID2021']==null)
//                 {
//                    $valueof = $element['STID2011'];
//                    $valueofname = $element['STName2011'];
//                 }
//                 else
//                 {
//                     $valueof = $element['STID2021'];
//                     $valueofname = $element['STName2021'];
//                 }

// 				$appand .='<option value="'.$valueof.'"'; if($elementdata['Read2021']==$valueof){ $appand .=' selected';  }  $appand .='>'.$valueofname.'</option>';
// 		}
//         $appand .='</select>
//         </div>
//     <div class = "col-md-5 pt-2">
//     <select class="form-select" required name = "actionto[]">
//     <option value = "">Action To</option>';
//     foreach ($row1 as $key => $element) {
//         $appand .='<option value="'.$element['statuslevel'].'"'; if($elementdata['ChangeTo']==$element['statuslevel']){ $appand .=' selected';  }  $appand .='>'.$element['forreaddetails'].'</option>';
// }

// $appand .='</select>
// </div>
// 	<div class="col-md-2 pt-2">
// 		<button type="button" class="btn-block btn-primary btn-rounded waves-effect waves-light remove_button">
// 			<i class="fas fa-times-circle"></i>
// 		</button>
// 	</div>
// 	</div>';
// 	}
//     }
// 	echo $appand."|".$valid;
	

// }

// else if($_POST['formname']=='addstatedata')
// {
// $checkval = pg_query($db, "select * from \"st2021\" where \"st2021\".\"STName2021\" = '".$_POST['addSTName2021']."'");
// $valid = pg_numrows($checkval);

// if($valid>0)
// {
// $task = "statenamealready";
// }
// else
// {


// $data = pg_query($db, 'select * from "st2021" ORDER BY "st2021"."STID2021" DESC LIMIT 1');
// $dataresult = pg_fetch_array($data);
// $STID2021 = $dataresult['STID2021']+1;
// $task = "";

// $query = "INSERT INTO st2021 (\"STID2021\",\"Short_ST2021\",\"MDDS_ST2021\",\"STName2021\",\"Status2021\") values
// (".$STID2021.",'".$_POST['addShort_ST2021']."','".$_POST['addMDDS_ST2021']."','".$_POST['addSTName2021']."','".$_POST['Status2021']."')";

// $result = pg_query($query);
// if($result)
// {
// if(isset($_POST['action']) && count($_POST['action'])>0)
// {

// for($i=0;$i<count($_POST['action']);$i++) { if($i==count($_POST['action'])-1) { $queryda .="("
//     .$_POST['STID2021'][$i].",".$_POST['action'][$i].",".$_POST['actionto'][$i].",".$STID2021.",'".$_POST['Leveldata']."')";
//     } else { $queryda .="("
//     .$_POST['STID2021'][$i].",".$_POST['action'][$i].",".$_POST['actionto'][$i].",".$STID2021.",'".$_POST['Leveldata']."'),";
//     } } $insertquery=pg_query($db,"INSERT INTO dataforread
//     (\"For2011\",\"ChangeFrom\",\"ChangeTo\",\"Read2021\",\"Leveldata\") values $queryda"); } $task="adddata" ; } else {
//     $task="error" ; } } echo $task; 

// } 
 // veena for Enter new name validation ends here
 
 
   else if($_POST['formname']=='updatestatedata' ) { 
        
 


        $task="" ;
       
     $checkval=pg_query($db, "select * from \" st2021\" where \"st2021\".\"STName2021\"='".$_POST[' STName2021']."' and
     \"st2021\".\"STID2021\" !='".$_POST[' update_ids']."'"); 
    $valid=pg_numrows($checkval); 
    if($valid>0)
    {
    $task = "statenamealready";
    }
    else {

      
    $query = "Update st2021 set
    \"Short_ST2021\"=".$_POST['Short_ST2021'].",\"MDDS_ST2021\"=".$_POST['MDDS_ST2021'].",\"STName2021\"='".$_POST['STName2021']."',\"Status2021\"='".$_POST['upStatus2021']."'
    where \"STID2021\"=".$_POST['update_ids']."";
 
    $result = pg_query($query);
    if($result)
    {

        if(isset($_POST['STID2011']) && count($_POST['STID2011'])>0)
        {


// JIGAR

            $sql = pg_query($db,"select array_to_string(array_agg(\"dataforread\".\"FRids\"), ',') as removeids,
            array_to_string(array_agg(\"dataforread\".\"For2011\"), ',') as alreadyids
            from dataforread where \"dataforread\".\"For2011\" In (".implode(',',$_POST['STID2011']).") and \"dataforread\".\"Read2021\" IN (".implode(',',$_POST['STID2021']).")");
            $dataresult = pg_fetch_array($sql);

            if($dataresult['alreadyids']!=null)
            {
                // echo "INNNNNNNNNNNNN";
                // echo "select array_agg(\"dataforread\".\"Read2021\") as diffidsdata from dataforread where \"dataforread\".\"For2011\"=".$_POST['update_ids']." and \"dataforread\".\"Read2021\" IN (".implode(',',$_POST['STID2021']).")";
                // exit;

                $select1 = pg_query("select array_agg(\"dataforread\".\"Read2021\") as diffidsdata from dataforread where \"dataforread\".\"For2011\"=".$_POST['update_ids']." and \"dataforread\".\"Read2021\" IN (".implode(',',$_POST['STID2021']).")");
                $dataresult1 = pg_fetch_array($select1);


            }

// JIGAR
            // echo "select array_agg(\"dataforread\".\"FRids\") as removeids,array_agg(\"dataforread\".\"Read2021\") as diffids from dataforread where \"dataforread\".\"For2011\"=".$_POST['update_ids']." and \"dataforread\".\"Read2021\" NOT IN (".implode(',',$_POST['STID2021']).")";
            // exit;

           $select = pg_query("select array_agg(\"dataforread\".\"FRids\") as removeids,array_agg(\"dataforread\".\"Read2021\") as diffids from dataforread where \"dataforread\".\"For2011\"=".$_POST['update_ids']." and \"dataforread\".\"Read2021\" NOT IN (".implode(',',$_POST['STID2021']).")");
           $dataresult = pg_fetch_array($select);
         
           if($dataresult['removeids']!=null)
           {
              
               $removeidsdata = substr($dataresult['removeids'], 1, -1);
               pg_query($db,"delete from dataforread where \"FRids\" IN (".$removeidsdata.")");
              
               $select1 = pg_query("select array_agg(\"dataforread\".\"Read2021\") as diffidsdata from dataforread where \"dataforread\".\"For2011\"=".$_POST['update_ids']." and \"dataforread\".\"Read2021\" IN (".implode(',',$_POST['STID2021']).")");
           $dataresult1 = pg_fetch_array($select1);
   
           $datanew = json_decode('[' . substr($dataresult1['diffidsdata'], 1, -1) . ']');
   
         //   $b=array_values(array_diff($_POST['STID2021'],$datanew));

           $b=array_values(array_diff($_POST['STID2021'],$datanew));

           $ba=array_diff($_POST['STID2021'],$datanew);
      
         $aaa = array_diff_key($_POST['action'],$ba);
          $bbb = array_values(array_diff_key($_POST['action'],$aaa));
          $bbbto = array_values(array_diff_key($_POST['actionto'],$aaa));
                if(count($b)>0)
            {
                $joinquery = '';
               for($i=0;$i<count($b);$i++)
               {   
                   if($i==count($b)-1) { 
   
                       $joinquery .="(".$_POST['update_ids'].",".$bbb[$i].",".$bbbto[$i].",".$b[$i].",'".$_POST['Leveldataup']."')";
   
                       }
                       else 
                       { 
                       $joinquery .="(".$_POST['update_ids'].",".$bbb[$i].",".$bbbto[$i].",".$b[$i].",'".$_POST['Leveldataup']."'),";
                       } 
                       
               }
           
                $insertdata = pg_query("INSERT INTO dataforread (\"For2011\",\"ChangeFrom\",\"ChangeTo\",\"Read2021\",\"Leveldata\") values $joinquery");
    
            }
             
           }
           else
           {
            $select1 = pg_query("select array_agg(\"dataforread\".\"Read2021\") as diffidsdata,array_agg(\"dataforread\".\"ChangeFrom\") as diffidsa from dataforread where \"dataforread\".\"For2011\"=".$_POST['update_ids']." and \"dataforread\".\"Read2021\" IN (".implode(',',$_POST['STID2021']).")");
            $dataresult1 = pg_fetch_array($select1);
         
            $datanew = json_decode('[' . substr($dataresult1['diffidsdata'], 1, -1) . ']');
            $b=array_values(array_diff($_POST['STID2021'],$datanew));
            $ba=array_diff($_POST['STID2021'],$datanew);
       
         $aaa = array_diff_key($_POST['action'],$ba);
         $bbb = array_values(array_diff_key($_POST['action'],$aaa));
         $bbbto = array_values(array_diff_key($_POST['actionto'],$aaa));
        
            $joinquery = '';
                for($i=0;$i<count($b);$i++)
                {   
                    if($i==count($b)-1) { 
    
                        $joinquery .="(".$_POST['update_ids'].",".$bbb[$i].",".$bbbto[$i].",".$b[$i].",'".$_POST['Leveldataup']."')";
    
                        }
                        else 
                        { 
                        $joinquery .="(".$_POST['update_ids'].",".$bbb[$i].",".$bbbto[$i].",".$b[$i].",'".$_POST['Leveldataup']."'),";
                        } 
                        
                }
               
                $insertdata = pg_query("INSERT INTO dataforread (\"For2011\",\"ChangeFrom\",\"ChangeTo\",\"Read2021\",\"Leveldata\") values $joinquery");
           }
           
        }
        else
        {
        //      echo "Only Delete";
        //    echo "delete from dataforread where For2011 =".$_POST['update_ids']."";
             pg_query($db,"delete from dataforread where \"dataforread\".\"For2011\" = ".$_POST['update_ids']."");
        }
      
    $task = "updatedata";
    }
    else
    {
    $task = "error";
    }
    }

    echo $task;
    }

    
    else if($_POST['formname']=='deletestate')
    {
    $task = "";


    $query = "delete from st2021 where \"STID2021\"=$1";
    $result = pg_query_params($db,$query,array($_POST['deletedids']));
    $result_rows = pg_affected_rows($result);
    if($result_rows!=0)
    {
    $task = "deletedata";
    }
    else
    {
    $task = "error";
    }


    echo $task;
    }

    else if($_POST['formname']=='deletedoc')
    {
   //  	print_r($_POST);
   
   // exit;
    $task = "";

    	$sqlselect = "select * from documentdata".$_SESSION['activeyears']." where \"docids\"=$1";
    	$query = pg_query_params($db,$sqlselect,array($_POST['deletedids']));
    	$sqldata = pg_fetch_array($query);
    	$filename = "Alldocuments/".$sqldata['docstid']."/".$sqldata['docnotification'];
	unlink($filename);    	

    $query = "delete from documentdata".$_SESSION['activeyears']." where \"docids\"=$1";
    $result = pg_query_params($db,$query,array($_POST['deletedids']));
    $result_rows = pg_affected_rows($result);
    if($result_rows!=0)
    {
    $task = "deletedata";
    }
    else
    {
    $task = "error";
    }


    echo $task;
    }

	else if ($_POST['formname'] === 'updatefreeze') {
		$docids = $_POST['docids'];
		$isFreezed = $_POST['isFreezed'];
	
		// Update the database table with the freeze status
		$query = 'UPDATE documentdata' . $_SESSION['activeyears'] . ' SET freezed = $1 WHERE "docids" = $2';
		$result = pg_query_params($db, $query, array($isFreezed, $docids));
		$resultRows = pg_affected_rows($result);
	
		if ($resultRows !== 0) {
			$task = 'updatedata';
		} else {
			$task = 'error';
		}
	
		echo $task;
	}
	

    else if($_POST['formname']=='deleteusers')
    {

    $task = "";


    $query = "delete from admin_login where \"id\"=$1";
    $result = pg_query_params($db,$query,array($_POST['deletedids']));
    $result_rows = pg_affected_rows($result);
    if($result_rows!=0)
    {
    $task = "deletedata";
    }
    else
    {
    $task = "error";
    }


    echo $task;
    }
    // else if($_POST['formname']=='adddistrictsdata')
    // {

    // $checkval = pg_query($db, "select * from \"dt2021\" where \"dt2021\".\"DTName2021\" = '".$_POST['addDTName2021']."'
    // and \"dt2021\".\"STID2021\" = ".$_POST['addSTID2021']."");
    // $valid = pg_numrows($checkval);

    // if($valid>0)
    // {
    // $task = "dtnamealready";
    // }
    // else
    // {

    // $data = pg_query($db, 'select * from "dt2021" ORDER BY "dt2021"."DTID2021" DESC LIMIT 1');
    // $dataresult = pg_fetch_array($data);
    // $DTID2021 = $dataresult['DTID2021']+1;
    // $task = "";
    // $query = "INSERT INTO dt2021 (\"STID2021\",\"DTID2021\",\"Short_DT2021\",\"MDDS_DT2021\",\"DTName2021\") values
    // (".$_POST['addSTID2021'].",".$DTID2021.",".$_POST['addShort_DT2021'].",".$_POST['addMDDS_DT2021'].",'".$_POST['addDTName2021']."')";
    // $result = pg_query($query);
    // if($result)
    // {
    // $task = "adddata";
    // }
    // else
    // {
    // $task = "error";
    // }
    // }
    // echo $task;

    // }

    // else if($_POST['formname']=='addsubdistrictsdata')
    // {

    // $checkval = pg_query($db, "select * from \"sd2021\" where \"sd2021\".\"SDName2021\" = '".$_POST['addSDName2021']."'
    // and \"sd2021\".\"STID2021\" = ".$_POST['addSTID2021']." and \"sd2021\".\"DTID2021\" = ".$_POST['addDTID2021']."");

    // $valid = pg_numrows($checkval);

    // if($valid>0)
    // {
    // $task = "sdtnamealready";
    // }
    // else
    // {


    // $task = "";
    // $query = "INSERT INTO sd2021
    // (\"STID2021\",\"DTID2021\",\"SDID2021\",\"Short_SD2021\",\"MDDS_SD2021\",\"SDName2021\") values
    // (".$_POST['addSTID2021'].",".$_POST['addDTID2021'].",".$_POST['addDTID2021']."".$_POST['addMDDS_SD2021'].",'".$_POST['addShort_SD2021']."','".$_POST['addMDDS_SD2021']."','".$_POST['addSDName2021']."')";
    // $result = pg_query($query);
    // if($result)
    // {
    // $task = "adddata";
    // }
    // else
    // {
    // $task = "error";
    // }
    // }
    // echo $task;

    // }

    // else if($_POST['formname']=='updatedistrictsdata')
    // {
    // $task = "";

    // $checkval = pg_query($db, "select * from \"dt2021\" where \"dt2021\".\"DTName2021\" = '".$_POST['DTName2021']."' and
    // \"dt2021\".\"STID2021\" = '".$_POST['STID2021']."' and \"dt2021\".\"DTID2021\" != '".$_POST['update_ids']."'");
    // $valid = pg_numrows($checkval);

    // if($valid>0)
    // {
    // $task = "dtnamealready";
    // }
    // else {
    // $query = "Update dt2021 set
    // \"Short_DT2021\"=".$_POST['Short_DT2021'].",\"MDDS_DT2021\"=".$_POST['MDDS_DT2021'].",\"DTName2021\"='".$_POST['DTName2021']."'
    // where \"DTID2021\"=".$_POST['update_ids']."";
    // $result = pg_query($query);
    // if($result)
    // {
    // $task = "updatedata";
    // }
    // else
    // {
    // $task = "error";
    // }
    // }

    // echo $task;
    // }

    // else if($_POST['formname']=='updatesubdistrictsdata')
    // {
    // $task = "";

    // $checkval = pg_query($db, "select * from \"sd2021\" where \"sd2021\".\"SDName2021\" = '".$_POST['SDName2021']."' and
    // \"sd2021\".\"STID2021\" = '".$_POST['STID2021']."' and \"sd2021\".\"DTID2021\" = '".$_POST['DTID2021']."' and
    // \"sd2021\".\"SDID2021\" != '".$_POST['update_ids']."'");
    // $valid = pg_numrows($checkval);

    // if($valid>0)
    // {
    // $task = "sdtnamealready";
    // }
    // else {
    // $query = "Update sd2021 set
    // \"Short_SD2021\"='".$_POST['Short_SD2021']."',\"MDDS_SD2021\"='".$_POST['MDDS_SD2021']."',\"SDName2021\"='".$_POST['SDName2021']."'
    // where \"SDID2021\"=".$_POST['update_ids']."";
    // $result = pg_query($query);
    // if($result)
    // {
    // $task = "updatedata";
    // }
    // else
    // {
    // $task = "error";
    // }
    // }

    // echo $task;
    // }
    // else if($_POST['formname']=='updatevillagedata')
    // {


    // $task = "";

    // $checkvaldata = pg_query($db, "select * from \"vt2021\" where \"vt2021\".\"VTName2021\" = '".$_POST['VTName2021']."'
    // and \"vt2021\".\"VTID2021\" = ".$_POST['update_ids']."");
    // $data = pg_fetch_array($checkvaldata);

    // $checkval = pg_query($db, "select * from \"vt2021\" where \"vt2021\".\"VTName2021\" = '".$_POST['VTName2021']."' and
    // \"vt2021\".\"STID2021\" = '".$data['STID2021']."' and \"vt2021\".\"DTID2021\" = '".$data['DTID2021']."' and
    // \"vt2021\".\"SDID2021\" = '".$data['SDID2021']."' and \"vt2021\".\"VTID2021\" != '".$_POST['update_ids']."'");
    // $valid = pg_numrows($checkval);

    // if($valid>0)
    // {
    // $task = "vtnamealready";
    // }
    // else {


    // if(isset($_POST['Status2021']) && trim($_POST['Status2021'])!='')
    // {
    // $query = "Update vt2021 set
    // \"Short_VT2021\"='".$_POST['Short_VT2021']."',\"MDDS_VT2021\"='".$_POST['MDDS_VT2021']."',\"Level2021\"='".$_POST['Level2021']."',\"Pop2021\"=".$_POST['Pop2021'].",\"Area2021\"=".$_POST['Area2021'].",\"VTName2021\"='".$_POST['VTName2021']."',\"Status2021\"='".$_POST['Status2021']."',\"Remark1\"='".$_POST['upRemark121']."',\"Remark2\"='".$_POST['upRemark221']."'
    // where \"VTID2021\"=".$_POST['update_ids']."";
    // }
    // else
    // {
    // $query = "Update vt2021 set
    // \"Short_VT2021\"='".$_POST['Short_VT2021']."',\"MDDS_VT2021\"='".$_POST['MDDS_VT2021']."',\"Level2021\"='".$_POST['Level2021']."',\"Pop2021\"=".$_POST['Pop2021'].",\"Area2021\"=".$_POST['Area2021'].",\"VTName2021\"='".$_POST['VTName2021']."',\"Remark1\"='".$_POST['upRemark121']."',\"Remark2\"='".$_POST['upRemark221']."'
    // where \"VTID2021\"=".$_POST['update_ids']."";
    // }

    // $result = pg_query($query);
    // if($result)
    // {
    // $task = "updatedata";
    // }
    // else
    // {
    // $task = "error";
    // }
    // }

    // echo $task;
    // }

    // else if($_POST['formname']=='deletedt')
    // {
    // $task = "";


    // $query = "delete from dt2021 where \"DTID2021\"=".$_POST['deletedids']."";
    // $result = pg_query($query);
    // if($result)
    // {
    // $task = "deletedata";
    // }
    // else
    // {
    // $task = "error";
    // }


    // echo $task;
    // }


 //    else if($_POST['formname']=='updateusersdata')
 //    {
	// 	$useremailcheck = pg_query_params($db,"select admin_name from admin_login where admin_name=$1 and
	// 	id!=$2",array($_POST['email'],$_POST['update_ids']));
	// 	$mailhave = pg_numrows($useremailcheck);
	// 	if($mailhave>0)
	// 	{
	// 	$task = "emailalready";
	// 	}
	// 	else
	// 	{

	// 		if($_POST['adminassigntypeup']=="ST")
	// 		{
	// 			$queryup=pg_query_params($db,"update admin_login set admin_name=$1 where id=$2",array($_POST['email'],$_POST['update_ids']));
	// 			if($queryup)
	// 			{
	// 			$task = "updatedata";
	// 			}
	// 			else
	// 			{
	// 			$task = "error";
	// 			}


	// 		}
	// 		else if($_POST['adminassigntypeup']=="DT")
	// 		{
	// 			$ids = implode(',',$_POST['linksDTID2021']);
	// 			$check = "select * from adminassignlist where adminids=".$_POST['update_ids']." and assignlistids IN (".$ids.") and
	// 			is_deleted=1";
	// 			$checkval = pg_query($db,$check);
	// 			$noofrows = pg_numrows($checkval);
	// 			if($noofrows>0)
	// 			{
	// 				while($dataresult = pg_fetch_array($checkval))
	// 				{
	// 				$final[] = $dataresult['assignlistids'];
	// 				}



	// 				$b=array_diff($_POST['linksDTID2021'],$final);
	// 				$result = array_values($b);

	// 				for($i=0;$i<count($result);$i++) 
	// 				{ 

	// 					if($i==count($result)-1) { 

	// 					$queryda .="(".$_POST['update_ids'].",".$result[$i].",1,'".$_POST['adminassigntypeup']."',".$_POST['stids'].",".$_POST['createdby'].")";

	// 					}
	// 					else 
	// 					{ 
	// 					$queryda .="(".$_POST['update_ids'].",".$result[$i].",1,'".$_POST['adminassigntypeup']."',".$_POST['stids'].",".$_POST['createdby']."),";
	// 					} 
	// 				} 
	// 				if(count($final)>0)
	// 				{
	// 				pg_query($db,'UPDATE adminassignlist SET is_deleted = 0 WHERE assignlistids IN (select assignlistids from adminassignlist where adminids='.$_POST['update_ids'].' and assignlistids NOT IN ('.implode(',',$final).'))') ;
	// 				}

	// 				$query = "insert into adminassignlist
	// 				(\"adminids\",\"assignlistids\",\"is_deleted\",\"assigntypedata\",\"stids\",\"createdby\") values ".$queryda."";

	// 				$result = pg_query($query);

	// 				if($result)
	// 				{
	// 				$task = "updatedata";
	// 				}
	// 				else
	// 				{
	// 				$task = "error";
	// 				}

	// 			}
	// 			else
	// 			{
	// 					pg_query($db,'UPDATE adminassignlist SET is_deleted = 0 WHERE assignlistids IN (select assignlistids from
	// 					adminassignlist where adminids='.$_POST['update_ids'].'') ;

	// 					for($i=0;$i<count($_POST['linksDTID2021']);$i++) { 
	// 					if($i==count($_POST['linksDTID2021'])-1) 
	// 					{ $queryda .="(".$_POST['update_ids'].",".$_POST['linksDTID2021'][$i].",1,'".$_POST['adminassigntypeup']."',".$_POST['stids'].",".$_POST['createdby'].")";
	// 					} else { 
	// 					$queryda .="(".$_POST['update_ids'].",".$_POST['linksDTID2021'][$i].",1,'".$_POST['adminassigntypeup']."',".$_POST['stids'].",".$_POST['createdby']."),";
	// 					} 
	// 					} 
	// 					$query="insert into adminassignlist (\"
	// 					adminids\",\"assignlistids\",\"is_deleted\",\"assigntypedata\",\"stids\",\"createdby\") values ".$queryda."";

	// 					$result = pg_query($query); 

	// 				if($result)
	// 				{
	// 				$task = " updatedata"; 
	// 				} 
	// 				else 
	// 				{ 
	// 				$task="error" ; 
	// 				} 
	// 			} 

	// 		}
	// 	}
	// 			 echo $task; 
	// } 

// else if($_POST['formname']=='updatedocumentsdata' ) {
// 	$task="" ;
            
// 				$checkval=pg_query($db, "select * from \" documentdata\" where \"documentdata\".\"doctitle\"='".$_POST['
//             doctitle']."\"documentdata\".\"docids\" !='".$_POST[' update_ids']."'"); 
// 			$valid=pg_numrows($checkval); 
//             if($valid>0)
// 			{
//             $task = "documentnamealready";
//             }
//             else 
// 			{

// 							if(isset($_FILES['docnotification']) && $_FILES['docnotification']['name']!='')
// 							{

// 							$foldername = $_POST['STIDS'];


					
// 							$structure = 'Alldocuments/'.$foldername.'';

// 								if (!file_exists("Alldocuments/". $foldername)) {
// 								mkdir("Alldocuments/". $foldername,0777, true);
// 								}
// 							$ext = pathinfo($_FILES['docnotification']['name'], PATHINFO_EXTENSION);

// 							$filename = $_POST['doctitle']." DT ".date("d-m-Y", strtotime($_POST['docdate'])).".".$ext ;

// 							$target = "Alldocuments/".$_POST['STIDS']."/".$filename;

// 								if(move_uploaded_file($_FILES['docnotification']['tmp_name'], $target))
// 								{

// 								$query = "Update documentdata set \"doctype\"='".$_POST['doctype']."',\"docdate\"='".date("Y-m-d",
// 								strtotime($_POST['docdate']))."',\"doctitle\"='".$_POST['doctitle']."',\"docdescription\"='".$_POST['docdescription']."',\"docnotification\"='".$filename."'
// 								where \"docids\"=".$_POST['update_ids']."";
// 								$result = pg_query($query);


// 								if($result)
// 								{
// 								$task = "updatedata";
// 								}
// 								else
// 								{
// 								$task = "error";
// 								}

// 								}
// 								else
// 								{
// 								$task = "fileuploadproblem";
// 								}

// 			}
//             else
//             {
//             $query = "Update documentdata set \"doctype\"='".$_POST['doctype']."',\"docdate\"='".date("Y-m-d",
//             strtotime($_POST['docdate']))."',\"doctitle\"='".$_POST['doctitle']."',\"docdescription\"='".$_POST['docdescription']."'
//             where \"docids\"=".$_POST['update_ids']."";
//             $result = pg_query($query);
//             if($result)
//             {
//             $task = "updatedata";
//             }
//             else
//             {
//             $task = "error";
//             }
//             }




//             }

//             echo $task;
//             }


            else if($_POST['formname']=='getdistlistusers')
            {
            $data = pg_query_params($db, 'select "DTID2021","DTName2021" from "dt2021" where "STID2021"=$1
            ORDER BY "dt2021"."DTID2021"',array($_POST['STID2021']));
            $dataresult = pg_fetch_all($data);

            $q='select array_to_string(array_agg(assignlistids),\',\') as list from adminassignlist where
            adminids=$1 and is_deleted=$2 GROUP BY adminids';
            $res = pg_query_params($db,$q,array($_POST['adminids'],1));
            $result = pg_fetch_array($res);

            $task = '';

            $task .='<label class="col-md-3 col-form-label">&nbsp;</label>
            <div class="col-md-9"><select multiple="multiple" id="linksDTID2021" name="linksDTID2021[]">';
                    foreach($dataresult as $key => $element) {
                    $task .='<option'; if(in_array($element['DTID2021'],explode(',',$result['list']))) { $task
                        .=' selected ' ; } $task .=' value="' .$element['DTID2021'].'">'.$element['DTName2021'].'
                        </option>';
                        }
                        $task .='</select></div>';

            echo json_encode($dataresult)."|".$task;
     
            }

            else if($_POST['formname']=='addgetdistlistusers')
            {
            $data = pg_query_params($db, 'select "DTID2021","DTName2021" from "dt2021" where "STID2021"=$1
            ORDER BY "dt2021"."DTID2021"',array($_POST['STID2021']));
            $dataresult = pg_fetch_all($data);

           
            $task = '';

            $task .='<label class="col-md-3 col-form-label">&nbsp;</label>
            <div class="col-md-9"><select multiple="multiple" id="addlinksDTID2021" name="addlinksDTID2021[]">';
                    foreach($dataresult as $key => $element) {
                    $task .='<option value="'.$element['DTID2021'].'">'.$element['DTName2021'].'
                        </option>';
                        }
                        $task .='</select></div>';

            echo json_encode($dataresult)."|".$task;
     
            }

            else if($_POST['formname']=='getdistlistdocument')
            {
             
            $data = pg_query_params($db, 'select "DTID2021","DTName2021" from "dt2021" where "STID2021"=$1
            ORDER BY "dt2021"."DTID2021"',array($_POST['STID2021']));
            $dataresult = pg_fetch_all($data);
          
            $task = '';

            $task .='<label class="col-md-3 col-form-label">&nbsp;</label>
            <div class="col-md-5"><select multiple="multiple" id="linksDTID2021" name="linksDTID2021[]">';
                 //  $task .='<option value="addnew">Add New</option>';
                    foreach($dataresult as $key => $element) {
                    $task .='<option value="'.$element['DTID2021'].'">'.$element['DTName2021'].'</option>';
                    }
                    $task .='</select></div><div class="col-md-4"><button type="button" onclick="addnewdistrict('.$_POST['STID2021'].')" name="addnew" class="btn btn-info waves-effect waves-light">Add New</button></div>';

            echo json_encode($dataresult)."|".$task;
           
            }

          

            else if($_POST['formname']=='getdistlist')
            {

            $where = "";
            if($_POST['DTID2021']!='')
            {
          //   $where = 'and "dt2021"."DTID2021" IN ('.$_POST['DTID2021'].')';

             $data = pg_query_params($db, 'select "DTID2021","DTName2021" from "dt2021" where "STID2021"=$1
            and "dt2021"."DTID2021" = Any(string_to_array($2::text, \',\'::text)::integer[])  ORDER BY "dt2021"."DTID2021"',array($_POST['STID2021'],$_POST['DTID2021']));

            }
            else
            {
            	 $data = pg_query_params($db, 'select "DTID2021","DTName2021" from "dt2021" where "STID2021"='.$_POST['STID2021'].'
             ORDER BY "dt2021"."DTID2021"',array($_POST['STID2021']));
            }
           
            $dataresult = pg_fetch_all($data);

            echo json_encode($dataresult);
            exit();
            }


              else if($_POST['formname']=='getdoclist')
            {

           
            $data = pg_query_params($db, 'select * from  where "STID2021"=$1
             ORDER BY "dt2021"."DTID2021"',array($_POST['STID2021']));
            $dataresult = pg_fetch_all($data);

            echo json_encode($dataresult);
            exit();
            }

            else if($_POST['formname']=='getsubdistlist')
            {
            $data = pg_query_params($db, 'select "SDID2021","SDName2021" from "sd2021" where "DTID2021"=$1
            ORDER BY "sd2021"."SDID2021"',array($_POST['DTID2021']));
            $dataresult = pg_fetch_all($data);

            echo json_encode($dataresult);
            exit();
            }

            else if($_POST['formname']=='getsubdistlistdocument')
            {
            $data = pg_query_params($db, 'select "SDID2021","SDName2021" from "sd2021" where "DTID2021"=$1
            ORDER BY "sd2021"."SDID2021"',array($_POST['DTID2021']));
            $dataresult = pg_fetch_all($data);

            $task = '';
            if(count($dataresult)>0)
            {
            $task .='<label class="col-md-3 col-form-label">&nbsp;</label>
            <div class="col-md-9"><select multiple="multiple" id="linksSDID2021" name="linksSDID2021[]">';
                    foreach($dataresult as $key => $element) {
                    $task .='<option value="'.$element['SDID2021'].'">'.$element['SDName2021'].'</option>';
                    }
                    $task .='</select></div>';
            }
            echo json_encode($dataresult)."|".$task;
            exit();
            }

            else if($_POST['formname']=='getvillagelistdocument')
            {
            $data = pg_query_params($db, 'select "VTID2021","VTName2021" from "vt2021" where "SDID2021"=$1
            ORDER BY "vt2021"."VTID2021"',array($_POST['SDID2021']));
            $dataresult = pg_fetch_all($data);
            $task = '';
            if(count($dataresult)>0)
            {
            $task .='<label class="col-md-3 col-form-label">&nbsp;</label>
            <div class="col-md-9"><select multiple="multiple" id="linksVTID2021" name="linksVTID2021[]">';
                    foreach($dataresult as $key => $element) {
                    $task .='<option value="'.$element['VTID2021'].'">'.$element['VTName2021'].'</option>';
                    }
                    $task .='</select></div>';
            }
            echo $task;
            exit();
            }

            else if($_POST['formname']=='getvtlist')
            {
            $data = pg_query_params($db, 'select "VTID2021","VTName2021" from "vt2021" where "SDID2021"=$1
            and "Level2021"=$2 ORDER BY "vt2021"."VTID2021"',array($_POST['SDID2021'],'TOWN'));
            $dataresult = pg_fetch_all($data);

            echo json_encode($dataresult);
            exit();
            }

            else if($_POST['formname']=='getstatus')
            {
            $data = pg_query_params($db, 'select DISTINCT("Status2021") FROM vt2021 where "Level2021"=$1 and "Status2021"
            !=$2 Group By "Status2021"',array('TOWN','null'));
            $dataresult = pg_fetch_all($data);
          
            echo json_encode($dataresult);
            exit();
            }

            // else if($_POST['formname']=='getstatuswd')
            // {
            // $data = pg_query_params($db, 'select DISTINCT("Status2021") FROM wd2021 where "Level2021"=\'WARD\' Group By
            // "Status2021"');
            // $dataresult = pg_fetch_all($data);
         
            // echo json_encode($dataresult);
            // exit();
            // }
          
            // else if($_POST['formname']=='linkedlinkdatas')
            // {
           
            // $task = "";
            // if($_POST['linkedcomefrom']=="ST")
            // {
            // $ids = implode(',',$_POST['ids']);
            // $query = "delete from documentlink where docids in (".$ids.") and linkstids=".$_POST['linkeddataids']." and
            // linkdtids=0 and linksdids=0 and linkvtids=0 and linkwdids=0";

            // }
            // else if($_POST['linkedcomefrom']=="DT")
            // {
            // $ids = implode(',',$_POST['ids']);
            // $query = "delete from documentlink where docids in (".$ids.") and linkstids=".$_POST['linkeddataids']." and
            // linkdtids=".$_POST['linkeddtdataids']." and linksdids=0 and linkvtids=0 and linkwdids=0";
            // }
            // else if($_POST['linkedcomefrom']=="SD")
            // {
            // $ids = implode(',',$_POST['ids']);
            // $query = "delete from documentlink where docids in (".$ids.") and linkstids=".$_POST['linkeddataids']." and
            // linkdtids=".$_POST['linkeddtdataids']." and linksdids=".$_POST['linkedsddataids']." and linkvtids=0 and
            // linkwdids=0";
            // }
            // else if($_POST['linkedcomefrom']=="VT")
            // {
            // $ids = implode(',',$_POST['ids']);
            // $query = "delete from documentlink where docids in (".$ids.") and linkstids=".$_POST['linkeddataids']." and
            // linkdtids=".$_POST['linkeddtdataids']." and linksdids=".$_POST['linkedsddataids']." and
            // linkvtids=".$_POST['linkedvtdataids']." and linkwdids=0";
            // }
            // else if($_POST['linkedcomefrom']=="WD")
            // {
            // $ids = implode(',',$_POST['ids']);
            // $query = "delete from documentlink where docids in (".$ids.") and linkstids=".$_POST['linkeddataids']." and
            // linkdtids=".$_POST['linkeddtdataids']." and linksdids=".$_POST['linkedsddataids']." and
            // linkvtids=".$_POST['linkedvtdataids']." and linkwdids=".$_POST['linkedwddataids']."";
            // }

            // $result = pg_query($query);

            // if($result)
            // {
            // $task = "unlinkdata";
            // }
            // else
            // {
            // $task = "error";
            // }
            // echo $task;
            // }
          
       //     else if($_POST['formname']=='linkdatas')
//             {
          
//             $task = "";
//             if($_POST['comefrom']=="ST")
//             {
//             $field = "linkstids =".$_POST['dataids']." and linkdtids=0 and linksdids=0 and linkvtids=0 and linkwdids=0";
//             $fields = "(\"docids\",\"linkstids\")";
//             }
//             else if($_POST['comefrom']=="DT")
//             {
//             $field = "linkstids =".$_POST['dataids']." and linkdtids = ".$_POST['datadtids']." and linksdids=0 and
//             linkvtids=0 and linkwdids=0";
//             $fields = "(\"docids\",\"linkstids\",\"linkdtids\")";
//             }
//             else if($_POST['comefrom']=="SD")
//             {
//             $field = "linkstids =".$_POST['dataids']." and linkdtids = ".$_POST['datadtids']." and linksdids =
//             ".$_POST['datasdids']." and linkvtids=0 and linkwdids=0";
//             $fields = "(\"docids\",\"linkstids\",\"linkdtids\",\"linksdids\")";
//             }
//             else if($_POST['comefrom']=="VT")
//             {
//             $field = "linkstids =".$_POST['dataids']." and linkdtids = ".$_POST['datadtids']." and linksdids =
//             ".$_POST['datasdids']." and linkvtids=".$_POST['datavtids']." and linkwdids=0";
//             $fields = "(\"docids\",\"linkstids\",\"linkdtids\",\"linksdids\",\"linkvtids\")";
//             }
//             else if($_POST['comefrom']=="WD")
//             {
//             $field = "linkstids =".$_POST['dataids']." and linkdtids = ".$_POST['datadtids']." and linksdids =
//             ".$_POST['datasdids']." and linkvtids=".$_POST['datavtids']." and linkwdids=".$_POST['datawdids']."";
//             $fields = "(\"docids\",\"linkstids\",\"linkdtids\",\"linksdids\",\"linkvtids\",\"linkwdids\")";
//             }

//             $ids = implode(',',$_POST['id']);
//             $query = 'select docids from documentlink where '.$field.' and docids in('.$ids.')';

//             $data = pg_query($db,$query);

//             while($dataresult = pg_fetch_array($data)) {
//             $final[] = $dataresult['docids'];
//             }

//             if(count($final)>0)
//             {
//             $b=array_diff($_POST['id'],$final);
//             $result = array_values($b);
//             }
//             else
//             {
//             $result = $_POST['id'];
//             }

//             for($i=0;$i<count($result);$i++) { if($_POST['comefrom']=="ST" ) { if($i==count($result)-1) { $queryda .="("
//                 .$result[$i].",".$_POST['dataids'].")"; } else { $queryda .="(" .$result[$i].",".$_POST['dataids']."),";
//                 } } else if($_POST['comefrom']=="DT" ) { if($i==count($result)-1) { $queryda .="("
//                 .$result[$i].",".$_POST['dataids'].",".$_POST['datadtids'].")"; } else { $queryda .="("
//                 .$result[$i].",".$_POST['dataids'].",".$_POST['datadtids']."),"; } } else if($_POST['comefrom']=="SD" )
//                 { if($i==count($result)-1) { $queryda .="("
//                 .$result[$i].",".$_POST['dataids'].",".$_POST['datadtids'].",".$_POST['datasdids'].")"; } else {
//                 $queryda .="(" .$result[$i].",".$_POST['dataids'].",".$_POST['datadtids'].",".$_POST['datasdids']."),";
//                 } } else if($_POST['comefrom']=="VT" ) { if($i==count($result)-1) { $queryda .="("
//                 .$result[$i].",".$_POST['dataids'].",".$_POST['datadtids'].",".$_POST['datasdids'].",".$_POST['datavtids'].")";
//                 } else { $queryda .="("
//                 .$result[$i].",".$_POST['dataids'].",".$_POST['datadtids'].",".$_POST['datasdids'].",".$_POST['datavtids']."),";
//                 } } else if($_POST['comefrom']=="WD" ) { if($i==count($result)-1) { $queryda .="("
//                 .$result[$i].",".$_POST['dataids'].",".$_POST['datadtids'].",".$_POST['datasdids'].",".$_POST['datavtids'].",".$_POST['datawdids'].")";
//                 } else { $queryda .="("
//                 .$result[$i].",".$_POST['dataids'].",".$_POST['datadtids'].",".$_POST['datasdids'].",".$_POST['datavtids'].",".$_POST['datawdids']."),";
//                 } } } $query="insert into documentlink " .$fields." values ".$queryda.""; 

// $result = pg_query($query); 

// if($result)
// {
// 	$task = " adddata"; } 
// 	else { $task="error" ; } 
// 	echo $task; 

// } 

	// else if($_POST['formname']=='getlinklist' ) { 
		
 //               $table='documentdata' ; 
	// 		   $primaryKey='docids' ; 
	// 		   $columns=array(
 //                array( 'db'=> 'docids','dt' => 0),
 //                array( 'db' => 'docids','dt' => 1),
 //                array( 'db' => 'docstid','dt' => 2),
 //                array( 'db' => 'doctype','dt' => 3),
 //                array( 'db' => 'docdate', 'dt' => 4,
 //                'formatter' => function( $d, $row ) {
 //                if (!is_null($d))
 //                return date( 'd-m-Y', strtotime($d));
 //                } ),
 //                array( 'db' => 'doctitle','dt' => 5),
 //                array( 'db' => 'docdescription','dt' => 6),
 //                array( 'db' => 'docnotification','dt' => 7),

 //                );
 //                $pg_details = $databaseinfo;

 //                $filtroAdd=" \"docstid\" = ".$_POST['STID2021']."";

 //                require( 'ssp.class.php' );

 //                echo json_encode(
 //                SSP::simple( $_POST, $pg_details, $table, $primaryKey, $columns,$filtroAdd)
 //                );

               
 //  }

                // else if($_POST['formname']=='getlinkedlist')
                // {
               

                // $table = 'documentdata';

              
                // $primaryKey = 'docids';

                // $columns = array(
                // array( 'db' => 'docids','dt' => 0),
                // array( 'db' => 'docids','dt' => 1),
                // array( 'db' => 'docstid','dt' => 2),
                // array( 'db' => 'doctype','dt' => 3),
                // array( 'db' => 'docdate', 'dt' => 4,
                // 'formatter' => function( $d, $row ) {
                // if (!is_null($d))
                // return date( 'd-m-Y', strtotime($d));
                // } ),
                // array( 'db' => 'doctitle','dt' => 5),
                // array( 'db' => 'docdescription','dt' => 6),
                // array( 'db' => 'docnotification','dt' => 7),

                // );
                // $pg_details = $databaseinfo;

                // if($_POST['linkedcomefrom']=="ST")
                // {
                // $filtroAdd = " \"documentdata\".\"docstid\" = ".$_POST['STID2021']." and docids IN (select docids from
                // documentlink where linkstids = ".$_POST['STID2021']." and linkdtids = 0 and linksdids = 0 and linkvtids
                // = 0 and linkwdids = 0)";
                // }
                // else if($_POST['linkedcomefrom']=="DT")
                // {
                // $filtroAdd = " \"documentdata\".\"docstid\" = ".$_POST['STID2021']." and docids IN (select docids from
                // documentlink where linkstids = ".$_POST['STID2021']." and linkdtids = ".$_POST['DTID2021']." and
                // linksdids = 0 and linkvtids = 0 and linkwdids = 0)";
                // }
                // else if($_POST['linkedcomefrom']=="SD")
                // {
                // $filtroAdd = " \"documentdata\".\"docstid\" = ".$_POST['STID2021']." and docids IN (select docids from
                // documentlink where linkstids = ".$_POST['STID2021']." and linkdtids = ".$_POST['DTID2021']." and
                // linksdids = ".$_POST['SDID2021']." and linkvtids = 0 and linkwdids = 0)";
                // }
                // else if($_POST['linkedcomefrom']=="VT")
                // {
                // $filtroAdd = " \"documentdata\".\"docstid\" = ".$_POST['STID2021']." and docids IN (select docids from
                // documentlink where linkstids = ".$_POST['STID2021']." and linkdtids = ".$_POST['DTID2021']." and
                // linksdids = ".$_POST['SDID2021']." and linkvtids = ".$_POST['VTID2021']." and linkwdids = 0)";
                // }

                // else if($_POST['linkedcomefrom']=="WD")
                // {
                // $filtroAdd = " \"documentdata\".\"docstid\" = ".$_POST['STID2021']." and docids IN (select docids from
                // documentlink where linkstids = ".$_POST['STID2021']." and linkdtids = ".$_POST['DTID2021']." and
                // linksdids = ".$_POST['SDID2021']." and linkvtids = ".$_POST['VTID2021']." and linkwdids =
                // ".$_POST['WDID2021'].")";
                // }

              

                // require( 'ssp.class.php' );

                // echo json_encode(
                // SSP::simple( $_POST, $pg_details, $table, $primaryKey, $columns,$filtroAdd)
                // );

               
                // }

                // else if($_POST['formname']=='addvillagesdata')
                // {

                // $checkval = pg_query($db, "select * from \"vt2021\" where \"vt2021\".\"VTName2021\" =
                // '".$_POST['addVTName2021']."' and \"vt2021\".\"STID2021\" = ".$_POST['addSTID2021']." and
                // \"vt2021\".\"DTID2021\" = ".$_POST['addDTID2021']." and \"vt2021\".\"SDID2021\" =
                // ".$_POST['addSDID2021']."");

                // $valid = pg_numrows($checkval);

                // if($valid>0)
                // {
                // $task = "vtnamealready";
                // }
                // else
                // {
                // $task = "";

                // if(isset($_POST['addStatus2021']) && trim($_POST['addStatus2021'])!='')
                // {
                // $query = "INSERT INTO vt2021
                // (\"STID2021\",\"DTID2021\",\"SDID2021\",\"VTID2021\",\"Short_VT2021\",\"MDDS_VT2021\",\"VTName2021\",\"Level2021\",\"Pop2021\",\"Status2021\",\"Area2021\",\"Remark1\",\"Remark2\")
                // values
                // (".$_POST['addSTID2021'].",".$_POST['addDTID2021'].",".$_POST['addSDID2021'].",".$_POST['addSDID2021']."".$_POST['addMDDS_VT2021'].",'".$_POST['addShort_VT2021']."','".$_POST['addMDDS_VT2021']."','".$_POST['addVTName2021']."','".$_POST['addLevel2021']."',".$_POST['addPop2021'].",'".trim($_POST['addStatus2021'])."',".$_POST['addArea2021'].",'".$_POST['addRemark1']."','".$_POST['addRemark2']."')";

                // }
                // else
                // {

                // $query = "INSERT INTO vt2021
                // (\"STID2021\",\"DTID2021\",\"SDID2021\",\"VTID2021\",\"Short_VT2021\",\"MDDS_VT2021\",\"VTName2021\",\"Level2021\",\"Pop2021\",\"Area2021\",\"Remark1\",\"Remark2\")
                // values
                // (".$_POST['addSTID2021'].",".$_POST['addDTID2021'].",".$_POST['addSDID2021'].",".$_POST['addSDID2021']."".$_POST['addMDDS_VT2021'].",'".$_POST['addShort_VT2021']."','".$_POST['addMDDS_VT2021']."','".$_POST['addVTName2021']."','".$_POST['addLevel2021']."',".$_POST['addPop2021'].",".$_POST['addArea2021'].",'".$_POST['addRemark1']."','".$_POST['addRemark2']."')";
                // }
                // $result = pg_query($query);
                // if($result)
                // {
                // $task = "adddata";
                // }
                // else
                // {
                // $task = "error";
                // }
                // }
                // echo $task;

                // }

                // else if($_POST['formname']=='addwarddata')
                // {

                // $checkval = pg_query($db, "select * from \"wd2021\" where \"wd2021\".\"WDName2021\" =
                // '".$_POST['addWDName2021']."' and \"wd2021\".\"STID2021\" = ".$_POST['addSTID2021']." and
                // \"wd2021\".\"DTID2021\" = ".$_POST['addDTID2021']." and \"wd2021\".\"SDID2021\" =
                // ".$_POST['addSDID2021']." and \"wd2021\".\"VTID2021\" = ".$_POST['addVTID2021']."");

                // $valid = pg_numrows($checkval);

                // if($valid>0)
                // {
                // $task = "wdnamealready";
                // }
                // else
                // {
                // $task = "";


                // $query = "INSERT INTO wd2021
                // (\"STID2021\",\"DTID2021\",\"SDID2021\",\"VTID2021\",\"WDID2021\",\"Short_WD2021\",\"MDDS_WD2021\",\"WDName2021\",\"Level2021\",\"Pop2021\",\"Status2021\",\"Area2021\",\"Remark1\",\"Remark2\")
                // values
                // (".$_POST['addSTID2021'].",".$_POST['addDTID2021'].",".$_POST['addSDID2021'].",".$_POST['addVTID2021'].",".$_POST['addSDID2021']."".$_POST['addMDDS_WD2021'].",'".$_POST['addShort_WD2021']."','".$_POST['addMDDS_WD2021']."','".$_POST['addWDName2021']."','".$_POST['addLevel2021']."',".$_POST['addPop2021'].",'".trim($_POST['addStatus2021'])."',".$_POST['addArea2021'].",'".$_POST['addRemark1']."','".$_POST['addRemark2']."')";


                // $result = pg_query($query);
                // if($result)
                // {
                // $task = "adddata";
                // }
                // else
                // {
                // $task = "error";
                // }
                // }
                // echo $task;

                // }


                // else if($_POST['formname']=='deletesd')
                // {
                // $task = "";


                // $query = "delete from sd2021 where \"SDID2021\"=".$_POST['deletedids']."";
                // $result = pg_query($query);
                // if($result)
                // {
                // $task = "deletedata";
                // }
                // else
                // {
                // $task = "error";
                // }


                // echo $task;
                // }

                // else if($_POST['formname']=='deletevt')
                // {
                // $task = "";


                // $query = "delete from vt2021 where \"VTID2021\"=$1";
                // $result = pg_query_params($db,$query,array($_POST['deletedids']));
                // $resultst_rows = pg_affected_rows($result);
                // if($resultst_rows!=0)
                // {
                // $task = "deletedata";
                // }
                // else
                // {
                // $task = "error";
                // }


                // echo $task;
                // }

                // else if($_POST['formname']=='deletewd')
                // {
                // $task = "";


                // $query = "delete from wd2021 where \"WDID2021\"=".$_POST['deletedids']."";
                // $result = pg_query($query);
                // if($result)
                // {
                // $task = "deletedata";
                // }
                // else
                // {
                // $task = "error";
                // }


                // echo $task;
                // }

                // else if($_POST['formname']=='deletedoc')
                // {
                // $task = "";


                // $query = "delete from documentdata where \"ID\"=".$_POST['deletedids']."";
                // $result = pg_query($query);
                // if($result)
                // {
                // $task = "deletedata";
                // }
                // else
                // {
                // $task = "error";
                // }


                // echo $task;
                // }

 //                else if($_POST['formname']=='documentlinkdata')
 //                {
              
 //                if(isset($_POST['linkSTID2021']))
 //                {


 //                $field = "linkstids";
 //                $fields = "(\"docids\",\"linkstids\")";


 //                $ids = implode(',',$_POST['linkSTID2021']);

 //                $query = 'select linkstids from documentlink where docids='.$_POST['docidsdata'].' and '.$field.'
 //                in('.$ids.')';
 //                $data = pg_query($db,$query);

 //                while($dataresult = pg_fetch_array($data)) {
 //                $final[] = $dataresult['linkstids'];
 //                }
             
 //                if(count($final)>0)
 //                {
 //                $b=array_diff($_POST['linkSTID2021'],$final);
 //                $result = array_values($b);
 //                }
 //                else
 //                {
 //                $result = $_POST['linkSTID2021'];
 //                }

 //                for($i=0;$i<count($result);$i++) { if($i==count($result)-1) { $queryda .="("
 //                    .$_POST['docidsdata'].",".$result[$i].")"; } else { $queryda .="("
 //                    .$_POST['docidsdata'].",".$result[$i]."),"; } } $query="insert into documentlink " .$fields."
 //                    values ".$queryda.""; 

	// 	$result = pg_query($query); 

	// }

	// if(isset($_POST['linksDTID2021']))
	// {	


	// 		$fields = " (\"docids\",\"linkstids\",\"linkdtids\")"; $ids=implode(',',$_POST['linksDTID2021']);
 //                    $query='select linkdtids from documentlink where docids=' .$_POST['docidsdata'].' and
 //                    linkstids='.$_POST[' lSTID2021'].' and linkdtids in('.$ids.')'; $data=pg_query($db,$query);
 //                    while($dataresult=pg_fetch_array($data)) { $final[]=$dataresult['linkdtids']; }
 //                    if(count($final)>0)
 //                    {
 //                    $b=array_diff($_POST['linksDTID2021'],$final);
 //                    $result = array_values($b);
 //                    }
 //                    else
 //                    {
 //                    $result = $_POST['linksDTID2021'];
 //                    }
                   
 //                    for($i=0;$i<count($result);$i++) { if($i==count($result)-1) { $queryda .="("
 //                        .$_POST['docidsdata'].",".$_POST['lSTID2021'].",".$result[$i].")"; } else { $queryda .="("
 //                        .$_POST['docidsdata'].",".$_POST['lSTID2021'].",".$result[$i]."),"; } }
 //                        $query="insert into documentlink " .$fields." values ".$queryda.""; 

	// 	$result = pg_query($query); 

	// }

	// if(isset($_POST['linksSDID2021']))
	// {
	// 	$fields = " (\"docids\",\"linkstids\",\"linkdtids\",\"linksdids\")"; $ids=implode(',',$_POST['linksSDID2021']);
 //                        $query='select linksdids from documentlink where docids=' .$_POST['docidsdata'].' and
 //                        linkstids='.$_POST[' lSTID2021'].' and linkdtids='.$_POST[' lDTID2021'].' and linksdids
 //                        in('.$ids.')'; $data=pg_query($db,$query); while($dataresult=pg_fetch_array($data)) {
 //                        $final[]=$dataresult['linksdids']; }  if(count($final)>0)
 //                        {
 //                        $b=array_diff($_POST['linksSDID2021'],$final);
 //                        $result = array_values($b);
 //                        }
 //                        else
 //                        {
 //                        $result = $_POST['linksSDID2021'];
 //                        }

 //                        for($i=0;$i<count($result);$i++) { if($i==count($result)-1) { $queryda .="("
 //                            .$_POST['docidsdata'].",".$_POST['lSTID2021'].",".$_POST['lDTID2021'].",".$result[$i].")"; }
 //                            else { $queryda .="("
 //                            .$_POST['docidsdata'].",".$_POST['lSTID2021'].",".$_POST['lDTID2021'].",".$result[$i]."),";
 //                            } } $query="insert into documentlink " .$fields." values ".$queryda.""; 

	// 	$result = pg_query($query); 

	// }

	// if(isset($_POST['linksVTID2021']))
	// {
	// 	$fields = " (\"docids\",\"linkstids\",\"linkdtids\",\"linksdids\",\"linkvtids\")";
 //                            $ids=implode(',',$_POST['linksVTID2021']);
 //                            $query='select linkvtids from documentlink where docids=' .$_POST['docidsdata'].' and
 //                            linkstids='.$_POST[' lSTID2021'].' and linkdtids='.$_POST[' lDTID2021'].' and
 //                            linkvtids='.$_POST[' lSDID2021'].' and linkvtids in('.$ids.')'; $data=pg_query($db,$query);
 //                            while($dataresult=pg_fetch_array($data)) { $final[]=$dataresult['linkvtids']; }  
	// 						if(count($final)>0)
 //                            {
 //                            $b=array_diff($_POST['linksVTID2021'],$final);
 //                            $result = array_values($b);
 //                            }
 //                            else
 //                            {
 //                            $result = $_POST['linksVTID2021'];
 //                            }

 //                            for($i=0;$i<count($result);$i++) { if($i==count($result)-1) { $queryda .="("
 //                                .$_POST['docidsdata'].",".$_POST['lSTID2021'].",".$_POST['lDTID2021'].",".$_POST['lSDID2021'].",".$result[$i].")";
 //                                } else { $queryda .="("
 //                                .$_POST['docidsdata'].",".$_POST['lSTID2021'].",".$_POST['lDTID2021'].",".$_POST['lSDID2021'].",".$result[$i]."),";
 //                                } } $query="insert into documentlink " .$fields." values ".$queryda.""; 

	// 	$result = pg_query($query); 

	// }

	// 	if($result)
	// 	{
	// 		$task = "adddata"; 
	// 	} 
	// 	else 
	// 	{ 
	// 		$task="error" ; 
	// 	} 
	// 		echo $task; 




	// } 

		// else if($_POST['formname']=='profile_change' ) {
  //                               $task='' ; $sql=mysqli_query($db,"select * from ".$admin_table." where
  //                               admin_name='".$_POST[' admin_name']."' and id!='".$_POST[' admin_ids']."'");
  //                               if(mysqli_num_rows($sql)>0)
  //                               {
  //                               $task = "email_already_existsts";
  //                               }
  //                               else{

  //                               $sql_ch = mysqli_query($db,"update ".$admin_table." set
  //                               admin_name='".$_POST['admin_name']."' , admin_name='".$_POST['admin_name']."' where
  //                               id='".$_POST['admin_ids']."'");
  //                               if($sql_ch==true)
  //                               {$task ='done_change';}
  //                               else
  //                               {$task ='server_prob';}

  //                               }
  //                               echo $task;
  //                               }

                                // else if($_POST['formname']=='change_password')
                                // {
                            
                                // $task='';
                                // $sql=mysqli_query($db,"select * from ".$admin_table." where
                                // admin_password='".md5($_POST['old_password'])."' and id='".$_POST['admin_ids']."'");
                                // if(mysqli_num_rows($sql)>0)
                                // {
                                // $sql_ch = mysqli_query($db,"update ".$admin_table." set
                                // admin_password='".md5($_POST['new_password'])."' ,
                                // admin_password1='".$_POST['new_password']."' where id='".$_POST['admin_ids']."'");
                                // if($sql_ch==true)
                                // {$task ='done_change';}
                                // else
                                // {$task ='server_prob';}

                                // }
                                // else{

                                // $task = "old_not_match";

                                // }
                                // echo $task;
                                // }
                                // else if($_POST['formname']=='updatewarddata')
                                // {


                                // $task = "";

                                // $checkvaldata = pg_query($db, "select * from \"wd2021\" where \"wd2021\".\"WDName2021\"
                                // = '".$_POST['WDName2021']."' and \"wd2021\".\"WDID2021\" = ".$_POST['update_ids']."");
                                // $data = pg_fetch_array($checkvaldata);

                                // $checkval = pg_query($db, "select * from \"wd2021\" where \"wd2021\".\"WDName2021\" =
                                // '".$_POST['WDName2021']."' and \"wd2021\".\"STID2021\" = '".$data['STID2021']."' and
                                // \"wd2021\".\"DTID2021\" = '".$data['DTID2021']."' and \"wd2021\".\"SDID2021\" =
                                // '".$data['SDID2021']."' and \"wd2021\".\"WDID2021\" != '".$_POST['update_ids']."'");
                                // $valid = pg_numrows($checkval);

                                // if($valid>0)
                                // {
                                // $task = "wdnamealready";
                                // }
                                // else {


                                // if(isset($_POST['Status2021']) && trim($_POST['Status2021'])!='')
                                // {
                                // $query = "Update wd2021 set
                                // \"Short_WD2021\"='".$_POST['Short_WD2021']."',\"MDDS_WD2021\"='".$_POST['MDDS_WD2021']."',\"Level2021\"='".$_POST['Level2021']."',\"Pop2021\"=".$_POST['Pop2021'].",\"Area2021\"=".$_POST['Area2021'].",\"WDName2021\"='".$_POST['WDName2021']."',\"Status2021\"='".$_POST['Status2021']."',\"Remark1\"='".$_POST['Remark1']."',\"Remark2\"='".$_POST['Remark2']."'
                                // where \"WDID2021\"=".$_POST['update_ids']."";
                                // }
                                // else
                                // {
                                // $query = "Update wd2021 set
                                // \"Short_wd2021\"='".$_POST['Short_wd2021']."',\"MDDS_wd2021\"='".$_POST['MDDS_wd2021']."',\"Level2021\"='".$_POST['Level2021']."',\"Pop2021\"=".$_POST['Pop2021'].",\"Area2021\"=".$_POST['Area2021'].",\"WDName2021\"='".$_POST['WDName2021']."',\"Remark1\"='".$_POST['Remark1']."',\"Remark2\"='".$_POST['Remark2']."'
                                // where \"WDID2021\"=".$_POST['update_ids']."";
                                // }

                                // $result = pg_query($query);
                                // if($result)
                                // {
                                // $task = "updatedata";
                                // }
                                // else
                                // {
                                // $task = "error";
                                // }
                                // }

                                // echo $task;

                                // }

//By sahana for AU state level.
else if ($_POST['formname'] == 'austform') {
	$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
	$tableName = 'dt' . (int)$_SESSION['activeyears'];
	$sql = 'SELECT "STID" FROM "' . $tableName . '" WHERE "STIDR" = $1';
	$sqlquery = pg_query_params($db, $sql, array($id));
	
	if ($sqlquery) {
		$data = pg_fetch_array($sqlquery);
		if ($data) {
			$ids = $data['STID'];
			$response = array('ids' => $ids);
			echo json_encode($response);
		} else {
			$response = array('error' => 'No result found for STIDR ' . $id);
			echo json_encode($response);
		}
	}
}
//By sahana for AU District level.
else if ($_POST['formname'] == 'audtform') {
	$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
	$tableName = 'sd' . (int)$_SESSION['activeyears'];
	$sql = 'SELECT "DTID" FROM "' . $tableName . '" WHERE "DTIDR" = $1';
	$sqlquery = pg_query_params($db, $sql, array($id));
	
	if ($sqlquery) {
		$data = pg_fetch_array($sqlquery);
		if ($data) {
			$ids = $data['DTID'];
			$response = array('ids' => $ids);
			echo json_encode($response);
		} else {
			$response = array('error' => 'No result found for STIDR ' . $id);
			echo json_encode($response);
		}
	}
}
//By sahana for AU Sub-District level.
else if ($_POST['formname'] == 'ausdform') {
	$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
	$tableName = 'vt' . (int)$_SESSION['activeyears'];
	$sql = 'SELECT "SDID" FROM "' . $tableName . '" WHERE "SDIDR" = $1';
	$sqlquery = pg_query_params($db, $sql, array($id));
	
	if ($sqlquery) {
		$data = pg_fetch_array($sqlquery);
		if ($data) {
			$ids = $data['SDID'];
			$response = array('ids' => $ids);
			echo json_encode($response);
		} else {
			$response = array('error' => 'No result found for STIDR ' . $id);
			echo json_encode($response);
		}
	}
}
//SR No. 9 by sahana
else if ($_POST['formname'] == 'sessiondetails') {
	$session = $_SESSION;

	if (!empty($session)) {
		$response = $session;
		echo json_encode($response);
	} else {
		$response = array('error' => 'No result found for session');
		echo json_encode($response);
	}
}
								?>