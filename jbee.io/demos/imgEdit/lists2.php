<html>
<head>
<?php
if(isset($_GET["show"])){echo '<META NAME="ROBOTS" CONTENT="NOINDEX, FOLLOW"><script src="http://www.caridadcharity.com/importMe/jquery-1.3.2.min.js" type="text/javascript"></script><script src="admin.js" type="text/javascript"></script>';}
else{echo '<META HTTP-EQUIV="Refresh" Content="0; URL=http://www.oasis-ad.com">';exit;}

function alert($show){echo '<script>alert("'.$show.'");</script>';}
function decodeQ($str){return $str;if($str.length == 0){
	//return $str;}
}
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
$key = array('%21','%2A','%27','%28','%29','%3B','%3A','%40','%26','%3D','%2B','%24','%2C','%2F','%3F','%25','%23','%5B','%5D','%7E','+','%3C','%3E');$replace=array('!','*',"'","(",")",";",":","@","&","=","+","$",",","/","?","%","#","[","]","~"," ","<",">");	return str_replace($key, $replace, $str);}
/////DATABASE CONNECT
$show =  explode("-", $_GET["show"]);
$hn="localhost";
$un="markmorr_SQL1";
$pd="OASIS-ad0920";
$db="markmorr_COPY";
$con = mysql_connect($hn,$un, $pd); 
if(!$con){ die('Could not connect: ' . mysql_error());}
else{mysql_select_db($db, $con);}
/////BEGIN
//lists.php?show=projView-projId-frameOF-idString&add=name%%website%%phone%%txt
$what = strtolower( $show[2]);
$divStr = "";

if($show[0]=='projPPL'){
	$what = strtolower( $show[2]);
	$projId = $show[1];$divWidth = 175;$divHeight = 30;$margin=",'margin':10";$isFrame=",'isFrame':true";	
	$dButton = 'background:url(../graphics/smallActionBtns.png) repeat 0 40px; cursor:pointer; height:20px; overflow:hidden; width:20px; 			                position:absolute; right:5px;top:5px;';$allPeople=array();
	if(isset($_GET["add"])){ $addMe = explode('~,', $_GET["add"]);
	 ///$addMe[0] = decodeQ($addMe[0]);	$addMe[1] = decodeQ($addMe[1]);	$addMe[2] = decodeQ($addMe[2]);	$addMe[3] = decodeQ($addMe[3]);	
	 alert($addMe[0].$show[2]);
	$insert = "INSERT INTO  teamEXT (name,ttype,website,number,txt,person,projects) VALUES ('";
	$values = $addMe[0]."','".$show[2]."','".$addMe[1]."','".$addMe[2]."','".$addMe[3]."','".$addMe[4]."','".$show[1]."');"; 
	echo $insert.$values;
		    mysql_query($insert.$values);
	$result = mysql_query('SELECT id FROM teamEXT WHERE name = \''.$addMe[0].'\' AND ttype = \''.$show[2].'\'');
	$row = mysql_fetch_array($result, MYSQL_BOTH);	$addID = $row[id];
	$confirmAdd = 'parent.addPeople("'.$show[2].'","'.$addID.'","'.$addMe[0].'");';	$newPpl = array($addMe[0],$addID);
	array_push($allPeople, $newPpl);}
$idString= explode(",", $show[3]);
foreach($idString as $i){if($i != ""){
$Qstring = "SELECT name FROM teamEXT WHERE id='".($i)."'"; $result = mysql_query($Qstring);
$row = mysql_fetch_array($result, MYSQL_BOTH);	if(isset($row[name])){$newPpl = array($row[name],$i);array_push($allPeople, $newPpl);}}}
$divStr=""; foreach($allPeople as $i){$divStr = $divStr.'<div class="item" title="'.$i[1].'"><div class="iI"><span class="frmt">'.$i[0].'</span><div class="dBtn"></div></div></div>';}
}
if($show[0]=='catProj'){
	$what = 'pFRM'.$show[1];
	$pos = explode(',',$show[2]);
	$divWidth = 195;$divHeight = 120;$margin=",'margin':10";$isFrame=",'isFrame':true";	
	$dButton = 'background:url(../graphics/editButtons.png) repeat 0 122px;width:28px;height:30px;cursor:pointer';
			$allProj=array();	 
			 $Qstring = 'SELECT name,description,pId,thmb FROM portfolio WHERE category='.$show[1];
			 $result = mysql_query($Qstring);
			 
			 while($projs=mysql_fetch_array($result)){ 
					$dName = str_replace(' ', '',strtolower($projs[name]));
					if(in_array($projs[pId],$pos))
						{	
							$idx = array_search($projs[pId],$pos);
							if($projs[thmb]!= '%')
							{
								$img = '<img src="../portfolio/'.$dName.'/'.$projs[thmb].'" class="pImg">';
							}
							$allProj[$idx] = array($projs[pId],$projs[name],$img);							
						}
					else{
							//deleteProject($dName,$projs[pId]);
						}
			 			ksort($allProj);
			 }
				
				foreach($allProj as $i)
				{					
					$divStr = $divStr.'<div class="item" title="'.$i[0].'"><table><tr><td colspan="2" class="pTxt">'.$i[1].'</td></tr>
<tr><td width="150px">'.$i[2].'</td><td valign="top"><div class="eBtn" title="'.$i[0].'"></div><br><div class="dBtn"></div></td></tr></table></div>';
					
				}		
}

if($show[0]=='allPPL'){
	$what = strtolower( $show[1]);
	$divWidth = 175;$divHeight = 200;$margin=",'margin':10";$isFrame=",'isFrame':true";	
	$dButton = 'background:url(../graphics/smallActionBtns.png) repeat 0 40px; cursor:pointer; height:20px; overflow:hidden; width:20px; 			                position:absolute; right:5px;top:5px;';$allPeople=array();
	
  $Qstring = "SELECT * FROM teamEXT where ttype = '".$what."' ORDER BY tOrder";
   $result = mysql_query($Qstring);
	 while($cat=mysql_fetch_array($result)){
	 array_push($allPeople, array($cat[show],$cat[website],$cat[name],$cat[txt],$cat[person],$cat['2ndInfo'],str_replace('.','',$cat[number]),$cat[number]));	
	 		 
			 }	
$divStr=""; foreach($allPeople as $i){$divStr = $divStr.'<div class="item" title="'.$i[2].'"><div class="iI"><span class="frmt2">
<textarea>'.$i[2].'</textarea><br>
<textarea>'.$i[1].'</textarea><br>
<textarea>'.$i[3].'</textarea><br>
<textarea>'.$i[4].'</textarea><br>
<textarea>'.$i[6].'</textarea><br>
</span>
show <input type="checkbox" name="vehicle" value="Car">
<input></input>
<div class="dBtn"></div></div></div>';}
}
?>

<script>

var currentProj = "<?php echo $projId;?>";
var currentCat = "<?php echo $show[1];?>";
$(document).ready(function()
{
<?php echo $confirmAdd;?> 
	$('#<?php echo $what?>List').dragSort({'name':<?php echo '\''.$what.'\''.$isFrame.$margin;?>,'iClass':'item','dH':<?php echo $divHeight ?>,'dW':<?php echo $divWidth?>});
	$('.dBtn').css('opacity','0.5').mouseenter(function(){$(this).css('opacity','1');}).mouseleave(function(){$(this).fadeTo('fast',0.5);});
	
	$('.eBtn').click(function(){parent.showProjPU($(this).attr('title'));})
				      .mouseenter(function() {$(this).css('backgroundPosition', '0px 30px');})
   			 		 .mouseleave(function(){$(this).css('backgroundPosition', '0px 61px');});
	
});
</script>
<style>
*{margin:0px;}
.item{background-color:#e7e7e7;border-bottom:1px dotted #bbb;border-top:1px dotted #bbb;cursor:move;overflow:hidden;
height:<?php echo $divHeight ?>px;width:<?php echo $divWidth ?>px;}
.iI{position:relative;width:100%;height:100%;color:#888;font-size:13px;font-weight:bold;}
.frmt{width:125px;px;color:#888;font-size:13px;font-weight:bold;display:block;padding-left:7px;padding-top:6px;overflow:hidden;height:23px;}
.frmt2{width:125px;px;color:#888;font-size:13px;font-weight:bold;display:block;padding-left:7px;padding-top:6px;overflow:hidden;height:180px;}
.frmt2 textarea{font-size:14px;font-weight:bolder;text-transform:uppercase;line-height:14px;color:fff;text-decoration:none;letter-spacing:0;background-color:#a1a3a5;}
.eBtn{background:url(../graphics/editButtons.png) repeat 0 61px;width:28px;height:30px;cursor:pointer}
.pTxt{text-transform:uppercase;color:#979797;font-size:20px;line-height:21px;
letter-spacing:-2px;font-weight:bold;
font-family:"Arial Narrow", Helvetica, sans-serif;}
.pImg{border:1px solid #666;}
.dBtn{<?php echo $dButton;?>}
</style>
<div style="position:relative;width:<?php echo $divWidth?>px;height:auto;">
<?php echo '<div id="'.$what.'List" class="dragList">'.$divStr.'</div>'?>
</div>
