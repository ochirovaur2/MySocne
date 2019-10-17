


	<script  src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<!-- Button trigger modal -->
    

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="loginModalTitle">Login</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="alert alert-danger" id="loginAlert">
            </div>
            <form>
              <input type="hidden" name="loginActive" id="loginActive" value="1">
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" placeholder="Enter your email">
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Enter your password">
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <a id="toggleLogin">Sign Up </a>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="loginSignUpButton">Login</button>
          </div>
        </div>
      </div>
    </div>
	<script>
      $("#toggleLogin").click(function(){
       if($("#loginActive").val() == "1") {
         $("#loginActive").val("0");
         $("#loginModalTitle").html("Sign Up!");
         $("#loginSignUpButton").html("Sign Up!");
          $("#toggleLogin").html("Login");
       } else {
         $("#loginActive").val("1");
         $("#loginModalTitle").html("Login");
         $("#loginSignUpButton").html("Login");
          $("#toggleLogin").html("Sign Up!");
       }
      })
      
      $("#loginSignUpButton").click(function() {
		$.ajax({
          type: "POST",
          url: "http://projectofsocnet-com.stackstaging.com/actions.php?action=loginSignUp",
          data: "email=" + $("#email").val() + "&password=" + $("#password").val() +"&loginActive=" + $("#loginActive").val(),
          success: function(result) {
            if(result == "1") {
              window.location.assign("http://projectofsocnet-com.stackstaging.com/");
            } else {
              $("#loginAlert").html(result).show();
            }
          }
          
        })
      })
      
      $(".toggleFollow").click(function() {
       	var id = $(this).attr('data-userId');
         $.ajax({
          type: "POST",
          url: "http://projectofsocnet-com.stackstaging.com/actions.php?action=toggleFollow",
          data: "userId=" + $(this).attr('data-userId'),
          success: function(result) {
            if(result == 1){
              $("a[data-userId='" + id + "']").html("Follow");
            } else if  (result == 2){
              $("a[data-userId='" + id + "']").html("Unfollow");
            }
          }
          
        })
      })
      
         $("#postTweet").click(function() {
            if($("#tweetContent").val()) {
                $.ajax({
                  type: "POST",
                  url: "http://projectofsocnet-com.stackstaging.com/actions.php?action=postTweet",
                  data: "tweet=" + $("#tweetContent").val(),
                  success: function(result) {
                    if (result == 1) {
                      $("#alertOfPost").html('<div class="alert alert-success" role="alert">Your message has been published successfully! :) </div>');
                    } else if (result == 0) {
                      $("#alertOfPost").html('<div class="alert alert-danger" role="alert">There was some problem, please try again</div>');
                    }

                  }
                })
              } else {
                $("#alertOfPost").html('<div class="alert alert-danger" role="alert">Please enter some text</div>');
              }
        })
       
    
	</script>
  </body>
</html>