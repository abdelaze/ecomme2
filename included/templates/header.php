
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title><?php echo getTitle(); ?></title>
	<link rel="stylesheet" href="<?php echo $Css;?>bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo $Css;?>font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo $Css;?>jquery-ui.css">
	<link rel="stylesheet" href="<?php echo $Css;?>jquery.selectBoxIt.css">
	<link rel="stylesheet" href="<?php echo $Css;?>style.css">
</head>
<body>

  <div class='upper-bar'>
      <div class="container">

           <?php
               if(isset($_SESSION['user'])) {?>


                   <img src="765-default-avatar.png" alt="default" class="img-circle my-image img-thumbnail">
                    <div class="btn-group">
                          <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                           <?php echo $_SESSION['user'] ?><span class="caret"></span>
                          </button>
                          <ul class="dropdown-menu">
                              <li><a href='profile.php'>My Profile</a></li>
                              <li><a href='newad.php'>Add Item</a></li>
                                <li><a href='profile.php#myads'>My Items</a></li>
                              <li> <a href='logout.php'>Logout</a></li>
                              
                          </ul>
                    </div>

                  
             <?php   }

                else {

            ?>
   
         <a href="login.php"><span class="pull-right">Login/SignUp</span></a>

         <?php } ?>
          
      </div>
  </div>
<nav class="navbar navbar-inverse">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#zaza" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">HomePage</a>
    </div>


    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="zaza">

     <ul class="nav navbar-nav navbar-right">
       
       <?php
 
        $categories = getALL('*','categories','WHERE Parent=0','','ID');

         foreach ($categories as $cat) {
               
              echo "<li>"."<a href='categories.php?pageid=".$cat['ID']."'>".$cat['Name']."</a></li>";
         }

       ?>

      </ul>
      
     
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

 
