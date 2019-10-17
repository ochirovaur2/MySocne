<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Hello, world!</title>
    <link rel="stylesheet" href="styles.css">
    <style>
      #loginAlert{
      display: none;
    }
      .miniContainer{
        padding: 20px;
      }
      .time {
        color: lightgrey;
      }
      .tweet{
        border: 1px solid gray;
        border-radius: 5px;
        padding: 5px;
        margin: 5px;
      }
    </style>
  </head>
  <body>

    <nav class="navbar navbar-expand-sm navbar-light bg-light">
  <a class="navbar-brand" href="http://projectofsocnet-com.stackstaging.com/">SocNet &#9993;</a>
   <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

   <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      
      <li class="nav-item">
        <a class="nav-link" href="?page=timeline">Your timeline</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="?page=yourposts">Your posts</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="?page=publicprofiles">Public profiles</a>
      </li>
    </ul>
   
    <div class="form-inline my-2 my-lg-0"> 
      <?php 
      if($_SESSION["id"]) { ?>
  		<a class="btn btn-outline-success my-2 my-sm-0" href="?function=logout">
 		 Logout
       </a>
  	<?php } else { ?> 
      <button type="button" class="btn btn-outline-success my-2 my-sm-0" data-toggle="modal" data-target="#exampleModal">
      Login/Signup
      </button>
    <?php }  ?>     
      
    </div>
 	</div>
</nav>