<?php
  //SITE ROOT
  $path = $_SERVER['DOCUMENT_ROOT'] ;
  define('SITE_ROOT', $path);
  //SITE path
  define('SITE_PATH','https://'.$_SERVER['HTTP_HOST'] .'/');
  //production
  define('PRODUCTION',true);
