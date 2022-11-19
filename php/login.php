<?php 

session_start();



include("connection.php");
	include("functions.php");


	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		//something was posted
		$name = $_POST['user_name'];
		$password = $_POST['password'];

		if(!empty($name) && !empty($password) && !is_numeric($name))
		{

			//read from database
			$query = "select * from regist where name = '$name' limit 1";
			$result = mysqli_query($con, $query);

			if($result)
			{
				if($result && mysqli_num_rows($result) > 0)
				{

					$user_data = mysqli_fetch_assoc($result);
					
					if($user_data['password'] === $password)
					{

						$_SESSION['id'] = $user_data['id'];
						header("Location: profile.php");
						die;
					}
				}
			}
			
			echo "wrong username or password!";
		}else
		{
			echo "wrong username or password!";
		}
	}

?>
