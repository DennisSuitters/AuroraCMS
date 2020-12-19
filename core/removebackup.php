<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Remove Backup
 * @package    core/removebackup.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.0
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'id',FILTER_SANITIZE_STRING);
unlink('../media/backup/'.$id.'.sql.gz');
echo'<script>window.top.window.$("#l_'.$id.'").slideUp(500,function(){$(this).remove()});</script>';
