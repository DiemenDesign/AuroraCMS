<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Preferences - Contact
 * @package    core/layout/pref_contact.php
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
      <div class="card mt-3 bg-transparent border-0 overflow-visible">
        <div class="card-actions text-right">
          <div class="row">
            <div class="col-12 col-sm-6">
              <ol class="breadcrumb m-0 pl-0 pt-0">
                <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/preferences';?>">Preferences</a></li>
                <li class="breadcrumb-item active">Contact</li>
              </ol>
            </div>
            <div class="col-12 col-sm-6 text-right">
              <div class="btn-group">
                <?=($user['options'][7]==1?'<button class="saveall" data-tooltip="left" aria-label="Save All Edited Fields (ctrl+s)"><i class="i">save-all</i></a>':'');?>
              </div>
            </div>
          </div>
        </div>
        <legend>Business Hours</legend>
        <div class="row my-2">
          <div class="col-12 col-md-4">
            <div class="form-row">
              <input id="prefBusinessHours" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="19" type="checkbox"<?=($config['options'][19]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
              <label for="prefBusinessHours">Business Hours</label>
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="form-row">
              <input id="prefShortDayNames" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="20" type="checkbox"<?=($config['options'][20]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');;?>>
              <label for="prefShortDayNames">Use Short Day Names</label>
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="form-row">
              <input id="pref24HourDigits" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="21" type="checkbox"<?=($config['options'][21]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');;?>>
              <label for="pref24HourDigits">Use 24 Hour Digits</label>
            </div>
          </div>
        </div>
        <div class="sticky-top shadow">
          <div class="row">
            <article class="card py-1 overflow-visible card-list card-list-header">
              <div class="row">
                <div class="col-12 col-md pl-2">From</div>
                <div class="col-12 col-md pl-2">To</div>
                <div class="col-12 col-md pl-2">Time From</div>
                <div class="col-12 col-md pl-2">Time To</div>
                <div class="col-12 col-md-3 pl-2">Additional Text</div>
                <div class="col-12 col-md-1 text-center">Active</div>
                <div class="col-12 col-md-1"></div>
              </div>
            </article>
          </div>
          <?php if($user['options'][7]==1){?>
            <form class="row" target="sp" method="post" action="core/add_hours.php">
              <input name="user" type="hidden" value="0">
              <input name="act" type="hidden" value="add_hours">
              <div class="col-12 col-md">
                <select id="from" name="from">
                  <option value="">No day</option>
                  <option value="monday">Monday</option>
                  <option value="tuesday">Tuesday</option>
                  <option value="wednesday">Wednesday</option>
                  <option value="thursday">Thursday</option>
                  <option value="friday">Friday</option>
                  <option value="saturday">Saturday</option>
                  <option value="sunday">Sunday</option>
                </select>
              </div>
              <div class="col-12 col-md">
                <select id="to" name="to">
                  <option value="">No day</option>
                  <option value="monday">Monday</option>
                  <option value="tuesday">Tuesday</option>
                  <option value="wednesday">Wednesday</option>
                  <option value="thursday">Thursday</option>
                  <option value="friday">Friday</option>
                  <option value="saturday">Saturday</option>
                  <option value="sunday">Sunday</option>
                </select>
              </div>
              <div class="col-12 col-md">
                <input id="hourstimefrom" name="hrfrom" type="time">
              </div>
              <div class="col-12 col-md">
                <input id="hourstimeto" name="hrto" type="time">
              </div>
              <div class="col-12 col-md-3">
                <input id="hoursinfo" name="info" list="hrsinfo">
                <datalist id="hrsinfo">
                  <option>Closed</option>
                  <option>By Appointment</option>
                  <option>Call for Assistance</option>
                  <option>Call for Help</option>
                  <option>Call for a Quote</option>
                  <option>Call to book</option>
                </datalist>
              </div>
              <div class="col-12 col-md-1">
                <div class="input-text border-0">
                  <input class="mx-auto" type="checkbox" name="active" checked value="1">
                </div>
              </div>
              <div class="col-12 col-md-1 text-right">
                <div class="btn-group" role="group">
                  <button class="trash" data-tooltip="tooltip" aria-label="Clear Values" onclick="$('#from,#to,#hourstimefrom,#hourstimeto,#hoursinfo').val('');return false;"><i class="i">eraser</i></button>
                  <button class="add" data-tooltip="tooltip" aria-label="Add"><i class="i">add</i></button>
                </div>
              </div>
            </form>
          <?php }?>
        </div>
        <div id="hours" class="row">
          <?php $ss=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE `contentType`='hours' ORDER BY `ord` ASC");
          $ss->execute();
          while($rs=$ss->fetch(PDO::FETCH_ASSOC)){
            if($rs['tis']!=0){
              $rs['tis']=str_pad($rs['tis'],4,'0',STR_PAD_LEFT);
              if($config['options'][21]==1)
                $hourFrom=$rs['tis'];
              else{
                $hourFromH=substr($rs['tis'],0,2);
                $hourFromM=substr($rs['tis'],3,4);
                $hourFrom=($hourFromH<12?ltrim($hourFromH,'0').($hourFromM>0?$hourFromM:'').'am':$hourFromH - 12 .($hourFromM>0?$hourFromM :'').'pm');
              }
            }else
              $hourFrom='&nbsp;';
            if($rs['tie']!=0){
    					$rs['tie']=str_pad($rs['tie'],4,'0',STR_PAD_LEFT);
    					if($config['options'][21]==1)
    						$hourTo=$rs['tie'];
    					else{
    						$hourToH=substr($rs['tie'],0,2);
    						$hourToM=substr($rs['tie'],3,4);
    						$hourTo=($hourToH<12?ltrim($hourToH,'0').($hourToM>0?$hourToM:'').'am':$hourToH - 12 .($hourToM>0?$hourToM:'').'pm');
    					}
    				}else
    					$hourTo='&nbsp;';?>
            <article id="l_<?=$rs['id'];?>" class="card col-12 zebra mb-0 p-0 overflow-visible card-list item shadow">
              <div class="row">
                <div class="col-12 col-md p-2"><?= ucfirst($rs['username']);?>&nbsp;</div>
                <div class="col-12 col-md p-2"><?= ucfirst($rs['password']);?>&nbsp;</div>
                <div class="col-12 col-md p-2"><?=$hourFrom;?></div>
                <div class="col-12 col-md p-2"><?=$hourTo;?></div>
                <div class="col-12 col-md-3 p-2"><?=$rs['title'];?>&nbsp;</div>
                <div class="col-12 col-md-1 p-2 text-center">
                  <input id="hoursactive<?=$rs['id'];?>" class="mx-auto" data-dbid="<?=$rs['id'];?>" data-dbt="choices" data-dbc="status" data-dbb="0" type="checkbox"<?=($rs['status']==1?' checked aria-checked="true"':' aria-checked="false"');?>>
                </div>
                <div class="col-12 col-md-1 text-right">
                  <div class="btn-group" role="group">
                    <?php if($user['options'][7]==1){?>
                      <div class="form-row">
                        <form target="sp" action="core/purge.php">
                          <input name="id" type="hidden" value="<?=$rs['id'];?>">
                          <input name="t" type="hidden" value="choices">
                          <button class="purge" type="submit" data-tooltip="tooltip" aria-label="Delete"><i class="i">trash</i></button>
                        </form>
                        <span class="btn handle"><i class="i">drag</i></span>
                      </div>
                    <?php }?>
                  </div>
                </div>
            </article>
          <?php }?>
          <article class="ghost hidden"></article>
        </div>
        <?php if($user['options'][7]==1){?>
          <script>
            $('#hours').sortable({
              items:"article.item",
              handle:'.handle',
              placeholder:".ghost",
              helper:fixWidthHelper,
              axis:"y",
              update:function(e,ui){
                var order=$("#hours").sortable("serialize");
                $.ajax({
                  type:"POST",
                  dataType:"json",
                  url:"core/reorderhours.php",
                  data:order
                });
              }
            }).disableSelection();
            function fixWidthHelper(e,ui){
              ui.children().each(function(){
                $(this).width($(this).width());
              });
              return ui;
            }
          </script>
        <?php }?>
        <legend class="mt-3">Business Contact Details</legend>
        <div class="row mt-2">
          <div class="col-12 col-md-4">
            <div class="form-row">
              <input id="prefDisplayAddress" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="22" type="checkbox"<?=($config['options'][22]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
              <label for="prefDisplayAddress">Display Address</label>
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="form-row">
              <input id="prefDisplayEmail" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="23" type="checkbox"<?=($config['options'][23]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
              <label for="prefDisplayEmail">Display Email</label>
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="form-row">
              <input id="prefDisplayPhone" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="24" type="checkbox"<?=($config['options'][24]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
              <label for="prefDisplayPhone">Display Phone Numbers</label>
            </div>
          </div>
        </div>
        <div class="alert alert-danger mt-3<?=$config['business']!=''?' hidden':'';?>" id="businessErrorBlock" role="alert">The Business Name has not been set. Some functions such as Messages,Newsletters and Bookings will NOT function currectly.</div>
        <div class="alert alert-danger<?=$config['email']!=''?' hidden':'';?>" id="emailErrorBlock" role="alert">The Email has not been set. Some functions such as Messages, Newsletters and Bookings will NOT function correctly.</div>
        <div class="row">
          <div class="col-12 col-md-4 pr-md-3" id="businessHasError">
            <label for="business">Business Name</label>
            <div class="form-row">
              <input class="textinput" id="business" data-dbid="1" data-dbt="config" data-dbc="business" type="text" value="<?=$config['business'];?>"<?=($user['options'][7]==1?' placeholder="Enter a Business Name..."':' disabled');?>>
              <?=($user['options'][7]==1?'<button class="save" id="savebusiness" data-dbid="business" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
            </div>
          </div>
          <div class="col-12 col-md-4 pr-md-3">
            <label for="abn">ABN</label>
            <div class="form-row">
              <input class="textinput" id="abn" data-dbid="1" data-dbt="config" data-dbc="abn" type="text" value="<?=$config['abn'];?>"<?=($user['options'][7]==1?' placeholder="Enter an ABN..."':' disabled');?>>
              <?=($user['options'][7]==1?'<button class="save" id="saveabn" data-dbid="abn" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
            </div>
          </div>
          <div class="col-12 col-md-4" id="emailHasError">
            <label for="email">Email</label>
            <div class="form-row">
              <input class="textinput" id="email" data-dbid="1" data-dbt="config" data-dbc="email" type="text" value="<?=$config['email'];?>"<?=($user['options'][7]==1?' placeholder="Enter an Email..."':' disabled');?>>
              <?=($user['options'][7]==1?'<button class="save" id="saveemail" data-dbid="email" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12 col-md-6 pr-md-3">
            <label for="phone">Phone</label>
            <div class="form-row">
              <input class="textinput" id="phone" data-dbid="1" data-dbt="config" data-dbc="phone" type="text" value="<?=$config['phone'];?>"<?=($user['options'][7]==1?' placeholder="Enter a Phone..."':' disabled');?>>
              <?=($user['options'][7]==1?'<button class="save" id="savephone" data-dbid="phone" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
            </div>
          </div>
          <div class="col-12 col-md-6">
            <label for="mobile">Mobile</label>
            <div class="form-row">
              <input class="textinput" id="mobile" data-dbid="1" data-dbt="config" data-dbc="mobile" type="text" value="<?=$config['mobile'];?>"<?=($user['options'][7]==1?' placeholder="Enter a Mobile..."':' disabled');?>>
              <?=($user['options'][7]==1?'<button class="save" id="savemobile" data-dbid="mobile" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
            </div>
          </div>
        </div>
        <label for="address">Address</label>
        <div class="form-row">
          <input class="textinput" id="address" data-dbid="1" data-dbt="config" data-dbc="address" type="text" value="<?=$config['address'];?>"<?=($user['options'][7]==1?' placeholder="Enter an Address..."':' disabled');?>>
          <?=($user['options'][7]==1?'<button class="save" id="saveaddress" data-dbid="address" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
        </div>
        <div class="row">
          <div class="col-12 col-md-3 pr-md-3">
            <label for="suburb">Suburb</label>
            <div class="form-row">
              <input class="textinput" id="suburb" data-dbid="1" data-dbt="config" data-dbc="suburb" type="text" value="<?=$config['suburb'];?>"<?=($user['options'][7]==1?' placeholder="Enter a Suburb..."':' disabled');?>>
              <?=($user['options'][7]==1?'<button class="save" id="savesuburb" data-dbid="suburb" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
            </div>
          </div>
          <div class="col-12 col-md-3 pr-md-3">
            <label for="city">City</label>
            <div class="form-row">
              <input class="textinput" id="city" data-dbid="1" data-dbt="config" data-dbc="city" type="text" value="<?=$config['city'];?>"<?=($user['options'][7]==1?' placeholder="Enter a City..."':' disabled');?>>
              <?=($user['options'][7]==1?'<button class="save" id="savecity" data-dbid="city" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
            </div>
          </div>
          <div class="col-12 col-md-3 pr-md-3">
            <label for="state">State</label>
            <div class="form-row">
              <input class="textinput" id="state" data-dbid="1" data-dbt="config" data-dbc="state" type="text" value="<?=$config['state'];?>"<?=($user['options'][7]==1?' placeholder="Enter a State..."':' disabled');?>>
              <?=($user['options'][7]==1?'<button class="save" id="savestate" data-dbid="state" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
            </div>
          </div>
          <div class="col-12 col-md-3">
            <label for="postcode">Postcode</label>
            <div class="form-row">
              <input class="textinput" id="postcode" data-dbid="1" data-dbt="config" data-dbc="postcode" type="text" value="<?=$config['postcode']!=0?$config['postcode']:'';?>"<?=($user['options'][7]==1?' placeholder="Enter a Postcode..."':' disabled');?>>
              <?=($user['options'][7]==1?'<button class="save" id="savepostcode" data-dbid="postcode" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
            </div>
          </div>
        </div>
        <label for="country">Country</label>
        <div class="form-row">
          <input class="textinput" id="country" data-dbid="1" data-dbt="config" data-dbc="country" type="text" value="<?=$config['country'];?>"<?=($user['options'][7]==1?' placeholder="Enter a Country..."':' disabled');?>>
          <?=($user['options'][7]==1?'<button class="save" id="savecountry" data-dbid="country" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
        </div>
        <label for="geo_weatherAPI">Open Weather API Key</label>
        <?=($user['options'][7]==1?'<div class="form-text">Visit <a target="_blank" href="https://openweatermap.org/">Open Weather Map</a> for an API Key.</div>':'');?>
        <div class="form-row">
          <input class="textinput" id="geo_weatherAPI" data-dbid="1" data-dbt="config" data-dbc="geo_weatherAPI" type="text" value="<?=$config['geo_weatherAPI'];?>"<?=($user['options'][7]==1?' placeholder="Enter an API Key from Open Weather..."':' disabled');?>>
          <?=($user['options'][7]==1?'<button class="save" id="savegeo_weatherAPI" data-dbid="geo_weatherAPI" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
        </div>
        <label for="mapapikey">Map Box API Key</label>
        <div class="form-row">
          <input class="textinput" id="mapapikey" data-dbid="1" data-dbt="config" data-dbc="mapapikey" type="text" value="<?=$config['mapapikey'];?>"<?=($user['options'][7]==1?' placeholder="Enter an API Key from Map Box..."':' disabled');?>>
          <?=($user['options'][7]==1?'<button class="save" id="savemapapikey" data-dbid="mapapikey" data-tooltip="tooltip" aria-label="Save"><i class="i">save</i></button>':'');?>
        </div>
        <div class="col-12 mt-3 mb-2">
          <div class="form-row">
            <input id="prefMapDisplay" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="27" type="checkbox"<?=($config['options'][27]==1?' checked aria-checked="true"':' aria-checked="false"').($user['options'][7]==1?'':' disabled');?>>
            <label for="prefMapDisplay">Enable Map Display</label>
          </div>
        </div>
        <?php if($config['mapapikey']==''){
          if($user['options'][7]==1){?>
            <div class="alert alert-info">
              There is currently no Map API Key entered above, to allow Maps to be displayed on pages.<br>
              Maps are displayed with the help of the Leaflet addon for it's ease of use.<br>
              To obtain an API Key to access Mapping, please register at <a href="https://account.mapbox.com/access-tokens/">Map Box</a>.
            </div>
          <?php }
        }else{
          echo($user['options'][7]==1?'<div class="form-text">Drag the map marker to update your Location.</div>':'');?>
          <div class="col-12">
            <div class="row" style="height:600px;" id="map"></div>
          </div>
          <script>
            <?php if($config['geo_position']==''){?>
              navigator.geolocation.getCurrentPosition(
                function(position){
                  var map=L.map('map').setView([position.coords.latitude,position.coords.longitude],13);
                  L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=<?=$config['mapapikey'];?>',{
                    attribution:'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                    maxZoom:18,
                    id:'mapbox/streets-v11',
                    tileSize:512,
                    zoomOffset:-1,
                    accessToken:'<?=$config['mapapikey'];?>'
                  }).addTo(map);
                  var myIcon=L.icon({
                    iconUrl:'<?= URL;?>core/js/leaflet/images/marker-icon.png',
                    iconSize:[38,95],
                    iconAnchor:[22,94],
                    popupAnchor:[-3,-76],
                    shadowUrl:'<?= URL;?>core/js/leaflet/images/marker-shadow.png',
                    shadowSize:[68,95],
                    shadowAnchor:[22,94]
                  });
                  var marker=L.marker([position.coords.latitude,position.coords.longitude],{draggable:<?=($user['options'][7]==1?'true':'false');?>,}).addTo(map);
                  window.top.window.toastr["info"]("Best location guess has been made from your browser location API!");
                  window.top.window.toastr["info"]("Reposition the marker to update your address coordinates!");
                  var popupHtml=`<strong><?=($config['business']!=''?$config['business']:'<mark>Fill in Business Field above</mark>');?></strong><small><?=($config['address']!=''?'<br>'.$config['address'].',<br>'.$config['suburb'].', '.$config['city'].', '.$config['state'].', '.$config['postcode'].',<br>'.$config['country']:'');?></small>`;
                  marker.bindPopup(popupHtml).openPopup();
                  marker.on('dragend',function(event){
                    var marker=event.target;
                    var position=marker.getLatLng();
                    update('1','config','geo_position',position.lat+','+position.lng);
                    window.top.window.toastr["success"]("Map Marker position updated!");
                    marker.setLatLng(new L.LatLng(position.lat,position.lng),{draggable:'true'});
                    map.panTo(new L.LatLng(position.lat,position.lng))
                  });
                },
                function(){
                  var map=L.map('map').setView([-24.287,136.406],4);
                  L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=<?=$config['mapapikey'];?>',{
                    attribution:'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                    maxZoom:18,
                    id:'mapbox/streets-v11',
                    tileSize:512,
                    zoomOffset:-1,
                    accessToken:'<?=$config['mapapikey'];?>'
                  }).addTo(map);
                  var myIcon=L.icon({
                    iconUrl:'<?= URL;?>core/js/leaflet/images/marker-icon.png',
                    iconSize:[38,95],
                    iconAnchor:[22,94],
                    popupAnchor:[-3,-76],
                    shadowUrl:'<?= URL;?>core/js/leaflet/images/marker-shadow.png',
                    shadowSize:[68,95],
                    shadowAnchor:[22,94]
                  });
                  var marker=L.marker([-24.287,136.406],{draggable:<?=($user['options'][7]==1?'true':'false');?>,}).addTo(map);
                  window.top.window.toastr["info"]("Unable to get your location via browser, location has been set so you can choose!");
                  window.top.window.toastr["info"]("Reposition the marker to update your address coordinates!");
                  var popupHtml=`<strong><?=($config['business']!=''?$config['business']:'<mark>Fill in Business Field above</mark>');?></strong><small><?=($config['address']!=''?'<br>'.$config['address'].',<br>'.$config['suburb'].', '.$config['city'].', '.$config['state'].', '.$config['postcode'].',<br>'.$config['country']:'');?></small>`;
                  marker.bindPopup(popupHtml).openPopup();
                  marker.on('dragend',function(event){
                    var marker=event.target;
                    var position=marker.getLatLng();
                    update('1','config','geo_position',position.lat+','+position.lng);
                    window.top.window.toastr["success"]("Map Marker position updated!");
                    marker.setLatLng(new L.LatLng(position.lat,position.lng),{draggable:'true'});
                    map.panTo(new L.LatLng(position.lat,position.lng))
                  });
                }
              );
            <?php }else{?>
              var map=L.map('map').setView([<?=$config['geo_position'];?>],13);
              L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=<?=$config['mapapikey'];?>',{
                attribution:'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                maxZoom:18,
                id:'mapbox/streets-v11',
                tileSize:512,
                zoomOffset:-1,
                accessToken:'<?=$config['mapapikey'];?>'
              }).addTo(map);
              var myIcon=L.icon({
                iconUrl:'<?= URL;?>core/js/leaflet/images/marker-icon.png',
                iconSize:[38,95],
                iconAnchor:[22,94],
                popupAnchor:[-3,-76],
                shadowUrl:'<?= URL;?>core/js/leaflet/images/marker-shadow.png',
                shadowSize:[68,95],
                shadowAnchor:[22,94]
              });
              var marker=L.marker([<?=$config['geo_position'];?>],{draggable:<?=($user['options'][7]==1?'true':'false');?>,}).addTo(map);
              var popupHtml=`<strong><?=($config['business']!=''?$config['business']:'<mark>Fill in Business Field above</mark>');?></strong><small><?=($config['address']!=''?'<br>'.$config['address'].',<br>'.$config['suburb'].', '.$config['city'].', '.$config['state'].', '.$config['postcode'].',<br>'.$config['country']:'');?></small>`;
              marker.bindPopup(popupHtml).openPopup();
              marker.on('dragend',function(event){
                var marker=event.target;
                var position=marker.getLatLng();
                update('1','config','geo_position',position.lat+','+position.lng);
                window.top.window.toastr["success"]("Map Marker position updated!");
                marker.setLatLng(new L.LatLng(position.lat,position.lng),{draggable:'true'});
                map.panTo(new L.LatLng(position.lat,position.lng))
              });
            <?php }?>
          </script>
        <?php }?>
      </div>
      <?php require'core/layout/footer.php';?>
    </div>
  </section>
</main>
