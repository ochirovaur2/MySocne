<div class="container miniContainer">
  
  <div class="row">
    <div class="col-6">
      <?php if($_GET['userid']) { ?>
  		<?php displayTweets($_GET['userid']);  ?>
  
		<?php } else { ?>
      <h2>Active users </h2>
      <?php displayUsers();  ?>
      <?php }?>
    </div>
    
    <div class="col-6">
      <?php displaySearch();
      ?>
      <hr>
      <?php displayTweetBox();
      ?>
    </div>
  </div>
</div>