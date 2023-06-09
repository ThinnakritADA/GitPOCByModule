<div class="row">
    <input type="hidden" id="ohdTCKLocZonePdtZneChain" name="ohdTCKLocZonePdtZneChain" value="<?= $tZneChain;?>">
    <input type="hidden" id="ohdTCKLocZonePdtZneCode" name="ohdTCKLocZonePdtZneCode" value="<?= $tZneCode;?>">
    <input type="hidden" id="ohdTCKLocZonePdtBchCode" name="ohdTCKLocZonePdtBchCode" value="<?= $tBchCode;?>">
    <div class="col-xs-8 col-sm-8 col-md-4 col-lg-4">
        <div class="form-group">
                <label class="xCNLabelFrm"><?= language('ticketnew/ticketloczone/ticketloczone','tTCKLocZoneSearch')?></label>
                <div class="input-group">
					<input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetTCKLocZoneSearchAll" name="oetTCKLocZoneSearchAll" placeholder="<?php echo language('common/main/main','tPlaceholder')?>">
                    <span class="input-group-btn">
                        <button class="btn xCNBtnSearch" type="button" onclick="JSvTCKLocZonePdtDataTable()">
                            <img class="xCNIconAddOn" src="<?= base_url().'/application/modules/common/assets/images/icons/search-24.png' ?>">
                        </button>
                    </span>
                </div>
            </div>
    </div>
    <div class="col-xs-4 col-sm-4 col-md-8 col-lg-8 text-right">
        <div class="demo-button xCNBtngroup" style="width:100%;">
            <?php if($aAlwEventLocZone['tAutStaFull'] == 1 || ($aAlwEventLocZone['tAutStaAdd'] == 1 || $aAlwEventLocZone['tAutStaEdit'] == 1)) : ?>
                <div id="odvTCKLocZonePdtBtnGrpInfo">
                    <button id="obtTCKLocZoneBrowsePdt" class="xCNBTNPrimeryPlus" type="button">+</button>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<div>
    <div id="odvTCKLocZonePdtContent"></div>
</div>
<?php include "script/jTicketloczonePdtAdd.php";?>
<script type="text/javascript" src="<?= base_url('application/modules/ticketnew/assets/src/ticketloczone/jTicketloczonePdt.js'); ?>"></script>


