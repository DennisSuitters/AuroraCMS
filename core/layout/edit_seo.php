<?php
/**
 * AurouraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Edit - SEO
 * @package    core/layout/edit_seo.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.17
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(!defined('DS'))define('DS',DIRECTORY_SEPARATOR);
$getcfg=true;
require_once'..'.DS.'db.php';
function svg($svg,$class=null,$size=null){
	echo'<i class="i'.($size!=null?' i-'.$size:'').($class!=null?' '.$class:'').'">'.file_get_contents('..'.DS.'images'.DS.'i-'.$svg.'.svg').'</i>';
}
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$s=$db->prepare("SELECT * FROM `".$prefix."seo` WHERE id=:id");
$s->execute([':id'=>$id]);
$r=$s->fetch(PDO::FETCH_ASSOC);?>
<div class="form-group row">
  <label for="title" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Title</label>
  <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
    <input type="text" id="title" class="form-control textinput2" value="<?php echo$r['title'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="seo" data-dbc="title" placeholder="Enter a Title...">
    <div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="savetitle" class="btn btn-secondary save2" data-dbid="title" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
  </div>
</div>
<div class="form-group row">
  <div class="input-group col-12">
    <form target="sp" method="POST" action="core/update.php" class="w-100">
      <input type="hidden" name="id" value="<?php echo$r['id'];?>">
      <input type="hidden" name="t" value="seo">
      <input type="hidden" name="c" value="notes">
      <textarea id="notes" class="form-control summernote" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="notes" name="da" readonly><?php echo$r['notes'];?></textarea>
    </form>
  </div>
</div>
<script>
  $('.summernote').summernote({
    codemirror:{
      lineNumbers:true,
      lineWrapping:true,
      theme:'base16-dark',
    },
    isNotSplitEdgePoint:true,
    height: 280,
    tabsize:2,
    toolbar:
      [
        ['save',['save']],
        ['style',['style']],
        ['font',['bold','italic','underline','clear']],
        ['para',['ul','ol','paragraph']],
        ['table',['table']],
        ['insert',['video','link','hr']],
        ['view',['fullscreen','codeview']],
        ['help',['help']]
      ],
      callbacks:{
        onInit:function(){
        	$('body > .note-popover').appendTo(".note-editing-area");
        }
      }
  });
  $('.save2').click(function(e){
	 	e.preventDefault();
	 	var l=Ladda.create(this);
    var el=$(this).data("dbid");
    var id=$('#'+el).data("dbid"),
        t=$('#'+el).data("dbt"),
        c=$('#'+el).data("dbc"),
        da=$('#'+el).val();
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
  $(".textinput2").on({
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
</script>
