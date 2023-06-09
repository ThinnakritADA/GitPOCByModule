<?php
    if(isset($nStaAddOrEdit) && $nStaAddOrEdit == 1){
        $tRoute     = "masTIKGteEventEdit";
        $tGteCode   = $aGateData['raItems']['rtGteCode'];
        $tGteName   = $aGateData['raItems']['rtGteName'];
        $tGteRmk    = $aGateData['raItems']['rtGteRmk'];
    }else{
        $tRoute     = "masTIKGteEventAdd";
        $tGteCode   = "";
        $tGteName   = "";
        $tGteRmk    = "";
    }

?>


<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddGte">
    <button style="display:none" type="submit" id="obtSubmitGte" onclick="JSoAddEditGte('<?= $tRoute?>')"></button>
    <div><!-- เพิ่มมาใหม่ --> 
        <div class="panel panel-body" style="padding-top:20px !important;"> <!-- เพิ่มมาใหม่ -->
            <div class="row">
                <div class="col-xs-12 col-md-5 col-lg-5"> <!-- เปลี่ยน Col Class -->

                    <div class="form-group">
                        <label class="xCNLabelFrm"><span class="text-danger">*</span><?= language('ticketnew/ticketlocgate/ticketlocgate','tLEVFrmGteCode')?></label>
                        <div id="odvGteAutoGenCode" class="form-group">
                        <div class="validate-input">
                        <label class="fancy-checkbox">
                            <input type="checkbox" id="ocbGteAutoGenCode" name="ocbGteAutoGenCode" checked="true" value="1">
                            <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                        </label>
                    </div>
                </div>
                    <div id="odvSupplierlevCodeForm" class="form-group">
                        <input type="hidden" id="ohdCheckDuplicateGteCode" name="ohdCheckDuplicateGteCode" value="1">
                                <div class="validate-input">
                                <input
                                type="text"
                                class="form-control xCNGenarateCodeTextInputValidate"
                                maxlength="5"
                                id="oetGteCode"
                                name="oetGteCode"
                                data-is-created="<?php echo $tGteCode;?>"
                                placeholder="<?= language('ticketnew/ticketlocgate/ticketlocgate','tLEVTBCode')?>"
                                value="<?= $tGteCode; ?>"
                                data-validate-required = "<?= language('supplier/supplierlev/supplierlev','tLEVValidCode')?>"
                                data-validate-dublicateCode = "<?= language('supplier/supplierlev/supplierlev','tLEVValidCheckCode')?>"
                            >
                        </div>
                    </div>
                </div>

                    <div class="form-group">
                        <label class="xCNLabelFrm"><span class="text-danger">*</span><?= language('ticketnew/ticketlocgate/ticketlocgate','tLEVFrmGteName')?></label> <!-- เปลี่ยนชื่อ Class -->
                        <input type="text"
                        class="form-control"
                        maxlength="100" id="oetGteName"
                        name="oetGteName"
                        autocomplete="off"
                        placeholder="<?= language('ticketnew/ticketlocgate/ticketlocgate','tLEVFrmGteName')?>"
                        value="<?=$tGteName?>"
                        data-validate-required ="<?= language('ticketnew/ticketlocgate/ticketlocgate','tLEVValidName')?>"> <!-- เปลี่ยนชื่อ Class เพิ่ม DataValidate -->
                    </div>
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?= language('ticketnew/ticketlocgate/ticketlocgate','tLEVFrmGteRmk')?></label> <!-- เปลี่ยนชื่อ Class -->
                        <textarea class="form-control" maxlength="100" rows="4" id="otaGteRmk" name="otaGteRmk"><?=$tGteRmk?></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<?php include "script/jTicketLocGateAdd.php"; ?>
<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>

<script>
    $('#obtGenCodeGte').click(function(){
        JStGenerateGteCode();
    });
</script>
