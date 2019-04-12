<?php 
session_start();
if(!isset($_SESSION["sess_user"])){
	header("location:index.php");
} else {
?>
<html>
<head>
<title>Welcome to Cartridge Management System</title>
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
<body>
<div align="center"><h2>Welcome, <?php echo $username;?> <a href="logout.php">Logout</a></h2>
			<?php
						
						$asset_cat_id=$_POST['asset_cat_id'];
						$cartridge_id=$_POST['cartridge_id'];
						$qty=$_POST['qty'];
						$qty1=$_POST['qty1'];
						$dt=date('Y-m-d');
						if($qty != '0')
						{
						$sql="INSERT INTO `history`(`asset_cat_id`, `cartridge_id`, `qty`, `date`) 
						VALUES ('".$asset_cat_id."','".$cartridge_id."','".$qty."','".$dt."')";
						echo "<br>";
						echo $sql;
						
						$result=mysql_query($sql);	
						if($result){
						//echo "<script>alert('Transaction Completed')</script>";
						}
						else
						{
						echo "Failure!";
						}
						$qty+=$qty1;
						$sql="UPDATE `stock_table` SET `qty`='".$qty."' WHERE asset_cat_id='".$asset_cat_id."' and cartridge_id='".$cartridge_id."'";
								
						echo $sql;
						
						$result=mysql_query($sql);	
						if($result){
						echo "<script>alert('Stock Successfully updated')</script>";
						header("Location: home.php");
						}
						else
						{
						echo "Failure!";
						}
						}
						else
						{
						$sql="INSERT INTO `stock_table`(`asset_cat_id`, `cartridge_id`, `qty`) VALUES ('".$asset_cat_id."','".$cartridge_id."','".$qty1."')";
								
						echo $sql;
						
						$result=mysql_query($sql);	
						if($result){
						echo "<script>alert('Stock Successfully updated')</script>";
						header("Location: home.php");
						}
						else
						{
						echo "Failure!";
						}

						}

				 
	?>
</div>
<?php
}
 ?>
</body>
</html>


