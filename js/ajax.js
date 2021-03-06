/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function getQueryParams(qs) {
//    qs = qs.split('+').join('%252b');

    var params = {},
            tokens,
            re = /[?&]?([^=]+)=([^&]*)/g;

    while (tokens = re.exec(qs)) {
        params[decodeURIComponent(tokens[1])] = decodeURIComponent(tokens[2]);
    }

    return params;
}

function ajaxError(xhr, desc, err) {
    appendAlert($('body'), ALERT_GENERAL_ERROR);
    console.log(xhr);
    console.log("Details: " + desc + "\nError:" + err);
}

function changeLanguage(data, callback) {
    $.ajax({
        url: 'includes/change-language.php',
        data: data,
        type: 'post',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

function getLanguage(callback) {
    $.ajax({
        url: 'includes/get-language.php',
        type: 'post',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

function acceptCookies(callback) {
    $.ajax({
        url: 'includes/accept-cookies.php',
        type: 'post',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

function login(data, callback) {
    $.ajax({
        url: 'includes/process_login.php',
        data: data,
        type: 'post',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}


function requestPasswordReset(data, callback) {
    $.ajax({
        url: 'includes/request-password-reset.php',
        data: data,
        type: 'post',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

function resetPassword(data, callback) {
    $.ajax({
        url: 'includes/reset-password.php',
        data: data,
        type: 'post',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

function register(data, callback) {
    $.ajax({
        url: 'includes/register.php',
        data: data,
        type: 'post',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

function requestContact(data, callback) {
    $.ajax({
        url: 'includes/request-contact.php',
        data: data,
        type: 'post',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

function getUser(callback) {
    $.ajax({
        url: 'includes/get-user.php',
        type: 'post',
        dataType: 'json',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

function updateUser(data, callback) {
    $.ajax({
        url: 'includes/update-user.php',
        type: 'post',
        dataType: 'json',
        data: data,
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

function updateIntroduction(data, callback) {
    var url = null;
    switch (data.context) {
        case 'studyCreation':
            url = 'includes/update-introduction-study-creation.php';
            break;
        case 'studyPreview':
            url = 'includes/update-introduction-study-preview.php';
            break;
        case 'study':
            url = 'includes/update-introduction-study.php';
            break;
        case 'extraction':
            url = 'includes/update-introduction-extraction.php';
            break;
        case 'participant':
            url = 'includes/update-introduction-participant.php';
            break;
        case 'gestureCatalog':
            url = 'includes/update-introduction-gesture-catalog.php';
            break;
    }

    $.ajax({

        url: url,
        type: 'post',
        dataType: 'json',
        data: data,
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}



/*
 * dashboard info footage
 */

function getDashboardInfos(callback) {
    $.ajax({
        url: 'includes/get-dashboard-infos.php',
        type: 'post',
        dataType: 'json',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}


/*
 * submit rating for a specific gesture
 */
function submitRatingForGesture(data, callback) {
    $.ajax({
        url: 'includes/submit-rating.php',
        data: data,
        type: 'post',
        dataType: 'json',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

/*
 * image upload
 */

function uploadSceneImage(data, callback) {
    $.ajax({
        url: 'includes/upload-scene-image.php',
        type: 'post',
        processData: false,
        contentType: false,
        cache: false,
        data: data,
        async: true,
        success: function (data) {
            if (callback) {
                callback(data);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

function deleteSceneImage(data, callback) {
    $.ajax({
        url: 'includes/delete-scene-image.php',
        data: data,
        type: 'post',
        dataType: 'json',
        async: true,
        success: function (data) {
            if (callback) {
                callback(data);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

/*
 * sound upload
 */

function uploadSound(data, callback) {
    $.ajax({
        type: 'post',
        url: 'includes/upload-sound.php',
        processData: false,
        contentType: false,
        cache: false,
        data: data,
        async: true,
        dataType: 'json',
        success: function (data) {
            if (callback) {
                callback(data);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

function deleteSound(data, callback) {
    $.ajax({
        url: 'includes/delete-sound.php',
        data: data,
        type: 'post',
        dataType: 'json',
        async: true,
        success: function (data) {
            if (callback) {
                callback(data);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

/*
 * studies handling
 * save, delete, get, update
 */

function saveStudy(data, callback) {
    $.ajax({
        ContentType: 'application/x-www-form-urlencoded; charset=UTF-8',
        dataType: 'json',
        url: 'includes/save-study.php',
        data: data,
        type: 'post',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

function updateStudy(data, callback) {
    $.ajax({
        ContentType: 'application/x-www-form-urlencoded; charset=UTF-8',
        dataType: 'json',
        url: 'includes/update-study.php',
        data: data,
        type: 'post',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

function deleteStudy(data, callback) {
    $.ajax({
        ContentType: 'application/x-www-form-urlencoded; charset=UTF-8',
        dataType: 'json',
        url: 'includes/delete-study.php',
        data: data,
        type: 'post',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

function deleteStudyResult(data, callback) {
    $.ajax({
        ContentType: 'application/x-www-form-urlencoded; charset=UTF-8',
        dataType: 'json',
        url: 'includes/delete-study-result.php',
        data: data,
        type: 'post',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

function inviteUser(data, callback) {
    $.ajax({
        ContentType: 'application/x-www-form-urlencoded; charset=UTF-8',
        dataType: 'json',
        url: 'includes/invite-user.php',
        data: data,
        type: 'post',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

function uninviteUser(data, callback) {
    $.ajax({
        ContentType: 'application/x-www-form-urlencoded; charset=UTF-8',
        dataType: 'json',
        url: 'includes/uninvite-user.php',
        data: data,
        type: 'post',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}


///*
// * extraction study
// */
//
///*
// * studies handling
// * save, delete, get, update
// */
//
//function saveExtractionStudy(data, callback) {
//    $.ajax({
//        ContentType: 'application/x-www-form-urlencoded; charset=UTF-8',
//        dataType: 'json',
//        url: 'includes/save-extraction-study.php',
//        data: data,
//        type: 'post',
//        async: true,
//        success: function (result) {
//            if (callback) {
//                callback(result);
//            }
//        },
//        error: function (xhr, desc, err) {
//            ajaxError(xhr, desc, err);
//        }
//    });
//}
//
//function updateExtractionStudy(data, callback) {
//    $.ajax({
//        ContentType: 'application/x-www-form-urlencoded; charset=UTF-8',
//        dataType: 'json',
//        url: 'includes/update-extraction-study.php',
//        data: data,
//        type: 'post',
//        async: true,
//        success: function (result) {
//            if (callback) {
//                callback(result);
//            }
//        },
//        error: function (xhr, desc, err) {
//            ajaxError(xhr, desc, err);
//        }
//    });
//}
//
//function deleteExtractionStudy(data, callback) {
//    $.ajax({
//        ContentType: 'application/x-www-form-urlencoded; charset=UTF-8',
//        dataType: 'json',
//        url: 'includes/delete-extraction-study.php',
//        data: data,
//        type: 'post',
//        async: true,
//        success: function (result) {
//            if (callback) {
//                callback(result);
//            }
//        },
//        error: function (xhr, desc, err) {
//            ajaxError(xhr, desc, err);
//        }
//    });
//}


/*
 * study execution
 */

function prepareStudyExecution(data, callback) {
    $.ajax({
        ContentType: 'application/x-www-form-urlencoded; charset=UTF-8',
        dataType: 'json',
        url: 'includes/prepare-study-execution.php',
        data: data,
        type: 'post',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

function getStudyResults(data, callback) {
    $.ajax({
        ContentType: 'application/x-www-form-urlencoded; charset=UTF-8',
        dataType: 'json',
        url: 'includes/get-study-results.php',
        data: data,
        type: 'post',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

function getExtractionData(data, callback) {
    $.ajax({
        url: 'includes/get-extraction-data.php',
        data: data,
        type: 'post',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

function saveExtractionData(data, callback) {
    $.ajax({
        url: 'includes/save-extraction-data.php',
        data: data,
        type: 'post',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

function getSharedGestureInfos(data, callback) {
    $.ajax({
        url: 'includes/get-shared-gesture-infos.php',
        data: data,
        type: 'post',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

function getGestureSets(callback) {
    $.ajax({
        url: 'includes/get-gesture-sets.php',
        type: 'post',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

//function getGestureSetsForStudyId(data, callback) {
//    $.ajax({
//        url: 'includes/get-gesture-sets-for-study-id.php',
//        data: data,
//        type: 'post',
//        async: true,
//        success: function (result) {
//            if (callback) {
//                callback(result);
//            }
//        },
//        error: function (xhr, desc, err) {
//            ajaxError(xhr, desc, err);
//        }
//    });
//}

function saveGestureSet(data, callback) {
    $.ajax({
        url: 'includes/save-gesture-set.php',
        data: data,
        type: 'post',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

function saveGestureSetForStudyId(data, callback) {
    $.ajax({
        url: 'includes/save-gesture-set-for-study-id.php',
        data: data,
        type: 'post',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

function updateGestureSets(data, callback) {
    $.ajax({
        url: 'includes/update-gesture-sets.php',
        data: data,
        type: 'post',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

function deleteGestureSet(data, callback) {
    $.ajax({
        url: 'includes/delete-gesture-set.php',
        data: data,
        type: 'post',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

function deleteGestureSets(data, callback) {
    $.ajax({
        url: 'includes/delete-gesture-sets.php',
        data: data,
        type: 'post',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

function getStudiesCatalog(callback) {
    $.ajax({
        url: 'includes/get-studies.php',
        type: 'post',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

//function getStudiesCatalogForTester(callback) {
//    $.ajax({
//        url: 'includes/get-studies-tester.php',
//        type: 'post',
//        async: true,
//        success: function (result) {
//            if (callback) {
//                callback(result);
//            }
//        },
//        error: function (xhr, desc, err) {
//            ajaxError(xhr, desc, err);
//        }
//    });
//}

//function getAgeRange(callback) {
//    $.ajax({
//        url: 'includes/get-age-range.php',
//        type: 'post',
//        async: true,
//        success: function (result) {
//            if (callback) {
//                callback(result);
//            }
//        },
//        error: function (xhr, desc, err) {
//            ajaxError(xhr, desc, err);
//        }
//    });
//}

function getStudyById(data, callback) {
    $.ajax({
        url: 'includes/get-study.php',
        data: data,
        type: 'post',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

function getStudyParticipant(data, callback) {
    $.ajax({
        url: 'includes/get-study-participant.php',
        data: data,
        type: 'post',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

function getAllStudyParticipants(data, callback) {
    $.ajax({
        url: 'includes/get-all-study-results.php',
        data: data,
        type: 'post',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

function saveNotes(data, callback) {
    $.ajax({
        url: 'includes/save-notes.php',
        data: data,
        type: 'post',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

function getObservations(data, callback) {
    $.ajax({
        url: 'includes/get-observations.php',
        data: data,
        type: 'post',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

function saveObservations(data, callback) {
    $.ajax({
        url: 'includes/save-observations.php',
        data: data,
        type: 'post',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}



/*
 * gesture handling
 * save, delete, get catalog, update
 */

function saveRecordedGesture(data, callback) {
    $.ajax({
        url: 'includes/save-gesture.php',
        data: data,
        type: 'post',
        dataType: 'json',
        async: true,
        success: function (data) {
            if (callback) {
                callback(data);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

function deleteGesture(data, callback) {
    $.ajax({
        url: 'includes/delete-gesture.php',
        data: data,
        type: 'post',
        dataType: 'json',
        async: true,
        success: function (data) {
            if (callback) {
                callback(data);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

function getGestureCatalog(callback) {
    $.ajax({
        url: 'includes/get-gestures.php',
        type: 'post',
        dataType: 'json',
        async: true,
        success: function (result) {
            if (result.status === RESULT_SUCCESS) {
                setLocalItem(GESTURE_CATALOG, result.gestures);

                var gestureCatalog = getLocalItem(GESTURE_CATALOG);
                if (result.sharedSetGestures && result.sharedSetGestures.length > 0) {
                    if (gestureCatalog && gestureCatalog.length > 0) {
                        var tempGestures = [];
                        for (var i = 0; i < result.sharedSetGestures.length; i++) {
                            var sharedSetGestureExistsInCatalog = false;
                            var sharedSetGesture = result.sharedSetGestures[i];
                            for (var j = 0; j < gestureCatalog.length; j++) {
                                var gesture = gestureCatalog[j];
                                if (parseInt(sharedSetGesture.id) === parseInt(gesture.id)) {
                                    sharedSetGestureExistsInCatalog = true;
                                }
                            }

                            if (sharedSetGestureExistsInCatalog === false) {
                                tempGestures.push(sharedSetGesture);
                            }
                        }

                        gestureCatalog = gestureCatalog.concat(tempGestures);
                        setLocalItem(GESTURE_CATALOG, gestureCatalog);
                    } else {
                        setLocalItem(GESTURE_CATALOG, result.sharedSetGestures);
                    }
                }

                gestureCatalog = getLocalItem(GESTURE_CATALOG);
                if (result.sharedGestures && result.sharedGestures.length > 0) {
                    if (gestureCatalog && gestureCatalog.length > 0) {
                        var tempGestures = [];
                        for (var i = 0; i < result.sharedGestures.length; i++) {
                            var sharedGestureExistsInCatalog = false;
                            var sharedGesture = result.sharedGestures[i];
                            for (var j = 0; j < gestureCatalog.length; j++) {
                                var gesture = gestureCatalog[j];
                                if (parseInt(sharedGesture.id) === parseInt(gesture.id)) {
                                    sharedGestureExistsInCatalog = true;
                                }
                            }

                            if (sharedGestureExistsInCatalog === false) {
                                tempGestures.push(sharedGesture);
                            }
                        }

                        gestureCatalog = gestureCatalog.concat(tempGestures);
                        setLocalItem(GESTURE_CATALOG, gestureCatalog);
                    } else {
                        setLocalItem(GESTURE_CATALOG, result.sharedSetGestures);
                    }
                }

                gestureCatalog = getLocalItem(GESTURE_CATALOG);
                if (result.unsharedSetGestures && result.unsharedSetGestures.length > 0) {
                    if (gestureCatalog && gestureCatalog.length > 0) {
                        var tempGestures = [];
                        for (var i = 0; i < result.unsharedSetGestures.length; i++) {
                            var sharedGestureExistsInCatalog = false;
                            var sharedGesture = result.unsharedSetGestures[i];
                            for (var j = 0; j < gestureCatalog.length; j++) {
                                var gesture = gestureCatalog[j];
                                if (parseInt(sharedGesture.id) === parseInt(gesture.id)) {
                                    sharedGestureExistsInCatalog = true;
                                }
                            }

                            if (sharedGestureExistsInCatalog === false) {
                                tempGestures.push(sharedGesture);
                            }
                        }

                        gestureCatalog = gestureCatalog.concat(tempGestures);
                        setLocalItem(GESTURE_CATALOG, gestureCatalog);
                    } else {
                        setLocalItem(GESTURE_CATALOG, result.sharedSetGestures);
                    }
                }
            }

            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

function updateGesture(data, callback) {
    $.ajax({
        url: 'includes/update-gesture.php',
        data: data,
        type: 'post',
        dataType: 'json',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

function updateGestureSet(data, callback) {
    $.ajax({
        url: 'includes/update-gesture-set.php',
        data: data,
        type: 'post',
        dataType: 'json',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

function deleteGestureFiles(data, callback) {
    $.ajax({
        url: 'includes/delete-gesture-files.php',
        data: data,
        type: 'post',
        dataType: 'json',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}


/*
 * gesture sharing
 */

function shareGesture(data, callback) {
    $.ajax({
        url: 'includes/share-gesture.php',
        data: data,
        type: 'post',
        dataType: 'json',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

function unshareGesture(data, callback) {
    $.ajax({
        url: 'includes/unshare-gesture.php',
        data: data,
        type: 'post',
        dataType: 'json',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

/*
 * gesture sharing for specific user
 */

function shareGestureForUser(data, callback) {
    $.ajax({
        url: 'includes/share-gesture-for-user.php',
        data: data,
        type: 'post',
        dataType: 'json',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

function unshareGestureForUser(data, callback) {
    $.ajax({
        url: 'includes/unshare-gesture-for-user.php',
        data: data,
        type: 'post',
        dataType: 'json',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}


/*
 * gesture set sharing
 */

function shareGestureSet(data, callback) {
    $.ajax({
        url: 'includes/share-gesture-set.php',
        data: data,
        type: 'post',
        dataType: 'json',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

function unshareGestureSet(data, callback) {
    $.ajax({
        url: 'includes/unshare-gesture-set.php',
        data: data,
        type: 'post',
        dataType: 'json',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}


/*
 * gesture set sharing for specific user
 */

function shareGestureSetForUser(data, callback) {
    $.ajax({
        url: 'includes/share-gesture-set-for-user.php',
        data: data,
        type: 'post',
        dataType: 'json',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

function unshareGestureSetForUser(data, callback) {
    $.ajax({
        url: 'includes/unshare-gesture-set-for-user.php',
        data: data,
        type: 'post',
        dataType: 'json',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

/*
 * gesture liking
 */

function likeGesture(data, callback) {
    $.ajax({
        url: 'includes/like-gesture.php',
        data: data,
        type: 'post',
        dataType: 'json',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

function unlikeGesture(data, callback) {
    $.ajax({
        url: 'includes/unlike-gesture.php',
        data: data,
        type: 'post',
        dataType: 'json',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}


/*
 * gesture set liking
 */

function likeGestureSet(data, callback) {
    $.ajax({
        url: 'includes/like-gesture-set.php',
        data: data,
        type: 'post',
        dataType: 'json',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

function unlikeGestureSet(data, callback) {
    $.ajax({
        url: 'includes/unlike-gesture-set.php',
        data: data,
        type: 'post',
        dataType: 'json',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}


/*
 * gesture infos
 * rating & comments
 */
//function getGestureInfos(data, callback) {
//    $.ajax({
//        url: 'includes/get-gesture-infos.php',
//        data: data,
//        type: 'post',
//        dataType: 'json',
//        async: true,
//        success: function (result) {
//            if (callback) {
//                callback(result);
//            }
//        },
//        error: function (xhr, desc, err) {
//            ajaxError(xhr, desc, err);
//        }
//    });
//}

/*
 * gesture comments
 */
function getCommentsForGesture(data, callback) {
    $.ajax({
        url: 'includes/get-gesture-comments.php',
        data: data,
        type: 'post',
        dataType: 'json',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

/*
 * gesture set comments
 */
function getCommentsForGestureSet(data, callback) {
    $.ajax({
        url: 'includes/get-gesture-set-comments.php',
        data: data,
        type: 'post',
        dataType: 'json',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

function getRatingsForGesture(data, callback) {
    $.ajax({
        url: 'includes/get-gesture-ratings.php',
        data: data,
        type: 'post',
        dataType: 'json',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

function getLikesForGesture(data, callback) {
    $.ajax({
        url: 'includes/get-gesture-likes.php',
        data: data,
        type: 'post',
        dataType: 'json',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}


/*
 * gesture comments
 */
function submitCommentForGesture(data, callback) {
    $.ajax({
        url: 'includes/submit-comment.php',
        data: data,
        type: 'post',
        dataType: 'json',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

function deleteComment(data, callback) {
    $.ajax({
        url: 'includes/delete-comment.php',
        data: data,
        type: 'post',
        dataType: 'json',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}


/*
 * gesture set comments
 */
function submitGestureSetComment(data, callback) {
    $.ajax({
        url: 'includes/submit-gesture-set-comment.php',
        data: data,
        type: 'post',
        dataType: 'json',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

function deleteGestureSetComment(data, callback) {
    $.ajax({
        url: 'includes/delete-gesture-set-comment.php',
        data: data,
        type: 'post',
        dataType: 'json',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}


/*
 * execution preperation
 */

function getParticipationRequests(data, callback) {
    $.ajax({
        url: 'includes/get-participation-requests.php',
        data: data,
        type: 'post',
        dataType: 'json',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

function approveParticipation(data, callback) {
    $.ajax({
        url: 'includes/approve-participation.php',
        data: data,
        type: 'post',
        dataType: 'json',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

function reapproveParticipation(data, callback) {
    $.ajax({
        url: 'includes/reapprove-participation.php',
        data: data,
        type: 'post',
        dataType: 'json',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

function requestParticipation(data, callback) {
    $.ajax({
        url: 'includes/request-participation.php',
        data: data,
        type: 'post',
        dataType: 'json',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

function savePreparedSensors(data, callback) {
    $.ajax({
        url: 'includes/save-prepared-sensors.php',
        data: data,
        type: 'post',
        dataType: 'json',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

/*
 * tester execution save
 */
function saveExecutionTester(data, callback) {
    $.ajax({
        url: 'includes/save-execution-tester.php',
        data: data,
        type: 'post',
        dataType: 'json',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

/*
 * moderator execution save
 */
function saveExecutionModerator(data, callback) {
    $.ajax({
        url: 'includes/save-execution-moderator.php',
        data: data,
        type: 'post',
        dataType: 'json',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

/*
 * wizard execution save
 */
function saveExecutionWizard(data, callback) {
    $.ajax({
        url: 'includes/save-execution-wizard.php',
        data: data,
        type: 'post',
        dataType: 'json',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

/*
 * observer execution save
 */
function saveExecutionObserver(data, callback) {
    $.ajax({
        url: 'includes/save-execution-observer.php',
        data: data,
        type: 'post',
        dataType: 'json',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

function getServerTime(callback) {
    $.ajax({
        url: 'includes/get-time.php',
        type: 'post',
        dataType: 'json',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

/*
 * execution analysis 
 */
function updateExecutionPhase(data, callback) {
    $.ajax({
        url: 'includes/update-execution-phase.php',
        data: data,
        type: 'post',
        dataType: 'json',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}


function saveGestureSetSimulation(data, callback) {
    $.ajax({
        url: 'includes/save-gesture-set-simulation.php',
        data: data,
        type: 'post',
        dataType: 'json',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

function getSimulationRecordings(data, callback) {
    $.ajax({
        url: 'includes/get-gesture-set-simulation.php',
        data: data,
        type: 'post',
        dataType: 'json',
        async: true,
        success: function (result) {
            if (callback) {
                callback(result);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}