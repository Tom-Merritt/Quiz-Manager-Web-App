<?php 
session_start();

if(isset($_SESSION['userID'])){
	require 'config.php';
}else{
	header("Location: index.php");
}

?>
<header>
<div class="container">
    <div class="row">
		<div class="col-6">
			<h3>Quiz Manager</h3>
		</div>
		<div class="col-6 text-right">
			<p><?php echo "User Name: ".$_SESSION['userName'];?></p>
			<p>Permission Level: <b><?php echo $_SESSION['permissions'];?></b></p>
			<form action="logout.php" method="post"><button type="submit" name="logout">Logout</button></form>
		</div>
	</div>
</div>
</header>