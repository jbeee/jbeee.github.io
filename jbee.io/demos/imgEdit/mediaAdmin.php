<html>
<head>

<META NAME="ROBOTS" CONTENT="NOINDEX, FOLLOW">
			<script src="../import/jQuery.js" type="text/javascript"></script> 
            <script src="admin.js" type="text/javascript"></script><link href="admin.css" rel="stylesheet" type="text/css"/> 
            <script src="../import/oScript.js" type="text/javascript"></script>
            <link rel="shortcut icon" href="http://www.oasis-ad.com/graphics/oasisIcon.ico" type="image/x-icon">
            <title>EDIT MEDIA</title>
<?php
include 'admin.php';cSQL('COPY');
$t='../process/';
$mID=44;
$mAOrder = "";
if($_POST["newMOrder"])
{
	$mAOrder = $_POST["newMOrder"];
}
else
{
	  $Qstring = 'SELECT pOrder FROM portfolioCat where cID = 5';
			 $result = mysql_query($Qstring);
			 while($cat=mysql_fetch_array($result)){
			 	$mAOrder = $cat[pOrder];				 
			 }	
}

$allMedia=array();
$mediaStrJS = "";
 //mArt(id , src,     title,date,  author,  photographer,type, kws,     txt,   thmb,pOrder,tImg,bImg,srcWeb, aURL,    nn, changed)
 //     pId, location,name, size,consultant,photographer,shPpl,kws,description,thmb,pOrder,tImg,bImg,product,trades, realtor,0) 

  
		
$Qstring = 'SELECT * FROM portfolio WHERE category= 5';
  			$result = mysql_query($Qstring);
			 while($cat=mysql_fetch_array($result)){
if($mID == $cat[pId])
{
$src = $cat[location];$title = $cat[name];$date =  $cat[size]; $author =  $cat[consultant];
$type =  $cat[photographer];$kews = $cat[shPpl];$txt = $cat[description];$thmb =  $cat[thmb];$pos = explode(',', $cat[pOrder]);
$tImg =  $cat[tImg];$bImg =  $cat[bImg];$srcWeb =  $cat[product];$aUrl =  $cat[trades];$nn =  $cat[realtor];
$dName = str_replace(' ', '',strtolower($cat[name]));
}

$mediaStrJS .= 'mAArr.push(new mArt("'.$cat[pId].'","'.$cat[location].'","'.$cat[name].'","'.$cat[size].'","'.$cat[consultant].'","'.$cat[photographer].'","'.$cat[kws].'","'.$cat[description].'","'.$cat[thmb].'","'.$cat[pOrder].'","'.$cat[tImg].'","'.$cat[bImg].'","'.$cat[product].'","'.$cat[trades].'","'.$cat[realtor].'",0));';				 
			 }	
			 
$allPhgs=array();	 
	 $r = 0;
	 $Qstring = 'SELECT projects,ttype,id,name FROM teamEXT ORDER BY name';
	 $result = mysql_query($Qstring);
	 while($ppl=mysql_fetch_array($result)){ $checked="";
	$ports = explode(',',$ppl[projects]);
	if(in_array($mID,$ports)){$checked='checked';}
	array_push($allPhgs, array($ppl[ttype],$ppl[id],$ppl[name],$checked));}	
	

$allImgs=array();	
if($mID != -1)
{
			 $Qstring = 'SELECT * FROM portImg WHERE pID='.$mID;
			 $result = mysql_query($Qstring);			
			 while($img=mysql_fetch_array($result))				
					{
						
					if(in_array($img[id],$pos))
						{				   
				$idx = array_search($img[id], $pos);
					$allImgs[$idx] = $img;
													
						}
				}
}

?>
<style>

#showAllMA{border:1px solid #bbb;height:0px;width:267px;background-color:#e7e7e7;}
#saveMediaBtn{margin-left:9px; width:271px;height:100px;}
#saveMediaBtn p{text-align:center;display:block;margin-top:35px;}
#mAInfoCont{margin-left:5px;width:415px;height:500px;text-align:center;background-color:#C5C7C8;}
.adminBody{	font-size:23px;color:#A7A7A7;text-transform:uppercase;
	font-family:Arial Narrow,Arial, Helvetica, sans-serif;font-weight:bold;letter-spacing:-1px;}
#mAContents{position:relative;margin-left:7px;width:272px;overflow:hidden;}
.mTxtH{color:#BCBCBC;font-size:40px;line-height:40px;letter-spacing:2px;font-weight:bold;}
.mImg{border:1px solid #666;height:80px;margin-top:2px;}
.mArtInner{width:120px;height:82px;font-size:9px;color:#666;}
.mArtDiv{background-color:#e7e7e7;border-bottom:1px dotted #bbb;border-top:1px dotted #bbb;cursor:move;overflow:hidden;
height:92px;width:270px;}
#mArtFrmt{background:url(../graphics/stripedBG.png);border:1px solid #e0e0e0;width:270px;overflow:hidden;position:relative;}
</style>
<script>
var mAArr = new Array();
var mAOrder="<?php echo $mAOrder;?>";
<?php echo $mediaStrJS; ?>

$(document).ready(function()
{
$('#mArtCont').dragSort({'name':'mArtDiv','margin':15,'iClass':'mArtDiv','dH':92,'dW':270});
});

function addFromFrame(str,name)
{	
}


</script>


</head><table id="mainContainerTable"><tr><td colspan="4">
<!-- headerStart --><div id="mainMenu" style="margin-bottom:5px;"> <div id="logo"><div id="goHome" onClick="(window.location = 'http://oasis-ad.com/admin')"></div></div><div id="mainNav"><table id="topButtonsSpaced"><tr><td><div class="unselectedButtons" id="topButtons" style="width:129px;"><a href="index.php"><h1>Home Page</h1></a></div></td><td><div class="unselectedButtons" id="topButtons" style="width:129px;"><a href="portfolioAdmin.php"><h1>Portfolio</h1></a></div></td><td><div class="unselectedButtons" id="topButtons"><a href="processAdmin.php"><h1>Process</h1></a></div></td><td><div class="unselectedButtons" id="topButtons"><a href="teamAdmin.php"><h1>Team</h1></a></div></td><td><div class="unselectedButtons" id="topButtons"><a href="contactAdmin.php"><h1>Contact</h1></a></div>
</td><td><div class="selectedButtons" id="topButtons"><a href="mediaAdmin.php"><h1>Media</h1></a></div></td><td><div class="unselectedButtons" id="topButtons"><a href="../fullSite.php"><h1>full site</h1></a></div></td></tr></table></div>
<!-- headerEnd --></td></tr>
<tr><td width="70px"></td><td valign="top">

 <table class="adminBody"><tr><td width="215px">ALL MEDIA ARTICLES</td>
<td><div class="addButton2" style="background-color:#3C9;" title="Add New Article"></div></td></tr></table> 
<form action="mediaAdmin.php" name="updateFront" method="post">
<iframe id="showAllMA" src="mini.php?show=allM-5-<?php echo $mAOrder;?>" frameborder="0" class="catProj" scrolling="no"></iframe>
<br><br>
</td>
<td valign="top">
<div id="mAInfoCont">
 <span class="errorMsg"><?php echo $portError;?></span> 
 </div>
</td><td valign="top">
<div class="bigSaveButtons" id="saveMediaBtn"><p>ADD ARTICLE</p></div>
<div id="mAContents">
<div id="mAContentsPG">
 <table class="adminBody" style="margin-left:3px;margin-top:10px;"><tr><td width="215px">ALL ARTICLE PAGES</td>
<td><div class="addButton2" style="background-color:#3C9;" title="Add New Article"></div></td></tr></table> 
<div id="mArtFrmt">
<div id="mArtCont"><!--BEGIN MEDIA PAGE CONTAINER -->
<?php 
$addJQ = "";
if(isset($allImgs))
{	
ksort($allImgs);
$ct = 1;
foreach($allImgs as $i)
{
echo '
<div class="mArtDiv" title="'.$i[id].'"><table style="margin-left:5px;"><tr><td class="mTxtH" width="85px">p.'.$ct.'</td><td width="145px"><div id="mImg'.$i[id].'" class="mArtInner"><img src="../portfolio/'.$dName.'/'.$i[src].'" class="mImg"></div></td><td><div class="eBtn" id="emArt'.$i[id].'"></div><br><div class="dBtn" onclick="deleteArt('.$i[id].');"></div></td><td></td></tr></table></div>';

$addJQ = $addJQ.'phArr.push(new pPhoto("'.$i[id].'","../portfolio/'.$dName.'/'.$i[src].'","697,484","'.$i[title].'","'.$i[kws].'","","../portfolio/'.$dName.'/'.$i[thmb].'",".jpg",0));';	
$ct = $ct +1;	
}
}
?>
<!--END MEDIA PAGE CONTAINER -->
</div>
</div>
</div>

</div>

<div id="mAContentsVid">
</div>

<div id="mAContentsDg">
</div>
</div>
</td>
</tr>
</table>
</div>

</body>

</html>