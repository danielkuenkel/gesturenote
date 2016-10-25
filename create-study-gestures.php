<?php
include './includes/language.php';
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" onclick="onCloseClick()">&times;</button>
    <h4 class="modal-title" id="exampleModalLabel">Studien-Gesten-Set</h4>
</div>
<div id="modal-body" class="modal-body">

    <div id="item-view">
        <div class="panel-group">
            <div class="form-group">
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
                    <input class="form-control item-input-text show-dropdown text-center readonly" tabindex="-1" type="text" value="Bitte wählen"/>
                    <div class="input-group-btn select" id="sort" role="group">
                        <button class="btn btn-default btn-shadow btn-dropdown dropdown-toggle" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
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
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon">Suchen</span>
                    <input class="form-control item-input-text search search-input save-data" id="searched-input" autocomplete="off" type="search" value="" placeholder="Suchbegriff eingeben"/>
                    <span class="input-group-addon">Einträge pro Seite</span>
                    <input class="form-control item-input-text show-dropdown text-center readonly" tabindex="-1" type="text" value="10"/>
                    <div class="input-group-btn select" id="resultsCountSelect" role="group">
                        <button class="btn btn-default btn-shadow btn-dropdown dropdown-toggle" type="button" data-toggle="dropdown"><span class="chosen hidden" id="results_10"></span><span class="caret"></span></button>
                        <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                            <li id="results_10" class="selected"><a href="#">10</a></li>
                            <li id="results_50"><a href="#">50</a></li>
                            <li id="results_100"><a href="#">100</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center custom-pagination" id="custom-pager">
            <nav>
                <ul class="pagination pagination-custom" itemprop="clipping_2">
                    <li id="btn-first-page"><a href="#" aria-label="First"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>
                    <li id="btn-previous-page"><a href="#" aria-label="Previous"><i class="fa fa-angle-left" aria-hidden="true"></i></a></li>
                    <li id="btn-next-page"><a href="#" aria-label="Next"><i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
                    <li id="btn-last-page"><a href="#" aria-label="Last"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
                </ul>
            </nav>
        </div>


        <div class="panel-group container-root root" id="list-container" style="margin-top: 10px;"></div>

        <div class="alert-space alert-no-search-results"></div>
    </div>

</div>
<div id="modal-footer" class="modal-footer">
    <button type="button" class="btn btn-default btn-shadow" data-dismiss="modal" onclick="onCloseClick()"><span class="glyphicon glyphicon-floppy-disk"></span> Speichern & Schließen</button>
</div>


<!--<script type="text/javascript" src="js/template-create.js"></script>-->
<script>
        function saveData() {
            updateCatalogButtons();
        }

        function renderData(data) {
            currentFilterData = data;
            $('#list-container').empty();

            if (currentFilterData && currentFilterData.length > 0) {
                var index = parseInt($('#custom-pager .pagination').find('.active').text()) - 1;
                var listCount = parseInt($('#resultsCountSelect .chosen').attr('id').split('_')[1]);
                var viewFromIndex = index * listCount;
                var viewToIndex = Math.min((index + 1) * listCount, currentFilterData.length);
                for (var i = viewFromIndex; i < viewToIndex; i++) {
                    var clone = getGestureListThumbnailPreview(currentFilterData[i]);
                    if(clone !== null) {
                        $('#list-container').append(clone);
                    }
                    
                    if (isGestureAssembled(currentFilterData[i].id)) {
                        clone.find('.gesture-assemble').click();
                    }
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

        $(document).ready(function () {
            currentFilterList = $('#list-container');
            var data = assembledGestures();
            if (data) {
                originalFilterData = data;
                initPagination($('#custom-pager .pagination'), originalFilterData.length, parseInt($('#resultsCountSelect .chosen').attr('id').split('_')[1]));
                $('#sort #newest').click();
            }

            $('#custom-modal').bind('hidden.bs.modal', function () {
                updateCatalogButtons();
                $(this).unbind('hidden.bs.modal');
            });
        });
</script>