<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Meta-Footer
 * @package    core/layout/meta_footer.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.0
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<script>
  $(document).on(
  	"click",
  	".opener",function(){
      $(this).parent().toggleClass('open');
      $(this).next().toggleClass('open');
      return false;
  	}
  );
  $(document).on(
    "click",
    ".nav-toggle",function(){
      $('#content,#sidebar').toggleClass('navsmall');
      document.getElementById('notification-checkbox').checked=false;
      return false;
    }
  );
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
      $('#'+el).removeClass('unsaved');
      $('#save'+c).removeClass('btn-danger');
      if($('.unsaved').length===0)$('.saveall').removeClass('btn-danger');
      unsaved=false;
    });
	 	return false;
	});
  <?php  if($args[0]=='edit'||$args[0]=='compose'||$args[0]=='reply'||$args[0]=='settings'||$args[0]=='security'||($view=='content'||$view=='accounts'||$view=='orders'||$view=='bookings'||$view=='newsletters'||$view=='messages'&&$args[0]=='settings'||$args[0]=='view')){?>
      function elfinderDialog(id,t,c){
        var fm=$('<div class="shadow light"/>').dialogelfinder({
          url:"<?php echo URL.DS.'core'.DS.'elfinder'.DS.'php'.DS.'connector.php';?>?id="+id+"&t="+t+"&c="+c,
          lang:'en',
          width:840,
          height:450,
          destroyOnClose:true,
          useBrowserHistory:false,
          getFileCallback:function(file,fm){
            if(id>0||c=='attachments'){
              if(c=='mediafile'){
                var urls=$.each(file,function(i,f){return f.url;});
                $('#'+c).val(urls);
              }else{
                $('#'+c).val(file.url);
                $('#save'+c).addClass('btn-danger');
              }
              if(t=='content'&&c=='file'){
                var thumb = file.url.replace(/^.*[\\\/]/, '');
                var thumbpath = file.url.replace(thumb,'')+"thumbs/"+thumb;
                $('#thumb').val(thumbpath);
                $('#thumbimage').attr('src',thumbpath);
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
                $('#attachments').append('<div id="a_'+timestamp+'" class="form-row mt-1"><img src="'+filename+'" alt="'+file.url+'"><div class="input-text col-12"><a target="_blank" href="'+file.url+'" data-title="'+file.url.replace(/^.*[\\\/]/,'')+'">'+file.url.replace(/^.*[\\\/]/,'')+'</a></div><button class="trash" onclick="attRemove(\''+timestamp+'\');return false;"><?php svg('trash');?></button></div>');
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
            commandsOptions:{
              getfile:{
                onlyURL:c=='mediafile'?true:false,
                folders:c=='mediafile'?false:true,
                multiple:c=='mediafile'?true:false,
                oncomplete:"close"
              }
            }
          }).dialogelfinder('instance');
        }
      <?php }
      if($view=='seo'||$view=='media'||$args[0]=='security'||($view=='accounts'||$view=='orders'||$view=='bookings'&&$args[0]=='settings')){?>
        $().ready(function(){
          var fm=$('#elfinder').elfinder({
            url:"<?php echo URL.DS.'core'.DS.'elfinder'.DS.'php'.DS.'connector.php';?>",
            lang:'en',
            width:'85vw',
            height:$(window).height()-102,
            resizeable:false,
            commandsOptions:{
              getfile:{
                open:{
                  selectAction:'getfile'
                },
                preference:{
                  selectActions:['getfile','edit/download','resize/edit/download','download','quicklook']
                },
              }
            },
            getFileCallback:function(file,elFinderInstance){
              var url=file.url;
              $.fancybox.open({src:url});
            }
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
          codemirror:{
            lineNumbers:true,
            lineWrapping:true,
            theme:'base16-dark',
          },
          isNotSplitEdgePoint:true,
          height:300,
          tabsize:2,
          styleTags:[
            'p',
            {title:'Blockquote',tag:'blockquote',className:'blockquote',value:'blockquote'},
            'pre',
            'h2',
            'h3',
            'h4',
            'h5',
            'h6'
          ],
          popover:{
            image:[
              ['custom',['picture','imageShapes','captionIt']],
              ['imagesize',['imageSize100','imageSize50','imageSize25']],
              ['float',['floatLeft','floatRight','floatNone']],
              ['remove',['removeMedia']],
            ],
            link:[
              ['link',['linkDialogShow','unlink']],
            ],
            air:[
              ['font',['bold','underline','clear']],
              ['para',['ul','paragraph']],
              ['table',['table']],
              ['insert',['media','link','picture']]
            ]
          },
          lang:'en-US',
          toolbar:[
            ['save',['save']],
            ['style',['style']],
            ['font',['bold','italic','underline','clear']],
            ['para',['ul','ol','paragraph']],
            ['table',['table']],
            ['insert',['elfinder','video','link','hr','checkbox']],
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
      $.fn.ogni=function(f,t){var i=0;function recurse(list){var el=list.shift();f.apply(el,[i++,el])||setTimeout(function(){list.length&&recurse(list)},t)}this.length&&recurse(this.toArray());return this}
      $(".saveall").on({
        click:function(event){
          event.preventDefault();
          if($('.unsaved').length>0)$('.page-block').addClass('d-block');
          $(".unsaved").ogni(function(event){
            var id=$(this).data("dbid");
            var t=$(this).data("dbt");
            var c=$(this).data("dbc");
            var da=$(this).val();
            $(this).removeClass('unsaved');
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
              $('.saveall').removeClass('btn-danger');
              unsaved=false;
            });
            $('#save'+c).removeClass('btn-danger');
            if($('.unsaved').length===0)$('.page-block').removeClass('d-block');
          },1000);
        }
      });
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
          $('.saveall').addClass('btn-danger');
          $('#'+save).addClass('unsaved');
          unsaved=true;
          if(event.which==13){
            event.preventDefault();
          }
        },
        change:function(event){
          var save=$(this).data("dbc");
          $('#'+save).addClass('unsaved');
          $('#save'+save).addClass('btn-danger');
          unsaved=true;
        }
      });
      $(document).on(
        'click','#content input[type=checkbox]',
        {},function(event){
          var id=$(this).data("dbid");
          if('#home input[type=checkbox]'){
            $('#actions').toggleClass('hidden');
          }else{
            $('#actions').toggleClass('hidden');
          }
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
    			var t=$(this).data("dbt");
    			var c=$(this).data("dbc");
    			var b=$(this).data("dbb");
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
        var stathtml='<li class="dropdown-heading py-2">Notifications</li>';
        if(stats[3]>0)stathtml+='<li><a href="<?php echo URL.$settings['system']['admin'];?>/content"><?php svg('comments');?> Comments<span class="badger badge-primary">'+stats[3]+'</span></a></li>';
        if(stats[4]>0)stathtml+='<li><a href="<?php echo URL.$settings['system']['admin'];?>/content"><?php svg('review');?> Reviews<span class="badger badge-primary">'+stats[4]+'</span></a></li>';
        if(stats[5]>0)stathtml+='<li><a href="<?php echo URL.$settings['system']['admin'];?>/messages"><?php svg('inbox');?> Messages<span class="badger badge-primary">'+stats[5]+'</span></a></li>';
        if(stats[6]>0)stathtml+='<li><a href="<?php echo URL.$settings['system']['admin'];?>/orders/pending"><?php svg('order');?> Orders<span class="badger badge-primary">'+stats[6]+'</span></a></li>';
        if(stats[7]>0)stathtml+='<li><a href="<?php echo URL.$settings['system']['admin'];?>/bookings"><?php svg('calendar');?> Bookings<span class="badger badge-primary">'+stats[7]+'</span></a></li>';
        if(stats[8]>0)stathtml+='<li><a href="<?php echo URL.$settings['system']['admin'];?>/accounts"><?php svg('users');?> Users<span class="badger badge-primary">'+stats[8]+'</span></a></li>';
        if(stats[9]>0)stathtml+='<li><a href="<?php echo URL.$settings['system']['admin'];?>/content/type/testimonials"><?php svg('testimonial');?> Testimonials<span class="badger badge-primary">'+stats[9]+'</span></a></li>';
        if(stats[2]>0)stathtml+='<li><a href="<?php echo URL.$settings['system']['admin'];?>/accounts"><?php svg('users');?> Active Users<span class="badger badge-primary">'+stats[2]+'</span></a></li>';
        $('#nav-stat').data('badge',stats[0]);
        $('#nav-stat-list').html(stathtml);
        if(stats[1]==0){
          document.title='Administration <?php echo$config['business']!=''?' for '.$config['business']:'';?> - AuroraCMS';
        }
        if(stats[0]>0)document.title='('+stats[0]+') Administration<?php echo$config['business']!=''?' for '.$config['business']:'';?> - AuroraCMS';
      });
    },30000);
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
<?php /*    <div class="modal fade" id="editseo" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">SEO Editor</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body p-4">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div> */ ?>
    <div class="page-block">
      <div class="spinner">
        <div class="sk-chase">
          <div class="sk-chase-dot"></div>
          <div class="sk-chase-dot"></div>
          <div class="sk-chase-dot"></div>
          <div class="sk-chase-dot"></div>
          <div class="sk-chase-dot"></div>
          <div class="sk-chase-dot"></div>
        </div>
      </div>
    </div>
<?php if($config['development']==1&&$user['rank']==1000){?>
    <script>
      $('.developmentbottom').html('Memory Used: <?php echo size_format(memory_get_usage());?> | Process Time: <?php echo elapsed_time();?> | PHPv<?php echo (float)PHP_VERSION;?> ');
    </script>
<?php }?>
  </body>
</html>
