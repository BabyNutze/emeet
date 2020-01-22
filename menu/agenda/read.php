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
				<div class="page-header">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="home.php" class="btn btn-outline-danger">หน้าแรก</a>
							</li>
							<li class="breadcrumb-item"><a href="home.php?menu=agenda" class="btn btn-outline-danger">งานประชุม</a></li>			
							<li class="breadcrumb-item active" aria-current="page">
								<button type="button" class="btn btn-danger" disabled><?php echo $agenda_topic . " ครั้งที่ " . $round; ?></button>
							</li>
						</ol>
					</nav>
				</div>

				<h5 class="text-center"><?php echo $agenda_topic . " ครั้งที่ " . $round; ?></h5>
				<div class="float-right">
					<a href="home.php?menu=agenda&sub=newterm&a=<?php echo $agenda_id; ?>" class="btn btn-primary" role="button" aria-disabled="true">เพิ่มวาระ</a>					
					<a href="home.php?menu=agenda&sub=viewagenda&a=<?php echo $agenda_id; ?>" class="btn btn-primary" role="button" aria-disabled="true">รายงานการประชุม</a>
				</div>

				<h5 class="text-center"><span>วันที่</span> <?php echo $thaidate. " เวลา " . $st . "-" . $et ; ?> น.</h5>

				<br>
				<table class="table table-dark table-striped">
					<thead>
						<tr>
							<th width="10%"></th>
							<th></th>
							<th width=""></th>
						</tr>
					</thead>
					<tbody>
						<?php
						$sql = "SELECT term.tid, term.term_no, term.term_subject, term.term_detail FROM term 
						where term.agenda_id = $agenda_id order by term.term_id asc";
						if ( $result = mysqli_query( $conn, $sql ) ) {
							if ( mysqli_num_rows( $result ) > 0 ) {
								while ( $row = mysqli_fetch_array( $result ) ) {
									$primaryterm = $row[ "tid" ];
									$term_detail = $row[ "term_detail" ];
									?>
						<tr>
							<td><a href="home.php?menu=agenda&sub=viewterm&a=<?php echo $agenda_id; ?>&t=<?php echo $row[ 'tid' ]; ?> " class="btn btn-success"><b><?php echo $row['term_no']; ?></b></a>
							</td>
							<td><a href="home.php?menu=agenda&sub=termdetail&a=<?php echo $agenda_id; ?>&t=<?php echo $row[ 'tid' ]; ?> "></a>
							<a href="home.php?menu=agenda&sub=viewterm&a=<?php echo $agenda_id; ?>&t=<?php echo $row[ 'tid' ]; ?> " class="btn btn-primary">	<b>
									<?php echo $row[ 'term_subject' ]; ?>
								</b></a>
								<br>
								<?php 
									$sql2 = "SELECT * FROM subterm where tid = $primaryterm and agenda_id = $agenda_id";
									$result2 = mysqli_query($conn, $sql2);

									if (@mysqli_num_rows($result2) > 0) {
    								while($row2 = mysqli_fetch_assoc($result2)) {
							
									echo "<p><a href='home.php?menu=agenda&sub=subtermdetail&a=$agenda_id&t=$row2[tid]&st=$row2[stid]' class='btn btn-info btn-sm'>" . $row2["subterm_no"] . " " . $row2["subterm_subject"] . "</a>";							
									echo "&nbsp; <a href='home.php?menu=agenda&sub=deletesubterm&a=$agenda_id&t=$row2[tid]&st=$row2[stid]' title='ลบวาระย่อย' data-toggle='tooltip' class='float-right'><span><i class='fas fa-trash'></i></span></a> ";
									echo " <a href='home.php?menu=agenda&sub=editsubtermdetail&a=$agenda_id&t=$row2[tid]&st=$row2[stid]' title='แก้ไขวาระย่อย' data-toggle='tooltip' class='float-right'><span><i class='fas fa-pen'></i></span></a>&nbsp;&nbsp;";											
										echo "</p>"; 									

    								}
									} else {
										
									if($term_detail != ""){														
										//echo $term_detail;
										
										$new_content = strip_tags($term_detail);
										$content = iconv_substr($new_content,0,100,'UTF-8');
										echo $content . "...";
										}else{
								
										}

									}

									
									?>
							</td>
							<td><a href="home.php?menu=agenda&sub=viewterm&a=<?php echo $agenda_id; ?>&t=<?php echo $row[ 'tid' ]; ?> " title='รายละเอียด' data-toggle='tooltip'><span><i class='fas fa-eye fa-2x'></i></span></a>
								<a href="home.php?menu=agenda&sub=addsubterm&a=<?php echo $agenda_id; ?>&t=<?php echo $row[ 'tid' ]; ?> " title='เพิ่มวาระย่อย' data-toggle='tooltip'><span><i class='fas fa-plus fa-2x'></i></span></a>
								<a href="home.php?menu=agenda&sub=edittermdetail&a=<?php echo $agenda_id; ?>&t=<?php echo $row[ 'tid' ]; ?>" title='แก้ไข' data-toggle='tooltip'><span><i class='fas fa-edit fa-2x'></i></span></a>								
								<a href="home.php?menu=agenda&sub=deleteterm&a=<?php echo $agenda_id; ?>&t=<?php echo $row[ 'tid' ]; ?>" title='ลบวาระ' data-toggle='tooltip'><span><i class='fas fa-trash fa-2x'></i></span></a>

							</td>
						</tr>
						<?php } ?>
				</table>
				<?php } else { echo "ไม่มีวาระการประชุม"; } } else { echo "ERROR: Could not able to execute $sql. " . mysqli_error( $conn ); } // Close connection mysqli_close( $conn ); ?>
			</div>
		</div>
	</div>
</div>