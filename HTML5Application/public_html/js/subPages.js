/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {
    
    // draw fixed top header
    var header = document.body.insertBefore(document.createElement("nav"), document.getElementById("breadCrump"));
    header.setAttribute("class", "navbar navbar-default navbar-fixed-top");
    
    var container = header.appendChild(document.createElement("div"));
    container.setAttribute("class", "container");
    
    var navbarHeader = container.appendChild(document.createElement("div"));
    navbarHeader.setAttribute("class", "navbar-header");
    
    var logoButton = navbarHeader.appendChild(document.createElement("button"));
    logoButton.setAttribute("type", "button");
    logoButton.setAttribute("class", "navbar-toggle");
    logoButton.setAttribute("data-toggle", "collapse");
    logoButton.setAttribute("data-target", "#myNavbar");
    
    var iconBar = logoButton.appendChild(document.createElement("span"));
    iconBar.setAttribute("class", "icon-bar");
    
    var navbarBrand = navbarHeader.appendChild(document.createElement("a"));
    navbarBrand.setAttribute("class", "navbar-brand");
    navbarBrand.setAttribute("onClick", "checkLogin()");
    
    var logoIcon = navbarBrand.appendChild(document.createElement("span"));
    logoIcon.setAttribute("class", "glyphicon glyphicon-signal");
    navbarBrand.appendChild(document.createTextNode(" GestureNote"));
    
    var signOutContainer = container.appendChild(document.createElement("div"));
    signOutContainer.setAttribute("class", "collapse navbar-collapse");
    signOutContainer.setAttribute("id", "myNavbar");
    
    var listContainerRight = signOutContainer.appendChild(document.createElement("ul"));
    listContainerRight.setAttribute("class", "nav navbar-nav navbar-right");
    
    var listItem = listContainerRight.appendChild(document.createElement("li"));
    var link = listItem.appendChild(document.createElement("a"));
    link.setAttribute("href", "index.html");
    var glyphIcon = link.appendChild(document.createElement("span"));
    glyphIcon.setAttribute("class", "glyphicon glyphicon-log-out");
    link.appendChild(document.createTextNode(" SIGN OUT"));
    
    var line = document.body.insertBefore(document.createElement("div"), document.getElementById("breadCrump"));
    line.setAttribute("class", "line text-center");
    
    
    // draw a fixed bottom footer
    var footer = document.createElement("nav");
    footer.setAttribute("class", "navbar navbar-default navbar-fixed-bottom");
    
    var container = footer.appendChild(document.createElement("div"));
    container.setAttribute("class", "container");
    
    var row = container.appendChild(document.createElement("div"));
    row.setAttribute("class", "row");
    
    var col = row.appendChild(document.createElement("div"));
    col.setAttribute("class", "col-xs-5");
    
    var listContainer = col.appendChild(document.createElement("ul"));
    listContainer.setAttribute("class", "nav nav-pills");
    
    var list = listContainer.appendChild(document.createElement("li"));
    list.setAttribute("role", "presentation");
    
    var link = list.appendChild(document.createElement("a"));
//    link.setAttribute("href", "#contact");
    
    var span = link.appendChild(document.createElement("span"));
    span.setAttribute("class", "glyphicon glyphicon-copyright-mark");
    link.appendChild(document.createTextNode(" DANIEL KUENKEL"));
    
    var colRight = row.appendChild(document.createElement("div"));
    colRight.setAttribute("class", "col-xs-7");
    
    var listContainerRight = colRight.appendChild(document.createElement("ul"));
    listContainerRight.setAttribute("class", "nav nav-pills navbar-right");
    
    var listItem = listContainerRight.appendChild(document.createElement("li"));
    listItem.setAttribute("role", "presentation");
    
    var linkProfile = listItem.appendChild(document.createElement("a"));
    linkProfile.setAttribute("href", "#");
    linkProfile.appendChild(document.createTextNode("profile"));
    
    listItem = listContainerRight.appendChild(document.createElement("li"));
    listItem.setAttribute("role", "presentation");
    
    var linkImprint = listItem.appendChild(document.createElement("a"));
    linkImprint.setAttribute("href", "#");
    linkImprint.appendChild(document.createTextNode("imprint"));
    
    document.body.appendChild(footer);
});