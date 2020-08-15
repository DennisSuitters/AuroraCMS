!function(global){"use strict";function keydown(e){var id,k=e?e.keyCode:event.keyCode;if(!held[k]){held[k]=!0;for(id in sequences)sequences[id].keydown(k)}}function keyup(e){var k=e?e.keyCode:event.keyCode;held[k]=!1}function resetHeldKeys(){var k;for(k in held)held[k]=!1}function on(obj,type,fn){obj.addEventListener?obj.addEventListener(type,fn,!1):obj.attachEvent&&(obj["e"+type+fn]=fn,obj[type+fn]=function(){obj["e"+type+fn](window.event)},obj.attachEvent("on"+type,obj[type+fn]))}var cheet,Sequence,sequences={},keys={backspace:8,tab:9,enter:13,"return":13,shift:16,"⇧":16,control:17,ctrl:17,"⌃":17,alt:18,option:18,"⌥":18,pause:19,capslock:20,esc:27,space:32,pageup:33,pagedown:34,end:35,home:36,left:37,L:37,"←":37,up:38,U:38,"↑":38,right:39,R:39,"→":39,down:40,D:40,"↓":40,insert:45,"delete":46,0:48,1:49,2:50,3:51,4:52,5:53,6:54,7:55,8:56,9:57,a:65,b:66,c:67,d:68,e:69,f:70,g:71,h:72,i:73,j:74,k:75,l:76,m:77,n:78,o:79,p:80,q:81,r:82,s:83,t:84,u:85,v:86,w:87,x:88,y:89,z:90,"⌘":91,command:91,kp_0:96,kp_1:97,kp_2:98,kp_3:99,kp_4:100,kp_5:101,kp_6:102,kp_7:103,kp_8:104,kp_9:105,kp_multiply:106,kp_plus:107,kp_minus:109,kp_decimal:110,kp_divide:111,f1:112,f2:113,f3:114,f4:115,f5:116,f6:117,f7:118,f8:119,f9:120,f10:121,f11:122,f12:123,equal:187,"=":187,comma:188,",":188,minus:189,"-":189,period:190,".":190},NOOP=function(){},held={};Sequence=function(str,next,fail,done){var i;for(this.str=str,this.next=next?next:NOOP,this.fail=fail?fail:NOOP,this.done=done?done:NOOP,this.seq=str.split(" "),this.keys=[],i=0;i<this.seq.length;++i)this.keys.push(keys[this.seq[i]]);this.idx=0},Sequence.prototype.keydown=function(keyCode){var i=this.idx;return keyCode!==this.keys[i]?void(i>0&&(this.reset(),this.fail(this.str),cheet.__fail(this.str))):(this.next(this.str,this.seq[i],i,this.seq),cheet.__next(this.str,this.seq[i],i,this.seq),void(++this.idx===this.keys.length&&(this.done(this.str),cheet.__done(this.str),this.reset())))},Sequence.prototype.reset=function(){this.idx=0},cheet=function(str,handlers){var next,fail,done;"function"==typeof handlers?done=handlers:null!==handlers&&void 0!==handlers&&(next=handlers.next,fail=handlers.fail,done=handlers.done),sequences[str]=new Sequence(str,next,fail,done)},cheet.disable=function(str){delete sequences[str]},on(window,"keydown",keydown),on(window,"keyup",keyup),on(window,"blur",resetHeldKeys),on(window,"focus",resetHeldKeys),cheet.__next=NOOP,cheet.next=function(fn){cheet.__next=null===fn?NOOP:fn},cheet.__fail=NOOP,cheet.fail=function(fn){cheet.__fail=null===fn?NOOP:fn},cheet.__done=NOOP,cheet.done=function(fn){cheet.__done=null===fn?NOOP:fn},cheet.reset=function(id){var seq=sequences[id];return seq instanceof Sequence?void seq.reset():void console.warn("cheet: Unknown sequence: "+id)},global.cheet=cheet,"function"==typeof define&&define.amd?define([],function(){return cheet}):"undefined"!=typeof module&&null!==module&&(module.exports=cheet)}(this);cheet('↑ ↑ ↓ ↓ ← → ← → b a',function(){if($(".konami").length<1){$('<div class="konami"><div class="loader"><div class="dot"></div><div class="dot"></div><div class="dot"></div><div class="dot"></div><div class="dot"></div></div></div>').appendTo('body');}});cheet('a s t i n k y o x',function(){var r=Math.floor(Math.random()*(3-1+1))+1;if(r==1){if($(".llama").length<5){$('body').addClass('amc');$('<div class="llama"></div>').appendTo('body').delay(30000).queue(function(){$(this).remove();if($('.llama').length==0&&$('.camel').length==0&&$('.flymo').length==0)$('body').removeClass('amc');});}else r=2;}if(r==2){if($(".camel").length<5){$('body').addClass('amc');$('<div class="camel"></div>').appendTo('body').delay(30000).queue(function(){$(this).remove();if($('.llama').length==0&&$('.camel').length==0&&$('.flymo').length==0)$('body').removeClass('amc');});}else r=3;}if(r==3){if($(".flymo").length<1){$('body').addClass('amc');$('<div class="flymo"><audio id="flymo" src="core/images/flymo.ogg" autoplay loop hidden volume="0.25"></audio></div>').appendTo('body').delay(35000).queue(function(){$(this).remove();if($('.llama').length==0&&$('.camel').length==0&&$('.flymo').length==0)$('body').removeClass('amc');});var audio=document.getElementById("flymo");audio.volume=.1;}}});
$('[data-tooltip="tooltip"]').tooltip();
$('#panel-rst').submit(function(){
  $('#rstbusy').html('<i class="i animated infinite spin"><svg role="img" focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14"><path d="m 4.62,11.2 q 0,0.525 -0.371875,0.8925 Q 3.87625,12.46 3.36,12.46 2.835,12.46 2.4675,12.0925 2.1,11.725 2.1,11.2 2.1,10.675 2.4675,10.3075 2.835,9.94 3.36,9.94 3.87625,9.94 4.248125,10.3075 4.62,10.675 4.62,11.2 z m 3.78,1.68 q 0,0.46375 -0.328125,0.791875 Q 7.74375,14 7.28,14 6.81625,14 6.488125,13.671875 6.16,13.34375 6.16,12.88 6.16,12.41625 6.488125,12.088125 6.81625,11.76 7.28,11.76 q 0.46375,0 0.791875,0.328125 Q 8.4,12.41625 8.4,12.88 z M 3.08,7.28 Q 3.08,7.8575 2.66875,8.26875 2.2575,8.68 1.68,8.68 1.1025,8.68 0.69125,8.26875 0.28,7.8575 0.28,7.28 0.28,6.7025 0.69125,6.29125 1.1025,5.88 1.68,5.88 2.2575,5.88 2.66875,6.29125 3.08,6.7025 3.08,7.28 z m 9.1,3.92 q 0,0.4025 -0.28875,0.69125 Q 11.6025,12.18 11.2,12.18 10.7975,12.18 10.50875,11.89125 10.22,11.6025 10.22,11.2 q 0,-0.4025 0.28875,-0.69125 Q 10.7975,10.22 11.2,10.22 q 0.4025,0 0.69125,0.28875 Q 12.18,10.7975 12.18,11.2 z M 4.9,3.36 Q 4.9,3.99875 4.449375,4.449375 3.99875,4.9 3.36,4.9 2.72125,4.9 2.270625,4.449375 1.82,3.99875 1.82,3.36 1.82,2.72125 2.270625,2.270625 2.72125,1.82 3.36,1.82 3.99875,1.82 4.449375,2.270625 4.9,2.72125 4.9,3.36 z M 8.96,1.68 q 0,0.7 -0.49,1.19 Q 7.98,3.36 7.28,3.36 6.58,3.36 6.09,2.87 5.6,2.38 5.6,1.68 5.6,0.98 6.09,0.49 6.58,0 7.28,0 7.98,0 8.47,0.49 8.96,0.98 8.96,1.68 z m 4.76,5.6 q 0,0.35 -0.245,0.595 Q 13.23,8.12 12.88,8.12 12.53,8.12 12.285,7.875 12.04,7.63 12.04,7.28 12.04,6.93 12.285,6.685 12.53,6.44 12.88,6.44 q 0.35,0 0.595,0.245 Q 13.72,6.93 13.72,7.28 z M 11.9,3.36 q 0,0.28875 -0.205625,0.494375 Q 11.48875,4.06 11.2,4.06 10.91125,4.06 10.705625,3.854375 10.5,3.64875 10.5,3.36 10.5,3.07125 10.705625,2.865625 10.91125,2.66 11.2,2.66 q 0.28875,0 0.494375,0.205625 Q 11.9,3.07125 11.9,3.36 z"/></svg></i>');
  $.ajax({
    data:$(this).serialize(),
    type:$(this).attr('method'),
    url:$(this).attr('action'),
    success:function(response){
      $('#rstfeedback').html(response);
      $('#rstbusy').html('<i class="i"><svg role="img" focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14"><path d="m 3.1785961,9.3930934 0.020751,0.113565 0.4753898,2.5991746 c 0.035466,0.193174 0.1645,0.355033 0.3440917,0.433133 0.1795917,0.07772 0.3867258,0.06112 0.5512258,-0.0449 C 5.2322045,12.06697 6.0969612,11.500275 6.073569,11.467073 L 3.1785961,9.3930934 Z M 1.4849255,5.7031624 c -0.258446,0.09923 -0.4418107,0.331641 -0.4784082,0.605934 -0.0362201,0.274669 0.080364,0.546698 0.3040986,0.709311 l 2.4493895,1.782335 8.7000106,-6.844481 -7.692637,7.578317 3.3484798,2.4365606 c 0.2131709,0.155068 0.4878405,0.201475 0.7410045,0.124507 0.2527866,-0.07697 0.4542613,-0.268633 0.5448118,-0.516137 L 12.9837,1.7755374 c 0.03622,-0.09961 0.01094,-0.210907 -0.06452,-0.285234 -0.07546,-0.07433 -0.186761,-0.09772 -0.285989,-0.05961 L 1.4849255,5.7031624 Z"/></svg></i>');
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
  document.cookie = 'bookingview=;expires=Thu, 01 Jan 1970 00:00:01 GMT;';
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
    }else if(id==0&&t=='cart'){
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
      $('#'+c+'image')[0].parentNode.remove();
		}else{
			if(imgsrc==''){
				$('#'+c+'image').attr('src',da);
        $('#'+c+'image')[0].parentNode.remove();
        $('#'+c+'image').wrap('<a data-fslightbox="cover" href="'+da+'"></a>');
			}
		}
    refreshFsLightbox();
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
      if(c=='file'||c=='thumb'||c=='fileDepth'){
        $('#'+c).val('');
      }
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
	if(w=='booking'||w=='noaccount'){
		$('#sp').load('core/change_bookingClient.php?id='+id+'&bid='+oid+'&w='+w);
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

var phrases=[
" A cold one","A few stubbies short of a six-pack","A few sandwiches short of a picnic","Accadacca","Ace ","Aerial pingpong ","Ambo ","Amber fluid ","and","also","Ankle biter ","Apples ","Arvo ","As busy as a ","As cross as a","As cunning as a","As dry as a","As stands out like ","Aussie Rules Footy ","Aussie salute","Avo ","Avos "
,"Back of Bourke ","Bail ","Bail out ","Banana bender","Barbie","Barbie ","Barrack ","Bastard ","Bastards ","Bathers ","Battler ","Bazza","Bail up ","Beauty ","Better than a ham sandwich","Better than a kick up the backside ","Big Smoke ","Bikie","Billabong ","Billy ","Bingle ","Bities","Bitzer","Bizzo ","Blimey ","Blind ","Bloke","bloody","Bloody ","Bloody oath ","Bloody ripper ","Blow in the bag ","Blowie ","Bludger ","Blue ","Bluey","Boardies","Bodgy ","Bog standard ","Bogan","Bogged ","Boil-over ","Bonza","Bonzer ","Boogie board ","Booze","Booze bus","Boozer ","Bottle-o ","Bottlo","Bounce ","Bradman","Brass razoo","Brekkie ","Brickie ","Brisvegas ","Brizzie","Brolly","Bruce","Brumby ","Buck's night ","Buckley's chance ","Budgie smugglers ","Buggered","Built like a","Bull bar ","Bundy ","Bunyip ","Burk","Burk ","Bush","Bush bash ","Bush oyster ","Bush telly ","Bushie","Bushman's handkerchief ","Bushranger ","Butcher "
,"Cab Sav ","Catcus ","Cactus mate","Cane toad ","Captain Cook ","Cark it ","Carry on like a pork chop ","Carrying on like a pork chop ","Chewie ","Chin wag ","Chock a Block ","Chokkie ","Chook ","Chrissie ","Christmas ","Chuck a sickie","Chuck a spaz","Chuck a yewy","Chunder ","Ciggies","Ciggy","Clacker ","Cleanskin","Clucky ","Coathanger ","Cobber ","Cockie ","Cockie","Coldie","Come a ","Compo","Cooee","Cook ","Coppers ","Corker ","Counter meal","Crack the shits ","Cracker","Cranky ","Cream ","Crikey ","Crook ","Crow eaters ","Cubby house ","Cut lunch ","Cut lunch commando","Cut snake"
,"Dag","Daks ","Damper ","Dardy ","Dead horse ","Deadset ","decent nik","Defo ","Dero ","Devo ","Digger ","Dill ","Dinky-di","Dinky-di ","Dipstick ","Divvy van ","Do the Harry ","Dob","Dog's balls","Dog's breakfast ","Dog's eye","Dole bludger ","Donga ","Donger ","Doovalacky ","Down Under ","Drongo","Dropkick ","Dry as as dead dingo's donga","Dunny","Dunny ","Dunny rat","Durry "
,"Esky","Eureka"
,"Facey ","Fair crack of the whip","Fair dinkum ","Fair go ","Fair go, mate","Fair suck of the sauce bottle","Fairy floss ","Feral","Few roos loose in the top paddock","Figjam ","Fisho ","Flake ","flamin'","Flanno","Flanny","Flat out","Flat out like a","Flick","Fly wire ","Footy ","Ford","Fossicker","Franger ","Freckle","Fremantle Doctor ","Freo ","Frog in a sock","Frothy ","Fruit loop ","Full blown ","Full boar ","Furthy"
,"G'day","Galah","Galah ","Garbo","Get a dog up ya","Give it a burl ","Gnarly","Gobful","Gobsmacked ","Going off ","Good oil ","Good onya ","Gone Walkabout ","Goon","Goon Bag","Grab us a ","Greenie ","Grog ","Grouse ","Grundies ","Gutful of ","gutta","Gyno "
,"Hard yakka ","Have a Captain Cook ","Have a go, you mug","Head like a dropped pie","heaps","Heaps","He hasn't got a","he's dreaming ","He's got a massive","His blood's worth bottling ","Hit the frog and toad","Hit the turps","Holden","Holy dooley ","Home grown ","Hoon ","Hooroo","Hottie ","how"
,"Icy pole","Iffy ","Ironman","It'll be"
,"Jackaroo","Jillaroo ","Joey","Jug","Jumbuck "
,"Kelpie","Ken Oath","Kero ","Kindie ","Knackered ","Knickers","Knock "
,"Lappy","Larrikin","Laughing gear ","leg it","Lets get some","Lets throw a","Like a madwoman's shit ","Lippy ","Lizard drinking","Lollies","Longneck ","Loose cannon ","Lurk "
,"Maccas","Mad as a","Manchester","Mates","mate","Mate ","Mate's rates","Metho","Mickey Mouse Mate","Middy","Milk bar ","Mokkies","Mongrel ","Moolah","Mozzie","Mullet","Muster ","my"
,"Nah, yeah ","Nipper","no dramas","No dramas","no worries","No worries","No worries, mate, she'll be right","No Wucka's","No wuckin' furries ","No-hoper ","Not my bowl of rice ","Not my cup of tea ","Nuddy"
,"Ocker ","Off chops ","Offsider ","oi","Oldies","On the cans ","One for the road","Onya bike ","Op shop","Outback"
,"Paddock ","Parma","Pash","Pav ","Pelican","Piece of Piss","Piker","pinga","Pint ","Piss Off","Piss Up","Pissed","Pissed Off","Plonk ","Pokies","Porky ","Postie","Pot ","Pozzy ","Pretty spiffy ","Prezzy ","Pub","Pull the wool over your eyes ","Pull the wool over their eyes ","Put a sock in it "
,"Quid"
,"Rack off ","Rage on ","Rapt ","Ratbag ","Reckon","Rego","Rellie","Rello ","Ridgy-didge","Rip snorter","Ripper ","Road train ","Roadie ","Rock up ","Rollie","Roo ","Roo bar ","Root Rat","Ropeable ","Rort ","Rotten","Rubbish ","Runners"
,"Sandgropper ","Sandgroppers ","Sanger ","Schooner","Scratchy","Servo","Shag on a rock","Shark Biscuit ","Shazza","Shazza got us some ","She'll be apples ","She'll be right","Shoey","Shoot Through","Sickie","Sheila","Sheila ","Shonky","Show pony ","Sick","Sickie","Six of one, half a dozen of the other","Skeg ","Skite ","Skull ","Slab ","Slabs","Slacker","slappa ","Slaps","Sleepout ","Smokes","Smoko ","Snag ","Sook ","Spag bol ","Spewin' ","Spit the dummy","Squizz ","Stands out like a","Stickybeak","Stoked ","Stonkered ","Straight to the pool room","Straya ","Strewth","Strides ","Struth","Stubby","Stubby holder ","Stuffed ","Sunnies ","Suss",,"Suss it out","Swag ","Swagger"
,"Taking the piss ","Tell him he's dreaming ","Tell your story walkin'","Ten Clicks away","Thingo ","Thongs ","Throw a shrimp on the barbie ","Throw-down ","Thunderbox ","Tickets on yourself ","Tinny","to ","Toads ","Too right","Top Bloke","Top End ","Tosser ","Trackie dacks ","Trackies","Trackies ","Tradie","Trent from punchy ","Troppo","Truckie ","True blue ","Tucker ","Tucker-bag","Turps ","Two pot screamer","Two up "
,"U-IE ","Ugg","Ugg boots ","Uluru","unit ","Up the duff ","Up Yours","Up Yourself","Ute","Ute "
,"VB","Vee dub","Veg out ","Vinnie's"
,"Waggin' school","Waratah","Watch out for the","Waazoo ","What's crackin' ","What's the John Dory?","Whinge ","We're going ","when","where","whit","Wobbly ","Woop Woop","Wouldn't piss on them if they're on fire","Wrap your laughing gear 'round that","Wuss"
,"ya","Yabber ","Yakka","Yobbo ","You little ripper","Your Shout","Yous"
];

function ipsuMe(el,p){
	if(typeof(phrases)=="undefined")return;
  var ipsum=[];
  if(el=='editor'){
	  var paramnum=p;
	  var paras=p;
    var sentr1=4;
    var sentr2=25;
    var parar1=4;
    var parar2=12;
  }else if(el=='title'){
    var paramnum=1;
    var paras=1;
    var sentr1=1;
    var sentr2=1;
    var parar1=1;
    var parar2=6;
  }else{
    var paramnum=1;
	  var paras=1;
    var sentr1=4;
    var sentr2=25;
    var parar1=4;
    var parar2=12;
  }
	for(i=0;i<paras;i++){
		para="";
		for(j=0;j<ipsumRandom(sentr1,sentr2);j++){
			sent="";
			prevW=-1;
			for(k=0;k<ipsumRandom(parar1,parar2);k++){
				if(sent!="")sent+=" ";
				var rW=ipsumRandom(0,phrases.length);
				while(rW==prevW){rW=ipsumRandom(0,phrases.length);}
        if(phrases[rW])sent+=phrases[rW].trim();
				prevW=rW;
			}
      if(el!='title')sent+=".";
			sent=sent.charAt(0).toUpperCase()+sent.slice(1).toLowerCase();
			if(para!="")para+=" ";
			para+=sent;
		}
		ipsum[ipsum.length]=para;
	}
  if(el=='editor'){
	  var resultHTML='';
	  for(p in ipsum){resultHTML+="<p>"+ipsum[p]+"</p>";}
    $('.summernote').summernote('code',resultHTML);
  }else{
    var resultHTML=$('#'+el);
    for(p in ipsum){resultHTML.val(ipsum[p]);}
  }
}
function ipsumRandom(min,max){return Math.floor((Math.random()*max)+min);}
