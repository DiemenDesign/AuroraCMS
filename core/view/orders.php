<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - View - Orders
 * @package    core/view/orders.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.5
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
require'core/puconverter.php';
$html=preg_replace([
  isset($_SESSION['loggedin'])&&$_SESSION['loggedin']==false?'~<orderlist>.*?<\/orderlist>~is':'/<[\/]?orderlist>/',
  $page['notes']!=''?'/<[\/]?pagenotes>/':'~<pagenotes>.*?<\/pagenotes>~is',
  '/<print page=[\"\']?notes[\"\']?>/',
],[
  '',
  '',
  $page['notes']
],$html);
if(stristr($html,'<order>')){
  preg_match('/<order>([\w\W]*?)<\/order>/',$html,$matches);
  $order=$matches[1];
  $html=preg_replace('~<order>.*?<\/order>~is','<order>',$html,1);
}
if(stristr($html,'<items>')){
  preg_match('/<items>([\w\W]*?)<\/items>/',$html,$matches);
  $items=$matches[1];
  $output='';
  $zebra=1;
  $s=$db->prepare("SELECT * FROM `".$prefix."orders` WHERE `cid`=:cid AND `status`!='archived' ORDER BY `ti` DESC");
  $s->execute([':cid'=>isset($_SESSION['uid'])?$_SESSION['uid']:0]);
  while($r=$s->fetch(PDO::FETCH_ASSOC)){
    $item=$items;
    $item=preg_replace([
      '/<print zebra>/',
      '/<print order=[\"\']?ordernumber[\"\']?>/',
      '/<print order=[\"\']?status[\"\']?>/',
      '/<print order=[\"\']?date[\"\']?>/',
      '/<print order=[\"\']?duedate[\"\']?>/',
      '/<print link>/'
    ],[
      'zebra'.$zebra,
      $r['qid'].$r['iid'],
      ucfirst($r['status']),
      $r['iid_ti']>0?date($config['dateFormat'],$r['iid_ti']):date($config['dateFormat'],$r['qid_ti']),
      date($config['dateFormat'],$r['due_ti']),
      URL.'orders/'.$r['qid'].$r['iid'].'/'
    ],$item);
    $output.=$item;
    $zebra=$zebra==2?$zebra=1:$zebra=2;
  }
  $html=preg_replace('~<items>.*?<\/items>~is',$output,$html,1);
}
if(isset($args[0])&&$args[0]!=''){
  // https://developers.auspost.com.au/apis/pac/tutorial/domestic-parcel
  preg_match('/<items>([\w\W]*?)<\/items>/',$order,$matches);
  $orderItem=$matches[1];
  $order=preg_replace('~<items>.*?<\/items>~is','<orderitems>',$order,1);
  $s=$db->prepare("SELECT * FROM `".$prefix."orders` WHERE `qid`=:id OR `iid`=:id AND `status`!='archived'");
  $s->execute([':id'=>$args[0]]);
  if($s->rowCount()>0){
    $r=$s->fetch(PDO::FETCH_ASSOC);
    $su=$db->prepare("SELECT * FROM `".$prefix."login` WHERE `id`=:uid");
    $su->execute([':uid'=>$r['cid']]);
    $ru=$su->fetch(PDO::FETCH_ASSOC);
    $order=$r['iid_ti']>0?preg_replace('/<print order=[\"\']?date[\"\']?>/',date($config['dateFormat'],$r['iid_ti']),$order):preg_replace('/<print order=[\"\']?date[\"\']?>/',date($config['dateFormat'],$r['qid_ti']),$order);
    $order=preg_replace([
      '/<print order=[\"\']?notes[\"\']?>/',
      '/<print config=[\"\']?business[\"\']?>/',
      '/<print config=[\"\']?abn[\"\']?>/',
      '/<print config=[\"\']?address[\"\']?>/',
      '/<print config=[\"\']?suburb[\"\']?>/',
      '/<print config=[\"\']?city[\"\']?>/',
      '/<print config=[\"\']?state[\"\']?>/',
      '/<print config=[\"\']?postcode[\"\']?>/',
      '/<print config=[\"\']?email[\"\']?>/',
      '/<print config=[\"\']?phone[\"\']?>/',
      '/<print config=[\"\']?mobile[\"\']?>/',
      '/<print config=[\"\']?bank[\"\']?>/',
      '/<print config=[\"\']?bankAccountName[\"\']?>/',
      '/<print config=[\"\']?bankAccountNumber[\"\']?>/',
      '/<print config=[\"\']?bankBSB[\"\']?>/',
      '/<print user=[\"\']?name[\"\']?>/',
      '/<print user=[\"\']?business[\"\']?>/',
      '/<print user=[\"\']?address[\"\']?>/',
      '/<print user=[\"\']?suburb[\"\']?>/',
      '/<print user=[\"\']?city[\"\']?>/',
      '/<print user=[\"\']?state[\"\']?>/',
      '/<print user=[\"\']?postcode[\"\']?>/',
      '/<print user=[\"\']?email[\"\']?>/',
      '/<print user=[\"\']?phone[\"\']?>/',
      '/<print user=[\"\']?mobile[\"\']?>/',
      '/<print order=[\"\']?ordernumber[\"\']?>/',
      '/<print order=[\"\']?duedate[\"\']?>/',
      '/<print status>/',
      '/<print order=[\"\']?status[\"\']?>/'
    ],[
      rawurldecode($r['notes']),
      htmlspecialchars($config['business'],ENT_QUOTES,'UTF-8'),
      htmlspecialchars($config['abn'],ENT_QUOTES,'UTF-8'),
      htmlspecialchars($config['address'],ENT_QUOTES,'UTF-8'),
      htmlspecialchars($config['suburb'],ENT_QUOTES,'UTF-8'),
      htmlspecialchars($config['city'],ENT_QUOTES,'UTF-8'),
      htmlspecialchars($config['state'],ENT_QUOTES,'UTF-8'),
      $config['postcode']==0?'':htmlspecialchars($config['postcode'],ENT_QUOTES,'UTF-8'),
      htmlspecialchars($config['email'],ENT_QUOTES,'UTF-8'),
      htmlspecialchars($config['phone'],ENT_QUOTES,'UTF-8'),
      htmlspecialchars($config['mobile'],ENT_QUOTES,'UTF-8'),
      htmlspecialchars($config['bank'],ENT_QUOTES,'UTF-8'),
      htmlspecialchars($config['bankAccountName'],ENT_QUOTES,'UTF-8'),
      htmlspecialchars($config['bankAccountNumber'],ENT_QUOTES,'UTF-8'),
      htmlspecialchars($config['bankBSB'],ENT_QUOTES,'UTF-8'),
      htmlspecialchars($ru['name']!=''?$ru['name']:$ru['business'],ENT_QUOTES,'UTF-8'),
      htmlspecialchars($ru['business']!=''?$ru['business']:$ru['name'],ENT_QUOTES,'UTF-8'),
      htmlspecialchars($ru['address'],ENT_QUOTES,'UTF-8'),
      htmlspecialchars($ru['suburb'],ENT_QUOTES,'UTF-8'),
      htmlspecialchars($ru['city'],ENT_QUOTES,'UTF-8'),
      htmlspecialchars($ru['state'],ENT_QUOTES,'UTF-8'),
      $ru['postcode']==0?'':htmlspecialchars($ru['postcode'],ENT_QUOTES,'UTF-8'),
      htmlspecialchars($ru['email'],ENT_QUOTES,'UTF-8'),
      htmlspecialchars($ru['phone'],ENT_QUOTES,'UTF-8'),
      htmlspecialchars($ru['mobile'],ENT_QUOTES,'UTF-8'),
      $r['qid'].$r['iid'],
      date($config['dateFormat'],$r['due_ti']),
      $r['status'],
      htmlspecialchars(ucfirst($r['status']),ENT_QUOTES,'UTF-8'),
    ],$order);
    $ois=$db->prepare("SELECT * FROM `".$prefix."orderitems` WHERE `oid`=:oid AND `status`!='neg' ORDER BY `status` ASC, `ti` ASC, `title` ASC");
    $ois->execute([':oid'=>$r['id']]);
    $outitems='';
    $total=$weight=$totalWeight=$dimW=$dimL=$dimH=0;
    $zebra=1;
    while($oir=$ois->fetch(PDO::FETCH_ASSOC)){
      $is=$db->prepare("SELECT * FROM `".$prefix."content` WHERE `id`=:id");
			$is->execute([':id'=>$oir['iid']]);
			$i=$is->fetch(PDO::FETCH_ASSOC);
      $sc=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `id`=:id");
      $sc->execute([':id'=>$oir['cid']]);
      $c=$sc->fetch(PDO::FETCH_ASSOC);
      $item=$orderItem;
      $gst=0;
      if($oir['status']!='pre-order'){
        if($config['gst']>0){
          $gst=$oir['cost']*($config['gst']/100);
          if($oir['quantity']>1)$gst=$gst*$oir['quantity'];
          $gst=number_format((float)$gst, 2, '.', '');
        }
      }
      $item=preg_replace([
        '/<print zebra>/',
        '/<print orderitem=[\"\']?code[\"\']?>/',
        '/<print orderitem=[\"\']?title[\"\']?>/',
        '/<print weight>/',
        '/<print size>/',
        '/<print choice>/',
        '/<print orderitem=[\"\']?quantity[\"\']?>/',
        '/<print orderitem=[\"\']?cost[\"\']?>/',
        '/<print orderitem=[\"\']?gst[\"\']?>/',
        '/<print orderitem=[\"\']?subtotal[\"\']?>/'
      ],[
        'zebra'.$zebra,
        htmlspecialchars($i['code'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($i['title'],ENT_QUOTES,'UTF-8'),
        ($i['weight']==''?'':'<br><small>Weight: '.$i['weight'].$i['weightunit']),
        ($i['width']==''?'':'<br><small>W: '.$i['width'].$i['widthunit'].' L: '.$i['length'].$i['lengthunit'].' H: '.$i['height'].$i['heightunit'].'</small>'),
        isset($c['title'])?htmlspecialchars($c['title'],ENT_QUOTES,'UTF-8'):'',
        htmlspecialchars($oir['quantity'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($oir['cost'],ENT_QUOTES,'UTF-8'),
        $gst,
        ($oir['status']!='pre-order'?htmlspecialchars($oir['cost']*$oir['quantity']+$gst,ENT_QUOTES,'UTF-8'):'<small>Pre-Order</small>')
      ],$item);
      if($oir['status']!='pre-order'){
        $total=$total+($oir['cost']*$oir['quantity'])+$gst;
      }
      if(isset($i['weightunit'])&&$i['weightunit']!='kg')$i['weight']=weight_converter($i['weight'],$i['weightunit'],'kg');
			$weight=(int)$weight+((int)$i['weight']*(int)$oir['quantity']);
			if(isset($i['widthunit'])&&$i['widthunit']!='cm')$i['width']=length_converter($i['width'],$i['widthunit'],'cm');
			if(isset($i['lengthunit'])&&$i['lengthunit']!='cm')$i['length']=length_converter($i['length'],$i['lengthunit'],'cm');
			if(isset($i['heightunit'])&&$i['heightunit']!='cm')$i['height']=length_converter($i['height'],$i['heightunit'],'cm');
			if($i['width']>$dimW)$dimW=$i['width'];
			if($i['length']>$dimL)$dimL=$i['length'];
			$dimH=(int)$dimH+((int)$i['height']*(int)$oir['quantity']);
      $outitems.=$item;
      $zebra=$zebra==2?$zebra=1:$zebra=2;
    }
    $order=preg_replace([
      '/<print dimensions>/',
      '/<print weight>/'
    ],[
      'W: '.$dimW.'cm X L: '.$dimL.'cm X H: '.$dimH.'cm',
      $weight.'kg'.($weight>22?'<br><div class="alert alert-danger">As the weight of your items exceeds 22kg you will not be able to use Australia Post.</div>':'')
    ],$order);
    $sr=$db->prepare("SELECT * FROM `".$prefix."rewards` WHERE `id`=:id");
    $sr->execute([':id'=>$r['rid']]);
    if($sr->rowCount()>0){
      $reward=$sr->fetch(PDO::FETCH_ASSOC);
      $total=$reward['method']==1?$total-$reward['value']:($total*((100-$reward['value'])/100));
      $total=number_format((float)$total, 2, '.', '');
      $order=preg_replace([
        '/<print rewards=[\"\']?code[\"\']?>/',
        '/<print rewards=[\"\']?method[\"\']?>/',
        '/<print rewards=[\"\']?value[\"\']?>/',
        '/<[\/]?rewards>/'
      ],[
        $reward['code'],
        $reward['method']==1?'$'.$reward['value'].' Off':$reward['value'].'% Off',
        $total,
        ''
      ],$order);
    }else$order=preg_replace('~<rewards>.*?<\/rewards>~is','',$order,1);

    if($config['options'][26]==1){
      $dedtot=0;
      $sd=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='discountrange' AND `f`<:f AND `t`>:t");
      $sd->execute([
        ':f'=>$ru['spent'],
        ':t'=>$ru['spent']
      ]);
      if($sd->rowCount()>0){
        $rd=$sd->fetch(PDO::FETCH_ASSOC);
        if($rd['value']==1){
          $dedtot=$rd['cost'];
        }
        if($rd['value']==2){
          $dedtot=$total*($rd['cost']/100);
        }
        $total=$total - $dedtot;
      }
      $order=preg_replace([
        $sd->rowCount()>0?'/<[\/]?discountRange>/':'~<discountRange>.*?<\/discountRange>~is',
        '/<print discount=[\"\']?method[\"\']?>/',
        '/<print discount=[\"\']?total[\"\']?>/'
      ],[
        '',
        $sd->rowCount()>0?'Spent over &#36;'.$rd['f'].' discount of '.($rd['value']==2?$rd['cost'].'&#37;':'&#36;'.$rd['cost']).' Off':'',
        $dedtot
      ],$order);
    }else$order=preg_replace('~<discountRange>.*?<\/discountRange>~is','',$order,1);
    $order=preg_replace([
      '/<print orderurl>/',
      '/<print order=[\"\']?oid[\"\']?>/',
      '/<print order=[\"\']?postOption[\"\']?>/',
      '/<print order=[\"\']?postCost[\"\']?>/'
    ],[
      URL.'orders/'.$r['qid'].$r['iid'].'/',
      $r['id'],
      $r['postageOption'],
      $r['postageCost'],
    ],$order);
    $total=$total+$r['postageCost'];
    $total=number_format((float)$total, 2, '.', '');
    $paytot=0;
    if($r['payMethod']==1)$paytot=$total*($r['payCost']/100);
    if($r['payMethod']==2)$paytot=$r['payCost'];
    $total=number_format((float)$total, 2, '.', '');
    $order=preg_replace([
      '/<print order=[\"\']?paymentOption[\"\']?>/',
      '/<print order=[\"\']?paymentCost[\"\']?>/'
    ],[
      $r['payOption'].($r['payMethod']==2?' (&#36;'.$r['payCost'].' surcharge)':' ('.$r['payCost'].'&#37; surcharge)'),
      $paytot>0?$paytot:''
    ],$order);
    $total=$total+$paytot;
    $total=number_format((float)$total,2,'.','');
    $order=preg_replace([
      '/<print order=[\"\']?total[\"\']?>/',
      '/<print order=[\"\']?id[\"\']?>/',
      '~<orderitems>~is'
    ],[
      $total,
      $r['id'],
      $outitems
    ],$order);
    if(stristr($order,'<orderDeduction>')){
      preg_match('/<orderDeduction>([\w\W]*?)<\/orderDeduction>/',$order,$match);
      $deductionHTML=$match[1];
      preg_match('/<deductionItems>([\w\W]*?)<\/deductionItems>/',$order,$match);
      $deductionItem=$match[1];
      $deductionItems='';
      $sn=$db->prepare("SELECT * FROM `".$prefix."orderitems` WHERE `oid`=:oid AND `status`='neg' ORDER BY `ti` ASC");
      $sn->execute([':oid'=>$r['id']]);
      if($sn->rowCount()>0){
    	   while($rn=$sn->fetch(PDO::FETCH_ASSOC)){
	        $ditem=$deductionItem;
          $ditem=preg_replace([
            '/<print deduction=[\"\']?date[\"\']?>/',
            '/<print deduction=[\"\']?title[\"\']?>/',
            '/<print deduction=[\"\']?cost[\"\']?>/'
          ],[
            date($config['dateFormat'],$rn['ti']),
            $rn['title'],
            $rn['cost']
          ],$ditem);
          $deductionItems.=$ditem;
    		  $total=$total-$rn['cost'];
        }
  		  $total=number_format((float)$total,2,'.','');
        $deductionHTML=preg_replace([
          '~<deductionItems>.*?<\/deductionItems>~is',
          '/<print deduction=[\"\']?total[\"\']?>/'
        ],[
          $deductionItems,
          $total
        ],$deductionHTML);
        $order=preg_replace('~<orderDeduction>.*?<\/orderDeduction>~is',$deductionHTML,$order);
      }else$order=preg_replace('~<orderDeduction>.*?<\/orderDeduction>~is','',$order);
    }
    $so=$db->prepare("UPDATE `".$prefix."orders` SET `total`=:total WHERE id=:id");
    $so->execute([
      ':id'=>$r['id'],
      ':total'=>$total
    ]);
    $html=preg_replace('~<order>~is',$order,$html,1);
    $html=preg_replace('/<print paypal>/',(stristr($html,'<print paypal>')&&$r['status']!='paid'?'<div id="paypal-button-container"></div><script src="https://www.paypal.com/sdk/js?client-id='.$config['payPalClientID'].'&currency=AUD" data-sdk-integration-source="button-factory"></script><script>paypal.Buttons({style:{shape:"rect",color:"gold",layout:"horizontal",label:"pay",},createOrder:function(data,actions){return actions.order.create({purchase_units:[{amount:{value:"'.$total.'"}}]});},Approve:function(data,actions){return actions.order.capture().then(function(details){alert("Transaction completed by "+details.payer.name.given_name+"!");});}}).render("#paypal-button-container");</script>':''),$html);
/*          '<script src="https://www.paypal.com/sdk/js?client-id='.$config['payPalClientID'].'"></script>'.
        '<div id="paypal-button-container"></div>'.
        '<script>paypal.Buttons({'.
          'createOrder:function(data,actions){'.
            'return actions.order.create({'.
              'purchase_units:[{'.
                'amount:{'.
                  'currency_code:`AUD`,'.
                  'value:`'.$total.'`'.
                '}'.
              '}]'.
            '});'.
          '},'.
          'onApprove:function(data,actions){'.
            '$.ajax({'.
              'type:"POST",'.
      					'url:"core/paymenttransaction.php",'.
      					'data:{'.
      						'id:"'.$r['id'].'",'.
      						'act:"paid",'.
      					'}'.
      				'}).done(function(msg){'.
                '$("#paymenttransaction").html(msg).removeClass("d-none").addClass("alert alert-success");'.
      				'});'.
            '},'.
            'onCancel:function(){'.
              '$.ajax({'.
                'type:"POST",'.
                'url:"core/paymenttransaction.php",'.
                'data:{'.
                  'id:"'.$r['id'].'",'.
                  'act:"cancelled",'.
                '}'.
              '}).done(function(msg){'.
                '$("#paymenttransaction").html(msg).removeClass("d-none").addClass("alert alert-danger");'.
              '});'.
            '},'.
            'onError:function(){'.
              '$.ajax({'.
                'type:"POST",'.
                'url:"core/paymenttransaction.php",'.
                'data:{'.
                  'id:"'.$r['id'].'",'.
                  'act:"error",'.
                '}'.
              '}).done(function(msg){'.
                '$("#paymenttransaction").html(msg).removeClass("d-none").addClass("alert alert-danger");'.
              '});'.
            '},'.
          '}).render(`#paypal-button-container`);'.
        '</script>', */
  }else$html=preg_replace('~<order>~is','',$html,1);
}else$html=preg_replace('~<order>~is','',$html,1);
$content.=$html;
