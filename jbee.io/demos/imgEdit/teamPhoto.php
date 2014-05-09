<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<META NAME="ROBOTS" CONTENT="NOINDEX, FOLLOW">
<?php

function alert($show){echo '<script>alert("'.$show.'");</script>';}
$hn="localhost";
$un="markmorr_SQL1";
$pd="OASIS-ad0920";
$db="markmorr_SQL";
$con = mysql_connect($hn,$un, $pd); 
if(!$con){ die('Could not connect: ' . mysql_error());}
else{mysql_select_db($db, $con);}


if($_POST["addNewPh"])
{
 $pNew=array();
	$allNew =  explode("%%",$_POST["addNewPh"]);
	foreach ($allNew as $npHA)
	{
		$np =  explode("!%!",$npHA);
		$addP = "INSERT INTO teamEXT (name,ttype,number,website,projects,txt,person)";
		$addP .= "VALUES ('".$np[2]."','photographer','".$np[3]."','".$np[4]."','".$np[6]."','".$np[5]."','".$np[1]."');";
		mysql_query($addP);
		
		$getNewPID = "SELECT id FROM teamEXT WHERE name = '".$np[2]."' AND person = '".$np[1]."' AND projects = '".$np[6]."'";
		
		$result = mysql_query($getNewPID);
		$row = mysql_fetch_array($result, MYSQL_BOTH);
		$add2Prj =  explode(",",$np[6]);
		array_push($pNew, array($np[0], $row[id]));
		foreach ($add2Prj as $a)
		{
			$chgMe = "UPDATE portfolio SET photographer = IFNULL(CONCAT(photographer, ',". $row[id]."'),'".$row[id]."')
 WHERE pId = ".$a.";";
			mysql_query($chgMe);
		}	
		
	}
	
	
}

if($_POST["deletePh"])
{
	$allDMe =  explode("%%",$_POST["deletePh"]);
	foreach ($allDMe as $dMe)
	{
		mysql_query('DELETE FROM teamEXT WHERE id='.$dMe);
	}
}

if($_POST["newPOrder"])
{	
	$newTOrder =  explode(",",$_POST["newPOrder"]);
	$myOrder = 1;
	foreach ($newTOrder as $oMe)
	{
		if(strpos($oMe, 'new') !== FALSE)
		{
			$oMe = $pNew[$oMe];
		}
		mysql_query('UPDATE teamEXT SET tOrder = "'.$myOrder.'" WHERE id='.$oMe);
		$myOrder=$myOrder+1;
	}
}
if($_POST["chgPh"])
{
	$toChg =  explode("%%",$_POST["chgPh"]);
	foreach ($toChg as $chgMe)
	{
		$np =  explode("!%!",$chgMe);
		$chgMe = "UPDATE teamEXT SET name = '".$np[2]."',number = '".$np[3]."',website = '".$np[4]."',projects = '".$np[6]."',txt = '".$np[5]."',person = '".$np[1]."' WHERE id =".$np[0].";";
		mysql_query($chgMe);
	}
}
if($_POST["chgPhProj"])
{
	$toChg =  explode("%%",$_POST["chgPhProj"]);
	foreach ($toChg as $chgMe)
	{
		$np =  explode("!%!",$chgMe);
		$chgMe = "UPDATE portfolio SET photographer = '". trim($np[1],',')."' WHERE pId =".$np[0].";";
		mysql_query($chgMe);
	}
}



  $pArr=array();
  $Qstring = "SELECT * FROM teamEXT where ttype = 'photographer' ORDER BY tOrder";
   $result = mysql_query($Qstring);
	 while($cat=mysql_fetch_array($result)){
array_push($pArr, array($cat[website],$cat[name],$cat[person],$cat[projects],$cat[txt],str_replace('.','',$cat[number]),$cat[id]));			 		
			 }	


$Qstring = 'SELECT name,pId,category FROM portfolio ORDER BY name';
 $allProj=array();
 $projChk ="";
 $projArrStr = "";
 $ct = 0;
 $c2 = 0;
 	 			 $result = mysql_query($Qstring);
			 while($cat=mysql_fetch_array($result)){
				$allProj[$cat[pId]]= array(strtolower($cat[name]),$cat[category]);
				if($cat[category] != '5')
				{
			$projChk .= '<td><input class="projChks" id="pgCPRoj'.$cat[pId].'" type="checkbox" name="allChkProj" value="'.$c2.'"></td><td>'.$cat[name].'</td>';
			$c2 = $c2+1;
			if($ct == 2){$projChk .= '</tr><tr>'; $ct = 0;}else{$ct=$ct + 1;}	 
			$projArrStr .= 'prjArr.push(new Array("'.$cat[pId].'","'.$cat[name].'","'.$cat[photographer].'",0));';
				}
			 }	

foreach($pArr as $i)
{
	///// id,person,company,phone,website,text,projects ,changed
	$phArrJS.= 'phCArr.push(new Array("'.$i[6].'","'.$i[2].'","'.$i[1].'","'.$i[5].'","'.$i[0].'","'.$i[4].'","'.$i[3].'",0));';	
	$orderStr .= ','.$i[6];
}
			 ?>
<head>
<link rel="shortcut icon" href="http://www.oasis-ad.com/graphics/oasisIcon.ico" type="image/x-icon">
<link href="../import/main2.css" rel="stylesheet" type="text/css"/>
<script src="../import/jQuery.js" type="text/javascript"></script> 
<script src="../import/oScript.js" type="text/javascript"></script>
<script src="admin.js" type="text/javascript"></script><link href="admin.css" rel="stylesheet" type="text/css"/> 
<title>EDIT Photographers</title> 
<style>
h3{color:#9f9f9f;font-weight:400;font-size:20px}
#pgDemoCont{width:452px;background-color:#c5c7c8;text-align:left;overflow:hidden}
#pgCContainer{width:452px;position:relative;margin-top:-10px;overflow:hidden}
.blockTitle{display:block;margin-top:10px;margin-left:10px}
.creditsTable{color:#fff;margin-left:10px;font-size:16px;}
.creditsTable .lilGrayTXT a:hover{color:#b1b1b1}
.creditsTable h1{display:inline}
.creditsTable h3{display:inline;line-height:20px;font-size:16px;text-transform:lowercase}
.creditsTable a{text-decoration:none;font-size:16px;color:#fdfdfd;line-height:18px;font-weight:lighter}
.lilGrayTXT,.creditsTable .lilGrayTXT a{font-size:13px;font-family:"Arial Narrow", Helvetica, sans-serif;color:#9f9f9f;font-weight:bolder;word-spacing:1px}
.creditsTable .lilGrayTXT{text-transform:lowercase}
.pgC{border-top:1px dotted #bbb;border-bottom:1px dotted #bbb;background-color:#c5c7c8;cursor:move;height:95px;width:449px}
#editPgCCont{margin-left:8px}
#editPgC{width:375px;position:relative;text-align:left;}
#showPgEditsCont{position:relative;height:650px;width:100%;}
#showPgCEdits{background-color:#e7e7e7;position:absolute;top:0px;left:0px;}
#showPgCEdits table{font-family:"Arial Narrow", Helvetica, sans-serif;color:#888;font-size:12px;text-transform:uppercase}
#editPgC table{margin-left:10px;font-weight:700;font-size:11px}
#editPgC input{font-size:15px;color:#888;margin-bottom:10px;margin-top:10px}
#editPgC textarea{margin-bottom:10px;margin-top:12px;font-size:15px;color:#888}
#savePgCButton{height:30px;width:320px;text-align:center;padding-top:5px;margin-bottom:9px}
#savePgEdits{height:20px;width:320px;text-align:center;font-size:16px}
#addPgCProj{margin-left:10px;position:relative; text-align:left;}
#phCError{padding-left:10px;padding-top:10px}
.addPgCBtn{margin-left:10px;margin-top:5px;}
</style>
<script>
newOrderStr = ",35,37,38,39,41,63,45,46,47,64,61,56,57,58,59,60,65,36";
var currentProj = true;
var nB = true;
var prjArr = new Array();
var phCArr = new Array();
var cPhC = -1;
var chE = false;
var errmsg = '';
var tmpProjs = new Array();
var newPID = -1;

 
<?php 
echo $phArrJS;

echo 'newOrderStr = "'.$orderStr.'";';

echo $projArrStr;
?>

for(i=0;i<prjArr.length;i++){tmpProjs.push(new Array(prjArr[i][0],prjArr[i][1],prjArr[i][2],prjArr[i][3]));}

$(document).ready(function()
{	
	$('#subMenu').selectMENU({'shD':false,'sD':'#A1A3A5','cD':'subMenu_1'});
	$('.ePgCBtn').click(function(){
					editPgCFxn($(this).attr('id').substring(4));})
				    .mouseenter(function() {$(this).css('backgroundPosition', '0px 30px');})
   			 		.mouseleave(function(){$(this).css('backgroundPosition', '0px 61px');});
	$('.addPgCBtn').click(function(){
		nudgeEditsTable(0);
		$('#savePgEdits').html('ADD PHOTOGRAPHER');
		;})
					.mouseenter(function() {$(this).css('backgroundPosition', '0px 152px');})
   			  		.mouseleave(function(){$(this).css('backgroundPosition', '0px 0px');});
	$('.dBtn').click(function(){delBtnFxns($(this).attr('id').substring(3));})
			  .mouseenter(function() {$(this).css('backgroundPosition', '0px 92px');})
   			  .mouseleave(function(){$(this).css('backgroundPosition', '0px 122px');}			  
			  );	
			  $('.projChks').change(function(){
				 changeUploadButton('savePgEdits');
				  var tp = $(this).val();
				 	if($(this).is(':checked'))
					{
						if(cPhC != -1)
						{						
						if(tmpProjs[tp][2].indexOf(','+phCArr[cPhC][0]+',') == -1)
						{
						tmpProjs[tp][2] +=phCArr[cPhC][0]+',';
						tmpProjs[tp][3] = 1;
						}
						}
					}
					else
					{
						if(tmpProjs[tp][2].indexOf(','+phCArr[cPhC][0]+',') != -1)
						{
						tmpProjs[tp][2] = tmpProjs[$(this).val()][2].replace(','+phCArr[cPhC][0]+',',',');
						tmpProjs[tp][3] = 1; 
						}
					}
				  });
			  $('.pgEInpt').keyup(function(){changeUploadButton('savePgEdits');});
			
				   
	$('#pgCContainer').dragSort({'name':'pgC','margin':5,'iClass':'pgC','dH':95,'dW':449});
	$('#savePgEdits').click(function(){
				var pDigits = (($('#editpgNum').val()).replace(/\D/g,'')).length;		

		if(($('#editpgName').val()=='')&&($('#editpgComp').val()==''))
		{
		$('#phCError').html('Either Photographers Name or Company must be provided.<br> Otherwise the list will look odd');
		}
		else if( (pDigits < 10) && (pDigits != 0 ))
		{
		pDigits = 10 - pDigits;			
		$('#phCError').html('Phone Number is missing ' + pDigits + ' digits');		
		}
		else if( pDigits > 10)
		{
		pDigits = pDigits - 10;			
		$('#phCError').html('Phone Number has ' + pDigits + ' extra digits');
		}
		else
		{
			$('#phCError').html('');
			$('#savePgCButton').css({'background-color':'#88c6aa','border':'1px solid #666','color':'#444','cursor':'pointer'});			
			for(i=0;i<tmpProjs.length;i++){prjArr[i][2] = tmpProjs[i][2];prjArr[i][3] = tmpProjs[i][3];}
			pgCSaveChngs();
			return;
		}
		$('#savePgEdits').css({'background-color':'#fafafa','border':'1px solid #ccc','color':'#999','cursor':'default'});
		});
	$('#savePgCButton').click(function(){saveAllPhotographers()});
	
	
	
});

function editPgCFxn(thsD)
{
	if(!nB){return;}
			nudgeEditsTable($(window).scrollTop());
		$('#savePgEdits').html('SAVE PHOTOGRAPHER');		
		$('#dpgC'+thsD +' table').css('background-color','#BCD4E6');
		$('#dpgC'+cPhC + ' table').css('background-color','#c5c7c8');
		clearPHInputs();
		cPhC=thsD;
		$('#editpgName').val(phCArr[cPhC][1]);
		$('#editpgComp').val(phCArr[cPhC][2]);
		$('#editpgWeb').val(phCArr[cPhC][4]);
		$('#editpgNum').val(phCArr[cPhC][3]);
		$('#editpgTxt').val(phCArr[cPhC][5]);
		pgChkFxn(phCArr[cPhC][6]);
	
}

function delBtnFxns(dME)
{
		phCArr[dME][7] = -1;
		var alldMEProj=phCArr[dME][6].split(",")
		for(i=0;i<alldMEProj.length;i++)
		{
			if(alldMEProj[i] != '')
			{
				for(j=0; j<prjArr.length; j++)
				{
					if(prjArr[j][0] == alldMEProj[i])
					{
						if(prjArr[j][2].indexOf(','+phCArr[dME][0]+',') != -1)
						{prjArr[j][2] = prjArr[j][2].replace(','+phCArr[dME][0]+',',',');}
						prjArr[j][3] = 1;						
					}
				}
					
			}
		}
		if(dME == cPhC)
		{
			cPhC = -1;
			clearPHInputs();
			$('#savePgEdits').html('ADD PHOTOGRAPHER');
		}
}
function pgCSaveChngs()
{
		for(i=0;i<phCArr.length;i++)
	{
		if(($('#editpgName').val() == phCArr[i][1])&&(i != cPhC))
		{			
			if($('#editpgComp').val() == phCArr[i][2])
			{
			$('#phCError').html('A photographer by the name: '+phCArr[i][1]+' working for '+phCArr[i][2]+' already exists.');
			$('#savePgEdits').css({'background-color':'#fafafa','border':'1px solid #ccc','color':'#999','cursor':'default'});
			return;
			}
		}
		
	}
	nB = false;
	var myPrjs = getNewPChks().split('>:D');
	var web = $('#editpgWeb').val();
		if((web.indexOf("http://") ==-1)&&(web != ''))
		{
			web  = 'http://'+web;
		}
	var num = $('#editpgNum').val().replace(/\D/g,'');
	if(cPhC == -1)
	{ 
newPID--;
cPhC = phCArr.length;
phCArr.push(new Array(newPID,$('#editpgName').val(),$('#editpgComp').val(),num,web,$('#editpgTxt').val(),myPrjs[0],1));
var newDivHtml = '<table class="creditsTable"><tr><td width="405px"><h3 id="dpg'+newPID+'N">'+$('#editpgName').val()+'</h3><span id="dpg'+newPID+'O"> of </span><h1 id="dpg'+newPID+'C">'+$('#editpgComp').val()+'</h1><span id="dpg'+newPID+'W">'+web+'</span></td><td rowspan="2"><div class="ePgCBtn" onclick="editPgCFxn('+cPhC+')"></div><br><div class="dBtn" onclick="delBtnFxns('+cPhC+')"></div></td></tr><tr><td class="lilGrayTXT" valign="top" id="dpg'+newPID+'PRS">'+myPrjs[1]+'</td></tr></table>';
$.fn.dragSort.extAdd(newDivHtml);
$('#dpgC'+(cPhC)+ ' table').css('background-color','#BCD4E6');		
	}
	else
	{
	
		phCArr[cPhC][1] = $('#editpgName').val();
	  	phCArr[cPhC][2] = $('#editpgComp').val();		
		phCArr[cPhC][4] = web;
		phCArr[cPhC][3] = num;
		phCArr[cPhC][5] = $('#editpgTxt').val();		
		phCArr[cPhC][6] = myPrjs[0];
		phCArr[cPhC][7] = 1;

	}
	nps = myPrjs[1];
	$('#dpg'+phCArr[cPhC][0]+'PRS').html(nps);		
	$('#dpg'+phCArr[cPhC][0]+'N').html(phCArr[cPhC][1]);
	$('#dpg'+phCArr[cPhC][0]+'C').html(phCArr[cPhC][2]);
	$('#dpg'+phCArr[cPhC][0]+'W').html('<br><a href="'+phCArr[cPhC][4]+'">'+ phCArr[cPhC][4].replace('http://','')+'</a>');	
	$('#savePgEdits').css({'background-color':'#fafafa','border':'1px solid #ccc','color':'#999','cursor':'default'});
	if((phCArr[cPhC][1]=='')||(phCArr[cPhC][2]==''))
	{
		$('#dpg'+phCArr[cPhC][0]+'O').html('');
	}
	else
	{
		$('#dpg'+phCArr[cPhC][0]+'O').html(' of ');
	}
	nB = true;
	}

function saveAllPhotographers()
{
	var chgProj = '';
	var add = '';
	var del = '';
	var chg = '';
	for(i=0;i<prjArr.length;i++)
	{
		if(prjArr[i][3]==1)
		{
			chgProj += '%%'+ prjArr[i][0] +'!%!'+prjArr[i][2];
		}
	}
	for(i=0;i<phCArr.length;i++)
	{
		if((phCArr[i][7]== -1)&&(phCArr[i][0].indexOf('new') ==-1))
		{
			
			del += '%%'+ phCArr[i][0];
		}
		else if(phCArr[i][7] == 1)
		{
		  if(phCArr[i][0]<0)
		  {
			add += '%%'+ phCArr[i][0]+'!%!'+ phCArr[i][1]+'!%!'+phCArr[i][2]+'!%!'+phCArr[i][3]+'!%!'+phCArr[i][4]+'!%!'+phCArr[i][5]+'!%!'+phCArr[i][6];
		  }
		  else
		  {
chg += '%%'+ phCArr[i][0]+'!%!'+phCArr[i][1]+'!%!'+phCArr[i][2]+'!%!'+phCArr[i][3]+'!%!'+phCArr[i][4]+'!%!'+phCArr[i][5]+'!%!'+phCArr[i][6]; 
		  }
		}
	}
	$('#chgPhProj').attr('value',chgProj.substr(2));
	$('#newPOrder').attr('value',newOrderStr);
	$('#addNewPh').attr('value',add.substr(2));
	$('#deletePh').attr('value',del.substr(2));
	$('#chgPh').attr('value',chg.substr(2));
	document.forms['editTeamPhotographers'].submit();	
}
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
<table><tbody><tr>
<td valign="top">
<div id="pgDemoCont">
<span class="blockTitle" style="margin-bottom:10px;"><h1>PROJECT PHOTOGRAPHERS</h1></span>
<div id="pgCContainer" style="height: 225px; width: 449px;">

<?php
$count = 0;	
foreach($pArr as $i)
{
	
	$website = "";

	if($i[0] != '')
	{
		$i[0] = str_replace("http://", "", $i[0]);
		$website = '<br><a href="http://'.$i[0].'">'.$i[0].'</a>';
	}
	 $of = ' of ';
	 if(($i[1]=="")||($i[2]==""))
	 {
		 $of = '';
	 }
	 
	echo '<div class="pgC" title="'.$i[6].'"><table class="creditsTable"><tr><td width="405px"><h3 id="dpg'.$i[6].'N">'.$i[2].'</h3><span id="dpg'.$i[6].'O">'.$of.'</span><h1 id="dpg'.$i[6].'C">'.$i[1].'</h1><span id="dpg'.$i[6].'W">'.$website.'</span></td><td rowspan="2"><div class="ePgCBtn" id="epgC'.$count.'"></div><br><div class="dBtn"></div></td></tr><tr><td class="lilGrayTXT" valign="top" id="dpg'.$i[6].'PRS">';	
	$allPArr = explode(",", $i["3"]);
	$allPString = "";
	foreach($allPArr as $j)
	{
		if($j != '')
		{
		//$allPString .= ', <a href="http://www.oasis-ad.com/portfolio/'.$allCat[$allProj[$j][1]].'?project='.$j.'">'.$allProj[$j][0].'</a>';
		$allPString .= ', '.$allProj[$j][0];
		}
	}			 
	echo  substr($allPString,1).'</td></tr></table></div>';
	$count = $count+1;
}

?>

</div>
</div>
</td>
<td valign="top">
<div id="editPgCCont">
<table><tbody><tr>
<td><div id="savePgCButton" class="bigSaveButtons">Save All Changes</div></td><td valign="top" width="40px"><div class="addPgCBtn" onclick="editPgCFxn(-1)"></div></td></tr><tr>
<td colspan="2">
<form id="editTeamPhotographers" method="post">
<input type = "hidden" name = "newPOrder"  id="newPOrder"/>
<input type = "hidden" name = "chgPh"  id="chgPh"/>
<input type = "hidden" name = "addNewPh"  id="addNewPh"/>
<input type = "hidden" name = "deletePh"  id="deletePh"/>
<input type = "hidden" name = "chgPhProj"  id="chgPhProj"/>
 <div id="showPgEditsCont">
<div id="showPgCEdits">
<div id="editPgC"><!---edits table--->
<span class="errorMsg" id="phCError"></span>
<table>
<tr><td>Photographer:</td><td><input id="editpgName" size="49" class="pgEInpt"></td></tr>
<tr><td>Company:</td><td><input id="editpgComp" size="49" class="pgEInpt"></td></tr>
<tr><td>Website:</td><td><input id="editpgWeb" size="49" class="pgEInpt"></td></tr>
<tr><td>Phone Number:</td><td><input id="editpgNum" size="49" class="pgEInpt"></td></tr>
<tr><td valign="top"><br>Additional Text:</td><td><textarea id="editpgTxt" cols="48" rows=3 class="pgEInpt"></textarea></td></tr>
<tr><td>Projects:</td></tr>
</table>
</div><!---end edits table--->
<!--- proj table--->
<div id="addPgCProj">
<table><tr><td width="15px"></td><td width="102px"></td><td width="15px"></td><td width="102px"></td></tr><tr>
<?php echo $projChk; ?>
</tr></table></div>
<!---end proj table--->
<br><center>
<div id="savePgEdits" class="bigSaveButtons">Add Photographer</div>
</center><br>
</div>
</div>
</td>
</tr></tbody></table>
</div>
</td>
</tr></tbody></table>


<!-- Main Content -->
</td>
</tr>
</table>
</div>

</body>

</html>