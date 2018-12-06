<?php
date_default_timezone_set( "Asia/Bangkok" );
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
	$agenda_subject = $_POST[ 'subject' ];
	$committee_id = $_POST[ 'committee_id' ];
	$subcommittee_id = $_POST[ 'subcommittee' ];
	$meeting_day = $_POST[ 'meeting_day' ];
	$round = $_POST[ "round" ];

	$st1 = trim( $_POST[ "t11" ] . ":" . $_POST[ "t12" ] . ":00" );
	$st2 = str_replace( ' ', '', $st1 );
	$et1 = $_POST[ "t21" ] . ":" . $_POST[ "t22" ] . ":00";
	$et2 = str_replace( ' ', '', $et1 );

	$start_time = $meeting_day . " " . $st2;
	$end_time = $meeting_day . " " . $et2;



	$sql = "INSERT agenda (agenda_id, agenda_subject,  committee_id, subcommittee_id, meeting_day, start_time, end_time,round ) 
		VALUES ($agenda_id," . "'$agenda_subject'" . ", $committee_id, $subcommittee_id," . "'$meeting_day'" . ",'$start_time'" . ",'$end_time'" . " , '$round')";

	if ( mysqli_query( $conn, $sql ) ) {
		echo "เพิ่มข้อมูลแล้ว<br>";

		$sql = "SELECT MAX(tid) AS tid FROM term";
		$result = mysqli_query( $conn, $sql );
		if ( $result->num_rows > 0 ) {
			// output data of each row
			if ( $row = $result->fetch_assoc() ) {
				$tid = $row[ "tid" ] + 1;
			}
		} else {
			$tid = 1;
		}
		$sql = "INSERT term (tid, term_id, agenda_id, term_no, term_subject) 
		VALUES ( $tid , 1 , $agenda_id, 'ระเบียบวาระที่ 1', 'เรื่องประธานและคณะอนุกรรมการแจ้งให้ที่ประชุมทราบ')";
		$query = mysqli_query( $conn, $sql );
		if ( $conn->query( $sql ) === TRUE ) {
			echo "เพิ่มวาระที่ 1 แล้ว" . "<br>";
		} else {
			//echo "Error: " . $sql . "<br>" . $conn->error;
		}



		$sql = "SELECT MAX(tid) AS tid FROM term";
		$result = mysqli_query( $conn, $sql );
		if ( $result->num_rows > 0 ) {
			// output data of each row
			if ( $row = $result->fetch_assoc() ) {
				$tid = $row[ "tid" ] + 1;
			}
		} else {
			$tid = 1;
		}
		$sql = "INSERT term (tid, term_id, agenda_id, term_no, term_subject) 
		VALUES ( $tid , 2 , $agenda_id, 'ระเบียบวาระที่ 2', 'เรื่องรับรองรายงานการประชุม')";

		$query = mysqli_query( $conn, $sql );
		if ( $conn->query( $sql ) === TRUE ) {
			echo "เพิ่มวาระที่ 2 แล้ว" . "<br>";
		} else {
			//echo "Error: " . $sql . "<br>" . $conn->error;
		}



		$sql = "SELECT MAX(tid) AS tid FROM term";
		$result = mysqli_query( $conn, $sql );
		if ( $result->num_rows > 0 ) {
			// output data of each row
			if ( $row = $result->fetch_assoc() ) {
				$tid = $row[ "tid" ] + 1;
			}
		} else {
			$tid = 1;
		}
		$sql = "INSERT term (tid, term_id, agenda_id, term_no, term_subject) 
		VALUES ( $tid , 3 , $agenda_id, 'ระเบียบวาระที่ 3', 'เรื่องสืบเนื่อง')";

		$query = mysqli_query( $conn, $sql );
		if ( $conn->query( $sql ) === TRUE ) {
			echo "เพิ่มวาระที่ 3 แล้ว" . "<br>";
		} else {
			//echo "Error: " . $sql . "<br>" . $conn->error;
		}



		$sql = "SELECT MAX(tid) AS tid FROM term";
		$result = mysqli_query( $conn, $sql );
		if ( $result->num_rows > 0 ) {
			// output data of each row
			if ( $row = $result->fetch_assoc() ) {
				$tid = $row[ "tid" ] + 1;
			}
		} else {
			$tid = 1;
		}
		$sql = "INSERT term (tid, term_id, agenda_id, term_no, term_subject) 
		VALUES ( $tid , 4 , $agenda_id, 'ระเบียบวาระที่ 4', 'เรื่องเพื่อพิจารณา')";

		$query = mysqli_query( $conn, $sql );
		if ( $conn->query( $sql ) === TRUE ) {
			echo "เพิ่มวาระที่ 4 แล้ว" . "<br>";
		} else {
			//echo "Error: " . $sql . "<br>" . $conn->error;
		}



		$sql = "SELECT MAX(tid) AS tid FROM term";
		$result = mysqli_query( $conn, $sql );
		if ( $result->num_rows > 0 ) {
			// output data of each row
			if ( $row = $result->fetch_assoc() ) {
				$tid = $row[ "tid" ] + 1;
			}
		} else {
			$tid = 1;
		}
		$sql = "INSERT term (tid, term_id, agenda_id, term_no, term_subject) 
		VALUES ( $tid , 5 , $agenda_id, 'ระเบียบวาระที่ 5', 'เรื่องเพื่อทราบ')";

		$query = mysqli_query( $conn, $sql );
		if ( $conn->query( $sql ) === TRUE ) {
			echo "เพิ่มวาระที่ 5 แล้ว" . "<br>";
		} else {
			//echo "Error: " . $sql . "<br>" . $conn->error;
		}



		$sql = "SELECT MAX(tid) AS tid FROM term";
		$result = mysqli_query( $conn, $sql );
		if ( $result->num_rows > 0 ) {
			// output data of each row
			if ( $row = $result->fetch_assoc() ) {
				$tid = $row[ "tid" ] + 1;
			}
		} else {
			$tid = 1;
		}
		$sql = "INSERT term (tid, term_id, agenda_id, term_no, term_subject) 
		VALUES ( $tid , 6 , $agenda_id, 'ระเบียบวาระที่ 6', 'เรื่องอื่น ๆ (ถ้ามี)')";

		$query = mysqli_query( $conn, $sql );
		if ( $conn->query( $sql ) === TRUE ) {
			echo "เพิ่มวาระที่ 6 แล้ว" . "<br>";
		} else {
			//echo "Error: " . $sql . "<br>" . $conn->error;
		}

		//echo "<script>window.location='home.php?menu=agenda'</script>";
		echo "บันทึกการประชุมแล้ว";

	} else {
		echo "Error: " . $sql . "<br>" . mysqli_error( $conn );
		//header( "location: home.php?menu=agenda" );
	}
	mysqli_close( $conn );

}
?>