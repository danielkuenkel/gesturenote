/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// languages
var LANGUAGE_EN = 'en';
var LANGUAGE_DE = 'de';

var currentLanguage = null;
var translation = null;

function checkLanguage(callback) {
    getLanguage(function (result) {

        if (result.lang && result.lang !== null) {
            currentLanguage = result.lang;
            $.getJSON('externals/' + currentLanguage + '/' + currentLanguage + '.json', function (data) {
                translation = data;
                console.log(translation.languages[currentLanguage]);
                if (callback) {
                    callback();
                }
            });
        } else {
            if (callback) {
                callback();
            }
        }
    });
}
