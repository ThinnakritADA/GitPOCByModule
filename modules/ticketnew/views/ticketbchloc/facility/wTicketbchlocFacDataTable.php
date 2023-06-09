<div class="row p-t-20">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="table-responsive">
            <table id="otbBranchFacTableList" class="table table-striped">
                <thead>
                    <tr>
                        <th nowarp class="text-center xCNTextBold" width="8%"><?= language('ticketnew/ticketbchloc/ticketbchloc','tTCKBchLocNo');?></th>
                        <th nowarp class="text-center xCNTextBold" width="10%"><?= language('ticketnew/ticketbchloc/ticketbchloc','tTCKBchLocFacCode');?></th>
                        <th nowarp class="text-center xCNTextBold" width="50%"><?= language('ticketnew/ticketbchloc/ticketbchloc','tTCKBchLocFacName');?></th>
                        <th nowarp class="text-center xCNTextBold" width="24%"><?= language('ticketnew/ticketbchloc/ticketbchloc','tTCKBchLocZoneName');?></th>
                        <th nowarp class="text-center xCNTextBold" width="8%"><?= language('common/main/main','tCMNActionDelete');?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($aDataList['rtCode']) && $aDataList['rtCode'] == 1 ) : ?>
                        <?php foreach($aDataList['raItems'] AS $key=>$aValue) : ?>
                            <tr 
                                class="xCNTextDetail2 xWBchLocFac"
                                data-lngid="<?= $aValue['FNLngID'];?>"
                                data-loccode="<?= $aValue['FTLocCode'];?>"
                                data-znecode="<?= $aValue['FTZneCode'];?>"
                                data-faccode="<?= $aValue['FTFacCode'];?>"
                            >
                                <td nowarp class="text-center"><?= $aValue['FNRowID'];?></td>
                                <td nowarp class="text-left"><?= $aValue['FTFacCode'];?></td>
                                <td nowarp class="text-left"><?= $aValue['FTFacName'];?></td>
                                <td nowarp class="text-left"><?= $aValue['FTZneName'];?></td>
                                <td nowarp class="text-center">
                                    <img class="xCNIconTable xCNIconDelete xWBchLocFacDelete">
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
    $('.xWBchLocFacDelete').click(function(){
        poElement = this;
        if (poElement.getAttribute("data-dblclick") == null) {
            poElement.setAttribute("data-dblclick", 1);
            $(poElement).select();
            setTimeout(function () {
                if(poElement.getAttribute("data-dblclick") == 1) {
                    let nStaSession = JCNxFuncChkSessionExpired();
                    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                        let oBchLocFacData = {
                            'ptLocCode' : $(poElement).parents('.xWBchLocFac').data('loccode'),
                            'ptZneCode' : $(poElement).parents('.xWBchLocFac').data('znecode'),
                            'ptFacCode' : $(poElement).parents('.xWBchLocFac').data('faccode'),
                        }
                        JSvTCKBchLocFacDelete(oBchLocFacData);
                    }else{
                        JCNxShowMsgSessionExpired();
                    }
                }
                poElement.removeAttribute("data-dblclick");
            }, 300);
        }
    });
</script>