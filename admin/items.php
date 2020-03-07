<?php

  session_start();
  $pagetitle = 'Items';

  if(isset($_SESSION['Username'])) {

	     include 'init.php';
    
         $do = isset($_GET['do']) ? $_GET['do'] : 'manage' ;

         if($do == 'manage') {

         	 $stmt = $connec->prepare('SELECT items.*,categories.Name AS category_name ,user.userName 

                                      from items 

                                    INNER JOIN categories ON categories.ID = items.cat_id

                                    INNER JOIN user ON user.userID = items.member_id');
         	 $stmt->execute();

         	 $rows = $stmt->fetchAll();

         	 ?>

         	 <div class="container">



         	     <h1 class="text-center">Manage Items</h1>

	         	 <div class="table-responsive text-center">
	                  
	         	      <table class="table main-table table-bordered">
	         	      	
	         	      	     <tr>
	         	                 <td>ID</td>
	         	                 <td>Name</td>
	         	                 <td>Desciption</td>
	         	                 <td>Price</td>
	         	                 <td>Add_Date</td>
	         	                 <td>Category</td>
	         	                 <td>userName</td>
	         	                  <td>Control</td>
	         	      	     </tr>

	         	      	     <?php
                                 
                                 
	         	      	     foreach ($rows as $row) {
	         	      	     	 echo "<tr>";
                                       
                                       echo "<td>".$row['ID']."</td>";
                                       echo "<td>".$row['Name']."</td>";
                                       echo "<td>".$row['Description']."</td>";
                                       echo "<td>".$row['Price']."</td>";
                                       echo "<td>".$row['add_date']."</td>";
                                       echo "<td>".$row['category_name']."</td>";
                                       echo "<td>".$row['userName']."</td>";

                                      echo "<td>";

                                      echo "<a href='items.php?do=Edit&itemid=".$row['ID']."' 

                                           class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>";

                                       echo "  <a href= 'items.php?do=Delete&itemid=".$row['ID']."' 

                                           class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a>";

                                           if($row['Approve'] == 0) {

                                          echo "  <a href= 'items.php?do=Approve&itemid=".$row['ID']."' 

                                           class='btn btn-info'><i class='fa fa-check'></i>Approve</a>";

                                           }

                                        echo "</td>";

                                echo "</tr>";

	         	      	     }
                               

	         	      	     ?>


	         	      </table>

	         	 </div>


	         	 <a href="items.php?do=Add" class="btn btn-primary">Add New Item</a>

         	 </div>
     


         

         <?php  } elseif($do=='Add') {?>
                 
                 <h1 class="text-center">Add New Item</h1>
                 <div class="container">

                     <form class="form-horizontal" action="?do=Insert" method="POST">

                         <div class="form-group">

                            <label class="control-label col-sm-2"> Name </label>
                            <div class="col-md-6 col-sm-10">
                               <input type="text" name="name" class="form-control" required="required" placeholder="Name Of Item" />
                            </div>
                         </div>

                         <div class="form-group">

                            <label class="control-label col-sm-2"> Description </label>
                            <div class="col-md-6 col-sm-10">
                               <input type="text" name="Desc" class="form-control" required="required" placeholder="Description Of Item"/>
                            </div>
                         </div>

                         <div class="form-group">

                            <label class="control-label col-sm-2"> Price </label>
                            <div class="col-md-6 col-sm-10">
                               <input type="text" name="price" class="form-control" required="required" placeholder="Price Of Item"/>
                            </div>
                         </div>




                         <div class="form-group">

                            <label class="control-label col-sm-2"> Country </label>
                            <div class="col-md-6 col-sm-10">
                               <input type="text" name="country" class="form-control" required="required" placeholder="country made Of Item"/>
                            </div>
                         </div>

                          
                          <div class="form-group">

                            <label class="control-label col-sm-2"> Status </label>
                            <div class="col-md-6 col-sm-10">
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

                            <label class="control-label col-sm-2"> Member </label>
                            <div class="col-md-6 col-sm-10">
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

                            <label class="control-label col-sm-2"> Category </label>
                            <div class="col-md-6 col-sm-10">
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

                            <label class="control-label col-sm-2"> Tag </label>
                            <div class="col-md-6 col-sm-10">
                               <input type="text" name="tag" class="form-control" placeholder="Seperate tags with comma"/>
                            </div>
                         </div>



                          <div class="form-group">

                              <div class="col-sm-offset-2 col-md-6">
                                <input type="submit" value="Add Item" class="form-control btn btn-primary">
                              </div>
                          </div>


                     </form>
                     </div>



     <?php    } elseif ($do == 'Insert') {
     	

     	                echo '<h1 class="text-center">Insert Members</h1>';
     	                echo "<div class='container'>";

                        if($_SERVER['REQUEST_METHOD'] == 'POST') {

                        	$name = $_POST['name'];
                        	$desc = $_POST['Desc'];
                        	$price = $_POST['price'];
                        	$country = $_POST['country'];
                        	$status = $_POST['status'];
                        	$member = $_POST['member'];
                        	$cat   = $_POST['category'];
                          $tag = $_POST['tag'];

                        	$formerrors = array();


                           if(empty($name)) {

                           	   $formerrors[] = "The Name Cant Be Empty";
                           }

                           if(empty($desc)) {

                           	   $formerrors[] = "The Desciption Cant Be Empty";
                           }
                           if(empty($price)) {

                           	   $formerrors[] = "The Price Cant Be Empty";
                           }

                           if(empty($country)) {

                           	   $formerrors[] = "The Country Cant Be Empty";
                           }

                           if($status == 0) {

                           	   $formerrors[] = " The Status Cant Be Zero ";
                           }

                            if($member == 0) {

                           	   $formerrors[] = " The Member Cant Be Zero ";
                           }
                            if($cat == 0) {

                           	   $formerrors[] = " The Category Cant Be Zero ";
                           }

                            foreach($formerrors as $error) {
                                      
                                 echo "<div class='alert alert-danger'>".$error."</div>";


                            }

 
                           if(empty($formerrors)) {


                                 $stmt = $connec->prepare("INSERT INTO items(Name,Description,Price,country_made,Status,add_date,cat_id,member_id,Tag) 

                                 Values(:name,:description,:price,:country,:status,now(),:cat,:member,:tag)");

                                 $stmt->execute(array(

                                     'name'          =>$name,
                                     'description'   =>$desc,
                                     'price'         => $price,
                                     'country'       =>$country,
                                     'status'        =>$status,
                                     'cat'           =>$cat,
                                     'member'        =>$member,
                                     'tag'           =>$tag 

                                       

                                 	));

                               $theMsg = "<div class='alert alert-success'>". $stmt->rowCount() ." Record Insertd</div>";

                              Redirect($theMsg); 

                           }
                            
 


                      
                        } else {

                        	$theMsg = "<div class='alert alert-danger'> You Cant Browse This Page Directly </div>";

                            Redirect($theMsg);
                        }


                     echo "</div>";
         

         } elseif ($do == 'Edit') { 

           $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ;

           
               $stmt = $connec->prepare("SELECT *FROM items where ID=? ");

               $stmt->execute(array($itemid));

               $row = $stmt->fetch();

              ?>

               <h1 class="text-center">Edit Items</h1>
             
               <div class="container">

                <form class="form-horizontal" action="?do=Update" method="POST">
               	 

               	<input type="hidden" name="id" value="<?php echo $row['ID']?>" />

               	<div class="form-group">

               	   <label class="col-sm-2 control-label">Name</label>

               	   <div class="col-md-6 col-sm-10">

               	   <input type="text" name="name" class="form-control" value="<?php echo $row['Name']?>"/>

               	   </div>

               	</div>

               		<div class="form-group">

               	   <label class="col-sm-2 control-label">Description</label>

               	   <div class="col-md-6 col-sm-10">

               	   <input type="text" name="Desc" class="form-control" value="<?php echo $row['Description']?>"/>
               	   
               	   </div>

               	   </div>


               	   	<div class="form-group">

               	   <label class="col-sm-2 control-label">Price</label>

               	   <div class="col-md-6 col-sm-10">

               	   <input type="text" name="price" class="form-control" value="<?php echo $row['Price']?>"/>

               	   
               	   </div>

               	</div>


               	<div class="form-group">

                            <label class="control-label col-sm-2"> Country </label>
                            <div class="col-md-6 col-sm-10">
                               <input type="text" name="country" class="form-control" required="required" value="<?php echo $row['country_made']?>"/>
                            </div>
                         </div>



              
                	<div class="form-group">

               	   <label class="col-sm-2 control-label">Status</label>

               	   <div class="col-md-6 col-sm-10">

               	     <select name="status">
               	     	
                        <option value="0">....</option>
                         <option value="1" <?php if($row['Status']== 1){ echo 'selected';}?> >New</option>
                         <option value="2" <?php if($row['Status']== 2){ echo 'selected';}?>>Like New</option>
                         <option value="3"<?php if($row['Status']== 3){ echo 'selected';}?>>Used</option>
                         <option value="4" <?php if($row['Status']== 4){ echo 'selected';}?>>Old</option>

               	     </select>
               	   
               	   </div>

               	</div>


                 <div class="form-group">

                            <label class="control-label col-sm-2"> Member </label>
                            <div class="col-md-6 col-sm-10">
                                 <select name="member">
                                  
                                      <option value="0">...</option>
                                     <?php

                                        $users = getAll('*','user','','','userID');
                                           
                                          
                                           foreach($users as $user ) {

                                            echo "<option value ='".$user['userID']."'";
                                              
                                              if($user['userID']==$row['member_id']) {

                                                 echo "selected";
                                              }


                                            echo ">".$user['userName']."</option>";
                                           }
                                          
                                     ?>
                                 </select>
                            </div>
                         </div>


                          <div class="form-group">

                            <label class="control-label col-sm-2"> Category </label>
                            <div class="col-md-6 col-sm-10">
                                 <select name="category">
                                  
                                      <option value="0">...</option>
                                     <?php

                                        $cats = getAll('*','categories','WHERE Parent=0','','ID');
                                           
                                             foreach($cats as $cat ) {

                                            echo "<option value ='".$cat['ID']."'";
                                              
                                               if($cat['ID']==$row['cat_id']) {

                                                 echo "selected";
                                              }


                                            echo ">".$cat['Name']."</option>";



                                           $childcats = getAll("*","categories","WHERE Parent={$cat['ID']}","","ID");
                                           foreach ($childcats as $c) {

                                              echo "<option value ='".$c['ID']."'";
                                               
                                                 if($c['ID']==$row['cat_id']) {

                                                 echo "selected";
                                              }

                                              echo ">--".$c['Name']."</option>";
                                           }


                                           }
                                          
                                     ?>
                                 </select>
                            </div>
                         </div>
                          <div class="form-group">

                              <div class="col-sm-offset-2 col-md-6">
                                <input type="submit" value="Update Item" class="form-control btn btn-primary">
                              </div>
                          </div>


                   </form>

                   <?php

                          $stmt = $connec->prepare("SELECT comments.* , items.Name AS Item_Name  FROM comments 

                                  INNER JOIN items ON items.ID = comments.item_id
                                
                                  WHERE comments.item_id = ?
                                 

                                 ") ;

                          $stmt->execute(array($itemid));

                          $rows = $stmt->fetchAll();



              if(!empty($rows)) {

                   ?>
    

               
              <h1 class="text-center">Manage Comments</h1>
      

             <div class="table-responsive">
                 <table class="table-bordered text-center main-table table">
                  
                        <tr>
                         
                           <td>Comment</td>
                           <td>Add_Date</td>
                           <td>Item_Name</td>
                           <td>Control</td>

                        </tr>

                        <?php
                                
                               foreach ($rows as $row) {
                                
                                     echo "<tr>";

                                  
                                     echo "<td>".$row['Comment']."</td>";
                                     echo "<td>".$row['Comment_date']."</td>";
                                     echo "<td>".$row['Item_Name']."</td>";
                                    

                                     echo "<td>"."<a href='comments.php?do=Edit&comid=".$row['Cid']."' class = 'btn btn-success'><i class='fa fa-edit'></i>Edit</a>";
                                    

                                      echo " <a href='comments.php?do=Delete&comid=".$row['Cid']."' class = 'confirm btn btn-danger'><i class='fa fa-close'></i>Delete</a>";

                                      if($row['Status'] == 0) {

                                           echo " <a href='comments.php?do=Approve&comid=".$row['Cid']."' class = 'btn btn-info'><i class='fa fa-check'></i>Approve</a>";
                                      }

                                     echo "</td>";




                                     echo "</tr>";

                               }
                             


                    } 

                        ?>

                      </table>

                      </div>


               	</div>





                           

         	

       <?php  }  elseif($do == "Update") {




             if($_SERVER['REQUEST_METHOD'] == 'POST') {

             	echo "<div class='container'>";

             	$id = $_POST['id'];
             	$name = $_POST['name'];
             	$desc = $_POST['Desc'];
             	$status = $_POST['status'];
             	$country = $_POST['country'];
             	$price = $_POST['price'];
             	$catid = $_POST['category'];
             	$memberid = $_POST['member'];

             	$formerrors = array();


                           if(empty($name)) {

                           	   $formerrors[] = "The Name Cant Be Empty";
                           }

                           if(empty($desc)) {

                           	   $formerrors[] = "The Desciption Cant Be Empty";
                           }
                           if(empty($price)) {

                           	   $formerrors[] = "The Price Cant Be Empty";
                           }

                           if(empty($country)) {

                           	   $formerrors[] = "The Country Cant Be Empty";
                           }

                           if($status == 0) {

                           	   $formerrors[] = " The Status Cant Be Zero ";
                           }

                            if($memberid == 0) {

                           	   $formerrors[] = " The Member Cant Be Zero ";
                           }
                            if($catid == 0) {

                           	   $formerrors[] = " The Category Cant Be Zero ";
                           }

                            foreach($formerrors as $error) {
                                      
                                 echo "<div class='alert alert-danger'>".$error."</div>";


                            }

                            if(empty($formerrors)) {

                                 
                                 $check = checkItem('ID','items',$id);

                                 if($check >0) {

                                     $stmt = $connec->prepare("UPDATE items set Name =?, Description = ? ,Price = ?, Status = ?,country_made = ?, cat_id =?, member_id =? WHERE ID = ?");

                                   $stmt->execute(array($name,$desc,$price,$status,$country,$catid,$memberid,$id));

                                   $theMsg = "<div class='alert alert-success'>". $stmt->rowCount()." Updated </div>";

                                 	Redirect($theMsg);
                                 
                                 }

                                 else {

                                 	$theMsg = "<div class='alert alert-danger'> The Item Is Not Exist </div>";

                                 	Redirect($theMsg);
                                 }

                                 echo "</div>";


                            }


///////////////////////////////
             } else {

             	$theMsg = "<div class='alert alert-danger'> The Item Is Not Exist </div>";

                  Redirect($theMsg);
             }

///////////////////////////////////////////////////
       }  elseif($do == 'Delete') {

       	      echo "<h1 class='text-center'>Delete Items</h1>";

       	      echo "<div class='container'>";

               $itemid  = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ;

               $check = checkItem('ID','items',$itemid);

               if($check > 0 ) {

               	    $stmt = $connec->prepare("DELETE FROM items WHERE ID=:id");

               	    $stmt->bindParam("id",$itemid);

               	    $stmt->execute();

               	   $theMsg ="<div class='alert alert-success'>".$stmt->rowCount()." Record Deleted</div>";
                    Redirect($theMsg,'back');

               }

               else {

                    $theMsg ="<div class='alert alert-danger'> This Item Not Found </div>";
                    Redirect($theMsg,'back');
               }

               echo "</div>";

       }    elseif ($do == 'Approve') {
       	           
                   
                       
                    $itemid = isset($_GET['itemid']) &&is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ;

                    echo "<h1 class='text-center'>Approve Items</h1>";

                    echo "<div class='container'>";

                    $check = checkItem('ID','items',$itemid);

                    if($check>0) {

                    	$stmt = $connec->prepare("UPDATE items SET Approve = 1 WHERE ID=?");
                    	$stmt->execute(array($itemid));

                       $theMsg = "<div class='alert alert-success'>". $stmt->rowCount()." Record Updated </div>";

                                 	Redirect($theMsg);
                                 
                  }

                                 else {

                                 	$theMsg = "<div class='alert alert-danger'> The Item Is Not Exist </div>";

                                 	Redirect($theMsg);
                                 }

                                 echo "</div>";


                           

       } /////////////////////////////////////////////////////////
 
		   



		 include $tpl.'footer.php';


 } else {/////////////////////THE END ////////////////////

	 	 header('location:index.php');
	 	 exit();
 }