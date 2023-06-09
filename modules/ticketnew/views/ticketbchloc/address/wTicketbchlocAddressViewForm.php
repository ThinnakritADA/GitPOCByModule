<?php
    $tBchLocAddrRefCode   = $tAddrLocCode;

    // Set Sta Call View Route
    if(isset($nStaCallView) && $nStaCallView == 1){
        $tBchLocAddrRoute ="masTCKBchLocAddrEventAdd";
    }else{
        $tBchLocAddrRoute ="masTCKBchLocAddrEventEdit";
    }

    // Check Data Address
    if (isset($aDataAddress['rtCode']) && $aDataAddress['rtCode'] == '1') {
        $nFNAddSeqNo        = $aDataAddress['raItem']['FNAddSeqNo'];
        $tFTAddVersion      = $aDataAddress['raItem']['FTAddVersion'];
        $tFTAddName         = $aDataAddress['raItem']['FTAddName'];
        $tFTAddGrpType      = $aDataAddress['raItem']['FTAddGrpType'];
        $tFTAddRefNo        = $aDataAddress['raItem']['FTAddRefNo'];
        $tFTAddTaxNo        = $aDataAddress['raItem']['FTAddTaxNo'];
        $tFTAddV2Desc1      = $aDataAddress['raItem']['FTAddV2Desc1'];
        $tFTAddV2Desc2      = $aDataAddress['raItem']['FTAddV2Desc2'];
        $tFTAddWebsite      = $aDataAddress['raItem']['FTAddWebsite'];
        $tFTAddRmk          = $aDataAddress['raItem']['FTAddRmk'];
        $tFTAddLongitude    = $aDataAddress['raItem']['FTAddLongitude'];
        $tFTAddLatitude     = $aDataAddress['raItem']['FTAddLatitude'];
        $tFTAddCountry      = $aDataAddress['raItem']['FTAddCountry'];
        $tFTAddV1No         = $aDataAddress['raItem']['FTAddV1No'];
        $tFTAddV1Village    = $aDataAddress['raItem']['FTAddV1Village'];
        $tFTAddV1Road       = $aDataAddress['raItem']['FTAddV1Road'];
        $tFTAddV1Soi        = $aDataAddress['raItem']['FTAddV1Soi'];
        $tFTAddV1PostCode   = $aDataAddress['raItem']['FTAddV1PostCode'];
        $tFTAddV1PvnCode    = $aDataAddress['raItem']['FTPvnCode'];
        $tFTPvnName         = $aDataAddress['raItem']['FTPvnName'];
        $tFTAddV1DstCode    = $aDataAddress['raItem']['FTDstCode'];
        $tFTDstName         = $aDataAddress['raItem']['FTDstName'];
        $tFTAddV1SubDist    = $aDataAddress['raItem']['FTSudCode'];
        $tFTSudName         = $aDataAddress['raItem']['FTSudName'];
        $tFTAddTel          = $aDataAddress['raItem']['FTAddTel'];
        $tFTAddFax          = $aDataAddress['raItem']['FTAddFax'];
    }else{
        $nFNAddSeqNo        = "";
        $tFTAddVersion      = "";
        $tFTAddName         = "";
        $tFTAddGrpType      = "8";
        $tFTAddRefNo        = "";
        $tFTAddTaxNo        = "";
        $tFTAddV2Desc1      = "";
        $tFTAddV2Desc2      = "";
        $tFTAddWebsite      = "";
        $tFTAddRmk          = "";
        $tFTAddLongitude    = "";
        $tFTAddLatitude     = "";
        $tFTAddCountry      = "";
        $tFTAddV1No         = "";
        $tFTAddV1Village    = "";
        $tFTAddV1Road       = "";
        $tFTAddV1Soi        = "";
        $tFTAddV1PostCode   = "";
        $tFTAddV1PvnCode    = "";
        $tFTPvnName         = "";
        $tFTAddV1DstCode    = "";
        $tFTDstName         = "";
        $tFTAddV1SubDist    = "";
        $tFTSudName         = "";
        $tFTAddTel          = "";
        $tFTAddFax          = "";
    }
    $nStaVersionAddr = $nDataConfigAddr;
    // $nStaVersionAddr = 2;
    // $nStaVersionAddr = 1;
?>

<form id="ofmBchLocAddrForm" class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
    <button class="xCNHide" id="obtBchLocAddrAddEdit" type="submit" onclick="JSvTCKBchLocAddressAddEdit()"></button>
    <input type="hidden" id="ohdBchLocAddrRoute"   name="ohdBchLocAddrRoute"      value="<?= $tBchLocAddrRoute; ?>">
    <input type="hidden" id="ohdBchLocAddrRefCode" name="ohdBchLocAddrRefCode"    value="<?= $tBchLocAddrRefCode; ?>">
    <input type="hidden" id="ohdBchLocAddrVersion" name="ohdBchLocAddrVersion"    value="<?= $nStaVersionAddr; ?>">
    <input type="hidden" id="ohdBchLocAddrGrpType" name="ohdBchLocAddrGrpType"    value="<?= $tFTAddGrpType; ?>">
    <input type="hidden" id="ohdBchLocAddrSeqNo"   name="ohdBchLocAddrSeqNo"      value="<?= $nFNAddSeqNo; ?>">
    <input type="hidden" id="ohdBchLocAddrMapLong" name="ohdBchLocAddrMapLong"    value="<?= $tFTAddLongitude; ?>">
    <input type="hidden" id="ohdBchLocAddrMapLat"  name="ohdBchLocAddrMapLat"     value="<?= $tFTAddLatitude; ?>">
    <?php if(isset($nStaVersionAddr) && $nStaVersionAddr == 2) : ?>
        <div class="panel-body" style="padding:0;">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div  class="form-group">
                            <label class="xCNLabelFrm"><?= language('company/branch/branch','tBCHAddressName');?></label>
                            <input 
                                type="text"
                                class="form-control"
                                maxlength="200"
                                id="oetBchLocAddrName2"
                                name="oetBchLocAddrName2" 
                                autocomplete="off"
                                placeholder="<?= language('company/branch/branch','tBCHAddressName'); ?>" 
                                value="<?= $tFTAddName; ?>"
                            >
                        </div>
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('company/branch/branch','tBCHAddTaxNo');?></label>
                            <input
                                type="text"
                                class="form-control"
                                maxlength="20"
                                id="oetBchLocAddrTaxNo2"
                                name="oetBchLocAddrTaxNo2"
                                autocomplete="off"
                                placeholder="<?= language('company/branch/branch','tBCHAddTaxNo');?>" 
                                value="<?= $tFTAddTaxNo; ?>"
                            >
                        </div>
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('company/branch/branch','tBCHAddV2Desc1');?></label>
                            <textarea class="form-control" rows="2" maxlength="255" id="oetBchLocAddrV2Desc1" name="oetBchLocAddrV2Desc1"><?= $tFTAddV2Desc1; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('company/branch/branch','tBCHAddV2Desc2');?></label>
                            <textarea class="form-control" rows="2" maxlength="255" id="oetBchLocAddrV2Desc2" name="oetBchLocAddrV2Desc2"><?= $tFTAddV2Desc2; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('company/branch/branch','tBCHAddWebsite')?></label>
                            <input 
                                type="text"
                                class="form-control"
                                maxlength="200"
                                id="oetBchLocAddrWeb2"
                                name="oetBchLocAddrWeb2" 
                                placeholder="<?= language('company/branch/branch','tBCHAddWebsite');?>" 
                                value="<?= $tFTAddWebsite; ?>"
                            >
                        </div>
                        <!--เบอร์-->
                        <div  class="form-group">
                            <label class="xCNLabelFrm"><?= language('company/branch/branch','tBCHAddContactTel')?></label>
                            <input
                                type="text"
                                class="form-control "
                                maxlength="50"
                                id="oetBchLocAddrTel2"
                                name="oetBchLocAddrTel2"
                                placeholder="<?= language('company/branch/branch','tBCHAddContactTel');?>"
                                value="<?= $tFTAddTel;?>"
                            >
                        </div>
                        <!--โทรสาร-->
                        <div  class="form-group">
                            <label class="xCNLabelFrm"><?= language('company/branch/branch','tBCHAddContactFax')?></label>
                            <input
                                type="text"
                                class="form-control "
                                maxlength="50"
                                id="oetBchLocAddrFax2"
                                name="oetBchLocAddrFax2"
                                placeholder="<?= language('company/branch/branch','tBCHAddContactFax');?>"
                                value="<?= $tFTAddFax;?>"
                            >
                        </div>
    
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('company/branch/branch','tBCHAddRmk')?></label>
                            <textarea class="form-control" rows="4" maxlength="200" id="oetBchLocAddrRmk2" name="oetBchLocAddrRmk2"><?= $tFTAddRmk; ?></textarea>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 p-t-25">
                        <div class="form-group">
                            <div id="odvBchLocAddrMapView" class="xCNMapShow"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php else : ?>
        <div class="panel-body" style="padding:0;">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div  class="form-group">
                            <label class="xCNLabelFrm"><?= language('company/branch/branch','tBCHAddressName');?></label>
                            <div class="form-group">
                                <input
                                    type="text"
                                    class="form-control"
                                    maxlength="200"
                                    id="oetBchLocAddrName"
                                    name="oetBchLocAddrName"
                                    placeholder="<?= language('company/branch/branch','tBCHAddressName');?>"  
                                    value="<?= $tFTAddName; ?>"
                                >
                            </div>
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?= language('company/branch/branch','tBCHAddTaxNo')?></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    maxlength="20"
                                    id="oetBchLocAddrTaxNo"
                                    name="oetBchLocAddrTaxNo" 
                                    placeholder="<?= language('company/branch/branch','tBCHAddTaxNo');?>" 
                                    value="<?= $tFTAddTaxNo; ?>"
                                >
                            </div>
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?= language('company/branch/branch','tBCHAddWebsite')?></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    maxlength="200"
                                    id="oetBchLocAddrWeb"
                                    name="oetBchLocAddrWeb" 
                                    placeholder="<?= language('company/branch/branch','tBCHAddWebsite');?>" 
                                    value="<?= $tFTAddWebsite;?>"
                                >
                            </div>
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?= language('company/branch/branch','tBCHAddV1No');?></label>
                                <input 
                                    type="text"
                                    class="form-control"
                                    maxlength="30"
                                    id="oetBchLocAddrNo"
                                    name="oetBchLocAddrNo"
                                    placeholder="<?= language('company/branch/branch','tBCHAddV1No');?>" 
                                    value="<?= $tFTAddV1No;?>"
                                >
                            </div>
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?= language('company/branch/branch','tBCHAddV1Village')?></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    maxlength="70"
                                    id="oetBchLocAddrVillage"
                                    name="oetBchLocAddrVillage"
                                    placeholder="<?= language('company/branch/branch','tBCHAddV1Village');?>" 
                                    value="<?= $tFTAddV1Village;?>"
                                >
                            </div>
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?= language('company/branch/branch','tBCHAddV1Road')?></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    maxlength="30"
                                    id="oetBchLocAddrRoad"
                                    name="oetBchLocAddrRoad"
                                    placeholder="<?= language('company/branch/branch','tBCHAddV1Road');?>" 
                                    value="<?= $tFTAddV1Road;?>"
                                >
                            </div>
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?= language('company/branch/branch','tBCHAddV1Soi')?></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    maxlength="30"
                                    id="oetBchLocAddrSoi"
                                    name="oetBchLocAddrSoi"
                                    placeholder="<?= language('company/branch/branch','tBCHAddV1Soi');?>" 
                                    value="<?= $tFTAddV1Soi;?>"
                                >
                            </div>
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?=  language('company/branch/branch','tBCHAddV1PvnCode')?></label>
                                <div class="input-group">
                                    <input 
                                        type="text"
                                        class="form-control xCNHide"
                                        id="oetBchLocAddrPvnCode"
                                        name="oetBchLocAddrPvnCode"
                                        maxlength="5"
                                        value="<?= $tFTAddV1PvnCode;?>"
                                    >
                                    <input 
                                        type="text"
                                        class="form-control xWPointerEventNone"
                                        id="oetBchLocAddrPvnName" 
                                        name="oetBchLocAddrPvnName"
                                        value="<?= $tFTPvnName;?>"
                                        readonly
                                    >
                                    <span class="input-group-btn">
                                        <button id="obtBchLocAddrBrowseProvince" type="button" class="btn xCNBtnBrowseAddOn">
                                            <img src="<?=  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?=  language('company/branch/branch','tBCHAddV1DstCode')?></label>
                                <div class="input-group">
                                    <input
                                        type="text"
                                        class="form-control xCNHide"
                                        id="oetBchLocAddrDstCode"
                                        name="oetBchLocAddrDstCode"
                                        maxlength="5"
                                        value="<?= $tFTAddV1DstCode;?>"
                                    >
                                    <input
                                        type="text"
                                        class="form-control xWPointerEventNone"
                                        id="oetBchLocAddrDstName"
                                        name="oetBchLocAddrDstName"
                                        value="<?= $tFTDstName ?>"
                                        readonly
                                    >
                                    <span class="input-group-btn xCNStartDisabled">
                                        <button id="obtBchLocAddrBrowseDistrict" type="button" class="btn xCNBtnBrowseAddOn">
                                            <img src="<?=  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?=  language('company/branch/branch','tBCHAddV1SubDist')?></label>
                                <div class="input-group">
                                    <input
                                        type="text"
                                        class="form-control xCNHide"
                                        id="oetBchLocAddrSubDstCode"
                                        name="oetBchLocAddrSubDstCode"
                                        maxlength="5"
                                        value="<?= $tFTAddV1SubDist;?>"
                                    >
                                    <input
                                        type="text"
                                        class="form-control xWPointerEventNone"
                                        id="oetBchLocAddrSubDstName"
                                        name="oetBchLocAddrSubDstName"
                                        value="<?= $tFTSudName;?>"
                                        readonly
                                    >
                                    <span class="input-group-btn xCNStartDisabled">
                                        <button id="obtBchLocAddrBrowseSubDistrict" type="button" class="btn xCNBtnBrowseAddOn">
                                            <img src="<?=  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?= language('company/branch/branch','tBCHAddV1PostCode')?></label>
                                <input
                                    type="text"
                                    class="form-control xCNInputNumericWithDecimal"
                                    maxlength="5"
                                    id="oetBchLocAddrPostCode"
                                    name="oetBchLocAddrPostCode"
                                    placeholder="<?= language('company/branch/branch','tBCHAddV1PostCode');?>"
                                    value="<?= $tFTAddV1PostCode;?>"
                                >
                            </div>
                            <!--เบอร์-->
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?= language('company/branch/branch','tBCHAddContactTel')?></label>
                                <input
                                    type="text"
                                    class="form-control "
                                    maxlength="50"
                                    id="oetBchLocAddrTel"
                                    name="oetBchLocAddrTel"
                                    placeholder="<?= language('company/branch/branch','tBCHAddContactTel');?>"
                                    value="<?= $tFTAddTel;?>"
                                >
                            </div>
                            <!--โทรสาร-->
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?= language('company/branch/branch','tBCHAddContactFax')?></label>
                                <input
                                    type="text"
                                    class="form-control "
                                    maxlength="50"
                                    id="oetBchLocAddrFax"
                                    name="oetBchLocAddrFax"
                                    placeholder="<?= language('company/branch/branch','tBCHAddContactFax');?>"
                                    value="<?= $tFTAddFax;?>"
                                >
                            </div>

                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?= language('company/branch/branch','tBCHAddRmk');?></label>
                                <textarea class="form-control" rows="4" maxlength="100" id="oetBchLocAddrRmk" name="oetBchLocAddrRmk"><?= $tFTAddRmk;?></textarea>
                            </div>   
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 p-t-25">
                        <div class="form-group">
                            <div id="odvBchLocAddrMapView" class="xCNMapShow"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</form>
<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<?php include "script/jTicketbchlocAddressForm.php";?>