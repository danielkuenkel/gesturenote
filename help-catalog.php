<?php
include './includes/language.php';
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $lang->gestureNoteHelpCatalog ?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- third party sources -->
        <link rel="stylesheet" href="js/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
        <link rel="icon" type="image/x-icon" href="img/favicon.ico">
        <script src="js/jquery/jquery.min.js"></script>
        <script src="js/bootstrap/js/bootstrap.min.js"></script>
        <script src="js/greensock/TweenMax.min.js"></script>

        <!-- gesturenote specific sources -->
        <link rel="stylesheet" href="css/general.css">
        <link rel="stylesheet" href="css/generalSubPages.css">
        <link rel="stylesheet" href="css/gesture.css">

        <script src="js/storage.js"></script>
        <script src="js/ajax.js"></script>
        <script src="js/constants.js"></script>
        <script src="js/externals.js"></script>
        <script src="js/language.js"></script>
        <script src="js/goto-general.js"></script>
        <script src="js/goto-evaluator.js"></script>
        <script src="js/globalFunctions.js"></script>
    </head>
    <body id="pageBody" data-spy="scroll" data-target=".navbar" data-offset="60">

        <!-- externals -->
        <div id="template-general"></div>



        <!-- Container (Landing Section) -->
        <div class="container" id="breadcrumb" style="">
            <div class="row">
                <ol class="breadcrumb">
                    <!--<li><a class="breadcrump-btn" id="btn-index"><i class="fa fa-home" aria-hidden="true"></i> <?php echo $lang->breadcrump->home ?></a></li>-->
                    <li><a class="breadcrump-btn" id="btn-dashboard"><i class="fa fa-tachometer" aria-hidden="true"></i> <?php echo $lang->breadcrump->dashboard ?></a></li>
                    <li class="active" data-id="btn-support"><i class="fa fa-support" aria-hidden="true"></i> <?php echo $lang->breadcrump->help ?></li>
                </ol>
            </div>
        </div>

        <div class="container mainContent" style="margin-top: 0px">
            <div class="row">
                <div class="col-md-5 col-lg-4" id="link-list" style="margin-bottom: 30px">
                    <!--<a href="#createStudy" class="smooth-goto">1. Gesten-Design-Studien</a>-->
                </div>
                <div class="col-md-7 col-lg-8" id="help-description">

                </div>
            </div>
        </div>

        <div class="hidden-sm hidden-xs" id="dynamic-link-list" style="position: fixed; top:20px; width: 100%; opacity:0">
            <div class="container">
                <div class="row">
                    <div class="col-md-5 col-lg-4" id="dynamic-link-list-items"></div>
                </div>
            </div>

        </div>

        <div id="btn-scroll-to-top" class="hidden" style="cursor:pointer; display: block; position: fixed; bottom: 15px; right: 15px; padding: 8px 10px; color:white; border-radius: 8px; background-color: rgba(0,0,0,.6)"><i class="fa fa-arrow-up fa-2x"></i></div>

        <script>
            $(document).ready(function () {
                checkDomain();
                checkLanguage(function () {
                    var externals = new Array();
                    externals.push(['#template-general', PATH_EXTERNALS + 'template-general.php']);
                    loadExternals(externals);
                });
            });

            function onAllExternalsLoadedSuccessfully() {
                var loggedIn = parseInt('<?php echo login_check($mysqli) ?>') === 1;
                renderSubPageElements(loggedIn);
                animateBreadcrump();

                var allHelp = [];
                allHelp.push({id: 'gesturesGestureSets', content: translation.introductionGestureCatalog});
                allHelp.push({id: 'createStudy', content: translation.introductionCreateStudy});
                allHelp.push({id: 'studyPreview', content: translation.introductionPreviewStudy});
                allHelp.push({id: 'study', content: translation.introductionStudy});
                allHelp.push({id: 'extraction', content: translation.introductionExtraction});
                allHelp.push({id: 'participant', content: translation.introductionParticipant});
                allHelp.push({id: 'collaboration', content: translation.introductionCollaboration});

                for (var i = 0; i < allHelp.length; i++) {
                    var helpItem = document.createElement('div');
                    $('#help-description').append(helpItem);

                    var headline = document.createElement('h1');
                    $(headline).addClass('dynamic-scrolling-item');
                    $(headline).attr('id', allHelp[i].id);
                    $(headline).attr('data-headline-format', 'h1');
                    $(headline).text((i + 1) + '. ' + translation.helpHeadlines[allHelp[i].id]);
                    $(helpItem).append(headline);

                    if (i === 0) {
                        $(headline).css({marginTop: '0px'});
                    } else {
                        $(headline).css({marginTop: '100px'});
                    }

                    if (i > 0) {
                        $('#link-list').append(document.createElement('p'));
                    }

                    var link = document.createElement('a');
                    $(link).attr('href', '#' + allHelp[i].id).addClass('smooth-goto ellipsis').text((i + 1) + '. ' + translation.helpHeadlines[allHelp[i].id]);
                    $('#link-list').append(link);

                    for (var j = 0; j < allHelp[i].content.length; j++) {
                        var contentHeadline = document.createElement('h2');
                        $(contentHeadline).addClass('dynamic-scrolling-item');
                        var contentHeadlineNumber = document.createElement('span');
                        $(contentHeadlineNumber).css({marginRight: '10px'}).text((i + 1) + '.' + (j + 1));
                        $(contentHeadline).attr('id', allHelp[i].id + '-' + allHelp[i].content[j].tabId);
                        $(contentHeadline).attr('data-headline-format', 'h2');
                        $(contentHeadline).text(allHelp[i].content[j].title).css({marginTop: '60px'});
                        $(contentHeadline).prepend(contentHeadlineNumber);
                        $(helpItem).append(contentHeadline);
//                        $(helpItem).append(document.createElement('hr'));

                        var link = document.createElement('a');
                        $(link).attr('href', '#' + allHelp[i].id + '-' + allHelp[i].content[j].tabId).addClass('smooth-goto ellipsis').text((i + 1) + '.' + (j + 1) + ' ' + allHelp[i].content[j].title);
                        $('#link-list').append(document.createElement('br')).append(link);

                        var helpItemImage = document.createElement('img');
                        $(helpItemImage).attr('src', allHelp[i].content[j].imgSrc).addClass('img-image');
                        $(helpItemImage).css({marginBottom: '30px', width: '100%'});
                        $(helpItemImage).addClass('image-border-rounded');
                        $(helpItem).append(helpItemImage);

                        var helpContent = document.createElement('div');
                        $(helpContent).html(allHelp[i].content[j].description);
                        $(helpItem).append(helpContent);

                        var headlines = $(helpContent).find('h4');
                        $(headlines).addClass('dynamic-scrolling-item');
                        $(headlines).attr('data-headline-format', 'h4');

                        for (var k = 0; k < headlines.length; k++) {
                            var number = (i + 1) + '.' + (j + 1) + '.' + (k + 1);
                            var idNumber = (i + 1) + '-' + (j + 1) + '-' + (k + 1);

                            var link = document.createElement('a');
                            $(link).attr('href', '#' + allHelp[i].id + '-' + allHelp[i].content[j].tabId + '-' + idNumber).addClass('smooth-goto ellipsis').text(number + ' ' + $(headlines[k]).text());
                            $('#link-list').append(document.createElement('br')).append(link);

                            $(headlines[k]).css({marginTop: '40px'});
                            var headlineNumber = document.createElement('span');

                            $(headlineNumber).text(number);
                            $(headlineNumber).css({marginRight: '10px'});
                            $(headlines[k]).attr('id', allHelp[i].id + '-' + allHelp[i].content[j].tabId + '-' + idNumber);
                            $(headlines[k]).prepend(headlineNumber);
                        }
                    }
                }

//                var query = getQueryParams(document.location.search);
//                if (query && query.section) {
//                    $('html').addClass('hidden');
////                    
////                    var scrollTop = $('#help-description').find('#' + query.section).offset().top;
//                    console.log('scroll to', query.section);
//                    setTimeout(function () {
//                        $('html').removeClass('hidden').animate({scrollTop: query.section}, 0);
//                    }, 1000);
//                }
            }

            $(document).on('click', '.smooth-goto', function () {
                $('html, body').animate({scrollTop: $('#help-description').find($(this).attr('href')).offset().top - 30}, 300);
                return false;
            });

            var scrollTimeout = null;
            $(document).scroll(function (event) {
                event.preventDefault();
                clearTimeout(scrollTimeout);

                var linkListHeight = $('#link-list').height() + $('#link-list').offset().top;
                var scrollTop = $(document).scrollTop();
                if (scrollTop > linkListHeight) {
                    $('#btn-scroll-to-top').removeClass('hidden');
                    if (!$('#dynamic-link-list').hasClass('active')) {
                        $('#dynamic-link-list').addClass('active');
                        $('#dynamic-link-list').removeClass('hidden');
                        TweenMax.to($('#dynamic-link-list'), .3, {opacity: 1});
                    }

                    var activeItems = [];
                    var prevItems = [];
                    var nextItems = [];

                    var dynamicScrollItems = $('#help-description').find('.dynamic-scrolling-item');
                    for (var i = 0; i < dynamicScrollItems.length; i++) {
                        // set previous default link list items
                        prevItems = [{item: $(dynamicScrollItems[i - 2])}, {item: $(dynamicScrollItems[i - 1])}];

                        // set active default link list item
                        activeItems = [{item: $(dynamicScrollItems[i]), active: true}];

                        if ($(dynamicScrollItems[i]).offset().top > scrollTop + 40) {
                            // set previous link list items
                            prevItems = [{item: $(dynamicScrollItems[i - 3])}, {item: $(dynamicScrollItems[i - 2])}];

                            // set active link list item
                            activeItems = [{item: $(dynamicScrollItems[i - 1]), active: true}];

                            // set next link list items
                            if (i < dynamicScrollItems.length - 3) {
                                nextItems = [{item: $(dynamicScrollItems[i])}, {item: $(dynamicScrollItems[i + 1])}, {item: $(dynamicScrollItems[i + 2])}, {item: $(dynamicScrollItems[i + 3])}];
                            } else if (i < dynamicScrollItems.length - 2) {
                                nextItems = [{item: $(dynamicScrollItems[i])}, {item: $(dynamicScrollItems[i + 1])}, {item: $(dynamicScrollItems[i + 2])}];
                            } else if (i < dynamicScrollItems.length - 1) {
                                nextItems = [{item: $(dynamicScrollItems[i])}, {item: $(dynamicScrollItems[i + 1])}];
                            } else if (i < dynamicScrollItems.length) {
                                nextItems = [{item: $(dynamicScrollItems[i])}];
                            }

                            break;
                        }
                    }
                    var renderItems = prevItems.concat(activeItems);
                    renderItems = renderItems.concat(nextItems);

//                    console.log(prevItems, activeItems, nextItems, renderItems);
                    $('#dynamic-link-list-items').empty();
                    for (var i = 0; i < renderItems.length; i++) {
                        var link = document.createElement(renderItems[i].active && renderItems[i].active === true ? 'span' : 'a');
                        $(link).html($(renderItems[i].item).html());
                        if (renderItems[i].active && renderItems[i].active === true) {
                            $(link).css({fontWeight: 'bold', color: 'black'});
                            var sectionId = $(renderItems[i].item).attr('id');
//                            scrollTimeout = setTimeout(function () {
//                                setParam(window.location.href, 'section', $('html, body').scrollTop());
//                            }, 300);
//                            if (window.history.replaceState) {

//                            }
                        } else {
                            $(link).attr('href', '#' + $(renderItems[i].item).attr('id')).addClass('smooth-goto ellipsis');
                        }
                        $('#dynamic-link-list-items').append(document.createElement('br')).append(link);
                    }
                } else {
                    $('#btn-scroll-to-top').addClass('hidden');

                    if ($('#dynamic-link-list').hasClass('active')) {
                        $('#dynamic-link-list').removeClass('active');
                        TweenMax.to($('#dynamic-link-list'), .1, {opacity: 0, onComplete: function () {
                                $('#dynamic-link-list').addClass('hidden');
                            }});
                    }

//                    scrollTimeout = setTimeout(function () {
//                        setParam(window.location.href, 'section', $('html, body').scrollTop());
//                    }, 300);
                }
            });

            $('#btn-scroll-to-top').click(function (event) {
                event.preventDefault();
                $('html, body').animate({scrollTop: 0}, "fast");
            });
        </script>

    </body>
</html>