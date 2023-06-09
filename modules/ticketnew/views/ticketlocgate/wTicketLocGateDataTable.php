<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table id="otbGteDataList" class="table table-striped"> <!-- เปลี่ยน -->
                <thead>
                    <tr>
                        <th class="text-center xCNTextBold" style="width:10%;"><?= language('ticketnew/ticketlocgate/ticketlocgate','tLEVChoose')?></th>
                        <th class="text-center xCNTextBold" style="width:15%;"><?= language('ticketnew/ticketlocgate/ticketlocgate','tLEVCode')?></th>
                        <th class="text-center xCNTextBold" style="width:30%;"><?= language('ticketnew/ticketlocgate/ticketlocgate','tLEVName')?></th>
                        <th class="text-center xCNTextBold" style="width:10%;"><?= language('ticketnew/ticketlocgate/ticketlocgate','tLEVDelete')?></th>
                        <th class="text-center xCNTextBold" style="width:10%;"><?= language('ticketnew/ticketlocgate/ticketlocgate','tLEVEdit')?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($aGateDataList['rtCode'] == 1 ):?>
                        <?php foreach($aGateDataList['raItems'] AS $nKey => $aValue):?>
                            <tr class="text-left xCNTextDetail2 otrGte" id="otrGte<?=$nKey?>" data-code="<?=$aValue['rtGteCode']?>" data-name="<?=$aValue['rtGteName']?>">
                            <?php
                                      $tDisableTD     = "";
                                      $tDisableImg    = "";
                                      $tDisabledItem  = "";
                                      $tDisabledItem2  = " ";
                                      $tDisabledcheckrow  = "false";
                              ?>
                                <td class="text-center">
                                    <label class="fancy-checkbox">
                                        <input id="ocbListItem<?=$nKey?>" type="checkbox" class="ocbListItem"  <?php echo $tDisabledItem; ?> name="ocbListItem[]">
                                        <span class="<?php echo $tDisabledItem2; ?>">&nbsp;</span>
                                    </label>
                                </td>
                                <td><?=$aValue['rtGteCode']?></td>
                                <td class="text-left"><?=$aValue['rtGteName']?></td>
                                <td class="text-center <?=$tDisableTD?>">
                                    <!-- เปลี่ยน -->
                                    <img class="xCNIconTable <?php echo $tDisableImg; ?>" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>" onClick="JSoGteDel('<?php echo $aValue['rtGteCode']?>','<?php echo $aValue['rtGteName']?>')">
                                </td>
                                <td class="text-center">
                                    <!-- เปลี่ยน -->
                                    <img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onClick="JSvCallPageGteEdit('<?php echo $aValue['rtGteCode']?>')">
                                </td>
                            </tr>
                        <?php endforeach;?>
                    <?php else:?>
                        <tr><td class='text-center xCNTextDetail2' colspan='5'><?= language('ticketnew/ticketlocgate/ticketlocgate','tLEVNoData')?></td></tr>
                    <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <!-- เปลี่ยน -->
    <div class="col-md-6">
        <p><?= language('common/main/main','tResultTotalRecord')?> <?=$aGateDataList['rnAllRow']?> <?= language('common/main/main','tRecord')?> <?= language('common/main/main','tCurrentPage')?> <?=$aGateDataList['rnCurrentPage']?> / <?=$aGateDataList['rnAllPage']?></p>
    </div>
    <!-- เปลี่ยน -->
    <div class="col-md-6">
        <div class="xWPageGte btn-toolbar pull-right"> <!-- เปลี่ยนชื่อ Class เป็นของเรื่องนั้นๆ --> 
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvGteClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <?php for($i=max($nPage-2, 1); $i<=max(0, min($aGateDataList['rnAllPage'],$nPage+2)); $i++){?> <!-- เปลี่ยนชื่อ Parameter Loop เป็นของเรื่องนั้นๆ --> 
                <?php 
                    if($nPage == $i){ 
                        $tActive = 'active'; 
                        $tDisPageNumber = 'disabled';
                    }else{ 
                        $tActive = '';
                        $tDisPageNumber = '';
                    }
                ?>
                <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <button onclick="JSvGteClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aGateDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvGteClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('.ocbListItem').click(function(){
        var nCode = $(this).parent().parent().parent().data('code');  //code
        var tName = $(this).parent().parent().parent().data('name');  //code
        $(this).prop('checked', true);
        var LocalItemData = localStorage.getItem("LocalItemData");
        var obj = [];
        if(LocalItemData){
            obj = JSON.parse(LocalItemData);
        }else{ }
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
        if(aArrayConvert == '' || aArrayConvert == null){
            obj.push({"nCode": nCode, "tName": tName });
            localStorage.setItem("LocalItemData",JSON.stringify(obj));
            JSxTextinModal();
        }else{
            var aReturnRepeat = findObjectByKey(aArrayConvert[0],'nCode',nCode);
            if(aReturnRepeat == 'None' ){           //ยังไม่ถูกเลือก
                obj.push({"nCode": nCode, "tName": tName });
                localStorage.setItem("LocalItemData",JSON.stringify(obj));
                JSxTextinModal();
            }else if(aReturnRepeat == 'Dupilcate'){	//เคยเลือกไว้แล้ว
                localStorage.removeItem("LocalItemData");
                $(this).prop('checked', false);
                var nLength = aArrayConvert[0].length;
                for($i=0; $i<nLength; $i++){
                    if(aArrayConvert[0][$i].nCode == nCode){
                        delete aArrayConvert[0][$i];
                    }
                }
                var aNewarraydata = [];
                for($i=0; $i<nLength; $i++){
                    if(aArrayConvert[0][$i] != undefined){
                        aNewarraydata.push(aArrayConvert[0][$i]);
                    }
                }
                localStorage.setItem("LocalItemData",JSON.stringify(aNewarraydata));
                JSxTextinModal();
            }
        }
        JSxShowButtonChoose();
    })
</script>