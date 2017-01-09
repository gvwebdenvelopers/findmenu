<?php
  //PROYECTO
  define('PROJECT', '/findmenu_localhost/');
  //SITE ROOT
  $path = $_SERVER['DOCUMENT_ROOT'] ;
  define('SITE_ROOT', $path);
  //SITE path
  define('SITE_PATH','https://'.$_SERVER['HTTP_HOST'].'/' );
  //production
  define('PRODUCTION',TRUE);
  //amigables
  define('URL_FRIENDLY', TRUE);

  //Includes de 1er nivel
  //libs
  define('LIBS', SITE_ROOT . '/libs/');
  //model
  define('MODEL_PATH', SITE_ROOT . 'model/');
  //media
  define('MEDIA_PATH', SITE_ROOT . 'media/');
  //modules
  define('MODULES_PATH', SITE_ROOT . 'modules/');
  //resources
  define('RESOURCES', SITE_ROOT . '/resources/');
  //utils
  define('UTILS', SITE_ROOT . '/utils/');

  //Includes de 2º nivel
  //CSS
  define('CSS_PATH', '/view/css/');
  //JS
  define('JS_PATH', SITE_PATH . '/view/js/');
  //log
  define('LOG_DIR', SITE_ROOT . 'classes/log/log.class.singleton.php');
  define('USER_LOG_DIR', SITE_ROOT . 'log/user/Site_User_errors.log');
  define('GENERAL_LOG_DIR', SITE_ROOT . 'log/general/Site_General_errors.log');
  //view
  define('VIEW_PATH_INC', SITE_ROOT . 'view/inc/');
  define('VIEW_PATH_INC_ERROR', SITE_ROOT . 'view/inc/templates_error/');

  //Includes de 3º nivel
  //module home
  define('HOME_VIEW', 'modules/home/view/');
  //Template home images
  define('TEMPLATE_IMAGE_PATH', '/view/img/template/');

  //model products
  define('UTILS_PRODUCTS', SITE_ROOT . 'modules/products/utils/');
  define('PRODUCTS_JS_LIB_PATH', '/modules/products/view/lib/');
  define('PRODUCTS_JS_PATH', '/modules/products/view/js/');
  define('PRODUCTS_CSS_PATH', '/modules/products/view/css/');

  define('MODEL_PATH_PRODUCTS', SITE_ROOT . 'modules/products/model/');
  define('DAO_PRODUCTS', SITE_ROOT . 'modules/products/model/DAO/');
  define('BLL_PRODUCTS', SITE_ROOT . 'modules/products/model/BLL/');
  define('MODEL_PRODUCTS', SITE_ROOT . 'modules/products/model/model/');

  //model contact
  define('CONTACT_JS_PATH', '/modules/contact/view/js/');
  define('CONTACT_CSS_PATH', '/modules/contact/view/css/');
  define('CONTACT_LIB_PATH', '/modules/contact/view/lib/');
  define('CONTACT_IMG_PATH', '/modules/contact/view/img/');
  define('CONTACT_VIEW_PATH', 'modules/contact/view/');

  //model ofertas
  define('MENUS_CSS_PATH', '/modules/menus/view/css/');
  define('MENUS_JS_PATH', '/modules/menus/view/js/');
  define('MODEL_MENUS', SITE_ROOT . 'modules/menus/model/model/');
  define('MENUS_VIEW_PATH', 'modules/menus/view/');

  //model users
  define('USERS_VIEW', '/modules/users/view/');
  define('MODEL_USER', SITE_ROOT . 'modules/users/model/model/');
  define('UTILS_USERS', SITE_ROOT . 'modules/users/utils/');
  define('USERS_CSS_PATH', '/modules/users/view/css/');
  define('USERS_JS_PATH', '/modules/users/view/js/');
