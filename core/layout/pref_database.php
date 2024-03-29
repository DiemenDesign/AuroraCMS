<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Preferences - Database
 * @package    core/layout/pref_database.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-7
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<main>
  <section class="<?=(isset($_COOKIE['sidebar'])&&$_COOKIE['sidebar']=='small'?'navsmall':'');?>" id="content">
    <div class="container-fluid">
      <div class="card bg-transparent border-0 overflow-visible">
        <div class="card-actions">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/preferences';?>">Preferences</a></li>
            <li class="breadcrumb-item active">Database</li>
          </ol>
        </div>
        <legend id="databaseOptions">Database Options</legend>
        <form target="sp" method="post" action="core/changeprefix.php">
          <label for="prefix">Table Prefix</label>
          <div class="form-row">
            <input class="textinput" id="prefix" name="dbprefix" type="text" value="<?=$prefix;?>"<?=($user['options'][7]==1?' placeholder="Enter a Table Prefix..."':' disabled');?>>
            <?=($user['options'][7]==1?'<button type="submit" onclick="$(`body`).append(`<div id=blocker><div></div></div>`);">Update</button>':'');?>
          </div>
        </form>
        <legend class="mt-3">Database Backup/Restore</legend>
        <div id="backup" name="backup">
          <div id="backup_info">
            <?php $tid=$ti-2592000;
            if($config['backup_ti']<$tid)echo$config['backup_ti']==0?'<div class="alert alert-info" role="alert">A Backup has yet to be performed.</div>':'<div class="alert alert-danger" role="alert">It has been more than 30 days since a Backup has been performed.</div>';?>
          </div>
          <form target="sp" method="post" action="core/backup.php" onsubmit="$('.page-block').addClass('d-block');">
            <div class="form-row">
              <label>Backup</label>
            </div>
            <?=($user['options'][7]==1?'<div class="form-text">Note: Only the database is backed up.</div>':'');?>
            <div class="form-row">
              <?=($user['options'][7]==1?'<button class="btn-block" type="submit">Perform Backup</button>':'');?>
            </div>
          </form>
          <div id="backups">
            <?php foreach(glob("media/backup/*") as$file){
              $filename=basename($file);
              $filename=rtrim($filename,'.sql.gz');?>
              <div id="l_<?=$filename;?>" class="form-row mt-2">
                <?=($user['options'][7]==1?'<a class="btn btn-block" href="'.$file.'">Click to Download <?= ltrim($file,`media/backup/`);?></a>':'<div class="input-text">'.$file.'</div>').
                ($user['options'][7]==1?'<button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="removeBackup(`'.$filename.'`);"><i class="i">trash</i></button>':'');?>
              </div>
            <?php }?>
          </div>
          <?php if($user['options'][7]==1){?>
            <div class="alert alert-info mt-3">
              To restore a Database Backup, you will need to upload the .sql/.sql.gz file to PHPMyAdmin or other Database Configuration tool.
            </div>
          <?php }?>
<?php /*
            <form class="mt-3" target="sp" method="post" action="core/restorebackup.php" enctype="multipart/form-data">
              <div class="custom-file">
                <input class="custom-file-input hidden" id="fu" type="file" name="fu" onchange="$(`.page-block`).addClass(`d-block`);form.submit();">
                <label for="fu" class="btn add">Choose File and Restore Database</label>
              </div>
            </form>
*/?>
        </div>
      </div>
      <?php require'core/layout/footer.php';?>
    </div>
  </section>
</main>
