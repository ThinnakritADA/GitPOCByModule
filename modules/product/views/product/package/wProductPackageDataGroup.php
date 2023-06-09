<style>
    .xWBorderBottomPdtPkg{
        border-bottom: 1px dotted #eeeeee !important;
    }

    .xWBorderPdtPkg{
        border-left: 1px solid #eeeeee !important;
    }

    .xWBTNPdtPkgAddNew{
        padding: 7px;
        width: 100%;
        color: #232c3d !important;
        background-color: #FFFFFF;
        border: 1px solid #ccc !important;
        font-weight: normal;
        line-height: 1.42857143;
        font-size: 18px !important;
        border-radius: 4px;
        -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
    }

    .xWBTNPdtPkgAddNew:hover {
        background-color: transparent;
        color: #179BFD !important;
        border-color: #179BFD;
    }

    .xWIconEditGrpName{
        filter: brightness(0) invert(1);
        margin-left: 5px;
        width: 18px;
    }
</style>

<?php if (isset($aDataGrp['rtCode']) && $aDataGrp['rtCode'] == 1) : ?>
    <input type="hidden" id="ohdPkgGrpAddKey" value="">

    <!-- ข้อมูลกลุ่มแพ็คเกจที่มี -->
    <?php foreach ($aDataGrp['raItems'] as $key => $aValue) : 
        $tPdtCode       = $aValue['FTPdtCode'];
        $tPkdGrpSeqNo   = $aValue['FNPkdGrpSeqNo'];
        $tPkdGrpName    = $aValue['FTPkdGrpName'];
        $nPkdGrpSeq     = $aValue['GrpNo'];
        $nPkdType       = $aValue['FTPkdType'];
        $nRefPdt        = $aValue['nRefPdt'];
        $nPdtInPkgGrp   = 0;
    ?>
        <div class="row xWPdtPkgGrp"
            data-key='<?= $key ?>'
            data-grpseq='<?= $nPkdGrpSeq; ?>'
            data-pdtcode='<?= $tPdtCode; ?>'
            data-grpcode='<?= $tPkdGrpSeqNo; ?>'>
            <div id="odvPdtPkgPanelGrp" class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top: 10px;">
                <div class="panel panel-default xCNDepositCashContainer" style="margin-bottom: 25px;">
                    <div id="odvHeadGeneralInfo" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                        <input type="hidden" id="ohdPkgGrpSeq<?= $key ?>"   value="<?= $nPkdGrpSeq ?>">
                        <input type="hidden" id="ohdPkgGrpSeqNo<?= $key ?>" value="<?= $tPkdGrpSeqNo ?>">
                        <input type="hidden" id="ohdPkgGrpName<?= $key ?>"  value="<?= $tPkdGrpName ?>">
                        <input type="hidden" id="ohdPkgTypeNew<?= $key ?>"  value="">
                        <label class="xCNTextModalHeard" style="font-size:20px !important;"><?= language('product/product/product', 'tPDTPkdGrp'); ?> : <?= $tPkdGrpName; ?></label>
                        <img class="xCNIconTable xCNIconEdit xWIconEditGrpName" onClick="JSvPdtPkgCallModalAddEditGrp('pdtPackageEventEditGrpIntoTmp', '<?= language('product/product/product', 'tPDTPkdEditGrp'); ?>', '<?= $key; ?>');">
                        <button type="button" class="close" style="color:#FFF; opacity:1; margin-top: -2px;" onclick="JSvPdtPkgDelGrp('<?= $nPkdGrpSeq; ?>', '<?= $tPkdGrpSeqNo; ?>', '<?= $tPkdGrpName; ?>', '<?= language('common/main/main', 'tPDTPkdConfirmDel')?>', '<?= language('common/main/main', 'tBCHYesOnNo')?>')">
                            <span style="font-size: 30px !important;">×</span>
                        </button>
                    </div>

                    <div class="panel-collapse collapse in" role="tabpanel">
                        <div class="panel-body xCNPDModlue" style="margin: 10px;">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7" style="padding-right: 20px;">
                                    <!-- ข้อมูลสินค้า/สถานที่ในกลุ่ม -->
                                    <?php if (isset($aDataPdt['rtCode']) && $aDataPdt['rtCode'] == 1) : ?>
                                        <?php foreach ($aDataPdt['raItems'] as $keypdt => $aValuePdt) : ?>
                                            <?php if (($aValuePdt['FNPkdGrpSeqNo'] == $tPkdGrpSeqNo) && ($aValuePdt['GrpNo'] == $nPkdGrpSeq)) : 
                                                $nPdtInPkgGrp = 1;
                                                $nPdtPkgQty   = !empty($aValuePdt['FNPkdPdtQty']) ? $aValuePdt['FNPkdPdtQty'] : 1;
                                            ?>
                                                <div class="row xWBorderBottomPdtPkg"
                                                    data-key='<?= $key ?>'
                                                    data-keypdt='<?= $keypdt ?>'
                                                    data-refgrpcode='<?= $aValuePdt['FNPkdGrpSeqNo']; ?>'
                                                    data-refpdtcode='<?= $aValuePdt['FTPdtCodeRef']; ?>'>
                                                    <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 p-t-10">
                                                        <label class="xCNTextDetail2"><?= !empty($aValuePdt['FTPdtCodeRef2']) ? $aValuePdt['FTPdtName'] . "/". $aValuePdt['FTPdtName2'] : $aValuePdt['FTPdtName'] ; ?></label>
                                                    </div>
                                                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
                                                        <?php if($aValuePdt['FTPkdType'] != 2) : ?>
                                                            <div class="form-group" style="margin: 5px 0;">
                                                                <input 
                                                                    type="number" 
                                                                    class="form-control text-right" 
                                                                    min="1" 
                                                                    id="onbPdtPkgQty<?= $aValuePdt['FTPdtCodeRef']; ?>" 
                                                                    name="onbPdtPkgQty<?= $aValuePdt['FTPdtCodeRef']; ?>"
                                                                    autocomplete="off" 
                                                                    onChange="JSxPdtPkgEditPdtQty('<?= $nPkdGrpSeq; ?>', '<?= $aValuePdt['FTPdtCodeRef']; ?>')" 
                                                                    value="<?= $nPdtPkgQty; ?>">
                                                            </div>
                                                        <?php endif; ?>    
                                                    </div>
                                                    <div class="col-xs-7 col-sm-7 col-md-2 col-lg-2 p-t-10">
                                                        <label class="xCNTextDetail2">
                                                            <?= ($aValuePdt['FTPkdType'] == 1) ? language('product/product/product', 'tPDTPkdType1'):language('product/product/product', 'tPDTPkdType2'); ?><?= !empty($aValuePdt['FTPdtCodeRef2']) ? "/โซน" : ""; ?>
                                                        </label>
                                                    </div>
                                                    <div class="col-xs-2 col-sm-2 col-md-1 col-lg-1 text-right p-l-0 p-t-10">
                                                        <img class="xCNIconTable xCNIconDelete xWBchLocAddrDelete" id="oimBtnDelPdtPkgPdtGrp<?= $keypdt; ?>" onClick="JSvPdtPkgDelPdtGrp('<?= $nPkdGrpSeq; ?>', '<?= $aValuePdt['FTPdtCodeRef']; ?>')">
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; ?>

                                        <!-- กรณีไม่มีสินค้าในกลุ่ม -->
                                        <?php if($nPdtInPkgGrp == 0) : ?>
                                            <div class="row xWBorderBottomPdtPkg">
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                                                    <label class="xCNTextDetail2"><?= language('product/product/product', 'tPDTPkdPdtNotFound'); ?></label>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php else : ?>
                                        <!-- กรณีไม่มีสินค้าในกลุ่ม -->   
                                        <div class="row xWBorderBottomPdtPkg">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                                                <label class="xCNTextDetail2"><?= language('product/product/product', 'tPDTPkdPdtNotFound'); ?></label>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <!-- เพิ่มรายการในกลุ่มแพ็คเกจ -->
                                    <div class="row" style="margin-top: 20px;">
                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-9 text-right"></div>
                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3 text-right" style="display: flex;">
                                            <input type="hidden" id="ohdPkgZneChain" value="">
                                            <input type="hidden" id="ohdPkgZneName" value="">
                                            <script>
                                                let nRefPdt  = '<?= $nRefPdt; ?>'
                                                let nPkdType = '<?= $nPkdType; ?>';
                                                if(nRefPdt != 0){
                                                    $('#ocmPdtPkgAddList' + <?= $key ?>).attr('disabled', true);
                                                    if(nPkdType != '2'){
                                                        $('#obtPdtPkgAddPdt' + <?= $key ?>).show();
                                                        $('#obtPdtPkgAddLoc' + <?= $key ?>).hide();
                                                    }else{
                                                        $('#obtPdtPkgAddPdt' + <?= $key ?>).hide();
                                                        $('#obtPdtPkgAddLoc' + <?= $key ?>).show();
                                                    }
                                                }else{
                                                    $('#ocmPdtPkgAddList' + <?= $key ?>).attr('disabled', false);
                                                    $('#obtPdtPkgAddPdt' + <?= $key ?>).show();
                                                    $('#obtPdtPkgAddLoc' + <?= $key ?>).hide();
                                                }
                                            </script>
                                            <button id="obtPdtPkgAddPdt<?= $key ?>" class="xWBTNPdtPkgAddNew" onclick="JSvPdtPkgBrowsePdt('<?= $key; ?>')"><?= language('product/product/product', 'tPDTPkdAddList'); ?></button>
                                            <button id="obtPdtPkgAddLoc<?= $key ?>" class="xWBTNPdtPkgAddNew" onclick="JSvPdtPkgCallModalAddLocZne('<?= $key; ?>')"><?= language('product/product/product', 'tPDTPkdAddLoc'); ?></button>
                                            <!-- <div style="width: 35px; padding-left: 3px;"></div> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 xWBorderPdtPkg" style="padding-left: 20px;">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">    
                                            <label class="xCNLabelFrm" style="font-size:20px !important;"><?= language('product/product/product', 'tPDTPkdCondGrp'); ?></label>
                                        </div>
                                        <!-- กำหนดประเภทกลุ่มของแพ็คเกจ -->
                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">   
                                            <select class="selectpicker form-control" id="ocmPdtPkgAddList<?= $key ?>" name="ocmPdtPkgAddList<?= $key ?>" maxlength="1" onchange="JSvPdtPkgAddList('<?= $key ?>', '<?= $nRefPdt; ?>', '<?= $nPkdGrpSeq; ?>', '<?= $tPkdGrpSeqNo;?>', '<?= $tPkdGrpName; ?>')">
                                                <option value="1" <?= $nPkdType == "1" ? "selected" : ""; ?>><?=language('product/product/product','tPDTPkdType1')?></option>
                                                <option value="2" <?= $nPkdType == "2" ? "selected" : ""; ?>><?=language('product/product/product','tPDTPkdType2')?></option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- จำนวนสูงสุดที่เลือกใช้บริการได้ -->
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="form-group">
                                                <label class="xCNLabelFrm"><?= language('product/product/product', 'tPDTPkdQtyAlw'); ?></label>
                                                <input 
                                                    type="number" 
                                                    class="form-control text-right" 
                                                    min="1" 
                                                    max="<?= $nRefPdt; ?>"
                                                    id="onbPdtPkgMax<?= $nPkdGrpSeq; ?>" 
                                                    name="onbPdtPkgMax<?= $nPkdGrpSeq; ?>"
                                                    autocomplete="off" 
                                                    placeholder="<?= language('product/product/product', 'tPDTPkdQtyAlw'); ?>"
                                                    onChange="JSxPdtPkgEditCondition('<?= $nPkdGrpSeq; ?>')" 
                                                    value="<?= $aValue['FNPkcQtyAlw']; ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- อนุญาตเข้าจุดเดิมซ้ำ -->
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="form-group">
                                                <label class="fancy-checkbox">
                                                    <?php $tCheckAlwDup = ($aValue['FTPkcStaAlwDup'] == 1) ? 'checked' : ''; ?>
                                                    <input 
                                                        type="checkbox" 
                                                        id="ocbPdtPkgStaAlwDup<?= $nPkdGrpSeq; ?>" 
                                                        name="ocbPdtPkgStaAlwDup<?= $nPkdGrpSeq; ?>" 
                                                        onChange="JSxPdtPkgEditCondition('<?= $nPkdGrpSeq; ?>')" 
                                                        value="<?= $aValue['FTPkcStaAlwDup']; ?>" 
                                                        <?= $tCheckAlwDup; ?>>
                                                    <span><?= language('product/product/product', 'tPDTPkdStaAlwDup'); ?></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- ระบุรายการตอนซื้อ -->
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="form-group">
                                                <label class="fancy-checkbox">
                                                    <?php $tCheckSelOrChk = ($aValue['FTPkcStaSelOrChk'] == 1) ? 'checked' : ''; ?>
                                                    <input 
                                                        type="checkbox" 
                                                        id="ocbPdtPkgStaSelOrChk<?= $nPkdGrpSeq; ?>" 
                                                        name="ocbPdtPkgStaSelOrChk<?= $nPkdGrpSeq; ?>" 
                                                        onChange="JSxPdtPkgEditCondition('<?= $nPkdGrpSeq; ?>')" 
                                                        value="<?= $aValue['FTPkcStaSelOrChk']; ?>" 
                                                        <?= $tCheckSelOrChk; ?>>
                                                    <span><?= language('product/product/product', 'tPDTPkdStaSelOrChk'); ?></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>  
<?php else : ?>
    <!-- กรณีไม่มีกลุ่มแพ็คเกจ -->
    <div class="row xWPdtPkgGrp">
        <div id="odvPdtPkgPanelGrp" class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top: 10px;">
            <div class="panel panel-default xCNDepositCashContainer" style="margin-bottom: 25px;">
                <div id="odvHeadGeneralInfo" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextModalHeard" style="font-size:20px !important;"><?= language('product/product/product', 'tPDTPkdGrpNotFound'); ?></label>
                </div>
                <div class="panel-collapse collapse in" role="tabpanel">
                        <div class="panel-body xCNPDModlue" style="margin: 10px;">
                            <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                                <label class="xCNTextDetail2"><?= language('product/product/product', 'tPDTPkdPdtNotFound'); ?></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php include "script/jProductPackageAdd.php"; ?>