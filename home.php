<!DOCTYPE html>
<?php session_start(); 
include("inc/db.php");

	if(isset($_SESSION['id'])){
		
		$strSQL = "SELECT * FROM user WHERE id = '".$_SESSION['id']."' ";
		$objQuery = mysqli_query( $conn, $strSQL );
		$objResult = mysqli_fetch_array( $objQuery );
		if ( $objResult ) {
		$usn = $objResult[ "username" ];
		// $status = $objResult[ "status" ];
		// $active = $objResult[ "active" ];
			$_SESSION['status'] = $objResult[ "status" ];
			$_SESSION['active'] = $objResult[ "active" ];
			
		} 
	}


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
	<script src="inc/moment.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Krub|Mali" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">
	<link href="inc/style.css" rel="stylesheet">
	<script src="inc/ckeditor/ckeditor.js"></script>
	<style>
		body {
			font-family: 'Mali', cursive;
			font-family: 'Krub', sans-serif;
		}
	</style>
	<script>
		$( document ).ready( function () {
			$( '#committee_id' ).on( 'change', function () {
				var committee_id = $( this ).val();
				if ( committee_id ) {
					$.ajax( {
						type: 'POST',
						url: 'data.php',
						data: 'committee_id=' + committee_id,
						success: function ( html ) {
							$( '#subcommittee_id' ).html( html );
						}
					} );
				}
			} );


		} );
	</script>
</head>

<body class="bg-dark">

	<?php 
	
	if(isset($usn)){
		include("inc/header2.php");
		
	if(isset($_GET["menu"]) && isset($_GET["sub"])){
		$menu = $_GET['menu'];
		$submenu = $_GET['sub'];
		$page = "menu/". $menu . "/" . $submenu . ".php";
		include_once($page);
	}	
	elseif(isset($_GET["menu"]) && !isset($_GET["sub"])){
		$menu = $_GET['menu'];
		$page = "menu/". $menu . "/" . $menu . ".php";
		include_once($page);
	}
	elseif(!isset($_GET["menu"]) && !isset($_GET["sub"])){
		$page = "home.php";
		include_once($page);
	}
		
	}
	elseif(!isset($usn)){
		include("inc/header1.php");
	}
	echo "<br>";

	

	?>




</body>

</html>