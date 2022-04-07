<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Sitemap
 * @package    core/view/sitemap.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.7
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
require'core/sanitize/HTMLPurifier.php';
$purify=new HTMLPurifier(HTMLPurifier_Config::createDefault());
include'inc-breadcrumbs.php';
$rank=isset($_SESSION['rank'])?$_SESSION['rank']+1:1;
$html=preg_replace([
  '/<print page=[\"\']?heading[\"\']?>/',
  '/<print page=[\"\']?notes[\"\']?>/'
],[
  htmlspecialchars(($page['heading']==''?$page['seoTitle']:$page['heading']),ENT_QUOTES,'UTF-8'),
  $purify->purify($page['notes'])
],$html);
preg_match('/<items>([\w\W]*?)<\/items>/',$html,$matches);
$item=$matches[1];
$s1=$db->query("SELECT `contentType`,`title` FROM `".$prefix."menu` WHERE `active`='1' AND `contentType`!='proofs' AND `contentType`!='orders' AND `contentType`!='settings' AND `contentType`!='comingsoon' AND `contentType`!='maintenance' AND `contentType`!='offline' AND `contentType`!='checkout' AND `contentType`!='cart' ORDER BY `ord` ASC");
$items=$sitemapitems='';
while($r1=$s1->fetch(PDO::FETCH_ASSOC)){
  $items=$item;
  $sitemaplinks='';
  $items=preg_replace(
    '/<print content=[\"\']?contentType[\"\']?>/',
    '<a href="'.URL.$r1['contentType'].($r1['contentType']=='page'?'/'.str_replace(' ','-',strtolower(htmlspecialchars($r1['title'],ENT_QUOTES,'UTF-8'))):'').'">'.($r1['contentType']=='page'?ucwords(htmlspecialchars($r1['title'],ENT_QUOTES,'UTF-8')):ucwords($r1['contentType'])).'</a>',
  $items);
  $s2=$db->prepare("SELECT `rank`,`contentType`,`title`,`urlSlug` FROM `".$prefix."content` WHERE `contentType`=:contentType AND `contentType`!='testimonials' AND `status`='published' AND `internal`!='1' ORDER BY ti DESC");
  $s2->execute([':contentType'=>$r1['contentType']]);
  while($r2=$s2->fetch(PDO::FETCH_ASSOC)){
    if($r2['rank']<$rank){
      $sitemaplinks.='<a href="'.$r1['contentType'].'/'.$r2['urlSlug'].'/">'.htmlspecialchars($r2['title'],ENT_QUOTES,'UTF-8').'</a><br>';
    }
  }
  $items=preg_replace('/<print links>/',$sitemaplinks,$items);
	$sitemapitems.=$items;
}
$html=preg_replace('~<items>.*?<\/items>~is',$sitemapitems,$html,1);
$content.=$html;
