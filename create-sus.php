<?php
include './includes/language.php';
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" onclick="onCloseClick()">&times;</button>
    <h4 class="modal-title" id="exampleModalLabel">System Usability Scale</h4>
</div>
<div id="modal-body" class="modal-body">
    <div id="list-container"></div>

    <!--    <button type="button" class="btn btn-warning btn-shadow" id="btn-reset-origin-data"><span class="glyphicon glyphicon-repeat"></span> Original SUS wiederherstellen</button>
        <button type="button" class="btn btn-info btn-shadow pull-right" id="btn-add-sus-item"><span class="glyphicon glyphicon-plus"></span> Ein neues Item hinzufügen</button>-->

</div>
<div id="modal-footer" class="modal-footer">
    <button type="button" class="btn btn-default btn-shadow" data-dismiss="modal" onclick="onCloseClick()"><span class="glyphicon glyphicon-floppy-disk"></span> Speichern & Schließen</button>
</div>


<script type="text/javascript" src="js/template-create.js"></script>
<script>
        $(document).ready(function () {
            var originData = getLocalItem(STUDY_ORIGIN_SUS);
            var customData = getLocalItem(currentIdForModal + '.data');

            if (customData !== null) {
                renderData(customData);
            } else if (originData !== null) {
                renderData(originData);
            } else {
                alert("No predefined data there");
            }
        });

        $('.show-hole-text').tooltip({
            container: 'body',
            placement: "top"
        });


        function renderData(data) {
            var listContainer = $('#list-container');
            for (var i = 0; i < data.length; i++) {
                renderFormatItem(listContainer, data[i]);
//                updateBadges(listContainer, data[i].format);
            }
            checkCurrentListState(listContainer);
        }

//        function renderData(data) {
//            for (var i = 0; i < data.length; i++) {
//                var clone = $('#form-item-container').find('#sus').clone().removeAttr('id');
//                $(clone).appendTo('#list-container');
//                $(clone).addClass(data[i].dimension);
//                $(clone).find('.show-hole-text').attr('title', data[i].question);
//                $(clone).find('.item-input-text').attr('value', data[i].question);
//
//                if (data[i].reversed === true)
//                {
//                    $(clone).find('.switchButtonAddon #').click();
//                }
//            }
//
//            checkCurrentListState($('#list-container'));
//        }

        function saveData() {
            var itemList = $('#list-container').children();
            var questionnaire = new Array();
            for (var i = itemList.length; i--; ) {
                questionnaire.push(getFormatData(itemList[i]));
            }
            setLocalItem(currentIdForModal + '.data', questionnaire);
        }

//        function saveData() {
//            var customGUS = new Array();
//            var itemList = document.getElementById('list-container').childNodes;
//
//            for (var i = 0; i < itemList.length; i++) {
//                var item = itemList[i];
//                var question = $(item).find('.item-input-text').val();
//                var reversed = $(item).find('#yes').hasClass('active') ? true : false;
//                var dimension = getDimensionByElement($(item));
//                var gusItem = new UsabilityScaleItem(question, dimension, 5, reversed);
//                customGUS.push(gusItem);
//            }
//            setLocalItem(currentIdForModal + ".data", customGUS);
//        }

//        $('#btn-add-sus-item').on('click', function () {
//            var newItem = $('#form-item-container').find('#sus').clone();
//            $('#list-container').append(newItem);
//            checkCurrentListState($('#list-container'));
//        });
//
//        $('#btn-reset-origin-data').on('click', function () {
//            var data = getLocalItem(STUDY_ORIGIN_SUS);
//            if (data !== null) {
//                $('#list-container').empty();
//                renderData(data);
//            }
//            checkCurrentListState($('#list-container'));
//        });


</script>