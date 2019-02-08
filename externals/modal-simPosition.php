<?php
include '../includes/language.php';
?>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="modal-title"><?php echo $lang->modalsimposition->heading ?></h4>
</div>
<div class="modal-body">
	<div class="row" id="viewer_positionScreen">
		<div class="col-md-12">
			<div class="row">
				<div class="positionArea"></div>
			</div>
			<div class="row">
				<div class="col-md-4"></div>
				<div class="col-md-4">
					<div class="output"></div>
				</div>
				<div class="col-md-4"></div>
			</div>
			<input type="text" id="viewer_positionScreen_type" style="display: none;" value=""/>
		</div>
	</div>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $lang->modalsimposition->close ?></button>
</div>