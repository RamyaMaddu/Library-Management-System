<?php
	include "navbar.php";
	include "connection.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title>Edit Profile</title>
	<style type="text/css">
		.form-control
		{
			width: 300px;
			height: 38px;
		}
		form
		{
			padding-left: 630px
		}
		label
		{
			color: white;
		}
	</style>
</head>
<body style="background-color: #004528;">
	<h2 style="text-align: center; color: white;">Edit Information</h2>
	<?php
		$sql="SELECT * FROM student Where username='$_SESSION[login_user]'";
		$result= mysqli_query($db,$sql) or die (mysql_error());
		while($row=mysqli_fetch_assoc($result))
		{
			$first=$row['first'];
			$last=$row['last'];
			$username=$row['username'];
			$password=$row['password'];
			$roll=$row['roll'];
			$email=$row['email'];
			$contact=$row['contact'];
		}
	?>
	<div class="profile_info" style="text-align: center;">
		<span style="color: white;">Welcome</span>
		<h4 style="color: white;"><?php echo $_SESSION['login_user'];?></h4>
	</div><br>
	<form action="" method="post" enctype="multipart/form-da">
		
		<label ><h4><b>First Name: </b></h4></label><br>
		<input class="form-control" type="text" name="first" value="<?php echo $first ; ?>">
		<label ><h4><b>Last Name: </b></h4></label><br>
		<input class="form-control" type="text" name="last" value="<?php echo $last ; ?>">
		<label ><h4><b>Username: </b></h4></label><br>
		<input class="form-control" type="text" name="username" value="<?php echo $username ; ?>">
		<label ><h4><b>Password: </b></h4></label><br>
		<input class="form-control" type="text" name="password" value="<?php echo $password ; ?>">
		<label ><h4><b>Roll: </b></h4></label><br>
		<input class="form-control" type="text" name="roll" value="<?php echo $roll ; ?>">
		<label ><h4><b>E-Mail: </b></h4></label><br>
		<input class="form-control" type="text" name="email" value="<?php echo $email ; ?>">
		<label ><h4><b>Contact: </b></h4></label><br>
		<input class="form-control" type="text" name="contact" value="<?php echo $contact ; ?>"><br>		
		
		<div style="padding-left: 120px;"><button class="btn btn-default" type="submit" name="submit">Save</button></div>
		<?php

			if(isset($_POST['submit']))
			{
				$first=$_POST['first'];
				$last=$_POST['last'];
				$username=$_POST['username'];
				$password=$_POST['password'];
				$roll=$_POST['roll'];
				$email=$_POST['email'];
				$contact=$_POST['contact'];

				$sql1= "UPDATE student SET first='$first',last='$last',username='$username', password='$password', email='$email',contact='$contact' WHERE username='".$_SESSION['login_user']."';";
				if(mysqli_query($db,$sql1))
				{
					?>
						<script type="text/javascript">
							alert("Saved Successfully")
						</script>
					<?php
				}
			}
		?>
	</form>
</body>
</html>