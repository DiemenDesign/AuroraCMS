<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Preferences - Theme
 * @package    core/layout/pref_theme.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.3
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<main>
  <section id="content">
    <div class="content-title-wrapper">
      <div class="content-title">
        <div class="content-title-heading">
          <div class="content-title-icon"><?= svg2('theme','i-3x');?></div>
          <div>Preferences - Theme</div>
          <div class="content-title-actions"></div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/preferences';?>">Preferences</a></li>
          <li class="breadcrumb-item active">Theme</li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0 shadow">
        <?='<div class="alert alert-danger'.(file_exists(THEME.'/theme.ini')?' hidden':'').'" id="notheme" role="alert">A Website Theme has not been set.</div>';?>
        <table class="table-zebra">
          <tbody class="theme-chooser" id="preference-theme">
            <?php $folders=preg_grep('/^([^.])/',scandir("layout"));
            foreach($folders as$folder){
              if(!file_exists('layout/'.$folder.'/theme.ini'))continue;
              $theme=parse_ini_file('layout/'.$folder.'/theme.ini',true);?>
              <tr class="theme<?=$config['theme']==$folder?' theme-selected':'';?>" data-theme="<?=$folder;?>">
                <td class="col-3 col-md-1">
                  <img src="<?php if(file_exists('layout/'.$folder.'/theme.jpg'))echo'layout/'.$folder.'/theme.jpg';elseif(file_exists('layout/'.$folder.'/theme.png'))echo'layout/'.$folder.'/theme.png';else echo ADMINNOIMAGE;?>" alt="<?= $theme['title'];?>">
                </td>
                <td class="col-9 col-md-11">
                  <h4><?= isset($theme['title'])&&$theme['title']!=''?$theme['title']:'No Title Assigned';?></h4>
                  <?= isset($theme['version'])&&$theme['version']!=''?'<small class="version">Version: '.$theme['version'].'</small><br>':'';
                  if(isset($theme['creator'])&&$theme['creator']!='')echo'<small class="creator">Creator'.(isset($theme['creator_url'])&&$theme['creator_url']!=''?': <a target="_blank" href="'.$theme['creator_url'].'">'.$theme['creator'].'</a>':$theme['creator']).'</small><br>';
                  if(isset($theme['framework_name'])&&$theme['framework_name']!='')echo'<small class="creator">Framework'.(isset($theme['framework_url'])&&$theme['framework_url']!=''?': <a target="_blank" href="'.$theme['framework_url'].'">'.$theme['framework_name'].'</a>':$theme['framework_name']).'</small><br>';?>
                </td>
              </tr>
            <?php }?>
          </tbody>
        </table>
        <?php require'core/layout/footer.php';?>
      </div>
    </div>
    <script>
      $(".theme-chooser").not(".disabled").find("tr.theme").on("click",function(){
        $('#preference-theme .theme').removeClass("theme-selected");
        $(this).addClass("theme-selected");
        $('#notheme').addClass("hidden");
        $.ajax({
          type:"GET",
          url:"core/update.php",
          data:{
            id:"1",
            t:"config",
            c:"theme",
            da:$(this).attr("data-theme")
          }
        });
      });
    </script>
  </section>
</main>
