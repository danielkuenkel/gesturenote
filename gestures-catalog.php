<?php
include './includes/language.php';
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

session_start();

if (login_check($mysqli) == false) {
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>GestureNote</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/general.css">
        <link rel="stylesheet" href="css/generalSubPages.css">
        <link rel="stylesheet" href="css/gesture.css">
        <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
        <link href="http://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
        <link href="http://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.5/TweenMax.min.js"></script>

        <script src="js/globalFunctions.js"></script>
        <script src="js/constants.js"></script>
        <script src="js/localforage.js"></script>
        <script src="js/storage.js"></script>
        <script src="js/storageFunctions.js"></script>
        <script src="js/language.js"></script>
        <script src="js/externals.js"></script>
        <script src="js/alert.js"></script>
        <script src="js/gotoPage.js"></script>       
        <script src="js/ajax.js"></script> 
        <script src="js/gesture.js"></script>
        <script src="js/joint-selection.js"></script>

        <!-- gesture recorder sources -->
        <script src="https://cdn.WebRTC-Experiment.com/RecordRTC.js"></script>
        <script src="https://cdn.webrtc-experiment.com/gumadapter.js"></script>
        <script src="https://cdn.webrtc-experiment.com/RecordRTC/Whammy.js"></script>
    </head>
    <body id="pageBody" data-spy="scroll" data-target=".navbar" data-offset="60">

        <!-- externals -->
        <div id="alerts"></div>
        <div id="templage-subpages"></div>
        <div id="template-gesture-recorder"></div>

        <!-- Modal -->
        <div id="custom-modal" class="modal fade custom-modal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content root">
                </div>
            </div>
        </div>


        <div class="root col-xs-6 col-sm-4 col-lg-3 hidden" id="gestures-catalog-thumbnail">
            <div class="panel panel-default btn-shadow">
                <div class="panel-heading" style=" text-overflow:ellipsis; white-space:nowrap; overflow: hidden;">
                    <span class="title-text ellipsis" style="position: relative; top: 1px;"></span>
                </div>

                <div class="panel-body">
                    <div class="previewGesture"></div>
                    <div class="text-center hidden gestureControls">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="glyphicon glyphicon-play"></i></button>
                            <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="glyphicon glyphicon-stop"></i></button>
                            <button type="button" class="btn btn-default" id="btn-step-backward-gesture"><i class="glyphicon glyphicon-step-backward"></i></button>
                            <button type="button" class="btn btn-default" id="btn-step-forward-gesture"><i class="glyphicon glyphicon-step-forward"></i></button>
                        </div>
                    </div>
                    <span class="label label-default" id="gesture-source"></span>
                    <span class="label label-default" id="gesture-scope"></span>
                </div>
                <div class="panel-footer">
                    <div class="btn-group btn-group-justified">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-info" id="btn-share-gesture"><i class="fa" aria-hidden="true"></i> <span class="btn-text"></span></button>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default" id="btn-show-gesture-info">Mehr</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Container (Breadcrump) -->
        <div class="container" id="breadcrumb">
            <div class="row">
                <ol class="breadcrumb">
                    <li><a class="breadcrump-btn" id="btn-index">Home</a></li>
                    <li><a class="breadcrump-btn" id="btn-dashboard">Dashboard</a></li>
                    <li class="active">Gestenkatalog</li>
                </ol>
            </div>
        </div>

        <!-- Container (Landing Section) -->
        <div class="container-fluid text-center bg-grey">
            <div class="container">
                <h1><i class="fa fa-sign-language" style="font-size: 60pt" aria-hidden="true"></i> GESTENKATALOG</h1>
                <p>Hier werden alle Gesten, die veröffentlicht wurden angezeigt. Zusätzlich werden hier auch die Gesten aufgelistet, die für eine Studie aufgezeichnet wurden, sei es vom Studien-Ersteller oder von einer Testperson. Private Gesten, z.B. von anderen Moderatoren werden dagegen nicht aufgelistet.</p>
                <p>Von anderen Moderatoren veröffentlichte Gesten können bewertet werden. Des Weiteren gibt es die Möglichkeit, über die Geste zu diskutieren.</p>
            </div>
        </div>

        <div class="container mainContent" style="margin-top: 35px;" id="item-view">

            <button type="button" class="btn btn-success btn-block btn-lg btn-shadow" id="btn-record-gesture"><i class="fa fa-video-camera" aria-hidden="true"></i> <span class="btn-text">Neue Geste aufzeichnen</span></button>

            <div class="form-group form-group-no-margin" style="margin-top: 20px">
                <div class="input-group">
                    <span class="input-group-addon">Filter</span>
                    <input class="form-control item-input-text show-dropdown text-center readonly" tabindex="-1" type="text" value="Alle"/>
                    <div class="input-group-btn select" id="filterGestures" role="group">
                        <button class="btn btn-default btn-shadow btn-dropdown dropdown-toggle" type="button" data-toggle="dropdown" style="border-radius: 0px"><span class="chosen hidden" id="all"></span><span class="caret"></span></button>
                        <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                            <li id="all" class="selected"><a href="#">Alle</a></li>
                            <li id="recorded"><a href="#">Eigene Aufgezeichnete</a></li>
                            <li id="tester"><a href="#">Tester</a></li>
                            <li id="public"><a href="#">Öffentlich</a></li>
                        </ul>
                    </div>
                    <span class="input-group-addon">Sortierung</span>
                    <input class="form-control item-input-text show-dropdown text-center readonly" tabindex="-1" type="text" value="Neueste zuerst"/>
                    <div class="input-group-btn select" id="sortGestures" role="group">
                        <button class="btn btn-default btn-shadow btn-dropdown dropdown-toggle" type="button" data-toggle="dropdown"><span class="chosen hidden" id="newest"></span><span class="caret"></span></button>
                        <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                            <li class="dropdown-header">Datum</li>
                            <li id="oldest"><a href="#">Älteste zuerst</a></li>
                            <li id="newest"><a href="#">Neueste zuerst</a></li>
                            <li class="divider"></li>
                            <li class="dropdown-header">Gestentitel</li>
                            <li id="asc"><a href="#">A bis Z</a></li>
                            <li id="desc"><a href="#">Z bis A</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="form-group form-group-margin-top">
                <div class="input-group">
                    <span class="input-group-addon">Suchen</span>
                    <input class="form-control item-input-text search gesture-search-input" id="searched-input" autocomplete="off" type="search" value="" placeholder="Suchbegriff eingeben"/>
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


            <div class="text-center custom-pagination" id="gesture-pager">
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
            <div class="alert-space alert-no-gestures"></div>
        </div>

    </div>

    <script>
        $(document).ready(function () {
            checkLanguage(function () {
                var externals = new Array();
                var path = PATH_EXTERNALS + '/' + currentLanguage;
                externals.push(['#alerts', path + '/alerts.html']);
                externals.push(['#templage-subpages', path + '/template-sub-pages.html']);
                externals.push(['#template-gesture-recorder', path + '/template-gesture-recorder.html']);
                loadExternals(externals);
            });
        });

        function onAllExternalsLoadedSuccessfully() {
            renderSubPageElements();

            getGestureCatalog(function (result) {
                if (result.status === RESULT_SUCCESS) {
                    currentModalId = GESTURE_CATALOG;
                    if (result.gestures && result.gestures.length > 0) {
                        $('#sortGestures #newest').click();
                    } else {
                        appendAlert($('#item-view'), ALERT_NO_GESTURES);
                    }
                }
            });
        }

        function renderData(data) {
            currentGestureSet = data;
            initPagination($('#gesture-pager .pagination'), data.length, parseInt($('#resultsCountSelect .chosen').attr('id').split('_')[1]));
            updateView();
        }

        function updateView() {
            $('#list-container').empty();

            var index = parseInt($('#gesture-pager .pagination').find('.active').text()) - 1;
            var listCount = parseInt($('#resultsCountSelect .chosen').attr('id').split('_')[1]);
            var viewFromIndex = index * listCount;
            var viewToIndex = Math.min((index + 1) * listCount, currentGestureSet.length);

            var count = 0;
            for (var i = viewFromIndex; i < viewToIndex; i++) {
                var clone = getGestureCatalogListThumbnail(currentGestureSet[i]);
                $('#list-container').append(clone);
                TweenMax.from(clone, .2, {delay: count * .03, opacity: 0, scaleX: 0.5, scaleY: 0.5});
                count++;
            }
        }

        $('#filterGestures').unbind('change').bind('change', function (event) {
            event.preventDefault();
            renderData(sortGestures());

            if ($('#searched-input').val().trim() !== "") {
                $('#searched-input').trigger('keyup');
            }
        });

        $('#sortGestures').unbind('change').bind('change', function (event) {
            event.preventDefault();
            renderData(sortGestures());

            if ($('#searched-input').val().trim() !== "") {
                $('#searched-input').trigger('keyup');
            }
        });

        $('#resultsCountSelect').unbind('change').bind('change', function (event) {
            event.preventDefault();
            renderData(currentGestureSet);

            if ($('#searched-input').val().trim() !== "") {
                $('#searched-input').trigger('keyup');
            }
        });

        $('#gesture-pager .pagination').on('indexChanged', function (event, index) {
            event.preventDefault();
            if (!event.handled) {
                event.handled = true;
                updateView();
            }
        });

        $('#btn-record-gesture').unbind('click').bind('click', function (event) {
            event.preventDefault();
            loadHTMLintoModal('custom-modal', 'create-gesture-recorder.html', 'modal-md');

            $('#custom-modal').unbind('gestureSavedSuccessfully').bind('gestureSavedSuccessfully', function (event, gestureId) {
                getGestureCatalog(function (result) {
                    if (result.status === RESULT_SUCCESS) {
                        currentGestureSet = result.gestures;
                        $('#sortGestures #newest').removeClass('selected');
                        $('#sortGestures #newest').click();
                    }
                });
            });
        });
    </script>

</body>
</html>