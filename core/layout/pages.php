<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Pages
 * @package    core/layout/pages.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$rank=0;
$show='pages';
if($args[0]=='add'){
  $ti=time();
  $q=$db->prepare("INSERT INTO `".$prefix."menu` (uid,mid,login_user,title,seoTitle,file,contentType,schemaType,menu,active,ord,eti) VALUES (:uid,'0',:login_user,:title,'','page','page','Article','other','0',:ord,:eti)");
  $q->execute([':uid'=>$user['id'],':login_user'=>(isset($user['name'])?$user['name']:$user['username']),':title'=>'New Page '.$ti.'',':ord'=>$ti,':eti'=>$ti]);
  $id=$db->lastInsertId();
  $rank=0;
  $args[0]='edit';
  $args[1]=$id;?>
<script>history.replaceState('','','<?php echo URL.$settings['system']['admin'].'/pages/edit/'.$args[1];?>');</script>
<?php
}
if($args[0]=='settings')
  include'core'.DS.'layout'.DS.'set_pages.php';
else{
  if($args[0]=='edit')$show='item';
  if($show=='pages'){?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/content';?>">Content</a></li>
    <li class="breadcrumb-item active">Pages</li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group">
        <a class="btn btn-ghost-normal add" href="<?php echo URL.$settings['system']['admin'].'/pages/add';?>" data-tooltip="tooltip" data-placement="left" title="Add" aria-label="Add"><?php svg('add');?></a>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <small class="help-block">Pages can be dragged to change their order.</small>
        <table class="table table-responsive-sm table-sm table-hover">
          <thead>
            <tr>
              <th class="col">
                Title<small class="float-right">Submenu Title</small>
              </th>
              <th class="col-1 text-center">Menu</th>
              <th class="col text-center"><span class="d-inline">Views&nbsp;</span><button class="btn btn-secondary btn-xs trash d-inline" onclick="$('[data-views=\'views\']').text('0');purge('0','pageviews');" data-tooltip="tooltip" title="Clear All" aria-label="Clear All"><?php svg('eraser');?></button></th>
              <th class="col-1 text-center">Active</th>
              <th class="col-2"></th>
            </tr>
          </thead>
          <tbody id="sortable">
<?php $s=$db->prepare("SELECT * FROM `".$prefix."menu` WHERE mid=0 ORDER BY ord ASC");
$s->execute();
while($r=$s->fetch(PDO::FETCH_ASSOC)){
  $ss=$db->prepare("SELECT COUNT(id) as cnt FROM `".$prefix."suggestions` WHERE rid=:id");
  $ss->execute([':id'=>$r['id']]);
  $rs=$ss->fetch(PDO::FETCH_ASSOC);?>
            <tr id="l_<?php echo$r['id'];?>" class="item subsortable">
              <td>
                <a href="<?php echo URL.$settings['system']['admin'].'/pages/edit/'.$r['id'];?>"><?php echo$r['title'];?></a>
                <?php echo$rs['cnt']>0?'<span data-tooltip="tooltip" title="Editing Suggestions" aria-label="Editing Suggestions">'.svg2('lightbulb').'</span>':'';
$sm=$db->prepare("SELECT id,title,contentType,views FROM `".$prefix."menu` WHERE mid!=0 AND mid=:mid ORDER BY ord ASC");
  $sm->execute([':mid'=>$r['id']]);
  while($rm=$sm->fetch(PDO::FETCH_ASSOC)){?>
                <small id="s_<?php echo$rm['id'];?>" class="sub help-block zebra float-right">
                  <a href="<?php echo URL.$settings['system']['admin'].'/pages/edit/'.$rm['id'];?>"><?php echo$rm['title'];?></a>
                  <span id="controls_<?php echo$rm['id'];?>" class="text-right" role="group">
                    <button class="btn btn-secondary dark btn-sm trash" onclick="$('#views<?php echo$rm['id'];?>').text('0');update('<?php echo$rm['id'];?>','menu','views','0');" data-tooltip="tooltip" title="Clear" aria-label="Clear"><?php svg('eraser');?> <span id="views<?php echo$rm['id'];?>"><?php echo$rm['views'];?></span></button>
                    <a class="btn btn-secondary btn-sm" href="<?php echo URL.$settings['system']['admin'].'/pages/edit/'.$rm['id'];?>" data-tooltip="tooltip" title="Edit" aria-label="Edit"><?php svg('edit');?></a>
                    <?php echo$rm['contentType']=='page'?'<button class="btn btn-secondary btn-sm trash" onclick="purge(\''.$rm['id'].'\',\'menu\')" data-tooltip="tooltip" title="Delete" aria-label="Delete">'.svg2('trash').'</button>':'';?>
                  </span>
                </small>
                <script>
                  $('#l_<?php echo$r['id'];?>').sortable({
                    items:"small",
                    placeholder:".ghost",
                    helper:fixWidthHelper,
                    axis:"y",
                    update:function(e,ui){
                      var order=$("#l_<?php echo$r['id'];?>").sortable("serialize");
                      $.ajax({
                        type:"POST",
                        dataType:"json",
                        url:"core/reordersub.php",
                        data:order
                      });
                    }
                  }).disableSelection();
                  function fixWidthHelper(e,ui){
                    ui.children().each(function(){
                      $(this).width($(this).width());
                    });
                    return ui;
                  }
                </script>
<?php }?>
              </td>
              <td class="text-center"><?php echo ucfirst($r['menu']);?></td>
              <td class="text-center">
                <button class="btn btn-secondary trash" onclick="$('#views<?php echo$r['id'];?>').text('0');updateButtons('<?php echo$r['id'];?>','menu','views','0');" data-tooltip="tooltip" title="Clear" aria-label="Clear"><?php svg('eraser');?>&nbsp;&nbsp;<span id="views<?php echo$r['id'];?>" data-views="views"><?php echo$r['views'];?></span></button>
              </td>
              <td class="text-center">
                <?php echo$r['contentType']!='index'?'<label class="switch switch-label switch-success"><input type="checkbox" id="active'.$r['id'].'" class="switch-input" data-dbid="'.$r['id'].'" data-dbt="menu" data-dbc="active" data-dbb="0"'.($r['active']==1?' checked aria-checked="true"':' aria-checked="false"').'><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>':'';?>
              </td>
              <td id="controls_<?php echo$r['id'];?>">
                <div class="btn-group float-right">
                  <a class="btn btn-secondary" href="<?php echo URL.$settings['system']['admin'].'/pages/edit/'.$r['id'];?>" data-tooltip="tooltip" title="Edit" aria-label="Edit Page"><?php svg('edit');?></a>
                  <?php echo$r['contentType']=='page'?'<button class="btn btn-secondary btn-sm trash" onclick="purge(\''.$r['id'].'\',\'menu\')" data-tooltip="tooltip" title="Delete" aria-label="Delete">'.svg2('trash').'</button>':'';?>
                </div>
              </td>
            </tr>
<?php }?>
            <tr class="ghost hidden">
              <td colspan="3">&nbsp;</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <script>
    $('#sortable').sortable({
      items:"tr",
      placeholder:".ghost",
      helper:fixWidthHelper,
      axis:"y",
      update:function(e,ui){
        var order=$("#sortable").sortable("serialize");
        $.ajax({
          type:"POST",
          dataType:"json",
          url:"core/reorder.php",
          data:order
        });
      }
    }).disableSelection();
    function fixWidthHelper(e,ui){
      ui.children().each(function(){
        $(this).width($(this).width());
      });
      return ui;
    }
  </script>
</main>
<?php }
}
if($show=='item')
  include'core'.DS.'layout'.DS.'edit_pages.php';
