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
//$uploadfile = $uploaddir . $fileName;


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

$fname = $user_id.'.jpg';
$dirurl = '/uploads/ava/'.$fname;
$uploadfile = $uploaddir . $user_id.'.jpg';

move_uploaded_file($_FILES["upfile"]["tmp_name"], $uploadfile);

$db->Query("UPDATE db_users_b SET ava = '$fname' WHERE id = '$user_id'");
$db->Query("UPDATE db_users_a SET ava = '$dirurl' WHERE id = '$user_id'");
echo "<img src=\"/uploads/ava/" . $fname . "\">";