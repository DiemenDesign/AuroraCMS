<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Preferences - Interface
 * @package    core/layout/pref_interface.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.9
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v0.0.3 Add Toggle to Enable Administration Activity Tracking.
 * @changes    v0.0.3 Change position of Toggles and Descriptions for better formatting.
 * @changes    v0.0.4 Fix Tooltips.
 * @changes    v0.0.6 Add GDPR Option.
 * @changes    v0.0.7 Fix Width Formatting for better responsiveness.
 * @changes    v0.0.7 Add Option to Lock Down Site for Developer Accounts.
 * @changes    v0.0.8 Add Options for Offline PWA.
 * @changes    v0.0.9 Fix incorrect ID for input's.
 */?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/preferences';?>">Preferences</a></li>
    <li class="breadcrumb-item active">Interface</li>
  </ol>
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
<?php if($user['rank']>999){?>
        <div class="form-group row">
          <div class="input-group col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">
            <label class="switch switch-label switch-success"><input type="checkbox" id="options17" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="17"<?php echo$config['options']{17}==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
          </div>
          <label for="options17" class="col-form-label col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">Developer Lock Down</label>
        </div>
<?php }?>
        <div class="form-group row">
          <div class="input-group col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">
            <label class="switch switch-label switch-success"><input type="checkbox" id="options8" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="8"<?php echo$config['options']{8}==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
          </div>
          <label for="options8" class="col-form-label col-2 col-sm-3 col-md-4 col-lg-3 col-xl-5">Display GDPR Banner.</label>
          <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-5 text-right small text-muted">Check <a target="_blank" href="https://www.oaic.gov.au/privacy/guidance-and-advice/australian-entities-and-the-eu-general-data-protection-regulation/">here</a> to determine if you need to display a GDPR Banner.</div>
        </div>
        <div class="form-group row">
          <div class="input-group col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">
            <label class="switch switch-label switch-success"><input type="checkbox" id="options18" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="18"<?php echo$config['options']{18}==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
          </div>
          <label for="options18" class="col-form-label col-2 col-sm-3 col-md-4 col-lg-3 col-xl-5">Enable Offline Page (PWA).</label>
        </div>
<?php if($user['rank']>999){?>
        <div class="form-group row">
          <div class="input-group col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">
            <label class="switch switch-label switch-success"><input type="checkbox" id="development0" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="development" data-dbb="0"<?php echo$config['development']{0}==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
          </div>
          <label for="development0" class="col-form-label col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">Development Mode</label>
        </div>
<?php if(file_exists('media'.DS.'cache'.DS.'error.log')){?>
        <div id="l_0">
          <div class="form-group row">
            <label for="error_log" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Error Log</label>
            <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
              <div class="input-group-btn">
                <button class="btn btn-secondary" onclick="$('#logview').toggleClass('d-none');$('#logfile').load('media/cache/error.log?<?php echo time();?>');">View Logs</button>
                <button class="btn btn-secondary trash" onclick="purge('0','errorlog')" aria-label="Purge"><?php svg('purge');?></button>
              </div>
            </div>
          </div>
          <div id="logview" class="form-group d-none">
            <div class=" col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2"></div>
            <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
              <div class="well col-12"><small id="logfile" style="white-space:pre"></small></div>
            </div>
          </div>
        </div>
<?php }
}?>
<?php if($user['rank']==1000||$config['options']{17}==0){?>
        <div class="form-group row">
          <div class="input-group col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">
            <label class="switch switch-label switch-success"><input type="checkbox" id="comingsoon0" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="comingsoon" data-dbb="0"<?php echo$config['comingsoon']{0}==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
          </div>
          <label for="comingsoon0" class="col-form-label col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">Coming Soon Mode</label>
        </div>
        <div class="form-group row">
          <div class="input-group col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">
            <label class="switch switch-label switch-success"><input type="checkbox" id="maintenance0" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="maintenance" data-dbb="0"<?php echo$config['maintenance']{0}==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
          </div>
          <label for="maintenance0" class="col-form-label col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">Maintenance Mode</label>
        </div>
        <div class="form-group row">
          <div class="input-group col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">
            <label class="switch switch-label switch-success"><input type="checkbox" id="options12" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="12"<?php echo$config['options']{12}==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
          </div>
          <label for="options4" class="col-form-label col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">Admin Activity Tracking</label>
        </div>
        <div class="form-group row">
          <div class="input-group col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">
            <label class="switch switch-label switch-success"><input type="checkbox" id="options4" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="4"<?php echo$config['options']{4}==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
          </div>
          <label for="options4" class="col-form-label col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">Enable Tooltips</label>
        </div>
        <div class="form-group row">
          <label for="uti_freq" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Update Frequency</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <select id="uti_freq" class="form-control" onchange="update('1','config','uti_freq',$(this).val());">
              <option value="0"<?php echo$config['uti_freq']==0?' selected':'';?>>Never</option>
              <option value="3600"<?php echo$config['uti_freq']==3600?' selected':'';?>>Hourly</option>
              <option value="84600"<?php echo$config['uti_freq']==84600?' selected':'';?>>Daily</option>
              <option value="604800"<?php echo$config['uti_freq']==604800?' selected':'';?>>Weekly</option>
              <option value="2629743"<?php echo$config['uti_freq']==2629743?' selected':'';?>>Monthly</option>
            </select>
            <div class="input-group-append">
              <button class="btn btn-secondary" onclick="$('#updatecheck').removeClass('hidden').load('core/layout/updatecheck.php');">Check Now</button>
            </div>
          </div>
        </div>
        <div id="updatecheck" class="form-group row d-none">
          <div class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2"></div>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <div class="col alert alert-warning" role="alert"><?php svg('spinner','animated spin').' Checking for new updates!';?></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="update_url" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2" data-tooltip="tooltip" data-title="URL where new updates are checked and downloaded from.">Update URL</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <input type="text" id="update_url" class="form-control textinput" value="<?php echo$config['update_url'];?>" data-dbid="1" data-dbt="config" data-dbc="update_url" placeholder="Enter an Update URL...">
            <div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="saveupdate_url" class="btn btn-secondary save" data-dbid="update_url" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
          </div>
        </div>
        <div class="help-block small text-muted text-right">'0' Disables Idle Timeout.</div>
        <div class="form-group row">
          <label for="idleTime" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Idle Timeout</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <input type="text" id="idleTime" class="form-control textinput" value="<?php echo$config['idleTime'];?>" data-dbid="1" data-dbt="config" data-dbc="idleTime" placeholder="Enter a Time in Minutes...">
            <div class="input-group-text">Minutes</div>
            <div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="saveidleTime" class="btn btn-secondary save" data-dbid="idleTime" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
          </div>
        </div>
        <div class="help-block small text-muted text-right">For information on Date Format Characters click <a target="_blank" href="http://php.net/manual/en/function.date.php#refsect1-function.date-parameters">here</a>.</div>
        <div class="form-group row">
          <label for="dateFormat" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Date/Time Format</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <input type="text" id="dateFormat" class="form-control textinput" value="<?php echo$config['dateFormat'];?>" data-dbid="1" data-dbt="config" data-dbc="dateFormat" placeholder="Enter a Date/Time Format...">
            <div class="input-group-text"><?php echo date($config['dateFormat'],time());?></div>
            <div class="input-group-append" data-tooltip="tooltip" data-title="Save"><button id="savedateFormat" class="btn btn-secondary save" data-dbid="dateFormat" data-style="zoom-in" aria-label="Save"><?php svg('save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="timezone" class="col-form-label col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">Timezone</label>
          <div class="input-group col-8 col-sm-9 col-md-10 col-lg-9 col-xl-10">
            <select id="timezone" class="form-control" onchange="update('1','config','timezone',$(this).val());" data-dbid="1" data-dbt="config" data-dbc="timezone">
<?php      function get_timezones(){
              $o=array();
              $t_zones=timezone_identifiers_list();
              foreach($t_zones as$a){
              $t='';
              try{
                $zone=new DateTimeZone($a);
                $seconds=$zone->getOffset(new DateTime("now",$zone));
                $hours=sprintf("%+02d",intval($seconds/3600));
                $minutes=sprintf("%02d",($seconds%3600)/60);
                $t=$a." [ $hours:$minutes ]" ;
                $o[$a]=$t;
              }
              catch(Exception $e){}
              }
              ksort($o);
              return$o;
              }
              $o=get_timezones();
              foreach($o as$tz=>$label)echo'<option value="'.$tz.'"'.($tz==$config['timezone']?' selected="selected"':'').'>'.$tz.'</option>';?>
            </select>
          </div>
        </div>
<?php }?>
      </div>
    </div>
  </div>
</main>
