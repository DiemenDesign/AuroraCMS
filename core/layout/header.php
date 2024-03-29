<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Header
 * @package    core/layout/header.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-7
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<header id="back-to-top" class="aurora shadow-md">
  <nav>
    <ul class="nav-left">
      <li>
        <button class="btn btn-ghost nav-toggle" type="button" aria-label="Show/Hide Sidebar" aria-expanded="true">
          <span class="line line-1"></span>
          <span class="line line-2"></span>
          <span class="line line-3"></span>
        </a>
      </li>
      <li>
        <a href="<?= URL.$settings['system']['admin'];?>/" data-tooltip="right" aria-label="AuroraCMS"><i class="i i-5x mb-3 i-color-black">auroracms</i></a>
      </li>
    </ul>
    <ul class="ml-auto mt-3">
      <li class="text-center" data-tooltip="left" aria-label="Search">
        <a href="<?= URL.$settings['system']['admin'].'/search';?>"><i class="i i-3x">search</i></a>
      </li>
      <li class="ml-3" data-tooltip="left" aria-label="Switch Theme Mode">
        <input class="d-none" id="theme-checkbox" type="checkbox">
        <label class="m-0" for="theme-checkbox">
          <i class="i i-3x theme-mode theme-light<?=(isset($_COOKIE['admintheme'])&&$_COOKIE['admintheme']=='light'?'':' d-none');?>">light-mode</i>
          <i class="i i-3x theme-mode theme-dark<?=(isset($_COOKIE['admintheme'])&&$_COOKIE['admintheme']=='dark'?'':' d-none');?>">dark-mode</i>
          <i class="i i-3x theme-mode theme-system<?=(isset($_COOKIE['admintheme'])&&$_COOKIE['admintheme']=='system'||$_COOKIE['admintheme']==''?'':' d-none');?>">system-mode</i>
        </label>
        <ul class="p-0" id="nav-theme-list">
          <li><a class="p-2 px-3" onclick="selectTheme('light');">Light</a></li>
          <li><a class="p-2 px-3" onclick="selectTheme('dark');">Dark</a></li>
          <li><a class="p-2 px-3" onclick="selectTheme('system');">System</a></li>
        </ul>
      </li>
      <li class="badge ml-3 text-center" id="nav-stat" aria-label="Notifications" data-badge="<?=$navStat>0?$navStat:'';?>">
        <input class="d-none" id="notification-checkbox" type="checkbox">
        <label class="m-0" for="notification-checkbox"><i class="i i-3x">bell</i></label>
        <ul class="p-0" id="nav-stat-list">
          <li class="dropdown-heading py-2">Notifications</li>
          <?=($nc['cnt']>0?'<li><a href="'.URL.$settings['system']['admin'].'/comments"><span class="badger badge-primary mr-2">'.$nc['cnt'].'</span>Comments</a></li>':'').
          ($nr['cnt']>0?'<li><a href="'.URL.$settings['system']['admin'].'/reviews"><span class="badger badge-primary mr-2">'.$nr['cnt'].'</span>Reviews</a></li>':'').
          ($nm['cnt']>0?'<li><a href="'.URL.$settings['system']['admin'].'/messages"><span class="badger badge-primary mr-2">'.$nm['cnt'].'</span>Messages</a></li>':'').
          ($po['cnt']>0?'<li><a href="'.URL.$settings['system']['admin'].'/orders/pending"><span class="badger badge-primary mr-2">'.$po['cnt'].'</span>Orders</a></li>':'').
          ($nb['cnt']>0?'<li><a href="'.URL.$settings['system']['admin'].'/bookings"><span class="badger badge-primary mr-2">'.$nb['cnt'].'</span>Bookings</a></li>':'').
          ($nu['cnt']>0?'<li><a href="'.URL.$settings['system']['admin'].'/accounts"><span class="badger badge-primary mr-2">'.$nu['cnt'].'</span>Users</a></li>':'').
          ($nt['cnt']>0?'<li><a href="'.URL.$settings['system']['admin'].'/content/type/testimonials"><span class="badger badge-primary mr-2">'.$nt['cnt'].'</span>Testimonials</a></li>':'').
          ($nou['cnt']>0?'<li><a href="'.URL.$settings['system']['admin'].'/accounts"><span class="badger badge-primary mr-2">'.$nou['cnt'].'</span>Active Users</a></li>':'');?>
        </ul>
      </li>
      <li data-tooltip="left" aria-label="View Site">
        <a href="<?= URL;?>"><i class="i i-3x">browser-general</i></a>
      </li>
      <li class="text-center ml-3" id="nav-accounts" data-tooltip="left" aria-label="Account Settings">
        <input class="d-none" id="header-account-checkbox" type="checkbox">
        <label class="m-0" for="header-account-checkbox">
          <span class="d-inline" id="account">
            <img class="img-avatar" src="<?php if($user['avatar']!=''&&file_exists('media/avatar/'.basename($user['avatar'])))echo'media/avatar/'.basename($user['avatar']);
              elseif($user['gravatar']!=''){
                if(stristr($user['gravatar'],'@')) echo'http://gravatar.com/avatar/'.md5($user['gravatar']);
              elseif(stristr($user['gravatar'],'gravatar.com/avatar/'))  echo$user['gravatar'];
              else echo ADMINNOAVATAR;
            }else echo ADMINNOAVATAR;?>" alt="<?=$user['username'];?>">
          </span>
        </label>
        <ul class="p-0" id="nav-account-list">
          <li class="text-center p-3">
            <img class="img-avatar m-3" style="width:80px;height:80px;max-width:initial;max-height:80px;" src="<?php if($user['avatar']!=''&&file_exists('media/avatar/'.basename($user['avatar'])))echo'media/avatar/'.basename($user['avatar']);
              elseif($user['gravatar']!=''){
                if(stristr($user['gravatar'],'@')) echo'http://gravatar.com/avatar/'.md5($user['gravatar']);
              elseif(stristr($user['gravatar'],'gravatar.com/avatar/'))  echo$user['gravatar'];
              else echo ADMINNOAVATAR;
            }else echo ADMINNOAVATAR;?>" alt="<?=$user['username'];?>"><br>
            <span class="d-inline-block"><strong class="d-block"><?=$user['name']==''?$user['username']:$user['name'];?></strong>
              <small><?= ucwords(rank($user['rank']));?></small>
            </span>
          </li>
          <li><a class="p-2 px-3" href="<?= URL.$settings['system']['admin'].'/accounts/edit/'.$user['id'];?>">My Account</a></li>
          <li><a class="p-2 px-3" target="_blank" href="https://github.com/DiemenDesign/AuroraCMS/issues">Support</a></li>
          <li><a class="p-2 px-3" href="<?= URL.$settings['system']['admin'].'/logout';?>">Logout</a></li>
          <li class="dropdown-heading">&nbsp;</li>
          <li><a class="p-2 px-3" href="https://github.com/DiemenDesign/AuroraCMS">AuroraCMS Home Page</a></li>
          <li><a class="p-2 px-3" href="https://github.com/DiemenDesign/AuroraCMS/issues">Report an issue</a></li>
          <li><a class="p-2 px-3" href="https://github.com/DiemenDesign/AuroraCMS/wiki">Documentation</a></li>
        </ul>
      </li>
    </ul>
  </nav>
</header>
