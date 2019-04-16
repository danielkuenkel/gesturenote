<?php
include '../includes/language.php';
?>

<div class="modal-header">
    <h4 class="modal-title"><i class="fa fa-support"></i> <?php echo $lang->help ?></h4>
</div>
<div class="fixed-help-naviation text-center hidden" style="">
    <div class="fixed-help-naviation-background hidden"></div>
    <!--<div class="form-group" style="display: block; left: 50%; position: relative; transform: translateX(-50%); top: 12px;">-->
    <div style="position: absolute; z-index: 1; top: 12px; left: 50%; transform: translateX(-50%); display: flex">
        <div class="dropdown select-help-section" style="margin-right: 10px">
            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                <span class="chosen"></span> <span class="caret"></span>
            </button>
            <ul class="dropdown-menu dropdown-menu-center option" aria-labelledby="dropdownMenu1"></ul>
        </div>
        <button type="button" id="btn-scroll-to-top" class="btn btn-default btn-shadow" style="display: inline;"><?php echo $lang->scrollToTop ?> <i class="fa fa-arrow-up"></i></button>
    </div>



    <!--        <div class="select select-help-section" data-update-option="filter" role="group" style="display: inline; margin-right: 10px;">
                <button class="btn btn-default btn-shadow dropdown-toggle disabled" type="button" data-toggle="dropdown"><span class="chosen"></span> <span class="caret"></span></button>
                <ul class="dropdown-menu dropdown-menu-center option" role="menu">
                </ul>
            </div>-->
            <!--<button type="button" id="btn-scroll-to-top" class="btn btn-default btn-shadow" style="display: inline;"><?php echo $lang->scrollToTop ?> <i class="fa fa-arrow-up"></i></button>-->
    <!--</div>-->



    <button type="button" class="close" id="btn-close-top" data-dismiss="modal" style="position: absolute; top: 13px; right: 15px; z-index: 1">&times;</button>
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
            <span class="option-text ellipsis"><?php echo $lang->dontShowIntroductionAutomatically ?></span>
        </button>
    </div>

    <button type="button" class="btn btn-default btn-shadow" id="btn-close"><i class="fa fa-close"></i> <?php echo $lang->close ?></button>
</div>

<script>
    $(document).ready(function () {
        var modal = $('#custom-modal');
        var itemsKey = $(modal).attr('data-help-items-key');
        var startTabId = $(modal).attr('data-start-tab-id');
        var context = $(modal).attr('data-help-context');

        $(modal).scroll(function () {
            var scrollTop = $('.modal').scrollTop();
            if (parseInt(scrollTop) > 117) {
                if (!$(modal).find('.fixed-help-naviation').hasClass('fixed')) {
                    $(modal).find('.fixed-help-naviation').addClass('fixed');
                }
                $(modal).find('.fixed-help-naviation-background').removeClass('hidden');
                $(modal).find('.fixed-help-naviation').css({top: (scrollTop - 61) + 'px'});
            } else {
                if ($(modal).find('.fixed-help-naviation').hasClass('fixed')) {
                    $(modal).find('.fixed-help-naviation').removeClass('fixed');
                }
                $(modal).find('.fixed-help-naviation-background').addClass('hidden');
                $(modal).find('.fixed-help-naviation').css({top: '0px'});
            }

            var activeItem = null;
            var dynamicScrollItems = $(modal).find('#help-description .dynamic-scrolling-item');
            for (var i = 0; i < dynamicScrollItems.length; i++) {
                if ($(dynamicScrollItems[i]).offset().top <= scrollTop + $(dynamicScrollItems[0]).offset().top) {
                    // save active link list item
                    activeItem = $(dynamicScrollItems[i]);
                } else {
                    break;
                }
            }

            if (activeItem) {
                $(modal).find('.fixed-help-naviation .chosen').text($(modal).find('.fixed-help-naviation .option').find('[href="#' + $(activeItem).attr('id') + '"]').text());
                $(modal).find('.fixed-help-naviation .selected').removeClass('selected');
                $(modal).find('.fixed-help-naviation .option').find('[href="#' + $(activeItem).attr('id') + '"]').parent().addClass('selected');
            }
        });

        var items = translation[itemsKey];
        if (items && items.length > 0) {
            $(modal).find('.fixed-help-naviation .dropdown-toggle').removeClass('disabled');
            $(modal).find('.fixed-help-naviation').removeClass('hidden');
            $(modal).find('#help-description').removeClass('hidden');
        }

        var container = $(modal).find('#help-description');
        $(container).css({opacity: 0});

        for (var i = 0; i < items.length; i++) {
            var contentHeadline = document.createElement('h2');
            $(contentHeadline).addClass('dynamic-scrolling-item');
            var contentHeadlineNumber = document.createElement('span');
            $(contentHeadlineNumber).text((i + 1)).css({marginRight: '10px'});
            $(contentHeadline).attr('id', items[i].tabId);
            $(contentHeadline).attr('data-headline-format', 'h2');
            $(contentHeadline).text(items[i].title).css({marginTop: (i > 0) ? '60px' : '0px'});
            $(contentHeadline).prepend(contentHeadlineNumber);
            $(container).append(contentHeadline);

            var linkListItem = document.createElement('li');
            var link = document.createElement('a');
            $(link).attr('href', '#' + items[i].tabId).addClass('smooth-goto ellipsis').text((i + 1) + ' ' + items[i].title);
//            $('#link-list').append(document.createElement('br')).append(link);
            $(linkListItem).append(link);
            $(modal).find('.fixed-help-naviation .option').append(linkListItem);

            if (i === 0) {
                $(modal).find('.fixed-help-naviation .chosen').text($(link).text());
            }
//
//            var helpItemImage = document.createElement('img');
//            $(helpItemImage).attr('src', allHelp[i].content[j].imgSrc).addClass('img-image');
//            $(helpItemImage).css({marginBottom: '30px', width: '100%'});
//            $(helpItemImage).addClass('image-border-rounded');
//            $(helpItem).append(helpItemImage);
//
            var helpContent = document.createElement('div');
            $(helpContent).html(items[i].description);
            $(container).append(helpContent);

            var headlines = $(helpContent).find('h4');
            $(headlines).addClass('dynamic-scrolling-item');
            $(headlines).attr('data-headline-format', 'h4');

            for (var j = 0; j < headlines.length; j++) {
                var number = (i + 1) + '.' + (j + 1);
                var idNumber = (i + 1) + '-' + (j + 1);

                linkListItem = document.createElement('li');
                var link = document.createElement('a');
                $(link).attr('href', '#' + items[i].tabId + '-' + idNumber).addClass('smooth-goto ellipsis').text(number + ' ' + $(headlines[j]).text());
                $(linkListItem).append(link);
                (modal).find('.fixed-help-naviation .option').append(linkListItem);
//                $('#link-list').append(document.createElement('br')).append(link);

                $(headlines[j]).css({marginTop: '40px'});
                var headlineNumber = document.createElement('span');

                $(headlineNumber).text(number);
                $(headlineNumber).css({marginRight: '10px'});
                $(headlines[j]).attr('id', items[i].tabId + '-' + idNumber);
                $(headlines[j]).prepend(headlineNumber);
            }
        }

        $(document).on('click', '.smooth-goto', function () {
            var scrollToElement = $(modal).find('#help-description').find($(this).attr('href'));
            var scrollTop = $(scrollToElement).position().top;
            $(modal).animate({scrollTop: scrollTop + 90}, 300);
        });

        if (startTabId) {
            console.log('start tab id', startTabId, $(modal).find('.fixed-help-naviation .option').find('[href="#' + startTabId + '"]'));
            setTimeout(function () {
                $(modal).find('.fixed-help-naviation .option').find('[href="#' + startTabId + '"]').click();
                TweenMax.to(container, .3, {delay: .3, opacity: 1});
            }, 400);
        } else {
            TweenMax.to(container, .3, {opacity: 1});
        }

        initPopover(0);

        var tutorials = <?php echo json_encode($_SESSION['tutorials']) ?>;
        if (tutorials && tutorials.hasOwnProperty(context) && parseInt(tutorials[context]) === 0) {
            $(modal).find('#checkbox-automatic-show .btn-checkbox').click();
        }

        $(modal).find('#btn-close').unbind('click').bind('click', function (event) {
            event.preventDefault();
            closeIntroduction();
        });

        $(modal).find('#btn-close-top').unbind('click').bind('click', function (event) {
            event.preventDefault();
            closeIntroduction();
        });

        $(modal).find('#btn-scroll-to-top').unbind('click').bind('click', function (event) {
            event.preventDefault();
            $(modal).animate({scrollTop: 0}, 300);
        });

        function closeIntroduction() {
            var dontShowIntroduction = $(modal).find('#checkbox-automatic-show .btn-checkbox').hasClass('btn-option-checked');
            updateIntroduction({context: context, dontShowIntroduction: dontShowIntroduction ? 0 : 1});
            $(modal).removeAttr('data-help-items-key');
            $(modal).removeAttr('data-help-context');
            $(modal).removeAttr('data-help-show-tutorial');
            $(modal).removeAttr('data-start-tab-id');
            $(modal).modal('hide');

            if (itemsKey === 'introductionStudy') {
                showStudyTutorial = dontShowIntroduction ? 0 : 1;
            } else if (itemsKey === 'introductionExtraction') {
                showExtractionTutorial = dontShowIntroduction ? 0 : 1;
            }
        }
    });
</script>