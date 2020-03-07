<?php


   // function get all from specified table 

function getAll($field,$table,$where=NULL,$and=NULL,$order,$ordering='DESC') {
   

    global $connec;

    $stmt = $connec->prepare("SELECT $field FROM $table $where $and  ORDER BY $order $ordering");
    $stmt->execute();
    $all = $stmt->fetchAll();
    return $all;
} 
   





// fuction get title



    function getTitle() {

        global $pagetitle;
        
    	if(isset($pagetitle)) {

    		return $pagetitle;
    	}
    	else {
    		return 'default';
    	}
    }


////////////////////////////////////////////////

 function Redirect($msg,$url=null,$seconds=5) {
        
        if($url==null) {

        	$url='index.php';
            $link = 'home page';
        }
        else {

        	if(isset($_SERVER['HTTP_REFERER'])&&!empty($_SERVER['HTTTP_REFERER'])) {

        		$url = $_SERVER['HTTP_REFERER'];
        	    $link = 'previous page';
        	}
        	else {

        		$url= 'index.php';
        		$link = 'home page';
        	}
        }
      
        echo $msg;

        echo "<div class='alert alert-info'>you will be redirected to $link in $seconds seconds </div>";

        header("refresh:$seconds;url=$url");
        exit();
 }

 ///////////////////////////////////////////////////////////

 // make afunction to check items 


function checkItem($select,$from,$value) {

	global $connec;

	$statement = $connec->prepare("SELECT $select from $from WHERE $select = ? ");
	$statement->execute(array($value));
	$count= $statement->rowCount();
	return $count;
}



//function for count Items 


function countItems ($item,$table){
  
    global $connec;
	$stmt2 = $connec->prepare("SELECT COUNT($item) FROM $table");
    $stmt2->execute();
    return $stmt2->fetchColumn();
}


// function Get Latest Items 
function getLatest ($select,$table,$order,$limit = 5) {

    global $connec;
    $stmt3 = $connec->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");
    $stmt3->execute();
    $rows= $stmt3->fetchAll();
    return $rows;

}




// get categories

function getCats(){
   
    global $connec;
    $stmt = $connec->prepare("SELECT *FROM categories");
    $stmt->execute();

    $items = $stmt->fetchAll();

    return $items; 
}


// get itmes

function getItems ($where,$value,$approve=NULL){

    if($approve == NULL) {
         
         $sql = 'AND Approve=1';

    } else {

       $sql=NULL;
    }

     global $connec;

    $stmt = $connec->prepare("SELECT *FROM items WHERE $where = ? $sql ORDER BY ID DESC");
    
    $stmt->execute(array($value));

    $items = $stmt->fetchAll();

    return $items; 
}


// fuction that check status

function checkuserStatus($user) {

    global $connec;

    $stmt = $connec->prepare("SELECT userName,RegStatus FROM user WHERE userName=? AND RegStatus=0");
    $stmt->execute(array($user));
    $count = $stmt->rowCount();
    return $count;
}










