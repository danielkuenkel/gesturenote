<!DOCTYPE html>
<html lang="en">
    <head>
        <title>GestureNote</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/general.css">
        <link rel="stylesheet" href="css/generalSubPages.css">
        <link rel="stylesheet" href="css/projects.css">
        <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
        <link href="http://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
        <link href="http://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.5/TweenMax.min.js"></script>

        <script src="js/constants.js"></script>
        <script src="js/alert.js"></script>
        <script src="js/externals.js"></script>
        <script src="js/language.js"></script>
        <script src="js/gotoPage.js"></script>
        <script src="js/ajax.js"></script>
        <script src="js/globalFunctions.js"></script>
    </head>
    <body id="pageBody" data-spy="scroll" data-target=".navbar" data-offset="60">

        <!-- externals -->
        <div id="alerts"></div>
        <div id="templage-subpages"></div>

        <!-- thumbnail -->
        <div class="root col-xs-12 col-sm-6 col-lg-4 hidden" id="studies-catalog-thumbnail">
            <div class="panel panel-default btn-shadow">
                <div class="panel-heading" style="text-overflow:ellipsis; white-space:nowrap; overflow: hidden;">
                    <span class="title-text ellipsis" style="position: relative; top: 1px;"></span>
                </div>

                <div class="panel-body">
                    <span class="label label-default" id="gesture-source"></span>
                    <span class="label label-default" id="gesture-scope"></span>
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
                    <li><a class="breadcrump-btn" id="btn-index">Home</a></li>
                    <li><a class="breadcrump-btn" id="btn-dashboard">Dashboard</a></li>
                    <li class="active">Studien</li>
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

            <button type="button" class="btn btn-success btn-lg btn-block" onclick="gotoCreateProject()"><i class="glyphicon glyphicon-plus"></i> Eine neue Studie erstellen</button>

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
                        console.log(result.studies);
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
                console.log(data);

                var index = parseInt($('#custom-pager .pagination').find('.active').text()) - 1;
                var listCount = parseInt($('#resultsCountSelect .chosen').attr('id').split('_')[1]);
                var viewFromIndex = index * listCount;
                var viewToIndex = Math.min((index + 1) * listCount, data.length);

                var count = 0;
                for (var i = viewFromIndex; i < viewToIndex; i++) {
                    var clone = getStudiesCatalogListThumbnail(data[i]);
                    $('#list-container').append(clone);
                    TweenMax.from(clone, .2, {delay: count * .03, opacity: 0, scaleX: 0.5, scaleY: 0.5});
                    count++;
                }
            }

            $('#filter').unbind('change').bind('change', function (event) {
                event.preventDefault();
                console.log('filter changed');
                renderData(sort());

                if ($('#searched-input').val().trim() !== "") {
                    $('#searched-input').trigger('keyup');
                }
            });

            $('#sort').unbind('change').bind('change', function (event) {
                event.preventDefault();
                console.log('sort changed');
                renderData(sort());

                if ($('#searched-input').val().trim() !== "") {
                    $('#searched-input').trigger('keyup');
                }
            });

            $('#resultsCountSelect').unbind('change').bind('change', function (event) {
                event.preventDefault();
                renderData(sort());

                if ($('#searched-input').val().trim() !== "") {
                    $('#searched-input').trigger('keyup');
                }
            });

            $('#custom-pager .pagination').on('indexChanged', function (event, index) {
                event.preventDefault();
                if (!event.handled) {
                    event.handled = true;
                    renderData(sort());
                }
            });


            var currentGesturePreviewId = null;
            var gesturePreviewOpened = false;
            function getStudiesCatalogListThumbnail(data) {
                console.log(data);
                var clone = $('#studies-catalog-thumbnail').clone().removeClass('hidden').removeAttr('id');
                clone.attr('id', data.id);
                clone.find('.title-text').text(data.data.name);

//                if (data.isOwner === true) {
//                    if (data.source !== SOURCE_GESTURE_TESTER) {
//                        clone.find('#gesture-source').text(translation.gestureSources[SOURCE_GESTURE_RECORDED]);
//                    } else {
//                        clone.find('#gesture-source').text(translation.gestureSources[data.source]);
//                    }
//                }
//                clone.find('#gesture-scope').text(translation.gestureScopes[data.scope]);
//
//                renderGestureImages(clone.find('.previewGesture'), data.images, data.previewImage, null);
//
//                $(clone).find('.panel').mouseenter(function (event) {
//                    event.preventDefault();
//                    if (gesturePreviewOpened === false) {
//                        playThroughThumbnails($(this).find('.previewGesture'), 0);
//                    }
//                });
//
//                $(clone).find('.panel').mouseleave(function (event) {
//                    event.preventDefault();
//                    if (gesturePreviewOpened === false) {
//                        resetThumbnails($(this).find('.previewGesture'));
//                    }
//                });
//
//                $(clone).find('#btn-show-gesture-info').click({gestureId: data.id, clone: clone}, function (event) {
//                    event.preventDefault();
//                    resetThumbnails($(event.data.clone).find('.previewGesture'));
//                    currentGesturePreviewId = event.data.gestureId;
//                    gesturePreviewOpened = true;
//                    $(clone).find('#btn-stop-gesture').click();
//                    loadHTMLintoModal('custom-modal', 'gestures-catalog-preview.html', 'modal-lg');
//                });
//
//                if (data.isOwner) {
//                    var shareButton = $(clone).find('#btn-share-gesture');
//                    if (data.scope === SCOPE_GESTURE_PRIVATE) {
//                        shareButton.removeClass('unshare-gesture').addClass('share-gesture');
//                        shareButton.find('.fa').removeClass('fa-lock').addClass('fa-share-alt');
//                        shareButton.find('.btn-text').text(translation.share);
//                    } else {
//                        shareButton.removeClass('share-gesture').addClass('unshare-gesture');
//                        shareButton.find('.fa').removeClass('fa-share-alt').addClass('fa-lock');
//                        shareButton.find('.btn-text').text(translation.unshare);
//                    }
//                } else {
//                    $(clone).find('#btn-share-gesture').parent().remove();
//                }
//
//                $(clone).find('#btn-share-gesture').click({gestureId: data.id}, function (event) {
//                    event.preventDefault();
//                    if (!$(this).hasClass('disabled')) {
//                        $(this).addClass('disabled');
//                        var button = $(this);
//
//                        if ($(this).hasClass('share-gesture')) {
//                            showCursor($('body'), CURSOR_PROGRESS);
//                            shareGesture({gestureId: event.data.gestureId}, function (result) {
//                                showCursor($('body'), CURSOR_DEFAULT);
//                                $(button).removeClass('disabled');
//                                if (result.status === RESULT_SUCCESS) {
//                                    $(button).removeClass('share-gesture').addClass('unshare-gesture');
//                                    $(button).find('.fa').removeClass('fa-share-alt').addClass('fa-lock');
//                                    $(button).find('.btn-text').text(translation.unshare);
//                                    clone.find('#gesture-scope').text(translation.gestureScopes[SCOPE_GESTURE_PUBLIC]);
//                                    getGestureCatalog(function (result) {
//                                        if (result.status === RESULT_SUCCESS) {
//                                            currentGestureSet = sort();
//                                        }
//                                    });
//                                }
//                            });
//                        } else if ($(this).hasClass('unshare-gesture')) {
//                            showCursor($('body'), CURSOR_PROGRESS);
//                            unshareGesture({gestureId: event.data.gestureId}, function (result) {
//                                showCursor($('body'), CURSOR_DEFAULT);
//                                $(button).removeClass('disabled');
//                                if (result.status === RESULT_SUCCESS) {
//                                    $(button).removeClass('unshare-gesture').addClass('share-gesture');
//                                    $(button).find('.fa').removeClass('fa-lock').addClass('fa-share-alt');
//                                    $(button).find('.btn-text').text(translation.share);
//                                    clone.find('#gesture-scope').text(translation.gestureScopes[SCOPE_GESTURE_PRIVATE]);
//                                    getGestureCatalog(function (result) {
//                                        if (result.status === RESULT_SUCCESS) {
//                                            currentGestureSet = sort();
//                                        }
//                                    });
//                                }
//                            });
//                        }
//                    }
//                });
//
//                $(clone).find('#btn-unshare-gesture').click(function (event) {
//                    event.preventDefault();
//                    if (!$(this).hasClass('disabled')) {
//                        $(this).addClass('disabled');
//                    }
//                });

                return clone;
            }

        </script>
    </body>
</html>
