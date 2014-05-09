<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<META NAME="ROBOTS" CONTENT="NOINDEX, FOLLOW">
<head>
<link rel="shortcut icon" href="http://www.oasis-ad.com/graphics/oasisIcon.ico" type="image/x-icon">
<link href="../import/main2.css" rel="stylesheet" type="text/css"/>
<script src="../import/jQuery.js" type="text/javascript"></script> 
<script src="admin.js" type="text/javascript"></script><link href="admin.css" rel="stylesheet" type="text/css"/> 
<script src="../import/oScript.js" type="text/javascript"></script>
<title>EDIT TEAM</title> 
<?php
$hn="localhost";$un="markmorr_SQL1";$pd="OASIS-ad0920";$db="markmorr_SQL";
$con = mysql_connect($hn,$un, $pd); if(!$con){ die('Could not connect: ' . mysql_error());}else{mysql_select_db($db, $con);}

if($_POST["ts1Title"])
{
$result = mysql_query('SELECT image FROM genInfo WHERE id = \'1\'');
$row = mysql_fetch_array($result, MYSQL_BOTH);
										$topImgO = $row[image];
$result = mysql_query('SELECT image FROM genInfo WHERE id = \'2\'');
$row = mysql_fetch_array($result, MYSQL_BOTH);
										$btmImgO = $row[image];
if($topImgO != $_POST['tsTopImg'])
{
	$newName = 'oasis_tsTopImg.'.(end(explode(".",strtolower(trim($_POST['tsTopImg']))))); 
	copy($_POST['tsTopImg'],'../team/graphics/'.$newName);
	$topImgO = $newName;
}
if($btmImgO != $_POST['tsBtmImg'])
{
	$newName = 'oasis_tsBtmImg.'.(end(explode(".",strtolower(trim($_POST['tsBtmImg']))))); 
	copy($_POST['tsBtmImg'],'../team/graphics/'.$newName);
	$btmImgO = $newName;
}
$updateSQL = "UPDATE genInfo SET name = '".$_POST["ts1Title"]."',image = '".$topImgO."',txt = '".trim($_POST["ts1Text"])."',txt2 = '".$_POST["tsSideNum"]."' where id = 1";
mysql_query($updateSQL);	
$updateSQL = "UPDATE genInfo SET name = '".$_POST["ts2Title"]."',image = '".$btmImgO."',txt = '".trim($_POST["ts2Text"])."' where id = '2'";
mysql_query($updateSQL);	

}
$result = mysql_query('SELECT * FROM genInfo WHERE id = \'1\'');
										$row = mysql_fetch_array($result, MYSQL_BOTH);
										$ts1Title = $row[name];	
										$ts1Text = $row[txt];	
										$topImg = '../team/graphics/'.$row[image];	
										$numImgs = $row[txt2];	
$result = mysql_query('SELECT * FROM genInfo WHERE id = \'2\'');
										$row = mysql_fetch_array($result, MYSQL_BOTH);
										$ts2Title = $row[name];	
										$ts2Text = $row[txt];	
										$btmImg = '../team/graphics/'.$row[image];					


$singleSides = "";
$doubleSides = "";
$showSingleSides = "";
$showDoubleSides = "";
if($numImgs != '2'){$singleSides = "checked"; $showDoubleSides="display:none;";}
else{$doubleSides = "checked";$showSingleSides="display:none;";}
										
		
?>
<style>
.absC{position:relative;width:100%;height:100%;}
.txtScroll{height:auto;position:absolute;top:0px;left:0px;}
.scrollMe{position:relative;overflow:hidden;}
.blockTitle{display:block;margin-top:7px;margin-left:10px;}
#allTeamContainer{position:relative;overflow:hidden;height:495px;width:935px}
.teamPages{position:absolute;left:0;height:100%;width:100%}
.bottomLink{cursor:pointer;height:78px;width:100%;background-color:#C5C7C8;position:relative}
.quarterSubs{background-color:#C5C7C8;margin-bottom:11px;position:relative;overflow:hidden;width:100%}
#quarter1{width:234px}
#quarter1Container{position:relative;overflow:hidden;width:225px}
#quarter2{width:280px}
#quarter2Mid{height:314px}
#quarter2Container{position:relative;overflow:hidden;width:271px}
h5{font-size:14px;font-weight:bolder;text-transform:uppercase;display:block;padding-left:8px;padding-top:3px;line-height:16px;letter-spacing:1px}
h2{font-size:14px;font-weight:bolder;text-transform:uppercase;display:block;padding-top:3px;line-height:16px;}
.teamTxtFormat{position:relative;overflow:hidden;font-size:17px;font-family:"Arial Narrow", Helvetica, sans-serif;color:#fff;line-height:24px;margin:11px}
.teamTxtFormat strong{font-size:20px;color:#888;font-weight:500;text-transform:lowercase}
.teamTxtFormat b{font-size:14px;font-weight:bolder;text-transform:uppercase;line-height:20px;display:inline;text-decoration:none}
.teamTxtFormat a{text-decoration:none;color:#efefef;font-size:13px;text-transform:lowercase}
#fstateContainer{width:250px;height:120px;margin-left:10px;}
#sstateContainer{width:250px;height:280px;margin-left:10px;}
.quarterSubs{font-size:16px;font-family:"Arial Narrow", Helvetica, sans-serif;color:#fff;text-align:left;}
h3{font-size:24px;font-weight:bold;}
</style>
<script>
$.support.touch = 'ontouchend' in document;
var mobile = $.support.touch;
var sideNum = <?php echo $numImgs?>;
phArr.push(new pPhoto("side1","<?php echo $topImg; ?>","226,484","","","apSide1Single","-1",".png",0));
phArr.push(new pPhoto("sideT","<?php echo $btmImg; ?>","226,170","","","apSide1Top","-1",".png",0));
phArr.push(new pPhoto("sideB","<?php echo $topImg; ?>","226,308","","","apSide1Bottom","-1",".png",0));
$(document).ready(function()
{
	$('#subMenu').selectMENU({'shD':false,'sD':'#A1A3A5','cD':'subMenu_X'});
	$('#showHtmlHelp').showHtmlHelp({'l':0,'t':0,'h':'484px','w':'271px'});
	$('.editTText').editTextBox ();
	$('.editTextBtn').mouseenter(function() {$(this).css('backgroundPosition', '0px 30px');})
   			 		 .mouseleave(function(){$(this).css('backgroundPosition', '0px 61px');});
	$('.dBtn').mouseenter(function() {$(this).css('backgroundPosition', '0px 92px');})
   			  .mouseleave(function(){$(this).css('backgroundPosition', '0px 122px');});
	$('.sideNum').click(function(){if(this.value == 1){$('.singleSide').css('display','block');
								$('.doubleSide').css('display','none');sideNum=1;}else{$('.singleSide').css('display','none');
								$('.doubleSide').css('display','block');sideNum=2;}changeUploadButton('saveTeamButton');});
	$('#saveTeamButton').click(function(){
		if(ok2Save){
		var noProbs = true;
		$('#ts1TitleVal').attr('value',$('#showTT1T').html());
		$('#ts2TitleVal').attr('value',$('#showTT2T').html());
		$('#ts1TextVal').attr('value',$('#showTT1').html());
		$('#ts2TextVal').attr('value',$('#showTT2').html());
		$('#tsSideNumVal').attr('value',sideNum);
		if(sideNum == 1)
		{
			var newSrc = $('#apSide1Single').find('img').attr('src');
			if(newSrc == ''){noProbs = false}
			$('#tsTopImgVal').attr('value',newSrc);
		}
		else
		{
			var newSrc = $('#apSide1Top').find('img').attr('src');
			if(newSrc == ''){noProbs = false}
			var newSrc2 = $('#apSide1Bottom').find('img').attr('src');
			if(newSrc2 == ''){noProbs = false}
			$('#tsTopImgVal').attr('value',newSrc);
			$('#tsBtmImgVal').attr('value',newSrc2);
		}
		if(noProbs)
		{
		document.forms['editTeamStatements'].submit();
		}
		}
		});



$('.scrollMe').aScroll({'mobile':$.support.touch});
});
</script>
</head>
<body>
<table id="mainContainerTable"><tr><td><!-- headerStart --><div id="mainMenu"> <div id="logo"><div id="goHome" onClick="(window.location = 'http://oasis-ad.com/admin')"></div></div><div id="mainNav"><table id="topButtonsSpaced"><tr><td><div class="unselectedButtons" id="topButtons" style="width:129px;"><a href="index.php"><h1>Home Page</h1></a></div></td><td><div class="unselectedButtons" id="topButtons" style="width:129px;"><a href="portfolioAdmin.php"><h1>Portfolio</h1></a></div></td><td><div class="unselectedButtons" id="topButtons"><a href="processAdmin.php"><h1>Process</h1></a></div></td><td><div class="selectedButtons" id="topButtons"><a href="teamAdmin.php"><h1>Team</h1></a></div></td><td><div class="unselectedButtons" id="topButtons"><a href="contactAdmin.php"><h1>Contact</h1></a></div>
</td><td><div class="unselectedButtons" id="topButtons"><a href="mediaAdmin.php"><h1>Media</h1></a></div></td><td><div class="unselectedButtons" id="topButtons"><a href="../fullSite.php"><h1>full site</h1></a></div></td></tr></table></div></td></tr><!-- headerEnd -->
<tr><td valign="top"><table><tr><td width="206px" valign="top">
<div id="subMenu">
<table style="margin-left:70px;margin-right:5px;margin-top:2px;" cellspacing="0px">
<tr><td class="subMenuTD"><div class="subMenu" id="subMenu_0"><a href="teamBio.php">
<span class="subText">Biographies</span></a></div></td></tr><tr><td class="smSpacer"></td></tr>
<tr><td class="subMenuTD"><div class="subMenu" id="subMenu_1"><a href="teamPhoto.php">
<span class="subText">Photographers</span></a></div></td></tr><tr><td class="smSpacer"></td></tr>
<tr><td class="subMenuTD"><div class="subMenu" id="subMenu_2"><a href="teamExt.php?edit=contractor">
<span class="subText">Contractors</span></a></div></td></tr><tr><td class="smSpacer"></td></tr>
<tr><td class="subMenuTD"><div class="subMenu" id="subMenu_3"><a href="teamExt.php?edit=trade">
<span class="subText">Trades</span></a></div></td></tr><tr><td class="smSpacer"></td></tr>
<tr><td class="subMenuTD"><div class="subMenu" id="subMenu_4"><a href="teamExt.php?edit=product">
<span class="subText">Products</span></a></div></td></tr><tr><td class="smSpacer"></td></tr>
<tr><td class="subMenuTD"><div class="subMenu" id="subMenu_5"><a href="teamExt.php?edit=consultant">
<span class="subText">Consultants</span></a></div></td></tr><tr><td class="smSpacer"></td></tr>
<tr><td class="subMenuTD"><div class="subMenu" id="subMenu_6"><a href="teamExt.php?edit=realtor">
<span class="subText">Realtors</span></a></div></td></tr><tr><td class="smSpacer"></td></tr>
<tr><td class="subMenuTD"><div class="subMenu" id="subMenu_7"><a href="teamExt.php?edit=interior_design">
<span class="subText">Interior Design</span></a></div></td></tr><tr><td class="smSpacer"></td></tr>

</table></div>
</div><!-- Sub Menu -->
</td><td valign="top"> 
<!-- Main Content -->
<div id="tFront">
<table id="quarterSegments"><tr><td align="left" valign="top" rowspan="2">
<div id="quarter1" class="quarterTops">
<div class="apImgDivFormat" style="width:224px; height:550px;position:relative;">      

<div id="apGetSide2" class="singleSide" style="width:224px;top:0px;<?php echo $showSingleSides; ?>">
<center>
<div class="showImg" id="apSide1Single" style="width:200px;height:428px;overflow:hidden;" title="side image">
<img src="<?php echo $topImg; ?>">
</div>
<div style="width:200px;height:11px;background-color:#fff;position:absolute;top:150px;left:12px;"></div>
<div class="lilButton" style="width:200px;height:15px;"><a href="javascript:void(0)" onClick="editImg('side1',0,0);">UPDATE</a></div>
</center></div>
 
<div id="apGetSide1" class="doubleSide" style="width:224px;<?php echo $showDoubleSides; ?>">
<center><div class="showImg" id="apSide1Top" style="width:200px;height:150px;overflow:hidden;" title="top side image">
<img src="<?php echo $topImg; ?>"></div>
<div class="lilButton" style="width:200px;height:15px;"><a href="javascript:void(0)" onClick="editImg('sideT',0,0);">UPDATE</a></div>
</center></div>
<div id="apGetSide2" class="doubleSide" style="width:224px;<?php echo $showDoubleSides; ?>" >
<center><div class="showImg" id="apSide1Bottom" style="width:200px;height:272px" title="bottom side image"><img src="<?php echo $btmImg; ?>"></div>
<div class="lilButton" style="width:200px;height:15px;"><a href="javascript:void(0)" onClick="editImg('sideB',0,0);">UPDATE</a>
</center></div>
<br>
 <span class="smallRadio"><b>STYLE:</b>
<form id="editTeamStatements" method="post">
<input type="radio" name="sideNum" class="sideNum" value="1" <?php echo $singleSides?>/>Single
<input type="radio" name="sideNum" class="sideNum" value="2" <?php echo $doubleSides?>/> Double</span>

<input type = "hidden" name = "ts1Title"  id="ts1TitleVal" value = "<?php echo $ts1Title; ?>" /> 
<input type = "hidden" name = "ts2Title"  id="ts2TitleVal" value = "<?php echo $ts2Title; ?>" /> 
<input type = "hidden" name = "ts1Text"  id="ts1TextVal" value = "<?php echo $ts1Text; ?>" /> 
<input type = "hidden" name = "ts2Text"  id="ts2TextVal" value = "<?php echo $ts2Text; ?>" /> 
<input type = "hidden" name = "tsTopImg"  id="tsTopImgVal" value = "<?php echo $topImg; ?>" /> 
<input type = "hidden" name = "tsBtmImg"  id="tsBtmImgVal" value = "<?php echo $btmImg; ?>" /> 
<input type = "hidden" name = "tsSideNum"  id="tsSideNumVal" value = "<?php echo $numImgs; ?>" /> 
 
</div>
</td><td>
<div id="quarter2" class="quarterTops" style="position:relative;">
<div id="quarter2Container">
<div id="quarter2Top" class="quarterSubs" style="height:160px;" >
<div class="editTextBtn" id="editTT1" title="Edit" style="position:absolute;right:5px;top:3px;"></div>
<span class="blockTitle" style="margin-bottom:5px;"><h1 id="showTT1T"><?php echo $ts1Title; ?></h1></span>
<div id="fstateContainer" class="scrollMe"> 
<div class="txtScroll" id="showTT1">
<?php echo $ts1Text; ?>
</div>

</div>
</div>
</div>
<div id="htmlHelp"><div class="absC"><div id="closeHtmlBtn" class="dBtn"></div><table><tr><td colspan="3"><h3>HTML CODES</h3></td></tr><tr><td><input value="<b>bold text</b>" size="30" readonly></td><td width="15px"></td><td><b>bold text</b></td></tr>
<tr><td><input value="<u>underlined text</u>" size="30" readonly></td><td width="15px"></td><td><u>underlined text</u></td></tr>
<tr><td><input value="<i>italic text</i>" size="30" readonly></td><td width="15px"></td><td><i>italic text</i></td></tr>
<tr><td><input value="<h1>header text</h1>" size="30" readonly></td><td width="15px"></td><td><h1>header text</h1></td></tr>
<tr><td><input value="<p>paragraph</p>" size="30" readonly></td><td width="15px"></td><td>paragraph</td></tr>
<tr><td><input value="<br>" size="30" readonly></td><td width="15px"></td><td>line break</td></tr>
<tr><td><textarea rows=2 cols="29" readonly><a href='http://www.oasis-ad.com'>text to link</a></textarea></td><td width="15px"></td><td><a href="#">text to link</a></td></tr><tr><td valign="bottom"><textarea rows=3 cols="29" readonly><img src='http://www.oasis-ad.com/graphics/oasisOGthm.png'></textarea></td><td width="25px"></td><td>
<img src="http://www.oasis-ad.com/graphics/oasisOGthm.png" height="60px"></td></tr></table></div></div>
</div>
<div id="quarter2Mid" class="quarterSubs" style="width:271px;overflow:hidden;">
<div class="editTextBtn" id="editTT2" title="Edit" style="position:absolute;right:5px;top:3px;"></div>
<span class="blockTitle" style="margin-bottom:5px;"><h1 id="showTT2T"><?php echo $ts2Title; ?></h1></span>
<div id="sstateContainer" class="scrollMe">
<div class="txtScroll" id="showTT2">
<?php echo $ts2Text; ?>
</div>
</div>
</div>
</div>
</td>
<td>
<div class="editTText" style="height:485px;width:321px;">
<div id="showHtmlHelp" style="right:11px;top:5px;"><a href="javascript:void(0)">&lt;/?&gt;</a></div>
<div id="editTTextInner" style="visibility:hidden;">
<input id="editTTitle" size=45 value="" maxlength="27">
<textarea id="editTText" rows=10 cols=49 spellcheck=true style="height:435px;width:300px;">
</textarea>
</div>
</form>
</div>
</td>
</tr>
<tr><td colspan="2"><div id="saveTeamButton" class="bigSaveButtons" style="height:33px;width:601px;">Save Statements</div></td></tr>
</table>
</div>


<!-- Main Content -->
</td>
</tr>
</table>
</div>

</body>

</html>