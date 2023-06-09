<div class="panel-heading">
    <div class="row">
        <div class="col-xs-8 col-md-4 col-lg-4">
            <div class="form-group">
                <label class="xCNLabelFrm"><?= language('ticketnew/tickettimetable/tickettimetable','tTCKTimeTbSearch')?></label>
                <div class="input-group">
					<input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetTCKTimeTbSearchAll" name="oetTCKTimeTbSearchAll" placeholder="<?= language('common/main/main','tPlaceholder')?>">
                    <span class="input-group-btn">
                        <button class="btn xCNBtnSearch" type="button" onclick="JSvTCKTimeTbCallPageDataTable()">
                            <img class="xCNIconAddOn" src="<?= base_url().'/application/modules/common/assets/images/icons/search-24.png' ?>">
                        </button>
                    </span>
                </div>
            </div>
        </div>
        <?php if($aAlwEventTimeTb['tAutStaFull'] == 1 || $aAlwEventTimeTb['tAutStaDelete'] == 1 ) : ?>
            <div class="col-xs-4 col-md-8 col-lg-8 text-right" style="margin-top:34px;">
                <div id="odvTCKTimeTbMngTableList" class="btn-group xCNDropDrownGroup">
                    <button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
                        <?= language('common/main/main','tCMNOption')?>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li id="oliTCKTimeTbBtnDeleteAll" class="disabled">
                            <a data-toggle="modal" data-target="#odvTCKTimeTbModalDeleteMultiple"><?= language('common/main/main','tDelAll')?></a>
                        </li>
                    </ul>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="panel-body">
	<section id="ostTCKTimeTbDataTimeTb"></section>
</div>

<input type="hidden" name="ohdDeleteChooseconfirm" id="ohdDeleteChooseconfirm" value="<?= language('common/main/main', 'tModalConfirmDeleteItemsAll') ?>">

<!-- ==================================================== Modal Delete Multiple ==================================================== -->
<div id="odvTCKTimeTbModalDeleteMultiple" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?= language('common/main/main', 'tModalDelete')?></label>
            </div>
            <div class="modal-body">
                <span id="ospTCKTimeTbConfirmDelMultiple" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
                <input type='hidden' id="ohdTCKTimeTbConfirmIDDelMultiple">
            </div>
            <div class="modal-footer">
                <button id="obtTCKTimeTbConfirmDelMultiple" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"><?= language('common/main/main', 'tModalConfirm')?></button>
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
    $('#odvTCKTimeTbModalDeleteMultiple #obtTCKTimeTbConfirmDelMultiple').off().on('click', function(){
        JSoTCKTimeTbDeleteMultiple();
    });    
</script>

