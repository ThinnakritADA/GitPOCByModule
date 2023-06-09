<div class="row p-t-20">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="table-responsive">
            <table id="otbTimeTbDTTableList" class="table table-striped">
                <thead>
                    <tr>
                        <th nowarp class="text-center xCNTextBold" width="8%"><?= language('ticketnew/tickettimetable/tickettimetable','tTCKTimeTbNo');?></th>
                        <th nowarp class="text-center xCNTextBold" width="28%"><?= language('ticketnew/tickettimetable/tickettimetable','tTCKTimeTbCheckIn');?></th>
                        <th nowarp class="text-center xCNTextBold" width="28%"><?= language('ticketnew/tickettimetable/tickettimetable','tTCKTimeTbStart');?></th>
                        <th nowarp class="text-center xCNTextBold" width="28%"><?= language('ticketnew/tickettimetable/tickettimetable','tTCKTimeTbEnd');?></th>
                        <th nowarp class="text-center xCNTextBold" width="8%"><?= language('ticketnew/tickettimetable/tickettimetable','tTCKTimeTbTitleDel')?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($aDataList['rtCode']) && $aDataList['rtCode'] == 1 ) : ?>
                        <?php foreach($aDataList['raItems'] AS $key=>$aValue) : ?>
                            <tr 
                                class="xCNTextDetail2 xWTimeTbDT"
                                data-tmecode  ="<?= $aValue['FTTmeCode'];?>"
                                data-tmeseqno ="<?= $aValue['FNTmeSeqNo'];?>"
                            >
                                <td nowarp class="text-center"><?= $aValue['FNTmeSeqNo'];?></td>
                                <td nowarp class="text-left"><?= $aValue['FTTmeCheckIn'];?></td>
                                <td nowarp class="text-left"><?= $aValue['FTTmeStartTime'];?></td>
                                <td nowarp class="text-left"><?= $aValue['FTTmeEndTime'];?></td>
                                <td nowarp class="text-center">
                                    <img class="xCNIconTable xCNIconDelete xWTimeTbDTDelete">
                                </td>
                        <?php endforeach; ?>
                    <?php else:?>
                        <tr><td class='text-center xCNTextDetail2' colspan='100'><?= language('common/main/main','tCMNNotFoundData')?></td></tr>
                    <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    // Event Click Delete
    $('.xWTimeTbDTDelete').click(function(){
        poElement = this;
        if (poElement.getAttribute("data-dblclick") == null) {
            poElement.setAttribute("data-dblclick", 1);
            $(poElement).select();
            setTimeout(function () {
                if(poElement.getAttribute("data-dblclick") == 1) {
                    let nStaSession = JCNxFuncChkSessionExpired();
                    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                        let oTimeTbDTData = {
                            'FTTmeCode'     : $(poElement).parents('.xWTimeTbDT').data('tmecode'),
                            'FNTmeSeqNo'    : $(poElement).parents('.xWTimeTbDT').data('tmeseqno'),
                        }
                        JSoTCKTimeTbDTDeleteData(oTimeTbDTData);
                    }else{
                        JCNxShowMsgSessionExpired();
                    }
                }
                poElement.removeAttribute("data-dblclick");
            }, 300);
        }
    });
</script>