<!DOCTYPE html>
<?php 
	session_start();
	var_dump($_SESSION);
?>
<html lang="en">

<head>
	<title>me</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Krub|Mali" rel="stylesheet">
	<style>
		body {
			font-family: 'Mali', cursive;
			font-family: 'Krub', sans-serif;
		}
	</style>
</head>

<body>
	<?php include("db.php");
			  include("header.php");
	?>


</body>

</html>