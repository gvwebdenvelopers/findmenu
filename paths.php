<?php
  //SITE ROOT
  $path = $_SERVER['DOCUMENT_ROOT'] ;
  define('SITE_ROOT', $path);
  //SITE path
  define('SITE_PATH','https://'.$_SERVER['HTTP_HOST'] .'/');
  //production
  define('PRODUCTION',true);
  //amigables
  define('URL_FRIENDLY', TRUE);

  //Includes de 1er nivel
  //model
  define('MODEL_PATH', SITE_ROOT.'model/');
  //media
  define('MEDIA_PATH', SITE_ROOT.'media/');
  //modules
  define('MODULES_PATH', SITE_ROOT.'modules/');
  //utils
  define('UTILS', SITE_ROOT.'utils/');

  //Includes de 2º nivel
  //CSS
  define('CSS_PATH', '/view/css/');
  //log
  define('LOG_DIR', SITE_ROOT.'classes/log.class.singleton.php');
  define('USER_LOG_DIR', SITE_ROOT.'log/user/Site_User_errors.log');
  define('GENERAL_LOG_DIR', SITE_ROOT.'log/general/Site_General_errors.log');
  //view
  define('VIEW_PATH_INC', SITE_ROOT.'view/inc/');
  define('VIEW_PATH_INC_ERROR', SITE_ROOT.'view/inc/templates_error/');

  //Includes de 3º nivel
  //model home
  define('HOME_VIEW', 'modules/home/view/');
