<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Cart Quantity
 * @package    core/cart_quantity.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.3
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$cart='';
$dti=$ti-86400;
$q=$db->prepare("DELETE FROM `".$prefix."cart` WHERE `ti`<:ti");
$q->execute([':ti'=>$dti]);
$q=$db->prepare("SELECT SUM(`quantity`) as quantity FROM `".$prefix."cart` WHERE `si`=:si");
$q->execute([':si'=>SESSIONID]);
$r=$q->fetch(PDO::FETCH_ASSOC);
$cart=$theme['settings']['cart_menu'];
$cart=preg_replace('/<print cart=[\"\']?quantity[\"\']?>/',$r['quantity'],$cart);
