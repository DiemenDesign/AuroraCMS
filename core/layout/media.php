<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Media
 * @package    core/layout/media.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.0
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if($args[0]=='settings')
  include'core'.DS.'layout'.DS.'set_media.php';
elseif($args[0]=='edit')
  include'core'.DS.'layout'.DS.'edit_media.php';
else{?>
<main>
  <section id="content" class="main">
    <div class="content-title-wrapper mb-0">
      <div class="content-title">
        <div class="content-title-heading">
          <div class="content-title-icon"><?php svg('picture','i-3x');?></div>
          <div>Media</div>
          <div class="content-title-actions">
            <?php echo$user['options'][7]==1?'<a class="btn" href="'.URL.$settings['system']['admin'].'/media/settings" data-tooltip="tooltip" role="button" aria-label="Media Settings">'.svg2('settings').'</a>':'';?>
          </div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/content';?>">Content</a></li>
          <li class="breadcrumb-item active">Media</li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0 shadow">
    <?php if($user['options'][0]==1){?>
        <div class="row">
          <div id="elfinder" style="width:100%;"></div>
        </div>
    <?php }else{?>
        <div class="alert alert-info" role="alert">You Don't Have Permissions To Use This Area</div>
    <?php }?>
        <?php include'core/layout/footer.php';?>
      </div>
    </div>
  </section>
</main>
<?php }
