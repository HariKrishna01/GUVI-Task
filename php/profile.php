<?php 
session_start();

	include("connection.php");
	include("functions.php");
    
	$user_data = check_login($con);

    //Redis
    $redis = new \Redis();

    $redis->connect('127.0.0.1', 6379);
	$redis->set('email', $user_data['email']);

    $user = $redis->get('email');


?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home</title>

    <!-- custom css file link  -->
    <link rel="stylesheet" href="/guvi2/css/style.css">

</head>
<body>
   
<div class="container">

   <div class="profile">
      <?php
       
            echo '<img src="/guvi2/assets/default-avatar.png">';
      ?>
      <h2>Hello!</h2> <p><?php echo $user_data['name'];?></p>
      <a href="./update_profile.php" class="btn">update profile</a>
      <a href="./logout.php" class="delete-btn">logout</a>
   </div>

</div>

</body>
</html>