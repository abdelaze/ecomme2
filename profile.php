<?php

session_start();
$pagetitle = 'profile';
include 'init.php';

  if(isset($_SESSION['user'])) {

  	$stmt1 = $connec->prepare("SELECT *FROM user WHERE userName=? ");
  	$stmt1->execute(array($_SESSION['user']));
  	$userinfo = $stmt1->fetch();


?>
   
 <h1 class="text-center"> <?php echo $_SESSION['user'] ?> </h1>

 <div class="information">

     <div class="container">

          <div class="panel panel-primary">
               <div class="panel-heading">My Information</div>
               <div class="panel-body">
                       <ul class="list-unstyled">
                            <li> <span><i class="fa fa-unlock-alt fa-fw"></i>Name:</span>  <?php echo $userinfo['userName']; ?> </li>
                            <li> <span><i class="fa fa-envelope-o fa-fw"></i>Email:</span> <?php echo $userinfo['userEmail']; ?> </li>
                            <li> <span><i class="fa fa-calendar fa-fw"></i>Full_Name:</span> <?php echo $userinfo['FullName']; ?> </li>
                            <li> <span><i class="fa fa-tags fa-fw"></i>Reg_Date:</span>  <?php echo $userinfo['Date']; ?> </li>
                       </ul>
                </div>
      
          </div>

     </div>

 </div>


 
  <div class="my-ads">

     <div class="container">

          <div class="panel panel-primary">
               <div class="panel-heading">My Advertises</div>
               <div class="panel-body">
             
               
					   <?php
					     
					      $items = getItems('member_id',$userinfo['userID'],1);

                if(!empty($items)) {

                 // echo "<div class='row'>";

      					      foreach($items as $item) {

      					      	  echo "<div class='col-md-3 col-sm-6'>";

      					      	      echo "<div class='thumbnail items-box' id='myads'>";
                                       
                                       if($item['Approve']==0) {
                                              echo "<span class='approve-message'>Waiting Approve</span>";
                                       }
      					      	             echo "<span>$".$item['Price']."</span>";

      					                     echo "<img class='img-responsive' src='765-default-avatar.png'>";
      					                     echo "<h3><a href='items.php?itemid=".$item['ID']."'>".$item['Name']."</a></h3>";
      					                     echo "<p>". $item['Description']."</p>";

                                     echo "<div class='date'>".$item['add_date']."</div>";



      					      	      echo "</div>";

      					      	  echo "</div>";

					      	 
					      } 

               //  echo "</div>";

              } else {
                   
                   echo "  There Is No Advertise";
              }

					   ?>

             
      
          </div>
          
     </div>

 </div>

 </div>




 <div class="mycomments">

     <div class="container">

          <div class="panel panel-primary">
               <div class="panel-heading">My comments</div>
               <div class="panel-body">
                      <?php
                           
                           $stmt = $connec->prepare("SELECT *FROM comments WHERE user_id=? ");

                           $stmt->execute(array($userinfo['userID']));

                           $comments = $stmt->fetchAll();

                           if(!empty($comments)) {

                             foreach ($comments as $comment) {
                             	
                             	echo "<p>".$comment['Comment']."</p>";                             }

                           } else {

                           	   echo "There is No Comments";
                           }

                      ?>
                </div>
      
          </div>
          
     </div>

 </div>



<?php
   include $tpl."footer.php";

  } else {

  	header("location:login.php");
  	exit();

  }
?>