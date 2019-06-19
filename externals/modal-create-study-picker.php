<?php
include '../includes/language.php';
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"><?php echo $lang->pickStudyQuestion ?></h4>
</div>
<div id="modal-body" class="modal-body">
    <div class="container-fluid" style="padding: 0">
        <div class="row">
            <div class="col-xs-12 col-sm-6 text-center">
                <div class="panel panel-default btn-shadow btn-panel" id="btn-create-expert-based-study">
                    <div class="panel-heading">
                        <span class="title-text"><?php echo $lang->expertBasedStudyCreationHead ?></span>
                    </div>
                    <div class="panel-body" style="padding: 15px">
                        <?php echo $lang->expertBasedStudyCreation ?>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 text-center">
                <div class="panel panel-default btn-shadow btn-panel" id="btn-create-user-centered-study">
                    <div class="panel-heading">
                        <span class="title-text"><?php echo $lang->userCenteredStudyCreationHead ?></span>
                    </div>
                    <div class="panel-body" style="padding: 15px">
                        <?php echo $lang->userCenteredStudyCreation ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modal-footer" class="modal-footer">
    <button type="button" class="btn btn-default btn-shadow" data-dismiss="modal"><i class="fa fa-close"></i> <?php echo $lang->cancel ?></button>
</div>

<script>
    $(document).ready(function () {
        $('#btn-create-expert-based-study').unbind('click').bind('click', function (event) {
            event.preventDefault();
            gotoCreateExtractionStudy();
        });

        $('#btn-create-user-centered-study').click(function (event) {
            event.preventDefault();
            gotoCreateStudy();
        });
    });
</script>