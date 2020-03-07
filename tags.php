<?php $pagetitle ='Categories Items'; include 'init.php';  ?>

<div class="container">

   

   <?php

       if(isset($_GET['name'])) {

         $tag = $_GET['name'];

    
     echo "<h1 class='text-center'>".  $_GET['name']  ."</h1>";


  }

    echo  "<div class='row'>";
     
     $items = getAll("*","items","WHERE Tag like '%$tag%'",'AND Approve=1','ID');

      foreach($items as $item) {

      	  echo "<div class='col-md-3 col-sm-6'>";

      	      echo "<div class='thumbnail items-box'>";

      	             echo "<span>".$item['Price']."</span>";

                     echo "<img class='img-responsive' src='765-default-avatar.png'>";
                     echo "<h3><a href='items.php?itemid=".$item['ID']."'>".$item['Name']."</a></h3>";
                     echo "<p>". $item['Description']."</p>";



      	      echo "</div>";

      	  echo "</div>";

      	
      }

   ?>

    </div>

</div>


<?php include $tpl.'footer.php'; ?>