/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function setLocalItem(id, data) {
    localStorage.setItem(id, JSON.stringify(data));
}

function getLocalItem(id) {
    if (localStorage.getItem(id) !== null) {
        return JSON.parse(localStorage.getItem(id));
    } else {
        return null;
    }
}

function removeLocalItem(id) {
    localStorage.removeItem(id);
}

function clearLocalItems() {
    localStorage.clear();
}