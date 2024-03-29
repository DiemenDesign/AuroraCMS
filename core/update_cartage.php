<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Update Cartage
 * @package    core/update_cartage.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`='1'")->fetch(PDO::FETCH_ASSOC);
define('SESSIONID',session_id());
define('THEME','../layout/'.$config['theme']);
if(file_exists('layout/'.$config['theme'].'/images/noimage.png'))
  define('NOIMAGE','layout/'.$config['theme'].'/images/noimage.png');
elseif(file_exists('layout/'.$config['theme'].'/images/noimage.gif'))
  define('NOIMAGE','layout/'.$config['theme'].'/images/noimage.gif');
elseif(file_exists('layout/'.$config['theme'].'/images/noimage.jpg'))
  define('NOIMAGE','layout/'.$config['theme'].'/images/noimage.jpg');
else
  define('NOIMAGE','core/images/noimage-sm.jpg');
define('UNICODE','UTF-8');
$theme=parse_ini_file(THEME.'/theme.ini',true);
$cq=$db->prepare("SELECT * FROM `".$prefix."cart` WHERE `si`=:si ORDER BY `ti` DESC");
$cq->execute([':si'=>SESSIONID]);
if($cq->rowCount()>0){
  $cartitem=$cartage='';
  while($cr=$cq->fetch(PDO::FETCH_ASSOC)){
    $cartitem=$theme['settings']['cartage_menu'];
    if($cr['file']=='')$cr['file']=NOIMAGE;
    $cartitem=preg_replace([
      '/<print cartageitem=[\"\']?thumb[\"\']?>/',
      '/<print cartageitem=[\"\']?title[\"\']?>/',
      '/<print cartageitem=[\"\']?quantity[\"\']?>/',
      '/<print cartageitem=[\"\']?cost[\"\']?>/'
    ],[
      $cr['file'],
      $cr['title'],
      $cr['quantity'],
      $cr['cost']
    ],$cartitem);
    $cartage.=$cartitem;
  }
  echo$cartage;
}
