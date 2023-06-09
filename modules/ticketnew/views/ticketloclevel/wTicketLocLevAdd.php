<?php
    if(isset($nStaAddOrEdit) && $nStaAddOrEdit == 1){
        $tRoute     = "masTIKLevEventEdit";
        $tLevCode   = $aLevData['raItems']['rtLevCode'];
        $tLevName   = $aLevData['raItems']['rtLevName'];
        $tLevRmk    = $aLevData['raItems']['rtLevRmk'];
    }else{
        $tRoute     = "masTIKLevEventAdd";
        $tLevCode   = "";
        $tLevName   = "";
        $tLevRmk    = "";
    }

?>


<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddLev">
    <button style="display:none" type="submit" id="obtSubmitLev" onclick="JSoAddEditLev('<?= $tRoute?>')"></button>
    <div><!-- เพิ่มมาใหม่ --> 
        <div class="panel panel-body" style="padding-top:20px !important;"> <!-- เพิ่มมาใหม่ -->
            <div class="row">
                <div class="col-xs-12 col-md-5 col-lg-5"> <!-- เปลี่ยน Col Class -->

                    <div class="form-group">
                        <label class="xCNLabelFrm"><span class="text-danger">*</span><?= language('ticketnew/ticketloclevel/ticketloclevel','tLEVFrmLevCode')?></label>
                        <div id="odvLevAutoGenCode" class="form-group">
                        <div class="validate-input">
                        <label class="fancy-checkbox">
                            <input type="checkbox" id="ocbLevAutoGenCode" name="ocbLevAutoGenCode" checked="true" value="1">
                            <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                        </label>
                    </div>
                </div>
                    <div id="odvSupplierlevCodeForm" class="form-group">
                        <input type="hidden" id="ohdCheckDuplicateLevCode" name="ohdCheckDuplicateLevCode" value="1">
                                <div class="validate-input">
                                <input
                                type="text"
                                class="form-control xCNGenarateCodeTextInputValidate"
                                maxlength="5"
                                id="oetLevCode"
                                name="oetLevCode"
                                data-is-created="<?php echo $tLevCode;?>"
                                placeholder="<?= language('ticketnew/ticketloclevel/ticketloclevel','tLEVTBCode')?>"
                                value="<?= $tLevCode; ?>"
                                data-validate-required = "<?= language('supplier/supplierlev/supplierlev','tLEVValidCode')?>"
                                data-validate-dublicateCode = "<?= language('supplier/supplierlev/supplierlev','tLEVValidCheckCode')?>"
                            >
                        </div>
                    </div>
                </div>

                    <div class="form-group">
                        <label class="xCNLabelFrm"><span class="text-danger">*</span><?= language('ticketnew/ticketloclevel/ticketloclevel','tLEVFrmLevName')?></label> <!-- เปลี่ยนชื่อ Class -->
                        <input type="text"
                        class="form-control"
                        maxlength="100" id="oetLevName"
                        name="oetLevName"
                        autocomplete="off"
                        placeholder="<?= language('ticketnew/ticketloclevel/ticketloclevel','tLEVFrmLevName')?>"
                        value="<?=$tLevName?>"
                        data-validate-required ="<?= language('ticketnew/ticketloclevel/ticketloclevel','tLEVValidName')?>"> <!-- เปลี่ยนชื่อ Class เพิ่ม DataValidate -->
                    </div>
                    
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?= language('ticketnew/ticketloclevel/ticketloclevel','tLEVFrmLevRmk')?></label> <!-- เปลี่ยนชื่อ Class -->
                        <textarea class="form-control" maxlength="100" rows="4" id="otaLevRmk" name="otaLevRmk" ><?=$tLevRmk?></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<?php include "script/jTicketLocLevAdd.php"; ?>
<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>

<script>
    $('#obtGenCodeLev').click(function(){
        JStGenerateLevCode();
    });

    $("#otaLevRmk").on('keypress change', function (){
        let nMaxLength = $(this).attr('maxlength');
        $(this).val($(this).val().replace(/\r(?!\n)|\n(?!\r)/g, "\r\n").substring(0,nMaxLength));
    });

</script>
