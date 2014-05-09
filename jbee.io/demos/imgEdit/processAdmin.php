<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<META NAME="ROBOTS" CONTENT="NOINDEX, FOLLOW">
<head>
 <?php
include 'admin.php';cSQL('SQL');
$t='../process/';

if($_POST["allTXTChanges"])
{
	$toChg =  explode("%!%",$_POST["allTXTChanges"]);
	foreach ($toChg as $chgMe)
	{
		$np =  explode("!%!",$chgMe);
	$chgMe = "UPDATE process SET title='".$np[1]."',txt='".$np[2]."',nSide='".$np[3]."',nTop='".$np[4]."' WHERE id =".$np[0].";";
		mysql_query($chgMe);
	}
}

if($_POST["allIMGChanges"])
{
	$toChg =  explode("%!%",$_POST["allIMGChanges"]);
	$iNm = array("sImg1", "sImg2", "tImg1", "tImg2");
	foreach ($toChg as $chgMe)
	{
	 $nI =  explode("!%!",$chgMe);
	 $iCt = 0;
	 $procID = array_shift($nI);
	 $chgImgStr = '';
	 foreach ($nI as $nImg)
		 {	
		 	if($nImg != -1)
			{	
		  	 $newName = 'process'.$procID.$iNm[$iCt].'.'.(end(explode(".",strtolower(trim($nImg))))); 
		     copy($nImg,'../process/graphics/'.$newName);
		  	 $chgImgStr .= ' '.$iNm[$iCt].'="graphics/'.$newName.'"';		  	
			}
			 $iCt = $iCt+1;
		 }
	 	$chgMe = "UPDATE process SET".$chgImgStr."  WHERE id =".$procID.";";
		mysql_query($chgMe);
	}
}

$procArr=array();
$Qstring = "SELECT * FROM process;";
$result = mysql_query($Qstring);
while($cat=mysql_fetch_array($result)){
	$procArr[$cat[id]] = array(decodeQ($cat[title]),decodeQ($cat[txt]),$cat[nSide],$cat[nTop],$t.$cat[sImg1],$t.$cat[sImg2],$t.$cat[tImg1],$t.$cat[tImg2]); }	
$procArrJS = '';$procHTML = '';	$c = 0;
foreach($procArr as $p)
{
//[0]    [1]   [2]  [3]   [4]  [side1][side2][t1][t2]
//title,text,nSide,nTop, changed
$procArrJS .= 'procArr.push(new Array("'.$p[0].'","'.$p[1].'","'.$p[2].'","'.$p[3].'",0,"'.$p[4].'","'.$p[5].'","'.$p[6].'","'.$p[7].'"));';

if($p[2] === '2'){$sOne = '';$sOneShow = 'display:none;'; $sTwo = 'checked';$sTwoShow = '';}
else{$sOne = 'checked';$sOneShow = '';$sTwo = '';$sTwoShow = 'display:none;';}

if($p[3] === '2'){$tOne = '';$tOneShow = 'display:none;';$tTwo = 'checked';$tTwoShow = '';}
else{$tOne = 'checked';$tOneShow = '';$tTwo = '';$tTwoShow = 'display:none;';}$procHTML .= '
<div id="process'.$c.'" class="processEdit"><table><tbody><tr><td colspan="4" height="5px"></td></tr>
<td rowspan="2" width="130"><div style="margin-right:7px;margin-left:6px;"><div class="showImgBorder" id="proc'.$c.'S2" style="height:257px;width:126px;margin-bottom:11px;'.$sTwoShow.'">
<div class="showImg" style="width:115px;margin-bottom:2px;" id="proc'.$c.'S2L"><img src="'.$p[4].'" width="115px"></div><div class="showImg" style="width:115px;margin-top:2px;" id="proc'.$c.'S2R"><img src="'.$p[5].'" width="115px"></div></div><div class="showImgBorder" id="proc'.$c.'S1" style="height:257px;width:126px;margin-bottom:5px;overflow:hidden;position:relative;'.$sOneShow.'"><div class="showImg" style="width:115px;border:none;" id="proc'.$c.'S1L"><img src="'.$p[4].'" width="115px"></div><div class="procSideWS"></div></div></div></td><td valign="top"><div class="showImgBorder" style="height:100px;width:425px;margin-bottom:7px;'.$tTwoShow.'" id="proc'.$c.'T2"><table><tbody><tr><td><div class="showImg" style="width:200px;margin-right:2px;height:82px;" id="proc'.$c.'T2T"><img src="'.$p[6].'" width="200px"></div></td><td><div class="showImg" style="width:200px;margin-left:2px;height:82px;" id="proc'.$c.'T2B"><img src="'.$p[7].'" width="200px"></div></td></tr></tbody></table></div><div class="showImgBorder" style="height:100px;width:425px;margin-bottom:7px;position:relative;'.$tOneShow.'" id="proc'.$c.'T1"><div class="showImg" style="width:410px;margin-left:7px;height:82px;" id="proc'.$c.'T1T"><img src="'.$p[6].'"></div><div class="procTopWS"></div></div></td><td valign="top" align="left" width="210">
<span class="smallProcRadio"><b>Side Images</b><input type="radio" id="proc'.$c.'S" name="proc'.$c.'S" class="imgNumS" value="1"  '.$sOne.'> Single &nbsp;&nbsp;<input type="radio" id="proc'.$c.'S" name="proc'.$c.'S" class="imgNumS" value="2"  '.$sTwo.'> Double</span>
<span class="smallProcRadio"><b><br>Top Images</b><input type="radio" id="proc'.$c.'T" name="proc'.$c.'T" class="imgNumT" value="1" '.$tOne.'> Single &nbsp;&nbsp;<input type="radio" id="proc'.$c.'T" name="proc'.$c.'T" class="imgNumT" value="2"  '.$tTwo.'> Double</span></td></tr><tr><td colspan="3" valign="top"><div class="processText" style="position:relative;top:0px;" id="proc'.$c.'D"><div class="eBtn" style="overflow:hidden;" id="proc'.$c.'DE"></div><span class="processTitle" id="proc'.$c.'DT">'.$p[0].'</span><span class="processDescription" id="proc'.$c.'DD">'.$p[1].'</span></div></td></tr></tbody></table></div><div id="proc'.$c.'DEDiv" class="procDEDiv"></div>
';

$procIMG .='
phArr.push(new pPhoto("proc'.$c.'T2T","'.$p[6].'","346,145","","","proc'.$c.'T2T","-1","'.substr($p[6],-4).'",0));
phArr.push(new pPhoto("proc'.$c.'T2B","'.$p[7].'","346,145","","","proc'.$c.'T2B","-1","'.substr($p[7],-4).'",0));
phArr.push(new pPhoto("proc'.$c.'T1T","'.$p[6].'","697,145","","","proc'.$c.'T1T","-1","'.substr($p[6],-4).'",0));
phArr.push(new pPhoto("proc'.$c.'S2L","'.$p[4].'","226,170","","","proc'.$c.'S2L","-1","'.substr($p[4],-4).'",0));
phArr.push(new pPhoto("proc'.$c.'S2R","'.$p[5].'","226,305","","","proc'.$c.'S2R","-1","'.substr($p[5],-4).'",0));
phArr.push(new pPhoto("proc'.$c.'S1L","'.$p[4].'","226,484","","","proc'.$c.'S1L","-1","'.substr($p[4],-4).'",0));
';

$c=$c+1;
}
?>
<link rel="shortcut icon" href="http://www.oasis-ad.com/graphics/oasisIcon.ico" type="image/x-icon">
<link href="../import/main2.css" rel="stylesheet" type="text/css"/>
<link href="admin.css" rel="stylesheet" type="text/css"/>
<script src="../import/jQuery.js" type="text/javascript"></script> 
<script src="admin.js" type="text/javascript"></script>
<script src="../import/oScript.js" type="text/javascript"></script>
<title>EDIT Process</title>
<style>
.processEdit{width:853px;height:280px;background-color:#f3f3f3;border:1px solid #ccc;}
.smallProcRadio b
{
	font-size:13px;
	letter-spacing:-1px;
	color:#666;
	display:block;
	text-transform:uppercase;
	margin-top:10px;
}
.smallProcRadio{font-size:11px;letter-spacing:1px;font-weight:700;color:#AAA;}
.procSideWS{width:115px;height:6px;border-top:1px solid #ccc;border-bottom:1px solid #ccc;position:absolute;left:5px;top:80px;background-color:#fff;}
.procTopWS{width:5px;height:84px;border-right:1px solid #ccc;border-left:1px solid #ccc;position:absolute;left:200px;top:5px;background-color:#fff;}
#procEdContainer{width:100%;height:100%;position:relative;}
#procEdPU{background-color:#ddd;border-left:1px solid #c9c9c9;border-right:1px solid #c9c9c9;border-top:2px dotted #ccc;border-bottom:2px dotted #ccc;height:185px;width:853px;font-family:"Arial Narrow", Helvetica, sans-serif;color:#fafafa;overflow:hidden;position:absolute;display:none;left:0px;top:0px;}
#procEdPU h6{color:#666;font-size:14px;text-transform:uppercase;line-height:24px;word-spacing:1px;font-weight:bold;text-align:left;}
#procTitleEdit{height:20px;font-size:14px;text-transform:uppercase;font-weight:bolder;width:417px;}
#procTxtEdit{font-size:17px;line-height:22px;font-weight:lighter;word-spacing:1px;width:647px;height:88px;padding:5px;}
.copyMe{font-size:11px;color:#666;background-color:#CCC;font-family:"Courier New", Courier, monospace;letter-spacing:-1px;}
#saveProcBtn{background-color:#fafafa;background-image:none;border: 1px outset #ccc;margin-left:9px;width:111px;position:absolute;}
#saveProcBtn p{font-size:20px;font-weight:bold;	text-transform:uppercase;color:#999;}
.eBtn {
background: url(../graphics/editButtons.png) repeat 0 61px;
width: 28px;
height: 30px;
cursor: pointer;
position:absolute;
top:5px;
right:5px;
}

#showSymbol{display:block;margin-left:50px;margin-top:10px;}
.procDEDiv{width:853px;height:185px;display:none;}
</style>

<script>
processMobile();
var cProc= -1;
var newWH;
$(document).ready(function()
{
var sH = $(window).height()-90;
var sTH = (sH/2)-20;
$('#saveProcBtn').css('height',sH+'px');
$('#saveProcBtn p').css('margin-top',sTH+'px');
$(window).scroll(function(){
	$('#saveProcBtn').css('height',sH+'px');
	});
$(document).scroll(function(e){
	newWH = $(window).scrollTop();
	if(newWH > 72){
		newWH -= 72;
		$('#saveProcBtn').css('top',newWH+'px');}
	else{$('#saveProcBtn').css('top',0+'px');}	
	

	
});
$('#cancelProcEdits').click(function()
{
	$('#'+cProc+'Title').html(oldTitle);
	$('#'+cProc+'Txt').html(oldText);
	$('#cCornerEdit').fadeOut(100);
	
});
$('#procTitleEdit').keyup(function() {
	var wh = $(this).val();
  $('#proc'+cProc+'DT').html(wh);
 	 saveProcsOK(cProc,0,wh);
});
$('#procTxtEdit').keyup(function() {
	var wh = $(this).val();
  $('#proc'+cProc+'DD').html(wh);
 	 saveProcsOK(cProc,1,wh);
});

$('.copyMe').click(function(){ $(this).select();});


$('.imgNumT').change(function(){
	var me = $(this).attr('id');
	var wh = $(this).val();
	 getImgNum(me,wh);
 	saveProcsOK(me.substr(4,1),3,wh);
	});
	
$('.imgNumS').change(function(){
	var me = $(this).attr('id');
	var wh = $(this).val();
	 getImgNum(me,wh);	
	 saveProcsOK(me.substr(4,1),2,wh);	 
	 });

	 
$('.eBtn').click(function(){
	var me = $(this).attr('id');
	$(this).fadeOut('fast');
	var idx = me.substr(4,1);
	if(cProc != idx)
	{	
	$('#proc'+cProc+'DE').fadeIn('fast');
	$('#proc'+cProc+'DEDiv').slideUp('fast');
	$('#procEdPU').slideUp('fast', function() {
	cProc = idx;	
	$('#'+me+'Div').slideDown();
	var newH = $('#'+me+'Div').position().top;	
	$('#procEdPU').slideDown(function(){  $("html, body").animate({ scrollTop: newH-200 }, 300);});
	$('#procTitleEdit').val(procArr[idx][0]);
	$('#procTxtEdit').val(procArr[idx][1]);
	$('#procEdPU').css({'top': newH + 'px'});
	var showS = parseInt(cProc) + 1;
	$('#showSymbol').html(' <div id="procGrid_'+showS+'"></div>');
		 });
	}

	});
$('.dBtn').click(function(){$('#proc'+cProc+'DEDiv').slideUp('fast');$('#procEdPU').slideUp('fast');
$('#proc'+cProc+'DE').fadeIn('fast');
cProc = -1;});

$('#saveProcBtn').click(function(){saveProcs();});
$('.showImg').click(function(){
	editImg($(this).attr('id'),0,0);
	
	});
});

function saveProcsOK(idx,w,n)
{
	procArr[idx][w]= n; 
	procArr[idx][4]=1;
	changeUploadButton('saveProcBtn');	
}

function getImgNum(me,num)
{
	if(num == 1)
	{
		$('#' + me + '2').css({'display':'none'});
		$('#' + me + '1').css({'display':'block'});		
	}
	else
	{
		$('#' + me + '1').css({'display':'none'});
		$('#' + me + '2').css({'display':'block'});
	}
	
}

function saveProcs()
{	
	var chgTXTStr ='';var chgIMGStr = '';
	
	for(i=0;i<procArr.length;i++)
	{
	if(procArr[i][4]==1){
	chgTXTStr += "%!%"+i+'!%!'+encodeQ(procArr[i][0])+'!%!'+encodeQ(procArr[i][1])+'!%!'+procArr[i][2]+'!%!'+procArr[i][3];	}
		
		
	var iStep = i*6;var chgPImgs = '';var hasChgs = false;
	
	//SIDE IMGS 	
	if(procArr[i][2]==2)
	 {
	 if(procArr[i][5]!=phArr[iStep+3].src){chgPImgs+="!%!"+phArr[iStep+3].src;hasChgs=true;ok2Save=true;}
	  else{chgPImgs+="!%!-1";}
	 if(procArr[i][6]!=phArr[iStep+4].src){chgPImgs+="!%!"+phArr[iStep+4].src;hasChgs=true;ok2Save=true;}else{chgPImgs+="!%!-1";}
	 
     }
	else
	 {
	 if(procArr[i][5]!=phArr[iStep+5].src){chgPImgs+="!%!"+phArr[iStep+5].src+"!%!-1";hasChgs=true;ok2Save=true;}
	 else{chgPImgs+="!%!-1!%!-1";}		 	 	
	 }
	 if(procArr[i][3]==2)
	 {
	 if(procArr[i][7]!=phArr[iStep].src){chgPImgs+="!%!"+phArr[iStep].src;hasChgs=true;ok2Save=true;
	  }else{chgPImgs+="!%!-1";}
	 if(procArr[i][8]!=phArr[iStep+1].src){chgPImgs+="!%!"+phArr[iStep+1].src;hasChgs=true;ok2Save=true;
	  }else{chgPImgs+="!%!-1";}
	  }
	 else
	 {
	  if(procArr[i][7]!=phArr[iStep+2].src){chgPImgs+="!%!"+phArr[iStep+2].src+"!%!-1";hasChgs=true;ok2Save=true;}
	  else{chgPImgs+="!%!-1!%!-1";}
	 }

	if(hasChgs){chgIMGStr += "%!%"+i+'!%!'+chgPImgs.substr(3);}
	}
	
	if(!ok2Save){return;};
	$('#allTXTChanges').attr('value',chgTXTStr.substr(3));
	$('#allIMGChanges').attr('value',chgIMGStr.substr(3));
	document.forms['saveProcChanges'].submit();	
	
}

var procArr = new Array();
<?php echo $procArrJS.$procIMG;?>
</script>

</head>
<body>
<table id="mainContainerTable"><tbody><tr><td><!-- headerStart -->
<div id="mainMenu"> 
<div id="logo"><div id="goHome" onclick="(window.location = &#39;http://oasis-ad.com/admin&#39;)"></div></div>
<div id="mainNav">
<table id="topButtonsSpaced"><tbody><tr>
<td><div class="unselectedButtons" id="topButtons" style="width:129px;"><a href="http://oasis-ad.com/admin/index.php"><h1>Home Page</h1></a></div></td>
<td><div class="unselectedButtons" id="topButtons" style="width:129px;"><a href="http://oasis-ad.com/admin/portfolioAdmin.php"><h1>Portfolio</h1></a></div></td><td><div class="selectedButtons" id="topButtons"><a href="./EDIT Process_files/EDIT Process.htm"><h1>Process</h1></a></div></td>
<td><div class="unselectedButtons" id="topButtons"><a href="http://oasis-ad.com/admin/teamAdmin.php"><h1>Team</h1></a></div></td>
<td><div class="unselectedButtons" id="topButtons"><a href="http://oasis-ad.com/admin/contactAdmin.php"><h1>Contact</h1></a></div></td>
<td><div class="unselectedButtons" id="topButtons"><a href="http://oasis-ad.com/admin/mediaAdmin.php"><h1>Media</h1></a></div></td>
<td><div class="unselectedButtons" id="topButtons"><a href="http://oasis-ad.com/fullSite.php"><h1>full site</h1></a></div></td>
</tr></tbody></table>
</div>
</div>
</td></tr>
<tr><td>
<table><tr><td width="68px"></td><td valign="top">
<!-- Main Contents -->
<div id="procEdContainer">
<div id="procEdPU"><table><tbody><tr><td valign="top" rowspan="2" width="190px"><div style="margin-left:10px;">
<table cellspacing="2px" bgcolor="#d9d9d9"><tbody><tr><td colspan="2"><h6 style="display:block;margin-bottom:2px;">HTML CODE:</h6></td></tr><tr><td><span class="preview"><h4>Line Break</h4></span></td><td><input size="12" value="&lt;br&gt;" readonly="readonly" class="copyMe"></td></tr><tr><td><span class="preview"><h4>Paragraph</h4></span></td><td><input size="12" value="&lt;p&gt;" readonly="readonly" class="copyMe"></td></tr><tr><td><span class="preview"><h1>Text</h1></span></td><td><input size="12" value="&lt;h1&gt;Text&lt;/h1&gt;" readonly="readonly" class="copyMe"></td></tr><tr><td><span class="preview"><b>Text</b></span></td><td><input size="12" value="&lt;b&gt;Text&lt;/b&gt;" readonly="readonly" class="copyMe"></td></tr><tr><td><span class="preview"><u>Text</u></span></td><td><input size="12" value="&lt;u&gt;Text&lt;/u&gt;" readonly="readonly" class="copyMe"></td></tr><tr><td><span class="preview"><i>Text</i></span></td><td><input size="12" value="&lt;i&gt;Text&lt;/i&gt;" readonly="readonly" class="copyMe"></td></tr></tbody></table></div></td><td valign="top" width="420px"><h6>Process Title:</h6><input size="80" id="procTitleEdit" class="procEditInputs" name="name" style="margin-left:8px;"></td><td align="center" valign="bottom"><div id="showSymbol"></div></td><td width="250px" align="right" valign="top"><div style="position:relative;"><div class="dBtn" style="overflow:hidden;"></div></div></td></tr><tr><td colspan="3"><h6>Process Description:</h6>
<textarea id="procTxtEdit" class="procEditInputs" rows="5" cols="90"></textarea></td></tr></tbody></table><br></div>
<?php echo $procHTML;?>
</div>


<form id="saveProcChanges" method="post">
<input type = "hidden" name="allTXTChanges"  id="allTXTChanges"/>
<input type = "hidden" name="allIMGChanges"  id="allIMGChanges"/>
</form>
<!-- Main Contents -->
</td><td width="122px" valign="top">
<div class="absC">
<div class="bigSaveButtons" id="saveProcBtn"><p>SAVE</p></div>
</div>
</td></tr></table>
</td></tr></tbody></table>

</body></html>