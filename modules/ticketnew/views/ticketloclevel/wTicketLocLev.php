<input id="oetLevStaBrowse" type="hidden" value="<?=$nLevBrowseType?>">
<input id="oetLevCallBackOption" type="hidden" value="<?=$tLevBrowseOption?>">

<?php if (isset($nLevBrowseType) && $nLevBrowseType == 0) : ?>
<div id="odvLevMainMenu" class="main-menu"> <!-- เปลี่ยน -->
    <div class="xCNMrgNavMenu">
        <div class="row xCNavRow" style="width:inherit;">
            <div class="xCNLevVMaster">
                <div class="col-xs-12 col-md-8">
                    <ol id="oliMenuNav" class="breadcrumb"> <!-- เปลี่ยน -->
                        <?php FCNxHADDfavorite('ticketLocLev/0/0');?> 
                        <li id="oliLevTitle" class="xCNLinkClick" onclick="JSvCallPageLevList()" style="cursor:pointer"><?= language('ticketnew/ticketloclevel/ticketloclevel','tLEVTitle')?></li> <!-- เปลี่ยน -->
                        <li id="oliLevTitleAdd" class="active"><a><?= language('ticketnew/ticketloclevel/ticketloclevel','tLEVTitleAdd')?></a></li>
                        <li id="oliLevTitleEdit" class="active"><a><?= language('ticketnew/ticketloclevel/ticketloclevel','tLEVTitleEdit')?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-4 text-right p-r-0"> <!-- เปลี่ยน -->
                    <div id="odvBtnLevInfo">
                        <button class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageLevAdd()">+</button>
                    </div>
                    <div id="odvBtnAddEdit">
                        <div class="demo-button xCNBtngroup" style="width:100%;">
                            <button onclick="JSvCallPageLevList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack')?></button>
                            <div class="btn-group">
								<button type="submit" class="btn xWBtnGrpSaveLeft" onclick="$('#obtSubmitLev').click()"> <?php echo language('common/main/main', 'tSave')?></button>
								<?php echo $vBtnSave?>
							</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="xCNLevVBrowse">
                <div class="col-xs-12 col-md-6">
                    <a onclick="JCNxBrowseData('<?php echo $tLevBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;font-size:19px;">
						<i class="fa fa-arrow-left xCNBackBowse"></i>	
					</a>
                    <ol id="oliPunNavBrowse" class="breadcrumb xCNBCMenu" style="margin-left:25px">
                        <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tLevBrowseOption?>')"><a><?php echo language('common/main/main','tShowData');?> : <?php echo language('ticketnew/ticketloclevel/ticketloclevel','tLEVTitle')?></a></li>
                        <li class="active"><a><?php echo  language('ticketnew/ticketloclevel/ticketloclevel','tLEVTitleAdd')?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-6 text-right">
                    <div id="odvPunBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                        <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitLev').click()"><?php echo  language('common/main/main', 'tSave')?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="xCNMenuCump xCNLevBrowseLine" id="odvMenuCump">
    &nbsp;
</div>
<div class="main-content">
    <div id="odvContentPageLev"></div>
</div>
<?php else : ?>
    <div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a onclick="JCNxBrowseData('<?php echo $tLevBrowseOption ?>')" class="xWBtnPrevious xCNIconBack" style="float:left;font-size:19px;">
                    <i class="fa fa-arrow-left xCNIcon"></i>
                </a>
                <ol id="oliPunNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tLevBrowseOption ?>')"><a><?php echo language('common/main/main', 'tShowData'); ?> : <?php echo language('ticketnew/ticketloclevel/ticketloclevel', 'tLEVTitle') ?></a></li>
                    <li class="active"><a><?php echo  language('supplier/groupsupplier/groupsupplier', 'tSGPTitleAdd') ?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvPunBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitLev').click()"><?php echo language('common/main/main', 'tSave') ?></button>
                </div>
            </div>
        </div>
    </div>
    <div class="main-content">
        <div id="odvContentPageLev"></div>
    </div>
<?php endif; ?>

<script src="<?php echo base_url('application\modules\ticketnew\assets\src\ticketloclevel\jTicketLocLevel.js')?>"></script>
