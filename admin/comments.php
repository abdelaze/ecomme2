<?php

   session_start();

   $pagetitle = 'Comments';

   if(isset($_SESSION['Username'])) {

   	   include 'init.php';

    $do = isset($_GET['do']) ? $_GET['do'] : 'manage';

    if($do == 'manage') {

        $stmt = $connec->prepare("SELECT comments.* ,items.Name AS Item_Name , user.userName FROM comments 

                                  INNER JOIN items ON items.ID = comments.item_id

                                  INNER JOIN user ON user.userID = comments.user_id

                                 ") ;
        $stmt->execute();

        $rows = $stmt->fetchAll();


    	?>
        
        <h1 class="text-center">Manage Comments</h1>
        <div class="container">

	    	<div class="table-responsive">
	               <table class="table-bordered text-center main-table table">
	               	
		                    <tr>
		                       <td>ID</td>
		                       <td>Comment</td>
		                       <td>Add_Date</td>
		                       <td>Item_Name</td>
		                       <td>User_Name</td>
		                       <td>Control</td>

		                    </tr>

		                    <?php
                                
                               foreach ($rows as $row) {
                               	
                               	     echo "<tr>";

                               	     echo "<td>".$row['Cid']."</td>";
                               	     echo "<td>".$row['Comment']."</td>";
                                     echo "<td>".$row['Comment_date']."</td>";
                                     echo "<td>".$row['Item_Name']."</td>";
                                     echo "<td>".$row['userName']."</td>";

                                     echo "<td>"."<a href='comments.php?do=Edit&comid=".$row['Cid']."' class = 'btn btn-success btn-small'><i class='fa fa-edit'></i>Edit</a>";
                                    

                                      echo "<a href='comments.php?do=Delete&comid=".$row['Cid']."' class = 'confirm btn btn-danger btn-small'><i class='fa fa-close'></i>Delete</a>";

                                      if($row['Status'] == 0) {

                                      	   echo "<a href='comments.php?do=Approve&comid=".$row['Cid']."' class = 'btn btn-info btn-small'><i class='fa fa-check'></i>Approve</a>";
                                      }

                                     echo "</td>";




                               	     echo "</tr>";

                               }
	                            

		                    ?>

	                    </table>

	              
	    	</div>
	   </div>


  <?php  } elseif( $do == "Edit") {


           $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ?  intval($_GET['comid']) : 0;


  	        echo "<h1 class='text-center'>Edit Comments</h1>";

  	        echo "<div class='container'>";

  	        $stmt = $connec->prepare("SELECT *FROM comments WHERE Cid = ? ");

  	        $stmt->execute(array($comid));

  	        $row = $stmt->fetch();

  	        $count = $stmt->rowCount();

  	        if($count > 0) {?>
              
                <form class="form-horizontal " action="?do=Update" method="POST">

                      <input type="hidden" name="id" value="<?php echo $row['Cid'] ?>">

                      <div class="form-group">
                      <label class="col-sm-2 control-label">Comment</label>

                      <div class="col-sm-10 col-md-6">
                            
                            <textarea class="form-control" name="comment"> <?php echo $row['Comment'] ?></textarea>

                      </div>

                      </div>

                      <div class="form-group">
                      <div class="col-sm-offset-2 col-md-6">

                             <input type="submit" class="btn btn-primary form-control" value="Edit Comment">
                      </div>
                       <div class="form-group">
                </form>

              
     
            <?php  } else {

                        $theMsg = "<div class='alert alert-danger'> There Is NO Such Id </div>";
                        Redirect($theMsg,'back');
                     
                    }

              echo "</div>";



  }   elseif($do == 'Update') {

  	      echo "<h1 class='text-center'>Edit Comments</h1>";

  	        echo "<div class='container'>";

  	      if($_SERVER['REQUEST_METHOD'] == 'POST' ) {

  	      	   $comid = $_POST['id'];
  	      	   $comment = $_POST['comment'];

  	      	   $stmt = $connec->prepare("UPDATE comments SET Comment=? WHERE Cid=?");
  	      	   $stmt->execute(array($comment,$comid));

  	      	    $theMsg = "<div class='alert alert-success'>" .$stmt->rowCount(). " Updated</div>";
                       
                 Redirect($theMsg,'back');


  	      } else {

  	      	     $theMsg = "<div class='alert alert-danger'> You Cant Browse This Page Directyl </div>";
                        Redirect($theMsg,'back');
  	      }

  	      echo "</div>";
  

  }    elseif($do == "Delete") {


       echo "<h1 class='text-center'>Delete Comments</h1>";

  	        echo "<div class='container'>";
                  
      $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ?  intval($_GET['comid']) : 0;


       $check = checkItem('Cid','comments',$comid);


       if($check>0) {


              $stmt = $connec->prepare("DELETE FROM comments WHERE Cid=:id");

              $stmt->bindParam('id',$comid);

              $stmt->execute();
              

               $theMsg = "<div class='alert alert-success'>" .$stmt->rowCount(). " Deleted</div>";
                       
                 Redirect($theMsg,'back');

        } else {

        	 $theMsg = "<div class='alert alert-danger'> There Is NO Such Id </div>";
                      

               Redirect($theMsg,'back');
        }

        echo "</div>";


    }   elseif ( $do == 'Approve') {
    	
                 echo "<h1 class='text-center'>Approve Comments</h1>";

  	        echo "<div class='container'>";
                  
      $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ?  intval($_GET['comid']) : 0;


       $check = checkItem('Cid','comments',$comid);


       if($check>0) {


              $stmt = $connec->prepare("UPDATE comments SET Status=1 WHERE Cid=?");

             

              $stmt->execute(array($comid));
              

               $theMsg = "<div class='alert alert-success'>" .$stmt->rowCount(). " Approved</div>";
                       
                 Redirect($theMsg,'back');

        } else {

        	 $theMsg = "<div class='alert alert-danger'> There Is NO Such Id </div>";
                      

               Redirect($theMsg,'back');
        }

        echo "</div>";
    }

   	   include $tpl.'footer.php';


   }
     else {


     	header('location:index.php');

     	exit();

     }      
