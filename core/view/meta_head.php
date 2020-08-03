<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Meta Head
 * @package    core/view/meta_head.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.18
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.18 Reformat source for legibility.
 */
if(preg_match('/<block include=[\"\']?meta_head.html[\"\']?>/',$template)&&file_exists(THEME.DS.'meta_head.html'))
	$head=file_get_contents(THEME.DS.'meta_head.html');
elseif(stristr($template,'</head>')){
	preg_match('/<head>([\w\W]*?)<\/head>/',$template,$matches);
	$head=$matches[1];
}else
	$head='You MUST include a meta_head template, or inbed a meta head section';
