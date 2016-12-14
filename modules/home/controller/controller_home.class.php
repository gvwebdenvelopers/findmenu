<?php
    class controller_home {

        public function __construct() {
            //include(UTILS . "common.inc.php");
        }

        public function init() {
            $_SESSION['module'] = "home";
            require_once(VIEW_PATH_INC."header.php");
			      require_once(VIEW_PATH_INC."home_menu.php");

            loadView(HOME_VIEW, 'home.php');

            require_once(VIEW_PATH_INC."footer.php");
        }
    }
