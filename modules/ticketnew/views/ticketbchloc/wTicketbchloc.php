<input type="hidden" id="ohdTCKBchLocBrowseType" value="<?= $nBchLocBrowseType ?>"/>
<input type="hidden" id="ohdTCKBchLocBrowseOption" value="<?= $tBchLocBrowseOption ?>"/>

<?php if(isset($nBchLocBrowseType) && $nBchLocBrowseType == 0) : ?>
    <div id="odvTCKBchLocMainMenu" class="main-menu">
        <div class="xCNMrgNavMenu">
            <div class="row xCNavRow" style="width:inherit;">
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                    <ol id="oliMenuNav" class="breadcrumb">
                        <?php FCNxHADDfavorite('ticketBchLocation/0/0');?> 
						<li id="oliTCKBchLocTitle" class="xCNLinkClick" onclick="JSvTCKBchLocCallPageBchLocList()" style="cursor:pointer"><?= language('ticketnew/ticketbchloc/ticketbchloc','tTCKBchLocTitle') ?></li>
                        <li id="oliTCKBchLocTitleAdd" class="active"><a><?= language('ticketnew/ticketbchloc/ticketbchloc','tTCKBchLocTitleAdd') ?></a></li>
                        <li id="oliTCKBchLocTitleEdit" class="active"><a><?= language('ticketnew/ticketbchloc/ticketbchloc','tTCKBchLocTitleEdit') ?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right p-r-0">
                    <div id="odvTCKBchLocBtnEditInfo">
                        <button id="obtTCKBchLocBtnBack" class="btn btn-default xCNBTNDefult" type="submit" onclick="JSvTCKBchLocCallPageBchLocList()"><?= language('common/main/main', 'tBack') ?></button>
                        <?php if($aAlwEventBchLoc['tAutStaFull'] == 1 || ($aAlwEventBchLoc['tAutStaAdd'] == 1 || $aAlwEventBchLoc['tAutStaEdit'] == 1)) : ?>
                            <div class="btn-group">
                                <button class="btn btn-default xWBtnGrpSaveLeft" type="submit" onclick="$('#obtTCKBchLocBtnSubmit').click();"> <?= language('common/main/main', 'tSave')?></button>
                                <?= $vBtnSave; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div id="odvTCKBchLocBtnInfo">
                        <?php if($aAlwEventBchLoc['tAutStaFull'] == 1 || $aAlwEventBchLoc['tAutStaAdd'] == 1) : ?>
                            <button class="xCNBTNPrimeryPlus" type="button" onclick="JSvTCKBchLocCallPageBchLocAdd()">+</button>
                        <?php endif; ?>
                    </div>    
                </div>
            </div>
        </div>
    </div>
    <div class="xCNMenuCump xCNTCKBchLocBrowseLine" id="odvMenuCump">
        &nbsp;
    </div>
    <div class="main-content">
		<div id="odvContentPageTCKBchLoc" class="panel panel-headline"></div>
	</div>
	<input type="hidden" name="ohdTCKBchLocDelChooseconf" id="ohdTCKBchLocDelChooseconf" value="<?= language('common/main/main', 'tModalConfirmDeleteItemsAll') ?>">

<?php else: ?>
    <div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a onclick="JCNxBrowseData('<?= $tBchLocBrowseOption ?>')" class="xWBtnPrevious xCNIconBack" style="float:left;">
                    <i class="fa fa-arrow-left xCNIcon"></i>	
                </a>
                <ol id="oliTCKBchLocNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?= $tBchLocBrowseOption?> ')"><a><?= language('common/main/main', 'tShowData')?> : <?= language('ticketnew/ticketbchloc/ticketbchloc','tTCKBchLocTitle')?></a></li>
                    <li class="active"><a><?= language('ticketnew/ticketbchloc/ticketbchloc','tTCKBchLocTitleAdd')?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvTCKBchLocBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtTCKBchLocBtnSubmit').click()"><?= language('common/main/main', 'tSave')?></button>
                </div>
            </div>
        </div>
    </div>
    <div id="odvTCKBchLocModalBodyBrowse" class="modal-body xCNModalBodyAdd">
    </div>
<?php endif; ?>
<script type="text/javascript" src="<?= base_url('application/modules/ticketnew/assets/src/ticketbchloc/jTicketbchloc.js'); ?>"></script>