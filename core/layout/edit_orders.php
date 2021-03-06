<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2018
 *
 * @category   Administration - Orders - Edit
 * @package    core/layout/edit_orders.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.5
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$q=$db->prepare("SELECT * FROM `".$prefix."orders` WHERE `id`=:id");
$q->execute([':id'=>$id]);
$r=$q->fetch(PDO::FETCH_ASSOC);
$q=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `id`=:id");
$q->execute([':id'=>$r['cid']]);
if($q->rowCount()>0){
  $client=$q->fetch(PDO::FETCH_ASSOC);
}else{
  $client=[
    'id'=>0,
    'options'=>00000000000000000000000000000000,
    'rank'=>0,
    'purchaseLimit'=>0,
    'spent'=>0,
    'points'=>0,
    'pti'=>0,
    'username'=>'',
    'name'=>'',
    'business'=>'',
    'email'=>'',
    'phone'=>'',
    'mobile'=>'',
    'address'=>'',
    'suburb'=>'',
    'city'=>'',
    'state'=>'',
    'postcode'=>0
  ];
}
$q=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `id`=:id");
$q->execute([':id'=>$r['uid']]);
$usr=$q->fetch(PDO::FETCH_ASSOC);
if($r['notes']==''){
  $r['notes']=$config['orderEmailNotes'];
  $q=$db->prepare("UPDATE `".$prefix."orders` SET `notes`=:notes WHERE `id`=:id");
  $q->execute([
    ':notes'=>$config['orderEmailNotes'],
    ':id'=>$r['id']
  ]);
}
if($error==1)echo'<div class="alert alert-danger" role="alert">'.$e[0].'</div>';
else{?>
  <main>
    <section id="content">
      <div class="content-title-wrapper mb-0">
        <div class="content-title">
          <div class="content-title-heading">
            <div class="content-title-icon"><?= svg2('order','i-3x');?></div>
            <div>Edit Order <?=$r['qid'].$r['iid'];?></div>
            <div class="content-title-actions">
              <?php if(isset($_SERVER['HTTP_REFERER'])){?>
                <a class="btn" data-tooltip="tooltip" href="<?=$_SERVER['HTTP_REFERER'];?>" role="button" aria-label="Back"><?= svg2('back');?></a>
              <?php }?>
              <button data-tooltip="tooltip" aria-label="Print Order" onclick="$('#sp').load('core/email_order.php?id=<?=$r['id'];?>&act=print');return false;"><?= svg2('print');?></button>
              <button data-tooltip="tooltip" aria-label="Email Order" onclick="$('#sp').load('core/email_order.php?id=<?=$r['id'];?>&act=');return false;"><?= svg2('email-send');?></button>
              <button class="saveall" data-tooltip="tooltip" aria-label="Save All Edited Fields"><?= svg2('save');?></button>
            </div>
          </div>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/orders';?>">Orders</a></li>
            <li class="breadcrumb-item">
              <?php if(isset($r['aid'])&&$r['aid']!='')echo'<a href="'.URL.$settings['system']['admin'].'/orders/archived">Archived</a>';
              elseif(isset($r['iid'])&&$r['iid']!='')echo'<a href="'.URL.$settings['system']['admin'].'/orders/invoices">Invoices</a>';
              elseif($r['qid']!='')echo'<a href="'.URL.$settings['system']['admin'].'/orders/quotes">Quotes</a>';?>
            </li>
            <li class="breadcrumb-item active"><span id="ordertitle"><?=$r['qid'].$r['iid'];?></span></li>
          </ol>
        </div>
      </div>
      <div class="container-fluid p-0">
        <div class="card border-radius-0 shadow px-4 py-3">
          <div class="row">
            <div class="col-12">
              <h4>Details</h4>
              <div class="form-row">
                <div class="input-text">Order #</div>
                <div class="input-text">
                  <a target="_blank" href="<?= URL.'orders/'.($r['iid']==''?$r['qid']:$r['iid']);?>"><?=$r['iid']==''?$r['qid']:$r['iid'].' '.svg2('new-window');?></a>
                </div>
                <div class="input-text">Created</div>
                <input id="detailscreated" type="text" value="<?=$r['iid_ti']!=0?date($config['dateFormat'],$r['iid_ti']):date($config['dateFormat'],$r['qid_ti']);?>" readonly aria-label="Date Created">
                <div class="input-text">Due</div>
                <input id="due_ti" type="date" value="<?= date('Y-m-d',$r['due_ti']);?>"<?php if($r['status']!='archived'){?> autocomplete="off" data-tooltip="tooltip" aria-label="Order Due Date" onchange="update(`<?=$r['id'];?>`,`orders`,`due_ti`,getTimestamp(`due_ti`));"<?php }?>>
                <div class="input-text">Status</div>
                <?php if($r['status']=='archived'||$r['status']=='paid')echo'<input type="text" value="'.ucfirst($r['status']).'" readonly>';
                else{?>
                  <select id="status" data-tooltip="tooltip" aria-label="Order Status" onchange="update('<?=$r['id'];?>','orders','status',$(this).val(),'select');">
                    <option value="pending"<?=$r['status']=='pending'?' selected':'';?>>Pending</option>
                    <option value="overdue"<?=$r['status']=='overdue'?' selected':'';?>>Overdue</option>
                    <option value="cancelled"<?=$r['status']=='cancelled'?' selected':'';?>>Cancelled</option>
                    <option value="paid"<?=$r['status']=='paid'?' selected':'';?>>Paid</option>
                  </select>
                <?php }?>
              </div>
              <div class="form-row">
                <div class="input-text col-12 col-sm">Rank:&nbsp;<span id="clientRank" class="badger badge-<?= rank($client['rank']);?>"><?= ucwords(rank($client['rank']));?></span></div>
                <div class="input-text col-12 col-sm">
<?php if($client['purchaseLimit']==0){
  if($client['rank']==200)$client['purchaseLimit']=$config['memberLimit'];
  if($client['rank']==210)$client['purchaseLimit']=$config['memberLimitSilver'];
  if($client['rank']==220)$client['purchaseLimit']=$config['memberLimitBronze'];
  if($client['rank']==230)$client['purchaseLimit']=$config['memberLimitGold'];
  if($client['rank']==240)$client['purchaseLimit']=$config['memberLimitPurchase'];
  if($client['rank']==310)$client['purchaseLimit']=$config['memberLimitSilver'];
  if($client['rank']==320)$client['purchaseLimit']=$config['memberLimitBronze'];
  if($client['rank']==330)$client['purchaseLimit']=$config['memberLimitGold'];
  if($client['rank']==340)$client['purchaseLimit']=$config['memberLimitPlatinum'];
  if($client['purchaseLimit']==0)$client['purchaseLimit']='No Limit';
}?>
                  Purchase Limit:&nbsp;<span id="clientPurchaseLimit"><?=$client['purchaseLimit'];?></span></div>
                <div class="input-text col-12 col-sm">Spent:&nbsp;$<span id="clientSpent"><?=$client['spent'];?></span></div>
                <div class="input-text col-12 col-sm">Points Earned:&nbsp;<span id="clientPoints"><?= number_format((float)$client['points']);?></span></div>
                <div class="input-text col-12 col-sm">Last Purchase:&nbsp;<span id="clientpti"><?= _ago($client['pti']);?></span></div>
              </div>
            </div>
          </div>
          <hr>
          <div class="row mt-3">
            <div class="col-12 col-md-6">
              <h4>From</h4>
              <p>
                <?='<strong>'.$config['business'].'</strong><br>'.
                '<small>'.
                  ($config['abn']!=''?'ABN: '.$config['abn'].'<br>':'').
                  ($config['email']!=''?'Email: '.$config['email'].'<br>':'').
                  ($config['phone']!=''?'Phone: '.$config['phone'].'<br>':'').
                  ($config['mobile']!=''?'Mobile: '.$config['mobile'].'<br>':'').
                  $config['address'].', '.$config['suburb'].', '.$config['city'].'<br>'.
                  $config['state'].($config['postcode']!=0?', '.$config['postcode']:'').
                '</small>';?>
              </p>
            </div>
            <div class="col-12 col-md-6 text-right">
              <h4>To</h4>
              <p id="to">
                <?='<strong>'.$client['username'].($client['name']!=''?' ['.$client['name'].']':'').'<br>'.
                ($client['business']!=''?' -> '.$client['business'].'<br>':'').'</strong>'.
                '<small>'.
                  ($client['email']!=''?'Email: '.$client['email'].'<br>':'').
                  ($client['phone']!=''?'Phone: '.$client['phone'].'<br>':'').
                  ($client['mobile']!=''?'Mobile: '.$client['mobile'].'<br>':'').
                  $client['address'].', '.$client['suburb'].', '.$client['city'].'<br>'.
                  $client['state'].', '.($client['postcode']!=0?', '.$client['postcode']:'').
                '</small>';?>
              </p>
              <?php if($r['status']!='archived'){?>
                <div class="form-row">
                  <div class="input-text">Client</div>
                  <select id="changeClient" data-tooltip="tooltip" aria-label="Select a Client..." onchange="changeClient($(this).val(),'<?=$r['id'];?>');">
                    <option value="0"<?=$r['cid']=='0'?' selected':'';?>>None</option>
                    <?php $q=$db->query("SELECT `id`,`business`,`username`,`name` FROM `".$prefix."login` WHERE `status`!='delete' AND `status`!='suspended' AND `id`!='0'");
                    if($q->rowCount()>0){
                      while($rs=$q->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['id'].'"'.($r['cid']==$rs['id']?' selected':'').'>'.$rs['username'].($rs['name']!=''?' ['.$rs['name'].']':'').($rs['business']!=''?' -> '.$rs['business'].'</option>':'');
                    }?>
                  </select>
                </div>
              <?php }?>
            </div>
            <?php if($r['status']!='archived'){?>
              <form class="form-row" target="sp" method="post" action="core/updateorder.php">
                <input name="act" type="hidden" value="additem">
                <input name="id" type="hidden" value="<?=$r['id'];?>">
                <input name="t" type="hidden" value="orderitems">
                <input name="c" type="hidden" value="">
                <div class="input-text">Inventory/Services/Events</div>
                <select name="da" data-tooltip="tooltip" aria-label="Select Product, Service, Event or Empty Entry">
                  <option value="0">Add Empty Entry...</option>
                  <option value="neg">Add Deducation Entry...</option>
                  <?php $s=$db->query("SELECT `id`,`contentType`,`code`,`cost`,`title` FROM `".$prefix."content` WHERE `contentType`='inventory' OR `contentType`='service' OR `contentType`='events' ORDER BY `contentType` ASC, `code` ASC");
                  if($s->rowCount()>0){
                    while($i=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$i['id'].'">'.ucfirst(rtrim($i['contentType'],'s')).$i['code'].':$'.$i['cost'].':'.$i['title'].'</option>';
                  }?>
                </select>
                <button class="add" data-tooltip="tooltip" type="submit" aria-label="Add"><?= svg2('add');?></button>
              </form>
              <div class="row">
                <small class="form-text text-muted">Note: Adding or removing items does not recalculate Postage Costs, you will need to do that manually with the selection below</small>
              </div>
              <?php $sp=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='postoption' ORDER BY `title` ASC");
              $sp->execute();
              if($sp->rowCount()>0){?>
                <form class="form-row" target="sp" method="post" action="core/updateorder.php">
                  <input name="act" type="hidden" value="addpostoption">
                  <input name="id" type="hidden" value="<?=$r['id'];?>">
                  <input name="t" type="hidden" value="orders">
                  <input name="c" type="hidden" value="postageOption">
                  <div class="input-text">Postage Options</div>
                  <select name="da" data-tooltip="tooltip" aria-label="Select Postage Option or Empty Entry" onchange="$('.page-block').addClass('d-block');this.form.submit();">
                    <option value="0">Clear Postage Option and Cost</option>
                    <?php while($rp=$sp->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rp['id'].'">'.$rp['title'].($rp['value']>0?' : $'.$rp['value']:'').'</option>';?>
                  </select>
                </form>
              <?php }
            }?>
            <table class="table zebra">
              <thead>
                <tr class="bg-black text-white">
                  <th style="width:30px;">
                    <input type="checkbox" id="itemchecker" onClick="orderitemstoggle(this);">
                  </th>
                  <th>Code</th>
                  <th class="col text-left">Title</th>
                  <th class="col-1">Option</th>
                  <th class="col-1 text-center">Quantity</th>
                  <th class="col-1 text-center">Cost</th>
                  <th class="col-1 text-right">GST</th>
                  <th class="col-1 text-right">Total</th>
                  <th class="col-1 align-middle">
                    <form target="sp" type="post" action="core/updateorder.php">
                      <input type="hidden" name="id" value="<?=$r['id'];?>">
                      <input type="hidden" id="actionda" name="da" value="">
                      <select id="action" class="pull-right text-black select-sm" name="act" onchange="actionItems();this.form.submit();">
                        <option value="0" selected hidden>Action</option>
                        <option value="removeItems">Remove Selected Items</option>
                        <option value="newQuote">Create New Quote with Selected Items</option>
                        <option value="newInvoice">Create New Invoice with Selected Items</option>
                        <option value="statusAvailable">Change Selected Items Status to "Available"</option>
                        <option value="statusPreorder">Change Selected Items Status to "Pre-Order"</option>
                      </select>
                    </form>
                    <script>
                      function actionItems(){
                        var items=$.map($('input[name="item"]:checked'),function(c){return c.value;});
                        $('#actionda').val(items);
                        $('#itemchecker').prop("checked",false);
                      }
                    </script>
                  </th>
                </tr>
              </thead>
              <tbody id="updateorder">
                <?php $s=$db->prepare("SELECT * FROM `".$prefix."orderitems` WHERE `oid`=:oid AND `status`!='neg' ORDER BY `status` ASC, `ti` ASC,`title` ASC");
                $s->execute([':oid'=>$r['id']]);
                $total=0;
                while($oi=$s->fetch(PDO::FETCH_ASSOC)){
                  $is=$db->prepare("SELECT `id`,`thumb`,`file`,`fileURL`,`code`,`title` FROM `".$prefix."content` WHERE `id`=:id");
                  $is->execute([':id'=>$oi['iid']]);
                  $i=$is->fetch(PDO::FETCH_ASSOC);
                  $sc=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `id`=:id");
                  $sc->execute([':id'=>$oi['cid']]);
                  $c=$sc->fetch(PDO::FETCH_ASSOC);?>
                  <tr>
                    <td class="align-middle">
                      <input type="checkbox" class="orderitems" name="item" value="<?=$oi['id'];?>">
                    </td>
                    <td class="text-left align-middle small px-0"><?=$i['code'];?></td>
                    <td class="text-left align-middle px-0">
                      <?php if($r['iid_ti']!=0)echo$i['title'];
                      else{?>
                        <form target="sp" method="post" action="core/updateorder.php">
                          <input name="act" type="hidden" value="title">
                          <input name="id" type="hidden" value="<?=$oi['id'];?>">
                          <input name="t" type="hidden" value="orderitems">
                          <input name="c" type="hidden" value="title">
                          <input name="da" type="text" value="<?=$oi['title'];?>">
                        </form>
                      <?php }?>
                    </td>
                    <td class="text-left align-middle px-0"><?=$c['title'];?></td>
                    <td class="text-center align-middle px-0">
                      <?php if($oi['iid']!=0){?>
                        <form target="sp" method="post" action="core/updateorder.php">
                          <input name="act" type="hidden" value="quantity">
                          <input name="id" type="hidden" value="<?=$oi['id'];?>">
                          <input name="t" type="hidden" value="orderitems">
                          <input name="c" type="hidden" value="quantity">
                          <input class="text-center" name="da" type="text" value="<?=$oi['quantity'];?>"<?=$r['status']=='archived'?' readonly':'';?>>
                        </form>
                      <?php }else{
                        if($oi['iid']!=0)echo$oi['quantity'];
                      }?>
                    </td>
                    <td class="text-right align-middle px-0">
                      <?php if($oi['iid']!=0){?>
                        <form target="sp" method="post" action="core/updateorder.php">
                          <input name="act" type="hidden" value="cost">
                          <input name="id" type="hidden" value="<?=$oi['id'];?>">
                          <input name="t" type="hidden" value="orderitems">
                          <input name="c" type="hidden" value="cost">
                          <input class="text-center" style="min-width:80px" name="da" value="<?= number_format((float)$oi['cost'],2,'.','');?>"<?=$r['status']=='archived'?' readonly':'';?>>
                        </form>
                      <?php }elseif($oi['iid']!=0)echo number_format((float)$oi['cost'],2,'.','');?>
                    </td>
                    <td class="text-right align-middle px-0">
                      <?php
                      $gst=0;
                      if($oi['status']!='pre-order'){
                        if($config['gst']>0){
                          $gst=$oi['cost']*($config['gst']/100);
                          if($oi['quantity']>1)$gst=$gst*$oi['quantity'];
                          $gst=number_format((float)$gst,2,'.','');
                        }
                        echo$gst>0?$gst:'';
                      }
                      ?>
                    </td>
                    <td class="text-right align-middle px-0">
                      <?php
                      if($oi['status']!='pre-order'){
                        echo$oi['iid']!=0?number_format((float)$oi['cost']*$oi['quantity']+$gst,2,'.',''):'';
                      }else{
                          echo'<small>Pre-Order</small>';
                      }?>
                    </td>
                    <td class="align-middle text-right px-0">
                      <form target="sp" method="post" action="core/updateorder.php">
                        <input name="act" type="hidden" value="trash">
                        <input name="id" type="hidden" value="<?=$oi['id'];?>">
                        <input name="t" type="hidden" value="orderitems">
                        <input name="c" type="hidden" value="quantity">
                        <input name="da" type="hidden" value="0">
                        <button class="trash" data-tooltip="tooltip" aria-label="Delete"><?= svg2('trash');?></button>
                      </form>
                    </td>
                  </tr>
                  <?php
                    if($oi['status']!='pre-order'){
                      if($oi['iid']!=0){
                        $total=$total+($oi['cost']*$oi['quantity'])+$gst;
                        $total=number_format((float)$total,2,'.','');
                      }
                    }
                  }
                  $sr=$db->prepare("SELECT * FROM `".$prefix."rewards` WHERE `id`=:rid");
                  $sr->execute([':rid'=>$r['rid']]);
                  $reward=$sr->fetch(PDO::FETCH_ASSOC);?>
                  <tr>
                    <td class="text-right align-middle px-0" colspan="2"><div class="input-text">Rewards</div></td>
                    <form class="form-row" id="rewardsinput" target="sp" method="post" action="core/updateorder.php">
                      <td class="text-center px-0" colspan="1">
                        <input name="act" type="hidden" value="reward">
                        <input name="id" type="hidden" value="<?=$r['id'];?>">
                        <input name="t" type="hidden" value="orders">
                        <input name="c" type="hidden" value="rid">
                        <?php $ssr=$db->prepare("SELECT * FROM `".$prefix."rewards` ORDER BY `code` ASC, `title` ASC");
                        $ssr->execute();
                        if($ssr->rowCount()>0){?>
                          <select onchange="$('#rewardselect').val($(this).val());$('#rewardsinput:first').submit();">
                            <option value="">Rewards Codes</option>
                            <?php while($srr=$ssr->fetch(PDO::FETCH_ASSOC)){?>
                              <option value="<?=$srr['code'];?>"<?=$srr['code']==$reward['code']?' selected':'';?>><?=$srr['code'].':'.($srr['method']==1?'$'.$srr['value']:$srr['value'].'%').' Off';?></option>
                            <?php }?>
                          </select>
                        <?php }?>
                      </td>
                      <td class="align-middle px-0" colspan="3">
                        <input id="rewardselect" name="da" type="text" value="<?=$sr->rowCount()==1?$reward['code']:'';?>" onchange="$('#rewardsinput:first').submit();">
                      </td>
                      </form>
                    </td>
                    <td class="text-center align-middle px-0">
                      <?php if($sr->rowCount()==1){
                        if($reward['method']==1){
                          echo'$';
                          $total=$total-$reward['value'];
                        }
                        echo$reward['value'];
                        if($reward['method']==0){
                          echo'%';
                          $total=($total*((100-$reward['value'])/100));
                        }
                        $total=number_format((float)$total, 2, '.', '');
                        echo' Off';
                      }?>
                    </td>
                    <td class="text-right align-middle px-0"><?=$reward['value']>0?$total:'';?></td>
                    <td>&nbsp;</td>
                  </tr>
<?php if($config['options'][26]==1){
  $dedtot=0;
  $sd=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='discountrange' AND `f`<:f AND `t`>:t");
  $sd->execute([
    ':f'=>$client['spent'],
    ':t'=>$client['spent']
  ]);
  if($sd->rowCount()>0){
    $rd=$sd->fetch(PDO::FETCH_ASSOC);
    if($rd['value']==1)$dedtot=$rd['cost'];
    if($rd['value']==2)$dedtot=$total*($rd['cost']/100);
    $total=$total - $dedtot;?>
                      <tr>
                        <td class="align-middle text-right px-0" colspan="2"><div class="input-text">Spent</div></td>
                        <td class="align-middle" colspan="5">&#36;<?=$client['spent'];?> within Discount Range &#36;<?=$rd['f'].'-&#36;'.$rd['t'];?> granting <?=($rd['value']==2?$rd['cost'].'&#37;':'&#36;'.$rd['cost'].' Off');?></td>
                        <td class="text-right align-middle px-0">-<?=$dedtot;?></td>
                        <td>&nbsp;</td>
                      </tr>
<?php }
}?>
                  <tr>
                    <td class="text-right align-middle px-0" colspan="2"><div class="input-text">Shipping</div></td>
                    <td class="align-middle px-0" colspan="1">
                      <form target="sp" method="post" action="core/updateorder.php" onchange="$(this).submit();">
                        <input name="act" type="hidden" value="postselect">
                        <input name="id" type="hidden" value="<?=$r['id'];?>">
                        <input name="t" type="hidden" value="orders">
                        <input name="c" type="hidden" value="postageCode">
                        <select name="da">
                          <option value="">Shipping Options</option>
                          <option value="AUS_PARCEL_REGULAR">Australia Post Regular Post</option>
            							<option value="AUS_PARCEL_EXPRESS">Australia Post Express Post</option>
                          <?php $spo=$db->query("SELECT * FROM `".$prefix."choices` WHERE `contentType`='postageoption' ORDER BY `title` ASC");
                          if($spo->rowCount()>0){
                            while($rpo=$spo->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rpo['id'].'">'.$rpo['title'].'</option>';
                          }?>
                        </select>
                      </form>
                    </td>
                    <td class="text-right align-middle px-0" colspan="4">
                      <form target="sp" method="post" action="core/updateorder.php" onchange="$(this).submit();">
                        <input name="act" type="hidden" value="postoption">
                        <input name="id" type="hidden" value="<?=$r['id'];?>">
                        <input name="t" type="hidden" value="orders">
                        <input name="c" type="hidden" value="postageOption">
                        <input name="da" type="text" value="<?=$r['postageOption'];?>">
                      </form>
                    </td>
                    <td class="text-right px-0">
                      <form target="sp" method="post" action="core/updateorder.php" onchange="$(this).submit();">
                        <input name="act" type="hidden" value="postcost">
                        <input name="id" type="hidden" value="<?=$r['id'];?>">
                        <input name="t" type="hidden" value="orders">
                        <input name="c" type="hidden" value="postageCost">
                        <input class="text-right" name="da" type="text" value="<?=$r['postageCost'];?>">
                        <?php if($r['postageCost']>0){
                          $total=$total+$r['postageCost'];
                          $total=number_format((float)$total, 2, '.', '');
                        }?>
                      </form>
                    </td>
                    <td></td>
                  </tr>
                  <tr>
                    <td class="text-right align-middle px-0" colspan="2"><div class="input-text">Payment</div></td>
                    <td class="align-middle px-0" colspan="1">
                      <?php $spo=$db->query("SELECT * FROM `".$prefix."choices` WHERE `contentType`='payoption' ORDER BY title ASC");
                      if($spo->rowCount()>0){?>
                        <form target="sp" method="post" action="core/updateorder.php" onchange="$(this).submit();">
                          <input name="act" type="hidden" value="payselect">
                          <input name="id" type="hidden" value="<?=$r['id'];?>">
                          <input name="t" type="hidden" value="orders">
                          <input name="c" type="hidden" value="payOption">
                          <select name="da">
                            <option value="0">Payment Options</option>
                            <?php while($rpo=$spo->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rpo['id'].'">'.$rpo['title'].($rpo['value']!=0?' (Surcharge '.($rpo['type']==1?$rpo['value'].'%':'$'.$rpo['value']).')':'').'</option>';?>
                          </select>
                        </form>
                      <?php }?>
                    </td>
                    <td class="text-right align-middle px-0" colspan="3">
                      <form target="sp" method="post" action="core/updateorder.php" onchange="$(this).submit();">
                        <input type="hidden" name="act" value="paytext">
                        <input type="hidden" name="id" value="<?=$r['id'];?>">
                        <input type="hidden" name="t" value="orders">
                        <input type="hidden" name="c" value="payOption">
                        <input type="text" name="da" value="<?=$r['payOption'];?>">
                      </form>
                    </td>
                    <td class="text-right align-middle px-0">
                      <form target="sp" method="post" action="core/updateorder.php" onchange="$(this).submit();">
                        <input type="hidden" name="act" value="paymethod">
                        <input type="hidden" name="id" value="<?=$r['id'];?>">
                        <input type="hidden" name="t" value="orders">
                        <input type="hidden" name="c" value="payMethod">
                        <select name="da" class="pl-1 pr-1">
                          <option value="2"<?=$r['payMethod']==2?' selected':'';?>>Add &#36;</option>
                          <option vlaue="1"<?=$r['payMethod']==1?' selected':'';?>>Add &#37;</option>
                        </select>
                      </form>
                      <?php if($r['payMethod']==1){
                        $paytot=$total*($r['payCost']/100);
                      }else{
                        $paytot=$r['payCost'];
                      }?>
                    </td>
                    <td class="align-middle text-right px-0">
                      <?php if($r['payMethod']==2){?>
                        <form target="sp" method="post" action="core/updateorder.php" onchange="$(this).submit();">
                          <input type="hidden" name="act" value="paycost">
                          <input type="hidden" name="id" value="<?=$r['id'];?>">
                          <input type="hidden" name="t" value="orders">
                          <input type="hidden" name="c" value="payCost">
                          <input type="text" class="text-right" name="da" value="<?= number_format((float)$paytot,2,'.','');?>">
                        </form>
                      <?php }else echo number_format((float)$paytot,2,'.','');
                      $total=$total+$paytot;
                      $total=number_format((float)$total,2,'.','');?>
                    </td>
                    <td></td>
                  </tr>
                  <tr>
                    <td class="text-right" colspan="7"><strong>Total</strong></td>
                    <td class="total text-right border-2 border-black border-top border-bottom px-0"><strong><?=$total;?></strong></td>
                    <td>&nbsp;</td>
                  </tr>
                  <?php $su=$db->prepare("UPDATE `".$prefix."orders` SET `total`=:total WHERE `id`=:id");
                  $su->execute([
                    ':id'=>$r['id'],
                    ':total'=>$total
                  ]);
                  $sn=$db->prepare("SELECT * FROM `".$prefix."orderitems` WHERE `oid`=:oid AND `status`='neg' ORDER BY `ti` ASC");
                  $sn->execute([':oid'=>$r['id']]);
                  if($sn->rowCount()>0){
                     while($rn=$sn->fetch(PDO::FETCH_ASSOC)){?>
                       <tr>
                        <td class="small align-middle px-0" colspan="2"><small><?= date($config['dateFormat'],$rn['ti']);?></small></td>
                        <td class="align-middle px-0" colspan="5">
                          <form target="sp" method="post" action="core/updateorder.php">
                            <input name="act" type="hidden" value="title">
                            <input name="id" type="hidden" value="<?=$rn['id'];?>">
                            <input name="t" type="hidden" value="orderitems">
                            <input name="c" type="hidden" value="title">
                            <div class="form-row">
                              <input name="da" type="text" value="<?=$rn['title'];?>">
                              <div class="input-text">minus</div>
                            </div>
                          </form>
                        </td>
                        <td class="text-right align-middle px-0">
                          <form target="sp" method="post" action="core/updateorder.php">
                            <input name="act" type="hidden" value="cost">
                            <input name="id" type="hidden" value="<?=$rn['id'];?>">
                            <input name="t" type="hidden" value="orderitems">
                            <input name="c" type="hidden" value="cost">
                            <input class="text-right" name="da" value="<?=$rn['cost'];?>">
                          </form>
                        </td>
                        <td class="text-right px-0">
                          <form target="sp" method="post" action="core/updateorder.php">
                            <input name="act" type="hidden" value="trash">
                            <input name="id" type="hidden" value="<?=$rn['id'];?>">
                            <input name="t" type="hidden" value="orderitems">
                            <input name="c" type="hidden" value="quantity">
                            <input name="da" type="hidden" value="0">
                            <button class="trash" data-tooltip="tooltip" aria-label="Delete"><?= svg2('trash');?></button>
                          </form>
                        </td>
                      </tr>
                      <?php $total=$total-$rn['cost'];
                    }
                    $total=number_format((float)$total,2,'.','');?>
                    <tr>
                      <td class="text-right" colspan="7"><strong>Balance</strong></td>
                      <td class="total text-right border-2 border-black border-top border-bottom px-0"><strong><?=$total;?></td>
                      <td></td>
                    </tr>
                  <?php
                  $so=$db->prepare("UPDATE `".$prefix."orders` SET `total`=:total WHERE id=:id");
                  $so->execute([
                    ':id'=>$r['id'],
                    ':total'=>$total
                  ]);
                }?>
                </tbody>
              </table>
            </div>
            <div class="col-sm-6">
              <?php if($r['status']!='archived'&&$user['rank']>699){?>
                <form target="sp" method="post" action="core/update.php">
                  <input name="id" type="hidden" value="<?=$r['id'];?>">
                  <input name="t" type="hidden" value="orders">
                  <input name="c" type="hidden" value="notes">
                  <textarea class="summernote" name="da"><?= rawurldecode($r['notes']);?></textarea>
                </form>
              <?php }else echo'<div class="well">'.$r['notes'].'</div>';?>
            </div>
            <?php require'core/layout/footer.php';?>
          </div>
        </div>
      </section>
    </main>
<?php }
