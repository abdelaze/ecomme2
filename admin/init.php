<?php
  
  include 'connect.php';
 $tpl = 'included/templates/';
 $lng = 'included/languages/';
 $func= 'included/functions/';
 $Css = 'layout/css/'; 
 $Js = 'layout/js/';

  

  include $func.'functions.php';
 include $lng.'english.php';
 include  $tpl.'header.php';

 if(!isset($nonavbar)) {

 	 include $tpl.'navbar.php';
 }


