<?php 
    if($aDataList['rtCode'] == '1'){
        $nCurrentPage = $aDataList['rnCurrentPage'];
    }else{
        $nCurrentPage ='1';
    }
?>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
					<tr>
                        <?php if($aAlwEventBchLoc['tAutStaFull'] == 1 || $aAlwEventBchLoc['tAutStaDelete'] == 1) : ?>
						    <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?= language('common/main/main','tCMNChoose')?></th>
						<?php endif; ?>
                        <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?= language('ticketnew/ticketbchloc/ticketbchloc','tTCKBchLocImg')?></th>
                        <th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?= language('ticketnew/ticketbchloc/ticketbchloc','tTCKBchLocCode')?></th>
						<th nowrap class="xCNTextBold" style="width:30%;text-align:center;"><?= language('ticketnew/ticketbchloc/ticketbchloc','tTCKBchLocName')?></th>
                        <th nowrap class="xCNTextBold" style="width:12%;text-align:center;"><?= language('ticketnew/ticketbchloc/ticketbchloc','tTCKBchLocStaAlwPet')?></th>
                        <!-- <th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?= language('ticketnew/ticketbchloc/ticketbchloc','tTCKBchLocStaAlwBook')?></th> -->
                        <th nowrap class="xCNTextBold" style="width:12%;text-align:center;"><?= language('ticketnew/ticketbchloc/ticketbchloc','tTCKBchLocCapacity')?></th>
                        <th nowrap class="xCNTextBold" style="width:11%;text-align:center;"><?= language('ticketnew/ticketbchloc/ticketbchloc','tTCKBchLocStaUse')?></th>
                        <?php if($aAlwEventBchLoc['tAutStaFull'] == 1 || $aAlwEventBchLoc['tAutStaDelete'] == 1) : ?>
                            <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?= language('common/main/main','tCMNActionDelete')?></th>
						<?php endif; ?>
                        <?php if($aAlwEventBchLoc['tAutStaFull'] == 1 || ($aAlwEventBchLoc['tAutStaEdit'] == 1 || $aAlwEventBchLoc['tAutStaRead'] == 1))  : ?>
                            <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?= language('common/main/main','tCMNActionEdit')?></th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody id="otbTCKBchLocList">
                    <?php if(isset($aDataList['rtCode']) && $aDataList['rtCode'] == 1 ) : ?>
                        <?php foreach($aDataList['raItems'] AS $key=>$aValue) : ?>
                            <?php
                                if($aValue['nCountZne'] > 0 || $aValue['nCountFac'] > 0 || $aValue['nCountPdt'] > 0){
                                    $tDisableTD     = "xWTdDisable";
                                    $tDisableImg    = "xWImgDisable";
                                    $tDisableDeItem = "disabled ";
                                }else{
                                    $tDisableTD     = "";
                                    $tDisableImg    = "";
                                    $tDisableDeItem = "";
                                }
                            ?>
                            <tr class="text-center xCNTextDetail2 otrTCKBchLoc" id="otrTCKBchLoc<?= $key ?>" 
                                data-loccode = "<?= $aValue['FTLocCode']?>" 
                                data-bchcode = "<?= $aValue['FTBchCode']?>"
                                data-locname = "<?= $aValue['FTLocName']?>" >
                                <?php if($aAlwEventBchLoc['tAutStaFull'] == 1 || $aAlwEventBchLoc['tAutStaDelete'] == 1) : ?>
                                    <td class="text-center">
                                        <label class="fancy-checkbox">
                                            <input type="checkbox" class="ocbListItem" id="ocbTCKBchLocListItem<?= $key ?>" name="ocbTCKBchLocListItem[]" <?= $tDisableDeItem; ?>>
                                            <span>&nbsp;</span>
                                        </label>
                                    </td>
                                <?php endif; ?>
                                <td nowrap class="text-center"><?= FCNtHGetImagePageList($aValue['FTImgObj'],'70px'); ?></td>
                                <td nowrap class="text-left"><?= $aValue['FTLocCode'] ?></td>
                                <td nowrap class="text-left"><?= $aValue['FTLocName'] ?></td>
                                <td nowrap class="text-left"><?= ($aValue['FTLocStaAlwPet'] == '1') ? language('ticketnew/ticketbchloc/ticketbchloc','tTCKBchLocAlw') : language('ticketnew/ticketbchloc/ticketbchloc','tTCKBchLocNotAlw'); ?></td>
                                <!-- <td nowrap class="text-left"><?= ($aValue['FTLocStaAlwBook'] == '1') ? language('ticketnew/ticketbchloc/ticketbchloc','tTCKBchLocAlw') : language('ticketnew/ticketbchloc/ticketbchloc','tTCKBchLocNotAlw'); ?></td> -->
                                <td nowrap class="text-right"><?= ($aValue['FCLocCapacity'] != 0) ? number_format($aValue['FCLocCapacity'], 0, '.', ',') : '-' ; ?></td>
                                <td nowrap class="text-left"><?= ($aValue['FTLocStaUse'] == '1') ? language('ticketnew/ticketbchloc/ticketbchloc','tTCKBchLocUse') : language('ticketnew/ticketbchloc/ticketbchloc','tTCKBchLocNotUse'); ?></td>
                                <?php if($aAlwEventBchLoc['tAutStaFull'] == 1 || $aAlwEventBchLoc['tAutStaDelete'] == 1) : ?>
                                    <td class="text-center <?= $tDisableTD; ?>">
                                        <img class="xCNIconTable xCNIconDelete <?= $tDisableImg; ?>" id="oimBtnDelBchLoc<?= $aValue['FTLocCode']?>" onClick="JSvTCKBchLocDel('<?= $nCurrentPage?>', '<?= $aValue['FTLocCode']?>', '<?= $aValue['FTLocName']?>', '<?= language('common/main/main', 'tBCHYesOnNo')?>')">
                                    </td>
                                <?php endif; ?>
                                <?php if($aAlwEventBchLoc['tAutStaFull'] == 1 || ($aAlwEventBchLoc['tAutStaEdit'] == 1 || $aAlwEventBchLoc['tAutStaRead'] == 1)) : ?>
                                    <td class="text-center">
                                        <img class="xCNIconTable xCNIconEdit" onClick="JSvTCKBchLocCallPageBchLocEdit('<?= $aValue['FTLocCode'] ?>')">
                                    </td>
                                <?php endif; ?>  
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr><td class='text-center xCNTextDetail2' colspan='99'><?= language('common/main/main', 'tCMNNotFoundData')?></td></tr>
                    <?php endif; ?>
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
        <div class="xWPageWah btn-toolbar pull-right">
            <!-- เปลี่ยนตัวแปร Onclick เป็นของ previous  -->
            <?php $tDisabledLeft = ($nPage == 1) ? 'disabled' : '-'; ?>
            <button onclick="JSvTCKBchLocClickPage('previous')" class="btn btn-white btn-sm" <?= $tDisabledLeft ?>> 
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <!-- เปลี่ยนตัวแปร Loop Onclick เป็นของหน้านั้น ๆ -->
            <?php for($i = max($nPage - 2, 1); $i <= max(0, min($aDataList['rnAllPage'], $nPage + 2)); $i++) : ?>
                <?php
                    if($nPage == $i){ 
                        $tActive        = "active"; 
                        $tDisPageNumber = "disabled";
                    }else{ 
                        $tActive        = "";
                        $tDisPageNumber = "";
                    }
                ?>
                <button onclick="JSvTCKBchLocClickPage('<?= $i?>')" type="button" class="btn xCNBTNNumPagenation <?= $tActive ?>" <?= $tDisPageNumber ?>><?= $i?></button>
            <?php endfor; ?>
            <!-- เปลี่ยนตัวแปร Onclick เป็นของ next -->
            <?php $tDisabledRight = ($nPage >= $aDataList['rnAllPage']) ? 'disabled' : '-'; ?>
            <button onclick="JSvTCKBchLocClickPage('next')" class="btn btn-white btn-sm" <?= $tDisabledRight ?>>
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>

<!-- Model ยืนยันการลบข้อมูล -->
<div class="modal fade" id="odvTCKBchLocModalDelete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?= language('common/main/main', 'tModalDelete')?></label>
			</div>
            <div class="modal-body">
                <span id="ospTCKBchLocConfirmDelete" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
				<input type='hidden' id="ohdTCKBchLocConfirmIDDelete">
            </div>
            <div class="modal-footer">
                <button id="obtTCKBchLocConfirmDelete" type="button" class="btn xCNBTNPrimery">
					<?= language('common/main/main', 'tModalConfirm')?>
				</button>
                <button class="btn xCNBTNDefult" type="button"  data-dismiss="modal">
					<?= language('common/main/main', 'tModalCancel')?>
				</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    // Select multiple delete
    $('.ocbListItem').click(function(){
        let tLocCode = $(this).parent().parent().parent().data('loccode');
        let tBchCode = $(this).parent().parent().parent().data('bchcode');
        let tLocName = $(this).parent().parent().parent().data('locname');
        $(this).prop('checked', true);
        let LocalItemData = localStorage.getItem("LocalItemData");
        let obj = [];
        if(LocalItemData){
            obj = JSON.parse(LocalItemData);
        }
        let aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
        if(aArrayConvert == '' || aArrayConvert == null){
            obj.push({"tLocCode": tLocCode, "tBchCode": tBchCode , "tLocName": tLocName });
            localStorage.setItem("LocalItemData",JSON.stringify(obj));
            JSxTCKBchLocTextinModal();
        }else{
            let aReturnRepeat = JSxTCKBchLocfindObjectByKey(aArrayConvert[0], 'tLocCode', tLocCode);
            if(aReturnRepeat == 'None'){ //ยังไม่ถูกเลือก
                obj.push({"tLocCode": tLocCode, "tBchCode": tBchCode , "tLocName": tLocName });
                localStorage.setItem("LocalItemData",JSON.stringify(obj));
                JSxTCKBchLocTextinModal();
            }else if(aReturnRepeat == 'Dupilcate'){ //เคยเลือกไว้แล้ว
                localStorage.removeItem("LocalItemData");
                $(this).prop('checked', false);
                let nLength = aArrayConvert[0].length;
                for($i = 0; $i < nLength; $i++){
                    if(aArrayConvert[0][$i].tLocCode == tLocCode && aArrayConvert[0][$i].tBchCode == tBchCode ){
                        delete aArrayConvert[0][$i];
                    }
                }
                let aNewarraydata = [];
                for($i = 0; $i < nLength; $i++){
                    if(aArrayConvert[0][$i] != undefined){
                        aNewarraydata.push(aArrayConvert[0][$i]);
                    }
                }
                localStorage.setItem("LocalItemData",JSON.stringify(aNewarraydata));
                JSxTCKBchLocTextinModal(); 
            }
        }
        JSxTCKBchLocShowButtonChoose(); 
    });
</script>