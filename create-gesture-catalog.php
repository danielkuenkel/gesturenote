<?php
include './includes/language.php';
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" onclick="onCloseClick()">&times;</button>
    <!--<h4 class="modal-title" id="exampleModalLabel">Gestenset zusammenstellen</h4>-->

    <!-- Nav tabs -->
    <ul class="nav nav-pills text-center" id="custom-tap-nav">
        <li role="presentation" class="active"><a href="#study-gesture-set" aria-controls="study-gesture-set" role="tab" data-toggle="pill">Zusammengestelltest Gesten-Set</a></li>
        <li role="presentation"><a href="#gesture-catalog" aria-controls="gesture-catalog" role="tab" data-toggle="pill">Gesten-Katalog</a></li>
        <li role="presentation"><a href="#gesture-sets" aria-controls="gesture-sets" role="tab" data-toggle="pill">Gesten-Sets</a></li>
    </ul>
</div>
<div id="modal-body" class="modal-body">

    <!-- Tab panes -->
    <div class="tab-content">

        <div role="tabpanel" class="tab-pane active" id="study-gesture-set">
            Studien-Gesten-Set
        </div>

        <div role="tabpanel" class="tab-pane" id="gesture-catalog">
            <div id="item-view">
                <div class="panel-group">
                    <div class="form-group form-group-no-margin">
                        <div class="input-group">
                            <span class="input-group-addon">Filter</span>
                            <input class="form-control item-input-text show-dropdown text-center readonly" tabindex="-1" type="text" value="Alle"/>
                            <div class="input-group-btn select" id="filter" role="group">
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
                            <div class="input-group-btn select" id="sort" role="group">
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
                            <div class="input-group-btn select" id="resultsCountSelect" role="group">
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

                <div class="text-center custom-pagination" id="custom-pager-top">
                    <nav>
                        <ul class="pagination pagination-custom" itemprop="clipping_2">
                            <li id="btn-first-page"><a href="#" aria-label="First"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>
                            <li id="btn-previous-page"><a href="#" aria-label="Previous"><i class="fa fa-angle-left" aria-hidden="true"></i></a></li>
                            <li id="btn-next-page"><a href="#" aria-label="Next"><i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
                            <li id="btn-last-page"><a href="#" aria-label="Last"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
                        </ul>
                    </nav>
                </div>


                <div class="panel-group container-root row root" id="list-container" style="margin-top: 10px;"></div>

                <div class="alert-space alert-no-search-results"></div>

                <div class="text-center custom-pagination" id="custom-pager-bottom">
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

        $('#custom-tap-nav #study-gesture-set').click();
    });

    function renderData(data) {
        currentFilterData = data;
        $('#list-container').empty();

        var index = parseInt($('#custom-pager-top .pagination').find('.active').text()) - 1;
        var listCount = parseInt($('#resultsCountSelect .chosen').attr('id').split('_')[1]);
        var viewFromIndex = index * listCount;
        var viewToIndex = Math.min((index + 1) * listCount, currentFilterData.length);
        var count = 0;

        for (var i = viewFromIndex; i < viewToIndex; i++) {
            //            var clone = getGestureListThumbnail(currentFilterData[i]);
            //            $('#list-container').append(clone);
            //
            //            if (isGestureAssembled(currentFilterData[i].id)) {
            //                clone.find('.gesture-assemble').click();
            //            }

            var clone = getCreateStudyGestureListThumbnail(currentFilterData[i], 'favorite-gesture-catalog-thumbnail', 'col-xs-6 col-md-3');
            $('#list-container').append(clone);
            TweenMax.from(clone, .2, {delay: count * .03, opacity: 0, scaleX: 0.5, scaleY: 0.5});
            count++;
        }
    }

    function saveData() {
        var currentGestures = $('#list-container').children();

        for (var j = 0; j < currentGestures.length; j++) {
            var gesture = currentGestures[j];
            var id = parseInt($(gesture).attr('id'));
            if ($(gesture).hasClass('selected') && !isGestureAssembled(id)) {
                assembleGesture(id);
            } else if (!$(gesture).hasClass('selected') && isGestureAssembled(id)) {
                reassembleGesture(id);
            }
        }
    }

    $('#filter').unbind('change').bind('change', function (event) {
        event.preventDefault();

        saveData();
        currentFilterData = sort();
        updatePaginationItems();
        renderData(currentFilterData);

        if ($('#searched-input').val().trim() !== "") {
            $('#searched-input').trigger('keyup');
        }
    });

    $('#sort').unbind('change').bind('change', function (event) {
        event.preventDefault();

        saveData();
        currentFilterData = sort();
        updatePaginationItems();

        if ($('#searched-input').val().trim() !== "") {
            $('#searched-input').trigger('keyup');
        }
    });

    $('#resultsCountSelect').unbind('change').bind('change', function (event) {
        event.preventDefault();

        saveData();
        currentFilterData = sort();
        updatePaginationItems();

        if ($('#searched-input').val().trim() !== "") {
            $('#searched-input').trigger('keyup');
        }
    });

    $('body').on('indexChanged', '.pagination', function (event, index) {
        event.preventDefault();
        if (!event.handled) {
            event.handled = true;
            saveData();
            renderData(sort());
        }
    });

    $('#custom-tap-nav').on('shown.bs.tab', function (event) {
        console.log('target', event.target, event.relatedTarget);
        console.log($(event.target).attr('href'));
        switch($(event.target).attr('href')) {
            case '#gesture-catalog':
                getWholeGestureCatalog();
                break;
        }
    });

    function getWholeGestureCatalog() {
        currentFilterList = $('#list-container');
        getGestureCatalog(function (result) {
            if (result.status === RESULT_SUCCESS) {
                originalFilterData = result.gestures;
                initPagination($('#custom-pager-top .pagination'), originalFilterData.length, parseInt($('#resultsCountSelect .chosen').attr('id').split('_')[1]));
//                initPagination($('#custom-pager-bottom .pagination'), originalFilterData.length, parseInt($('#resultsCountSelect .chosen').attr('id').split('_')[1]));
                $('#sort #newest').click();
            }
        });
    }
</script>