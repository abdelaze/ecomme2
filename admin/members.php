<?php

session_start();

  $pagetitle = 'Members';

if(isset($_SESSION['Username'])) {
	
     include 'init.php';


     $do= isset($_GET['do']) ?  $_GET['do'] : 'manage';

     if($do=='manage') {

             $query='';
             if(isset($_GET['page']) && $_GET['page'] == 'pending') {

                $query = 'AND RegStatus= 0';
             }

           $stmt = $connec->prepare("select *from user where groupID !=1 $query");
           $stmt->execute();
           $rows = $stmt->fetchAll();

     	?>

     	<h1 class="text-center">Mange Members</h1>
     	<div class="container">
            <div class="table-responsive">
                <table class="table  manage-table table-bordered text-center main-table">
                	<tr>
                		<td>ID</td>
                    <td>Avatar</td>
                		<td>Username</td>
                		<td>Email</td>
                		<td>FullName</td>
                		<td>Registered Date</td>
                		<td>Control</td>

                	</tr>

                	<?php

                	foreach ($rows as $row) {
                		
                	
                	echo "<tr>";
                	
                	 echo "<td>".$row['userID']."</td>";
                   if(empty($row['avatar'])) {

                     echo "<td><img src='uploads/avatars/default.png' alt=''></td>";
                   }
                   else {

                    echo "<td><img src='uploads/avatars/".$row['avatar']." ' alt=''></td>";

                  }
                	 echo "<td>".$row['userName']."</td>";
                	 echo "<td>".$row['userEmail']."</td>";
                	 echo "<td>".$row['FullName']."</td>";
                	 echo "<td>".$row['Date']."</td>";
                	 echo "<td>
                   <a href='members.php?do=Edit&userid=" . $row['userID'] . " 'class='btn btn-success'><i class='fa fa-edit'></i>Edit</a> 
                      <a href='members.php?do=Delete&userid=" . $row['userID'] . " 'class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a>";

                    if($row['RegStatus'] == 0) {
                     echo " <a href='members.php?do=Activate&userid=" . $row['userID'] . " 'class='btn btn-primary active'><i class='fa fa-close'></i>Activate</a>";
                    }


                    echo  "</td>";

                	echo "</tr>";
                  }
               ?>
                </table>
            </div>
            <a href="members.php?do=Add" class="btn btn-primary"><i class='fa fa-plus'></i>Add New Memeber</a>
     	</div>
     	

   



   <?php  }
//////////////////////////////////////////////////////////////////


     elseif ($do=='Add'){?>

         
            <h1 class="text-center">Add New Member</h1>

            <div class="container">
     		
	     		<form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">

	     	
	     		<div class="form-group">
	     		     <label class="col-sm-2 control-label">User name</label>
	     		     <div class="col-md-6 col-sm-10">
                      <input class='form-control' type="text" name="username" autocomplete="off" required="required">  
                     </div>
	     		</div>


	     		<div class="form-group">
	     		     <label class="col-sm-2 control-label">Email</label>
	     		     <div class="col-md-6 col-sm-10">
                      <input class='form-control ' type="Email" name="email" autocomplete="off" required="required">  
                     </div>
	     		</div>


	     		<div class="form-group">
	     		     <label class="col-sm-2 control-label">Password</label>
	     		     <div class="col-md-6 col-sm-10">
	     		     
                      <input class='form-control password' type="password" name="newpassword" autocomplete="new-password" required="required"> 
                      <i class="show fa fa-eye fa-2x"></i> 
                     </div>
	     		</div>



	     		<div class="form-group">
	     		     <label class="col-sm-2 control-label">Full Name</label>
	     		     <div class="col-md-6 col-sm-10">
                      <input class='form-control ' type="text" name="full" autocomplete="off" required="required">  
                     </div>
	     		</div>

          <div class="form-group">
                 <label class="col-sm-2 control-label">Avatar</label>
                 <div class="col-md-6 col-sm-10">

                        <input class='form-control ' type="file" name="avatar" required="required">  

                  </div>
          </div>

	     		<div class="form-group">
	     		    
	     		     <div class=" col-sm-offset-2 col-md-6 col-sm-10">
                      <input class='btn btn-primary btn-lg btn-block' type="submit" value="Add Member">  
                     </div>
	     		</div>


	           </form>
     	</div>
            


   
   <?php  }//////////////////////////////////////////////////////////////////////////////////////

   
   /////////////////////////////////////////////////////////////////////////////

   elseif($do=='Insert') {

   	       
   	       if($_SERVER['REQUEST_METHOD']=='POST') {
   
   	       	   echo '<h1 class="text-center">INSERT MEMBERS</h1>';


               // recieve image data 

           // echo print_r($_FILES['avatar']);


              $avatarname = $_FILES['avatar']['name'];
               $avatarsize = $_FILES['avatar']['size'];
               $avatartype = $_FILES['avatar']['type'];
               $avatartmp = $_FILES['avatar']['tmp_name'];

               $avatarextensions = array('jpeg','jpg','gif','png');

               $extension = strtolower(end(explode('.',$avatarname)));

   	          	$username = $_POST['username'];
   	          	$useremail= $_POST['email'];
   	          	$userpass = $_POST['newpassword'];
   	          	$hashedpass= sha1($_POST['newpassword']);
   	          	$fullname =$_POST['full'];
                   
                 $formerrors=array();


        
                 	    if(strlen($username)<4) {
                               
                               $formerrors[] = 'username cannot be less than 4';

                 	    }

                 	    if(strlen($username)>20) {
                           
                               $formerrors[] = 'username cannot be more than 20';
                 	    }

                 	    if(empty($username)) {
                               
                               $formerrors[] = 'username cannot be empty';

                 	    }

                 	     if(empty($userpass)) {
                               
                               $formerrors[] = 'password cannot be empty';

                 	    }




                 	     if(empty($fullname)) {
                               
                               $formerrors[] = 'fullname cannot be empty';

                 	    }

                 	     if(empty($useremail)) {
                               
                               $formerrors[] = 'email cannot be empty';

                 	    }

                      if(!empty($avatarname) && !in_array($extension, $avatarextensions)) {

                              $formerrors[] = ' This Extension Is Not Allowed ';
                      }

                      if(empty($avatarname)) {

                          $formerrors[] = ' This Avatar Is Required ';
                      }
                      
                      if($avatarsize > 4194304) {

                            $formerrors[] = ' This Avatar cannot Be More Than 4MB ';
                      }

                 	      echo "<div class='container'>";
                      

				    	foreach ($formerrors as  $error) {
                              
                           

								echo '<div class="alert alert-danger">'.$error."</div>";

                           
							}
							  echo "</div>";

                    if(empty($formerrors)) {

                      $avatar = rand(0,1000000000).'_'.$avatarname;

                    move_uploaded_file($avatartmp, "uploads\avatars\\".$avatar);

                    	 $check = checkItem('userName','user',$username);
                    	 if($check == 1) {

                    	 	echo 'sorry this user name exist ';
                    	 }
                    	 else {

			   	          	$stmt = $connec->prepare("insert into user(

			   	          		          userName,userEmail,userPassword,FullName,RegStatus,Date,avatar)

			   	          		          values(:user,:email,:pass,:name,1,now(),:avtar)");
			   	          	$stmt->execute(array(

			   	          		'user'=>  $username,
			   	          		'email'=> $useremail,
			   	          		'pass'=>  $hashedpass,
			   	          		 'name'=> $fullname,
                         'avtar'=>$avatar

			   	          	));

			   	          	echo "<div class='alert alert-danger'>".$stmt->rowCount()." record insrted "."</div>";
			                
                  }

              }

   	      }

   	        else {

   	         	 $error = 'you cannot browse directly'; 
			     Redirct($error,6);
   	         } 

   } 

   /////////////////////////////////////////////////////////////////////////////////


     elseif ($do=='Edit') {
   
     $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
     
       $stmt = $connec->prepare("select *from user where userID=? ");

       $stmt->execute(array($userid));
       $row = $stmt->fetch();
       $count = $stmt->rowCount();

       if($count>0) { ?>

       	<h1 class="text-center">Edit Member</h1>

     	<div class="container">
     		
	     		<form class="form-horizontal" action="?do=Update" method="POST">

	     		<input type="hidden" name="id" value="<?php echo $row['userID']?>">

	     		<div class="form-group">
	     		     <label class="col-sm-2 control-label">User name</label>
	     		     <div class="col-md-6 col-sm-10">
                      <input class='form-control' type="text" name="username" value="<?php echo $row['userName'];?>" autocomplete="off" required="required">  
                     </div>
	     		</div>


	     		<div class="form-group">
	     		     <label class="col-sm-2 control-label">Email</label>
	     		     <div class="col-md-6 col-sm-10">
                      <input class='form-control' type="Email" name="email" value="<?php echo $row['userEmail'];?>" autocomplete="off" required="required">  
                     </div>
	     		</div>


	     		<div class="form-group">
	     		     <label class="col-sm-2 control-label">Password</label>
	     		     <div class="col-md-6 col-sm-10">
	     		     <input type="hidden" name="oldpassword" value="<?php echo $row['userPassword'];?>">
                      <input class='form-control' type="password" name="newpassword" autocomplete="new-password">  
                     </div>
	     		</div>



	     		<div class="form-group">
	     		     <label class="col-sm-2 control-label">Full Name</label>
	     		     <div class="col-md-6 col-sm-10">
                      <input class='form-control' type="text" name="full"  value="<?php echo $row['FullName'];?>" autocomplete="off" required="required">  
                     </div>
	     		</div>

	     		<div class="form-group">
	     		    
	     		     <div class=" col-sm-offset-2 col-md-6 col-sm-10">
                      <input class='btn btn-primary btn-lg btn-block' type="submit" value="Edit">  
                     </div>
	     		</div>


	           </form>
     	</div>
     
   <?php }
           else {

          	$msg =  "<div class='alert alert-danger'>there is no such id </div>";
            Redirect($msg,'back',4);
      }

       }   elseif($do=='Update') {


       	         echo '<h1 class="text-center">Update Members</h1>';

                 if($_SERVER['REQUEST_METHOD']=='POST'){

                 	  $userid = $_POST['id'];
                 	  $username = $_POST['username'];
                 	   $email = $_POST['email'];
                 	    $fullname = $_POST['full'];

                 	    $pass = '';

                 	    if(empty($_POST['newpassword'])) {

                 	         $pass = $_POST['oldpassword'];	
                 	    }

                 	    else {
                 	    	$pass = sha1($_POST['newpassword']);
                 	    }

                 	    $formerrors=array();

                 	     if(strlen($username)<4) {
                               
                               $formerrors[] = 'username cannot be less than 4';

                 	    }

                 	    if(empty($username)) {
                               
                               $formerrors[] = 'username cannot be empty';

                 	    }

                 	     if(empty($fullname)) {
                               
                               $formerrors[] = 'fullname cannot be empty';

                 	    }

                 	     if(empty($email)) {
                               
                               $formerrors[] = 'email cannot be empty';

                 	    }

                 	      echo "<div class='container'>";

							foreach ($formerrors as  $error) {
                              
                           

								echo '<div class="alert alert-danger">'.$error."</div>";

                           
							}
							  echo "</div>";


                       if(empty($formerrors)) {

                 	    $stmt = $connec->prepare("UPDATE user SET userName=?,userEmail=?,FullName=?,userPassword=? where userID=?");
                 	    $stmt->execute(array( $username,$email, $fullname,$pass,$userid));

                 	   $msg = "<div class='alert alert-danger'>".$stmt->rowCount()."record updated"."</div>";
                       Redirect($msg,'back',4);

                      }

                 }

                 else {

                 	 	$msg = "<div class='alert alert-danger'>you cant browse this page directly </div>";
                        Redirect($msg,'back',4);
                 }
            }

            elseif ($do=='Delete') {

            	 echo "<h1 class='text-center'>Delete Memebers</h1>";
            	 echo "<div class='container'>";
                
                 $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
     
			          $stmt = $connec->prepare("select *from user where userID=? ");

			         $stmt->execute(array($userid));
			      
			         $count = $stmt->rowCount();

			       if($count>0) {

			       	  $stmt =$connec->prepare("DELETE from user where userID = :userid");
			       	  $stmt->bindParam("userid",$userid);
			       	  $stmt->execute();

			       	  echo "<div class='alert alert-danger'>".$stmt->rowCount() ."recods deleted" . "</div>"; 
			       }
			       else {

			       	  $error = "the id not exist";
			       	  redirect($error,6);
			       }
            }
  
    elseif ($do=='Activate') {
         
         echo "<h1 class='text-center'>Update Memebers</h1>";
               echo "<div class='container'>";
                
             $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
     
             $stmt = $connec->prepare("UPDATE user SET RegStatus = 1 WHERE userID = ?");

             $stmt->execute(array($userid));
            
            $check = checkItem('userID','user',$userid);
             if($check>0) {

                   $Msg = "<div class='alert alert-success'>".$stmt->rowCount() ."Activated" . "</div>"; 
                   Redirect($Msg,'back');
             }
             else {

                    $Msg = "<div class='alert alert-danger'>".$stmt->rowCount() ."recods Activated" . "</div>"; 
                    Redirect($Msg,'back');
             }
        }

    

     else {

     	$error =  'error';
     	Redirect($error,6);
     }


	include $tpl.'footer.php';
}

else {

	header('location:index.php');
	exit();

}

