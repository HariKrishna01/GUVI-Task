<?php

session_start();



$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "guvi2";

if(!$conn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname))
{

	die("failed to connect!");
}
$user_id = $_SESSION['id'];
//==================================================================
//fetch from sql and store in fetch

$select = mysqli_query($conn, "SELECT * FROM `regist` WHERE id = '$user_id'") or die('query failed 4');
if(mysqli_num_rows($select) > 0){
   $fetch = mysqli_fetch_assoc($select);
   
}    


//connect with mongodb db 
require_once __DIR__ . '/vendor/autoload.php';
$con= new MongoDB\Client("mongodb://localhost:27017");

$db=$con->profile; 

$tb=$db->userprofile;

$em=$fetch['email'];


//update on mongodb


//========================================================================

if(isset($_POST['update_profile'])){
   echo "hello";
   $update_name =  $_POST['update_name'];
   $update_email =  $_POST['update_email'];

   mysqli_query($conn, "UPDATE `regist` SET name = '$update_name', email = '$update_email' WHERE id = '$user_id'") or die('query failed1 ');

   $old_pass = $fetch['password'];
   
   $confirm_pass = mysqli_real_escape_string($conn, ($_POST['confirm_pass']));

   if(!empty($confirm_pass)){
      if($confirm_pass!= $old_pass){
         echo "hellllo";
         $message[] = 'old password not matched!';
      }else{
         $tb->updateOne(
            ['email'=> $em],
            [ '$set' => [ 'name' =>  $update_name, 'email' => $update_email ]],
         );         
         $message[] = 'password updated successfully!';
      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>update profile</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="/guvi2/css/style.css">

</head>
<body>
   
<div class="update-profile">

 

   <form action="" method="post" enctype="multipart/form-data">
      <?php
        
         if(isset($message)){
            foreach($message as $message){
               echo '<div class="message">'.$message.'</div>';
            }
         }
      ?>
      <div class="flex">
         <div class="inputBox">
            <span>username :</span>
            <input type="text" name="update_name" value="<?php echo $fetch['name']; ?>" class="box">
            <span>your email :</span>
            <input type="email" name="update_email" value="<?php echo $fetch['email']; ?>" class="box">
            
         </div>
         <div class="inputBox">
            <span> password :</span>
            <input type="password" name="confirm_pass" placeholder="confirm new password" class="box">
         </div>
      </div>
      <input type="submit" value="update profile" name="update_profile" class="btn">
      <a href="profile.php" class="delete-btn">go back</a>
   </form>

</div>

</body>
</html>