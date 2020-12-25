<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Brand Option
 * @package    core/add_brand.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.0
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`='1'")->fetch(PDO::FETCH_ASSOC);
function svg2($svg,$class=null,$size=null){
	return'<i class="i'.($size!=null?' i-'.$size:'').($class!=null?' '.$class:'').'">'.file_get_contents('images/i-'.$svg.'.svg').'</i>';
}
$at=filter_var($_POST['at'],FILTER_SANITIZE_STRING);
$w=filter_input(INPUT_POST,'w',FILTER_SANITIZE_STRING);
$ci=isset($_POST['ci'])?filter_input(INPUT_POST,'ci',FILTER_SANITIZE_STRING):'';
if($ci!=''){
  $s=$db->prepare("INSERT IGNORE INTO `".$prefix."seo` (`contentType`,`type`,`title`,`notes`) VALUES ('clippy',:at,:w,:ci)");
  $s->execute([
		':at'=>$at,
		':w'=>$w,
		':ci'=>$ci
	]);
  $id=$db->lastInsertId();
	echo'<script>'.
				'window.top.window.$("#clippyseo").append(`'.
					'<div id="l_'.$id.'">'.
						'<div class="row" id="l_'.$id.'">'.
							'<div class="col-12 col-md-6">'.
								'<label for="at'.$id.'">Animation Type </label>'.
								'<div class="form-row">'.
									'<select id="at'.$id.'" onchange="update(`'.$id.'`,`seo`,`type`,$(this).val());">'.
										'<option value="none"'.($at=='none'?' selected':'').'>No Animation</option>'.
										'<option value="Alert"'.($at=='Alert'?' selected':'').'>Alert</option>'.
										'<option value="CheckingSomething"'.($at=='CheckingSomething'?' selected':'').'>Checking Something</option>'.
										'<option value="EmptyTrash"'.($at=='EmptyTrash'?' selected':'').'>Empty Trash</option>'.
										'<option value="Explain"'.($at=='Explain'?' selected':'').'>Explain</option>'.
										'<option value="GestureDown"'.($at=='GestureDown'?' selected':'').'>Gesture Down</option>'.
										'<option value="GestureLeft"'.($at=='GestureLeft'?' selected':'').'>Gesture Left</option>'.
										'<option value="GestureRight"'.($at=='GestureRight'?' selected':'').'>Gesture Right</option>'.
										'<option value="GestureUp"'.($at=='GestureUp'?' selected':'').'>Gesture Up</option>'.
										'<option value="GetArtsy"'.($at=='GetArtsy'?' selected':'').'>Get Artsy</option>'.
										'<option value="GetAttention"'.($at=='GetAttention'?' selected':'').'>Get Attention</option>'.
										'<option value="GetTechy"'.($at=='GetTechy'?' selected':'').'>Get Techy</option>'.
										'<option value="GetWizardly"'.($at=='GetWizardly'?' selected':'').'>Get Wizardly</option>'.
										'<option value="GoodBye"'.($at=='GoodBye'?' selected':'').'>Goodbye</option>'.
										'<option value="Greeting"'.($at=='Greeting'?' selected':'').'>Greeting</option>'.
										'<option value="Hearing_1"'.($at=='Hearing_1'?' selected':'').'>Hearing</option>'.
										'<option value="Hide"'.($at=='Hide'?' selected':'').'>Hide</option>'.
										'<option value="Idle_1"'.($at=='Idle_1'?' selected':'').'>Idle</option>'.
										'<option value="IdleAtom"'.($at=='IdleAtom'?' selected':'').'>Idle Atom</option>'.
										'<option value="IdleEyeBrowRaise"'.($at=='IdleEyeBrowRaise'?' selected':'').'>Idle Eyebrow Raise</option>'.
										'<option value="IdleFingerTap"'.($at=='IdleFingerTap'?' selected':'').'>Idle Finger Tap</option>'.
										'<option value="IdleHeadScratch"'.($at=='IdleHeadScratch'?' selected':'').'>Idle Head Scratch</option>'.
										'<option value="IdleRopePile"'.($at=='IdleRopePile'?' selected':'').'>Idle Rope Pile</option>'.
										'<option value="IdleSideToSide"'.($at=='IdleSideToSide'?' selected':'').'>Idle Side To Side</option>'.
										'<option value="IdleSnooze"'.($at=='IdleSnooze'?' selected':'').'>Idle Snooze</option>'.
										'<option value="LookDown"'.($at=='LookDown'?' selected':'').'>Look Down</option>'.
										'<option value="LookDownLeft"'.($at=='LookDownLeft'?' selected':'').'>Look Down Left</option>'.
										'<option value="LookDownRight"'.($at=='LookDownRight'?' selected':'').'>Look Down Right</option>'.
										'<option value="LookLeft"'.($at=='LookLeft'?' selected':'').'>Look Left</option>'.
										'<option value="LookRight"'.($at=='LookRight'?' selected':'').'>Look Right</option>'.
										'<option value="LookUp"'.($at=='LookUp'?' selected':'').'>Look Up</option>'.
										'<option value="LookUpLeft"'.($at=='LookUpLeft'?' selected':'').'>Look Up Left</option>'.
										'<option value="LookUpRight"'.($at=='LookUpRight'?' selected':'').'>Look Up Right</option>'.
										'<option value="Print"'.($at=='Print'?' selected':'').'>Print</option>'.
										'<option value="Processing"'.($at=='Processing'?' selected':'').'>Processing</option>'.
										'<option value="RestPose"'.($at=='RestPose'?' selected':'').'>Rest Pose</option>'.
										'<option value="Save"'.($at=='Save'?' selected':'').'>Save</option>'.
										'<option value="Searching"'.($at=='Searching'?' selected':'').'>Searching</option>'.
										'<option value="SendMail"'.($at=='SendMail'?' selected':'').'>Send Mail</option>'.
										'<option value="Show"'.($at=='Show'?' selected':'').'>Show</option>'.
										'<option value="Thinking"'.($at=='Thinking'?' selected':'').'>Thinking</option>'.
										'<option value="Wave"'.($at=='Wave'?' selected':'').'>Wave</option>'.
										'<option value="Writing"'.($at=='Writing'?' selected':'').'>Writing</option>'.
									'</select>'.
								'</div>'.
							'</div>'.
							'<div class="col-12 col-md-6">'.
								'<label for="when'.$id.'">Before or After</label>'.
								'<div class="form-row">'.
									'<select id="when'.$id.'" onchange="update(`'.$id.'`,`seo`,`title`,$(this).val());">'.
										'<option value="before"'.($w=='before'?' selected':'').'>Before</option>'.
										'<option value="after"'.($w=='after'?' selected':'').'>After</option>'.
									'</select>'.
								'</div>'.
							'</div>'.
						'</div>'.
						'<div class="row">'.
							'<div class="col-12">'.
								'<div class="form-row">'.
									'<input id="info'.$id.'" name="info" value="'.$ci.'" readonly>'.
									'<form target="sp" action="core/purge.php">'.
										'<input name="id" type="hidden" value="'.$id.'">'.
										'<input name="t" type="hidden" value="seo">'.
										'<button class="trash" data-tooltip="tooltip" type="submit" aria-label="Delete">'.svg2('trash').'</button>'.
									'</form>'.
								'</div>'.
							'</div>'.
						'</div>'.
						'<hr>'.
					'</div>'.
				'`);'.
			'</script>';
}else
	echo'<script>window.top.window.toastr["error"]("No Text was entered");</script>';
