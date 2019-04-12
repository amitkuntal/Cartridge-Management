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
					$txn=$_POST['txn'];
					$query=mysql_query("SELECT * FROM txntable,login,asset WHERE txntable.txn_id='".$txn."' and login.emp_no='".$emp_no."' and 
					asset.asset_id=txntable.asset_id;");
					$numrows=mysql_num_rows($query);
					if($numrows!=0)
					{
					while($row=mysql_fetch_assoc($query))
					{
						$txn=$row['txn_id'];
						$asset_id= $row['asset_id'];;
						$emp_no=$row['emp_no'];
						$emp_name=$row['emp_name'];
						$dept=$row['dept'];
						$asset_cat_id=$row['asset_cat_id'];
						$qty=$row['qty'];
						$tdate=$row['tdate'];
						$cartridge_id=$row['cartridge_id'];
					}
					}
						
						
						echo "<p>Transaction ID:-".$txn."</p>
								<p>Printer No.:- ".$asset_id."</p>
								<p>Emp No.:-".$emp_no."</p>
								<p>Emp Name.:-".$emp_name."</p>
								<p>Department.:- ".$dept."</p>
								<p>Printer Model.:- ".$asset_cat_id."</p>
								<p>Cartridge.:- ".$cartridge_id."</p>
								<p>Qty.:- ".$qty."</p>
								";
								echo "<input type='button' name='print' value='Print' onclick='window.print()'>";
								
	
						
				 
	?>
</div>
<?php
}
 ?>
</body>
</html>
