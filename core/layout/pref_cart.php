<?php
/**
* AuroraCMS - Copyright (C) Diemen Design 2019
*
* @category   Administration - Preferences - Cart
* @package    core/layout/pref_cart.php
* @author     Dennis Suitters <dennis@diemen.design>
* @copyright  2014-2019 Diemen Design
* @license    http://opensource.org/licenses/MIT  MIT License
* @version    0.1.0
* @link       https://github.com/DiemenDesign/AuroraCMS
* @notes      This PHP Script is designed to be executed using PHP 7+
*/?>
<main>
  <section id="content">
    <div class="content-title-wrapper">
      <div class="content-title">
        <div class="content-title-heading">
          <div class="content-title-icon"><?php svg('shop-cart','i-3x');?></div>
          <div>Preferences - Cart</div>
          <div class="content-title-actions"></div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/preferences';?>">Preferences</a></li>
          <li class="breadcrumb-item active">Cart</li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0 shadow p-0 overflow-visible">
        <table class="table-zebra">
          <thead>
            <tr>
              <th>ID</th>
              <th>SID</th>
              <th class="text-center">Item</th>
              <th>Quantity</th>
              <th>Cost</th>
              <th>Date</th>
              <th>
                <div class="btn-group float-right">
                  <button class="trash" data-tooltip="tooltip" aria-label="Purge All" onclick="purge('0','cart');return false;"><?php svg('purge');?></button>
                </div>
              </th>
            </tr>
          </thead>
          <tbody id="l_cart">
            <?php $s=$db->prepare("SELECT * FROM `".$prefix."cart` ORDER BY `ti` DESC");
            $s->execute();
            while($r=$s->fetch(PDO::FETCH_ASSOC)){
              $ci=$db->prepare("SELECT `id`,`code`,`title` FROM `".$prefix."content` WHERE `id`=:id");
              $ci->execute([
                ':id'=>$r['iid']
              ]);
              $cr=$ci->fetch(PDO::FETCH_ASSOC);?>
              <tr id="l_<?php echo$r['id'];?>">
                <td class="text-wrap align-middle"><?php echo trim($r['id']);?></td>
                <td class="text-wrap align-middle"><?php echo trim($r['si']);?></td>
                <td class="text-center align-middle"><?php echo($cr['code']!=''?$cr['code'].' | ':'').$cr['title'];?></td>
                <td class="text-center align-middle"><?php echo$r['quantity'];?></td>
                <td class="text-center align-middle"><?php echo$r['cost'];?></td>
                <td class="text-center align-middle"><?php echo date($config['dateFormat'],$r['ti']);?></td>
                <td class="align-middle">
                  <button class="trash" data-tooltip="tooltip" aria-label="Delete" onclick="purge('<?php echo$r['id'];?>','cart');"><?php svg('trash');?></button>
                </td>
              </tr>
            <?php }?>
          </tbody>
        </table>
        <?php include'core/layout/footer.php';?>
      </div>
    </div>
  </section>
</main>
