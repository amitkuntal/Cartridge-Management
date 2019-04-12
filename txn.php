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
						
						//$date=$emp_no.'/'.date('Y/m/d').'/'.date('h').date('i').date('s');
						$date=$emp_no.date('Y').date('m').date('d').date('h').date('i').date('s');
						//echo $date;
						$asset_id= $_POST['asset_id'];
						$emp_no=$_POST['emp_no'];
						$emp_name=$_POST['emp_name'];
						$dept=$_POST['dept'];
						$asset_cat_id=$_POST['asset_cat_id'];
						$qty=1;
						$tdate=date('y-m-d');
						echo $tdate;
						$cartridge_id=$_POST['cartridge_id'];
						echo "<p>Transaction ID:-".$date."</p>
								<p>Printer No.:- ".$asset_id."</p>
								<p>Emp No.:-".$emp_no."</p>
								<p>Emp Name:- ".$emp_name."</p>
								<p>Department.:- ".$dept."</p>
								<p>Printer Model.:- ".$asset_cat_id."</p>
								<p>Cartridge.:- ".$cartridge_id."</p>
								<p>Qty.:- ".$qty."</p>
								";
						echo "<input type='button' name='print' value='Print' onclick='window.print()'>";
	
						$sql="INSERT INTO `txntable`(`emp_no`, `cartridge_id`, `qty`, `tdate`, `issued`, `qty_issued`, `last_issue`, `txn_id`,`asset_id`)
								VALUES (".$emp_no.",'".$cartridge_id."',".$qty.",'".$tdate."','NO','0','0000-00-00',".$date.",'".$asset_id."')";
								//echo $sql;
						$result=mysql_query($sql);	
						if($result){
						echo "<script>alert('Transaction Completed')</script>";
						}
						else
						{
						echo "Failure!";
						}

				 
	?>
</div>
<?php
}
 ?>
</body>
</html>
