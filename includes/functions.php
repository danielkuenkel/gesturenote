<?php

include_once 'psl-config.php';

//function sec_session_start() {
//    $session_name = 'sec_session_id';   // Set a custom session name
//    $secure = true;
//    // This stops JavaScript being able to access the session id.
//    $httponly = true;
//    // Forces sessions to only use cookies.
//    if (ini_set('session.use_only_cookies', 1) === FALSE) {
//        header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
//        exit();
//    }
//    // Gets current cookies params.
//    $cookieParams = session_get_cookie_params();
//    session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);
//    // Sets the session name to the one set above.
//    session_name($session_name);
//
//    session_start();                // Start the PHP session 
//    session_regenerate_id(true);    // regenerate the session, delete the old one. 
////    print_r("generate session successful");
//}

function login($email, $password, $mysqli) {
    // Using prepared statements means that SQL injection is not possible.
//    echo $email . ", " + $password;
//    exit();
    if ($stmt = $mysqli->prepare("SELECT * FROM users WHERE email = ? LIMIT 1")) {
        $stmt->bind_param('s', $email);  // Bind "$email" to parameter.
        $stmt->execute();    // Execute the prepared query.
        $stmt->store_result();

        // get variables from result.
        $stmt->bind_result($user_id, $forename, $surname, $email, $db_password, $birthday, $gender, $usertype, $created, $passwordReset, $tutorialStudyCreation, $tutorialStudyPreview, $tutorialStudy, $tutorialParticipant);
        $stmt->fetch();

        if ($stmt->num_rows == 1) {
            // If the user exists we check if the account is locked
            // from too many login attempts 

            if (checkbrute($user_id, $mysqli) == true) {
                // Account is locked 
                // Send an email to user saying their account is locked
                echo json_encode(array('status' => 'accountLogged'));
                exit();
            } else {
                // Check if the password in the database matches
                // the password the user submitted. We are using
                // the password_verify function to avoid timing attacks.
                if (strcmp($password, $db_password) == 0) {
                    // Password is correct!
                    // Get the user-agent string of the user.
                    $user_browser = $_SERVER['HTTP_USER_AGENT'];
                    // XSS protection as we might print this value
                    $user_id = preg_replace("/[^0-9]+/", "", $user_id);

                    $_SESSION['user_id'] = $user_id;
                    $_SESSION['forename'] = $forename;
                    $_SESSION['surname'] = $surname;
                    $_SESSION['email'] = $email;
                    $_SESSION['login_string'] = hash('sha512', $db_password . $user_browser);
//                    $_SESSION['gender'] = $gender;
                    $_SESSION['usertype'] = $usertype;
//                    $_SESSION['birthday'] = $birthday;
                    $_SESSION['tutorialStudyCreation'] = $tutorialStudyCreation;
                    $_SESSION['tutorialStudyPreview'] = $tutorialStudyPreview;
                    $_SESSION['tutorialStudy'] = $tutorialStudy;
                    $_SESSION['tutorialParticipant'] = $tutorialParticipant;
                    
                    echo json_encode(array('status' => 'success', 'userId' => $user_id, 'forename' => $forename, 'surname' => $surname, 'userType' => $usertype));
                    exit();
                } else {
                    // Password is not correct
                    // We record this attempt in the database
                    $now = time();
                    $mysqli->query("INSERT INTO login_attempts(user_id, time)
                                    VALUES ('$user_id', '$now')");
                    echo json_encode(array('status' => 'passwordNotCorrect'));
                    exit();
                }
            }
        } else {
            // No user exists.
            echo json_encode(array('status' => 'noUserExists'));
            exit();
        }
    } else {
        echo json_encode(array('status' => 'loginFailed'));
        exit();
    }
}

function checkbrute($user_id, $mysqli) {
    // Get timestamp of current time 
    $now = time();

    // All login attempts are counted from the past 2 hours. 
    $valid_attempts = $now - (2 * 60 * 60);

    if ($stmt = $mysqli->prepare("SELECT time 
                             FROM login_attempts 
                             WHERE user_id = ? 
                             AND time > '$valid_attempts'")) {
        $stmt->bind_param('i', $user_id);

        // Execute the prepared query. 
        $stmt->execute();
        $stmt->store_result();

        // If there have been more than 5 failed logins 
        if ($stmt->num_rows > 5) {
            return true;
        } else {
            return false;
        }
    }
}

function login_check($mysqli) {
    // Check if all session variables are set 
//    print_r($_SESSION);
//    exit(0);
    if (isset($_SESSION['user_id'], $_SESSION['forename'], $_SESSION['surname'], $_SESSION['login_string'])) {

        $user_id = $_SESSION['user_id'];
        $login_string = $_SESSION['login_string'];
        $forename = $_SESSION['forename'];
        $surname = $_SESSION['surname'];

        // Get the user-agent string of the user.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];

        if ($stmt = $mysqli->prepare("SELECT password 
                                      FROM users 
                                      WHERE id = ? LIMIT 1")) {
            // Bind "$user_id" to parameter. 
            $stmt->bind_param('i', $user_id);
            $stmt->execute();   // Execute the prepared query.
            $stmt->store_result();

            if ($stmt->num_rows == 1) {
                // If the user exists get variables from result.
                $stmt->bind_result($password);
                $stmt->fetch();
                $login_check = hash('sha512', $password . $user_browser);

                if (strcmp($login_check, $login_string) == 0) {
                    // Logged In!!!! 
                    return true;
                } else {
                    // Not logged in 
                    return false;
                }
            } else {
                // Not logged in 
                return false;
            }
        } else {
            // Not logged in 
            return false;
        }
    } else {
        // Not logged in 
        return false;
    }
}

function esc_url($url) {

    if ('' == $url) {
        return $url;
    }

    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);

    $strip = array('%0d', '%0a', '%0D', '%0A');
    $url = (string) $url;

    $count = 1;
    while ($count) {
        $url = str_replace($strip, '', $url, $count);
    }

    $url = str_replace(';//', '://', $url);

    $url = htmlentities($url);

    $url = str_replace('&amp;', '&#038;', $url);
    $url = str_replace("'", '&#039;', $url);

    if ($url[0] !== '/') {
        // We're only interested in relative links from $_SERVER['PHP_SELF']
        return '';
    } else {
        return $url;
    }
}

function deleteFiles($targetUrl, $files) {
    if ($files && count($files) > 0) {
        foreach ($files as $url) {
            if (file_exists($targetUrl . $url) && ($url !== '' || $url !== null)) {
                unlink($targetUrl . $url);
            } else {
                
            }
        }
    }
}

function json_decode_nice($json, $assoc = TRUE) {
    $json = str_replace(array("\n", "\r"), "\\n", $json);
    $json = preg_replace('/([{,]+)(\s*)([^"]+?)\s*:/', '$1"$3":', $json);
    $json = preg_replace('/(,)\s*}$/', '}', $json);
    return json_decode($json, $assoc);
}

function getv($key, $default = '', $data_type = '') {
    $param = (isset($_REQUEST[$key]) ? $_REQUEST[$key] : $default);

    if (!is_array($param) && $data_type == 'int') {
        $param = intval($param);
    }

    return $param;
}

function studyExecutionExists($studyId, $mysqli) {
    $userId = $_SESSION['user_id'];
    if ($select_stmt = $mysqli->prepare("SELECT * FROM study_results_tester WHERE study_id = '$studyId' && user_id = '$userId' LIMIT 1")) {
        if (!$select_stmt->execute()) {
            return false;
        } else {
            $select_stmt->store_result();
            $select_stmt->bind_result($id, $studyId, $userId, $data, $created);
            $select_stmt->fetch();

            if ($select_stmt->num_rows == 1) {
                $decodedData = json_decode_nice($data, false);
                if (isset($decodedData->aborted, $decodedData->studySuccessfull)) {
                    $studySuccessfull = $decodedData->studySuccessfull;
                    $studyAborted = $decodedData->aborted;

                    return $studySuccessfull == 'yes' && $studyAborted == 'no';
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    } else {
        return false;
    }
}
