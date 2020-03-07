<?php

session_start();

if(isset($_SESSION['Username'])) {

	include 'init.php';

     $do= isset($_GET['do']) ?  $_GET['do'] : 'manage';

     if($do=='manage') {

            

           $stmt = $connec->prepare("select *from brand");
           $stmt->execute();
           $rows = $stmt->fetchAll();

     	?>

     	<h1 class="text-center">Mange Brands</h1>
     	<div class="container">
            <div class="table-responsive">
                <table class="table table-bordered text-center main-table">
                	<tr>
                		<td>ID</td>
                		<td>Image</td>
                    <td>Name</td>
                    <td>Control</td>
                
                	</tr>

                	<?php

                	foreach ($rows as $row) {
                		
                	
                	echo "<tr>";
                	
                	 echo "<td>".$row['ID']."</td>";
                	 echo "<td>".$row['Name']."</td>";
                	 echo "<td>".$row['image']."</td>";
                	
                	 echo "<td>
                   <a href='members.php?do=Edit&userid=" . $row['ID'] . " 'class='btn btn-success'><i class='fa fa-edit'></i>Edit</a> 
                      <a href='members.php?do=Delete&userid=" . $row['ID'] . " 'class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a>";


                    echo  "</td>";

                	echo "</tr>";
                  }
               ?>
                </table>
            </div>
            <a href="brand.php?do=Add" class="btn btn-primary"><i class='fa fa-plus'></i>Add New Brand</a>
     	</div>
     	

   



   <?php  }
//////////////////////////////////////////////////////////////////


     elseif ($do=='Add'){?>

         
            <h1 class="text-center">Add New Brand</h1>

            <div class="container">
     		
	     		<form class="form-horizontal" action="?do=Insert" method="POST">

	     	
	     		<div class="form-group">
	     		     <label class="col-sm-2 control-label">Name</label>
	     		     <div class="col-md-6 col-sm-10">
                      <input class='form-control' type="text" name="name" autocomplete="off" required="required">  
                     </div>
	     		</div>


	     		<div class="form-group">
	     		     <label class="col-sm-2 control-label">Image</label>
	     		     <div class="col-md-6 col-sm-10">
                      <input class='form-control ' type="text" name="image"  required="required">  

                     </div>
	     		</div>


	     		<div class="form-group">
	     		    
	     		     <div class=" col-sm-offset-2 col-md-6 col-sm-10">
                      <input class='btn btn-primary btn-lg btn-block' type="submit" value="Add Brand">  
                     </div>
	     		</div>


	           </form>
     	</div>
            


   
   <?php  }//////////////////////////////////////////////////////////////////////////////////////

   
   /////////////////////////////////////////////////////////////////////////////

   elseif($do=='Insert') {

   	       
   	       if($_SERVER['REQUEST_METHOD']=='POST') {
   
   	       	   echo '<h1 class="text-center">INSERT MEMBERS</h1>';

   	          	$name   = $_POST['name'];
   	          	$image  = $_POST['image'];
   	          
                   
                

                  

                    	 $check = checkItem('userName','user',$username);
                    	 if($check == 1) {

                    	 	echo 'sorry this user name exist ';
                    	 }
                    	 else {

			   	          	$stmt = $connec->prepare("insert into brand(

			   	          		          Name,Image)

			   	          		          values(name,image");
			   	          	$stmt->execute(array(

			   	          		'name'=>  $username,
			   	          		'image'=> $useremail,
			   	          		

			   	          	));

			   	          	echo "<div class='alert alert-danger'>".$stmt->rowCount()." record insrted "."</div>";
			                
                  }

              }

   	      

   	         else {

       	         	 $error = 'you cannot browse directly'; 
    			         Redirect($error,6);
   	         }

   }/////////////////////////////////////////////////////////////////////////////////


     elseif ($do=='Edit') {
   
     $brandid = isset($_GET['brandid']) && is_numeric($_GET['brandid']) ? intval($_GET['brandid']) : 0;
     
       $stmt = $connec->prepare("select *from brand where userID=? ");

       $stmt->execute(array($brandid));
       $row = $stmt->fetch();
       $count = $stmt->rowCount();

       if($count>0) { ?>

       	<h1 class="text-center">Edit Member</h1>

     	<div class="container">
     		
	     		<form class="form-horizontal" action="?do=Update" method="POST">

	     		<input type="hidden" name="id" value="<?php echo $row['ID']?>">

	     		<div class="form-group">
	     		     <label class="col-sm-2 control-label"> name</label>
	     		     <div class="col-md-6 col-sm-10">
                      <input class='form-control' type="text" name="name" value="<?php echo $row['Name'];?>" autocomplete="off" required="required">  
                     </div>
	     		</div>


	     		<div class="form-group">
	     		     <label class="col-sm-2 control-label">image</label>
	     		     <div class="col-md-6 col-sm-10">
                      <input class='form-control' type="image" name="image" value="<?php echo $row['image'];?>"  required="required">  
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

                 	  $id = $_POST['id'];
                 	  $name = $_POST['name'];
                 	   $image = $_POST['email'];
                 
                 	    $stmt = $connec->prepare("UPDATE user SET userName=?,userEmail=?,FullName=?,userPassword=? where userID=?");
                 	    $stmt->execute(array( $username,$email, $fullname,$pass,$userid));

                 	   $msg = "<div class='alert alert-danger'>".$stmt->rowCount()."record updated"."</div>";
                       Redirect($msg,'back',4);

                    

                 }

                 else {

                 	 	$msg = "<div class='alert alert-danger'>you cant browse this page directly </div>";
                        Redirect($msg,'back',4);
                 }
            }

            elseif ($do=='Delete') {

            	 echo "<h1 class='text-center'>Delete Brands</h1>";
            	 echo "<div class='container'>";
                
                 $brandid = isset($_GET['brandid']) && is_numeric($_GET['brandid']) ? intval($_GET['brandid']) : 0;
     
			          $stmt = $connec->prepare("select *from brand where ID=? ");

			         $stmt->execute(array($brandid));
			      
			         $count = $stmt->rowCount();

			       if($count>0) {

			       	  $stmt =$connec->prepare("DELETE from brand where ID = :id");
			       	  $stmt->bindParam("id",$brandid);
			       	  $stmt->execute();

			       	  echo "<div class='alert alert-danger'>".$stmt->rowCount() ."recods deleted" . "</div>"; 
			       }
			       else {

			       	  $error = "the id not exist";
			       	  redirect($error,6);
			       }


            }



  
  
   

    

    
     include $tpl.'footer.php';
}

else {

	header('location:index.php');
	exit();

}

