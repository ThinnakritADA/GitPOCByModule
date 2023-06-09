<form id="ofmTCKTimeTbDTForm" class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
    <button class="xCNHide" id="obtTCKTimeTbDTAddEdit" type="submit" onclick="JSvTCKTimeTbDTAdd()"></button>
    <input type="hidden" id="ohdTimeTbDTTmeCode"  name="ohdTimeTbDTTmeCode" value="<?= $tTmeCode; ?>">
    <div class="panel-body" style="padding:0;">
        <div class="row">
            <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
                <!-- เวลาเช็คอิน -->
                <div class="form-group">
                    <label class="xCNLabelFrm"><?= language('ticketnew/tickettimetable/tickettimetable', 'tTCKTimeTbCheckIn'); ?></label>
                    <input
                        class="form-control" 
                        type="text"
                        id="oetTCKTimeTbDTChackIn" 
                        maxlength="10" 
                        autocomplete="off" 
                        name="oetTCKTimeTbDTChackIn" 
                        placeholder="<?= language('ticketnew/tickettimetable/tickettimetable', 'tTCKTimeTbCheckIn'); ?>" 
                        value="">
                </div>
                <!-- เวลาเริ่มต้น -->
                <div class="form-group">
                    <label class="xCNLabelFrm"><?= language('ticketnew/tickettimetable/tickettimetable', 'tTCKTimeTbStart'); ?></label>
                    <input
                        class="form-control" 
                        type="text"
                        id="oetTCKTimeTbDTStartTime" 
                        maxlength="10" 
                        autocomplete="off" 
                        name="oetTCKTimeTbDTStartTime" 
                        placeholder="<?= language('ticketnew/tickettimetable/tickettimetable', 'tTCKTimeTbStart'); ?>" 
                        value="">
                </div>
                <!-- เวลาเริ่มสิ้นสุด -->
                <div class="form-group">
                    <label class="xCNLabelFrm"><?= language('ticketnew/tickettimetable/tickettimetable', 'tTCKTimeTbEnd'); ?></label>
                    <input
                        class="form-control" 
                        type="text"
                        id="oetTCKTimeTbDTEndTime" 
                        maxlength="10" 
                        autocomplete="off" 
                        name="oetTCKTimeTbDTEndTime" 
                        placeholder="<?= language('ticketnew/tickettimetable/tickettimetable', 'tTCKTimeTbEnd'); ?>" 
                        value="">
                </div>
            </div>
        </div>
    </div>
</form>