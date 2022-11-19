<?php 
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$phno = $_POST['phno'];
$email = $_POST['email'];
$pass1 = $_POST['pass1']; 
$conn = mysqli_connect('localhost','root','','guvi2');
if($conn->connect_error){
    die("Connection failure:". $conn->connect_error);
}
$select = "select * from regist where email='$email'";
$result = mysqli_query($conn, $select);
$count = mysqli_num_rows($result);

if($count<1){

//insert in mysql
    $insert = "INSERT INTO regist(name, email, password,phno) 
    VALUES('$firstName', '$email', '$pass1','$phno')";
    mysqli_query($conn, $insert);

    
    echo 1;
//insert in mongodb
    require_once __DIR__ . '/vendor/autoload.php';
$con= new MongoDB\Client("mongodb://localhost:27017");

$db=$con->profile;

$tb=$db->userprofile;
$insertOne=$tb->insertOne(["phno"=>$phno,"name"=>$firstName,"email"=>$email]);
    exit;
}
else{
  echo 2;
  exit;
}
?>