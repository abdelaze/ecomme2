<?php $pagetitle ='Categories Items'; include 'init.php';  ?>

<div class="container">

<h1 class="text-center"> Category Items </h1>

    
    <div class="row">
   <?php
     
      $items = getItems('cat_id',$_GET['pageid']);

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