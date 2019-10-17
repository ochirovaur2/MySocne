<div class="container miniContainer">
  
  <div class="row">
    <div class="col-6">
      <h2>Posts for you </h2>
      <?php displayTweets('isFollowing'); ?>
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