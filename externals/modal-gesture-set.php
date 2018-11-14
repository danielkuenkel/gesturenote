<?php
include '../includes/language.php';
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"><?php echo $lang->gestureSetPreview ?></h4>
</div>
<div id="modal-body" class="modal-body">

    <!-- Nav tabs -->
    <ul class="nav nav-pills" id="gesture-set-nav-tab" style="display: flex; justify-content: center;">
        <li role="presentation"><a href="#tab-gesture-set-general" aria-controls="tab-gesture-set-general" role="tab" data-toggle="pill"><i class="fa fa-bookmark-o" aria-hidden="true"></i> <?php echo $lang->general ?></a></li>
        <li role="presentation"><a href="#tab-gesture-set-gestures" aria-controls="tab-gesture-set-gestures" role="tab" data-toggle="pill"><i class="fa fa-paperclip" aria-hidden="true"></i> <?php echo $lang->gestures ?></a></li>
        <li role="presentation"><a href="#tab-gesture-set-mappings" aria-controls="tab-gesture-set-mappings" role="tab" data-toggle="pill"><i class="fa fa-exchange" aria-hidden="true"></i> <?php echo $lang->mappings ?></a></li>
        <li role="presentation"><a href="#tab-gesture-set-comments" aria-controls="tab-gesture-set-comments" role="tab" data-toggle="pill"><i class="fa fa-comments-o" aria-hidden="true"></i> <?php echo $lang->comments ?></a></li>
    </ul>

    <div class="tab-content" style="margin-top: 20px;">

        <div role="tabpanel" class="tab-pane" id="tab-gesture-set-general">
            <div class="row" id="gesture-set-general-info-container">
                <div class="col-md-7 root" style="margin-bottom: 20px">

                    <div id="gesture-set-likes" style="margin-bottom: 30px">
                        <h3 style="margin-top: 0"><i class="fa fa-heart-o"></i> <?php echo $lang->likes ?></h3>
                        <span id="liked-by"></span>
                        <div style="display: block">
                            <div class="btn-like-set update-list-view" style="display: inline-block; margin-right: 5px; font-size: 16pt; cursor: pointer"><i class="fa fa-heart-o"></i> <span class="amount hidden"></span></div>
                            <div style="display: inline-block" class="liked-self"></div>
                        </div>
                    </div>

                    <div style="display: block" id="gesture-set-sharing">
                        <h3><i class="fa fa-share-alt"></i> <?php echo $lang->share ?></h3>
                        <div style="margin-top: 10px"><label class="text"><?php echo $lang->inviteAllUsersForGestureSet ?></label></div>
                        <div style="margin-top: -10px">
                            <div class="btn-share-set" style="display: inline-block; cursor: pointer"><span style="font-size: 28pt; line-height: 16px; top: 8px; position: relative;">&infin;</span></div>
                            <div style="display: inline-block" class="shared-self"></div>
                        </div>

                        <div id="invited-users" style="margin-top: 10px">
                            <div class="form-group" id="invite-users-form">
                                <label class="text"><?php echo $lang->inviteUserViaMail ?></label>
                                <div class="alert-space alert-gesture-set-not-shared"></div>

                                <div class="alert-space alert-missing-email"></div>
                                <div class="alert-space alert-invalid-email"></div>
                                <div class="alert-space alert-user-already-invited"></div>
                                <div class="alert-space alert-share-gesture-set-to-yourself"></div>

                                <div class="input-group">
                                    <input type="text" class="form-control" id="input-email" minlength="8" maxlength="50" placeholder="<?php echo $lang->email ?>">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button" id="btn-invite-user"><i class="fa fa-paper-plane"></i> <span class="btn-text"><?php echo $lang->invite ?></span></button>
                                    </span>
                                </div>

                                <div id="shared-gesture-sets-list" style="margin-top: 10px"></div>
                            </div>
                        </div>
                    </div>

                    <div class="hidden" style="display: block" id="gesture-set-sharing-not-owner">
                        <h3><i class="fa fa-share-alt"></i> <?php echo $lang->share ?></h3>
                        <div style="" class="shared-with-others"></div>
                        <div style="" class="shared-self"><?php echo $lang->gestureSetSharedWithYou ?></div>
                    </div>

                </div>

                <div class="col-md-5">
                    <div class="panel panel-shadow" id="gesture-set-data-preview">
                        <div class="panel-body">
                            <div style="margin: 0; display: flex">
                                <span class="label label-default" id="gesture-set-scope"><i class="fa fa-lock hidden" id="private"></i><i class="fa fa-share-alt hidden" id="public"></i> <span class="label-text"></span></span>
                            </div>

                            <div style="">
                                <div id="created"><span class="address"><?php echo $lang->Created ?>:</span> <span class="text"></span></div>
                                <div id="creator"><?php echo $lang->userTypes->interactionDesigner ?>: <span class="text"></span></div>
                                <div id="title"><?php echo $lang->title ?>:<span class="address"></span> <span class="text"></span></div>
                            </div>

                            <button type="button" class="btn btn-block btn-default btn-shadow gesture-set-owner-controls" id="btn-edit-gesture-set" style="margin-top: 20px"><i class="fa fa-pencil" aria-hidden="true"></i> <?php echo $lang->editGestureSet ?></button>
                        </div>
                    </div>

                    <!--                    <div class="row" style="margin-top: 20px" id="gesture-set-owner-controls">
                                            <div class="col-xs-6">
                                                
                                            </div>
                                            <div class="col-xs-6">
                                                
                                            </div>
                                        </div>-->

                </div>
            </div>

            <div class="row hidden" id="gesture-set-edit-general-info-container">
                <div class="col-xs-12 col-md-8 col-md-offset-2">
                    <div class="alert-space alert-missing-fields"></div>

                    <div class="form-group">
                        <label><?php echo $lang->gestureName ?></label>
                        <input type="text" class="form-control" id="gesture-set-name-input" required>
                    </div>

                    <button type="button" class="btn btn-success btn-shadow btn-block" id="btn-submit-edit-gesture-set" style="margin-top: 10px"><i class="fa fa-save"></i> <?php echo $lang->submitEditGestureSet ?></button>
                    <button type="button" class="btn btn-default btn-shadow btn-block" id="btn-cancel-edit-gesture-set" style="margin-top: 10px"><i class="fa fa-close"></i> <?php echo $lang->cancelEditGestureSet ?></button>
                </div>
            </div>
        </div>

        <div role="tabpanel" class="tab-pane" id="tab-gesture-set-gestures">
            <div class="row" id="attached-gestures"></div>
        </div>

        <div role="tabpanel" class="tab-pane" id="tab-gesture-set-mappings">

        </div>

        <div role="tabpanel" class="tab-pane" id="tab-gesture-set-comments">
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <textarea class="form-control" id="comment" rows="4" maxlength="500" placeholder="<?php echo $lang->inputComment ?>" required></textarea>
                    </div>
                    <button type="button" class="btn btn-default btn-shadow btn-block" id="btn-comment-gesture-set"><i class="fa fa-send" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->submitComment ?></span></button>
                </div>
                <div class="col-md-7">
                    <div class="alert-space alert-no-comments"></div>
                    <div id="comments-list"></div>
                </div>
            </div>
        </div>

    </div>

</div>

<div id="modal-body-delete-gesture-set" class="modal-body hidden">
    <div class="text-center text">
        <p>
            <?php echo $lang->deleteGestureSetModal ?>
        </p>
    </div>

    <div class="btn-group btn-group-justified">
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-default btn-shadow" id="btn-yes"><i class="fa fa-check"></i> <?php echo $lang->yes ?></button>
        </div>
        <div class="btn-group" role="group">
            <button type="button" class="btn  btn-default btn-shadow" id="btn-no"><i class="fa fa-close"></i> <?php echo $lang->no ?></button>
        </div>

    </div>
</div>

<div class="hidden panel panel-default panel-sm panel-shadow" id="gesture-set-comment-item" style="margin-top: 0px; margin-bottom: 8px">
    <div class="panel-heading" style="font-size: 10pt">
        <span id="user"><i class="fa fa-comment" aria-hidden="true"></i> <span class="text"></span></span>
        <span id="created" class="pull-right"><i class="fa fa-clock-o" aria-hidden="true"></i> <span class="text"></span></span>
    </div>
    <div class="panel-body" style="color: #303030; font-size: 10pt"></div>
    <div class="panel-footer">
        <button class="btn btn-xs btn-danger" id="btn-delete-comment"><i class="fa fa-trash"></i> <?php echo $lang->deleteComment ?></button>
    </div>
</div>

<div id="modal-footer" class="modal-footer">
    <button type="button" class="btn btn-shadow btn-danger pull-left gesture-set-owner-controls" id="btn-delete-gesture-set"><i class="fa fa-trash" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->deleteGestureSet ?></span></button>
    <div class="" style="display: inline-block; margin-right: 12px">
        <button type="button" class="btn btn-default btn-shadow btn-join-conversation"><span class=""><?php echo $lang->joinConversation ?></span> <i class="fa fa-group"></i></button>
        <button type="button" class="btn btn-default btn-shadow btn-leave-conversation hidden"><span class=""><?php echo $lang->leaveConversation ?></span> 
            <span>
                <i class="fa fa-group"></i>
                <i class="fa fa-ban" style="
                   font-size: 9pt;
                   position: relative;
                   right: 5px;
                   top: -6px;"></i>
            </span>
        </button>
    </div>
    <button type="button" class="btn btn-shadow btn-default" data-dismiss="modal"><i class="fa fa-close"></i> <?php echo $lang->close ?></button>
</div>

<script>
    var modal = $('#custom-modal');
    $(document).ready(function () {

        $('#gesture-set-nav-tab').unbind('shown.bs.tab').bind('shown.bs.tab', function (event) {
            switch ($(event.target).attr('href')) {
                case '#tab-gesture-set-general':
                    renderGeneralGestureInfo();
                    break;
                case '#tab-gesture-set-gestures':
                    resetGeneralGestureInfo();
                    renderAttachedGestures();
                    break;
                case '#tab-gesture-set-comments':
                    resetGeneralGestureInfo();
                    renderGestureSetComments();
                    break;
            }
            initPopover();
        });

        if (currentPreviewGestureSet.startTab) {
            switch (currentPreviewGestureSet.startTab) {
                case 'general':
                    $('#gesture-set-nav-tab a[href="#tab-gesture-set-general"]').tab('show');
                    break;
                case 'gestureSets':
                    $('#gesture-set-nav-tab a[href="#tab-gesture-set-gestures"]').tab('show');
                    break;
                case 'comments':
                    $('#gesture-set-nav-tab a[href="#tab-gesture-set-comments"]').tab('show');
                    break;
            }
        } else {
            $('#gesture-set-nav-tab a[href="#tab-gesture-set-general"]').tab('show');
        }

        if ($('.custom-modal').attr('data-conv-allowed') === 'false') {
            $('.custom-modal').find('.btn-join-conversation').remove();
            $('.custom-modal').find('.btn-leave-conversation').remove();
        } else {
            // join and leave conversation about this gesture
            $('.btn-join-conversation').unbind('click').bind('click', function (event) {
                event.preventDefault();
                initCollaborativeVideoCaller('gestureSet' + currentPreviewGestureSet.set.id);
            });

            $('.btn-leave-conversation').unbind('click').bind('click', function (event) {
                event.preventDefault();
                leaveCollaborativeVideoCaller();
            });
        }

        $('#custom-modal').bind('hidden.bs.modal', function () {
            currentPreviewGestureSet = null;
            gestureSetPreviewOpened = false;
            $(this).unbind('hidden.bs.modal');
        });

        $('#custom-modal').bind('hide.bs.modal', function () {
            if ($('.custom-modal').attr('data-conv-allowed') !== 'false') {
                $('.btn-leave-conversation').click();
            }

            $(this).unbind('hide.bs.modal');
        });
    });



    function renderGeneralGestureInfo() {
        var set = currentPreviewGestureSet.set;
        if (set === null) {
            return false;
        }

        var container = $('#modal-body');
        container.find('#created .text').text(convertSQLTimestampToDate(set.created).toLocaleString());
        container.find('#creator .text').text(set.forename + (set.surname !== '.' ? ' ' + set.surname : ''));
        container.find('#title .text').text(set.title);

        var shareButton = $(container).find('.btn-share-set');
        if (set.isOwner === true) {
            $(container).find('#gesture-set-sharing-not-owner').remove();

            $(shareButton).removeClass('hidden');
            if (set.scope === SCOPE_GESTURE_PRIVATE) {
                shareButton.removeClass('gesture-set-shared');
                $(container).find('#gesture-set-sharing .shared-self').text(translation.gestureSetNotShared);
            } else {
                shareButton.addClass('gesture-set-shared');
                $(container).find('#gesture-set-sharing .shared-self').text(translation.gestureSetShared);
            }
        } else {
            var shareAmount = 0;
            if (set.invitedUsers) {
                shareAmount = set.invitedUsers.length;
            }

            $(container).find('#gesture-set-sharing').remove();
            $(modal).find('.gesture-set-owner-controls').remove();
            $(container).find('#gesture-set-sharing-not-owner').removeClass('hidden');
            if (set.scope === SCOPE_GESTURE_PRIVATE) {
                $(container).find('.shared-with-others').html(new String(translation.gestureSetSharedWithOthers).replace('{x}', Math.max(shareAmount - 1)));
            } else {
                $(container).find('.shared-with-others').html(translation.gestureSetShared);
            }
        }

        updateGestureSetSharingInfos();
        updateGestureSetSharing();
        renderInvitedGestureSetUsers();
        updateGestureSetLikes();

        $('#modal-body #btn-edit-gesture-set').unbind('click').bind('click', function (event) {
            event.preventDefault();

            var editContainer = $(modal).find('#gesture-set-edit-general-info-container');
            $(modal).find('#gesture-set-general-info-container').addClass('hidden');
            $(editContainer).removeClass('hidden');
            var titleInput = $(editContainer).find('#gesture-set-name-input');
            $(titleInput).val(currentPreviewGestureSet.set.title);

            $(modal).find($('#btn-submit-edit-gesture-set')).unbind('click').bind('click', function (event) {
                console.log('submit data');
                var button = $(this);
                lockButton(button, true, 'fa-save');

                if (inputsValid(true)) {
                    var title = $(titleInput).val();
                    console.log('inputs valid');
                    updateGestureSet({setId: currentPreviewGestureSet.set.id, title: title, gestures: currentPreviewGestureSet.set.gestures, ownerId: currentPreviewGestureSet.set.userId}, function (result) {
                        unlockButton(button, true, 'fa-save');
                        if (result.status === RESULT_SUCCESS) {
                            updateGestureSetById(GESTURE_SETS, currentPreviewGestureSet.set.id, {title: title});
                            $(modal).find('#gesture-set-general-info-container').removeClass('hidden');
                            $(editContainer).addClass('hidden');
                            container.find('#title .text').text(title);
                            $(currentPreviewGestureSet.thumbnail).find('.panel-heading-text').text(title);
                        } else {
                            // append general error alert
                        }
                    });
                }
            });
        });

        var modal = $('#custom-modal');
        $('#modal-body #btn-cancel-edit-gesture-set').unbind('click').bind('click', function (event) {
            event.preventDefault();

            $(modal).find('#gesture-set-general-info-container').removeClass('hidden');
            $(modal).find('#gesture-set-edit-general-info-container').addClass('hidden');
            $(modal).find('#gesture-set-edit-general-info-container .edit-content').empty();

            renderGeneralGestureInfo();
        });

        if ($(currentPreviewGestureSet.thumbnail).hasClass('deleteable') && currentPreviewGestureSet.set.isOwner === true) {
            $('#custom-modal').find('#btn-delete-gesture-set').unbind('click').bind('click', function (event) {
                event.preventDefault();
                var button = $(this);

                if (!event.handled && !$(this).hasClass('disabled')) {

                    event.handled = true;
                    lockButton(button, true, 'fa-trash');

                    $(modal).find('#modal-body').addClass('hidden');
                    $(modal).find('#modal-body-delete-gesture-set').removeClass('hidden');
                    $(modal).find('#modal-body-delete-gesture-set #btn-yes').unbind('click').bind('click', function (event) {
                        event.preventDefault();

                        var button = $(this);
                        lockButton(button, true, 'fa-check');
                        showCursor($('body'), CURSOR_PROGRESS);
                        $(modal).find('#modal-body-delete-gesture-set #btn-no').addClass('disabled');

                        deleteGestureSet({setId: currentPreviewGestureSet.set.id}, function (result) {
                            if (result.status === RESULT_SUCCESS) {
                                getGestureSets(function (result) {
                                    showCursor($('body'), CURSOR_DEFAULT);
                                    unlockButton(button, true, 'fa-trash');
                                    $(modal).find('#modal-body-delete-gesture-set #btn-no').removeClass('disabled');

                                    if (result.status === RESULT_SUCCESS) {
                                        setLocalItem(GESTURE_SETS, result.gestureSets);
                                        originalFilterData = result.gestureSets;
                                        currentFilterData = sort();
                                    } else {
                                        // show error;
                                    }

                                    $('#custom-modal').modal('hide');
                                    $('#custom-modal').trigger('gesture-set-deleted');
                                });
                            }
                        });
                    });

                    $(modal).find('#modal-body-delete-gesture-set #btn-no').unbind('click').bind('click', function (event) {
                        event.preventDefault();
                        $(modal).find('#modal-body').removeClass('hidden');
                        $(modal).find('#modal-body-delete-gesture-set').addClass('hidden');
                        unlockButton(button, true, 'fa-trash');
                    });
                }
            });
        } else {
            $(container).find('#btn-delete-gesture-set').remove();
            $(container).find('#btn-edit-gesture-set').parent().removeClass('col-xs-6').addClass('col-xs-12');
        }
    }

    function resetGeneralGestureInfo() {
        var modal = $('#custom-modal');
        $(modal).find('#gesture-general-info-container').removeClass('hidden');
        $(modal).find('#gesture-edit-general-info-container').addClass('hidden');
        $(modal).find('#gesture-edit-general-info-container .edit-content').empty();

        renderGeneralGestureInfo();
    }

    function updateGestureSetLikes() {
        updateLikeStatus();

        initLikeGestureSet($('#gesture-set-likes').find('.btn-like-set'), {id: currentPreviewGestureSet.set.id, hasLiked: currentPreviewGestureSet.set.hasLiked, likeAmount: currentPreviewGestureSet.set.likeAmount}, function () {
            currentPreviewGestureSet.set = getGestureSetById(currentPreviewGestureSet.set.id);
            if (currentPreviewGestureSet.set.hasLiked === true) {
                $(currentPreviewGestureSet.thumbnail).find('.btn-like-set .fa').removeClass('fa-heart-o').addClass('fa-heart');
                $(currentPreviewGestureSet.thumbnail).find('.btn-like-set').addClass('gesture-set-liked');
            } else {
                $(currentPreviewGestureSet.thumbnail).find('.btn-like-set').removeClass('gesture-set-liked');
                $(currentPreviewGestureSet.thumbnail).find('.btn-like-set .fa').removeClass('fa-heart').addClass('fa-heart-o');
            }
            $(currentPreviewGestureSet.thumbnail).find('.btn-like-set .amount').text($('#gesture-set-likes').find('.btn-like-set .amount').text());

            updateLikeStatus();
        });

        function updateLikeStatus() {
            var likeAmount = parseInt(currentPreviewGestureSet.set.likeAmount);
            var hasLiked = currentPreviewGestureSet.set.hasLiked;

            $('#gesture-set-likes').find('#liked-by').html(new String(likeAmount === 1 ? translation.likedByUser : translation.likedByUsers).replace('{x}', likeAmount || 0));
            $('#gesture-set-likes').find('#liked-users-count').text(likeAmount || 0);
            $('#liked-by-users').text(likeAmount === 1 ? translation.likedByUser : translation.likedByUsers);

            if (hasLiked && (hasLiked === true || hasLiked === 'true')) {
                $('#gesture-set-likes').find('.liked-self').text(translation.likedGestureSetByMyself);
                $('#gesture-set-likes').find('.btn-like-set').addClass('gesture-set-liked');
            } else {
                $('#gesture-set-likes').find('.liked-self').text(translation.notLikedGestureSetByMyself);
                $('#gesture-set-likes').find('.btn-like-set').removeClass('gesture-set-liked');
            }
        }
    }

    function renderGestureSetComments() {
        getCommentsForGestureSet({setId: currentPreviewGestureSet.set.id}, function (result) {
            if (result.status === RESULT_SUCCESS) {
                renderComments(result.comments);
            }
        });

        $('#tab-gesture-set-comments #btn-comment-gesture-set').unbind('click').bind('click', function (event) {
            event.preventDefault();
            var button = $(this);
            if (!$(button).hasClass('disabled')) {
                lockButton(button, true, 'fa-send');
                var comment = $('#tab-gesture-set-comments #comment').val().trim();
                if (comment !== '') {
                    showCursor($('body'), CURSOR_PROGRESS);
                    submitGestureSetComment({setId: currentPreviewGestureSet.set.id, comment: comment}, function (result) {
                        showCursor($('body'), CURSOR_DEFAULT);
                        unlockButton(button, true, 'fa-send');
                        if (result.status === RESULT_SUCCESS) {
                            $('#tab-gesture-set-comments #comment').val('');
                            renderComments(result.comments);
                            $(currentPreviewGestureSet.thumbnail).find('.btn-comment-set .fa').removeClass('fa-comment-o').addClass('fa-comments');
                            $(currentPreviewGestureSet.thumbnail).find('.btn-comment-set .amount').text(result.comments.length);
                        }
                    });
                } else {
                    unlockButton(button, true, 'fa-send');
                }
            }
        });
    }

    function renderComments(data) {
        var list = $('#tab-gesture-set-comments #comments-list');
        list.empty();
        if (data && data !== null && data.length > 0) {
            clearAlerts($('#tab-gesture-set-comments'));

            for (var i = 0; i < data.length; i++) {
                var clone = $('#gesture-set-comment-item').clone().removeClass('hidden').removeAttr('id');
                clone.find('.panel-heading #user .text').text(data[i].forename + ' ' + data[i].surname);
                clone.find('.panel-heading #created .text').text(convertSQLTimestampToDate(data[i].created).toLocaleString());
                clone.find('.panel-body').text(data[i].comment);
                list.prepend(clone);

                if (data[i].isOwner === true) {
                    clone.find('#btn-delete-comment').click({commentId: data[i].id, setId: data[i].setId}, function (event) {
                        var button = $(this);
                        if (!$(button).hasClass('disabled')) {
                            lockButton(button, true, 'fa-trash');
                            event.preventDefault();
                            showCursor($('body'), CURSOR_PROGRESS);
                            deleteGestureSetComment({commentId: event.data.commentId, setId: event.data.setId}, function (result) {
                                showCursor($('body'), CURSOR_DEFAULT);
                                unlockButton(button, true, 'fa-trash');
                                if (result.status === RESULT_SUCCESS) {
                                    renderComments(result.comments);
                                    if (!result.comments) {
                                        $(currentPreviewGestureSet.thumbnail).find('.btn-comment-set .amount').text('');
                                        $(currentPreviewGestureSet.thumbnail).find('.btn-comment-set .fa').removeClass('fa-comments').addClass('fa-comment-o');
                                    } else {
                                        $(currentPreviewGestureSet.thumbnail).find('.btn-comment-set .amount').text(result.comments.length);
                                        $(currentPreviewGestureSet.thumbnail).find('.btn-comment-set .fa').removeClass('fa-comment-o').addClass('fa-comments');
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
            appendAlert($('#tab-gesture-set-comments'), ALERT_NO_COMMENTS);
        }
    }

    /*
     * gesture set adding and attached rendering
     */
    function renderAttachedGestures() {
        var listContainer = $('#tab-gesture-set-gestures').find('#attached-gestures').empty();
        var gestureIds = currentPreviewGestureSet.set.gestures;
        if (gestureIds && gestureIds.length > 0) {
            for (var i = 0; i < gestureIds.length; i++) {
                var gesture = getGestureById(gestureIds[i]);
                var clone = getGestureCatalogListThumbnail(gesture, 'gesture-set-thumbnail', 'col-xs-12 col-sm-6 col-md-4');
                $(listContainer).append(clone);
//                console.log(gesture);
            }

            $(listContainer).unbind('removedGestureFromSet').bind('removedGestureFromSet', function (event, gestureId) {
                event.preventDefault();
                console.log('removed Gesture from set', gestureId);
                renderAttachedGestures();
                $(modal).trigger('gestureSetsUpdated', [gestureId]);
            });
        } else {
            // append alert
        }
    }
//
//    function renderModalGestureSets(preselect, id) {
//        var sets = getLocalItem(GESTURE_SETS);
////        console.log('render attached gesture sets', sets);
//        if (sets && sets !== null && sets !== '' && sets.length > 0) {
//            var container = $('#add-to-gesture-set #existing-sets-container');
//            container.find('.option-container').empty();
//
//            for (var i = 0; i < sets.length; i++) {
//                var option = $('#template-general-container').find('#checkbox').clone();
//                option.find('.option-text').text(sets[i].title);
//                option.find('.btn-checkbox').attr('id', sets[i].id);
//                container.find('.option-container').append(option);
//                container.find('.option-container').append(document.createElement('br'));
//
//                // preselect item after adding new gesture set
//                if (preselect === true && id && parseInt(id) === parseInt(sets[i].id)) {
//                    option.find('.btn-checkbox').click();
//                }
//
//                // check gestures and make checkbox selected if gesture is in gesture set [i]
//                if (sets[i].gestures && sets[i].gestures.length > 0) {
//                    if (checkSetAssignment(sets[i].gestures, currentPreviewGesture.gesture.id)) {
//                        option.find('.btn-checkbox').click();
//                    }
//                }
//            }
//
//            $('#add-to-gesture-set .create-gesture-set-input').unbind('gestureSetCreated').bind('gestureSetCreated', function (event, newSetId) {
//                event.preventDefault();
//                getGestureSets(function (result) {
//                    if (result.status === RESULT_SUCCESS) {
//                        setLocalItem(GESTURE_SETS, result.gestureSets);
//                        renderModalGestureSets(true, newSetId);
//                    }
//                });
//            });
//
//            $(container).unbind('change').bind('change', function (event) {
//                event.preventDefault();
//                saveGestureSets();
//            });
//
//            function saveGestureSets() {
//                var listItems = $(container).find('.option-container').find('.btn-checkbox');
//                for (var i = 0; i < listItems.length; i++) {
//                    if ($(listItems[i]).hasClass('btn-option-checked')) {
//                        addToGestureSet($(listItems[i]).attr('id'), currentPreviewGesture.gesture.id);
//                    } else {
//                        removeFromGestureSet($(listItems[i]).attr('id'), currentPreviewGesture.gesture.id);
//                    }
//                }
//
//                // call ajax update gesture sets, calling php 
//                updateGestureSets({sets: getLocalItem(GESTURE_SETS)}, function (result) {
//                    var gestureSets = getLocalItem(GESTURE_SETS);
//                    if (gestureSets) {
//                        var titles = "";
//                        for (var i = 0; i < gestureSets.length; i++) {
//                            var gestureSetIds = gestureSets[i].gestures;
//                            if (gestureSetIds) {
//                                for (var j = 0; j < gestureSetIds.length; j++) {
//                                    if (parseInt(currentPreviewGesture.gesture.id) === parseInt(gestureSetIds[j])) {
//                                        titles += '<div>' + gestureSets[i].title + '</div>';
//                                    }
//                                }
//                            }
//                        }
//                        if (titles.length > 0) {
//                            $(currentPreviewGesture.thumbnail).find('.btn-edit-gesture-set').addClass('gesture-is-in-set');
//                            $(currentPreviewGesture.thumbnail).find('.btn-edit-gesture-set').attr('data-content', titles);
//                        } else {
//                            $(currentPreviewGesture.thumbnail).find('.btn-edit-gesture-set').removeClass('gesture-is-in-set');
//                            $(currentPreviewGesture.thumbnail).find('.btn-edit-gesture-set').attr('data-content', translation.notAssignedToGestureSet);
//                        }
//                    }
//
//                    $(container).trigger('gestureSetsUpdated', [currentPreviewGesture.gesture.id]);
//                });
//            }
//        } else {
//            appendAlert($('#add-to-gesture-set'), ALERT_NO_GESTURE_SETS_FOR_STUDY);
//        }
//    }

    function inputsValid(showErrors) {
        var container = $(modal).find('#gesture-set-edit-general-info-container');
        var title = $(container).find('#gesture-set-name-input').val().trim();
        if (title === '') {
            if (showErrors) {
                appendAlert(container, ALERT_MISSING_FIELDS);
            } else {
                removeAlert(container, ALERT_MISSING_FIELDS);
            }
            return false;
        }

        // return true, no more fields needed to be checked for gesture set meta data
        return true;

        var context = $(container).find('#gesture-set-context-input').val().trim();
        if (context === '') {
            if (showErrors) {
                appendAlert(container, ALERT_MISSING_FIELDS);
            } else {
                removeAlert(container, ALERT_MISSING_FIELDS);
            }
            return false;
        }

        var association = $(container).find('#gesture-set-association-input').val().trim();
        if (association === '') {
            if (showErrors) {
                appendAlert(container, ALERT_MISSING_FIELDS);
            } else {
                removeAlert(container, ALERT_MISSING_FIELDS);
            }
            return false;
        }

        var description = $(container).find('#gesture-set-description-input').val().trim();
        if (description === '') {
            if (showErrors) {
                appendAlert(container, ALERT_MISSING_FIELDS);
            } else {
                removeAlert(container, ALERT_MISSING_FIELDS);
            }
            return false;
        }

        return true;
    }

    function updateGestureSetSharingInfos() {
        var set = currentPreviewGestureSet.set;
        var shareButton = $(modal).find('.btn-share-set');
        $(modal).find('#gesture-set-scope #public').addClass('hidden');
        $(modal).find('#gesture-set-scope #private').addClass('hidden');
        $(modal).find('#gesture-set-scope #' + set.scope).removeClass('hidden');
        $(modal).find('#gesture-set-scope .label-text').text(translation.gestureScopes[set.scope]);

        if (set.isOwner === true) {
            $(modal).find('#gesture-rating #btn-rate-gesture').remove();

            $(shareButton).removeClass('hidden');
            if (set.scope === SCOPE_GESTURE_PRIVATE) {
                shareButton.removeClass('gesture-shared');
                $(modal).find('#gesture-sharing .shared-self').text(translation.gestureSetNotShared);
            } else {
                shareButton.addClass('gesture-shared');
                $(modal).find('#gesture-sharing .shared-self').text(translation.gestureSetShared);
            }

            if (set.source !== SOURCE_GESTURE_TESTER) {
                modal.find('#gesture-source .label-text').text(translation.gestureSources[SOURCE_GESTURE_OWN]);
                modal.find('#gesture-source #' + SOURCE_GESTURE_OWN).removeClass('hidden');
            } else {
                modal.find('#gesture-source .label-text').text(translation.gestureSources[SOURCE_GESTURE_TESTER]);
                modal.find('#gesture-source #' + SOURCE_GESTURE_TESTER).removeClass('hidden');
            }
        } else {
            $(modal).find('#gesture-owner-controls').remove();
            $(shareButton).remove();
            $(modal).find('#gesture-sharing .shared-self').remove();

            if (set.source !== SOURCE_GESTURE_TESTER) {
                modal.find('#gesture-source .label-text').text(translation.gestureSources[SOURCE_GESTURE_EVALUATOR]);
                modal.find('#gesture-source #' + SOURCE_GESTURE_EVALUATOR).removeClass('hidden');
            } else {
                modal.find('#gesture-source .label-text').text(translation.gestureSources[SOURCE_GESTURE_TESTER]);
                modal.find('#gesture-source #' + SOURCE_GESTURE_TESTER).removeClass('hidden');
            }
        }

        if (set.invitedUsers && set.invitedUsers.length > 0) {
            $(modal).find('#gesture-set-scope #public').addClass('hidden');
            $(modal).find('#gesture-set-scope #private').addClass('hidden');
            $(modal).find('#gesture-set-scope #public').removeClass('hidden');
            $(modal).find('#gesture-set-scope .label-text').text(translation.gestureScopes.public);
        }
    }

    function updateGestureSetSharing() {
        var modal = $('#custom-modal');

        initShareGestureSetModalButton($(modal).find('#gesture-set-sharing .btn-share-set'), currentPreviewGestureSet.thumbnail, currentPreviewGestureSet.source, currentPreviewGestureSet.set, function () {
            var button = $(modal).find('#gesture-set-sharing .btn-share-set');
            updateGestureSetSharingInfos();

            if (currentPreviewGestureSet.set.scope === SCOPE_GESTURE_PUBLIC) {
                $(modal).find('#gesture-set-sharing .shared-self').text(translation.gestureSetShared);
                $(button).addClass('gesture-set-shared');
            } else {
                $(modal).find('#gesture-set-sharing .shared-self').text(translation.gestureSetNotShared);
                $(button).removeClass('gesture-set-shared');
            }
        });
    }

    function renderInvitedGestureSetUsers() {
        var invitedUsers = currentPreviewGestureSet.set.invitedUsers;
        $(modal).find('#shared-gesture-sets-list').empty();
        clearAlerts($(modal).find('#invited-users'));

        if (invitedUsers && invitedUsers.length > 0) {
            for (var i = 0; i < invitedUsers.length; i++) {
                var listItem = $('#shared-gesture-set-list-item').clone().removeAttr('id');
                $(listItem).find('.shared-gesture-set-item-email').text(invitedUsers[i].email);
                $(listItem).find('.btn-uninvite-user').attr('data-invite-id', invitedUsers[i].id);
                $(listItem).find('.btn-uninvite-user').attr('data-invite-mail', invitedUsers[i].email);
                $(modal).find('#shared-gesture-sets-list').append(listItem);
            }
        } else {
            appendAlert($(modal).find('#invited-users'), ALERT_GESTURE_SET_NOT_SHARED);
        }

        $(modal).find('#invited-users #input-email').unbind('keyup').bind('keyup', function (event) {
            event.preventDefault();
            clearAlerts($(modal).find('#invite-users-form'));
        });

        $(modal).find('#invited-users #btn-invite-user').unbind('click').bind('click', function (event) {
            event.preventDefault();
            var button = $(this);
            if (!$(button).hasClass('disabled')) {
                lockButton(button, true, 'fa-paper-plane');

                var email = $(modal).find('#invited-users #input-email');
                if ($(email).val().trim() === '') {
                    appendAlert($(modal).find('#invited-users'), ALERT_MISSING_EMAIL);
                    unlockButton(button, true, 'fa-paper-plane');
                    $(email).focus();
                    return false;
                }

                // validate email
                if (!validateEmail($(email).val().trim())) {
                    appendAlert($(modal).find('#invited-users'), ALERT_INVALID_EMAIL);
                    unlockButton(button, true, 'fa-paper-plane');
                    $(email).focus();
                    return false;
                }

                shareGestureSetForUser({setId: currentPreviewGestureSet.set.id, email: email.val().trim()}, function (result) {
                    unlockButton(button, true, 'fa-paper-plane');
                    if (result.status === RESULT_SUCCESS) {
//                        var inviteAmount = result.invitedUsers && result.invitedUsers.length > 0 ? result.invitedUsers.length : 0;
                        updateGestureSetById(GESTURE_SETS, currentPreviewGestureSet.set.id, {invitedUsers: result.invitedUsers});
                        currentPreviewGestureSet.set = getGestureSetById(currentPreviewGestureSet.set.id);
                        originalFilterData = getLocalItem(GESTURE_SETS);
                        $(email).val('');
                        renderInvitedGestureSetUsers();
                        updateGestureSetThumbnailSharing(currentPreviewGestureSet.thumbnail, currentPreviewGestureSet.set);
                        updateGestureSetSharingInfos();

                    } else if (result.status === 'userAlreadyInvited') {
                        $(email).val('');
                        appendAlert($(modal).find('#invite-users-form'), ALERT_USER_ALREADY_INVITED);
                    } else if (result.status === 'notInviteYourself') {
                        $(email).val('');
                        appendAlert($(modal).find('#invite-users-form'), ALERT_SHARE_GESTURE_SET_TO_YOURSELF);
                    }
                });
            }
        });
    }

    $(modal).on('click', '.btn-uninvite-user', function (event) {
        event.preventDefault();
        var button = $(this);
        if (!$(button).hasClass('disabled')) {
            lockButton(button, true, 'fa-trash');
            unshareGestureSetForUser({setId: currentPreviewGestureSet.set.id, id: $(this).attr('data-invite-id'), email: $(this).attr('data-invite-mail')}, function (result) {
                unlockButton(button, true, 'fa-trash');
                if (result.status === RESULT_SUCCESS) {
                    updateGestureSetById(GESTURE_SETS, currentPreviewGestureSet.set.id, {invitedUsers: result.invitedUsers});
                    currentPreviewGestureSet.set = getGestureSetById(currentPreviewGestureSet.set.id);
                    originalFilterData = getLocalItem(GESTURE_SETS);
                    renderInvitedGestureSetUsers();
                    updateGestureSetThumbnailSharing(currentPreviewGestureSet.thumbnail, currentPreviewGestureSet.set);
                    updateGestureSetSharingInfos();
                }
            });
        }
    });
</script>