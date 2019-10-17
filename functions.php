<?php
	session_start();
	$link = mysqli_connect("shareddb-o.hosting.stackcp.net", "Twitter-31303957d3", "VOzUKScC{Vlg", "Twitter-31303957d3");

	if(mysqli_connect_error()){
      print_r(mysqli_connect_error());
      exit();
    }
	if (isset($_GET["function"])) {
      if($_GET["function"] == "logout") {
        session_unset();
      }
    }
	
	function time_since($since) {
      $chunks = array(
          array(60 * 60 * 24 * 365 , 'year'),
          array(60 * 60 * 24 * 30 , 'month'),
          array(60 * 60 * 24 * 7, 'week'),
          array(60 * 60 * 24 , 'day'),
          array(60 * 60 , 'hour'),
          array(60 , 'minute'),
          array(1 , 'second')
      );

      for ($i = 0, $j = count($chunks); $i < $j; $i++) {
          $seconds = $chunks[$i][0];
          $name = $chunks[$i][1];
          if (($count = floor($since / $seconds)) != 0) {
              break;
          }
      }

      $print = ($count == 1) ? '1 '.$name : "$count {$name}s";
      return $print;
	}
	

	function displayTweets($type){
      global $link;
      
      //public
      if ($type == 'public') {
        $whereClause = "";
          $query = "SELECT * FROM tweets ".$whereClause." ORDER BY `datetime` DESC LIMIT 100";
      $result = mysqli_query($link, $query);
      if(mysqli_num_rows($result) == 0) {
        echo "There are no tweets to display";
      } else{
        while ($row = mysqli_fetch_assoc($result)) {
          $userQuery = "SELECT * FROM users WHERE id = ".mysqli_real_escape_string($link, $row['userid'])." LIMIT 1";
          $userQueryResult = mysqli_query($link, $userQuery);
          $user = mysqli_fetch_assoc($userQueryResult);
          echo "<div class='tweet'><p><a href='?page=publicprofiles&userid=".$user['id']."'>".$user['email']."</a> <span class='time'>".time_since(time() - strtotime($row['datetime']) + 14)." ago</span></p>";
          echo "<p>".$row["tweet"]."</p>";
          echo "<p><a class='toggleFollow' data-userId='".$row['userid']."'>";
                $isFollowingQuery = "SELECT * FROM `isFollowing` WHERE `follower` = '".mysqli_real_escape_string($link, $_SESSION["id"])."' AND `isFollowing` = '".mysqli_real_escape_string($link, $row['userid'])."' LIMIT 1";
         $isFollowingResult = mysqli_query($link, $isFollowingQuery);
          if (mysqli_num_rows($isFollowingResult) > 0) {
            echo "Unfollow"; 
          } else {
            echo "Follow";
          }
          
            
          echo "</a></p> </div>";
        }
      }
        
      } 
      //isFollowing
      else if ($type == 'isFollowing'){
         $query = "SELECT * FROM `isFollowing` WHERE `follower` = ".mysqli_real_escape_string($link, $_SESSION["id"]);
         $result = mysqli_query($link, $query);
        $whereClause = "";
         while( $row = mysqli_fetch_assoc($result)) {
           if($whereClause == "") $whereClause = "WHERE"; 
           else $whereClause.= " OR ";
           $whereClause.= " userid = ".$row['isFollowing'];
         }
        if($whereClause == "") {
          echo "<p>There are no tweets to display, please follow someone.</p>";
          
        } else {
               $query = "SELECT * FROM tweets ".$whereClause." ORDER BY `datetime` DESC LIMIT 100";
          $result = mysqli_query($link, $query);
          if(mysqli_num_rows($result) == 0) {
            echo "There are no tweets to display";
          } else{
            while ($row = mysqli_fetch_assoc($result)) {
              $userQuery = "SELECT * FROM users WHERE id = ".mysqli_real_escape_string($link, $row['userid'])." LIMIT 1";
              $userQueryResult = mysqli_query($link, $userQuery);
              $user = mysqli_fetch_assoc($userQueryResult);
              echo "<div class='tweet'><p><a href='?page=publicprofiles&userid=".$user['id']."'>".$user['email']."</a> <span class='time'>".time_since(time() - strtotime($row['datetime']) + 14)." ago</span></p>";
              echo "<p>".$row["tweet"]."</p>";
              echo "<p><a class='toggleFollow' data-userId='".$row['userid']."'>";
                    $isFollowingQuery = "SELECT * FROM `isFollowing` WHERE `follower` = '".mysqli_real_escape_string($link, $_SESSION["id"])."' AND `isFollowing` = '".mysqli_real_escape_string($link, $row['userid'])."' LIMIT 1";
             $isFollowingResult = mysqli_query($link, $isFollowingQuery);
              if (mysqli_num_rows($isFollowingResult) > 0) {
                echo "Unfollow"; 
              } else {
                echo "Follow";
              }


              echo "</a></p> </div>";
            }
          }
        }
      }
      //your posts
       else if ($type == 'yourPosts') {
              $query = "SELECT * FROM tweets WHERE userid = ".mysqli_real_escape_string($link, $_SESSION["id"])." ORDER BY `datetime` DESC LIMIT 100";
                $result = mysqli_query($link, $query);
                if(mysqli_num_rows($result) == 0) {
                  echo "There are no tweets to display";
                } else{
          while ($row = mysqli_fetch_assoc($result)) {
            $userQuery = "SELECT * FROM users WHERE id = ".mysqli_real_escape_string($link, $_SESSION['id'])." LIMIT 1";
            $userQueryResult = mysqli_query($link, $userQuery);
            $user = mysqli_fetch_assoc($userQueryResult);
          	echo "<div class='tweet'><p><a href='?page=publicprofiles&userid=".$user['id']."'>".$user['email']."</a> <span class='time'>".time_since(time() - strtotime($row['datetime']) + 14)." ago</span></p>";
            echo "<p>".$row["tweet"]."</p>";



            echo "</a></p> </div>";
          }
      	}
      }
      // search
      
    else if ($type == 'search') {
        echo "<p>Showing results for '".mysqli_real_escape_string($link, $_GET['queryOfSearch'])."':</p>";
          $query = "SELECT * FROM tweets WHERE tweet like '%".mysqli_real_escape_string($link, $_GET['queryOfSearch'])."%' ORDER BY `datetime` DESC LIMIT 100";
      $result = mysqli_query($link, $query);
      if(mysqli_num_rows($result) == 0) {
        echo "There are no tweets to display";
      } else{
        while ($row = mysqli_fetch_assoc($result)) {
          $userQuery = "SELECT * FROM users WHERE id = ".mysqli_real_escape_string($link, $row['userid'])." LIMIT 1";
          $userQueryResult = mysqli_query($link, $userQuery);
          $user = mysqli_fetch_assoc($userQueryResult);
          echo "<div class='tweet'><p><a href='?page=publicprofiles&userid=".$user['id']."'>".$user['email']."</a> <span class='time'>".time_since(time() - strtotime($row['datetime']) + 14)." ago</span></p>";
          echo "<p>".$row["tweet"]."</p>";
          echo "<p><a class='toggleFollow' data-userId='".$row['userid']."'>";
                $isFollowingQuery = "SELECT * FROM `isFollowing` WHERE `follower` = '".mysqli_real_escape_string($link, $_SESSION["id"])."' AND `isFollowing` = '".mysqli_real_escape_string($link, $row['userid'])."' LIMIT 1";
         $isFollowingResult = mysqli_query($link, $isFollowingQuery);
          if (mysqli_num_rows($isFollowingResult) > 0) {
            echo "Unfollow"; 
          } else {
            echo "Follow";
          }
          
            
          echo "</a></p> </div>";
        }
      }
        
      } 
      else if (is_numeric($type)) {
       
        
      $query = "SELECT * FROM tweets WHERE userid = ".mysqli_real_escape_string($link, $type)." ORDER BY `datetime` DESC LIMIT 100";
      $result = mysqli_query($link, $query);
      if(mysqli_num_rows($result) == 0) {
        
        echo "There are no tweets to display";
      } else{
        
        
        while ($row = mysqli_fetch_assoc($result)) {
          $userQuery = "SELECT * FROM users WHERE id = ".mysqli_real_escape_string($link, $row['userid'])." LIMIT 1";
          $userQueryResult = mysqli_query($link, $userQuery);
          $user = mysqli_fetch_assoc($userQueryResult);
          echo "<p>".$user['email']."'s post</p>";
          echo "<div class='tweet'><p><a href='?page=publicprofiles&userid=".$user['id']."'>".$user['email']."</a> <span class='time'>".time_since(time() - strtotime($row['datetime']) + 14)." ago</span></p>";
          echo "<p>".$row["tweet"]."</p>";
          echo "<p><a class='toggleFollow' data-userId='".$row['userid']."'>";
                $isFollowingQuery = "SELECT * FROM `isFollowing` WHERE `follower` = '".mysqli_real_escape_string($link, $_SESSION["id"])."' AND `isFollowing` = '".mysqli_real_escape_string($link, $row['userid'])."' LIMIT 1";
         $isFollowingResult = mysqli_query($link, $isFollowingQuery);
          if (mysqli_num_rows($isFollowingResult) > 0) {
            echo "Unfollow"; 
          } else {
            echo "Follow";
          }
          
            
          echo "</a></p> </div>";
        }
      }
        
      } 
    }

	function displaySearch() {
      
      echo '
      <form class="form-inline">
        <div class="form-group mb-2">
          <input type="hidden" name="page" value="search">
          <input type="text" name="queryOfSearch" class="form-control" id="search" placeholder="Search">
        </div>
        
        <button  type="submit" class="btn btn-primary mb-2">Search</button>
      </form>
      ';
    }
	function displayTweetBox() {
      
      if($_SESSION["id"] > 0) {
        echo '<div class="form">
        <div class="form-group">
          
          <textarea type="text" class="form-control" id="tweetContent"></textarea>
        </div>
        <div id="alertOfPost">
          
        </div>
        <button  class="btn btn-primary" id="postTweet">Post your news</button>
      </div>
     
      ';
      }
    }

	function displayUsers() {
      global $link;
      $query = "SELECT * FROM users  LIMIT 100";
      $result = mysqli_query($link, $query);
      while ($row = mysqli_fetch_assoc($result)) {
        echo "<p><a href='?page=publicprofiles&userid=".$row["id"]."'>".$row["email"]."<a></p>";
      }
    }
	
?>