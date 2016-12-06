<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Gesten-Vorschau</h4>
</div>
<div id="modal-body" class="modal-body">

    <div class="row">
        <div class="col-md-5">
            <div class="previewGesture mouseScrollable btn-shadow autoplay"></div>
            <div class="progress gesture-progress">
                <div class="progress-bar gesture-progress-bar progress-bar-success" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
            </div>
            <div class="text-center">
                <div class="btn-group">
                    <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="glyphicon glyphicon-play"></i></button>
                    <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="glyphicon glyphicon-stop"></i></button>
                    <button type="button" class="btn btn-default" id="btn-step-backward-gesture"><i class="glyphicon glyphicon-step-backward"></i></button>
                    <button type="button" class="btn btn-default" id="btn-step-forward-gesture"><i class="glyphicon glyphicon-step-forward"></i></button>
                </div>
            </div>
            <hr>
            <div class="gesture-rating" id="gesture-rating" style="margin-top: 20px; margin-bottom: 30px">
                <h3><i class="fa fa-star-o"></i> Bewertung</h3>
                <div class="rating-container rating-physicalContext row" id="rating-physicalContext">
                    <div class="col-xs-4 col-sm-3 col-md-5 rating-stars-container"></div>
                    <div class="col-xs-8 col-sm-9 col-md-7 rating-headling"><span class="address"></span> <span class="text">Gestentyp für Kontext stimmig? (z.B. Ganzkörper-Geste für Arbeitsplatz stimmig?)</span></div>
                </div>
                <div class="rating-container rating-adaption row" id="rating-adaption">
                    <div class="col-xs-4 col-sm-3 col-md-5 rating-stars-container"></div>
                    <div class="col-xs-8 col-sm-9 col-md-7 rating-headling"><span class="address"></span> <span class="text">Kontext-Adaption (Könnte die Geste auch woanders eingesetzt werden?)</span></div>
                </div>
                <div class="rating-container rating-fittingTask row" id="rating-fittingTask">
                    <div class="col-xs-4 col-sm-3 col-md-5 rating-stars-container"></div>
                    <div class="col-xs-8 col-sm-9 col-md-7 rating-headling"><span class="address"></span> <span class="text">Passt die Geste zur beschriebenen Aufgabe?</span></div>
                </div>
                <div id="rating-infos">
                    <span id="rated-by"></span> <span id="rating-users-count"></span> <span id="rated-by-users"></span>
                    <div class="alert-space alert-rating-submitted" style="margin-top: 10px;"></div>
                </div>
                <button type="button" class="btn btn-block btn-warning" id="btn-rate-gesture" style="margin-top: 10px;">Geste bewerten</button>
                <div class="btn-group-vertical btn-block hidden" id="rating-submit-buttons" style="margin-top: 0px;">
                    <button type="button" class="btn btn-success" id="btn-submit-gesture-rating">Bewertung abgeben</button>
                    <button type="button" class="btn btn-danger" id="btn-cancel-gesture-rating">Abbrechen</button>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <h3 style="margin-top: 0"><i class="fa fa-bookmark-o"></i> Allgemeines</h3>
            <div id="gesture-data-preview">
                <div id="title">Titel:<span class="address"></span> <span class="text"></span></div>
                <div id="created"><span class="address">Erstellt:</span> <span class="text"></span></div>
                <div id="context">Kontext:<span class="address"></span> <span class="text"></span></div>
                <div id="description">Beschreibung:<span class="address"></span> <span class="text"></span></div>

                <span class="label label-default" id="gesture-source"><i class="fa fa-globe hidden" id="tester"></i><i class="fa fa-video-camera hidden" id="own"></i><i class="fa fa-globe hidden" id="evaluator"></i> <span class="label-text"></span></span>
                <span class="label label-default" id="gesture-scope"><i class="fa fa-lock hidden" id="private"></i><i class="fa fa-share-alt hidden" id="public"></i> <span class="label-text"></span></span>

                <div class="preview-joints-humand-body" id="human-body" style="width: 400px; margin: auto; margin-top: 10px">
                    <div id="joint-container" style="position: absolute"></div>
                    <img src="img/human_body.svg">
                </div>
            </div>

            <div id="gesture-data-edit" class="hidden">
                <div class="alert-space alert-missing-fields"></div>

                <div class="form-group">
                    <label>Gesten-Name</label>
                    <input type="text" class="form-control" id="gesture-name-input" required>
                </div>
                <div class="form-group">
                    <label>Gesten-Kontext</label>
                    <input type="text" class="form-control" placeholder="Wo soll die Geste eingesetzt werden?" id="gesture-context-input" required>
                </div>
                <div class="form-group">
                    <label>Gesten-Beschreibung</label>
                    <textarea class="form-control" id="gesture-description-input" rows="3" maxlength="500" required></textarea>
                </div>

                <div class="form-group">
                    <label>Welche Teile des Körpers werden für die Geste genutzt?</label>
                    <div class="select-joints-humand-body" id="select-joints-human-body" style="width: 400px; margin: auto; margin-top: 10px">
                        <div id="joint-container" style="position: absolute"></div>
                        <img src="img/human_body.svg">
                    </div>
                </div>
            </div>

            <div class="btn-group-vertical btn-block" style="margin-top: 20px" id="gesture-owner-controls">
                <button type="button" class="btn btn-default gesture-previewable" id="btn-edit-gesture"><i class="fa fa-pencil" aria-hidden="true"></i> <span class="btn-text"></span></button>
                <button type="button" class="btn btn-info" id="btn-share-gesture"><i class="fa" aria-hidden="true"></i> <span class="btn-text"></span></button>
                <button type="button" class="btn btn-danger" id="btn-delete-gesture"><i class="fa fa-trash" aria-hidden="true"></i> <span class="btn-text">Geste löschen</span></button>
            </div>

        </div>
    </div>
</div>

<hr style="margin: 0; padding: 0">

<div id="discussion-body" class="modal-body">
    <h3 style="margin-bottom: 20px"><i class="fa fa-comments-o" aria-hidden="true"></i> Mitreden</h3>

    <div class="row">
        <div class="col-md-5">
            <div class="form-group">
                <textarea class="form-control" id="comment" rows="4" maxlength="500" placeholder="Kommentar einfügen" required></textarea>
            </div>
            <button type="button" class="btn btn-default btn-block" id="btn-comment-gesture"><i class="fa fa-commenting" aria-hidden="true"></i> <span class="btn-text">Kommentar abschicken</span></button>
        </div>
        <div class="col-md-7">
            <div class="alert-space alert-no-comments"></div>
            <div id="comments-list"></div>
        </div>
    </div>

</div>

<div class="hidden panel panel-default panel-sm" id="gesture-comment-item" style="margin-top: 0px; margin-bottom: 8px">
    <div class="panel-heading" style="font-size: 10pt">
        <span id="user"><i class="fa fa-comment" aria-hidden="true"></i> <span class="text"></span></span>
        <span id="created" class="pull-right"><i class="fa fa-clock-o" aria-hidden="true"></i> <span class="text"></span></span>
    </div>
    <div class="panel-body" style="color: #303030; font-size: 10pt"></div>
    <div class="panel-footer">
        <button class="btn btn-xs btn-danger" id="btn-delete-comment">Kommentar löschen</button>
    </div>
</div>

<div id="modal-footer" class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Schließen</button>
</div>

<script>
    var testRatings = [{physicalContext: 1, adaption: 0, fittingTask: 3}, {physicalContext: 0, adaption: 3, fittingTask: 4}, {physicalContext: 2, adaption: 0, fittingTask: 3}, {physicalContext: 2, adaption: 2, fittingTask: 3}, {physicalContext: 2, adaption: 1, fittingTask: 1}];
    var currentRatings = [{physicalContext: 0, adaption: 0, fittingTask: 0}];
    $(document).ready(function () {
        initGestureRating($('#gesture-rating'), 5);
        renderModalData(currentGesturePreviewId);
//        renderGestureRating($('#gesture-rating'), testRatings, true); //result.ratings);

        $('#custom-modal').bind('hidden.bs.modal', function () {
            currentGesturePreviewId = null;
            gesturePreviewOpened = false;
            $(this).unbind('hidden.bs.modal');
        });
    });


    $(document).on('mouseleave', '.rating-stars-container', function (event) {
        event.preventDefault();
        if ($(this).find('.active').length === 0) {
            $(this).find('.btn-gesture-rating-clickable .fa').removeClass('fa-star').addClass('fa-star-o');
        } else {
            $(this).find('.active').find('.fa').removeClass('fa-star-o').addClass('fa-star');
            $(this).find('.active').prevAll().find('.fa').removeClass('fa-star-o').addClass('fa-star');
            $(this).find('.active').nextAll().find('.fa').removeClass('fa-star').addClass('fa-star-o');
        }
    });

    $(document).on('mouseenter', '.btn-gesture-rating-clickable', function (event) {
        event.preventDefault();
        $(this).prevAll().find('.fa').removeClass('fa-star-o').addClass('fa-star');
        $(this).find('.fa').removeClass('fa-star-o').addClass('fa-star');
        $(this).nextAll().find('.fa').removeClass('fa-star').addClass('fa-star-o');
    });

    $(document).on('click', '.btn-gesture-rating-clickable', function (event) {
        event.preventDefault();
        if (!event.handled) {
            event.handled = true;
            $(this).addClass('active');
            $(this).prevAll().removeClass('active');
            $(this).prevAll().find('.fa').removeClass('fa-star-o').addClass('fa-star');
            $(this).find('.fa').removeClass('fa-star-o').addClass('fa-star');
            $(this).nextAll().removeClass('active');
            $(this).nextAll().find('.fa').removeClass('fa-star').addClass('fa-star-o');
        }
    });

    $('#btn-rate-gesture').on('click', function (event) {
        event.preventDefault();
        if (!event.handled && !$(this).hasClass('disabled')) {
            $(this).addClass('hidden');
            $(this).closest('.gesture-rating').find('#rating-submit-buttons').removeClass('hidden');
            $(this).closest('.gesture-rating').find('.btn-gesture-rating .fa').removeClass('fa-star-half-full fa-star').addClass('fa-star-o');
            $(this).closest('.gesture-rating').find('.btn-gesture-rating').addClass('btn-gesture-rating-clickable');
        }
    });

    $('#btn-cancel-gesture-rating').on('click', function (event) {
        event.preventDefault();
        if (!event.handled && !$(this).hasClass('disabled')) {
            $(this).closest('.gesture-rating').find('#rating-submit-buttons').addClass('hidden');
            $(this).closest('.gesture-rating').find('#btn-rate-gesture').removeClass('hidden');
            $(this).closest('.gesture-rating').find('.btn-gesture-rating').removeClass('btn-gesture-rating-clickable active');
            renderGestureRating($(this).closest('.gesture-rating'), currentRatings, false);
        }
    });

    $('#btn-submit-gesture-rating').on('click', function (event) {
        event.preventDefault();
        if (!event.handled && !$(this).hasClass('disabled')) {
            event.handled = true;
            var activeStars = $(this).closest('.gesture-rating').find('.active');
            var container = $(this).closest('.gesture-rating').find('.rating-container');
            var button = $(this);

            if (activeStars.length === container.length) {
                $(button).addClass('disabled');
                $(this).closest('.gesture-rating').find('#btn-cancel-gesture-rating').addClass('disabled');
                $(this).closest('.gesture-rating').find('.btn-gesture-rating').removeClass('btn-gesture-rating-clickable');
                var ratings = {};

                for (var i = 0; i < container.length; i++) {
                    var id = $(container[i]).attr('id').split('-')[1];
                    var rating = $(container[i]).find('.active').index();
                    ratings[id] = rating;
                }

                submitRatingForGesture({gestureId: currentGesturePreviewId, ratings: ratings}, function (result) {
                    $(button).removeClass('disabled');
                    $(button).closest('.gesture-rating').find('#btn-cancel-gesture-rating').removeClass('disabled');

                    if (result.status === RESULT_SUCCESS) {
                        $(button).closest('.gesture-rating').find('#btn-rate-gesture').remove();
                        $(button).closest('.gesture-rating').find('#rating-submit-buttons').addClass('hidden');
                        $(button).closest('.gesture-rating').find('.btn-gesture-rating').removeClass('btn-gesture-rating-clickable active');
                        renderGestureRating($(button).closest('.gesture-rating'), result.ratings, true);
                        appendAlert($('#gesture-rating'), ALERT_RATING_SUBMITTED);
                    }
                });
            }
        }
    });

    function initGestureRating(target, totalStars) {
        for (var i = 0; i < totalStars; i++) {
            var ratingButton = document.createElement('div');
            $(ratingButton).addClass('btn-gesture-rating');
            var emptyStar = document.createElement('i');
            $(emptyStar).addClass('fa fa-star-o');
            $(ratingButton).append(emptyStar);
            $(target).find('.rating-stars-container').append(ratingButton);
        }

        $('#rated-by').text(translation.ratedBy);
    }

    function renderGestureRating(target, ratings, newData) {
        if (newData) {
            $('#rating-users-count').text(ratings !== null ? ratings.length : 0);
            if (ratings === null) {
                $('#rated-by-users').text(translation.ratedByUsers);
            } else {
                $('#rated-by-users').text(ratings.length === 1 ? translation.ratedByUser : translation.ratedByUsers);
            }

            ratings = calculateRatings(ratings);
        }

        currentRatings = ratings;
//        console.log()

        if (ratings) {
            for (var key in ratings) {
                var value = parseFloat(ratings[key]) + 1;
                var viewValue;
                if (value % .5 === 0) {
                    viewValue = value;
                } else if ((value % 1 >= .25 && value % 1 < .5) || (value % 1 <= .75 && value % 1 > .5)) {
                    viewValue = Math.floor(value) + .5;
                } else {
                    viewValue = Math.round(value);
                }

                var container = $(target).find('.rating-' + key + ' .rating-stars-container');
                var fullStars = parseInt(Math.abs(viewValue));
                var hasHalfStar = viewValue % 1 === .5;
                var nthStar = container.find(".btn-gesture-rating:nth-child(" + fullStars + ")");
                $(nthStar).prevAll().find('.fa').removeClass('fa-star-o').addClass('fa-star');
                $(nthStar).find('.fa').removeClass('fa-star-o').addClass('fa-star');
                $(nthStar).nextAll().find('.fa').removeClass('fa-star').addClass('fa-star-o');

                if (hasHalfStar) {
                    $(nthStar).next().find('.fa').removeClass('fa-star-o').addClass('fa-star-half-full');
                }
            }
        }
    }

    function calculateRatings(ratingsArray) {
        var ratings = {physicalContext: 0, adaption: 0, fittingTask: 0};
        if (ratingsArray && ratingsArray.length > 0) {
            for (var key in ratings) {
                for (var i = 0; i < ratingsArray.length; i++) {
                    var currentRating = ratings[key];
                    ratings[key] = currentRating + parseInt(ratingsArray[i].ratings[key]);
                }
                ratings[key] = ratings[key] / ratingsArray.length;
            }
            return ratings;
        }
        return null;
    }

    function renderModalData() {
        var gesture = getGestureById(currentGesturePreviewId);
        if (gesture === null) {
            return false;
        }

        var container = $('#modal-body');
        container.find('#title .text').text(gesture.title);
        container.find('#created .text').text(convertSQLTimestampToDate(gesture.created).toLocaleString());
        container.find('#context .text').text(gesture.context);
        container.find('#description .text').text(gesture.description);
        container.find('#btn-edit-gesture .btn-text').text(translation.edit);
        container.find('#btn-delete-gesture .btn-text').text(translation.deleteGesture);
        container.find('#gesture-scope .label-text').text(translation.gestureScopes[gesture.scope]);
        container.find('#gesture-scope #' + gesture.scope).removeClass('hidden');
        var shareButton = $(container).find('#btn-share-gesture');

        if (gesture.isOwner === true) {
            $(container).find('#gesture-rating #btn-rate-gesture').remove();

            if (gesture.scope === SCOPE_GESTURE_PRIVATE) {
                shareButton.removeClass('unshare-gesture').addClass('share-gesture');
                shareButton.find('.fa').removeClass('fa-lock').addClass('fa-share-alt');
                shareButton.find('.btn-text').text(translation.share);
            } else {
                shareButton.removeClass('share-gesture').addClass('unshare-gesture');
                shareButton.find('.fa').removeClass('fa-share-alt').addClass('fa-lock');
                shareButton.find('.btn-text').text(translation.unshare);
            }

            if (gesture.source !== SOURCE_GESTURE_TESTER) {
                container.find('#gesture-source .label-text').text(translation.gestureSources[SOURCE_GESTURE_OWN]);
                container.find('#gesture-source #' + SOURCE_GESTURE_OWN).removeClass('hidden');
            } else {
                container.find('#gesture-source .label-text').text(translation.gestureSources[SOURCE_GESTURE_TESTER]);
                container.find('#gesture-source #' + SOURCE_GESTURE_TESTER).removeClass('hidden');
            }
        } else {
            $(container).find('#gesture-owner-controls').remove();

            if (gesture.source !== SOURCE_GESTURE_TESTER) {
                container.find('#gesture-source .label-text').text(translation.gestureSources[SOURCE_GESTURE_EVALUATOR]);
                container.find('#gesture-source #' + SOURCE_GESTURE_EVALUATOR).removeClass('hidden');
            } else {
                container.find('#gesture-source .label-text').text(translation.gestureSources[SOURCE_GESTURE_TESTER]);
                container.find('#gesture-source #' + SOURCE_GESTURE_TESTER).removeClass('hidden');
            }
        }

        renderGestureImages(container.find('.previewGesture'), gesture.images, gesture.previewImage, null);
        renderBodyJointsPreview(container.find('#human-body'), gesture.joints);

        var thumbnail = $('#item-view #gestures-list-container').find('#' + currentGesturePreviewId);

        $(container).find('#btn-share-gesture').unbind('click').bind('click', {gestureId: gesture.id}, function (event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')) {
                $(this).addClass('disabled');
                var button = $(this);

                if ($(this).hasClass('share-gesture')) {
                    showCursor($('body'), CURSOR_PROGRESS);
                    shareGesture({gestureId: event.data.gestureId}, function (result) {
                        showCursor($('body'), CURSOR_DEFAULT);
                        $(button).removeClass('disabled');
                        if (result.status === RESULT_SUCCESS) {
                            $(button).removeClass('share-gesture').addClass('unshare-gesture');
                            $(button).find('.fa').removeClass('fa-share-alt').addClass('fa-lock');
                            $(button).find('.btn-text').text(translation.unshare);
                            $(container).find('#gesture-scope .label-text').text(translation.gestureScopes[SCOPE_GESTURE_PUBLIC]);
                            $(container).find('#gesture-scope .fa').addClass('hidden');
                            $(container).find('#gesture-scope #' + SCOPE_GESTURE_PUBLIC).removeClass('hidden');

                            $(thumbnail).find('#btn-share-gesture').removeClass('share-gesture').addClass('unshare-gesture');
                            $(thumbnail).find('#btn-share-gesture .fa').removeClass('fa-share-alt').addClass('fa-lock');
                            $(thumbnail).find('#btn-share-gesture .btn-text').text(translation.unshare);
                            $(thumbnail).find('#gesture-scope .label-text').text(translation.gestureScopes[SCOPE_GESTURE_PUBLIC]);
                            $(thumbnail).find('#gesture-scope .fa').addClass('hidden');
                            $(thumbnail).find('#gesture-scope #' + SCOPE_GESTURE_PUBLIC).removeClass('hidden');

                            updateGestureById(GESTURE_CATALOG, result.id, {scope: 'public'});
                            originalFilterData = getLocalItem(GESTURE_CATALOG);
                            currentFilterData = sort();
//                            getGestureCatalog(function (result) {
//                                if (result.status === RESULT_SUCCESS) {
//                                    originalFilterData = result.gestures;
////                                    currentFilterData = sort();
//                                }
//                            });
                        }
                    });
                } else if ($(this).hasClass('unshare-gesture')) {
                    showCursor($('body'), CURSOR_PROGRESS);
                    unshareGesture({gestureId: event.data.gestureId}, function (result) {
                        showCursor($('body'), CURSOR_DEFAULT);
                        $(button).removeClass('disabled');
                        if (result.status === RESULT_SUCCESS) {
                            $(button).removeClass('unshare-gesture').addClass('share-gesture');
                            $(button).find('.fa').removeClass('fa-lock').addClass('fa-share-alt');
                            $(button).find('.btn-text').text(translation.share);
                            $(container).find('#gesture-scope .label-text').text(translation.gestureScopes[SCOPE_GESTURE_PRIVATE]);
                            $(container).find('#gesture-scope .fa').addClass('hidden');
                            $(container).find('#gesture-scope #' + SCOPE_GESTURE_PRIVATE).removeClass('hidden');

                            $(thumbnail).find('#btn-share-gesture').removeClass('unshare-gesture').addClass('share-gesture');
                            $(thumbnail).find('#btn-share-gesture .fa').removeClass('fa-lock').addClass('fa-share-alt');
                            $(thumbnail).find('#btn-share-gesture .btn-text').text(translation.share);
                            $(thumbnail).find('#gesture-scope .label-text').text(translation.gestureScopes[SCOPE_GESTURE_PRIVATE]);
                            $(thumbnail).find('#gesture-scope .fa').addClass('hidden');
                            $(thumbnail).find('#gesture-scope #' + SCOPE_GESTURE_PRIVATE).removeClass('hidden');

                            updateGestureById(GESTURE_CATALOG, result.id, {scope: 'private'});
                            originalFilterData = getLocalItem(GESTURE_CATALOG);
                            currentFilterData = sort();
//                            getGestureCatalog(function (result) {
//                                if (result.status === RESULT_SUCCESS) {
//                                    originalFilterData = result.gestures;
////                                    currentFilterData = sort();
//                                }
//                            });
                        }
                    });
                }
            }
        });

        getGestureInfos({gestureId: gesture.id}, function (result) {
            if (result.status === RESULT_SUCCESS) {
                renderComments(result.comments);
                renderGestureRating($('#gesture-rating'), result.ratings, true);
                if (hasUserRatedGesture(result.userId, result.ratings)) {
                    $(container).find('#gesture-rating #btn-rate-gesture').remove();
                }
            }
        });

        $('#discussion-body #btn-comment-gesture').unbind('click').bind('click', function (event) {
            event.preventDefault();
            var comment = $('#discussion-body #comment').val().trim();
            if (comment !== '') {
                var button = $(this);
                $(button).addClass('disabled');
                showCursor($('body'), CURSOR_PROGRESS);
                submitCommentForGesture({gestureId: gesture.id, comment: comment}, function (result) {
                    showCursor($('body'), CURSOR_DEFAULT);
                    $(button).removeClass('disabled');
                    if (result.status === RESULT_SUCCESS) {
                        $('#discussion-body #comment').val('');
                        renderComments(result.comments);
                    }
                });
            }
        });

        $('#modal-body #btn-edit-gesture').unbind('click').bind('click', function (event) {
            event.preventDefault();
            var button = $(this);
            if ($(this).hasClass('gesture-editable')) {
                if (!$(this).hasClass('disabled') && inputsValid(true)) {

                    $(button).addClass('disabled');
                    showCursor($('body'), CURSOR_PROGRESS);
                    var title = $('#gesture-name-input').val().trim();
                    var context = $('#gesture-context-input').val().trim();
                    var description = $('#gesture-description-input').val().trim();
                    var joints = getSelectedJoints($('#select-joints-human-body #joint-container'));
                    updateGesture({gestureId: gesture.id, title: title, context: context, description: description, joints: joints}, function (result) {

                        showCursor($('body'), CURSOR_DEFAULT);
                        $(button).removeClass('disabled');
                        $('#modal-body #btn-delete-gesture, #modal-body #btn-share-gesture').removeClass('disabled');
                        if (result.status === RESULT_SUCCESS) {
                            updateGestureById(GESTURE_CATALOG, result.id, {title: result.title, context: result.context, description: result.description, joints: result.joints});
                            $(thumbnail).find('.title-text').text(title);
                            $(button).removeClass('gesture-editable').addClass('gesture-previewable');
                            $(button).find('.btn-text').text(translation.edit);
                            $('#modal-body #gesture-data-preview').removeClass('hidden');
                            $('#modal-body #gesture-data-edit').addClass('hidden');

//                            setLocalItem(GESTURE_CATALOG, result.gestures);
                            originalFilterData = getLocalItem(GESTURE_CATALOG);
//                            currentFilterData = sort();
                            renderModalData();
                        } else {
                            appendAlert($('#modal-body'), ALERT_GENERAL_ERROR);
                        }
                    });
                }
            } else {
                $(this).removeClass('gesture-previewable').addClass('gesture-editable');
                $(this).find('.btn-text').text(translation.gesturePreviewable);
                $('#modal-body #gesture-data-preview').addClass('hidden');
                $('#modal-body #gesture-data-edit').removeClass('hidden');
                $('#modal-body #btn-delete-gesture, #modal-body #btn-share-gesture').addClass('disabled');
                $('#gesture-name-input').val(gesture.title);
                $('#gesture-context-input').val(gesture.context);
                $('#gesture-description-input').val(gesture.description);
                renderBodyJoints($('#select-joints-human-body'), gesture.joints);
            }
        });

        if (gesturePreviewDeleteable === true) {
            $(container).find('#btn-delete-gesture').unbind('click').bind('click', {gestureId: gesture.id}, function (event) {
                event.preventDefault();

                if (!event.handled && !$(this).hasClass('disabled')) {
                    event.handled = true;
                    $(this).addClass('disabled');
                    showCursor($('body'), CURSOR_PROGRESS);
                    deleteGesture({gestureId: event.data.gestureId}, function (result) {
                        showCursor($('body'), CURSOR_DEFAULT);
                        if (result.status === RESULT_SUCCESS) {
                            getGestureCatalog(function (result) {
                                if (result.status === RESULT_SUCCESS) {
                                    originalFilterData = result.gestures;
                                    currentFilterData = sort();
                                    $('#custom-modal').trigger('gesture-deleted');
                                    $('#custom-modal').modal('hide');
                                }
                            });
                        }
                    });
                }
            });
        } else {
            $(container).find('#btn-delete-gesture').remove();
        }
    }

    function renderComments(data) {
        var list = $('#discussion-body #comments-list');
        list.empty();
        if (data !== null && data.length > 0) {
            clearAlerts($('#discussion-body'));

            for (var i = 0; i < data.length; i++) {
                var clone = $('#gesture-comment-item').clone().removeClass('hidden').removeAttr('id');
                clone.find('.panel-heading #user .text').text(data[i].forename + " " + data[i].surname);
                clone.find('.panel-heading #created .text').text(convertSQLTimestampToDate(data[i].created).toLocaleString());
                clone.find('.panel-body').text(data[i].comment);
                list.prepend(clone);
                if (data[i].isOwner === true) {
                    clone.find('#btn-delete-comment').click({commentId: data[i].id, gestureId: data[i].gestureId}, function (event) {
                        event.preventDefault();
                        showCursor($('body'), CURSOR_PROGRESS);
                        deleteComment({commentId: event.data.commentId, gestureId: event.data.gestureId}, function (result) {
                            showCursor($('body'), CURSOR_DEFAULT);
                            if (result.status === RESULT_SUCCESS) {
                                renderComments(result.comments);
                            }
                        });
                    });
                } else {
                    clone.find('.panel-footer').remove();
                }
            }
        } else {
            appendAlert($('#discussion-body'), ALERT_NO_COMMENTS);
        }
    }

    function hasUserRatedGesture(userId, ratings) {
        if (ratings && ratings.length > 0) {
            for (var i = 0; i < ratings.length; i++) {
                if (parseInt(ratings[i].userId) === parseInt(userId)) {
                    return true;
                }
            }
        }

        return false;
    }

    function inputsValid(showErrors) {
        var container = $('#gesture-data-edit');
        var title = $('#gesture-data-edit #gesture-name-input').val().trim();
        if (title === '') {
            if (showErrors) {
                appendAlert(container, ALERT_MISSING_FIELDS);
            } else {
                removeAlert(container, ALERT_MISSING_FIELDS);
            }
            return false;
        }

        var context = $('#gesture-data-edit #gesture-context-input').val().trim();
        if (context === '') {
            if (showErrors) {
                appendAlert(container, ALERT_MISSING_FIELDS);
            } else {
                removeAlert(container, ALERT_MISSING_FIELDS);
            }
            return false;
        }

        var description = $('#gesture-data-edit #gesture-description-input').val().trim();
        if (description === '') {
            if (showErrors) {
                appendAlert(container, ALERT_MISSING_FIELDS);
            } else {
                removeAlert(container, ALERT_MISSING_FIELDS);
            }
            return false;
        }

        var selectedJoints = getSelectedJoints($('#select-joints-human-body #joint-container'));
        if (selectedJoints.length === 0) {
            if (showErrors) {
                appendAlert(container, ALERT_MISSING_FIELDS);
            } else {
                removeAlert(container, ALERT_MISSING_FIELDS);
            }
            return false;
        }

        return true;
    }

    $('#gesture-data-edit #select-joints-human-body').bind('change', function () {
        if (inputsValid()) {
            $('#btn-edit-gesture').removeClass('disabled');
        } else {
            $('#btn-edit-gesture').addClass('disabled');
        }
    });

    $('#gesture-name-input, #gesture-context-input, #gesture-description-input').bind('input', function () {
        if (inputsValid()) {
            $('#btn-edit-gesture').removeClass('disabled');
        } else {
            $('#btn-edit-gesture').addClass('disabled');
        }
    }
    );

</script>