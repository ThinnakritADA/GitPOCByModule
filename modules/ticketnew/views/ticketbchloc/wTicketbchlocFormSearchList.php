<div class="panel-heading">
    <div class="row">
        <div class="col-xs-8 col-md-4 col-lg-4">
            <div class="form-group">
                <label class="xCNLabelFrm"><?= language('ticketnew/ticketbchloc/ticketbchloc','tTCKBchLocSearch')?></label>
                <div class="input-group">
					<input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetTCKBchLocSearchAll" name="oetTCKBchLocSearchAll" placeholder="<?php echo language('common/main/main','tPlaceholder')?>">
                    <span class="input-group-btn">
                        <button class="btn xCNBtnSearch" type="button" onclick="JSvTCKBchLocCallPageBchLocDataTable()">
                            <img class="xCNIconAddOn" src="<?= base_url().'/application/modules/common/assets/images/icons/search-24.png' ?>">
                        </button>
                    </span>
                </div>
            </div>
        </div>
        <?php if($aAlwEventBchLoc['tAutStaFull'] == 1 || $aAlwEventBchLoc['tAutStaDelete'] == 1 ) : ?>
            <div class="col-xs-4 col-md-8 col-lg-8 text-right" style="margin-top:34px;">
                <div id="odvTCKBchLocMngTableList" class="btn-group xCNDropDrownGroup">
                    <button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
                        <?= language('common/main/main','tCMNOption')?>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li id="oliTCKBchLocBtnDeleteAll" class="disabled">
                            <a data-toggle="modal" data-target="#odvTCKBchLocModalDeleteMultiple"><?= language('common/main/main','tDelAll')?></a>
                        </li>
                    </ul>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="panel-body">
	<section id="ostTCKBchLocDataBchLoc"></section>
</div>

<input type="hidden" name="ohdDeleteChooseconfirm" id="ohdDeleteChooseconfirm" value="<?= language('common/main/main', 'tModalConfirmDeleteItemsAll') ?>">

<!-- ==================================================== Modal Delete Multiple ==================================================== -->
<div id="odvTCKBchLocModalDeleteMultiple" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?= language('common/main/main', 'tModalDelete')?></label>
            </div>
            <div class="modal-body">
                <span id="ospTCKBchLocConfirmDelMultiple" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
                <input type='hidden' id="ohdTCKBchLocConfirmIDDelMultiple">
            </div>
            <div class="modal-footer">
                <button id="obtTCKBchLocConfirmDelMultiple" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"><?= language('common/main/main', 'tModalConfirm')?></button>
                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal"><?= language('common/main/main', 'tModalCancel')?></button>
            </div>
        </div>
    </div>
</div>
<!-- ===================================================== End Delete Multiple ===================================================== -->

<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>

<script type="text/javascript">
    // Click Confirm Delete Multiple
    $('#odvTCKBchLocModalDeleteMultiple #obtTCKBchLocConfirmDelMultiple').off().on('click', function(){
        JSvTCKBchLocDeleteMultiple();
    });
    // On Keyup Search
    $('#oetTCKBchLocSearchAll').on('keyup', function(e){
        if(e.keyCode == 13){
            e.preventDefault();
            JSvTCKBchLocCallPageBchLocDataTable();
        }
    });
</script>