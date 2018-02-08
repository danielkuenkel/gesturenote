<?php
include 'includes/language.php';
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"><?php echo $lang->gesturePreview ?></h4>
</div>
<div id="modal-body" class="modal-body">

    <!-- Nav tabs -->
    <ul class="nav nav-pills" id="gesture-info-nav-tab" style="display: flex; justify-content: center;">
        <li role="presentation"><a href="#tab-gesture-general" aria-controls="tab-gesture-general" role="tab" data-toggle="pill"><i class="fa fa-bookmark-o" aria-hidden="true"></i> <?php echo $lang->general ?></a></li>
        <li role="presentation"><a href="#tab-gesture-gesture-sets" aria-controls="tab-gesture-gesture-sets" role="tab" data-toggle="pill"><i class="fa fa-paperclip" aria-hidden="true"></i> <?php echo $lang->gestureSets ?></a></li>
        <li role="presentation"><a href="#tab-gesture-comments" aria-controls="tab-gesture-comments" role="tab" data-toggle="pill"><i class="fa fa-comments-o" aria-hidden="true"></i> <?php echo $lang->comments ?></a></li>
    </ul> 

    <div class="tab-content" style="margin-top: 20px;">

        <div role="tabpanel" class="tab-pane" id="tab-gesture-general">
            <div class="row">
                <div class="col-md-5 root">
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
                        </div><br/>
                        <button type="button" class="btn btn-default hidden" id="btn-choose-preview-image" style="margin-top: 6px"><i class="fa fa-bookmark" aria-hidden="true"></i> <span class="text"><?php echo $lang->selectPreviewImage ?></span></button>
                    </div>

                    <div class="gesture-rating" id="gesture-rating" style="margin-top: 30px;">
                        <h3><i class="fa fa-star-o"></i> <?php echo $lang->valuation ?></h3>
                        <div class="rating-container rating-physicalContext row" id="rating-physicalContext">
                            <div class="col-xs-5 col-sm-3 col-md-5 rating-stars-container"></div>
                            <div class="col-xs-7 col-sm-9 col-md-7 rating-headling"><span class="address"></span> <span class="text"><?php echo $lang->valuationType ?></span></div>
                        </div>
                        <div class="rating-container rating-adaption row" id="rating-adaption">
                            <div class="col-xs-5 col-sm-3 col-md-5 rating-stars-container"></div>
                            <div class="col-xs-7 col-sm-9 col-md-7 rating-headling"><span class="address"></span> <span class="text"><?php echo $lang->valuationAdaption ?></span></div>
                        </div>
                        <div class="rating-container rating-fittingTask row" id="rating-fittingTask">
                            <div class="col-xs-5 col-sm-3 col-md-5 rating-stars-container"></div>
                            <div class="col-xs-7 col-sm-9 col-md-7 rating-headling"><span class="address"></span> <span class="text"><?php echo $lang->valuationTask ?></span></div>
                        </div>
                        <div id="rating-infos">
                            <span id="rated-by"></span> <span id="rating-users-count"></span> <span id="rated-by-users"></span>
                            <div class="alert-space alert-rating-submitted" style="margin-top: 10px;"></div>
                        </div>
                        <button type="button" class="btn btn-block btn-warning" id="btn-rate-gesture" style="margin-top: 10px;"><?php echo $lang->rateGesture ?></button>
                        <div class="btn-group-vertical btn-block hidden" id="rating-submit-buttons" style="margin-top: 0px;">
                            <button type="button" class="btn btn-success" id="btn-submit-gesture-rating"><?php echo $lang->submitGestureRating ?></button>
                            <button type="button" class="btn btn-danger" id="btn-cancel-gesture-rating"><?php echo $lang->cancel ?></button>
                        </div>
                    </div>

                    <div id="gesture-likes" style="margin-top: 30px; margin-bottom: 30px">
                        <h3><i class="fa fa-heart-o"></i> <?php echo $lang->likes ?></h3>
                        <span id="liked-by"></span> <span id="liked-users-count"></span> <span id="liked-by-users"></span>
                        <div style="display: block">
                            <div class="btn-like" style="display: inline-block; margin-right: 5px; font-size: 16pt; cursor: pointer"><i class="fa fa-heart-o"></i> <span class="amount hidden"></span></div>
                            <div style="display: inline-block" class="liked-self"></div>
                        </div>
                    </div>

                    <div style="display: block" id="gesture-sharing">
                        <h3><i class="fa fa-share-alt"></i> <?php echo $lang->share ?></h3>
                        <div class="btn-share" style="display: inline-block; margin-right: 5px; font-size: 16pt; cursor: pointer"><i class="fa fa-share-alt"></i></div>
                        <div style="display: inline-block" class="shared-self"></div>
                    </div>

                </div>

                <div class="col-md-7">
                    <div id="gesture-data-preview">
                        <div id="created"><span class="address"><?php echo $lang->Created ?>:</span> <span class="text"></span></div>
                        <div id="title"><?php echo $lang->title ?>:<span class="address"></span> <span class="text"></span></div>
                        <div id="type"><?php echo $lang->gestureType ?>:<span class="address"></span> <span class="text"></span></div>
                        <div id="interactionType"><?php echo $lang->gestureInteractionType ?>:<span class="address"></span> <span class="text"></span></div>
                        <div id="context"><?php echo $lang->gestureContext ?>:<span class="address"></span> <span class="text"></span></div>
                        <div id="association"><?php echo $lang->gestureAssociation ?>:<span class="address"></span> <span class="text"></span></div>
                        <div id="description"><?php echo $lang->gestureDescription ?>:<span class="address"></span> <span class="text"></span></div>

                        <span class="label label-default" id="gesture-source"><i class="fa fa-globe hidden" id="tester"></i><i class="fa fa-video-camera hidden" id="own"></i><i class="fa fa-globe hidden" id="evaluator"></i> <span class="label-text"></span></span>
                        <span class="label label-default" id="gesture-scope"><i class="fa fa-lock hidden" id="private"></i><i class="fa fa-share-alt hidden" id="public"></i> <span class="label-text"></span></span>

                        <div class="preview-joints-humand-body" id="human-body" style="width: 350px; margin: auto; margin-top: 10px">
                            <div id="joint-container" style="position: absolute"></div>
                            <img src="img/human_body.svg">
                        </div>
                    </div>

                    <div id="gesture-data-edit" class="hidden">
                        <div class="alert-space alert-missing-fields"></div>

                        <div class="form-group">
                            <label><?php echo $lang->gestureName ?></label>
                            <input type="text" class="form-control" id="gesture-name-input" required>
                        </div>

                        <div class="form-group root" id="gestureTypeSelect">
                            <label>
                                <?php echo $lang->gestureType ?> 
                                <i class="fa fa-info-circle text btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->createStudyInfos->general->text4 ?>"></i>
                            </label><br>

                            <div class="btn-group" id="radio" style="margin: 0">
                                <button class="btn btn-default btn-radio" name="primary" id="pose">
                                    <span id="icons" style="margin-right: 6px">
                                        <i class="fa fa-circle-thin" id="normal"></i>
                                        <i class="fa fa-circle hidden" id="over"></i>
                                        <i class="fa fa-check-circle hidden" id="checked"></i>
                                    </span>
                                    <span class="option-text"><?php echo $lang->gestureTypes->pose ?></span>
                                </button>
                            </div>
                            <div class="btn-group" id="radio" style="margin: 0">
                                <button class="btn btn-default btn-radio" name="primary" id="dynamic">
                                    <span id="icons" style="margin-right: 6px">
                                        <i class="fa fa-circle-thin" id="normal"></i>
                                        <i class="fa fa-circle hidden" id="over"></i>
                                        <i class="fa fa-check-circle hidden" id="checked"></i>
                                    </span>
                                    <span class="option-text"><?php echo $lang->gestureTypes->dynamic ?></span>
                                </button>
                            </div>
                        </div>

                        <div class="form-group root" id="gestureInteractionTypeSelect">
                            <label>
                                <?php echo $lang->gestureInteractionType ?> 
                                <i class="fa fa-info-circle text btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->createStudyInfos->general->text4 ?>"></i>
                            </label><br>

                            <div class="btn-group" id="radio" style="margin: 0">
                                <button class="btn btn-default btn-radio" name="primary" id="discrete">
                                    <span id="icons" style="margin-right: 6px">
                                        <i class="fa fa-circle-thin" id="normal"></i>
                                        <i class="fa fa-circle hidden" id="over"></i>
                                        <i class="fa fa-check-circle hidden" id="checked"></i>
                                    </span>
                                    <span class="option-text"><?php echo $lang->gestureInteractionTypes->discrete ?></span>
                                </button>
                            </div>
                            <div class="btn-group" id="radio" style="margin: 0">
                                <button class="btn btn-default btn-radio" name="primary" id="continuous">
                                    <span id="icons" style="margin-right: 6px">
                                        <i class="fa fa-circle-thin" id="normal"></i>
                                        <i class="fa fa-circle hidden" id="over"></i>
                                        <i class="fa fa-check-circle hidden" id="checked"></i>
                                    </span>
                                    <span class="option-text"><?php echo $lang->gestureInteractionTypes->continuous ?></span>
                                </button>
                            </div>
                        </div>


                        <div class="form-group">
                            <label><?php echo $lang->gestureContext ?></label>
                            <input type="text" class="form-control" placeholder="<?php echo $lang->gestureContextQuestion ?>" id="gesture-context-input" required>
                        </div>

                        <div class="form-group">
                            <label><?php echo $lang->gestureAssociation ?></label>
                            <textarea class="form-control" id="gesture-association-input" rows="3" maxlength="500" required></textarea>
                        </div>

                        <div class="form-group">
                            <label><?php echo $lang->gestureDescription ?></label>
                            <textarea class="form-control" id="gesture-description-input" rows="3" maxlength="500" required></textarea>
                        </div>

                        <div class="form-group">
                            <label><?php echo $lang->gestureGraphicsQuestion ?></label>
                            <div class="select-joints-humand-body" id="select-joints-human-body" style="width: 350px; margin: auto; margin-top: 10px">
                                <div id="joint-container" style="position: absolute"></div>
                                <img src="img/human_body.svg">
                            </div>
                        </div>
                    </div>

                    <div class="btn-group-vertical btn-block" style="margin-top: 20px" id="gesture-owner-controls">
                        <button type="button" class="btn btn-default gesture-previewable" id="btn-edit-gesture"><i class="fa fa-pencil" aria-hidden="true"></i> <span class="btn-text"></span></button>
                        <button type="button" class="btn btn-danger" id="btn-delete-gesture"><i class="fa fa-trash" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->deleteGesture ?></span></button>
                    </div>

                </div>
            </div>
        </div>

        <div role="tabpanel" class="tab-pane" id="tab-gesture-gesture-sets">
            <div id="attached-gesture-sets">

                <div id="add-to-gesture-set">
                    <div class="create-gesture-set-input">
                        <label class="text"><?php echo $lang->createNewGestureSet ?></label>

                        <div class="alert-space alert-gesture-set-title-too-short"></div>

                        <div class="input-group">
                            <input type="text" class="form-control" id="input-new-set-title" minlength="8" maxlength="60" placeholder="<?php echo $lang->createNewGestureSetPlaceholder ?>">
                            <span class="input-group-btn">
                                <button class="btn btn-info btn-add-gesture-set" type="button" id="btn-add-gesture-set"><i class="fa fa-plus"></i></button>
                            </span>
                        </div>
                    </div>

                    <div class="row text-center" style="margin-top: 20px">
                        <label class="uppercase" style="font-size: 10pt"><?php echo $lang->or ?></label>
                    </div>

                    <div style="margin-top: 10px">
                        <label class="text"><?php echo $lang->assignToGestureSet ?></label>

                        <div id="existing-sets-container">
                            <div class="option-container root"></div>
                        </div>
                        <div class="alert-space alert-no-gesture-sets-for-study"></div>
                    </div>

                </div>
            </div>
        </div>

        <div role="tabpanel" class="tab-pane" id="tab-gesture-comments">
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <textarea class="form-control" id="comment" rows="4" maxlength="500" placeholder="<?php echo $lang->inputComment ?>" required></textarea>
                    </div>
                    <button type="button" class="btn btn-default btn-block" id="btn-comment-gesture"><i class="fa fa-send" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->submitComment ?></span></button>
                </div>
                <div class="col-md-7">
                    <div class="alert-space alert-no-comments"></div>
                    <div id="comments-list"></div>
                </div>
            </div>
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
        <button class="btn btn-xs btn-danger" id="btn-delete-comment"><?php echo $lang->deleteComment ?></button>
    </div>
</div>

<div id="modal-footer" class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> <?php echo $lang->close ?></button>
</div>

<script>
    var testRatings = [{physicalContext: 1, adaption: 0, fittingTask: 3}, {physicalContext: 0, adaption: 3, fittingTask: 4}, {physicalContext: 2, adaption: 0, fittingTask: 3}, {physicalContext: 2, adaption: 2, fittingTask: 3}, {physicalContext: 2, adaption: 1, fittingTask: 1}];
    var currentRatings = [{physicalContext: 0, adaption: 0, fittingTask: 0}];
    $(document).ready(function () {
        initGestureRating($('#gesture-rating'), 5);

        $('#gesture-info-nav-tab').unbind('shown.bs.tab').bind('shown.bs.tab', function (event) {
            switch ($(event.target).attr('href')) {
                case '#tab-gesture-general':
                    renderGeneralGestureInfo();
                    break;
                case '#tab-gesture-gesture-sets':
                    renderAttachedGestureSets();
                    break;
                case '#tab-gesture-comments':
                    renderGestureComments();
                    break;
            }
        });

        if (currentPreviewGesture.startTab) {
            switch (currentPreviewGesture.startTab) {
                case 'general':
                    $('#gesture-info-nav-tab a[href="#tab-gesture-general"]').tab('show');
                    break;
                case 'gestureSets':
                    $('#gesture-info-nav-tab a[href="#tab-gesture-gesture-sets"]').tab('show');
                    break;
                case 'comments':
                    $('#gesture-info-nav-tab a[href="#tab-gesture-comments"]').tab('show');
                    break;
                case 'rating':
                    $('#gesture-info-nav-tab a[href="#tab-gesture-general"]').tab('show');

                    setTimeout(function () {
                        var ratingTop = $('#custom-modal').find('#gesture-rating').position().top;
                        console.log(ratingTop, $('#custom-modal').find('.modal-content'));
                        $('#custom-modal').animate({
                            scrollTop: ratingTop + 180
                        }, 300);
                    }, 300);

                    break;
            }
        } else {
            $('#gesture-info-nav-tab a[href="#tab-gesture-general"]').tab('show');
        }

        $('#custom-modal').bind('hidden.bs.modal', function () {
            currentPreviewGesture = null;
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
                lockButton(button);
                $(this).closest('.gesture-rating').find('#btn-cancel-gesture-rating').addClass('disabled');
                $(this).closest('.gesture-rating').find('.btn-gesture-rating').removeClass('btn-gesture-rating-clickable');
                var ratings = {};

                for (var i = 0; i < container.length; i++) {
                    var id = $(container[i]).attr('id').split('-')[1];
                    var rating = $(container[i]).find('.active').index();
                    ratings[id] = rating;
                }

                submitRatingForGesture({gestureId: currentPreviewGesture.gesture.id, ratings: ratings}, function (result) {
                    unlockButton(button);
                    $(button).closest('.gesture-rating').find('#btn-cancel-gesture-rating').removeClass('disabled');

                    if (result.status === RESULT_SUCCESS) {
                        $(button).closest('.gesture-rating').find('#btn-rate-gesture').remove();
                        $(button).closest('.gesture-rating').find('#rating-submit-buttons').addClass('hidden');
                        $(button).closest('.gesture-rating').find('.btn-gesture-rating').removeClass('btn-gesture-rating-clickable active');
                        renderGestureRating($(button).closest('.gesture-rating'), result.ratings, true);
                        appendAlert($('#gesture-rating'), ALERT_RATING_SUBMITTED);

                        $(currentPreviewGesture.thumbnail).find('.btn-rate').addClass('gesture-rated');
                        $(currentPreviewGesture.thumbnail).find('.btn-rate .fa').removeClass('fa-star-o').addClass('fa-star');
                        $(currentPreviewGesture.thumbnail).find('.btn-rate .amount').text(parseInt(result.ratings.length) === 0 ? '' : result.ratings.length);
                        $(currentPreviewGesture.thumbnail).find('.btn-rate').attr('data-content', translation.gestureRated);
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
        } else {
            $(target).find('.btn-gesture-rating .fa').removeClass('fa-star-half-full fa-star').addClass('fa-star-o');
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

    function renderGeneralGestureInfo() {
        var gesture = currentPreviewGesture.gesture;
//        console.log('renderModalData', currentPreviewGesture);
        if (gesture === null) {
            return false;
        }

        var container = $('#modal-body');
        container.find('#created .text').text(convertSQLTimestampToDate(gesture.created).toLocaleString());
        container.find('#title .text').text(gesture.title);
        container.find('#type .text').text(gesture.type === null ? '-' : translation.gestureTypes[gesture.type]);
        container.find('#interactionType .text').text(gesture.interactionType === null ? '-' : translation.gestureInteractionTypes[gesture.interactionType]);
        container.find('#context .text').text(gesture.context);
        container.find('#association .text').text(gesture.association === null ? '-' : gesture.association);
        container.find('#description .text').text(gesture.description);
        container.find('#btn-edit-gesture .btn-text').text(translation.edit);
        container.find('#btn-delete-gesture .btn-text').text(translation.deleteGesture);
        container.find('#gesture-scope .label-text').text(translation.gestureScopes[gesture.scope]);
        container.find('#gesture-scope #' + gesture.scope).removeClass('hidden');

        if (gesture.isOwner === true) {
            $(container).find('#gesture-rating #btn-rate-gesture').remove();

            var shareButton = $(container).find('.btn-share');
            if (gesture.scope === SCOPE_GESTURE_PRIVATE) {
                shareButton.removeClass('gesture-shared');
                $(container).find('#gesture-sharing .shared-self').text(translation.gestureNotShared);
            } else {
                shareButton.addClass('gesture-shared');
                $(container).find('#gesture-sharing .shared-self').text(translation.gestureShared);
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
            $(container).find('#gesture-sharing').remove();

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

        var thumbnail = $(currentPreviewGesture.thumbnail);

        updateGestureSharing();
        updateGestureRating();
        updateGestureLikes();

        $('#modal-body #btn-edit-gesture').unbind('click').bind('click', function (event) {
            event.preventDefault();
            var button = $(this);
            if ($(button).hasClass('gesture-editable')) {
                if (!$(button).hasClass('disabled') && inputsValid(true)) {
                    
                    lockButton(button, true, 'fa-pencil');
                    showCursor($('body'), CURSOR_PROGRESS);
                    var previewImageIndex = getGesturePreviewIndex($('#modal-body').find('.previewGesture'));
                    var title = $('#gesture-name-input').val().trim();
                    var type = $(container).find('#gestureTypeSelect .btn-option-checked').attr('id');
                    var interactionType = $(container).find('#gestureInteractionTypeSelect .btn-option-checked').attr('id');
                    var context = $('#gesture-context-input').val().trim();
                    var association = $('#gesture-association-input').val().trim();
                    var description = $('#gesture-description-input').val().trim();
                    var joints = getSelectedJoints($('#select-joints-human-body #joint-container'));

                    updateGesture({gestureId: gesture.id, title: title, type: type, interactionType: interactionType, context: context, association: association, description: description, joints: joints, previewImageIndex:previewImageIndex}, function (result) {
                        showCursor($('body'), CURSOR_DEFAULT);
                        unlockButton(button, true, 'fa-pencil');

                        $('#modal-body #btn-delete-gesture, #modal-body #btn-share-gesture').removeClass('disabled');
                        if (result.status === RESULT_SUCCESS) {
                            updateGestureById(currentPreviewGesture.source, result.id, {title: result.title, type: type, interactionType: interactionType, context: result.context, association: association, description: result.description, joints: result.joints, previewImage: result.previewImage});
                            $(thumbnail).find('.gesture-name').text(title);
                            $('#modal-body #btn-choose-preview-image').addClass('hidden');
                            $(thumbnail).find('.previewGesture .gestureImage').removeClass('previewImage active ');
                            $(thumbnail).find('.previewGesture .gestureImage').addClass('hidden');
                            $($(thumbnail).find('.previewGesture .gestureImage')[previewImageIndex]).addClass('previewImage active');
                            $($(thumbnail).find('.previewGesture .gestureImage')[previewImageIndex]).removeClass('hidden');
                            $(button).removeClass('gesture-editable').addClass('gesture-previewable');
                            $(button).find('.btn-text').text(translation.edit);
                            $('#modal-body #gesture-data-preview').removeClass('hidden');
                            $('#modal-body #gesture-data-edit').addClass('hidden');
                            currentPreviewGesture.gesture = getGestureById(result.id, currentPreviewGesture.source);
//                            console.log('btn-edit', currentPreviewGesture, result.id);
                            originalFilterData = getLocalItem(currentPreviewGesture.source);
                            renderGeneralGestureInfo();
                        } else {
                            appendAlert($('#modal-body'), ALERT_GENERAL_ERROR);
                        }
                    });
                }
            } else {
//                console.log('edit gesture:', gesture);
                $(button).removeClass('gesture-previewable').addClass('gesture-editable');
                $(button).find('.btn-text').text(translation.gesturePreviewable);
                $('#modal-body #gesture-data-preview').addClass('hidden');
                $('#modal-body #gesture-data-edit').removeClass('hidden');
                $('#modal-body #btn-delete-gesture, #modal-body .btn-share').addClass('disabled');
                $('#modal-body #btn-choose-preview-image').removeClass('hidden');
                $('#gesture-name-input').val(gesture.title);
                if (gesture.type !== "") {
                    $('#gesture-data-edit #gestureTypeSelect').find('#' + gesture.type).click();
                }
                if (gesture.interactionType !== "") {
                    $('#gesture-data-edit #gestureInteractionTypeSelect').find('#' + gesture.interactionType).click();
                }

                $('#gesture-association-input').val(gesture.association);
                $('#gesture-context-input').val(gesture.context);
                $('#gesture-description-input').val(gesture.description);
                renderBodyJoints($('#select-joints-human-body'), gesture.joints);
            }
        });

        $('#modal-body #btn-choose-preview-image').unbind('click').bind('click', function (event) {
            event.preventDefault();
            
            var previewImage = $(this).closest('.root').find('.previewImage');
            previewImage.removeClass('previewImage');
            var visibleImage = $(this).closest('.root').find('.active');
            visibleImage.addClass('previewImage');
            console.log('tag as preview image', previewImage, visibleImage);
        });

        if ($(thumbnail).hasClass('deleteable')) {
            $(container).find('#btn-delete-gesture').unbind('click').bind('click', {gestureId: gesture.id}, function (event) {
                event.preventDefault();
                var button = $(this);
                if (!event.handled && !$(this).hasClass('disabled')) {
                    event.handled = true;
                    lockButton(button, true, 'fa-trash');
                    showCursor($('body'), CURSOR_PROGRESS);

                    deleteGesture({gestureId: event.data.gestureId}, function (result) {
                        if (result.status === RESULT_SUCCESS) {
                            getGestureCatalog(function (result) {
                                showCursor($('body'), CURSOR_DEFAULT);
                                unlockButton(button, true, 'fa-trash');

                                if (result.status === RESULT_SUCCESS) {
                                    originalFilterData = result.gestures;
                                    currentFilterData = sort();
                                    $('#custom-modal').modal('hide');
                                    $('#custom-modal').trigger('gesture-deleted');
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

    function updateGestureSharing() {
        var modal = $('#custom-modal');

        initShareGesture($(modal).find('#gesture-sharing .btn-share'), currentPreviewGesture.thumbnail, currentPreviewGesture.source, currentPreviewGesture.gesture, function () {
            if ($(modal).find('#gesture-sharing .btn-share').hasClass('gesture-shared')) {
                $(modal).find('#gesture-sharing .shared-self').text(translation.gestureShared);
                $(currentPreviewGesture.thumbnail).find('.btn-share').addClass('gesture-shared');
            } else {
                $(modal).find('#gesture-sharing .shared-self').text(translation.gestureNotShared);
                $(currentPreviewGesture.thumbnail).find('.btn-share').removeClass('gesture-shared');
            }
        });
    }

    function updateGestureRating() {
        var modal = $('#custom-modal');
        getRatingsForGesture({gestureId: currentPreviewGesture.gesture.id}, function (result) {
            if (result.status === RESULT_SUCCESS) {
                renderGestureRating($(modal).find('#gesture-rating'), result.ratings, true);
                if (result.hasRated && (result.hasRated === true || result.hasRated === 'true')) {
                    $(modal).find('#gesture-rating #btn-rate-gesture').remove();
                }
            }
        });
    }

    function updateGestureLikes() {
        getLikesForGesture({gestureId: currentPreviewGesture.gesture.id}, function (result) {
            if (result.status === RESULT_SUCCESS) {
                $('#gesture-likes').find('#liked-by').text(translation.likedBy);
                $('#gesture-likes').find('#liked-users-count').text(result.likeAmount || 0);
                $('#liked-by-users').text(parseInt(result.likeAmount) === 1 ? translation.likedByUser : translation.likedByUsers);

                initLikeGesture($('#gesture-likes').find('.btn-like'), currentPreviewGesture.source, {id: currentPreviewGesture.gesture.id, hasLiked: result.hasLiked, likeAmount: result.likeAmount}, function () {
                    if ($('#gesture-likes').find('.btn-like').hasClass('gesture-liked')) {
                        $('#gesture-likes').find('.liked-self').text(translation.likedByMyself);
                        $(currentPreviewGesture.thumbnail).find('.btn-like .fa').removeClass('fa-heart-o').addClass('fa-heart');
                        $(currentPreviewGesture.thumbnail).find('.btn-like').addClass('gesture-liked');
                    } else {
                        $('#gesture-likes').find('.liked-self').text(translation.notLikedByMyself);
                        $(currentPreviewGesture.thumbnail).find('.btn-like').removeClass('gesture-liked');
                        $(currentPreviewGesture.thumbnail).find('.btn-like .fa').removeClass('fa-heart').addClass('fa-heart-o');
                    }
                    $(currentPreviewGesture.thumbnail).find('.btn-like .amount').text($('#gesture-likes').find('.btn-like .amount').text());
                });

                if (result.hasLiked && (result.hasLiked === true || result.hasLiked === 'true')) {
                    $('#gesture-likes').find('.liked-self').text(translation.likedByMyself);
                    $('#gesture-likes').find('.btn-like').addClass('gesture-liked');
                } else {
                    $('#gesture-likes').find('.liked-self').text(translation.notLikedByMyself);
                    $('#gesture-likes').find('.btn-like').removeClass('gesture-liked');
                }
            }
        });
    }

    function renderGestureComments() {
        getCommentsForGesture({gestureId: currentPreviewGesture.gesture.id}, function (result) {
            if (result.status === RESULT_SUCCESS) {
                renderComments(result.comments);
            }
        });

        $('#tab-gesture-comments #btn-comment-gesture').unbind('click').bind('click', function (event) {
            event.preventDefault();
            var button = $(this);
            if (!$(button).hasClass('disabled')) {
                lockButton(button, true, 'fa-send');
                var comment = $('#tab-gesture-comments #comment').val().trim();
                if (comment !== '') {
                    showCursor($('body'), CURSOR_PROGRESS);
                    submitCommentForGesture({gestureId: currentPreviewGesture.gesture.id, comment: comment}, function (result) {
                        showCursor($('body'), CURSOR_DEFAULT);
                        unlockButton(button, true, 'fa-send');
                        if (result.status === RESULT_SUCCESS) {
                            $('#tab-gesture-comments #comment').val('');
                            renderComments(result.comments);
                            $(currentPreviewGesture.thumbnail).find('.btn-comment .fa').removeClass('fa-comment-o').addClass('fa-comments');
                            $(currentPreviewGesture.thumbnail).find('.btn-comment .amount').text(result.comments.length);
                        }
                    });
                } else {
                    unlockButton(button, true, 'fa-send');
                }
            }
        });
    }

    function renderComments(data) {
        var list = $('#tab-gesture-comments #comments-list');
        list.empty();
        if (data && data !== null && data.length > 0) {
            clearAlerts($('#tab-gesture-comments'));

            for (var i = 0; i < data.length; i++) {
                var clone = $('#gesture-comment-item').clone().removeClass('hidden').removeAttr('id');
                clone.find('.panel-heading #user .text').text(data[i].forename + " " + data[i].surname);
                clone.find('.panel-heading #created .text').text(convertSQLTimestampToDate(data[i].created).toLocaleString());
                clone.find('.panel-body').text(data[i].comment);
                list.prepend(clone);
                if (data[i].isOwner === true) {
                    clone.find('#btn-delete-comment').click({commentId: data[i].id, gestureId: data[i].gestureId}, function (event) {
                        var button = $(this);
                        if (!$(button).hasClass('disabled')) {
                            lockButton(button, true, 'fa-trash');
                            event.preventDefault();
                            showCursor($('body'), CURSOR_PROGRESS);
                            deleteComment({commentId: event.data.commentId, gestureId: event.data.gestureId}, function (result) {
                                showCursor($('body'), CURSOR_DEFAULT);
                                unlockButton(button, true, 'fa-trash');
                                if (result.status === RESULT_SUCCESS) {
                                    renderComments(result.comments);
                                    if (!result.comments) {
                                        $(currentPreviewGesture.thumbnail).find('.amount').text('');
                                        $(currentPreviewGesture.thumbnail).find('.btn-comment .fa').removeClass('fa-comments').addClass('fa-comment-o');
                                    } else {
                                        $(currentPreviewGesture.thumbnail).find('.amount').text(result.comments.length);
                                        $(currentPreviewGesture.thumbnail).find('.btn-comment .fa').removeClass('fa-comment-o').addClass('fa-comments');
                                    }
                                }
                            });
                        }
                    });
                } else {
                    clone.find('.panel-footer').remove();
                }
            }
        } else {
            appendAlert($('#tab-gesture-comments'), ALERT_NO_COMMENTS);
        }
    }

    /*
     * gesture set adding and attached rendering
     */
    function renderAttachedGestureSets(preselect, id) {
        getGestureSets(function (result) {
            if (result.status === RESULT_SUCCESS) {
                setLocalItem(GESTURE_SETS, result.gestureSets);
                renderModalGestureSets(preselect, id);
            }
        });
    }

    function renderModalGestureSets(preselect, id) {
        var sets = getLocalItem(GESTURE_SETS);
//        console.log('render attached gesture sets', sets);
        if (sets && sets !== null && sets !== '' && sets.length > 0) {
            var container = $('#add-to-gesture-set #existing-sets-container');
            container.find('.option-container').empty();

            for (var i = 0; i < sets.length; i++) {
                var option = $('#template-general-container').find('#checkbox').clone();
                option.find('.option-text').text(sets[i].title);
                option.find('.btn-checkbox').attr('id', sets[i].id);
                container.find('.option-container').append(option);
                container.find('.option-container').append(document.createElement('br'));

                // preselect item after adding new gesture set
                if (preselect === true && id && parseInt(id) === parseInt(sets[i].id)) {
                    option.find('.btn-checkbox').click();
                }

                // check gestures and make checkbox selected if gesture is in gesture set [i]
                if (sets[i].gestures && sets[i].gestures.length > 0) {
                    if (checkSetAssignment(sets[i].gestures, currentPreviewGesture.gesture.id)) {
                        option.find('.btn-checkbox').click();
                    }
                }
            }

            $('#add-to-gesture-set .create-gesture-set-input').unbind('gestureSetCreated').bind('gestureSetCreated', function (event, newSetId) {
                event.preventDefault();
                getGestureSets(function (result) {
                    if (result.status === RESULT_SUCCESS) {
                        setLocalItem(GESTURE_SETS, result.gestureSets);
                        renderModalGestureSets(true, newSetId);
                    }
                });
            });

            $(container).unbind('change').bind('change', function (event) {
                event.preventDefault();
                saveGestureSets();
            });

            function saveGestureSets() {
                var listItems = $(container).find('.option-container').find('.btn-checkbox');
                for (var i = 0; i < listItems.length; i++) {
                    if ($(listItems[i]).hasClass('btn-option-checked')) {
                        addToGestureSet($(listItems[i]).attr('id'), currentPreviewGesture.gesture.id);
                    } else {
                        removeFromGestureSet($(listItems[i]).attr('id'), currentPreviewGesture.gesture.id);
                    }
                }

                // call ajax update gesture sets, calling php 
                updateGestureSets({sets: getLocalItem(GESTURE_SETS)}, function (result) {
                    $(container).trigger('gestureSetsUpdated', [currentPreviewGesture.gesture.id]);
                });
            }
        } else {
            appendAlert($('#add-to-gesture-set'), ALERT_NO_GESTURE_SETS_FOR_STUDY);
        }
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

        var type = $(container).find('#gestureTypeSelect .btn-option-checked').attr('id');
        if (type === undefined) {
            if (showErrors) {
                appendAlert(container, ALERT_MISSING_FIELDS);
            } else {
                removeAlert(container, ALERT_MISSING_FIELDS);
            }
            return false;
        }

        var interactionType = $(container).find('#gestureInteractionTypeSelect .btn-option-checked').attr('id');
        if (interactionType === undefined) {
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

        var association = $('#gesture-data-edit #gesture-association-input').val().trim();
        if (association === '') {
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

    $('#gesture-data-edit #gestureTypeSelect, #gesture-data-edit #gestureInteractionTypeSelect').unbind('change').bind('change', function () {
        if (inputsValid()) {
            $('#btn-edit-gesture').removeClass('disabled');
        } else {
            $('#btn-edit-gesture').addClass('disabled');
        }
    });

    $('#gesture-name-input, #gesture-association-input, #gesture-context-input, #gesture-description-input').bind('input', function () {
        if (inputsValid()) {
            $('#btn-edit-gesture').removeClass('disabled');
        } else {
            $('#btn-edit-gesture').addClass('disabled');
        }
    });
</script>