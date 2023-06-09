<?php
    $tFacAgnCode = $tFacAgnCode;
    $tFacBchCode = $tFacBchCode;
    $tFacLocCode = $tFacLocCode;
?>

<form id="ofmBchLocFacForm" class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
    <button class="xCNHide" id="obtBchLocFacAddEdit" type="submit" onclick="JSvTCKBchLocFacAddEdit()"></button>
    <input type="hidden" id="ohdBchLocFacAgnCode" name="ohdBchLocFacAgnCode" value="<?= $tFacAgnCode; ?>">
    <input type="hidden" id="ohdBchLocFacBchCode" name="ohdBchLocFacBchCode" value="<?= $tFacBchCode; ?>">
    <input type="hidden" id="ohdBchLocFacLocCode" name="ohdBchLocFacLocCode" value="<?= $tFacLocCode; ?>">
    <div class="panel-body" style="padding:0;">
        <div class="col-xs-12 col-sm-12 col-md-12 col-xs-12">
            <!-- สิ่งอำนวยความสะดวก -->
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <div class="form-group">
                    <label class="xCNLabelFrm"><span class="text-danger">*</span> <?= language('ticketnew/ticketbchloc/ticketbchloc','tTCKBchLocFacSelect');?></label>
                        <div class="input-group">
                            <input type="hidden" class="input100 xCNHide" id="ohdTCKBchLocFacCode" name="ohdTCKBchLocFacCode" maxlength="5" value="">
                            <input class="form-control xWPointerEventNone" type="text" id="oetTCKBchLocFacName" name="oetTCKBchLocFacName" value="" data-validate-required="<?= language('ticketnew/ticketbchloc/ticketbchloc','tTCKBchLocValidFac'); ?>" placeholder="<?= language('ticketnew/ticketbchloc/ticketbchloc','tTCKBchLocFacSelect'); ?>" readonly>
                            <span class="input-group-btn">
                                <button id="obtTCKBchLocBrowseFac" type="button" class="btn xCNBtnBrowseAddOn">
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
                                <input type="hidden" class="input100 xCNHide" id="ohdTCKBchLocFacZneCode" name="ohdTCKBchLocFacZneCode" maxlength="5" value="">
                                <input class="form-control xWPointerEventNone" type="text" id="oetTCKBchLocFacZneName" name="oetTCKBchLocFacZneName" value="" placeholder="<?= language('ticketnew/ticketbchloc/ticketbchloc','tTCKBchLocZoneSelect'); ?>" readonly>
                                <span class="input-group-btn">
                                    <button id="obtTCKBchLocBrowseFacZne" type="button" class="btn xCNBtnBrowseAddOn">
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
<?php include "script/jTicketbchlocFacilityForm.php";?>