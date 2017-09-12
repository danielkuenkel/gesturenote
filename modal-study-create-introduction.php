<?php
include 'includes/language.php';
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"><i class="fa fa-support"></i> <?php echo $lang->introduction ?></h4>
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
<div id="modal-footer" class="modal-footer">
    <button type="button" class="btn btn-default btn-shadow" data-dismiss="modal"><i class="fa fa-close"></i> Schließen</button>
</div>

<div class="item hidden" id="carousel-listbox-item">
    <img src="">
    <div class="carousel-caption">
        <h4 class="carousel-caption-header"></h4>
        <p class="carousel-caption-text"></p>
    </div>
</div>

<script>
    $(document).ready(function () {
        for (var i = 0; i < translation.introductionCreateStudy.length; i++) {
            var item = $('#carousel-listbox-item').clone().removeClass('hidden').removeAttr('id');
            $(item).find('img').attr('src', translation.introductionCreateStudy[i].imgSrc);
            $(item).find('.carousel-caption-header').text(translation.introductionCreateStudy[i].title);
            $(item).find('.carousel-caption-text').text(translation.introductionCreateStudy[i].text);
            $('#carousel-introduction-generic').find('.carousel-inner').append(item);

            var indicatorItem = document.createElement('li');
            $(indicatorItem).attr('data-target', '#carousel-introduction-generic');
            $(indicatorItem).attr('data-slide-to', i);
            $('#carousel-introduction-generic').find('.carousel-indicators').append(indicatorItem);

            if (i === 0) {
                $(indicatorItem).addClass('active');
                $(item).addClass('active');
            }
        }
    });
</script>