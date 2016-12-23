<?php
include '../includes/language.php';
?>

<!-- ALERTS -->
<div id="alert-container" class="hidden">
    <div class="alert alert-danger"  id="general-error" role="alert"><i class="glyphicon glyphicon-alert"></i> <span class="alert-text"><?php echo $lang->alerts->generalError->text ?></span></div>
    <div class="alert alert-warning" id="missing-fields" role="alert"><i class="glyphicon glyphicon-alert"></i> <span class="alert-text"><?php echo $lang->alerts->missingFields->text ?></span></div>
    <div class="alert alert-warning" id="missing-email" role="alert"><i class="glyphicon glyphicon-alert"></i> <span class="alert-text"><?php echo $lang->alerts->missingEmail->text ?></span></div>
    <div class="alert alert-warning" id="login-failed" role="alert"><i class="glyphicon glyphicon-alert"></i> <span class="alert-text"><?php echo $lang->alerts->loginFailed->text ?></span></div>
    <div class="alert alert-danger"  id="account-logged" role="alert"><i class="glyphicon glyphicon-alert"></i> <span class="alert-text"><?php echo $lang->alerts->accountLogged->text ?></span></div>
    <div class="alert alert-warning" id="invalid-email" role="alert"><i class="glyphicon glyphicon-alert"></i> <span class="alert-text"><?php echo $lang->alerts->invalidEmail->text ?></span></div>
    <div class="alert alert-warning" id="check-email" role="alert"><i class="glyphicon glyphicon-alert"></i> <span class="alert-text"><?php echo $lang->alerts->checkEmail->text ?></span></div>
    <div class="alert alert-success" id="password-reset-send" role="alert"><i class="glyphicon glyphicon-alert"></i> <span class="alert-text"><?php echo $lang->alerts->passwordResetSend->text ?></span></div>
    <div class="alert alert-success" id="password-reset-success" role="alert"><i class="glyphicon glyphicon-alert"></i> <span class="alert-text"><?php echo $lang->alerts->passwordResetSuccess->text ?></span></div>
    <div class="alert alert-warning" id="reset-password-error" role="alert"><i class="glyphicon glyphicon-alert"></i> <span class="alert-text"><?php echo $lang->alerts->resetPasswordError->text ?></span></div>
    <div class="alert alert-warning" id="wrong-password" role="alert"><i class="glyphicon glyphicon-alert"></i> <span class="alert-text"><?php echo $lang->alerts->wrongPassword->text ?></span></div>
    <div class="alert alert-warning" id="password-short" role="alert"><i class="glyphicon glyphicon-alert"></i> <span class="alert-text"><?php echo $lang->alerts->passwordShort->text ?></span></div>
    <div class="alert alert-warning" id="password-invalid" role="alert"><i class="glyphicon glyphicon-alert"></i> <span class="alert-text"><?php echo $lang->alerts->passwordInvalid->text ?></span></div>
    <div class="alert alert-warning" id="passwords-not-matching" role="alert"><i class="glyphicon glyphicon-alert"></i> <span class="alert-text"><?php echo $lang->alerts->passwordsNotMatching->text ?></span></div>
    <div class="alert alert-warning" id="invalid-birthday" role="alert"><i class="glyphicon glyphicon-alert"></i> <span class="alert-text"><?php echo $lang->alerts->invalidBirthday->text ?></span></div>
    <div class="alert alert-warning" id="user-exists" role="alert"><i class="glyphicon glyphicon-alert"></i> <span class="alert-text"><?php echo $lang->alerts->userExists->text ?></span></div>
    <div class="alert alert-warning" id="no-user-exists" role="alert"><i class="glyphicon glyphicon-alert"></i> <span class="alert-text"><?php echo $lang->alerts->noUserExists->text ?></span></div>
    <div class="alert alert-success" id="register-success" role="alert"><i class="glyphicon glyphicon-ok"></i> <span class="alert-text"><?php echo $lang->alerts->registerSuccess->text ?></span></div>
    <div class="alert alert-warning" id="wrong-current-password" role="alert"><i class="glyphicon glyphicon-alert"></i> <span class="alert-text"><?php echo $lang->alerts->wrongCurrentPassword->text ?></span></div>
    <div class="alert alert-danger"  id="no-gestures-assembled" role="alert"><i class="glyphicon glyphicon-alert"></i> <span class="alert-text"><?php echo $lang->alerts->noGesturesAssembled->text ?></span></div>
    <div class="alert alert-warning" id="assembled-gesture-removed" role="alert"><i class="glyphicon glyphicon-trash"></i> <span class="alert-text"><?php echo $lang->alerts->assembledGestureRemoved->text ?></span></div>
    <div class="alert alert-danger"  id="no-trigger-assembled" role="alert"><i class="glyphicon glyphicon-alert"></i> <span class="alert-text"><?php echo $lang->alerts->noTriggerAssembled->text ?></span></div>
    <div class="alert alert-warning" id="assembled-trigger-removed" role="alert"><i class="glyphicon glyphicon-trash"></i> <span class="alert-text"><?php echo $lang->alerts->assembledTriggerRemoved->text ?></span></div>
    <div class="alert alert-danger"  id="no-feedback-assembled" role="alert"><i class="glyphicon glyphicon-alert"></i> <span class="alert-text"><?php echo $lang->alerts->noFeedbackAssembled->text ?></span></div>
    <div class="alert alert-warning" id="assembled-feedback-removed" role="alert"><i class="glyphicon glyphicon-trash"></i> <span class="alert-text"><?php echo $lang->alerts->assembledFeedbackRemoved->text ?></span></div>
    <div class="alert alert-danger"  id="no-title" role="alert"><i class="glyphicon glyphicon-alert"></i> <span class="alert-text"><?php echo $lang->alerts->noTitle->text ?></span></div>
    <div class="alert alert-danger"  id="no-scenes-assembled" role="alert"><i class="glyphicon glyphicon-alert"></i> <span class="alert-text"><?php echo $lang->alerts->noScenesAssembled->text ?></span></div>
    <div class="alert alert-warning" id="assembled-scene-removed" role="alert"><i class="glyphicon glyphicon-trash"></i> <span class="alert-text"><?php echo $lang->alerts->assembledSceneRemoved->text ?></span></div>
    <div class="alert alert-warning" id="pidoco-embed-url-invalid" role="alert"><i class="glyphicon glyphicon-alert"></i> <span class="alert-text"><?php echo $lang->alerts->pidocoEmbedUrlInvalid->text ?></span></div>
    <div class="alert alert-warning" id="pidoco-edit-url-invalid" role="alert"><i class="glyphicon glyphicon-alert"></i> <span class="alert-text"><?php echo $lang->alerts->pidocoEditUrlInvalid->text ?></span></div>
    <div class="alert alert-warning" id="video-embed-url-invalid" role="alert"><i class="glyphicon glyphicon-alert"></i> <span class="alert-text"><?php echo $lang->alerts->videoEmbedUrlInvalid->text ?></span></div>
    <div class="alert alert-warning" id="no-search-results" role="alert"><i class="glyphicon glyphicon-alert"></i> <span class="alert-text"><?php echo $lang->alerts->noSearchResults->text ?></span></div>
    <div class="alert alert-warning" id="no-phase-data" role="alert"><i class="glyphicon glyphicon-alert"></i> <span class="alert-text"><?php echo $lang->alerts->noPhaseData->text ?></span></div>
    <div class="alert alert-warning" id="waiting-for-training-gesture" role="alert"><i class="glyphicon glyphicon-alert"></i> <span class="alert-text"><?php echo $lang->alerts->waitingForTrainingGesture->text ?></span></div>
    <div class="alert alert-warning" id="waiting-for-slideshow" role="alert"><i class="glyphicon glyphicon-alert"></i> <span class="alert-text"><?php echo $lang->alerts->waitingForSlideshow->text ?></span></div>
    <div class="alert alert-warning" id="waiting-for-identification" role="alert"><i class="glyphicon glyphicon-alert"></i> <span class="alert-text"><?php echo $lang->alerts->waitingForIdentification->text ?></span></div>
    <div class="alert alert-warning" id="waiting-for-scenario-start" role="alert"><i class="glyphicon glyphicon-alert"></i> <span class="alert-text"><?php echo $lang->alerts->waitingForScenarioStart->text ?></span></div>
    <div class="alert alert-danger"  id="web-rtc-not-supported" role="alert"><i class="glyphicon glyphicon-alert"></i> <span class="alert-text"><?php echo $lang->alerts->webRTCNotSupported->text ?></span></div>
    <div class="alert alert-warning" id="another-browser-needed-for-web-rtc" role="alert"><i class="glyphicon glyphicon-alert"></i> <span class="alert-text"><?php echo $lang->alerts->anotherBrowserNeededForWebRTC->text ?></span></div>
    <div class="alert alert-danger"  id="no-storage-api" role="alert"><i class="glyphicon glyphicon-alert"></i> <span class="alert-text"><?php echo $lang->alerts->noStorageAPI->text ?></span></div>
    <div class="alert alert-danger"  id="gesture-too-short" role="alert"><i class="glyphicon glyphicon-alert"></i> <span class="alert-text"><?php echo $lang->alerts->gestureTooShort->text ?></span></div>
    <div class="alert alert-success" id="gesture-save-success" role="alert"><i class="glyphicon glyphicon-info-sign"></i> <span class="alert-text"><?php echo $lang->alerts->gestureSaveSuccess->text ?></span></div>
    <div class="alert alert-success" id="gesture-delete-success" role="alert"><i class="glyphicon glyphicon-info-sign"></i> <span class="alert-text"><?php echo $lang->alerts->gestureDeleteSuccess->text ?></span></div>
    <div class="alert alert-warning" id="no-gestures" role="alert"><i class="glyphicon glyphicon-alert"></i> <span class="alert-text"><?php echo $lang->alerts->noGestures->text ?></span></div>
    <div class="alert alert-warning" id="no-studies" role="alert"><i class="glyphicon glyphicon-alert"></i> <span class="alert-text"><?php echo $lang->alerts->noStudies->text ?></span></div>
    <div class="alert alert-warning" id="study-unmoderated" role="alert"><i class="glyphicon glyphicon-alert"></i> <span class="alert-text"><?php echo $lang->alerts->studyUnmoderated->text1 ?> <strong><?php echo $lang->alerts->studyUnmoderated->text2 ?></strong>. <?php echo $lang->alerts->studyUnmoderated->text3 ?></span>  <a href="#" id="btn-open-study-details" class="alert-link"><?php echo $lang->alerts->studyUnmoderated->text4 ?></a> <i class="fa fa-file-text" aria-hidden="true"></i></div>
    <div class="alert alert-success" id="rating-submitted" role="alert"><i class="glyphicon glyphicon-info-sign"></i> <span class="alert-text"><?php echo $lang->alerts->ratingSubmitted->text ?></span></div>
    <div class="alert alert-warning" id="no-comments" role="alert"><i class="glyphicon glyphicon-info-sign"></i> <span class="alert-text"><?php echo $lang->alerts->noComments->text ?></span></div>
    <div class="alert alert-danger"  id="contact-support" role="alert"><i class="glyphicon glyphicon-alert"></i> <span class="alert-text"><?php echo $lang->alerts->contactSupport->text ?></span> <a href="mailto:support@gesturenote.com">Support</a>.</div>
    <div class="alert alert-danger"  id="sus-invalid" role="alert"><i class="glyphicon glyphicon-alert"></i> <span class="alert-text"><?php echo $lang->alerts->susInvalid->text ?></span></div>
    <div class="alert alert-warning" id="webm-unsupported" role="alert"><i class="glyphicon glyphicon-alert"></i> <span class="alert-text"><?php echo $lang->alerts->webmUnsupported->text ?></span></div>
    <div class="alert alert-warning" id="no-record" role="alert"><i class="glyphicon glyphicon-alert"></i> <span class="alert-text"><?php echo $lang->alerts->noRecord->text ?></span></div>
    <div class="alert alert-danger"  id="record-url-invalid" role="alert"><i class="glyphicon glyphicon-alert"></i> <span class="alert-text"><?php echo $lang->alerts->recordUrlInvalid->text ?></span></div>
    <div class="alert alert-warning" id="waiting-for-moderator" role="alert"><i class="glyphicon glyphicon-alert"></i> <span class="alert-text"><?php echo $lang->alerts->waitingForModerator->text ?></span></div>
    <div class="alert alert-warning" id="no-participation-requests" role="alert"><i class="glyphicon glyphicon-alert"></i> <span class="alert-text"><?php echo $lang->alerts->noParticipationRequests->text ?></span></div>
    <div class="alert alert-warning" id="study-over-range" role="alert"><i class="glyphicon glyphicon-alert"></i> <span class="alert-text"><?php echo $lang->alerts->studyOverRange->text ?></span></div>
    <div class="alert alert-warning" id="study-under-range" role="alert"><i class="glyphicon glyphicon-alert"></i> <span class="alert-text"><?php echo $lang->alerts->studyUnderRange->text ?></span></div>
    <div class="alert alert-warning" id="please-wait" role="alert"><i class="glyphicon glyphicon-alert"></i> <span class="alert-text"><?php echo $lang->alerts->pleaseWait->text ?></span></div>
    <div class="alert alert-warning" id="no-recorded-gestures" role="alert"><i class="glyphicon glyphicon-alert"></i> <span class="alert-text"><?php echo $lang->alerts->noRecordedGestures->text ?></span></div>
    <div class="alert alert-warning" id="no-gestures-classified" role="alert"><i class="glyphicon glyphicon-alert"></i> <span class="alert-text"><?php echo $lang->alerts->noGesturesClassified->text ?></span></div>
    <div class="alert alert-warning" id="no-more-gestures-for-classification" role="alert"><i class="glyphicon glyphicon-alert"></i> <span class="alert-text"><?php echo $lang->alerts->noMoreGesturesForClassification->text ?></span></div>
    <div class="alert alert-warning" id="no-plan" role="alert"><i class="glyphicon glyphicon-alert"></i> <span class="alert-text"><?php echo $lang->alerts->noPlan->text ?></span></div>
</div>