<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<META NAME="ROBOTS" CONTENT="NOINDEX, FOLLOW">
<head>
<link rel="shortcut icon" href="http://www.oasis-ad.com/graphics/oasisIcon.ico" type="image/x-icon">
<link href="../import/main2.css" rel="stylesheet" type="text/css"/>
<script src="../import/jQuery.js" type="text/javascript"></script> 
<script src="admin.js" type="text/javascript"></script><link href="admin.css" rel="stylesheet" type="text/css"/> 
<script src="../import/oScript.js" type="text/javascript"></script>
<?php
$hn="localhost";
$un="markmorr_SQL1";
$pd="OASIS-ad0920";
$db="markmorr_SQL";
$con = mysql_connect($hn,$un, $pd); 
if(!$con){ die('Could not connect: ' . mysql_error());}
else{mysql_select_db($db, $con);}
if($_POST["hs0Title"])
{
$hs0Img = $_POST['hs0ImgOG'];
if($_POST['hs0Img'] != $_POST['hs0ImgOG'])
{
	$newName = 'oasis_hs0Img.'.(end(explode(".",strtolower(trim($_POST['hs0Img']))))); 
	copy($_POST['hs0Img'],'../team/graphics/'.$newName);
	$hs0Img = $newName;
}

$hs1Img = $_POST['hs1ImgOG'];
if($_POST['hs1Img'] != $_POST['hs1ImgOG'])
{
	$newName = 'oasis_hs1Img.'.(end(explode(".",strtolower(trim($_POST['hs1Img']))))); 
	copy($_POST['hs1Img'],'../team/graphics/'.$newName);
	$hs1Img = $newName;
}
$hs2Img = $_POST['hs2ImgOG'];
if($_POST['hs2Img'] != $_POST['hs2ImgOG'])
{
	$newName = 'oasis_hs2Img.'.(end(explode(".",strtolower(trim($_POST['hs2Img']))))); 
	copy($_POST['hs2Img'],'../team/graphics/'.$newName);
	$hs2Img = $newName;
}
$hs3Img = $_POST['hs3ImgOG'];
if($_POST['hs3Img'] != $_POST['hs3ImgOG'])
{
	$newName = 'oasis_hs3Img.'.(end(explode(".",strtolower(trim($_POST['hs3Img']))))); 
	copy($_POST['hs3Img'],'../team/graphics/'.$newName);
	$hs3Img = $newName;
}
$updateSQL = "UPDATE teamEXT SET txt = '".$_POST["hs0Title"]."',website = '".$hs0Img."',projects = '".trim($_POST["hs0Txt"])."'  where name = 'hs0'";
mysql_query($updateSQL);

$updateSQL1 = "UPDATE teamEXT SET txt = '".$_POST["hs1Title"]."',website = '".$hs1Img."',projects = '".trim($_POST["hs1Txt"])."'  where name = 'hs1'";
mysql_query($updateSQL1);	

$updateSQL2 = "UPDATE teamEXT SET txt = '".$_POST["hs2Title"]."',website = '".$hs2Img."',projects = '".trim($_POST["hs2Txt"])."'  where name = 'hs2'";
mysql_query($updateSQL2);

$updateSQL3 = "UPDATE teamEXT SET txt = '".$_POST["hs3Title"]."',website = '".$hs3Img."',projects = '".trim($_POST["hs3Txt"])."'  where name = 'hs3'";
mysql_query($updateSQL3);
}
$empArr = array();
$Qstring = 'SELECT * FROM teamEXT WHERE ttype = \'emp\' ORDER BY tOrder';
			 $result = mysql_query($Qstring);
			 while($emp=mysql_fetch_array($result)){
			 array_push($empArr, array($emp[txt],$emp[website],$emp[projects],$emp[name],'../team/graphics/'.$emp[website]));			 
			 }
			
$singleSides = "";
$doubleSides = "";
$showSingleSides = "";
$showDoubleSides = "";
if($numImgs != '2'){$singleSides = "checked"; $showDoubleSides="display:none;";}
else{$doubleSides = "checked";$showSingleSides="display:none;";}
										
		
?>
<title>EDIT Biographies</title> 
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
#quarter2Container{position:relative;overflow:hidden;width:271px}

h5{font-size:14px;font-weight:bolder;text-transform:uppercase;display:block;padding-left:8px;padding-top:3px;line-height:16px;letter-spacing:1px}
h2{font-size:14px;font-weight:bolder;text-transform:uppercase;display:block;padding-top:3px;line-height:16px;}

.bText{position:absolute;top:0;left:0}
.bText2{position:absolute;top:0;left:0;width:100%;text-align:center;}
#quarter3{width:140px}
#quarter3Container{position:relative;overflow:hidden;width:131px}
#quarter4{width:274px}
#quarter4Container{position:relative;overflow:hidden;width:100%;height:484px;background-color:#C5C7C8;margin-bottom:11px}
.tmOverLayTxt{position:absolute;width:131px;text-align:center;font-family:"Arial Narrow", Helvetica, sans-serif;color:#fff;font-size:14px;font-weight:bolder;text-transform:uppercase;line-height:20px;display:inline;left:0;bottom:2px}
.pOver{width:100%;height:100%;background-color:#a1a3a5;display:none;position:absolute;top:0;left:0}

#teamBioScroll{position:relative;overflow:hidden;width:100%;height:484px;margin-bottom:11px}
.teamBio{position:absolute;top:0;left:0;height:484px;background-color:#C5C7C8;visibility:hidden;width:274px}
#OHS0{visibility:hidden;display:none}
#bHS0{visibility:visible}
#quarter1Top,#quarter2Top,#HS0{height:160px;}
#quarter1Mid,#quarter2Mid{height:313px;}
.teamTxtFormat a:hover,.sixSubsTxt a:hover{text-decoration:none;color:#eee}
#HS1,#HS2,#HS3{height:97px}

#bio0{height:446px;width:255px;margin-left:10px;}
#bio1{height:446px;width:255px;margin-left:10px;}
#bio2{height:446px;width:255px;margin-left:10px;}
#bio3{height:446px;width:255px;margin-left:10px;}
#quarter4{font-size:16px;font-family:"Arial Narrow", Helvetica, sans-serif;color:#fff;text-align:left;}
h3{font-size:24px;font-weight:bold;}
</style>
<script>
$.support.touch = 'ontouchend' in document;
var mobile = $.support.touch;
var cBio = 0;
var busyP = false;
var busyB = false;
var cP = 0;
var me;
var cPZ = 10;

phArr.push(new pPhoto("HS0","<?php echo $empArr[0][4]; ?>","131,160","","","showImgHS0","-1",".png",0));
phArr.push(new pPhoto("HS1","<?php echo $empArr[1][4]; ?>","131,97","","","showImgHS1","-1",".png",0));
phArr.push(new pPhoto("HS2","<?php echo $empArr[2][4]; ?>","131,97","","","showImgHS2","-1",".png",0));
phArr.push(new pPhoto("HS3","<?php echo $empArr[3][4]; ?>","131,97","","","showImgHS3","-1",".png",0));
$(document).ready(function()
{
	$('#showHtmlHelp').showHtmlHelp({'l':0,'t':0,'h':'484px','w':'271px'});
	$('.editTText').editTextBox ();
	$('.editTextBtn').mouseenter(function() {$(this).css('backgroundPosition', '0px 30px');})
   			 		 .mouseleave(function(){$(this).css('backgroundPosition', '0px 61px');});
	$('.dBtn').mouseenter(function() {$(this).css('backgroundPosition', '0px 92px');})
   			  .mouseleave(function(){$(this).css('backgroundPosition', '0px 122px');});

	$('#saveTeamButton').click(function(){
		if(ok2Save){
		$('#hs0TitleVal').attr('value',$('#showHS0T').html());
		$('#hs0TxtVal').attr('value',$('#showHS0').html());
		var newSrc = $('#showImgHS0').find('img').attr('src');
		$('#hs0ImgVal').attr('value',newSrc);
		
		$('#hs1TitleVal').attr('value',$('#showHS1T').html());
		$('#hs1TxtVal').attr('value',$('#showHS1').html());
		newSrc = $('#showImgHS1').find('img').attr('src');
		$('#hs1ImgVal').attr('value',newSrc);
		
		$('#hs2TitleVal').attr('value',$('#showHS2T').html());
		$('#hs2TxtVal').attr('value',$('#showHS2').html());
		newSrc = $('#showImgHS2').find('img').attr('src');
		$('#hs2ImgVal').attr('value',newSrc);
		
		$('#hs3TitleVal').attr('value',$('#showHS3T').html());
		$('#hs3TxtVal').attr('value',$('#showHS3').html());
		newSrc = $('#showImgHS3').find('img').attr('src');
		$('#hs3ImgVal').attr('value',newSrc);
		document.forms['editTeamStatements'].submit();		
		}

		});
	$('.headShots').mousedown(function(){
				if(busyB){return;}
				var id = $(this).attr('id');				
				n = parseInt(id.substr(2));
				if(n != cBio)
				{
					switchBio(n);
					$('#O'+id).css('visibility','hidden');
				}
						});
	if(!mobile)
	{
		$('.headShots').mouseenter(function() {$('#O'+$(this).attr('id')).fadeOut(50)})
		.mouseleave(function() { $('#O'+$(this).attr('id')).fadeIn(300)});
	}
	

var bTime = 300;
function switchBio(n)
 {	
	  busyT = true;
	 $('#OHS'+cBio).css({'visibility':'visible','display':'none'});
	 $('#OHS'+cBio).fadeIn(bTime);
	  if(n<cBio)
	  {
	   $('#bHS'+n).css({'left':'-285px','visibility':'visible'});		 
	   $('#bHS'+n).animate({left:'0px'},bTime);	
	   $('#bHS'+cBio).animate({left:'285px'},bTime, function(){doneBSwitch(n)});
	  
	  }
	  else
	  {
	   $('#bHS'+n).css({'left':'285px','visibility':'visible'});		 
	   $('#bHS'+n).animate({left:'0px'},bTime);	
	   $('#bHS'+cBio).animate({left:'-285px'},bTime, function(){doneBSwitch(n)});
	  }
	  
 }
 
 function doneBSwitch(n)
 {
	 	$('#bHS'+cBio).css({'visibility':'hidden','top':'0px','left':'0px'});
		cBio=n;
		busyB = false;
 }
$('#subMenu').selectMENU({'shD':false,'sD':'#A1A3A5','cD':'subMenu_0'});
$('.scrollMe').aScroll({'mobile':$.support.touch});
});
</script>
</head>
<body>
<table id="mainContainerTable"><tr><td><!-- headerStart --><div id="mainMenu"> <div id="logo"><div id="goHome" onClick="(window.location = 'http://oasis-ad.com/admin')"></div></div><div id="mainNav"><table id="topButtonsSpaced"><tr><td><div class="unselectedButtons" id="topButtons" style="width:129px;"><a href="index.php"><h1>Home Page</h1></a></div></td><td><div class="unselectedButtons" id="topButtons" style="width:129px;"><a href="portfolioAdmin.php"><h1>Portfolio</h1></a></div></td><td><div class="unselectedButtons" id="topButtons"><a href="processAdmin.php"><h1>Process</h1></a></div></td><td><div class="selectedButtons" id="topButtons"><a href="teamAdmin.php"><h1>Team</h1></a></div></td><td><div class="unselectedButtons" id="topButtons"><a href="contactAdmin.php"><h1>Contact</h1></a></div>
</td><td><div class="unselectedButtons" id="topButtons"><a href="mediaAdmin.php"><h1>Media</h1></a></div></td><td><div class="unselectedButtons" id="topButtons"><a href="../fullSite.php"><h1>full site</h1></a></div></td></tr></table></div></div></td></tr><!-- headerEnd -->
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
</td><td valign="top" background-color="#000"> 
<!-- Main Content -->
<div id="tFront">
<table id="quarterSegments"><tr><td align="left" valign="top">
<div id="quarter3" class="quarterTops">
<div id="quarter3Container">
<div id="HS0" class="headShots">
<div id="showImgHS0"><img src="<?php echo $empArr[0][4]; ?>"></div>
<div class="imageOverlayToggle" id="OHS0"></div>
<div class="tmOverLayTxt" id="showHS0T"><?php echo $empArr[0][0]; ?></div></div>
<div id="HS1" class="headShots">
<div id="showImgHS1"><img src="<?php echo $empArr[1][4]; ?>"></div>
<div class="imageOverlayToggle" id="OHS1"></div>
<div class="tmOverLayTxt" id="showHS1T"><?php echo $empArr[1][0]; ?></div></div>
<div id="HS2" class="headShots">
<div id="showImgHS2"><img src="<?php echo $empArr[2][4]; ?>"></div>
<div class="imageOverlayToggle" id="OHS2"></div>
<div class="tmOverLayTxt" id="showHS2T"><?php echo $empArr[2][0]; ?></div></div>
<div id="HS3" class="headShots">
<div id="showImgHS3"><img src="<?php echo $empArr[3][4]; ?>"></div>
<div class="imageOverlayToggle" id="OHS3"></div>
<div class="tmOverLayTxt" id="showHS3T"><?php echo $empArr[3][0]; ?></div></div>
</div>
</div>
</td><td>
<div id="quarter4" class="quarterTops">
<div id="teamBioScroll">
<div id="htmlHelp"><div class="absC"><div id="closeHtmlBtn" class="dBtn"></div><table><tr><td colspan="3"><h3>HTML CODES</h3></td></tr><tr><td><input value="<b>bold text</b>" size="30" readonly></td><td width="15px"></td><td><b>bold text</b></td></tr>
<tr><td><input value="<u>underlined text</u>" size="30" readonly></td><td width="15px"></td><td><u>underlined text</u></td></tr>
<tr><td><input value="<i>italic text</i>" size="30" readonly></td><td width="15px"></td><td><i>italic text</i></td></tr>
<tr><td><input value="<h1>header text</h1>" size="30" readonly></td><td width="15px"></td><td><h1>header text</h1></td></tr>
<tr><td><input value="<p>paragraph</p>" size="30" readonly></td><td width="15px"></td><td>paragraph</td></tr>
<tr><td><input value="<br>" size="30" readonly></td><td width="15px"></td><td>line break</td></tr>
<tr><td><textarea rows=2 cols="29" readonly><a href='http://www.oasis-ad.com'>text to link</a></textarea></td><td width="15px"></td><td><a href="#">text to link</a></td></tr><tr><td valign="bottom"><textarea rows=3 cols="29" readonly><img src='http://www.oasis-ad.com/graphics/oasisOGthm.png'></textarea></td><td width="25px"></td><td>
<img src="http://www.oasis-ad.com/graphics/oasisOGthm.png" height="60px"></td></tr></table></div></div>
<div class="teamBio" id="bHS0">
<div class="editTextBtn" id="editHS0" title="Edit" style="position:absolute;right:5px;top:3px;"></div>
<span class="blockTitle" style="margin-bottom:5px;"><h1>Biography</h1></span>
<div id="bio0" class="scrollMe">
<div class="txtScroll" id="showHS0"><?php echo $empArr[0][2]; ?></div>
</div>
</div>

<div class="teamBio" id="bHS1">
<div class="editTextBtn" id="editHS1" title="Edit" style="position:absolute;right:5px;top:3px;"></div>
<span class="blockTitle" style="margin-bottom:5px;"><h1>Biography</h1></span>
<div id="bio1" class="scrollMe">
<div class="txtScroll" id="showHS1"><?php echo $empArr[1][2]; ?></div>
</div>
</div>

<div class="teamBio" id="bHS2">
<div class="editTextBtn" id="editHS2" title="Edit" style="position:absolute;right:5px;top:3px;"></div>
<span class="blockTitle" style="margin-bottom:5px;"><h1>Biography</h1></span>
<div id="bio2" class="scrollMe">
<div class="txtScroll" id="showHS2"><?php echo $empArr[2][2]; ?></div>
</div>
</div>

<div class="teamBio" id="bHS3">
<div class="editTextBtn" id="editHS3" title="Edit" style="position:absolute;right:5px;top:3px;"></div>
<span class="blockTitle" style="margin-bottom:5px;"><h1>Biography</h1></span>
<div id="bio3" class="scrollMe">
<div class="txtScroll" id="showHS3"><?php echo $empArr[3][2]; ?></div>
</div>
</div>



</div>
</div>
</td>
<td rowspan="2">
<form id="editTeamStatements" method="post">
<input type = "hidden" name = "hs0Title"  id="hs0TitleVal"/> 
<input type = "hidden" name = "hs0Txt"  id="hs0TxtVal"/>
<input type = "hidden" name = "hs0Img"  id="hs0ImgVal" value = "<?php echo $empArr[0][1]; ?>" /> 
<input type = "hidden" name = "hs0ImgOG"  value = "<?php echo $empArr[0][1]; ?>" /> 

<input type = "hidden" name = "hs1Title"  id="hs1TitleVal"/> 
<input type = "hidden" name = "hs1Txt"  id="hs1TxtVal"/>
<input type = "hidden" name = "hs1Img"  id="hs1ImgVal" value = "<?php echo $empArr[1][1]; ?>" /> 
<input type = "hidden" name = "hs1ImgOG"  value = "<?php echo $empArr[1][1]; ?>" /> 

<input type = "hidden" name = "hs2Title"  id="hs2TitleVal"/> 
<input type = "hidden" name = "hs2Txt"  id="hs2TxtVal"/>
<input type = "hidden" name = "hs2Img"  id="hs2ImgVal" value = "<?php echo $empArr[2][1]; ?>" />
<input type = "hidden" name = "hs2ImgOG"  value = "<?php echo $empArr[2][1]; ?>" /> 

<input type = "hidden" name = "hs3Title"  id="hs3TitleVal"/> 
<input type = "hidden" name = "hs3Txt"  id="hs3TxtVal"/>
<input type = "hidden" name = "hs3Img"  id="hs3ImgVal" value = "<?php echo $empArr[3][1]; ?>" />
<input type = "hidden" name = "hs3ImgOG"  value = "<?php echo $empArr[3][1]; ?>" /> 


<div class="editTText" style="height:555px;width:412px;margin-left:7px;">
<div id="showHtmlHelp" style="right:11px;top:5px;"><a href="javascript:void(0)">&lt;/?&gt;</a></div>
<div id="editTTextInner" style="visibility:hidden;">
<table><tr><td><input id="editTTitle" size=25 value="" maxlength="15"></td>
<td>
<div class="lilButton" style="width:100px;height:17px;margin-top:8px; margin-left:11px;text-align:center;">
<a href="javascript:void(0)" onClick="editImg(hsID,0,0);">UPDATE Image</a></div></td></tr></table>
<textarea id="editTText" rows=10 cols=49 spellcheck=true style="height:505px;width:395px;">
</textarea>
</form>
</div>
</div>
</td>
</tr>
<tr><td colspan="2"><div id="saveTeamButton" class="bigSaveButtons" style="height:40px;width:416px;">Save Bios</div></td><td></td></tr>
</table>
</div>


<!-- Main Content -->
</td>
</tr>
</table>
</div>

</body>

</html>