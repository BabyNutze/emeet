<?php
// Check existence of id parameter before processing further
if ( isset( $_GET[ "a" ] ) && !empty( trim( $_GET[ "a" ] ) ) ) {

	$thai_day_arr = array( "อาทิตย์", "จันทร์", "อังคาร", "พุธ", "พฤหัสบดี", "ศุกร์", "เสาร์" );
	$thai_month_arr = array(
		"0" => "",
		"1" => "มกราคม",
		"2" => "กุมภาพันธ์",
		"3" => "มีนาคม",
		"4" => "เมษายน",
		"5" => "พฤษภาคม",
		"6" => "มิถุนายน",
		"7" => "กรกฎาคม",
		"8" => "สิงหาคม",
		"9" => "กันยายน",
		"10" => "ตุลาคม",
		"11" => "พฤศจิกายน",
		"12" => "ธันวาคม"
	);

	function thai_date( $time ) {
		global $thai_day_arr, $thai_month_arr;
		$thai_date_return = "วัน" . $thai_day_arr[ date( "w", $time ) ];
		$thai_date_return .= "ที่ " . date( "j", $time );
		$thai_date_return .= " " . $thai_month_arr[ date( "n", $time ) ];
		$thai_date_return .= " พ.ศ." . ( date( "Yํ", $time ) + 543 );
		$thai_date_return .= "  " . date( "H:i", $time ) . " น.";
		return $thai_date_return;
	}

	$eng_date = time(); // แสดงวันที่ปัจจุบัน

	// Prepare a select statement
	$sql = "SELECT *  , date_format(DATE_ADD(meeting_day, INTERVAL 543 year),'%d/%m/%Y') as thaidate,
	DATE_FORMAT(meeting_day,'%d/%m/%Y') as md,TIME_FORMAT(start_time, '%H:%i') as st,TIME_FORMAT(end_time, '%H:%i') as et FROM agenda WHERE agenda_id = " . $_GET[ 'a' ];

	if ( $result = mysqli_query( $conn, $sql ) ) {
		if ( mysqli_num_rows( $result ) == 1 ) {
			/* Fetch result row as an associative array. Since the result set
			contains only one row, we don't need to use while loop */
			$row = mysqli_fetch_array( $result, MYSQLI_ASSOC );

			// Retrieve individual field value
			$agenda_id = $row[ "agenda_id" ];
			$agenda_topic = $row[ "agenda_subject" ];
			$round = $row[ "round" ];
			$thaidate = $row[ "thaidate" ];
			$st = $row[ "st" ];
			$et = $row[ "et" ];
			$md = $row[ "md" ];




		} else {
			// URL doesn't contain valid id parameter. Redirect to error page
			//header( "location: error.php" );
			//exit();
		}

	} else {
		echo "Oops! Something went wrong. Please try again later.";
	}
}


?>

<div class="wrapper">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">

				<br>
				<h5 class="text-center"><span></span>ระเบียบวาระการประชุม<?php echo $agenda_topic . " ครั้งที่ " . $round; ?></h5>
				<h5 class="text-center"><span></span><?php echo "ครั้งที่ " . $round; ?></h5>

				<h5 class="text-center"><span>วันที่</span> <?php echo $thaidate. " เวลา " . $st . "-" . $et ; ?> น.</h5>
				<hr>
				<br>

				<?php

				$sql = "SELECT term.tid, term.term_no, term.term_subject, term.term_detail FROM term 
						where term.agenda_id = $agenda_id order by term.term_id asc";
				if ( $result = mysqli_query( $conn, $sql ) ) {
					if ( mysqli_num_rows( $result ) > 0 ) {
						while ( $row = mysqli_fetch_array( $result ) ) {
							$primaryterm = $row[ "tid" ];
							$tid = $row["tid"];
							$term_detail = $row[ "term_detail" ];
							$term_no = $row["term_no"];
							
							?>
				<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
					<a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-<?php echo $tid; ?>" role="tab" aria-controls="v-pills-<?php echo $tid; ?>" aria-selected="true"><?php echo $term_no; ?></a>
					
				</div>
				<div class="tab-content" id="v-pills-tabContent">
					<div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">...</div>
					<div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">...</div>
					<div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">...</div>
					<div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">...</div>
				</div>

				<?php } ?>

				<?php } else { echo "ไม่มีวาระการประชุม"; } } else { echo "ERROR: Could not able to execute $sql. " . mysqli_error( $conn ); } // Close connection mysqli_close( $conn ); ?>
			</div>
		</div>
	</div>
</div>