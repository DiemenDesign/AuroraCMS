<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Blacklist
 * @package    core/add_blacklist.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.13
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`='1'")->fetch(PDO::FETCH_ASSOC);
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$t=isset($_POST['t'])?filter_input(INPUT_POST,'t',FILTER_UNSAFE_RAW):filter_input(INPUT_GET,'t',FILTER_UNSAFE_RAW);
$reason=isset($_POST['r'])?filter_input(INPUT_POST,'r',FILTER_UNSAFE_RAW):filter_input(INPUT_GET,'r',FILTER_UNSAFE_RAW);
if($t=='comments')$s=$db->prepare("SELECT `ip`,`ti` FROM `".$prefix."comments` WHERE `id`=:id");
elseif($t=='tracker')$s=$db->prepare("SELECT `ip`,`ti` FROM `".$prefix."tracker` WHERE `id`=:id");
elseif($t=='livechat')$s=$db->prepare("SELECT `ip`,`ti` FROM `".$prefix."livechat` WHERE `id`=:id");
$s->execute([':id'=>$id]);
if($s->rowCount()>0){
  $r=$s->fetch(PDO::FETCH_ASSOC);
  $sql=$db->prepare("INSERT IGNORE INTO `".$prefix."iplist` (`ip`,`oti`,`reason`,`ti`) VALUES (:ip,:oti,:reason,:ti)");
  $sql->execute([
    ':ip'=>$r['ip'],
    ':oti'=>$r['ti'],
    ':reason'=>$reason,
    ':ti'=>time()
  ]);
  echo'IP Added to Blacklist!';
}else echo'IP already exists in the Blacklist!';
