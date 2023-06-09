<?php
    $tZoneAgnCode = $tZoneAgnCode;
    $tZoneBchCode = $tZoneBchCode;
    $tZoneLocCode = $tZoneLocCode;
?>

<form id="ofmBchLocZoneForm" class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
    <button class="xCNHide" id="obtBchLocZoneAddEdit" type="submit" onclick="JSvTCKBchLocZoneAddEdit()"></button>
    <input type="hidden" id="ohdBchLocZoneAgnCode" name="ohdBchLocZoneAgnCode" value="<?= $tZoneAgnCode; ?>">
    <input type="hidden" id="ohdBchLocZoneBchCode" name="ohdBchLocZoneBchCode" value="<?= $tZoneBchCode; ?>">
    <input type="hidden" id="ohdBchLocZoneLocCode" name="ohdBchLocZoneLocCode" value="<?= $tZoneLocCode; ?>">
    <div class="panel-body" style="padding:0;">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="form-group">
            <label class="xCNLabelFrm"><span class="text-danger">*</span> <?= language('ticketnew/ticketbchloc/ticketbchloc','tTCKBchLocZoneSelect');?></label>
                <div class="input-group">
                    <input type="hidden" class="input100 xCNHide" id="ohdTCKBchLocZneChain" name="ohdTCKBchLocZneChain" maxlength="20" value="">
                    <input type="hidden" class="input100 xCNHide" id="ohdTCKBchLocZneCode" name="ohdTCKBchLocZneCode" maxlength="5" value="">
                    <input class="form-control xWPointerEventNone" type="text" id="oetTCKBchLocZneName" name="oetTCKBchLocZneName" value="" data-validate-required="<?= language('ticketnew/ticketbchloc/ticketbchloc','tTCKBchLocValidZne'); ?>" placeholder="<?= language('ticketnew/ticketbchloc/ticketbchloc','tTCKBchLocZoneSelect'); ?>" readonly>
                    <span class="input-group-btn">
                        <button id="obtTCKBchLocBrowseZne" type="button" class="btn xCNBtnBrowseAddOn">
							<img src="<?= base_url('application/modules/common/assets/images/icons/find-24.png'); ?>">
                        </button>
                    </span>
                </div>
            </div>            
        </div>
    </div>
</form>
<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<?php include "script/jTicketbchlocZoneForm.php";?>