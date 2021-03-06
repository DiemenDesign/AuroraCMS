<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Settings - Accounts
 * @package    core/layout/set_accounts.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.1.5
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<main>
  <section id="content">
    <div class="content-title-wrapper mb-0">
      <div class="content-title">
        <div class="content-title-heading">
          <div class="content-title-icon"><?= svg2('users','i-3x');?></div>
          <div>Accounts Settings</div>
          <div class="content-title-actions">
            <?php if(isset($_SERVER['HTTP_REFERER'])){?>
              <a class="btn" data-tooltip="tooltip" href="<?=$_SERVER['HTTP_REFERER'];?>" role="button" aria-label="Back"><?= svg2('back');?></a>
            <?php }?>
            <button class="saveall" data-tooltip="tooltip" aria-label="Save All Edited Fields"><?= svg2('save');?></button>
          </div>
        </div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= URL.$settings['system']['admin'].'/accounts';?>">Accounts</a></li>
          <li class="breadcrumb-item active">Settings</li>
        </ol>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="card border-radius-0 shadow px-4 py-3 overflow-visible">
        <div class="row">
          <?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/accounts/settings#createAccounts" aria-label="PermaLink to Allow Account Signups Checkbox">&#128279;</a>':'';?>
          <input id="configoptions3" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="3" type="checkbox"<?=$config['options'][3]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
          <label id="configoptions31" for="configoptions3" data-tooltip="tooltip" aria-label="Allow Users to Create Accounts.">Allow Account Sign Ups</label>
        </div>
        <div class="row">
          <?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/accounts/settings#productLoggedIn" aria-label="PermaLink to Must be Logged In to Purchase Products Checkbox">&#128279;</a>':'';?>
          <input id="configoptions30" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="30" type="checkbox"<?=$config['options'][30]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
          <label id="configoptions301" for="configoptions30" data-tooltip="tooltip" aria-label="Allow Users to Create Accounts.">Must be Logged In to Purchase Products</label>
        </div>
        <div class="row">
          <?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/accounts/settings#productEnablePoints" aria-label="PermaLink to Display Points Value Checkbox">&#128279;</a>':'';?>
          <input id="configoptions0" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="0" type="checkbox"<?=$config['options'][0]==1?' checked aria-checked="true"':' aria-checked="false"';?>>
          <label id="configoptions01" for="configoptions0" data-tooltip="tooltip" aria-label="Enable Points Value Display.">Display Points Value</label>
        </div>
        <legend id="purchaseLimitsSection" class="mt-3"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/accounts/settings#purchaseLimitsSection" aria-label="PermaLink to Purchase Limits Section">&#128279;</a>':'';?>Purchase Item Limits</legend>
        <div class="row">
          <div class="col-2 mr-4">
            <label id="accountsMemberLimit" for="memberLimit"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/accounts/settings#accountsMemberLimit" aria-label="PermaLink to Member Purchase Limit Field">&#128279;</a>':'';?><small>Member Limit</small></label>
            <div class="form-row">
              <input class="textinput" id="memberLimit" data-dbid="1" data-dbt="config" data-dbc="memberLimit" type="number" value="<?=$config['memberLimit'];?>">
              <button class="save" id="savememberLimit" data-tooltip="tooltip" data-dbid="memberLimit" data-style="zoom-in" aria-label="Save"><?= svg2('save');?></button>
            </div>
          </div>
          <div class="col-2 mr-4">
            <label id="accountsMemberLimitSilver" for="memberLimitSilver"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/accounts/settings#accountsMemberLimitSilver" aria-label="PermaLink to Member Purchase Limit Silver Field">&#128279;</a>':'';?><small>Member Silver Limit</small></label>
            <div class="form-row">
              <input class="textinput" id="memberLimitSilver" data-dbid="1" data-dbt="config" data-dbc="memberLimitSilver" type="number" value="<?=$config['memberLimitSilver'];?>">
              <button class="save" id="savememberLimitSilver" data-tooltip="tooltip" data-dbid="memberLimitSilver" data-style="zoom-in" aria-label="Save"><?= svg2('save');?></button>
            </div>
          </div>
          <div class="col-2 mr-4">
            <label id="accountsMemberLimitBronze" for="memberLimitBronze"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/accounts/settings#accountsMemberLimitBronze" aria-label="PermaLink to Member Purchase Limit Bronze Field">&#128279;</a>':'';?><small>Member Bronze Limit</small></label>
            <div class="form-row">
              <input class="textinput" id="memberLimitBronze" data-dbid="1" data-dbt="config" data-dbc="memberLimitBronze" type="number" value="<?=$config['memberLimitBronze'];?>">
              <button class="save" id="savememberLimitBronze" data-tooltip="tooltip" data-dbid="memberLimitBronze" data-style="zoom-in" aria-label="Save"><?= svg2('save');?></button>
            </div>
          </div>
          <div class="col-2 mr-4">
            <label id="accountsMemberLimitGold" for="memberLimitGold"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/accounts/settings#accountsMemberLimitGold" aria-label="PermaLink to Member Purchase Limit Gold Field">&#128279;</a>':'';?><small>Member Gold Limit</small></label>
            <div class="form-row">
              <input class="textinput" id="memberLimitGold" data-dbid="1" data-dbt="config" data-dbc="memberLimitGold" type="number" value="<?=$config['memberLimitGold'];?>">
              <button class="save" id="savememberLimitGold" data-tooltip="tooltip" data-dbid="memberLimitGold" data-style="zoom-in" aria-label="Save"><?= svg2('save');?></button>
            </div>
          </div>
          <div class="col-2">
            <label id="accountsMemberLimitPlatinum" for="memberLimitPlatinum"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/accounts/settings#accountsMemberLimitPlatinum" aria-label="PermaLink to Member Purchase Limit Platinum Field">&#128279;</a>':'';?><small>Member Platinum Limit</small></label>
            <div class="form-row">
              <input class="textinput" id="memberLimitPlatinum" data-dbid="1" data-dbt="config" data-dbc="memberLimitPlatinum" type="number" value="<?=$config['memberLimitPlatinum'];?>">
              <button class="save" id="savememberLimitPlatinum" data-tooltip="tooltip" data-dbid="memberLimitPlatinum" data-style="zoom-in" aria-label="Save"><?= svg2('save');?></button>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-2 mr-4">
            <label id="accountsWholesaleLimitSilver" for="wholesaleLimitSilver"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/accounts/settings#accountsWholesaleLimitSilver" aria-label="PermaLink to Wholesale Purchase Limit Silver Field">&#128279;</a>':'';?><small>Wholesale Silver Limit</small></label>
            <div class="form-row">
              <input class="textinput" id="wholesaleLimitSilver" data-dbid="1" data-dbt="config" data-dbc="wholesaleLimitSilver" type="number" value="<?=$config['wholesaleLimitSilver'];?>">
              <button class="save" id="savewholesaleLimitSilver" data-tooltip="tooltip" data-dbid="wholesaleLimitSilver" data-style="zoom-in" aria-label="Save"><?= svg2('save');?></button>
            </div>
          </div>
          <div class="col-2 mr-4">
            <label id="accountsWholesaleLimitBronze" for="wholesaleLimitBronze"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/accounts/settings#accountsWholesaleLimitBronze" aria-label="PermaLink to Wholesale Purchase Limit Bronze Field">&#128279;</a>':'';?><small>Wholesale Bronze Limit</small></label>
            <div class="form-row">
              <input class="textinput" id="wholesaleLimitBronze" data-dbid="1" data-dbt="config" data-dbc="wholesaleLimitBronze" type="number" value="<?=$config['wholesaleLimitBronze'];?>">
              <button class="save" id="savewholesaleLimitBronze" data-tooltip="tooltip" data-dbid="wholesaleLimitBronze" data-style="zoom-in" aria-label="Save"><?= svg2('save');?></button>
            </div>
          </div>
          <div class="col-2 mr-4">
            <label id="accountsWholesaleLimitGold" for="wholesaleLimitGold"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/accounts/settings#accountsWholesaleLimitGold" aria-label="PermaLink to Wholesale Purchase Limit Gold Field">&#128279;</a>':'';?><small>Wholesale Gold Limit</small></label>
            <div class="form-row">
              <input class="textinput" id="wholesaleLimitGold" data-dbid="1" data-dbt="config" data-dbc="wholesaleLimitGold" type="number" value="<?=$config['wholesaleLimitGold'];?>">
              <button class="save" id="savewholesaleLimitGold" data-tooltip="tooltip" data-dbid="wholesaleLimitGold" data-style="zoom-in" aria-label="Save"><?= svg2('save');?></button>
            </div>
          </div>
          <div class="col-2">
            <label id="accountsWholesaleLimitPlatinum" for="wholesaleLimitPlatinum"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/accounts/settings#accountsWholesaleLimitPlatinum" aria-label="PermaLink to Wholesale Purchase Limit Platinum Field">&#128279;</a>':'';?><small>Wholesale Platinum Limit</small></label>
            <div class="form-row">
              <input class="textinput" id="wholesaleLimitPlatinum" data-dbid="1" data-dbt="config" data-dbc="wholesaleLimitPlatinum" type="number" value="<?=$config['wholesaleLimitPlatinum'];?>">
              <button class="save" id="savewholesaleLimitPlatinum" data-tooltip="tooltip" data-dbid="wholesaleLimitPlatinum" data-style="zoom-in" aria-label="Save"><?= svg2('save');?></button>
            </div>
          </div>
        </div>

        <legend id="wholesaleTimes" class="mt-3"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/accounts/settings#wholesaleTimes" aria-label="PermaLink to Wholesale Time Limits Section">&#128279;</a>':'';?>Wholesale Purchase Time Limits</legend>
        <div class="row">
          <div class="col-2 mr-4">
            <label for="wholesaleTimeSilver"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/accounts/settings#accountsWholesaleLimitSilver" aria-label="PermaLink to Wholesale Time Limit Silver Field">&#128279;</a>':'';?><small>Wholesale Silver Limit</small></label>
            <select id="wholesaleTimeSilver" data-dbid="1" data-dbt="login" data-dbc="wholesaleTimeSilver"<?=$user['options'][5]==1?'':' disabled';?> onchange="update('1','config','wholesaleTimeSilver',$(this).val(),'select');">
              <option value="0"<?=$config['wholesaleTimeSilver']==0?' selected':'';?>>Use System Default</option>
              <option value="2629743"<?=$config['wholesaleTimeSilver']==2629743?' selected':'';?>>1 Month</option>
              <option value="5259486"<?=$config['wholesaleTimeSilver']==5259486?' selected':'';?>>2 Months</option>
              <option value="7889229"<?=$config['wholesaleTimeSilver']==7889229?' selected':'';?>>3 Months</option>
              <option value="15778458"<?=$config['wholesaleTimeSilver']==15778458?' selected':'';?>>6 Months</option>
              <option value="31556926"<?=$config['wholesaleTimeSilver']==31556926?' selected':'';?>>1 Year</option>
              <option value="63113852"<?=$config['wholesaleTimeSilver']==63113852?' selected':'';?>>2 Years</option>
              <option value="94670778"<?=$config['wholesaleTimeSilver']==94670778?' selected':'';?>>3 Years</option>
            </select>
          </div>
          <div class="col-2 mr-4">
            <label for="wholesaleTimeBronze"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/accounts/settings#accountsWholesaleLimitBronze" aria-label="PermaLink to Wholesale Time Limit Bronze Field">&#128279;</a>':'';?><small>Wholesale Bronze Limit</small></label>
            <select id="wholesaleTimeBronze" data-dbid="1" data-dbt="login" data-dbc="wholesaleTimeBronze"<?=$user['options'][5]==1?'':' disabled';?> onchange="update('1','config','wholesaleTimeBronze',$(this).val(),'select');">
              <option value="0"<?=$config['wholesaleTimeBronze']==0?' selected':'';?>>Use System Default</option>
              <option value="2629743"<?=$config['wholesaleTimeBronze']==2629743?' selected':'';?>>1 Month</option>
              <option value="5259486"<?=$config['wholesaleTimeBronze']==5259486?' selected':'';?>>2 Months</option>
              <option value="7889229"<?=$config['wholesaleTimeBronze']==7889229?' selected':'';?>>3 Months</option>
              <option value="15778458"<?=$config['wholesaleTimeBronze']==15778458?' selected':'';?>>6 Months</option>
              <option value="31556926"<?=$config['wholesaleTimeBronze']==31556926?' selected':'';?>>1 Year</option>
              <option value="63113852"<?=$config['wholesaleTimeBronze']==63113852?' selected':'';?>>2 Years</option>
              <option value="94670778"<?=$config['wholesaleTimeBronze']==94670778?' selected':'';?>>3 Years</option>
            </select>
          </div>
          <div class="col-2 mr-4">
            <label for="wholesaleTimeGold"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/accounts/settings#accountsWholesaleLimitGold" aria-label="PermaLink to Wholesale Time Limit Gold Field">&#128279;</a>':'';?><small>Wholesale Gold Limit</small></label>
            <select id="wholesaleTimeGold" data-dbid="1" data-dbt="login" data-dbc="wholesaleTimeGold"<?=$user['options'][5]==1?'':' disabled';?> onchange="update('1','config','wholesaleTimeGold',$(this).val(),'select');">
              <option value="0"<?=$config['wholesaleTimeGold']==0?' selected':'';?>>Use System Default</option>
              <option value="2629743"<?=$config['wholesaleTimeGold']==2629743?' selected':'';?>>1 Month</option>
              <option value="5259486"<?=$config['wholesaleTimeGold']==5259486?' selected':'';?>>2 Months</option>
              <option value="7889229"<?=$config['wholesaleTimeGold']==7889229?' selected':'';?>>3 Months</option>
              <option value="15778458"<?=$config['wholesaleTimeGold']==15778458?' selected':'';?>>6 Months</option>
              <option value="31556926"<?=$config['wholesaleTimeGold']==31556926?' selected':'';?>>1 Year</option>
              <option value="63113852"<?=$config['wholesaleTimeGold']==63113852?' selected':'';?>>2 Years</option>
              <option value="94670778"<?=$config['wholesaleTimeGold']==94670778?' selected':'';?>>3 Years</option>
            </select>
          </div>
          <div class="col-2">
            <label for="wholesaleTimePlatinum"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/accounts/settings#accountsWholesaleLimitPlatinum" aria-label="PermaLink to Wholesale Time Limit Platinum Field">&#128279;</a>':'';?><small>Wholesale Platinum Limit</small></label>
            <select id="wholesaleTimePlatinum" data-dbid="1" data-dbt="login" data-dbc="wholesaleTimePlatinum"<?=$user['options'][5]==1?'':' disabled';?> onchange="update('1','config','wholesaleTimePlatinum',$(this).val(),'select');">
              <option value="0"<?=$config['wholesaleTimePlatinum']==0?' selected':'';?>>Use System Default</option>
              <option value="2629743"<?=$config['wholesaleTimePlatinum']==2629743?' selected':'';?>>1 Month</option>
              <option value="5259486"<?=$config['wholesaleTimePlatinum']==5259486?' selected':'';?>>2 Months</option>
              <option value="7889229"<?=$config['wholesaleTimePlatinum']==7889229?' selected':'';?>>3 Months</option>
              <option value="15778458"<?=$config['wholesaleTimePlatinum']==15778458?' selected':'';?>>6 Months</option>
              <option value="31556926"<?=$config['wholesaleTimePlatinum']==31556926?' selected':'';?>>1 Year</option>
              <option value="63113852"<?=$config['wholesaleTimePlatinum']==63113852?' selected':'';?>>2 Years</option>
              <option value="94670778"<?=$config['wholesaleTimePlatinum']==94670778?' selected':'';?>>3 Years</option>
            </select>
          </div>
        </div>

        <hr>
        <legend id="passwordResetSection"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/accounts/settings#passwordResetSection" aria-label="PermaLink to Password Reset Section">&#128279;</a>':'';?>Password Reset Email Layout</legend>
        <div id="passwordResetSubject" class="form-row">
          <label for="pwdRstSub"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/accounts/settings#passwordResetSubject" aria-label="PermaLink to Password Reset Subject Field">&#128279;</a>':'';?>Subject</label>
          <div class="form-text text-right">Tokens: <a class="badger badge-secondary" href="#" onclick="insertAtCaret('pwdRstSub','{business}');return false;">{business}</a> <a class="badger badge-secondary" href="#" onclick="insertAtCaret('pwdRstSub','{date}');return false;">{date}</a></div>
        </div>
        <div class="form-row">
          <input class="textinput" id="pwdRstSub" data-dbid="1" data-dbt="config" data-dbc="passwordResetSubject" type="text" value="<?=$config['passwordResetSubject'];?>">
          <button class="save" id="savepwdRstSub" data-tooltip="tooltip" data-dbid="pwdRstSub" data-style="zoom-in" aria-label="Save"><?= svg2('save');?></button>
        </div>
        <div id="passwordResetLayout" class="form-row mt-3">
          <div class="form-text text-right">
            Tokens:
            <a class="badger badge-secondary" href="#" onclick="$('#pRL').summernote('insertText','{business}');return false;">{business}</a>
            <a class="badger badge-secondary" href="#" onclick="$('#pRL').summernote('insertText','{name}');return false;">{name}</a>
            <a class="badger badge-secondary" href="#" onclick="$('#pRL').summernote('insertText','{first}');return false;">{first}</a>
            <a class="badger badge-secondary" href="#" onclick="$('#pRL').summernote('insertText','{last}');return false;">{last}</a>
            <a class="badger badge-secondary" href="#" onclick="$('#pRL').summernote('insertText','{date}');return false;">{date}</a>
            <a class="badger badge-secondary" href="#" onclick="$('#pRL').summernote('insertText','{password}');return false;">{password}</a>
          </div>
        </div>
        <div class="row">
          <?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/accounts/settings#passwordResetLayout" aria-label="PermaLink to Password Reset Layout">&#128279;</a>':'';?>
          <form method="post" target="sp" class="p-0" action="core/update.php">
            <input name="id" type="hidden" value="1">
            <input name="t" type="hidden" value="config">
            <input name="c" type="hidden" value="passwordResetLayout">
            <textarea class="summernote" id="pRL" name="da"><?= rawurldecode($config['passwordResetLayout']);?></textarea>
          </form>
        </div>
        <hr>
        <legend id="signUpSection"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/accounts/settings#signUpSection" aria-label="PermaLink to Sign Up Section">&#128279;</a>':'';?>Sign Up Emails</legend>
        <div id="activatationSubject" class="form-row">
          <label for="aS"><?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/accounts/settings#activationSubject" aria-label="PermaLink to Account Activation Subject Field">&#128279;</a>':'';?>Subject</label>
          <div class="form-text text-right">Tokens: <a class="badger badge-secondary" href="#" onclick="insertAtCaret('aS','{username}');return false;">{username}</a> <a class="badger badge-secondary" href="#" onclick="insertAtCaret('aS','{site}');return false;">{site}</a></div>
        </div>
        <div class="form-row">
          <input class="textinput" id="aS" data-dbid="1" data-dbt="config" data-dbc="accountActivationSubject" type="text" value="<?=$config['accountActivationSubject'];?>">
          <button class="save" id="saveaS" data-tooltip="tooltip" data-dbid="aS" data-style="zoom-in" aria-label="Save"><?= svg2('save');?></button>
        </div>
        <div id="activationLayout" class="form-row mt-3">
          <div class="form-text text-right">Tokens:
            <a class="badger badge-secondary" href="#" onclick="$('#accountActivationLayout').summernote('insertText','{username}');return false;">{username}</a>
            <a class="badger badge-secondary" href="#" onclick="$('#accountActivationLayout').summernote('insertText','{password}');return false;">{password}</a>
            <a class="badger badge-secondary" href="#" onclick="$('#accountActivationLayout').summernote('insertText','{site}');return false;">{site}</a>
            <a class="badger badge-secondary" href="#" onclick="$('#accountActivationLayout').summernote('insertText','{activation_link}');return false;">{activation_link}</a>
          </div>
        </div>
        <div class="row">
          <?=$user['rank']>899?'<a class="permalink" data-tooltip="tooltip" href="'.URL.$settings['system']['admin'].'/accounts/settings#activationLayout" aria-label="PermaLink to Activation Layout">&#128279;</a>':'';?>
          <form class="p-0" method="post" target="sp" action="core/update.php">
            <input name="id" type="hidden" value="1">
            <input name="t" type="hidden" value="config">
            <input name="c" type="hidden" value="accountActivationLayout">
            <textarea class="summernote" id="accountActivationLayout" name="da"><?= rawurldecode($config['accountActivationLayout']);?></textarea>
          </form>
        </div>
        <?php require'core/layout/footer.php';?>
      </div>
    </div>
  </section>
</main>
