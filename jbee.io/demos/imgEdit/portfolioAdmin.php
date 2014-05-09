<html>
<head>

<META NAME="ROBOTS" CONTENT="NOINDEX, FOLLOW">
			<script src="../import/jQuery.js" type="text/javascript"></script> 
            <script src="admin.js" type="text/javascript"></script><link href="admin.css" rel="stylesheet" type="text/css"/> 
            <script src="../import/oScript.js" type="text/javascript"></script>
            <link rel="shortcut icon" href="http://www.oasis-ad.com/graphics/oasisIcon.ico" type="image/x-icon">
            <title>EDIT PORTFOLIO</title>
<?php

function alert($show){echo '<script>alert("'.$show.'");</script>';}
$hn="localhost";
$un="markmorr_SQL1";
$pd="OASIS-ad0920";
$db="markmorr_SQL";
$con = mysql_connect($hn,$un, $pd); 
if(!$con){ die('Could not connect: ' . mysql_error());}
else{mysql_select_db($db, $con);}

$home = $portfolio = $process = $team = $contact = $media = $dropbox = "unselectedButtons";
$show =  explode("-", $_GET["nav"]);
	$selected=1;
if($show[0]=='update')
{

	$projOpts = array('img','name','pOrder');
			for($i=0;$i<5;$i++)
			{
				if(strlen($_POST['pCat'.$i]))
				{
					$updateSQL = "UPDATE portfolioCat SET";	
					$chgs = explode("~", $_POST['pCat'.$i]);
					$n = decbin($chgs[0]);
					$nStr = str_pad($n, 4, "0", STR_PAD_LEFT); 
					$edited = str_split($nStr);
					for($j=0;$j<count($projOpts);$j++)
						{
								
								if($edited[$j] != 0)
								{
									if($j==0)
									{			
										$newName = 'oasis_'.(end(explode("/",strtolower(trim($chgs[$j+1]))))); 										
										copy($chgs[$j+1], '../graphics/'.$newName);
										$updateSQL =$updateSQL.' '.$projOpts[$j].' = \''.$newName.'\',';
									}
									elseif($j==1)
									{
										$result = mysql_query('SELECT name FROM portfolioCat WHERE cID = \''.($i+1).'\'');
										$row = mysql_fetch_array($result, MYSQL_BOTH);
										$oldName = $row[name];	
										$name = $chgs[$j+1];
										$dName = strtolower(str_replace(' ', '',$oldName));
										$ndName = strtolower(str_replace(' ', '',$name));
										  if(strcmp(strtolower($name),strtolower($oldName)) != 0)///RENAME									{
											{	
											if($ndName != $dName)
											{
											  if((is_dir('../portfolio/'.$ndName)))
											  {$portError = '<b>Save Failed</b>: Could not rename Category: '.$name.'\'</strong> already exists.';
											  }									
											 else if($name==''){$portError = '<b>Save Failed</b>:Category Name cannot be left blank.';}
											 else{
												 rename('../portfolio/'.$dName,'../portfolio/'.$ndName);
												 }
										   	}

											}
										if(!(isset($portError)))
											{
													$updateSQL =$updateSQL.' '.$projOpts[$j].' = \''.$name.'\',';
											}
									}
									else
									{								
										$updateSQL =$updateSQL.' '.$projOpts[$j].' = \''.$chgs[$j+1].'\' ,';	
									}									
									
								}
						}
						
						$catEditSQL = rtrim($updateSQL,',').' WHERE cID='.($i+1);
						mysql_query($catEditSQL);					
				}
			}
			
}
  $allProj=array();
  $Qstring = 'SELECT * FROM portfolioCat';
			 $result = mysql_query($Qstring);
			 while($cat=mysql_fetch_array($result)){
			$img="";
			 if($cat[img] != '%'){$img = '<img src="../graphics/'.$cat[img].'">';}
			 array_push($allProj, array($cat[cID],$cat[name],$img,$cat[pOrder]));			 
			 }			


?>
<style>
h6{font-weight:bold;color:#666;font-size:12px;text-transform:uppercase;}

.projCatInput{width:196px;font-size:22px;text-transform:uppercase; color:#888;}
.frmtMove{width:195px;font-size:11px;color:#444;}
.frmtMove input,.frmtMove select{font-size:11px;color:#666;background:none;}
.showImg{height:237px;width:178px;}
#saveAllProj{height:30px;width:826px;text-align:center;margin-bottom:9px;}

</style>
<script>

phArr.push(new pPhoto("1","","230,305","<?php echo $allProj[0][1].'","'.$allProj[0][3];?>","pImg1","-1",".jpg",0));
phArr.push(new pPhoto("2","","230,305","<?php echo $allProj[1][1].'","'.$allProj[1][3];?>","pImg2","-1",".jpg",0));
phArr.push(new pPhoto("3","","230,305","<?php echo $allProj[2][1].'","'.$allProj[2][3];?>","pImg3","-1",".jpg",0));
phArr.push(new pPhoto("4","","230,305","<?php echo $allProj[3][1].'","'.$allProj[3][3];?>","pImg4","-1",".jpg",0));
$(document).ready(function()
{
		editProjFXNS();
$('#subMenu').selectMENU({'shD':false,'sD':'#A1A3A5','cD':'subMenu_<?php echo $selected;?>'});
$('.eBtn').click(function(){alert($(this).attr('id').substring(nSize+3));});
});

function addFromFrame(str,name)
{	
	var cID = name.replace('pFRM','');
	phArr[cID-1].kws = str;
	phArr[cID-1].changed = phArr[cID-1].changed | 2;
	changeUploadButton('saveAllProj');
}

</script>


</head><table id="mainContainerTable"><tr><td><!-- headerStart --><div id="mainMenu"> <div id="logo"><div id="goHome" onClick="(window.location = 'http://oasis-ad.com/admin')"></div></div><div id="mainNav"><table id="topButtonsSpaced"><tr><td><div class="unselectedButtons" id="topButtons" style="width:129px;"><a href="index.php"><h1>Home Page</h1></a></div></td><td><div class="selectedButtons" id="topButtons" style="width:129px;"><a href="portfolioAdmin.php"><h1>Portfolio</h1></a></div></td><td><div class="unselectedButtons" id="topButtons"><a href="processAdmin.php"><h1>Process</h1></a></div></td><td><div class="unselectedButtons" id="topButtons"><a href="teamAdmin.php"><h1>Team</h1></a></div></td><td><div class="unselectedButtons" id="topButtons"><a href="contactAdmin.php"><h1>Contact</h1></a></div>
</td><td><div class="unselectedButtons" id="topButtons"><a href="mediaAdmin.php"><h1>Media</h1></a></div></td><td><div class="unselectedButtons" id="topButtons"><a href="../fullSite.php"><h1>full site</h1></a></div></td></tr></table></div></td></tr><!-- headerEnd -->
<tr><td valign="top"><table><tr><td width="206px" valign="top">
<div id="subMenu">
<table style="margin-left:70px;margin-right:7px;margin-top:2px;" cellspacing="0px">
<tr><td class="subMenuTD"><div class="subMenu" id="subMenu_1"><a href="javascript:void(0)">
<span class="subText">Portfolio Front</span></a></div></td></tr><tr><td class="smSpacer"></td></tr>
<tr><td class="subMenuTD"><div class="subMenu" id="subMenu_2"><a href="addproject.php?nav=create-new">
<span class="subText">Add Project</span></a></div></td></tr><tr><td class="smSpacer"></td></tr>
</table></div>
</div><!-- Sub Menu -->
</td><td><div id="#spacer"></div></td><td valign="top"> <span class="errorMsg"><?php echo $portError;?></span>  
<form action="portfolioAdmin.php?nav=update" name="updateFront" method="post">
<table><tr><td valign="top">
<input id="pCatT0" name="pCatT0" class="projCatInput" size="30" value="<?php echo $allProj[0][1];?>" onKeyUp="changeUploadButton('saveAllProj');">
<input type = "hidden" name="pCat0"  id="ipCat0" value = "" /> 
<br><br><span class="noteText">IMAGE SIZE:	W:228px H:304px</span>
<div class="apImgDivFormat" style="width:195px;">
<div class="showImg" id="pImg1" title="<?php echo $allProj[0][1];?> projects" onClick="editImg('1',0,0);">
<?php echo $allProj[0][2];?></div></div>
</td><td width="7px"></td><td valign="top">
<input name="pCatT1" id="pCatT1" class="projCatInput" size="30" value="<?php echo $allProj[1][1];?>" onKeyUp="changeUploadButton('saveAllProj');">
<input type = "hidden" name="pCat1"  id="ipCat1" value = "" /> 
<br><br><span class="noteText">IMAGE SIZE:	W:228px H:304px</span>
<div class="apImgDivFormat" style="width:195px;">
<div class="showImg" id="pImg2" title="<?php echo $allProj[1][1];?> projects" onClick="editImg('2',0,0);">
<?php echo $allProj[1][2];?></div></div>
</td></td><td width="7px"></td><td valign="top">
<input name="pCatT2" id="pCatT2" class="projCatInput" size="30" value="<?php echo $allProj[2][1];?>" onKeyUp="changeUploadButton('saveAllProj');">
<input type = "hidden" name="pCat2"  id="ipCat2" value = "" /> 
<br><br><span class="noteText">IMAGE SIZE:	W:228px H:304px</span>
<div class="apImgDivFormat" style="width:195px;">
<div class="showImg" id="pImg3" title="<?php echo $allProj[2][1];?> projects" onClick="editImg('3',0,0);">
<?php echo $allProj[2][2];?></div></div>
</td></td><td width="7px"></td><td valign="top">
<input name="pCatT3" id="pCatT3"  class="projCatInput" size="30" value="<?php echo $allProj[3][1];?>" onKeyUp="changeUploadButton('saveAllProj');">
<input type = "hidden" name="pCat3"  id="ipCat3" value = "" /> 
<br><br><span class="noteText">IMAGE SIZE:	W:228px H:304px</span>
<div class="apImgDivFormat" style="width:195px;">
<div class="showImg" id="pImg4" title="<?php echo $allProj[3][1];?> projects" onClick="editImg('4',0,0);">
<?php echo $allProj[3][2];?></div></div>
</form></td></tr>
<tr><td colspan="7" align="center"><div id="saveAllProj" class="bigSaveButtons">SAVE CHANGES</div></td></tr>
<tr>
<td valign="top"><iframe id="pFRM1" src="lists.php?show=catProj-1-<?php echo $allProj[0][3];?>" frameborder="0" class="catProj" scrolling="no"></iframe>
<br><br></td><td></td>
<td valign="top"><iframe id="pFRM2" src="lists.php?show=catProj-2-<?php echo $allProj[1][3];?>" frameborder="0" class="catProj" scrolling="no"></iframe>
<br><br></td><td></td>
<td valign="top"><iframe id="pFRM3" src="lists.php?show=catProj-3-<?php echo $allProj[2][3];?>" frameborder="0" class="catProj" scrolling="no"></iframe>
<br><br></td><td></td>
<td valign="top"><iframe id="pFRM4" src="lists.php?show=catProj-4-<?php echo $allProj[3][3];?>" frameborder="0" class="catProj" scrolling="no"></iframe>
<br><br></td>
</tr>
</table>
</div>

</body>

</html>