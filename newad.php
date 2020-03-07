<?php

   session_start();
   $pagetitle = 'New Ad';

   if(isset($_SESSION['user'])) {

   	include 'init.php';

   	if($_SERVER['REQUEST_METHOD']=="POST") {
   
      $formerrors = array();

      $name     = filter_var($_POST['name'],FILTER_SANITIZE_STRING);
      $desc     = filter_var($_POST['Desc'],FILTER_SANITIZE_STRING);
      $country  = filter_var($_POST['country'],FILTER_SANITIZE_STRING);
      $price    = filter_var($_POST['price'],FILTER_SANITIZE_NUMBER_INT);
      $status   = filter_var($_POST['status'],FILTER_SANITIZE_NUMBER_INT);
      $category = filter_var($_POST['category'],FILTER_SANITIZE_NUMBER_INT);
      $tag      = filter_var($_POST['tag'],FILTER_SANITIZE_STRING);

      if(strlen($name)<4) {

        $formerrors [] ="Items Name Must Be At Least 4 Chars";
      }
      if(strlen($desc)<10) {

        $formerrors [] ="Items Desc Must Be At Least 10 Chars";
      }

      if(strlen($country)<2) {

        $formerrors [] ="Items Country Must Be At Least 2 Chars";
      }
      if(empty($price)) {

        $formerrors [] ="Items Price Must Be At Least 4 Chars";
      }
      if(empty($status)) {

        $formerrors [] ="Items Status Must Be At Least 4 Chars";
      }
      if(empty($category)) {

        $formerrors [] ="Items Category Must Be At Least 4 Chars";

      }

      if(empty($formerrors)) {

          $stmt = $connec->prepare("INSERT INTO items(Name,Description,Price,country_made,Status,add_date,cat_id,member_id,$tag)


                                   VALUES(:name,:description,:price,:country,:status,now(),:catid,:memberid,:tag)");

          $stmt->execute(array(

            'name'           =>$name,
            'description'    =>$desc,
            'price'          =>$price,
            'country'        =>$country,
            'status'         =>$status,
            'catid'          =>$category,
            'memberid'       =>$_SESSION['uid'],
            'tag'            =>$tag
                              

            ));

          if($stmt) {

             echo 'Item Added';
          }
      }


 

 ////////////////////////  		
   	}
   
?>


      <h1 class="text-center"> New Ad </h1>

 <div class="new-ad">

     <div class="container">

          <div class="panel panel-primary">
               <div class="panel-heading">Add New Add</div>
               <div class="panel-body">

                   <div class="row">
                      
                       <div class="col-md-8">
                              


                     <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">

                         <div class="form-group">

                            <label class="control-label col-sm-2"> Name </label>
                            <div class="col-md-9 col-sm-10">
                               <input type="text" name="name" class="form-control" required="required" placeholder="Name Of Item" id='live-name' />
                            </div>
                         </div>

                         <div class="form-group">

                            <label class="control-label col-sm-2"> Description </label>
                            <div class="col-md-9 col-sm-10">
                               <input type="text" name="Desc" class="form-control" required="required" placeholder="Description Of Item" id='live-desc'/>
                            </div>
                         </div>

                         <div class="form-group">

                            <label class="control-label col-sm-2"> Price </label>
                            <div class="col-md-9 col-sm-10">
                               <input type="text" name="price" class="form-control" required="required" placeholder="Price Of Item" id='live-price'/>
                            </div>
                         </div>




                         <div class="form-group">

                            <label class="control-label col-sm-2"> Country </label>
                            <div class="col-md-9 col-sm-10">
                               <input type="text" name="country" class="form-control" required="required" placeholder="country made Of Item"/>
                            </div>
                         </div>

                          
                          <div class="form-group">

                            <label class="control-label col-sm-2"> Status </label>
                            <div class="col-md-9 col-sm-10">
                                 <select name="status">
                                 	
                                      <option value="0">...</option>
                                      <option value="1">New</option>
                                      <option value="2">Like New</option>
                                      <option value="3">Used</option>
                                      <option value="4">Old</option>
                                        

                                 </select>
                            </div>
                         </div>


                         


                          <div class="form-group">

                            <label class="control-label col-sm-2"> Category </label>
                            <div class="col-md-9 col-sm-10">
                                 <select name="category">
                                 	
                                      <option value="0">...</option>
                                     <?php

                                        $cats = getAll('*','categories','WHERE Parent=0','','ID');
                                           
                                             foreach($cats as $cat ) {

                                            echo "<option value ='".$cat['ID']."'>".$cat['Name']."</option>";
                                           $childcats = getAll("*","categories","WHERE Parent={$cat['ID']}","","ID");
                                           foreach ($childcats as $c) {

                                              echo "<option value ='".$c['ID']."'>--".$c['Name']."</option>";
                                           }


                                           }
                                          
                                     ?>
                                 </select>
                            </div>
                         </div>


                            <div class="form-group">

                            <label class="control-label col-sm-2"> Member</label>
                            <div class="col-md-9 col-sm-10">
                                 <select name="member">
  
                                       <option value="0">...</option>
                                     <?php

                                        $users = getAll('*','user','','','userID');
                                           
                                          
                                           foreach($users as $user ) {

                                            echo "<option value ='".$user['userID']."'>".$user['userName']."</option>";
                                           }

                                      ?>
                                 </select>
                            </div>
                         </div>



                           <div class="form-group">

                            <label class="control-label col-sm-2"> Tags </label>
                            <div class="col-md-9 col-sm-10">
                               <input type="text" name="tag" class="form-control" placeholder="seperat tags with comma(,)"/>
                            </div>
                         </div>




                          <div class="form-group">

                              <div class="col-sm-offset-2 col-md-9">
                                <input type="submit" value="Add Item" class="form-control btn btn-primary">
                              </div>
                          </div>


                     </form>
                 


                       </div>

                        <div class="col-md-4">
                           

                              <div class='thumbnail items-box live-preview'>

				      	             <span>$0</span>

				                     <img class='img-responsive' src='765-default-avatar.png'>

				                     <div class="item-caption">
					                     <h3>Test</h3>
					                     <p>Description</p>
				                     </div>



                          </div>

                   </div>
                       
                </div>

                <!-- Looping Through Errors -->

               

                     <div class="errors text-center">
                     
                       <?php
                         if(!empty($formerrors)) {
                         foreach ($formerrors as $error) {



                             echo "<div class='alert alert-danger'>".$error."</div>";
                         }
                       }
                       ?>
                      
                     </div>
               
               <!-- ///////////////////////////////-->
          </div>

     </div>

 </div>


<?php
   
   }

   else {

      header("location:login.php");
      exit();
   }

   include $tpl."footer.php";

?>