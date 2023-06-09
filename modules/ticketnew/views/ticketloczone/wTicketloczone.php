<input type="hidden" id="ohdTCKLocZoneBrowseType" value="<?= $nLocZoneBrowseType ?>"/>
<input type="hidden" id="ohdTCKLocZoneBrowseOption" value="<?= $nLocZoneBrowseOption ?>"/>

<?php if(isset($nLocZoneBrowseType) && $nLocZoneBrowseType == 0) : ?>
    <div id="odvTCKLocZoneMainMenu" class="main-menu">
        <div class="xCNMrgNavMenu">
            <div class="row xCNavRow" style="width:inherit;">
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                    <ol id="oliTCKLocZoneMenuNav" class="breadcrumb">
                        <?php FCNxHADDfavorite('ticketLocZone/0/0');?> 
                        <li id="oliTCKLocZoneTitle" class="xCNLinkClick" onclick="JSvTCKLocZoneCallPageList()" style="cursor:pointer"><?= language('ticketnew/ticketloczone/ticketloczone','tTCKLocZoneTitle') ?></li>
                        <li id="oliTCKLocZoneTitleAdd" class="active"><a><?= language('ticketnew/ticketloczone/ticketloczone','tTCKLocZoneTitleAdd') ?></a></li>
                        <li id="oliTCKLocZoneTitleEdit" class="active"><a><?= language('ticketnew/ticketloczone/ticketloczone','tTCKLocZoneTitleEdit') ?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right p-r-0">
                    <div id="odvTCKLocZoneBtnEditInfo">
                        <button id="obtTCKLocZoneBtnBack" class="btn btn-default xCNBTNDefult" type="submit" onclick="JSvTCKLocZoneCallPageList()"><?= language('common/main/main', 'tBack') ?></button>
                        <?php if($aAlwEventLocZone['tAutStaFull'] == 1 || ($aAlwEventLocZone['tAutStaAdd'] == 1 || $aAlwEventLocZone['tAutStaEdit'] == 1)) : ?>
                            <div class="btn-group">
                                <button class="btn btn-default xWBtnGrpSaveLeft" type="submit" onclick="$('#obtTCKLocZoneBtnSubmit').click();"> <?= language('common/main/main', 'tSave')?></button>
                                <?= $vLocZoneBtnSave; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div id="odvTCKLocZoneBtnInfo">
                        <?php if($aAlwEventLocZone['tAutStaFull'] == 1 || $aAlwEventLocZone['tAutStaAdd'] == 1) : ?>
                            <button class="xCNBTNPrimeryPlus" type="button" onclick="JSvTCKLocZoneCallPageAdd()">+</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="xCNMenuCump xCNTCKLocZoneBrowseLine" id="odvMenuCump">
        &nbsp;
    </div>
    <div class="main-content">
		<div id="odvContentPageTCKLocZone" class="panel panel-headline"></div>
	</div>
    <input type="hidden" name="ohdTCKLocZoneDelChooseconf" id="ohdTCKLocZoneDelChooseconf" value="<?= language('common/main/main', 'tModalConfirmDeleteItemsAll') ?>">
<?php else: ?>
    <div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a onclick="JCNxBrowseData('<?= $nLocZoneBrowseOption ?>')" class="xWBtnPrevious xCNIconBack" style="float:left;">
                    <i class="fa fa-arrow-left xCNIcon"></i>	
                </a>
                <ol id="oliTCKLocZoneNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?= $nLocZoneBrowseOption?> ')"><a><?= language('common/main/main', 'tShowData')?> : <?= language('ticketnew/ticketloczone/ticketloczone','tTCKLocZoneTitle')?></a></li>
                    <li class="active"><a><?= language('ticketnew/ticketloczone/ticketloczone','tTCKLocZoneTitleAdd')  ?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvTCKLocZoneBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtTCKLocZoneBtnSubmit').click()"><?= language('common/main/main', 'tSave')?></button>
                </div>
            </div>
        </div>
    </div>
    <div id="odvTCKLocZoneModalBodyBrowse" class="modal-body xCNModalBodyAdd">
    </div>
<?php endif; ?>
<script type="text/javascript" src="<?= base_url('application/modules/ticketnew/assets/src/ticketloczone/jTicketloczone.js'); ?>"></script>
