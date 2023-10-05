<?php 

function toPostgresArray($values) {
    $strArray = [];
    foreach ($values as $value) {
        if (is_int($value) || is_float($value)) {
            // For integers and floats, we can simply use strval().
            $str = strval($value);
        } else if (is_string($value)) {
            // For strings, we must first do some text escaping.
            $value = str_replace('\\', '\\\\', $value);
            $value = str_replace('"', '\\"', $value);
            $str = '"' . $value . '"';
        } else if (is_bool($value)) {
            // Convert the boolean value into a PostgreSQL constant.
            $str = $value ? 'TRUE' : 'FALSE';
        } else if (is_null($value)) {
            // Convert the null value into a PostgreSQL constant.
            $str = 'NULL';
        } else {
            throw new Exception('Unsupported data type encountered.');
        }
        $strArray[] = $str;
    }
    return '{' . implode(',', $strArray) . '}';
}
 
function array_dup($ar){
   return array_unique(array_diff_assoc($ar,array_unique($ar)));
}
function getToken($length){
  $token = "";
  $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
  $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
  $codeAlphabet.= "0123456789";
  $max = strlen($codeAlphabet); // edited

  for ($i=0; $i < $length; $i++) {
    $token .= $codeAlphabet[random_int(0, $max-1)];
  }

  return $token;
}

function createThumb($filepath, $thumbPath,$maxheight, $quality=100)
{   
            $created=false;
            $file_name  = pathinfo($filepath);  
           //  print_r($file_name);
			$format = $file_name['extension'];
            // Get new dimensions
          list($width, $height, $type, $attr) = getimagesize($filepath); 
		   $newH=$maxheight;
		$newW=($width/$height)*$newH;
		
		 //   $newW   = $maxwidth;
          //   $newH   = $maxheight;
			
            // Resample
            $thumb = imagecreatetruecolor($newW, $newH);
            $image = imagecreatefromstring(file_get_contents($filepath));
            list($width_orig, $height_orig) = getimagesize($filepath);
            imagecopyresampled($thumb, $image, 0, 0, 0, 0, $newW, $newH, $width_orig, $height_orig);

            // Output
            switch (strtolower($format)) {
                case 'png':
                imagepng($thumb, $thumbPath, 9);
                $created=true;
                break;

                case 'gif':
                imagegif($thumb, $thumbPath);
                $created=true;
                break;

                default:
                imagejpeg($thumb, $thumbPath, $quality);
                $created=true;
                break;
            }
            imagedestroy($image);
            imagedestroy($thumb);
            return $created;    
}
function image_upload_data($file_name,$image_path,$thumb_name,$random_name,$size_h)
{
			$final_video ='';
			$name1a=$_FILES[''.$file_name.'']['name'];

			$type1a=$_FILES[''.$file_name.'']['type'];

			$filename1a  = basename($_FILES[''.$file_name.'']['name']);

			$ext1a = pathinfo($filename1a, PATHINFO_EXTENSION);

			$cname1a=$random_name."_".date('dmYhi').".".$ext1a;

			$tmp_name1a=$_FILES[''.$file_name.'']['tmp_name'];

			$target_path1a="".$image_path."";

			$target_path1a=$target_path1a.$cname1a;	

		//	$filename = compress_image($_FILES["dp"]["tmp_name"], $target_path1a, 80); 	
			if (move_uploaded_file($_FILES[''.$file_name.'']['tmp_name'],$target_path1a))
			{ 
			 $final_video .=$cname1a;
			
			}
		else
			{
				$final_video .=0;
				// 
			}
			if($final_video!='0')
			{
$filepath="".$image_path."".$final_video."";
$thumbPath="".$image_path."".$thumb_name."".$final_video."";
$maxheight=$size_h;
		createThumb($filepath, $thumbPath,$maxheight, $quality=75);	
			}
		return $final_video;		
}
function image_upload_data_array($i,$file_name,$image_path,$thumb_name,$random_name,$size_h)
{
	
			$final_video ='';
			$name1a=$_FILES[''.$file_name.'']['name'][$i];

			$type1a=$_FILES[''.$file_name.'']['type'][$i];

			$filename1a  = basename($_FILES[''.$file_name.'']['name'][$i]);

			$ext1a = pathinfo($filename1a, PATHINFO_EXTENSION);

			$cname1a=$random_name."_".date('dmYhi').".".$ext1a;

			$tmp_name1a=$_FILES[''.$file_name.'']['tmp_name'][$i];

			$target_path1a="".$image_path."";

			$target_path1a=$target_path1a.$cname1a;	

		//	$filename = compress_image($_FILES["dp"]["tmp_name"], $target_path1a, 80); 	
			if (move_uploaded_file($_FILES[''.$file_name.'']['tmp_name'][$i],$target_path1a))
			{ 
			 $final_video .=$cname1a;
			
			}
		else
			{
				$final_video .=0;
				// 
			}
			
			
			
			
			if($final_video!='0')
			{
$filepath="".$image_path."".$final_video."";
$thumbPath="".$image_path."".$thumb_name."".$final_video."";
$maxheight=$size_h;
		createThumb($filepath, $thumbPath,$maxheight, $quality=75);	
			}
		return $final_video;		
} 

function image_upload_data_array_org($i,$file_name,$image_path,$thumb_name,$random_name,$size_h)
{
	
			$final_video ='';
			$name1a=$_FILES[''.$file_name.'']['name'][$i];

			$type1a=$_FILES[''.$file_name.'']['type'][$i];

			$filename1a  = basename($_FILES[''.$file_name.'']['name'][$i]);

			$ext1a = pathinfo($filename1a, PATHINFO_EXTENSION);

			$cname1a=$filename1a;

			$tmp_name1a=$_FILES[''.$file_name.'']['tmp_name'][$i];

			$target_path1a="".$image_path."";

			$target_path1a=$target_path1a.$cname1a;	

		//	$filename = compress_image($_FILES["dp"]["tmp_name"], $target_path1a, 80); 	
			if (move_uploaded_file($_FILES[''.$file_name.'']['tmp_name'][$i],$target_path1a))
			{ 
			 $final_video .=$cname1a;
			
			}
		else
			{
				$final_video .=0;
				// 
			}
			
			
			
			
			if($final_video!='0')
			{
$filepath="".$image_path."".$final_video."";
$thumbPath="".$image_path."".$thumb_name."".$final_video."";
$maxheight=$size_h;
		createThumb($filepath, $thumbPath,$maxheight, $quality=75);	
			}
		return $final_video;		
} 

function clean($string) {
   $string = str_replace(' ', '_', $string); // Replaces all spaces with hyphens.

  return preg_replace('/[^A-Za-z0-9\-]/', '_', $string); // Removes special chars.
} 
function delete($dbt,$dbtid,$db)
{
	
	   $fldlist = mysql_list_fields($db, $dbt);
	   $columns = mysql_num_fields($fldlist);
	   for ($i = 0; $i < $columns; $i++) 
	   {
		  $Listing[] = mysql_field_name($fldlist, $i);	
	   }
	
	   $sql="DELETE from $dbt where $Listing[0]=$dbtid";	
	   $result=mysql_query($sql);
	   return $result;
}
function CheckAvailability($tbl,$checkval,$db) //this function use for check the value of database is axit or not ,,Date::-8/6/2011
{
	$cond='';
	foreach ($checkval as $key =>$value)
	{
		$cond.= "$key"."='".pg_escape_string($value)."' and ";
	}
	$condition = substr($cond,0, strlen($cond)-4);
	//  echo "Select * from $tbl where $condition";
	$sql=pg_query($db,"Select * from $tbl where $condition");
	$cnt=pg_num_rows($sql);
	return $cnt;
}

function CheckAvailabilityOnUpdate($tbl,$checkval,$db,$id,$idval)  //this function use for update ,,Date::-8/6/2011
{
	foreach ($checkval as $key =>$value)
	{
		$cond.= $key."='".$value."' and ";
	}
	$condition = substr($cond,0, strlen($cond)-4);
	
	$condition.=" and ".$id ." != " . $idval;
	
	$sql=mysql_query("Select * from $db.$tbl where $condition");
	$cnt=mysql_num_rows($sql);
	return $cnt;
}

function getTblData($tbl,$checkval,$db,$orderfield,$ordertype) //this function used for retrive the data of database ,,Date::-8/6/2011
{
	$cond='';
	foreach ($checkval as $key =>$value)
	{
		$cond.= $key."='".pg_escape_string($value)."' and ";
	}
	
	$condition = substr($cond,0, strlen($cond)-4);
	
	if($orderfield !='' and $ordertype != '')
	{
	  $condition .= " order by ".$orderfield." ".$ordertype ;
	}
	//echo "select * from $db.$tbl where $condition";
	$sql=pg_query($db,"select * from $tbl where $condition");
	while($row=pg_fetch_array($sql))
	{
	  $data[] = $row;
	}
	
	return $data;	
	
}

function randomPrefix($length)  //this function used for generate the random password  ,,Date::-8/6/2011
{
	$random= "";
	
	srand((double)microtime()*1000000);
	
	$data = "AbcDE123IJKLMN67QRS@#$%TUVWXYZ";
	$data .= "aBCdefghijk@#$%lmn123opq45rs67tuv89wxyz";
	$data .= "0FGH45OP89@#$%";
	
	for($i = 0; $i < $length; $i++)
	{
	$random .= substr($data, (rand()%(strlen($data))), 1);
	}
	
	return $random;
}
function insert($dbt,$post,$db)
{
    $fldlist = mysql_list_fields($db, $dbt);
	$columns = mysql_num_fields($fldlist);
	for ($i = 0; $i < $columns; $i++) 
	{
		 $Listing[] = mysql_field_name($fldlist, $i);
			  
	}
	
	$str="";
	$colNames;
    for ($i = 1; $i < $columns; $i++) 
	{
		if($i==$columns-1)
		{
		   $str .="'".mysql_real_escape_string($post[$Listing[$i]])."'";
		   $colNames .= "`" .$Listing[$i] . "`";
		}
		else
		{
		   $str .="'".mysql_real_escape_string($post[$Listing[$i]])."',";	
		   $colNames .= "`" .$Listing[$i] . "`,";
		}
    }
 
    $sql="insert into $dbt ($colNames) values(".$str.")";
	//return $sql;	
	$result=mysql_query($sql);
    return $result;
}
function update_tbl_fields($dbt,$post,$fields,$dbtid,$dbtidval,$db)
{				 
	
	$cnt = count($fields);
	for($i=0;$i<$cnt;$i++)
	{
	  if($i == ($cnt - 1))
		   $str .="".$fields[$i]."='".mysql_real_escape_string($_POST[$fields[$i]])."'";	  
   	  else		
		   $str .="".$fields[$i]."='".mysql_real_escape_string($_POST[$fields[$i]])."',";	
	}
	
 	$sql="update  $dbt set ".$str." where $dbtid = '$dbtidval'"; 
	//return $sql;
    $result=mysql_query($sql);
    return $result;
}
function update($dbt,$post,$dbtid,$db)
{				 
	 $fldlist = mysql_list_fields($db, $dbt);
	 $columns = mysql_num_fields($fldlist);
	 for ($i = 0; $i < $columns; $i++) 
	 {
		 $Listing[] = mysql_field_name($fldlist, $i);			  
	 }			 
	 
	 $str="";
 	 for ($i = 1; $i < $columns; $i++) 
	 { 
		if($i==$columns-1)
		   $str .="".$Listing[$i]."='".mysql_real_escape_string($_POST[$Listing[$i]])."'";	  
		else		
		   $str .="".$Listing[$i]."='".mysql_real_escape_string($_POST[$Listing[$i]])."',";	
     }
	 
   $sql="update  $dbt set ".$str." where $Listing[0] = '$dbtid'";
     $result=mysql_query($sql);
     return $result;
}

 function get_compete($url)
    {
		$stat = 'rank';
        //$url = k_filter_url($url);
        
        $urlparts = explode('.', $url);
        while(count($urlparts) > 2)
        {
            array_shift($urlparts);
        }
        $url = implode('.', $urlparts);
       
		
        $compete_url = 'http://siteanalytics.compete.com/'.$url.'/';
		
        $furl = sprintf($compete_url, $url);
        
        // Check the page and validate - return data
        if(/*$contents = $this->getUrl($furl, $s)*/true)
        {
			$contents=getPageData($compete_url);
            preg_match_all('/number value\">([0-9,]*)/', $contents, $matches);

            if(($stat == 'unique') && (!empty($matches[1][0])))
            {
                return str_replace(',', '', ($matches[1][0]));
            }
            elseif(($stat == 'visitors') && (!empty($matches[1][1])))
            {
                return str_replace(',', '', ($matches[1][1]));
            }
            elseif(($stat == 'rank') && (!empty($matches[1][2])))
            {
                return str_replace(',', '', ($matches[1][2]));
            }
            else
            {
                return 0;
            }
        }
        else
        {
            return 0;
        } 
    }
    
function exportMysqlToCsv_santra_account($table)
{
	
	$filename ='Parasdham-users-'.date('d-m-Y').'.csv';

    $csv_terminated = "\n";
    $csv_separator = ",";
    $csv_enclosed = '"';
    $csv_escaped = "\\";
		$sql_query = "SELECT name,email,phone,city,country,profile_pic,token_type,active_user,created_date from paras_register";
 	
 	//echo $sql_query;
    // Gets the data from the database
    $result = mysql_query($sql_query);
    $fields_cnt = mysql_num_fields($result);
 
 
    $schema_insert = '';
 
    //for ($i = 0; $i < $fields_cnt; $i++)
    //{
        //$l = $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed,
          //  stripslashes(mysql_field_name($result, $i))) . $csv_enclosed;
      //  $schema_insert .= $l;
    //    $schema_insert .= $csv_separator;
  //  } // end for
 
$schema_insert .= 'Usernanme,Email,Phone,City,Country,Images,Device,Status(0=Pending 1=Approved 2=Rejected),Register Date,';	   
 $out = trim(substr($schema_insert, 0, -1));
    $out .= $csv_terminated;
 
    // Format the data
    while ($row = mysql_fetch_array($result))
    {
	   
        $schema_insert = '';
        for ($j = 0; $j < $fields_cnt; $j++)
        {
		    if ($row[$j] == '0' || $row[$j] != '')
            {
				
                if ($csv_enclosed == '')
                {
					$schema_insert .= iconv('UTF-8', 'ISO-8859-1//TRANSLIT',$row[$j]);
                }
				 else
                {
					$schema_insert .= $csv_enclosed . 
					str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, iconv('UTF-8', 'ISO-8859-1//TRANSLIT',$row[$j])) . $csv_enclosed;
                }
            } 
			else
            {
                $schema_insert .= '';
            }
			
		
 
            if ($j < $fields_cnt - 1)
            {
                $schema_insert .= $csv_separator;
            }
        } // end for
 
        $out .= $schema_insert;
		
        $out .= $csv_terminated;
    } // end while


    // vulnerability issue : Sensitive data exposure by veena
    header("Cache-Control: no-cache, no-store, must-revalidate, post-check=0, pre-check=0");


    header("Content-Length: " . strlen($out));
    // Output to browser with appropriate mime type, you choose ;)
    header("Content-type: text/x-csv");
    //header("Content-type: text/csv");
    //header("Content-type: application/csv");
    header("Content-Disposition: attachment; filename=$filename");
    echo $out;
    exit;
	

 
}

function Get_Subscriber($table)
{
	
	$filename ='Subscriber-'.date('d-m-Y').'.csv';

    $csv_terminated = "\n";
    $csv_separator = ",";
    $csv_enclosed = '"';
    $csv_escaped = "\\";
		$sql_query = "SELECT email from fodmap_subscribe where email!='' group By email Order By id Desc";
 	
 	//echo $sql_query;
    // Gets the data from the database
    $result = mysql_query($sql_query);
    $fields_cnt = mysql_num_fields($result);
 
 
    $schema_insert = '';
 
    //for ($i = 0; $i < $fields_cnt; $i++)
    //{
        //$l = $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed,
          //  stripslashes(mysql_field_name($result, $i))) . $csv_enclosed;
      //  $schema_insert .= $l;
    //    $schema_insert .= $csv_separator;
  //  } // end for
 
$schema_insert .= 'Email,';	   
 $out = trim(substr($schema_insert, 0, -1));
    $out .= $csv_terminated;
 
    // Format the data
    while ($row = mysql_fetch_array($result))
    {
	   
        $schema_insert = '';
        for ($j = 0; $j < $fields_cnt; $j++)
        {
		    if ($row[$j] == '0' || $row[$j] != '')
            {
				
                if ($csv_enclosed == '')
                {
					$schema_insert .= iconv('UTF-8', 'ISO-8859-1//TRANSLIT',$row[$j]);
                }
				 else
                {
					$schema_insert .= $csv_enclosed . 
					str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, iconv('UTF-8', 'ISO-8859-1//TRANSLIT',$row[$j])) . $csv_enclosed;
                }
            } 
			else
            {
                $schema_insert .= '';
            }
			
		
 
            if ($j < $fields_cnt - 1)
            {
                $schema_insert .= $csv_separator;
            }
        } // end for
 
        $out .= $schema_insert;
		
        $out .= $csv_terminated;
    } // end while

    // vulnerability issue : Sensitive data exposure by veena

    header("Cache-Control: no-cache, no-store, must-revalidate, post-check=0, pre-check=0");
	
    header("Content-Length: " . strlen($out));
    // Output to browser with appropriate mime type, you choose ;)
    header("Content-type: text/x-csv");
    //header("Content-type: text/csv");
    //header("Content-type: application/csv");
    header("Content-Disposition: attachment; filename=$filename");
    echo $out;
    exit;
	

 
}

// image_resize('file_name','image_path','img_size_h','random_name')
function image_resize($file_name,$image_path,$img_size_h,$random_name)
		{
		$image = "";
		$files_not_uploaded = "";
		$img_dirlarge="".$image_path."";
		$filename1 = basename($_FILES[''.$file_name.'']['name']);
		$ffff = pathinfo($filename1, PATHINFO_FILENAME);
		$ext1 = pathinfo($filename1, PATHINFO_EXTENSION);
		$image_filePath=$_FILES[''.$file_name.'']['tmp_name'];
		$krowAvatar=$random_name."_".date('dmYhi').".".$ext1;
		$img_thumbLarge = $img_dirlarge . $krowAvatar;
		$extension = strtolower($ext1);
		if(in_array($extension , array('jpg','jpeg', 'gif', 'png', 'bmp')))
		{
		list($gotwidth, $gotheight, $gottype, $gotattr)= getimagesize($_FILES[''.$file_name.'']['tmp_name']);
		if($extension=="jpg" || $extension=="jpeg" ){
		$src = imagecreatefromjpeg($_FILES[''.$file_name.'']['tmp_name']);
		}
		else if($extension=="png"){
		$src = imagecreatefrompng($_FILES[''.$file_name.'']['tmp_name']);
		}
		else{
		$src = imagecreatefromgif($_FILES[''.$file_name.'']['tmp_name']);
		}
		list($width,$height)=getimagesize($_FILES[''.$file_name.'']['tmp_name']);
		//$newwidthLarge = 300;
		$newheightLarge=$img_size_h;
		$newwidthLarge=($width/$height)*$newheightLarge;
		if($extension=="png")
		{
		$tmp1=imagecreate($newwidthLarge,$newheightLarge);
		$color = imagecolorallocatealpha($tmp1, 0, 0, 0, 127);
		imagefill($tmp1, 0, 0, $color);	
		} 
		else 
		{
		$tmp1=imagecreatetruecolor($newwidthLarge,$newheightLarge);
		}
		imagecopyresampled($tmp1,$src,0,0,0,0,$newwidthLarge,$newheightLarge, $width,$height);
		if($extension=="jpg" || $extension=="jpeg" )
		{
		imagejpeg($tmp1,$img_thumbLarge);
		}
		else if($extension=="png")
		{
		imagepng($tmp1,$img_thumbLarge);
		}
		else 
		{
		imagegif($tmp1,$img_thumbLarge);
		} 
		imagedestroy($src);
		
		imagedestroy($tmp1);
		}
		return $krowAvatar;		
		}
		
		// image_original('file_name','image_path','random_name')
function image_original($file_name,$image_path,$random_name)
{
			$final_video ='';
			$name1a=$_FILES[''.$file_name.'']['name'];

			$type1a=$_FILES[''.$file_name.'']['type'];

			$filename1a  = basename($_FILES[''.$file_name.'']['name']);

			$ext1a = pathinfo($filename1a, PATHINFO_EXTENSION);

			$cname1a=$random_name."_".date('dmYhi').".".$ext1a;

			$tmp_name1a=$_FILES[''.$file_name.'']['tmp_name'];

			$target_path1a="".$image_path."";

			$target_path1a=$target_path1a.$cname1a;	

		//	$filename = compress_image($_FILES["dp"]["tmp_name"], $target_path1a, 80); 	
			if (move_uploaded_file($_FILES[''.$file_name.'']['tmp_name'],$target_path1a))
			{ 
			 $final_video .=$cname1a;
			
			}
		else
			{
				$final_video .=0;
				// 
			}
			
		return $final_video;		
}


// image_resize('file_name','image_path','img_size_h','random_name')
function image_resize_array($file_name,$image_path,$img_size_h,$random_name,$i)
		{
		$image = "";
		$files_not_uploaded = "";
		$img_dirlarge="".$image_path."";
		$filename1 = basename($_FILES[''.$file_name.'']['name'][$i]);
		$ffff = pathinfo($filename1, PATHINFO_FILENAME);
		$ext1 = pathinfo($filename1, PATHINFO_EXTENSION);
		$image_filePath=$_FILES[''.$file_name.'']['tmp_name'][$i];
		$krowAvatar=$i.$random_name."_".date('dmYhi').".".$ext1;
		$img_thumbLarge = $img_dirlarge . $krowAvatar;
		$extension = strtolower($ext1);
		if(in_array($extension , array('jpg','jpeg', 'gif', 'png', 'bmp')))
		{
		list($gotwidth, $gotheight, $gottype, $gotattr)= getimagesize($_FILES[''.$file_name.'']['tmp_name'][$i]);
		if($extension=="jpg" || $extension=="jpeg" ){
		$src = imagecreatefromjpeg($_FILES[''.$file_name.'']['tmp_name'][$i]);
		}
		else if($extension=="png"){
		$src = imagecreatefrompng($_FILES[''.$file_name.'']['tmp_name'][$i]);
		}
		else{
		$src = imagecreatefromgif($_FILES[''.$file_name.'']['tmp_name'][$i]);
		}
		list($width,$height)=getimagesize($_FILES[''.$file_name.'']['tmp_name'][$i]);
		//$newwidthLarge = 300;
		$newheightLarge=$img_size_h;
		$newwidthLarge=($width/$height)*$newheightLarge;
		if($extension=="png")
		{
		$tmp1=imagecreate($newwidthLarge,$newheightLarge);
		$color = imagecolorallocatealpha($tmp1, 0, 0, 0, 127);
		imagefill($tmp1, 0, 0, $color);	
		} 
		else 
		{
		$tmp1=imagecreatetruecolor($newwidthLarge,$newheightLarge);
		}
		imagecopyresampled($tmp1,$src,0,0,0,0,$newwidthLarge,$newheightLarge, $width,$height);
		if($extension=="jpg" || $extension=="jpeg" )
		{
		imagejpeg($tmp1,$img_thumbLarge);
		}
		else if($extension=="png")
		{
		imagepng($tmp1,$img_thumbLarge);
		}
		else 
		{
		imagegif($tmp1,$img_thumbLarge);
		} 
		imagedestroy($src);
		
		imagedestroy($tmp1);
		}
		return $krowAvatar;		
		}
		
		// image_original('file_name','image_path','random_name')
function image_original_array($file_name,$image_path,$random_name,$i)
{
			$final_video ='';
			$name1a=$_FILES[''.$file_name.'']['name'][$i];

			$type1a=$_FILES[''.$file_name.'']['type'][$i];

			$filename1a  = basename($_FILES[''.$file_name.'']['name'][$i]);

			$ext1a = pathinfo($filename1a, PATHINFO_EXTENSION);

			$cname1a=$i.$random_name."_".date('dmYhi').".".$ext1a;

			$tmp_name1a=$_FILES[''.$file_name.'']['tmp_name'][$i];

			$target_path1a="".$image_path."";

			$target_path1a=$target_path1a.$cname1a;	

		//	$filename = compress_image($_FILES["dp"]["tmp_name"], $target_path1a, 80); 	
			if (move_uploaded_file($_FILES[''.$file_name.'']['tmp_name'][$i],$target_path1a))
			{ 
			 $final_video .=$cname1a;
			
			}
		else
			{
				$final_video .=0;
				// 
			}
			
		return $final_video;		
}

// $url_cat = get_URL()."/profile_pic/".$sql_query_data['profile_pic'];
function get_URL()
{
 $url  = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
$url .= $_SERVER['SERVER_NAME'];
$url .= $_SERVER['REQUEST_URI'];

return dirname(dirname($url));	
}

?>