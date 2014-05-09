<html>
<head>

<META NAME="ROBOTS" CONTENT="NOINDEX, FOLLOW">
			<script src="http://www.caridadcharity.com/importMe/jquery-1.3.2.min.js" type="text/javascript"></script> 
            <script src="testJQ.js" type="text/javascript"></script>

<style>
*{background-color:none;margin:0;padding:0}
body{font-family:"Arial Narrow", Helvetica, sans-serif;font-size:14px;height:100%;text-align:center;width:100%}
a{text-decoration:none}
#logo{background:url(../graphics/OasisAdminLogo.png) no-repeat;height:63px;position:relative;width:940px}
.mainNav{left:239px;position:absolute;top:39px}
#goHome{cursor:pointer;height:60px;left:0;position:absolute;top:0;width:255px}
#mainMenu{height:66px;margin-top:10px;position:relative}
#mainNav{left:70px;overflow:hidden;position:absolute;top:37px;width:1000px}
.unselectedButtons a{background-color:#C5C7C8;display:block;height:100%;text-align:center;width:100%}
H1{color:#fff;font-size:14px;font-weight:700;padding-top:1px;text-transform:uppercase}
.selectedButtons a{background-color:#A1A3A5;display:block;height:100%;text-align:center;width:100%}
#topButtons{height:20px;margin-right:9px;width:131px}
.subMenuTD{background-color:#000;height:72px;width:129px}
.subMenuTD a{display:table-cell;height:72px;text-align:center;vertical-align:center;width:129px}
.subText{color:#fff;display:block;font-size:12px;font-weight:700;padding-top:25px;text-transform:uppercase}
.smSpacer{height:11px;width:100%}
.subMenu a:hover{background-color:#A1A3A5}
.subMenu a:active{background-color:#999}
.subMenu {background-color:#C5C7C8;}
input,textarea
{
	font-family:"Arial Narrow", Helvetica, sans-serif;
	color:#333;
	background-image: url(../graphics/inputShadow.png);
	border:1px solid #999;
}
h6
{font-weight:bold;color:#666;font-size:12px;text-transform:uppercase;}
h4
{font-size:11px; text-transform:uppercase;}
.showImgBorder
{
	border: 1px dashed #AAA;
	background-color:#fff;
}
.showImg{background-color:#e9e9e9;background:url(../graphics/missingTHM.png) #e9e9e9 no-repeat center;border:1px solid #ccc;margin:5px;overflow:hidden;cursor:pointer;position:relative;}

.showImg img{width:inherit;height:inherit;}

.saveBtn
{	
	background-color:#fafafa;
	background-image:none;
	border: 1px outset #ccc;
	cursor:pointer;
}
.saveBtn P
{
	font-size:20px;
	font-weight:bold;
	text-transform:uppercase;
	color:#999;
}
.adminTxt
{
	font-family:"Arial Narrow", Helvetica, sans-serif;
	text-transform:uppercase;
	color:#999;
	font-size:11px;
}

#cCornerTxt
{
	display:block;
	width:273px;
	height:235px;
	background-color:#c5c7c8;
	position:relative;
	text-align:center;
	cursor:pointer;
}
#cCornerTxtfrmt
{
	display:block;
	text-align:right;
	position:absolute;
	right:11px;
	bottom:11px;
	width:255px;
	font-size:14px;
	font-family:"Arial Narrow", Helvetica, sans-serif;
	color:#A1A3A5;
	font-weight:bold;
	line-height:23px;
	word-spacing:2px;	
	text-align:right;
	
}
#cCornerShow
{
	font-size:14px;
	font-family:"Arial Narrow", Helvetica, sans-serif;
	color:#A1A3A5;
	font-weight:bold;
	line-height:23px;
	word-spacing:2px;	
}
#cCornerEdit
{
	display:block;
	width:412px;
	height:255px;
	background-color:#c5c7c8;
	position:relative;
	text-align:center;
	position:absolute;
	top:100px;
	left:215px;
	display:none;
}
#cCornerTxtEdit
{
	margin-top:10px;	
 	font-size:14px;
	width:260px;
	height:155px;
}
.copyMe
{
	font-size:11px;
	color:#666;
	background-color:#CCC;
	font-family:"Courier New", Courier, monospace;
	letter-spacing:-1px;
}
.smallRadio
{
	font-size:11px;
	letter-spacing:-1px;
	font-weight:bold;
	text-transform:uppercase;
	color:#BBB;
}
.noteText 
{
	font-size:10px;
	font-weight:bold;
	color:#777;
	letter-spacing:2px;
	word-spacing:4px;
	text-transform:none;
}
#cCover1
{
	width:7px;
	height:297px;
	background-color:#fff;
	position:absolute;
	top:5px;
	left:143px;
}
#cCover2
{
	height:7px;
	width:402px;
	background-color:#fff;
	position:absolute;
	top:106px;
	left:5px;
}
#cCover3
{
	width:255px;
	height:187px;
	background-color:#eee;
	position:absolute;
	top:113px;
	left:150px;
}
</style>
<script>

var bgImgs = '#cont1Img';
var oldCorner = "";

$(document).ready(function()
{
$('#cancelCornerEdits').click(function()
{
	$('#cCornerTxt').html(oldCorner);
	$('#cCornerEdit').fadeOut(100);
	
});
$('#saveCornerEdits').click(function()
{
	$('#cCornerEdit').fadeOut(100);	
});

$('#cCornerTxt').click(function()
{
	oldCorner = $(this).html();
	var mH = $(this).position();
	$('#cCornerEdit').css({'top':mH.top-20,'left':mH.left-422});
	$('#cCornerEdit').fadeIn(100);
});
$('#cCornerTxtEdit').keyup(function() {
  $('#cCornerTxtfrmt').html($(this).val());
});
$('.contImg').click(function()
				   {
					   if(this.value == 1)
							{
								$(bgImgs).css('display','none');
								$('#cont1Img').css('display','block');
								bgImgs='#cont1Img';
								$('#cImgSize').html('w:656px h:484px');
							}
						else if(this.value == 2)
							{
								$(bgImgs).css('display','none');
								$('#cont2Top').css('display','block');
								bgImgs='#cont2Top';
								$('#cImgSize').html('w:656px h:165px<br>w:227px h:308px');
							}
						else if(this.value == 3)
							{
								$(bgImgs).css('display','none');
								$('#cont2Side').css('display','block');
								bgImgs='#cont2Side';
								$('#cImgSize').html('w:227px h:484px<br>w:420px h:165px');
							}
						else if(this.value == 4)
							{
								$(bgImgs).css('display','none');
								$('#cont3Img').css('display','block');
								bgImgs='#cont3Img';
								$('#cImgSize').html('w:227px h:165px<br>w:420px h:165px<br>w:227px h:308px');
							}
				   });

$('#subMenu').selectMENU({'shD':false,'sD':'#A1A3A5','cD':'subMenu_1'});
});
</script>


</head><body><table id="mainContainerTable"><tr><td><!-- headerStart --><div id="mainMenu"> <div id="logo"><div id="goHome" onClick="(window.location = 'http://oasis-ad.com/admin')"></div></div><div id="mainNav"><table id="topButtonsSpaced"><tr><td><div class="unselectedButtons" id="topButtons" style="width:129px;"><a href="nav.php?nav=1-1"><h1>Home Page</h1></a></div></td><td><div class="unselectedButtons" id="topButtons" style="width:129px;"><a href="inner1.php?nav=2-1"><h1>Portfolio</h1></a></div></td><td><div class="unselectedButtons" id="topButtons"><a href="?nav=3-1"><h1>Process</h1></a></div></td><td><div class="unselectedButtons" id="topButtons"><a href="?nav=4-1"><h1>Team</h1></a></div></td><td><div class="selectedButtons" id="topButtons"><a href="?nav=5-1"><h1>Contact</h1></a></div>
</td><td><div class="unselectedButtons" id="topButtons"><a href="?nav=6-1"><h1>Media</h1></a></div></td><td><div class="unselectedButtons" id="topButtons"><a href="?nav=7-1"><h1>Dropbox</h1></a></div></td></tr></table></div></td></tr><!-- headerEnd -->
<tr><td valign="top"><table><tr><td width="208px" valign="top">
<div id="subMenu">
<table style="margin-left:70px;margin-right:9px;" cellspacing="0px">
<tr><td class="subMenuTD"><div class="subMenu" id="subMenu_1"><a href="javascript:void(0)">
<span class="subText">Contact Page</span></a></div></td></tr><tr><td class="smSpacer"></td></tr>
<tr><td class="subMenuTD"><div class="subMenu" id="subMenu_2"><a href="javascript:void(0)">
<span class="subText">Site Credits</span></a></div></td></tr><tr><td class="smSpacer"></td></tr>
</table></div>
</div><!-- Sub Menu -->
</td><td>

<table>
<tr><td>
<h6>ADDRESS 1</h6>
<form name="genSiteInfo" method="post" action="?show=home&sub=genInfo">
<table class="adminTxt" cellspacing="3px;">
<tr><td>Email:</td><td><input name="email" size=25 value="info@oasis-ad.com" onChange="okSave();"></td></tr>
<tr><td colspan="2" height="5px"></td></tr>
<tr><td>Phone:</td><td><input name="phone" size=25 value="858.273.5632" onChange="okSave();"><br></td></tr>
<tr><td colspan="2" height="5px"></td></tr>
<tr><td>Fax:</td><td><input name="fax" size=25 value="858.273.5655" onChange="okSave();"><br></td></tr>
<tr><td colspan="2" height="5px"></td></tr>
<tr><td>Street:</td><td><input name="street" size=25 value="1015 turquoise street" onChange="okSave();"><br></td></tr>
<tr><td colspan="2" height="5px"></td></tr>
<tr><td>Suite:</td><td><input name="number" size=25 value="suite 2" onChange="okSave();"><br></td></tr>
<tr><td colspan="2" height="5px"></td></tr>
<tr><td>City:</td><td><input name="city" size=25 value="San Diego" onChange="okSave();"><br></td></tr>
<tr><td colspan="2" height="5px"></td></tr>
<tr><td>State:</td><td><input name="state" size=25 value="CA" onChange="okSave();"><br></td></tr>
<tr><td colspan="2" height="5px"></td></tr>
<tr><td>Zip:</td><td><input name="zip" size=25  class="92109" value="<?php echo $zip;?>" onChange="okSave();"><br></td></tr>
<tr><td colspan="2" height="5px"></td></tr>
</table>

</td><td width="10px"></td><td>

<h6>ADDRESS 2</h6>
<table class="adminTxt" cellspacing="3px;">
<tr><td>Email:</td><td><input name="email2" size=25 value="info@oasis-ad.com" onChange="okSave();"></td></tr>
<tr><td colspan="2" height="5px"></td></tr>
<tr><td>Phone:</td><td><input name="phone2" size=25 value="408.761.2764" onChange="okSave();"><br></td></tr>
<tr><td colspan="2" height="5px"></td></tr>
<tr><td>Fax:</td><td><input name="fax2" size=25 value="" onChange="okSave();"><br></td></tr>
<tr><td colspan="2" height="5px"></td></tr>
<tr><td>Street:</td><td><input name="street2" size=25 value="" onChange="okSave();"><br></td></tr>
<tr><td colspan="2" height="5px"></td></tr>
<tr><td>Suite:</td><td><input name="number2" size=25 value="" onChange="okSave();"><br></td></tr>
<tr><td colspan="2" height="5px"></td></tr>
<tr><td>City:</td><td><input name="city2" size=25 value="APTOS" onChange="okSave();"><br></td></tr>
<tr><td colspan="2" height="5px"></td></tr>
<tr><td>State:</td><td><input name="state2" size=25 value="CA" onChange="okSave();"><br></td></tr>
<tr><td colspan="2" height="5px"></td></tr>
<tr><td>Zip:</td><td><input name="zip2" size=25  value="95003" onChange="okSave();"><br></td></tr>
<tr><td colspan="2" height="5px"></td></tr>
</table>
</form>

</td><td width="28px"></td>
<td valign="top">
<h6>Corner Text</h6>
<div id="cCornerTxt">
<span id="cCornerTxtfrmt">
The firm is composed of a strong team of<br>
talented individuals focused
and dedicated to<br> the firm's goal of adding value by creating<br>
 quality living environment for our clients. This<br> goal is achieved through the collective hands<br> on experience of the team designing homes<br> and monitoring the contruction.
</span>

</div>

</td>
<td><div class="saveBtn" id="saveContact1" style="height:150px;width:128px;margin-left:9px;"><center><p style="padding-top:30px;">SAVE<br>ALL<br>CHANGES</p></center></td>

</tr><tr><td colspan="4" height="7px"></td></tr>
<tr><td colspan="4">
<h6>CONTACT SIDE IMAGE</h6>
<div style="position:relative;width:411px;height:307px;">
<div class="showImgBorder" style="height:305px;width:409px;" id="cont1Img">
<div class="showImg" style="width:399px;height:294px;border:none;"><img src="../graphics/contact1Img.png" width="399px"></div></div>

<div class="showImgBorder" style="height:305px;width:409px;display:none;" id="cont2Top">
<div class="showImg" style="width:399px;height:100px;border:none;"><img src="../graphics/contact2Top.png" width="399px"></div>
<div class="showImg" style="width:138px;height:188px;border:none;"><img src="../graphics/contact2Side.png" width="138px"></div>
</div>
<div class="showImgBorder" style="height:305px;width:409px;display:none;" id="cont2Side">
<table><tr><td>
<div class="showImg" style="width:138px;height:294px;border:none;margin-right:2px;"><img src="../graphics/contact3side.png" width="138px"></div>
</td><td valign="top">
<div class="showImg" style="width:255px;height:100px;border:none;margin-left:0px;"><img src="../graphics/contact3top.png" width="255px"></div>
</td>
</tr></table>
</div>

<div class="showImgBorder" style="height:305px;width:409px;display:none;" id="cont3Img">
<table><tr><td>
<div class="showImg" style="width:138px;height:100px;border:none;margin-right:0px;margin-bottom:0px;"><img src="../graphics/contact1a.png" width="138px"></div>
</td><td valign="top">
<div class="showImg" style="width:255px;height:100px;border:none;margin-left:0px;margin-bottom:0px;"><img src="../graphics/contact4t2.png" width="255px"></div>
</td>
</tr>
<tr><td><div class="showImg" style="width:138px;height:190px;border:none;margin-top:0px;margin-right:2px;"><img src="../graphics/contact1c.png" width="138px"></div></td><td></td></tr></table>
</div>



<div id="cCover1"></div><div id="cCover2"></div>
<div id="cCover3"><center>
<table cellspacing="10px"><tr>
<td colspan="2" height="50px"><span class="noteText" id="cImgSize">w:656px h:484px</span></td>
</tr><tr><td>
<input type="radio" name="contImg" class="contImg" value="1" checked/></td>
<td width="50px"><span class="smallRadio">1 Image</span></td></tr><tr><td>
<input type="radio" name="contImg" class="contImg" value="2"/></td><td width="90px"><span class="smallRadio">2 Images - 1 top</span>
</td></tr><tr><td>
<input type="radio" name="contImg" class="contImg" value="3"/></td><td width="90px"><span class="smallRadio">2 Images - 1 side</span></td></tr><tr><td>
<input type="radio" name="contImg" class="contImg" value="4"/> </td><td width="50px"><span class="smallRadio">3 Images</span></td></tr></table>
</center>
</div></div>
</div>

</td><td colspan="2">
<h6>MAP</h6>
<div style="position:relative;width:411px;height:307px;">
<div class="showImgBorder" style="height:305px;width:409px;" id="cont1Img">
<div class="showImg" style="width:399px;height:294px;border:none;"><img src="../graphics/map.png" width="399px"></div></div>



</td></tr>
</table>
<div id="cCornerEdit">
<div style="width:100%;heigth:20px;background-color:#fff;text-align:left;"><h6>EDIT CORNER TEXT</h6></div>
<table><tr><td>
<table cellspacing="5px" id="cCornerShow">
<tr><td colspan="2"><h6>HTML BASICS:</h6></td></tr>
<tr><td>line break</td><td><input size=10  value="<br>" readonly="readonly" class="copyMe"></td></tr>
<tr><td>paragraph</td><td><input size=10  value="<p>" readonly="readonly" class="copyMe"></td></tr>
<tr><td><u>underline</u></td><td><input size=10  value="<u>Text</u>" readonly="readonly" class="copyMe"></td></tr>
<tr><td><i>italic</i></td><td><input size=10  value="<i>Text</i>" readonly="readonly" class="copyMe"></td></tr>
</table>
</td><td>
<textarea cols=47 rows=9 name="cCornerTxtEdit" id="cCornerTxtEdit">
The firm is composed of a strong team of<br>
talented individuals focused
and dedicated to<br> the firm's goal of adding value by creating<br>
 quality living environment for our clients. This<br> goal is achieved through the collective hands<br> on experience of the team designing homes<br> and monitoring the contruction.
</textarea>
</td></tr><tr><td colspan="2" height="4px"></td></tr><tr><td align="center">
<div class="saveBtn" id="cancelCornerEdits" style="height:40px;width:100px;"><center><p style="padding:9px;">Cancel</p></center>
</div>
</td><td align="center">
<div class="saveBtn" id="saveCornerEdits" style="height:40px;width:150px;"><center><p style="padding-top:9px;">Done</p></center>
</div>
</td></tr></table>
</div>

</body>

</html>