<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Core - Display More Tracking Items
 * @package    core/more_tracker.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.3
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE `id`='1'")->fetch(PDO::FETCH_ASSOC);
function svg2($svg,$class=null,$size=null){
	return'<i class="i'.($size!=null?' i-'.$size:'').($class!=null?' '.$class:'').'">'.file_get_contents('images/i-'.$svg.'.svg').'</i>';
}
$t=filter_input(INPUT_GET,'t',FILTER_SANITIZE_STRING);
$c=filter_input(INPUT_GET,'c',FILTER_SANITIZE_STRING);
$b=filter_input(INPUT_GET,'b',FILTER_SANITIZE_STRING);
$s=$db->prepare("SELECT * FROM `".$prefix."tracker` WHERE LOWER(`browser`) LIKE LOWER(:b) ORDER BY `ti` DESC LIMIT $c,20");
$s->execute([':b'=>'%'.strtolower($b).'%']);
$c=$c+$c;
if($s->rowCount()>0){
  while($r=$s->fetch(PDO::FETCH_ASSOC)){
    echo'<tr id="l_'.$r['id'].'" data-ip="'.$r['ip'].'" class="small animated fadeIn">'.
        	'<td class="text-wrap align-middle" style="min-width:200px;max-width:250px;">'.$r['id'].': '.trim($r['urlDest']).'</td>'.
          '<td class="text-wrap align-middle" style="min-width:200px;max-width:250px;">'.trim($r['urlFrom']).'</td>'.
          '<td class="text-center align-middle">'.
            '<a target="_blank" href="http://www.ipaddress-finder.com/?ip='.$r['ip'].'">'.$r['ip'].'</a>'.
            '<button class="trash" data-tooltip="tooltip" onclick="purge(`'.$r['ip'].'`,`clearip`)" aria-label="Remove all of this IP">'.svg2('eraser').'</button>'.
          '</td>'.
          '<td class="text-center align-middle">'.ucfirst($r['browser']).'</td>'.
          '<td class="text-center align-middle">'.ucfirst($r['os']).'</td>'.
          '<td class="text-center align-middle">'.date($config['dateFormat'],$r['ti']).'</td>'.
          '<td class="align-middle">'.
            '<div class="btn-group float-right">'.
              '<button class="pathviewer" data-tooltip="tooltip" data-toggle="popover" data-dbid="'.$r['id'].'" aria-label="View Visitor Path">'.svg2('seo-path').'</button>';
    if($config['php_options'][0]==1){
      echo'<button class="phpviewer" data-tooltip="tooltip" data-toggle="popover" data-dbid="'.$r['id'].'" data-dbt="tracker" aria-label="Check IP with Project Honey Pot">'.svg2('brand-projecthoneypot').'</button>';
    }
              echo'<button class="trash" onclick="purge(`'.$r['id'].'`,`tracker`)" data-tooltip="tooltip" aria-label="Delete">'.svg2('trash').'</button>'.
            '</div>'.
          '</td>'.
        '</tr>';
  }
      echo'<tr id="more_'.$c.'">'.
            '<td colspan="7">'.
              '<div class="form-group">'.
                '<div class="input-group">'.
                  '<button class="btn-block" onclick="more(`tracker`,`'.$c.'`,`'.$b.'`);">More</button>'.
                '</div>'.
              '</div>'.
            '</td>'.
          '</tr>';
}else echo'nomore';
