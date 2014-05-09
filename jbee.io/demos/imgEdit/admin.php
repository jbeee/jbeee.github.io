<?php
function cSQL($w)
{$hn="localhost";$un="markmorr_SQL1";$pd="OASIS-ad0920";$db="markmorr_".$w;$con = mysql_connect($hn,$un, $pd); 
if(!$con){ die('Could not connect: ' . mysql_error());}else{mysql_select_db($db, $con);}
}

function decodeQ($str){ 
$key = array('%21','%2A','%27','%28','%29','%3B','%3A','%40','%26','%3D','%2B','%24','%2C','%2F','%3F','%25','%23','%5B','%5D','%7E','+','%3C','%3E','%34');$replace=array('!','*',"'","(",")",";",":","@","&","=","+","$",",","/","?","%","#","[","]","~"," ","<",">",'"');
return str_replace($key, $replace, $str);}

function alert($show){echo '<script>alert("'.$show.'");</script>';}


/*function deleteProject($dName,$pId)
{
	$dir = '../portfolio/'.$dName;
	if(is_dir($dir))
	{
		foreach (scandir($dir) as $item) {
  		  if ($item == '.' || $item == '..') continue; unlink($dir.DIRECTORY_SEPARATOR.$item);}
		rmdir($dir);
	}
	$deleteImgSQL = 'DELETE FROM portImg WHERE pID='.$pId; mysql_query($deleteImgSQL);
	$deleteProjSQL = 'DELETE FROM portfolio WHERE pID='.$pId;mysql_query($deleteProjSQL);
}*/

/*function deleteProject($dName,$pId)
{
	$dir = '../portfolio/'.$dName;
	if(is_dir($dir))
	{
		foreach (scandir($dir) as $item) {
  		  if ($item == '.' || $item == '..') continue; unlink($dir.DIRECTORY_SEPARATOR.$item);}
		rmdir($dir);
	}
	$deleteImgSQL = 'DELETE FROM portImg WHERE pID='.$pId; mysql_query($deleteImgSQL);
	$deleteProjSQL = 'DELETE FROM portfolio WHERE pID='.$pId;mysql_query($deleteProjSQL);
}*/

?>