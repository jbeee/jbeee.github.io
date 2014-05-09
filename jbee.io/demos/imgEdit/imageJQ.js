var error="";
var processString="";
var fitToPos;
var dNum=0;
function changeUploadButton(id)
{
	if(dNum<4)
	{
	$('#'+id).css({'background-color': '#c7dcd3','borderTop':'1px solid #ecf9fe','borderLeft':'1px solid #ecf9fe','borderBottom':'1px solid #88baa3','borderRight':'1px solid #88baa3','color':'#444','cursor':'pointer'});
	$('#formatUploads').css('display','none');
	$('#uploadImg').css('display','block');
	}
	else
	{
		$('#errorMsg').html('<b>Upload Failed</b><br>Maximum Four Images');
	}
}
function uploadVal(){
	$('#errorMsg').html('');
	var upVal = $('#I2Upload').val();if(upVal != null){var n=upVal.lastIndexOf(".");	var ext = upVal.substr(n+1);	
	if((ext == 'jpg')||(ext == 'jpeg')||(ext == 'png')||(ext == 'gif'))
	{n=upVal.lastIndexOf("\\");	if(n != -1){upVal = upVal.substr(n+1);}$('#imgFileName').html(upVal);
	$('#uploadImgFile,#cancelImg').css({'display':'block'});
	$('#chooseFile,#chooseWeb').css({'display':'none'});}
	else{$('#errorMsg').html('<b>Not an Image File</b><br>Must be .jpg, .png, or .gif');}}}

function saveImg()
{
		if(dNum==0)
		{
			$('#errorMsg').html('<b>Save Failed</b><br>No Images Selected<br>');
		}
		else if(error=="")
		{
			
			var qs="?specs=" + baseQuery +'&dims='+ processString + '&save='+fitToPos.top+','+fitToPos.left;
			window.location = qs;
		}
		else
		{
			$('#errorMsg').html(error);
		}
}

(function( $ ){
$.fn.imageEditor = function( options ) { 
var settings = $.extend({'fitH':500,'fitW':500,'double':false,'max':false}, options);
var newDims=options;
var fitW = parseInt(newDims.fitW);
var fW = fitW;
var fitH = parseInt(newDims.fitH);
var isIE = isIE();
if(isIE){$('#I2Upload').attr('size',12);}
var activeControl='NONE';
var clickPosX;
var clickPosY;
var lastY;
var activeImg='NONE';
var shftPr = false;
var backOne = new Array(-1,0,0,0,0);
var eImg = new Array(0,0,0,0,0,0,0,0,0);
//0imgH,1imgW,2MimgH,3MimgW,4newTop,5newLeft,6newH,7newW
var allImgs = (this).children("img");
numImgs = allImgs.length;
dNum = numImgs;
var imgZ = 900;
var overImgZ = 900+numImgs;
var nudgeImg = 0;
var borderColors = ["#c03c52","#2c92c2","#479448","#b040b3","#f8d111"];
var thisColor = 1;
var imgDims = new Array();
var imgListHtml="";

borderString = '<table id="dimTable"><tr><td colspan="3" class="overlayTD" id="tdT"></td></tr><tr><td id="tdL" class="overlayTD"></td><td><div id="fitTo"></div></td><td id="tdR" class="overlayTD"></td></tr><tr><td colspan="3" id="tdB" class="overlayTD"></td></tr></table>';
crop = document.createElement('div');
$(crop).html(borderString);
$(crop).css({'position':'absolute','top':0,'left':0,'z-index':(overImgZ++)});
$(this).append(crop);
var cWidth =840;
var cHeight=580;
$('#fitTo').css({'height':fitH,'width':fitW});
var tdT = (cHeight-fitH)/2;
var tdL = (cWidth-fitW)/2;
var tdR = cWidth - fitW - tdL;
var tdB = cHeight - fitH - tdT;

$('#tdT').height(tdT);
$('#tdB').height(tdB);
$('#tdR').width(tdR);
$('#tdL').width(tdL);

fitToPos = $('#fitTo').position();
centerGuide = document.createElement('div');
$(centerGuide).addClass("overlayTD");
$(centerGuide).css({'position':'absolute','top':0,'left':343,'width':'9px','height':'484px','borderLeft':'1px dashed #444',
				   'borderRight':'1px dashed #444','display':'none'});
$('#fitTo').append(centerGuide);
if(newDims.double)
{
	$(centerGuide).css('display','block');fW = 383;baseQuery[4]=fW;	
}
$('.radio').change(function(){
							if(this.value == 1)
							{
								$(centerGuide).css('display','none');
								fW = 697;
								baseQuery[4]=fW;								
								$('#imgW').html(fW);
								$("#uploadForm").attr("action", "?specs=" + baseQuery +'&dims='+ processString+'&upload');
							}
							else
							{
								$(centerGuide).css('display','block');
								fW = 383;
								baseQuery[4]=fW;								
								$('#imgW').html(fW);
								$("#uploadForm").attr("action", "?specs=" + baseQuery +'&dims='+ processString+'&upload');
							}
							
							});

moveMEContainer = document.createElement('div');
$(this).append(moveMEContainer);
$(moveMEContainer).css({'overflow':'hidden','position':'absolute',
					   width : cWidth ,height : cHeight,'top':'0px','left':'0px','z-index':(overImgZ++)});

absContainer1 = document.createElement('div');
$(moveMEContainer).append(absContainer1);
$(absContainer1).addClass("absContainer");	


$(this).children('img').each(function(i) { 
	imgDims[i] = new Array();
	imgDims[i][4] = $(this).attr('src');
	imgDims[i][5] = i;
	var imgBorder=(i+1)%numImgs;
	var thisBG = -12*imgBorder;
	$(this).attr("id","img"+i);
	moveImg = document.createElement('div');
	$(moveImg).attr("id",'Mimg'+i);
	$(absContainer1).append(moveImg);
	imgAbsContainer = document.createElement('div');
	$(moveImg).append(imgAbsContainer);
	$(imgAbsContainer).addClass("absContainer");	
	
	getMove = document.createElement('div');
	$(getMove).addClass("getMove");
	$(getMove).attr("id",'MVimg'+i);
	$(imgAbsContainer).append(getMove);
	$(imgAbsContainer).css({'border':'1px solid '+borderColors[imgBorder]});
	var bg = 'url(\"../graphics/moveImgButtons.png\") repeat 0px '+ thisBG+'px';

	TL = document.createElement('div');
	$(TL).addClass("moveButton");
	$(TL).attr("id",'TLimg'+i);
	$(TL).css({'top':'-6px','left':'-6px','cursor':'se-resize','background': bg});
	$(imgAbsContainer).append(TL);

	TR = document.createElement('div');
	$(TR).addClass("moveButton");
	$(TR).attr("id",'TRimg'+i);
	$(TR).css({'top':'-6px','right':'-6px','cursor':'ne-resize','background': bg});
	$(imgAbsContainer).append(TR);

	BL = document.createElement('div');
	$(BL).addClass("moveButton");
	$(BL).attr("id",'BLimg'+i);
	$(BL).css({'bottom':'-6px','left':'-6px','cursor':'ne-resize','background': bg});
	$(imgAbsContainer).append(BL);

	BR = document.createElement('div');
	$(BR).addClass("moveButton");
	$(BR).attr("id",'BRimg'+i);
	$(BR).css({'bottom':'-6px','right':'-6px','cursor':'nw-resize','background': bg});
	$(imgAbsContainer).append(BR);
	
	addImage(i,imgBorder);		
	
 var imgTable = '<div class="item"><table><tr><td><div style="width:30px;height:34px;overflow:hidden;';
 imgTable += 'border: 2px solid'+borderColors[imgBorder]+';">';
 imgTable+= '<img src="'+imgDims[i][4]+'" height="40px"></div></td><td align=center><div style="width:110px;overflow:hidden;height:20px;">';
 var n=imgDims[i][4].lastIndexOf('/')+1;
 imgTable += imgDims[i][4].substring(n);
 imgTable += '</div></td><td width="20px"><div class="dlBtn"></div></td></tr></table></div>';
 imgListHtml = imgTable + imgListHtml;

});
$('#imgList').html(imgListHtml);

 if(numImgs>1){$('.item').css({'cursor':'move'});$('.moveButton').css({'display':'none'});}
$('.getMove').css({'width':'98%',
					'height':'98%',
					'position':'absolute',
					'top':'6px',
					'left':'6px',
					'cursor':'move'});
$('.moveButton').css({'width':'12px',
					 'height':'12px',
					 'position':'absolute',
					 'overflow':'hidden'});
$('.absContainer').css({'width':'100%','height':'100%','position':'relative'});


var w = $('.item').width();
var dH =$('.item').height();
var hm = 10;
var dDif = hm+dH;
var dPos = new Array();
var dMap = new Array();
var startZ = 700;
$('#imgList').children('div').each(function(i) {
		var newId = dNum-1-i;
		$(this).addClass('item');
		$(this).attr("id","d"+newId);
		$(this).css({'position':'absolute',right:0,top:((dDif*i)+hm),'z-index':(startZ+(newId+1))});
		
		dPos[newId]=[(dDif*i)+hm,i,i];
		dMap[i]=[(dDif*i)+hm,newId];	
		$(this).find('.dlBtn').attr('id', 'e'+newId);	
		 });
var cH = parseInt(dNum * (dH+hm))+(2*hm);
var lastZ = 700+dNum+2;	
var zones = ((dNum*5)+1);
var g2 = cH/(dNum);
var gu = cH/zones;
var gZone = gu*2;
$('#imgList').css({height:cH,width:w});
$('.imgLayer').css({height:dH,width:w});	

glowZone = document.createElement('div');
$(glowZone).css({height:gZone,width:w,'position':'absolute','z-index':startZ-dNum,'background-color':'#3CC','visibility':'hidden'});
$('#imgList').append(glowZone);	

$(document).mousemove(function(e)
 {
	 if(activeControl != 'NONE')
			{
				if(activeControl == 'list'){moveDiv(e.pageY);}
				else{editImage(e.pageX,e.pageY);}
			}
  });
$(document).keydown(function (e){
				event.preventDefault();				
				if(e.shiftKey){shftPr = true;}
				var code = (e.keyCode ? e.keyCode : e.which);
				if(code == 16){shftPr = true;}
				else if((code == 90)&&(backOne[0] != -1))
				{
					activeImg=backOne[0];					
					getNewDims(backOne[0],backOne[3],backOne[4]);
					$('#img'+backOne[0]).css({"left": backOne[2]+"px","top": backOne[1]+"px","height":eImg[0],"width":eImg[1]});
					$('#Mimg'+backOne[0]).css({"left": backOne[2]+"px","top": backOne[1]+"px","height":eImg[2],"width":eImg[3]});
					setDims();saveME();
					
				}
				else if((activeImg != 'NONE')&&(code >= 37)&&(code <=40)) {
					var mPos = $('#img'+activeImg).position(); backOne[0]= activeImg;backOne[1]= mPos.top;backOne[2]= mPos.left;
					backOne[3]= $('#img'+activeImg).height();backOne[4]= $('#img'+activeImg).width();
					
					if(code <= 37){					
						var nudge=mPos.left-1;$('#img'+activeImg+',#Mimg'+activeImg).css({'left':nudge});}
					else if(code <= 38){var nudge = mPos.top-1;$('#img'+activeImg+',#Mimg'+activeImg).css({'top':nudge});}
					else if(code <= 39){var nudge=mPos.left+1;$('#img'+activeImg+',#Mimg'+activeImg).css({'left':nudge});}
					else if(code <= 40){var nudge=mPos.top+1;$('#img'+activeImg+',#Mimg'+activeImg).css({'top':nudge});}
					setDims();saveME();
					}
			else if(code==88){if(activeImg != 'NONE'){aResizeImg(activeImg);}else if(dNum==1){activeImg=dMap[0][1];aResizeImg(dMap[0][1])}}			
			});

function aResizeImg(aID)
{
	var mPos = $('#img'+aID).position();
	backOne[0]= aID;backOne[1]= mPos.top;backOne[2]= mPos.left;backOne[3]=imgDims[aID][2];backOne[4]=imgDims[aID][3];
		var iH = imgDims[aID][6];
		var iW = imgDims[aID][7];
		var newH; var newW;var newT; var newL;
		var Rm = fitH/fW; 
		var Ri = iH/iW;					 
		if(Ri>Rm){
			newW = fW+1; 
			newH = newW * Ri;
			} 
			else { 
			newH = fitH+1; 
			newW = newH * (iW/iH);
			}
		if(newW <= (fW+1)){newL = tdL-7;}
		else{var move = parseInt((newW - fW)/2);newL = tdL - move-7;}
		if(newH <= (fitH+1)){newT = tdT-7;}
		else{var move =(newH - fitH)/2;newT = tdT - move-7;}	
		
	if(isIE){MimgH = newH + 14;MimgW = newW + 14;}else{MimgH = newH;MimgW = newW;}
	$('#img'+aID).css({'width':newW,'height':newH,'top':newT,'left':newL});
	$('#Mimg'+aID).css({'width':MimgW,'height':MimgH,'top':newT,'left':newL});
	setDims();saveME();
}
$(document).keyup(function (e){shftPr = false;});
$('.item').mousedown(function(e){activeControl='list';clickPosY=e.pageY;lastY=e.pageY;var aZ = overImgZ+activeImg;							  
		if((activeImg != "NONE")&& (numImgs>1))
		{
		$('#d'+activeImg + ' table').css({'background-color':'#e7e7e7', 'borderTop':'1px dotted #666','borderBottom':'1px dotted #666'});
		$('#BRimg'+activeImg+',#BLimg'+activeImg+',#TLimg'+activeImg+',#TRimg'+activeImg).css({'display':'none'});
		$('#Mimg'+activeImg).css({'z-index':aZ});
		}
		activeImg=$(this).attr('id').substring(1);
		aZ = aZ *2;
		$('#d'+activeImg + ' table').css({'background-color':'#d7d7d7', 'borderTop':'1px dotted #666','borderBottom':'1px dotted #666'});
		$('#BRimg'+activeImg+',#BLimg'+activeImg+',#TLimg'+activeImg+',#TRimg'+activeImg).css({'display':'block'});
		$('#Mimg'+activeImg).css({'z-index':aZ});
							  })
			.mouseup(function(){activeControl = 'NONE'; snapTo();});

$('.getMove').mousedown(function(e){clickPosX = e.pageX; clickPosY = e.pageY;setActive($(this).attr('id'));})
		.mouseup(function(){activeControl = 'NONE'; dontFit();});
$('.moveButton').mousedown(function(e){clickPosX = e.pageX; clickPosY = e.pageY;setActive($(this).attr('id'));})
			.mouseup(function(){activeControl = 'NONE'; dontFit();});
$('html').mouseup(function(){ if(activeControl != 'NONE')
								 {
									 activeControl = 'NONE';
									 if(activeControl == 'list'){snapTo();$('.glowZone').css('visibility','hidden');}
									 else{dontFit();}
								 }
								 });
$('#imgList').mouseleave(function(){if(activeControl == 'div'){snapTo();}activeControl = 'NONE'; });


function setActive(id)
	{
		var aZ = overImgZ+activeImg;
		if((activeImg != "NONE")&& (numImgs>1))
		{
		$('#d'+activeImg + ' table').css({'background-color':'#e7e7e7', 'borderTop':'1px dotted #666','borderBottom':'1px dotted #666'});
		$('#BRimg'+activeImg+',#BLimg'+activeImg+',#TLimg'+activeImg+',#TRimg'+activeImg).css({'display':'none'});
		$('#Mimg'+activeImg).css({'z-index':aZ});
		}
		activeControl = id.substring(0,2);
		activeImg = id.substring(5);
		aZ = aZ*2;
		$('#d'+activeImg + ' table').css({'background-color':'#d7d7d7', 'borderTop':'1px dotted #666','borderBottom':'1px dotted #666'});
		$('#BRimg'+activeImg+',#BLimg'+activeImg+',#TLimg'+activeImg+',#TRimg'+activeImg).css({'display':'block'});
		$('#Mimg'+activeImg).css({'z-index':aZ});
		
		setDims();
	}
function setDims()
{
		var mPos = $('#img'+activeImg).position();
		imgDims[activeImg][0]= mPos.top;
		imgDims[activeImg][1]= mPos.left;
		imgDims[activeImg][2]= $('#img'+activeImg).height();
		imgDims[activeImg][3]= $('#img'+activeImg).width();
		
		if(activeControl!='NONE')
		{
			backOne[0]= activeImg;
			backOne[1]= mPos.top;
			backOne[2]= mPos.left;
			backOne[3]=imgDims[activeImg][2];
			backOne[4]=imgDims[activeImg][3];
		}
}


function editImage(x,y)
	{	
		var difX = (x-clickPosX);
		var difY = (y-clickPosY);			
		if(activeControl == 'BR')
		{
			getNewDims(activeImg,imgDims[activeImg][2]+difY,imgDims[activeImg][3]+difX);
			$('#img'+activeImg).css({"height":eImg[0],"width":eImg[1]});
			$('#Mimg'+activeImg).css({"height":eImg[2],"width":eImg[3]});
		}
		if(activeControl == 'TL')
		{				
			getNewDims(activeImg,imgDims[activeImg][2]-difY,imgDims[activeImg][3]-difX);
			$('#img'+activeImg).css({"left": eImg[5]+"px","top": eImg[4]+"px","height":eImg[0],"width":eImg[1]});
			$('#Mimg'+activeImg).css({"left": eImg[5]+"px","top": eImg[4]+"px","height":eImg[2],"width":eImg[3]});
		}
		if(activeControl == 'TR')
		{
			getNewDims(activeImg,imgDims[activeImg][2]-difY,imgDims[activeImg][3]+difX);
			$('#img'+activeImg).css({"top": eImg[4]+"px","height":eImg[0],"width":eImg[1]});
			$('#Mimg'+activeImg).css({"top": eImg[4]+"px","height":eImg[2],"width":eImg[3]});
		}
		if(activeControl == 'BL')
		{
			getNewDims(activeImg,imgDims[activeImg][2]+difY,imgDims[activeImg][3]-difX);
			$('#img'+activeImg).css({"left": eImg[5]+"px","height":eImg[0],"width":eImg[1]});
			$('#Mimg'+activeImg).css({"left": eImg[5]+"px","height":eImg[2],"width":eImg[3]});
			
		}
		else if(activeControl == 'MV')
		{		
			$('#img'+activeImg+',#Mimg'+activeImg).css({"top": (difY + imgDims[activeImg][0])+"px", "left": (difX +imgDims[activeImg][1])+"px" });
		}	
		saveME();

}

function getNewDims(id,h,w)
{
	eImg[0]=h;
	eImg[1]=w;		
	if(!shftPr)
	{
		eImg[1] =  eImg[0]*(imgDims[id][3] / imgDims[id][2]);
	}
	if(isIE){eImg[2] = eImg[0]+14;eImg[3]=eImg[1]+14;}else{eImg[2]=eImg[0];eImg[3]=eImg[1];}
	eImg[4]=imgDims[id][0] + ( imgDims[id][2] - eImg[0]);
	eImg[5]=imgDims[id][1] + ( imgDims[id][3] - eImg[1]);
}


function addImage(i,imgBorder)
{
	var imgH;
	var imgW;
	var newT;
	var newL;
if(($('#img'+i).attr('title')!=null)&&($('#img'+i).attr('title')!=''))
{
	newDims = $('#img'+i).attr('title').split(",");
	newT = newDims[0];
	newL = newDims[1];
	imgH = newDims[2];
	imgW = newDims[3];
}
else
{
imgH=$('#img'+i).height();
imgW=$('#img'+i).width();
	if(nudgeImg != 0)
	{
		nudgeImg += 100;	
	}
	if(imgW <= (fitW+1))
	{
		newL = fitToPos.left + nudgeImg-6;
	}
	else
	{
		var move = parseInt((imgW - fitW)/2);
		newL = fitToPos.left-move+ nudgeImg-6;
	}
if(imgH <= (fitH+1))
{
	newT = fitToPos.top-6;	
}
else
{
	var move = parseInt((imgH - fitH)/2);
	newT = fitToPos.top - move-6;		
}
}

imgDims[i][0]=newT;
imgDims[i][1]=newL;
imgDims[i][2]=imgH;
imgDims[i][3]=imgW;
imgDims[i][6]=imgH;
imgDims[i][7]=imgW;

if(isIE){MimgH = parseInt(imgH)+14;MimgW = parseInt(imgW)+14;}else{MimgH = imgH;MimgW = imgW;}

$('#fitTo').css('background','none');
$('#img'+i).css({'width':imgW,
				'height':imgH,
				'margin':'6px',
				'position':'absolute',
				'top':newT,'left':newL,
				'visibility':'visible',
				'z-index':(imgZ+i),
				'border':'1px solid '+borderColors[imgBorder]});
$('#Mimg'+i).css({'width':MimgW,
					'height':MimgH,
					'position':'absolute',
					'top':newT,
					'left':newL,					
					'padding':'6px',
					'z-index':(overImgZ+i),'diplay':'none'});
activeImg = i;
setDims();

processString+='@'+$('#img'+i).attr('src')+','+newT+','+newL+','+imgH+','+imgW+','+i;
$("#uploadForm").attr("action", "?specs=" + baseQuery +'&dims='+ processString+'&upload');
}

function dontFit()
{
	setDims();
	saveME();
}

function makeProcess()
{
	
   processString="";
	for (i=0;i<numImgs;i++)
	{

		if(imgDims[i][5] != -1)
		{
			processString+="@"+imgDims[i][4]+","+imgDims[i][0]+","+imgDims[i][1]+","+imgDims[i][2]+","+imgDims[i][3]+","+imgDims[i][5];	
		}
	}
	$("#uploadForm").attr("action", "?specs=" + baseQuery +'&dims='+ processString+'&upload');
}
function saveME()
{
	$('#saveImg').css({'background-color': '#c7dcd3','borderTop':'1px solid #ecf9fe','borderLeft':'1px solid #ecf9fe','borderBottom':'1px solid #88baa3','borderRight':'1px solid #88baa3','color':'#444','cursor':'pointer'});
	ok2Save = true;
	makeProcess();
}
				
function moveDiv(y)
{	
	var ogH = parseInt(dPos[activeImg][0]);	
	var newH = ogH +(y-clickPosY);
	var diffY = y-lastY;	
	if((newH>0)&&(newH<(cH-dH)))
	{
		$('#saveImg').html(zone);
		var zone = parseInt((newH+(3*gu))/g2);		
		glowZones(newH,diffY);
		dPos[activeImg][1]=zone;
		$('#d'+activeImg).css({'top':newH,'z-index':lastZ});	
		lastY = y;
	}
}
function glowZones(newH,diffY)
{
	if(diffY < 0)
	{
		$(glowZone).css({'top':newH-gZone,'visibility':'visible'});
	}
	else
	{
		$(glowZone).css({'top':newH+dDif,'visibility':'visible'});
	}
}
function snapTo()
{	
	$(glowZone).css('visibility','hidden');
	var newZ = dPos[activeImg][1]; 
	var newH = dMap[newZ][0];
	var oldZ = dPos[activeImg][2];	
	if(newZ != oldZ)
	{
		nudgeRest(newZ,oldZ);
		$('#img'+activeImg).css('z-index',(imgZ+(dNum-newZ)));
		$('#Mimg'+ activeImg).css('z-index',(overImgZ+(dNum-newZ)));
		dPos[activeImg][0]=newH;
		dPos[activeImg][1]=newZ;
		dPos[activeImg][2]=newZ;	
		$('#d'+activeImg).css({'top':newH,'z-index':startZ});
		dMap[newZ][1] = activeImg;
		imgDims[activeImg][5]=newZ;
		saveME();
	}
	else
	{
		$('#d'+activeImg).css({'top':newH,'z-index':startZ});
		$('#d'+activeImg).css({'background-color':'#e7e7e7', 'borderTop':'1px dotted #bbb','borderBottom':'1px dotted #bbb'});
	}

}
$('.dlBtn').click(function(){if(activeControl == 'div'){snapTo();}activeControl = 'NONE'; 					
												deleteMe($(this).attr('id').substring(1));});
function deleteMe(id)
{
	$('#Mimg'+id).hide();
	$('#img'+id).hide();
	$('#Mimg'+id).remove();
	$('#Mimg'+id).remove();
	imgDims[id][5]=-1;
	dNum = dNum - 1;
	var deleteactiveImg = dPos[id][1];
	dPos[deleteactiveImg][2] = -1;
	 nudgeRest(dNum,deleteactiveImg);
	$('#d'+id).hide();
	$('#d'+id).remove();
	
	 cH = cH-(dH+hm);

	 $('#imgList').height(cH);
	 
	 if(dNum < 1)
	 {
		 error="<b>Save Failed</b><br>No Images Added<br>";		 
	 }
	 makeProcess();
	 activeImg = 'NONE';
}
function nudgeRest(newZ,oldZ)
{
	if(newZ < oldZ)
	{
		for(i=oldZ;i>newZ;i--)
		{	
			var dM = dMap[i-1][1];
			var zDX = dNum - i;
			dMap[i][1]=dM;
			dPos[dM][0] = dMap[i][0];
			dPos[dM][1] = i;
			dPos[dM][2] = i;
			$('#d'+dM).animate({top:dMap[i][0]}, 200, function() {});	
			$('#img'+dM).css('z-index',(imgZ+zDX));
			$('#Mimg'+ dM).css('z-index',(overImgZ+zDX));
			imgDims[dM][5]=i;
		}
	}
	else if(newZ > oldZ)
	{		
		for(i=oldZ;i<newZ;i++)
		{
			var dM = dMap[i+1][1];
			var zDX = dNum - i;
			dMap[i][1]=dM;
			dPos[dM][0] = dMap[i][0];
			dPos[dM][1] = i;
			dPos[dM][2] = i;
			$('#d'+dM).animate({top:dMap[i][0]}, 200, function() {});		
			$('#img'+dM).css('z-index',(imgZ+zDX));
			$('#Mimg'+ dM).css('z-index',(overImgZ+zDX));
			imgDims[dM][5]=i;
		}
	}	
}
function isIE(){
if (
navigator.appName == 'Microsoft Internet Explorer'){return true;}else{return false;}}
}; 
})( jQuery );
