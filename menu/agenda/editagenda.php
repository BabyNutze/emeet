<script type="text/javascript">
	$( document ).ready( function () {
		var committee_id = $( '#committee' ).val();
		var subcommittee_id = $( '#subcm' ).val();
	console.log(committee_id);console.log(subcommittee_id);
		if ( subcommittee_id ) {
			$.ajax( {
				type: 'POST',
				url: 'menu/agenda/ajaxaddagenda.php',
				data : { 'committee_id': committee_id, 'subcommittee_id': subcommittee_id}
				,
				success: function ( html ) {
					$( '#subcommittee' ).html( html );


				}
			} );
		} else {
			$( '#subcommittee' ).html( '<option value="">เลือก</option>' );
		}
		
		$( '#committee' ).on( 'change', function () {
			var committee_id = $( this ).val();
			console.log( committee_id );
			if ( committee_id ) {
				$.ajax( {
					type: 'POST',
					url: 'menu/agenda/ajaxaddagenda.php',
					data: 'committee_id=' + committee_id,
					success: function ( html ) {
						$( '#subcommittee' ).html( html );


					}
				} );
			} else {
				$( '#subcommittee' ).html( '<option value="">Select country first</option>' );
			}
		} );


	} );
</script>
<?php

if ( isset( $_GET[ "a" ] ) && !empty( trim( $_GET[ "a" ] ) ) ) {

	// Prepare a select statement
	$sql = "SELECT agenda.agenda_id, agenda.agenda_subject,  DATE_FORMAT(meeting_day,'%d/%m/%Y') as md,TIME_FORMAT(start_time, '%H:%i') as st,	meeting_day,
TIME_FORMAT(end_time, '%H:%i') as et, round, agenda.committee_id, agenda.subcommittee_id, committee.committee_name, subcommittee.subcommittee_name
	FROM agenda 
	left join committee on committee.committee_id = agenda.committee_id    
    left join subcommittee on subcommittee.subcommittee_id = agenda.subcommittee_id
	WHERE agenda_id = " . $_GET[ 'a' ];

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

	$fsubject = $_POST[ "subject" ];
	$fagenda_id = $_POST[ "agenda_id" ];
	$fround = $_POST[ "round" ];
	$fcommittee_id = $_POST[ "committee" ];
	$fsubcommittee_id = $_POST[ "subcommittee" ];
	$fmeeting_day = $_POST[ "meeting_day" ];


	$fst1 = trim( $_POST[ "t11" ] . ":" . $_POST[ "t12" ] . ":00" );
	$fst2 = str_replace( ' ', '', $fst1 );
	$fet1 = $_POST[ "t21" ] . ":" . $_POST[ "t22" ] . ":00";
	$fet2 = str_replace( ' ', '', $fet1 );

	$fstart_time = $fmeeting_day . " " . $fst2;
	$fend_time = $fmeeting_day . " " . $fet2;


	// Prepare a select statement
	$sql = "UPDATE agenda SET agenda_subject= '$fsubject', round = '$fround', committee_id = $fcommittee_id, subcommittee_id = $fsubcommittee_id, meeting_day = '$fmeeting_day', start_time = '$fstart_time', end_time = '$fend_time' WHERE agenda_id =  $fagenda_id";
	if ( mysqli_query( $conn, $sql ) ) {

		echo "<script>window.location.href = 'home.php?menu=agenda&sub=editagenda&a=$agenda_id';</script>";

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
							<li class="breadcrumb-item" aria-current="page">
								<a href="home.php?menu=agenda&sub=read&a=<?php echo $agenda_id;?>">
									<?php echo $agenda_subject . " ครั้งที่ " . $round; ?>
								</a>
							</li>
							<li class="breadcrumb-item active" aria-current="page">
								แก้ไขการประชุม
							</li>

						</ol>
					</nav>


				</div>
				<h2></h2>
				<form action="" method="post">

					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<label class='input-group-text' for='subject'>หัวข้อการประชุม</label>
						</div>
						<input type="hidden" name="agenda_id" value="<?php echo $agenda_id;?>">
						<input type="text" name="subject" class="form-control" value="<?php echo $agenda_subject;?>">
					</div>


					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<label class='input-group-text' for='round'>ครั้งที่</label>
						</div>
						<input type="text" name="round" value="<?php echo $round; ?>">

					</div>



					<div class='input-group mb-3'>
						<div class='input-group-prepend'>
							<label class='input-group-text' for='committee'>กรรมการ</label>
						</div>
						<select class='custom-select' id='committee' name='committee'>
							<option>เลือก</option>
							<?php
							$sql = "SELECT * FROM committee";
							$result = $conn->query( $sql );
							while ( $row = $result->fetch_assoc() ) {
								$cid = $row["committee_id"];
								$cname = $row["committee_name"];
								?>
							<option value="<?php echo $cid; ?>" <?php if( $cid==1 ) echo "selected";?>>
								<?php echo $cname; ?>
							</option>

							<?php
							}
							?>
						</select>
					</div>
					<div id="me"></div>
					<div class='input-group mb-3'>
						<div class='input-group-prepend'>
							<label class='input-group-text' for='committee'>อนุกรรมการ</label>
						</div>
						<select class='custom-select' id="subcommittee" name="subcommittee">
							<option value="">เลือก</option>
						</select>
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


					<input type="hidden" id="subcm" value="34">



					<button type="submit" class="btn btn-success">บันทึก</button>
				</form>
			</div>
		</div>
	</div>
</div>