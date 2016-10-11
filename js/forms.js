/* 
 * get form answers
 */

function getQuestionnaireAnswers(questionnaire) {
    var questionnaireAnswers = new Array();
    for (var i = 0; i < questionnaire.length; i++) {
        var format = $(questionnaire[i]).attr('id');
        switch (format) {
            case COUNTER:
                questionnaireAnswers.push(getCounterAnswers($(questionnaire[i])));
                break;
            case OPEN_QUESTION:
            case OPEN_QUESTION_GUS:
                questionnaireAnswers.push(getOpenQuestionAnswers($(questionnaire[i])));
                break;
            case DICHOTOMOUS_QUESTION:
            case DICHOTOMOUS_QUESTION_GUS:
                questionnaireAnswers.push(getDichotomousQuestionAnswers($(questionnaire[i])));
                break;
            case GROUPING_QUESTION:
                questionnaireAnswers.push(getGroupingQuestionAnswers($(questionnaire[i])));
                break;
            case GROUPING_QUESTION_GUS:
                questionnaireAnswers.push(getGroupingQuestionGUSAnswers($(questionnaire[i])));
                break;
            case RATING:
                questionnaireAnswers.push(getRatingAnswers($(questionnaire[i])));
                break;
            case SUM_QUESTION:
                questionnaireAnswers.push(getSumQuestionAnswers($(questionnaire[i])));
                break;
            case RANKING:
                questionnaireAnswers.push(getRankingAnswers($(questionnaire[i])));
                break;
            case ALTERNATIVE_QUESTION:
                questionnaireAnswers.push(getAlternativeQuestionAnswers($(questionnaire[i])));
                break;
            case GUS_SINGLE:
                questionnaireAnswers.push(getSingleUSAnswers($(questionnaire[i])));
                break;
            case SUS_ITEM:
                questionnaireAnswers.push(getSingleUSAnswers($(questionnaire[i])));
                break;
        }
    }
    return questionnaireAnswers;
}

function getCounterAnswers(source) {
    return {count: $(source).find('.stepper-text').val()};
}

function getOpenQuestionAnswers(source) {
    return {openAnswer: $(source).find('#openQuestionInput').val()};
}

function getDichotomousQuestionAnswers(source) {
    var data = new Object();
    data.selectedSwitch = $(source).find('.switch .active').attr('id') === undefined ? 'none' : $(source).find('.switch .active').attr('id');
    var justificationInput = $(source).find('#justificationInput');
    if (justificationInput && justificationInput.length > 0) {
        data.justification = $(source).find('#justificationInput').val();
    } else {
        data.justification = '';
    }
    return data;
}

function getGroupingQuestionAnswers(source) {
    var data = new Object();
    var selectedOptions = $(source).find('.option-container .btn-option-checked');
    var array = new Array();
    for (var i = 0; i < selectedOptions.length; i++) {
        var selectedId = $(selectedOptions[i]).attr('id');
        if (selectedId !== 'checkbox-optionalanswer') {
//            console.log(selectedOptions[i], selectedId);
            array.push(selectedId);
        }
    }
    if (selectedOptions.length === 0) {
        data.selectedOptions = -1;
    } else {
        data.selectedOptions = array;
    }
    data.optionalAnswer = $(source).find('.optionalInput').val();
    return data;
}

function getGroupingQuestionGUSAnswers(source) {
    var data = new Object();
    var selectedOptions = $(source).find('.option-container .btn-option-checked');
    var array = new Array();
    for (var i = 0; i < selectedOptions.length; i++) {
        if ($(selectedOptions[i]).parent().attr('id') !== 'checkbox-optionalanswer') {
            array.push($(selectedOptions[i]).find('.option-text').attr('id'));
        }
    }
    data.selectedOptions = array;
    data.optionalAnswer = $(source).find('.optionalInput').val();

    var justificationInput = $(source).find('#justificationInput');
    if (justificationInput && justificationInput.length > 0) {
        data.justification = $(source).find('#justificationInput').val();
    } else {
        data.justification = '';
    }

    return data;
}

function getRatingAnswers(source) {
    var data = new Object();
    var array = new Array();
    var scalesContainer = $(source).find('.scales-container');
    for (var i = 0; i < scalesContainer.length; i++) {
        array.push($(scalesContainer[i]).find('.btn-option-checked').closest('.btn-group').index() >> 1);
    }
    data.scales = array;
    return data;
}

function getSumQuestionAnswers(source) {
    var data = new Object();
    var array = new Array();
    var sumOptions = $(source).find('.option-container').children();
    for (var i = 0; i < sumOptions.length; i++) {
        array.push($(sumOptions[i]).find('.stepper-text').val());
    }
    data.sumCounts = array;
    return data;
}

function getRankingAnswers(source) {
    var data = new Object();
    var items = $(source).find('.option-container').children();
    var array = new Array();
    for (var i = 0; i < items.length; i++) {
        array.push($(items[i]).attr('id'));
    }
    data.arrangement = array;
    return data;
}

function getAlternativeQuestionAnswers(source) {
    var data = new Object();
    var selectedOptions = $(source).find('.option-container .btn-option-checked');
    var array = new Array();
    for (var i = 0; i < selectedOptions.length; i++) {
        if ($(selectedOptions[i]).parent().attr('id') !== 'checkbox-optionalanswer') {
            array.push($(selectedOptions[i]).find('.option-text').attr('id'));
        }
    }
    data.selectedOptions = array;
    data.optionalAnswer = $(source).find('.optionalInput').val();
    data.justification = $(source).find('#justificationInput').val();
    return data;
}

function getSingleUSAnswers(source) {
    return {selectedOption: $(source).find('.option-container .btn-option-checked').closest('.btn-group').index() >> 1};
}



/*
 * render questionnaire answers
 */

function renderQuestionnaireAnswers(content, studyData, resultsData) {
    for (var i = 0; i < studyData.length; i++) {
        var listItem = $('#template-study-container').find('#' + studyData[i].format).clone();
        listItem.find('#format .format-text').text(translation.questionFormats[studyData[i].format].text);
        $(content).find('.list-container').append(listItem);

        if (studyData[i].dimension !== DIMENSION_ANY) {
            $(listItem).find('#item-factors').removeClass('hidden');
            $(listItem).find('#factor-primary').text(translation.dimensions[studyData[i].dimension]);
            $(listItem).find('#factor-main').text(translation.mainDimensions[getMainDimensionForDimension(studyData[i].dimension)]);
        }

        switch (studyData[i].format) {
            case COUNTER:
                renderCounter(listItem, studyData[i], resultsData.answers[i]);
                break;
            case OPEN_QUESTION:
            case OPEN_QUESTION_GUS:
                renderOpenQuestion(listItem, studyData[i], resultsData.answers[i]);
                break;
            case DICHOTOMOUS_QUESTION:
                renderDichotomousQuestion(listItem, studyData[i], resultsData.answers[i]);
                break;
            case DICHOTOMOUS_QUESTION_GUS:
                renderDichotomousQuestion(listItem, studyData[i], resultsData.answers[i]);
                break;
            case GROUPING_QUESTION:
                renderGroupingQuestion(listItem, studyData[i], resultsData.answers[i]);
                break;
            case GROUPING_QUESTION_GUS:
                renderGroupingQuestionGUS(listItem, studyData[i], resultsData.answers[i]);
                break;
            case RATING:
                renderRating(listItem, studyData[i], resultsData.answers[i]);
                break;
            case SUM_QUESTION:
                renderSumQuestion(listItem, studyData[i], resultsData.answers[i]);
                break;
            case RANKING:
                renderRanking(listItem, studyData[i], resultsData.answers[i]);
                break;
            case ALTERNATIVE_QUESTION:
                renderAlternativeQuestion(listItem, studyData[i], resultsData.answers[i]);
                break;
            case GUS_SINGLE:
                renderGUS(listItem, studyData[i], resultsData.answers[i]);
                break;
            case SUS_ITEM:
                renderSUSItem(listItem, studyData[i], resultsData.answers[i]);
                break;
        }
        $(listItem).css({y: 0, opacity: 1});
        TweenMax.from(listItem, .1, {delay: i * .1, opacity: 0, y: -10});
    }
}

function renderCounter(item, studyData, resultsData) {
    var parameters = studyData.parameters;
    $(item).find('.question').text(studyData.question);
    $(item).find('#counter-label .counter-from').text(translation.of + ' ' + translation.atLeast + ' ' + parameters.countFrom);
    $(item).find('#counter-label .counter-to').text(translation.to + ' ' + translation.maximal + ' ' + parameters.countTo);
    if (resultsData.count && resultsData.count !== '') {
        $(item).find('.answer').text(resultsData.count);
    } else {
        $(item).find('#no-answer').removeClass('hidden');
    }
}

function renderEditableCounter(item, question, answer) {
    var parameters = question.parameters;
    $(item).find('.question').text(question.question);
    renderCounterInput(item, parameters);
    $(item).find('#counter-label .counter-from').text(translation.of + ' ' + translation.atLeast + ' ' + parameters.countFrom);
    $(item).find('#counter-label .counter-to').text(translation.to + ' ' + translation.maximal + ' ' + parameters.countTo);

    if (answer !== null && !isNaN(parseInt(answer))) {
        $(item).find('.stepper-text').val(answer);
    }
}

function renderOpenQuestion(item, studyData, resultsData) {
    $(item).find('.question').text(studyData.question);
    if (resultsData.openAnswer && resultsData.openAnswer !== '') {
        $(item).find('.answer').text(resultsData.openAnswer);
    } else {
        $(item).find('#no-answer').removeClass('hidden');
    }
}

function renderEditableOpenQuestion(item, question, answer) {
    $(item).find('.question').text(question.question);
    renderOpenQuestionInput(item);

    if (answer !== null) {
        $(item).find('#openQuestionInput').val(answer);
    }
}

function renderDichotomousQuestion(item, studyData, resultsData) {
//                console.log(studyData, resultsData);
    $(item).find('.question').text(studyData.question);

    if (resultsData.selectedSwitch === 'none') {
        $(item).find('#no-answer').removeClass('hidden');
        $(item).find('#selection').remove();
    } else {
//                    console.log(translation[resultsData.selectedSwitch])
        $(item).find('#selection .text').text(translation[resultsData.selectedSwitch]);
    }

    if (studyData.parameters.justification === 'yes') {
        $(item).find('#justification').removeClass('hidden');
        $(item).find('#' + studyData.parameters.justificationFor).removeClass('hidden');

        if ((resultsData.selectedSwitch === studyData.parameters.justificationFor || studyData.parameters.justificationFor === 'always') && resultsData.justification !== '') {
            $(item).find('#justification-content').removeClass('hidden');
            $(item).find('#justification-content .text').text(resultsData.justification);
        } else if (resultsData.justification === '' && (resultsData.selectedSwitch === studyData.parameters.justificationFor || studyData.parameters.justificationFor === 'always')) {
            $(item).find('#no-justification-result').removeClass('hidden');
        }
    } else {
        $(item).find('#no-justification').removeClass('hidden');
    }
}

function renderEditableDichotomousQuestion(item, question, answer) {
    $(item).find('.question').text(question.question);
    var parameters = question.parameters;
    renderDichotomousQuestionInput(item, parameters);

    if (parameters.justification === 'yes') {
        $(item).find('#label-justification').removeClass('hidden');
        $(item).find('#label-' + parameters.justificationFor).removeClass('hidden');

        if (answer !== null) {
            // render answers
        }
    } else {
        $(item).find('#label-no-justification').removeClass('hidden');
    }
}

function renderGroupingQuestion(item, studyData, resultsData) {
    console.log(studyData, resultsData);
    $(item).find('.question').text(studyData.question);

    if (studyData.parameters.multiselect === 'yes') {
        $(item).find('#multiselect').removeClass('hidden');
    } else {
        $(item).find('#singleselect').removeClass('hidden');
    }

    if (studyData.parameters.optionalanswer === 'yes') {
//                    $(item).find('#optionalanswer, #optionalanswer-headline').removeClass('hidden');

        if (resultsData.optionalAnswer !== '') {
            $(item).find('#optionalanswer-content').removeClass('hidden');
            $(item).find('#optionalanswer-content .text').text(resultsData.optionalAnswer);
        } else {
            $(item).find('#no-optional-answer').removeClass('hidden');
        }
    }

    if ((resultsData.selectedOptions && parseInt(resultsData.selectedOptions) === -1) || !resultsData.selectedOptions) {
        $(item).find('#no-answer').removeClass('hidden');
    }

    for (var i = 0; i < studyData.options.length; i++) {
        var optionItem = $('#template-study-container').find('#grouping-question-item').clone();
        $(optionItem).text(studyData.options[i].title);
        $(item).find('.option-container').append(optionItem);

        if (i < studyData.options.length - 1) {
            item.find('.option-container').append(document.createElement('br'));
        }

        if (resultsData.selectedOptions && resultsData.selectedOptions.length > 0) {
//                        console.log(resultsData.selectedOptions);
            for (var j = 0; j < resultsData.selectedOptions.length; j++) {
                if (parseInt(resultsData.selectedOptions[j]) === parseInt(studyData.options[i].id)) {
                    $(optionItem).addClass('bordered-scale-item');
                    if (i > 0) {
                        $(optionItem).css({marginTop: '5px'});
                    }
                    break;
                } else {
//                                $(optionItem).css({paddingLeft: "0px"});
                }
            }
        } else {
            $(optionItem).css({paddingLeft: "0px"});
        }
    }
}

function renderEditableGroupingQuestion(item, question, answer) {
    $(item).find('.question').text(question.question);
    var parameters = question.parameters;
    var options = question.options;
    renderGroupingQuestionInput(item, parameters, options);

    if (parameters.multiselect === 'yes') {
        $(item).find('#multiselect').removeClass('hidden');
    } else {
        $(item).find('#singleselect').removeClass('hidden');
    }

    if (answer !== null) {
        // render answers
    }
}


function renderGroupingQuestionGUS(item, studyData, resultsData) {
    //                console.log(studyData, resultsData);
    $(item).find('.question').text(studyData.question);
    var options;
    switch (studyData.parameters.optionSource) {
        case 'gestures':
            options = assembledGestures();
            break;
        case 'triggers':
            options = getLocalItem(ASSEMBLED_TRIGGER);
            break;
        case 'feedbacks':
            options = getLocalItem(ASSEMBLED_FEEDBACK);
            break;
    }

    if (studyData.parameters.multiselect === 'yes') {
        item.find('#multiselect').removeClass('hidden');
    } else {
        item.find('#singleselect').removeClass('hidden');
    }

    if (studyData.parameters.justification === 'yes') {
        item.find('#justification').removeClass('hidden');
        item.find('#' + studyData.parameters.justificationFor).removeClass('hidden');

        if (studyData.parameters.justificationFor === 'selectOne' && resultsData.selectedOptions && resultsData.selectedOptions.length > 0 && resultsData.justification !== '') {
            $(item).find('#justification-content').removeClass('hidden');
            $(item).find('#justification-content .text').text(resultsData.justification);
        } else if (studyData.parameters.justificationFor === 'selectNothing' && !resultsData.selectedOptions && resultsData.justification !== '') {
            $(item).find('#justification-content').removeClass('hidden');
            $(item).find('#justification-content .text').text(resultsData.justification);
        } else if (studyData.parameters.justificationFor === 'always' && resultsData.justification !== '') {
            $(item).find('#justification-content').removeClass('hidden');
            $(item).find('#justification-content .text').text(resultsData.justification);
        } else if (resultsData.selectedOptions && resultsData.selectedOptions.length > 0 && resultsData.justification === '') {
            $(item).find('#no-answer').removeClass('hidden');
        }
    } else {
        item.find('#no-justification').removeClass('hidden');
    }


    if (options && options.length > 0) {
        for (var i = 0; i < options.length; i++) {
            var optionItem = $('#template-study-container').find('#grouping-question-gus-' + studyData.parameters.optionSource + '-option').clone(false);
            optionItem.attr('id', options[i].id);
            optionItem.find('.text').text(options[i].title);
            item.find('.option-container').append(optionItem);

            if (i < options.length - 1) {
                item.find('.option-container').append(document.createElement('br'));
            }

            if (studyData.parameters.optionSource === 'gestures') {
                $(optionItem).find('.btn-popover-gesture-preview').attr('name', options[i].id);
            }

            if (resultsData.selectedOptions && resultsData.selectedOptions.length > 0) {
                for (var j = 0; j < resultsData.selectedOptions.length; j++) {
                    if (parseInt(resultsData.selectedOptions[j]) === parseInt(options[i].id)) {
                        $(optionItem).addClass('bordered-scale-item');
                        break;
                    } else {
                        //                                    $(optionItem).css({paddingLeft: "0px"});
                    }
                }
            } else {
                $(optionItem).css({paddingLeft: "0px"});
            }
        }
    }
}

function renderRating(item, studyData, resultsData) {
    $(item).find('.question').text(studyData.question);

    for (var i = 0; i < studyData.options.length; i++) {
        var optionItem = $('#template-study-container').find('#rating-item').clone();
        $(optionItem).find('#rating-option').text(studyData.options[i].option);
        $(item).find('.option-container').append(optionItem);

        var score = 0;
        if (studyData.options[i].negative === 'yes') {
            $(optionItem).find('#negative').removeClass('hidden');
            score = studyData.options.length - parseInt(resultsData.scales[i]);
        } else {
            $(optionItem).find('#positive').removeClass('hidden');
            score = parseInt(resultsData.scales[i]) + 1;
        }

        if (i < studyData.options.length - 1) {
            var hr = document.createElement('hr');
            $(hr).css({marginTop: "15px", marginBottom: "5px"});
            $(item).find('.option-container').append(hr);
        }

        var selectedScale = parseInt(resultsData.scales[i]);

        if (selectedScale === -1) {
            $(item).find('#score-container').remove();
            $(item).find('#no-answer').removeClass('hidden');
        } else {
            renderRatingSigns($(item).find('#score-container'), score);
        }

        for (var j = 0; j < studyData.options[i].scales.length; j++) {
            var scaleItem = $('#template-study-container').find('#rating-scale-item').clone();
            $(optionItem).find('#scale-container').append(scaleItem);
            $(scaleItem).text((j + 1) + '. ' + studyData.options[i].scales[j]);

            if (j === selectedScale) {
                $(scaleItem).addClass('bordered-scale-item');
            } else if (j === 0) {
                $(scaleItem).css({paddingLeft: "0px"});
            }
        }
    }
}

function renderEditableRating(item, question, answer) {
    $(item).find('.question').text(question.question);
    renderRatingInput(item, question.options);

    if (answer !== null) {
        // render answers
    }
}

function renderSumQuestion(item, studyData, resultsData) {
    $(item).find('.question').text(studyData.question);
    $(item).find('#maximum .label-text').text(translation.maximum + ': ' + studyData.parameters.maximum);
    $(item).find('#allocation .label-text').text(translation.scales[studyData.parameters.allocation]);

    var count = 0;
    for (var i = 0; i < resultsData.sumCounts.length; i++) {
        var listItemAnswer = $('#template-study-container').find('#sum-question-item').clone();
        count += parseInt(resultsData.sumCounts[i]);
        $(listItemAnswer).text(studyData.options[i] + ': ' + resultsData.sumCounts[i] + ' ' + translation.scales[studyData.parameters.allocation]);
        $(item).find('.option-container').append(listItemAnswer);
    }

    if (count === parseInt(studyData.parameters.maximum)) {
        $(item).find('#distributeAllPoints').removeClass('hidden');
    } else {
        $(item).find('#distributeNotAllPoints').removeClass('hidden');
    }
}

function renderEditableSumQuestion(item, question, answer) {
    var parameters = question.parameters;
    var options = question.options;

    $(item).find('.question').text(question.question);
    $(item).find('#maximum .label-text').text(translation.maximum + ': ' + parameters.maximum);
    $(item).find('#allocation .label-text').text(translation.scales[parameters.allocation]);

    renderSumQuestionInput(item, parameters, options);

    if (answer !== null) {
        // render answers
    }
}

function renderRanking(item, studyData, resultsData) {
    $(item).find('.question').text(studyData.question);

    for (var i = 0; i < resultsData.arrangement.length; i++) {
        var listItemAnswer = $('#template-study-container').find('#ranking-item').clone();
        $(listItemAnswer).text((i + 1) + '. ' + studyData.options[parseInt(resultsData.arrangement[i])]);
        $(item).find('.option-container').append(listItemAnswer);
    }
}

function renderEditableRanking(item, question, answer) {
    $(item).find('.question').text(question.question);
    renderRankingInput(item, question.options);

    if (answer !== null) {
        // render answers
    }
}

function renderAlternativeQuestion(item, studyData, resultsData) {
    //                console.log(studyData, resultsData);

    $(item).find('.question').text(studyData.question);

    if (studyData.parameters.optionalanswer === 'yes') {
        $(item).find('#optionalanswer').removeClass('hidden');
    }

    if (studyData.parameters.justification === 'yes') {
        $(item).find('#justification').removeClass('hidden');
        $(item).find('#' + studyData.parameters.justificationFor).removeClass('hidden');

        if (studyData.parameters.justificationFor === 'selectOne' && resultsData.selectedOptions && resultsData.selectedOptions.length > 0 && resultsData.justification !== '') {
            $(item).find('#justification-content').removeClass('hidden');
            $(item).find('#justification-content .text').text(resultsData.justification);
        } else if (studyData.parameters.justificationFor === 'selectNothing' && !resultsData.selectedOptions && resultsData.justification !== '') {
            $(item).find('#justification-content').removeClass('hidden');
            $(item).find('#justification-content .text').text(resultsData.justification);
        } else if (studyData.parameters.justificationFor === 'always' && resultsData.justification !== '') {
            $(item).find('#justification-content').removeClass('hidden');
            $(item).find('#justification-content .text').text(resultsData.justification);
        } else if (resultsData.selectedOptions && resultsData.selectedOptions.length > 0 && resultsData.justification === '') {
            $(item).find('#no-answer').removeClass('hidden');
        }
    } else {
        $(item).find('#no-justification').removeClass('hidden');
    }

    if (studyData.parameters.alternative === 'gestures' && studyData.parameters.alternativeFor === 'alternativeGesture') {
        $(item).find('#gesturesForGesture').removeClass('hidden');
    } else if (studyData.parameters.alternative === 'gestures' && studyData.parameters.alternativeFor === 'alternativeTrigger') {
        $(item).find('#gesturesForTrigger').removeClass('hidden');
    } else if (studyData.parameters.alternative === 'triggers' && studyData.parameters.alternativeFor === 'alternativeTrigger') {
        $(item).find('#triggersForTrigger').removeClass('hidden');
    } else {
        $(item).find('#triggersForGesture').removeClass('hidden');
    }

    var options = null;
    var cloneItem = null;
    if (studyData.parameters.alternative === 'triggers') {
        options = getLocalItem(ASSEMBLED_TRIGGER);
        cloneItem = '#alternativeQuestion-trigger-item';

    } else if (studyData.parameters.alternative === 'gestures') {
        options = assembledGestures();
        cloneItem = '#alternativeQuestion-gesture-item';
    }

    for (var i = 0; i < options.length; i++) {
        if (parseInt(options[i].id) !== parseInt(currentGUSData.gestureId)) {
            var optionItem = $('#template-study-container').find(cloneItem).clone();
            $(optionItem).find('.text').text(options[i].title);
            $(item).find('.option-container').append(optionItem);

            if (i < options.length - 1) {
                $(item).find('.option-container').append(document.createElement('br'));
            }

            if (studyData.parameters.alternative === 'gestures') {
                $(optionItem).find('.btn-popover-gesture-preview').attr('name', options[i].id);
            }

            if (resultsData.selectedOptions && resultsData.selectedOptions.length > 0) {
                for (var j = 0; j < resultsData.selectedOptions.length; j++) {
                    if (parseInt(resultsData.selectedOptions[j]) === parseInt(options[i].id)) {
                        $(optionItem).addClass('bordered-scale-item');
                        break;
                    }
                }
            } else {
                if (i === 0) {
                    //                                $(optionItem).css({paddingLeft: "0px"});
                }
            }
        }
    }

    if (resultsData.optionalAnswer !== '') {
        $(item).find('#optionalanswer-content').removeClass('hidden');
        $(item).find('#optionalanswer-content .text').text(resultsData.optionalAnswer);
    } else {
        $(item).find('#no-optional-answer').removeClass('hidden');
    }
}

function renderGUS(item, studyData, resultsData) {
    $(item).find('.question').text(studyData.question);

    var score = 0;
    if (studyData.parameters.negative === 'yes') {
        $(item).find('#negative').removeClass('hidden');
        score = translation.gusOptions.length - parseInt(resultsData.selectedOption);
    } else {
        $(item).find('#positive').removeClass('hidden');
        score = parseInt(resultsData.selectedOption) + 1;
    }

    var selectedOption = parseInt(resultsData.selectedOption);
    if (selectedOption === -1) {
        $(item).find('#score-container').remove();
        $(item).find('#no-answer').removeClass('hidden');
    } else {
        renderRatingSigns($(item).find('#score-container'), score);
    }

    var options = translation.gusOptions;
    for (var i = 0; i < options.length; i++) {
        var option = $('#template-study-container').find('#gus-single-item-option').clone();
        $(option).text(options[i]);
        $(item).find('.option-container').append(option);

        if (i === selectedOption) {
            $(option).addClass('bordered-scale-item');
        } else if (i === 0) {
            $(option).css({paddingLeft: "0px"});
        }
    }
}

function renderSUSItem(item, studyData, resultsData) {
    $(item).find('.question').text(studyData.question);

    var score = 0;
    if (studyData.parameters.negative === 'yes') {
        $(item).find('#negative').removeClass('hidden');
        score = translation.susOptions.length - parseInt(resultsData.selectedOption);
    } else {
        $(item).find('#positive').removeClass('hidden');
        score = parseInt(resultsData.selectedOption) + 1;
    }

    var selectedOption = parseInt(resultsData.selectedOption);
    if (selectedOption === -1) {
        $(item).find('#score-container').remove();
        $(item).find('#no-answer').removeClass('hidden');
    } else {
        renderRatingSigns($(item).find('#score-container'), score);
    }

    var options = translation.susOptions;
    for (var i = 0; i < options.length; i++) {
        var option = $('#template-study-container').find('#sus-item-option').clone();
        $(option).text(options[i]);
        $(item).find('.option-container').append(option);

        if (i === selectedOption) {
            $(option).addClass('bordered-scale-item');
        } else if (i === 0) {
            $(option).css({paddingLeft: "0px"});
        }
    }
}

function renderRatingSigns(container, score) {
    $(container).find('.score-text').text(score);
    if (score >= 4) {
        $(container).find('.fa').addClass('fa-thumbs-up');
    } else if (score === 3) {
        $(container).find('.fa').addClass('fa-caret-left');
    } else {
        $(container).find('.fa').addClass('fa-thumbs-down');
    }
}




/* 
 * form rendering for moderator, tester and participant results view
 */


/*
 * open question 
 */
function renderOpenQuestionInput(item) {
    setInputChangeEvent(item.find('#openQuestionInput'), 1000);
}

/*
 * counter 
 */
function renderCounterInput(item, parameters) {
    var counterFrom = parseInt(parameters.countFrom);
    var counterTo = parseInt(parameters.countTo);

    if (isNaN(counterFrom) || isNaN(counterTo)) {
        item.find('.btn-stepper-decrease').attr('value', 0);
        item.find('.btn-stepper-increase').attr('value', 100);
        item.find('.stepper-text').val(0);
    } else {
        item.find('.btn-stepper-decrease').attr('value', counterFrom);
        item.find('.btn-stepper-increase').attr('value', counterTo);
        item.find('.stepper-text').val(counterFrom);
    }
}

function renderCounterPreview(item, parameters) {
    $(item).find('#counter-label .counter-from').text(translation.of + ' ' + translation.atLeast + ' ' + parameters.countFrom);
    $(item).find('#counter-label .counter-to').text(translation.to + ' ' + translation.maximal + ' ' + parameters.countTo);
}

/*
 * dichotomous question
 */
function renderDichotomousQuestionPreview(item, parameters) {
    if (parameters.justification === 'yes') {
        item.find('#justification').removeClass('hidden');
        item.find('#' + parameters.justificationFor).removeClass('hidden');
    } else {
        item.find('#no-justification').removeClass('hidden');
    }
}

function renderDichotomousQuestionInput(item, parameters) {
    if (parameters.justification === 'yes') {
        var justification = $('#item-container-inputs').find('#justification').clone().addClass('hidden');
        justification.css({marginTop: '10px'});
        item.find('#panel-body').append(justification);
        setInputChangeEvent(justification.find('#justificationInput'), 1000);

        if (parameters.justificationFor === 'always') {
            justification.removeClass('hidden');
        } else {
            $(item).find('.switch').bind('change', function () {
                var activeButton = $(this).find('.active');
                if (parameters.justificationFor === activeButton.attr('id')) {
                    $(item).find('#justification').removeClass('hidden');
                } else {
                    $(item).find('#justification').addClass('hidden');
                }
            });
        }
    }
}

function renderDichotomousQuestionGUSPreview(item, parameters) {
    if (parameters.justification === 'yes') {
        item.find('#justification').removeClass('hidden');
        item.find('#' + parameters.justificationFor).removeClass('hidden');
    } else {
        item.find('#no-justification').removeClass('hidden');
    }
}

function renderDichotomousQuestionGUSInput(item, parameters) {
    if (parameters.justification === 'yes') {
        var justification = $('#item-container-inputs').find('#justification').clone().addClass('hidden');
        item.find('.panel-body').append(justification);

        if (parameters.justificationFor === 'always') {
            justification.removeClass('hidden');
        } else {
            $(item).find('.switch').bind('change', function () {
                var activeButton = $(this).find('.active');
                if (parameters.justificationFor === activeButton.attr('id')) {
                    $(item).find('#justification').removeClass('hidden');
                } else {
                    $(item).find('#justification').addClass('hidden');
                }
            });
        }
    }
}

/*
 * grouping question
 */
function renderGroupingQuestionPreview(source, item, parameters, options) {
    if (parameters.multiselect === 'yes') {
        item.find('#multiselect').removeClass('hidden');
    } else {
        item.find('#singleselect').removeClass('hidden');
    }

    if (parameters.optionalanswer === 'yes') {
        item.find('#optionalanswer').removeClass('hidden');
    }

    for (var j = 0; j < options.length; j++) {
        var optionItem = $(source).find('#option-item').clone(false).removeAttr('id');
        optionItem.text(options[j]);
        item.find('.option-container').append(optionItem);
    }
}

function renderGroupingQuestionInput(item, parameters, options) {
    var optionType = parameters.multiselect === 'yes' ? 'checkbox' : 'radio';
    for (var i = 0; i < options.length; i++) {
        var option = $('#item-container-inputs').find('#' + optionType).clone();
        option.find('.option-text').text(options[i].title);
        option.find('.btn-' + optionType).attr('id', options[i].id);
        $(item).find('.option-container').append(option);
        $(item).find('.option-container').append(document.createElement('br'));
    }

    if (parameters.optionalanswer === 'yes') {
        var option = $('#item-container-inputs').find('#' + optionType + '-optionalanswer').clone();
        $(item).find('.option-container').append(option);
        setInputChangeEvent(option.find('.optionalInput'), 1000);
    }
}

/*
 * grouping question GUS
 */
function renderGroupingQuestionGUSPreview(source, item, parameters) {
    var options;

    switch (parameters.optionSource) {
        case 'gestures':
            options = assembledGestures();
            break;
        case 'triggers':
            options = getLocalItem(ASSEMBLED_TRIGGER);
            break;
        case 'feedbacks':
            options = getLocalItem(ASSEMBLED_FEEDBACK);
            break;
    }

    if (parameters.multiselect === 'yes') {
        item.find('#multiselect').removeClass('hidden');
    } else {
        item.find('#singleselect').removeClass('hidden');
    }

    if (parameters.justification === 'yes') {
        item.find('#justification').removeClass('hidden');
        item.find('#' + parameters.justificationFor).removeClass('hidden');
    } else {
        item.find('#no-justification').removeClass('hidden');
    }

    if (options && options.length > 0) {
        for (var i = 0; i < options.length; i++) {
            var optionItem = $(source).find('#option-item').clone(false);
            optionItem.attr('id', options[i].id);
            item.find('.option-container').append(optionItem);

            if (parameters.optionSource === 'triggers') {
                var trigger = getTriggerById(options[i].id);
                optionItem.text(trigger.title);
            }

            if (parameters.optionSource === 'gestures') {
                var gesture = getGestureById(options[i].id);
                optionItem.text(gesture.title);
            }

            if (parameters.optionSource === 'feeedbacks') {
                var feedback = getFeedbackById(options[i].id);
                optionItem.text(feedback.title);
            }
        }
    }
}

function renderGroupingQuestionGUSInput(item, parameters) {
    var optionType = parameters.multiselect === 'yes' ? 'checkbox' : 'radio';
    var options;

    switch (parameters.optionSource) {
        case 'gestures':
            options = assembledGestures();
            break;
        case 'triggers':
            options = getLocalItem(ASSEMBLED_TRIGGER);
            break;
        case 'feedbacks':
            options = getLocalItem(ASSEMBLED_FEEDBACK);
            break;
    }

    if (options && options.length > 0) {
        for (var i = 0; i < options.length; i++) {
            var option = $('#item-container-inputs').find('#' + optionType).clone();
            $(item).find('.option-container').append(option);

            var optionItem = null;
            switch (parameters.optionSource) {
                case 'gestures':
                    optionItem = getGestureById(options[i].id);
                    var button = $('#item-container-inputs').find('#btn-show-gesture').clone().removeClass('hidden').removeAttr('id');
                    button.attr('name', optionItem.id);
                    option.append(button);
                    break;
                case 'triggers':
                    optionItem = getTriggerById(options[i].id);
                    break;
                case 'feedbacks':
                    optionItem = getFeedbackById(options[i].id);
                    break;
            }
            option.find('.option-text').text(optionItem.title);
            option.find('.option-text').attr('id', optionItem.id);
            $(item).find('.option-container').append(document.createElement('br'));
        }
    }

    if (parameters.justification === 'yes') {
        var justification = $('#item-container-inputs').find('#justification').clone().addClass('hidden');
        item.find('.option-container').append(justification);

        if (parameters.justificationFor === 'always') {
            justification.removeClass('hidden');
        } else {
            if (parameters.justificationFor === 'selectNothing') {
                justification.removeClass('hidden');
            }

            $(item).find('.option-container').bind('change', function () {
                var totalCheckboxButtons = $(this).find('.btn-' + optionType);
                var activeCheckboxButtons = $(totalCheckboxButtons).filter('.btn-option-checked');
                if (parameters.justificationFor === 'selectOne' && activeCheckboxButtons.length > 0) {
                    $(item).find('#justification').removeClass('hidden');
                } else if (parameters.justificationFor === 'selectNothing' && activeCheckboxButtons.length === 0) {
                    $(item).find('#justification').removeClass('hidden');
                } else {
                    $(item).find('#justification').addClass('hidden');
                }
            });
        }
    }
}


/*
 * rating
 */
function renderRatingPreview(source, item, options) {
    for (var j = 0; j < options.length; j++) {
        var ratingItem = $(source).find('#rating-item').clone().removeAttr('id');
        if (options[j].negative === 'yes') {
            ratingItem.find('#reversed').removeClass('hidden');
        }

        ratingItem.find('#rating-header').text(options[j].option);
        for (var k = 0; k < options[j].scales.length; k++) {
            var optionItem = $(source).find('#option-item').clone(false).removeAttr('id');
            optionItem.text(options[j].scales[k]);
            ratingItem.find('#scales-container').append(optionItem);
        }

        item.find('.option-container').append(ratingItem);
    }
}

function renderRatingInput(item, options) {
    for (var j = 0; j < options.length; j++) {
        var ratingItem = $('#item-container-inputs').find('#rating-item').clone().removeAttr('id');
        ratingItem.find('#rating-header').text(options[j].option);
        for (var k = 0; k < options[j].scales.length; k++) {
            var optionItem = $('#item-container-inputs').find('#radio').clone(false);
            optionItem.find('.option-text').text(options[j].scales[k]);
            ratingItem.find('#scales-container').append(optionItem);
            ratingItem.find('#scales-container').append(document.createElement('br'));
        }

        item.find('.option-container').append(ratingItem);
        if (j < options.length - 1) {
            var horizontalLine = document.createElement('hr');
            item.find('.option-container').append(horizontalLine);
        }
    }
}

/*
 * sum question
 */
function renderSumQuestionPreview(source, item, parameters, options) {
    if (parameters.maximum !== null) {
        var maximum = $(source).find('#option-item').clone(false).removeAttr('id');
        maximum.text(translation.maximum + ': ' + parameters.maximum);
        item.find('#distribution-container').append(maximum);
    }

    if (parameters.allocation !== null) {
        var percent = $(source).find('#option-item').clone(false).removeAttr('id');
        percent.text(translation.scales[parameters.allocation]);
        item.find('#distribution-container').append(percent);
    }

    for (var i = 0; i < options.length; i++) {
        var optionItem = $(source).find('#option-item').clone(false).removeAttr('id');
        optionItem.text(options[i]);
        item.find('.option-container').append(optionItem);
    }
}

function renderSumQuestionInput(item, parameters, options) {
    for (var i = 0; i < options.length; i++) {
        var maxSum = parseInt(parameters.maximum);
        var sumQuestionItem = $('#item-container-inputs').find('#sumQuestion-item').clone().removeAttr('id');
        sumQuestionItem.find('.option-text').html(options[i]);
        sumQuestionItem.find('.btn-stepper-increase').val(maxSum);
        item.find('.option-container').append(sumQuestionItem);

        $(sumQuestionItem).find('.stepper-text').on('change', function (event) {
            event.preventDefault();
            var steppers = item.find('.option-container .simple-stepper .stepper-text');
            var sum = 0;
            for (var j = 0; j < steppers.length; j++) {
                sum += parseInt($(steppers[j]).val());
            }
            if (sum > maxSum) {
                $(this).val(parseInt($(this).val()) - 1);
            }
        });
    }
}

/*
 * ranking
 */
function renderRankingPreview(source, item, options) {
    for (var i = 0; i < options.length; i++) {
        var optionItem = $(source).find('#option-item').clone(false).removeAttr('id');
        optionItem.text(options[i]);
        item.find('.option-container').append(optionItem);
    }
}

function renderRankingInput(item, options) {
    if (options) {
        for (var i = 0; i < options.length; i++) {
            var rankingItem = $('#item-container-inputs').find('#ranking-item').clone().removeAttr('id');
            rankingItem.find('.option-text').html(options[i]);
            rankingItem.attr('id', i);
            item.find('.option-container').append(rankingItem);
            checkCurrentListState(item.find('.option-container'));
        }
    }
}

/*
 * alternative question
 */
function renderAlternativeQuestionPreview(item, parameters) {
    if (parameters.optionalanswer === 'yes') {
        $(item).find('#optionalanswer').removeClass('hidden');
    }

    if (parameters.justification === 'yes') {
        $(item).find('#justification').removeClass('hidden');
        $(item).find('#' + parameters.justificationFor).removeClass('hidden');
    } else {
        $(item).find('#no-justification').removeClass('hidden');
    }

    if (parameters.alternative === 'gestures' && parameters.alternativeFor === 'alternativeGesture') {
        $(item).find('#gesturesForGesture').removeClass('hidden');
    } else if (parameters.alternative === 'gestures' && parameters.alternativeFor === 'alternativeTrigger') {
        $(item).find('#gesturesForTrigger').removeClass('hidden');
    } else if (parameters.alternative === 'triggers' && parameters.alternativeFor === 'alternativeTrigger') {
        $(item).find('#triggersForTrigger').removeClass('hidden');
    } else {
        $(item).find('#triggersForGesture').removeClass('hidden');
    }
}

function renderAlternativeQuestionInput(item, data) {
    var parameters = data.parameters;
    var options;
    var optionId = null;

    switch (parameters.alternative) {
        case 'gestures':
            options = assembledGestures();
            if (singleGUSGesture) {
                optionId = singleGUSGesture.gestureId;
            }
            break;
        case 'triggers':
            options = getLocalItem(ASSEMBLED_TRIGGER);
            if (singleGUSGesture) {
                optionId = singleGUSGesture.triggerId;
            }
            break;
        case 'feedbacks':
            options = getLocalItem(ASSEMBLED_FEEDBACK);
            if (singleGUSGesture) {
                optionId = singleGUSGesture.feedbackId;
            }
            break;
    }

    if (options) {
        for (var i = 0; i < options.length; i++) {
            if (optionId === null || (parseInt(optionId) !== parseInt(options[i].id))) {
                var optionButton = $('#item-container-inputs').find('#checkbox').clone();
                optionButton.find('.option-text').html(options[i].title);
                optionButton.find('.option-text').attr('id', options[i].id);
                item.find('.option-container').append(optionButton);
                item.find('.option-container').append(document.createElement('br'));

                if (parameters.alternative === 'gestures') {
                    var button = $('#item-container-inputs').find('#btn-show-gesture').clone().removeClass('hidden').removeAttr('id');
                    button.attr('name', options[i].id);
                    optionButton.append(button);
                }
            }
        }
    }

    if (parameters.optionalanswer === 'yes') {
        var optionalAnswer = $('#item-container-inputs').find('#checkbox-optionalanswer').clone();
        item.find('.option-container').append(optionalAnswer);
    }

    if (parameters.justification === 'yes') {
        var justification = $('#item-container-inputs').find('#justification').clone().addClass('hidden');
        item.find('.option-container').append(justification);

        if (parameters.justificationFor === 'always') {
            justification.removeClass('hidden');
        } else {
            if (parameters.justificationFor === 'selectNothing') {
                justification.removeClass('hidden');
            }

            $(item).find('.option-container').bind('change', function () {
                var totalCheckboxButtons = $(this).find('.btn-checkbox');
                var activeCheckboxButtons = $(totalCheckboxButtons).filter('.btn-option-checked');
                if (parameters.justificationFor === 'selectOne' && activeCheckboxButtons.length > 0) {
                    $(item).find('#justification').removeClass('hidden');
                } else if (parameters.justificationFor === 'selectNothing' && activeCheckboxButtons.length === 0) {
                    $(item).find('#justification').removeClass('hidden');
                } else {
                    $(item).find('#justification').addClass('hidden');
                }
            });
        }
    }
}

/*
 * gus & sus
 */

function renderGUSSinglePreview(item, data) {
    if (data.parameters.negative === 'yes') {
        $(item).find('#reversed').removeClass('hidden');
    }
    if (data.dimension !== DIMENSION_ANY) {
        $(item).find('#item-factors').removeClass('hidden');
        $(item).find('#factor-primary').text(translation.dimensions[data.dimension]);
        $(item).find('#factor-main').text(translation.mainDimensions[getMainDimensionForDimension(data.dimension)]);
    }
}
function renderGUSSingleInput(item) {
    var options = translation.gusOptions;
    for (var i = 0; i < options.length; i++) {
        var radioButton = $('#item-container-inputs').find('#radio').clone();
        radioButton.find('.option-text').html(options[i]);
        item.find('.option-container').append(radioButton);
        item.find('.option-container').append(document.createElement('br'));
    }
}

function renderSusInput(item) {
    var options = translation.susOptions;
    for (var i = 0; i < options.length; i++) {
        var radioButton = $('#item-container-inputs').find('#radio').clone();
        radioButton.find('.option-text').html(options[i]);
        item.find('.option-container').append(radioButton);
        item.find('.option-container').append(document.createElement('br'));
    }
}


var changeTriggerTimer = null;
function setInputChangeEvent(target, milliseconds) {
    $(target).keypress(function (event) {
        clearTimeout(changeTriggerTimer);
        changeTriggerTimer = setTimeout(function () {
            clearTimeout(changeTriggerTimer);
            $(target).trigger('change');
        }, milliseconds);
    });
}