<?php
  session_start();
  $pagetitle= "Show Itmes";
  include 'init.php';

    $itemid = isset($_GET['itemid'])&& is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

    $stmt = $connec->prepare("SELECT items.* ,categories.Name AS category_name , user.userName  FROM items
                                 
                               INNER JOIN categories ON categories.ID = items.cat_id

                               INNER JOIN user ON user.userID = items.member_id
                                
                               WHERE items.ID=?  AND Approve=1");

   
    $stmt->execute(array($itemid));

    $count = $stmt->rowCount();
    
    if($count>0) {

     
    $item = $stmt->fetch();



?>
   
    <h1 class="text-center"><?php echo $item['Name'] ?> </h1>

    <div class="container">
       <div class="row">
          <div class="col-md-3">
            <img src="765-default-avatar.png" class="img-responsive center-block"  alt='default'>
          </div>
          <div class="col-md-9">
             <div class="item-info">
                 <h3><span>Name:</span> <?php echo $item['Name'] ?></h3>
                 <p><span>Description:</span><?php echo $item['Description'] ?></p>
                 <ul class="list-unstyled">
                    <li><span>Date:</span><?php echo $item['add_date'] ?></li>
                     <li> <span>Price:$</span><?php echo $item['Price'] ?></li>
                     <li><span>Made In:</span><?php echo $item['country_made'] ?></li>
                     <li><span>Category:</span><?php echo "<a href='categories.php?pageid=".$item['cat_id']."'>".$item['category_name']."</a>" ?></li>
                     <li><span>Member:</span><?php echo "<a href='profile.php'>".$item['userName']."</a>" ?></li>

                        <?php

                            $tags =  explode(',' , $item['Tag']);

                            echo   "<li><span>Tags:</span>";
                            foreach ($tags as $tag) {

                              $tag = str_replace(' ', '', $tag);                       
                              $lowertag = strToLower($tag);
                            echo "<a href='tags.php?name={$lowertag}'>" . $tag ." | </a>";
                            }

                            echo "</li>";

                          
                        ?>
                    
                 </ul>
             </div>
          </div>
       </div>
        <hr class="custom-hr">

        <?php
          if(isset($_SESSION['user'])) {
        ?>
        <div class="row">
          <div class="col-md-offset-3">
            <div class="add-comment">
              <h3>Add Your Comment</h3>
              <form action="<?php echo $_SERVER['PHP_SELF'].'?itemid='.$item['ID']?>"  method="POST">
                 <textarea rows="6" cols="45" name="comment"></textarea>
                 <input type="submit" class="btn btn-primary" value="Add Comment">
              </form>
                <?php
                 if($_SERVER['REQUEST_METHOD']=="POST") {
                       
                       $comment = filter_var($_POST['comment'],FILTER_SANITIZE_STRING);
                       $itemid = $item['ID'];
                       $memberid = $_SESSION['uid'];

                       if(!empty($comment)) {

                          $stmt = $connec->prepare("INSERT INTO comments(Comment,Status,Comment_date,item_id,user_id)

                                                    VALUES(:zcomment,0,now(),:zitemid,:zuserid)");

                          $stmt->execute(array(

                              'zcomment' => $comment,
                              'zitemid'  => $itemid,
                              'zuserid'  => $memberid
 
                            ));

                          if($stmt) {
                            echo "<div class='alert alert-success'>Comment Added</div>";
                          }

                       }
                       else {
                              
                              echo "<div class='alert alert-danger'>Comment cannot Be Empty</div>";
                       }
                 }

                 ?>
            </div>
          </div>
        </div>

        <?php
         } else {
            
            echo "<a href='login.php'>Login or Register</a> TO Add Comment";

         }
        ?>
        <hr class="custom-hr">
        <?php
          $stmt = $connec->prepare("SELECT comments.* ,user.userName FROM comments 

                                    INNER JOIN user 
                                    ON user.userID = comments.user_id
                                    WHERE comments.item_id = ? AND comments.Status = 1

                                    ORDER BY Cid DESC 
                                   ");
          $stmt->execute(array($item['ID']));

          $comments = $stmt->fetchAll();

          foreach ($comments as  $comment) {
              
              echo "<div class='comment-box'>";
              echo "<div class='row'>";
              
              echo "<div class='col-sm-2 text-center'>". "<img src='765-default-avatar.png' class='img-responsive center-block img-thumbnail img-circle' alt='default'>".$comment['userName']."</div>";

              echo "<div class='col-sm-10'>"."<p class='lead'>".$comment['Comment']."</p>"."</div>";

              echo "</div>";
              echo "</div>";
          }


        ?>


     



    </div>


<?php
   
    } else {

         echo "<div class='alert alert-danger text-center'>There Is No Such ID OR Item Waiting Approve</div>";
    }

     include $tpl.'footer.php';
?>