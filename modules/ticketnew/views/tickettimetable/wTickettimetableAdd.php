<?php
    if (isset($aResult['rtCode']) && $aResult['rtCode'] == '1') {
        $tRoute         = "masTCKTimeTbEventEdit";
        $tTmeCode       = $aResult['raItem']['FTTmeCode'];
        $tTmeName       = $aResult['raItem']['FTTmeName'];
        $tTmeStaAct     = $aResult['raItem']['FTTmeStaActive'];        
    } else {
        $tRoute         = "masTCKTimeTbEventAdd";
        $tTmeCode       = "";
        $tTmeName       = "";
        $tTmeStaAct     = "";    
    }
?>

<div id="odvTCKTimeTbDataInfo" class="tab-pane active" style="margin-top:10px;" role="tabpanel" aria-expanded="true">
    <div class="row" style="margin-right:-30px; margin-left:-30px;">
        <div class="main-content" style="padding-bottom:0px !important;">
            <div class="main-content" style="padding-bottom:0px !important;">
                <form id="ofmTCKTimeTbAdd" class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
                    <input type="hidden" id="ohdTCKTimeTbRoute" name="ohdTCKTimeTbRoute" value="<?= $tRoute; ?>">
                    <button
                        type="submit"
						id="obtTCKTimeTbBtnSubmit"
						class="btn xCNHide"
                        onclick="JSvTCKTimeTbAddEdit('<?= $tRoute?>');" >
                    </button>
                    <div class="row">
                        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
                            <!-- รหัส -->
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><span class="text-danger">*</span> <?= language('ticketnew/tickettimetable/tickettimetable', 'tTCKTimeTbCode') ?></label>
                                        <div id="odvTCKTimeTbAutoGenCode" class="form-group">
                                            <div class="validate-input">
                                                <label class="fancy-checkbox">
                                                    <input type="checkbox" id="ocbTCKTimeTbAutoGenCode" name="ocbTCKTimeTbAutoGenCode" checked="true" value="1" placeholder="<?= language('ticketnew/tickettimetable/tickettimetable', 'tTCKTimeTbCode') ?>">
                                                    <span> <?= language('common/main/main', 'tGenerateAuto'); ?></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div id="odvTCKTimeTbCodeForm" class="form-group">
                                            <input type="hidden" id="ohdTCKTimeTbCheckDuplicateCode" name="ohdTCKTimeTbCheckDuplicateCode" value="1">
                                            <div class="validate-input">
                                                <input 
                                                    type="text" 
                                                    class="form-control xCNGenarateCodeTextInputValidate" 
                                                    maxlength="5" 
                                                    id="oetTCKTimeTbCode" 
                                                    name="oetTCKTimeTbCode" 
                                                    value="<?= $tTmeCode; ?>" 
                                                    data-is-created="<?= $tTmeCode; ?>" 
                                                    autocomplete="off" 
                                                    placeholder="<?= language('ticketnew/tickettimetable/tickettimetable', 'tTCKTimeTbCode'); ?>" 
                                                    data-validate-required="<?= language('ticketnew/tickettimetable/tickettimetable', 'tTCKTimeTbValidCode'); ?>" 
                                                    data-validate-dublicateCode="<?= language('ticketnew/tickettimetable/tickettimetable', 'tTCKTimeTbValidCodeDup'); ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ชื่อตารางเวลา -->
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><span class="text-danger">*</span> <?= language('ticketnew/tickettimetable/tickettimetable', 'tTCKTimeTbName'); ?></label>
                                        <input
                                            type="text"
                                            class="form-control" 
                                            maxlength="100" 
                                            id="oetTCKTimeTbName" 
                                            name="oetTCKTimeTbName" 
                                            autocomplete="off" 
                                            placeholder="<?= language('ticketnew/tickettimetable/tickettimetable', 'tTCKTimeTbName'); ?>" 
                                            data-validate-required="<?= language('ticketnew/tickettimetable/tickettimetable', 'tTCKTimeTbValidName') ?>" 
                                            value="<?= $tTmeName; ?>">
                                    </div>
                                </div>
                            </div> 
                            <!-- สถานะ -->
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label class="fancy-checkbox">
                                            <input type="checkbox" id="ocbTCKTimeTbStaUse" name="ocbTCKTimeTbStaUse" value="1">
                                            <span><?= language('ticketnew/tickettimetable/tickettimetable', 'tTCKTimeTbUse') ?></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="wrap-input100" style="margin:10px 0;"></div>
                <div id="odvTCKTimeTbDataDT"></div>
            </div>
        </div>
    </div>
</div>

<?php include "script/jTickettimetableAdd.php";?>