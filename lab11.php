<html>
	<head>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	</head>
	<body>
		<div  id="home">
			<div>
				<h2>Sign Up</h2>
				<form method="post" action="">
					First Name <input type = "text" name="fname"><br><br>
					Last Name <input type = "text" name="lname"><br><br>
					Email <input type = "email" name="email"><br><br>
					Password <input type = "password" name="pwd"><br><br>
					Select Category:<br>
					<input type="radio" name="category" value="student">Student<br>
					<input type="radio" name="category" value="teacher">Teacher<br><br>
					<input type = "submit" name = "signup" value = "Sign Up"><br><br>
				</form>
			</div>

			<div>
				<h2>Sign In</h2>
				<form method="post" action="">
					Email <input type = "email" name="email"><br><br>
					Password <input type = "password" name="pwd"><br><br>
					<input type = "submit" name = "signin" value = "Sign In"><br><br>
				</form>
			</div>
		</div>

<?php
	$conn = mysqli_connect("localhost", "root", "", "attendance recorder");

	$sql="CREATE TABLE IF NOT EXISTS attendance(
		classid int(50) NOT NULL,
		studentid int(50) NOT NULL,
		isPresent tinyint(1) NOT NULL,
		comments varchar(200) NOT NULL
	)";

	mysqli_query($conn, $sql);

	$sql="CREATE TABLE IF NOT EXISTS class (
	  id int(50) NOT NULL AUTO_INCREMENT,
	  teacherid int(50) NOT NULL,
	  starttime timestamp NOT NULL,
	  endtime timestamp NOT NULL,
	  credit_hours int(11) NOT NULL,
	  PRIMARY KEY (id)
	)";

	mysqli_query($conn, $sql);

	$sql="CREATE TABLE IF NOT EXISTS user (
	  id int(50) NOT NULL AUTO_INCREMENT,
	  fullname varchar(200) NOT NULL,
	  email varchar(200) NOT NULL,
	  password varchar(200) NOT NULL,
	  role enum('teacher','student') NOT NULL,
	  PRIMARY KEY (id)
	)";

	mysqli_query($conn, $sql);

	if(isset($_POST['signup']))
	{
		$fullname=$_POST['fname']." ".$_POST['lname'];
		$email=$_POST['email'];
		$pwd=$_POST['pwd'];
		$role=$_POST['category'];

		$sql="INSERT into user(fullname, email, password, role) values ('$fullname', '$email', '$pwd', '$role')";
		mysqli_query($conn, $sql);
	}

	if(isset($_POST['signin']))
	{
		$email=$_POST['email'];
		$pwd=$_POST['pwd'];
		$sql="SELECT * from user where email='$email' AND password='$pwd'";
		$result=mysqli_query($conn, $sql);

		if($val=mysqli_fetch_row($result))
		{
			if($val[4]=="teacher")
			{
				?>

				<script>
					$("#home").hide();
				</script>

				<?php

				$sql="SELECT * from class where teacherid='$val[0]'";
				$result=mysqli_query($conn, $sql);
				while($val1=mysqli_fetch_row($result))
					echo "<b> Session:</b> ".$val1[2]." <b>to</b> ".$val1[3]. " <button onclick=mark_attendance()> Edit </button>";

			}
		}

		else
			echo "Invalid username or password!";
	}
?>

<script>

	function mark_attendance()
	{
		
		//functionality for taking attendance. Could not be done due to lack of time
	}

</script>

</body>
</html>