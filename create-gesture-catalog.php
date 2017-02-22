<?php
include './includes/language.php';
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" onclick="onCloseClick()">&times;</button>
    <!--<h4 class="modal-title" id="exampleModalLabel">Gestenset zusammenstellen</h4>-->

    <!-- Nav tabs -->
    <ul class="nav nav-pills text-center" id="custom-tab-nav">
        <li role="presentation" class="active"><a href="#study-gesture-set" aria-controls="study-gesture-set" role="tab" data-toggle="pill">Studien-Gesten-Set</a></li>
        <li role="presentation"><a href="#gesture-catalog" aria-controls="gesture-catalog" role="tab" data-toggle="pill">Gesten-Katalog</a></li>
        <li role="presentation"><a href="#gesture-sets" aria-controls="gesture-sets" role="tab" data-toggle="pill">Gesten-Sets</a></li>
    </ul>
</div>
<div id="modal-body" class="modal-body">

    <!-- Tab panes -->
    <div class="tab-content">

        <div role="tabpanel" class="tab-pane active" id="study-gesture-set">
            <div id="item-view">
                <div class="panel-group">
                    <div class="form-group form-group-no-margin">
                        <div class="input-group">
                            <span class="input-group-addon">Filter</span>
                            <input class="form-control item-input-text show-dropdown text-center readonly" tabindex="-1" type="text" value="Alle"/>
                            <div class="input-group-btn select filter" id="filter" role="group">
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
                            <div class="input-group-btn select sort" id="sort" role="group">
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
                            <input class="form-control item-input-text search search-input save-data" id="searched-input" autocomplete="off" type="search" value="" placeholder="Suchbegriff eingeben"/>
                            <span class="input-group-addon">Einträge pro Seite</span>
                            <input class="form-control item-input-text show-dropdown text-center readonly" tabindex="-1" type="text" value="16"/>
                            <div class="input-group-btn select resultsCountSelect" id="resultsCountSelect" role="group">
                                <button class="btn btn-default btn-shadow btn-dropdown dropdown-toggle" type="button" data-toggle="dropdown"><span class="chosen hidden" id="results_16"></span><span class="caret"></span></button>
                                <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                                    <li id="results_8"><a href="#">8</a></li>
                                    <li id="results_16" class="selected"><a href="#">16</a></li>
                                    <li id="results_40"><a href="#">40</a></li>
                                    <li id="results_100"><a href="#">100</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center custom-pagination" id="pager-top">
                    <nav>
                        <ul class="pagination pagination-custom" itemprop="clipping_2">
                            <li id="btn-first-page"><a href="#" aria-label="First"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>
                            <li id="btn-previous-page"><a href="#" aria-label="Previous"><i class="fa fa-angle-left" aria-hidden="true"></i></a></li>
                            <li id="btn-next-page"><a href="#" aria-label="Next"><i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
                            <li id="btn-last-page"><a href="#" aria-label="Last"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
                        </ul>
                    </nav>
                </div>


                <div class="panel-group container-root row root" id="study-gestures-item-container" style="margin-top: 10px;"></div>

                <div class="alert-space alert-no-search-results"></div>

                <div class="text-center custom-pagination" id="pager-bottom">
                    <nav>
                        <ul class="pagination pagination-custom" itemprop="clipping_2">
                            <li id="btn-first-page"><a href="#" aria-label="First"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>
                            <li id="btn-previous-page"><a href="#" aria-label="Previous"><i class="fa fa-angle-left" aria-hidden="true"></i></a></li>
                            <li id="btn-next-page"><a href="#" aria-label="Next"><i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
                            <li id="btn-last-page"><a href="#" aria-label="Last"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
                        </ul>
                    </nav>
                </div>

            </div>

        </div>

        <div role="tabpanel" class="tab-pane" id="gesture-catalog">
            <div id="item-view">
                <div class="panel-group">
                    <div class="form-group form-group-no-margin">
                        <div class="input-group">
                            <span class="input-group-addon">Filter</span>
                            <input class="form-control item-input-text show-dropdown text-center readonly" tabindex="-1" type="text" value="Alle"/>
                            <div class="input-group-btn select filter" id="filter" role="group">
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
                            <div class="input-group-btn select sort" id="sort" role="group">
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
                            <input class="form-control item-input-text search search-input save-data" id="searched-input" autocomplete="off" type="search" value="" placeholder="Suchbegriff eingeben"/>
                            <span class="input-group-addon">Einträge pro Seite</span>
                            <input class="form-control item-input-text show-dropdown text-center readonly" tabindex="-1" type="text" value="16"/>
                            <div class="input-group-btn select resultsCountSelect" id="resultsCountSelect" role="group">
                                <button class="btn btn-default btn-shadow btn-dropdown dropdown-toggle" type="button" data-toggle="dropdown"><span class="chosen hidden" id="results_16"></span><span class="caret"></span></button>
                                <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                                    <li id="results_8"><a href="#">8</a></li>
                                    <li id="results_16" class="selected"><a href="#">16</a></li>
                                    <li id="results_40"><a href="#">40</a></li>
                                    <li id="results_100"><a href="#">100</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center custom-pagination" id="pager-top">
                    <nav>
                        <ul class="pagination pagination-custom" itemprop="clipping_2">
                            <li id="btn-first-page"><a href="#" aria-label="First"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>
                            <li id="btn-previous-page"><a href="#" aria-label="Previous"><i class="fa fa-angle-left" aria-hidden="true"></i></a></li>
                            <li id="btn-next-page"><a href="#" aria-label="Next"><i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
                            <li id="btn-last-page"><a href="#" aria-label="Last"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
                        </ul>
                    </nav>
                </div>


                <div class="panel-group container-root row root" id="gesture-catalog-item-container" style="margin-top: 10px;"></div>

                <div class="alert-space alert-no-search-results"></div>

                <div class="text-center custom-pagination" id="pager-bottom">
                    <nav>
                        <ul class="pagination pagination-custom" itemprop="clipping_2">
                            <li id="btn-first-page"><a href="#" aria-label="First"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>
                            <li id="btn-previous-page"><a href="#" aria-label="Previous"><i class="fa fa-angle-left" aria-hidden="true"></i></a></li>
                            <li id="btn-next-page"><a href="#" aria-label="Next"><i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
                            <li id="btn-last-page"><a href="#" aria-label="Last"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
                        </ul>
                    </nav>
                </div>

            </div>
        </div>

        <div role="tabpanel" class="tab-pane" id="gesture-sets">
            Gesten-Sets
        </div>

    </div>
</div>
<div id="modal-footer" class="modal-footer">
    <button type="button" class="btn btn-default btn-shadow" data-dismiss="modal" onclick="onCloseClick()"><span class="glyphicon glyphicon-floppy-disk"></span> <?php echo $lang->saveAndClose ?></button>
</div>


<!--<script type="text/javascript" src="js/template-create.js"></script>-->
<script>
    $(document).ready(function () {
        $('#custom-modal').bind('hidden.bs.modal', function () {
            updateCatalogButtons();
            $(this).unbind('hidden.bs.modal');
        });
        $('#custom-tab-nav #study-gesture-set').click();
    });
    function renderData(data) {
        currentFilterData = data;
        var container = $('#gesture-catalog-item-container');
        var activeTab = $('#custom-tab-nav').find('.active').find('a').attr('href');
        if (activeTab === '#study-gesture-set') {
            container = $('#study-gestures-item-container');
        }

        $(container).empty();
        var index = parseInt($('#custom-pager-top .pagination').find('.active').text()) - 1;
        var listCount = parseInt($('#resultsCountSelect .chosen').attr('id').split('_')[1]);
        var viewFromIndex = index * listCount;
        var viewToIndex = Math.min((index + 1) * listCount, currentFilterData.length);
        var count = 0;
        for (var i = viewFromIndex; i < viewToIndex; i++) {
            var isGestureAss = isGestureAssembled(currentFilterData[i].id);
            var clone = getCreateStudyGestureListThumbnail(currentFilterData[i], 'favorite-gesture-catalog-thumbnail', 'col-xs-6 col-md-3', null, isGestureAss && activeTab !== '#study-gesture-set' ? 'panel-success' : null);
            $(container).append(clone);
            TweenMax.from(clone, .2, {delay: count * .03, opacity: 0, scaleX: 0.5, scaleY: 0.5});
            count++;
            if (isGestureAss) {
                clone.find('#btn-tag-as-favorite-gesture').addClass('selected btn-success');
            }
        }
    }

//    function saveData() {
//        var activeTab = $('#custom-tab-nav').find('.active').find('a').attr('href');
//        switch (activeTab) {
//            case '#study-gesture-set':
//
//                break;
//            case '#gesture-catalog':
//                console.log('activeTab', activeTab);
//                var currentGestures = $('#gesture-catalog-item-container').children();
//
//                for (var j = 0; j < currentGestures.length; j++) {
//                    var gestureItem = currentGestures[j];
//                    var id = parseInt($(gestureItem).attr('id'));
//                    if ($(gestureItem).hasClass('selected') && !isGestureAssembled(id)) {
//                        assembleGesture(id);
//                    } else if (!$(gestureItem).hasClass('selected') && isGestureAssembled(id)) {
//                        reassembleGesture(id);
//                    }
//                }
//                break;
//        }
//    }

    $('.filter').unbind('change').bind('change', function (event) {
        event.preventDefault();
//        saveData();
        currentFilterData = sort();
        updatePaginationItems($('#custom-pager-top .pagination'));
        renderData(currentFilterData);
        if ($('#searched-input').val().trim() !== "") {
            $('#searched-input').trigger('keyup');
        }
    });
    $('.sort').unbind('change').bind('change', function (event) {
        event.preventDefault();
//        saveData();
        currentFilterData = sort();
        updatePaginationItems($('#custom-pager-top .pagination'));
        if ($('#searched-input').val().trim() !== "") {
            $('#searched-input').trigger('keyup');
        }
    });
    $('.resultsCountSelect').unbind('change').bind('change', function (event) {
        event.preventDefault();
//        saveData();
        currentFilterData = sort();
        updatePaginationItems($('#custom-pager-top .pagination'));
        if ($('#searched-input').val().trim() !== "") {
            $('#searched-input').trigger('keyup');
        }
    });
    $('body').on('indexChanged', '.pagination', function (event, index) {
        event.preventDefault();
        if (!event.handled) {
            event.handled = true;
//            saveData();
            renderData(sort());
        }
    });
    $('#custom-tab-nav').on('hide.bs.tab', function (event) {
//        console.log('target', event.target, event.relatedTarget);
        console.log($(event.relatedTarget).attr('href'));
//        saveData();
        switch ($(event.relatedTarget).attr('href')) {
            case '#study-gesture-set':
                getStudyGestures();
                break;
            case '#gesture-catalog':
                getWholeGestureCatalog();
                break;
            case '#gesture-sets':
                break;
        }
    });
    
    function getStudyGestures() {
        currentFilterList = $('#study-gestures-item-container');
        originalFilterData = assembledGestures();
        var data = {
            pager: {
                top: $('#study-gesture-set').find('#pager-top .pagination'),
                bottom: $('#study-gesture-set').find('#pager-bottom .pagination'),
                dataLength: originalFilterData.length,
                maxElements: parseInt($('#study-gesture-set').find('#resultsCountSelect .chosen').attr('id').split('_')[1])
            },
            filter: {
                countSelect: $('#study-gesture-set').find('#resultsCountSelect')
            }
        };
        initPagination(data);
        $('#study-gesture-set').find('#sort #newest').click();
        
        $('#study-gestures-item-container').unbind('change').bind('change', function (event, gestureId, assemble) {
            console.log('study gestures changed', gestureId);
        });
    }

    function getWholeGestureCatalog() {
        currentFilterList = $('#gesture-catalog-item-container');
        getGestureCatalog(function (result) {
            if (result.status === RESULT_SUCCESS) {
                originalFilterData = result.gestures;

                var data = {
                    pager: {
                        top: $('#gesture-catalog').find('#pager-top .pagination'),
                        bottom: $('#gesture-catalog').find('#pager-bottom .pagination'),
                        dataLength: originalFilterData.length,
                        maxElements: parseInt($('#study-gesture-set').find('#resultsCountSelect .chosen').attr('id').split('_')[1])
                    },
                    filter: {
                        countSelect: $('#gesture-catalog').find('#resultsCountSelect')
                    }
                };
                initPagination(data);
                $('#gesture-catalog').find('#sort #newest').click();

//                initPagination($('#custom-pager-top .pagination'), originalFilterData.length, parseInt($('#resultsCountSelect .chosen').attr('id').split('_')[1]));
//                initPagination($('#custom-pager-bottom .pagination'), originalFilterData.length, parseInt($('#resultsCountSelect .chosen').attr('id').split('_')[1]));
//                $('#sort #newest').click();
            }
        });
        $('#gesture-catalog-item-container').unbind('change').bind('change', function (event, gestureId, assemble) {
            event.preventDefault();
            if (assemble) {
                assembleGesture(gestureId);
            } else {
                reassembleGesture(gestureId);
            }
        });
    }
</script>