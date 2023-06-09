<div class="row">
    <input type="hidden" id="ohdTCKBchLocZoneAgnCode" name="ohdTCKBchLocZoneAgnCode" value="<?= $tAgnCode;?>">
    <input type="hidden" id="ohdTCKBchLocZoneBchCode" name="ohdTCKBchLocZoneBchCode" value="<?= $tBchCode;?>">
    <input type="hidden" id="ohdTCKBchLocZoneLocCode" name="ohdTCKBchLocZoneLocCode" value="<?= $tLocCode;?>">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <label id="olbTCKBchLocZoneInfo"  class="xCNLabelFrm xCNLinkClick"><?= language('ticketnew/ticketbchloc/ticketbchloc','tTCKBchLocHeadTabZone');?></label>
        <label id="olbTCKBchLocZoneAdd"   class="xCNLabelFrm"> / <?= language('ticketnew/ticketbchloc/ticketbchloc','tTCKBchLocTitleAdd');?></label>
        <label id="olbTCKBchLocZoneEdit"  class="xCNLabelFrm"> / <?= language('ticketnew/ticketbchloc/ticketbchloc','tTCKBchLocTitleEdit');?></label>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right p-r-0">
        <div class="demo-button xCNBtngroup" style="width:100%;">
            <?php if($aAlwEventBchLoc['tAutStaFull'] == 1 || ($aAlwEventBchLoc['tAutStaAdd'] == 1 || $aAlwEventBchLoc['tAutStaEdit'] == 1)) : ?>
                <div id="odvTCKBchLocZoneBtnGrpInfo">
                    <button id="obtTCKBchLocZoneCallPageAdd" class="xCNBTNPrimeryPlus" type="button">+</button>
                </div>
            <?php endif; ?>
            <div id="odvTCKBchLocZoneBtnGrpAddEdit">
                <div class="demo-button xCNBtngroup" style="width:100%;">
                    <button id="obtTCKBchLocZoneCancel" type="button" class="btn" style="background-color:#D4D4D4; color:white;">
                        <?= language('common/main/main','tCancel')?>
                    </button>
                    <?php if($aAlwEventBchLoc['tAutStaFull'] == 1 || ($aAlwEventBchLoc['tAutStaAdd'] == 1 || $aAlwEventBchLoc['tAutStaEdit'] == 1)) : ?>
                        <button id="obtTCKBchLocZoneSave" type="button" class="btn" style="background-color:#179BFD; color:white;">
                            <?= language('common/main/main', 'tSave')?>
                        </button>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div id="odvTCKBchLocZoneContent"></div>
</div>
<script type="text/javascript" src="<?= base_url('application/modules/ticketnew/assets/src/ticketbchloc/jTicketbchlocZone.js'); ?>"></script>