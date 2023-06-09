<div class="panel panel-headline">
	<div class="panel-heading">
		<div class="row">
			<div class="col-lg-6 col-md-6 col-xs-12 col-sm-8">
				<div class="form-group">
					<label class="xCNLabelFrm"><?php echo language('ticketnew/ticketlocgate/ticketlocgate','tLEVSearch')?></label>
					<div class="input-group">
						<input type="text" class="form-control" id="oetSearchGte" name="oetSearchGte" placeholder="<?php echo language('ticketnew/ticketlocgate/ticketlocgate','tLEVSearchData')?>">
						<span class="input-group-btn">
							<button id="oimSearchGte" class="btn xCNBtnSearch" type="button">
								<img class="xCNIconAddOn" src="<?php echo base_url().'/application/modules/common/assets/images/icons/search-24.png'?>">
							</button>
						</span>
					</div>
				</div>
			</div>
			<div class="col-lg-6 col-md-6 col-xs-12 col-sm-4 text-right">
				<div class="form-group"> 
					<label class="xCNLabelFrm hidden-xs"></label>
					<div >
						<div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
							<button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
								<?php echo language('common/main/main','tCMNOption')?>
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu" role="menu">
								<li id="oliBtnDeleteAll" class="disabled">
									<a data-toggle="modal" data-target="#odvModalDelGte"><?php echo language('common/main/main','tDelAll')?></a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="panel-body">
		<section id="ostDataGte"></section>
	</div>
</div>
<input type="hidden" name="ohdDeleteChooseconfirm" id="ohdDeleteChooseconfirm" value="<?php echo language('common/main/main', 'tModalConfirmDeleteItemsAll') ?>">
<input type="hidden" name="ohdDeleteconfirm" id="ohdDeleteconfirm" value="<?php echo language('common/main/main', 'tModalConfirmDeleteItems') ?>">
<input type="hidden" name="ohdDeleteconfirmYN" id="ohdDeleteconfirmYN" value="<?php echo language('common/main/main', 'tModalConfirmDeleteItemsYN') ?>">

<div class="modal fade" id="odvModalDelGte">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="xCNHeardModal modal-title" style="display:inline-block"><?php echo language('common/main/main', 'tModalDelete')?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<span id="ospConfirmDelete" class="xCNTextModal"> - </span>
				<input type='hidden' id="ospConfirmIDDelete">
			</div>
			<div class="modal-footer">
				<!-- แก้ -->
				<button id="osmConfirm" onClick="JSoGteDelChoose()" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button">
					<?php echo language('common/main/main', 'tModalConfirm')?>
				</button>
				<!-- แก้ -->
				<button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal">
					<?php echo language('common/main/main', 'tModalCancel')?>
				</button>
			</div>
		</div>
	</div>
</div>

<script>
	$('#oimSearchGte').click(function(){
		JCNxOpenLoading();
		JSvGteDataTable();
	});
	$('#oetSearchGte').keypress(function(event){
		if(event.keyCode == 13){
			JCNxOpenLoading();
			JSvGteDataTable();
		}
	});
</script>
