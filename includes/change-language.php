<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
session_start();
if (isset($_POST['lang'])) {
    $newLang = $_POST['lang'];
    $language = new updateLanguage($newLang);
    $lang = $language->translate();
    echo json_encode(array('status' => 'success'));
    exit();
} else {
    echo json_encode(array('status' => 'error'));
    exit();
}

class updateLanguage {

    public $data;

    function __construct($language) {
        $splitURI = explode("/", $_SERVER['REQUEST_URI']);
        $additionalPath = '';
        foreach ($splitURI as $value) {
            if ($value === 'externals') {
                $additionalPath = '../';
                break;
            }
        }
        
        $data = file_get_contents("../externals/" . $language . "/" . $language . ".json");
        $this->data = json_decode($data);
        $_SESSION['lang'] = $language;
    }

    function translate() {
        return $this->data;
    }

}