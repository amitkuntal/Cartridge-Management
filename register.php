<?php 
session_start();
if(!isset($_SESSION["sess_user"])){
	header("location:index.php");
} 
else {
?><!doctype html>
<html>
<head>
<title>Register</title>
</head>
<body>
<?php
	include_once("config.php");
	$emp_no=$_SESSION['sess_user'];
	$query=mysql_query("SELECT * FROM login,emp_role WHERE login.emp_no='".$emp_no."' and emp_role.emp_no='".$emp_no."'");
	$numrows=mysql_num_rows($query);
	if($numrows!=0)
	{
	while($row=mysql_fetch_assoc($query))
	{
	$username=$row['emp_name'];
	$role=$row['role'];
	
	}
	}
?>
<body><div align="center"><h2>Welcome, <?php echo $username;?> <a href="logout.php">Logout</a></h2>
<h3>Registration Form</h3>
<form action="" method="POST">
Emp No: <input type="text" name="empno"><br />
Dept: <input type="text" name="dept"><br />
Desig: <input type="text" name="empno"><br />
Emp Name: <input type="text" name="empno"><br />
Password: <input type="password" name="pass"><br />	
Emp type: <input type="radio" name="utype" value="A">Admin	
		<input type="radio" name="utype" value="N" checked>Normal User<br />
<input type="submit" value="Register" name="submit" />
</form>
<?php
if(isset($_POST["submit"])){

if(!empty($_POST['user']) && !empty($_POST['pass'])) {
	$user=$_POST['user'];
	$pass=$_POST['pass'];

	$con=mysql_connect('localhost','root','') or die(mysql_error());
	mysql_select_db('user_registration') or die("cannot select DB");

	$query=mysql_query("SELECT * FROM login WHERE username='".$user."'");
	$numrows=mysql_num_rows($query);
	if($numrows==0)
	{
	$sql="INSERT INTO login(username,password) VALUES('$user','$pass')";

	$result=mysql_query($sql);


	if($result){
	echo "Account Successfully Created";
	} else {
	echo "Failure!";
	}

	} else {
	echo "That username already exists! Please try again with another.";
	}

} else {
	echo "All fields are required!";
}
}
}
?>

</body>
</html>