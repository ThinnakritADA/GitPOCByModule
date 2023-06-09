<?php
    if (isset($aResult['rtCode']) && $aResult['rtCode'] == '1') {
        $tRoute         = "masTCKLocZoneEventEdit";
        // Control Tab Menu
        $tMenuTabDisable = "";
        $tMenuTabToggle = "tab";

        $tZneChain      = $aResult['raItem']['FTZneChain'];
        $tAgnCode       = $aResult['raItem']['FTAgnCode'];
        $tAgnName       = $aResult['raItem']['FTAgnName'];
        $tBchCode       = $aResult['raItem']['FTBchCode'];
        $tBchName       = $aResult['raItem']['FTBchName'];
        $tLocCode       = $aResult['raItem']['FTLocCode'];
        $tLocName       = $aResult['raItem']['FTLocName'];
        $tZneCode       = $aResult['raItem']['FTZneCode'];
        $tZneName       = $aResult['raItem']['FTZneName'];
        $tLevCode       = $aResult['raItem']['FTLevCode'];
        $tLevName       = $aResult['raItem']['FTLevName'];
        $tGteCode       = $aResult['raItem']['FTGteCode'];
        $tGteName       = $aResult['raItem']['FTGteName'];
        $tZneCapacity   = ($aResult['raItem']['FCZneCapacity'] != 0) ? $aResult['raItem']['FCZneCapacity'] : "" ;
        $tZneStaUse     = $aResult['raItem']['FTZneStaUse'];
        $tImgObjPath    = $aResult['raItem']['FTImgObj'];
        $nCountZnePdt   = $aResult['raItem']['nCountZnePdt'];
        
    } else {
        $tRoute         = "masTCKLocZoneEventAdd";
        // Control Tab Menu
        $tMenuTabDisable = " disabled xCNCloseTabNav";
        $tMenuTabToggle = "false";

        $tZneChain      = "";
        $tAgnCode       = "";
        $tAgnName       = "";
        $tBchCode       = "";
        $tBchName       = "";
        $tLocCode       = "";
        $tLocName       = "";
        $tZneCode       = "";
        $tZneName       = "";
        $tLevCode       = "";
        $tLevName       = "";
        $tGteCode       = "";
        $tGteName       = "";
        $tZneCapacity   = "";
        $tZneStaUse     = 1;
        $tImgObjPath    = "";
        $nCountZnePdt   = 0;
    }
?>


<div id="odvTCKLocZonePanelBody" class="panel-body" style="padding-top:10px !important;">
    <!-- TAB -->
    <div id="odvTCKLocZoneRowNavMenu" class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="custom-tabs-line tabs-line-bottom left-aligned">
                <ul class="nav" role="tablist">
                    <li id="oliTCKLocZoneTabInfoNav" class="xCNBCHTab active" data-typetab="main" data-tabtitle="loczoneinfo">
                        <a role="tab" data-toggle="tab" data-target="#odvTCKLocZoneDataInfo" aria-expanded="true">
                            <?= language('ticketnew/ticketloczone/ticketloczone', 'tTCKLocZoneHeadTabInfo') ?>
                        </a>
                    </li>
                    <!-- <li id="oliTCKLocZoneTabPdtNav" class="xCNBCHTab<?= $tMenuTabDisable; ?>" data-typetab="sub" data-tabtitle="loczonepdt">
                        <a role="tab" data-toggle="<?= $tMenuTabToggle; ?>" data-target="#odvTCKLocZoneDataPdt" aria-expanded="true">
                            <?= language('ticketnew/ticketloczone/ticketloczone', 'tTCKLocZoneHeadTabPdt') ?>
                        </a>
                    </li> -->
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Tab Zone Info -->
<div id="odvTCKLocZoneContentDataTab" class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-xs-12">
        <div class="tab-content">
            <!-- Tab Content Zone Info 1 -->
            <div id="odvTCKLocZoneDataInfo" class="tab-pane active" style="margin-top:10px;" role="tabpanel" aria-expanded="true">
                <div class="row" style="margin-right:-30px; margin-left:-30px;">
                    <div class="main-content" style="padding-bottom:0px !important;">
                        <div class="main-content" style="padding-bottom:0px !important;">
                            <form id="ofmTCKLocZoneAdd" class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
                                <input type="hidden" id="ohdTCKLocZoneRoute" name="ohdTCKLocZoneRoute" value="<?= $tRoute; ?>">
                                <input type="hidden" id="ohdTCKLocZoneZneChain" name="ohdTCKLocZoneZneChain" value="<?= $tZneChain; ?>">
                                <input type="hidden" id="ohdTCKLocZoneAgnCode" name="ohdTCKLocZoneAgnCode" value="<?= $tAgnCode; ?>">
                                <input type="hidden" id="ohdTCKLocZoneBchCode" name="ohdTCKLocZoneBchCode" value="<?= $tBchCode; ?>">
                                <input type="hidden" id="ohdTCKLocZoneBchLocCode" name="ohdTCKLocZoneBchLocCode" value="<?= $tLocCode; ?>">

                                <button
                                    type="submit"
									id="obtTCKLocZoneBtnSubmit"
									class="btn xCNHide"
                                    onclick="JSvTCKLocZoneAddEdit('<?= $tRoute?>');" >
                                </button>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-5 col-md-4 col-lg-4">
                                        <?= FCNtHGetContentUploadImage($tImgObjPath, 'ticketloczone'); ?>
                                    </div>
                                    <div class="col-xs-12 col-sm-7 col-md-8 col-lg-8">
                                        <!-- รหัส -->
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><span class="text-danger">*</span> <?= language('ticketnew/ticketloczone/ticketloczone', 'tTCKLocZoneCode') ?></label>
                                                    <div id="odvTCKLocZoneAutoGenCode" class="form-group">
                                                        <div class="validate-input">
                                                            <label class="fancy-checkbox">
                                                                <input type="checkbox" id="ocbTCKLocZoneAutoGenCode" name="ocbTCKLocZoneAutoGenCode" checked="true" value="1" placeholder="<?= language('ticketnew/ticketloczone/ticketloczone', 'tTCKLocZoneCode') ?>">
                                                                <span> <?= language('common/main/main', 'tGenerateAuto'); ?></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div id="odvTCKLocZoneCodeForm" class="form-group">
                                                        <input type="hidden" id="ohdTCKLocZoneCheckDuplicateCode" name="ohdTCKLocZoneCheckDuplicateCode" value="1">
                                                        <div class="validate-input">
                                                            <input 
                                                                type="text" 
                                                                class="form-control xCNGenarateCodeTextInputValidate" 
                                                                maxlength="5" 
                                                                id="oetTCKLocZoneCode" 
                                                                name="oetTCKLocZoneCode" 
                                                                value="<?= $tZneCode; ?>" 
                                                                data-is-created="<?= $tZneCode; ?>" 
                                                                autocomplete="off" 
                                                                placeholder="<?= language('ticketnew/ticketloczone/ticketloczone', 'tTCKLocZoneCode'); ?>" 
                                                                data-validate-required="<?= language('ticketnew/ticketloczone/ticketloczone', 'tTCKLocZoneValidCode'); ?>" 
                                                                data-validate-dublicateCode="<?= language('ticketnew/ticketloczone/ticketloczone', 'tTCKLocZoneValidCodeDup'); ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ชื่อโซน -->
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><span class="text-danger">*</span> <?= language('ticketnew/ticketloczone/ticketloczone', 'tTCKLocZoneName'); ?></label>
                                                    <input
                                                        type="text"
                                                        class="form-control" 
                                                        maxlength="100" 
                                                        id="oetTCKLocZoneName" 
                                                        name="oetTCKLocZoneName" 
                                                        autocomplete="off" 
                                                        placeholder="<?= language('ticketnew/ticketloczone/ticketloczone', 'tTCKLocZoneName'); ?>" 
                                                        data-validate-required="<?= language('ticketnew/ticketloczone/ticketloczone', 'tTCKLocZoneValidName') ?>" 
                                                        value="<?= $tZneName; ?>">
                                                </div>
                                            </div>
                                        </div>  
                                        <!-- ความจุ -->
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?= language('ticketnew/ticketloczone/ticketloczone', 'tTCKLocZoneCapacity'); ?></label>
                                                    <input 
                                                        type="number" 
                                                        class="form-control text-right" 
                                                        min="0" id="onbTCKLocZoneCapacity" 
                                                        name="onbTCKLocZoneCapacity" 
                                                        autocomplete="off" 
                                                        placeholder="<?= language('ticketnew/ticketloczone/ticketloczone', 'tTCKLocZoneCapacity'); ?>" 
                                                        value="<?= !empty($tZneCapacity) ? number_format($tZneCapacity, 0, '.', '') : $tZneCapacity; ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Agency -->
                                        <!-- <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 <?php if( !FCNbGetIsAgnEnabled()) : echo 'xCNHide';  endif;?>">
                                                <div class="form-group">
                                                <label class="xCNLabelFrm"><?= language('authen/user/user','tUSRAgency')?></label>
                                                    <div class="input-group">
                                                        <input type="hidden" class="input100 xCNHide" id="ohdTCKLocZoneAgnCode" name="ohdTCKLocZoneAgnCode" maxlength="5" value="<?= $tAgnCode; ?>">
                                                        <input class="form-control xWPointerEventNone" type="text" id="oetTCKLocZoneAgnName" name="oetTCKLocZoneAgnName" value="<?= $tAgnName; ?>" data-validate-required="<?= language('authen/user/user','tUsrValiAgency'); ?>" placeholder="<?= language('authen/user/user','tUSRAgency'); ?>" readonly>
                                                        <span class="input-group-btn">
                                                            <button id="obtTCKLocZoneBrowseAgn" type="button" class="btn xCNBtnBrowseAddOn" >
								                                <img src="<?= base_url('application/modules/common/assets/images/icons/find-24.png'); ?>">
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> -->
                                        <!-- สาขา -->
                                        <!-- <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?= language('ticketnew/ticketloczone/ticketloczone', 'tTCKLocZoneBch'); ?></label>
                                                    <div class="input-group">
                                                        <input type="hidden" class="input100 xCNHide" id="ohdTCKLocZoneBchCode" name="ohdTCKLocZoneBchCode" maxlength="5" value="<?= $tBchCode; ?>">
						                                <input class="form-control xWPointerEventNone" type="text" id="oetTCKLocZoneBchName" name="oetTCKLocZoneBchName" value="<?= $tBchName; ?>" data-validate-required="<?= language('ticketnew/ticketloczone/ticketloczone', 'tTCKLocZoneValidBch') ?>" placeholder="<?= language('ticketnew/ticketloczone/ticketloczone', 'tTCKLocZoneBch'); ?>" readonly>
                                                        <span class="input-group-btn">
                                                            <button id="obtTCKLocZoneBrowseBch" type="button" class="btn xCNBtnBrowseAddOn">
							                                    <img src="<?= base_url('application/modules/common/assets/images/icons/find-24.png'); ?>">
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>    
                                            </div>
                                        </div> -->
                                        <!-- อาคาร-สถานที่ -->
                                        <!-- <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><span class="text-danger">*</span> <?= language('ticketnew/ticketloczone/ticketloczone', 'tTCKLocZoneBchLoc'); ?></label>
                                                    <div class="input-group">
                                                        <input type="hidden" class="input100 xCNHide" id="ohdTCKLocZoneBchLocCode" name="ohdTCKLocZoneBchLocCode" maxlength="5" value="<?= $tLocCode; ?>">
						                                <input class="form-control xWPointerEventNone" type="text" id="oetTCKLocZoneBchLocName" name="oetTCKLocZoneBchLocName" value="<?= $tLocName; ?>" data-validate-required="<?= language('ticketnew/ticketloczone/ticketloczone', 'tTCKLocZoneValidBchLoc') ?>" placeholder="<?= language('ticketnew/ticketloczone/ticketloczone', 'tTCKLocZoneBchLoc'); ?>" readonly>
                                                        <span class="input-group-btn">
                                                            <button id="obtTCKLocZoneBrowseBchLoc" type="button" class="btn xCNBtnBrowseAddOn">
							                                    <img src="<?= base_url('application/modules/common/assets/images/icons/find-24.png'); ?>">
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>    
                                            </div>
                                        </div> -->
                                        <!-- ชั้น -->
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?= language('ticketnew/ticketloczone/ticketloczone', 'tTCKLocZoneLev'); ?></label>
                                                    <div class="input-group">
                                                        <input type="hidden" class="input100 xCNHide" id="ohdTCKLocZoneLevCode" name="ohdTCKLocZoneLevCode" maxlength="5" value="<?= $tLevCode; ?>">
						                                <input class="form-control xWPointerEventNone" type="text" id="oetTCKLocZoneLevName" name="oetTCKLocZoneLevName" value="<?= $tLevName; ?>" placeholder="<?= language('ticketnew/ticketloczone/ticketloczone', 'tTCKLocZoneLev'); ?>" readonly>
                                                        <span class="input-group-btn">
                                                            <button id="obtTCKLocZoneBrowseLev" type="button" class="btn xCNBtnBrowseAddOn">
							                                    <img src="<?= base_url('application/modules/common/assets/images/icons/find-24.png'); ?>">
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>    
                                            </div>
                                        </div>
                                        <!-- ทางเข้า -->
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?= language('ticketnew/ticketloczone/ticketloczone', 'tTCKLocZoneGate'); ?></label>
                                                    <div class="input-group">
                                                        <input type="hidden" class="input100 xCNHide" id="ohdTCKLocZoneGateCode" name="ohdTCKLocZoneGateCode" maxlength="5" value="<?= $tGteCode; ?>">
						                                <input class="form-control xWPointerEventNone" type="text" id="oetTCKLocZoneGateName" name="oetTCKLocZoneGateName" value="<?= $tGteName; ?>" placeholder="<?= language('ticketnew/ticketloczone/ticketloczone', 'tTCKLocZoneGate'); ?>" readonly>
                                                        <span class="input-group-btn">
                                                            <button id="obtTCKLocZoneBrowseGate" type="button" class="btn xCNBtnBrowseAddOn">
							                                    <img src="<?= base_url('application/modules/common/assets/images/icons/find-24.png'); ?>">
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>    
                                            </div>
                                        </div>
                                        <!-- สถานะ -->
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group">
                                                    <label class="fancy-checkbox">
                                                        <input type="checkbox" id="ocbTCKLocZoneStaUse" name="ocbTCKLocZoneStaUse" value="1">
                                                        <span><?= language('ticketnew/ticketloczone/ticketloczone', 'tTCKLocZoneUse') ?></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Tab Info Data Zone Product -->
            <div id="odvTCKLocZoneDataPdt" class="tab-pane fade">
            </div>
        </div>
    </div>
</div>
<?php include "script/jTicketloczoneAdd.php";?>