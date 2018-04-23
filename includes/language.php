<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
class language {

    public $data;

    function __construct($language) {
        $splitURI = explode("/", $_SERVER['REQUEST_URI']);
        $additionalPath = '';
        foreach ($splitURI as $value) {
            if ($value === 'externals' || $value === 'includes') {
                $additionalPath = '../';
                break;
            }
        }
        $data = file_get_contents($additionalPath . "externals/" . $language . "/" . $language . ".json");
        $this->data = json_decode($data);
        $_SESSION['lang'] = $language;
    }

    function translate() {
        return $this->data;
    }
}

$browserLanguage = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
$language = new language(isset($_SESSION['lang']) ? $_SESSION['lang'] : $browserLanguage);
$lang = $language->translate();
