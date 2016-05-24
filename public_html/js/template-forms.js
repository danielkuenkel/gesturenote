/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$('body').on('click', '.btn-toggle-checkbox', function (event) {
    event.preventDefault();
    if ($(this).hasClass('inactive')) {
        if ($(this).parent().children('.active').length === 0) {
            toggleSwitch(null, $(this));
        } else {
            toggleSwitch($(this).parent().children('.active'), $(this));
        }
    }

    if ($(this).hasClass('saveGeneralData')) {
        saveGeneralData();
    }
});

$('body').on('click', '.switchButtonAddon', function (event) {
    event.preventDefault();
    var activeButton = $(this).nextAll().filter('.active');
    var inactiveButton = $(this).nextAll().filter('.inactive');

    if (activeButton.length === 0) {
        activeButton = null;
        inactiveButton = $(this).next();

    }
    inactiveButton.click();
});

function toggleSwitch(activeButton, inactiveButton) {
    if (activeButton) {
        $(activeButton).removeClass('active');
        $(activeButton).addClass('inactive');
        $(activeButton).addClass('btn-default');
        $(activeButton).removeClass($(activeButton).attr('name'));
    }
    $(inactiveButton).removeClass('inactive');
    $(inactiveButton).addClass('active');
    $(inactiveButton).removeClass('btn-default');
    $(inactiveButton).addClass($(inactiveButton).attr('name'));

    var supplements = $(activeButton).parent().children('.supplement');
    if (supplements.length > 0) {
        if ($(supplements).hasClass('hidden')) {
            $(supplements).removeClass('hidden');
        } else {
            $(supplements).addClass('hidden');
        }
    }
}

$('body').on('click', '.simple-stepper .btn-stepper-decrease', function (event) {
    if (event.handled !== true)
    {
        event.handled = true;
        event.preventDefault();
        var min = parseInt($(this).val());
        var currentValue = parseInt($(this).closest('.simple-stepper').find('.stepper-text').val());
        if (currentValue > min) {
            currentValue--;
        } else {
            currentValue = min;
        }
        $(this).closest('.simple-stepper').find('.stepper-text').val(currentValue);
    }
});

$('body').on('click', '.simple-stepper .btn-stepper-increase', function (event) {
    if (event.handled !== true)
    {
        event.handled = true;
        event.preventDefault();
        var max = parseInt($(this).val());
        var currentValue = parseInt($(this).closest('.simple-stepper').find('.stepper-text').val());
        if (currentValue < max) {
            currentValue++;
        } else {
            currentValue = max;
        }
        $(this).closest('.simple-stepper').find('.stepper-text').val(currentValue);
    }
});