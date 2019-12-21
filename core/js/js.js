!function(global){"use strict";function keydown(e){var id,k=e?e.keyCode:event.keyCode;if(!held[k]){held[k]=!0;for(id in sequences)sequences[id].keydown(k)}}function keyup(e){var k=e?e.keyCode:event.keyCode;held[k]=!1}function resetHeldKeys(){var k;for(k in held)held[k]=!1}function on(obj,type,fn){obj.addEventListener?obj.addEventListener(type,fn,!1):obj.attachEvent&&(obj["e"+type+fn]=fn,obj[type+fn]=function(){obj["e"+type+fn](window.event)},obj.attachEvent("on"+type,obj[type+fn]))}var cheet,Sequence,sequences={},keys={backspace:8,tab:9,enter:13,"return":13,shift:16,"⇧":16,control:17,ctrl:17,"⌃":17,alt:18,option:18,"⌥":18,pause:19,capslock:20,esc:27,space:32,pageup:33,pagedown:34,end:35,home:36,left:37,L:37,"←":37,up:38,U:38,"↑":38,right:39,R:39,"→":39,down:40,D:40,"↓":40,insert:45,"delete":46,0:48,1:49,2:50,3:51,4:52,5:53,6:54,7:55,8:56,9:57,a:65,b:66,c:67,d:68,e:69,f:70,g:71,h:72,i:73,j:74,k:75,l:76,m:77,n:78,o:79,p:80,q:81,r:82,s:83,t:84,u:85,v:86,w:87,x:88,y:89,z:90,"⌘":91,command:91,kp_0:96,kp_1:97,kp_2:98,kp_3:99,kp_4:100,kp_5:101,kp_6:102,kp_7:103,kp_8:104,kp_9:105,kp_multiply:106,kp_plus:107,kp_minus:109,kp_decimal:110,kp_divide:111,f1:112,f2:113,f3:114,f4:115,f5:116,f6:117,f7:118,f8:119,f9:120,f10:121,f11:122,f12:123,equal:187,"=":187,comma:188,",":188,minus:189,"-":189,period:190,".":190},NOOP=function(){},held={};Sequence=function(str,next,fail,done){var i;for(this.str=str,this.next=next?next:NOOP,this.fail=fail?fail:NOOP,this.done=done?done:NOOP,this.seq=str.split(" "),this.keys=[],i=0;i<this.seq.length;++i)this.keys.push(keys[this.seq[i]]);this.idx=0},Sequence.prototype.keydown=function(keyCode){var i=this.idx;return keyCode!==this.keys[i]?void(i>0&&(this.reset(),this.fail(this.str),cheet.__fail(this.str))):(this.next(this.str,this.seq[i],i,this.seq),cheet.__next(this.str,this.seq[i],i,this.seq),void(++this.idx===this.keys.length&&(this.done(this.str),cheet.__done(this.str),this.reset())))},Sequence.prototype.reset=function(){this.idx=0},cheet=function(str,handlers){var next,fail,done;"function"==typeof handlers?done=handlers:null!==handlers&&void 0!==handlers&&(next=handlers.next,fail=handlers.fail,done=handlers.done),sequences[str]=new Sequence(str,next,fail,done)},cheet.disable=function(str){delete sequences[str]},on(window,"keydown",keydown),on(window,"keyup",keyup),on(window,"blur",resetHeldKeys),on(window,"focus",resetHeldKeys),cheet.__next=NOOP,cheet.next=function(fn){cheet.__next=null===fn?NOOP:fn},cheet.__fail=NOOP,cheet.fail=function(fn){cheet.__fail=null===fn?NOOP:fn},cheet.__done=NOOP,cheet.done=function(fn){cheet.__done=null===fn?NOOP:fn},cheet.reset=function(id){var seq=sequences[id];return seq instanceof Sequence?void seq.reset():void console.warn("cheet: Unknown sequence: "+id)},global.cheet=cheet,"function"==typeof define&&define.amd?define([],function(){return cheet}):"undefined"!=typeof module&&null!==module&&(module.exports=cheet)}(this);
cheet('a s t i n k y o x',function(){var r=Math.floor(Math.random()*(3-1+1))+1;if(r==1){if($(".llama").length<5){$('body').addClass('amc');$('<div class="llama"></div>').appendTo('body').delay(30000).queue(function(){$(this).remove();if($('.llama').length==0&&$('.camel').length==0&&$('.flymo').length==0)$('body').removeClass('amc');});}else r=2;}if(r==2){if($(".camel").length<5){$('body').addClass('amc');$('<div class="camel"></div>').appendTo('body').delay(30000).queue(function(){$(this).remove();if($('.llama').length==0&&$('.camel').length==0&&$('.flymo').length==0)$('body').removeClass('amc');});}else r=3;}if(r==3){if($(".flymo").length<1){$('body').addClass('amc');$('<div class="flymo"><audio id="flymo" src="core/images/flymo.ogg" autoplay loop hidden volume="0.25"></audio></div>').appendTo('body').delay(35000).queue(function(){$(this).remove();if($('.llama').length==0&&$('.camel').length==0&&$('.flymo').length==0)$('body').removeClass('amc');});var audio=document.getElementById("flymo");audio.volume=.1;}}});
$('[data-tooltip="tooltip"]').tooltip();
$('#panel-rst').submit(function(){
  $('#rstbusy').html('<i class="libre libre-spinner-1"></i>');
  $.ajax({
    data:$(this).serialize(),
    type:$(this).attr('method'),
    url:$(this).attr('action'),
    success:function(response){
      $('#rstfeedback').html(response);
      $('#rstbusy').html('<i class="libre libre-envelope"></i>');
    }
  });
  return false;
});
function update(id,t,c,da){
	if(t=='comments'){
		if(c=='status'){
			$('#approve_'+id).remove();
		}
		if(da=='approved'){
			$('#l_'+id).removeClass('danger');
		}
	}else{
		if(t=='media'){
//        			$('#mediab'+c).before(busy);
		}else{
//        			$('#'+c).before(busy);
		}
	}
	$.ajax({
		type:"GET",
		url:"core/update.php",
		data:{
			id:id,
			t:t,
			c:c,
			da:da
		}
	}).done(function(msg){
		if(t=='login'){
			if(c=='layoutAccounts'||c=='layoutContent'){
				$('#listtype').removeClass('list card table').addClass(da);
			}
			if(c=='rank'){
				if(da>-1&&da<400){
					$.ajax({
						type:"GET",
						url:"core/update.php",
						data:{
							id:id,
							t:t,
							c:'options',
							da:'000000000000000000000000000000000'
						}
					}).done(function(msg){
						$('#options0,#options1,#options2,#options3,#options4,#options5,#options6,#options7,#options8').attr('checked',false);
					});
				}
				if(da==400||da==500){
					$.ajax({
						type:"GET",
						url:"core/update.php",
						data:{
							id:id,
							t:t,
							c:'options',
							da:'110000000000000000000000000000000'
						}
					}).done(function(msg){
						$('#options0,#options1').attr('checked',true);
						$('#options2,#options3,#options4,#options5,#options6,#options7,#options8').attr('checked',false);
					});
				}
				if(da==600){
					$.ajax({
						type:"GET",
						url:"core/update.php",
						data:{
							id:id,
							t:t,
							c:'options',
							da:'110000100000000000000000000000000'
						}
					}).done(function(msg){
						$('#options0,#options1,#options6').attr('checked',true);
						$('#options2,#options3,#options4,#options5,#options7,#options8').attr('checked',false);
					});
				}
				if(da==700||da==800||da==900){
					$.ajax({
						type:"GET",
						url:"core/update.php",
						data:{
							id:id,
							t:t,
							c:'options',
							da:'111111110000000000000000000000000'
						}
					}).done(function(msg){
						$('#options0,#options1,#options2,#options3,#options4,#options5,#options6,#options7').attr('checked',true);
						$('#options8').attr('checked',false);
					});
				}
				if(da==1000){
					$.ajax({
						type:"GET",
						url:"core/update.php",
						data:{
							id:id,
							t:t,
							c:'options',
							da:'111111110000000000000000000000000'
						}
					}).done(function(msg){
						$('#options0,#options1,#options2,#options3,#options4,#options5,#options6,#options7,#options8').attr('checked',true);
					});
				}
			}
		}
		if(t=='config'&&c=='language'){
			location.reload();
		}
		if(t=='messages'){
			if(c=='folder'){
				$('#l_'+id).addClass('animated zoomOut');
				setTimeout(function(){$('#l_'+id).remove();},500);
				$('[data-tooltip="tooltip"], .tooltip').tooltip('hide');
			}
		}
		if(t!='comments'){
			if(t=='menu'){
				$('#'+c+'save').remove();
			}else{
				$('#'+c+'save').remove();
			}
			if(t=='media'){
				$('#mediab'+c).remove();
			}else{
//				$('#'+c).remove();
			}
		}
		if(t=='content'&&c=='contentType'){
			$('[id^=d]').removeClass('d-none');
			var els='';
			if(da=='article')els='#d5,#d7,#d8,#d9,#d10,#d11,#d12,#d13,#d14,#d15,#d16,#d19,#d20,#d21,#d26t,#d54,#d060,#d60';
			if(da=='portfolio')els='#d6,#d7,#d8,#d9,#d10,#d11,#d12,#d13,#d19,#d20,#d21,#d22,#d24,#d26t,#d53,#d54,#d060,#d60';
			if(da=='events')els='#d5,#d6,#d7,#d8,#d9,#d10,#d21,#d22,#d24,#d26t,#d53,#d060,#d60';
			if(da=='news')els='#d5,#d7,#d8,#d9,#d10,#d11,#d12,#d13,#d14,#d15,#d16,#d19,#d20,#d21,#d22,#d24,#d26t,#d54,#d060,#d60';
			if(da=='testimonials')els='#d6,#d7,#d8,#d9,#d10,#d11,#d12,#d17,#d18,#d19,#d20,#d21,#d22,#d24,#d26nt,#d043,#d43,#d53,#d54,#d060,#d60';
			if(da=='inventory')els='#d5,#d6,#d11,#d12,#d13,#d14,#d15,#d16,#d24,#d26t,#d043,#d43,#d54';
			if(da=='service')els='#d5,#d6,#d9,#d10,#d11,#d12,#d13,#d14,#d15,#d16,#d21,#d24,#d26t,#d043,#d43';
			if(da=='gallery')els='#d5,#d7,#d8,#d9,#d10,#d11,#d12,#d13,#d14,#d15,#d16,#d19,#d20,#d21,#d24,#d26t,#d043,#d43,#d54,#d060,#d60';
			if(da=='proofs')els='#d3,#d7,#d8,#d9,#d10,#d11,#d12,#d19,#d20,#d21,#d22,#d24,#d26t,#d46,#d47,#d53,#d54,#d060,#d60';
			$(els).addClass('d-none');
		}
		$('.page-block').removeClass('d-none');
	})
}
function toggleCalendar(){
	$('#calendar-view,#table-view').toggleClass('d-none');
	$('.i-calendar,.i-table').toggleClass('d-none');
	if(!$('#calendar-view').hasClass('d-none')){
		Cookies.set('bookingview','calendar',{expires:14});
		$('#calendar').fullCalendar('render');
	}else{
		Cookies.set('bookingview','table',{expires:14});
	}
	return false;
}
function updateButtons(id,t,c,da){
	$('#sp').load('core/update.php?id='+id+'&t='+t+'&c='+c+'&da='+escape(da));
}
function restore(id){
	$.ajax({
		type:"GET",
		url:"core/restore.php",
		data:{
			id:id,
		}
	}).done(function(msg){
		$('#sp').html(msg);
	});
}
function more(t,c,b){
	$.ajax({
		type:"GET",
		url:"core/more_"+t+".php",
		data:{
			t:t,
			c:c,
      b:b
		}
	}).done(function(msg){
		if(msg=='nomore'){
			$('#more_'+c).remove();
		}else{
			$('#more_'+c).remove();
			$('#l_tracker').append(msg);
		}
		$('[data-tooltip="tooltip"], .tooltip').tooltip('hide');
	});
}
function purge(id,t,c){
	if(t=='clearip'){
		var f='clearip';
	}else{
		var f='purge';
	}
	$.ajax({
		type:"GET",
		url:"core/"+f+".php",
		data:{
			id:id,
			t:t,
			c:c
		}
	}).done(function(msg){
		if(t=='clearip'){
			$('[data-ip="'+id+'"]').addClass('animated zoomOut');
			setTimeout(function(){$('[data-ip="'+id+'"]').remove();},500);
		}else if(t=='iplist'||t=='logs'&&id==0){
			$('#l_'+t).addClass('animated zoomOut');
			setTimeout(function(){$('#l_'+t).remove();},500);
		}else if(t=='media'){
			$('#mi_'+id).addClass('animated zoomOut');
			setTimeout(function(){$('#mi_'+id).remove();},500);
		}else if(id==0&&t=='tracker'){
			$('#l_'+t).addClass('animated zoomOut');
			setTimeout(function(){$('#l_'+t).remove();},500);
		}else{
			$('#l_'+id).addClass('animated zoomOut');
			setTimeout(function(){$('#l_'+id).remove();},500);
		}
		$('[data-tooltip="tooltip"], .tooltip').tooltip('hide');
	});
}
function suggest(id){
	$.ajax({
		type:"GET",
		url:"core/suggest.php",
		data:{
			id:id
		}
	}).done(function(msg){
		$('#sp').html(msg);
	})
}
function coverUpdate(id,t,c,da){
	var imgsrc=$('#cover').attr('val');
	$.ajax({
		type:"GET",
		url:"core/update.php",
		data:{
			id:id,
			t:t,
			c:c,
			da:da
		}
	}).done(function(msg){
		if(da==''){
			$('#'+c).val('');
			$('#'+c+'image').attr('src','core/images/noimage.png');
		}else{
			if(imgsrc==''){
				$('#'+c+'image').attr('src',da);
			}
		}
	})
}
function imageUpdate(id,t,c,da){
	$.ajax({
		type:"GET",
		url:"core/update.php",
		data:{
			id:id,
			t:t,
			c:c,
			da:da
		}
	}).done(function(msg){
		if(t=='login'&&c=='avatar'&&da==''){
			$('.img-avatar').attr('src','core/images/i-noavatar.svg');
		}else{
			if(da==''){
				$('#'+c).html('');
			}else{
				$('#'+c).html('<img src="media/'+da+'">');
			}
		}
	})
}
function insertAtCaret(aId,t) {
	var ta=document.getElementById(aId);
	var sP=ta.scrollTop;
	var cP=ta.selectionStart;
	var f=(ta.value).substring(0,cP);
	var b=(ta.value).substring(ta.selectionEnd,ta.value.length);
	ta.value=f+t+b;
	cP=cP+t.length;
	ta.selectionStart=cP;
	ta.selectionEnd=cP;
	ta.focus();
	ta.scrollTop=sP;
}
function removeStopWords(id,txt){
//	$('.page-block').addClass('d-block');
	var x;
	var y;
	var word;
	var stop_word;
	var regex_str;
	var regex;
	var cleansed_string=txt;
	var stop_words=new Array('a','about','above','across','after','again','against','all','almost','alone','along','already','also','although','always','among','an','and','another','any','anybody','anyone','anything','anywhere','are','area','areas','around','as','ask','asked','asking','asks','at','away','b','back','backed','backing','backs','be','became','because','become','becomes','been','before','began','behind','being','beings','best','better','between','big','both','but','by','c','came','can','cannot','case','cases','certain','certainly','clear','clearly','come','could','d','did','differ','different','differently','do','does','done','down','down','downed','downing','downs','during','e','each','early','either','end','ended','ending','ends','enough','even','evenly','ever','every','everybody','everyone','everything','everywhere','f','face','faces','fact','facts','far','felt','few','find','finds','first','for','four','from','full','fully','further','furthered','furthering','furthers','g','gave','general','generally','get','gets','give','given','gives','go','going','good','goods','got','great','greater','greatest','group','grouped','grouping','groups','h','had','has','have','having','he','her','here','herself','high','high','high','higher','highest','him','himself','his','how','however','i','if','important','in','interest','interested','interesting','interests','into','is','it','its','itself','j','just','k','keep','keeps','kind','knew','know','known','knows','l','large','largely','last','later','latest','least','less','let','lets','like','likely','long','longer','longest','m','made','make','making','man','many','may','me','member','members','men','might','more','most','mostly','mr','mrs','much','must','my','myself','n','necessary','need','needed','needing','needs','never','new','new','newer','newest','next','no','nobody','non','noone','not','nothing','now','nowhere','number','numbers','o','of','off','often','old','older','oldest','on','once','one','only','open','opened','opening','opens','or','order','ordered','ordering','orders','other','others','our','out','over','p','part','parted','parting','parts','per','perhaps','place','places','point','pointed','pointing','points','possible','present','presented','presenting','presents','problem','problems','put','puts','q','quite','r','rather','really','right','right','room','rooms','s','said','same','saw','say','says','second','seconds','see','seem','seemed','seeming','seems','sees','several','shall','she','should','show','showed','showing','shows','side','sides','since','small','smaller','smallest','so','some','somebody','someone','something','somewhere','state','states','still','still','such','sure','t','take','taken','than','that','the','their','them','then','there','therefore','these','they','thing','things','think','thinks','this','those','though','thought','thoughts','three','through','thus','to','today','together','too','took','toward','turn','turned','turning','turns','two','u','under','until','up','upon','us','use','used','uses','v','very','w','want','wanted','wanting','wants','was','way','ways','we','well','wells','went','were','what','when','where','whether','which','while','who','whole','whose','why','will','with','within','without','work','worked','working','works','would','x','y','year','years','yet','you','young','younger','youngest','your','yours','z');
	words=cleansed_string.match(/[^\s]+|\s+[^\s+]$/g);
	for(x=0;x<words.length;x++){
		for(y=0;y<stop_words.length;y++){
			word=words[x].replace(/\s+|[^a-z]+/ig,"");
			stop_word=stop_words[y];
			if(word.toLowerCase()==stop_word){
				regex_str="^\\s*"+stop_word+"\\s*$";
				regex_str+="|^\\s*"+stop_word+"\\s+";
				regex_str+="|\\s+"+stop_word+"\\s*$";
				regex_str+="|\\s+"+stop_word+"\\s+";
				regex=new RegExp(regex_str, "ig");
				cleansed_string=cleansed_string.replace(regex," ");
			}
		}
	}
	txt=cleansed_string.replace(/^\s+|\s+$/g,"");
	$('#'+id).val(txt).change();
}
function makeClient(id){
//	$('.page-block').addClass('d-block');
	$('#sp').load('core/add_data.php?id='+id+'&act=make_client');
}
function changeClient(id,oid,w){
	if(w=='booking'){
		$('#sp').load('core/change_bookingClient.php?id='+id+'&bid='+oid);
	}else{
		if(id==0){
			$('#sp').load('core/change_orderClient.php?id='+id+'&oid='+oid);
			$('.oce').attr('readonly','readonly');
			$('.ocesave').addClass('d-none');
			$('.ocehelp').removeClass('d-none');
		}else{
			$('#sp').load('core/change_orderClient.php?id='+id+'&oid='+oid);
			$('.oce').removeAttr('readonly');
			$('.ocesave').removeClass('d-none');
			$('.ocehelp').addClass('d-none');
		}
	}
}
function reload(c){
	location.reload(true);
}
function loadMore(l,is,ie,action,lang){
	$('#more_'+is).html('');
	$.ajax({
		type:"GET",
		url:"core/layout/"+l+".php",
		data:{
			is:is,
			ie:ie,
			action:action,
			l:lang
		}
	}).done(function(msg){
		$('#l_activity').append(msg);
//		$('.page-block').removeClass('d-block');
	})
}
