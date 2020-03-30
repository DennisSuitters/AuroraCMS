<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Meta-Footer
 * @package    core/layout/meta_footer.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.12
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.4 Fix Tooltips.
 * @changes    v0.0.8 Add Javascript for Offline PWA and Push Notifications.
 * @changes    v0.0.10 Add PHP Version to Developer Display and move to top of page.
 * @changes    v0.0.11 Prepare for PHP7.4 Compatibility. Remove {} in favour [].
 * @changes    v0.0.12 Fix Save Button for Image and Thumbnail selection not showing unsaved changes.
 * @changes    v0.0.12 Fix Multiple Media Adding.
 */?>
<script>
var unsaved=false;
window.onbeforeunload=function(e){
  if(unsaved)return'You have unsaved changes. Do you ant to leave this page and discard your changes or stay on this page?';
}
<?php if($config['idleTime']!=0){?>
  $(document).ready(function(){
    idleTimer=null;
    idleState=false;
    idleWait=<?php echo$config['idleTime']*60000;?>;
    $(document).on('mousemove scroll keyup keypress mousedown mouseup mouseover',function(){
      clearTimeout(idleTimer);
      idleState=false;
      idleTimer=setTimeout(function(){
        idleState=true;
        unsaved=false;
        document.location.href="<?php echo URL.$settings['system']['admin'].'/logout';?>";
      },idleWait);
    });
    $("body").trigger("mousemove");
    $('select[name="colorpicker"]').simplecolorpicker({theme: 'regularfont'});
  });
  $(function(){
    var hash=window.location.hash;
    hash && $('ul.nav a[href="'+hash+'"]').tab('show');
    $('.nav-tabs a').click(function (e){
      $(this).tab('show');
      var scrollmem=$('body').scrollTop();
      window.location.hash=this.hash;
      $('html,body').scrollTop(scrollmem);
    });
  });
<?php }?>
  $('#seoTitle').keyup(function(){
  	var length=$(this).val().length;
  	var max=70;
  	var length=max-length;
  	$("#seoTitlecnt").text(length);
    $('#google-title').text($(this).val());
  	if(length<0){
  		$("#seoTitlecnt").addClass('text-danger');
  	}else{
  		$("#seoTitlecnt").removeClass('text-danger');
  	}
  });
  $('#seoCaption').keyup(function(){
  	var length=$(this).val().length;
  	var max=160;
  	var length=max-length;
  	$("#seoCaptioncnt").text(length);
  	if(length<0){
  		$("#seoCaptioncnt").addClass('text-danger');
  	}else{
  		$("#seoCaptioncnt").removeClass('text-danger');
  	}
  });
  $('#seoDescription').keyup(function(){
  	var length=$(this).val().length;
  	var max=160;
  	var length=max-length;
  	$("#seoDescriptioncnt").text(length);
    $('#google-description').text($(this).val());
  	if(length<0){
  		$("#seoDescriptioncnt").addClass('text-danger');
  	}else{
  		$("#seoDescriptioncnt").removeClass('text-danger');
  	}
  });
<?php if(isset($r['pti'])&&$user['options'][1]==1){?>
  $('#pti').daterangepicker({
    singleDatePicker:true,
    linkedCalendars:false,
    autoUpdateInput:true,
    showDropdowns:true,
    showCustomRangeLabel:false,
    timePicker:true,
    startDate:"<?php echo date($config['dateFormat'],$r['pti']!=0?$r['pti']:time());?>",
    locale:{
      format:'MMM Do,YYYY h:mm A'
    }
  },function(start){
    $('#ptix').val(start.unix());
  });
<?php }
if(isset($r['tis'])&&($user['options'][2]==1||$user['options'][1]==1)){?>
  $('#tis').daterangepicker({
    singleDatePicker:true,
    linkedCalendars:false,
    autoUpdateInput:true,
    showDropdowns:true,
    showCustomRangeLabel:false,
    timePicker:true,
    startDate:"<?php echo date($config['dateFormat'],$r['tis']!=0?$r['tis']:time());?>",
    locale:{
      format:'MMM Do,YYYY h:mm A'
    }
  },function(start){
    $('#tisx').val(start.unix());
  });
<?php }
if(isset($r['tie'])&&($user['options'][2]==1||$user['options'][1]==1)){?>
  $('#tie').daterangepicker({
    singleDatePicker:true,
    linkedCalendars:false,
    autoUpdateInput:true,
    showDropdowns:true,
    showCustomRangeLabel:false,
    timePicker:true,
    startDate:"<?php echo date($config['dateFormat'],$r['tie']!=0?$r['tie']:time());?>",
    locale:{
      format:'MMM Do,YYYY h:mm A'
    }
  },function(start){
    $('#tiex').val(start.unix());
  });
<?php }
if(isset($r['due_ti'])){?>
  $('#due_ti').daterangepicker({
    singleDatePicker:true,
    linkedCalendars:false,
    autoUpdateInput:true,
    showDropdowns:true,
    showCustomRangeLabel:false,
    timePicker:true,
    startDate:"<?php echo date($config['dateFormat'],$r['due_ti']!=0?$r['due_ti']:time());?>",
    locale:{
      format:'MMM Do,YYYY h:mm A'
    }
  },function(start){
    $('#due_tix').val(start.unix());
  });
<?php }?>
  $('.save').click(function(e){
	 	e.preventDefault();
	 	var l=Ladda.create(this);
    var el=$(this).data("dbid");
    var id=$('#'+el).data("dbid"),
        t=$('#'+el).data("dbt"),
        c=$('#'+el).data("dbc"),
        da=$('#'+el).val();
    if(c=='tis'||c=='tie'||c=='pti'||c=='due_ti'){
      da=$('#'+c+'x').val();
    }
	 	l.start();
    $('#'+el).attr('disabled','disabled');
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
      l.stop();
      $('#'+el).removeAttr('disabled');
      $('#save'+c).removeClass('btn-danger');
      unsaved=false;
    });
	 	return false;
	});
<?php
  if($view=='media'||$args[0]=='edit'){?>
  $.widget.bridge('uibutton',$.ui.button);
  $.widget.bridge('uitooltip',$.ui.tooltip);
<?php }
  if($config['options'][4]==0){?>
  $().tooltip('disable');
<?php }else{?>
  $('body').tooltip({
    selector:'[data-tooltip="tooltip"]',
    container:"body"
  });
<?php }
  if($args[0]=='edit'||$args[0]=='compose'||$args[0]=='reply'||$args[0]=='settings'||$args[0]=='security'||($view=='content'||$view=='accounts'||$view=='orders'||$view=='bookings'||$view=='newsletters'||$view=='messages'&&$args[0]=='settings'||$args[0]=='view')){?>
  function elfinderDialog(id,t,c){
    var fm=$('<div class="shadow light"/>').dialogelfinder({
      url:"<?php echo URL.DS.'core'.DS.'elfinder'.DS.'php'.DS.'connector.php';?>",
      lang:'en',
      width:840,
      height:450,
      destroyOnClose:true,
      useBrowserHistory:false,
      getFileCallback:function(file,fm){
        if(id>0||c=='attachments'){
          if(c=='mediafile'){
            var urls = $.each(file,function(i,f){return f.url;});
            $('#'+c).val(urls);
          }else{
            $('#'+c).val(file.url);
            $('#save'+c).addClass('btn-danger');
          }
          if(t=='content'&&c=='file'){
            $('#thumb').val(file.tmb);
            $('#savethumb').addClass('btn-danger');
          }
          if(t=='content'&&c=='fileDepth'){
            $('#savefileDepth').addClass('btn-danger');
          }
          if(t=='category'){

          }else if(t!='media'||t!='category'){
            if(t=='config'&&c=='php_honeypot'){
              $('#php_honeypot_link').html('<a target="_blank" href="'+file.url+'">'+file.url+'</a>');
            }else{
              if(t=='menu'&&c=='cover'){
                coverUpdate(id,t,c,file.url);
                $('#'+c+'image').attr('src',file.url);
              }else{
                $('#'+c+'image').attr('src',file.url);
              }
            }
          }
          if(t=='messages'&&c=='attachments'){
            var path_splitted=file.url.split('.');
            var fileExt=path_splitted.pop();
            var filename="core/images/i-file.svg";
            if(fileExt=="jpg"||fileExt=="jpeg"||fileExt=="png"||fileExt=="gif"||fileExt=="bmp"||fileExt=="webp"||fileExt=="svg"){
              filename=file.url;
            }
            if(fileExt=="pdf"){
              filename='core/images/i-file-pdf.svg';
            }
            if(fileExt=="zip"||fileExt=="zipx"||fileExt=="tar"||fileExt=="gz"||fileExt=="rar"||fileExt=="7zip"||fileExt=="7z"||fileExt=="bz2"){
              filename='core/images/i-file-archive.svg';
            }
            if(fileExt=="doc"||fileExt=="docx"||fileExt=="xls"){
              filename="core/images/i-file-docs.svg";
            }
            var timestamp = $.now();
            $('#attachments').append('<a id="a_'+timestamp+'" target="_blank" class="card col-2 p-0" href="'+file.url+'" data-title="'+file.url.replace(/^.*[\\\/]/,'')+'"><img class="card-img-top bg-white" src="'+filename+'" alt="'+file.url+'"><span class="card-footer text-truncate p-0 pl-1 pr-1 small">'+file.url.replace(/^.*[\\\/]/,'')+'</span><span class="attbuttons"><button class="btn btn-secondary trash" onclick="attRemove(\''+timestamp+'\');return false;"><?php svg('trash');?></button></span></a>');
            var atts=$('#atts').val();
            if(atts!='')atts+=',';
            atts+=file.url;
            $('#atts').val(atts);
          }
        }else{
          if(file.url.match(/\.(jpeg|jpg|gif|png)$/)){
<?php if($view=='messages'){?>
            $('#bod').summernote('editor.insertImage',file.url);
<?php }else{?>
            $('.summernote').summernote('editor.insertImage',file.url);
<?php }?>
          }else{
<?php if($view=='messages'){?>
            $('#bod').summernote('createLink',{
              text:file.name,
              url:file.url,
              newWindow:true
            });
<?php }else{?>
            $('.summernote').summernote('createLink',{
              text:file.name,
              url:file.url,
              newWindow:true
            });
<?php }?>
          }
        }
      },
      commandsOptions: {
        getfile: {
          onlyURL: true,
          folders: false,
          multiple: true,
          oncomplete: "close"
        }
      }
    }).dialogelfinder('instance');
  }
<?php }
  if($view=='media'||$args[0]=='security'||($view=='accounts'||$view=='orders'||$view=='bookings'&&$args[0]=='settings')){?>
  $().ready(function(){
    var fm=$('#elfinder').elfinder({
      url:"<?php echo URL.DS.'core'.DS.'elfinder'.DS.'php'.DS.'connector.php';?>",
      lang:'en',
      width:'85vw',
      height:$(window).height()-102,
      resizeable:false,
      handlers:{
        dblclick:function(e,eI){
          e.preventDefault();
          eI.exec('getfile').done(function(){
            eI.exec('quicklook');
          }).fail(function(){
            eI.exec('open');
          });
        }
      },
      getFileCallback:function(){
        return false;
      },
    }).elfinder('instance');
    var $elfinder=$('#elfinder').elfinder();
    $(window).resize(function(){
      resizeTimer=setTimeout(function(){
        var h=parseInt($(window).height())-102;
        if(h!=parseInt($('#elfinder').height())){
          fm.resize('100%',h);
        }
      },200);
      resizeTimer && clearTimeout(resizeTimer);
    });
  });
<?php }?>
  document.addEventListener("DOMContentLoaded",function(event){
<?php if($args[0]=='edit'||$args[0]=='compose'||$args[0]=='reply'||($view=='accounts'||$view=='orders'||$view=='bookings'||$view=='newsletters'||$view=='messages'&&$args[0]=='settings')){?>
    $('.summernote').summernote({
      isNotSplitEdgePoint:true,
      height:300,
      tabsize:2,
      popover:{
        image:
          [
            ['custom',['imageAttributes','imageShapes','captionIt']],
            ['imagesize',['imageSize100','imageSize50','imageSize25']],
            ['float',['floatLeft','floatRight','floatNone']],
            ['remove',['removeMedia']],
          ],
        link:
          [
            ['link',['linkDialogShow','unlink']]
          ],
        air:
          [
            ['color',['color']],
            ['font',['bold','underline','clear']],
            ['para',['ul','paragraph']],
            ['table',['table']],
            ['insert',['media','link','picture']]
          ]
      },
      lang:'en-US',
      toolbar:
        [
          ['save',['save']],
//        ['aria',['accessibility','findnreplace','cleaner','seo']],
          ['style',['style']],
          ['font',['bold','italic','underline','clear']],
          ['fontname',['fontname']],
          ['fontsize',['fontsize']],
          ['color',['color']],
          ['para',['ul','ol','paragraph']],
          ['height',['height']],
          ['table',['table']],
          ['insert',['videoAttributes','elfinder','link','hr']],
          ['view',['fullscreen','codeview']],
          ['help',['help']]
        ],
        callbacks:{
          onInit:function(){
            $('body > .note-popover').appendTo(".note-editing-area");
          }
        }
    });
<?php }?>
    $(".textinput").on({
    	blur:function(event){
    		event.preventDefault();
    	},
    	keydown:function(event){
    		var id=$(this).data("dbid");
    		if(event.keyCode==46||event.keyCode==8){
    			$(this).trigger('keypress');
    		}
    	},
    	keyup:function(event){
    		if(event.which==9){
    			var id=$(this).data("dbid");
    			var da=$(this).val();
    			$(this).trigger('keypress');
    			$(this).next("input").focus();
          unsaved=true;
    		}
    	},
    	keypress:function(event){
        var save=$(this).data("dbc");
        $('#save'+save).addClass('btn-danger');
        unsaved=true;
    		if(event.which==13){
    			event.preventDefault();
    		}
    	},
    	change:function(event){
        var save=$(this).data("dbc");
        $('#save'+save).addClass('btn-danger');
        unsaved=true;
    	}
    });
    $(document).on(
    	'click','#content input[type=checkbox]',
    	{},
    	function(event){
    		var id=$(this).data("dbid");
    		if('#home input[type=checkbox]'){
    			$('#actions').toggleClass('hidden');
    		}else{
    			$('#actions').toggleClass('hidden');
  		   }
//    		if(id=='checkboxtoggle'){
    			if(this.checked){
    				$('.switchinput').each(function(){
    					this.checked=true;
              $(this).attr("aria-checked","true");
    				});
    			}else{
    				$('.switchinput').each(function(){
    					this.checked=false;
              $(this).attr("aria-checked","false");
    				});
    			}
//    		}else{
    			var t=$(this).data("dbt");
    			var c=$(this).data("dbc");
    			var b=$(this).data("dbb");
//   			var a=$(this).data("dba");
          $.ajax({
            type:"GET",
            url:"core/toggle.php",
            data:{
              id:id,
              t:t,
              c:c,
              b:b
            }
          }).done(function(msg){
        });
//    		}
    	}
    );
    setInterval(function(){
      $.get("<?php echo URL;?>/core/nav-stats.php",{},function(results){
        var stats=results.split(",");
        var navStat=$('#nav-stat').html();
        var stats=results.split(",");
        var navStat=$('#nav-stat').html();
        if(stats[0]==0)stats[0]='';
        $('#nav-nou').html(stats[2]);
        var stathtml='<div class="dropdown-header text-center"><strong>Notifications</strong></div>';
        if(stats[3]>0)stathtml+='<a class="dropdown-item" href="<?php echo URL.$settings['system']['admin'];?>/content"><?php svg('comments');?> Comments<span id="nav-nc" class="badge badge-info">'+stats[3]+'</span></a>';
        if(stats[4]>0)stathtml+='<a class="dropdown-item" href="<?php echo URL.$settings['system']['admin'];?>/content"><?php svg('review');?> Reviews<span id="nav-nr" class="badge badge-info">'+stats[4]+'</span></a>';
        if(stats[5]>0)stathtml+='<a class="dropdown-item" href="<?php echo URL.$settings['system']['admin'];?>/messages"><?php svg('inbox');?> Messages<span id="nav-nm" class="badge badge-info">'+stats[5]+'</span></a>';
        if(stats[6]>0)stathtml+='<a class="dropdown-item" href="<?php echo URL.$settings['system']['admin'];?>/orders/pending"><?php svg('order');?> Orders<span id="nav-po" class="badge badge-info">'+stats[6]+'</span></a>';
        if(stats[7]>0)stathtml+='<a class="dropdown-item" href="<?php echo URL.$settings['system']['admin'];?>/bookings"><?php svg('calendar');?> Bookings<span id="nav-nb" class="badge badge-info">'+stats[7]+'</span></a>';
        if(stats[8]>0)stathtml+='<a class="dropdown-item" href="<?php echo URL.$settings['system']['admin'];?>/accounts"><?php svg('users');?> Users<span id="nav-nu" class="badge badge-info">'+stats[8]+'</span></a>';
        if(stats[9]>0)stathtml+='<a class="dropdown-item" href="<?php echo URL.$settings['system']['admin'];?>/content/type/testimonials"><?php svg('testimonial');?> Testimonials<span id="nav-nt" class="badge badge-info">'+stats[9]+'</span></a>';
        if(stats[2]>0)stathtml+='<a class="dropdown-item" href="<?php echo URL.$settings['system']['admin'];?>/accounts"><?php svg('users');?> Active Users<span id="nav-nou" class="badge badge-info">'+stats[2]+'</span></a>';
        $('#nav-stat').html(stats[0]);
        $('#nav-stat-list').html(stathtml);
        if(stats[1]==0){
          document.title='Administration <?php echo$config['business']!=''?' for '.$config['business']:'';?> - AuroraCMS';
        }
        if(stats[0]>0)document.title='('+stats[0]+') Administration<?php echo$config['business']!=''?' for '.$config['business']:'';?> - AuroraCMS';
      });
    },30000);
    $('.pathviewer').popover({
      html:true,
      trigger:'manual',
      title:'Visitor Path <button type="button" class="close" data-dismiss="popover" aria-label="Close"><span aria-hidden="true">&times;</span></button>',
      container:'body',
      placement:'auto',
      template:'<div class="popover pathviewer shadow" role="tooltip"><h3 class="popover-header"></h3><div class="popover-body"></div></div>',
      content:function(){
        var id=$(this).data("dbid");
        return $.ajax({
          url:'core/layout/pathviewer.php',
          dataType:'html',
          async:false,
          data:{
            id:id
          }
        }).responseText;
      }
    }).click(function(e){
      $(this).popover('toggle');
      $('.pathviewer').draggable({
        appendTo: 'document',
        addClasses: false,
        handle: 'h3',
      });
    }).on('shown.bs.popover',function(e) {
      var current_popover='#'+$(e.target).attr('aria-describedby');
      var $cur_pop=$(current_popover);
      $cur_pop.find('.close').click(function(){
        $cur_pop.popover('hide');
      });
    });
    $('.phpviewer').popover({
      html:true,
      trigger:'manual',
      title:'Project Honey Pot Threat Assessment <button type="button" class="close" data-dismiss="popover" aria-label="Close"><span aria-hidden="true">&times;</span></button>',
      container:'body',
      placement:'auto',
      template:'<div class="popover suggestions shadow" role="tooltip"><h3 class="popover-header"></h3><div class="popover-body"></div></div>',
      content:function(){
        var id=$(this).data("dbid"),
            t=$(this).data("dbt");
        return $.ajax({
          url:'core/layout/phpviewer.php',
          dataType:'html',
          async:false,
          data:{
            id:id,
            t:t
          }
        }).responseText;
      }
    }).click(function(e){
      $(this).popover('toggle');
    }).on('shown.bs.popover',function(e){
      var current_popover='#'+$(e.target).attr('aria-describedby');
      var $cur_pop=$(current_popover);
      $cur_pop.find('.close').click(function(){
        $cur_pop.popover('hide');
      });
    });
    $('.suggestions').popover({
      html:true,
      trigger:'manual',
      title:'Editing Suggestions <button type="button" class="close" data-dismiss="popover" aria-label="Close"><span aria-hidden="true">&times;</span></button>',
      container:'body',
      placement:'auto',
      template:'<div class="popover suggestions shadow" role="tooltip"><h3 class="popover-header"></h3><div class="popover-body"></div></div>',
      content:function(){
        var el=$(this).data("dbgid");
        var id=$('#'+el).data("dbid"),
            t=$('#'+el).data("dbt"),
            c=$('#'+el).data("dbc");
        return $.ajax({
          url:'core/layout/suggestions.php',
          dataType:'html',
          async:false,
          data:{
            id:id,
            t:t,
            c:c
          }
        }).responseText;
      }
    }).click(function(e) {
      $(this).popover('toggle');
    }).on('shown.bs.popover',function(e){
      var current_popover='#'+$(e.target).attr('aria-describedby');
      var $cur_pop=$(current_popover);
      $cur_pop.find('.close').click(function(){
        $cur_pop.popover('hide');
      });
    });
<?php if($user['rank']>899){?>
    $('.addsuggestion').popover({
      html:true,
      trigger:'manual',
      title:'Add Suggestion <button type="button" class="close" data-dismiss="popover" aria-label="Close"><span aria-hidden="true">&times;</span></button>',
      container:'body',
      placement:'auto',
      template:'<div class="popover suggestions shadow" role="tooltip"><h3 class="popover-header"></h3><div class="popover-body"></div></div>',
      content:function(){
        var el=$(this).data("dbgid");
        var id=$('#'+el).data("dbid"),
            t=$('#'+el).data("dbt"),
            c=$('#'+el).data("dbc");
        return $.ajax({
          url:'core/layout/suggestions-add.php',
          dataType:'html',
          async:false,
          data:{
            id:id,
            t:t,
            c:c
          }
        }).responseText;
      }
    }).click(function(e) {
      $(this).popover('toggle');
    }).on('shown.bs.popover',function(e){
      var current_popover='#'+$(e.target).attr('aria-describedby');
      var $cur_pop=$(current_popover);
      $cur_pop.find('.close').click(function(){
        $cur_pop.popover('hide');
      });
    });
<?php }?>
      });
      if('serviceWorker' in navigator){
        window.addEventListener('load',()=>{
          navigator.serviceWorker.register('core/js/service-worker-admin.php',{
            scope:'/'
          }).then((reg)=>{
            console.log('[AuroraCMS] Administration Service worker registered.',reg);
          });
        });
      }
    </script>
    <iframe id="sp" name="sp" class="d-none"></iframe>
    <div id="searchbox" class="d-none">
      <div class="searchclose"><a href="#" onclick="$('#searchbox').toggleClass('d-none');return false;">X</a></div>
      <div class="container-fluid">
        <div class="form-group">
          <form method="post" action="<?php echo URL.$settings['system']['admin'].'/search';?>">
            <div class="input-group col-12">
              <input type="text" class="form-control" name="s" placeholder="What are you looking for?">
              <div class="input-group-append">
                <button type="submit" class="btn btn-secondary btn-lg">Go</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="page-block">
      <div class="loader">
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
      </div>
    </div>
<?php if($config['development']==1&&$user['rank']==1000){
  echo'<div class="developmentbottom">Memory Used: '.size_format(memory_get_usage()).' | Process Time: '.elapsed_time().' | PHPv'.(float)PHP_VERSION.'</div>';
}?>
  </body>
</html>
