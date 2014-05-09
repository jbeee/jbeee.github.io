<?php
if(isset($_GET["specs"]))
{
		echo '<META NAME="ROBOTS" CONTENT="NOINDEX, FOLLOW">
			<script src="../import/jQuery.js" type="text/javascript"></script>
			<script src="imageJQ.js" type="text/javascript"></script> ';
}
else
{
	echo '<META HTTP-EQUIV="Refresh" Content="0; URL=http://www.oasis-ad.com">';    
    exit;  
}
?>


<style>
*{margin:0;padding:0}
body{background-color:#fff;text-align:center;height:100%;width:100%;font-family:"Arial Narrow", Helvetica, sans-serif;color:#FFF;font-size:14px}
.imageEditContainer{background-color:#fff;width:1000px;height:584px;position:absolute;top:0px;left:0px;border:1px solid #999;overflow:hidden;text-align:left;}
#imageEditor{position:relative;height:100%;width:100%;overflow:hidden;text-align:center}
#imageEditor img{visibility:hidden}
.overlayTD{background:url(../graphics/editBG.png)}
#fitTo{width:500px;height:500px;border:1px dashed #444;background:url(../graphics/missingTHM.png) #e9e9e9 no-repeat center;position:relative}
#dimTable{width:840px;height:578px;color:#000;border:0;text-align:center;border-collapse:collapse;border-spacing:0}
#saveImg{width:140px;height:80px;margin-bottom:15px;font-size:22px;line-height:25px;}
.bigSizeText{font-size:70px;letter-spacing:5px;color:#BBB;line-height:60px;font-weight:bolder}
.bigSizeText b{letter-spacing:-1px;font-size:20px;color:#888;line-height:20px}
.bigSizeText strong{letter-spacing:-1px;font-size:17px;color:#999;line-height:20px;color:#c1c1c1}
#imgRadio{letter-spacing:-1px;font-size:23px;color:#AAA;line-height:25px;}
#errorMsg{color:#C00;font-size:12px;text-transform:uppercase;line-height:13px;display:block;height:31px;padding-top:5px;}
#errorMsg b{font-size:18px;letter-spacing:-1px;line-height:18px}
#imglist{background-color:#eee;background-image:url(../graphics/stripedBG.png);border:1px solid #cfcfcf;overflow:hidden;position:relative}
.item{height:36px;width:170px}
.item table{background-color:#e7e7e7;border-bottom:1px dotted #bbb;border-top:1px dotted #bbb;color:#333;font-size:10px;font-weight:700;
height:36px;overflow:hidden;text-align:right;text-transform:lowercase;width:170px}
.dlbtn{background:url(../graphics/smallActionBtns.png) repeat 0 40px;cursor:pointer;height:20px;overflow:hidden;width:20px}
#formatUploads{position:absolute;cursor:pointer;top:-2px;left:-100px;}
#formatUploads input{cursor:pointer;height:100px;opacity:0.0;filter:alpha(opacity=0.0);}
#textFormat{font-size:17px;color:#555;text-transform:uppercase;font-weight:700;letter-spacing:2px;word-spacing:2px;}
.chooseImgBtn{position:relative;overflow:hidden;font-family:"Arial Narrow", Helvetica, sans-serif;font-size:14px;font-weight:bold;background-color:#FFF;background-image:url(../graphics/inputShadow.png);background-repeat:repeat-x;border:1px solid #BBB;color:#555;letter-spacing:-1px;width:70px;height:30px;line-height:13px;text-align:center;cursor:pointer;}
#uploadImgFile{background-color: #71d37d;borderTop:1px solid #ecf9fe;borderLeft:1px solid #ecf9fe;borderBottom:1px solid #88baa3;borderRight:1px solid #88baa3;color:#444;cursor:pointer;width:70px;height:30px;font-weight:bold;font-size:11px;display:none;}
#imgFileName{color:#aaa;font-size:14px;font-weight:700;text-transform:lowercase;line-height:15px;}
#cancelImg{display:none;height:26px;font-size:12px;width:65px;color:#777}
#btnPad{height:7px;width:1px;}
#padSave{height:25px;width:1px;}
@-moz-document url-prefix() {#formatUploads{top:-2px;left:-150px;}}
</style>
<!--[if IE]>
<style>
#formatUploads{cursor:pointer;margin-left:-50px;}
#btnPad{display:none}
#cancelImg{padding-top:7px;}
#saveImg{padding-top:25px;}
#padSave{display:none;}
</style>
<![endif]-->
<?php
//specs = h-w-max-ext-port-thmb
//[height],[width],[0-1],[.png/.jpg],[0-383-697],[n,e,r]
//dims = src-top-left-height-width-order
//action = save/upload
//?specs=25,66,0,.jpg,697,0&dims=@tempGraphics/tmp30.jpg,256,379,96,138,0&action=save
$imgSpecs = explode(",",$_GET['specs']);
$h=$imgSpecs[1];
$w=$imgSpecs[0];
$showPort = $imgSpecs[4];

$x = 0;	
$dir = new DirectoryIterator('tempGraphics');
foreach($dir as $file ){$x=$x+1;}
$filename = 'tempGraphics/img'.$x;
$numImgs=0;


$allImgs = array();	
$getImgs = explode("@", substr($_GET["dims"],1));
foreach ($getImgs as &$i)
{
	$img = explode(",", $i);
	$allImgs[$img[5]] = $img;
	$numImgs++;  
}
	
ksort($allImgs);

function uploadImage($filename){
$postvars = array("image"=> trim($_FILES["image"]["name"]),"image_tmp"=> $_FILES["image"]["tmp_name"]);
$name = explode(".",strtolower(trim($_FILES["image"]["name"])));
$ext = end($name);
$size=filesize($_FILES['image']['tmp_name']);
if(($size > 2000000))
{
	return '<b>Upload Failed</b><br>Maximum file size 2MB</span>';
}
list($width,$height) = getimagesize($postvars["image_tmp"]);
if(($height>563)||($width>785))
{
	$hRatio = 563/$height;	$wRatio = 785/$width;	
		if($hRatio > $wRatio)
		{
			 $newH = $hRatio * $height;
			 $newW = $hRatio * $width;
		}
		else
		{
			 $newH = $wRatio * $height;
			 $newW = $wRatio * $width;
		}
	if($ext == "jpg" || $ext == "jpeg"){
		$tempImg = imagecreatetruecolor($newW,$newH);
		$image = imagecreatefromjpeg($postvars["image_tmp"]);
		imagecopyresampled($tempImg,$image,0,0,0,0,$newW, $newH ,$width,$height);
		imagejpeg($tempImg,$filename.$name[0].'.jpg',100);
	}
	else if($ext == "png")
	{
		$tempImg = imagecreatetruecolor($newW,$newH);
		$image = imagecreatefrompng($postvars["image_tmp"]);
		 $tIdx = imagecolortransparent($image);
		 if ($tIdx >= 0) {
       						$tClr=imagecolorsforindex($image, $tIdx);
       						$tIdx=imagecolorallocate($tempImg, $tClr['red'], $tClr['green'], $tClr['blue']);
    					    imagefill($tempImg, 0, 0, $tIdx);
      						imagecolortransparent($tempImg, $tIdx);
				  		 }
        imagealphablending($tempImg, false);
        $color = imagecolorallocatealpha($tempImg, 0, 0, 0, 127);
        imagefill($tempImg, 0, 0, $color);
        imagesavealpha($tempImg, true);
		imagecopyresampled($tempImg,$image,0,0,0,0,$newW,$newH,$width,$height);
		imagepng($tempImg,$filename.$name[0].'.png',9);
      
	}
	else if($ext == "gif")
	{
		$tempImg = imagecreate($newW,$newH);
		$image = imagecreatefromgif($postvars["image_tmp"]);
		$tIdx = imagecolortransparent($image);
    	  if ($tIdx >= 0) {
        	$tClr=imagecolorsforindex($image, $tIdx);
        	$tIdx=imagecolorallocate($tempImg, $tClr['red'], $tClr['green'], $tClr['blue']);
     	 	imagefill($tempImg, 0, 0, $tIdx);
       		imagecolortransparent($tempImg, $tIdx);
     		 }
		imagecopyresampled($tempImg,$image,0,0,0,0,$newW,$newH,$width,$height);
		imagegif($tempImg,$filename.$name[0].'.gif');			 
		}
	imagedestroy($image);	
	imagedestroy($tempImg);	
}

if(move_uploaded_file($_FILES['image']['tmp_name'], $filename.$name[0].'.'.$ext)) 
			{
				return  $filename.$name[0].'.'.$ext.'" width="'.$width.'px" height="'.$height.'px';
			}
			else
			{
				return '<b>Upload Failed</b><br>Could not connect to server</span>';
			}


}

if(0 < $showPort)
{
	$displayP = "";
	
	if($showPort==383)
	{
		$doubleJQ=",'double':true";
		$single='';
		$double='checked';
	}
	else
	{
		$single='checked';
		$double='';
	}
}
else
{
	$showPort=$imgSpecs[0];
	$displayP = 'style="display:none;"';
}

if($imgSpecs[2]==1)
{
	$maxString = '<strong>MAX: </strong>';
	$maxJQ =",'max':true";
}
		
		


if(isset($_GET["save"]))
{
		$cropDims = explode(",",$_GET["save"]);
		$baseColor = imagecreatefrompng('../graphics/base.png');
		$base = imagecreatetruecolor($w, $h);
		imagecopyresampled($base,$baseColor,0,0,0,0,$w,$h,10,10);	
		$tdT = $cropDims[0]-6;
		$tdR = $cropDims[1]-4;

		foreach($allImgs as $i)
		{
				$ext = end(explode(".",strtolower($i[0])));
				list($wImg,$hImg) = getimagesize($i[0]);
				$newH = $i[3]+3;
				$newW = $i[4]+3;
				$pullX=0;
				$pullY=0;
				$pushX=0;
				$pushY=0;
				$tmpX=$newW;
				$tmpY=$newH;		
			if($i[1]<$tdT)
	    	{
				$pullY = $tdT-$i[1];
				$tmpY = $newH-$pullY;
			}
			else
			{
				$pushY = $i[1] - $tdT;
			}
			if($i[2]<$tdR)
			{
				$pullX = $tdR-$i[2];
				$tmpX = $newW-$pullX;
			}
			else
			{
				$pushX = $i[2]+2 - $tdR;
			}			
			
			
			if($ext == "png")
			{
				$image = imagecreatefrompng($i[0]);
				$tmp = imagecreatetruecolor($newW,$newH);
				 $tIdx = imagecolortransparent($image);
				 if ($tIdx >= 0) {
       						$tClr=imagecolorsforindex($image, $tIdx);
       						$tIdx=imagecolorallocate($tmp, $tClr['red'], $tClr['green'], $tClr['blue']);
    					    imagefill($tmp, 0, 0, $tIdx);
      						imagecolortransparent($tmp, $tIdx);
				  				 }
       			 imagealphablending($tmp, false);
       			 $color = imagecolorallocatealpha($tmp, 0, 0, 0, 127);
        		 imagefill($tmp, 0, 0, $color);
       			 imagesavealpha($tmp, true);
			}
			else if($ext == "gif")
			{
				$image = imagecreatefromgif($i[0]);
				$tmp = imagecreate($newW,$newH);
				$tIdx = imagecolortransparent($image);
    	 		 if ($tIdx >= 0) {
        			$tClr=imagecolorsforindex($image, $tIdx);
        			$tIdx=imagecolorallocate($tempImg, $tClr['red'], $tClr['green'], $tClr['blue']);
     			 	imagefill($tempImg, 0, 0, $tIdx);
       				imagecolortransparent($tempImg, $tIdx);
     							 }
			}
			else
			{
				$image = imagecreatefromjpeg($i[0]);
				$tmp = imagecreatetruecolor($newW,$newH);
			}
			imagecopyresampled($tmp,$image,0,0,0,0,$newW,$newH,$wImg,$hImg);
		    imagecopyresampled($base,$tmp,$pushX,$pushY,$pullX,$pullY,$tmpX,$tmpY,$tmpX,$tmpY);
		
			imagedestroy($tmp);	
			imagedestroy($image);	
		}//close foreeach
		if($showPort==383)
		{
			imagecopyresampled($base,$baseColor,343,0,0,0,11,484,10,10);		
		}
		if($imgSpecs[3]=='.jpg')
		{
			imagejpeg($base,$filename.$imgSpecs[3],100);
		}
		else if($imgSpecs[3]=='.png')
		{
		   imagepng($base,$filename.$imgSpecs[3],9);
		}
		else
		{
		   imagegif($base,$filename.$imgSpecs[3]);
		}
		if($imgSpecs[5]!='-1')
		{
			$t = imagecreatetruecolor(66,25);
			imagecopyresampled($t,$base,0,0,394,250,160,111,697,484); 
			imagejpeg($t,$filename.'THMB.jpg',100);
			imagedestroy($t);
		}
		imagedestroy($base);
		$allImgs=array(); 
		$numImgs=1;
		$allImgs[0] = array($filename.$imgSpecs[3],$tdT,$tdR-3,$h,$w,0);
		$parentCallBack = 'parent.newImg(\''.$filename.$imgSpecs[3].'\');';
	
}
if(isset($_GET["upload"]))
{
		$addNewImage=uploadImage($filename);
		if (!(strpos($addNewImage, 'Upload Failed') === false))
		{
			$error = $addNewImage;
		}
		else
		{
			$allowEdit = "visible";
			$missingImg = "";
			$img1Src= $addNewImage;
			$uploaded = 'changeUploadButton("saveImg");';
			$allImgs[numImgs] = array($addNewImage,'n');			
		}
}//close if=upload

?>
<script>
<?php echo $parentCallBack?>
var baseQuery = new Array(<?php echo $w.','.$h.','.$imgSpecs[2].',"'.$imgSpecs[3].'","'.$imgSpecs[4].'","'.$imgSpecs[5].'"'?>);
<?php echo $uploaded?>
$(document).ready(function()
{	$('#imageEditor').imageEditor({'fitW':<?php echo $w;?>,'fitH':<?php echo $h;?><?php echo $doubleJQ.$maxJQ;?>});
	$('#cancelImg').click(function(){$('#imgFileName').html('');$('#chooseFile,#chooseWeb').css({'display':'block'}); 
	$('#uploadImgFile,#cancelImg').css({'display':'none'});});
});
</script>
</head>
<body>
<div class="imageEditBG"></div>
<div class="imageEditContainer"> 
<table><tr><td width="840px" height="580" rowspan="4">
<div id="imageEditor">
<?php foreach($allImgs as &$i)
	{
		if($i[0] != "")
		{
 		echo '<img src="'.$i[0].'"';
		if($i[1] != 'n')
		{
			echo 'title="'.$i[1].','.$i[2].','.$i[3].','.$i[4].'"';
		}
		else
		{
			echo ' height="'.$i[3].'" width="'.$i[4].'"';
		}
		echo '>';
		}
	}?>
</div>
</td><td bgcolor="#fafafa" width="174px" height="120px" align="center" valign="top">
<div class="bigSizeText">size<br><?php echo $maxString;?><b>w:<span id="imgW"><?php echo $showPort;?></span>px h:<span id="imgH"><?php echo $h;?></span>px</b></div>
</td></tr><tr><td align="center">
<table id="imgRadio" <?php echo $displayP;?>>
<tr><td><input type="radio" name="radio" class="radio" value="1"/ <?php echo $single;?>></td><td> Single</td><td width="15px"></td>
<td><input type="radio" name="radio" class="radio" value="2"/ <?php echo $double;?>></td><td>Double</td></tr>
</table>
</td></tr><tr><td bgcolor="#fafafa" align="center" valign="top">
<form id="uploadForm" action="<?php echo '?specs='.$_GET["specs"].'&dims='.$_GET["dims"].'&upload'?>" method="post" enctype="multipart/form-data">
<span id="errorMsg"><?php echo $error;?></span>
<span id="textFormat" id="imgAction">ADD IMAGE</span>
<table><tr><td colspan="2" height="15px" align="center">
<span id="imgFileName"></span>
</td></tr><tr><td>
<div id="chooseFile" class="chooseImgBtn">C H O O S E <br>F I L E
<div id="formatUploads">
<input type="file" name="image" id="I2Upload" size=20 onChange="uploadVal();"/></div>
</div>
<input type="submit" name="newImg" id="uploadImgFile" value="UPLOAD"></form>
</td><td>
<div id="chooseWeb_SOOOON" class="chooseImgBtn" style="display:none;">C H O O S E <br>W E B</div>
<div id="cancelImg" class="chooseImgBtn"><div id="btnPad"></div>C A N C E L</div>
</td></tr><tr><td colspan="2" height="3px"></td></tr></table>
<div id="imgList"></div>
</td></tr><tr><td align="center" bgcolor="#fafafa"><div id="saveImg" class="chooseImgBtn" onClick="saveImg();"><div id="padSave"></div>CREATE IMAGE</div>
</td></tr></table></div>
</body></html>
