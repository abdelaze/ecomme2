<?php
  
  ini_set('display_errors','on');
  error_reporting(E_ALL);

  include 'admin/connect.php';
  $tpl = 'included/templates/';
  $lng = 'included/languages/';
  $func= 'included/functions/';
  $Css = 'layout/css/'; 
  $Js = 'layout/js/';

  

  include $func.'functions.php';
  include $lng.'english.php';
  include  $tpl.'header.php';




