<?php

    session_start();
   
     $pagetitle = 'Dashbord';
  
   if(isset($_SESSION['Username'])) {

           
             include 'init.php';

             $LatestUsers = 6;

             $getLatestUsers = getLatest("*","user","userID",$LatestUsers);


             $LatestItems = 6;

             $GetLatestItems = getLatest('*','items','ID',$LatestItems);

             ?>



             <h1 class="text-center">Dashbord</h1>

             <div class="home">
                
                <div class="container">
                  <div class="row">
                    <div class="col-md-3">
                      <div class="stat st-member">
                          <div class="info pull-right">
                           Members
                           <span><a href="members.php"><?php echo countItems('userID','user');?></a></span>

                           </div>

                           <i class="fa fa-users pull-left"></i>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="stat st-pending">
                   <!--    <div class="info pull-right">
                         Pending Members
                     <span><a href='members.php?do=manage&page=pending'><?php echo checkItem('RegStatus','user',0) ?></a></span>
                         </div>
                        -->
                          <div class="info pull-right">
                          Pending Members
                           <span><a href="members.php"><?php echo countItems('userID','user');?></a></span>

                           </div>

                         <i class="fa fa-user-plus pull-left"></i>
                      </div>

                    </div>
                    <div class="col-md-3">
                      <div class="stat st-item">

                       <div class="info pull-right">
                           Items
                            <span><a href="items.php"><?php echo countItems('ID','items');?></a></span>

                           </div>

                         <i class="fa fa-tag pull-left"></i>
                       
                         
                      </div>
                    </div>

                    <div class="col-md-3">
                      <div class="stat st-comment">

                         <div class="info pull-right">
                           Total Comments
                           <span><a href="comments.php"><?php echo countItems('Cid','comments') ?></a> </span>

                           </div>

                         <i class="fa fa-comments pull-left"></i>
                       
                         
                         
                      </div>
                    </div>
                  </div>
                </div>


             </div>
        


            <!-- stat latest -->

             <div class="latest">

                 <div class="container">

                    <div class="row">
                      <div class="col-sm-6">
                         <div class="panel panel-default" >
                            <div  class="panel-heading "><i class="fa fa-users"></i>Latest <?php echo $LatestUsers ?> Registered Members <i  id='latest-member' class="fa fa-plus pull-right"></i></div>
                                <div class="panel-body">
                                     <?php
                                     echo "<ul class='list-unstyled latest-list'>";
                                     foreach ($getLatestUsers as $row) {
                                       
                                         echo "<li>".$row['userName']."<a href='members.php?do=Edit&userid=".$row['userID']."'><span class='btn btn-success pull-right'><i class='fa fa-edit'></i>Edit</span></a>";

                                            if($row['RegStatus']==0) {

                                              
                                               echo"<a href='members.php?do=Activate&userid=".$row['userID']."'><span class='btn btn-primary pull-right'>Activate</span></a>";
                                              
                                         }
                                         echo "</li>";
                                        
                                     }

                                     echo "<ul>";

                                                       
                                              

                                     ?>
                                </div>
                          </div>

                      </div>

                       <div class="col-sm-6">
                         <div class="panel panel-default">
                            <div class="panel-heading"><i class="fa fa-tag"></i>Latest Items <i  id='latest-items' class="fa fa-plus pull-right"></i></div>
                                <div class="panel-body">
                                     <ul class="list-unstyled latest-list">

                                           <?php

                                               foreach ($GetLatestItems as  $item) {
                                                 
                                                   echo "<li>";

                                                   echo $item['Name'];

                                               echo "<a href='items.php?do=Edit&itemid=".$item['ID']."' class='btn btn-success pull-right'><i class='fa fa-edit'></i>Edit";

                                                      echo "</a>";


                                                      if($item['Approve'] == 0) {

                                                         echo "<a href='items.php?do=Approve&itemid=".$item['ID']."' class='btn btn-info pull-right'><i class='fa fa-check'></i>Approve
                                                      ";

                                                      echo  "</a>";
                                                      }

                                                   echo "</li>";


                                               }
                                              

                                           ?>

                                     </ul>
                                </div>
                          </div>

                      </div>

                      </div>


                         <div class="row">


                         <div class="col-sm-6">
                         <div class="panel panel-default">
                            <div class="panel-heading"><i class="fa fa-tag"></i> Members Commments <i  id='latest-items' class="fa fa-plus pull-right"></i></div>
                                <div class="panel-body">
                                     <ul class="list-unstyled latest-list">

                                    <?php

                                $stmt = $connec->prepare("SELECT comments.* , user.userName FROM comments 
  
                                    INNER JOIN user ON user.userID = comments.user_id

                                   

                                 ") ;

                                  $stmt->execute();

                                   $rows = $stmt->fetchAll();

                                     foreach ($rows as $row) {

                                      echo "<div class='com-box'>";


                                        
                                        echo "<span class='member-n pull-left'>"."<a href='members.php?do=Edit&userid=".$row['user_id']."'>". $row['userName']."</a>" . "</span>";
                                         echo "<p class='member-c'>". $row['Comment'] . "</p>";
                                        

                                         echo "</div>";
                                        
                                     }

                                   
                                                       
                                              

                                     ?>

                                   </ul>
                                </div>
                          </div>

                      </div>



                     <!-- ////////////////////////////////////////-->
                   
                   </div>
                    
                 </div>
             </div>


         







          <?php

          include $tpl.'footer.php';

    }

    else {

    	  header('location:index.php');
    	  exit();
    }

