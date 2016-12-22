<?php
    class controller_home {

        public function __construct() {
            
        }

        public function init() {
            $_SESSION['module'] = "home";        
            //require_once(VIEW_PATH_INC."home_menu.php");
            loadView(HOME_VIEW, 'home.php');       
        }
    }
