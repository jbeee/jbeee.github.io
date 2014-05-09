<html>
<head>
<script src="http://www.caridadcharity.com/importMe/jquery-1.3.2.min.js" type="text/javascript"></script> 
			<script src="admin.js" type="text/javascript"></script><link href="admin.css" rel="stylesheet" type="text/css"/>
            <link rel="shortcut icon" href="http://www.oasis-ad.com/graphics/oasisIcon.ico" type="image/x-icon">
            
<?php
if(isset($_GET["nav"]))
{
		echo '<META NAME="ROBOTS" CONTENT="NOINDEX, FOLLOW">
			<script src="../import/jQuery.js" type="text/javascript"></script> 
			<script src="admin.js" type="text/javascript"></script><link href="admin.css" rel="stylesheet" type="text/css"/> ';
}
else
{
	echo '<META HTTP-EQUIV="Refresh" Content="0; URL=http://www.oasis-ad.com/admin.php">';    
    exit;  
}

function emptyTempGraphics() {  
$dir= 'tempGraphics/';
foreach (scandir($dir) as $item) {
    if ($item == '.' || $item == '..')continue;
	unlink($dir.DIRECTORY_SEPARATOR.$item);
}
}
function alert($msg){echo '<script>alert("'.$msg.'");</script>';}
function deleteImg($dirR,$dir,$oldSrc){
	if(($oldSrc != '%')&&(file_exists($dirR.'/'.$dir.'/'.$oldSrc))){
		unlink($dirR.'/'.$dir.'/'.$oldSrc);}}

$hn="localhost";
$un="markmorr_SQL1";
$pd="OASIS-ad0920";
$db="markmorr_SQL";
$con = mysql_connect($hn,$un, $pd); 
if(!$con){ die('Could not connect: ' . mysql_error());}
else{mysql_select_db($db, $con);}
$home = $portfolio = $process = $team = $contact = $media = $dropbox = "unselectedButtons";
$show =  explode("-", $_GET["nav"]);

$catArr = array();
$Qstring = 'SELECT * FROM portfolioCat';
			 $result = mysql_query($Qstring);
			 while($cat=mysql_fetch_array($result)){
			 array_push($catArr, $cat[name]);			 
			 }			


$editProjectSelect = 'selectedSub';
$projID = $show[1];
		$buttonTxt = $show[0];
			if($show[0]=='create')
			{
				echo '<TITLE>ADD NEW PROJECT</TITLE>';
			}
			else if($show[0]=='update')			
			{
				if($show[1]=='new')
				{
					echo '<TITLE>ADD NEW PROJECT</TITLE>';
					$idxHTML = "lots oh stuff";
					$name = trim($_POST["name"]);
					$dName = str_replace(' ', '',strtolower($name));
					if($name=='')
					{
						$createError = "<b>ADD FAILED</b>: NAME REQUIRED TO CREATE NEW PROJECT";
					}
					else if(is_dir('../portfolio/'.$dName))
					{
						$createError ='<b>ADD FAILED</b>: A project named <strong>\''.$name.'\'</strong> already exists.';
					}
					else
					{
						mkdir('../portfolio/'.$dName, 0777);
						$insert = "INSERT INTO  portfolio ( category,name,keywords,location,description,size) VALUES ('";
					    $values = $_POST['category']."','".$_POST['name']."','".$_POST['keywords']."','".$_POST['location']."',
						'".$_POST['description']."','".$_POST['size']."');";
						mysql_query($insert.$values);						
						$buttonTxt = 'UPDATE';
						$result = mysql_query('SELECT pID FROM portfolio WHERE name = \''.$name.'\'');
						$row = mysql_fetch_array($result, MYSQL_BOTH);
						$projID = $row[pID];
						$concatMe = "UPDATE portfolioCat SET pOrder = CONCAT(pOrder, ',".$projID."')WHERE cID='".$_POST['category']."'";
						mysql_query($concatMe);
					
						$createIdx = fopen('../portfolio/'.$dName.'/index.php', 'w') or die("can't open file");
						fwrite($createIdx, $idxHTML); fclose($createIdx);
					}
				
				}//END ($projID=='new')
				else
				{
					$name = trim($_POST["name"]);					
					$dName = str_replace(' ', '', strtolower($name));
					if(strlen($_POST["chPpl"]))
					{
						$updateSQL = "UPDATE portfolio SET";
						$changed =  explode("-", $_POST["chPpl"]);
						foreach($changed as $i){
						$updateSQL = $updateSQL.' '.str_replace("@", "='", $i).'\',';
						$tmp=str_replace("@", ",", $i);
						$addTo = explode(',',$tmp);
							foreach($addTo as $j)
							{
							mysql_query("UPDATE teamEXT SET projects = CONCAT(projects, ',".$projID."')WHERE id='".$j."'");
							}
						
						}
						$updateSQL = rtrim($updateSQL,',').' WHERE pID='.$projID;
						mysql_query($updateSQL);	
						
					}
					if(strlen($_POST["bsx"]))
					{
						$basics = explode(",", $_POST["bsx"]);
						if(strlen($_POST["shPpl"])){array_push($basics,"shPpl");}
						if(in_array('name',$basics))
							{								
								$result = mysql_query('SELECT name FROM portfolio WHERE pID = \''.$projID.'\'');
								$row = mysql_fetch_array($result, MYSQL_BOTH);
								$oldName = $row[name];	

								if(strcmp(strtolower($name),strtolower($oldName)) != 0)///RENAME									{
									{											
									  if((is_dir('../portfolio/'.$dName))){$portError = '<b>Save Failed</b>: Could not rename project.
											A project named <strong>\''.$name.'\'</strong> already exists.';	}									
									 else if($name==''){$portError = '<b>Save Failed</b>:Project Name cannot be left blank.';}
									 else{
										 rename('../portfolio/'.str_replace(' ', '_', strtolower($oldName)),'../portfolio/'.$dName);
										 }
									}
						}
												
						if(!(isset($portError)))
							{
								$updateSQL = "UPDATE portfolio SET";
								foreach($basics as $i){	$updateSQL =$updateSQL.' '.$i.' = \''.$_POST[$i].'\',';}
								$updateSQL = rtrim($updateSQL,',').' WHERE pID='.$projID;
								mysql_query($updateSQL);
							}
					}///end basics
			if(strlen($_POST["pOrd"])){	$newImgOrder = $_POST["pOrd"];}
			
			if(strlen($_POST["pEds"]))
			{
						$Qstring = 'SELECT name,topImg,btmImg,thmb FROM portfolio WHERE pID='.$projID;
						 $result = mysql_query($Qstring);
						 $row = mysql_fetch_array($result, MYSQL_BOTH);
			 
						$sides = $_POST["sideNum"];
						$imgs = explode('@',$_POST["pEds"]);
						foreach($imgs as $i){
							$img = explode(":",$i);
					///5:tempGraphics/img3.jpg:stuff:sdkjfsksj:8:tempGraphics/img3.jpg:8
					$ext = end(explode(".",strtolower(trim($img[1]))));

	if($img[0]=='thmb')
	{
		$newImg = $dName.'THMB.'.$ext;
		deleteImg('../portfolio/',$dName,$row[thmb]);		
		copy($img[1], '../portfolio/'.$dName.'/'.$newImg);
		$updateSQL = 'UPDATE portfolio SET thmb = \''.$newImg.'\' WHERE pID='.$projID;
		mysql_query($updateSQL);
		$inGen = "INSERT INTO  genImgs (dirR,dir,url) VALUES ('portfolio','".$dName."','".$newImg."');";
		mysql_query($inGen);
	}
	else if(($img[0]=='side1')&&($sides[0]==1))
	{
		$newImg = $dName.'S1.'.$ext;
		deleteImg('../portfolio/',$dName,$row[topImg]);		
		copy($img[1], '../portfolio/'.$dName.'/'.$newImg);
		$updateSQL = 'UPDATE portfolio SET topImg = \''.$newImg.'\',btmImg = \'single\' WHERE pID='.$projID;
		mysql_query($updateSQL);
		$inGen = "INSERT INTO  genImgs (dirR,dir,url) VALUES ('portfolio','".$dName."','".$newImg."');";
		mysql_query($inGen);
	}
	else if(($img[0]=='sideT')&&($sides[0]==2))
	{
		$newImg = $dName.'ST.'.$ext;
		deleteImg('../portfolio/',$dName,$row[topImg]);		
		copy($img[1], '../portfolio/'.$dName.'/'.$newImg);
		$updateSQL = 'UPDATE portfolio SET topImg = \''.$newImg.'\' WHERE pID='.$projID;
		mysql_query($updateSQL);
		$inGen = "INSERT INTO  genImgs (dirR,dir,url) VALUES ('portfolio','".$dName."','".$newImg."');";
		mysql_query($inGen);
	}
	else if(($img[0]=='sideB')&&($sides[0]==2))
	{
		$newImg = $dName.'SB.'.$ext;
		deleteImg('../portfolio/',$dName,$row[btmImg]);		
		copy($img[1], '../portfolio/'.$dName.'/'.$newImg);
		$updateSQL = 'UPDATE portfolio SET btmImg = \''.$newImg.'\' WHERE pID='.$projID;
		mysql_query($updateSQL);
		$inGen = "INSERT INTO  genImgs (dirR,dir,url) VALUES ('portfolio','".$dName."','".$newImg."');";
		mysql_query($inGen);
	}
	else
	{
		if($img[5] == 'd')
		{
			$updateSQL = 'DELETE FROM portImg WHERE id='.$img[0];
			mysql_query($updateSQL);
			deleteImg('../portfolio/',$dName,$img[1]);
			deleteImg('../portfolio/',$dName,$img[4]);
		}
		else if($img[5] == 16)
		{
							
			$insert = "INSERT INTO  portImg (pID,kws,title) VALUES ('";
			$extThmb = end(explode(".",strtolower(trim($img[4]))));
			$extPic = end(explode(".",strtolower(trim($img[1]))));
			$values = $projID."','".$img[3]."','".$img[2]."');";
			mysql_query($insert.$values);
			$newPictureId = mysql_insert_id();
			$newImgOrder = str_replace($img[0],$newPictureId, $newImgOrder);
			$newPicUrl = $dName.'_'.$newPictureId.'.'.$extPic;
			$newThmbUrl =  $dName.'_'.$newPictureId.'THMB.'.$extThmb;
			copy($img[1],'../portfolio/'.$dName.'/'.$newPicUrl);
			copy($img[4],'../portfolio/'.$dName.'/'.$newThmbUrl);
			$updateSQL = "UPDATE portImg SET src = '".$newPicUrl."', thmb = '".$newThmbUrl."' WHERE id=".$newPictureId;
			mysql_query($updateSQL);
			
		}
		else
		{
			$updateSQL = "UPDATE portImg SET";								
			$imgOpts = array('src','title','kws','thmb');
			$n = decbin($img[5]);
			$nStr = str_pad($n, 4, "0", STR_PAD_LEFT); 
			$edited = str_split($nStr);		
			for($i=0;$i<count($edited);$i++)
			{
				if($edited[$i] != 0)
				{
					if(($i==0)||($i==3)){						
						$tExt = '.'.(end(explode(".",strtolower(trim($img[$i+1])))));
						if($i==3){$tExt = 'THMB'.$tExt;}
						copy($img[$i+1], '../portfolio/'.$dName.'/'.$dName.'_'.$img[0].$tExt);
						$updateSQL =$updateSQL.' '.$imgOpts[$i].' = \''.$dName.'_'.$img[0].$tExt.'\',';
						}	
						else
						{								
							$updateSQL =$updateSQL.' '.$imgOpts[$i].' = \' '.$img[$i+1].'\' ,';
						}
					
				}

			}
			
			$updateSQL = rtrim($updateSQL,',').' WHERE id='.$img[0];
			mysql_query($updateSQL);
			
			
		}
	}

							
							}//end loop
					}///end photoEdits
	if(isset($newImgOrder))
	{	
		$updateSQL = "UPDATE portfolio SET pOrder = '".$newImgOrder."' WHERE pID=".$projID;
		mysql_query($updateSQL);
	}
				}//($currentProj EXISTS)
			}//end ($show[0]=='update')	
	////GET EXISTING PROJECT INFO
		if(($show[0]!='create')&&(!(isset($createError))))
		 {
			 
			 $buttonTxt='Save';
			 $allPeople=array();	 
			 $r = 0;
			  $Qstring = 'SELECT projects,ttype,id,name FROM teamEXT';
			 $result = mysql_query($Qstring);
			 while($ppl=mysql_fetch_array($result)){ $checked="";
					$ports = explode(',',$ppl[projects]);
					if(in_array($projID,$ports)){$checked='checked';}
					$allPeople[$r] = array($ppl[ttype],$ppl[id],$ppl[name],$checked);
					$r=$r+1;}			
		
	         $Qstring = 'SELECT * FROM portfolio WHERE pID='.$projID;
			 $result = mysql_query($Qstring);
			 $row = mysql_fetch_array($result, MYSQL_BOTH);
			 $name = $row[name];
			 echo '<TITLE>EDIT '.strtoupper($name).'</TITLE>';
			 $dName = str_replace(' ', '', strtolower($name));
			 $loc = $row[location];
			 $size = $row[size];
			 $desc = $row[description];
			 $kw = $row[keywords];
			 $category = $row[category];
			 switch ($category)
 {case 1:$cat1 ='selected';break;case 2:$cat2 ='selected';break;case 3:$cat3 ='selected';break;case 4:$cat4 ='selected';break;case 5:$cat5 ='selected';break;}
			 $teamExt = array();
			 $showTeam = explode(',',$row[shPpl]);
			 $teamExt[0] = array('photographer',$row[photographer],$showTeam[0]);
			 $teamExt[1] = array('consultant',$row[consultant],$showTeam[1]);
			 $teamExt[2] = array('contractor',$row[contractor],$showTeam[2]);
			 $teamExt[3] = array('trade',$row[trade],$showTeam[3]);
			 $teamExt[4] = array('product',$row[product],$showTeam[4]);
			 $teamExt[5] = array('realtor',$row[realtor],$showTeam[5]);
			 $teamExt[6] = array('interior_design',$row[interior_design],$showTeam[6]);
			 if($row[thmb]!='%'){$thmb='../portfolio/'.$dName.'/'.$row[thmb]; $thmbC = '<img src="'.$thmb.'">';}
			  $singleCSS = 'display:none;';	
			  $doubleR = 'checked';
			  $sideNum = '2';
			 if($row[topImg]!='%')
			 {
				$topImg='../portfolio/'.$dName.'/'.$row[topImg];$topImgC2= '<img src="'.$topImg.'">';			 
			 	if($row[btmImg] == 'single')
				 {	$topImgSingle = $topImg; 
				 	 $singleCSS=$doubleR=$btmImg=$btmImgC=$topImgC2=$topImg='';
			 		 $topImgC1= '<img src="'.$topImgSingle.'">';
					 $singleR = 'checked';
					 $sideNum = '1';
					 $doubleCSS = 'display:none;';
			 }}
			 if(($row[btmImg]!='%')&&($row[btmImg] != 'single'))
			 {$btmImg='../portfolio/'.$dName.'/'.$row[btmImg]; $btmImgC = '<img src="'.$btmImg.'">';} 
			 $pOrder = $row[pOrder];
			 $allImgs=array();	 
			 $pos = explode(',',$pOrder);
			 $Qstring = 'SELECT * FROM portImg WHERE pID='.$projID;
			 $result = mysql_query($Qstring);			
			 while($img=mysql_fetch_array($result))				
					{
						if(in_array($img[id],$pos))
						{				   
							$idx = array_search($img[id], $pos);
							$allImgs[$idx]= $img;							
						}
					}				
			
		 }//GOT PROJECT INFO
$saveAction = '?nav=update-'.$projID;
if($show[0]=='create')
{						
		$projDetails='style="display:none;"';
}
else if(isset($createError))
{
	$saveAction = '?nav=create-'.$projID;
}


?>

</head><table id="mainContainerTable"><tr><td><!-- headerStart --><div id="mainMenu"> <div id="logo"><div id="goHome" onClick="(window.location = 'http://oasis-ad.com/admin')"></div></div><div id="mainNav"><table id="topButtonsSpaced"><tr><td><div class="unselectedButtons" id="topButtons" style="width:129px;"><a href="index.php"><h1>Home Page</h1></a></div></td><td><div class="selectedButtons" id="topButtons" style="width:129px;"><a href="portfolioAdmin.php"><h1>Portfolio</h1></a></div></td><td><div class="unselectedButtons" id="topButtons"><a href="processAdmin.php"><h1>Process</h1></a></div></td><td><div class="unselectedButtons" id="topButtons"><a href="teamAdmin.php"><h1>Team</h1></a></div></td><td><div class="unselectedButtons" id="topButtons"><a href="contactAdmin.php"><h1>Contact</h1></a></div>
</td><td><div class="unselectedButtons" id="topButtons"><a href="mediaAdmin.php"><h1>Media</h1></a></div></td><td><div class="unselectedButtons" id="topButtons"><a href="../fullSite.php"><h1>full site</h1></a></div></td></tr></table></div></div></td></tr><!-- headerEnd -->
<tr><td valign="top"><table><tr><td width="206px" valign="top">
<div id="subMenu">
<table style="margin-left:70px;margin-right:7px;margin-top:2px;" cellspacing="0px">
<tr><td class="subMenuTD"><div class="subMenu" id="subMenu_1"><a href="portfolioAdmin.php">
<span class="subText">Portfolio Front</span></a></div></td></tr><tr><td class="smSpacer"></td></tr>
<tr><td class="subMenuTD"><div class="subMenu" id="subMenu_2"><a href="addproject.php?nav=create-new">
<span class="subText">Add Project</span></a></div></td></tr><tr><td class="smSpacer"></td></tr>
</table></div>
</div><!-- Sub Menu --></td><td valign="top">
<div class="mainAdminBody" id="portfolioADD">
<span class="errorMsg"><?php echo $portError;?></span>  
<table><tr><td valign="top" id="projInfoTD">     
<form id="editProject" method="post" action="<?php echo $saveAction;?>">
Name:<br><input class="portBasics" name="name" size=20 value="<?php echo $name;?>" maxlength="14"><br>
location:<br>
<input name="location" class="portBasics" size=20 value="<?php echo $loc;?>" ><br>
size:<br>
<input name="size" size=20 class="portBasics" value="<?php echo $size;?>">

</td><td valign="top">
<div style="margin-left:9px;margin-right:9px;">
Description:<br><textarea name="description" id="desc" rows=6 cols=49><?php echo $desc;?></textarea>
</div>
</td><td valign="top">
<table><tr><td width="40px">Type:</td><td>
<select name="category" id="cats">
  	<option value="1" <?php echo $cat1?>><?php echo $catArr[0];?></option>
   	<option value="2" <?php echo $cat2?>><?php echo $catArr[1];?></option>
    <option value="3" <?php echo $cat3?>><?php echo $catArr[2];?></option>
  	<option value="4" <?php echo $cat4?>><?php echo $catArr[3];?></option>
</select>
</td></tr></table>
<br />
Project KeyWords:<br><textarea name="keywords" rows=3 cols=48 id="kws"><?php echo $kw;?></textarea>
</td><td><div id="saveProjButton" class="bigSaveButtons"><?php echo $buttonTxt;?></div>
<input type = "hidden" name = "pEds"  id="pEdsVal" value = "" /> 
<input type = "hidden" name = "pOrd"  id="pOrdVal" value = "<?php echo $pOrder;?>" /> 
<input type = "hidden" name = "chPpl"  id="chVal" value = "" />
<input type = "hidden" name = "shPpl"  id="showVal" value = "" />
<input type = "hidden" name = "bsx"  id="bsxVal" value = "" /> 

</td></tr></table>
<table <?php echo $projDetails;?>><tr><td valign="top">
<br>
Side Images:<br /> <span class="smallRadio">
<input type="radio" name="sideNum" class="sideNum" value="1" <?php echo $singleR?>/>Single
<input type="radio" name="sideNum" class="sideNum" value="2" <?php echo $doubleR?>/> Double</span>
</form>
<div class="apImgDivFormat" style="width:224px;">      

<div id="apGetSide2" class="singleSide" style="width:224px;top:0px;<?php echo $singleCSS?>">
<center>
<div class="showImg" id="apSide1Single" style="width:200px;height:428px;overflow:hidden;" title="side image">
<div class="absContainer">
<?php echo $topImgC1; ?><div style="width:200px;height:11px;background-color:#fff;position:absolute;top:150px;left:0px;"></div></div></div>

<div class="lilButton" style="width:200px;height:15px;"><a href="javascript:void(0)" onClick="editImg('side1',0,0);">UPDATE</a></div>
</center></div>
 
<div id="apGetSide1" class="doubleSide" style="width:224px;<?php echo $doubleCSS?>" >
<center><div class="showImg" id="apSide1Top" style="width:200px;height:150px;overflow:hidden;" title="top side image">
<?php echo $topImgC2; ?></div>
<div class="lilButton" style="width:200px;height:15px;"><a href="javascript:void(0)" onClick="editImg('sideT',0,0);">UPDATE</a></div>
</center></div>
<div id="apGetSide2" class="doubleSide" style="width:224px;<?php echo $doubleCSS?>" >
<center><div class="showImg" id="apSide1Bottom" style="width:200px;height:272px" title="bottom side image"><?php echo $btmImgC; ?></div>
<div class="lilButton" style="width:200px;height:15px;"><a href="javascript:void(0)" onClick="editImg('sideB',0,0);">UPDATE</a>
</center></div>





<br />

</div>

</td>
<td valign="top">
<div style="margin-left:12px;margin-right:2px;height:auto;width:auto;">
<table width="200px" height="40px"><tr><td width="150px">Project Photos:</td><td align="right">
<div class="addPhotoBtn" id="newPhoto" title='Add New Photo'></div></td></tr></table>
<div id="apPhotoContainer"><!--BEGIN PHOTO CONTAINER -->
<?php 
$addJQ = "";
if(isset($allImgs))
{	
ksort($allImgs);
foreach($allImgs as $i)
{
echo '<div class="apPhoto" title="'.$i[id].'"><table><tr><td width="120px"><div class="showImg" style="width:100px;height:70px"><img src="../portfolio/'.$dName.'/'.$i[src].'" width="100px" id="img'.$i[id].'"></div></td><td width="216"><div class="apPhotoTxt"><b><span id="title'.$i[id].'">'.$i[title].'</span></b><br><span id="kws'.$i[id].'">'.$i[kws].'</span></div></td></td><td width="40px"><div class="editPhotoBtn" id="edit'.$i[id].'" title="Edit"></div></td><td><div class="dBtn" id="eapPhoto'.$i[id].'" title="Delete" onclick="deletePhoto('.$i[id].');"></div></td></tr></table></div>';
$addJQ = $addJQ.'phArr.push(new pPhoto("'.$i[id].'","../portfolio/'.$dName.'/'.$i[src].'","697,484","'.$i[title].'","'.$i[kws].'","","../portfolio/'.$dName.'/'.$i[thmb].'",".jpg",0));';		
}
}
?>

</div><!--END PHOTO CONTAINER -->
</div>
</td>
<td valign="top"><br>
<table><tr><td>Thumbnail: </td><td><span class="noteText" style="margin-left:10px;"> W:118px H:81px</span></td></tr></table>
<div class="apImgDivFormat" style="margin: 10px 10px 10px 10px;width:174px;"><center> 
<div class="showImg" style="width:118px;height:81px;" id="apGetThm" title="project thumbnail"><?php echo $thmbC; ?></div>
<div class="lilButton" style="width:118px;height:15px;"><a href="javascript:void(0)" onClick="editImg('thmb',0,0);">UPDATE</a></div>
<br></div></center></div> 
<table width="180px">
<?php
if(isset($teamExt))
{
foreach($teamExt as $i){
if($i[2]==1){$chkShow='checked';}else{$chkShow='';}	
if(strlen($i[1])<1){$chkHide = 'style="visibility:hidden;"';}else{$chkHide='';}
echo '<tr><td>'.$i[0].'</td><td width="30px" rowspan="2"><div class="addButton2" id="add'.$i[0].'" title="Add More '.$i[0].'"></div></td></tr><tr><td><table '.$chkHide.' id="show'.$i[0].'"><tr><td><input type="checkbox" class="showTeam" '.$chkShow.'/></td><td>
<span class="noteText"><b>SHOW IN DESCRIPTION</b></span></td></tr></table></td></tr><tr><td colspan="2"><iframe id="'.$i[0].'" src="lists.php?show=projPPL-'.$projID.'-'.$i[0].'-'.$i[1].'" frameborder="0" class="projPPL" scrolling="no"></iframe><br><br></td></tr>';}	
}
?>


</table></td></tr></table>

</td></tr></table>
</div> 
</td></tr></table>


<div id="addPeople" style="visibility:hidden;z-index:900">
<div class="absContainer">
<div class="addPeople" id="addExisting"><table class="frmtPpl"><tr><td><center><span class="title" id="tExist"></span><form> 
<table class="txt"><tr><td colspan="2">
<table class="txt" id="chk"></table>
</td></tr>
<tr><td width="41px"><div class="aBtn" id="addNewPerson" style="margin-left:-1px;"></div></td>
<td><div id="tAdd">_____________________________</div></td></tr></table></form>
<div class="lilButton" id="doneAdding" style="width:150px;height:25px;"><br>
<a href="javascript:void(0)" style="font-size:18px;text-align:center;">DONE</a></div><br></td></tr></table></div>
<div class="addPeople" id="addNew"><table class="frmtPpl"><tr><td><center><span class="title" id="tNEW"></span>
<span class="errorMsg" id="pplError"></span><form>
<table class="txt">
<tr><td class="shPhInd">INDIVIDUAL:</td><td class="shPhInd"><input id="personInd" size=30 value=""></td></tr>
<tr><td>COMPANY:</td><td><input id="personName" size=30 value=""></td></tr>
<tr><td>SITE:</td><td><input id="personWebsite" size=30 value=""></td></tr>
<tr><td>PHONE:</td><td><input id="personPhone" size=30 value=""></td></tr>
<tr><td>ADDITIONAL<br>Information:</td><td><textarea id="personText" rows=3 cols=29 value=""></textarea></td></tr></table>
<br><table><tr><td>
<div class="lilButton" style="width:120px;height:25px;" id="cancelAdd"><a href="javascript:void(0)" style="font-size:18px;text-align:center;">Cancel</a></div>
</td><td width="20px"></td><td>
<div class="lilButton" style="width:120px;height:25px;" id="saveNew"><a href="javascript:void(0)" style="font-size:18px;text-align:center;">Save</a></div>
</td></tr></table></form></td></tr></table></div>
</div>
</div>
<div style="visibility:hidden;">
</div>


<script>
<?php if(isset($projID))
{
echo "var baseFrameSrc = 'lists.php?show=projPPL-".$projID."-';";
}
?>
var bsx="";
var allPeople = new Array();	
var projLists = new Array();
<?php 
if(isset($allPeople)){
$count=0;
foreach($allPeople as $i){echo 'allPeople['.$count.']=["'.$i[0].'","'.$i[1].'","'.$i[2].'","'.$i[3].'"];';
$count=$count+1;}
$count=0;
foreach($teamExt as $i){echo 'projLists['.$count.']=["'.$i[0].'",0,"'.$i[1].'",'.($i[2]).'];'; $count=$count+1;}
}
?>
phArr.push(new pPhoto("temp","","697,484","","","tempView",".jpg",31));
phArr.push(new pPhoto("tmpThmb","<?php echo $thmb;?>","65,25","","","tempViewThmb","-1",".png",0));
phArr.push(new pPhoto("side1","<?php echo $topImg;?>","226,484","","","apSide1Single","-1",".png",0));
phArr.push(new pPhoto("sideT","<?php echo $topImg;?>","226,170","","","apSide1Top","-1",".png",0));
phArr.push(new pPhoto("sideB","<?php echo $btmImg;?>","226,308","","","apSide1Bottom","-1",".png",0));
phArr.push(new pPhoto("thmb","","118,81","","","apGetThm","-1",".png",0));
///
<?php echo $addJQ;?>


var currentProj = "<?php echo $projID;?>";
parent.thsProj = currentProj;
var sideNum = "<?php echo $sideNum;?>";
var newOrderStr = "<?php echo $pOrder;?>";

$(document).ready(function()
{
	refreshFrameHeight();
	$('#addPeople').addPeoplePROJ();
	 $('.addButton2').mouseenter(function() {$(this).css('backgroundPosition', '0px 152px');})
   				   .mouseleave(function(){$(this).css('backgroundPosition', '0px 0px');});
	$('.editPhotoBtn').click(function(){editProjectPhoto(($(this).attr('id')).replace('edit',''));})
				      .mouseenter(function() {$(this).css('backgroundPosition', '0px 30px');})
   			 		 .mouseleave(function(){$(this).css('backgroundPosition', '0px 61px');});
	$('.addPhotoBtn').click(function(){editProjectPhoto('newPhoto');})
					.mouseenter(function() {$(this).css('backgroundPosition', '0px 152px');})
   			  		.mouseleave(function(){$(this).css('backgroundPosition', '0px 0px');});
	$('.dBtn').mouseenter(function() {$(this).css('backgroundPosition', '0px 92px');})
   			  .mouseleave(function(){$(this).css('backgroundPosition', '0px 122px');});
	$('#apPhotoContainer').dragSort({'name':'img','margin':5,'iClass':'apPhoto','dH':97,'dW':410});
	$('.deleteButton').mouseenter(function() {$(this).css('backgroundPosition', '0px 30px');})
   				   .mouseleave(function(){$(this).css('backgroundPosition', '0px 60px');});
				   
		addProjectFXNS();	
		parent.changePEditFrm($(document).height())
});
function addFromFrame(str,name)
{	
	newOrderStr = str;
}



</script>

</body>
</html>
