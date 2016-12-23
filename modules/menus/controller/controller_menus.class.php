<?php

class controller_menus {

    function __construct() {
        
    }

    function menus_maps() {
        loadView('modules/menus/view/', 'menus.php');
    }

    function maploader() {
        set_error_handler('ErrorHandler');
        try {
            $arrValue = loadModel(MODEL_MENUS, "menus_model", "select", array('column' => array('false'), 'field' => array('*')));
        } catch (Exception $e) {
            $arrValue = false;
        }
        restore_error_handler();

        if ($arrValue) {
            $arrArguments['menus'] = $arrValue;
            $arrArguments['success'] = true;
            echo json_encode($arrArguments);
        } else {
            $arrArguments['success'] = false;
            $arrArguments['error'] = 503;
            echo json_encode($arrArguments);
        }
    }

}
