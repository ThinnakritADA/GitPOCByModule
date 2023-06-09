<div class="row">
    <input type="hidden" id="ohdTCKTimeTbDTTmeCode" name="ohdTCKTimeTbDTTmeCode" value="<?= $tTmeCode;?>">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <label id="olbTCKTimeTbDTInfo"  class="xCNLabelFrm xCNLinkClick"><?= language('ticketnew/tickettimetable/tickettimetable','tTCKTimeTbHeadDT');?></label>
        <label id="olbTCKTimeTbDTAdd"   class="xCNLabelFrm"> / <?= language('ticketnew/tickettimetable/tickettimetable','tTCKTimeTbTitleAddData');?></label>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right">
        <div class="demo-button xCNBtngroup" style="width:100%;">
            <?php if($aAlwEventTimeTb['tAutStaFull'] == 1 || ($aAlwEventTimeTb['tAutStaAdd'] == 1 || $aAlwEventTimeTb['tAutStaEdit'] == 1)) : ?>
                <div id="odvTCKTimeTbDTBtnGrpInfo">
                    <button id="obtTCKTimeTbDTCallPageAdd" class="xCNBTNPrimeryPlus" type="button" >+</button>
                </div>
            <?php endif; ?>
            <div id="odvTCKTimeTbDTBtnGrpAddEdit">
                <div class="demo-button xCNBtngroup" style="width:100%;">
                    <button id="obtTCKTimeTbDTCancel" type="button" class="btn" style="background-color:#D4D4D4; color:white;">
                        <?= language('common/main/main','tCancel')?>
                    </button>
                    <?php if($aAlwEventTimeTb['tAutStaFull'] == 1 || ($aAlwEventTimeTb['tAutStaAdd'] == 1 || $aAlwEventTimeTb['tAutStaEdit'] == 1)) : ?>
                        <button id="obtTCKTimeTbDTSave" type="button" class="btn" style="background-color:#179BFD; color:white;">
                            <?= language('common/main/main', 'tSave')?>
                        </button>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>
</div>
<div>
    <div id="odvTCKTimeTbDTContent"></div>
</div>
<script type="text/javascript" src="<?= base_url('application/modules/ticketnew/assets/src/tickettimetable/jTickettimetabledt.js'); ?>"></script>
