<?php
 
 $dsn = 'mysql:host=localhost;dbname=shop';
 $user = 'root';
 $pass = '';

 $option = array(
   PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES UTF8',
 	);

 try {

    $connec =new PDO($dsn,$user,$pass,$option);
    $connec->setAttribute(

    	PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION
    	);

    
 }
 catch(PDOException $e){

 	echo 'failed'.$e->getMessage();

 }

?>