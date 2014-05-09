var ok2Save = false;
var aId;
var hsID;
var addToCat = -1;
var thsProj = -1;
var phArr = new Array();
function isIE(){if (navigator.appName == 'Microsoft Internet Explorer'){return true;}else{return false;}} var tFontF = isIE();

function nudgeEditsTable($newH)
{if($newH < 132){$('#showPgCEdits').css({'top':'0px'});}else{$newH -= 130;$('#showPgCEdits').css({'top': $newH +'px'});}}

function getNewPChks()
{
	var nps = '';
	var npsVal = '';

	var boxes = $('input[name=allChkProj]:checked');
	$("input:checkbox[name=allChkProj]:checked").each(function()
	{
  		nps += ', '+ prjArr[$(this).val()][1];
		npsVal += ',' + prjArr[$(this).val()][0];
	});	

	return npsVal.substring(1)+'>:D'+nps.substring(1);
}
function clearPHInputs()
{
	$('#editpgName').val('');
	$('#editpgComp').val('');
	$('#editpgWeb').val('');
	$('#editpgNum').val('');
	$('#editpgTxt').val('');
	$('#chkShowTExt').attr('checked','checked');
	for(i=0;i<prjArr.length;i++)
	{
		$('#pgCPRoj'+prjArr[i][0]).removeAttr('checked');
	}
	for(i=0;i<tmpProjs.length;i++){	tmpProjs[i][2] = prjArr[i][2]; tmpProjs[i][3] = prjArr[i][3];}
}
function pgChkFxn(prStr)
{	
	var phP=prStr.split(",");
	for(i=0;i<phP.length;i++)
	{
		
		$('#pgCPRoj'+phP[i]).attr('checked','checked');
	}
}

function pPhoto(id,src,dims,ti,kws,dN,thmb,ext,changed)
{this.id=id;this.dN=dN;this.dims=dims;this.ext=ext;
this.src=src;//8 1000
this.title=ti;//4 0100
this.kws=kws;//2 0010
this.thmb=""+thmb;//1 0001
this.changed = changed; //default:00000,new://16:10000;
}

function mArt(id,src,title,date,author,photographer,type,kws,txt,thmb,pOrder,tImg,bImg,srcWeb,aURL,nImgs,nn,changed)
{this.id = id;this.src=src;this.title=title;this.date=date;this.author=author;this.type=type;this.kws=kws;
this.txt=txt;this.pOrder=pOrder;this.tImg=tImg;this.bImg=bImg;this.srcWeb=srcWeb;this.aURL=aURL;this.changed = changed;
this.thmb=thmb;this.photographer=photographer;this.nImgs = nImgs;this.nn=nn}

function refreshFrameHeight(addH)
{
		parent.refreshInner(addH);		
}
function changeCurrentCat(me)
{
	addToCat = me;
}
function refreshInner(addH)
{
	var oldH = $(document).height();
	$(document).height(oldH+addH);
	$('#showAllMA').height(addH);
	parent.changePEditFrm(oldH+addH);
}
function changePEditFrm(newH)
{
	$('#editProjectPOP').height(newH);
	var fTop  = $('#editProjectPOP').scrollTop();
	$('#popUPproj').height(fTop+newH);
	$('#popHproj').height(newH);
	$('#spacer').height(fTop+newH);	
}
function editProjFXNS()
{

	$('#saveAllProj').click(function(){
							if(ok2Save){									
								for(i=0;i<phArr.length;i++){
									if( $('#pCatT'+i).attr('value') != phArr[i].title)
									{
										title = $('#pCatT'+i).attr('value');
										phArr[i].changed = phArr[i].changed | 4;
									}
									else
									{
										title="";
									}
									if(phArr[i].changed > 0)
									{
										var img = phArr[i].src;
										var pOrder = cleanString(phArr[i].kws);
										var changes = phArr[i].changed;	
										$('#ipCat'+i).attr('value', changes+'~'+ img +'~'+ title +'~'+ pOrder)		
									}									
								}
						    	document.forms['updateFront'].submit();
								}
											 });		
}
function addProjectFXNS()
	{

	$('.apPhotoBox').mouseenter(function() {$(this).css('background-color', '#ddd');})
   				   .mouseleave(function(){$(this).css('background-color', '#eee');});
				   
	$('#apAddPhoto').click(function(){editPhotoInfo(-1);});
	$('#saveProjButton').click(function(){if(ok2Save){
											 setChanges();
								document.forms['editProject'].submit();
											 }});
	
	$('.sideNum').click(function(){
							this.value == 1;
							if(this.value == 1)
							{
								$('.singleSide').css('display','block');
								$('.doubleSide').css('display','none');
								sideNum=1;
							}
							else
							{
								$('.singleSide').css('display','none');
								$('.doubleSide').css('display','block');
								sideNum=2;
							}
							changeUploadButton('saveProjButton');
							
							});	
	$('#editProject input').keyup(function(){iChanged($(this).attr('name'));});
	$('#kws').keyup(function(){iChanged($(this).attr('name'));});
	$('#cats').change(function(){iChanged($(this).attr('name')); parent.changeCurrentCat($(this).attr('value'))});
	$('#desc').keyup(function(){iChanged($(this).attr('name'));});		
};

function setChanges()
{

	if(currentProj != "new")
	{	
	
	var eStr = "";	var changed=""; 	var tShow="";
for(i=2;i<phArr.length;i++)
{
	if(phArr[i].changed != 0){eStr += '@'+phArr[i].id+':'+phArr[i].src+':'+phArr[i].title+':'+phArr[i].kws+':'+phArr[i].thmb+':'+phArr[i].changed;}
}
if(eStr != "")
{
		$('#pEdsVal').attr('value',eStr.substr(1));
}	

for(i=0;i<7;i++){
	tShow += ','+projLists[i][3]; if(projLists[i][1]!=0){changed+='-'+projLists[i][0]+'@'+projLists[i][2];}}				
	 if(changed != ""){$('#chVal').attr('value',changed.substr(1));$('#showVal').attr('value',tShow.substr(1));}
	}
	if(bsx != ""){$('#bsxVal').attr('value',bsx.substr(1));}
	 var idOrderStr = cleanString(newOrderStr);	
	 if($('#pOrdVal').attr('value')!= idOrderStr)
	 {
		 $('#pOrdVal').attr('value',idOrderStr);
	 }
	 else
	 {
		 $('#pOrdVal').attr('value','');
	 }	
	 
}

function iChanged(name){if(bsx.indexOf(name)==-1){bsx += ','+name;}changeUploadButton('saveProjButton')}

function changeUploadButton(id)
{
	$('#'+id).css({'background-color':'#88c6aa','border':'1px solid #666','color':'#444','cursor':'pointer'});
	$('#'+id + ' p').css({'color':'#444'});
	ok2Save = true;

	if(id=='saveProjButton')
	{		
		var newH = $(document).height();
		parent.changePEditFrm(newH);
	}
}


function editStatement()
{									 
  		var newStatement = $('#editedStatement').val();
		changeUploadButton('statementChange');
		$('#statementPreview').html(newStatement);
		$('#confirmSave').html("");
		ok2Save = true;
}

function showProjPU(id)
{
	if(id == -1)
	{
		window.open('addproject.php?nav=create-new');
	}
	else
	{
	window.open('addproject.php?nav=show-'+id);
	}
}

function encodeQ(str){var replaced=['!','*',"'","(",")",";",":","@","&","=","+","$",",","/","?","#","[","]","~"," ","<",">",'"'];var nStr = str;
var key=['%21','%2A','%27','%28','%29','%3B','%3A','%40','%26','%3D','%2B','%24','%2C','%2F','%3F','%23','%5B','%5D','%7E','+','%3C','%3E','%34'];
for(enQ=0;enQ<key.length;enQ++){var encoded=false;while(nStr.indexOf(replaced[enQ]) != -1){nStr = nStr.replace(replaced[enQ],key[enQ]);}}return nStr;}

function cleanString(cleanStr)
{while(cleanStr.indexOf(',,')!= -1){cleanStr = cleanStr.replace(',,',',');}if(cleanStr[0] == ','){	cleanStr = cleanStr.substr(1);}	
var end = cleanStr.length - 1;
if(end == cleanStr.lastIndexOf(',')){ cleanStr = cleanStr.substr(0,end);}return cleanStr;}

function editImg(id,mx,prt)
{
	aId = id;
	var cp = phArr[findPhoto(id)];
	createBigPop(1000,584,'img',true);
	
	var specsStr = "";var dimStr = "";
	var splitDims = (cp.dims).split(",");
	specsStr = 'specs='+ cp.dims+','+mx+','+cp.ext+','+prt+','+cp.thmb;
	if(cp.src != ""){dimStr = '&dims=@'+cp.src+',n,0,'+splitDims[1]+','+splitDims[0]}
	var htmlStr = '<iframe id="innerAdmin" src="imageJQ.php?'+specsStr+dimStr+'"';
	htmlStr += 'frameborder="0" width="1000px" height="584px" scrolling="no"></iframe>';
	$(popHtml).html(htmlStr);
	$(popHtml).append(closePop);
	$('#closePopimg').click(function(){$('#popUPimg').fadeOut("fast",function(){$('#popUPimg').remove();}); });
}
function editTeamImg(id,mx,prt)
{
	aId = id;
	var cp = phArr[findPhoto(id)];
	createBigPop(1000,584,'img',true);
	
	var specsStr = "";var dimStr = "";
	var splitDims = (cp.dims).split(",");
	specsStr = 'specs='+ cp.dims+','+mx+','+cp.ext+','+prt+','+cp.thmb;
if(cp.src != ""){dimStr = '&dims=@'+cp.src+',n,0,'+splitDims[1]+','+splitDims[0] + '@../graphics/greyBack.png,n,0,'+splitDims[1]+','+splitDims[0] +',0' }
	var htmlStr = '<iframe id="innerAdmin" src="imageJQ.php?'+specsStr+dimStr+'"';
	htmlStr += 'frameborder="0" width="1000px" height="584px" scrolling="no"></iframe>';
	$(popHtml).html(htmlStr);
	$(popHtml).append(closePop);
	$('#closePopimg').click(function(){$('#popUPimg').fadeOut("fast",function(){$('#popUPimg').remove();}); });
}
function newImg(imgUrl)
{
	var aImg = phArr[findPhoto(aId)];
	if((aId == 'tmpPhoto')||(aId == 'tmpThmb'))
	{
		changeUploadButton('savePhotoButton');
		if(aId == 'tmpPhoto')
		{
			var thmbUrl = imgUrl.replace('.','THMB.');
			aImg.thmb = thmbUrl;
			$('#tempViewThmb').html(addImgHtml(thmbUrl));			
		}
	}

	var aDiv = '#' + aImg.dN;
	var imgH = $(aDiv).height();
	var imgW = $(aDiv).width();
	$(aDiv).html('<img src="'+imgUrl+'" height="'+imgH+'px" width="'+imgW+'px">');
	changeUploadButton('saveProjButton');
	changeUploadButton('saveAllProj');
	changeUploadButton('saveTeamButton');
	changeUploadButton('savePgCButton');
	changeUploadButton('saveProcBtn');
	aImg.changed = aImg.changed | 8;
	aImg.src = imgUrl;
}

function findPhoto(id){for(i=0;i<phArr.length;i++){if(phArr[i].id == id){return i;}}}
function addImgHtml(url){if(url != ""){return '<img src="'+url+'">';}else{return '';}}

function editProjectPhoto(id)
{
	if(id=='newPhoto'){var temp = new pPhoto("tmpPhoto","","697,484","","","tempView","",".jpg",16); phArr[0]=temp}	
	else{ var idx = findPhoto(id); 
	var cp = phArr[idx];var temp = new pPhoto('tmpPhoto',cp.src,cp.dims,cp.title,cp.kws,"tempView",cp.thmb,cp.ext,cp.changed);
	phArr[0]=temp; phArr[1].src=cp.thmb}	
	var tableString = '<table id="editTable"><tr><td align="center"><div class="showImg" id="tempView" style="width:697px;height:484px;">';
	tableString +=  addImgHtml(temp.src)+'</div><div class="lilButton" style="width:697px;height:15px;">';
	tableString += '<a href="javascript:void(0)" onClick="editImg(\'tmpPhoto\',0,697);">UPDATE</a></div>';
	tableString += '</td><td valign="top"><br><br><span class="errorMsg" id="editError"></span><br>Title:<br><input class="lilTexts"';
	tableString += ' id="editTitle" size=36 maxlength="38" onKeyUp="changeUploadButton(\'savePhotoButton\');" value="'+temp.title+'">';
	tableString += '<br><br>Thumbnail: <span class="noteText"> W:65px H:25px</span><div class="apImgDivFormat"><table><tr><td width="110px">';
	tableString += '<div class="showImg" style="width:66px;height:25px;" id="tempViewThmb">'+addImgHtml(temp.thmb)+'</div></td>';
	tableString += '<td align="center"><div class="lilButton" style="width:66px;height:22px;margin-right:25px"><a ';
	tableString += 'href="javascript:void(0)" onClick="editImg(\'tmpThmb\',0,0);">UPDATE</a>';
	tableString += '</div></td></tr></table></div>Photo Keywords:<br><textarea id="editKws" rows=11 cols=36 ';
	tableString += 'onKeyUp="changeUploadButton(\'savePhotoButton\');">'+temp.kws+'</textarea><br><br>';
	tableString += '<div id="savePhotoButton" class="bigSaveButtons" style="text-align:center;font-size:30px;height:120px;">';
	tableString += '<div style="height:40px;"></div>SAVE PHOTO</div></form></td></tr></table>';	
	createBigPop(945,570,'edit',true);
	$(popHtml).html(tableString);
	$(popHtml).append(closePop);
	$('#savePhotoButton').click(function(){
			var error="";
		temp.title = $('#editTitle').val();temp.kws = $('#editKws').val();
		if(temp.src == ""){error = "No Image Selected"}
		else if(temp.title ==""){error = "No Photo Title Provided"}
											
if(error != ""){$('#editError').html('<b>Save Failed : </b><br>' + error);
$('#savePhotoButton').css({'background-color':'#fafafa','border':'1px solid #ccc','color':'#999','cursor':'default'});ok2Save = false;return;}
						if(id=='newPhoto')
								{
									var newId='new'+(phArr.length-6);								
				phArr.push(new pPhoto(newId,temp.src,temp.dims,temp.title,temp.kws,'prPh'+newId,temp.thmb,"jpg",16));									
									$('#popUPedit').fadeOut("fast",function(){$('#popUPedit').remove();});	
var newDivHtml = '<table><tr><td width="120px"><div class="showImg" style="width:100px;height:70px"><img src="'+temp.src+'" width="100px" id="img'+newId+'"></div></td><td width="216"><div class="apPhotoTxt"><b><span id="title'+newId+'">'+temp.title+'</span></b><br><span id="kws'+newId+'">'+temp.kws+'</span></div></td></td><td width="40px"><div class="editPhotoBtn" id="edit'+newId+'" title="Edit"></div></td><td><div class="dBtn" id="eapPhoto'+newId+'" title="Delete" onclick="deletePhoto('+newId+');"></div></td></tr></table>';
								$.fn.dragSort.extAdd(newDivHtml);
								$('#edit'+newId).click(function(){editProjectPhoto(newId);});}
								else
								{								
									if(temp.title != cp.title){temp.changed = temp.changed | 4;
									$('#title'+id).html(temp.title);}								
									if(temp.kws != cp.kws){temp.changed = temp.changed | 2;
									$('#kws'+id).html(temp.kws);}
									if(temp.src != cp.src){temp.changed = temp.changed | 8;
									$('#img'+id).attr('src',temp.src);}
									if(cp.thmb != phArr[1].src){temp.changed = temp.changed | 1; temp.thmb = phArr[1].src; }	
									changeUploadButton('saveProjButton');
							
									phArr[idx].src = temp.src;	
									phArr[idx].title = temp.title;
									phArr[idx].kws = temp.kws;
									phArr[idx].thmb = temp.thmb;
									if(phArr[idx].changed != 16){phArr[idx].changed = temp.changed;}
		
									$('#popUPedits').fadeOut("fast",function(){$('#popUPedits').remove();});						
								}

								});
		$('#closePopedit').click(function(){ $('#popUPedit').fadeOut("fast",function(){$('#popUPedit').remove();}); });
};

function deletePhoto(id)
{
	if(phArr[findPhoto(id)].changed==16)
	{
		phArr[findPhoto(id)].changed=0;
	}
	else
	{
		phArr[findPhoto(id)].changed='d';
	}
}

function createBigPop(thisW,thisH,name,moveWith)
{
	var currentTop = $(document).scrollTop()+20;
	var center = $(window).width();
	center = (center - thisW)/2;	
    $(window).scroll(function (){if(moveWith){var newTop = $(document).scrollTop(); $(backdrop).css({'top':newTop});}});	
	backdrop = document.createElement('div');
	var bHeight = $(document).height();
	$(backdrop).css({'position':'absolute','top':0,'left':0,'width':'100%','height':bHeight,'z-index':900,
				   'overflow':'hidden','background-image':'url(../graphics/editBG.png)'});
	innerHtml = document.createElement('div');
	$(innerHtml).css({'position':'absolute','top':currentTop,'left':center,'width':thisW,'height':thisH,'z-index':901,
				   'background-color':'#f4f4f4','border':'1px solid #ccc'});	
	popHtml = document.createElement('div');
	$(popHtml).addClass('absContainer');
	$(popHtml).attr('id','popH'+name);
	$('body').append(backdrop);	
	$(backdrop).append(innerHtml);	
	$(backdrop).attr('id','popUP'+name);
	$(innerHtml).append(popHtml);
	closePop = document.createElement('div');
	$(closePop).addClass('dBtn');
	$(closePop).attr('id','closePop'+name);
	$(closePop).css({'position':'absolute','right':-10,'top':-10});	
	$(closePop).mouseenter(function() {$(this).css('backgroundPosition', '0px 92px');})
   			  .mouseleave(function(){$(this).css('backgroundPosition', '0px 122px');});
}

function addPeople(type,id,name)
{
	var newPpl=[type,id,name,'checked'];
	allPeople.push(newPpl);
	for(i=0;i<7;i++){
		if(projLists[i][0]==name){projLists[i][2]=id+','+projLists[i][2];projLists[i][1]=1; break;}}
	$.fn.addPeoplePROJ.extRefresh(id);
}


function resizeList(id,newH)
{
	var oldH = $('#id').height();
	$('#'+id).height(newH);
	if(oldH < newH)
	{		
	refreshFrameHeight(newH-oldH);
	}

}


function addNewString(str,name)
{	
	for(i=0;i<7;i++){if(projLists[i][0]==name){projLists[i][2]=str;projLists[i][1]=1; break;}}
	for(i=0;i<allPeople.length;i++)
	{
		if(name == allPeople[i][0])
		{	
			var chkString = ','+str+',';
			var chkId = ','+allPeople[i][1]+',';
			if(chkString.indexOf(chkId)!=-1)
			{					
				allPeople[i][3]='checked';
			}
			else
			{
				allPeople[i][3]='';
			}
		}
	}
	changeUploadButton('saveProjButton');
}





(function( $ ){

$.fn.addPeoplePROJ= function(){	
	var newHeight;
	var which;
	clearAddForm();
	createPeopleCheck();
	$(this).css({width:302,'overflow':'hidden','position':'absolute'});
	$('.title').css({'font-size':'36px','color':'#999','text-transform':'lowercase','letter-spacing':'-2','font-weight':'bolder'});	
	$('.addPeople').css({'background-color':'#f7f7f7','border':'1px dotted #bbb','position':'absolute',top:0,left:0,width:300});	
	$('.txt').css({'font-family':'Arial Narrow','font-size':'13px','font-weight':'bold','color':'#555','text-transform':'uppercase'});

	$('#addNewPerson').click(function(){$(addNew).animate({top:0});});
	$('#cancelAdd').click(function(){ $('#addNew').animate({top:(-1*newHeight)});clearAddForm()});
	$('#saveNew').click(function(){
					var name = $('#personName').val();					
					if(name=="")
					{						
						$('#pplError').html('<u>ADD FAILED:</u> '+which+' Name Required');
						return;
					}
						
					for(i=0;i<allPeople.length;i++)
					{
						if(name.toLowerCase() == allPeople[i][2].toLowerCase())
						{							
							if(which == allPeople[i][0])
							{
							$('#pplError').html('<u>ADD FAILED:</u> '+which+' <strong> '+name+' </strong> already exists');
							return;
							}							
						}
					}
					name =  encodeQ(name);
					var website = '~,'+ encodeQ($('#personWebsite').val());
					var phone = '~,'+ encodeQ($('#personPhone').val());
					var txt = '~,'+ encodeQ($('#personText').val());
					var ind = '~,'+ encodeQ($('#personInd').val());
					$('#'+which).attr('src',baseFrameSrc+which+'-'+newOrderString(-1,'r')+'&add='+name+website+phone+txt+ind); 
					clearAddForm();					
					});
	

$('#doneAdding').click(function(){ 
								
								var ppls = newOrderString(-1,'r');
								if(ppls.length<1){$('#show'+which).css('visibility','hidden');}
								else{$('#show'+which).css('visibility','visible');}
									$('#addPeople').css('visibility','hidden'); 
									$('#'+which).attr('src',baseFrameSrc+which+'-'+ppls);									
									})
$('.addButton2').click(function(e){
								reloadWhich($(this).attr('id').substring(3));
								var atT = e.pageY - ($('#addExisting').height()/2);
								var atL = e.pageX -  $('#addExisting').width()-15;
								$('#addPeople').css({top:atT,left:atL,'visibility':'visible'});	
								newPpl = [which,-1,name,'checked'];	});

function canSave() { ok2Save=true;
$('#saveProjButton').css({'background-color': '#c7dcd3','borderTop':'1px solid #ecf9fe','borderLeft':'1px solid #ecf9fe','borderBottom':'1px solid #88baa3','borderRight':'1px solid #88baa3','color':'#444','cursor':'pointer'});
}
	
function newOrderString(chk,act)
{
	for(i=0;i<7;i++)
	{
		if(projLists[i][0]==which)
		{
			var str=projLists[i][2];
			if(act=='s'){projLists[i][3]=chk; projLists[i][1]=1; return;}				
			
			if(act=='r'){ return cleanString(str);}
			else 
			{				
				var tString = ','+str + ',';
				var findChk = ','+chk+',';
				
				if(tString.indexOf(findChk) != -1)
				{	
					if((act=='d'))
						{
							str = (','+tString).replace(','+chk+',',',');
						}
				}
				else
				{
					if((act=='a'))
						{
							str += chk+',';
						}
				}
					projLists[i][1]=1;
					projLists[i][2]=str;
					canSave();				
			}
		  
		break;
		}
 	 }
}


function reloadWhich(id){which = id.toLowerCase();createPeopleCheck();
$('#tExist').html('ADD '+which+'S');$('#tAdd').html('Add New '+which);$('#tNEW').html('Add New '+which);}


function createPeopleCheck()
{
	var chkBoxString ="";
	newHeight=302;
	var totalP = 0;
	for(i=0;i<allPeople.length;i++)
	{
		if(which == allPeople[i][0])
		{
			if((which=='photographer')||(which=='real_estate_agent')){$('.shPhInd').css({'display':'block'});}
			else{$('.shPhInd').css({'display':'none'});}
			chkBoxString += '<tr><td height="26px" width="40px"><input type="checkbox" class="peopleCHK" value="'+allPeople[i][1];
			chkBoxString += '" '+allPeople[i][3]+'/></td><td> '+allPeople[i][2]+'</td></tr>';
			if(totalP>4){newHeight+=26;}
			totalP++;
		}
	}
	$('#addPeople').height(newHeight);
	$('.frmtPpl').css({height:newHeight-6,width:296});
	$(addNew).css({top:-(newHeight-2),height:(newHeight-2)});
	$('#chk').html(chkBoxString);
	$('#chk input').click(function(){ 
		var chk=$(this).attr('value');
		for(i=0;i<allPeople.length;i++)
			{
				if(allPeople[i][1] == chk)
				{			
					if($(this).is(':checked'))
						{	
							allPeople[i][3]='checked';	
							newOrderString(chk,'a');
							break;
						}
						else
						{
							allPeople[i][3]='';	
							newOrderString(chk,'d');	
							break;
						}
				}
			}

			}); 

}
$('#showTeam').click(function(){if($(this).is(':checked')){	newOrderString(1,'s');}	else{newOrderString(0,'s');}});


function clearAddForm()
	{
		$('#personName').val("");
		$('#personWebsite').val("");
		$('#personPhone').val("");
		$('#personText').val("");
	}
function cleanString(cleanStr)
{while(cleanStr.indexOf(',,')!= -1){cleanStr = cleanStr.replace(',,',',');}if(cleanStr[0] == ','){	cleanStr = cleanStr.substr(1);}	
var end = cleanStr.length - 1;if(cleanStr[end]==','){ cleanStr = cleanStr.substr(0,end);}return cleanStr;}

$.fn.addPeoplePROJ.extRefresh= function(id) {
			newOrderString(id,'a');
                createPeopleCheck();
            }
}




$.fn.dragSort= function( options )  {
var settings = $.extend({'name' : 'list','isFrame' : false,'margin':5 ,'iClass':'item','dH':100,'dW':200}, options);
var newSpecs=options;
var name = newSpecs.name;
var iClass = newSpecs.iClass;
var bgColor =  $('.'+iClass).css('background-color');
var isFrame = newSpecs.isFrame;
var nSize = name.length;
var dNum=0;
var dW = parseInt(newSpecs.dW);
var dH = parseInt(newSpecs.dH);
var containerId = '#'+ $(this).attr('id');
var hm = newSpecs.margin;
var dDif = hm+dH;
var dPos = new Array();
var dMap = new Array();
var startZ = 700;

$(this).children('div').each(function(i) {
		$(this).addClass(iClass);
		$(this).attr("id","d"+name+i);
		$(this).css({'position':'absolute',right:0,top:((dDif*i)+hm),'z-index':(startZ+i)});
		dPos[i]=[(dDif*i)+hm,i,i];
		dMap[i]=[(dDif*i)+hm,i];	
		dNum++;
		$(this).find('.dBtn').attr('id', 'e'+name+i);	
		 });
		currentDNum = dNum;

	var cH = dNum * (dH+hm)+hm;	
	var lastZ = 700+dNum+2;	
	var zones = ((dNum*5)+1);
	var g2 = cH/(dNum);
	var gu = cH/zones;
	var gZone = gu*2;
	
	$(containerId).css({'height':cH,'width':dW});
	
	if(isFrame)
	{
		$(this).css({'background-image':'url(../graphics/stripedBG.png)'});
		parent.resizeList(name,cH);
	}
	

	glowZone = document.createElement('div');
	$(glowZone).css({height:gZone,width:dW,'position':'absolute','z-index':startZ-dNum,'background-color':'#3CC','visibility':'hidden'});
	$(this).append(glowZone);		
	

var activeControl = "NONE";
var idx;
var clickPosY;
var lastY;
var dir;
var oChged = false;
$('.'+iClass).mousedown(function(e){dir = 0;activeControl = "div";clickPosY = e.pageY;lastY = e.pageY;idx = $(this).attr('id').substring(nSize+1);})
			.mouseup(function(){activeControl = 'NONE'; snapTo();});

$('html').mouseup(function(){if(activeControl == 'div'){snapTo();}
					$('.glowZone').css('visibility','hidden');
					activeControl = 'NONE';});
$(this).mouseleave(function(){if(activeControl == 'div'){snapTo();} activeControl = 'NONE';});
$(document).mousemove(function(e){y = e.pageY;if(activeControl == 'div'){moveDiv(e.pageY);}});
	
function moveDiv(y)
{	
 $('#d'+name+idx).css({'background-color':'#d7d7d7', 'borderTop':'1px dotted #666','borderBottom':'1px dotted #666'});
	var ogH = parseInt(dPos[idx][0]);	
	var newH = ogH +(y-clickPosY);
	var diffY = y-lastY;	
	if((newH>0)&&(newH<(cH-dH)))
	{	
		var zone = parseInt((newH+(3*gu))/g2);		
		glowZones(newH,diffY);
		dPos[idx][1]=zone;
		$('#d'+name+idx).css({'top':newH,'z-index':lastZ});	
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
	var newZ = dPos[idx][1]; 
	var newZ2 = newZ+1;
	var newH = dMap[newZ][0];
	var oldZ = dPos[idx][2];	
	if(newZ != oldZ)
	{
		nudgeRest(newZ,oldZ);
		dPos[idx][0]=newH;
		dPos[idx][1]=newZ;
		dPos[idx][2]=newZ;	
		$('#d'+name+idx).css({'top':newH,'z-index':startZ});
		dMap[newZ][1] = idx;
	}
	else
	{
		$('#d'+name+idx).css({'top':newH,'z-index':startZ});
		$('#d'+name+idx).css({'background-color':bgColor, 'borderTop':'1px dotted #bbb','borderBottom':'1px dotted #bbb'});
	}
	createOrderString();
}
$('.dBtn').click(function(){deleteMe($(this).attr('id').substring(nSize+1));});
$.fn.dragSort.extAdd= function(divHtml){
	if(activeControl == 'div'){snapTo(); activeControl = 'NONE';}
	var newId = dPos.length;
	newItem = document.createElement('div');
	$(newItem).addClass(iClass);
	$(newItem).attr("id","d"+name+newId);
	$(newItem).attr("title","new"+newId);
	$(newItem).css({'position':'absolute',right:0,top:(hm),'z-index':(startZ+newId)});
	currentDNum++;	
	dMap[newId]=[(dDif*newId)+hm,newId];
	nudgeRest(0,newId);
	dPos[newId]=[hm,0,0];
	dMap[0][1]=newId;
	$(newItem).html('NEW DIV');
	$(containerId).append(newItem);	
	$(newItem).html(divHtml);
	cH += (dH+hm);
	$(containerId).height(cH);
	$("#d"+name+newId).mousedown(function(e){ 
								  dir = 0;
								  activeControl = "div";
								  clickPosY = e.pageY;
								  lastY = e.pageY;
								  idx = newId;})

			.mouseup(function(){activeControl = 'NONE'; snapTo();});
	$(newItem).find('.dBtn').click(function(){if(activeControl == 'div'){snapTo();}activeControl = 'NONE'; 
											deleteMe(newId);});
	$(newItem).find('.eBtn').click(function(){if(activeControl == 'div'){snapTo();}activeControl = 'NONE'; 
											parent.showProjPU(currentCat,$(this).attr('title'));});
	createOrderString();}
function deleteMe(id)
{	
	currentDNum = currentDNum - 1;
	var deleteIdx = dPos[id][1];
	 dPos[deleteIdx][2] = -1;
	 if(currentDNum >0)
	 {
	 nudgeRest(currentDNum,deleteIdx);
	 }
	$('#d'+name+id).hide();
	$('#d'+name+id).remove();	
	 cH -=(dH+hm);
	 $(containerId).height(cH);
	 if(isFrame)
	 {
	 	parent.resizeList(name,cH);
	 }
	 createOrderString();
}
function nudgeRest(newZ,oldZ)
{
	if(newZ < oldZ)
	{
		for(i=oldZ;i>newZ;i--)
		{	
			var dM = dMap[i-1][1];
			var point = i-1;
			if(i <= (dMap.length-1))
			{
				dMap[i][1]=dM;
				dPos[dM][0] = dMap[i][0];
				dPos[dM][1] = i;
				dPos[dM][2] = i;
			$('#d'+name+dM).animate({top:dMap[i][0]}, 200, function() {
			 $('#d'+name+idx).css({'background-color':bgColor, 'borderTop':'1px dotted #bbb','borderBottom':'1px dotted #bbb'});});	
			}		
		}
		oChged = true;
	}
	else if(newZ > oldZ)
	{		
		for(i=oldZ;i<newZ;i++)
		{
			var dM = dMap[i+1][1];	
			dMap[i][1]=dM;
			dPos[dM][0] = dMap[i][0];
			dPos[dM][1] = i;
			dPos[dM][2] = i;
			$('#d'+name+dM).animate({top:dMap[i][0]}, 200, function() {
			 $('#d'+name+idx).css({'background-color':bgColor, 'borderTop':'1px dotted #bbb','borderBottom':'1px dotted #bbb'});});		
		oChged = true;	
		}
	}	
	else
	{
	}
}
function createOrderString()
{
	var str="";
	for(i=0;i<currentDNum;i++)
	{
		str += $('#d'+name+dMap[i][1]).attr('title')+',';		
	}
	if(isFrame)
	 {
	 	parent.addFromFrame(str,name);
	 }
	else if(currentProj != null)
	{
		if(oChged)
		{
			$('#saveProjButton').css({'background-color':'#88c6aa','border':'1px solid #666','color':'#444','cursor':'pointer'});
			$('#savePgCButton').css({'background-color':'#88c6aa','border':'1px solid #666','color':'#444','cursor':'pointer'});
			ok2Save = true;
			newOrderStr = str;	
		}
	}
}

};


$.fn.editTextBox = function(options){
	var iIs = "";
	$('.editTextBtn').click(function(){
		$('#editTTextInner').css('visibility','visible');
		iIs ='#' + $(this).attr('id').replace('edit','show');
		hsID =$(this).attr('id').replace('edit','');
		$('#editTTitle').val($(iIs + 'T').html());
		$('#editTText').val($(iIs).html());		
});
$('#editTTitle').keyup(function() {
    $(iIs + 'T').html($(this).val()); 
	changeUploadButton('saveTeamButton');
});
$('#editTText').keyup(function() {
    $(iIs).html($(this).val()); 
	changeUploadButton('saveTeamButton');
});
	
}



})( jQuery );