<?php
include './includes/language.php';
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" onclick="onCloseClick()">&times;</button>
    <h4 class="modal-title" id="exampleModalLabel">Zustands-Katalog <i class="fa fa-info-circle" for="studyDescription" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->createStudyInfos->catalogs->text3 ?>"></i></h4>
</div>
<div id="modal-body" class="modal-body">
    <div class="container-root" id="list-container"></div>
</div>
<hr style="margin: 0;">
<div id="modal-body" class="modal-body">

    <!--        <div class="form-group form-group-no-margin">
                <div class="input-group">
                    <span class="input-group-addon">Zustands-Format</span>
                    <input class="form-control item-input-text show-dropdown text-center readonly" type="text" value="Bitte wählen"/>
                    <div class="input-group-btn select dropup" id="addFormatSelect" role="group">
                        <button class="btn btn-default btn-shadow btn-dropdown" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                        <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                            <li id="pidoco"><a href="#">Pidoco</a></li>
                            <li id="web"><a href="#">Webseite</a></li>
                            <li id="image"><a href="#">Bild</a></li>
                            <li id="video"><a href="#">Video</a></li>
                            <li id="videoEmbed"><a href="#">Videoeinbettung</a></li>
                        </ul>
                        <button class="btn btn-info btn-shadow disabled dropdown-disabled" id="addFormat" type="button"><span class="glyphicon glyphicon-plus"></span></button>
                    </div>
                </div>
            </div>-->

    <span class="text">Um einen Zustand für die Verwendung z.B. in einer Szenario-basierten Aufgabe oder einem Gesten-Training hinzuzufügen, klick Sie auf das entsprechende Format. Es wird ein Element hinzugefügt, welches anschließend noch bearbeitet werden muss.</span>
    <div class="add-button-group" id="add-scenes-button-group">
        <div class="btn-group">
            <div class="btn btn-info btn-add-item font-bold" id="web">
                <i class="fa fa-plus"></i> <?php echo $lang->sceneTypes->web ?> 
                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Hinterlegen Sie URL's von Webseiten, um …"></i>
            </div>
        </div>
        <div class="btn-group">
            <div class="btn btn-info btn-add-item font-bold" id="image">
                <i class="fa fa-plus"></i> <?php echo $lang->sceneTypes->image ?>
                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Hinterlegen Sie Bilder von Prototypen, die Sie testen wollen. Achten Sie auf das Format (Hochformat oder Querformat) abhängig von ihrem Anwendungsfall."></i>
            </div>
        </div>
        <div class="btn-group">
            <div class="btn btn-info btn-add-item font-bold" id="videoEmbed">
                <i class="fa fa-plus"></i> <?php echo $lang->sceneTypes->videoEmbed ?>
                <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="Binden Sie jedes Video von YouTube oder Vimeo in ihre Studie ein. Hinterlegen Sie dazu die Einbettungs-URL"></i>
            </div>
        </div>
    </div>
</div>
<div id="modal-footer" class="modal-footer">
    <button type="button" class="btn btn-default btn-shadow" data-dismiss="modal" onclick="onCloseClick()"><span class="glyphicon glyphicon-floppy-disk"></span> Speichern & Schließen</button>
</div>


<!--<script type="text/javascript" src="js/template-create.js"></script>-->
<script>
    $(document).ready(function () {
        closeClicked = false;
        $('[data-toggle="popover"]').popover({container: 'body', delay: {"show": 300, "hide": 0}});

        var data = getLocalItem(ASSEMBLED_SCENES);
        if (data !== null) {
            renderData(data);
        }

        $('#custom-modal').bind('hidden.bs.modal', function () {
            updateCatalogButtons();
            $('#list-container').empty();
            $(this).unbind('hidden.bs.modal');
        });
    });

    $('#custom-modal').on('hide.bs.modal', function (event) {
        if (!event.handled && closeClicked) {
            closeClicked = false;
            event.handled = true;

            var items = $('#list-container').children();
            var hasTitles = true;
            for (var i = 0; i < items.length; i++) {
                var item = items[i];
                var title = $(item).find('.title').val();

                if (title.trim() === '') {
                    if ($(item).find('.alert-' + ALERT_NO_TITLE).children().length === 0) {
                        appendAlert($(item).closest('.root'), ALERT_NO_TITLE);
                        $(item).find('.title').closest('.form-group').addClass('has-error');
                    }
                    hasTitles = false;
                }
            }

            if (!hasTitles) {
                event.preventDefault();
                event.stopImmediatePropagation();
                return false;
            }

            $(this).unbind('hide.bs.modal');
        }
    });

    function renderData(data) {
        for (var i = 0; i < data.length; i++) {
            var item = data[i];
            var clone = $('#form-item-container').find('#' + item.type).clone();
            clone.find('.title').val(item.title);
            clone.attr('name', item.id);
            $('#list-container').append(clone);
            updateBadges($('#list-container'), item.type);

            switch (item.type) {
                case SCENE_PIDOCO:
                    if (item.data[0]) {
                        $(clone).find('.pidoco-edit-url').val(item.data[0]);
                        $(clone).find('.checkPidocoEditURL').click();
                    }
                    if (item.data[1]) {
                        $(clone).find('.pidoco-embed-url').val(item.data[1]);
                        $(clone).find('.checkPidocoEmbedURL').click();
                    }
                    if (item.data[2] === true) {
                        $(clone).find('.transmit-gestures-select .switchButtonAddon').click();
                        $(clone).find('#transmitGestures').removeClass('hidden');
                    }
                    break;
                case SCENE_WEB:
                    $(clone).find('.website-url').val(item.data[0]);
                    break;
                case SCENE_IMAGE:
                    if (item.data) {
                        $(clone).find('.imageAreaContent').attr("src", item.data);
                        $(clone).find('.imageArea').removeClass('hidden');
                        $(clone).find('.chooseSceneImage .btn-text').text('Anderes Bild auswählen');
                        $(clone).find('.chooseSceneImage .btn-icon').removeClass('glyphicon-picture');
                        $(clone).find('.chooseSceneImage .btn-icon').addClass('glyphicon-refresh');
                    }
                    break;
                case SCENE_VIDEO_EMBED:
                    if (item.data[0]) {
                        $(clone).find('.video-embed-url').val(item.data[0]);
                        $(clone).find('.checkVideoEmbedURL').click();
                        $(clone).find('.ratioSelect #' + item.options[0]).click();
                    }
                    break;
            }
        }

        checkCurrentListState($('#list-container'));
    }

    function saveData() {
        var assembledData = new Array();
        var items = $('#list-container').children();
        for (var i = 0; i < items.length; i++) {
            var item = items[i];
            var type = $(item).attr('id');
            var name = $(item).attr('name');
            var title = $(item).find('.title').val();
            var options = new Array();
            var data = new Array();

            if (name === undefined || name === null) {
                name = chance.natural();
            }

            switch (type) {
                case SCENE_PIDOCO:
                    var pidocoEditUrl = $(item).find('.pidoco-edit-url').val();
                    if (urlIsValid(pidocoEditUrl, TYPE_URL_PIDOCO_EDIT)) {
                        data.push(pidocoEditUrl);
                    } else {
                        data.push(null);
                    }
                    var pidocoEmbedUrl = $(item).find('.pidoco-embed-url').val();
                    if (urlIsValid(pidocoEmbedUrl, TYPE_URL_PIDOCO_EMBED)) {
                        data.push(pidocoEmbedUrl);
                    } else {
                        data.push(null);
                    }

                    options.push($(item).find('.transmit-gestures-select #success').hasClass('active'));

                    break;
                case SCENE_WEB:
                    data.push($(item).find('.website-url').val());
                    break;
                case SCENE_IMAGE:
                    if ($(item).find('.imageArea').hasClass('hidden') !== true) {
                        data = $(item).find('.imageAreaContent').attr('src');
                    }
                    break;
                case SCENE_VIDEO_EMBED:
                    var videoEmbedUrl = $(item).find('.video-embed-url').val();
                    options.push($(item).find('.ratioSelect .chosen').attr('id'));
                    if (urlIsValid(videoEmbedUrl, TYPE_URL_VIDEO_EMBED)) {
                        data.push(videoEmbedUrl);
                    } else {
                        data.push(null);
                    }
                    break;
            }

            if (data.length > 0) {
                assembledData.push({id: name, type: type, title: title, options: options, data: data});//new Scene(name, type, title, options, data));
            }
        }
        setLocalItem(ASSEMBLED_SCENES, assembledData);
    }

    $('.transmit-gestures-select .check').unbind('click').bind('click', function () {
        var aGestures = assembledGestures();
        if (aGestures && $(this).closest('.root').find('.transmit-gestures-select #success').hasClass('inactive')) {
            $(this).closest('.root').find('#transmitGestures').removeClass('hidden');
        } else {
            $(this).closest('.root').find('#transmitGestures').addClass('hidden');
        }
    });

    $('body').on('click', '#transmitGestures', function (event) {
        if (event.handled !== true)
        {
            event.handled = true;
            console.log('transmit gestures clicked');
        }
    });

    $('#modal-body .add-button-group').unbind('change').bind('change', function (event) {
        var itemType = $(event.target).attr('id');
        var clone = $('#form-item-container').find('#' + itemType).clone();
        clone.attr('name', itemType);

        var listContainer = $(this).closest('.root').find('#list-container');
        var tweenTarget = listContainer.children().last();
        if(!tweenTarget || (tweenTarget && tweenTarget.length === 0)) {
            TweenMax.to($(event.target), .3, {y: '-=120', opacity: 0, clearProps: 'all', ease: Quad.easeIn, onComplete: onMoveComplete, onCompleteParams: [clone, listContainer, itemType]});
            return null;
        }
        
        var tweenTargetOffset = $(tweenTarget).offset();
        var tweenElementOffset = $(event.target).offset();
        var tweenOffset = {offsetY: tweenTargetOffset.top - tweenElementOffset.top + tweenTarget.height(), offsetX: tweenTargetOffset.left - tweenElementOffset.left};
        var alphaY = tweenOffset.offsetY < 0 ? '' + tweenOffset.offsetY : '+' + tweenOffset.offsetY;
        var alphaX = tweenOffset.offsetX < 0 ? '' + tweenOffset.offsetX : '+' + tweenOffset.offsetX;
        TweenMax.to($(event.target), .3, {x: alphaX, y: alphaY, opacity: 0, clearProps: 'all', ease: Quad.easeIn, onComplete: onMoveComplete, onCompleteParams: [clone, listContainer, itemType]});
    });


    function onMoveComplete(clone, listContainer, itemType) {
        $(listContainer).append(clone);
        checkCurrentListState(listContainer);
        updateBadges($('#modal-body #list-container'), itemType);

        TweenMax.from(clone, 1, {y: -40, opacity: 0, ease: Elastic.easeOut, clearProps: 'all'});
        $(listContainer).trigger('listItemAdded');
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