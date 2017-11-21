<?php
include 'includes/language.php';
session_start();
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"><i class="fa fa-support"></i> <?php echo $lang->help ?></h4>
</div>
<div id="modal-body" class="modal-body" style="padding: 0">
    <div id="carousel-introduction-generic" class="carousel slide" data-ride="carousel" data-interval="false" data-wrap="false">
        <!-- Positionsanzeiger -->
        <ol class="carousel-indicators"></ol>

        <!-- Verpackung für die Elemente -->
        <div class="carousel-inner" role="listbox"></div>

        <!-- Schalter -->
        <a class="left carousel-control" href="#carousel-introduction-generic" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Zurück</span>
        </a>
        <a class="right carousel-control" href="#carousel-introduction-generic" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Weiter</span>
        </a>
    </div>
</div>
<div id="help-description" class="modal-body hidden" style="padding: 20px">

</div>
<div id="modal-footer" class="modal-footer">
    <div class="pull-left" id="checkbox-automatic-show">
        <button class="btn btn-default btn-checkbox" name="primary">
            <span id="icons" style="margin-right: 6px">
                <i class="fa fa-square-o" id="normal"></i>
                <i class="fa fa-square hidden" id="over"></i>
                <i class="fa fa-check-square hidden" id="checked"></i>
            </span>
            <span class="option-text ellipsis">Nicht mehr automatisch anzeigen</span>
        </button>
    </div>

    <button type="button" class="btn btn-default btn-shadow" id="btn-close"><i class="fa fa-close"></i> Schließen</button>
</div>

<script>
    $(document).ready(function () {
        var modal = $('#custom-modal');
        var items = $(modal).attr('data-help-items-key');

console.log(items, translation[items]);
        for (var i = 0; i < translation[items].length; i++) {
            var helpItem = translation[items][i];
            var item = $('#carousel-listbox-item').clone().removeClass('hidden').removeAttr('id');
            $(item).find('img').attr('src', helpItem.imgSrc);
            $(item).find('.carousel-caption-header').text(helpItem.title);
            $(item).find('.carousel-caption-text').text(helpItem.text);
            $(modal).find('#carousel-introduction-generic .carousel-inner').append(item);

            var indicatorItem = document.createElement('li');
            $(indicatorItem).attr('data-target', '#carousel-introduction-generic');
            $(indicatorItem).attr('data-slide-to', i);
            $(modal).find('#carousel-introduction-generic .carousel-indicators').append(indicatorItem);

            if (i === 0) {
                $(indicatorItem).addClass('active');
                $(item).addClass('active');

                if (helpItem.description) {
                    $(modal).find('#help-description').removeClass('hidden');
                    $(modal).find('#help-description').html(helpItem.description);
                }
            }
        }

        $(modal).find('#carousel-introduction-generic').unbind('slide.bs.carousel').bind('slide.bs.carousel', function () {
            $(modal).find('#help-description').html('');
            $(modal).find('#help-description').addClass('hidden');
        });

        $(modal).find('#carousel-introduction-generic').unbind('slid.bs.carousel').bind('slid.bs.carousel', function () {
            var currentIndex = parseInt($(modal).find('#carousel-introduction-generic .carousel-indicators .active').attr('data-slide-to'));
            if (items && translation[items] && translation[items].length > 0) {
                var helpItem = translation[items][currentIndex];
                if (helpItem.description) {
                    $(modal).find('#help-description').removeClass('hidden');
                    $(modal).find('#help-description').html(helpItem.description);
                }
            }
        });



        var showTutorial = parseInt($(modal).attr('data-help-show-tutorial'));
        if (showTutorial === 0) {
            $(modal).find('#checkbox-automatic-show .btn-checkbox').click();
        }

        $(modal).find('#btn-close').unbind('click').bind('click', function (event) {
            event.preventDefault();
            var dontShowIntroduction = $(this).parent().find('#checkbox-automatic-show .btn-checkbox').hasClass('btn-option-checked');
            updateIntroduction({context: $(modal).attr('data-help-context'), dontShowIntroduction: dontShowIntroduction ? 0 : 1});
            $(modal).removeAttr('data-help-items-key');
            $(modal).modal('hide');
        });
    });
</script>