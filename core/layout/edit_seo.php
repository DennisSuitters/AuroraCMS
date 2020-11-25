<?php
/**
 * AurouraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Edit - SEO
 * @package    core/layout/edit_seo.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.1
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
$s=$db->prepare("SELECT * FROM `".$prefix."seo` WHERE `id`=:id");
$s->execute([
	':id'=>$id
]);
$r=$s->fetch(PDO::FETCH_ASSOC);?>
<div class="fancybox-ajax">
	<h6 class="bg-dark p-2">Edit SEO Information</h6>
	<div class="m-3">
		<label for="title">Title</label>
		<div class="form-row mb-5">
		  <input class="textinput2" id="title" data-dbid="<?php echo$r['id'];?>" data-dbt="seo" data-dbc="title" type="text" value="<?php echo$r['title'];?>" placeholder="Enter a Title...">
		  <button class="save2" id="savetitle" data-dbid="title" data-style="zoom-in" data-tooltip="tooltip" data-title="Save" aria-label="Save"><?php svg('save');?></button>
		</div>
		<form class="w-100" target="sp" method="post" action="core/update.php">
		  <input name="id" type="hidden" value="<?php echo$r['id'];?>">
		  <input name="t" type="hidden" value="seo">
		  <input name="c" type="hidden" value="notes">
		  <textarea class="summernote" id="notes" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="notes" name="da" readonly><?php echo$r['notes'];?></textarea>
		  </form>
		</div>
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
