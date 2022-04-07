<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Quick Edit
 * @package    core/quickedit.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.7
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`='1'")->fetch(PDO::FETCH_ASSOC);
function svg2($svg,$class=null,$size=null){
	return'<i class="i'.($size!=null?' i-'.$size:'').($class!=null?' '.$class:'').'">'.file_get_contents('images/i-'.$svg.'.svg').'</i>';
}
if((!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')||$_SERVER['SERVER_PORT']==443){
  if(!defined('PROTOCOL'))define('PROTOCOL','https://');
}else{
  if(!defined('PROTOCOL'))define('PROTOCOL','http://');
}
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
$rank=isset($_SESSION['rank'])?$_SESSION['rank']:400;
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$t=isset($_POST['t'])?filter_input(INPUT_POST,'t',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'t',FILTER_SANITIZE_STRING);
if($t=='content'||$t=='login'||$t=='orders'){
	$s=$db->prepare("SELECT * FROM `".$prefix.$t."` WHERE id=:id");
	$s->execute([':id'=>$id]);
	$r=$s->fetch(PDO::FETCH_ASSOC);
	if(!isset($r['id']))$r['id']=0;
	if(!isset($r['contentType']))$r['contentType']='';
	if(!isset($r['urlSlug']))$r['urlSlug']='';
	if(!isset($r['ti']))$r['ti']=0;
	if(!isset($r['pti']))$r['pti']=0;
	if(!isset($r['eti']))$r['eti']=0;
	if(!isset($r['status']))$r['status']='';
	if(!isset($r['rank']))$r['rank']=0;

	echo'<td colspan="8">'.
		'<div class="row">'.
	    '<div class="col-12 col-sm-4 p-1">';
		if($t=='login'){
			if($r['name']!=''&&$r['bio_options'][0]==1){
				echo'<div class="row">'.
					'<label for="qeprofilelink'.$r['id'].'">Profile Link</label>'.
					'<div class="form-row">'.
						'<a id="qeprofilelink'.$r['id'].'" target="_blank" href="'.URL.'profile/'.str_replace(' ','-',$r['name']).'">'.URL.'profile/'.str_replace(' ','-',$r['name']).'</a>'.
					'</div>'.
				'</div>';
			}
				echo'<div class="row">'.
					'<div class="col-12 col-sm-6 pr-1">'.
						'<label for="qename'.$r['id'].'">Name</label>'.
						'<div class="form-row">'.
							'<input class="qetextinput" id="qename'.$r['id'].'" data-dbid="'.$r['id'].'" data-dbt="login" data-dbc="name" type="text" value="'.$r['name'].'" placeholder="Enter a Name...">'.
							'<button class="qesave" id="qesavename'.$r['id'].'" data-tooltip="tooltip" data-dbid="qename'.$r['id'].'" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>'.
						'</div>'.
					'</div>'.
					'<div class="col-12 col-sm-6 pl-1">'.
						'<label for="qebusiness'.$r['id'].'">Business</label>'.
						'<div class="form-row">'.
							'<input class="qetextinput" id="qebusiness'.$r['id'].'" data-dbid="'.$r['id'].'" data-dbt="login" data-dbc="business" type="text" value="'.$r['business'].'" placeholder="Enter a Business...">'.
							'<button class="qesave" id="qesavebusiness'.$r['id'].'" data-tooltip="tooltip" data-dbid="qebusiness'.$r['id'].'" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>'.
						'</div>'.
					'</div>'.
				'</div>'.
				'<div class="row">'.
					'<label for="qeemail'.$r['id'].'">Email</label>'.
					'<div class="form-row">'.
						'<div class="input-icon">';
						$sm=$db->prepare("SELECT id FROM `".$prefix."choices` WHERE `contentType`='mailbox'");
						$sm->execute();
						if($sm->rowCount()>0){
							$email=URL.$settings['system']['admin'].'/messages/compose/';
							$emailwin=false;
						}else{
							$email='mailto:';
							$emailwin=true;
						}
							echo'<input class="qetextinput" id="qeemail'.$r['id'].'" type="text" value="'.$r['email'].'" data-dbid="'.$r['id'].'" data-dbt="login" data-dbc="email" placeholder="Enter an Email...">'.
							'<button class="btn-input btn-ghost" data-tooltip="tooltip" aria-label="Send Email" onclick="window.open(`'.$email.'`+$(`#qeemail'.$r['id'].'`).val(),'.($emailwin==true?'`_blank`':'`_self`').');">'.svg2('email-send').'</button>'.
						'</div>'.
						'<button class="qesave" id="qesaveemail'.$r['id'].'" data-tooltip="tooltip" data-dbid="qeemail'.$r['id'].'" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>'.
					'</div>'.
				'</div>'.
				'<div class="row">'.
					'<label for="qeurl'.$r['id'].'">URL</label>'.
					'<div class="form-row">'.
						'<div class="input-icon">'.
							'<input class="qetextinput" id="qeurl'.$r['id'].'" data-dbid="'.$r['id'].'" data-dbt="login" data-dbc="url" type="text" value="'.$r['url'].'" placeholder="Enter a URL...">'.
							'<button class="btn-input btn-ghost" data-tooltip="tooltip" aria-label="Open URL in New Window" onclick="window.open($(`#qeurl'.$r['id'].'`).val(),`_blank`);">'.svg2('new-window').'</button>'.
						'</div>'.
						'<button class="qesave" id="qesaveurl'.$r['id'].'" data-tooltip="tooltip" data-dbid="qeurl'.$r['id'].'" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>'.
					'</div>'.
				'</div>'.
				'<div class="row">'.
					'<div class="col-12 col-sm-6 pr-1">'.
						'<label for="qephone'.$r['id'].'">Phone</label>'.
						'<div class="form-row">'.
							'<input class="qetextinput" id="qephone'.$r['id'].'" data-dbid="'.$r['id'].'" data-dbt="login" data-dbc="phone" type="text" value="'.$r['phone'].'" placeholder="Enter a Phone...">'.
							'<button class="qesave" id="qesavephone'.$r['id'].'" data-tooltip="tooltip" data-dbid="qephone'.$r['id'].'" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>'.
						'</div>'.
					'</div>'.
					'<div class="col-12 col-sm-6 pl-1">'.
						'<label for="qemobile'.$r['id'].'">Mobile</label>'.
						'<div class="form-row">'.
							'<input class="qetextinput" id="qemobile'.$r['id'].'" data-dbid="'.$r['id'].'" data-dbt="login" data-dbc="mobile" type="text" value="'.$r['mobile'].'" placeholder="Enter a Mobile...">'.
							'<button class="save" id="qesavemobile'.$r['id'].'" data-tooltip="tooltip" data-dbid="qemobile'.$r['id'].'" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>'.
						'</div>'.
					'</div>'.
				'</div>';
		}
		if($t=='content'){
	    	echo'<div class="row">'.
	      	'<label for="qegenurl'.$r['id'].'">URL Slug</label>'.
        	'<div class="form-row col-12">'.
          	'<a id="qegenurl'.$r['id'].'" target="_blank" href="'.URL.$r['contentType'].'/'.$r['urlSlug'].'">'.URL.$r['contentType'].'/'.$r['urlSlug'].' '.svg2('new-window').'</a>'.
        	'</div>'.
      	'</div>';
			if($r['contentType']=='inventory'||$r['contentType']=='service'){
				echo'<div class="row">'.
					'<div class="col-6 pr-1">'.
	  				'<label for="qerrp'.$r['id'].'" data-tooltip="tooltip" aria-label="Recommended Retail Price">RRP</label>'.
	  				'<div class="form-row">'.
	    				'<div class="input-text">$</div>'.
	  					'<input class="qetextinput" id="qerrp'.$r['id'].'" data-dbid="'.$r['id'].'" data-dbt="content" data-dbc="rrp" type="text" value="'.$r['rrp'].'">'.
	  					'<button class="qesave" id="qesaverrp'.$r['id'].'" data-tooltip="tooltip" data-dbid="qerrp'.$r['id'].'" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>'.
						'</div>'.
					'</div>'.
					'<div class="col-6 pl-1">'.
						'<label for="qecost'.$r['id'].'">Cost</label>'.
	  				'<div class="form-row">'.
	    				'<div class="input-text">$</div>'.
	    				'<input class="qetextinput" id="qecost'.$r['id'].'" data-dbid="'.$r['id'].'" data-dbt="content" data-dbc="cost" type="text" value="'.$r['cost'].'" placeholder="Enter a Cost...">'.
	    				'<button class="qesave" id="qesavecost'.$r['id'].'" data-tooltip="tooltip" data-dbid="qecost'.$r['id'].'" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>'.
	  				'</div>'.
					'</div>'.
				'</div>'.
				'<div class="row">'.
					'<div class="col-6 pr-1">'.
	  				'<label for="qerCost'.$r['id'].'">Reduced Cost</label>'.
	  				'<div class="form-row">'.
	    				'<div class="input-text">$</div>'.
	    				'<input class="qetextinput" id="qerCost'.$r['id'].'" data-dbid="'.$r['id'].'" data-dbt="content" data-dbc="rCost" type="text" value="'.$r['rCost'].'" placeholder="Enter a Reduced Cost...">'.
	    				'<button class="qesave" id="qesaverCost'.$r['id'].'" data-tooltip="tooltip" data-dbid="qerCost'.$r['id'].'" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>'.
	  				'</div>'.
					'</div>'.
					'<div class="col-6 pl-1">'.
	  				'<label for="qedCost'.$r['id'].'">Distributor Cost</label>'.
	  				'<div class="form-row">'.
	    				'<div class="input-text">$</div>'.
	    				'<input class="qetextinput" id="qedCost'.$r['id'].'" data-dbid="'.$r['id'].'" data-dbt="content" data-dbc="dCost" type="text" value="'.$r['dCost'].'" placeholder="Enter a Distributor Cost...">'.
	    				'<button class="qesave" id="qesavedCost'.$r['id'].'" data-tooltip="tooltip" data-dbid="qedCost'.$r['id'].'" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>'.
	  				'</div>'.
					'</div>'.
				'</div>';
			}
			if($r['contentType']=='inventory'){
				echo'<div class="row">'.
					'<label for="qequantity'.$r['id'].'">Quantity</label>'.
					'<div class="form-row">'.
	  				'<input class="qetextinput" id="qequantity'.$r['id'].'" data-dbid="'.$r['id'].'" data-dbt="content" data-dbc="quantity" type="text" value="'.$r['quantity'].'">'.
	  				'<button class="qesave" id="qesavequantity'.$r['id'].'" data-tooltip="tooltip" data-dbid="qequantity'.$r['id'].'" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>'.
					'</div>'.
				'</div>'.
				'<div class="row">'.
					'<label for="qestockStatus'.$r['id'].'">Stock Status</label>'.
					'<select id="qestockStatus'.$r['id'].'" onchange="update(`'.$r['id'].'`,`content`,`stockStatus`,$(this).val());">'.
	  				'<option value="quantity"'.($r['stockStatus']=='quantity'?' selected':'').'>Dependant on Quantity (In Stock/Out Of Stock)</option>'.
	  				'<option value="in stock"'.($r['stockStatus']=='in stock'?' selected':'').'>In Stock</option>'.
	  				'<option value="out of stock"'.($r['stockStatus']=='out of stock'?' selected':'').'>Out Of Stock</option>'.
						'<option value="back order"'.($r['stockStatus']=='back order'?' selected':'').'>Back Order</option>'.
	  				'<option value="pre order"'.($r['stockStatus']=='pre order'?' selected':'').'>Pre Order</option>'.
	  				'<option value="available"'.($r['stockStatus']=='available'?' selected':'').'>Available</option>'.
	  				'<option value="sold out"'.($r['stockStatus']=='sold out'?' selected':'').'>Sold Out</option>'.
	  				'<option value="none"'.($r['stockStatus']=='none'||$r['stockStatus']==''?' selected':'').'>No Display</option>'.
					'</select>'.
				'</div>';
			}
		}
	    echo'</div>'.
	    '<div class="col-12 col-sm-4 p-1">';
		if($t=='content'){
			if($r['contentType']=='events'){
	    	echo'<div class="row">'.
	      	'<label for="qetis'.$r['id'].'">Event Start <span class="labeldate small ml-2" id="labeldatetis'.$r['id'].'">('.date($config['dateFormat'],$r['tis']).')</span></label>'.
	      	'<input id="qetis'.$r['id'].'" type="datetime-local" value="'.($r['tis']!=0?date('Y-m-d\TH:i',$r['tis']):'').'" autocomplete="off" onchange="update(`'.$r['id'].'`,`content`,`tis`,getTimestamp(`qetis'.$r['id'].'`));">'.
	    	'</div>'.
	    	'<div class="row">'.
	      	'<label for="qetie'.$r['id'].'">Event End <span class="labeldate small ml-2" id="labeldatetie'.$r['id'].'">('.date($config['dateFormat'],$r['tie']).')</span></label>'.
	      	'<input id="qetie'.$r['id'].'" type="datetime-local" value="'.($r['tie']!=0?date('Y-m-d\TH:i',$r['tie']):'').'" autocomplete="off" onchange="update(`'.$r['id'].'`,`content`,`tie`,getTimestamp(`qetie'.$r['id'].'`));">'.
	    	'</div>';
			}
			if($r['contentType']=='article'||$r['contentType']=='portfolio'||$r['contentType']=='news'||$r['contentType']=='inventory'||$r['contentType']=='service'){
	    	echo'<div class="row">'.
	        '<label for="qecategory_1'.$r['id'].'">Category One</label>'.
	        '<div class="form-row">'.
	          '<input class="qetextinput" id="qecategory_1'.$r['id'].'" data-dbid="'.$r['id'].'" data-dbt="content" data-dbc="category_1" type="text" value="'.$r['category_1'].'">'.
	          '<button class="qesave" id="qesavecategory_1'.$r['id'].'" data-tooltip="tooltip" data-dbid="qecategory_1'.$r['id'].'" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>'.
	        '</div>'.
	      '</div>'.
	      '<div class="row">'.
	        '<label for="qecategory_2'.$r['id'].'">Category Two</label>'.
	        '<div class="form-row">'.
	          '<input class="qetextinput" id="qecategory_2'.$r['id'].'" data-dbid="'.$r['id'].'" data-dbt="content" data-dbc="category_2" type="text" value="'.$r['category_2'].'">'.
	          '<button class="qesave" id="qesavecategory_2'.$r['id'].'" data-tooltip="tooltip" data-dbid="qecategory_2'.$r['id'].'" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>'.
	        '</div>'.
	      '</div>'.
	      '<div class="row">'.
	        '<label for="qecategory_3'.$r['id'].'">Category Three</label>'.
	        '<div class="form-row">'.
	          '<input class="qetextinput" id="qecategory_3'.$r['id'].'" data-dbid="'.$r['id'].'" data-dbt="content" data-dbc="category_3" type="text" value="'.$r['category_3'].'">'.
	          '<button class="qesave" id="qesavecategory_3'.$r['id'].'" data-tooltip="tooltip" data-dbid="qecategory_3'.$r['id'].'" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>'.
	        '</div>'.
	      '</div>'.
	      '<div class="row">'.
	        '<label for="qecategory_4'.$r['id'].'">Category Four</label>'.
	        '<div class="form-row">'.
	          '<input class="qetextinput" id="qecategory_4'.$r['id'].'" data-dbid="'.$r['id'].'" data-dbt="content" data-dbc="category_4" type="text" value="'.$r['category_4'].'">'.
	          '<button class="qesave" id="qesavecategory_4'.$r['id'].'" data-tooltip="tooltip" data-dbid="qecategory_4'.$r['id'].'" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>'.
	        '</div>'.
	      '</div>'.
				'<div class="row">'.
					'<label for="qetags'.$r['id'].'">Tags</label>'.
					'<div class="form-row">'.
						'<input class="qetextinput" id="qetags'.$r['id'].'" data-dbid="'.$r['id'].'" data-dbt="'.$t.'" data-dbc="tags" type="text" value="'.$r['tags'].'" placeholder="Enter Tags...">'.
						'<button class="qesave" id="qesavetags'.$r['id'].'" data-tooltip="tooltip" data-dbid="qetags'.$r['id'].'" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>'.
					'</div>';
				$tags=array();
				$st=$db->query("SELECT DISTINCT `tags` FROM `".$prefix."content` WHERE `tags`!='' UNION SELECT DISTINCT `tags` FROM `".$prefix."login` WHERE `tags`!=''");
				if($st->rowCount()>0){
					while($rt=$st->fetch(PDO::FETCH_ASSOC)){
						$tagslist=explode(",",$rt['tags']);
						foreach($tagslist as$ts)$tgs[]=$ts;
					}
				}
				$tags=array_unique($tgs);
				asort($tags);
					echo'<select id="tags_options" onchange="qeaddTag(`'.$r['id'].'`,$(this).val());">'.
							'<option value="none">Clear All</option>';
					foreach($tags as$ts)echo'<option value="'.$ts.'">'.$ts.'</option>';
						echo'</select>'.
					'</div>';
			}
		}
		if($t=='login'){
			echo'<div class="row">'.
				'<label for="qeaddress'.$r['id'].'">Address</label>'.
				'<div class="form-row">'.
					'<input class="qetextinput" id="qeaddress'.$r['id'].'" data-dbid="'.$r['id'].'" data-dbt="login" data-dbc="address" type="text" value="'.$r['address'].'" placeholder="Enter an Address...">'.
					'<button class="qesave" id="qesaveaddress'.$r['id'].'" data-tooltip="tooltip" data-dbid="qeaddress'.$r['id'].'" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>'.
				'</div>'.
			'</div>'.
			'<div class="row">'.
				'<div class="col-12 col-sm-6 pr-1">'.
					'<label for="qesuburb'.$r['id'].'">Suburb</label>'.
					'<div class="form-row">'.
						'<input class="qetextinput" id="qesuburb'.$r['id'].'" data-dbid="'.$r['id'].'" data-dbt="login" data-dbc="suburb" type="text" value="'.$r['suburb'].'" placeholder="Enter a Suburb...">'.
						'<button class="qesave" id="qesavesuburb'.$r['id'].'" data-tooltip="tooltip" data-dbid="qesuburb'.$r['id'].'" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>'.
					'</div>'.
				'</div>'.
				'<div class="col-12 col-sm-6 pl-1">'.
					'<label for="qecity'.$r['id'].'">City</label>'.
					'<div class="form-row">'.
						'<input class="qetextinput" id="qecity'.$r['id'].'" data-dbid="'.$r['id'].'" data-dbt="login" data-dbc="city" type="text" value="'.$r['city'].'" placeholder="Enter a City...">'.
						'<button class="qesave" id="qesavecity'.$r['id'].'" data-tooltip="tooltip" data-dbid="qecity'.$r['id'].'" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>'.
					'</div>'.
				'</div>'.
			'</div>'.
			'<div class="row">'.
				'<div class="col-12 col-sm-6 pr-1">'.
					'<label for="qestate'.$r['id'].'">State</label>'.
					'<div class="form-row">'.
						'<input class="qetextinput" id="qestate'.$r['id'].'" data-dbid="'.$r['id'].'" data-dbt="login" data-dbc="state" type="text" value="'.$r['state'].'" placeholder="Enter a State...">'.
						'<button class="qesave" id="qesavestate'.$r['id'].'" data-tooltip="tooltip" data-dbid="qestate'.$r['id'].'" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>'.
					'</div>'.
				'</div>'.
				'<div class="col-12 col-sm-6 pl-1">'.
					'<label for="qepostcode'.$r['id'].'">Postcode</label>'.
					'<div class="form-row">'.
						'<input class="qetextinput" id="qepostcode'.$r['id'].'" data-dbid="'.$r['id'].'" data-dbt="login" data-dbc="postcode" type="text" value="'.($r['postcode']!=0?$r['postcode']:'').'" placeholder="Enter a Postcode...">'.
						'<button class="qesave" id="qesavepostcode'.$r['id'].'" data-tooltip="tooltip" data-dbid="qepostcode'.$r['id'].'" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>'.
					'</div>'.
				'</div>'.
			'</div>'.
			'<div class="row">'.
				'<label for="qecountry'.$r['id'].'">Country</label>'.
				'<div class="form-row">'.
					'<input class="qetextinput" id="qecountry'.$r['id'].'" data-dbid="'.$r['id'].'" data-dbt="login" data-dbc="country" type="text" value="'.$r['country'].'" placeholder="Enter a Country...">'.
					'<button class="qesave" id="qesavecountry'.$r['id'].'" data-tooltip="tooltip" data-dbid="qecountry'.$r['id'].'" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>'.
				'</div>'.
			'</div>'.
			'<div class="row">'.
				'<label for="qetags'.$r['id'].'">Tags</label>'.
				'<div class="form-row">'.
					'<input class="qetextinput" id="qetags'.$r['id'].'" data-dbid="'.$r['id'].'" data-dbt="'.$t.'" data-dbc="tags" type="text" value="'.$r['tags'].'" placeholder="Enter Tags...">'.
					'<button class="qesave" id="qesavetags'.$r['id'].'" data-tooltip="tooltip" data-dbid="qetags'.$r['id'].'" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>'.
				'</div>';
			$tags=array();
			$st=$db->query("SELECT DISTINCT `tags` FROM `".$prefix."content` WHERE `tags`!='' UNION SELECT DISTINCT `tags` FROM `".$prefix."login` WHERE `tags`!=''");
			if($st->rowCount()>0){
				while($rt=$st->fetch(PDO::FETCH_ASSOC)){
					$tagslist=explode(",",$rt['tags']);
					foreach($tagslist as$ts)$tgs[]=$ts;
				}
			}
			$tags=array_unique($tgs);
			asort($tags);
				echo'<select id="tags_options" onchange="qeaddTag(`'.$r['id'].'`,$(this).val());">'.
						'<option value="none">Clear All</option>';
				foreach($tags as$ts)echo'<option value="'.$ts.'">'.$ts.'</option>';
					echo'</select>'.
	    	'</div>';
			}
			echo'</div>'.
	    '<div class="col-12 col-sm-4 p-1">';
		if($t=='content'){
				echo'<div class="row">'.
	        '<label for="qeti'.$r['id'].'">Created</label>'.
	        '<input id="qeti'.$r['id'].'" type="text" value="'.date($config['dateFormat'],$r['ti']).'" readonly>'.
	      '</div>'.
	      '<div class="row">'.
	        '<label for="qepti'.$r['id'].'">Published On <span class="labeldate small ml-2" id="labeldatepti'.$r['id'].'">('.date($config['dateFormat'],$r['pti']).')</span></label>'.
	        '<input id="qepti'.$r['id'].'" type="datetime-local" value="'.date('Y-m-d\TH:i',$r['pti']).'" autocomplete="off" onchange="update(`'.$r['id'].'`,`content`,`pti`,getTimestamp(`qepti'.$r['id'].'`));">'.
	      '</div>'.
	      '<div class="row">'.
	        '<label for="qestatus'.$r['id'].'">Status</label>'.
	        '<select id="qestatus'.$r['id'].'" onchange="update(`'.$r['id'].'`,`content`,`status`,$(this).val());statusSet(`'.$r['id'].'`,$(this).val());">'.
	          '<option value="unpublished"'.($r['status']=='unpublished'?' selected':'').'>Unpublished</option>'.
	          '<option value="autopublish"'.($r['status']=='autopublish'?' selected':'').'>AutoPublish</option>'.
	          '<option value="published"'.($r['status']=='published'?' selected':'').'>Published</option>'.
	          '<option value="delete"'.($r['status']=='delete'?' selected':'').'>Delete</option>'.
	          '<option value="archived"'.($r['status']=='archived'?' selected':'').'>Archived</option>'.
	        '</select>'.
	      '</div>'.
	      '<div class="row">'.
	        '<label for="qerank'.$r['id'].'">Access</label>'.
	        '<select id="qerank'.$r['id'].'" onchange="update(`'.$r['id'].'`,`content`,`rank`,$(this).val());$(`#rank'.$r['id'].'`).html($(this).find(`:selected`).text());">'.
	          '<option value="0"'.($r['rank']==0?' selected':'').'>Available to Everyone</option>'.
	          '<option value="100"'.($r['rank']==100?' selected':'').'>Available to Subscriber and Above</option>'.
	          '<option value="200"'.($r['rank']==200?' selected':'').'>Available to Member and Above</option>'.
						'<option value="200"'.($r['rank']==200?' selected':'').'>Available to Member and Above</option>'.
						'<option value="210"'.($r['rank']==210?' selected':'').'>Available to Member Silver and Above</option>'.
						'<option value="220"'.($r['rank']==220?' selected':'').'>Available to Member Bronze and Above</option>'.
						'<option value="230"'.($r['rank']==230?' selected':'').'>Available to Member Gold and Above</option>'.
						'<option value="240"'.($r['rank']==240?' selected':'').'>Available to Member Platinum and Above</option>'.
	          '<option value="300"'.($r['rank']==300?' selected':'').'>Available to Client and Above</option>'.
						'<option value="310"'.($r['rank']==310?' selected':'').'>Available to Wholesaler and Above</option>'.
						'<option value="320"'.($r['rank']==320?' selected':'').'>Available to Wholesaler Bronze and Above</option>'.
	          '<option value="330"'.($r['rank']==330?' selected':'').'>Available to Wholesaler Silver and Above</option>'.
	          '<option value="340"'.($r['rank']==340?' selected':'').'>Available to Wholesaler Gold and Above</option>'.
	          '<option value="350"'.($r['rank']==350?' selected':'').'>Available to Wholesaler Platinum and Above</option>'.
	          '<option value="400"'.($r['rank']==400?' selected':'').'>Available to Contributor and Above</option>'.
	          '<option value="500"'.($r['rank']==500?' selected':'').'>Available to Author and Above</option>'.
	          '<option value="600"'.($r['rank']==600?' selected':'').'>Available to Editor and Above</option>'.
	          '<option value="700"'.($r['rank']==700?' selected':'').'>Available to Moderator and Above</option>'.
	          '<option value="800"'.($r['rank']==800?' selected':'').'>Available to Manager and Above</option>'.
	          '<option value="900"'.($r['rank']==900?' selected':'').'>Available to Administrator and Above</option>'.
	        '</select>'.
	      '</div>'.
	      '<div class="row">'.
	        '<label for="qelastedited'.$r['id'].'">Last Edited</label>'.
	        '<div class="col-12">'.
	          ($r['eti']==0?'Never':date($config['dateFormat'],$r['eti']).' by '.$r['login_user']).
	        '</div>'.
	      '</div>';
		}
		if($t=='login'){
				echo'<div class="row">'.
					'<label for="qeti'.$r['id'].'">Created</label>'.
					'<div class="form-row">'.
						'<input id="qeti'.$r['id'].'" type="text" value="'.date($config['dateFormat'],$r['ti']).'" readonly>'.
					'</div>'.
				'</div>'.
				'<div class="row">'.
					'<label for="qerank'.$r['id'].'">Rank</label>'.
					'<div class="form-row">'.
						'<select id="qerank'.$r['id'].'" data-dbid="'.$r['id'].'" data-dbt="login" data-dbc="rank" onchange="update(`'.$r['id'].'`,`login`,`rank`,$(this).val());$(`#accountrank'.$r['id'].'`).text(rank($(this).val()));$(`#accountrank'.$r['id'].'`).removeClass().addClass(`badger badge-`+rankclass($(this).val()));">'.
							'<option value="0"'.($r['rank']==0?' selected':'').'>Visitor</option>'.
							'<option value="100"'.($r['rank']==100?' selected':'').'>Subscriber</option>'.
							'<option value="200"'.($r['rank']==200?' selected':'').'>Member</option>'.
							'<option value="210"'.($r['rank']==210?' selected':'').'>Member Silver</option>'.
							'<option value="220"'.($r['rank']==220?' selected':'').'>Member Bronze</option>'.
							'<option value="230"'.($r['rank']==230?' selected':'').'>Member Gold</option>'.
							'<option value="240"'.($r['rank']==240?' selected':'').'>Member Platinum</option>'.
							'<option value="300"'.($r['rank']==300?' selected':'').'>Client</option>'.
							'<option value="310"'.($r['rank']==310?' selected':'').'>Wholesaler</option>'.
							'<option value="320"'.($r['rank']==320?' selected':'').'>Wholesaler Bronze</option>'.
							'<option value="330"'.($r['rank']==330?' selected':'').'>Wholesaler Silver</option>'.
							'<option value="340"'.($r['rank']==340?' selected':'').'>Wholesaler Gold</option>'.
							'<option value="350"'.($r['rank']==350?' selected':'').'>Wholesaler Platinum</option>'.
							'<option value="400"'.($r['rank']==400?' selected':'').'>Contributor</option>'.
							'<option value="500"'.($r['rank']==500?' selected':'').'>Author</option>'.
							'<option value="600"'.($r['rank']==600?' selected':'').'>Editor</option>'.
							'<option value="700"'.($r['rank']==700?' selected':'').'>Moderator</option>'.
							'<option value="800"'.($r['rank']==800?' selected':'').'>Manager</option>'.
							'<option value="900"'.($r['rank']==900?' selected':'').'>Administrator</option>'.
							($rank==1000?'<option value="1000"'.($r['rank']==1000?' selected':'').'>Developer</option>':'').
						'</select>'.
					'</div>'.
				'</div>'.
				'<div id="aWT'.$r['id'].'" class="row'.($r['rank']<301||$r['rank']>399?' d-none':'').'">'.
					'<input id="accountWholesaler'.$r['id'].'" data-dbid="'.$r['id'].'" data-dbt="login" data-dbc="options" data-dbb="19" type="checkbox"'.($r['options'][19]==1?' checked aria-checked="true"':' aria-checked="false"').' onclick="$(\'#wholesaler'.$r['id'].'\').toggleClass(\'d-none\');">'.
					'<label for="accountWholesaler'.$r['id'].'" id="loginnewsletter0'.$r['id'].'">Wholesaler Accepted to Purchase</label>'.
				'</div>'.
				'<div class="row">'.
					'<label for="qespent'.$r['id'].'">Spent</label>'.
					'<div class="form-row">'.
						'<div class="input-text">$</div>'.
						'<input class="qetextinput" id="qespent'.$r['id'].'" type="number" value="'.$r['spent'].'" data-dbid="'.$r['id'].'" data-dbt="login" data-dbc="spent">'.
						'<button class="qesave" id="qesavespent'.$r['id'].'" data-tooltip="tooltip" data-dbid="qespent'.$r['id'].'" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>'.
					'</div>'.
				'</div>'.
				'<div class="row">'.
					'<label for="qepoints'.$r['id'].'">Points Earned</label>'.
					'<div class="form-row">'.
						'<input class="qetextinput" id="qepoints'.$r['id'].'" type="number" value="'.$r['points'].'" data-dbid="'.$r['id'].'" data-dbt="login" data-dbc="points">'.
						'<button class="qesave" id="qesavepoints'.$r['id'].'" data-tooltip="tooltip" data-dbid="qepoints'.$r['id'].'" data-style="zoom-in" aria-label="Save">'.svg2('save').'</button>'.
					'</div>'.
				'</div>'.
				'<div class="row">'.
					'User is'.($r['newsletter'][0]==1?'':' not').' a Newsletter Subscriber'.
				'</div>'.
				'<div class="row">'.
					'IP: '.$r['userIP'].
				'</div>'.
				'<div class="row">'.
					'Browser Info: '.$r['userAgent'].
				'</div>';
		}
		if($t=='orders'){
			echo'<div class="row">'.
				'<label for="qestatus'.$r['id'].'">Status</label>'.
				'<div class="col-12">'.
					ucfirst($r['status']).
				'</div>'.
			'</div>'.
			'<div class="row">'.
				'<label for="qeti'.$r['id'].'">Created</label>'.
				'<div class="col-12">'.
					date($config['dateFormat'],($r['iid_ti']==0?$r['qid_ti']:$r['iid_ti'])).
				'</div>'.
			'</div>'.
			'<div class="row">'.
				'<label for="qedueti'.$r['id'].'">Due</label>'.
				'<div class="col-12">'.
					date($config['dateFormat'],$r['due_ti']).
				'</div>'.
			'</div>';
		}
	    echo'</div>'.
	  '</div>'.
	  '<script>'.
	    '$(".qetextinput").on({'.
	      'blur:function(event){'.
	        'event.preventDefault();'.
	      '},'.
	      'keydown:function(event){'.
	        'var id=$(this).data("dbid");'.
	        'if(event.keyCode==46||event.keyCode==8){'.
	          '$(this).trigger(`keypress`);'.
	        '}'.
	      '},'.
	      'keyup:function(event){'.
	        'if(event.which==9){'.
	          'var id=$(this).data("dbid");'.
	          'var da=$(this).val();'.
	          '$(this).trigger(`keypress`);'.
	          '$(this).next("input").focus();'.
	        '}'.
	      '},'.
	      'keypress:function(event){'.
					'var id=$(this).data("dbid");'.
	        'var save=$(this).data("dbc");'.
	        '$("#qesave"+save+id).addClass("btn-danger");'.
	        'console.log("keypress");'.
	        'if(event.which==13){'.
	          'event.preventDefault();'.
	        '}'.
	      '},'.
	      'change:function(event){'.
					'var id=$(this).data("dbid");'.
	        'var save=$(this).data("dbc");'.
	        '$("#qesave"+save+id).addClass("btn-danger");'.
	        'console.log("change");'.
	      '}'.
	    '});'.
	    '$(".qesave").click(function(e){'.
	  	  'e.preventDefault();'.
	  	 	'var l=Ladda.create(this);'.
	      'var el=$(this).data("dbid");'.
	      'var id=$("#"+el).data("dbid"),'.
	          't=$("#"+el).data("dbt"),'.
	          'c=$("#"+el).data("dbc"),'.
	          'da=$("#"+el).val();'.
	  	 	'l.start();'.
	      '$("#"+el).attr("disabled","disabled");'.
	      '$.ajax({'.
	        'type:"GET",'.
	        'url:"core/update.php",'.
	        'data:{'.
	          'id:id,'.
	          't:t,'.
	          'c:c,'.
	          'da:da'.
	        '}'.
	      '}).done(function(msg){'.
	        'l.stop();'.
	        '$("#"+el).removeAttr("disabled");'.
	        '$("#"+el).removeClass("unsaved");'.
	        '$("#qesave"+c+id).removeClass("btn-danger");'.
	      '});'.
	  	 	'return false;'.
	  	'});'.
			'function qeaddTag(id,t){'.
				'var eltags=$("#qetags"+id).val();'.
				'if(!eltags.includes(t)){'.
					'if(eltags.length > 0){'.
						'eltags+=",";'.
					'}'.
					'if(t=="none"){'.
						'eltags="";'.
					'}else{'.
						'eltags+=t;'.
					'}'.
					'$("#qetags"+id).val(eltags);'.
					'$("#qetags"+id).trigger("change");'.
				'}'.
			'}'.
			'function rank(rank){'.
				'if(rank==0){return"Visitor";}'.
				'if(rank==100){return"Subscriber";}'.
				'if(rank==200){return"Member";}'.
				'if(rank==210){return"Member Silver";}'.
				'if(rank==220){return"Member Bronze";}'.
				'if(rank==230){return"Member Gold";}'.
				'if(rank==240){return"Member Platinum";}'.
				'if(rank==300){return"Client";}'.
				'if(rank==310){return"Wholesaler";}'.
				'if(rank==320){return"Wholesaler Bronze";}'.
				'if(rank==330){return"Wholesaler Silver";}'.
				'if(rank==340){return"Wholesaler Gold";}'.
				'if(rank==350){return"Wholesaler Platinum";}'.
				'if(rank==400){return"Contributor";}'.
				'if(rank==500){return"Author";}'.
				'if(rank==600){return"Editor";}'.
				'if(rank==700){return"Moderator";}'.
				'if(rank==800){return"Manager";}'.
				'if(rank==900){return"Administrator";}'.
				'if(rank==1000){return"Developer";}'.
			'}'.
			'function rankclass(rank){'.
				'if(rank==0){return"visitor";}'.
				'if(rank==100){return"subscriber";}'.
				'if(rank==200){return"member";}'.
				'if(rank==210){return"member-silver";}'.
				'if(rank==220){return"member-bronze";}'.
				'if(rank==230){return"member-gold";}'.
				'if(rank==240){return"member-platinum";}'.
				'if(rank==300){return"client";}'.
				'if(rank==310){return"wholesale";}'.
				'if(rank==320){return"wholesale-bronze";}'.
				'if(rank==330){return"wholesale-silver";}'.
				'if(rank==340){return"wholesale-gold";}'.
				'if(rank==350){return"wholesale-platinum";}'.
				'if(rank==400){return"contributor";}'.
				'if(rank==500){return"author";}'.
				'if(rank==600){return"editor";}'.
				'if(rank==700){return"moderator";}'.
				'if(rank==800){return"manager";}'.
				'if(rank==900){return"administrator";}'.
				'if(rank==1000){return"developer";}'.
			'}'.
	  '</script>'.
	'</td>';
}
