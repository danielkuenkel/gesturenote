/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var ORIGINAL_BODY_WIDTH = 400;
var ORIGINAL_HAND_WIDTH = 400;

var JOINT_HAND_RIGHT = 'handRight';
var JOINT_WRIST_RIGHT = 'wristRight';
var JOINT_ELBOW_RIGHT = 'elbowRight';
var JOINT_SHOULDER_RIGHT = 'shoulderRight';
var JOINT_SHOULDER_CENTER = 'shoulderCenter';
var JOINT_SHOULDER_LEFT = 'shoulderLeft';
var JOINT_ELBOW_LEFT = 'elbowLeft';
var JOINT_WRIST_LEFT = 'wristLeft';
var JOINT_HAND_LEFT = 'handLeft';
var JOINT_HEAD = 'head';
var JOINT_SPINE = 'spine';
var JOINT_HIP_CENTER = 'hipCenter';
var JOINT_HIP_RIGHT = 'hipRight';
var JOINT_KNEE_RIGHT = 'kneeRight';
var JOINT_ANGLE_RIGHT = 'ankleRight';
var JOINT_FOOT_RIGHT = 'footRight';
var JOINT_HIP_LEFT = 'hipLeft';
var JOINT_KNEE_LEFT = 'kneeLeft';
var JOINT_ANKLE_LEFT = 'ankleLeft';
var JOINT_FOOT_LEFT = 'footLeft';

var bodyJoints = new Array();
bodyJoints.push(new Joint(JOINT_HAND_LEFT, [79, 56]));
bodyJoints.push(new Joint(JOINT_WRIST_LEFT, [90, 76]));
bodyJoints.push(new Joint(JOINT_ELBOW_LEFT, [110, 121]));
bodyJoints.push(new Joint(JOINT_SHOULDER_LEFT, [123, 161]));

bodyJoints.push(new Joint(JOINT_SHOULDER_RIGHT, [123, 239]));
bodyJoints.push(new Joint(JOINT_ELBOW_RIGHT, [110, 277]));
bodyJoints.push(new Joint(JOINT_WRIST_RIGHT, [90, 324]));
bodyJoints.push(new Joint(JOINT_HAND_RIGHT, [79, 344]));

bodyJoints.push(new Joint(JOINT_SHOULDER_CENTER, [124, 200]));
bodyJoints.push(new Joint(JOINT_HEAD, [94, 200]));
bodyJoints.push(new Joint(JOINT_SPINE, [160, 200]));
bodyJoints.push(new Joint(JOINT_HIP_CENTER, [187, 200]));

bodyJoints.push(new Joint(JOINT_HIP_RIGHT, [203, 176]));
bodyJoints.push(new Joint(JOINT_KNEE_RIGHT, [290, 156]));
bodyJoints.push(new Joint(JOINT_ANGLE_RIGHT, [361, 123]));
bodyJoints.push(new Joint(JOINT_FOOT_RIGHT, [357, 100]));

bodyJoints.push(new Joint(JOINT_HIP_LEFT, [203, 224]));
bodyJoints.push(new Joint(JOINT_KNEE_LEFT, [290, 244]));
bodyJoints.push(new Joint(JOINT_ANKLE_LEFT, [361, 277]));
bodyJoints.push(new Joint(JOINT_FOOT_LEFT, [357, 300]));

var JOINT_THUMB_DISTAL = 'thumbDistal';
var JOINT_THUMB_INTERMEDIATE = 'thumbIntermediate';
var JOINT_THUMB_PROXIMAL = 'thumbProximal';
var JOINT_THUMB_METACARPALS = 'thumbMetacarpals';

var JOINT_TIP_DISTAL = 'tipDistal';
var JOINT_TIP_INTERMEDIATE = 'tipIntermediate';
var JOINT_TIP_PROXIMAL = 'tipProximal';
var JOINT_TIP_METACARPALS = 'tipMetacarpals';

var JOINT_MIDDLE_DISTAL = 'middleDistal';
var JOINT_MIDDLE_INTERMEDIATE = 'middleIntermediate';
var JOINT_MIDDLE_PROXIMAL = 'middleProximal';
var JOINT_MIDDLE_METACARPALS = 'middleMetacarpals';

var JOINT_RING_DISTAL = 'ringDistal';
var JOINT_RING_INTERMEDIATE = 'ringIntermediate';
var JOINT_RING_PROXIMAL = 'ringProximal';
var JOINT_RING_METACARPALS = 'ringMetacarpals';

var JOINT_PINKY_DISTAL = 'pinkyDistal';
var JOINT_PINKY_INTERMEDIATE = 'pinkyIntermediate';
var JOINT_PINKY_PROXIMAL = 'pinkyProximal';
var JOINT_PINKY_METACARPALS = 'pinkyMetacarpals';

var JOINT_PALM = "palm";


var handJoints = new Array();
handJoints.push(new Joint(JOINT_THUMB_DISTAL, [205, 20]));
handJoints.push(new Joint(JOINT_THUMB_INTERMEDIATE, [231, 50]));
handJoints.push(new Joint(JOINT_THUMB_PROXIMAL, [281, 90]));
handJoints.push(new Joint(JOINT_THUMB_METACARPALS, [356, 159]));

handJoints.push(new Joint(JOINT_TIP_DISTAL, [33, 150]));
handJoints.push(new Joint(JOINT_TIP_INTERMEDIATE, [70, 151]));
handJoints.push(new Joint(JOINT_TIP_PROXIMAL, [113, 155]));
handJoints.push(new Joint(JOINT_TIP_METACARPALS, [200, 163]));

handJoints.push(new Joint(JOINT_MIDDLE_DISTAL, [18, 234]));
handJoints.push(new Joint(JOINT_MIDDLE_INTERMEDIATE, [53, 230]));
handJoints.push(new Joint(JOINT_MIDDLE_PROXIMAL, [109, 222]));
handJoints.push(new Joint(JOINT_MIDDLE_METACARPALS, [202, 213]));

handJoints.push(new Joint(JOINT_RING_DISTAL, [53, 302]));
handJoints.push(new Joint(JOINT_RING_INTERMEDIATE, [87, 292]));
handJoints.push(new Joint(JOINT_RING_PROXIMAL, [138, 279]));
handJoints.push(new Joint(JOINT_RING_METACARPALS, [216, 255]));

handJoints.push(new Joint(JOINT_PINKY_DISTAL, [124, 370]));
handJoints.push(new Joint(JOINT_PINKY_INTERMEDIATE, [149, 354]));
handJoints.push(new Joint(JOINT_PINKY_PROXIMAL, [187, 329]));
handJoints.push(new Joint(JOINT_PINKY_METACARPALS, [242, 297]));

handJoints.push(new Joint(JOINT_PALM, [373, 205]));


function Joint(title, position) {
    this.title = title;
    this.position = position;
}

function renderBodyJoints(target, activeJoints) {
    var ratio = $(target).width() / ORIGINAL_BODY_WIDTH;
//    console.log(ratio);
//    console.log(target);

    for (var i = 0; i < bodyJoints.length; i++) {
        var buttonJoint = document.createElement('div');
        $(buttonJoint).addClass('btn-joint-human-body');
        $(buttonJoint).attr('id', bodyJoints[i].title);
        $(target).find('#joint-container').append(buttonJoint);

        var icon = document.createElement('i');
        $(icon).addClass('fa fa-circle');
        $(icon).css({position: 'absolute', color: '#ffffff'});
        $(buttonJoint).append(icon);

        icon = document.createElement('i');
        $(icon).addClass('fa fa-circle');
        $(icon).attr('id', 'toggle-icon');
        $(icon).css({position: 'absolute'});
        $(buttonJoint).append(icon);

        var jointData = bodyJoints[i];
        var top = Math.round((ratio * jointData.position[0]) - (24 / 2));
        var left = Math.round((ratio * jointData.position[1]) - (21 / 2));
        $(buttonJoint).css({top: top, left: left});

        if (activeJoints && activeJoints.length > 0 && isJointActive(bodyJoints[i], activeJoints)) {
            $(buttonJoint).click();
        }
    }
}

function renderBodyJointsPreview(target, activeJoints) {
    var ratio = $(target).width() / ORIGINAL_BODY_WIDTH;
    for (var i = 0; i < bodyJoints.length; i++) {
        var buttonJoint = document.createElement('div');
        $(buttonJoint).addClass('joint-human-body');
        $(buttonJoint).attr('id', bodyJoints[i].title);
        $(target).find('#joint-container').append(buttonJoint);

        var icon = document.createElement('i');
        $(icon).addClass('fa fa-circle');
        $(icon).css({position: 'absolute', color: '#ffffff'});
        $(buttonJoint).append(icon);

        icon = document.createElement('i');
        $(icon).addClass('fa fa-circle');
        $(icon).attr('id', 'toggle-icon');
        $(icon).css({position: 'absolute'});
        $(buttonJoint).append(icon);

        var jointData = bodyJoints[i];
        var top = Math.round((ratio * jointData.position[0]) - (24 / 2));
        var left = Math.round((ratio * jointData.position[1]) - (21 / 2));
        $(buttonJoint).css({top: top, left: left});

        if (isJointActive(bodyJoints[i], activeJoints)) {
            $(buttonJoint).addClass('active');
            $(buttonJoint).find('#toggle-icon').removeClass('fa-circle').addClass('fa-check-circle');
        }
    }
}

function renderHandJoints(target, activeJoints) {
    var ratio = $(target).width() / ORIGINAL_HAND_WIDTH;

    for (var i = 0; i < handJoints.length; i++) {
        var buttonJoint = document.createElement('div');
        $(buttonJoint).addClass('btn-joint-human-body');
        $(buttonJoint).attr('id', handJoints[i].title);
        $(target).find('#joint-container').append(buttonJoint);

        var icon = document.createElement('i');
        $(icon).addClass('fa fa-circle');
        $(icon).css({position: 'absolute', color: '#ffffff'});
        $(buttonJoint).append(icon);

        icon = document.createElement('i');
        $(icon).addClass('fa fa-circle');
        $(icon).attr('id', 'toggle-icon');
        $(icon).css({position: 'absolute'});
        $(buttonJoint).append(icon);

        var jointData = handJoints[i];
        var top = Math.round((ratio * jointData.position[0]) - (24 / 2));
        var left = Math.round((ratio * jointData.position[1]) - (21 / 2));
        $(buttonJoint).css({top: top, left: left});

        if (activeJoints && activeJoints.length > 0 && isJointActive(handJoints[i], activeJoints)) {
            $(buttonJoint).click();
        }
    }
}

function renderHandJointsPreview(target, activeJoints) {
    var ratio = $(target).width() / ORIGINAL_HAND_WIDTH;
    for (var i = 0; i < bodyJoints.length; i++) {
        var buttonJoint = document.createElement('div');
        $(buttonJoint).addClass('joint-human-body');
        $(buttonJoint).attr('id', bodyJoints[i].title);
        $(target).find('#joint-container').append(buttonJoint);

        var icon = document.createElement('i');
        $(icon).addClass('fa fa-circle');
        $(icon).css({position: 'absolute', color: '#ffffff'});
        $(buttonJoint).append(icon);

        icon = document.createElement('i');
        $(icon).addClass('fa fa-circle');
        $(icon).attr('id', 'toggle-icon');
        $(icon).css({position: 'absolute'});
        $(buttonJoint).append(icon);

        var jointData = bodyJoints[i];
        var top = Math.round((ratio * jointData.position[0]) - (24 / 2));
        var left = Math.round((ratio * jointData.position[1]) - (21 / 2));
        $(buttonJoint).css({top: top, left: left});

        if (isJointActive(bodyJoints[i], activeJoints)) {
            $(buttonJoint).addClass('active');
            $(buttonJoint).find('#toggle-icon').removeClass('fa-circle').addClass('fa-check-circle');
        }
    }
}

function isJointActive(joint, activeJoints) {
    if (activeJoints && activeJoints.length > 0) {
        for (var i = 0; i < activeJoints.length; i++) {
            if (joint.title === activeJoints[i]) {
                return true;
            }
        }
    }
    return false;
}

$(document).on('click', '.btn-joint-human-body', function (event) {
    event.preventDefault();
    if (!event.handled) {

        event.handled = true;
        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
            $(this).find('#toggle-icon').removeClass('fa-check-circle').addClass('fa-circle');
        } else {
            $(this).addClass('active');
            $(this).find('#toggle-icon').removeClass('fa-circle').addClass('fa-check-circle');
        }

        $(this).trigger('change');
    }
});

function getSelectedJoints(target) {
    var selectedJoints = $(target).children('.active');
    var array = new Array();
    for (var i = 0; i < selectedJoints.length; i++) {
        array.push($(selectedJoints[i]).attr('id'));
    }

    return array;
}