<div class="row p-t-20">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="table-responsive">
            <table id="otbBranchPdtTableList" class="table table-striped">
                <thead>
                    <tr>
                        <th nowarp class="text-center xCNTextBold" width="8%"><?= language('ticketnew/ticketbchloc/ticketbchloc','tTCKBchLocNo');?></th>
                        <th nowarp class="text-center xCNTextBold" width="10%"><?= language('ticketnew/ticketbchloc/ticketbchloc','tTCKBchLocPdtCode');?></th>
                        <th nowarp class="text-center xCNTextBold" width="50%"><?= language('ticketnew/ticketbchloc/ticketbchloc','tTCKBchLocPdtName');?></th>
                        <th nowarp class="text-center xCNTextBold" width="24%"><?= language('ticketnew/ticketbchloc/ticketbchloc','tTCKBchLocZoneName');?></th>
                        <th nowarp class="text-center xCNTextBold" width="8%"><?= language('common/main/main','tCMNActionDelete');?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($aDataList['rtCode']) && $aDataList['rtCode'] == 1 ) : ?>
                        <?php foreach($aDataList['raItems'] AS $key=>$aValue) : ?>
                            <tr 
                                class="xCNTextDetail2 xWBchLocPdt"
                                data-lngid="<?= $aValue['FNLngID'];?>"
                                data-loccode="<?= $aValue['FTLocCode'];?>"
                                data-znecode="<?= $aValue['FTZneCode'];?>"
                                data-pdtcode="<?= $aValue['FTLzbRefPdt'];?>"
                            >
                                <td nowarp class="text-center"><?= $aValue['FNRowID'];?></td>
                                <td nowarp class="text-left"><?= $aValue['FTLzbRefPdt'];?></td>
                                <td nowarp class="text-left"><?= $aValue['FTPdtName'];?></td>
                                <td nowarp class="text-left"><?= $aValue['FTZneName'];?></td>
                                <td nowarp class="text-center">
                                    <img class="xCNIconTable xCNIconDelete xWBchLocPdtDelete">
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
<script type="text/javascript">
    // Event Click Delete
    $('.xWBchLocPdtDelete').click(function(){
        poElement = this;
        if (poElement.getAttribute("data-dblclick") == null) {
            poElement.setAttribute("data-dblclick", 1);
            $(poElement).select();
            setTimeout(function () {
                if(poElement.getAttribute("data-dblclick") == 1) {
                    let nStaSession = JCNxFuncChkSessionExpired();
                    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                        let oBchLocPdtData = {
                            'ptLocCode' : $(poElement).parents('.xWBchLocPdt').data('loccode'),
                            'ptZneCode' : $(poElement).parents('.xWBchLocPdt').data('znecode'),
                            'ptPdtCode' : $(poElement).parents('.xWBchLocPdt').data('pdtcode'),
                        }
                        JSvTCKBchLocPdtDelete(oBchLocPdtData);
                    }else{
                        JCNxShowMsgSessionExpired();
                    }
                }
                poElement.removeAttribute("data-dblclick");
            }, 300);
        }
    });
</script>