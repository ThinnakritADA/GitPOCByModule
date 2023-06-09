<?php
    if(isset($nStaAddOrEdit) && $nStaAddOrEdit == 1){
        $tRoute      = "masTIKFacEventEdit";
        $tFacCode    = $aFacData['raItems']['rtFacCode'];
        $tFacName    = $aFacData['raItems']['rtFacName'];
        $tFacStaUse  = $aFacData['raItems']['FTFacStaAlwUse'];
    }else{
        $tRoute     = "masTIKFacEventAdd";
        $tFacCode   = "";
        $tFacName   = "";
        $tFacStaUse = "";
    }

?>


<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddFac">
    <button style="display:none" type="submit" id="obtSubmitFac" onclick="JSoAddEditFac('<?= $tRoute?>')"></button>
    <div><!-- เพิ่มมาใหม่ --> 
        <div class="panel panel-body" style="padding-top:20px !important;"> <!-- เพิ่มมาใหม่ -->
            <div class="row">
                <div class="col-xs-12 col-md-5 col-lg-5"> <!-- เปลี่ยน Col Class -->

                    <div class="form-group">
                        <label class="xCNLabelFrm"><span class="text-danger">*</span><?= language('ticketnew/ticketlocfac/ticketlocfac','tFACFrmFacCode')?></label>
                        <div id="odvFacAutoGenCode" class="form-group">
                        <div class="validate-input">
                            <label class="fancy-checkbox">
                                <input type="checkbox" id="ocbFacAutoGenCode" name="ocbFacAutoGenCode" checked="true" value="1">
                                <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                            </label>
                        </div>
                    </div>

                    <div id="odvSupplierlevCodeForm" class="form-group">
                        <input type="hidden" id="ohdCheckDuplicateFacCode" name="ohdCheckDuplicateFacCode" value="1">
                            <div class="validate-input">
                                <input
                                type="text"
                                class="form-control xCNGenarateCodeTextInputValidate"
                                maxlength="5"
                                id="oetFacCode"
                                name="oetFacCode"
                                data-is-created="<?php echo $tFacCode;?>"
                                placeholder="<?= language('ticketnew/ticketlocfac/ticketlocfac','tFACTBCode')?>"
                                value="<?= $tFacCode; ?>"
                                data-validate-required = "<?= language('supplier/supplierlev/supplierlev','tFACValidCode')?>"
                                data-validate-dublicateCode = "<?= language('supplier/supplierlev/supplierlev','tFACValidCheckCode')?>"
                            >
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="xCNLabelFrm"><span class="text-danger">*</span><?= language('ticketnew/ticketlocfac/ticketlocfac','tFACFrmFacName')?></label> <!-- เปลี่ยนชื่อ Class -->
                        <input type="text"
                        class="form-control"
                        maxlength="100" id="oetFacName"
                        name="oetFacName"
                        autocomplete="off"
                        placeholder="<?= language('ticketnew/ticketlocfac/ticketlocfac','tFACFrmFacName')?>"
                        value="<?=$tFacName?>"
                        data-validate-required ="<?= language('ticketnew/ticketlocfac/ticketlocfac','tFACValidName')?>"> <!-- เปลี่ยนชื่อ Class เพิ่ม DataValidate -->
                    </div>

                <!-- สถานะใช้งาน -->
                    <div class="form-group">
                        <label class="fancy-checkbox">
                            <?php
                            if ((isset($tFacStaUse) && $tFacStaUse == 1 ) || $tRoute == "masTIKFacEventAdd") {
                                $tChecked   = 'checked';
                            } else {
                                $tChecked   = '';
                            }
                            ?>
                            <input type="checkbox" id="ocbFacStatusUse" name="ocbFacStatusUse" <?php echo $tChecked; ?>>
                            <span> <?php echo language('common/main/main', 'tStaUse'); ?></span>
                        </label>
                    </div>
                <!-- END สถานะใช้งาน -->
                </div>
            </div>
        </div>
    </div>
</form>

<?php include "script/jTicketLocFacAdd.php"; ?>
<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>

<script>
    $('#obtGenCodeFac').click(function(){
        JStGenerateFacCode();
    });
</script>
