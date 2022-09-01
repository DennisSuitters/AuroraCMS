<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Courses
 * @package    core/view/courses.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.18
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$rank=0;
$show='';
$currentPassCSS=$matchPassCSS='';
$currentPassHidden=$matchPassHidden=$successHidden=$success=$theme['settings']['hidden'];
$successShow=$theme['settings']['show'];
if(isset($args[1])&&$args[1]=='redo'){
	$sqm=$db->prepare("DELETE FROM `".$prefix."moduleQuestionsTrack` WHERE `uid`=:uid AND `cid`=:cid");
	$sqm->execute([
		':uid'=>$user['id'],
		':cid'=>$args[0]
	]);
	unset($args[1]);
}
if((isset($_SESSION['loggedin'])&&$_SESSION['loggedin']==true)&&(isset($user)&&$user['rank']>0)){
	$html=preg_replace([
		'/<print page=[\"\']?heading[\"\']?>/',
	  '/<print page=[\"\']?notes[\"\']?>/',
		$page['notes']!=''?'/<[\/]?pagenotes>/':'~<pagenotes>.*?<\/pagenotes>~is'
	],[
		htmlspecialchars(($page['heading']==''?$page['seoTitle']:$page['heading']),ENT_QUOTES,'UTF-8'),
	  $page['notes'],
		''
	],$html);
	if(!isset($args[0])){
		preg_match('/<items>([\w\W]*?)<\/items>/',$html,$match);
		$items=$match[1];
		$output='';
		$sc=$db->prepare("SELECT * FROM `".$prefix."courseTrack` WHERE `uid`=:uid");
		$sc->execute([':uid'=>$user['id']]);
		while($rc=$sc->fetch(PDO::FETCH_ASSOC)){
			$scc=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `id`=:id ORDER BY `ti` DESC");
			$scc->execute([':id'=>$rc['rid']]);
			$rcc=$scc->fetch(PDO::FETCH_ASSOC);
			$mcs=$db->prepare("SELECT COUNT(`id`) AS `cnt` FROM `".$prefix."modules` WHERE `id` < :id");
			$mcs->execute([':id'=>$rc['complete']]);
			$rcs=$mcs->fetch(PDO::FETCH_ASSOC);
			$snext=$db->prepare("SELECT `id` FROM `".$prefix."modules` WHERE `rid`=:rid AND `id`>:id ORDER BY `ord` ASC LIMIT 1");
			$snext->execute([
				':rid'=>$rc['rid'],
				':id'=>$rc['complete']
			]);
			$next=$snext->fetch(PDO::FETCH_ASSOC);
			$smc=$db->prepare("SELECT COUNT(`id`) AS `cnt` FROM `".$prefix."modules` WHERE `rid`=:rid");
			$smc->execute([':rid'=>$rc['rid']]);
			$rmc=$smc->fetch(PDO::FETCH_ASSOC);
			$out='';
			$out=preg_replace([
				'/<print course=[\"\']?thumb[\"\']?>/',
				'/<print course=[\"\']?image[\"\']?>/',
				'/<print course=[\"\']?imageALT[\"\']?>/',
				'/<print course=[\"\']?title[\"\']?>/',
				'/<print course=[\"\']?progress[\"\']?>/',
				'/<print continueLink>/',
				'/<print continue>/',
				'/<print module=[\"\']?id[\"\']?>/'
			],[
				($rcc['thumb']!=''&&file_exists('media/sm/'.basename($rcc['thumb']))?'media/sm/'.basename($rcc['thumb']):NOIMAGESM),
				'', // image
				$rcc['title'],
				$rcc['title'],
				$rc['complete']=='done'?'Complete<br>Score '.$rc['score'].'%':($mcs->rowCount()>0?$rc['progress'].' of '.$rmc['cnt'].' Modules Complete':'Not Started'),
				$rc['complete']=='done'?URL.'courses/'.$rc['id'].'/assessment':($snext->rowCount()>0?URL.'courses/'.$rc['id'].'/'.$next['id']:URL.'courses/'.$rc['id']),
				'<button type="submit">'.($rc['complete']=='done'?'View Assessment':($rc['complete']!=''?'Continue Course':'Start Course')).'</button>',
				$next['id']
			],$items);
			$output.=$out;
		}
		$html=preg_replace([
			'~<assessment>.*?<\/assessment>~is',
			'~<item>.*?<\/item>~is',
			'/<[\/]?contentitems>/',
			'~<items>.*?<\/items>~is'
		],[
			'',
			'',
			'',
			$output
		],$html);
	}
	if(isset($args[1])&&$args[1]=='assessment'){
		$moduleQuestions='';
		$score=0;
		$qcount=0;
		$sc=$db->prepare("SELECT * FROM `".$prefix."courseTrack` WHERE `id`=:id");
		$sc->execute([':id'=>$args[0]]);
		$rc=$sc->fetch(PDO::FETCH_ASSOC);
		$sm=$db->prepare("SELECT * FROM `".$prefix."modules` WHERE `rid`=:rid ORDER BY `ord` ASC");
		$sm->execute([':rid'=>$rc['rid']]);
		if($sm->rowCount()>0){
			while($rm=$sm->fetch(PDO::FETCH_ASSOC)){
				$smq=$db->prepare("SELECT * FROM `".$prefix."moduleQuestions` WHERE `rid`=:rid ORDER BY `ord` ASC");
				$smq->execute([':rid'=>$rm['id']]);
				if($smq->rowCount()>0){
					$moduleQuestions.='<div class="h4">Module - '.$rm['title'].'</div>';
				}
				while($rq=$smq->fetch(PDO::FETCH_ASSOC)){
					if($rq['check_answer']==1)$qcount++;
					$smqt=$db->prepare("SELECT * FROM `".$prefix."moduleQuestionsTrack` WHERE `uid`=:uid AND `mid`=:mid AND `qid`=:qid");
					$smqt->execute([
						':uid'=>$user['id'],
						':mid'=>$rm['id'],
						':qid'=>$rq['id']
					]);
					$moduleQuestions.='<ol>'.
						'<li>'.$rq['title'];
						if($smqt->rowCount()==1){
							$moduleQuestions.=' - '.($rq['check_answer']==1?'<span class="text-success">Correct</span>':'<span class="text-danger">Incorrect</span>');
							if($rq['check_answer']==1)$score++;
						}
						$moduleQuestions.='</li>'.
					'</ol>';
				}
			}
		}
		$html=preg_replace([
			'/<moduleQuestions>/',
			$moduleQuestions==''?'~<questions>.*?<\/questions>~is':'/<[\/]?questions>/'
		],[
			$moduleQuestions,
			''
		],$html);
		$totalscore=($score / $qcount) * 100;
		$sc=$db->prepare("UPDATE `".$prefix."courseTrack` SET `complete`='done', `score`=:score, `attempts`=GREATEST(0, `attempts` - 1) WHERE `id`=:id");
		$sc->execute([
			':id'=>$args[0],
			':score'=>$totalscore
		]);
		$scc=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `id`=:rid");
		$scc->execute([':rid'=>$rc['rid']]);
		$rcc=$scc->fetch(PDO::FETCH_ASSOC);
		$html=preg_replace([
			'~<item>.*?<\/item>~is',
			'~<contentitems>.*?<\/contentitems>~is',
			'/<[\/]?assessment>/',
			$totalscore>$rcc['rating']?'~<fail>.*?<\/fail>~is':'/<[\/]?fail>/',
			$totalscore>$rcc['rating']?'/<[\/]?success>/':'~<success>.*?<\/success>~is',
			'/<[\/]?score>/',
			'/<print viewCertificate>/',
			'/<print course=[\"\']?score[\"\']?>/',
			'/<print course=[\"\']?minscore[\"\']?>/',
			'/<print course=[\"\']?attempts[\"\']?>/'
		],[
			'',
			'',
			'',
			'',
			'',
			'',
			URL.'core/view_certificate.php?id='.$rc['rid'].'&uid='.$user['id'],
			$totalscore.'%',
			$rcc['rating'].'%',
			$rc['attempts']!=0?'However, you have '.$rc['attempts'].' attempts left.<br><br>Click <a href="'.URL.'courses/'.$rc['id'].'/redo">here</a> to try again.':'Unfortunately you have no more attempts left'
		],$html);
	}elseif(isset($args[0])){
		$act=isset($_POST['act'])?$_POST['act']:'';
		if(isset($_POST['cid']))$args[0]=$_POST['cid'];
		if(isset($_POST['nid']))$args[1]=$_POST['nid'];
		$mid=isset($_POST['mid'])?$_POST['mid']:'';
		if($act=='questions'){
			$q=isset($_POST['q'])?$_POST['q']:'';
			if(isset($q)&&count($q)>0){
				for($i=0;$i<count($q);$i++){
					$sq=$db->prepare("INSERT IGNORE INTO `".$prefix."moduleQuestionsTrack` (`uid`,`cid`,`mid`,`qid`) VALUES (:uid,:cid,:mid,:qid)");
					$sq->execute([
						':uid'=>$user['id'],
						':cid'=>$args[0],
						':mid'=>$mid,
						':qid'=>$q[$i]
					]);
				}
			}
		}
		$sc=$db->prepare("SELECT * FROM `".$prefix."courseTrack` WHERE `id`=:id AND `uid`=:uid");
		$sc->execute([
			':id'=>$args[0],
			':uid'=>$user['id']
		]);
		$rc=$sc->fetch(PDO::FETCH_ASSOC);
		$scc=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `id`=:id");
		$scc->execute([':id'=>$rc['rid']]);
		$rcc=$scc->fetch(PDO::FETCH_ASSOC);
		if(isset($args[1])){
			$sm=$db->prepare("SELECT * FROM `".$prefix."modules` WHERE `id`=:id");
			$sm->execute([':id'=>$args[1]]);
			$rm=$sm->fetch(PDO::FETCH_ASSOC);
			$progress=$rc['progress'] + 1;
		}else{
			$sm=$db->prepare("SELECT * FROM `".$prefix."modules` WHERE `rid`=:rid ORDER BY `ord` ASC");
			$sm->execute([':rid'=>$rc['rid']]);
			$rm=$sm->fetch(PDO::FETCH_ASSOC);
			$progress=0;
		}
		$sq=$db->prepare("UPDATE `".$prefix."courseTrack` SET `complete`=:mid, `progress`=:progress WHERE `id`=:id");
		$sq->execute([
			':id'=>$args[0],
			':mid'=>$mid,
			':progress'=>$progress
		]);
		$snext=$db->prepare("SELECT * FROM `".$prefix."modules` WHERE `rid`=:rid AND `id`>:id ORDER BY `ord` ASC LIMIT 1");
		$snext->execute([
			':rid'=>$rcc['id'],
			':id'=>isset($args[1])?$args[1]:$rm['id']
		]);
		$next=$snext->fetch(PDO::FETCH_ASSOC);
		$questions='';
		$sq=$db->prepare("SELECT * FROM `".$prefix."moduleQuestions` WHERE `rid`=:rid ORDER BY `ord` ASC");
		$sq->execute([':rid'=>isset($args[1])?$args[1]:$rm['id']]);
		while($rq=$sq->fetch(PDO::FETCH_ASSOC)){
			$questions.=
				'<div class="row">'.
					'<div class="col-12">'.
						'<input class="module-check" id="q'.$rq['id'].'" type="'.$rq['type'].'" name="q[]" value="'.$rq['id'].'">'.
						'<label class="ml-3" for="q'.$rq['id'].'">'.$rq['title'].'</label>'.
					'</div>'.
				'</div>';
		}
		$html=preg_replace([
			'~<contentitems>.*?<\/contentitems>~is',
			'~<assessment>.*?<\/assessment>~is',
			'/<[\/]?item>/',
			'/<print course=[\"\']?heading[\"\']?>/',
			'/<print course=[\"\']?title[\"\']?>/',
			'/<print course=[\"\']?notes[\"\']?>/',
			'/<print course=[\"\']?id[\"\']?>/',
			'/<print module=[\"\']?id[\"\']?>/',
			'/<print course=[\"\']?url[\"\']?>/',
			'/<print module=[\"\']?question[\"\']?>/',
			$sq->rowCount()>0?'/<[\/]?questions>/':'~<questions>.*?<\/questions>~is',
			'/<questionitems>/',
			$sq->rowCount()>0?'~<nextmodule>.*?<\/nextmodule>~is':'/<[\/]?nextmodule>/',
			'/<print module=[\"\']?nextid[\"\']?>/',
			'/<print module=[\"\']?nexttitle[\"\']?>/'
		],[
			'',
			'',
			'',
			$rcc['title'],
			$rm['title'],
			$rm['notes'],
			$rc['id'],
			$rm['id'],
			URL.'courses/'.$rc['id'].'/',
			$rm['question'],
			'',
			$questions,
			'',
			$next['id']!=''?$next['id']:'assessment',
			$next['id']!=''?'Proceed to Module '.$next['title']:'Proceed to Assessment'
		],$html);
	}
}else{
	if(file_exists(THEME.'/noaccess.html'))
		$html=file_get_contents(THEME.'/noaccess.html');
}
$content.=$html;
