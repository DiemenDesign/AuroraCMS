<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Add Postage Option
 * @package    core/add_postoption.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-7
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`='1'")->fetch(PDO::FETCH_ASSOC);
$c=isset($_POST['c'])?filter_input(INPUT_POST,'c',FILTER_UNSAFE_RAW):'';
$t=isset($_POST['t'])?filter_input(INPUT_POST,'t',FILTER_UNSAFE_RAW):'';
$v=isset($_POST['v'])?filter_input(INPUT_POST,'v',FILTER_UNSAFE_RAW):0;
if($t==''){
  echo'<script>window.top.window.toastr["error"]("Title field can\'t be empty!");</script>';
}else{
  $s=$db->prepare("INSERT IGNORE INTO `".$prefix."choices` (`rid`,`contentType`,`type`,`title`,`value`) VALUES (0,'postoption',:c,:t,:v)");
  $s->execute([
		':c'=>$c,
		':t'=>$t,
		':v'=>$v
	]);
  if($v==0)$v='';
  $id=$db->lastInsertId();
	echo'<script>'.
        'window.top.window.$("#postoption").append(`<div id="l_'.$id.'" class="row add-item">'.
          '<div class="col-12 col-md">'.
            '<div class="input-text">'.$c.'</div>'.
          '</div>'.
          '<div class="col-12 col-md">'.
            '<div class="input-text">'.$t.'</div>'.
          '</div>'.
          '<div class="col-12 col-md">'.
            '<div class="form-row">'.
              '<div class="input-text col-md">'.$v.'</div>'.
              '<form target="sp" action="core/purge.php">'.
                '<input name="id" type="hidden" value="'.$id.'">'.
                '<input name="t" type="hidden" value="choices">'.
                '<button class="trash" data-tooltip="tooltip" type="submit" aria-label="Delete"><i class="i">trash</i></button>'.
              '</form>'.
            '</div>'.
          '</div>'.
        '</div>`);'.
      '</script>';
}
