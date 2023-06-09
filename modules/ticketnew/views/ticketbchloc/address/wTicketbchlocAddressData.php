<div class="row">
    <input type="hidden" id="ohdTCKBchLocAddressAgnCode" name="ohdTCKBchLocAddressAgnCode" value="<?= $tAgnCode;?>">
    <input type="hidden" id="ohdTCKBchLocAddressBchCode" name="ohdTCKBchLocAddressBchCode" value="<?= $tBchCode;?>">
    <input type="hidden" id="ohdTCKBchLocAddressLocCode" name="ohdTCKBchLocAddressLocCode" value="<?= $tLocCode;?>">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <label id="olbTCKBchLocAddressInfo"  class="xCNLabelFrm xCNLinkClick"><?= language('ticketnew/ticketbchloc/ticketbchloc','tTCKBchLocHeadTabAddress');?></label>
        <label id="olbTCKBchLocAddressAdd"   class="xCNLabelFrm"> / <?= language('ticketnew/ticketbchloc/ticketbchloc','tTCKBchLocTitleAdd');?></label>
        <label id="olbTCKBchLocAddressEdit"  class="xCNLabelFrm"> / <?= language('ticketnew/ticketbchloc/ticketbchloc','tTCKBchLocTitleEdit');?></label>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right p-r-0">
        <div class="demo-button xCNBtngroup" style="width:100%;">
            <?php if($aAlwEventBchLoc['tAutStaFull'] == 1 || ($aAlwEventBchLoc['tAutStaAdd'] == 1 || $aAlwEventBchLoc['tAutStaEdit'] == 1)) : ?>
                <div id="odvTCKBchLocAddressBtnGrpInfo">
                    <button id="obtTCKBchLocAddressCallPageAdd" class="xCNBTNPrimeryPlus" type="button">+</button>
                </div>
            <?php endif; ?>
            <div id="odvTCKBchLocAddressBtnGrpAddEdit">
                <div class="demo-button xCNBtngroup" style="width:100%;">
                    <button id="obtTCKBchLocAddressCancel" type="button" class="btn" style="background-color:#D4D4D4; color:white;">
                        <?= language('common/main/main','tCancel')?>
                    </button>
                    <?php if($aAlwEventBchLoc['tAutStaFull'] == 1 || ($aAlwEventBchLoc['tAutStaAdd'] == 1 || $aAlwEventBchLoc['tAutStaEdit'] == 1)) : ?>
                        <button id="obtTCKBchLocAddressSave" type="button" class="btn" style="background-color:#179BFD; color:white;">
                            <?= language('common/main/main', 'tSave')?>
                        </button>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div id="odvTCKBchLocAddressContent"></div>
</div>
<script type="text/javascript" src="<?= base_url('application/modules/ticketnew/assets/src/ticketbchloc/jTicketbchlocAddress.js'); ?>"></script>