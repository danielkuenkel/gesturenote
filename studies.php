<?php
include './includes/language.php';
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

if (login_check($mysqli) == true) {
    if (isset($_SESSION['usertype']) && $_SESSION['usertype'] == 'tester') {
        header('Location: index.php');
    }
} else {
    header('Location: index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $lang->gestureNoteStudies ?></title>
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
        <link rel="stylesheet" href="css/studies.css">

        <script src="js/refreshSession.js"></script>
        <script src="js/storage.js"></script>
        <script src="js/chance.min.js"></script>
        <script src="js/constants.js"></script>
        <script src="js/alert.js"></script>
        <script src="js/externals.js"></script>
        <script src="js/language.js"></script>
        <script src="js/goto-general.js"></script>
        <script src="js/goto-evaluator.js"></script>
        <script src="js/ajax.js"></script>
        <script src="js/globalFunctions.js"></script>
        <script src="js/sha512/sha512.min.js"></script>
        <script src="js/masonry/masonry.min.js"></script>
    </head>
    <body id="pageBody" data-spy="scroll" data-target=".navbar" data-offset="60">

        <!-- externals -->
        <div id="alerts"></div>
        <div id="template-general"></div>

        <!-- thumbnail -->
        <div class="root col-xs-12 col-sm-6 col-lg-4 hidden grid-item studies-catalog-thumbnail" id="studies-catalog-thumbnail">
            <div class="panel panel-default btn-shadow btn-panel">
                <div class="panel-heading" style="text-overflow:ellipsis; white-space:nowrap; overflow: hidden;">
                    <span class="title-text ellipsis" style="position: relative; top: 1px;"></span>
                </div>

                <div class="panel-body panel-body-progress">
                    <div class="progress" style="margin:0; border-radius:0; height:2px">
                        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="10" aria-valuemax="100" style="width: 100%;"></div>
                    </div>
                </div>

                <div class="panel-body panel-content">
                    <div>
                        <div class="label label-default" id="type-method"></div>
                        <div class="label label-default" id="type-phase"></div>
                        <!--<div class="label label-default" id="type-survey"></div>-->
                        <div class="label label-default hidden" id="participant-count" data-toggle="popover" data-trigger="hover" data-placement="auto"><i class="fa fa-users"></i> <span class="label-text"></span></div>
                        <div class="label label-default hidden" id="shared-study" data-toggle="popover" data-trigger="hover" title="<?php echo $lang->studySharedWith ?>" data-placement="auto"><i class="fa fa-share-alt"></i> <span class="label-text"></span></div>
                    </div>

                    <div id="study-description" style="line-height: 14pt; font-size: 11pt; margin-top: 10px">

                    </div>

                    <div id="study-plan" class="hidden" style="margin-top: 3px">
                        <div id="study-range-days" style="margin-bottom: -6px"><span class="address"></span> <span class="text"></span></div>
                        <div class="hidden study-no-plan text"><i class="fa fa-calendar-times-o" aria-hidden="true"></i> <span class="status-text"></span></div>
                        <div class="hidden study-not-started text"><i class="fa fa-hourglass-start" aria-hidden="true"></i> <span class="status-text"></span></div>
                        <div class="hidden study-started text"><i class="fa fa-hourglass-half" aria-hidden="true"></i> <span class="status-text"></span></div>
                        <div class="hidden study-ended text"><i class="fa fa-hourglass-end" aria-hidden="true"></i> <span class="status-text"></span></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Container (Breadcrump) -->
        <div class="container" id="breadcrumb" style="">
            <div class="row">
                <ol class="breadcrumb">
                    <!--<li><a class="breadcrump-btn" id="btn-index"><i class="fa fa-home" aria-hidden="true"></i> <?php echo $lang->breadcrump->home ?></a></li>-->
                    <li><a class="breadcrump-btn" id="btn-dashboard"><i class="fa fa-tachometer" aria-hidden="true"></i> <?php echo $lang->breadcrump->dashboard ?></a></li>
                    <li class="active" data-id="btn-studies"><i class="fa fa-tasks" aria-hidden="true"></i> <?php echo $lang->breadcrump->studies ?></li>
                </ol>
            </div>
        </div>

        <!-- Modal -->
        <div id="custom-modal" class="modal fade custom-modal" data-backdrop="static" data-keyboard="false" role="dialog" data-conv-allowed="false">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content root">
                </div>
            </div>
        </div>

        <div class="hidden-xs hidden-sm study-owner-controls" id="fixed-studies-controls" style="position: fixed; top: 50%; z-index: 100; opacity: 0;">
            <div class="btn-group-vertical left-controls" style="right: -44px; transform: translateY(-50%)">
                <div>
                    <button type="button" class="btn btn-lg btn-default btn-shadow btn-create-study" id="btn-create-study" style="float: right; position: relative; border-bottom-left-radius: 0px; border-top-left-radius: 0px; border-top-right-radius: 8px; border-bottom-right-radius: 8px;"><?php echo $lang->createNewStudy ?> <i class="fa fa-plus" style="margin-left: 10px"></i> </button>
                </div>
            </div>
        </div>

        <div id="loading-indicator" class="window-sized-loading text-center">
            <i class="fa fa-circle-o-notch fa-spin fa-5x fa-fw"></i>
        </div>


        <!-- Container (Panel Section) -->
        <div class="container mainContent hidden" style="margin-top: 0px; padding-top: 0px" id="item-view">

            <button type="button" class="btn btn-success hidden-md hidden-lg btn-block btn-shadow btn-create-study" style="margin-top: 20px"><i class="fa fa-plus"></i> <?php echo $lang->createNewStudy ?></button>

            <div style="margin-top: 30px">
                <h3><?php echo $lang->breadcrump->studies ?></h3>
            </div>

            <div id="filter-controls">
                <div class="form-group form-group-no-margin" style="margin-top: 20px">
                    <div class="input-group">
                        <span class="input-group-addon"><?php echo $lang->filter->name ?></span>
                        <input class="form-control item-input-text text-center show-dropdown" tabindex="-1" type="text" value="<?php echo $lang->filter->all ?>"/>
                        <div class="input-group-btn select" id="filter" role="group">
                            <button class="btn btn-default btn-shadow btn-dropdown dropdown-toggle" type="button" data-toggle="dropdown" style="border-radius: 0px"><span class="chosen hidden" id="all"></span><span class="caret"></span></button>
                            <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                                <li id="all" class="selected"><a href="#"><?php echo $lang->filter->all ?></a></li>
                                <li id="elicitation"><a href="#"><?php echo $lang->filter->elicitation ?></a></li>
                                <li id="extraction"><a href="#"><?php echo $lang->filter->extraction ?></a></li>
                                <li id="evaluation"><a href="#"><?php echo $lang->filter->evaluation ?></a></li>
                                <li id="unmoderated"><a href="#"><?php echo $lang->filter->unmoderated ?></a></li>
                                <li id="moderated"><a href="#"><?php echo $lang->filter->moderated ?></a></li>
                                <li id="public"><a href="#"><?php echo $lang->filter->shared ?></a></li>
                                <li id="sharedWithYou"><a href="#"><?php echo $lang->filter->sharedWithYou ?></a></li>
                                <li id="private"><a href="#"><?php echo $lang->filter->private ?></a></li>
                            </ul>
                        </div>
                        <span class="input-group-addon"><?php echo $lang->sorting->name ?></span>
                        <input class="form-control item-input-text text-center show-dropdown" tabindex="-1" type="text" value="<?php echo $lang->sorting->ASC ?>"/>
                        <div class="input-group-btn select" id="sort" role="group">
                            <button class="btn btn-default btn-shadow btn-dropdown dropdown-toggle" type="button" data-toggle="dropdown"><span class="chosen hidden" id="newest"></span><span class="caret"></span></button>
                            <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                                <li id="oldest"><a href="#"><?php echo $lang->sorting->DESC ?></a></li>
                                <li id="newest"><a href="#"><?php echo $lang->sorting->ASC ?></a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="form-group form-group-margin-top">
                    <div class="input-group">
                        <span class="input-group-addon"><?php echo $lang->search->name ?></span>
                        <input class="form-control item-input-text search search-input" id="searched-input" autocomplete="off" type="search" value="" placeholder="<?php echo $lang->search->placeHolder ?>"/>
                        <span class="input-group-addon"><?php echo $lang->filterItems->name ?></span>
                        <input class="form-control item-input-text text-center show-dropdown" tabindex="-1" type="text" value="12"/>
                        <div class="input-group-btn select" id="resultsCountSelect" role="group">
                            <button class="btn btn-default btn-shadow btn-dropdown dropdown-toggle" type="button" data-toggle="dropdown"><span class="chosen hidden" id="results_12"></span><span class="caret"></span></button>
                            <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                                <li id="results_3"><a href="#">3</a></li>
                                <li id="results_6"><a href="#">6</a></li>
                                <li id="results_12" class="selected"><a href="#">12</a></li>
                                <li id="results_48"><a href="#">48</a></li>
                                <li id="results_96"><a href="#">96</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="text-center custom-pagination" id="pager-top">
                    <nav>
                        <ul class="pagination pagination-custom hidden" data-clipping="7">
                            <li id="btn-first-page"><a href="#" aria-label="First"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>
                            <li id="btn-previous-page"><a href="#" aria-label="Previous"><i class="fa fa-angle-left" aria-hidden="true"></i></a></li>
                            <li id="btn-next-page"><a href="#" aria-label="Next"><i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
                            <li id="btn-last-page"><a href="#" aria-label="Last"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
                        </ul>
                    </nav>
                </div>

                <div class="container-root row root" id="list-container" style="margin-top: 10px;"></div>

                <div class="text-center custom-pagination" id="pager-bottom" style="margin: 0">
                    <nav>
                        <ul class="pagination pagination-custom hidden" data-clipping="7">
                            <li id="btn-first-page"><a href="#" aria-label="First"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>
                            <li id="btn-previous-page"><a href="#" aria-label="Previous"><i class="fa fa-angle-left" aria-hidden="true"></i></a></li>
                            <li id="btn-next-page"><a href="#" aria-label="Next"><i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
                            <li id="btn-last-page"><a href="#" aria-label="Last"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
                        </ul>
                    </nav>
                </div>
            </div>


            <div class="alert-space alert-no-search-results"></div>
            <div class="alert-space alert-no-studies"></div>

            <button type="button" class="btn btn-success hidden btn-block btn-shadow btn-create-study" id="btn-main-create-study" style="margin-top: 20px"><i class="fa fa-plus"></i> <?php echo $lang->createNewStudy ?></button>

            <div style="margin-top: 35px;" class="text-center hidden" id="color-explanation">
                <span class="text"><?php echo $lang->studyColors->whatDoTheColorsMean ?></span>
                <span style="margin-left: 10px"><i class="fa fa-minus" aria-hidden="true" style="color: #EEAC57"></i> <span class="text"><?php echo $lang->studyColors->notStarted ?></span></span>
                <span style="margin-left: 10px"><i class="fa fa-minus" aria-hidden="true" style="color: #5cb85c"></i> <span class="text"><?php echo $lang->studyColors->running ?></span></span>
                <span style="margin-left: 10px"><i class="fa fa-minus" aria-hidden="true" style="color: #5bc0de"></i> <span class="text"><?php echo $lang->studyColors->stopped ?></span></span>
                <!--<span style="margin-left: 10px"><i class="fa fa-minus" aria-hidden="true" style="color: #d9534f"></i> <span class="text"><?php echo $lang->studyColors->noSchedule ?></span></span>-->
            </div>

        </div>

        <div class="container">
            <div class="row" id="masonry-grid">
            </div>
        </div>


        <script>
            var firstInit = true;

            $(document).ready(function () {
                checkDomain();
                keepSessionAlive();
                currentFilterList = $('#list-container');

                checkLanguage(function () {
                    var externals = new Array();
                    externals.push(['#alerts', PATH_EXTERNALS + 'alerts.php']);
                    externals.push(['#template-general', PATH_EXTERNALS + 'template-general.php']);
                    loadExternals(externals);
                });

                var createStudyButton = $('#fixed-studies-controls #btn-create-study');
                var createStudyButtonTimeline = new TimelineMax({paused: true, onStart: function () {
                        $(createStudyButton).removeClass('btn-default').addClass('btn-primary');
                    }, onReverseComplete: function () {
                        $(createStudyButton).removeClass('btn-primary').addClass('btn-default');
                    }});

                $(createStudyButton).unbind('mouseenter').bind('mouseenter', function (event) {
                    event.preventDefault();
                    createStudyButtonTimeline.play();
                });

                $(createStudyButton).unbind('mouseleave').bind('mouseleave', function (event) {
                    event.preventDefault();
                    createStudyButtonTimeline.reverse();
                });

                setTimeout(function () {
                    var leftFlex = 46;

                    createStudyButtonTimeline.add("tween", 0)
                            .to(createStudyButton, .3, {left: +parseInt($(createStudyButton).outerWidth()) - leftFlex, ease: Quad.easeInOut});
                }, 200);
            });

            function onAllExternalsLoadedSuccessfully() {
                renderSubPageElements();
                checkDarkMode(parseInt('<?php echo checkDarkMode(); ?>'));

                getStudiesCatalog(function (result) {
                    if (result.status === RESULT_SUCCESS) {
                        if (result.studies && result.studies.length > 0) {
                            
                            originalFilterData = sortByKey(result.studies, 'created');

                            var data = {
                                pager: {
                                    top: $('#item-view #pager-top .pagination'),
                                    bottom: $('#item-view #pager-bottom .pagination'),
                                    dataLength: originalFilterData.length,
                                    maxElements: parseInt($('#item-view').find('#resultsCountSelect .chosen').attr('id').split('_')[1])
                                },
                                filter: {
                                    countSelect: $('#item-view').find('#resultsCountSelect'),
                                    filter: $('#item-view').find('#filter'),
                                    sort: $('#item-view').find('#sort')
                                }
                            };
                            
                            $('#color-explanation').removeClass('hidden');
                            $('.mainContent').removeClass('hidden');
                            TweenMax.to($('#loading-indicator'), .4, {opacity: 0, onComplete: function () {
                                    $('#loading-indicator').remove();
                                    initPagination(data);
                                    currentFilterData = sort();
                                    renderData(currentFilterData, true);
                                }});
                            TweenMax.from($('.mainContent'), .3, {delay: .3, opacity: 0});


//                            $('#sort #newest').click();
                        } else {
                            appendAlert($('#item-view'), ALERT_NO_STUDIES);
                            $('.mainContent').find('#filter-controls').addClass('hidden');
                            $('.mainContent').removeClass('hidden');
                            $('.mainContent').find('#btn-main-create-study').removeClass('hidden');
                            TweenMax.to($('#loading-indicator'), .4, {opacity: 0, onComplete: function () {
                                    $('#loading-indicator').remove();
                                }});
                        }

                        animateBreadcrump();
                        TweenMax.to($('#fixed-studies-controls'), .3, {opacity: 1});
                        TweenMax.from($('#fixed-studies-controls'), .3, {x: -20, ease: Quad.easeInOut});
                    }
                });
            }

            function renderData(data, animate) {
                var $container = $('#list-container');
                var hasMasonry = $container.data('masonry') ? true : false;
                if (hasMasonry === true) {
                    $container.masonry('destroy');
                }

                $(currentFilterList).empty();
                currentFilterData = data;

                var index = getCurrentPaginationIndex();
                var listCount = parseInt($('#resultsCountSelect .chosen').attr('id').split('_')[1]);
                var viewFromIndex = index * listCount;
                var viewToIndex = Math.min((index + 1) * listCount, currentFilterData.length);

                if (currentFilterData.length > 0) {
                    clearAlerts($('#item-view'));
                    initPopover();

                    for (var i = viewFromIndex; i < viewToIndex; i++) {
                        var clone = getStudiesCatalogListThumbnail(currentFilterList, currentFilterData[i]);
                        if (animate) {
                            TweenMax.from(clone, .2, {delay: i * .03, opacity: 0, scaleX: 0.5, scaleY: 0.5});
                        }

                        if (currentFilterData[i].data.generalData.method === 'userCentered') {
                            $(clone).unbind('gotoStudyParticipants').bind('gotoStudyParticipants', function (event, payload) {
                                event.preventDefault();
                                var hash = sha512(parseInt(payload.studyId) + '<?php echo $_SESSION['user_id'] . $_SESSION['forename'] . $_SESSION['surname'] ?>');
                                goto("study.php?studyId=" + payload.studyId + "&h=" + hash + '&joinedConv=false#participants');
                            });

                            $(clone).find('.panel').click({studyId: currentFilterData[i].id}, function (event) {
                                event.preventDefault();
                                var hash = sha512(parseInt(event.data.studyId) + '<?php echo $_SESSION['user_id'] . $_SESSION['forename'] . $_SESSION['surname'] ?>');
                                goto("study.php?studyId=" + event.data.studyId + "&h=" + hash + '&joinedConv=false');
                            });
                        } else if (currentFilterData[i].data.generalData.method === 'expertBased') {
                            $(clone).find('.panel').click({studyId: currentFilterData[i].id}, function (event) {
                                event.preventDefault();
                                var hash = sha512(parseInt(event.data.studyId) + '<?php echo $_SESSION['user_id'] . $_SESSION['forename'] . $_SESSION['surname'] ?>');
                                goto("extraction-study.php?studyId=" + event.data.studyId + "&h=" + hash + '&joinedConv=false');
                            });
                        }

                        $(clone).find('.panel').unbind('mouseenter').bind('mouseenter', function (event) {
                            event.preventDefault();
                            TweenMax.to($(this), .15, {scale: 1.05, ease: Quad.easeIn});
                        });

                        $(clone).find('.panel').unbind('mouseleave').bind('mouseleave', function (event) {
                            event.preventDefault();
                            TweenMax.to($(this), .2, {scale: 1, ease: Quad.easeOut, clearProps: 'all'});
                        });
                    }
                } else {
                    appendAlert($('#item-view'), ALERT_NO_STUDIES);
                    $('#item-view #pager-top .pagination').addClass('hidden');
                    $('#item-view #pager-bottom .pagination').addClass('hidden');
                }

                $(currentFilterList).unbind('renderData').bind('renderData', function (event, data) {
                    event.preventDefault();
                    renderData(data);
                });

                $container.masonry({
                    columnWidth: '.grid-item',
                    itemSelector: '.grid-item',
                    horizontalOrder: true,
                    percentPosition: true,
                    transitionDuration: 0
                });

                $container.masonry('layout');
                firstInit = false;
            }

            $('#filter').unbind('change').bind('change', function (event) {
                event.preventDefault();
                if (firstInit !== true) {
                    currentFilterData = sort();
                    updatePaginationItems();
                    if ($(currentFilterList).closest('#item-view').find('#searched-input').val().trim() !== "") {
                        $(currentFilterList).closest('#item-view').find('#searched-input').trigger('keyup');
                    } else {
                        renderData(currentFilterData, true);
                    }
                }
            });

            $('#sort').unbind('change').bind('change', function (event) {
                event.preventDefault();
                if (firstInit !== true) {
                    currentFilterData = sort();
                    updatePaginationItems();
                    if ($(currentFilterList).closest('#item-view').find('#searched-input').val().trim() !== "") {
                        $(currentFilterList).closest('#item-view').find('#searched-input').trigger('keyup');
                    } else {
                        renderData(currentFilterData, true);
                    }
                }
            });

            $('#resultsCountSelect').unbind('change').bind('change', function (event) {
                event.preventDefault();
                if (firstInit !== true) {
                    currentFilterData = sort();
                    updatePaginationItems();
                    if ($(currentFilterList).closest('#item-view').find('#searched-input').val().trim() !== "") {
                        $(currentFilterList).closest('#item-view').find('#searched-input').trigger('keyup');
                    } else {
                        renderData(currentFilterData, true);
                    }
                }
            });

            $('body').on('indexChanged', '.pagination', function (event, index) {
                event.preventDefault();
                if (!event.handled) {
                    event.handled = true;
                    if (firstInit !== true) {
                        renderData(sort(), true);
                    }
                }
            });

            function renderMasonryTest(maxItems) {
                for (var i = 0; i < maxItems; i++) {
                    var col = document.createElement('div');
                    $(col).addClass('col-xs-12 col-sm-6 col-md-4 col-lg-3 grid-item');
                    $('#masonry-grid').append(col);

                    var height = chance.natural({min: 50, max: 350});
                    var panel = document.createElement('div');
                    $(panel).addClass('panel panel-default');
                    $(col).append(panel);

                    var panelHeading = document.createElement('div');
                    $(panelHeading).addClass('panel-heading');
                    $(panel).append(panelHeading);

                    var panelBody = document.createElement('div');
                    $(panelBody).addClass('panel-body');
                    $(panelBody).css({height: height + 'px'});
                    $(panel).append(panelBody);
                }

                var $container = $('#masonry-grid');
                $container.masonry({
                    columnWidth: '.grid-item',
                    itemSelector: '.grid-item'
                });
            }

            $('.btn-create-study').unbind('click').bind('click', function (event) {
                event.preventDefault();
                loadHTMLintoModal('custom-modal', 'externals/modal-create-study-picker.php', 'modal-md');
            });
        </script>
    </body>
</html>
