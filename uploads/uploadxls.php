<?php
session_start();

function __autoload($name){ include("../classes/_class.".$name.".php");}
$config = new config;
$func = new func;
$db = new db($config->HostDB, $config->UserDB, $config->PassDB, $config->BaseDB);
$pref = $config->BasePrefix;
$user_id = $_SESSION['user_id'];




$uploaddir = getcwd() . DIRECTORY_SEPARATOR . "ava" . DIRECTORY_SEPARATOR;
$fileName = basename($_FILES["upfile"]["name"]);
$uploadfile = $uploaddir . $fileName;


	  $mystring = $fileName;
	   $findme   = "`";
       $pos = strpos($mystring, $findme);
       
       if ($pos === false) {
            
        } else {
            
            exit;
            
        }
		
       $findme   = "'";
       $pos = strpos($mystring, $findme);
       
       if ($pos === false) {
            
        } else {
            
            exit;
            
        }
        
       $findme   = "=";
       $pos = strpos($mystring, $findme);
       
       if ($pos === false) {
            
        } else {
            
            exit;
            
        }


$uploadfile = '../upload.xlsx';
move_uploaded_file($_FILES["upfile"]["tmp_name"], $uploadfile);
/*
$db->Query("UPDATE db_users_b SET ava = '$fname' WHERE id = '$user_id'");
$db->Query("UPDATE db_users_a SET ava = '$dirurl' WHERE id = '$user_id'");
echo "<img src=\"/uploads/ava/" . $fname . "\">";
*/









$db->query("TRUNCATE `db_phone`");

require '../PhpSpreadsheet/vendor/autoload.php';


$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
$reader->setReadDataOnly(TRUE);


$spreadsheet = $reader->load('../upload.xlsx');

$worksheet = $spreadsheet->getActiveSheet();
$highestRow = $worksheet->getHighestRow(); // 总行数
$highestColumn = $worksheet->getHighestColumn(); // 总列数
$highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn); // e.g. 5

$lines = $highestRow - 2; 
if ($lines <= 0) {
    exit('Excel表格中没有数据');
}

$sql = "INSERT INTO `db_phone` (`npp`, `ls`, `phone`, `resultat`,`res`,`status`) VALUES ";

for ($row = 2; $row <= $highestRow; ++$row) {
    $npp = $worksheet->getCellByColumnAndRow(1, $row)->getValue(); //姓名
    $ls = $worksheet->getCellByColumnAndRow(2, $row)->getValue(); //语文
    $phone = $worksheet->getCellByColumnAndRow(3, $row)->getValue(); //数学
    $resultat = $worksheet->getCellByColumnAndRow(4, $row)->getValue(); //外语


if($resultat=='')
	$resultat = 'в очереди';
	
	if($resultat == 'в очереди')
	    $res = 0;
	if($resultat == 'недоступен')
	    $res = 1;
	if($resultat == 'прослушал')
	    $res = 2;
    if($resultat == 'отбился')
	    $res = 3;
    
    	
	$ls=mb_convert_encoding($ls,"Windows-1251","UTF-8");
	$phone=mb_convert_encoding($phone,"Windows-1251","UTF-8");
	$resultat=mb_convert_encoding($resultat,"Windows-1251","UTF-8");




    $sql .= "('$npp','$ls','$phone','$resultat','$res','0'),";
}
$sql = rtrim($sql, ","); //去掉最后一个,号
try {
    $db->query($sql);
    echo 'OK';
} catch (Exception $e) {
    echo $e->getMessage();
}