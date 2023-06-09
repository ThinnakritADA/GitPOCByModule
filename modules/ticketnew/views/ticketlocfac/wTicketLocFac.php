<input id="oetFacStaBrowse" type="hidden" value="<?=$nFacBrowseType?>">
<input id="oetFacCallBackOption" type="hidden" value="<?=$tFacBrowseOption?>">

<?php if (isset($nFacBrowseType) && $nFacBrowseType == 0) : ?>
<div id="odvFacMainMenu" class="main-menu"> <!-- เปลี่ยน -->
    <div class="xCNMrgNavMenu">
        <div class="row xCNavRow" style="width:inherit;">
            <div class="xCNFacVMaster">
                <div class="col-xs-12 col-md-8">
                    <ol id="oliMenuNav" class="breadcrumb"> <!-- เปลี่ยน -->
                        <?php FCNxHADDfavorite('ticketLocFac/0/0');?> 
                        <li id="oliFacTitle" class="xCNLinkClick" onclick="JSvCallPageFacList()" style="cursor:pointer"><?= language('ticketnew/ticketlocfac/ticketlocfac','tFACTitle')?></li> <!-- เปลี่ยน -->
                        <li id="oliFacTitleAdd" class="active"><a><?= language('ticketnew/ticketlocfac/ticketlocfac','tFACTitleAdd')?></a></li>
                        <li id="oliFacTitleEdit" class="active"><a><?= language('ticketnew/ticketlocfac/ticketlocfac','tFACTitleEdit')?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-4 text-right p-r-0"> <!-- เปลี่ยน -->
                    <div id="odvBtnFacInfo">
                        <button class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageFacAdd()">+</button>
                    </div>
                    <div id="odvBtnAddEdit">
                        <div class="demo-button xCNBtngroup" style="width:100%;">
                            <button onclick="JSvCallPageFacList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack')?></button>
                            <div class="btn-group">
								<button type="submit" class="btn xWBtnGrpSaveLeft" onclick="$('#obtSubmitFac').click()"> <?php echo language('common/main/main', 'tSave')?></button>
								<?php echo $vBtnSave?>
							</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="xCNFacVBrowse">
                <div class="col-xs-12 col-md-6">
                    <a onclick="JCNxBrowseData('<?php echo $tFacBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;font-size:19px;">
						<i class="fa fa-arrow-left xCNBackBowse"></i>	
					</a>
                    <ol id="oliPunNavBrowse" class="breadcrumb xCNBCMenu" style="margin-left:25px">
                        <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tFacBrowseOption?>')"><a><?php echo language('common/main/main','tShowData');?> : <?php echo language('ticketnew/ticketlocfac/ticketlocfac','tFACTitle')?></a></li>
                        <li class="active"><a><?php echo  language('ticketnew/ticketlocfac/ticketlocfac','tFACTitleAdd')?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-6 text-right">
                    <div id="odvPunBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                        <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitFac').click()"><?php echo  language('common/main/main', 'tSave')?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="xCNMenuCump xCNFacBrowseLine" id="odvMenuCump">
    &nbsp;
</div>
<div class="main-content">
    <div id="odvContentPageFac"></div>
</div>
<?php else : ?>
    <div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a onclick="JCNxBrowseData('<?php echo $tFacBrowseOption ?>')" class="xWBtnPrevious xCNIconBack" style="float:left;font-size:19px;">
                    <i class="fa fa-arrow-left xCNIcon"></i>
                </a>
                <ol id="oliPunNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tFacBrowseOption ?>')"><a><?php echo language('common/main/main', 'tShowData'); ?> : <?php echo language('ticketnew/ticketlocfac/ticketlocfac', 'tFACTitle') ?></a></li>
                    <li class="active"><a><?php echo  language('supplier/groupsupplier/groupsupplier', 'tSGPTitleAdd') ?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvPunBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitFac').click()"><?php echo language('common/main/main', 'tSave') ?></button>
                </div>
            </div>
        </div>
    </div>
    <div class="main-content">
        <div id="odvContentPageFac"></div>
    </div>
<?php endif; ?>

<script src="<?php echo base_url('application\modules\ticketnew\assets\src\ticketlocfac\jTicketLocFac.js')?>"></script>
