/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function setLocalItem(id, data) {
    localStorage.setItem(id, JSON.stringify(data));
}

function getLocalItem(id) {
    var data = localStorage.getItem(id);
    if (data !== null && data !== undefined && data !== 'undefined' && data.length > 0) {
        return JSON.parse(localStorage.getItem(id));
    }
    
    return null;
}

function removeLocalItem(id) {
    localStorage.removeItem(id);
}

function clearLocalItems() {
    localStorage.clear();
}