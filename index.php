<?php
session_start();
$pagetitle = 'index'; 
 include 'init.php';
 
?>
 

  <div class="container">

    <?php 
       $items = getAll('*','items','','','ID');
      
       	   
       	    

                         echo "<div class='row'>";

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


    ?>


  </div>



<?php
   
 include  $tpl.'footer.php';

 ?>