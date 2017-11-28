<?php
include './includes/language.php';
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

session_start();
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
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="css/general.css">
        <link rel="stylesheet" href="css/generalSubPages.css">
        <link rel="stylesheet" href="css/studies.css">
        <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.5/TweenMax.min.js"></script>


        <script src="js/storage.js"></script>
        <script src="js/constants.js"></script>
        <script src="js/alert.js"></script>
        <script src="js/externals.js"></script>
        <script src="js/language.js"></script>
        <script src="js/goto-general.js"></script>
        <script src="js/goto-evaluator.js"></script>
        <script src="js/ajax.js"></script>
        <script src="js/globalFunctions.js"></script>
        <script src="js/sha512.js"></script>
    </head>
    <body id="pageBody" data-spy="scroll" data-target=".navbar" data-offset="60">

        <!-- externals -->
        <div id="alerts"></div>
        <div id="template-subpages"></div>

        <!-- thumbnail -->
        <div class="root col-xs-12 col-sm-6 col-lg-4 hidden studies-catalog-thumbnail" id="studies-catalog-thumbnail">
            <div class="panel panel-default btn-shadow">
                <div class="panel-heading" style="text-overflow:ellipsis; white-space:nowrap; overflow: hidden;">
                    <span class="title-text ellipsis" style="position: relative; top: 1px;"></span>
                </div>

                <div class="panel-body panel-body-progress">
                    <div class="progress" style="margin:0; border-radius:0; height:3px">
                        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="10" aria-valuemax="100" style="width: 100%;"></div>
                    </div>
                </div>

                <div class="panel-body">
                    <div>
                        <div class="label label-default" id="type-phase"></div>
                        <div class="label label-default" id="type-survey"></div>
                        <div class="label label-default hidden" id="panel-survey"><?php echo $lang->panelSurvey ?></div>
                    </div>

                    <div>
                        <div id="study-range-days"><span class="address"></span> <span class="text"></span></div>
                        <div class="hidden study-no-plan"><i class="fa fa-calendar-times-o" aria-hidden="true"></i> <span class="text"></span></div>
                        <div class="hidden study-not-started"><i class="fa fa-hourglass-start" aria-hidden="true"></i> <span class="text"></span></div>
                        <div class="hidden study-started"><i class="fa fa-hourglass-half" aria-hidden="true"></i> <span class="text"></span></div>
                        <div class="hidden study-ended"><i class="fa fa-hourglass-end" aria-hidden="true"></i> <span class="text"></span></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Container (Breadcrump) -->
        <div class="container" id="breadcrumb" style="margin-top: 40px">
            <div class="row">
                <ol class="breadcrumb">
                    <li><a class="breadcrump-btn" id="btn-index"><i class="fa fa-home" aria-hidden="true"></i> <?php echo $lang->breadcrump->home ?></a></li>
                    <li><a class="breadcrump-btn" id="btn-dashboard"><i class="fa fa-tachometer" aria-hidden="true"></i> <?php echo $lang->breadcrump->dashboard ?></a></li>
                    <li class="active"><i class="fa fa-tasks" aria-hidden="true"></i> <?php echo $lang->breadcrump->studies ?></li>
                </ol>
            </div>
        </div>


        <!-- Container (Panel Section) -->
        <div class="container mainContent" style="margin-top: 0px;" id="item-view">

            <button type="button" class="btn btn-success btn-lg btn-block btn-shadow" onclick="gotoCreateStudy()"><i class="glyphicon glyphicon-plus"></i> <?php echo $lang->createNewStudy ?></button>

            <div class="form-group form-group-no-margin" style="margin-top: 20px">
                <div class="input-group">
                    <span class="input-group-addon"><?php echo $lang->filter->name ?></span>
                    <input class="form-control item-input-text show-dropdown text-center readonly" tabindex="-1" type="text" value="<?php echo $lang->filter->all ?>"/>
                    <div class="input-group-btn select" id="filter" role="group">
                        <button class="btn btn-default btn-shadow btn-dropdown dropdown-toggle" type="button" data-toggle="dropdown" style="border-radius: 0px"><span class="chosen hidden" id="all"></span><span class="caret"></span></button>
                        <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                            <li id="all" class="selected"><a href="#"><?php echo $lang->filter->all ?></a></li>
                            <li id="elicitation"><a href="#"><?php echo $lang->filter->elicitation ?></a></li>
                            <li id="extraction"><a href="#"><?php echo $lang->filter->extraction ?></a></li>
                            <li id="evaluation"><a href="#"><?php echo $lang->filter->evaluation ?></a></li>
                            <li id="unmoderated"><a href="#"><?php echo $lang->filter->unmoderated ?></a></li>
                            <li id="moderated"><a href="#"><?php echo $lang->filter->moderated ?></a></li>
                        </ul>
                    </div>
                    <span class="input-group-addon"><?php echo $lang->sorting->name ?></span>
                    <input class="form-control item-input-text show-dropdown text-center readonly" tabindex="-1" type="text" value="<?php echo $lang->sorting->ASC ?>"/>
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
                    <input class="form-control item-input-text show-dropdown text-center readonly" tabindex="-1" type="text" value="12"/>
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

            <div style="margin-top: 15px;" class="text-center">
                <span class="text"><?php echo $lang->studyColors->whatDoTheColorsMean ?></span>
                <span style="margin-left: 10px"><i class="fa fa-minus" aria-hidden="true" style="color: #EEAC57"></i> <span class="text"><?php echo $lang->studyColors->notStarted ?></span></span>
                <span style="margin-left: 10px"><i class="fa fa-minus" aria-hidden="true" style="color: #5bc0de"></i> <span class="text"><?php echo $lang->studyColors->running ?></span></span>
                <span style="margin-left: 10px"><i class="fa fa-minus" aria-hidden="true" style="color: #5cb85c"></i> <span class="text"><?php echo $lang->studyColors->stopped ?></span></span>
                <span style="margin-left: 10px"><i class="fa fa-minus" aria-hidden="true" style="color: #d9534f"></i> <span class="text"><?php echo $lang->studyColors->noSchedule ?></span></span>
            </div>

            <div class="text-center custom-pagination" id="pager-top">
                <nav>
                    <ul class="pagination pagination-custom hidden" itemprop="clipping_2">
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
                    <ul class="pagination pagination-custom hidden" itemprop="clipping_2">
                        <li id="btn-first-page"><a href="#" aria-label="First"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>
                        <li id="btn-previous-page"><a href="#" aria-label="Previous"><i class="fa fa-angle-left" aria-hidden="true"></i></a></li>
                        <li id="btn-next-page"><a href="#" aria-label="Next"><i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
                        <li id="btn-last-page"><a href="#" aria-label="Last"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
                    </ul>
                </nav>
            </div>

            <div class="alert-space alert-no-search-results"></div>
            <div class="alert-space alert-no-studies"></div>

        </div>

        <script>
            $(document).ready(function () {
                checkDomain();
                currentFilterList = $('#list-container');

                checkLanguage(function () {
                    var externals = new Array();
                    externals.push(['#alerts', PATH_EXTERNALS + 'alerts.php']);
                    externals.push(['#template-subpages', PATH_EXTERNALS + 'template-sub-pages.php']);
                    loadExternals(externals);
                });
            });

            function onAllExternalsLoadedSuccessfully() {
                renderSubPageElements();

                getStudiesCatalog(function (result) {
                    if (result.status === RESULT_SUCCESS) {
                        if (result.studies && result.studies.length > 0) {
                            originalFilterData = result.studies;

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
                            initPagination(data);
                            $('#sort #newest').click();
                        } else {
                            appendAlert($('#item-view'), ALERT_NO_STUDIES);
                        }
                    }
                });
            }

            function renderData(data, animate) {
                $(currentFilterList).empty();
                currentFilterData = data;

                var index = getCurrentPaginationIndex();
                var listCount = parseInt($('#resultsCountSelect .chosen').attr('id').split('_')[1]);
                var viewFromIndex = index * listCount;
                var viewToIndex = Math.min((index + 1) * listCount, currentFilterData.length);

                for (var i = viewFromIndex; i < viewToIndex; i++) {
                    var clone = getStudiesCatalogListThumbnail(currentFilterData[i]);
                    $(currentFilterList).append(clone);

                    if (animate) {
                        TweenMax.from(clone, .2, {delay: i * .03, opacity: 0, scaleX: 0.5, scaleY: 0.5});
                    }

                    $(clone).find('.panel').click({studyId: currentFilterData[i].id}, function (event) {
                        event.preventDefault();
                        var hash = hex_sha512(parseInt(event.data.studyId) + '<?php echo $_SESSION['user_id'] . $_SESSION['forename'] . $_SESSION['surname'] ?>');
                        goto("study.php?studyId=" + event.data.studyId + "&h=" + hash);
                    });
                }

                $(currentFilterList).unbind('renderData').bind('renderData', function (event, data) {
                    event.preventDefault();
                    renderData(data);
                });
            }

            $('#filter').unbind('change').bind('change', function (event) {
                event.preventDefault();
                currentFilterData = sort();
                updatePaginationItems();
                if ($(currentFilterList).closest('#item-view').find('#searched-input').val().trim() !== "") {
                    $(currentFilterList).closest('#item-view').find('#searched-input').trigger('keyup');
                } else {
                    renderData(currentFilterData, true);
                }
            });

            $('#sort').unbind('change').bind('change', function (event) {
                event.preventDefault();
                currentFilterData = sort();
                updatePaginationItems();
                if ($(currentFilterList).closest('#item-view').find('#searched-input').val().trim() !== "") {
                    $(currentFilterList).closest('#item-view').find('#searched-input').trigger('keyup');
                } else {
                    renderData(currentFilterData, true);
                }
            });

            $('#resultsCountSelect').unbind('change').bind('change', function (event) {
                event.preventDefault();
                currentFilterData = sort();
                updatePaginationItems();
                if ($(currentFilterList).closest('#item-view').find('#searched-input').val().trim() !== "") {
                    $(currentFilterList).closest('#item-view').find('#searched-input').trigger('keyup');
                } else {
                    renderData(currentFilterData, true);
                }
            });

            $('body').on('indexChanged', '.pagination', function (event, index) {
                event.preventDefault();
                if (!event.handled) {
                    event.handled = true;
                    renderData(sort(), true);
                }
            });
        </script>
    </body>
</html>
