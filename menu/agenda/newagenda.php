<!doctype html>
<?php  
session_start();
		include("../../inc/db.php");
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
//var_dump($_POST);
if ( $_SERVER[ "REQUEST_METHOD" ] == "POST" ) {

		$sql = "SELECT MAX(agenda_id) AS agenda_id FROM agenda";
		$result = mysqli_query( $conn, $sql );
		if ( $result->num_rows > 0 ) {
			// output data of each row
			if ( $row = $result->fetch_assoc() ) {
				$agenda_id = $row[ "agenda_id" ] + 1;
			}
		} else {
			$agenda_id = 1;
		}
		$agenda_topic = $_POST['topic'];		
		$project_no = $_POST['project_no'];		
		$committee_id = $_POST['committee_id'];		
		$subcommittee_id = $_POST['subcommittee_id'];		
		$meeting_day = $_POST['meeting_day'];
	

		$sql = "INSERT agenda (agenda_id, agenda_topic, project_no, committee_id, subcommittee_id, meeting_day, start_time, end_time) 
		VALUES ($agenda_id,$agenda_topic,$project_no,$committee_id,$subcommittee_id,$meeting_day,now(),now())";

		echo $sql;
	mysqli_close( $conn );
}
?>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Krub|Mali" rel="stylesheet">
	<style>
		body {
			font-family: 'Mali', cursive;
			font-family: 'Krub', sans-serif;
		}
	</style>



	<title>ME</title>
</head>

<body>
<?php include("../../inc/header2.php"); ?>
	<div class="wrapper">
		<div class="container bg-dark">
			<div class="row">
				<div class="col-md-12">
					<div class="page-header clearfix">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="home.php">หน้าแรก</a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">เพิ่มการประชุม</li>
							</ol>
						</nav>


					</div>
					<h2></h2>
					<form action="" method="post">
						<div class="form-row">
							<div class="form-group col-md-9">
								<label for="topic">หัวข้อการประชุม</label>
								<input type="text" class="form-control" name="topic">
							</div>
							<div class="form-group col-md-3">
								<label for="project_no">รหัสโครงการ</label>
								<input type="text" class="form-control" name="project_no">
							</div>
						</div>

						<div class="form-row">
							<div class="form-group col-md-4">							
								<?php
							$query = $conn->query( "SELECT * FROM committee " );
							$rowCount = $query->num_rows;
							?>

								<label for="committee_id">คณะกรรมการ</label>
								<select id="committee_id" name="committee_id" class="form-control">
									<option value="">เลือกชุดกรรมการ</option>
									<?php
									if ( $rowCount > 0 ) {
										while ( $row = $query->fetch_assoc() ) {
											echo '<option value="' . $row[ 'committee_id' ] . '">' . $row[ 'committee_name' ] . '</option>';
										}
									} else {
										echo '<option value="">ไม่พบข้อมูลกรรมการ</option>';
									}
									?>



								</select>
							</div>
							<div class="form-group col-md-8">
								<label for="subcommittee_id">อนุกรรมการ/คณะทำงาน</label>
								<select id="subcommittee_id" name="subcommittee_id" class="form-control">
									<option value="">เลือกชุดกรรมการก่อน</option>
								</select>
							</div>

						</div>



						<div>
							<label for="meeting_day">วันที่</label>
							<input type="date" name="meeting_day" id="meeting_day">
							<label for="t1">เวลา</label>
							<select name="t11">
								<?php
								foreach ( range( '0', '23' ) as $num ) {
									?>
								<option value="<?php echo sprintf(" %02d ",$num); ?>">
									<?php echo sprintf("%02d",$num)?>
								</option>
								<?php } ?>
							</select>
							<select name="t12">
								<?php
								foreach ( range( '0', '59' ) as $num ) {
									?>
								<option value="<?php echo sprintf(" %02d ",$num); ?>">
									<?php echo sprintf("%02d",$num)?>
								</option>
								<?php } ?>
							</select>

							<label for="t21"> ถึง </label>
							<select name="t21">
								<?php
								foreach ( range( '0', '23' ) as $num ) {
									?>
								<option value="<?php echo sprintf(" %02d ",$num); ?>">
									<?php echo sprintf("%02d",$num)?>
								</option>
								<?php } ?>
							</select>
							<select name="t22">
								<?php
								foreach ( range( '0', '59' ) as $num ) {
									?>
								<option value="<?php echo sprintf(" %02d ",$num); ?>">
									<?php echo sprintf("%02d",$num)?>
								</option>
								<?php } ?>
							</select>
						</div>


						<br>
						<button type="submit" class="btn btn-primary">บันทึก</button>
					</form>
				</div>
			</div>
		</div>
	</div>




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



</body>

</html>