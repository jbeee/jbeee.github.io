<html>
<head>
<?php
if(isset($_GET["show"])){echo '<META NAME="ROBOTS" CONTENT="NOINDEX, FOLLOW"><script src="http://www.caridadcharity.com/importMe/jquery-1.3.2.min.js" type="text/javascript"></script><script src="admin.js" type="text/javascript"></script>';}
else{echo '<META HTTP-EQUIV="Refresh" Content="0; URL=http://www.oasis-ad.com">';exit;}

/////DATABASE CONNECT

include 'admin.php';cSQL('COPY');
$show =  explode("-", $_GET["show"]);
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
	$what = strtolower( $show[2]);
	$divWidth = 175;$divHeight = 100;$margin=",'margin':10";$isFrame=",'isFrame':true";	
	$dButton = 'background:url(../graphics/smallActionBtns.png) repeat 0 40px; cursor:pointer; height:20px; overflow:hidden; width:20px; 			                position:absolute; right:5px;top:5px;';$allPeople=array();
	
$Qstring = "SELECT name FROM teamEXT WHERE id='".($i)."'"; $result = mysql_query($Qstring);
$row = mysql_fetch_array($result, MYSQL_BOTH);	
$divStr=""; foreach($allPeople as $i){$divStr = $divStr.'<div class="item" title="'.$i[1].'"><div class="iI"><span class="frmt">'.$i[0].'</span><div class="dBtn"></div></div></div>';}
}

if($show[0]=='allM'){
	$what = 'pFRM'.$show[1];
	$pos = explode(',',$show[2]);
	$divWidth = 267;$divHeight = 105;$margin=",'margin':10";$isFrame=",'isFrame':true";	
	$dButton = 'background:url(../graphics/editButtons.png) repeat 0 122px;width:28px;height:30px;cursor:pointer';
			$allProj=array();	 
			 $Qstring = 'SELECT realtor,location,size,pId,thmb,name FROM portfolio WHERE category='.$show[1];
			 $result = mysql_query($Qstring);
			 
			 while($projs=mysql_fetch_array($result)){ 
					$dName = str_replace(' ', '',strtolower($projs[name]));
					if(in_array($projs[pId],$pos))
						{	
							$idx = array_search($projs[pId],$pos);
							if($projs[thmb]!= '%')
							{
								$img = '<img src="../portfolio/'.$dName.'/'.$projs[thmb].'" class="mImg">';
							}
							$allProj[$idx] = array($projs[pId],$projs[realtor],$img,$projs[location],$projs[size]);							
						}
					else{
							//deleteProject($dName,$projs[pId]);
						}
			 			ksort($allProj);
			 }
				
				foreach($allProj as $i)
				{					
					$divStr = $divStr.'
					<div class="item" title="'.$i[0].'"><table class="mItem"><tr><td class="mTxtH" colspan="2">'.$i[1].'</td><td rowspan ="3"><div class="eBtn" title="'.$i[0].'"></div><br><div class="dBtn"></div></td></tr><tr><td width="105px" rowspan="2"><div id="thisImg">'.$i[2].'</div></td><td class="mTxtS" height="50px">'.$i[3].'</td></tr>
<tr><td class="mTxtD" height="15px">'.$i[4].'</td></tr></table></div>';					
				}		
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
.eBtn{background:url(../graphics/editButtons.png) repeat 0 61px;width:28px;height:30px;cursor:pointer}
.pTxt{text-transform:uppercase;color:#979797;font-size:20px;line-height:21px;
letter-spacing:-2px;font-weight:bold;
font-family:"Arial Narrow", Helvetica, sans-serif;}
.pImg{border:1px solid #666;}
.dBtn{<?php echo $dButton;?>}
.mTxtH{text-transform:uppercase;color:#979797;font-size:20px;line-height:21px;letter-spacing:1px;font-weight:bold;}
.mTxtD{text-transform:uppercase;color:#BBB;font-size:10px;line-height:10px;letter-spacing:2px;font-weight:bold;}
.mTxtS{text-transform:uppercase;color:#BBB;font-size:12px;line-height:13px;font-weight:bold;}
.mImg{border:1px solid #666;width:100px;}
.mItem{margin-left:5px;font-family:Arial Narrow, Arial, Helvetica, sans-serif;}
</style>
<div style="position:relative;width:<?php echo $divWidth?>px;height:auto;">
<?php echo '<div id="'.$what.'List" class="dragList">'.$divStr.'</div>'?>
</div>
