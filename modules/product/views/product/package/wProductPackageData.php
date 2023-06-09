<?php
    $tImgObjPath    = $tFirtImage;
    $tPdtCode       = $tPdtCode;
    $tPdtName       = $tPdtName;
?>

<!-- Package -->
<div id="odvPdtPkgContentDataTab" class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-xs-12">
        <form id="ofmPdtPkgAdd" class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
            <input type="hidden" id="ohdPdtCode" name="ohdPdtCode" value="<?= $tPdtCode; ?>">
            <input type="hidden" id="ohdPkgGrpLangEdits" value="<?= $this->session->userdata("tLangEdit");?>">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    <?= FCNtHGetImagePageList($tImgObjPath, '100%'); ?>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                            <label class="xCNLabelFrm xCNLinkClick" style="font-size:22px !important;"><?= language('product/product/product', 'tPDTName'); ?> : <?= $tPdtName; ?></label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 text-right" style="margin-bottom:10px;">
                            <button id="obtPdtPkgBack" class="btn " type="button" style="background-color: #D4D4D4; color: #000000;"><?= language('common/main/main', 'tCancel') ?></button>
                            <button id="obtPdtPkgSave" class="btn " type="button" style="background-color: rgb(23, 155, 253); color: white;"><?= language('common/main/main', 'tSave') ?></button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
                            <div class="demo-button xCNBtngroup" style="width:100%;">
                                <div id="odvPdtPkgBtnGrpInfo">
                                    <button id="obtPdtPkgAddGrp" class="xCNBTNPrimeryPlus" type="button" onclick="JSvPdtPkgCallModalAddEditGrp('pdtPackageEventAddGrpIntoTmp', '<?= language('product/product/product', 'tPDTPkdAddGrp'); ?>', '')">+</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="odvPdtPkgContent">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- ==================================================== Modal Add Group ==================================================== -->

<div id="odvPdtPkgModalAddEditGrp" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"></label>
            </div>
            <div class="modal-body">
                <div class="panel-body" style="padding: 10px;">
                    <form id="ofmPdtPkgAddGrp" class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
                        <input type="hidden" id="ohdPdtPkgPdtCode"  name="ohdPdtPkgPdtCode" value="<?= $tPdtCode; ?>">
                        <input type="hidden" id="ohdPdtPkgRoute"    name="ohdPdtPkgRoute">
                        <input type="hidden" id="ohdPdtPkgGrpSeq"   name="ohdPdtPkgGrpSeq">
                        <input type="hidden" id="ohdPdtPkgGrpSeqNo" name="ohdPdtPkgGrpSeqNo">
                        <input type="hidden" id="ohdPdtPkgGrpNameOld" name="ohdPdtPkgGrpNameOld">
                        
                        <button
                            type="submit"
                            id="obtPdtPkgConfirmAddGrp"
                            class="btn xCNHide"
                            onclick="JSvPdtPkgAddEditGroup();" >
                        </button>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?= language('product/product/product', 'tPDTPkdGrpName'); ?></label>
                                    <input
                                        type="text"
                                        class="form-control" 
                                        maxlength="100" 
                                        id="oetPdtPkgGrpName" 
                                        name="oetPdtPkgGrpName" 
                                        autocomplete="off" 
                                        placeholder="<?= language('product/product/product', 'tPDTPkdGrpName'); ?>" 
                                        data-validate-required="<?= language('product/product/product', 'tPDTPkdValidGrpName'); ?>" 
                                        value="">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal"><?= language('common/main/main', 'tCancel')?></button>
                <button type="submit" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" onclick="$('#obtPdtPkgConfirmAddGrp').click()"><?= language('common/main/main', 'tCMNOK')?></button>
            </div>
        </div>
    </div>
</div>
<!-- ===================================================== Modal Add Group ===================================================== -->

<!-- ================================================= Modal Add Location/Zone ================================================= -->

<div id="odvPdtPkgModalAddLocZne" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?= language('product/product/product', 'tPDTPkdAddLocZne')?></label>
            </div>
            <div class="modal-body">
                <div class="panel-body" style="padding: 10px;">
                    <form id="ofmPdtPkgAddLocZne" class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
                        <input type="hidden" id="ohdPdtPkgPdtCode" name="ohdPdtPkgPdtCode" value="<?= $tPdtCode; ?>">
                        <input type="hidden" id="ohdLocZnePkgType" name="ohdLocZnePkgType" value="">
                        <input type="hidden" id="ohdLocZnePkgGrpSeq" name="ohdLocZnePkgGrpSeq" value="">
                        <input type="hidden" id="ohdLocZnePkgGrpSeqNo" name="ohdLocZnePkgGrpSeqNo" value="">
                        <input type="hidden" id="ohdLocZnePkgGrpName" name="ohdLocZnePkgGrpName" value="">

                        <button
                            type="submit"
                            id="obtPdtPkgConfirmAddLocZne"
                            class="btn xCNHide"
                            onclick="JSvPdtPkgAddLocZne();" >
                        </button>
                        <!-- อาคาร-สถานที่ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><span class="text-danger">*</span> <?= language('product/product/product','tPDTPkdBchLoc');?></label>
                                    <div class="input-group">
                                        <input type="hidden" class="input100 xCNHide" id="ohdPdtPkgLocCode" name="ohdPdtPkgLocCode" maxlength="5" value="">
                                        <input class="form-control xWPointerEventNone" type="text" id="oetPdtPkgLocName" name="oetPdtPkgLocName" value="" data-validate-required="<?= language('product/product/product','tPDTPkdValidBchLoc'); ?>" placeholder="<?= language('product/product/product','tPDTPkdBchLoc'); ?>" readonly>
                                        <span class="input-group-btn">
                                            <button id="obtPdtPkgBrowseLoc" type="button" class="btn xCNBtnBrowseAddOn">
                                                <img src="<?= base_url('application/modules/common/assets/images/icons/find-24.png'); ?>">
                                            </button>
                                        </span>
                                    </div>
                                </div>            
                            </div>
                        </div>
                            
                        <!-- โซน -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?= language('product/product/product','tPDTPkdZne');?></label>
                                        <div class="input-group">
                                            <input type="hidden" class="input100 xCNHide" id="ohdPdtPkgZneCode" name="ohdPdtPkgZneCode" maxlength="5" value="">
                                            <input class="form-control xWPointerEventNone" type="text" id="oetPdtPkgZneName" name="oetPdtPkgZneName" value="" placeholder="<?= language('product/product/product','tPDTPkdZne'); ?>" readonly>
                                            <span class="input-group-btn">
                                                <button id="obtPdtPkgBrowseZne" type="button" class="btn xCNBtnBrowseAddOn">
                                                    <img src="<?= base_url('application/modules/common/assets/images/icons/find-24.png'); ?>">
                                                </button>
                                            </span>
                                        </div>
                                    </div>            
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right m-b-10">
                                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal"><?= language('common/main/main', 'tCancel')?></button>
                                <button type="submit" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" onclick="$('#obtPdtPkgConfirmAddLocZne').click()"><?= language('common/main/main', 'tCMNOK')?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<!-- ================================================= Modal Add Location/Zone ================================================= -->

<!-- ============================================== Model ยืนยันการลบข้อมูล 1 รายการ =============================================== -->
<div class="modal fade" id="odvPdtPkgModalDelete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?= language('common/main/main', 'tModalDelete')?></label>
			</div>
            <div class="modal-body">
                <span id="ospPdtPkgConfirmDelete" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
                <input type='hidden' id="ohdPdtPkgConfirmIDDelete">
            </div>
            <div class="modal-footer">
                <button id="obtPdtPkgConfirmDelete" type="button" class="btn xCNBTNPrimery">
					<?= language('common/main/main', 'tModalConfirm')?>
				</button>
                <button class="btn xCNBTNDefult" type="button"  data-dismiss="modal">
					<?= language('common/main/main', 'tModalCancel')?>
				</button>
            </div>
        </div>
    </div>
</div>
<!-- ============================================== Model ยืนยันการลบข้อมูล 1 รายการ =============================================== -->

<!-- ============================================ Model ยืนยันการลบข้อมูลรายการในกลุ่ม =============================================== -->
<div class="modal fade" id="odvPdtPkgModalDeleteListInGrp">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?= language('common/main/main', 'tModalDelete')?></label>
			</div>
            <div class="modal-body">
                <span id="ospPdtPkgConfirmDeleteListInGrp" class="xCNTextModal" style="display: inline-block; word-break:break-all">
                    <?= language('product/product/product', 'tPDTPkdDelAllPdt'); ?>
                </span>
                <input type="hidden" id="ohdPdtPkgPdtCode" name="ohdPdtPkgPdtCode" value="<?= $tPdtCode; ?>">
                <input type="hidden" id="ohdLocZnePkgDelGrpSeq">
                <input type="hidden" id="ohdLocZnePkgDelGrpSeqNo">
                <input type="hidden" id="ohdLocZnePkgDelGrpName">
            </div>
            <div class="modal-footer">
                <button id="obtPdtPkgConfirmDeleteListInGrp" type="button" class="btn xCNBTNPrimery">
					<?= language('common/main/main', 'tModalConfirm')?>
				</button>
                <button id="obtPdtPkgCancelDeleteListInGrp" class="btn xCNBTNDefult" type="button"  data-dismiss="modal">
					<?= language('common/main/main', 'tModalCancel')?>
				</button>
            </div>
        </div>
    </div>
</div>
<!-- ============================================ Model ยืนยันการลบข้อมูลรายการในกลุ่ม =============================================== -->

<script type="text/javascript" src="<?= base_url('application/modules/product/assets/src/product/jProductPackage.js?v=2'); ?>"></script>