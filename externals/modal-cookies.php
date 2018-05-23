<?php
include '../includes/language.php';
?>

<div id="modal-body" class="modal-body">
    <div class="text-center text">
        <p>
            <?php echo $lang->cookieHint ?>
        </p>
    </div>

    <div class="btn-group btn-group-justified">
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-default btn-shadow" id="btn-no" data-dismiss="modal"><i class="fa fa-info-circle"></i> <?php echo $lang->moreInfos ?></button>
        </div>
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-default btn-shadow" id="btn-yes" data-dismiss="modal"><i class="fa fa-check"></i> <?php echo $lang->acceptCookies ?></button>
        </div>

    </div>
</div>

<script>
    $(document).ready(function () {
        $('#btn-yes').unbind('click').bind('click', function (event) {
            event.preventDefault();
            $('#custom-modal').trigger('acceptCookies');
            $('#custom-modal').modal('hide');
        });

        $('#btn-no').click(function (event) {
            event.preventDefault();
            $('#custom-modal').trigger('moreInfos');
            $('#custom-modal').modal('hide');
        });
    });
</script>