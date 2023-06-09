<?php
    if (isset($aResult['rtCode']) && $aResult['rtCode'] == '1') {
        $tRoute         = "masTCKBchLocEventEdit";
        // Control Tab Menu
        $tMenuTabDisable = "";
        $tMenuTabToggle = "tab";

        $tAgnCode       = $aResult['raItem']['FTAgnCode'];
        $tAgnName       = $aResult['raItem']['FTAgnName'];
        $tBchCode       = $aResult['raItem']['FTBchCode'];
        $tBchName       = $aResult['raItem']['FTBchName'];
        $tLocCode       = $aResult['raItem']['FTLocCode'];
        $tLocName       = $aResult['raItem']['FTLocName'];
        $tLocCapacity   = ($aResult['raItem']['FCLocCapacity'] != 0) ? $aResult['raItem']['FCLocCapacity'] : "" ;
        $tLocStaAlwPet  = $aResult['raItem']['FTLocStaAlwPet'];
        $tLocStaAlwBook = $aResult['raItem']['FTLocStaAlwBook'];
        $tLocStaUse     = $aResult['raItem']['FTLocStaUse'];
        $tImgObjPath    = $aResult['raItem']['FTImgObj'];
        $nCountZne      = $aResult['raItem']['nCountZne'];
        $nCountFac      = $aResult['raItem']['nCountFac'];

    } else {
        $tRoute         = "masTCKBchLocEventAdd";
        // Control Tab Menu
        $tMenuTabDisable = " disabled xCNCloseTabNav";
        $tMenuTabToggle = "false";

        $tAgnCode       = "";
        $tAgnName       = "";
        $tBchCode       = "";
        $tBchName       = "";
        $tLocCode       = "";
        $tLocName       = "";
        $tLocCapacity   = "";
        $tLocStaAlwPet  = "";
        $tLocStaAlwBook = "";
        $tLocStaUse     = 1;
        $tImgObjPath    = "";
        $nCountZne      = 0;
        $nCountFac      = 0;
    }
?>

<div id="odvTCKBchLocPanelBody" class="panel-body" style="padding-top:10px !important;">
    <!-- TAB -->
    <div id="odvTCKBchLocRowNavMenu" class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="custom-tabs-line tabs-line-bottom left-aligned">
                <ul class="nav" role="tablist">
                    <li id="oliTCKBchLocTabInfoNav" class="xCNBCHTab active" data-typetab="main" data-tabtitle="bchlocinfo">
                        <a role="tab" data-toggle="tab" data-target="#odvTCKBchLocDataInfo" aria-expanded="true">
                            <?= language('ticketnew/ticketbchloc/ticketbchloc', 'tTCKBchLocHeadTabInfo') ?>
                        </a>
                    </li>
                    <li id="oliTCKBchLocTabZoneNav" class="xCNBCHTab<?= $tMenuTabDisable; ?>" data-typetab="sub" data-tabtitle="bchloczone">
                        <a role="tab" data-toggle="<?= $tMenuTabToggle; ?>" data-target="#odvTCKBchLocDataZone" aria-expanded="true">
                            <?= language('ticketnew/ticketbchloc/ticketbchloc', 'tTCKBchLocHeadTabZone') ?>
                        </a>
                    </li>
                    <li id="oliTCKLocZoneTabPdtNav" class="xCNBCHTab<?= $tMenuTabDisable; ?>" data-typetab="sub" data-tabtitle="bchlocpdt">
                        <a role="tab" data-toggle="<?= $tMenuTabToggle; ?>" data-target="#odvTCKBchLocDataPdt" aria-expanded="true">
                            <?= language('ticketnew/ticketbchloc/ticketbchloc', 'tTCKBchLocHeadTabPdt') ?>
                        </a>
                    </li>
                    <li id="oliTCKBchLocTabFacNav" class="xCNBCHTab<?= $tMenuTabDisable; ?>" data-typetab="sub" data-tabtitle="bchlocfac">
                        <a role="tab" data-toggle="<?= $tMenuTabToggle; ?>" data-target="#odvTCKBchLocDataFac" aria-expanded="true">
                            <?= language('ticketnew/ticketbchloc/ticketbchloc', 'tTCKBchLocHeadTabFac') ?>
                        </a>
                    </li>
                    <li id="oliTCKBchLocTabAddressNav" class="xCNBCHTab<?= $tMenuTabDisable; ?>" data-typetab="sub" data-tabtitle="bchlocaddress">
                        <a role="tab" data-toggle="<?= $tMenuTabToggle; ?>" data-target="#odvTCKBchLocDataAddress" aria-expanded="true">
                            <?= language('ticketnew/ticketbchloc/ticketbchloc', 'tTCKBchLocHeadTabAddress') ?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Tab Location Info -->
    <div id="odvTCKBchLocContentDataTab" class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-xs-12">
            <div class="tab-content">
                <!-- Tab Content Location Info 1 -->
                <div id="odvTCKBchLocDataInfo" class="tab-pane active" style="margin-top:10px;" role="tabpanel" aria-expanded="true">
                    <div class="row" style="margin-right:-30px; margin-left:-30px;">
                        <div class="main-content" style="padding-bottom:0px !important;">
                            <div class="main-content" style="padding-bottom:0px !important;">
                                <form id="ofmTCKBchLocAddLoc" class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
                                    <!-- <input type="hidden" id="ohdTCKBchAgn" name="ohdTCKBchAgn" value="<?= $tAgnCode ?>"> -->
                                    <input type="hidden" id="ohdTCKBchRoute" name="ohdTCKBchRoute" value="<?= $tRoute; ?>">
                                    <button
                                        type="submit"
										id="obtTCKBchLocBtnSubmit"
										class="btn xCNHide"
                                        onclick="JSvTCKBchLocAddEdit('<?= $tRoute?>');" >
                                    </button>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-5 col-md-4 col-lg-4">
                                            <?= FCNtHGetContentUploadImage($tImgObjPath, 'branchlocation'); ?>
                                        </div>
                                        <div class="col-xs-12 col-sm-7 col-md-8 col-lg-8">
                                            <!-- รหัส -->
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                    <div class="form-group">
                                                        <label class="xCNLabelFrm"><span class="text-danger">*</span> <?= language('ticketnew/ticketbchloc/ticketbchloc', 'tTCKBchLocCode') ?></label>
                                                        <div id="odvTCKBchLocAutoGenCode" class="form-group">
                                                            <div class="validate-input">
                                                                <label class="fancy-checkbox">
                                                                    <input type="checkbox" id="ocbTCKBchLocAutoGenCode" name="ocbTCKBchLocAutoGenCode" checked="true" value="1">
                                                                    <span> <?= language('common/main/main', 'tGenerateAuto'); ?></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div id="odvTCKBchLocCodeForm" class="form-group">
                                                            <input type="hidden" id="ohdTCKBchLocCheckDuplicateCode" name="ohdTCKBchLocCheckDuplicateCode" value="1">
                                                            <div class="validate-input">
                                                                <input 
                                                                    type="text" 
                                                                    class="form-control xCNGenarateCodeTextInputValidate" 
                                                                    maxlength="5" 
                                                                    id="oetTCKBchLocCode" 
                                                                    name="oetTCKBchLocCode" 
                                                                    value="<?= $tLocCode; ?>" 
                                                                    data-is-created="<?= $tLocCode; ?>" 
                                                                    autocomplete="off" 
                                                                    placeholder="<?= language('ticketnew/ticketbchloc/ticketbchloc', 'tTCKBchLocCode'); ?>" 
                                                                    data-validate-required="<?= language('ticketnew/ticketbchloc/ticketbchloc', 'tTCKBchLocValidCode'); ?>" 
                                                                    data-validate-dublicateCode="<?= language('ticketnew/ticketbchloc/ticketbchloc', 'tTCKBchLocValidCodeDup'); ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- ชื่ออาคาร-สถานที่ -->
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                    <div class="form-group">
                                                        <label class="xCNLabelFrm"><span class="text-danger">*</span> <?= language('ticketnew/ticketbchloc/ticketbchloc', 'tTCKBchLocName'); ?></label>
                                                        <input
                                                            type="text"
                                                            class="form-control" 
                                                            maxlength="100" 
                                                            id="oetTCKBchLocName" 
                                                            name="oetTCKBchLocName" 
                                                            autocomplete="off" 
                                                            placeholder="<?= language('ticketnew/ticketbchloc/ticketbchloc', 'tTCKBchLocName'); ?>" 
                                                            data-validate-required="<?= language('ticketnew/ticketbchloc/ticketbchloc', 'tTCKBchLocValidName') ?>" 
                                                            value="<?= $tLocName; ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Agency -->
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 <?php if( !FCNbGetIsAgnEnabled()) : echo 'xCNHide';  endif;?>">
                                                    <div class="form-group">
                                                    <label class="xCNLabelFrm"><?= language('authen/user/user','tUSRAgency')?></label>
                                                        <div class="input-group">
                                                            <input type="hidden" class="input100 xCNHide" id="ohdTCKBchLocAgnCode" name="ohdTCKBchLocAgnCode" maxlength="5" value="<?= $tAgnCode; ?>">
                                                            <input class="form-control xWPointerEventNone" type="text" id="oetTCKBchLocAgnName" name="oetTCKBchLocAgnName" value="<?= $tAgnName; ?>" data-validate-required="<?= language('authen/user/user','tUsrValiAgency'); ?>" placeholder="<?= language('authen/user/user','tUSRAgency'); ?>" readonly>
                                                            <span class="input-group-btn">
                                                                <button id="obtTCKBchLocBrowseAgn" type="button" class="btn xCNBtnBrowseAddOn">
								                                    <img src="<?= base_url('application/modules/common/assets/images/icons/find-24.png'); ?>">
                                                                </button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- สาขา -->
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                    <div class="form-group">
                                                        <label class="xCNLabelFrm"><span class="text-danger">*</span> <?= language('ticketnew/ticketbchloc/ticketbchloc', 'tTCKBchLocBch'); ?></label>
                                                        <div class="input-group">
                                                            <input type="hidden" class="input100 xCNHide" id="ohdTCKBchLocBchCode" name="ohdTCKBchLocBchCode" maxlength="5" value="<?= $tBchCode; ?>">
						                                    <input class="form-control xWPointerEventNone" type="text" id="oetTCKBchLocBchName" name="oetTCKBchLocBchName" value="<?= $tBchName; ?>" data-validate-required="<?= language('ticketnew/ticketbchloc/ticketbchloc', 'tTCKBchLocValidBch') ?>" placeholder="<?= language('ticketnew/ticketbchloc/ticketbchloc', 'tTCKBchLocBch'); ?>" readonly>
                                                            <span class="input-group-btn">
                                                                <button id="obtTCKBchLocBrowseBch" type="button" class="btn xCNBtnBrowseAddOn">
								                                    <img src="<?= base_url('application/modules/common/assets/images/icons/find-24.png'); ?>">
                                                                </button>
                                                            </span>
                                                        </div>
                                                    </div>    
                                                </div>
                                            </div>

                                            <!-- ความจุ -->
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                    <div class="form-group">
                                                        <label class="xCNLabelFrm"><?= language('ticketnew/ticketbchloc/ticketbchloc', 'tTCKBchLocCapacity'); ?></label>
                                                        <input
                                                            type="number" 
                                                            class="form-control text-right" 
                                                            min="0"
                                                            step="1"
                                                            maxlength="13"
                                                            id="onbTCKBchLocCapacity" 
                                                            name="onbTCKBchLocCapacity" 
                                                            autocomplete="off" 
                                                            placeholder="<?= language('ticketnew/ticketbchloc/ticketbchloc', 'tTCKBchLocCapacity'); ?>" 
                                                            value="<?= !empty($tLocCapacity) ? number_format($tLocCapacity, 0, '.', '') : $tLocCapacity; ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- อนุญาต สัตว์เลี้ยง -->
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                    <div class="form-group">
                                                        <label class="fancy-checkbox">
                                                            <input type="checkbox" id="ocbTCKBchLocStaAlwPet" name="ocbTCKBchLocStaAlwPet" value="1">
                                                            <span><?= language('ticketnew/ticketbchloc/ticketbchloc', 'tTCKBchLocStaAlwPet') ?></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- อนุญาต จอง ซ่อนไว้ก่อนเดี๋ยวใช้ในเฟส 2-->
                                            <!-- <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                    <div class="form-group">
                                                        <label class="fancy-checkbox">
                                                            <input type="checkbox" id="ocbTCKBchLocStaAlwBook" name="ocbTCKBchLocStaAlwBook" value="1">
                                                            <span><?= language('ticketnew/ticketbchloc/ticketbchloc', 'tTCKBchLocStaAlwBook') ?></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div> -->

                                            <!-- สถานะ -->
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                    <div class="form-group">
                                                        <label class="fancy-checkbox">
                                                            <input type="checkbox" id="ocbTCKBchLocStaUse" name="ocbTCKBchLocStaUse" value="1">
                                                            <span><?= language('ticketnew/ticketbchloc/ticketbchloc', 'tTCKBchLocUse') ?></span>
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

                <!-- Tab Info Data Branch Location Zone -->
                <div id="odvTCKBchLocDataZone" class="tab-pane fade">
                </div>

                <!-- Tab Info Data Branch Location Product -->
                <div id="odvTCKBchLocDataPdt" class="tab-pane fade">
                </div>

                <!-- Tab Info Data Branch Location Facilities -->
                <div id="odvTCKBchLocDataFac" class="tab-pane fade">
                </div>

                <!-- Tab Info Data Branch Location Address -->
                <div id="odvTCKBchLocDataAddress" class="tab-pane fade">
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "script/jTicketbchlocAdd.php";?>