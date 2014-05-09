<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<META NAME="ROBOTS" CONTENT="NOINDEX, FOLLOW">
<head>
<link rel="shortcut icon" href="http://www.oasis-ad.com/graphics/oasisIcon.ico" type="image/x-icon">
<link href="../import/main2.css" rel="stylesheet" type="text/css"/>
<script src="../import/jQuery.js" type="text/javascript"></script> 
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

 
phCArr.push(new Array("80","Ramona d'Viola","Ilumus Photography","6194056708","http://www.ilumus.com","","27,26,35,47",0));phCArr.push(new Array("79","OWEN MCGOLDRICK","Owen McGoldrick Photography","6199776194","http://www.omphoto.com","","43,21,27,22,40,39,37,41",0));newOrderStr = ",80,79";prjArr.push(new Array("14","BAE ","",0));prjArr.push(new Array("43","Baylight","",0));prjArr.push(new Array("15","Bernardo Tech ","",0));prjArr.push(new Array("28","birds eye","",0));prjArr.push(new Array("21","bonsai","",0));prjArr.push(new Array("27","BRIDGE VIEW","",0));prjArr.push(new Array("44","Bungalow Court","",0));prjArr.push(new Array("45","Cabana","",0));prjArr.push(new Array("29","CALAVO","",0));prjArr.push(new Array("22","Candlelight","",0));prjArr.push(new Array("40","Capri","",0));prjArr.push(new Array("31","Cedar Woods","",0));prjArr.push(new Array("18","Centennial","",0));prjArr.push(new Array("30","De Cascadas","",0));prjArr.push(new Array("17","Entrada","",0));prjArr.push(new Array("23","Eternity","",0));prjArr.push(new Array("32","Green Lake","",0));prjArr.push(new Array("26","HEAVENLY point","",0));prjArr.push(new Array("33","Hillside","",0));prjArr.push(new Array("34","Island Tropic","",0));prjArr.push(new Array("39","Koa Sun","",0));prjArr.push(new Array("35","Lotus Perch","",0));prjArr.push(new Array("46","Moonlight","",0));prjArr.push(new Array("47","Nautica","",0));prjArr.push(new Array("36","North Park","",0));prjArr.push(new Array("48","Ocaso","",0));prjArr.push(new Array("37","Ocean Ridge","",0));prjArr.push(new Array("38","Riviera","",0));prjArr.push(new Array("16","San Diego Ave","",0));prjArr.push(new Array("42","Scarlet Sky","",0));prjArr.push(new Array("19","SD Water Auth","",0));prjArr.push(new Array("41","Sinalda","",0));prjArr.push(new Array("49","Southern Light","",0));prjArr.push(new Array("50","West Wing","",0));
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
			chgProj += '%%'+ prjArr[i][0] +'!!'+prjArr[i][2];
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
			add += '%%'+ phCArr[i][0]+'!!'+ phCArr[i][1]+'!!'+phCArr[i][2]+'!!'+phCArr[i][3]+'!!'+phCArr[i][4]+'!!'+phCArr[i][5]+'!!'+phCArr[i][6];
		  }
		  else
		  {
chg += '%%'+ phCArr[i][0]+'!!'+phCArr[i][1]+'!!'+phCArr[i][2]+'!!'+phCArr[i][3]+'!!'+phCArr[i][4]+'!!'+phCArr[i][5]+'!!'+phCArr[i][6]; 
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
</td><td><div class="unselectedButtons" id="topButtons"><a href="mediaAdmin.php"><h1>Media</h1></a></div></td><td><div class="unselectedButtons" id="topButtons"><a href="../fullSite.php"><h1>full site</h1></a></div></td></tr></table></div></td></tr><!-- headerEnd -->
<tr><td valign="top"><table><tr><td width="206px" valign="top">
<div id="subMenu">
<table style="margin-left:70px;margin-right:5px;margin-top:2px;" cellspacing="0px">
<tr><td class="subMenuTD"><div class="subMenu" id="subMenu_0"><a href="teamPhoto.php">
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



<!-- Main Content -->
</td>
</tr>
</table>
</div>

</body>

</html>