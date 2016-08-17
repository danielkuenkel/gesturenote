/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function ajaxError(xhr, desc, err) {
    appendAlert($('body'), ALERT_GENERAL_ERROR);
    console.log(xhr);
    console.log("Details: " + desc + "\nError:" + err);
}

function login(data) {
    $.ajax({
        url: 'includes/process_login.php',
        data: data,
        type: 'post',
        async: true,
        success: function (data) {

            resetAlerts();
            if (data.status === 'accountLogged') {
                showAlert($('#login'), ALERT_ACCOUNT_LOGGED);
            } else if (data.status === 'passwordNotCorrect') {
                showAlert($('#login'), ALERT_WRONG_PASSWORD);
            } else if (data.status === 'loginFailed') {
                showAlert($('#login'), ALERT_LOGIN_FAILED);
            } else if (data.status === 'noUserExists') {
                showAlert($('#login'), ALERT_NO_USER_EXISTS);
            } else if (data.status === 'success') {
                window.location.replace('dashboard.php');
            } else if (data.status === 'databaseError') {
                showAlert($('#login'), ALERT_GENERAL_ERROR);
            }
        },
        error: function (xhr, desc, err) {
            ajaxError(xhr, desc, err);
        }
    });
}

function register(data) {
    $.ajax({
        url: 'includes/register.php',
        data: data,
        type: 'post',
        async: true,
        success: function (data) {
            resetAlerts();
            if (data.status === 'emailExists') {
                showAlert($('#modal-register'), ALERT_USER_EXISTS);
            } else if (data.status === 'success') {
                showAlert($('#modal-register'), ALERT_REGISTER_SUCCESS);
                $('#modal-register').find('#register-form').addClass('hidden');
                $('#modal-register').find('#btn-register').addClass('hidden');
                $('#modal-register').find('#userType').addClass('hidden');
                $('#modal-register').find('#btn-close').removeClass('hidden');
            } else if (data.status === 'error') {
                showAlert($('#modal-register'), ALERT_GENERAL_ERROR);
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
//        contentType: 'multipart/form-data',
//        mimeType: 'multipart/form-data',
//        beforeSend: function (xhr) {
//            xhr.setRequestHeader('Content-Type', 'multipart/form-data');
//        },
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



/*
 * gesture handling
 * save, delete, get catalog, update
 */

function saveModeratorGesture(data, callback) {
    $.ajax({
        url: 'includes/get-study.php',
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
            if (result.status === RESULT_SUCCESS) {
                setLocalItem(GESTURE_CATALOG, result.gestures);
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
 * gesture infos
 * rating & comments
 */
function getGestureInfos(data, callback) {
    $.ajax({
        url: 'includes/get-gesture-infos.php',
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