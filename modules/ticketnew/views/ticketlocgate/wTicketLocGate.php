<input id="oetGteStaBrowse" type="hidden" value="<?=$nGteBrowseType?>">
<input id="oetGteCallBackOption" type="hidden" value="<?=$tGteBrowseOption?>">

<?php if (isset($nGteBrowseType) && $nGteBrowseType == 0) : ?>
<div id="odvGteMainMenu" class="main-menu"> <!-- เปลี่ยน -->
    <div class="xCNMrgNavMenu">
        <div class="row xCNavRow" style="width:inherit;">
            <div class="xCNGteVMaster">
                <div class="col-xs-12 col-md-8">
                    <ol id="oliMenuNav" class="breadcrumb"> <!-- เปลี่ยน -->
                        <?php FCNxHADDfavorite('ticketLocGte/0/0');?> 
                        <li id="oliGteTitle" class="xCNLinkClick" onclick="JSvCallPageGteList()" style="cursor:pointer"><?= language('ticketnew/ticketlocgate/ticketlocgate','tLEVTitle')?></li> <!-- เปลี่ยน -->
                        <li id="oliGteTitleAdd" class="active"><a><?= language('ticketnew/ticketlocgate/ticketlocgate','tLEVTitleAdd')?></a></li>
                        <li id="oliGteTitleEdit" class="active"><a><?= language('ticketnew/ticketlocgate/ticketlocgate','tLEVTitleEdit')?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-4 text-right p-r-0"> <!-- เปลี่ยน -->
                    <div id="odvBtnGteInfo">
                        <button class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageGteAdd()">+</button>
                    </div>
                    <div id="odvBtnAddEdit">
                        <div class="demo-button xCNBtngroup" style="width:100%;">
                            <button onclick="JSvCallPageGteList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack')?></button>
                            <div class="btn-group">
								<button type="submit" class="btn xWBtnGrpSaveLeft" onclick="$('#obtSubmitGte').click()"> <?php echo language('common/main/main', 'tSave')?></button>
								<?php echo $vBtnSave?>
							</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="xCNGteVBrowse">
                <div class="col-xs-12 col-md-6">
                    <a onclick="JCNxBrowseData('<?php echo $tGteBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;font-size:19px;">
						<i class="fa fa-arrow-left xCNBackBowse"></i>	
					</a>
                    <ol id="oliPunNavBrowse" class="breadcrumb xCNBCMenu" style="margin-left:25px">
                        <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tGteBrowseOption?>')"><a><?php echo language('common/main/main','tShowData');?> : <?php echo language('ticketnew/ticketlocgate/ticketlocgate','tLEVTitle')?></a></li>
                        <li class="active"><a><?php echo  language('ticketnew/ticketlocgate/ticketlocgate','tLEVTitleAdd')?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-6 text-right">
                    <div id="odvPunBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                        <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitGte').click()"><?php echo  language('common/main/main', 'tSave')?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="xCNMenuCump xCNGteBrowseLine" id="odvMenuCump">
    &nbsp;
</div>
<div class="main-content">
    <div id="odvContentPageGte"></div>
</div>
<?php else : ?>
    <div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a onclick="JCNxBrowseData('<?php echo $tGteBrowseOption ?>')" class="xWBtnPrevious xCNIconBack" style="float:left;font-size:19px;">
                    <i class="fa fa-arrow-left xCNIcon"></i>
                </a>
                <ol id="oliPunNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tGteBrowseOption ?>')"><a><?php echo language('common/main/main', 'tShowData'); ?> : <?php echo language('ticketnew/ticketlocgate/ticketlocgate', 'tLEVTitle') ?></a></li>
                    <li class="active"><a><?php echo  language('supplier/groupsupplier/groupsupplier', 'tSGPTitleAdd') ?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvPunBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitGte').click()"><?php echo language('common/main/main', 'tSave') ?></button>
                </div>
            </div>
        </div>
    </div>
    <div class="main-content">
        <div id="odvContentPageGte"></div>
    </div>
<?php endif; ?>

<script src="<?php echo base_url('application\modules\ticketnew\assets\src\ticketlocgate\jTicketLocGate.js')?>"></script>
