<?php
// Check existence of id parameter before processing further
if ( isset( $_GET[ "ag" ] ) && !empty( trim( $_GET[ "ag" ] ) ) ) {

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
	DATE_FORMAT(meeting_day,'%d/%m/%Y') as md,TIME_FORMAT(start_time, '%H:%i') as st,TIME_FORMAT(end_time, '%H:%i') as et FROM agenda WHERE agenda_id = " . $_GET[ 'ag' ];

	if ( $result = mysqli_query( $conn, $sql ) ) {
		if ( mysqli_num_rows( $result ) == 1 ) {
			/* Fetch result row as an associative array. Since the result set
			contains only one row, we don't need to use while loop */
			$row = mysqli_fetch_array( $result, MYSQLI_ASSOC );

			// Retrieve individual field value
			$agenda_id = $row[ "agenda_id" ];
			$agenda_topic = $row[ "agenda_subject" ];
			$thaidate = $row[ "thaidate" ];
			$st = $row[ "st" ];
			$et = $row[ "et" ];
			$md = $row[ "md" ];
			//echo thai_date( $md );
			echo strtotime( $md );


		} else {
			// URL doesn't contain valid id parameter. Redirect to error page
			header( "location: error.php" );
			exit();
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
				<div class="page-header">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="home.php">หน้าแรก</a>
							</li>
							<li class="breadcrumb-item"><a href="home.php?menu=agenda">งานประชุม</a>
							</li>
							<li class="breadcrumb-item active" aria-current="page">
								<?php echo $agenda_topic . " วันที่ " . $thaidate. " เวลา " . $st . "-" . $et ; ?>
							</li>
						</ol>
					</nav>
				</div>

				<h5><span></span> <?php echo $agenda_topic; ?></h5>
				<div class="float-right">
					<a href="home.php?menu=agenda&sub=addterm&ag=<?php echo $agenda_id; ?>" class="btn btn-primary" role="button" aria-disabled="true">เพิ่มวาระ</a>
				</div>

				<h5><span>วันที่</span> <?php echo $thaidate. " เวลา " . $st . "-" . $et ; ?> น.</h5>

				<br>
				<table class="table table-dark table-striped">
					<thead>
						<tr>
							<th width="10%">ระเบียบวาระที่</th>
							<th>เรื่อง</th>
							<th width="10%"></th>
						</tr>
					</thead>
					<tbody>
						<?php
						$sql = "SELECT * FROM term where agenda_id = $agenda_id";
						if ( $result = mysqli_query( $conn, $sql ) ) {
							if ( mysqli_num_rows( $result ) > 0 ) {
								while ( $row = mysqli_fetch_array( $result ) ) {
									?>
						<tr>
							<td><a href="home.php?menu=agenda&sub=addsubterm&ag=<?php echo $agenda_id; ?>&t=<?php echo $row[ 'term_id' ]; ?> "></a>
							</td>
							<td><a href="home.php?menu=agenda&sub=termdetail&ag=<?php echo $agenda_id; ?>&t=<?php echo $row[ 'term_id' ]; ?> "></a>
								<?php echo $row[ 'term_subject' ]; ?> <br>
								<?php echo $row[ 'term_detail' ]; ?>
							</td>
							<td><a href="home.php?menu=agenda&sub=termdetail&ag=<?php echo $agenda_id; ?>&t=<?php echo $row[ 'term_id' ]; ?> "title='รายละเอียด' data-toggle='tooltip'><span><i class='fas fa-eye fa-2x'></i></span></a>
								<a href="home.php?menu=agenda&sub=edittermdetail&ag=<?php echo $agenda_id; ?>&t=<?php echo $row[ 'term_id' ]; ?>"  title='แก้ไข' data-toggle='tooltip'><span><i class='fas fa-edit fa-2x'></i></span></a>

							</td></tr>
						<?php } ?>
				</table>
				<?php } else { echo "ไม่มีวาระการประชุม"; } } else { echo "ERROR: Could not able to execute $sql. " . mysqli_error( $conn ); } // Close connection mysqli_close( $conn ); ?>
			</div>
		</div>
	</div>
</div>