<?php
include './includes/language.php';
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" onclick="onCloseClick()">&times;</button>
    <h4 class="modal-title" id="exampleModalLabel">Funktions-Set zusammenstellen</h4>
</div>
<div id="modal-body" class="modal-body">

    <div class="root" id="list-container"></div>

</div>
<div id="modal-footer" class="modal-footer">
    <button type="button" class="btn btn-default btn-shadow" data-dismiss="modal" onclick="onCloseClick()"><span class="glyphicon glyphicon-floppy-disk"></span> Speichern & Schließen</button>
</div>


<!--<script type="text/javascript" src="js/template-create.js"></script>-->
<script>
    $(document).ready(function () {
        var trigger = $('#form-item-container #trigger').clone();
        $('#list-container').append(trigger);

        var data = getLocalItem(ASSEMBLED_TRIGGER);
        if (data !== null) {
            renderData(data);
        }

        $('#custom-modal').bind('hidden.bs.modal', function () {
            updateCatalogButtons();
            $(this).unbind('hidden.bs.modal');
        });
    });

    function renderData(data) {
        for (var i = 0; i < data.length; i++) {
            var clone = $('#triggerItem').clone().removeClass('hidden');
            clone.find('.option').val(data[i].title);
            var id = parseInt(data[i].id);
            clone.attr('id', data[i].type + '_' + id);
            $('#list-container').find('.option-container').append(clone);
        }
        checkCurrentListState($('#list-container').find('.option-container'));
    }

    function saveData() {
        var trigger = new Array();
        var elements = $('#list-container').find('.option-container').children();
        for (var i = 0; i < elements.length; i++) {
            var triggerId;
            var element = elements[i];
            if ($(element).attr('id') !== undefined) {
                var splitId = $(element).attr('id').split('_');
                if (splitId[0] === TYPE_TRIGGER) {
                    triggerId = splitId[1];
                }
            } else {
                triggerId = chance.natural();
            }
            trigger.push({id: triggerId, type: TYPE_TRIGGER, title: $(elements[i]).find('.option').val()});//new Trigger(triggerId, TYPE_TRIGGER, $(elements[i]).find('.option').val()));
        }
        setLocalItem(ASSEMBLED_TRIGGER, trigger);
    }

    $('#modal-body #list-container').unbind('listItemAdded').bind('listItemAdded', function (event) {
        event.preventDefault();
        var scrollTarget = $(this).closest('.modal');
        var newScrollTop = Math.max(0, scrollTarget.find('.modal-content').height() - scrollTarget.height() + 60);
        $(scrollTarget).animate({
            scrollTop: newScrollTop
        }, 200);
    });
</script>