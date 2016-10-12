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
        <title>GestureNote</title>
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
        <div id="templage-subpages"></div>

        <!-- thumbnail -->
        <div class="root col-xs-12 col-sm-6 col-lg-4 hidden studies-catalog-thumbnail" id="studies-catalog-thumbnail">
            <div class="panel panel-default btn-shadow">
                <div class="panel-heading" style="text-overflow:ellipsis; white-space:nowrap; overflow: hidden;">
                    <span class="title-text ellipsis" style="position: relative; top: 1px;"></span>
                </div>

                <div class="panel-body panel-body-progress">
                    <div class="progress" style="margin:0; border-radius:0; height:3px">
                        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="10" aria-valuemax="100" style="width: 100%;">
                            <!--                            <div class="hidden study-no-plan">Kein Zeitplan</div>
                                                        <div class="hidden study-not-started">Nicht gestartet</div>
                                                        <div class="hidden study-started"></div>
                                                        <div class="hidden study-ended">Beendet</div>-->
                        </div>
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
                <!--                <div class="panel-footer">
                                    <div class="btn-group btn-group-justified">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-info" id="btn-share-gesture"><i class="fa" aria-hidden="true"></i> <span class="btn-text"></span></button>
                                        </div>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-default" id="btn-show-gesture-info">Mehr</button>
                                        </div>
                                    </div>
                                </div>-->
            </div>
        </div>

        <!-- Container (Breadcrump) -->
        <div class="container" id="breadcrumb">
            <div class="row">
                <ol class="breadcrumb">
                    <li><a class="breadcrump-btn" id="btn-index"><?php echo $lang->breadcrump->home ?></a></li>
                    <li><a class="breadcrump-btn" id="btn-dashboard"><?php echo $lang->breadcrump->dashboard ?></a></li>
                    <li class="active"><?php echo $lang->breadcrump->studies ?></li>
                </ol>
            </div>
        </div>

        <!-- Container (Landing Section) -->
        <div class="container-fluid text-center bg-grey" id="landingText">
            <div class="container">
                <h1><i class="fa fa-tasks" style="font-size: 60pt" aria-hidden="true"></i> STUDIEN</h1>
                <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
            </div>
        </div>

        <!-- Container (Panel Section) -->
        <div class="container mainContent" style="margin-top: 35px;" id="item-view">

            <button type="button" class="btn btn-success btn-lg btn-block btn-shadow" onclick="gotoCreateStudy()"><i class="glyphicon glyphicon-plus"></i> <?php echo $lang->createNewStudy ?></button>

            <div class="form-group form-group-no-margin" style="margin-top: 20px">
                <div class="input-group">
                    <span class="input-group-addon">Filter</span>
                    <input class="form-control item-input-text show-dropdown text-center readonly" tabindex="-1" type="text" value="Alle"/>
                    <div class="input-group-btn select" id="filter" role="group">
                        <button class="btn btn-default btn-shadow btn-dropdown dropdown-toggle" type="button" data-toggle="dropdown" style="border-radius: 0px"><span class="chosen hidden" id="all"></span><span class="caret"></span></button>
                        <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                            <li id="all" class="selected"><a href="#">Alle</a></li>
                            <li id="elicitation"><a href="#">Ermittlung</a></li>
                            <li id="evaluation"><a href="#">Evaluierung</a></li>
                            <li id="unmoderated"><a href="#">Unmoderiet</a></li>
                            <li id="moderated"><a href="#">Moderiert</a></li>
                        </ul>
                    </div>
                    <span class="input-group-addon">Sortierung</span>
                    <input class="form-control item-input-text show-dropdown text-center readonly" tabindex="-1" type="text" value="Neueste zuerst"/>
                    <div class="input-group-btn select" id="sort" role="group">
                        <button class="btn btn-default btn-shadow btn-dropdown dropdown-toggle" type="button" data-toggle="dropdown"><span class="chosen hidden" id="newest"></span><span class="caret"></span></button>
                        <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                            <li class="dropdown-header">Datum</li>
                            <li id="oldest"><a href="#">Älteste zuerst</a></li>
                            <li id="newest"><a href="#">Neueste zuerst</a></li>
                            <li class="divider"></li>
                            <li class="dropdown-header">Titel</li>
                            <li id="asc"><a href="#">A bis Z</a></li>
                            <li id="desc"><a href="#">Z bis A</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="form-group form-group-margin-top">
                <div class="input-group">
                    <span class="input-group-addon">Suchen</span>
                    <input class="form-control item-input-text search search-input" id="searched-input" autocomplete="off" type="search" value="" placeholder="Suchbegriff eingeben"/>
                    <span class="input-group-addon">Einträge pro Seite</span>
                    <input class="form-control item-input-text show-dropdown text-center readonly" tabindex="-1" type="text" value="12"/>
                    <div class="input-group-btn select" id="resultsCountSelect" role="group">
                        <button class="btn btn-default btn-shadow btn-dropdown dropdown-toggle" type="button" data-toggle="dropdown"><span class="chosen hidden" id="results_12"></span><span class="caret"></span></button>
                        <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                            <li id="results_6"><a href="#">6</a></li>
                            <li id="results_12" class="selected"><a href="#">12</a></li>
                            <li id="results_48"><a href="#">48</a></li>
                            <li id="results_96"><a href="#">96</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div style="margin-top: 15px;" class="text-center">
                <span class="text">Was bedeuten die Farben?</span>
                <span style="margin-left: 10px"><i class="fa fa-minus" aria-hidden="true" style="color: #EEAC57"></i> <span class="text">Studie noch nicht gestartet</span></span>
                <span style="margin-left: 10px"><i class="fa fa-minus" aria-hidden="true" style="color: #5bc0de"></i> <span class="text">Studie läuft aktuell</span></span>
                <span style="margin-left: 10px"><i class="fa fa-minus" aria-hidden="true" style="color: #5cb85c"></i> <span class="text">Studie beendet</span></span>
                <span style="margin-left: 10px"><i class="fa fa-minus" aria-hidden="true" style="color: #d9534f"></i> <span class="text">Studie ohne Zeitplan</span></span>
            </div>

            <div class="text-center custom-pagination" id="custom-pager">
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

            <div class="alert-space alert-no-search-results"></div>
            <div class="alert-space alert-no-studies"></div>

        </div>

        <script>
            $(document).ready(function () {
                checkDomain();
                checkLanguage(function () {
                    var externals = new Array();
                    externals.push(['#alerts', PATH_EXTERNALS + '/' + currentLanguage + '/alerts.html']);
                    externals.push(['#templage-subpages', PATH_EXTERNALS + '/' + currentLanguage + '/template-sub-pages.html']);
                    loadExternals(externals);
                });
            });

            function onAllExternalsLoadedSuccessfully() {
                renderSubPageElements();

                getStudiesCatalog(function (result) {
                    if (result.status === RESULT_SUCCESS) {
//                        console.log(result.studies);
                        if (result.studies && result.studies.length > 0) {
                            originalFilterData = result.studies;
                            initPagination($('#custom-pager .pagination'), originalFilterData.length, parseInt($('#resultsCountSelect .chosen').attr('id').split('_')[1]));
                            $('#sort #newest').click();
                        } else {
                            appendAlert($('#item-view'), ALERT_NO_STUDIES);
                        }
                    }
                });
            }

            function renderData(data) {
                $('#list-container').empty();

                var index = parseInt($('#custom-pager .pagination').find('.active').text()) - 1;
                var listCount = parseInt($('#resultsCountSelect .chosen').attr('id').split('_')[1]);
                var viewFromIndex = index * listCount;
                var viewToIndex = Math.min((index + 1) * listCount, data.length);

                for (var i = viewFromIndex; i < viewToIndex; i++) {
                    var clone = getStudiesCatalogListThumbnail(data[i]);
                    $('#list-container').append(clone);
                    TweenMax.from(clone, .2, {delay: i * .03, opacity: 0, scaleX: 0.5, scaleY: 0.5});

                    $(clone).find('.panel').click({studyId: data[i].id}, function (event) {
                        event.preventDefault();
                        var hash = hex_sha512(parseInt(event.data.studyId) + '<?php echo $_SESSION['user_id'] . $_SESSION['forename'] . $_SESSION['surname'] ?>');
                        goto("study.php?studyId=" + event.data.studyId + "&h=" + hash);
                    });
                }
            }

            $('#filter').unbind('change').bind('change', function (event) {
                event.preventDefault();
                currentFilterData = sort();
                updatePaginationItems();
                renderData(currentFilterData);

                if ($('#searched-input').val().trim() !== "") {
                    $('#searched-input').trigger('keyup');
                }
            });

            $('#sort').unbind('change').bind('change', function (event) {
                event.preventDefault();
                currentFilterData = sort();
                updatePaginationItems();

                if ($('#searched-input').val().trim() !== "") {
                    $('#searched-input').trigger('keyup');
                }
            });

            $('#resultsCountSelect').unbind('change').bind('change', function (event, id) {
                event.preventDefault();
                currentFilterData = sort();
                updatePaginationItems();

                if ($('#searched-input').val().trim() !== "") {
                    $('#searched-input').trigger('keyup');
                }
            });

            $('#custom-pager .pagination').on('indexChanged', function (event, id) {
                event.preventDefault();
                if (!event.handled) {
                    event.handled = true;
                    renderData(sort());
                }
            });
        </script>
    </body>
</html>
