<div class="row">
    <input type="hidden" id="ohdTCKBchLocFacAgnCode" name="ohdTCKBchLocFacAgnCode" value="<?= $tAgnCode;?>">
    <input type="hidden" id="ohdTCKBchLocFacBchCode" name="ohdTCKBchLocFacBchCode" value="<?= $tBchCode;?>">
    <input type="hidden" id="ohdTCKBchLocFacLocCode" name="ohdTCKBchLocFacLocCode" value="<?= $tLocCode;?>">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <label id="olbTCKBchLocFacInfo"  class="xCNLabelFrm xCNLinkClick"><?= language('ticketnew/ticketbchloc/ticketbchloc','tTCKBchLocHeadTabFac');?></label>
        <label id="olbTCKBchLocFacAdd"   class="xCNLabelFrm"> / <?= language('ticketnew/ticketbchloc/ticketbchloc','tTCKBchLocTitleAdd');?></label>
        <label id="olbTCKBchLocFacEdit"  class="xCNLabelFrm"> / <?= language('ticketnew/ticketbchloc/ticketbchloc','tTCKBchLocTitleEdit');?></label>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right p-r-0">
        <div class="demo-button xCNBtngroup" style="width:100%;">
            <?php if($aAlwEventBchLoc['tAutStaFull'] == 1 || ($aAlwEventBchLoc['tAutStaAdd'] == 1 || $aAlwEventBchLoc['tAutStaEdit'] == 1)) : ?>
                <div id="odvTCKBchLocFacBtnGrpInfo">
                    <button id="obtTCKBchLocFacCallPageAdd" class="xCNBTNPrimeryPlus" type="button">+</button>
                </div>
            <?php endif; ?>
            <div id="odvTCKBchLocFacBtnGrpAddEdit">
                <div class="demo-button xCNBtngroup" style="width:100%;">
                    <button id="obtTCKBchLocFacCancel" type="button" class="btn" style="background-color:#D4D4D4; color:white;">
                        <?= language('common/main/main','tCancel')?>
                    </button>
                    <?php if($aAlwEventBchLoc['tAutStaFull'] == 1 || ($aAlwEventBchLoc['tAutStaAdd'] == 1 || $aAlwEventBchLoc['tAutStaEdit'] == 1)) : ?>
                        <button id="obtTCKBchLocFacSave" type="button" class="btn" style="background-color:#179BFD; color:white;">
                            <?= language('common/main/main', 'tSave')?>
                        </button>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div id="odvTCKBchLocFacContent"></div>
</div>
<script type="text/javascript" src="<?= base_url('application/modules/ticketnew/assets/src/ticketbchloc/jTicketbchlocFacility.js'); ?>"></script>