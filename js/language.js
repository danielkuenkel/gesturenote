/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// languages
var LANGUAGE_EN = 'en';
var LANGUAGE_DE = 'de';

var currentLanguage = LANGUAGE_EN;
var translation = null;

function checkLanguage(callback) {
    if (navigator.language.indexOf(LANGUAGE_EN) > -1) {
        currentLanguage = LANGUAGE_EN;
        console.log('language: english');
    } else if (navigator.language.indexOf(LANGUAGE_DE) > -1) {
        currentLanguage = LANGUAGE_DE;
        console.log('language: deutsch');
    }

    $.getJSON('externals/' + currentLanguage + '/' + currentLanguage + '.json', function (data) {
        translation = data;
        callback();
    });
}
