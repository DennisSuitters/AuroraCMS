<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Remove Backup
 * @package    core/removebackup.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.13
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_UNSAFE_RAW):filter_input(INPUT_GET,'id',FILTER_UNSAFE_RAW);
unlink('../media/backup/'.$id.'.sql.gz');
echo'<script>window.top.window.$("#l_'.$id.'").slideUp(500,function(){$(this).remove()});</script>';
