<!doctype html>
<html>
	<head>
	
		<title>LOGIN PAGE</title>
		<link href="assets/css/bootstrap.css" rel="stylesheet" />
		<link href="assets/css/bootstrap-theme.css" rel="stylesheet" />
	</head>
	<body class='bg-secondary'>
	<div class='container mt-5'>
	<div class='row mt-5' align='center'>
	<div class='col mt-5'>
	<h3 class="text-white">Welcome to Cartridge Management System</h3>
	<div class='col-md-5 col-md-offset-4'>
	<form method="post" action="" class="form-signin">
		
				<img class="mb-4" src="assets/img/iocl.png" alt="" width="100" height="100">
				<h1 class="h3 mb-3 font-weight-normal text-white">Please sign in</h1>
				<input type="text" class="form-control" name="user" placeholder="Emp. No" required="" autofocus><br>
				<input type="password" class="form-control" name="pass" placeholder="Password" required=""><br>
				<input type="submit" class="btn btn-lg btn-primary btn-block" name="submit" Value='Login '>
	</form>
	</div>
	</div>
	</div>
	
            <?php include_once("config.php");
if(isset($_POST["submit"])){

if(!empty($_POST['user']) && !empty($_POST['pass'])) {
	$user=$_POST['user'];
	$pass=$_POST['pass'];
	$query=mysql_query("SELECT * FROM login WHERE emp_no='".$user."' AND password='".$pass."'");
	$numrows=mysql_num_rows($query);
	if($numrows!=0)
	{
	while($row=mysql_fetch_assoc($query))
	{
	$dbusername=$row['emp_no'];
	$dbpassword=$row['password'];
	}

	if($user == $dbusername && $pass == $dbpassword)
	{
	session_start();
	$_SESSION['sess_user']=$user;

	/* Redirect browser */
	header("Location: home.php");
	}
	} else {
	echo "<script>alert('Invalid username or password!')</script>";
	}

} else {
	echo "All fields are required!";
}
}
?>

</div>
<script src="js/bootstrap.min.js"></script>


	</body>
</html>