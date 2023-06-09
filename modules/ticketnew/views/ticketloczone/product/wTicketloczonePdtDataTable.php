<div class="row p-t-20">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="table-responsive">
            <table id="otbLocZonePdtTableList" class="table table-striped">
                <thead>
                    <tr>
                        <th nowarp class="text-center xCNTextBold" width="10%"><?= language('ticketnew/ticketloczone/ticketloczone','tTCKLocZonePdtCode');?></th>
                        <th nowarp class="text-center xCNTextBold" width="85%"><?= language('ticketnew/ticketloczone/ticketloczone','tTCKLocZonePdtName');?></th>
                        <th nowarp class="text-center xCNTextBold" width="5%"><?= language('ticketnew/ticketloczone/ticketloczone','tTCKLocZoneTitleDel'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($aDataList['rtCode']) && $aDataList['rtCode'] == 1 ) : ?>
                        <?php foreach($aDataList['raItems'] AS $key=>$aValue) : ?>
                            <tr 
                                class="xCNTextDetail2 xWLocZonePdt"
                                data-zonechain  = "<?= $aValue['FTZneChain'];?>"
                                data-pdtcode    = "<?= $aValue['FTLzbRefPdt'];?>"
                            >
                                <td nowarp class="text-center"><?= $aValue['FTLzbRefPdt'];?></td>
                                <td nowarp class="text-left"><?= $aValue['FTPdtName'];?></td>
                                <td nowarp class="text-center">
                                    <img class="xCNIconTable xCNIconDelete xWLocZonePdtDelete">
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else:?>
                        <tr><td class='text-center xCNTextDetail2' colspan='100'><?= language('common/main/main','tCMNNotFoundData')?></td></tr>
                    <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- จำนวนข้อมูล/การแบ่งหน้า -->
<div class="row">
    <div class="col-md-6">
        <p><?= language('common/main/main','tResultTotalRecord')?> <?= $aDataList['rnAllRow']?> <?= language('common/main/main','tRecord')?> <?= language('common/main/main','tCurrentPage')?> <?= $aDataList['rnCurrentPage']?> / <?= $aDataList['rnAllPage']?></p>
    </div>
    <div class="col-md-6">
    </div>
</div>

<script type="text/javascript">
    // Event Click Delete
    $('.xWLocZonePdtDelete').click(function(){
        poElement = this;
        if (poElement.getAttribute("data-dblclick") == null) {
            poElement.setAttribute("data-dblclick", 1);
            $(poElement).select();
            setTimeout(function () {
                if(poElement.getAttribute("data-dblclick") == 1) {
                    let nStaSession = JCNxFuncChkSessionExpired();
                    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                        let oLocZonePdtData = {
                            'FTZneChain'    : $(poElement).parents('.xWLocZonePdt').data('zonechain'),
                            'FTLzbRefPdt'   : $(poElement).parents('.xWLocZonePdt').data('pdtcode'),
                        }
                        JSvTCKLocZonePdtDeleteData(oLocZonePdtData);
                    }else{
                        JCNxShowMsgSessionExpired();
                    }
                }
                poElement.removeAttribute("data-dblclick");
            }, 300);
        }
    });
</script>