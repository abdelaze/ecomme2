<?php 
    
     session_start();
     if(isset($_SESSION['user'])) {

     	 header('location:index.php');
     }
     $pagetitle = 'login';

    include 'init.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

    	  if(isset($_POST['login'])) {

    	$user = $_POST['username'];
    	$pass = sha1($_POST['password']);

    	$stmt = $connec->prepare("SELECT userID,userName , userPassword FROM user WHERE userName=? AND userPassword=? ");
    	$stmt->execute(array($user,$pass));
      $get = $stmt->fetch();
    	$count = $stmt->rowCount();

    	if($count>0)  {
    		$_SESSION['user'] = $user;
        $_SESSION['uid']  = $get['userID'];
    		header('location:index.php');
    		exit();
    	}
    }  else {

          $formerrors = array();

          $username   = $_POST['username'];
          $password1  = $_POST['password'];
          $password2  = $_POST['password2'];
          $email      = $_POST['email'];

    	  if(isset($username)) {

             $user = filter_var($username,FILTER_SANITIZE_STRING);

             if(strlen($user)<4) {

             	$formerrors[] ="User Name Must Be Larger Than Four Characters";
             }
    	  	  
    	  }

    	  if(isset($password1) && isset($password2)) {

    	  	if(empty($password1)) {

    	  		$formerrors = "password cannot be empty";
    	  	}


            $pass1 = sha1($_POST['password']);
            $pass2 = sha1($_POST['password2']);

             if($pass1 !== $pass2) {

             	$formerrors[] ="Password1 Must Be Match Password2";
             }

         }
    	  	  

    	  


    	  if(isset($_POST['email'])) {

    	  	$email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);

    	  	if(filter_var($email,FILTER_VALIDATE_EMAIL) != true) {

    	  		$formerrors = "Email Not Valid";
    	  	}

    	  }

      
          if(empty($formerrors)) {

          	   $check =checkItem('userName','user',$user);
          	   if($check == 1) {

          	   	   $formerrors[] = 'Sorry User Is Exist';
          	   }
          	   else {
                   
                    $stmt = $connec->prepare("INSERT INTO user(userName,userEmail,userPassword,RegStatus,Date) 

                    	                     values(:name,:email,:pass,0,now())");

                    $stmt->execute(array(

                           'name'=>$user,
                           'email'=>$email,
                           'pass' =>sha1($password1)

                    	));

                    $sucess = "Congrats You Are Regiestered now";
          	   }
          }
   

    


///////////////////////
   }
}

?>



 <div class="container">

		     
		      <div class="login-page">

		          <h1 class="text-center"><span id='login' class="selected">Login</span> | <span id='signup'>Signup</span></h1>

		        
		         <form class="login" action="<?php echo $_SERVER['PHP_SELF']?>" method='POST'>
		              <div class="input-container">
			              <input type="text" name="username" class="form-control" autocomplete="off" required="required" placeholder="Enter UserName">
			          </div>

			          <div class="input-container">

			          <input type="password" name="password" class="form-control" autocomplete="new-password" required="required" placeholder="Enter Valid Password">
			          </div>

			          <div class="input-container">

			          <input type="submit" class="btn-block btn btn-primary" value="login" name='login'>

			          </div>
		        
		         </form>

		         <form class="signup" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">

		               <div class="input-container">

		               <input pattern=".{4,}" title="Name Must Be Less Than 4 chars" type="text" name="username" class="form-control"   placeholder="Enter Your username" required="required" autocomplete="off">
			          </div>

			         

		             <div class="input-container">

		                <input type="email" name="email" class="form-control"  placeholder="Enter Your Eamil" required="required">
			          </div>

			          <div class="input-container">

			          <input minlength="4" type="password" name="password" class="form-control" autocomplete="new-password" placeholder="Enter Valid Password" required="required">
			          </div>

			          <div class="input-container">

			            <input minlength="4"  type="password" name="password2" class="form-control" autocomplete="new-password"  placeholder="Enter Password Again" required="required">

			           </div>
			          <input type="submit" class="btn-block btn btn-success" value="signup" name="signup">
		        
		         </form>



		    </div>

   </div>

       <div class="container">

          <div class="errors text-center">
             <?php
             if(!empty($formerrors)) {

             	foreach($formerrors as $error) {

             		 echo $error."<br>";
             	}
             }


              if(isset($sucess)) {
                    
                    echo $sucess;
              }
             ?>
          </div>


       </div>





<?php
     
      include $tpl.'footer.php';
?>