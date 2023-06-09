<?php
    $tPdtAgnCode = $tPdtAgnCode;
    $tPdtBchCode = $tPdtBchCode;
    $tPdtLocCode = $tPdtLocCode;
?>

<form id="ofmBchLocPdtForm" class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
    <button class="xCNHide" id="obtBchLocPdtAddEdit" type="submit" onclick="JSvTCKBchLocPdtAddEdit()"></button>
    <input type="hidden" id="ohdBchLocPdtAgnCode" name="ohdBchLocPdtAgnCode" value="<?= $tPdtAgnCode; ?>">
    <input type="hidden" id="ohdBchLocPdtBchCode" name="ohdBchLocPdtBchCode" value="<?= $tPdtBchCode; ?>">
    <input type="hidden" id="ohdBchLocPdtLocCode" name="ohdBchLocPdtLocCode" value="<?= $tPdtLocCode; ?>">
    <div class="panel-body" style="padding:0;">
        <div class="col-xs-12 col-sm-12 col-md-12 col-xs-12">
            <!-- สินค้า -->
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <div class="form-group">
                    <label class="xCNLabelFrm"><span class="text-danger">*</span> <?= language('ticketnew/ticketbchloc/ticketbchloc','tTCKBchLocPdtSelect');?></label>
                        <div class="input-group">
                            <input type="hidden" class="input100 xCNHide" id="ohdTCKBchLocPdtCode" name="ohdTCKBchLocPdtCode" maxlength="5" value="">
                            <input class="form-control xWPointerEventNone" type="text" id="oetTCKBchLocPdtName" name="oetTCKBchLocPdtName" value="" data-validate-required="<?= language('ticketnew/ticketbchloc/ticketbchloc','tTCKBchLocValidPdt'); ?>" placeholder="<?= language('ticketnew/ticketbchloc/ticketbchloc','tTCKBchLocPdtSelect'); ?>" readonly>
                            <span class="input-group-btn">
                                <button id="obtTCKBchLocBrowsePdt" type="button" class="btn xCNBtnBrowseAddOn">
                                    <img src="<?= base_url('application/modules/common/assets/images/icons/find-24.png'); ?>">
                                </button>
                            </span>
                        </div>
                    </div>            
                </div>
            </div>
            
            <!-- โซน -->
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?= language('ticketnew/ticketbchloc/ticketbchloc','tTCKBchLocZoneSelect');?></label>
                            <div class="input-group">
                                <input type="hidden" class="input100 xCNHide" id="ohdTCKBchLocPdtZneCode" name="ohdTCKBchLocPdtZneCode" maxlength="5" value="">
                                <input class="form-control xWPointerEventNone" type="text" id="oetTCKBchLocPdtZneName" name="oetTCKBchLocPdtZneName" value="" placeholder="<?= language('ticketnew/ticketbchloc/ticketbchloc','tTCKBchLocZoneSelect'); ?>" readonly>
                                <span class="input-group-btn">
                                    <button id="obtTCKBchLocBrowsePdtZne" type="button" class="btn xCNBtnBrowseAddOn">
                                        <img src="<?= base_url('application/modules/common/assets/images/icons/find-24.png'); ?>">
                                    </button>
                                </span>
                            </div>
                        </div>            
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<?php include "script/jTicketbchlocProductForm.php";?>