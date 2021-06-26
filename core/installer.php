<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Installer
 * @package    core/installer.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.5
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$error=0;
$act=isset($_POST['act'])?filter_input(INPUT_POST,'act',FILTER_SANITIZE_STRING):'';
if($_POST['emailtrap']==''){
	if($act=='step1'){
		$dbprefix=isset($_POST['dbprefix'])?filter_input(INPUT_POST,'dbprefix',FILTER_SANITIZE_STRING):'';
		$dbtype=isset($_POST['dbtype'])?filter_input(INPUT_POST,'dbtype',FILTER_SANITIZE_STRING):'';
		$dbhost=isset($_POST['dbhost'])?filter_input(INPUT_POST,'dbhost',FILTER_SANITIZE_STRING):'';
		$dbport=isset($_POST['dbport'])?filter_input(INPUT_POST,'dbport',FILTER_SANITIZE_NUMBER_INT):'';
		$dbschema=isset($_POST['dbschema'])?filter_input(INPUT_POST,'dbschema',FILTER_SANITIZE_STRING):'';
		$dbusername=isset($_POST['dbusername'])?filter_input(INPUT_POST,'dbusername',FILTER_SANITIZE_STRING):'';
		$dbpassword=isset($_POST['dbpassword'])?filter_input(INPUT_POST,'dbpassword',FILTER_SANITIZE_STRING):'';
		$txt='[database]'.PHP_EOL.
				 'prefix = '.$dbprefix.PHP_EOL.
				 'driver = '.$dbtype.PHP_EOL.
				 'host = '.$dbhost.PHP_EOL.
				 'port = '.($dbport==''?'3306':$dbport).PHP_EOL.
				 'schema = '.$dbschema.PHP_EOL.
				 'username = '.$dbusername.PHP_EOL.
				 'password = '.$dbpassword.PHP_EOL.
				 '[system]'.PHP_EOL.
				 'devmode = false'.PHP_EOL.
				 'version = '.time().PHP_EOL.
				 'url = '.PHP_EOL.
				 'admin = '.PHP_EOL;
		if(file_exists('config.ini'))unlink('config.ini');
		$oFH=fopen("config.ini",'w');
		fwrite($oFH,$txt);
		fclose($oFH);
		echo'<script>'.
			'window.top.window.$("#step1").addClass("d-none");'.
			'window.top.window.$("#step2").removeClass("d-none");'.
			'window.top.window.$("#block").removeClass("d-block");'.
		'</script>';
	}
	if($act=='step2'){
		$config=parse_ini_file('config.ini',true);
		$sysurl=isset($_POST['sysurl'])?filter_input(INPUT_POST,'sysurl',FILTER_SANITIZE_STRING):'';
		$sysadmin=isset($_POST['sysadmin'])?filter_input(INPUT_POST,'sysadmin',FILTER_SANITIZE_STRING):'';
		$aTheme=isset($_POST['aTheme'])?filter_input(INPUT_POST,'aTheme',FILTER_SANITIZE_STRING):'';
		$sysurl='/'.ltrim($sysurl,'/');
		$sysurl=rtrim($sysurl,'/');
		$txt='[database]'.PHP_EOL.
				 'prefix = '.$config['database']['prefix'].PHP_EOL.
				 'driver = '.$config['database']['driver'].PHP_EOL.
				 'host = '.$config['database']['host'].PHP_EOL.
				 'port = '.$config['database']['port'].PHP_EOL.
				 'schema = '.$config['database']['schema'].PHP_EOL.
				 'username = '.$config['database']['username'].PHP_EOL.
				 'password = '.$config['database']['password'].PHP_EOL.
				 '[system]'.PHP_EOL.
				 'devmode = '.$config['system']['devmode'].PHP_EOL.
				 'version = '.time().PHP_EOL.
				 'url = '.ltrim($sysurl).PHP_EOL.
				 'admin = '.($sysadmin==''?'admin':$sysadmin).PHP_EOL;
		if(file_exists('config.ini'))unlink('config.ini');
		$oFH=fopen("config.ini",'w');
		fwrite($oFH,$txt);
		fclose($oFH);
		require'db.php';
		if(!isset($db)){
			$error=1;
			echo'<script>window.top.window.$("#dbsuccess").html(`<div class="alert alert-danger" role="alert">Database Connection Error!</div>`);</script>';
		}
		if($error==0){
			$prefix=$settings['database']['prefix'];
			$sql=file_get_contents('aurora.sql');
			$sql=str_replace([
					"CREATE TABLE `",
					"INSERT INTO `",
					"ALTER TABLE `"
				],[
					"CREATE TABLE `".$prefix,
					"INSERT INTO `".$prefix,
					"ALTER TABLE `".$prefix
				],$sql);
			$q=$db->exec($sql);
			$e=$db->errorInfo();
			if(is_null($e[2]))echo'<script>window.top.window.$("#dbsuccess").html(`<div class="alert alert-success" role="alert">Database Import Succeeded!</div>`);</script>';
			require'db.php';
			$prefix=$settings['database']['prefix'];
			$sql=$db->prepare("UPDATE `".$prefix."config` SET `theme`=:theme,`maintenance`=1 WHERE `id`=1");
			$sql->execute([':theme'=>$aTheme]);
			$e=$db->errorInfo();
			if(!is_null($e[2]))echo'<script>window.top.window.alert(`'.$e[2].'`);</script>';
			else{
				echo'<script>'.
					'window.top.window.$("#step2").addClass("d-none");'.
					'window.top.window.$("#step3").removeClass("d-none");'.
					'window.top.window.$("#block").removeClass("d-block");'.
				'</script>';
			}
		}
	}
	if($act=='step3'){
		require'db.php';
		$aname=isset($_POST['aname'])?filter_input(INPUT_POST,'aname',FILTER_SANITIZE_STRING):'';
		$aemail=isset($_POST['aemail'])?filter_input(INPUT_POST,'aemail',FILTER_SANITIZE_STRING):'';
		$ausername=isset($_POST['ausername'])?filter_input(INPUT_POST,'ausername',FILTER_SANITIZE_STRING):'';
		$apassword=isset($_POST['apassword'])?filter_input(INPUT_POST,'apassword',FILTER_SANITIZE_STRING):'';
		$atimezone=isset($_POST['atimezone'])?filter_input(INPUT_POST,'atimezone',FILTER_SANITIZE_STRING):'';
		$prefix=$settings['database']['prefix'];
		$hash=password_hash($apassword,PASSWORD_DEFAULT);
		$sql=$db->prepare("INSERT IGNORE INTO `".$prefix."login` (`options`,`bio_options`,`username`,`password`,`email`,`name`,`language`,`timezone`,`ti`,`active`,`rank`) VALUES ('11111111101111111100000000000000','11110000000000000000000000000000',:username,:password,:email,:name,'en-AU',:timezone,:ti,'1','1000')");
		$sql->execute([
			':username'=>$ausername,
			':password'=>$hash,
			':email'=>$aemail,
			':name'=>$aname,
			':timezone'=>$atimezone,
			':ti'=>time()
		]);
		$e=$db->errorInfo();
		if(!is_null($e[2]))echo'<script>window.top.window.alert(`'.$e[2].'`);</script>';
		else{
			echo'<script>'.
				'window.top.window.$("#step3").addClass("d-none");'.
				'window.top.window.$("#step4").removeClass("d-none");'.
				'window.top.window.$("#block").removeClass("d-block");'.
			'</script>';
		}
	}
}
