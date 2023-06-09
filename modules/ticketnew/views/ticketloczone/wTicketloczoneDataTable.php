<?php 
    if(isset($aDataList['rtCode']) && $aDataList['rtCode'] == '1'){
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
                        <?php if($aAlwEventLocZone['tAutStaFull'] == 1 || $aAlwEventLocZone['tAutStaDelete'] == 1) : ?>
						    <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?= language('common/main/main','tCMNChoose')?></th>
						<?php endif; ?>
                        <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?= language('ticketnew/ticketloczone/ticketloczone','tTCKLocZoneImg')?></th>
                        <th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?= language('ticketnew/ticketloczone/ticketloczone','tTCKLocZoneCode')?></th>
						<th nowrap class="xCNTextBold" style="width:35%;text-align:center;"><?= language('ticketnew/ticketloczone/ticketloczone','tTCKLocZoneName')?></th>
                        <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?= language('ticketnew/ticketloczone/ticketloczone','tTCKLocZoneLev')?></th>
                        <th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?= language('ticketnew/ticketloczone/ticketloczone','tTCKLocZoneGate')?></th>
                        <th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?= language('ticketnew/ticketloczone/ticketloczone','tTCKLocZoneCapacity')?></th>
                        <th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?= language('ticketnew/ticketloczone/ticketloczone','tTCKLocZoneStaUse')?></th>
                        <?php if($aAlwEventLocZone['tAutStaFull'] == 1 || $aAlwEventLocZone['tAutStaDelete'] == 1) : ?>
                            <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?= language('common/main/main','tCMNActionDelete')?></th>
						<?php endif; ?>
                        <?php if($aAlwEventLocZone['tAutStaFull'] == 1 || ($aAlwEventLocZone['tAutStaEdit'] == 1 || $aAlwEventLocZone['tAutStaRead'] == 1))  : ?>
                            <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?= language('common/main/main','tCMNActionEdit')?></th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody id="otbTCKLocZoneList">
                    <?php if(isset($aDataList['rtCode']) && $aDataList['rtCode'] == 1 ) : ?>
                        <?php foreach($aDataList['raItems'] AS $key=>$aValue) : ?>
                            <!-- <?php
                                // if($aValue['rtWahStaType'] == '1' || $aValue['rtWahRefCode'] != '' ){
                                //     $tDisableTD     = "xWTdDisable";
                                //     $tDisableImg    = "xWImgDisable";
                                //     $tDisableDeItem  = "disabled ";
                                // }else{ รอเช็ค chain จากเมนูตารางกิจกรรม
                                    $tDisableTD     = "";
                                    $tDisableImg    = "";
                                    $tDisableDeItem = "";
                                // }
                            ?> -->

                            <tr class="text-center xCNTextDetail2 otrTCKLocZone" id="otrTCKLocZone<?= $key ?>" 
                                data-znecode  = "<?= $aValue['FTZneCode']?>" 
                                data-znechain = "<?= $aValue['FTZneChain']?>"
                                data-znename  = "<?= $aValue['FTZneName']?>" >
                                <?php if($aAlwEventLocZone['tAutStaFull'] == 1 || $aAlwEventLocZone['tAutStaDelete'] == 1) : ?>
                                    <td class="text-center">
                                        <label class="fancy-checkbox">
                                            <input type="checkbox" class="ocbListItem" id="ocbTCKLocZoneListItem<?= $key ?>" name="ocbTCKLocZoneListItem[]" <?= $tDisableDeItem; ?>>
                                            <span>&nbsp;</span>
                                        </label>
                                    </td>
                                <?php endif; ?>
                                <td nowrap class="text-center"><?= FCNtHGetImagePageList($aValue['FTImgObj'],'70px'); ?></td>
                                <td nowrap class="text-left"><?= $aValue['FTZneCode'] ?></td>
                                <td nowrap class="text-left"><?= $aValue['FTZneName'] ?></td>
                                <td nowrap class="text-left"><?= !empty($aValue['FTLevName']) ? $aValue['FTLevName'] : '-' ; ?></td>
                                <td nowrap class="text-left"><?= !empty($aValue['FTGteName']) ? $aValue['FTGteName'] : '-' ; ?></td>
                                <td nowrap class="text-right"><?= ($aValue['FCZneCapacity'] != 0) ? number_format($aValue['FCZneCapacity'], 0, '.', ',') : '-' ; ?></td>
                                <td nowrap class="text-left"><?= ($aValue['FTZneStaUse'] == '1') ? language('ticketnew/ticketloczone/ticketloczone','tTCKLocZoneUse') : language('ticketnew/ticketloczone/ticketloczone','tTCKLocZoneNotUse'); ?></td>
                                <?php if($aAlwEventLocZone['tAutStaFull'] == 1 || $aAlwEventLocZone['tAutStaDelete'] == 1) : ?>
                                    <td class="text-center <?= $tDisableTD; ?>">
                                        <img class="xCNIconTable xCNIconDelete <?= $tDisableImg; ?>" id="oimBtnDelLocZone<?= $aValue['FTZneCode']?>" onClick="JSvTCKLocZoneDel('<?= $nCurrentPage?>', '<?= $aValue['FTZneChain']?>', '<?= $aValue['FTZneCode']?>', '<?= $aValue['FTZneName']?>', '<?= language('common/main/main', 'tBCHYesOnNo')?>')">
                                    </td>
                                <?php endif; ?>
                                <?php if($aAlwEventLocZone['tAutStaFull'] == 1 || ($aAlwEventLocZone['tAutStaEdit'] == 1 || $aAlwEventLocZone['tAutStaRead'] == 1)) : ?>
                                    <td class="text-center">
                                        <img class="xCNIconTable xCNIconEdit" onClick="JSvTCKLocZoneCallPageEdit('<?= $aValue['FTZneCode'] ?>')">
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
            <button onclick="JSvTCKLocZoneClickPage('previous')" class="btn btn-white btn-sm" <?= $tDisabledLeft ?>> 
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
                <button onclick="JSvTCKLocZoneClickPage('<?= $i?>')" type="button" class="btn xCNBTNNumPagenation <?= $tActive ?>" <?= $tDisPageNumber ?>><?= $i?></button>
            <?php endfor; ?>
            <!-- เปลี่ยนตัวแปร Onclick เป็นของ next -->
            <?php $tDisabledRight = ($nPage >= $aDataList['rnAllPage']) ? 'disabled' : '-'; ?>
            <button onclick="JSvTCKLocZoneClickPage('next')" class="btn btn-white btn-sm" <?= $tDisabledRight ?>>
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>

<!-- Model ยืนยันการลบข้อมูล 1 รายการ -->
<div class="modal fade" id="odvTCKLocZoneModalDelete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?= language('common/main/main', 'tModalDelete')?></label>
			</div>
            <div class="modal-body">
                <span id="ospTCKLocZoneConfirmDelete" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
                <input type='hidden' id="ohdTCKLocZoneConfirmIDDelete">
            </div>
            <div class="modal-footer">
                <button id="obtTCKLocZoneConfirmDelete" type="button" class="btn xCNBTNPrimery">
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
    // Select Mutiple delete
    $('.ocbListItem').click(function(){
        let tZnecode  = $(this).parent().parent().parent().data('znecode');
        let tZneChain = $(this).parent().parent().parent().data('znechain');
        let tZnename  = $(this).parent().parent().parent().data('znename');
        $(this).prop('checked', true);
        let LocalItemData = localStorage.getItem("LocalItemData");
        let obj = [];
        if(LocalItemData){
            obj = JSON.parse(LocalItemData);
        }
        let aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
        if(aArrayConvert == '' || aArrayConvert == null){
            obj.push({"tZnecode": tZnecode, "tZneChain": tZneChain , "tZnename": tZnename });
            localStorage.setItem("LocalItemData",JSON.stringify(obj));
            JSxTCKLocZoneTextinModal();
        }else{
            let aReturnRepeat = JSxTCKLocZonefindObjectByKey(aArrayConvert[0], 'tZnecode', tZnecode);
            if(aReturnRepeat == 'None'){ //ยังไม่ถูกเลือก
                obj.push({"tZnecode": tZnecode, "tZneChain": tZneChain , "tZnename": tZnename });
                localStorage.setItem("LocalItemData",JSON.stringify(obj));
                JSxTCKLocZoneTextinModal();
            }else if(aReturnRepeat == 'Dupilcate'){ //เคยเลือกไว้แล้ว
                localStorage.removeItem("LocalItemData");
                $(this).prop('checked', false);
                let nLength = aArrayConvert[0].length;
                for($i = 0; $i < nLength; $i++){
                    if(aArrayConvert[0][$i].tZnecode == tZnecode && aArrayConvert[0][$i].tZneChain == tZneChain ){
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
                JSxTCKLocZoneTextinModal(); 
            }
        }
        JSxTCKLocZoneShowButtonChoose(); 
    });
</script>