<input type="hidden" id="ohdTCKTimeTbBrowseType" value="<?= $nTimeTbBrowseType ?>"/>
<input type="hidden" id="ohdTCKTimeTbBrowseOption" value="<?= $nTimeTbBrowseOption ?>"/>

<?php if(isset($nTimeTbBrowseType) && $nTimeTbBrowseType == 0) : ?>
    <div id="odvTCKTimeTbMainMenu" class="main-menu">
        <div class="xCNMrgNavMenu">
            <div class="row xCNavRow" style="width:inherit;">
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                    <ol id="oliTCKTimeTbMenuNav" class="breadcrumb">
                        <?php FCNxHADDfavorite('ticketTimeTable/0/0');?> 
                        <li id="oliTCKTimeTbTitle" class="xCNLinkClick" onclick="JSvTCKTimeTbCallPageList()" style="cursor:pointer"><?= language('ticketnew/tickettimetable/tickettimetable','tTCKTimeTbTitle') ?></li>
                        <li id="oliTCKTimeTbTitleAdd" class="active"><a><?= language('ticketnew/tickettimetable/tickettimetable','tTCKTimeTbTitleAdd') ?></a></li>
                        <li id="oliTCKTimeTbTitleEdit" class="active"><a><?= language('ticketnew/tickettimetable/tickettimetable','tTCKTimeTbTitleEdit') ?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right p-r-0">
                    <div id="odvTCKTimeTbBtnEditInfo">
                        <button id="obtTCKTimeTbBtnBack" class="btn btn-default xCNBTNDefult" type="submit" onclick="JSvTCKTimeTbCallPageList()"><?= language('common/main/main', 'tBack') ?></button>
                        <?php if($aAlwEventTimeTb['tAutStaFull'] == 1 || ($aAlwEventTimeTb['tAutStaAdd'] == 1 || $aAlwEventTimeTb['tAutStaEdit'] == 1)) : ?>
                            <div class="btn-group">
                                <button class="btn btn-default xWBtnGrpSaveLeft" type="submit" onclick="$('#obtTCKTimeTbBtnSubmit').click();"> <?= language('common/main/main', 'tSave')?></button>
                                <?= $vTimeTbBtnSave; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div id="odvTCKTimeTbBtnInfo">
                        <?php if($aAlwEventTimeTb['tAutStaFull'] == 1 || $aAlwEventTimeTb['tAutStaAdd'] == 1) : ?>
                            <button class="xCNBTNPrimeryPlus" type="button" onclick="JSvTCKTimeTbCallPageAdd()">+</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="xCNMenuCump xCNTCKTimeTbBrowseLine" id="odvMenuCump">
        &nbsp;
    </div>
    <div class="main-content">
		<div id="odvContentPageTCKTimeTb" class="panel panel-headline"></div>
	</div>
    <input type="hidden" name="ohdTCKTimeTbDelChooseconf" id="ohdTCKTimeTbDelChooseconf" value="<?= language('common/main/main', 'tModalConfirmDeleteItemsAll') ?>">
<?php else: ?>
    <div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a onclick="JCNxBrowseData('<?= $nTimeTbBrowseOption ?>')" class="xWBtnPrevious xCNIconBack" style="float:left;">
                    <i class="fa fa-arrow-left xCNIcon"></i>	
                </a>
                <ol id="oliTCKTimeTbNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?= $nTimeTbBrowseOption?> ')"><a><?= language('common/main/main', 'tShowData')?> : <?= language('ticketnew/tickettimetable/tickettimetable','tTCKTimeTbTitle')?></a></li>
                    <li class="active"><a><?= language('ticketnew/tickettimetable/tickettimetable','tTCKTimeTbTitleAdd')  ?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvTCKTimeTbBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtTCKTimeTbBtnSubmit').click()"><?= language('common/main/main', 'tSave')?></button>
                </div>
            </div>
        </div>
    </div>
    <div id="odvTCKTimeTbModalBodyBrowse" class="modal-body xCNModalBodyAdd">
    </div>
<?php endif; ?>
<script type="text/javascript" src="<?= base_url('application/modules/ticketnew/assets/src/tickettimetable/jTickettimetable.js'); ?>"></script>
