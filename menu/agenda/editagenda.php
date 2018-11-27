<?php

if ( isset( $_GET[ "ag" ] ) && !empty( trim( $_GET[ "ag" ] ) ) ) {

	// Prepare a select statement
	$sql = "SELECT agenda.agenda_id, agenda.agenda_subject,  DATE_FORMAT(meeting_day,'%d/%m/%Y') as md,TIME_FORMAT(start_time, '%H:%i') as st,	meeting_day,
TIME_FORMAT(end_time, '%H:%i') as et, round, agenda.committee_id, agenda.subcommittee_id, committee.committee_name, subcommittee.subcommittee_name
	FROM agenda 
	left join committee on committee.committee_id = agenda.committee_id    
    left join subcommittee on subcommittee.subcommittee_id = agenda.subcommittee_id
	WHERE agenda_id = " . $_GET[ 'ag' ];

	if ( $result = mysqli_query( $conn, $sql ) ) {
		if ( mysqli_num_rows( $result ) == 1 ) {
			/* Fetch result row as an associative array. Since the result set
			contains only one row, we don't need to use while loop */
			$row = mysqli_fetch_array( $result, MYSQLI_ASSOC );

			// Retrieve individual field value
			$agenda_id = $row[ "agenda_id" ];
			$agenda_subject = $row[ "agenda_subject" ];
			$md = $row[ "md" ];
			$st = $row[ "st" ];
			$et = $row[ "et" ];
			$round = $row[ "round" ];
			$committee_id = $row[ "committee_id" ];
			$committee_name = $row[ "committee_name" ];
			$subcommittee_id = $row[ "subcommittee_id" ];
			$subcommittee_name = $row[ "subcommittee_name" ];
			$meeting_day = $row[ "meeting_day" ];
			$expst = explode( ":", $st );
			$expet = explode( ":", $et );


		} else {
			// URL doesn't contain valid id parameter. Redirect to error page
			header( "location: error.php" );
			exit();
		}

	} else {
		echo "Oops! Something went wrong. Please try again later.";
	}
}

if ( isset( $_POST[ "agenda_id" ] ) && !empty( trim( $_POST[ "agenda_id" ] ) ) && isset( $_POST[ "subject" ] ) && !empty( trim( $_POST[ "subject" ] ) ) ) {

	$subject = $_POST[ "subject" ];
	$agenda_id = $_POST[ "agenda_id" ];
	$round = $_POST[ "round" ];	
	$committee_id = $_POST[ "committee_id" ];	
	$subcommittee_id = $_POST[ "subcommittee_id" ];	
	$meeting_day = $_POST[ "meeting_day" ];
	
	$st1 = trim( $_POST[ "t11" ] . ":" . $_POST[ "t12" ] . ":00" );
	$st2 = str_replace( ' ', '', $st1 );
	$et1 = $_POST[ "t21" ] . ":" . $_POST[ "t22" ] . ":00";
	$et2 = str_replace( ' ', '', $et1 );

	$start_time = $meeting_day . " " . $st2;
	$end_time = $meeting_day . " " . $et2;

	
	// Prepare a select statement
	$sql = "UPDATE agenda SET agenda_subject= '$agenda_subject', round = '$round', committee_id = $committee_id, subcommittee_id = $subcommittee_id, meeting_day = '$meeting_day', start_time = '$start_time', end_time = '$end_time'
	WHERE agenda_id =  $agenda_id";
	
	if ( mysqli_query( $conn, $sql ) ) {
		echo "แก้ไขข้อมูลแล้ว";
		echo "<script>setTimeout(function() {  window.location.href = 'home.php?menu=agenda&ag=$agenda_id';}, 1000);</script>";

	} else {
		echo "Error updating record: " . mysqli_error( $conn );
	}
	mysqli_close( $conn );

}
?>
<div class="wrapper">
	<div class="container bg-dark">
		<div class="row">
			<div class="col-md-12">
				<div class="page-header clearfix">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="home.php">หน้าแรก</a>
							</li>
							<li class="breadcrumb-item " aria-current="page"><a href="home.php?menu=agenda">งานประชุม</a>
							</li>
							<li class="breadcrumb-item active" aria-current="page">
								<a href="home.php?menu=agenda&sub=read&ag=<?php echo $agenda_id;?>">
									<?php echo $agenda_subject . " วันที่ " . $md. " เวลา " . $st . "-" . $et ; ?>
								</a>
							</li>

						</ol>
					</nav>


				</div>
				<h2></h2>
				<form action="" method="post">
					<div class="form-row">
						<div class="form-group col-md-9">
							<label for="inputEmail4">หัวข้อการประชุม</label>
							<input type="text" class="form-control" name="subject" value="<?php echo $agenda_subject;?>">
							<input type="hidden" name="agenda_id" value="<?php echo $agenda_id;?>">
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md">
							<label for="round">ครั้งที่</label>
							<input type="text" name="round" value="<?php echo $round; ?>">

						</div>
					</div>


					<div class="form-row">
						<div class="form-group col-md-4">
							<label for="committee_id">กรรมการ / จรรยาบรรณ</label>
							<select id="committee_id" name="committee_id" class="form-control">
								<?php
								$default_committee = '1 ';
								$default_val = '1 ';
								$sql = "SELECT * FROM committee";
								if ( $result = mysqli_query( $conn, $sql ) ) {
									if ( mysqli_num_rows( $result ) > 0 ) {
										while ( $row = mysqli_fetch_array( $result ) ) {
											$cid = $row["committee_id"];
											$cname = $row["committee_name"];
											?>
								<option value="<?php echo $cid; ?>" <?php if( $cid == $committee_id ) echo "selected";?>><?php echo $cname; ?>
								</option>
								<?php
								}
								}
								}
								?>
							</select>
						</div>

					</div>


					<div class="form-row">
						<div class="form-group col-md-8">
							<label for="subcommittee_id">อนุกรรมการ / คณะทำงาน</label>
							<select id="subcommittee_id" name="subcommittee_id" class="form-control">
								<?php

								$sql = "SELECT * FROM subcommittee";
								if ( $result = mysqli_query( $conn, $sql ) ) {
									if ( mysqli_num_rows( $result ) > 0 ) {
										while ( $row = mysqli_fetch_array( $result ) ) {
											$scid = $row["subcommittee_id"];
											$scname = $row["subcommittee_name"];
											?>
								<option value="<?php echo $scid; ?>" <?php if($scid==$subcommittee_id ) echo "selected";?>>
									<?php echo $scname; ?>
								</option>
								<?php
								}
								}
								}
								?>
							</select>
						</div>
					</div>


					<div>
						<label for="meeting_day">วันที่</label>
						<input type="date" name="meeting_day" id="meeting_day" value="<?php echo strftime('%Y-%m-%d', strtotime($meeting_day)); ?>" name="date"/>


						<label for="t1">เวลา</label>
						<select name="t11">
							<option value="<?php echo $expst[0];?>"><?php echo $expst[0];?></option>
							<?php
							foreach ( range( '0', '23' ) as $num ) {
								?>
							<option value="<?php echo sprintf(" %02d ",$num); ?>">
								<?php echo sprintf("%02d",$num)?>
							</option>
							<?php } ?>
						</select>
						<select name="t12">
							<option value="<?php echo $expst[1];?>"><?php echo $expst[1];?></option>
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
							<option value="<?php echo $expet[0];?>"><?php echo $expet[0];?></option>
							<?php
							foreach ( range( '0', '23' ) as $num ) {
								?>
							<option value="<?php echo sprintf(" %02d ",$num); ?>">
								<?php echo sprintf("%02d",$num)?>
							</option>
							<?php } ?>
						</select>
						<select name="t22">
							<option value="<?php echo $expet[1];?>"><?php echo $expet[1];?></option>
							<?php
							foreach ( range( '0', '59' ) as $num ) {
								?>
							<option value="<?php echo sprintf(" %02d ",$num); ?>">
								<?php echo sprintf("%02d",$num)?>
							</option>
							<?php } ?>
						</select>
					</div>






					<button type="submit" class="btn btn-success">บันทึก</button>
				</form>
			</div>
		</div>
	</div>
</div>