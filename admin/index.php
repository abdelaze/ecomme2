<?php
 
 session_start();
 $pagetitle = 'Login';
 $nonavbar = '';
 if(isset($_SESSION['Username'])) {

 	 header('location:homepage.php');
 }
 include 'init.php';
 
 

 if($_SERVER['REQUEST_METHOD']=='POST') {

 	$username = $_POST['user'];
 	$password = $_POST['pass'];
 	$hashedpass = sha1($password);

 	 
 	 $stmt = $connec->prepare('select userID,userName,userPassword from user where userName=? AND userPassword=? AND groupID=1 LIMIT 1');

 	 $stmt->execute(array($username,$hashedpass));
     $row=$stmt->fetch();
 	 $count = $stmt->rowCount();

      if($count>0) {
  
        $_SESSION['Username'] = $username;

        $_SESSION['Userid'] =$row['userID'];

       // print_r($row);

         header('location:homepage.php');
         exit();

      }
 
  

 }

 ?>

	 <form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?> " method='POST'">

	     <h3 class="text-center">admin login</h3>

	     <input type="text" class="form-control" name="user" placeholder="username" autocomplete="off">

	     <input type="password" class="form-control" name="pass" placeholder="password" autocomplete="new-password">
	     <input type="submit" class="btn btn-success btn-block" value="login">

	 </form>

  
   

<?php include  $tpl.'footer.php';?>