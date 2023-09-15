<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Edit Postcodes
 * @package    core/edit_postcodes.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-6
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
require'db.php';
$st=filter_input(INPUT_POST,'st',FILTER_UNSAFE_RAW);
$s=filter_input(INPUT_POST,'s',FILTER_UNSAFE_RAW);
$pcf=filter_input(INPUT_POST,'pcf',FILTER_UNSAFE_RAW);
$pct=filter_input(INPUT_POST,'pct',FILTER_UNSAFE_RAW);
$html='';
if($st=='All'&&$pcf==''&&$pct==''){
	$html='<div class="row"><div class="col-12"><div class="alert alert-info text-center">A State selection other than All needs to be selected, or Postcode values need to be entered!</div></div></div>';
}else{
	$config=$db->query("SELECT `development` FROM `".$prefix."config` WHERE `id`=1")->fetch(PDO::FETCH_ASSOC);
	if($pcf!=''){
		if($pct==''||$pct<$pcf){
			$html='<div class="row"><div class="col-12"><div class="alert alert-danger text-center">A Postcode To value can`t be empty or smaller than the Postcode From value!</div></div></div>';
		}
		$q=$db->prepare("SELECT * FROM `".$prefix."locations` WHERE `postcode`>:pcf AND `postcode`<:pct ORDER BY `postcode` ASC");
		$q->execute([
			':pcf'=>$pcf,
			':pct'=>$pct
		]);
	}else{
		$q=$db->prepare("SELECT * FROM `".$prefix."locations` WHERE `state`=:state AND `area` LIKE :area ORDER BY `postcode` ASC");
		$q->execute([
			':state'=>$st,
			':area'=>($s=='All'?'%':str_replace(' ','%',$s))
		]);
	}
	$html.='<div class="sticky-top">'.
		'<div class="row mb-3">'.
			'<button class="btn" data-tooltip="bottom" aria-label="Hide FOMO Areas" onclick="editLocations();"><i class="i fomoarrow">down</i><i class="i fomoarrow d-none">up</i></button>'.
		'</div>'.
		'<div class="row">'.
			'<div class="col-12">'.
				'<input id="location-filter" type="text" value="" placeholder="Search for Postcode or Area..." onkeyup="filterLocations();">'.
			'</div>'.
		'</div>'.
		'<div class="row mt-3 pb-2">'.
			'<div class="col-2 font-weight-bold text-center">'.
				'Postcode'.
				'<span class="position-relative pull-right mr-2">'.
					'<i class="sort-by-asc" onclick="tinysort(`.locationitem`,{data:`postcode`});" data-tooltip="tooltip" aria-label="Sort Postcode in Ascending Order"></i>'.
					'<i class="sort-by-desc" onclick="tinysort(`.locationitem`,{data:`postcode`,order:`desc`});" data-tooltip="bottom" aria-label="Sort Postcode in Descending Order"></i>'.
				'</span>'.
			'</div>'.
			'<div class="col-8 font-weight-bold pl-3">'.
				'Area'.
				'<span class="position-relative pull-right mr-2">'.
					'<i class="sort-by-asc" onclick="tinysort(`.locationitem`,{data:`area`});" data-tooltip="tooltip" aria-label="Sort Area in Ascending Order"></i>'.
					'<i class="sort-by-desc" onclick="tinysort(`.locationitem`,{data:`area`,order:`desc`});" data-tooltip="bottom" aria-label="Sort Area in Descending Order"></i>'.
				'</span>'.
			'</div>'.
			'<div class="col-1 font-weight-bold text-center">'.
				'Include'.
			'</div>'.
			'<div class="col-1"></div>'.
		'</div>'.
	'</div>'.
	($config['development']==1?
		'<form class="row" target="sp" method="post" action="core/add_location.php">'.
			'<input type="hidden" name="state" value="'.$st.'">'.
			'<div class="col-2">'.
				'<input type="text" name="postcode" value="" placeholder="Postcode...">'.
			'</div>'.
			'<div class="col-8">'.
				'<input type="text" name="area" value="" placeholder="Area...">'.
			'</div>'.
			'<div class="col-1 text-center p-2">'.
				'<input type="checkbox" name="in" value="1" checked>'.
			'</div>'.
			'<div class="col-1 text-right">'.
				'<button class="add" type="submit"><i class="i">add</i></button>'.
			'</div>'.
		'</form>'
	:
		''
	).
	'<div id="locationsitems">';
	while($r=$q->fetch(PDO::FETCH_ASSOC)){
		$html.='<div id="l_'.$r['id'].'" class="locationitem row border-bottom" data-postcode="'.$r['postcode'].'" data-area="'.$r['area'].'" data-content="'.$r['postcode'].' '.$r['area'].'">'.
			($config['development']==1?
				'<div class="col-2">'.
					'<form class="form-row" target="sp" method="post" action="core/update.php">'.
						'<input type="hidden" name="id" value="'.$r['id'].'">'.
						'<input type="hidden" name="t" value="locations">'.
						'<input type="hidden" name="c" value="postcode">'.
						'<input type="text" name="da" value="'.$r['postcode'].'">'.
						'<button type="submit"><i class="i">save</i></button>'.
					'</form>'.
				'</div>'.
				'<div class="col-8">'.
					'<form class="form-row" target="sp" method="post" action="core/update.php">'.
						'<input type="hidden" name="id" value="'.$r['id'].'">'.
						'<input type="hidden" name="t" value="locations">'.
						'<input type="hidden" name="c" value="area">'.
						'<input type="text" name="da" value="'.$r['area'].'">'.
						'<button type="submit"><i class="i">save</i></button>'.
					'</form>'.
				'</div>'
			:
				'<div class="col-2 pt-3 text-center">'.$r['postcode'].'</div>'.
				'<div class="col-8 pt-3">'.$r['area'].'</div>'
			).
			'<div class="col-1 text-center p-2">'.
				'<input id="locations'.$r['id'].'" data-dbid="'.$r['id'].'" data-dbt="locations" data-dbc="active" type="checkbox"'.($r['active']==1?' checked':'').'>'.
			'</div>'.
			'<div class="col-1 text-right">'.
				'<a class="btn" href="https://www.google.com/maps/place/'.str_replace(' ','+',$r['area']).'+'.$r['state'].'+'.$r['postcode'].'" target="child" data-tooltip="tooltip" aria-label="View Location in Google Maps"><i class="i">map</i></a>'.
				($config['development']==1?
					'<button class="trash" onclick="purge(`'.$r['id'].'`,`locations`);"><i class="i">trash</i></button>'
				:
					'').
			'</div>'.
		'</div>';
	}
	$html.='</div>';
}
echo$html;
