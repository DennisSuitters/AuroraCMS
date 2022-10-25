<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Meta-Footer
 * @package    core/layout/meta_footer.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.19
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
      if($('#sidebar').hasClass('navsmall')){
        Cookies.set('sidebar','small');
        if($(window).width() < 577){
          $(this).attr('aria-expanded','true');
        }else{
          $(this).attr('aria-expanded','false');
        }
      }else{
        Cookies.remove('sidebar');
        if($(window).width() < 577){
          $(this).attr('aria-expanded','false');
        }else{
          $(this).attr('aria-expanded','true');
        }
      }
      return false;
    }
  );
  if ($(window).width() < 577) {
    $('.nav-toggle').attr('aria-expanded','false');
  }
  var unsaved=false;
  window.onbeforeunload=function(e){
    if(unsaved)return'You have unsaved changes. Do you want to leave this page and discard your changes or stay on this page?';
  }
  <?php if($config['idleTime']!=0){?>
    $(document).ready(function(){
      idleTimer=null;
      idleState=false;
      idleWait=<?=$config['idleTime']*60000;?>;
      $(document).on('mousemove scroll keyup keypress mousedown mouseup mouseover',function(){
        clearTimeout(idleTimer);
        idleState=false;
        idleTimer=setTimeout(function(){
          idleState=true;
          unsaved=false;
          document.location.href="<?= URL.$settings['system']['admin'].'/logout';?>";
        },idleWait);
      });
      $("body").trigger("mousemove");
      $('select[name="colorpicker"]').simplecolorpicker({theme: 'regularfont'});
    });
  <?php }?>
  $('#seoTitle').keyup(function(){
  	var length=$(this).val().length;
  	var max=70;
  	$("#seoTitlecnt").text(length);
    $('#google-title').text($(this).val());
  	if(length<50){
  		$("#seoTitlecnt").addClass('text-danger');
  	}else if(length>max){
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
  	$("#seoDescriptioncnt").text(length);
    $('#google-description').text($(this).val());
  	if(length<50){
  		$("#seoDescriptioncnt").addClass('text-danger');
  	}else if(length>max){
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
      $('#save'+c).removeClass('addedtrash');
      if($('.unsaved').length===0)$('.saveall').removeClass('addedtrash');
      unsaved=false;
      $('#sp').html(msg);
    });
	 	return false;
	});
  <?php  if(
    (isset($args[0])&&($args[0]=='edit'||$args[0]=='compose'||$args[0]=='reply'||$args[0]=='settings'||$args[0]=='security'))
    ||
    (isset($args[0])&&($view=='content'||$view=='course'||$view=='accounts'||$view=='orders'||$view=='bookings'||$view=='newsletters'||$view=='messages'&&$args[0]=='settings'||$args[0]=='view'))
  ){?>
      function elfinderDialog(id,t,c){
        var fm=$('<div class="shadow light"/>').dialogelfinder({
          url:"<?= URL.'core/elfinder/php/connector.php';?>?id="+id+"&t="+t+"&c="+c,
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
                $('#save'+c).addClass('addedtrash');
              }
              if(t=='content'&&c=='file'){
                var thumb=file.url.replace(/^.*[\\\/]/, '');
                var thumbpath=file.url.replace(thumb,'')+"sm/"+thumb;
                $('#thumb').val(thumbpath);
                $('#thumbimage').attr('src',thumbpath);
                $('#savethumb').addClass('addedtrash');
              }
              if(t=='content'&&c=='fileDepth'){
                $('#savefileDepth').addClass('addedtrash');
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
                var filename="file";
                var fileExtCheck=fileExt.toLowerCase();
                if(fileExtCheck=="jpg"||fileExtCheck=="jpeg"||fileExtCheck=="png"||fileExtCheck=="gif"||fileExtCheck=="bmp"||fileExtCheck=="webp"||fileExtCheck=="svg"){
                  filename=file.url;
                }
                if(fileExtCheck=="pdf"){
                  filename='file-pdf';
                }
                if(fileExtCheck=="zip"||fileExtCheck=="zipx"||fileExtCheck=="tar"||fileExtCheck=="gz"||fileExtCheck=="rar"||fileExtCheck=="7zip"||fileExtCheck=="7z"||fileExtCheck=="bz2"){
                  filename='file-archive';
                }
                if(fileExtCheck=="doc"||fileExtCheck=="docx"||fileExtCheck=="xls"){
                  filename="file-docs";
                }
                var timestamp = $.now();
                $('#attachments').append('<div id="a_'+timestamp+'" class="form-row mt-1"><i class="i i-5x">filename</i><div class="input-text col-12"><a target="_blank" href="'+file.url+'" aria-label="'+file.url.replace(/^.*[\\\/]/,'')+'">'+file.url.replace(/^.*[\\\/]/,'')+'</a></div><button class="trash" onclick="attRemove(\''+timestamp+'\');return false;"><i class="i">trash</i></button></div>');
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
      if(($view=='seo'||$view=='media'||isset($args[0])&&$args[0]=='security')||($view=='accounts'||$view=='orders'||$view=='bookings'&&isset($args[0])&&$args[0]=='settings')){?>
        $().ready(function(){
          var fm=$('#elfinder').elfinder({
            url:"<?= URL.'core/elfinder/php/connector.php';?>",
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
      <?php if(isset($args[0])&&($args[0]=='settings'||$args[0]=='edit'||$args[0]=='compose'||$args[0]=='reply')||($view=='accounts'||$view=='course'||$view=='orders'||$view=='bookings'||$view=='newsletters'||$view=='messages')){?>
        $('.summernote').summernote({
          codemirror:{
            lineNumbers:true,
            lineWrapping:true,
            theme:'base16-dark',
          },
          isNotSplitEdgePoint:true,
          stickyToolbar: true,
          tabsize:2,
          disableUpload:true,
          fileExplorer:'elfinderDialog',
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
            ['custom',['findnreplace'<?=$view=='newsletters'?",'pageTemplates'":"";?>]],
//            ['custom',['cleaner','findnreplace']],
//            ['style',['style']],
            ['font',['bold','italic','underline','clear']],
            ['para',['ul','ol','paragraph']],
            ['table',['table']],
            ['insert',['picture','video','audio','link','hr','checkbox']],
            ['view',['fullscreen','codeview']],
            ['help',['help']]
          ],
<?php if($view=='newsletters'){?>
          pageTemplates: {
            icon: '<i class="note-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14" width="12" height="12"><path d="m 10,10.696915 -6,0 0,-1.071288 6,0 z m -0.00114,-1.9788834 -2.3368368,0 0,-1.0712886 2.3368368,0 z m 0,-1.9759562 -2.3368368,0 0,-1.071288 2.3368368,0 z m -3.3029604,1.9759562 -2.6958966,0 0,-3.0472086 2.6958966,0 z M 7.640148,1.26517 C 7.49432,1.11934 7.20625,1 7,1 L 2.5,1 C 2.29375,1 2.125,1.16875 2.125,1.375 l 0,11.25 C 2.125,12.83125 2.29375,13 2.5,13 l 9,0 c 0.20625,0 0.375,-0.16875 0.375,-0.375 l 0,-6.75 c 0,-0.20625 -0.11932,-0.49432 -0.265148,-0.64015 L 7.640148,1.26517 Z M 11.125,12.25 l -8.25,0 0,-10.5 4.115133,0 c 0.03417,0.006 0.09853,0.0323 0.12668,0.0525 l 3.955734,3.95571 c 0.02018,0.0281 0.04683,0.0925 0.05245,0.12668 l 0,6.36513 z M 11.5,1 9.25,1 C 9.04375,1 8.99432,1.11932 9.140148,1.26515 l 2.46968,2.46968 C 11.75568,3.88068 11.875,3.83125 11.875,3.625 l 0,-2.25 C 11.875,1.16875 11.70625,1 11.5,1 Z"/></svg></i>',
            insertDetails: true,
            dateFormat:    'longDate',
            yourName:      '<?=$user['name'];?>',
            yourTitle:     'Your Title',
            yourCompany:   '<?=$config['business'];?>',
            yourPhone:     '<?=$config['phone'];?>',
            yourAddress:   '<?=$config['address'];?>',
            yourCity:      '<?=$config['city'];?>',
            yourState:     '<?=$config['state'];?>',
            yourCountry:   '<?=$config['country'];?>',
            yourPostcode:  '<?=$config['postcode'];?>',
            yourEmail:     '<?=$config['email'];?>',
<?php if(file_exists('layout/'.$config['theme'].'/images/newsletterslogo.png'))
  $newsletterslogo=URL.'layout/'.$config['theme'].'/images/newsletterslogo.png';
elseif(file_exists('layout/.'.$config['theme'].'/images/newsletterslogo.jpg'))
  $newsletterslogo=URL.'layout/'.$config['theme'].'/images/newsletterslogo.jpg';
else
  $newsletterslogo='';?>
            logoImage:     '<?=$newsletterslogo;?>',
            siteLink:      '<?= URL;?>',
            socialLinkFacebook: 'https://facebook.com/',
            socialLinkTwitter: 'https://twitter.com/',
            socialLinkEmail: 'example@example.com/',
            socialLinkLinkedIn: 'https://linkedin.com/',
            templates:     '../summernote-templates/page-templates/',
            cssFile:       '<?= URL.'layout/'.$config['theme'].'/css/newsletter.css';?>'
          },
<?php }?>
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
              $('.saveall').removeClass('addedtrash');
              unsaved=false;
            });
            $('#save'+c).removeClass('addedtrash');
            if($('.unsaved').length===0)$('.page-block').removeClass('d-block');
          },1000);
        }
      });
      function delay(time){
        return new Promise(resolve => setTimeout(resolve,time));
      }
      $(".trashall").on({
        click:function(event){
          event.preventDefault();
          $('.page-block').addClass('d-block');
          var total=$('#l_tracker').data("dbtot");
          let i=1;
          let trackelements=document.getElementsByClassName('findtracker');
          for(const element of trackelements){
            var id=$(element).data("dbid");
            purge(id,'tracker');
            delay(1000);
            i++;
            if(i===total)break;
          };
          $('.page-block').removeClass('d-block');
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
          $('#save'+save).addClass('addedtrash');
          console.log('keypress');
//          if($('#qesave'+save).length > 0){
            $('#qesave'+save).addClass('addedtrash');
//          }
          $('.saveall').addClass('addedtrash');
          $('#'+save).addClass('unsaved');
          unsaved=true;
          if(event.which==13){
            event.preventDefault();
          }
        },
        change:function(event){
          var save=$(this).data("dbc");
          $('#'+save).addClass('unsaved');
          $('#save'+save).addClass('addedtrash');
          console.log('change');
//          if($('#qesave'+save).length > 0){
            $('#qesave'+save).addClass('addedtrash');
//          }
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
    			var t=$(this).data("dbt");
    			var c=$(this).data("dbc");
    			var b=$(this).data("dbb");
          $('#'+t+c+b+id).parent().find(".dot-pulse").remove();
          $('#'+t+c+b+id).append(`<div class="dot-pulse"></div>`);
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
            $('#'+t+c+b+id).parent().find(".dot-pulse").remove();
        });
    	}
    );
    if($('.tab-control').length>0){
      $('.tab-control').on('click',function(){
        var tab=$(this).attr('id');
        window.location.hash=tab;
      });
      if(location.href.indexOf("#")!= -1){
        var tab=window.location.hash.substr(1);
        if(tab!=''){
          if(!tab.includes("tab")){
            var clo=document.getElementById(tab);
            var tab=clo.closest("[data-tabid]").dataset.tabid;
          }
          var cbarray=document.getElementsByName('tabs');
          for(var i=0;i<cbarray.length;i++){
            cbarray[i].checked=false;
          }
          document.getElementById(tab).checked=true;
        }else{
          document.getElementById('tab1-1').checked=true;
        }
      }else{
        if(document.getElementById('tab1-1')){
          document.getElementById('tab1-1').checked=true;
        }
      }
    }
    setInterval(function(){
      $.get("<?= URL;?>core/nav-stats.php",{},function(results){
        var stats=results.split(",");
        var navStat=$('#nav-stat').html();
        var stats=results.split(",");
        var navStat=$('#nav-stat').html();
        if(stats[0]==0)stats[0]='';
        var stathtml='<li class="dropdown-heading py-2">Notifications</li>';
        if(stats[3]>0)stathtml+='<li><a href="<?= URL.$settings['system']['admin'];?>/comments"><span class="badger badge-primary mr-2">'+stats[3]+'</span>Comments</a></li>';
        if(stats[4]>0)stathtml+='<li><a href="<?= URL.$settings['system']['admin'];?>/reviews"><span class="badger badge-primary mr-2">'+stats[4]+'</span>Reviews</a></li>';
        if(stats[5]>0)stathtml+='<li><a href="<?= URL.$settings['system']['admin'];?>/messages"><span class="badger badge-primary mr-2">'+stats[5]+'</span>Messages</a></li>';
        if(stats[6]>0)stathtml+='<li><a href="<?= URL.$settings['system']['admin'];?>/orders/pending"><span class="badger badge-primary mr-2">'+stats[6]+'</span>Orders</a></li>';
        if(stats[7]>0)stathtml+='<li><a href="<?= URL.$settings['system']['admin'];?>/bookings"><span class="badger badge-primary mr-2">'+stats[7]+'</span>Bookings</a></li>';
        if(stats[8]>0)stathtml+='<li><a href="<?= URL.$settings['system']['admin'];?>/accounts"><span class="badger badge-primary mr-2">'+stats[8]+'</span>Users</a></li>';
        if(stats[9]>0)stathtml+='<li><a href="<?= URL.$settings['system']['admin'];?>/content/type/testimonials"><span class="badger badge-primary mr-2">'+stats[9]+'</span>Testimonials</a></li>';
        if(stats[2]>0)stathtml+='<li><a href="<?= URL.$settings['system']['admin'];?>/accounts"><span class="badger badge-primary mr-2">'+stats[2]+'</span>Active Users</a></li>';
        $('#nav-stat').attr('data-badge',stats[0]);
        $('#nav-stat-list').html(stathtml);
        if(stats[1]==0){
          document.title='<?=$config['business']!=''?$config['business']:'';?> Administration';
        }
        if(stats[0]>0)document.title='('+stats[0]+') <?=$config['business']!=''?$config['business']:'';?> Administration';
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
<?php if($view=='dashboard'&&$user['accountsContact']==1&&$config['hosterURL']!=''){?>
    <script>
      $(document).ready(function(){
        $.getJSON('<?=$config['hosterURL'];?>core/hostinginfo.php?h=<?=$user['infoHash'];?>',function(data){
          var html=(data.hostStatus=='overdue'?'<div class="alert alert-danger shake-horizontal">Hosting was Due <strong>'+data.hostDays+'</strong> days ago.</div></div>':'')+
          (data.hostStatus=='outstanding'?'<div class="alert alert-warning">Hosting Payment is currently Outstanding, due in <strong>'+data.hostDays+'</strong> days.</div>':'')+
          (data.hostStatus=='paid'?'<div class="alert alert-success">Hosting is due in <strong>'+data.hostDays+'</strong> days.</div>':'')+
          (data.siteStatus=='overdue'?'<div class="alert alert-'+(data.siteDate!=0?'danger':'info')+'">Outstanding Site Payment Left <strong>$'+data.siteCost+'</strong>.'+(data.siteDate!=0?'<br>Final Payment was Due on <strong>'+data.siteDate+'</strong>.':''):'');
          if(html!=''){
            $("#hostinginfo").html(html);
          }
        });
      });
    </script>
<?php }?>
  </body>
</html>
