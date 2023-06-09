<div class="row p-t-20">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="table-responsive">
            <table id="otbBranchAddressTableList" class="table table-striped">
                <thead>
                    <tr>
                        <th nowarp class="text-center xCNTextBold" width="8%"><?= language('company/branch/branch','tBCHAddressTblHeadNo');?></th>
                        <th nowarp class="text-center xCNTextBold" ><?= language('company/branch/branch','tBCHAddressTblHeadAddrName');?></th>
                        <th nowarp class="text-center xCNTextBold" ><?= language('company/branch/branch','tBCHAddressTblHeadAddrTaxNo');?></th>
                        <th nowarp class="text-center xCNTextBold" ><?= language('company/branch/branch','tBCHAddressTblHeadAddrRmk');?></th>
                        <th nowarp class="text-center xCNTextBold" width="8%"><?= language('company/branch/branch','tBCHAddressTblHeadAddrDelete')?></th>
                        <th nowarp class="text-center xCNTextBold" width="8%"><?= language('company/branch/branch','tBCHAddressTblHeadAddrEdit')?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($aDataList['rtCode']) && $aDataList['rtCode'] == 1 ) : ?>
                        <?php foreach($aDataList['raItems'] AS $key=>$aValue) : ?>
                            <tr 
                                class="xCNTextDetail2 xWBchLocAddress"
                                data-lngid="<?= $aValue['FNLngID'];?>"
                                data-addgrptype="<?= $aValue['FTAddGrpType'];?>"
                                data-addrefcode="<?= $aValue['FTAddRefCode'];?>"
                                data-addseqno="<?= $aValue['FNAddSeqNo'];?>"
                            >
                                <td nowarp class="text-center"><?= $aValue['FTAddRefNo'];?></td>
                                <td nowarp class="text-left"><?= $aValue['FTAddName'];?></td>
                                <td nowarp class="text-left"><?= $aValue['FTAddTaxNo'];?></td>
                                <td nowarp class="text-left"><?= $aValue['FTAddRmk'];?></td>
                                <td nowarp class="text-center">
                                    <img class="xCNIconTable xCNIconDelete xWBchLocAddrDelete">
                                </td>
                                <td nowarp class="text-center">
                                    <img class="xCNIconTable xCNIconEdit xWBchLocAddrEdit">
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
    $('.xWBchLocAddrDelete').click(function(){
        poElement = this;
        if (poElement.getAttribute("data-dblclick") == null) {
            poElement.setAttribute("data-dblclick", 1);
            $(poElement).select();
            setTimeout(function () {
                if(poElement.getAttribute("data-dblclick") == 1) {
                    let nStaSession = JCNxFuncChkSessionExpired();
                    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                        let oBchLocAddrData = {
                            'FNLngID'       : $(poElement).parents('.xWBchLocAddress').data('lngid'),
                            'FTAddGrpType'  : $(poElement).parents('.xWBchLocAddress').data('addgrptype'),
                            'FTAddRefCode'  : $(poElement).parents('.xWBchLocAddress').data('addrefcode'),
                            'FNAddSeqNo'    : $(poElement).parents('.xWBchLocAddress').data('addseqno'),
                            'ptTCKBchLocAddrBchCode' : $('#ohdTCKBchLocAddressBchCode').val(),
                        }
                        JSvTCKBchLocAddressDeleteData(oBchLocAddrData);
                    }else{
                        JCNxShowMsgSessionExpired();
                    }
                }
                poElement.removeAttribute("data-dblclick");
            }, 300);
        }
    });
    // Event Click Edits
    $('.xWBchLocAddrEdit').click(function(){
        poElement = this;
        if (poElement.getAttribute("data-dblclick") == null) {
            poElement.setAttribute("data-dblclick", 1);
            $(poElement).select();
            setTimeout(function () {
                if(poElement.getAttribute("data-dblclick") == 1) {
                    let nStaSession = JCNxFuncChkSessionExpired();
                    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                        let oBchLocAddrData = {
                            'FNLngID'       : $(poElement).parents('.xWBchLocAddress').data('lngid'),
                            'FTAddGrpType'  : $(poElement).parents('.xWBchLocAddress').data('addgrptype'),
                            'FTAddRefCode'  : $(poElement).parents('.xWBchLocAddress').data('addrefcode'),
                            'FNAddSeqNo'    : $(poElement).parents('.xWBchLocAddress').data('addseqno'),
                            'ptTCKBchLocAddrBchCode' : $('#ohdTCKBchLocAddressBchCode').val(),
                        }
                        JSvTCKBchLocCallPageBchLocEditAddress(oBchLocAddrData);
                    }else{
                        JCNxShowMsgSessionExpired();
                    }
                }
                poElement.removeAttribute("data-dblclick");
            }, 300);
        }
    });
</script>