<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add List
 * @package    core/add_list.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`='1'")->fetch(PDO::FETCH_ASSOC);
if((!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')||$_SERVER['SERVER_PORT']==443){
  if(!defined('PROTOCOL'))define('PROTOCOL','https://');
}else{
  if(!defined('PROTOCOL'))define('PROTOCOL','http://');
}
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
$rid=filter_input(INPUT_POST,'rid',FILTER_UNSAFE_RAW);
$lh=filter_input(INPUT_POST,'lh',FILTER_UNSAFE_RAW);
$li1=filter_input(INPUT_POST,'li',FILTER_UNSAFE_RAW);
$li2=filter_input(INPUT_POST,'li2',FILTER_UNSAFE_RAW);
$li3=filter_input(INPUT_POST,'li3',FILTER_UNSAFE_RAW);
$li4=filter_input(INPUT_POST,'li4',FILTER_UNSAFE_RAW);
$lu=filter_input(INPUT_POST,'lu',FILTER_UNSAFE_RAW);
$lda=filter_input(INPUT_POST,'lda',FILTER_UNSAFE_RAW);
$ti=time();
if($lda=='')echo'<script>window.top.window.toastr["error"]("The Notes field must contain data!");</script>';
else{
	$q=$db->prepare("INSERT IGNORE INTO `".$prefix."content` (`rid`,`contentType`,`title`,`urlSlug`,`notes`,`ti`) VALUES (:rid,'list',:title,:url,:notes,:ti)");
	$q->execute([
		':rid'=>$rid,
		':title'=>$lh,
		':url'=>$lu,
		':notes'=>$lda,
		':ti'=>$ti
	]);
	$id=$db->lastInsertId();
	$e=$db->errorInfo();
	if(is_null($e[2])){
    $media=0;
		$s=$db->prepare("UPDATE `".$prefix."content` SET `ord`=:id WHERE `id`=:id");
		$s->execute([':id'=>$id]);
    if($li1!=''){
      if(stristr($li1,'youtu')){
        preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#",$li1,$vidMatch);
        $thumb='https://i.ytimg.com/vi/'.$vidMatch[0].'/maxresdefault.jpg';
      }elseif(stristr($li1,'vimeo')){
        preg_match('/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/',$li1,$vidMatch);
        $thumb='https://vumbnail.com/'.$vidMatch[5].'.jpg';
      }else
        $thumb=$li1;
      $s1=$db->prepare("INSERT IGNORE INTO `".$prefix."media` (`rid`,`pid`,`file`,`thumb`,`ti`) VALUES (:rid,:pid,:file,:thumb,:ti)");
      $s1->execute([
        ':rid'=>$id,
        ':pid'=>$id,
        ':file'=>$li1,
        ':thumb'=>$thumb,
        ':ti'=>$ti
      ]);
      $media=1;
    }
    if($li2!=''){
      if(stristr($li2,'youtu')){
        preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#",$li2,$vidMatch);
        $thumb='https://i.ytimg.com/vi/'.$vidMatch[0].'/maxresdefault.jpg';
      }elseif(stristr($li2,'vimeo')){
        preg_match('/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/',$li2,$vidMatch);
        $thumb='https://vumbnail.com/'.$vidMatch[5].'.jpg';
      }else
        $thumb=$li2;
      $s2=$db->prepare("INSERT IGNORE INTO `".$prefix."media` (`rid`,`pid`,`file`,`thumb`,`ti`) VALUES (:rid,:pid,:file,:thumb,:ti)");
      $s2->execute([
        ':rid'=>$id,
        ':pid'=>$id,
        ':file'=>$li2,
        ':thumb'=>$thumb,
        ':ti'=>$ti
      ]);
      $media=2;
    }
    if($li3!=''){
      if(stristr($li3,'youtu')){
        preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#",$li3,$vidMatch);
        $thumb='https://i.ytimg.com/vi/'.$vidMatch[0].'/maxresdefault.jpg';
      }elseif(stristr($li3,'vimeo')){
        preg_match('/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/',$li3,$vidMatch);
        $thumb='https://vumbnail.com/'.$vidMatch[5].'.jpg';
      }else
        $thumb=$li3;
      $s3=$db->prepare("INSERT IGNORE INTO `".$prefix."media` (`rid`,`pid`,`file`,`thumb`,`ti`) VALUES (:rid,:pid,:file,:thumb,:ti)");
      $s3->execute([
        ':rid'=>$id,
        ':pid'=>$id,
        ':file'=>$li3,
        ':thumb'=>$thumb,
        ':ti'=>$ti
      ]);
      $media=3;
    }
    if($li4!=''){
      if(stristr($li4,'youtu')){
        preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#",$li4,$vidMatch);
        $thumb='https://i.ytimg.com/vi/'.$vidMatch[0].'/maxresdefault.jpg';
      }elseif(stristr($li4,'vimeo')){
        preg_match('/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/',$li1,$vidMatch);
        $thumb='https://vumbnail.com/'.$vidMatch[5].'.jpg';
      }else
        $thumb=$li4;
      $s4=$db->prepare("INSERT IGNORE INTO `".$prefix."media` (`rid`,`pid`,`file`,`thumb`,`ti`) VALUES (:rid,:pid,:file,:thumb,:ti)");
      $s4->execute([
        ':rid'=>$id,
        ':pid'=>$id,
        ':file'=>$li4,
        ':thumb'=>$thumb,
        ':ti'=>$ti
      ]);
      $media=4;
    }
    echo'<script>'.
			'window.top.window.$("#list").append(`<div id="l_'.$id.'" class="card col-12 mx-0 my-1 m-sm-1 overflow-visible add-item">'.
				'<div class="row">'.
          '<div class="col-12 col-sm-3 list-images-'.$media.' overflow-hidden">';
          if($li1!=''){
            if(stristr($li1,'youtu')){
              preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#",$li1,$vidMatch);
              echo'<div class="note-video-wrapper video" data-fancybox="list" href="'.$li1.'" data-fancybox-plyr data-embed="https://www.youtube.com/embed/'.$vidMatch[0].'">'.
                '<img class="note-video-clip" src="https://i.ytimg.com/vi/'.$vidMatch[0].'/maxresdefault.jpg">'.
                '<div class="play"></div>'.
              '</div>';
            }elseif(stristr($li1,'vimeo')){
              preg_match('/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/',$li1,$vidMatch);
              echo'<div class="note-video-wrapper video" data-fancybox="list" href="'.$li1.'" data-fancybox-plyr data-embed="https://vimeo.com/'.$vidMatch[5].'">'.
                '<img class="note-video-clip" src="https://vumbnail.com/'.$vidMatch[5].'.jpg">'.
                '<div class="play"></div>'.
              '</div>';
            }else
              echo'<a data-fancybox="list" href="'.$li1.'"><img src="'.$li1.'" alt="'.$lh.'"></a>';
          }
          if($li2!=''){
            if(stristr($li2,'youtu')){
              preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#",$li2,$vidMatch);
              echo'<div class="note-video-wrapper video" data-fancybox="facts" href="'.$li2.'" data-fancybox-plyr data-embed="https://www.youtube.com/embed/'.$vidMatch[0].'">'.
                '<img class="note-video-clip" src="https://i.ytimg.com/vi/'.$vidMatch[0].'/maxresdefault.jpg">'.
                '<div class="play"></div>'.
              '</div>';
            }elseif(stristr($li2,'vimeo')){
              preg_match('/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/',$li2,$vidMatch);
              echo'<div class="note-video-wrapper video" data-fancybox="facts" href="'.$li2.'" data-fancybox-plyr data-embed="https://vimeo.com/'.$vidMatch[5].'">'.
                '<img class="note-video-clip" src="https://vumbnail.com/'.$vidMatch[5].'.jpg">'.
                '<div class="play"></div>'.
              '</div>';
            }else
              echo'<a data-fancybox="list" href="'.$li2.'"><img src="'.$li2.'" alt="'.$lh.'"></a>';
          }
          if($li3!=''){
            if(stristr($li3,'youtu')){
              preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#",$li3,$vidMatch);
              echo'<div class="note-video-wrapper video" data-fancybox="facts" href="'.$li3.'" data-fancybox-plyr data-embed="https://www.youtube.com/embed/'.$vidMatch[0].'">'.
                '<img class="note-video-clip" src="https://i.ytimg.com/vi/'.$vidMatch[0].'/maxresdefault.jpg">'.
                '<div class="play"></div>'.
              '</div>';
            }elseif(stristr($li3,'vimeo')){
              preg_match('/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/',$li3,$vidMatch);
              echo'<div class="note-video-wrapper video" data-fancybox="facts" href="'.$li3.'" data-fancybox-plyr data-embed="https://vimeo.com/'.$vidMatch[5].'">'.
                '<img class="note-video-clip" src="https://vumbnail.com/'.$vidMatch[5].'.jpg">'.
                '<div class="play"></div>'.
              '</div>';
            }else
              echo'<a data-fancybox="list" href="'.$li3.'"><img src="'.$li3.'" alt="'.$lh.'"></a>';
          }
          if($li4!=''){
            if(stristr($li4,'youtu')){
              preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#",$li4,$vidMatch);
              echo'<div class="note-video-wrapper video" data-fancybox="list" href="'.$li4.'" data-fancybox-plyr data-embed="https://www.youtube.com/embed/'.$vidMatch[0].'">'.
                '<img class="note-video-clip" src="https://i.ytimg.com/vi/'.$vidMatch[0].'/maxresdefault.jpg">'.
                '<div class="play"></div>'.
              '</div>';
            }elseif(stristr($li4,'vimeo')){
              preg_match('/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/',$li4,$vidMatch);
              echo'<div class="note-video-wrapper video" data-fancybox="list" href="'.$li4.'" data-fancybox-plyr data-embed="https://vimeo.com/'.$vidMatch[5].'">'.
                '<img class="note-video-clip" src="https://vumbnail.com/'.$vidMatch[5].'.jpg">'.
                '<div class="play"></div>'.
              '</div>';
            }else
              echo'<a data-fancybox="list" href="'.$li4.'"><img src="'.$li4.'" alt="'.$lh.'"></a>';
          }
          echo'</div>'.
					'<div class="card-footer col-12 col-sm m-0 p-1">'.
						'<div class="row m-0 p-0">'.
							'<div class="col-12 small m-0 p-0">'.
								($lh!=''?'<div class="h6 col-12">'.$lh.'</div>':'').
								$lda.
								($lu!=''?' <a target="_blank" href="'.$lu.'">More...</a>':'').
							'</div>'.
							'<div class="col-12 text-right">'.
								'<a class="btn" href="'.URL.$settings['system']['admin'].'/content/edit/'.$id.'" role="button" data-tooltip="tooltip" aria-label="Edit"><i class="i">edit</i></a>'.
								'<form class="d-inline" target="sp" action="core/purge.php">'.
									'<input name="id" type="hidden" value="'.$id.'">'.
									'<input name="t" type="hidden" value="content">'.
									'<button class="btn trash" data-tooltip="tooltip" aria-label="Delete"><i class="i">trash</i></button>'.
								'</form>'.
								'<span class="btn orderhandle" data-tooltip="tooltip" aria-label="Drag to Reorder"><i class="i">drag</i></span>'.
							'</div>'.
						'</div>'.
					'</div>'.
				'</div>'.
			'</div>`);'.
      'window.top.window.toastr["success"]("'.$lh.' added!")'.
		'</script>';
	}else echo'<script>window.top.window.toastr["error"]("There was an issue adding the Data!");</script>';
}
