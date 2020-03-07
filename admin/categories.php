<?php
  
  session_start();

     $pagetitle = 'categories';

  if(isset($_SESSION['Username'])) {

  	 include 'init.php';
     
  	

  	 $do = isset($_GET['do']) ? $_GET['do'] : 'manage';

  	 if($do == 'manage') {

        $sort = 'ASC';

        $sort_array = array('ASC','DESC');

        if(isset($_GET['sort'])&&in_array($_GET['sort'], $sort_array)) {

             $sort = $_GET['sort'];
        }


         $stmts= $connec->prepare("SELECT *from categories WHERE Parent=0 ORDER BY Ordering $sort");

         $stmts->execute();

         $rows = $stmts->fetchAll();



      ?>

          <h1 class="text-center">Mange Categories</h1>
          <div class="container">

  	 	     <div class="panel panel-default">
  
                  <div class="panel-heading">

                       Manage
                         
                      <div class="ordering pull-right">
                        
                          <a class="<?php if($sort=='ASC'){echo 'active'; }?>" href="?sort=ASC">Asc</a> / 
                          <a class="<?php if($sort=='DESC'){echo 'active'; }?>" href="?sort=DESC">Desc</a>

                      </div>




                  </div>
                  <div class="panel-body categories">
                    <?php

                         foreach ($rows as $row) {


                             echo "<div class='cat'>";

                             echo "<div class='hidden-buttons'>";

                                 echo "<a href='categories.php?do=Edit&catid=". $row['ID']." ' class='btn btn-xs btn-success'>Edit</a>";
                                  echo "<a href='categories.php?do=Delete&catname=".$row['Name']."' class='btn btn-xs btn-primary confirm'>Delete</a>";


                             echo "</div>";
                             echo "<h3 class='cat-head'>" . $row['Name'] ."</h3>";

                             echo "<div class='full'>";
                             if($row['Description'] == '')  { 

                              echo "<p> There Is No Description </p>";

                             } 

                             else {

                                echo "<p>" . $row['Description'] . "</p>";
                              }

                             if($row['Visbility'] == 1) {

                                echo "<span class='vis'>hidden</span>"; 
                             }

                              
                               if($row['allow_comment'] == 1) {

                                echo "<span class='com'>comment disaple</span>"; 
                             }

                              if($row['allow_adv'] == 1) {

                                echo "<span class='advs'>advs disaple</span>"; 
                             }

                             echo "</div>";

                             echo '</div>';
                             
                             $childcats = getAll("*","categories","WHERE Parent={$row['ID']}",'','ID');

                             if(!empty($childcats)) {
                                echo "<h4 class='child-head'>Child Categories</h4>";
                                echo "<ul class='list-unstyled child-cats'>";
                                foreach ($childcats as $c) {
                                  
                                     echo "<li class='child-link'><a href='categories.php?do=Edit&catid=".$c['ID']."'>".$c['Name']."

                                     <a href='categories.php?do=Delete&catid=".$c['ID']."' class='confirm child-del'>Delete</a>


                                     </li>";
                                }
                             }
                            
                             echo '<hr>';
                         }
                    ?>


            </div>

          </div>
           <a class="add-cat btn btn-primary" href="categories.php?do=Add"><i class="fa fa-plus"></i>Add New Categroy</a>


  	<?php } elseif ($do=='Add') {?>
  	 	
           <h1 class="text-center"> Add Category </h1>

           <div class="container">
                
                <form class="form-horizontal" action="?do=Insert" method="POST">
                	
                	<div class="form-group form-group-lg">

                	     <label class="col-sm-2 control-label">Name</label>
                	     <div class="col-md-6 col-sm-10">
                             
                             <input type="text" class="form-control" name="name" required="required" autocomplete="off" placeholder="enter category name">

                	     </div>
                	</div>
                	<div class="form-group form-group-lg">

                	     <label class="col-sm-2 control-label">Description</label>
                	     <div class="col-md-6 col-sm-10">
                             
                             <input type="text" class="form-control" name="description" placeholder="descrpe category">

                	     </div>
                	</div>


                    <div class="form-group form-group-lg">

                       <label class="col-sm-2 control-label">Parent? </label>
                       <div class="col-md-6 col-sm-10">
                             
                            <select name="parent" class="form-control">
                              <option value="0">NONE</option>
                              <?php
                                 $allcats = getAll('*','categories','WHERE Parent=0','','ID');
                                 foreach ($allcats as $cat) {
                                   
                                   echo "<option value='".$cat['ID']."'>".$cat['Name']."</option>";
                                 }

                              ?>

                            </select>

                       </div>
                  </div>




                	<div class="form-group form-group-lg">

                	     <label class="col-sm-2 control-label">Order</label>
                	     <div class="col-md-6 col-sm-10">
                             
                             <input type="text" class="form-control" name="ordering" placeholder="enter ordering">

                	     </div>
                	</div>

                	<div class="form-group form-group-lg">

                         <label class="col-sm-2 control-label">Visible</label>
                       <div class="col-md-6 col-sm-10">
                            <div>
		                         <input  id="via-yes" type="radio" name="visbility" value="0" checked >
		                         <label for="via-yes">Yes</label>
                             </div>

                             <div>
		                         <input  id="via-no" type="radio" name="visbility" value="1" >
		                         <label for="via-no">No</label>
                             </div>

                       </div>


                	</div>

                	<div class="form-group form-group-lg">

                         <label class="col-sm-2 control-label">allow commenting</label>
                       <div class="col-md-6 col-sm-10">
                            <div>
		                         <input  id="com-yes" type="radio" name="commenting" value="0" checked >
		                         <label for="com-yes">Yes</label>
                             </div>

                             <div>
		                         <input  id="com-no" type="radio" name="commenting" value="1" >
		                         <label for="com-no">No</label>
                             </div>

                       </div>


                	</div>

                	<div class="form-group form-group-lg">

                         <label class="col-sm-2 control-label">allow advs</label>
                       <div class="col-md-6 col-sm-10">
                            <div>
		                         <input  id="advs-yes" type="radio" name="advs" value="0" checked >
		                         <label for="advs-yes">Yes</label>
                             </div>

                             <div>
		                         <input  id="advs-no" type="radio" name="advs" value="1" >
		                         <label for="advs-no">No</label>
                             </div>

                       </div>


                	</div>

                	<div class="form-group form-group-lg">

                        <div class="col-md-offset-2 col-md-6">
                             <input type="submit" class="btn btn-primary btn-lg btn-block" value="Add Category">
                        </div>

                	</div>


                </form>

           </div>
  	

  	<?php } elseif ($do=='Insert') {
          
            
            echo "<h1 class='text-center'>Insert new Category</h1>";
            echo "<div class='container'>";

            if($_SERVER['REQUEST_METHOD']== 'POST') {

                  $name = $_POST['name'];
                  $desc = $_POST['description'];
                  $parent = $_POST['parent'];
                  $order = $_POST['ordering'];
                  $vis = $_POST['visbility'];
                  $com = $_POST['commenting'];
                  $advs = $_POST['advs'];
                 
              // chech if the caategory exist or not 

                  $check = checkItem('Name','categories',$name);

                  if($check == 1) {
                    
                        $Msg = "<div class='alert alert-danger'> This Item Is Exist  </div>";
                        Redirect($Msg,'back');
                  }

                  else {

                    $stmt = $connec->prepare("insert into categories(Name,Description,Parent,Ordering,visbility,allow_comment,allow_adv) values(:name,:desc,:parent,:order,:vis,:com,:advs)");
                    $stmt->execute(array(

                       'name'    =>$name,
                       'desc'    =>$desc,
                       'parent'  =>$parent,
                       'order'   =>$order,
                       'vis'     =>$vis,
                       'com'     =>$com,
                       'advs'    =>$advs

                      ));

                     $Msg = "<div class='alert alert-success'>". $stmt->rowCount() ."  Recod Inserted</div>";
                      Redirect($Msg,'back');

                  }




            } else {
              $Msg = "<div class='alert alert-danger'> YOu Cant Brwose This Page Directly </div>";
              Redirect($Msg,'back');

            }

    } elseif( $do == 'Edit') {

      $catid = isset($_GET['catid'])&&is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0 ;

      $stmt = $connec->prepare("SELECT * FROM categories WHERE ID = ? ");
      $stmt->execute(array($catid));
      $row = $stmt->fetch();
      $count = $stmt->rowCount();
      if($count > 0) { ?>

       <h1 class="text-center">Edit Category</h1>
       <div class="container">

            <form class="form-horizontal" action="?do=Update" method="POST">

               <input type="hidden" name="id" value="<?php echo $row['ID']; ?>">

               <div class="form-group">

                  
                   <label class="col-sm-2 control-label">Name</label>

                   <div class="col-md-6 col-sm-10">
               
                    <input type="text" class="form-control" name="name" required ="required" placeholder="Enter Category name" value="<?php echo $row['Name']; ?>">

                    </div>

                </div>

                 
                <div class="form-group">

                  <label class="col-sm-2  control-label">Desciption</label>

                   <div class="col-sm-10 col-md-6">
                   <input type="text" class="form-control" name="desc"  placeholder="Enter Category description"value="<?php echo $row['Description']; ?>">
                   </div>

                </div>


                  <div class="form-group form-group-lg">

                       <label class="col-sm-2 control-label">Parent?</label>
                       <div class="col-md-6 col-sm-10">
                             
                            <select name="parent" class="form-control">
                              <option value="0">NONE</option>
                              <?php
                                 $allcats = getAll('*','categories','WHERE Parent=0','','ID');

                                 foreach ($allcats as $cat) {

                                   
                                   echo "<option value='".$cat['ID']."'";

                                   if($row['Parent']==$cat['ID']){echo 'selected';} echo ">".$cat['Name']."</option>";
                                 
                                 }

                              ?>

                            </select>

                       </div>
                  </div>





                
                <div class="form-group">
                     
                  <label class="col-sm-2 control-label">Ordering</label>
                  <div class="col-sm-10 col-md-6"> 
                   <input type="text" class="form-control" name="ordering"  placeholder="Enter  category order" value="<?php echo $row['Ordering']; ?>">
                   </div>

                </div>

                <div class="form-group">
                   <label class="col-sm-2 control-label">Visibility</label>
                   <div class="col-md-6 col-sm-10">
                      <div>
                        <input id='vis-yes' type="radio" name="vis" value="0" <?php if($row['Visbility'] == 0){ echo 'checked';}?>>
                        <label for="vis-yes">Yes</label>
                      </div>
                       <div>
                        <input id='vis-no' type="radio" name="vis" value="1" <?php if($row['Visbility'] == 1){ echo 'checked';}?>>
                        <label for="vis-no">No</label>
                      </div>
                   </div>
                </div>


                <div class="form-group">
                   <label class="col-sm-2 control-label">Commenting</label>
                   <div class="col-md-6 col-sm-10">
                      <div>
                        <input id='com-yes' type="radio" name="com" value="0" <?php if($row['allow_comment'] == 0){ echo 'checked';}?>>
                        <label for="com-yes">Yes</label>
                      </div>
                       <div>
                        <input id='com-no' type="radio" name="com" value="1" <?php if($row['allow_comment'] == 1){ echo 'checked';}?>>
                        <label for="com-no">No</label>
                      </div>
                   </div>
                </div>


                <div class="form-group">
                   <label class="col-sm-2 control-label">Advertising</label>
                   <div class="col-md-6 col-sm-10">
                      <div>
                        <input id='advs-yes' type="radio" name="advs" value="0" <?php if($row['allow_adv'] == 0){ echo 'checked';}?>>
                        <label for="advs-yes">Yes</label>
                      </div>
                       <div>
                        <input id='advs-no' type="radio" name="advs" value="1" <?php if($row['allow_adv'] == 1){ echo 'checked';}?>>
                        <label for="advs-no">No</label>
                      </div>
                   </div>
                </div>

                <div class="form-group">
                   
                   <div class="col-sm-offset-2 col-md-6">

                        <input class="form-control btn btn-primary" type="submit" value="Update">

                   </div>

                </div>
   
            </form>


       </div>

       <?php } else {

            $msg = '<div class="alert alert-danger"> This Id Is Not Exist </div>';

            Redirect($msg ,'back');

           
       }




  } elseif ( $do =='Update') {
    
             if($_SERVER['REQUEST_METHOD'] == 'POST') {

                  $id   = $_POST['id'];
                  $name = $_POST['name'];
                  $desc = $_POST['desc'];
                  $parent= $_POST['parent'];
                  $order = $_POST['ordering'];
                  $vis = $_POST['vis'];
                  $com = $_POST['com'];
                  $advs = $_POST['advs'];
                 
                 $stmt = $connec->prepare("UPDATE categories SET Name= ? ,  Description = ?, Parent = ?, Ordering = ? , Visbility = ? , allow_comment = ? ,allow_adv = ? WHERE ID = ? ");
                 $stmt->execute(array($name,$desc,$parent,$order,$vis,$com,$advs,$id));

                

                  $msg = '<div class="alert alert-success">'.$stmt->rowCount().' Updated </div>';
                  Redirect($msg,'back');


         } else {

                  $msg = '<div class="alert alert-danger"> You Cannot Browse this Page Directly </div>';
                  Redirect($msg,'back'); 
             }


      } elseif($do == 'Delete') {

             $catname = isset($_GET['catname'])&&!empty($_GET['catname']) ? $_GET['catname'] : '0' ;

             $check      = checkItem('Name','categories', $catname);

             if($check >0 ) {
  
                $stmt = $connec->prepare("Delete FROM categories WHERE Name=:name ");

                 $stmt->bindParam(':name', $catname);

                 $stmt->execute();
                
                  $Msg = "<div class = 'alert alert-success'>".$stmt->rowCount(). " Deleted </div>";
                  Redirect($Msg,'back');


             }   
             else {

                $Msg = "<div class = 'alert alert-success'> This Category Not Exist  </div>";
                Redirect($Msg,'back');
             }
       
      }

        include($tpl.'footer.php');

  } else {

  	header('location:index.php');
  	exit();
  }

