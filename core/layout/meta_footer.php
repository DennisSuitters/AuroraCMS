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
          url:"<?php echo URL.'/core/elfinder/php/connector.php';?>?id="+id+"&t="+t+"&c="+c,
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
                var fileExtCheck=fileExt.toLowerCase();
                if(fileExtCheck=="jpg"||fileExtCheck=="jpeg"||fileExtCheck=="png"||fileExtCheck=="gif"||fileExtCheck=="bmp"||fileExtCheck=="webp"||fileExtCheck=="svg"){
                  filename=file.url;
                }
                if(fileExtCheck=="pdf"){
                  filename='core/images/i-file-pdf.svg';
                }
                if(fileExtCheck=="zip"||fileExtCheck=="zipx"||fileExtCheck=="tar"||fileExtCheck=="gz"||fileExtCheck=="rar"||fileExtCheck=="7zip"||fileExtCheck=="7z"||fileExtCheck=="bz2"){
                  filename='core/images/i-file-archive.svg';
                }
                if(fileExtCheck=="doc"||fileExtCheck=="docx"||fileExtCheck=="xls"){
                  filename="core/images/i-file-docs.svg";
                }
                var timestamp = $.now();
                $('#attachments').append('<div id="a_'+timestamp+'" class="form-row mt-1"><img src="'+filename+'" alt="'+file.url+'"><div class="input-text col-12"><a target="_blank" href="'+file.url+'" aria-label="'+file.url.replace(/^.*[\\\/]/,'')+'">'+file.url.replace(/^.*[\\\/]/,'')+'</a></div><button class="trash" onclick="attRemove(\''+timestamp+'\');return false;"><?php svg('trash');?></button></div>');
                var atts=$('#atts').val();
                if(atts!='')atts+=',';
                atts+=file.url;
                $('#atts').val(atts);
              }
            }else{
              if(file.url.match(/\.(jpeg|JPEG|jpg|JPG|gif|GIF|png|PNG|webp|WEBP)$/)){
                $('#'+id).val(file.url);
                $('.note-image-btn').removeAttr("disabled");
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
            url:"<?php echo URL.'/core/elfinder/php/connector.php';?>",
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
          disableUpload: true,
          fileExplorer: 'elfinderDialog',
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
            ['find',['findnreplace']],
            ['style',['cleaner','style']],
            ['font',['bold','italic','underline','clear']],
            ['para',['ul','ol','paragraph']],
            ['table',['table']],
            ['insert',['picture','video','link','hr','checkbox']],
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
    if($('.tab-control').length>0){
      $('.tab-control').on('click',function(){
        var tab=$(this).attr('id');
        window.location.hash = tab;
      });
      if (location.href.indexOf("#") != -1) {
        var tab = window.location.hash.substr(1);
        if(tab != '') {
          if(!tab.includes("tab")) {
            var clo=document.getElementById(tab);
            var tab = clo.closest("[data-tabid]").dataset.tabid;
          }
          var cbarray = document.getElementsByName('tabs');
          for(var i = 0; i < cbarray.length; i++){
            cbarray[i].checked = false;
          }
          document.getElementById(tab).checked = true;
        }else{
          document.getElementById('tab1-1').checked = true;
        }
      }else{
        if(document.getElementById('tab1-1')) {
          document.getElementById('tab1-1').checked = true;
        }
      }
    }
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

    $(document).on("click","[data-social-share]",function(){
      var url=$(this).data("social-share");
      var desc=$(this).data("social-desc");
      var tpl=`<div class="fancybox-share"><h1>Share on Social Media</h1><p><a class="fancybox-share__button fancybox-share__button--fb" href="https://www.facebook.com/sharer/sharer.php?u={{url}}"><svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="m287 456v-299c0-21 6-35 35-35h38v-63c-7-1-29-3-55-3-54 0-91 33-91 94v306m143-254h-205v72h196"/></svg><span>Facebook</span></a><a class="fancybox-share__button fancybox-share__button--tw" href="https://twitter.com/intent/tweet?url={{url}}&text={{desc}}"><svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="m456 133c-14 7-31 11-47 13 17-10 30-27 37-46-15 10-34 16-52 20-61-62-157-7-141 75-68-3-129-35-169-85-22 37-11 86 26 109-13 0-26-4-37-9 0 39 28 72 65 80-12 3-25 4-37 2 10 33 41 57 77 57-42 30-77 38-122 34 170 111 378-32 359-208 16-11 30-25 41-42z"/></svg><span>Twitter</span></a><a class="fancybox-share__button fancybox-share__button--pt" href="https://www.pinterest.com/pin/create/button/?url={{url}}&description={{desc}}"><svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="m265 56c-109 0-164 78-164 144 0 39 15 74 47 87 5 2 10 0 12-5l4-19c2-6 1-8-3-13-9-11-15-25-15-45 0-58 43-110 113-110 62 0 96 38 96 88 0 67-30 122-73 122-24 0-42-19-36-44 6-29 20-60 20-81 0-19-10-35-31-35-25 0-44 26-44 60 0 21 7 36 7 36l-30 125c-8 37-1 83 0 87 0 3 4 4 5 2 2-3 32-39 42-75l16-64c8 16 31 29 56 29 74 0 124-67 124-157 0-69-58-132-146-132z" fill="#fff"/></svg><span>Pinterest</span></a></p><p><input class="fancybox-share__input" type="text" value="{{url_raw}}" onclick="select()"></p></div>`;
      tpl=tpl.replace(/\{\{desc\}\}/g,encodeURIComponent(desc)).replace(/\{\{url\}\}/g,encodeURIComponent(url)).replace(/\{\{url_raw\}\}/g,escapeHtml(url));
      $.fancybox.open({
        src:tpl,
        type:"html",
        opts:{
          touch:false,
          animationEffect:true,
          afterLoad:function(shareInstance,shareCurrent){
            shareCurrent.$content.find(".fancybox-share__button").click(function(){
              window.open(this.href,"Share","width=550,height=450");
              return false;
            });
          },
          mobile:{
            autoFocus:false
          }
        }
      });
    });
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
<?php if($config['options'][28]==1){?>
  clippy.load({name: '<?php echo$config['seoKeywords']==''?'Clippy':$config['seoKeywords'];?>', path: 'core/js/clippy/agents/'}, function(agent){
    agent.show();
<?php
    if(isset($clippy)){
      foreach($clippy as $clip){
        echo$clip;
      }
    }?>

    $('.saveall').click(function(){
      if($(this).hasClass('btn-danger')){
        agent.stop();
        agent.play('Save');
      }
    });

    $('.print').click(function(){
      agent.stop();
      agent.play('Print');
    });

    $('.email').click(function(){
      agent.stop();
      agent.play('SendMail');
    });

    $('.archive').click(function(){
      agent.stop();
      agent.play('Save');
    });

    $('.purge').click(function(){
      agent.stop();
      agent.play('EmptyTrash');
    });

    var agentRestore=0;
    $('.restore').mouseover(function(){
      if(agentRestore==0){
        agent.stop();
        agent.speak(`The Restore button will revert changed content back to what it was before this activity was recorded.\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B`);
        agentRestore=1;
        setTimeout(function(){
          agentRestore=0;
        }, 1200000);
      }
    });

    $("#seoTitle").click(function(){
      agent.stop();
      agent.stopCurrent();
      var text=$(this).val();
      if(text.length == 0){
        agent.speak("It is best to not leave the SEO Title empty, this is the text used for the Title of your pages, and should contain Keywords related to the page content, and recommended to be about 70 characters long.\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B");
      }
      if(text.length < 70 && text.length !=0){
        agent.speak("Remember to use Keywords that are relevant to the content of the page, and try not to exceed the 70 characters suggested length.\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B")
      }
      if(text.length > 70){
        agent.speak("You have exceeded the recommended character length of 70 characters. Remember to include keywords relevant to the page they title is for.\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B")
      }
      agent.play("Writing");
    });
    $("#seoDescription").click(function(){
      agent.stop();
      agent.stopCurrent();
      var text=$(this).val();
      if(text.length == 0){
        agent.speak("It is best to not leave the SEO Description empty, this is the text used for the Description of your pages, which Google will hopefully use for your search description, and should contain Keywords related to the page, and is recommended to be about 160 characters long.\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B");
      }
      if(text.length < 160 && text.length !=0){
        agent.speak("Use Keywords that are relevant to the content of the page, and remember this is what we hope Google will use in the search description for the page in it's results, and try not exceed the 160 character length recommendation.\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B")
      }
      if(text.length > 160){
        agent.speak("You have exceeded the recommended character length of 160 characters. Remember to use relevant keywords to the page, and hope that Google will use this in it's search results.\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B")
      }
      agent.play("Writing");
    });
<?php
$seoarr='';
if($view=='content'||$view=='pages'&&$args[0]=='edit'){
  $sc=$db->prepare("SELECT * FROM `".$prefix."seo` WHERE `contentType`=:cT ORDER BY rand() LIMIT 1,10");
  $sc->execute([':cT'=>'clippy']);
  if($sc->rowCount()>0){
    while($rc=$sc->fetch(PDO::FETCH_ASSOC)){
      echo'var seo'.$rc['id'].' = function(){'.
        ($rc['type']!='none'&&$rc['title']=='before'?'agent.play(`'.$rc['type'].'`);':'').
        'agent.speak("SEO Tip: '.addslashes(html_entity_decode(str_replace(['&#39;'],["'"],$rc['notes']))).' Click <a href=\"#\" data-fancybox data-type=\"ajax\" data-src=\"core/seolist.php\">here</a> for more tips.\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B\u2006\u200B");'.
        ($rc['type']!='none'&&$rc['title']=='after'?'agent.play(`'.$rc['type'].'`);':'').
      '};';
      $seoarr.='seo'.$rc['id'].',';
    }
  }
}else{?>
    $("#at").change(function(){
      agent.stop();
      agent.stopCurrent();
      agent.play($("#at").val());
    });
<?php }?>
    var animate1 = function(){
      agent.play('Pleased');
      agent.speak("Hmmm.... yes indeed.");
    }

    var animate2 = function(){
      agent.play('Hearing_1');
    }

    var animate3 = function(){
      agent.play('CheckingSomething');
    }

    var animate4 = function(){
      agent.play('EmptyTrash');
    }

    var animate4 = function(){
      agent.play('GetAttention');
    }

    var animate4 = function(){
      agent.play('GetTechy');
    }

    var animate5 = function(){
      agent.play('GetWizardly');
    }

    var animate6 = function(){
      agent.play('IdleRopePile');
    }

    var animate7 = function(){
      agent.play('IdleSnooze');
    }

    var animate8 = function(){
      agent.play('Searching');
    }

    var arr = [
<?php echo$seoarr;?>
      animate1,
      animate2,
      animate3,
      animate4,
      animate5,
      animate6,
      animate7,
      animate8,
    ];

    window.setInterval(function(){
      var fun = arr[Math.floor(Math.random()*arr.length)];
      fun();
    }, 60000);
  });
<?php }?>
</script>
    <iframe id="sp" name="sp" class="d-none"></iframe>
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
