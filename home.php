<?php 
session_start();
if(!isset($_SESSION["sess_user"])){
	header("location:index.php");
} else {
?>
<html>
<head>
<title>Welcome to Cartridge Management System</title>
<link href="assets/css/bootstrap.css" rel="stylesheet" />
		<link href="assets/css/bootstrap-theme.css" rel="stylesheet" />
</head>
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
<body class='bg-secondary'>
	<div class="container mt-3 bg-secondary">
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
					<img class="mb-4" src='assets/img/iocl.png' width='100' height='60'>
					<a class="navbar-brand text-white ml-5">Welcome <?php echo ucwords($username);?></a>
					<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
					</ul>
					<form class="form-inline my-2 my-lg-0">
							<button class='btn btn-outline-danger'>
							<a class='text-white' href="logout.php">Logout</a>
						</button>
					</form>
		</nav>
<!-- Identify the user Admin of Normal user than display the controls-->
<?php
	if ($role=='A')
	{	//echo $role;
		//echo "Admin Control  Goes Here";
		$query=mysql_query("SELECT * FROM asset WHERE emp_no='".$emp_no."'");
		$numrows=mysql_num_rows($query);
		if($numrows!=0)
		{
			echo "<div class='row'><div class='col-6'>
					<form method='post' action='#'>
					<div class='form-group row'>Select Asset No.<select name='cat_id'>";
		while($row=mysql_fetch_assoc($query))
		{
		echo "<option  value='{$row['asset_cat_id']}'>{$row['asset_id']}
				</option>";
		}
		echo "	</select><br><br>
						<input type='submit' value='Issue' name='issue'>
						<input type='submit' value='Addstock' name='selectstock'>
						<input type='submit' value='Request' name='request'>
						<input type='submit' value='View Stock' name='stock'>
						<input type='submit' value='Print Transaction' name='print'>
						</form>";
		}
	}
	else 
	{
		$query=mysql_query("SELECT * FROM asset WHERE emp_no='".$emp_no."'");
		$numrows=mysql_num_rows($query);
		if($numrows!=0)
		{
			echo "<form method='post' action='#'>Select Asset No.<select name='cat_id'>";
		while($row=mysql_fetch_assoc($query))
		{
		echo "<option  value='{$row['asset_cat_id']}'>{$row['asset_id']}
				</option>";
		}
		echo "	</select><br><br><input type='submit' value='Request' name='request'>
						<input type='submit' value='View Stock' name='stock'>
						<input type='submit' value='Print Transaction' name='print'>
						</form>";
		}
		}

?>
<!-- Cartridge Request approval -->

<?php
if(isset($_POST["issue"])){

	$query=mysql_query("SELECT * FROM txntable where issued='NO'");
	$numrows=mysql_num_rows($query);
	if($numrows!=0)
	{
		echo "<table border='4'><tr><th>Transaction Id</th>
				<th>Emp No</th>
				<th>Cartridge Id</th>
				<th>Transaction Date</th>
				<th colspan='2'>Asset ID</th>
				</tr>";
	while($row=mysql_fetch_assoc($query))
	{
		echo "<tr><form method='post'>";
		echo "<td><input type='text' name='txn_id' value='{$row['txn_id']}'></td>
				<td><input type='text' name='emp_no' value='{$row['emp_no']}'></td>
				<td><input type='text' name='cartridge_id' value='{$row['cartridge_id']}'></td>
				<td><input type='text' name='t_date' value='{$row['tdate']}'></td>
				<td><input type='text' name='asset_id' value='{$row['asset_id']}'></td>";
		echo "<td><input type='submit' value='Approve' name='approve'></td></form></tr>";
				
	}
		echo "</table>";
	}
	else
	{
		echo "NO Pending Request found";
	}
	
}
?>

<?php
						
						if(isset($_POST["approve"])){
							$da=date('Y-m-d');
						$txn_id=$_POST['txn_id'];
						$sql="UPDATE `txntable` SET `issued`='YES',`qty_issued`='1',`last_issue`='".$da."' WHERE txn_id='".$txn_id."'";
						echo "<br>";
						
						$result=mysql_query($sql);	
						if($result){
						echo "<script>alert('Transaction Completed')</script>";
						}
						else
						{
						echo "Failure!";
						}
						}
?>


<!-- Cartridge Request approval end here -->


<!--Add Stock admin control -->


<?php
if(isset($_POST["selectstock"])){

	$query=mysql_query("SELECT distinct(asset_cat_id) FROM cartridge ");
	$numrows=mysql_num_rows($query);
	if($numrows!=0)
	{
		echo "<form method='post'><select name='asset_cat_id'>";
	while($row=mysql_fetch_assoc($query))
	{
	echo "<option value='{$row['asset_cat_id']}'>{$row['asset_cat_id']}</option>";
				
	}
		echo "</select><input type='submit' value='go' name='cartridge'></form>";
	}
	else
	{
		echo "NO record found";
	}
	
}
?>
<?php
if(isset($_POST["cartridge"])){
	$asset_cat_id=$_POST['asset_cat_id'];
	//echo "SELECT cartridge_id FROM cartridge where asset_cat_id = '".$asset_cat_id."'";
	$query=mysql_query("SELECT cartridge_id FROM cartridge where asset_cat_id = '".$asset_cat_id."'");
	$numrows=mysql_num_rows($query);
	if($numrows!=0)
	{
		echo "<form method='post'><input type='text' name='asset_cat_id' value=".$asset_cat_id."><select name='cartridge_id'>";
	while($row=mysql_fetch_assoc($query))
	{
	echo "<option value='{$row['cartridge_id']}'>{$row['cartridge_id']}</option>";
				
	}
		echo "</select><input type='submit' value='go' name='addstock'></form>";
	}
	else
	{
		echo "NO record found";
	}
	
}
?>

<?php
if(isset($_POST["addstock"])){
	$asset_cat_id = $_POST['asset_cat_id'];
	$cartridge_id = $_POST['cartridge_id'];
	$query=mysql_query("SELECT * FROM stock_table where asset_cat_id = '".$asset_cat_id."' and cartridge_id='".$cartridge_id."'");
	$numrows=mysql_num_rows($query);
	echo "<form method='post' action='addstock.php'><input type='text' name='asset_cat_id' value=".$asset_cat_id."><br>
		<input type='text' name='cartridge_id' value='".$cartridge_id."'><br>";
	if($numrows!=0)
	{
	while($row=mysql_fetch_assoc($query))
	{
	echo "<input type='text' name='qty' value='{$row['qty']}'><br>";
				
	}
		
	}
	else
	{
		echo "<input type='text' name='qty' value='0'><br>";
	}
	echo "<input type='text' name='qty1' required=''><br><input type='submit' name='submit' value='Update Stock'></form>";
	
}
?>

<!-- -->

<!-- Used for the generate the requests  -->
<?php
if(isset($_POST["request"])){

if(!empty($_POST['cat_id'])) {
	$cat_id=$_POST['cat_id'];

	$query=mysql_query("SELECT * FROM login,asset WHERE login.emp_no='".$emp_no."' and asset.asset_cat_id='".$cat_id."'" );
	$numrows=mysql_num_rows($query);
	if($numrows!=0)
	{
	while($row=mysql_fetch_assoc($query))
	{
	echo "<form action='txn.php' method='post'><p>Printer No.:- <input type='text' name='asset_id' value='{$row['asset_id']}'></p>
			<p>Emp No.:-<input type='text' name='emp_no' value='{$row['emp_no']}'>	</p>
			<p>Emp Name:- <input type='text' name='emp_name' value='{$row['emp_name']}'></p>
			<p>Department.:- <input type='text' name='dept' value='{$row['dept']}'></p>
			<p>Printer Model.:- <input type='text' name='asset_cat_id' value='{$row['asset_cat_id']}'></p>
			";
				$query=mysql_query("SELECT * FROM cartridge WHERE asset_cat_id='".$cat_id."'" );
				$numrows=mysql_num_rows($query);
				if($numrows!=0)
				{
					echo "Cartridge:-<select name='cartridge_id'>";
				while($row=mysql_fetch_assoc($query))
				{
				echo "<option value='{$row['cartridge_id']}'>{$row['cartridge_id']}</option>";
						
				}
				echo "</select>
				<input type='submit' value='submit' name='submit'>
				</form>
				";
				}
	}
	}
	else
	{
		echo "NO record found";
	}
	

	//echo $cat_id;
	//echo $emp_no;
	}

 else {
	echo "All fields are required!";
}
}
?>
<!-- Used for display the stocks -->
<?php
if(isset($_POST["stock"])){

if(!empty($_POST['cat_id'])) {
	$cat_id=$_POST['cat_id'];

	$query=mysql_query("SELECT * FROM asset JOIN stock_table ON asset.asset_cat_id = stock_table.asset_cat_id WHERE asset.emp_no ='".$emp_no."' ");
	$numrows=mysql_num_rows($query);
	if($numrows!=0)
	{
		echo "<table border='5'><th>Asset Id</th><th>Asset Cat Id</th><th>Cartridge Id</th><th> Qty </th>";
	while($row=mysql_fetch_assoc($query))
	{
	echo "<tr><td>{$row['asset_id']}</td><td>{$row['asset_cat_id']}</td><td>{$row['cartridge_id']}</td><td>{$row['qty']}</td></tr>";
				
	}
	}
	else
	{
		echo "NO record found";
	}
	

	//echo $cat_id;
	//echo $emp_no;
	}

 else {
	echo "All fields are required!";
}
}
?>
<?php
if(isset($_POST["print"])){
	
	$query=mysql_query("SELECT * FROM txntable WHERE emp_no='".$emp_no."'");
		$numrows=mysql_num_rows($query);
		if($numrows!=0)
		{
			echo "<form method='post' action='printtxn.php'>Select Transaction ID.<select name='txn'>";
		while($row=mysql_fetch_assoc($query))
		{
		echo "<option  value='{$row['txn_id']}'>{$row['txn_id']}
				</option>";
		}
		echo "</select>
		<input type='submit' name='Print' value='submit'></form>";
		}
	
}
?>

</div>
<script src="js/bootstrap.min.js"></script>
<?php
}
 ?>
</body>
</html>
