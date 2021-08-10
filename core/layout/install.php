<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Install
 * @package    core/layout/install.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.5
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<!DOCTYPE HTML>
<!--
     AuroraCMS - Administration - Copyright (C) Diemen Design 2019
          the Australian MIT Licensed Open Source Content Management System.

     Project Maintained at https://github.com/DiemenDesign/AuroraCMS
-->
<html lang="en" id="AuroraCMS">
	<head>
		<meta charset="UTF-8">
    <meta name="generator" content="AuroraCMS">
    <meta name="robots" content="noindex,nofollow">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<title>Install - AuroraCMS</title>
		<link rel="icon" href="core/images/favicon.png">
		<link rel="apple-touch-icon" href="core/images/favicon.png">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
		<link rel="stylesheet" type="text/css" href="core/css/style.css">
	</head>
	<body class="aurora">
		<main class="row">
			<div class="col-12 col-sm-3 mx-auto mt-0 mt-sm-5 p-5 p-sm-0">
				<div class="m-4">
					<img class="login-logo" src="core/images/auroracms.svg" alt="AuroraCMS">
				</div>
				<noscript><div class="alert alert-danger" role="alert">Javascript MUST BE ENABLED for AuroraCMS to function correctly!</div></noscript>
				<h3 class="text-white text-md-black">Installation</h3>
				<hr>
				<div id="step1">
					<div id="dbinfo"></div>
					<?php $error=0;
					if(version_compare(phpversion(),'7.0','<'))echo'<div class="alert alert-danger" role="alert">AuroraCMS was built using PHP v7.0, your installed version is lower. While AuroraCMS may operate on your system, some functionality may not work or be available. We recommend using PHP 7.3 if available on you\'re services!</div>';
					if(extension_loaded('pdo')){
						if(empty(PDO::getAvailableDrivers())){
							$error++;
							echo'<div class="alert alert-danger" role="alert">Great PDO is Installed and Active, but there are no Database Drivers Installed!</div>';
						}
					}else{
						$error++;
						echo'<div class="alert alert-danger" role="alert">AuroraCMS uses PDO for Database Interaction, please Install or Enable PDO!</div>';
					}
					if(file_exists('core/config.ini')&&!is_writable('core/config.ini')){
						$error++;
						echo'<div class="alert alert-danger" role="alert"><code>core/config.ini</code> Exists, but is not writeable. There is two ways to fix this, either make <code>core/config.ini</code> writable, or remove the file!</div>';
					}
					if(!isset($_SERVER['HTTP_MOD_REWRITE'])){
						$error++;
						echo'<div class="alert alert-danger" role="alert"><code>mod_rewrite</code> must be available and enabled for AuroraCMS to function correctly!</div>';
					}
					if(!extension_loaded('gd')&&!function_exists('gd_info')){
						$error++;
						echo'<div class="alert alert-danger" role="alert">GD-Image is NOT Installed or Enabled!</div>';
					}
					if(!function_exists('curl_version')){
						$error++;
						echo'<div class="alert alert-info" role="alert">CURL Function is NOT enabled or Installed. Please install or enable the CURL extension!</div>';
					}
					echo(!function_exists('exif_read_data')?'<div class="alert alert-info" role="alert">EXIF Functions are NOT enabled or installed. While not Mandatory, some features won\'t work.</div>':'');
					echo($error>0?'<div class="alert alert-danger" role="alert">Please fix the above '.$error.' Issue\'s outlined within the Red Sections, then Refresh the page to Check Again.</div>':'');
					if($error==0){?>
						<h4 class="text-white text-md-black">Database Settings</h4>
						<form target="sp" method="post" action="core/installer.php" onsubmit="isValid();">
							<input name="emailtrap" type="hidden" value="">
							<input name="act" type="hidden" value="step1">
							<label class="text-white text-md-black" for="dbtype">Type</label>
							<select id="dbtype" name="dbtype">
								<?php	foreach(PDO::getAvailableDrivers() as$DRIVER)echo'<option value="'.$DRIVER.'">'.strtoupper($DRIVER).'</option>';?>
							</select>
							<label class="text-white text-md-black" for="dbhost">Host</label>
							<input id="dbhost" name="dbhost" type="text" value="localhost" placeholder="Enter a Host..." required>
							<label for="dbport">Port</label>
							<input id="dbport" name="dbport" type="text" value="" placeholder="Enter a Port Number, or leave Blank for Default...">
							<label for="dbprefix">Table Prefix</label>
							<input id="dbprefix" name="dbprefix" type="text" value="aurora_" placeholder="Enter a Table Prefix...">
							<label for="dbschema">Schema</label>
							<input id="dbschema" name="dbschema" type="text" value="" placeholder="Enter a Database Schema/Name..." required>
							<label for="dbusername">Username</label>
							<input id="dbusername" name="dbusername" type="text" value="" placeholder="Enter Database Username..." required>
							<label for="dbpassword">Password</label>
							<input id="dbpassword" name="dbpassword" type="password" value="" placeholder="Enter Database Password..." required>
							<button class="btn-block my-3" type="submit" aria-label="Go to Next Step">Next</button>
						</form>
					</div>
					<div class="d-none" id="step2">
						<h4 class="text-white text-md-black">System Settings</h4>
						<form target="sp" method="post" action="core/installer.php" onsubmit="isValid();">
							<input name="emailtrap" type="hidden" value="">
							<input name="act" type="hidden" value="step2">
							<label class="text-white text-md-black" for="sysurl">Site URL</label>
							<input id="sysurl" name="sysurl" type="text" value="" placeholder="Enter URL Folder if Site isn't in Domain Root...">
							<label class="text-white text-md-black" for="sysadmin">Administration Folder</label>
							<input id="sysadmin" name="sysadmin" type="text" value="" placeholder="Enter Administration Page Folder...">
							<div class="form-text small">Leave blank to use default: \"admin\". e.g. http://www.sitename.com/admin/</div>
							<label for="aTheme">Theme</label>
							<select id="aTheme" name="aTheme">
								<?php foreach(new DirectoryIterator('layout') as$folder){
									if($folder->isDOT())continue;
									if($folder->isDir()){
										$theme=parse_ini_file('layout/'.$folder.'/theme.ini',true);?>
										<option value="<?=$folder;?>"<?=(stristr($folder,'default')?' selected':'');?>><?=$theme['title'];?></option>
									<?php }
								}?>
							</select>
							<button class="btn-block my-3" type="submit" aria-label="Go to Next Step">Next</button>
						</form>
					</div>
					<div class="d-none" id="step3">
						<h4 class="text-white text-md-black">Developer Account Settings</h4>
						<form target="sp" method="post" action="core/installer.php" onsubmit="isValid();">
							<input name="emailtrap" type="hidden" value="">
							<input name="act" type="hidden" value="step3">
							<label class="text-white text-md-black" for="aname">Name</label>
							<input id="aname" name="aname" type="text" value="" placeholder="Enter a Name..." required>
							<label class="text-white text-md-black" for="aemail">Email</label>
							<input id="aemail" name="aemail" type="text" value="" placeholder="Enter an Email..." required>
							<label for="ausername">Username</label>
							<input id="ausername" name="ausername" type="text" value="" placeholder="Enter a Username..." required>
							<label for="apassword">Password</label>
							<input id="apassword" name="apassword" type="password" value="" placeholder="Enter a Password..." required>
							<label for="atimezone">Timezone</label>
							<select id="atimezone" name="atimezone">
								<option value="default">System Default</option>
									<?php $o=array(
	                  'Australia/Perth'      => "(GMT+08:00) Perth",
	                  'Australia/Adelaide'   => "(GMT+09:30) Adelaide",
	                  'Australia/Darwin'     => "(GMT+09:30) Darwin",
	                  'Australia/Brisbane'   => "(GMT+10:00) Brisbane",
	                  'Australia/Canberra'   => "(GMT+10:00) Canberra",
	                  'Australia/Hobart'     => "(GMT+10:00) Hobart",
	                  'Australia/Melbourne'  => "(GMT+10:00) Melbourne",
	                  'Australia/Sydney'     => "(GMT+10:00) Sydney"
                	);
                	foreach($o as$tz=>$label)echo'<option value="'.$tz.'">'.$label.'</option>';?>
							</select>
							<button class="btn-block my-3" type="submit" aria-label="Go to Next Step">Next</button>
						</form>
					</div>
				<?php }?>
				<div class="d-none" id="step4">
					<div class="alert alert-success text-center" role="alert">Installation Complete!<br>Website is Ready to use!</div>
					<div class="alert alert-info text-center" role="alert">NOTE: Website is currently in Maintenance Mode!</div>
				</div>
			</div>
			<iframe class="hidden" id="sp" name="sp"></iframe>
			<div class="page-block" id="block">
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
			<script src="core/js/jquery/jquery.min.js"></script>
			<script src="core/js/aurora.min.js"></script>
			<script>
				function isValid(){
					$('#block').addClass('d-block');
				}
			</script>
		</main>
		<div class="row mt-4">
			<footer class="footer mb-4 text-center">
				<a href="https://github.com/DiemenDesign/AuroraCMS" title="Project Source Hosted on GitHub, where you can also report Issues."><img class="tasmanian" src="core/images/octocat.svg" alt="GitHub Octocat."></a> <a href="https://github.com/DiemenDesign/AuroraCMS/blob/master/LICENSE" title="AuroraCMS is MIT Licensed."><img class="tasmanian" src="core/images/mit.svg" alt="AuroraCMS is MIT Licensed."></a> <img class="tasmanian" src="core/images/tasmania.svg" data-tooltip="tooltip" alt="Made in Tasmania for Australian Businesses." title="Made in Tasmania for Australian Businesses.">
			</footer>
		</div>
	</body>
</html>
